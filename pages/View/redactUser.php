<?php
	$sanq = "";
	if(isset($_POST["otozv"])){
		add_po_zaprsu($podkl, "DELETE FROM zap_new_dolk WHERE LoginPol='".$_USER["Login"]."'");
	}
	
	if(isset($_POST["pdt"])){
		$otkogo = htmlspecialchars("silatrotila0atom@gmail.com");
		$komu = htmlspecialchars($_USER["Email"]);
		$tema = htmlspecialchars("Подтверждение аккаунта на ABC.com");
		$message = htmlspecialchars('Доброго времени суток, уважаемый(ая) '.$_USER["Family"].' '.$_USER["Name"].'. Вы создали аккаунт на нашем сайте, теперь вам необходимо его подтвердить. Вот ссылка для подтверждения: http://webmvc/Profile?PostReg='.$_USER["Login"].'');
		$tema = "=?utf-8?B?".base64_encode($tema)."?=";
		$headers="From: $otkogo\r\nReply-to: $komu\r\nContent-type: text/plain; charset=utf-8\r\n";
		mail($komu, $tema, $message, $headers);
		$sanq = '<b style="color:#aa00aa">Письмо на ваш почтовый ящик ('.$_USER["Email"].') уже отправлен. Для активации акккаунта пройдите по ссылке в письме. Если письма нет, подождите несколько минут, либо проверьте раздел «Спам»</b>';
	}
	$_Blok = array('FB_Blue', false, false);
	$_polya = array("Mal" => "Изменить", "Ava" => "Новая");
	$_errs = array("Mal" => "Kr", "Ava" => "Kr");
	if(isset($_POST["save"])){
		$zapros = "UPDATE polzovatel SET ";
		$pr="";
		if(strlen($_POST['newpass'])>0 && $_USER['Password'] != $_POST['newpass']){
			$pr .=(" Password='".$_POST['newpass']."',");//,`Podtverjden`=[value-3],`Family`=[value-4],`Name`=[value-5],`Ottestvo`=[value-6],`Email`=[value-7],`Doljnost`=[value-8] WHERE 1";
		}
		if(empty($_FILES['newAva']['size'])){
			if($_POST['delAva'] == "Удалено"){ $pr .=(" Ava='',"); }
		}else{
			$flnaml = UpLoadFile($_FILES, 'newAva', 'resource/Avatars/Profiles/', array('image/jpg', 'image/png', 'image/gif', 'image/jpeg', 'image/bmp'));
			if($flnaml==null && !empty($_FILES['newAva']['size'])) $_errs["Ava"]= "KrEr";
			else $pr .=(" Ava='".$flnaml."',");
		}
		
		if(strlen($_POST['newfam'])>0 && $_USER['Family'] != $_POST['newfam']){
			$pr .=(" Family='".$_POST['newfam']."',");
		}
		if(strlen($_POST['newnam'])>0 && $_USER['Name'] != $_POST['newnam']){
			$pr .=(" Name='".$_POST['newnam']."',");
		}
		if(strlen($_POST['newott'])>0 && $_USER['Ottestvo'] != $_POST['newott']){
			$pr .=(" Ottestvo='".$_POST['newott']."',");
		}
		if($_USER['Doljnost'] != $_POST['newdol']){
			//$pr .=(" Doljnost='".$_POST['newdol']."',");
			add_po_zaprsu($podkl, "INSERT INTO zap_new_dolk(LoginPol, New_Dol) VALUES ('".$_USER["Login"]."', '".$_POST['newdol']."')");
		}
		if(strlen($_POST['newmal'])>0 && $_USER['Email'] != $_POST['newmal']){
			if(!preg_match('/@/', $_POST['newmal'])){
				$_polya["Mal"] = "Новый Email некорректный"; $_errs["Mal"]="KrEr";
				$_Blok[0] = 'FB_Red';
			}else{
				$pr .=(" Email='".$_POST['newmal']."', Podtverjden=0 ");
			}
		}
		//if(strlen($_POST['newott'])>0)
		
		for($i=0; $i<strlen($pr)-1; $i++) { $zapros .=$pr[$i]; }
		$zapros .= (" WHERE Login='".$_USER["Login"]."'");
		if($_errs["Mal"] == "Kr" && $_errs["Ava"] == "Kr" && (strlen($_POST['newpass'])>0 || strlen($_POST['newfam'])>0 || $_POST['delAva']=="Удалено" || strlen($_POST['newnam'])>0 || strlen($_POST['newott'])>0 || strlen($_POST['newmal'])>0 || $_USER['Doljnost'] != $_POST['newdol'] || !empty($_FILES['newAva']['size'])) ){
			add_po_zaprsu($podkl, $zapros);
			$_USER = (isset($_COOKIE["userlogin"]) && $_COOKIE["userlogin"]!=null)? get_pol_po_login($podkl, $_COOKIE["userlogin"]) : null;
			$sanq .= '<b style="color:#aa00aa">Данные успешно изменены</b>';
		}
	}
	$_page_title = 'Редактирование профиля';
	$body_text = '<h1>Редактирование профиля</h1>'.$sanq;
	$psss = "";
	for($i=0; $i<strlen($_USER["Password"]); $i++) { $psss.=( ($i%2==1) ? '⌧' : $_USER["Password"][$i] ); }
	$estvladelec = get_massiv_po_zaprosu($podkl, "SELECT * From polzovatel WHERE Doljnost='владелец'");
	$estupravlay = get_massiv_po_zaprosu($podkl, "SELECT * From polzovatel WHERE Doljnost='управляющий'");
	$vava = $_USER["Ava"];
	$_qwe = get_massiv_po_zaprosu($podkl, "SELECT * FROM zap_new_dolk WHERE LoginPol='".$_USER["Login"]."'");
	$body_text.='<form method="post" action="PasswordEdit"><table class="tabl">
		<tr><td class = "f">Логин</td><td class = "s">'.$_USER["Login"].'</td><td class = "t"><input type="text" class="Kr" disabled placeholder="Не меняется"/></td></tr>
		<tr><td class = "f">Пароль</td><td class = "s">'.$psss.'</td><td class = "t">
		<div class="nv"><input type="text" value="'.htmlspecialchars($_USER["Login"]).'" name="userlog" /><input type="text" value="edit" name="log"/></div>
		<input type="submit" name="editpas" class="Kr" value="Изменить пароль"/>
		</td></tr></table></form>
		<form method="post" action="" enctype="multipart/form-data"><table class="tabl">
		<tr><td class = "f" rowspan="2"><img src="'.(($_USER["Ava"] && file_exists($_USER["Ava"])) ? $_USER["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava_mini" /></td>
		<td class = "s">Удалить аватарку</td><td class = "t"><input type="text" readonly onmousedown="DelAva()" id="Ava_minib" class="Kr" value="Удалить" name="delAva"/></td></tr>
		<tr><td class = "t" colspan="2"><input class="'.$_errs["Ava"].'" type="file" title="Аватарка польователя" name="newAva"/></td></tr>
		<tr><td class = "f">Фамилия</td><td class = "s">'.$_USER["Family"].'</td><td class = "t"><input type="text" name="newfam" class="Kr" placeholder="Изменить" value="'.$_POST["newfam"].'"/></td></tr>
		<tr><td class = "f">Имя</td><td class = "s">'.$_USER["Name"].'</td><td class = "t"><input type="text" name="newnam" class="Kr" placeholder="Изменить" value="'.$_POST["newnam"].'"/></td></tr>
		<tr><td class = "f">Отчество</td><td class = "s">'.$_USER["Ottestvo"].'</td><td class = "t"><input type="text" name="newott" class="Kr" placeholder="Изменить" value="'.$_POST["newott"].'"/></td></tr>
		<tr><td class = "f">Должность</td>
		'.( (count($_qwe)>0) ? '<td class = "s"><b>'.$_USER["Doljnost"].'</b> <b style="color:#aa00aa">('.$_qwe[0]["New_Dol"].') В ожидании подтверждения</b></td><td class = "t"><input type="submit" name="otozv" class="Kr" value="Отозвать"/>' : '<td class = "s">'.$_USER["Doljnost"].'</td><td class = "t"><select class="Kr" name ="newdol"><optgroup label = "Должность">
		<option value = "ученик" title="Может просматривать уроки, задавать интересующие вопросы кураторам, писать в обсуждениях">ученик</option>
		<option '.(($_USER["Doljnost"]=='куратор')?'selected':'').' value = "куратор" title="Может редактировать отдельные уроки, тесты своего курса">куратор</option>
		<option '.(($_USER["Doljnost"]=='директор')?'selected':'').' value = "директор" title="Может редактировать отдельный курс, так и добавлять еще">директор</option>
		<option '.(($_USER["Doljnost"]=='управляющий')?'selected':'').' '.( (count($estupravlay)>0 && $_USER["Doljnost"]!="управляющий") ? ' disabled title="уже имеется"' : 'title="Может редактировать все имеющиеся курсы"' ).' value = "управляющий">управляющий</option>
		<option '.(($_USER["Doljnost"]=='владелец')?'selected':'').' '.( (count($estvladelec)>0 && $_USER["Doljnost"]!="владелец") ? ' disabled title="уже имеется"' : ' title="Имеет неограниченные возможности в управлении данного ресурса"' ).' value = "владелец">владелец</option>
		</select>').'</td></tr>
		<tr><td class = "f">Email</td><td class = "s">'.$_USER["Email"].'</td><td class = "t"><input type="mail" name="newmal" class="'.$_errs["Mal"].'" placeholder="'.$_polya["Mal"].'" value="'.$_POST["newmal"].'"/></td></tr></form>
		<tr><td class = "f">Подтверждение</td><td class = "s">'.(($_USER["Podtverjden"]) ? '<b style="color:#00ff00; font-family : Wingdings" title="подтвержден"></b> Подтвержден</td><td class = "t"><input type="submit" name="rgr" disabled class="Kr" value="Уже подтвержден"/></td>' : '<b style="color:red; font-family : Wingdings" title="не подтвержден"></b> Не подтвержден </td><td class = "t"><input type="submit" name="pdt" class="Kr"value="Подтвердить"/></td>').'</tr>
		<tr><td></td><td><input type="submit" name="save" class="Kr" value="Сохранить"/></td><td></td></tr>
	</table></form>
	<div style="width : 80%; height : 300px; position : absolute; top : 150px; left : 10%; border : 2px solid #065f92; border-radius : 10px; background-color : #6da4bb; box-shadow: 0 0 0px #000000; display : none ">
	</div>';

?>