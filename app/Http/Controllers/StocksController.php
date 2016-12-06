<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;

use App\Http\Requests;

class StocksController extends Controller
{
    public function refill($product_id, $quantity)
    {
        if (!Product::find($product_id)) {
            return response('404: Not found', 404);
        };

        $stock = Stock::firstOrNew(['product_id' => $product_id]);
        $stock->quantity += abs($quantity);
        $stock->save();

        return \Response::json(array(
            'product_id' => $stock->product_id,
            'quantity' => $stock->quantity,
            'errors' => false,
        ),
            200
        );
    }

    public function remove($product_id, $quantity)
    {
        $stock = Stock::find(['product_id' => $product_id])->first();

        if (empty($stock)) {
            return response("404: Stock for product not found: $product_id", 404);
        };

        $finalQuantity = abs($quantity);

        if ($stock->quantity >= $finalQuantity) {
            $stock->quantity -= $finalQuantity;

            $stock->save();

            return \Response::json(array(
                'product_id' => $stock->product_id,
                'quantity' => $stock->quantity,
                'errors' => false,
            ),
                200
            );
        } else {
            return response('400: Bad request', 400);
        }

    }
}
