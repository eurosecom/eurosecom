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

//copern=999 minuly rok z poznamok firmy min.roka 1999 po stranach z uprav
$postranach=0;
if( $copern == 1999 ) { $copern=999; $postranach=1; }
if( $copern == 999 )
{
$stranax = 1*$_REQUEST['stranax'];

$sql = "SELECT * FROM ".$databaza."F".$h_ycf."_poznamky_po2011 ";
$vysledok = mysql_query("$sql");
if (!$vysledok) { echo "Vo firme è.$h_ycf nie sú poznámky v.2011, program nenaèíta hodnoty bezprostredne predchádzajúceho obdobia."; exit; }

//str uvod,1,2 
if( $stranax == 0 OR $stranax == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011,".$databaza."F".$h_ycf."_poznamky_po2011 SET ".
" F$kli_vxcf"."_poznamky_po2011.aa2=".$databaza."F".$h_ycf."_poznamky_po2011.aa2, ".

" F$kli_vxcf"."_poznamky_po2011.bb21a=".$databaza."F".$h_ycf."_poznamky_po2011.bb21a, ".
" F$kli_vxcf"."_poznamky_po2011.bb21b=".$databaza."F".$h_ycf."_poznamky_po2011.bb21b, ".
" F$kli_vxcf"."_poznamky_po2011.bb21c=".$databaza."F".$h_ycf."_poznamky_po2011.bb21c, ".
" F$kli_vxcf"."_poznamky_po2011.bb21d=".$databaza."F".$h_ycf."_poznamky_po2011.bb21d, ".
" F$kli_vxcf"."_poznamky_po2011.bb21e=".$databaza."F".$h_ycf."_poznamky_po2011.bb21e, ".
" F$kli_vxcf"."_poznamky_po2011.bb21f=".$databaza."F".$h_ycf."_poznamky_po2011.bb21f, ".

" F$kli_vxcf"."_poznamky_po2011.bb22a=".$databaza."F".$h_ycf."_poznamky_po2011.bb22a, ".
" F$kli_vxcf"."_poznamky_po2011.bb22b=".$databaza."F".$h_ycf."_poznamky_po2011.bb22b, ".
" F$kli_vxcf"."_poznamky_po2011.bb22c=".$databaza."F".$h_ycf."_poznamky_po2011.bb22c, ".
" F$kli_vxcf"."_poznamky_po2011.bb22d=".$databaza."F".$h_ycf."_poznamky_po2011.bb22d, ".
" F$kli_vxcf"."_poznamky_po2011.bb22e=".$databaza."F".$h_ycf."_poznamky_po2011.bb22e, ".
" F$kli_vxcf"."_poznamky_po2011.bb22f=".$databaza."F".$h_ycf."_poznamky_po2011.bb22f, ".

" F$kli_vxcf"."_poznamky_po2011.bb23a=".$databaza."F".$h_ycf."_poznamky_po2011.bb23a, ".
" F$kli_vxcf"."_poznamky_po2011.bb23b=".$databaza."F".$h_ycf."_poznamky_po2011.bb23b, ".
" F$kli_vxcf"."_poznamky_po2011.bb23c=".$databaza."F".$h_ycf."_poznamky_po2011.bb23c, ".
" F$kli_vxcf"."_poznamky_po2011.bb23d=".$databaza."F".$h_ycf."_poznamky_po2011.bb23d, ".
" F$kli_vxcf"."_poznamky_po2011.bb23e=".$databaza."F".$h_ycf."_poznamky_po2011.bb23e, ".
" F$kli_vxcf"."_poznamky_po2011.bb23f=".$databaza."F".$h_ycf."_poznamky_po2011.bb23f, ".

" F$kli_vxcf"."_poznamky_po2011.bb299c=".$databaza."F".$h_ycf."_poznamky_po2011.bb299c, ".
" F$kli_vxcf"."_poznamky_po2011.bb299d=".$databaza."F".$h_ycf."_poznamky_po2011.bb299d, ".
" F$kli_vxcf"."_poznamky_po2011.bb299e=".$databaza."F".$h_ycf."_poznamky_po2011.bb299e, ".
" F$kli_vxcf"."_poznamky_po2011.bb299f=".$databaza."F".$h_ycf."_poznamky_po2011.bb299f, ".

" F$kli_vxcf"."_poznamky_po2011.bb11a=".$databaza."F".$h_ycf."_poznamky_po2011.bb11a, ".
" F$kli_vxcf"."_poznamky_po2011.bb11b=".$databaza."F".$h_ycf."_poznamky_po2011.bb11b, ".
" F$kli_vxcf"."_poznamky_po2011.bb11c=".$databaza."F".$h_ycf."_poznamky_po2011.bb11c, ".
" F$kli_vxcf"."_poznamky_po2011.bb11d=".$databaza."F".$h_ycf."_poznamky_po2011.bb11d, ".
" F$kli_vxcf"."_poznamky_po2011.bb11e=".$databaza."F".$h_ycf."_poznamky_po2011.bb11e, ".

" F$kli_vxcf"."_poznamky_po2011.bb12a=".$databaza."F".$h_ycf."_poznamky_po2011.bb12a, ".
" F$kli_vxcf"."_poznamky_po2011.bb12b=".$databaza."F".$h_ycf."_poznamky_po2011.bb12b, ".
" F$kli_vxcf"."_poznamky_po2011.bb12c=".$databaza."F".$h_ycf."_poznamky_po2011.bb12c, ".
" F$kli_vxcf"."_poznamky_po2011.bb12d=".$databaza."F".$h_ycf."_poznamky_po2011.bb12d, ".
" F$kli_vxcf"."_poznamky_po2011.bb12e=".$databaza."F".$h_ycf."_poznamky_po2011.bb12e, ".

" F$kli_vxcf"."_poznamky_po2011.bb13a=".$databaza."F".$h_ycf."_poznamky_po2011.bb13a, ".
" F$kli_vxcf"."_poznamky_po2011.bb13b=".$databaza."F".$h_ycf."_poznamky_po2011.bb13b, ".
" F$kli_vxcf"."_poznamky_po2011.bb13c=".$databaza."F".$h_ycf."_poznamky_po2011.bb13c, ".
" F$kli_vxcf"."_poznamky_po2011.bb13d=".$databaza."F".$h_ycf."_poznamky_po2011.bb13d, ".
" F$kli_vxcf"."_poznamky_po2011.bb13e=".$databaza."F".$h_ycf."_poznamky_po2011.bb13e, ".

" F$kli_vxcf"."_poznamky_po2011.bb14a=".$databaza."F".$h_ycf."_poznamky_po2011.bb14a, ".
" F$kli_vxcf"."_poznamky_po2011.bb14b=".$databaza."F".$h_ycf."_poznamky_po2011.bb14b, ".
" F$kli_vxcf"."_poznamky_po2011.bb14c=".$databaza."F".$h_ycf."_poznamky_po2011.bb14c, ".
" F$kli_vxcf"."_poznamky_po2011.bb14d=".$databaza."F".$h_ycf."_poznamky_po2011.bb14d, ".
" F$kli_vxcf"."_poznamky_po2011.bb14e=".$databaza."F".$h_ycf."_poznamky_po2011.bb14e, ".

" F$kli_vxcf"."_poznamky_po2011.bb15a=".$databaza."F".$h_ycf."_poznamky_po2011.bb15a, ".
" F$kli_vxcf"."_poznamky_po2011.bb15b=".$databaza."F".$h_ycf."_poznamky_po2011.bb15b, ".
" F$kli_vxcf"."_poznamky_po2011.bb15c=".$databaza."F".$h_ycf."_poznamky_po2011.bb15c, ".
" F$kli_vxcf"."_poznamky_po2011.bb15d=".$databaza."F".$h_ycf."_poznamky_po2011.bb15d, ".
" F$kli_vxcf"."_poznamky_po2011.bb15e=".$databaza."F".$h_ycf."_poznamky_po2011.bb15e, ".

" F$kli_vxcf"."_poznamky_po2011.bb199b=".$databaza."F".$h_ycf."_poznamky_po2011.bb199b, ".
" F$kli_vxcf"."_poznamky_po2011.bb199c=".$databaza."F".$h_ycf."_poznamky_po2011.bb199c, ".
" F$kli_vxcf"."_poznamky_po2011.bb199d=".$databaza."F".$h_ycf."_poznamky_po2011.bb199d, ".
" F$kli_vxcf"."_poznamky_po2011.bb199e=".$databaza."F".$h_ycf."_poznamky_po2011.bb199e, ".

" F$kli_vxcf"."_poznamky_po2011.ac12=".$databaza."F".$h_ycf."_poznamky_po2011.ac11, ".
" F$kli_vxcf"."_poznamky_po2011.ac22=".$databaza."F".$h_ycf."_poznamky_po2011.ac21, ".
" F$kli_vxcf"."_poznamky_po2011.ac32=".$databaza."F".$h_ycf."_poznamky_po2011.ac31  ".
" WHERE F$kli_vxcf"."_poznamky_po2011.psys=".$databaza."F".$h_ycf."_poznamky_po2011.psys "; 

$upravene = mysql_query("$uprtxt"); 
  }

//str 3-6 nehm
if( $stranax == 0 OR $stranax == 4 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011,".$databaza."F".$h_ycf."_poznamky_po2011 SET ".

" F$kli_vxcf"."_poznamky_po2011.f1a215i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a215h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a215g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a215f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a215e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a215d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a215c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a215b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a115b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a214i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a214h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a214g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a214f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a214e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a214d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a214c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a214b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a114b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a213i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a213h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a213g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a213f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a213e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a213d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a213c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a213b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a113b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a212i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a212h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a212g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a212f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a212e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a212d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a212c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a212b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a112b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a211i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a211h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a211g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a211f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a211e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a211d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a211c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a211b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a111b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a210i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a210h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a210g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a210f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a210e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a210d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a210c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a210b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a110b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a29i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a29h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a29g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a29f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a29e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a29d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a29c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a29b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a19b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a28i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a28h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a28g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a28f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a28e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a28d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a28c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a28b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a18b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a27i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a27h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a27g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a27f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a27e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a27d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a27c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a27b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a17b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a26i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a26h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a26g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a26f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a26e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a26d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a26c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a26b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a16b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a25i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a25h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a25g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a25f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a25e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a25d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a25c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a25b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a15b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a24i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a24h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a24g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a24f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a24e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a24d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a24c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a24b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a14b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a23i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a23h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a23g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a23f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a23e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a23d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a23c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a23b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a13b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a22i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a22h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a22g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a22f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a22e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a22d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a22c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a22b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a12b, ".

" F$kli_vxcf"."_poznamky_po2011.f1a21i=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11i, ".
" F$kli_vxcf"."_poznamky_po2011.f1a21h=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11h, ".
" F$kli_vxcf"."_poznamky_po2011.f1a21g=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11g, ".
" F$kli_vxcf"."_poznamky_po2011.f1a21f=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11f, ".
" F$kli_vxcf"."_poznamky_po2011.f1a21e=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11e, ".
" F$kli_vxcf"."_poznamky_po2011.f1a21d=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11d, ".
" F$kli_vxcf"."_poznamky_po2011.f1a21c=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11c, ".
" F$kli_vxcf"."_poznamky_po2011.f1a21b=".$databaza."F".$h_ycf."_poznamky_po2011.f1a11b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011.psys=".$databaza."F".$h_ycf."_poznamky_po2011.psys "; 

$upravene = mysql_query("$uprtxt"); 

//str 3-6 hm
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011,".$databaza."F".$h_ycf."_poznamky_po2011 SET ".
" F$kli_vxcf"."_poznamky_po2011.f2a215j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a215b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a115b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a214j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a214b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a114b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a213j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a213b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a113b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a212j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a212b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a112b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a211j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a211b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a111b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a210j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a210b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a110b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a29j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a29b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a19b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a28j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a28b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a18b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a27j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a27b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a17b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a26j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a26b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a16b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a25j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a25b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a15b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a24j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a24b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a14b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a23j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a23b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a13b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a22j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a22b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a12b, ".

" F$kli_vxcf"."_poznamky_po2011.f2a21j=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11j, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21i=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11i, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21h=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11h, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21g=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11g, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21f=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11f, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21e=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11e, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21d=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11d, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21c=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11c, ".
" F$kli_vxcf"."_poznamky_po2011.f2a21b=".$databaza."F".$h_ycf."_poznamky_po2011.f2a11b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011.psys=".$databaza."F".$h_ycf."_poznamky_po2011.psys "; 

$upravene = mysql_query("$uprtxt"); 
  }


//str 7,8,10-13 
if( $stranax == 0 OR $stranax == 6 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j11j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j11b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j11b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j10j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j10b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j10b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j9j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j9b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j9b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j8j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j8b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j8b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j7j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j7b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j7b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j6j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j6b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j6b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j5j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j5b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j5b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j4j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j4b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j4b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j3j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j3b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j3b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j2j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j2b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j2b, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2j1j=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1j, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1i=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1i, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1h=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1h, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1g=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1g, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1f=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1f, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1e=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1e, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1d=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1d, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1c, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2j1b=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1j1b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt"); 
  }

//str 14-17 
if( $stranax == 0 OR $stranax == 7 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".
" F$kli_vxcf"."_poznamky_po2011s2.f1q3c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1q3b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1q2c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1q2b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1q1c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1q1b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".
" F$kli_vxcf"."_poznamky_po2011s2.f3q3c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3q3b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f3q2c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3q2b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f3q1c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3q1b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".
" F$kli_vxcf"."_poznamky_po2011s2.f2s6c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2s6b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2s5c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2s5b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2s4c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2s4b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2s3c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2s3b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2s2c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2s2b, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2s1c=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2s1b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt");

  }

//str18-23
if( $stranax == 0 OR $stranax == 8 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".
" F$kli_vxcf"."_poznamky_po2011s2.f1w12=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1w11, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1w22=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1w21, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1w32=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1w31, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1w42=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1w41, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1w992=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1w991 ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt"); 


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".

" F$kli_vxcf"."_poznamky_po2011s2.f4zb33=".$databaza."F".$h_ycf."_poznamky_po2011s2.f4zb32, ".
" F$kli_vxcf"."_poznamky_po2011s2.f4zb31=".$databaza."F".$h_ycf."_poznamky_po2011s2.f4zb31, ".
" F$kli_vxcf"."_poznamky_po2011s2.f4zb23=".$databaza."F".$h_ycf."_poznamky_po2011s2.f4zb22, ".
" F$kli_vxcf"."_poznamky_po2011s2.f4zb21=".$databaza."F".$h_ycf."_poznamky_po2011s2.f4zb21, ".
" F$kli_vxcf"."_poznamky_po2011s2.f4zb13=".$databaza."F".$h_ycf."_poznamky_po2011s2.f4zb12, ".

" F$kli_vxcf"."_poznamky_po2011s2.f3zb33=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3zb32, ".
" F$kli_vxcf"."_poznamky_po2011s2.f3zb31=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3zb31, ".
" F$kli_vxcf"."_poznamky_po2011s2.f3zb23=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3zb22, ".
" F$kli_vxcf"."_poznamky_po2011s2.f3zb21=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3zb21, ".
" F$kli_vxcf"."_poznamky_po2011s2.f3zb13=".$databaza."F".$h_ycf."_poznamky_po2011s2.f3zb12, ".

" F$kli_vxcf"."_poznamky_po2011s2.f2zb33=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2zb32, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2zb31=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2zb31, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2zb23=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2zb22, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2zb21=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2zb21, ".
" F$kli_vxcf"."_poznamky_po2011s2.f2zb13=".$databaza."F".$h_ycf."_poznamky_po2011s2.f2zb12, ".

" F$kli_vxcf"."_poznamky_po2011s2.f1zb33=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1zb32, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1zb31=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1zb31, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1zb23=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1zb22, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1zb21=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1zb21, ".
" F$kli_vxcf"."_poznamky_po2011s2.f1zb13=".$databaza."F".$h_ycf."_poznamky_po2011s2.f1zb12  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".
" F$kli_vxcf"."_poznamky_po2011s2.fzc99g=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc99d, ".
" F$kli_vxcf"."_poznamky_po2011s2.fzc99f=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc99c, ".
" F$kli_vxcf"."_poznamky_po2011s2.fzc99e=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc99b, ".

" F$kli_vxcf"."_poznamky_po2011s2.fzc2g=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc2d, ".
" F$kli_vxcf"."_poznamky_po2011s2.fzc2f=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc2c, ".
" F$kli_vxcf"."_poznamky_po2011s2.fzc2e=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc2b, ".

" F$kli_vxcf"."_poznamky_po2011s2.fzc1g=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc1d, ".
" F$kli_vxcf"."_poznamky_po2011s2.fzc1f=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc1c, ".
" F$kli_vxcf"."_poznamky_po2011s2.fzc1e=".$databaza."F".$h_ycf."_poznamky_po2011s2.fzc1b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt");
  }

//str24,25 
if( $stranax == 0 OR $stranax == 9 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2,".$databaza."F".$h_ycf."_poznamky_po2011s2 SET ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b8f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b8f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b8e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b8e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b8d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b8d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b8c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b8c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b8b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b8b2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b8a2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b8a2, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b7f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b7f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b7e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b7e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b7d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b7d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b7c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b7c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b7b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b7b2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b7a2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b7a2, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b6f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6b2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6a2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6a2, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b5f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5b2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5a2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5a2, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b4f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4b2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4a2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4a2, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b3f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3b2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3a2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3a2, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b2f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2b2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2a2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2a2, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b1f2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1f2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1e2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1e2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1d2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1d2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1c2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1c2, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1b2=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1b1, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b6f1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6f1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6e1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6e1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6d1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6d1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6c1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6c1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6b1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6b1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b6a1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b6a1, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b5f1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5f1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5e1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5e1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5d1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5d1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5c1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5c1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5b1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5b1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b5a1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b5a1, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b4f1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4f1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4e1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4e1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4d1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4d1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4c1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4c1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4b1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4b1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b4a1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b4a1, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b3f1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3f1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3e1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3e1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3d1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3d1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3c1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3c1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3b1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3b1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b3a1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b3a1, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b2f1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2f1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2e1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2e1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2d1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2d1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2c1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2c1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2b1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2b1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b2a1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b2a1, ".

" F$kli_vxcf"."_poznamky_po2011s2.g2b1f1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1f1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1e1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1e1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1d1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1d1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1c1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1c1, ".
" F$kli_vxcf"."_poznamky_po2011s2.g2b1b1=".$databaza."F".$h_ycf."_poznamky_po2011s2.g1b1b1  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s2.psys=".$databaza."F".$h_ycf."_poznamky_po2011s2.psys "; 
$upravene = mysql_query("$uprtxt");
  }

