<HTML>
<?php

do
{
$sys = 'ANA';
$urov = 2900;
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$vsetko = 1*$_REQUEST['vsetko'];

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

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";



?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export pre DÚ do CSV</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
</script>
</HEAD>
<BODY class="white" id="white" onload="" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Export pre DÚ do CSV

<a href="#" onClick="window.open('../ucto/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT', '_self' )">
<img src='../obr/export.png' width=20 height=15 border=0 title='Prejs do mesaèných úètovných zostáv' ></a>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zakladna ponuka
if( $copern == 1 )
{
?>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=50&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV - Spracujte najprv v MAJETKU Úètovné odpisy za 12.<?php echo $kli_vrok; ?> a Daòové odpisy za <?php echo $kli_vrok; ?>' ></a>
<td class="bmenu" width="98%">
Export Evidencia dlhodobého hmotného a nehmotného majetku do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=40&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV' ></a>
<td class="bmenu" width="98%">
Export Evidencia skladových zásob do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=60&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV - Vytvorte najprv Úètovný dennik v úètovníctve v Mesaèných zostavách' ></a>
<td class="bmenu" width="98%">
Export Úètovný dennik do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=75&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV - Vytvorte najprv OBRATOVÚ PREDVAHU v úètovníctve v Mesaèných zostavách' ></a>
<td class="bmenu" width="98%">
Export Obratová predvaha do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=70&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV - Vytvorte najprv HL.KNIHA sumárna za syntetické aj analytické úèty s názvom úètu' ></a>
<td class="bmenu" width="98%">
Export Hlavná kniha sumárna do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('hlkniha_csv.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV celý rok <?php echo $kli_vrok; ?>, nemusíte pred tým vytvára žiadnu zostavu, triedenie dátum, doklad' ></a>
<td class="bmenu" width="96%">
Export Hlavnej knihy položkovej do CSV súboru
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('hlkniha_csv.php?copern=10&drupoh=1&page=1&len5xx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV celý rok <?php echo $kli_vrok; ?>, nemusíte pred tým vytvára žiadnu zostavu, len úèty 5xx, triedenie úèet máda, dátum, doklad' ></a>

</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('knihafaktur_csv.php?copern=10&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV celý rok <?php echo $kli_vrok; ?>, nemusíte pred tým vytvára žiadnu zostavu' ></a>
<td class="bmenu" width="98%">
Export Knihy faktúr do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=80&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV - Vytvorte najprv Peòažný denník druh 1 v JÚ' ></a>
<td class="bmenu" width="98%">
Export Peòažného denníka JÚ do CSV súboru
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('danovy_csv.php?copern=90&drupoh=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Vytvori vo formáte CSV - Vytvorte najprv Mesaèný preh¾ad príjmov a výdavkov aj s názvom v JÚ' ></a>
<td class="bmenu" width="98%">
Export Mesaèného preh¾adu príjmov a výdavkov zapoèítate¾ných do daòového základu JÚ do CSV súboru
</table>

<?php
}
//koniec zakladnej ponuky
?>



<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU evidencia dlhodobeho hmotneho a nehmotneho majetku
if( $copern == 50 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="dlhodoby_majetok";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_majmaj".
" WHERE inv >= 0 ";
" ORDER BY inv ";
//echo $sqltt;


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dob_sk=SkDatum($hlavicka->dob);


if( $i == 0 )
     {
  $text = "inv.c".";"."nazov".";"."uct.obst.cena".";"."uct.opravky".";"."uct.zos.cena".";"."dat.zar.".";"."uct.r.odp".";"."uct.sposob odp. 1=rovn.,2=zrych.".";"."uct.odp.skupina"
.";"."dan.obst.cena".";"."dan.opravky".";"."dan.zos.cena".";"."dan.r.odp".";"."dan.sposob odp. 1=rovn.,2=zrych.".";"."dan.odp.skupina"
."\r\n"; 

  fwrite($soubor, $text);

     }

$cen=$hlavicka->cen; $ecen=str_replace(".",",",$cen); 
$ops=$hlavicka->ops; $eops=str_replace(".",",",$ops);
$zos=$hlavicka->zos; $ezos=str_replace(".",",",$zos);
$roc=$hlavicka->ros; $eroc=str_replace(".",",",$roc);

$ced=$hlavicka->cen_dan; $eced=str_replace(".",",",$ced); 
$opd=$hlavicka->ops_dan+$hlavicka->hd5; $eopd=str_replace(".",",",$opd);
$zod=$hlavicka->zos_dan-$hlavicka->hd5; $ezod=str_replace(".",",",$zod);
$rod=$hlavicka->hd5; $erod=str_replace(".",",",$rod);


  $text = $hlavicka->inv.";".$hlavicka->naz.";".$ecen.";".$eops.";".$ezos.";".$dob_sk.";".$eroc.";".$hlavicka->spo.";".$hlavicka->sku
.";".$eced.";".$eopd.";".$ezod.";".$erod.";".$hlavicka->spo_dan.";".$hlavicka->sku_dan
."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU evidencia dlhodobeho hmotneho a nehmotneho majetku

?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU evidencia skladovych zasob
if( $copern == 40 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="skladove_zasoby";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_sklpri".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklpri.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE F$kli_vxcf"."_sklpri.cis > 0 ";
" ORDER BY dok,F$kli_vxcf"."_sklpri.cis ";
//echo $sqltt;


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);


if( $i == 0 )
     {
  $text = "datum".";"."druh".";"."c.dokladu".";"."nazov".";"."cena".";"."mnozstvo"."\r\n"; 

  fwrite($soubor, $text);

     }

$cen=$hlavicka->cen; $ecen=str_replace(".",",",$cen); 
$mno=$hlavicka->mno; $emno=str_replace(".",",",$mno);


  $text = $dat_sk.";"."PRIJEM".";".$hlavicka->dok.";".$hlavicka->natBD.";".$ecen.";".$emno."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }

$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_sklvyd".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_sklvyd.cis=F$kli_vxcf"."_sklcis.cis".
" WHERE F$kli_vxcf"."_sklvyd.cis > 0 ";
" ORDER BY dok,F$kli_vxcf"."_sklvyd.cis ";
//echo $sqltt;


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);


$cen=$hlavicka->cen; $ecen=str_replace(".",",",$cen); 
$mno=$hlavicka->mno; $emno=str_replace(".",",",$mno);


  $text = $dat_sk.";"."VYDAJ".";".$hlavicka->dok.";".$hlavicka->natBD.";".$ecen.";".$emno."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }


fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU evidencia skladovych zasob
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU dennik
if( $copern == 60 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="dennik";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcudenniksx$kli_uzid WHERE cpl > 0 AND uro = 1 ORDER BY dat,dok ";
//echo $sqltt;


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);


if( $i == 0 )
     {
  $text = "ume".";"."datum".";"."c.dokladu".";"."ucm".";"."ucd".";"."ico".";"."fak".";"."hodnota".";"."popis"."\r\n"; 

  fwrite($soubor, $text);

     }

$cen=$hlavicka->hod; $ecen=str_replace(".",",",$cen); 


  $text = $hlavicka->ume.";".$dat_sk.";".$hlavicka->dok.";".$hlavicka->ucm.";".$hlavicka->ucd.";";
  $text = $text.$hlavicka->ico.";".$hlavicka->fak.";".$ecen.";".$hlavicka->pop."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }




fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU dennik
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU  hl.kniha sumarna Au a SU aj s nazvom
if( $copern == 70 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="hlavna_kniha_sumarna";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prchlknihasxx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".rdp=F$kli_vxcf"."_uctdrdp.rdp".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prchlknihasxx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE cpl > 0 AND uro = 770 ".
" ORDER BY suc,uro,F$kli_vxcf"."_prchlknihasxx$kli_uzid.uce";


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);

if( $polozka->uro == 770 AND $nazvy == 1 )
   {

$pdf->Cell(30,5,"$polozka->uce $polozka->nuc","0",1,"L");
$pdf->Cell(30,5," ","0",0,"L");$pdf->Cell(35,5,"$polozka->pmdt","0",0,"R");$pdf->Cell(35,5,"$polozka->pdal","0",0,"R"); 
$pdf->Cell(35,5,"$polozka->omdt","0",0,"R");$pdf->Cell(35,5,"$polozka->odal","0",0,"R");$pdf->Cell(35,5,"$srozdiel","0",0,"R");
$pdf->Cell(35,5,"$polozka->zmdt","0",0,"R");$pdf->Cell(35,5,"$polozka->zdal","0",1,"R");
$j=$j+1;
   }


if( $i == 0 )
     {
  $text = "uce".";"."nazov".";"."PSmadat".";"."PSdal".";"."POHmadat".";"."POHdal".";"."ZOSmadat".";"."ZOSdal"."\r\n"; 

  fwrite($soubor, $text);

     }

$cen=$hlavicka->hod; $ecen=str_replace(".",",",$cen); 


  $text = $hlavicka->uce.";".$hlavicka->nuc.";".$hlavicka->pmdt.";".$hlavicka->pdal.";".$hlavicka->omdt.";";
  $text = $text.$hlavicka->odal.";".$hlavicka->zmdt.";".$hlavicka->zdal."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }




fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU hl.kniha sumarna
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU obratovka
if( $copern == 75 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="obratova_predvaha";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT ".
" F$kli_vxcf"."_prcuobratsx$kli_uzid.uce, F$kli_vxcf"."_uctosnova.nuc, F$kli_vxcf"."_prcuobratsx$kli_uzid.pmd, pdl,".
" bmd,bdl,omd,odl,zmd,zdl,ur1,uro,fak,ico,str ".
" FROM F$kli_vxcf"."_prcuobratsx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcuobratsx$kli_uzid".".uce=F$kli_vxcf"."_uctosnova.uce".
" WHERE ur1 = 999  ".
" ORDER BY cpl";


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);


if( $i == 0 )
     {
  $text = "uce".";"."nazov".";"."PSmadat".";"."PSdal".";"."MESmadat".";"."MESdal".";"."ROKmadat".";"."ROKdal".";"."ZOSmadat".";"."ZOSdal"."\r\n"; 

  fwrite($soubor, $text);

     }


$pmdt=$hlavicka->pmd; $pmdt=str_replace(".",",",$pmdt); 
$pdal=$hlavicka->pdl; $pdal=str_replace(".",",",$pdal); 
$bmdt=$hlavicka->bmd; $bmdt=str_replace(".",",",$bmdt); 
$bdal=$hlavicka->bdl; $bdal=str_replace(".",",",$bdal);
$omdt=$hlavicka->omd; $omdt=str_replace(".",",",$omdt); 
$odal=$hlavicka->odl; $odal=str_replace(".",",",$odal);
$zmdt=$hlavicka->zmd; $zmdt=str_replace(".",",",$zmdt); 
$zdal=$hlavicka->zdl; $zdal=str_replace(".",",",$zdal);

  $text = $hlavicka->uce.";".$hlavicka->nuc.";".$pmdt.";".$pdal.";".$bmdt.";".$bdal.";";
  $text = $text.$omdt.";".$odal.";".$zmdt.";".$zdal."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }




fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU obratovka
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU  penazny dennik copern=80
if( $copern == 80 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="penazny_dennik_ju";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcpendensx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prcpendensx$kli_uzid".".poh=F$kli_vxcf"."_uctosnova.ucc".
" WHERE uro = 1 "."ORDER BY cpl";
//echo $sqltt;


$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$datsk=SkDatum($hlavicka->dat);




if( $i == 0 )
     {
  $text = "dok".";"."datum".";"."pohyb".";"."nazov pohybu".";"."hodnota".";"."ico".";"."popis".";"; 
  $text = $text."c.pokladnice".";"."hot.prijem".";"."hot.vydavok".";"."c.banky".";"."ban.prijem".";"."ban.vydavok"."\r\n"; 

  fwrite($soubor, $text);

     }

$hod=$hlavicka->hod; $ehod=str_replace(".",",",$hod); 
$hotp=$hlavicka->hotp; $pokp=str_replace(".",",",$hotp); 
$hotv=$hlavicka->hotv; $pokv=str_replace(".",",",$hotv); 
$ucbp=$hlavicka->ucbp; $banp=str_replace(".",",",$ucbp); 
$ucbv=$hlavicka->ucbv; $banv=str_replace(".",",",$ucbv); 

  $text = $hlavicka->dok.";".$datsk.";".$hlavicka->poh.";".$hlavicka->nuc.";".$ehod.";".$hlavicka->ico.";".$hlavicka->pop.";";
  $text = $text.$hlavicka->pokc.";".$pokp.";".$pokv.";".$hlavicka->ucbc.";".$banp.";".$banv."\r\n"; 

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }




fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU penazny dennik copern=80
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU mesacne prijmy avydavky copern=90
if( $copern == 90 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="mesprijmyvydavky_ju";


if (File_Exists ("../tmp/$nazsub.csv")) { $soubor = unlink("../tmp/$nazsub.csv"); }

$soubor = fopen("../tmp/$nazsub.csv", "a+");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prctopman$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_prctopman$kli_uzid".".rrd=F$kli_vxcf"."_uctosnova.uce".
" WHERE prx >= 0 ORDER BY prx,rrd ";

//echo $sqltt;
$sql = mysql_query("$sqltt");
if($sql)                                                      {
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$datsk=SkDatum($hlavicka->dat);



$xjan=$hlavicka->jan; $jan=str_replace(".",",",$xjan); if( $xjan == 0 ) $xjan="";
$xfeb=$hlavicka->feb; $feb=str_replace(".",",",$xfeb); if( $xfeb == 0 ) $xfeb="";
$xmar=$hlavicka->mar; $mar=str_replace(".",",",$xmar); if( $xmar == 0 ) $xmar="";
$xapr=$hlavicka->apr; $apr=str_replace(".",",",$xapr); if( $xapr == 0 ) $xapr="";
$xmaj=$hlavicka->maj; $maj=str_replace(".",",",$xmaj); if( $xmaj == 0 ) $xmaj="";
$xjun=$hlavicka->jun; $jun=str_replace(".",",",$xjun); if( $xjun == 0 ) $xjun="";
$xjul=$hlavicka->jul; $jul=str_replace(".",",",$xjul); if( $xjul == 0 ) $xjul="";
$xaug=$hlavicka->aug; $aug=str_replace(".",",",$xaug); if( $xaug == 0 ) $xaug="";
$xsep=$hlavicka->sep; $sep=str_replace(".",",",$xsep); if( $xsep == 0 ) $xsep="";
$xokt=$hlavicka->okt; $okt=str_replace(".",",",$xokt); if( $xokt == 0 ) $xokt="";
$xnov=$hlavicka->nov; $nov=str_replace(".",",",$xnov); if( $xnov == 0 ) $xnov="";
$xder=$hlavicka->der; $der=str_replace(".",",",$xder); if( $xder == 0 ) $xder="";
$xrok=$hlavicka->rok; $rok=str_replace(".",",",$xrok); if( $xrok == 0 ) $xrok="";

if( $i == 0 )
     {
  $text = "pohyb".";"."nazov pohybu".";"."januar".";"."februar".";"."marec".";"."april".";"."maj"; 
  $text = $text.";"."jun".";"."jul".";"."august".";"."september".";"."oktober"; 
  $text = $text.";"."november".";"."december".";"."spolu"."\r\n"; 

  fwrite($soubor, $text);

     }

if( $hlavicka->prx == 1 OR $hlavicka->prx == 11 )  {  $text = $hlavicka->rrd.";".$hlavicka->nuc.";"; }
if( $hlavicka->prx == 9 )  {  $text = "V".";"."Vydavky".";"; }
if( $hlavicka->prx == 19 ) {  $text = "P".";"."Prijmy".";"; }
if( $hlavicka->prx == 20 ) {  $text = "Z".";"."Zisk".";"; }

  $text = $text.$xjan.";".$xfeb.";"."$xmar".";"."$xapr".";"."$xmaj"; 
  $text = $text.";"."$xjun".";"."$xjul".";"."$xaug".";"."$xsep".";"."$xokt"; 
  $text = $text.";"."$xnov".";"."$xder".";"."$xrok"."\r\n";  

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }




fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.csv">../tmp/<?php echo $nazsub; ?>.csv</a>


<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//koniec ak existuje subor
                                                              }
}
///////////////////////////////////////////////////KONIEC SUBORU mesacne prijmy avydavky copern=90
?>

<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
