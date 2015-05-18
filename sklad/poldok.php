<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];

$cislo_dok = 1*$_REQUEST['cislo_dok'];
$lenjeden=0;
if( $cislo_dok > 0 ) $lenjeden=1;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$tlacR=1;

$cislo_doklady = $_REQUEST['cislo_doklady'];


$ajpoznam=0; $poznampod=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_skldokset$kli_uzid WHERE id = $kli_uzid ORDER BY id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ajpoznam=1*$riaddok->ajpoznam;
  $poznampod=1*$riaddok->poznampod;

  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlaè-V</title>
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

<SCRIPT Language="JavaScript">
    <!--

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }


    // -->
</SCRIPT>

</HEAD>
<BODY class="white" onload="">
<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana è. &p z &P pata=prazdna
// na sirku okraje vl=15 vp=15 hr=15 dl=15  


if ( $drupoh == 1 ) $tabl = "sklpri";
if ( $drupoh == 2 ) $tabl = "sklvyd";
if ( $drupoh == 3 ) $tabl = "sklpre";

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<zozprc
(
   pox         int,
   cpl         int,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         DECIMAL(10,0),
   poz         VARCHAR(80) NOT NULL,
   skl         INT,
   poh         INT(2),
   ico         INT(10),
   fak         DECIMAL(10,0),
   str         INT,
   zak         INT,
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,2),
   hod         DECIMAL(10,2),
   unk         VARCHAR(80) NOT NULL,
   id          DECIMAL(10,0)
);
zozprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$podmdok=" AND ume = $kli_vume ";
if( $lenjeden == 1 ) $podmdok=" AND dok = ".$cislo_dok;


$viacdokladov=0;
$pole = explode("-", $cislo_doklady);
$doklad1=1*$pole[0];
$doklad2=1*$pole[1];
if( $doklad1 > 0 AND $doklad2 > 0 ) 
{
$viacdokladov=1;
$podmdok="AND dok >= ".$doklad1." AND dok <= ".$doklad2;
//$podmdok1="F$kli_vxcf"."_zozprc".$kli_uzid.".dok >= ".$doklad1." AND F$kli_vxcf"."_zozprc".$kli_uzid.".dok <= ".$doklad2;
$lenjeden=0;
}


if( $drupoh == 1 OR $drupoh == 2 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT 1,cpl,ume,dat,dok,poz,skl,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),unk,id ".
" FROM F$kli_vxcf"."_$tabl WHERE cis > 0 $podmdok ".
" ORDER BY dok,cpl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;
}
if( $drupoh == 3 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT 1,cpl,ume,dat,dok,poz,skl,poh,ico,sk2,str,zak,cis,mno,cen,(mno*cen),unk,id ".
" FROM F$kli_vxcf"."_$tabl WHERE cis > 0 $podmdok ".
" ORDER BY dok,cpl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//group za dok
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc".$kli_uzid.
" SELECT 8,cpl,ume,dat,dok,poz,skl,poh,ico,fak,str,zak,cis,SUM(mno),cen,SUM(hod),unk,id FROM F$kli_vxcf"."_zozprc".$kli_uzid." ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");

//group za dok
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc".$kli_uzid.
" SELECT 0,cpl,ume,dat,dok,poz,skl,poh,ico,fak,str,zak,cis,SUM(mno),cen,SUM(hod),unk,id FROM F$kli_vxcf"."_zozprc".$kli_uzid." ".
" GROUP BY dok".
"";
$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc".$kli_uzid.
" SELECT 9,cpl,ume,dat,9999999999,poz,skl,poh,ico,fak,str,zak,cis,SUM(mno),cen,SUM(hod),unk,id FROM F$kli_vxcf"."_zozprc".$kli_uzid." WHERE pox = 1".
" GROUP BY pox".
"";
$dsql = mysql_query("$dsqlt");


