<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductOffer;
use App\Trigger;

class TriggersController extends Controller
{
    public function index() {
        $triggers = Trigger::all();
        return \Response::json($triggers);
    }

    public function find($id) {
        $trigger = Trigger::find($id);

        if (empty($trigger)) {
            return response("404: Trigger not found: $id", 404);
        }

        return \Response::json($trigger);
    }

    public function store() {
        if (\Request::has('id')) {
            $trigger = Trigger::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $trigger = new Trigger();
        }

        $productId = \Request::get('product_id');
        $product = Product::find($productId);
        if (empty($product)) {
            return response("404: Product not found: $productId", 404);
        }

        $productOfferId = \Request::get('product_offer_id');
        $productOffer = ProductOffer::find($productOfferId);
        if (empty($productOffer)) {
            return response("404: Product Offer not found: $productOfferId", 404);
        }

        $trigger->product_id = $productId;
        $trigger->product_offer_id = $productOfferId;
        $trigger->threshold = \Request::get('threshold');
        $trigger->offset = \Request::get('offset');
        $trigger->fill = \Request::get('fill');
        $trigger->enabled = \Request::get('enabled');

        try {
            $trigger->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $trigger->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {
        if (!Trigger::destroy($id)) {
            return response("404: Trigger not found: $id", 404);
        }
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

    public function enable($id) {
        $trigger = Trigger::find($id);

        if (empty($trigger)) {
            return response("404: Trigger not found: $id", 404);
        }

        $trigger->enabled = true;
        $trigger->save();

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

    public function disable($id) {
        $trigger = Trigger::find($id);

        if (empty($trigger)) {
            return response("404: Trigger not found: $id", 404);
        }

        $trigger->enabled = false;
        $trigger->save();

        return \Response::json(array(
            'errors' => false,
        ),
            200
        );
    }

}
