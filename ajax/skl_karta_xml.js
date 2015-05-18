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
function urobSklkar()
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      var prm1 = document.forms.forms1.h_slu.value; 
      var prm2 = document.forms.forms1.h_nsl.value; 
      var prm3 = document.forms.forms1.h_skl.value; 
      var prm4 = 0;
      var h_min = 0;
      if( document.formx1.h_min.checked ) h_min=1;

      // create the params string
      var params = "prm1=" + prm1 + "&prm2=" + prm2 + "&prm3=" + prm3 + "&h_min=" + h_min +
                   "&prm4=" + prm4;

      // initiate reading a file from the server
      xmlHttp.open("GET", "../ajax/daj_sklkarta_xml.php?" + params, true);
      xmlHttp.onreadystatechange = pockajSklkar;
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
function pockajSklkar() 
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
          karta_SklkarXML();

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
function karta_SklkarXML()
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
  // generate HTML output
  var ggg = 0;
  var zmlspl = 0;

  var html = "<table  class='fmenu' width='100%'><tr>" +
             "<td width='8%' >Skladová karta</td>" +
             "<td width='7%' >Dátum</td>" +
             "<td width='7%' >Doklad</td>" +
             "<td width='3%' >POH</td>" +
             "<td >DOD/ODB</td>" +
             "<td width='9%' align='right' >Množstvo</td>" +
             "<td width='9%' align='right' >Cena</td>" +
             "<td width='9%' align='right' >Príjem</td>" +
             "<td width='9%' align='right' >Výdaj</td>" +
             "<td width='9%' align='right' >Zostatok</td>" +
             "</tr>";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {

    var drupoh = pol10Array.item(i).firstChild.data;



    html += "<tr>"+
            "<td class='hmenu'>SKL" + pol08Array.item(i).firstChild.data + "</td>" +
            "<td class='hmenu'>" + pol01Array.item(i).firstChild.data + "</td>" +



            "<td class='hmenu'>";

  if ( drupoh == 0 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('cpoc_t.php?copern=10&drupoh=1&page=1&cislo_dok=" +
pol02Array.item(i).firstChild.data + "', '_blank' )\">" +
pol02Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 1 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('poldok.php?copern=101&cislo_dok=" +
pol02Array.item(i).firstChild.data + "&drupoh=1&page=1&page=1&tlacitR=1', '_blank' )\">" +
pol02Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 2 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('poldok.php?copern=101&cislo_dok=" +
pol02Array.item(i).firstChild.data + "&drupoh=2&page=1&page=1&tlacitR=1', '_blank' )\">" +
pol02Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 4 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('poldok.php?copern=101&cislo_dok=" +
pol02Array.item(i).firstChild.data + "&drupoh=3&page=1&page=1&tlacitR=1', '_blank' )\">" +
pol02Array.item(i).firstChild.data + "</a>";
  }

  if ( drupoh == 3 ) 
  {
html += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_pdf.php?sysx=INE&rozuct=NIE&hladaj_dok=" + pol02Array.item(i).firstChild.data + "&cislo_dok=" +
pol02Array.item(i).firstChild.data + "&copern=20&drupoh=1', '_blank' )\">" +
pol02Array.item(i).firstChild.data + "</a>";
  }

    html += "</td>" +


            "<td class='hmenu'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td class='hmenu'>" + pol11Array.item(i).firstChild.data + "</td>" +
            "<td class='hmenu' align='right'>" + pol09Array.item(i).firstChild.data + "</td>" +
            "<td class='hmenu' align='right'>" + pol04Array.item(i).firstChild.data + "</td>" +
            "<td class='hmenu' align='right'>" + pol05Array.item(i).firstChild.data + "</td>" +
            "<td class='hmenu' align='right'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "<td class='hmenu' align='right'>" + pol07Array.item(i).firstChild.data + "</td>" +
            "</tr>";
    }

  // obtain a reference to the <div> element on the page
     html += "</table>";


  mySklkar = document.getElementById("mySklkarelement");
  // display the HTML output
  mySklkar.innerHTML = html;
}




