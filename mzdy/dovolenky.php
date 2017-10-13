<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$ostre = 1*$_REQUEST['ostre'];
$aktpr = 1*$_REQUEST['aktpr'];

$dajcsv = 1*$_REQUEST['dajcsv'];


if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovol'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovolx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovolz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   pox          INT(7) DEFAULT 0,
   pomer        INT(7) DEFAULT 0,
   uvazok       DECIMAL(10,2) DEFAULT 0,
   narok        DECIMAL(10,2) DEFAULT 0,
   minul        DECIMAL(10,2) DEFAULT 0,
   cerpal       DECIMAL(10,2) DEFAULT 0,
   cerpalm      DECIMAL(10,2) DEFAULT 0,
   zostatok     DECIMAL(10,2) DEFAULT 0,
   priemer      DECIMAL(10,4) DEFAULT 0,
   zoseur       DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcdovol'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcdovolx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcdovolz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//zober data z kun 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" SELECT oc,0,0,0,".
"0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_mzdzalkun".
" WHERE ume = $kli_vume ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z vy 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" SELECT oc,0,0,0,".
"0,0,dni,0,0,ume,0,".
"0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume <= $kli_vume AND ( dm = 506 OR dm = 507 OR dm = 508 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if( $alchem == 1 AND $kli_vrok == 2010 AND $kli_vume >= 10.2010 AND $kli_vxcf == 523 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcdovol".$kli_uzid."  WHERE oc = 214 AND cerpal != 0 AND priemer < 10.2010 ";
$dsql = mysql_query("$dsqlt");
}
if( $alchem == 1 AND $kli_vrok == 2010 AND $kli_vume >= 11.2010 AND $kli_vxcf == 523 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcdovol".$kli_uzid."  WHERE oc = 191 AND cerpal != 0 AND priemer < 11.2010 ";
$dsql = mysql_query("$dsqlt");
}

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovol$kli_uzid SET priemer=0 WHERE oc > 0";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" SELECT oc,0,0,0,".
"0,0,0,dni,0,0,0,".
"0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND ( dm = 506 OR dm = 507 OR dm = 508 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,1,0,0,".
"0,0,SUM(cerpal),SUM(cerpalm),0,0,0,".
"0".
" FROM F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" WHERE pox = 0".
" GROUP BY oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln udaje z kun
if( $aktpr != 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid,F$kli_vxcf"."_mzdzalkun".
" SET pomer=pom, narok=nrk, minul=nev, priemer=znah, uvazok=uva ".
" WHERE F$kli_vxcf"."_mzdprcdovolx$kli_uzid.oc = F$kli_vxcf"."_mzdzalkun.oc AND ume = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
}
if( $aktpr == 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET pomer=pom, narok=nrk, minul=nev, priemer=znah, uvazok=uva ".
" WHERE F$kli_vxcf"."_mzdprcdovolx$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
}


//vypocitaj sucty
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcdovolx$kli_uzid WHERE narok = 0 AND cerpal = 0 AND minul = 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcdovolx$kli_uzid WHERE pomer = 9 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


if( $medo == 1 AND $kli_vrok == 2011 AND $kli_vume > 1.2011 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid SET cerpal=cerpal+20 WHERE oc = 7402 ";
$oznac = mysql_query("$sqtoz");
  }

//vypocitaj sucty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET zostatok=narok+minul-cerpal, zoseur=zostatok*priemer*uvazok ".
" WHERE oc > 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,0,0,uvazok,".
"SUM(narok),SUM(minul),SUM(cerpal),SUM(cerpalm),SUM(zostatok),0,SUM(zoseur),".
"9".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" WHERE pox = 1".
" GROUP BY pox";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid SET pox=0, pomer=0 ";
$oznac = mysql_query("$sqtoz");

if( $wedgb == 1 ) { $medo=1; }

if( $medo == 1 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET pox=stz ".
" WHERE F$kli_vxcf"."_mzdprcdovolx$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc ";
$oznac = mysql_query("$sqtoz");

//sumar za str
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,pox,1,uvazok,".
"SUM(narok),SUM(minul),SUM(cerpal),SUM(cerpalm),SUM(zostatok),0,SUM(zoseur),".
"0".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" WHERE konx = 0".
" GROUP BY pox";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Èerpanie a zostatok dovolenky</title>
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
<td>EuroSecom  -  Èerpanie a zostatok dovolenky

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$typ="PDF";
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if( $dajcsv == 0 AND $typ == 'PDF' )
    {
 $outfilexdel="../tmp/dovol_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/dovol_".$kli_uzid."_".$hhmmss.".pdf";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }
    }

if( $dajcsv == 1 AND $typ == 'PDF' )
    {

 $outfilexdel="../tmp/dovol_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/dovol_".$kli_uzid."_".$hhmmss.".csv";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$nazsub=$outfilex;
$soubor = fopen("$nazsub", "a+");

    }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE ( ( konx = 0 AND pomer <= 1 ) OR konx = 9 ) ORDER BY konx,pox,pomer,F$kli_vxcf"."_mzdkun.prie,F$kli_vxcf"."_mzdkun.meno,F$kli_vxcf"."_mzdkun.oc";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