//str26az30 
if( $stranax == 0 OR $stranax == 10 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.gh11=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh11, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh12=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh12, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh13=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh13, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh14=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh14, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh15=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh15, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh16=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh16, ".

" F$kli_vxcf"."_poznamky_po2011s3.gh21=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh21, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh22=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh22, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh23=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh23, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh24=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh24, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh25=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh25, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh26=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh26, ".

" F$kli_vxcf"."_poznamky_po2011s3.gh31=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh31, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh32=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh32, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh33=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh33, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh34=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh34, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh35=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh35, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh36=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh36, ".

" F$kli_vxcf"."_poznamky_po2011s3.gh41=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh41, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh42=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh42, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh43=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh43, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh44=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh44, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh45=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh45, ".
" F$kli_vxcf"."_poznamky_po2011s3.gh46=".$databaza."F".$h_ycf."_poznamky_po2011s3.gh46  ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.gcd12=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd11, ".
" F$kli_vxcf"."_poznamky_po2011s3.gcd22=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd21, ".
" F$kli_vxcf"."_poznamky_po2011s3.gcd32=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd31, ".
" F$kli_vxcf"."_poznamky_po2011s3.gcd42=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd41, ".
" F$kli_vxcf"."_poznamky_po2011s3.gcd52=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd51, ".
" F$kli_vxcf"."_poznamky_po2011s3.gcd62=".$databaza."F".$h_ycf."_poznamky_po2011s3.gcd61  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.gf102=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf101, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf112=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf111, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf122=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf121, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf132=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf131, ".

" F$kli_vxcf"."_poznamky_po2011s3.fv12=".$databaza."F".$h_ycf."_poznamky_po2011s3.fv11, ".
" F$kli_vxcf"."_poznamky_po2011s3.fv22=".$databaza."F".$h_ycf."_poznamky_po2011s3.fv21, ".
" F$kli_vxcf"."_poznamky_po2011s3.fv32=".$databaza."F".$h_ycf."_poznamky_po2011s3.fv31, ".
" F$kli_vxcf"."_poznamky_po2011s3.fv42=".$databaza."F".$h_ycf."_poznamky_po2011s3.fv41, ".

" F$kli_vxcf"."_poznamky_po2011s3.gf12=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf11, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf22=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf21, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf32=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf31, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf42=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf41, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf52=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf51, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf62=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf61, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf72=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf71, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf82=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf81, ".
" F$kli_vxcf"."_poznamky_po2011s3.gf92=".$databaza."F".$h_ycf."_poznamky_po2011s3.gf91  ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.gg12=".$databaza."F".$h_ycf."_poznamky_po2011s3.gg11, ".
" F$kli_vxcf"."_poznamky_po2011s3.gg22=".$databaza."F".$h_ycf."_poznamky_po2011s3.gg21, ".
" F$kli_vxcf"."_poznamky_po2011s3.gg32=".$databaza."F".$h_ycf."_poznamky_po2011s3.gg31, ".
" F$kli_vxcf"."_poznamky_po2011s3.gg42=".$databaza."F".$h_ycf."_poznamky_po2011s3.gg41, ".
" F$kli_vxcf"."_poznamky_po2011s3.gg52=".$databaza."F".$h_ycf."_poznamky_po2011s3.gg51, ".
" F$kli_vxcf"."_poznamky_po2011s3.gg62=".$databaza."F".$h_ycf."_poznamky_po2011s3.gg61, ".
" F$kli_vxcf"."_poznamky_po2011s3.gg72=".$databaza."F".$h_ycf."_poznamky_po2011s3.gg71  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.g1i3f2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3e2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3d2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3c2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3b2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g1i2f2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2e2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2d2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2c2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2b2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g1i1f2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1e2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1d2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1c2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1b2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g1i3f1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3e1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3d1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3c1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3b1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i3a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i3a1, ".

" F$kli_vxcf"."_poznamky_po2011s3.g1i2f1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2e1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2d1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2c1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2b1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i2a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i2a1, ".

" F$kli_vxcf"."_poznamky_po2011s3.g1i1f1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1e1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1d1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1c1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1b1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1i1a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1i1a1  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i2f3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2e3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2d3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2d3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2c3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2c3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2b3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2b3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2a3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2a3, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i1f3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1e3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1d3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1d3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1c3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1c3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1b3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1b3, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1a3=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1a3, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i3f2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3e2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3d2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3c2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3b2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i2f2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2e2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2d2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2c2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2b2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i1f2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1e2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1d2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1c2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1b2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i3f1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3e1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3d1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3c1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3b1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i3a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i3a1, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i2f1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2e1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2d1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2c1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2b1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i2a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i2a1, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2i1f1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1e1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1d1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1c1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1b1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2i1a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2i1a1  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");
  }

//str31az34 
if( $stranax == 0 OR $stranax == 11 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.g1j13=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1j12, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1j21=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1j21, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1j23=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1j22, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1j31=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1j31, ".
" F$kli_vxcf"."_poznamky_po2011s3.g1j33=".$databaza."F".$h_ycf."_poznamky_po2011s3.g1j32, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2j13=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2j12, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2j21=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2j21, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2j23=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2j22, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2j31=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2j31, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2j33=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2j32, ".

" F$kli_vxcf"."_poznamky_po2011s3.g3j13=".$databaza."F".$h_ycf."_poznamky_po2011s3.g3j12, ".
" F$kli_vxcf"."_poznamky_po2011s3.g3j21=".$databaza."F".$h_ycf."_poznamky_po2011s3.g3j21, ".
" F$kli_vxcf"."_poznamky_po2011s3.g3j23=".$databaza."F".$h_ycf."_poznamky_po2011s3.g3j22, ".
" F$kli_vxcf"."_poznamky_po2011s3.g3j31=".$databaza."F".$h_ycf."_poznamky_po2011s3.g3j31, ".
" F$kli_vxcf"."_poznamky_po2011s3.g3j33=".$databaza."F".$h_ycf."_poznamky_po2011s3.g3j32, ".
" F$kli_vxcf"."_poznamky_po2011s3.g3j41=".$databaza."F".$h_ycf."_poznamky_po2011s3.g3j41, ".
" F$kli_vxcf"."_poznamky_po2011s3.g3j43=".$databaza."F".$h_ycf."_poznamky_po2011s3.g3j42, ".

" F$kli_vxcf"."_poznamky_po2011s3.g4j13=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j12, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j21=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j21, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j23=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j22, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j31=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j31, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j33=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j32, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j41=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j41, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j43=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j42, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j51=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j51, ".
" F$kli_vxcf"."_poznamky_po2011s3.g4j53=".$databaza."F".$h_ycf."_poznamky_po2011s3.g4j52  ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.gl1c=".$databaza."F".$h_ycf."_poznamky_po2011s3.gl1b, ".
" F$kli_vxcf"."_poznamky_po2011s3.gl2c=".$databaza."F".$h_ycf."_poznamky_po2011s3.gl2b, ".
" F$kli_vxcf"."_poznamky_po2011s3.gl3c=".$databaza."F".$h_ycf."_poznamky_po2011s3.gl3b, ".
" F$kli_vxcf"."_poznamky_po2011s3.gl4c=".$databaza."F".$h_ycf."_poznamky_po2011s3.gl4b, ".
" F$kli_vxcf"."_poznamky_po2011s3.gl99c=".$databaza."F".$h_ycf."_poznamky_po2011s3.gl99b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k4e2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k4c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k4d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k4b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k4a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k4a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2k3e2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k3c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k3d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k3b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k3a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k3a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2k2e2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k2c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k2d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k2b2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k2a2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k2a2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2k1e2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k1c2, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k1d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k1b2, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2k4e1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k4c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k4d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k4b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k4a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k4a1, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2k3e1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k3c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k3d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k3b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k3a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k3a1, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2k2e1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k2c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k2d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k2b1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k2a1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k2a1, ".

" F$kli_vxcf"."_poznamky_po2011s3.g2k1e1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k1c1, ".
" F$kli_vxcf"."_poznamky_po2011s3.g2k1d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.g2k1b1  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys ";  
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.gm99g=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm99d, ".
" F$kli_vxcf"."_poznamky_po2011s3.gm99f=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm99c, ".
" F$kli_vxcf"."_poznamky_po2011s3.gm99e=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm99b, ".

" F$kli_vxcf"."_poznamky_po2011s3.gm2g=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm2d, ".
" F$kli_vxcf"."_poznamky_po2011s3.gm2f=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm2c, ".
" F$kli_vxcf"."_poznamky_po2011s3.gm2e=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm2b, ".

" F$kli_vxcf"."_poznamky_po2011s3.gm1g=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm1d, ".
" F$kli_vxcf"."_poznamky_po2011s3.gm1f=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm1c, ".
" F$kli_vxcf"."_poznamky_po2011s3.gm1e=".$databaza."F".$h_ycf."_poznamky_po2011s3.gm1b  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 
  }

//str35az41 
if( $stranax == 0 OR $stranax == 12 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.ha4g=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha4f, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha4e=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha4d, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha4c=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha4b, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha4a=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha4a, ".

" F$kli_vxcf"."_poznamky_po2011s3.ha3g=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha3f, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha3e=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha3d, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha3c=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha3b, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha3a=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha3a, ".

" F$kli_vxcf"."_poznamky_po2011s3.ha2g=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha2f, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha2e=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha2d, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha2c=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha2b, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha2a=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha2a, ".

" F$kli_vxcf"."_poznamky_po2011s3.ha1g=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha1f, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha1e=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha1d, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha1c=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha1b, ".
" F$kli_vxcf"."_poznamky_po2011s3.ha1a=".$databaza."F".$h_ycf."_poznamky_po2011s3.ha1a  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.h1cf13=".$databaza."F".$h_ycf."_poznamky_po2011s3.h1cf12, ".
" F$kli_vxcf"."_poznamky_po2011s3.h1cf21=".$databaza."F".$h_ycf."_poznamky_po2011s3.h1cf21, ".
" F$kli_vxcf"."_poznamky_po2011s3.h1cf23=".$databaza."F".$h_ycf."_poznamky_po2011s3.h1cf22, ".
" F$kli_vxcf"."_poznamky_po2011s3.h1cf31=".$databaza."F".$h_ycf."_poznamky_po2011s3.h1cf31, ".
" F$kli_vxcf"."_poznamky_po2011s3.h1cf33=".$databaza."F".$h_ycf."_poznamky_po2011s3.h1cf32, ".

" F$kli_vxcf"."_poznamky_po2011s3.h2cf13=".$databaza."F".$h_ycf."_poznamky_po2011s3.h2cf12, ".
" F$kli_vxcf"."_poznamky_po2011s3.h2cf21=".$databaza."F".$h_ycf."_poznamky_po2011s3.h2cf21, ".
" F$kli_vxcf"."_poznamky_po2011s3.h2cf23=".$databaza."F".$h_ycf."_poznamky_po2011s3.h2cf22, ".
" F$kli_vxcf"."_poznamky_po2011s3.h2cf31=".$databaza."F".$h_ycf."_poznamky_po2011s3.h2cf31, ".
" F$kli_vxcf"."_poznamky_po2011s3.h2cf33=".$databaza."F".$h_ycf."_poznamky_po2011s3.h2cf32, ".
" F$kli_vxcf"."_poznamky_po2011s3.h2cf41=".$databaza."F".$h_ycf."_poznamky_po2011s3.h2cf41, ".
" F$kli_vxcf"."_poznamky_po2011s3.h2cf43=".$databaza."F".$h_ycf."_poznamky_po2011s3.h2cf42, ".

" F$kli_vxcf"."_poznamky_po2011s3.h3cf13=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf12, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf23=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf22, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf33=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf32, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf43=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf42, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf51=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf51, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf53=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf52, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf61=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf61, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf63=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf62, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf71=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf71, ".
" F$kli_vxcf"."_poznamky_po2011s3.h3cf73=".$databaza."F".$h_ycf."_poznamky_po2011s3.h3cf72, ".

" F$kli_vxcf"."_poznamky_po2011s3.h4cf13=".$databaza."F".$h_ycf."_poznamky_po2011s3.h4cf12, ".
" F$kli_vxcf"."_poznamky_po2011s3.h4cf21=".$databaza."F".$h_ycf."_poznamky_po2011s3.h4cf21, ".
" F$kli_vxcf"."_poznamky_po2011s3.h4cf23=".$databaza."F".$h_ycf."_poznamky_po2011s3.h4cf22, ".
" F$kli_vxcf"."_poznamky_po2011s3.h4cf31=".$databaza."F".$h_ycf."_poznamky_po2011s3.h4cf31, ".
" F$kli_vxcf"."_poznamky_po2011s3.h4cf33=".$databaza."F".$h_ycf."_poznamky_po2011s3.h4cf32  ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.hb4d=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb4c, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb3d=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb3c, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb2d=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb2c, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb1d=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb1c, ".

" F$kli_vxcf"."_poznamky_po2011s3.hb4c=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb4b, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb3c=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb3b, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb2c=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb2b, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb1c=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb1b, ".

" F$kli_vxcf"."_poznamky_po2011s3.hb9f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb9e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb8f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb8e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb7f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb7e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb6f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb6e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb5f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb5e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb4f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb4e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb3f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb3e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb2f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb2e, ".
" F$kli_vxcf"."_poznamky_po2011s3.hb1f=".$databaza."F".$h_ycf."_poznamky_po2011s3.hb1e  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.hg12=".$databaza."F".$h_ycf."_poznamky_po2011s3.hg11, ".
" F$kli_vxcf"."_poznamky_po2011s3.hg22=".$databaza."F".$h_ycf."_poznamky_po2011s3.hg21, ".
" F$kli_vxcf"."_poznamky_po2011s3.hg32=".$databaza."F".$h_ycf."_poznamky_po2011s3.hg31, ".
" F$kli_vxcf"."_poznamky_po2011s3.hg42=".$databaza."F".$h_ycf."_poznamky_po2011s3.hg41, ".
" F$kli_vxcf"."_poznamky_po2011s3.hg52=".$databaza."F".$h_ycf."_poznamky_po2011s3.hg51, ".
" F$kli_vxcf"."_poznamky_po2011s3.hg62=".$databaza."F".$h_ycf."_poznamky_po2011s3.hg61, ".
" F$kli_vxcf"."_poznamky_po2011s3.hg992=".$databaza."F".$h_ycf."_poznamky_po2011s3.hg991  ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.i1ag13=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag12, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag23=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag22, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag33=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag32, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag43=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag42, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag53=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag52, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag63=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag62, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag73=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag72, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag83=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag82, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag93=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag92, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag103=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag102, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag113=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag112, ".

" F$kli_vxcf"."_poznamky_po2011s3.i1ag91=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag91, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag101=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag101, ".
" F$kli_vxcf"."_poznamky_po2011s3.i1ag111=".$databaza."F".$h_ycf."_poznamky_po2011s3.i1ag111, ".

" F$kli_vxcf"."_poznamky_po2011s3.i2ag13=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag12, ".
" F$kli_vxcf"."_poznamky_po2011s3.i2ag23=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag22, ".
" F$kli_vxcf"."_poznamky_po2011s3.i2ag33=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag32, ".
" F$kli_vxcf"."_poznamky_po2011s3.i2ag43=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag42, ".
" F$kli_vxcf"."_poznamky_po2011s3.i2ag53=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag52, ".

" F$kli_vxcf"."_poznamky_po2011s3.i2ag21=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag21, ".
" F$kli_vxcf"."_poznamky_po2011s3.i2ag31=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag31, ".
" F$kli_vxcf"."_poznamky_po2011s3.i2ag41=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag41, ".
" F$kli_vxcf"."_poznamky_po2011s3.i2ag51=".$databaza."F".$h_ycf."_poznamky_po2011s3.i2ag51, ".

" F$kli_vxcf"."_poznamky_po2011s3.i3ag13=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag12, ".
" F$kli_vxcf"."_poznamky_po2011s3.i3ag23=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag22, ".
" F$kli_vxcf"."_poznamky_po2011s3.i3ag33=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag32, ".
" F$kli_vxcf"."_poznamky_po2011s3.i3ag43=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag42, ".
" F$kli_vxcf"."_poznamky_po2011s3.i3ag53=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag52, ".
" F$kli_vxcf"."_poznamky_po2011s3.i3ag63=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag62, ".

" F$kli_vxcf"."_poznamky_po2011s3.i3ag51=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag51, ".
" F$kli_vxcf"."_poznamky_po2011s3.i3ag61=".$databaza."F".$h_ycf."_poznamky_po2011s3.i3ag61, ".

" F$kli_vxcf"."_poznamky_po2011s3.i4ag13=".$databaza."F".$h_ycf."_poznamky_po2011s3.i4ag12, ".
" F$kli_vxcf"."_poznamky_po2011s3.i4ag23=".$databaza."F".$h_ycf."_poznamky_po2011s3.i4ag22, ".
" F$kli_vxcf"."_poznamky_po2011s3.i4ag33=".$databaza."F".$h_ycf."_poznamky_po2011s3.i4ag32, ".

" F$kli_vxcf"."_poznamky_po2011s3.i4ag21=".$databaza."F".$h_ycf."_poznamky_po2011s3.i4ag21, ".
" F$kli_vxcf"."_poznamky_po2011s3.i4ag31=".$databaza."F".$h_ycf."_poznamky_po2011s3.i4ag31  ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.jae12=".$databaza."F".$h_ycf."_poznamky_po2011s3.jae11, ".
" F$kli_vxcf"."_poznamky_po2011s3.jae22=".$databaza."F".$h_ycf."_poznamky_po2011s3.jae21, ".
" F$kli_vxcf"."_poznamky_po2011s3.jae32=".$databaza."F".$h_ycf."_poznamky_po2011s3.jae31, ".
" F$kli_vxcf"."_poznamky_po2011s3.jae42=".$databaza."F".$h_ycf."_poznamky_po2011s3.jae41, ".
" F$kli_vxcf"."_poznamky_po2011s3.jae52=".$databaza."F".$h_ycf."_poznamky_po2011s3.jae51, ".
" F$kli_vxcf"."_poznamky_po2011s3.jae62=".$databaza."F".$h_ycf."_poznamky_po2011s3.jae61  ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.jfg1e=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg1b, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg6e=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg6b, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg5e=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg5b, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg4e=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg4b, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg3e=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg3b, ".

" F$kli_vxcf"."_poznamky_po2011s3.jfg9f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg9c, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg8f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg8c, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg7f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg7c, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg6f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg6c, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg5f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg5c, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg4f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg4c, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg3f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg3c, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg2f=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg2c, ".

" F$kli_vxcf"."_poznamky_po2011s3.jfg9g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg9d, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg8g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg8d, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg7g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg7d, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg6g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg6d, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg5g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg5d, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg4g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg4d, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg3g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg3d, ".
" F$kli_vxcf"."_poznamky_po2011s3.jfg2g=".$databaza."F".$h_ycf."_poznamky_po2011s3.jfg2d  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");
  }

