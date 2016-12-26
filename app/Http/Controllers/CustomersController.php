<?php

namespace App\Http\Controllers;

use App\Customer;

class CustomersController extends Controller
{
    public function index() {
        $customers = Customer::all();
        return \Response::json($customers);
    }

    public function find($id) {
        $customer = Customer::find($id);

        if (empty($customer)) {
            return response("404: Customer not found: $id", 404);
        }

        return \Response::json($customer);
    }

    public function store() {
        if (\Request::has('id')) {
            $customer = Customer::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $customer = new Customer();
        }

        $customer->name = \Request::get('name');
        $customer->description = \Request::get('description');

        try {
            $customer->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $customer->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {
        if (!Customer::destroy($id)) {
            return response("404: Customer not found: $id", 404);
        }
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

}
