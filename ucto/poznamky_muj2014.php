<HTML>
<?php
//celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_minrok=$kli_vrok-1;
$stvrtrok=1;
$vyb_ump="1.".$kli_vrok;
$vyb_ums="2.".$kli_vrok;
$vyb_umk="3.".$kli_vrok;
$mesiac="03";
if( $kli_vmes > 3 ) { $stvrtrok=2; $vyb_ump="4.".$kli_vrok; $vyb_ums="5.".$kli_vrok; $vyb_umk="6.".$kli_vrok; $mesiac="06"; }
if( $kli_vmes > 6 ) { $stvrtrok=3; $vyb_ump="7.".$kli_vrok; $vyb_ums="8.".$kli_vrok; $vyb_umk="9.".$kli_vrok; $mesiac="09"; }
if( $kli_vmes > 9 ) { $stvrtrok=4; $vyb_ump="10.".$kli_vrok; $vyb_ums="11.".$kli_vrok; $vyb_umk="12.".$kli_vrok; $mesiac="12"; }

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) $strana=1;

$dopoz = 1*$_REQUEST['dopoz'];
if( $copern == 1 ) $dopoz=1;
//echo $copern;

//vytvor tabulku textov v databaze

$sql = "SELECT ico FROM F$kli_vxcf"."_poznamky_muj2014texty ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {
$vsql = 'DROP TABLE F'.$kli_vxcf.'_poznamky_muj2014texty';
$vytvor = mysql_query("$vsql");
     
$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   ozntxt       VARCHAR(10) not null,
   hdntxt       TEXT not null,
   prmx1        DECIMAL(10,0) DEFAULT 0,
   prmx2        DECIMAL(10,0) DEFAULT 0,
   prmx3        DECIMAL(10,0) DEFAULT 0,
   prmx4        DECIMAL(10,0) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx8        DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_poznamky_muj2014texty'.$sqlt;
$vytvor = mysql_query("$vsql");

   }
$sql = "SELECT oldp FROM F$kli_vxcf"."_poznamky_muj2014texty ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014texty ADD oldc2 VARCHAR(10) NOT NULL AFTER prmx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014texty ADD oldc1 VARCHAR(10) NOT NULL AFTER prmx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014texty ADD oldp VARCHAR(10) NOT NULL AFTER prmx4";
$vysledek = mysql_query("$sql");

   }
//koniec vytvor tabulku textov v databaze

//vytvor tabulku v databaze
$sql = "SELECT ico FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{   
   
$vsql = 'DROP TABLE F'.$kli_vxcf.'_poznamky_muj2014';
$vytvor = mysql_query("$vsql");
     
$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_poznamky_muj2014'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}

$sql = "SELECT gh46 FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def1<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD ac32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd21 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd31 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd41 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd51 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd52 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd61 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gcd62 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh11 VARCHAR(40) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh13 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh14 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh15 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh16 VARCHAR(30) NOT NULL"; 
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh21 VARCHAR(40) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh22 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh23 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh24 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh25 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh26 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh31 VARCHAR(40) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh32 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh33 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh34 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh35 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh36 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh41 VARCHAR(40) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh42 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh43 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh44 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh45 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_po2011s3 ADD gh46 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");

}

//koniec upravy 2014

//koniec vytvor tabulku v databaze


