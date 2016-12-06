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

        if (empty($category)) {
            return response("404: Category not found: $id", 404);
        }

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

        try {
            $category->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $category->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {
        if (!Category::destroy($id)) {
            return response("404: Category not found: $id", 404);
        }
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

    public function products($idCategory) {
        $category = Category::findOrFail($idCategory);

        if (empty($category)) {
            return response("404: Category not found: $idCategory", 404);
        }

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
