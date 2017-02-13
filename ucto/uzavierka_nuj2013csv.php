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
   <td class="header">Uz·vierka NUJ / Export CSV <span class="subheader"></span></td>
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


//predch obdobie suvaha
$rm01="0"; $rm02="0"; $rm03="0"; $rm04="0"; $rm05="0"; $rm06="0"; $rm07="0"; $rm08="0"; $rm09="0"; $rm10="0";
$rm11="0"; $rm12="0"; $rm13="0"; $rm14="0"; $rm15="0"; $rm16="0"; $rm17="0"; $rm18="0"; $rm19="0"; $rm20="0";
$rm21="0"; $rm22="0"; $rm23="0"; $rm24="0"; $rm25="0"; $rm26="0"; $rm27="0"; $rm28="0"; $rm29="0"; $rm30="0";
$rm31="0"; $rm32="0"; $rm33="0"; $rm34="0"; $rm35="0"; $rm36="0"; $rm37="0"; $rm38="0"; $rm39="0"; $rm40="0";
$rm41="0"; $rm42="0"; $rm43="0"; $rm44="0"; $rm45="0"; $rm46="0"; $rm47="0"; $rm48="0"; $rm49="0"; $rm50="0";
$rm51="0"; $rm52="0"; $rm53="0"; $rm54="0"; $rm55="0"; $rm56="0"; $rm57="0"; $rm58="0"; $rm59="0"; $rm60="0";
$rm61="0"; $rm62="0"; $rm63="0"; $rm64="0"; $rm65="0"; $rm66="0"; $rm67="0"; $rm68="0"; $rm69="0"; $rm70="0";
$rm71="0"; $rm72="0"; $rm73="0"; $rm74="0"; $rm75="0"; $rm76="0"; $rm77="0"; $rm78="0"; $rm79="0"; $rm80="0";
$rm81="0"; $rm82="0"; $rm83="0"; $rm84="0"; $rm85="0"; $rm86="0"; $rm87="0"; $rm88="0"; $rm89="0"; $rm90="0";
$rm91="0"; $rm92="0"; $rm93="0"; $rm94="0"; $rm95="0"; $rm96="0"; $rm97="0"; $rm98="0"; $rm99="0"; $rm100="0";
$rm101="0"; $rm102="0"; $rm103="0"; $rm104="0"; 


$sqlttps = "SELECT * FROM F$kli_vxcf"."_uctpocsuvahano WHERE dok > 0 ORDER BY dok ";
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
if ( $riadok == 46 ) { $rm46=1*$hlavickps->hod; }
if ( $riadok == 47 ) { $rm47=1*$hlavickps->hod; }
if ( $riadok == 48 ) { $rm48=1*$hlavickps->hod; }
if ( $riadok == 49 ) { $rm49=1*$hlavickps->hod; }

if ( $riadok == 50 ) { $rm50=1*$hlavickps->hod; }
if ( $riadok == 51 ) { $rm51=1*$hlavickps->hod; }
if ( $riadok == 52 ) { $rm52=1*$hlavickps->hod; }
if ( $riadok == 53 ) { $rm53=1*$hlavickps->hod; }
if ( $riadok == 54 ) { $rm54=1*$hlavickps->hod; }
if ( $riadok == 55 ) { $rm55=1*$hlavickps->hod; }
if ( $riadok == 56 ) { $rm56=1*$hlavickps->hod; }
if ( $riadok == 57 ) { $rm57=1*$hlavickps->hod; }
if ( $riadok == 58 ) { $rm58=1*$hlavickps->hod; }
if ( $riadok == 59 ) { $rm59=1*$hlavickps->hod; }

if ( $riadok == 60 ) { $rm60=1*$hlavickps->hod; }
if ( $riadok == 61 ) { $rm61=1*$hlavickps->hod; }
if ( $riadok == 62 ) { $rm62=1*$hlavickps->hod; }
if ( $riadok == 63 ) { $rm63=1*$hlavickps->hod; }
if ( $riadok == 64 ) { $rm64=1*$hlavickps->hod; }
if ( $riadok == 65 ) { $rm65=1*$hlavickps->hod; }
if ( $riadok == 66 ) { $rm66=1*$hlavickps->hod; }
if ( $riadok == 67 ) { $rm67=1*$hlavickps->hod; }
if ( $riadok == 68 ) { $rm68=1*$hlavickps->hod; }
if ( $riadok == 69 ) { $rm69=1*$hlavickps->hod; }

