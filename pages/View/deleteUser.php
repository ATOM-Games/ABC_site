<?php
	$_Blok = array('FB_Blue', false, false);
	$_page_title = "Удаление профиля";
	$body_text = '<h1>Удаление профиля</h1>';
	if(isset($_POST["deleteme"])){
		if(isset($_POST["pritina"])){
			add_po_zaprsu($podkl, "DELETE FROM polzovatel WHERE Login = '".$_USER["Login"]."'");
			if($_POST["pritina"]=="My"){
				add_po_zaprsu($podkl, "INSERT INTO otset_delete_user(Prichina, Svoya) VALUES ('".$_POST["message"]."',1)");
			}else{
				add_po_zaprsu($podkl, "INSERT INTO otset_delete_user(Prichina, Svoya) VALUES ('".$_POST["pritina"]."',0)");
			}
			setcookie ("userlogin", null);
			header("Location: Profile?Login=1"); exit();
		}else{
			$_Blok[0] = 'FB_Red';
			$body_text = '<h1>Укажите, пожалуйста, причину</h1>';
		}
	}
	$body_text .= '<br/>Пожалуйста, укажите причину вашего удаления
	<form action="" method="post">
	<input type="radio" name="pritina" value="Высокие цены"/> Высокие цены<br/>
	<input type="radio" name="pritina" value="Мало полезного материала"/> Мало полезного материала<br/>
	<input type="radio" name="pritina" value="Сложное управление сайтом"/> Сложное управление сайтом<br/>
	<input type="radio" name="pritina" value="My"/> Свой вариант<br/>
	<textarea class="Kr" title="" name="message" rows=5 style="width:100%" placeholder=""></textarea>
	<table style="width : 100%">
	<tr><td width=50% style="text-align : center"> <input type="submit" name="deleteme" class="Kr" value="Удалиться"/>
	</td><td width=50% style="text-align : center"> <input type="reset" class="Kr" value="Отмена"/>
	</td></tr></table>
	</form>';
?>