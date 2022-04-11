<?php
// ***************************
// 接続
// ***************************
$pdo = connectDb();

// *************************************
// データベース接続
// *************************************
function connectDb(){

    global $error;

    $result = null;

    try {
        $result = new PDO( $GLOBALS["connect_string"], $GLOBALS["user"], $GLOBALS["password"] );
    } 
    catch ( PDOException $e ) {
        $error["db"] = "<div>{$GLOBALS["connect_string"]}, {$GLOBALS["user"]}, {$GLOBALS["password"]}</div>"; 
        $error["db"] .= $e->getMessage();
        return $result;
    }
    // 接続以降で try ～ catch を有効にする設定
    $result->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $result;

}