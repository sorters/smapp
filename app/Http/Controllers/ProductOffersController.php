<?php

namespace App\Http\Controllers;

use App\ProductOffer;
use App\Product;
use App\Provider;

class ProductOffersController extends Controller
{
    public function index() {
        $productOffers = ProductOffer::all();
        return \Response::json($productOffers);
    }

    public function find($id) {
        $productOffer = ProductOffer::find($id);

        if (empty($productOffer)) {
            return response("404: Product Offer not found: $id", 404);
        }

        return \Response::json($productOffer);
    }

    public function store() {
        if (\Request::has('id')) {
            $productOffer = ProductOffer::firstOrNew(['id' => \Request::get('id')]);
        } else {
            $productOffer = new ProductOffer();
        }

        $product = Product::find(\Request::get('product_id'));
        if (empty($product)) {
            return response("404: Product not found: $id", 404);
        }

        $provider = Provider::find(\Request::get('provider_id'));
        if (empty($provider)) {
            return response("404: Provider not found: $id", 404);
        }

        $productOffer->product_id = $product->id;
        $productOffer->provider_id = $provider->id;
        $productOffer->delivery = \Request::get('delivery');
        $productOffer->unit_price = \Request::get('unit_price');

        try {
            $productOffer->save();
        } catch (QueryException $e) {
            return response('400: Bad request', 400);
        }

        return \Response::json(array(
                'id' => $productOffer->id,
                'errors' => false,
            ),
            200
        );
    }

    public function delete($id) {
        if (!ProductOffer::destroy($id)) {
            return response("404: Product Offer not found: $id", 404);
        }
        return \Response::json(array(
                'errors' => false,
            ),
            200
        );
    }

}
