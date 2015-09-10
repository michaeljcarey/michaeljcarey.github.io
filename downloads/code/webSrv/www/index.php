<?php 
include("header.php"); 
?>

<script language="javascript">
var timerIsOn = false;
function startStopTimer() {
	var myId = "myTimeStream";

	if (timerIsOn==true)  {			// if timer is on
		timerIsOn = false;				// toggle timer flag to off
		clearInterval(myTimer);
		document.getElementById(myId).innerHTML= "Halted";
	} else {											// else if timer is off
		timerIsOn = true;					// toggle timer flag to on
		myTimer = setInterval(function () { loadXMLDoc(1) }, 1000);
		document.getElementById(myId).innerHTML= "Running";
	}
}

function loadXMLDoc(state) {
	var xmlhttp;
	if (window.XMLHttpRequest)	{ // code for IE7+, Firefox, Crome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var myId;
			if (state ==1) {	
				myId="myTime";
			} else if (state==2) {
				myId="func2";
			} 
			document.getElementById(myId).innerHTML=xmlhttp.responseText;
		}
	}	// end func pointer
	xmlhttp.open("GET", "getTime.php?state=" + state.toString(), true);
	xmlhttp.send();
}
</script>

<TABLE>
<TR><TH colspan=2>Time Web Server Demo</TH></TR>
<TR><TH>Action</TH><TH>Description</TH></TR>
<TR>
	<TD><input type="button" value='Get Once' onClick="loadXMLDoc(1)" ></TD>
	<TD><div id="myTime"><a> Disconnected </a></div></TD>
</TR>
<TR>
	<TD><input type="button" value='Observe Time' onClick="startStopTimer()" ></TD>
	<TD><div id="myTimeStream"><a> Push to Continually Update</a></div></TD>
</TR>
<TR>
	<TD><input type="button" value='Call Another Function' onClick="loadXMLDoc(2)" ></TD>
	<TD><div id="func2"><a> Not Supported </a></div></TD>
</TR>
</TABLE>
