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

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$mzdmes="mzdzalmesx".$kli_uzid;
$mzdtrn="mzdzaltrnx".$kli_uzid;
$mzdddp="mzdzalddpx".$kli_uzid;
$mzdkun="mzdzalkunx".$kli_uzid;
$mzdprm="mzdzalprmx".$kli_uzid;

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmesx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalmes WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrnx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzaltrn WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddpx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalddp WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkunx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprmx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalprm WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");

//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcddp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcddpz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   xddp         INT(7) DEFAULT 0,
   xczml        VARCHAR(25) NOT NULL,
   xdatp        DATE,
   zzam_ddp     DECIMAL(10,2) DEFAULT 0,
   ozam_ddp     DECIMAL(10,2) DEFAULT 0,
   ofir_ddp     DECIMAL(10,2) DEFAULT 0,
   perc_zddp    DECIMAL(10,2) DEFAULT 0,
   fix_zddp     DECIMAL(10,2) DEFAULT 0,
   perc_fddp    DECIMAL(10,2) DEFAULT 0,
   fix_fddp     DECIMAL(10,2) DEFAULT 0,
   celk_spolu   DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   zzam_xzp     DECIMAL(10,2) DEFAULT 0,
   zzam_xip     DECIMAL(10,2) DEFAULT 0,
   zzam_xpn     DECIMAL(10,2) DEFAULT 0,
   zzam_xnp     DECIMAL(10,2) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcddp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcddpx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcddpz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//definicia mzdddp          cpl  oc  perz_dd  fixz_dd  perp_dd  fixp_dd  cddp  czm  dtd  pd1  pd2  pd3  pd4  datm  
//definicia mzdzalddp  ume  cpl  oc  perz_dd  fixz_dd  perp_dd  fixp_dd  cddp  czm  dtd  pd1  pd2  pd3  pd4  datm  

