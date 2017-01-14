<?php

namespace App\Http\Controllers;

use App\SaleOrder;

class SaleOrdersController extends Controller
{
    public function index() {
        $saleOrders = SaleOrder::all();
        return \Response::json($saleOrders);
    }
/*
    public function find($id) {
        $purchaseOrder = PurchaseOrder::find($id);

        if (empty($purchaseOrder)) {
            return response("404: Purchase Order not found: $id", 404);
        }

        return \Response::json($purchaseOrder);
    }

    public function store() {
        if (\Request::has('id')) {
            $purchaseOrder = PurchaseOrder::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $purchaseOrder = new PurchaseOrder();
        }

        $purchaseOrder->comments = \Request::get('comments');

        try {
            $purchaseOrder->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $purchaseOrder->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {

        $purchaseOrder = PurchaseOrder::find($id);

        if (empty($purchaseOrder)) {
            return response("404: Purchase Order not found: $id", 404);
        }

        if ($purchaseOrder->state) {
            return response("400: Cannot delete Purchase Order $id: State is not Closed", 400);
        }

        PurchaseOrder::destroy($id);

        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

    public function open($id) {
        $purchaseOrder = PurchaseOrder::find($id);

        if (empty($purchaseOrder)) {
            return response("404: Purchase Order not found: $id", 404);
        }

        $purchaseOrder->state = true;
        $purchaseOrder->save();

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function close($id) {
        $purchaseOrder = PurchaseOrder::find($id);

        if (empty($purchaseOrder)) {
            return response("404: Purchase Order not found: $id", 404);
        }

        foreach($purchaseOrder->lines as $line) {
            if ($line->state) {
                return response("400: Purchase Order $id has open Purchase Line: $line->id", 400);
            }
        };

        $purchaseOrder->state = false;
        $purchaseOrder->save();

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function lines($id) {
        $purchaseOrder = PurchaseOrder::find($id);

        if (empty($purchaseOrder)) {
            return response("404: Purchase Order not found: $id", 404);
        }

        $lines = $purchaseOrder->lines;

        return \Response::json($lines);
    }
*/
}
