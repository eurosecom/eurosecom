<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

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

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$cislo_koc = 1*$_REQUEST['cislo_koc'];
$cislo_kcpl = 1*$_REQUEST['cislo_kcpl'];
$subor = $_REQUEST['subor'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//novy doklad
if ( $copern == 40 )
    {
$dat_dat = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

if( $cislo_oc > 0 )
     {
$sqty = "INSERT INTO F$kli_vxcf"."_personal_dok ( oc,typ,kedy,popis )".
" VALUES ('$cislo_oc', 1, ".
" '$dat_dat', 'nov˝ pr·zdny dokument' );"; 
$ulozene = mysql_query("$sqty");

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_personal_dok ORDER BY cpl DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_cpl=$riaddok->cpl;
  $cislo_oc=$riaddok->oc;
  }
     }

if( $cislo_oc == 0 )
     {
$sqty = "INSERT INTO personal_dok ( oc,typ,kedy,popis )".
" VALUES ('$cislo_oc', 1, ".
" '$dat_dat', 'nov˝ pr·zdny dokument' );"; 
$ulozene = mysql_query("$sqty");

$sqldok = mysql_query("SELECT * FROM personal_dok ORDER BY cpl DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_cpl=$riaddok->cpl;
  $cislo_oc=$riaddok->oc;
  }
     }

$copern=20;
$subor=1;
    }
//koniec znovu nacitaj

//skopiruj udaje
if ( $copern == 27 )
    {
if( $cislo_koc > 0 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_personal_dok".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_personal_dok.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_personal_dok.oc = $cislo_koc AND cpl = $cislo_kcpl ORDER BY cpl";
}

if( $cislo_koc == 0 )
{
$sqlfir = "SELECT * FROM personal_dok".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON personal_dok.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE personal_dok.oc = $cislo_koc AND cpl = $cislo_kcpl ORDER BY cpl";
}

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$kop_oc = $fir_riadok->oc;
$kop_cpl = $fir_riadok->cpl;
$kop_meno = $fir_riadok->meno;
$kop_prie = $fir_riadok->prie;
$kop_titl = $fir_riadok->titl;

$kop_typ = $fir_riadok->typ;
$kop_kedy = $fir_riadok->kedy;
$kop_kedysk=SkDatum($kedy);
$kop_popis = $fir_riadok->popis;
$kop_nazov = $fir_riadok->nazov;
$kop_paragraf = $fir_riadok->paragraf;
$kop_text1 = $fir_riadok->text1;
$kop_text2 = $fir_riadok->text2;
$kop_pozn = $fir_riadok->pozn;

if( $cislo_oc > 0 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_personal_dok SET ".
" typ='$kop_typ',  nazov='$kop_nazov', paragraf='$kop_paragraf', text1='$kop_text1', text2='$kop_text2', popis='$kop_popis' ".
" ".
" WHERE oc = $cislo_oc AND cpl = $cislo_cpl "; 
}
if( $cislo_oc == 0 )
{
$uprtxt = "UPDATE personal_dok SET ".
" typ='$kop_typ',  nazov='$kop_nazov', paragraf='$kop_paragraf', text1='$kop_text1', text2='$kop_text2', popis='$kop_popis' ".
" ".
" WHERE oc = $cislo_oc AND cpl = $cislo_cpl "; 
}
$upravene = mysql_query("$uprtxt");

$copern=20;
    }
//koniec kopirovania udajov



