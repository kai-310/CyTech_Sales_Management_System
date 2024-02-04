<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        $productId = $request->input('product_id');

        // 商品が存在するか確認
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // 在庫があるか確認
        if ($product->stock <= 0) {
            return response()->json(['error' => 'Out of stock'], 400);
        }

        // 購入処理
        try {
            DB::beginTransaction();

            // Salesテーブルにレコードを追加
            $sale = new Sale();
            $sale->product_id = $productId;
            $sale->save();

            // Productsテーブルの在庫数を減算
            $product->stock -= 1;
            $product->save();

            DB::commit();

            return response()->json(['message' => 'Purchase successful'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to process the purchase'], 500);
        }
    }
}