//zober data
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcddpx".$kli_uzid.
" SELECT oc,cddp,'','',".
"0,0,0,0,0,0,0,0,".
"0,0,0,0,0".
" FROM F$kli_vxcf"."_$mzdddp ".
" WHERE ume = $kli_vume AND oc > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcddpx".$kli_uzid.
" SELECT oc,cddp,'','',".
"0,kc,0,0,0,0,0,0,".
"0,0,0,0,0".
" FROM F$kli_vxcf"."_mzdzalvy ".
" WHERE ume = $kli_vume AND oc > 0 AND dm = 965 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcddp".$kli_uzid.
" SELECT oc,xddp,xczml,xdatp,".
"sum(zzam_ddp),sum(ozam_ddp),sum(ofir_ddp),0,0,0,0,sum(celk_spolu),".
"0,0,0,0,0".
" FROM F$kli_vxcf"."_mzdprcddpx".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY xddp,oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//dopln cddp z ddp do vy
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcddp$kli_uzid,F$kli_vxcf"."_$mzdddp".
" SET perc_zddp=perz_dd, fix_zddp=fixz_dd, perc_fddp=perp_dd, fix_fddp=fixp_dd, xczml=czm, xdatp=dtd".
" WHERE F$kli_vxcf"."_mzdprcddp$kli_uzid.oc = F$kli_vxcf"."_$mzdddp.oc AND F$kli_vxcf"."_mzdprcddp$kli_uzid.xddp = F$kli_vxcf"."_$mzdddp.cddp";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//dopln sum_hru z sum
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcddp$kli_uzid,F$kli_vxcf"."_mzdzalsum ".
" SET zzam_ddp=sum_hru   ".
" WHERE F$kli_vxcf"."_mzdprcddp$kli_uzid.oc = F$kli_vxcf"."_mzdzalsum.oc AND F$kli_vxcf"."_mzdzalsum.ume = $kli_vume ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vypocitaj znovu ddp zamestnavatela
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcddp$kli_uzid".
" SET ofir_ddp=perc_fddp*zzam_ddp/100 ".
" WHERE oc > 0 AND perc_fddp > 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcddp$kli_uzid".
" SET ofir_ddp=fix_fddp  ".
" WHERE oc > 0 AND fix_fddp > 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//sumy
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcddp$kli_uzid ".
" SET celk_spolu=ozam_ddp+ofir_ddp ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcddp".$kli_uzid.
" SELECT oc,xddp,xczml,xdatp,".
"sum(zzam_ddp),sum(ozam_ddp),sum(ofir_ddp),0,0,0,0,sum(celk_spolu),".
"9,0,0,0,0".
" FROM F$kli_vxcf"."_mzdprcddp".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY xddp";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Rozpis odvodov DDP</title>
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
<?php if ( $copern == 1 ) { echo "<td>EuroSecom  -  Rozpis odvodov DDP "; } ?>
<?php if ( $copern == 30 ) { echo "<td>EuroSecom  -  Prevod AXA XML súbor "; } ?>
<?php if ( $copern == 40 ) { echo "<td>EuroSecom  -  Prevod TATRA TXT súbor "; } ?>
<?php if ( $copern == 50 ) { echo "<td>EuroSecom  -  Prevod ING TATRY SYMPATIA TXT súbor "; } ?>
<?php if ( $copern == 60 ) { echo "<td>EuroSecom  -  Prevod STABILITA XML súbor "; } ?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
////////////////////////////////////MESACNA ZOSTAVA
if ( $copern == 1 )
          {


if (File_Exists ("../tmp/mzdzos$kli_uzid.pdf")) { $soubor = unlink("../tmp/mzdzos$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_$mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_$mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc >= 0 ORDER BY xddp,konx,prie,meno";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$zzam_ddp=$rtov->zzam_ddp;
if( $rtov->zzam_ddp == 0 ) $zzam_ddp="";
$ozam_ddp=$rtov->ozam_ddp;
if( $rtov->ozam_ddp == 0 ) $ozam_ddp="";
$ofir_ddp=$rtov->ofir_ddp;
if( $rtov->ofir_ddp == 0 ) $ofir_ddp="";

//hlavicka strany
if ( $j == 0 AND $rtov->konx == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);
$pdf->Cell(115,6,"Rozpis odvodov do DDSporenia ( DDP ) za $kli_vume","LTB",0,"L");
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);


$pdf->Cell(50,5,"Priezvisko,meno ","1",0,"L");$pdf->Cell(25,5,"Základ","1",0,"C");$pdf->Cell(25,5,"Odvod Zamtel","1",0,"C");
$pdf->Cell(25,5,"Odvod Zamnec","1",0,"C");
$pdf->Cell(30,5,"Odvod Spolu","1",0,"C");
$pdf->Cell(30,5,"Èíslo zmluvy","1",0,"C");$pdf->Cell(30,5,"Dátum poistenia","1",1,"C");

$pdf->Cell(100,5,"DDP$rtov->xddp $rtov->nddp","0",1,"L");
     }
//koniec hlavicky j=0


if( $rtov->konx == 0 )
{


$pdf->SetFont('arial','',8);

$pdf->Cell(50,5,"DDP$rtov->xddp $rtov->prie $rtov->meno $rtov->titl","0",0,"L");
$pdf->Cell(25,5,"$zzam_ddp","0",0,"R");$pdf->Cell(25,5,"$ofir_ddp","0",0,"R");
$pdf->Cell(25,5,"$ozam_ddp","0",0,"R");
$pdf->Cell(30,5,"$rtov->celk_spolu","0",0,"R");
$pdf->Cell(30,5,"$rtov->xczml","0",0,"C");$pdf->Cell(30,5,"$rtov->xdatp","0",1,"C");

}

if( $rtov->konx == 9 )
{
$pdf->Cell(230,3," ","B",1,"R");

$pdf->Cell(50,5,"CELKOM DDP $rtov->xdrv","0",0,"L");
$pdf->Cell(25,5,"$zzam_ddp","0",0,"R");$pdf->Cell(25,5,"$ofir_ddp","0",0,"R");
$pdf->Cell(25,5,"$ozam_ddp","0",0,"R");
$pdf->Cell(30,5,"$rtov->celk_spolu","0",0,"R");
$pdf->Cell(30,5," ","0",0,"C");$pdf->Cell(30,5," ","0",1,"C");


}


}
$i = $i + 1;
$j = $j + 1;

if( $rtov->konx == 9 ) $j=0; //nova strana;
  }


$pdf->Output("../tmp/mzdzos.$kli_uzid.pdf");


?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mzdzos.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

?>

<?php

          }
////////////////////////////////////KONIEC MESACNA ZOSTAVA
?>



