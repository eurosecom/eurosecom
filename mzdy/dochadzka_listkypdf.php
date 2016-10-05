<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 100;
$clsm = 820;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$mail = 1*$_REQUEST['mail'];

//echo $mail;

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

$h_dod = $_REQUEST['h_dod'];
$h_ddo = $_REQUEST['h_ddo'];
$h_hdo = 1*$_REQUEST['h_hdo'];

$h_dod_sql=SqlDatum($h_dod);
$h_ddo_sql=SqlDatum($h_ddo);


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_dochprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_dochprc'.$kli_uzid." ".
" SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE oc >= 0";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_dochprc'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");

if( $drupoh == 1 )
{
$vsql = 'INSERT INTO F'.$kli_vxcf.'_dochprc'.$kli_uzid." ".
" SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND dmxa = 506 AND daod <= '$h_dod_sql' AND dado >= '$h_ddo_sql' ";
$vytvor = mysql_query("$vsql");
}
if( $drupoh == 2 )
{
$vsql = 'INSERT INTO F'.$kli_vxcf.'_dochprc'.$kli_uzid." ".
" SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND ( dmxa = 518 OR dmxa = 520 ) AND daod <= '$h_dod_sql' AND dado >= '$h_ddo_sql' ";
$vytvor = mysql_query("$vsql");
}
if( $drupoh == 3 )
{
$vsql = 'INSERT INTO F'.$kli_vxcf.'_dochprc'.$kli_uzid." ".
" SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND dmxa = 502 AND daod <= '$h_dod_sql' AND dado >= '$h_ddo_sql' ";
$vytvor = mysql_query("$vsql");
}
if( $drupoh == 4 )
{
$vsql = 'INSERT INTO F'.$kli_vxcf.'_dochprc'.$kli_uzid." ".
" SELECT * FROM F$kli_vxcf"."_mzddochadzka WHERE oc = $cislo_oc AND dmxa = 520 AND daod <= '$h_dod_sql' AND dado >= '$h_ddo_sql' ";
$vytvor = mysql_query("$vsql");
}


