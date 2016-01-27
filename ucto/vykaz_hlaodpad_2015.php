<HTML>
<?php

//skript pre rok 2015 a niûöie

do
{
$sys = 'UCT';
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


$tlacodpady=1;

if( $_SERVER['SERVER_NAME'] == "www.enposro.sk" ) 
{ 
if( $kli_uzid != 17 AND $kli_uzid != 57 AND $kli_uzid != 58 AND $kli_uzid != 141 ) { $tlacodpady=0; }
}


$stvrtrok = 1*$_REQUEST['stvrtrok'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) $strana=9999;
$h_kmd = 1*$_REQUEST['h_kmd'];
$zaciatok = 1*$_REQUEST['zaciatok'];
$h_zos = $_REQUEST['h_zos'];

$icox = 1*$_REQUEST['icox'];
$hodx = 1*$_REQUEST['hodx'];
$doxx = 1*$_REQUEST['doxx'];

if( $stvrtrok == 0 ) $stvrtrok=1;
if( $stvrtrok == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; $kli_pume="1.".$kli_vrok; $kli_kume="3.".$kli_vrok; }
if( $stvrtrok == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; $kli_pume="4.".$kli_vrok; $kli_kume="6.".$kli_vrok; }
if( $stvrtrok == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; $kli_pume="7.".$kli_vrok; $kli_kume="9.".$kli_vrok; }
if( $stvrtrok == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; $kli_pume="10.".$kli_vrok; $kli_kume="12.".$kli_vrok; }


$vsetkyprepocty=0;

include("vykaz_hlaodpad_nazovkomodity.php");
include("vykaz_hlaodpad_nazovkomodityfull.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

// zmaz,uprav riadok
if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];
$upravit = 1*$_REQUEST['upravit'];

$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_hlaodpadd2 WHERE cpl = $cislo_cpl ORDER BY cpl DESC LIMIT 1";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$druh = $fir_riadok->druh;
$daz = $fir_riadok->daz;
$ico = $fir_riadok->ico;
$komodita = $fir_riadok->komodita;
$hod = $fir_riadok->hod;
$dox = $fir_riadok->dox;
if( $upravit == 0 ) { $hod=""; }

mysql_free_result($fir_vysledok);

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_hlaodpadd2 WHERE cpl = $cislo_cpl";
$oznac = mysql_query("$sqtoz");
$copern=20;

    }
//koniec zmaz,uprav riadok