<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU AXA
if( $copern == 30 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="AXA".$kli_vmes.$kli_vxr;


if (File_Exists ("../tmp/$nazsub.xml")) { $soubor = unlink("../tmp/$nazsub.xml"); }

$soubor = fopen("../tmp/$nazsub.xml", "a+");

/////////////NACITANIE UDAJOV O DDP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE nddp LIKE '%AXA%' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_ddp=$riaddok->cddp;
  $ddpvsy=$riaddok->vsy;
  $naznddp=$riaddok->nddp;
  $ddpksy=$riaddok->ksy;
  $ddpssy=1*$riaddok->ssy;
  $ddpucb=$riaddok->uceb;
  $ddpnum=$riaddok->numb;
  }

//pocet poloziek
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";

$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 9 ORDER BY xddp,konx,prie,meno";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 


if( $fir_fico > 0 )
{

$fir_kodddp=$ddpvsy;
$fir_identifikatorddp="1";
$fir_ucetfondu=$ddpucb."/".$ddpnum;

}

if( $ddpssy == 0 ) $ddpssy=$kli_vmes.$kli_vrok;

  $text = "<?xml version = \"1.0\" encoding=\"windows-1250\" ?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<vypisy>"."\r\n";
  fwrite($soubor, $text);
  $text = "<vypis cislo=\"1\" identifikator=\"$fir_identifikatorddp\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<hlavicka produkt=\"DDS\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<organizacia>"."\r\n";
  fwrite($soubor, $text);
  $text = "<kodzamestnavatela>$fir_kodddp</kodzamestnavatela>"."\r\n";
  fwrite($soubor, $text);
  $text = "<kontakt>$fir_ftel</kontakt>"."\r\n";
  fwrite($soubor, $text);      
  $text = "<ico>$fir_fico</ico>"."\r\n";
  fwrite($soubor, $text);  
  $text = "<oj>00</oj>"."\r\n";
  fwrite($soubor, $text);         
  $text = "<vs>$ddpvsy</vs>"."\r\n";
  fwrite($soubor, $text);       
  $text = "<ss>$ddpssy</ss>"."\r\n";
  fwrite($soubor, $text);
  $text = "<nazovorganizacie>$fir_fnaz</nazovorganizacie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<cislouctu>$fir_fuc1/$fir_fnm1</cislouctu>"."\r\n";
  fwrite($soubor, $text);
  $text = "</organizacia>"."\r\n";
  fwrite($soubor, $text);

  $text = "<obdobie>".$kli_vrok.$kli_vmes."</obdobie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ucetfondu>$fir_ucetfondu</ucetfondu>"."\r\n";
  fwrite($soubor, $text);
  $text = "<pocetviet>$polp</pocetviet>"."\r\n";
  fwrite($soubor, $text);
  $text = " <sumy>"."\r\n";
  fwrite($soubor, $text);

$Cislo=$hlavicka->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);

  $text = "<celkovasumaZCZ>$ozam_ddp</celkovasumaZCZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<celkovasumaZTZ>$ofir_ddp</celkovasumaZTZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<celkovasuma>$celk_spolu</celkovasuma>"."\r\n";
  fwrite($soubor, $text);


  $text = "</sumy>"."\r\n";
  fwrite($soubor, $text);
  $text = "<poznamka>OK</poznamka>"."\r\n";
  fwrite($soubor, $text);
  $text = "</hlavicka>"."\r\n";
  fwrite($soubor, $text);

     

  $text = "<vety>"."\r\n";
  fwrite($soubor, $text);




}
$i = $i + 1;
$j = $j + 1;
  }

//polozky

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";


