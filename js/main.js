

// Game-Monitor.RS
// Copyrighted material - 2010 BGD-Hosting
// Coded and designed by geras1m.com

function preload() {
	btn1= new Image(132,73); 
	btn1.src="/style/images/gm_over_22.png";
	btn2= new Image(132,73); 
	btn2.src="/style/images/gm_over_24.png";
	btn3= new Image(132,73); 
	btn3.src="/style/images/gm_over_26.png";
	btn4= new Image(132,73); 
	btn4.src="/style/images/gm_over_28.png";
	btn5= new Image(132,73); 
	btn5.src="/style/images/gm_over_30.png";
	btn6= new Image(93,23); 
	btn6.src="/style/images/gm_over_10.png";
	btn7= new Image(93,23); 
	btn7.src="/style/images/gm_over_12.png";
	btn8= new Image(259,73); 
	btn8.src="/style/images/gm_over_33.png";
	btn9= new Image(132,23);
	btn8.src="/style/images/gm_over_14.png";
}

function setimage(id, val) {
	document.getElementById(id).src = val;
}
function setinner(id, val) {
	document.getElementById(id).innerHTML = val;
}
function banners(sid) {
	var ip = document.getElementById("ip").innerHTML;
	var col = document.getElementById("color").value;
	setimage("img1", "/banner/1/"+sid+"/"+col+".png");
	setimage("img2", "/banner/2/"+sid+"/"+col+".png");
	setimage("img3", "/banner/3/"+sid+"/"+col+".png");
	setinner("code1", "<a href=\"http:\/\/www.game-monitor.rs\/server\/"+ip+"\"><img src=\"http:\/\/www.game-monitor.rs\/banner\/1\/"+sid+"\/"+col+".png\"><\/a>");
	setinner("code2", "[url=http:\/\/www.game-monitor.rs\/server\/"+ip+"][img]http:\/\/www.game-monitor.rs\/banner\/1\/"+sid+"\/"+col+".png[\/img][\/url]");
	setinner("code3", "<a href=\"http:\/\/www.game-monitor.rs\/server\/"+ip+"\"><img src=\"http:\/\/www.game-monitor.rs\/banner\/2\/"+sid+"\/"+col+".png\"><\/a>");
	setinner("code4", "[url=http:\/\/www.game-monitor.rs\/server\/"+ip+"][img]http:\/\/www.game-monitor.rs\/banner\/2\/"+sid+"\/"+col+".png[\/img][\/url]");
	setinner("code5", "<a href=\"http:\/\/www.game-monitor.rs\/server\/"+ip+"\"><img src=\"http:\/\/www.game-monitor.rs\/banner\/3\/"+sid+"\/"+col+".png\"><\/a>");
	setinner("code6", "[url=http:\/\/www.game-monitor.rs\/server\/"+ip+"][img]http:\/\/www.game-monitor.rs\/banner\/3\/"+sid+"\/"+col+".png[\/img][\/url]");
}
