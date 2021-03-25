<?php
	$_KATS; $_newNews="";
	$_Blok = array('FB_Blue', false, false);
	$errortext = array("Zag"=>"Название", "TXT"=>"Описание");
	$ercl = array("Zag"=>"Kr", "TXT"=>"Kr");
	if(isset($_POST["OtpiskaP"])) { add_po_zaprsu($podkl, "DELETE FROM podpiska_na_kategory_lesson WHERE ID_kategory=".$_POST["id"]." and Login_polzovatel='".$_POST["lg"]."'"); }
	if(isset($_POST["PodpiskaP"])) { add_po_zaprsu($podkl, "INSERT INTO podpiska_na_kategory_lesson(ID_kategory, Login_polzovatel) VALUES ('".$_POST["id"]."', '".$_POST["lg"]."')"); }
	if(isset($_POST["OtpiskaM"])) { add_po_zaprsu($podkl, "DELETE FROM podpiska_na_kategory_mail WHERE ID_kategory=".$_POST["id"]." and Login_polzovatelya='".$_POST["lg"]."'"); }
	if(isset($_POST["PodpiskaM"])) { add_po_zaprsu($podkl, "INSERT INTO podpiska_na_kategory_mail(ID_kategory, Login_polzovatelya) VALUES ('".$_POST["id"]."', '".$_POST["lg"]."')"); }
	if(isset($_POST["newkat"])){
		if(strlen($_POST["Zag"])==0){ $errortext["Zag"]="Напишите название"; $ercl["Zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите описание"; $ercl["TXT"] = "KrEr"; }
		if($ercl["Zag"]=="Kr" && $ercl["TXT"]=="Kr"){
			add_po_zaprsu($podkl, "INSERT INTO kategories(Nazvanie, Author, Description) VALUES ('".$_POST["Zag"]."', '".$_POST["Login"]."', '".$_POST["TXT"]."')");
			$_KATS = '<div style="text-align:center"><b style="color:#aa00aa;">Категория была успешно добавлена</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["regkat"])){
		if(strlen($_POST["Zag"])==0){ $errortext["Zag"]="Напишите название"; $ercl["Zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите описание"; $ercl["TXT"] = "KrEr"; }
		if($ercl["Zag"]=="Kr" && $ercl["TXT"]=="Kr"){
			add_po_zaprsu($podkl, "UPDATE kategories SET Author='".$_POST["autor"]."', Nazvanie='".$_POST["Zag"]."', Description='".$_POST["TXT"]."' WHERE ID=".$_POST["id"]);
			$_KATS = '<div style="text-align:center"><b style="color:#aa00aa;">Категория была успешно изменена</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["delkat"])){
		add_po_zaprsu($podkl, "DELETE From kategories WHERE ID=".$_POST["id"]);
		$_KATS = '<div style="text-align:center"><b style="color:#aa00aa;">Категория была успешно удалена</b></div><br/>';
	}
	if($_USER!=null){
		if(isset($_GET["NewKats"])){
		$_newNews='<h1>Добавление категории</h1>'.$_KATS.'<form method="post" action="" >
			<input class="'.$ercl["Zag"].'" type="text" title="'.$errortext["Zag"].'" name="Zag" placeholder="'.$errortext["Zag"].'" autosave="ABCreferens" value="'.$_POST["Zag"].'"/>
			<textarea class="'.$ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width:100%" placeholder="'.$errortext["TXT"].'">'.$_POST["TXT"].'</textarea>
			<table style="width : 100%"><input value="'.$_USER["Login"].'" name="Login" style="display:none"/>
			<tr><td width=50% style="text-align : center"> <input type="submit" name="newkat" class="Kr" value="Отправить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>';
		}
		if(isset($_GET["RegKats"])){
			$novka = get_massiv_po_zaprosu($podkl, "SELECT * From kategories WHERE ID=".$_GET["RegKats"]);
			$_newNews='<h1>Редактирование категории</h1>'.$_KATS.'<form method="post" action="" >
			<input type="text" style="display:none" name="id" value="'.$novka[0]["ID"].'"/>
			<input type="text" style="display:none" name="autor" value="'.$novka[0]["Author"].'"/>
			<input class="'.$ercl["Zag"].'" type="text" title="'.$errortext["Zag"].'" name="Zag" placeholder="'.$errortext["Zag"].'" autosave="ABCreferens" value="'.$novka[0]["Nazvanie"].'"/>
			<textarea class="'.$ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width:100%" placeholder="'.$errortext["TXT"].'">'.$novka[0]["Description"].'</textarea>
			<table style="width : 100%">
			<tr><td width=50% style="text-align : center"> <input type="submit" name="regkat" class="Kr" value="Изменить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>';
		}
		if(isset($_GET["DelKats"])){
			$_Blok[0] = 'FB_Red';
			$_newNews='<h1>Удаление категории</h1>'.(($_KATS) ? $_KATS : '<div style="text-align:center">Вы удаляете категорию. Вы уверены?</div>
			<form method="post" action="" ><table style="width : 100%"><input type="text" name="id" style="display:none" value="'.$_GET["DelKats"].'"/>
			<tr><td width=50% style="text-align : center"> <input type="submit" name="delkat" class="Kr" value="Удалить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>');
		}
	}
	if(isset($_GET["ID"])){
		$_KATS = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM kategories WHERE ID=".$_GET["ID"]);
		if($_KATS!=null && Count($_KATS)>0){
			$_newNews = ""; 
			if($_USER!=null){
				$_newNews .= ('<table style="width:100%; text-align:center"><tr><td style="width:50%"><h1>'.$_KATS[0]["Nazvanie"].'</h1></td><td style="width:50%">');
				$_podps = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM podpiska_na_kategory_lesson WHERE ID_kategory=".$_KATS[0]["ID"]." AND Login_polzovatel='".$_USER["Login"]."'");
				$_podml = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM podpiska_na_kategory_mail WHERE ID_kategory=".$_KATS[0]["ID"]." AND Login_polzovatelya='".$_USER["Login"]."'");
				/*if($_podml!=null && Count($_podml)>0){
					$_newNews .=('<form method="post" action="" text-align:center><input name="id" value="'.$_KATS[0]["ID"].'" style="display:none" /><input name="lg" value="'.$_USER["Login"].'" style="display:none" /><input type="submit" class="Kr" value="Убрать оповещения" name="OtpiskaM"/></form>');
				}else{
					$_newNews .=('<form method="post" action="" text-align:center><input name="id" value="'.$_KATS[0]["ID"].'" style="display:none" /><input name="lg" value="'.$_USER["Login"].'" style="display:none" /><input type="submit" class="Kr" value="Получать оповещения" name="PodpiskaM"/></form>');
				}*/
				$_newNews .= ('</td></tr></table>');
			}else{
				$_newNews .= ('<h1>'.$_KATS[0]["Nazvanie"].'</h1>');
			}
			$_newNews .= ('<hr/>'.$_KATS[0]["Description"].'<hr/>');
			//---------------
			$_leski = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM kurs WHERE ID_kategory=".$_KATS[0]["ID"]);
			if($_leski!=null && Count($_leski)>0){
				foreach($_leski as $onekurs){
					$auto = get_pol_po_login($podkl, $onekurs["Author"]);
					$_newNews .= ('<table><tr><td style="width:100px">
					<img src="'.(($onekurs["Ava"] && file_exists($onekurs["Ava"])) ? $onekurs["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
					</td><td><b><a href="Kourses?ID='.$onekurs["ID"].'" class="b">'.$onekurs["Name"].'</a></b><br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'</a><br/>'.$onekurs["Description"].'');
					if($_USER!=null && $_USER["Doljnost"]=='ученик'){
						$_Buys = get_massiv_po_zaprosu($podkl, "SELECT * FROM buy_kurse WHERE Kurs=".$_KATS[0]["ID"]." AND Kto=".$_USER["Login"]);
						if($_Buys!=null && count($_Buys)>0){
							if($_Buys[0]["Status"]=='1'){
								$_newNews .=('<form method="post" action="" style="text-align : center; width : 240px;"><input name="id" value="'.$_KATS[0]["ID"].'" style="display:none" /><input name="lg" value="'.$_USER["Login"].'" style="display:none" /><input type="submit" class="Kr" value="Записан на курс" name="Zapiska"/></form>');
							}else{
								$_newNews .=('<form method="post" action="" style="text-align : center; width : 240px;"><input name="id" value="'.$_KATS[0]["ID"].'" style="display:none" /><input name="lg" value="'.$_USER["Login"].'" style="display:none" /><input type="submit" class="Kr" value="В ожидании подтверждения" name="Zapiska"/></form>');
							}
						}else{
							$_newNews .=('<form method="post" action="" style="text-align : center; width : 240px;"><input name="id" value="'.$_KATS[0]["ID"].'" style="display:none" /><input name="lg" value="'.$_USER["Login"].'" style="display:none" /><input type="submit" class="Kr" value="Записаться на курс" name="Otpiska"/></form>');
						}
					}
					$_newNews .= '</td></tr></table><hr/>';
				}
			}else{
				$_newNews .= ('<b>В данной категории нет курсов 😢😢😢😢</b>');
			}
			//---------------
		}else{
			$_newNews = '<h1>Такой категории нет</h1>'; $_Blok[0] = 'FB_Red';
		}
	}
	if(!isset($_GET["DelKats"]) && !isset($_GET["RegKats"]) && !isset($_GET["NewKats"]) && !isset($_GET["ID"])){
		$_KATS = get_obrat_massiv_po_zaprosu($podkl, "SELECT * From kategories");
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Категории</title>
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
	$body_text = "";
	if($_USER!=null && !isset($_GET["ID"]) && !isset($_GET["NewKats"]) && !isset($_GET["RegKats"]) && !isset($_GET["DelKats"]) ){
		$_KATS = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM kategories");
		if($_KATS!=null && count($_KATS)>0){
			foreach ($_KATS as $OneNew){
				$_Blok = array('FB_Blue', false, false);
				$auto = get_pol_po_login($podkl, $OneNew["Author"]);
				$body_text = '<table width=100%><tr><td width=30px></td><td><h1>'.$OneNew["Nazvanie"].'</h1></td>
				<td width=30px><h1>'.( ($_USER["Doljnost"]=="владелец" || ($_USER["Doljnost"]=="управляющий" && $auto["Doljnost"]!="владелец") || $_USER["Login"]==$OneNew["Author"] ) ? '<a href="Kategories?RegKats='.$OneNew["ID"].'" style="color:green;" title="Редактировать"><pen></pen></a><a href="Kategories?DelKats='.$OneNew["ID"].'" style="color:red" title="Удалить"><pen></pen></a>' : '' ).'</h1></td></tr></table>
				'.$OneNew["Description"].'<br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден').'';
				include "Kuski/Block.php";
			}
		}
	}else{
		$body_text = $_newNews;
		include "Kuski/Block.php";
	}
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>