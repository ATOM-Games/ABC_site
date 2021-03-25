<?php
	$_KOWrS=''; $_newNews="";
	$_Blok = array('FB_Blue', false, false);
	$errortext = array("zag" => "Название", "TXT" => "Описание", "Ava" => "Аватарка");
	if(isset($_POST["Pod"])){
		add_po_zaprsu($podkl, "UPDATE buy_kurse SET Status='1' WHERE Kto='".$_POST["Kto"]."' AND Kurs='".$_POST["Kogo"]."'");
	}
	
	
	if($_USER != null){
		if($_USER["Doljnost"] != 'ученик' && $_USER["Doljnost"] != 'куратор') {
			$_newNews='<h1>Покупки курсов</h1><hr/>';
			$_allpok = get_massiv_po_zaprosu($podkl, "SELECT * FROM buy_kurse WHERE Status=0");
			if($_allpok!=null){
				foreach($_allpok as $onepok){
					$kto = get_massiv_po_zaprosu($podkl, "SELECT Family, Name FROM polzovatel WHERE Login='".$onepok["Kto"]."'");
					$kur = get_massiv_po_zaprosu($podkl, "SELECT Name FROM kurs WHERE ID='".$onepok["Kurs"]."'");
					$_newNews.='<b>Покупатель : </b>'. ( ($kto!=null) ? ('<a href="Profile?ID='.$onepok["Kto"].'" class="b">'.$kto[0]["Family"].' '.$kto[0]["Name"].'</a>') : ('<a class="b">НЕИЗВЕСТНЫЙ ПОЛЬЗОВАТЕЛЬ</a>') ).'<br/>
					<b>Курс : </b>'.( ($kur!=null) ? ('<a href="Kourses?ID='.$onepok["Kurs"].'" class="b">'.$kur[0]["Name"].'</a>') : ('<a class="b">НЕИЩВЕСТНЫЙ КУРС</a>') ).'<br/>
					<b>Дата покупки : </b>'.$onepok["Date"].'<form method="post" action="" style="text-align : center"><input type="submit" class="Kr" name="Pod" value="Подтвердить оплату"/>
					<input type="hidden" name="Kto" value="'.$onepok["Kto"].'"/><input type="hidden" name="Kogo" value="'.$onepok["Kurs"].'"/></form><hr/>';
				}
			}else{
				
				
			}
		}else{
			$_Blok[0] = 'FB_red';
			$_newNews='<h1 style="color:red;">Ошибка уровня доступа</h1>Функция редактирования курса доступна только преподавательскому составу на должности директора и выше.';
		}
	}
	$_allKat = get_massiv_po_zaprosu($podkl, "SELECT * FROM kategories");
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Покупки</title>
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
	$body_text = $_newNews;
	include "Kuski/Block.php";
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>