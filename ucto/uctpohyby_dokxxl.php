<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];
$cele = $_REQUEST['cele'];
if( $cele != 0 ) $cele=1;

$ucedlzka=strlen($cislo_uce);
//echo $ucedlzka;

$uziv = include("../uziv.php");
if( !$uziv ) exit;


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$vyb_ume = $_REQUEST['vyb_ume'];
if(!isset($vyb_ume)) { $vyb_ume = $kli_vume; }
$vyb_ump = $_REQUEST['vyb_ump'];
if(!isset($vyb_ump)) { $vyb_ump = $kli_vume; }
$zvypisu=0;
//volanie z vypisu pohybov
if( $drupoh == 11 )
{
$h_obdp = $_REQUEST['h_obdp'];
$h_obdk = $_REQUEST['h_obdk'];
if( $h_obdk == 0 ) $h_obdk=12;
$vyb_ume=$h_obdk.".".$kli_vrok;
if( $h_obdp == 0 ) $h_obdp=01;
$vyb_ump=$h_obdp.".".$kli_vrok;
$drupoh=1;
$cele=0;
$zvypisu=1;
}
//echo $vyb_ume;
//echo $vyb_ump;

$uctpohyby = $_REQUEST['uctpohyby'];
$jedatum=0;
if( $uctpohyby == 1 )
{
$h_datp = $_REQUEST['h_datp'];
$h_datk = $_REQUEST['h_datk'];
$h_datpsql = SqlDatum($h_datp);
$h_datksql = SqlDatum($h_datk);
$pocroka="01.01.".$kli_vrok;
$konroka="31.12.".$kli_vrok;
if( $h_datp != '' AND $h_datp != $pocroka ) $jedatum=1;
if( $h_datk != '' AND $h_datk != $konroka ) $jedatum=1;

//echo $h_datp." ".$h_datk." ".$jedatum;
//echo $h_datpsql." ".$h_datksql." ".$jedatum;
}

//pracovny subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcuobrats
(
   psys         INT,
   uro          INT(8),
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT(8),
   uce          VARCHAR(10),
   ur1          INT(10),
   puc          INT(10),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   rdp          INT(2),
   ico          INT(10),
   fak          INT(10),
   str          INT,
   zak          INT,
   hod          DECIMAL(10,2),
   mdt          DECIMAL(10,2),
   dal          DECIMAL(10,2),
   zos          DECIMAL(10,2),
   pop          VARCHAR(80),
   pox          INT(10),
   pmd          DECIMAL(10,2),
   pdl          DECIMAL(10,2),
   bmd          DECIMAL(10,2),
   bdl          DECIMAL(10,2),
   omd          DECIMAL(10,2),
   odl          DECIMAL(10,2),
   zmd          DECIMAL(10,2),
   zdl          DECIMAL(10,2),
   PRIMARY KEY(cpl)
);
prcuobrats;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//datum pociatku
$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $vyb_ume);
$vyb_mume=$pole[0];
$vyb_rume=$pole[1];
if( $vyb_mume < 10 ) $vyb_mume="0".$vyb_mume;

$ume_poc=$vyb_ume;
$datp_ume=$vyb_rume.'-'.$vyb_mume.'-01';
$datk_ume=$vyb_rume.'-'.$vyb_mume.'-01';
if( $cele == 1 ) { $datp_ume=$vyb_rume.'-01-01'; $ume_poc="1.2009"; }
if( $zvypisu == 1 ) { $datp_ume=$vyb_rume."-".$h_obdp.'-01'; $ume_poc=$vyb_ump; }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_ume', '$datk_ume', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp=SUBDATE('$datp_ume',1),  datk=LAST_DAY('$datk_ume')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

if( $jedatum == 1 ) 
{
$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$h_datpsql',  datk='$h_datksql' ".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

}

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_ume=$riadok->datp;
  $datk_ume=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_umesk=SkDatum($datp_ume);
$datk_umesk=SkDatum($datk_ume);

$dat_pcc=$datp_ume;
$ume_pcc="0";

//echo $datp_ume." ".$datk_ume;

//synteticky alebo analyticky ucet
$couce="uce";
$coucm="ucm";
$coucd="ucd";
if( $drupoh == 56 ) { $couce="LEFT(uce,3)"; $coucm="LEFT(ucm,3)"; $coucd="LEFT(ucd,3)"; }

if( $ucedlzka == 3 AND $kli_vduj == 0 ) { $couce="LEFT(uce,3)"; $coucm="LEFT(ucm,3)"; $coucd="LEFT(ucd,3)"; }


