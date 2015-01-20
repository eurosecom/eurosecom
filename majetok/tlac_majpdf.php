<HTML>
<?php

do
{
$sys = 'HIM';
$urov = 1000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$h_zos = $_REQUEST['h_zos'];
$h_dru = 1*$_REQUEST['h_dru'];
$h_vyber = 1*$_REQUEST['h_vyber'];
$h_vyrad = 1*$_REQUEST['h_vyrad'];

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

if( $typ == 'PDF' )
{
if (File_Exists ("../tmp/tlacmaj.$kli_uzid.pdf")) { $soubor = unlink("../tmp/tlacmaj.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
}



$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$subormaj="majmaj";
$podmvyrad="";
if( $h_dru == 2 ) $subormaj="majdim";
if( $h_vyrad == 1 ) { $subormaj="majpoh"; $podmvyrad=" AND poh = 3 "; }
if( $h_dru == 2 AND $h_vyrad == 1 ) { $subormaj="majpohdim"; $podmvyrad=" AND poh = 3 "; }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlaè z údajov o majetku</title>
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
<?php $copert=$copern+2; ?>
  <a href="#" onClick="window.open('../majetok/tlac_majpdf.php?h_zos=<?php echo $h_zos; ?>&h_por=<?php echo $h_por; ?>&copern=30&drupoh=1&page=1&typ=PDF' ,'_self' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 alt='Vytlaèi vo formáte PDF' ></a>
</td>
<td align="right">
<span class="login"><?php echo "UME $vyb_ume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php
$podmienka="";
$podmienkaxy="";
$triedenie="";
$popis="";
$polozky="";
$polozkysum="";

//urob popis,tlac poloziek a podmienku a triedenie
$sqltt = "SELECT * FROM F$kli_vxcf"."_majzos_maj ".
" LEFT JOIN majmajpol".
" ON pol=xpol".
" WHERE czs=$h_zos ORDER BY por ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;

  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);
$nazov=$polozka->nzs;

//text pred
$ttp=$polozka->ttp;
//text za
$ttz=$polozka->ttz;

//popis
$xdlz=2*$polozka->xdlz;
$popis=$popis."\$pdf->Cell(".$xdlz.",5,\"".$polozka->pop."\",\"1\",0,\"".$polozka->xzar."\");";

//polozky
$normal=1;
if( $polozka->xpol == 'dob' OR $polozka->xpol == 'zar' ) { $normal=0; }
if( $polozka->xpol == 'inv' ) { $normal=0; }

if( $normal == 1 )
     {
$polozky=$polozky."\$pdf->Cell(".$xdlz.",5,\"\$polozka->".$polozka->pol."\",\"B\",0,\"".$polozka->xzar."\");";
$polozkysum=$polozkysum."\$pdf->Cell(".$xdlz.",5,\"\$".$polozka->pol."\",\"B\",0,\"".$polozka->xzar."\");";
     }

if( $polozka->xpol == 'dob' )
     {
$polozky=$polozky."\$dob_sk=SkDatum(\$polozka->dob);\$pdf->Cell(".$xdlz.",5,\"\$dob_sk \",\"B\",0,\"".$polozka->xzar."\");";
$polozkysum=$polozkysum."\$pdf->Cell(".$xdlz.",5,\"  \",\"B\",0,\"".$polozka->xzar."\");";
     }
if( $polozka->xpol == 'zar' )
     {
$polozky=$polozky."\$zar_sk=SkDatum(\$polozka->zar);if( \$zar_sk == \"00.00.0000\" ) \$zar_sk=\"\";\$pdf->Cell(".$xdlz.",5,\"\$zar_sk \",\"B\",0,\"".$polozka->xzar."\");";
$polozkysum=$polozkysum."\$pdf->Cell(".$xdlz.",5,\"  \",\"B\",0,\"".$polozka->xzar."\");";
     }

if( $polozka->xpol == 'inv' )
     {
$odkaz="../majetok/vstm_u.php?copern=8&drupoh=1&page=1&cislo_cpl="."\$polozka->cpl"."&h_cpl="."\$polozka->cpl"."&page=1";

$polozky=$polozky."\$pdf->Cell(".$xdlz.",5,\"\$polozka->inv\",\"B\",0,\"".$polozka->xzar."\",0,\$odkaz);";
$polozkysum=$polozkysum."\$pdf->Cell(".$xdlz.",5,\"  \",\"B\",0,\"".$polozka->xzar."\");";
     }


//triedenie od prveho po posledne
$normtrd=1;

if( $polozka->xpol == 'adk' ) { $normtrd=0; }

if ( $normtrd == 1 AND $polozka->trd == 1 ) { $triedenie=$triedenie.$polozka->pol.","; }

//podmienka precitaj len jednu poslednu
$normpod=1;
if( $normpod == 1 AND $polozka->pod != '' ) { $podmienkaxy=$polozka->pod; $podpol=$polozka->pol; }


}
$i = $i + 1;
  }
