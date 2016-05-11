<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 100000;
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
if( $copern == 1 ) { $copern=2; }

//zapis upravene udaje
if ( $copern == 3 )
    {
$db2010 = strip_tags($_REQUEST['db2010']);
$db2011 = strip_tags($_REQUEST['db2011']);
$db2012 = strip_tags($_REQUEST['db2012']);
$db2013 = strip_tags($_REQUEST['db2013']);
$db2014 = strip_tags($_REQUEST['db2014']);
$db2015 = strip_tags($_REQUEST['db2015']);
$db2016 = strip_tags($_REQUEST['db2016']);
$db2017 = strip_tags($_REQUEST['db2017']);
$db2018 = strip_tags($_REQUEST['db2018']);
$db2019 = strip_tags($_REQUEST['db2019']);


$upravttt = "UPDATE ".$mysqldb2016.".dtbset SET ".
" db2010='$db2010', db2011='$db2011', db2012='$db2012', db2013='$db2013', db2014='$db2014', db2015='$db2015', ".
" db2016='$db2016', db2017='$db2017', db2018='$db2018', db2019='$db2019' ";  
//echo $upravttt;
$upravene = mysql_query("$upravttt"); 
$copern=2;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu uprav udaje



//nacitaj udaje

$sql = "SELECT * FROM ".$mysqldb2016.".dtbset ";
$vysledok = mysql_query($sql);
//echo $sql;
$riadok=mysql_fetch_object($vysledok);

$db2010 = $riadok->db2010;
$db2011 = $riadok->db2011;
$db2012 = $riadok->db2012;
$db2013 = $riadok->db2013;
$db2014 = $riadok->db2014;
$db2015 = $riadok->db2015;
$db2016 = $riadok->db2016;
$db2017 = $riadok->db2017;
$db2018 = $riadok->db2018;
$db2019 = $riadok->db2019;


//koniec nacitania



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DELENÉ DTB v.2016</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
<?php
//uprava udaje o firme
  if ( $copern == 2 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.db2010.value = '<?php echo "$db2010";?>';
    document.formv1.db2011.value = '<?php echo "$db2011";?>';
    document.formv1.db2012.value = '<?php echo "$db2012";?>';
    document.formv1.db2013.value = '<?php echo "$db2013";?>';
    document.formv1.db2014.value = '<?php echo "$db2014";?>';
    document.formv1.db2015.value = '<?php echo "$db2015";?>';
    document.formv1.db2016.value = '<?php echo "$db2016";?>';
    document.formv1.db2017.value = '<?php echo "$db2017";?>';
    document.formv1.db2018.value = '<?php echo "$db2018";?>';
    document.formv1.db2019.value = '<?php echo "$db2019";?>';


    }
<?php
//koniec uprava
  }
?>



//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }



</script>
</HEAD>
<BODY class="white" onload="ObnovUI();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  DELENÉ DTB v.2016</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php
//upravy  udaje 
if ( $copern == 2 )
    {
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="delenedtb.php?copern=3" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>


<tr>
<td class="bmenu" colspan="1">DB 2010</td>
<td class="fmenu" colspan="2"><input type="text" name="db2010" id="db2010" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2011</td>
<td class="fmenu" colspan="2"><input type="text" name="db2011" id="db2011" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2012</td>
<td class="fmenu" colspan="2"><input type="text" name="db2012" id="db2012" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2013</td>
<td class="fmenu" colspan="2"><input type="text" name="db2013" id="db2013" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2014</td>
<td class="fmenu" colspan="2"><input type="text" name="db2014" id="db2014" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2015</td>
<td class="fmenu" colspan="2"><input type="text" name="db2015" id="db2015" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2016</td>
<td class="fmenu" colspan="2"><input type="text" name="db2016" id="db2016" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2017</td>
<td class="fmenu" colspan="2"><input type="text" name="db2017" id="db2017" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2018</td>
<td class="fmenu" colspan="2"><input type="text" name="db2018" id="db2018" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2019</td>
<td class="fmenu" colspan="2"><input type="text" name="db2019" id="db2019" size="20"/> </td>
</tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloži úpravy"></td>
</tr>
</FORM>

</table>
<?php
    }
//koniec uprav  udaje o firme
?>



<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
