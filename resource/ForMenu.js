window.captureEvents(Event.MOUSEMOVE);
function ieMouse(){}
window.document.onmousemove = ieMouse
window.document.onclick = Zakr;
function Zakr(){ }
function Naved(Name, Nav){ }
//------for find menu
var ButtonFindLeftRight = document.getElementById("BFRL");
var BFRLopen;
var FindPoleMenu = document.getElementById("FindMenu");
var PoleFind = document.getElementById("PoleFind");
var LeftMen = document.getElementById("LeftMenu"); var RghtMen = document.getElementById("RightMenu");
var withs = 10000;
var tfi = document.getElementById("BlockFind");
function BFRLclic(){
	withs = tfi.offsetWidth - 200;
	PoleFind.setAttribute("style","width : "+withs+";");
	if(BFRLopen){
		FindPoleMenu.setAttribute("style","width : calc(100%-150px); max-width : 0px; transition: 0.5s; background-color : #131c33; box-shadow: 0 0 0px #043d70; overflow : hidden;");
		ButtonFindLeftRight.setAttribute("value","►");
		BFRLopen = false;
	}else{
		FindPoleMenu.setAttribute("style","width : calc(100%-150px); max-width : "+withs+"px; transition: 0.5s; background-color : #6da4bb; box-shadow: 0 0 15px #043d70; overflow : hidden;");
		ButtonFindLeftRight.setAttribute("value","◄");
		BFRLopen = true;
	}
}
//------for redact user page
//------for KategMenu
var kategmen = document.getElementById("katMen");
var katopen=false; var dvig = false;
var kuregmen = document.getElementById("kurMen");
var kuropen=false; var dvig_kur = false;
function KategClick(){
	if(dvig==false){ dvig=true;
		if(katopen){
			kategmen.setAttribute("style","max-height : "+kategmen.childElementCount*34+"px; display:inline-block; overflow : hidden; transition: 0.5s;");
			katopen=false;
			setTimeout(PostSec, 1, katopen);
		}else{
			kategmen.setAttribute("style","max-height : "+kategmen.childElementCount*34+"px; display:inline-block; overflow : hidden; transition: 0.5s;");
			katopen=true;
			if(kuropen){
				kuregmen.setAttribute("style","max-height : "+kuregmen.childElementCount*34+"px; display:inline-block; overflow : hidden; transition: 0.5s;");
				kuropen=false;
				setTimeout(PostSecKur, 1, kuropen);
			}
			setTimeout(PostSec, 500, katopen);
		}
		setTimeout(function(){dvig=false;}, 500);
	}
}
function PostSec(katop){
	if(katop) kategmen.setAttribute("style","display:inline-block; overflow : hidden; transition: 0.5s;");
	else kategmen.setAttribute("style","max-height : 0px; display:inline-block; overflow : hidden; transition: 0.5s;");
}
//------
function KursClick(){
	if(dvig_kur==false){ dvig_kur = true;
		if(kuropen){
			kuregmen.setAttribute("style","max-height : "+kuregmen.childElementCount*34+"px; display:inline-block; overflow : hidden; transition: 0.5s;");
			kuropen=false;
			setTimeout(PostSecKur, 1, kuropen);
		}else{
			kuregmen.setAttribute("style","max-height : "+kuregmen.childElementCount*34+"px; display:inline-block; overflow : hidden; transition: 0.5s;");
			kuropen=true;
			if(katopen){
				kategmen.setAttribute("style","max-height : "+kategmen.childElementCount*34+"px; display:inline-block; overflow : hidden; transition: 0.5s;");
				katopen=false;
				setTimeout(PostSec, 1, katopen);
			}
			setTimeout(PostSecKur, 500, kuropen);
		}
		setTimeout(function(){dvig_kur = false;}, 500);
	}
}
function PostSecKur(katp){
	if(katp) kuregmen.setAttribute("style","display:inline-block; overflow : hidden; transition: 0.5s;");
	else kuregmen.setAttribute("style","max-height : 0px; display:inline-block; overflow : hidden; transition: 0.5s;");
}
function DelAva(){
	document.getElementById("Ava_mini").setAttribute("src", "resource/Images/Krustik.png");
	document.getElementById("Ava_minib").setAttribute("value", "Удалено");
}
function VV(Chek, Strg){
	document.getElementById(Strg).setAttribute("style", "width : 0%; transition: 0.5s;");
	setTimeout(VVDD, 500, Chek, Strg);
}
function VVDD(Chek, Strg){
	document.getElementById(Strg).setAttribute("style", "width : 100%; transition: 0.5s;");
	if(document.getElementById(Chek).checked){
		document.getElementById(Strg).setAttribute("type", "text");
	}else{
		document.getElementById(Strg).setAttribute("type", "file");
	}
}
//---------------------------------------------
function LFBcl(){
	document.getElementById("Sec").setAttribute("style", "position : relative; left : 110%; transition : 0.5s;");
	LeftMen.style.left = 0;
	RghtMen.style.right = "-100%";//.setAttribute("style", "left : 0%; transition : 0.5s;");
}
function RFBcl(){
	document.getElementById("Sec").setAttribute("style", "position : relative; left : -110%; transition : 0.5s;");
	RghtMen.style.right = 0;
	LeftMen.style.left = "-100%";//.getElementById("Sec").setAttribute("style", "right : 0%; transition : 0.5s;");
}



