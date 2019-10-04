function createREQ() {
try {
     req = new XMLHttpRequest(); /* p.e. Firefox */
     } catch(err1) {
       try {
       req = new ActiveXObject('Msxml2.XMLHTTP'); /* algunas versiones IE */
       } catch (err2) {
         try {
         req = new ActiveXObject("Microsoft.XMLHTTP"); /* algunas versiones IE */
         } catch (err3) {
          req = false;
         }
       }
     }
     return req;
}
function requestGET(url, query, req) {
myRand=parseInt(Math.random()*99999999);
req.open("GET",url+'?'+query+'&rand='+myRand,true);
req.send(null);
}
function requestPOST(url, query, req) {
req.open("POST", url,true);
req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
req.send(query);
}
function doCallback(callback,item) {
eval(callback + '(item)');
}
function doAjax(url,query,callback,reqtype,getxml) 
{
// crea la instancia del objeto XMLHTTPRequest 
var myreq = createREQ();
myreq.onreadystatechange = function() {
if(myreq.readyState == 4) {
   if(myreq.status == 200) {
      var item = myreq.responseText;
      if(getxml==1) {
         item = myreq.responseXML;
      }
      doCallback(callback, item);
    }
  }
}
if(reqtype=='post') {
requestPOST(url,query,myreq);
} else {
requestGET(url,query,myreq);
}
} 


/*
*Esta libreria es una libreria AJAX creada por Javier Mellado con la inestimable
*colaboracion de Beatriz Gonzalez.
*y descargada del portal AJAX Hispano oAjax://www.ajaxhispano.com
*contacto javiermellado@gmail.com
*
*Puede ser utilizada, pasada, modificada pero no olvides mantener
*el espiritu del software libre y respeta GNU-GPL
*/ 

function creaAjax() {
var req;
try {
	req = new XMLHttpRequest();
} catch(err1) {
	try {
		req = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (err2) {
		try {
			req = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (err3) {
				req = false;
			}
		}
	}
	return req;
}

oAjax = creaAjax();
oAjax2 = creaAjax();
oAjax3 = creaAjax();
oAjax4 = creaAjax();


function fAjax(url,vars,capa){
	myRand = parseInt(Math.random()*999999999999999);
	var geturl = url +"?rand=" + myRand + vars; 
	oAjax.open("GET", geturl, true);
	capa_rpta = capa;
	oAjax.onreadystatechange = rAjax;
	oAjax.send(null);
}

function rAjax() {
	if (oAjax.readyState == 4) {
		if(oAjax.status == 200) {
			var miTexto = oAjax.responseText;
			document.getElementById(capa_rpta).innerHTML = (miTexto);
		}else{
			document.getElementById(capa_rpta).innerHTML = "<img src='img/procesando.gif' />";
		}
	}
}

function fAjax2(url2,vars2,capa2){
	myRand2 = parseInt(Math.random()*999999999999999);
	var geturl2 = url2 +"?rand2=" + myRand2 + vars2; 
	oAjax2.open("GET", geturl2, true);
	capa_rpta2 = capa2;
	oAjax2.onreadystatechange = rAjax2;
	oAjax2.send(null);
}

function rAjax2() {
	if (oAjax2.readyState == 4) {
		if(oAjax2.status == 200) {
			var miTexto2 = oAjax2.responseText;
			document.getElementById(capa_rpta2).innerHTML = (miTexto2);
		}else{
			document.getElementById(capa_rpta).innerHTML = "<img src='img/procesando.gif' />";
		}
	}
}


function fAjax4(url4,vars4,capa4){
	myRand4 = parseInt(Math.random()*999999999999999);
	var geturl4 = url4 +"?rand4=" + myRand4 + vars4; 
	oAjax4.open("GET", geturl4, true);
	capa_rpta4 = capa4;
	oAjax4.onreadystatechange = rAjax4;
	oAjax4.send(null);
}

function rAjax4() {
	if (oAjax4.readyState == 4) {
		if(oAjax4.status == 200) {
			var miTexto4 = oAjax4.responseText;
			document.getElementById(capa_rpta4).innerHTML = (miTexto4);
		}else{
			document.getElementById(capa_rpta4).innerHTML = "<img src='img/procesando.gif' />";
		}
	}
}



function getVar(url2,vars2){
	myRand2 = parseInt(Math.random()*999999999999999);
	var geturl2 = url2 +"?rand2=" + myRand2 + vars2; 
	oAjax3.open("GET", geturl2, true);
	oAjax3.onreadystatechange = rAjax3;
	oAjax3.send(null);
}

function rAjax3() {
	if (oAjax3.readyState == 4) {
		if(oAjax3.status == 200) {
		}
	} else {
	}
}

function fMostrarOcultar(vars2,nombreCapa){
	if (vars2==false){
		document.getElementById(nombreCapa).style.visibility="visible"; 
	}else{
		document.getElementById(nombreCapa).style.visibility="hidden"; 
	}
}