if( $drupoh == 1 OR $drupoh == 2 )
{
$vsql = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid,F$kli_vxcf"."_mzdkun ".
" SET hodxa=uva, dnixb=dnixa WHERE F$kli_vxcf"."_dochprc$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc ";
$vytvor = mysql_query("$vsql");

$vsql = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid ".
" SET dnixa=hodxb/hodxa WHERE dnixb = 1 ";
$vytvor = mysql_query("$vsql");

}



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Dochádzka PDF</title>
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
<td>EuroSecom  -  Dochádzka PDF 

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if (File_Exists ("../tmp/doch$kli_uzid.pdf") AND $mail == 0 ) { $soubor = unlink("../tmp/doch$kli_uzid.pdf"); }
if (File_Exists ("../tmp/mdoch$kli_uzid.pdf") AND $mail == 1 ) { $soubor = unlink("../tmp/mdoch$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,200";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$neparne=1;

if ( $copern == 10 )
  {
//sumar za oc pred a za
$dsqlt = "UPDATE F$kli_vxcf"."_dochprc$kli_uzid "." SET dmxb=15 ";
$dsql = mysql_query("$dsqlt");

//ume  oc  dmxa  dmxb  daod  dado  dnixa  dnixb  hodxa  hodxb  xtxt  datm  

$sqltt = "SELECT * FROM F$kli_vxcf"."_dochprc$kli_uzid ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_dochprc$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_str.str=F$kli_vxcf"."_mzdkun.stz".
" LEFT JOIN F$kli_vxcf"."_mzddochadzkaset".
" ON F$kli_vxcf"."_dochprc$kli_uzid.oc=F$kli_vxcf"."_mzddochadzkaset.ocx".
" WHERE F$kli_vxcf"."_dochprc$kli_uzid.oc = $cislo_oc ".
" ORDER BY F$kli_vxcf"."_dochprc$kli_uzid.oc ";

  }


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


$nassklad = $riadok->nas;
$pocstavCelkom = $pocstavCelkom + $riadok->pcs;
$Cislo=$pocstavCelkom+"";
$sPocstavCelkom=sprintf("%0.2f", $Cislo);

$prijemCelkom = $prijemCelkom + $riadok->prj;
$Cislo=$prijemCelkom+"";
$sPrijemCelkom=sprintf("%0.2f", $Cislo);

$pocstav = $riadok->pcs;
$Cislo=$pocstav+"";
$sPocstav=sprintf("%0.2f", $Cislo);

$daod_sk=SkDatum($riadok->daod);
$dado_sk=SkDatum($riadok->dado);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

//hlavicka strany
if ( $j == 0 )
     {

//odmailovat
if( $mail == 1 ) { 

  function email($komu, $predmet, $text, $emailodkoho, $hlavicky = ''){

  // pøekódování windows-1250 do iso-8859-2
  $text = StrTr($text,"\x8A\x8D\x8E\x9A\x9D\x9E\xBE\xBC\xA0",
                      "\xA9\xAB\xAE\xB9\xBB\xBE\xB5\xA5\x20");
  $predmet = StrTr($predmet,"\x8A\x8D\x8E\x9A\x9D\x9E\xBE\xBC\xA0",
                      "\xA9\xAB\xAE\xB9\xBB\xBE\xB5\xA5\x20");

  // text do Base64
  //$text = chunk_split(Base64_Encode($text));
  $hlavicky .= "MIME-Version: 1.0\n".
  "Content-Type: text/plain; charset=\"iso-8859-2\"\n".
  "Content-Transfer-Encoding: base64\n";

  // odeslání
  //ok posle ale zakodovane musel som zaremovat kodovanie mail("$komu", "$predmet", "$text", "From: $emailodkoho" );
  mail("$komu", "$predmet", "$text", "From: $emailodkoho" );
  }

if( $drupoh == 1 )
{
$predmet="Ziadost o dovolenku ".$dat_dat;
$text=$riadok->prie." ".$riadok->meno." osè.".$riadok->oc."\n";
$text=$text.$riadok->stz." ".$riadok->nst." "."\n\n";
$text=$text."Žiadam o dovolenku na zotavenie za kalendárny rok ".$kli_vrok."\n";
$text=$text."od ".$daod_sk." do ".$dado_sk." vrátane t.j. ".$riadok->dnixa." pracovných dní."."\n";
$text=$text."Miesto pobytu na dovolenke ".$riadok->mdov."\n";
$hlavicky="";
}
if( $drupoh == 2 OR $drupoh == 4 )
{
$predmet="Ziadost o priepustku ".$dat_dat;
$text=$riadok->prie." ".$riadok->meno." osè.".$riadok->oc."\n";
$text=$text.$riadok->stz." ".$riadok->nst." "."\n\n";
$text=$text."Žiadam o priepustku zo zamestnania ".$riadok->hodxb." hodín na deò ".$daod_sk."\n";
$hlavicky="";
}
if( $drupoh == 3 )
{
$predmet="Ziadost o pracovne volno ".$dat_dat;
$text=$riadok->prie." ".$riadok->meno." osè.".$riadok->oc."\n";
$text=$text.$riadok->stz." ".$riadok->nst." "."\n\n";
$text=$text."Žiadam o pracovné vo¾no ".$riadok->hodxb." hodín na deò ".$daod_sk."\n";
$hlavicky="";
}

$polemail = explode(";", $riadok->mail);
$mail1=$polemail[0];
$mail2=$polemail[1];
$mail3=$polemail[2];
$mail4=$polemail[3];

$mail1=str_replace(" ","",$mail1);
$mail2=str_replace(" ","",$mail2);
$mail3=str_replace(" ","",$mail3);
$mail4=str_replace(" ","",$mail4);
$dlzkamail1=strlen($mail1);
$dlzkamail2=strlen($mail2);
$dlzkamail3=strlen($mail3);
$dlzkamail4=strlen($mail4);

if( $dlzkamail1 > 8 ) email( $mail1, $predmet, $text, $riadok->zema  );
if( $dlzkamail2 > 8 ) email( $mail2, $predmet, $text, $riadok->zema  );
if( $dlzkamail3 > 8 ) email( $mail3, $predmet, $text, $riadok->zema  );
if( $dlzkamail4 > 8 ) email( $mail4, $predmet, $text, $riadok->zema  );

                 }
//koniec odmailovat

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/mzdy_listky/dovolenka.jpg') AND $drupoh == 1 )
{
$pdf->Image('../dokumenty/mzdy_listky/dovolenka.jpg',8,8,130,80);
}

if (File_Exists ('../dokumenty/mzdy_listky/priepustka.jpg') AND ( $drupoh == 2 OR $drupoh == 4 ))
{
$pdf->Image('../dokumenty/mzdy_listky/priepustka.jpg',8,8,130,80);
}

if (File_Exists ('../dokumenty/mzdy_listky/volno.jpg') AND $drupoh == 3 )
{
$pdf->Image('../dokumenty/mzdy_listky/volno.jpg',8,8,130,80);
}

//if ( $copern == 10 AND $drupoh == 1)  { $pdf->Cell(90,6,"Dovolenka ","LTB",0,"L"); }
//if ( $copern == 10 AND $drupoh == 2)  { $pdf->Cell(90,6,"Priepustka lekár","LTB",0,"L"); }
//if ( $copern == 10 AND $drupoh == 3)  { $pdf->Cell(90,6,"Volno ","LTB",0,"L"); }
//if ( $copern == 10 AND $drupoh == 4)  { $pdf->Cell(90,6,"Priepustka iné","LTB",0,"L"); }

//$pdf->Cell(0,6,"$kli_nxcf","RTB",1,"R");

$pdf->SetFont('arial','',6);

if( $copern == 10 )
{

}


     }
//koniec hlavicky j=0



if( $drupoh == 1 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(0,12," ","0",1,"L");
$pdf->Cell(100,5,"$riadok->prie $riadok->meno  $riadok->titl","0",0,"L");$pdf->Cell(0,5,"$riadok->oc","0",1,"L");
$pdf->Cell(0,2," ","0",1,"L");
$pdf->Cell(100,5,"$riadok->nst","0",0,"L");$pdf->Cell(0,5,"$riadok->stz","0",1,"L");

$pdf->Cell(0,1," ","0",1,"L");
$pdf->Cell(89,4," ","0",0,"L");$pdf->Cell(0,4,"$kli_vrok","0",1,"L");

$pdf->Cell(10,5," ","0",0,"L");
$pdf->Cell(40,5,"$daod_sk","0",0,"L");$pdf->Cell(44,5,"$dado_sk","0",0,"L");$pdf->Cell(30,5,"$riadok->dnixa","0",0,"L");$pdf->Cell(0,5," ","0",1,"L");

$pdf->Cell(40,4," ","0",0,"L");$pdf->Cell(0,4,"$riadok->mdov","0",1,"L");
$pdf->Cell(15,5," ","0",0,"L");$pdf->Cell(44,5,"$dat_dat","0",1,"L");



$odkaz="../mzdy/dochadzka_listkypdf.php?copern=".$copern."&drupoh=".$drupoh."&cislo_oc=".$cislo_oc."&mail=1&h_dod=".$h_dod."&h_ddo=".$h_ddo."";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/mzdy/dochadzka_listkypdf.php?copern=".$copern."&drupoh=".$drupoh."&cislo_oc=".$cislo_oc."&mail=1&h_dod=".$h_dod."&h_ddo=".$h_ddo."";
                               }
$pdf->Cell(0,35," ","0",1,"L");

}


if( $drupoh == 2 OR $drupoh == 4 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(0,30," ","0",1,"L");
$pdf->Cell(10,5," ","0",0,"L");$pdf->Cell(100,5,"$riadok->prie $riadok->meno  $riadok->titl osè. $riadok->oc","0",1,"L");


$pdf->Cell(40,5," ","0",0,"L");$pdf->Cell(40,5,"$daod_sk","0",1,"L");
$pdf->Cell(0,5," ","0",1,"L");
$pdf->Cell(10,5," ","0",0,"L");$pdf->Cell(100,5,"$riadok->dovv","0",1,"L");



$odkaz="../mzdy/dochadzka_listkypdf.php?copern=".$copern."&drupoh=".$drupoh."&cislo_oc=".$cislo_oc."&mail=1&h_dod=".$h_dod."&h_ddo=".$h_ddo."";

$pdf->Cell(0,37," ","0",1,"L");
$pdf->Cell(6,5," ","0",0,"L");

}


if( $drupoh == 3 )
{

$pdf->SetFont('arial','',9);

$pdf->Cell(0,13," ","0",1,"L");
$pdf->Cell(35,5," ","0",0,"L");
$pdf->Cell(65,5,"$riadok->prie $riadok->meno  $riadok->titl","0",0,"L");$pdf->Cell(0,5,"$riadok->oc","0",1,"L");

$pdf->Cell(18,5," ","0",0,"L");
$pdf->Cell(82,5,"$riadok->nst","0",0,"L");$pdf->Cell(0,5,"$riadok->stz","0",1,"L");

$pdf->Cell(50,5," ","0",0,"L");
$pdf->Cell(58,5,"$daod_sk","0",0,"L");$pdf->Cell(40,5,"$riadok->hodxb","0",1,"L");

$pdf->Cell(0,1," ","0",1,"L");
$pdf->Cell(20,4," ","0",0,"L");$pdf->Cell(0,4,"$riadok->dovv","0",1,"L");

$pdf->Cell(0,10," ","0",1,"L");
$pdf->Cell(8,5," ","0",0,"L");$pdf->Cell(40,5,"$fir_fmes","0",0,"L");$pdf->Cell(44,5,"$dat_dat","0",1,"L");



$odkaz="../mzdy/dochadzka_listkypdf.php?copern=".$copern."&drupoh=".$drupoh."&cislo_oc=".$cislo_oc."&mail=1&h_dod=".$h_dod."&h_ddo=".$h_ddo."";


$pdf->Cell(0,30," ","0",1,"L");
$pdf->Cell(6,5," ","0",0,"L");

}



if( $mail == 0 ) { $pdf->Cell(160,5,"Odmailova z $riadok->zema na $riadok->mail","1",1,"L",0,$odkaz); }
if( $mail == 1 ) { $pdf->Cell(130,5,"Odmailované $dat_dat z $riadok->zema na $riadok->mail","0",1,"L",0,$odkaz); }






}
$i = $i + 1;
$j = $j + 1;
if( $j > 48 ) $j=0;

  }

//echo $mail;

if( $mail == 0 ) { $pdf->Output("../tmp/doch.$kli_uzid.pdf"); }
if( $mail == 1 ) { $pdf->Output("../tmp/mdoch.$kli_uzid.pdf"); }

if( $mail == 0 ) { 
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/doch.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
                 }

if( $mail == 1 ) { 
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/mdoch.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php
                 }

?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
