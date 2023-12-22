<?php

// GETでid取得

$id = $_GET["id"];

// DB接続
try{

    $pdo = new PDO('mysql:dbname=db_library;charset=utf8;host=localhost','root','root');

}catch(PDOException $e){
    
    exit('DBConnectError:'.$e->getMessage());

}

// UPDATE

$sql = "DELETE FROM db_library_test WHERE id=:id";
$stmt = $pdo -> prepare($sql);
$stmt -> bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録

$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
    // データのみ抽出の場合はWhileループで取り出さない.$stmt->fetch()でひとつだけ取り出せる。
    header("Location: select.php");
    exit;
}

?>