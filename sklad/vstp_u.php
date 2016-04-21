<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'SKL';
$urov = 2000;
$cslm=401101;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
//operacie so zahlavim 5=nova prijemka   = formularova ->68ulozenie a prechod na 8
//                    28=uprava zahlavia = formularova ->38ulozenie a prechod na 78
//                    15=nova prijemka hlavicka po hladani -> prechod na 5
//operacie s polozkami 8=uprava prijemky nova polozka , 18,19=ulozenie novej polozky a prechod do 8
//                    48=uprava vybranej polozky , 58=ulozenie upravenej polozky a prechod do 8
//                    78=nova polozka po ulozeni novej hlavicky
//                    LEN 8,48 a 78 su formularove ostatne sa prepisuju na ne
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
//$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$sql = "SELECT ajstrzak FROM F$kli_vxcf"."_skldokset$kli_uzid ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_skldokset'.$kli_uzid;
$vytvor = mysql_query("$vsql");


$sqlt = <<<statistika_p1304
(
   id           DECIMAL(10,0) DEFAULT 0,
   ajpoznam     DECIMAL(8,0) DEFAULT 0,
   poznampod    DECIMAL(8,0) DEFAULT 0,
   ajstrzak     DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_skldokset'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'INSERT INTO F'.$kli_vxcf.'_skldokset'.$kli_uzid." ( id ) VALUES ('$kli_uzid') ";
$vytvor = mysql_query("$vsql");

}
$ajpoznam=0; $poznampod=0; $ajstrzak=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_skldokset$kli_uzid WHERE id = $kli_uzid ORDER BY id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ajpoznam=1*$riaddok->ajpoznam;
  $poznampod=1*$riaddok->poznampod;
  $ajstrzak=1*$riaddok->ajstrzak;

  }

if( $polno == 1 ) { $ajstrzak=1; }

$kuch = 1*$_REQUEST['kuch'];

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = strip_tags($_REQUEST['drupoh']);

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


$page = strip_tags($_REQUEST['page']);
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);
$cislo_dat = strip_tags($_REQUEST['cislo_dat']);
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);
$cislo_fak = strip_tags($_REQUEST['cislo_fak']);
$cislo_dph = strip_tags($_REQUEST['cislo_dph']);
$cislo_poz = strip_tags($_REQUEST['cislo_poz']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$newdok = strip_tags($_REQUEST['newdok']);

$h_dok = strip_tags($_REQUEST['h_dok']);
$h_skl = strip_tags($_REQUEST['h_skl']);
$h_dat = strip_tags($_REQUEST['h_dat']);
$h_poh = strip_tags($_REQUEST['h_poh']);
$h_sk2 = strip_tags($_REQUEST['h_sk2']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_nai = strip_tags($_REQUEST['h_nai']);
$h_fak = strip_tags($_REQUEST['h_fak']);
$h_unk = strip_tags($_REQUEST['h_unk']);
$h_poz = strip_tags($_REQUEST['h_poz']);
$h_str = strip_tags($_REQUEST['h_str']);
if( $h_str == '' OR $h_str == '0' ) $h_str = $fir_sklstr;
$h_zak = strip_tags($_REQUEST['h_zak']);
if( $h_zak == '' OR $h_zak == '0' ) $h_zak = $fir_sklzak;
$h_cpl = strip_tags($_REQUEST['h_cpl']);
$h_cis = strip_tags($_REQUEST['h_cis']);
$h_nat = strip_tags($_REQUEST['h_nat']);
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_cen = strip_tags($_REQUEST['h_cen']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$hp_skl = strip_tags($_REQUEST['hp_skl']);
$hp_cis = strip_tags($_REQUEST['hp_cis']);
$hp_cen = strip_tags($_REQUEST['hp_cen']);
$hp_mno = strip_tags($_REQUEST['hp_mno']);
$h_vcis = strip_tags($_REQUEST['h_vcis']);

$vybr = strip_tags($_REQUEST['vybr']);
$vybr_skl = strip_tags($_REQUEST['vybr_skl']);
$vybr_dok = strip_tags($_REQUEST['vybr_dok']);
$vybr_cis = strip_tags($_REQUEST['vybr_cis']);
$vybr_nat = strip_tags($_REQUEST['vybr_nat']);
$vybr_mer = strip_tags($_REQUEST['vybr_mer']);
$vybr_dph = strip_tags($_REQUEST['vybr_dph']);
$vybr_cen = strip_tags($_REQUEST['vybr_cen']);
$vybr_zas = strip_tags($_REQUEST['vybr_zas']);
$vybr_ico = strip_tags($_REQUEST['vybr_ico']);
$vybr_nai = strip_tags($_REQUEST['vybr_nai']);
$hlad = strip_tags($_REQUEST['hlad']);
$hlat = strip_tags($_REQUEST['hlat']);
$hlad_skl = strip_tags($_REQUEST['h_skl']);
$hlad_cis = strip_tags($_REQUEST['h_cis']);
$hlad_nat = strip_tags($_REQUEST['h_nat']);
$hlat_ico = strip_tags($_REQUEST['h_ico']);
$hlat_nai = strip_tags($_REQUEST['h_nai']);

if ( $hlad == 'ANO' AND $copern == 18) $copern=8;
if ( $hlad == 'ANO' AND $copern == 19) $copern=78;
if ( $hlad == 'ANO' AND $copern == 58) $copern=48;
if ( $hlad == 'NIE' AND $vybr == 'ANO' AND $copern == 19) $copern=78;
if ( $hlad != 'ANO' AND $vybr != 'ANO' AND $copern == 19) $copern=18;

if ( $hlat == 'ANO' AND $copern == 68) $copern=15;
if ( $hlat == 'NIE' AND $vybr == 'ANO' AND $copern == 15) $copern=15;
if ( $hlat == 'ANO' AND $copern == 38) $copern=28;

//echo "copern".$copern;

$h_mn2 = 1*$_REQUEST['h_mn2'];

if( $drupoh == 1 )
{
$tabl = "sklpri";
$cov1p = "PrÌjem";
$com1p = "prÌjem";
$com4p = "prÌjmu";
$dokm1p = "prÌjemka";
$dokm4p = "prÌjemky";
$dokm2p = "prÌjemku";
$dokm4pm = "prÌjemok";
$icov1p = "Dod·vateæ";
$hladp = "Dod·vateæ";
$skladp = "Na sklad";
$fakv1p = "Fakt˙ra";
$skladpd = "Na sklad:";
$fakv1pd = "Fakt˙ra";
$cisdok = "sklcpr";
$akedrp = "<= 4";
$znmskl = "+";
$znxskl = "-";
$h_sk2 = $cislo_skl;
if( $copern == 68 ) $h_sk2 = $h_skl;
$popico = "Dod·vateæ I»O:";
$popnai = "Dod·vateæ N·zov:";
}

if( $drupoh == 2 )
{
$tabl = "sklvyd";
$cov1p = "V˝daj";
$com1p = "v˝daj";
$com4p = "v˝daja";
$dokm1p = "v˝dajka";
$dokm4p = "v˝dajky";
$dokm2p = "v˝dajku";
$dokm4pm = "v˝dajok";
$icov1p = "Odberateæ";
$hladp = "Odberateæ - Z·kazka";
$skladp = "Zo skladu";
$fakv1p = "Fakt˙ra";
$skladpd = "Zo skladu:";
$fakv1pd = "Fakt˙ra";
$cisdok = "sklcvd";
$akedrp = ">= 6";
$znmskl = "-";
$znxskl = "+";
$h_sk2 = $cislo_skl;
if( $copern == 68 ) $h_sk2 = $h_skl;
$popico = "Odberateæ I»O:";
$popnai = "Odberateæ N·zov:";
}

if( $drupoh == 3 )
{
$tabl = "sklpre";
$cov1p = "Presun";
$com1p = "presun";
$com4p = "presunu";
$dokm1p = "presunka";
$dokm4p = "presunky";
$dokm2p = "presunku";
$dokm4pm = "presuniek";
$icov1p = "Dod·vateæ";
$hladp = "Na sklad";
$skladp = "Zo skladu";
$skladpd = "Zo skladu:";
$fakv1pd = "";
$fakv1p = "   ";
$cisdok = "sklcps";
$akedrp = "= 5";
$znmskl = "-";
$znxskl = "+";
$h_str = 0;
$h_zak = 0;
$popico = " ";
$popnai = " ";
}

//echo "hsk2 $h_sk2 hstr $h_str hzak $h_zak";

$uloz="NO";
$zmaz="NO";
$uprav="NO";
$uprap="NO";

//zalohovy subor sklpohall

$sqlfir = "SELECT * FROM F$kli_vxcf"."_sklpohall ";
$fir_vysledok = mysql_query($sqlfir);
if (!$fir_vysledok) { 

$sql = "CREATE TABLE F".$kli_vxcf."_sklpohall SELECT * FROM F".$kli_vxcf."_sklpri WHERE cis < 0 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F".$kli_vxcf."_sklpohall MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F".$kli_vxcf."_sklpohall MODIFY cpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
                    }
//koniec zalohovy subor sklpohall

//spotreba poloziek z prijemky
if ( $copern == 1035 )
    {

if( $drupoh == 2 )
{

$sqlfir = "SELECT * FROM F$kli_vxcf"."_sklvyd WHERE dok=$cislo_dok AND cis=0 ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { 

$fir_riadok=mysql_fetch_object($fir_vysledok); 
$cislo_ume = $fir_riadok->ume;
$cislo_dat = $fir_riadok->dat;
$cislo_skl = $fir_riadok->skl;
$cislo_poh = $fir_riadok->poh;
$cislo_ico = $fir_riadok->ico;
$cislo_fak = $fir_riadok->fak;
$cislo_str = $fir_riadok->str;
$cislo_zak = $fir_riadok->zak;
                    }
// cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  poz  str  zak  cis  mno  cen  id  sk2  datm  

$cislo_prx = 1*$_REQUEST['cislo_prx'];

$sqty = "INSERT INTO F$kli_vxcf"."_sklvyd SELECT 0,'$cislo_ume','$cislo_dat','$cislo_dok','0',".
"'$cislo_skl','$cislo_poh','$cislo_ico','$cislo_fak','','','$cislo_str','$cislo_zak',".
"cis,mno,cen,'$kli_uzid','0',now(),0,0 ".
" FROM F$kli_vxcf"."_sklpri WHERE F$kli_vxcf"."_sklpri.mno != 0 AND F$kli_vxcf"."_sklpri.cis > 0 ".
" AND F$kli_vxcf"."_sklpri.dok = $cislo_prx";

//echo $sqty;
if( $cislo_prx > 0 ) { $ulozene = mysql_query("$sqty"); }

}

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $fir_xsk04 == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$reko = include("skl_rekonstrukcia.php");

$copern=8;
    }
//koniec spotreba poloziek z prijemky

//spotreba poloziek na zakazke
if ( $copern == 1025 )
    {

if( $drupoh == 2 )
{

$sqlfir = "SELECT * FROM F$kli_vxcf"."_sklvyd WHERE dok=$cislo_dok AND cis=0 ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { 

$fir_riadok=mysql_fetch_object($fir_vysledok); 
$cislo_ume = $fir_riadok->ume;
$cislo_dat = $fir_riadok->dat;
$cislo_skl = $fir_riadok->skl;
$cislo_poh = $fir_riadok->poh;
$cislo_ico = $fir_riadok->ico;
$cislo_fak = $fir_riadok->fak;
$cislo_str = $fir_riadok->str;
$cislo_zak = $fir_riadok->zak;
                    }
// cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  poz  str  zak  cis  mno  cen  id  sk2  datm  

$sqty = "INSERT INTO F$kli_vxcf"."_sklvyd SELECT 0,'$cislo_ume','$cislo_dat','$cislo_dok','0',".
"'$cislo_skl','$cislo_poh','$cislo_ico','$cislo_fak','','','$cislo_str','$cislo_zak',".
"cis,mno,cen,'$kli_uzid','0',now(),0,0 ".
" FROM F$kli_vxcf"."_sklprcd$kli_uzid WHERE pox = 8 AND F$kli_vxcf"."_sklprcd$kli_uzid.mno != 0 ".
" AND F$kli_vxcf"."_sklprcd$kli_uzid.ico = $cislo_zak AND F$kli_vxcf"."_sklprcd$kli_uzid.skl = $cislo_skl";

//echo $sqty;
$ulozene = mysql_query("$sqty");

}

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $fir_xsk04 == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$reko = include("skl_rekonstrukcia.php");

$copern=8;
    }
//koniec spotreba poloziek na zakazke

//spotreba poloziek na sklade
if ( $copern == 1015 )
    {

if( $drupoh == 2 )
{

$sqlfir = "SELECT * FROM F$kli_vxcf"."_sklvyd WHERE dok=$cislo_dok AND cis=0 ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { 

$fir_riadok=mysql_fetch_object($fir_vysledok); 
$cislo_ume = $fir_riadok->ume;
$cislo_dat = $fir_riadok->dat;
$cislo_skl = $fir_riadok->skl;
$cislo_poh = $fir_riadok->poh;
$cislo_ico = $fir_riadok->ico;
$cislo_fak = $fir_riadok->fak;
$cislo_str = $fir_riadok->str;
$cislo_zak = $fir_riadok->zak;
                    }
// cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  poz  str  zak  cis  mno  cen  id  sk2  datm  

$sqty = "INSERT INTO F$kli_vxcf"."_sklvyd SELECT 0,'$cislo_ume','$cislo_dat','$cislo_dok','0',".
"'$cislo_skl','$cislo_poh','$cislo_ico','$cislo_fak','','','$cislo_str','$cislo_zak',".
"cis,zas,cen,'$kli_uzid','0',now(),0,0 ".
" FROM F$kli_vxcf"."_sklprcd$kli_uzid WHERE pox = 0 AND F$kli_vxcf"."_sklprcd$kli_uzid.zas != 0 ".
" AND F$kli_vxcf"."_sklprcd$kli_uzid.skl = $cislo_skl";

//echo $sqty;
$ulozene = mysql_query("$sqty");

}

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $fir_xsk04 == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$reko = include("skl_rekonstrukcia.php");

$copern=8;
    }
