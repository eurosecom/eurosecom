<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


//spoj mzdkun a mzdkunnewzam pre niektore potvrdenia
$sqlttt = "DROP TABLE F$kli_vxcf"."_prcmzdkun$kli_uzid ";
$sql = mysql_query("$sqlttt");
$sqlttt = "DROP TABLE F$kli_vxcf"."_prcmzdkuns$kli_uzid ";
$sql = mysql_query("$sqlttt");
$sqlttt = "CREATE TABLE F$kli_vxcf"."_prcmzdkun$kli_uzid SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ";
$sql = mysql_query("$sqlttt");
$sqlttt = "CREATE TABLE F$kli_vxcf"."_prcmzdkuns$kli_uzid SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc < 0 ";
$sql = mysql_query("$sqlttt");
$sqlttt = "INSERT INTO F$kli_vxcf"."_prcmzdkun$kli_uzid SELECT * FROM F$kli_vxcf"."_mzdkunnewzam WHERE oc > 0 ";
$sql = mysql_query("$sqlttt");

$sqlttt = "INSERT INTO F$kli_vxcf"."_prcmzdkuns$kli_uzid SELECT * FROM F$kli_vxcf"."_prcmzdkun$kli_uzid WHERE oc > 0 GROUP BY oc";
$sql = mysql_query("$sqlttt");
$sqlttt = "DROP TABLE F$kli_vxcf"."_prcmzdkun$kli_uzid ";
$sql = mysql_query("$sqlttt");

//subor zmluv a dohod
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");


$sqlt = <<<mzdprc
(
   cpl          int not null auto_increment,
   oc           INT(7) DEFAULT 0,
   typ          INT DEFAULT 0,
   kedy         DATE,
   nazov        VARCHAR(80),
   paragraf     VARCHAR(80),
   text1        TEXT,
   text2        TEXT,
   konx1        DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_personal_dok'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE personal_dok'.$sqlt;
$vytvor = mysql_query("$vsql");
$sql = "ALTER TABLE F$kli_vxcf"."_personal_dok ADD pozn VARCHAR(80) NOT NULL AFTER text2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_personal_dok ADD popis VARCHAR(80) NOT NULL AFTER text2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE personal_dok ADD pozn VARCHAR(80) NOT NULL AFTER text2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE personal_dok ADD popis VARCHAR(80) NOT NULL AFTER text2";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_personal_dok MODIFY nazov VARCHAR(100) ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE personal_dok MODIFY nazov VARCHAR(100) ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_personal_dok MODIFY popis VARCHAR(100) ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE personal_dok MODIFY popis VARCHAR(100) ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_personal_dok MODIFY paragraf VARCHAR(100) ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE personal_dok MODIFY paragraf VARCHAR(100) ";
$vysledek = mysql_query("$sql");

?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zmluvy a dohody</title>
  <style type="text/css">

  </style>

<script type="text/javascript" src="spr_doklady_xml.js"></script>

<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

function novyDok()
                {
var h_oc = document.forms.formp1.h_oc.value;
var h_vel = document.forms.formp1.h_vel.value;

myStrelement.style.display='none';

window.open('../mzdy/personal_tlac.php?cislo_oc=' + h_oc + '&velkost=' + h_vel + '&copern=40&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=880, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function tlacDok(cpl,oc)
                {
var h_vel = document.forms.formp1.h_vel.value;

window.open('../mzdy/personal_tlac.php?cislo_oc=' + oc + '&velkost=' + h_vel + '&cislo_cpl=' + cpl + '&copern=10&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=880, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function upravDok(cpl,oc)
                {
//myStrelement.style.display='none';

var h_vel = document.forms.formp1.h_vel.value;

window.open('../mzdy/personal_tlac.php?cislo_oc=' + oc + '&velkost=' + h_vel + '&cislo_cpl=' + cpl + '&copern=20&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=880, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function zmazDok(cpl,oc)
                {
var xcpl = cpl;
var xoc = oc;

myStrelement.style.display='none';
zmazStr(xcpl,xoc);
                }

function ZavolajStr()
                {
var h_oc = document.forms.formp1.h_oc.value;

volajStr(h_oc,1);

                }

   
</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Person·lne zmluvy a dohody 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{
?>

<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="80%">Adres·r dokumentov :
<?php
$sql = mysql_query("SELECT oc,prie,meno FROM F$kli_vxcf"."_prcmzdkuns$kli_uzid WHERE oc > 0 ORDER BY prie,meno");
?>
<select size="1" name="h_oc" id="h_oc" onclick="myStrelement.style.display='none';">
<option value="0" >Vzory dokumentov</option>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?> osË <?php echo $zaznam["oc"];?></option>
<?php endwhile;?>
</select>
 <a href="#" onClick="ZavolajStr();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobraziù zmluvy a dohody' ></a>
</td>
<td class="bmenu" width="20%">Veækosù pÌsma tlaËe :
<select size="1" name="h_vel" id="h_vel" >
<option value="8" >8</option>
<option value="9" >9</option>
<option value="10" >10</option>
<option value="11" >11</option>
</td>

<td class="bmenu" width="2%">
</td>


</tr>
</FORM>
</table>

<div id="myStrelement" ></div>



<?php
}
//koniec zakladnej ponuky
?>

<br />
<br />


<?php
// celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
       } while (false);
?>
</BODY>
</HTML>