// zapis upravene udaje
if ( $copern == 23 )
    {


$oc = 1*$_REQUEST['oc'];
$typ = strip_tags($_REQUEST['typ']);
$kedy = strip_tags($_REQUEST['kedy']);
$kedysql=SqlDatum($kedy);
$nazov = strip_tags($_REQUEST['nazov']);
$paragraf = strip_tags($_REQUEST['paragraf']);
$text1 = strip_tags($_REQUEST['text1']);
$text2 = strip_tags($_REQUEST['text2']);
$popis = strip_tags($_REQUEST['popis']);
$pozn = strip_tags($_REQUEST['pozn']);

if( $cislo_oc > 0 )
{
$uprtxt = "UPDATE F$kli_vxcf"."_personal_dok SET ".
" typ='$typ', kedy='$kedysql', kedy='$kedysql', nazov='$nazov', paragraf='$paragraf', text1='$text1', text2='$text2', popis='$popis', ".
" pozn='$pozn' ".
" WHERE oc = $cislo_oc AND cpl = $cislo_cpl "; 
}
if( $cislo_oc == 0 )
{
$uprtxt = "UPDATE personal_dok SET ".
" typ='$typ', kedy='$kedysql', kedy='$kedysql', nazov='$nazov', paragraf='$paragraf', text1='$text1', text2='$text2', popis='$popis', ".
" pozn='$pozn' ".
" WHERE oc = $cislo_oc AND cpl = $cislo_cpl "; 
}



$upravene = mysql_query("$uprtxt");  
$copern=10;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov



/////////////////////////////////////////////////VYTLAC DOKUMENT
if( $copern == 10 )
{


if (File_Exists ("../tmp/dokument.$kli_uzid.pdf")) { $soubor = unlink("../tmp/dokument.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$sirka_vyska="210,297";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
$pdf->AddFont('arialb','','arialb.php');

//vytlac
if( $cislo_oc > 0 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_personal_dok".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_personal_dok.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_personal_dok.oc = $cislo_oc AND cpl = $cislo_cpl ORDER BY cpl";
}

if( $cislo_oc == 0 )
{
$sqlfir = "SELECT * FROM personal_dok".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON personal_dok.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE personal_dok.oc = $cislo_oc AND cpl = $cislo_cpl ORDER BY cpl";
}

$velkost = 1*$_REQUEST['velkost'];
if( $velkost == 0 ) $velkost=8;
$velkost2=1*$velkost+2;

$sql = mysql_query("$sqlfir");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

$pdf->AddPage();
$pdf->SetFont('arial','',$velkost2);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15);



//dohody
if( $hlavicka->typ == 1 )
{
$pdf->SetFont('arial','',$velkost2);

$pdf->Cell(180,6,"$hlavicka->nazov","0",1,"C");
$pdf->Cell(180,2," ","0",1,"C");
$pdf->Cell(180,6,"$hlavicka->paragraf","0",1,"C");
$pdf->Cell(180,10," ","0",1,"C");

$pdf->SetFont('arial','',$velkost);

$datrsk=SkDatum($hlavicka->dar);
$kedysk=SkDatum($hlavicka->kedy);

$A=1*substr($hlavicka->rdc,2,2);
$muz=1;
if( $A > 50 ) $muz=0;

$pdf->Cell(180,5," ","T",1,"C");

$pdf->Cell(90,6,"Zamestn·vateæ:","0",0,"L");

$dodatok=0;
$nazov7=substr($hlavicka->nazov,0,7);
if( $nazov7 == 'DODATOK' ) { $dodatok=1;  }
if( $nazov7 == 'Dodatok' ) { $dodatok=1;  }

if( $dodatok == 0 ) {
if( $muz == 1 ) { $pdf->Cell(90,6,"a p·n:","0",1,"L"); }
if( $muz == 0 ) { $pdf->Cell(90,6,"a pani:","0",1,"L"); }
                    }
if( $dodatok == 1 ) {
if( $muz == 1 ) { $pdf->Cell(90,6,"Zamestnanec:","0",1,"L"); }
if( $muz == 0 ) { $pdf->Cell(90,6,"Zamestnanec:","0",1,"L"); }
                    }

$pdf->Cell(90,6,"I»O: $fir_fico","0",0,"L");$pdf->Cell(90,6,"$hlavicka->titl $hlavicka->meno $hlavicka->prie","0",1,"L");
$pdf->Cell(90,6,"$fir_fnaz ","0",0,"L");

if( $muz == 1 ) { $pdf->Cell(90,6,"naroden˝: $datrsk ","0",1,"L"); }
if( $muz == 0 ) { $pdf->Cell(90,6,"naroden·: $datrsk ","0",1,"L"); }

$pdf->Cell(90,6,"$fir_fuli $fir_fcdm","0",0,"L");$pdf->Cell(90,6,"bydlisko: $hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","0",1,"L");
$pdf->Cell(90,6,"$fir_fpsc $fir_fmes","0",0,"L");$pdf->Cell(90,6,"rodnÈ ËÌslo: $hlavicka->rdc $hlavicka->rdk","0",1,"L");
$pdf->Cell(90,6,"zastupuje $fir_uctt05","0",0,"L");

if( $muz == 1 ) { $pdf->Cell(90,6,"Ôalej len zamestnanec","0",1,"L"); }
if( $muz == 0 ) { $pdf->Cell(90,6,"Ôalej len zamestnankyÚa","0",1,"L"); }
$pdf->Cell(180,3,"     ","0",1,"L");


}
//koniec dohody

//oznamenie zamestnancovi
if( $hlavicka->typ == 2 )
{
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg'))
{
$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/hlavicka.jpg',15,10,180,20);
$pdf->SetY(30);
}

$pdf->SetFont('arial','',$velkost);

$datrsk=SkDatum($hlavicka->dar);
$kedysk=SkDatum($hlavicka->kedy);

$A=1*substr($hlavicka->rdc,2,2);
$muz=1;
if( $A > 50 ) $muz=0;


$pdf->Cell(180,7,"$fir_fnaz, $fir_fuli $fir_fcdm, $fir_fpsc $fir_fmes, I»O: $fir_fico","0",1,"L");

$pdf->Cell(180,5," ","T",1,"C");

$pdf->Cell(90,6," ","0",0,"L");

if( $muz == 1 ) { $pdf->Cell(90,6," ","0",1,"L"); }
if( $muz == 0 ) { $pdf->Cell(90,6," ","0",1,"L"); }

$pdf->Cell(90,6," ","0",0,"L");$pdf->Cell(90,6,"$hlavicka->titl $hlavicka->meno $hlavicka->prie","0",1,"L");
$pdf->Cell(90,6," ","0",0,"L");

if( $muz == 1 ) { $pdf->Cell(90,6,"naroden˝: $datrsk ","0",1,"L"); }
if( $muz == 0 ) { $pdf->Cell(90,6,"naroden·: $datrsk ","0",1,"L"); }

$pdf->Cell(90,6," ","0",0,"L");$pdf->Cell(90,6,"bydlisko: $hlavicka->zuli $hlavicka->zcdm, $hlavicka->zmes, $hlavicka->zpsc","0",1,"L");
$pdf->Cell(90,6," ","0",0,"L");$pdf->Cell(90,6,"rodnÈ ËÌslo: $hlavicka->rdc $hlavicka->rdk","0",1,"L");
$pdf->Cell(180,10,"     ","0",1,"L");

$pdf->Cell(180,6,"Vec: $hlavicka->nazov, $hlavicka->paragraf","0",1,"L");

}
//koniec oznamenia zamestnancovi

//text1=strana1
if( $hlavicka->text1 != '' )
{
$pdf->SetFont('arial','',$velkost);

$pdf->Cell(180,1,"","B",1,"L");
$pdf->Cell(180,5,""," ",1,"L");

$pole = explode("\r\n", $hlavicka->text1);

$ipole=1;
foreach( $pole as $hodnota ) {

$pozicia=1*strpos( $hodnota, "{" );

if( $pozicia > 0 )
  {
$cast = explode("{", $hodnota);
$cast1=$cast[0]."";

$poziciax=1*strpos( $hodnota, "{" );
$poziciaber=$poziciax+1;
$poziciaber1=$poziciaber;
$cast1zvysok=substr($hodnota,$poziciaber,100);

$castx1 = explode("}", $cast1zvysok);
$cast2=$castx1[0]."";

$poziciax=1*strpos( $cast1zvysok, "}" );
$poziciaber=$poziciax+1;
$poziciaber2=$poziciaber;
$cast2zvysok=substr($cast1zvysok,$poziciaber,100);

$castxx1 = explode("{", $cast2zvysok);
$cast3=$castxx1[0]."";

$poziciax=1*strpos( $cast2zvysok, "{" );
$poziciaber=$poziciax+1;
$poziciaber3=$poziciaber;
$cast3zvysok=substr($cast2zvysok,$poziciaber,100);
if( $poziciax == 0 ) { $cast3zvysok=""; }

//echo "|zv1ka |".$cast1zvysok."|zv2ka |".$cast2zvysok."|zv3ka |".$cast3zvysok;

$castxxx1 = explode("}", $cast3zvysok);
$cast4=$castxxx1[0]."";
//echo count($castxxx1)." ".$cast4." ".$cast5." x ";

$cast5=$castxxx1[1]."";

$dlzkana1=strlen($cast1); $dlzkana2=strlen($cast2); $dlzkana3=strlen($cast3); $dlzkana4=strlen($cast4); $dlzkana5=strlen($cast5);

$koefdlzky=1.34;
$koefprehrube=1.05;
if( $velkost == 9 ) { $koefdlzky=1.50; $koefprehrube=1.10; }
if( $velkost == 10 ) { $koefdlzky=1.66; $koefprehrube=1.15; }
if( $velkost == 11 ) { $koefdlzky=1.82; $koefprehrube=1.20; }
$dlzkana1=$koefdlzky*$dlzkana1; $dlzkana2=$koefprehrube*$koefdlzky*$dlzkana2; $dlzkana3=$koefdlzky*$dlzkana3; 
$dlzkana4=$koefprehrube*$koefdlzky*$dlzkana4; $dlzkana5=$koefdlzky*$dlzkana5;

$dlzkana1=ceil($dlzkana1); $dlzkana2=ceil($dlzkana2); $dlzkana3=ceil($dlzkana3); $dlzkana4=ceil($dlzkana4); $dlzkana5=ceil($dlzkana5);

$cast2rev=strrev($cast2); $cast4rev=strrev($cast4);

$posunvzad1=1*strpos( $cast2rev, "[" );
$posunvzad2=strpos( $cast2, "[[" );
$posunvzad3=strpos( $cast2, "[[[" );
$posunvzad4=strpos( $cast2, "[[[[" );

if( $posunvzad4 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[[[[","",$cast2); }
if( $posunvzad3 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[[[","",$cast2); }
if( $posunvzad2 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[[","",$cast2); }
if( $posunvzad1 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[","",$cast2);  }

$cast4rev=strrev($cast4);

$posunvzad1=1*strpos( $cast4rev, "[" );
$posunvzad2=strpos( $cast4, "[[" );
$posunvzad3=strpos( $cast4, "[[[" );
$posunvzad4=strpos( $cast4, "[[[[" );

if( $posunvzad4 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4=str_replace("[[[[","",$cast4); }
if( $posunvzad3 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4str_replace("[[[","",$cast4); }
if( $posunvzad2 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4=str_replace("[[","",$cast4); }
if( $posunvzad1 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4=str_replace("[","",$cast4);  }


$pdf->Cell($dlzkana1,5,"$cast1","0",0,"L");

$pdf->SetFont('arialb','',$velkost);
$pdf->Cell($dlzkana2,5,"$cast2","0",0,"L");
$pdf->SetFont('arial','',$velkost);

$pdf->Cell($dlzkana3,5,"$cast3","0",0,"L");

$pdf->SetFont('arialb','',$velkost);
$pdf->Cell($dlzkana4,5,"$cast4","0",0,"L");
$pdf->SetFont('arial','',$velkost);

$pdf->Cell($dlzkana5,5,"$cast5","0",0,"L");

$pdf->Cell(0,5,"","0",1,"L");
  }
if( $pozicia == 0 )
  {
$pdf->Cell(70,5,"$hodnota","0",1,"L");
  }

$ipole=$ipole+1;
                             }

$ajstrana=1;
if( $_SERVER['SERVER_NAME'] == "www.merkfood.sk" ) { $ajstrana=0; }

$pozy=$pdf->GetY();                            
$pdf->SetY(270);
$pdf->SetFont('arial','',$velkost);
if( $ajstrana == 1 ) { $pdf->Cell(180,6,"- 1.strana -","0",1,"C"); }
$pdf->SetY($pozy);

}
//koniec text1

//text2=strana2
if( $hlavicka->text2 != '' )
{

$pdf->AddPage();
$pdf->SetFont('arial','',$velkost2);

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15);

$pdf->SetFont('arial','',$velkost);

$ajstrana=1;
if( $_SERVER['SERVER_NAME'] == "www.merkfood.sk" ) { $ajstrana=0; }

$pozy=$pdf->GetY();                            
$pdf->SetY(270);
$pdf->SetFont('arial','',$velkost);
if( $ajstrana == 1 ) { $pdf->Cell(180,6,"- 2.strana -","0",1,"C"); }
$pdf->SetY($pozy);

$pdf->Cell(180,1,""," ",1,"L");
$pdf->Cell(180,5,""," ",1,"L");

$pole = explode("\r\n", $hlavicka->text2);

$ipole=1;
foreach( $pole as $hodnota ) {

$pozicia=1*strpos( $hodnota, "{" );

if( $pozicia > 0 )
  {
$cast = explode("{", $hodnota);
$cast1=$cast[0]."";

$poziciax=1*strpos( $hodnota, "{" );
$poziciaber=$poziciax+1;
$poziciaber1=$poziciaber;
$cast1zvysok=substr($hodnota,$poziciaber,100);

$castx1 = explode("}", $cast1zvysok);
$cast2=$castx1[0]."";

$poziciax=1*strpos( $cast1zvysok, "}" );
$poziciaber=$poziciax+1;
$poziciaber2=$poziciaber;
$cast2zvysok=substr($cast1zvysok,$poziciaber,100);

$castxx1 = explode("{", $cast2zvysok);
$cast3=$castxx1[0]."";

$poziciax=1*strpos( $cast2zvysok, "{" );
$poziciaber=$poziciax+1;
$poziciaber3=$poziciaber;
$cast3zvysok=substr($cast2zvysok,$poziciaber,100);
if( $poziciax == 0 ) { $cast3zvysok=""; }

//echo "|zv1ka |".$cast1zvysok."|zv2ka |".$cast2zvysok."|zv3ka |".$cast3zvysok;

$castxxx1 = explode("}", $cast3zvysok);
$cast4=$castxxx1[0]."";
//echo count($castxxx1)." ".$cast4." ".$cast5." x ";

$cast5=$castxxx1[1]."";

$dlzkana1=strlen($cast1); $dlzkana2=strlen($cast2); $dlzkana3=strlen($cast3); $dlzkana4=strlen($cast4); $dlzkana5=strlen($cast5);

$koefdlzky=1.34;
$koefprehrube=1.05;
if( $velkost == 9 ) { $koefdlzky=1.50; $koefprehrube=1.10; }
if( $velkost == 10 ) { $koefdlzky=1.66; $koefprehrube=1.15; }
if( $velkost == 11 ) { $koefdlzky=1.82; $koefprehrube=1.20; }
$dlzkana1=$koefdlzky*$dlzkana1; $dlzkana2=$koefprehrube*$koefdlzky*$dlzkana2; $dlzkana3=$koefdlzky*$dlzkana3; 
$dlzkana4=$koefprehrube*$koefdlzky*$dlzkana4; $dlzkana5=$koefdlzky*$dlzkana5;

$dlzkana1=ceil($dlzkana1); $dlzkana2=ceil($dlzkana2); $dlzkana3=ceil($dlzkana3); $dlzkana4=ceil($dlzkana4); $dlzkana5=ceil($dlzkana5);

$cast2rev=strrev($cast2); $cast4rev=strrev($cast4);

$posunvzad1=1*strpos( $cast2rev, "[" );
$posunvzad2=strpos( $cast2, "[[" );
$posunvzad3=strpos( $cast2, "[[[" );
$posunvzad4=strpos( $cast2, "[[[[" );

if( $posunvzad4 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[[[[","",$cast2); }
if( $posunvzad3 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[[[","",$cast2); }
if( $posunvzad2 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[[","",$cast2); }
if( $posunvzad1 > 0 ) { $dlzkana1=$dlzkana1-4; $cast2=str_replace("[","",$cast2);  }

$cast4rev=strrev($cast4);

$posunvzad1=1*strpos( $cast4rev, "[" );
$posunvzad2=strpos( $cast4, "[[" );
$posunvzad3=strpos( $cast4, "[[[" );
$posunvzad4=strpos( $cast4, "[[[[" );

if( $posunvzad4 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4=str_replace("[[[[","",$cast4); }
if( $posunvzad3 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4str_replace("[[[","",$cast4); }
if( $posunvzad2 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4=str_replace("[[","",$cast4); }
if( $posunvzad1 > 0 ) { $dlzkana3=$dlzkana1-4; $cast4=str_replace("[","",$cast4);  }


$pdf->Cell($dlzkana1,5,"$cast1","0",0,"L");

$pdf->SetFont('arialb','',$velkost);
$pdf->Cell($dlzkana2,5,"$cast2","0",0,"L");
$pdf->SetFont('arial','',$velkost);

$pdf->Cell($dlzkana3,5,"$cast3","0",0,"L");

$pdf->SetFont('arialb','',$velkost);
$pdf->Cell($dlzkana4,5,"$cast4","0",0,"L");
$pdf->SetFont('arial','',$velkost);

$pdf->Cell($dlzkana5,5,"$cast5","0",0,"L");

$pdf->Cell(0,5,"","0",1,"L");
  }
if( $pozicia == 0 )
  {
$pdf->Cell(70,5,"$hodnota","0",1,"L");
  }

                             }

}
//koniec text2

//exit;

//dohody
if( $hlavicka->typ == 1 )
{
$pdf->Cell(180,10," ","0",1,"L");
$pdf->Cell(50,6,"$fir_fmes $kedysk","0",1,"L");


$pdf->Cell(90,18," ","0",1,"L");
$pdf->Cell(30,6," ","0",0,"L");
$pdf->Cell(50,6,"peËiatka a podpis zamestn·vateæa","T",0,"L");
$pdf->Cell(40,6," ","0",0,"L");$pdf->Cell(50,6,"podpis $hlavicka->titl $hlavicka->meno $hlavicka->prie","T",1,"L");
$pdf->Cell(30,3," ","0",0,"L");$pdf->Cell(50,3,"$fir_uctt05","0",0,"L");
$pdf->Cell(40,3," ","0",0,"L");$pdf->Cell(50,3," ","0",1,"L");
}


//oznamenie zamestnancovi
if( $hlavicka->typ == 2 )
{
$pdf->Cell(180,10," ","0",1,"L");
$pdf->Cell(50,6,"$fir_fmes $kedysk","0",1,"L");


$pdf->Cell(90,18," ","0",1,"L");
$pdf->Cell(30,6," ","0",0,"L");
$pdf->Cell(50,6,"peËiatka a podpis zamestn·vateæa","T",0,"L");
$pdf->Cell(40,6," ","0",0,"L");$pdf->Cell(50,6,"prevzal $hlavicka->titl $hlavicka->meno $hlavicka->prie","T",1,"L");
$pdf->Cell(30,3," ","0",0,"L");$pdf->Cell(50,3,"$fir_uctt05","0",0,"L");
$pdf->Cell(40,3," ","0",0,"L");$pdf->Cell(50,3," ","0",1,"L");
}


$pdf->Cell(90,6," ","0",1,"L");
$pdf->Cell(180,5,"$hlavicka->pozn","0",1,"L");


}
$i = $i + 1;

  }


$pdf->Output("../tmp/dokument.$kli_uzid.pdf");


?>

<script type="text/javascript">
  var okno = window.open("../tmp/dokument.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC DOKUMENTU


//nacitaj udaje pre upravu
if ( $copern == 20 )
    {

if( $cislo_oc > 0 )
{
$sqlfir = "SELECT * FROM F$kli_vxcf"."_personal_dok".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_personal_dok.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_personal_dok.oc = $cislo_oc AND cpl = $cislo_cpl ORDER BY cpl";
}

if( $cislo_oc == 0 )
{
$sqlfir = "SELECT * FROM personal_dok".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON personal_dok.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE personal_dok.oc = $cislo_oc AND cpl = $cislo_cpl ORDER BY cpl";
}

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$cpl = $fir_riadok->cpl;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$titl = $fir_riadok->titl;

$typ = $fir_riadok->typ;
$kedy = $fir_riadok->kedy;
$kedysk=SkDatum($kedy);
$popis = $fir_riadok->popis;
$nazov = $fir_riadok->nazov;
$paragraf = $fir_riadok->paragraf;
$text1 = $fir_riadok->text1;
$text2 = $fir_riadok->text2;
$pozn = $fir_riadok->pozn;

if( $oc == 0 ) { $meno="VzorovÈ dokumenty"; }

mysql_free_result($fir_vysledok);

    }
//koniec nacitania



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Person·lne dokumenty</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana 1
  if ( $copern == 20 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.kedy.value = '<?php echo "$kedysk";?>';
    document.formv1.typ.value = '<?php echo "$typ";?>';
    document.formv1.popis.value = '<?php echo "$popis";?>';
    document.formv1.nazov.value = '<?php echo "$nazov";?>';
    document.formv1.paragraf.value = '<?php echo "$paragraf";?>';

    document.formv1.pozn.value = '<?php echo "$pozn";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern != 20 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
  }
?>

//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


function ZnovuPotvrdenie()
                {
window.open('../mzdy/potvrd_fo.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }



  function zobraz_robotmenu()
  { 
  myRobotmenu = document.getElementById("robotmenu");
  myRobotmenu.innerHTML = htmlmenu;
  robotmenu.style.display='';
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  }

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Kliknite na dokument, z ktorÈho chcete kopÌrovaù texty</td>";
    htmlmenu += "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmenu += "onClick='zhasni_menurobot();' alt='Zhasni menu' ></td></tr>";  


<?php
$sqltt = "SELECT * FROM personal_dok WHERE oc >= 0 ORDER BY cpl";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"kopirujTEXT(1,<?php echo $riadok->cpl; ?>,<?php echo $riadok->oc; ?>,<?php echo $cislo_cpl; ?>,<?php echo $cislo_oc; ?>); window.name = 'zoznam';\">" +
"Vzorov˝ dokument - <?php echo $riadok->popis; ?> </a>";
    htmlmenu += "</td></tr>";
<?php
  }
$i=$i+1;
   }
?>

<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_personal_dok ".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_personal_dok.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE cpl >= 0  ORDER BY prie,cpl";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"kopirujTEXT(1,<?php echo $riadok->cpl; ?>,<?php echo $riadok->oc; ?>,<?php echo $cislo_cpl; ?>,<?php echo $cislo_oc; ?>); window.name = 'zoznam';\">" +
"<?php echo $riadok->prie; ?> - <?php echo $riadok->popis; ?> </a>";
    htmlmenu += "</td></tr>";
<?php
  }
$i=$i+1;
   }
?>

    htmlmenu += "</table>"; 

  function kopirujTEXT(druh,kcpl,koc,cpl,oc)
  { 
window.open('../mzdy/personal_tlac.php?cislo_oc=' + oc + '&cislo_cpl=' + cpl + '&cislo_kcpl=' + kcpl +  '&cislo_koc=' + koc + '&copern=27&drupoh=1&page=1&subor=0',
 '_self', 'width=1080, height=880, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
 
   
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Person·lne dokumenty

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>




<?php
//upravy  udaje strana 1
if ( $copern == 20 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="personal_tlac.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>" >
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr><td class="bmenu" colspan="4">OsobnÈ ËÌslo, titul, meno, priezvisko:</td>
<td class="bmenu" colspan="3"><?php echo $oc.", ".$titl." ".$meno." ".$prie;?></td>
<td class="bmenu" colspan="1"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù a tlaËiù"></td>
</tr>

<tr><td class="bmenu" colspan="4">Popis:</td>
<td class="fmenu" colspan="4"><input type="text" name="popis" id="popis" size="80"  />
 <img src='../obr/info.png' width=12 height=12 border=0 alt="Tento popis sa objavÌ v n·zve dokumentu nie na vytlaËenom dokumente ">
</td>
</tr>

<tr><td class="bmenu" colspan="4">Typ dokumentu:</td>
<td class="bmenu" colspan="2"><select size="1" name="typ" id="typ" >
<option value="1" >Dohoda zamestn·vateæa a zamestnanca</option>
<option value="2" >Ozn·menie zamestn·vateæa zamestnancovi</option>
<option value="3" >Ozn·menie zamestnanca zamestn·vateæovi</option>
</select></td></tr>

<tr><td class="bmenu" colspan="4">N·zov:</td>
<td class="fmenu" colspan="4"><input type="text" name="nazov" id="nazov" size="80"  />
 <img src='../obr/info.png' width=12 height=12 border=0 alt="N·zov dokumentu napr. Dohoda o vykonanÌ pr·ce, bude vytlaËen˝ na dokumente ">
</td>
</tr>

<tr><td class="bmenu" colspan="4">ß Z·konnÌka pr·ce:</td>
<td class="fmenu" colspan="4"><input type="text" name="paragraf" id="paragraf" size="80"  />
 <img src='../obr/info.png' width=12 height=12 border=0 alt="ß Z·k.pr·ce podæa ktorÈho sa dohoda uzatv·ra, bude vytlaËen˝ na dokumente ">
</td>
</tr>

<tr><td class="bmenu" colspan="4">D·tum podpisu:</td>
<td class="fmenu" colspan="1"><input type="text" name="kedy" id="kedy" size="10"  /></td>
<td class="bmenu" colspan="2">
<img border=0 src='../obr/robot/robot3.jpg' style='width:25; height:25;' onClick="zobraz_robotmenu();"
 alt='KopÌrovanie popisu,n·zvu,ßZP a textov z uû vytvoren˝ch vzorov' >
</td>
</tr>

<tr><td class="bmenu" colspan="4">1.strana</td><td class="bmenu" colspan="4" align="right" >{text}zv˝raznen˝ text, {[text}=zv˝raznen˝ text a posun o znak væavo</td></tr>

<tr><td class="bmenu" colspan="10">
<textarea name="text1" id="text1" rows="24" cols="120" >
<?php echo $text1; ?>
</textarea>
</td></tr>

<tr><td class="bmenu" colspan="4">2.strana</td></tr>

<tr><td class="bmenu" colspan="10">
<textarea name="text2" id="text2" rows="24" cols="120" >
<?php echo $text2; ?>
</textarea>
</td></tr>

<tr><td class="bmenu" colspan="4"> </td></tr>

<tr><td class="bmenu" colspan="1">Pozn·mka</td>
<td class="fmenu" colspan="6"><input type="text" name="pozn" id="pozn" size="80" /></td></tr>

<input class="hvstup" type="hidden" name="cislo_oc" id="cislo_oc" value="<?php echo $oc;?>" />
<input class="hvstup" type="hidden" name="cislo_cpl" id="cislo_cpl" value="<?php echo $cpl;?>" />

</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 210; left: 600; width:400; height:100;">
zobrazene menu
</div>

<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje strana 1
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
       } while (false);
?>
</BODY>
</HTML>
