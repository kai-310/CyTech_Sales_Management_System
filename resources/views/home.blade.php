@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品一覧画面</h1>

    <div class="row justify-content-center">
        <form method="post" action="{{ route('search') }}" enctype="multipart/form-data">
        @csrf
            <div class="d-flex">
                <div class="col-md-4">
                    <input type="text" id="keyword" name="keyword" class="form-control" placeholder="検索キーワード">
                </div>
                <div class="col-md-4">
                    <select id="maker" name="maker" class="form-control">
                        <option value = "">メーカー名</option>
                        @foreach($companies as $id => $company_name)
                            <option value = "{{ $id }}">{{ $company_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">検索 </button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- 以下、商品一覧テーブルのコード -->
    <table class="table table-bordered mt-4">
        <!-- テーブルヘッダー -->
        <thead>
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <th>
                    <a href="{{ route('product.register') }}">{{ __('新規登録') }}</a>
                </th>
            </tr>
        </thead>
        <!-- テーブルボディー -->
        <tbody>
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
                            <form action="{{ route('destroy', ['product_id' => $product -> product_id]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-secondary" onclick="return confirm('本当に削除しますか？')">削除</button>
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
