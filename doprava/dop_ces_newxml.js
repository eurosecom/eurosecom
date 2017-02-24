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
function volajCes(miesto,polozka)
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

      var prm1 = "";
      if( polozka ==  1 ) { prm1 = document.forms.fhosnew1.n_pop.value; }
      if( polozka ==  2 ) { prm1 = document.forms.fhosnew2.n_pop.value; }
      if( polozka ==  3 ) { prm1 = document.forms.fhosnew3.n_pop.value; }
      if( polozka ==  4 ) { prm1 = document.forms.fhosnew4.n_pop.value; }
      if( polozka ==  5 ) { prm1 = document.forms.fhosnew5.n_pop.value; }
      if( polozka ==  6 ) { prm1 = document.forms.fhosnew6.n_pop.value; }
      if( polozka ==  7 ) { prm1 = document.forms.fhosnew7.n_pop.value; }
      if( polozka ==  8 ) { prm1 = document.forms.fhosnew8.n_pop.value; }
      if( polozka ==  9 ) { prm1 = document.forms.fhosnew9.n_pop.value; }
      if( polozka == 10 ) { prm1 = document.forms.fhosnew10.n_pop.value; }

      if( polozka == 11 ) { prm1 = document.forms.fhosnew11.n_pop.value; }
      if( polozka == 12 ) { prm1 = document.forms.fhosnew12.n_pop.value; }
      if( polozka == 13 ) { prm1 = document.forms.fhosnew13.n_pop.value; }
      if( polozka == 14 ) { prm1 = document.forms.fhosnew14.n_pop.value; }
      if( polozka == 15 ) { prm1 = document.forms.fhosnew15.n_pop.value; }
      if( polozka == 16 ) { prm1 = document.forms.fhosnew16.n_pop.value; }
      if( polozka == 17 ) { prm1 = document.forms.fhosnew17.n_pop.value; }
      if( polozka == 18 ) { prm1 = document.forms.fhosnew18.n_pop.value; }
      if( polozka == 19 ) { prm1 = document.forms.fhosnew19.n_pop.value; }
      if( polozka == 20 ) { prm1 = document.forms.fhosnew20.n_pop.value; }

      if( polozka == 21 ) { prm1 = document.forms.fhosnew21.n_pop.value; }
      if( polozka == 22 ) { prm1 = document.forms.fhosnew22.n_pop.value; }
      if( polozka == 23 ) { prm1 = document.forms.fhosnew23.n_pop.value; }
      if( polozka == 24 ) { prm1 = document.forms.fhosnew24.n_pop.value; }
      if( polozka == 25 ) { prm1 = document.forms.fhosnew25.n_pop.value; }
      if( polozka == 26 ) { prm1 = document.forms.fhosnew26.n_pop.value; }
      if( polozka == 27 ) { prm1 = document.forms.fhosnew27.n_pop.value; }
      if( polozka == 28 ) { prm1 = document.forms.fhosnew28.n_pop.value; }
      if( polozka == 29 ) { prm1 = document.forms.fhosnew29.n_pop.value; }
      if( polozka == 30 ) { prm1 = document.forms.fhosnew30.n_pop.value; }

      if( polozka == 31 ) { prm1 = document.forms.fhosnew31.n_pop.value; }
      if( polozka == 32 ) { prm1 = document.forms.fhosnew32.n_pop.value; }
      if( polozka == 33 ) { prm1 = document.forms.fhosnew33.n_pop.value; }
      if( polozka == 34 ) { prm1 = document.forms.fhosnew34.n_pop.value; }
      if( polozka == 35 ) { prm1 = document.forms.fhosnew35.n_pop.value; }
      if( polozka == 36 ) { prm1 = document.forms.fhosnew36.n_pop.value; }
      if( polozka == 37 ) { prm1 = document.forms.fhosnew37.n_pop.value; }
      if( polozka == 38 ) { prm1 = document.forms.fhosnew38.n_pop.value; }
      if( polozka == 39 ) { prm1 = document.forms.fhosnew39.n_pop.value; }
      if( polozka == 40 ) { prm1 = document.forms.fhosnew40.n_pop.value; }

      if( polozka == 41 ) { prm1 = document.forms.fhosnew41.n_pop.value; }
      if( polozka == 42 ) { prm1 = document.forms.fhosnew42.n_pop.value; }
      if( polozka == 43 ) { prm1 = document.forms.fhosnew43.n_pop.value; }
      if( polozka == 44 ) { prm1 = document.forms.fhosnew44.n_pop.value; }
      if( polozka == 45 ) { prm1 = document.forms.fhosnew45.n_pop.value; }
      if( polozka == 46 ) { prm1 = document.forms.fhosnew46.n_pop.value; }
      if( polozka == 47 ) { prm1 = document.forms.fhosnew47.n_pop.value; }
      if( polozka == 48 ) { prm1 = document.forms.fhosnew48.n_pop.value; }
      if( polozka == 49 ) { prm1 = document.forms.fhosnew49.n_pop.value; }
      if( polozka == 50 ) { prm1 = document.forms.fhosnew50.n_pop.value; }

      if( polozka == 51 ) { prm1 = document.forms.fhosnew51.n_pop.value; }
      if( polozka == 52 ) { prm1 = document.forms.fhosnew52.n_pop.value; }
      if( polozka == 53 ) { prm1 = document.forms.fhosnew53.n_pop.value; }
      if( polozka == 54 ) { prm1 = document.forms.fhosnew54.n_pop.value; }
      if( polozka == 55 ) { prm1 = document.forms.fhosnew55.n_pop.value; }
      if( polozka == 56 ) { prm1 = document.forms.fhosnew56.n_pop.value; }
      if( polozka == 57 ) { prm1 = document.forms.fhosnew57.n_pop.value; }
      if( polozka == 58 ) { prm1 = document.forms.fhosnew58.n_pop.value; }
      if( polozka == 59 ) { prm1 = document.forms.fhosnew59.n_pop.value; }
      if( polozka == 60 ) { prm1 = document.forms.fhosnew60.n_pop.value; }

     
      var prm2 = miesto; 

      // create the params string
      var params = "prm1=" + prm1 + 
                   "&prm2=" + prm2 + "&polozka=" + polozka;

      // initiate reading a file from the server
      xmlHttp.open("GET", "daj_dopces_newxml.php?" + params, true);
      xmlHttp.onreadystatechange = cakajCes;
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
function cakajCes() 
{
  // when readyState is 4, we are ready to read the server response
  if (xmlHttp.readyState == 4) 
  {
    // continue only if HTTP status is "OK"
    if (xmlHttp.status == 200) 
    {
      try
      {

          tabulka_CesXML();

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
function tabulka_CesXML()
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
  var zmlspl = 0;
  var polozka = 0;

  var html = "<table  class='ponuka' width='100%'>";  
  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {
    html += "<tr>"+
            "<td width='15%' class='ponuka'>Odchod: " + pol01Array.item(i).firstChild.data + "</td>" +
            "<td width='2%'><input type='image' src='../obr/ok.png'" +
            " onclick='vykonajCes(\"" + pol01Array.item(i).firstChild.data + "\"," +
            "\"" + pol02Array.item(i).firstChild.data + "\"," +
            "\"" + pol03Array.item(i).firstChild.data + "\"," +
            "\"" + pol04Array.item(i).firstChild.data + "\"," +
            "\"" + pol05Array.item(i).firstChild.data + "\"," +
            "\"" + pol06Array.item(i).firstChild.data +"\" );' />" +
            "<td width='15%' class='ponuka'>Príchod: " + pol02Array.item(i).firstChild.data + "</td>" + 
            "<td width='5%' class='ponuka'>km od " + pol03Array.item(i).firstChild.data + "</td>" +
            "<td width='5%' class='ponuka'> do " + pol04Array.item(i).firstChild.data + "</td>" +
            "<td width='29%' class='ponuka'></td>" +
            "<td width='29%' class='ponuka'></td>" +
            "</tr>";
    polozka = pol06Array.item(i).firstChild.data;
 
    }

  // obtain a reference to the <div> element on the page
     html += "</table>";


  myCes = document.getElementById("myCesElement1");
  if( polozka == 1 ) { myCes = document.getElementById("myCesElement1"); }
  if( polozka == 2 ) { myCes = document.getElementById("myCesElement2"); }
  if( polozka == 3 ) { myCes = document.getElementById("myCesElement3"); }
  if( polozka == 4 ) { myCes = document.getElementById("myCesElement4"); }
  if( polozka == 5 ) { myCes = document.getElementById("myCesElement5"); }
  if( polozka == 6 ) { myCes = document.getElementById("myCesElement6"); }
  if( polozka == 7 ) { myCes = document.getElementById("myCesElement7"); }
  if( polozka == 8 ) { myCes = document.getElementById("myCesElement8"); }
  if( polozka == 9 ) { myCes = document.getElementById("myCesElement9"); }
  if( polozka == 10 ) { myCes = document.getElementById("myCesElement10"); }

  if( polozka == 11 ) { myCes = document.getElementById("myCesElement11"); }
  if( polozka == 12 ) { myCes = document.getElementById("myCesElement12"); }
  if( polozka == 13 ) { myCes = document.getElementById("myCesElement13"); }
  if( polozka == 14 ) { myCes = document.getElementById("myCesElement14"); }
  if( polozka == 15 ) { myCes = document.getElementById("myCesElement15"); }
  if( polozka == 16 ) { myCes = document.getElementById("myCesElement16"); }
  if( polozka == 17 ) { myCes = document.getElementById("myCesElement17"); }
  if( polozka == 18 ) { myCes = document.getElementById("myCesElement18"); }
  if( polozka == 19 ) { myCes = document.getElementById("myCesElement19"); }
  if( polozka == 20 ) { myCes = document.getElementById("myCesElement20"); }

  if( polozka == 21 ) { myCes = document.getElementById("myCesElement21"); }
  if( polozka == 22 ) { myCes = document.getElementById("myCesElement22"); }
  if( polozka == 23 ) { myCes = document.getElementById("myCesElement23"); }
  if( polozka == 24 ) { myCes = document.getElementById("myCesElement24"); }
  if( polozka == 25 ) { myCes = document.getElementById("myCesElement25"); }
  if( polozka == 26 ) { myCes = document.getElementById("myCesElement26"); }
  if( polozka == 27 ) { myCes = document.getElementById("myCesElement27"); }
  if( polozka == 28 ) { myCes = document.getElementById("myCesElement28"); }
  if( polozka == 29 ) { myCes = document.getElementById("myCesElement29"); }
  if( polozka == 30 ) { myCes = document.getElementById("myCesElement30"); }

  if( polozka == 31 ) { myCes = document.getElementById("myCesElement31"); }
  if( polozka == 32 ) { myCes = document.getElementById("myCesElement32"); }
  if( polozka == 33 ) { myCes = document.getElementById("myCesElement33"); }
  if( polozka == 34 ) { myCes = document.getElementById("myCesElement34"); }
  if( polozka == 35 ) { myCes = document.getElementById("myCesElement35"); }
  if( polozka == 36 ) { myCes = document.getElementById("myCesElement36"); }
  if( polozka == 37 ) { myCes = document.getElementById("myCesElement37"); }
  if( polozka == 38 ) { myCes = document.getElementById("myCesElement38"); }
  if( polozka == 39 ) { myCes = document.getElementById("myCesElement39"); }
  if( polozka == 40 ) { myCes = document.getElementById("myCesElement40"); }

  if( polozka == 41 ) { myCes = document.getElementById("myCesElement41"); }
  if( polozka == 42 ) { myCes = document.getElementById("myCesElement42"); }
  if( polozka == 43 ) { myCes = document.getElementById("myCesElement43"); }
  if( polozka == 44 ) { myCes = document.getElementById("myCesElement44"); }
  if( polozka == 45 ) { myCes = document.getElementById("myCesElement45"); }
  if( polozka == 46 ) { myCes = document.getElementById("myCesElement46"); }
  if( polozka == 47 ) { myCes = document.getElementById("myCesElement47"); }
  if( polozka == 48 ) { myCes = document.getElementById("myCesElement48"); }
  if( polozka == 49 ) { myCes = document.getElementById("myCesElement49"); }
  if( polozka == 50 ) { myCes = document.getElementById("myCesElement50"); }

  if( polozka == 51 ) { myCes = document.getElementById("myCesElement51"); }
  if( polozka == 52 ) { myCes = document.getElementById("myCesElement52"); }
  if( polozka == 53 ) { myCes = document.getElementById("myCesElement53"); }
  if( polozka == 54 ) { myCes = document.getElementById("myCesElement54"); }
  if( polozka == 55 ) { myCes = document.getElementById("myCesElement55"); }
  if( polozka == 56 ) { myCes = document.getElementById("myCesElement56"); }
  if( polozka == 57 ) { myCes = document.getElementById("myCesElement57"); }
  if( polozka == 58 ) { myCes = document.getElementById("myCesElement58"); }
  if( polozka == 59 ) { myCes = document.getElementById("myCesElement59"); }
  if( polozka == 60 ) { myCes = document.getElementById("myCesElement60"); }

  // display the HTML output
  myCes.style.display='';
  myCes.innerHTML = html;
}