if ( $riadok == 70 ) { $rm70=1*$hlavickps->hod; }
if ( $riadok == 71 ) { $rm71=1*$hlavickps->hod; }
if ( $riadok == 72 ) { $rm72=1*$hlavickps->hod; }
if ( $riadok == 73 ) { $rm73=1*$hlavickps->hod; }
if ( $riadok == 74 ) { $rm74=1*$hlavickps->hod; }
if ( $riadok == 75 ) { $rm75=1*$hlavickps->hod; }
if ( $riadok == 76 ) { $rm76=1*$hlavickps->hod; }
if ( $riadok == 77 ) { $rm77=1*$hlavickps->hod; }
if ( $riadok == 78 ) { $rm78=1*$hlavickps->hod; }
if ( $riadok == 79 ) { $rm79=1*$hlavickps->hod; }

if ( $riadok == 80 ) { $rm80=1*$hlavickps->hod; }
if ( $riadok == 81 ) { $rm81=1*$hlavickps->hod; }
if ( $riadok == 82 ) { $rm82=1*$hlavickps->hod; }
if ( $riadok == 83 ) { $rm83=1*$hlavickps->hod; }
if ( $riadok == 84 ) { $rm84=1*$hlavickps->hod; }
if ( $riadok == 85 ) { $rm85=1*$hlavickps->hod; }
if ( $riadok == 86 ) { $rm86=1*$hlavickps->hod; }
if ( $riadok == 87 ) { $rm87=1*$hlavickps->hod; }
if ( $riadok == 88 ) { $rm88=1*$hlavickps->hod; }
if ( $riadok == 89 ) { $rm89=1*$hlavickps->hod; }

if ( $riadok == 90 ) { $rm90=1*$hlavickps->hod; }
if ( $riadok == 91 ) { $rm91=1*$hlavickps->hod; }
if ( $riadok == 92 ) { $rm92=1*$hlavickps->hod; }
if ( $riadok == 93 ) { $rm93=1*$hlavickps->hod; }
if ( $riadok == 94 ) { $rm94=1*$hlavickps->hod; }
if ( $riadok == 95 ) { $rm95=1*$hlavickps->hod; }
if ( $riadok == 96 ) { $rm96=1*$hlavickps->hod; }
if ( $riadok == 97 ) { $rm97=1*$hlavickps->hod; }
if ( $riadok == 98 ) { $rm98=1*$hlavickps->hod; }
if ( $riadok == 99 ) { $rm99=1*$hlavickps->hod; }

if ( $riadok == 100 ) { $rm100=1*$hlavickps->hod; }
if ( $riadok == 101 ) { $rm101=1*$hlavickps->hod; }
if ( $riadok == 102 ) { $rm102=1*$hlavickps->hod; }
if ( $riadok == 103 ) { $rm103=1*$hlavickps->hod; }
if ( $riadok == 104 ) { $rm104=1*$hlavickps->hod; }


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
$email = iconv("CP1250", "UTF-8", $fir_fem1);

  $text = "\"".$dic."\",\"".$sid."\",\"".$sknace."\",\"".$ulica."\",\"".$popisnecislo."\",\"".$psc."\",\"".$obecnazov."\",\"".$telefon."\",\"".$fax."\",\"".$email."\""."\r\n"; fwrite($soubor, $text);


  $text = "\"suvaha-aktiva,60\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rk01."\",\"".$hlavicka->rn01."\",\"".$rm01."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->r02."\",\"".$hlavicka->rk02."\",\"".$hlavicka->rn02."\",\"".$rm02."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->r03."\",\"".$hlavicka->rk03."\",\"".$hlavicka->rn03."\",\"".$rm03."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->r04."\",\"".$hlavicka->rk04."\",\"".$hlavicka->rn04."\",\"".$rm04."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->r05."\",\"".$hlavicka->rk05."\",\"".$hlavicka->rn05."\",\"".$rm05."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->r06."\",\"".$hlavicka->rk06."\",\"".$hlavicka->rn06."\",\"".$rm06."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->r07."\",\"".$hlavicka->rk07."\",\"".$hlavicka->rn07."\",\"".$rm07."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->r08."\",\"".$hlavicka->rk08."\",\"".$hlavicka->rn08."\",\"".$rm08."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->r09."\",\"".$hlavicka->rk09."\",\"".$hlavicka->rn09."\",\"".$rm09."\""."\r\n"; fwrite($soubor, $text);

