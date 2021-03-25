<?php
    $_Blok = array('FB_Blue', false, false);
    if(isset($_POST["editpas"])){
        if($_POST["log"]=="edit"){
            $_page_title = 'Изменение пароля';
            $body_text = '<h1>Изменение пароля</h1><br/>
            <form action="" method="post" style="text-align : center">
            <input type="text" class="nv" name="userlog" value="'.$_POST["userlog"].'"/>
            <input type="text" class="Kr" name="oldpass" placeholder="Старый пароль"/>
            <input type="text" class="Kr" name="newpass" placeholder="Новый пароль"/>
            <input type="text" class="Kr" name="newpasr" placeholder="Повторите пароль"/>
            <input type="text" class="Kr" name="newpods" placeholder="Новая подсказка"/>
            <input type="submit" class="Kr" name="savepass" value="Изменить"/>
            </form>';
        }
        if($_POST["log"]=='vost'){
            $_page_title = 'Восстановление пароля';
            $body_text = '<h1>Восстановление пароля</h1><br/>
            <form action="" method="post" style="text-align : center">
            <input type="text" class="nv" name="userlog" value="'.$_POST["userlog"].'"/>
            <input type="text" class="Kr" name="newpass" placeholder="Новый пароль"/>
            <input type="text" class="Kr" name="newpasr" placeholder="Повторите пароль"/>
            <input type="text" class="Kr" name="newpods" placeholder="Новая подсказка"/>
            <input type="submit" class="Kr" name="savepass" value="Восстановить"/>
            </form>';
        }
    }
	if(isset($_POST["savepass"])){
	    $localuser = get_pol_po_login($podkl, $_POST["userlog"]);
	    $error = false;
	    if($_POST["savepass"]=="Изменить"){
	        $_page_title = 'Изменение пароля';
	        $body_text = '<h1>Изменение пароля</h1><br/>
            <form action="" method="post" style="text-align : center">
            <input type="text" class="nv" name="userlog" value="'.$_POST["userlog"].'"/>';
            if( empty($_POST["oldpass"]) ){ $body_text .= '<input type="text" class="KrEr" name="oldpass" placeholder="Введите старый пароль"/>'; $error=true; }
            else {
                if($_POST["oldpass"] != $localuser["Password"]) {
                    $body_text .= '<input type="text" class="KrEr" name="oldpass" placeholder="Старый пароль не совпадает"/>'; $error=true;
                }else{
                    $body_text .= '<input type="text" class="Kr" name="oldpass" value="'.$_POST["oldpass"].'"/>';
                }
            }
	        if( empty($_POST["newpass"]) ){ $body_text .= '<input type="text" class="KrEr" name="newpass" placeholder="Введите новый пароль"/>'; $error=true; } else {
	            $body_text .= '<input type="text" class="Kr" name="newpass" value="'.$_POST["newpass"].'"/>';
	        }
	        if( empty($_POST["newpasr"]) ){ $body_text .= '<input type="text" class="KrEr" name="newpasr" placeholder="Введите повторно новый пароль"/>'; $error=true; }
	        else { 
	            if($_POST["newpass"] != $_POST["newpasr"]) { $body_text .= '<input type="text" class="KrEr" name="newpasr" placeholder="Повторный пароль не совпадает"/>'; $error=true; }
	            else {
	                $body_text .= '<input type="text" class="Kr" name="newpasr" value="'.$_POST["newpasr"].'"/>';
	            }
	        }
	        $body_text .= '<input type="text" class="Kr" name="newpods" placeholder="Новая подсказка"/>
	        <input type="submit" class="Kr" name="savepass" value="Изменить"/>';
	    }
	    if($_POST["savepass"]=="Восстановить"){
	        $_page_title = 'Изменение пароля';
	        $body_text = '<h1>Изменение пароля</h1><br/>
            <form action="" method="post" style="text-align : center">
            <input type="text" class="nv" name="userlog" value="'.$_POST["userlog"].'"/>';
	        if( empty($_POST["newpass"]) ){ $body_text .= '<input type="text" class="KrEr" name="newpass" placeholder="Введите новый пароль"/>'; $error=true; } else {
	            $body_text .= '<input type="text" class="Kr" name="newpass" value="'.$_POST["newpass"].'"/>';
	        }
	        if( empty($_POST["newpasr"]) ){ $body_text .= '<input type="text" class="KrEr" name="newpasr" placeholder="Введите повторно новый пароль"/>'; $error=true; }
	        else { 
	            if($_POST["newpass"] != $_POST["newpasr"]) { $body_text .= '<input type="text" class="KrEr" name="newpasr" placeholder="Повторный пароль не совпадает"/>'; $error=true; }
	            else{
	                $body_text .= '<input type="text" class="Kr" name="newpasr" value="'.$_POST["newpasr"].'"/>';
	            }
	        }
	        $body_text .= '<input type="text" class="Kr" name="newpods" placeholder="Новая подсказка"/>
	        <input type="submit" class="Kr" name="savepass" value="Восстановить"/>';
	    }
	    $body_text .= '</form>';
	    if(!$error){ 
	        $result = mysqli_query($podkl, 'UPDATE polzovatel SET Password="'.$_POST["newpass"].'", Podskazka="'.$_POST["newpods"].'" WHERE Login="'.$_POST["userlog"].'"');
	        $body_text = '<h1>Пароль был успешно изменен</h1>';
	    }
	}
?>
<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" href="resource/STUL.css" type="text/css">
</head>
<body>
<?php 
	include_once "Kuski/Header.php";
	include_once "Kuski/Menu.php";
	include_once "Kuski/FindBlock.php";
	include "Kuski/Block.php";
	include_once "Kuski/Footer.php";
?>
<script type="text/javascript" src="resource/ForMenu.js" ></script>
<title><?=$_page_title;?></title>
</body></html>