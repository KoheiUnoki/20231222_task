<?php

// htmlspecialcharsのためのファンクション

// require_once('funcs.php');

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
  }



//1.  DB接続します
try {

  //ID:'root', Password: xamppは 空白 ''
  $pdo = new PDO('mysql:dbname=db_library;charset=utf8;host=localhost','root','root');

} catch (PDOException $e) {

  exit('DBConnectError:'.$e->getMessage());

}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM db_library_test");
$status = $stmt->execute();

//３．データ表示
$view="";
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    // $view .= "<p>";
    // $view .= h($result['title']).h($result['author']).h($result['content']).h($result['indate']);
    // // var_dump($result);
    // $view .= "</p>";

    $view .= '<section class="text-gray-600 body-font">';
    $view .= '<div class="container px-5 py-24 mx-auto">';
    $view .= '<div class="xl:w-1/2 lg:w-3/4 w-full mx-auto text-center">';
    $view .= '<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="inline-block w-8 h-8 text-gray-400 mb-8" viewBox="0 0 975.036 975.036">';
    $view .= '<path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>';
    $view .= '</svg>';
    $view .= '</p>';
    $view .= '<h2 class="text-gray-900 font-medium title-font tracking-wider text-m">';
    $view .= h($result['title']);
    $view .= '</h2>';
    $view .= '<p class="text-gray-500">';
    $view .= h($result['author']);
    $view .= '</p>';
    $view .= '<span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-8 mb-6"></span>';
    $view .= '<p class="leading-relaxed text-lg">';
    $view .= h($result['content']);
    $view .= '</p><br>';
    $view .= '<h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">';
    $view .= 'date '.h($result['indate']);
    $view .= '</h2>';
    $view .= '<h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">';
    $view .= 'reviewed by '.h($result['reviewer']);
    $view .= '</h2>';
    $view .= '<h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">';
    $view .= '<a href="u_view.php?id='.$result["id"].'">';
    $view .= '[編集]';
    $view .= "</a>";
    $view .= '<a href="delete.php?id='.$result["id"].'">';
    $view .= '[削除]';
    $view .= "</a>";
    $view .= '</h2>';
    // $view .= '<h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">';
    // $view .= '[削除]';
    // $view .= '</h2>';

    // $view .= '<span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-8 mb-6"></span>';
    // $view .= '<h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">';
    // $view .= h($result['title']);
    // $view .= '</h2>';
    // $view .= '<p class="text-gray-500">';
    // $view .= h($result['author']);
    // $view .= '</p>';
    $view .= '</div>';
    $view .= '</div>';
    $view .= '</section>';
  
  }

}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">

<!-- ヘッダー -->
<header class="text-gray-600 body-font">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
      </svg>
      <span class="ml-3 text-xl">Tailblocks</span>
    </a>
    <nav class="md:mr-auto md:ml-4 md:py-1 md:pl-4 md:border-l md:border-gray-400	flex flex-wrap items-center text-base justify-center">
      <a class="mr-5 hover:text-gray-900" href="index.php">データ登録</a>
      <a class="mr-5 hover:text-gray-900">Second Link</a>
      <a class="mr-5 hover:text-gray-900">Third Link</a>
      <a class="mr-5 hover:text-gray-900">Fourth Link</a>
    </nav>
    <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">Button
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</header>
<!-- ヘッダー -->

<!-- Main[Start] -->
<div>
  <!-- php echoの代わりに、?= -->
    <div class="container jumbotron"><?= $view ?></div>
</div>
<!-- Main[End] -->

</body>
</html>