//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,0,F$kli_vxcf"."_uctosnova.pmd,F$kli_vxcf"."_uctosnova.pmd,0,0,'poËiatoËn˝ stav $ume_poc',1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE $couce = $cislo_uce AND pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,0,-F$kli_vxcf"."_uctosnova.pda,-F$kli_vxcf"."_uctosnova.pda,0,0,'poËiatoËn˝ stav $ume_poc',1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE $couce = $cislo_uce AND pda != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$psys=1;
$kolkopsys=9;


 while ($psys <= $kolkopsys ) 
 {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }

//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND $coucm = $cislo_uce AND ume <= $vyb_ume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucd,1,ucm,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,0,F$kli_vxcf"."_$uctovanie.hod,".
"0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND $coucd = $cislo_uce AND ume <= $vyb_ume";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,hod,".
"0,0,pop,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE $coucm = $cislo_uce AND ume <= $vyb_ume";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucd,1,ucm,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,0,hod,".
"0,pop,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE $coucd = $cislo_uce AND ume <= $vyb_ume";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

//ak za sysntetiku prepis ucet na synteticky
if( $ucedlzka == 3 AND $kli_vduj == 0 )
{ 
$dsqlt = "DELETE FROM F$kli_vxcf"."_prcuobrats$kli_uzid "." WHERE $couce != $cislo_uce";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid "." SET uce=$cislo_uce ";
$dsql = mysql_query("$dsqlt");
}

//sumar za doklady ur1=999
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" psys,1,0,ume,dat,dok,uce,999,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE $couce = $cislo_uce".
" GROUP BY dok,uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vloz pre ocislovanie poloziek
if( $cele == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ume <= $vyb_ume AND F$kli_vxcf"."_prcuobrats$kli_uzid.ur1 = 999".
" ORDER BY uce,ur1,dat,dok,hod";
$dsql = mysql_query("$dsqlt");
}
if( $cele == 0 )
{
$vyb_obd="ume = ".$vyb_ume;
$podvyb_obd="ume < ".$vyb_ume;
$vybr_obdobie=$vyb_ume;
if( $zvypisu == 1 ) { 
$vyb_obd="ume <= ".$vyb_ume." AND ume >= ".$vyb_ump;
$podvyb_obd="ume < ".$vyb_ump; 
$vybr_obdobie=$h_obdp.".".$vyb_rume." aû ".$vyb_ume;
                    }

//echo $vyb_obd; //echo $podvyb_obd;
if( $jedatum == 0 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE $vyb_obd AND F$kli_vxcf"."_prcuobrats$kli_uzid.ur1 = 999".
" ORDER BY uce,ur1,dat,dok,hod";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid "." SELECT".
" psys,1,0,$ume_pcc,'$dat_pcc',0,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),'poËiatoËn˝ stav $ume_poc',1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE $podvyb_obd AND F$kli_vxcf"."_prcuobrats$kli_uzid.ur1 = 999".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
    }
if( $jedatum == 1 )
     {
$pole = explode("-", $datp_ume);
$datp_rok=$pole[0];
$datp_mes=$pole[1];
$datp_obd=$datp_mes.".".$datp_rok;

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE dat >= '$datp_ume' AND dat <= '$datk_ume' AND F$kli_vxcf"."_prcuobrats$kli_uzid.ur1 = 999".
" ORDER BY uce,ur1,dat,dok,hod";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid "." SELECT".
" psys,1,0,$ume_pcc,'$dat_pcc',0,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),'poËiatoËn˝ stav $ume_poc',1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE dat < '$datp_ume' AND F$kli_vxcf"."_prcuobrats$kli_uzid.ur1 = 999".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
    }
}
//koniec ak cele=0

//exit;

