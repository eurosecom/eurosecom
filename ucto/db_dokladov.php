<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$clsm = 900;
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
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$hladaj_uce = 1*$_REQUEST['hladaj_uce'];
$unk = $_REQUEST['unk'];
$subor = 1*$_REQUEST['subor'];

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$sql = "SELECT pdok FROM F".$kli_vxcf."_uctdb_dokladov ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctdb_dokladov SELECT * FROM F'.$kli_vxcf.'_uctvsdp ';
//echo $vsql;
$vytvor = mysql_query("$vsql");

$sql = "TRUNCATE TABLE F$kli_vxcf"."_uctdb_dokladov ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctdb_dokladov ADD pdok VARCHAR(90) NOT NULL AFTER dok";
$vysledek = mysql_query("$sql");
}

///////uloz do databazy
if( $copern == 1 )
{
$new_dok=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdb_dokladov WHERE dok < 99001 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $new_dok=$riaddok->dok+1;
  }
if( $new_dok == 0 ) $new_dok=1;

//popis dokladu
$pdok="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdh WHERE dok = $cislo_dok");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pdok=$riaddok->txp;
  }


$unk=trim($unk);
//echo $unk." koniec";

if( $unk == 'NEDOK' )
{
//echo "idem";
$new_dok=99001;

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctdb_dokladov  WHERE dok = $new_dok ";
$dsql = mysql_query("$dsqlt");

}

// dok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdb_dokladov ".
" SELECT $new_dok,'$pdok',".
"poh,0,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,$kli_uzid,now() ".
" FROM F$kli_vxcf"."_uctvsdp ".
" WHERE dok = $cislo_dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
///////koniec uloz do databazy


