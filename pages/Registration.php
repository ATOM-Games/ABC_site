<?php
	$_Blok = array('FB_Blue', false, false);
	$errortext = array("Fam" => "Фамилия", "Nam" => "Имя", "Otx" => "Отчество", "Mal" => "Email", "Pas" => "Пароль", "Lod" => "Логин",  "Ava" => "Аватарка");
	$_errs = array("Fam" => "Kr", "Nam" => "Kr", "Otx" => "Kr", "Mal" => "Kr", "Pas" => "Kr", "Lod" => "Kr", "Ava" => "Kr");
	if(isset($_POST['rgr'])){
		if(strlen($_POST['Fam']) == 0) { $errortext["Fam"] = 'Укажите фамилию'; $_errs["Fam"] = "KrEr"; }
		if(strlen($_POST['Ima']) == 0) { $errortext["Nam"] = 'Укажите имя'; $_errs["Nam"] = "KrEr"; }
		if(strlen($_POST['Otx']) == 0) { $errortext["Otx"] = 'Укажите отчество'; $_errs["Otx"] = "KrEr"; }
		if(!preg_match('/@/', $_POST['Elma'])) { $errortext["Mal"] = 'Укажите корректный Email'; $_errs["Mal"] = "KrEr"; }
		if(!preg_match('/^[A-z0-9]{1,30}$/', $_POST['Logan'])) { $errortext["Lod"] = 'Логин должен содержать буквы латинского алфавита и цифры'; $_errs["Lod"] = "KrEr"; }
		$estly = get_pol_po_login($podkl, $_POST['Logan']);
		if($estly!=null) { $errortext["Lod"] = 'Пользователь с логином '.$_POST['Logan'].' уже существует'; $_errs["Lod"] = "KrEr"; }
		if(strlen($_POST['Paswa']) == 0) { $errortext["Pas"] = 'Укажите пароль'; $_errs["Pas"] = "KrEr"; }
		//--ava
		
		$flnaml = ($_FILES['Ava']['size'] < 40000000) ? UpLoadFile($_FILES, 'Ava', 'resource/Avatars/Profiles/', array('image/jpg', 'image/png', 'image/gif', 'image/jpeg', 'image/bmp')) : null;
		//-----Постошибие
		if($flnaml==null && !empty($_FILES['Ava']['size'])) $_errs["Ava"]= "KrEr";
		if($_errs["Fam"]=="Kr" && $_errs["Nam"]=="Kr" && $_errs["Otx"]=="Kr" && $_errs["Mal"]=="Kr" && $_errs["Lod"]=="Kr" && $_errs["Pas"]=="Kr" && $_errs["Ava"]=="Kr") {
			$polzovatel = array( "Login" => htmlspecialchars($_POST['Logan']),
			"Passw" => htmlspecialchars($_POST['Paswa']),
			"Famka" => htmlspecialchars($_POST['Fam']),
			"Nama" => htmlspecialchars($_POST['Ima']),
			"Ottestvo" => htmlspecialchars($_POST['Otx']),
			"Ava" => $flnaml,
			"Mala" => htmlspecialchars($_POST['Elma']));
			add_polzovatel($podkl, $polzovatel);
			setcookie ("userlogin", ''.$polzovatel["Login"]);
			header("Location: Profile?ID=".$_POST['Logan']);
		}else{
			$_Blok[0] = 'FB_Red';
		}
	}
	$_page_title = 'Создание профиля';
	$body_text = '<h1>Создание профиля</h1> <form method="post" action="" enctype="multipart/form-data">
	<input class="'.$_errs["Fam"].'" type="text" title="'.$errortext["Fam"].'" name="Fam" placeholder="'.$errortext["Fam"].'" autosave="ABCreferens" value="'.$_POST['Fam'].'" required/>
	'.(($_errs["Fam"]=="KrEr")?('<op>'.$errortext["Fam"].'</op>'):'').'
	<input class="'.$_errs["Nam"].'" type="text" title="'.$errortext["Nam"].'" name="Ima" placeholder="'.$errortext["Nam"].'" autosave="ABCreferens" value="'.$_POST['Ima'].'" required/>
	'.(($_errs["Nam"]=="KrEr")?('<op>'.$errortext["Nam"].'</op>'):'').'
	<input class="'.$_errs["Otx"].'" type="text" title="'.$errortext["Otx"].'" name="Otx" placeholder="'.$errortext["Otx"].'" autosave="ABCreferens" value="'.$_POST['Otx'].'" />
	'.(($_errs["Otx"]=="KrEr")?('<op>'.$errortext["Otx"].'</op>'):'').'
	<table style="width : 100%"><tr><td width=30%><input class="'.$_errs["Ava"].'" type="text" title="Аватарка" placeholder="'.$errortext["Ava"].'" disabled/>
	</td><td width=70%><input class="'.$_errs["Ava"].'" type="file" title="Аватарка польователя" name="Ava"/>
	</td></tr></table>
	'.(($_errs["Ava"]=="KrEr")?('<op>'.$errortext["Ava"].'</op>'):'').'
	<input class="'.$_errs["Mal"].'" type="mail" title="'.$errortext["Mal"].'" name="Elma" placeholder="'.$errortext["Mal"].'" autosave="ABCreferens" value="'.$_POST['Elma'].'" required/>
	'.(($_errs["Mal"]=="KrEr")?('<op>'.$errortext["Mal"].'</op>'):'').'
	<input class="'.$_errs["Lod"].'" type="text" title="'.$errortext["Lod"].'" name="Logan" placeholder="'.$errortext["Lod"].'" autosave="ABCreferens" value="'.$_POST['Logan'].'" required/>
	'.(($_errs["Lod"]=="KrEr")?('<op>'.$errortext["Lod"].'</op>'):'').'
	<input class="'.$_errs["Pas"].'" type="password" title="'.$errortext["Pas"].'" name="Paswa" placeholder="'.$errortext["Pas"].'" autosave="ABCreferens" value="'.$_POST['Paswa'].'" required/>
	'.(($_errs["Pas"]=="KrEr")?('<op>'.$errortext["Pas"].'</op>'):'').'
	<table style="width : 100%">
	<tr><td width=50% style="text-align : center"> <input type="submit" name="rgr" class="Kr" value="Регистрация"/>
	</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
	</td></tr>
	</table></form>';
?>
