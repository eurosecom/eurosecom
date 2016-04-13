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


//uprav 
    if ( $copern == 346 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$copern=20;
$strana=3;
$zoznamaut=0;
    }
//koniec uprav 

//nove 
    if ( $copern == 336 )
    {
$sql = "INSERT INTO F".$kli_vxcf."_ucthlasenie_euler (oc,konx1) VALUES ( 1, 0 ) ";
$vysledok = mysql_query($sql);

$cislo_cpl=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler WHERE oc = 1 ORDER BY cpl DESC LIMIT 1";
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
//koniec nove 

//zmaz 
    if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$cislo_spz = $_REQUEST['cislo_spz'];
?>
<script type="text/javascript">
if( !confirm ("Chcete zmazaù vozidlo <?php echo $cislo_spz; ?> ?") )
         { location.href='hlasenie_euler.php?cislo_oc=9999&drupoh=1&page=1&subor=0&copern=20&strana=5' }
else
         { location.href='hlasenie_euler.php?copern=3166&page=1&drupoh=1&cislo_cpl=<?php echo $cislo_cpl; ?>' }
</script>
<?php
exit;                      
    }

    if ( $copern == 3166 )
    {

$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$sql = "DELETE FROM F".$kli_vxcf."_ucthlasenie_euler WHERE cpl = $cislo_cpl ";
$vysledok = mysql_query($sql);

$copern=20;
$strana=5;
$zoznamaut=1;
    }
//zmaz 



