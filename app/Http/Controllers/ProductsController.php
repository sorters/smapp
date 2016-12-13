<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Tag;

use Illuminate\Database\QueryException;

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

    public function getStock($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return response("404: Product not found: $id", 404);
        }

        $stock = $product->stock;
        $quantity = 0;

        if (!empty($stock)) {
            $quantity = $stock->quantity;
        }

        return \Response::json(array(
            'product_id' => $product->id,
            'quantity' => number_format($quantity, 2),
            'errors' => false,
        ),
            200
        );

    }

    public function tag($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return response("404: Product not found: $id", 404);
        }

        $tag = Tag::firstOrNew(['name' => strtolower(\Request::get('tag'))]);
        $tag->save();
        $tagId = $tag->id;
        $product->tags()->sync([$tagId], false);

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );

    }

    public function untag($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return response("404: Product not found: $id", 404);
        }

        $tagName = strtolower(\Request::get('tag'));
        $tag = Tag::where('name', $tagName)->first();

        if (empty($tag)) {
            return response("404: Tag not found: $tagName", 404);
        }

        $product->tags()->detach([$tag['id']], false);

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );

    }

    public function tags($idProduct)
    {
        $product = Product::find($idProduct);

        if (empty($product)) {
            return response("404: Product not found: $idProduct", 404);
        }

        $tags = array();

        foreach($product->tags as $tag) {
            $tags[] = array('id' => $tag->id, 'name' => $tag->name);
        };

        return \Response::json(array(
            'errors' => false,
            'tags' => $tags,
        ),
            200
        );

    }

}
