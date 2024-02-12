/*///////////////////////////////////////////////
// 検索機能とソート/////////////////////////////////
///////////////////////////////////////////////*/
$(document).ready(function() {

    var sortDirection = 'asc';  // 初期ソート方向

    // 検索フォームのsubmitイベントを拾ってAjaxで検索結果を取得
    $('#searchForm').submit(function(e) {
        e.preventDefault();

        sortDirection = 'asc';//ソート方向初期化

        var searchFormData = $(this).serialize();// 検索フォームのデータを取得

        

        $.ajax({
            type: 'POST',
            url: 'search',
            data: searchFormData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
                // 商品一覧テーブルの内容を更新
                $('#productTableBody').html(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


    // ソート機能：テーブルヘッダーのクリックイベント
    $('table thead tr th.sort-column').click(function(e) {
        e.preventDefault();
        var columnName = $(this).data('column');  // カラム名を取得
        sortDirection = toggleSortDirection(sortDirection);  // ソート方向をトグル

        // 検索フォームのデータを取得
        var sortFormData = $('#searchForm').serializeArray();
        sortFormData.push({name: 'column', value: columnName});  // カラム名を追加
        sortFormData.push({name: 'direction', value: sortDirection});  // ソート方向を追加

        // サーバーにソート情報を送信
        sendSortRequest(sortFormData);
    });

        function toggleSortDirection(direction) {
            return direction === 'asc' ? 'desc' : 'asc';  // 昇順と降順をトグル
        }

        function sendSortRequest(sortFormData) {
 
            $.ajax({
                type: 'POST',
                url: 'sort',
                data: sortFormData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // ソート結果をテーブルに反映
                    $('#productTableBody').html(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
});


/*///////////////////////////////////////////////
// 削除ボタンのクリックイベント/////////////////////
///////////////////////////////////////////////*/
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    var productId = $(this).data('product_id');
    // 確認メッセージ
    if (confirm('本当に削除しますか？')) {
        // 削除リクエストの送信
        deleteProduct(productId);
    }
});

// 商品削除リクエストの送信
function deleteProduct(productId) {
    $.ajax({
        type: 'DELETE',
        url: 'destroy/' + productId,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // 削除成功時の処理（例: テーブルから行を削除）
            $('#productTableBody').html(response);
            alert('削除が完了しました。');
        },
        error: function(error) {
            console.log(error);
            alert('削除中にエラーが発生しました。');
        }
    });
}
