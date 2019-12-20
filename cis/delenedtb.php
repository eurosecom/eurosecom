<HTML>
<?php

// //POZOR NEZABUDNI !!! ALTER DATABASE do1720900db CHARACTER SET cp1250 COLLATE cp1250_general_ci
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


//nove smerovanie databaz podla roka
if(!isset($mysqldb2016)) { $mysqldb2016=$mysqldb; }
if(isset($mysqldb2016)) 
  {

mysql_select_db($mysqldb2016);

$sql = "SELECT db2019 FROM $mysqldb2016.dtbset ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$vsql = "DROP TABLE ".$mysqldb2016.".dtbset ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<mzdprc
(
   db2010       VARCHAR(20) NOT NULL,
   db2011       VARCHAR(20) NOT NULL,
   db2012       VARCHAR(20) NOT NULL,
   db2013       VARCHAR(20) NOT NULL,
   db2014       VARCHAR(20) NOT NULL,
   db2015       VARCHAR(20) NOT NULL,
   db2016       VARCHAR(20) NOT NULL, 
   db2017       VARCHAR(20) NOT NULL, 
   db2018       VARCHAR(20) NOT NULL, 
   db2019       VARCHAR(20) NOT NULL 
);
mzdprc;

$vsql = "CREATE TABLE ".$mysqldb2016.".dtbset ".$sqlt;
$vytvor = mysql_query("$vsql");

if(!isset($mysqldb2010)) { $mysqldb2010=$mysqldb; }
if(!isset($mysqldb2011)) { $mysqldb2011=$mysqldb; }
if(!isset($mysqldb2012)) { $mysqldb2012=$mysqldb; }
if(!isset($mysqldb2013)) { $mysqldb2013=$mysqldb; }
if(!isset($mysqldb2014)) { $mysqldb2014=$mysqldb; }
if(!isset($mysqldb2015)) { $mysqldb2015=$mysqldb; }
if(!isset($mysqldb2016)) { $mysqldb2016=$mysqldb; }
if(!isset($mysqldb2017)) { $mysqldb2017=$mysqldb2016; }
if(!isset($mysqldb2018)) { $mysqldb2018=$mysqldb2016; }
if(!isset($mysqldb2019)) { $mysqldb2019=$mysqldb2016; }

$vsql = "INSERT INTO ".$mysqldb2016.".dtbset ( db2010, db2011, db2012, db2013, db2014, db2015, db2016, db2017, db2018, db2019) VALUES ".
" ( '$mysqldb2010', '$mysqldb2011', '$mysqldb2012', '$mysqldb2013', '$mysqldb2014', '$mysqldb2015', '$mysqldb2016', '$mysqldb2017', '$mysqldb2018', '$mysqldb2019' ) ";
$vytvor = mysql_query("$vsql");
}

  }

$sql = "SELECT dbmain FROM $mysqldb2016.dtbset ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE ".$mysqldb2016.".dtbset ADD dbmain VARCHAR(30) DEFAULT '2016' AFTER db2019";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT db2024 FROM $mysqldb2016.dtbset ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE ".$mysqldb2016.".dtbset ADD db2020 VARCHAR(30) DEFAULT '".$mysqldb2019."' AFTER dbmain";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldb2016.".dtbset ADD db2021 VARCHAR(30) DEFAULT '".$mysqldb2019."' AFTER db2020";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldb2016.".dtbset ADD db2022 VARCHAR(30) DEFAULT '".$mysqldb2019."' AFTER db2021";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldb2016.".dtbset ADD db2023 VARCHAR(30) DEFAULT '".$mysqldb2019."' AFTER db2022";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldb2016.".dtbset ADD db2024 VARCHAR(30) DEFAULT '".$mysqldb2019."' AFTER db2023";
$vysledek = mysql_query("$sql");
}

// cislo operacie
$copern = 1*$_REQUEST['copern'];
if( $copern == 1 ) { $copern=2; }