// zapis riadok
if ( $copern == 23 )
    {


$druh = $_REQUEST['druh'];
$daz = $_REQUEST['daz'];
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$poledaz = explode(".", $daz);
$daz=$poledaz[0].".".$kli_vrok;

if( $daz < $kli_pume ) { $daz=$kli_pume; }
if( $daz > $kli_kume ) { $daz=$kli_kume; }

$ico = strip_tags($_REQUEST['ico']);
$poleico = explode("-", $ico);
$ico=1*$poleico[0];

$komodita = $_REQUEST['komodita'];
$hod = 1*$_REQUEST['hod'];
$dox = 1*$_REQUEST['dox'];

$xico = 1*strip_tags($_REQUEST['xico']);
$xnaz = strip_tags($_REQUEST['xnaz']);
$xnaz = trim($xnaz);
$xna2 = substr($xnaz,30,30);
$xnaz = substr($xnaz,0,30);

$xmes = strip_tags($_REQUEST['xmes']);

if( $xico > 0 AND $xnaz != '' )
  {
$uloztt = "INSERT INTO F$kli_vxcf"."_ico".
" ( ico,dic,icd,nai,na2,uli,psc,mes,tel,fax,em1,em2,em3,dns,www,uc1,nm1,uc2,nm2,uc3,nm3,ib1,ib2,ib3 )".
" VALUES ($xico, '$h_dic', '$h_icd', '$xnaz', '$xna2', '$h_uli', '$h_psc', '$xmes',".
" '$h_tel', '$h_fax', '$h_em1', '$h_em2', '$h_em3', '$h_dns',".
" '$h_www', '0', '0', '$h_uc2', '$h_nm2', '$h_uc3', '$h_nm3', '$h_ib1', '$h_ib2', '$h_ib3') "; 
//echo $uloztt;
$ulozene = mysql_query("$uloztt");

$ico=$xico;
  }

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_hlaodpadd2 (oc,druh,daz,ico,komodita,hod,dox) VALUES ".
" (  '$stvrtrok', '$druh', '$daz', '$ico', '$komodita', '$hod', '$dox' ) ";

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapis riadok

//prac.subor a subor 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT dox FROM F".$kli_vxcf."_uctvykaz_hlaodpad";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_hlaodpad';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_hlaodpadd2';
$vysledok = mysql_query("$sqlt");

$desat=0;
  while ($desat <= 1 )
  {
$pocdes="10,3";
if( $desat == 1 ) $pocdes="10,3";

$sqlt = <<<mzdprc
(
   cpl          int not null auto_increment,
   pxy06        DECIMAL($pocdes) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   daz          DECIMAL(10,4) DEFAULT 0,
   kor          INT DEFAULT 0,
   prx          INT DEFAULT 0,
   hod          DECIMAL($pocdes) DEFAULT 0,
   vyroba       DECIMAL($pocdes) DEFAULT 0,
   dovoz        DECIMAL($pocdes) DEFAULT 0,
   vyvoz        DECIMAL($pocdes) DEFAULT 0,
   reexport     DECIMAL($pocdes) DEFAULT 0,
   ico          DECIMAL(10,0) DEFAULT 0,
   komodita     DECIMAL(10,0) DEFAULT 0,
   dox          DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_hlaodpad'.$sqlt;
if( $desat == 1 ) $vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_hlaodpadd2'.$sqlt;
//echo $vsql;
$vytvor = mysql_query("$vsql");

$desat=$desat+1;
  }
//koniec while


}
//koniec vytvorenie 

$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_hlaodpadd2 ADD xmen VARCHAR(40) NOT NULL AFTER dox";
$vysledek = mysql_query("$sql");


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_hlaodpadd2";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_hlaodpad";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");

//exit;



//vypocty
if( $copern == 10 )
{
$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_hlaodpad WHERE oc >= 0";
$oznac = mysql_query("$sqtoz");

//  cpl  pxy06  oc  druh  daz  kor  prx  hod  vyroba  dovoz  vyvoz  reexport  ico  komodita  

$h_kmd100="10".$h_kmd;
$podmkmd=" AND ( komodita = $h_kmd OR komodita = $h_kmd100 ) ";
if( $h_kmd == 0 ) $podmkmd="";

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_hlaodpad".
" SELECT 0,0,oc,druh,daz,kor,9,sum(hod),0,0,0,0,ico,komodita,dox FROM F$kli_vxcf"."_uctvykaz_hlaodpadd2 WHERE daz >= $kli_pume AND daz <= $kli_kume ".
" $podmkmd GROUP BY komodita,ico,daz,druh ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET komodita=komodita-100 WHERE komodita > 100 ";
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET vyroba=hod WHERE druh=0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET dovoz=hod WHERE druh=1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET vyvoz=hod WHERE druh=2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET reexport=hod WHERE druh=3 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_hlaodpad".
" SELECT 0,0,oc,druh,daz,1,10,sum(hod),sum(vyroba),sum(dovoz),sum(vyvoz),sum(reexport),ico,komodita,0 FROM F$kli_vxcf"."_uctvykaz_hlaodpad ".
" WHERE prx = 9".
" GROUP BY komodita,ico,daz ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_hlaodpad WHERE prx != 10";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_hlaodpad".
" SELECT 0,0,oc,druh,daz,SUM(kor),1,sum(hod),sum(vyroba),sum(dovoz),sum(vyvoz),sum(reexport),ico,komodita,0 FROM F$kli_vxcf"."_uctvykaz_hlaodpad ".
" WHERE prx = 10".
" GROUP BY komodita ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctvykaz_hlaodpad".
" SELECT 0,0,oc,druh,daz,kor,100,sum(hod),sum(vyroba),sum(dovoz),sum(vyvoz),sum(reexport),ico,komodita,0 FROM F$kli_vxcf"."_uctvykaz_hlaodpad ".
" WHERE prx = 10".
" GROUP BY komodita ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET kor=kor-10 WHERE prx=1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET pxy06=kor/32 WHERE prx=1 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_uctvykaz_hlaodpad SET kor=CEIL(pxy06)+1 WHERE prx=1 ";
$dsql = mysql_query("$dsqlt");

//exit;

}
//koniec vypocty

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

/////////////////////////////////////////////////VYTLAC ROCNE
if( $copern == 10 )
{


if (File_Exists ("../tmp/vykazfin.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazfin.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$chodna2stranu=0;

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_hlaodpad".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctvykaz_hlaodpad.ico=F$kli_vxcf"."_ico.ico".
" WHERE prx >= 0  ORDER BY komodita,prx,F$kli_vxcf"."_uctvykaz_hlaodpad.ico,daz";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=1; 
$k=0;
$strana=0;

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $hlavicka->prx == 1 )  $celkomstran=$hlavicka->kor;
if( $celkomstran <= 1 )  $celkomstran=2;
$celkomstran=$celkomstran-1;

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$dat_dat = SkDatum($hlavicka->da21 );
if( $dat_dat == '0000-00-00' ) $dat_dat="";

//tab. n·zov v˝robku
$text_komodita=NazovKomodityfull($hlavicka->komodita);
$text_komodita=str_replace("\"O\"","",$text_komodita);


////////////////////////////////////////ZACIATOK 1.STRANA DVOJSTRANY
if ( $hlavicka->prx == 1 )    {

$k=0;
$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy2010/hlaovyrobes1.jpg') )
{
$pdf->Image('../dokumenty/vykazy2010/hlaovyrobes1.jpg',1,8,212,290); 
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);


//za ötvrùrok
$pdf->Cell(190,42,"                          ","0",1,"L");

$text=$stvrtrok.".".$kli_vrok;

$pdf->Cell(28,6," ","0",0,"R");$pdf->Cell(6,6,"$text","0",1,"L");


//list Ë.:
$pdf->Cell(190,5,"                          ","0",1,"L");

$text="1";

$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);

$pdf->Cell(30,6," ","0",0,"R");$pdf->Cell(5,7,"$t01","0",0,"R");$pdf->Cell(5,7,"$t02","0",0,"C");$pdf->Cell(5,7,"$t03","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");


//poËet listov:
$pdf->Cell(190,5,"                          ","0",1,"L");

$text=$celkomstran;

$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);

$pdf->Cell(30,6," ","0",0,"R");$pdf->Cell(5,7,"$t01","0",0,"R");$pdf->Cell(5,7,"$t02","0",0,"C");$pdf->Cell(5,7,"$t03","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");


//iËo
$pdf->Cell(190,25,"                          ","0",1,"L");

$text=$fir_fico;
$textx="12345678";
if( $text < 999999 ) $text="00".$text;

$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);

$pdf->Cell(86,6," ","0",0,"R");$pdf->Cell(5,6,"$t01","0",0,"C");$pdf->Cell(5,6,"$t02","0",0,"C");$pdf->Cell(5,6,"$t03","0",0,"C");
$pdf->Cell(4,6,"$t04","0",0,"C");$pdf->Cell(5,6,"$t05","0",0,"R");$pdf->Cell(5,6,"$t06","0",0,"C");$pdf->Cell(5,6,"$t07","0",0,"C");
$pdf->Cell(5,6,"$t08","0",0,"C");$pdf->Cell(5,6," ","0",1,"C");


//obchodnÈ meno
$pdf->Cell(190,5,"                          ","0",1,"L");

$text=$fir_fnaz;

$pdf->Cell(14,6," ","0",0,"R");$pdf->Cell(84,7,"$text","0",0,"L");


//n·zov zavodu
//udaje o zavode a zodpovednej osobe za zavod berie z danoveho priznania PO
//Umiestnenie st·lej prev·dzk·rne na ˙zemÌ Slovenskej republiky (ak nie je sÌdlo na ˙zemÌ SR) 1.strana - tam je adresa prevadzkarne
//nazov prevadzkarne je v polozke ulica v tvare "nazov - ulica", podla pomlcky si to rozdeli
//Osoba opr·vnen· na podanie daÚovÈho priznania za PO 8.strana

$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctpriznanie_po ";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$pole = explode("-", $fir_riadok->pruli);
$zav_fnaz=$pole[0];
$zav_fuli=$pole[1];

$zav_fpsc = $fir_riadok->prpsc;
$zav_fcdm = $fir_riadok->prcdm;
$zav_fmes = $fir_riadok->prmes;

$zav_oprie = $fir_riadok->ooprie;
$zav_omeno = $fir_riadok->oomeno;
$zav_otitl = $fir_riadok->ootitl;
$zav_otel = $fir_riadok->ootel;
$zav_ofax = $fir_riadok->oofax;

$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$zav_fnaz;

$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(86,7,"$text","0",1,"L");


//ulica a ËÌslo
$pdf->Cell(190,6,"                          ","0",1,"L");

$text=$fir_fuli." ".$fir_fcdm;

$pdf->Cell(22,6," ","0",0,"R");$pdf->Cell(75,6,"$text","0",0,"L");


//ulica a ËÌslo z·vodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$zav_fuli." ".$zav_fcdm;

$pdf->Cell(9,6," ","0",0,"R");$pdf->Cell(79,6,"$text","0",1,"L");


//obec
$pdf->Cell(190,-1,"                          ","0",1,"L");

$text=$fir_fmes;

$pdf->Cell(23,6," ","0",0,"R");$pdf->Cell(43,7,"$text","0",0,"L");


//psË
$pdf->Cell(2,6,"                          ","0",0,"L");

$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;

$pdf->Cell(7,6," ","0",0,"R");$pdf->Cell(25,7,"$text","0",0,"L");$pdf->Cell(1,6," ","0",0,"C");


//obec z·vodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$zav_fmes;

$pdf->Cell(6,6," ","0",0,"R");$pdf->Cell(43,7,"$text","0",0,"L");


//psË z·vodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$zav_fpsc;

$pdf->Cell(7,6," ","0",0,"R");$pdf->Cell(25,6,"$text","0",1,"L");


//meno ötatut·ra firmy
$pdf->Cell(190,7,"                          ","0",1,"L");

$text="$fir_uctt05";

$pdf->Cell(23,6," ","0",0,"R");$pdf->Cell(74,6,"$text","0",0,"L");


//meno zodpovednej osoby zavodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$zav_otitl." ".$zav_omeno." ".$zav_oprie;

$pdf->Cell(10,6," ","0",0,"R");$pdf->Cell(78,6,"$text","0",1,"L");


//telefÛn ötatut·ra firmy
$pdf->Cell(190,0,"                          ","0",1,"L");

$text=$fir_ftel;

$pdf->Cell(25,6," ","0",0,"R");$pdf->Cell(40,6,"$text","0",0,"L");


//fax ötatut·ra
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$fir_ffax;

$pdf->Cell(6,6," ","0",0,"R");$pdf->Cell(24,6,"$text","0",0,"L");


//telefÛn zodpovednej osoby zavodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$zav_otel;

$pdf->Cell(12,6," ","0",0,"R");$pdf->Cell(40,6,"$text","0",0,"L");


//fax zodpovednej osoby zavodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$zav_ofax;

$pdf->Cell(7,6," ","0",0,"R");$pdf->Cell(27,6,"$text","0",1,"L");


//email ötat˙ra
$pdf->SetFont('arial','',8); 
$pdf->Cell(190,-1,"                          ","0",1,"L");

$text=$fir_fem1;

$pdf->Cell(23,6," ","0",0,"R");$pdf->Cell(43,6,"$text","0",0,"L");


//url ötatut·ra
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$fir_fwww;

$pdf->Cell(6,6," ","0",0,"R");$pdf->Cell(24,6,"$text","0",0,"L");


//email zodpovednÈho zavodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text="";

$pdf->Cell(10,6," ","0",0,"R");$pdf->Cell(43,6,"$text","0",0,"L");


//url zodpovednÈho zavodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text="";

$pdf->Cell(6,6," ","0",0,"R");$pdf->Cell(25,6,"$text","0",0,"L");

$pdf->SetFont('arial','',10); 
//d·tum podpisu
$pdf->Cell(190,13,"                          ","0",1,"L");

$text=$h_zos;
$textx="0123456789";

$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);