//koniec spotreba poloziek na sklade


//vymazanie poloziek dokladu
if ( $copern == 166 )
    {

if( $drupoh == 1 )
{
$zmaztt = "DELETE FROM F$kli_vxcf"."_sklpri WHERE dok='$cislo_dok' AND cis > 0"; 
$zmazane = mysql_query("$zmaztt");
}
if( $drupoh == 2 )
{
$zmaztt = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE dok='$cislo_dok' AND cis > 0"; 
$zmazane = mysql_query("$zmaztt");
}
if( $drupoh == 3 )
{
$zmaztt = "DELETE FROM F$kli_vxcf"."_sklpre WHERE dok='$cislo_dok' AND cis > 0"; 
$zmazane = mysql_query("$zmaztt");
}
$copern=8;

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $fir_xsk04 == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$reko = include("skl_rekonstrukcia.php");

    }
//koniec vymazania poloziek dokladu

//ulozenie novej polozky
if ( $copern == 18 )
    {
$h_cen=1*$h_cen;

$h_natBD = StrTr($h_nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$sqtx = "INSERT INTO F$kli_vxcf"."_sklcis ( cis,nat,natBD,mer,dph,cep,ced ) VALUES ($h_cis, '$h_nat', '$h_natBD', '$h_mer', $h_dph, 0, 0);"; 
$ulozene = mysql_query("$sqtx"); 

$sqtz = "INSERT INTO F$kli_vxcf"."_sklzas ( skl,cis,cen,zas ) VALUES ($h_skl, $h_cis, $h_cen, $znmskl($h_mno));"; 
//echo $sqtz;
$ulozzas = mysql_query("$sqtz");
if (!$ulozzas)
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znmskl($h_mno) WHERE ( skl=$h_skl AND cis=$h_cis AND cen=$h_cen );";
//echo $sqtu;
$upravene = mysql_query("$sqtu");
}

if ($drupoh == 3)
{
$sqtz = "INSERT INTO F$kli_vxcf"."_sklzas ( skl,cis,cen,zas ) VALUES ($h_sk2, $h_cis, $h_cen, $znxskl($h_mno));"; 
$ulozzas = mysql_query("$sqtz");
if (!$ulozzas)
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znxskl($h_mno) WHERE ( skl=$h_sk2 AND cis=$h_cis AND cen=$h_cen );";
$upravene = mysql_query("$sqtu");
}
}

if ( $fir_xsk04 == 1 AND $drupoh == 2 )
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas$znmskl($h_mno) WHERE ( skl=$h_skl AND cis=$h_cis );";
$upravene = mysql_query("$sqtu");
}

if ( $fir_xsk04 == 1 AND $drupoh == 3 )
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas$znmskl($h_mno) WHERE ( skl=$h_skl AND cis=$h_cis );";
$upravene = mysql_query("$sqtu");
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas$znxskl($h_mno) WHERE ( skl=$h_sk2 AND cis=$h_cis );";
$upravene = mysql_query("$sqtu");
}

$vymazpriemer=0;
if( $fir_xsk04 == 1 AND $drupoh == 1 ) { $vymazpriemer=1; }
  $ajeshop=0;
  if (File_Exists ("../eshop/index.php")) { $ajeshop=1; }
  if( $ajeshop == 1 ) { $vymazpriemer=1; }

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $vymazpriemer == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$h_dat = SqlDatum($h_dat);
  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];

$sqtyx = "INSERT INTO F$kli_vxcf"."_sklpohall ( dok,skl,dat,ume,poh,sk2,ico,fak,unk,poz,str,zak,cis,cen,mno,id,mn2 )".
" VALUES ($cislo_dok, $cislo_skl, '$h_dat', '$h_ume', $h_poh, '$h_sk2', $h_ico, $h_fak, '$h_unk', '$h_poz', '$h_str',".
" '$h_zak', $h_cis, $h_cen, $h_mno, $kli_uzid, $h_mn2 );"; 
$ulozenex = mysql_query("$sqtyx");

$h_pon = strip_tags($_REQUEST['h_pon']);

$sqty = "INSERT INTO F$kli_vxcf"."_$tabl ( dok,skl,dat,ume,poh,sk2,ico,fak,unk,poz,str,zak,cis,cen,mno,id,mn2 )".
" VALUES ($cislo_dok, $cislo_skl, '$h_dat', '$h_ume', $h_poh, '$h_sk2', $h_ico, $h_fak, '$h_unk', '$h_pon', '$h_str',".
" '$h_zak', $h_cis, $h_cen, $h_mno, $kli_uzid, $h_mn2 );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty"); 

$copern=8;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia polozky

$vymazanie=0;

//vymazanie polozky
if ( $copern == 36 )
    {

$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znxskl($h_mno) WHERE ( skl=$h_skl AND cis=$h_cis AND cen=$h_cen );";
$upravene = mysql_query("$sqtu");

if ($drupoh == 3)
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znmskl($h_mno) WHERE ( skl=$h_sk2 AND cis=$h_cis AND cen=$h_cen );";
$upravene = mysql_query("$sqtu");
}

if ( $fir_xsk04 == 1 AND $drupoh == 2 )
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas$znxskl($h_mno) WHERE ( skl=$h_skl AND cis=$h_cis );";
$upravene = mysql_query("$sqtu");
}

if ( $fir_xsk04 == 1 AND $drupoh == 3 )
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas$znxskl($h_mno) WHERE ( skl=$h_skl AND cis=$h_cis );";
$upravene = mysql_query("$sqtu");
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas$znmskl($h_mno) WHERE ( skl=$h_sk2 AND cis=$h_cis );";
$upravene = mysql_query("$sqtu");
}

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $fir_xsk04 == 1 AND $drupoh == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE ( cpl='$cislo_cpl' )"); 
$copern=1;
$vymazanie=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
$copern=8;
endif;
    }
//koniec vymazania polozky

//uprava hlavicky 38
if ( $copern == 38 )
  {
$h_dat = SqlDatum($h_dat);
  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];

if( $ajstrzak == 0 )
{
$upravene = mysql_query("UPDATE F$kli_vxcf"."_$tabl SET skl='$cislo_skl', dok='$cislo_dok', dat='$h_dat', ume='$h_ume', poh=$h_poh, sk2='$h_sk2',
 ico='$h_ico', fak='$h_fak', unk='$h_unk', str='$h_str', zak='$h_zak', id='$kli_uzid' WHERE skl='$cislo_skl' AND dok='$cislo_dok'");  
}
if( $ajstrzak == 1 )
{
$upravene = mysql_query("UPDATE F$kli_vxcf"."_$tabl SET skl='$cislo_skl', dok='$cislo_dok', dat='$h_dat', ume='$h_ume', poh=$h_poh, sk2='$h_sk2',
 ico='$h_ico', fak='$h_fak', unk='$h_unk',  str='$h_str', zak='$h_zak', id='$kli_uzid' WHERE skl='$cislo_skl' AND dok='$cislo_dok' AND cis = 0 ");  

$upravene = mysql_query("UPDATE F$kli_vxcf"."_$tabl SET skl='$cislo_skl', dok='$cislo_dok', dat='$h_dat', ume='$h_ume', poh=$h_poh, sk2='$h_sk2',
 ico='$h_ico', fak='$h_fak', unk='$h_unk', id='$kli_uzid' WHERE skl='$cislo_skl' AND dok='$cislo_dok' AND cis > 0 ");  
}


$upravene = mysql_query("UPDATE F$kli_vxcf"."_$tabl SET poz='$h_poz' WHERE skl='$cislo_skl' AND dok='$cislo_dok' AND cis = 0 ");  


$copern=8;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "PRIJEMKA DOK:$cislo_dok 
endif;
  }
//koniec uprava hlavicky

//nova hlavicka 68
if ( $copern == 68 )
  {
$h_dat = SqlDatum($h_dat);
  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];
$upravene = mysql_query("UPDATE F$kli_vxcf"."_$tabl SET skl='$h_skl', dok='$h_dok', dat='$h_dat', ume='$h_ume', poh=$h_poh, sk2='$h_sk2',
 ico='$h_ico', fak='$h_fak', unk='$h_unk', poz='$h_poz', str='$h_str', zak='$h_zak' WHERE id='$kli_uzid' AND dok='$newdok'");  
$cislo_skl = $h_skl;
$cislo_dok = $h_dok;
$copern=78;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
exit;
endif;
if ($upravene):
$uprav="OK";
endif;
  }
//koniec nova hlavicka

//uprava polozky
if ( $copern == 58 )
    {
$h_natBD = StrTr($h_nat, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcis ( cis,nat,natBD,mer,dph,cep,ced ) VALUES ($h_cis, '$h_nat', '$h_natBD', '$h_mer', $h_dph, 0, 0); "); 


$sqtz = "INSERT INTO F$kli_vxcf"."_sklzas ( skl,cis,cen,zas ) VALUES ($h_skl, $h_cis, $h_cen, $znmskl($h_mno));"; 
$ulozzas = mysql_query("$sqtz");
if (!$ulozzas)
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znmskl($h_mno) WHERE ( skl=$h_skl AND cis=$h_cis AND cen=$h_cen );";
$upravene = mysql_query("$sqtu");
}
$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znxskl($hp_mno) WHERE ( skl=$hp_skl AND cis=$hp_cis AND cen=$hp_cen );";
//echo $sqtu;
$upravene = mysql_query("$sqtu");

$vymazpriemer=0;
if( $fir_xsk04 == 1 AND $drupoh == 1 ) { $vymazpriemer=1; }
  $ajeshop=0;
  if (File_Exists ("../eshop/index.php")) { $ajeshop=1; }
  if( $ajeshop == 1 ) { $vymazpriemer=1; }

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $vymazpriemer == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$h_pon = strip_tags($_REQUEST['h_pon']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_$tabl SET cis='$h_cis', cen='$h_cen', mno='$h_mno', poz='$h_pon' WHERE cpl='$cislo_cpl'");  
$copern=8;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprap="OK";
//echo "PRIJEMKA DOK:$cislo_dok UPRAVEN¡ ";
endif;
    }
//koniec uprava polozky

//nova prijemka hlavicka fir_xsk05 pristup jednoduchy
if ( $copern == 5 AND $fir_xsk05 == 0 )
    {
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE ( isnull(dok) )"); 
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_ufir");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  }
$maxdok=0;

$sql = mysql_query("SELECT dok FROM F$kli_vxcf"."_$tabl ORDER by dok ");

while($zaznam=mysql_fetch_array($sql)):

if( $zaznam["dok"] == $newdok ) $newdok=$newdok+1;

endwhile;

$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$newdok'+1");  
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcis ( cis ) VALUES ( 0 ); ");
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_$tabl ( dok,skl,doq,str,zak,cis,id ) VALUES ( $newdok, 0, $newdok, '$fir_sklstr', '$fir_sklzak', 0, $kli_uzid ); "); 
if (!$ulozene):
?>
<script type="text/javascript"> alert( " NIE JE SPOJENIE S DATAB¡ZOU ,  ukonËite program a spustite ho znovu " ) </script>
<?php
exit;
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec nova prijemka hlavicka

//nova prijemka hlavicka fir_xsk05 pristup podla uzivatela
if ( $copern == 5 AND $fir_xsk05 == 1 )
    {
$cisdok = "xcpri";
if( $drupoh == 2 ) { $cisdok = "xcvyd"; }
if( $drupoh == 3 ) { $cisdok = "xcpre"; }

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE ( isnull(dok) )"); 
$sql = mysql_query("SELECT $cisdok, xsklv FROM F$kli_vxcf"."_skluzid WHERE uzix = $kli_uzid ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  $xsklv=$riadok->xsklv;
  }
$maxdok=0;


//cislovane v sklade pri,vyd,pre v jednej rade
$cislo_skladu=1*$_REQUEST['cislo_skladu'];
if( $cislo_skladu == 0 AND $xsklv == 9 )
    {
$sql = mysql_query("SELECT sklx FROM F$kli_vxcf"."_sklxskl ORDER BY sklx ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $cislo_skladu=$riadok->sklx;
  }
    }
if( $xsklv == 9 )
{
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_sklxskl WHERE sklx = $cislo_skladu ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  }
$maxdok=0;
}
//koniec cislovane v sklade pri,vyd,pre v jednej rade

$cnewdok=1*$newdok;
$opacdok=strRev($newdok);
if( $cnewdok > 9999 ) { $poccis="001"; $koncis="999"; $predok=substr($opacdok,3,2); }
if( $cnewdok > 99999 ) { $poccis="0001"; $koncis="9999"; $predok=substr($opacdok,4,2); }
if( $cnewdok > 999999 ) { $poccis="00001"; $koncis="99999"; $predok=substr($opacdok,5,2); }
if( $cnewdok > 9999999 ) { $poccis="000001"; $koncis="999999"; $predok=substr($opacdok,6,2); }
if( $cnewdok > 99999999 ) { $poccis="0000001"; $koncis="9999999"; $predok=substr($opacdok,7,2); }
$predok=strRev($predok);
$predok=1*$predok;

$pocdok=$predok.$poccis;
$kondok=$predok.$koncis;

$sqlt = "SELECT dok FROM F$kli_vxcf"."_$tabl WHERE dok >= $pocdok AND dok <= $kondok ORDER by dok ";
//echo $sqlt;

//cislovane v sklade pri,vyd,pre v jednej rade
if( $xsklv == 9 )
{
$sql = mysql_query("( SELECT dok FROM F$kli_vxcf"."_$tabl2 ORDER by dok ) UNION ( SELECT dok FROM F$kli_vxcf"."_$tabl ORDER by dok ) ORDER BY dok");

$sqlt = "( SELECT dok FROM F$kli_vxcf"."_sklpri WHERE dok >= $pocdok AND dok <= $kondok AND skl = $cislo_skladu ORDER by dok ) UNION ".
"( SELECT dok FROM F$kli_vxcf"."_sklvyd WHERE dok >= $pocdok AND dok <= $kondok AND skl = $cislo_skladu ORDER by dok ) UNION ".
"( SELECT dok FROM F$kli_vxcf"."_sklpre WHERE dok >= $pocdok AND dok <= $kondok AND skl = $cislo_skladu ORDER by dok ) ORDER BY dok ";
//echo $sqlt;

}
//koniec cislovane v sklade pri,vyd,pre v jednej rade


$sql = mysql_query("$sqlt ");

while($zaznam=mysql_fetch_array($sql)):

if( $zaznam["dok"] == $newdok ) $newdok=$newdok+1;

endwhile;

$upravene = mysql_query("UPDATE F$kli_vxcf"."_skluzid SET $cisdok='$newdok'+1 WHERE uzix = $kli_uzid ");  
//cislovane v sklade pri,vyd,pre v jednej rade
if( $xsklv == 9 )
{
$upravene = mysql_query("UPDATE F$kli_vxcf"."_sklxskl SET xcpri='$newdok'+1, xcvyd='$newdok'+1, xcpre='$newdok'+1 WHERE sklx = $cislo_skladu ");
}
//koniec cislovane v sklade pri,vyd,pre v jednej rade
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_sklcis ( cis ) VALUES ( 0 ); ");
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_$tabl ( dok,skl,doq,str,zak,cis,id ) VALUES ( $newdok, 0, $newdok, '$fir_sklstr', '$fir_sklzak', 0, $kli_uzid ); "); 
if (!$ulozene):
?>
<script type="text/javascript"> alert( " NIE JE SPOJENIE S DATAB¡ZOU ,  ukonËite program a spustite ho znovu " ) </script>
<?php
exit;
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec nova prijemka hlavicka

if ( $copern == 15 ) $copern=5;

//echo $copern;
//echo $drupoh;


$sql = "SELECT * FROM F$kli_vxcf"."_sklzaspriemer";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
$priemer = include("../sklad/sklzaspriemer.php");
     }

if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=8'); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Sklad <?php echo $cov1p; ?></title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js"></SCRIPT>

<?php
if ( $ajstrzak == 1 )
{
?>
<script type="text/javascript" src="spr_sklpstr_xml.js"></script>
<script type="text/javascript" src="spr_sklpzak_xml.js"></script>
<?php
}
?>

<?php
if ( $copern == 5 OR $copern == 28 )
{
?>
<script type="text/javascript" src="../ajax/skl_ico_xml.js"></script>
<script type="text/javascript" src="spr_sklstr_xml.js"></script>
<script type="text/javascript" src="spr_sklzak_xml.js"></script>
<?php
}
?>

<?php
if (  ( $copern == 78 OR $copern == 8 OR $copern == 48 ) AND $drupoh == 1 )
{
?>
<script type="text/javascript" src="../ajax/skl_pri_xml.js"></script>
<?php
}
?>

<?php
if (  ( $copern == 78 OR $copern == 8 OR $copern == 48 ) AND ( $drupoh == 2 OR $drupoh == 3 ) )
{
?>
<script type="text/javascript" src="../ajax/skl_vyd_xml.js"></script>
<?php
}
?>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

var vyskawic = screen.height;
var sirkawic = screen.width-10;


    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }
//Posun Enter

function SklEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_dat.focus();
              }

                }

function DatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poh.focus();
              }

                }

function PohEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
              if( document.forms.fhlv1.h_ico.value == '' ) { document.forms.fhlv1.h_ico.value='<?php echo $fir_fico; ?>'; } 
<?php if( $drupoh != 3 ) echo "document.forms.fhlv1.h_ico.focus();"; ?>
<?php if( $drupoh == 3 ) echo "document.forms.fhlv1.h_sk2.focus();"; ?>
              }

                }

<?php
//len presun
if( $drupoh == 3 )
{
?>

function Sk2Enter(e)
                {

  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }

                }
<?php
}
?>

<?php
//len prijem,vydaj
if( $drupoh != 3 )
{
?>

function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_ico.value != '')
        {
        myIcoElement.style.display='';
        nulujIco();
        volajIco();
        }      
        if( document.fhlv1.h_ico.value == "" ) { document.fhlv1.h_nai.disabled = false; document.fhlv1.h_nai.focus(); document.fhlv1.h_nai.select(); }
        if( document.fhlv1.h_ico.value == 0 ) { document.fhlv1.h_nai.disabled = false; document.fhlv1.h_nai.focus(); }

              }
                }



function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_nai.value != '' )
        {
        myIcoElement.style.display='';
        nulujIco();
        volajIco();
        }   

        if( document.fhlv1.h_nai.value != "" && document.fhlv1.h_ico.value > 0 )
            { document.fhlv1.h_ico.focus(); }

        if( document.fhlv1.h_nai.value == "" ) { document.fhlv1.h_ico.focus(); }

              }
                }


//co urobi po potvrdeni ok z tabulky ico
function vykonajIco(ico,nazov,mesto,ucb,num,dns)
                {
        document.forms.fhlv1.h_ico.value = ico;
        document.forms.fhlv1.h_nai.value = nazov;
        myIcoElement.style.display='none';

        document.forms.fhlv1.h_str.focus();

                }

function nulujIco()
                {

                }

function Len1ICO()
                    {
        document.forms.fhlv1.h_str.focus();
                    }

<?php
//len nove polozky
if( $copern != 8 AND $copern != 48 AND $copern != 78  )
{
?>

function StrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if ( document.fhlv1.h_str.value != '' && document.fhlv1.h_str.value != '0' ) 
        {
        volajStr(0,0); 
        }

        if ( document.fhlv1.h_str.value == '0' )
        {         
        if ( document.fhlv1.h_zak.value == '' ) document.fhlv1.h_zak.value = '0';
        document.forms.fhlv1.h_zak.focus();
        document.forms.fhlv1.h_zak.select();
        }
               }

                }


//co urobi po potvrdeni ok z tabulky str
function vykonajStr(str,strtext)
                {
         document.forms.fhlv1.h_str.value = str;
  var html = "<span id='str0' style='width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;'>";
  html += "" + strtext + " </span>";  
  myStr = document.getElementById("myStrelement");
  myStr.innerHTML = html;
  myStrelement.style.display='';
         if ( document.fhlv1.h_zak.value == '' ) document.fhlv1.h_zak.value = '0';
         document.fhlv1.h_zak.focus();
         document.fhlv1.h_zak.select();
                }


function Len1Str(str)
              {
         document.forms.fhlv1.h_str.value = str;
         if ( document.fhlv1.h_zak.value == '' ) document.fhlv1.h_zak.value = '0';
         document.fhlv1.h_zak.focus();
         document.fhlv1.h_zak.select();
              }

function Len0Str()
                    {
         document.fhlv1.h_str.focus();
         document.fhlv1.h_str.select();
                    }




function ZakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if ( document.fhlv1.h_zak.value != '' && document.fhlv1.h_zak.value != '0' ) 
        {
        volajZak(0,0); 
        }

        if ( document.fhlv1.h_zak.value == '0' )
        {         
        if ( document.fhlv1.h_fak.value == '' ) document.fhlv1.h_fak.value = '0';
        document.forms.fhlv1.h_fak.focus();
        document.forms.fhlv1.h_fak.select();
        }
               }

                }


//co urobi po potvrdeni ok z tabulky zak
function vykonajZak(str,zak,zaktext)
                {
         document.forms.fhlv1.h_zak.value = zak;
         document.forms.fhlv1.h_str.value = str;
  var html = "<span id='str0' style='width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;'>";
  html += "" + zaktext + " </span>";  
  myZak = document.getElementById("myZakelement");
  myZak.innerHTML = html;
  myZakelement.style.display='';
         if ( document.fhlv1.h_fak.value == '' ) document.fhlv1.h_fak.value = '0';
         document.fhlv1.h_fak.focus();
         document.fhlv1.h_fak.select();
                }


function Len1Zak(str,zak)
              {
         document.forms.fhlv1.h_zak.value = zak;
         document.forms.fhlv1.h_str.value = str;
         if ( document.fhlv1.h_fak.value == '' ) document.fhlv1.h_fak.value = '0';
         document.fhlv1.h_fak.focus();
         document.fhlv1.h_fak.select();
              }

function Len0Zak()
                    {
         document.fhlv1.h_zak.focus();
         document.fhlv1.h_zak.select();
                    }

<?php
//len nove polozky
//if( $copern != 8 AND $copern != 48 AND $copern != 78  )
}
?>

function FakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_unk.focus();
              }

                }

function UnkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }

                }

<?php
//koniec prijem,vydaj
}
?>

function PozEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_poh.value == '' ) okvstup=0;
<?php
//len presun
if( $drupoh != 3 )
{
?>
    if ( document.fhlv1.err_ico.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_fak.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_ico.value == '' ) okvstup=0;
    if ( document.fhlv1.h_fak.value == '' ) okvstup=0;
    if ( document.fhlv1.h_zak.value == '' ) okvstup=0;
    if ( okvstup == 0 && document.fhlv1.h_fak.value == '' ) { document.fhlv1.h_fak.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.h_zak.value == '' ) { document.fhlv1.h_zah.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_ico.value == '1' ) { document.fhlv1.h_ico.focus(); return (false); }
<?php
}
?>
    if ( okvstup == 0 && document.fhlv1.h_dat.value == '' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_dat.value == '1' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_poh.value == '1' ) { document.fhlv1.h_poh.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_dat.value == '1' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.fhlv1.submit(); return (true); }
              }
                }


<?php
//len nove polozky
if( $copern == 8 OR $copern == 48 OR $copern == 78  )
{
?>
function StrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if ( document.formv1.h_str.value != '' && document.formv1.h_str.value != '0' ) 
        {
        volajStr(0,0); 
        }

        if ( document.formv1.h_str.value == '0' )
        {         
        if ( document.formv1.h_zak.value == '' ) document.formv1.h_zak.value = '0';
        document.forms.formv1.h_zak.focus();
        document.forms.formv1.h_zak.select();
        }
               }

                }


//co urobi po potvrdeni ok z tabulky str
function vykonajStr(str,strtext)
                {
         document.forms.formv1.h_str.value = str;
  var html = "<span id='str0' style='width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;'>";
  html += "" + strtext + " </span>";  
  myStr = document.getElementById("myStrelement");
  myStr.innerHTML = html;
  myStrelement.style.display='';
         if ( document.formv1.h_zak.value == '' ) document.formv1.h_zak.value = '0';
         document.formv1.h_zak.focus();
         document.formv1.h_zak.select();
                }


function Len1Str(str)
              {
         document.forms.formv1.h_str.value = str;
         if ( document.formv1.h_zak.value == '' ) document.formv1.h_zak.value = '0';
         document.formv1.h_zak.focus();
         document.formv1.h_zak.select();
              }

function Len0Str()
                    {
         document.formv1.h_str.focus();
         document.formv1.h_str.select();
                    }




function ZakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if ( document.formv1.h_zak.value != '' && document.formv1.h_zak.value != '0' ) 
        {
        volajZak(0,0); 
        }

        if ( document.formv1.h_zak.value == '0' )
        {         
        document.forms.formv1.h_cis.focus();
        document.forms.formv1.h_cis.select();
        }
               }

                }


//co urobi po potvrdeni ok z tabulky zak
function vykonajZak(str,zak,zaktext)
                {
         document.forms.formv1.h_zak.value = zak;
         document.forms.formv1.h_str.value = str;
  var html = "<span id='str0' style='width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;'>";
  html += "" + zaktext + " </span>";  
  myZak = document.getElementById("myZakelement");
  myZak.innerHTML = html;
  myZakelement.style.display='';
         document.formv1.h_cis.focus();
         document.formv1.h_cis.select();
                }


function Len1Zak(str,zak)
              {
         document.forms.formv1.h_zak.value = zak;
         document.forms.formv1.h_str.value = str;
         document.formv1.h_cis.focus();
         document.formv1.h_cis.select();
              }

function Len0Zak()
                    {
         document.formv1.h_zak.focus();
         document.formv1.h_zak.select();
                    }

<?php
//if( $copern == 8 OR $copern == 48 OR $copern == 78  )
}
?>

function CisEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.formv1.h_cis.value != '')
        {
        mySklcisElement.style.display='';
        nulujSklcis();
        volajSklcis();
        }      
        if( document.formv1.h_cis.value == "" ) { document.formv1.h_nat.disabled = false; document.formv1.h_nat.focus(); document.formv1.h_nat.select(); }
        if( document.formv1.h_cis.value == 0 ) { document.formv1.h_nat.disabled = false; document.formv1.h_nat.focus(); }

              }
                }



function NatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.formv1.h_nat.value != '' && document.formv1.h_cis.value == '' )
        {
        mySklcisElement.style.display='';
        nulujSklcis();
        volajSklcis();
        }   

        if( document.formv1.h_nat.value != "" && document.formv1.h_cis.value > 0 )
            { document.formv1.h_dph.focus(); }

        if( document.formv1.h_nat.value == "" ) { document.formv1.h_cis.focus(); }

              }
                }


//co urobi po potvrdeni ok z tabulky sklpri
function vykonajSklpri(cis,nat,dph,mer,cen,zas,mrx,mr2,mrk)
                {
        document.forms.formv1.h_cis.value = cis;
        document.forms.formv1.h_nat.value = nat;
        document.forms.formv1.h_dph.value = dph;
        document.forms.formv1.h_mer.value = mer;
        document.forms.formv1.h_nat.disabled = true;
        mySklcisElement.style.display='none';
        document.forms.formv1.h_mrx.value = mrx;

        if( document.forms.formv1.h_mrx.value == 1 ) 
                       { 

  var html4 = "" + mr2 + "";


  myMer2 = document.getElementById("myMer2element");
  myMer2.innerHTML = html4;
  myMer2element.style.display='';

                       }

        document.forms.formv1.h_cen.focus();

                }

function nulujSklcis()
                    {

                    }

function Len1Sklpri()
                    {
        document.forms.formv1.h_nat.disabled = true;
        document.forms.formv1.h_cen.focus();
        document.forms.formv1.h_cen.select();
                    }


function Len0Sklpri()
                    {
        New.style.display="";
        document.forms.formv1.h_nat.focus();
                    }


