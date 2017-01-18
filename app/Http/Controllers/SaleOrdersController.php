<?php

namespace App\Http\Controllers;

use App\SaleOrder;

class SaleOrdersController extends Controller
{
    public function index() {
        $saleOrders = SaleOrder::all();
        return \Response::json($saleOrders);
    }

    public function find($id) {
        $saleOrder = SaleOrder::find($id);

        if (empty($saleOrder)) {
            return response("404: Sale Order not found: $id", 404);
        }

        return \Response::json($saleOrder);
    }

    public function store() {
        if (\Request::has('id')) {
            $saleOrder = SaleOrder::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $saleOrder = new SaleOrder();
        }

        $saleOrder->comments = \Request::get('comments');
        $saleOrder->customer_id = \Request::get('customer_id');

        try {
            $saleOrder->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
            'id' => $saleOrder->id,
            'errors' => false,
        ),
            200
        );
    }

    public function delete($id) {

        $saleOrder = SaleOrder::find($id);

        if (empty($saleOrder)) {
            return response("404: Sale Order not found: $id", 404);
        }

        if ($saleOrder->state) {
            return response("400: Cannot delete Sale Order $id: State is not Closed", 400);
        }

        SaleOrder::destroy($id);

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function open($id) {
        $saleOrder = SaleOrder::find($id);

        if (empty($saleOrder)) {
            return response("404: Sale Order not found: $id", 404);
        }

        $saleOrder->state = true;
        $saleOrder->save();

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function close($id) {
        $saleOrder = SaleOrder::find($id);

        if (empty($saleOrder)) {
            return response("404: Sale Order not found: $id", 404);
        }

        foreach($saleOrder->lines as $line) {
            if ($line->state) {
                return response("400: Sale Order $id has open Sale Line: $line->id", 400);
            }
        };

        $saleOrder->state = false;
        $saleOrder->save();

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function lines($id) {
        $saleOrder = SaleOrder::find($id);

        if (empty($saleOrder)) {
            return response("404: Sale Order not found: $id", 404);
        }

        $lines = $saleOrder->lines;

        return \Response::json($lines);
    }

}
