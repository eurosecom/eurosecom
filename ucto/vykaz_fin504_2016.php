<!doctype html>
<HTML>
<?php
//celkovy zaciatok
do
{
$sys = 'UCT';
$urov = 3000;
$copern = $_REQUEST['copern'];

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

//ramcek fpdf 1=zap,0=vyp
$rmc=1;
$rmc1=0;

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2016/fin504/fin5-04_v16";
$jpg_popis="Finanèný výkaz o dlhových nástrojoch a vybraných záväzkoch FIN 5-04 za rok ".$kli_vrok;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=9999;

if ( $cislo_oc == 0 ) $cislo_oc=1;
if ( $cislo_oc == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if ( $cislo_oc == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if ( $cislo_oc == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if ( $cislo_oc == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }


$vsetkyprepocty=0;

//vymaz polozku
if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin504 WHERE cpl = $cislo_cpl";
$oznac = mysql_query("$sqtoz");
$copern=20;

    }
//koniec vymaz polozku

//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {

$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin504 SET ".
" daz='$daz_sql' ".
" WHERE oc = $cislo_oc";

$upravene = mysql_query("$uprtxt");
 
                    }

if ( $strana == 2 ) {

$okres = strip_tags($_REQUEST['okres']);
$obec = strip_tags($_REQUEST['obec']);
$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);
$stlpa = strip_tags($_REQUEST['stlpa']);
$stlpb = strip_tags($_REQUEST['stlpb']);
$stlp1 = strip_tags($_REQUEST['stlp1']);
$stlp2 = strip_tags($_REQUEST['stlp2']);
$stlp3 = strip_tags($_REQUEST['stlp3']);
$stlp4 = strip_tags($_REQUEST['stlp4']);
$stlp5 = strip_tags($_REQUEST['stlp5']);
$stlp1 = str_replace(".","",$stlp1);
$stlp2 = str_replace(".","",$stlp2);

$rs00003 = 1*strip_tags($_REQUEST['rs00003']);
$rs00004 = 1*strip_tags($_REQUEST['rs00004']);

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin504 (oc,druh,stlpa,stlpb,stlp1,stlp2,stlp3,stlp4,stlp5,stlp6,rs00003,rs00004) VALUES ".
" (  '$stvrtrok', 1, '$stlpa', '$stlpb', '$stlp1', '$stlp2', '$stlp3', '$stlp4', '$stlp5', '$stlp6', '$rs00003', '$rs00004' ) ";
if( $stlp5 >= 0 OR $stlp6 >= 0 ) { $upravene = mysql_query("$uprtxt"); } 

                    }


$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov


//prac.subor a subor 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT px01 FROM F".$kli_vxcf."_uctvykaz_fin504";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin504';
$vysledok = mysql_query("$sqlt");


$pocdes="10,0";
$sqlt = <<<mzdprc
(
   cpl         int not null auto_increment,
   px01         DECIMAL($pocdes) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   okres        VARCHAR(11) NOT NULL,
   obec         VARCHAR(11) NOT NULL,
   daz          DATE NOT NULL,
   stlpa        VARCHAR(11) NOT NULL,
   stlpb        VARCHAR(11) NOT NULL,
   stlp1        DECIMAL(4,0) DEFAULT 0,
   stlp2        DECIMAL(4,0) DEFAULT 0,
   stlp3        DECIMAL(10,0) DEFAULT 0,
   stlp4        DATE NOT NULL,
   stlp5        DECIMAL(10,0) DEFAULT 0,
   stlp6        DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin504'.$sqlt;
$vytvor = mysql_query("$vsql");

}
//koniec create

$sql = "SELECT xxb FROM F".$kli_vxcf."_uctvykaz_fin504";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp1 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp2 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp3 VARCHAR(11) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp4 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 MODIFY stlp5 DECIMAL(10,2) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 ADD xxb DECIMAL(10,0) DEFAULT 0 AFTER stlp6";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT rs00004 FROM F".$kli_vxcf."_uctvykaz_fin504";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 ADD rs00003 DECIMAL(10,2) DEFAULT 0 AFTER xxb ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin504 ADD rs00004 DECIMAL(10,2) DEFAULT 0 AFTER xxb ";
$vysledek = mysql_query("$sql");

}
//koniec vytvorenie 


//vypocty
if ( $copern == 10 OR $copern == 20 )
{


}
//koniec vypocty


//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504 WHERE oc = $cislo_oc ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 OR $strana == 9999 )
{
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);
}

if ( $strana == 2 )
{
$r01 = $fir_riadok->r01;

}