// zapis upravene udaje strana 1
if ( $copern == 3 AND $strana == 1 )
    {
$ac11 = strip_tags($_REQUEST['ac11']);       
$ac12 = strip_tags($_REQUEST['ac12']);       
$ac21 = strip_tags($_REQUEST['ac21']);       
$ac22 = strip_tags($_REQUEST['ac22']);       
$ac31 = strip_tags($_REQUEST['ac31']);       
$ac32 = strip_tags($_REQUEST['ac32']); 


$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" ac11='$ac11', ac12='$ac12', ac21='$ac21', ac22='$ac22', ac31='$ac31', ac32='$ac32', ".
" konx8=0 ".
" WHERE ico >= 0"; 

//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 1


// zapis upravene udaje strana 2
if ( $copern == 3 AND $strana == 2 )
    {
    

$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".

" konx8=0 ".        
" WHERE ico >= 0";  
  
//echo $uprtxt;
  
$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 2

// zapis upravene udaje strana 3
if ( $copern == 3 AND $strana == 3 )
    {

$gcd11 = strip_tags($_REQUEST['gcd11']);
$gcd12 = strip_tags($_REQUEST['gcd12']);
$gcd21 = strip_tags($_REQUEST['gcd21']);
$gcd22 = strip_tags($_REQUEST['gcd22']);
$gcd31 = strip_tags($_REQUEST['gcd31']);
$gcd32 = strip_tags($_REQUEST['gcd32']);
$gcd41 = strip_tags($_REQUEST['gcd41']);
$gcd42 = strip_tags($_REQUEST['gcd42']);
$gcd51 = strip_tags($_REQUEST['gcd51']);
$gcd52 = strip_tags($_REQUEST['gcd52']);
$gcd61 = strip_tags($_REQUEST['gcd61']);
$gcd62 = strip_tags($_REQUEST['gcd62']);

$gh11 = strip_tags($_REQUEST['gh11']);
$gh12 = strip_tags($_REQUEST['gh12']);
$gh13 = strip_tags($_REQUEST['gh13']);
$gh14 = strip_tags($_REQUEST['gh14']);
$gh15 = strip_tags($_REQUEST['gh15']);
$gh16 = strip_tags($_REQUEST['gh16']);
$gh21 = strip_tags($_REQUEST['gh21']);
$gh22 = strip_tags($_REQUEST['gh22']);
$gh23 = strip_tags($_REQUEST['gh23']);
$gh24 = strip_tags($_REQUEST['gh24']);
$gh25 = strip_tags($_REQUEST['gh25']);
$gh26 = strip_tags($_REQUEST['gh26']);
$gh31 = strip_tags($_REQUEST['gh31']);
$gh32 = strip_tags($_REQUEST['gh32']);
$gh33 = strip_tags($_REQUEST['gh33']);
$gh34 = strip_tags($_REQUEST['gh34']);
$gh35 = strip_tags($_REQUEST['gh35']);
$gh36 = strip_tags($_REQUEST['gh36']);
$gh41 = strip_tags($_REQUEST['gh41']);
$gh42 = strip_tags($_REQUEST['gh42']);
$gh43 = strip_tags($_REQUEST['gh43']);
$gh44 = strip_tags($_REQUEST['gh44']);
$gh45 = strip_tags($_REQUEST['gh45']);
$gh46 = strip_tags($_REQUEST['gh46']);    

$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" gcd11='$gcd11', gcd12='$gcd12', gcd21='$gcd21', gcd22='$gcd22', ".
" gcd31='$gcd31', gcd32='$gcd32', gcd41='$gcd41', gcd42='$gcd42', ".
" gcd51='$gcd51', gcd52='$gcd52', gcd61='$gcd61', gcd62='$gcd62', ".
" gh11='$gh11', gh12='$gh12', gh13='$gh13', gh14='$gh14', gh15='$gh15', gh16='$gh16', ". 
" gh21='$gh21', gh22='$gh22', gh23='$gh23', gh24='$gh24', gh25='$gh25', gh26='$gh26', ". 
" gh31='$gh31', gh32='$gh32', gh33='$gh33', gh34='$gh34', gh35='$gh35', gh36='$gh36', ".
" gh41='$gh41', gh42='$gh42', gh43='$gh43', gh44='$gh44', gh45='$gh45', gh46='$gh46', ".
" konx8=0 ".        
" WHERE ico >= 0";  
  
//echo $uprtxt;
  
$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov strana 2

//prepocet kontrolnych cisiel
if( $copern == 1 )
  {
$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" gcd31=gcd11+gcd21,".
" gcd32=gcd12+gcd22,".
" gcd61=gcd41+gcd51,".
" gcd62=gcd42+gcd52 ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");



   }
//koniec prepocet kontrolnych cisiel


//nacitaj udaje
if ( $copern >= 1 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$ac11 = $fir_riadok->ac11;
$ac12 = $fir_riadok->ac12;
$ac21 = $fir_riadok->ac21;
$ac22 = $fir_riadok->ac22;
$ac31 = $fir_riadok->ac31;
$ac32 = $fir_riadok->ac32;

$gcd11 = $fir_riadok->gcd11;
$gcd12 = $fir_riadok->gcd12;
$gcd21 = $fir_riadok->gcd21;
$gcd22 = $fir_riadok->gcd22;
$gcd31 = $fir_riadok->gcd31;
$gcd32 = $fir_riadok->gcd32;
$gcd41 = $fir_riadok->gcd41;
$gcd42 = $fir_riadok->gcd42;
$gcd51 = $fir_riadok->gcd51;
$gcd52 = $fir_riadok->gcd52;
$gcd61 = $fir_riadok->gcd61;
$gcd62 = $fir_riadok->gcd62;

$gh11 = $fir_riadok->gh11;
$gh12 = $fir_riadok->gh12;
$gh13 = $fir_riadok->gh13;
$gh14 = $fir_riadok->gh14;
$gh15 = $fir_riadok->gh15;
$gh16 = $fir_riadok->gh16;
$gh21 = $fir_riadok->gh21;
$gh22 = $fir_riadok->gh22;
$gh23 = $fir_riadok->gh23;
$gh24 = $fir_riadok->gh24;
$gh25 = $fir_riadok->gh25;
$gh26 = $fir_riadok->gh26;
$gh31 = $fir_riadok->gh31;
$gh32 = $fir_riadok->gh32;
$gh33 = $fir_riadok->gh33;
$gh34 = $fir_riadok->gh34;
$gh35 = $fir_riadok->gh35;
$gh36 = $fir_riadok->gh36;
$gh41 = $fir_riadok->gh41;
$gh42 = $fir_riadok->gh42;
$gh43 = $fir_riadok->gh43;
$gh44 = $fir_riadok->gh44;
$gh45 = $fir_riadok->gh45;
$gh46 = $fir_riadok->gh46;

mysql_free_result($fir_vysledok);
    }
//koniec nacitania

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl_poznamky_po2011.css">
<title>Poznámky k úèt. závierke MUJ 2014</title>
<style>



</style>


<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana 1
  if ( $copern == 1 AND $strana == 1 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.ac11.value = '<?php echo "$ac11";?>';
    document.formv1.ac12.value = '<?php echo "$ac12";?>';
    document.formv1.ac21.value = '<?php echo "$ac21";?>';
    document.formv1.ac22.value = '<?php echo "$ac22";?>';
    document.formv1.ac31.value = '<?php echo "$ac31";?>';
    document.formv1.ac32.value = '<?php echo "$ac32";?>';

    }
<?php
//koniec uprava
  }
?>

<?php
//uprava sadzby strana 2
  if ( $copern == 1 AND $strana == 2 )
  { 
?>
    function ObnovUI()
    {


    }
<?php
//koniec uprava
  }
?>

<?php
//uprava sadzby strana 3
  if ( $copern == 1 AND $strana == 3 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.gcd11.value = '<?php echo "$gcd11";?>';
    document.formv1.gcd12.value = '<?php echo "$gcd12";?>';
    document.formv1.gcd21.value = '<?php echo "$gcd21";?>';
    document.formv1.gcd22.value = '<?php echo "$gcd22";?>';
    document.formv1.gcd31.value = '<?php echo "$gcd31";?>';
    document.formv1.gcd32.value = '<?php echo "$gcd32";?>';
    document.formv1.gcd41.value = '<?php echo "$gcd41";?>';
    document.formv1.gcd42.value = '<?php echo "$gcd42";?>';
    document.formv1.gcd51.value = '<?php echo "$gcd51";?>';
    document.formv1.gcd52.value = '<?php echo "$gcd52";?>';
    document.formv1.gcd61.value = '<?php echo "$gcd61";?>';
    document.formv1.gcd62.value = '<?php echo "$gcd62";?>';

    document.formv1.gh11.value = '<?php echo "$gh11";?>';
    document.formv1.gh12.value = '<?php echo "$gh12";?>';
    document.formv1.gh13.value = '<?php echo "$gh13";?>';
    document.formv1.gh14.value = '<?php echo "$gh14";?>';
    document.formv1.gh15.value = '<?php echo "$gh15";?>';
    document.formv1.gh16.value = '<?php echo "$gh16";?>';
    document.formv1.gh21.value = '<?php echo "$gh21";?>';
    document.formv1.gh22.value = '<?php echo "$gh22";?>';
    document.formv1.gh23.value = '<?php echo "$gh23";?>';
    document.formv1.gh24.value = '<?php echo "$gh24";?>';
    document.formv1.gh25.value = '<?php echo "$gh25";?>';
    document.formv1.gh26.value = '<?php echo "$gh26";?>';
    document.formv1.gh31.value = '<?php echo "$gh31";?>';
    document.formv1.gh32.value = '<?php echo "$gh32";?>';
    document.formv1.gh33.value = '<?php echo "$gh33";?>';
    document.formv1.gh34.value = '<?php echo "$gh34";?>';
    document.formv1.gh35.value = '<?php echo "$gh35";?>';
    document.formv1.gh36.value = '<?php echo "$gh36";?>';
    document.formv1.gh41.value = '<?php echo "$gh41";?>';
    document.formv1.gh42.value = '<?php echo "$gh42";?>';
    document.formv1.gh43.value = '<?php echo "$gh43";?>';
    document.formv1.gh44.value = '<?php echo "$gh44";?>';
    document.formv1.gh45.value = '<?php echo "$gh45";?>';
    document.formv1.gh46.value = '<?php echo "$gh46";?>';

    }
<?php
//koniec uprava
  }
