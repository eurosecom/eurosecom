<HTML>
<?php
//CSV PRE UZAVIERKA MUJ v.2014
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

 $outfilexdel="../tmp/UZ_MUJ_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/UZ_MUJ_".$kli_uzid."_".$hhmmss.".csv";
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


//hlavicka a suvaha
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." WHERE prx = 1 "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//suvaha minuly rok
$sqlttps = "SELECT * FROM F$kli_vxcf"."_pos_muj2014 WHERE dok > 0 ORDER BY dok ";
$sqlps = mysql_query("$sqlttps");
$polps = mysql_num_rows($sqlps);

$ips=0;
  while ($ips <= $polps )
  {
  if (@$zaznam=mysql_data_seek($sqlps,$ips))
{
$hlavickps=mysql_fetch_object($sqlps);

$riadok=1*$hlavickps->dok;
if ( $riadok ==  1 ) { $rm01=1*$hlavickps->hod; }
if ( $riadok ==  2 ) { $rm02=1*$hlavickps->hod; }
if ( $riadok ==  3 ) { $rm03=1*$hlavickps->hod; }
if ( $riadok ==  4 ) { $rm04=1*$hlavickps->hod; }
if ( $riadok ==  5 ) { $rm05=1*$hlavickps->hod; }
if ( $riadok ==  6 ) { $rm06=1*$hlavickps->hod; }
if ( $riadok ==  7 ) { $rm07=1*$hlavickps->hod; }
if ( $riadok ==  8 ) { $rm08=1*$hlavickps->hod; }
if ( $riadok ==  9 ) { $rm09=1*$hlavickps->hod; }
if ( $riadok == 10 ) { $rm10=1*$hlavickps->hod; }
if ( $riadok == 11 ) { $rm11=1*$hlavickps->hod; }
if ( $riadok == 12 ) { $rm12=1*$hlavickps->hod; }
if ( $riadok == 13 ) { $rm13=1*$hlavickps->hod; }
if ( $riadok == 14 ) { $rm14=1*$hlavickps->hod; }
if ( $riadok == 15 ) { $rm15=1*$hlavickps->hod; }
if ( $riadok == 16 ) { $rm16=1*$hlavickps->hod; }
if ( $riadok == 17 ) { $rm17=1*$hlavickps->hod; }
if ( $riadok == 18 ) { $rm18=1*$hlavickps->hod; }
if ( $riadok == 19 ) { $rm19=1*$hlavickps->hod; }
if ( $riadok == 20 ) { $rm20=1*$hlavickps->hod; }
if ( $riadok == 21 ) { $rm21=1*$hlavickps->hod; }
if ( $riadok == 22 ) { $rm22=1*$hlavickps->hod; }
if ( $riadok == 23 ) { $rm23=1*$hlavickps->hod; }
if ( $riadok == 24 ) { $rm24=1*$hlavickps->hod; }
if ( $riadok == 25 ) { $rm25=1*$hlavickps->hod; }
if ( $riadok == 26 ) { $rm26=1*$hlavickps->hod; }
if ( $riadok == 27 ) { $rm27=1*$hlavickps->hod; }
if ( $riadok == 28 ) { $rm28=1*$hlavickps->hod; }
if ( $riadok == 29 ) { $rm29=1*$hlavickps->hod; }
if ( $riadok == 30 ) { $rm30=1*$hlavickps->hod; }
if ( $riadok == 31 ) { $rm31=1*$hlavickps->hod; }
if ( $riadok == 32 ) { $rm32=1*$hlavickps->hod; }
if ( $riadok == 33 ) { $rm33=1*$hlavickps->hod; }
if ( $riadok == 34 ) { $rm34=1*$hlavickps->hod; }
if ( $riadok == 35 ) { $rm35=1*$hlavickps->hod; }
if ( $riadok == 36 ) { $rm36=1*$hlavickps->hod; }
if ( $riadok == 37 ) { $rm37=1*$hlavickps->hod; }
if ( $riadok == 38 ) { $rm38=1*$hlavickps->hod; }
if ( $riadok == 39 ) { $rm39=1*$hlavickps->hod; }
if ( $riadok == 40 ) { $rm40=1*$hlavickps->hod; }
if ( $riadok == 41 ) { $rm41=1*$hlavickps->hod; }
if ( $riadok == 42 ) { $rm42=1*$hlavickps->hod; }
if ( $riadok == 43 ) { $rm43=1*$hlavickps->hod; }
if ( $riadok == 44 ) { $rm44=1*$hlavickps->hod; }
if ( $riadok == 45 ) { $rm45=1*$hlavickps->hod; }
}
$ips = $ips + 1;
  }


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
  $text = "\"dic\",\"sk-nace\",\"ulica\",\"popisne-cislo\",\"psc\",\"obec-nazov\",\"telefon\",\"fax\",\"email\""."\r\n"; fwrite($soubor, $text);