$pdf->Cell(14,6," ","0",0,"C");$pdf->Cell(5,6,"$t01","0",0,"C");$pdf->Cell(5,6,"$t02","0",0,"R");
$pdf->Cell(2,6," ","0",0,"C");$pdf->Cell(5,6,"$t04","0",0,"C");$pdf->Cell(6,6,"$t05","0",0,"L");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$t07","0",0,"C");$pdf->Cell(5,6,"$t08","0",0,"C");
$pdf->Cell(5,6,"$t09","0",0,"C");$pdf->Cell(5,6,"$t10","0",0,"C");$pdf->Cell(4,6," ","0",0,"C");


//d·tum podpisu z·vodu
$pdf->Cell(2,6,"                          ","0",0,"L");

$text=$h_zos;
$textx="0123456789";

$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);

$pdf->Cell(36,6," ","0",0,"C");$pdf->Cell(5,6,"$t01","0",0,"C");$pdf->Cell(5,6,"$t02","0",0,"R");
$pdf->Cell(2,6," ","0",0,"C");$pdf->Cell(5,6,"$t04","0",0,"R");$pdf->Cell(6,6,"$t05","0",0,"C");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(5,6,"$t07","0",0,"R");$pdf->Cell(5,6,"$t08","0",0,"C");
$pdf->Cell(5,6,"$t09","0",0,"C");$pdf->Cell(5,6,"$t10","0",0,"C");$pdf->Cell(4,6," ","0",1,"C");

