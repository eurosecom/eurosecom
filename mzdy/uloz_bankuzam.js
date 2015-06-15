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
function ulozBANKU(ake,oc)
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      var iban = "";
      var swft = "";

      if( ake == 1 ) {  
      var vban = 1;
      var h_oc = oc;
      var iban = document.forms.fbanka1.h_ibanb.value;
      var swft = document.forms.fbanka1.h_swft.value;
      var uceb = document.forms.fbanka1.h_uceb.value; 
      var numb = document.forms.fbanka1.h_numb.value;
      var vsy = document.forms.fbanka1.h_vsy.value;
      var ksy = document.forms.fbanka1.h_ksy.value;
      var ssy = document.forms.fbanka1.h_ssy.value;
      var prm4 = 1;
      }

      if( ake == 2 ) {  
      var vban = 1;
      var h_oc = oc;
      var uceb = document.forms.fbanka2.h_uceb.value; 
      var numb = document.forms.fbanka2.h_numb.value;
      var vsy = document.forms.fbanka2.h_vsy.value;
      var ksy = document.forms.fbanka2.h_ksy.value;
      var ssy = document.forms.fbanka2.h_ssy.value;
      var prm4 = 2;
      }

      if( ake == 3 ) {  
      var vban = 1;
      var h_oc = oc;
      var uceb = document.forms.fbanka3.h_uceb.value; 
      var numb = document.forms.fbanka3.h_numb.value;
      var vsy = document.forms.fbanka3.h_vsy.value;
      var ksy = document.forms.fbanka3.h_ksy.value;
      var ssy = document.forms.fbanka3.h_ssy.value;
      var prm4 = 3;
      }

      if( ake == 4 ) {  
      var vban = 1;
      var h_oc = oc;
      var uceb = document.forms.fbanka4.h_uceb.value; 
      var numb = document.forms.fbanka4.h_numb.value;
      var vsy = document.forms.fbanka4.h_vsy.value;
      var ksy = document.forms.fbanka4.h_ksy.value;
      var ssy = document.forms.fbanka4.h_ssy.value;
      var prm4 = 4;
      }

      if( ake == 5 ) {  
      var vban = 1;
      var h_oc = oc;
      var uceb = document.forms.fbanka5.h_uceb.value; 
      var numb = document.forms.fbanka5.h_numb.value;
      var vsy = document.forms.fbanka5.h_vsy.value;
      var ksy = document.forms.fbanka5.h_ksy.value;
      var ssy = document.forms.fbanka5.h_ssy.value;
      var prm4 = 5;
      }

      // create the params string
      var params = "vban=" + vban + "&h_oc=" + h_oc + "&uceb=" + uceb + "&numb=" + numb + "&vsy=" + vsy + "&ksy=" + ksy + "&ssy=" + ssy + 
			"&iban=" + iban + "&swft=" + swft + "&prm4=" + prm4;

      // initiate reading a file from the server
      xmlHttp.open("GET", "uloz_bankuzam.php?" + params, true);
      xmlHttp.onreadystatechange = cakajBANKU;
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
function cakajBANKU() 
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
          tabulka_MENUXML();

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
function tabulka_MENUXML()
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
  var prm4 = 0;
  var oc = 0;
  var uce = 0;
  var dok = 0;
  var uceb = 0;
  var numb = 0;
  var vsy = 0;
  var ksy = 0;
  var ssy = 0;


  for (var i=0; i<pol01Array.length; i++)
    {
    oc = pol01Array.item(i).firstChild.data;
    prm4 = pol07Array.item(i).firstChild.data;
    }


  // obtain a reference to the <div> element on the page
     html = "";

  if( prm4 == 1 )
  {
  for (var i=0; i<pol01Array.length; i++)
    {
    uceb = pol02Array.item(i).firstChild.data;
    numb = pol03Array.item(i).firstChild.data;
    vsy = pol04Array.item(i).firstChild.data;
    ksy = pol05Array.item(i).firstChild.data;
    ssy = pol06Array.item(i).firstChild.data;
    }

  myBANKA = document.getElementById("myBANKAelement");
  // display the HTML output
  myBANKA.innerHTML = html;
  myBANKAelement.style.display='none';

  //nastav do okna stav uctu

    jeBANKA = document.getElementById("jeBANKAelement");

    var htmlbanka = "<table  class='ponuka' width='100%'><tr>";

    htmlbanka += "<td width='40%'>Bankový úèet: ";
    htmlbanka += "" + ibanb + " / ";
    htmlbanka += "" + uceb + " / ";
    htmlbanka += "" + numb + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='15%'>VSY:";
    htmlbanka += "" + vsy + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='10%'>KSY:";
    htmlbanka += "" + ksy + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='15%'>SSY:";
    htmlbanka += "" + ssy + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='5%'>";
    htmlbanka += "</td>";

    htmlbanka += "<td width='15%' align='right'></td></tr>"; 
    htmlbanka += "</table>";
    jeBANKA.innerHTML = htmlbanka;
    jeBANKAelement.style.display='';
  }

  if( prm4 == 2 )
  {
  for (var i=0; i<pol01Array.length; i++)
    {
    uced = pol02Array.item(i).firstChild.data;
    numd = pol03Array.item(i).firstChild.data;
    vsyd = pol04Array.item(i).firstChild.data;
    ksyd = pol05Array.item(i).firstChild.data;
    ssyd = pol06Array.item(i).firstChild.data;
    }

  myBANKAD = document.getElementById("myBANKADelement");
  // display the HTML output
  myBANKAD.innerHTML = html;
  myBANKADelement.style.display='none';

  //nastav do okna stav uctu

    jeBANKAD = document.getElementById("jeBANKADelement");

    var htmlbankad = "<table  class='ponuka' width='100%'><tr>";

    htmlbankad += "<td width='40%'>Bankový úèet daò z príjmu: ";
    htmlbankad += "" + uced + " / ";
    htmlbankad += "" + numd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='15%'>VSY:";
    htmlbankad += "" + vsyd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='10%'>KSY:";
    htmlbankad += "" + ksyd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='15%'>SSY:";
    htmlbankad += "" + ssyd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='5%'><a href='#' onClick='vyberBANKUD();'>";
    htmlbankad += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankový úèet pre odvod dane z príjmu' ></a>";
    htmlbankad += "</td>";

    htmlbankad += "<td width='15%' align='right'></td></tr>"; 
    htmlbankad += "</table>";
    jeBANKAD.innerHTML = htmlbankad;
    jeBANKADelement.style.display='';
  }

  if( prm4 == 3 )
  {
  for (var i=0; i<pol01Array.length; i++)
    {
    uces = pol02Array.item(i).firstChild.data;
    nums = pol03Array.item(i).firstChild.data;
    vsys = pol04Array.item(i).firstChild.data;
    ksys = pol05Array.item(i).firstChild.data;
    ssys = pol06Array.item(i).firstChild.data;
    }

  myBANKAS = document.getElementById("myBANKASelement");
  // display the HTML output
  myBANKAS.innerHTML = html;
  myBANKASelement.style.display='none';

  //nastav do okna stav uctu

    jeBANKAS = document.getElementById("jeBANKASelement");

    var htmlbankas = "<table  class='ponuka' width='100%'><tr>";

    htmlbankas += "<td width='40%'>Bankový úèet SP: ";
    htmlbankas += "" + uces + " / ";
    htmlbankas += "" + nums + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='15%'>VSY:";
    htmlbankas += "" + vsys + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='10%'>KSY:";
    htmlbankas += "" + ksys + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='15%'>SSY:";
    htmlbankas += "" + ssys + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='5%'><a href='#' onClick='vyberBANKUS();'>";
    htmlbankas += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankový úèet pre odvod SP' ></a>";
    htmlbankas += "</td>";

    htmlbankas += "<td width='15%' align='right'></td></tr>"; 
    htmlbankas += "</table>";
    jeBANKAS.innerHTML = htmlbankas;
    jeBANKASelement.style.display='';
  }

  if( prm4 == 4 )
  {
  for (var i=0; i<pol01Array.length; i++)
    {
    ucedz = pol02Array.item(i).firstChild.data;
    numdz = pol03Array.item(i).firstChild.data;
    vsydz = pol04Array.item(i).firstChild.data;
    ksydz = pol05Array.item(i).firstChild.data;
    ssydz = pol06Array.item(i).firstChild.data;
    }

  myBANKADZ = document.getElementById("myBANKADZelement");
  // display the HTML output
  myBANKADZ.innerHTML = html;
  myBANKADZelement.style.display='none';

  //nastav do okna stav uctu

    jeBANKADZ = document.getElementById("jeBANKADZelement");

    var htmlbankadz = "<table  class='ponuka' width='100%'><tr>";

    htmlbankadz += "<td width='40%'>Bankový úèet zrážková daò: ";
    htmlbankadz += "" + ucedz + " / ";
    htmlbankadz += "" + numdz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='15%'>VSY:";
    htmlbankadz += "" + vsydz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='10%'>KSY:";
    htmlbankadz += "" + ksydz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='15%'>SSY:";
    htmlbankadz += "" + ssydz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='5%'><a href='#' onClick='vyberBANKUDZ();'>";
    htmlbankadz += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankový úèet pre odvod zrážkovej dane' ></a>";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='15%' align='right'></td></tr>"; 
    htmlbankadz += "</table>";
    jeBANKADZ.innerHTML = htmlbankadz;
    jeBANKADZelement.style.display='';
  }

  if( prm4 == 5 )
  {
  for (var i=0; i<pol01Array.length; i++)
    {
    uceo = pol02Array.item(i).firstChild.data;
    numo = pol03Array.item(i).firstChild.data;
    vsyo = pol04Array.item(i).firstChild.data;
    ksyo = pol05Array.item(i).firstChild.data;
    ssyo = pol06Array.item(i).firstChild.data;
    }

  myBANKAO = document.getElementById("myBANKAOelement");
  // display the HTML output
  myBANKAO.innerHTML = html;
  myBANKAOelement.style.display='none';

  //nastav do okna stav uctu

    jeBANKAO = document.getElementById("jeBANKAOelement");

    var htmlbankao = "<table  class='ponuka' width='100%'><tr>";

    htmlbankao += "<td width='40%'>Bankový úèet zrážková daò: ";
    htmlbankao += "" + uceo + " / ";
    htmlbankao += "" + numo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='15%'>VSY:";
    htmlbankao += "" + vsyo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='10%'>KSY:";
    htmlbankao += "" + ksyo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='15%'>SSY:";
    htmlbankao += "" + ssyo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='5%'><a href='#' onClick='vyberBANKUO();'>";
    htmlbankao += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankový úèet pre odbory' ></a>";
    htmlbankao += "</td>";

    htmlbankao += "<td width='15%' align='right'></td></tr>"; 
    htmlbankao += "</table>";
    jeBANKAO.innerHTML = htmlbankao;
    jeBANKAOelement.style.display='';
  }

}




