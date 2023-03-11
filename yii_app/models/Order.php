<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Order extends ActiveRecord
{
    public function rules()
    {
        return [
            ['createDate', 'date'],
            ['clientId', 'exist', 'targetClass' => Client::class, 'targetAttribute' => ['clientId' => 'id']],
        ];
    }
    
    public static function tableName()
    {
        return 'order';
    }
}