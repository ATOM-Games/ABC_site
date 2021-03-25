<?php
$body_text = '';
if(isset($_GET["Pr_of_ud"])){
	$body_text='<h1>Иные причины удаления с сайта</h1></hr>';
	$svoi = get_massiv_po_zaprosu($podkl, "SELECT * FROM otset_delete_user WHERE Svoya='1'");
	if($svoi){
		foreach($svoi as $onesvoi){
			$body_text.=($onesvoi["Prichina"].'<hr/>');
		}
	}else{
		$body_text.='По иным причинам, которые юы пользователи могли бы записать в поле "Свой вариант", никто не удалялся';
	}
}
if(isset($_GET["Result"])){
	$allUsp = get_massiv_po_zaprosu($podkl, "SELECT * FROM test_result tr INNER JOIN kurs K ON tr.Kurs=K.ID WHERE Student='".$_GET["Result"]."'");
	$auto = get_pol_po_login($podkl, $_GET["Result"]);
	$body_text='<h1>Успеваемость пользователя "'.$auto["Family"].' '.$auto["Name"].'"</h1><table class="stat_st"><tr class="zag">
	<td style="width : 30%">Курс</td><td style="width : 30%">Процент ответов</td><td style="width : 40%">Дата и время</td></tr>';
	foreach($allUsp as $oneUsp){
		$body_text.='<tr class="zag"><td>'.$oneUsp["Name"].'</td><td>'.intval($oneUsp["Percent"]).'%</td><td>'.$oneUsp["Data"].'</td></tr>';
	}
	$body_text.='</table>';
}


