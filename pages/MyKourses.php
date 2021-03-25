<?php
	$_Blok = array('FB_Blue', false, false);
	$errortext = array("zag"=>"Название", "TXT"=>"Описание", "Ava"=>"Аватарка");
	$_ercl = array("zag"=>"Kr", "TXT"=>"Kr", "Ava"=>"Kr");
	if($_USER!=null){
		$_allMyPodp = get_massiv_po_zaprosu($podkl, "SELECT * FROM buy_kurse WHERE Kto='".$_USER["Login"]."' AND Status='1'");
		$body_text = '<h1>Мои подписки</h1>';
		foreach ($_allMyPodp as $_oneMyPodp){
			$kurse = get_massiv_po_zaprosu($podkl, "SELECT * FROM kurs WHERE ID='".$_oneMyPodp["Kurs"]."'");
			$body_text.=('<table><tr><td style="width:100px">
			<img src="'.(($kurse[0]["Ava"] && file_exists($kurse[0]["Ava"])) ? $kurse[0]["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
			</td><td><a href="Kourses?ID='.$kurse[0]["ID"].'" class="b"><b>'.$kurse[0]["Name"].'</b></a><br/>'.$kurse[0]["Description"].'<br/>
			<form method="post" action="Tests" style="text-align : center; width : 240px;"><input name="ID" value="'.$kurse[0]["ID"].'" type="hidden" /><input type="submit" class="Kr" value="Пройти тест" name="BEGINPROH"/></form>
			</td></tr></table><hr/>');
		}
	}else{
		$_Blok[0] = 'FB_Red';
		$body_text = '<h1>Авторизуйтесь</h1>Данная страница предназначена только для авторизованных пользователей';
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Мои подписки</title>
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
	include "Kuski/Block.php";
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>