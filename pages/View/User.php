<?php
	$sanq = "";
	if(isset($_POST["pdt"])){
		$otkogo = $_thisResurs;
		$komu = htmlspecialchars($_USER["Email"]);
		$tema = htmlspecialchars("Подтверждение аккаунта на ".$_domen);
		$tema = "=?utf-8?B?".base64_encode($tema)."?=";
		$headers="From: $otkogo\r\nReply-to: $komu\r\nContent-type: text/html; charset=utf-8\r\n";
		$message = '<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
        <html><head></head>
		<body style="background-color : #131c33;"><div>
		<div style="color : #000; border-radius : 5px; margin-top : 20px; margin-bottom : 20px; padding-top : 5px; padding-bottom : 5px; padding-right : 10px; padding-left : 10px; border : 2px solid #065f92; background-color : #6da4bb; box-shadow: 0 0 0px #000000;">
		<h1 style="margin-top : 20px; margin-bottom : 20px; width : 100%; text-align : center; color : #000;">Уважаемый(ая) '.$_USER["Family"].' '.$_USER["Name"].'</h1>
		Доброго времени суток, уважаемый(ая) '.$_USER["Family"].' '.$_USER["Name"].'. Вы создали аккаунт на нашем сайте, теперь вам необходимо его подтвердить.
		Вот ссылка для подтверждения: <a href="'.$_domen.'/Profile?PostReg='.$_USER["Login"].'" style="font-size : 16px; font-family : times new roman; text-decoration : none; color : #000; text-shadow : 0 0 0px #000000; display : block; border : 2px solid #065f92; border-radius : 5px; margin-bottom : 1px; margin-top : 30px; padding-top : 5px; padding-bottom : 5px; text-align : center;"> ПОДТВЕРДИТЬ </a></div></div></body>';
		mail($komu, $tema, $message, $headers);
		$sanq = '<b style="color:#aa00aa">Письмо на ваш почтовый ящик ('.$_USER["Email"].') уже отправлен. Для активации акккаунта пройдите по ссылке в письме. Если письма нет, подождите несколько минут, либо проверьте раздел «Спам»</b>';
	}
	
	$_Blok = array('FB_Blue', false, false);
	if($_COOKIE["userlogin"] == $_GET["ID"]){ // - - если открыл свою страницу (как ее хозяин)
		$_page_title = $_USER["Family"].' '.$_USER["Name"].'';
		$body_text = '<h1>'.$_USER["Family"].' '.$_USER["Name"].' '.(($_USER["Podtverjden"]==0)?'<b style="color:red; font-family : Wingdings" title="не подтвержден"></b>':'<b style="color:#00ff00; font-family : Wingdings" title="подтвержден"></b>').' ('.$_USER["Doljnost"].')</h1><br/><table><tr><td><img src="'.(($_USER["Ava"] && file_exists($_USER["Ava"])) ? $_USER["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava" /></td>
		<td><b>E-Mail : </b> <a href="">'.$_USER["Email"].'</a><br/><br/><a href="MyMail?MailTo='.$_USER["Login"].'" class="Kr">Мои заметки</a></td></tr></table><br/>'.$sanq;
		if($_USER["Podtverjden"]==0){
			$body_text.='<form method="post" action="" ><table style="width : 100%">
			<tr><td width=50% style="text-align : center"> <input type="submit" name="pdt" class="Kr" value="Подтвердить EMail"/>
			</td><td width=50% style="text-align : center"> </td></tr></table></form>';
		}
	}else{ // - - если заглянул на чью-то страницу
		$NeMoyUser = get_pol_po_login($podkl,$_GET["ID"]);
		if($NeMoyUser){
			$_page_title = $NeMoyUser["Family"].' '.$NeMoyUser["Name"].'';
			$body_text = '<h1>'.$NeMoyUser["Family"].' '.$NeMoyUser["Name"].' ('.$NeMoyUser["Doljnost"].')</h1><br/><table><tr><td><img src="'.(($NeMoyUser["Ava"] && file_exists($NeMoyUser["Ava"])) ? $NeMoyUser["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava" /></td><td><b>E-Mail : </b> <a href="">'.$NeMoyUser["Email"].'</a>
			<br/><br/><a href="MyMail?MailTo='.$NeMoyUser["Login"].'" class="Kr">Написать</a></td></tr></table><br/>';
		}else{
			$_Blok[0] = 'FB_Red';
			$_page_title = 'Нет пользователя';
			$body_text = '<h1>Пользователь с логином '.$_GET["ID"].'<br/> не существует или удален</h1><br/><img src="resource/Images/Krustik.png" title="нет аватарки" id="Ava" /><br/>';
		}
	}

?>