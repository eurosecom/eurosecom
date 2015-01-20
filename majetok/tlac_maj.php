<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'HIM';
$urov = 1000;
$cslm=310;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../ucto/vtvuct.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$h_dru = 1*$_REQUEST['h_dru'];
$czs = 1*$_REQUEST['czs'];

//echo $czs;
//echo "cop".$copern;

if( $czs == 0 )
{
$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_majzos_maj ORDER by czs DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $czs=$riadmax->czs+1;
  }
if( $czs == 0 ) $czs=1;

$czs1=0;
$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_majzos_maj WHERE czs=1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $czs1=$riadmax->czs;
  }

//echo $czs1;
if( $czs1 == 0 ) 
     {
$czs=1;
$dsqlt = "INSERT INTO F$kli_vxcf"."_majzos_maj (czs,nzs,pzs,por,pol,pop,vyz,trd,pod) ".
" VALUES ('$czs', 'zostava1', 'zostava1', '1', 'inv', 'Inv.Ë.', 'Invent·rne ËÌslo', '0', '' ) ";
$dsql = mysql_query("$dsqlt"); 
$copern=1;
//echo $dsqlt;
//exit;
     }
}

$citfir = include("../cis/citaj_fir.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$sqlt = <<<prcprizdphs
(
   czs          DECIMAL(10,0),
   nzs          VARCHAR(40),
   pzs          VARCHAR(40),
   ttp          TEXT,
   ttz          TEXT,
   cpl          int not null auto_increment,
   por          DECIMAL(10,0),
   pol          VARCHAR(10),
   pop          VARCHAR(20),
   vyz          VARCHAR(40),
   pod          VARCHAR(40),
   trd          INT,
   fic          INT,
   PRIMARY KEY(cpl)
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_majzos_maj'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "ALTER TABLE F".$kli_vxcf."_majzos_maj MODIFY pop VARCHAR(30)";
$vysledek = mysql_query("$sql");


$sql = "SELECT mes FROM majmajpol ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "DROP TABLE majmajpol ";
$vysledok = mysql_query($sql);

$sqlt = <<<uctcrv
(
   xpol          VARCHAR(10),
   xpop          VARCHAR(20),
   xdlz          VARCHAR(3),
   xzar          VARCHAR(2),
   xvyz          VARCHAR(40)
);
uctcrv;

$vsql = 'CREATE TABLE majmajpol'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'inv', 'Inv.Ë.', '15', 'R', 'Invent·rne ËÌslo' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'naz', 'N·zov', '35', 'L', 'N·zov majetku' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'drm', 'DRM', '10', 'L', 'DRM' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'cen', 'Obst.cena', '20', 'R', 'Obstar·vacia cena' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'ops', 'Opr·vky', '20', 'R', 'Opr·vky' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'zos', 'Zost.cena', '20', 'R', 'Zost.cena' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'zak', 'ZAK', '10', 'L', 'ZAK' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'vyc', 'v.Ë.', '20', 'L', 'v˝robnÈ ËÌslo' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'tri', 'TRI', '10', 'L', 'Trieda' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'obo', 'OBO', '10', 'L', 'Obor' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'spo', 'SPO', '10', 'R', 'SpÙsob odpisovania' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'sku', 'SKU', '10', 'R', 'Odpisov· skupina ˙Ëtovn·' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'rvr', 'r.v˝r.', '10', 'L', 'Rok v˝roby' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'ros', 'RoË.odpis', '20', 'R', 'RoË.odpis' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'mes', 'Mes.odpis', '20', 'R', 'Mes.odpis' )";
$ttqq = mysql_query("$ttvv");
               }

