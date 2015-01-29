<?php
$sys = 'MZD';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//ulozit nahraty pohyb rozuctovania faktury
// set the output content type as xml
header('Content-Type: text/xml; Accept-Charset: utf-8; ');
//header('Content-Type: text/xml ');
// create the new XML document
$dom = new DOMDocument();

// create the root <response> element
$response = $dom->createElement('response');
$dom->appendChild($response);

// create the <vety> element and append it as a child of <response>
$vety = $dom->createElement('vety');
$response->appendChild($vety);


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");

//oc
$h_oc = 1*strip_tags($_GET['h_oc']);
$h_drp = strip_tags($_GET['h_drp']);

$h_dok = strip_tags($_GET['h_dok']);
$h_dat = strip_tags($_GET['h_dat']);
$h_str = strip_tags($_GET['h_str']);
$h_dm = 1*strip_tags($_GET['h_dm']);
$h_dp = strip_tags($_GET['h_dp']);
$h_dk = strip_tags($_GET['h_dk']);
$h_dn = strip_tags($_GET['h_dn']);
$h_stj = strip_tags($_GET['h_stj']);
$h_zak = strip_tags($_GET['h_zak']);
$h_hh = strip_tags($_GET['h_hh']);
$h_mn = strip_tags($_GET['h_mn']);
$h_sa = strip_tags($_GET['h_sa']);
$h_kc = strip_tags($_GET['h_kc']);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$dat_sql=SqlDatum($h_dat);
$dp_sql=SqlDatum($h_dp);
$dk_sql=SqlDatum($h_dk);

$jeoc=0;
$sqldok = mysql_query("SELECT * FROM F".$kli_vxcf."_mzdkun WHERE oc = $h_oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $jeoc=1;
    }

if( $h_drp == 1 AND $h_oc > 0 AND $h_dm > 0 AND $jeoc == 1 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_mzdmes ( dok,oc,dat,ume,str,dm,dp,dk,dni,stj,zak,hod,mnz,saz,kc,id )".
" VALUES ('$h_dok', '$h_oc', '$dat_sql', '$kli_vume', '$h_str', '$h_dm', '$dp_sql', '$dk_sql', '$h_dn', '$h_stj', '$h_zak',".
" '$h_hh', '$h_mn', '$h_sa', '$h_kc', '$kli_uzid' );"; 

$ulozene = mysql_query("$sqty"); 

if( $wedgb == 1 )
  {
$sqty = "UPDATE F$kli_vxcf"."_mzdmes SET saz=kc/hod WHERE dm = 107 AND hod != 0 "; 
$ulozene = mysql_query("$sqty");
  }


}

$rozu=1;
$txp01=$h_oc;
$txp02=$h_drp;
$txp03=$h_kc;

// create the title element for the veta
$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

// create the pol02 element for the veta
$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

// create the pol03 element for the veta
$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);


// create the <veta> element 
$veta = $dom->createElement('veta');
$veta->appendChild($pol01);
$veta->appendChild($pol02);
$veta->appendChild($pol03);

// append <veta> as a child of <vety>
$vety->appendChild($veta);


//uloz xml strukturu
// build the XML structure in a string variable
$dom->encoding = 'utf-8';
$xmlString = $dom->saveXML();
// output the XML string
echo $xmlString;

// vystup textoveho retazca
//echo $xmlString;
//print $xmlString;

// konfigurace pro uložení
//$dom->formatOutput = TRUE;
//$dom->encoding = 'utf-8';
//$dom->save('../tmp/mesins.xml');
?>
