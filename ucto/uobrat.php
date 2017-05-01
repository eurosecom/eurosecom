<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];

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

$vyb_ume=$kli_vume;
$vyb_umep=$kli_vume;
$vyb_umek=$kli_vume;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$h_obdp=$kli_vmes;
$h_obdk=$kli_vmes;

if( $copern == 11 )
{
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) $h_obdp=1;
if( $h_obdk == 0 ) $h_obdk=12;
$vyb_ume=$h_obdk.".".$kli_vrok;
$vyb_umep=$h_obdk.".".$kli_vrok;
$vyb_umek=$h_obdk.".".$kli_vrok;
$copern=$copern-1;
}

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/uobrat_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/uobrat_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }


   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctzosuce';
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
   puc          VARCHAR(10),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   rdp          INT(2),
   ico          INT(10),
   fak          varchar(10),
   str          INT,
   zak          INT,
   hod          DECIMAL(12,2),
   mdt          DECIMAL(12,2),
   dal          DECIMAL(12,2),
   zos          DECIMAL(12,2),
   pop          VARCHAR(80),
   pox          INT(10),
   pmd          DECIMAL(12,2),
   pdl          DECIMAL(12,2),
   bmd          DECIMAL(12,2),
   bdl          DECIMAL(12,2),
   omd          DECIMAL(12,2),
   odl          DECIMAL(12,2),
   zmd          DECIMAL(12,2),
   zdl          DECIMAL(12,2),
   PRIMARY KEY(cpl)
);
prcuobrats;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctzosuce'.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $vyb_ume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vrkp=1*$kli_vrok-1;
$dat_poc=$kli_vrok."-01-01";
$ume_poc="01.".$kli_vrok;
$dat_pcc=$kli_vrkp."-12-31";
$ume_pcc="0";


//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,0,F$kli_vxcf"."_uctosnova.pmd,F$kli_vxcf"."_uctosnova.pmd,0,0,'poËiatoËn˝ stav',1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" 0,1,0,$ume_pcc,'$dat_pcc',0,F$kli_vxcf"."_uctosnova.uce,1,0,0,F$kli_vxcf"."_uctosnova.uce,".
"0,0,0,0,0,F$kli_vxcf"."_uctosnova.pda,0,F$kli_vxcf"."_uctosnova.pda,0,'poËiatoËn˝ stav',1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$psys=1;
 while ($psys <= 9 ) 
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
if( $typ == 'HTML' )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND ume <= $vyb_ume";
$dsql = mysql_query("$dsqlt");
     }
if( $typ != 'HTML' )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,SUM(F$kli_vxcf"."_$uctovanie.hod),SUM(F$kli_vxcf"."_$uctovanie.hod),".
"0,0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND ume <= $vyb_ume".
" GROUP BY ume,ucm,ucd ";

$dsql = mysql_query("$dsqlt");
     }
}

else
{
//tu budu podsystemy

if( $typ == 'HTML' )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,hod,".
"0,0,pop,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume <= $vyb_ume";
$dsql = mysql_query("$dsqlt");
}

if( $typ != 'HTML' )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,SUM(hod),SUM(hod),".
"0,0,pop,1,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume <= $vyb_ume".
" GROUP BY ume,ucm,ucd ";

$dsql = mysql_query("$dsqlt");
}

//exit;
}

$psys=$psys+1;
  }



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Obratov· predvaha</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
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
<td>EuroSecom  -  Obratov· predvaha PU
  <a href="#" onClick="window.open('../ucto/uobrat.php?copern=11&drupoh=1&page=1&typ=PDF&h_obdk=<?php echo $h_obdk;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='VytlaËiù vo form·te PDF' ></a>

 <a href="#" onClick="window.open('../ucto/uobrat.php?copern=11&drupoh=1&page=1&typ=HTML&h_obdk=<?php echo $h_obdk;?>', '_self' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 alt='PrepoËet po ˙prav·ch knihy' ></a>
