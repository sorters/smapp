<?php

namespace App\Http\Controllers;

use App\Provider;

class ProvidersController extends Controller
{
    public function index() {
        $providers = Provider::all();
        return \Response::json($providers);
    }

    public function find($id) {
        $provider = Provider::find($id);

        if (empty($provider)) {
            return response("404: Provider not found: $id", 404);
        }

        return \Response::json($provider);
    }

    public function store() {
        if (\Request::has('id')) {
            $provider = Provider::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $provider = new Provider();
        }

        $provider->name = \Request::get('name');
        $provider->description = \Request::get('description');

        try {
            $provider->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $provider->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {
        if (!Provider::destroy($id)) {
            return response("404: Provider not found: $id", 404);
        }
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

    public function lines($id) {
        $provider = Provider::find($id);

        if (empty($provider)) {
            return response("404: Provider not found: $id", 404);
        }

        $lines = $provider->lines;

        return \Response::json($lines);
    }

}
