<?php


// postデータ取得
$title = $_POST['title'];
$author = $_POST['author'];
$content = $_POST['content'];
$reviewer = $_POST['reviewer'];

// DB接続します
try {

    //ID:'root', Password: xamppは 空白 ''
    $pdo = new PDO('mysql:dbname=db_library;charset=utf8;host=localhost','root','root');
  
  } catch (PDOException $e) {
  
    exit('DBConnectError:'.$e->getMessage());
  }

//３．データ登録SQL作成

// 3-1. SQL文を用意
$stmt = $pdo->prepare("
INSERT INTO 
db_library_test(id, title, author, content, indate, reviewer)
VALUE
(NULL,:title,:author,:content,sysdate(),:reviewer)");//:name、:emailは新規変数。次の3-2で:nemeに$nameを入れる作業を行う。ここに直接$〇〇を入れない。

// 3-2. バインド変数を用意
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':author', $author, PDO::PARAM_STR);
$stmt->bindValue(':content', $content, PDO::PARAM_STR);
$stmt->bindValue(':reviewer', $reviewer, PDO::PARAM_STR);

//  3-3. 実行
$status = $stmt->execute();

//４．データ登録処理後
if($status === false){

  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);

}else{

  //５．index.phpへリダイレクト
  // 成功した場合
  // echo 'test'
  header('Location: index.php');
  
}





?>