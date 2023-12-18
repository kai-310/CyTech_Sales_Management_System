@extends('layouts.app')

@section('content')
<div class="container">
    <h1>商品情報編集画面</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('商品情報編集画面') }}</div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card-body">
                    <!-- 商品登録フォーム -->
                    <form method="POST" action="{{ route('update', ['product_id'=>$product->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- 商品名 -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ID') }}</label>

                            <div class="col-md-6">
                            {{ $product->id }}

                            </div>
                        </div>

                        <!-- 商品名 -->
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('商品名') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->product_name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- 価格 -->
                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('価格') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $product->price }}" required>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- 在庫数 -->
                        <div class="form-group row">
                             <label for="stock" class="col-md-4 col-form-label text-md-right">{{ __('在庫数') }}</label>

                            <div class="col-md-6">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ $product->stock }}" required>

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- メーカー名 -->
                        <div class="form-group row">
                            <label for="maker" class="col-md-4 col-form-label text-md-right">{{ __('メーカー名') }}</label>

                            <div class="col-md-6">
                                <select id="maker" class="form-control @error('maker') is-invalid @enderror" name="maker" required>
                                    <option value="{{$company->id}}">{{$company->company_name}}</option>
                                    @foreach($companies as $id => $company_name)
                                        <option value="{{ $id }}">{{ $company_name }}</option>
                                    @endforeach
                                </select>

                                @error('maker')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- コメント -->
                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">{{ __('コメント') }}</label>

                            <div class="col-md-6">
                                <input id="comment" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" value="{{ $product->comment }}" autocomplete="comment" autofocus>

                                @error('comment')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <!-- 商品画像 -->
                        <div class="form-group row">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('商品画像') }}</label>

                            <div class="col-md-6">
                                <img src="{{ asset('storage/'.$product->img_path)}}" alt="" width="200" height="200">
                                <input id="image" type="file" class="form-control-file @error('image') is-invalid @enderror" name="image">

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- 登録ボタン -->
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('更新') }}
                                </button>
                                <a href="{{ route('product.show', ['product_id'=>$product->id]) }}" class="btn btn-secondary">
                                    {{ __('戻る') }}
                                </a>
                            </div>
                        </div>
                    </form>
                    <!-- 商品登録フォーム終了 -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection