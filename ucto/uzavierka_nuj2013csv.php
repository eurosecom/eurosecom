<HTML>
<?php
//CSV PRE UZAVIERKA NUJ v.2013
do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$zdrd = $_REQUEST['zdrd'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];
$h_arch = $_REQUEST['h_arch'];

$chyby = 1*$_REQUEST['chyby'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);



//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


$hhmmss = Date ("i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/UZ_NUJ_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/UZ_NUJ_".$kli_uzid."_".$hhmmss.".csv";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$copern=10;
$zarchivu=1;
$elsubor=2;

//FO - priezvisko,meno,tituly a trvaly pobyt z ufirdalsie
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok )
     {
$riadok=mysql_fetch_object($vysledok);
$dprie = $riadok->dprie;
$dmeno = $riadok->dmeno;
$dtitl = $riadok->dtitl;
$dtitz = $riadok->dtitz;
$duli = $riadok->duli;
$dcdm = $riadok->dcdm;
$dpsc = $riadok->dpsc;
$dmes = $riadok->dmes;
$dstat = $riadok->dstat;
//$dtel = $riadok->dtel;
     }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
<link rel="stylesheet" href="../css/reset.css">
<link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - UZ NUJ csv export</title>
<style>
#content {
  box-sizing: border-box;
  background-color: white;
  padding: 30px 25px;
   -webkit-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  -moz-box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
  box-shadow: 1px 1px 6px 0px rgba(0, 0, 0, 0.298);
}
#content > p {
  line-height: 22px;
  font-size: 14px;
}
#content > p > a {
  color: #00e;
}
#content > p > a:hover {
  text-decoration: underline;
}
#upozornenie > h2 {
  line-height: 20px;
  margin-top: 25px;
  margin-bottom: 10px;
  overflow: auto;
}
#upozornenie > h2 > strong {
  font-size: 16px;
  font-weight: bold;
}
#upozornenie > ul > li {
  line-height: 18px;
  margin: 10px 0;
  font-size: 13px;
}
.red {
  border-left: 4px solid #f22613;
  text-indent: 8px;
}
.orange {
  border-left: 4px solid #f89406;
  text-indent: 8px;
}
dl.legend-area {
  height: 14px;
  line-height: 14px;
  font-size: 11px;
  position: relative;
  top: 5px;
}
dl.legend-area > dt {
  width:10px;
  height:10px;
  margin: 2px 5px 0 12px;
}
.box-red {
  background-color: #f22613;
}
.box-orange {
  background-color: #f89406;
}
.header-section {
  padding-top: 5px;
}
</style>
</HEAD>
<BODY>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Uzávierka NUJ / Export CSV <span class="subheader"></span></td>
   <td></td>
  </tr>
 </table>
</div>
<?php
//XML SUBOR elsubor=2
if ( $copern == 10 AND $elsubor == 2  )
     {
//prva strana
$nazsub = $outfilex; 
$soubor = fopen("$nazsub", "a+");
?>

<?php
//rok2016
$sqlt = <<<mzdprc
(

);
mzdprc;


//hlavicka a suvaha
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvahano_stl".
" ON F$kli_vxcf"."_prcsuvahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvahano_stl.fic".
" WHERE prx = 1 ".""; 


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {
  $text = "\"hlavicka,1\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"ico\",\"rok\",\"mesiac\""."\r\n"; fwrite($soubor, $text);
  $text = "\"".$fir_fico."\",\"".$kli_vrok."\",\"".$kli_vmes."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"uctovna-zavierka,1\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"typ-uz\",\"zaciatok-bezneho-obdobia\",\"koniec-bezneho-obdobia\",\"zaciatok-predch-obdobia\",\"koniec-predch-obdobia\",\"stav-uz\",\"datum-zostavenia\",\"datum-schvalenia\""."\r\n"; fwrite($soubor, $text);

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];

$riadnamimoriadna="R";
if ( $h_drp == 2 ) { $riadnamimoriadna="M"; }
$zossch="Z";
if ( $h_sch != '' )
{
$zossch="S"; 
}

$datzos=$h_zos;
$pole = explode(".", $datzos);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
$datzos=$rok.$mesiac.$den;
if ( $datzos =='00000000' ) { $datzos=""; }

$datsch=$h_sch;
$pole = explode(".", $datsch);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
$datsch=$rok.$mesiac.$den;
if ( $datsch =='00000000' ) { $datsch=""; }


//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.12.".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);
     }
  }

$zacb=$datbodsk;
$pole = explode(".", $zacb);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
$zacb=$rok.$mesiac.$den;
if ( $zacb =='00000000' ) { $zacb=""; }

$konb=$datbdosk;
$pole = explode(".", $konb);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
$konb=$rok.$mesiac.$den;
if ( $konb =='00000000' ) { $konb=""; }

$zacp=$datmodsk;
$pole = explode(".", $zacp);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
$zacp=$rok.$mesiac.$den;
if ( $zacp =='00000000' ) { $zacp=""; }

$konp=$datmdosk;
$pole = explode(".", $konp);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];
$konp=$rok.$mesiac.$den;
if ( $konp =='00000000' ) { $konp=""; }

  $text = "\"".$riadnamimoriadna."\",\"".$zacb."\",\"".$konb."\",\"".$zacp."\",\"".$konp."\",\"".$zossch."\",\"".$datzos."\",\"".$datsch."\""."\r\n"; fwrite($soubor, $text);


  $text = "\"uctovna-jednotka,1\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"dic\",\"sid\",\"sk-nace\",\"ulica\",\"popisne-cislo\",\"psc\",\"obec-nazov\",\"telefon\",\"fax\",\"email\""."\r\n"; fwrite($soubor, $text);

