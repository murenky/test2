<?php

namespace app\controllers;

use Yii;
use app\models\Product;

class ProductController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_JSON;
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'new'   => ['POST'],
            ],
        ];
        
        return $behaviors;
    }
    
    public function actionIndex($id)
    {
        $product = Product::checkCache($id);
        if (!$product) {
            $product = Product::findOne($id);
            if ($product) {
                $product->cache();
            }
        }
       
        if (!$product) {
            return ['result' => 'product not found'];
        }
        
        return $product;
    }
    
    public function actionNew() {
        $product = new Product();
        $data = \Yii::$app->request->getBodyParams();
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        
        if (!$product->validate()) {
            return ['result' =>  $product->getFirstErrors()];
        }
        
        $product->save();
        
        return ['result' => 'ok', 'product_id' => $product->id];
    }
}