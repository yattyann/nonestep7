<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;

class ProductController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    // Product::query() は、Productモデルの新しいクエリビルダーインスタンスを作成します。このクエリビルダーを使用して、後で条件を追加
    // 新井さんが仰る『indexアクションで実装済みだと思う』は下記のことになるのか・・・？
    public function search(Request $request)
{
    $query = Product::query()->join('companies', 'companies.id', '=', 'products.id');

    // リクエストに keyword パラメータが含まれている場合、商品名にそのキーワードを含む商品を検索
    // 部分一致検索を行うために、like 演算子とワイルドカード (%) を使用
    if ($request->filled('keyword')) {
        $query->where('product_name', 'like', '%' . $request->keyword . '%');
    }

    // company_id がリクエストに含まれている場合、そのメーカーIDに一致する商品を検索
    if ($request->filled('company_id')) {
        $query->where('company_id', $request->company_id);
    }

    // min_price または max_price がリクエストに含まれている場合、その価格範囲内の商品を検索
    if ($request->filled('min_price')) {
        $query->where('price', '>=', $request->min_price);
    }

    if ($request->filled('max_price')) {
        $query->where('price', '<=', $request->max_price);
    }

    // min_stock または max_stock がリクエストに含まれている場合、その在庫範囲内の商品を検索 
    if ($request->filled('min_stock')) {
        $query->where('stock', '>=', $request->min_stock);
    }

    if ($request->filled('max_stock')) {
        $query->where('stock', '<=', $request->max_stock);
    }
    
    // 追加された条件に基づいてクエリを実行し、結果を取得
    $products = $query->get();

    // フィルタリングされた商品のリストをJSON形式で返す
    return response()->json(['products' => $products]);
}

// 新井さんが仰る『indexアクションで実装済みだと思う』は下記のことになるのか・・・？だとすれば重複している。。。？
    public function index(Request $request)
    {
        $query = Product::query();

        // キーワード、メーカーIDによるフィルタリング
        if ($request->has('keyword') && isset($request->company_id)) {
            $query->where('product_name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->has('company_id') && isset($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }

        // 価格の下限と上限によるフィルタリング
        if ($request->has('min_price') && isset($request->min_price)) {
            $intMinPrice = intval($request->input('min_price'));
            $query->where('price', '>=', $intMinPrice);
        }
        if ($request->has('max_price') && isset($request->max_price)) {
            $intMaxPrice = intval($request->input('max_price'));
            $query->where('price', '<=', $intMaxPrice);
        }

        // 在庫数の下限と上限によるフィルタリング
        if ($request->has('min_stock') && isset($request->min_stock)) {
            $intMinstock = intval($request->input('min_stock'));
            $query->where('stock', '>=', $intMinstock);
        }

        if ($request->has('max_stock') && isset($request->max_stock)) {
            $intMaxstock = intval($request->input('max_stock'));
            $query->where('stock', '<=', $intMaxstock);
        }

        $products = $query->get();

        $companies = Company::all();
        return view('products.index', compact('products', 'companies'));
    }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $companies=Company::all();
            return view('products.add', compact('companies'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */

        public function store(Request $request)
    {
        // バリデーションを実行
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ], [
            // バリデーションエラーメッセージを日本語にする
            'required' => ':attributeは必須項目です。',
            'string' => ':attributeは文字列を入力してください。',
            'max' => ':attributeは:max文字以内で入力してください。',
            'integer' => ':attributeは整数を入力してください。',
            'numeric' => ':attributeは数値を入力してください。',
            'min' => ':attributeは:min以上で入力してください。',
            'image' => '画像ファイルを選択してください。',
            'mimes' => '画像ファイルの形式は:valuesのみ有効です。',
        ]);    
    
        try {
            $product = new Product();
            $product->company_id = $request->get("company_id");
            $product->product_name = $request->get("product_name");
            $product->price = $request->get("price");
            $product->stock = $request->get("stock");
            $product->comment = $request->get("comment");

            if ($request->hasFile('img_path')) {
                $path = $request->file('img_path')->store('public/productimages');
                $product->img_path = basename($path);
            }

            $product->save();

            return redirect(route('products.index'))->with('success', '商品を追加しました。');
        } catch (\Exception $e) {
            // エラーが発生した場合の処理
            return redirect(route('products.index'))->with('error', '商品の追加中にエラーが発生しました。');
        }
    }

        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function show(Product $product)
        {
            return view('products.show',compact('product'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Product $product)
        {
            $companies=Company::all();
            return view('products.edit',compact('companies','product'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
        {
            // バリデーションを実行
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            // 他のフィールドのバリデーションルールを追加
        ]);

        // 更新対象の商品を取得
        $product = Product::findOrFail($id);

        // フォームから受け取ったデータで商品情報を更新
            $product->product_name = $request->input('product_name');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->company_id = $request->input('company_id');
            $product->comment = $request->input('comment');
            if($request->hasFile('img_path')) {
                $path=$request->file('img_path')->store('public/productimages');
                $product->img_path=basename($path);
            }
        // 他の更新するフィールドがあれば同様に追加

        // 商品情報を保存
            $product->save();

        // リダイレクトまたはレスポンスを返す
            return redirect()->route('products.edit',$product->id)->with('success', '商品情報を更新しました。');
        }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\JsonResponse
    */
    public function destroy($id)
    {
    // 指定されたIDに対応する商品を取得
    $product = Product::findOrFail($id);

    // 商品を削除
    $product->delete();

    // JSONレスポンスを返す
    return response()->json(['success' => '商品を削除しました。']);
    }
}
