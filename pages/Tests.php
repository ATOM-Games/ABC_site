<?php
	$err = array("BodyVopros"=>"Kr", "var_0"=>"Kr","var_1"=>"Kr","var_2"=>"Kr","var_3"=>"Kr","var_4"=>"Kr","var_5"=>"Kr","var_6"=>"Kr","var_7"=>"Kr","var_8"=>"Kr","var_9"=>"Kr");
	$errorText = '';
	if(isset($_POST["DElete"])){
		add_po_zaprsu($podkl, "DELETE FROM test_vopros WHERE ID='".$_POST["IDDD"]."'");
		header("Location: Tests?RedVod=All"); exit();
	}
	if(isset($_POST["AddVop"])){
		if(!isset($_POST["BodyVopros"]) || $_POST["BodyVopros"]==null) { $err["BodyVopros"]="KrEr"; $errorText.='Текст вопроса не должен быть пустой<br/>'; }
		if(!isset($_POST["pravotv"])) { $errorText.='Укажите правильный ответ<br/>'; }
		else{
			if(!isset($_POST[$_POST["pravotv"]]) || $_POST[$_POST["pravotv"]]==null){
				$err[$_POST["pravotv"]] = "KrEr";
				$errorText.='Если вы указали правильный ответ, напишите его тело<br/>';
			}
		}
		if($errorText==''){
			$ovtetv = ''.( ($_POST["var_0"]!=null) ? ($_POST["var_0"]) : ('') );
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_1"]!=null)?'¦':'').( ($_POST["var_1"]!=null) ? ($_POST["var_1"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_2"]!=null)?'¦':'').( ($_POST["var_2"]!=null) ? ($_POST["var_2"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_3"]!=null)?'¦':'').( ($_POST["var_3"]!=null) ? ($_POST["var_3"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_4"]!=null)?'¦':'').( ($_POST["var_4"]!=null) ? ($_POST["var_4"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_5"]!=null)?'¦':'').( ($_POST["var_5"]!=null) ? ($_POST["var_5"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_6"]!=null)?'¦':'').( ($_POST["var_6"]!=null) ? ($_POST["var_6"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_7"]!=null)?'¦':'').( ($_POST["var_7"]!=null) ? ($_POST["var_7"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_8"]!=null)?'¦':'').( ($_POST["var_8"]!=null) ? ($_POST["var_8"]) : ('') ));
			$ovtetv .= (( ($ovtetv != '' && $_POST["var_9"]!=null)?'¦':'').( ($_POST["var_9"]!=null) ? ($_POST["var_9"]) : ('') ));
			add_po_zaprsu($podkl, "INSERT INTO test_vopros(Kurs, Вопрос, Варианты_ответов, Правильный_ответ, Тип_ответа) VALUES ('".$_POST["Kurses"]."', '".$_POST["BodyVopros"]."', '".$ovtetv."', '".$_POST[$_POST["pravotv"]]."', '0')");
			header("Location: Tests?RedVod=All"); exit();
		}
	}
?>



