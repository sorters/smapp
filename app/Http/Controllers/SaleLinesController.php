<?php

namespace App\Http\Controllers;

use App\SaleLine;
use App\SaleOrder;
use App\Product;

class SaleLinesController extends Controller
{

    public function find($id) {
        $saleLine = SaleLine::find($id);

        if (empty($saleLine)) {
            return response("404: Sale Line not found: $id", 404);
        }

        return \Response::json($saleLine);
    }

    public function store() {
        if (\Request::has('id')) {
            $saleLine = SaleLine::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $saleLine = new SaleLine();
        }

        $saleLine->sale_order_id = \Request::get('sale_order_id');
        $saleLine->product_id = \Request::get('product_id');
        $saleLine->unit_price = \Request::get('unit_price');
        $saleLine->units = \Request::get('units');

        try {
            $saleLine->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $saleLine->id,
                'errors' => false,
            ),
            200
        );
    }

    public function assign($lineId, $orderId) {

        $saleLine = SaleLine::find($lineId);

        if (empty($saleLine)) {
            return response("404: Sale Line not found: $lineId", 404);
        }

        $saleOrder = SaleOrder::find($orderId);

        if (empty($saleOrder)) {
            return response("404: Sale Order not found: $orderId", 404);
        }

        $saleLine->sale_order_id = $orderId;

        try {
            $saleLine->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );

    }


    public function acknowledge($id) {

        $saleLine = SaleLine::find($id);

        if (empty($saleLine)) {
            return response("404: Sale Line not found: $id", 404);
        }

        $product = Product::find($saleLine->product_id);

        if (empty($product)) {
            return response("404: Product not found: $saleLine->product_id", 404);
        }

        $quantity = $saleLine->units;
        $available = $product->stock;

        if ($quantity > $available) {
            return response("400: Bad request: Quantity to remove ($quantity) greater than Available Quantity ($available)", 400);
        }

        app('App\Http\Controllers\StocksController')->removeFromStock($product, $available, $quantity);

        $saleLine->state = false;

        try {
            $saleLine->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );

    }

    public function delete($id) {
        if (!SaleLine::destroy($id)) {
            return response("404: Sale Line not found: $id", 404);
        }
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

}
