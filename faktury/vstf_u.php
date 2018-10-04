<HTML>
<?php

$copern = 1*strip_tags($_REQUEST['copern']);
$sys = 'FAK';
$urov = 2000;
$cslm=301880;
$drupoh = strip_tags($_REQUEST['drupoh']);
$regpok = 1*$_REQUEST['regpok'];
if( $drupoh == 31 OR $drupoh == 12 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
$sys = 'DOP';
$urov = 2000;
if( $regpok == 1 ) { $sys = 'FAK'; }
}
$DOPRAVA = "DOPRAVA";
$vyroba = $_REQUEST['vyroba'];
if(!isset($vyroba)) $vyroba = 0;
if($vyroba == 1 ) $DOPRAVA = "V›ROBA";

if( $drupoh == 1 ) { $cslm=301881; }
if( $drupoh == 2 ) { $cslm=301882; }
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {
//5=nova faktura zadavanie udajov po vyplneni ide na 68 ulozi a vrati sa do vstfak.php ako copern=1
//6=vymazanie faktury  po odsuhlaseni sa vrati sa do vstfak.php ako copern na 16
//8=uprava faktury po vyplneni ide na 78 ulozi a vrati sa do vstfak.php ako copern na 1
//7=z novej 5 alebo upravy 8 po odpaleni sluzby ulozi 68 alebo 78 hlavicku a ide na vstup sluzieb
//77=ulozenie polozky sluzby do fakslu,sklfak a naspat do copern na 7
//36=vymazanie polozky sluzby a naspat do copern na 7
//87=vybral som polozku sluzieb na upravu a 88 update upravenej a naspat do copern na 7
//97=vybral som textovu polozku sluzieb na upravu a 98 update upravenej textovej a naspat do copern na 7
//Pri dodacich listoch parametricky popisky a vymenil som h_fak a h_dol pri zapise ale vo formularoch som nic nemenil


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$tlaclenpdf=1;
if( $kli_vrok < 2014 ) { $tlaclenpdf=0; }
if( $_SESSION['nieie'] == 1 ) { $tlaclenpdf=1; }


$tlacitkoenter=0;
//if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $tlacitkoenter=1; }
if( $copern == 6 ) { $tlacitkoenter=0; }
$itstablet=0;
if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $itstablet=1; }
if( $_SESSION['ie10'] == 1 ) { $itstablet=0; }

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvfak";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../faktury/vtvfak.php");
endif;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");
//zaokruhlenie
$sZao = include("../funkcie/zaokruhli_hod.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = strip_tags($_REQUEST['drupoh']);
$uctovat = 1*strip_tags($_REQUEST['uctovat']);

//echo $uctovat;

$ucto_sys=$_SESSION['ucto_sys'];
//echo $ucto_sys;
if( $ucto_sys == 1 )
{
$rozuct='ANO';
$sysx='UCT';
}

$pocstav = $_REQUEST['pocstav'];
if(!isset($pocstav)) $pocstav=$_SESSION['pocstav'];

if( $pocstav == 1 AND ( $copern == 5 OR $copern == 6 OR $copern == 8 OR $copern == 68 OR $copern == 78 ) )
{
//echo "mazem";
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctsaldopoco ';
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctsaldopocd ';
$vytvor = mysql_query("$vsql");
}


if ( $rozuct == 'ANO' OR $pocstav == 1 ) $fir_xfa04=1;

$page = strip_tags($_REQUEST['page']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);
$h_uce = strip_tags($_REQUEST['h_uce']);
$h_dok = strip_tags($_REQUEST['h_dok']);
$nwwdok = strip_tags($_REQUEST['nwwdok']);
$h_fak = strip_tags($_REQUEST['h_fak']);
$h_sz3 = strip_tags($_REQUEST['h_sz3']);
$h_dat = strip_tags($_REQUEST['h_dat']);
$h_dav = strip_tags($_REQUEST['h_dav']);
$h_daz = strip_tags($_REQUEST['h_daz']);
$h_das = strip_tags($_REQUEST['h_das']);
$h_skl = strip_tags($_REQUEST['h_skl']);
$h_poh = strip_tags($_REQUEST['h_poh']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_nai = strip_tags($_REQUEST['h_nai']);
$h_dol = strip_tags($_REQUEST['h_dol']);
$h_prf = strip_tags($_REQUEST['h_prf']);
$h_ksy = strip_tags($_REQUEST['h_ksy']);
$h_ssy = strip_tags($_REQUEST['h_ssy']);
$h_poz = strip_tags($_REQUEST['h_poz']);
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_txp = strip_tags($_REQUEST['h_txp']);
$h_txz = strip_tags($_REQUEST['h_txz']);
$zmen = strip_tags($_REQUEST['zmen']);
$kurz = strip_tags($_REQUEST['kurz']);
if( $drupoh == 1 )
{
if( $h_ksy == '' ) { $h_ksy = '0308'; }
}
if( $drupoh == 11 )
{
$h_dolxx = $h_dol;
$h_fakxx = $h_fak;
$h_dol = $h_fakxx;
$h_fak = $h_dolxx;
}
if( $drupoh == 12 )
{
$h_dolxx = $h_dol;
$h_fakxx = $h_fak;
$h_dol = $h_fakxx;
$h_fak = $h_dolxx;
if( $copern == 5 )
   {
$h_ico = $fir_fico;
$h_nai = $fir_fnaz;
   }
}
if( $drupoh == 21 )
{
$h_ico = $fir_fico;
$h_nai = $fir_fnaz;
$h_dph = 0;
}
if( $drupoh == 22 )
{
$h_ico = $fir_fico;
$h_nai = $fir_fnaz;
$h_dph = 0;
}
if( $drupoh == 42 )
{
$h_ico = $fir_fico;
$h_nai = $fir_fnaz;
if( $h_dat == '' ) { $h_dat = Date ("d.m.Y", MkTime (0,0,0,date("m"),date("d"),date("Y"))); }
if( $h_daz == '' ) { $h_daz = Date ("d.m.Y", MkTime (0,0,0,date("m"),date("d"),date("Y"))); }
if( $h_das == '' ) { $h_das = Date ("d.m.Y", MkTime (0,0,0,date("m"),date("d"),date("Y"))); }
}
if( $drupoh == 52 )
{
$h_prfxx = $h_prf;
$h_fakxx = $h_fak;
$h_prf = $h_fakxx;
$h_fak = $h_prfxx;
if( $copern == 5 )
   {
$h_ico = $fir_fico;
$h_nai = $fir_fnaz;
   }
}

$text = htmlspecialchars($_REQUEST['h_txp']); 
$hu_txp = str_replace(array("\r\n","\n"),"<br />",$text); 
$text = htmlspecialchars($_REQUEST['h_txz']); 
$hu_txz = str_replace(array("\r\n","\n"),"<br />",$text);

$newdok = strip_tags($_REQUEST['newdok']);
$h_zal = strip_tags($_REQUEST['h_zal']);
$h_ruc = strip_tags($_REQUEST['h_ruc']);
$h_hod = strip_tags($_REQUEST['h_hod']);
$h_zk0 = strip_tags($_REQUEST['h_zk0']);
$h_zao = strip_tags($_REQUEST['h_zao']);
$h_zk1 = strip_tags($_REQUEST['h_zk1']);
$h_zk2 = strip_tags($_REQUEST['h_zk2']);
$h_zk3 = strip_tags($_REQUEST['h_zk3']);
$h_zk4 = strip_tags($_REQUEST['h_zk4']);
$h_dn1 = strip_tags($_REQUEST['h_dn1']);
$h_dn2 = strip_tags($_REQUEST['h_dn2']);
$h_dn3 = strip_tags($_REQUEST['h_dn3']);
$h_dn4 = strip_tags($_REQUEST['h_dn4']);
$h_sz1 = strip_tags($_REQUEST['h_sz1']);
$h_sz2 = strip_tags($_REQUEST['h_sz2']);
$h_sz3 = strip_tags($_REQUEST['h_sz3']);
$h_sz4 = strip_tags($_REQUEST['h_sz4']);
$h_sp1 = strip_tags($_REQUEST['h_sp1']);
$h_sp2 = strip_tags($_REQUEST['h_sp2']);
$h_sp3 = strip_tags($_REQUEST['h_sp3']);
$h_sp4 = strip_tags($_REQUEST['h_sp4']);
$h_obj = strip_tags($_REQUEST['h_obj']);
$h_unk = strip_tags($_REQUEST['h_unk']);

$unkcheck=0;
if( $fir_fico == 46614478 AND $drupoh == 11 ) { $unkcheck=1; }
if( $unkcheck == 1 )
  {
$h_unk = 1*$_REQUEST['h_unkcheck'];
  }


$h_dpr = strip_tags($_REQUEST['h_dpr']);
$h_uhr = strip_tags($_REQUEST['h_uhr']);

$hlat = strip_tags($_REQUEST['hlat']);
$vybr = strip_tags($_REQUEST['vybr']);
$hlat_ico = strip_tags($_REQUEST['h_ico']);
$hlat_nai = strip_tags($_REQUEST['h_nai']);

$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$cislo_uce = strip_tags($_REQUEST['cislo_uce']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);
$cislo_dat = strip_tags($_REQUEST['cislo_dat']);
$cislo_daz = strip_tags($_REQUEST['cislo_daz']);
$cislo_das = strip_tags($_REQUEST['cislo_das']);
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);
$cislo_fak = strip_tags($_REQUEST['cislo_fak']);
$cislo_dol = strip_tags($_REQUEST['cislo_dol']);
$cislo_prf = strip_tags($_REQUEST['cislo_prf']);
$cislo_dph = strip_tags($_REQUEST['cislo_prf']);
$cislo_ksy = strip_tags($_REQUEST['cislo_ksy']);
$cislo_ssy = strip_tags($_REQUEST['cislo_ssy']);
$cislo_str = strip_tags($_REQUEST['cislo_str']);
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_unk = strip_tags($_REQUEST['cislo_unk']);
$cislo_obj = strip_tags($_REQUEST['cislo_obj']);
$cislo_zk0 = strip_tags($_REQUEST['cislo_zk0']);
$cislo_zao = strip_tags($_REQUEST['cislo_zao']);
$cislo_zk1 = strip_tags($_REQUEST['cislo_zk1']);
$cislo_zk2 = strip_tags($_REQUEST['cislo_zk2']);
$cislo_dn1 = strip_tags($_REQUEST['cislo_dn1']);
$cislo_dn2 = strip_tags($_REQUEST['cislo_dn2']);
$cislo_sp1 = strip_tags($_REQUEST['cislo_sp1']);
$cislo_sp2 = strip_tags($_REQUEST['cislo_sp2']);
$cislo_sz2 = strip_tags($_REQUEST['cislo_sz2']);
$cislo_sz1 = strip_tags($_REQUEST['cislo_sz1']);
$cislo_txp = strip_tags($_REQUEST['cislo_txp']);
$cislo_txz = strip_tags($_REQUEST['cislo_txz']);
$cislo_dpr = strip_tags($_REQUEST['cislo_dpr']);

$text = htmlspecialchars($_REQUEST['cislo_txp']); 
$cislou_txp = str_replace(array("\r\n","\n"),"<br />",$text); 
$text = htmlspecialchars($_REQUEST['cislo_txz']); 
$cislou_txz = str_replace(array("\r\n","\n"),"<br />",$text);

$cislo_poz = strip_tags($_REQUEST['cislo_poz']);
$cislo_hod = strip_tags($_REQUEST['cislo_hod']);
$cislo_zal = strip_tags($_REQUEST['cislo_zal']);
$cislo_ruc = strip_tags($_REQUEST['cislo_ruc']);

$vybr_dok = strip_tags($_REQUEST['vybr_dok']);
$vybr_cis = strip_tags($_REQUEST['vybr_cis']);
$vybr_nat = strip_tags($_REQUEST['vybr_nat']);
$vybr_mer = strip_tags($_REQUEST['vybr_mer']);
$vybr_dph = strip_tags($_REQUEST['vybr_dph']);
$vybr_cen = strip_tags($_REQUEST['vybr_cen']);
$vybr_zas = strip_tags($_REQUEST['vybr_zas']);
$vybr_ico = strip_tags($_REQUEST['vybr_ico']);
$vybr_nai = strip_tags($_REQUEST['vybr_nai']);

$rozb1 = strip_tags($_REQUEST['rozb1']);
$rozb2 = strip_tags($_REQUEST['rozb2']);
$h_tlsl = strip_tags($_REQUEST['h_tlsl']);
if( $drupoh == 31 OR $drupoh == 12 OR $drupoh == 22 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 ) $h_tlsl=1;
$sluz1 = 'MALE';
if( $h_tlsl == 1 AND $rozb1 == 'NOT' AND $rozb2 == 'NOT' ) { $sluz1 = 'VELKE'; $tov1 = 'MALE'; }
$h_tltv = strip_tags($_REQUEST['h_tltv']);
if( $h_tlsl == 1 AND $h_tltv == 1 ) $h_tltv = 0;
$tov1 = 'MALE';
if( $h_tltv == 1 AND $rozb1 == 'NOT' AND $rozb2 == 'NOT'  ) { $sluz1 = 'MALE'; $tov1 = 'VELKE'; }

//echo 'sluz'.$sluz1;
//echo 'tlsl'.$h_tlsl;
//echo 'tltv'.$h_tltv;
//echo 'copern'.$copern;
//echo 'd'.$h_dok;
//echo 'f'.$h_fak;
//echo 'dd'.$h_dol;

$hlas = strip_tags($_REQUEST['hlas']);

$h_cpl = strip_tags($_REQUEST['h_cpl']);
$h_slu = strip_tags($_REQUEST['h_slu']);
$h_nsl = strip_tags($_REQUEST['h_nsl']);
$h_nsl = AddSlashes($h_nsl);
$h_pop = strip_tags($_REQUEST['h_pop']);
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_cep = strip_tags($_REQUEST['h_cep']);
$h_ced = strip_tags($_REQUEST['h_ced']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_cen = strip_tags($_REQUEST['h_cen']);

//echo 'CEN'.$h_cen;

if ( $rozb1 == 'VELKE' AND $copern == 68) $copern=15;
if ( $rozb1 == 'VELKE' AND $copern == 78) $copern=18;
if ( $rozb1 == 'MALE' AND $copern == 68) $copern=15;
if ( $rozb1 == 'MALE' AND $copern == 78) $copern=18;
if ( $rozb2 == 'VELKE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'VELKE' AND $copern == 78) $copern=18;
if ( $rozb2 == 'MALE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'MALE' AND $copern == 78) $copern=18;

$ajvsy=0;
if( ( $rozuct == 'ANO' OR $pocstav == 1 ) AND $kli_vrok >= 2014 ) { $ajvsy=1; }
if( $ajvsy == 0 ) { $h_sz3=$h_fak; $cislo_sz3=$cislo_fak; }
//echo $ajvsy;

$prepocpriemerne=0;
$kli_vxcfskl=$kli_vxcf;
if( $drupoh == 1 )
{
$tabl = "fakodb";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakodb";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
if( $pocstav == 1 ) $tabl = "fakodbpoc";
if( $fir_xfa06 > 0 ) { $kli_vxcfskl=$fir_xfa06; }
}

if( $drupoh == 31 )
{
$tabl = "dopfak";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopfak";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 11 )
{
$tabl = "fakdol";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakdol";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 12 )
{
$tabl = "dopdol";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopdol";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 21 )
{
$tabl = "fakvnp";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakvnp";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 22 )
{
$tabl = "dopvnp";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopvnp";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 42 )
{
$tabl = "dopreg";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "dopreg";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "dopsluzbyzas";
$citreg = include("../doprava/citaj_reg.php");
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=0;
$h_tltv=1;
$rozuct='NIE';
$sysx='INE';
if( $regpok == 1 ) 
  {  
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$h_tlsl = 1*$_REQUEST['h_tlsl'];
$h_tltv = 1*$_REQUEST['h_tltv'];
if( $h_tlsl == 0 AND $h_tltv == 0 ) { $h_tlsl=0; $h_tltv=1; } 
  }
}

if( $drupoh == 52 )
{
$tabl = "dopprf";
$tablsluzby = "dopslu";
$cissluzby = "dopsluzby";
$cisdok = "fakprf";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberateæ";
$zassluzby = "dopsluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
$rozuct='NIE';
$sysx='INE';
}

if( $drupoh == 2 )
{
$tabl = "fakdod";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$cisdok = "fakdod";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Dod·vateæ";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$h_skl=$fir_xfa05;
$h_tlsl=1;
$h_tltv=0;
if( $pocstav == 1 ) $tabl = "fakdodpoc";
}

//odznacenie polozky z dodacich listov
if ( $copern == 2010 )
    {
$sqtoz = "UPDATE F$kli_vxcf"."_dopslu".
" SET cfak=0, dfak=0 ".
" WHERE ( dok='$cislo_dok' AND cpl='$cislo_cpl' AND cfak=999 AND dfak=999 ) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$copern=8;
    }

//uprava textov pred a za z ponuky
if ( $copern == 3008 OR $copern == 3009 )
    {
$cpt = 1*strip_tags($_REQUEST['cpt']);

$sqtoz = "UPDATE F$kli_vxcf"."_$tabl,F$kli_vxcf"."_faktext SET txp=txx WHERE dok='$cislo_dok' AND cpt = $cpt";
if( $copern == 3009 ) { $sqtoz = "UPDATE F$kli_vxcf"."_$tabl,F$kli_vxcf"."_faktext SET txz=txx WHERE dok='$cislo_dok' AND cpt = $cpt"; }
$oznac = mysql_query("$sqtoz");


$copern=8;
}
//koniec uprava textov pred a za z ponuky

//uprava textov pred a za
if ( $copern == 2008 OR $copern == 2009 )
    {
$h_penp = strip_tags($_REQUEST['h_penp']);
//echo "penpe".$h_penp;
$sqtoz = "UPDATE F$kli_vxcf"."_$tabl SET txp='$h_penp' WHERE dok='$cislo_dok' ";
if( $copern == 2009 ) { $sqtoz = "UPDATE F$kli_vxcf"."_$tabl SET txz='$h_penp' WHERE dok='$cislo_dok' ";  }
$oznac = mysql_query("$sqtoz");
$copern=8;
}
//koniec uprava textov pred a za

//uloz upravy polozky sluzby 88 88 88 88 88 88 
if ( $copern == 88 )
    {
$z_mer = strip_tags($_REQUEST['z_mer']);
$z_dph = strip_tags($_REQUEST['z_dph']);
$z_cep = strip_tags($_REQUEST['z_cep']);
$z_ced = strip_tags($_REQUEST['z_ced']);
$z_cen = strip_tags($_REQUEST['z_cen']);
$z_mno = strip_tags($_REQUEST['z_mno']);
$z_pop = strip_tags($_REQUEST['z_pop']);
$z_nsl = strip_tags($_REQUEST['z_nsl']);
$z_slu = strip_tags($_REQUEST['z_slu']);
$z_cpl = strip_tags($_REQUEST['z_cpl']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
//odpocitaj z napoctov povodnu
$z_ced2 = $z_ced;
$z_cep2 = $z_cep;
$z_spo2 = ($z_cep*$z_mno)*(1+$fir_dph2/100);
$z_ced1 = 0;
$z_cep1 = 0;
$z_spo1 = 0;
$z_cep0 = 0;
if( $z_dph == $fir_dph1 )
{
$z_ced1 = $z_ced;
$z_cep1 = $z_cep;
$z_spo1 = ($z_cep*$z_mno)*(1+$fir_dph1/100);
$z_ced2 = 0;
$z_cep2 = 0;
$z_spo2 = 0;
$z_cep0 = 0;
}
if( $z_dph == 0 )
{
$z_cep0 = $z_cep;
$z_ced1 = 0;
$z_cep1 = 0;
$z_spo1 = 0;
$z_ced2 = 0;
$z_cep2 = 0;
$z_spo2 = 0;
}
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET zk1=zk1-('$z_mno'*'$z_cep1'), sp1=sp1-('$z_spo1'), dn1=sp1-zk1,".
" zk2=zk2-('$z_mno'*'$z_cep2'), sp2=sp2-('$z_spo2'), dn2=sp2-zk2,".
" zk0=zk0-('$z_mno'*'$z_cep0'), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");
//pripocitaj do napoctov novu
$h_ced2 = $h_ced;
$h_cep2 = $h_cep;
$h_spo2 = ($h_cep*$h_mno)*(1+$fir_dph2/100);
//echo $h_spo2;
$h_ced1 = 0;
$h_cep1 = 0;
$h_spo1 = 0;
$h_cep0 = 0;
if( $h_dph == $fir_dph1 )
{
$h_ced1 = $h_ced;
$h_cep1 = $h_cep;
$h_spo1 = ($h_cep*$h_mno)*(1+$fir_dph1/100);
$h_ced2 = 0;
$h_cep2 = 0;
$h_spo2 = 0;
$h_cep0 = 0;
}
if( $h_dph == 0 )
{
$h_cep0 = $h_cep;
$h_ced1 = 0;
$h_cep1 = 0;
$h_spo1 = 0;
$h_ced2 = 0;
$h_cep2 = 0;
$h_spo2 = 0;
}

$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET zk1=zk1+('$h_mno'*'$h_cep1'), sp1=sp1+('$h_spo1'), dn1=sp1-zk1,".
" zk2=zk2+('$h_mno'*'$h_cep2'), sp2=sp2+('$h_spo2'), dn2=sp2-zk2,".
" zk0=zk0+('$h_mno'*'$h_cep0'), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");

//uprav polozku
if( $h_tlsl == 1 )
{
$sqtz = "UPDATE F$kli_vxcf"."_$tablsluzby SET slu=$h_slu, nsl='$h_nsl', dph=$h_dph, cep=$h_cep,".
" ced=$h_ced, mno=$h_mno, mer='$h_mer' ".
" WHERE cpl='$cislo_cpl'";
$upravene = mysql_query("$sqtz");

$h_pon = trim(strip_tags($_REQUEST['h_pon']));
if( $h_pon != '' AND $drupoh == 1 )
   {
$sqtz = "UPDATE F$kli_vxcfskl"."_$tablsluzby SET pon='$h_pon' WHERE cpl='$cislo_cpl'";
$upravene = mysql_query("$sqtz");
   }
}
if( $h_tltv == 1 )
{
$prepocpriemerne=1;
$sqtz = "UPDATE F$kli_vxcfskl"."_$tabltovar SET cis=$h_slu, nat='$h_nsl', dph=$h_dph, cep=$h_cep,".
" ced=$h_ced, mno=$h_mno, mer='$h_mer' ".
" WHERE cpl='$cislo_cpl'";
$upravene = mysql_query("$sqtz");

$h_pon = trim(strip_tags($_REQUEST['h_pon']));
if( $h_pon != '' AND ( $drupoh == 1 OR $drupoh == 11 ) )
   {
$sqtz = "UPDATE F$kli_vxcfskl"."_$tabltovar SET poz='$h_pon' WHERE cpl='$cislo_cpl'";
$upravene = mysql_query("$sqtz");
   }
}

//pripisat do zasob
$x_skl=0;
if( $h_tltv == 1 ) $x_skl=$h_skl;
$x_cen=0;
if( $h_tltv == 1 ) $x_cen=$z_cen;
$x_slu=$z_slu;
$x_mno=$z_mno;
include("zasslu_plus.php");
//odpisat zo zasob
$x_skl=0;
if( $h_tltv == 1 ) $x_skl=$h_skl;
$x_cen=0;
if( $h_tltv == 1 ) $x_cen=$h_cen;
$x_slu=$h_slu;
$x_mno=$h_mno;
include("zasslu_minus.php");


$copern=7;
    }
//koniec uloz upravu polozky sluzby 88 88 88 88 88 88 88 88 88 


//vyber upravy polozky sluzby 8787878787878787878 97979797979797979797979797
if ( $copern == 87 OR $copern == 97 )
    {
$z_mer = strip_tags($_REQUEST['z_mer']);
$z_dph = strip_tags($_REQUEST['z_dph']);
$z_cep = strip_tags($_REQUEST['z_cep']);
$z_ced = strip_tags($_REQUEST['z_ced']);
$z_cen = strip_tags($_REQUEST['z_cen']);
$z_mno = strip_tags($_REQUEST['z_mno']);
$z_pop = strip_tags($_REQUEST['z_pop']);
$z_nsl = strip_tags($_REQUEST['z_nsl']);
$z_slu = strip_tags($_REQUEST['z_slu']);
$z_cpl = strip_tags($_REQUEST['z_cpl']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

    }
//koniec vyber upravu polozky sluzby


//uloz upravy polozky sluzby 9898989898989898989898 
if ( $copern == 98 )
    {
$z_mer = strip_tags($_REQUEST['z_mer']);
$z_dph = strip_tags($_REQUEST['z_dph']);
$z_cep = strip_tags($_REQUEST['z_cep']);
$z_ced = strip_tags($_REQUEST['z_ced']);
$z_cen = strip_tags($_REQUEST['z_cen']);
$z_mno = strip_tags($_REQUEST['z_mno']);
$z_pop = strip_tags($_REQUEST['z_pop']);
$z_nsl = strip_tags($_REQUEST['z_nsl']);
$z_slu = strip_tags($_REQUEST['z_slu']);
$z_cpl = strip_tags($_REQUEST['z_cpl']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

//uprav polozku
$sqtz = "UPDATE F$kli_vxcf"."_$tablsluzby SET pop='$h_pop' ".
" WHERE cpl='$cislo_cpl'";

$upravene = mysql_query("$sqtz");

$copern=7;
    }
//koniec uloz upravu textovej polozky sluzby989898989898989898 


$ulozenienovejpolozky=0;
$vymazaniepolozky=0;
//ulozenie  polozky sluzby alebo tovaru 7777777777777777
if ( $copern == 77 )
    {

if( $drupoh == 11 OR $drupoh == 12  )
{
$h_dolxx = $h_dol;
$h_fakxx = $h_fak;
$h_dol = $h_fakxx;
$h_fak = $h_dolxx;
}
$h_cfak = $h_fak;
$h_cdol = $h_dol;
$h_cprf = $h_prf;
//echo "f".$h_cfak;
//echo "d".$h_cdol;
//echo "p".$h_cprf;

if( $h_tlsl == 1 )
{
$h_pon = strip_tags($_REQUEST['h_pon']);

$sqty = "INSERT INTO F$kli_vxcf"."_$tablsluzby ( dok,fak,dol,prf,slu,nsl,pop,dph,cep,ced,mno,mer,dfak,cfak,pfak,id,pon )". 
" VALUES ('$cislo_dok', '$h_cfak', '$h_cdol', '$h_cprf', '$h_slu', '$h_nsl', '$h_pop', '$h_dph', '$h_cep', '$h_ced',".
" '$h_mno', '$h_mer', 0, 0, 0, '$kli_uzid', '$h_pon' );"; 
}
if( $h_tltv == 1 )
{
///////////////////////////////////////////////////////
$prepocpriemerne=1;
$ulozenienovejpolozky=1;
$h_poh=50+$drupoh;
$h_dat = SqlDatum($h_dat);
$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

$h_pon = trim(strip_tags($_REQUEST['h_pon']));
if( $h_pon != '' AND ( $drupoh == 1 OR $drupoh == 11 ) )
   {
$h_poz=$h_pon;
   }

$sqty = "INSERT INTO F$kli_vxcfskl"."_$tabltovar ( dok,fak,dol,prf,skl,poh,ico,str,zak,dat,ume,cis,nat,pop,poz,dph,cen,cep,ced,mno,mer,id )". 
" VALUES ('$cislo_dok', '$h_cfak', '$h_cdol', '$h_cprf', '$h_skl', '$h_poh', '$h_ico', '$h_str', '$h_zak', '$h_dat', '$h_ume', '$h_slu', '$h_nsl',".
" '$h_pop', '$h_poz', '$h_dph', '$h_cen', '$h_cep', '$h_ced',".
" '$h_mno', '$h_mer', '$kli_uzid' );";
 
}

//echo $sqty;
$ulozene = mysql_query("$sqty"); 

if( $zmen == 1 AND $kli_vrok < 2009 )
{
$h_hodm=$h_ced;
$h_cep=$h_cep*$kurz;
$h_ced=$h_ced*$kurz;
}
if( $zmen == 1 AND $kli_vrok > 2008 )
{
$h_hodm=$h_ced;
$h_cep=$h_cep/$kurz;
$h_ced=$h_ced/$kurz;
}


$h_ced2 = $h_ced;
$h_cep2 = $h_cep;
$h_spo2 = ($h_cep*$h_mno)*(1+$fir_dph2/100);
//echo $h_spo2;
$h_ced1 = 0;
$h_cep1 = 0;
$h_spo1 = 0;
$h_cep0 = 0;
if( $h_dph == $fir_dph1 )
{
$h_ced1 = $h_ced;
$h_cep1 = $h_cep;
$h_spo1 = ($h_cep*$h_mno)*(1+$fir_dph1/100);
$h_ced2 = 0;
$h_cep2 = 0;
$h_spo2 = 0;
$h_cep0 = 0;
}
if( $h_dph == 0 )
{
$h_cep0 = $h_cep;
$h_ced1 = 0;
$h_cep1 = 0;
$h_spo1 = 0;
$h_ced2 = 0;
$h_cep2 = 0;
$h_spo2 = 0;
}

//echo $h_cep0." ".$h_dph." ".$kurz;

$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET zk1=zk1+('$h_mno'*'$h_cep1'), sp1=sp1+('$h_spo1'), dn1=sp1-zk1,".
" zk2=zk2+('$h_mno'*'$h_cep2'), sp2=sp2+('$h_spo2'), dn2=sp2-zk2,".
" zk0=zk0+('$h_mno'*'$h_cep0'), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";

//echo $sqtz;

$upravene = mysql_query("$sqtz");

//odpisat zo zasob
$x_skl=0;
if( $h_tltv == 1 ) $x_skl=$h_skl;
$x_cen=0;
if( $h_tltv == 1 ) $x_cen=$h_cen;
$x_slu=$h_slu;
$x_mno=$h_mno;
include("zasslu_minus.php");

if( $zmen == 1 AND $kli_vrok < 2009 )
{
$sqtm = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm+('$h_mno'*'$h_hodm') WHERE dok='$cislo_dok' AND kurz > 0";
$upravzmen = mysql_query("$sqtm");
}
if( $zmen == 1 AND $kli_vrok > 2008 )
{
$sqtm = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm+('$h_mno'*'$h_hodm') WHERE dok='$cislo_dok' AND kurz > 0";
$upravzmen = mysql_query("$sqtm");
}

$copern=7;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia polozky sluzby

$mazalasacpl=0;
//vymazanie polozky sluzby 3636363636363636363
if ( $copern == 36 )
    {

$z_dph = strip_tags($_REQUEST['z_dph']);
$z_cep = strip_tags($_REQUEST['z_cep']);
$z_ced = strip_tags($_REQUEST['z_ced']);
$z_cen = strip_tags($_REQUEST['z_cen']);
$z_mno = strip_tags($_REQUEST['z_mno']);
$z_pop = strip_tags($_REQUEST['z_pop']);

if( $h_tlsl == 1 )
{
$sqlttt = "SELECT * FROM F$kli_vxcf"."_$tablsluzby WHERE cpl='$cislo_cpl' ORDER BY cpl LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislox=$riaddok->slu;
 $nazovx=$riaddok->nsl;
 $cepx=$riaddok->cep;
 $cedx=$riaddok->ced;
 $mnox=$riaddok->mno;
 $merx=$riaddok->mer;
 $z_pon=$riaddok->pon;
 }

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tablsluzby WHERE ( cpl='$cislo_cpl' )"); 
}
if( $h_tltv == 1 )
{
$sqlttt = "SELECT * FROM F$kli_vxcf"."_$tabltovar WHERE cpl='$cislo_cpl' ORDER BY cpl LIMIT 1";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $cislox=$riaddok->cis;
 $nazovx=$riaddok->nat;
 $cepx=$riaddok->cep;
 $cedx=$riaddok->ced;
 $mnox=$riaddok->mno;
 $merx=$riaddok->mer;
 $z_pon=$riaddok->poz;
 }
//echo $cislox.$nazovx.$cepx.$cedx.$mnox.$merx;

$prepocpriemerne=1;
$vymazaniepolozky=1;
$zmazane = mysql_query("DELETE FROM F$kli_vxcfskl"."_$tabltovar WHERE ( cpl='$cislo_cpl' )"); 
}

$mazalasacpl=1;

if( $zmen == 1 AND $kli_vrok < 2009 )
{
$z_hodm=$z_ced;
$z_cep=$z_cep*$kurz;
$z_ced=$z_ced*$kurz;
}
if( $zmen == 1 AND $kli_vrok > 2008 )
{
$z_hodm=$z_ced;
$z_cep=$z_cep/$kurz;
$z_ced=$z_ced/$kurz;
}

$z_ced2 = $z_ced;
$z_cep2 = $z_cep;
$z_spo2 = ($z_cep*$z_mno)*(1+$fir_dph2/100);
$z_ced1 = 0;
$z_cep1 = 0;
$z_spo1 = 0;
$z_cep0 = 0;
if( $z_dph == $fir_dph1 )
{
$z_ced1 = $z_ced;
$z_cep1 = $z_cep;
$z_spo1 = ($z_cep*$z_mno)*(1+$fir_dph1/100);
$z_ced2 = 0;
$z_cep2 = 0;
$z_spo2 = 0;
$z_cep0 = 0;
}
if( $z_dph == 0 )
{
$z_cep0 = $z_cep;
$z_ced1 = 0;
$z_cep1 = 0;
$z_spo1 = 0;
$z_ced2 = 0;
$z_cep2 = 0;
$z_spo2 = 0;
}
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET zk1=zk1-('$z_mno'*'$z_cep1'), sp1=sp1-('$z_spo1'), dn1=sp1-zk1,".
" zk2=zk2-('$z_mno'*'$z_cep2'), sp2=sp2-('$z_spo2'), dn2=sp2-zk2,".
" zk0=zk0-('$z_mno'*'$z_cep0'), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";

//echo $sqtz;

$upravene = mysql_query("$sqtz");

//pripisat do zasob
$x_skl=0;
if( $h_tltv == 1 ) $x_skl=$h_skl;
$x_cen=0;
if( $h_tltv == 1 ) $x_cen=$z_cen;
$x_slu=$h_slu;
$x_mno=$z_mno;
include("zasslu_plus.php");


if( $zmen == 1 AND $kli_vrok < 2009 )
{
$sqtm = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm-('$z_mno'*'$z_hodm') WHERE dok='$cislo_dok' AND kurz > 0";
$upravzmen = mysql_query("$sqtm");
}
if( $zmen == 1 AND $kli_vrok > 2008 )
{
$sqtm = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm-('$z_mno'*'$z_hodm') WHERE dok='$cislo_dok' AND kurz > 0";
$upravzmen = mysql_query("$sqtm");
}


$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
$copern=7;
endif;
    }
//koniec vymazania polozky sluzby


$hladaj_ucex=$hladaj_uce;

//ak viac rad pre jednu analytiku
if( $fir_uctx14 == 1 AND ( $drupoh == 1 OR $drupoh == 2 ) AND $copern != 6 )
{
if( $drupoh == 1 )
     {
$sqluce = mysql_query("SELECT dodb,nodb,ucod FROM F$kli_vxcf"."_dodb WHERE ( dodb = $hladaj_uce ) ORDER BY dodb"); 
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  //echo "idem";
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_ucex=$riaduce->ucod;
  }
     }
if( $drupoh == 2 )
     {
$sqluce = mysql_query("SELECT ddod,ndod,ucdo FROM F$kli_vxcf"."_ddod WHERE ( ddod = $hladaj_uce ) ORDER BY ddod"); 
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  //echo "idem";
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_ucex=$riaduce->ucdo;
  }
     }
$cislo_uce=$hladaj_ucex;
$h_uce=$hladaj_ucex;
}



//nova faktura hlavicka
if ( $copern == 5 OR $copern == 355 )
    {
if( $drupoh == 11 AND $copern == 355 ) { $hladaj_uce="88801"; }

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE ( isnull(dok) )"); 

if( $cisdokodd != 1 OR $drupoh == 42 )
        {
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_ufir");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  }
        }

if( $cisdokodd == 1 AND $drupoh != 42 )
        {
  if( $drupoh == 1  ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_dodb WHERE drod = 1 AND dodb = $hladaj_uce"); }
  if( $drupoh == 31 ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_dodb WHERE drod = 11 AND dodb = $hladaj_uce"); }
  if( $drupoh == 11 ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_dodb WHERE drod = 2 AND dodb = $hladaj_uce"); }
  if( $drupoh == 12 ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_dodb WHERE drod = 12 AND dodb = $hladaj_uce"); }
  if( $drupoh == 21 ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_dodb WHERE drod = 3 AND dodb = $hladaj_uce"); }
  if( $drupoh == 22 ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_dodb WHERE drod = 13 AND dodb = $hladaj_uce"); }
  if( $drupoh == 52 ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_dodb WHERE drod = 14 AND dodb = $hladaj_uce"); }
  if( $drupoh == 2  ) { $sql = mysql_query("SELECT cfak FROM F$kli_vxcf"."_ddod WHERE drdo = 1 AND ddod = $hladaj_uce"); }

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->cfak;
  $nwwdok=$riadok->cfak;
  }
        }


//cislovanie podla ume ak vyhovuje ciselnej rade zoberie vyssie nastaveny ak nie zoberie max v rade+1, nemoze byt aj v jednej rade aj ume
$cisdokume=1*$fir_uctx11;
if( $cisdokume >= 3 AND $cisdokume <= 7 AND $drupoh == 2 )
        {
$pole = explode(".", $kli_vume);
$mesiac=1*$pole[0];
$rok=1*$pole[1];
if( $mesiac < 10 ) $mesiac="0".$mesiac;
$opacdok=strRev($newdok);
if( $cisdokume == 3 ) { $poccis="01"; $koncis="99"; $predok=substr($opacdok,4,4); }
if( $cisdokume == 4 ) { $poccis="001"; $koncis="999"; $predok=substr($opacdok,5,3); }
if( $cisdokume == 5 ) { $poccis="0001"; $koncis="9999"; $predok=substr($opacdok,6,2); }
if( $cisdokume == 6 ) { $poccis="00001"; $koncis="99999"; $predok=substr($opacdok,7,1); }
if( $cisdokume == 7 ) { $poccis="000001"; $koncis="999999"; $predok=substr($opacdok,8,0); }
$predok=strRev($predok);
$predok=1*$predok;

$pocdok=$predok.$mesiac.$poccis;
$kondok=$predok.$mesiac.$koncis;

$maxumedok=0;
  if( $drupoh == 2 ) { $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdod WHERE dok >= $pocdok AND dok <= $kondok ORDER BY dok DESC LIMIT 1"); }

  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxumedok=1*$riaddok->dok+1;
  }

if( $maxumedok == 0 ) $newdok=$pocdok;
if( $maxumedok > 0 AND $newdok >= $pocdok AND $newdok <= $kondok ) $newdok=$newdok;
if( $maxumedok > 0 AND $newdok < $pocdok ) $newdok=$maxumedok;
if( $maxumedok > 0 AND $newdok > $kondok ) $newdok=$maxumedok;

//echo "podla ume ".$pocdok." - ".$kondok." MAX ".$maxumedok." NEW ".$newdok;

        }
//koniec cislovania podla ume


$maxdok=0;

$sql = mysql_query("SELECT dok FROM F$kli_vxcf"."_$tabl ORDER by dok ");

while($zaznam=mysql_fetch_array($sql)):

if( $zaznam["dok"] == $newdok ) $newdok=$newdok+1;

endwhile;

$h_fak = $newdok;
if( $drupoh == 2 ) $h_fak=0;
if( $pocstav != 1 )
    {
if( $cisdokodd != 1 OR $drupoh == 42  ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$newdok'+1"); }
if( $cisdokodd == 1 AND $drupoh != 42 )
 { 
 if( $drupoh == 1  ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET cfak='$newdok'+1 WHERE drod=1 AND dodb = $hladaj_uce"); }
 if( $drupoh == 31 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET cfak='$newdok'+1 WHERE drod=11 AND dodb = $hladaj_uce"); }
 if( $drupoh == 11 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET cfak='$newdok'+1 WHERE drod=2 AND dodb = $hladaj_uce"); }
 if( $drupoh == 12 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET cfak='$newdok'+1 WHERE drod=12 AND dodb = $hladaj_uce"); }
 if( $drupoh == 21 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET cfak='$newdok'+1 WHERE drod=3 AND dodb = $hladaj_uce"); }
 if( $drupoh == 22 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET cfak='$newdok'+1 WHERE drod=13 AND dodb = $hladaj_uce"); }
 if( $drupoh == 52 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dodb SET cfak='$newdok'+1 WHERE drod=14 AND dodb = $hladaj_uce"); }
 if( $drupoh == 2  ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_ddod SET cfak='$newdok'+1 WHERE drdo=1 AND ddod = $hladaj_uce"); }
 }
    }



if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 21 )
    {

$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( uce,dok,doq,fak,str,zak,id ) VALUES ( $hladaj_ucex, $newdok, $newdok, $newdok, $fir_fakstr, $fir_fakzak, $kli_uzid )";
    }



if ( $drupoh == 31 OR $drupoh == 22 OR $drupoh == 52 )
    {
$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( dok,doq,fak,str,zak,id )".
" VALUES ( $newdok, $newdok, $newdok, $fir_dopstr, $fir_dopzak, $kli_uzid )";
    }

if ( $drupoh == 42 )
    {

$citreg = include("../doprava/citaj_reg.php");
$newfak = $reg_cbl;
$upravcbl = mysql_query("UPDATE F$kli_vxcf"."_dopdkp SET cbl='$newfak'+1"); 

  $sqlzs = mysql_query("SELECT * FROM F$kli_vxcf"."_dpok WHERE drpk = 9");
  if (@$zaznam=mysql_data_seek($sqlzs,0))
  {
  $riadzs=mysql_fetch_object($sqlzs);
  $ucefak=$riadzs->dpok;
  }

$dat_dat = Date ("Y-m-d", MkTime (0,0,0,date("m"),date("d"),date("Y"))); 
$pole = explode("-", $dat_dat);
$umereg=$pole[1].".".$pole[0];

$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( ume,uce,dok,doq,fak,dat,daz,das,ico,str,zak, id, zk1, dn1, zk2, dn2, zk0, sp1, sp2, hod, cbl,cdu,cmu )".
" VALUES ( $umereg, $ucefak, $newdok, $newdok, $newfak, '$dat_dat', '$dat_dat', '$dat_dat', $fir_fico, $fir_dopstr,".
" $fir_dopzak, $kli_uzid, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 )";
    }

if ( $drupoh == 11 )
    {
$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( dok,doq,dol,str,zak,id ) VALUES ( $newdok, $newdok, $newdok, $fir_fakstr, $fir_fakzak, $kli_uzid )";
    }

if ( $drupoh == 12 )
    {
$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( dok,doq,dol,ico,id ) VALUES ( $newdok, $newdok, $newdok, '$fir_fico', $kli_uzid )";
    }

//echo $sqlhh;
$ulozene = mysql_query("$sqlhh"); 
if (!$ulozene):
?>
<script type="text/javascript"> alert( " NIE JE SPOJENIE S DATAB¡ZOU ,  ukonËite program a spustite ho znovu " ) </script>
<?php
exit;
endif;
if ($ulozene):
$uloz="OK";
endif;

$kopydok = 1*$_REQUEST['kopydok'];
if( $kopydok == 1 )
  {
?> 
<script type="text/javascript">
  var okno = window.open("../ucto/kopia_dokladov.php?copern=2&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&cislo_dok=<?php echo $cislo_dok; ?>&kopia_dok=<?php echo $newdok; ?>","_self");
</script>
<?php 

exit;
  }

$shopdok = 1*$_REQUEST['shopdok'];
$lensklad = 1*$_REQUEST['lensklad'];
$dodaneobj = 1*$_REQUEST['dodaneobj'];

$zprac = 1*$_REQUEST['zprac'];
if( $shopdok == 1 )
  {
?> 
<script type="text/javascript">
  var okno = window.open("../eshop/spracuj_obj.php?copern=2&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&cislo_dok=<?php echo $cislo_dok; ?>&kopia_dok=<?php echo $newdok; ?>&dodaneobj=<?php echo $dodaneobj; ?>&lensklad=<?php echo $lensklad; ?>&zprac=<?php echo $zprac; ?>","_self");
</script>
<?php 

exit;
  }

    }
if ( $copern == 5 AND $drupoh == 42 ) { $sluz1 = "VELKE"; $copern=7; $cislo_dok = $newdok; }
if ( $copern == 5 AND $drupoh == 42 ) { $tov1 = "VELKE"; $copern=7; $cislo_dok = $newdok; }
if ( $copern == 15 ) $copern=5;
if ( $copern == 5 AND $sluz1 == "VELKE" ) $copern=7;
if ( $copern == 5 AND $tov1 == "VELKE" ) $copern=7;
//koniec nova faktura hlavicka

//urob dodaci z faktury
if ( $copern == 355 )
{
//copern355skopiruj donho udaje zahlavia

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE drod = 2");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $hladaj_uce=$riadok->dodb;
  }

$faktt = "SELECT * FROM F$kli_vxcf"."_fakodb"." WHERE dok = $cislo_fak "." ORDER BY dok";
$dsql = mysql_query("$faktt");

  if (@$dzak=mysql_data_seek($dsql,0))
  {
$friadok=mysql_fetch_object($dsql);

$fakxx=$friadok->fak;
if( $fir_fico == 46614478 ) { $fakxx=0; }

 $uprt = "UPDATE F$kli_vxcf"."_fakdol SET  uce='$hladaj_uce', dat='$friadok->dat', ume='$friadok->ume',".
" daz='$friadok->daz', das='$friadok->das', poh='$friadok->poh', skl='$friadok->skl', ico='$friadok->ico',".
" ksy='$friadok->ksy', ssy='$friadok->ssy',".
" poz='$friadok->poz', str='$friadok->str', zak='$friadok->zak', txp='$friadok->txp', txz='$friadok->txz',".
" fak='$fakxx', prf='$friadok->prf',".
" hod='$friadok->hod', zk0='$friadok->zk0', zk1='$friadok->zk1', zk2='$friadok->zk2', dn1='$friadok->dn1',".
" dn2='$friadok->dn2', sz1='$friadok->sz1', sz2='$friadok->sz2',".
" zk3='$friadok->zk3', zk4='$friadok->zk4', dn3='$friadok->dn3', dn4='$friadok->dn4', sz3='$friadok->sz3',".
" sz4='$friadok->sz4', sp1='$friadok->sp1', sp2='$friadok->sp2',".
" hodm='$friadok->hodm', mena='$friadok->mena', zmen='$friadok->zmen', kurz='$friadok->kurz',".
" obj='$friadok->obj', unk='$friadok->unk', dpr='$friadok->dpr', zal='$friadok->zal'".
" WHERE id='$kli_uzid' AND dok='$newdok'";

$upravene = mysql_query("$uprt");
  }
  

//copern355skopiruj polozky do fakslu
$sluztt = "SELECT dok, fak, dol, prf, cpl, slu, nsl, pop, dph,".
" mno, mer, cep, ced". 
" FROM F$kli_vxcf"."_fakslu".
" WHERE dok = $cislo_fak ".
" ORDER BY cpl";
$dsql = mysql_query("$sluztt");

$pzaz = mysql_num_rows($dsql);

$i = 0;
   while ($i < $pzaz )
   {
  if (@$dzak=mysql_data_seek($dsql,$i))
  {

$driadok=mysql_fetch_object($dsql);

$sqty = "INSERT INTO F$kli_vxcf"."_fakslu ( dok,fak,dol,prf,slu,nsl,pop,dph,cep,ced,mno,mer,id )".
" VALUES ('$newdok', '$driadok->fak', '$newdok', '$driadok->prf', '$driadok->slu', '$driadok->nsl', '$driadok->pop',".
" '$driadok->dph', '$driadok->cep', '$driadok->ced', '$driadok->mno', '$driadok->mer', '$kli_uzid' );"; 

//echo $sqty;
$kopia = mysql_query("$sqty");

  }
$i = $i + 1;
   }

//copern355skopiruj polozky do sklfak
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklfak "." SELECT".
" 0,ume,dat,$newdok,$newdok,skl,61,ico,$cislo_fak,cpl,$newdok,'','',str,zak,cis,nat,dph,mer,pop,mno,cen,cep,ced,id,sk2,now(),me2,mn2  ".
" FROM F$kli_vxcf"."_sklfak".
" WHERE F$kli_vxcf"."_sklfak.dok=$cislo_fak ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$copern=7;
$drupoh=11;
$cislo_dok=$newdok;
$sluz1 = 'VELKE';
$h_tlsl=1;
$h_tltv=0;
$sluz1 = 'VELKE';
$tov1 = 'MALE';
$tabl = "fakdol";
$tablsluzby = "fakslu";
$cissluzby = "sluzby";
$Odberatel = "Odberateæ";
$zassluzby = "sluzbyzas";
$tabltovar = "sklfak";
$zastovar = "sklzas";
$rozuct='NIE';
$sysx='INE';
$uloz="";
}
//koniec dodaci z faktury copern=355

//uprava faktury hlavicka
if ( $copern == 8 )
    {
$odbm="";
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) { $odbm=",odbm"; }
$sz3dav="";
if ( $drupoh == 1 OR $drupoh == 2 ) { $sz3dav=",sz3,dav"; }

$cituhr="";
if ( $pocstav == 1 ) { $cituhr=",uhr"; }

$citsz4="";
if ( $drupoh == 2 ) { $citsz4=",sz4"; }

$sqltt = "SELECT uce, dok, fak, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, DATE_FORMAt(daz, '%d.%m.%Y' ) AS daz,".
" DATE_FORMAt(das, '%d.%m.%Y' ) AS das, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, dol, prf, poz, str, zak,".
" txp, txz, ksy, ssy, zk1, dn1, sp1, zk2, dn2, sp2, zk0, hod, zal, ruc, obj, unk, dpr, zao".$odbm.$sz3dav.$cituhr.$citsz4.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$cislo_skl = $riadok->skl;
$cislo_uce = $riadok->uce;
$cislo_dok = $riadok->dok;
$newdok = $riadok->dok;
$cislo_dat = $riadok->dat;
$cislo_daz = $riadok->daz;
$cislo_dao = SkDatum($riadok->sz4);
$cislo_das = $riadok->das;
$cislo_poh = $riadok->poh;
$cislo_fak = $riadok->fak;
$cislo_sz3 = $riadok->sz3;
$cislo_dav = $riadok->dav;
$cislo_dol = $riadok->dol;
$cislo_prf = $riadok->prf;
$cislo_ksy = $riadok->ksy;
$cislo_ssy = $riadok->ssy;
$cislo_str = $riadok->str;
$cislo_zak = $riadok->zak;
$cislo_cpl = $riadok->cpl;
$cislo_unk = $riadok->unk;
$cislo_obj = $riadok->obj;
$cislo_zk0 = $riadok->zk0;
$cislo_zao = $riadok->zao;
$cislo_zk1 = $riadok->zk1;
$cislo_zk2 = $riadok->zk2;
$cislo_dn1 = $riadok->dn1;
$cislo_dn2 = $riadok->dn2;
$cislo_sp1 = $riadok->sp1;
$cislo_sp2 = $riadok->sp2;
$cislo_sz2 = $riadok->sz2;
$cislo_sz1 = $riadok->sz1;
$cislo_txp = $riadok->txp;
$cislo_txz = $riadok->txz;
$cislo_dpr = $riadok->dpr;
$cislo_odbm = $riadok->odbm;

if( $ajvsy == 0 ) { $cislo_sz3=$cislo_fak; }

$text = htmlspecialchars($riadok->txp); 
$cislou_txp = str_replace(array("\r\n","\n"),"<br />",$text); 

$text = htmlspecialchars($riadok->txz); 
$cislou_txz = str_replace(array("\r\n","\n"),"<br />",$text); 

$cislo_poz = $riadok->poz;
$cislo_hod = $riadok->hod;
$cislo_zal = $riadok->zal;
$cislo_ruc = $riadok->ruc;
$cislo_uhr = $riadok->uhr;

$vybr_ico = $riadok->ico;
$vybr = 'ANO';
  }
if( $drupoh == 1 )
{
if( $cislo_ksy == '' ) { $cislo_ksy = '0308'; }
}
if( $drupoh == 11 )
{
$cislo_dolxx = $cislo_dol;
$cislo_fakxx = $cislo_fak;
$cislo_dol = $cislo_fakxx;
$cislo_fak = $cislo_dolxx;
}
if( $drupoh == 12 )
{
$cislo_dolxx = $cislo_dol;
$cislo_fakxx = $cislo_fak;
$cislo_dol = $cislo_fakxx;
$cislo_fak = $cislo_dolxx;
}
if( $drupoh == 21 )
{
$cislo_ico = $fir_fico;
$cislo_nai = $fir_fnaz;
$cislo_dph = 0;
}
if( $drupoh == 22 )
{
$cislo_ico = $fir_fico;
$cislo_nai = $fir_fnaz;
$cislo_dph = 0;
}
if( $drupoh == 42 )
{
$cislo_ico = $fir_fico;
$cislo_nai = $fir_fnaz;
if( $cislo_dat == '' ) { $cislo_dat = Date ("d.m.Y", MkTime (0,0,0,date("m"),date("d"),date("Y"))); }
if( $cislo_daz == '' ) { $cislo_daz = Date ("d.m.Y", MkTime (0,0,0,date("m"),date("d"),date("Y"))); }
if( $cislo_das == '' ) { $cislo_das = Date ("d.m.Y", MkTime (0,0,0,date("m"),date("d"),date("Y"))); }
}
if( $drupoh == 52 )
{
$cislo_prfxx = $cislo_prf;
$cislo_fakxx = $cislo_fak;
$cislo_prf = $cislo_fakxx;
$cislo_fak = $cislo_prfxx;
}

    }

if ( $copern == 18 ) { $copern=8; }
if ( $copern == 8 AND $sluz1 == "VELKE" ) { $copern=7; }
if ( $copern == 8 AND $tov1 == "VELKE" ) { $copern=7; }
//koniec uprava faktury hlavicka

//nova hlavicka ulozenie 68
if ( $copern == 68 )
  {

$h_dat = SqlDatum($h_dat);
$h_daz = SqlDatum($h_daz);
$h_das = SqlDatum($h_das);

$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

if( $pocstav != 1 ) 
{
$ajeshop=0;
if (File_Exists ("../eshop/index.php")) { $ajeshop=1; }
if( $drupoh == 1 AND $sysx != 'UCT' AND $ajeshop == 1 ) 
{ 
//$h_sz4=2;
$h_icoxx=1*$h_ico;
if( $h_icoxx > 0 )
  {
$sqlfir = "SELECT * FROM ezak WHERE ez_ico = $h_icoxx ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { 
$fir_riadok=mysql_fetch_object($fir_vysledok); 
$ccenxx = 1*$fir_riadok->ccen; 
                   }
if( $ccenxx > 0 ) { $h_sz4=$ccenxx; }
  }
}  

if( $drupoh == 2 )
  {
$h_daosql = SqlDatum($_REQUEST['h_dao']);
$h_sz4=$h_daosql;
  }

$prepocpriemerne=1;
$uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume', dav='$h_dav', ".
" daz='$h_daz', das='$h_das', poh='$h_poh', skl='$h_skl', ico='$h_ico', fak='$h_fak', ksy='$h_ksy', ssy='$h_ssy',".
" poz='$h_poz', str='$h_str', zak='$h_zak', txp='$h_txp', txz='$h_txz', dol='$h_dol', prf='$h_prf',".
" hod='$h_hod', zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', sz1='$h_sz1', sz2='$h_sz2',".
" zk3='$h_zk3', zk4='$h_zk4', dn3='$h_dn3', dn4='$h_dn4', sz3='$h_sz3', sz4='$h_sz4', sp1='$h_sp1', sp2='$h_sp2',".
" obj='$h_obj', unk='$h_unk', dpr='$h_dpr', zal='$h_zal', ruc='$h_ruc', zao='$h_zao'".
" WHERE id='$kli_uzid' AND dok='$h_dok'";
}
if( $pocstav == 1 ) 
{
$uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$nwwdok', dat='$h_dat', ume='$h_ume', dav='$h_dav', ".
" daz='$h_daz', das='$h_das', poh='$h_poh', skl='$h_skl', ico='$h_ico', fak='$h_fak', ksy='$h_ksy', ssy='$h_ssy',".
" poz='$h_poz', str='$h_str', zak='$h_zak', txp='$h_txp', txz='$h_txz', dol='$h_dol', prf='$h_prf',".
" hod='$h_hod', zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', sz1='$h_sz1', sz2='$h_sz2',".
" zk3='$h_zk3', zk4='$h_zk4', dn3='$h_dn3', dn4='$h_dn4', sz3='$h_sz3', sz4='$h_sz4', sp1='$h_sp1', sp2='$h_sp2',".
" hodu='$h_hod', zk0u='$h_zk0', zk1u='$h_zk1', zk2u='$h_zk2', dn1u='$h_dn1', dn2u='$h_dn2', sp1u='$h_sp1', sp2u='$h_sp2',".
" obj='$h_obj', unk='$h_unk', dpr='$h_dpr', zal='$h_zal', ruc='$h_ruc', zao='$h_zao', uhr='$h_uhr'".
" WHERE id='$kli_uzid' AND dok='$h_dok'";
$h_dok=$nwwdok;
}
//echo $uprt;
//echo "sss".$sluz1;
//exit;
$upravene = mysql_query("$uprt");  
$cislo_dok = $h_dok;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA ULOéEN¡ " ) </script>
<?php
exit;
endif;
if ($upravene):
$uprav="OK";
if( $drupoh == 2 AND $pocstav != 1 ) { $sluz1='VELKE'; }
if ( $sluz1 != 'VELKE' AND $tov1 != 'VELKE' AND $uctovat != 1 )
{
?>
<script type="text/javascript">
 location.href='vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&page=1'  
</script>
<?php
}
$copern=7;
endif;
if ( $uctovat == 1 )
{
?>
<script type="text/javascript">
window.open('../faktury/vstf_t.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $h_dok;?>&h_ico=<?php echo $h_ico;?>
&h_uce=<?php echo $_uce;?>&h_unk=<?php echo $h_unk;?>', '_self' );
</script>
<?php
}
  }
//koniec nova hlavicka ulozenie

//uprava hlavicka ulozenie 78
if ( $copern == 78 )
  {
 
$h_dat = SqlDatum($h_dat);
$h_daz = SqlDatum($h_daz);
$h_das = SqlDatum($h_das);

$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

if( $drupoh == 2 )
  {
$h_daosql = SqlDatum($_REQUEST['h_dao']);
$h_sz4=$h_daosql;
  }

if( $pocstav != 1 ) 
{
$uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume', dav='$h_dav', 
daz='$h_daz', das='$h_das', poh='$h_poh', ico='$h_ico', fak='$h_fak', ksy='$h_ksy', ssy='$h_ssy',
poz='$h_poz', str='$h_str', zak='$h_zak', txp='$h_txp', txz='$h_txz', dol='$h_dol', prf='$h_prf',
hod='$h_hod', zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', sz1='$h_sz1', sz2='$h_sz2',
zk3='$h_zk3', zk4='$h_zk4', dn3='$h_dn3', dn4='$h_dn4', sz3='$h_sz3', sz4='$h_sz4', sp1='$h_sp1', sp2='$h_sp2',
obj='$h_obj', unk='$h_unk', dpr='$h_dpr', zal='$h_zal', ruc='$h_ruc', zao='$h_zao'
WHERE dok='$h_dok'";
}
if( $pocstav == 1 ) 
{
$uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$nwwdok', dat='$h_dat', ume='$h_ume', dav='$h_dav', 
daz='$h_daz', das='$h_das', poh='$h_poh', ico='$h_ico', fak='$h_fak', ksy='$h_ksy', ssy='$h_ssy',
poz='$h_poz', str='$h_str', zak='$h_zak', txp='$h_txp', txz='$h_txz', dol='$h_dol', prf='$h_prf',
hod='$h_hod', zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', sz1='$h_sz1', sz2='$h_sz2',
zk3='$h_zk3', zk4='$h_zk4', dn3='$h_dn3', dn4='$h_dn4', sz3='$h_sz3', sz4='$h_sz4', sp1='$h_sp1', sp2='$h_sp2',
hodu='$h_hod', zk0u='$h_zk0', zk1u='$h_zk1', zk2u='$h_zk2', dn1u='$h_dn1', dn2u='$h_dn2', sp1u='$h_sp1', sp2u='$h_sp2',
obj='$h_obj', unk='$h_unk', dpr='$h_dpr', zal='$h_zal', ruc='$h_ruc', zao='$h_zao', uhr='$h_uhr'
WHERE dok='$h_dok'";
$h_dok=$nwwdok;
}
//echo $uprt;
//exit;
$upravene = mysql_query("$uprt");  
$cislo_dok = $h_dok;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA ULOéEN¡ " ) </script>
<?php
exit;
endif;
if ($upravene):
$uprav="OK";
if ( $sluz1 != 'VELKE' AND $tov1 != 'VELKE' AND $uctovat != 1 )
{
?>
<script type="text/javascript">
 location.href='vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&page=1'  
</script>
<?php
}
$copern=7;
endif;
if ( $uctovat == 1 )
{
?>
<script type="text/javascript">
window.open('../faktury/vstf_t.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $h_dok;?>&h_ico=<?php echo $h_ico;?>
&h_uce=<?php echo $_uce;?>&h_unk=<?php echo $h_unk;?>', '_self' );
</script>
<?php
}
  }
//koniec uprava hlavicka ulozenie
//echo 'sluz'.$sluz1;
//echo 'rozb1'.$rozb1;
//echo 'rozb2'.$rozb2;
//echo 'copern'.$copern;


if ( $sluz1 == "VELKE" ) { $rozb1="NOT"; $rozb2="NOT"; }
if ( $tov1 == "VELKE" ) { $rozb1="NOT"; $rozb2="NOT"; }

//echo 'sluz'.$sluz1;
//echo 'rozb1'.$rozb1;
//echo 'rozb2'.$rozb2;
//echo 'copern'.$copern;

//echo 'uce'.$hladaj_uce;
//echo 'dok'.$cislo_dok;


if( $fir_xsk04 == 1 AND $h_tltv == 1 AND $drupoh == 1 AND $sys == 'FAK' AND $prepocpriemerne == 1 ) 
{ 
//$ulozenienovejpolozky=0;
//$vymazaniepolozky=0;
//echo "idem ".$prepocpriemerne;
if( $ulozenienovejpolozky == 0 AND $vymazaniepolozky == 0 )
    {
$sqlpr = 'DROP TABLE F'.$kli_vxcfskl.'_sklzaspriemer';
$sqlpr = mysql_query("$sqlpr"); 
$priemer = include("../sklad/sklzaspriemer.php");
    }
if( $ulozenienovejpolozky == 1 )
    {
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas-($h_mno) WHERE ( skl=$h_skl AND cis=$h_slu );";
//echo $sqtu;
$upravene = mysql_query("$sqtu");
    }
if( $vymazaniepolozky == 1 )
    {
$sqtu = "UPDATE F$kli_vxcf"."_sklzaspriemer SET zas=zas+($z_mno) WHERE ( skl=$h_skl AND cis=$cislox );";
//echo $sqtu;
$upravene = mysql_query("$sqtu");
    }
}
if( $fir_xsk04 == 1 AND $h_tltv == 1 AND $drupoh == 1 AND $sys == 'FAK' ) 
{ 
$sql = "SELECT * FROM F$kli_vxcfskl"."_sklzaspriemer";
$vysledok = mysql_query("$sql");
if (!$vysledok) { $priemer = include("../sklad/sklzaspriemer.php"); }
}
if( $fir_xsk04 == 1 AND $drupoh == 42 AND $sys == 'FAK' ) 
{ 
//echo "idem";
$sql = "SELECT * FROM F$kli_vxcfskl"."_sklzaspriemer";
$vysledok = mysql_query("$sql");
if (!$vysledok) { $priemer = include("../sklad/sklzaspriemer.php"); }
} 

if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=8'); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 )
  {
?>
<title>Fakt˙ra</title>
<?php
}
?>
<?php
if ( $drupoh == 11 )
  {
?>
<title>DodacÌ list</title>
<?php
}
?>
<?php
if ( $drupoh == 12 )
  {
?>
<title>DodacÌ list</title>
<?php
}
?>
<?php
if ( $drupoh == 21 )
  {
?>
<title>Vn˙tropod.fakt˙ra</title>
<?php
}
?>
<?php
if ( $drupoh == 22 )
  {
?>
<title>Vn˙tropod.fakt˙ra</title>
<?php
}
?>
<?php
if ( $drupoh == 42 )
  {
?>
<title>RegistraËn· pokladnica</title>
<?php
}
?>
<?php
if ( $drupoh == 52 )
  {
?>
<title>Predfakt˙ra</title>
<?php
}
?>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0; z-index: 300;
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
if ( $copern == 7  OR $copern == 87 )
      {
?>
<?php
if ( $drupoh != 21 AND $drupoh != 12 AND $drupoh != 31 AND $drupoh != 22 )
{
?>
<?php
if ( $h_tlsl == 1 )
       {
?>
<script type="text/javascript" src="../ajax/spr_slu_xml.js"></script>
<?php
       }
?>
<?php
if ( $h_tltv == 1 )
       {
?>
<script type="text/javascript" src="../ajax/spr_tov_xml.js"></script>
<?php
       }
?>

<?php
}
?>
<?php
  $ajeshop=0;
  if (File_Exists ("../eshop/index.php")) { $ajeshop=1; }

if ( $drupoh == 21 AND $ajeshop == 0 )
{
?>
<script type="text/javascript" src="../ajax/spr_slu0_xml.js"></script>
<?php
}
?>
<?php
if ( $drupoh == 21 AND $ajeshop == 1 )
{
?>
<script type="text/javascript" src="../ajax/spr_tov_xml.js"></script>
<?php
}
?>
<?php
if ( ( $drupoh == 12 OR $drupoh == 31 OR $drupoh == 42 OR $drupoh == 52 ) AND $regpok == 0 )
{
?>
<script type="text/javascript" src="../ajax/spr_dslu_xml.js"></script>
<?php
}
?>
<?php
if ( $drupoh == 42 AND $regpok == 1 )
{
?>
<?php
if ( $h_tlsl == 1 )
       {
?>
<script type="text/javascript" src="../ajax/spr_slu_xml.js"></script>
<?php
       }
?>
<?php
if ( $h_tltv == 1 )
       {
?>
<script type="text/javascript" src="../ajax/spr_tov_xml.js"></script>
<?php
       }
?>
<?php
}
?>
<?php
if ( $drupoh == 22 )
{
?>
<script type="text/javascript" src="../ajax/spr_dslu0_xml.js"></script>
<?php
}
?>
<?php
      }
?>
<?php
if ( $copern == 5 OR $copern == 8 )
{
?>
<script type="text/javascript" src="../ajax/spr_icofak_xml.js"></script>
<script type="text/javascript" src="spr_odbm_xml.js"></script>
<script type="text/javascript" src="set_odbm_xml.js"></script>
<script type="text/javascript" src="spr_fakstr_xml.js"></script>
<script type="text/javascript" src="spr_fakzak_xml.js"></script>
<script type="text/javascript" src="datumy.js"></script>
<?php
}
?>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;


function vyberODBM()
                {
         volajODBM(<?php echo $drupoh; ?>)
                }

//co urobi po potvrdeni ok z tabulky odbm
function vykonajOdbm(odbm,nazov,mesto,doklad,drupoh,oper)
                {
        document.forms.fhlv1.h_odbm.value = odbm;
        myOdbmElement.style.display='none';
        nastavODBM(<?php echo $drupoh; ?>, odbm)
        myOdbmElement.style.display='';
                }

//co urobi ak je len jedno ico
function Len1ICO()
                    {
<?php
if ( $fir_xfa04 != 0 )
{
?>
        document.forms.fhlv1.h_dat.focus();
<?php
}
?>
<?php
if ( $fir_xfa04 == 0 )
{
?>
        document.forms.fhlv1.h_fak.focus();
        document.forms.fhlv1.h_fak.select();
<?php
}
?>
                    }

function HlvOnClick()
                    {
 Fxh.style.display='none';
 document.fhlv1.uloh.disabled = true; 
<?php
if ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
?>
 document.fhlv1.sluzby.disabled = true;
 document.fhlv1.tovar.disabled = true;
<?php
}
?>
                    }


//premenne na prepocet dph
sdphpred = 0;
sdphpo = 0;
sdphrz = 0;

//posuny Enter[[[[[[[[[[[


function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
<?php
if ( $rozuct != 'ANO' AND $pocstav != 1 )
{
?>
        document.forms.fhlv1.h_ico.focus();
        document.forms.fhlv1.h_ico.select();
<?php
}
?>
<?php
if ( ( $rozuct == 'ANO' OR $pocstav == 1 ) AND $ajvsy == 0 )
{
?>
        document.forms.fhlv1.h_fak.focus();
        document.forms.fhlv1.h_fak.select();
<?php
}
?>
<?php
if ( ( $rozuct == 'ANO' OR $pocstav == 1 ) AND $ajvsy == 1 )
{
?>
        document.forms.fhlv1.h_sz3.focus();
        document.forms.fhlv1.h_sz3.select();
<?php
}
?>
              }

                }

function NwwdokEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_fak.focus();
        document.forms.fhlv1.h_fak.select();
              }

                }

function Sz3Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
  var thestring=document.forms.fhlv1.h_sz3.value;  
  //var thenum = thestring.replace( /^\D+/g, '');
  var thenum = thestring.replace(/[^\d.]/g, "");
  thenum10 = thenum.substring(0,10);

  if( thenum > 0 ) { document.forms.fhlv1.h_fak.value=thenum10; }
        document.forms.fhlv1.h_fak.focus();
	document.forms.fhlv1.h_fak.select();
              }

                }


function FakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

<?php if( $tlacitkoenter == 1 )  { echo "var k=e;"; } ?>

  if(k == 13 ){
<?php
if ( $fir_xfa04 == 0 )
{
?>
        document.forms.fhlv1.h_dat.focus();
<?php
}
?>
<?php
if ( $fir_xfa04 != 0 )
{
?>
        if( document.forms.fhlv1.h_fak.value > 0 ) {
        document.forms.fhlv1.h_ico.focus();
        document.forms.fhlv1.h_ico.select();
                                                     }
<?php
}
?>
              }

                }



function OnfocusDat()
                {
        if( document.forms.fhlv1.h_dat.value == "" ) { document.forms.fhlv1.h_dat.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dat.select();
                }

function DatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        <?php if( $drupoh != 2 OR  $fir_allx13 == 0 ) { echo "document.forms.fhlv1.h_daz.focus();"."\r"; } ?>
        <?php if( $drupoh == 2 AND $fir_allx13 == 1 ) { 
	echo "document.forms.fhlv1.h_dao.focus();"."\r";
	} ?>
        if( document.forms.fhlv1.h_dns.value > 0 ) { volajDatumy( 1 ); }
              }

                }

function OnfocusDao()
                {
        <?php if( $drupoh == 2 AND $fir_allx13 == 1 ) { ?>
        if( document.forms.fhlv1.h_dao.value == "" ) { document.forms.fhlv1.h_dao.value = document.forms.fhlv1.h_dat.value; }
        if( document.forms.fhlv1.h_daz.value == "" ) { document.forms.fhlv1.h_daz.value = document.forms.fhlv1.h_dat.value; }
        document.forms.fhlv1.h_dao.select();
        <?php                                         } ?>
                }

function OnfocusDaz()
                {
        <?php if( $drupoh == 2 ) { ?>
        if( document.forms.fhlv1.h_dao.value == "" ) { document.forms.fhlv1.h_dao.value = document.forms.fhlv1.h_dat.value; }
        <?php                    } ?>
        <?php if( $drupoh == 2 AND $fir_allx13 == 1 ) { ?>
        document.forms.fhlv1.h_daz.value = document.forms.fhlv1.h_dao.value;
        <?php                                         } ?>
        if( document.forms.fhlv1.h_daz.value == "" ) { document.forms.fhlv1.h_daz.value = document.forms.fhlv1.h_dat.value; }
        document.forms.fhlv1.h_daz.select();
                }

function DaoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_daz.focus();
              }

                }

function DazEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_das.focus();
              }

                }

function OnfocusDas()
                {
       if( document.forms.fhlv1.h_das.value == '' ) { document.forms.fhlv1.h_das.value=document.forms.fhlv1.h_dat.value; }
       document.forms.fhlv1.h_das.select();
                }

function DasEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_obj.focus();
        document.forms.fhlv1.h_obj.select();
              }

                }

function ObjEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_unk.focus();
        document.forms.fhlv1.h_unk.select();
              }

                }


function UnkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if ( document.fhlv1.h_str.value == '' ) { document.fhlv1.h_str.value = '0'; }

        document.forms.fhlv1.h_str.focus();
        document.forms.fhlv1.h_str.select();
              }

                }


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
function vykonajIco(ico,nazov,mesto,ucb,num,dns,icd)
                {
        document.forms.fhlv1.h_ico.value = ico;
        document.forms.fhlv1.h_icd.value = icd;
        document.forms.fhlv1.h_nai.value = nazov;
        var zmlspl = dns;
        document.forms.fhlv1.h_dns.value = zmlspl;
        myIcoElement.style.display='none';
<?php
if ( $fir_xfa04 != 0 )
{
?>
        document.forms.fhlv1.h_dat.focus();
<?php
}
?>
<?php
if ( $fir_xfa04 == 0 )
{
?>
        document.forms.fhlv1.h_fak.focus();
        document.forms.fhlv1.h_fak.select();
<?php
}
?>
                }

