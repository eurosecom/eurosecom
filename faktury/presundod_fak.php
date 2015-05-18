<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kopia_dok = 1*strip_tags($_REQUEST['kopia_dok']);

$karta = 1*$_REQUEST['karta'];

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$tl10 = 1*$_REQUEST['tl10'];
$tl11 = 1*$_REQUEST['tl11'];
$tl12 = 1*$_REQUEST['tl12'];
$tl13 = 1*$_REQUEST['tl13'];
$tl14 = 1*$_REQUEST['tl14'];
$tl15 = 1*$_REQUEST['tl15'];
$tl16 = 1*$_REQUEST['tl16'];
$tl17 = 1*$_REQUEST['tl17'];
$tl18 = 1*$_REQUEST['tl18'];
$tl19 = 1*$_REQUEST['tl19'];


$tlxx=$tl10;

if( $tlxx == 0 ) { $tlxx=$tl11; }
if( $tlxx == 0 ) { $tlxx=$tl12; }
if( $tlxx == 0 ) { $tlxx=$tl13; }
if( $tlxx == 0 ) { $tlxx=$tl14; }
if( $tlxx == 0 ) { $tlxx=$tl15; }
if( $tlxx == 0 ) { $tlxx=$tl16; }
if( $tlxx == 0 ) { $tlxx=$tl17; }
if( $tlxx == 0 ) { $tlxx=$tl18; }
if( $tlxx == 0 ) { $tlxx=$tl19; }

if( $tlxx == 0 ) { echo "Nem·te oznaËenÈ ûiadne dodacie listy !"; exit; }

if( $tl10 > 0 ) { $txdod=$txdod." - ".$tl10; }
if( $tl11 > 0 ) { $txdod=$txdod." - ".$tl11; }
if( $tl12 > 0 ) { $txdod=$txdod." - ".$tl12; }
if( $tl13 > 0 ) { $txdod=$txdod." - ".$tl13; }
if( $tlxx == 0 AND $tl14 > 0 ) { $txdod=$txdod." - ".$tl14; }
if( $tlxx == 0 AND $tl15 > 0 ) { $txdod=$txdod." - ".$tl15; }
if( $tlxx == 0 AND $tl16 > 0 ) { $txdod=$txdod." - ".$tl16; }
if( $tlxx == 0 AND $tl17 > 0 ) { $txdod=$txdod." - ".$tl17; }
if( $tlxx == 0 AND $tl18 > 0 ) { $txdod=$txdod." - ".$tl18; }
if( $tlxx == 0 AND $tl19 > 0 ) { $txdod=$txdod." - ".$tl19; }




if ( $copern == 20 )
        {
?>
<script type="text/javascript">
if( !confirm ("Chcete vytvoriù fakt˙ru \r z vybran˝ch dodacÌch listov <?php echo $txdod; ?> ?") )
         { location.href='vstfak.php?copern=1&drupoh=11&page=1&page=1';  }

else
         { location.href='presundod_fak.php?copern=2&tl10=<?php echo $tl10; ?>&tl11=<?php echo $tl11; ?>&tl12=<?php echo $tl12; ?>';  }

</script>
<?php
exit;
        }


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$maxdok=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok > 0 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_dok=$riaddok->dok+1;
  $uce=1*$riaddok->uce;
  }

//fakdol  uce  ume  dat  dav  das  daz  dok  doq  skl  poh  ico  fak  dol  prf  obj  unk  dpr  ksy  ssy  poz  str  zak  txz  txp  zk0  zk1  zk2  zk3  zk4  
//dn1  dn2  dn3  dn4  sp1  sp2  sz1  sz2  sz3  sz4  hod  hodm  kurz  mena  zmen  odbm  zal  zao  ruc  uhr  id  datm  


//fakodb uce  ume  dat  dav  das  daz  dok  doq  skl  poh  ico  fak  dol  prf  obj  unk  dpr  ksy  ssy  poz  str  zak  txz  txp  
//zk0  zk1  zk2  zk3  zk4  dn1  dn2  dn3  dn4  sp1  sp2  sz1  sz2  sz3  sz4  zk0u  zk1u  zk2u  dn1u  dn2u  sp0u  sp1u  sp2u  hodu  hod  
//hodm  kurz  mena  zmen  odbm  zal  zao  ruc  uhr  id  datm 


$dnes_sql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

$pole = explode("-", $dnes_sql);
$kli_vmesx=$pole[1];
$kli_vrokx=$pole[0];

$ume=$kli_vmesx.".".$kli_vrokx;


$kopia_dok=0;
  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdol WHERE dok = $tlxx ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kopia_dok=1*$riaddok->dok;
  }


$textp="Fakt˙rujeme V·m dodacie listy ".$txdod;