?>                                   
                                           
</script>           
                    
<script type='text/javascript'>
                    
                
                    

    function upravtext( oscx )
    {

var h_osc = oscx;

window.open('poznamky_muj2014texty.php?h_ozntxt=' + h_osc + '&copern=1&drupoh=1&page=1', '_blank',  'width=900, height=900, top=0, left=40, status=yes, resizable=yes, scrollbars=yes' );

    }

function minulyrok( strana )
                {

window.open('../ucto/poznamky_muj2014nacitaj.php?copern=1999&stranax=' + strana + '&drupoh=1&page=1&dopoz=0&xxc=1', '_self' ); 
                }

</script>

</HEAD>
<BODY class="white" onload="ObnovUI();"  >

<table class="nadpis" width="100%" >
<tr>
<td class="h2">EuroSecom  -  Poznámky k úètovnej závierke MUJ 2014</td><td align="center" class="vyplnam" ><span style="display:none;">vypåòate stranu è. <?php echo "$strana";?></span></td>
<td class="login" align="right"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></td>
</tr>
</table>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobrı deò , ja som Váš EkoRobot , ak máte otázku alebo nejaké elanie kliknite na mòa prosím 1x myšou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<!--
 <tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musí by celé kladné èíslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Dátum musí by v tvare DD.MM.RRRR,DD.MM alebo DD napríklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 2 desatinné miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 4 desatinné miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 1 desatinné miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OSÈ musí by celé kladné èíslo v rozsahu 1 a 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Musíte vyplni všetky poloky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloka OSÈ=<?php echo $h_oc;?> správne uloená</span>