$dic=iconv("CP1250", "UTF-8", $fir_fdic);
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

  $text = "\"".$dic."\",\"".$sknace."\",\"".$ulica."\",\"".$popisnecislo."\",\"".$psc."\",\"".$obecnazov."\",\"".$telefon."\",\"".$fax."\",\"".$email."\""."\r\n"; fwrite($soubor, $text);


  $text = "\"suvaha-aktiva,23\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->rn01."\",\"".$rm01."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->rn02."\",\"".$rm02."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->rn03."\",\"".$rm03."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->rn04."\",\"".$rm04."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->rn05."\",\"".$rm05."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->rn06."\",\"".$rm06."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->rn07."\",\"".$rm07."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->rn08."\",\"".$rm08."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->rn09."\",\"".$rm09."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R10\",\"".$hlavicka->rn10."\",\"".$rm10."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R11\",\"".$hlavicka->rn11."\",\"".$rm11."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R12\",\"".$hlavicka->rn12."\",\"".$rm12."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R13\",\"".$hlavicka->rn13."\",\"".$rm13."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R14\",\"".$hlavicka->rn14."\",\"".$rm14."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R15\",\"".$hlavicka->rn15."\",\"".$rm15."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R16\",\"".$hlavicka->rn16."\",\"".$rm16."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R17\",\"".$hlavicka->rn17."\",\"".$rm17."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R18\",\"".$hlavicka->rn18."\",\"".$rm18."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R19\",\"".$hlavicka->rn19."\",\"".$rm19."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R20\",\"".$hlavicka->rn20."\",\"".$rm20."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R21\",\"".$hlavicka->rn21."\",\"".$rm21."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->rn22."\",\"".$rm22."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->rn23."\",\"".$rm23."\""."\r\n"; fwrite($soubor, $text);



  $text = "\"suvaha-pasiva,22\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R24\",\"".$hlavicka->rn24."\",\"".$rm24."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->rn25."\",\"".$rm25."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->rn26."\",\"".$rm26."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->rn27."\",\"".$rm27."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R28\",\"".$hlavicka->rn28."\",\"".$rm28."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R29\",\"".$hlavicka->rn29."\",\"".$rm29."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R20\",\"".$hlavicka->rn20."\",\"".$rm20."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R21\",\"".$hlavicka->rn21."\",\"".$rm21."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->rn22."\",\"".$rm22."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->rn23."\",\"".$rm23."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R24\",\"".$hlavicka->rn24."\",\"".$rm24."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->rn25."\",\"".$rm25."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->rn26."\",\"".$rm26."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->rn27."\",\"".$rm27."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R28\",\"".$hlavicka->rn28."\",\"".$rm28."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R29\",\"".$hlavicka->rn29."\",\"".$rm29."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R30\",\"".$hlavicka->rn30."\",\"".$rm30."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R31\",\"".$hlavicka->rn31."\",\"".$rm31."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R32\",\"".$hlavicka->rn32."\",\"".$rm32."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R33\",\"".$hlavicka->rn33."\",\"".$rm33."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R34\",\"".$hlavicka->rn34."\",\"".$rm34."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R35\",\"".$hlavicka->rn35."\",\"".$rm35."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R36\",\"".$hlavicka->rn36."\",\"".$rm36."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R37\",\"".$hlavicka->rn37."\",\"".$rm37."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R38\",\"".$hlavicka->rn38."\",\"".$rm38."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R39\",\"".$hlavicka->rn39."\",\"".$rm39."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R40\",\"".$hlavicka->rn40."\",\"".$rm40."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R41\",\"".$hlavicka->rn41."\",\"".$rm41."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R42\",\"".$hlavicka->rn42."\",\"".$rm42."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R43\",\"".$hlavicka->rn43."\",\"".$rm43."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R44\",\"".$hlavicka->rn44."\",\"".$rm44."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R45\",\"".$hlavicka->rn45."\",\"".$rm45."\""."\r\n"; fwrite($soubor, $text);


     }
//koniec ak j=0

}
$i = $i + 1;
$j = $j + 1;
  }
//koniec hlavicka  a suvaha

