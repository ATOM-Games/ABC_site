<?php
	$_LsLSn; $_newNews="";
	$_Blok = array('FB_Blue', false, false);
	$errortext = array("Zag"=>"Название", "TXT"=>"Описание", "Ava"=>"Аватарка");
	$ercl = array("Zag"=>"Kr", "TXT"=>"Kr", "Ava"=>"Kr", "vi"=>"Kr");
	//if(isset($_POST["OtpiskaP"])) { add_po_zaprsu($podkl, "DELETE FROM podpiska_na_kategory_lesson WHERE ID_kategory=".$_POST["id"]." and Login_polzovatel='".$_POST["lg"]."'"); }
	//if(isset($_POST["PodpiskaP"])) { add_po_zaprsu($podkl, "INSERT INTO podpiska_na_kategory_lesson(ID_kategory, Login_polzovatel) VALUES ('".$_POST["id"]."', '".$_POST["lg"]."')"); }
	//if(isset($_POST["OtpiskaM"])) { add_po_zaprsu($podkl, "DELETE FROM podpiska_na_kategory_mail WHERE ID_kategory=".$_POST["id"]." and Login_polzovatelya='".$_POST["lg"]."'"); }
	//if(isset($_POST["PodpiskaM"])) { add_po_zaprsu($podkl, "INSERT INTO podpiska_na_kategory_mail(ID_kategory, Login_polzovatelya) VALUES ('".$_POST["id"]."', '".$_POST["lg"]."')"); }
	if(isset($_POST["newlesson"])){
		if(strlen($_POST["Zag"])==0){ $errortext["Zag"]="Напишите название"; $ercl["Zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите описание"; $ercl["TXT"] = "KrEr"; }
		$ava_naml = UpLoadFile($_FILES, 'Ava', 'resource/Avatars/Kurses/', array('image/jpg', 'image/png', 'image/gif', 'image/jpeg', 'image/bmp'));
		if($ava_naml==null && !empty($_FILES['Ava']['size'])) { $ercl["Ava"]= "KrEr"; }
		else { $pr .=(" Ava='".$ava_naml."',"); }
		
		$video='';
		$vnVideo = '';// = ($_POST["VnVideo"]) ? $_POST["vi"] : UpLoadFile($_FILES, 'vi', 'resource/Avatars/Kurses/', array());
		if(isset($_POST["VnVideo"])){
		    $vnVideo = $_POST["vi"];
		}else{
		    $video = UpLoadFile($_FILES, 'vi', 'resource/Avatars/Kurses/', array('video/mpeg4','video/mp4'));
		}
		
		if($video==null && !empty($_FILES['vi']['size'])) { $ercl["vi"]= "KrEr"; }
		if($ercl["Zag"]=="Kr" && $ercl["TXT"]=="Kr" && $ercl["Ava"] == "Kr"){
			add_po_zaprsu($podkl, "INSERT INTO oneleson(AvaYaUrok, Zagolovok, keywords, TXT, Kurs, Video, vnVideo, AvaNaVideo, Author) VALUES ('".$ava_naml."', '".$_POST["Zag"]."', '".$_POST["KeyWrld"]."', '".$_POST["TXT"]."', '".$_POST["Kur"]."','".$video."','".$vnVideo."','','".$_POST["Login"]."')");
			$_LsLSn = '<div style="text-align:center"><b style="color:#aa00aa;">Урок был успешно добавлен</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["reglesson"])){
		if(strlen($_POST["Zag"])==0){ $errortext["Zag"]="Напишите название"; $ercl["Zag"] = "KrEr"; }
		if(strlen($_POST["TXT"])==0){ $errortext["TXT"]="Напишите описание"; $ercl["TXT"] = "KrEr"; }
		$pr="";
		if(empty($_FILES['newAva']['size'])){
			if($_POST['delAva'] == "Удалено"){ $pr .=(" Ava='',"); }
		}else{
			$flnaml;
			if($_FILES['newAva']['size']>(5*1024*1024)){
				$errortext["Ava"] = "Неподходящий размер (слишком большой файл)"; $ercl["Ava"]="KrEr";
			}else{
				$fdptyle = array('image/jpg', 'image/png', 'image/gif', 'image/jpeg', 'image/bmp');
				$fname = getimagesize($_FILES['newAva']['tmp_name']);
				if(!in_array($fname['mime'], $fdptyle)) { 
					$errortext["Ava"] = "Картинка должна быть формата *.JPG, *.GIF, *.PNG и *.BMP"; $ercl["Ava"] = "KrEr";
				}else{
					$uploadDir = 'resource/Avatars/Profiles/';
					$fn = $_FILES['newAva']['name'];
					$name = $uploadDir.date('YmdHis')."Ava_ABC_hashCode".substr($fn, strpos($fn, '.'), strlen($fn)-1);
					$mov = move_uploaded_file($_FILES['newAva']['tmp_name'], $name);
					if($mov){
						$flnaml = stripcslashes(strip_tags(trim($name)));
						$pr .=(" Ava='".$flnaml."',");
					}else{
						$errortext["Ava"] = "Произошла ошибка при загрузке аватарки"; $ercl["Ava"] = "KrEr";
					}
				}
			}
		}
		
		if($ercl["Zag"]=="Kr" && $ercl["TXT"]=="Kr" && $ercl["Ava"]=="Kr"){
			add_po_zaprsu($podkl, "UPDATE oneleson SET ".$pr." Author='".$_POST["autor"]."', Zagolovok='".$_POST["Zag"]."', TXT='".$_POST["TXT"]."', Kurs='".$_POST["Kur"]."' WHERE ID=".$_POST["id"]);
			$_LsLSn = '<div style="text-align:center"><b style="color:#aa00aa;">Урок был успешно изменен</b></div><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST["dellesson"])){
		add_po_zaprsu($podkl, "DELETE From oneleson WHERE ID=".$_POST["id"]);
		$_LsLSn = '<div style="text-align:center"><b style="color:#aa00aa;">Урок был успешно удален</b></div><br/>';
	}
	if($_USER!=null){
		if(isset($_GET["NewLesson"])){
			$sp = "скопируйте сюда ссылку";
			$_newNews='<h1>Новый урок</h1>'.$_LsLSn.'<form method="post" action="" enctype="multipart/form-data">
			<input class="'.$ercl["Zag"].'" type="text" title="'.$errortext["Zag"].'" name="Zag" placeholder="'.$errortext["Zag"].'" autosave="ABCreferens" value="'.$_POST["Zag"].'"/>
			<input class="Kr" type="text" title="'.$errortext["KeyWrld"].'" name="KeyWrld" placeholder="Ключевые слова" autosave="ABCreferens" value="'.$_POST["KeyWrld"].'"/>
			<textarea class="'.$ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width : 100%" placeholder="'.$errortext["TXT"].'">'.$_POST["TXT"].'</textarea>
			<table style="width : 100%; text-align:center">
			<tr><td style="width:60%">
				<input type="file" name="vi" id="Videos_01" multiple accept=".avi, .mp4, .mpeg4, .3gp" class="'.$ercl["vi"].'" style="width : 100%; transition: 0.5s;"/>
			</td><td>
				<input type="checkbox" onchange="VV(\'VideoVneshn\',\'Videos_01\')" id="VideoVneshn" name="VnVideo"/> Внешний ресурс
			</td></tr></table>
			<table style="width : 100%"><input value="'.$_GET["Kur"].'" name="Kur" style="display:none"/><input value="'.$_USER["Login"].'" name="Login" style="display:none"/>
			<tr><td style="text-align : center">Аватарка</td><td><input class="'.$ercl["Ava"].'" type="file" title="'.$errortext["Ava"].'" name="Ava"/></td></tr>
			<tr><td width=50% style="text-align : center"> <input type="submit" name="newlesson" class="Kr" value="Создать урок"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>';
		}
		if(isset($_GET["RegLesson"])){
			$novka = get_massiv_po_zaprosu($podkl, "SELECT * From oneleson WHERE ID=".$_GET["RegLesson"]);
			$_newNews='<h1>Редактирование урока</h1>'.$_LsLSn.'<form method="post" action="" enctype="multipart/form-data">
			<input style="display:none" name="id" value="'.$novka[0]["ID"].'"/>
			<input style="display:none" name="autor" value="'.$novka[0]["Author"].'"/>
			<input style="display:none" name="Kur" value="'.$novka[0]["Kurs"].'"/>
			<input class="'.$ercl["Zag"].'" type="text" title="'.$errortext["Zag"].'" name="Zag" placeholder="'.$errortext["Zag"].'" autosave="ABCreferens" value="'.$novka[0]["Zagolovok"].'"/>
			<textarea class="'.$ercl["TXT"].'" title="'.$errortext["TXT"].'" name="TXT" rows=5 style="width:100%" placeholder="'.$errortext["TXT"].'">'.$novka[0]["TXT"].'</textarea>
			<table style="width : 100%">
			
			<tr><td class = "s" rowspan="2"><img src="'.(($novka[0]["AvaYaUrok"] && file_exists($novka[0]["AvaYaUrok"])) ? $novka[0]["AvaYaUrok"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" /></td>
			<td class = "t"><input type="text" readonly onmousedown="DelAva()" id="Ava_minib" class="Kr" value="Удалить" name="delAva"/></td></tr>
			<tr><td class = "t"><input class="'.$ercl["Ava"].'" type="file" title="Аватарка урока" name="newAva"/></td></tr>
			
			<tr><td width=50% style="text-align : center"> <input type="submit" name="reglesson" class="Kr" value="Изменить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>';
		}
		if(isset($_GET["DelLesson"])){
			$_Blok[0] = 'FB_Red';
			$_newNews='<h1>Удаление урока</h1>'.(($_LsLSn) ? $_LsLSn : '<div style="text-align:center">Вы удаляете курс. Вы уверены?</div>
			<form method="post" action="" ><table style="width : 100%"><input type="text" name="id" style="display:none" value="'.$_GET["DelLesson"].'"/>
			<tr><td width=50% style="text-align : center"> <input type="submit" name="dellesson" class="Kr" value="Удалить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form>');
		}
	}
	$_allkurs = get_massiv_po_zaprosu($podkl, "SELECT * From kurs");
	if(!isset($_GET["DelKours"]) && !isset($_GET["RegKours"]) && !isset($_GET["NewKours"]) && !isset($_GET["ID"])){
		$_LsLSn = get_massiv_po_zaprosu($podkl, "SELECT * From oneleson");
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Уроки</title>
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
	if(isset($_GET["ID"])){
		$_oneLesson = get_massiv_po_zaprosu($podkl, "SELECT * From oneleson WHERE ID=".$_GET["ID"]);
		$body_text = '<h1>'.$_oneLesson[0]["Zagolovok"].'</h1><br/>'.$_oneLesson[0]["TXT"].'<br/><br/>';
		if(!empty($_oneLesson[0]["Video"])){
			$body_text.='<video src="'.$_oneLesson[0]["Video"].'" class="tabl"'.((!empty($_oneLesson[0]["AvaNaVideo"])) ? 'poster="'.$_oneLesson[0]["AvaNaVideo"].'"' :'').' controls></video>';
		}
		if(!empty($_oneLesson[0]["vnVideo"])){
		    $body_text.='<iframe class="tabl" src="'.$_oneLesson[0]["vnVideo"].'" allowfullscreen></iframe>';
		}
		include "Kuski/Block.php";
	}else{
		if($_USER!=null && (isset($_GET["NewLesson"]) || isset($_GET["RegLesson"]) || isset($_GET["DelLesson"]))){
			$body_text = $_newNews;
			include "Kuski/Block.php";
		}else{
			foreach ($_allkurs as $onekurses){
				if($_USER["Doljnost"]=="владелец" || $_USER["Doljnost"]=="управляющий" || $_USER["Login"] == $onekurses["Author"]){
					$body_text = '<div style="text-align:center;"><form action="" method="get"><input value="'.$onekurses["ID"].'" name="Kur" style="display:none"/><input type="submit" title="Добавить в курс «'.$onekurses["Name"].'» новый урок" value="'.$onekurses["Name"].' ⧾" class="Kr" name="NewLesson"/></form></div>';
					foreach ($_LsLSn as $OneNew){
						if($OneNew["Kurs"]==$onekurses["ID"]){
						    $auto = get_pol_po_login($podkl, $OneNew["Author"]);
							$body_text .= ('<hr/><table><tr><td style="width:100px">
							<img src="'.(($OneNew["AvaYaUrok"] && file_exists($OneNew["AvaYaUrok"])) ? $OneNew["AvaYaUrok"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
							</td><td><a href="Lesson?ID='.$OneNew["ID"].'" class="b"><b>'.$OneNew["Zagolovok"].'</b></a> '.( ($_USER["Doljnost"]=="владелец" || ($_USER["Doljnost"]=="управляющий" && $auto["Doljnost"]!="владелец") || $_USER["Login"] == $OneNew["Author"]) ? ('<b><a href="Lesson?RegLesson='.$OneNew["ID"].'" style="color:green;" title="Редактировать"><pen></pen></a><a href="Lesson?DelLesson='.$OneNew["ID"].'" style="color:red" title="Удалить"><pen></pen></a></b>') : ('') ).'<br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден').'');
							$body_text .= ('<br/>'.$OneNew["TXT"].'</td></tr></table><hr/>');
						}
					}
					include "Kuski/Block.php";
				}
			}
		}
	}
	//---
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>