mysql_free_result($fir_vysledok);
    }
//koniec nacitania

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }

//skrateny datum k
$skutku=substr($datum,0,6);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>Výkaz FIN 5-04</title>
<style type="text/css">
form input[type=text] {
  height: 20px;
  line-height: 20px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
div.input-echo {
  position: absolute;
  font-size: 16px;
  background-color: #fff;
  font-weight: bold;
}
table.echo-zoznam {
position: absolute; top: 194px; left: 83px;  font-size: 14px;

}
table.echo-zoznam td {
  height: 26px;
  line-height: 26px;
  font-size: 15px;
   border-bottom: 1px solid black;


}


</style>
<script type="text/javascript">
<?php
//uprava sadzby
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.daz.value = '<?php echo $daz_sk;?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>

document.formv1.stlpa.value = '<?php echo $stlpa;?>';
document.formv1.stlpb.value = '<?php echo $stlpb;?>';
document.formv1.stlp1.value = '<?php echo $stlp1;?>';
document.formv1.stlp2.value = '<?php echo $stlp2;?>';
document.formv1.stlp3.value = '<?php echo $stlp3;?>';
document.formv1.stlp4.value = '<?php echo $stlp4;?>';
document.formv1.stlp5.value = '<?php echo $stlp5;?>';

document.formv1.rs00003.value = '<?php echo $rs00003;?>';
document.formv1.rs00004.value = '<?php echo $rs00004;?>';

document.forms.formv1.stlpa.focus();
document.forms.formv1.stlpa.select();
<?php                     } ?>
    }
<?php
//koniec uprava
  }
