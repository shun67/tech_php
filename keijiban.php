
<?php
//データベース接続
$dsn = '****************';
$user = 't**********';
$password = 'PASSWORD';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//データベース接続
//データベースの作成（IF NOT EXISTS）
$sql = "CREATE TABLE IF NOT EXISTS db_mission5"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
  . "comment TEXT,"
  . "date char(32),"
  . "pass char(32)"
  .");";
  //name comment date pass
	$stmt = $pdo->query($sql);

$edi_name="名前";
$ed_com="コメント";
//あらかじめ初期化
if(isset($_POST['edit_num'])&&isset($_POST['pass'])){
$name_tittle_pass="パスワードを新規入力してください";
//post null ?

$edit_num=$_POST['edit_num'];
$pass=$_POST['pass'];
 $sql = 'SELECT * FROM db_mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
foreach ($results as $key=> $row){

if($edit_num==($key+1)&& $row['pass']==$pass){
$edi_name=$row['name'];
$ed_com=$row['comment'];
$edit_num=($key+1);
}
}
}
else{
    $name_tittle_pass="パスワードを入力してください";
    $edit_num="";

}
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
</head>
<form  method="post" action="mission5.php">
<input type="hidden" value="<?php echo $edit_num;?>" name="edit_num"  placeholder="" />
<p>あなたの名前を入力してください</p>
 <input type="text" name="name" value="<?php echo $edi_name;?>" placeholder="名前"  required><br />
<p>コメントを入力してください</p>
 <input type="text" name="comment" value="<?php echo $ed_com;?>"  placeholder="コメント"  required><br />
<p><?php echo $name_tittle_pass;?></p>
 <input type="password"　 name="pass"　value="" placeholder="パスワード"  required><br />
    <input type="submit" value="送信">
</form>

<form  method="post" action="mission5.php">

<p>削除したい番号を指定してください</p>
 <input type="number"　 name="del_num"　value="" placeholder="削除したい番号"  required><br />
<p>パスワードを入力してください</p>
 <input type="password"　 name="pass"　value="" placeholder="パスワード"  required><br />
    <input type="submit" value="削除">
</form>

<form  method="post" action="mission5.php">

<p>編集したい番号を指定してください</p>
 <input type="number"　 name="edit_num"　value="" placeholder="編集したい番号"  required><br />
<p>パスワードを入力してください</p>
 <input type="password"　 name="pass"　value="" placeholder="パスワード"  required><br />
    <input type="submit" value="編集">
</form>


<?php
//del#########################################################################
//del_numにフォームから消したい番号代入
if(isset($_POST['del_num'])&&isset($_POST['pass'])&&isset($_POST['del_num'])){
$del_num=$_POST['del_num'];
$pass=$_POST['pass'];
 $sql = 'SELECT * FROM db_mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $key=> $row){
  //$rowの中にはテーブルのカラム名が入る
if($key==($del_num-1)&&$pass== $row['pass']){
$del_num=$row['id'];
$sql = 'delete from db_mission5 where id=:del_num';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':del_num', $del_num, PDO::PARAM_INT);
$stmt->execute();
}
else;
}
}
//del#########################################################################	

//add&edit#########################################################################
if(isset($_POST['name'])&&isset($_POST['comment'])&&isset($_POST['pass'])){
$name=$_POST['name'] ;
$comment=$_POST['comment'] ;
$pass=$_POST['pass'];
$dd = date("Y/m/d H:i:s");

 //編集のとき####################################################
if ($_POST['edit_num']){
 $edit_id=$_POST['edit_num'] ;

  $sql = 'SELECT * FROM db_mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $key=> $row){
  //$rowの中にはテーブルのカラム名が入る
  if($key==($edit_id-1)){
  $edit_id=$row['id'];
	$sql = 'update db_mission5 set name=:name,comment=:comment,date=:dd,pass=:pass where id=:edit_id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
  $stmt->bindParam(':dd', $dd, PDO::PARAM_STR);
  $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':edit_id', $edit_id, PDO::PARAM_INT);
  $stmt->execute();
  }
  else;
}
}
//編集のとき####################################################

//追加のとき####################################################
else{
//add database
$sql = $pdo -> prepare("INSERT INTO db_mission5 (name, comment,date,pass) VALUES (:name, :comment,:dd, :pass)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':dd', $dd, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
$sql -> execute();


}
//追加のとき#####################################################
}
//add&edit#########################################################################

//print out#########################################################################
echo "<br>";
  $sql = 'SELECT * FROM db_mission5';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $key=> $row){
	//$rowの中にはテーブルのカラム名が入る
echo ($key+1).": 名前=>".$row['name']." 投稿時間=>".$row['date']."<br>";
echo"コメント:".$row['pass']."<br>";
}
//print out#########################################################################
?>

</body>
</html>
