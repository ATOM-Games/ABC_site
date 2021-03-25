<?php
	if(isset($_GET["Exit"])){
		if($_USER!=null){
			setcookie ("userlogin", null);
			header("Location: Profile?Login=1"); exit();
		}
	}
	if(isset($_GET["PostReg"])){
		$sqlgetmess = "UPDATE polzovatel SET Podtverjden=1 WHERE Login = '".$_GET["PostReg"]."'";
		$result = mysqli_query($podkl, $sqlgetmess);
		header("Location: Profile?ID=".$_GET["PostReg"]); exit();
	}
	if($_USER!=null){
		if(isset($_GET["ID"])) include "View/User.php";
		if(isset($_GET["DeleteMe"])) include "View/deleteUser.php";
		if(isset($_GET["RedactMe"])) include "View/redactUser.php";
	}else{
		//if(isset($_GET["ID"])) { header("Location: Profile?Login=1"); exit(); }
		if(isset($_GET["ID"])) include "View/User.php";
		if(isset($_GET["Login"])){
				include_once "Login.php";
		}
		if(isset($_GET["Registration"])){
			include_once "Registration.php";
		}
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8">
<title><?=$_page_title;?></title>
<link rel="stylesheet" href="resource/STUL.css" type="text/css">
</head>
<body>
<?php 
	include_once "Kuski/Header.php";
	include_once "Kuski/Menu.php";
	include_once "Kuski/FindBlock.php";
	include "Kuski/Block.php";
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>

</body></html>