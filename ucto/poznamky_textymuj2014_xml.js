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
function volajZak(polozka,ako)
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      myZakelement.style.display='none';

      var prm1 = 0; 
      var prm2 = 0; 
      var prm3 =  1*document.forms.formpren.xfir.value;; 
      var prm4 = polozka;

    if( prm3 > 0 )
          {

      // create the params string
      var params = "prm1=" + prm1 + "&prm2=" + prm2 + "&prm3=" + prm3 +
                   "&prm4=" + prm4;

      // initiate reading a file from the server
      xmlHttp.open("GET", "poznamky_textymuj2014_dajxml.php?" + params, true);
      xmlHttp.onreadystatechange = cakajZak;
      xmlHttp.send(null);
          }
    }
    // display the error in case of failure
    catch (e)
    {
      alert("Can't connect to server:\n" + e.toString());
    }
  }
}



// function called when the state of the HTTP request changes
function cakajZak() 
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
          tabulka_ZakXML();

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
function tabulka_ZakXML()
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
  // generate HTML output
  var ggg = 0;
  var zak = 0;
  var str = 0;
  var topZak = 288;
  for (var i=0; i<pol01Array.length; i++)
    {
    ggg = pol07Array.item(i).firstChild.data;
    var topZak = 288 + pol06Array.item(i).firstChild.data*19 - pol08Array.item(i).firstChild.data*200;
    var zak = pol01Array.item(i).firstChild.data;
    var str = pol03Array.item(i).firstChild.data;
    var zaktext = "Zákazka: " + pol02Array.item(i).firstChild.data + "";
    }

  var html = "<table  class='pnseda' width='100%'><tr><td colspan='9' >Vyberte text:";
      html += " <button class=\"hvstup\" height=10 onclick=\"myZakelement.style.display='none';\">";
      html += "<img src='../obr/zmaz.png' border='0' title='Spä - Nevybra text' ></button>";

      html += "</td></tr>";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {
    html += "<tr>"+

            "<td width='25%' class='pnseda'>text " + pol01Array.item(i).firstChild.data + "</td>" + 
            "<td width='75%' class='pnseda' align='left'>" + 
            "<input type='image' title='Kliknutím vyberiete text' src='../obr/ok.png'" +
            " onclick='vykonajTextJeden(\"" + pol01Array.item(i).firstChild.data + "\"," +
            "\"" + pol03Array.item(i).firstChild.data + "\"," +
            "\"" + pol04Array.item(i).firstChild.data +"\" );' />" +
            " " + pol02Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
    }

  // obtain a reference to the <div> element on the page
     html += "</table>";



  myZakelement.style.display='';

  myZak = document.getElementById("myZakelement");
  // display the HTML output
  myZak.innerHTML = html;
}




