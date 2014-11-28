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

$sql = "SELECT ac32 FROM F$kli_vxcf"."_poznamky_muj2014 WHERE ico=0";
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
//$upravene = mysql_query("$uprtxt");



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
