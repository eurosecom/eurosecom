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
function urobSaldo()
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      var prm1 = document.forms.forms1.h_ico.value; 
      var prm2 = document.forms.forms1.h_nai.value; 
      var prm3 = document.forms.forms1.h_uce.value; 
      var obd  = document.forms.forms1.h_obd.value; 
      var prm4 = 0;
      var h_al = 0;
      if( document.formx1.h_al.checked ) h_al=1;

      // create the params string
      var params = "prm1=" + prm1 + "&prm2=" + prm2 + "&prm3=" + prm3 + "&obd=" + obd + "&h_al=" + h_al +
                   "&prm4=" + prm4;

      // initiate reading a file from the server
      xmlHttp.open("GET", "daj_saldo_xml.php?" + params, true);
      xmlHttp.onreadystatechange = pockajSaldo;
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
function pockajSaldo() 
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
          karta_SaldoXML();

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
function karta_SaldoXML()
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
  pol10Array = xmlRoot.getElementsByTagName("pol10");
  pol11Array = xmlRoot.getElementsByTagName("pol11");
  pol12Array = xmlRoot.getElementsByTagName("pol12");
  // generate HTML output
  var ggg = 0;
  var zmlspl = 0;
  var faktury = 0;
  var uhrady = 0;
  var zostatok = 0;

  var html = "<table  class='fmenu' width='100%'><tr>" +
             "<td width='10%' >Saldokonto</td>" +
             "<td width='10%' align='right'>Ume</td>" +
             "<td width='10%' align='right' >Doklad</td>" +
             "<td width='10%' >Vyhotovená</td>" +
             "<td width='10%' >Splatná</td>" +
             "<td width='10%' align='right' >IÈO</td>" +
             "<td width='10%' align='right' >Faktúra èíslo</td>" +
             "<td width='10%' align='right' >Hodnota</td>" +
             "<td width='10%' align='right' >Úhrada</td>" +
             "<td width='10%' align='right' >Zostatok</td>" +

             "</tr>";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {

    var drupoh = pol10Array.item(i).firstChild.data;
    faktury = faktury + 1*pol09Array.item(i).firstChild.data;
    uhrady = uhrady + 1*pol11Array.item(i).firstChild.data;
    zostatok = zostatok + 1*pol12Array.item(i).firstChild.data;

    html += "<tr>"+
            "<td class='hvstup'>Úèet " + pol01Array.item(i).firstChild.data + "</td>" +

            "<td class='hvstup' align='right'>" + pol02Array.item(i).firstChild.data + "</td>" +

            "<td class='pvstuz' align='right'>";

  if ( drupoh == 11 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=" + pol01Array.item(i).firstChild.data + 
"&rozuct=ANO&copern=8&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=" + pol07Array.item(i).firstChild.data + "', '_blank'," +
" 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='Úprava príjmového pokladnièného dokladu'></a>";

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_t.php?copern=20&drupoh=1&page=1&sysx=UCT&rozuct=ANO&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 12 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=" + pol01Array.item(i).firstChild.data + 
"&rozuct=ANO&copern=8&drupoh=2&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=" + pol07Array.item(i).firstChild.data + "', '_blank'," +
" 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='Úprava výdavkového pokladnièného dokladu'></a>";

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_t.php?copern=20&drupoh=2&page=1&sysx=UCT&rozuct=ANO&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 13 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=" + pol01Array.item(i).firstChild.data + 
"&rozuct=ANO&copern=8&drupoh=4&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=" + pol07Array.item(i).firstChild.data + "', '_blank'," +
" 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='Úprava bankového dokladu'></a>";

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_t.php?copern=20&drupoh=4&page=1&sysx=UCT&rozuct=ANO&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 14 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=" + pol01Array.item(i).firstChild.data + 
"&rozuct=ANO&copern=8&drupoh=5&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=" + pol07Array.item(i).firstChild.data + "', '_blank'," +
" 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='Úprava všeobecného úètovného dokladu'></a>";

html += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_t.php?copern=20&drupoh=5&page=1&sysx=UCT&rozuct=ANO&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 5 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?sysx=UCT&hladaj_uce=" + pol01Array.item(i).firstChild.data + 
"&rozuct=ANO&copern=20&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=" + pol07Array.item(i).firstChild.data + "', '_blank'," +
" 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='Úprava rozúètovania odberate¾skej faktúry'></a>";

html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?copern=20&drupoh=1&page=1&pocstav=0&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 6 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?sysx=UCT&hladaj_uce=" + pol01Array.item(i).firstChild.data + 
"&rozuct=ANO&copern=20&drupoh=2&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=" + pol07Array.item(i).firstChild.data + "', '_blank'," +
" 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='Úprava rozúètovania dodávate¾skej faktúry'></a>";

html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?copern=20&drupoh=2&page=1&pocstav=0&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 7 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?copern=20&drupoh=1&page=1&pocstav=1&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 8 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_t.php?copern=20&drupoh=2&page=1&pocstav=1&cislo_dok=" +
pol07Array.item(i).firstChild.data + "', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
pol07Array.item(i).firstChild.data + "</a>";
  }

    html += "</td>" +


            "<td class='hvstup'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td class='hvstup'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td class='hvstup' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td class='pvstuz' align='right' onmouseover=\"UkazSkryj('" + pol08Array.item(i).firstChild.data + "')\" " +
            "onmouseout=\"Okno.style.display='none';\"><a href=\"#\" onClick=\"SaldoFak(" + pol06Array.item(i).firstChild.data + ");\">" + 
            pol06Array.item(i).firstChild.data + "</a></td>" +
            "<td class='pvstuz' align='right'>" + pol09Array.item(i).firstChild.data + "</td>" +
            "<td class='hvstup' align='right'>" + pol11Array.item(i).firstChild.data + "</td>" +
            "<td class='pvstuz' align='right'>" + pol12Array.item(i).firstChild.data + "</td>" +
            "</tr>";
    }

  // obtain a reference to the <div> element on the page

     html += "<tr><td align='right' colspan='7'>CELKOM</td>";

     faktury = faktury.toFixed(2);
     uhrady = uhrady.toFixed(2);
     zostatok = zostatok.toFixed(2);

     html += "<td align='right'>" + faktury + "</td>";
     html += "<td align='right'>" + uhrady + "</td>";
     html += "<td align='right'>" + zostatok + "</td></tr>";
     html += "</table>";


  mySaldo = document.getElementById("mySaldoelement");
  // display the HTML output
  mySaldo.innerHTML = html;
}




