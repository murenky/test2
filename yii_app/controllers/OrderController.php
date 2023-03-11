<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\Product2order;

class OrderController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'new'   => ['POST'],
            ],
        ];
        
        return $behaviors;
    }
    
    public function actionNew() {
        $transaction = Order::getDb()->beginTransaction();
        
        $order = new Order();
        $data = \Yii::$app->request->getBodyParams();
        
        $order->clientId = $data['clientId'];
        if (!$order->validate()) {
            $transaction->rollBack();
            return ['result' => 'client not found'];
        }
        $order->save();
        
        $productIds = $data['products'];
        if (!$productIds) {
            $transaction->rollBack();
            return ['result' => 'products are missing'];
        }
        
        foreach ($productIds as $id) {
            $p2o = new Product2order();
            $p2o->orderId = $order->id;
            $p2o->productId = $id;
            if (!$p2o->validate()) {
                $transaction->rollBack();
                return ['result' => "product $id not found"];
            }
            $p2o->save();
        }
        
        $transaction->commit();
        
        return ['result' => 'ok', 'order_id' => $order->id];
    }
}