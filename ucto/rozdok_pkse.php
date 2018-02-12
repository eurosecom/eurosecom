<HTML>
<?php

do
{
$sys = 'FAK';
$urov = 1000;
$copern = $_REQUEST['copern'];
if ( $copern == 5 OR $copern == 6 )
{
$sys = 'DOP';
$urov = 1000;
}

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$copern = $_REQUEST['copern'];

$tlacR=0;
$tlacitR = $_REQUEST['tlacitR'];
if( $tlacitR == 1 ) { $tlacR=1; }


$pksesys = 1*$_REQUEST['pksesys'];
//412ka je 3500001
//411ka je 3600001

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlač-V</title>
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
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana č. &p z &P pata=prazdna
// na sirku okraje vl=15 vp=15 hr=15 dl=15  


if ( $copern == 101 ) $tabl = "fakodb";

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<zozprc
(
   ume         FLOAT(8,4),
   uce         INT,
   dok         DECIMAL(10,0),
   fak         DECIMAL(10,0),
   ico         INT,
   strn        INT,
   zakn        INT,
   agr         INT,
   agr1        DECIMAL(10,4),
   agr2        DECIMAL(10,4),
   dat         DATE,
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   hod         DECIMAL(10,2)
);
zozprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$cislo_uce = 1*$_REQUEST['cislo_uce'];

$podmdok=" ume = $vyb_ume AND dok >= 35000001 AND dok <= 35009999 ";
if( $pksesys == 911 ) { $podmdok=" ume = $vyb_ume AND dok >= 360001 AND dok <= 369999 "; }
if( $pksesys == 914 ) { $podmdok=" ume = $vyb_ume AND dok >= 370001 AND dok <= 379999 "; }

if( $copern == 101 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT ume,uce,dok,fak,ico,0,0,0,0,0,dat,zk0u,".
"zk1u,zk2u,dn1u,dn2u,hodu FROM F$kli_vxcf"."_$tabl WHERE $podmdok ".
" ORDER BY uce,dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_zozprc$kli_uzid".
" SELECT ume,uce,9999999999,fak,ico,0,0,9,0,0,dat,SUM(zk0),".
"SUM(zk1),SUM(zk2),SUM(dn1),SUM(dn2),SUM(hod) FROM F$kli_vxcf"."_zozprc$kli_uzid WHERE dok > 0 ".
" GROUP BY uce ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}


$tabl="zozprc".$kli_uzid;

if ( $copern == 101 )
  {
$sqltt = "SELECT uce, agr, dok, fak, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, F$kli_vxcf"."_$tabl.ico, nai, zk0, zk1, dn1, ".
" zk2, dn2, hod".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE dok > 0 ".
" ORDER BY uce,agr,dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
  }

//exit;

if (File_Exists ("../tmp/zoznam$kli_uzid.pdf")) { $soubor = unlink("../tmp/zoznam$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 



if ( $copern == 101 )
  {
$pdf->Cell(90,5,"Zoznam rozúčtovaných odberateľských faktúr","LTB",0,"L");$pdf->Cell(90,5,"$vyb_ume $vyb_naz","RTB",1,"R");
  }



//hlavicka
if ( $copern == 101 )
  {
$pdf->SetFont('arial','',9);
$pdf->Cell(10,5,"Účet","1",0,"R");
$pdf->Cell(11,5,"Doklad","1",0,"R");$pdf->Cell(18,5,"Faktúra","1",0,"R");$pdf->Cell(13,5,"Dátum","1",0,"R");
$pdf->Cell(40,5,"Odberateľ","1",0,"L");
$pdf->SetFont('arial','',4);
$pdf->Cell(14,5,"Zákl.0% + Zaokrúhl.","1",0,"R");
$pdf->SetFont('arial','',7);
$pdf->Cell(15,5,"Základ $fir_dph1 %","1",0,"R");
$pdf->Cell(14,5,"Daň $fir_dph1 %","1",0,"R");$pdf->Cell(15,5,"Základ $fir_dph2 %","1",0,"R");$pdf->Cell(15,5,"Daň $fir_dph2 %","1",0,"R");
$pdf->Cell(15,5,"Hodnota","1",1,"R");
}



$tvpol = mysql_num_rows($sql);
//echo $tvpol;
//exit;
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$rtov=mysql_fetch_object($sql);
//$dat_sk = SkDatum($rtov->dat);




//celkom
if( $rtov->agr == 9 )
{
//echo "pod";
$pdf->Cell(92,4,"CELKOM  účet $rtov->uce ","0",0,"R");
$pdf->Cell(14,4,"$rtov->zk0","0",0,"R");$pdf->Cell(15,4,"$rtov->zk1","0",0,"R");
$pdf->Cell(14,4,"$rtov->dn1","0",0,"R");$pdf->Cell(15,4,"$rtov->zk2","0",0,"R");$pdf->Cell(15,4,"$rtov->dn2","0",0,"R");
$pdf->Cell(15,4,"$rtov->hod","0",1,"R");
$pdf->Cell(180,4," ","0",1,"R");
}



//tlac zakladneho riadku
if( $rtov->agr == 0 )
     {
$pdf->SetFont('arial','',7);
$pdf->Cell(10,4,"$rtov->uce","0",0,"R");
$pdf->Cell(11,4,"$rtov->dok","0",0,"R");$pdf->Cell(18,4,"$rtov->fak","0",0,"R");$pdf->Cell(13,4,"$rtov->dat","0",0,"R");

$pdf->Cell(40,4,"$rtov->nai","0",0,"L");

$pdf->Cell(14,4,"$rtov->zk0","0",0,"R");$pdf->Cell(15,4,"$rtov->zk1","0",0,"R");
$pdf->Cell(14,4,"$rtov->dn1","0",0,"R");$pdf->Cell(15,4,"$rtov->zk2","0",0,"R");$pdf->Cell(15,4,"$rtov->dn2","0",0,"R");
$pdf->Cell(15,4,"$rtov->hod","0",1,"R");

//tlac rozuctovania
if( $tlacR == 1 )
{

$tablucto="uctodb";

$uctott = "SELECT * FROM F$kli_vxcf"."_$tablucto WHERE dok = $rtov->dok ";
$ucto = mysql_query("$uctott");
$ucpol = mysql_num_rows($ucto);

//echo $rtov->dok;
//exit;

//zaciatok vypisu
$iu=0;
  while ($iu <= $ucpol )
  {

  if (@$zaznam=mysql_data_seek($ucto,$iu))
{
$ructo=mysql_fetch_object($ucto);

$pdf->SetFont('arial','',9);
$pdf->Cell(15,4," ","0",0,"L");$pdf->Cell(15,4,"$ructo->ucm","0",0,"L");$pdf->Cell(15,4,"$ructo->ucd","0",0,"L");$pdf->Cell(10,4,"$ructo->rdp","0",0,"R");
$pdf->Cell(10,4,"$ructo->str","0",0,"R");$pdf->Cell(10,4,"$ructo->zak","0",0,"R");
$pdf->Cell(15,4,"$ructo->hod","0",1,"R");

}
$iu = $iu + 1;
  }

}
$pdf->Cell(15,4," ","0",1,"R");
//koniec tlace rozuctovania 

     }
//koniec tlac zakladneho riadku

}
$i = $i + 1;
  }



$pdf->Output("../tmp/zoznam$kli_uzid.pdf");

//exit;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_zozprc'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

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