//str42az46
if( $stranax == 0 OR $stranax == 13 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.k12=".$databaza."F".$h_ycf."_poznamky_po2011s3.k11, ".
" F$kli_vxcf"."_poznamky_po2011s3.k22=".$databaza."F".$h_ycf."_poznamky_po2011s3.k21, ".
" F$kli_vxcf"."_poznamky_po2011s3.k32=".$databaza."F".$h_ycf."_poznamky_po2011s3.k31, ".
" F$kli_vxcf"."_poznamky_po2011s3.k42=".$databaza."F".$h_ycf."_poznamky_po2011s3.k41, ".
" F$kli_vxcf"."_poznamky_po2011s3.k52=".$databaza."F".$h_ycf."_poznamky_po2011s3.k51, ".
" F$kli_vxcf"."_poznamky_po2011s3.k62=".$databaza."F".$h_ycf."_poznamky_po2011s3.k61, ".
" F$kli_vxcf"."_poznamky_po2011s3.k72=".$databaza."F".$h_ycf."_poznamky_po2011s3.k71, ".
" F$kli_vxcf"."_poznamky_po2011s3.k82=".$databaza."F".$h_ycf."_poznamky_po2011s3.k81, ".
" F$kli_vxcf"."_poznamky_po2011s3.k92=".$databaza."F".$h_ycf."_poznamky_po2011s3.k91  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.l2ab11=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab11, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab21=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab21, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab31=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab31, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab41=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab41, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab51=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab51, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab61=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab61, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab12=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab12, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab22=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab22, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab32=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab32, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab42=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab42, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab52=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab52, ".
" F$kli_vxcf"."_poznamky_po2011s3.l2ab62=".$databaza."F".$h_ycf."_poznamky_po2011s3.l1ab62  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.lc12=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc11, ".
" F$kli_vxcf"."_poznamky_po2011s3.lc22=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc21, ".
" F$kli_vxcf"."_poznamky_po2011s3.lc32=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc31, ".
" F$kli_vxcf"."_poznamky_po2011s3.lc42=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc41, ".
" F$kli_vxcf"."_poznamky_po2011s3.lc52=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc51, ".
" F$kli_vxcf"."_poznamky_po2011s3.lc62=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc61, ".
" F$kli_vxcf"."_poznamky_po2011s3.lc72=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc71, ".
" F$kli_vxcf"."_poznamky_po2011s3.lc82=".$databaza."F".$h_ycf."_poznamky_po2011s3.lc81  ".
" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");



$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.m23c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m13c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m22c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m12c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m21c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m11c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m23b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m13b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m22b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m12b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m21b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m11b,  ".

" F$kli_vxcf"."_poznamky_po2011s3.m43c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m33c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m42c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m32c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m41c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m31c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m43b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m33b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m42b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m32b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m41b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m31b,  ".

" F$kli_vxcf"."_poznamky_po2011s3.m63c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m53c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m62c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m52c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m61c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m51c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m63b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m53b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m62b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m52b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m61b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m51b,  ".

" F$kli_vxcf"."_poznamky_po2011s3.m83c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m73c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m82c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m72c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m81c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m71c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m83b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m73b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m82b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m72b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m81b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m71b,  ".

" F$kli_vxcf"."_poznamky_po2011s3.m103c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m93c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m102c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m92c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m101c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m91c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m103b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m93b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m102b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m92b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m101b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m91b,  ".

" F$kli_vxcf"."_poznamky_po2011s3.m123c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m113c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m122c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m112c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m121c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m111c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m123b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m113b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m122b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m112b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m121b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m111b,  ".

" F$kli_vxcf"."_poznamky_po2011s3.m143c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m133c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m142c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m132c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m141c=".$databaza."F".$h_ycf."_poznamky_po2011s3.m131c,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m143b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m133b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m142b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m132b,  ".
" F$kli_vxcf"."_poznamky_po2011s3.m141b=".$databaza."F".$h_ycf."_poznamky_po2011s3.m131b   ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d14=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c13,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d24=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c23,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d34=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c33,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d44=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c43,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d54=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c53,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d64=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c63,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d74=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c73,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d84=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c83,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d94=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c93,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1d104=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1c103,  ".

" F$kli_vxcf"."_poznamky_po2011s3.n1b12=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b12,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b22=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b22,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b32=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b32,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b42=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b42,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b52=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b52,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b62=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b62,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b72=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b72,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b82=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b82,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b92=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b92,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1b102=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1b102,  ".

" F$kli_vxcf"."_poznamky_po2011s3.n1a11=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a11,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a21=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a21,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a31=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a31,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a41=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a41,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a51=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a51,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a61=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a61,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a71=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a71,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a81=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a81,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a91=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a91,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n1a101=".$databaza."F".$h_ycf."_poznamky_po2011s3.n1a101   ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d14=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c13,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d24=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c23,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d34=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c33,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d44=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c43,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d54=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c53,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d64=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c63,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d74=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c73,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d84=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c83,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2d94=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2c93,  ".

" F$kli_vxcf"."_poznamky_po2011s3.n2b12=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b12,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b22=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b22,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b32=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b32,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b42=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b42,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b52=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b52,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b62=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b62,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b72=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b72,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b82=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b82,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2b92=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2b92,  ".

" F$kli_vxcf"."_poznamky_po2011s3.n2a11=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a11,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a21=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a21,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a31=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a31,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a41=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a41,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a51=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a51,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a61=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a61,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a71=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a71,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a81=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a81,  ".
" F$kli_vxcf"."_poznamky_po2011s3.n2a91=".$databaza."F".$h_ycf."_poznamky_po2011s3.n2a91   ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");
  }

//str47 
if( $stranax == 0 OR $stranax == 14 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3,".$databaza."F".$h_ycf."_poznamky_po2011s3 SET ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f19=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f19,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e19=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e19,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d19=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d19,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c19=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c19,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b19=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b19,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f18=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f18,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e18=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e18,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d18=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d18,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c18=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c18,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b18=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b18,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f17=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f17,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e17=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e17,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d17=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d17,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c17=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c17,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b17=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b17,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f16=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f16,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e16=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e16,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d16=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d16,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c16=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c16,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b16=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b16,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f15=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f15,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e15=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e15,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d15=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d15,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c15=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c15,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b15=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b15,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f14=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f14,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e14=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e14,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d14=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d14,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c14=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c14,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b14=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b14,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f13=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f13,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e13=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e13,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d13=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d13,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c13=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c13,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b13=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b13,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f12=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f12,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e12=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e12,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d12=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d12,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c12=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c12,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b12=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b12,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f11=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f11,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e11=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e11,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d11=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d11,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c11=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c11,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b11=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b11,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f10=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f10,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e10=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e10,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d10=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d10,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c10=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c10,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b10=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b10,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f9=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f9,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e9=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e9,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d9=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d9,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c9=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c9,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b9=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b9,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f8=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f8,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e8=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e8,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d8=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d8,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c8=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c8,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b8=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b8,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f7=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f7,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e7=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e7,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d7=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d7,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c7=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c7,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b7=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b7,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f6=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f6,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e6=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e6,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d6=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d6,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c6=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c6,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b6=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b6,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f5=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f5,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e5=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e5,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d5=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d5,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c5=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c5,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b5=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b5,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f4=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f4,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e4=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e4,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d4=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d4,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c4=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c4,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b4=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b4,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f3=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f3,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e3=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e3,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d3=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d3,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c3=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c3,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b3=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b3,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f2=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f2,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e2=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e2,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d2=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d2,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c2=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c2,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b2=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b2,  ".

" F$kli_vxcf"."_poznamky_po2011s3.p2f1=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1f1,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2e1=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1e1,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2d1=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1d1,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2c1=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1c1,  ".
" F$kli_vxcf"."_poznamky_po2011s3.p2b1=".$databaza."F".$h_ycf."_poznamky_po2011s3.p1b1   ".

" WHERE F$kli_vxcf"."_poznamky_po2011s3.psys=".$databaza."F".$h_ycf."_poznamky_po2011s3.psys "; 
$upravene = mysql_query("$uprtxt");
 }


//andrejko tuto robi
}
//koniec copern=999 minuly rok z poznamok firmy min.roka

//copern=510 zakl.imanie
if( $copern == 510 )
{
///////////copern 505 tabulka 28.
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" p2b1=0, p2c1=0, p2d1=0, p2e1=0, p2f1=0, ".
" p2b2=0, p2c2=0, p2d2=0, p2e2=0, p2f2=0, ".
" p2b3=0, p2c3=0, p2d3=0, p2e3=0, p2f3=0, ".
" p2b4=0, p2c4=0, p2d4=0, p2e4=0, p2f4=0, ".
" p2b5=0, p2c5=0, p2d5=0, p2e5=0, p2f5=0, ".
" p2b6=0, p2c6=0, p2d6=0, p2e6=0, p2f6=0, ".
" p2b7=0, p2c7=0, p2d7=0, p2e7=0, p2f7=0, ".
" p2b8=0, p2c8=0, p2d8=0, p2e8=0, p2f8=0, ".
" p2b9=0, p2c9=0, p2d9=0, p2e9=0, p2f9=0, ".
" p2b10=0, p2c10=0, p2d10=0, p2e10=0, p2f10=0, ".
" p2b11=0, p2c11=0, p2d11=0, p2e11=0, p2f11=0, ".
" p2b12=0, p2c12=0, p2d12=0, p2e12=0, p2f12=0, ".
" p2b13=0, p2c13=0, p2d13=0, p2e13=0, p2f13=0, ".
" p2b14=0, p2c14=0, p2d14=0, p2e14=0, p2f14=0, ".
" p2b15=0, p2c15=0, p2d15=0, p2e15=0, p2f15=0, ".
" p2b16=0, p2c16=0, p2d16=0, p2e16=0, p2f16=0, ".
" p2b17=0, p2c17=0, p2d17=0, p2e17=0, p2f17=0, ".
" p2b18=0, p2c18=0, p2d18=0, p2e18=0, p2f18=0, ".
" p2b19=0, p2c19=0, p2d19=0, p2e19=0, p2f19=0, ".

" p1b1=0, p1c1=0, p1d1=0, p1e1=0, p1f1=0, ".
" p1b2=0, p1c2=0, p1d2=0, p1e2=0, p1f2=0, ".
" p1b3=0, p1c3=0, p1d3=0, p1e3=0, p1f3=0, ".
" p1b4=0, p1c4=0, p1d4=0, p1e4=0, p1f4=0, ".
" p1b5=0, p1c5=0, p1d5=0, p1e5=0, p1f5=0, ".
" p1b6=0, p1c6=0, p1d6=0, p1e6=0, p1f6=0, ".
" p1b7=0, p1c7=0, p1d7=0, p1e7=0, p1f7=0, ".
" p1b8=0, p1c8=0, p1d8=0, p1e8=0, p1f8=0, ".
" p1b9=0, p1c9=0, p1d9=0, p1e9=0, p1f9=0, ".
" p1b10=0, p1c10=0, p1d10=0, p1e10=0, p1f10=0, ".
" p1b11=0, p1c11=0, p1d11=0, p1e11=0, p1f11=0, ".
" p1b12=0, p1c12=0, p1d12=0, p1e12=0, p1f12=0, ".
" p1b13=0, p1c13=0, p1d13=0, p1e13=0, p1f13=0, ".
" p1b14=0, p1c14=0, p1d14=0, p1e14=0, p1f14=0, ".
" p1b15=0, p1c15=0, p1d15=0, p1e15=0, p1f15=0, ".
" p1b16=0, p1c16=0, p1d16=0, p1e16=0, p1f16=0, ".
" p1b17=0, p1c17=0, p1d17=0, p1e17=0, p1f17=0, ".
" p1b18=0, p1c18=0, p1d18=0, p1e18=0, p1f18=0, ".
" p1b19=0, p1c19=0, p1d19=0, p1e19=0, p1f19=0  ".

" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 11 )
  {

$pri=0; $poc=0; $uby=0; 

if( $nacitaj ==  1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 411 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 411 )"; }
if( $nacitaj ==  2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 412 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 412 )"; }
if( $nacitaj ==  3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 413 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 413 )"; }
if( $nacitaj ==  4 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 421 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 421 )"; }
if( $nacitaj ==  5 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 422 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 422 )"; }
if( $nacitaj ==  6 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 423 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 423 )"; }
if( $nacitaj ==  7 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 428 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 428 )"; }
if( $nacitaj ==  8 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 429 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 429 )"; }
if( $nacitaj ==  9 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,1) = 5 OR LEFT(ucm,1) = 6 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,1) = 5 OR LEFT(ucd,1) = 6 )"; }
if( $nacitaj ==  10 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 491 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 491 )"; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys > 1 ) { $uby=$uby+$polozka->hod; }
if( $polozka->psys == 1 ) { $poc=$poc-$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys > 1 ) { $pri=$pri+$polozka->hod; }
if( $polozka->psys == 1 ) { $poc=$poc+$polozka->hod; }
}
$i=$i+1;                   }


if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b1='$poc', p1c1='$pri', p1d1='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b5='$poc', p1c5='$pri', p1d5='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b6='$poc', p1c6='$pri', p1d6='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b11='$poc', p1c11='$pri', p1d11='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b12='$poc', p1c12='$pri', p1d12='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b13='$poc', p1c13='$pri', p1d13='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b14='$poc', p1c14='$pri', p1d14='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b15='$poc', p1c15='$pri', p1d15='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1f16='$poc'+$pri-$uby  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p1b19='$poc', p1c19='$pri', p1d19='$uby' WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b1='$poc', p2c1='$pri', p2d1='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b5='$poc', p2c5='$pri', p2d5='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b6='$poc', p2c6='$pri', p2d6='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b11='$poc', p2c11='$pri', p2d11='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b12='$poc', p2c12='$pri', p2d12='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b13='$poc', p2c13='$pri', p2d13='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b14='$poc', p2c14='$pri', p2d14='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b15='$poc', p2c15='$pri', p2d15='$uby' WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2f16='$poc'+$pri-$uby  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET p2b19='$poc', p2c19='$pri', p2d19='$uby' WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
$nacitaj=$nacitaj+1;
  }


$pocet=$pocet+1;
    }

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" p2f6=p2b6+p2c6-p2d6, ".
" p2f11=p2b11+p2c11-p2d11, ".
" p2f12=p2b12+p2c12-p2d12, ".
" p2f13=p2b13+p2c13-p2d13, ".
" p2f14=p2b14+p2c14-p2d14, ".
" p2f15=p2b15+p2c15-p2d15, ".
" p2f19=p2b19+p2c19-p2d19, ".
" p2f5=p2b5+p2c5-p2d5, ".
" p2f1=p2b1+p2c1-p2d1, ".

" p1f6=p1b6+p1c6-p1d6, ".
" p1f11=p1b11+p1c11-p1d11, ".
" p1f12=p1b12+p1c12-p1d12, ".
" p1f13=p1b13+p1c13-p1d13, ".
" p1f14=p1b14+p1c14-p1d14, ".
" p1f15=p1b15+p1c15-p1d15, ".
" p1f19=p1b19+p1c19-p1d19, ".
" p1f5=p1b5+p1c5-p1d5, ".
" p1f1=p1b1+p1c1-p1d1  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");



}
//koniec copern=510 zakl.imanie

//copern=509 dane
if( $copern == 509 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" jfg1b=0, jfg1e=0, jfg2c=0, jfg2d=0, jfg2f=0, jfg2g=0, ".
" jfg3b=0, jfg3c=0, jfg3d=0, jfg3e=0, jfg3f=0, jfg3g=0, ".
" jfg4b=0, jfg4c=0, jfg4d=0, jfg4e=0, jfg4f=0, jfg4g=0, ".
" jfg5b=0, jfg5c=0, jfg5d=0, jfg5e=0, jfg5f=0, jfg5g=0, ".
" jfg6b=0, jfg6c=0, jfg6d=0, jfg6e=0, jfg6f=0, jfg6g=0, ".
" jfg7c=0, jfg7d=0, jfg7f=0, jfg7g=0, ".
" jfg8c=0, jfg8d=0, jfg8f=0, jfg8g=0, ".
" jfg9c=0, jfg9d=0, jfg9f=0, jfg9g=0  ".

" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 4 )
  {

$hod=0; $pri=0; $uby=0;


if( $nacitaj == 1 ) { 
$podmmd="psys >= 1 AND ( ( LEFT(ucm,1) = 5 OR LEFT(ucm,1) = 6 ) AND LEFT(ucm,2) != 59 )"; 
$podmdl="psys >= 1 AND ( ( LEFT(ucd,1) = 5 OR LEFT(ucd,1) = 6 ) AND LEFT(ucd,2) != 59 )"; }
if( $nacitaj == 2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 591 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 591 )"; }
if( $nacitaj == 3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 592 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 592 )"; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod-$polozka->hod; }
}
$i=$i+1;                   }

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg1b=-1*'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg7c='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg8c='$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg1e=-1*'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg7f='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg8f='$hod'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg2c=0.19*jfg1b, jfg2d=19, jfg7d=19  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt");  

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg9c=jfg7c+jfg8c, jfg9d=19 WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt");  
  }

if( $pocet == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg2f=0.19*jfg1e, jfg2g=19, jfg7g=19 WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt");  

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET jfg9f=jfg7f+jfg8f, jfg9g=19  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt");  

  }

$pocet=$pocet+1;
    }

}
//koniec copern=509 dane

//copern=506 cas.rozlisenie pasiva
if( $copern == 506 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" g1j12=0, g1j13=0, g1j21='', g1j22=0, g1j23=0, g1j31='', g1j32=0, g1j33=0, ".
" g2j12=0, g2j13=0, g2j21='', g2j22=0, g2j23=0, g2j31='', g2j32=0, g2j33=0, ".
" g3j12=0, g3j13=0, g3j21='', g3j22=0, g3j23=0, g3j31='', g3j32=0, g3j33=0, g3j41='', g3j42=0, g3j43=0, ".
" g4j12=0, g4j13=0, g4j21='', g4j22=0, g4j23=0, g4j31='', g4j32=0, g4j33=0, g4j41='', g4j42=0, g4j43=0, g4j51='', g4j52=0, g4j53=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 3 )
  {

$hod=0; $pri=0; $uby=0;


if( $nacitaj == 1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 383 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 383 )"; }
if( $nacitaj == 2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 384 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 384 )"; }


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

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET g2j12='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET g4j12='$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET g2j13='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET g4j13='$hod'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET g2j22=g2j12, g4j22=g4j12  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt");  

  }

if( $pocet == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET g2j23=g2j13, g4j23=g4j13  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt");  

  }

$pocet=$pocet+1;
    }

}
//koniec copern=506 cas.rozlisenie pasiva