$popis="<?php ".$popis."\$pdf->Cell(0,5,\" \",\"1\",1,\"L\");"." ?>";
$polozky="<?php ".$polozky."\$pdf->Cell(0,5,\" \",\"B\",1,\"L\");"." ?>";
$polozkysum="<?php ".$polozkysum."\$pdf->Cell(0,5,\" \",\"B\",1,\"L\");"." ?>";
$triedenie=$triedenie."inv";


//podmienka posledna nacitana v while
$pole = explode(",", $podmienkaxy);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
if( $kli_fmax0 == '' ) $kli_fmax0=$kli_fmin0;

//if( $polozka->xpol == 'dob' OR $polozka->xpol == 'zar') { $kli_fmin0="'".SqlDatum($kli_fmin0)."'"; $kli_fmax0="'".SqlDatum($kli_fmax0)."'"; }
if( $podpol == 'dob' OR $podpol == 'zar') { $kli_fmin0="'".SqlDatum($kli_fmin0)."'"; $kli_fmax0="'".SqlDatum($kli_fmax0)."'"; }

$akefirmy = "( $podpol >= $kli_fmin0 AND $podpol <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
if( $kli_fmax1 == '' ) $kli_fmax1=$kli_fmin1;
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol >= $kli_fmin1 AND $podpol <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
if( $kli_fmax2 == '' ) $kli_fmax2=$kli_fmin2;
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol >= $kli_fmin2 AND $podpol <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
if( $kli_fmax3 == '' ) $kli_fmax3=$kli_fmin3;
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol >= $kli_fmin3 AND $podpol <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
if( $kli_fmax4 == '' ) $kli_fmax4=$kli_fmin4;
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol >= $kli_fmin4 AND $podpol <= $kli_fmax4 )";

