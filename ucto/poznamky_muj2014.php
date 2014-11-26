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
$sql = "SELECT w1 FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
   {

$sql = "SELECT r101x FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{   
   
$vsql = 'DROP TABLE F'.$kli_vxcf.'_poznamky_muj2014';
$vytvor = mysql_query("$vsql");
     
$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx8        DECIMAL(10,0) DEFAULT 0,
   r101x        DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_poznamky_muj2014'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");

}

$sql = "SELECT x2fzc FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def1<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014 ADD x2fzc DATE NOT NULL AFTER ico";
$vysledek = mysql_query("$sql");

}

//koniec upravy 2014

   }
//koniec vytvor tabulku v databaze


// zapis upravene udaje strana 1
if ( $copern == 3 AND $strana == 1 )
    {
$aa1 = strip_tags($_REQUEST['aa1']);


$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" aa1='$aa1sql', aa2='$aa2sql', ab1='$ab1',  
  a1e='$a1e', a2e='$a2e',
  x1ac='$x1ac', x2ac='$x2ac',
  x1ad='$x1ad', x2ad='$x2ad', x1ae='$x1ae', x2ae='$x2ae',
  x1af='$x1af', x2af='$x2af', x1b='$x1b', x2b='$x2b',
  x1ba='$x1ba', x2ba='$x2ba', x1bb='$x1bb', x2bb='$x2bb',
  x1c='$x1c', x2c='$x2c',
  x1e='$x1e', x2e='$x2e', x1ea='$x1ea',
  x2ea='$x2ea', x1eb='$x1eb', x2eb='$x2eb', x1ed='$x1ed', x2ed='$x2ed', x1ee='$x1ee', x2ee='$x2ee', 
  x1f='$x1f', x2f='$x2f', x1fa='$x1fa', x2fa='$x2fa',
  x1fb='$x1fb', x2fb='$x2fb', x1fc='$x1fc', x2fc='$x2fc', x1fd='$x1fd',
  x2fd='$x2fd', x1fe='$x1fe', x2fe='$x2fe', x1ff='$x1ff', x2ff='$x2ff',
  x1fg='$x1fg', x2fg='$x2fg', x1fh='$x1fh', x2fh='$x2fh', x1fi='$x1fi',
  x2fi='$x2fi', x1fjk='$x1fjk', 
  x2fjk='$x2fjk', x1fjl='$x1fjl', x2fjl='$x2fjl', x1fm='$x1fm',
  x2fm='$x2fm', x1fn='$x1fn', x2fn='$x2fn', x1fo='$x1fo', x2fo='$x2fo',
  x1fp='$x1fp', x2fp='$x2fp', x1fq='$x1fq', x2fq='$x2fq', x1fr='$x1fr',
  x2fr='$x2fr', x1fs='$x1fs', x2fs='$x2fs', x1ftu='$x1ftu', x2ftu='$x2ftu',
  x1fv='$x1fv', x2fv='$x2fv', x1fw='$x1fw', x2fw='$x2fw', x1fx='$x1fx',
  x2fx='$x2fx', x1fy='$x1fy', x2fy='$x2fy', 
  x1g='$x1g', x2g='$x2g', x1ga1='$x1ga1', x2ga1='$x2ga1',
  x1ga2='$x1ga2', x2ga2='$x2ga2', x1ga3='$x1ga3', x2ga3='$x2ga3',
  x1ga4='$x1ga4', x2ga4='$x2ga4', x1ga5='$x1ga5', x2ga5='$x2ga5',
  x1ga6='$x1ga6', x2ga6='$x2ga6', x1gb='$x1gb', x2gb='$x2gb',
  x1gcd='$x1gcd', x2gcd='$x2gcd', x1ge='$x1ge',
  x2ge='$x2ge', x1gf='$x1gf', x2gf='$x2gf', x1gg='$x1gg', x2gg='$x2gg',
  x1gh='$x1gh', x2gh='$x2gh', x1gi='$x1gi', x2gi='$x2gi', x1gj='$x1gj',
  x2gj='$x2gj', x1gk='$x1gk', x2gk='$x2gk', x1gl='$x1gl', x2gl='$x2gl',
  x1gm='$x1gm', x2gm='$x2gm', x1h='$x1h', x2h='$x2h', x1ha='$x1ha',
  x2ha='$x2ha', x1hb='$x1hb', x2hb='$x2hb', x1hcf='$x1hcf',
  x2hcf='$x2hcf', x1i='$x1i', x2i='$x2i', x1iag='$x1iag', x2iag='$x2iag',
  x1j='$x1j', x2j='$x2j', x1jae='$x1jae', x2jae='$x2jae',
  x1jfg='$x1jfg', x2jfg='$x2jfg', x1k='$x1k', x2k='$x2k', x1l='$x1l',
  x2l='$x2l', x1lab='$x1lab', x2lab='$x2lab', x1lc='$x1lc', x2lc='$x2lc',
  x1m='$x1m', x2m='$x2m', x1n='$x1n', x2n='$x2n', x1o='$x1o', x2o='$x2o',
  x1u='$x1u', x2u='$x2u', 
  x1v='$x1v', x2v='$x2v',
  x1w='$x1w', x2w='$x2w', ".
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
$ac11 = strip_tags($_REQUEST['ac11']);       

$uprav="NO";

$uprtxt = "UPDATE F$kli_vxcf"."_poznamky_muj2014 SET ".
" ac11='$ac11', ac12='$ac12', ac21='$ac21', ac22='$ac22', ac31='$ac31', ac32='$ac32', 
  ad1='$ad1', ae2='$ae2',
  af2a='$af2a', af2b='$af2b', af3a='$af3a', af3b='$af3b',
  af6='$af6sql',
  ba1='$ba1',
  bb11a='$bb11a', bb11b='$bb11b',
  bb11c='$bb11c', bb11d='$bb11d', bb11e='$bb11e', bb12a='$bb12a',
  bb12b='$bb12b', bb12c='$bb12c', bb12d='$bb12d', bb12e='$bb12e',
  bb13a='$bb13a', bb13b='$bb13b', bb13c='$bb13c', bb13d='$bb13d',
  bb13e='$bb13e', bb14a='$bb14a', bb14b='$bb14b', bb14c='$bb14c',
  bb14d='$bb14d', bb14e='$bb14e', bb15a='$bb15a', bb15b='$bb15b',
  bb15c='$bb15c', bb15d='$bb15d', bb15e='$bb15e', bb199b='$bb199b',
  bb199c='$bb199c', bb199d='$bb199d', bb199e='$bb199e',
  bb21a='$bb21a', bb21b='$bb21bsql', bb21c='$bb21c', bb21d='$bb21d',
  bb21e='$bb21e', bb21f='$bb21f', bb22a='$bb22a', bb22b='$bb22bsql',
  bb22c='$bb22c', bb22d='$bb22d', bb22e='$bb22e', bb22f='$bb22f',
  bb23a='$bb23a', bb23b='$bb23bsql', bb23c='$bb23c', bb23d='$bb23d',
  bb23e='$bb23e', bb23f='$bb23f', bb299c='$bb299c', bb299d='$bb299d',
  bb299e='$bb299e', bb299f='$bb299f',
  ca1='$ca1', cb1='$cb1', cc1='$cc1', cc2='$cc2',
  cd11='$cd11', cd21='$cd21', cd22='$cd22', cd23='$cd23', ".
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
" bb199b=bb11b+bb12b+bb13b+bb14b+bb15b,".
" bb199c=bb11c+bb12c+bb13c+bb14c+bb15c,".
" bb199d=bb11d+bb12d+bb13d+bb14d+bb15d,".
" bb199e=bb11e+bb12e+bb13e+bb14e+bb15e,".
" bb299c=bb21c+bb22c+bb23c,".
" bb299d=bb21d+bb22d+bb23d,".
" bb299e=bb21e+bb22e+bb23e,".
" bb299f=bb21f+bb22f+bb23f ".
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

$aa1 = $fir_riadok->aa1;
$aa1sk = SkDatum($aa1);
$aa2 = $fir_riadok->aa2;


mysql_free_result($fir_vysledok);
    }
//koniec nacitania

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl_poznamky_po2011.css">

<title>Poznámky k úèt. závierke MUJ 2014</title>
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
    document.formv1.aa1.value = '<?php echo "$aa1sk";?>';

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
    document.formv1.ac11.value = '<?php echo "$ac11";?>';

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
<tr><td class="castname" colspan="10">Èl. I Všeobecné údaje</td></tr>
<tr><td class="medium" colspan="10">Èl. I.2 Údaje o konsolidovanom celku</td></tr>
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

<?php
//koniec zobraz a uprav nastavene udaje strana 1
    }
?>


<?php if ( $strana == 2 ) { ?>
<tr>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td>
<td class="rsmall" width="10%"></td><td class="rsmall" width="10%"></td>
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

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
