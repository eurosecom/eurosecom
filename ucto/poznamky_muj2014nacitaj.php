<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$zobrat = 1*$_REQUEST['zobrat'];
$zsuva = 1*$_REQUEST['zsuva'];
$zvysl = 1*$_REQUEST['zvysl'];
$strana = 1*$_REQUEST['strana'];

$citfir = include("../cis/citaj_fir.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


$dopoz = 1*$_REQUEST['dopoz'];

if( $zobrat == 1 ) { $copern=300; }
if( $zsuva == 1 ) { $copern=400; }
if( $zvysl == 1 ) { $copern=500; }

$h_ycf=0;
if( $fir_allx11 > 0 ) { $h_ycf=1*$fir_allx11; }

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");


//kontrola ci su poznamky inicializovane
if( $copern != 901 )
{
$sql = "SELECT * FROM F".$kli_vxcf."_poznamky_muj2014 ";
$vysledok = mysql_query("$sql");
if (!$vysledok) { echo "<br /><br />Nemáte inicializované Poznámky MUJ, najprv 1x vojdite do úpravy Poznámok MUJ."; exit; }

}
//koniec kontrola ci su poznamky inicializovane

//copern=999 minuly rok z poznamok firmy min.roka 1999 po stranach z uprav
$postranach=0;
if( $copern == 1999 ) { $copern=999; $postranach=1; }
if( $copern == 999 )
{
$stranax = 1*$_REQUEST['stranax'];

$sql = "SELECT * FROM ".$databaza."F".$h_ycf."_poznamky_po2011 ";
$vysledok = mysql_query("$sql");
if (!$vysledok) { echo "Vo firme è.$h_ycf nie sú poznámky v.2011, program nenaèíta hodnoty bezprostredne predchádzajúceho obdobia."; exit; }

//str1 pocet zamestnancov 
if( $stranax == 0 OR $stranax == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014,".$databaza."F".$h_ycf."_poznamky_po2011 SET ".
" F$kli_vxcf"."_poznamky_muj2014.ac12=".$databaza."F".$h_ycf."_poznamky_po2011.ac11, ".
" F$kli_vxcf"."_poznamky_muj2014.ac22=".$databaza."F".$h_ycf."_poznamky_po2011.ac21, ".
" F$kli_vxcf"."_poznamky_muj2014.ac32=".$databaza."F".$h_ycf."_poznamky_po2011.ac31  ".
" WHERE F$kli_vxcf"."_poznamky_muj2014.psys=".$databaza."F".$h_ycf."_poznamky_po2011.psys "; 

$upravene = mysql_query("$uprtxt"); 
  }

//str3 zavazky, vlastne akcie 
if( $stranax == 0 OR $stranax == 3 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_muj2014.gcd12=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd11, ".
" F$kli_vxcf"."_poznamky_muj2014.gcd22=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd21, ".
" F$kli_vxcf"."_poznamky_muj2014.gcd32=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd31, ".
" F$kli_vxcf"."_poznamky_muj2014.gcd42=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd41, ".
" F$kli_vxcf"."_poznamky_muj2014.gcd52=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd51, ".
" F$kli_vxcf"."_poznamky_muj2014.gcd62=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd61  ".

" WHERE F$kli_vxcf"."_poznamky_muj2014.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_muj2014.gh11=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh11, ".
" F$kli_vxcf"."_poznamky_muj2014.gh12=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh12, ".
" F$kli_vxcf"."_poznamky_muj2014.gh13=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh13, ".
" F$kli_vxcf"."_poznamky_muj2014.gh14=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh14, ".
" F$kli_vxcf"."_poznamky_muj2014.gh15=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh15, ".
" F$kli_vxcf"."_poznamky_muj2014.gh16=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh16, ".

" F$kli_vxcf"."_poznamky_muj2014.gh21=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh21, ".
" F$kli_vxcf"."_poznamky_muj2014.gh22=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh22, ".
" F$kli_vxcf"."_poznamky_muj2014.gh23=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh23, ".
" F$kli_vxcf"."_poznamky_muj2014.gh24=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh24, ".
" F$kli_vxcf"."_poznamky_muj2014.gh25=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh25, ".
" F$kli_vxcf"."_poznamky_muj2014.gh26=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh26, ".

" F$kli_vxcf"."_poznamky_muj2014.gh31=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh31, ".
" F$kli_vxcf"."_poznamky_muj2014.gh32=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh32, ".
" F$kli_vxcf"."_poznamky_muj2014.gh33=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh33, ".
" F$kli_vxcf"."_poznamky_muj2014.gh34=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh34, ".
" F$kli_vxcf"."_poznamky_muj2014.gh35=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh35, ".
" F$kli_vxcf"."_poznamky_muj2014.gh36=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh36, ".

" F$kli_vxcf"."_poznamky_muj2014.gh41=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh41, ".
" F$kli_vxcf"."_poznamky_muj2014.gh42=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh42, ".
" F$kli_vxcf"."_poznamky_muj2014.gh43=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh43, ".
" F$kli_vxcf"."_poznamky_muj2014.gh44=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh44, ".
" F$kli_vxcf"."_poznamky_muj2014.gh45=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh45, ".
" F$kli_vxcf"."_poznamky_muj2014.gh46=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh46  ".

" WHERE F$kli_vxcf"."_poznamky_muj2014.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 
  }

//str4 statutary 
if( $stranax == 0 OR $stranax == 4 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_muj2014.m23c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m13c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m22c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m12c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m21c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m11c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m23b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m13b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m22b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m12b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m21b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m11b,  ".

" F$kli_vxcf"."_poznamky_muj2014.m43c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m33c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m42c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m32c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m41c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m31c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m43b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m33b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m42b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m32b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m41b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m31b,  ".

" F$kli_vxcf"."_poznamky_muj2014.m63c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m53c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m62c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m52c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m61c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m51c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m63b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m53b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m62b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m52b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m61b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m51b,  ".

" F$kli_vxcf"."_poznamky_muj2014.m83c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m73c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m82c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m72c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m81c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m71c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m83b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m73b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m82b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m72b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m81b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m71b,  ".

" F$kli_vxcf"."_poznamky_muj2014.m103c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m93c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m102c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m92c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m101c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m91c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m103b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m93b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m102b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m92b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m101b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m91b,  ".

" F$kli_vxcf"."_poznamky_muj2014.m123c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m113c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m122c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m112c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m121c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m111c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m123b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m113b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m122b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m112b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m121b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m111b,  ".

" F$kli_vxcf"."_poznamky_muj2014.m143c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m133c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m142c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m132c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m141c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m131c,  ".
" F$kli_vxcf"."_poznamky_muj2014.m143b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m133b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m142b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m132b,  ".
" F$kli_vxcf"."_poznamky_muj2014.m141b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m131b   ".

" WHERE F$kli_vxcf"."_poznamky_muj2014.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 
  }

//str5 podmienene zavazky a majetok
if( $stranax == 0 OR $stranax == 5 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_muj2014.k12=".$databaza."F".$h_ycf."_poznamky_po2011s3.k11, ".
" F$kli_vxcf"."_poznamky_muj2014.k22=".$databaza."F".$h_ycf."_poznamky_po2011s3.k21, ".
" F$kli_vxcf"."_poznamky_muj2014.k32=".$databaza."F".$h_ycf."_poznamky_po2011s3.k31, ".
" F$kli_vxcf"."_poznamky_muj2014.k42=".$databaza."F".$h_ycf."_poznamky_po2011s3.k41, ".
" F$kli_vxcf"."_poznamky_muj2014.k52=".$databaza."F".$h_ycf."_poznamky_po2011s3.k51, ".
" F$kli_vxcf"."_poznamky_muj2014.k62=".$databaza."F".$h_ycf."_poznamky_po2011s3.k61, ".
" F$kli_vxcf"."_poznamky_muj2014.k72=".$databaza."F".$h_ycf."_poznamky_po2011s3.k71, ".
" F$kli_vxcf"."_poznamky_muj2014.k82=".$databaza."F".$h_ycf."_poznamky_po2011s3.k81, ".
" F$kli_vxcf"."_poznamky_muj2014.k92=".$databaza."F".$h_ycf."_poznamky_po2011s3.k91  ".

" WHERE F$kli_vxcf"."_poznamky_muj2014.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_muj2014.l2ab11=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab11, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab21=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab21, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab31=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab31, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab41=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab41, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab51=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab51, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab61=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab61, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab12=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab12, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab22=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab22, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab32=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab32, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab42=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab42, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab52=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab52, ".
" F$kli_vxcf"."_poznamky_muj2014.l2ab62=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab62  ".

" WHERE F$kli_vxcf"."_poznamky_muj2014.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_muj2014.lc12=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc11, ".
" F$kli_vxcf"."_poznamky_muj2014.lc22=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc21, ".
" F$kli_vxcf"."_poznamky_muj2014.lc32=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc31, ".
" F$kli_vxcf"."_poznamky_muj2014.lc42=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc41, ".
" F$kli_vxcf"."_poznamky_muj2014.lc52=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc51, ".
" F$kli_vxcf"."_poznamky_muj2014.lc62=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc61, ".
" F$kli_vxcf"."_poznamky_muj2014.lc72=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc71, ".
" F$kli_vxcf"."_poznamky_muj2014.lc82=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc81  ".

" WHERE F$kli_vxcf"."_poznamky_muj2014.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");
 
  }

}
//koniec copern=999 minuly rok z poznamok firmy min.roka