//copern=505 soc.fond
if( $copern == 505 )
{
///////////copern 505 tabulka 28.
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" gg11=0, gg12=0, ".
" gg21=0, gg22=0, ".
" gg31=0, gg32=0, ".
" gg41=0, gg42=0, ".
" gg51=0, gg52=0, ".
" gg61=0, gg62=0, ".
" gg71=0, gg72=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 2 )
  {

$pri=0; $poc=0; $uby=0; 

if( $nacitaj ==  1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 472 OR LEFT(ucm,3) = 441 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 472 OR LEFT(ucd,3) = 441 )"; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys > 1 ) { $uby=$uby+$polozka->hod; }
if( $polozka->psys == 1 ) { $poc=$poc-$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys > 1 ) { $pri=$pri+$polozka->hod; }
if( $polozka->psys == 1 ) { $poc=$poc+$polozka->hod; }
}
$i=$i+1;                   }


if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gg11='$poc', gg21='$pri', gg61='$uby' WHERE psys >= 0 "; }

  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gg12='$poc', gg22='$pri', gg62='$uby' WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
$nacitaj=$nacitaj+1;
  }


$pocet=$pocet+1;
    }

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" gg51=gg21+gg31+gg41, ".
" gg52=gg22+gg32+gg42  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" gg71=gg11+gg51-gg61, ".
" gg72=gg12+gg52-gg62  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");


///////////koniec copern 505 tabulka 28.
//exit;
}
//koniec copern=505 soc.fond


//rezervy
if( $copern == 504 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" g2b1b2=0, g2b1c2=0, g2b1d2=0, g2b1e2=0, g2b1f2=0,  ".
" g2b2b2=0, g2b2c2=0, g2b2d2=0, g2b2e2=0, g2b2f2=0,  ".
" g2b3b2=0, g2b3c2=0, g2b3d2=0, g2b3e2=0, g2b3f2=0,  ".
" g2b4b2=0, g2b4c2=0, g2b4d2=0, g2b4e2=0, g2b4f2=0,  ".
" g2b5b2=0, g2b5c2=0, g2b5d2=0, g2b5e2=0, g2b5f2=0,  ".
" g2b6b2=0, g2b6c2=0, g2b6d2=0, g2b6e2=0, g2b6f2=0,  ".
" g2b7b2=0, g2b7c2=0, g2b7d2=0, g2b7e2=0, g2b7f2=0,  ".
" g2b8b2=0, g2b8c2=0, g2b8d2=0, g2b8e2=0, g2b8f2=0,  ".

" g2b1b1=0, g2b1c1=0, g2b1d1=0, g2b1e1=0, g2b1f1=0,  ".
" g2b2b1=0, g2b2c1=0, g2b2d1=0, g2b2e1=0, g2b2f1=0,  ".
" g2b3b1=0, g2b3c1=0, g2b3d1=0, g2b3e1=0, g2b3f1=0,  ".
" g2b4b1=0, g2b4c1=0, g2b4d1=0, g2b4e1=0, g2b4f1=0,  ".
" g2b5b1=0, g2b5c1=0, g2b5d1=0, g2b5e1=0, g2b5f1=0,  ".
" g2b6b1=0, g2b6c1=0, g2b6d1=0, g2b6e1=0, g2b6f1=0,   ".

" g1b1b2=0, g1b1c2=0, g1b1d2=0, g1b1e2=0, g1b1f2=0,  ".
" g1b2b2=0, g1b2c2=0, g1b2d2=0, g1b2e2=0, g1b2f2=0,  ".
" g1b3b2=0, g1b3c2=0, g1b3d2=0, g1b3e2=0, g1b3f2=0,  ".
" g1b4b2=0, g1b4c2=0, g1b4d2=0, g1b4e2=0, g1b4f2=0,  ".
" g1b5b2=0, g1b5c2=0, g1b5d2=0, g1b5e2=0, g1b5f2=0,  ".
" g1b6b2=0, g1b6c2=0, g1b6d2=0, g1b6e2=0, g1b6f2=0,  ".
" g1b7b2=0, g1b7c2=0, g1b7d2=0, g1b7e2=0, g1b7f2=0,  ".
" g1b8b2=0, g1b8c2=0, g1b8d2=0, g1b8e2=0, g1b8f2=0,  ".

" g1b1b1=0, g1b1c1=0, g1b1d1=0, g1b1e1=0, g1b1f1=0,  ".
" g1b2b1=0, g1b2c1=0, g1b2d1=0, g1b2e1=0, g1b2f1=0,  ".
" g1b3b1=0, g1b3c1=0, g1b3d1=0, g1b3e1=0, g1b3f1=0,  ".
" g1b4b1=0, g1b4c1=0, g1b4d1=0, g1b4e1=0, g1b4f1=0,  ".
" g1b5b1=0, g1b5c1=0, g1b5d1=0, g1b5e1=0, g1b5f1=0,  ".
" g1b6b1=0, g1b6c1=0, g1b6d1=0, g1b6e1=0, g1b6f1=0   ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 2 )
  {

$poc=0; $pri=0; $uby=0; $zos=0;

if( $nacitaj == 1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 323 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 323 )"; }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $poc=$poc-$polozka->hod; }
if( $polozka->psys == 2 ) { $uby=$uby+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $poc=$poc+$polozka->hod; }
if( $polozka->psys == 2 ) { $pri=$pri+$polozka->hod; }
}
$i=$i+1;                   }

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g1b1b2='$poc', g1b1c2='$pri', g1b1d2='$uby'  WHERE psys >= 0 "; }

  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g2b1b2='$poc', g2b1c2='$pri', g2b1d2='$uby'  WHERE psys >= 0 "; }

  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" g1b1f2=g1b1b2+g1b1c2-g1b1d2 ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" g1b2b2=g1b1b2, g1b2c2=g1b1c2, g1b2d2=g1b1d2, g1b2f2=g1b1f2 ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

  }

if( $pocet == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" g2b1f2=g2b1b2+g2b1c2-g2b1d2 ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" g2b2b2=g2b1b2, g2b2c2=g2b1c2, g2b2d2=g2b1d2, g2b2f2=g2b1f2 ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

  }

$pocet=$pocet+1;
    }

}
//koniec copern=504 rezervy 


//copern=511 naklady
if( $copern == 511 )
{
///////////copern 566 tabulka 36.
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".

" hb9e=0, hb9f=0, ".
" hb8e=0, hb8f=0, ".
" hb7e=0, hb7f=0, ".
" hb6e=0, hb6f=0, ".
" hb5e=0, hb5f=0, ".
" hb4b=0, hb4c=0, hb4d=0, hb4e=0, hb4f=0, ".
" hb3b=0, hb3c=0, hb3d=0, hb3e=0, hb3f=0, ".
" hb2b=0, hb2c=0, hb2d=0, hb2e=0, hb2f=0, ".
" hb1b=0, hb1c=0, hb1d=0, hb1e=0, hb1f=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 4 )
  {

$hod=0; $poc=0; 

if( $nacitaj ==  1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 121 OR LEFT(ucm,3) = 122 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 121 OR LEFT(ucd,3) = 122 )"; }
if( $nacitaj ==  2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 123  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 123  )"; }
if( $nacitaj ==  3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 124  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 124  )"; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod+$polozka->hod; }
if( $polozka->psys == 1 ) { $poc=$poc+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod-$polozka->hod; }
if( $polozka->psys == 1 ) { $poc=$poc-$polozka->hod; }
}
$i=$i+1;                   }


if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hb1b='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hb2b='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hb3b='$hod' WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hb1c='$hod', hb1d='$poc' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hb2c='$hod', hb2d='$poc' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hb3c='$hod', hb3d='$poc' WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
$nacitaj=$nacitaj+1;
  }


$pocet=$pocet+1;
    }

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" hb4b=hb1b+hb2b+hb3b, ".
" hb4c=hb1c+hb2c+hb3c, ".
" hb4d=hb1d+hb2d+hb3d, ".
" hb1e=hb1b-hb1c, hb1f=hb1c-hb1d, ".
" hb2e=hb2b-hb2c, hb2f=hb2c-hb2d, ".
" hb3e=hb3b-hb3c, hb3f=hb3c-hb3d, ".
" hb4e=hb4b-hb4c, hb4f=hb4c-hb4d, ".
" hb9e=hb4e-hb5e-hb6e-hb7e-hb8e, ".
" hb9f=hb4f-hb5f-hb6f-hb7f-hb8f  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");


///////////koniec copern 511 tabulka 36.
//exit;
}
//koniec copern=511 naklady


//copern=508 naklady
if( $copern == 508 )
{
///////////copern 508 tabulka 39.
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" i4ag12=0, i4ag13=0, ".
" i4ag21='', i4ag22=0, i4ag23=0, ".
" i4ag31='', i4ag32=0, i4ag33=0, ".

" i3ag12=0, i3ag13=0, ".
" i3ag22=0, i3ag23=0, ".
" i3ag32=0, i3ag33=0, ".
" i3ag42=0, i3ag43=0, ".
" i3ag51='', i3ag52=0, i3ag53=0, ".
" i3ag61='', i3ag62=0, i3ag63=0, ".

" i2ag12=0, i2ag13=0, ".
" i2ag21='', i2ag22=0, i2ag23=0, ".
" i2ag31='', i2ag32=0, i2ag33=0, ".
" i2ag41='', i2ag42=0, i2ag43=0, ".
" i2ag51='', i2ag52=0, i2ag53=0, ".

" i1ag12=0, i1ag13=0, ".
" i1ag22=0, i1ag23=0, ".
" i1ag32=0, i1ag33=0, ".
" i1ag42=0, i1ag43=0, ".
" i1ag52=0, i1ag53=0, ".
" i1ag62=0, i1ag63=0, ".
" i1ag72=0, i1ag73=0, ".
" i1ag82=0, i1ag83=0, ".
" i1ag91='', i1ag92=0, i1ag93=0, ".
" i1ag101='', i1ag102=0, i1ag103=0, ".
" i1ag111='', i1ag112=0, i1ag113=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 6 )
  {

$hod=0; $pri=0; $uby=0;

if( $nacitaj ==  1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 518  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 518  )"; }
if( $nacitaj ==  2 ) { 
$podmmd="psys >= 1 AND ( ( LEFT(ucm,2) = 54 AND LEFT(ucm,3) != 547 ) OR LEFT(ucm,3) = 551 ) "; 
$podmdl="psys >= 1 AND ( ( LEFT(ucd,2) = 54 AND LEFT(ucd,3) != 547 ) OR LEFT(ucd,3) = 551 ) "; }
if( $nacitaj ==  3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,2) = 56  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,2) = 56  )"; }
if( $nacitaj ==  4 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,2) = 58  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,2) = 58  )"; }
if( $nacitaj ==  5 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 563  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 563  )"; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod-$polozka->hod; }
}
$i=$i+1;                   }


if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i1ag12='$hod', i1ag82='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i2ag12='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i3ag12='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i4ag12='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i3ag22='$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i1ag13='$hod', i1ag83='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i2ag13='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i3ag13='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i4ag13='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET i3ag23='$hod'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
$nacitaj=$nacitaj+1;
  }


$pocet=$pocet+1;
    }

///////////koniec copern 508 tabulka 39.
//exit;
}
//koniec copern=508 naklady


//copern=507 trzby,vynosy
if( $copern == 507 )
{
///////////copern 507 tabulka 35.

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" ha1a='', ha1b=0, ha1c=0, ha1d=0, ha1e=0, ha1f=0, ha1g=0, ".
" ha2a='', ha2b=0, ha2c=0, ha2d=0, ha2e=0, ha2f=0, ha2g=0, ".
" ha3a='', ha3b=0, ha3c=0, ha3d=0, ha3e=0, ha3f=0, ha3g=0, ".
" ha4a='', ha4b=0, ha4c=0, ha4d=0, ha4e=0, ha4f=0, ha4g=0, ".
" ha99b=0, ha99c=0, ha99d=0, ha99e=0, ha99f=0, ha99g=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$uce1=0; $uce2=0; $uce3=0; $uce4=0; $uce5=0; $uce6=0;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcstatr101s'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcstatr101mins'.$kli_uzid;
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

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcstatr101s'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcstatr101mins'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101s$kli_uzid"." SELECT".
" 1,0,ucm,ucd,0,SUM(hod) ".
" FROM F$kli_vxcf"."_prcstatr101$kli_uzid".
" WHERE LEFT(ucd,2) = 60 GROUP BY ucd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcstatr101mins$kli_uzid"." SELECT".
" 1,0,ucm,ucd,0,SUM(hod) ".
" FROM F$kli_vxcf"."_prcstatr101min$kli_uzid".
" WHERE LEFT(ucd,2) = 60 GROUP BY ucd ";
$dsql = mysql_query("$dsqlt");

$uce1=0; $uce2=0; $uce3=0; $uce4=0; $uce5=0; $uce6=0; 
$hod1=0; $hod2=0; $hod3=0; $hod4=0; $hod5=0; $hod6=0;

$hod1min=0; $hod2min=0; $hod3min=0; $hod4min=0; $hod5min=0; $hod6min=0;

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101s$kli_uzid ORDER BY hod DESC ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uce1=1*($riaddok->ucd);
  $hod1=1*($riaddok->hod);
  }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101mins$kli_uzid WHERE ucd = $uce1 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hod1min=1*($riaddok->hod);
  }

if( $uce1 > 0 ) { 
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ha1a='$uce1', ha1b='$hod1', ha1c='$hod1min' WHERE psys >= 0 "; $upravene = mysql_query("$uprtxt"); 
                }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101s$kli_uzid ORDER BY hod DESC ");
  if (@$zaznam=mysql_data_seek($sqldok,1))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uce2=1*($riaddok->ucd);
  $hod2=1*($riaddok->hod);
  }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101mins$kli_uzid WHERE ucd = $uce2 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hod2min=1*($riaddok->hod);
  }

if( $uce2 > 0 ) { 
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ha2a='$uce2', ha2b='$hod2', ha2c='$hod2min' WHERE psys >= 0 "; $upravene = mysql_query("$uprtxt"); 
                }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101s$kli_uzid ORDER BY hod DESC ");
  if (@$zaznam=mysql_data_seek($sqldok,2))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uce3=1*($riaddok->ucd);
  $hod3=1*($riaddok->hod);
  }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101mins$kli_uzid WHERE ucd = $uce3 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hod3min=1*($riaddok->hod);
  }

if( $uce3 > 0 ) { 
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ha3a='$uce3', ha3b='$hod3', ha3c='$hod3min' WHERE psys >= 0 "; $upravene = mysql_query("$uprtxt"); 
                }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101s$kli_uzid ORDER BY hod DESC ");
  if (@$zaznam=mysql_data_seek($sqldok,3))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uce4=1*($riaddok->ucd);
  $hod4=1*($riaddok->hod);
  }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcstatr101mins$kli_uzid WHERE ucd = $uce4 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hod4min=1*($riaddok->hod);
  }

if( $uce4 > 0 ) { 
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ha4a='$uce4', ha4b='$hod4', ha4c='$hod4min' WHERE psys >= 0 "; $upravene = mysql_query("$uprtxt"); 
                }

//suma
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ha99b=ha1b+ha2b+ha3b+ha4b, ha99c=ha1c+ha2c+ha3c+ha4c WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
 

///////////koniec copern 507 tabulka 35.

///////////copern 507 tabulka 37.
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" h4cf12=0, h4cf12=0,".
" h4cf21='', h4cf22=0, h4cf23=0 ".
" h4cf31='', h4cf32=0, h4cf33=0 ".

" h2cf12=0, h2cf12=0,".
" h2cf21='', h2cf22=0, h2cf23=0 ".
" h2cf31='', h2cf32=0, h2cf33=0 ".
" h2cf41='', h2cf42=0, h2cf43=0 ".

" h3cf12=0, h3cf12=0,".
" h3cf22=0, h3cf23=0 ".
" h3cf32=0, h3cf33=0 ".
" h3cf42=0, h3cf43=0 ".
" h3cf52=0, h3cf53=0 ".
" h3cf61='', h3cf62=0, h3cf63=0 ".
" h3cf71='', h3cf72=0, h3cf73=0 ".

" h1cf12=0, h1cf12=0,".
" h1cf21=0, h1cf22=0, h1cf23=0 ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 6 )
  {

$hod=0; $pri=0; $uby=0;

if( $nacitaj ==  1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,2) = 62  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,2) = 62  )"; }
if( $nacitaj ==  2 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,1) = 6 AND LEFT(ucm,2) != 62 AND LEFT(ucm,2) != 66 AND LEFT(ucm,2) != 68 ) "; 
$podmdl="psys >= 1 AND ( LEFT(ucd,1) = 6 AND LEFT(ucd,2) != 62 AND LEFT(ucd,2) != 66 AND LEFT(ucd,2) != 68 )"; }
if( $nacitaj ==  3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,2) = 66  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,2) = 66  )"; }
if( $nacitaj ==  4 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,2) = 68  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,2) = 68  )"; }
if( $nacitaj ==  5 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 663  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 663  )"; }

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


if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h1cf12='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h2cf12='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h3cf12='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h4cf12='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h3cf22='$hod' WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h1cf13='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h2cf13='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h3cf13='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h4cf13='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET h3cf23='$hod' WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }


$pocet=$pocet+1;
    }

///////////koniec copern 507 tabulka 37.

///////////copern 507 tabulka 38.
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" hg11=0, hg21=0, hg31=0, hg41=0, hg51=0, hg61=0, hg991=0, ".
" hg12=0, hg22=0, hg32=0, hg42=0, hg52=0, hg62=0, hg992=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 5 )
  {

$hod=0; $pri=0; $uby=0;

if( $nacitaj ==  1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 601  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 601  )"; }
if( $nacitaj ==  2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 602  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 602  )"; }
if( $nacitaj ==  3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 604  )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 604  )"; }
if( $nacitaj ==  4 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,1) = 6 AND LEFT(ucm,2) != 66 AND LEFT(ucm,2) != 68 ) "; 
$podmdl="psys >= 1 AND ( LEFT(ucd,1) = 6 AND LEFT(ucd,2) != 66 AND LEFT(ucd,2) != 68 )"; }

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


if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg11='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg21='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg31='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg991='$hod' WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg12='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg22='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg32='$hod' WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET hg992='$hod' WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }


$pocet=$pocet+1;
    }

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" hg61=hg991-hg11-hg21-hg31, ".
" hg62=hg992-hg12-hg22-hg32  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

