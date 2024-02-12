<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Product;

class Product extends Model
{
    // モデルに関連付けるテーブル
    protected $table = 'products';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'id';

    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'company_id',
        'product_name', 
        'price', 
        'stock', 
        'comment',
        'img_path',
    ];


    public function getProduct()//テーブル結合元データ
    {
        return DB::table('products')

            ->select(
                        '*',
                        'products.id as product_id',
                        'companies.id as companies_id',
                    )
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->get();
    }

    public function getProductSearch($keyword, $smaker, $priceFloor, $priceCeiling, $stockFloor, $stockCeiling)
    {
        $query = DB::table('products')
        ->select(
            '*',
            'products.id as product_id',
            'companies.id as companies_id'
        )
        ->join('companies', 'products.company_id', '=', 'companies.id');

        if ($keyword !== null) {
            $query->where('product_name', 'like', '%' . $keyword . '%');
        }

        if ($smaker !== null) {
            $query->where('company_id', '=', $smaker);
        }

        if ($priceFloor !== null) {
            $query->where('price', '>=',$priceFloor);
        }

        if ($priceCeiling !== null) {
            $query->where('price', '<=',$priceCeiling);
        }

        if ($stockFloor !== null) {
            $query->where('stock', '>=',$stockFloor);
        }

        if ($stockCeiling !== null) {
            $query->where('stock', '<=',$stockCeiling);
        }
        return $query->get();
    }

    /**
     * リクエストされたIDをもとにbooksテーブルのレコードを1件取得
     */
    public function findPuroductById($product_id)
    {
        return Product::find($product_id);
    }

    public function pickUpProduct($product_id)//テーブル結合
    {
        return DB::table('products')
            ->select(
                        '*',
                        'products.id as product_id',
                        'companies.id as companies_id'
                    )
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->where('products.id','=',$product_id)
            ->first();
    }


    public function deletePuroductById($product_id)
    {
        return $this->destroy($product_id);
    }

    public function updateRecord($request, $product_id)
    {
        $product = Product::find($product_id);
    
        if ($product) {
            $product->company_id = $request->maker;
            $product->product_name = $request->name;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->comment = $request->comment;
    
            if ($request->hasFile('image')) {
                $product->img_path = $request->file('image')->store('products', 'public');
            }
    
            $product->save();
        }
    }
    
    public function register($request,$validatedData)
    {
        // リクエストデータから商品情報を取得
        $productData = [
            'product_name' => $validatedData['name'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'company_id' => $validatedData['maker'],
            'comment' => $request->input('comment'),
            'img_path' => $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null,
        ];
    
        // 商品の作成
        $product = Product::create($productData);
    }

    public function getSortedProduct($keyword, $smaker, $priceFloor, $priceCeiling, $stockFloor, $stockCeiling, $columnName, $direction)
    {
        $query = DB::table('products')
        ->select(
            'products.*',
            'products.id as product_id',
            'companies.id as companies_id',
            'companies.company_name'
        )
        ->join('companies', 'products.company_id', '=', 'companies.id');

            if ($keyword !== null) {
                $query->where('product_name', 'like', '%' . $keyword . '%');
            }
    
            if ($smaker !== null) {
                $query->where('company_id', '=', $smaker);
            }
    
            if ($priceFloor !== null) {
                $query->where('price', '>=',$priceFloor);
            }
    
            if ($priceCeiling !== null) {
                $query->where('price', '<=',$priceCeiling);
            }
    
            if ($stockFloor !== null) {
                $query->where('stock', '>=',$stockFloor);
            }
    
            if ($stockCeiling !== null) {
                $query->where('stock', '<=',$stockCeiling);
            }

            $query->orderBy($columnName, $direction);
            return $query->get();
            
    } 
    public function getSortedProductTest($column, $direction)
    {
        return DB::table('products')
            ->select(
                'products.*',
                'products.id as product_id',
                'companies.id as companies_id',
                'companies.company_name'
            )
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->orderBy($column, $direction)
            ->get();
    } 

}
