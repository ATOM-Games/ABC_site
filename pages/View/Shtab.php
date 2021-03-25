<?php
	$_page_title = 'Штаб';
	$_Blok = array('FB_Blue', false, false);
	$body_text = '<h1>'.$_USER["Family"].' '.$_USER["Name"].' '.(($_USER["Podtverjden"]==0)?'<b style="color:red; font-family : Wingdings" title="не подтвержден"></b>':'<b style="color:#00ff00; font-family : Wingdings" title="подтвержден"></b>').' ('.$_USER["Doljnost"].')</h1><br/>'.$sanq;
	if($_USER["Podtverjden"]==0){
		$body_text.='<form method="post" action="" ><table style="width : 100%">
		<tr><td width=50% style="text-align : center"> <input type="submit" name="pdt" class="Kr" value="Подтвердить EMail"/>
		</td><td width=50% style="text-align : center"> </td></tr></table></form>';
	}
?>