///////////koniec copern 507 tabulka 38.

}
//koniec copern=507 trzby,vynosy

// copern=402 zavazky
if( $copern == 402 )
{

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
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
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd31=gcd31+'$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd32=gcd32+'$hod'  WHERE psys >= 0 "; }
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

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd11='$posplt1'   WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 



$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
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

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET gcd12='$posplt1'   WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s3 SET ".
" gcd22=gcd32-gcd12 ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

$pocet=$pocet+1;
    }
//exit;
}
//koniec copern=402 zavazky


//copern=503 rozdelenie zisku straty
if( $copern == 503 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" g3a11=0, g3a12=0,  g3a13=0,  g3a14=0,  g3a15=0,  g3a16=0,  g3a17=0,  g3a18=0,  g3a19=0,  g3a199=0, ".
" g3a21=0, g3a22=0,  g3a23=0,  g3a24=0,  g3a25=0,  g3a26=0,  g3a27=0,  g3a299=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$zisk=0;

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE LEFT(uce,3) = 431 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zisk=1*($riaddok->pda-$riaddok->pmd);
  }

//echo "z".$zisk;
//exit;

$pocet=1;

while( $pocet < 2 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 8 )
  {

$hod=0;


if( $nacitaj == 1 ) { $podmmd="psys >= 1 AND ( LEFT(ucd,3) = 431 ) AND ( LEFT(ucm,3) = 421 )"; $podmdl="psys >= 1 AND ( LEFT(ucm,3) = 431 ) AND ( LEFT(ucd,3) = 421 )"; }
if( $nacitaj == 2 ) { $podmmd="psys >= 1 AND ( LEFT(ucd,3) = 431 ) AND ( LEFT(ucm,3) = 423 OR LEFT(ucm,3) = 427 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucm,3) = 431 ) AND ( LEFT(ucd,3) = 423 OR LEFT(ucd,3) = 427 )"; }
if( $nacitaj == 3 ) { $podmmd="psys >= 1 AND ( LEFT(ucd,3) = 431 ) AND ( LEFT(ucm,3) = 441 OR LEFT(ucm,3) = 472 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucm,3) = 431 ) AND ( LEFT(ucd,3) = 441 OR LEFT(ucd,3) = 472 )"; }
if( $nacitaj == 4 ) { $podmmd="psys >= 1 AND ( LEFT(ucd,3) = 431 ) AND ( LEFT(ucm,3) = 411 )"; $podmdl="psys >= 1 AND ( LEFT(ucm,3) = 431 ) AND ( LEFT(ucd,3) = 411 )"; }
if( $nacitaj == 5 ) { $podmmd="psys >= 1 AND ( LEFT(ucd,3) = 431 ) AND ( LEFT(ucm,3) = 429 )"; $podmdl="psys >= 1 AND ( LEFT(ucm,3) = 431 ) AND ( LEFT(ucd,3) = 429 )"; }
if( $nacitaj == 6 ) { $podmmd="psys >= 1 AND ( LEFT(ucd,3) = 431 ) AND ( LEFT(ucm,3) = 428 )"; $podmdl="psys >= 1 AND ( LEFT(ucm,3) = 431 ) AND ( LEFT(ucd,3) = 428 )"; }
if( $nacitaj == 7 ) { $podmmd="psys >= 1 AND ( LEFT(ucd,3) = 431 ) AND ( LEFT(ucm,3) = 354 OR LEFT(ucm,3) = 364 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucm,3) = 431 ) AND ( LEFT(ucd,3) = 354 OR LEFT(ucd,3) = 364 )"; }

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

if( $pocet == 1 AND $zisk > 0 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a12='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a13='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a14='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a15='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a16='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a17='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a18='$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 1 AND $zisk < 0 )
  {
$hod=-1*$hod;

if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a22='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a23='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a24='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a25='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a26='$hod'  WHERE psys >= 0 "; }

  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 AND $zisk > 0 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a11='$zisk'  WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a19=g3a11-g3a12-g3a13-g3a14-g3a15-g3a16-g3a17-g3a18  WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a199=g3a12+g3a13+g3a14+g3a15+g3a16+g3a17+g3a18+g3a19  WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt"); 
  }

if( $pocet == 1 AND $zisk < 0 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a21=-1*'$zisk' WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a27=g3a21-g3a22-g3a23-g3a24-g3a25-g3a26  WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET g3a299=g3a22+g3a23+g3a24+g3a25+g3a26+g3a27  WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt"); 
  }

$pocet=$pocet+1;
    }

}
//koniec copern=503 rozdelenie zisku straty


//copern=502 zapis do poznamky_po2011s2 z obratovky cas.rozlisenie aktiva
if( $copern == 502 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1zb12=0, f1zb13=0, f1zb22=0, f1zb23=0, f1zb32=0, f1zb33=0, ".
" f2zb12=0, f2zb13=0, f2zb22=0, f2zb23=0, f2zb32=0, f2zb33=0, ".
" f3zb12=0, f3zb13=0, f3zb22=0, f3zb23=0, f3zb32=0, f3zb33=0, ".
" f4zb12=0, f4zb13=0, f4zb22=0, f4zb23=0, f4zb32=0, f4zb33=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 3 )
  {

$hod=0; $pri=0; $uby=0;


if( $nacitaj == 1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 381 OR LEFT(ucm,3) = 382 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 381 OR LEFT(ucd,3) = 382 )"; }
if( $nacitaj == 2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 385 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 385 )"; }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod-$polozka->hod; }
}
$i=$i+1;                   }

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2zb12='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f4zb12='$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2zb13='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f4zb13='$hod'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {

  }

if( $pocet == 2 )
  {

  }

$pocet=$pocet+1;
    }

}
//koniec copern=502 zapis do poznamky_po2011s2 z obratovky cas.rozlisenie aktiva



//zapis do poznamky_po2011 z obratovky udaje o kr.fin.maj
if( $copern == 501 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1w11=0, f1w21=0, f1w31=0, f1w41=0, f1w991=0, ".
" f1w12=0, f1w22=0, f1w32=0, f1w42=0, f1w992=0  ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 4 )
  {

$hod=0; $pri=0; $uby=0;


if( $nacitaj == 1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,2) = 21 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,2) = 21 )"; }
if( $nacitaj == 2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 221 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 221 )"; }
if( $nacitaj == 3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 261 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 261 )"; }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod-$polozka->hod; }
}
$i=$i+1;                   }

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1w11='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1w21='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1w41='$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1w12='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1w22='$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1w42='$hod'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1w991=f1w11+f1w21+f1w31+f1w41  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

  }

if( $pocet == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1w992=f1w12+f1w22+f1w32+f1w42  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

$pocet=$pocet+1;
    }

}
//koniec copern=501 zapis do poznamky_po2011s2 z obratovky udaje kr.fin.majetku


// copern=401 zapis do poznamky_po2011 z obratovky,salda struktura pohladavok
if( $copern == 401 )
{

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1s1b=0, f1s2b=0, f1s3b=0, f1s4b=0, f1s5b=0, f1s6b=0, f1s7b=0, f1s8b=0, f1s9b=0, f1s10b=0, f1s11b=0, f1s12b=0, f1s13b=0, f1s14b=0,  ".
" f1s1c=0, f1s2c=0, f1s3c=0, f1s4c=0, f1s5c=0, f1s6c=0, f1s7c=0, f1s8c=0, f1s9c=0, f1s10c=0, f1s11c=0, f1s12c=0, f1s13c=0, f1s14c=0,  ".
" f1s1d=0, f1s2d=0, f1s3d=0, f1s4d=0, f1s5d=0, f1s6d=0, f1s7d=0, f1s8d=0, f1s9d=0, f1s10d=0, f1s11d=0, f1s12d=0, f1s13d=0, f1s14d=0,  ".
" f2s1b=0, f2s2b=0, f2s3b=0, f2s4b=0, f2s5b=0, f2s6b=0,  ".
" f2s1c=0, f2s2c=0, f2s3c=0, f2s4c=0, f2s5c=0, f2s6c=0   ".
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
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 311 OR LEFT(ucm,3) = 312 OR LEFT(ucm,3) = 313 OR LEFT(ucm,3) = 314 OR LEFT(ucm,3) = 315 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 311 OR LEFT(ucd,3) = 312 OR LEFT(ucd,3) = 313 OR LEFT(ucd,3) = 314 OR LEFT(ucd,3) = 315 )"; }
if( $nacitaj ==  2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 351 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 351 )"; }
if( $nacitaj ==  3 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 354 OR LEFT(ucm,3) = 355 OR LEFT(ucm,3) = 358 OR LEFT(ucm,3) = 398 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 354 OR LEFT(ucd,3) = 355 OR LEFT(ucd,3) = 358 OR LEFT(ucd,3) = 398 )"; }
if( $nacitaj ==  4 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 336 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 336 )"; }
if( $nacitaj ==  5 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 335 OR LEFT(ucm,3) = 371 OR LEFT(ucm,3) = 373 OR LEFT(ucm,3) = 374 OR LEFT(ucm,3) = 375 OR LEFT(ucm,3) = 376 OR LEFT(ucm,3) = 378 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 335 OR LEFT(ucd,3) = 371 OR LEFT(ucd,3) = 373 OR LEFT(ucd,3) = 374 OR LEFT(ucd,3) = 375 OR LEFT(ucd,3) = 376 OR LEFT(ucd,3) = 378 )"; }

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
if( $polozka->psys >= 1 ) { $hod=$hod+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys >= 1 ) { $hod=$hod-$polozka->hod; }
}
$i=$i+1;                   }


if( $nacitaj == 4 OR $nacitaj == 6 OR $nacitaj == 7 OR $nacitaj == 8 OR $nacitaj == 9 OR $nacitaj == 10 OR $nacitaj == 11 ) 
{
if( $hod < 0 ) { $hod=0; }
}

if( $pocet == 1 )
  {
if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s7d='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s8d='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s10d='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s11d='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s13d='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s12d='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s12d=f1s12d+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s12d=f1s12d+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s12d=f1s12d+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s12d=f1s12d+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s12d=f1s12d+'$hod'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {

if( $nacitaj ==  1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c='$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s3c=f2s3c+'$hod'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$konrok=$kli_vrok."-12-31";
$uprtxt = "UPDATE F$kli_vxcf"."_prsaldoicofak$kli_uzid SET puc=TO_DAYS('$konrok')-TO_DAYS(das) ";
$upravene = mysql_query("$uprtxt"); 

$podm="puc > 0 AND ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 312 OR LEFT(uce,3) = 313 OR LEFT(uce,3) = 314 OR LEFT(uce,3) = 315 )"; 

$posplt1=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid WHERE $podm "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$posplt1=$posplt1+$polozka->zos;
}
$i=$i+1;                   }


$podm="puc > 0 AND ( LEFT(uce,3) = 378 )"; 

$posplt2=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid WHERE $podm "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$posplt2=$posplt2+$polozka->zos;
}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_prsaldoicofak$kli_uzid SET puc=0 ";
$upravene = mysql_query("$uprtxt"); 

if( $posplt1 < 0 ) $posplt1=0;
if( $posplt2 < 0 ) $posplt2=0;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1s7c='$posplt1', f1s13c='$posplt2'  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 



$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1s1b=f1s1d-f1s1c, f1s2b=f1s2d-f1s2c, f1s3b=f1s3d-f1s3c, f1s4b=f1s4d-f1s4c, f1s5b=f1s5d-f1s5c, f1s6b=f1s6d-f1s6c, ".
" f1s7b=f1s7d-f1s7c, f1s8b=f1s8d-f1s8c, f1s9b=f1s9d-f1s9c, f1s10b=f1s10d-f1s10c, f1s11b=f1s11d-f1s11c, f1s12b=f1s12d-f1s12c, f1s13b=f1s13d-f1s13c ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1s14b=f1s7b+f1s8b+f1s9b+f1s10b+f1s11b+f1s12b+f1s13b, ".
" f1s14c=f1s7c+f1s8c+f1s9c+f1s10c+f1s11c+f1s12c+f1s13c, ".
" f1s14d=f1s7d+f1s8d+f1s9d+f1s10d+f1s11d+f1s12d+f1s13d, ".
" f1s6b=f1s1b+f1s2b+f1s3b+f1s4b+f1s5b, ".
" f1s6c=f1s1c+f1s2c+f1s3c+f1s4c+f1s5c, ".
" f1s6d=f1s1d+f1s2d+f1s3d+f1s4d+f1s5d  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s1b=f1s14c, f2s3b=f1s14d, f2s2b=f2s3b-f2s1b  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s4b=f1s6c, f2s6b=f1s6d, f2s5b=f2s6b-f2s4b  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

if( $pocet == 2 )
  {
$kli_vrom=$kli_vrok-1;
$konrok=$kli_vrom."-12-31";
$uprtxt = "UPDATE ".$databaza."F$h_ycf"."_prsaldoicofak$kli_uzid SET puc=TO_DAYS('$konrok')-TO_DAYS(das) ";
$upravene = mysql_query("$uprtxt"); 

$podm="puc > 0 AND ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 312 OR LEFT(uce,3) = 313 OR LEFT(uce,3) = 314 OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 378 )"; 

$posplm=0;
$sqltt = "SELECT * FROM ".$databaza."F$h_ycf"."_prsaldoicofak$kli_uzid WHERE $podm "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$posplm=$posplm+$polozka->zos;
}
$i=$i+1;                   }



$uprtxt = "UPDATE ".$databaza."F$h_ycf"."_prsaldoicofak$kli_uzid SET puc=0 ";
$upravene = mysql_query("$uprtxt"); 

if( $posplm < 0 ) $posplm=0;


$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s1c='$posplm'   WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2s2c=f2s3c-f2s1c  WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt");
//echo $uprtxt;

  }

$pocet=$pocet+1;
    }
//exit;
}
//koniec copern=401 zapis do poznamky_po2011 z obratovky,salda struktura pohladavok

//zapis do poznamky_po2011 z obratovky udaje o fin.majetku
if( $copern == 302 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1j1b=0, f1j2b=0, f1j3b=0, f1j4b=0, f1j5b=0, f1j6b=0, f1j7b=0, f1j8b=0, f1j9b=0, f1j10b=0, f1j11b=0, f1j12b=0, f1j13b=0, f1j14b=0,  ".
" f1j1c=0, f1j2c=0, f1j3c=0, f1j4c=0, f1j5c=0, f1j6c=0, f1j7c=0, f1j8c=0, f1j9c=0, f1j10c=0, f1j11c=0, f1j12c=0, f1j13c=0, f1j14c=0,  ".
" f1j1d=0, f1j2d=0, f1j3d=0, f1j4d=0, f1j5d=0, f1j6d=0, f1j7d=0, f1j8d=0, f1j9d=0, f1j10d=0, f1j11d=0, f1j12d=0, f1j13d=0, f1j14d=0,  ".
" f1j1e=0, f1j2e=0, f1j3e=0, f1j4e=0, f1j5e=0, f1j6e=0, f1j7e=0, f1j8e=0, f1j9e=0, f1j10e=0, f1j11e=0, f1j12e=0, f1j13e=0, f1j14e=0,  ".
" f1j1f=0, f1j2f=0, f1j3f=0, f1j4f=0, f1j5f=0, f1j6f=0, f1j7f=0, f1j8f=0, f1j9f=0, f1j10f=0, f1j11f=0, f1j12f=0, f1j13f=0, f1j14f=0,  ".
" f1j1g=0, f1j2g=0, f1j3g=0, f1j4g=0, f1j5g=0, f1j6g=0, f1j7g=0, f1j8g=0, f1j9g=0, f1j10g=0, f1j11g=0, f1j12g=0, f1j13g=0, f1j14g=0,  ".
" f1j1h=0, f1j2h=0, f1j3h=0, f1j4h=0, f1j5h=0, f1j6h=0, f1j7h=0, f1j8h=0, f1j9h=0, f1j10h=0, f1j11h=0, f1j12h=0, f1j13h=0, f1j14h=0,  ".
" f1j1i=0, f1j2i=0, f1j3i=0, f1j4i=0, f1j5i=0, f1j6i=0, f1j7i=0, f1j8i=0, f1j9i=0, f1j10i=0, f1j11i=0, f1j12i=0, f1j13i=0, f1j14i=0,  ".
" f1j1j=0, f1j2j=0, f1j3j=0, f1j4j=0, f1j5j=0, f1j6j=0, f1j7j=0, f1j8j=0, f1j9j=0, f1j10j=0, f1j11j=0, f1j12j=0, f1j13j=0, f1j14j=0,  ".

" f2j1b=0, f2j2b=0, f2j3b=0, f2j4b=0, f2j5b=0, f2j6b=0, f2j7b=0, f2j8b=0, f2j9b=0, f2j10b=0, f2j11b=0, f2j12b=0, f2j13b=0, f2j14b=0,  ".
" f2j1c=0, f2j2c=0, f2j3c=0, f2j4c=0, f2j5c=0, f2j6c=0, f2j7c=0, f2j8c=0, f2j9c=0, f2j10c=0, f2j11c=0, f2j12c=0, f2j13c=0, f2j14c=0,  ".
" f2j1d=0, f2j2d=0, f2j3d=0, f2j4d=0, f2j5d=0, f2j6d=0, f2j7d=0, f2j8d=0, f2j9d=0, f2j10d=0, f2j11d=0, f2j12d=0, f2j13d=0, f2j14d=0,  ".
" f2j1e=0, f2j2e=0, f2j3e=0, f2j4e=0, f2j5e=0, f2j6e=0, f2j7e=0, f2j8e=0, f2j9e=0, f2j10e=0, f2j11e=0, f2j12e=0, f2j13e=0, f2j14e=0,  ".
" f2j1f=0, f2j2f=0, f2j3f=0, f2j4f=0, f2j5f=0, f2j6f=0, f2j7f=0, f2j8f=0, f2j9f=0, f2j10f=0, f2j11f=0, f2j12f=0, f2j13f=0, f2j14f=0,  ".
" f2j1g=0, f2j2g=0, f2j3g=0, f2j4g=0, f2j5g=0, f2j6g=0, f2j7g=0, f2j8g=0, f2j9g=0, f2j10g=0, f2j11g=0, f2j12g=0, f2j13g=0, f2j14g=0,  ".
" f2j1h=0, f2j2h=0, f2j3h=0, f2j4h=0, f2j5h=0, f2j6h=0, f2j7h=0, f2j8h=0, f2j9h=0, f2j10h=0, f2j11h=0, f2j12h=0, f2j13h=0, f2j14h=0,  ".
" f2j1i=0, f2j2i=0, f2j3i=0, f2j4i=0, f2j5i=0, f2j6i=0, f2j7i=0, f2j8i=0, f2j9i=0, f2j10i=0, f2j11i=0, f2j12i=0, f2j13i=0, f2j14i=0,  ".
" f2j1j=0, f2j2j=0, f2j3j=0, f2j4j=0, f2j5j=0, f2j6j=0, f2j7j=0, f2j8j=0, f2j9j=0, f2j10j=0, f2j11j=0, f2j12j=0, f2j13j=0, f2j14j=0   ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 9 )
  {

$hod=0; $pri=0; $uby=0;

if( $nacitaj ==  1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 061 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 061 )"; }
if( $nacitaj ==  2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 062 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 062 )"; }
if( $nacitaj ==  3 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 063 OR LEFT(ucm,3) = 065 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 063 OR LEFT(ucd,3) = 065 )"; }
if( $nacitaj ==  4 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 066 OR LEFT(ucm,3) = 067 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 066 OR LEFT(ucd,3) = 067 )"; }
if( $nacitaj ==  5 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 069 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 069 )"; }
if( $nacitaj ==  6 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 043 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 043 )"; }

if( $nacitaj ==  7 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 053 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 053 )"; }
if( $nacitaj ==  8 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 096 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 096 )"; }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $hod=$hod+$polozka->hod; }
if( $polozka->psys == 2 ) { $pri=$pri+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $hod=$hod-$polozka->hod; }
if( $polozka->psys == 2 ) { $uby=$uby+$polozka->hod; }
}
$i=$i+1;                   }

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j1b='$hod', f1j2b='$pri', f1j3b='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j1c='$hod', f1j2c='$pri', f1j3c='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j1d='$hod', f1j2d='$pri', f1j3d='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j1e='$hod', f1j2e='$pri', f1j3e='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j1f='$hod', f1j2f='$pri', f1j3f='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j1h='$hod', f1j2h='$pri', f1j3h='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j1i='$hod', f1j2i='$pri', f1j3i='$uby'  WHERE psys >= 0 "; }