function nulujIco()
                {

                }

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
        if ( document.fhlv1.h_ksy.value == '' ) document.fhlv1.h_ksy.value = '0308';
        document.forms.fhlv1.h_ksy.focus();
        document.forms.fhlv1.h_ksy.select();
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
         if ( document.fhlv1.h_ksy.value == '' ) document.fhlv1.h_ksy.value = '0';
         document.fhlv1.h_ksy.focus();
         document.fhlv1.h_ksy.select();
                }


function Len1Zak(str,zak)
              {
         document.forms.fhlv1.h_zak.value = zak;
         document.forms.fhlv1.h_str.value = str;
         if ( document.fhlv1.h_ksy.value == '' ) document.fhlv1.h_ksy.value = '0308';
         document.fhlv1.h_ksy.focus();
         document.fhlv1.h_ksy.select();
              }

function Len0Zak()
                    {
         document.fhlv1.h_zak.focus();
         document.fhlv1.h_zak.select();
                    }


function KsyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_ssy.focus();
        document.forms.fhlv1.h_ssy.select();
              }

                }

function SsyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_dol.focus();
        document.forms.fhlv1.h_dol.select();
              }

                }

function DolEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_prf.focus();
        document.forms.fhlv1.h_prf.select();
              }

                }


function PrfEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_dpr.focus();
        document.forms.fhlv1.h_dpr.select();
              }

                }


function DprEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_zk1.value == '' ){ document.forms.fhlv1.h_zk1.value = 0; }
        document.forms.fhlv1.h_zk1.focus();
        document.forms.fhlv1.h_zk1.select();
              }

                }


function TxpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_txz.focus();
              }

                }


function TxzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }

                }



function Zk1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        dann = 0.<?php echo $fir_dph1; ?>*document.forms.fhlv1.h_zk1.value;
        <?php if( $vyb_rok < 2009 ) { echo "danz = dann.toFixed(1);"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "danz = dann.toFixed(2);"; } ?>

        document.forms.fhlv1.h_dn1.value = danz;
        var hodsp1 = 1*document.forms.fhlv1.h_zk1.value+1*document.forms.fhlv1.h_dn1.value;
        document.forms.fhlv1.h_sp1.value = hodsp1.toFixed(2);
        document.forms.fhlv1.h_dn1.focus();
        document.forms.fhlv1.h_dn1.select();
              }

                }


function Dn1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        var hodsp1 = 1*document.forms.fhlv1.h_zk1.value+1*document.forms.fhlv1.h_dn1.value;
        document.forms.fhlv1.h_sp1.value = hodsp1.toFixed(2);
        if(document.forms.fhlv1.h_zk2.value == '' ){ document.forms.fhlv1.h_zk2.value = 0; }
        document.forms.fhlv1.h_zk2.focus();
        document.forms.fhlv1.h_zk2.select();
              }

                }

function Zk2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        dann = 0.<?php echo $fir_dph2; ?>*document.forms.fhlv1.h_zk2.value;
        <?php if( $vyb_rok < 2009 ) { echo "danz = dann.toFixed(1);"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "danz = dann.toFixed(2);"; } ?>

        document.forms.fhlv1.h_dn2.value = danz;
        var hodsp2 = 1*document.forms.fhlv1.h_zk2.value+1*document.forms.fhlv1.h_dn2.value;
        document.forms.fhlv1.h_sp2.value = hodsp2.toFixed(2);
        document.forms.fhlv1.h_dn2.focus();
        document.forms.fhlv1.h_dn2.select();
              }

                }

function Dn2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        var hodsp2 = 1*document.forms.fhlv1.h_zk2.value+1*document.forms.fhlv1.h_dn2.value;
        document.forms.fhlv1.h_sp2.value = hodsp2.toFixed(2);
        if(document.forms.fhlv1.h_zk0.value == '' ){ document.forms.fhlv1.h_zk0.value = 0; document.forms.fhlv1.h_sp0.value = 0; }
        document.forms.fhlv1.h_zk0.focus();
        document.forms.fhlv1.h_zk0.select();
              }

                }


function Zk0Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_zao.focus();
        document.forms.fhlv1.h_zao.select();
              }

                }

function ZaoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        var hodcelk = 1*document.forms.fhlv1.h_sp1.value+1*document.forms.fhlv1.h_sp2.value+1*document.forms.fhlv1.h_zk0.value+1*document.forms.fhlv1.h_zao.value;
        document.forms.fhlv1.h_hod.value = hodcelk.toFixed(2);
        document.forms.fhlv1.h_hod.focus();
        document.forms.fhlv1.h_hod.select();
              }

                }


function HodEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        <?php if ( $pocstav != 1 ) {  echo "document.forms.fhlv1.h_zal.focus();\r"; } ?>
        <?php if ( $pocstav != 1 ) {  echo "document.forms.fhlv1.h_zal.select();\r"; } ?>
        <?php if ( $pocstav == 1 ) {  echo "document.forms.fhlv1.h_uhr.focus();\r"; } ?>
        <?php if ( $pocstav == 1 ) {  echo "document.forms.fhlv1.h_uhr.select();\r"; } ?>
              }

                }


function ZalEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }

                }

function RucEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }

                }

function UhrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }
                }

function PozEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_daz.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_das.value == '1' ) okvstup=0;

    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_daz.value == '' ) okvstup=0;
    if ( document.fhlv1.h_das.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.fhlv1.h_dat.value == '' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.h_daz.value == '' ) { document.fhlv1.h_daz.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.h_das.value == '' ) { document.fhlv1.h_das.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_dat.value == '1' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_daz.value == '1' ) { document.fhlv1.h_daz.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_das.value == '1' ) { document.fhlv1.h_das.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.fhlv1.submit(); return (true); }
              }
                }


//script pre copern vymazanie 6 666666666666666 
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
//koniec skriptu 6 666666666
}?>


//script pre copern  7 77777777777777777 vstup sluzby
<?php
if ( $copern == 7 OR $copern == 87 ) 
{?>


function SluEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.forms1.h_slu.value != '' && document.forms.forms1.h_slu.value != 0 )
        {
        myDivElement.style.display='';
        document.forms.forms1.h_nsl.value = '';
        nulujPol();
        volajSlu();
        }      

        if( document.forms1.h_slu.value == "" ) { document.forms1.h_nsl.disabled = false; document.forms1.h_nsl.focus(); }
        if( document.forms1.h_slu.value == 0 ) 
                        { document.forms1.h_nsl.disabled = false;
                          document.forms1.h_dph.value = <?php echo $fir_dph2; ?>;
                          myDivElement.style.display='none'; 
                         <?php if( $drupoh == 21 OR $drupoh == 22 ) echo "document.forms1.h_dph.value = 0;"; ?>
                          document.forms1.h_nsl.focus();
                        }

              }
                }


function NslEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.forms1.h_nsl.value != '' && document.forms1.h_slu.value == '')
        {
        myDivElement.style.display='';
        nulujPol();
        volajSlu();
        }   

        if( document.forms1.h_nsl.value != "" && document.forms1.h_slu.value > 0 )
            { document.forms1.h_slu.focus(); }

        if( document.forms1.h_nsl.value != "" && document.forms1.h_slu.value == 0)
            { document.forms1.h_dph.focus(); }

        if( document.forms1.h_nsl.value == "" ) { document.forms1.h_slu.focus(); }

              }
                }

function DphEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        if( document.forms.forms1.h_cep.value == "" ) document.forms.forms1.h_cep.value = '0';
        document.forms.forms1.h_cep.focus();
        document.forms.forms1.h_cep.select();
              }

                }


function CepEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if( document.forms.forms1.h_dph.value == <?php echo $fir_dph2; ?> ) { dann = 0.<?php echo $fir_dph2; ?>*document.forms.forms1.h_cep.value; }
        if( document.forms.forms1.h_dph.value == <?php echo $fir_dph1; ?> ) { dann = 0.<?php echo $fir_dph1; ?>*document.forms.forms1.h_cep.value; }
        if( document.forms.forms1.h_dph.value == 0 ) { dann = 0; }

        danz = dann.toFixed(4);

        h_ced = (1*danz) + (1*document.forms.forms1.h_cep.value);
        h_cdz = h_ced.toFixed(4);
        document.forms.forms1.h_ced.value = (1*h_cdz);

        sdphpred =  document.forms.forms1.h_ced.value;
        document.forms.forms1.h_ced.focus();
        document.forms.forms1.h_ced.select();
              }
                }

        <?php if( $vyb_rok < 2009 ) { echo "var maxrozp=0.01; var maxrozm=-0.01;"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "var maxrozp=0.0001; var maxrozm=-0.0001;"; } ?>

function CedEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        sdphpo =  document.forms.forms1.h_ced.value;
        sdphrz =  sdphpred - sdphpo;

    if( sdphrz <= maxrozp && sdphrz >= maxrozm  )
        {
        if( document.forms.forms1.h_mno.value == "" ) document.forms.forms1.h_mno.value = '1';
        document.forms.forms1.h_mno.focus();
        document.forms.forms1.h_mno.select();
        }
    if( sdphrz > maxrozp || sdphrz < maxrozm )
        {
        if( document.forms.forms1.h_dph.value == <?php echo $fir_dph2; ?> ) { bezd = document.forms.forms1.h_ced.value / 1.<?php echo $fir_dph2; ?>; }
        if( document.forms.forms1.h_dph.value == <?php echo $fir_dph1; ?> ) { bezd = document.forms.forms1.h_ced.value / 1.<?php echo $fir_dph1; ?>; }
        if( document.forms.forms1.h_dph.value == 0 ) { bezd = document.forms.forms1.h_ced.value / 1; }

        bezd = bezd.toFixed(4);
        document.forms.forms1.h_cep.value = bezd;
        if( document.forms.forms1.h_mno.value == "" ) document.forms.forms1.h_mno.value = '1';
        document.forms.forms1.h_mno.focus();
        document.forms.forms1.h_mno.select();
//        document.forms.forms1.h_cep.focus();
//        document.forms.forms1.h_cep.select();
        }
               }

                }

function MnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.forms1.h_mer.value == "" ) document.forms.forms1.h_mer.value = 'h';
        document.forms.forms1.h_mer.focus();
        document.forms.forms1.h_mer.select();
              }

                }

function MerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.forms1.err_slu.value == '1' ) okvstup=0;
    if ( document.forms1.err_cep.value == '1' ) okvstup=0;
    if ( document.forms1.err_ced.value == '1' ) okvstup=0;
    if ( document.forms1.err_mno.value == '1' ) okvstup=0;
    if ( document.forms1.h_slu.value == '' ) okvstup=0;
    if ( document.forms1.h_nsl.value == '' ) okvstup=0;
    if ( document.forms1.h_cep.value == '' ) okvstup=0;
    if ( document.forms1.h_ced.value == '' ) okvstup=0;
    if ( document.forms1.h_mno.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms.forms1.submit(); return (true); }
    if ( okvstup == 0 && document.forms1.err_slu.value == '1' ) { document.forms1.h_slu.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.err_cep.value == '1' ) { document.forms1.h_cep.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.err_ced.value == '1' ) { document.forms1.h_ced.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.err_mno.value == '1' ) { document.forms1.h_mno.focus(); return (false); }
              }
                }

//co urobi po potvrdeni ok z tabulky tovar
function vykonajTov(slu,nazov,dph,cenap,cenad,cenan,zas,mer)
                {
        document.forms.forms1.h_slu.value = slu;
        document.forms.forms1.h_nsl.value = nazov;
        document.forms.forms1.h_dph.value = dph;
        document.forms.forms1.h_cen.value = cenan;
        <?php if( $drupoh == 21 OR $drupoh == 22 ) echo "document.forms1.h_dph.value = 0;"; ?>
        document.forms.forms1.h_cep.value = cenap;
        document.forms.forms1.h_ced.value = cenad;
        <?php if( $drupoh == 21 OR $drupoh == 22 ) echo "document.forms1.h_ced.value = cenap;"; ?>
        if ( document.forms1.zmen.value == '1' ) {
               document.forms.forms1.h_dph.value = 0;
               cenaz = cenap*document.forms.forms1.kurz.value; 
               cena2 = cenaz.toFixed(4);
               document.forms.forms1.h_cep.value = cena2; 
               document.forms.forms1.h_ced.value = cena2; 
                                                 }
        document.forms.forms1.h_mno.value = zas;
        document.forms.forms1.h_mer.value = mer;
        myDivElement.style.display='none';
        document.forms.forms1.h_cep.focus();
        document.forms.forms1.h_cep.select();
                }                 

//co urobi po potvrdeni ok z tabulky sluzby
function vykonajSlu(slu,nazov,dph,cenap,cenad,mer)
                {
        document.forms.forms1.h_slu.value = slu;
        document.forms.forms1.h_nsl.value = nazov;
        document.forms.forms1.h_dph.value = dph;
        <?php if( $drupoh == 21 OR $drupoh == 22 ) echo "document.forms1.h_dph.value = 0;"; ?>
        document.forms.forms1.h_cep.value = cenap;
        document.forms.forms1.h_ced.value = cenad;
        <?php if( $drupoh == 21 OR $drupoh == 22 ) echo "document.forms1.h_ced.value = cenap;"; ?>
        if ( document.forms1.zmen.value == '1' ) {
               document.forms.forms1.h_dph.value = 0;
               cenaz = cenap*document.forms.forms1.kurz.value; 
               cena2 = cenaz.toFixed(4);
               document.forms.forms1.h_cep.value = cena2; 
               document.forms.forms1.h_ced.value = cena2; 
                                                 }
        document.forms.forms1.h_mer.value = mer;
        myDivElement.style.display='none';
        document.forms.forms1.h_cep.focus();
        document.forms.forms1.h_cep.select();
                }

function nulujPol()
                {

        document.forms.forms1.h_dph.value = '';
        document.forms.forms1.h_cep.value = '';
        document.forms.forms1.h_ced.value = '';
        document.forms.forms1.h_mer.value = '';
        Nen.style.display="none";
                }

    function ObnovUI()
    {
    <?php if( $mazalasacpl == 1 ) echo "document.forms.forms1.h_slu.value = '$cislox';";?>
    <?php if( $mazalasacpl == 1 ) echo "document.forms.forms1.h_nsl.value = '$nazovx';";?>
    <?php if( $mazalasacpl == 1 ) echo "document.forms.forms1.h_cep.value = '$cepx';";?>
    <?php if( $mazalasacpl == 1 ) echo "document.forms.forms1.h_ced.value = '$cedx';";?>
    <?php if( $mazalasacpl == 1 ) echo "document.forms.forms1.h_mno.value = '$mnox';";?>
    <?php if( $mazalasacpl == 1 ) echo "document.forms.forms1.h_mer.value = '$merx';";?>
    <?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    }
    function VyberVstup()
    {
    document.forms1.h_cpl.disabled = true;
    document.forms1.h_hdp.disabled = true;
    document.forms1.h_hdd.disabled = true;
    document.forms1.uloz.disabled = true;
    document.forms1.h_slu.focus();
<?php
if ( $copern == 87 ) 
{
?>
    document.forms.forms1.h_slu.value = '<?php echo $z_slu; ?>';
    document.forms.forms1.h_nsl.value = '<?php echo $z_nsl; ?>';
    document.forms.forms1.h_dph.value = '<?php echo $z_dph; ?>';
    document.forms.forms1.h_cep.value = '<?php echo $z_cep; ?>';
    document.forms.forms1.h_ced.value = '<?php echo $z_ced; ?>';
    document.forms.forms1.h_mno.value = '<?php echo $z_mno; ?>';
    document.forms.forms1.h_mer.value = '<?php echo $z_mer; ?>';
<?php
}
?>
    }

    function Hlas()
    {
    document.forms1.hlas.value = 'ANO';
    }

    function NeHlas()
    {
    document.forms1.hlas.value = 'NIE';
    }

    function Zapis_COOK()
    {

    return (true);
    }

    function Povol_uloz()
    {
    var okvstup=1;

    if ( document.forms1.err_slu.value == '1' ) okvstup=0;
    if ( document.forms1.err_cep.value == '1' ) okvstup=0;
    if ( document.forms1.err_ced.value == '1' ) okvstup=0;
    if ( document.forms1.err_mno.value == '1' ) okvstup=0;
    if ( document.forms1.h_slu.value == '' ) okvstup=0;
    if ( document.forms1.h_nsl.value == '' ) okvstup=0;
    if ( document.forms1.h_cep.value == '' ) okvstup=0;
    if ( document.forms1.h_ced.value == '' ) okvstup=0;
    if ( document.forms1.h_mno.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.forms1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.forms1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    Zm.style.display="none";
    }


<?php
//koniec skriptu 7 77777777
}?>


//script pre copern  17 171717171717 vstup text sluzby
<?php
if ( $copern == 17 OR $copern == 97 ) 
{?>


function PopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        document.forms.forms1.h_mer.focus();
        document.forms.forms1.h_mer.select();
              }

                }


function MerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.forms1.h_pop.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms.forms1.submit(); return (true); }
    if ( okvstup == 0 && document.forms1.h_pop.value == '' ) { document.forms1.h_pop.focus(); return (false); }
              }
                }
                 
    function ObnovUI()
    {
    <?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    }
    function VyberVstup()
    {
    document.forms1.h_cpl.disabled = true;
    document.forms1.h_hdp.disabled = true;
    document.forms1.h_hdd.disabled = true;
    document.forms1.uloz.disabled = true;
<?php
if ( $copern == 97 ) 
{
?>
    document.forms.forms1.h_pop.value = '<?php echo $z_pop; ?>';
<?php
}
?>
    document.forms1.h_pop.focus();
    document.forms1.h_pop.select();
    }

    function Zapis_COOK()
    {

    return (true);
    }

    function Povol_uloz()
    {
    var okvstup=1;

    if ( document.forms1.h_pop.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.forms1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    Zm.style.display="none";
    }


<?php
//koniec skriptu 17 171717171717
}?>


