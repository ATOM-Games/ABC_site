<?php
	$_page_title ;
	$page = "";
	$_domen = "localhost:96";
	$_thisResurs = "G.D.S.Game_Develop_School.ru";
	
	require_once("pages/BazaData.php");
	require_once("pages/WorkOtherFiles.php");
	$_USER = (isset($_COOKIE["userlogin"]) && $_COOKIE["userlogin"]!=null) ? get_pol_po_login($podkl, $_COOKIE["userlogin"]) : null;
	if($_SERVER["REQUEST_URI"] == '/') { $page = "Main"; }
	else{
		$page = strtok(substr($_SERVER["REQUEST_URI"], 1), '?');
	}
	if($page!="main"){
		if(! preg_match('/^[A-z0-9]{1,25}$/', $page) ){ include $page = "pages/nf404.php"; exit(); }
	}
	if( file_exists("pages/$page.php") ){ include "pages/$page.php"; }
	else include $page = "pages/nf404.php";
?>
