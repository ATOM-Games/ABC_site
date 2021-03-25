<?php 
	$_USER;
	
	function VihodUser(){ }
	
	
	//checkCooockie();
	
	function checkCooockie(){
		if(isset($_COOKIE["userlogin"]) && $_COOKIE["userlogin"]!=null){
			if(strlen($_COOKIE["userlogin"]) > 0 && $_USER == null){
				VhodUser();
			}
		}
	}
	function VhodUser(){
		$_USER = get_pol_po_login($podkl, $_COOKIE["userlogin"]);
	}
?>
