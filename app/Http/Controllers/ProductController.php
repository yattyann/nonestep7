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

    public function index(Request $request)
    {
        $keyword = $request->input('keyword'); // リクエストから検索キーワードを取得
        
        // 検索キーワードがある場合は、商品名にキーワードを含む商品を検索する
        if (!empty($keyword)) {
            $products = Product::where('product_name', 'like', '%' . $keyword . '%')->where('company_id',$request->get('company_id'))->get();
        } else {
            $products = Product::all();
        }
        
        $companies=Company::all();
        return view('products.index',compact('companies','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies=Company::all();
        return view('products.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|integer',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'comment' => 'nullable|string|max:1000',
            'img_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // バリデーションを通過したら、新しい商品を作成して保存するロジックを追加
    
        {
            $validatedData = $request->validate([
                // バリデーションルール
            ]);
        
            // バリデーションを通過したら、新しい商品を作成して保存するロジックを追加
        
            // バリデーションに失敗した場合は、フォームにリダイレクトしてエラーメッセージを表示
            return redirect()->back()->withErrors($validatedData)->withInput();
        }

        try{
        $product = new Product();
        $product->company_id = $request->get("company_id");
        $product->product_name = $request->get("product_name");
        $product->price = $request->get("price");
        $product->stock = $request->get("stock");
        $product->comment = $request->get("comment");

        if($request->hasFile('img_path')) {
            $path=$request->file('img_path')->store('public/productimages');
            $product->img_path=basename($path);
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
        return redirect()->route('products.index')->with('success', '商品情報を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    // 指定されたIDに対応する商品を取得
    $product = Product::findOrFail($id);

    // 商品を削除
    $product->delete();

    // リダイレクトまたはレスポンスを返す
    return redirect()->route('products.index')->with('success', '商品を削除しました。');
    }
}