//na riadku r10,r11 je krizik v korekcii tzn. nevyplna sa, rovnako 45 az 47 a 52 az 54
  $text = "\"R10\",\"".$hlavicka->r10."\",,\"".$hlavicka->rn10."\",\"".$rm10."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R11\",\"".$hlavicka->r11."\",,\"".$hlavicka->rn11."\",\"".$rm11."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R12\",\"".$hlavicka->r12."\",\"".$hlavicka->rk12."\",\"".$hlavicka->rn12."\",\"".$rm12."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R13\",\"".$hlavicka->r13."\",\"".$hlavicka->rk13."\",\"".$hlavicka->rn13."\",\"".$rm13."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R14\",\"".$hlavicka->r14."\",\"".$hlavicka->rk14."\",\"".$hlavicka->rn14."\",\"".$rm14."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R15\",\"".$hlavicka->r15."\",\"".$hlavicka->rk15."\",\"".$hlavicka->rn15."\",\"".$rm15."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R16\",\"".$hlavicka->r16."\",\"".$hlavicka->rk16."\",\"".$hlavicka->rn16."\",\"".$rm16."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R17\",\"".$hlavicka->r17."\",\"".$hlavicka->rk17."\",\"".$hlavicka->rn17."\",\"".$rm17."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R18\",\"".$hlavicka->r18."\",\"".$hlavicka->rk18."\",\"".$hlavicka->rn18."\",\"".$rm18."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R19\",\"".$hlavicka->r19."\",\"".$hlavicka->rk19."\",\"".$hlavicka->rn19."\",\"".$rm19."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R20\",\"".$hlavicka->r20."\",\"".$hlavicka->rk20."\",\"".$hlavicka->rn20."\",\"".$rm20."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R21\",\"".$hlavicka->r21."\",\"".$hlavicka->rk21."\",\"".$hlavicka->rn21."\",\"".$rm21."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->r22."\",\"".$hlavicka->rk22."\",\"".$hlavicka->rn22."\",\"".$rm22."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->r23."\",\"".$hlavicka->rk23."\",\"".$hlavicka->rn23."\",\"".$rm23."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R24\",\"".$hlavicka->r24."\",\"".$hlavicka->rk24."\",\"".$hlavicka->rn24."\",\"".$rm24."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->r25."\",\"".$hlavicka->rk25."\",\"".$hlavicka->rn25."\",\"".$rm25."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->r26."\",\"".$hlavicka->rk26."\",\"".$hlavicka->rn26."\",\"".$rm26."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->r27."\",\"".$hlavicka->rk27."\",\"".$hlavicka->rn27."\",\"".$rm27."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R28\",\"".$hlavicka->r28."\",\"".$hlavicka->rk28."\",\"".$hlavicka->rn28."\",\"".$rm28."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R29\",\"".$hlavicka->r29."\",\"".$hlavicka->rk29."\",\"".$hlavicka->rn29."\",\"".$rm29."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R30\",\"".$hlavicka->r30."\",\"".$hlavicka->rk30."\",\"".$hlavicka->rn30."\",\"".$rm30."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R31\",\"".$hlavicka->r31."\",\"".$hlavicka->rk31."\",\"".$hlavicka->rn31."\",\"".$rm31."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R32\",\"".$hlavicka->r32."\",\"".$hlavicka->rk32."\",\"".$hlavicka->rn32."\",\"".$rm32."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R33\",\"".$hlavicka->r33."\",\"".$hlavicka->rk33."\",\"".$hlavicka->rn33."\",\"".$rm33."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R34\",\"".$hlavicka->r34."\",\"".$hlavicka->rk34."\",\"".$hlavicka->rn34."\",\"".$rm34."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R35\",\"".$hlavicka->r35."\",\"".$hlavicka->rk35."\",\"".$hlavicka->rn35."\",\"".$rm35."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R36\",\"".$hlavicka->r36."\",\"".$hlavicka->rk36."\",\"".$hlavicka->rn36."\",\"".$rm36."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R37\",\"".$hlavicka->r37."\",\"".$hlavicka->rk37."\",\"".$hlavicka->rn37."\",\"".$rm37."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R38\",\"".$hlavicka->r38."\",\"".$hlavicka->rk38."\",\"".$hlavicka->rn38."\",\"".$rm38."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R39\",\"".$hlavicka->r39."\",\"".$hlavicka->rk39."\",\"".$hlavicka->rn39."\",\"".$rm39."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R40\",\"".$hlavicka->r40."\",\"".$hlavicka->rk40."\",\"".$hlavicka->rn40."\",\"".$rm40."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R41\",\"".$hlavicka->r41."\",\"".$hlavicka->rk41."\",\"".$hlavicka->rn41."\",\"".$rm41."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R42\",\"".$hlavicka->r42."\",\"".$hlavicka->rk42."\",\"".$hlavicka->rn42."\",\"".$rm42."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R43\",\"".$hlavicka->r43."\",\"".$hlavicka->rk43."\",\"".$hlavicka->rn43."\",\"".$rm43."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R44\",\"".$hlavicka->r44."\",\"".$hlavicka->rk44."\",\"".$hlavicka->rn44."\",\"".$rm44."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R45\",\"".$hlavicka->r45."\",,\"".$hlavicka->rn45."\",\"".$rm45."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R46\",\"".$hlavicka->r46."\",,\"".$hlavicka->rn46."\",\"".$rm46."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R47\",\"".$hlavicka->r47."\",,\"".$hlavicka->rn47."\",\"".$rm47."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R48\",\"".$hlavicka->r48."\",\"".$hlavicka->rk48."\",\"".$hlavicka->rn48."\",\"".$rm48."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R49\",\"".$hlavicka->r49."\",\"".$hlavicka->rk49."\",\"".$hlavicka->rn49."\",\"".$rm49."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R50\",\"".$hlavicka->r50."\",\"".$hlavicka->rk50."\",\"".$hlavicka->rn50."\",\"".$rm50."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R51\",\"".$hlavicka->r51."\",\"".$hlavicka->rk51."\",\"".$hlavicka->rn51."\",\"".$rm51."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R52\",\"".$hlavicka->r52."\",,\"".$hlavicka->rn52."\",\"".$rm52."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R53\",\"".$hlavicka->r53."\",,\"".$hlavicka->rn53."\",\"".$rm53."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R54\",\"".$hlavicka->r54."\",,\"".$hlavicka->rn54."\",\"".$rm54."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R55\",\"".$hlavicka->r55."\",\"".$hlavicka->rk55."\",\"".$hlavicka->rn55."\",\"".$rm55."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R56\",\"".$hlavicka->r56."\",\"".$hlavicka->rk56."\",\"".$hlavicka->rn56."\",\"".$rm56."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R57\",\"".$hlavicka->r57."\",\"".$hlavicka->rk57."\",\"".$hlavicka->rn57."\",\"".$rm57."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R58\",\"".$hlavicka->r58."\",\"".$hlavicka->rk58."\",\"".$hlavicka->rn58."\",\"".$rm58."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R59\",\"".$hlavicka->r59."\",\"".$hlavicka->rk59."\",\"".$hlavicka->rn59."\",\"".$rm59."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R60\",\"".$hlavicka->r60."\",\"".$hlavicka->rk60."\",\"".$hlavicka->rn60."\",\"".$rm60."\""."\r\n"; fwrite($soubor, $text);



  $text = "\"suvaha-pasiva,44\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S5\",\"S6\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R61\",\"".$hlavicka->r61."\",\"".$rm61."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R62\",\"".$hlavicka->r62."\",\"".$rm62."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R63\",\"".$hlavicka->r63."\",\"".$rm63."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R64\",\"".$hlavicka->r64."\",\"".$rm64."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R65\",\"".$hlavicka->r65."\",\"".$rm65."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R66\",\"".$hlavicka->r66."\",\"".$rm66."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R67\",\"".$hlavicka->r67."\",\"".$rm67."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R68\",\"".$hlavicka->r68."\",\"".$rm68."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R69\",\"".$hlavicka->r69."\",\"".$rm69."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R70\",\"".$hlavicka->r70."\",\"".$rm70."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R71\",\"".$hlavicka->r71."\",\"".$rm71."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R72\",\"".$hlavicka->r72."\",\"".$rm72."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R73\",\"".$hlavicka->r73."\",\"".$rm73."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R74\",\"".$hlavicka->r74."\",\"".$rm74."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R75\",\"".$hlavicka->r75."\",\"".$rm75."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R76\",\"".$hlavicka->r76."\",\"".$rm76."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R77\",\"".$hlavicka->r77."\",\"".$rm77."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R78\",\"".$hlavicka->r78."\",\"".$rm78."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R79\",\"".$hlavicka->r79."\",\"".$rm79."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R80\",\"".$hlavicka->r80."\",\"".$rm80."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R81\",\"".$hlavicka->r81."\",\"".$rm81."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R82\",\"".$hlavicka->r82."\",\"".$rm82."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R83\",\"".$hlavicka->r83."\",\"".$rm83."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R84\",\"".$hlavicka->r84."\",\"".$rm84."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R85\",\"".$hlavicka->r85."\",\"".$rm85."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R86\",\"".$hlavicka->r86."\",\"".$rm86."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R87\",\"".$hlavicka->r87."\",\"".$rm87."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R88\",\"".$hlavicka->r88."\",\"".$rm88."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R89\",\"".$hlavicka->r89."\",\"".$rm89."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R90\",\"".$hlavicka->r90."\",\"".$rm90."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R91\",\"".$hlavicka->r91."\",\"".$rm91."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R92\",\"".$hlavicka->r92."\",\"".$rm92."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R93\",\"".$hlavicka->r93."\",\"".$rm93."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R94\",\"".$hlavicka->r94."\",\"".$rm94."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R95\",\"".$hlavicka->r95."\",\"".$rm95."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R96\",\"".$hlavicka->r96."\",\"".$rm96."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R97\",\"".$hlavicka->r97."\",\"".$rm97."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R98\",\"".$hlavicka->r98."\",\"".$rm98."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R99\",\"".$hlavicka->r99."\",\"".$rm99."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R100\",\"".$hlavicka->r100."\",\"".$rm100."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R101\",\"".$hlavicka->r101."\",\"".$rm101."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R102\",\"".$hlavicka->r102."\",\"".$rm102."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R103\",\"".$hlavicka->r103."\",\"".$rm103."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R104\",\"".$hlavicka->r104."\",\"".$rm104."\""."\r\n"; fwrite($soubor, $text);


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