?>
<?php
  if ( $copern != 20 )
  { 
?>
  function ObnovUI()
  {
  }
<?php
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_vysvetlivky.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('vykaz_fin504_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
 '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Nacitaj()
  {
   window.open('vykaz_fin504_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=0&strana=1',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

function DbfFin204pod16()
                {
window.open('fin204poddbf_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 20 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">FIN 5-04 Dlhové nástroje a vybrané záväzky za
   <span style="color:#39f;"><?php echo "$cislo_oc. štvrrok";?></span>
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie výkazu" class="btn-form-tool">
    <img src="../obr/ikony/upbox_blue_icon.png" onclick="DbfFin204pod16();" title="Export do DBF" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>
<?php if ( $strana < 1 OR $strana > 3 ) $strana=1; ?>

<?php
$sirka=950;
$vyska=1300;
if ( $strana == 2 )
{
$sirka=1250; $vyska=920;
}
?>
<div id="content" style="width:<?php echo $sirka; ?>px; height:<?php echo $vyska; ?>px;">
<FORM name="formv1" method="post" action="../ucto/vykaz_fin504_2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="vykaz_fin504_2016.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">2</a>

<?php
$alertnacitaj="";
if ( $nacitavamhodnoty == 1 ) { $alertnacitaj="!!! Údaje sú naèítané !!!"; }
?>
 <div class="alert-pocitam"><?php echo $alertnacitaj; ?></div>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 265kB">

<span class="text-echo" style="top:153px; left:403px;"><?php echo $datum; ?></span>
<span class="text-echo" style="top:361px; left:141px;">x</span>
<span class="text-echo" style="top:516px; left:141px; letter-spacing:13.5px;"><?php echo $fir_ficox; ?></span>
<span class="text-echo" style="top:516px; left:342px; letter-spacing:14px;"><?php echo $mesiac; ?></span>
<span class="text-echo" style="top:516px; left:409px; letter-spacing:13.5px;"><?php echo $kli_vrok; ?></span>
<div class="input-echo" style="width:687px; top:574px; left:135px; height:40px; line-height:40px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="width:687px; top:655px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_uctt02; ?></div>
<div class="input-echo" style="width:687px; top:735.5px; left:135px; height:39.5px; line-height:39.5px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="width:105px; top:816.5px; left:135px; height:19px; line-height:19px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="width:553px; top:816.5px; left:269px; height:39.5px; line-height:39.5px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="width:687px; top:898px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_fem1; ?></div>
<input type="text" name="daz" id="daz" onkeyup="CiarkaNaBodku(this);"
       style="width:80px; top:966px; left:236px; height:22px; line-height:22px; font-size:14px; padding-left:4px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2_form.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 265kB" style="width:1250px; height:1000px;">

<table class="echo-zoznam" style="">
<?php
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504  ".
" WHERE oc >= 0 AND druh = 1 ORDER BY cpl ";

$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);
?>
<tr>
 <td class="center" style="width:190px; background-color:;"><?php echo $rsluz->stlpa; ?></td>
 <td class="center" style="width:94px; background-color:;"><?php echo $rsluz->stlpb; ?></td>
 <td class="center" style="width:117px; background-color:;"><?php echo $rsluz->stlp1; ?></td>
 <td class="center" style="width:117px; background-color:;"><?php echo $rsluz->stlp2; ?></td>
 <td class="center" style="width:93px; background-color:;"><?php echo $rsluz->stlp3; ?></td>
 <td class="right" style="width:118px; background-color:;"><?php echo $rsluz->stlp4; ?>&nbsp;&nbsp;</td>
 <td class="right" style="width:118px; background-color:;"><?php echo $rsluz->stlp5; ?>&nbsp;&nbsp;</td>
 <td class="right" style="width:118px; background-color:;"><?php echo $rsluz->rs00003; ?>&nbsp;&nbsp;</td>
 <td class="right" style="width:118px; background-color:;"><?php echo $rsluz->rs00004; ?>&nbsp;&nbsp;</td>
 <td class="center" style="width:44px; background-color:; border:0;">
 <a href='vykaz_fin504_2016.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>'>
<img src="../obr/ikony/xmark_lred_icon.png" title="Vymaza riadok" style="width:16px; height:16px;"></a> <!-- dopyt, nemôže by cez <img> ? -->
</td> <!-- dopyt, zobrazuje sa img, aj keï nie sú uložené údaje -->

</tr>
<?php
}
$i = $i + 1;
$j = $j + 1;
  }
?>
</table>
<?php
$topx=291+$cpol*28;
//191
//$topx0=802+$cpol*28;
//$topx1=830+$cpol*28;
//$topx2=840+$cpol*28;
//$cpol=1;
$topx=200+25*$i;
?>
<input type="text" name="stlpa" id="stlpa" style="width:174px; top:<?php echo $topx;?>px; left:89px;"/> <!-- dopyt, nedáme cez select? -->
<input type="text" name="stlpb" id="stlpb" style="width:78px; top:<?php echo $topx;?>px; left:278px;"/> <!-- dopyt, nedáme cez select? -->
<input type="text" name="stlp1" id="stlp1" onkeyup="CiarkaNaBodku(this);" style="width:104px; top:<?php echo $topx;?>px; left:370px;"/>
<input type="text" name="stlp2" id="stlp2" onkeyup="CiarkaNaBodku(this);" style="width:104px; top:<?php echo $topx;?>px; left:488px;"/>
<input type="text" name="stlp3" id="stlp3" style="width:78px; top:<?php echo $topx;?>px; left:606px;"/> <!-- dopyt, nedáme cez select? -->
<input type="text" name="stlp4" id="stlp4" onkeyup="CiarkaNaBodku(this);" style="width:104px; top:<?php echo $topx;?>px; left:698px;"/>
<input type="text" name="stlp5" id="stlp5" onkeyup="CiarkaNaBodku(this);" style="width:103px; top:<?php echo $topx;?>px; left:817px;"/>
<input type="text" name="rs00003" id="rs00003" onkeyup="CiarkaNaBodku(this);" style="width:104px; top:<?php echo $topx;?>px; left:934px;"/>
<input type="text" name="rs00004" id="rs00004" onkeyup="CiarkaNaBodku(this);" style="width:104px; top:<?php echo $topx;?>px; left:1052px;"/>


<?php
//uhrn
$uhrn1=1100;
$uhrn2=1200;
$uhrn3=1300;
$uhrn4=1400;
$topx=300+25*$i;
?>
<tr>
 <td class="center" style="width:190px; background-color:;"><?php echo $uhrn1; ?></td>
 <td class="center" style="width:94px; background-color:;"><?php echo $uhrn2; ?></td>
 <td class="center" style="width:117px; background-color:;"><?php echo $uhrn3; ?></td>
 <td class="center" style="width:117px; background-color:;"><?php echo $uhrn4; ?></td>
</tr>



<?php                     } ?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloži zmeny" class="btn-bottom-formsave">
</div>

</FORM>
</div> <!-- #content -->
<?php
     }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC
if ( $copern == 10 )
{
$hhmmss = Date ("is", MkTime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")) );

 $outfilexdel="../tmp/vykfin_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/vykfin_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504";
$vytvor = mysql_query("$vsql");

//sumare
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,".
" '','',stlp1,stlp2,stlp3,SUM(stlp4),SUM(stlp5),SUM(stlp6),0,rs00003,rs00004 ".
" FROM F$kli_vxcf"."_uctvykaz_fin504".
" WHERE druh = 1 ".
" GROUP BY druh ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprcvykazx".$kli_uzid." ".
" WHERE F$kli_vxcf"."_uctprcvykazx$kli_uzid.oc >= 0  ORDER BY px01,cpl ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//prva strana
if ( $i == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//obdobie k
$text=$datum;
$pdf->Cell(195,19," ","$rmc1",1,"L");
$pdf->Cell(78,6," ","$rmc1",0,"R");$pdf->Cell(22,4,"$text","$rmc",1,"C");

//druh vykazu krizik
$text="x";
$pdf->Cell(195,44.5," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//ico
$text=$fir_fico;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(195,31.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"R");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
//mesiac
$text=$mesiac;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",1,"C");

//nazov subjektu
$text=$fir_fnaz;
$textx="0123456789abcdefghijklmnoprstuv";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=substr($fir_fnaz,31,30);;
$text="Èý0123456789abcdefghijklmnoprstuv";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//pravna forma
$text=$fir_uctt02;
$textx="0123456789abcdefghijklmnoprstuv";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//ulica a cislo
$text=$fir_fuli." ".$fir_fcdm;
$textx="0123456789abcdefghijklmnoprstuv";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,13.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=" ";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//psc
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");
//obec
$text=$fir_fmes;
$textx="123456789abcdefghijklmnov";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");
//
$text=" ";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$pdf->Cell(49,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");

//email
$text=$fir_fem1;
$textx="0123456789abcdefghijklmnoprstuv";
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
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//datum zostavenia
$daz= SkDatum($hlavicka->daz);
if ( $daz == '00.00.0000' ) $daz="";
$pdf->Cell(195,12," ","$rmc1",1,"L");
$pdf->Cell(40,5," ","$rmc1",0,"C");$pdf->Cell(22,4,"$daz","$rmc",1,"C");
//koniec prva strana


$pdf->AddPage(L);
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str2.jpg') )
{
$pdf->Image($jpg_cesta.'_str2.jpg',5,0,305,200);
}
$pdf->SetY(10);

                                       } //dopyt, preèo je to zátvorka až nemá by vyššie? inde to tak máme, a druhá strana nie je oddelená



$stlpa=$hlavicka->stlpa;
$stlpb=$hlavicka->stlpb;
$stlp1=$hlavicka->stlp1;
$stlp2=$hlavicka->stlp2;
$stlp3=$hlavicka->stlp3;
$stlp4=$hlavicka->stlp4;
if( $hlavicka->stlp4 == 0 ) $stlp4="";
$stlp5=$hlavicka->stlp5;
if( $hlavicka->stlp5 == 0 ) $stlp5="";
$stlp6=$hlavicka->stlp6;
if( $hlavicka->stlp6 == 0 ) $stlp6="";

if( $hlavicka->px01 == 0 AND $i <= 7 )
  {
$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->Cell(25,6,"$stlpa","$rmc",0,"L");$pdf->Cell(25,6,"$stlpb","$rmc",0,"C");$pdf->Cell(26,6,"$stlp1","$rmc",0,"C");$pdf->Cell(25,6,"$stlp2","$rmc",0,"C");
$pdf->Cell(25,6,"$stlp3","$rmc",0,"C");$pdf->Cell(26,6,"$stlp4 ","$rmc",0,"R");$pdf->Cell(25,6,"$stlp5 ","$rmc",1,"R");
  }

if( $hlavicka->px01 == 0 AND $i > 7 )
  {
$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->Cell(25,6,"$stlpa","1",0,"L");$pdf->Cell(25,6,"$stlpb","1",0,"C");$pdf->Cell(26,6,"$stlp1","1",0,"C");$pdf->Cell(25,6,"$stlp2","1",0,"C");
$pdf->Cell(25,6,"$stlp3","1",0,"C");$pdf->Cell(26,6,"$stlp4 ","1",0,"R");$pdf->Cell(25,6,"$stlp5 ","1",1,"R");
  }

if( $hlavicka->px01 == 1 )
  {
if( $pol <= 8 ) { $pdf->SetY(85); }
$pdf->Cell(195,1,"                          ","$rmc",1,"L");
$pdf->Cell(9,6," ","$rmc",0,"C");
$pdf->SetFont('arial','B',10);
$pdf->Cell(126,6,"Úhrn","$rmc",0,"L");$pdf->Cell(26,6,"$stlp4","$rmc",0,"R");$pdf->Cell(25,6,"$stlp5","$rmc",1,"R");
  }




}
$i = $i + 1;
  }
$pdf->Output("$outfilex");
?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA 
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec
$cislista = include("uct_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>