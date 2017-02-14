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

 $outfilexdel="../tmp/UZ_POD_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/UZ_POD_".$kli_uzid."_".$hhmmss.".csv";
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
   <td class="header">Uz·vierka POD / Export CSV <span class="subheader"></span></td>
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

$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk65 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk66 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk67 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk68 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk69 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk70 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk71 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk72 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk73 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk74 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk75 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk76 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk77 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." MODIFY rk78 DECIMAL(13,0) DEFAULT 0 "; $sql = mysql_query("$sqltt");

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
$rm101="0"; $rm102="0"; $rm103="0"; $rm104="0"; $rm105="0"; $rm106="0"; $rm107="0"; $rm108="0"; $rm109="0"; $rm110="0";
$rm111="0"; $rm112="0"; $rm113="0"; $rm114="0"; $rm115="0"; $rm116="0"; $rm117="0"; $rm118="0"; $rm119="0"; $rm120="0";
$rm121="0"; $rm122="0"; $rm123="0"; $rm124="0"; $rm125="0"; $rm126="0"; $rm127="0"; $rm128="0"; $rm129="0"; $rm130="0";
$rm131="0"; $rm132="0"; $rm133="0"; $rm134="0"; $rm135="0"; $rm136="0"; $rm137="0"; $rm138="0"; $rm139="0"; $rm140="0";
$rm141="0"; $rm142="0"; $rm143="0"; $rm144="0"; $rm145="0"; 

$sqlttps = "SELECT * FROM F$kli_vxcf"."_pos_pod2014 WHERE dok > 0 ORDER BY dok ";
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
if ( $riadok == 105 ) { $rm105=1*$hlavickps->hod; }
if ( $riadok == 106 ) { $rm106=1*$hlavickps->hod; }
if ( $riadok == 107 ) { $rm107=1*$hlavickps->hod; }
if ( $riadok == 108 ) { $rm108=1*$hlavickps->hod; }
if ( $riadok == 109 ) { $rm109=1*$hlavickps->hod; }
if ( $riadok == 110 ) { $rm110=1*$hlavickps->hod; }
if ( $riadok == 111 ) { $rm111=1*$hlavickps->hod; }
if ( $riadok == 112 ) { $rm112=1*$hlavickps->hod; }
if ( $riadok == 113 ) { $rm113=1*$hlavickps->hod; }
if ( $riadok == 114 ) { $rm114=1*$hlavickps->hod; }
if ( $riadok == 115 ) { $rm115=1*$hlavickps->hod; }
if ( $riadok == 116 ) { $rm116=1*$hlavickps->hod; }
if ( $riadok == 117 ) { $rm117=1*$hlavickps->hod; }
if ( $riadok == 118 ) { $rm118=1*$hlavickps->hod; }
if ( $riadok == 119 ) { $rm119=1*$hlavickps->hod; }
if ( $riadok == 120 ) { $rm120=1*$hlavickps->hod; }
if ( $riadok == 121 ) { $rm121=1*$hlavickps->hod; }
if ( $riadok == 122 ) { $rm122=1*$hlavickps->hod; }
if ( $riadok == 123 ) { $rm123=1*$hlavickps->hod; }
if ( $riadok == 124 ) { $rm124=1*$hlavickps->hod; }
if ( $riadok == 125 ) { $rm125=1*$hlavickps->hod; }
if ( $riadok == 126 ) { $rm126=1*$hlavickps->hod; }
if ( $riadok == 127 ) { $rm127=1*$hlavickps->hod; }
if ( $riadok == 128 ) { $rm128=1*$hlavickps->hod; }
if ( $riadok == 129 ) { $rm129=1*$hlavickps->hod; }
if ( $riadok == 130 ) { $rm130=1*$hlavickps->hod; }
if ( $riadok == 131 ) { $rm131=1*$hlavickps->hod; }
if ( $riadok == 132 ) { $rm132=1*$hlavickps->hod; }
if ( $riadok == 133 ) { $rm133=1*$hlavickps->hod; }
if ( $riadok == 134 ) { $rm134=1*$hlavickps->hod; }
if ( $riadok == 135 ) { $rm135=1*$hlavickps->hod; }
if ( $riadok == 136 ) { $rm136=1*$hlavickps->hod; }
if ( $riadok == 137 ) { $rm137=1*$hlavickps->hod; }
if ( $riadok == 138 ) { $rm138=1*$hlavickps->hod; }
if ( $riadok == 139 ) { $rm139=1*$hlavickps->hod; }
if ( $riadok == 140 ) { $rm140=1*$hlavickps->hod; }
if ( $riadok == 141 ) { $rm141=1*$hlavickps->hod; }
if ( $riadok == 142 ) { $rm142=1*$hlavickps->hod; }
if ( $riadok == 143 ) { $rm143=1*$hlavickps->hod; }
if ( $riadok == 144 ) { $rm144=1*$hlavickps->hod; }
if ( $riadok == 145 ) { $rm145=1*$hlavickps->hod; }

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
  $text = "\"dic\",\"sk-nace\",\"velkost-uj\",\"ulica\",\"popisne-cislo\",\"psc\",\"obec-nazov\",\"obchodny-register\",\"telefon\",\"fax\",\"email\""."\r\n"; fwrite($soubor, $text);