//predch obdobie vysledovka
$rm01="0"; $rm02="0"; $rm03="0"; $rm04="0"; $rm05="0"; $rm06="0"; $rm07="0"; $rm08="0"; $rm09="0"; $rm10="0";
$rm11="0"; $rm12="0"; $rm13="0"; $rm14="0"; $rm15="0"; $rm16="0"; $rm17="0"; $rm18="0"; $rm19="0"; $rm20="0";
$rm21="0"; $rm22="0"; $rm23="0"; $rm24="0"; $rm25="0"; $rm26="0"; $rm27="0"; $rm28="0"; $rm29="0"; $rm30="0";
$rm31="0"; $rm32="0"; $rm33="0"; $rm34="0"; $rm35="0"; $rm36="0"; $rm37="0"; $rm38="0"; $rm39="0"; $rm40="0";
$rm41="0"; $rm42="0"; $rm43="0"; $rm44="0"; $rm45="0"; $rm46="0"; $rm47="0"; $rm48="0"; $rm49="0"; $rm50="0";
$rm51="0"; $rm52="0"; $rm53="0"; $rm54="0"; $rm55="0"; $rm56="0"; $rm57="0"; $rm58="0"; $rm59="0"; $rm60="0";
$rm61="0"; $rm62="0"; $rm63="0"; $rm64="0"; $rm65="0"; $rm66="0"; $rm67="0"; $rm68="0"; $rm69="0"; $rm70="0";
$rm71="0"; $rm72="0"; $rm73="0"; $rm74="0"; $rm75="0"; $rm76="0"; $rm77="0"; $rm78="0"; 

