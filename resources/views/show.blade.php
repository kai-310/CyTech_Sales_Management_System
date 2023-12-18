@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品詳細画面</h1>
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th> <th>{{ $product->id }}</th>
        </tr>
        <tr>
            <th>商品画像</th> <td><img src="{{ asset('storage/'.$product->img_path)}}" alt="" width="200" height="200"></td>
        </tr>
        <tr>
            <th>商品名</th> <td>{{ $product->product_name }}</td>
        </tr>
        <tr>
            <th>メーカー</th> <th>{{ $products->company_name }}</th>
        </tr>
        <tr>
            <th>価格</th> <td>{{ $product->price }}</td>
        </tr>
        <tr>
            <th>在庫数</th> <td>{{ $product->stock }}</td>
        </tr>
        <tr>
            <th>コメント</th> <td>{{ $product->comment }}</td>
        </tr>
    </table>

    <!-- 編集ボタンと戻るボタン -->
    <div class="mt-4">
        <a href="{{ route('edit', ['product_id'=>$product->id]) }}" class="btn btn-primary mr-2">編集</a>
        <a href="{{ route('home') }}" class="btn btn-secondary">戻る</a>
    </div>
</div>
@endsection