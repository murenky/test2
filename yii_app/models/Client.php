<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Client extends ActiveRecord
{
    /*public $firstname;
    public $lastname;
    public $email;
    public $birthdate;*/
    
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'email'], 'required'],
            ['birthdate', 'date', 'format' => 'php:Y-m-d'],
            ['email', 'email'],
        ];
    }
    
    public static function tableName()
    {
        return 'client';
    }
    
    public function getOrderedProducts() {
        $products = Product::find()->select('product.*')
        ->innerJoin('product2order', 'product.id = product2order.productId')
        ->innerJoin('order', 'order.id = product2order.orderId')
        ->where(['order.clientId' => $this->id])
        ->all();
        
        return $products;
    }
}