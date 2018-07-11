<?php 
header('Content-type: text/html; charset=windows-1251');
?>
<style>
a#input-minus, a#input-plus {text-decoration:none;color:black;font-size:smaller}
td {white-space:nowrap}
</style>
<script>
function input_mod(a){
	var inp = document.getElementById(a.getAttribute('for'));
	var val = (a.getAttribute('id')=='input-minus'?-1:1);
	if (inp) {
		var step=(inp.getAttribute('step')?inp.getAttribute('step'):1);
		if (parseInt(inp.value)>0) {
			val=parseInt(inp.value)+val*step;
		} else {
			val=val*step;
		}
		var min=(inp.getAttribute('min')?inp.getAttribute('min'):0);
		if ((!inp.getAttribute('max') || val<=inp.getAttribute('max')) && val>=min) {
			if (val==0 && inp.getAttribute('zero')) val=inp.getAttribute('zero');
			inp.value=val;
			//inp.change();
		}
	}
}
</script>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name=viewport content="width=device-width, initial-scale=1">
<!-- border-style:solid; for Mozilla ? -->
<style>
a 	{font-family: verdana, arial, helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #0000cc; text-decoration: underline }
a.service_url	{color: inherit; text-decoration: none; border-bottom: 1px dashed}
th	{font-family: verdana, arial, helvetica, sans-serif; font-weight: bold; color: #ffffff; background-color:#3333A2; padding: 2px 2px}
th a	{font-weight: bold; color: #ffffff;}
option	{border-color:#000000; border-width:1; font-size: 11px}
select	{border-color:#000000; border-width:1; font-size: 11px;background-color:white}
input, button {border-color:#000000; border-width:1; font-size: 11px;background-color:white}
input[type=radio] {height: 11px;margin:0px}
input.box	{border-style:solid}
textarea	{border-color:#000000; border-width:1; font-size: 12px; border-style:solid; background-color:white}
body	{font-family: verdana, arial, helvetica, sans-serif; font-size: 11px; font-weight: normal; color: #000000 }
h5	{font-family: verdana, arial, helvetica, sans-serif; font-size: 12px}
h5 span	{font-weight: normal}
table,td,tr	{font-family: verdana, arial, helvetica, sans-serif; font-size: 11px; border: 0}
td	{vertical-align:top; padding: 2px 4px}
td.toggle	{padding: 0px 0px}
#table.details td {padding: 2px 5px}
tr	{background-color:white};
table	{background-color:#3333A2}
hr	{height:1}
form    {margin:0}
.ex	{color:gray; font-style:italic}
.disabled, .disabled font {text-decoration:line-through}
.zero_use {color:gray}
.c	{text-align: center}
.r	{text-align: right}
.l	{text-align: left}
small	{font-size: 10px}
table[border~="1"] tr:nth-child(even) {background-color: #eee}
table[border~="1"] tr:nth-child(odd) {background-color: white}
table[border~="1"] tr:hover {background-color: #ddd}
table#nodes-table{border: 0px; border-spacing: 0px; empty-cells: show;}
#nodes-table td {border: 0px; border-bottom: 1px solid #999; border-collapse: collapse; padding: 2px 2px;}
#nodes-table tr:hover {background-color: #ddd}
#nodes-table th {background: #fbfbfb; color: #000; border-bottom: 2px solid #999;}
</style></head>
<body><basefont face="verdana, arial, helvetica, sans-serif">
<script>
function isDigit(charCode){ return (charCode >= 48 && charCode <= 57)}
function isLat(charCode){ return ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122))}
function isRus(charCode){ return (charCode >= 1040 && charCode <= 1103)}
function filter(evt,set,exc,x) { //set= 1 - digit 2 - lat 4 - rus; x=кроме set
	evt = (evt) ? evt : ((event) ? event : null);
	if (evt) {
		var charCode = (evt.charCode || evt.charCode == 0) ? evt.charCode :
			((evt.keyCode) ? evt.keyCode : evt.which);
//alert(charCode);
		if (charCode > 13 && !x^(!(set&1 && isDigit(charCode)) && !(set&2 && isLat(charCode)) && !(set&4 && isRus(charCode)) && exc.indexOf(String.fromCharCode(charCode))==-1)) {
//		if (evt.returnValue) {
//			evt.returnValue = false;
//		} else if (evt.preventDefault) {
			if (evt.preventDefault) { evt.preventDefault(); } else { evt.returnValue = false; return false; }
		}
	}
}
var transl = {"Ё":"YO","Й":"I","Ц":"TS","У":"U","К":"K","Е":"E","Н":"N","Г":"G","Ш":"SH","Щ":"SCH","З":"Z","Х":"H","Ъ":"","ё":"yo","й":"i","ц":"ts","у":"u","к":"k","е":"e","н":"n","г":"g","ш":"sh","щ":"sch","з":"z","х":"h","ъ":"","Ф":"F","Ы":"I","В":"V","А":"a","П":"P","Р":"R","О":"O","Л":"L","Д":"D","Ж":"ZH","Э":"E","ф":"f","ы":"i","в":"v","а":"a","п":"p","р":"r","о":"o","л":"l","д":"d","ж":"zh","э":"e","Я":"Ya","Ч":"CH","С":"S","М":"M","И":"I","Т":"T","Ь":"","Б":"B","Ю":"YU","я":"ya","ч":"ch","с":"s","м":"m","и":"i","т":"t","ь":"","б":"b","ю":"yu"};
function Lat(text){
	var result="";
	for(i=0;i<text.length;i++) {
		if(transl[text[i]]!=undefined) { result+=transl[text[i]]; }
		else { result+=text[i]; }
	}
	return result;
}
function fieldCheck(field,regexp){
	if (!field || !regexp || !field.value || !field.style) return;
	var re = new RegExp(regexp);
	if (re && !re.test(field.value)) {
		field.style.borderColor="red";
		field.style.color="red";
	} else {
		field.style.borderColor="black";
		field.style.color="black";
	}
}
function Limit(field,max) { if (field.value.length>max) field.value=field.value.substr(0,max-1); }
function maxLen(evt,field,max) {
	evt = (evt) ? evt : ((event) ? event : null);
	if (evt && (field.value.length>=max)) {
		Limit(field,max);
        	if (evt.preventDefault) { evt.preventDefault();	} 
		else { evt.returnValue = false;	return false; }
	}
}
var HelpWnd;
function Help(id){
	HlpWnd=window.open("",null,"width=400,height=300,status=no,toolbar=no,menubar=no,location=no,resizable=yes,scrollbars=yes");
	HlpWnd.document.write("<title>please wait...</title>");
	HlpWnd.focus();
	HlpWnd.location="help.php?show="+id;
}
var Plan;
function ChoosePlan(field,def){
	if (!def && field) def=field.value;
	Plan=field;
	PlanWnd=window.open("",null,"width=350,height=450,status=no,toolbar=no,menubar=no,location=no,resizable=yes,scrollbars=no");
	PlanWnd.document.write("<title>please wait...</title>");
	PlanWnd.focus();
	PlanWnd.location="plan.php?str="+def;
}
function Disable(field){
	if (field && !field.disabled) {
		field.disabled=true;
		field.style.borderColor="silver";
	}
};
function Enable(field){
	if (field && field.disabled) {
		field.disabled=false;
		field.style.borderColor="black";
	}
};
function Decode(code,key){
	var str="";
	for (var i=0;i<code.length;i++) {
		str=str+String.fromCharCode(code.charCodeAt(i)-key.charCodeAt(i)+48);
	}
	return str;
}
function mhref(code,key,link){ link.href="ma"+"ilt"+"o:"+Decode(code,key); }
function MTo(code,key,name){
	var addr=Decode(code,key);
	if (name=="") name=addr;
	document.write("<a href=m"+"ai"+"lto"+":"+addr+">"+name+"</a>");
}
function goURL(page,noselect){
	if (noselect==1) {
		if (document.getSelection) selection = document.getSelection();
		else selection = document.selection.createRange().text;
		if (selection!="") return false;
	}
	document.location.href=page;
}
//function toggle_visibility(id){
//	var e;
//	if ((e=document.getElementById(id)) && e.style) 
//		if(e.style.display == "none") e.style.display = "table-row";
//		else e.style.display = "none";
//} 
</script>

<center><h5>Выбор тарифного плана</h5>
<script>
function calc_sql(){
	e=document.forms.tab.elements;
	if (e.sql.checked) {
		e.php.checked=true;
	}
}
function calc_php(){
	e=document.forms.tab.elements;
	if (!e.php.checked) {
		e.sql.checked=false;
	}
}
function OS(f){
	e=document.forms.tab.elements;
	m=parseInt(e.m.value);
	if (m) { 
		if (m<10) e.m.value=m=10;
		else e.m.value=m=5*Math.round(m/5);
	}
	php=e.php.checked;
	sql=e.sql.checked;
	ip=e.ip.checked;
		d2=parseInt(e.d2.value);
	ad=parseInt(e.ad.value);
	d3=parseInt(e.d3.value);
	loc=(e.loc?e.loc.value:"-RU");
	mm="U";
	plan=mm+(m?m:10)+(php?"P":"")+(sql?"B":'')+(ad?"A"+ad:"")+(d2?"D"+d2:"")+(d3?"S"+d3:"")+(ip?"I4":"")+loc;
	document.location.href="plan.php?str="+plan;
	return false;
}
</script>
<form method=get style="MARGIN: 0px; PADDING: 0px" name=tab onSubmit="return OS()">
<p>Группа&nbsp;тарифов:&nbsp;<select name=group onChange='document.location.href="plan.php?group="+this.value'>
<option value='unlim' selected>Безлимитные тарифы</option><option value='vip' >VIP-тарифы</option><option value='cms' >CMS-тарифы</option><option value='res' >Реселлерские</option></select></p>
<table cellspacing=0 border=0>
<tr>
<input type=hidden name=loc value="-RU"><td colspan=2>Место:</td>
<td><a href="#" id="input-minus" for="m" onclick="input_mod(this)">[-]</a><input id="m" name="m" maxlength=5 size=5 value="1000" min="1000" step="500"><a href="#" id="input-plus" for="m" onclick="input_mod(this)">[+]</a> Мб</td>
</tr><tr>
<td colspan=2>Поддержка PHP/CGI/Cron:</td>
<td style='padding-left:10px'><input type=checkbox name=php value=1 checked onChange=calc_php() onClick=calc_php()></td>
</tr><tr>
<td colspan=2>Поддержка mySQL:</td>
<td style='padding-left:10px'><input type=checkbox name=sql value=1 checked onChange=calc_sql() onClick=calc_sql()></td>
</tr><tr>
<td colspan=2>Выделенный IP:</td>
<td style='padding-left:10px'><input type=checkbox name=ip value=1></td>
</tr>
<tr>
<td>Поддомены:</td><td>&nbsp;5&nbsp;+&nbsp;</td>
<td><a href="#" id="input-minus" for="d3" onclick="input_mod(this)">[-]</a><input id="d3" name="d3" maxlength="3" size=5 value=""><a href="#" id="input-plus" for="d3" onclick="input_mod(this)">[+]</a></td>
</tr><tr>
<tr>
<td>Паркованные домены:</td><td>&nbsp;5&nbsp;+&nbsp;</td>
<td><a href="#" id="input-minus" for="d2" onclick="input_mod(this)">[-]</a><input id="d2" name="d2" maxlength="3" size=5 value=""><a href="#" id="input-plus" for="d2" onclick="input_mod(this)">[+]</a></td>
</tr><tr>
<td colspan=2>Дополнительные домены:</td>
<td><a href="#" id="input-minus" for="ad" onclick="input_mod(this)">[-]</a><input id="ad" name="ad" maxlength="3" size=5 value=""><a href="#" id="input-plus" for="ad" onclick="input_mod(this)">[+]</a></td>
</tr>

<tr>
<td colspan=3 align="center"><br><input type="submit" value="Посчитать" name="submit"></td>
</tr>
</table>

<p>Тарифный план: <nobr><b>U1000PB-RU</b></nobr>
<br>Цена: <b>50.00 руб./мес</b> <nobr>(<b>540.00 руб./год</b>)</nobr></p>

<input type=button name=ok value='   Выбрать   ' OnClick='opener.focus(); if (opener.Plan) opener.Plan.value="U1000PB-RU"; window.close()' >

</form></center>
<script>
var e=document.forms.tab.elements;
if (e.loc && e.loc.value=='' && e.php ) { e.php.disabled=true; e.php.value='P'; } else if (e.php) e.php.disabled=false;
if (!opener || !opener.Plan) {
	e.ok.value='Закрыть';
	e.ok.disabled=false;
}
</script>
