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
    public function home()
    {
        $this -> products = new Product();//商品情報
        $products = $this -> products -> getProduct();

        $model = new Company(); //企業リスト取得
        $companies = $model -> getList();
        //  dd($products);
        return view('home', compact('companies','products'));
    }

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
        // 指定されたIDのレコードを削除
        $deletePuroduct = $this -> Product -> deletePuroductById($id);
        // 削除したら一覧画面にリダイレクト
        return redirect() -> route('home');
    }

    public function search(Request $searchRequest)
    {
        // dd($searchRequest);
        $skeyword = $searchRequest -> input('keyword');
        $smaker = $searchRequest -> input('maker');
        // dd($skeyword);
        
        $this->products = new Product();
        $products = $this -> products -> getProductSearch($skeyword,$smaker);
        // dd($products);

        $model = new Company(); //企業リスト取得
        $companies = $model->getList();

        return view('home', compact('companies','products'));
    }
}