//script pre copern 5555555555555[[[[[[[[[[88888888888888888
<?php
if ( $copern == 5 OR $copern == 8 ) 
{?>
    function ObnovUI()
    {
<?php if( $vybr == 'ANO' )
{
 if( $cislo_uce != '' ) { echo "document.fhlv1.h_uce.value = '$cislo_uce';\r"; }
 echo "document.fhlv1.h_dok.value = '$cislo_dok';\r";
 echo "document.fhlv1.h_fak.value = '$cislo_fak';\r";
 echo "document.fhlv1.h_sz3.value = '$cislo_sz3';\r";
 echo "document.fhlv1.h_dav.value = '$cislo_dav';\r";
 echo "document.fhlv1.h_dat.value = '$cislo_dat';\r";
 echo "document.fhlv1.h_daz.value = '$cislo_daz';\r";
 if( $drupoh == 2 ) { echo "document.fhlv1.h_dao.value = '$cislo_dao';\r"; }
 echo "document.fhlv1.h_das.value = '$cislo_das';\r";
 echo "document.fhlv1.h_ksy.value = '$cislo_ksy';\r";
 echo "document.fhlv1.h_ssy.value = '$cislo_ssy';\r";
 echo "document.fhlv1.h_str.value = '$cislo_str';\r";
 echo "document.fhlv1.h_zak.value = '$cislo_zak';\r";
 echo "document.fhlv1.h_dol.value = '$cislo_dol';\r";
 echo "document.fhlv1.h_prf.value = '$cislo_prf';\r";
 echo "document.fhlv1.h_obj.value = '$cislo_obj';\r";
 echo "document.fhlv1.h_unk.value = '$cislo_unk';\r";
 echo "document.fhlv1.h_dpr.value = '$cislo_dpr';\r";
 echo "document.fhlv1.h_hod.value = '$cislo_hod';\r";
 if ( $pocstav != 1 ) {  echo "document.fhlv1.h_zal.value = '$cislo_zal';\r"; }
 if ( ( $drupoh == 1 OR $drupoh == 31 ) AND $pocstav != 1 ) { echo "document.fhlv1.h_ruc.value = '$cislo_ruc';\r"; }
 if ( $pocstav == 1 ) {  echo "document.fhlv1.h_uhr.value = '$cislo_uhr';\r"; }
 echo "document.fhlv1.h_zk0.value = '$cislo_zk0';\r";
 echo "document.fhlv1.h_sp0.value = '$cislo_zk0';\r";
 echo "document.fhlv1.h_zao.value = '$cislo_zao';\r";
 echo "document.fhlv1.h_zk1.value = '$cislo_zk1';\r";
 echo "document.fhlv1.h_zk2.value = '$cislo_zk2';\r";
 echo "document.fhlv1.h_dn1.value = '$cislo_dn1';\r";
 echo "document.fhlv1.h_dn2.value = '$cislo_dn2';\r";
 echo "document.fhlv1.h_sp1.value = '$cislo_sp1';\r";
 echo "document.fhlv1.h_sp2.value = '$cislo_sp2';\r";
 echo "document.fhlv1.h_poz.value = '$cislo_poz';";
// echo "document.fhlv1.h_txp.value = '$cislo_txp';";
// echo "document.fhlv1.h_txz.value = '$cislo_txz';";
 echo "document.fhlv1.h_ico.value = '$vybr_ico';\r";
 echo "document.fhlv1.h_nai.value = '$vybr_nai';\r";
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


    function Rozb1()
    {
    var akevelke = document.fhlv1.rozb1.value;
    myTextpred = document.getElementById("h_txp");
    if( akevelke != 'VELKE' )
      {
    myTextpred.rows = 8;
    myTextpred.cols = 80;
    document.fhlv1.rozb1.value = 'VELKE';
      }
    if( akevelke == 'VELKE' )
      {
    myTextpred.rows = 1;
    myTextpred.cols = 50;
    document.fhlv1.rozb1.value = 'MALE';
      }
    }

    function NeRozb1()
    {

    }

    function Rozb2()
    {
    var akevelke2 = document.fhlv1.rozb2.value;
    myTextza = document.getElementById("h_txz");
    if( akevelke2 != 'VELKE' )
      {
    myTextza.rows = 8;
    myTextza.cols = 80;
    document.fhlv1.rozb2.value = 'VELKE';
      }
    if( akevelke2 == 'VELKE' )
      {
    myTextza.rows = 1;
    myTextza.cols = 50;
    document.fhlv1.rozb2.value = 'MALE';
      }
    }

    function NeRozb2()
    {

    }

    function Sluz1()
    {
    document.fhlv1.sluz1.value = 'VELKE';
    }

    function NeSluz1()
    {
    document.fhlv1.sluz1.value = 'MALE';
    }


    function Povol_uloz()
    {
    document.fhlv1.uctovat.value = '0';
    var okvstup=1;

    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_daz.value == '' ) okvstup=0;
    if ( document.fhlv1.h_das.value == '' ) okvstup=0;
    if ( document.fhlv1.h_ico.value == '' ) okvstup=0;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_daz.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_das.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_ico.value == '1' ) okvstup=0;

    if ( okvstup == 1 )
       { 
         document.fhlv1.uloh.disabled = false;
<?php
if ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
?>
 document.fhlv1.sluzby.disabled = false;
 document.fhlv1.tovar.disabled = false;
<?php
}
?>
         Fxh.style.display="none"; return (true);
       }
       else { 
            document.fhlv1.uloh.disabled = true;
            <?php
            if ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
            {
            ?>
            document.fhlv1.sluzby.disabled = true;
            document.fhlv1.tovar.disabled = true;
            <?php
            }
            ?>
            Fxh.style.display="";
            if ( okvstup == 0 && document.fhlv1.h_zak.value == '' ){ document.fhlv1.h_zak.focus(); document.fhlv1.h_zak.select();}
            return (false) ;
            }

    }

    function VyberVstup()
    {

<?php if( $hlat == 'ANO' OR $rozb1 == 'VELKE' OR $rozb2 == 'VELKE' OR $rozb1 == 'MALE' OR $rozb2 == 'MALE'  )
{
 if( $h_uce != '' ) { echo "document.fhlv1.h_uce.value = '$h_uce';"; }
 echo "document.fhlv1.h_dok.value = '$h_dok';";
 echo "document.fhlv1.h_das.value = '$h_das';";
 echo "document.fhlv1.h_daz.value = '$h_daz';";
 if( $drupoh == 2 ) { echo "document.fhlv1.h_dao.value = '$h_dao';\r"; }
 echo "document.fhlv1.h_dat.value = '$h_dat';";
 echo "document.fhlv1.h_dol.value = '$h_dol';";
 echo "document.fhlv1.h_prf.value = '$h_prf';";
 echo "document.fhlv1.h_str.value = '$h_str';";
 echo "document.fhlv1.h_zak.value = '$h_zak';";
 echo "document.fhlv1.h_ksy.value = '$h_ksy';";
 echo "document.fhlv1.h_ssy.value = '$h_ssy';";
 echo "document.fhlv1.h_dol.value = '$h_dol';";
 echo "document.fhlv1.h_prf.value = '$h_prf';";
 echo "document.fhlv1.h_obj.value = '$h_obj';";
 echo "document.fhlv1.h_unk.value = '$h_unk';";
 echo "document.fhlv1.h_dpr.value = '$h_dpr';";
 echo "document.fhlv1.h_hod.value = '$h_hod';";
 echo "document.fhlv1.h_zal.value = '$h_zal';";
 if ( $drupoh == 1 OR $drupoh == 31 ) { echo "document.fhlv1.h_ruc.value = '$h_ruc';\r"; }
 echo "document.fhlv1.h_zk0.value = '$h_zk0';";
 echo "document.fhlv1.h_sp0.value = '$h_zk0';";
 echo "document.fhlv1.h_zk1.value = '$h_zk1';";
 echo "document.fhlv1.h_zk2.value = '$h_zk2';";
 echo "document.fhlv1.h_dn1.value = '$h_dn1';";
 echo "document.fhlv1.h_dn2.value = '$h_dn2';";
 echo "document.fhlv1.h_sp1.value = '$h_sp1';";
 echo "document.fhlv1.h_sp2.value = '$h_sp2';";
 echo "document.fhlv1.h_poz.value = '$h_poz';";
// echo "document.fhlv1.h_txp.value = '$hu_txp';";
// echo "document.fhlv1.h_txz.value = '$hu_txz';";
}
?>

<?php if( $hlat != 'ANO' AND $vybr != 'ANO' AND $rozb1 != 'VELKE' AND $rozb2 != 'VELKE' AND $rozb1 != 'MALE' AND $rozb2 != 'MALE' )
{
 echo "document.forms.fhlv1.h_uce.focus();";
}
?>

<?php if( $vybr == 'ANO' )
{
?>
  document.fhlv1.h_ico.focus();
  document.fhlv1.h_ico.select();
  document.fhlv1.h_nai.disabled = true;
<?php
}
?>

<?php if( $rozb1 == 'VELKE' )
{
?>
  document.fhlv1.h_txp.focus();
<?php
}
?>

<?php if( $rozb2 == 'VELKE' )
{
?>
  document.fhlv1.h_txz.focus();
<?php
}
?>

<?php if( $rozb1 == 'MALE' )
{
?>
  document.fhlv1.h_zk1.focus();
<?php
}
?>

<?php if( $rozb2 == 'MALE' )
{
?>
  document.fhlv1.h_poz.focus();
<?php
}
?>

    document.fhlv1.uloh.disabled = true;
    document.fhlv1.h_dns.disabled = true;
<?php
if ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
?>
 document.fhlv1.sluzby.disabled = true;
 document.fhlv1.tovar.disabled = true;
<?php
}
?>
    <?php if( $hladaj_uce != '' ) { ?> document.fhlv1.h_uce.value='<?php echo $hladaj_ucex;?>'; <?php } ?>
    <?php if( $pocstav != 1 )     { ?> document.fhlv1.nwwdok.disabled = true; <?php } ?>
   }


    function Zapis_COOK()
    {

    }

    function Obnov_vstup()
    {

    }


<?php
}?>
//koniec scriptu copern 5,8

//[[[[[[[[[[[[
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
         if ( $copern == 5 OR $copern == 8 ) 
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
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
<?php
if ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
?>
 document.fhlv1.sluzby.disabled = true;
 document.fhlv1.tovar.disabled = true;
<?php
}
?>
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
         if ( $copern == 5 OR $copern == 8 ) 
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
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
<?php
if ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
?>
 document.fhlv1.sluzby.disabled = true;
 document.fhlv1.tovar.disabled = true;
<?php
}
?>
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


//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
<?php if( $_SESSION['nieie'] == 0 )  { ?>
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;
<?php                                } ?>
    }

//funkcia na prepnutie do uctovania zo zahlavia
    function Uctovat() 
      { 
    document.fhlv1.uctovat.value = '1';
    var okvstup=1;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_daz.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_das.value == '1' ) okvstup=0;

    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_daz.value == '' ) okvstup=0;
    if ( document.fhlv1.h_das.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; document.forms.fhlv1.submit(); return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (true); }

      }

//funkcia na prepnutie do uctovania z poloziek
    function UctovatPol() 
      { 

window.open('../faktury/vstf_t.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=ANO&copern=20&drupoh=<?php echo $drupoh;?>
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok;?>&h_ico=<?php echo $h_ico;?>
&h_uce=<?php echo $_uce;?>&h_unk=<?php echo $h_unk;?>', '_self' );

      }

    
//robot 

  function ukazrobot()
  { 
  myRobot = document.getElementById("robotokno");
  myRobotmenu = document.getElementById("robotmenu");
  myRobothlas = document.getElementById("robothlas");
  myRobot.style.top = toprobot;
  myRobot.style.left = leftrobot;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobothlas.style.top = toprobothlas;
  myRobothlas.style.left = leftrobothlas;
  <?php if( $kli_vduj >= 0 AND $vyb_robot == 1 ) { echo "robotokno.style.display=''; robotmenu.style.display='none';"; } ?>
  }

  function zhasnirobot()
  { 
  robotokno.style.display='none';
  robotmenu.style.display='none';
  robothlas.style.display='none';
  }

  function zobraz_robotmenu()
  { 
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlmenu;
  robotmenu.style.display='';
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  robotmenu.style.display='none';
  robothlas.style.display='none';
  }

    var toprobot = 330;
    var leftrobot = 40;
    var toprobotmenu = 310;
    var leftrobotmenu = 70;
    var widthrobotmenu = 400;
    var toprobothlas = 350;
    var leftrobothlas = 60;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>";
    htmlmenu += "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmenu += "onClick='zhasni_menurobot();' alt='Zhasni menu' title='Zhasni menu' ></td></tr>";  

<?php if( ( $copern == 5 OR $copern == 7 ) AND $rozuct == 'ANO' ) { ?>

<?php
$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }
$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; $nuctpoh=""; }
$duj_vfor=$kli_vduj;
$dru_vfor=1*10+$drupoh;
if( $copern == 7 ) { $duj_vfor=1*10+$kli_vduj; }
$sqltt = "SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ucto = '$kli_vduj' AND druh = '$dru_vfor' ORDER BY cpoh";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>

    var toprobotmenu = toprobot - <?php echo $cpol; ?>*19;

    if( toprobot < 100 ) { toprobot=100; }

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(<?php echo $duj_vfor; ?>,<?php echo $dru_vfor; ?>,<?php echo $riadok->cpoh; ?>); window.name = 'zoznam';\">" +
"Chcete za˙Ëtovaù <?php echo $riadok->pohp; ?> ?</a>";
    htmlmenu += "</td></tr>";

<?php
  }
$i=$i+1;
   }
?>

<?php                    } ?>


    htmlmenu += "</table>";  
    
</script>

<?php if( ( $copern == 5 OR $copern == 7 ) AND $kli_vduj >= 0 AND $vyb_robot == 1 AND $rozuct == 'ANO' ) 
{ echo "<script type='text/javascript' src='robot_fuct.js'></script>"; } ?>

<?php if( ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 ) AND $copern == 7 ) 
{ echo "<script type='text/javascript' src='../ucto/uloz_mena.js'></script>"; } ?>

<script type='text/javascript'>

<?php //predvolene texty pre fakturu
if( ( $drupoh == 1 OR $drupoh == 2 ) AND ( $copern == 5 OR $copern == 8 ) ) { 
  if( $drupoh == 1 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 1 ORDER BY cpt"); }
  if( $drupoh == 2 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 11 ORDER BY cpt"); }
$i=0;
while( $i <= 3 ) {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
  $riadok=mysql_fetch_object($sql);
  if( $i == 0 ) $ptxp1=$riadok->txx;
  if( $i == 1 ) $ptxp2=$riadok->txx;
  if( $i == 2 ) $ptxp3=$riadok->txx;
  if( $i == 3 ) $ptxp4=$riadok->txx;
  }
$i=$i+1;
                 }
$pole_txp1 = explode("\r\n", $ptxp1);
$pole_txp2 = explode("\r\n", $ptxp2);
$pole_txp3 = explode("\r\n", $ptxp3);
$pole_txp4 = explode("\r\n", $ptxp4);

  if( $drupoh == 1 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 2 ORDER BY cpt"); }
  if( $drupoh == 2 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 12 ORDER BY cpt"); }
$i=0;
while( $i <= 3 ) {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
  $riadok=mysql_fetch_object($sql);
  if( $i == 0 ) $ptxz1=$riadok->txx;
  if( $i == 1 ) $ptxz2=$riadok->txx;
  if( $i == 2 ) $ptxz3=$riadok->txx;
  if( $i == 3 ) $ptxz4=$riadok->txx;
  }
$i=$i+1;
                 }
$pole_txz1 = explode("\r\n", $ptxz1);
$pole_txz2 = explode("\r\n", $ptxz2);
$pole_txz3 = explode("\r\n", $ptxz3);
$pole_txz4 = explode("\r\n", $ptxz4);

?>
    htmlptxp1_1 = "<?php echo $pole_txp1[0];?>";
    htmlptxp1_2 = "<?php echo $pole_txp1[1];?>";
    htmlptxp1_3 = "<?php echo $pole_txp1[2];?>";
    htmlptxp1_4 = "<?php echo $pole_txp1[3];?>";
    htmlptxp1_5 = "<?php echo $pole_txp1[4];?>";
    htmlptxp2_1 = "<?php echo $pole_txp2[0];?>";
    htmlptxp2_2 = "<?php echo $pole_txp2[1];?>";
    htmlptxp2_3 = "<?php echo $pole_txp2[2];?>";
    htmlptxp2_4 = "<?php echo $pole_txp2[3];?>";
    htmlptxp2_5 = "<?php echo $pole_txp2[4];?>";
    htmlptxp3_1 = "<?php echo $pole_txp3[0];?>";
    htmlptxp3_2 = "<?php echo $pole_txp3[1];?>";
    htmlptxp3_3 = "<?php echo $pole_txp3[2];?>";
    htmlptxp3_4 = "<?php echo $pole_txp3[3];?>";
    htmlptxp3_5 = "<?php echo $pole_txp3[4];?>";
    htmlptxp4_1 = "<?php echo $pole_txp4[0];?>";
    htmlptxp4_2 = "<?php echo $pole_txp4[1];?>";
    htmlptxp4_3 = "<?php echo $pole_txp4[2];?>";
    htmlptxp4_4 = "<?php echo $pole_txp4[3];?>";
    htmlptxp4_5 = "<?php echo $pole_txp4[4];?>";

    htmlptxz1_1 = "<?php echo $pole_txz1[0];?>";
    htmlptxz1_2 = "<?php echo $pole_txz1[1];?>";
    htmlptxz1_3 = "<?php echo $pole_txz1[2];?>";
    htmlptxz1_4 = "<?php echo $pole_txz1[3];?>";
    htmlptxz1_5 = "<?php echo $pole_txz1[4];?>";
    htmlptxz2_1 = "<?php echo $pole_txz2[0];?>";
    htmlptxz2_2 = "<?php echo $pole_txz2[1];?>";
    htmlptxz2_3 = "<?php echo $pole_txz2[2];?>";
    htmlptxz2_4 = "<?php echo $pole_txz2[3];?>";
    htmlptxz2_5 = "<?php echo $pole_txz2[4];?>";
    htmlptxz3_1 = "<?php echo $pole_txz3[0];?>";
    htmlptxz3_2 = "<?php echo $pole_txz3[1];?>";
    htmlptxz3_3 = "<?php echo $pole_txz3[2];?>";
    htmlptxz3_4 = "<?php echo $pole_txz3[3];?>";
    htmlptxz3_5 = "<?php echo $pole_txz3[4];?>";
    htmlptxz4_1 = "<?php echo $pole_txz4[0];?>";
    htmlptxz4_2 = "<?php echo $pole_txz4[1];?>";
    htmlptxz4_3 = "<?php echo $pole_txz4[2];?>";
    htmlptxz4_4 = "<?php echo $pole_txz4[3];?>";
    htmlptxz4_5 = "<?php echo $pole_txz4[4];?>";

    function Txp1()
    {
    document.fhlv1.h_txp.value = htmlptxp1_1 + "\r\n" + htmlptxp1_2 + "\r\n" + htmlptxp1_3 + "\r\n" + htmlptxp1_4 + "\r\n" + htmlptxp1_5;
    }
    function Txp2()
    {
    document.fhlv1.h_txp.value = htmlptxp2_1 + "\r\n" + htmlptxp2_2 + "\r\n" + htmlptxp2_3 + "\r\n" + htmlptxp2_4 + "\r\n" + htmlptxp2_5;
    }
    function Txp3()
    {
    document.fhlv1.h_txp.value = htmlptxp3_1 + "\r\n" + htmlptxp3_2 + "\r\n" + htmlptxp3_3 + "\r\n" + htmlptxp3_4 + "\r\n" + htmlptxp3_5;
    }
    function Txp4()
    {
    document.fhlv1.h_txp.value = htmlptxp4_1 + "\r\n" + htmlptxp4_2 + "\r\n" + htmlptxp4_3 + "\r\n" + htmlptxp4_4 + "\r\n" + htmlptxp4_5;
    }

    function Txz1()
    {
    document.fhlv1.h_txz.value = htmlptxz1_1 + "\r\n" + htmlptxz1_2 + "\r\n" + htmlptxz1_3 + "\r\n" + htmlptxz1_4 + "\r\n" + htmlptxz1_5;
    }
    function Txz2()
    {
    document.fhlv1.h_txz.value = htmlptxz2_1 + "\r\n" + htmlptxz2_2 + "\r\n" + htmlptxz2_3 + "\r\n" + htmlptxz2_4 + "\r\n" + htmlptxz2_5;
    }
    function Txz3()
    {
    document.fhlv1.h_txz.value = htmlptxz3_1 + "\r\n" + htmlptxz3_2 + "\r\n" + htmlptxz3_3 + "\r\n" + htmlptxz3_4 + "\r\n" + htmlptxz3_5;
    }
    function Txz4()
    {
    document.fhlv1.h_txz.value = htmlptxz4_1 + "\r\n" + htmlptxz4_2 + "\r\n" + htmlptxz4_3 + "\r\n" + htmlptxz4_4 + "\r\n" + htmlptxz4_5;
    }

<?php //koniec predvolene texty pre fakturu
                   } ?>

</script>

<script type='text/javascript'>

<?php if( $_SESSION['nieie'] == 0 )  { ?>

function TlacPdf()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>', '_blank', '<?php echo $tlcuwin; ?>' );

                }

function TlacPdfbezCen()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&bezcen=1', '_blank', '<?php echo $tlcuwin; ?>' );

                }

function TlacPdfD()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&jazyk=1', '_blank', '<?php echo $tlcuwin; ?>' );

                }

function TlacPdfGB()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&jazyk=2', '_blank', '<?php echo $tlcuwin; ?>' );

                }

function TlacPdfDod()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&dodaci=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>', '_blank', '<?php echo $tlcuwin; ?>' );

                }

function TlacPdfPrf()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&predfaktura=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>', '_blank', '<?php echo $tlcuwin; ?>' );

                }

<?php                                } ?>

<?php if( $_SESSION['nieie'] == 1 )  { ?>

function TlacPdf()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function TlacPdfbezCen()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&bezcen=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function TlacPdfD()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&jazyk=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function TlacPdfGB()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&jazyk=2', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function TlacPdfDod()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&dodaci=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function TlacPdfPrf()
                {              

  var h_razitko = 0;
  var h_pocpol = 0;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
  var h_pocpol = document.formx1.h_pocpol.value;
<?php
     }
?>
window.open('vstf_pdf.php?h_razitko=' + h_razitko + '&h_pocpol=' + h_pocpol + '&copern=20&predfaktura=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }



<?php                                } ?>


</script>
<script type='text/javascript'>

function newIco()
                {

window.open('../cis/cico.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=5&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php if( $tlacitkoenter == 1 ) {  ?>

    function polohaen1()
    { 
  myEnter = document.getElementById("tlacitkoEnter");
  myEnter.style.top = 150;
  myEnter.style.left = 410;
    }

    function polohaen2()
    { 
  myEnter = document.getElementById("tlacitkoEnter");
  myEnter.style.top = 400;
  myEnter.style.left = 410;
    }

    function ukaztlacitkoEnter()
    { 
    tlacitkoEnter.style.display='';
    }

    function zhasni_Enter()
    { 
    tlacitkoEnter.style.display='none';
    }

    function tlacitko_Enter()
    { 

    <?php if( $copern == 5 OR $copern == 8 ) {  ?>
    document.forms.fhlv1.klikenter.value=1;
    if( document.forms.fhlv1.kdefoc.value == 'uce' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; UceEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'fak' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; FakEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'ico' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; IcoEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'nai' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; NaiEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dat' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; DatEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'das' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; DasEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'daz' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; DazEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'obj' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; ObjEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'unk' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; UnkEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'str' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; StrEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zak' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; ZakEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dol' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; DolEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'prf' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; PrfEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'ksy' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; KsyEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'ssy' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; SsyEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dpr' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; DprEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zk1' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Zk1Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dn1' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Dn1Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zk2' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Zk2Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dn2' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Dn2Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zk0' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Zk0Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zao' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; ZaoEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'hod' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; HodEnter(13); }
    <?php                    }  ?>
    <?php if( $copern == 7 ) {  ?>
    document.forms.forms1.klikenter.value=1;
    if( document.forms.forms1.kdefoc.value == 'slu' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; SluEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'nsl' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; NslEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'cep' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; CepEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'ced' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; CedEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'mno' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; MnoEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'mer' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; MerEnter(13); }
    <?php                    }  ?>
    }


<?php                           }  ?> 

    <?php if( $copern == 5 OR $copern == 8 ) {  ?>
    function onUce()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'uce';"; } ?>  }
    function onFak()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'fak';"; } ?>  }
    function onIco()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'ico';"; } ?>  }
    function onNai()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'nai';"; } ?>  }
    function onDas()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'das';"; } ?>  }
    function onDaz()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'daz';"; } ?>  }
    function onDat()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dat';"; } ?>  }
    function onObj()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'obj';"; } ?>  }
    function onUnk()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'unk';"; } ?>  }
    function onStr()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'str';"; } ?>  }
    function onZak()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zak';"; } ?>  }
    function onDol()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dol';"; } ?>  }
    function onPrf()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'prf';"; } ?>  }
    function onKsy()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'ksy';"; } ?>  }
    function onSsy()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'ssy';"; } ?>  }
    function onDpr()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dpr';"; } ?>  }
    function onZk1()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zk1';"; } ?>  }
    function onDn1()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dn1';"; } ?>  }
    function onZk2()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zk2';"; } ?>  }
    function onDn2()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dn2';"; } ?>  }
    function onZk0()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zk0';"; } ?>  }
    function onZao()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zao';"; } ?>  }
    function onHod()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'hod';"; } ?>  }
    <?php                    }  ?>
    <?php if( $copern == 7 ) {  ?>
    function onSlu()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'slu';"; } ?>  }
    function onNsl()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'nsl';"; } ?>  }
    function onCep()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'cep';"; } ?>  }
    function onCed()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'ced';"; } ?>  }
    function onMno()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'mno';"; } ?>  }
    function onMer()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'mer';"; } ?>  }
    <?php                    }  ?>
</script>

<?php if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 42 ) AND $sysx != 'UCT' ) { ?>
<script type="text/javascript" src="fak_setx.js"></script>
<?php if ( $drupoh == 1 ) { ?>
<script type="text/javascript" src="vyvoz_setx.js"></script>
<?php                     } ?>
<?php                                                         } ?>

<script type='text/javascript'>
<?php if( ( $drupoh == 1 OR $drupoh == 2 ) AND ( $copern == 5 OR $copern == 8 ) ) {  ?>

  function zoznamTextov()
  { 
  myRobotmenu = document.getElementById("robotmenu");
  //myRobotmenu.style.width = 300;
  //myRobotmenu.style.left = 800;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlzoznamtextov;
  robotmenu.style.display='';
  }

  function zoznamTextov2()
  { 
  myRobotmenu = document.getElementById("robotmenu");
  //myRobotmenu.style.width = 300;
  //myRobotmenu.style.left = 800;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlzoznamtextov2;
  robotmenu.style.display='';
  }

  function zhasni_zoznamTextov()
  { 
  robotmenu.style.display='none';
  }

  function nastavText(textxy)
  { 
  var uri=textxy;

  //document.forms.fhlv1.h_txp.value=decodeURIComponent(uri);
  //document.forms.fhlv1.h_txp.value="aaaaa";
  //document.forms.fhlv1.h_txp.value=uri;
  //document.forms.fhlv1.h_txp.value=unescape(uri);
  var urix=uri.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXNNN", "\n");
  var urix=urix.replace("XXXNNN", "\n");
  var urix=urix.replace("XXXNNN", "\n");
  document.forms.fhlv1.h_txp.value=urix.replace("XXXNNN", "\n");
  robotmenu.style.display='none';
  }

  function nastavText2(textxy)
  { 
  var uri=textxy;

  var urix=uri.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXRRR", "\r");
  var urix=urix.replace("XXXNNN", "\n");
  var urix=urix.replace("XXXNNN", "\n");
  var urix=urix.replace("XXXNNN", "\n");
  document.forms.fhlv1.h_txz.value=urix.replace("XXXNNN", "\n");
  robotmenu.style.display='none';
  }

    var htmlzoznamtextov = "<table  class='ponuka' width='100%'><tr><td width='90%'>Texty pred</td>";
    htmlzoznamtextov += "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlzoznamtextov += "onClick='zhasni_zoznamTextov();' title='Zhasni menu' ></td></tr>";  

<?php
if( $drupoh == 1 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 1 ORDER BY cpt"; }
if( $drupoh == 2 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 11 ORDER BY cpt"; }
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$text=$riadok->txx;
//$textr=urlencode($riadok->txx);
//$textr30=substr($textr,0,30);
//$textad=addslashes($text);
$textrp=str_replace("\r","XXXRRR",$text);
$textrep=str_replace("\n","XXXNNN",$textrp);

$textrpt=str_replace("\r"," ",$text);
$textrept=str_replace("\n","",$textrpt);
$textrept30=substr($textrept,0,30);
?>
    htmlzoznamtextov += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
    htmlzoznamtextov += "<a href=\"#\" onClick=\"nastavText('<?php echo $textrep; ?>'); \" ><?php echo $textrept30; ?> </a>";
    htmlzoznamtextov += "</td></tr>";

<?php
  }
$i=$i+1;
   }
?>
    htmlzoznamtextov += "</table>";



    var htmlzoznamtextov2 = "<table  class='ponuka' width='100%'><tr><td width='90%'>Texty za</td>";
    htmlzoznamtextov2 += "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlzoznamtextov2 += "onClick='zhasni_zoznamTextov();' title='Zhasni menu' ></td></tr>";  

<?php
if( $drupoh == 1 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 2 ORDER BY cpt"; }
if( $drupoh == 2 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 12 ORDER BY cpt"; }
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$text=$riadok->txx;
//$textr=urlencode($riadok->txx);
//$textr30=substr($textr,0,30);
//$textad=addslashes($text);
$textrp=str_replace("\r","XXXRRR",$text);
$textrep=str_replace("\n","XXXNNN",$textrp);

$textrpt=str_replace("\r"," ",$text);
$textrept=str_replace("\n","",$textrpt);
$textrept30=substr($textrept,0,30);
?>
    htmlzoznamtextov2 += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
    htmlzoznamtextov2 += "<a href=\"#\" onClick=\"nastavText2('<?php echo $textrep; ?>'); \" ><?php echo $textrept30; ?> </a>";
    htmlzoznamtextov2 += "</td></tr>";

<?php
  }
$i=$i+1;
   }
?>
    htmlzoznamtextov2 += "</table>";

<?php                                    }  ?>


function TlacNespSaldo(icox)
                {

var h_ico = icox;

window.open('../ucto/saldo_pdf.php?h_uce=31100&h_nai=&h_ico=' + h_ico + '&h_obd=0&copern=10&drupoh=1&page=1&h_su=0&h_al=1&analyzy=0&zico=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OverIcdph()
                {
        window.open('http://ec.europa.eu/taxation_customs/vies/', '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes'); 
                }

</script>
</HEAD>

<BODY class="white" id="white" onload="ObnovUI(); VyberVstup(); <?php if( ( $copern == 5 OR $copern == 7 ) AND $rozuct == 'ANO' ) { echo " ukazrobot(); "; } ?>
 <?php if( $tlacitkoenter == 1 ) { echo " ukaztlacitkoEnter(); "; } ?>
 <?php if( $copern == 7 AND $tlacitkoenter == 1 ) { echo " polohaen2(); "; } ?>
 ">

<?php if( $tlacitkoenter == 1 ) {  ?>

<div id="tlacitkoEnter" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 150; left: 410; width:80; height:25;">
<img border=0 src='../obr/tlacitka/enter.jpg' style='width:50; height:20;' onClick="tlacitko_Enter();"
 title='tlaËÌtko Enter' >
<img border=+ src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="zhasni_Enter();"
 title='zhasn˙ù Enter' >
</div>


<?php                           }  ?>

<?php
//nastavenie datumu do kvdph
if ( ( $copern == 5 AND ( $drupoh == 1 OR $drupoh == 2 ) ) OR ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 2 ) ) )
     {

$sql = "SELECT nzk0 FROM F".$kli_vxcf."_autopausal".$kli_uzid." ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = "DROP TABLE F".$kli_vxcf."_autopausal".$kli_uzid." ";
$vysledok = mysql_query("$sqlt");
$sqlt = <<<mzdprc
(
   id           INT(7) DEFAULT 0,
   udp          VARCHAR(11) NOT NULL,
   adp          VARCHAR(11) NOT NULL,
   uzk          VARCHAR(11) NOT NULL,
   azk          VARCHAR(11) NOT NULL,
   ajo          DECIMAL(2,0) DEFAULT 0,
   aju          VARCHAR(11) NOT NULL,
   xzk          DECIMAL(10,2) DEFAULT 0,
   xdp          DECIMAL(10,2) DEFAULT 0,
   mzk          DECIMAL(10,2) DEFAULT 0,
   mdp          DECIMAL(10,2) DEFAULT 0,
   nzk          DECIMAL(10,2) DEFAULT 0,
   ndp          DECIMAL(10,2) DEFAULT 0,

   xzk0         DECIMAL(10,2) DEFAULT 0,
   mzk0         DECIMAL(10,2) DEFAULT 0,
   nzk0         DECIMAL(10,2) DEFAULT 0,

   kox          DECIMAL(2,0) DEFAULT 0
);
mzdprc;

$vsql = "CREATE TABLE F".$kli_vxcf."_autopausal".$kli_uzid." ".$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_autopausal".$kli_uzid." ( id, udp, adp, uzk, azk, ajo, aju ) VALUES ( '$kli_uzid', '', '', '', '99', 0, '' ) ";
if( $kli_vduj == 9 )
 {
$vsql = "INSERT INTO F".$kli_vxcf."_autopausal".$kli_uzid." ( id, udp, adp, uzk, azk, ajo, aju ) VALUES ( '$kli_uzid', '', '99', '17', '', 0, '' ) ";
 }
$vytvor = mysql_query("$vsql");

}


