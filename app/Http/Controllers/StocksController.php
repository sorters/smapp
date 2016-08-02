<?php

namespace App\Http\Controllers;

use App\Stock;

use App\Http\Requests;

class StocksController extends Controller
{
    public function refill($product_id, $quantity)
    {
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
            return \Response::json(array(
                'product_id' => $stock->product_id,
                'errors' => true,
            ),
                400
            );
        }

    }
}
