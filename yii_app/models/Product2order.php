<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Product2order extends ActiveRecord
{   
    public function rules()
    {
        return [
            ['orderId', 'exist', 'targetClass' => Order::class, 'targetAttribute' => ['orderId' => 'id']],
            ['productId', 'exist', 'targetClass' => Product::class, 'targetAttribute' => ['productId' => 'id']],
        ];
    }
    
    public static function tableName()
    {
        return 'product2order';
    }
}