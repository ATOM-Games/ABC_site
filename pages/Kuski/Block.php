<article class = "Block <?php echo $_Blok[0]?>">
<?php
if($_Blok[1]) echo '<div class="InBox">'.$body_text.'</div>';
else echo $body_text;
if($_Blok[2]) echo '<div class="LikeComment">Laйк, коммент, позвонить</div>';
else echo '<div style="height : 35px"></div>';
?>
</article>