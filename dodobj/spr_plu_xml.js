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
function volajSlu()
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {


      var h_cis = document.forms.formv1.xcis.value;
      var h_nat = document.forms.formv1.xnat.value; 
      var cennik = 0; 

      // create the params string
      var params = "prm1=" + h_cis + "&prm2=" + h_nat + "&cennik=" + cennik;

      // initiate reading a file from the server
      xmlHttp.open("GET", "daj_plu_xml.php?" + params, true);
      xmlHttp.onreadystatechange = cakajSlu;
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
function cakajSlu() 
{
  // when readyState is 4, we are ready to read the server response
  if (xmlHttp.readyState == 4) 
  {
    // continue only if HTTP status is "OK"
    if (xmlHttp.status == 200) 
    {
      try
      {
        // vypis bez tabulky oddelene ;
        //vypisXML();
        // vypis do tabulky samostatnej ;
          tabulkaXML();
        // select  ;
        //selectXML(); 
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


// vypis do selectu
function selectXML()
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
  rokArray = xmlRoot.getElementsByTagName("rok");
  // generate HTML output
  var html = "<select class='hvstup' size='1' name='h_xcf' id='h_xcf' onKeyDown='return XcfEnter(event.which)'>";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    html += "<option value='" + pol01Array.item(i).firstChild.data + "' >" +
            pol01Array.item(i).firstChild.data + " - " + pol02Array.item(i).firstChild.data + "</option>";
  // obtain a reference to the <div> element on the page
  // html += "</select>";
  myDiv = document.getElementById("myDivElement");
  // display the HTML output
  myDiv.innerHTML = html;
}


// vypis do tabulky s parametrom
function tabulkaXML()
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
  // generate HTML output
  var ggg = 0;
  for (var i=0; i<pol01Array.length; i++)
    {
    ggg = pol07Array.item(i).firstChild.data;
    }

  var html = "<table  class='ponuka' width='100%'>";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {
    html += "<tr>"+
            "<td width='6%' class='ponuka'>" + pol01Array.item(i).firstChild.data + "</td>" +
            "<td width='2%'><input type='image' src='../obr/ok.png'" +
            " onclick='vykonajPlu(\"" + pol01Array.item(i).firstChild.data + "\"," +
            "\"" + pol02Array.item(i).firstChild.data + "\"," +
            "\"" + pol03Array.item(i).firstChild.data + "\"," +
            "\"" + pol04Array.item(i).firstChild.data + "\"," +
            "\"" + pol05Array.item(i).firstChild.data + "\"," +
            "\"" + pol09Array.item(i).firstChild.data + "\"," +
            "\"" + pol10Array.item(i).firstChild.data + "\"," +
            "\"" + pol06Array.item(i).firstChild.data +"\" );' />" +
            "<td width='31%' class='ponuka'>" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='4%' class='ponuka'>" + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='8%'>NC=" + pol09Array.item(i).firstChild.data + "</td>" +
            "<td width='8%'>ZÁS=" + pol10Array.item(i).firstChild.data + "</td>" +
            "<td width='4%' class='ponuka'>" + pol06Array.item(i).firstChild.data + "</td>" +
            "<td width='8%'></td>" +
            "<td width='13%'></td>" +
            "</tr>";
    }

  // obtain a reference to the <div> element on the page
     html += "</table>";



  if ( ggg == 0 ) 
  {
  var html = "<span id='slu0' style='width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;'>" +
  " Položka nie je v èíselníku</span>";  
  myDivElement.style.display='';
  }

  if ( ggg == 1 ) 
  {

  var html = "";  
  document.forms.formv1.xcis.value =  pol01Array.item(0).firstChild.data;
  document.forms.formv1.xnat.value =  pol02Array.item(0).firstChild.data;
  document.forms.formv1.xced.value =  pol09Array.item(0).firstChild.data;
  document.forms.formv1.xmno.value =  pol10Array.item(0).firstChild.data;
  myDivElement.style.display='none';
  document.forms.formv1.xced.focus();
  document.forms.formv1.xced.select();


  }

  myDiv = document.getElementById("myDivElement");
  // display the HTML output
  myDiv.innerHTML = html;


}

// vypis len oddelene ;
function vypisXML()
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
  // generate HTML output
  var html = "";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    html += pol01Array.item(i).firstChild.data + 
            ", " + pol02Array.item(i).firstChild.data + 
            ", " + pol03Array.item(i).firstChild.data + "<br/>";
  // obtain a reference to the <div> element on the page
  myDiv = document.getElementById("myDivElement");
  // display the HTML output
  myDiv.innerHTML = html;
}


