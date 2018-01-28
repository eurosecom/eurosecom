// holds an instance of XMLHttpRequest
var xmlHttp = createXmlHttpRequestObject();

// creates an XMLHttpRequest instance
function createXmlHttpRequestObject() 
{
  // will store the reference to the XMLHttpRequest object
  var xmlHttp;
  // this should work for all browsers except IE6 and older
  try
  {
    // try to create XMLHttpRequest object
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    // assume IE6 or older
    var XmlHttpVersions = new Array("MSXML2.XMLHTTP.6.0",
                                    "MSXML2.XMLHTTP.5.0",
                                    "MSXML2.XMLHTTP.4.0",
                                    "MSXML2.XMLHTTP.3.0",
                                    "MSXML2.XMLHTTP",
                                    "Microsoft.XMLHTTP");
    // try every prog id until one works
 
    for (var i=0; i<XmlHttpVersions.length && !xmlHttp; i++) 
    {
      try 
      { 
        // try to create XMLHttpRequest object
        xmlHttp = new ActiveXObject(XmlHttpVersions[i]);
      } 
      catch (e) {}
    }
  }
  // return the created object or display an error message
  if (!xmlHttp)
    alert("Error creating the XMLHttpRequest object.");
  else 
    return xmlHttp;
}

// read a file from the server
function urobVyrSaldo()
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      //nastav hodiny
      bodywhite = document.getElementById("white");
      bodywhite.style.cursor = "wait";

      var prm1 = document.forms.forms1.h_ico.value; 
      var prm2 = document.forms.forms1.h_nai.value; 
      var prm3 = document.forms.forms1.h_uce.value; 
      var prm4 = 0;

      // create the params string
      var params = "prm1=" + prm1 + "&prm2=" + prm2 + "&prm3=" + prm3 +
                   "&prm4=" + prm4;

      // initiate reading a file from the server
      if( prm3 == 1 ) { xmlHttp.open("GET", "daj_ukazvop_xml.php?" + params, true); }
      if( prm3 != 1 ) { xmlHttp.open("GET", "daj_ukazeop_xml.php?" + params, true); }
      xmlHttp.onreadystatechange = cakajVyrSaldo;
      xmlHttp.send(null);
    }
    // display the error in case of failure
    catch (e)
    {
      alert("Can't connect to server:\n" + e.toString());
    }
  }
}


// function called when the state of the HTTP request changes
function cakajVyrSaldo() 
{
  // when readyState is 4, we are ready to read the server response
  if (xmlHttp.readyState == 4) 
  {
    // continue only if HTTP status is "OK"
    if (xmlHttp.status == 200) 
    {
      try
      {

        // vypis do tabulky samostatnej ;
          tabulka_VyrSaldoXML();

      }
      catch(e)
      {
        // display error message
        alert("Error reading the response: " + e.toString());
      }
    } 
    else
    {
      // display status message
      alert("There was a problem retrieving the data:\n" + 
            xmlHttp.statusText);
 
    }
  }
}