if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f1j6f='$hod', f1j7f='$pri', f1j8f=1*'$uby'  WHERE psys >= 0 "; }

  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j1b='$hod', f2j2b='$pri', f2j3b='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j1c='$hod', f2j2c='$pri', f2j3c='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j1d='$hod', f2j2d='$pri', f2j3d='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j1e='$hod', f2j2e='$pri', f2j3e='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j1f='$hod', f2j2f='$pri', f2j3f='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j1h='$hod', f2j2h='$pri', f2j3h='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j1i='$hod', f2j2i='$pri', f2j3i='$uby'  WHERE psys >= 0 "; }

if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET f2j6f='$hod', f2j7f='$pri', f2j8f=1*'$uby'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1j6j=f1j6b+f1j6c+f1j6d+f1j6e+f1j6f+f1j6g+f1j6h+f1j6i, ".
" f1j7j=f1j7b+f1j7c+f1j7d+f1j7e+f1j7f+f1j7g+f1j7h+f1j7i, ".
" f1j8j=f1j8b+f1j8c+f1j8d+f1j8e+f1j8f+f1j8g+f1j8h+f1j8i, ".

" f1j1j=f1j1b+f1j1c+f1j1d+f1j1e+f1j1f+f1j1g+f1j1h+f1j1i, ".
" f1j2j=f1j2b+f1j2c+f1j2d+f1j2e+f1j2f+f1j2g+f1j2h+f1j2i, ".
" f1j3j=f1j3b+f1j3c+f1j3d+f1j3e+f1j3f+f1j3g+f1j3h+f1j3i  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1j9j=f1j6j+f1j7j-f1j8j, ".
" f1j9i=f1j6i+f1j7i-f1j8i, ".
" f1j9h=f1j6h+f1j7h-f1j8h, ".
" f1j9g=f1j6g+f1j7g-f1j8g, ".
" f1j9f=f1j6f+f1j7f-f1j8f, ".
" f1j9e=f1j6e+f1j7e-f1j8e, ".
" f1j9d=f1j6d+f1j7d-f1j8d, ".
" f1j9c=f1j6c+f1j7c-f1j8c, ".
" f1j9b=f1j6b+f1j7b-f1j8b, ".

" f1j5j=f1j1j+f1j2j-f1j3j+f1j4j, ".
" f1j5i=f1j1i+f1j2i-f1j3i+f1j4i, ".
" f1j5h=f1j1h+f1j2h-f1j3h+f1j4h, ".
" f1j5g=f1j1g+f1j2g-f1j3g+f1j4g, ".
" f1j5f=f1j1f+f1j2f-f1j3f+f1j4f, ".
" f1j5e=f1j1e+f1j2e-f1j3e+f1j4e, ".
" f1j5d=f1j1d+f1j2d-f1j3d+f1j4d, ".
" f1j5c=f1j1c+f1j2c-f1j3c+f1j4c, ".
" f1j5b=f1j1b+f1j2b-f1j3b+f1j4b ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f1j11j=f1j5j+f1j9j, ".
" f1j11i=f1j5i+f1j9i, ".
" f1j11h=f1j5h+f1j9h, ".
" f1j11g=f1j5g+f1j9g, ".
" f1j11f=f1j5f+f1j9f, ".
" f1j11e=f1j5e+f1j9e, ".
" f1j11d=f1j5d+f1j9d, ".
" f1j11c=f1j5c+f1j9c, ".
" f1j11b=f1j5b+f1j9b, ".

" f1j10j=f1j1j+f1j6j, ".
" f1j10i=f1j1i+f1j6i, ".
" f1j10h=f1j1h+f1j6h, ".
" f1j10g=f1j1g+f1j6g, ".
" f1j10f=f1j1f+f1j6f, ".
" f1j10e=f1j1e+f1j6e, ".
" f1j10d=f1j1d+f1j6d, ".
" f1j10c=f1j1c+f1j6c, ".
" f1j10b=f1j11b+f1j6b  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

if( $pocet == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f2j6j=f2j6b+f2j6c+f2j6d+f2j6e+f2j6f+f2j6g+f2j6h+f2j6i, ".
" f2j7j=f2j7b+f2j7c+f2j7d+f2j7e+f2j7f+f2j7g+f2j7h+f2j7i, ".
" f2j8j=f2j8b+f2j8c+f2j8d+f2j8e+f2j8f+f2j8g+f2j8h+f2j8i, ".

" f2j1j=f2j1b+f2j1c+f2j1d+f2j1e+f2j1f+f2j1g+f2j1h+f2j1i, ".
" f2j2j=f2j2b+f2j2c+f2j2d+f2j2e+f2j2f+f2j2g+f2j2h+f2j2i, ".
" f2j3j=f2j3b+f2j3c+f2j3d+f2j3e+f2j3f+f2j3g+f2j3h+f2j3i  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f2j9j=f2j6j+f2j7j-f2j8j, ".
" f2j9i=f2j6i+f2j7i-f2j8i, ".
" f2j9h=f2j6h+f2j7h-f2j8h, ".
" f2j9g=f2j6g+f2j7g-f2j8g, ".
" f2j9f=f2j6f+f2j7f-f2j8f, ".
" f2j9e=f2j6e+f2j7e-f2j8e, ".
" f2j9d=f2j6d+f2j7d-f2j8d, ".
" f2j9c=f2j6c+f2j7c-f2j8c, ".
" f2j9b=f2j6b+f2j7b-f2j8b, ".

" f2j5j=f2j1j+f2j2j-f2j3j+f2j4j, ".
" f2j5i=f2j1i+f2j2i-f2j3i+f2j4i, ".
" f2j5h=f2j1h+f2j2h-f2j3h+f2j4h, ".
" f2j5g=f2j1g+f2j2g-f2j3g+f2j4g, ".
" f2j5f=f2j1f+f2j2f-f2j3f+f2j4f, ".
" f2j5e=f2j1e+f2j2e-f2j3e+f2j4e, ".
" f2j5d=f2j1d+f2j2d-f2j3d+f2j4d, ".
" f2j5c=f2j1c+f2j2c-f2j3c+f2j4c, ".
" f2j5b=f2j1b+f2j2b-f2j3b+f2j4b ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011s2 SET ".
" f2j11j=f2j5j+f2j9j, ".
" f2j11i=f2j5i+f2j9i, ".
" f2j11h=f2j5h+f2j9h, ".
" f2j11g=f2j5g+f2j9g, ".
" f2j11f=f2j5f+f2j9f, ".
" f2j11e=f2j5e+f2j9e, ".
" f2j11d=f2j5d+f2j9d, ".
" f2j11c=f2j5c+f2j9c, ".
" f2j11b=f2j5b+f2j9b, ".

" f2j10j=f2j1j+f2j6j, ".
" f2j10i=f2j1i+f2j6i, ".
" f2j10h=f2j1h+f2j6h, ".
" f2j10g=f2j1g+f2j6g, ".
" f2j10f=f2j1f+f2j6f, ".
" f2j10e=f2j1e+f2j6e, ".
" f2j10d=f2j1d+f2j6d, ".
" f2j10c=f2j1c+f2j6c, ".
" f2j10b=f2j11b+f2j6b  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

$pocet=$pocet+1;
    }

}
//koniec copern=302 zapis do poznamky_po2011 z obratovky udaje o fin.majetku

//zapis do poznamky_po2011 z obratovky udaje o nehm.majetku
if( $copern == 301 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f1a11b=0, f1a12b=0, f1a13b=0, f1a14b=0, f1a15b=0, f1a16b=0, f1a17b=0, f1a18b=0, f1a19b=0, f1a110b=0, f1a111b=0, f1a112b=0, f1a113b=0, f1a114b=0,  ".
" f1a11c=0, f1a12c=0, f1a13c=0, f1a14c=0, f1a15c=0, f1a16c=0, f1a17c=0, f1a18c=0, f1a19c=0, f1a110c=0, f1a111c=0, f1a112c=0, f1a113c=0, f1a114c=0,  ".
" f1a11d=0, f1a12d=0, f1a13d=0, f1a14d=0, f1a15d=0, f1a16d=0, f1a17d=0, f1a18d=0, f1a19d=0, f1a110d=0, f1a111d=0, f1a112d=0, f1a113d=0, f1a114d=0,  ".
" f1a11e=0, f1a12e=0, f1a13e=0, f1a14e=0, f1a15e=0, f1a16e=0, f1a17e=0, f1a18e=0, f1a19e=0, f1a110e=0, f1a111e=0, f1a112e=0, f1a113e=0, f1a114e=0,  ".
" f1a11f=0, f1a12f=0, f1a13f=0, f1a14f=0, f1a15f=0, f1a16f=0, f1a17f=0, f1a18f=0, f1a19f=0, f1a110f=0, f1a111f=0, f1a112f=0, f1a113f=0, f1a114f=0,  ".
" f1a11g=0, f1a12g=0, f1a13g=0, f1a14g=0, f1a15g=0, f1a16g=0, f1a17g=0, f1a18g=0, f1a19g=0, f1a110g=0, f1a111g=0, f1a112g=0, f1a113g=0, f1a114g=0,  ".
" f1a11h=0, f1a12h=0, f1a13h=0, f1a14h=0, f1a15h=0, f1a16h=0, f1a17h=0, f1a18h=0, f1a19h=0, f1a110h=0, f1a111h=0, f1a112h=0, f1a113h=0, f1a114h=0,  ".
" f1a11i=0, f1a12i=0, f1a13i=0, f1a14i=0, f1a15i=0, f1a16i=0, f1a17i=0, f1a18i=0, f1a19i=0, f1a110i=0, f1a111i=0, f1a112i=0, f1a113i=0, f1a114i=0,  ".

" f1a21b=0, f1a22b=0, f1a23b=0, f1a24b=0, f1a25b=0, f1a26b=0, f1a27b=0, f1a28b=0, f1a29b=0, f1a210b=0, f1a211b=0, f1a212b=0, f1a213b=0, f1a214b=0,  ".
" f1a21c=0, f1a22c=0, f1a23c=0, f1a24c=0, f1a25c=0, f1a26c=0, f1a27c=0, f1a28c=0, f1a29c=0, f1a210c=0, f1a211c=0, f1a212c=0, f1a213c=0, f1a214c=0,  ".
" f1a21d=0, f1a22d=0, f1a23d=0, f1a24d=0, f1a25d=0, f1a26d=0, f1a27d=0, f1a28d=0, f1a29d=0, f1a210d=0, f1a211d=0, f1a212d=0, f1a213d=0, f1a214d=0,  ".
" f1a21e=0, f1a22e=0, f1a23e=0, f1a24e=0, f1a25e=0, f1a26e=0, f1a27e=0, f1a28e=0, f1a29e=0, f1a210e=0, f1a211e=0, f1a212e=0, f1a213e=0, f1a214e=0,  ".
" f1a21f=0, f1a22f=0, f1a23f=0, f1a24f=0, f1a25f=0, f1a26f=0, f1a27f=0, f1a28f=0, f1a29f=0, f1a210f=0, f1a211f=0, f1a212f=0, f1a213f=0, f1a214f=0,  ".
" f1a21g=0, f1a22g=0, f1a23g=0, f1a24g=0, f1a25g=0, f1a26g=0, f1a27g=0, f1a28g=0, f1a29g=0, f1a210g=0, f1a211g=0, f1a212g=0, f1a213g=0, f1a214g=0,  ".
" f1a21h=0, f1a22h=0, f1a23h=0, f1a24h=0, f1a25h=0, f1a26h=0, f1a27h=0, f1a28h=0, f1a29h=0, f1a210h=0, f1a211h=0, f1a212h=0, f1a213h=0, f1a214h=0,  ".
" f1a21i=0, f1a22i=0, f1a23i=0, f1a24i=0, f1a25i=0, f1a26i=0, f1a27i=0, f1a28i=0, f1a29i=0, f1a210i=0, f1a211i=0, f1a212i=0, f1a213i=0, f1a214i=0   ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 14 )
  {

$hod=0; $pri=0; $uby=0;

if( $nacitaj == 1 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 011 OR LEFT(ucm,3) = 012 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 011 OR LEFT(ucd,3) = 012 )"; }
if( $nacitaj == 2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 013 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 013 )"; }
if( $nacitaj == 3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 014 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 014 )"; }
if( $nacitaj == 4 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 015 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 015 )"; }
if( $nacitaj == 5 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 018 OR LEFT(ucm,3) = 019 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 018 OR LEFT(ucd,3) = 019 )"; }
if( $nacitaj == 6 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 041 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 041 )"; }
if( $nacitaj == 7 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 051 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 051 )"; }

if( $nacitaj ==  8 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 071 OR LEFT(ucm,3) = 072 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 071 OR LEFT(ucd,3) = 072 )"; }
if( $nacitaj ==  9 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 073 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 073 )"; }
if( $nacitaj == 10 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 074 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 074 )"; }
if( $nacitaj == 11 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 075 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 075 )"; }
if( $nacitaj == 12 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 078 OR LEFT(ucm,3) = 078 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 079 OR LEFT(ucd,3) = 079 )"; }

if( $nacitaj == 13 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 091 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 091 )"; }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $hod=$hod+$polozka->hod; }
if( $polozka->psys == 2 ) { $pri=$pri+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $hod=$hod-$polozka->hod; }
if( $polozka->psys == 2 ) { $uby=$uby+$polozka->hod; }
}
$i=$i+1;                   }

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a11b='$hod', f1a12b='$pri', f1a13b='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a11c='$hod', f1a12c='$pri', f1a13c='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a11d='$hod', f1a12d='$pri', f1a13d='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a11e='$hod', f1a12e='$pri', f1a13e='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a11f='$hod', f1a12f='$pri', f1a13f='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a11g='$hod', f1a12g='$pri', f1a13g='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a11h='$hod', f1a12h='$pri', f1a13h='$uby'  WHERE psys >= 0 "; }

if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a16b=-1*'$hod', f1a17b=1*'$uby', f1a18b=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a16c=-1*'$hod', f1a17c=1*'$uby', f1a18c=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a16d=-1*'$hod', f1a17d=1*'$uby', f1a18d=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a16e=-1*'$hod', f1a17e=1*'$uby', f1a18e=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 12 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a16f=-1*'$hod', f1a17f=1*'$uby', f1a18f=1*'$pri'  WHERE psys >= 0 "; }

