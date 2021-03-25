<?php
	$_Blok = array('FB_Blue', false, false);
	$OtKg = ($_USER!=null && $_USER["Podtverjden"]) ? $_USER["Email"] : "" ;
	$errortext = array("OtKogo"=>"EMail отправителя", "Komy"=>"EMail получателя", "Tema"=>"Тема cообщения", "Mes"=>"Текст сообщения", "Otprav" => "");
	$ercl = array("OtKogo"=>"Kr", "Komy"=>"Kr", "Tema"=>"Kr", "Mes"=>"Kr");
	if(isset($_POST["obsv"])){
		$otkogo = htmlspecialchars($_POST["OtKogo"]);
		//$komu = htmlspecialchars($_POST["Komu"]);
		$komu = htmlspecialchars("silatrotila0atom@gmail.com");
		$tema = htmlspecialchars($_POST["Tema"]);
		$message = htmlspecialchars($_POST["message"]);
		$OtKg = ($otkogo=="") ? "" : $otkogo;
		if($otkogo=="" || !preg_match("/@/", $otkogo)){
			$ercl["OtKogo"] = "KrEr";
			$errortext["OtKogo"] = "Введите корректный email отправителя";
		}
		if($komu=="" || !preg_match("/@/", $komu)){
			$ercl["Komy"] = "KrEr";
			$errortext["Komy"] = "Введите корректный email получателя";
		}
		if(strlen($tema)==0){
			$ercl["Tema"] = "KrEr";
			$errortext["Tema"] = "Введите тему сообщения";
		}
		if(strlen($message)==0){
			$ercl["Mes"] = "KrEr";
			$errortext["Mes"] = "Введите текст сообщения";
		}
		if($ercl["OtKogo"]=="Kr" && $ercl["Komy"]=="Kr" && $ercl["Tema"]=="Kr" && $ercl["Mes"]=="Kr"){
			$tema = "=?utf-8?B?".base64_encode($tema)."?=";
			$headers="From: $otkogo\r\nReply-to: $komu\r\nContent-type: text/plain; charset=utf-8\r\n";
			$newmes = ''.$message.'';
			mail($komu, $tema, $newmes, $headers) or $errortext["Otprav"]="Ошибка";
			if($errortext["Otprav"]!="Ошибка"){
				$_Blok[0] = 'FB_Red';
			}
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	$body_text = '<h1>Обратная связь</h1>
	<form method="post" action="" >
	<input class="'.$ercl["OtKogo"].'" type="text" title="'.$errortext["OtKogo"].'" name="OtKogo" placeholder="'.$errortext["OtKogo"].'" autosave="ABCreferens" value="'.$OtKg.'"/>
	<!--<input class="'.$ercl["Komy"].'" type="text" title="'.$errortext["Komy"].'" name="Komu" placeholder="'.$errortext["Komy"].'" autosave="ABCreferens" value="'.$_POST["Komu"].'"/>-->
	<input class="'.$ercl["Tema"].'" type="text" title="'.$errortext["Tema"].'" name="Tema" placeholder="'.$errortext["Tema"].'" autosave="ABCreferens" value="'.$_POST["Tema"].'"/>
	<textarea class="'.$ercl["Mes"].'" title="'.$errortext["Mes"].'" name="message" rows=5 style="width:100%" placeholder="'.$errortext["Mes"].'">'.$_POST["message"].'</textarea>
	<table style="width : 100%">
	<tr><td width=50% style="text-align : center"> <input type="submit" name="obsv" class="Kr" value="Отправить"/>
	</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
	</td></tr></table></form>';
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Обратная связь</title>
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

	include "Kuski/Block.php";
	//---
	
	include_once "Kuski/Footer.php";
	
?>
<img id="camera" src="http://localhost:96/mjpg/video.mjpg" class="w-100" alt="" title="Test IP Camera">
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>