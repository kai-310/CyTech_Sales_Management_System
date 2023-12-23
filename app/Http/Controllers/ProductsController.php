<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->product = new Product();
    }
    
    // 商品情報をテーブルに登録
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $this->product->register($request);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        // 商品の登録が成功した場合の処理（例えば、成功メッセージをフラッシュするなど）
        return redirect()->route('product.register')->with('success', '商品が登録されました。');
    }

    // 会社名取得
    public function productRegister()
    {
        $model = new Company();
        $companies = $model->getList();

        return view('product_register', compact('companies'));
    }

    // 削除機能
    public function destroy($product_id)
    {
        DB::beginTransaction();
        try{
        // 指定されたIDのレコードを削除
        $product_id = $this -> product->deletePuroductById($product_id);
        DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        return redirect()->route('home');
    }

    // 詳細画面表示
    public function show($product_id)
    {
        $this->products = new Product();//商品情報
        $products = $this->products->pickUpProduct($product_id);
        
        $product = Product::find($product_id);

        // dd($products);
        return view('show', compact('product','products'));
    }
    
    public function edit($product_id)
    {
        // 特定の商品情報を取得
        $product = Product::find($product_id);
        // 企業リストを取得
        $model = new Company();
        $companies = $model->getList();
        $company = Company::find($product->company_id);
        $product->save();

        return view('update_screen', compact('product', 'companies','company'));
    }

    public function update(Request $request,$product_id)
    {
        DB::beginTransaction();
        try{
            $this->product->updateRecord($request,$product_id);
            $product = Product::find($product_id);

            // 企業リストを取得
            $model = new Company();
            $companies = $model->getList();
            $company = Company::find($product->company_id);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        // dd($product);
        return view('update_screen', compact('product', 'companies','company'));
    }
    
}