//tab. n·zov v˝robku

$pdf->Cell(190,21,"                          ","0",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(45,5," ","0",0,"C");$pdf->Cell(0,7,"$text_komodita","0",1,"L");
$pdf->Cell(190,13,"                          ","0",1,"L");


////////////////////////////////////////KONIEC 1.STRANA DVOJSTRANY prx=1
                              }

$datum = $hlavicka->daz;
if( $datum == 0 ) $datum="";
$vyroba = $hlavicka->vyroba;
$Cislo=$vyroba+"";
$vyroba=sprintf("%0.3f", $Cislo);
if( $vyroba == 0 ) $vyroba="";
$dovoz = $hlavicka->dovoz;
$Cislo=$dovoz+"";
$dovoz=sprintf("%0.3f", $Cislo);
if( $dovoz == 0 ) $dovoz="";
$vyvoz = $hlavicka->vyvoz;
$Cislo=$vyvoz+"";
$vyvoz=sprintf("%0.3f", $Cislo);
if( $vyvoz == 0 ) $vyvoz="";
$reexport = $hlavicka->reexport;
$Cislo=$reexport+"";
$reexport=sprintf("%0.3f", $Cislo);
if( $reexport == 0 ) $reexport="";


////////////////////////////////////////ZACIATOK 2.STRANA DVOJSTRANY POLOZKY da sa tam 32 poloziek
if ( $hlavicka->prx == 10 AND $j > 10)    {



if( $k == 0 AND $j > 11 )
     {
$strana=$strana+1;

if( $strana > 2 )
{
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy2010/hlaovyrobes2.jpg') )
  {
$pdf->Image('../dokumenty/vykazy2010/hlaovyrobes2.jpg',3,6,210,294); 
  }

$pdf->SetY(10);


//tab. n·zov v˝robku

$pdf->Cell(190,9,"                          ","0",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(50,5," ","0",0,"C");$pdf->Cell(120,7,"$text_komodita","0",0,"L");$pdf->Cell(0,5,"List Ë. $strana","0",1,"L");
$pdf->Cell(190,14,"                          ","0",1,"L");

}

     }



//d·tum 11
$pdf->SetFont('arial','',8);

$pdf->Cell(14,3," ","0",0,"R");$pdf->Cell(12,3,"$datum","0",0,"R");

//v˝robok v ton·ch 11
$pdf->SetFont('arial','',10);
$pdf->Cell(1,3,"                          ","0",0,"L");

$pdf->Cell(16,3,"$vyroba","0",0,"R");$pdf->Cell(1,3," ","0",0,"C");$pdf->Cell(16,3,"$dovoz","0",0,"R");$pdf->Cell(1,3," ","0",0,"C");
$pdf->Cell(17,3,"$vyvoz","0",0,"R");$pdf->Cell(1,3," ","0",0,"C");$pdf->Cell(17,3,"$reexport","0",0,"R");

$pdf->SetFont('arial','',9);

//iËo a obchodnÈ meno 11
$ico=$hlavicka->ico;
if( $ico > 111111 AND $ico < 1000000 ) { $ico="00".$ico; }
$iconazov=$ico.", ".$hlavicka->nai.$hlavicka->na2;
$iconazov=substr($iconazov,0,57);
$mesto=trim($hlavicka->mes);
if( $mesto == '0' ) { $mesto=""; }

$pdf->SetFont('arial','',9);
$pdf->Cell(1,3,"                          ","0",0,"L");$pdf->Cell(90,3,"$iconazov","0",1,"L");
$pdf->Cell(97,3,"                          ","0",0,"L");$pdf->Cell(90,3,"$mesto","0",1,"L");
$pdf->Cell(0,1," ","0",1,"L");

$k=$k+1;
$j = $j + 1;

////////////////////////////////////////KONIEC 2.STRANA DVOJSTRANY POLOZKY
                                            }


////////////////////////////////////////ZACIATOK 1.STRANA DVOJSTRANY POLOZKY
if ( $hlavicka->prx == 10 AND $j <= 10 )    {


//d·tum 1
$pdf->SetFont('arial','',8);


$pdf->Cell(12,3," ","0",0,"C");$pdf->Cell(12,3,"$datum","0",0,"C");

//v˝robok v ton·ch 1
$pdf->SetFont('arial','',10);
$pdf->Cell(1,3,"                          ","0",0,"L");

$pdf->Cell(16,3,"$vyroba","0",0,"R");$pdf->Cell(1,3," ","0",0,"C");$pdf->Cell(17,3,"$dovoz","0",0,"R");$pdf->Cell(1,3," ","0",0,"C");
$pdf->Cell(17,3,"$vyvoz","0",0,"R");$pdf->Cell(1,3," ","0",0,"C");$pdf->Cell(17,3,"$reexport","0",0,"R");



//iËo a obchodnÈ meno 1
$ico=$hlavicka->ico;
if( $ico > 111111 AND $ico < 1000000 ) { $ico="00".$ico; }
$iconazov=$ico.", ".$hlavicka->nai.$hlavicka->na2;
$iconazov=substr($iconazov,0,58);
$mesto=trim($hlavicka->mes);
if( $mesto == '0' ) { $mesto=""; }

$pdf->SetFont('arial','',9);
$pdf->Cell(1,3,"                          ","0",0,"L");$pdf->Cell(91,3,"$iconazov","0",1,"L");
$pdf->Cell(96,3,"                          ","0",0,"L");$pdf->Cell(91,3,"$mesto","0",1,"L");
$pdf->Cell(0,1," ","0",1,"L");

if( $j == 10 )
  {
$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy2010/hlaovyrobes2.jpg') )
  {
$pdf->Image('../dokumenty/vykazy2010/hlaovyrobes2.jpg',3,6,210,294); 
  }

$pdf->SetY(10);


//tab. n·zov v˝robku
$pdf->Cell(190,9,"                          ","0",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(50,5," ","0",0,"C");$pdf->Cell(120,7,"$text_komodita","0",0,"L");$pdf->Cell(0,5,"List Ë. $strana","0",1,"L");
$pdf->Cell(190,14,"                          ","0",1,"L");

  }

$j = $j + 1;

////////////////////////////////////////KONIEC 1.STRANA DVOJSTRANY POLOZKY
                                           }

if( $k >= 32 ) { $k=0; }



////////////////////////////////////////SPOLU
if ( $hlavicka->prx == 100   )    {


if( $j < 11 )
  {
$strana=$strana+1;

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy2010/hlaovyrobes2.jpg') )
  {
$pdf->Image('../dokumenty/vykazy2010/hlaovyrobes2.jpg',3,6,210,294); 
  }

$pdf->SetY(10);


//tab. n·zov v˝robku
$pdf->Cell(190,9,"                          ","0",1,"L");
$pdf->SetFont('arial','',12);
$pdf->Cell(50,5," ","0",0,"C");$pdf->Cell(120,7,"$text_komodita","0",0,"L");$pdf->Cell(0,5,"List Ë. $strana","0",1,"L");
$pdf->Cell(190,14,"                          ","0",1,"L");

  }

//spolu
$pdf->SetFont('arial','',9);
$pdf->SetY(270); $pdf->SetX(33); 
$pdf->Cell(18,7,"$vyroba","0",0,"R");$pdf->Cell(17,7,"$dovoz","0",0,"R");$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(17,7,"$vyvoz","0",0,"R");
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(17,7,"$reexport","0",1,"R");

$pdf->SetFont('arial','',11);

//zodpovedn· osoba
$pdf->SetY(285); $pdf->SetX(48); $pdf->Cell(100,7,"$fir_mzdt05","0",0,"L");


$j=1; 
$k=0;
$strana=0;

////////////////////////////////////////koniec SPOLU
                                  }



}
$i = $i + 1;


  }

