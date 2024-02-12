@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>

    <div class="row justify-content-center">
        <form id="searchForm" enctype="multipart/form-data">
            @csrf
                <!-- 一段目 -->
                <div class="row mb-3">
                    <div class="col">
                        <input type="text" id="keyword" name="keyword" class="form-control" placeholder="検索キーワード">
                    </div>

                    <div class="col">
                        <select id="maker" name="maker" class="form-control">
                            <option value="">メーカー名</option>
                            @foreach($companies as $id => $company_name)
                            <option value="{{ $id }}">{{ $company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- 二段目 -->
                <div class="row mb-3">
                    <div class="col">
                        <input type="number" id="price-ceiling" name="price-ceiling" class="form-control" placeholder="価格上限">
                    </div>
                    <div class="col">
                        <input type="number" id="price-floor" name="price-floor" class="form-control" placeholder="価格下限">
                    </div>
                </div>

                <!-- 三段目 -->
                <div class="row mb-3">
                    <div class="col">
                        <input type="number" id="stock-ceiling" name="stock-ceiling" class="form-control" placeholder="在庫上限">
                    </div>
                    <div class="col">
                        <input type="number" id="stock-floor" name="stock-floor" class="form-control" placeholder="在庫下限">
                    </div>
                </div>

                <!-- ボタン -->
                <div class="row">
                    <div class="col">
                        <button  class="btn btn-primary btn-block" style="width: 100%;">検索 </button>
                    </div>
                </div>
        </form>
    </div>
    
    <!-- 以下、商品一覧テーブルのコード -->
    <table id="productTable" class="table table-bordered mt-4">
        <!-- テーブルヘッダー -->
        <thead>
            <tr>
                <th data-column="id" class="sort-column"><a href="#">ID</a></th>
                <th>商品画像</th>
                <th data-column="product_name" class="sort-column"><a href="#">商品名</a></th>
                <th data-column="price" class="sort-column"><a href="#">価格</a></th>
                <th data-column="stock" class="sort-column"><a href="#">在庫数</a></th>
                <th data-column="company_id" class="sort-column"><a href="#">メーカー名</a></th>
                <th><a href="{{ route('product.register') }}">{{ __('新規登録') }}</a></th>
            </tr>
        </thead>
        <!-- テーブルボディー -->
        <tbody id="productTableBody">
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->product_id }}</td>
                <td><img src="{{ asset('storage/'.$product->img_path)}}" alt="" width="200" height="200"></td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product->company_name }}</td>
                <td>
                    <div class="d-flex">
                        <div class="mr-2">
                            <a href="{{ route('product.show', ['product_id' => $product -> product_id]) }}" class="btn btn-primary">詳細</a>
                        </div>
                        <div>
                            <form>
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-secondary delete-btn" data-product_id="{{ $product->product_id }}">削除</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