$sqlttps = "SELECT * FROM F$kli_vxcf"."_uctpocvziskovno WHERE dok > 0 ORDER BY dok ";
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
if ( $riadok == 46 ) { $rm46=1*$hlavickps->hod; }
if ( $riadok == 47 ) { $rm47=1*$hlavickps->hod; }
if ( $riadok == 48 ) { $rm48=1*$hlavickps->hod; }
if ( $riadok == 49 ) { $rm49=1*$hlavickps->hod; }

if ( $riadok == 50 ) { $rm50=1*$hlavickps->hod; }
if ( $riadok == 51 ) { $rm51=1*$hlavickps->hod; }
if ( $riadok == 52 ) { $rm52=1*$hlavickps->hod; }
if ( $riadok == 53 ) { $rm53=1*$hlavickps->hod; }
if ( $riadok == 54 ) { $rm54=1*$hlavickps->hod; }
if ( $riadok == 55 ) { $rm55=1*$hlavickps->hod; }
if ( $riadok == 56 ) { $rm56=1*$hlavickps->hod; }
if ( $riadok == 57 ) { $rm57=1*$hlavickps->hod; }
if ( $riadok == 58 ) { $rm58=1*$hlavickps->hod; }
if ( $riadok == 59 ) { $rm59=1*$hlavickps->hod; }

if ( $riadok == 60 ) { $rm60=1*$hlavickps->hod; }
if ( $riadok == 61 ) { $rm61=1*$hlavickps->hod; }
if ( $riadok == 62 ) { $rm62=1*$hlavickps->hod; }
if ( $riadok == 63 ) { $rm63=1*$hlavickps->hod; }
if ( $riadok == 64 ) { $rm64=1*$hlavickps->hod; }
if ( $riadok == 65 ) { $rm65=1*$hlavickps->hod; }
if ( $riadok == 66 ) { $rm66=1*$hlavickps->hod; }
if ( $riadok == 67 ) { $rm67=1*$hlavickps->hod; }
if ( $riadok == 68 ) { $rm68=1*$hlavickps->hod; }
if ( $riadok == 69 ) { $rm69=1*$hlavickps->hod; }