$pdf->Output("../tmp/vykazfin.$kli_uzid.pdf");



?>

<script type="text/javascript">
  var okno = window.open("../tmp/vykazfin.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA 

if( $strana == 9999 ) $strana=1;

//nacitaj udaje pre upravu
if ( $zaciatok == 1 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_hlaodpadd2 WHERE daz >= $kli_pume AND daz <= $kli_kume ORDER BY cpl DESC LIMIT 1";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$druh = $fir_riadok->druh;
$daz = $fir_riadok->daz;
$ico = $fir_riadok->ico;
$komodita = $fir_riadok->komodita;
$hod = 0;
$dox = $fir_riadok->dox;

mysql_free_result($fir_vysledok);


    }
//koniec nacitania



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Hl·senie</title>
  <style type="text/css">

  </style>

<?php
if ( $copern == 20 )
{
?>
<script type="text/javascript" src="vykaz_hlaodpad_ico.js"></script>
<?php
}
?>

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

function xIcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.xnaz.focus();
        document.forms.formv1.xnaz.select();
              }
                }

function xNazEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
              if( document.formv1.xnaz.value != '' ){
        document.forms.formv1.xmes.focus();
        document.forms.formv1.xmes.select();
                                                    }
              }
                }

function xMesEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
              if( document.formv1.xmes.value != '' ){
        document.forms.formv1.komodita.focus();
                                                    }
              }
                }

function DruhEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    if ( document.formv1.daz.value == '' ) { document.formv1.daz.value = '<?php echo $kli_vume;?>'; }
    if ( document.formv1.daz.value == '00.0000' ) { document.formv1.daz.value = '<?php echo $kli_vume;?>'; }

        document.forms.formv1.daz.focus();
        document.forms.formv1.daz.select();
              }
                }

function DazEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.ico.focus();
        document.forms.formv1.ico.select();
              }
                }



function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.formv1.ico.value != '')
        {
        myIcoElement.style.display='';
        volajIco(0);
        }      
              }
                }


