<?php
	$_NEWS; $_newNews="";
	$_Blok = array('FB_Blue', false, false);
	$errortext = array("Zag"=>"Заголовок", "TXT"=>"Тело новости");
	$ercl = array("Zag"=>"Kr", "TXT"=>"Kr");
	if(isset($_POST["newnov"])){
		if(strlen($_POST["Zag"])==0){ $errortext["Zag"]="Напишите заголовок"; $ercl["Zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите текст"; $ercl["TXT"] = "KrEr"; }
		if($ercl["Zag"]=="Kr" && $ercl["TXT"]=="Kr"){
			add_po_zaprsu($podkl, "INSERT INTO news(keywords, Author, Zagolovok, Txt) VALUES ('".$_POST["KeyWord"]."', '".$_POST["Login"]."', '".$_POST["Zag"]."', '".$_POST["TXT"]."')");
			$_NEWS = '<div style="text-align:center"><b style="color:#aa00aa;">Новость была успешно добавлена</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["regnov"])){
		if(strlen($_POST["Zag"])==0){ $errortext["Zag"]="Напишите заголовок"; $ercl["Zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите текст"; $ercl["TXT"] = "KrEr"; }
		if($ercl["Zag"]=="Kr" && $ercl["TXT"]=="Kr"){
			add_po_zaprsu($podkl, "UPDATE news SET keywords='".$_POST["KeyWord"]."', Author='".$_POST["autor"]."', Zagolovok='".$_POST["Zag"]."', Txt='".$_POST["TXT"]."' WHERE ID=".$_POST["id"]);
			$_NEWS = '<div style="text-align:center"><b style="color:#aa00aa;">Новость была успешно изменена</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["delnov"])){
		add_po_zaprsu($podkl, "DELETE From news WHERE ID=".$_POST["id"]);
		$_NEWS = '<div style="text-align:center"><b style="color:#aa00aa;">Новость была успешно удалена</b></div><br/>';
	}
	if($_USER !=null){
		if(isset($_GET["NewNews"])){
		$_newNews='<h1>Добавление новости</h1>'.$_NEWS.'<form method="post" action="">
			<input class="'.$ercl["Zag"].'" type="text" title="'.$errortext["Zag"].'" name="Zag" placeholder="'.$errortext["Zag"].'" autosave="ABCreferens" value="'.$_POST["Zag"].'"/>
			<input class="Kr" type="text" title="Ключевые слова" name="KeyWord" placeholder="Ключевые слова" autosave="ABCreferens" value="'.$_POST["KeyWord"].'"/>
			<textarea class="'.$ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width:100%" placeholder="'.$errortext["TXT"].'">'.$_POST["TXT"].'</textarea>
			<table style="width : 100%"><input value="'.$_USER["Login"].'" name="Login" style="display:none"/>
			<tr><td width=50% style="text-align : center"> <input type="submit" name="newnov" class="Kr" value="Отправить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>';
		}
		if(isset($_GET["RegNews"])){
			$novka = get_massiv_po_zaprosu($podkl, "SELECT * From news WHERE ID=".$_GET["RegNews"]);
			$_newNews='<h1>Редактирование новости</h1>'.$_NEWS.'<form method="post" action="" >
			<input type="text" style="display:none" name="id" value="'.$novka[0]["ID"].'"/>
			<input type="text" style="display:none" name="autor" value="'.$novka[0]["Author"].'"/>
			<input class="'.$ercl["Zag"].'" type="text" title="'.$errortext["Zag"].'" name="Zag" placeholder="'.$errortext["Zag"].'" autosave="ABCreferens" value="'.$novka[0]["Zagolovok"].'"/>
			<input class="Kr" type="text" title="Ключевые слова" name="KeyWord" placeholder="Ключевые слова" autosave="ABCreferens" value="'.$novka[0]["keywords"].'"/>
			<textarea class="'.$ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width:100%" placeholder="'.$errortext["TXT"].'">'.$novka[0]["Txt"].'</textarea>
			<table style="width : 100%">
			<tr><td width=50% style="text-align : center"> <input type="submit" name="regnov" class="Kr" value="Изменить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>';
		}
		if(isset($_GET["DelNews"])){
			$_Blok[0] = 'FB_Red';
			$_newNews='<h1>Удаление новости</h1>'.(($_NEWS) ? $_NEWS : '<div style="text-align:center">Вы удаляете новостную запись. Вы уверены?</div>
			<form method="post" action="" ><table style="width : 100%"><input type="text" name="id" style="display:none" value="'.$_GET["DelNews"].'"/>
			<tr><td width=50% style="text-align : center"> <input type="submit" name="delnov" class="Kr" value="Удалить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>');
		}
	}else{
		if(isset($_GET["NewNews"]) || isset($_GET["DelNews"]) || isset($_GET["RegNews"])){
			header("Location: News"); exit();
		}
	}
	if(!isset($_GET["DelNews"]) && !isset($_GET["RegNews"]) && !isset($_GET["NewNews"])){
		$_NEWS = get_obrat_massiv_po_zaprosu($podkl, "SELECT * From news");
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Новости</title>
<meta charset="utf-8">
<meta content="Название документа (не повторяет титульника)" name="dc.title" />
<meta content="Описание - 1 предложение" name="description" />
<meta content="Ключевые слова - штук 10-15" name="keywords" />
<meta content="Владимир Антонов" name="author" />
<meta content="Programming,Games,Design" name="userline" />
<meta content="programmers,gamers,designers" name="dc.audience" />
<meta content="computers" name="rating" />
<meta content="Russia" name="distribution" />
<meta content="text/html; charset=windows-1251" http-equiv="content-type" />
<meta content="index, follow" name="robots" />
<link rel="stylesheet" href="resource/STUL.css" type="text/css">
</head>
<body>
<?php 
	include_once "Kuski/Header.php";
	include "Kuski/Menu.php";
	include_once "Kuski/FindBlock.php";
	//---
	if(isset($_COOKIE["userlogin"]) && (isset($_GET["NewNews"]) || isset($_GET["RegNews"]) || isset($_GET["DelNews"]))){
		$body_text = $_newNews;
		include "Kuski/Block.php";
	}else{
		if($_USER!=null && $_USER["Doljnost"]!="ученик")echo '<div style="text-align:center;"><form action="" method="get" name="NewNews"><input type="submit" value="⧾" class="Kr" name="NewNews"/></form></div>';
		foreach ($_NEWS as $OneNew){
			$_Blok = array('FB_Blue', false, false);
			$auto = get_pol_po_login($podkl, $OneNew["Author"]);
			$body_text = '<table width=100%><tr><td width=30px></td><td><h1>'.$OneNew["Zagolovok"].'</h1></td>
			<td width=30px><h1>'.( ($_USER["Doljnost"]=="владелец" || ($_USER["Doljnost"]=="управляющий" && $auto["Doljnost"]!="владелец") || $_USER["Login"] == $OneNew["Author"] ) ? '<a href="News?RegNews='.$OneNew["ID"].'" style="color:green;" title="Редактировать"><pen></pen></a><a href="News?DelNews='.$OneNew["ID"].'" style="color:red" title="Удалить"><pen></pen></a>' : '' ).'</h1></td></tr></table>'.$OneNew["Txt"].'
			<br/>Автор : '.( (count($auto)>0) ? '<a href="Profile?ID='.$auto["Login"].'">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'';
			include "Kuski/Block.php";
		}
	}
	//---
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>