//co urobi po potvrdeni ok z tabulky sklvyd
function vykonajSklvyd(cis,nat,dph,mer,cen,zas,mrx,mr2,mrk)
                {
        document.forms.formv1.h_cis.value = cis;
        document.forms.formv1.h_nat.value = nat;
        document.forms.formv1.h_dph.value = dph;
        document.forms.formv1.h_cen.value = cen;
        document.forms.formv1.h_mer.value = mer;
        document.forms.formv1.h_mno.value = zas;
        document.forms.formv1.h_nat.disabled = true;
        mySklcisElement.style.display='none';
        document.forms.formv1.h_mrx.value = mrx;

        if( document.forms.formv1.h_mrx.value == 1 ) 
                       { 

  var html4 = "" + mr2 + "";

  myMer2 = document.getElementById("myMer2element");
  myMer2.innerHTML = html4;
  myMer2element.style.display='';
                       }

        if( document.forms.formv1.h_mrx.value == 0 )
        {
        document.forms.formv1.h_mno.focus();
        document.forms.formv1.h_mno.select();
        }
        if( document.forms.formv1.h_mrx.value == 1 )
        {
        if( document.forms.formv1.h_mn2.value == "" ) document.forms.formv1.h_mn2.value = '1';
        document.forms.formv1.h_mn2.focus();
        document.forms.formv1.h_mn2.select();
        }

                }


function Len1Sklvyd()
                    {
        document.forms.formv1.h_nat.disabled = true;

        if( document.forms.formv1.h_mrx.value == 0 )
        {
        document.forms.formv1.h_mno.focus();
        document.forms.formv1.h_mno.select();
        }
        if( document.forms.formv1.h_mrx.value == 1 )
        {
        if( document.forms.formv1.h_mn2.value == "" ) document.forms.formv1.h_mn2.value = '1';
        document.forms.formv1.h_mn2.focus();
        document.forms.formv1.h_mn2.select();
        }


                    }


function Len0Sklvyd()
                    {
        New.style.display="";
        document.forms.formv1.h_cis.focus();
        document.forms.formv1.h_cis.select();
                    }



function DphEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        document.forms.formv1.h_cen.focus();
               }
                }

function CenEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        if( document.forms.formv1.h_mno.value == "" ) document.forms.formv1.h_mno.value = '1';

        if( document.forms.formv1.h_mrx.value == 0 )
        {      
        document.forms.formv1.h_mno.focus();
        document.forms.formv1.h_mno.select();
        }
        if( document.forms.formv1.h_mrx.value == 1 )
        {      
        if( document.forms.formv1.h_mn2.value == "" ) document.forms.formv1.h_mn2.value = '1';
        document.forms.formv1.h_mn2.focus();
        document.forms.formv1.h_mn2.select();
        }
               }

                }

function MnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.formv1.h_mer.value == "" ) document.forms.formv1.h_mer.value = 'ks';
        document.forms.formv1.h_mer.focus();
        document.forms.formv1.h_mer.select();
              }

                }

function Mn2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_mno.focus();
        document.forms.formv1.h_mno.select();
              }

                }

function MerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.formv1.err_cis.value == '1' ) okvstup=0;
    if ( document.formv1.err_cen.value == '1' ) okvstup=0;
    if ( document.formv1.err_mno.value == '1' ) okvstup=0;
    if ( document.formv1.h_cis.value == '' ) okvstup=0;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    if ( document.formv1.h_cen.value == '' ) okvstup=0;
    if ( document.formv1.h_mno.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
    if ( okvstup == 0 && document.formv1.err_cis.value == '1' ) { document.formv1.h_cis.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.err_cen.value == '1' ) { document.formv1.h_cen.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.err_mno.value == '1' ) { document.formv1.h_mno.focus(); return (false); }
              }
                }
                 

//koniec posun Enter

//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1965 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1965.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1)
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;

         if (b == "") { err=0 }
         if (Math.floor(b)==b && b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9]/g) != -1) { err=1 }
         if (Math.floor(b)!=b && b != "") { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 28 OR $copern == 8 OR $copern == 48 OR $copern == 78 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 8 OR $copern == 48 OR $copern == 78 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 28 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 28 OR $copern == 8 OR $copern == 48 OR $copern == 78 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 8 OR $copern == 48 OR $copern == 78 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 28 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

<?php
if ( $copern == 6 ) 
{?>
    function ObnovUI()
    {

    }
    function VyberVstup()
    {

    }

<?php
}?>

<?php
if ( $copern == 8 OR $copern == 78 ) 
{?>
    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    Up.style.display="none";
    Uph.style.display="none";
    Zm.style.display="none";
    New.style.display="none";
    }

    function ObnovUI()
    {
    <?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
<?php if( $vybr == 'ANO' )
{
 echo "document.formv1.h_skl.value = '$vybr_skl';";
 echo "document.formv1.h_cis.value = '$vybr_cis';";
 echo "document.formv1.h_nat.value = '$vybr_nat';";
 echo "document.formv1.h_mer.value = '$vybr_mer';";
 echo "document.formv1.h_dph.value = '$vybr_dph';";
  if( $drupoh != 1 )
  {
 echo "document.formv1.h_cen.value = '$vybr_cen';";
 echo "document.formv1.h_mno.value = '$vybr_zas';";
  }
}
?>
<?php if( $hlad == 'ANO' )
{
 echo "document.formv1.h_skl.value = '$hlad_skl';";
}
?>
<?php
if ( $h_vcis == 1 )
   {
?>
document.formv1.h_vcis.checked = "checked";
<?php
   }
?>
    }
 
    function VyberVstup()
    {
    <?php if( $hlad != 'ANO' AND $ajstrzak == 1 )
    {
    echo "document.formv1.h_str.value = '$h_str';";
    echo "document.formv1.h_zak.value = '$h_zak';";
    }
    ?>
    <?php if( $vymazanie == 1 )
    {
    echo "document.formv1.h_cis.value = '$h_cis';";
    echo "document.formv1.h_cen.value = '$h_cen';";
    echo "document.formv1.h_mno.value = '$h_mno';";
    }
    ?>
    <?php if( $hlad != 'ANO' )
    {
    ?>
    document.formv1.h_cis.focus();
    document.formv1.h_cis.select();
    <?php
    }
    ?>
    <?php if( $vybr == 'ANO' )
    {
      if( $drupoh == 1 )
      {
    echo "document.formv1.h_cen.focus();";
    echo "document.formv1.h_cen.select();";
    echo "document.formv1.h_nat.disabled = true;";
      }
      if( $drupoh != 1 )
      {
    echo "document.formv1.h_mno.focus();";
    echo "document.formv1.h_mno.select();";
    echo "document.formv1.h_nat.disabled = true;";
      }
    }
    ?>
    document.formv1.h_cpl.disabled = true;
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    <?php if( $uprav == 'OK' ) echo "Uph.style.display='';";?>
    <?php if( $uprap == 'OK' ) echo "Up.style.display='';";?>
    }


    function Hlad()
    {
    document.formv1.hlad.value = 'ANO';
    }

    function NeHlad()
    {
    document.formv1.hlad.value = 'NIE';
    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.err_cis.value == '1' ) okvstup=0;
    if ( document.formv1.err_cen.value == '1' ) okvstup=0;
    if ( document.formv1.err_mno.value == '1' ) okvstup=0;
    if ( document.formv1.h_cis.value == '' ) okvstup=0;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    <?php if( $polno != 1 ) { ?>
    if ( document.formv1.h_cen.value == '' ) okvstup=0;
    if ( document.formv1.h_mno.value == '' ) okvstup=0;
    <?php                   } ?>
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
    }

    function Zapis_COOK()
    {

    }

    function Obnov_vstup()
    {

    }


<?php
}?>

<?php
if ( $copern == 28 ) 
{?>
    function ObnovUI()
    {

<?php if( $vybr != 'ANO' && $hlat != 'ANO' )
{
 if( $drupoh != 3 ) echo "document.fhlv1.h_poh.value = '$h_poh';";
 if( $drupoh != 3 ) echo "document.fhlv1.h_str.value = '$h_str';";

 if( $drupoh != 3 ) echo "document.fhlv1.h_zak.value = '$h_zak';";
 if( $drupoh == 3 ) echo "document.fhlv1.h_sk2.value = '$h_sk2';";
}
?>
<?php if( $vybr == 'ANO' )
{
 echo "document.fhlv1.h_dat.value = '$cislo_dat';";
 echo "document.fhlv1.h_poh.value = '$cislo_poh';";
 echo "document.fhlv1.h_str.value = '$cislo_str';";

 echo "document.fhlv1.h_zak.value = '$cislo_zak';";
 echo "document.fhlv1.h_ico.value = '$vybr_ico';";
 echo "document.fhlv1.h_nai.value = '$vybr_nai';";
}
?>
<?php if( $hlat == 'ANO' )
{
 echo "document.fhlv1.h_dat.value = '$h_dat';";
 echo "document.fhlv1.h_poh.value = '$h_poh';";
 echo "document.fhlv1.h_fak.value = '$h_fak';";
 echo "document.fhlv1.h_unk.value = '$h_unk';";
 echo "document.fhlv1.h_poz.value = '$h_poz';";
 echo "document.fhlv1.h_str.value = '$h_str';";

 echo "document.fhlv1.h_zak.value = '$h_zak';";
}
?>
    document.fhlv1.uloh.disabled = true;
    }
    
    function VyberVstup()
    {
    <?php if( $hlat != 'ANO' && $vybr != 'ANO')
    {
    ?>
    document.fhlv1.h_dat.focus();
    document.fhlv1.h_dat.select();
    <?php
    }
    ?>
    <?php if( $vybr == 'ANO' )
    {
    ?>
    document.fhlv1.h_str.focus();
    document.fhlv1.h_str.select();
    document.fhlv1.h_nai.disabled = true;
    <?php
    }
    ?>
    }

    function Hlat()
    {
    document.fhlv1.hlat.value = 'ANO';
    }

    function NeHlat()
    {
    document.fhlv1.hlat.value = 'NIE';
    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_poh.value == '' ) okvstup=0;
<?php
if( $drupoh != 3 )
{
?>
    if ( document.fhlv1.err_ico.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_fak.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_ico.value == '' ) okvstup=0;
    if ( document.fhlv1.h_fak.value == '' ) okvstup=0;
<?php
}
?>
    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (false) ; }
    }

<?php
}?>

<?php
if ( $copern == 5 ) 
{?>
    function ObnovUI()
    {
<?php if( $vybr == 'ANO' )
{
 echo "document.fhlv1.h_dok.value = '$cislo_dok';";
 echo "document.fhlv1.h_skl.value = '$cislo_skl';";
 echo "document.fhlv1.h_dat.value = '$cislo_dat';";
 echo "document.fhlv1.h_poh.value = '$cislo_poh';";
// nemozem lebo je '' echo "document.fhlv1.h_str.value = '$cislo_str';";
// nemozem lebo je '' echo "document.fhlv1.h_zak.value = '$cislo_zak';";
 echo "document.fhlv1.h_ico.value = '$vybr_ico';";
 echo "document.fhlv1.h_nai.value = '$vybr_nai';";
}
?>
<?php if( $hlat == 'ANO' )
{
 echo "document.fhlv1.h_dok.value = '$h_dok';";
 echo "document.fhlv1.h_skl.value = '$h_skl';";
 echo "document.fhlv1.h_dat.value = '$h_dat';";
 echo "document.fhlv1.h_poh.value = '$h_poh';";
// echo "document.fhlv1.h_fak.value = '$h_fak';";
// echo "document.fhlv1.h_str.value = '$h_str';";
// echo "document.fhlv1.h_zak.value = '$h_zak';";
}
?>
    document.fhlv1.uloh.disabled = true;
    document.fhlv1.nwwdok.disabled = true;
    }

    function VyberVstup()
    {
    <?php if( $hlat != 'ANO' && $vybr != 'ANO')
    {
    ?>
    document.forms.fhlv1.h_skl.selectedIndex = 0;
<?php
if( $cislo_skladu > 0  )
{
?>
    document.forms.fhlv1.h_skl.value = '<?php echo $cislo_skladu; ?>'
<?php
}
?>
    document.forms.fhlv1.h_skl.focus();
    <?php
    }
    ?>
    <?php if( $vybr == 'ANO' )
    {
    ?>
    document.fhlv1.h_str.focus();
    document.fhlv1.h_nai.disabled = true;
    <?php
    }
    ?>
    }

    function Hlat()
    {
    document.fhlv1.hlat.value = 'ANO';
    }

    function NeHlat()
    {
    document.fhlv1.hlat.value = 'NIE';
    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_poh.value == '' ) okvstup=0;
<?php
if( $drupoh != 3 )
{
?>
    if ( document.fhlv1.err_ico.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_fak.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_ico.value == '' ) okvstup=0;
    if ( document.fhlv1.h_fak.value == '' ) okvstup=0;
<?php
}
?>
    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (false) ; }
    }

<?php
}?>

<?php
if ( $copern == 48 ) 
{?>
    function ObnovUI()
    {
<?php if( $vybr == 'ANO' AND $hlad == "NIE" )
{
 echo "document.formv1.h_cis.value = '$vybr_cis';";
 echo "document.formv1.h_nat.value = '$vybr_nat';";
 echo "document.formv1.h_mer.value = '$vybr_mer';";
 echo "document.formv1.h_dph.value = '$vybr_dph';";
  if( $drupoh != 1 )
  {
 echo "document.formv1.h_cen.value = '$vybr_cen';";
 echo "document.formv1.h_mno.value = '$vybr_zas';";
  }
}
?>
<?php if( $vybr != 'ANO' AND $hlad != "ANO" )
{
 echo "document.formv1.h_cis.value = '$h_cis';";
 echo "document.formv1.h_nat.value = '$h_nat';";
 echo "document.formv1.h_mer.value = '$h_mer';";
 echo "document.formv1.h_pon.value = '$h_poz';";
}
?>
<?php
if ( $h_vcis == 1 )
   {
?>
document.formv1.h_vcis.checked = "checked";
<?php
   }
?>
    document.formv1.h_cen.value = <?php echo "$h_cen";?>;
    document.formv1.h_mno.value = <?php echo "$h_mno";?>;
    }

    function VyberVstup()
    {
    document.formv1.h_cpl.disabled = true;
    document.formv1.uloz.disabled = true;
<?php if( $vybr != 'ANO' AND $hlad != "ANO" )
{
 echo "document.formv1.h_cis.focus();";
 echo "document.formv1.h_cis.select();";
}
?>
    }

    function Hlad()
    {
    document.formv1.hlad.value = 'ANO';
    }

    function NeHlad()
    {
    document.formv1.hlad.value = 'NIE';
    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.err_cis.value == '1' ) okvstup=0;
    if ( document.formv1.err_cen.value == '1' ) okvstup=0;
    if ( document.formv1.err_mno.value == '1' ) okvstup=0;
    if ( document.formv1.h_cis.value == '' ) okvstup=0;
    if ( document.formv1.h_nat.value == '' ) okvstup=0;
    <?php if( $polno != 1 ) { ?>
    if ( document.formv1.h_cen.value == '' ) okvstup=0;
    if ( document.formv1.h_mno.value == '' ) okvstup=0;
    <?php                   } ?>
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
    }

    function Zapis_COOK()
    {

    }

    function Obnov_vstup()
    {

    }