//kontrola ci je subor
if( $copern == 402 )
{
$sql = "SELECT * FROM F".$kli_vxcf."_prcstatr101$kli_uzid ";
$vysledok = mysql_query("$sql");
if (!$vysledok) { echo "<br /><br />Nemáte vytvorený súbor pre naèítanie, 1x kliknite na tlaèítko Súbor v Naèítaní údajov do Poznámok MUJ."; exit; }

}
//koniec kontrola ci je subor

// copern=402 zavazky
if( $copern == 402 )
{

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" gcd11=0, gcd21=0, gcd31=0, gcd41=0, gcd51=0, gcd61=0, ".
" gcd12=0, gcd22=0, gcd32=0, gcd42=0, gcd52=0, gcd62=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

//_prsaldoicofak38`saldo
$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 12 )
  {

$hod=0; $pri=0; $uby=0;

if( $nacitaj ==  1 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 321 OR LEFT(ucm,3) = 322 OR LEFT(ucm,3) = 323 OR LEFT(ucm,3) = 324 OR LEFT(ucm,3) = 325 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 321 OR LEFT(ucd,3) = 322 OR LEFT(ucd,3) = 323 OR LEFT(ucd,3) = 324 OR LEFT(ucd,3) = 325 )"; }
if( $nacitaj ==  2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 361 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 361 )"; }
if( $nacitaj ==  3 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 364 OR LEFT(ucm,3) = 365 OR LEFT(ucm,3) = 366 OR LEFT(ucm,3) = 367 OR LEFT(ucm,3) = 368 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 364 OR LEFT(ucd,3) = 365 OR LEFT(ucd,3) = 366 OR LEFT(ucd,3) = 367 OR LEFT(ucd,3) = 368 )"; }
if( $nacitaj ==  4 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 336 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 336 )"; }
if( $nacitaj ==  5 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 372 OR LEFT(ucm,3) = 377 OR LEFT(ucm,3) = 379 OR LEFT(ucm,3) = 331 OR LEFT(ucm,3) = 333 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 372 OR LEFT(ucd,3) = 377 OR LEFT(ucd,3) = 379 OR LEFT(ucd,3) = 331 OR LEFT(ucd,3) = 333 )"; }

if( $nacitaj ==  6 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 341 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 341 )"; }
if( $nacitaj ==  7 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 342 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 342 )"; }
if( $nacitaj ==  8 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 343 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 343 )"; }
if( $nacitaj ==  9 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 345 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 345 )"; }
if( $nacitaj == 10 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 346 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 346 )"; }
if( $nacitaj == 11 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 347 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 347 )"; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod-$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod+$polozka->hod; }
}
$i=$i+1;                   }