///////zmaz z databazy
if( $copern == 80 )
{
$vloz_dok = 1*$_REQUEST['vloz_dok'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctdb_dokladov WHERE dok = $vloz_dok ";
$dsql = mysql_query("$dsqlt");

}
///////koniec zmaz z databazy

///////tlac z databazy
if( $copern == 50 )
{
$vloz_dok = 1*$_REQUEST['vloz_dok'];

if (File_Exists ("../tmp/podklad$kli_uzid.pdf")) { $soubor = unlink("../tmp/podklad$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$sqlt = "DROP TABLE F".$kli_vxcf."_tlacdok".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = "CREATE TABLE F".$kli_vxcf."_tlacdok".$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctdb_dokladov WHERE dok=$vloz_dok ";
$vytvor = mysql_query("$vsql");

//dok  pdok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm  

$dsqlt = "UPDATE F".$kli_vxcf."_tlacdok".$kli_uzid." SET poh=0 ";
$dsql = mysql_query("$dsqlt");


if( $subor == 0 ){

$dsqlt = "INSERT INTO F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" SELECT $vloz_dok,pdok,".
"99,0,ucm,ucd,rdp,dph,SUM(hod),hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,$kli_uzid,now() ".
" FROM F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" WHERE dok = $vloz_dok GROUP BY poh";
$dsql = mysql_query("$dsqlt");
                 }

if( $subor == 1 ){

$dsqlt = "INSERT INTO F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" SELECT $vloz_dok,pdok,".
"98,0,ucm,ucd,rdp,dph,SUM(hod),hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,$kli_uzid,now() ".
" FROM F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" WHERE dok = $vloz_dok GROUP BY ucm";
$dsql = mysql_query("$dsqlt");
                 }

if( $subor == 2 ){

$dsqlt = "INSERT INTO F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" SELECT $vloz_dok,pdok,".
"97,0,ucm,ucd,rdp,dph,SUM(hod),hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,$kli_uzid,now() ".
" FROM F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" WHERE dok = $vloz_dok GROUP BY ucm";
$dsql = mysql_query("$dsqlt");
                 }

if( $subor == 3 ){

$dsqlt = "INSERT INTO F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" SELECT $vloz_dok,pdok,".
"96,0,ucm,ucd,rdp,dph,SUM(hod),hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,$kli_uzid,now() ".
" FROM F".$kli_vxcf."_tlacdok".$kli_uzid." ".
" WHERE dok = $vloz_dok GROUP BY str,zak";
$dsql = mysql_query("$dsqlt");
                 }


$sqltt = "SELECT * FROM F".$kli_vxcf."_tlacdok".$kli_uzid." WHERE dok = $vloz_dok ORDER BY poh,cpl";
if( $subor == 1 ){ $sqltt = "SELECT * FROM F".$kli_vxcf."_tlacdok".$kli_uzid." WHERE dok = $vloz_dok ORDER BY ucm,poh,ucd,str,zak ";  }
if( $subor == 2 ){ $sqltt = "SELECT * FROM F".$kli_vxcf."_tlacdok".$kli_uzid." WHERE dok = $vloz_dok ORDER BY ucd,poh,ucm,str,zak ";  }
if( $subor == 3 ){ $sqltt = "SELECT * FROM F".$kli_vxcf."_tlacdok".$kli_uzid." WHERE dok = $vloz_dok ORDER BY str,zak,poh,ucm,ucd ";  }

//echo $sqltt;
//exit;
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

//exit;

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

$pdf->SetFont('arial','',10);

$pdf->Cell(20,5,"doklad","1",0,"R");$pdf->Cell(20,5,"ucm","1",0,"L");$pdf->Cell(20,5,"ucd","1",0,"L");
$pdf->Cell(20,5,"str","1",0,"L");$pdf->Cell(20,5,"zak","1",0,"L");
$pdf->Cell(20,5,"hodnota","1",0,"R");
$pdf->Cell(0,5,"popis","1",1,"L");
     }

if ( $riadok->poh == 0 )
     {
$pdf->Cell(20,5,"$riadok->dok","0",0,"R");$pdf->Cell(20,5,"$riadok->ucm","0",0,"L");$pdf->Cell(20,5,"$riadok->ucd","0",0,"L");
$pdf->Cell(20,5,"$riadok->str","0",0,"L");$pdf->Cell(20,5,"$riadok->zak","0",0,"L");
$pdf->Cell(20,5,"$riadok->hod","0",0,"R");
$pdf->Cell(0,5,"$riadok->pop","0",1,"L");
     }

if ( $riadok->poh == 99 )
     {
$pdf->Cell(100,5,"SPOLU všetko","T",0,"L");
$pdf->Cell(20,5,"$riadok->hod","T",0,"R");
$pdf->Cell(0,5," ","T",1,"L");
     }

if ( $riadok->poh == 98 )
     {
$pdf->Cell(100,5,"SPOLU ucm","T",0,"L");
$pdf->Cell(20,5,"$riadok->hod","T",0,"R");
$pdf->Cell(0,5," ","T",1,"L");
     }
if ( $riadok->poh == 97 )
     {
$pdf->Cell(100,5,"SPOLU ucd","T",0,"L");
$pdf->Cell(20,5,"$riadok->hod","T",0,"R");
$pdf->Cell(0,5," ","T",1,"L");
     }
if ( $riadok->poh == 96 )
     {
$pdf->Cell(100,5,"SPOLU str,zak","T",0,"L");
$pdf->Cell(20,5,"$riadok->hod","T",0,"R");
$pdf->Cell(0,5," ","T",1,"L");
     }


}
$i = $i + 1;
$j = $j + 1;

  }


$pdf->Output("../tmp/podklad.$kli_uzid.pdf");

$sqlt = "DROP TABLE F".$kli_vxcf."_tlacdok".$kli_uzid;
$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/podklad.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php

}
///////koniec tlac z databazy


