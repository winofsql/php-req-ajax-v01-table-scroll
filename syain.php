<?php
require_once("setting.php");

header( "Content-Type: application/json; charset=utf-8" );

// データベースに接続する
require_once("db_connect.php");
require_once("model.php");

// ***********************************
// SQL 文字列
// ***********************************
$sql = <<<QUERY
select 
    社員マスタ.社員コード,
    社員マスタ.氏名,
    社員マスタ.フリガナ,
    concat(社員マスタ.所属,' ',名称) as 所属,
    case 社員マスタ.性別
        when 0 then '男性'
        when 1 then '女性'
        else '不明'
    end as 性別,
    社員マスタ.作成日,
    社員マスタ.更新日,
    format(社員マスタ.給与, 0) as 給与,
    format(社員マスタ.手当, 0) as 手当,
    管理者.氏名 as 管理者,
    DATE_FORMAT(社員マスタ.生年月日,'%Y/%m/%d') as 生年月日
from 社員マスタ
    left outer join コード名称マスタ
        on 社員マスタ.所属 = コード名称マスタ.コード
        and コード名称マスタ.区分 = 2
    left outer join 社員マスタ 管理者
        on 社員マスタ.管理者 = 管理者.社員コード
where 社員マスタ.氏名 like :name
order by 社員マスタ.社員コード
QUERY;

// ***********************************
// 準備
// ***********************************
$statement = $pdo->prepare($sql);

// ***********************************
// バインド
// ***********************************
$statement->bindValue(':name', "%{$_REQUEST["name"]}%", PDO::PARAM_STR);

// ***********************************
// 実行
// ***********************************
$statement->execute();

// ***********************************
// 読込み
// ***********************************
$html = get_table( $statement );

// ***********************************
// 終了処理
// ***********************************
$statement = null;
$pdo = null;