//vzas
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvyk1000ziss".$kli_uzid." WHERE prx = 1 ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//poc.stav vzas
$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10="";
$rm11=""; $rm12=""; $rm13=""; $rm14=""; $rm15=""; $rm16=""; $rm17=""; $rm18=""; $rm19=""; $rm20="";
$rm21=""; $rm22=""; $rm23=""; $rm24=""; $rm25=""; $rm26=""; $rm27=""; $rm28=""; $rm29=""; $rm30="";
$rm31=""; $rm32=""; $rm33=""; $rm34=""; $rm35=""; $rm36=""; $rm37=""; $rm38="";

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_pov_muj2014 WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
$polpv = mysql_num_rows($sqlpv);

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);
$riadok=1*$hlavickpv->dok;

if ( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if ( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if ( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if ( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if ( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if ( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if ( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if ( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if ( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if ( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if ( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if ( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if ( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if ( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if ( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if ( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if ( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if ( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if ( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if ( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if ( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }
if ( $riadok == 22 ) { $rm22=1*$hlavickpv->hod; }
if ( $riadok == 23 ) { $rm23=1*$hlavickpv->hod; }
if ( $riadok == 24 ) { $rm24=1*$hlavickpv->hod; }
if ( $riadok == 25 ) { $rm25=1*$hlavickpv->hod; }
if ( $riadok == 26 ) { $rm26=1*$hlavickpv->hod; }
if ( $riadok == 27 ) { $rm27=1*$hlavickpv->hod; }
if ( $riadok == 28 ) { $rm28=1*$hlavickpv->hod; }
if ( $riadok == 29 ) { $rm29=1*$hlavickpv->hod; }
if ( $riadok == 30 ) { $rm30=1*$hlavickpv->hod; }
if ( $riadok == 31 ) { $rm31=1*$hlavickpv->hod; }
if ( $riadok == 32 ) { $rm32=1*$hlavickpv->hod; }
if ( $riadok == 33 ) { $rm33=1*$hlavickpv->hod; }
if ( $riadok == 34 ) { $rm34=1*$hlavickpv->hod; }
if ( $riadok == 35 ) { $rm35=1*$hlavickpv->hod; }
if ( $riadok == 36 ) { $rm36=1*$hlavickpv->hod; }
if ( $riadok == 37 ) { $rm37=1*$hlavickpv->hod; }
if ( $riadok == 38 ) { $rm38=1*$hlavickpv->hod; }

}
$ipv = $ipv + 1;
  }



$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {

  $text = "\"vzas,38\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$rm01."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->r02."\",\"".$rm02."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->r03."\",\"".$rm03."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->r04."\",\"".$rm04."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->r05."\",\"".$rm05."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->r06."\",\"".$rm06."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->r07."\",\"".$rm07."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->r08."\",\"".$rm08."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->r09."\",\"".$rm09."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R10\",\"".$hlavicka->r10."\",\"".$rm10."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R11\",\"".$hlavicka->r11."\",\"".$rm11."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R12\",\"".$hlavicka->r12."\",\"".$rm12."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R13\",\"".$hlavicka->r13."\",\"".$rm13."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R14\",\"".$hlavicka->r14."\",\"".$rm14."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R15\",\"".$hlavicka->r15."\",\"".$rm15."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R16\",\"".$hlavicka->r16."\",\"".$rm16."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R17\",\"".$hlavicka->r17."\",\"".$rm17."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R18\",\"".$hlavicka->r18."\",\"".$rm18."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R19\",\"".$hlavicka->r19."\",\"".$rm19."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R20\",\"".$hlavicka->r10."\",\"".$rm20."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R21\",\"".$hlavicka->r11."\",\"".$rm21."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->r12."\",\"".$rm22."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->r13."\",\"".$rm23."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R24\",\"".$hlavicka->r14."\",\"".$rm24."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->r15."\",\"".$rm25."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->r16."\",\"".$rm26."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->r17."\",\"".$rm27."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R28\",\"".$hlavicka->r18."\",\"".$rm28."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R29\",\"".$hlavicka->r19."\",\"".$rm29."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R30\",\"".$hlavicka->r10."\",\"".$rm30."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R31\",\"".$hlavicka->r11."\",\"".$rm31."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R32\",\"".$hlavicka->r12."\",\"".$rm32."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R33\",\"".$hlavicka->r13."\",\"".$rm33."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R34\",\"".$hlavicka->r14."\",\"".$rm34."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R35\",\"".$hlavicka->r15."\",\"".$rm35."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R36\",\"".$hlavicka->r16."\",\"".$rm36."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R37\",\"".$hlavicka->r17."\",\"".$rm37."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R38\",\"".$hlavicka->r38."\",\"".$rm38."\""."\r\n"; fwrite($soubor, $text);



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