$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $polp )
  {


  if (@$zaznam=mysql_data_seek($sqlp,$i))
{
$hlavickp=mysql_fetch_object($sqlp);
$cislo=$i+1;

$Cislo=$hlavickp->ofir_np+"";
$ofir_np=sprintf("%0.1f", $Cislo);


  $text = "<veta cislo=\"$cislo\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<zamestnanec>"."\r\n";
  fwrite($soubor, $text);
  $text = "<cisloZCZ>$hlavickp->xczml</cisloZCZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<meno>$hlavickp->meno</meno>"."\r\n";
  fwrite($soubor, $text);
  $text = "<priezvisko>$hlavickp->prie</priezvisko>"."\r\n";
  fwrite($soubor, $text);
  $text = "<rodnecislo>$hlavickp->rdc$hlavickp->rdk</rodnecislo>"."\r\n";
  fwrite($soubor, $text);
  $text = "</zamestnanec>"."\r\n";
  fwrite($soubor, $text);

  $text = "<prispevky>"."\r\n";
  fwrite($soubor, $text);
  $text = "<prispevok typprispevku=\"N\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<kat3a4>true</kat3a4>"."\r\n";
  fwrite($soubor, $text);          

$Cislo=$hlavickp->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);
           
  $text = "<prispevokZCZ>$ozam_ddp</prispevokZCZ>"."\r\n";
  fwrite($soubor, $text);    
  $text = "<prispevokZTZ>$ofir_ddp</prispevokZTZ>"."\r\n";
  fwrite($soubor, $text);    
            
  $text = "</prispevok>"."\r\n";
  fwrite($soubor, $text);
  $text = "</prispevky>"."\r\n";
  fwrite($soubor, $text);

  $text = "</veta>"."\r\n";
  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</vety>"."\r\n";
  fwrite($soubor, $text);

  $text = "</vypis>"."\r\n";
  fwrite($soubor, $text);
  $text = "</vypisy>"."\r\n";
  fwrite($soubor, $text);

fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.xml">../tmp/<?php echo $nazsub; ?>.xml</a>


<?php

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU AXA

?>


<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU TATRA
if( $copern == 40 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$pole = explode("-", $dnes);
$rok=$pole[0];
$mesiac=$pole[1];
$den=$pole[2];
$datum=$den.$mesiac.$rok;

$nazsub=$fir_fico."00.".$datum."00";
//AAAAAAAABB.DDMMRRRRèè

if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }

$soubor = fopen("../tmp/$nazsub", "a+");

/////////////NACITANIE UDAJOV O DDP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE nddp LIKE '%TATRA%' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_ddp=$riaddok->cddp;
  $ddpvsy=$riaddok->vsy;
  $naznddp=$riaddok->nddp;
  $ddpksy=$riaddok->ksy;
  $ddpssy=1*$riaddok->ssy;
  $ddpucb=$riaddok->uceb;
  $ddpnum=$riaddok->numb;
  }

//pocet poloziek
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";

$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 9 ORDER BY xddp,konx,prie,meno";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);



$cislozmluvyzamestnavatela="";
if( $_SERVER['SERVER_NAME'] == "www.eurolark.sk" ) { $cislozmluvyzamestnavatela="50814"; }


//if( $kli_vmes < 10 ) $kli_vmes="0".$kli_vmes;
$obdobievyplat=$kli_vrok.$kli_vmes;

$Cislo=$hlavicka->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);

$ofir_ddp=str_replace(".",",",$ofir_ddp);
$ozam_ddp=str_replace(".",",",$ozam_ddp);
$celk_spolu=str_replace(".",",",$celk_spolu);

  $text = "\"".$cislozmluvyzamestnavatela."\" \"".$fir_fico."00\" \"".$obdobievyplat."\" \"".$datum."00\" \"";
  $text = $text." ".$ozam_ddp." ".$ofir_ddp." ".$celk_spolu."\r\n";
  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }

//polozky

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";


$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $polp )
  {


  if (@$zaznam=mysql_data_seek($sqlp,$i))
{
$hlavickp=mysql_fetch_object($sqlp);
$cislo=$i+1;


$Cislo=$hlavickp->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);

$ofir_ddp=str_replace(".",",",$ofir_ddp);
$ozam_ddp=str_replace(".",",",$ozam_ddp);
$celk_spolu=str_replace(".",",",$celk_spolu);

  $text = "\"".$hlavickp->rdc.$hlavickp->rdk."\" \"".$hlavickp->prie."\"";
  $text = $text." ".$ozam_ddp." ".$ofir_ddp." "."\"\""."\r\n";
  fwrite($soubor, $text);




}
$i = $i + 1;
$j = $j + 1;
  }



fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>


<?php

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU TATRA

?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU  ING TATRY SYMPATIA
if( $copern == 50 )
{

//TXT export
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$pole = explode("-", $dnes);
$rok=$pole[0];
$mesiac=$pole[1];
$den=$pole[2];
$datum=$den.$mesiac.$rok;
$dnes_sk=SkDatum($dnes);

$nazsub=$fir_fico."_".$kli_vrok.$kli_vmes;
//ico_201106.txt na rozpisy_ts@ing.sk

if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }

$soubor = fopen("../tmp/$nazsub", "a+");

