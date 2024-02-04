<!-- resources/views/partials/product_table.blade.php -->

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
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary delete-btn" data-product_id="{{ $product->product_id }}" onclick="deleteProduct(this)">削除</button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
@endforeach