if ( $riadok == 70 ) { $rm70=1*$hlavickps->hod; }
if ( $riadok == 71 ) { $rm71=1*$hlavickps->hod; }
if ( $riadok == 72 ) { $rm72=1*$hlavickps->hod; }
if ( $riadok == 73 ) { $rm73=1*$hlavickps->hod; }
if ( $riadok == 74 ) { $rm74=1*$hlavickps->hod; }
if ( $riadok == 75 ) { $rm75=1*$hlavickps->hod; }
if ( $riadok == 76 ) { $rm76=1*$hlavickps->hod; }
if ( $riadok == 77 ) { $rm77=1*$hlavickps->hod; }
if ( $riadok == 78 ) { $rm78=1*$hlavickps->hod; }

}
$ips = $ips + 1;
  }

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {

  $text = "\"vzas-naklady,38\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rpc01."\",\"".$hlavicka->rsp01."\",\"".$rm01."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->r02."\",\"".$hlavicka->rpc02."\",\"".$hlavicka->rsp02."\",\"".$rm02."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->r03."\",\"".$hlavicka->rpc03."\",\"".$hlavicka->rsp03."\",\"".$rm03."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->r04."\",\"".$hlavicka->rpc04."\",\"".$hlavicka->rsp04."\",\"".$rm04."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->r05."\",\"".$hlavicka->rpc05."\",\"".$hlavicka->rsp05."\",\"".$rm05."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->r06."\",\"".$hlavicka->rpc06."\",\"".$hlavicka->rsp06."\",\"".$rm06."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->r07."\",\"".$hlavicka->rpc07."\",\"".$hlavicka->rsp07."\",\"".$rm07."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->r08."\",\"".$hlavicka->rpc08."\",\"".$hlavicka->rsp08."\",\"".$rm08."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->r09."\",\"".$hlavicka->rpc09."\",\"".$hlavicka->rsp09."\",\"".$rm09."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R10\",\"".$hlavicka->r10."\",\"".$hlavicka->rpc10."\",\"".$hlavicka->rsp10."\",\"".$rm10."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R11\",\"".$hlavicka->r11."\",\"".$hlavicka->rpc11."\",\"".$hlavicka->rsp11."\",\"".$rm11."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R12\",\"".$hlavicka->r12."\",\"".$hlavicka->rpc12."\",\"".$hlavicka->rsp12."\",\"".$rm12."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R13\",\"".$hlavicka->r13."\",\"".$hlavicka->rpc13."\",\"".$hlavicka->rsp13."\",\"".$rm13."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R14\",\"".$hlavicka->r14."\",\"".$hlavicka->rpc14."\",\"".$hlavicka->rsp14."\",\"".$rm14."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R15\",\"".$hlavicka->r15."\",\"".$hlavicka->rpc15."\",\"".$hlavicka->rsp15."\",\"".$rm15."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R16\",\"".$hlavicka->r16."\",\"".$hlavicka->rpc16."\",\"".$hlavicka->rsp16."\",\"".$rm16."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R17\",\"".$hlavicka->r17."\",\"".$hlavicka->rpc17."\",\"".$hlavicka->rsp17."\",\"".$rm17."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R18\",\"".$hlavicka->r18."\",\"".$hlavicka->rpc18."\",\"".$hlavicka->rsp18."\",\"".$rm18."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R19\",\"".$hlavicka->r19."\",\"".$hlavicka->rpc19."\",\"".$hlavicka->rsp19."\",\"".$rm19."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R20\",\"".$hlavicka->r20."\",\"".$hlavicka->rpc20."\",\"".$hlavicka->rsp20."\",\"".$rm20."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R21\",\"".$hlavicka->r21."\",\"".$hlavicka->rpc21."\",\"".$hlavicka->rsp21."\",\"".$rm21."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->r22."\",\"".$hlavicka->rpc22."\",\"".$hlavicka->rsp22."\",\"".$rm22."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->r23."\",\"".$hlavicka->rpc23."\",\"".$hlavicka->rsp23."\",\"".$rm23."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R24\",\"".$hlavicka->r24."\",\"".$hlavicka->rpc24."\",\"".$hlavicka->rsp24."\",\"".$rm24."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->r25."\",\"".$hlavicka->rpc25."\",\"".$hlavicka->rsp25."\",\"".$rm25."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->r26."\",\"".$hlavicka->rpc26."\",\"".$hlavicka->rsp26."\",\"".$rm26."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->r27."\",\"".$hlavicka->rpc27."\",\"".$hlavicka->rsp27."\",\"".$rm27."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R28\",\"".$hlavicka->r28."\",\"".$hlavicka->rpc28."\",\"".$hlavicka->rsp28."\",\"".$rm28."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R29\",\"".$hlavicka->r29."\",\"".$hlavicka->rpc29."\",\"".$hlavicka->rsp29."\",\"".$rm29."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R30\",\"".$hlavicka->r30."\",\"".$hlavicka->rpc30."\",\"".$hlavicka->rsp30."\",\"".$rm30."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R31\",\"".$hlavicka->r31."\",\"".$hlavicka->rpc31."\",\"".$hlavicka->rsp31."\",\"".$rm31."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R32\",\"".$hlavicka->r32."\",\"".$hlavicka->rpc32."\",\"".$hlavicka->rsp32."\",\"".$rm32."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R33\",\"".$hlavicka->r33."\",\"".$hlavicka->rpc33."\",\"".$hlavicka->rsp33."\",\"".$rm33."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R34\",\"".$hlavicka->r34."\",\"".$hlavicka->rpc34."\",\"".$hlavicka->rsp34."\",\"".$rm34."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R35\",\"".$hlavicka->r35."\",\"".$hlavicka->rpc35."\",\"".$hlavicka->rsp35."\",\"".$rm35."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R36\",\"".$hlavicka->r36."\",\"".$hlavicka->rpc36."\",\"".$hlavicka->rsp36."\",\"".$rm36."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R37\",\"".$hlavicka->r37."\",\"".$hlavicka->rpc37."\",\"".$hlavicka->rsp37."\",\"".$rm37."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R38\",\"".$hlavicka->r38."\",\"".$hlavicka->rpc38."\",\"".$hlavicka->rsp38."\",\"".$rm38."\""."\r\n"; fwrite($soubor, $text);


  $text = "\"vzas-vynosy,40\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1\",\"S2\",\"S3\",\"S4\""."\r\n"; fwrite($soubor, $text);


  $text = "\"R39\",\"".$hlavicka->r39."\",\"".$hlavicka->rpc39."\",\"".$hlavicka->rsp39."\",\"".$rm39."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R40\",\"".$hlavicka->r40."\",\"".$hlavicka->rpc40."\",\"".$hlavicka->rsp40."\",\"".$rm40."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R41\",\"".$hlavicka->r41."\",\"".$hlavicka->rpc41."\",\"".$hlavicka->rsp41."\",\"".$rm41."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R42\",\"".$hlavicka->r42."\",\"".$hlavicka->rpc42."\",\"".$hlavicka->rsp42."\",\"".$rm42."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R43\",\"".$hlavicka->r43."\",\"".$hlavicka->rpc43."\",\"".$hlavicka->rsp43."\",\"".$rm43."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R44\",\"".$hlavicka->r44."\",\"".$hlavicka->rpc44."\",\"".$hlavicka->rsp44."\",\"".$rm44."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R45\",\"".$hlavicka->r45."\",\"".$hlavicka->rpc45."\",\"".$hlavicka->rsp45."\",\"".$rm45."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R46\",\"".$hlavicka->r46."\",\"".$hlavicka->rpc46."\",\"".$hlavicka->rsp46."\",\"".$rm46."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R47\",\"".$hlavicka->r47."\",\"".$hlavicka->rpc47."\",\"".$hlavicka->rsp47."\",\"".$rm47."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R48\",\"".$hlavicka->r48."\",\"".$hlavicka->rpc48."\",\"".$hlavicka->rsp48."\",\"".$rm48."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R49\",\"".$hlavicka->r49."\",\"".$hlavicka->rpc49."\",\"".$hlavicka->rsp49."\",\"".$rm49."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R50\",\"".$hlavicka->r50."\",\"".$hlavicka->rpc50."\",\"".$hlavicka->rsp50."\",\"".$rm50."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R51\",\"".$hlavicka->r51."\",\"".$hlavicka->rpc51."\",\"".$hlavicka->rsp51."\",\"".$rm51."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R52\",\"".$hlavicka->r52."\",\"".$hlavicka->rpc52."\",\"".$hlavicka->rsp52."\",\"".$rm52."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R53\",\"".$hlavicka->r53."\",\"".$hlavicka->rpc53."\",\"".$hlavicka->rsp53."\",\"".$rm53."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R54\",\"".$hlavicka->r54."\",\"".$hlavicka->rpc54."\",\"".$hlavicka->rsp54."\",\"".$rm54."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R55\",\"".$hlavicka->r55."\",\"".$hlavicka->rpc55."\",\"".$hlavicka->rsp55."\",\"".$rm55."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R56\",\"".$hlavicka->r56."\",\"".$hlavicka->rpc56."\",\"".$hlavicka->rsp56."\",\"".$rm56."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R57\",\"".$hlavicka->r57."\",\"".$hlavicka->rpc57."\",\"".$hlavicka->rsp57."\",\"".$rm57."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R58\",\"".$hlavicka->r58."\",\"".$hlavicka->rpc58."\",\"".$hlavicka->rsp58."\",\"".$rm58."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R59\",\"".$hlavicka->r59."\",\"".$hlavicka->rpc59."\",\"".$hlavicka->rsp59."\",\"".$rm59."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R60\",\"".$hlavicka->r60."\",\"".$hlavicka->rpc60."\",\"".$hlavicka->rsp60."\",\"".$rm60."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R61\",\"".$hlavicka->r61."\",\"".$hlavicka->rpc61."\",\"".$hlavicka->rsp61."\",\"".$rm61."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R62\",\"".$hlavicka->r62."\",\"".$hlavicka->rpc62."\",\"".$hlavicka->rsp62."\",\"".$rm62."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R63\",\"".$hlavicka->r63."\",\"".$hlavicka->rpc63."\",\"".$hlavicka->rsp63."\",\"".$rm63."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R64\",\"".$hlavicka->r64."\",\"".$hlavicka->rpc64."\",\"".$hlavicka->rsp64."\",\"".$rm64."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R65\",\"".$hlavicka->r65."\",\"".$hlavicka->rpc65."\",\"".$hlavicka->rsp65."\",\"".$rm65."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R66\",\"".$hlavicka->r66."\",\"".$hlavicka->rpc66."\",\"".$hlavicka->rsp66."\",\"".$rm66."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R67\",\"".$hlavicka->r67."\",\"".$hlavicka->rpc67."\",\"".$hlavicka->rsp67."\",\"".$rm67."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R68\",\"".$hlavicka->r68."\",\"".$hlavicka->rpc68."\",\"".$hlavicka->rsp68."\",\"".$rm68."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R69\",\"".$hlavicka->r69."\",\"".$hlavicka->rpc69."\",\"".$hlavicka->rsp69."\",\"".$rm69."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R70\",\"".$hlavicka->r70."\",\"".$hlavicka->rpc70."\",\"".$hlavicka->rsp70."\",\"".$rm70."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R71\",\"".$hlavicka->r71."\",\"".$hlavicka->rpc71."\",\"".$hlavicka->rsp71."\",\"".$rm71."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R72\",\"".$hlavicka->r72."\",\"".$hlavicka->rpc72."\",\"".$hlavicka->rsp72."\",\"".$rm72."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R73\",\"".$hlavicka->r73."\",\"".$hlavicka->rpc73."\",\"".$hlavicka->rsp73."\",\"".$rm73."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R74\",\"".$hlavicka->r74."\",\"".$hlavicka->rpc74."\",\"".$hlavicka->rsp74."\",\"".$rm74."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R75\",\"".$hlavicka->r75."\",\"".$hlavicka->rpc75."\",\"".$hlavicka->rsp75."\",\"".$rm75."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R76\",\"".$hlavicka->r76."\",\"".$hlavicka->rpc76."\",\"".$hlavicka->rsp76."\",\"".$rm76."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R77\",\"".$hlavicka->r77."\",\"".$hlavicka->rpc77."\",\"".$hlavicka->rsp77."\",\"".$rm77."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R78\",\"".$hlavicka->r78."\",\"".$hlavicka->rpc78."\",\"".$hlavicka->rsp78."\",\"".$rm78."\""."\r\n"; fwrite($soubor, $text);


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
<p>Stiahnite si niûöie uveden˝ s˙bor <strong><?php echo $nazsub; ?></strong> do V·öho poËÌtaËa s n·zvom UZ_NUJ.csv a naËÌtajte ho na
<a href="https://www.rissam.sk/vpn/rissam.html" target="_blank" title="Str·nka RIS pre Samospr·vu">RIS pre Samospr·vu</a>.
<br />
K naËÌtaniu NUJ uz·vierky vo form·te CSV na RISSAM budete eöte potrebovaù Pozn·mky NUJ vo form·te PDF a ⁄vodn˙ stranu uz·vierky NUJ vo form·te PDF.
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
 <dt class="toleft box-red"></dt><dd class="toleft">kritickÈ</dd>
 <dt class="toleft box-orange"></dt><dd class="toleft">logickÈ</dd>
</dl>
</h2>
<ul id="alertpage1" style="display:none;">
<li class="header-section">STRANA 1</li>
<li class="red">
<?php if ( trim($h_zos) == "" )
{
$upozorni1=1;
echo "Nie je vyplnen˝ <strong>d·tum zostavenia</strong> uz·vierky.";
}
?>
</li>
<li class="red">
<?php if ( trim($h_sch) == "" )
{
$upozorni1=1;
echo "Nie je vyplnen˝ <strong>d·tum schv·lenia</strong> uz·vierky.";
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