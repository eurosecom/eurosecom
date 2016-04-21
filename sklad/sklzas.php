<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 1000;
$cslm=404600;
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
$sql = "SELECT * FROM F$kli_vxcf"."_vtvskl";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../sklad/vtvskl.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*$_REQUEST['copern'];

?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Stav z·sob</title>
  <style type="text/css">

  </style>

<script type="text/javascript">

</script>
</HEAD>
<BODY class="white" >

<?php 

// aktualna strana
$page = $_REQUEST['page'];

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Stav z·sob

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//rekonstrukcia sklzas
    if ( $copern == 50 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete zrekonötruovaù aktu·lny stav z·sob na materi·lov˝ch poloûk·ch ?") )
         { window.close()  }
else
         { location.href='sklzas.php?copern=55'  }
</script>
<?php
    }

if ( $copern == 55 )
    {

//$reko = include("skl_rekonstrukcia_old.php");
$reko = include("skl_rekonstrukcia.php");

$copern=1;
    }
//koniec rekonstrukcie



if ( $copern == 1 )
  {

$sql = mysql_query("SELECT skl, F$kli_vxcf"."_sklzas.cis, F$kli_vxcf"."_sklcis.nat,".
" zas, F$kli_vxcf"."_sklcis.mer, F$kli_vxcf"."_sklzas.cen".
" FROM F$kli_vxcf"."_sklzas".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklzas.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE skl > 0 ".
" ORDER BY skl,cis,cen");
  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
// pocet poloziek na strane
$pols = 1*41;
// pocet stran
$xstr =ceil($cpol / $pols);
$strana = 1;
?>

<?php
$celkom = 0.00;
$hodnota = 0.00;
   while ($strana <= $xstr )
     {
?>

<table width="660px" align="left" border="1" cellpadding="3" cellspacing="0"  rules="rows" bordercolor="lightblue" >
<caption align="left"><b>Stav z·sob - okamûit˝ stav</b>
<a href='sklzas_t.php?copern=10' target="_blank">
<img src='../obr/tlac.png' width=20 height=18 border=0 alt="Verzia pre tlaË" ></a></td>
</caption>
<tr bgcolor="lightblue">
<th class="tlac">Sklad<th class="tlac">».materi·lu<th class="tlac">N·zov materi·lu<th class="tlac">Cena
<th class="tlac">Mnoûstvo<th class="tlac">MJ<th class="tlac">Hodnota
<br />
</tr>


<?php
$i=($strana*$pols)-$pols;
$konc=($strana*$pols)-1;

   while ($i <= $konc )
   {

  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="tlac" width="4%" >&nbsp;<?php echo $riadok->skl;?></td>
<td class="tlac" width="8%" align="right" >&nbsp;<?php echo $riadok->cis;?></td>
<td class="tlac" width="45%" >&nbsp;<?php echo $riadok->nat;?></td>
<td class="tlac" align="right" >&nbsp;<?php echo $riadok->cen;?></td>
<td class="tlac" align="right" >&nbsp;<?php echo $riadok->zas;?></td>
<td class="tlac" width="3%" >&nbsp;<?php echo $riadok->mer;?></td>
<?php 
$hodnota = $riadok->cen*$riadok->zas;
$celkom = $celkom + $hodnota;
$Cislo=$hodnota+"";
$sText=sprintf("%0.2f", $Cislo);
$Cislo=$celkom+"";
$sCelkom=sprintf("%0.2f", $Cislo);
?>
<td class="tlac" align="right" >&nbsp;<?php echo $sText;?></td>
</tr>
<?php
  }
$i = $i + 1;

   }
?>
</table>
<br clear=left>

<?php
$strana = $strana + 1;
     }
?>

<table width="660px" align="left" border="1" cellpadding="3" cellspacing="0" rules="rows" bordercolor="lightblue" >
<tr bgcolor="lightblue">
<td class="tlacs">Celkom:&nbsp;<?php echo $sCelkom;?> Sk </td>
</tr>
</table>
<br clear=left>

<?php
mysql_free_result($sql);

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