///////vloz do dokladu
if( $copern == 20 )
{
$vloz_dok = 1*$_REQUEST['vloz_dok'];
// dok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvsdp ".
" SELECT $cislo_dok,".
"poh,0,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,$kli_uzid,now() ".
" FROM F$kli_vxcf"."_uctdb_dokladov ".
" WHERE dok = $vloz_dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;
?>

<script type="text/javascript">

window.open('vspk_u.php?cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=7&drupoh=5&page=1&subor=0',
 '_self', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

</script>

<?php
}
///////koniec vloz do dokladu



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>DATABÁZA DOKLADOV</title>
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

function TlacDok( dok )
                {

window.open('db_dokladov.php?vloz_dok=' + dok + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=50&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDokUcm( dok )
                {

window.open('db_dokladov.php?vloz_dok=' + dok + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=50&drupoh=1&page=1&subor=1',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDokUcd( dok )
                {

window.open('db_dokladov.php?vloz_dok=' + dok + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=50&drupoh=1&page=1&subor=2',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacDokZak( dok )
                {

window.open('db_dokladov.php?vloz_dok=' + dok + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=50&drupoh=1&page=1&subor=3',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
    
function ZmazDok( dok )
                {

window.open('db_dokladov.php?vloz_dok=' + dok + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=80&drupoh=1&page=1&subor=0',
 '_self', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function VlozDok( dok )
                {

window.open('db_dokladov.php?vloz_dok=' + dok + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=20&drupoh=1&page=1&subor=0',
 '_self', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Spat( dok )
                {

window.open('vspk_u.php?cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=7&drupoh=5&page=1&subor=0',
 '_self', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  DATABÁZA DOKLADOV

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctdb_dokladov GROUP BY dok";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);


$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {

if ( $j == 0 )
      {
?>

<table class="vstup" width="100%" >

<tr>
<td class="bmenu" colspan="3">
<a href="#" onClick="Spat(<?php echo $polozka->dok;?>);">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Návrat spä do dokladu <?php echo $cislo_dok;?>' ></a>

<tr>
<td class="bmenu" width="10%">Doklad</td>
<td class="bmenu" width="70%" align="left">Popis dokladu</td>
<td class="bmenu" width="10%"> </td>
<td class="bmenu" width="10%"> </td>
</tr>

<?php
      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

$h_hotp=0;
$h_hotv=0;
$h_hotp=$polozka->hotp;
$h_hotv=$polozka->hotv;

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

$hvstup="hvstup";

?>

<tr>
<td class="<?php echo $hvstup; ?>" align="right">
<?php echo $polozka->dok; ?> 
</td>

<td class="<?php echo $hvstup; ?>">
<?php echo $polozka->pdok; ?></td>


<td class="<?php echo $hvstup; ?>">

<a href="#" onClick="TlacDok(<?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi zaúètovanie dokladu <?php echo $polozka->dok;?> vo formáte PDF' ></a>

<a href="#" onClick="TlacDokUcm(<?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi zaúètovanie dokladu <?php echo $polozka->dok;?> zotriedené pod¾a UCM vo formáte PDF' ></a>

<a href="#" onClick="TlacDokUcd(<?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi zaúètovanie dokladu <?php echo $polozka->dok;?> zotriedené pod¾a UCD vo formáte PDF' ></a>

<a href="#" onClick="TlacDokZak(<?php echo $polozka->dok;?>);">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi zaúètovanie dokladu <?php echo $polozka->dok;?> zotriedené pod¾a STR,ZÁK vo formáte PDF' ></a>


<td class="<?php echo $hvstup; ?>">

<a href="#" onClick="VlozDok(<?php echo $polozka->dok;?>);">
<img src='../obr/import.png' width=20 height=15 border=0 title='Vloži zaúètovanie do dokladu <?php echo $cislo_dok;?>' ></a>

<a href="#" onClick="ZmazDok(<?php echo $polozka->dok;?>);">
<img src='../obr/zmaz.png' width=20 height=15 border=0 title='Zmaza doklad <?php echo $polozka->dok;?>' ></a>

</tr>

<?php
}



$i = $i + 1;
$j = $j + 1;
  }

//koniec poloziek

?>


<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