$pocpol=$tvpol-1;
//exit;

$strana=0;
$j=0;           
$i=0;
$pcislo=1;
  while ($i <= $pocpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$zzam_zp=$rtov->zzam_zp;
if( $rtov->zzam_zp == 0 ) $zzam_zp="";


//hlavicka strany
if ( $j == 0 )
     {
$strana=$strana+1;

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);
$pdf->Cell(125,6,"Èerpanie a zostatok dovolenky za $kli_vume ","LTB",0,"L");
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',9);


$pdf->Cell(70,5,"Zamestnanec","1",0,"L");
$pdf->Cell(28,5,"Nárok dni","1",0,"R");$pdf->Cell(33,5,"Prenos min.rok dni","1",0,"R");
$pdf->Cell(25,5,"Èerpané celkom","1",0,"R");$pdf->Cell(25,5,"Èerpané $kli_vume","1",0,"R");$pdf->Cell(28,5,"Zostatok dni","1",0,"R");
$pdf->Cell(28,5,"Priemer $mena1/hod.","1",0,"R");
$pdf->Cell(0,5,"Zostatok $mena1","1",1,"R");

if ( $dajcsv == 1 )
      {
$text = "priezvisko;meno;osc;narok;prenos z minuleho;cerpane celkom;cerpane mesiac;zostatok;priemer na hod.;zostatok eur"."\r\n";
fwrite($soubor, $text);
      }

     }
//koniec hlavicky j=0



if( $rtov->konx == 0 AND $rtov->pomer == 0 )
{

$pdf->Cell(70,5,"$rtov->prie $rtov->meno oc.$rtov->oc ","0",0,"L");
$pdf->Cell(28,5,"$rtov->narok","0",0,"R");$pdf->Cell(33,5,"$rtov->minul","0",0,"R");
$pdf->Cell(25,5,"$rtov->cerpal","0",0,"R");$pdf->Cell(25,5,"$rtov->cerpalm","0",0,"R");$pdf->Cell(28,5,"$rtov->zostatok","0",0,"R");
$pdf->Cell(28,5,"$rtov->priemer","0",0,"R");
$pdf->Cell(0,5,"$rtov->zoseur","0",1,"R");

if ( $dajcsv == 1 )
      {

$narok = str_replace(".",",",$rtov->narok);
$minul = str_replace(".",",",$rtov->minul);
$cerpal = str_replace(".",",",$rtov->cerpal);
$cerpalm = str_replace(".",",",$rtov->cerpalm);
$zostatok = str_replace(".",",",$rtov->zostatok);
$priemer = str_replace(".",",",$rtov->priemer);
$zoseur = str_replace(".",",",$rtov->zoseur);

$text = $rtov->prie.";".$rtov->meno.";".$rtov->oc.";".$narok.";".$minul.";".$cerpal.";".$cerpalm.";".$zostatok;
$text = $text.";".$priemer.";".$zoseur."\r\n";
fwrite($soubor, $text);
      }

}


if( $rtov->konx == 0 AND $rtov->pomer == 1 )
{

$pdf->Cell(70,5,"STR $rtov->pox ","T",0,"L");
$pdf->Cell(28,5,"$rtov->narok","T",0,"R");$pdf->Cell(33,5,"$rtov->minul","T",0,"R");
$pdf->Cell(25,5,"$rtov->cerpal","T",0,"R");$pdf->Cell(25,5,"$rtov->cerpalm","T",0,"R");$pdf->Cell(28,5,"$rtov->zostatok","T",0,"R");
$pdf->Cell(28,5," ","T",0,"R");
$pdf->Cell(0,5,"$rtov->zoseur","T",1,"R");
$j=45;

}


if( $rtov->konx == 9 )
{

$pdf->Cell(70,5,"CELKOM ","T",0,"L");
$pdf->Cell(28,5,"$rtov->narok","T",0,"R");$pdf->Cell(33,5,"$rtov->minul","T",0,"R");
$pdf->Cell(25,5,"$rtov->cerpal","T",0,"R");$pdf->Cell(25,5,"$rtov->cerpalm","T",0,"R");$pdf->Cell(28,5,"$rtov->zostatok","T",0,"R");
$pdf->Cell(28,5," ","T",0,"R");
$pdf->Cell(0,5,"$rtov->zoseur","T",1,"R");


}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 31 ) $j=0;
  }


if( $dajcsv == 0 )
  {
$pdf->Output("$outfilex");

?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
  }

if( $dajcsv == 1 )
  {
fclose($soubor);
?> 
<br />
<br />
Stiahnite si nižšie uvedený súbor na Váš lokálny disk :
<br />
<br />
  <a href="<?php echo $outfilex; ?>"><?php echo $outfilex; ?></a>
<?php

  }


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovol'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovolx'.$kli_uzid;
if( $kli_vmes != 12 ) $vysledok = mysql_query("$sqlt");


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