//zapis upravene udaje
if ( $copern == 23 )
     {
if ( $strana == 1 ) {
$druh = strip_tags($_REQUEST['druh']);
$rdc = strip_tags($_REQUEST['rdc']);
$rdk = strip_tags($_REQUEST['rdk']);
$zoo = strip_tags($_REQUEST['zoo']);
$zoosql=SqlDatum($zoo);
$zod = strip_tags($_REQUEST['zod']);
$zodsql=SqlDatum($zod);
$dar = strip_tags($_REQUEST['dar']);
$darsql=SqlDatum($dar);
$ddp = strip_tags($_REQUEST['ddp']);
$ddpsql=SqlDatum($ddp);
$fod = strip_tags($_REQUEST['fod']);
$zahos = 1*$_REQUEST['zahos'];
$zouli = strip_tags($_REQUEST['zouli']);
$zocdm = strip_tags($_REQUEST['zocdm']);
$zopsc = strip_tags($_REQUEST['zopsc']);
$zomes = strip_tags($_REQUEST['zomes']);
$zotel = strip_tags($_REQUEST['zotel']);
$zoema = strip_tags($_REQUEST['zoema']);
if ( $zoosql == '0000-00-00' ) { $zoosql=$kli_vrok."-01-01"; }
if ( $zodsql == '0000-00-00' ) { $zodsql=$kli_vrok."-12-31"; }

$uprtxt = "UPDATE F$kli_vxcf"."_ucthlasenie_euler SET ".
" dar='$darsql', ddp='$ddpsql', zoo='$zoosql', zod='$zodsql', fod='$fod', ".
" rdc='$rdc', rdk='$rdk', druh='$druh', zahos='$zahos', ".
" zouli='$zouli', zocdm='$zocdm', zopsc='$zopsc', zomes='$zomes', zotel='$zotel', zoema='$zoema' ".
" WHERE oc = 9999 ";
                    }

if ( $strana == 2 ) {
$druh31 = strip_tags($_REQUEST['druh31']);
$druh32 = strip_tags($_REQUEST['druh32']);
$druh33 = strip_tags($_REQUEST['druh33']);
$druh34 = strip_tags($_REQUEST['druh34']);
//$druh35 = strip_tags($_REQUEST['druh35']);
$dedic = strip_tags($_REQUEST['dedic']);
$likvi = strip_tags($_REQUEST['likvi']);
$druh3=0;
if ( $druh31 == 1 ) { $druh3=1; }
if ( $druh32 == 1 ) { $druh3=2; }
if ( $druh33 == 1 ) { $druh3=3; }
if ( $druh34 == 1 ) { $druh3=4; }
//if ( $druh35 == 1 ) { $druh3=5; }
if ( $dedic == 1 ) { $druh3=6; }
if ( $likvi == 1 ) { $druh3=7; }
$rdc3 = strip_tags($_REQUEST['rdc3']);
$rdk3 = strip_tags($_REQUEST['rdk3']);
$naz3 = strip_tags($_REQUEST['naz3']);
$dic3 = strip_tags($_REQUEST['dic3']);
$d3meno = strip_tags($_REQUEST['d3meno']);
$d3prie = strip_tags($_REQUEST['d3prie']);
$d3titl = strip_tags($_REQUEST['d3titl']);
$d3titz = strip_tags($_REQUEST['d3titz']);
$d3uli = strip_tags($_REQUEST['d3uli']);
$d3cdm = strip_tags($_REQUEST['d3cdm']);
$d3psc = strip_tags($_REQUEST['d3psc']);
$d3mes = strip_tags($_REQUEST['d3mes']);
$d3tel = strip_tags($_REQUEST['d3tel']);
$d3fax = strip_tags($_REQUEST['d3fax']);
$xstat3 = strip_tags($_REQUEST['xstat3']);
$dar3 = strip_tags($_REQUEST['dar3']);
$dar3sql=SqlDatum($dar3);

$uprtxt = "UPDATE F$kli_vxcf"."_ucthlasenie_euler SET ".
" rdc3='$rdc3', rdk3='$rdk3', dic3='$dic3', d3meno='$d3meno', d3prie='$d3prie', ".
" d3titl='$d3titl', d3titz='$d3titz', dar3='$dar3sql', xstat3='$xstat3', ".
" druh3='$druh3', d3uli='$d3uli', d3cdm='$d3cdm', d3psc='$d3psc', d3mes='$d3mes', ".
" d3tel='$d3tel', d3fax='$d3fax', naz3='$naz3', dedic='$dedic', likvi='$likvi' ".
" WHERE oc = 9999 ";

                    }

if ( $strana == 3 ) {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$ico = strip_tags($_REQUEST['ico']);

$uprtxt = "UPDATE F$kli_vxcf"."_ucthlasenie_euler SET ".
" ico='$ico'  ".
" WHERE oc = 1 AND cpl = $cislo_cpl ";

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

//vypocty



//koniec vypocty


//prac.subor a subor vytvorenych rocnych
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sql = "SELECT px03 FROM F".$kli_vxcf."_ucthlasenie_euler";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_ucthlasenie_euler';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   cpl          int not null auto_increment,
   oc           DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(10,0) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   dsuma        DECIMAL(10,2) DEFAULT 0,
   konx1        DECIMAL(10,0) DEFAULT 0,
   px03         DECIMAL(10,2) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_ucthlasenie_euler'.$sqlt;
$vytvor = mysql_query("$vsql");

$sql = "INSERT INTO F".$kli_vxcf."_ucthlasenie_euler (oc,konx1) VALUES ( 9999, 0 ) ";
$vysledok = mysql_query($sql);
}
//koniec vytvorenie priznaniedmv



//koniec uprav def. tabulky
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");


?>

<?php
//nacitaj udaje pre upravu
if ( $copern == 20 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler".
" WHERE oc = 9999 ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if ( $strana == 1 ) {
$druh = $fir_riadok->druh;
$dar = $fir_riadok->dar;
$darsk=SkDatum($dar);
$zoo = $fir_riadok->zoo;
$zoosk=SkDatum($zoo);
$zod = $fir_riadok->zod;
$zodsk=SkDatum($zod);
$ddp = $fir_riadok->ddp;
$ddpsk=SkDatum($ddp);
$fod = $fir_riadok->fod;
$zahos = 1*$fir_riadok->zahos;
$zouli = $fir_riadok->zouli;
$zocdm = $fir_riadok->zocdm;
$zopsc = $fir_riadok->zopsc;
$zomes = $fir_riadok->zomes;
$zotel = $fir_riadok->zotel;
$zoema = $fir_riadok->zoema;
                    }

if ( $strana == 2 ) {
$druh3 = $fir_riadok->druh3;
$rdc3 = $fir_riadok->rdc3;
$rdk3 = $fir_riadok->rdk3;
$naz3 = $fir_riadok->naz3;
$dic3 = $fir_riadok->dic3;
$d3meno = $fir_riadok->d3meno;
$d3prie = $fir_riadok->d3prie;
$d3titl = $fir_riadok->d3titl;
$xstat3 = $fir_riadok->xstat3;
$d3uli = $fir_riadok->d3uli;
$d3cdm = $fir_riadok->d3cdm;
$d3psc = $fir_riadok->d3psc;
$d3mes = $fir_riadok->d3mes;
$d3tel = $fir_riadok->d3tel;
$d3fax = $fir_riadok->d3fax;
$dar3 = $fir_riadok->dar3;
$dar3sk=SkDatum($dar3);
$d3titz = $fir_riadok->d3titz;
$dedic = $fir_riadok->dedic;
$likvi = $fir_riadok->likvi;
                    }

if ( $strana == 3 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler".
" WHERE cpl = $cislo_cpl ORDER BY oc";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$ico = $fir_riadok->ico;


}


mysql_free_result($fir_vysledok);
     }