if( $nacitaj == 13 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a110f='$hod', f1a111f='$pri', f1a112f='$uby'  WHERE psys >= 0 "; }

  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a21b='$hod', f1a22b='$pri', f1a23b='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a21c='$hod', f1a22c='$pri', f1a23c='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a21d='$hod', f1a22d='$pri', f1a23d='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a21e='$hod', f1a22e='$pri', f1a23e='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a21f='$hod', f1a22f='$pri', f1a23f='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a21g='$hod', f1a22g='$pri', f1a23g='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a21h='$hod', f1a22h='$pri', f1a23h='$uby'  WHERE psys >= 0 "; }

if( $nacitaj ==  8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a26c=-1*'$hod', f1a27c=1*'$uby', f1a28c=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a26c=-1*'$hod', f1a27c=1*'$uby', f1a28c=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a26d=-1*'$hod', f1a27d=1*'$uby', f1a28d=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a26e=-1*'$hod', f1a27e=1*'$uby', f1a28e=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 12 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a26f=-1*'$hod', f1a27f=1*'$uby', f1a28f=1*'$pri'  WHERE psys >= 0 "; }

if( $nacitaj == 13 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f1a210f='$hod', f1a211f='$pri', f1a212f='$uby'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f1a110i=f1a110b+f1a110c+f1a110d+f1a110e+f1a110f+f1a110g+f1a110h, ".
" f1a111i=f1a111b+f1a111c+f1a111d+f1a111e+f1a111f+f1a111g+f1a111h, ".
" f1a112i=f1a112b+f1a112c+f1a112d+f1a112e+f1a112f+f1a112g+f1a112h, ".

" f1a16i=f1a16b+f1a16c+f1a16d+f1a16e+f1a16f+f1a16g+f1a16h, ".
" f1a17i=f1a17b+f1a17c+f1a17d+f1a17e+f1a17f+f1a17g+f1a17h, ".
" f1a18i=f1a18b+f1a18c+f1a18d+f1a18e+f1a18f+f1a18g+f1a18h, ".

" f1a11i=f1a11b+f1a11c+f1a11d+f1a11e+f1a11f+f1a11g+f1a11h, ".
" f1a12i=f1a12b+f1a12c+f1a12d+f1a12e+f1a12f+f1a12g+f1a12h, ".
" f1a13i=f1a13b+f1a13c+f1a13d+f1a13e+f1a13f+f1a13g+f1a13h  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f1a113i=f1a110i+f1a111i-f1a112i, ".
" f1a113h=f1a110h+f1a111h-f1a112h, ".
" f1a113g=f1a110g+f1a111g-f1a112g, ".
" f1a113f=f1a110f+f1a111f-f1a112f, ".
" f1a113e=f1a110e+f1a111e-f1a112e, ".
" f1a113d=f1a110d+f1a111d-f1a112d, ".
" f1a113c=f1a110c+f1a111c-f1a112c, ".
" f1a113b=f1a110b+f1a111b-f1a112b, ".

" f1a19i=f1a16i+f1a17i-f1a18i, ".
" f1a19h=f1a16h+f1a17h-f1a18h, ".
" f1a19g=f1a16g+f1a17g-f1a18g, ".
" f1a19f=f1a16f+f1a17f-f1a18f, ".
" f1a19e=f1a16e+f1a17e-f1a18e, ".
" f1a19d=f1a16d+f1a17d-f1a18d, ".
" f1a19c=f1a16c+f1a17c-f1a18c, ".
" f1a19b=f1a16b+f1a17b-f1a18b, ".

" f1a15i=f1a11i+f1a12i-f1a13i+f1a14i, ".
" f1a15h=f1a11h+f1a12h-f1a13h+f1a14h, ".
" f1a15g=f1a11g+f1a12g-f1a13g+f1a14g, ".
" f1a15f=f1a11f+f1a12f-f1a13f+f1a14f, ".
" f1a15e=f1a11e+f1a12e-f1a13e+f1a14e, ".
" f1a15d=f1a11d+f1a12d-f1a13d+f1a14d, ".
" f1a15c=f1a11c+f1a12c-f1a13c+f1a14c, ".
" f1a15b=f1a11b+f1a12b-f1a13b+f1a14b ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f1a115i=f1a15i-f1a19i+f1a113i, ".
" f1a115h=f1a15h-f1a19h+f1a113h, ".
" f1a115g=f1a15g-f1a19g+f1a113g, ".
" f1a115f=f1a15f-f1a19f+f1a113f, ".
" f1a115e=f1a15e-f1a19e+f1a113e, ".
" f1a115d=f1a15d-f1a19d+f1a113d, ".
" f1a115c=f1a15c-f1a19c+f1a113c, ".
" f1a115b=f1a15b-f1a19b+f1a113b, ".

" f1a114i=f1a11i-f1a16i+f1a110i, ".
" f1a114h=f1a11h-f1a16h+f1a110h, ".
" f1a114g=f1a11g-f1a16g+f1a110g, ".
" f1a114f=f1a11f-f1a16f+f1a110f, ".
" f1a114e=f1a11e-f1a16e+f1a110e, ".
" f1a114d=f1a11d-f1a16d+f1a110d, ".
" f1a114c=f1a11c-f1a16c+f1a110c, ".
" f1a114b=f1a11b-f1a16b+f1a110b  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

if( $pocet == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f1a210i=f1a210b+f1a210c+f1a210d+f1a210e+f1a210f+f1a210g+f1a210h, ".
" f1a211i=f1a211b+f1a211c+f1a211d+f1a211e+f1a211f+f1a211g+f1a211h, ".
" f1a212i=f1a212b+f1a212c+f1a212d+f1a212e+f1a212f+f1a212g+f1a212h, ".

" f1a26i=f1a26b+f1a26c+f1a26d+f1a26e+f1a26f+f1a26g+f1a26h, ".
" f1a27i=f1a27b+f1a27c+f1a27d+f1a27e+f1a27f+f1a27g+f1a27h, ".
" f1a28i=f1a28b+f1a28c+f1a28d+f1a28e+f1a28f+f1a28g+f1a28h, ".

" f1a21i=f1a21b+f1a21c+f1a21d+f1a21e+f1a21f+f1a21g+f1a21h, ".
" f1a22i=f1a22b+f1a22c+f1a22d+f1a22e+f1a22f+f1a22g+f1a22h, ".
" f1a23i=f1a23b+f1a23c+f1a23d+f1a23e+f1a23f+f1a23g+f1a23h  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f1a213i=f1a210i+f1a211i-f1a212i, ".
" f1a213h=f1a210h+f1a211h-f1a212h, ".
" f1a213g=f1a210g+f1a211g-f1a212g, ".
" f1a213f=f1a210f+f1a211f-f1a212f, ".
" f1a213e=f1a210e+f1a211e-f1a212e, ".
" f1a213d=f1a210d+f1a211d-f1a212d, ".
" f1a213c=f1a210c+f1a211c-f1a212c, ".
" f1a213b=f1a210b+f1a211b-f1a212b, ".

" f1a29i=f1a26i+f1a27i-f1a28i, ".
" f1a29h=f1a26h+f1a27h-f1a28h, ".
" f1a29g=f1a26g+f1a27g-f1a28g, ".
" f1a29f=f1a26f+f1a27f-f1a28f, ".
" f1a29e=f1a26e+f1a27e-f1a28e, ".
" f1a29d=f1a26d+f1a27d-f1a28d, ".
" f1a29c=f1a26c+f1a27c-f1a28c, ".
" f1a29b=f1a26b+f1a27b-f1a28b, ".

" f1a25i=f1a21i+f1a22i-f1a23i+f1a24i, ".
" f1a25h=f1a21h+f1a22h-f1a23h+f1a24h, ".
" f1a25g=f1a21g+f1a22g-f1a23g+f1a24g, ".
" f1a25f=f1a21f+f1a22f-f1a23f+f1a24f, ".
" f1a25e=f1a21e+f1a22e-f1a23e+f1a24e, ".
" f1a25d=f1a21d+f1a22d-f1a23d+f1a24d, ".
" f1a25c=f1a21c+f1a22c-f1a23c+f1a24c, ".
" f1a25b=f1a21b+f1a22b-f1a23b+f1a24b ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f1a215i=f1a25i-f1a29i+f1a213i, ".
" f1a215h=f1a25h-f1a29h+f1a213h, ".
" f1a215g=f1a25g-f1a29g+f1a213g, ".
" f1a215f=f1a25f-f1a29f+f1a213f, ".
" f1a215e=f1a25e-f1a29e+f1a213e, ".
" f1a215d=f1a25d-f1a29d+f1a213d, ".
" f1a215c=f1a25c-f1a29c+f1a213c, ".
" f1a215b=f1a25b-f1a29b+f1a213b, ".

" f1a214i=f1a21i-f1a26i+f1a210i, ".
" f1a214h=f1a21h-f1a26h+f1a210h, ".
" f1a214g=f1a21g-f1a26g+f1a210g, ".
" f1a214f=f1a21f-f1a26f+f1a210f, ".
" f1a214e=f1a21e-f1a26e+f1a210e, ".
" f1a214d=f1a21d-f1a26d+f1a210d, ".
" f1a214c=f1a21c-f1a26c+f1a210c, ".
" f1a214b=f1a21b-f1a26b+f1a210b  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

$pocet=$pocet+1;
    }

}
//koniec copern=301 zapis do poznamky_po2011 z obratovky udaje o nehm.majetku 


//zapis do poznamky_po2011 z obratovky udaje o hm.majetku
if( $copern == 300 )
{

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f2a11b=0, f2a12b=0, f2a13b=0, f2a14b=0, f2a15b=0, f2a16b=0, f2a17b=0, f2a18b=0, f2a19b=0, f2a110b=0, f2a111b=0, f2a112b=0, f2a113b=0, f2a114b=0,  ".
" f2a11c=0, f2a12c=0, f2a13c=0, f2a14c=0, f2a15c=0, f2a16c=0, f2a17c=0, f2a18c=0, f2a19c=0, f2a110c=0, f2a111c=0, f2a112c=0, f2a113c=0, f2a114c=0,  ".
" f2a11d=0, f2a12d=0, f2a13d=0, f2a14d=0, f2a15d=0, f2a16d=0, f2a17d=0, f2a18d=0, f2a19d=0, f2a110d=0, f2a111d=0, f2a112d=0, f2a113d=0, f2a114d=0,  ".
" f2a11e=0, f2a12e=0, f2a13e=0, f2a14e=0, f2a15e=0, f2a16e=0, f2a17e=0, f2a18e=0, f2a19e=0, f2a110e=0, f2a111e=0, f2a112e=0, f2a113e=0, f2a114e=0,  ".
" f2a11f=0, f2a12f=0, f2a13f=0, f2a14f=0, f2a15f=0, f2a16f=0, f2a17f=0, f2a18f=0, f2a19f=0, f2a110f=0, f2a111f=0, f2a112f=0, f2a113f=0, f2a114f=0,  ".
" f2a11g=0, f2a12g=0, f2a13g=0, f2a14g=0, f2a15g=0, f2a16g=0, f2a17g=0, f2a18g=0, f2a19g=0, f2a110g=0, f2a111g=0, f2a112g=0, f2a113g=0, f2a114g=0,  ".
" f2a11h=0, f2a12h=0, f2a13h=0, f2a14h=0, f2a15h=0, f2a16h=0, f2a17h=0, f2a18h=0, f2a19h=0, f2a110h=0, f2a111h=0, f2a112h=0, f2a113h=0, f2a114h=0,  ".
" f2a11i=0, f2a12i=0, f2a13i=0, f2a14i=0, f2a15i=0, f2a16i=0, f2a17i=0, f2a18i=0, f2a19i=0, f2a110i=0, f2a111i=0, f2a112i=0, f2a113i=0, f2a114i=0,  ".
" f2a11j=0, f2a12j=0, f2a13j=0, f2a14j=0, f2a15j=0, f2a16j=0, f2a17j=0, f2a18j=0, f2a19j=0, f2a110j=0, f2a111j=0, f2a112j=0, f2a113j=0, f2a114j=0,  ".

" f2a21b=0, f2a22b=0, f2a23b=0, f2a24b=0, f2a25b=0, f2a26b=0, f2a27b=0, f2a28b=0, f2a29b=0, f2a210b=0, f2a211b=0, f2a212b=0, f2a213b=0, f2a214b=0,  ".
" f2a21c=0, f2a22c=0, f2a23c=0, f2a24c=0, f2a25c=0, f2a26c=0, f2a27c=0, f2a28c=0, f2a29c=0, f2a210c=0, f2a211c=0, f2a212c=0, f2a213c=0, f2a214c=0,  ".
" f2a21d=0, f2a22d=0, f2a23d=0, f2a24d=0, f2a25d=0, f2a26d=0, f2a27d=0, f2a28d=0, f2a29d=0, f2a210d=0, f2a211d=0, f2a212d=0, f2a213d=0, f2a214d=0,  ".
" f2a21e=0, f2a22e=0, f2a23e=0, f2a24e=0, f2a25e=0, f2a26e=0, f2a27e=0, f2a28e=0, f2a29e=0, f2a210e=0, f2a211e=0, f2a212e=0, f2a213e=0, f2a214e=0,  ".
" f2a21f=0, f2a22f=0, f2a23f=0, f2a24f=0, f2a25f=0, f2a26f=0, f2a27f=0, f2a28f=0, f2a29f=0, f2a210f=0, f2a211f=0, f2a212f=0, f2a213f=0, f2a214f=0,  ".
" f2a21g=0, f2a22g=0, f2a23g=0, f2a24g=0, f2a25g=0, f2a26g=0, f2a27g=0, f2a28g=0, f2a29g=0, f2a210g=0, f2a211g=0, f2a212g=0, f2a213g=0, f2a214g=0,  ".
" f2a21h=0, f2a22h=0, f2a23h=0, f2a24h=0, f2a25h=0, f2a26h=0, f2a27h=0, f2a28h=0, f2a29h=0, f2a210h=0, f2a211h=0, f2a212h=0, f2a213h=0, f2a214h=0,  ".
" f2a21i=0, f2a22i=0, f2a23i=0, f2a24i=0, f2a25i=0, f2a26i=0, f2a27i=0, f2a28i=0, f2a29i=0, f2a210i=0, f2a211i=0, f2a212i=0, f2a213i=0, f2a214i=0,  ".
" f2a21j=0, f2a22j=0, f2a23j=0, f2a24j=0, f2a25j=0, f2a26j=0, f2a27j=0, f2a28j=0, f2a29j=0, f2a210j=0, f2a211j=0, f2a212j=0, f2a213j=0, f2a214j=0   ".
" WHERE psys >= 0 ";
$upravene = mysql_query("$uprtxt");

$pocet=1;

while( $pocet < 3 )  
    {

$nacitaj=1;
$minuly="";
if( $pocet == 2 ) { $minuly="min"; }
while( $nacitaj < 16 )
  {

$hod=0; $pri=0; $uby=0;

if( $nacitaj == 1 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 031 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 031 )"; }
if( $nacitaj == 2 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 021 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 021 )"; }
if( $nacitaj == 3 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 022 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 022 )"; }
if( $nacitaj == 4 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 025 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 025 )"; }
if( $nacitaj == 5 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 026 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 026 )"; }
if( $nacitaj == 6 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 023 OR LEFT(ucm,3) = 024 OR LEFT(ucm,3) = 027 OR LEFT(ucm,3) = 029 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 023 OR LEFT(ucd,3) = 024 OR LEFT(ucd,3) = 027 OR LEFT(ucd,3) = 029 )"; }
if( $nacitaj == 7 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 042 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 042 )"; }
if( $nacitaj == 8 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 052 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 052 )"; }

if( $nacitaj ==  9 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 081 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 081 )"; }
if( $nacitaj == 10 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 082 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 082 )"; }
if( $nacitaj == 11 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 085 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 085 )"; }
if( $nacitaj == 12 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 086 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 086 )"; }
if( $nacitaj == 13 ) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 083 OR LEFT(ucm,3) = 084 OR LEFT(ucm,3) = 087 OR LEFT(ucm,3) = 089 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 083 OR LEFT(ucd,3) = 084 OR LEFT(ucd,3) = 087 OR LEFT(ucd,3) = 089 )"; }


if( $nacitaj == 14) { 
$podmmd="psys >= 1 AND ( LEFT(ucm,3) = 092 OR LEFT(ucm,3) = 097 OR LEFT(ucm,3) = 098 )"; 
$podmdl="psys >= 1 AND ( LEFT(ucd,3) = 092 OR LEFT(ucd,3) = 097 OR LEFT(ucd,3) = 098 )"; }
if( $nacitaj == 15 ) { $podmmd="psys >= 1 AND ( LEFT(ucm,3) = 094 )"; $podmdl="psys >= 1 AND ( LEFT(ucd,3) = 094 )"; }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmmd "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $hod=$hod+$polozka->hod; }
if( $polozka->psys == 2 ) { $pri=$pri+$polozka->hod; }
}
$i=$i+1;                   }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minuly$kli_uzid WHERE $podmdl "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->psys == 1 ) { $hod=$hod-$polozka->hod; }
if( $polozka->psys == 2 ) { $uby=$uby+$polozka->hod; }
}
$i=$i+1;                   }