// vypis do tabulky s parametrom
function tabulka_VyrSaldoXML()
{
  // read the message from the server
  var xmlResponse = xmlHttp.responseXML;
  // catching potential errors with IE and Opera
  if (!xmlResponse || !xmlResponse.documentElement)
    throw("Invalid XML structure:\n" + xmlHttp.responseText);
  // catching potential errors with Firefox
  var rootNodeName = xmlResponse.documentElement.nodeName;
  if (rootNodeName == "parsererror") throw("Invalid XML structure");
  // obtain the XML's document element
  xmlRoot = xmlResponse.documentElement;  
  // obtain arrays with book titles and ISBNs 
  pol01Array = xmlRoot.getElementsByTagName("pol01");
  pol02Array = xmlRoot.getElementsByTagName("pol02");
  pol03Array = xmlRoot.getElementsByTagName("pol03");
  pol04Array = xmlRoot.getElementsByTagName("pol04");
  pol05Array = xmlRoot.getElementsByTagName("pol05");
  pol06Array = xmlRoot.getElementsByTagName("pol06");
  pol07Array = xmlRoot.getElementsByTagName("pol07");
  pol08Array = xmlRoot.getElementsByTagName("pol08");
  pol09Array = xmlRoot.getElementsByTagName("pol09");
  // generate HTML output
  var ggg = 0;
  var hlv = 0;
  var prf = 0;
  var dol = 0;
  var huh = 0;

  for (var i=0; i<pol01Array.length; i++)
    {
    ggg = pol07Array.item(i).firstChild.data;
    }

  for (var i=0; i<pol01Array.length; i++)
    {
    hlv = pol08Array.item(i).firstChild.data;
    if( hlv == 1400 ) { huh = 1*huh + 1*pol06Array.item(i).firstChild.data ; }
    if( hlv == 1450 ) { huh = 1*huh + 1*pol06Array.item(i).firstChild.data ; }
    }

  var html = "<table  class='ponuka' width='100%'><tr><td colspan='9' ></td></tr>";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {

    hlv = pol08Array.item(i).firstChild.data;

    if( hlv == 2 ) {
    html += "<tr>"+
            "<td width='100%' class='pvstuz' align='left' colspan='6'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }

    if( hlv == 1 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }


    if( hlv == 0 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right' onmouseover=\"UkazSkryj('Úprava základných údajov');\" onmouseout=\"Okno.style.display='none';\" >"; 

html += "<a href=\"#\" onClick=\"window.open('dopzak.php?copern=8&page=1&cislo_zak=" + pol01Array.item(i).firstChild.data +
"&h_zak=" + pol01Array.item(i).firstChild.data + " ', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol01Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
    html += "<tr>"+ "<td colspan='6' class='ponuka'>Poznámka: " + pol09Array.item(i).firstChild.data + "</td>" + "</tr>";
                   }


//datumy
    if( hlv == 11 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='ponuka' colspan='5'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }

//vyrobky

    if( hlv == 502 ) {
    html += "<tr>"+

            "<td width='50%' class='pvstuz' align='left' colspan='3'>"; 

html += "<a href=\"#\" onClick=\"window.open('../vyroba/model.php?copern=2&drupoh=1&page=1&cislo_zak=" + pol03Array.item(i).firstChild.data + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
            "<img src='../obr/naradie.png' width=15 height=12 border=0 title='Modelova nový výrobok'></a>";

html += "<a href=\"#\" onClick=\"window.open('../vyroba/dopzak.php?copern=108&cislo_zak=" + pol03Array.item(i).firstChild.data + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Vloži a upravi výrobky'></a>";

html += "<a href=\"#\" onClick=\"TlacPrace(" + pol03Array.item(i).firstChild.data + ");\">" +
            "<img src='../obr/tlac.png' width=15 height=12 border=0 title='Vytlaèi Práce na zákazke'></a>";

html += "<a href=\"#\" onClick=\"TlacMat(" + pol03Array.item(i).firstChild.data + ");\">" +
            "<img src='../obr/tlac.png' width=15 height=12 border=0 title='Vytlaèi Materiál na zákazke'></a>";

html += "<a href=\"#\" onClick=\"TlacSumar(" + pol03Array.item(i).firstChild.data + ");\">" +
            "<img src='../obr/tlac.png' width=15 height=12 border=0 title='Vytlaèi Sumár na zákazke'></a>";

    html += pol01Array.item(i).firstChild.data + "</td>";

    html += "<td width='50%' class='pvstuz' align='right' colspan='3'>"; 

html += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrspot.php?copern=10&drupoh=1&page=1&cislo_zak=" + pol03Array.item(i).firstChild.data + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Priradenie receptúr na výrobok'></a>";

html += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrspot.php?copern=30&drupoh=1&page=1&cislo_zak=" + pol03Array.item(i).firstChild.data + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
            "<img src='../obr/tlac.png' width=20 height=12 border=0 title='Výrobné náklady a tržby za predané výrobky na zákazke'></a>";

html += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrspot.php?copern=30&drupoh=1&page=1&spo=1&cislo_zak=" + pol03Array.item(i).firstChild.data + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
            "<img src='../obr/tlac.png' width=20 height=12 border=0 title='Spotreba výrobných komponentov a operácií na zákazke'></a>";

    html += "</td></tr>";
                   }

    if( hlv == 501 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 500 ) {
    html += "<tr>"+
            "<td class='ponuka' align='right' ></td>" +  
            "<td class='ponuka' colspan='5'>" + pol09Array.item(i).firstChild.data + "</td>" +  
            "</tr>";
    html += "<tr>"+
            "<td class='ponuka' align='right' ></td>" +  
            "<td class='ponuka'>" + pol02Array.item(i).firstChild.data + "</td>" +  
            "<td class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }


    if( hlv == 503 ) {
    html += "<tr>"+
            "<td width='90%' class='pvstup' align='right' colspan='5'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='10%' class='pvstup' align='right'>" + pol02Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

//material

    if( hlv == 102 ) {
    html += "<tr>"+
            "<td width='100%' class='pvstuz' align='left' colspan='6'>"; 

html += "<a href=\"#\" onClick=\"window.open('../sklad/vstp_u.php?copern=5&drupoh=2&page=1" + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +

            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nová výdajka na materiál'></a>";


html += " <a href=\"#\" onClick=\"window.open('../sklad/vstp_u.php?copern=5&drupoh=1&page=1" + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +

            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nová príjemka na materiál'></a>";

    html += pol01Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }

    if( hlv == 101 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 100 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right' onmouseover=\"UkazSkryj('Úprava výdajky');\" onmouseout=\"Okno.style.display='none';\">"; 

html += "<a href=\"#\" onClick=\"window.open('../sklad/vstp_u.php?copern=8&drupoh=2&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol01Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 103 ) {
    html += "<tr>"+
            "<td width='90%' class='pvstup' align='right' colspan='5'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='10%' class='pvstup' align='right'>" + pol02Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

//prac.operacie

    if( hlv == 202 ) {
    html += "<tr>"+
            "<td width='100%' class='pvstuz' align='left' colspan='6'>"; 

html += "<a href=\"#\" onClick=\"window.open('pracprik.php?copern=5&drupoh=1&page=1" + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +

            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nový pracovný príkaz'></a>";

    html += pol01Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }


    if( hlv == 201 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 200 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right'  onmouseover=\"UkazSkryj('Úprava výrobného príkazu');\" onmouseout=\"Okno.style.display='none';\">"; 

html += "<a href=\"#\" onClick=\"window.open('vyrprik.php?copern=108&cislo_vpr=" + pol01Array.item(i).firstChild.data +
"&cislo_cpr=" + pol09Array.item(i).firstChild.data + "', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol09Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 203 ) {
    html += "<tr>"+
            "<td width='90%' class='pvstup' align='right' colspan='5'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='10%' class='pvstup' align='right'>" + pol02Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 999 ) {
    html += "<tr>"+
            "<td width='90%' class='pvstuz' align='right' colspan='5'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='10%' class='pvstuz' align='right'>" + pol02Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

//predfaktury

    if( hlv == 1102 ) {
    html += "<tr>"+
            "<td width='100%' class='pvstuz' align='left' colspan='6'>"; 

html += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrzak.php?vyroba=1&copern=5&drupoh=52&page=1" + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +

            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nová predfaktúra'></a>";

    html += pol01Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }

    if( hlv == 1101 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 1100 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right' onmouseover=\"UkazSkryj('Úprava predfaktúry');\" onmouseout=\"Okno.style.display='none';\">"; 

html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?vyroba=1&copern=8&drupoh=52&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol01Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>"; 

    prf = pol01Array.item(i).firstChild.data;

    html += " <img onClick=\"VytlacPredFakt(" + pol01Array.item(i).firstChild.data + ")\" src='../obr/pdf.png' width=15 height=12 border=0 title='Tlaè predfaktúry vo formáte PDF'> ";


    html += "" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

//dodacie listy

    if( hlv == 1202 ) {
    html += "<tr>"+
            "<td width='100%' class='pvstuz' align='left' colspan='6'>"; 

html += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrzak.php?vyroba=1&copern=5&drupoh=12&page=1" + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +

            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nový dodací list'></a>";

    html += pol01Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }

    if( hlv == 1201 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 1200 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right' onmouseover=\"UkazSkryj('Úprava dodacieho listu');\" onmouseout=\"Okno.style.display='none';\">"; 

html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?vyroba=1&copern=8&drupoh=12&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol01Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>"; 

    dol = pol01Array.item(i).firstChild.data;

html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?vyroba=1&copern=20&drupoh=12&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )\">" +

            "<img src='../obr/tlac.png' width=15 height=12 border=0 title='Tlaè dodacieho listu'></a>";

html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?vyroba=1&copern=20&drupoh=12&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"&ceny=0', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )\">" +

            "<img src='../obr/tlac.png' width=15 height=12 border=0 title='Tlaè dodacieho listu bez cien'></a>";

    html += "" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

//faktury

    if( hlv == 1302 ) {
    html += "<tr>"+
            "<td width='100%' class='pvstuz' align='left' colspan='6'>"; 

html += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrzak.php?vyroba=1&copern=5&drupoh=31&page=1&prf=" + prf + "&dol=" + dol + "&huh=" + huh +
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +

            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nová faktúra'></a>";

    html += pol01Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }

    if( hlv == 1301 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 1300 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right' onmouseover=\"UkazSkryj('Úprava faktúry');\" onmouseout=\"Okno.style.display='none';\">"; 

html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?vyroba=1&copern=8&drupoh=31&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol01Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>"; 



    html += " <img onClick=\"VytlacFakt(" + pol01Array.item(i).firstChild.data + ")\" src='../obr/pdf.png' width=15 height=12 border=0 title='Tlaè faktúry vo formáte PDF'> ";

    html += "" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

//uhrady

    if( hlv == 1402 ) {
    html += "<tr>"+
            "<td width='100%' class='pvstuz' align='left' colspan='6'>"; 

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=3&page=1&hladaj_uce=21100" + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nová úhrada v hotovosti'></a>";

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=4&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=22100" + 
"', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
            "<img src='../obr/ziarovka.png' width=15 height=12 border=0 title='Nová úhrada cez banku'></a>";

    html += pol01Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
                   }

    if( hlv == 1401 ) {
    html += "<tr>"+
            "<td width='10%' class='pvstup' align='right'>" + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='20%' class='pvstup'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='pvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='pvstup' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='pvstup' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 1400 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right' onmouseover=\"UkazSkryj('Úprava úhrady v hotovosti');\" onmouseout=\"Okno.style.display='none';\">"; 

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=8&drupoh=3&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol01Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>"; 

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_t.php?copern=20&drupoh=3&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )\">" +

            "<img src='../obr/tlac.png' width=15 height=12 border=0 title='Tlaè úhrady'></a>";

    html += "" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    if( hlv == 1450 ) {
    html += "<tr>"+
            "<td width='10%' class='ponuka' align='right' onmouseover=\"UkazSkryj('Úprava úhrady cez banku');\" onmouseout=\"Okno.style.display='none';\">"; 

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=8&drupoh=4&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT&rozuct=ANO&sysx=UCT', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol01Array.item(i).firstChild.data + "</a>";

    html += "</td>" + 
            "<td width='20%' class='ponuka'>"; 

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_t.php?copern=20&drupoh=4&page=1&cislo_dok=" + pol01Array.item(i).firstChild.data + 
"', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )\">" +

            "<img src='../obr/tlac.png' width=15 height=12 border=0 title='Tlaè úhrady'></a>";

    html += "" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='30%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='20%' class='ponuka' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td width='10%' class='ponuka' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "</tr>";
                   }

    }

  // obtain a reference to the <div> element on the page
     html += "</table>";


  bodywhite.style.cursor = "auto";
  mySaldo = document.getElementById("mySaldoelement");
  // display the HTML output
  mySaldo.innerHTML = html;
  mySaldoelement.style.display='';
}