</tr>
-->

<?php
//zobraz a uprav nastavene udaje 
if ( $copern == 1  )
        {
?>

<?php

    function vypistextx($ktorytext, $mysqlhostx, $mysqluserx, $mysqlpasswdx, $mysqldbx, $kli_vxcf)
    {

  @$spojeni = mysql_connect($mysqlhostx, $mysqluserx, $mysqlpasswdx);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldbx);

$ozntext=$ktorytext;
$textvypis="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014texty WHERE ozntxt = '$ozntext' ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $textvypis=$riaddok->hdntxt;
 }
$dlzkatxt=strlen($textvypis);
$textvypis=substr($textvypis,0,60);
if( $dlzkatxt > 60 ) { $textvypis=$textvypis."..."; }

    return $textvypis;
    }

?>


<!-- hlavièka tabu¾ky so stranami a tlaèou -->
<?php
$clas1="noselect"; $clas2="noselect"; $clas2="noselect";$clas3="noselect"; $clas4="noselect"; $clas5="noselect"; $clas6="noselect"; $clas7="noselect";
$clas8="noselect"; $clas9="noselect"; $clas10="noselect"; $clas11="noselect"; $clas12="noselect"; $clas13="noselect"; $clas14="noselect";
if( $strana == 1 ) $clas1="selected";
if( $strana == 2 ) $clas2="selected";
if( $strana == 3 ) $clas3="selected";
if( $strana == 4 ) $clas4="selected";
if( $strana == 5 ) $clas5="selected";
if( $strana == 6 ) $clas6="selected";
if( $strana == 7 ) $clas7="selected";
if( $strana == 8 ) $clas8="selected";
if( $strana == 9 ) $clas9="selected";
if( $strana == 10 ) $clas10="selected";
if( $strana == 11 ) $clas11="selected";
if( $strana == 12 ) $clas12="selected";
if( $strana == 13 ) $clas13="selected";
if( $strana == 14 ) $clas14="selected";
?>

