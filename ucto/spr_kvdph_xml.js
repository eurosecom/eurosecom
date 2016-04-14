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
function volajKV(oddiel, xdod)
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      var oddielx = oddiel; 
      var xpov = document.fhlv0.xpov.value;
      var xdodx = xdod;
      
      if ( oddielx == "A1" ) { var xicd = document.fhlv1.kvicd.value; var xer1 = document.fhlv1.kver1.value; }
      if ( oddielx == "A2" ) { var xicd = document.fhlv2.kvicd.value; var xer1 = document.fhlv2.kver1.value; }
      if ( oddielx == "B1" ) { var xicd = document.fhlv3.kvicd.value; var xer1 = document.fhlv3.kver1.value; }
      if ( oddielx == "B2" ) { var xicd = document.fhlv4.kvicd.value; var xer1 = document.fhlv4.kver1.value; }
      if ( oddielx == "B3" ) { var xicd = ""; var xer1 = document.fhlv5.kver1.value; }
      if ( oddielx == "B31" ) { var xicd = ""; var xer1 = document.fhlv11.kver1.value; }
      if ( oddielx == "B32" ) { var xicd = ""; var xer1 = document.fhlv12.kver1.value; }
      if ( oddielx == "C1" ) { var xicd = document.fhlv6.kvicd.value; var xer1 = document.fhlv6.kver1.value; }
      if ( oddielx == "C2" ) { var xicd = document.fhlv7.kvicd.value; var xer1 = document.fhlv7.kver1.value; }
      if ( oddielx == "D1" ) { var xicd = ""; var xer1 = document.fhlv8.kver1.value; }
      if ( oddielx == "D2" ) { var xicd = ""; var xer1 = document.fhlv1.kver1.value; }

      

      // create the params string
      var params = "oddiel=" + oddielx + "&xpov=" + xpov + "&xdod=" + xdodx + "&xicd=" + xicd + "&xer1=" + xer1;

      // initiate reading a file from the server
      xmlHttp.open("GET", "daj_kvdph_xml.php?" + params, true);
      xmlHttp.onreadystatechange = cakajIco;
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
function cakajIco() 
{
  // when readyState is 4, we are ready to read the server response
  if (xmlHttp.readyState == 4) 
  {
    // continue only if HTTP status is "OK"
    if (xmlHttp.status == 200) 
    {
      try
      {

          tabulka_icoXML();

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
function tabulka_icoXML()
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
  pol19Array = xmlRoot.getElementsByTagName("pol19");
  pol20Array = xmlRoot.getElementsByTagName("pol20");
  pol21Array = xmlRoot.getElementsByTagName("pol21");
  // generate HTML output
  var ggg = 0;
  var oddiel = " ";
  for (var i=0; i<pol01Array.length; i++)
  {
   ggg = pol07Array.item(i).firstChild.data;
   oddiel = pol21Array.item(i).firstChild.data;
  }

  var html = "<table class='ponuka'>";
      html +="<caption>Oddiel " + oddiel + " <img src='../obr/ikony/turnoff_blue_icon.png' onclick='myKVDPH.style.display=\"none\";' title='Skryù menu' class='skry'></caption>" +
             "<tr>" +
              "<th width='10%'></th>" +
              "<th width='20%'>I»DPH</th>" +
              "<th width='12%'>D·tum</th>" +
              "<th width='20%'>»Ìslo fa.</th>" +
              "<th width='19%'>z·klad DPH</th>" +
              "<th width='19%'>suma DPH</th>" +
             "</tr>";
  
  //iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {
    html += "<tr>"+
             "<td>" + pol01Array.item(i).firstChild.data + " <input type='image' src='../obr/ok.png'" +
              "onclick='vykonajKVDPH(\"" + pol01Array.item(i).firstChild.data + "\"," +
              "\"" + pol02Array.item(i).firstChild.data + "\"," +
              "\"" + pol03Array.item(i).firstChild.data + "\"," +
              "\"" + pol04Array.item(i).firstChild.data + "\"," +
              "\"" + pol05Array.item(i).firstChild.data + "\"," +
              "\"" + pol06Array.item(i).firstChild.data + "\"," +
              "\"" + pol08Array.item(i).firstChild.data + "\"," +
              "\"" + pol09Array.item(i).firstChild.data + "\"," +
              "\"" + pol10Array.item(i).firstChild.data + "\"," +
              "\"" + pol11Array.item(i).firstChild.data + "\"," +
              "\"" + pol12Array.item(i).firstChild.data + "\"," +
              "\"" + pol13Array.item(i).firstChild.data + "\"," +
              "\"" + pol14Array.item(i).firstChild.data + "\"," +
              "\"" + pol15Array.item(i).firstChild.data + "\"," +
              "\"" + pol16Array.item(i).firstChild.data + "\"," +
              "\"" + pol17Array.item(i).firstChild.data + "\"," +
              "\"" + pol18Array.item(i).firstChild.data + "\"," +
              "\"" + pol19Array.item(i).firstChild.data + "\"," +
              "\"" + pol20Array.item(i).firstChild.data +"\" );' class='ok-btn'/></td>" +
             "<td>" + pol02Array.item(i).firstChild.data + "</td>" +
             "<td>" + pol03Array.item(i).firstChild.data + "</td>" +
             "<td>" + pol04Array.item(i).firstChild.data + "</td>" +
             "<td style='text-align:right;'>" + pol05Array.item(i).firstChild.data + "&nbsp;</td>" +
             "<td style='text-align:right;'>" + pol06Array.item(i).firstChild.data + "&nbsp;</td>" +
            "</tr>";
    }

  //obtain a reference to the <div> element on the page
     html += "</table>";

  myKVDPHx = document.getElementById("myKVDPH");
  //display the HTML output
  myKVDPHx.innerHTML = html;

}