<?php
}?>

    function DokladPDF(doklad)
    {
    window.open('poldok.php?copern=101&cislo_dok=' + doklad + '&drupoh=<?php echo $drupoh; ?>&page=1&page=1&tlacitR=1&kuch=<?php echo $kuch; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }

    function VydajkaPDF(doklad)
    {
    window.open('poldok.php?copern=101&cislo_dok=' + doklad + '&drupoh=2&page=1&page=1&tlacitR=1&kuch=<?php echo $kuch; ?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }

    function PolozkyNula(status)
    {

    window.open('pridaj_nulovepolozky.php?copern=100&status=' + status + '&drupoh=<?php echo $drupoh; ?>&cislo_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>&page=1', '_self' )

    }


function UpravSklad(skl)
                {
var uhr_mskl = skl;

//var dajism = "SM" + uhr_mskl; 

  myUhrasm = document.getElementById("SM");

  htmluhs  = " <FORM name='fskl1' method='post' action='#' ><table width='100%' ><tr>";

  htmluhs += " <td class='hvstup_zlte' width='100%' align='left'>";

  htmluhs += " <input class='hvstup' type='text' name='n_skl' id='n_skl' size='8'  value='"  + uhr_mskl +  "' />";

  htmluhs += " <img border=1 src='../obr/ok.png' style='width:15; height:15;' title='Uloûiù sklad' ";
  htmluhs += " onClick=\"UlozSklad();\">";

  htmluhs += " </td>";

  htmluhs += " </tr></table></FORM>";


  myUhrasm.innerHTML = htmluhs;


  document.forms.fskl1.n_skl.focus();
  document.forms.fskl1.n_skl.select();
                }

function UlozSklad()
                {

var n_skl = document.forms.fskl1.n_skl.value;

if( n_skl > 0 ) {
window.open('upravsklad.php?copern=1001&n_skl=' + n_skl + '&drupoh=<?php echo $drupoh; ?>&cislo_dok=<?php echo $cislo_dok; ?>', '_self' );
                 }

                }

</script>
</HEAD>
<BODY class="white" onload="window.scrollTo(0, 3000); ObnovUI(); VyberVstup();"  >

<?php
if ( $copern >= 1 )
     {
//nastavenie parametrov dokladu

?>
<div id="nastavfakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 300px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie dokladu uzv(<?php echo $kli_uzid; ?>)</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavfakx.style.display='none';" title='Zhasni menu' ></td></tr>  
                    
<tr><FORM name='enast' method='post' action='#' ><td class='ponuka' colspan='5'>
<a href="#" onClick="NastavDok();"> Chcete uloûiù nastavenie dokladu ?</a></td></tr>

<tr>
<td class='ponuka' colspan='2'>Text nad poloûkou</td>
<td class='ponuka' colspan='1'><input type='checkbox' name='ajpoznam' value='1' > </td>
<td class='ponuka' colspan='1'>/ pod poloûkou</td>
<td class='ponuka' colspan='1'><input type='checkbox' name='poznampod' value='1' ></td>
</tr>
<tr>
<td class='ponuka' colspan='2'>STR, ZAK pri poloûke</td> 
<td class='ponuka' colspan='3'><input type='checkbox' name='ajstrzak' value='1' ></td>
</tr>
<?php
if ( $ajpoznam == 1 )
   {
?>
<script type="text/javascript">
document.enast.ajpoznam.checked = "checked";
</script>
<?php
   }
?>
<?php
if ( $poznampod == 1 )
   {
?>
<script type="text/javascript">
document.enast.poznampod.checked = "checked";
</script>
<?php
   }
?>
<?php
if ( $ajstrzak == 1 )
   {
?>
<script type="text/javascript">
document.enast.ajstrzak.checked = "checked";
</script>
<?php
   }
?>
</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function NastavDok()
                {
var ajpoznam = 0;
if( document.enast.ajpoznam.checked ) ajpoznam=1;
var poznampod = 0;
if( document.enast.poznampod.checked ) poznampod=1;
var ajstrzak = 0;
if( document.enast.ajstrzak.checked ) ajstrzak=1;

window.open('dok_setuloz.php?cislo_dok=<?php echo $cislo_dok; ?>&ajpoznam=' + ajpoznam + '&poznampod=' + poznampod + '&ajstrzak=' + ajstrzak + '&kliuzid=<?php echo $kli_uzid; ?>&copern=900&drupoh=<?php echo $drupoh; ?>', '_self' );
                }


</script>
<?php
     }
//koniec nastavenie parametrov dokladu
?>


<?php 

// aktualna strana
$page = strip_tags($_REQUEST['page']);
$pagex=1;
// nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 300;
// zaciatok cyklu
$i = ( $pagex - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($pagex-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  <?php echo $cov1p; ?> z·sob
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
<?php
  if ( $copern == 5 ) echo "- nov· $dokm1p";
  if ( $copern == 8 ) echo "- ˙prava poloûiek $dokm4p";
  if ( $copern == 28 ) echo "- ˙prava z·hlavia $dokm4p";
  if ( $copern == 48 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie $dokm4p";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php

if ( $copern == 78 )
  {

$sql = mysql_query("SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, fak, unk, poz, str, zak".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE dok = $cislo_dok ".
"");

  }

if ( $copern == 6 OR $copern == 8 OR $copern == 28 )
  {
$sql = mysql_query("SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, fak, unk, poz, str, zak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, F$kli_vxcf"."_sklcis.dph, cen, mno, F$kli_vxcf"."_sklcis.mer, mn2, xmer2 ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"");
//echo "toto";
  }

if ( $copern == 48 )
  {

$sql = mysql_query("SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, fak, unk, poz, str, zak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, F$kli_vxcf"."_sklcis.dph, cen, mno, F$kli_vxcf"."_sklcis.mer ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE ( dok = $cislo_dok AND NOT( cpl = $cislo_cpl ))".
"");

  }

if ( $copern == 5 )
  {

$sql = mysql_query("SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, fak, unk, poz, str, zak".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE dok = $newdok".
"");
  }

  if ( $copern == 5 OR $copern == 6 OR $copern == 8 OR $copern == 28 OR $copern == 48 OR $copern == 78 )
     {
//zobrazenie hlavicky

$j = 0;
?>
<span style="position: absolute; top: 168; left: 50%; z-index: 200;"> 
<div id="myIcoElement"></div>
</span>
<span style="position: absolute; top: 195; left: 50%;"> 
<div id="myStrelement"></div>
</span>
<span style="position: absolute; top: 195; left: 50%;"> 
<div id="myZakelement"></div>
</span>

<span id="Str" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo strediska musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999</span>
<span id="Zak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo z·kazky musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>

<span id="NiejeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som stredisko v ËÌselnÌku </span>
<span id="NiejeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som z·kazku v ËÌselnÌku </span>
<div id="jeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>

<table class="fmenu" width="100%">
<table class="fmenu" width="50%" height="150px" align="left">
<tr></tr><tr></tr>
<?php
   while ($j <= 0 )
   {
  if (@$zaznam=mysql_data_seek($sql,$j))
  {
$riadok=mysql_fetch_object($sql);
?>
<?php
//hlavicka pri uprava a nove polozky
  if ( $copern == 6 OR $copern == 8 OR $copern == 48 OR $copern == 78 )
  {
?>
<tr>
<td class="bmenu" width="15%" >
&nbsp;»Ìslo <?php echo $dokm4p; ?>:
<a href='vstp_s.php?copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie origin·lu <?php echo $dokm4p; ?> do datab·zy" ></a>
</td>
<td class="fmenu" width="20%" >&nbsp;<?php echo $riadok->dok;?></td>
<td width="15%" >
<?php
if ( $copern != 6 AND $copern != 78 )
{
?>
<a href='vstp_u.php?copern=28&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>
&h_dat=<?php echo $riadok->dat;?>&h_poh=<?php echo $riadok->poh;?>&h_ico=<?php echo $riadok->ico;?>&h_nai=<?php echo $riadok->nai;?>
&h_fak=<?php echo $riadok->fak;?>&h_poz=<?php echo $riadok->poz;?>&h_str=<?php echo $riadok->str;?>&h_zak=<?php echo $riadok->zak;?>
&h_sk2=<?php echo $riadok->sk2;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="⁄prava z·hlavia <?php echo $dokm4p; ?>" >⁄prava z·hlavia</a>
<?php
}
?>
</td>
</tr>
<tr><td class="bmenu" >&nbsp;<?php echo $skladpd; ?></td>
<td class="fmenu" >&nbsp;<?php echo $riadok->skl;?></td></tr>
<tr><td class="bmenu" >&nbsp;D·tum <?php echo $com4p; ?>:</td><td class="fmenu" width="10%" >&nbsp;<?php echo $riadok->dat;?></td></tr>
<tr><td class="bmenu" >&nbsp;Pohyb:</td><td class="fmenu" width="10%" >&nbsp;<?php echo $riadok->poh;?></td>
<td class="bmenu" >
<?php
if ( $drupoh == 1 AND $polno == 1 AND $riadok->poh == 92 )
     {
?>
<a href="#" onClick="window.open('polno_krmnedni.php?copern=20&drupoh=1&cislo_dok=<?php echo $riadok->dok;?>&kopia_dok=<?php echo $riadok->unk;?>', '_self' )">
<img src='../obr/import.png' width=15 height=15 border=0 title="NaËÌtaù k‡mne dni za <?php echo $kli_vume;?>" ></a>


<?php
     }
?>
</tr>
<tr></tr>
<tr>
<td class="bmenu" >
<?php
       if ( ( $copern == 8 OR $copern == 48 ) AND $drupoh == 2 )
       {
?>
<a href='vstp_u.php?drupoh=<?php echo $drupoh;?>&copern=1015&page=<?php echo $page;?>&cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>'>
<img src='../obr/vlozit.png' width=15 height=15 border=1 title="Spotreba vöetk˝ch poloûiek zo skladu <?php echo $riadok->skl;?>"></a>

<a href='vstp_u.php?drupoh=<?php echo $drupoh;?>&copern=1025&page=<?php echo $page;?>&cislo_dok=<?php echo $riadok->dok;?>&cislo_zak=<?php echo $riadok->zak;?>'>
<img src='../obr/import.png' width=15 height=15 border=1 title="Spotreba vöetk˝ch poloûiek na z·kazke <?php echo $riadok->zak;?>"></a>

<?php
$pole = explode("P", $riadok->poz);
$prz=1*$pole[0];
$prx=1*$pole[1];

?>

<a href='vstp_u.php?drupoh=<?php echo $drupoh;?>&copern=1035&page=<?php echo $page;?>&cislo_dok=<?php echo $riadok->dok;?>&cislo_prx=<?php echo $prx;?>'>
<img src='../obr/orig.png' width=15 height=15 border=1 title="Spotreba vöetk˝ch poloûiek z prÌjemky <?php echo $prx;?>"></a>
<?php
       }
?>
</tr>
</table>
<table class="fmenu" width="50%" height="150px" align="left">
<tr></tr><tr></tr>
<?php
if ( $drupoh == 1 OR $drupoh == 2 )
{
?>
<tr><td class="bmenu" width="15%" >&nbsp;<?php echo $popico; ?></td><td class="fmenu" width="25%" >&nbsp;<?php echo $riadok->ico;?></td>
<td class="bmenu" width="10%" ></td>
</tr>
<tr><td class="bmenu">&nbsp;<?php echo $popnai; ?></td><td class="fmenu" >&nbsp;<?php echo $riadok->nai;?></td></tr>
<tr><td class="bmenu">&nbsp;STR Z¡K:</td><td class="fmenu" >&nbsp;<?php echo $riadok->str;?>&nbsp;<?php echo $riadok->zak;?></td></tr>
<tr><td class="bmenu">&nbsp;Fakt˙ra / UNIkÛd:</td><td class="fmenu" >&nbsp;<?php echo $riadok->fak;?> / <?php echo $riadok->unk;?></td></tr>
<?php
}
?>

<?php
       if ( $drupoh == 1 )
       {
?>
<tr></tr>
<tr><td class="bmenu">
<a href='doklad_import.php?drupoh=<?php echo $drupoh;?>&copern=1015&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/import.png' width=15 height=15 border=1 title="Import prÌjemky"></a>
<?php
$pohvyroba=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklcph WHERE poh = $riadok->poh ORDER BY poh DESC LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $ucm=1*$riaddok->ucm; 
 $ucm3=substr($ucm,0,3);
 //echo $ucm3;
 if( $ucm3 == 123 ) { $pohvyroba=1; }

 }

       if ( $pohvyroba == 1 )
         {

$unkhod=1*$riadok->unk;
?>
<td class="bmenu">
<a href='doklad_vyroba.php?drupoh=<?php echo $drupoh;?>&copern=1015&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/naradie.png' width=15 height=15 border=1 title="Spracovaù v˝robu na doklade"></a>
<?php
       if ( $unkhod > 0 )
           {
?>

<a href='#' onclick='VydajkaPDF(<?php echo $unkhod;?>);' >
<img src='../obr/tlac.png' width=15 height=15 border=1 title="VytlaËiù v˝dajku Ë.<?php echo $unkhod;?>"></a>
<?php
           }
?>
</tr>
<?php
         }
?>

</tr>
<?php
       }
?>

<?php
       if ( $drupoh == 2 )
       {
?>
<tr></tr>
<tr><td class="bmenu">
<a href="#" onclick="window.open('doklad_export.php?drupoh=<?php echo $drupoh;?>&copern=2015&cislo_dok=<?php echo $riadok->dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );" >
<img src='../obr/export.png' width=15 height=15 border=1 title="Export v˝dajky"></a>
</tr>
<?php
       }
?>

<?php
if ( $drupoh == 3 )
{
?>
<tr><td class="bmenu" width="15%" >&nbsp;</td><td class="fmenu" width="25%" >&nbsp;</td>
<td class="bmenu" width="10%" ></td>
</tr>
<tr><td class="bmenu">&nbsp;Na sklad:</td><td class="fmenu" >&nbsp;<?php echo $riadok->sk2;?></td></tr>
<tr><td class="bmenu">&nbsp;</td><td class="fmenu" >&nbsp;</td></tr>
<tr><td class="bmenu">&nbsp;</td><td class="fmenu" >&nbsp;</td></tr>
<?php
}
?>

<?php
  }
//koniec hlavicka pri uprava a nove polozky 6,8,48
//hlavicka pri uprava a nove hlavicka
  if ( $copern == 28 )
  {
?>
<tr><td class="vsttd" width="15%" >&nbsp;»Ìslo <?php echo $dokm4p; ?>:</td><td class="fmenu" width="20%" >&nbsp;<?php echo $riadok->dok;?></td>
<td class="bmenu" width="15%" ></td>
</tr>
<tr><td class="vsttd" >&nbsp;<?php echo $skladpd; ?></td>
<td class="fmenu" >
<div id='SM' >
<?php echo $riadok->skl;?> <img src='../obr/uprav.png' onClick="UpravSklad(<?php echo $riadok->skl;?>);" width=15 height=10 border=1 title='Uprav sklad' >
</div>
</td></tr>
<FORM name="fhlv1" class="obyc" method="post" action="vstp_u.php?drupoh=<?php echo $drupoh;?>&page=1&copern=38&
cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>" >
<?php
  }
  if ( $copern == 5 )
  {
?>
<FORM name="fhlv1" class="obyc" method="post" action="vstp_u.php?drupoh=<?php echo $drupoh;?>&page=1&copern=68" >
<tr><td class="bmenu" width="15%" >&nbsp;»Ìslo <?php echo $dokm4p; ?>:</td>
<td class="fmenu" width="20%" >
<input type="text" name="nwwdok" id="nwwdok" size="10" value="<?php echo $newdok;?>" onclick="Fxh.style.display='none'; document.fhlv1.uloh.disabled = true;" />
<input type="hidden" name="newdok" id="newdok" value="<?php echo $newdok;?>" />
<input type="hidden" name="h_dok" id="h_dok" value="<?php echo $newdok;?>" />
</td>
<td class="bmenu" width="15%" ></td>
</tr>
<tr><td class="bmenu">&nbsp;<?php echo $skladpd; ?></td>
<?php
$sqls = mysql_query("SELECT skl,nas FROM F$kli_vxcf"."_skl ORDER BY skl");
?>
<td class="fmenu">
<select size="1" name="h_skl" id="h_skl" onmouseover="Fxh.style.display='none';"
 document.fhlv1.uloh.disabled = true; onKeyDown="return SklEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["skl"];?>" >
<?php 
$polmen = $zaznam["nas"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["skl"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
</tr>
<?php
  }
  if ( $copern == 5 OR $copern == 28 )
  {
?>
<tr><td class="bmenu" >&nbsp;D·tum <?php echo $com4p; ?>:</td>
<td class="fmenu">
<input type="text" name="h_dat" id="h_dat" size="10" maxlength="10" value="<?php echo $h_dat;?>"
 onclick="Fxh.style.display='none'; document.fhlv1.uloh.disabled = true;" onkeyup="KontrolaDatum(this, Kx)"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_dat)" onKeyDown="return DatEnter(event.which)" />
<INPUT type="hidden" name="err_dat" value="0">
</td>
</tr>

<tr><td class="bmenu">&nbsp;Pohyb:</td>
<?php
$sqls = mysql_query("SELECT poh,nph FROM F$kli_vxcf"."_sklcph WHERE ( drp >= 1 AND drp $akedrp ) ORDER BY poh");
?>
<td class="fmenu">
<select size="1" name="h_poh" id="h_poh" onmouseover="Fxh.style.display='none'; document.fhlv1.uloh.disabled = true;" 
 onKeyDown="return PohEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["poh"];?>" >
<?php 
$polmen = $zaznam["nph"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["poh"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
</tr>

<tr></tr><tr></tr><tr></tr>
</table>

<table class="fmenu" width="50%" height="150px" align="left">
<tr></tr><tr></tr>
<?php
if ( $drupoh == 1 OR $drupoh == 2 ) 
{
?>
<tr><td class="pvstup" width="15%" >&nbsp;<?php echo $popico; ?>
<a href="#" onClick="window.open('../cis/cico.php?copern=5&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Vloûiù novÈ I»O do datab·zy" ></a>

</td>
<td class="hvstup" width="25%" >
<input class="hvstup" type="text" name="h_ico" id="h_ico" size="12" maxlength="8" value="<?php echo $h_ico;?>"
 onclick="Fxh.style.display='none'; document.fhlv1.h_nai.disabled = false; myIcoElement.style.display='none'; nulujIco();"
 onchange="return intg(this,1,99999999,Ix,document.fhlv1.err_ico)" onkeyup="KontrolaCisla(this, Ix)" 
 onKeyDown="return IcoEnter(event.which)" />

<img src='../obr/hladaj.png' border="0" title="Hæadaj zadanÈ I»O alebo n·zov firmy" onclick="myIcoElement.style.display=''; volajIco();" >

<input class="hvstup" type="hidden" name="err_ico" value="0">

</td>
<td class="pvstup" width="10%" ></td>
</tr>
<tr><td class="pvstup" >&nbsp;<?php echo $popnai; ?></td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_nai" id="h_nai" size="30" value="<?php echo $h_nai;?>"
 onKeyDown="return NaiEnter(event.which)" 
 onclick="Fxh.style.display='none'; myIcoElement.style.display='none'; nulujIco();"/>
</td>
</tr>

<?php
//hladanie polozky ponuka
if ( $hlat == 'ANO' AND $copern == 5 OR $hlat == 'ANO' AND $copern == 28 ) 
{

if ( $hlat_nai != "" ) $hsql = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ( nai LIKE '%$hlat_nai%' ) ORDER BY ico");
if ( $hlat_ico != "" ) $hsql = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ( ico = $hlat_ico ) ORDER BY ico");
$vvpol = mysql_num_rows($hsql);

//ak vvpol > 1
if ( $vvpol > 1 )
 {
?>
<script type="text/javascript">
</script>
<span style="position: absolute; top: 130;">
<iframe name="vybranie" WIDTH="89.2%" HEIGHT="105px" HSPACE="0" VSPACE="0" MARGINHEIGHT="0" MARGINWIDTH="0"
SRC="vstp_v.php?drupoh=<?php echo $drupoh;?>&page=1
<?php
if ( $copern == 5 ) 
{
?>
&copern=2&h_skl=<?php echo $h_skl;?>&h_dok=<?php echo $h_dok;?>&newdok=<?php echo $newdok;?>
<?php
}
?>
<?php
if ( $copern == 28 ) 
{
?>
&copern=12&h_dok=<?php echo $riadok->dok;?>&h_skl=<?php echo $riadok->skl;?>
<?php
}
?>
&hlat_ico=<?php echo $hlat_ico;?>&hlat_nai=<?php echo $hlat_nai;?>
&h_dat=<?php echo $h_dat;?>&h_poh=<?php echo $h_poh;?>&h_fak=<?php echo $h_fak;?>&h_poz=<?php echo $h_poz;?>
&h_str=<?php echo $riadok->str;?>&h_zak=<?php echo $riadok->zak;?>&h_sk2=<?php echo $riadok->sk2;?>
&h_unk=<?php echo $riadok->unk;?>" >
</iframe>
</span>
<?php
 }
//koniec ak vvpol > 1
}
?>

<tr>
<td class="pvstup">&nbsp;STR - Z¡K:</td>
<td class="hvstup" >
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù stredisko" onClick="volajStr(0,1);" >
<input class="hvstup" type="text" name="h_str" id="h_str" size="7" 
 onclick="myStrelement.style.display='none';"
 onchange="return intg(this,0,9999,Str,document.fhlv1.err_str)"
 onkeyup="KontrolaCisla(this, Str)" onKeyDown="return StrEnter(event.which)"
/>
<INPUT type="hidden" name="err_str" value="0">

<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù z·kazku" onClick="myZakelement.style.display=''; volajZak(0,1);" >
<input class="hvstup" type="text" name="h_zak" id="h_zak" size="7" 
 onclick="myZakelement.style.display='none';"
 onchange="return intg(this,0,9999999,Zak,document.fhlv1.err_zak)"
 onkeyup="KontrolaCisla(this, Zak)" onKeyDown="return ZakEnter(event.which)"/>
<INPUT type="hidden" name="err_zak" value="0">

</td>
</tr>

<tr><td class="bmenu" >&nbsp;<?php echo $fakv1pd; ?> / UNIkÛd:</td>
<td class="fmenu" >
<input type="text" name="h_fak" id="h_fak" size="12" maxlength="10" value="<?php echo $h_fak;?>" onclick="Fxh.style.display='none'; document.fhlv1.uloh.disabled = true;"
onchange="return intg(this,0,9999999999,Jx,document.fhlv1.err_fak)" onkeyup="KontrolaCisla(this, Jx)" 
 onKeyDown="return FakEnter(event.which)" />
 / 
<input type="text" name="h_unk" id="h_unk" size="12" maxlength="10" value="<?php echo $h_unk;?>"
 onclick="Fxh.style.display='none'; document.fhlv1.uloh.disabled = true;"
 onKeyDown="return UnkEnter(event.which)" />
<INPUT type="hidden" name="err_fak" value="0">
</td>
</tr>
<?php
}
?>

<?php
if ( $drupoh == 3 ) 
{
?>
<tr><td class="bmenu" >&nbsp;</td>
<td class="fmenu" >
<input type="text" name="h_icq" id="h_icq" size="30" value="" />
</td>
</tr>

<tr>
<td class="bmenu">&nbsp;Na sklad:</td>
<?php
$sqls = mysql_query("SELECT skl,nas FROM F$kli_vxcf"."_skl ORDER BY skl");
?>
<td class="fmenu">
<select size="1" name="h_sk2" id="h_sk2" onmouseover="Fxh.style.display='none';"
 document.fhlv1.uloh.disabled = true; onKeyDown="return Sk2Enter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["skl"];?>" >
<?php 
$polmen = $zaznam["nas"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["skl"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
</tr>
<input type="hidden" name="h_ico" id="h_ico" value="0" />
<input type="hidden" name="h_nai" id="h_nai" value="" />
<input type="hidden" name="h_fak" id="h_fak" value="0" />
<input type="hidden" name="h_unk" id="h_unk" value="0" />

<tr><td class="bmenu" >&nbsp;</td>
<td class="fmenu" >
<input type="text" name="h_naq" id="h_naq" size="30" value="" />
</td>
</tr>

<tr><td class="bmenu" >&nbsp;</td>
<td class="fmenu" >
<input type="text" name="h_faq" id="h_faq" size="30" value="" />
</td>
</tr>

<?php
}
?>


<?php
//hladanie polozky ponuka
if ( $hlat == 'ANO' AND $copern == 5 OR $hlat == 'ANO' AND $copern == 28 ) 
{

//ak vvpol = 1
if ( $vvpol == 1 )
 {
  if (@$hzaznam=mysql_data_seek($hsql,0))
    {
  $hriadok=mysql_fetch_object($hsql);
    }
?>
<script type="text/javascript">
document.fhlv1.h_ico.value = "<?php echo $hriadok->ico;?>";
document.fhlv1.h_nai.value = "<?php echo $hriadok->nai;?>";
document.fhlv1.h_nai.disabled = true;
document.fhlv1.h_str.focus();
</script>
<?php
 }
//koniec ak vvpol = 1

//ak vvpol = 0
if ( $vvpol == 0 )
 {
?>
<script type="text/javascript">
document.fhlv1.h_ico.value = "<?php echo $hlat_ico;?>";
document.fhlv1.h_nai.value = "<?php echo $hlat_nai;?>";
document.fhlv1.h_ico.focus();
document.fhlv1.h_ico.select();
</script>
<?php
 }
//koniec ak vvpol = 0

}
//koniec hladanie
?>

<?php //<tr><td class="vsttd" ></td></tr> ?>

<?php
  }
//koniec hlavicka pri uprava a nove hlavicka
?>
<?php
  }
$j = $j + 1;
   }
?>
<tr></tr><tr></tr>
</table>

<br clear=left>

<table class="fmenu" width="100%">
<?php
//tabulka poznamka 
  if ( $copern == 6 OR $copern == 8 OR $copern == 48 OR $copern == 78 )
  {
?>
<tr><td class="bmenu" width="15%" >

&nbsp&nbsp<img src='../obr/naradie.png' onClick="nastavfakx.style.display='';" width=15 height=15 border=0 title="Nastaviù parametre pdokladu" ></a>

&nbsp&nbspPozn·mka:</td><td class="fmenu" width="55%" >&nbsp;<?php echo $riadok->poz;?></td>
<td class="bmenu" width="20%" >&nbsp;(Nebude vytlaËen· na doklade)

<?php
if ( $drupoh == 2 AND $fir_xsk04 == 1 )
  {
?>
<a href="#" onClick="PolozkyNula(0)">
P0<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Pridaj do dokladu Poloûky v sklade s nulov˝m mnoûstvom a nenulovou hodnotou" ></a>

<a href="#" onClick="PolozkyNula(1)">
P1<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Pridaj do dokladu Poloûky v sklade so z·pornou priemernou cenou a nenulovou hodnotou" ></a>
<?php
  }
?>

</td>
<td class="bmenu" width="5%" >
<?php
       if ( $copern == 8 )
       {
?>
<a href='vstp_u.php?drupoh=<?php echo $drupoh;?>&copern=166&page=<?php echo $page;?>&cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $cislo_skl;?>'>
<img src='../obr/kos.png' width=15 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek dokladu"></a>
<?php
       }
?>
</td>
</tr>
<?php
  }
?>
<?php
  if ( $copern == 5 OR $copern == 28 )
  {
?>
<tr>
<td class="bmenu" width="15%" >&nbsp;Pozn·mka:</td>
<td class="fmenu" width="55%" >
<input type="text" name="h_poz" id="h_poz" size="80" maxlength="80" value="<?php echo $h_poz;?>" onclick="Fxh.style.display='none'; document.fhlv1.uloh.disabled = true;"
 onKeyDown="return PozEnter(event.which)" /></td>
<td class="bmenu" width="20%" >&nbsp;(Nebude vytlaËen· na doklade)</td><td class="bmenu" width="5%" >&nbsp;</td>
</tr>
<tr>
<td>
<INPUT type="submit" id="uloh" name="uloh" value="Uloûiù"  
 onmouseover="UkazSkryj('Uloûiù ˙pravy z·hlavia, ˙prava poloûiek <?php echo $dokm4p; ?>'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<?php
  if ( $copern == 28 )
  {
?>
<td>
<a href='vstp_u.php?copern=8&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>
&h_cpl=<?php echo $riadok->cpl;?>&h_cis=<?php echo $riadok->cis;?>&h_nat=<?php echo $riadok->nat;?>&h_cen=<?php echo $riadok->cen;?>
&h_mno=<?php echo $riadok->mno;?>&h_mer=<?php echo $riadok->mer;?>&h_str=<?php echo $riadok->str;?>&h_zak=<?php echo $riadok->zak;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="⁄prava poloûiek vybranej <?php echo $dokm4p; ?>" >⁄prava poloûiek</a>
</td>
<?php
  }
?>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstpoh.php?drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="bmenu" ></td><td class="bmenu"></td>
<td class="obyc" ><INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('Neuloûiù ˙pravy z·hlavia , n·vrat do zoznamu <?php echo $dokm4pm; ?>')" onmouseout="Okno.style.display='none';"></td>
</FORM>

</tr>

<?php
  }
?>

</table>
<tr>
<span id="Fxh" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ix" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O dod·vateæa musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Jx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo dod·vateæskej fakt˙ry musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Kx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Uph" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Z·hlavie DOK=<?php echo $cislo_dok;?> upravenÈ</span>
</tr>


<?php
//koniec zobrazenie hlavicky
     }
?>


<?php
// toto je cast na zobrazenie poloziek
// 1=volanie z vstpoh.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 6=mazanie celej prijemky,36=mazanie polozky
// 7=hladanie
// 9=hladanie
if ( $copern >= 1 )
     {

if ( $copern <= 0 ) break;

// zobraz vsetky polozky
    do
    {

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
?>

<table class="fmenu" width="100%" >

<tr>
<td width="5%" class="hmenu">Por.ËÌslo
<?php if( $ajstrzak == 1 ) { ?>
<td width="5%" class="hmenu">STR<td width="5%" class="hmenu">Z¡K
<?php                   } ?>
<td width="10%" class="hmenu">
<a href='freecis.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="VoænÈ ËÌsla materi·lu"></a>
»Ìslo materi·lu
<td width="30%" class="hmenu">N·zov materi·lu<td width="5%" class="hmenu">DPH
<td width="10%" class="hmenu">Cena<td width="10%" class="hmenu">Mnoûstvo<td width="10%" class="hmenu">MJ
<td width="5%" class="hmenu">Uprav<td width="5%" class="hmenu">Zmaû
</tr>

<?php
//zaciatok vypisu
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
  if ( $riadok->cis != 0 )
     {
?>
<?php if( $ajpoznam == 1 ) { ?>
<tr>
<td class="bmenu" colspan="2"> </td>
<?php if( $ajstrzak == 1 ) { ?>
<td class="bmenu" colspan="2"> </td>
<?php                      } ?>
<td class="fmenu" colspan="2"><?php echo $riadok->poz;?></td>
</tr>
<?php                   } ?>

<tr>
<td class="fmenu" ><?php echo $riadok->cpl;?></td>

<?php if( $ajstrzak == 1 ) { ?>
<td class="fmenu" ><?php echo $riadok->str;?></td>
<td class="fmenu" ><?php echo $riadok->zak;?></td>
<?php                   } ?>

<td class="fmenu" >
<a href="#" onClick="window.open('cis_udaje.php?copern=20&cislo_cis=<?php echo $riadok->cis;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="DoplÚuj˙ce ˙daje o materi·lovej, tovarovej poloûke" >
</a>

<?php echo $riadok->cis;?></td>
<td class="fmenu" ><?php echo $riadok->nat;?></td>
<td class="fmenu" ><?php echo $riadok->dph;?></td>
<td class="fmenu" ><?php echo $riadok->cen;?></td>
<td class="fmenu" ><?php echo $riadok->mno;?></td>
<td class="fmenu" ><?php echo $riadok->mer;?></td>
<?php 
$hodnota = $riadok->cen*$riadok->mno;
$celkom = $celkom + $hodnota;
$Cislo=$hodnota+"";
$sText=sprintf("%0.2f", $Cislo);
$Cislo=$celkom+"";
$sCelkom=sprintf("%0.2f", $Cislo);
?>
<td class="fmenu" >
<?php
  if ( $copern == 8 AND $drupoh != 3 )
  {
?>
<a href='vstp_u.php?copern=48&drupoh=<?php echo $drupoh;?>&page=1&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>
&h_cpl=<?php echo $riadok->cpl;?>&h_cis=<?php echo $riadok->cis;?>&h_nat=<?php echo $riadok->nat;?>&h_cen=<?php echo $riadok->cen;?>
&h_mno=<?php echo $riadok->mno;?>&h_mer=<?php echo $riadok->mer;?>&h_poz=<?php echo $riadok->poz;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="⁄prava vybranej poloûky" ></a>
<?php
  }
?>
</td>
<td class="fmenu" >
<?php
  if ( $copern == 8 )
  {
?>
<a href='vstp_u.php?copern=36&drupoh=<?php echo $drupoh;?>&page=1&cislo_cpl=<?php echo $riadok->cpl;?>
&cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>
&h_skl=<?php echo $riadok->skl;?>&h_dok=<?php echo $riadok->dok;?>&h_dat=<?php echo $riadok->dat;?>&h_poh=<?php echo $riadok->poh;?>
&h_ico=<?php echo $riadok->ico;?>&h_nai=<?php echo $riadok->nai;?>&h_fak=<?php echo $riadok->fak;?>&h_poz=<?php echo $riadok->poz;?>
&h_str=<?php echo $riadok->str;?>&h_zak=<?php echo $riadok->zak;?>&h_sk2=<?php echo $riadok->sk2;?>
&h_cis=<?php echo $riadok->cis;?>&h_cen=<?php echo $riadok->cen;?>&h_mno=<?php echo $riadok->mno;?>
&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazanie vybranej poloûky" ></a>
<?php
  }
?>
</td>
</tr>
<?php
$mn2=1*$riadok->mn2;
$xmer2=$riadok->xmer2;
$Cislo=$mn2+"";
$Smn2=sprintf("%0.3f", $Cislo);
  if ( $mn2 != 0 )
  {
?>
<tr>
<td class="hmenu" colspan="4" > </td>
<?php if( $ajstrzak == 1 ) { ?>
<td colspan="2" class="hmenu"> 
<?php                   } ?>
<td class="hmenu"  align="right">2.MJ </td>
<td class="fmenu"  ><?php echo $Smn2;?></td>
<td class="fmenu"  ><?php echo $xmer2;?></td>
</tr>
<?php
  }
?>


<?php
    }
  }
$i = $i + 1;
   }
// koniec vypisu
?>
<?php
    } while (false);
// koniec zobraz vsetky polozky
?>

<?php
// 6=vymazanie prijemky
if ( $copern == 6 )
  {
?>

<FORM name="formv2" class="obyc" method="post" action="vstpoh.php?drupoh=<?php echo $drupoh;?>&page=1&copern=16&
cislo_dok=<?php echo $riadok->dok;?>&cislo_skl=<?php echo $riadok->skl;?>&cislo_skladu=<?php echo $riadok->skl;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="Vymazaù" 
 onmouseover="UkazSkryj('Vymazaù vybran˙ <?php echo $dokm2p; ?>')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="vstpoh.php?drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno" 
 onmouseover="UkazSkryj('Nevymazaù vybran˙ <?php echo $dokm2p; ?> , n·vrat do zoznamu <?php echo $dokm4pm; ?>')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
</table>

<?php
  }
//koniec pre vymazanie prijemky
?>

<?php
// 5=nova prijemka zahlavie
if ( $copern == 5 OR $copern == 28 )
  {
?>
</table>
<?php
  }
//koniec nova prijemka zahlavie
?>

<?php
mysql_free_result($sql);
//zobraz pre novu polozku
if ( $copern == 8 OR $copern == 48 OR $copern == 78 )
     {
?>
<tr>
<span id="Cx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo materi·lu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 N·kupn· cena materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Des4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 N·kupn· cena materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0.0001 aû 99999999 max. 4 desatinnÈ miesta</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Mnoûstvo materi·lu musÌ byù desatinnÈ ËÌslo v rozsahu 0.001 aû 999999 max. 3 desatinnÈ miesta</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $h_cis;?> CEN=<?php echo $h_cen;?> spr·vne uloûen·</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $h_cis;?> CEN=<?php echo $h_cen;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CIS=<?php echo $h_cis;?> CEN=<?php echo $h_cen;?> upraven·</span>
<?php
if ( $drupoh == 1 OR $h_vcis == 1 )
  {
?>
<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nov· poloûka CIS , zadajte n·zov , DPH aj MJ</span><?php
  }
?>
<?php
if ( $drupoh != 1 AND $h_vcis != 1 )
  {
?>
<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Poloûka CIS nie je na z·sobe v sklade <?php echo $cislo_skl;?> , oznaËte checkbox a hæadajte v celom ËÌselnÌku materi·lu</span><?php
  }
?>
<?php
if ( $drupoh != 1 AND $h_vcis == 1 )
  {
?>
<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span><?php
  }
?>

</tr>
<FORM name="formv1" class="obyc" method="post" action="vstp_u.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&
<?php if ( $copern == 8 ) {echo "copern=18"; } ?>
<?php if ( $copern == 8 ) {echo "&cislo_skl=$cislo_skl&cislo_dok=$cislo_dok"; } ?>
<?php if ( $copern == 78 ) {echo "copern=19"; } ?>
<?php if ( $copern == 78 ) {echo "&cislo_skl=$cislo_skl&cislo_dok=$cislo_dok"; } ?>
<?php if ( $copern == 48 ) {echo "copern=58"; } ?>
<?php if ( $copern == 48 ) {echo "&cislo_skl=$cislo_skl&cislo_dok=$cislo_dok&cislo_cpl=$cislo_cpl&hp_cen=$h_cen
&hp_cis=$h_cis&hp_skl=$cislo_skl&hp_mno=$h_mno"; } ?>
" >
<?php if( $ajpoznam == 0 ) { ?>
<input type="hidden" name="h_pon" id="h_pon" value="" /></td>
<?php                      } ?>

<?php if( $ajpoznam == 1 ) { ?>
<tr>
<?php if( $ajstrzak == 1 ) { ?>
<td class="bmenu" colspan="2"> </td>
<?php                      } ?>
<td class="bmenu" colspan="2">Text nad poloûkou:</td>
<td class="fmenu" colspan="2"><input type="text" name="h_pon" id="h_pon" size="50" /></td>
</tr>
<?php                   } ?>

<tr>
<td class="fmenu"><input type="text" name="h_cpl" id="h_cpl" size="7" /></td>

<?php if( $ajstrzak == 1 ) { ?>
<td class="fmenu"><img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù stredisko" onClick="volajStr(0,1);" >
<input class="hvstup" type="text" name="h_str" id="h_str" size="4" 
 onclick="myStrelement.style.display='none';"
 onchange="return intg(this,0,9999,Str,document.formv1.err_str)"
 onkeyup="KontrolaCisla(this, Str)" onKeyDown="return StrEnter(event.which)"
/>
<INPUT type="hidden" name="err_str" value="0"></td>
<td class="fmenu"><img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù z·kazku" onClick="myZakelement.style.display=''; volajZak(0,1);" >
<input class="hvstup" type="text" name="h_zak" id="h_zak" size="4" 
 onclick="myZakelement.style.display='none';"
 onchange="return intg(this,0,9999999,Zak,document.formv1.err_zak)"
 onkeyup="KontrolaCisla(this, Zak)" onKeyDown="return ZakEnter(event.which)"/>
<INPUT type="hidden" name="err_zak" value="0"></td>
<?php                   } ?>

<td class="fmenu"><input type="text" name="h_cis" id="h_cis" size="15" 
onchange="return intg(this,1,9999999999999,Cx,document.formv1.err_cis)"
 onclick="document.formv1.h_nat.disabled = false; ZhasniSP(); mySklcisElement.style.display='none'; nulujSklcis();"
 onkeyup="KontrolaCisla(this, Cx)" onKeyDown="return CisEnter(event.which)"/>
<INPUT type="hidden" name="err_cis" value="0"></td>

<td class="fmenu">
<img src='../obr/hladaj.png' border="0" title="Hæadaj zadanÈ ËÌslo alebo n·zov materi·lu" onclick="mySklcisElement.style.display=''; volajSklcis();" >
<?php
if ( $drupoh != 1 )
  {
?>
<input type="checkbox" name="h_vcis" id="h_vcis" value="0"
 onmouseover="UkazSkryj(' Pri v˝daji program hæad· poloûku na z·sobe v sklade podæa skladu v z·hlavÌ dokladu , ak ju nen·jde a oznaËÌte tento checkbox , bude program hæadaù poloûku vo vöetk˝ch skladoch ')" onmouseout="Okno.style.display='none';" />
<?php
  }
?>
<input type="hidden" name="hlad" id="hlad" value="NIE" />
<input type="text" name="h_nat" id="h_nat" size="40" maxlength="40" onclick="ZhasniSP(); mySklcisElement.style.display='none'; volajSklcis();" 
 onKeyDown="return NatEnter(event.which)" />
</td>


<td class="fmenu">
<select size="1" name="h_dph" id="h_dph" onmouseover="Fx.style.display='none';" onKeyDown="return DphEnter(event.which)">
<option value="<?php echo $fir_dph2;?>" ><?php echo $fir_dph2;?></option>
<option value="<?php echo $fir_dph1;?>" ><?php echo $fir_dph1;?></option>
<option value="0" >0</option>
<option value="<?php echo $fir_dph3;?>" ><?php echo $fir_dph3;?></option>
<option value="<?php echo $fir_dph4;?>" ><?php echo $fir_dph4;?></option>
</td>

<td class="fmenu"><input type="text" name="h_cen" id="h_cen" size="10" 
onchange="return cele(this,0.0001,99999999,Des4,4,document.formv1.err_cen)" onclick="Fx.style.display='none';"
 onkeyup="KontrolaDcisla(this, Des4)" onKeyDown="return CenEnter(event.which)" />
<INPUT type="hidden" name="err_cen" >

<td class="fmenu"><input type="text" name="h_mno" id="h_mno" size="10" 
onchange="return cele(this,-999999,999999,Ex,3,document.formv1.err_mno)" onclick="Fx.style.display='none';"
 onkeyup="KontrolaDcisla(this, Ex)" onKeyDown="return MnoEnter(event.which)" />
<INPUT type="hidden" name="err_mno" >

<td class="fmenu"><input type="text" name="h_mer" id="h_mer" size="3" onClick="return Povol_uloz();"
onKeyDown="return MerEnter(event.which)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="3" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="3" /></td>
<input type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />
<input type="hidden" name="h_skl" id="h_skl" value="<?php echo $cislo_skl;?>" />
<input type="hidden" name="h_dat" id="h_dat" value="<?php echo $riadok->dat;?>" />
<input type="hidden" name="h_poh" id="h_poh" value="<?php echo $riadok->poh;?>" />
<input type="hidden" name="h_sk2" id="h_sk2" value="<?php echo $riadok->sk2;?>" />
<input type="hidden" name="h_ico" id="h_ico" value="<?php echo $riadok->ico;?>" />
<input type="hidden" name="h_fak" id="h_fak" value="<?php echo $riadok->fak;?>" />
<input type="hidden" name="h_unk" id="h_unk" value="<?php echo $riadok->unk;?>" />
<input type="hidden" name="h_poz" id="h_poz" value="<?php echo $riadok->poz;?>" />
<?php if( $ajstrzak == 0 ) { ?>
<input type="hidden" name="h_str" id="h_str" value="<?php echo $riadok->str;?>" />
<input type="hidden" name="h_zak" id="h_zak" value="<?php echo $riadok->zak;?>" />
<?php                   } ?>
</tr>


<tr>
<td class="hmenu" colspan="4" > </td>
<?php if( $ajstrzak == 1 ) { ?>
<td colspan="2" class="hmenu"> 
<?php                   } ?>

<?php
$jemer2=0;
$zvieratapolno=0;

$sqldokttt = "SELECT * FROM F$kli_vxcf"."_sklzas".
" LEFT JOIN F$kli_vxcf"."_sklcisudaje".
" ON F$kli_vxcf"."_sklzas.cis=F$kli_vxcf"."_sklcisudaje.xcis".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklzas.skl=F$kli_vxcf"."_skl.skl".
" WHERE xmerx = 1 AND F$kli_vxcf"."_sklzas.skl = $cislo_skl ";


$sqldok = mysql_query("$sqldokttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jemer2=1;
  $zvieratapolno=$riaddok->ucs;
  }
$zvieratapolno3=substr($zvieratapolno,0,3);
if( $polno == 1 AND $zvieratapolno3 != 124 ) { $zvieratapolno3=0; }

//echo $jemer2." ".$zvieratapolno3;
?>
<?php if( $jemer2 == 1 OR $zvieratapolno3 == 124) {  ?>
<td class="hmenu"  align="right">2.MJ</td>
<td class="hmenu" ><input type='text' name='h_mn2' id='h_mn2' size='10' onKeyDown='return Mn2Enter(event.which)' /></td>
<?php                    } ?>
<td class="hmenu" ><div id="myMer2element"></div><input type='hidden' name='h_mrx' id='h_mrx' value='0' /></td>
</tr>

<?php

//hladanie polozky ponuka
//[[[[[[[[[[[
if ( $hlad == 'ANO' AND $copern == 8 OR $hlad == 'ANO' AND $copern == 78 OR $hlad == 'ANO' AND $copern == 48 ) 
{

if ( $hlad_nat != "" )
  {
if ( $drupoh == 1 )
    {
$sqt = "SELECT cis,nat,mer,dph".
" FROM F$kli_vxcf"."_sklcis WHERE ( nat LIKE '%$hlad_nat%' ) ORDER BY cis".
"";
    }
if ( $drupoh != 1 )
    {
$akyskl = 'skl = '.$cislo_skl;
if( $h_vcis == 1 ) $akyskl = 'skl > 0';
$sqt = "SELECT skl, F$kli_vxcf"."_sklzas.cis, F$kli_vxcf"."_sklcis.nat, F$kli_vxcf"."_sklcis.mer,".
" F$kli_vxcf"."_sklcis.dph, cen, zas".
" FROM F$kli_vxcf"."_sklzas".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklzas.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE ( F$kli_vxcf"."_sklcis.nat LIKE '%$hlad_nat%' AND "."$akyskl"." )".
"";
    }
$sql = mysql_query("$sqt");
  }

if ( $hlad_cis != "" )
  {
if ( $drupoh == 1 )
    {
$sqt = "SELECT * FROM F$kli_vxcf"."_sklcis WHERE ( cis = '$hlad_cis' ) ORDER BY cis";
    }
if ( $drupoh != 1 )
    {
$akyskl = 'skl = '.$cislo_skl;
if( $h_vcis == 1 ) $akyskl = 'skl > 0';
$sqt = "SELECT skl, F$kli_vxcf"."_sklzas.cis, F$kli_vxcf"."_sklcis.nat, F$kli_vxcf"."_sklcis.mer,".
" F$kli_vxcf"."_sklcis.dph, cen, zas".
" FROM F$kli_vxcf"."_sklzas".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklzas.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE ( F$kli_vxcf"."_sklzas.cis = '$hlad_cis' AND "."$akyskl"." )".
"";
    }
$sql = mysql_query("$sqt");
  }


if ( $hlad_cis == "" AND $hlad_nat == "") $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis WHERE ( cis = 99999999999999 ) ORDER BY cis");
$vpol = mysql_num_rows($sql);

//ak vpol = 1
if ( $vpol == 1 )
 {
  if (@$zaznam=mysql_data_seek($sql,0))
    {
  $riadok=mysql_fetch_object($sql);
    }
?>
<?php
if ( $drupoh == 1 )
    {
?>
<script type="text/javascript">
document.formv1.h_cis.value = "<?php echo $riadok->cis;?>";
document.formv1.h_nat.value = "<?php echo $riadok->nat;?>";
document.formv1.h_mer.value = "<?php echo $riadok->mer;?>";
document.formv1.h_dph.value = "<?php echo $riadok->dph;?>";
document.formv1.h_nat.disabled = true;
document.formv1.h_cen.focus();
document.formv1.h_cen.select();
</script>
<?php
 }
?>
<?php
if ( $drupoh != 1 )
    {
?>
<script type="text/javascript">
document.formv1.h_cis.value = "<?php echo $riadok->cis;?>";
document.formv1.h_nat.value = "<?php echo $riadok->nat;?>";
document.formv1.h_mer.value = "<?php echo $riadok->mer;?>";
document.formv1.h_dph.value = "<?php echo $riadok->dph;?>";
document.formv1.h_cen.value = "<?php echo $riadok->cen;?>";
document.formv1.h_mno.value = "<?php echo $riadok->zas;?>";
document.formv1.h_nat.disabled = true;
document.formv1.h_mno.focus();
document.formv1.h_mno.select();
</script>
<?php
 }
?>
<?php
 }
//koniec ak vpol = 1

//ak vpol = 0
if ( $vpol == 0 )
 {
  if ( $hlad_cis != "" )
   {
?>
<script type="text/javascript">
document.formv1.h_cis.value = "<?php echo $hlad_cis;?>";
document.formv1.h_nat.disabled = false;
New.style.display="";
document.formv1.h_nat.focus();
document.formv1.h_nat.select();
</script>
<?php
   }
  if ( $hlad_cis == "" )
   {
?>
<script type="text/javascript">
document.formv1.h_nat.value = "<?php echo $hlad_nat;?>";
New.style.display="none";
document.formv1.h_nat.focus();
document.formv1.h_nat.select();
</script>
<?php
   }
 }
//koniec ak vpol = 0


//ak vpol > 1
if ( $vpol > 1 )
 {
?>

<script type="text/javascript">
document.formv1.h_cis.value = '<?php echo $hlad_cis;?>';
document.formv1.h_nat.value = '<?php echo $hlad_nat;?>';
document.formv1.h_mer.value = '<?php echo $hlad_mer;?>';
document.formv1.h_cis.focus();
document.formv1.h_cis.select();
</script>
</table>
<iframe name="vybranie" WIDTH="100%" HEIGHT="100px" HSPACE="0" VSPACE="0" MARGINHEIGHT="0" MARGINWIDTH="0"
SRC="vstp_v.php?drupoh=<?php echo $drupoh;?>&page=1&h_vcis=<?php echo $h_vcis;?>
<?php
if ( $copern == 8 OR $copern == 78 ) 
{
?>
&copern=1
<?php
}
?>
<?php
if ( $copern == 48 ) 
{
?>
&copern=11&cislo_cpl=<?php echo $cislo_cpl;?>&h_cen=<?php echo $h_cen;?>&h_mno=<?php echo $h_mno;?>
<?php
}
?>
&h_dok=<?php echo $h_dok;?>&h_skl=<?php echo $h_skl;?>
&hlad_cis=<?php echo $hlad_cis;?>&hlad_nat=<?php echo $hlad_nat;?>" >

</iframe>
<table class="fmenu" width="100%" >
<tr>
<td class="vsttd" width="10%" ></td>
<td class="vsttd" width="15%" ></td>
<td class="vsttd" width="40%" ></td>
<td class="vsttd" width="10%" ></td>
<td class="vsttd" width="10%" ></td>
<td class="vsttd" width="5%" ></td>
<td class="vsttd" width="5%" ></td>
<td class="vsttd" width="5%" ></td>
</tr>
<?php
 }
//koniec ak vpol > 1
}
//koniec hladanie polozky ponuka
?>

<tr>
<td colspan="2" class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" 
 onmouseover="UkazSkryj('Uloûiù poloûku do <?php echo $dokm4p; ?>')" onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td></td>
<?php
if ( $copern == 8 OR $copern == 78 )
{
?>
<td colspan="2" class="obyc" align="right"></td>
</FORM>
</tr>

<tr>
<FORM name="formv4" class="obyc" method="post" action="vstpoh.php?drupoh=<?php echo $drupoh;?>&page=1&copern=1&cislo_skladu=<?php echo $riadok->skl;?>" >
<td class="obyc" colspan="2" align="left" ><INPUT type="submit" id="stornou" name="stornou" value="Zoznam"
 onmouseover="UkazSkryj('N·vrat do zoznamu <?php echo $dokm4pm; ?>')" onmouseout="Okno.style.display='none';" ></td>
</FORM>
<FORM name="forma4"class="obyc" method="post" action="vstp_u.php?copern=5&drupoh=<?php echo $drupoh;?>&page=1&cislo_skladu=<?php echo $riadok->skl;?>" >
<td class="obyc" colspan="2" align="left" ><INPUT type="submit" name="npol" id="npol" value="Nov· <?php echo $dokm1p; ?>"
 onmouseover="UkazSkryj('Vytvoriù nov˙ <?php echo $dokm2p; ?>')" onmouseout="Okno.style.display='none';" ></td>
</FORM>
<td class="obyc" align="right" >
<?php
$tlaclenpdf=1;
if( $kli_vrok < 2014 ) { $tlaclenpdf=0; }
if( $_SESSION['nieie'] == 1 ) { $tlaclenpdf=1; }
//$tlaclenpdf=0;
?>
<?php if( $tlaclenpdf == 0 )  { ?>
<a href="#" onClick="window.open('vstp_t.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=30 height=15 border=0 title="VytlaËiù doklad" >TlaËiù</a>
<?php                                } ?>

<?php if( $tlaclenpdf == 1 )  { ?>
<a href="#" onClick="DokladPDF(<?php echo $riadok->dok;?>);"><img src='../obr/tlac.png' width=30 height=15 border=0 title="VytlaËiù doklad" >TlaËiù</a>
<?php                                } ?>

<img src='../obr/pdf.png' width=15 height=15 border=0 onClick='DokladPDF(<?php echo $riadok->dok;?>);' title="TlaË dokladu Ë.<?php echo $riadok->dok;?> vo form·te PDF" >


</td>
<?php
}
?>
<?php
if ( $copern == 48 )
{
?>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="vstp_u.php?drupoh=<?php echo $drupoh;?>&page=1&copern=8&cislo_skl=<?php echo $cislo_skl;?>&cislo_dok=<?php echo $cislo_dok;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Nasp‰ù" 
 onmouseover="UkazSkryj('Neupravovaù vybran˙ poloûku, uloûiù bez zmien')" onmouseout="Okno.style.display='none';" ></td>
<td class="obyc"><SPAN id="vypis">&nbsp;</SPAN></td>
</FORM>
<?php
}
?>
</tr>
</table>
<div id="mySklcisElement"></div>
<?php
     }
//koniec zobrazenia pre novu polozku
?>
<table class="fmenu" width="100%">
<tr>
<td class="obyc" align="right">
&nbsp;Celkom <?php echo $com1p; ?>:&nbsp;<?php echo $sCelkom;?>&nbsp;<?php echo $mena1;?>&nbsp;&nbsp;&nbsp;
</td>
</tr>
</table>
  <div id="Okno"></div>

<?php
// toto je koniec casti na zobrazenie poloziek 
     }

$cislista = include("skl_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