$dic=iconv("CP1250", "UTF-8", $fir_fdic);
$sknace=trim($fir_sknace);
$sknace = str_replace(".","",$sknace);
$ulica=trim(iconv("CP1250", "UTF-8", $fir_fuli));
$popisnecislo=iconv("CP1250", "UTF-8", $fir_fcdm);
$sknace = trim(str_replace(".","",$fir_sknace));
$psc = trim(str_replace(" ","",$fir_fpsc));
$obecnazov=iconv("CP1250", "UTF-8", $fir_fmes);
$register=iconv("CP1250", "UTF-8", $fir_obreg);
$telefon = trim(str_replace(" ","",$fir_ftel));
$telefon = trim(str_replace("/","",$telefon));
$fax = trim(str_replace(" ","",$fir_ffax));
$fax = trim(str_replace("/","",$fax));
$email = iconv("CP1250", "UTF-8", $fir_fem1);
$velkostuj="M";


  $text = "\"".$dic."\",\"".$sknace."\",\"".$velkostuj."\",\"".$ulica."\",\"".$popisnecislo."\",\"".$psc."\",\"".$obecnazov."\",\"".$register."\",\"".$telefon."\",,\"".$email."\""."\r\n"; fwrite($soubor, $text);


  $text = "\"suvaha-aktiva,78\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S1-1\",\"S1-2\",\"S2\",\"S3\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rk01."\",\"".$hlavicka->rn01."\",\"".$rm01."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->r02."\",\"".$hlavicka->rk02."\",\"".$hlavicka->rn02."\",\"".$rm02."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->r03."\",\"".$hlavicka->rk03."\",\"".$hlavicka->rn03."\",\"".$rm03."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->r04."\",\"".$hlavicka->rk04."\",\"".$hlavicka->rn04."\",\"".$rm04."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->r05."\",\"".$hlavicka->rk05."\",\"".$hlavicka->rn05."\",\"".$rm05."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->r06."\",\"".$hlavicka->rk06."\",\"".$hlavicka->rn06."\",\"".$rm06."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->r07."\",\"".$hlavicka->rk07."\",\"".$hlavicka->rn07."\",\"".$rm07."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->r08."\",\"".$hlavicka->rk08."\",\"".$hlavicka->rn08."\",\"".$rm08."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->r09."\",\"".$hlavicka->rk09."\",\"".$hlavicka->rn09."\",\"".$rm09."\""."\r\n"; fwrite($soubor, $text);


  $text = "\"R10\",\"".$hlavicka->r10."\",\"".$hlavicka->rk10."\",\"".$hlavicka->rn10."\",\"".$rm10."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R11\",\"".$hlavicka->r11."\",\"".$hlavicka->rk11."\",\"".$hlavicka->rn11."\",\"".$rm11."\""."\r\n"; fwrite($soubor, $text);
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
  $text = "\"R45\",\"".$hlavicka->r45."\",\"".$hlavicka->rk45."\",\"".$hlavicka->rn45."\",\"".$rm45."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R46\",\"".$hlavicka->r46."\",\"".$hlavicka->rk46."\",\"".$hlavicka->rn46."\",\"".$rm46."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R47\",\"".$hlavicka->r47."\",\"".$hlavicka->rk47."\",\"".$hlavicka->rn47."\",\"".$rm47."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R48\",\"".$hlavicka->r48."\",\"".$hlavicka->rk48."\",\"".$hlavicka->rn48."\",\"".$rm48."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R49\",\"".$hlavicka->r49."\",\"".$hlavicka->rk49."\",\"".$hlavicka->rn49."\",\"".$rm49."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R50\",\"".$hlavicka->r50."\",\"".$hlavicka->rk50."\",\"".$hlavicka->rn50."\",\"".$rm50."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R51\",\"".$hlavicka->r51."\",\"".$hlavicka->rk51."\",\"".$hlavicka->rn51."\",\"".$rm51."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R52\",\"".$hlavicka->r52."\",\"".$hlavicka->rk52."\",\"".$hlavicka->rn52."\",\"".$rm52."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R53\",\"".$hlavicka->r53."\",\"".$hlavicka->rk53."\",\"".$hlavicka->rn53."\",\"".$rm53."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R54\",\"".$hlavicka->r54."\",\"".$hlavicka->rk54."\",\"".$hlavicka->rn54."\",\"".$rm54."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R55\",\"".$hlavicka->r55."\",\"".$hlavicka->rk55."\",\"".$hlavicka->rn55."\",\"".$rm55."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R56\",\"".$hlavicka->r56."\",\"".$hlavicka->rk56."\",\"".$hlavicka->rn56."\",\"".$rm56."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R57\",\"".$hlavicka->r57."\",\"".$hlavicka->rk57."\",\"".$hlavicka->rn57."\",\"".$rm57."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R58\",\"".$hlavicka->r58."\",\"".$hlavicka->rk58."\",\"".$hlavicka->rn58."\",\"".$rm58."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R59\",\"".$hlavicka->r59."\",\"".$hlavicka->rk59."\",\"".$hlavicka->rn59."\",\"".$rm59."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R60\",\"".$hlavicka->r60."\",\"".$hlavicka->rk60."\",\"".$hlavicka->rn60."\",\"".$rm60."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R61\",\"".$hlavicka->r61."\",\"".$hlavicka->rk61."\",\"".$hlavicka->rn61."\",\"".$rm61."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R62\",\"".$hlavicka->r62."\",\"".$hlavicka->rk62."\",\"".$hlavicka->rn62."\",\"".$rm62."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R63\",\"".$hlavicka->r63."\",\"".$hlavicka->rk63."\",\"".$hlavicka->rn63."\",\"".$rm63."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R64\",\"".$hlavicka->r64."\",\"".$hlavicka->rk64."\",\"".$hlavicka->rn64."\",\"".$rm64."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R65\",\"".$hlavicka->r65."\",\"".$hlavicka->rk65."\",\"".$hlavicka->rn65."\",\"".$rm65."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R66\",\"".$hlavicka->r66."\",\"".$hlavicka->rk66."\",\"".$hlavicka->rn66."\",\"".$rm66."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R67\",\"".$hlavicka->r67."\",\"".$hlavicka->rk67."\",\"".$hlavicka->rn67."\",\"".$rm67."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R68\",\"".$hlavicka->r68."\",\"".$hlavicka->rk68."\",\"".$hlavicka->rn68."\",\"".$rm68."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R69\",\"".$hlavicka->r69."\",\"".$hlavicka->rk69."\",\"".$hlavicka->rn69."\",\"".$rm69."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R70\",\"".$hlavicka->r70."\",\"".$hlavicka->rk70."\",\"".$hlavicka->rn70."\",\"".$rm70."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R71\",\"".$hlavicka->r71."\",\"".$hlavicka->rk71."\",\"".$hlavicka->rn71."\",\"".$rm71."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R72\",\"".$hlavicka->r72."\",\"".$hlavicka->rk72."\",\"".$hlavicka->rn72."\",\"".$rm72."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R73\",\"".$hlavicka->r73."\",\"".$hlavicka->rk73."\",\"".$hlavicka->rn73."\",\"".$rm73."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R74\",\"".$hlavicka->r74."\",\"".$hlavicka->rk74."\",\"".$hlavicka->rn74."\",\"".$rm74."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R75\",\"".$hlavicka->r75."\",\"".$hlavicka->rk75."\",\"".$hlavicka->rn75."\",\"".$rm75."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R76\",\"".$hlavicka->r76."\",\"".$hlavicka->rk76."\",\"".$hlavicka->rn76."\",\"".$rm76."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R77\",\"".$hlavicka->r77."\",\"".$hlavicka->rk77."\",\"".$hlavicka->rn77."\",\"".$rm77."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R78\",\"".$hlavicka->r78."\",\"".$hlavicka->rk78."\",\"".$hlavicka->rn78."\",\"".$rm78."\""."\r\n"; fwrite($soubor, $text);



  $text = "\"suvaha-pasiva,67\""."\r\n"; fwrite($soubor, $text);		
  $text = "\"R\",\"S4\",\"S5\""."\r\n"; fwrite($soubor, $text);


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
  $text = "\"R105\",\"".$hlavicka->r105."\",\"".$rm105."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R106\",\"".$hlavicka->r106."\",\"".$rm106."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R107\",\"".$hlavicka->r107."\",\"".$rm107."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R108\",\"".$hlavicka->r108."\",\"".$rm108."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R109\",\"".$hlavicka->r109."\",\"".$rm109."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R110\",\"".$hlavicka->r110."\",\"".$rm110."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R111\",\"".$hlavicka->r111."\",\"".$rm111."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R112\",\"".$hlavicka->r112."\",\"".$rm112."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R113\",\"".$hlavicka->r113."\",\"".$rm113."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R114\",\"".$hlavicka->r114."\",\"".$rm114."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R115\",\"".$hlavicka->r115."\",\"".$rm115."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R116\",\"".$hlavicka->r116."\",\"".$rm116."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R117\",\"".$hlavicka->r117."\",\"".$rm117."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R118\",\"".$hlavicka->r118."\",\"".$rm118."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R119\",\"".$hlavicka->r119."\",\"".$rm119."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R120\",\"".$hlavicka->r120."\",\"".$rm120."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R121\",\"".$hlavicka->r121."\",\"".$rm121."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R122\",\"".$hlavicka->r122."\",\"".$rm122."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R123\",\"".$hlavicka->r123."\",\"".$rm123."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R124\",\"".$hlavicka->r124."\",\"".$rm124."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R125\",\"".$hlavicka->r125."\",\"".$rm125."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R126\",\"".$hlavicka->r126."\",\"".$rm126."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R127\",\"".$hlavicka->r127."\",\"".$rm127."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R128\",\"".$hlavicka->r128."\",\"".$rm128."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R129\",\"".$hlavicka->r129."\",\"".$rm129."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R130\",\"".$hlavicka->r130."\",\"".$rm130."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R131\",\"".$hlavicka->r131."\",\"".$rm131."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R132\",\"".$hlavicka->r132."\",\"".$rm132."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R133\",\"".$hlavicka->r133."\",\"".$rm133."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R134\",\"".$hlavicka->r134."\",\"".$rm134."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R135\",\"".$hlavicka->r135."\",\"".$rm135."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R136\",\"".$hlavicka->r136."\",\"".$rm136."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R137\",\"".$hlavicka->r137."\",\"".$rm137."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R138\",\"".$hlavicka->r138."\",\"".$rm138."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R139\",\"".$hlavicka->r139."\",\"".$rm139."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R140\",\"".$hlavicka->r140."\",\"".$rm140."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R141\",\"".$hlavicka->r141."\",\"".$rm141."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R142\",\"".$hlavicka->r142."\",\"".$rm142."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R143\",\"".$hlavicka->r143."\",\"".$rm143."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R144\",\"".$hlavicka->r144."\",\"".$rm144."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R145\",\"".$hlavicka->r145."\",\"".$rm145."\""."\r\n"; fwrite($soubor, $text);



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