$udp="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_autopausal$kli_uzid WHERE id > 0 ORDER BY id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $udp=$riaddok->udp;
  $adp=$riaddok->adp;
  $uzk=$riaddok->uzk;
  $azk=$riaddok->azk;
  $ajo=$riaddok->ajo;
  $aju=$riaddok->aju;

  }
?>
<div id="nastavpaux" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 260px; left: 170px; width:620px; height:300px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie ˙Ëtovania pauöalnych v˝davkov 80 - 20 % PHM ...</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavpaux.style.display='none';" title='Zhasni' ></td></tr>  
                    
<tr><FORM name='enastpau' method='post' action='#' >
<td class='ponuka' colspan='4' align='left'> 
 ⁄Ëet DPH 20% neodpoËÌtan· 
<td class='ponuka' colspan='1' align='left'> 
<input type='text' name='h_udp' id='h_udp' size='10' maxlenght='10' value='<?php echo $udp; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 34399, 34388... = ⁄Ëet pre ˙Ëtovanie 20% neodpoËÌtanej DPH' >
</td></tr>
<tr><td class='ponuka' colspan='4'> 
 Analityka DPH 20% neodpoËÌtan· 
<td class='ponuka' colspan='1'> 
<input type='text' name='h_adp' id='h_adp' size='10' maxlenght='10' value='<?php echo $adp; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 99, 88... = Analytika pre ˙Ëtovanie 20% neodpoËÌtanej DPH. ⁄Ëet rovnak˝ ako v nastavenÌ Robota. Ak nastavÌte analytiku, ˙Ëet nechajte pr·zdny a opaËne ak nastavÌte ˙Ëet, analytiku nechajte pr·zdnu.' >
</td></tr>
<tr><td class='ponuka' colspan='4'> 
 ⁄Ëet Z·klad 20% neuplatnen˝ 
<td class='ponuka' colspan='1'> 
<input type='text' name='h_uzk' id='h_uzk' size='10' maxlenght='10' value='<?php echo $uzk; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 50199, 21399... = ⁄Ëet pre ˙Ëtovanie 20% neuplatnenÈho z·kladu DPH, pripoËÌtateænej poloûky' >
</td></tr>
<tr><td class='ponuka' colspan='4'> 
 Analityka Z·klad 20% neuplatnen˝  
<td class='ponuka' colspan='1'> 
<input type='text' name='h_azk' id='h_azk' size='10' maxlenght='10' value='<?php echo $azk; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 99, 88... = Analytika pre ˙Ëtovanie neuplatnenÈho z·kladu DPH, pripoËÌtateænej poloûky. ⁄Ëet rovnak˝ ako v nastavenÌ Robota. Ak nastavÌte analytiku, ˙Ëet nechajte pr·zdny a opaËne ak nastavÌte ˙Ëet, analytiku nechajte pr·zdnu.' >
</td></tr>
<tr><td class='ponuka' colspan='4'>
Od˙Ëtovaù neodpoËÌtan˙ DPH 20% 
<td class='ponuka' colspan='1'>  
<input type="checkbox" name="h_ajo" value="1" />
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Ak zaökrtnete, program pre˙Ëtuje 20% neodpoËÌtan˙ DPH na ˙Ëet nastaven˝ niûöie s DRD=10' >
<?php
if ( $ajo == 1 )
   {
?>
<script type="text/javascript">
document.enastpau.h_ajo.checked = "checked";
</script>
<?php
   }
?>
</td></tr>
<tr><td class='ponuka' colspan='4'>
⁄Ëet pre od˙Ëtovanie neodpoËÌtanej DPH 20% 
<td class='ponuka' colspan='1'>  
<input type='text' name='h_aju' id='h_aju' size='10' maxlenght='10' value='<?php echo $aju; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 54999... = ⁄Ëet pre pre˙Ëtovanie 20% neodpoËÌtanej DPH s DRD=10' >
</td></tr>
<tr><td class='ponuka' colspan='4'>
<td class='ponuka' colspan='1'>  
 <img border=0 src='../obr/ok.png' style="width:10; height:10;" onClick="NastavPau();" title='Uloû nastavenie' > Uloûiù
</td></tr>
</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function NastavPau()
                {
var udp = document.forms.enastpau.h_udp.value;
var adp = document.forms.enastpau.h_adp.value;
var uzk = document.forms.enastpau.h_uzk.value;
var azk = document.forms.enastpau.h_azk.value;
var ajo = 0;
if ( document.enastpau.h_ajo.checked ) { ajo=1; }
var aju = document.forms.enastpau.h_aju.value;

window.open('../ucto/fak_setulozpau.php?cislo_dok=<?php echo $cislo_dok; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&udp=' + udp + '&adp=' + adp + '&uzk=' + uzk + '&azk=' + azk + '&ajo=' + ajo + '&aju=' + aju + '&copern=901', '_self' );
                }

</script>
<?php
     }
?>


<?php
//text pred a za polozkami
if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 31 ) AND $sysx != 'UCT' )
     {
?>
<script type="text/javascript" src="spr_texty_xml.js"></script>
<?php
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_$tabl WHERE dok=$cislo_dok");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);

  $h_penp1=$riaddok->txp;
  $h_penz1=$riaddok->txz;
  }

?>
<div id="myTextElement" style="cursor: hand; display: none; position: absolute; z-index: 800; top: 190px; left: 20px; width:800px; height:200px;">
</div>

<div id="nastavtpx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 190px; left: 10px; width:800px; height:200px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='fhoddok' method='post' action='#' >
<td colspan='5'>Text Fakt˙ry - pred poloûkami
<input type='hidden' name='druh' id='druh' >
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onClick='UlozPenp();' title='Uloû zmeny v texte' >

</td>
<td colspan='5' align='right'>

<img border=0 src='../obr/zoznam.png' style='width:15px; height:15px;' onClick="myTextElement.style.display=''; DajTextp(1);" title='Vybraù text z ponuky' > &nbsp&nbsp&nbsp&nbsp
<img border=0 src='../obr/zmazuplne.png' style="width:15px; height:15px;" onClick="nastavtpx.style.display='none'; myTextElement.style.display='none';" title='Zhasni' >

</td></tr>  
                    
<tr><td colspan='10' class='obyc' align='left'>
<textarea name='h_penp' id='h_penp' rows='12' cols='118' ><?php echo $h_penp1; ?></textarea>
</td></tr>


</FORM></table>
</div>

<div id="nastavtzx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 190px; left: 10px; width:800px; height:200px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='fhoddoz' method='post' action='#' >
<td colspan='5'>Text Fakt˙ry - za poloûkami
<input type='hidden' name='druh' id='druh' >
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onClick='UlozPenz();' title='Uloû zmeny v texte' >

</td>
<td colspan='5' align='right'>

<img border=0 src='../obr/zoznam.png' style='width:15px; height:15px;' onClick="myTextElement.style.display=''; DajTextp(2);" title='Vybraù text z ponuky' > &nbsp&nbsp&nbsp&nbsp
<img border=0 src='../obr/zmazuplne.png' style="width:15px; height:15px;" onClick="nastavtzx.style.display='none'; myTextElement.style.display='none';" title='Zhasni' >

</td></tr>  
                    
<tr><td colspan='10' class='obyc' align='left'>
<textarea name='h_penz' id='h_penz' rows='12' cols='118' ><?php echo $h_penz1; ?></textarea>
</td></tr>


</FORM></table>
</div>

<script type="text/javascript">

function RozniPenp(druh)
                {
  nastavtpx.style.display='';
  document.forms.fhoddok.druh.value=1; 

                }

function RozniPenz(druh)
                {
  nastavtzx.style.display='';
  document.forms.fhoddok.druh.value=2; 

                }

function DajTextp(druh)
                {
  if( druh == 1 ) { DajText(1); }
  if( druh == 2 ) { DajText(2); }
                }


function UlozPenp()
                {
  nastavtpx.style.display='none';                

<?php if( $_SESSION['chrome'] == 0 ) { ?>
  var h_penpe = document.forms.fhoddok.h_penp.value.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
<?php                                } ?>
<?php if( $_SESSION['chrome'] == 1 ) { ?>
  var h_penpe = document.forms.fhoddok.h_penp.value.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
<?php                                } ?>

      var druh = document.forms.fhoddok.druh.value;
      if( druh == 1 ) { var copernx=2008; }
      if( druh == 2 ) { var copernx=2009; }

window.open('../faktury/vstf_u.php?regpok=<?php echo $regpok; ?>&h_penp=' + h_penpe + '&vyroba=0&copern='+ copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&h_tlsl=<?php echo $h_tlsl; ?>&h_tltv=<?php echo $h_tltv; ?>&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_fak=0&h_dol=0&h_prf=0', '_self' );

                }

function UlozPenz()
                {
  nastavtzx.style.display='none';                

<?php if( $_SESSION['chrome'] == 0 ) { ?>
  var h_penpe = document.forms.fhoddoz.h_penz.value.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
<?php                                } ?>
<?php if( $_SESSION['chrome'] == 1 ) { ?>
  var h_penpe = document.forms.fhoddoz.h_penz.value.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
<?php                                } ?>

      var druh = document.forms.fhoddok.druh.value;
      if( druh == 1 ) { var copernx=2008; }
      if( druh == 2 ) { var copernx=2009; }

window.open('../faktury/vstf_u.php?regpok=<?php echo $regpok; ?>&h_penp=' + h_penpe + '&vyroba=0&copern='+ copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&h_tlsl=<?php echo $h_tlsl; ?>&h_tltv=<?php echo $h_tltv; ?>&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_fak=0&h_dol=0&h_prf=0', '_self' );

                }

//co urobi po potvrdeni ok z tabulky textov
function vykonajText(druh, cpt)
                {

      if( druh == 1 ) { var copernx=3008; }
      if( druh == 2 ) { var copernx=3009; }

window.open('../faktury/vstf_u.php?regpok=<?php echo $regpok; ?>&cpt=' + cpt + '&vyroba=0&copern='+ copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&h_tlsl=<?php echo $h_tlsl; ?>&h_tltv=<?php echo $h_tltv; ?>&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_fak=0&h_dol=0&h_prf=0', '_self' );

                }

</script>
<?php
     }
//koniec texty pred a za polozkami
?>

<?php
//potvrdenie o vyvoze tovaru
if ( $copern == 7 AND $drupoh == 1 AND $sys == 'FAK' )
     {

?>
<div id="nastavpex" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='evnast' method='post' action='#' ><td colspan='5'>VytlaËiù potvrdenie o v˝voze tovaru</td>
<td colspan='5' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavpex.style.display='none';" title='Zhasni' ></td></tr>  
                    

<tr><td class='bmenu' colspan='5'>
<a href="#" onClick="UlozVyvoz(<?php echo $kli_uzid;?>,0 );"> Chcete uloûiù nastavenie potvrdenia ?</a></td> 
<td class='bmenu' colspan='5'>
<a href="#" onClick="UlozVyvoz(<?php echo $kli_uzid;?>,1 );"> Chcete vytlaËiù potvrdenie ?</a></td></tr> 

<tr><td colspan='10'>Odberateæ miesto podnikania ak je inÈ ako sÌdlo</td></tr> 
<tr><td colspan='10'><input type='text' name='h_ucm1' id='h_ucm1' size='80' maxlenght='80' value='' ></td></tr> 

<tr><td class='bmenu' colspan='10'> </td></tr>

<tr><td colspan='10'><input type='checkbox' name='zmd' value='1' > Dopravu vykonal dod·vateæ </td></tr>

<tr><td colspan='10'>Miesto prevzatia tovaru</td> 
<tr><td colspan='10'><input type='text' name='h_ucm2' id='h_ucm2' size='80' maxlenght='80' value='' ></td></tr> 

<tr><td colspan='10'> 
<input type='text' name='h_ico1' id='h_ico1' size='10' maxlenght='10' value='' > D·tum prevzatia tovaru</td></tr> 


<tr><td class='bmenu' colspan='10'> </td></tr>

<tr><td colspan='10'><input type='checkbox' name='zdl' value='1' > Dopravu vykonal odberateæ </td></tr>

<tr><td colspan='10'>Miesto skonËenia prepravy</td></tr> 
<tr><td  colspan='10'><input type='text' name='h_ucm3' id='h_ucm3' size='80' maxlenght='80' value='' ></td></tr> 

<tr><td colspan='10'> 
<input type='text' name='h_ico2' id='h_ico2' size='10' maxlenght='10' value='' > D·tum skonËenia prepravy</td></tr> 


<tr><td class='bmenu' colspan='10'> </td></tr>

<tr><td colspan='10'>Meno a priezvisko vodiËa 
<input type='text' name='h_ucm4' id='h_ucm4' size='40' maxlenght='40' value='' ></td></tr> 

<tr><td colspan='10'>EvidenËnÈ ËÌslo vozidla 
<input type='text' name='h_ucm5' id='h_ucm5' size='10' maxlenght='10' value='' ></td></tr> 


<tr><td colspan='10'><input type='hidden' name='h_ico3' id='h_ico3' >

<input type='hidden' name='h_ico4' id='h_ico4' > 

<input type='hidden' name='h_ico5' id='h_ico5' >
</td></tr>  

<tr><td colspan='10'>  
 <input type='hidden' name='omd' value='1' > <input type='hidden' name='odl' value='1' > 
 <input type='hidden' name='pmd' value='1' > <input type='hidden' name='pdl' value='1' > 
</tr>

</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function UlozVyvoz( premx, xxz )
                {
var doklad = document.forms.forms1.h_dok.value;

var ucm1 = document.forms.evnast.h_ucm1.value;
var ucm2 = document.forms.evnast.h_ucm2.value;
var ucm3 = document.forms.evnast.h_ucm3.value;
var ucm4 = document.forms.evnast.h_ucm4.value;
var ucm5 = document.forms.evnast.h_ucm5.value;
var ico1 = document.forms.evnast.h_ico1.value;
var ico2 = document.forms.evnast.h_ico2.value;
var ico3 = document.forms.evnast.h_ico3.value;
var ico4 = document.forms.evnast.h_ico4.value;
var ico5 = document.forms.evnast.h_ico5.value;
var premenna = premx;
var zmd = 0;
if( document.evnast.zmd.checked ) zmd=1;
var zdl = 0;
if( document.evnast.zdl.checked ) zdl=1;
var omd = 0;
if( document.evnast.omd.checked ) omd=1;
var odl = 0;
if( document.evnast.odl.checked ) odl=1;
var pmd = 0;
if( document.evnast.pmd.checked ) pmd=1;
var pdl = 0;
if( document.evnast.pdl.checked ) pdl=1;

if( xxz == 0 )
   {
window.open('vyvoz_setulozx.php?cislo_dok=' + doklad + '&h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&premenna=' + premenna + '&copern=900', '_self' );
   }
if( xxz == 1 )
   {
robotmenu.style.display='none';
window.open('vyvoz_setulozx.php?cislo_dok=' + doklad + '&h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&premenna=' + premenna + '&copern=900&tlac=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
   }
                }

</script>
<?php
     }
?>


<?php
if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 42 ) AND $sysx != 'UCT' )
     {
//nastavenie parametrov faktury a bankovych uctov pre fakturu

$jeodbucb=0;
$sqlttu = "SELECT * FROM F$kli_vxcf"."_fakodbucb WHERE dok = $cislo_dok ";
$sqldou = mysql_query("$sqlttu");
  if (@$zaznam=mysql_data_seek($sqldou,0))
  {
  $riaddou=mysql_fetch_object($sqldou);
  $jeodbucb=1;
  }

if( $jeodbucb == 0 )
          {

$sqltdef = <<<prsaldo
(
   dok         DECIMAL(10,0),
   u1f         DECIMAL(2,0),
   u2f         DECIMAL(2,0),
   u3f         DECIMAL(2,0)
);
prsaldo;

$vsql = "CREATE TABLE F".$kli_vxcf."_fakodbucb ".$sqltdef;
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_fakodbucb ( dok, u1f, u2f, u3f ) VALUES ('$cislo_dok', '$fir_uc1fk', '$fir_uc2fk', '$fir_uc3fk') ";
$vytvor = mysql_query("$vsql");

          }


$sqlttu = "SELECT * FROM F$kli_vxcf"."_fakodbucb WHERE dok = $cislo_dok ";
$sqldou = mysql_query("$sqlttu");
  if (@$zaznam=mysql_data_seek($sqldou,0))
  {
  $riaddou=mysql_fetch_object($sqldou);
  $fir_uc1fk=$riaddou->u1f;
  $fir_uc2fk=$riaddou->u2f;
  $fir_uc3fk=$riaddou->u3f;
  }

//koniec fir_uc1fk az fir_uc3fk z _fakodbucb ak existuje

$dokladico=0;
$sqlttu = "SELECT * FROM F$kli_vxcf"."_$tabl WHERE dok = $cislo_dok ";
$sqldou = mysql_query("$sqlttu");
  if (@$zaznam=mysql_data_seek($sqldou,0))
  {
  $riaddou=mysql_fetch_object($sqldou);
  $dokladico=1*$riaddou->ico;
  }

$defpercento=0; $jedefpercento=0;
$sqlttu = "SELECT * FROM F$kli_vxcf"."_icorozsirenie WHERE ico = $dokladico ";
$sqldou = mysql_query("$sqlttu");
  if (@$zaznam=mysql_data_seek($sqldou,0))
  {
  $riaddou=mysql_fetch_object($sqldou);
  $defpercento=1*$riaddou->pico2;
  }
if( $defpercento != 0 ) { $jedefpercento=1; }
?>
<div id="nastavfakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 300px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie fakt˙ry uzv(<?php echo $kli_uzid; ?>)</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavfakx.style.display='none';" title='Zhasni menu' ></td></tr>  
                    
<tr><FORM name='enast' method='post' action='#' ><td class='ponuka' colspan='5'>
<a href="#" onClick="NacitajPol(<?php echo $kli_uzid; ?>);"> Chcete uloûiù nastavenie fakt˙ry ?</a></td></tr>

<tr><td class='ponuka' colspan='1'><input type='checkbox' name='zmd' value='1' > PeËiatka  
<img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='PecSubor();' title='NaËÌtanie JPG s˙boru peËiatky' > 
<td class='ponuka' colspan='1'> öÌrka<input type='text' name='h_ucm1' id='h_ucm1' size='4' maxlenght='4' value='' > 
<td class='ponuka' colspan='1'> v˝öka<input type='text' name='h_ucm2' id='h_ucm2' size='4' maxlenght='4' value='' ></td>
<td class='ponuka' colspan='1'> zæava<input type='text' name='h_ucm3' id='h_ucm3' size='4' maxlenght='4' value='' ></td>
<td class='ponuka' colspan='1'> zhora<input type='text' name='h_ucm4' id='h_ucm4' size='4' maxlenght='4' value='' ></td>
</tr>

<tr><td class='ponuka' colspan='1'><input type='checkbox' name='zdl' value='1' > Logo  
<img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='LogoSubor();' title='NaËÌtanie JPG s˙boru loga' > 
<td class='ponuka' colspan='1'> öÌrka<input type='text' name='h_ico1' id='h_ico1' size='4' maxlenght='4' value='' > 
<td class='ponuka' colspan='1'> v˝öka<input type='text' name='h_ico2' id='h_ico2' size='4' maxlenght='4' value='' >
<td class='ponuka' colspan='1'> zæava<input type='text' name='h_ico3' id='h_ico3' size='4' maxlenght='4' value='' >
<td class='ponuka' colspan='1'> zhora<input type='text' name='h_ico4' id='h_ico4' size='4' maxlenght='4' value='' >
</tr>

<tr><td class='ponuka' colspan='5'> 
maxim·lny poËet znakov v n·zve poloûky <input type='text' name='h_ucm5' id='h_ucm5' size='4' maxlenght='4' value='' >(minim·lne 40 znakov, max.80 znakov) 
</tr>

<tr><td class='ponuka' colspan='4'> 
Zæava % <input type='text' name='h_ico5' id='h_ico5' size='4' maxlenght='4' value='' >
<?php if( $jedefpercento == 1 ) { echo " *** "; } ?>
<a href="#" onClick="ZlavaPol(<?php echo $kli_uzid; ?>);"> VypoËÌtaù zæavu z fakt˙ry</a></td>
<td class='ponuka' colspan='1' align="right"> 
<img border=0 src='../obr/ok.png' style='width:12px; height:12px;' onClick='IcoZlava();' title='Uloûiù percento zæavy pre I∆O <?php echo $riadok->ico;?> ako defaultnÈ percento' > </td>
</tr>  

<tr><td class='ponuka' colspan='5'> | Text nad poloûkou <input type='checkbox' name='omd' value='1' > / pod poloûkou <input type='checkbox' name='pdl' value='1' >
 | zahraniËn· fakt˙ra <input type='checkbox' name='odl' value='1' > </td></tr>
<tr><td class='ponuka' colspan='5'> | Text za (pred rozpisom DPH) <input type='checkbox' name='pmd' value='1' > 
</td></tr> 
<?php
$fir_uc1xx=substr($fir_fib1,0,8);
$fir_uc2xx=substr($fir_fib2,0,8);
$fir_uc3xx=substr($fir_fib3,0,8);
?>
<tr><td class='ponuka' colspan='5'> banka uËet 1 <input type='checkbox' name='u1f' value='1' > <?php echo $fir_uc1xx; ?>...
 | uËet 2 <input type='checkbox' name='u2f' value='1' > <?php echo $fir_uc2xx; ?>... 
 | uËet 3 <input type='checkbox' name='u3f' value='1' > <?php echo $fir_uc3xx; ?>...</td>
</tr> 

</FORM></table>
</div>
<script type="text/javascript">
//uloz subor
function LogoSubor()
                {
window.open('../cis/ulozhlavicku.php?copern=998&drupoh=1&page=1','_blank');
                }

function PecSubor()
                {
window.open('../cis/ulozhlavicku.php?copern=997&drupoh=1&page=1','_blank');
                }

//zapis nastavenie
function NacitajPol( premx )
                {
var doklad = document.forms.forms1.h_dok.value;

var ucm1 = document.forms.enast.h_ucm1.value;
var ucm2 = document.forms.enast.h_ucm2.value;
var ucm3 = document.forms.enast.h_ucm3.value;
var ucm4 = document.forms.enast.h_ucm4.value;
var ucm5 = document.forms.enast.h_ucm5.value;
var ico1 = document.forms.enast.h_ico1.value;
var ico2 = document.forms.enast.h_ico2.value;
var ico3 = document.forms.enast.h_ico3.value;
var ico4 = document.forms.enast.h_ico4.value;
var ico5 = document.forms.enast.h_ico5.value;
var premenna = premx;
var zmd = 0;
if( document.enast.zmd.checked ) zmd=1;
var zdl = 0;
if( document.enast.zdl.checked ) zdl=1;
var omd = 0;
if( document.enast.omd.checked ) omd=1;
var odl = 0;
if( document.enast.odl.checked ) odl=1;
var pmd = 0;
if( document.enast.pmd.checked ) pmd=1;
var pdl = 0;
if( document.enast.pdl.checked ) pdl=1;
var u1f = 0;
if( document.enast.u1f.checked ) u1f=1;
var u2f = 0;
if( document.enast.u2f.checked ) u2f=1;
var u3f = 0;
if( document.enast.u3f.checked ) u3f=1;

window.open('fak_setuloz.php?drupoh=<?php echo $drupoh; ?>&jedefpercento=0&u1f=' + u1f + '&u2f=' + u2f + '&u3f=' + u3f + '&cislo_dok=' + doklad + '&h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&premenna=' + premenna + '&copern=900', '_self' );
                }

//zlava
function ZlavaPol( premx )
                {
var doklad = document.forms.forms1.h_dok.value;

var ucm1 = document.forms.enast.h_ucm1.value;
var ucm2 = document.forms.enast.h_ucm2.value;
var ucm3 = document.forms.enast.h_ucm3.value;
var ucm4 = document.forms.enast.h_ucm4.value;
var ucm5 = document.forms.enast.h_ucm5.value;
var ico1 = document.forms.enast.h_ico1.value;
var ico2 = document.forms.enast.h_ico2.value;
var ico3 = document.forms.enast.h_ico3.value;
var ico4 = document.forms.enast.h_ico4.value;
var ico5 = document.forms.enast.h_ico5.value;
var premenna = premx;
var zmd = 0;
if( document.enast.zmd.checked ) zmd=1;
var zdl = 0;
if( document.enast.zdl.checked ) zdl=1;
var omd = 0;
if( document.enast.omd.checked ) omd=1;
var odl = 0;
if( document.enast.odl.checked ) odl=1;
var pmd = 0;
if( document.enast.pmd.checked ) pmd=1;
var pdl = 0;
if( document.enast.pdl.checked ) pdl=1;

window.open('fak_setuloz.php?drupoh=<?php echo $drupoh; ?>&jedefpercento=<?php echo $jedefpercento; ?>&cislo_dok=' + doklad + '&h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&premenna=' + premenna + '&copern=900&zlava=1', '_self' );
                }

//zapis percento zlavy ako default pre ico
function IcoZlava()
                {
var doklad = document.forms.forms1.h_dok.value;
var ico5 = document.forms.enast.h_ico5.value;

window.open('fak_setuloz.php?drupoh=<?php echo $drupoh; ?>&icox=<?php echo $dokladico;?>&cislo_dok=' + doklad + '&ico5=' + ico5 + '&copern=600&zlava=0', '_self' );
                }

function SetIcoZlava()
                {
<?php
if( $defpercento != 0 ) 
  {
?>
document.forms.enast.h_ico5.value="<?php echo $defpercento;?>";
<?php
  }
?>
                }

</script>
<?php
     }
?>

<?php
//nastavenie datumu do kvdph
if ( $copern == 7 AND $drupoh == 2 AND $sysx == 'UCT' )
     {
$dak = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dak_sk=SkDatum($dak);

$dak_set="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakturasetdak WHERE dok = $cislo_dok ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dak_set=SkDatum($riaddok->dak);
  }
if( $dak_set != '' AND $dak_set != '00.00.0000' ) { $dak_sk=$dak_set; }
?>
<div id="nastavdakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie d·tumu zaradenia fakt˙ry do KV DPH</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavdakx.style.display='none';" title='Zhasni' ></td></tr>  
                    
<tr><FORM name='enastdak' method='post' action='#' >
<td class='ponuka' colspan='5'> 
 D·tum zaradenia do KV DPH <input type='text' name='h_dak' id='h_dak' size='10' maxlenght='10' value='<?php echo $dak_sk; ?>' >
 <img border=0 src='../obr/ok.png' style="width:10; height:10;" onClick="NacitajDak();" title='Uloû d·tum zaradenia do KV DPH' >
</td></tr> 
</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function NacitajDak()
                {
var dak = document.forms.enastdak.h_dak.value;

window.open('fak_setulozdak.php?cislo_dok=<?php echo $cislo_dok; ?>&dak=' + dak + '&copern=900', '_self' );
                }

</script>
<?php
     }
?>

<?php
//nastavenie datumu do kvdph
if ( $copern == 7 AND $sysx == 'UCT' )
     {
$textdpp=0;
$sqldpp = mysql_query("SELECT * FROM F".$kli_vxcf."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 1 ");
  if (@$zaznam=mysql_data_seek($sqldpp,0))
  {
  $riadokdpp=mysql_fetch_object($sqldpp);
  $textdpp=$riadokdpp->dppx;
  }
?>
<div id="nastavdppx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie OdpoËtu a uplatnenia DPH aû po prijatÌ platby</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavdppx.style.display='none';" title='Zhasni' ></td></tr>  
                    
<tr><FORM name='enastdpp' method='post' action='#' >
<td class='ponuka' colspan='5'> 
 OdpoËet a uplatnenie DPH aû po prijatÌ platby <input type="checkbox" name="dppx" value="1" />
 <img border=0 src='../obr/ok.png' style="width:10; height:10;" onClick="NacitajDpp();" title='Uloû nastavenie OdpoËtu a uplatnenia DPH aû po prijatÌ platby' > 
<?php if ( $textdpp == 1 )       { ?>
 <script type="text/javascript">document.enastdpp.dppx.checked = "checked";</script>
<?php                            } ?>
</td></tr> 
</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function NacitajDpp()
                {
var dppx = 0;
if( document.enastdpp.dppx.checked ) dppx=1;

window.open('fak_setulozdpp.php?cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>&dppx=' + dppx + '&copern=900', '_self' );
                }

</script>
<?php
     }
?>

<?php
//nastavenie cudzej meny na doklade
//echo $copern;
if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 ) )
     {
?>
<div id="nastavmenax" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 180px; left: 10px; width:800px; height:100px;">
<table  class='ponuka' width='100%'><tr><FORM name='fmena1' class='obyc' method='post' action='#' >

<td width='20%'>Cudzia mena:
<?php

$sqlttt = "SELECT dat,kurz,mena,hodm,dok FROM F$kli_vxcf"."_$tabl WHERE dok = $cislo_dok";
$sql = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datum=$riadok->dat;
  $kurz1=$riadok->kurz;
  $mena1=$riadok->mena;
  $hodm1=1*$riadok->hodm;
  }

$sqlttt = "SELECT pomr FROM F$kli_vxcf"."_uctkurzy WHERE mena = '$mena1' ";
$sql = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $pomer1=1*$riadok->pomr;
  }

//echo $sqlttt;

$sqtt = "SELECT * FROM F$kli_vxcf"."_uctmeny LEFT JOIN F$kli_vxcf"."_uctkurzy".
" ON F$kli_vxcf"."_uctmeny.mena=F$kli_vxcf"."_uctkurzy.mena".
" WHERE datk <= '$datum' ORDER BY datk DESC,F$kli_vxcf"."_uctmeny.mena LIMIT 25";

$sqls = mysql_query("$sqtt");

$i=0;
?>
<select class='hvstup' size='1' name='h_menax' id='h_menax' onchange="nastavKURZ();" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam['mena'];?>|<?php echo $zaznam['pomr'];?>|<?php echo $zaznam['kurz'];?>" >
<?php echo SkDatum($zaznam['datk']);?> <?php echo $zaznam['mena'];?> <?php echo $zaznam['kurz'];?></option>
<?php if( $i == 0 ) { $mena=$zaznam['mena']; $pomr=$zaznam['pomr']; $kurz=$zaznam['kurz']; } $i=$i+1; endwhile;?>
</select>
</td>

<td width='12%'>Mena:
<input type='text' name='h_mena' id='h_mena' size='5' readonly="readonly" /> 
</td>

<td width='12%'>Pomer:
<input type='text' name='h_pomr' id='h_pomr' size='5' value="" 
onchange='return intg(this,1,1000,Cele)' onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cele)" /> 
</td>

<td width='12%'>Kurz:
<input type='text' name='h_kurz' id='h_kurz' size='5' onchange='return cele(this,0,99999999,Desc,4,document.fmena1.err_kurz)' 
onkeyup="KontrolaDcisla(this, Desc)" value="" /> 
<INPUT type='hidden' name='err_kurz' value="0">
</td>

