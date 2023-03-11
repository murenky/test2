<?php 
namespace app\controllers;

use Yii;
use app\models\Client;

class ClientController extends \yii\rest\Controller
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
                     'products' => ['GET'],
                 ],
             ];
        
        return $behaviors;
    }
    
    public function actionIndex($id)
    {
        $client = Client::findOne($id);
        
        if (!$client) {
            return ['result' => 'client not found'];
        }
        
        return $client;
    }
    
    public function actionNew() {
        $client = new Client();
        $data = \Yii::$app->request->getBodyParams();
        $client->firstname = $data['firstname'];
        $client->lastname = $data['lastname'];
        $client->email = $data['email'];
        $client->birthdate = $data['birthdate'];
        
        if (!$client->validate()) {
            return ['result' =>  $client->getFirstErrors()];
        }
        
        $client->save();
        
        return ['result' => 'ok', 'client_id' => $client->id];
    }
    
    public function actionOrdered($id) {
        /** @var Client $client */
        $client = Client::findOne($id);
        
        if (!$client) {
            return ['result' => 'client not found'];
        }
        
        return $client->getOrderedProducts();
    }
}

