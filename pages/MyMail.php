<?php
if(isset($_POST["NemMes"])){
	add_po_zaprsu($podkl, "INSERT INTO `ak_ak_message`(`Ot_kogo`, `Komu`, `Time`, `TEXT`, `Looooooked`) VALUES ('".$_POST["otkogo"]."', '".$_POST["komu"]."', NOW(), '".$_POST["message"]."', '0')");
}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Сообщения</title>
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
	if($_USER!=null){
		if(isset($_GET["MailTo"])){
			$_allMeessa = get_massiv_po_zaprosu($podkl, "SELECT * FROM ak_ak_message WHERE (Ot_kogo='".$_USER["Login"]."' AND Komu='".$_GET["MailTo"]."') OR (Ot_kogo='".$_GET["MailTo"]."' AND Komu='".$_USER["Login"]."') ORDER BY ak_ak_message.`Time` DESC");
			if($_allMeessa!=null){
				foreach($_allMeessa as $_oneMess){
					$_Blok = array('FB_Blue', false, false);
					if( $_oneMess["Ot_kogo"] != $_USER["Login"]){
						$auto = get_pol_po_login($podkl, $_oneMess["Ot_kogo"]);
						if( $auto!=null ){
							$body_text = '<a href="Profile?ID='.$_oneMess["Ot_kogo"].'"><h2>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>'.$auto["Family"].' '.$auto["Name"].' ('.$auto["Doljnost"].')</b> <op>[NEW]</op>') : ($auto["Family"].' '.$auto["Name"].' ('.$auto["Doljnost"].')') ).'</h2></a>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>'.$_oneMess["TEXT"].'</b>') : ($_oneMess["TEXT"]) ).'<r_m>'.$_oneMess["Time"].'<r_m>';
						}else{
							$_Blok[0]='FB_Red';
							$body_text = '<h2>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>НЕИЗВЕСТНЫЙ ПОЛЬЗОВАТЕЛЬ</b> <op>[NEW]</op>') : ('НЕИЗВЕСТНЫЙ ПОЛЬЗОВАТЕЛЬ') ).'</a>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>'.$_oneMess["TEXT"].'</b>') : ($_oneMess["TEXT"]) ).'<r_m>'.$_oneMess["Time"].'<r_m>';
						}
						include "Kuski/Block.php";
					}
					if( $_oneMess["Komu"] != $_USER["Login"]){
						$auto = get_pol_po_login($podkl, $_oneMess["Komu"]);
						if( $auto!=null ){
							$body_text = '<div style="text-align : right; width : 100%;"><a href="Profile?ID='.$_oneMess["Ot_kogo"].'"><h3>[ Я ]</h3></a>'.$_oneMess["TEXT"].'</div><l_m>'.$_oneMess["Time"].'</l_m>';
						}else{
							$_Blok[0]='FB_Red';
							$body_text = '<div style="text-align : right; width : 100%;"><h2>НЕИЗВЕСТНЫЙ ПОЛЬЗОВАТЕЛЬ</h2></a>'.$_oneMess["TEXT"].'</div><l_m>'.$_oneMess["Time"].'</l_m>';
						}
						include "Kuski/Block.php";
					}
					if( $_oneMess["Komu"] == $_USER["Login"] && $_oneMess["Ot_kogo"] == $_USER["Login"]){
						$body_text = '<h2>Заметка (самому себе)</h2>'.$_oneMess["TEXT"].'<r_m>'.$_oneMess["Time"].'<r_m>';
						include "Kuski/Block.php";
					}
				}
				add_po_zaprsu($podkl, "UPDATE `ak_ak_message` SET `Looooooked`='1' WHERE Ot_kogo='".$_GET["MailTo"]."' AND Komu='".$_USER["Login"]."'");
			}
			$_allMeessa = get_massiv_po_zaprosu($podkl, "SELECT * FROM ak_ak_message WHERE (Ot_kogo='".$_USER["Login"]."' AND Komu='".$_USER["Login"]."') LIMIT 0,1");
			//-- сообщалка
			echo '<div style="height:150px"></div><div class="Block FB_Blue" style="position : fixed; left : calc(25% - 10px); bottom : 40px; width : 50%;">
			<form action="" method="post">
			<textarea class="Kr" title="Ваше сообщение" name="message" rows=3 style="width:100%" placeholder="Ваше сообщение"></textarea>
			<input type="hidden" value="'.$_GET["MailTo"].'" name="komu" />
			<input type="hidden" value="'.$_USER["Login"].'" name="otkogo" />
			<table style="width : 100%; text-align : center;">
			<tr><td width=50% style="text-align : center"> <input type="submit" name="NemMes" class="Kr" value="Отправить"/>
			</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
			</td></tr></table></form></div>';
		}else{
			$_allMeessa = get_massiv_po_zaprosu($podkl, "SELECT * FROM ak_ak_message WHERE Ot_kogo='".$_USER["Login"]."' OR Komu='".$_USER["Login"]."' ORDER BY ak_ak_message.`Time` DESC");
			if($_allMeessa!=null){
				$was = array();
				foreach($_allMeessa as $_oneMess){
					$_Blok = array('FB_Blue', false, false);
					if( $_oneMess["Ot_kogo"] != $_USER["Login"] && !in_array($_oneMess["Ot_kogo"], $was) ){ // - письма не от меня
						$was[] = $_oneMess["Ot_kogo"];
						$auto = get_pol_po_login($podkl, $_oneMess["Ot_kogo"]);
						if( $auto!=null ){
							$body_text = '<a href="MyMail?MailTo='.$_oneMess["Ot_kogo"].'"><h2>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>'.$auto["Family"].' '.$auto["Name"].' ('.$auto["Doljnost"].')</b> <op>[NEW]</op>') : ($auto["Family"].' '.$auto["Name"].' ('.$auto["Doljnost"].')') ).'</h2></a>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>'.$_oneMess["TEXT"].'</b>') : ($_oneMess["TEXT"]) );
						}else{
							$_Blok[0]='FB_Red';
							$body_text = '<a href="MyMail?MailTo='.$_oneMess["Ot_kogo"].'"><h2>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>НЕИЗВЕСТНЫЙ ПОЛЬЗОВАТЕЛЬ</b> <op>[NEW]</op>') : ('НЕИЗВЕСТНЫЙ ПОЛЬЗОВАТЕЛЬ') ).'</h2></a>'.( ($_oneMess["Looooooked"]=='0') ? ('<b>'.$_oneMess["TEXT"].'</b>') : ($_oneMess["TEXT"]) );
						}
						include "Kuski/Block.php";
					}
					if( $_oneMess["Komu"] != $_USER["Login"] && !in_array($_oneMess["Komu"], $was) ){  // - письма от меня
						$was[] = $_oneMess["Komu"];
						$auto = get_pol_po_login($podkl, $_oneMess["Komu"]);
						if( $auto!=null ){
							$body_text = '<a href="MyMail?MailTo='.$_oneMess["Komu"].'"><h2>'.$auto["Family"].' '.$auto["Name"].' ('.$auto["Doljnost"].')</h2></a>'.$_oneMess["TEXT"];
						}else{
							$_Blok[0]='FB_Red';
							$body_text = '<a href="MyMail?MailTo='.$_oneMess["Komu"].'"><h2>НЕИЗВЕСТНЫЙ ПОЛЬЗОВАТЕЛЬ</h2></a>'.$_oneMess["TEXT"];
						}
						include "Kuski/Block.php";
					}
				}
			}else{
				$_Blok = array('FB_Red', false, false);
				$body_text = '<h1>Увы</h1>Но мы не нашли ни одного письма... Похоже, что вам никто не пишет.';
				include_once "Kuski/Block.php";
			}
		}
	}else{
		$_Blok = array('FB_Red', false, false);
		$body_text = '<h1>Авторизуйтесь</h1>Переписки доступны только авторизованным пользователям!';
		include_once "Kuski/Block.php";
	}
	//---
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>