/////////////NACITANIE UDAJOV O DDP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE nddp LIKE '%SYMPATIA%' OR nddp LIKE '%NN%' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_ddp=$riaddok->cddp;
  $ddpvsy=$riaddok->vsy;
  $naznddp=$riaddok->nddp;
  $ddpksy=$riaddok->ksy;
  $ddpssy=1*$riaddok->ssy;
  $ddpucb=$riaddok->uceb;
  $ddpnum=$riaddok->numb;
  }

//pocet poloziek
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";

$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 9 ORDER BY xddp,konx,prie,meno";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= 0 )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);



$cislozmluvyzamestnavatela="";
$cislozmluvyzamestnavatela=1*$ddpvsy;
if( $cislozmluvyzamestnavatela == 0 ) { $cislozmluvyzamestnavatela="";  }

//if( $kli_vmes < 10 ) $kli_vmes="0".$kli_vmes;
$obdobievyplat=$kli_vrok.$kli_vmes;

$Cislo=$hlavicka->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);

$ofir_ddp=str_replace(".",",",$ofir_ddp);
$ozam_ddp=str_replace(".",",",$ozam_ddp);
$celk_spolu=str_replace(".",",",$celk_spolu);


if( $fir_mzdt05 == '' ) $fir_mzdt05=$kli_uzmeno." ".$kli_uzprie;

  $text = "";

  $text = $text."i1	KodZZ                           "."\r\n";		
  $text = $text."i2	èíslo zmluvy		        ".$cislozmluvyzamestnavatela."\r\n";
  $text = $text."i3	IÈO		                ".$fir_fico."\r\n";
  $text = $text."i4	Názov organizácie               ".$fir_fnaz."\r\n";		
  $text = $text."i5	Ïalšie identif. údaje           "."\r\n";		
  $text = $text."i6	Obdobie (vo formáte RRRRMM)     ".$kli_vrok.$kli_vmes."\r\n";		
  $text = $text."i7	Poèet úèastníkov	        ".$polp."\r\n";	
  $text = $text."i8	Súèet príspevkov úèastníkov	".$ozam_ddp."\r\n";
  $text = $text."i9	Súèet príspevkov zamestnávate¾a	".$ofir_ddp."\r\n";
  $text = $text."i10	Celková uhrádzaná èiastka	".$celk_spolu."\r\n";
  $text = $text."i11	Termín úhrady                   "."\r\n";		
  $text = $text."i12	Úhrada - VS                     ".$ddpvsy."\r\n";
  $text = $text."i13	Úhrada - KS	                3558"."\r\n";	
  $text = $text."i14	Úhrada - ŠS	                ".$ddpssy."\r\n";	
  $text = $text."i15	Dátum a miesto vypracovania     ".$dnes_sk." ".$fir_fmes."\r\n";		
  $text = $text."i16	Vypracoval, tel. è.             ".$fir_mzdt05." ".$fir_mzdt04."\r\n"."\r\n";

  fwrite($soubor, $text);

}
$i = $i + 1;
$j = $j + 1;
  }

//polozky

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";


$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $polp )
  {


  if (@$zaznam=mysql_data_seek($sqlp,$i))
{
$hlavickp=mysql_fetch_object($sqlp);
$cislo=$i+1;

if( $i == 0 )
  {
  $text = "Por.è.".";"."Èíslo úèastníckej zmluvy alebo Rodné èíslo úèastníka".";"."Priezvisko úèastníka".";"."Meno úèastníka";
  $text = $text.";"."Výška príspevku úèastníka".";"."Výška príspevku zamest. úèastníkovi".";"."Hrubá mzda".";"."Poznámka"."\r\n";
  fwrite($soubor, $text);
  }


$Cislo=$hlavickp->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);


$Cislo=$hlavickp->zzam_ddp+"";
$zaklad=sprintf("%0.2f", $Cislo);

$ofir_ddp=str_replace(".",",",$ofir_ddp);
$ozam_ddp=str_replace(".",",",$ozam_ddp);
$celk_spolu=str_replace(".",",",$celk_spolu);
$zaklad=str_replace(".",",",$zaklad);

$cslzam=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdddp WHERE oc = $hlavickp->oc ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cslzam=1*$riaddok->czm;
  }


