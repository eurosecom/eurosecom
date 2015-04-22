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
function volajAutoUCT(odkial,drupoh,pohyb)
{
  // only continue if xmlHttp isn't void
  if (xmlHttp)
  {
    // try to connect to the server
    try
    {

//    nastav hodiny
      bodywhite = document.getElementById("white");
      bodywhite.style.cursor = "wait";

      var h_odkial = odkial; 


//    odkial=9 z jednoducheho  11,12faktury z copern=5 zahlavie
      if( h_odkial == 9 )
      {
      var h_drupoh = drupoh; 
      var h_pohyb = pohyb;
      var h_uce = document.forms.fhlv1.h_uce.value; 
      var h_dok = document.forms.fhlv1.h_dok.value; 
      var h_ico = document.forms.fhlv1.h_ico.value; 
      var h_dat = document.forms.fhlv1.h_dat.value; 
      var h_zao = document.forms.fhlv1.h_zao.value; 
      var h_zk0 = document.forms.fhlv1.h_zk0.value; 
      var h_zk1 = document.forms.fhlv1.h_zk1.value; 
      var h_zk2 = document.forms.fhlv1.h_zk2.value; 
      var h_dn1 = document.forms.fhlv1.h_dn1.value; 
      var h_dn2 = document.forms.fhlv1.h_dn2.value; 
      var h_txp = document.forms.fhlv1.h_txp.value; 
      var h_txz = document.forms.fhlv1.h_txz.value;
      var h_kto = "";
      var h_poz = document.forms.fhlv1.h_poz.value;
      var h_unk = document.forms.fhlv1.h_unk.value;

      var h_fak = document.forms.fhlv1.h_fak.value;
      var h_dol = document.forms.fhlv1.h_dol.value;
      var h_prf = document.forms.fhlv1.h_prf.value;
      var h_obj = document.forms.fhlv1.h_obj.value;
      var h_dpr = document.forms.fhlv1.h_dpr.value;

      var h_str = document.forms.fhlv1.h_str.value;
      var h_zak = document.forms.fhlv1.h_zak.value;
      var h_ksy = document.forms.fhlv1.h_ksy.value;
      var h_ssy = document.forms.fhlv1.h_ssy.value;

      var h_daz = document.forms.fhlv1.h_daz.value;
      var h_das = document.forms.fhlv1.h_das.value;
      var h_sz3 = document.forms.fhlv1.h_sz3.value;
      var h_dav = document.forms.fhlv1.h_dav.value;
      var h_dao = "";
      if( drupoh == 12 ) { var h_dao = document.forms.fhlv1.h_dao.value; }

      // create the params string
      var params = "h_drupoh=" + h_drupoh + "&h_pohyb=" + h_pohyb + "&h_odkial=" + h_odkial + "&h_dok=" + h_dok + "&h_ico=" + h_ico ;
          params += "&h_dat=" + h_dat + "&h_zao=" + h_zao + "&h_zk0=" + h_zk0 + "&h_zk1=" + h_zk1;
          params += "&h_zk2=" + h_zk2 + "&h_dn1=" + h_dn1 + "&h_dn2=" + h_dn2; 
          params += "&h_uce=" + h_uce + "&h_txp=" + h_txp + "&h_txz=" + h_txz + "&h_poz=" + h_poz + "&h_kto=" + h_kto + "&h_unk=" + h_unk;
          params += "&h_fak=" + h_fak + "&h_dol=" + h_dol + "&h_prf=" + h_prf + "&h_obj=" + h_obj + "&h_dpr=" + h_dpr;
          params += "&h_str=" + h_str + "&h_zak=" + h_zak + "&h_ksy=" + h_ksy + "&h_ssy=" + h_ssy;
          params += "&h_daz=" + h_daz + "&h_das=" + h_das + "&h_sz3=" + h_sz3 + "&h_dav=" + h_dav + "&h_dao=" + h_dao;

      // initiate reading a file from the server
      xmlHttp.open("GET", "robot_fju.php?" + params, true);
      }


//    odkial=0 z podvojneho  11,12faktury z copern=5 zahlavie
      if( h_odkial == 0 )
      {
      var h_drupoh = drupoh; 
      var h_pohyb = pohyb;
      var h_uce = document.forms.fhlv1.h_uce.value; 
      var h_dok = document.forms.fhlv1.h_dok.value; 
      var h_ico = document.forms.fhlv1.h_ico.value; 
      var h_dat = document.forms.fhlv1.h_dat.value; 
      var h_zao = document.forms.fhlv1.h_zao.value; 
      var h_zk0 = document.forms.fhlv1.h_zk0.value; 
      var h_zk1 = document.forms.fhlv1.h_zk1.value; 
      var h_zk2 = document.forms.fhlv1.h_zk2.value; 
      var h_dn1 = document.forms.fhlv1.h_dn1.value; 
      var h_dn2 = document.forms.fhlv1.h_dn2.value; 
      var h_txp = document.forms.fhlv1.h_txp.value; 
      var h_txz = document.forms.fhlv1.h_txz.value;
      var h_kto = "";
      var h_poz = document.forms.fhlv1.h_poz.value;
      var h_unk = document.forms.fhlv1.h_unk.value;

      var h_fak = document.forms.fhlv1.h_fak.value;
      var h_dol = document.forms.fhlv1.h_dol.value;
      var h_prf = document.forms.fhlv1.h_prf.value;
      var h_obj = document.forms.fhlv1.h_obj.value;
      var h_dpr = document.forms.fhlv1.h_dpr.value;

      var h_str = document.forms.fhlv1.h_str.value;
      var h_zak = document.forms.fhlv1.h_zak.value;
      var h_ksy = document.forms.fhlv1.h_ksy.value;
      var h_ssy = document.forms.fhlv1.h_ssy.value;

      var h_daz = document.forms.fhlv1.h_daz.value;
      var h_das = document.forms.fhlv1.h_das.value;
      var h_sz3 = document.forms.fhlv1.h_sz3.value;
      var h_dav = document.forms.fhlv1.h_dav.value;
      var h_dao = "";
      if( drupoh == 12 ) { var h_dao = document.forms.fhlv1.h_dao.value; }
      var pau80 = 0;
      if( document.fhlv1.pau80.checked ) { pau80=1; }

      // create the params string
      var params = "h_drupoh=" + h_drupoh + "&h_pohyb=" + h_pohyb + "&h_odkial=" + h_odkial + "&h_dok=" + h_dok + "&h_ico=" + h_ico ;
          params += "&h_dat=" + h_dat + "&h_zao=" + h_zao + "&h_zk0=" + h_zk0 + "&h_zk1=" + h_zk1;
          params += "&h_zk2=" + h_zk2 + "&h_dn1=" + h_dn1 + "&h_dn2=" + h_dn2 + "&pau80=" + pau80; 
          params += "&h_uce=" + h_uce + "&h_txp=" + h_txp + "&h_txz=" + h_txz + "&h_poz=" + h_poz + "&h_kto=" + h_kto + "&h_unk=" + h_unk;
          params += "&h_fak=" + h_fak + "&h_dol=" + h_dol + "&h_prf=" + h_prf + "&h_obj=" + h_obj + "&h_dpr=" + h_dpr;
          params += "&h_str=" + h_str + "&h_zak=" + h_zak + "&h_ksy=" + h_ksy + "&h_ssy=" + h_ssy;
          params += "&h_daz=" + h_daz + "&h_das=" + h_das + "&h_sz3=" + h_sz3 + "&h_dav=" + h_dav + "&h_dao=" + h_dao;

      // initiate reading a file from the server
      xmlHttp.open("GET", "robot_fpu.php?" + params, true);
      }


//    odkial=19 z jednoducheho  11,12faktury z copern=7 polozky
      if( h_odkial == 19 )
      {
      var h_drupoh = drupoh; 
      var h_pohyb = pohyb;
      var h_dok = document.forms.forms1.h_dok.value; 


      // create the params string
      var params = "h_drupoh=" + h_drupoh + "&h_pohyb=" + h_pohyb + "&h_odkial=" + h_odkial + "&h_dok=" + h_dok;

      // initiate reading a file from the server
      xmlHttp.open("GET", "robot_fju.php?" + params, true);
      }


//    odkial=0 z podvojneho  11,12faktury z copern=7 polozky
      if( h_odkial == 10 )
      {
      var h_drupoh = drupoh; 
      var h_pohyb = pohyb;
      var h_dok = document.forms.forms1.h_dok.value; 

      // create the params string
      var params = "h_drupoh=" + h_drupoh + "&h_pohyb=" + h_pohyb + "&h_odkial=" + h_odkial + "&h_dok=" + h_dok;

      // initiate reading a file from the server
      xmlHttp.open("GET", "robot_fpu.php?" + params, true);
      }

      xmlHttp.onreadystatechange = cakajHlas;
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
function cakajHlas() 
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
          tabulka_HlasXML();

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
function tabulka_HlasXML()
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

  // generate HTML output
  var odkial = 0;
  var drupoh = 0;
  var pohyb = 0;
  var uce = 0;
  var dok = 0;
  var ico = 0;

  for (var i=0; i<pol01Array.length; i++)
    {
    odkial = pol01Array.item(i).firstChild.data;
    drupoh = pol02Array.item(i).firstChild.data;
    pohyb = pol03Array.item(i).firstChild.data;
    uce = pol04Array.item(i).firstChild.data;
    dok = pol05Array.item(i).firstChild.data;
    }

  var html = "<table  class='fmenz' width='100%'>";


  // iterate through the arrays and create an HTML structure
  for (var i=0; i<pol01Array.length; i++)
    {
    if( odkial == 0 ) {  html += "<tr><td width='7%' class='hvstuz'>OKay</td></tr>"; }
    if( odkial == 9 ) {  html += "<tr><td width='7%' class='hvstuz'>OKay</td></tr>"; }
    }

  // obtain a reference to the <div> element on the page
     html += "</table>";


  myhlas = document.getElementById("robothlas");
  // display the HTML output
  bodywhite.style.cursor = "auto";
  myhlas.innerHTML = html;
  robotmenu.style.display='none';
  robothlas.style.display='';


  if( odkial == 0 && drupoh == 11 ) {
var parok = "sysx=UCT&hladaj_uce=" + uce + "&rozuct=ANO&copern=20&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT" +
            "&cislo_dok=" + dok + "&h_ico=" + ico +"&h_uce=" + uce + "&h_unk";
window.open('vstf_t.php?' + parok, '_self' );

                                    }

  if( odkial == 0 && drupoh == 12 ) {
var parok = "sysx=UCT&hladaj_uce=" + uce + "&rozuct=ANO&copern=20&drupoh=2&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT" +
            "&cislo_dok=" + dok + "&h_ico=" + ico +"&h_uce=" + uce + "&h_unk";
window.open('vstf_t.php?' + parok, '_self' );

                                    }



  if( odkial == 9 && drupoh == 11 ) {
var parok = "sysx=UCT&hladaj_uce=" + uce + "&rozuct=ANO&copern=20&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT" +
            "&cislo_dok=" + dok + "&h_ico=" + ico +"&h_uce=" + uce + "&h_unk";
window.open('vstf_t.php?' + parok, '_self' );

                                    }

  if( odkial == 9 && drupoh == 12 ) {
var parok = "sysx=UCT&hladaj_uce=" + uce + "&rozuct=ANO&copern=20&drupoh=2&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT" +
            "&cislo_dok=" + dok + "&h_ico=" + ico +"&h_uce=" + uce + "&h_unk";
window.open('vstf_t.php?' + parok, '_self' );

                                    }


}