</td>
<td align="right">
<?php
$prev_obdk=$h_obdk-1; $next_obdk=$h_obdk+1;
if( $prev_obdk == 0 ) { $prev_obdk=12; }
if( $next_obdk == 13 ) { $next_obdk=1; }
$coperp=$copern+1;
      if( $copern == 30 OR $copern == 20 OR $copern == 10 ) { ?>
<a href="#" onClick="window.open('../ucto/uobrat.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $prev_obdk;?>
&page=1&typ=HTML', '_self' )">
<img src='../obr/prev.png' width=10 height=10 border=0 alt='Obdobie <?php echo $prev_obdk.".".$kli_vrok; ?>' ></a>
<a href="#" onClick="window.open('../ucto/uobrat.php?copern=<?php echo $coperp;?>&drupoh=<?php echo $drupoh;?>&h_obdk=<?php echo $next_obdk;?>
&page=1&typ=HTML', '_self' )">
<img src='../obr/next.png' width=10 height=10 border=0 alt='Obdobie <?php echo $next_obdk.".".$kli_vrok; ?>' ></a>
<?php                                                       } ?>
<span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php
//vloz stranu dal
if( $typ == 'HTML' )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" psys,1,0,ume,dat,dok,ucd,1,ucm,ucm,ucd,rdp,ico,fak,str,zak,hod,0,hod,0,pop,pox,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ume <= $vyb_ume AND psys > 0 ";
" ";
$dsql = mysql_query("$dsqlt");
}
if( $typ != 'HTML' )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid"." SELECT".
" psys,1,0,ume,dat,dok,ucd,1,ucm,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),0,SUM(hod),0,pop,pox,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ume <= $vyb_ume AND psys > 0 ".
" GROUP BY ume,ucm,ucd ";
" ";
$dsql = mysql_query("$dsqlt");
}

//rozdel do omd,odl
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET pmd=mdt, pdl=dal WHERE cpl >= 0 AND psys = 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET omd=mdt, odl=dal WHERE cpl >= 0 AND psys > 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET bmd=mdt, bdl=dal WHERE cpl >= 0 AND psys > 0  AND ume = $vyb_ume ";
$dsql = mysql_query("$dsqlt");

//vypocitaj zmd,zdl
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zmd=pmd-pdl+omd-odl, zdl=0 WHERE cpl >= 0 ";
$dsql = mysql_query("$dsqlt");

//sumar za ucty
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" psys,1,0,ume,dat,0,uce,999,puc,ucm,ucd,rdp,1,0,0,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE cpl >= 0".
" GROUP BY uce".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vypocitaj zmd,zdl
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdl=-zmd, zmd=0 WHERE cpl >= 0 AND ur1 = 999 AND zmd < 0 ";
$dsql = mysql_query("$dsqlt");

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" psys,999,0,ume,dat,0,uce,1,puc,ucm,ucd,rdp,ico,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,999,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl)".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ur1 = 999".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//SU do fak, TR do str
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET fak=0, fak=LEFT(uce,3), str=0, str=LEFT(uce,1) WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

//sumar za SU 
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" psys,1,0,ume,dat,0,999999996,996,puc,ucm,ucd,rdp,SUM(ico),fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd-pdl),0,SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd-zdl),0".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ur1 = 999".
" GROUP BY fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//pociatok za SU ak je < 0 do dal
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET pdl=-pmd, pmd=0 WHERE uce=999999996 AND pmd < 0";
$dsql = mysql_query("$dsqlt");

//zostatok za SU ak je < 0 do dal
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdl=-zmd, zmd=0 WHERE uce=999999996 AND zmd < 0";
$dsql = mysql_query("$dsqlt");

//sumar za TR 
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" psys,1,0,ume,dat,2,999999997,997,puc,ucm,ucd,rdp,SUM(ico),999999997,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd-pdl),0,SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd-zdl),0".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ur1 = 996".
" GROUP BY str".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//pociatok za TR ak je < 0 do dal
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET pdl=-pmd, pmd=0 WHERE uce=999999997 AND pmd < 0";
$dsql = mysql_query("$dsqlt");

//zostatok za TR ak je < 0 do dal
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdl=-zmd, zmd=0 WHERE uce=999999997 AND zmd < 0";
$dsql = mysql_query("$dsqlt");

//sumy za SU aj ked len jeden ucet
if( $poliklinikase == 1 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET ico=ico+1 WHERE ur1 = 996 ";
$dsql = mysql_query("$dsqlt");

}

//vloz pre ocislovanie poloziek
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsx$kli_uzid"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE ( ur1 = 999 OR ( ur1 = 996 AND ico > 1 ) OR ( ur1 = 997 ) OR uro = 999 ) ".
" ORDER BY pox,str,fak,uce";
$dsql = mysql_query("$dsqlt");

//vloz do zostatku pre prenos
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctzosuce"." SELECT".
" psys,uro,0,ume,dat,dok,uce,ur1,puc,ucm,ucd,rdp,ico,fak,str,zak,hod,mdt,dal,zos,pop,pox,".
"pmd,pdl,bmd,bdl,omd,odl,zmd,zdl".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" WHERE ur1 = 999 ".
" ORDER BY uce";
$dsql = mysql_query("$dsqlt");

