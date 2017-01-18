<?php

namespace App\Http\Controllers;

use App\Product;
use App\Stock;
use League\Flysystem\Exception;

class StocksController extends Controller
{

    const DECIMALS = 2;

    public function index() {
        $stocks = Stock::all();
        return \Response::json($stocks);
    }

    public function refill($product_id, $quantity, $stock_id = null)
    {
        $product = Product::find($product_id);

        if (empty($product)) {
            return response("404: Product not found: $product_id", 404);
        }

        if (!empty($stockId)) {
            try {
                $stock = Stock::find($stock_id);
            } catch (Exception $e) {
                return response("404: Stock not found: $stock_id", 404);
            }
        } else {

            if (strtoupper(\Request::get('mode')) == 'CREATE') {
                $stock = new Stock;
                $stock->product_id = $product_id;

                $provider_id = \Request::get('provider_id');
                if (!empty($provider_id)) {
                    if (Provider::find($provider_id)) {
                        $stock->provider_id = $provider_id;
                    } else {
                        return response("404: Provider not found: $provider_id", 404);
                    }
                }

            } else {
                $stock = Stock::firstOrNew(['product_id' => $product_id]);
            }
        }

        $stock->quantity += abs($quantity);
        $stock->save();

        return \Response::json(array(
            'product_id' => $stock->product_id,
            'quantity' => number_format($product->stock, self::DECIMALS),
            'errors' => false,
        ),
            200
        );
    }

    public function remove($product_id, $quantity, $stock_id = null)
    {
        $product = Product::find($product_id);

        if (empty($product)) {
            return response("404: Product not found: $product_id", 404);
        }

        $available = $product->stock;

        if ($quantity > $available) {
            return response("400: Bad request: Quantity to remove ($quantity) greater than Available Quantity ($available)", 400);
        }

        $finalQuantity = $this->removeFromStock($product, $available, $quantity, $stock_id);

        return \Response::json(array(
            'product_id' => $product_id,
            'quantity' => number_format($finalQuantity, self::DECIMALS),
            'errors' => false,
        ),
            200
        );

    }

    public function removeFromStock($product, $available, $quantity, $stock_id = null)
    {
        $finalQuantity = $available - $quantity;

        $remainingQuantity = $quantity;

        if (!empty($stock_id)) {
            $stock = Stock::find($stock_id);

            if (!empty($stock)) {
                if ($stock->quantity >= $remainingQuantity) {
                    $stock->quantity -= $remainingQuantity;
                    $remainingQuantity = 0;
                } else {
                    $remainingQuantity -= $stock->quantity;
                    $stock->quantity = 0;
                }

                $stock->save();
            }
        }

        if ($remainingQuantity > 0) {
            $sortedStocks = array();

            foreach ($product->stocks as $stock) {
                $sortedStocks[] = $stock;
            }

            usort($sortedStocks, function ($a, $b) {
                return ($a['created_at'] < $b['created_at']) ? -1 : 1;
            });

            foreach ($sortedStocks as $stock) {
                if ($remainingQuantity > 0) {
                    if ($stock->quantity >= $remainingQuantity) {
                        $stock->quantity -= $remainingQuantity;
                        $remainingQuantity = 0;
                    } else {
                        $remainingQuantity -= $stock->quantity;
                        $stock->quantity = 0;
                    }
                    $stock->save();
                } else {
                    break;
                }
            }
        }

        return $finalQuantity;
    }

}