//koniec nacitania

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Euler</title>
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
<?php if ( $druh == 0 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 1 ) { ?> document.formv1.druh1.checked = 'true'; <?php } ?>
<?php if ( $druh == 2 ) { ?> document.formv1.druh2.checked = 'true'; <?php } ?>
<?php if ( $druh == 3 ) { ?> document.formv1.druh3.checked = 'true'; <?php } ?>
<?php if ( $zahos == 1 ) { ?> document.formv1.zahos.checked = 'checked'; <?php } ?>
   document.formv1.dar.value = '<?php echo "$darsk";?>';
   document.formv1.zoo.value = '<?php echo "$zoosk";?>';
   document.formv1.zod.value = '<?php echo "$zodsk";?>';
   document.formv1.ddp.value = '<?php echo "$ddpsk";?>';
   document.formv1.fod.value = '<?php echo "$fod";?>';
   document.formv1.zouli.value = '<?php echo "$zouli";?>';
   document.formv1.zocdm.value = '<?php echo "$zocdm";?>';
   document.formv1.zopsc.value = '<?php echo "$zopsc";?>';
   document.formv1.zomes.value = '<?php echo "$zomes";?>';
   document.formv1.zotel.value = '<?php echo "$zotel";?>';
   document.formv1.zoema.value = '<?php echo "$zoema";?>';
<?php                                        } ?>

<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<?php if ( $druh3 == 1 ) { ?>document.formv1.druh31.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 2 ) { ?>document.formv1.druh32.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 3 ) { ?>document.formv1.druh33.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 4 ) { ?>document.formv1.druh34.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 6 ) { ?>document.formv1.dedic.checked = 'true'; <?php } ?>
<?php if ( $druh3 == 7 ) { ?>document.formv1.likvi.checked = 'true'; <?php } ?>
   document.formv1.rdc3.value = '<?php echo "$rdc3";?>';
   document.formv1.naz3.value = '<?php echo "$naz3";?>';
   document.formv1.rdk3.value = '<?php echo "$rdk3";?>';
   document.formv1.dar3.value = '<?php echo "$dar3sk";?>';
   document.formv1.dic3.value = '<?php echo "$dic3";?>';
   document.formv1.d3prie.value = '<?php echo "$d3prie";?>';
   document.formv1.d3meno.value = '<?php echo "$d3meno";?>';
   document.formv1.d3titl.value = '<?php echo "$d3titl";?>';
   document.formv1.d3uli.value = '<?php echo "$d3uli";?>';
   document.formv1.d3cdm.value = '<?php echo "$d3cdm";?>';
   document.formv1.d3psc.value = '<?php echo "$d3psc";?>';
   document.formv1.d3mes.value = '<?php echo "$d3mes";?>';
   document.formv1.d3tel.value = '<?php echo "$d3tel";?>';
   document.formv1.d3fax.value = '<?php echo "$d3fax";?>';
   document.formv1.xstat3.value = '<?php echo "$xstat3";?>';
   document.formv1.d3titz.value = '<?php echo "$d3titz";?>';
<?php                                        } ?>

