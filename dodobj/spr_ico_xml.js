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
function volajIco()
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      var prm1 = document.forms.formv1.xice.value; 
      var prm2 = document.forms.formv1.xfir.value; 

      // create the params string
      var params = "prm1=" + prm1 + 
                   "&prm2=" + prm2;

      // initiate reading a file from the server
      xmlHttp.open("GET", "daj_ico_xml.php?" + params, true);
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
        // vypis bez tabulky oddelene ;
        //vypis_icoXML();
        // vypis do tabulky samostatnej ;
          tabulka_icoXML();
        // select  ;
        //select_icoXML(); 
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
  // generate HTML output
  var ggg = 0;
  var ico = "";
  var nazov = "";
  for (var i=0; i<pol07Array.length; i++)
    {
    ggg = pol07Array.item(i).firstChild.data;
    ico = pol01Array.item(i).firstChild.data;
    nazov = pol02Array.item(i).firstChild.data;
    }

  var html = "<table class='ponuka' style='width:450px;'>";
    html += "<tr>"+
            "<td width='15%'></td>" +
            "<td width='55%'></td>" +
            "<td width='30%' class='center' style'height:18px;'>&nbsp;<a href='#' onclick=\"myIcoElement.style.display='none';\">Zhasni</a></td>" +
            "</tr>";


  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol07Array.length; i++)
    {
    html += "<tr>"+
            "<td class='right'>" + pol01Array.item(i).firstChild.data + "&nbsp;</td>" +
            "<td><input type='image' src='../obr/ok.png' title='Vybrať'" +
            " onclick='vykonajIco(\"" + pol01Array.item(i).firstChild.data + "\"," +
            "\"" + pol02Array.item(i).firstChild.data + "\"," +
            "\"" + pol03Array.item(i).firstChild.data +"\" );' />" +
            "" + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td>&nbsp;" + pol03Array.item(i).firstChild.data + "</td>" +
            "</tr>";
    }

  // obtain a reference to the <div> element on the page
     html += "</table>";



  myIco = document.getElementById("myIcoElement");
  // display the HTML output
  myIco.innerHTML = html;
  myIcoElement.style.display='';

if( ggg == 1 )
    {
        document.forms.formv1.xice.value = ico;
        document.forms.formv1.xfir.value = nazov;
        document.forms.formv1.xplat.focus();
        document.forms.formv1.xplat.select();
  myIcoElement.style.display='none';
    }

}


//co urobi po potvrdeni ok z tabulky ico
function vykonajIco(ico,nazov,mesto)
                {
        document.forms.formv1.xice.value = ico;
        document.forms.formv1.xfir.value = nazov;
        document.forms.formv1.xplat.focus();
        document.forms.formv1.xplat.select();
  myIcoElement.style.display='none';
                }
