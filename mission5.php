<html>
<head>
<meta charset="utf-8">
  <title>mission5</title>
      
 </head>

 <body>

 <?php
  $name=$_POST["name"];//コメントフォーム
  $namae=$_POST["namae"];//名前フォーム
  $sakuzyo=$_POST["sakuzyo"];//削除フォーム
  $edit=$_POST["edit"];//編集機能フォーム
  $date=date('Y年m月d日 H時i分');//日付
  $filename="mission_3-04.txt";//テキストファイル
  $editnum=$_POST["editnum"];//編集番号フォーム


 //投稿機能開始

  if(empty($namae)==false&&empty($name)==false&&empty($editnum)==true){//もし$namaeと$nameが空っぽでなく、$editnumは空だったら
  $ret_array=file($filename);//テキストファイルを読み込み
  $d=$ret_array === false ? 1 : count($ret_array)+1;//2-1の要素の数を数える（配列の順番は０から始まる←→投稿番号は１から始めたい）
  $a=$d."<>".$namae."<>".$name."<>".$date;//投稿番号、名前、コメント、日付   
  $fp=fopen($filename,'a+');//読み込みと追加書き込みをする
  fwrite($fp,$a.PHP_EOL);//書き込み処理
  fclose($fp);
  }

  //投稿機能終了

  //削除機能開始

  if (!empty($_POST["sakuzyo"])) {      //$sakuzyoが空っぽじゃなかったら
    $delnum = $_POST["sakuzyo"];     //書き込む文字列を変数に代入する//
    $delCon = file("mission_3-04.txt");      // データを書き出すファイル名を設定
    $filename="mission_3-04.txt";

    $fp = fopen($filename, "w");
    for ($i = 0; $i < count($delCon); $i++) {       //ファイルを読み込んだ配列を、配列の数（＝行数）だけループさせる
        $delDate = explode("<>", $delCon[$i]);      //ループ処理内：区切り文字「<>」で分割して、それぞれの値を取得
        if ($delDate[0] != $delnum) {       //投稿番号と削除対象番号を比較。
            fwrite($fp, $delCon[$i]);       //$delDate[0]＝１番最初の値＝$num
        } else {        //等しくない場合は、ファイルに追加書き込みを行う
            fwrite($fp, "消去しました".PHP_EOL);        //等しい場合は、”消去しました”で置き換える→削除対象の行は上書きされて消えてしまう
        }
    }
    fclose($fp);
}
  
 //削除機能終了

 //編集選択始まり

  if(empty($edit)==false){//$editが空っぽじゃなかったら
  $ret_array=file($filename);//ファイル読み込み
  for($i=0; $i<count($ret_array);$i++){//ループ処理
  $ex=explode("<>",$ret_array[$i]);
  if($i==$edit-1){//投稿番号と編集番号が一致したら
      $editbango=$ex[0];
      $editnamae=$ex[1];
      $editname=$ex[2];
  }
  }
  $eded=$editbango."<>".$editnamae."<>".$editname;  //これらが「名前」「コメント」フォームに再表示される
  }
  //編集選択終わり

  //編集機能始まり

  if(empty($editnum)==false&&empty($namae)==false&&empty($name)==false){//編集番号と$namaeと$namaeが空っぽじゃなかったら
  $editel=file($filename);//ファイル読み込み
  $kakikomi=fopen($filename,"w");//上書き書き込み
  for($i=0; $i<count($editel);$i++){//ループ処理
  $plode=explode("<>",$editel[$i]);
  if($plode[0]==$editnum){//一致したら
   
    $a=$editnum."<>".$namae."<>".$name."<>".$date;
  fwrite($kakikomi,$a.PHP_EOL);//差し替え
  
}  
 else{//一致しなかったら
    fwrite($kakikomi, $editel[$i]);
    }//else閉じ
 
 }//ループ処理閉じ
 fclose($kakikomi);
 }

 //編集機能終わり


 ?>

  <form action="" method="POST">
      <input type="text" name="namae" placeholder="名前" value="<?php echo $editnamae;?>"><br>
      <input type="text" name="name" placeholder="コメント" value="<?php echo $editname;?>"><br>
      <input type="hidden" name="editnum" value="<?php echo $edit; ?>"><br>

  
      <input type="submit" value="送信">
      <br>
      <input type="text" name="sakuzyo" placeholder="削除対象番号"><br>
      <input type="submit" value="削除"><br>
      <br>
      <input type="text" name="edit" placeholder="編集対象番号"><br>
      <input type="submit" value="編集"><br>

      </form>

<?php


 //表示機能

  $ret_array=file($filename);//テキストファイルを読み込み
  for($i=0; $i<count($ret_array);$i++){//ループ処理
  $ex=explode("<>",$ret_array[$i]);//投稿番号取得、それを読み込んだファイル
  echo $ex[0].$ex[1].$ex[2].$ex[3]."<br>";//分解して投稿番号を取得、表示
  }
?>


</body>
</html>