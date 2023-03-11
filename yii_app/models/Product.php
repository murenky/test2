<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use Predis;

class Product extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            ['createDate', 'date'],
            [['name', 'description'], 'string'],
            ['price', 'double'],
        ];
    }
    
    public static function tableName()
    {
        return 'product';
    }
    
    /**
     * Возвращает продукт из кэша, если он там есть
     * @param int $id
     * @return Product|null
     */
    public static function checkCache(int $id): ?Product {
        $client = Yii::$app->redis;
        $cache = $client->get('product_'.$id);
        if (!$cache) {
            return null;
        }
        
        $data = json_decode($cache, true);
        
        $product = new Product();
        $product->id = $data['id'];
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->description = $data['description'];
        $product->createDate = $data['createDate'];
        
        return $product;
    }
    
    /**
     * Добавляет продукт в кэш
     */
    public function cache(): void
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'createDate' => $this->createDate
        ];
        
        $json = json_encode($data);
        $client = Yii::$app->redis;
        $client->set('product_'.$this->id, $json);
    }
}