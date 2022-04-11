<?php
// ***********************************
// 画面用テーブル要素文字列作成
// ***********************************
function get_table($statement) {

    $html = "";
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {

        if ( $row["性別"]  == "男性" ) {
            $class = "text-primary";
        }
        else {
            $class = "text-danger";
        }

        $html .=<<<HTML
        <tr>
            <td>{$row["社員コード"]}</td>
            <td>{$row["氏名"]}</td>
            <td>{$row["フリガナ"]}</td>
            <td>{$row["所属"]}</td>
            <td class="{$class}">{$row["性別"]}</td>
            <td class="text-end">{$row["給与"]}</td>
            <td class="text-end">{$row["手当"]}</td>
            <td>{$row["管理者"]}</td>
            <td>{$row["生年月日"]}</td>
        </tr>
HTML;

    }

    return $html;

}