$sql = "SELECT * FROM majmajpol WHERE xpol = 'dob' ";
$vysledok = mysql_query($sql);
$pol = mysql_num_rows($vysledok);
if ( $pol == 0 ){

$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'ckp', 'CKP', '20', 'L', 'CKP' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'jkp', 'JKP', '20', 'L', 'JKP' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'kanc', 'KANC', '20', 'L', 'Kancel·ria' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'pop', 'Popis', '35', 'L', 'Popis majetku' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'poz', 'Pozn·mka', '35', 'L', 'Pozn·mka' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'zar', 'ZaradenÈ', '10', 'L', 'D·tum zaradenia' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'dob', 'ObstaranÈ', '10', 'L', 'D·tum obstarania' )";
$ttqq = mysql_query("$ttvv");
                }

$sql = "SELECT * FROM majmajpol WHERE xpol = 'str' ";
$vysledok = mysql_query($sql);
$pol = mysql_num_rows($vysledok);
if ( $pol == 0 ){

$ttvv = "INSERT INTO majmajpol ( xpol,xpop,xdlz,xzar,xvyz ) VALUES ( 'str', 'STR', '10', 'L', 'STR' )";
$ttqq = mysql_query("$ttvv");
                }

$kopia=0;

//kopia zostavy
if ( $copern == 115 )
    {

$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_majzos_maj ORDER by czs DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $czs=$riadmax->czs+1;
  }
$copy_zos = 1*$_REQUEST['copy_zos'];


$dsqlt = "INSERT INTO F$kli_vxcf"."_majzos_maj "." SELECT ".
"'$czs',nzs,pzs,ttp,ttz,0,por,pol,pop,vyz,pod,trd,0 ".
" FROM F$kli_vxcf"."_majzos_maj WHERE F$kli_vxcf"."_majzos_maj.czs = $copy_zos ";
$dsql = mysql_query("$dsqlt"); 

$kopia=1;
$copern=1;

    }
//koniec kopia zostavy 

//zmaz zostavu 
if ( $copern == 116 )
    {
$del_zos = 1*$_REQUEST['del_zos'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_majzos_maj WHERE czs = $del_zos ";
$dsql = mysql_query("$dsqlt"); 

$copern=1;

    }
//koniec zmaz zostavu 


//ulozenie  polozky 
if ( $copern == 15 )
    {

$h_por = 1*$_REQUEST['h_por'];
$h_pol = strip_tags($_REQUEST['h_pol']);
$h_pop = strip_tags($_REQUEST['h_pop']);
$h_vyz = strip_tags($_REQUEST['h_vyz']);
$h_pod = strip_tags($_REQUEST['h_pod']);
$h_trd = strip_tags($_REQUEST['h_trd']);
$h_nzs = strip_tags($_REQUEST['h_nzs']);
$h_pzs = strip_tags($_REQUEST['h_pzs']);
$h_ttp = $_REQUEST['h_ttp'];
$h_ttz = $_REQUEST['h_ttz'];

$h_ttp=str_replace("<br />","\r",$h_ttp);
$h_ttz=str_replace("<br />","\r",$h_ttz);

//echo $h_ttp;
//exit;


$sqty = "INSERT INTO F$kli_vxcf"."_majzos_maj ( czs,nzs,pzs,ttp,ttz,por,pol,pop,vyz,pod,trd )".
" VALUES ( '$czs', '$h_nzs', '$h_pzs', '$h_ttp', '$h_ttz', '$h_por', '$h_pol', '$h_pop', '$h_vyz', '$h_pod', '$h_trd' );"; 

//echo $sqty;

if( $h_por > 0 ) $ulozene = mysql_query("$sqty"); 

$sqty = "UPDATE F$kli_vxcf"."_majzos_maj SET nzs='$h_nzs', pzs='$h_pzs', ttp='$h_ttp', ttz='$h_ttz' ".
" WHERE czs = $czs"; 

//echo $sqty;

if( $h_nzs != '' ) $ulozene = mysql_query("$sqty"); 


$copern=1;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia polozky 

$zmazanie=0;

//vymazanie  polozky 
if ( $copern == 16 )
    {

$h_cpl = 1*$_REQUEST['h_cpl'];
$zmazanie=1;


$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_majzos_maj WHERE cpl=$h_cpl LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $zmaz_por=$riadmax->por;
  $zmaz_pol=$riadmax->pol;
  $zmaz_pop=$riadmax->pop;
  $zmaz_pod=$riadmax->pod;
  $zmaz_trd=$riadmax->trd;
  $zmaz_por=$riadmax->por;
  $zmaz_vyz=$riadmax->vyz;
  $h_ttp=$riadmax->ttp;
  $h_ttz=$riadmax->ttz;
  }

$sqty = "DELETE FROM F$kli_vxcf"."_majzos_maj WHERE cpl = $h_cpl"; 

//echo $sqty;

$ulozene = mysql_query("$sqty"); 

$copern=1;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec vymazania polozky 

$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_majzos_maj WHERE czs=$czs ORDER by czs DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $nzs=$riadmax->nzs;
  $pzs=$riadmax->pzs;
  $h_ttp=$riadmax->ttp;
  $h_ttz=$riadmax->ttz;
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>TlaË ˙dajov o majetku</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>

<script type="text/javascript" src="spr_majpol_xml.js"></script>

<script type="text/javascript">
var sirkawin = screen.width-10;
var vyskawin = screen.height-10;

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }


//  Oprav ciarku na bodku u desatinnych cisiel
    function CiarkaNaBodku(Vstup)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
    }