<td width='12%'>Hodnota:
<input type='text' name='h_hodm' id='h_hodm' size='5' onchange='return cele(this,0,99999999,Desc,2,document.fmena1.err_hodm)' 
onkeyup="KontrolaDcisla(this, Desc)" value="" /> 
<INPUT type='hidden' name='err_hodm' value="0">
</td>

<?php $ulozdru=1*1000+$drupoh; ?>
<?php if( $pocstav == 1 ) { $ulozdru=$ulozdru+4000; } ?>

<td width='12%'>
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onclick='ulozMENU(<?php echo $ulozdru;?>);' title='Uloûiù' >
</td>


<td width='48%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15px; height:15px;'
onClick="nastavmenax.style.display='none';" title='Zhasni v˝ber meny' ></td></FORM></tr> 
</table>
</div>
<script type="text/javascript">

//cudzia mena


    function nacitajKURZ()
    {

    document.fmena1.h_mena.value = "<?php echo $mena1;?>";
    document.fmena1.h_kurz.value = "<?php echo $kurz1;?>";
    document.fmena1.h_hodm.value = "<?php echo $hodm1;?>";
    document.fmena1.h_pomr.value = "<?php echo $pomer1;?>";
    document.fmena1.h_menax.value = "<?php echo $mena1."|".$pomer1."|".$kurz1;?>";
    document.fmena1.h_menax.focus();
    }

    function nastavKURZ()
    {

    var h_kurzx = document.fmena1.h_menax.value;
    var hxx = h_kurzx.split("|");
    document.fmena1.h_mena.value = hxx[0];
    document.fmena1.h_pomr.value = hxx[1];
    document.fmena1.h_kurz.value = hxx[2];
    document.fmena1.h_hodm.select();
    document.fmena1.h_hodm.focus();


    }


</script>
<?php
     }
?>

<div id="textpenp" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>

<div id="robothlas" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 150; left: 90; width:200; height:100;">
zobrazeny vysledok
</div>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 200; left: 40; ">
<img border=0 src='../obr/robot/robot3.jpg' style='width:40; height:80;' onClick="zobraz_robotmenu();"
 alt='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' title='Zhasni EkoRobota' >
</div>

<table class="h2" width="100%" >
<tr>
<?php if( $drupoh == 1 ) echo "<td>EuroSecom  -  OdberateæskÈ fakt˙ry"; ?>
<?php if( $drupoh == 31 ) echo "<td>EuroSecom  -  OdberateæskÈ fakt˙ry"; ?>
<?php if( $drupoh == 11 ) echo "<td>EuroSecom  -  Dodacie listy"; ?>
<?php if( $drupoh == 12 ) echo "<td>EuroSecom  -  Dodacie listy"; ?>
<?php if( $drupoh == 21 ) echo "<td>EuroSecom  -  Vn˙tropod.fakt˙ry"; ?>
<?php if( $drupoh == 22 ) echo "<td>EuroSecom  -  Vn˙tropod.fakt˙ry"; ?>
<?php if( $drupoh == 42 ) echo "<td>EuroSecom  -  RegistraËn· pokladnica"; ?>
<?php if( $drupoh == 52 ) echo "<td>EuroSecom  -  Predfakt˙ry"; ?>
<?php if( $drupoh == 2 ) echo "<td>EuroSecom  -  Dod·vateæskÈ fakt˙ry"; ?>
<?php if( $pocstav == 1 ) echo " - PS"; ?>
 <img src='../obr/info.png' width=12 height=12 border=0 alt="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
<?php
if ( $copern == 5 ) echo " - nov˝ doklad";
?>
<?php
if ( $copern == 6 ) echo " - vymazanie dokladu";
?>
<?php
if ( $copern == 7 OR $copern == 17 ) echo " - sluûby";
?>
<?php
if ( $copern == 87 OR $copern == 97 ) echo " - ˙prava sluûby";
?>
<?php
if ( $copern == 8 ) echo " - ˙prava dokladu";
?>
</td>
<td align="right">
<a href="#" title="Pre spr·vne vytvorenie KontrolnÈho v˝kazu DPH je dÙleûitÈ aby ste mali v ËÌselnÌku I»O spr·vne I» DPH !!!" onclick="OverIcdph();" >Overovanie I» DPH</a>
<span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 
$peciatkaano=0;
$maxtextpol=40;
$textnadpol=0;
$textpodpol=0;
$zahranicna=0;
if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $maxtextpol=80; }
if ( ( $copern == 7 OR $copern == 87 ) AND ( $drupoh == 1 OR $drupoh == 11 ) AND $sysx != 'UCT' ) {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_fakturaset$kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $peciatkaano=1*$riaddok->zmd;
  $maxtextpol=1*$riaddok->ucm5;
  $textnadpol=1*$riaddok->omd;
  $zahranicna=1*$riaddok->odl;
//echo "maxtextpol".$maxtextpol;
  }
if( $maxtextpol > 40 ) { $maxtextpol=80; }
if( $longslu == 1 ) { $maxtextpol=100; }
//if( $kli_uzid == 17 ) { echo "maxtextpol".$maxtextpol; }
                                                       }
//nova faktura
//[[[[[[[5555555555[[[[[[[[[888888888888
if ( $copern == 5 OR $copern == 8 )
     {

?>
<span style="position: absolute; top: 150; left: 50%;"> 
<div id="myOdbmElement"></div>
</span>
<span style="position: absolute; top: 150; left: 50%;"> 
<div id="myIcoElement"></div>
</span>
<span style="position: absolute; top: 238; left: 50%;"> 
<div id="myStrelement"></div>
</span>
<span style="position: absolute; top: 238; left: 50%;"> 
<div id="myZakelement"></div>
</span>

<span id="NiejeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som stredisko v ËÌselnÌku </span>
<span id="NiejeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som z·kazku v ËÌselnÌku </span>
<div id="jeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>

<table class="vstup" width="50%" height="170px" align="left">
<tr></tr><tr></tr>
<FORM name="fhlv1" class="obyc" method="post" action="vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $newdok;?>&hladaj_uce=<?php echo $hladaj_uce;?>
<?php
if ( $copern == 5 )
     {
?>
&copern=68" >
<?php
     }
?>
<?php
if ( $copern == 8 )
     {
?>
&copern=78" >
<?php
     }
?>
<tr><td class="pvstup">&nbsp;⁄Ëet:
<a href='vstf_s.php?copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Uloûenie origin·lu dokladu do datab·zy" title="Uloûenie origin·lu dokladu do datab·zy" ></a>
</td>
<?php
if( $drupoh == 1 )
{
$sqls = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 1 ) ORDER BY dodb");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 31 )
{
$sqls = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 11 ) ORDER BY dodb");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 11 )
{
$sqls = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 2 ) ORDER BY dodb");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 12 )
{
$sqls = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 12 ) ORDER BY dodb");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 21 )
{
$sqls = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 3 ) ORDER BY dodb");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 22 )
{
$sqls = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 13 ) ORDER BY dodb");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 42 )
{
$sqls = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 9 ) ORDER BY dpok");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dpok"];?>" >
<?php 
$polmen = $zaznam["npok"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dpok"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 52 )
{
$sqls = mysql_query("SELECT dodb,nodb FROM F$kli_vxcf"."_dodb WHERE ( drod = 14 ) ORDER BY dodb");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dodb"];?>" >
<?php 
$polmen = $zaznam["nodb"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dodb"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
<?php
if( $drupoh == 2 )
{
$sqls = mysql_query("SELECT ddod,ndod FROM F$kli_vxcf"."_ddod WHERE ( drdo = 1 ) ORDER BY ddod");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_uce" id="h_uce" onmouseover="HlvOnClick()" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["ddod"];?>" >
<?php 
$polmen = $zaznam["ndod"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["ddod"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>
</tr>

<tr>
<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 21 OR $drupoh == 31 OR $drupoh == 22 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / fakt˙ry <?php if( $ajvsy == 1 ) { echo "/ VSY"; } ?>:</td>
<?php
}
?>
<?php
if( $drupoh == 42 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / ËÌslo v dni:</td>
<?php
}
?>
<?php
if( $drupoh == 11 OR $drupoh == 12 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / dod.listu:</td>
<?php
}
?>
<?php
if( $drupoh == 52 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / predFakt:</td>
<?php
}
?>

<td class="hvstup" width="25%" >
<input class="hvstup" type="text" name="nwwdok" id="nwwdok" size="10" value="<?php echo $newdok;?>" onclick="HlvOnClick()"
 onchange="return intg(this,1,9999999999,Jx,document.fhlv1.err_fak)" onkeyup="KontrolaCisla(this, Jx)"
 onKeyDown="return NwwdokEnter(event.which)"  />

<?php if( $ajvsy == 0 ) { ?>
<input class="hvstup" type="hidden" name="h_sz3" id="h_sz3" />
<?php                   } ?>
<?php if( $ajvsy == 1 ) { ?>
<input class="hvstup" type="text" name="h_sz3" id="h_sz3" size="14" maxlength="30" value="<?php echo $h_fak;?>"
 onclick="HlvOnClick()" onKeyDown="return Sz3Enter(event.which)" />
<?php                   } ?>

<input class="hvstup" type="text" name="h_fak" id="h_fak" size="10" maxlength="10" value="<?php echo $h_fak;?>"
 onclick="HlvOnClick()" onfocus="onFak();"
 onchange="return intg(this,1,9999999999,Jx,document.fhlv1.err_fak)" onkeyup="KontrolaCisla(this, Jx)" 
 onKeyDown="return FakEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_fak" value="0">
<input class="hvstup" type="hidden" name="newdok" id="newdok" value="<?php echo $newdok;?>" />
<input class="hvstup" type="hidden" name="h_dok" id="h_dok" value="<?php echo $newdok;?>" />

<input class="hvstup" type="hidden" name="kdefoc" id="kdefoc" value="uce" />
<input class="hvstup" type="hidden" name="klikenter" id="klikenter" value="0" />
</td>
<td class="bmenu" width="10%" >
<?php
if ( $copern == 7 )
     {
?>
<?php if( $tlaclenpdf == 0 AND $drupoh != 42 )  { ?>
<a href="#" onClick="window.open('vstf_t.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="VytlaËiù doklad" title="VytlaËiù doklad" >TlaËiù</a>
<?php                                                  } ?>
<?php if( $drupoh == 42 )                              { ?>
<a href="#" onClick="window.open('../doprava/regpok_pdf.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&sysx=<?php echo $sysx;?>
&cislo_dok=<?php echo $riadok->dok;?>&regpok=<?php echo $regpok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho dokladu " >TlaËiù</a>
<?php                                                  } ?>

<?php if( $tlaclenpdf == 1 AND $drupoh != 42 )  { ?>
<a href="#" onClick="TlacPdf();">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="VytlaËiù doklad" title="VytlaËiù doklad PDF" >TlaËiù</a>
<?php                                                  } ?>
<?php
     }
?>
</td>
</tr>
<tr><td class="pvstup" >&nbsp;D·tum vyhotovenia:</td>
<td class="hvstup">
<input class="hvstup" type="text" name="h_dat" id="h_dat" size="10" maxlength="10" value="<?php echo $h_dat;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)" onfocus="onDat(); OnfocusDat();"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_dat)" onKeyDown="return DatEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dat" value="0">
</td>
</tr>
<?php if( $drupoh != 2 ) { ?>
<tr><td class="pvstup" >&nbsp;D·tum dodania:</td>
<td class="hvstup">
<input class="hvstup" type="text" name="h_daz" id="h_daz" size="10" maxlength="10" value="<?php echo $h_daz;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)"  onfocus="onDaz(); OnfocusDaz()"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_daz)" onKeyDown="return DazEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_daz" value="0">
</td>
</tr>
<?php                    } ?>
<?php if( $drupoh == 2 ) { ?>
<tr><td class="pvstup" >&nbsp;D·tum dodania - odpoËtu:</td>
<td class="hvstup">
<input class="hvstup" type="text" name="h_dao" id="h_dao" size="10" maxlength="10" value="<?php echo $h_dao;?>"
 onkeyup="KontrolaDatum(this, Kx)" onfocus="OnfocusDao()"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_daz)" onKeyDown="return DaoEnter(event.which)" />
 - 
<input class="hvstup" type="text" name="h_daz" id="h_daz" size="10" maxlength="10" value="<?php echo $h_daz;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)"  onfocus="onDaz(); OnfocusDaz()"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_daz)" onKeyDown="return DazEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_daz" value="0">
</td>
</tr>
<?php                    } ?>

<tr><td class="pvstup" >&nbsp;D·tum splatnosti:</td>
<td class="hvstup">
<input class="hvstup" type="text" name="h_das" id="h_das" size="10" maxlength="10" value="<?php echo $h_das;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)" onfocus="onDas(); OnfocusDas()"
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_das)" onKeyDown="return DasEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_das" value="0">
<input class="hvstup" type="text" name="h_dns" id="h_dns" value="" size="2" maxlength="3">
<input class="hvstup" type="hidden" name="h_spl" id="h_spl" value="" size="2" maxlength="3">
</td>
</tr>

<tr><td class="pvstup" >&nbsp;Objedn·vka - UNIkÛd:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_obj" id="h_obj" size="15" maxlength="15" value="<?php echo $h_obj;?>" onclick="HlvOnClick()"
 onKeyDown="return ObjEnter(event.which)"  onfocus="onObj();" />
<?php
$h_unkcheck=1*$cislo_unk;

$unkcheck=0;
if( $fir_fico == 46614478 AND $drupoh == 11 ) { $unkcheck=1; }
if( $unkcheck == 0 )
  {
?>
<input class="hvstup" type="text" name="h_unk" id="h_unk" size="15" maxlength="15" value="<?php echo $h_unk;?>" onclick="HlvOnClick()"
 onKeyDown="return UnkEnter(event.which)"  onfocus="onUnk();"/>
<?php
  }
?>
<?php
if( $unkcheck == 1 )
  {
?>
<input type="checkbox" name="h_unkcheck" id="h_unkcheck" value="1" /> NEVYSPORIADAN›
<input class="hvstup" type="hidden" id="h_unk" name="h_unk" value="<?php echo $h_unk;?>">
<?php
if ( $h_unkcheck == 1 )
 {
?>
<script type="text/javascript">
document.fhlv1.h_unkcheck.checked = "checked";
</script>
<?php
 }
?> 
<?php
  }
?>
<input class="hvstup" type="hidden" name="err_unk" value="0">
<input class="hvstup" type="hidden" name="uctovat" value="0">
</td>
<?php
if( $copern != 5 )
{
?>
<td>
<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=7&drupoh=<?php echo $drupoh;?>&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>'>
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="⁄prava poloûiek dokladu, neuloûÌ zmeny v z·hlavÌ , pre uloûenie ˙prav pouûite tlaËÌtko Sluûby alebo Tovar" >Poloûky</a>
</td>
<?php
}
?>
</tr>
<tr></tr><tr></tr>
</table>
<table class="vstup" width="50%" height="170px" align="left">
<tr></tr><tr></tr>
<tr><td class="pvstup" width="15%" >&nbsp;<?php echo $Odberatel; ?> I»O:
<?php
if( $copern == 5 )
{
?>
<img src='../obr/ziarovka.png' border="1" onclick="newIco();" width="12" hight="12" title="Vloûiù novÈ I»O do datab·zy" >
<?php
}
?>
<?php
if( $copern != 5 AND $copern != 6 )
{
?>
<img src='../obr/ziarovka.png' border="1" onclick="newIco();" width="12" hight="12" title="Vloûiù novÈ I»O do datab·zy" >
<?php
}
?>
</td>
<td class="hvstup" width="25%" >
<input class="hvstup" type="text" name="h_ico" id="h_ico" size="12" maxlength="8" value="<?php echo $h_ico;?>"
 onclick="Fxh.style.display='none'; document.fhlv1.h_nai.disabled = false; myIcoElement.style.display='none'; nulujIco(); myOdbmElement.style.display='none';"
 onchange="return intg(this,1,99999999,Ix,document.fhlv1.err_ico)" onkeyup="KontrolaCisla(this, Ix)" 
 onKeyDown="return IcoEnter(event.which)" onfocus="onIco();" />

<img src='../obr/hladaj.png' border="1" onclick="myIcoElement.style.display=''; myOdbmElement.style.display='none'; volajIco();" alt="Hæadaj zadanÈ I»O alebo n·zov firmy" >

iËdph <input class="hvstup" type="text" name="h_icd" id="h_icd" size="14" disabled="disabled">

<input class="hvstup" type="hidden" name="err_ico" value="0">

</td>
<td class="pvstup" width="10%" >
<?php
if ( ( $copern == 8 OR $copern == 5 ) AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) )
     {
?>

<img src='../obr/zoznam.png' border="0" alt="Vybraù odbernÈ miesto" title="Vybraù odbernÈ miesto" onclick="myOdbmElement.style.display=''; vyberODBM();" >
<input class="bvstup" type="text" name="h_odbm" id="h_odbm" size="5" maxlength="8" value="<?php echo $cislo_odbm;?>" />
<?php
     }
?>
</td>
</tr>
<tr><td class="pvstup" >&nbsp;<?php echo $Odberatel; ?> N·zov:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_nai" id="h_nai" size="30" value="<?php echo $h_nai;?>"
 onKeyDown="return NaiEnter(event.which)" onfocus="onNai();" 
 onclick="Fxh.style.display='none'; myIcoElement.style.display='none'; myOdbmElement.style.display='none'; nulujIco();"/>
</td>
<td class="bmenu" width="10%" >
<?php
if ( ( $copern == 7 AND $drupoh == 1 ) OR ( $copern == 7 AND $drupoh == 31 ) )
     {
?>
<img src='../obr/pdf.png' width=15 height=12 border=0 title="Vytvoriù doklad PDF" onClick="TlacPdf();" > PDF
<?php
     }

?>
</td>
</tr>

<tr>
<td class="pvstup">&nbsp;STR - Z¡K:</td>
<td class="hvstup" >
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù stredisko" title="Hæadaù stredisko" onClick="volajStr(0,1);" >
<input class="hvstup" type="text" name="h_str" id="h_str" size="7" 
 onclick="myStrelement.style.display='none';" onfocus="onStr();"
 onchange="return intg(this,0,9999,Str,document.fhlv1.err_str)"
 onkeyup="KontrolaCisla(this, Str)" onKeyDown="return StrEnter(event.which)"/>
<INPUT type="hidden" name="err_str" value="0">

<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù z·kazku" title="Hæadaù z·kazku" onClick="myZakelement.style.display=''; volajZak(0,1);" >
<input class="hvstup" type="text" name="h_zak" id="h_zak" size="7" 
 onclick="myZakelement.style.display='none';" onfocus="onZak();"
 onchange="return intg(this,0,9999999,Zak,document.fhlv1.err_zak)"
 onkeyup="KontrolaCisla(this, Zak)" onKeyDown="return ZakEnter(event.which)"/>
<INPUT type="hidden" name="err_zak" value="0">

</td>
</tr>
<tr><td class="pvstup" >&nbsp;Symbol KSY - SSY:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_ksy" id="h_ksy" size="6" maxlength="4" value="<?php echo $h_ksy;?>" onclick="HlvOnClick()"
onchange="return intg(this,0,9999,Lx,document.fhlv1.err_ksy)" onkeyup="KontrolaCisla(this, Lx)" 
 onKeyDown="return KsyEnter(event.which)"  onfocus="onKsy();"/>
<input class="hvstup" type="hidden" name="err_ksy" value="0">
<input class="hvstup" type="text" name="h_ssy" id="h_ssy" size="8" maxlength="7" value="<?php echo $h_ssy;?>" onclick="HlvOnClick()"
onchange="return intg(this,0,9999999999,Mx,document.fhlv1.err_ssy)" onkeyup="KontrolaCisla(this, Mx)" 
 onKeyDown="return SsyEnter(event.which)"  onfocus="onSsy();"/>
<input class="hvstup" type="hidden" name="err_ssy" value="0">
 Oprav.fakt˙ra <input class="hvstup" type="text" name="h_dav" id="h_dav" size="14" maxlength="20" value="<?php echo $cislo_dav;?>" />
</td>
</tr>

<tr>
<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 21 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 )
{
?>
<td class="pvstup" >&nbsp;Dod.list - predFakt:</td>
<?php
}
?>
<?php
if( $drupoh == 11 OR $drupoh == 12 )
{
?>
<td class="pvstup" >&nbsp;Fakt˙ra - predFakt:</td>
<?php
}
?>
<?php
if( $drupoh == 52 )
{
?>
<td class="pvstup" >&nbsp;Fakt˙ra - Dod.list:</td>
<?php
}
?>

<td class="hvstup" >
<input class="hvstup" type="text" name="h_dol" id="h_dol" size="10" maxlength="10" value="<?php echo $h_dol;?>" onclick="HlvOnClick()"
onchange="return intg(this,0,9999999999,Jx,document.fhlv1.err_dol)" onkeyup="KontrolaCisla(this, Jx)" 
 onKeyDown="return DolEnter(event.which)" onfocus="onDol();"/>
<input class="hvstup" type="hidden" name="err_dol" value="0">
<input class="hvstup" type="text" name="h_prf" id="h_prf" size="10" maxlength="10" value="<?php echo $h_prf;?>" onclick="HlvOnClick()"
onchange="return intg(this,0,9999999999,Jx,document.fhlv1.err_prf)" onkeyup="KontrolaCisla(this, Jx)" 
 onKeyDown="return PrfEnter(event.which)" onfocus="onPrf();"/>
<input class="hvstup" type="hidden" name="err_prf" value="0">
</td>
</tr>
<tr><td class="pvstup" >&nbsp;Doprava:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_dpr" id="h_dpr" size="20" maxlength="20" value="<?php echo $h_dpr;?>" onclick="HlvOnClick()"
 onKeyDown="return DprEnter(event.which)" onfocus="onDpr();"/>
</td>
</tr>

<?php
//$vstf_h = include("vstf_h.php");
?>

<tr></tr><tr></tr>
</table>

<br clear=left>
<tr>
<span id="Str" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Stredisko ???</span>
<span id="Zak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Z·kazka ???</span>
<span id="Fxh" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo max. 2 desatinnÈ miesta</span>
<span id="Ix" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O dod·vateæa musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Jx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo fakt˙ry,predfakt˙ry,dod.listu musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Lx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Konötantn˝ symbol musÌ byù celÈ ËÌslo v rozsahu 0 aû 9999</span>
<span id="Mx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 äpecifick˝ symbol musÌ byù celÈ ËÌslo v rozsahu 0 aû 9999999999</span>
<span id="Kx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Uph" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Z·hlavie DOK=<?php echo $cislo_dok;?> upravenÈ</span>
<div id="Okno"></div>
</tr>

