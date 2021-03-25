<?php
	$_color_bukv = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
	
	function UpLoadFile($File, $NameKey, $UploadDir, $fdptyle){
		if(empty($File[$NameKey]['size'])){ return null; }else{
			if($File[$NameKey]['size'] < 40000000) {
				$fname = getimagesize($File[$NameKey]['tmp_name']);
				if(count($fdptyle)>0 && !in_array($fname['mime'], $fdptyle)) { 
					$errortext[$NameKey] = "Неверный формат";
					return null;
				}else{
					$fn = $File[$NameKey]['name'];
					$name = $UploadDir.date('YmdHis')."Ava_ABC_hashCode".substr($fn, strpos($fn, '.'), strlen($fn)-1);
					$mov = move_uploaded_file($File[$NameKey]['tmp_name'], $name);
					if($mov){
						return stripcslashes(strip_tags(trim($name)));
						//$pr .=(" Ava='".$flnaml."',");
					}else{
						$errortext[$NameKey] = "Произошла ошибка при загрузке";
						return null;
					}
				}
			}else{ $errortext[$NameKey] = "Файл слишком велик"; return null; }
		}
	}
	function MaxAssoc($massiv){
		$maxval=-9999999;
		$result='';
		foreach ( $massiv as $ky => $val ){
			if(intval($val)>$maxval){
				$maxval = intval($val);
				$result = $ky;
			}
		}
		return $result;
	}
	function Rand_Color($_color_bukv, $min, $max){
		return '#'.$_color_bukv[random_int($min,$max)].$_color_bukv[random_int($min,$max)].$_color_bukv[random_int($min,$max)].$_color_bukv[random_int($min,$max)].$_color_bukv[random_int($min,$max)].$_color_bukv[random_int($min,$max)];
	}
?>
