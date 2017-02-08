<HTML>
<?php
//CSV PRE UZAVIERKA NO JU v.2013
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

 $outfilexdel="../tmp/UZ_NO_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/UZ_NO_".$kli_uzid."_".$hhmmss.".csv";
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
<title>EuroSecom - UZ MUJ csv export</title>
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
   <td class="header">Uzávierka MUJ / Export CSV <span class="subheader"></span></td>
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


//hlavicka a prijmy a vydavky
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid."  WHERE prx = 1  ";  

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


  $text = "\"vopav-prijmy,16\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rpc01."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->r02."\",\"".$hlavicka->rpc02."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->r03."\",\"".$hlavicka->rpc03."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->r04."\",\"".$hlavicka->rpc04."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->r05."\",\"".$hlavicka->rpc05."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->r06."\",\"".$hlavicka->rpc06."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->r07."\",\"".$hlavicka->rpc07."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->r08."\",\"".$hlavicka->rpc08."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->r09."\",\"".$hlavicka->rpc09."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R10\",\"".$hlavicka->r10."\",\"".$hlavicka->rpc10."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R11\",\"".$hlavicka->r11."\",\"".$hlavicka->rpc11."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R12\",\"".$hlavicka->r12."\",\"".$hlavicka->rpc12."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R13\",\"".$hlavicka->r13."\",\"".$hlavicka->rpc13."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R14\",\"".$hlavicka->r14."\",\"".$hlavicka->rpc14."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R15\",\"".$hlavicka->r15."\",\"".$hlavicka->rpc15."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R16\",\"".$hlavicka->r16."\",\"".$hlavicka->rpc16."\""."\r\n"; fwrite($soubor, $text);



  $text = "\"vopav-vydavky,11\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R17\",\"".$hlavicka->r17."\",\"".$hlavicka->rpc17."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R18\",\"".$hlavicka->r18."\",\"".$hlavicka->rpc18."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R19\",\"".$hlavicka->r19."\",\"".$hlavicka->rpc19."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R20\",\"".$hlavicka->r20."\",\"".$hlavicka->rpc20."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R21\",\"".$hlavicka->r21."\",\"".$hlavicka->rpc21."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->r22."\",\"".$hlavicka->rpc22."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->r23."\",\"".$hlavicka->rpc23."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R24\",\"".$hlavicka->r24."\",\"".$hlavicka->rpc24."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->r25."\",\"".$hlavicka->rpc25."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->r26."\",\"".$hlavicka->rpc26."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->r27."\",\"".$hlavicka->rpc27."\""."\r\n"; fwrite($soubor, $text);


     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec hlavicka  a prijmy a vydavky

//majetok a zavazky
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvmajzavs".$kli_uzid." ".
" LEFT JOIN F$kli_vxcf"."_uctpocmajzavnoju_stl".
" ON F$kli_vxcf"."_prcvmajzavs$kli_uzid.prx=F$kli_vxcf"."_uctpocmajzavnoju_stl.fic".
" WHERE prx = 1 "."";
//echo $sqltt;

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

  $text = "\"vomaz-majetok,11\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rm01."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->r02."\",\"".$hlavicka->rm02."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->r03."\",\"".$hlavicka->rm03."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->r04."\",\"".$hlavicka->rm04."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->r05."\",\"".$hlavicka->rm05."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->r06."\",\"".$hlavicka->rm06."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->r07."\",\"".$hlavicka->rm07."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->r08."\",\"".$hlavicka->rm08."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->r09."\",\"".$hlavicka->rm09."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R10\",\"".$hlavicka->r10."\",\"".$hlavicka->rm10."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R11\",\"".$hlavicka->r11."\",\"".$hlavicka->rm11."\""."\r\n"; fwrite($soubor, $text);



  $text = "\"vomaz-zavazky,6\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R12\",\"".$hlavicka->r12."\",\"".$hlavicka->rm12."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R13\",\"".$hlavicka->r13."\",\"".$hlavicka->rm13."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R14\",\"".$hlavicka->r14."\",\"".$hlavicka->rm14."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R15\",\"".$hlavicka->r15."\",\"".$hlavicka->rm15."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R16\",\"".$hlavicka->r16."\",\"".$hlavicka->rm16."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R17\",\"".$hlavicka->r17."\",\"".$hlavicka->rm17."\""."\r\n"; fwrite($soubor, $text);



     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec majetok a zavazky




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