if( $nacitaj == 4 OR $nacitaj == 6 OR $nacitaj == 7 OR $nacitaj == 8 OR $nacitaj == 9 OR $nacitaj == 10 OR $nacitaj == 11 ) 
{
if( $hod < 0 ) { $hod=0; }
}

if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
//echo $uprtxt."<br />";
  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$konrok=$kli_vrok."-12-31";
$uprtxt = "UPDATE F$kli_vxcf"."_prsaldoicofak$kli_uzid SET puc=TO_DAYS('$konrok')-TO_DAYS(das) ";
$upravene = mysql_query("$uprtxt"); 

$podm="puc > 0 AND ( LEFT(uce,3) = 321 OR LEFT(uce,3) = 325 OR LEFT(uce,3) = 379 )"; 

$posplt1=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid WHERE $podm "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$posplt1=$posplt1+$polozka->zos;
}
$i=$i+1;                   }



if( $posplt1 < 0 ) $posplt1=0;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd11='$posplt1'   WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 



$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" gcd21=gcd31-gcd11 ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 


  }

if( $pocet == 2 )
  {
$kli_vrom=$kli_vrok-1;
$konrok=$kli_vrom."-12-31";
$uprtxt = "UPDATE ".$databaza."F$h_ycf"."_prsaldoicofak$kli_uzid SET puc=TO_DAYS('$konrok')-TO_DAYS(das) ";
$upravene = mysql_query("$uprtxt");  

$podm="puc > 0 AND ( LEFT(uce,3) = 321 OR LEFT(uce,3) = 325 OR LEFT(uce,3) = 379 )"; 

$posplt1=0;
$sqltt = "SELECT * FROM ".$databaza."F$h_ycf"."_prsaldoicofak$kli_uzid WHERE $podm ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$posplt1=$posplt1+$polozka->zos;
}
$i=$i+1;                   }