<?php
if( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 OR $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
{
?>
<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="15%" >
<?php if( $itstablet == 1 )     {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko' >
<?php                           }  ?>
</td>
<td class="pvstup" width="10%" >
<?php
if( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 21 )
     {
?>
<?php
if( $fir_xfa01 == 1 )
{
?>
<input type="checkbox" name="h_tlsl" id="h_tlsl" value="1" checked="checked" />
<?php
}
?>
<?php
if( $fir_xfa01 != 1 )
{
?>
<input type="checkbox" name="h_tlsl" id="h_tlsl" value="1"  />
<?php
}
?>
<input type="submit" id="sluzby" name="sluzby" value="Sluûby"  
 onmouseover="UkazSkryj('Uloûiù z·hlavie dokladu, vstup sluûieb'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<td class="pvstup" width="10%" >
<?php
if( $fir_xfa01 == 2 )
{
?>
<input type="checkbox" name="h_tltv" id="h_tltv" value="1" checked="checked" />
<?php
}
?>
<?php
if( $fir_xfa01 != 2 )
{
?>
<input type="checkbox" name="h_tltv" id="h_tltv" value="1"  />
<?php
}
?>
<input type="submit" id="tovar" name="tovar" value="Tovar"  
 onmouseover="UkazSkryj('Uloûiù z·hlavie dokladu, vstup tovaru'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<?php
     }
?>

<?php
if( $drupoh == 12 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 OR $drupoh == 52 )
     {
?>
<input type="checkbox" name="h_tlsl" id="h_tlsl" value="1" checked="checked" />
<input type="submit" id="sluzby" name="sluzby" value="Sluûby"  
 onmouseover="UkazSkryj('Uloûiù z·hlavie dokladu, vstup sluûieb'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<td class="pvstup" width="10%" >
<?php
if( $fir_xdp01 == 2 )
{
?>
<input type="checkbox" name="h_tltv" id="h_tltv" value="1" checked="checked" />
<?php
}
?>
<?php
if( $fir_xdp01 != 2 )
{
?>
<input type="checkbox" name="h_tltv" id="h_tltv" value="1"  />
<?php
}
?>
<input type="submit" id="tovar" name="tovar" value="Tovar"  
 onmouseover="UkazSkryj('Uloûiù z·hlavie dokladu, vstup tovaru'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<?php
     }
?>

<td class="pvstup" width="15%" ></td><td class="pvstup" width="16%" ></td>
<td class="pvstup" width="50%" ></td><td class="pvstup" width="16%" ></td>
</tr>
</table>
<?php
}
?>

<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="16%" >

<img src='../obr/ziarovka.png' border="1" onclick="Rozb1();" alt="Zv‰Ëöiù okno pre text pred tovarom" title="Zv‰Ëöiù okno pre text pred tovarom" >
<input class="hvstup" type="hidden" name="rozb1" id="rozb1" value="NOT" />
&nbsp;Text pred:
</td>
<td class="hvstup" width="100px" >
<textarea name="h_txp" id="h_txp" rows="1" cols="50" >
<?php if( $vybr != 'ANO' )
{
?>
<?php echo $h_txp; ?>
<?php
}
?>
<?php if( $vybr == 'ANO' )
{
?>
<?php echo $cislo_txp; ?>
<?php
}
?>
</textarea>
</td>
<td class="pvstup">
<?php if( $drupoh == 1 OR $drupoh == 2 ) { ?>
&nbsp;&nbsp;<a href="#" onClick="Txp1();">1</a>&nbsp;&nbsp;
<a href="#" onClick="Txp2();">2</a>&nbsp;&nbsp;<a href="#" onClick="Txp3();">3</a>
&nbsp;&nbsp;<a href="#" onClick="Txp4();">4</a>
<?php                                    } ?>
<?php if( ( $drupoh == 1 OR $drupoh == 2 ) AND ( $copern == 5 OR $copern == 8 ) ) { ?>
<img src='../obr/zoznam.png' onclick="zoznamTextov();" width=20 height=12 border=0 title="Vybraù predvolen˝ text zo zoznamu" >
<?php                                     } ?>
</td>
</tr>
</table>

<table class="vstup" width="100%">
<tr></tr><tr></tr>
<tr>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" align="right" >&nbsp;%DPH</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Z·klad</td>
<td class="pvstup" width="10%" align="right" >&nbsp;DaÚ</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Spolu</td>
</tr>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sz1" id="h_sz1" size="12" value="<?php echo $fir_dph1; ?>" disabled="disabled" />
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zk1" id="h_zk1" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Zk1Enter(event.which)" onfocus="onZk1();"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_dn1" id="h_dn1" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Dn1Enter(event.which)" onfocus="onDn1();"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sp1" id="h_sp1" size="12" /> 
</td>
</tr>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sz2" id="h_sz2" size="12" value="<?php echo $fir_dph2; ?>" disabled="disabled" />
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zk2" id="h_zk2" size="12" onclick="HlvOnClick()" onfocus="onZk2();"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Zk2Enter(event.which)"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_dn2" id="h_dn2" size="12" onclick="HlvOnClick()" onfocus="onDn2();"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Dn2Enter(event.which)"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sp2" id="h_sp2" size="12" /> 
</td>
</tr>

<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sz0" id="h_sz0" size="12" value="0" disabled="disabled" />
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zk0" id="h_zk0" size="12" onclick="HlvOnClick()" onfocus="onZk0();"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Zk0Enter(event.which)"
/> 
</td>
<td class="hvstup" align="right" ></td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sp0" id="h_sp0" size="12" /> 
</td>
</tr>

<tr>
<td class="pvstup" colspan="7" >&nbsp;</td>
<td class="pvstup" align="right" colspan="2" >
Zaokr˙hlenie:
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zao" id="h_zao" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return ZaoEnter(event.which)" onfocus="onZao();"
/> 
</td>
</tr>

<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>

<td class="pvstup" colspan="1" >
<img src='../obr/naradie.png' onClick="nastavpaux.style.display='';" width=15 height=15 border=0 title="Nastavenie ˙Ëtovania pauö·lu 80%" ></a>
&nbsp;
Pauö·l 80%<input type="checkbox" name="pau80" id="pau80" value="1" />
</td>
<td class="pvstup" align="right" colspan="2" >
Celkom hodnota dokladu:
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_hod" id="h_hod" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return HodEnter(event.which)" onfocus="onHod();"
/> 
</td>
</tr>

<?php
if( $pocstav != 1 )
     {
?>
<tr>
<td class="pvstup" colspan="7" >&nbsp;</td>
<td class="pvstup" align="right" colspan="2" >
Zaplaten· z·loha:
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zal" id="h_zal" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return ZalEnter(event.which)"
/> 
</td>
</tr>
<?php
if( $drupoh == 31 OR $drupoh == 1 )
{
?>
<tr>
<td class="pvstup" colspan="7" >&nbsp;</td>
<td class="pvstup" align="right" colspan="2" >
DPH na z·lohe:
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_ruc" id="h_ruc" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return RucEnter(event.which)"
/> 
</td>
</tr>
<?php
}
?>
<?php
     }
?>

<?php
if( $pocstav == 1 )
     {
?>
<tr>
<td class="pvstup" colspan="7" >&nbsp;</td>
<td class="pvstup" align="right" colspan="2" >
UhradenÈ:
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_uhr" id="h_uhr" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return UhrEnter(event.which)"
/> 
</td>
</tr>
<?php
     }
?>
<tr></tr><tr></tr>
</table>

<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="16%" >
<img src='../obr/ziarovka.png' border="1" onclick="Rozb2();" alt="Zv‰Ëöiù okno pre text pred tovarom" title="Zv‰Ëöiù okno pre text pred tovarom" >
<input class="hvstup" type="hidden" name="rozb2" id="rozb2" value="NOT" />
&nbsp;Text za:
</td>
<td class="hvstup" width="100px" >
<textarea name="h_txz" id="h_txz" rows="1" cols="50" >
<?php if(  $vybr != 'ANO'  )
{
?>
<?php echo $h_txz; ?>
<?php
}
?>
<?php if( $vybr == 'ANO' )
{
?>
<?php echo $cislo_txz; ?>
<?php
}
?>
</textarea></td>
<td class="pvstup">
<?php if( $drupoh == 1 OR $drupoh == 2 ) { ?>
&nbsp;&nbsp;<a href="#" onClick="Txz1();">1</a>&nbsp;&nbsp;
<a href="#" onClick="Txz2();">2</a>&nbsp;&nbsp;<a href="#" onClick="Txz3();">3</a>
&nbsp;&nbsp;<a href="#" onClick="Txz4();">4</a>
<?php                                    } ?>
<?php if( ( $drupoh == 1 OR $drupoh == 2 ) AND ( $copern == 5 OR $copern == 8 ) ) { ?>
<img src='../obr/zoznam.png' onclick="zoznamTextov2();" width=20 height=12 border=0 title="Vybraù predvolen˝ text zo zoznamu" >
<?php                                     } ?>
</td>
</tr>
</table>

<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="15%" >&nbsp;Pozn·mka:</td>
<td class="hvstup" width="55%" >
<input class="hvstup" type="text" name="h_poz" id="h_poz" size="80" maxlength="80" value="<?php echo $h_poz;?>" onclick="HlvOnClick()"
 onKeyDown="return PozEnter(event.which)" /></td>
<td class="pvstup" width="25%" >&nbsp;(Nebude vytlaËen· na doklade)</td><td class="pvstup" >&nbsp;</td>
</tr>
<tr>
<td>
<input type="submit" id="uloh" name="uloh" value="Uloûiù"  
 onmouseover="UkazSkryj('Uloûiù ˙pravy z·hlavia dokladu'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>
&copern=1" >
<td class="obyc" >
<INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('Neuloûiù ˙pravy z·hlavia dokladu , n·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';">
</td>
<td class="obyc" >
<?php if( $sysx == 'UCT' AND $kli_vduj >= 0 AND $_SESSION['nieie'] == 0 AND $pocstav == 0 )  { ?>
<button id="uctovat" onclick="return Uctovat();" 
 onmouseover="UkazSkryj('Za˙Ëtovaù DPH,trûby,n·klady dokladu')" onmouseout="Okno.style.display='none';">⁄Ëtovaù</button>
<?php                                                                      } ?>
<?php if( $sysx == 'UCT' AND $kli_vduj >= 0 AND $_SESSION['nieie'] == 1 AND $pocstav == 0 )  { ?>
<img src='../obr/tlacitka/uctovat.jpg' border="1" onclick="Uctovat();" width="50" height="16" title="⁄Ëtovaù" >
<?php                                                                      } ?>


</td>
<td class="obyc" align="right"></td>
</FORM>
</table>

<?php
// toto je koniec nova faktura copern=5
     }
?>

<?php 
//vymazanie faktury a sluzby
//[[[[[[[666666666666 777777777777
if ( $copern == 6 OR $copern == 7 OR $copern == 17 OR $copern == 87 OR $copern == 97 )
     {
$odbm="";
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) { $odbm=",odbm"; }
if ( $drupoh == 1 ) { $odbm=",odbm,sz4"; }
$citzmen="";
if ( $drupoh == 1 OR $drupoh == 31 OR $drupoh == 2 ) { $citzmen=",zmen,mena,kurz,hodm,sz3,dav"; }
$cituhr="";
if ( $pocstav == 1 ) { $cituhr=",uhr"; }
$citsz4="";
if ( $drupoh == 2 ) { $citsz4=",sz4"; }

$sqltt = "SELECT uce, dok, fak, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, DATE_FORMAt(daz, '%d.%m.%Y' ) AS daz,".
" DATE_FORMAt(das, '%d.%m.%Y' ) AS das, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, icd, dol, prf, poz, str, zak, zal,".
" txp, txz, ksy, ssy, zk1, dn1, zk2, dn2, zk0, sp1, sp2, hod, obj, unk, dpr, zao".$odbm.$citzmen.$cituhr.$citsz4.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
$sql = mysql_query("$sqltt");
$j = 0;
?>
<table class="vstup" width="50%" height="120px" align="left">
<tr></tr><tr></tr>
<?php
   while ($j <= 0 )
   {
  if (@$zaznam=mysql_data_seek($sql,$j))
  {
$riadok=mysql_fetch_object($sql);
$h_dao=SkDatum($riadok->sz4);
$hodn_fak = $riadok->fak;
$hodn_dol = $riadok->dol;
$hodn_prf = $riadok->prf;
$hodn_dat = $riadok->dat;
$hodn_ico = $riadok->ico;
$hodn_str = $riadok->str;
$hodn_zak = $riadok->zak;
$h_uce = $riadok->uce;
?>

<tr>
<td class="pvstup">&nbsp;⁄Ëet:
<a href='vstf_s.php?copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Uloûenie origin·lu dokladu do datab·zy" title="Uloûenie origin·lu dokladu do datab·zy" ></a>
<?php
if( $vyb_duj == 1 )
 {
?>
<a href='vstf_s.php?copern=120&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Uloûenie origin·lu zmluvy do datab·zy" title="Uloûenie origin·lu zmluvy do datab·zy" ></a>
<?php
 }
?>
</td>
<td class="fmenu"><?php echo $riadok->uce; ?><?php if( $riadok->zmen == 1 ) { echo " - MENA ".$riadok->mena; } ?></td>
<td class="bmenu" width="10%" >
<?php
if( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 ) )
{
?>
<a href="#" onClick="nastavmenax.style.display=''; nacitajKURZ();">
<img src='../obr/banky/dollar2.jpg' width=20 height=12 border=0 alt='Vybraù menu' title='Vybraù menu' >Mena</a>
<?php
}
?>
</td>
</tr>
<tr>

<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 21 OR $drupoh == 31 OR $drupoh == 22 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / fakt˙ry <?php if( $ajvsy == 1 ) { echo "/ VSY"; } ?>:</td>
<td class="hvstup" width="25%" ><?php echo $riadok->dok; ?> <?php if( $ajvsy == 1 ) { echo "/ ".$riadok->sz3; } ?> / <?php echo $riadok->fak; ?></td>
<?php
}
?>
<?php
if( $drupoh == 42 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / ËÌslo v dni:</td>
<td class="hvstup" width="25%" ><?php echo $riadok->dok; ?> / <?php echo $riadok->fak; ?></td>
<?php
}
?>
<?php
if( $drupoh == 11 OR $drupoh == 12 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / dod.listu:</td>
<td class="hvstup" width="25%" ><?php echo $riadok->dok; ?> / <?php echo $riadok->dol; ?></td>
<?php
}
?>
<?php
if( $drupoh == 52 )
{
?>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu / predFakt:</td>
<td class="hvstup" width="25%" ><?php echo $riadok->dok; ?> / <?php echo $riadok->prf; ?></td>
<?php
}
?>

<td class="bmenu">
<?php
if ( $copern != 6 AND $copern != 87 AND $copern != 8 )
     {
?>
<?php if( $tlaclenpdf == 0 AND $drupoh != 42 )  { ?>
<a href="#" onClick="window.open('vstf_t.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&hladaj_uce=<?php echo $h_uce; ?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="VytlaËiù doklad" title="VytlaËiù doklad" >TlaËiù</a>
<?php                                                  } ?>
<?php if( $drupoh == 42 )                              { ?>
<a href="#" onClick="window.open('../doprava/regpok_pdf.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&sysx=<?php echo $sysx;?>
&cislo_dok=<?php echo $riadok->dok;?>&regpok=<?php echo $regpok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho dokladu " >TlaËiù</a>
<?php                                                  } ?>
<?php if( $tlaclenpdf == 1 AND $drupoh != 42 )  { ?>
<a href="#" onClick="TlacPdf();">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="VytlaËiù doklad" title="VytlaËiù doklad PDF" >TlaËiù</a>
<?php                                           } ?>
<?php
     }
?>
</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;D·tum vyhotovenia:</td>
<td class="hvstup"><?php echo $riadok->dat; ?></td>

<?php 
//echo "sysx ".$sysx;
if( $drupoh == 1 AND $sysx != 'UCT' AND $plotyskala == 1 )  { 
//andrejko
$jeskicd="";
$skicd=trim($riadok->icd);
$jeskicd=substr($skicd,0,2);
?>
<?php if( $jeskicd == "SK" )  { ?>
<td class="pvstup">
<span style="width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">SK Pl·tca DPH !!!</span>
</td>
<?php                       } ?>
<?php                                      } ?>

</tr>

<?php if( $drupoh != 2 ) { ?>
<tr><td class="pvstup" >&nbsp;D·tum dodania:</td><td class="hvstup"><?php echo $riadok->daz; ?></td>
<?php                    } ?>
<?php if( $drupoh == 2 ) { ?>
<tr><td class="pvstup" >&nbsp;D·tum dodania - odpoËtu:</td><td class="hvstup"><?php echo SkDatum($riadok->sz4); ?> - <?php echo $riadok->daz; ?></td>
<?php                    } ?>
<?php
//echo $copern;
if ( $copern == 7 AND $sysx == 'UCT' AND $kli_vrok >= 2016 )
     {
$textdpp=0;
$sqldpp = mysql_query("SELECT * FROM F".$kli_vxcf."_uctfakuhrdph WHERE dok = $cislo_dok AND prx7 = 1 ");
  if (@$zaznam=mysql_data_seek($sqldpp,0))
  {
  $riadokdpp=mysql_fetch_object($sqldpp);
  $textdpp=$riadokdpp->dppx;
  }
?>
<td class="pvstup">
<img src='../obr/icon_calendar.png' onClick="nastavdppx.style.display=''; volajDppset(<?php echo $kli_uzid;?>);" width=13 height=9 border=0 title="OdpoËet a uplatnenie DPH aû po prijatÌ platby 0=nie, 1=·no" ></a>
<?php echo $textdpp; ?>
</td>
<?php
     }
?>

</tr>

<tr>
<td class="pvstup" >&nbsp;D·tum splatnosti:</td>
<td class="hvstup"><?php echo $riadok->das; ?></td>

<?php
//echo $copern;
if ( $copern == 7 AND $drupoh == 2 AND $sysx == 'UCT' )
     {
$textdak="kvdph";
if( $dak_set != '' AND $dak_set != '00.00.0000' ) { $textdak=$dak_set; }
?>
<td class="pvstup">
<img src='../obr/icon_calendar.png' onClick="nastavdakx.style.display=''; volajDakset(<?php echo $kli_uzid;?>);" width=12 height=9 border=0 title="D·tum zaradenia do KV DPH, ak je in˝ ako d·tum odpoËtu" ></a>
<?php echo $textdak; ?>
</td>
<?php
     }
?>

</tr>
<tr>
<td class="pvstup" >&nbsp;Objedn·vka 

<?php
if( $copern == 7 AND $drupoh == 1 AND $sys == 'FAK' )
  {
  $ajeshop=0;
  if (File_Exists ("../eshop/index.php")) { $ajeshop=1; }
  if( $ajeshop == 1 )       { 
?>
<a href='../eshop/obj_tlac.php?copern=8011&drupoh=1&page=1&ffd=0&cislo_dok=<?php echo $riadok->dok;?>&zmtz=1'>
<img src='../obr/prev.png' width=15 height=13 border=0 title="Presun fakt˙ry do objedn·vok" ></a>
<?php                       } ?>
<?php
  }
?>

- UNIkÛd:</td>

<?php
$cislo_unk=1*$riadok->unk;
$unkcheck=0;
if( $fir_fico == 46614478 AND $drupoh == 11 ) { $unkcheck=1; }
$textunk=$riadok->unk;
if( $unkcheck == 1 )
  {
$textunk="VYSPORIADAN›";
if( $cislo_unk == 1 ) { $textunk="NEVYSPORIADAN›"; }  
  }
?>

<td class="hvstup"><?php echo $riadok->obj; ?> - <?php echo $textunk; ?></td>
<?php
if( $copern == 7 OR $copern == 17 )
{
?>
<td>
<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=8&drupoh=<?php echo $drupoh;?>&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>'>
<img src='../obr/ziarovka.png' width=15 height=16 border=0 alt="⁄prava z·hlavia dokladu" title="⁄prava z·hlavia dokladu" >Z·hlavie</a>
</td>
<?php
}
?>
</tr>
<tr></tr><tr></tr>
</table>

<table class="vstup" width="50%" height="120px" align="left">
<tr></tr><tr></tr>

<tr>
<td class="pvstup">&nbsp;Odberateæ I»O:
<?php
if( $copern != 5 AND $copern != 6 )
{
?>
<img src='../obr/ziarovka.png' border="1" onclick="newIco();" width="12" height="12" title="Vloûiù novÈ I»O do datab·zy" >
<?php
}
?>
</td>
<td class="fmenu"><?php echo $riadok->ico; ?>
<?php  if ( $drupoh == 1 OR $drupoh == 2 )    { ?>
 <img src='../obr/zoznam.png' onClick="TlacNespSaldo(<?php echo $riadok->ico;?>);" width=15 height=15 border=0 title='Saldokonto' >
<?php                         } ?>

<?php
$akeicd=$riadok->icd;
if( $riadok->odbm > 0 )
{
$sqlttt = "SELECT icd2 FROM F$kli_vxcf"."_icoodbm WHERE ico = $riadok->ico AND odbm = $riadok->odbm ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akeicd=$riaddok->icd2;
  }
}
?>

 iËDPH <?php echo $akeicd; ?>

<?php
if ( ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 31 OR $drupoh == 11 OR $drupoh == 12 OR $drupoh == 52 ) AND $riadok->odbm > 0 )
     {
?>
 / <?php echo $riadok->odbm; ?>
<?php
     }
?>
</td>
<td class="bmenu" width="10%" ></td>
</tr>
<tr>
<td class="pvstup" width="15%" >&nbsp;Odberateæ N·zov:</td>
<td class="hvstup" width="25%" >
<a href="#" title="Upraviù ˙daje o I»O" 
onClick="window.open('../cis/cico.php?copern=88&page=1&cislo_ico=<?php echo $riadok->ico; ?>', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $riadok->nai; ?></a>
</td>
<td class="bmenu" width="10%" >
<?php
if ( $copern != 6 AND $copern != 87 AND $copern != 8 AND ( $drupoh == 1 OR $drupoh == 11 OR $drupoh == 31 OR $drupoh == 21 ) )
     {
?>
<img src='../obr/pdf.png' width=15 height=12 border=0 title="Vytvoriù Sk doklad PDF" onClick="TlacPdf();" > PDF

<?php
if ( $zahranicna == 1 )
   {
?>
<img src='../obr/germany.png' width=15 height=12 border=0 title="Vytvoriù D doklad PDF" onClick="TlacPdfD();" >

<img src='../obr/england.png' width=15 height=12 border=0 title="Vytvoriù GB doklad PDF" onClick="TlacPdfGB();" >
<?php
   }
?>
<?php
     }
?>
<?php
if ( $copern == 7 AND ( $drupoh == 11 OR $drupoh == 12 ))
     {
?>
<?php if( $tlaclenpdf == 0 )         { ?>
<a href="#" onClick="window.open('vstf_t.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>&ceny=0', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 alt="VytlaËiù doklad bez cien" title="VytlaËiù doklad bez cien" >Bez cien</a>
<?php                                } ?>

<?php if( $tlaclenpdf == 1 )         { ?>
<a href="#" onClick="TlacPdfbezCen();">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="VytlaËiù doklad bez cien" >Bez cien</a>
<?php                                } ?>
<?php
     }
?>
</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;STR - Z¡K:</td>
<td class="hvstup"><?php echo $riadok->str; ?> - <?php echo $riadok->zak; ?></td></tr>
<tr>
<td class="pvstup" >&nbsp;KSY - SSY:</td>
<td class="hvstup"><?php echo $riadok->ksy; ?> - <?php echo $riadok->ssy; ?> Oprav.fakt˙ra <?php echo $riadok->dav; ?></td>
</tr>
<tr>

<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 21 OR $drupoh == 31 OR $drupoh == 22 OR $drupoh == 42 )
{
?>
<td class="pvstup" >&nbsp;Dod.list - Predfakt˙ra:</td>
<td class="hvstup"><?php echo $riadok->dol; ?> - <?php echo $riadok->prf; ?>
<?php
if ( $copern == 7 AND $drupoh == 1 )
     {
?>
<td class="pvstup">


 <img src='../obr/pdf.png' width=13 height=13 border=0 alt="VytlaËiù dodacÌ list PDF" title="VytlaËiù dodacÌ list PDF" onClick="TlacPdfDod();" >
 <img src='../obr/pdf.png' width=13 height=13 border=0 alt="VytlaËiù predfakt˙ru PDF" title="VytlaËiù predfakt˙ru PDF" onClick="TlacPdfPrf();" >

<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=0&copern=355&drupoh=11&page=1&cislo_fak=<?php echo $riadok->dok;?>' >
<img src='../obr/ziarovka.png' width=20 height=12 border=0 alt="Vytvoriù dodacÌ list k tejto fakt˙re" title="Vytvoriù dodacÌ list k tejto fakt˙re" ></a>
<?php
     }
?>
</td>
<?php
}
?>
<?php
if( $drupoh == 11 OR $drupoh == 12 )
{
?>
<td class="pvstup" >&nbsp;Fakt˙ra - predFakt:</td>
<td class="hvstup"><?php echo $riadok->fak; ?> - <?php echo $riadok->prf; ?></td>
<?php
}
?>
<?php
if( $drupoh == 52 )
{
?>
<td class="pvstup" >&nbsp;Fakt˙ra - Dod.list:</td>
<td class="hvstup"><?php echo $riadok->fak; ?> - <?php echo $riadok->dol; ?></td>
<?php
}
?>

</tr>
<tr>
<td class="pvstup" >&nbsp;Doprava:</td>
<td class="hvstup"><?php echo $riadok->dpr; ?></td>
<td class="pvstup" width="10%" >
<?php
if ( $copern == 7 AND $drupoh == 1 )
     {
?>
<a href='vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=55&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $h_uce; ?>
&cislo_dok=<?php echo $riadok->dok;?>' >
<img src='../obr/ziarovka.png' width=20 height=12 border=0 alt="Vytvoriù rovnak˝ nov˝ doklad" title="Vytvoriù rovnak˝ nov˝ doklad" ></a>
<?php
     }
?>
<?php
if ( $copern == 7 AND $drupoh != 42 )
     {
?>
<a href="#" onClick="window.open('obalka.php?copern=10&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>',
 '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/obalka.jpg' width=20 height=12 border=0 alt="VytlaËiù ob·lku" title="VytlaËiù ob·lku" ></a>
<?php
     }
?>
<?php
if ( $copern == 7 AND $drupoh == 42 )
     {
?>
<a href="../tmp/registruj<?php echo $riadok->dok;?>" >registruj<?php echo $riadok->dok;?></a>
<?php
     }
?>
</td>
</tr>
<tr></tr><tr></tr>
</table>
<br clear=left>
<tr>
<div id="Okno"></div>
<div id="myMENAelement"></div>
</tr>

<?php
if( $riadok->zmen == 1 )
    {
//cudzia mena
$kurzform=1*$riadok->kurz;
?>
<table  class='ponuka' width='100%'>
<tr>
<td width="15%" >Cudzia mena: <?php echo $riadok->mena; ?></td>
<td width="12%" >Pomer: 1</td>
<td width="12%" >Kurz: <?php echo $kurzform; ?></td>
<td width="12%" >Hodnota: <?php echo $riadok->hodm; ?><?php echo $riadok->mena; ?></td>
<td width="72%" > </td>
</tr>
</table>
<?php
    }
?>


<table class="vstup" width="100%">
<tr>
<?php
$vypis_txp = ereg_replace("\n", "<br>", trim($riadok->txp));
$vypis_txp = ereg_replace(" ", "&nbsp;", trim($vypis_txp));
?>
<td class="hvstup" width="100%" >

<?php
if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 31 ) AND $sysx != 'UCT' )
     {
?>
<img src='../obr/uprav.png' width=12 height=12 border=1 onClick="RozniPenp(1);" title="Upraviù text pred poloûkami fakt˙ry" >
<?php
     }
?>

<?php echo $vypis_txp; ?></td>
</tr>
</table>
<tr>
<span id="Cx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo sluûby musÌ byù celÈ kladnÈ ËÌslo v rozsahu 0 aû 999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Cena musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Mnoûstvo musÌ byù desatinnÈ ËÌslo v rozsahu 0.001 aû 999999 max. 3 desatinnÈ miesta</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka SLU=<?php echo $h_slu;?> spr·vne uloûen·</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka SLU=<?php echo $h_slu;?>  zmazan·</span>
<span id="Nen" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nenaöiel som v ËÌselnÌku sluûieb , pre voæn˝ vstup zadajte SLU=0</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ ËÌslo </span>
</tr>

<?php
if ( $copern == 6 OR $copern == 7 OR $copern == 17 OR $copern == 87 OR $copern == 97 )
                {


$sluztt = "SELECT dok, cpl, F$kli_vxcf"."_$tablsluzby.slu, F$kli_vxcf"."_$tablsluzby.nsl, pop, F$kli_vxcf"."_$tablsluzby.dph,".
" mno, F$kli_vxcf"."_$tablsluzby.mer, F$kli_vxcf"."_$tablsluzby.cep, F$kli_vxcf"."_$tablsluzby.ced, fak, dol, cfak, nslp, pon". 
" FROM F$kli_vxcf"."_$tablsluzby".
" LEFT JOIN F$kli_vxcf"."_$cissluzby".
" ON F$kli_vxcf"."_$tablsluzby.slu=F$kli_vxcf"."_$cissluzby.slu".
" WHERE F$kli_vxcf"."_$tablsluzby.dok = $cislo_dok ".
" ORDER BY cpl";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//echo $slpol;
$ajpoz="";
if( $drupoh == 1 OR $drupoh == 11 ) { $ajpoz=",poz"; }

$tovtt = "SELECT dok, cpl, F$kli_vxcfskl"."_$tabltovar.cis AS slu, F$kli_vxcfskl"."_$tabltovar.nat AS nsl, pop, F$kli_vxcfskl"."_$tabltovar.dph,".
" mno, F$kli_vxcfskl"."_$tabltovar.mer, F$kli_vxcfskl"."_$tabltovar.cep, F$kli_vxcfskl"."_$tabltovar.ced, F$kli_vxcfskl"."_$tabltovar.cen, fak, dol $ajpoz". 
" FROM F$kli_vxcfskl"."_$tabltovar".
" LEFT JOIN F$kli_vxcfskl"."_sklcis".
" ON F$kli_vxcfskl"."_$tabltovar.cis=F$kli_vxcfskl"."_sklcis.cis".
" WHERE F$kli_vxcfskl"."_$tabltovar.dok = $cislo_dok ".
" ORDER BY cpl";
//echo $tovtt;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
?>

<table class="fmenu" width="100%" >

<tr>
<th class="hmenu">
<?php
if ( $drupoh == 1 OR $drupoh == 11 OR ( $drupoh == 42 AND $regpok == 1 ) )
          {
?>
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tlsl == 1 )
                {
?>
<a href='vstf_u	.php?copern=7&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_fak=<?php echo $riadok->fak;?>&h_dol=<?php echo $riadok->dol;?>
&regpok=<?php echo $regpok;?>&h_prf=<?php echo $riadok->prf;?>&h_tlsl=0&h_tltv=1' >
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Prepn˙ù do tovaru" title="Prepn˙ù do tovaru"></a>
<?php
                }
?>
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tltv == 1 )
                {
?>
<a href='vstf_u	.php?copern=7&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_fak=<?php echo $riadok->fak;?>&h_dol=<?php echo $riadok->dol;?>
&regpok=<?php echo $regpok;?>&h_prf=<?php echo $riadok->prf;?>&h_tlsl=1&h_tltv=0' >
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Prepn˙ù do sluûieb" title="Prepn˙ù do sluûieb"></a>
<?php
                }
?>
<?php
           }
?>
Por.ËÌslo
<th class="hmenu">
<?php
if ( $copern == 7 )
                {
?>
<a href='vstf_u	.php?copern=17&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_fak=<?php echo $riadok->fak;?>&h_dol=<?php echo $riadok->dol;?>
&regpok=<?php echo $regpok; ?>&h_prf=<?php echo $riadok->prf;?>&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>' >
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Vloûiù textov˝ riadok" title="Vloûiù textov˝ riadok"></a>
<?php
                }
?>
<?php
if( $h_tlsl == 1 )
{
?>
Sluûba
<th class="hmenu">N·zov sluûby
<?php if( $riadok->zmen == 1 ) { echo " - CENY zad·vajte v ".$riadok->mena; } ?>
<th class="hmenu">DPH
<th class="hmenu">JCbezDPH<th class="hmenu">JCsdPH<th class="hmenu">Mnoûstvo<th class="hmenu">MJ
<th class="hmenu">HODbezDPH<th class="hmenu">HODsDPH<th class="hmenu">Zmaû
<?php
}
?>
<?php
if( $h_tltv == 1 )
{
?>
Tovar
<th class="hmenu">N·zov tovaru
<?php if( $riadok->zmen == 1 ) { echo " - CENY zad·vajte v ".$riadok->mena; } ?>
<th class="hmenu">DPH
<th class="hmenu">JCbezDPH<th class="hmenu">JCsdPH<th class="hmenu">Mnoûstvo<th class="hmenu">MJ
<th class="hmenu">HODbezDPH<th class="hmenu">HODsDPH<th class="hmenu">Zmaû
<?php
}
?>
</tr>

<?php
//zaciatok vypisu tovaru
if( $tvpol > 0 )
     {
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

?>

<?php if(  $copern == 7 AND ( $drupoh == 1 OR $drupoh == 11 ) AND $sysx != 'UCT' ) { ?>
<?php if( $textnadpol == 1 AND $rtov->poz != '' ) { ?>
<tr><td class="bmenu" colspan="2" ><td class="fmenu" colspan="9" ><?php echo $rtov->poz;?></td></tr>
<?php                                             } ?>
<?php                                                         } ?>


<tr>
<?php
if ( $copern != 87 AND $copern != 97 AND $copern != 6 AND $h_tltv == 1 )
     {
?>
<td class="fmenu" width="8%" >
<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>&
<?php
if(  $rtov->slu >= 0 AND $rtov->nsl != '' AND $h_tltv == 1 )
{
?>
copern=87
<?php
}
?>
<?php
if(  $rtov->slu == 0 AND $rtov->pop != '' AND $h_tltv == 1 )
{
?>
copern=97
<?php
}
?>
&drupoh=<?php echo $drupoh;?>&cislo_cpl=<?php echo $rtov->cpl;?>&z_cpl=<?php echo $rtov->cpl;?>
&cislo_dok=<?php echo $rtov->dok;?>&z_slu=<?php echo $rtov->slu;?>&z_mno=<?php echo $rtov->mno;?>
&z_dph=<?php echo $rtov->dph;?>&z_cep=<?php echo $rtov->cep;?>&z_ced=<?php echo $rtov->ced;?>&z_cen=<?php echo $rtov->cen;?>
&z_pop=<?php echo $rtov->pop;?>&z_nsl=<?php echo $rtov->nsl;?>&z_mer=<?php echo $rtov->mer;?>'>
<?php echo $rtov->cpl;?>
</a>
</td>
<?php
      }
?>

<?php
if ( $copern ==  6 OR $h_tltv != 1 )
     {
?>
<td class="fmenu" width="8%" >
<?php echo $rtov->cpl;?>
</td>
<?php
      }
?>

<?php
if ( $copern == 87 AND $rtov->cpl == $z_cpl AND $h_tltv == 1 )
     {
?>
<td class="fmenu" width="8%" align="right" style="font-family:bold; font-weight:bold; background-color:red; color:black;">
<?php echo $rtov->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 87 AND $rtov->cpl != $z_cpl AND $h_tltv == 1 )
     {
?>
<td class="fmenu" width="8%" >
<?php echo $rtov->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 97 AND $rtov->cpl == $z_cpl AND $h_tltv == 1 )
     {
?>
<td class="fmenu" width="8%" align="right" style="font-family:bold; font-weight:bold; background-color:red; color:black;">
<?php echo $rtov->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 97 AND $rtov->cpl != $z_cpl AND $h_tltv == 1 )
     {
?>
<td class="fmenu" width="8%" >
<?php echo $rtov->cpl;?>
</td>
<?php
     }
?>
<?php
if(  $rtov->slu >= 0 AND $rtov->nsl != '' )
{
?>
<td class="fmenu" width="8%" ><?php echo $rtov->slu;?></td>
<td class="fmenu" width="34%" ><?php echo $rtov->nsl;?></td>
<td class="fmenu" width="3%" ><?php echo $rtov->dph;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $rtov->cep;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $rtov->ced;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $rtov->mno;?></td>
<td class="fmenu" width="2%" ><?php echo $rtov->mer;?></td>
<?php 
$hodbdph = $rtov->cep*$rtov->mno;
if( $rtov->dph == $fir_dph2 ) $hodsdph = ($rtov->cep*$rtov->mno)*(1+$fir_dph2/100);
if( $rtov->dph == $fir_dph1 ) $hodsdph = ($rtov->cep*$rtov->mno)*(1+$fir_dph1/100);        
if( $rtov->dph == 0 ) $hodsdph = ($rtov->cep*$rtov->mno);

$Cislo=$hodbdph+"";
$hdp=sprintf("%0.2f", $Cislo);
$Cislo=$hodsdph+"";
$hdd=sprintf("%0.2f", $Cislo);
?>
<td class="fmenu" width="8%" align="right" ><?php echo $hdp;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $hdd;?></td>
<?php
}
?>
<?php
if(  $rtov->slu == 0 AND $rtov->pop != '' )
{
?>
<td class="fmenu" width="8%" ><?php echo $rtov->slu;?></td>
<td class="fmenu" width="93%" colspan="8" ><?php echo $rtov->pop;?></td>
<?php
}
?>
<td class="fmenu" width="5%" >
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tltv == 1 )
     {
?>
<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=36&drupoh=<?php echo $drupoh;?>&cislo_cpl=<?php echo $rtov->cpl;?>&hladaj_uce=<?php echo $h_uce; ?>
&cislo_dok=<?php echo $rtov->dok;?>&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>
&h_slu=<?php echo $rtov->slu;?>&z_mno=<?php echo $rtov->mno;?>&zmen=<?php echo $zmen;?>&kurz=<?php echo $kurz;?>
&z_dph=<?php echo $rtov->dph;?>&z_cep=<?php echo $rtov->cep;?>&z_ced=<?php echo $rtov->ced;?>
&z_cen=<?php echo $rtov->cen;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt="Vymazanie vybranej poloûky" title="Vymazanie vybranej poloûky" ></a>
<?php
     }
?>
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tltv != 1 )
     {
?>
TOV
<?php
     }
?>
</td>
</tr>
<?php
}

$i = $i + 1;
  }
     }
//koniec vypisu tovaru ak tvpol > 0
?>