if (File_Exists ("../tmp/zoznam$kli_uzid.pdf")) { $soubor = unlink("../tmp/zoznam$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
  {
$sqltt = "SELECT * FROM F$kli_vxcf"."_zozprc".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_zozprc".$kli_uzid.".ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_zozprc".$kli_uzid.".cis=F$kli_vxcf"."_sklcis.cis".
" WHERE dok > 0 $podmdok ".
" ORDER BY dok,pox,cpl";
  }


$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//echo $sqltt;
//exit;

$zostatokeur=0;
$zostatok=0;
$new=0;
$strana=0;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);


//hlavicka strany
if ( $j == 0 )
     {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;

$pdf->SetFont('arial','',10);

if( $lenjeden == 0 AND $viacdokladov == 0 )
{
if ( $drupoh == 1 )  { $pdf->Cell(90,6,"Zoznam príjemok za $kli_vume","LTB",0,"L"); }
if ( $drupoh == 2 )  { $pdf->Cell(90,6,"Zoznam výdajok za $kli_vume","LTB",0,"L"); }
if ( $drupoh == 3 )  { $pdf->Cell(90,6,"Zoznam presunov za $kli_vume","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);

$dat_sk=SkDatum($riadok->dat);

$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"Doklad","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");
$pdf->Cell(10,5,"Pohyb","1",0,"R");
$pdf->Cell(80,5,"Dodávate¾/Odberate¾","1",0,"L");$pdf->Cell(20,5,"Faktúra","1",0,"R");
$pdf->Cell(0,5,"STR/ZÁK","1",1,"R");

}

if( $lenjeden == 0 AND $viacdokladov == 1 )
{
if ( $drupoh == 1 )  { $pdf->Cell(90,6,"Zoznam príjemok $doklad1 / $doklad2","LTB",0,"L"); }
if ( $drupoh == 2 )  { $pdf->Cell(90,6,"Zoznam výdajok $doklad1 / $doklad2","LTB",0,"L"); }
if ( $drupoh == 3 )  { $pdf->Cell(90,6,"Zoznam presunov $doklad1 / $doklad2","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);

$dat_sk=SkDatum($riadok->dat);

$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"Doklad","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");
$pdf->Cell(10,5,"Pohyb","1",0,"R");
$pdf->Cell(80,5,"Dodávate¾/Odberate¾","1",0,"L");$pdf->Cell(20,5,"Faktúra","1",0,"R");
$pdf->Cell(0,5,"STR/ZÁK","1",1,"R");

}


if( $lenjeden == 1 )
{
if ( $drupoh == 1 )  { $pdf->Cell(90,8,"PRÍJEMKA è.$cislo_dok","LTB",0,"L"); }
if ( $drupoh == 2 )  { $pdf->Cell(90,8,"VÝDAJKA è.$cislo_dok","LTB",0,"L"); }
if ( $drupoh == 3 )  { $pdf->Cell(90,8,"PRESUNKA è.$cislo_dok","LTB",0,"L"); }
$pdf->Cell(0,8,"$kli_nxcf strana $strana","RTB",1,"R");

$pdf->SetFont('arial','',8);

$dat_sk=SkDatum($riadok->dat);

if( $drupoh != 3 )
  {
$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");
$pdf->Cell(10,5,"Pohyb","1",0,"R");
$pdf->Cell(80,5,"Dodávate¾/Odberate¾","1",0,"L");$pdf->Cell(20,5,"Faktúra","1",0,"R");
$pdf->Cell(0,5,"Unikód","1",1,"L");
  }
if( $drupoh == 3 )
  {
$pdf->Cell(10,5,"SKL","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");
$pdf->Cell(10,5,"Pohyb","1",0,"R");
$pdf->Cell(80,5,"Presun na sklad","1",0,"L");$pdf->Cell(20,5," ","1",0,"R");
$pdf->Cell(0,5,"Unikód","1",1,"L");
  }
}



$new=0;
     }
//koniec hlavicky j=0



if( $riadok->pox == 0 AND $lenjeden == 0 )
{

$pdf->SetFont('arial','',8);
$dat_sk=SkDatum($riadok->dat);

$pdf->Cell(10,5,"$riadok->skl","1",0,"R");$pdf->Cell(20,5,"$riadok->dok","1",0,"R");$pdf->Cell(20,5,"$dat_sk","1",0,"R");
$pdf->Cell(10,5,"$riadok->poh","1",0,"R");$pdf->Cell(80,5,"$riadok->ico $riadok->nai","1",0,"L");$pdf->Cell(20,5,"$riadok->fak","1",0,"R");
$pdf->Cell(0,5,"$riadok->str / $riadok->zak","1",1,"R");


$pdf->Cell(10,5,"STR","0",0,"R");$pdf->Cell(10,5,"ZAK","0",0,"R");
$pdf->Cell(30,5,"CIS","0",0,"R");$pdf->Cell(60,5,"Názov","0",0,"L");
$pdf->Cell(25,5,"Cena/MJ","0",0,"R");$pdf->Cell(25,5,"Množstvo MJ","0",0,"R");$pdf->Cell(0,5,"Hodnota $mena1","0",1,"R");
}


if( $riadok->pox == 0 AND $lenjeden == 1 )
{

$pdf->SetFont('arial','',8);

if( $drupoh != 3 )
  {
$pdf->Cell(10,5,"$riadok->skl","1",0,"R");$pdf->Cell(20,5,"$dat_sk","1",0,"R");
$pdf->Cell(10,5,"$riadok->poh","1",0,"R");$pdf->Cell(80,5,"$riadok->ico $riadok->nai","1",0,"L");$pdf->Cell(20,5,"$riadok->fak","1",0,"R");
$pdf->Cell(0,5,"$riadok->unk","1",1,"L");
  }
if( $drupoh == 3 )
  {
$pdf->Cell(10,5,"$riadok->skl","1",0,"R");$pdf->Cell(20,5,"$dat_sk","1",0,"R");
$pdf->Cell(10,5,"$riadok->poh","1",0,"R");$pdf->Cell(80,5,"$riadok->fak","1",0,"L");$pdf->Cell(20,5," ","1",0,"R");
$pdf->Cell(0,5,"$riadok->unk","1",1,"L");
  }

$pdf->Cell(0,5," ","0",1,"R");

$pdf->Cell(10,5,"STR","B",0,"R");$pdf->Cell(10,5,"ZAK","B",0,"R");
$pdf->Cell(30,5,"CIS","B",0,"R");$pdf->Cell(60,5,"Názov","B",0,"L");
$pdf->Cell(25,5,"Cena/MJ","B",0,"R");$pdf->Cell(25,5,"Množstvo MJ","B",0,"R");$pdf->Cell(0,5,"Hodnota $mena1","B",1,"R");
}


if( $riadok->pox == 1 AND $lenjeden == 0 )
{

$pdf->SetFont('arial','',8);

if( $ajpoznam == 1 AND $poznampod == 0 AND trim($riadok->poz) != '' ) {

$pdf->Cell(10,5," ","0",0,"R");$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(30,5," ","0",0,"R");$pdf->Cell(60,5,"$riadok->poz","0",1,"L");
$j=$j+1;
                                         }

$pdf->Cell(10,5,"$riadok->str","0",0,"R");$pdf->Cell(10,5,"$riadok->zak","0",0,"R");
$pdf->Cell(30,5,"$riadok->cis","0",0,"R");$pdf->Cell(60,5,"$riadok->nat","0",0,"L");
$pdf->Cell(25,5,"$riadok->cen","0",0,"R");$pdf->Cell(25,5,"$riadok->mno $riadok->mer","0",0,"R");$pdf->Cell(0,5,"$riadok->hod","0",1,"R");

if( $ajpoznam == 1 AND $poznampod == 1 AND trim($riadok->poz) != '' ) {

$pdf->Cell(10,5," ","0",0,"R");$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(30,5," ","0",0,"R");$pdf->Cell(60,5,"$riadok->poz","0",1,"L");
$j=$j+1;
                                         }

}


if( $riadok->pox == 1 AND $lenjeden == 1 )
{

$pdf->SetFont('arial','',8);

if( $ajpoznam == 1 AND $poznampod == 0 AND trim($riadok->poz) != '' ) {

$pdf->Cell(10,5," ","0",0,"R");$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(30,5," ","0",0,"R");$pdf->Cell(60,5,"$riadok->poz","0",1,"L");
$j=$j+1;
                                         }

$pdf->Cell(10,5,"$riadok->str","0",0,"R");$pdf->Cell(10,5,"$riadok->zak","0",0,"R");
$pdf->Cell(30,5,"$riadok->cis","0",0,"R");$pdf->Cell(60,5,"$riadok->nat","0",0,"L");
$pdf->Cell(25,5,"$riadok->cen","0",0,"R");$pdf->Cell(25,5,"$riadok->mno $riadok->mer","0",0,"R");$pdf->Cell(0,5,"$riadok->hod","0",1,"R");

if( $ajpoznam == 1 AND $poznampod == 1 AND trim($riadok->poz) != '' ) {

$pdf->Cell(10,5," ","0",0,"R");$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(30,5," ","0",0,"R");$pdf->Cell(60,5,"$riadok->poz","0",1,"L");
$j=$j+1;
                                         }

}


if( $riadok->pox == 8 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(120,5,"CELKOM doklad $riadok->dok","T",0,"L");
$pdf->Cell(40,5,"$riadok->mno","T",0,"R");$pdf->Cell(20,5," ","T",0,"R");$pdf->Cell(0,5,"$riadok->hod","T",1,"R");

$pdf->Cell(0,5," ","0",1,"R");
$j=$j+1;
}


if( $riadok->pox == 9 AND $lenjeden == 0 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(120,5,"CELKOM všetky doklady","LTB",0,"L");
$pdf->Cell(40,5,"$riadok->mno","TB",0,"R");$pdf->Cell(20,5," ","TB",0,"R");$pdf->Cell(0,5,"$riadok->hod","RTB",1,"R");
$j=$j+1;
}

if( $riadok->pox == 9 AND $lenjeden == 1 )
{

$prie = "";
$meno = "";
$sqlpoktt = "SELECT * FROM klienti WHERE id_klienta=$riadok->id ";
$sqlpok = mysql_query("$sqlpoktt"); 
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
$prie = $riadokpok->priezvisko;
$meno = $riadokpok->meno;
  }

$pdf->SetFont('arial','',9);

$pdf->Cell(0,10," ","0",1,"R");
$pdf->Cell(60,8,"Vystavil(a): $prie $meno","1",0,"L");
$pdf->Cell(60,8,"Vydal:","1",0,"L");$pdf->Cell(0,8,"Prijal:","1",1,"L");
$j=$j+1;
}

}
$i = $i + 1;
$j = $j + 1;
if( $j > 40 ) $j=0;

  }