<table class="tbhead" width="100%">
<FORM name="formv1" class="obyc" method="post" action="poznamky_muj2014.php?copern=3&strana=<?php echo "$strana";?>" >
<tr>
<td class="pages" width="90%">

<span class="maleinfo">Strana:</span>
&nbsp;&nbsp;
 <a class="<?php echo $clas1; ?>" href="#" onClick="window.open('poznamky_muj2014.php?copern=1&strana=1', '_self');">1</a>

 <a class="<?php echo $clas2; ?>" href="#" onClick="window.open('poznamky_muj2014.php?copern=1&strana=2', '_self');">2</a>

 <a class="<?php echo $clas3; ?>" href="#" onClick="window.open('poznamky_muj2014.php?copern=1&strana=3', '_self');">3</a>

 <a class="<?php echo $clas4; ?>" href="#" onClick="window.open('poznamky_muj2014.php?copern=1&strana=4', '_self');">4</a>

</td>
<td width="10%" align="center"><INPUT type="submit" id="uloz" name="uloz" value="Uloi zmeny"></td>
</tr>
</table>

<table class="tbbody" width="100%"> <!-- telo stránky -->
<?php
//zobraz a uprav nastavene udaje strana 1
if ( $strana == 1 )
    {
?>
<tr>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="5%"></td>
<td class="rsmall" width="15%"></td><td class="rsmall" width="15%"></td><td class="rsmall" width="5%"></td><td class="rsmall" width="10%"></td>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td>
</tr>
<tr><td class="rmedium" colspan="10"></td></tr>
<tr><td class="castname" colspan="10">Èl. I Všeobecné údaje.</td></tr>
<tr><td class="medium" colspan="10">Èl. I.2 Údaje o konsolidovanom celku.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="A_text1"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. I.3 Priemernı prepoèítanı poèet zamestnancov.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="A_text2"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>
<tr>
<td colspan="5">
<div class="casti">
<table width="100%" >
<caption><span class="ctab"></span>Poèet zamestnancov</caption>
<thead>
<tr>
<th colspan="3">Názov poloky</th><th colspan="1"><?php echo $kli_vrok;?></th><th colspan="1"><?php echo $kli_minrok;?>
 <img src="../obr/vlozit.png" width="10" height="10" onclick="minulyrok(<?php echo $strana;?>)"
 title="Naèíta hodnoty predchádzajúceho obdobia pre stranu è.<?php echo $strana;?>" ></th>
</tr>
</thead>
<tbody>
<tr>
<td colspan="3">Priemernı prepoèítanı poèet zamestnancov</td>
<td colspan="1"><input type="text" name="ac11" id="ac11" size="10" /></td>
<td colspan="1"><input type="text" name="ac12" id="ac12" size="10" /></td>
</tr>
<tr>
<td colspan="3">Stav zamestnancov ku dòu zostavenia úètovnej závierky, z toho:</td>
<td colspan="1"><input type="text" name="ac21" id="ac21" size="10" /></td>
<td colspan="1"><input type="text" name="ac22" id="ac22" size="10" /></td>
</tr>
<tr>
<td colspan="3">&nbsp;- poèet vedúcich zamestnancov</td>
<td colspan="1"><input type="text" name="ac31" id="ac31" size="10" /></td>
<td colspan="1"><input type="text" name="ac32" id="ac32" size="10" /></td>
</tr>
</tbody>
</table>
</div>
</td>
<td colspan="5"></td>
</tr>
<tr>
<td colspan="10"></td>
</tr>

<?php
//koniec zobraz a uprav nastavene udaje strana 1
    }
?>


