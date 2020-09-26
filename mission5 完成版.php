<html>
<head>
<meta charset="utf-8">
  <title>mission5</title>
      
 </head>

 <body>
<?php

// DB接続設定
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT"
	.");";
	$stmt = $pdo->query($sql);
	
//テーブル一覧を表示
	$sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[0];
		echo '<br>';
	}
	echo "<hr>";

//テーブルの構成詳細をみる	
	$sql ='SHOW CREATE TABLE tbtest';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
		echo $row[1];
	}
	echo "<hr>";
	
//データを入力
if(!empty($_POST["name"])&&!empty($_POST["comment"])&&empty($_POST["editnum"])){

$name=$_POST["name"];
$comment=$_POST["comment"];

	$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	 
	$sql -> execute();
}

//データ削除
if(!empty($_POST["delete"])){
	$delete=$_POST["delete"];
$id = $delete;
$sql = 'delete from tbtest where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
}

//データ編集
if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["editnum"])){

$editnum=$_POST["editnum"];
$id = $editnum; //変更する投稿番号
$name=$_POST["name"];
$comment=$_POST["comment"];
$sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
}


//データ抽出、表示
	$sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
	echo "<hr>";
	}
	
?>

<form action="" method="POST">
      <input type="text" name="name" placeholder="名前" value="<?php echo $editnamae;?>"><br>
      <input type="text" name="comment" placeholder="コメント" value="<?php echo $editname;?>"><br>
      <input type="submit" value="送信"><br>
	  <br>
	  <input type="text" name="delete" placeholder="削除対象番号"><br>
      <input type="submit" value="削除"><br>
	  <br>
      <input type="text" name="editnum" placeholder="編集対象番号"><br>
      <input type="submit" value="編集"><br>
	<hr>
      </form>

</body>
</html>