$kuch=0;
$cislonormy=$cislo_dok-($kli_vxcf*10000);
$sqltt = "SELECT * FROM F$kli_vxcf"."_kuchobjp ".
" LEFT JOIN F$kli_vxcf"."_kuchrecepth".
" ON F$kli_vxcf"."_kuchobjp.rcis=F$kli_vxcf"."_kuchrecepth.crcp".
" LEFT JOIN F$kli_vxcf"."_kuchobjh".
" ON F$kli_vxcf"."_kuchobjp.dok=F$kli_vxcf"."_kuchobjh.dok".
" WHERE F$kli_vxcf"."_kuchobjp.dok = $cislonormy ".
" ORDER BY F$kli_vxcf"."_kuchobjp.dok,druhp,rcis ";

$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kuch=1;
  }


if( $kuch == 1 )
          {

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//echo $sqltt;
//exit;

$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

//hlavicka strany
if ( $j == 0 )
     {

$pdf->Cell(0,5," ","0",1,"C");
$pdf->Cell(0,6,"Stravný list $cislonormy $riadok->txp","0",1,"L");
$pdf->Cell(0,1,"","0",1,"L");

     }
//koniec hlavicky j=0

$vaha=1*$riadok->rmno;
$mnozstvo=1*$riadok->jmno;

$nazov=$riadok->rnaz;

$pdf->Cell(10,5," ","0",0,"L");
$pdf->Cell(30,5,"$vaha $riadok->rmer","0",0,"L"); 


$pdf->Cell(80,5,"$nazov","0",0,"L");
$pdf->Cell(30,5,"$mnozstvo ks","0",0,"R"); 



$pdf->Cell(0,5," ","0",1,"R");


}
$i = $i + 1;
$j = $j + 1;


  }

//if( $kuch == 1 )
          }

$pdf->Output("../tmp/zoznam$kli_uzid.pdf");

//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 
<script type="text/javascript">
  var okno = window.open("../tmp/zoznam<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>