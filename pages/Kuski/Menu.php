<?php
$katki =  get_massiv_po_zaprosu($podkl, "SELECT * From kategories");
$kursi =  get_massiv_po_zaprosu($podkl, "SELECT * From kurs");
$leftMenu = '<button class="LeftMenuMob" onmousedown="LFBcl()">«</button><nav id="LeftMenu">
<a class="zag" title="Меню сайта">Меню сайта</a>
<a class="Knopka nad" title="На главную" href="/">На главную</a>
<a class="Knopka nad" title="Новости" href="News">Новости</a>
<a class="Knopka nad" title="Категории" onmousedown="KategClick()" href="#">Категории</a>
<div style="max-height : 0px; display:inline-block; overflow : hidden; transition: 0.5s;" id="katMen">';
foreach ($katki as $Onekat){
	$leftMenu .='<a class="Knopka pod" title="'.$Onekat["Description"].'" href="Kategories?ID='.$Onekat["ID"].'">'.$Onekat["Nazvanie"].'</a>';
}
$leftMenu .='</div>
<a class="Knopka nad" title="Курсы" onmousedown="KursClick()" href="#">Kурсы</a>
<div style="max-height : 0px; display:inline-block; overflow : hidden; transition: 0.5s;" id="kurMen">';
foreach ($kursi as $Onekur){
	$leftMenu .='<a class="Knopka pod" title="'.$Onekur["Description"].'" href="Kourses?ID='.$Onekur["ID"].'">'.$Onekur["Name"].'</a>';
}
$leftMenu .='</div>
<a class="Knopka nad" title="Обратная связь" href="Obratka">Обратная связь</a>
</nav>';
$rghtMenu = '<button class="RghtMenuMob" onmousedown="RFBcl()">»</button><nav id="RightMenu">
<a class="zag" title="Инструменты">Инструменты</a>';
if(isset($_COOKIE["userlogin"]) && $_COOKIE["userlogin"]!=null && $_USER!=null){
	$_allMes = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM ak_ak_message WHERE Komu='".$_USER["Login"]."' AND Looooooked='0'");
	$rghtMenu.='<a class="Knopka nad" title="'.$_USER["Family"].' '.$_USER["Name"].'" href="Profile?ID='.$_COOKIE["userlogin"].'">Мой профиль</a>
	<a class="Knopka nad" title="Редактировать страницу" href="Profile?RedactMe='.$_COOKIE["userlogin"].'">Редактировать</a>
	<a class="Knopka nad" title="Сообщения" href="MyMail">Сообщения'.( ($_allMes[0]["Qty"]!='0') ? (' <op>['.$_allMes[0]["Qty"].']</op>') : '' ).'</a>';
	if($_USER["Doljnost"]=="ученик" && $_USER["Podtverjden"]){
		$rghtMenu.='<a class="Knopka nad" title="Мои подписки" href="MyKourses">Подписки</a>';
	}
	if($_USER["Doljnost"]=="куратор"){
		$rghtMenu.='<a class="Knopka nad" title="Вопросы мне" href="#">Вопросы</a>
		<a class="Knopka nad" title="Мои уроки" href="Lesson">Мои уроки</a>
		<a class="Knopka nad" title="Добавить курс" href="Kourses">Новый курс</a>
		<a class="Knopka nad" title="Добавить курс" href="Tests?RedVod=All">Тесты</a>';
	}
	if($_USER["Doljnost"]=="директор"){
		$_byiki = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Status='0'");
		$rghtMenu.='<a class="Knopka nad" title="Мои уроки" href="Lesson">Мои уроки</a>
		<a class="Knopka nad" title="Мои курсы" href="Kourses">Мои курсы</a>
		<a class="Knopka nad" title="Добавить категорию" href="Kategories?NewKats=1">Новая категория</a>
		<a class="Knopka nad" title="Покупки" href="Byues">Покупки'.( ($_byiki[0]["Qty"]!='0') ? (' <op>['.$_byiki[0]["Qty"].']</op>') : ('') ).'</a>
		<a class="Knopka nad" title="Добавить курс" href="Tests?RedVod=All">Тесты</a>';
	}
	if($_USER["Doljnost"]=="управляющий"){
		$_byiki = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Status='0'");
		$rghtMenu.='<a class="Knopka nad" title="Отчеты за все разделы" href="Report">Отчеты</a>
		<a class="Knopka nad" title="Добавить категорию" href="Kategories?NewKats=1">Новая категория</a>
		<a class="Knopka nad" title="Список всех категорий" href="Kategories">Категории</a>
		<a class="Knopka nad" title="Список всех курсов" href="Kourses">Курсы</a>
		<a class="Knopka nad" title="Список всех уроков" href="Lesson">Уроки</a>
		<a class="Knopka nad" title="Покупки" href="Byues">Покупки'.( ($_byiki[0]["Qty"]!='0') ? (' <op>['.$_byiki[0]["Qty"].']</op>') : ('') ).'</a>
		<a class="Knopka nad" title="Добавить курс" href="Tests?RedVod=All">Тесты</a>';
	}
	if($_USER["Doljnost"]=="владелец"){
		$_byiki = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM buy_kurse WHERE Status='0'");
		$_znd = get_massiv_po_zaprosu($podkl, "SELECT count(*) as Qty FROM zap_new_dolk");
		$rghtMenu.='<a class="Knopka nad" title="Штаб" href="Shtab">Штаб'.( ($_znd[0]["Qty"]!='0') ? (' <op>['.$_znd[0]["Qty"].']</op>') : '' ).'</a>
		<a class="Knopka nad" title="Все отчеты" href="Report">Отчеты</a>
		<a class="Knopka nad" title="Добавить категорию" href="Kategories?NewKats=1">Новая категория</a>
		<a class="Knopka nad" title="Список всех категорий" href="Kategories">Категории</a>
		<a class="Knopka nad" title="Список всех курсов" href="Kourses">Курсы</a>
		<a class="Knopka nad" title="Список всех уроков" href="Lesson">Уроки</a>
		<a class="Knopka nad" title="Покупки" href="Byues">Покупки'.( ($_byiki[0]["Qty"]!='0') ? (' <op>['.$_byiki[0]["Qty"].']</op>') : ('') ).'</a>
		<a class="Knopka nad" title="Добавить курс" href="Tests?RedVod=All">Тесты</a>';
	}
	$rghtMenu.='<a class="Knopka nad" title="Удалить страницу" href="Profile?DeleteMe='.$_COOKIE["userlogin"].'">Удалиться</a>
	<a class="Knopka nad" title="Выйти" href="Profile?Exit='.$_COOKIE["userlogin"].'">Выйти</a>
	</nav>';
}else{
	$rghtMenu .= '<a class="Knopka nad" title="Зарегистрироваться" href="Profile?Registration=1">Регистрация</a>
	<a class="Knopka nad" title="Войти" href="Profile?Login=1">Вход</a>
	</nav>';
}
echo "".$leftMenu.$rghtMenu."";
?>
<div id="OTHER"><section id="Sec" style="padding-left : 0%; padding-right : 0%; transition: 0.5s;"><article class="otstup_head"></article>