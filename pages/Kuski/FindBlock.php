<article id = "BlockFind">
<?php
$stro='<form action="Result" method="get"><table style="margin-top : 10px; margin-bottom : -5px;"><tr>
<td style="width : 130px;"><input type="text" class="fn" name="Find" value="" /><input type="submit" class="fnp" value="⌕"/></td>
<td id="FindMenu" style="width : calc(100%-150px); max-width : 0px; transition: 0.5s; overflow : hidden;"><div id="PoleFind" style="width : 1000px">
<input type="checkbox" name="News" class="PR" '.(( isset($_GET["Find"]) && !isset($_GET["News"]) ) ? ' ' : 'checked').' />Новости
<input type="checkbox" name="Mans" class="PR" '.(( isset($_GET["Find"]) && !isset($_GET["Mans"]) ) ? ' ' : 'checked').' />Люди
<input type="checkbox" name="Kourse" class="PR" '.(( isset($_GET["Find"]) && !isset($_GET["Kourse"]) ) ? ' ' : 'checked').' />Курсы
<input type="checkbox" name="Urok" class="PR" '.(( isset($_GET["Find"]) && !isset($_GET["Urok"]) ) ? ' ' : 'checked').' />Уроки
</div></td>
<td style="width : 20px;"><input type="button" class="fnp" value="►" onmousedown="BFRLclic()" id="BFRL"/></td>
</tr></table></form>';
echo $stro;
//<input type="submit" class="findleftright" value="&#x1f50d;" />
?>
</article>