if( $posplt1 < 0 ) $posplt1=0;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET gcd12='$posplt1'   WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" gcd22=gcd32-gcd12 ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

$pocet=$pocet+1;
    }
//exit;
}
//koniec copern=402 zavazky



//copern=901 subor
if( $copern == 901 )
{

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcstatr101'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcstatr101min'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcuobrats
(
   psys         INT,
   uro          INT(8),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   ico          DECIMAL(10,0),
   hod          DECIMAL(12,2)
);
prcuobrats;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcstatr101'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcstatr101min'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//bezny rok
//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101$kli_uzid"." SELECT".
" 1,0,uce,0,0,pmd ".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101$kli_uzid"." SELECT".
" 1,0,0,uce,0,pda ".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0";
$dsql = mysql_query("$dsqlt");

$psys=1;
 while ($psys <= 9 ) 
 {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="xxxxxxxxx"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; }
//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 9 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101$kli_uzid"." SELECT ".
" 2,0,F$kli_vxcf"."_$uctovanie.ucm,F$kli_vxcf"."_$uctovanie.ucd,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.hod ".
" FROM F$kli_vxcf"."_$uctovanie ".
" WHERE F$kli_vxcf"."_$uctovanie.hod != 0";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

}

else
{

}

$psys=$psys+1;
  }

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101$kli_uzid"." SELECT".
" psys,1,ucm,ucd,ico,SUM(hod) ".
" FROM F$kli_vxcf"."_prcstatr101$kli_uzid ".
" GROUP BY psys,ucm,ucd,ico ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcstatr101$kli_uzid"." WHERE uro != 1 ";
$dsql = mysql_query("$dsqlt");
//koniec bezny rok

