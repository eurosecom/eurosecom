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
function volajPokset(premenna)
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {


      var prm1 = premenna; 
      var prm2 = 0; 
      var prm3 = 0; 
      var prm4 = 0;

      // create the params string
      var params = "prm1=" + prm1 + "&prm2=" + prm2 + "&prm3=" + prm3 +
                   "&prm4=" + prm4;

      // initiate reading a file from the server
      xmlHttp.open("GET", "pok_set.php?" + params, true);
      xmlHttp.onreadystatechange = cakajPokset;
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
function cakajPokset() 
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
          tabulka_FaksetXML();

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
function tabulka_FaksetXML()
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
  pol13Array = xmlRoot.getElementsByTagName("pol13");
  pol14Array = xmlRoot.getElementsByTagName("pol14");
  pol15Array = xmlRoot.getElementsByTagName("pol15");
  pol16Array = xmlRoot.getElementsByTagName("pol16");
  pol17Array = xmlRoot.getElementsByTagName("pol17");
  pol18Array = xmlRoot.getElementsByTagName("pol18");
  // generate HTML output
  var ggg = 0;
  var ucm1 = 0;
  var ucm2 = 0;
  var ucm3 = 0;
  var ucm4 = 0;
  var ucm5 = 0;
  var ico1 = 0;
  var ico2 = 0;
  var ico3 = 0;
  var ico4 = 0;
  var ico5 = 0;
  var zmd = 1;
  var zdl = 0;
  var omd = 0;
  var odl = 0;
  var pmd = 0;
  var pdl = 0;
  for (var i=0; i<pol01Array.length; i++)
    {
    ggg = pol07Array.item(i).firstChild.data;
    var ucm1 = pol01Array.item(i).firstChild.data;
    var ucm2 = pol02Array.item(i).firstChild.data;
    var ucm3 = pol03Array.item(i).firstChild.data;
    var ucm4 = pol04Array.item(i).firstChild.data;
    var ucm5 = pol06Array.item(i).firstChild.data;

    var ico1 = pol08Array.item(i).firstChild.data;
    var ico2 = pol09Array.item(i).firstChild.data;
    var ico3 = pol10Array.item(i).firstChild.data;
    var ico4 = pol11Array.item(i).firstChild.data;
    var ico5 = pol12Array.item(i).firstChild.data;

    var zmd = pol13Array.item(i).firstChild.data;
    var zdl = pol14Array.item(i).firstChild.data;
    var omd = pol15Array.item(i).firstChild.data;
    var odl = pol16Array.item(i).firstChild.data;
    var pmd = pol17Array.item(i).firstChild.data;
    var pdl = pol18Array.item(i).firstChild.data;
    }
    
document.forms.enast.h_ucm1.value = ucm1;
document.forms.enast.h_ucm2.value = ucm2;
document.forms.enast.h_ucm3.value = ucm3;
document.forms.enast.h_ucm4.value = ucm4;
document.forms.enast.h_ucm5.value = ucm5;

document.forms.enast.h_ico1.value = ico1;
document.forms.enast.h_ico2.value = ico2;
document.forms.enast.h_ico3.value = ico3;
document.forms.enast.h_ico4.value = ico4;
document.forms.enast.h_ico5.value = ico5;

if( zmd == 1 ) { document.enast.zmd.checked = 'checked'; }
if( zdl == 1 ) { document.enast.zdl.checked = 'checked'; }
if( omd == 1 ) { document.enast.omd.checked = 'checked'; }
if( odl == 1 ) { document.enast.odl.checked = 'checked'; }
if( pmd == 1 ) { document.enast.pmd.checked = 'checked'; }
if( pdl == 1 ) { document.enast.pdl.checked = 'checked'; }

document.forms.enast.h_ucm1.focus();
document.forms.enast.h_ucm1.select();

}
