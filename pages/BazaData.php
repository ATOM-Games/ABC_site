<?php 
	$podkl = mysqli_connect('localhost','root','','f0336420_ABC_001');
	if(mysqli_connect_errno()) {
		echo "Ошибка в подлкючении (".mysqli_connect_errno().") ".mysqli_connect_error();
		exit();
	}
	function get_pol_po_login($pgg, $polze){
		$sql_get_mess = "SELECT * FROM polzovatel WHERE Login = '".$polze."'";
		$result = mysqli_query($pgg, $sql_get_mess) or null;
		if($result){
			$messa = array();
			if($result != null){
				$total = mysqli_num_rows($result);
				while($row = mysqli_fetch_assoc($result)) $messa[] = $row;
			}
			return $messa[0];
		}else{
			return null;
		}
	}
	function add_polzovatel($pgg, $polze){
		$zapros = "INSERT INTO polzovatel(Login, Password, Ava, Podtverjden, Family, Name, Ottestvo, Email, Doljnost) VALUES ('".$polze["Login"]."', '".$polze["Passw"]."', '".$polze["Ava"]."', 0, '".$polze["Famka"]."', '".$polze["Nama"]."', '".$polze["Ottestvo"]."', '".$polze["Mala"]."', 'ученик')";
		$result = mysqli_query($pgg, $zapros) or null;
		$_User_login = $polze["Login"];
	}
	function get_massiv_po_zaprosu($pgg, $zapros){
		$result = mysqli_query($pgg, $zapros) or null;
		if($result){
			$messa=array();
			//$total = mysqli_num_rows($result);
			while($row = mysqli_fetch_assoc($result)) $messa[] = $row;
			return $messa;
		}else{
			return null;
		}
	}
	function get_obrat_massiv_po_zaprosu($pgg, $zapros){
		$result = mysqli_query($pgg, $zapros) or null;
		if($result){
			$messa = array();
			if($result != null){
				$total = mysqli_num_rows($result);
				while($row = mysqli_fetch_assoc($result)) $messa[] = $row;
			}
			$obrmes = array();
			for($i=count($messa)-1; $i>=0; $i--) { $obrmes[]=$messa[$i]; }
			return $obrmes;
		}else{
			return null;
		}
	}
	function add_po_zaprsu($pgg, $zapros){
		$result = mysqli_query($pgg, $zapros) or null;
	}	
?>
