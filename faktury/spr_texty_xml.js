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
function DajText(druh)
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      if( druh == 1 ) { var copernxh=2008; }
      if( druh == 2 ) { var copernxh=2009; }

      var prm1 = 0; 
      var prm2 = 0; 

      // create the params string
      var params = "druh=" + druh + "&prm1=" + prm1 + "&prm2=" + prm2;

      // initiate reading a file from the server
      xmlHttp.open("GET", "daj_texty_xml.php?" + params, true);
      xmlHttp.onreadystatechange = cakajTexty;
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
function cakajTexty() 
{
  // when readyState is 4, we are ready to read the server response
  if (xmlHttp.readyState == 4) 
  {
    // continue only if HTTP status is "OK"
    if (xmlHttp.status == 200) 
    {
      try
      {
          tabulka_TextyXML();

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
function tabulka_TextyXML()
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
  // generate HTML output


  var html = "<table class='fmenu' width='100%' >";  
    html += "<tr>"+
            "<td width='50%' class='bmenu' >Predvolené texty...</td>" +
            "<td width='50%' class='bmenu' >" + 
"<img border=0 src='../obr/zmazuplne.png' style=\"width:15px; height:15px;\" onClick=\"myTextElement.style.display='none';\" title='Zhasni' >" +
            "</td></tr>";


  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol07Array.length; i++)
    {
    html += "<tr height='30'>"+
            "<td align='center' class='pvstuz' >" + pol01Array.item(i).firstChild.data + 
            "<input type='image' style='width:20px; height:20px;' src='../obr/ok.png'" +
            " onclick='vykonajText(\"" + pol03Array.item(i).firstChild.data + "\"," +
            "\"" + pol01Array.item(i).firstChild.data + "\"," +
            "\"" + pol04Array.item(i).firstChild.data +"\" );' />" +
            "<td class='pvstuz' >" + pol02Array.item(i).firstChild.data + "</td>" + 
            "</tr>";
    }

  // obtain a reference to the <div> element on the page
     html += "</table>";



  MyText = document.getElementById("myTextElement");
  // display the HTML output
  MyText.innerHTML = html;


}
