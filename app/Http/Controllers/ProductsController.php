<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;

use App\Http\Requests;
use Illuminate\Database\QueryException;
use Mockery\CountValidator\Exception;

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

        if (empty($product)) {
            return response("404: Product not found: $id", 404);
        }

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

        try {
            $product->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
            'id' => $product->id,
            'errors' => false,
        ),
            200
        );
    }

    public function delete($id)
    {
        if (!Product::destroy($id))
        {
            return response("404: Product not found: $id", 404);
        }
        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function setCategory($idCategory)
    {
        $productIDs = explode(',', \Request::get('products'));

        $category = Category::find($idCategory);
        if (empty($category)) {
            return response("404: Category not found: $idCategory", 404);
        }

        foreach ($productIDs as $id) {
            $product = Product::find($id);
            if (empty($product)) {
                return response("404: Product not found: $id", 404);
            }
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
