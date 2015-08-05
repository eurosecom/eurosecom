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
function volajPriku(ake)
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

      var prm4 = ake;
      var ucm = 0;
      var ucd = 0;
      var uce = 0;

  if ( prm4 == 1 || prm4 == 2 || prm4 == 3 ) 
    {
      var uceb = document.forms.forms1.h_uceb.value;       
      var vsy = document.forms.forms1.h_vsy.value; 
      var ico = document.forms.forms1.h_ico.value; 
      //1=prikazy na uhradu dodav, 2=prikazy na uhradu ICO
    }

  if ( prm4 == 4 ) 
    {
      var uceb = 0;       
      var vsy = document.forms.forms1.h_fak.value; 
      ucm = document.forms.forms1.h_ucm.value; 
      ucd = document.forms.forms1.h_ucd.value; 
      uce = document.forms.forms1.h_uce.value; 
      var ico = 0; 
      //4=bankovy fak,prijmovy,vydavkovy
    }


      // create the params string
      var params = "uceb=" + uceb + "&vsy=" + vsy + "&ico=" + ico + "&ucm=" + ucm + "&ucd=" + ucd + "&uce=" + uce +
                   "&prm4=" + prm4;

      // initiate reading a file from the server
      xmlHttp.open("GET", "daj_priku_iban.php?" + params, true);
      xmlHttp.onreadystatechange = cakajPriku;
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
function cakajPriku() 
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
          tabulka_PrikuXML();

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
function tabulka_PrikuXML()
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

  // generate HTML output
  var ggg = 0;
  var prm4 = 0;
  var zmlspl = 0;
  var hdx = 0;
  var zaktext="";
  for (var i=0; i<pol01Array.length; i++)
    {
    ggg = pol07Array.item(i).firstChild.data;
    prm4 = pol16Array.item(i).firstChild.data;
    hdx = pol17Array.item(i).firstChild.data;
    zaktext = pol02Array.item(i).firstChild.data;  
    }

  var html = "<table  class='ponuka' width='100%'><tr><td width='10%' >Vyberte položku</td>";  
    html += "<td width='10%' >Odberate¾/Dodávate¾</td>" +
            "<td width='20%' ></td>" +
            "<td width='20%' >Bank.úèet / num / IBAN-BIC</td>" +
            "<td width='14%' >VSY / KSY / SSY</td>" +
            "<td width='9%' align='right'>Faktúra</td>" +
            "<td width='8%' align='right'>Úhrada</td>" +
            "<td width='9%' align='right'>Zostatok</td>" +
            "</tr>";


  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {
    html += "<tr>"+
            "<td class='ponuka'>" + pol06Array.item(i).firstChild.data + "</td>" + 
            "<td  class='ponuka' align='right'>" + pol01Array.item(i).firstChild.data +
            "<input type='image' src='../obr/ok.png'";

  if ( prm4 == 1 || prm4 == 3 ){
    html += " onclick='vykonajPriku(\"" + pol01Array.item(i).firstChild.data + "\",";
                               }

  if ( prm4 == 2 ){
    html += " onclick='vykonajPriku2(\"" + pol01Array.item(i).firstChild.data + "\",";
                               }
  if ( prm4 == 4 ){
    html += " onclick='vykonajPriku4(\"" + pol01Array.item(i).firstChild.data + "\",";
                               }


    html += "\"" + pol02Array.item(i).firstChild.data + "\"," +
            "\"" + pol03Array.item(i).firstChild.data + "\"," +
            "\"" + pol04Array.item(i).firstChild.data + "\"," +
            "\"" + pol05Array.item(i).firstChild.data + "\"," +
            "\"" + pol06Array.item(i).firstChild.data + "\"," +
            "\"" + pol08Array.item(i).firstChild.data + "\"," +
            "\"" + pol11Array.item(i).firstChild.data + "\"," +
            "\"" + pol12Array.item(i).firstChild.data + "\"," +
            "\"" + pol13Array.item(i).firstChild.data + "\"," +
            "\"" + pol14Array.item(i).firstChild.data + "\"," +
            "\"" + pol15Array.item(i).firstChild.data + "\"," +
            "\"" + pol18Array.item(i).firstChild.data + "\"," +
            "\"" + pol19Array.item(i).firstChild.data +"\" );' />" +
            "<td class='ponuka'>" + pol02Array.item(i).firstChild.data + " " + pol03Array.item(i).firstChild.data +  "</td>" + 

            "<td class='ponuka'>" + pol08Array.item(i).firstChild.data + " / " + pol12Array.item(i).firstChild.data +  "<br />" +
            pol18Array.item(i).firstChild.data + " - " + pol19Array.item(i).firstChild.data +  "</td>" +

            "<td class='ponuka'>" + pol13Array.item(i).firstChild.data + " / " + 
            pol14Array.item(i).firstChild.data + " / " + pol15Array.item(i).firstChild.data + "</td>" +
            "<td class='ponuka' align='right'>" + pol09Array.item(i).firstChild.data + "</td>" +
            "<td class='ponuka' align='right'>" + pol10Array.item(i).firstChild.data + "</td>" +
            "<td class='ponuka' align='right'>" + pol11Array.item(i).firstChild.data + "</td>" +
            "</tr>";
    }


  // obtain a reference to the <div> element on the page
     html += "</table>";


  myPrikuelement.style.display='';

  if ( ggg == 1 ) 
  {
  var html = "";  
  if ( prm4 == 1 || prm4 == 3 ) 
    {
  document.forms.forms1.h_ico.value =  pol01Array.item(0).firstChild.data;
  document.forms.forms1.h_uceb.value =  pol08Array.item(0).firstChild.data;
  document.forms.forms1.h_numb.value =  pol12Array.item(0).firstChild.data;
  document.forms.forms1.h_vsy.value =  pol13Array.item(0).firstChild.data;
  document.forms.forms1.h_hodp.value =  pol11Array.item(0).firstChild.data;
  document.forms.forms1.h_ksy.value =  pol14Array.item(0).firstChild.data;
  document.forms.forms1.h_ssy.value =  pol15Array.item(0).firstChild.data;
  document.forms.forms1.h_uce.value =  pol06Array.item(0).firstChild.data;
  document.forms.forms1.h_iban.value =  pol18Array.item(0).firstChild.data;
  document.forms.forms1.h_pbic.value =  pol19Array.item(0).firstChild.data;
    }
  if ( prm4 == 2 ) 
    {
  document.forms.forms1.h_uceb.value =  pol08Array.item(0).firstChild.data;
  document.forms.forms1.h_numb.value =  pol12Array.item(0).firstChild.data;
  document.forms.forms1.h_iban.value =  pol18Array.item(0).firstChild.data;
  document.forms.forms1.h_pbic.value =  pol19Array.item(0).firstChild.data;
    }
  if ( prm4 == 4 ) 
    {
  ukazZak = document.getElementById("jeZak");
  ukazZak.innerHTML = zaktext;
  ukazZak.style.display='';

  document.forms.forms1.h_ico.value =  pol01Array.item(0).firstChild.data;
  document.forms.forms1.h_fak.value =  pol13Array.item(0).firstChild.data;
  document.forms.forms1.h_hop.value =  pol11Array.item(0).firstChild.data;
  document.forms.forma4.h_hdx.value =  pol17Array.item(0).firstChild.data;
    }

  myPrikuelement.style.display='none';
  Len1Priku();
  }

  if ( ggg == 0 ) 
  {
  var html = "";  
  if ( prm4 == 1 || prm4 == 2 || prm4 == 3 ) 
    {
  document.forms.forms1.h_uceb.value =  uceb;
  document.forms.forms1.h_numb.value =  0;
  document.forms.forms1.h_vsy.value =  vsy;
  document.forms.forms1.h_hodp.value =  0;
  document.forms.forms1.h_uce.value =  0;
    }
  if ( prm4 == 4 ) 
    {
  document.forms.forms1.h_fak.value =  vsy;
  document.forms.forms1.h_hop.value =  0;
  document.forms.forma4.h_hdx.value =  0;
    }
  myPrikuelement.style.display='none';
  Len0Priku();
  }

  bodywhite.style.cursor = "auto";
  myPriku = document.getElementById("myPrikuelement");
  // display the HTML output
  myPriku.innerHTML = html;

}




