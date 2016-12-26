<?php

namespace App\Http\Controllers;

use App\PurchaseLine;
use App\PurchaseOrder;

class PurchaseLinesController extends Controller
{

    public function find($id) {
        $purchaseLine = PurchaseLine::find($id);

        if (empty($purchaseLine)) {
            return response("404: Purchase Line not found: $id", 404);
        }

        return \Response::json($purchaseLine);
    }

    public function store() {
        if (\Request::has('id')) {
            $purchaseLine = PurchaseLine::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $purchaseLine = new PurchaseLine();
        }

        $purchaseLine->purchase_order_id = \Request::get('purchase_order_id');
        $purchaseLine->product_id = \Request::get('product_id');
        $purchaseLine->provider_id = \Request::get('provider_id');
        $purchaseLine->unit_price = \Request::get('unit_price');
        $purchaseLine->units = \Request::get('units');

        try {
            $purchaseLine->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $purchaseLine->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {
        if (!PurchaseLine::destroy($id)) {
            return response("404: Purchase Line not found: $id", 404);
        }
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

}