if (File_Exists ("../tmp/poklkni.$kli_uzid.pdf")) { $soubor = unlink("../tmp/poklkni.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$navysku = 1*$_REQUEST['navysku'];
if( $navysku == 0 ) $pdf=new FPDF("L","mm","A4");
if( $navysku == 1 ) $pdf=new FPDF("P","mm","A4"); 
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Pohyby za doklady na ˙Ëte</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
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

<?php
if( $typ == 'HTML' )
{
//#252,170,18
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom 
  <a href="#" onClick="window.open('uctpohyby_dokxxl.php?uctpohyby=<?php echo $uctpohyby; ?>&copern=<?php echo $copern; ?>&drupoh=11&h_obdp=<?php echo $h_obdp;?>
&h_obdk=<?php echo $h_obdk;?>&h_datp=<?php echo $h_datp;?>
&h_datk=<?php echo $h_datk;?>&page=1&typ=PDF&cislo_uce=<?php echo $cislo_uce; ?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=25 height=15 border=0 title='VytlaËiù vo form·te PDF na öÌrku' ></a>

  <a href="#" onClick="window.open('uctpohyby_dokxxl.php?uctpohyby=<?php echo $uctpohyby; ?>&copern=<?php echo $copern; ?>&drupoh=11&h_obdp=<?php echo $h_obdp;?>
&h_obdk=<?php echo $h_obdk;?>&h_datp=<?php echo $h_datp;?>
&h_datk=<?php echo $h_datk;?>&page=1&typ=PDF&cislo_uce=<?php echo $cislo_uce; ?>&navysku=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=15 height=20 border=0 title='VytlaËiù vo form·te PDF na v˝öku' ></a>


</td>
<td align="right">
<?php
$pole = explode(".", $vyb_ume);
$kli_vms=$pole[0];
$kli_vrk=$pole[1];

$prev_obdk=$kli_vms-1; $next_obdk=$kli_vms+1;
if( $prev_obdk == 0 ) { $prev_obdk=12; }
if( $next_obdk == 13 ) { $next_obdk=1; }

$prev_ume=$prev_obdk.".".$kli_vrk; $next_ume=$next_obdk.".".$kli_vrk;

      if( $cele == 0 ) { ?>
<a href="#" onClick="window.open('uctpohyby_dokxxl.php?copern=<?php echo $copern;?>&drupoh=<?php echo $drupoh;?>&vyb_ume=<?php echo $prev_ume;?>
&page=1&typ=HTML&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Obdobie <?php echo $prev_ume; ?>' ></a>
<a href="#" onClick="window.open('uctpohyby_dokxxl.php?copern=<?php echo $copern;?>&drupoh=<?php echo $drupoh;?>&vyb_ume=<?php echo $next_ume;?>
&page=1&typ=HTML&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 title='Obdobie <?php echo $next_ume; ?>' ></a>
<?php                  } ?>
<span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" WHERE psys >= 0".
" ORDER BY dat,dok";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcuobratsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prcuobratsy$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" WHERE cpl > 0 "."ORDER BY cpl";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

//sumare napocet
$hotp = 0.00;
$hotv = 0.00;
$hotz = 0.00;

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);


if ( $j == 0 )
      {

if( $typ == 'PDF' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$cislo_ucc=1*$cislo_uce;

if( $copern == 40 )
    {
$UCM="⁄Ëet";
$UCD="Proti";
$PRI="PrÌjem";
$VYD="V˝davok";
    }

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce = $cislo_uce");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $nazuce=$riaddok->nuc;
  }


$pdf->Cell(90,5,"Pohyby na ˙Ëte $cislo_uce $nazuce - sum·r za doklad","LTB",0,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(0,3,"FIR$kli_vxcf $kli_nxcf strana $strana","RT",1,"R");
$pdf->SetFont('arial','',6);
$dnesoktime = Date ("d.m.Y H:i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$pdf->Cell(0,2,"$dnesoktime","RB",1,"R");


$pdf->SetFont('arial','',8);


$pdf->Cell(12,4,"Poloûka","1",0,"R");$pdf->Cell(14,4,"D·tum","1",0,"R");$pdf->Cell(15,4,"Doklad","1",0,"R");

$pdf->Cell(12,4,"$UCM","1",0,"R");$pdf->Cell(18,4,"$PRI","1",0,"R");$pdf->Cell(18,4,"$VYD","1",0,"R");$pdf->Cell(18,4,"Zostatok","1",0,"R");

$pdf->Cell(0,4,"Popis","1",1,"L");

}


if( $typ == 'HTML' )
{
$cislo_ucc=1*$cislo_uce;

if( $copern == 40 )
    {
$UCM="⁄Ëet";
$UCD="Proti";
$PRI="PrÌjem";
$VYD="V˝davok";
    }

?>
<table class="vstup" width="100%" >
<tr>
<?php
if( $drupoh == 1 OR $drupoh == 2 )
{
?>
<td class="bmenu" colspan="4">Pohyby na ˙Ëte <?php echo $cislo_uce." ".$polozka->nuc; ?> - sum·r za doklad</td>
<td class="bmenu" colspan="4" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="7%">Poloûka</td>
<td class="bmenu" width="7%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="8%"><?php echo $UCM; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $PRI; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $VYD; ?></td>
<td class="hvstup_zlte" width="10%" align="right">Zostatok</td>

<td class="bmenu" width="38%" >Popis</td>

</tr>

<?php
}
?>
<?php
if( $drupoh == 4 )
{
?>
<td class="bmenu" colspan="4">Zostatok BankovÈho ˙Ëtu</td>
<td class="bmenu" colspan="4" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="7%">Poloûka</td>
<td class="bmenu" width="7%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="8%"><?php echo $UCM; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $PRI; ?></td>
<td class="hvstup_zlte" width="10%" align="right"><?php echo $VYD; ?></td>
<td class="hvstup_zlte" width="10%" align="right">Zostatok</td>

<td class="bmenu" width="38%" >Popis</td>

</tr>
<?php
}
?>
<?php
if( $drupoh == 55 )
{
?>
<td class="bmenu" colspan="4">Zostatok ˙Ëtu</td>
<td class="bmenu" colspan="4" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="7%">Poloûka</td>
<td class="bmenu" width="7%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="8%"><?php echo $UCM; ?></td>
<td class="hvstup_zlte" width="10%" align="right">M·Daù</td>
<td class="hvstup_zlte" width="10%" align="right">Dal</td>
<td class="hvstup_zlte" width="10%" align="right">Zostatok</td>

<td class="bmenu" width="38%" >Popis</td>

</tr>
<?php
}
?>
<?php
if( $drupoh == 56 )
{
?>
<td class="bmenu" colspan="4">Zostatok syntetickÈho ˙Ëtu</td>
<td class="bmenu" colspan="4" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>
<td class="bmenu" width="7%">Poloûka</td>
<td class="bmenu" width="7%">D·tum</td>
<td class="bmenu" width="10%">Doklad</td>

<td class="hvstup_zlte" width="8%"><?php echo $UCM; ?></td>
<td class="hvstup_zlte" width="10%" align="right">M·Daù</td>
<td class="hvstup_zlte" width="10%" align="right">Dal</td>
<td class="hvstup_zlte" width="10%" align="right">Zostatok</td>

<td class="bmenu" width="38%" >Popis</td>

</tr>
<?php
}
?>

<?php
}

      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;



$h_hotp=0;
$h_hotv=0;

$h_hotp=$polozka->mdt;
$h_hotv=$polozka->dal;

$tlacuce=$polozka->uce;
if( $ucedlzka == 3 AND $kli_vduj == 0 ) { $tlacuce=$cislo_uce; }

//ak je nulova polozka daj medzeru
if( $h_pokc == 0 ) $h_pokc="";
if( $h_hotp == 0 ) $h_hotp="";
if( $h_hotv == 0 ) $h_hotv="";
if( $h_poh == 0 ) $h_poh="";


//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hotp = $hotp + $h_hotp;
$Cislo=$hotp+"";
$shotp=sprintf("%0.2f", $Cislo);
$hotv = $hotv + $h_hotv;
$Cislo=$hotv+"";
$shotv=sprintf("%0.2f", $Cislo);
$hotz=$hotz+$h_hotp-($h_hotv);
$Cislo=$hotz+"";
$shotz=sprintf("%0.2f", $Cislo);

$poc_obd=$h_obdp.".".$vyb_rume;
$kon_obd=$vyb_ume;
$vyber_obdobie="$polozka->ume >= ".$h_obdp.".".$vyb_rume." AND $polozka->ume <= ".$vyb_ume;

if( $polozka->ume == $vyb_ume AND $zvypisu == 0 )
{
$hotpume = $hotpume + $h_hotp;
$Cislo=$hotpume+"";
$shotpume=sprintf("%0.2f", $Cislo);
$hotvume = $hotvume + $h_hotv;
$Cislo=$hotvume+"";
$shotvume=sprintf("%0.2f", $Cislo);
}
if( $polozka->ume >= $poc_obd AND $polozka->ume <= $kon_obd AND $zvypisu == 1 )
{
$hotpume = $hotpume + $h_hotp;
$Cislo=$hotpume+"";
$shotpume=sprintf("%0.2f", $Cislo);
$hotvume = $hotvume + $h_hotv;
$Cislo=$hotvume+"";
$shotvume=sprintf("%0.2f", $Cislo);
}

$popis=$polozka->nuc;
if( $kli_vduj == 0 ) $popis=$polozka->pop;
$pohc=1*$polozka->poh;
if( $pohc >= 34300 AND $pohc <= 34399  ) $popis=$popis." RDP".$polozka->rdp." ".$polozka->nrd;

if( $polozka->fak != 0 ) $popis=$popis." Fakt˙ra: ".$polozka->fak." I»O: ".$polozka->ico." ".$polozka->nai." ".$polozka->mes;


if( $typ == 'PDF' )
{

$pdf->Cell(12,4,"$polozka->cpl","0",0,"R");$pdf->Cell(14,4,"$datsk","0",0,"R");$pdf->Cell(15,4,"$polozka->dok","0",0,"R");

$pdf->Cell(12,4,"$tlacuce","0",0,"R");$pdf->Cell(18,4,"$h_hotp","0",0,"R");$pdf->Cell(18,4,"$h_hotv","0",0,"R");$pdf->Cell(18,4,"$shotz","0",0,"R");

$pdf->Cell(0,4,"$polozka->pop","0",1,"L");

}

if( $typ == 'HTML' )
{
?>

<tr>
<td class="hvstup"><?php echo $polozka->cpl; ?></td>
<td class="hvstup"><?php echo $datsk; ?></td>
<td class="hvstup">
<?php
if( $polozka->pox > 0 AND $polozka->dok > 0  )
{
?>
<?php if( $polozka->psys == 1 )
  { ?>
<?php if( substr($polozka->ucm,0,3) == 211 ) { $hladaj_ucex=$polozka->ucm; $h_ucex=$polozka->ucm; } ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $hladaj_ucex;?>&h_uce=<?php echo $h_ucex;?>&rozuct=ANO&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho prÌjmovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 2 )
  { ?>
<?php if( substr($polozka->ucd,0,3) == 211 ) { $hladaj_ucex=$polozka->ucd; $h_ucex=$polozka->ucd; } ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $hladaj_ucex;?>&h_uce=<?php echo $h_ucex;?>&rozuct=ANO&copern=8&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho pokladniËnÈho v˝davkovÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 3 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho bankovÈho v˝pisu " ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=4&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho bankovÈho v˝pisu " ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 4 )
  { ?>
<a href="#" onClick="window.open('vspk_u.php?sysx=UCT&rozuct=ANO&copern=8&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<a href="#" onClick="window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho vöeobecnÈho ˙ËtovnÈho dokladu" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 5 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej odberateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=1&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej odberateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php if( $polozka->psys == 6 )
  { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 title="⁄prava vybranej dod·vateæskej fakt˙ry" ></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&rozuct=NIE&copern=20&drupoh=2&page=1&cislo_dok=<?php echo $polozka->dok;?>', '_blank',
 'width=700, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranej dod·vateæskej fakt˙ry" ></a>
<?php 
  } ?>
<?php
}
?>
<?php echo $polozka->dok;?>

</td>

<td class="hvstup_zlte"><?php echo $tlacuce; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotp; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $h_hotv; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $shotz; ?></td>

<td class="hvstup" ><?php echo $polozka->pop; ?></td>

</tr>
<?php
}


}
$i = $i + 1;
$j = $j + 1;

//koniec stranky
if( $j == 60 )
      {

if( $typ == 'PDF' )
{
//tlac sumare za stranu


}

$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky



  }
//koniec polozky


if( $typ == 'PDF' )
{
//tlac sumare
if( $cele == 0 )
     {
$pdf->Cell(41,5,"Spolu za $vybr_obdobie","1",0,"L");
$pdf->Cell(12,5," ","1",0,"R");$pdf->Cell(18,5,"$shotpume","1",0,"R");$pdf->Cell(18,5,"$shotvume","1",0,"R");$pdf->Cell(18,5,"$shotzume","1",1,"R");
     }

$pdf->Cell(41,5,"Spolu celkom","1",0,"L");
$pdf->Cell(12,5," ","1",0,"R");$pdf->Cell(18,5,"$shotp","1",0,"R");$pdf->Cell(18,5,"$shotv","1",0,"R");$pdf->Cell(18,5,"$shotz","1",1,"R");


//tlac textu na zostavy
$zostxx = include("../cis/zostxx.php");
//koniec tlac textu na zostavy

$pdf->Output("../tmp/poklkni.$kli_uzid.pdf");
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/poklkni.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}


if( $typ == 'HTML' )
{
if( $cele == 0 )
     {
?>
<tr>
<td class="bmenu" colspan="3">Spolu za <?php echo $vybr_obdobie; ?></td>
<td class="hvstup_tzlte"></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotpume; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotvume; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotzume; ?></td>
</tr>
<?php
     }
?>
<tr>
<td class="bmenu" colspan="3">Spolu celkom</td>
<td class="hvstup_tzlte"></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotp; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotv; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $shotz; ?></td>
</tr>

</table>
<?php
}

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpoklknisy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniks'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcudenniksy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendens'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcpendensy'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoico'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");


?>


<?php

// celkovy koniec dokumentu

$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
