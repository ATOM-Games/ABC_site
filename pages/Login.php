<?php
	$_Blok = array('FB_Blue', false, false);
	$_polya = array("Log" => "Логин", "Pas" => "Пароль");
	$_errs = array("Log" => "Kr", "Pas" => "Kr");
	$sanq = "";
	if(isset($_POST['ForgotePassword'])){
	    if(strlen($_POST['Logan']) == 0){
			$_polya["Log"] = 'Введите логин'; $_errs["Log"] = "KrEr";
		}else{
			if(!preg_match('/^[A-z0-9]{1,30}$/', $_POST['Logan'])) {
				$_polya["Log"] = 'Логин должен содержать буквы латинского алфавита и цифры'; $_errs["Log"] = "KrEr";
			}else{
				$estly = get_pol_po_login($podkl, $_POST['Logan']);
				if($estly==null){
					$_polya["Log"] = 'Пользователь в логином '.$_POST['Logan'].' не найден'; $_errs["Log"] = "KrEr";
				}else{
				    $otkogo = $_thisResurs;
		            $komu = htmlspecialchars($estly["Email"]);
		            $tema = "Восстановление пароля";
		            $tema = "=?utf-8?B?".base64_encode($tema)."?=";
		            $headers="From: $otkogo\r\nReply-to: $komu\r\nContent-type: text/html; charset=utf-8\r\n";
		            $message = '<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
                    <html><head></head>
		            <body style="background-color : #131c33;"><div>
		            <div style="color : #000; border-radius : 5px; margin-top : 20px; margin-bottom : 20px; padding-top : 5px; padding-bottom : 5px; padding-right : 10px; padding-left : 10px; border : 2px solid #065f92; background-color : #6da4bb; box-shadow: 0 0 0px #000000;">
	            	<h1 style="margin-top : 20px; margin-bottom : 20px; width : 100%; text-align : center; color : #000;">Уважаемый(ая) '.$estly["Family"].' '.$estly["Name"].'</h1>
		            Вы попытались зайти на сайт '.$_thisResurs.', но у вас ничего не получилось, так как забыли пароль. Перед тем как восстановить пароль, попробуйте его вспомнить. Вы себе оставили напоминалку : <br/> '.((strlen($estly["Podskazka"])==0) ? '<div style="">Ничего нет</div>' : '<div style="">'.$estly["Podskazka"].'</div>').'<br/>
		            Если Вам Ваша же подсказка не помогла, вот ссылка для восстановления: 
		            <form action="f0336420.xsph.ru/PasswordEdit" method="POST">  
		                <input type="text" style="display : none" value="'.$estly["Login"].'" name="userlog" /><input type="text" style="display : none" value="vost" name="log" />
		                <input type="submit" value="Восстановить" style="width : 80%; background-color : #ddd; border : 1px solid #0044dd; border-radius : 10px; color : #002288; font-size : 20px; font-family : CRY; text-align : center; text-shadow : 0 0 5px #000000;" name="editpas" />
		            </form></div></div></body>';
		            mail($komu, $tema, $message, $headers);
		    $sanq = "Письмо с ссылкой для востановления пароля отправлено ".$estly["Email"];
				}
			}
		}
		if($_errs["Log"]=="Kr" && $_errs["Pas"]=="Kr"){
			//setcookie ("userlogin", ''.$_POST['Logan']);
			//header("Location: Profile?ID=".$_POST['Logan']);
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	if(isset($_POST['lgn'])){
		if(strlen($_POST['Logan']) == 0){
			$_polya["Log"] = 'Введите логин'; $_errs["Log"] = "KrEr";
		}else{
			if(!preg_match('/^[A-z0-9]{1,30}$/', $_POST['Logan'])) {
				$_polya["Log"] = 'Логин должен содержать буквы латинского алфавита и цифры'; $_errs["Log"] = "KrEr";
			}else{
				$estly = get_pol_po_login($podkl, $_POST['Logan']);
				if($estly==null){
					$_polya["Log"] = 'Пользователь в логином '.$_POST['Logan'].' не найден'; $_errs["Log"] = "KrEr";
				}else{
					if($_POST['Paswa'] != $estly["Password"]){
						$_polya["Pas"] = 'Неверный пароль'; $_errs["Pas"] = "KrEr";
					}
				}
			}
		}
		if($_errs["Log"]=="Kr" && $_errs["Pas"]=="Kr"){
			setcookie ("userlogin", ''.$_POST['Logan']);
			header("Location: Profile?ID=".$_POST['Logan']);
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	$_page_title = 'Логин/Вход';
	$body_text = '<h1>Войти</h1> <form method="post" action="">
	<input class="'.$_errs["Log"].'" type="text" title="'.$_polya["Log"].'" name="Logan" placeholder="'.$_polya["Log"].'" autosave="ABCreferens" value="'.(($_errs["Pas"] == "KrEr")?$_POST['Logan']:"").'" required/>
	'.(($_errs["Log"]=="KrEr")?('<op>'.$_polya["Log"].'</op>'):'').'
	<input class="'.$_errs["Pas"].'" type="password" title="'.$_polya["Pas"].'" name="Paswa" placeholder="'.$_polya["Pas"].'" autosave="ABCreferens" value="" required/>
	'.(($_errs["Pas"]=="KrEr")?('<op>'.$_polya["Pas"].'</op>'):'').'
	<table style="width : 100%">
	<tr><td width=50% style="text-align : center"> <input type="submit" name="lgn" class="Kr" value="Войти"/>
	</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
	</td></tr>
	</table><div style="text-align : center">
	<input type="submit" name="ForgotePassword" class="Kr" value="Забыл пароль" />
	</div>
	</form></br>'.$sanq;
?>