//posuny Enter[[[[[[[[[[[



function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.forms1.h_uce.value != ''  )
        {
        New.style.display="none";
        myUcetelement.style.display='none';
        document.forms.forms1.h_nai.value = '';
        volajUcet();
        }      

        if( document.forms1.h_uce.value == "" ) {  document.forms1.h_nai.focus(); }

              }
                }



function VyberVstup()
                {
        document.forms.formz1.h_zos.value = '<?php echo $czs; ?>';
        document.forms.forms1.h_nzs.value = '<?php echo $nzs; ?>';
        document.forms.forms1.h_pzs.value = '<?php echo $pzs; ?>';

<?php if ( $zmazanie == 1 ) { ?>
        document.forms.forms1.h_por.value = '<?php echo $zmaz_por; ?>';
        document.forms.forms1.h_pol.value = '<?php echo $zmaz_pol; ?>';
        document.forms.forms1.h_pop.value = '<?php echo $zmaz_pop; ?>';
        document.forms.forms1.h_pod.value = '<?php echo $zmaz_pod; ?>';
        document.forms.forms1.h_vyz.value = '<?php echo $zmaz_vyz; ?>';
<?php                       } ?>
                }

function PdfZos()
                {

var h_zos = document.forms.formz1.h_zos.value;
var h_dru = document.forms.formz1.h_dru.value;
  var h_vyber = 0;
  if( document.formz1.h_vyber.checked ) h_vyber=1;
  var h_vyrad = 0;
  if( document.formz1.h_vyrad.checked ) h_vyrad=1;

window.open('../majetok/tlac_majpdf.php?h_zos=' + h_zos + '&h_dru=' + h_dru + '&h_vyber=' + h_vyber + '&h_vyrad=' + h_vyrad + '&copern=30&drupoh=1&page=1&typ=PDF',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function HtmlZos()
                {

var h_zos = document.forms.formz1.h_zos.value;


window.open('../majetok/tlac_majpdf.php?h_zos=' + h_zos + '&copern=30&drupoh=1&page=1&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }


function Vynuluj()
                {
myUcetelement.style.display='none';
New.style.display='none';

document.forms.forms1.h_por.value='';
document.forms.forms1.h_por.focus();


                }

function ZmazPolozku(cpl)
                {
var h_cpl = cpl;

window.open('tlac_maj.php?h_cpl=' + h_cpl + '&copern=16&drupoh=1&page=1&typ=HTML&czs=<?php echo $czs; ?>', '_self' );

                }

function UpravPolozku(por)
                {

                }

function UlozPolozku()
                {
var h_por = document.forms.forms1.h_por.value;
var h_pol = document.forms.forms1.h_pol.value;
var h_pod = document.forms.forms1.h_pod.value;
var h_pop = document.forms.forms1.h_pop.value;
var h_vyz = document.forms.forms1.h_vyz.value;
var h_trd = 0;
if( document.forms.forms1.h_trd.checked ) { h_trd=1; }


var h_nzs = document.forms.forms1.h_nzs.value;
var h_pzs = document.forms.forms1.h_pzs.value;

var h_ttp = document.forms.forms1.h_ttp.value;
var h_ttpen = h_ttp.replace("\r","<br />");
var h_ttpen = h_ttpen.replace("\r","<br />");
var h_ttpen = h_ttpen.replace("\r","<br />");
var h_ttpen = h_ttpen.replace("\r","<br />");
var h_ttpen = h_ttpen.replace("\r","<br />");
var h_ttpen = h_ttpen.replace("\r","<br />");
var h_ttpen = h_ttpen.replace("\r","<br />");

var h_ttz = document.forms.forms1.h_ttz.value;
var h_ttzen = h_ttz.replace("\r","<br />");
var h_ttzen = h_ttzen.replace("\r","<br />");
var h_ttzen = h_ttzen.replace("\r","<br />");
var h_ttzen = h_ttzen.replace("\r","<br />");
var h_ttzen = h_ttzen.replace("\r","<br />");
var h_ttzen = h_ttzen.replace("\r","<br />");
var h_ttzen = h_ttzen.replace("\r","<br />");

window.open('tlac_maj.php?copern=15' + '&h_ttz=' + h_ttzen + '&h_ttp=' + h_ttpen + '&h_por=' + h_por  + '&h_pol=' + h_pol + '&h_pod=' + h_pod + '&h_pop=' + h_pop + '&h_vyz=' + h_vyz + '&h_nzs=' + h_nzs + '&h_pzs=' + h_pzs + '&h_trd=' + h_trd + '&drupoh=1&page=1&typ=HTML&czs=<?php echo $czs; ?>', '_self' );

                }

function EditZos()
                {
var h_zos = document.forms.formz1.h_zos.value;

window.open('tlac_maj.php?czs=' + h_zos + '&copern=1', '_self' );
                }

function ZmazZos()
                {
var h_zos = document.forms.formz1.h_zos.value;

window.open('tlac_maj.php?del_zos=' + h_zos + '&copern=116&czs=<?php echo $czs; ?>', '_self' );
                }

function CopyZos()
                {
var h_zos = document.forms.formz1.h_zos.value;

window.open('tlac_maj.php?copy_zos=' + h_zos + '&copern=115&czs=<?php echo $czs; ?>', '_self' );
                }

//co urobi po potvrdeni ok z tabulky zak
function vykonajZak(pol,pop,vyz)
                {
         document.forms.forms1.h_pol.value = pol;
         document.forms.forms1.h_pop.value = pop;
         document.forms.forms1.h_vyz.value = vyz;
         myZakelement.style.display='none';

         document.forms1.h_pod.focus();
         document.forms1.h_pod.select();
                }


function Len1Zak(pol,pop,vyz)
              {
         document.forms.forms1.h_pol.value = pol;
         document.forms.forms1.h_pop.value = pop;
         document.forms.forms1.h_vyz.value = vyz;
         myZakelement.style.display='none';

         document.forms1.h_pod.focus();
         document.forms1.h_pod.select();
              }

function Len0Zak()
                    {
         document.forms1.h_pol.focus();
         document.forms1.h_pol.select();
                    }


  </script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  TlaË ˙dajov o majetku</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<table class="fmenu" width="100%" >

<FORM name="formz1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu" colspan="9">

<select size="1" name="h_dru" id="h_dru" >
<option value="1" >Dlhodob˝</option>
<option value="2" >Drobn˝</option>
</select>

Vyberte zostavu
<?php
$sql = "DROP TABLE F".$kli_vxcf."_majzos_maj".$kli_uzid." ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_majzos_maj$kli_uzid SELECT * FROM F".$kli_vxcf."_majzos_maj WHERE fic != 0";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majzos_maj$kli_uzid"." SELECT *".
" FROM F$kli_vxcf"."_majzos_maj WHERE F$kli_vxcf"."_majzos_maj.czs >= 0 GROUP BY czs ";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_majzos_maj".$kli_uzid." WHERE czs > 0 ORDER BY pzs");
?>
<select size="1" name="h_zos" id="h_zos" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["czs"];?>" >
Ë.<?php echo $zaznam["czs"];?> - <?php echo $zaznam["pzs"];?></option>
<?php endwhile;?>
</select>

<a href="#" onClick="PdfZos();" >
<img border=0 src='../obr/tlac.png' style='width:20; height:20;' title='VytlaË preddefinovan˙ zostavu PDF' >
 PDF </a>

<img src='../obr/info.png' onClick='' width=12 height=12 border=0 title='Ak zaökrtnete polÌËko pouûije sa pre zostavu v˝ber zo zoznamu majetku' >

<input type="checkbox" name="h_vyber" value="1" />

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
VYR <img src='../obr/info.png' onClick='' width=12 height=12 border=0 title='Ak zaökrtnete polÌËko tlaËiù sa bude z vyradenÈho majetku' >
<input type="checkbox" name="h_vyrad" value="1" />

<?php
$dajhtml=0;
if( $dajhtml == 1 )
{
?>
<a href="#" onClick="HtmlZos();" >
<img border=0 src='../obr/zoznam.png' style='width:20; height:20;' title='VytlaË preddefinovan˙ zostavu HTML' >
 HTML </a>
<?php
}
?>

<td class="hmenu" colspan="1">
<a href="#" onClick="EditZos();" >
<img border=0 src='../obr/uprav.png' style='width:20; height:20;' title='Uprav preddefinovan˙ zostavu HTML' >
</a>

<a href="#" onClick="CopyZos();" >
<img border=0 src='../obr/ziarovka.png' style='width:20; height:20;' title='KÛpia preddefinovanej zostavy' >
</a>

<a href="#" onClick="ZmazZos();" >
<img border=0 src='../obr/zmazuplne.png' style='width:20; height:20;' title='Zmaû preddefinovan˙ zostavu' >
</a>
</tr>
</FORM>
</table>

<table class="fmenu" width="100%" >

<FORM name="forms1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu" colspan="10">Zostava Ë.<?php echo $czs; ?> 
<tr>
<td class="hmenu" colspan="10"> 
<tr>
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%"> 
<td class="hmenu" width="10%">
<td class="hmenu" width="10%"> 
<td class="hmenu" width="10%">
<td class="hmenu" width="10%"> 
<td class="hmenu" width="10%">
</tr>
<tr>
<td class="hmenu" colspan="10" align="left">
<input type="text" name="h_nzs" id="h_nzs" size="40" onclick="New.style.display='none'; " />N·zov zostavy
<tr>
<td class="hmenu" colspan="10" align="left">
<input type="text" name="h_pzs" id="h_pzs" size="40" onclick="New.style.display='none'; " />Popis zostavy

<tr><td class="bmenu" colspan="10">
<textarea name="h_ttp" id="h_ttp" rows="4" cols="80" >
<?php echo $h_ttp; ?>
</textarea>Text pred poloûkami
</td></tr>

<tr><td class="bmenu" colspan="10">
<textarea name="h_ttz" id="h_ttz" rows="4" cols="80" >
<?php echo $h_ttz; ?>
</textarea>Text za poloûkami
</td></tr>

<tr>
<td class="hmenu" align="left">Poradie
<td class="hmenu" >Poloûka
<td class="hmenu" >Popis
<td class="hmenu" colspan="3">V˝znam
<td class="hmenu" colspan="3">Triedenie a podmienka ( tvar podmienky napr.: 1,2,7-12,28 )

<td class="hmenu" width="10%">
</tr>
<tr>
<td class="hmenu" colspan="1" align="left"><input type="text" name="h_por" id="h_por" size="10" 
onclick="New.style.display='none'; " />
<td class="hmenu" colspan="1" align="left">
<a href="#" onClick="myZakelement.style.display=''; volajZak(0,1);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù z·kazku" ></a>
<input type="text" name="h_pol" id="h_pol" size="10" 
onclick="New.style.display='none'; " />
<td class="hmenu" colspan="1" align="left"><input type="text" name="h_pop" id="h_pop" size="15" 
onclick="New.style.display='none'; " />
<td class="hmenu" colspan="3" align="left"><input type="text" name="h_vyz" id="h_vyz" size="40" 
onclick="New.style.display='none'; " />
<td class="hmenu" colspan="2" align="left">
 <input type="checkbox" name="h_trd" />
<input type="text" name="h_pod" id="h_pod" size="20" 
onclick="New.style.display='none'; " />

<td class="hmenu" colspan="1" align="left">
<button id="uloz" onclick="UlozPolozku(); ">Uloûiù</button>

</tr>

</FORM>
</table>

<div id="myZakelement"></div>
<div id="jeZak"></div>
<div id="myUcetelement"></div>
<div id="myUcmtelement"></div>
<div id="myUcdtelement"></div>
<div id="myIcoelement"></div>
<div id="myFakelement"></div>

<div id="Okno"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som ˙Ëet podæa zadan˝ch podmienok, sk˙ste znovu</span>

<table class="fmenu" width="100%" >

<?php

$sqltt="SELECT * FROM F$kli_vxcf"."_majzos_maj WHERE czs = $czs ORDER BY czs,por";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
?>

<?php
if( $i == 0 )
{
?>
<tr>
<td class="hmenu" colspan="10">Zostava Ë.<?php echo $polozka->czs; ?> N·zov:<?php echo $polozka->nzs; ?> Popis:<?php echo $polozka->pzs; ?>
</tr>


<tr>
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
<td class="hmenu" colspan="1" width="10%">
</tr>
<?php
}
//koniec i=0
?>

<tr>
<td class="hvstup" colspan="1" width="10%"><?php echo $polozka->por; ?>
<td class="hvstup" colspan="1" width="10%"><?php echo $polozka->pol; ?>
<td class="hvstup" colspan="1" width="10%"><?php echo $polozka->pop; ?>
<td class="hvstup" colspan="3" width="10%"><?php echo $polozka->vyz; ?>
<td class="hvstup" colspan="2" width="10%">
<?php if( $polozka->trd == 1 ) {  ?>
 <input type="checkbox" name="trd" value="1" checked = "checked" disabled />
<?php
   }
?>
<?php if( $polozka->trd != 1 ) {  ?>
 <input type="checkbox" name="trd" value="1" disabled />
<?php
   }
?>
<?php echo $polozka->pod; ?> 
<td class="hvstup" colspan="1" width="10%">
 <a href="#" onClick="ZmazPolozku(<?php echo $polozka->cpl; ?>);">
 <img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>
</tr>


<?php
}

$i=$i+1;
  }
//koniec while

?>
</table>


<?php
$sql = "DROP TABLE F".$kli_vxcf."_majzos_maj".$kli_uzid." ";
$vysledek = mysql_query("$sql");

// celkovy koniec dokumentu

$cislista = include("maj_lista.php");
       } while (false);
?>
</BODY>
</HTML>