<?php
//zaciatok vypisu sluzieb
if( $slpol > 0 )
     {
$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

?>

<?php if(  $copern == 7 AND ( $drupoh == 1 OR $drupoh == 11 ) AND $sysx != 'UCT' ) { ?>
<?php if( $textnadpol == 1 AND $rsluz->pon != '' ) { ?>
<tr><td class="bmenu" colspan="2" ><td class="fmenu" colspan="9" ><?php echo $rsluz->pon;?></td></tr>
<?php                                              } ?>
<?php                                                         } ?>

<?php
if( $rsluz->nslp != '' )
{
?>
<tr>
<td class="fmenu" colspan="8" >&nbsp;&nbsp;<?php echo $rsluz->nslp;?></td>
</tr>
<?php
}
?>

<tr>
<?php
if ( $copern != 87 AND $copern != 97 AND $copern != 6 AND $h_tlsl == 1 )
     {
?>
<td class="fmenu" width="8%" >
<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>&hladaj_uce=<?php echo $h_uce; ?>&
<?php
if(  $rsluz->slu >= 0 AND $rsluz->nsl != '' AND $h_tlsl == 1  )
{
?>
copern=87
<?php
}
?>
<?php
if(  $rsluz->slu == 0 AND $rsluz->pop != '' AND $h_tlsl == 1  )
{
?>
copern=97
<?php
}
?>
&drupoh=<?php echo $drupoh;?>&cislo_cpl=<?php echo $rsluz->cpl;?>&z_cpl=<?php echo $rsluz->cpl;?>
&cislo_dok=<?php echo $rsluz->dok;?>&z_slu=<?php echo $rsluz->slu;?>&z_mno=<?php echo $rsluz->mno;?>
&z_dph=<?php echo $rsluz->dph;?>&z_cep=<?php echo $rsluz->cep;?>&z_ced=<?php echo $rsluz->ced;?>
&z_pop=<?php echo $rsluz->pop;?>&z_nsl=<?php echo $rsluz->nsl;?>&z_mer=<?php echo $rsluz->mer;?>'>
<?php echo $rsluz->cpl;?>
</a>
</td>
<?php
      }
?>

<?php
if ( $copern ==  6 OR $h_tlsl != 1  )
     {
?>
<td class="fmenu" width="8%" >
<?php echo $rsluz->cpl;?>
</td>
<?php
      }
?>

<?php
if ( $copern == 87 AND $rsluz->cpl == $z_cpl AND $h_tlsl == 1 )
     {
?>
<td class="fmenu" width="8%" align="right" style="font-family:bold; font-weight:bold; background-color:red; color:black;">
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 87 AND $rsluz->cpl != $z_cpl AND $h_tlsl == 1 )
     {
?>
<td class="fmenu" width="8%" >
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 97 AND $rsluz->cpl == $z_cpl AND $h_tlsl == 1 )
     {
?>
<td class="fmenu" width="8%" align="right" style="font-family:bold; font-weight:bold; background-color:red; color:black;">
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 97 AND $rsluz->cpl != $z_cpl AND $h_tlsl == 1 )
     {
?>
<td class="fmenu" width="8%" >
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>

<?php
if(  $rsluz->slu >= 0 AND $rsluz->nsl != '' )
{
?>
<td class="fmenu" width="8%" ><?php echo $rsluz->slu;?></td>
<td class="fmenu" width="34%" ><?php echo $rsluz->nsl;?></td>
<td class="fmenu" width="3%" ><?php echo $rsluz->dph;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $rsluz->cep;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $rsluz->ced;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $rsluz->mno;?></td>
<td class="fmenu" width="2%" ><?php echo $rsluz->mer;?></td>
<?php 
$hodbdph = $rsluz->cep*$rsluz->mno;
if( $rsluz->dph == $fir_dph2 ) $hodsdph = ($rsluz->cep*$rsluz->mno)*(1+$fir_dph2/100);
if( $rsluz->dph == $fir_dph1 ) $hodsdph = ($rsluz->cep*$rsluz->mno)*(1+$fir_dph1/100);        
if( $rsluz->dph == 0 ) $hodsdph = ($rsluz->cep*$rsluz->mno);

$Cislo=$hodbdph+"";
$hdp=sprintf("%0.2f", $Cislo);
$Cislo=$hodsdph+"";
$hdd=sprintf("%0.2f", $Cislo);
?>
<td class="fmenu" width="8%" align="right" ><?php echo $hdp;?></td>
<td class="fmenu" width="8%" align="right" ><?php echo $hdd;?></td>
<?php
}
?>
<?php
if(  $rsluz->slu == 0 AND $rsluz->pop != '' )
{
?>
<td class="fmenu" width="8%" ><?php echo $rsluz->slu;?></td>
<td class="fmenu" width="93%" colspan="8" ><?php echo $rsluz->pop;?></td>
<?php
}
?>
<td class="fmenu" width="5%" >
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tlsl == 1 AND $drupoh != 12 )
     {
?>
<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=36&drupoh=<?php echo $drupoh;?>&cislo_cpl=<?php echo $rsluz->cpl;?>&hladaj_uce=<?php echo $h_uce; ?>
&cislo_dok=<?php echo $rsluz->dok;?>&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>
&h_slu=<?php echo $rsluz->slu;?>&z_mno=<?php echo $rsluz->mno;?>&zmen=<?php echo $zmen;?>&kurz=<?php echo $kurz;?>
&z_dph=<?php echo $rsluz->dph;?>&z_cep=<?php echo $rsluz->cep;?>&z_ced=<?php echo $rsluz->ced;?>
'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt="Vymazanie vybranej poloûky" title="Vymazanie vybranej poloûky" ></a>
<?php
     }
?>
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tlsl != 1 AND $drupoh != 12 )
     {
?>
SLU
<?php
     }
?>
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tlsl == 1 AND $drupoh == 12 AND $rsluz->cfak == 0 )
     {
?>
<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=36&drupoh=<?php echo $drupoh;?>&cislo_cpl=<?php echo $rsluz->cpl;?>&hladaj_uce=<?php echo $h_uce; ?>
&cislo_dok=<?php echo $rsluz->dok;?>&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>
&h_slu=<?php echo $rsluz->slu;?>&z_mno=<?php echo $rsluz->mno;?>&zmen=<?php echo $zmen;?>&kurz=<?php echo $kurz;?>
&z_dph=<?php echo $rsluz->dph;?>&z_cep=<?php echo $rsluz->cep;?>&z_ced=<?php echo $rsluz->ced;?>
'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt="Vymazanie vybranej poloûky" title="Vymazanie vybranej poloûky" ></a>
<?php
     }
?>
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tlsl == 1 AND $drupoh == 12 AND $rsluz->cfak > 0 AND $rsluz->cfak != 999 )
     {
echo $rsluz->cfak;
     }
?>
<?php
if ( ( $copern == 7 OR $copern == 17 ) AND $h_tlsl == 1 AND $drupoh == 12 AND $rsluz->cfak == 999 )
     {
echo "<a href='vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=2010&drupoh=12&cislo_dok=$rsluz->dok&&hladaj_uce=<?php echo $h_uce; ?>cislo_cpl=$rsluz->cpl&page=1&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT'>$rsluz->cfak</a>";
     }
?>

</td>
</tr>
<?php
}

$i = $i + 1;
  }
     }
//koniec vypisu sluzieb ak slpol > 0
?>

<?php
                }
// koniec vypisu poloziek sluzieb aj tovaru pre copern 6,7 6666666666666666  777777777777777
?>
<?php
// vstup poloziek sluzby 777777777777777
if ( $copern == 7  OR $copern == 87 )
     {
?>
<tr>
<FORM name="forms1" class="obyc" method="post" action="vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>
<?php
if ( $copern == 7 )
     {
?>
&copern=77&cislo_dok=<?php echo $cislo_dok;?>" >
<?php if(  $copern == 7 AND ( $drupoh == 1 OR $drupoh == 11 ) AND $sysx != 'UCT' ) { ?>
<?php if( $textnadpol == 0 ) { ?>
<input type="hidden" name="h_pon" id="h_pon" />
<?php                        } ?>
<?php if( $textnadpol == 1 ) { ?>
<td class="bmenu" colspan="2" >Text nad poloûkou:<td class="bmenu" colspan="9" ><input type="text" name="h_pon" id="h_pon" size="80" maxlength="80" value="<?php echo $z_pon; ?>" ></td></tr><tr>
<?php                        } ?>
<?php                                                         } ?>
<td class="fmenu"><input type="text" name="h_cpl" id="h_cpl" size="5" /></td>
<?php
}
?>
<?php
if ( $copern == 87 )
     {
?>
&copern=88&cislo_dok=<?php echo $cislo_dok;?>&cislo_cpl=<?php echo $z_cpl;?>" >
<?php if( $textnadpol == 0 ) { ?>
<input type="hidden" name="h_pon" id="h_pon" />
<?php                        } ?>
<?php if( $textnadpol == 1 ) { ?>
<?php
if ( $copern == 87 AND $drupoh == 1 AND $sysx != 'UCT' ) {
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklfak WHERE cpl = $z_cpl ";
if( $h_tlsl == 1 )
 {
$sqlttt = "SELECT cpl, pon AS poz FROM F$kli_vxcf"."_fakslu WHERE cpl = $z_cpl ";
 }
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $z_pon=$riaddok->poz;
  }                                                         }
?>
<td class="bmenu" colspan="2" >Text nad poloûkou:<td class="bmenu" colspan="9" ><input type="text" name="h_pon" id="h_pon" size="80" maxlength="80" value="<?php echo $z_pon; ?>" ></td></tr><tr>
<?php                        } ?>
<td class="fmenu" >
<input type="text" name="h_cpl" id="h_cpl" size="5" style="background-color:lime; color:black;" value="<?php echo $z_cpl;?>" />
</td>
<?php
}
?>

<td class="fmenu"><input type="text" name="h_slu" id="h_slu" size="5" 
onchange="return intg(this,0,999999,Cx,document.forms1.err_cis)" onclick="document.forms1.h_nsl.disabled = false; ZhasniSP(); myDivElement.style.display='none'; nulujPol();"
 onkeyup="KontrolaCisla(this, Cx)" onKeyDown="return SluEnter(event.which)" onfocus="onSlu();"/>
<INPUT type="hidden" name="err_slu" value="0"></td>

<td class="fmenu">

<img src='../obr/hladaj.png' border="1" alt="Hæadaj zadanÈ ËÌslo alebo n·zov sluûby" onclick="myDivElement.style.display=''; volajSlu();" >
<input type="text" name="h_nsl" id="h_nsl" size="42" maxlength="<?php echo $maxtextpol;?>" onclick="ZhasniSP(); myDivElement.style.display='none'; nulujPol();" 
 onKeyDown="return NslEnter(event.which)" onfocus="onNsl();" />
<input type="hidden" name="hlas" id="hlas" value="NIE" />
</td>

<td class="fmenu">
<select size="1" name="h_dph" id="h_dph" onmouseover="Fx.style.display='none';" onKeyDown="return DphEnter(event.which)" >
<?php
if ( $riadok->zmen != 1 )
     {
?>
<option value="<?php echo $fir_dph2;?>" ><?php echo $fir_dph2;?></option>
<option value="<?php echo $fir_dph1;?>" ><?php echo $fir_dph1;?></option>
<option value="0" >0</option>
<option value="<?php echo $fir_dph3;?>" ><?php echo $fir_dph3;?></option>
<option value="<?php echo $fir_dph4;?>" ><?php echo $fir_dph4;?></option>
<?php
     }
?>
<?php
if ( $riadok->zmen == 1 )
     {
?>
<option value="0" >0</option>
<?php
     }
?>
</td>

<INPUT type="hidden" name="h_cen"
<?php
if ( $copern != 87 )
     {
?>
 value="0">
<?php
     }
?>
<?php
if ( $copern == 87 )
     {
?>
 value="<?php echo $z_cen;?>">
<?php
     }
?>
</td>

<td class="fmenu"><input class="hvstup" type="text" name="h_cep" id="h_cep" size="11" 
onchange="return cele(this,0.0001,99999999,Dx,4,document.forms1.err_cep)" onclick="Fx.style.display='none';"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return CepEnter(event.which)" onfocus="onCep();" />
<?php if( $itstablet == 1 )     {  ?>
<img border=0 src="../obr/next.png" style="width:15; height:15;" onClick="return CepEnter(13)" title="œalej" >
<?php                           }  ?>
<INPUT type="hidden" name="err_cep" >

<td class="fmenu"><input class="hvstup" type="text" name="h_ced" id="h_ced" size="11" 
onchange="return cele(this,0.0001,99999999,Dx,4,document.forms1.err_ced)" onclick="Fx.style.display='none';"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return CedEnter(event.which)" onfocus="onCed();" />
<?php if( $itstablet == 1 )     {  ?>
<img border=0 src="../obr/next.png" style="width:15; height:15;" onClick="return CedEnter(13)" title="œalej" >
<?php                           }  ?>
<INPUT type="hidden" name="err_ced" >

<td class="fmenu"><input type="text" name="h_mno" id="h_mno" size="8" 
 onchange="return cele(this,-999999,999999,Ex,3,document.forms1.err_mno)" onclick="Fx.style.display='none';"
 onkeyup="KontrolaDcisla(this, Ex)" onKeyDown="return MnoEnter(event.which)" onfocus="onMno();" />
<INPUT type="hidden" name="err_mno" >

<td class="fmenu"><input type="text" name="h_mer" id="h_mer" size="3" onClick="return Povol_uloz();"
onKeyDown="return MerEnter(event.which)" onfocus="onMer();" />
<?php if( $itstablet == 1 )     {  ?>
<img border=0 src="../obr/next.png" style="width:15; height:15;" onClick="return MerEnter(13)" title="œalej" >
<?php                           }  ?>

<td class="fmenu"><input type="text" name="h_hdp" id="h_hdp" size="9" /></td>
<td class="fmenu"><input type="text" name="h_hdd" id="h_hdd" size="9" /></td>

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="3" /></td>
<input type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />
<input type="hidden" name="h_fak" id="h_fak" value="<?php echo $hodn_fak;?>" />
<input type="hidden" name="h_dol" id="h_dol" value="<?php echo $hodn_dol;?>" />
<input type="hidden" name="h_prf" id="h_prf" value="<?php echo $hodn_prf;?>" />
<input type="hidden" name="h_dat" id="h_dat" value="<?php echo $hodn_dat;?>" />
<input type="hidden" name="h_ico" id="h_ico" value="<?php echo $hodn_ico;?>" />
<input type="hidden" name="h_str" id="h_str" value="<?php echo $hodn_str;?>" />
<input type="hidden" name="h_zak" id="h_zak" value="<?php echo $hodn_zak;?>" />
<input type="hidden" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>" />
<input type="hidden" name="zmen" id="zmen" value="<?php echo $riadok->zmen;?>" />
<input type="hidden" name="kurz" id="kurz" value="<?php echo $riadok->kurz;?>" />

<input class="hvstup" type="hidden" name="kdefoc" id="kdefoc" value="uce" />
<input class="hvstup" type="hidden" name="klikenter" id="klikenter" value="0" />
<?php
if ( $copern == 87 )
     {
?>
<input type="hidden" name="z_slu" id="z_dph" value="<?php echo $z_slu;?>" />
<input type="hidden" name="z_dph" id="z_dph" value="<?php echo $z_dph;?>" />
<input type="hidden" name="z_cep" id="z_cep" value="<?php echo $z_cep;?>" />
<input type="hidden" name="z_ced" id="z_ced" value="<?php echo $z_ced;?>" />
<input type="hidden" name="z_cen" id="z_cen" value="<?php echo $z_cen;?>" />
<input type="hidden" name="z_mno" id="z_mno" value="<?php echo $z_mno;?>" />
<?php
}
?>
</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" 
 onmouseover="UkazSkryj('Uloûiù poloûku do dokladu')" onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
<?php if( $itstablet == 1 )     {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko' >
<?php                           }  ?>
</td>
</FORM>
<td class="pvstup" ></td>
<?php
if ( $copern != 87 )
     {
?>
<FORM name="formh4" method="post" action="vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $h_uce; ?>&copern=1" >
<td class="pvstup" >
<INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('N·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';">
</td>
</FORM>
<?php
}
?>
<?php
if ( $copern == 87 )
     {
?>
<FORM name="formh4" method="post" action="vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=7&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>
<?php
if( $fir_xfa01 == 1 )
{
?>
&h_tlsl=1
<?php
}
?>
&cislo_dok=<?php echo $cislo_dok;?>" >
<td class="pvstup" >
<INPUT type="submit" id="stornou" name="stornou" value="Sp‰ù" align="right"
 onmouseover="UkazSkryj('Neupravovaù poloûku')" onmouseout="Okno.style.display='none';">
</td>
</FORM>
<?php
}
?>

<td class="pvstup" ></td>
<FORM name="forma4" method="post" action="vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $h_uce; ?>" >
<td class="pvstup" >
<?php
if ( $copern != 87 )
     {
?>
<INPUT type="submit" name="npol" id="npol" value="Doklad"
 onmouseover="UkazSkryj('Vytvoriù nov˝ doklad')" onmouseout="Okno.style.display='none';" >
<?php
}
?>
</td>
</FORM>

<?php
     }
//koniec vstupu poloziek sluzby 77777777777777777777
?>
<?php
// vstup text poloziek sluzby 1717171717171717
if ( $copern == 17 OR $copern == 97 )
     {
?>
<tr>
<FORM name="forms1" class="obyc" method="post" action="vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>
<?php
if ( $copern == 17 )
{
?>
&copern=77&cislo_dok=<?php echo $cislo_dok;?>" >
<td class="fmenu"><input type="text" name="h_cpl" id="h_cpl" size="5" /></td>
<?php
}
?>
<?php
if ( $copern == 97 )
{
?>
&copern=98&cislo_dok=<?php echo $cislo_dok;?>&cislo_cpl=<?php echo $z_cpl;?>" >
<td class="fmenu" >
<input type="text" name="h_cpl" id="h_cpl" size="5" style="background-color:lime; color:black;" value="<?php echo $z_cpl;?>" />
</td>
<?php
}
?>

<td class="fmenu" colspan="6">
<input type="text" name="h_pop" id="h_pop" size="100" maxlength="90" 
 onclick="ZhasniSP(); myDivElement.style.display='none';" 
 onKeyDown="return PopEnter(event.which)" />
</td>

<input type="hidden" name="h_fak" id="h_fak" value="<?php echo $h_fak;?>" />
<input type="hidden" name="h_dol" id="h_dol" value="<?php echo $h_dol;?>" />
<input type="hidden" name="h_prf" id="h_prf" value="<?php echo $h_prf;?>" />
<INPUT type="hidden" name="h_slu" value="0"></td>
<INPUT type="hidden" name="h_nsl" value=""></td>
<INPUT type="hidden" name="h_dph" value="0"></td>
<INPUT type="hidden" name="h_cep" value="0"></td>
<INPUT type="hidden" name="h_ced" value="0"></td>
<INPUT type="hidden" name="h_mno" value="0"></td>


<INPUT type="hidden" name="err_slu" value="0"></td>
<INPUT type="hidden" name="err_nsl" >
<INPUT type="hidden" name="err_cep" >
<INPUT type="hidden" name="err_ced" >
<INPUT type="hidden" name="err_mno" >
<input type="hidden" name="hlas" id="hlas" value="NIE" />


<td class="fmenu"><input type="text" name="h_mer" id="h_mer" size="3" onClick="return Povol_uloz();"
onKeyDown="return MerEnter(event.which)" />


<td class="fmenu"><input type="text" name="h_hdp" id="h_hdp" size="9" /></td>
<td class="fmenu"><input type="text" name="h_hdd" id="h_hdd" size="9" /></td>

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="3" /></td>
<input type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />

</tr>


<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" 
 onmouseover="UkazSkryj('Uloûiù poloûku do dokladu')" onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
<?php if( $itstablet == 1 )     {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko' >
<?php                           }  ?>
</td>
</FORM>
<td class="pvstup" ></td>
<?php
if ( $copern != 97 )
     {
?>
<FORM name="formh4" method="post" action="vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $h_uce; ?>&copern=1" >
<td class="pvstup" >
<INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('N·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';">
</td>
</FORM>
<?php
}
?>
<?php
if ( $copern == 97 )
     {
?>
<FORM name="formh4" method="post" action="vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=7&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&hladaj_uce=<?php echo $h_uce; ?>
&h_tlsl=<?php echo $h_tlsl;?>&h_tltv=<?php echo $h_tltv;?>
<?php
if( $fir_xfa01 == 1 )
{
?>
&h_tlsl=1
<?php
}
?>
&cislo_dok=<?php echo $cislo_dok;?>" >
<td class="pvstup" >
<INPUT type="submit" id="stornou" name="stornou" value="Sp‰ù" align="right"
 onmouseover="UkazSkryj('Neupravovaù poloûku')" onmouseout="Okno.style.display='none';">
</td>
</FORM>
<?php
}
?>

<td class="pvstup" ></td>
<FORM name="forma4" method="post" action="vstf_u.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $h_uce; ?>" >
<td class="pvstup" >
<?php
if ( $copern != 97 )
     {
?>
<INPUT type="submit" name="npol" id="npol" value="Doklad"
 onmouseover="UkazSkryj('Vytvoriù nov˝ doklad')" onmouseout="Okno.style.display='none';" >
<?php
}
?>
</td>
</FORM>
<?php
     }
?>
<?php if( $sysx == 'UCT' AND $kli_vduj >= 0 ) { ?>
<td class="pvstup" >
<td class="pvstup" >
<td class="pvstup" >
<?php
if ( $copern != 6 AND $_SESSION['nieie'] == 0 AND $pocstav == 0 )
     {
?>
<button id="uctovat" onclick="return UctovatPol();" 
 onmouseover="UkazSkryj('Za˙Ëtovaù DPH,trûby,n·klady dokladu')" onmouseout="Okno.style.display='none';">⁄Ëtovaù</button>
<?php
     }
?>
<?php
if ( $copern != 6 AND $_SESSION['nieie'] == 1 AND $pocstav == 0 )
     {
?>
<img src='../obr/tlacitka/uctovat.jpg' border="1" onclick="UctovatPol();" width="50" height="16" title="⁄Ëtovaù" >
<?php
     }
?>


</td>
<?php                                         } ?>
<?php
//koniec vstupu text poloziek sluzby 171717171717
?>

</table>
<div id="myDivElement"></div>

<table class="vstup" width="100%">
<tr></tr><tr></tr>

<tr>
<td class="pvstup" width="10%" >&nbsp;
<?php
if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 42 ) AND $sysx != 'UCT' )
     {
?>
<?php if( $drupoh == 1 ) { ?>
<a href="#" onClick="window.open('vstf_import.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $hladaj_uce; ?>', '_self', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/import.png' width=15 height=15 border=0 alt="NaËÌtaù poloûky fakt˙ry z CSV cis;nat;dph;cep;ced;mno;mer" title="NaËÌtaù poloûky fakt˙ry z CSV cis;nat;dph;cep;ced;mno;mer" ></a>
&nbsp&nbsp&nbsp
<?php                    } ?>
<img src='../obr/naradie.png' onClick="nastavfakx.style.display=''; volajFakset(<?php echo $kli_uzid;?>, <?php echo $cislo_dok;?>);" width=15 height=15 border=0 title="Nastaviù parametre fakt˙ry" ></a>
<?php if( $drupoh == 1 ) { ?>
&nbsp&nbsp&nbsp
<img src='../obr/auta/auto3.jpg' onClick="nastavpex.style.display=''; volajVyvozsetx(<?php echo $kli_uzid;?>);" width=20 height=15 border=0 title="VytlaËiù potvrdenie o v˝voze tovaru" ></a>

<?php                    } ?>
<?php if( $drupoh == 1 ) { ?>
&nbsp&nbsp&nbsp
<a href="#" onClick="window.open('vstf_exportxml.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>&hladaj_uce=<?php echo $hladaj_uce; ?>', '_blank', '_blank'
, 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/export.png' width=15 height=15 border=0 title="Export fakt˙ry do XML" ></a>
<?php                    } ?>
<?php if( $drupoh == 42 ) { ?>
&nbsp&nbsp&nbsp
<a href="#" onClick="window.open('fak_setuloz.php?drupoh=<?php echo $drupoh; ?>&cislo_dok=<?php echo $cislo_dok; ?>&copern=707', '_self' );">
<img src='../obr/banky/euro.jpg' width=15 height=15 border=0 title="Platba kartou" ></a>
&nbsp&nbsp&nbsp
<?php                    } ?>
<?php
     }
?>

</td>

<td class="pvstup" width="10%" >&nbsp;
<?php
if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 42 ) AND $sysx != 'UCT' )
     {
?>
<?php if( $drupoh == 1 ) { ?>
&nbsp&nbsp&nbsp
<a href="#" onClick="window.open('fak_prendph.php?drupoh=<?php echo $drupoh; ?>&cislo_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>&copern=900&zlava=1', '_self' )">
<img src='../obr/vlozit.png' width=15 height=15 border=0 title="PrepoËet Prenosu daÚovej povinnosti" ></a>

&nbsp&nbsp&nbsp
<a href="#" onClick="window.open('uhradfak_erp.php?drupoh=<?php echo $drupoh; ?>&kopia_dok=<?php echo $cislo_dok; ?>&drupoh=<?php echo $drupoh; ?>&copern=20', '_self' )">
<img src='../obr/banky/euro.jpg' width=15 height=15 border=0 title="⁄hrada fakt˙ry <?php echo $cislo_dok; ?> cez ERP" ></a>
<?php                    } ?>
<?php
     }
?>

</td>
<td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Sadzba DPH</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Z·klad</td>
<td class="pvstup" width="10%" align="right" >&nbsp;DaÚ</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Spolu</td>
</tr>

<FORM name="formx1" class="obyc" method="post" action="#" >
<tr>
<td class="pvstup" colspan="6" >&nbsp;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
<input type="checkbox" name="h_razitko" value="1" /> peËiatka
<?php
if ( $peciatkaano == 1 )
   {
?>
<script type="text/javascript">
document.formx1.h_razitko.checked = "checked";
</script>
<?php
   }
?> 
<?php
     }
?>
</td>
<td class="hvstup" align="right" ><?php echo $fir_dph1; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->zk1; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->dn1; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->sp1; ?></td>
</tr>
<tr>
<td class="pvstup" colspan="6" >&nbsp;
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
<input type='text' name='h_pocpol' id='h_pocpol' size='1' value='20' > poloûiek na 1.strane
<?php
     }

?>

<?php
if ( $copern == 7 AND $drupoh == 31 AND $sysx != 'UCT' )
     {
?>
<a href="#" onClick="window.open('../faktury/set_danpren.php?copern=<?php echo $copern;?>&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&cislo_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/pozor.png' width=15 height=15 border=0 title="Nastav prenos daÚovej povinnosti" ></a>
<?php
     }

?>

</td>
<td class="hvstup" align="right" ><?php echo $fir_dph2; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->zk2; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->dn2; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->sp2; ?></td>
</tr>
<tr>
<td class="pvstup" colspan="6" >&nbsp;
<?php
if ( $copern == 7 AND ( $drupoh == 21 OR $drupoh == 42 ) )
     {
?>
<input type="hidden" name="h_sz4x" value="0" >
<?php
     }
?>
<?php
if ( $copern == 7 AND ( $drupoh == 1 OR $drupoh == 11 ) AND $sysx != 'UCT' )
     {

$pocetcen=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcisudaje WHERE cep01 > 0 ");
if($sqldok) {  $pocetcen = 1*mysql_num_rows($sqldok); }
if( $h_tltv == 0 ) { $pocetcen=0; }
if ( $pocetcen == 0 ) {
?>
<input type="hidden" name="h_sz4x" value="0" >
<?php
                      }
if ( $pocetcen > 0 )  {
$cencis=1*$riadok->sz4;
?>

<select class="hvstup" size="1" name="h_sz4x" id="h_sz4x" >
<option value="0" >CennÌk 0</option>
<option value="1" >CennÌk 1</option>
<option value="2" >CennÌk 2</option>
<option value="3" >CennÌk 3</option>
<option value="4" >CennÌk 4</option>
</select>
<img src='../obr/ok.png' onClick="NastavCennik();" width=15 height=15 border=0 title="Nastaviù cennÌk" >

<script type='text/javascript'>
function NastavCennik()
                {              

  var h_sz4x = document.formx1.h_sz4x.value;

  window.open('nastavcennik.php?h_sz4x=' + h_sz4x + '&copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>', '_self' );

                }

document.formx1.h_sz4x.value=<?php echo $cencis;?>;
</script>

<?php
                      }
     }
?>
<td class="hvstup" align="right" >0</td>
<td class="hvstup" align="right" ><?php echo $riadok->zk0; ?></td>
<td class="hvstup" align="right" ></td>
<td class="hvstup" align="right" ><?php echo $riadok->zk0; ?></td>
</tr>

<tr>
<td class="pvstup" colspan="9" align="right" >&nbsp;Zaokr˙hlenie:</td>
<td class="hvstup" align="right" colspan="1" ><?php echo $riadok->zao; ?></td>
</tr>

<tr>
<td class="pvstup" colspan="9" align="right" >&nbsp;Celkom hodnota dokladu:</td>
<td class="hvstup" align="right" colspan="1" ><?php echo $riadok->hod; ?> <?php echo $fir_mena1; ?></td>
</FORM>
</tr>
<?php
if( $riadok->zmen == 1 )
    {
//cudzia mena
?>
<tr>
<td class="pvstup" colspan="9" align="right" >&nbsp;Celkom hodnota v cudzej mene:</td>
<td class="hvstup" align="right" colspan="1" ><?php echo $riadok->hodm; ?> <?php echo $riadok->mena; ?></td>
</tr>
<?php
    }
?>

<?php
if ( $pocstav == 1 )
     {
?>
<tr>
<td class="pvstup" colspan="9" align="right" >&nbsp;UhradenÈ:</td>
<td class="hvstup" align="right" colspan="1" ><?php echo $riadok->uhr; ?></td>
</tr>
<?php
     }
?>

<?php
$czal=1*$riadok->zal;
if ( $czal != 0 )
     {
?>
<tr>
<td class="pvstup" colspan="9" align="right" >&nbsp;Zaplaten· z·loha:</td>
<td class="hvstup" align="right" colspan="1" ><?php echo $riadok->zal; ?></td>
</tr>
<?php
     }
?>

<tr></tr><tr></tr>
</table>

<table class="vstup" width="100%">
<tr>
<?php
$vypis_txz = ereg_replace("\n", "<br>", trim($riadok->txz));
$vypis_txz = ereg_replace(" ", "&nbsp;", trim($vypis_txz));
?>
<td class="hvstup" width="100%" >
<?php
if ( $copern == 7 AND $drupoh == 1 AND $sysx != 'UCT' )
     {
?>
<img src='../obr/uprav.png' width=12 height=12 border=1 onClick="RozniPenz(2);" title="Upraviù text za poloûkami fakt˙ry" >
<?php
     }
?>

<?php echo $vypis_txz; ?></td></table>

<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="15%" >&nbsp;Pozn·mka:</td>
<td class="hvstup" width="55%" ><?php echo $riadok->poz; ?></td>
<td class="pvstup" width="25%" >&nbsp;(Nebude vytlaËen· na doklade)</td><td class="pvstup" width="5%" >&nbsp;</td>
</tr>
</table>

<?php 
//[[[[[[[[[[[[66666666666666666vymazanie
if ( $copern == 6 )
     {
?>
<table class="vstup" width="100%">
<FORM name="formv2" class="obyc" method="post" action="vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $hladaj_ucex; ?>
&copern=16&cislo_dok=<?php echo $riadok->dok;?>&cislo_fak=<?php echo $riadok->fak;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="Vymazaù" 
 onmouseover="UkazSkryj('Vymazaù vybran˝ doklad')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="vstfak.php?regpok=<?php echo $regpok; ?>&vyroba=<?php echo $vyroba; ?>&drupoh=<?php echo $drupoh;?>&page=1&hladaj_uce=<?php echo $hladaj_ucex; ?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno" 
 onmouseover="UkazSkryj('Nevymazaù vybran˝ doklad , n·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
</table>
<?php 
     }
?>

<?php
  }
$j = $j + 1;
   }
?>


<?php
// toto je koniec vymazanie faktury copern=6 a sluzby copern=7 
     }
?>


<?php
$robot=1;
if( $sys != 'DOP' ) $cislista = include("fak_lista.php");
if( $sys == 'DOP' ) $cislista = include("../doprava/dop_lista.php");
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
