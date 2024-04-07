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
    public function index()
    {
        //イフ文書くところ！！！検索機能
        $products=Product::all();
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

            return redirect(route('products.index'));
        }catch(e) {
            return redirect(route('products.index'));
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
        //データを更新コードを記入
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //データを削除するコードを記入
    }
}
