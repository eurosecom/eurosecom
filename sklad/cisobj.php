<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$cslm=404200;
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

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);


$vsql = "DROP TABLE F".$kli_vxcf."_kosprcx".$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = "DROP TABLE F".$kli_vxcf."_kosprcu".$kli_uzid;
$vytvor = mysql_query("$vsql");
$vsql = "DROP TABLE F".$kli_vxcf."_kosprcv".$kli_uzid;
$vytvor = mysql_query("$vsql");

$sqlt = <<<kosprc
(
   pox          decimal(10,0) DEFAULT 0,
   xdok         int DEFAULT 0,
   xice         decimal(10,0) DEFAULT 0,
   xodbm        decimal(10,0) DEFAULT 0,
   xsx3         decimal(10,0) DEFAULT 0,
   xcpl         int(10) DEFAULT 0,
   xcis         varchar(15) NOT NULL,
   xnat         VARCHAR(50) NOT NULL,
   xdph         DECIMAL(2,0) DEFAULT 20,
   xcep         decimal(10,4) DEFAULT 0,
   xced         decimal(10,2) DEFAULT 0,
   xmno         decimal(10,3) DEFAULT 0,
   xhdb         decimal(10,2) DEFAULT 0,
   xhdd         decimal(10,2) DEFAULT 0,
   xid          INT DEFAULT 0,
   xdatm        TIMESTAMP(14),
   xskm         decimal(10,3) DEFAULT 0,
   xobm         decimal(10,3) DEFAULT 0,
   xrzd         decimal(10,3) DEFAULT 0,
   xpsk         decimal(10,3) DEFAULT 0
);
kosprc;

$vsql = "CREATE TABLE F".$kli_vxcf."_kosprcx".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_kosprcu".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_kosprcv".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$dsqlt = "INSERT INTO F$kli_vxcf"."_kosprcx".$kli_uzid.
" SELECT 1,xdok,xice,xodbm,xsx3,xcpo,xcis,xnat,xdph,xcep,xced,xmno,xhdb,xhdd,xid,xdatm,0,0,0,0 FROM F$kli_vxcf"."_kosikobj ".
" WHERE xfak = 0 ".
"";
$dsql = mysql_query("$dsqlt");



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Materiál na objednávkach</title>
<script type="text/javascript">

function StavObj(dok, ico)
                {
var dokx = dok;
var icox = ico;

window.open('../eshop/obj_stav.php?copern=1&drupoh=1&page=1&cislo_dok=' + dokx + '&icox=' + icox + '&ffd=0&tlacobj=1&zmtz=1',
 '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY class="white" >

<?php 


// aktualna strana
$page = strip_tags($_REQUEST['page']);
// nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Vybraný materiál na nevybavených objednávkach z e-shopu</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

    do
    {
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nat = strip_tags($_REQUEST['hladaj_nat']);
$hladaj_cis = strip_tags($_REQUEST['hladaj_cis']);


if ( $hladaj_nat != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_kosprcx$kli_uzid WHERE ( xnat LIKE '%$hladaj_nat%' ) ORDER BY xcis, xdok");
if ( $hladaj_cis != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_kosprcx$kli_uzid WHERE ( xcis = '$hladaj_cis' ) ORDER BY xcis, xdok");
  }

// zobraz 
if ( $copern == 1 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_kosprcx$kli_uzid WHERE xcis < 0 ORDER BY xcis, xdok");
  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
?>

<table class="fmenu" width="100%" >

<?php
//nezobraz hladanie pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<td class="hmenu" >
<img src='../obr/hladaj.png' width=20 height=12 border=0>
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
</tr>
<FORM name="formhl1" class="hmenu" method="post" action="cisobj.php?page=1&copern=9" >
<tr>
<td class="hmenu"><input type="text" name="hladaj_cis" id="hladaj_cis" size="15" value="<?php echo $hladaj_cis;?>" />
<td class="hmenu"><input type="text" name="hladaj_nat" id="hladaj_nat" size="50" value="<?php echo $hladaj_nat;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="H¾ada" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="cisobj.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Všetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">È.materiálu<th class="hmenu">Názov materiálu
<th class="hmenu">Množstvo<th class="hmenu">Objednávka<th class="hmenu">Odberate¾
</tr>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
  if ($riadok->xcis != 0 )
       {

//ico
$sqlfi2 = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $riadok->xice ";
$fir_vysledo2 = mysql_query($sqlfi2);
if ($fir_vysledo2) 
{ 
$fir_riado2=mysql_fetch_object($fir_vysledo2); 

$ico = $fir_riado2->ico; $dic = $fir_riado2->dic; $icd = $fir_riado2->icd;
$nai = $fir_riado2->nai; $na2 = $fir_riado2->na2; $uli = $fir_riado2->uli;
$psc = $fir_riado2->psc; $mes = $fir_riado2->mes; $tel = $fir_riado2->tel; 
$fax = $fir_riado2->fax; $em1 = $fir_riado2->em1;
}


?>
<tr>
<td class="fmenu" width="10%" >
<a href="#" onClick="window.open('cis_udaje.php?copern=20&cislo_cis=<?php echo $riadok->xcis;?>', '_blank' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="Doplòujúce údaje o materiálovej, tovarovej položke" ></a>
<?php echo $riadok->xcis;?>
</td>
<td class="fmenu" width="30%" ><?php echo $riadok->xnat;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->xmno;?></td>
<td class="fmenu" width="10%" >

<a href="#" onClick="StavObj(<?php echo $riadok->xdok;?>, <?php echo $riadok->xice;?>);">
<?php echo $riadok->xdok;?></a>


</td>
<td class="fmenu" width="40%" ><?php echo $riadok->xice;?> <?php echo $nai;?> <?php echo $mes;?></td>
</tr>
<?php
       }
  }
$i = $i + 1;
   }
if ( $copern != 5 AND $copern != 8 AND $copern != 6 ) echo "</table>";
?>


<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,5,6,7,8,9
?>


<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
