<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function purchase(Request $request)
    {
        $statusCode = 200;
        $result = [];

        try {
            // トランザクションの開始
            DB::beginTransaction();

            // 商品特定
            $product = Product::where('id', $request->id)->first();

            if (!$product) {
                // 商品が見つからない場合のエラーハンドリング
                $statusCode = 404;
                $result['error'] = '商品が見つかりません。';
                return response()->json($result, $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
            }

            // 在庫判定
            if ($product->stock < $request->quantity) {
                // 在庫が不足している場合のエラーハンドリング
                $statusCode = 400;
                $result['error'] = '在庫が不足しています。';
                return response()->json($result, $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
            }

            // salesテーブルにレコードを追加する（在庫がある場合）
            Sale::create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);

            // productsテーブルの在庫数を減算する（在庫がある場合）
            $product->stock -= $request->quantity;
            $product->save();

            // トランザクションのコミット
            DB::commit();

            $result['message'] = '購入が完了しました。';
        } catch (\Exception $e) {
            // トランザクションのロールバック
            DB::rollBack();
            $statusCode = 500;
            $result['error'] = '購入処理中にエラーが発生しました。';
        }

        return response()->json($result, $statusCode, ['Content-Type' => 'application/json'], JSON_UNESCAPED_SLASHES);
    }
}