if( $pocet == 1 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11b='$hod', f2a12b='$pri', f2a13b='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11c='$hod', f2a12c='$pri', f2a13c='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11d='$hod', f2a12d='$pri', f2a13d='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11e='$hod', f2a12e='$pri', f2a13e='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11f='$hod', f2a12f='$pri', f2a13f='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11g='$hod', f2a12g='$pri', f2a13g='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11h='$hod', f2a12h='$pri', f2a13h='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a11i='$hod', f2a12i='$pri', f2a13i='$uby'  WHERE psys >= 0 "; }

if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a16c=-1*'$hod', f2a17c=1*'$uby', f2a18c=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a16d=-1*'$hod', f2a17d=1*'$uby', f2a18d=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a16e=-1*'$hod', f2a17e=1*'$uby', f2a18e=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 12 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a16f=-1*'$hod', f2a17f=1*'$uby', f2a18f=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 13 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a16g=-1*'$hod', f2a17g=1*'$uby', f2a18g=1*'$pri'  WHERE psys >= 0 "; }

if( $nacitaj == 14 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a110g='$hod', f2a111g='$pri', f2a112g='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 15 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a110h='$hod', f2a111h='$pri', f2a112h='$uby'  WHERE psys >= 0 "; }
  }

if( $pocet == 2 )
  {
if( $nacitaj == 1 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21b='$hod', f2a22b='$pri', f2a23b='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 2 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21c='$hod', f2a22c='$pri', f2a23c='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 3 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21d='$hod', f2a22d='$pri', f2a23d='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 4 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21e='$hod', f2a22e='$pri', f2a23e='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 5 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21f='$hod', f2a22f='$pri', f2a23f='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 6 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21g='$hod', f2a22g='$pri', f2a23g='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 7 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21h='$hod', f2a22h='$pri', f2a23h='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 8 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a21i='$hod', f2a22i='$pri', f2a23i='$uby'  WHERE psys >= 0 "; }

if( $nacitaj ==  9 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a26c=-1*'$hod', f2a27c=1*'$uby', f2a28c=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 10 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a26d=-1*'$hod', f2a27d=1*'$uby', f2a28d=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 11 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a26e=-1*'$hod', f2a27e=1*'$uby', f2a28e=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 12 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a26f=-1*'$hod', f2a27f=1*'$uby', f2a28f=1*'$pri'  WHERE psys >= 0 "; }
if( $nacitaj == 13 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a26g=-1*'$hod', f2a27g=1*'$uby', f2a28g=1*'$pri'  WHERE psys >= 0 "; }

if( $nacitaj == 14 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a210g='$hod', f2a211g='$pri', f2a212g='$uby'  WHERE psys >= 0 "; }
if( $nacitaj == 15 ) { $uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET f2a210h='$hod', f2a211h='$pri', f2a212h='$uby'  WHERE psys >= 0 "; }
  }

$upravene = mysql_query("$uprtxt");  

$nacitaj=$nacitaj+1;
  }

if( $pocet == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f2a110j=f2a110b+f2a110c+f2a110d+f2a110e+f2a110f+f2a110g+f2a110h+f2a110i, ".
" f2a111j=f2a111b+f2a111c+f2a111d+f2a111e+f2a111f+f2a111g+f2a111h+f2a111i, ".
" f2a112j=f2a112b+f2a112c+f2a112d+f2a112e+f2a112f+f2a112g+f2a112h+f2a112i, ".

" f2a16j=f2a16b+f2a16c+f2a16d+f2a16e+f2a16f+f2a16g+f2a16h+f2a16i, ".
" f2a17j=f2a17b+f2a17c+f2a17d+f2a17e+f2a17f+f2a17g+f2a17h+f2a17i, ".
" f2a18j=f2a18b+f2a18c+f2a18d+f2a18e+f2a18f+f2a18g+f2a18h+f2a18i, ".

" f2a11j=f2a11b+f2a11c+f2a11d+f2a11e+f2a11f+f2a11g+f2a11h+f2a11i, ".
" f2a12j=f2a12b+f2a12c+f2a12d+f2a12e+f2a12f+f2a12g+f2a12h+f2a12i, ".
" f2a13j=f2a13b+f2a13c+f2a13d+f2a13e+f2a13f+f2a13g+f2a13h+f2a13i  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f2a113j=f2a110j+f2a111j-f2a112j, ".
" f2a113i=f2a110i+f2a111i-f2a112i, ".
" f2a113h=f2a110h+f2a111h-f2a112h, ".
" f2a113g=f2a110g+f2a111g-f2a112g, ".
" f2a113f=f2a110f+f2a111f-f2a112f, ".
" f2a113e=f2a110e+f2a111e-f2a112e, ".
" f2a113d=f2a110d+f2a111d-f2a112d, ".
" f2a113c=f2a110c+f2a111c-f2a112c, ".
" f2a113b=f2a110b+f2a111b-f2a112b, ".

" f2a19j=f2a16j+f2a17j-f2a18j, ".
" f2a19i=f2a16i+f2a17i-f2a18i, ".
" f2a19h=f2a16h+f2a17h-f2a18h, ".
" f2a19g=f2a16g+f2a17g-f2a18g, ".
" f2a19f=f2a16f+f2a17f-f2a18f, ".
" f2a19e=f2a16e+f2a17e-f2a18e, ".
" f2a19d=f2a16d+f2a17d-f2a18d, ".
" f2a19c=f2a16c+f2a17c-f2a18c, ".
" f2a19b=f2a16b+f2a17b-f2a18b, ".

" f2a15j=f2a11j+f2a12j-f2a13j+f2a14j, ".
" f2a15i=f2a11i+f2a12i-f2a13i+f2a14i, ".
" f2a15h=f2a11h+f2a12h-f2a13h+f2a14h, ".
" f2a15g=f2a11g+f2a12g-f2a13g+f2a14g, ".
" f2a15f=f2a11f+f2a12f-f2a13f+f2a14f, ".
" f2a15e=f2a11e+f2a12e-f2a13e+f2a14e, ".
" f2a15d=f2a11d+f2a12d-f2a13d+f2a14d, ".
" f2a15c=f2a11c+f2a12c-f2a13c+f2a14c, ".
" f2a15b=f2a11b+f2a12b-f2a13b+f2a14b ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f2a115j=f2a15j-f2a19j+f2a113j, ".
" f2a115i=f2a15i-f2a19i+f2a113i, ".
" f2a115h=f2a15h-f2a19h+f2a113h, ".
" f2a115g=f2a15g-f2a19g+f2a113g, ".
" f2a115f=f2a15f-f2a19f+f2a113f, ".
" f2a115e=f2a15e-f2a19e+f2a113e, ".
" f2a115d=f2a15d-f2a19d+f2a113d, ".
" f2a115c=f2a15c-f2a19c+f2a113c, ".
" f2a115b=f2a15b-f2a19b+f2a113b, ".

" f2a114j=f2a11j-f2a16j+f2a110j, ".
" f2a114i=f2a11i-f2a16i+f2a110i, ".
" f2a114h=f2a11h-f2a16h+f2a110h, ".
" f2a114g=f2a11g-f2a16g+f2a110g, ".
" f2a114f=f2a11f-f2a16f+f2a110f, ".
" f2a114e=f2a11e-f2a16e+f2a110e, ".
" f2a114d=f2a11d-f2a16d+f2a110d, ".
" f2a114c=f2a11c-f2a16c+f2a110c, ".
" f2a114b=f2a11b-f2a16b+f2a110b  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

if( $pocet == 2 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f2a210j=f2a210b+f2a210c+f2a210d+f2a210e+f2a210f+f2a210g+f2a210h+f2a210i, ".
" f2a211j=f2a211b+f2a211c+f2a211d+f2a211e+f2a211f+f2a211g+f2a211h+f2a211i, ".
" f2a212j=f2a212b+f2a212c+f2a212d+f2a212e+f2a212f+f2a212g+f2a212h+f2a212i, ".

" f2a26j=f2a26b+f2a26c+f2a26d+f2a26e+f2a26f+f2a26g+f2a26h+f2a26i, ".
" f2a27j=f2a27b+f2a27c+f2a27d+f2a27e+f2a27f+f2a27g+f2a27h+f2a27i, ".
" f2a28j=f2a28b+f2a28c+f2a28d+f2a28e+f2a28f+f2a28g+f2a28h+f2a28i, ".

" f2a21j=f2a21b+f2a21c+f2a21d+f2a21e+f2a21f+f2a21g+f2a21h+f2a21i, ".
" f2a22j=f2a22b+f2a22c+f2a22d+f2a22e+f2a22f+f2a22g+f2a22h+f2a22i, ".
" f2a23j=f2a23b+f2a23c+f2a23d+f2a23e+f2a23f+f2a23g+f2a23h+f2a23i  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f2a213j=f2a210j+f2a211j-f2a212j, ".
" f2a213i=f2a210i+f2a211i-f2a212i, ".
" f2a213h=f2a210h+f2a211h-f2a212h, ".
" f2a213g=f2a210g+f2a211g-f2a212g, ".
" f2a213f=f2a210f+f2a211f-f2a212f, ".
" f2a213e=f2a210e+f2a211e-f2a212e, ".
" f2a213d=f2a210d+f2a211d-f2a212d, ".
" f2a213c=f2a210c+f2a211c-f2a212c, ".
" f2a213b=f2a210b+f2a211b-f2a212b, ".

" f2a29j=f2a26j+f2a27j-f2a28j, ".
" f2a29i=f2a26i+f2a27i-f2a28i, ".
" f2a29h=f2a26h+f2a27h-f2a28h, ".
" f2a29g=f2a26g+f2a27g-f2a28g, ".
" f2a29f=f2a26f+f2a27f-f2a28f, ".
" f2a29e=f2a26e+f2a27e-f2a28e, ".
" f2a29d=f2a26d+f2a27d-f2a28d, ".
" f2a29c=f2a26c+f2a27c-f2a28c, ".
" f2a29b=f2a26b+f2a27b-f2a28b, ".

" f2a25j=f2a21j+f2a22j-f2a23j+f2a24j, ".
" f2a25i=f2a21i+f2a22i-f2a23i+f2a24i, ".
" f2a25h=f2a21h+f2a22h-f2a23h+f2a24h, ".
" f2a25g=f2a21g+f2a22g-f2a23g+f2a24g, ".
" f2a25f=f2a21f+f2a22f-f2a23f+f2a24f, ".
" f2a25e=f2a21e+f2a22e-f2a23e+f2a24e, ".
" f2a25d=f2a21d+f2a22d-f2a23d+f2a24d, ".
" f2a25c=f2a21c+f2a22c-f2a23c+f2a24c, ".
" f2a25b=f2a21b+f2a22b-f2a23b+f2a24b ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
//exit;

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_po2011 SET ".
" f2a215j=f2a25j-f2a29j+f2a213j, ".
" f2a215i=f2a25i-f2a29i+f2a213i, ".
" f2a215h=f2a25h-f2a29h+f2a213h, ".
" f2a215g=f2a25g-f2a29g+f2a213g, ".
" f2a215f=f2a25f-f2a29f+f2a213f, ".
" f2a215e=f2a25e-f2a29e+f2a213e, ".
" f2a215d=f2a25d-f2a29d+f2a213d, ".
" f2a215c=f2a25c-f2a29c+f2a213c, ".
" f2a215b=f2a25b-f2a29b+f2a213b, ".

" f2a214j=f2a21j-f2a26j+f2a210j, ".
" f2a214i=f2a21i-f2a26i+f2a210i, ".
" f2a214h=f2a21h-f2a26h+f2a210h, ".
" f2a214g=f2a21g-f2a26g+f2a210g, ".
" f2a214f=f2a21f-f2a26f+f2a210f, ".
" f2a214e=f2a21e-f2a26e+f2a210e, ".
" f2a214d=f2a21d-f2a26d+f2a210d, ".
" f2a214c=f2a21c-f2a26c+f2a210c, ".
" f2a214b=f2a21b-f2a26b+f2a210b  ".
" WHERE psys >= 0 "; 
$upravene = mysql_query("$uprtxt"); 
  }

$pocet=$pocet+1;
    }

}
//koniec copern=300 zapis do poznamky_po2011 z obratovky udaje o hm.majetku

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

//copern=900 nacitaj premennu
if( $copern == 900 )
{
$ucm1 = $_REQUEST['h_ucm1'];
$ucm2 = $_REQUEST['h_ucm2'];
$ucm3 = $_REQUEST['h_ucm3'];
$ucm4 = $_REQUEST['h_ucm4'];
$ucm5 = $_REQUEST['h_ucm5'];
$ico1 = 1*$_REQUEST['h_ico1'];
$ico2 = 1*$_REQUEST['h_ico2'];
$ico3 = 1*$_REQUEST['h_ico3'];
$ico4 = 1*$_REQUEST['h_ico4'];
$ico5 = 1*$_REQUEST['h_ico5'];
$premenna = $_REQUEST['premenna'];
$zmd = 1*$_REQUEST['zmd'];
$zdl = 1*$_REQUEST['zdl'];
$omd = 1*$_REQUEST['omd'];
$odl = 1*$_REQUEST['odl'];
$pmd = 1*$_REQUEST['pmd'];
$pdl = 1*$_REQUEST['pdl'];
$mnl = 1*$_REQUEST['mnl'];

if( $zdl == 0 AND $omd == 0 AND $odl == 0 AND $pmd == 0 AND $pdl == 0 ) { $zmd=1; }

$ttvv = "DELETE FROM F$kli_vxcf"."_poznamky_muj2014set WHERE polozka ='$premenna' ";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014set ( polozka,ucm1,ucm2,ucm3,ucm4,ucm5,ico1,ico2,ico3,ico4,ico5,zmd,zdl,omd,odl,pmd,pdl,mnl ) ".
" VALUES ( '$premenna', '$ucm1', '$ucm2', '$ucm3', '$ucm4', '$ucm5', '$ico1', '$ico2', '$ico3', '$ico4', '$ico5', ".
" '$zmd', '$zdl', '$omd', '$odl', '$pmd', '$pdl', '$mnl' )";
$ttqq = mysql_query("$ttvv");

//podmienka ucet
$hodnota="0";
$ajucm=0;
$ajucd=0;
$podmucetm="";
$podmucetd="";

$cucm1=1*$ucm1;
$cucm2=1*$ucm2;
$cucm3=1*$ucm3;
$cucm4=1*$ucm4;
$cucm5=1*$ucm5;
if( $cucm1 > 0 AND $cucm1 > 999 )
{
$podmucetm=" ucm = $ucm1 ";
$podmucetd=" ucd = $ucm1 ";
}
if( $cucm1 > 0 AND $cucm1 <= 999 )
{
$podmucetm=" LEFT(ucm,3) = $ucm1 ";
$podmucetd=" LEFT(ucd,3) = $ucm1 ";
}
if( $cucm1 > 0 AND $cucm2 > 0 )
{
$podmucetm=$podmucetm." OR ";
$podmucetd=$podmucetd." OR ";
}
if( $cucm2 > 0 AND $cucm2 > 999 )
{
$podmucetm=$podmucetm." ucm = $ucm2";
$podmucetd=$podmucetd." ucd = $ucm2";
}
if( $cucm2 > 0 AND $cucm2 <= 999 )
{
$podmucetm=" LEFT(ucm,3) = $ucm2 ";
$podmucetd=" LEFT(ucd,3) = $ucm2 ";
}
if( $cucm2 > 0 AND $cucm3 > 0 )
{
$podmucetm=$podmucetm." OR ";
$podmucetd=$podmucetd." OR ";
}
if( $cucm3 > 0 AND $cucm3 > 999 )
{
$podmucetm=$podmucetm." ucm = $ucm3";
$podmucetd=$podmucetd." ucd = $ucm3";
}
if( $cucm3 > 0 AND $cucm3 <= 999 )
{
$podmucetm=" LEFT(ucm,3) = $ucm3 ";
$podmucetd=" LEFT(ucd,3) = $ucm3 ";
}
if( $cucm3 > 0 AND $cucm4 > 0 )
{
$podmucetm=$podmucetm." OR ";
$podmucetd=$podmucetd." OR ";
}
if( $cucm4 > 0 AND $cucm4 > 999 )
{
$podmucetm=$podmucetm." ucm = $ucm4";
$podmucetd=$podmucetd." ucd = $ucm4";
}
if( $cucm4 > 0 AND $cucm4 <= 999 )
{
$podmucetm=" LEFT(ucm,3) = $ucm4 ";
$podmucetd=" LEFT(ucd,3) = $ucm4 ";
}
if( $cucm4 > 0 AND $cucm5 > 0 )
{
$podmucetm=$podmucetm." OR ";
$podmucetd=$podmucetd." OR ";
}
if( $cucm5 > 0 AND $cucm5 > 999 )
{
$podmucetm=$podmucetm." ucm = $ucm5";
$podmucetd=$podmucetd." ucd = $ucm5";
}
if( $cucm5 > 0 AND $cucm5 <= 999 )
{
$podmucetm=" LEFT(ucm,3) = $ucm5 ";
$podmucetd=" LEFT(ucd,3) = $ucm5 ";
}

$podmucetm="( ".$podmucetm." )";
$podmucetd="( ".$podmucetd." )";

//podmienka ico
$podmico=" ico >= 0 ";
$cico1=1*$ico1;
$cico2=1*$ico2;
$cico3=1*$ico3;
$cico4=1*$ico4;
$cico5=1*$ico5;
if( $cico1 > 0 )
{
$podmico=" ico = $ico1 ";
}
if( $cico1 > 0 AND $cico2 > 0 )
{
$podmico=$podmico." OR ";
}
if( $cico2 > 0 )
{
$podmico=$podmico." ico = $ico2";
}
if( $cico2 > 0 AND $cico3 > 0 )
{
$podmico=$podmico." OR ";
}
if( $cico3 > 0 )
{
$podmico=$podmico." ico = $ico3";
}
if( $cico3 > 0 AND $cico4 > 0 )
{
$podmico=$podmico." OR ";
}
if( $cico4 > 0 )
{
$podmico=$podmico." ico = $ico4";
}
if( $cico4 > 0 AND $cico5 > 0 )
{
$podmico=$podmico." OR ";
}
if( $cico5 > 0 )
{
$podmico=$podmico." ico = $ico5";
}


$podmico="( ".$podmico." )";


//celk podmienka
$podmienkaucm="uro = 99";
$podmienkaucd="uro = 99";
if( $zmd == 1 ) { $podmienkaucm="uro = 1 AND ( psys = 1 OR psys = 2 ) AND $podmucetm AND $podmico "; $ajucm=1; }
if( $zmd == 1 ) { $podmienkaucd="uro = 1 AND ( psys = 1 OR psys = 2 ) AND $podmucetd AND $podmico "; $ajucd=1; }
if( $zdl == 1 ) { $podmienkaucm="uro = 1 AND ( psys = 1 OR psys = 2 ) AND $podmucetm AND $podmico "; $ajucm=1; }
if( $zdl == 1 ) { $podmienkaucd="uro = 1 AND ( psys = 1 OR psys = 2 ) AND $podmucetd AND $podmico "; $ajucd=1; }
if( $pmd == 1 ) { $podmienkaucm="uro = 1 AND ( psys = 1 ) AND $podmucetm AND $podmico "; $ajucm=1; }
if( $pmd == 1 ) { $podmienkaucd="uro = 1 AND ( psys = 1 ) AND $podmucetd AND $podmico "; $ajucd=1; }
if( $pdl == 1 ) { $podmienkaucm="uro = 1 AND ( psys = 1 ) AND $podmucetm AND $podmico "; $ajucm=1; }
if( $pdl == 1 ) { $podmienkaucd="uro = 1 AND ( psys = 1 ) AND $podmucetd AND $podmico "; $ajucd=1; }
if( $omd == 1 ) { $podmienkaucm="uro = 1 AND ( psys = 2 ) AND $podmucetm AND $podmico "; $ajucm=1; }
if( $omd == 1 ) { $podmienkaucd="uro = 1 AND ( psys = 2 ) AND $podmucetd AND $podmico "; $ajucd=0; }
if( $odl == 1 ) { $podmienkaucm="uro = 1 AND ( psys = 2 ) AND $podmucetm AND $podmico "; $ajucm=0; }
if( $odl == 1 ) { $podmienkaucd="uro = 1 AND ( psys = 2 ) AND $podmucetd AND $podmico "; $ajucd=1; }

$minul="";
if( $mnl == 1 ) { $minul="min"; }

if( $ajucm == 1 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minul$kli_uzid WHERE $podmienkaucm ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $hodnota=$hodnota+$polozka->hod; }
$i=$i+1;                   }
  }

//echo $sqltt;

if( $ajucd == 1 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcstatr101$minul$kli_uzid WHERE $podmienkaucd ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $hodnota=$hodnota-$polozka->hod; }
$i=$i+1;                   }
  }

if( $zdl == 1 ) { $hodnota=-1*$hodnota; }
if( $pdl == 1 ) { $hodnota=-1*$hodnota; }
if( $odl == 1 ) { $hodnota=-1*$hodnota; }

$tabulka="poznamky_muj2014";

$ttvv = "UPDATE F$kli_vxcf"."_".$tabulka." SET ".$premenna."=".$hodnota." ";
$ttqq = mysql_query("$ttvv");

}
//koniec copern=900 nacitaj premennu

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
<title>Poznámky PO 2013 nacitaj</title>
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
<td>EuroSecom Poznámky PO v.2013 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />





<?php

//prepni do poznamok
$cstat=10101;
$strana=1;
if( $copern == 300 ) { $strana=4; $cstat=20101; }
if( $copern == 301 ) { $strana=4; $cstat=20101; }
if( $copern == 200 ) { $strana=2; $cstat=20101; }
if( $copern == 302 ) { $strana=6; $cstat=20101; }
if( $copern == 401 ) { $strana=7; $cstat=20101; }
if( $copern == 501 ) { $strana=8; $cstat=20101; }
if( $copern == 502 ) { $strana=8; $cstat=20101; }
if( $copern == 503 ) { $strana=9; $cstat=20101; }
if( $copern == 504 ) { $strana=9; $cstat=20101; }
if( $copern == 505 ) { $strana=10; $cstat=20101; }
if( $copern == 402 ) { $strana=10; $cstat=20101; }
if( $copern == 506 ) { $strana=11; $cstat=20101; }
if( $copern == 507 ) { $strana=12; $cstat=20101; }
if( $copern == 508 ) { $strana=12; $cstat=20101; }
if( $copern == 509 ) { $strana=12; $cstat=20101; }
if( $copern == 510 ) { $strana=14; $cstat=20101; }
if( $copern == 511 ) { $strana=12; $cstat=20101; }
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
