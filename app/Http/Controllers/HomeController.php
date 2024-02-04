<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Product;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->product = new Product();
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
        // $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home(Request $request)
    {
        $columnName = "id";
        $direction = "asc";

        $this->products = new Product();
        $products = $this->products->getSortedProduct($columnName, $direction);

        $model = new Company();
        $companies = $model->getList();

        return view('home', compact('companies', 'products', 'columnName', 'direction'));
    }
    /*public function home()
    {
        $this -> products = new Product();//商品情報
        $products = $this -> products -> getProduct();

        $model = new Company(); //企業リスト取得
        $companies = $model -> getList();
        //  dd($products);
        return view('home', compact('companies','products'));
    }*/

    public function index()
    {
        $products = Product::all(); 
        return view('home', compact('products'));
    }

    public function companyList()
    {
        $model = new Company();
        $companies = $model -> getList();
        return view('home', compact('companies'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            // 指定されたIDのレコードを削除
            $deletePuroduct = $this -> Product -> deletePuroductById($id);
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
        // 削除したら一覧画面にリダイレクト
        return redirect() -> route('home');
    }

    public function search(Request $searchRequest)
    {
        $keyword = $searchRequest->input('keyword');
        $smaker = $searchRequest->input('maker');
        $priceFloor = $searchRequest->input('price-floor');
        $priceCeiling = $searchRequest->input('price-ceiling');
        $stockFloor = $searchRequest->input('stock-floor');
        $stockCeiling = $searchRequest->input('stock-ceiling');
    
        $products = $this->product->getProductSearch($keyword, $smaker, $priceFloor, $priceCeiling, $stockFloor, $stockCeiling);
    
        return view('partials.product_table', compact('products'))->render();
    }

    public function sort(Request $sortRequest)
    {
        $columnName = $sortRequest->input('column');
        $direction = $sortRequest->input('direction');
         //dd($sortRequest);
         //dd($columnName);
        $products = $this->product->getSortedProduct($columnName, $direction);
        //dd($products);
        return view('partials.product_table', compact('products'))->render();
    }
}
