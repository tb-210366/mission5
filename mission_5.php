<?php

	$dsn='�f�[�^�x�[�X��';
	$user='���[�U�[��';
	$password='�p�X���[�h';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	//�ulog�v�Ƃ������O�̃e�[�u�������݂��Ȃ��Ƃ��A�e�[�u����V���ɍ쐬�B
	$sql = "CREATE TABLE IF NOT EXISTS log1"
	."("
	."id INT AUTO_INCREMENT PRIMARY KEY,"
	."name char(32),"
	."comment TEXT,"
	."date DATETIME,"
	."pass char(18)"
	.");";
	$stmt = $pdo->query($sql);

	if(!empty($_POST["name"]) and !empty($_POST["textarea"]) and !empty($_POST["pass"]))
	{
		if(!empty($_POST["editnumber"]))
		{
			$bbb = $_POST["editnumber"];

			//���[�U�[����̓��͂��󂯕t����
			$sql = $pdo -> prepare("update log1 set name = :name,comment = :comment,date = :date,pass = :pass where id = $bbb");

			//SQL���̈ꕔ��ϐ��ɂ���B
			$sql -> bindParam(':name', $name , PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> bindParam(':date', $date, PDO::PARAM_STR);
			$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

			//�ϐ��͂ǂ�����H
			$name = $_POST["name"];
			$comment = $_POST["textarea"];
			$date = date("Y-m-d H:i:s");
			$pass = $_POST["pass"];

			//�������ꂽ�������s����
			$sql -> execute();
		}
		else
		{
			//���[�U�[����̓��͂��󂯕t����
			$sql = $pdo -> prepare("INSERT INTO log1(name, comment,date, pass)  VALUES(:name,:comment,:date,:pass)");

			//SQL���̈ꕔ��ϐ��ɂ���
			$sql -> bindParam(':name', $name , PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> bindParam(':date', $date, PDO::PARAM_STR);
			$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
			$name = $_POST['name'];
			$comment = $_POST['textarea'];
			$date = date("Y-m-d H:i:s");
			$pass = $_POST['pass'];

			//�������ꂽ�������s����
			$sql -> execute();
		}
	}

	elseif(!empty($_POST["delete"]) and !empty($_POST["deletepass"]))
	{
		$id = $_POST["delete"];
		$deletepass = $_POST["deletepass"];

		$sql = $pdo ->prepare( "SELECT * FROM log1 WHERE id = $id");

		$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
		$sql -> execute();

		//��̃��R�[�h�����o��
		$result = $sql -> fetch();
		$Truepass = $result['pass'];

		if($deletepass == $Truepass)
		{
			$sql = "delete from log1 where id =:id";
			$stmt = $pdo -> prepare($sql);
			$stmt ->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt ->execute();
		}
		else
		{
			echo "�p�X���[�h���Ⴂ�܂��B";
			echo "<br>";
		}
	}

	elseif(!empty($_POST["edit"]) and !empty($_POST["editpass"]))
	{
		$aaa = $_POST["edit"];
		$editpass = $_POST["editpass"];

		$sql = $pdo ->prepare( "SELECT * FROM log1 WHERE id = $aaa");

		$sql -> bindParam(':name', $name , PDO::PARAM_STR);
		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
		$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

		$sql -> execute();

		$result = $sql -> fetch();
		$Truepass = $result['pass'];

		if($editpass == $Truepass)
		{
			$PostEdit1 = $result['name'];
			$PostEdit2 = $result['comment'];
			$PostEdit3 = $Truepass;

		}
		else
		{
			echo "�p�X���[�h���Ⴂ�܂��B";
			echo "<br>";
		}
	}

		
	$sql = 'SELECT * FROM log1';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row)
	{
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['date'].'<br>';
		echo "<hr>";
	}


?>

<!DOCTYPE html>
<html lang = "ja">

<head>

<meta charset = "utf-8">

</head>

<body>

<form action = "" method = "post" >

	<p>
	<input type = "text" placeholder = "name" name = "name" value = "<?php if(isset($PostEdit1)) {echo $PostEdit1;} ?>"> </p>

	<p>
	<textarea name = "textarea" placeholder = "comment" rows = "5"><?php if(isset($PostEdit2)) {echo $PostEdit2;} ?></textarea></p>

	<p>
	<input tupe = "password" placeholder = "pass" name = "pass" value = "<?php if(isset($PostEdit3)) {echo $PostEdit3;} ?>">

	<input type = "submit" value = "post"> </p>

	<p><input type = "hidden" name = "editnumber" value = "<?php if(isset($aaa)) {echo $aaa;} ?>"></p>


</form>

<form action = "" method = "post">

	<p>
	<input type = "text" placeholder = "deletenumber" name = "delete"> </p>

	<p>
	<input type =  "password" placeholder = "pass" name = "deletepass">

	<input type = "submit" value = "delete"></p>

</form>

<form action = "" method = "post">

	<p>
	<input type = "text" placeholder = "editnumber" name = "edit"> </p>

	<p>
	<input type = "password" placeholder = "pass" name = "editpass">

	<input type = "submit" value = "edit"></p>

</form>

</body>


</html>