<?php if ( $strana == 2 ) { ?>
<tr>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="5%"></td>
<td class="rsmall" width="15%"></td><td class="rsmall" width="15%"></td><td class="rsmall" width="5%"></td><td class="rsmall" width="10%"></td>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td>
</tr>
<tr><td class="rmedium" colspan="10"></td></tr>
<tr><td class="castname" colspan="10">Èl. II Informácie o prijatıch postupoch.</td></tr>



<tr>
<td colspan="5">
<div class="casti">
<table width="100%" >
<caption ><span class="ctab">26</span> - Gcd) Záväzky</caption>
<tr>
<td class="rsmall" width="64%"></td><td class="rsmall" width="18%"></td><td class="rsmall" width="18%"></td>
</tr>
<thead>
<tr>
<th colspan="1">Názov poloky</th><th colspan="1"><?php echo $kli_vrok;?></th><th colspan="1"><?php echo $kli_minrok;?>
 <img src="../obr/vlozit.png" width="10" height="10" onclick="minulyrok(<?php echo $strana;?>)"
 title="Naèíta hodnoty predchádzajúceho obdobia pre stranu è.<?php echo $strana;?>" >
</th>
</tr>
</thead>
<tbody>
<tr>
<th colspan="1">Dlhodobé záväzky spolu</th>
<td colspan="1"><input type="text" name="gcd61" id="gcd61" size="12" /></td>
<td colspan="1"><input type="text" name="gcd62" id="gcd62" size="12" /></td>
</tr>
<tr>
<td colspan="1">Záväzky so zostatkovou dobou splatnosti nad 5 rokov</td>
<td colspan="1"><input type="text" name="gcd51" id="gcd51" size="12" /></td>
<td colspan="1"><input type="text" name="gcd52" id="gcd52" size="12" /></td>
</tr>
<tr>
<td colspan="1">Záväzky so zostatkovou dobou splatnosti 1 a 5 rokov</td>
<td colspan="1"><input type="text" name="gcd41" id="gcd41" size="12" /></td>
<td colspan="1"><input type="text" name="gcd42" id="gcd42" size="12" /></td>
</tr>
<tr>
<th colspan="1">Krátkodobé záväzky spolu</th>
<td colspan="1"><input type="text" name="gcd31" id="gcd31" size="12" /></td>
<td colspan="1"><input type="text" name="gcd32" id="gcd32" size="12" /></td>
</tr>
<tr>
<td colspan="1">Záväzky so zostatkovou dobou splatnosti do 1 roka vrátane</td>
<td colspan="1"><input type="text" name="gcd21" id="gcd21" size="12" /></td>
<td colspan="1"><input type="text" name="gcd22" id="gcd22" size="12" /></td>
</tr>
<tr>
<td colspan="1">Záväzky po lehote splatnosti</td>
<td colspan="1"><input type="text" name="gcd11" id="gcd11" size="12" /></td>
<td colspan="1"><input type="text" name="gcd12" id="gcd12" size="12" /></td>
</tr>
</tbody>
</table>
</div>
</td>
<td colspan="5"></td>
</tr>
<tr><td class="medium" colspan="10">Èl. II.1 Nepretrité pokraèovanie v èinnosti.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="B_text1"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. II.2 Spôsob oceòovania jednotlivıch poloiek majetku a záväzkov.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="B_text2"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. II.3 Spôsob zostavenia odpisového plánu majetku.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="B_text3"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. II.4 Zmeny úètovnıch zásad a zmeny úètovnıch metód.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="B_text4"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. II.5 Informácie o dotáciách a ich oceòovanie v úètovníctve.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="B_text5"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. II.6 Informácie o úètovaní vıznamnıch opráv chıb minulıch úètovnıch období v benom úètovnom období.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="B_text6"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<tr>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="5%"></td>
<td class="rsmall" width="15%"></td><td class="rsmall" width="15%"></td><td class="rsmall" width="5%"></td><td class="rsmall" width="10%"></td>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td>
</tr>
<tr><td class="rmedium" colspan="10"></td></tr>
<tr><td class="castname" colspan="10">Èl. III Informácie, ktoré vysvet¾ujú a dopåòajú súvahu a vıkaz ziskov a strát.</td></tr>
<tr>
<td colspan="5">
<div class="casti">
<table width="100%" >
<caption ><span class="ctab">29</span> - Gh) Vydané dlhopisy</caption>
<tr>
<td class="rsmall" width="38%"></td><td class="rsmall" width="20%"></td><td class="rsmall" width="6%"></td><td class="rsmall" width="15%"></td>
<td class="rsmall" width="6%"></td><td class="rsmall" width="15%"></td>
</tr>
<thead>
<tr>
<th colspan="1">Názov vydaného dlhopisu</th><th colspan="1">Menovitá hodn.</th><th colspan="1">Poèet</th><th colspan="1">Emis. kurz</th>
<th colspan="1">Úrok</th><th colspan="1">Splatnos</th>
</tr>
</thead>
<tbody>
<tr>
<td colspan="1"><input type="text" name="gh11" id="gh11" size="35" /></td><td colspan="1"><input type="text" name="gh12" id="gh12" size="10" /></td>
<td colspan="1"><input type="text" name="gh13" id="gh13" size="8" /></td><td colspan="1"><input type="text" name="gh14" id="gh14" size="10" /></td>
<td colspan="1"><input type="text" name="gh15" id="gh15" size="8" /></td><td colspan="1"><input type="text" name="gh16" id="gh16" size="10" /></td>
</tr>
<tr>
<td colspan="1"><input type="text" name="gh21" id="gh21" size="35" /></td><td colspan="1"><input type="text" name="gh22" id="gh22" size="10" /></td>
<td colspan="1"><input type="text" name="gh23" id="gh23" size="8" /></td><td colspan="1"><input type="text" name="gh24" id="gh24" size="10" /></td>
<td colspan="1"><input type="text" name="gh25" id="gh25" size="8" /></td><td colspan="1"><input type="text" name="gh26" id="gh26" size="10" /></td>
</tr>
<tr>
<td colspan="1"><input type="text" name="gh31" id="gh31" size="35" /></td><td colspan="1"><input type="text" name="gh32" id="gh32" size="10" /></td>
<td colspan="1"><input type="text" name="gh33" id="gh33" size="8" /></td><td colspan="1"><input type="text" name="gh34" id="gh34" size="10" /></td>
<td colspan="1"><input type="text" name="gh35" id="gh35" size="8" /></td><td colspan="1"><input type="text" name="gh36" id="gh36" size="10" /></td>
</tr>
<tr>
<td colspan="1"><input type="text" name="gh41" id="gh41" size="35" /></td><td colspan="1"><input type="text" name="gh42" id="gh42" size="10" /></td>
<td colspan="1"><input type="text" name="gh43" id="gh43" size="8" /></td><td colspan="1"><input type="text" name="gh44" id="gh44" size="10" /></td>
<td colspan="1"><input type="text" name="gh45" id="gh45" size="8" /></td><td colspan="1"><input type="text" name="gh46" id="gh46" size="10" /></td>
</tr>
</tbody>
</table>
</div>

