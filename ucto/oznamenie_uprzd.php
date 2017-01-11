<!doctype html>
<HTML>
<?php
do
{
$sys = 'UCT';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$rokdmv=2015;
if ( $kli_vrok > 2015 ) { $rokdmv=2015; }

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 9999;
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
$zoznamaut=1;

$vsetkyprepocty=0;
$prepocitaj = 1*$_REQUEST['prepocitaj'];

$pocetdni = 1*$_REQUEST['pocetdni'];
$vypocitajdan = 1*$_REQUEST['vypocitajdan'];

$xml = 1*$_REQUEST['xml'];

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;


//uprav vozidlo
    if ( $copern == 346 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$copern=20;
$strana=3;
$zoznamaut=0;
    }
//koniec uprav vozidlo

//nove vozidlo
    if ( $copern == 336 )
    {
$sql = "INSERT INTO F".$kli_vxcf."_uctoznamenie_uprzd (oc,konx1) VALUES ( 1, 0 ) ";
$vysledok = mysql_query($sql);

$cislo_cpl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 ORDER BY cpl DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislo_cpl=$riaddok->cpl;
 }
$copern=20;
$strana=3;
$zoznamaut=0;
$_REQUEST['cislo_cpl']=$cislo_cpl;
    }
//koniec nove vozidlo

//zmaz vozidlo
    if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$cislo_spz = $_REQUEST['cislo_spz'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù vozidlo <?php echo $cislo_spz; ?> ?") )
         { location.href='oznamenie_uprzd.php?cislo_oc=9999&drupoh=1&page=1&subor=0&copern=20&strana=5' }
else
         { location.href='oznamenie_uprzd.php?copern=3166&page=1&drupoh=1&cislo_cpl=<?php echo $cislo_cpl; ?>' }
</script>
<?php
exit;                      
    }

    if ( $copern == 3166 )
    {

$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$sql = "DELETE FROM F".$kli_vxcf."_uctoznamenie_uprzd WHERE cpl = $cislo_cpl ";
$vysledok = mysql_query($sql);

$copern=20;
$strana=5;
$zoznamaut=1;
    }
//zmaz vozidlo



//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {

$zoema = strip_tags($_REQUEST['zoema']);


$uprtxt = "UPDATE F$kli_vxcf"."_uctoznamenie_uprzd SET ".
" zoema='$zoema' ".
" WHERE oc = 9999 ";
                    }

if ( $strana == 2 ) {

$rdc3 = strip_tags($_REQUEST['rdc3']);


$uprtxt = "UPDATE F$kli_vxcf"."_uctoznamenie_uprzd SET ".
" rdc3='$rdc3' ".
" WHERE oc = 9999 ";

                    }

if ( $strana == 3 ) {

$rdc3 = strip_tags($_REQUEST['rdc3']);


$uprtxt = "UPDATE F$kli_vxcf"."_uctoznamenie_uprzd SET ".
" rdc3='$rdc3' ".
" WHERE oc = 9999 ";

                    }

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov




//vytvorenie
$sql = "SELECT konx3 FROM F".$kli_vxcf."_uctoznamenie_uprzd";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctoznamenie_uprzd';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   cpl           int not null auto_increment,
   oc            INT(7) DEFAULT 0,
   druh          DECIMAL(10,0) DEFAULT 0,
   ul30a         DECIMAL(1,0) DEFAULT 0,
   ul30b         DECIMAL(1,0) DEFAULT 0,
   datum         DATE NOT NULL,

   ico           DECIMAL(10,0) DEFAULT 0,
   suma          DECIMAL(10,2) DEFAULT 0,

   konx          DECIMAL(10,0) DEFAULT 0,
   konx1         DECIMAL(10,0) DEFAULT 0,
   konx2         DECIMAL(10,0) DEFAULT 0,
   konx3         DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctoznamenie_uprzd'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "INSERT INTO F".$kli_vxcf."_uctoznamenie_uprzd (oc,konx1) VALUES ( 9999, 0 ) ";
