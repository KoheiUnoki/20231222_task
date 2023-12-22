<?php

// 1.postで送られたものを受け取りましょうネ

$id = $_POST["id"];
$title = $_POST["title"];
$author = $_POST["author"];
$content = $_POST["content"];
$reviewer = $_POST["reviewer"];

// 2．DB接続(毎回一緒)

try{

    $pdo = new PDO('mysql:dbname=db_library;charset=utf8;host=localhost','root','root');

}catch(PDOException $e){
    
    exit('DBConnectError:'.$e->getMessage());

}

// 3.updateで更新

$sql = 'UPDATE db_library_test SET title=:title, author=:author, content=:content, reviewer=:reviewer WHERE id=:id';
$stmt = $pdo -> prepare($sql);
$stmt -> bindValue(':title',   $title,   PDO::PARAM_STR);
$stmt -> bindValue(':author',  $author,  PDO::PARAM_STR);
$stmt -> bindValue(':content', $content, PDO::PARAM_STR);
$stmt -> bindValue(':reviewer', $reviewer, PDO::PARAM_STR);
$stmt -> bindValue(':id',     $id,     PDO::PARAM_INT);
$status = $stmt->execute();

// 4.データ登録処理後

if($status==false){

  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
    // select.phpへリダイアレクト
    header("Location: select.php");
    exit;
}



?>