if( $cslzam == 0 ) { $cslzam=$hlavickp->rdc.$hlavickp->rdk; }
$cslzam=1*$cslzam;

  $text = $cislo.";".$cslzam.";".$hlavickp->prie.";".$hlavickp->meno.";";
  $text = $text.$ozam_ddp.";".$ofir_ddp.";".$celk_spolu.";".$zaklad.";;"."\r\n";
  fwrite($soubor, $text);




}
$i = $i + 1;
$j = $j + 1;
  }



fclose($soubor);
?>

Tento vytvorený súbor TXT alebo XML zašlite na e-mailovú adresu rozpisy@nn.sk <br/>
Ako predmet e-mailu zadajte IÈO spoloènosti, za ktorú je rozpis vytorený.<br/><br/>

<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>

<?php
//XML export
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$pole = explode("-", $dnes);
$rok=$pole[0];
$mesiac=$pole[1];
$den=$pole[2];
$datum=$den.$mesiac.$rok;
$dnes_sk=SkDatum($dnes);

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsubxml=$fir_fico."_".$kli_vrok.$kli_vmes."_".$idx.".xml";

if (File_Exists ("../tmp/$nazsubxml")) { $soubor = unlink("../tmp/$nazsubxml"); }

$soubor = fopen("../tmp/$nazsubxml", "a+");

//pocet poloziek
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";

$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 9 ORDER BY xddp,konx,prie,meno";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 


if( $fir_fico > 0 )
{

$fir_kodddp=$ddpvsy;
$fir_identifikatorddp="1";
$fir_ucetfondu=$ddpucb."/".$ddpnum;

}

if( $ddpssy == 0 ) $ddpssy=$kli_vmes.$kli_vrok;

  $text = "<?xml version = \"1.0\" encoding=\"windows-1250\" ?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<vypisy>"."\r\n";
  fwrite($soubor, $text);
  $text = "<vypis cislo=\"1\" identifikator=\"$fir_identifikatorddp\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<hlavicka produkt=\"DDS\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<organizacia>"."\r\n";
  fwrite($soubor, $text);
  $text = "<kodzamestnavatela>$fir_kodddp</kodzamestnavatela>"."\r\n";
  fwrite($soubor, $text);
  $text = "<kontakt>$fir_ftel</kontakt>"."\r\n";
  fwrite($soubor, $text);      
  $text = "<ico>$fir_fico</ico>"."\r\n";
  fwrite($soubor, $text);  
  $text = "<oj>00</oj>"."\r\n";
  fwrite($soubor, $text);         
  $text = "<vs>$ddpvsy</vs>"."\r\n";
  fwrite($soubor, $text);       
  $text = "<ss>$ddpssy</ss>"."\r\n";
  fwrite($soubor, $text);
  $text = "<nazovorganizacie>$fir_fnaz</nazovorganizacie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<cislouctu>$fir_fuc1/$fir_fnm1</cislouctu>"."\r\n";
  fwrite($soubor, $text);
  $text = "</organizacia>"."\r\n";
  fwrite($soubor, $text);

  $text = "<obdobie>".$kli_vrok.$kli_vmes."</obdobie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ucetfondu>$fir_ucetfondu</ucetfondu>"."\r\n";
  fwrite($soubor, $text);
  $text = "<pocetviet>$polp</pocetviet>"."\r\n";
  fwrite($soubor, $text);
  $text = " <sumy>"."\r\n";
  fwrite($soubor, $text);

$Cislo=$hlavicka->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);

  $text = "<celkovasumaZCZ>$ozam_ddp</celkovasumaZCZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<celkovasumaZTZ>$ofir_ddp</celkovasumaZTZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<celkovasuma>$celk_spolu</celkovasuma>"."\r\n";
  fwrite($soubor, $text);


  $text = "</sumy>"."\r\n";
  fwrite($soubor, $text);
  $text = "<poznamka>OK</poznamka>"."\r\n";
  fwrite($soubor, $text);
  $text = "</hlavicka>"."\r\n";
  fwrite($soubor, $text);

     

  $text = "<vety>"."\r\n";
  fwrite($soubor, $text);




}
$i = $i + 1;
$j = $j + 1;
  }

//polozky

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";