$vysledok = mysql_query($sql);
}

$sql = "SELECT rxx FROM F".$kli_vxcf."_uctoznamenie_uprzd";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctoznamenie_uprzd ADD rxx DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}

//koniec vytvorenie 
?>

<?php
//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 ) {

$zoema = $fir_riadok->druh;
                    }

if ( $strana == 2 ) {

$rdc3 = $fir_riadok->rdc3;

                    }

if ( $strana == 3 ) {

$rdc3 = $fir_riadok->rdc3;

                    }

mysql_free_result($fir_vysledok);
     }
//koniec nacitania

//udaje o FO z ufirdalsie
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$dmeno = $fir_riadok->dmeno;
$dprie = $fir_riadok->dprie;
$dtitl = $fir_riadok->dtitl;
$dtitz = $fir_riadok->dtitz;
$duli = $fir_riadok->duli;
$dcdm = $fir_riadok->dcdm;
$dmes = $fir_riadok->dmes;
$dpsc = $fir_riadok->dpsc;
$dtel = $fir_riadok->dtel;
$dstat = $fir_riadok->dstat;
if ( $fir_uctt03 != 999 )
{
$dmeno = "";
$dprie = "";
$dtitl = "";
$dtitz = "";
$duli = $fir_fuli;
$dcdm = $fir_fcdm;
$dmes = $fir_fmes;
$dpsc = $fir_fpsc;
$dtel = $fir_ftel;
$dstat = "SK";
}
if ( $fir_uctt03 == 999 )
{
$fir_fnaz = "";
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - DaÚ z motorov˝ch vozidiel</title>
<style type="text/css">
div.sadzby-area {
  position: absolute;
  background-color: #ffff90;
  z-index: 100;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2); /* prefixy */
  padding-bottom: 5px;
}
div.sadzby-area-heading {
  clear: both;
  overflow: auto;
  height: 36px;
}
div.sadzby-area-heading > h1 {
  font-size: 14px;
  text-transform: uppercase;
  margin-top: 14px;
  margin-left: 15px;
}
div.sadzby-area-heading > img {
  width:18px;
  height:18px;
  margin-top: 8px;
  margin-right: 8px;
  opacity: 1; /* prefixy */
  cursor: pointer;
}
div.sadzby-area-heading > img:hover {
  opacity: 0.8; /* prefixy */
}
div.sadzby-area-body {
  clear: both;
}
div.sadzby-area-body > div {
  margin-left: 15px;
}
div.sadzby-section-heading {
  font-size:14px;
  height: 14px;
  padding: 8px 0 2px 0;
  font-weight: bold;
}
table.sadzby {
  background-color: #add8e6;
  margin-right: 15px;
}
table.sadzby caption {
font-size: 14px;
font-weight: ;
text-align: left;
height: 14px;
background-color:;
padding: 8px 0 6px 0;
}
tr.odd {
  background-color: #90ccde;
}
table.sadzby tr td > a {
  height: 24px;
  line-height: 24px;
  background-color: #fff;
  color: #000;
  text-align: right;
  font-weight: bold;
  display: block;
  border-right: 3px solid #add8e6;
  border-bottom: 3px solid #add8e6;
  padding-right: 4px;
}
table.sadzby tr td > a:hover {
  background-color: #eee;
}
table.sadzby th {
  font-size: 11px;
  font-weight: normal;
  padding-top: 3px;
  line-height: 15px;
}
table.sadzby td {
  font-size: 12px;
  text-align: center;
  line-height: 24px;
}
tr.zero-line > td {
  border: 0 !important;
  height: 0 !important;
}
div.wrap-vozidla {
  overflow: auto;
  width: 100%;
  background-color: #fff;
}
table.vozidla {
  width: 900px;
  margin: 16px auto;
  background-color: ;
}
table.vozidla caption {
  height: 20px;
  font-weight: bold;
  font-size: 14px;
  text-align: left;
}
a.btn-item-new {
  position: absolute;
  top: 35px;
  left: 150px;
  cursor: pointer;
  font-weight: bold;
  color: #fff;
  font-size: 10px;
  padding: 8px 12px 7px 12px;
  border-radius: 2px;
  box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.25);
  text-transform: uppercase;
  background-color: #1ccc66;
}
a.btn-item-new:hover {
  background-color: #1abd5f;
}