//minuly rok
//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101min$kli_uzid"." SELECT".
" 1,0,uce,0,0,pmd ".
" FROM ".$databaza."F".$h_ycf."_uctosnova".
" WHERE ".$databaza."F".$h_ycf."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101min$kli_uzid"." SELECT".
" 1,0,0,uce,0,pda ".
" FROM ".$databaza."F".$h_ycf."_uctosnova".
" WHERE ".$databaza."F".$h_ycf."_uctosnova.pda != 0";
$dsql = mysql_query("$dsqlt");

$psys=1;
 while ($psys <= 9 ) 
 {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="xxxxxxxxx"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; }
//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 9 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101min$kli_uzid"." SELECT ".
" 2,0,".$databaza."F".$h_ycf."_$uctovanie.ucm,".$databaza."F".$h_ycf."_$uctovanie.ucd,".$databaza."F".$h_ycf."_$uctovanie.ico,".$databaza."F".$h_ycf."_$uctovanie.hod ".
" FROM ".$databaza."F".$h_ycf."_$uctovanie ".
" WHERE ".$databaza."F".$h_ycf."_$uctovanie.hod != 0";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

}

else
{

}

$psys=$psys+1;
  }

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101min$kli_uzid"." SELECT".
" psys,1,ucm,ucd,ico,SUM(hod) ".
" FROM F$kli_vxcf"."_prcstatr101min$kli_uzid ".
" GROUP BY psys,ucm,ucd,ico ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcstatr101min$kli_uzid"." WHERE uro != 1 ";
$dsql = mysql_query("$dsqlt");
//koniec minuly rok

}
//koniec copern=901 subor



//zapis UDAJE Z MIEZD
if( $copern == 200 )
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statprac
(
   drh          DECIMAL(3,0) DEFAULT 0,
   oc           INT(5),
   ume          DECIMAL(7,4) DEFAULT 0,
   rodc         VARCHAR(6),
   zena         INT(1),
   pom          DECIMAL(3,0) DEFAULT 0,
   dhpom        DECIMAL(3,0) DEFAULT 0,
   pocet        DECIMAL(10,0) DEFAULT 0,
   dm           INT(5),
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   ico          DECIMAL(8,0),
   uvap         DECIMAL(10,2) DEFAULT 0,
   uvax         DECIMAL(10,2) DEFAULT 0,
   skrat        DECIMAL(3,0) DEFAULT 0
);
statprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statprac'.$sqlt;
$vytvor = mysql_query("$vsql");

