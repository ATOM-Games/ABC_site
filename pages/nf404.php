<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Ошибка URL-запроса</title>
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
	$body_text = "<h1 style=\"color:red\">Ошибка 404</h1>\n Страница не найдена. Пожалуйста. Убедитесь, что Ваш URL-запрос \"".substr($_SERVER["REQUEST_URI"], 1)."\" правильный";
	$_Blok = array('FB_Red', false, false);
	include "Kuski/Block.php";
	//---
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>