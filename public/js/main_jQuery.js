/*///////////////////////////////////////////////
// 検索機能///////////////////////////////////////
///////////////////////////////////////////////*/
$(document).ready(function() {
    // 検索フォームのsubmitイベントを拾ってAjaxで検索結果を取得
    $('#searchForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        console.log(formData);

        $.ajax({
            type: 'POST',
            url: 'search',
            data: formData,
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
});
/*///////////////////////////////////////////////
// ソート機能/////////////////////////////////////
///////////////////////////////////////////////*/
$(document).ready(function(e) {
    var sortDirection = 'asc';  // 初期ソート方向

    // テーブルヘッダーのクリックイベント
    $('table thead tr th.sort-column').click(function(e) {
        e.preventDefault();
        var columnName = $(this).data('column');  // カラム名を取得
        // console.log(columnName);
        sortDirection = toggleSortDirection(sortDirection);  // ソート方向をトグル
        // console.log(sortDirection);
        // サーバーにソート情報を送信
        sendSortRequest(columnName, sortDirection);
    });

    function toggleSortDirection(direction) {
        return direction === 'asc' ? 'desc' : 'asc';  // 昇順と降順をトグル
    }

    function sendSortRequest(column, direction) {
        var formData = {
            column: column,
            direction: direction
        };
        console.log(formData);
        $.ajax({
            type: 'POST',
            url: 'sort',
            data: formData,
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
    console.log(productId);
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