$dsqlt = "INSERT INTO F$kli_vxcf"."_fakodb SELECT ".
" $uce,$ume,'$dnes_sql','','$dnes_sql',dat,$cislo_dok,$cislo_dok,0,0,ico,$cislo_dok,$kopia_dok,'','','','','','','',0,0,'','$textp', ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,'',0,0,0,0,0,0, ".
" $kli_uzid,now()  ".
" FROM F$kli_vxcf"."_fakdol ".
" WHERE dok=$kopia_dok ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$i=0;
          
  while ($i < 10 )
  {

if( $i == 0 ) { $kopia_dok=$tl10; }
if( $i == 1 ) { $kopia_dok=$tl11; }
if( $i == 2 ) { $kopia_dok=$tl12; }
if( $i == 3 ) { $kopia_dok=$tl13; }
if( $i == 4 ) { $kopia_dok=$tl14; }
if( $i == 5 ) { $kopia_dok=$tl15; }
if( $i == 6 ) { $kopia_dok=$tl16; }
if( $i == 7 ) { $kopia_dok=$tl17; }
if( $i == 8 ) { $kopia_dok=$tl18; }
if( $i == 9 ) { $kopia_dok=$tl19; }


if( $kopia_dok > 0 )
          {

//sklfak  cpl  ume  dat  dok  doq  skl  poh  ico  fak  unk  dol  prf  poz  str  zak  cis  nat  dph  mer  pop  mno  cen  cep  ced  id  sk2  datm  me2  mn2   

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklfak "." SELECT".
" 0,$ume,'$dnes_sql',$cislo_dok,$cislo_dok,skl,51,ico,$cislo_dok,cpl,$kopia_dok,'',poz,str,zak,cis,nat,dph,mer,pop,mno,cen,cep,ced,$kli_uzid,0,now(),me2,mn2  ".
" FROM F$kli_vxcf"."_sklfak".
" WHERE F$kli_vxcf"."_sklfak.dok=$kopia_dok ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

//oznac
$dsqlt = "UPDATE F$kli_vxcf"."_fakdol "." SET ".
" txp=CONCAT(txp, ' - fakt˙rovanÈ Ë.', '$cislo_dok'  ), fak=$cislo_dok ".
" WHERE F$kli_vxcf"."_fakdol.dok=$kopia_dok ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$uctujdodacie=0;
  $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcph WHERE poh = 62 AND nph LIKE '%dodac%' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uctujdodacie=1;
  }

if( $uctujdodacie == 0 )
     {
$dsqlt = "UPDATE F$kli_vxcf"."_sklfak "." SET fak=$cislo_dok, unk=mno WHERE F$kli_vxcf"."_sklfak.dok=$kopia_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklfak "." SET mno=0 WHERE F$kli_vxcf"."_sklfak.dok=$kopia_dok ";
$dsql = mysql_query("$dsqlt");
     }

if( $uctujdodacie == 1 )
     {
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklfak "." SELECT".
" 0,$ume,'$dnes_sql',$kopia_dok,$kopia_dok,skl,62,ico,$cislo_dok,cpl,$kopia_dok,'','',str,zak,cis,nat,dph,mer,pop,(-1*mno),cen,cep,ced,$kli_uzid,0,now(),me2,mn2  ".
" FROM F$kli_vxcf"."_sklfak".
" WHERE F$kli_vxcf"."_sklfak.dok=$kopia_dok ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

     }

          }

$i = $i + 1;
  }


//zaklady a zaokruhli
$sqlttt = "DROP TABLE F$kli_vxcf"."_faksluprc$kli_uzid  ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "CREATE TABLE F$kli_vxcf"."_faksluprc$kli_uzid SELECT * FROM F$kli_vxcf"."_sklfak WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "ALTER TABLE F$kli_vxcf"."_faksluprc$kli_uzid ADD hodb DECIMAL(10,2) DEFAULT 0 AFTER datm ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE F$kli_vxcf"."_faksluprc$kli_uzid SET hodb=cep*mno ";
$sqldok = mysql_query("$sqlttt");

$zaklad2s=0;
$sqlttt = "SELECT SUM(hodb) AS zaklad2s FROM F$kli_vxcf"."_faksluprc$kli_uzid WHERE dok = $cislo_dok AND dph > 0 GROUP BY dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad2s=1*$riaddok->zaklad2s;
  }

$zaklad0s=0;
$sqlttt = "SELECT SUM(hodb) AS zaklad0s FROM F$kli_vxcf"."_faksluprc$kli_uzid WHERE dok = $cislo_dok AND dph = 0 GROUP BY dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad0s=1*$riaddok->zaklad2s;
  }

$sqlttt = "UPDATE F$kli_vxcf"."_fakodb SET zk2=$zaklad2s, zk0=$zaklad0s WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt"); 

$sZao = include("../funkcie/zaokruhli_hod.php");
$sZad = include("../funkcie/zaokruhli_dph.php");

$tabl="fakodb";
$vyb_rok=$kli_vrok;

$zad = zaokruhli_dph("1", $kli_vxcf, $tabl, $cislo_dok, $vyb_rok);
$zao = zaokruhli_hod($fir_xfa02, $kli_vxcf, $tabl, $cislo_dok);

//vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=31100&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT
//&cislo_dok=710001&h_fak=710001&h_dol=0&h_prf=0'
//exit;
?> 
<script type="text/javascript">
  var okno = window.open("../faktury/vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&hladaj_uce=<?php echo $uce; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT","_self");
</script>
<?php 


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Presun DOD do FAK</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

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
<td>EuroSecom  -  Presun DOD do FAK

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
