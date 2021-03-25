<?php
	if(isset($_POST["Otk"]) || isset($_POST["Pri"])){
		if(isset($_POST["Pri"])) { add_po_zaprsu($podkl, "UPDATE polzovatel SET Doljnost='".$_POST["Dol"]."' WHERE Login='".$_POST["Log"]."'"); }
		add_po_zaprsu($podkl, "DELETE FROM zap_new_dolk WHERE ID='".$_POST["Idd"]."'");
		header("Location: Shtab"); exit();
	}
	$_Blok = array('FB_Blue', false, false);
	$body_text = '';
	if(isset($_GET["ID"])){
		$_zap = get_massiv_po_zaprosu($podkl, "SELECT * FROM zap_new_dolk WHERE ID='".$_GET["ID"]."'");
		$_pol = get_pol_po_login($podkl, $_zap[0]["LoginPol"]);
		$body_text = '<h1>Запрос на должность</h1>От пользователя : '.$_pol["Family"].' '.$_pol["Name"].'<hr/>На должность : "'.$_zap[0]["New_Dol"].'"<hr/>
		<form action="" method="POST"><input type="hidden" name="Idd" value="'.$_GET["ID"].'">
		<input type="hidden" name="Log" value="'.$_zap[0]["LoginPol"].'"><input type="hidden" name="Dol" value="'.$_zap[0]["New_Dol"].'">
		<table style="width:100%; text-align:center;"><tr><td style="width:50%"><input type="submit" name="Pri" value="Принять" class="Kr"/>
		</td><td style="width:50%"><input type="submit" name="Otk" value="Отклонить" class="Kr"/></td></tr>
		</table></form>';
	}else{
		$_upr = get_massiv_po_zaprosu($podkl, "SELECT * FROM polzovatel WHERE Doljnost = 'управляющий'");
		$_dir = get_massiv_po_zaprosu($podkl, "SELECT * FROM polzovatel WHERE Doljnost = 'директор'");
		$_kur = get_massiv_po_zaprosu($podkl, "SELECT * FROM polzovatel WHERE Doljnost = 'куратор'");
		$_uts = get_massiv_po_zaprosu($podkl, "SELECT * FROM polzovatel WHERE Doljnost = 'ученик'");
		$body_text = '<h1>Штаб</h1>
		<table><tr><td><b>Должность</b></td><td><b>Логин</b></td><td><b>Фамилия имя</b></td><td><b>Запрос на должность</b></td></tr>
		<tr><td><hr/></td><td><hr/></td><td><hr/></td><td><hr/></td></tr>
		<tr><td><b>Владелец</b></td><td>'.$_USER["Login"].'</td><td>'.$_USER["Family"].' '.$_USER["Name"].'</td><td></td></tr>
		<tr><td><hr/></td><td><hr/></td><td><hr/></td><td><hr/></td></tr>
		<tr><td><b>Управляющий</b></td><td>'.(($_upr!=null) ? ($_upr[0]["Login"]) : 'нет пользователя').'</td><td>'.(($_upr!=null) ? ($_upr[0]["Family"].' '.$_upr[0]["Name"]) : 'нет пользователя').'</td><td></td></tr>';
		$body_text .= '<tr><td><hr/></td><td><hr/></td><td><hr/></td><td><hr/></td></tr>';
		foreach ($_dir as $one_dir){
			$_znd = get_massiv_po_zaprosu($podkl, "SELECT * FROM zap_new_dolk WHERE LoginPol='".$one_dir["Login"]."'");
			$body_text .= '<tr><td><b>Директор</b></td><td>'.$one_dir["Login"].'</td><td>'.($one_dir["Family"].' '.$one_dir["Name"]).'</td>'.( (count($_znd)>0) ? '<td style="text-align:center"><a class="bl_bord" href="Shtab?ID='.$_znd[0]["ID"].'"> Запрос на должность" '.$_znd[0]["New_Dol"].' " </a>' : '<td>' ).'</td></tr>';
		}
		$body_text .= '<tr><td><hr/></td><td><hr/></td><td><hr/></td><td><hr/></td></tr>';
		foreach ($_kur as $one_kur){
			$_znd = get_massiv_po_zaprosu($podkl, "SELECT * FROM zap_new_dolk WHERE LoginPol='".$one_kur["Login"]."'");
			$body_text .= '<tr><td><b>Куратор</b></td><td>'.$one_kur["Login"].'</td><td>'.($one_kur["Family"].' '.$one_kur["Name"]).'</td>'.( (count($_znd)>0) ? '<td style="text-align:center"><a class="bl_bord" href="Shtab?ID='.$_znd[0]["ID"].'"> Запрос на должность" '.$_znd[0]["New_Dol"].' " </a>' : '<td>' ).'</td></tr>';
		}
		$body_text .= '</table><h1>Учебный состав</h1>
		<table><tr><td><b>Логин</b></td><td><b>Фамилия имя</b></td><td><b style="font-family : Wingdings" title="Подтвержденный"></b></td><td><b>Запрос на должность</b></td></tr>
		<tr><td><hr/></td><td><hr/></td><td><hr/></td><td><hr/></td></tr>';
		foreach ($_uts as $one_uts){
			$_znd = get_massiv_po_zaprosu($podkl, "SELECT * FROM zap_new_dolk WHERE LoginPol='".$one_uts["Login"]."'");
			$body_text .= '<tr><td>'.$one_uts["Login"].'</td><td>'.$one_uts["Family"].' '.$one_uts["Name"].'</td><td>'.(($one_uts["Podtverjden"]==0)?'<b style="color:red; font-family : Wingdings" title="не подтвержден"></b>':'<b style="color:#00ff00; font-family : Wingdings" title="подтвержден"></b>').'</td>'.( (count($_znd)>0) ? '<td style="text-align:center"><a class="bl_bord" href="Shtab?ID='.$_znd[0]["ID"].'"> Запрос на должность" '.$_znd[0]["New_Dol"].' " </a>' : '<td>' ).'</td></tr>';
		}
		$body_text .= '</table>';
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Штаб</title>
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
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>