<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = 1*strip_tags($_REQUEST['cislo_dok']);

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


//504ka do vseobecneho
if( $copern == 100 )
    {

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdh WHERE dok = $cislo_dok ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ume=$riaddok->ume;
  $hladaj_uce = 1*$riaddok->uce;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ORDER BY dat ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $datp=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = $ume ORDER BY dat DESC ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $datk=$riaddok->dat;
  }


//odberatelske
$sqlttt = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dat >= '$datp' AND dat <= '$datk' ";

$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;

//echo $sqlttt;
//exit;

if( $cpol >= 1 )
               {

while ($i < $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
    {
  $riadok=mysql_fetch_object($sql);


$sqltt = "SELECT * FROM F$kli_vxcf"."_uctodb WHERE dok = $riadok->dok AND LEFT(ucd,3) = 604 ";
$sqldok = mysql_query("$sqltt");

$cpolx = mysql_num_rows($sqldok);
$ix=0;

if( $cpolx >= 1 )
               {

while ($ix < $cpolx )
{
  if (@$zaznamx=mysql_data_seek($sqldok,$ix))
    {
  $riaddok=mysql_fetch_object($sqldok);

 
  $hodnota=0.901*$riaddok->hod;
  $ico=1*$riaddok->ico;
  $fak=1*$riaddok->fak;
  $str=1*$riaddok->str;
  $zak=1*$riaddok->zak;



//uctvsdp  dok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm   
//uctodb   dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvsdp  SELECT ".
" '$cislo_dok',5,0,'50400','13200',1,0,'$hodnota',0,0,'',0,$ico,$fak,'','$str','$zak','','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_uctodb ".
" WHERE cpl = $riaddok->cpl ";

$dsql = mysql_query("$dsqlt");

//echo $dsqlt;


    }
$ix=$ix+1;
}


//if( $cpolx >= 1 )
               }


    }
$i=$i+1;
}

//if( $cpol >= 1 )
               }

//koniec odberatelske

//prijmove
$sqlttt = "SELECT * FROM F$kli_vxcf"."_pokpri WHERE dat >= '$datp' AND dat <= '$datk' ";

$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;

//echo $sqlttt;
//exit;

if( $cpol >= 1 )
               {

while ($i < $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
    {
  $riadok=mysql_fetch_object($sql);


$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpokuct WHERE dok = $riadok->dok AND LEFT(ucd,3) = 604 ";
$sqldok = mysql_query("$sqltt");

$cpolx = mysql_num_rows($sqldok);
$ix=0;

if( $cpolx >= 1 )
               {

while ($ix < $cpolx )
{
  if (@$zaznamx=mysql_data_seek($sqldok,$ix))
    {
  $riaddok=mysql_fetch_object($sqldok);

 
  $hodnota=0.902*$riaddok->hod;
  $ico=1*$riaddok->ico;
  $fak=1*$riaddok->fak;
  $str=1*$riaddok->str;
  $zak=1*$riaddok->zak;



//uctvsdp  dok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm   
//uctodb   dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvsdp  SELECT ".
" '$cislo_dok',5,0,'50400','13200',1,0,'$hodnota',0,0,'',0,$ico,$fak,'','$str','$zak','','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_uctpokuct ".
" WHERE cpl = $riaddok->cpl ";

$dsql = mysql_query("$dsqlt");

//echo $dsqlt;


    }
$ix=$ix+1;
}


//if( $cpolx >= 1 )
               }


    }
$i=$i+1;
}

//if( $cpol >= 1 )
               }

//koniec prijmove


    }
//koniec if( $copern == 101 )







//504ka do vseobecneho
if( $copern == 100 )
    {

//<a href='vspk_u.php?sysx=UCT&hladaj_uce=1&rozuct=ANO&copern=8&drupoh=5&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT
//&cislo_dok=3&h_ico=31423116&h_uce=1&h_unk='>


?> 
<script type="text/javascript">
  var okno = window.open("vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=ANO&copern=8&drupoh=5&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_uce=<?php echo $hladaj_uce; ?>","_self");
</script>
<?php 


    }
//koniec if( $copern == 100 )

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Polozky do dokladu</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

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



<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    



</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