$podmnaz=0;
if( $podpol == 'naz' ) 
{ 
$podmnaz=1;
$akefirmy = "( naz LIKE '%".$pole[0]."%' )";
if( StrLen($pole[1]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[1]."%' ) "; }
if( StrLen($pole[2]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[2]."%' ) "; }
if( StrLen($pole[3]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[3]."%' ) "; }
if( StrLen($pole[4]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[4]."%' ) "; }
$akefirmy=" ( ".$akefirmy." ) ";

$akefirmynaz=$akefirmy;
}
if( $podpol == 'vyc' ) 
{ 
$podmnaz=1;
$akefirmy = "( vyc LIKE '%".$pole[0]."%' )";
$akefirmynaz = "( vyc LIKE '%".$pole[0]."%' )";
}
//echo $akefirmy;
//exit;

if( $podmienkaxy != '' ) { $podmienka="".$akefirmy." AND inv >= 0 "; }
if( $podmienkaxy == '' ) { $podmienka=" inv >= 0 "; }

//koniec podmienka posledna



//podmienka prva idem ju nacitat
$sqlttx = "SELECT * FROM F$kli_vxcf"."_majzos_maj WHERE czs=$h_zos AND pod != '' ORDER BY por ";
//echo $sqlttx;
$sqlx = mysql_query("$sqlttx");
$polx = mysql_num_rows($sqlx);
if ( $polx > 1 )
  {
  if (@$zaznam=mysql_data_seek($sqlx,0))
{
$polozkax=mysql_fetch_object($sqlx);
$podmienka2xy=$polozkax->pod;
$podpol2=$polozkax->pol;
}
//echo $podmienka2xy." ".$podpol2;
//exit;


$pole = explode(",", $podmienka2xy);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
if( $kli_fmax0 == '' ) $kli_fmax0=$kli_fmin0;

if( $podpol2 == 'dob' OR $podpol2 == 'zar') { $kli_fmin0="'".SqlDatum($kli_fmin0)."'"; $kli_fmax0="'".SqlDatum($kli_fmax0)."'"; }

$akefirmy = "( $podpol2 >= $kli_fmin0 AND $podpol2 <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
if( $kli_fmax1 == '' ) $kli_fmax1=$kli_fmin1;
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol2 >= $kli_fmin1 AND $podpol2 <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
if( $kli_fmax2 == '' ) $kli_fmax2=$kli_fmin2;
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol2 >= $kli_fmin2 AND $podpol2 <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
if( $kli_fmax3 == '' ) $kli_fmax3=$kli_fmin3;
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol2 >= $kli_fmin3 AND $podpol2 <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
if( $kli_fmax4 == '' ) $kli_fmax4=$kli_fmin4;
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( $podpol2 >= $kli_fmin4 AND $podpol2 <= $kli_fmax4 )";

$podmnaz=0;
if( $podpol2 == 'naz' ) 
{ 
$podmnaz=1;
$akefirmy = "( naz LIKE '%".$pole[0]."%' )";
if( StrLen($pole[1]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[1]."%' ) "; }
if( StrLen($pole[2]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[2]."%' ) "; }
if( StrLen($pole[3]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[3]."%' ) "; }
if( StrLen($pole[4]) > 3 ) { $akefirmy = $akefirmy." OR ( naz LIKE '%".$pole[4]."%' ) "; }
$akefirmy=" ( ".$akefirmy." ) ";

$akefirmynaz=$akefirmy;
}
if( $podpol2 == 'vyc' ) 
{ 
$podmnaz=1;
$akefirmy = "( vyc LIKE '%".$pole[0]."%' )";
$akefirmynaz = "( vyc LIKE '%".$pole[0]."%' )";
}
//echo $akefirmy;
//exit;

if( $podmienka2xy != '' ) { $podmienka="( ".$akefirmy." ) AND ".$podmienka." "; }
//echo $podmienka;
//exit;

  }
//koniec podmienka prva


if (File_Exists ("../tmp/zospopis.php")) { $soubor = unlink("../tmp/zospopis.php"); }
$soubor = fopen("../tmp/zospopis.php", "a+");
fwrite($soubor, $popis);
fclose($soubor);

if (File_Exists ("../tmp/zospolozky.php")) { $soubor = unlink("../tmp/zospolozky.php"); }
$soubor = fopen("../tmp/zospolozky.php", "a+");
$odkazy="<?php \$odkaz=\"".$odkaz."\"; ?>";
$text="<?php if( \$polozka->hx5 != 99 ) { ?>";
fwrite($soubor, $text);
fwrite($soubor, $odkazy);
fwrite($soubor, $polozky);
$text="<?php } ?>";
fwrite($soubor, $text);
$text="<?php if( \$polozka->hx5 == 99 ) { ?>";
fwrite($soubor, $text);
fwrite($soubor, $polozkysum);
$text="<?php } ?>";
fwrite($soubor, $text);
fclose($soubor);


//koniec popis,tlac poloziek a podmienku a triedenie

if( $h_vyber == 1 )
{
$podmienka=" hx3 = 1 ";
}

//spocitaj sumy cen,ops,zos,pocet
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majmajx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_majmajx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_$subormaj WHERE inv >= 0 $podmvyrad ";
//echo $vsql;
//exit;
$vytvor = mysql_query("$vsql");

if( $podmnaz == 0 ) {
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_majmajx'.$kli_uzid."";
$vytvor = mysql_query("$vsql");

$vsql = 'INSERT INTO F'.$kli_vxcf.'_majmajx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_$subormaj WHERE $podmienka $podmvyrad";
$vytvor = mysql_query("$vsql");
                    }

if( $podmnaz == 1)  {
$vsql = 'UPDATE F'.$kli_vxcf.'_majmajx'.$kli_uzid." SET hx5=90 WHERE $akefirmynaz";
//echo $vsql;
$vytvor = mysql_query("$vsql");

$vsql = 'DELETE FROM F'.$kli_vxcf.'_majmajx'.$kli_uzid." WHERE hx5 != 90";
//echo $vsql;
$vytvor = mysql_query("$vsql");
                    }

//exit;

$dsqlt = "UPDATE F$kli_vxcf"."_majmajx$kli_uzid SET hx5=1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majmajx$kli_uzid".
" SELECT 0,$kli_vume,druh,drm,0,'SPOLU',pop,poz,vyc,rvr,tri,obo,jkp,ckp,0,0,SUM(mno),dob,dox,zar,rzv,str,zak,oc,kanc,spo,sku,perc,meso,".
"SUM(cen),SUM(ops),SUM(zos),SUM(zss),SUM(mes),SUM(ros),SUM(rop),0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,99,0,0".
" FROM F$kli_vxcf"."_majmajx$kli_uzid".
" GROUP BY druh";
$dsql = mysql_query("$dsqlt");


$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_majmajx$kli_uzid WHERE hx5=99");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $summno=$riaddok->mno;
  }
$naztext="Spolu ".$summno." položiek";

$dsqlt = "UPDATE F$kli_vxcf"."_majmajx$kli_uzid SET naz='$naztext' WHERE hx5=99 ";
$dsql = mysql_query("$dsqlt");


//tlac polozky
$sqltt = "SELECT * FROM F$kli_vxcf"."_majmajx$kli_uzid WHERE ( $podmienka ) OR ( hx5 = 99 ) ORDER BY hx5,$triedenie";
//echo $sqltt;
//exit;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

//exit;

//sumare napocet
$hotz = 0.00;

//////////////////////////////////////////////////////////////////
if ( $copern == 30 OR copern == 40 OR copern == 20 )
      {

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$porc=1;

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


$pdf->Cell(80,5,"$nazov","LTB",0,"L");
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',9);

$pole = explode("\r", $ttp);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,2,"  ","0",1,"R");
}


include("../tmp/zospopis.php");
}

//exit;


      }
//koniec j=0



if( $typ == 'PDF' )
{
$naz=$polozka->naz;
$cen=$polozka->cen;
$ops=$polozka->ops;
$zos=$polozka->zos;
$ros=$polozka->ros;
if( $polozka->hx5 == 99 ) 
{
$pdf->SetFont('arial','',10);
$pdf->Cell(0,1," ","1",1,"L");
}
include("../tmp/zospolozky.php");

}

if( $j > 30 ) { $strana=$strana+1; $j=-1; }


}
$i = $i + 1;
$j = $j + 1;
$porc = $porc + 1;

//koniec stranky
if( $j == 40 )
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
$pole = explode("\r", $ttz);

if( $pole[0] != '' )
{
$pdf->Cell(0,2,"  ","0",1,"R");

$ipole=1;
foreach( $pole as $hodnota ) {

$pdf->Cell(150,5,"$hodnota","0",1,"L");
$ipole=$ipole+1;
                             }

$pdf->Cell(0,2,"  ","0",1,"R");
}

$pdf->Output("../tmp/tlacmaj.$kli_uzid.pdf");
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/tlacmaj.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}


if( $typ == 'HTML' )
{
?>

</table>
<?php
}
?>

<?php
//////////////////////////////////////////////////////////////////koniec z PODVOJNEHO
      }
?>



<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prchlknihasy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majmajx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

if (File_Exists ("../tmp/zospopis.php")) { $soubor = unlink("../tmp/zospopis.php"); }
//if (File_Exists ("../tmp/zospolozky.php")) { $soubor = unlink("../tmp/zospolozky.php"); }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
