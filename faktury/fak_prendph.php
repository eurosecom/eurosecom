<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 2000;
$clsm = 900;
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

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$strana = 1*$_REQUEST['strana'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
//$cislo_dok=710031;
//echo $cislo_dok;
//exit;

$citfir = include("../cis/citaj_fir.php");


$zlava = 1*$_REQUEST['zlava'];
//zlava faktura
if( $zlava == 1 AND $drupoh != 42 )
{
$h_cep=0;
$h_ced=0;
$zaklad2s=0;
$sqlttt = "SELECT zk2 FROM F$kli_vxcf"."_fakodb WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad2s=1*$riaddok->zk2;
  }

$sqltt = "SELECT * FROM F$kli_vxcf"."_sklfak WHERE dok = $cislo_dok AND dph = 20 ";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
           
$i=0; $odpoczk2=0; $odpocdn2=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$colsadz="";
$sqlttt = "SELECT xcis, xtxt5 FROM F$kli_vxcf"."_sklcisudaje WHERE xcis = $riadok->cis ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $colsadz=trim($riaddok->xtxt5);
  }

//echo $riaddok->xcis." ".$colsadz."<br />";
if( $colsadz != '' )
    {

$odpoczk2=$odpoczk2+($riadok->cep*$riadok->mno);
$odpocdn2=$odpocdn2+(($riadok->ced-$riadok->cep)*$riadok->mno);

$sqty = "UPDATE F$kli_vxcf"."_sklfak SET ced=cep, dph=0, poz='colný sadzobník ".$colsadz." - prenos daòovej povinnosti' WHERE cpl = $riadok->cpl "; 
$ulozene = mysql_query("$sqty");

    }

//echo $odpoczk2." ".$odpocdn2."<br />";

}
$i = $i + 1;

  }

//exit;


$sqtz = "UPDATE F$kli_vxcf"."_fakodb SET ".
" zk2=zk2-('$odpoczk2'), sp2=sp2-('$odpoczk2')-('$odpocdn2'), dn2=sp2-zk2,  ".
" zk0=zk0+('$odpoczk2'), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";

//echo $sqtz;
$upravene = mysql_query("$sqtz");
//exit;
}
//koniec zlava faktura

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Nastavenie faktury uloz</title>
  <style type="text/css">

  </style>

<script type="text/javascript">

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
//vstf_u.php?vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=31100&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT
//&cislo_dok=710031&h_fak=710031&h_dol=0&h_prf=0

//prepni do faktury
$cstat=10101;
if( $cstat == 10101 AND $drupoh != 42 )
{
?>
<script type="text/javascript">

window.open('../faktury/vstf_u.php?copern=8&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT', '_self' )

</script>
<?php
exit;
}
//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
