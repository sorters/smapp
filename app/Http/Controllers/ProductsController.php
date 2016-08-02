<?php

namespace App\Http\Controllers;

use App\Product;

use App\Http\Requests;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return \Response::json($products);
    }

    public function find($id)
    {
        $product = Product::find($id);
        return \Response::json($product);
    }

    public function store()
    {
        if (\Request::has('id')) {
            $product = Product::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $product = new Product();
        }

        $product->name = \Request::get('name');
        $product->category_id = \Request::get('category_id');
        $product->description = \Request::get('description');
        $product->buy_price = \Request::get('buy_price');
        $product->sell_price = \Request::get('sell_price');

        $product->save();

        return \Response::json(array(
            'id' => $product->id,
            'errors' => false,
        ),
            200
        );
    }

    public function delete($id)
    {
        Product::destroy($id);
        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function setCategory($idCategory) {
        $productIDs = explode(',', \Request::get('products'));

        \Log::info($productIDs);
        \Log::info('------reswgsgreg----------------------------sergerg----------------------------');

        foreach($productIDs as $id) {
            $product = Product::find($id);
            $product->category_id = $idCategory;
            $product->save();
        }

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }
}