$dic=iconv("CP1250", "UTF-8", $fir_fdic);
$sid="";
$sknace=trim($fir_sknace);
$sknace = str_replace(".","",$sknace);
$ulica=trim(iconv("CP1250", "UTF-8", $fir_fuli));
$popisnecislo=iconv("CP1250", "UTF-8", $fir_fcdm);
$sknace = trim(str_replace(".","",$fir_sknace));
$psc = trim(str_replace(" ","",$fir_fpsc));
$obecnazov=iconv("CP1250", "UTF-8", $fir_fmes);
$telefon = trim(str_replace(" ","",$fir_ftel));
$telefon = trim(str_replace("/","",$telefon));
$fax = trim(str_replace(" ","",$fir_ffax));
$fax = trim(str_replace("/","",$fax));
$email = iconv("CP1250", "UTF-8", $fir_fema);

  $text = "\"".$dic."\",\"".$sid."\",\"".$sknace."\",\"".$ulica."\",\"".$popisnecislo."\",\"".$psc."\",\"".$obecnazov."\",\"".$telefon."\",\"".$fax."\",\"".$email."\""."\r\n"; fwrite($soubor, $text);


  $text = "\"suvaha-aktiva,60\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rk01."\",\"".$hlavicka->rn01."\",\"".$hlavicka->rm01."\""."\r\n"; fwrite($soubor, $text);

//doplnit az po riadok 60

  $text = "\"R60\",\"".$hlavicka->r60."\",\"".$hlavicka->rk60."\",\"".$hlavicka->rn60."\",\"".$hlavicka->rm60."\""."\r\n"; fwrite($soubor, $text);



  $text = "\"suvaha-pasiva,44\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S5\",\"S6\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R61\",\"".$hlavicka->r61."\",\"".$hlavicka->rm61."\""."\r\n"; fwrite($soubor, $text);

//doplnit az po riadok 104

  $text = "\"R104\",\"".$hlavicka->r104."\",\"".$hlavicka->rm104."\""."\r\n"; fwrite($soubor, $text);


     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec hlavicka  a suvaha

//vzas
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocvziskovno_stl".
" ON F$kli_vxcf"."_prcvykziss$kli_uzid.prx=F$kli_vxcf"."_uctpocvziskovno_stl.fic".
" WHERE prx = 1 "."";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {

  $text = "\"vzas-naklady,38\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rpc01."\",\"".$hlavicka->rsp01."\",\"".$hlavicka->rm01."\""."\r\n"; fwrite($soubor, $text);

//doplnit az po riadok 38

  $text = "\"R38\",\"".$hlavicka->r38."\",\"".$hlavicka->rpc38."\",\"".$hlavicka->rsp38."\",\"".$hlavicka->rm38."\""."\r\n"; fwrite($soubor, $text);



  $text = "\"vzas-vynosy,40\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R39\",\"".$hlavicka->r39."\",\"".$hlavicka->rpc39."\",\"".$hlavicka->rsp39."\",\"".$hlavicka->rm39."\""."\r\n"; fwrite($soubor, $text);

//doplnit az po riadok 78

  $text = "\"R78\",\"".$hlavicka->r78."\",\"".$hlavicka->rpc78."\",\"".$hlavicka->rsp78."\",\"".$hlavicka->rm78."\""."\r\n"; fwrite($soubor, $text);




     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec vzas




fclose($soubor);
?>
<div id="content">
<?php if ( $elsubor == 2 ) { ?>
<p>Stiahnite si nižšie uvedený súbor <strong>.csv</strong> do Vášho poèítaèa a naèítajte ho na
<a href="https://www.rissam.sk/vpn/rissam.html" target="_blank" title="Stránka RIS pre Samosprávu">RIS pre Samosprávu</a> :
</p>
<p>
<a href="<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a>
</p>
<?php                      } ?>

<?php
/////////////////////////////////////////////////////////////////////UPOZORNENIE
$upozorni1=0; $upozorni2=0; $upozorni10=0; $upozorni11=0; $upozorni12=0;
?>
<div id="upozornenie" style="display:none;">
<h2>
<strong class="toleft">Upozornenie</strong>
<dl class="toright legend-area">
 <dt class="toleft box-red"></dt><dd class="toleft">kritické</dd>
 <dt class="toleft box-orange"></dt><dd class="toleft">logické</dd>
</dl>
</h2>
<ul id="alertpage1" style="display:none;">
<li class="header-section">STRANA 1</li>
<li class="red">
<?php if ( $hlavicka->fdic == "0" AND $hlavicka->dar == '0000-00-00' )
{
$upozorni1=1;
echo "Nie je vyplnené <strong>DIÈ</strong> daòovníka.";
}
?>
</li>

</ul>

</div> <!-- #upozornenie -->

<script type="text/javascript">
<?php
if ( $upozorni1 == 1 OR $upozorni2 == 1 OR $upozorni10 == 1 OR $upozorni11 == 1 OR $upozorni12 == 1 OR $upozorni14 == 1 )
     { echo "upozornenie.style.display='block';"; }
if ( $upozorni1 == 1 ) { echo "alertpage1.style.display='block';"; } 
if ( $upozorni2 == 1 ) { echo "alertpage2.style.display='block';"; } 
if ( $upozorni10 == 1 ) { echo "alertpage10.style.display='block';"; }
if ( $upozorni11 == 1 ) { echo "alertpage11.style.display='block';"; }
if ( $upozorni12 == 1 ) { echo "alertpage12.style.display='block';"; }
if ( $upozorni14 == 1 ) { echo "alertpage14.style.display='block';"; }
?>
</script>

</div> <!-- #content -->
<?php
//mysql_free_result($vysledok);
     }
//koniec XML SUBOR
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>