//zapis do statistickej TABLE p304 modul 1003 a 1004
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 20304 )
{
$modul = 1*$_REQUEST['modul'];

$rok304="";
if( $kli_vrok < 2016 ) $rok304="_2015";
if( $kli_vrok < 2014 ) $rok304="_2013";
if( $kli_vrok < 2013 ) $rok304="_2012";
?>
<script type="text/javascript">

window.open('../ucto/statistika_p304<?php echo $rok304; ?>.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky modul 1003 a 1004


//zapis do statistickej TABLE vts101 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 20201 )
{
$modul = 1*$_REQUEST['modul'];
?>
<script type="text/javascript">

window.open('../ucto/statistika_vts101.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky vts101

//zapis do statistickej TABLE zav101 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 30201 )
{
$modul = 1*$_REQUEST['modul'];
?>
<script type="text/javascript">

window.open('../ucto/statistika_zav101.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky zav101

//zapis do statistickej TABLE opu201 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 10201 )
{
$modul = 1*$_REQUEST['modul'];
?>
<script type="text/javascript">

window.open('../ucto/statistika_opu201.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky opu201

//zapis do statistickej TABLE ikap201 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 60201 )
{
$modul = 1*$_REQUEST['modul'];
?>
<script type="text/javascript">

window.open('../ucto/statistika_ikap201.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky ikap201

//zapis do statistickej TABLE vts201 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 50201 )
{
$modul = 1*$_REQUEST['modul'];
?>
<script type="text/javascript">

window.open('../ucto/statistika_vts201.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky vts201

//zapis do statistickej zostavy rocny r101
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../ucto/statistika_r101nacitaj.php?copern=1&drupoh=1&page=1&zobrat=1', '_self' )

</script>
<?php
exit;
}
//koniec zapis do statistickej zostavy rocny r101

//zapis do statistickej zostavy rocny r101
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 10102 )
{
?>
<script type="text/javascript">

window.open('../ucto/statistika_r101nacitaj.php?copern=1&drupoh=1&page=1&zobrat=11', '_self' )

</script>
<?php
exit;
}
//koniec zapis do statistickej zostavy rocny r101

//zapis do poznamky PO 2011
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 20101 )
{
?>
<script type="text/javascript">

window.open('../ucto/poznamky_po2011nacitaj.php?copern=1&drupoh=1&page=1&zobrat=1', '_self' )

</script>
<?php
exit;
}
//koniec zapis do poznamky PO 2011

//zapis do statistickej TABLE modul 512 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 512 )
{
$rokvts112="";
if( $kli_vrok < 2016 ) $rokvts112="_2015";
if( $kli_vrok < 2014 ) $rokvts112="_2013";
?>
<script type="text/javascript">

window.open('../ucto/statistika_vts112<?php echo $rokvts112; ?>.php?copern=1&drupoh=1&page=1&modul=512', '_self' )

</script>
<?php
exit;
}
//koniec statistiky modul 512

//zapis do statistickej TABLE modul 124 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 124 )
{
$rokopu112="";
if( $kli_vrok < 2016 ) $rokopu112="_2015";
if( $kli_vrok < 2014 ) $rokopu112="_2013";
?>
<script type="text/javascript">

window.open('../ucto/statistika_opu112<?php echo $rokopu112; ?>.php?copern=1&drupoh=1&page=1&modul=124', '_self' )

</script>
<?php
exit;
}
//koniec statistiky modul 512

//zapis do statistickej TABLE modul 112 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 1304 )
{
$r01a1=0; $r02a1=0; $r03a1=0; $r04a1=0; $r05a1=0; $r06a1=0; $r07a1=0; $r08a1=0; $r09a1=0; $r10a1=0; $r11a1=0; $r12a1=0; $r13a1=0;
$r01a2=0; $r02a2=0; $r03a2=0; $r04a2=0; $r05a2=0; $r06a2=0; $r07a2=0; $r08a2=0; $r09a2=0; $r10a2=0; $r11a2=0; $r12a2=0; $r13a2=0;
$r01a3=0; $r02a3=0; $r03a3=0; $r04a3=0; $r05a3=0; $r06a3=0; $r07a3=0; $r08a3=0; $r09a3=0; $r10a3=0; $r11a3=0; $r12a3=0; $r13a3=0;
$r01a4=0; $r02a4=0; $r03a4=0; $r04a4=0; $r05a4=0; $r06a4=0; $r07a4=0; $r08a4=0; $r09a4=0; $r10a4=0; $r11a4=0; $r12a4=0; $r13a4=0;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 041 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01a1=$r01a1+$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 042 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02a1=$r02a1+$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 641 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02a4=$r02a4+$polozka->odl; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod112r01a1='$r01a1', mod112r02a1='$r02a1', mod112r02a4='$r02a4', ".
" mod112r12a1=mod112r02a1, mod112r12a4=mod112r02a4,".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r04a1+mod112r05a1+mod112r06a1+mod112r07a1+mod112r08a1+mod112r09a1+mod112r10a1+mod112r11a1+mod112r12a1,".
" mod112r99a2=mod112r01a2+mod112r02a2+mod112r03a2+mod112r04a2+mod112r05a2+mod112r06a2+mod112r07a2+mod112r08a2+mod112r09a2+mod112r10a2+mod112r11a2+mod112r12a2,".
" mod112r99a3=mod112r01a3+mod112r02a3+mod112r03a3+mod112r04a3+mod112r05a3+mod112r06a3+mod112r07a3+mod112r08a3+mod112r09a3+mod112r10a3+mod112r11a3+mod112r12a3,".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r04a4+mod112r05a4+mod112r06a4+mod112r07a4+mod112r08a4+mod112r09a4+mod112r10a4+mod112r11a4+mod112r12a4".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
//exit;

$rok1304="";
if( $kli_vrok < 2016 ) $rok1304="_2015";
if( $kli_vrok < 2014 ) $rok1304="_2013";
if( $kli_vrok < 2012 ) $rok1304="_2011";
?>
<script type="text/javascript">

window.open('../ucto/statistika_p1304<?php echo $rok1304; ?>.php?copern=1&drupoh=1&page=1&modul=112', '_self' )

</script>
<?php
}
//koniec statistiky modul 112


//zapis do statistickej TABLE modul 545 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 1304545 )
{
$r01a1=0; $r02a1=0; $r03a1=0; $r04a1=0; $r05a1=0; $r06a1=0; $r07a1=0; $r08a1=0; $r09a1=0; $r10a1=0; $r11a1=0;
$r01a2=0; $r02a2=0; $r03a2=0; $r04a2=0; $r05a2=0; $r06a2=0; $r07a2=0; $r08a2=0; $r09a2=0; $r10a2=0; $r11a2=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 01 OR LEFT(uce,2) = 02 OR LEFT(uce,2) = 03 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01a2=$r01a2+$polozka->zmd-$polozka->zdl; $r01a1=$r01a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 07 OR LEFT(uce,2) = 08 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02a2=$r02a2+$polozka->zdl-$polozka->zmd; $r02a1=$r02a1+$polozka->pdl-$polozka->pmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 111 OR LEFT(uce,3) = 112 OR LEFT(uce,3) = 119 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03a2=$r03a2+$polozka->zmd-$polozka->zdl; $r03a1=$r03a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 121 OR LEFT(uce,3) = 122 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04a2=$r04a2+$polozka->zmd-$polozka->zdl; $r04a1=$r04a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 123 OR LEFT(uce,3) = 123 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05a2=$r05a2+$polozka->zmd-$polozka->zdl; $r05a1=$r05a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 131 OR LEFT(uce,3) = 132 OR LEFT(uce,3) = 139 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06a2=$r06a2+$polozka->zmd-$polozka->zdl; $r06a1=$r06a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 211 OR LEFT(uce,3) = 213 OR LEFT(uce,3) = 261 ".
" OR LEFT(uce,3) = 291 OR LEFT(uce,3) = 221  OR LEFT(uce,3) = 251  OR LEFT(uce,3) = 253  OR LEFT(uce,3) = 256  OR LEFT(uce,3) = 257 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07a2=$r07a2+$polozka->zmd-$polozka->zdl; $r07a1=$r07a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 31 OR LEFT(uce,2) = 35 OR LEFT(uce,3) = 335 ".
" OR ( LEFT(uce,2) = 37 AND LEFT(uce,3) != 379 )  OR LEFT(uce,2) = 34 OR LEFT(uce,3) = 336 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08a2=$r08a2+$polozka->zmd-$polozka->zdl; $r08a1=$r08a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 32 OR LEFT(uce,2) = 36 OR LEFT(uce,3) = 331 ".
" OR LEFT(uce,2) = 47 OR LEFT(uce,3) = 379 OR LEFT(uce,3) = 333 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r09a2=$r09a2+$polozka->zdl-$polozka->zmd; $r09a1=$r09a1+$polozka->pdl-$polozka->pmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 231 OR LEFT(uce,3) = 232 OR LEFT(uce,3) = 242 ".
" OR LEFT(uce,3) = 249 OR LEFT(uce,3) = 461 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r10a2=$r10a2+$polozka->zdl-$polozka->zmd; $r10a1=$r10a1+$polozka->pdl-$polozka->pmd; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod545r01a1='$r01a1', mod545r02a1='$r02a1', mod545r03a1='$r03a1', mod545r04a1='$r04a1', mod545r05a1='$r05a1', mod545r06a1='$r06a1', ".
" mod545r07a1='$r07a1', mod545r08a1='$r08a1', mod545r09a1='$r09a1', mod545r10a1='$r10a1',  ".
" mod545r01a2='$r01a2', mod545r02a2='$r02a2', mod545r03a2='$r03a2', mod545r04a2='$r04a2', mod545r05a2='$r05a2', mod545r06a2='$r06a2', ".
" mod545r07a2='$r07a2', mod545r08a2='$r08a2', mod545r09a2='$r09a2', mod545r10a2='$r10a2',  ".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1,".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  

//exit;

$rok1304="";
if( $kli_vrok < 2016 ) $rok1304="_2015";
if( $kli_vrok < 2014 ) $rok1304="_2013";
if( $kli_vrok < 2012 ) $rok1304="_2011";
?>
<script type="text/javascript">

window.open('../ucto/statistika_p1304<?php echo $rok1304; ?>.php?copern=101&drupoh=1&page=1&modul=545', '_self' )

</script>
<?php
}
//koniec statistiky modul 545

//zapis do statistickej TABLE modul 112 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 304 )
{
$r01a1=0; $r02a1=0; $r03a1=0; $r04a1=0; $r05a1=0; $r06a1=0; $r07a1=0; $r08a1=0; $r09a1=0; $r10a1=0; $r11a1=0; $r12a1=0; $r13a1=0;
$r01a2=0; $r02a2=0; $r03a2=0; $r04a2=0; $r05a2=0; $r06a2=0; $r07a2=0; $r08a2=0; $r09a2=0; $r10a2=0; $r11a2=0; $r12a2=0; $r13a2=0;
$r01a3=0; $r02a3=0; $r03a3=0; $r04a3=0; $r05a3=0; $r06a3=0; $r07a3=0; $r08a3=0; $r09a3=0; $r10a3=0; $r11a3=0; $r12a3=0; $r13a3=0;
$r01a4=0; $r02a4=0; $r03a4=0; $r04a4=0; $r05a4=0; $r06a4=0; $r07a4=0; $r08a4=0; $r09a4=0; $r10a4=0; $r11a4=0; $r12a4=0; $r13a4=0;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 041 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01a1=$r01a1+$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 042 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02a1=$r02a1+$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 641 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02a4=$r02a4+$polozka->odl; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod112r01a1='$r01a1', mod112r02a1='$r02a1', mod112r02a4='$r02a4', ".
" mod112r12a1=mod112r02a1, mod112r12a4=mod112r02a4,".
" mod112r99a1=mod112r01a1+mod112r02a1+mod112r03a1+mod112r04a1+mod112r05a1+mod112r06a1+mod112r07a1+mod112r08a1+mod112r09a1+mod112r10a1+mod112r11a1+mod112r12a1,".
" mod112r99a2=mod112r01a2+mod112r02a2+mod112r03a2+mod112r04a2+mod112r05a2+mod112r06a2+mod112r07a2+mod112r08a2+mod112r09a2+mod112r10a2+mod112r11a2+mod112r12a2,".
" mod112r99a3=mod112r01a3+mod112r02a3+mod112r03a3+mod112r04a3+mod112r05a3+mod112r06a3+mod112r07a3+mod112r08a3+mod112r09a3+mod112r10a3+mod112r11a3+mod112r12a3,".
" mod112r99a4=mod112r01a4+mod112r02a4+mod112r03a4+mod112r04a4+mod112r05a4+mod112r06a4+mod112r07a4+mod112r08a4+mod112r09a4+mod112r10a4+mod112r11a4+mod112r12a4".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
//exit;

$rok304="";
if( $kli_vrok < 2016 ) $rok304="_2015";
if( $kli_vrok < 2014 ) $rok304="_2013";
if( $kli_vrok < 2013 ) $rok304="_2012";
?>
<script type="text/javascript">

window.open('../ucto/statistika_p304<?php echo $rok304; ?>.php?copern=1&drupoh=1&page=1&modul=112', '_self' )

</script>
<?php
}
//koniec statistiky modul 112


//zapis do statistickej TABLE modul 146(545) a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 304545 )
{
$r01a1=0; $r02a1=0; $r03a1=0; $r04a1=0; $r05a1=0; $r06a1=0; $r07a1=0; $r08a1=0; $r09a1=0; $r10a1=0; $r11a1=0;
$r01a2=0; $r02a2=0; $r03a2=0; $r04a2=0; $r05a2=0; $r06a2=0; $r07a2=0; $r08a2=0; $r09a2=0; $r10a2=0; $r11a2=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 01 OR LEFT(uce,2) = 02 OR LEFT(uce,2) = 03 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01a2=$r01a2+$polozka->zmd-$polozka->zdl; $r01a1=$r01a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 07 OR LEFT(uce,2) = 08 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02a2=$r02a2+$polozka->zdl-$polozka->zmd; $r02a1=$r02a1+$polozka->pdl-$polozka->pmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 111 OR LEFT(uce,3) = 112 OR LEFT(uce,3) = 119 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03a2=$r03a2+$polozka->zmd-$polozka->zdl; $r03a1=$r03a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 121 OR LEFT(uce,3) = 122 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04a2=$r04a2+$polozka->zmd-$polozka->zdl; $r04a1=$r04a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 123 OR LEFT(uce,3) = 123 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05a2=$r05a2+$polozka->zmd-$polozka->zdl; $r05a1=$r05a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 131 OR LEFT(uce,3) = 132 OR LEFT(uce,3) = 139 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06a2=$r06a2+$polozka->zmd-$polozka->zdl; $r06a1=$r06a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 211 OR LEFT(uce,3) = 213 OR LEFT(uce,3) = 261 ".
" OR LEFT(uce,3) = 291 OR LEFT(uce,3) = 221  OR LEFT(uce,3) = 251  OR LEFT(uce,3) = 253  OR LEFT(uce,3) = 256  OR LEFT(uce,3) = 257 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07a2=$r07a2+$polozka->zmd-$polozka->zdl; $r07a1=$r07a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 211 OR LEFT(uce,3) = 213 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08a2=$r08a2+$polozka->zmd-$polozka->zdl; $r08a1=$r08a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 221 OR LEFT(uce,3) = 261 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r09a2=$r09a2+$polozka->zmd-$polozka->zdl; $r09a1=$r09a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 381 OR LEFT(uce,3) = 382 OR LEFT(uce,3) = 385 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r10a2=$r10a2+$polozka->zmd-$polozka->zdl; $r10a1=$r10a1+$polozka->pmd-$polozka->pdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 383 OR LEFT(uce,3) = 384 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r11a2=$r11a2+$polozka->zdl-$polozka->zmd; $r11a1=$r11a1+$polozka->pdl-$polozka->pmd; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod545r01a1='$r01a1', mod545r02a1='$r02a1', mod545r03a1='$r03a1', mod545r04a1='$r04a1', mod545r05a1='$r05a1', mod545r06a1='$r06a1', ".
" mod545r07a1='$r07a1', mod545r08a1='$r08a1', mod545r09a1='$r09a1', mod545r10a1='$r10a1', mod545r11a1='$r11a1',  ".
" mod545r01a2='$r01a2', mod545r02a2='$r02a2', mod545r03a2='$r03a2', mod545r04a2='$r04a2', mod545r05a2='$r05a2', mod545r06a2='$r06a2', ".
" mod545r07a2='$r07a2', mod545r08a2='$r08a2', mod545r09a2='$r09a2', mod545r10a2='$r10a2', mod545r11a2='$r11a2',  ".
" mod545r99a1=mod545r01a1+mod545r02a1+mod545r03a1+mod545r04a1+mod545r05a1+mod545r06a1+mod545r07a1+mod545r08a1+mod545r09a1+mod545r10a1+mod545r11a1,".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  

//exit;

$rok304="";
if( $kli_vrok < 2016 ) $rok304="_2015";
if( $kli_vrok < 2014 ) $rok304="_2013";
if( $kli_vrok < 2013 ) $rok304="_2012";
?>
<script type="text/javascript">

window.open('../ucto/statistika_p304<?php echo $rok304; ?>.php?copern=101&drupoh=1&page=1&modul=545', '_self' )

</script>
<?php
}
//koniec statistiky modul 545

if( $typ != 'PDF' )
{
$sqltt = "SELECT ".
" F$kli_vxcf"."_uctosnova.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,fak,ico,str ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 996 OR ur1 = 997 OR uro = 999 ) ".
" ORDER BY cpl";
//echo $sqltt;
}

if( $typ == 'PDF' )
{
$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,fak,ico,str ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ( ur1 = 999 OR ur1 = 996 OR ur1 = 997 OR uro = 999 ) ".
" ORDER BY cpl";
//echo $sqltt;
}

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

//sumare napocet
$hod = 0.00;

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$k=0; //zaciatok dennika nedaj prevedene
$par=0; //parne nedam biele ale sede
  while ($i <= $pol )
  {

if ( $j == 0 )
      {

if( $typ == 'PDF' )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

$pdf->Cell(110,5,"Obratov· predvaha za $vyb_ume","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);
$pdf->Cell(19,4,"⁄Ëet","1",0,"R");
$pdf->Cell(34,4,"PoËiatoËn˝Stav M·Daù","1",0,"R");$pdf->Cell(34,4,"PoËiatoËn˝Stav Dal","1",0,"R");
$pdf->Cell(30,4,"Beûn˝ mesiac M·Daù","1",0,"R");$pdf->Cell(30,4,"Beûn˝ mesiac Dal","1",0,"R");
$pdf->Cell(35,4,"Cel˝ rok M·Daù","1",0,"R");$pdf->Cell(35,4,"Cel˝ rok Dal","1",0,"R");
$pdf->Cell(30,4,"Zostatok M·Daù","1",0,"R");$pdf->Cell(30,4,"Zostatok Dal","1",1,"R");

}


if( $typ == 'HTML' )
{
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="5"><?php echo "Obratov· predvaha za $vyb_ume"; ?></td>
<td class="bmenu" colspan="4" align="right"><?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?></td>
</tr>

<tr>

<td class="bmenu" width="6%">⁄Ëet</td>
<td class="hvstup_zlte" width="12%" align="right">PoËiatoËn˝Stav M·Daù</td>
<td class="hvstup_zlte" width="12%" align="right">PoËiatoËn˝Stav Dal</td>
<td class="bmenu" width="11%" align="right">Beûn˝ mesiac M·Daù</td>
<td class="bmenu" width="11%" align="right">Beûn˝ mesiac Dal</td>
<td class="hvstup_zlte" width="12%" align="right">Cel˝ rok M·Daù</td>
<td class="hvstup_zlte" width="12%" align="right">Cel˝ rok Dal</td>
<td class="bmenu" width="12%" align="right">Zostatok M·Daù</td>
<td class="bmenu" width="12%" align="right">Zostatok Dal</td>
</tr>

<?php
}

$str_hod = 0.00;

      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

//ak je nulova polozka daj medzeru

$h_hod=$polozka->hod;
if( $polozka->hod == 0 ) $h_hod="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);


if( $typ == 'PDF' )
{
if( $polozka->ur1 == 999 )
   {
//tlac sumare za ucet analyticky
$pdf->Cell(19,4,"$polozka->uce","0",0,"L");
$pdf->Cell(34,4,"$polozka->pmd","0",0,"R");$pdf->Cell(34,4,"$polozka->pdl","0",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","0",0,"R");$pdf->Cell(30,4,"$polozka->bdl","0",0,"R");
$pdf->Cell(35,4,"$polozka->omd","0",0,"R");$pdf->Cell(35,4,"$polozka->odl","0",0,"R");
$pdf->Cell(30,4,"$polozka->zmd","0",0,"R");$pdf->Cell(30,4,"$polozka->zdl","0",1,"R");
   }

if( $polozka->ur1 == 996 AND $polozka->ico > 1 )
   {
//tlac sumare za ucet synteticky
$pdf->Cell(19,4,"SU$polozka->fak","T",0,"R");
$pdf->Cell(34,4,"$polozka->pmd","T",0,"R");$pdf->Cell(34,4,"$polozka->pdl","T",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","T",0,"R");$pdf->Cell(30,4,"$polozka->bdl","T",0,"R");
$pdf->Cell(35,4,"$polozka->omd","T",0,"R");$pdf->Cell(35,4,"$polozka->odl","T",0,"R");
$pdf->Cell(30,4,"$polozka->zmd","T",0,"R");$pdf->Cell(30,4,"$polozka->zdl","T",1,"R");
   }

if( $polozka->ur1 == 997  )
   {
//tlac sumare za triedu
$pdf->Cell(19,4,"Trieda $polozka->str","TB",0,"R");
$pdf->Cell(34,4,"$polozka->pmd","TB",0,"R");$pdf->Cell(34,4,"$polozka->pdl","TB",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","TB",0,"R");$pdf->Cell(30,4,"$polozka->bdl","TB",0,"R");
$pdf->Cell(35,4,"$polozka->omd","TB",0,"R");$pdf->Cell(35,4,"$polozka->odl","TB",0,"R");
$pdf->Cell(30,4,"$polozka->zmd","TB",0,"R");$pdf->Cell(30,4,"$polozka->zdl","TB",1,"R");
   }

if( $polozka->uro == 999 )
   {
//tlac sumare za vsetko
$pdf->Cell(277,2," ","T",1,"R");
$pdf->Cell(19,4,"Celkom","0",0,"R");
$pdf->Cell(34,4,"$polozka->pmd","0",0,"R");$pdf->Cell(34,4,"$polozka->pdl","0",0,"R");
$pdf->Cell(30,4,"$polozka->bmd","0",0,"R");$pdf->Cell(30,4,"$polozka->bdl","0",0,"R");
$pdf->Cell(35,4,"$polozka->omd","0",0,"R");$pdf->Cell(35,4,"$polozka->odl","0",0,"R");
$pdf->Cell(30,4,"$polozka->zmd","0",0,"R");$pdf->Cell(30,4,"$polozka->zdl","0",1,"R");
   }
}

if( $typ == 'HTML' )
{
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }

if( $polozka->ur1 == 999 )
   {
?>
<tr>
<td class="<?php echo $hvstup; ?>">
<a href="#" title='<?php echo $polozka->nuc; ?>'  onClick="window.open('pokl_kniha.php?copern=40&drupoh=55&page=1&typ=HTML&cislo_uce=<?php echo $polozka->uce;?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<?php echo $polozka->uce; ?></a>
</td>

<td class="hvstup_zlte" align="right"><?php echo $polozka->pmd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->pdl; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->bmd; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->bdl; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->omd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->odl; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->zmd; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->zdl; ?></td>

</tr>
<?php
//koniec ur1=999
   }

if( $polozka->ur1 == 996 AND $polozka->ico > 1 )
   {
?>
<tr>
<td class="<?php echo $hvstup; ?>" align="right">
<a href="#" onClick="window.open('pokl_kniha.php?copern=40&drupoh=56&page=1&typ=HTML&cislo_uce=<?php echo $polozka->fak;?>', '_blank', 
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
SU<?php echo $polozka->fak; ?></a>
</td>

<td class="hvstup_zlte" align="right"><?php echo $polozka->pmd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->pdl; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->bmd; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->bdl; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->omd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->odl; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->zmd; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->zdl; ?></td>

</tr>
<?php
//koniec ur1=996
   }

if( $polozka->ur1 == 997  )
   {
?>
<tr>
<td class="hvstup_zlte" align="right">
Trieda <?php echo $polozka->str; ?>
</td>

<td class="hvstup_zlte" align="right"><?php echo $polozka->pmd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->pdl; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->bmd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->bdl; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->omd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->odl; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->zmd; ?></td>
<td class="hvstup_zlte" align="right"><?php echo $polozka->zdl; ?></td>

</tr>
<?php
//koniec ur1=997
   }

if( $polozka->uro == 999 )
   {
?>
<tr>
<td class="bmenu">CELKOM</td>

<td class="hvstup_tzlte" align="right"><?php echo $polozka->pmd; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->pdl; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->bmd; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->bdl; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->omd; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->odl; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->zmd; ?></td>
<td class="hvstup_tzlte" align="right"><?php echo $polozka->zdl; ?></td>

</tr>

</table>
<?php
//koniec uro=999
   }

//koniec html
}


}
$i = $i + 1;
$j = $j + 1;

if( $par == 0 )
{
$par=1;
}
else
{
$par=0;
}

//koniec stranky
if( $j == 40 )
      {
$strana=$strana+1;
$j=0;
      }
//koniec bloku na koniec stranky


  }
//koniec polozky


if( $typ == 'PDF' )
{

//tlac textu na zostavy
$zostxx = include("../cis/zostxx.php");
//koniec tlac textu na zostavy

$pdf->Output("$outfilex");
?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
}


if( $typ == 'HTML' )
{
?>

<?php
}

?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsx'.$kli_uzid;
//if( $cstat == 0 )  { $vysledok = mysql_query("$sqlt"); }
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctzosuce';
if( $kli_vmes != 12 AND $hosprok == 0 ) $vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