//zaloz db
if ( $copern == 99001 )
    {
$h_dbmain = strip_tags($_REQUEST['h_dbmain']);


?>
<script type="text/javascript">
if( !confirm ("Chcete zaloûiù datab·zu pre rok <?php echo $h_dbmain; ?> ? ") )
         { location.href='delenedtb.php?copern=2'  }
else
         { location.href='delenedtb.php?h_dbmain=<?php echo $h_dbmain; ?>&copern=99002'  }
</script>
<?php
    }

    if ( $copern == 99002 )
    {
$h_dbmain = strip_tags($_REQUEST['h_dbmain']);

if( $h_dbmain <= 2019 ) 
 {
echo "Datab·za pre rok ".$h_dbmain." ???";
exit;
 }

if( $h_dbmain >  2020 ) 
 {
echo "Datab·za pre rok ".$h_dbmain." ???";
exit;
 }

if( $h_dbmain <= 2016 ) { $databazakam=$mysqldb2016; $databazaodkial=$mysqldb2015; }
if( $h_dbmain == 2017 ) { $databazakam=$mysqldb2017; $databazaodkial=$mysqldb2016; }
if( $h_dbmain == 2018 ) { $databazakam=$mysqldb2018; $databazaodkial=$mysqldb2017; }
if( $h_dbmain == 2019 ) { $databazakam=$mysqldb2019; $databazaodkial=$mysqldb2018; }
if( $h_dbmain == 2020 ) { $databazakam=$mysqldb2020; $databazaodkial=$mysqldb2019; }

$pocp=0;
$poslhh = "SELECT * FROM ".$databazakam.".klienti ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $pocp = 1*mysql_num_rows($posl); }
if( $pocp >= 1 ) 
  {
echo "Datab·za ".$databazakam." pre rok ".$h_dbmain." uû bola zaloûen·. NemÙûete opakovaù zaloûenie datab·zy.";
exit;
  }

//zacni vytvarat

$sqlttt=" ALTER DATABASE ".$mysqldbkam." CHARACTER SET cp1250 COLLATE cp1250_general_ci "; 
$sql = mysql_query("$sqlttt");
echo $sqlttt."<br />";

$mysqldbkam=$databazakam;
$mysqldbodkial=$databazaodkial;

$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`dlogin` SELECT * FROM `".$mysqldbodkial."`.`dlogin` WHERE id < 0"; $sql = mysql_query("$sqlttt");
echo $sqlttt."<br />";
$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`druzis` SELECT * FROM `".$mysqldbodkial."`.`druzis` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`ezak` SELECT * FROM `".$mysqldbodkial."`.`ezak` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`fir` SELECT * FROM `".$mysqldbodkial."`.`fir` "; $sql = mysql_query("$sqlttt");

$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`h4blogin` SELECT * FROM `".$mysqldbodkial."`.`h4blogin` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`h4bregister` SELECT * FROM `".$mysqldbodkial."`.`h4bregister` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`h4bregister_rgp` SELECT * FROM `".$mysqldbodkial."`.`h4bregister_rgp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`infotext` SELECT * FROM `".$mysqldbodkial."`.`infotext` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".ipxok_no SELECT * FROM ".$mysqldbodkial.".ipxok_no "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".kalendar SELECT * FROM ".$mysqldbodkial.".kalendar "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldbkam."`.`klienti` SELECT * FROM `".$mysqldbodkial."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".krtgrd SELECT * FROM ".$mysqldbodkial.".krtgrd "; $sql = mysql_query("$sqlttt");

$sqlttt=" CREATE TABLE ".$mysqldbkam.".majmajpol SELECT * FROM ".$mysqldbodkial.".majmajpol "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".menp SELECT * FROM ".$mysqldbodkial.".menp "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".mzddmn SELECT * FROM ".$mysqldbodkial.".mzddmn "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".mzdkunes SELECT * FROM ".$mysqldbodkial.".mzdkunes "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".mzdpomer SELECT * FROM ".$mysqldbodkial.".mzdpomer "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".mzdzampol SELECT * FROM ".$mysqldbodkial.".mzdzampol "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".nas_id SELECT * FROM ".$mysqldbodkial.".nas_id "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".personal_dok SELECT * FROM ".$mysqldbodkial.".personal_dok "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".poslanemail SELECT * FROM ".$mysqldbodkial.".poslanemail "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".skluzid SELECT * FROM ".$mysqldbodkial.".skluzid "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".treximafir SELECT * FROM ".$mysqldbodkial.".treximafir "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".treximaoc SELECT * FROM ".$mysqldbodkial.".treximaoc "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".uctpohyby SELECT * FROM ".$mysqldbodkial.".uctpohyby "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".uctpohyby2010 SELECT * FROM ".$mysqldbodkial.".uctpohyby2010 "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".uctpohyby2011 SELECT * FROM ".$mysqldbodkial.".uctpohyby2011 "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".uctpoznamkypo SELECT * FROM ".$mysqldbodkial.".uctpoznamkypo "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".ucttopman SELECT * FROM ".$mysqldbodkial.".ucttopman "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".vtvtab SELECT * FROM ".$mysqldbodkial.".vtvtab "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".webslu SELECT * FROM ".$mysqldbodkial.".webslu "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".spravy SELECT * FROM ".$mysqldbodkial.".spravy "; $sql = mysql_query("$sqlttt");

$sqlttt=" CREATE TABLE ".$mysqldbkam.".uctosnova_PU SELECT * FROM ".$mysqldbodkial.".uctosnova_PU "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".uctosnova_JU SELECT * FROM ".$mysqldbodkial.".uctosnova_JU "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".mzddmn SELECT * FROM ".$mysqldbodkial.".mzddmn "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE ".$mysqldbkam.".mzdpomer SELECT * FROM ".$mysqldbodkial.".mzdpomer "; $sql = mysql_query("$sqlttt");

$sqlttt=" CREATE TABLE ".$mysqldbkam.".firuz SELECT * FROM ".$mysqldbodkial.".firuz "; $sql = mysql_query("$sqlttt");

$sqltt = "CREATE TABLE ".$mysqldbkam.".zozicdph01 SELECT * FROM ".$mysqldbodkial.".zozicdph01 ";
$tov = mysql_query("$sqltt");

$sqlttx = "SELECT * FROM zozicdph01 ";

$tov = mysql_query("$sqlttx");
$tvpol = mysql_num_rows($tov);
//echo $sqltt."<br />"."pol ".$tvpol."<br />";

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE ".$mysqldbkam.".zozicdph01new20032014 ".$sqlt;
//echo $sql."<br />";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbkam.".zozicdph01new30052014 ".$sqlt;
//echo $sql."<br />";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbkam.".zozicdph01new150220 ".$sqlt;
//echo $sql."<br />";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbkam.".zozicdph01new160531 ".$sqlt;
//echo $sql."<br />";
$vysledek = mysql_query("$sql");


echo "modify primary, timestamp"."<br />";


$sql = "ALTER TABLE ".$mysqldbkam.".dlogin MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".ezak MODIFY ez_id int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".ezak MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".fir MODIFY xcf int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".h4bregister MODIFY rcpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".h4bregister_rgp MODIFY rcpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".krtgrd MODIFY id int UNIQUE ";
//$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".personal_dok MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".uctpoznamkypo MODIFY oc int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".ucttopman MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbkam.".mzddmn MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".mzdpomer MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".nas_id MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".poslanemail MODIFY kedye timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".skluzid MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ".$mysqldbkam.".uctpohyby MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


echo "Databaza 2020 zalozena.<br />";


$copern=2;
    }
//koniec zaloz db

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
$db2020 = strip_tags($_REQUEST['db2020']);
$db2021 = strip_tags($_REQUEST['db2021']);
$db2022 = strip_tags($_REQUEST['db2022']);
$db2023 = strip_tags($_REQUEST['db2023']);
$db2024 = strip_tags($_REQUEST['db2024']);
$dbmain = strip_tags($_REQUEST['dbmain']);
//dbmain musi byt 2016, tam je original fir a klienti
$dbmain = "2016";

$upravttt = "UPDATE ".$mysqldb2016.".dtbset SET ".
" db2010='$db2010', db2011='$db2011', db2012='$db2012', db2013='$db2013', db2014='$db2014', db2015='$db2015', ".
" db2016='$db2016', db2017='$db2017', db2018='$db2018', db2019='$db2019', dbmain='$dbmain', db2020='$db2020', ". 
" db2021='$db2021', db2022='$db2022', db2023='$db2023', db2024='$db2024' ";
//echo $upravttt;
$upravene = mysql_query("$upravttt"); 
$copern=2;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
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
$db2020 = $riadok->db2020;
$db2021 = $riadok->db2021;
$db2022 = $riadok->db2022;
$db2023 = $riadok->db2023;
$db2024 = $riadok->db2024;
$dbmain = $riadok->dbmain;

//koniec nacitania



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DELEN… DTB v.2016</title>
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
    document.formv1.db2020.value = '<?php echo "$db2020";?>';
    document.formv1.db2021.value = '<?php echo "$db2021";?>';
    document.formv1.db2022.value = '<?php echo "$db2022";?>';
    document.formv1.db2023.value = '<?php echo "$db2023";?>';
    document.formv1.db2024.value = '<?php echo "$db2024";?>';
    document.formv1.dbmain.value = '<?php echo "$dbmain";?>';


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


  function VytvorMain()
  { 

  var h_dbmain = document.forms.formv1.dbmain.value;

  window.open('delenedtb.php?h_dbmain=' + h_dbmain + '&copern=99001', '_self'  );
  }

</script>
</HEAD>
<BODY class="white" onload="ObnovUI();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  DELEN… DTB v.2016</td>
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
<td class="bmenu" colspan="1">Main DB</td>
<td class="fmenu" colspan="2"><input type="text" name="dbmain" id="dbmain" size="20"/> 

<img border=0 src='../obr/vlozit.png' style='width:14px; height:14px;' onClick="VytvorMain();" title='Main DB musÌ byù st·le 2016. Len pri zaloûenÌ treba vloûiù rok, ktor˝ sa zaklad·. Zakladan· datab·za, musÌ byù vytvoren· v phpMyadmin' ></td></tr>  

</td>
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
<td class="bmenu" colspan="1">DB 2020</td>
<td class="fmenu" colspan="2"><input type="text" name="db2020" id="db2020" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2021</td>
<td class="fmenu" colspan="2"><input type="text" name="db2021" id="db2021" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2022</td>
<td class="fmenu" colspan="2"><input type="text" name="db2022" id="db2022" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2023</td>
<td class="fmenu" colspan="2"><input type="text" name="db2023" id="db2023" size="20"/> </td>
</tr>
<tr>
<td class="bmenu" colspan="1">DB 2024</td>
<td class="fmenu" colspan="2"><input type="text" name="db2024" id="db2024" size="20"/> </td>
</tr>

<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
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