//predch obdobie vysledovka
$rm01="0"; $rm02="0"; $rm03="0"; $rm04="0"; $rm05="0"; $rm06="0"; $rm07="0"; $rm08="0"; $rm09="0"; $rm10="0";
$rm11="0"; $rm12="0"; $rm13="0"; $rm14="0"; $rm15="0"; $rm16="0"; $rm17="0"; $rm18="0"; $rm19="0"; $rm20="0";
$rm21="0"; $rm22="0"; $rm23="0"; $rm24="0"; $rm25="0"; $rm26="0"; $rm27="0"; $rm28="0"; $rm29="0"; $rm30="0";
$rm31="0"; $rm32="0"; $rm33="0"; $rm34="0"; $rm35="0"; $rm36="0"; $rm37="0"; $rm38="0"; $rm39="0"; $rm40="0";
$rm41="0"; $rm42="0"; $rm43="0"; $rm44="0"; $rm45="0"; $rm46="0"; $rm47="0"; $rm48="0"; $rm49="0"; $rm50="0";
$rm51="0"; $rm52="0"; $rm53="0"; $rm54="0"; $rm55="0"; $rm56="0"; $rm57="0"; $rm58="0"; $rm59="0"; $rm60="0";
$rm61="0";  

$sqlttps = "SELECT * FROM F$kli_vxcf"."_pov_pod2014 WHERE dok > 0 ORDER BY dok "; 
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

}
$ips = $ips + 1;
  }

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_datsql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {

  $text = "\"vzas,61\""."\r\n"; fwrite($soubor, $text);		
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

  $text = "\"R20\",\"".$hlavicka->r20."\",\"".$rm20."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R21\",\"".$hlavicka->r21."\",\"".$rm21."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->r22."\",\"".$rm22."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->r23."\",\"".$rm23."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R24\",\"".$hlavicka->r24."\",\"".$rm24."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->r25."\",\"".$rm25."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->r26."\",\"".$rm26."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->r27."\",\"".$rm27."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R28\",\"".$hlavicka->r28."\",\"".$rm28."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R29\",\"".$hlavicka->r29."\",\"".$rm29."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R30\",\"".$hlavicka->r30."\",\"".$rm30."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R31\",\"".$hlavicka->r31."\",\"".$rm31."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R32\",\"".$hlavicka->r32."\",\"".$rm32."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R33\",\"".$hlavicka->r33."\",\"".$rm33."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R34\",\"".$hlavicka->r34."\",\"".$rm34."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R35\",\"".$hlavicka->r35."\",\"".$rm35."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R36\",\"".$hlavicka->r36."\",\"".$rm36."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R37\",\"".$hlavicka->r37."\",\"".$rm37."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R38\",\"".$hlavicka->r38."\",\"".$rm38."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R39\",\"".$hlavicka->r39."\",\"".$rm39."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R40\",\"".$hlavicka->r40."\",\"".$rm40."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R41\",\"".$hlavicka->r41."\",\"".$rm41."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R42\",\"".$hlavicka->r42."\",\"".$rm42."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R43\",\"".$hlavicka->r43."\",\"".$rm43."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R44\",\"".$hlavicka->r44."\",\"".$rm44."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R45\",\"".$hlavicka->r45."\",\"".$rm45."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R46\",\"".$hlavicka->r46."\",\"".$rm46."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R47\",\"".$hlavicka->r47."\",\"".$rm47."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R48\",\"".$hlavicka->r48."\",\"".$rm48."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R49\",\"".$hlavicka->r49."\",\"".$rm49."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R50\",\"".$hlavicka->r50."\",\"".$rm50."\""."\r\n"; fwrite($soubor, $text);;
  $text = "\"R51\",\"".$hlavicka->r51."\",\"".$rm51."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R52\",\"".$hlavicka->r52."\",\"".$rm52."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R53\",\"".$hlavicka->r53."\",\"".$rm53."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R54\",\"".$hlavicka->r54."\",\"".$rm54."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R55\",\"".$hlavicka->r55."\",\"".$rm55."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R56\",\"".$hlavicka->r56."\",\"".$rm56."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R57\",\"".$hlavicka->r57."\",\"".$rm57."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R58\",\"".$hlavicka->r58."\",\"".$rm58."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R59\",\"".$hlavicka->r59."\",\"".$rm59."\""."\r\n"; fwrite($soubor, $text);

  $text = "\"R60\",\"".$hlavicka->r60."\",\"".$rm60."\""."\r\n"; fwrite($soubor, $text);
  $text = "\"R61\",\"".$hlavicka->r61."\",\"".$rm61."\""."\r\n"; fwrite($soubor, $text);



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
<p>Stiahnite si niûöie uveden˝ s˙bor <strong><?php echo $nazsub; ?></strong> do V·öho poËÌtaËa s n·zvom UZ_POD.csv a naËÌtajte ho na
<a href="https://www.rissam.sk/vpn/rissam.html" target="_blank" title="Str·nka RIS pre Samospr·vu">RIS pre Samospr·vu</a>.
<br />
K naËÌtaniu POD uz·vierky vo form·te CSV na RISSAM budete eöte potrebovaù Pozn·mky POD vo form·te PDF a ⁄vodn˙ stranu uz·vierky POD vo form·te PDF.
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