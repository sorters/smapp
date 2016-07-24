<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

use App\Http\Requests;

class CategoriesController extends Controller
{
    public function index() {
        $categories = Category::all();
        return \Response::json($categories);
    }

    public function store() {
        $category = new Category;
        $category->name = \Request::get('name');
        $category->description = \Request::get('description');
        \Log::info('About to save a category...');
        $category->save();
        \Log::info('Saved a category with id = '.$category->id);

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
}
