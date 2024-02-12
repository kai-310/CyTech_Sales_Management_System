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

        $this->products = new Product();
    $products = $this->products->getProduct();

        $model = new Company();
        $companies = $model->getList();

        return view('home', compact('companies', 'products'));
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
        // dd($sortRequest);
        //検索
        $keyword = $sortRequest->input('keyword');
        $smaker = $sortRequest->input('maker');
        $priceFloor = $sortRequest->input('price-floor');
        $priceCeiling = $sortRequest->input('price-ceiling');
        $stockFloor = $sortRequest->input('stock-floor');
        $stockCeiling = $sortRequest->input('stock-ceiling');
        //ソート
        $columnName = $sortRequest->input('column');
        $direction = $sortRequest->input('direction');

        $products = $this->product->getSortedProduct($keyword, $smaker, $priceFloor, $priceCeiling, $stockFloor, $stockCeiling, $columnName, $direction);

        return view('partials.product_table', compact('products'))->render();
    }
}