<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Тест</title>
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
	
	
	if(isset($_GET["RedVod"])){
		if($_USER && $_USER["Doljnost"]!='ученик'){
			if($_GET["RedVod"]=='All'){
				$Voproses = get_obrat_massiv_po_zaprosu($podkl, "SELECT tv.ID as 'IDtv', tv.Вопрос, tv.Варианты_ответов, tv.Правильный_ответ, tv.Тип_ответа, K.Name FROM test_vopros tv INNER JOIN kurs K ON K.ID=tv.Kurs ORDER BY `K`.`ID` DESC");
				echo '<form action="" method="GET" style="text-align : center; width : 100%;"><input type="submit" name="RedVod" value="Новый вопрос" class="Kr"/></form>';
				foreach($Voproses as $oneVop){
					$body_txt = '<article class = "Block FB_Blue"><h2>'.$oneVop["Name"].' <a href="Tests?RedVod=Del_0'.$oneVop["IDtv"].'" style="color:red" title="Удалить"><pen></pen></a></h2>'.$oneVop["Вопрос"].'<br/><br/>';
					$otvets = preg_split('/¦/', $oneVop["Варианты_ответов"]);
					foreach($otvets as $one){ $body_txt .= ( (($one==$oneVop["Правильный_ответ"])?('<b>'.$one.'</b>'):($one)).'<br/>'); }
					$body_txt .= '</article>';
					echo $body_txt;
				}
			}
			if(preg_match('/Del_0/',$_GET["RedVod"])){
				//substr($fn, str($fn, '.'), strlen($fn)-1);
				$body_txt = '<article class = "Block FB_Red">
				<h1>Удалить вопрос из теста</h1>Вы уверены, что хотите удалить вопрос из теста?
				<form action="" method="post" style="width:100%; text-align:center">
				<input type="hidden" value="'.intval(substr($_GET["RedVod"], strpos($_GET["RedVod"], '0'), strlen($_GET["RedVod"]))).'" name="IDDD"/>
				<input type="submit" class="Kr" value="Удалить" name="DElete"/>
				</form></article>';
				echo $body_txt;
			}
			if($_GET["RedVod"]=='Новый вопрос'){
				$body_txt = '<article class = "Block '.( ($errorText=='') ? 'FB_Blue' : 'FB_Red' ).'">
				<h1>Новый вопрос</h1><form action="" method="post" style="width:100%; text-align:center">
				<textarea class="'.$err["BodyVopros"].'" title="Вопрос" name="BodyVopros" rows=3 style="width:100%" placeholder="'.( ($err["BodyVopros"]=="Kr")?'Текст вопроса':'Напишите текст вопроса!' ).'">'.$_POST["BodyVopros"].'</textarea><table style="width : 100%;">
				<tr><td><input type="text" name="var_0" class="'.$err["var_0"].'" placeholder="'.(($err["var_0"]=="Kr")?'Вариант ответа 1':'Укажите тело правильного ответа').'" value="'.$_POST["var_0"].'"/></td><td><input type="radio" name="pravotv" value="var_0"></td></tr>
				<tr><td><input type="text" name="var_1" class="'.$err["var_1"].'" placeholder="'.(($err["var_1"]=="Kr")?'Вариант ответа 2':'Укажите тело правильного ответа').'" value="'.$_POST["var_1"].'"/></td><td><input type="radio" name="pravotv" value="var_1"></td></tr>
				<tr><td><input type="text" name="var_2" class="'.$err["var_2"].'" placeholder="'.(($err["var_2"]=="Kr")?'Вариант ответа 3':'Укажите тело правильного ответа').'" value="'.$_POST["var_2"].'"/></td><td><input type="radio" name="pravotv" value="var_2"></td></tr>
				<tr><td><input type="text" name="var_3" class="'.$err["var_3"].'" placeholder="'.(($err["var_3"]=="Kr")?'Вариант ответа 4':'Укажите тело правильного ответа').'" value="'.$_POST["var_3"].'"/></td><td><input type="radio" name="pravotv" value="var_3"></td></tr>
				<tr><td><input type="text" name="var_4" class="'.$err["var_4"].'" placeholder="'.(($err["var_4"]=="Kr")?'Вариант ответа 5':'Укажите тело правильного ответа').'" value="'.$_POST["var_4"].'"/></td><td><input type="radio" name="pravotv" value="var_4"></td></tr>
				<tr><td><input type="text" name="var_5" class="'.$err["var_5"].'" placeholder="'.(($err["var_5"]=="Kr")?'Вариант ответа 6':'Укажите тело правильного ответа').'" value="'.$_POST["var_5"].'"/></td><td><input type="radio" name="pravotv" value="var_5"></td></tr>
				<tr><td><input type="text" name="var_6" class="'.$err["var_6"].'" placeholder="'.(($err["var_6"]=="Kr")?'Вариант ответа 7':'Укажите тело правильного ответа').'" value="'.$_POST["var_6"].'"/></td><td><input type="radio" name="pravotv" value="var_6"></td></tr>
				<tr><td><input type="text" name="var_7" class="'.$err["var_7"].'" placeholder="'.(($err["var_7"]=="Kr")?'Вариант ответа 8':'Укажите тело правильного ответа').'" value="'.$_POST["var_7"].'"/></td><td><input type="radio" name="pravotv" value="var_7"></td></tr>
				<tr><td><input type="text" name="var_8" class="'.$err["var_8"].'" placeholder="'.(($err["var_8"]=="Kr")?'Вариант ответа 9':'Укажите тело правильного ответа').'" value="'.$_POST["var_8"].'"/></td><td><input type="radio" name="pravotv" value="var_8"></td></tr>
				<tr><td><input type="text" name="var_9" class="'.$err["var_9"].'" placeholder="'.(($err["var_9"]=="Kr")?'Вариант ответа 10':'Укажите тело правильного ответа').'" value="'.$_POST["var_9"].'"/></td><td><input type="radio" name="pravotv" value="var_9"></td></tr>
				</table><select class="Kr" name ="Kurses"><optgroup label = "Курсы">';
				$alKurs = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM kurs");
				foreach($alKurs as $onKure){
					if($errorText!='' && $_POST["Kurses"]==$onKure["ID"]){
						$body_txt .=('<option selected value="'.$onKure["ID"].'">'.$onKure["Name"].'</option>');
					}else{
						$body_txt .=('<option value="'.$onKure["ID"].'">'.$onKure["Name"].'</option>');
					}
				}
				$body_txt .='</select><b style="color:red">'.$errorText.'</b>
				<input type="submit" class="Kr" name="AddVop" value="Создать вопрос"/>
				</article>';
				echo $body_txt;
			}
		}else{
			$body_txt = '<article class = "Block FB_Red">
			<h1>Ошибка уровня доступа</h1>Раздел редактирования тестовых вопросов доступен только '.( ($_USER)?'управляющему или преподавательскому составу':'авторизованным пользователям' ).'</article>';
			echo $body_txt;
		}
	}else{
		if(isset($_POST["PROH"])){
			if(isset($_POST["start"])){
				$Voproses = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM test_vopros WHERE Kurs='".$_POST["ID"]."' ORDER BY RAND() LIMIT ".$_POST["MAXotv"]);
				$num=1;
				echo '<form action="" method="POST"><input type="hidden" value="'.$_POST["ID"].'" name="ID_kurs"/><input type="hidden" value="'.$_USER["Login"].'" name="ID_login"/>';
				$str = '';
				foreach($Voproses as $oneVop){
					$body_txt = '<article class = "Block FB_Blue">
					<h1>Вопрос '.($num).'</h1>'.$oneVop["Вопрос"].'<hr/>';
					$otvets = preg_split('/¦/', $oneVop["Варианты_ответов"]);
					foreach($otvets as $one){ $body_txt .= ('<input type="radio" name="var_otv_'.$oneVop["ID"].'" value="'.$one.'"> '.$one.'<br/>'); }
					$body_txt .= '</article>';
					echo $body_txt;
					$str.=($oneVop["ID"]);
					if(count($Voproses)>$num) $str.='¦';
					$num++;
				}
				echo '<article class = "Block FB_Blue" style="text-align:center"><input type="hidden" value="'.$str.'" name="IdSn"/><input type="submit" value="Проверить тест" name="Prov" class="Kr"/></article>';
			}
		}
		if(isset($_POST["Prov"])){
				$MyOtv=0;
				$num=1;
				$IdSn = preg_split('/¦/', $_POST["IdSn"]);
				foreach($IdSn as $Id){
					$cvet = 'FB_Blue';
					if($Id!=null){
						$OneVop = get_obrat_massiv_po_zaprosu($podkl, "SELECT * FROM test_vopros WHERE ID='".$Id."'");
						if(isset($_POST["var_otv_".$Id]) && $_POST["var_otv_".$Id]==$OneVop[0]["Правильный_ответ"]){
							$MyOtv++;
						}else{
							$cvet = 'FB_Red';
						}
						$body_txt = '<article class = "Block '.$cvet.'">
						<h1>Вопрос '.($num).'</h1>'.$OneVop[0]["Вопрос"].'<hr/>';
						$otvets = preg_split('/¦/', $OneVop[0]["Варианты_ответов"]);
						foreach($otvets as $one){
							$body_txt .= (''.$one.' ');
							if(isset($_POST["var_otv_".$Id]) && $_POST["var_otv_".$Id]==$one){
								$body_txt .= ( ($cvet=='FB_Red') ? ('<pen style="color:red"></pen>') : ('<pen style="color:green"></pen>') );
							}
							$body_txt .= '<br/>';
						}
						$body_txt .= '</article>';
						echo $body_txt;
						$num++;
					}
				}
				$procent = number_format((100/intval(count($IdSn))*intval($MyOtv)),0, ' ', ' ');
				add_po_zaprsu($podkl, "INSERT INTO test_result(Kurs, Student, Data, MAXotv, RIGHTotv, Percent) VALUES ('".$_POST["ID_kurs"]."', '".$_POST["ID_login"]."', NOW(), '".(count($IdSn))."', '".$MyOtv."', '".$procent."')");
				echo '<article class = "Block FB_Blue"><h1>Ваш результат ( '.$MyOtv.' / '.(count($IdSn)).' ) [ '.$procent.'% ]</h1></article>';
			}
		
		if(isset($_POST["BEGINPROH"])){
			$_Blok = array('FB_Blue', false, false);
			$kurs = get_massiv_po_zaprosu($podkl, "SELECT * FROM kurs WHERE ID='".$_POST["ID"]."'");
			$auto = get_pol_po_login($podkl, $kurs[0]["Author"]);
			$AllVop = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM test_vopros WHERE Kurs='".$_POST["ID"]."'");
			$body_text = '<h1>Добро пожаловать</h1>Здравствуйте, '.$_USER["Family"].' '.$_USER["Name"].', вы хотите начать тестирование по курсу "'.$kurs[0]["Name"].'" 
			<br/>ВНИМАНИЕ : пропущенные вопросы считаются за неправильные!<br/><br/>';
			if($AllVop[0]["Qty"]!='0'){
				$body_text .= ('<form method="POST" action="" style="text-align : center">
				<b>Введите количество вопросов<b>
				<input type="number" min=1 max='.$AllVop[0]["Qty"].' class="Kr" name="MAXotv" value="1"/>
				<input type="hidden" value="Старт" name="start" />
				<input type="hidden" value="'.$_POST["ID"].'" name="ID" />
				<input type="submit" class="Kr" value="Начать тест" name="PROH" /></form>');
			}else{
				$_Blok[0] = 'FB_Red';
				$body_text .= '<b style="color:red">УВЫ!.. Но данный курс пока не содержит тестов. '.( ($auto) ? ('Вы можете <a href="MyMail?MailTo='.$auto["Login"].'">написать автору</a> данного курса и сообщить ему об этом.') : ('Автор данного теста по каким-то причинам отсутствует, но вы можете написать высшему руководству') ).'</b>';
			}
			include "Kuski/Block.php";
		}
	}
	//---
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
</body></html>