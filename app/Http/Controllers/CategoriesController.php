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
        $category->save();

        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }
}
