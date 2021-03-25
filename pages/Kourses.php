<?php
	$_KOWrS=''; $_newNews="";
	$_Blok = array('FB_Blue', false, false);
	$errortext = array("zag"=>"Название", "TXT"=>"Описание", "Ava"=>"Аватарка");
	$_ercl = array("zag"=>"Kr", "TXT"=>"Kr", "Ava"=>"Kr");
	//if(isset($_POST["OtpiskaP"])) { add_po_zaprsu($podkl, "DELETE FROM podpiska_na_kategory_lesson WHERE ID_kategory=".$_POST["id"]." and Login_polzovatel='".$_POST["lg"]."'"); }
	//if(isset($_POST["PodpiskaP"])) { add_po_zaprsu($podkl, "INSERT INTO podpiska_na_kategory_lesson(ID_kategory, Login_polzovatel) VALUES ('".$_POST["id"]."', '".$_POST["lg"]."')"); }
	if(isset($_POST["Zapiska"])) { add_po_zaprsu($podkl, "INSERT INTO buy_kurse(Kto, Kurs, Status, Date) VALUES ('".$_POST["lg"]."', '".$_POST["id"]."', '0', NOW() )"); }
	if(isset($_POST["Otpiska"])) { add_po_zaprsu($podkl, "DELETE FROM buy_kurse WHERE Kto='".$_POST["lg"]."' AND Kurs='".$_POST["id"]."'"); }
	if(isset($_POST["newkours"])){
		if(strlen($_POST["zag"])==0){ $errortext["zag"]="Напишите название"; $_ercl["zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите описание"; $_ercl["TXT"] = "KrEr"; }
		$flnaml = UpLoadFile($_FILES, 'Ava', 'resource/Avatars/Kurses/', array('image/jpg', 'image/png', 'image/gif', 'image/jpeg', 'image/bmp'));
		if($flnaml == null && !empty($_FILES['Ava']['size'])) $_ercl["Ava"] = "KrEr";
		if($_ercl["zag"] == "Kr" && $_ercl["TXT"] == "Kr" && $_ercl["Ava"] == "Kr"){
			add_po_zaprsu($podkl, "INSERT INTO kurs(Ava, Name, Author, Description, ID_kategory) VALUES ('".$flnaml."', '".$_POST["zag"]."', '".$_POST["Login"]."', '".$_POST["TXT"]."', '".$_POST["newkat"]."')");
			$_KOWrS = '<div style="text-align:center"><b style="color:#aa00aa;">Курс был успешно добавлен</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["regkours"])){
		if(strlen($_POST["zag"])==0){ $errortext["zag"]="Напишите название"; $_ercl["zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите описание"; $_ercl["TXT"] = "KrEr"; }
		$pr="";
		if(empty($_FILES['newAva']['size'])){
			if($_POST['delAva'] == "Удалено"){ $pr .=(" Ava='',"); }
		}else{
			$flnaml  = UpLoadFile($_FILES, 'newAva', 'resource/Avatars/Kurses/', array('image/jpg', 'image/png', 'image/gif', 'image/jpeg', 'image/bmp'));;
			if($flnaml == null && !empty($_FILES['newAva']['size'])) $_ercl["Ava"] = "KrEr";
			else $pr .=(" Ava='".$flnaml."',");
		}
		if($_ercl["zag"] == "Kr" && $_ercl["TXT"] == "Kr" && $_ercl["Ava"] == "Kr"){
			add_po_zaprsu($podkl, "UPDATE kurs SET ".$pr." Author='".$_POST["autor"]."', Name='".$_POST["zag"]."', Description='".$_POST["TXT"]."', ID_kategory='".$_POST["newkat"]."' WHERE ID=".$_POST["id"]);
			$_KOWrS = '<div style="text-align:center"><b style="color:#aa00aa;">Новость была успешно изменена</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["delkours"])){
		add_po_zaprsu($podkl, "DELETE FROM kurs WHERE ID=".$_POST["id"]);
		$_KOWrS = '<div style="text-align:center"><b style="color:#aa00aa;">Новость была успешно удалена</b></div><br/>';
	}
	if($_USER != null){
		if($_USER["Doljnost"] != 'ученик') {
			if(isset($_GET["NewKours"])){
			$_newNews='<h1>Новый курс</h1>'.$_KOWrS.'<form method="post" action="" enctype="multipart/form-data">
				<input class="'.$_ercl["zag"].'" type="text" title="'.$errortext["zag"].'" name="zag" placeholder="'.$errortext["zag"].'" autosave="ABCreferens" value="'.$_POST["zag"].'"/>
				<textarea class="'.$_ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width : 100%" placeholder="'.$errortext["TXT"].'">'.$_POST["TXT"].'</textarea>
				<table style="width : 100%"><input value="'.$_USER["Login"].'" name="Login" style="display:none"/>
				<tr><td style="text-align : center">Аватарка</td>
				<td><input class="'.$_ercl["Ava"].'" type="file" title="'.$errortext["Ava"].'" name="Ava"/>
				</td></tr><tr><td style="text-align:center; color:#0011ff; font-weight : bold;">Категория</td><td>
					<select class="Kr" name ="newkat"><optgroup label = "Категория">';
					$kateaa = get_massiv_po_zaprosu($podkl, "SELECT * FROM kategories");
					foreach($kateaa as $onekateaa){
						if(isset($_GET["Kat"]) && $_GET["Kat"]==$onekateaa["ID"]){
							$_newNews.=('<option selected value="'.$onekateaa["ID"].'" title="'.$onekateaa["Description"].'">'.$onekateaa["Nazvanie"].'</option>');
						}else{
							$_newNews.=('<option value="'.$onekateaa["ID"].'" title="'.$onekateaa["Description"].'">'.$onekateaa["Nazvanie"].'</option>');
						}
					}
				$_newNews.='</select></td></tr>
				<tr><td width=50% style="text-align : center"> <input type="submit" name="newkours" class="Kr" value="Создать курс"/>
				</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
				</td></tr></table></form>';
			}
			if(isset($_GET["RegKours"])){
				$novka = get_massiv_po_zaprosu($podkl, "SELECT * From kurs WHERE ID=".$_GET["RegKours"]);
				$_newNews = '<h1>Редактирование курса</h1>'.$_KOWrS.'<form method="post" action="" enctype="multipart/form-data">
				<input style="display:none" name="id" value="'.$novka[0]["ID"].'"/>
				<input style="display:none" name="autor" value="'.$novka[0]["Author"].'"/>
				<input class="'.$_ercl["zag"].'" type="text" title="'.$errortext["zag"].'" name="zag" placeholder="'.$errortext["zag"].'" autosave="ABCreferens" value="'.$novka[0]["Name"].'"/>
				<textarea class="'.$_ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width:100%" placeholder="'.$errortext["TXT"].'">'.$novka[0]["Description"].'</textarea>
				<table style="width : 100%">
				<tr><td class = "s" rowspan="2"><img src="'.(($novka[0]["Ava"] && file_exists($novka[0]["Ava"])) ? $novka[0]["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" /></td>
				<td class = "t"><input type="text" readonly onmousedown="DelAva()" id="Ava_minib" class="Kr" value="Удалить" name="delAva"/></td></tr>
				<tr><td class = "t"><input class="'.$_ercl["Ava"].'" type="file" title="Аватарка курса" name="newAva"/></td></tr>
				<tr><td style="text-align:center; color:#0011ff; font-weight : bold;">Категория</td><td>
					<select class="Kr" name ="newkat"><optgroup label = "Категория">';
					$kateaa = get_massiv_po_zaprosu($podkl, "SELECT * From kategories");
					foreach($kateaa as $onekateaa){
						if($onekateaa["ID"]==$novka[0]["ID_kategory"]){
							$_newNews.=('<option selected value="'.$onekateaa["ID"].'" title="'.$onekateaa["Description"].'">'.$onekateaa["Nazvanie"].'</option>');
						}else{
							$_newNews.=('<option value="'.$onekateaa["ID"].'" title="'.$onekateaa["Description"].'">'.$onekateaa["Nazvanie"].'</option>');
						}
					}
				$_newNews.='</select></td></tr><tr><td width=50% style="text-align : center"> <input type="submit" name="regkours" class="Kr" value="Изменить"/>
				</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/></td></tr></table></form>';
			}
			if(isset($_GET["DelKours"])){
				$_Blok[0] = 'FB_Red';
				$_newNews='<h1>Удаление курса</h1>'.(($_KOWrS) ? $_KOWrS : '<div style="text-align:center">Вы удаляете курс. Вы уверены?</div>
				<form method="post" action="" ><table style="width : 100%"><input type="text" name="id" style="display:none" value="'.$_GET["DelKours"].'"/>
				<tr><td width=50% style="text-align : center"> <input type="submit" name="delkours" class="Kr" value="Удалить"/>
				</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
				</td></tr></table></form>');
			}
		}else{
			$_Blok[0] = 'FB_red';
			$_newNews='<h1 style="color:red;">Ошибка уровня доступа</h1>Функция редактирования курса доступна только преподавательскому составу, коем вы не являетесь.';
		}
	}
	if(isset($_GET["ID"])){
		$_Blok[0] = 'FB_blue';
		$_KOWrS = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM kurs WHERE ID=".$_GET["ID"]);
		if($_KOWrS!=null && Count($_KOWrS)>0){
			$_newNews = ""; 
			if($_USER!=null){
				$_newNews .= ('<table style="width:100%; text-align:center"><tr><td style="width:50%"><h1>'.$_KOWrS[0]["Name"].'</h1></td><td style="width:50%">');
				$_byu = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM buy_kurse WHERE Kurs=".$_KOWrS[0]["ID"]." AND Kto='".$_USER["Login"]."'");
				$_podml = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM podpiska_na_kategory_mail WHERE ID_kategory=".$_KOWrS[0]["ID"]." AND Login_polzovatelya='".$_USER["Login"]."'");
				/*if($_podml!=null && Count($_podml)>0){
					$_newNews .=('<form method="post" action="" text-align:center><input name="id" value="'.$_KOWrS[0]["ID"].'" type="hidden" /><input name="lg" value="'.$_USER["Login"].'" type="hidden" /><input type="submit" class="Kr" value="Убрать оповещения" name="OtpiskaM"/></form>');
				}else{
					$_newNews .=('<form method="post" action="" text-align:center><input name="id" value="'.$_KOWrS[0]["ID"].'" type="hidden" /><input name="lg" value="'.$_USER["Login"].'" type="hidden" /><input type="submit" class="Kr" value="Получать оповещения" name="PodpiskaM"/></form>');
				}*/
				$_newNews .= '<form method="POST" action=""><input name="id" value="'.$_KOWrS[0]["ID"].'" type="hidden" /><input name="lg" value="'.$_USER["Login"].'" type="hidden" />';
				if($_USER!=null && $_USER["Doljnost"]=='ученик'){
					if($_byu!=null && Count($_byu)>0){
						if($_byu[0]["Status"]=='1'){
							$_newNews .=('<input type="submit" class="Kr" value="Отписаться" name="Otpiska" />');
						}else{
							$_newNews .=('<input type="submit" class="Kr" value="В ожидании подтверждения, отозвать" name="Otpiska" />');
						}
					}else{
						$_newNews .=('<input type="submit" class="Kr" value="Записаться на курс" name="Zapiska" />');
					}
				}
				$_newNews .= ('</form></td></tr></table>');
			}else{
				$_newNews .= ('<h1>'.$_KOWrS[0]["Name"].'</h1>');
			}
			$_newNews .= ('<hr/>'.$_KOWrS[0]["Description"].'<hr/>');
			//---------------
			$_leski = get_massiv_po_zaprosu($podkl, "SELECT * FROM oneleson WHERE Kurs=".$_GET["ID"]);
			if($_leski!=null && Count($_leski)>0){
				foreach($_leski as $oneess){
					$auto = get_pol_po_login($podkl, $oneess["Author"]);
					$_newNews .= ('<table><tr><td style="width:100px">
					<img src="'.(($oneess["AvaYaUrok"] && file_exists($oneess["AvaYaUrok"])) ? $oneess["AvaYaUrok"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
					</td><td>');
					$_byu = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM buy_kurse WHERE Kurs=".$_KOWrS[0]["ID"]." AND Kto='".$_USER["Login"]."'");
					if($_USER!=null){
						if($_USER["Doljnost"]=='ученик'){
							if( $_byu!=null && Count($_byu)>0 && $_byu[0]["Status"]=='1'){
								$_newNews .= ('<a href="Lesson?ID='.$oneess["ID"].'" class="b"><b>'.$oneess["Zagolovok"].'</b> '.( ($_USER["Doljnost"]=="владелец" || ($_USER["Doljnost"]=="управляющий" && $auto["Doljnost"]!="владелец") || $_USER["Login"] == $oneess["Author"] ) ? (' <b><a href="Lesson?RegLesson='.$oneess["ID"].'" style="color:green;" title="Редактировать"><pen></pen></a><a href="Lesson?DelLesson='.$oneess["ID"].'" style="color:red" title="Удалить"><pen></pen></a></b>') : ('') ).'</a>');
							}else{
								$_newNews .= ('<b>'.$oneess["Zagolovok"].'</b>');
							}
						}else{
							$_newNews .= ('<a href="Lesson?ID='.$oneess["ID"].'" class="b"><b>'.$oneess["Zagolovok"].'</b> '.( ($_USER["Doljnost"]=="владелец" || ($_USER["Doljnost"]=="управляющий" && $auto["Doljnost"]!="владелец") || $_USER["Login"] == $oneess["Author"] ) ? (' <b><a href="Lesson?RegLesson='.$oneess["ID"].'" style="color:green;" title="Редактировать"><pen></pen></a><a href="Lesson?DelLesson='.$oneess["ID"].'" style="color:red" title="Удалить"><pen></pen></a></b>') : ('') ).'</a>');
						}
					}else{ $_newNews .= ('<b>'.$oneess["Zagolovok"].'</b>'); }
					
					/*
					if($_USER!=null && $_USER["Doljnost"]=='ученик' && $_byu!=null && Count($_byu)>0 && $_byu[0]["Status"]=='1'){
						$_newNews .= ('<a href="Lesson?ID='.$oneess["ID"].'" class="b"><b>'.$oneess["Zagolovok"].'</b></a>');
					}else if($_USER!=null && $_USER["Doljnost"]=='ученик' || $_USER==null){
						$_newNews .= ('<b>'.$oneess["Zagolovok"].'</b>');
					}
					if($_USER!=null && $_USER["Doljnost"]!='ученик'){
						$_newNews .= ('<a href="Lesson?ID='.$oneess["ID"].'" class="b"><b>'.$oneess["Zagolovok"].'</b> '.( ($_USER["Doljnost"]=="владелец" || ($_USER["Doljnost"]=="управляющий" && $auto["Doljnost"]!="владелец") || $_USER["Login"] == $oneess["Author"] ) ? (' <b><a href="Lesson?RegLesson='.$oneess["ID"].'" style="color:green;" title="Редактировать"><pen></pen></a><a href="Lesson?DelLesson='.$oneess["ID"].'" style="color:red" title="Удалить"><pen></pen></a></b>') : ('') ).'</a>');
					}*/
					$_newNews .=('<br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'</a>');
					$_newNews .= ('<br/>'.$oneess["TXT"].'</td></tr></table><hr/>');
				}
				$_newNews .= ('<form action="Tests" method="POST" style="text-align:center">
				<input type="hidden" value="'.$_GET["ID"].'" name="ID" />
				<input type="submit" value="Пройти тест" class="Kr" name="BEGINPROH" />
				</form>');
			}else{
				$_newNews .= ('<b>В данном курсе нет уроков 😢😢😢😢</b>');
			}
			//---------------
		}else{
			$_newNews = '<h1>Такого курса нет</h1>'; $_Blok[0] = 'FB_Red';
		}
	}
	$_allKat = get_massiv_po_zaprosu($podkl, "SELECT * FROM kategories");
	if(!isset($_GET["DelKours"]) && !isset($_GET["RegKours"]) && !isset($_GET["NewKours"]) && !isset($_GET["ID"])){
		$_KOWrS = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM kurs");
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Курсы</title>
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
	if($_USER!=null && !isset($_GET["ID"]) && !isset($_GET["NewKours"]) && !isset($_GET["RegKours"]) && !isset($_GET["DelKours"])){
		if($_allKat!=null && count($_allKat)>0){
			foreach ($_allKat as $onekat){
				$body_text = '<div style="text-align:center;"><form action="" method="get" name="NewKours"><input value="'.$onekat["ID"].'" name="Kat" style="display:none"/><input type="submit" title="Добавить в категорию «'.$onekat["Nazvanie"].'» новый курс" value="'.$onekat["Nazvanie"].' ⧾" class="Kr" name="NewKours"/></form></div>';
				foreach ($_KOWrS as $OneNew){
					if($OneNew["ID_kategory"]==$onekat["ID"]){
						$auto = get_pol_po_login($podkl, $OneNew["Author"]);
						$body_text .= ('<table><tr><td style="width:100px">
						<img src="'.(($OneNew["Ava"] && file_exists($OneNew["Ava"])) ? $OneNew["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
						</td><td><a href="Kourses?ID='.$OneNew["ID"].'" class="b"><b>'.$OneNew["Name"].'</a></b> '.( ($_USER["Doljnost"]=="владелец" || ($_USER["Doljnost"]=="управляющий" && $auto["Doljnost"]!="владелец") || $_USER["Login"] == $OneNew["Author"] ) ? ('<b><a href="Kourses?RegKours='.$OneNew["ID"].'" style="color:green;" title="Редактировать"><pen></pen></a><a href="Kourses?DelKours='.$OneNew["ID"].'" style="color:red" title="Удалить"><pen></pen></a></b>') : ('') ).'<br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден').'');
						$body_text .= ('<br/>'.$OneNew["Description"].'</td></tr></table><hr/>');
					}
				}
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