</td>
<td colspan="5"></td>
</tr>
<tr><td class="medium" colspan="10">Èl. III.1 Informácia o sume a dôvodoch vzniku jednotlivıch poloiek nákladov alebo vınosov, ktoré majú vınimoènı rozsah.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="C_text1"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. III.2 Informácie o záväzkoch.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="C_text2"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. III.3 Informácie o vlastnıch akciách.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="C_text3"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>


<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
<tr>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="5%"></td>
<td class="rsmall" width="15%"></td><td class="rsmall" width="15%"></td><td class="rsmall" width="5%"></td><td class="rsmall" width="10%"></td>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td>
</tr>
<tr><td class="rmedium" colspan="10"></td></tr>
<tr><td class="castname" colspan="10">Èl. III Informácie, ktoré vysvet¾ujú a dopåòajú súvahu a vıkaz ziskov a strát.</td></tr>

<tr><td class="medium" colspan="10">Èl. III.4 Informácie o orgánoch úètovnej jednotky.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="C_text4"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<tr><td class="medium" colspan="10">Èl. III.5 Informácie o povinnostiach úètovnej jednotky.</td></tr>
<tr>
<td colspan="10" >
<div class="dtext" >
<?php $ozntext="C_text5"; $textvypis=vypistextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); ?>
<img src="../obr/eshop/note.png" width="25" height="20" onclick="upravtext('<?php echo $ozntext; ?>')" title="Upravi text" >
<span class="dtextbox">
<span>&bdquo;</span>&nbsp;<?php echo $textvypis; ?>&nbsp;<span>&rdquo;</span>
</span>
</div>
</td>
</tr>

<?php                     } ?>

</FORM>

</table>

<?php
//zobraz a uprav nastavene udaje
        }
?>




<?php
$robot=1;
$cislista = include("uct_lista.php");

//celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