//pocet zamestnancov
$pokus=1;
while( $pokus < 3 )
    {
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_statprac ';
$vytvor = mysql_query("$vsql");


if( $pokus == 1 ) 
{
$h_mfir = 1*strip_tags($_REQUEST['h_mfir']);
$vyb_ume = strip_tags($_REQUEST['vyb_ume']);
$vyb_ump="1.".$kli_vrok;
$vyb_umk="12.".$kli_vrok;
$kli_vrokx=$kli_vrok;
$databazax="";
$kli_vxcfx=$h_mfir;
}
if( $pokus == 2 ) 
{
$kli_vrokmin=$kli_vrok-1;
$vyb_ump="1.".$kli_vrokmin;
$vyb_umk="12.".$kli_vrokmin;
$kli_vrokx=$kli_vrokmin;
$databazax=$databaza;
$kli_vxcfx=$h_ycf;
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,rdc,0,pom,0,1, ".
"0,0,0,0,$fir_fico,0,uva,0 ".
" FROM ".$databazax."F".$kli_vxcfx."_mzdzalkun".
" WHERE pom != 9 AND ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt;
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,".$databazax."F".$kli_vxcfx."_mzdpomer SET ".
" dhpom=pm_doh, zena=SUBSTRING(rodc,3,2) ".
" WHERE F$kli_vxcf"."_statprac.pom = ".$databazax."F".$kli_vxcfx."_mzdpomer.pm"; 
$upravene = mysql_query("$uprtxt");  

/////////////NACITANIE prac.uvazku standartneho
$sqldok = mysql_query("SELECT * FROM ".$databazax."F".$kli_vxcfx."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uva_hod=$riaddok->uva_hod;
  }

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET uvap=uvax/$uva_hod ";
$upravene = mysql_query("$uprtxt");  

$uprtxt = "UPDATE F$kli_vxcf"."_statprac SET skrat=1 WHERE uvap < 0.8 AND uvax < $uva_hod";
$upravene = mysql_query("$uprtxt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 999,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,$fir_fico,uvap,0,skrat".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom >= 0".
" GROUP BY ume,dhpom";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 998,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,$fir_fico,uvap,0,skrat".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom = 1".
" GROUP BY oc";
$dsql = mysql_query("$dsqlt");

//pocet zamestnancov

$r02=0; $r02m1=0; $r02m2=0; $r02m3=0; $r02m4=0; $r02m5=0; $r02m6=0; $r02m7=0; $r02m8=0; $r02m9=0; $r02m10=0; $r02m11=0; $r02m12=0; 
$r03=0; $r04=0; $r07=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 1.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m1=$r02m1+$polozka->pocet; }
$i=$i+1;                   }

//echo $r02m1;
//exit;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 2.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m2=$r02m2+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 3.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m3=$r02m3+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 4.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m4=$r02m4+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 5.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m5=$r02m5+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 6.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m6=$r02m6+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 7.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m7=$r02m7+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 8.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m8=$r02m8+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 9.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m9=$r02m9+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 10.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m10=$r02m10+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 11.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m11=$r02m11+$polozka->pocet; }
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 12.".$kli_vrokx." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02m12=$r02m12+$polozka->pocet; }
$i=$i+1;                   }

$r02=($r02m1+$r02m2+$r02m3+$r02m4+$r02m5+$r02m6+$r02m7+$r02m8+$r02m9+$r02m10+$r02m11+$r02m12)/12;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND zena > 12 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+1; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND dhpom = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+1; }
$i=$i+1;                   }


$r01=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND dhpom = 0 AND ume = 12.".$kli_vrokx." ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+($polozka->pocet); }
$i=$i+1;                   }



if( $pokus == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" ac11='$r02', ac21='$r01', ".
" psys=0 ".
" WHERE psys >= 0"; 
  }
if( $pokus == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" ac12='$r02', ac22='$r01', ".
" psys=0 ".
" WHERE psys >= 0"; 
  }
$upravene = mysql_query("$uprtxt");  

//echo $uprtxt;
//exit;

$pokus=$pokus+1;
    }
//koniec while pocet zamestnancov

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statprac';
$vytvor = mysql_query("$vsql");

//exit;
}
//koniec copern=200 nacitaj z miezd UDAJE Z MIEZD

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Poznámky MUJ 2014 nacitaj</title>
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

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    



</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom Poznámky MUJ v.2014 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />





<?php

//prepni do poznamok
$cstat=10101;
$strana=1;

if( $copern == 200 ) { $strana=1; $cstat=20101; }
if( $copern == 402 ) { $strana=3; $cstat=20101; }

if( $dopoz == 1 ) { $cstat=10101; }
if( $copern == 900 ) { $strana = 1*$_REQUEST['strana']; $cstat=20101; }
if( $copern == 999 AND $postranach == 0 ) { $strana = 1*$_REQUEST['strana']; $cstat=10101; }
if( $copern == 999 AND $postranach == 1 ) { $strana = 1*$stranax; $cstat=20101; }

if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../ucto/poznamky_muj2014tlac.php?copern=1&drupoh=1&page=1&strana=<?php echo $strana; ?>&dopoz=1', '_self' )

</script>
<?php
exit;
}
if( $cstat == 20101 )
{
?>
<script type="text/javascript">

window.open('../ucto/poznamky_muj2014.php?copern=1&drupoh=1&page=<?php echo $strana; ?>&strana=<?php echo $strana; ?>', '_self' )

</script>
<?php
exit;
}
//koniec prepni do vykazu r101

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
