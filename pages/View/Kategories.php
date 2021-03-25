<?php
	$sanq = "";
	if(isset($_POST["pdt"])){
		$otkogo = htmlspecialchars("silatrotila0atom@gmail.com");
		$komu = htmlspecialchars($_USER["Email"]);
		$tema = htmlspecialchars("Подтверждение аккаунта на A.T.O.M.-Games.com");
		$message = htmlspecialchars('Доброго времени суток, уважаемый(ая) '.$_USER["Family"].' '.$_USER["Name"].'. Вы создали аккаунт на нашем сайте, теперь вам необходимо его подтвердить. Вот ссылка для подтверждения: http://webmvc/Profile?PostReg='.$_USER["Login"].'');
		$tema = "=?utf-8?B?".base64_encode($tema)."?=";
		$headers="From: $otkogo\r\nReply-to: $komu\r\nContent-type: text/plain; charset=utf-8\r\n";
		mail($komu, $tema, $message, $headers);
		$sanq = '<b style="color:#aa00aa">Письмо на ваш почтовый ящик ('.$_USER["Email"].') уже отправлен. Для активации акккаунта пройдите по ссылке в письме. Если письма нет, подождите несколько минут, либо проверьте раздел «Спам»</b>';
	}
	
	
	
	






	$_page_title = $_USER["Family"].' '.$_USER["Name"];
	$_Blok = array('FB_Blue', false, false);
	$body_text = '<h1>'.$_USER["Family"].' '.$_USER["Name"].' '.(($_USER["Podtverjden"]==0)?'<b style="color:red; font-family : Wingdings" title="не подтвержден"></b>':'<b style="color:#00ff00; font-family : Wingdings" title="подтвержден"></b>').' ('.$_USER["Doljnost"].')</h1><br/><img src="'.(($OneMan["Ava"]) ? $OneMan["Ava"].'"' : 'resource/Images/Krustik.png" title="нет аватарки"').' id="Ava" /><br/>'.$sanq;
	if($_USER["Podtverjden"]==0){
		$body_text.='<form method="post" action="" ><table style="width : 100%">
		<tr><td width=50% style="text-align : center"> <input type="submit" name="pdt" class="Kr" value="Подтвердить EMail"/>
		</td><td width=50% style="text-align : center"> </td></tr></table></form>';
	}
?>