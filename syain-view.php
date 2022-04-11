<!DOCTYPE html>
<html>

<head>
<meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
<meta charset="utf-8">
<title>社員問合せ</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.js"></script>

<style>
html,body,form {
    height: 100%;
}
#head {
    display: block;
    margin: auto;
    width: 100%;
    height: 160px!important;
    height: 100%;
}
#content {
    padding: 4px 16px;
    display: block;
    margin: auto;
    width: calc( 100% - 3px );
    height: calc( 100% - 160px - 2px );
    border: solid 2px #c0c0c0;
    overflow: scroll;
}

td,th {
    cursor: default!important;
    white-space: pre;
}

#tbl {
    user-select: none;
}

.w100 {
    width: 100px;
}

.folder {
    float: right;
}
</style>
<script>
// ***********************
// カンマ編集
// ***********************
String.prototype.number_format = 
function (prefix) {
    var num = this.valueOf();
    prefix = prefix || '';
    num += '';
    var splitStr = num.split('.');
    var splitLeft = splitStr[0];
    var splitRight = splitStr.length > 1 ? '.' + splitStr[1] : '';
    var regx = /(\d+)(\d{3})/;
    while (regx.test(splitLeft)) {
        splitLeft = splitLeft.replace(regx, '$1' + ',' + '$2');
    }
    return prefix + splitLeft + splitRight;
}

$(function(){

    $("#load_data").on( "click", function(){
        $.ajax({
                url: "https://lightbox.sakura.ne.jp/demo/json/syain_api1.php",
                cache: false,
                data: { "name" : "" }
        })
        .done(function( data, textStatus ){
            console.log( "status:" + textStatus );
            console.log( "data:" + JSON.stringify(data, null, "    ") );

            $("#message").text( data.length  + "件のデータがあります" );
            loadTable( data );
        })
        // 失敗
        .fail(function(jqXHR, textStatus, errorThrown ){
            console.log( "status:" + textStatus );
            console.log( "errorThrown:" + errorThrown );

            // エラーメッセージを表示
            alert("システムエラーです");

        })
        // 常に実行
        .always(function() {
        })
        ;
    });

});

// *************************************
// テーブル作成
// *************************************
function loadTable( arrayData ) {

    var row_data = "";

    // テーブル表示リセット
    $("#tbl .row_data").remove();

    var len = arrayData.length;
    for( i = 0; i < len; i++ ) {

        row_data = $("<tr></tr>")
            .addClass("row_data")
            .appendTo( "#tbl" );

        $.each( arrayData[i], function( propertyName, valueOfProperty ){

            // 作成日・更新日
            if ( propertyName == "作成日" || propertyName == "更新日" ) {
                return true;
            }

            if ( propertyName == "給与" || propertyName == "手当" ) {
                $("<td></td>")
                    .text( (valueOfProperty==null?"":valueOfProperty).number_format() )
                    .addClass("text-end")
                    .appendTo( row_data );
            }
            else {  
                $("<td></td>")
                    .text( valueOfProperty )
                    .appendTo( row_data );
            }
        });

    }

}
</script>
</head>

<body>
<form method="post">
    <div id="head">
        <h3 class="alert alert-primary">
            社員問合せ
            <a href="." class="btn btn-secondary btn-sm folder me-4">フォルダ</a>
        </h3>
        <input type="button" id="load_data" value="読込み" class="ms-4 btn btn-primary">
    </div>
    <div id="content">

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="w100">社員コード</th>
                            <th>氏名</th>
                            <th>フリガナ</th>
                            <th>所属</th>
                            <th>性別</th>
                            <th class="text-end">給与</th>
                            <th class="text-end">手当</th>
                            <th>管理者</th>
                        </tr>
                    </thead>
                    <tbody id="tbl">
                    </tbody>
                </table>
            </div>
    </div>
</form>
</body>
</html>