table.vozidla tr.body:hover {
  background-color: #f1faff;
}
table.vozidla th {
  height: 14px;
  vertical-align: middle;
  font-size: 11px;
  font-weight: bold;
  color: #999;
}
table.vozidla td {
  height: 28px;
  line-height: 28px;
  border-top: 2px solid #add8e6;
  font-size: 14px;
}
table.vozidla td img {
  width: 18px;
  height: 18px;
  vertical-align: text-bottom;
  cursor: pointer;
}
span.text-echo {
  font-size: 18px;
  letter-spacing: 13px;
}
div.input-echo {
  position: absolute;
  font-size: 18px;
  background-color: #fff;
}
.tooltip-body ul li {
  font-size: 13px;
  line-height: 20px;
}
.tooltip-body ul li strong {
  font-size: 14px;
}
</style>

<script type="text/javascript">
<?php
//uprava
  if ( $copern == 20 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 OR $strana == 9999 ) { ?>

   document.formv1.zoema.value = '<?php echo "$zoema";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>

   document.formv1.rdc3.value = '<?php echo "$rdc3";?>';

<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>

   document.formv1.rdc3.value = '<?php echo "$rdc3";?>';

<?php                                        } ?>

   }
<?php
//koniec uprava
  }
?>

<?php if ( $copern != 20 ) { ?>
  function ObnovUI()
  {
  }
<?php                      } ?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function TlacDMV()
  {
   window.open('../ucto/oznamenie_uprzd.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../ucto/oznamenie_uprzd.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self', 'width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes')
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Sadzby2015()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_sadzby.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }


  function VytvorOznamZanik(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/oznamenie_uprzd.php?cislo_oc=<?php echo $cislo_oc;?>&copern=70&drupoh=1&page=1&cislo_cpl='+ cislo_cpl + '&ukoncenie=1',
 '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes' )
  }
  function UpravVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/oznamenie_uprzd.php?copern=346&cislo_cpl='+ cislo_cpl + '&uprav=0', '_self' )
  }
  function ZmazVzd(cpl, cislo_spz)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/oznamenie_uprzd.php?copern=316&cislo_cpl='+ cislo_cpl + '&cislo_spz='+ cislo_spz + '&uprav=0', '_self' )
  }
  function NoveVzd()
  {
   window.open('../ucto/oznamenie_uprzd.php?copern=336&uprav=0', '_self' )
  }
  function DMVdoXML()
  {
   window.open('../ucto/oznamenie_uprzd.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }

<?php if ( $copern == 20 ) { ?>
  function VyberZhasni(sadzba)
  {
   document.formv1.r12.value=sadzba;
   document.getElementById('sadzby').className='hidden';
   document.formv1.r12.focus();
   document.formv1.r12.select();
  }
<?php                      } ?>
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
  if ( $copern == 20 )
  {
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
  </tr>
  <tr>
   <td class="header">Ozn·menie o ˙prave z·kladu dane <?php echo $kli_vrok; ?></td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();"
          title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="DMVdoXML();"
          title="Export do XML" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacDMV();"
          title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="oznamenie_uprzd.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&cislo_cpl=<?php echo $cislo_cpl;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active";

$source="../ucto/oznamenie_uprzd.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">Subjekty</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
<?php if ( $strana != 5 ) { ?> <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave"> <?php } ?>
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16_str1.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 1.strana" class="form-background">


<div class="input-echo" style="width:635px; top:100px; left:52px;"><?php echo $duli; ?></div>

<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16_str2.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 2.strana 380kB" class="form-background">
<span class="text-echo" style="top:75px; left:406px;"><?php echo $fir_fdic;?></span>


<input type="text" name="d3prie" id="d3prie" style="width:359px; top:100px; left:51px;"/>

<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16_str1.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 2.strana 380kB" class="form-background">
<span class="text-echo" style="top:75px; left:406px;"><?php echo $fir_fdic;?></span>


<input type="text" name="d3prie" id="d3prie" style="width:359px; top:100px; left:51px;"/>

<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) {
//VYPIS ZOZNAMU 
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd WHERE oc = 1 ORDER BY ico ";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <a href="#" onclick="NoveVzd();" title="Pridaù subjekt" class="btn-item-new" >+ Vozidlo</a>
<table class="vozidla">
<caption>Zoznam subjektov</caption>
<tr class="zero-line">
 <td style="width:12%;"></td><td style="width:29%;"></td><td style="width:4%;"></td>
 <td style="width:12%;"></td><td style="width:10%;"></td><td style="width:12%;"></td>
 <td style="width:9%;"></td><td style="width:12%;"></td>
</tr>
<tr>
 <th>iËo</th>
 <th>diË</th>
 <th>n·zov</th>
 <th>ulica</th>
 <th>mesto</th>
 <th>suma</th>
</tr>
<?php
$i=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
 {
$rsluz=mysql_fetch_object($sluz);
$cisloi=$i+1;
?>
<tr class="body"> 
 <td align="left"><?php echo $cisloi.". ".$rsluz->ico; ?></td>
 <td><?php echo $dic; ?></td>
 <td align="center"><?php echo $nai; ?></td>
 <td align="center"><?php echo $uli; ?></td>
 <td align="center"><?php echo $mes; ?></td>
 <td align="right" style="">x<?php echo $rsluz->suma; ?></td>
<td align="center">
  <img src="../obr/ikony/pencil_blue_icon.png" onclick="UpravVzd(<?php echo $rsluz->cpl; ?>);"
       title="Upraviù">&nbsp;&nbsp;&nbsp;
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="ZmazVzd(<?php echo $rsluz->cpl; ?>, '<?php echo $rsluz->vzspz; ?>');"
       title="Vymazaù">
 </td>
</tr>
<?php
 }
$i=$i+1;
   }
?>
 </table>
</div>
<?php                                        } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">Subjekty</a>
<?php if ( $strana != 5 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
<?php                     } ?>
</div>

</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
  }
//koniec uprav
?>


<?php
/////////////////////////////////////////////////VYTLAC 
if ( $copern == 10 )
{


$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/oznuprzd_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/oznuprzd_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctoznamenie_uprzd".
" WHERE F$kli_vxcf"."_uctoznamenie_uprzd.oc = 9999 ORDER BY oc";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16_str1.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//kriziky FO,PO a zahr.osoba
$pdf->SetY(45);
$fo="";
$po="x";
$zo="";
if ( $fir_uctt03 == 999 ) { $fo="x"; $po=""; }
if ( $hlavicka->zahos == 1 ) $zo="x";
$pdf->SetX(13);
$pdf->Cell(3,5,"$fo","$rmc",0,"C");
$pdf->SetX(48);
$pdf->Cell(4,5,"$po","$rmc",0,"C");
$pdf->SetX(89);
$pdf->Cell(4,7,"$zo","$rmc",0,"C");


                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16_str2.jpg') )
{
$pdf->Image('../dokumenty/dan_z_prijmov2016/ozn176v16/ozn176_v16_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,0," ","$rmc1",1,"L");
$textxx="0123456789";
$text=$fir_fdic;
$fdicc=1*$fir_fdic;
//if( $fdicc <= 0 ) { $text=$hlavicka->rdc.$hlavicka->rdk; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(81,7," ","$rmc1",0,"R");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",1,"C");

                                       } //koniec 2.strany


}
$i = $i + 1;
  }
$pdf->Output("$outfilex");


?>
<script type="text/javascript"> var okno = window.open("<?php echo $outfilex; ?>","_self"); </script>
<?php


}
//koniec copern 10 VYTLAC
?>



<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("uct_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>