<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
   document.formv1.ico.value = '<?php echo "$ico";?>';
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
   window.open('../ucto/hlasenie_euler.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMinRok()
  {
   window.open('../ucto/hlasenie_euler.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1', '_self', 'width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes')
  }
  function PoucVyplnenie()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_poucenie.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function Sadzby2015()
  {
   window.open('../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_sadzby.pdf', '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function cezucet()
  {
   document.formv1.post.checked = false;
  }
  function cezpostu()
  {
   document.formv1.ucet.checked = false;
  }

  function vypocetMes()
  {
   window.open('../ucto/hlasenie_euler.php?copern=346&cislo_cpl=<?php echo $cislo_cpl;?>&uprav=0&pocetdni=1', '_self');
  }
  function vypocitajDan()
  {
   window.open('../ucto/hlasenie_euler.php?copern=346&cislo_cpl=<?php echo $cislo_cpl;?>&uprav=0&vypocitajdan=1', '_self');
  }
  function vypocitajPredpoDan()
  {
   window.open('hlasenie_euler.php?copern=20&strana=4&predpoklad=1', '_self');
  }
  function dajSadzbu()
  {
   window.open('hlasenie_euler.php?copern=20&cislo_cpl=<?php echo $cislo_cpl;?>&dajsadzbu=1', '_self');
  }
  function dajVsetky()
  {
   window.open('hlasenie_euler.php?copern=2020&cislo_cpl=0&dajsadzbu=1&dajvsetky=1', '_self');
  }
  function VytvorOznamZanik(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/hlasenie_euler.php?cislo_oc=<?php echo $cislo_oc;?>&copern=70&drupoh=1&page=1&cislo_cpl='+ cislo_cpl + '&ukoncenie=1',
 '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes' )
  }
  function UpravVzd(cpl)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/hlasenie_euler.php?copern=346&cislo_cpl='+ cislo_cpl + '&uprav=0', '_self' )
  }
  function ZmazVzd(cpl, cislo_spz)
  {
   var cislo_cpl = cpl;
   window.open('../ucto/hlasenie_euler.php?copern=316&cislo_cpl='+ cislo_cpl + '&cislo_spz='+ cislo_spz + '&uprav=0', '_self' )
  }
  function NoveVzd()
  {
   window.open('../ucto/hlasenie_euler.php?copern=336&uprav=0', '_self' )
  }
  function DMVdoXML()
  {
   window.open('../ucto/priznaniedmv_xml2015.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1',
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
   <td class="header">Euler <?php echo $kli_vrok; ?></td>
   <td>
    <div class="bar-btn-form-tool">
     <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajMinRok();"
          title="NaËÌtaù ˙daje z minulÈho roka" class="btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="Sadzby2015();"
          title="RoËnÈ sadzby dane" class="btn-form-tool">
     <img src="../obr/ikony/info_blue_icon.png" onclick="PoucVyplnenie();"
          title="PouËenie na vyplnenie" class="btn-form-tool">
<?php if ( $strana == 5 ) { ?>
    <img src="../obr/ikony/calculator_blue_icon.png" onclick="dajVsetky();"
      title="Pre VäETKY VOZIDL¡ doplniù sadzbu dane do r. 12 podæa druhu vozidla,
             +nastaviù r.13 checkbox,
             +vypoËÌtaù poËet mesiacov r.19,
             +vypoËÌtaù r.14,16,18,20,21" class="btn-form-tool">
<?php                     } ?>
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
<FORM name="formv1" method="post" action="hlasenie_euler.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&cislo_cpl=<?php echo $cislo_cpl;?>&strana=<?php echo $strana;?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active"; if ( $strana == 3 ) $clas3="active";
if ( $strana == 4 ) $clas4="active"; if ( $strana == 5 ) $clas5="active";

$source="../ucto/hlasenie_euler.php?cislo_oc=".$cislo_oc."&drupoh=1&page=1&subor=0";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">Odberatelia</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=3', '_blank');" class="<?php echo $clas3; ?> toright">3</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=2', '_blank');" class="<?php echo $clas2; ?> toright">2</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=10&strana=1', '_blank');" class="<?php echo $clas1; ?> toright">1</a>
 <h6 class="toright">TlaËiù:</h6>
<?php if ( $strana != 5 ) { ?> <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave"> <?php } ?>
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str1.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 1.strana" class="form-background">

<span class="text-echo" style="top:223px; left:61px;"><?php if ( $fir_uctt03 == 999 ) echo "x"; ?></span>
<span class="text-echo" style="top:223px; left:222px;"><?php if ( $fir_uctt03 != 999 ) echo "x"; ?></span>
<input type="checkbox" name="zahos" value="1" style="top:229px; left:401px;"/>
<span class="text-echo" style="top:293px; left:56px;"><?php echo $fir_fdic;?></span>
<input type="text" name="dar" id="dar" disabled="disabled" class="nofill" style="width:195px; top:342px; left:51px;"/>
<!-- Druh priznania -->
<input type="radio" id="druh1" name="druh" value="1" style="top:290px; left:423px;"/>
<input type="radio" id="druh2" name="druh" value="2" style="top:315px; left:423px;"/>
<input type="radio" id="druh3" name="druh" value="3" style="top:340px; left:423px;"/>
<!-- Za zdanovacie obdobie -->
<input type="text" name="zoo" id="zoo" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:232px; left:696px;"/>
<input type="text" name="zod" id="zod" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:274px; left:696px;"/>
<input type="text" name="ddp" id="ddp" onkeyup="CiarkaNaBodku(this);" style="width:196px; top:343px; left:696px;"/>

<!-- I. ODDIEL -->
<!-- Udaje o FO -->
<div class="input-echo" style="width:359px; top:455px; left:52px;"><?php echo $dprie; ?></div>
<div class="input-echo" style="width:244px; top:455px; left:432px;"><?php echo $dmeno; ?></div>
<div class="input-echo" style="width:112px; top:455px; left:696px;"><?php echo $dtitl; ?></div>
<div class="input-echo" style="width:68px; top:455px; left:828px;"><?php echo $dtitz; ?></div>
<input type="text" name="fod" id="fod" style="width:842px; top:510px; left:51px;"/>
<!-- Udaje o PO -->
<div class="input-echo" style="width:842px; top:589px; left:52px;"><?php echo $fir_fnaz; ?></div>
<!-- Adresa -->
<div class="input-echo" style="width:635px; top:702px; left:52px;"><?php echo $duli; ?></div>
<div class="input-echo" style="width:175px; top:702px; left:718px;"><?php echo $dcdm; ?></div>
<div class="input-echo" style="width:107px; top:758px; left:52px;"><?php echo $dpsc; ?></div>
<div class="input-echo" style="width:451px; top:758px; left:178px;"><?php echo $dmes; ?></div>
<div class="input-echo" style="width:245px; top:758px; left:649px;"><?php echo $dstat; ?></div>
<div class="input-echo" style="width:290px; top:812px; left:52px;"><?php echo $dtel; ?></div>
<div class="input-echo" style="width:521px; top:812px; left:361px;"><?php echo $fir_fem1; ?></div>
<!-- Adresa organizacnej zlozky -->
<input type="text" name="zouli" id="zouli" style="width:635px; top:890px; left:51px;"/>
<input type="text" name="zocdm" id="zocdm" style="width:175px; top:890px; left:718px;"/>
<input type="text" name="zopsc" id="zopsc" style="width:107px; top:946px; left:51px;"/>
<input type="text" name="zomes" id="zomes" style="width:451px; top:946px; left:178px;"/>
<input type="text" name="zotel" id="zotel" style="width:290px; top:1001px; left:51px;"/>
<input type="text" name="zoema" id="zoema" style="width:522px; top:1001px; left:370px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str2.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 2.strana 380kB" class="form-background">
<span class="text-echo" style="top:75px; left:406px;"><?php echo $fir_fdic;?></span>

<!-- II. ODDIEL -->
<input type="checkbox" name="druh31" id="druh31" value="1" onclick="klik31();"
       style="top:157px; left:68px;"/>
<input type="checkbox" name="dedic" id="dedic" value="1" onclick="klik36();"
       style="top:183px; left:68px;"/>
<input type="checkbox" name="druh33" id="druh33" value="1" onclick="klik33();"
       style="top:208px; left:68px;"/>
<input type="checkbox" name="likvi" id="likvi" value="1" onclick="klik37();"
       style="top:157px; left:470px;"/>
<input type="checkbox" name="druh32" id="druh32" value="1" onclick="klik32();"
       style="top:183px; left:470px;"/>
<input type="checkbox" name="druh34" id="druh34" value="1" onclick="klik34();"
       style="top:208px; left:470px;"/>
<input type="text" name="d3prie" id="d3prie" style="width:359px; top:262px; left:51px;"/>
<input type="text" name="d3meno" id="d3meno" style="width:244px; top:262px; left:430px;"/>
<input type="text" name="d3titl" id="d3titl" style="width:111px; top:262px; left:695px;"/>
<input type="text" name="d3titz" id="d3titz" style="width:68px; top:262px; left:827px;"/>
<input type="text" name="rdc3" id="rdc3" style="width:129px; top:319px; left:51px;"/>
<input type="text" name="rdk3" id="rdk3" style="width:84px; top:319px; left:212px;"/>
<input type="text" name="dar3" id="dar3" onkeyup="CiarkaNaBodku(this);" style="width:198px; top:319px; left:327px;"/>
<input type="text" name="dic3" id="dic3" style="width:221px; top:319px; left:568px;"/>
<input type="text" name="naz3" id="naz3" style="width:842px; top:374px; left:51px;"/>
<input type="text" name="d3uli" id="d3uli" style="width:635px; top:451px; left:51px;"/>
<input type="text" name="d3cdm" id="d3cdm" style="width:175px; top:451px; left:718px;"/>
<input type="text" name="d3psc" id="d3psc" style="width:107px; top:505px; left:51px;"/>
<input type="text" name="d3mes" id="d3mes" style="width:451px; top:505px; left:178px;"/>
<input type="text" name="xstat3" id="xstat3" style="width:245px; top:505px; left:648px;"/>
<input type="text" name="d3tel" id="d3tel" style="width:290px; top:562px; left:51px;"/>
<input type="text" name="d3fax" id="d3fax" style="width:522px; top:562px; left:370px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 ) { ?>
<img src="../dokumenty/dan_z_prijmov2015/dpdmv2015/dmv_v15_str3.jpg"
     alt="tlaËivo DaÚ z motorov˝ch vozidiel pre rok 2015 3.strana 380kB" class="form-background">
<span class="text-echo" style="top:75px; left:458px;"><?php echo $fir_fdic; ?></span>

<input type="text" name="ico" id="ico" value="<?php echo $da1sk; ?>"
       onkeyup="CiarkaNaBodku(this);" style="width:196px; top:162px; left:381px;"/>


<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) {
//VYPIS ZOZNAMU VOZIDIEL
$sluztt = "SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler WHERE oc = 1 ORDER BY ico ";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>
<div class="wrap-vozidla">
 <a href="#" onclick="NoveVzd();" title="Pridaù vozidlo" class="btn-item-new" >+ Vozidlo</a>
<table class="vozidla">
<caption>Zoznam odberateæov</caption>
<tr class="zero-line">
 <td style="width:12%;"></td><td style="width:29%;"></td><td style="width:4%;"></td>
 <td style="width:12%;"></td><td style="width:10%;"></td><td style="width:12%;"></td>
 <td style="width:9%;"></td><td style="width:12%;"></td>
</tr>
<tr>
 <th rowspan="2">iËo</th>
 <th rowspan="2" align="left">ZnaËka</th>
 <th rowspan="2">Katg.</th>
 <th>Prv·</th>
 <th colspan="2">DaÚov· povinnosù</th>
 <th rowspan="2" align="right">DaÚ</th>
 <th rowspan="2">&nbsp;</th>
</tr>
<tr>
 <th style="padding-bottom:1px;">evidencia</th>
 <th style="padding-bottom:1px;">Vznik</th>
 <th style="padding-bottom:1px;">Z·nik</th>
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
 <td><?php echo $rsluz->vzzn; ?></td>
 <td align="center"><?php echo $rsluz->vzkat; ?></td>
 <td align="center">
<?php if ( SkDatum($rsluz->da1) == '00.00.0000' ) { ?>
 <img src="../obr/pozor.png" style="width:14px; height:14px;"
      title="Pozor, nie je vyplnen˝ d·tum prvej evidencie. Program nevypoËÌta spr·vne v˝öku dane">
<?php                                             } ?>
<?php echo SkDatum($rsluz->da1); ?>
 </td>
 <td align="center"><?php echo SkDatum($rsluz->datz); ?></td>
 <td align="center">
  <img src="../obr/ikony/list_blue_icon.png" onclick="VytvorOznamZanik(<?php echo $rsluz->cpl; ?>);"
       title="Vytvoriù ozn·menie o z·niku daÚovej povinnosti">
    <?php echo SkDatum($rsluz->datk); ?>
 </td>
 <td align="right" style=""><?php echo $rsluz->r21; ?></td>
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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=5', '_self');" class="<?php echo $clas5; ?> toleft">Odberatelia</a>
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
$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/euler_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/euler_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_ucthlasenie_euler".
" WHERE F$kli_vxcf"."_ucthlasenie_euler.oc = 1 ORDER BY ico ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


if ( $strana == 1 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/statistika2016/hlasenie_pohladavok/hlasenie_euler_str1.jpg') )
{
$pdf->Image('../dokumenty/statistika2016/hlasenie_pohladavok/hlasenie_euler_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic 
$pdf->Cell(195,20," ","$rmc1",1,"L");
$textxx="0123456789";
$text=$hlavicka->ico;
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

                                       } //koniec 1.strany

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/statistika2016/hlasenie_pohladavok/hlasenie_euler_str2.jpg') )
{
$pdf->Image('../dokumenty/statistika2016/hlasenie_pohladavok/hlasenie_euler_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

//dic horne
$pdf->Cell(195,20," ","$rmc1",1,"L");
$textxx="0123456789";
$text=$hlavicka->ico;
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

<?php if ( $xml == 0 ) { ?>
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php                  } ?>
<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA
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