function Len1Ico(ico,nazov,mesto)
                {
        document.forms.formv1.ico.value = ico + " - " + nazov + " " + mesto;
       if ( document.formv1.komodita.value == 0 ) document.formv1.komodita.value = 1;
        document.forms.formv1.komodita.focus();
                }

function Len0Ico()
                {
                Ico.style.display="";
                document.formv1.xico.value=document.formv1.ico.value;
                document.forms.formv1.xico.focus();
                document.forms.formv1.xico.select();
                }

//co urobi po potvrdeni ok z tabulky ico
function vykonajIco(ico,nazov,mesto,ucb,num,tel)
                {
        document.forms.formv1.ico.value = ico + " - " + nazov + " " + mesto;
        myIcoElement.style.display='none';
       if ( document.formv1.komodita.value == 0 ) document.formv1.komodita.value = 1;
        document.forms.formv1.komodita.focus();
                }


function KomoditaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.dox.focus();
        document.forms.formv1.dox.select();
              }
                }

function DoxEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.hod.focus();
        document.forms.formv1.hod.select();
              }
                }

function HodEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;

    if ( document.formv1.hod.value == '' ) okvstup=0;
    if ( document.formv1.hod.value == 0 ) okvstup=0;
    if ( document.formv1.ico.value == '' ) okvstup=0;
    if ( document.formv1.ico.value == 0 ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true);  document.forms.formv1.submit(); return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

              }
                }

    function ObnovUI()
    {

<?php if ( $strana == 1  )                           { ?>

document.formv1.druh.value = '<?php echo $druh;?>';
document.formv1.daz.value = '<?php echo $daz;?>';
document.formv1.ico.value = '<?php echo $ico;?>';
document.formv1.komodita.value = '<?php echo $komodita;?>';
document.formv1.dox.value = '<?php echo $dox;?>';
document.formv1.hod.value = '<?php echo $hod;?>';

document.forms.formv1.druh.focus();
<?php if ( $icox == 1  ) { echo "document.forms.formv1.ico.focus();\r"; echo "document.forms.formv1.ico.select();\r"; } ?>
<?php if ( $doxx == 1  ) { echo "document.forms.formv1.dox.focus();\r"; echo "document.forms.formv1.dox.select();\r"; } ?>
<?php if ( $hodx == 1  ) { echo "document.forms.formv1.hod.focus();\r"; echo "document.forms.formv1.hod.select();\r"; } ?>

document.formv1.uloz.disabled = true;



<?php                                                } ?>




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


  function TlacVyr()
  { 

<?php if( $tlacodpady == 1 ) { ?>

  var h_o = 0;
  if( document.formv1.h_o.checked ) h_o=1;
  var h_n = 0;
  if( document.formv1.h_n.checked ) h_n=1;

  window.open('vykaz_hlaodpad_zoznam.php?stvrtrok=<?php echo $stvrtrok;?>&copern=10' + '&h_o=' + h_o + '&h_n=' + h_n + '&drupoh=1&page=1&subor=0',
 '_blank', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

<?php                        } ?>

  }

  function TlacDov()
  { 

<?php if( $tlacodpady == 1 ) { ?>

  var h_o = 0;
  if( document.formv1.h_o.checked ) h_o=1;
  var h_n = 0;
  if( document.formv1.h_n.checked ) h_n=1;

  window.open('vykaz_hlaodpad_zoznam.php?stvrtrok=<?php echo $stvrtrok;?>&copern=10' + '&h_o=' + h_o + '&h_n=' + h_n + '&drupoh=2&page=1&subor=0',
 '_blank', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

<?php                        } ?>

  }

  function TlacVyv()
  { 

<?php if( $tlacodpady == 1 ) { ?>

  var h_o = 0;
  if( document.formv1.h_o.checked ) h_o=1;
  var h_n = 0;
  if( document.formv1.h_n.checked ) h_n=1;

  window.open('vykaz_hlaodpad_zoznam.php?stvrtrok=<?php echo $stvrtrok;?>&copern=10' + '&h_o=' + h_o + '&h_n=' + h_n + '&drupoh=3&page=1&subor=0',
 '_blank', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

<?php                        } ?>

  }

  function TlacRee()
  { 

<?php if( $tlacodpady == 1 ) { ?>

  var h_o = 0;
  if( document.formv1.h_o.checked ) h_o=1;
  var h_n = 0;
  if( document.formv1.h_n.checked ) h_n=1;

  window.open('vykaz_hlaodpad_zoznam.php?stvrtrok=<?php echo $stvrtrok;?>&copern=10' + '&h_o=' + h_o + '&h_n=' + h_n + '&drupoh=4&page=1&subor=0',
 '_blank', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

<?php                        } ?>

  }

  function TlacAll()
  { 

<?php if( $tlacodpady == 1 ) { ?>

  window.open('vykaz_hlaodpad_zoznam.php?stvrtrok=<?php echo $stvrtrok;?>&copern=10&drupoh=5&page=1&subor=0',
 '_blank', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );

<?php                        } ?>

  }

  function ImportVyr()
  { 
  var h_i = 0;
  if( document.formv1.h_i.checked ) h_i=1;

  window.open('vykaz_hlaodpad_import.php?stvrtrok=<?php echo $stvrtrok;?>&copern=55' + '&h_i=' + h_i + '&drupoh=1&page=1&subor=0',
 '_self', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
  }

  function ImportDov()
  { 
  var h_i = 0;
  if( document.formv1.h_i.checked ) h_i=1;

  window.open('vykaz_hlaodpad_import.php?stvrtrok=<?php echo $stvrtrok;?>&copern=55' + '&h_i=' + h_i + '&drupoh=2&page=1&subor=0',
 '_self', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
  }

  function ImportVyv()
  { 
  var h_i = 0;
  if( document.formv1.h_i.checked ) h_i=1;

  window.open('vykaz_hlaodpad_import.php?stvrtrok=<?php echo $stvrtrok;?>&copern=55' + '&h_i=' + h_i + '&drupoh=3&page=1&subor=0',
 '_self', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
  }

  function ImportRee()
  { 
  var h_i = 0;
  if( document.formv1.h_i.checked ) h_i=1;

  window.open('vykaz_hlaodpad_import.php?stvrtrok=<?php echo $stvrtrok;?>&copern=55' + '&h_i=' + h_i + '&drupoh=4&page=1&subor=0',
 '_self', 'width=1060, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
  }
   
</script>
</HEAD>
<BODY class="white" id="white" onload="window.scrollTo(0, 3000); ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  HL¡SENIE o objeme v˝roby, dovozu, v˝vozu a reexportu

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>


<?php
//upravy  udaje strana
if ( $copern == 20 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 3 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Ico" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nezn·me I»O</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="../ucto/vykaz_hlaodpad_2015.php?copern=23&stvrtrok=<?php echo $stvrtrok;?>" >



<?php if ( $strana == 1   )                           { ?>

<?php

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_hlaodpadd2 ".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctvykaz_hlaodpadd2.ico=F$kli_vxcf"."_ico.ico".
" WHERE oc >= 0 AND daz >= $kli_pume AND daz <= $kli_kume ORDER BY cpl";


//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i) OR $j == 0 )
{
$rsluz=mysql_fetch_object($sluz);

if( $j == 0 )
     {
$fmenu="fmenu";
$pvstup="pvstup";

?>

<tr>
<td class="obyc" colspan="2">
<td class="obyc" colspan="2">
ico?<input type="checkbox" name="h_i" value="1" />

VYR<img src='../obr/import.png' onClick="ImportVyr();" width=20 height=15 border=0 title='NaËÌtaù v˝robu za <?php echo $stvrtrok;?>.ötvrùrok z CSV' >

DOV<img src='../obr/import.png' onClick="ImportDov();" width=20 height=15 border=0 title='NaËÌtaù dovoz za <?php echo $stvrtrok;?>.ötvrùrok z CSV' >

VYV<img src='../obr/import.png' onClick="ImportVyv();" width=20 height=15 border=0 title='NaËÌtaù v˝voz za <?php echo $stvrtrok;?>.ötvrùrok z CSV' >

REE<img src='../obr/import.png' onClick="ImportRee();" width=20 height=15 border=0 title='NaËÌtaù reexport za <?php echo $stvrtrok;?>.ötvrùrok z CSV' >
</tr>

<tr>
<td class="<?php echo $pvstup ?>" width="8%">Do/V˝voz
<td class="<?php echo $pvstup ?>" width="8%">⁄Ët.Mesiac
<td class="<?php echo $pvstup ?>" width="34%">
 <input type="checkbox" name="icox" value="1"  /> 
<?php if ( $icox == 1 )
       { ?>
<script type="text/javascript">
document.formv1.icox.checked = "checked";
</script>
<?php  } ?>
 I»O
<td class="<?php echo $pvstup ?>" width="20%">Komodita
<td class="<?php echo $pvstup ?>" width="10%" align="right" >Doklad
 <input type="checkbox" name="doxx" value="1"  /> 
<?php if ( $doxx == 1 )
       { ?>
<script type="text/javascript">
document.formv1.doxx.checked = "checked";
</script>
<?php  } ?>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >Hmotnosù v ton·ch
 <input type="checkbox" name="hodx" value="1"  /> 
<?php if ( $hodx == 1 )
       { ?>
<script type="text/javascript">
document.formv1.hodx.checked = "checked";
</script>
<?php  } ?>
<td class="<?php echo $pvstup ?>" width="10%">Zmaû
</tr>

<?php


     }

if( $rsluz->druh == 0 ) $text_druh="V›ROBA";
if( $rsluz->druh == 1 ) $text_druh="DOVOZ";
if( $rsluz->druh == 2 ) $text_druh="V›VOZ";
if( $rsluz->druh == 3 ) $text_druh="REEXPORT";

$text_komodita=NazovKomodity($rsluz->komodita);

?>

<tr>
<td class="fmenu" ><?php echo $text_druh;?></td>
<td class="fmenu" align="left" ><?php echo $rsluz->daz;?></td>
<?php if( $rsluz->ico > 0 ) { ?>
<td class="fmenu" align="left" ><?php echo $rsluz->ico;?> - <?php echo $rsluz->nai;?> <?php echo $rsluz->mes;?> </td>
<?php                       } ?>
<?php if( $rsluz->ico == 0 ) { ?>
<td class="fmenu" align="left" >0 <img src='../obr/info.png' width=15 height=10 border=0 title="Nezn·ma firma ???" > <?php echo $rsluz->xmen;?> </td>
<?php                        } ?>
<td class="fmenu" align="left" ><?php echo $text_komodita;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->dox;?></td>
<td class="fmenu" align="right" ><?php echo $rsluz->hod;?></td>
<td class="fmenu" width="5%" >
<a href='vykaz_hlaodpad_2015.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&stvrtrok=<?php echo $stvrtrok;?>&upravit=1'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù riadok" ></a>

 <a href='vykaz_hlaodpad_2015.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&stvrtrok=<?php echo $stvrtrok;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
</td>
</tr>

<?php
}

$i = $i + 1;
$j = $j + 1;
  }
              
?>

<tr>
<td class="bmenu" colspan="1" >
<td class="bmenu" colspan="1" ><?php echo $kli_vume; ?>
<td class="bmenu" align="left" colspan="8" > NovÈ I»O
<input class="hvstup" type="text" name="xico" id="xico" size="10" maxlength="10" onKeyDown="return xIcoEnter(event.which)" 
 onclick="myIcoElement.style.display='none'; Ico.style.display='none';" />

N·zov firmy
<input class="hvstup" type="text" name="xnaz" id="xnaz" size="50" maxlength="50" onKeyDown="return xNazEnter(event.which)" 
 onclick="myIcoElement.style.display='none'; Ico.style.display='none';" />

Mesto
<input class="hvstup" type="text" name="xmes" id="xmes" size="30" maxlength="30" onKeyDown="return xMesEnter(event.which)" 
 onclick="myIcoElement.style.display='none'; Ico.style.display='none';" />
</td>
</tr>

<tr>
<td class="fmenu" >
<select size="1" name="druh" id="druh" onKeyDown="return DruhEnter(event.which)" >
<option value="0" >V›ROBA</option>
<option value="1" >DOVOZ</option>
<option value="2" >V›VOZ</option>
<option value="3" >REEXPORT</option>
</td>

<td class="fmenu" align="left" >
<input class="hvstup" type="text" name="daz" id="daz" size="7" maxlength="7" onKeyDown="return DazEnter(event.which)" />
</td>
<td class="fmenu" align="left" >
<img src='../obr/hladaj.png' border="1" onclick="myIcoElement.style.display=''; volajIco(1);" title="Hæadaj zadanÈ I»O alebo n·zov firmy" >

<input class="hvstup" type="text" name="ico" id="ico" size="50" maxlength="50" onKeyDown="return IcoEnter(event.which)" 
 onclick="myIcoElement.style.display='none'; Ico.style.display='none';" />
</td>
<td class="fmenu" align="left" >
<select size="1" name="komodita" id="komodita"  onKeyDown="return KomoditaEnter(event.which)" >
<option value="1" >obaly z papiera "O"</option>
<option value="101" >obaly z papiera "N"</option>
<option value="2" >obaly z plastov "O"</option>
<option value="102" >obaly z plastov "N"</option>
<option value="3" >obaly z kovu Al "O"</option>
<option value="103" >obaly z kovu Al "N"</option>
<option value="4" >obaly z kovu Fe "O"</option>
<option value="104" >obaly z kovu Fe "N"</option>
<option value="5" >obaly zo skla "O"</option>
<option value="105" >obaly zo skla "N"</option>
<option value="6" >viacvrstv.obaly "O"</option>
<option value="106" >viacvrstv.obaly "N"</option>
<option value="7" >elektroz. tr1</option>
<option value="8" >elektroz. tr2</option>
<option value="9" >elektroz. tr3</option>
<option value="10" >elektroz. tr4</option>
<option value="11" >elektroz. tr5 sv.zdroje</option>
<option value="12" >elektroz. tr6</option>
<option value="13" >elektroz. tr7</option>
<option value="14" >elektroz. tr8</option>
<option value="15" >elektroz. tr9</option>
<option value="16" >batÈrie pren.</option>
<option value="17" >batÈrie priem.</option>
<option value="18" >batÈrie auto</option>
<option value="19" >pneumatiky</option>
<option value="20" >oleje</option>
<option value="21" >sklo tovar</option>
<option value="22" >viacvrst.mat.</option>
<option value="23" >papier tovar</option>
<option value="24" >plasty tovar</option>
<option value="25" >elektroz. tr5 svietidl·</option>


</select>
</td>
<td class="fmenu" align="right" >
<input class="hvstup" type="text" name="dox" id="dox" size="10" maxlength="10" onKeyDown="return DoxEnter(event.which)" />
</td>

<td class="fmenu" align="right" >
<input class="hvstup" type="text" name="hod" id="hod" size="10" maxlength="10" onKeyDown="return HodEnter(event.which)" 
 onkeyup="KontrolaDcisla(this, Desc)" />
</td>
<td class="fmenu" >
 
</td>
</tr>


<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù"></td>
<td class="obyc" colspan="2">
O<input type="checkbox" name="h_o" value="1" />

+

N<input type="checkbox" name="h_n" value="1" />

<?php if( $tlacodpady == 1 ) { ?>

VYR<img src='../obr/tlac.png' onClick="TlacVyr();" width=20 height=15 border=0 title='VytlaËiù v˝robu za <?php echo $stvrtrok;?>.ötvrùrok' >

DOV<img src='../obr/tlac.png' onClick="TlacDov();" width=20 height=15 border=0 title='VytlaËiù dovoz za <?php echo $stvrtrok;?>.ötvrùrok' >

VYV<img src='../obr/tlac.png' onClick="TlacVyv();" width=20 height=15 border=0 title='VytlaËiù v˝voz za <?php echo $stvrtrok;?>.ötvrùrok' >

REE<img src='../obr/tlac.png' onClick="TlacRee();" width=20 height=15 border=0 title='VytlaËiù reexport za <?php echo $stvrtrok;?>.ötvrùrok' >

<?php                        } ?>

<td class="obyc" colspan="2">

<?php if( $tlacodpady == 1 ) { ?>

ALL<img src='../obr/tlac.png' onClick="TlacAll();" width=20 height=15 border=0 title='VytlaËiù pohyby vöetk˝ch v˝robkov za <?php echo $stvrtrok;?>.ötvrùrok' >

<?php                        } ?>

</tr>

<?php                                                 } //koniec 1.strana ?>






</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>
<div id="myIcoElement"></div>

<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje 
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
