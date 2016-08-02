<?php

namespace App\Http\Controllers;

use App\Category;

use App\Http\Requests;

class CategoriesController extends Controller
{
    public function index() {
        $categories = Category::all();
        return \Response::json($categories);
    }

    public function find($id) {
        $category = Category::find($id);
        return \Response::json($category);
    }

    public function store() {
        if (\Request::has('id')) {
            $category = Category::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $category = new Category();
        }

        $category->name = \Request::get('name');
        $category->description = \Request::get('description');

        $category->save();

        return \Response::json(array(
                'id' => $category->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {
        Category::destroy($id);
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

    public function products($idCategory) {
        $category = Category::findOrFail($idCategory);
        if ($category !== NULL) {
            return \Response::json($category->products);
        } else {
            return \Response::json(array(
                'id' => $category->id,
                'errors' => true,
            ),
                404
            );
        }
    }
}
