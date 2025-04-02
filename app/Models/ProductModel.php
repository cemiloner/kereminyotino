<?php
namespace App\Models;

use RedBeanPHP\R as R;

class ProductModel
{
    public static function all()
    {
        // Tüm products tablosunu getir
        return R::findAll('products');
    }

    public static function create($data)
    {
        // $data = ['name' => 'Pasta', 'stock' => 10, ... ]
        $product = R::dispense('products');
        $product->name = isset($data['name']) ? $data['name'] : 'Unknown';
        $product->stock = isset($data['stock']) ? $data['stock'] : 0;
        // vs...
        $id = R::store($product);
        return $id;
    }

    // vs. update, delete gibi metotlar ekleyebilirsin
}