$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $polp )
  {


  if (@$zaznam=mysql_data_seek($sqlp,$i))
{
$hlavickp=mysql_fetch_object($sqlp);
$cislo=$i+1;

$Cislo=$hlavickp->ofir_np+"";
$ofir_np=sprintf("%0.1f", $Cislo);


  $text = "<veta cislo=\"$cislo\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<zamestnanec>"."\r\n";
  fwrite($soubor, $text);
  $text = "<cisloZCZ>$hlavickp->xczml</cisloZCZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<meno>$hlavickp->meno</meno>"."\r\n";
  fwrite($soubor, $text);
  $text = "<priezvisko>$hlavickp->prie</priezvisko>"."\r\n";
  fwrite($soubor, $text);
  $text = "<rodnecislo>$hlavickp->rdc$hlavickp->rdk</rodnecislo>"."\r\n";
  fwrite($soubor, $text);
  $text = "</zamestnanec>"."\r\n";
  fwrite($soubor, $text);

  $text = "<prispevky>"."\r\n";
  fwrite($soubor, $text);
  $text = "<prispevok typprispevku=\"N\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<kat3a4>true</kat3a4>"."\r\n";
  fwrite($soubor, $text);          

$Cislo=$hlavickp->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);
           
  $text = "<prispevokZCZ>$ozam_ddp</prispevokZCZ>"."\r\n";
  fwrite($soubor, $text);    
  $text = "<prispevokZTZ>$ofir_ddp</prispevokZTZ>"."\r\n";
  fwrite($soubor, $text);    
            
  $text = "</prispevok>"."\r\n";
  fwrite($soubor, $text);
  $text = "</prispevky>"."\r\n";
  fwrite($soubor, $text);

  $text = "</veta>"."\r\n";
  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</vety>"."\r\n";
  fwrite($soubor, $text);

  $text = "</vypis>"."\r\n";
  fwrite($soubor, $text);
  $text = "</vypisy>"."\r\n";
  fwrite($soubor, $text);

fclose($soubor);
?>

<br /><br />
<a href="../tmp/<?php echo $nazsubxml; ?>">../tmp/<?php echo $nazsubxml; ?></a>


<?php

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU ING TATRY SYMPATIA
?>

<?php
///////////////////////////////////////////////////VYTVORENIE SUBORU PRE ELEKTRONIKU STABILITA XML
if( $copern == 60 )
{

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub="STABILITA".$kli_vmes.$kli_vxr;


if (File_Exists ("../tmp/$nazsub.xml")) { $soubor = unlink("../tmp/$nazsub.xml"); }

$soubor = fopen("../tmp/$nazsub.xml", "a+");

/////////////NACITANIE UDAJOV O DDP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp WHERE nddp LIKE '%STABILITA%' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_ddp=$riaddok->cddp;
  $ddpvsy=$riaddok->vsy;
  $naznddp=$riaddok->nddp;
  $ddpksy=$riaddok->ksy;
  $ddpssy=1*$riaddok->ssy;
  $ddpucb=$riaddok->uceb;
  $ddpnum=$riaddok->numb;
  }

//pocet poloziek
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";

$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 9 ORDER BY xddp,konx,prie,meno";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 


if( $fir_fico > 0 )
{

$fir_kodddp=$ddpvsy;
$fir_identifikatorddp="1";
$fir_ucetfondu=$ddpucb."/".$ddpnum;

}

if( $ddpssy == 0 ) $ddpssy=$kli_vmes.$kli_vrok;

  $text = "<?xml version = \"1.0\" encoding=\"windows-1250\" ?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<vypisy>"."\r\n";
  fwrite($soubor, $text);
  $text = "<vypis cislo=\"1\" identifikator=\"$fir_identifikatorddp\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<hlavicka produkt=\"DDS\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<organizacia>"."\r\n";
  fwrite($soubor, $text);
  $text = "<kodzamestnavatela>$fir_kodddp</kodzamestnavatela>"."\r\n";
  fwrite($soubor, $text);
  $text = "<kontakt>$fir_ftel</kontakt>"."\r\n";
  fwrite($soubor, $text);      
  $text = "<ico>$fir_fico</ico>"."\r\n";
  fwrite($soubor, $text);  
  $text = "<oj>00</oj>"."\r\n";
  fwrite($soubor, $text);         
  $text = "<vs>$ddpvsy</vs>"."\r\n";
  fwrite($soubor, $text);       
  $text = "<ss>$ddpssy</ss>"."\r\n";
  fwrite($soubor, $text);
  $text = "<nazovorganizacie>$fir_fnaz</nazovorganizacie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<cislouctu>$fir_fuc1/$fir_fnm1</cislouctu>"."\r\n";
  fwrite($soubor, $text);
  $text = "</organizacia>"."\r\n";
  fwrite($soubor, $text);

  $text = "<obdobie>".$kli_vrok.$kli_vmes."</obdobie>"."\r\n";
  fwrite($soubor, $text);
  $text = "<ucetfondu>$fir_ucetfondu</ucetfondu>"."\r\n";
  fwrite($soubor, $text);
  $text = "<pocetviet>$polp</pocetviet>"."\r\n";
  fwrite($soubor, $text);
  $text = " <sumy>"."\r\n";
  fwrite($soubor, $text);

$Cislo=$hlavicka->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavicka->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);

  $text = "<celkovasumaZCZ>$ozam_ddp</celkovasumaZCZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<celkovasumaZTZ>$ofir_ddp</celkovasumaZTZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<celkovasuma>$celk_spolu</celkovasuma>"."\r\n";
  fwrite($soubor, $text);


  $text = "</sumy>"."\r\n";
  fwrite($soubor, $text);
  $text = "<poznamka>OK</poznamka>"."\r\n";
  fwrite($soubor, $text);
  $text = "</hlavicka>"."\r\n";
  fwrite($soubor, $text);

     

  $text = "<vety>"."\r\n";
  fwrite($soubor, $text);




}
$i = $i + 1;
$j = $j + 1;
  }