if($body_text == ''){
	$body_text='<h1>Статистика сайта</h1>';
	//----Populyarnost kursov
	$allPok_1 = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Status='1'")[0]["Qty"];
	$body_text.='<h2>Популярность курсов (подтвержденные покупки '.$allPok_1.' шт)</h2>
	<table class="stat_st"><tr class="zag">
	<td style="width : 25%">Курсы</td><td style="width : 75%">Популярность</td></tr>';
	$allKurser = get_massiv_po_zaprosu($podkl, "SELECT * FROM kurs");
	$allPok_0 = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Status='0'")[0]["Qty"];
	$prskur_1 = array();
	foreach($allKurser as $oneKurser){
		$_colBye_1 = intval(get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Kurs='".$oneKurser["ID"]."' AND Status='1'")[0]["Qty"]);
		$prskur_1 +=[ $oneKurser["ID"] => $_colBye_1 ];
	}
	$keymax_1 = MaxAssoc($prskur_1);
	foreach($allKurser as $oneKurser){
		$randcolor = Rand_Color($_color_bukv, 0, 12);
		$_colBye_1 = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Kurs='".$oneKurser["ID"]."' AND Status='1'")[0]["Qty"];
		$per = (intval($prskur_1[$keymax_1])>0) ? 100/intval($prskur_1[$keymax_1])*intval($_colBye_1) : 0;
		$body_text.='<tr class="stlb_c"><td style="width : 25%;">'.$oneKurser["Name"].'<br/>('.$_colBye_1.' покупок)</td><td style="width : 75%;"><div style="height:25px; width:'.$per.'%; background-color : '.$randcolor.';"></div></td></tr>';
	}
	$body_text.='<table><br/><br/>
	<h2>Популярность курсов (ожидают подтверждения '.$allPok_0.' шт)</h2>
	<table class="stat_st"><tr class="zag">
	<td style="width : 25%">Курсы</td><td style="width : 75%">Популярность</td></tr>';
	$prskur_2 = array();
	foreach($allKurser as $oneKurser){
		$_colBye_1 = intval(get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Kurs='".$oneKurser["ID"]."' AND Status='0'")[0]["Qty"]);
		//$prskur_2 +=[ $oneKurser["ID"] => $_colBye_1 ];
		$prskur_2[$oneKurser["ID"]] = $_colBye_1;
	}
	$keymax_2 = MaxAssoc($prskur_2);
	foreach($allKurser as $oneKurser){
		$randcolor = Rand_Color($_color_bukv, 0, 12);
		$_colBye_2 = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Kurs='".$oneKurser["ID"]."' AND Status='0'")[0]["Qty"];
		$pewr = (intval($prskur_2[$keymax_2])>0) ? 100/intval($prskur_2[$keymax_2])*intval($_colBye_2) : 0;
		$body_text.='<tr class="stlb_c"><td style="width : 25%;">'.$oneKurser["Name"].'<br/>('.$_colBye_2.' заявок)</td><td style="width : 75%;"><div style="height:25px; width:'.$pewr.'%; background-color : '.$randcolor.';"></div></td></tr>';
	}
	$body_text.='<table><br/><br/><h2>Средняя успеваемость</h2><table class="stat_st"><tr class="zag">
	<td style="width : 25%">Логин<td><td style="width : 25%">Фамилия</td><td style="width : 25%">Имя</td><td style="width : 25%">Успеваемость</td></tr>';
	$allUsp = get_massiv_po_zaprosu($podkl, "SELECT AVG(Percent) as 'Sr', P.Login, P.Name, P.Family FROM test_result Tr INNER JOIN polzovatel P ON Student=P.Login GROUP BY P.Login");
	foreach($allUsp as $oneUsp){
		$body_text.= ('<tr class="zag"><td><a class="b" href="Report?Result='.$oneUsp["Login"].'">'.$oneUsp["Login"].'</a><td><td>'.$oneUsp["Family"].'</td><td>'.$oneUsp["Name"].'</td><td>'.intval($oneUsp["Sr"]).'%</td></tr>');
	}
	$body_text.='</table><br/><br/>';
	//----Deletetdededed users       SELECT AVG(Percent) as 'Sr', P.Login, P.Name, P.Family FROM test_result Tr INNER JOIN polzovatel P ON Student=P.Login
	$_all = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM otset_delete_user");
	$prs = array(
		'1' => get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM otset_delete_user WHERE Svoya='0' AND Prichina='Высокие цены'")[0]["Qty"],
		'2' => get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM otset_delete_user WHERE Svoya='0' AND Prichina='Мало полезного материала'")[0]["Qty"],
		'3' => get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM otset_delete_user WHERE Svoya='0' AND Prichina='Сложное управление сайтом'")[0]["Qty"],
		'4' => get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM otset_delete_user WHERE Svoya='1'")[0]["Qty"]
	);	
	$keymax = MaxAssoc($prs);
	$hs = array(
		'1' => ( $keymax == '1') ? 300 : (($prs[$keymax]==0) ? 300 : 300/intval($prs[$keymax])*intval($prs['1'])),
		'2' => ( $keymax == '2') ? 300 : (($prs[$keymax]==0) ? 300 : 300/intval($prs[$keymax])*intval($prs['2'])),
		'3' => ( $keymax == '3') ? 300 : (($prs[$keymax]==0) ? 300 : 300/intval($prs[$keymax])*intval($prs['3'])),
		'4' => ( $keymax == '4') ? 300 : (($prs[$keymax]==0) ? 300 : 300/intval($prs[$keymax])*intval($prs['4']))
	);	
	$body_text.='<h2>Удалившиеся подписчики (всего : '.$_all[0]["Qty"].')</h2>
	<table class="stat_st">
	<tr class="zag">
	<td style="width : 25%">'.$prs['1'].'шт ('.number_format((100/intval($_all[0]["Qty"])*$prs['1']),0, ' ', ' ').'%)</td>
	<td style="width : 25%">'.$prs['2'].'шт ('.number_format((100/intval($_all[0]["Qty"])*$prs['2']),0, ' ', ' ').'%)</td>
	<td style="width : 25%">'.$prs['3'].'шт ('.number_format((100/intval($_all[0]["Qty"])*$prs['3']),0, ' ', ' ').'%)</td>
	<td style="width : 25%">'.$prs['4'].'шт ('.number_format((100/intval($_all[0]["Qty"])*$prs['4']),0, ' ', ' ').'%)</td>
	</tr>
	<tr class="stlb_d" style="height:300px;">
	<td><div class="st" style="height : '.$hs['1'].'px; background-color : #ff0000;"><div></td>
	<td><div class="st" style="height : '.$hs['2'].'px; background-color : #ffff00;"><div></td>
	<td><div class="st" style="height : '.$hs['3'].'px; background-color : #ff00ff;"><div></td>
	<td><div class="st" style="height : '.$hs['4'].'px; background-color : #00ffff;"><div></td>
	</tr>
	<tr class="zag">
	<td>Высокие цены</td>
	<td>Мало полезного материала</td>
	<td>Сложное управление сайтом</td>
	<td><a class="b" href="Report?Pr_of_ud=1">Свой вариант</a></td>
	</tr></table>';
}
?>



<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Статистика сайта</title>
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
	$_Blok = array('FB_Blue', false, false);
	include "Kuski/Block.php";
	//---
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>