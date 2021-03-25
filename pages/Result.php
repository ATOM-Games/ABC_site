<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Результаты поиска</title>
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
	$body_text = '<h1>Результаты поиска</h1>';
	$_Blok = array('FB_Blue', false, false);
	$results = array();
	$_findslow = array();
	if(isset($_GET["Find"])) { if($_GET["Find"]!=null) { $_findslow = preg_split('/ /', $_GET["Find"]); } }
	if(isset($_GET["News"])) {// <- Новости
		$nes = get_massiv_po_zaprosu($podkl, "SELECT * FROM news");
		foreach($nes as $OneNew){
			$zag=preg_split('/ /', $OneNew["Zagolovok"]);
			$kyw=preg_split('/ /', $OneNew["keywords"]);
			$boool = false;
			if(count($_findslow)>0){
				for($f=0; $f<count($_findslow); $f++){
					for($z=0; $z<count($zag); $z++){
						if($zag[$z]==$_findslow[$f]){
							$boool=true; break;
						}
					}
					for($k=0; $k<count($kyw); $k++){
						if($kyw[$k]==$_findslow[$f]){
							$boool=true; break;
						}
					}
				}
			} else { $boool=true; }
			if($boool){
				$results[] = "<h2>(Новость) ".$OneNew["Zagolovok"]."</h2>";
			}
		}
	}
	if(isset($_GET["Mans"])) {// <- Люди
		$man = get_massiv_po_zaprosu($podkl, "SELECT * FROM polzovatel");
		foreach($man as $OneMan){
			$boool = false;
			if(count($_findslow)>0){
				for($f=0; $f<count($_findslow); $f++){
					if($OneMan["Login"]==$_findslow[$f]){ $boool=true; }
					if($OneMan["Family"]==$_findslow[$f]){ $boool=true; }
					if($OneMan["Name"]==$_findslow[$f]){ $boool=true; }
					if($OneMan["Ottestvo"]==$_findslow[$f]){ $boool=true; }
					if($OneMan["Doljnost"]==$_findslow[$f]){ $boool=true; }
				}
			} else { $boool=true; }
			if($boool){
				$results[] = '<table width = 100%><tr><td width=100px><img src="'.(($OneMan["Ava"] && file_exists($OneMan["Ava"])) ? $OneMan["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" /></td><td>
				<h2><a href="Profile?ID='.$OneMan["Login"].'">(Пользователь "'.$OneMan["Login"].'")</a><br/>'.$OneMan["Family"].' '.$OneMan["Name"].' '.$OneMan["Ottestvo"].'<br/>('.$OneMan["Doljnost"].')</h2></td></tr></table>';
			}
		}
	}
	if(isset($_GET["Kourse"])) {// <- Курсы
		$kur = get_massiv_po_zaprosu($podkl, "SELECT * FROM kurs");
		foreach($kur as $OneKur){
			$zag = preg_split('/ /', $OneKur["Name"]);
			$boool = false;
			if(count($_findslow)>0){
				for($f=0; $f<count($_findslow); $f++){
					if(in_array($_findslow[$f], $zag)) { $boool=true; }
				}
			} else { $boool=true; }
			if($boool){
				$auto = get_pol_po_login($podkl, $OneKur["Author"]);
				$results[] = '<table><tr><td style="width:100px">
				<img src="'.(($OneKur["Ava"] && file_exists($OneKur["Ava"])) ? $OneKur["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
				</td><td><b>(Курс) <a href="Kourses?ID='.$OneKur["ID"].'" class="b">'.$OneKur["Name"].'</a></b><br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'</a><br/>'.$OneKur["Description"].'</td></tr></table>';
			}
		}
	}
	if(isset($_GET["Urok"])) {// <- Уроки
		$les = get_massiv_po_zaprosu($podkl, "SELECT * FROM oneleson");
		foreach($les as $OneLes){
			$zag = preg_split('/ /', $OneLes["Zagolovok"]);
			$kye = preg_split('/ /', $OneLes["keywords"]);
			$boool = false;
			if(count($_findslow)>0){
				for($f=0; $f<count($_findslow); $f++){
					if(in_array($_findslow[$f], $zag)) { $boool=true; }
					if(in_array($_findslow[$f], $kye)) { $boool=true; }
				}
			} else { $boool=true; }
			if($boool){
				$auto = get_pol_po_login($podkl, $OneKur["Author"]);
				
				if($_USER!=null){
					if($_USER["Doljnost"]=='ученик'){
						$_byu = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM buy_kurse WHERE Kurs=".$OneLes["Kurs"]." AND Kto='".$_USER["Login"]."'");
						if( $_byu!=null && Count($_byu)>0 && $_byu[0]["Status"]=='1'){
							$results[] = '<table><tr><td style="width:100px"><img src="'.(($OneLes["AvaYaUrok"] && file_exists($OneLes["AvaYaUrok"])) ? $OneLes["AvaYaUrok"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
				</td><td><b>(Урок) <a href="Lesson?ID='.$OneLes["ID"].'" class="b">'.$OneLes["Zagolovok"].'</b> </a><br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'</a><br/>'.$OneLes["TXT"].'</td></tr></table>';
						}else{
							$results[] = '<table><tr><td style="width:100px"><img src="'.(($OneLes["AvaYaUrok"] && file_exists($OneLes["AvaYaUrok"])) ? $OneLes["AvaYaUrok"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
				</td><td><b>(Урок) '.$OneLes["Zagolovok"].'</b> <br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'</a><br/>'.$OneLes["TXT"].'</td></tr></table>';
						}
					}else{
						$results[] = '<table><tr><td style="width:100px"><img src="'.(($OneLes["AvaYaUrok"] && file_exists($OneLes["AvaYaUrok"])) ? $OneLes["AvaYaUrok"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
				</td><td><b>(Урок) <a href="Lesson?ID='.$OneLes["ID"].'" class="b">'.$OneLes["Zagolovok"].'</b> </a><br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'</a><br/>'.$OneLes["TXT"].'</td></tr></table>';
					}
				}else{ $results[] = '<table><tr><td style="width:100px"><img src="'.(($OneLes["AvaYaUrok"] && file_exists($OneLes["AvaYaUrok"])) ? $OneLes["AvaYaUrok"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" />
				</td><td><b>(Урок) '.$OneLes["Zagolovok"].'</b> <br/>Автор : '.( ($auto!=null) ? '<a href="Profile?ID='.$auto["Login"].'" class="b">'.$auto["Family"].' '.$auto["Name"].'</a>' : 'Пользователь не найден' ).'</a><br/>'.$OneLes["TXT"].'</td></tr></table>'; }
				
			
				
				
			}
		}
	}

	if(count($results)>0){
		//$body_text;
		if(count($results)%10==1 && (count($results)%100<11 || count($results)%100>14)){
			$body_text = "По Вашему запросу была найдена ".count($results)." запись";
		}else if( (count($results)%10>=2 && count($results)%10<=4) && (count($results)%100<11 || count($results)%100>14)){
			$body_text = "По Вашему запросу были найдены ".count($results)." записи";
		}else{
			$body_text = "По Вашему запросу было найдено ".count($results)." записей";
		}
		
		include "Kuski/Block.php";
		for($i=0; $i<count($results); $i++){
			$body_text = $results[$i];
			include "Kuski/Block.php";
		}
	}else{
		$body_text = "По Вашему запросу ничего не найдено";
		include "Kuski/Block.php";
	}
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>