//polozky

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcddp$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_mzdcisddp".
" ON F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp=F$kli_vxcf"."_mzdcisddp.cddp".
" WHERE F$kli_vxcf"."_mzdprcddp".$kli_uzid.".xddp = $cislo_ddp AND konx = 0 ORDER BY xddp,konx,prie,meno";


$sqlp = mysql_query("$sqltt");
$polp = mysql_num_rows($sqlp);


$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $polp )
  {


  if (@$zaznam=mysql_data_seek($sqlp,$i))
{
$hlavickp=mysql_fetch_object($sqlp);
$cislo=$i+1;

$Cislo=$hlavickp->ofir_np+"";
$ofir_np=sprintf("%0.1f", $Cislo);


  $text = "<veta cislo=\"$cislo\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<zamestnanec>"."\r\n";
  fwrite($soubor, $text);
  $text = "<cisloZCZ>$hlavickp->xczml</cisloZCZ>"."\r\n";
  fwrite($soubor, $text);
  $text = "<meno>$hlavickp->meno</meno>"."\r\n";
  fwrite($soubor, $text);
  $text = "<priezvisko>$hlavickp->prie</priezvisko>"."\r\n";
  fwrite($soubor, $text);
  $text = "<rodnecislo>$hlavickp->rdc$hlavickp->rdk</rodnecislo>"."\r\n";
  fwrite($soubor, $text);
  $text = "</zamestnanec>"."\r\n";
  fwrite($soubor, $text);

  $text = "<prispevky>"."\r\n";
  fwrite($soubor, $text);
  $text = "<prispevok typprispevku=\"N\">"."\r\n";
  fwrite($soubor, $text);
  $text = "<kat3a4>true</kat3a4>"."\r\n";
  fwrite($soubor, $text);          

$Cislo=$hlavickp->ofir_ddp+"";
$ofir_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->ozam_ddp+"";
$ozam_ddp=sprintf("%0.2f", $Cislo);
$Cislo=$hlavickp->celk_spolu+"";
$celk_spolu=sprintf("%0.2f", $Cislo);
           
  $text = "<prispevokZCZ>$ozam_ddp</prispevokZCZ>"."\r\n";
  fwrite($soubor, $text);    
  $text = "<prispevokZTZ>$ofir_ddp</prispevokZTZ>"."\r\n";
  fwrite($soubor, $text);    
            
  $text = "</prispevok>"."\r\n";
  fwrite($soubor, $text);
  $text = "</prispevky>"."\r\n";
  fwrite($soubor, $text);

  $text = "</veta>"."\r\n";
  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }

  $text = "</vety>"."\r\n";
  fwrite($soubor, $text);

  $text = "</vypis>"."\r\n";
  fwrite($soubor, $text);
  $text = "</vypisy>"."\r\n";
  fwrite($soubor, $text);

fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.xml">../tmp/<?php echo $nazsub; ?>.xml</a>


<?php

}
///////////////////////////////////////////////////KONIEC SUBORU PRE ELEKTRONIKU STABILITA
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcddp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
