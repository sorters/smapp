<?php

namespace App\Http\Controllers;

use App\Tag;

class TagsController extends Controller
{

    public function products($idTag) {

        $tag = Tag::find($idTag);

        if (empty($tag)) {
            return response("404: Tag not found: $idTag", 404);
        }

        $products = array();

        foreach($tag->products as $product) {
            $products[] = array(
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description
            );
        };

        return \Response::json(array(
            'errors' => false,
            'products' => $products,
        ),
            200
        );

    }
}
