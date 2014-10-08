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

//ramcek fpdf
$rmc=0;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) $strana=1;


$prepoc = 1*$_REQUEST['prepoc'];
$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//priezvisko,meno,titul FO
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob".
" WHERE oc = 9999 ORDER BY oc";

$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
if ( $fir_uctt03 == 999 )
{
$fnazov = $fir_riadok->dmeno." ".$fir_riadok->dprie." ".$fir_riadok->dtitl;
$dadresa = $fir_riadok->duli." "." ".$fir_riadok->dcdm." ".$fir_riadok->dmes;
}
if( $fir_uctt03 != 999 )
{
$fadresa = $fir_fuli." ".$fir_fcdm." ".$fir_fmes;
$fnazov = $fir_fnaz;
}



// zapis upravene udaje
if ( $copern == 23 )
    {


$da1 = strip_tags($_REQUEST['da1']);
$da1sql=SqlDatum($da1);

$da2 = strip_tags($_REQUEST['da2']);
$da2sql=SqlDatum($da2);



if ( $strana == 1 )    {

$uprtxt = "UPDATE F$kli_vxcf"."_mzdoznam_student SET ".
" da1='$da1sql', da2='$da2sql' ".
" WHERE oc = $cislo_oc"; 

                       }

$upravene = mysql_query("$uprtxt");  

$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov

//prac.subor a subor vytvorenych 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT oc FROM F".$kli_vxcf."_mzdoznam_student";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdoznam_student';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   da1          DATE,
   da2          DATE,
   konx1        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdoznam_student'.$sqlt;
$vytvor = mysql_query("$vsql");

}
//koniec vytvorenie oznamenie


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdoznam_student";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_mzdoznam_student";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");




$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdoznam_student WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if( $jepotvrd == 0 ) $subor=1;

//pre rocne vytvor pracovny subor
if( $subor == 1 )
{


$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprcvypl$kli_uzid ( druh,oc ) VALUES  ( 1, '$cislo_oc' )";
$ttqq = mysql_query("$ttvv");


//uloz do priznania
$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdoznam_student WHERE oc = $cislo_oc";
$oznac = mysql_query("$sqtoz");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdoznam_student".
" SELECT * FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE oc = $cislo_oc ".
" GROUP BY oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$prepoc=1;
}
//koniec pracovneho suboru 




/////////////////////////////////////////////////VYTLAC OZNAMENIE
if( $copern == 10 )
{


if (File_Exists ("../tmp/oznamenie.$kli_uzid.pdf")) { $soubor = unlink("../tmp/oznamenie.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdoznam_student".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznam_student.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdoznam_student.oc = $cislo_oc AND konx1 = 0 ORDER BY F$kli_vxcf"."_mzdoznam_student.oc";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);



if ( $strana == 1 OR $strana == 9999 )    {

$pdf->Addpage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

//tady upravis velkost na original

if (File_Exists ('../dokumenty/mzdy_potvrdenia/oznamenie_studenta/Oznamenie_strana1.jpg') )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/oznamenie_studenta/Oznamenie_strana1.jpg',1,0,209,297); 
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//zamestnanec - priezvisko, meno a titul
$pdf->Cell(190,57,"                          ","$rmc",1,"L");
$pdf->Cell(34,6," ","$rmc",0,"R");$pdf->Cell(71,5,"$hlavicka->prie","$rmc",0,"L");
$pdf->Cell(9,6," ","$rmc",0,"R");$pdf->Cell(40,5,"$hlavicka->meno","$rmc",0,"L");
$pdf->Cell(8,6," ","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->titl","$rmc",1,"L");

//zamestnanec - rodne cislo
$pdf->Cell(190,1,"                          ","$rmc",1,"L");
$pdf->Cell(37,6," ","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->rdc / $hlavicka->rdk","$rmc",1,"L");

//zamestnanec - pobyt
$pdf->Cell(190,1,"                          ","$rmc",1,"L");
$pdf->Cell(55,6," ","$rmc",0,"R");$pdf->Cell(135,5,"$hlavicka->zuli $hlavicka->zcdm ","$rmc",1,"L");

//zamestnavatel - nazov
$pdf->Cell(190,13,"                          ","$rmc",1,"L");
$fnazov = $fir_fnaz;
if ( $fir_uctt03 == 999 ) $fnazov = $fir_riadok->dmeno." ".$fir_riadok->dprie." ".$fir_riadok->dtitl;
$pdf->Cell(29,6," ","$rmc",0,"R");$pdf->Cell(161,5,"$fnazov","$rmc",1,"L");

//zamestnavatel - trvaly pobyt
$pdf->Cell(190,1,"                          ","$rmc",1,"L");
if ( $fir_uctt03 != 999 ) $dadresa = " "; 
$pdf->Cell(39,6," ","$rmc",0,"R");$pdf->Cell(151,5,"$dadresa","$rmc",1,"L");

//zamestnavatel - sidlo
$pdf->Cell(190,1,"                          ","$rmc",1,"L");
if ( $fir_uctt03 == 999 ) $fadresa = " ";
$pdf->Cell(27,6," ","$rmc",0,"R");$pdf->Cell(163,6,"$fadresa","$rmc",1,"L");

//datum1
$pdf->Cell(190,9,"                          ","$rmc",1,"L");
$text="01012010";
$text=SKDatum($hlavicka->da2);
if( $text =='00.00.0000' ) $text="";
$pdf->Cell(26,6," ","$rmc",0,"R");$pdf->Cell(33,5,"$text","$rmc",1,"C");

//datum dna
$pdf->Cell(190,63,"                          ","$rmc",1,"L");

$text="01012010";
$text=SKDatum($hlavicka->da1);
if( $text =='00.00.0000' ) $text="";
$pdf->Cell(26,6," ","$rmc",0,"R");$pdf->Cell(29,6,"$text","$rmc",1,"C");

                                          }

if ( $strana == 2 OR $strana == 9999 )    {

$pdf->Addpage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

//tady upravis velkost na original

if (File_Exists ('../dokumenty/mzdy_potvrdenia/oznamenie_studenta/Oznamenie_strana2.jpg') )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/oznamenie_studenta/Oznamenie_strana2.jpg',1,0,209,297); 
}

                                          }


}
$i = $i + 1;

  }

$pdf->Output("../tmp/oznamenie.$kli_uzid.pdf");





?>

<script type="text/javascript">
  var okno = window.open("../tmp/oznamenie.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA ROCNEHO


//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdoznam_student".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdoznam_student.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdoznam_student.oc = $cislo_oc AND konx1 = 0 ORDER BY F$kli_vxcf"."_mzdoznam_student.oc";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$titl = $fir_riadok->titl;
$h_rdc = $fir_riadok->rdc;
$h_rdk = $fir_riadok->rdk;
$zuli = $fir_riadok->zuli." ".$fir_riadok->zcdm." ".$fir_riadok->zmes;


//echo "meno".$meno;

$da1 = $fir_riadok->da1;
$da1sk=SkDatum($da1);
$da2 = $fir_riadok->da2;
$da2sk=SkDatum($da2);



    }
//koniec nacitania

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Oznámenie študenta</title>

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

<?php if ( $strana == 1 OR $strana == 9999 )                           { ?>

    document.formv1.da1.value = '<?php echo "$da1sk";?>';

    document.formv1.da2.value = '<?php echo "$da2sk";?>';
<?php                                                                   } ?>




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
			{text=text + "Rok nemoze byt väèší ako 2029.\r"; err=3 }
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
window.open('../mzdy/oznamenie_student.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Oznámenie a èestné vyhlásenie študenta</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<?php if( $copern == 20 ) { ?>

<table class="h2" width="100%" >
<tr>
<td align="left">

<?php
$prepoc=1;
$novy=0;
if( $novy == 0 )
{
$prev_oc=$cislo_oc-1; 
$next_oc=$cislo_oc+1;

if( $prev_oc == 0 ) $prev_oc=1;
if( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc DESC LIMIT 1"); 
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }

if( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $next_oc=$next_oc+1;
if( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;

if( $prev_oc == 0 ) $prev_oc=1;
if( $next_oc > 9999 ) $next_oc=9999;
?>
<a href="#" onClick="window.open('oznamenie_student.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $prev_oc;?>', '_self' )">
<img src='../obr/prev.png' width=12 height=12 border=0 title='Zamestnanec osè <?php echo $prev_oc; ?>' ></a>
<a href="#" onClick="window.open('oznamenie_student.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $next_oc;?>', '_self' )">
<img src='../obr/next.png' width=12 height=12 border=0 title='Zamestnanec osè <?php echo $next_oc; ?>' ></a>
<?php
}
//koniec novy=0
?>

<?php echo "Os.è.: $oc $meno $prie ";?>

<a href="#" onClick="window.open('../mzdy/oznamenie_student.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
 '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Tlaè do PDF' ></a>

</td>

<td colspan="2">
<a href="#" onClick="window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_oc=<?php echo $cislo_oc;?>&h_oc=<?php echo $cislo_oc;?>',
 '_blank','width=1060, height=900, top=0, left=12, status=yes, resizable=yes, scrollbars=yes')">
<img src='../obr/uprav.png' width=15 height=15 border=0 title='Úprava údajov o zamestnancovi' ></a>
</td>
</tr>
</table>

<?php                     } ?>

<?php
//upravy  udaje strana
if ( $copern == 20 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musí by celé kladné èíslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Dátum musí by v tvare DD.MM.RRRR,DD.MM alebo DD napríklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 2 desatinné miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 4 desatinné miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 1 desatinné miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OSÈ musí by celé kladné èíslo v rozsahu 1 a 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Musíte vyplni všetky poloky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloka OSÈ=<?php echo $h_oc;?> správne uloená</span>
</tr>

<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="oznamenie_student.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>" >
<tr>
<td width="10%"></td><td width="10%"></td><td width="10%"></td><td width="10%"></td><td width="10%"></td>
<td width="10%"></td><td width="10%"></td><td width="10%"></td><td width="10%"></td><td width="10%"></td>
</tr>
<tr style="display:none" >
<td class="bmenu" colspan="10"> Strana <?php echo $strana;?>
<?php
$prev_str=$strana-1;
$next_str=$strana+1;
if( $prev_str == 0 ) $prev_str=6;
if( $next_str == 7 ) $next_str=1;
?>
<a href="#" onClick="window.open('oznamenie_student.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $prev_str;?>', '_self' )">
<img src='../obr/prev.png' width=12 height=12 border=0 title='Strana <?php echo $prev_str;?> Zamestnanec osè <?php echo $cislo_oc; ?>' ></a>
<a href="#" onClick="window.open('oznamenie_student.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $next_str;?>', '_self' )">
<img src='../obr/next.png' width=12 height=12 border=0 title='Strana <?php echo $next_str;?> Zamestnanec osè <?php echo $cislo_oc; ?>' ></a>
<span style="display:none">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Uprav vybranú stranu è." ></a>
<a href="#" onClick="window.open('../mzdy/oznamenie_student.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=1&subor=0&strana=1', '_self' );">1</a>
</span>
<span style="display:none;">
<img src='../obr/tlac.png' width=20 height=15 border=0 title="Tlaèi vybranú stranu è." ></a>
<a href="#" onClick="window.open('../mzdy/oznamenie_student.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=1', '_self' );">1</a>
</span>
</td>
</tr>

<tr>
<td class="bmenu" colspan="8" style="font-weight:normal;">Zamestnanec</td>
<td class="bmenu" colspan="2" align="center"><INPUT type="submit" id="uloz" name="uloz" value="Uloi zmeny"></td>
</tr>
<tr>
<td class="bmenu" colspan="2">&nbsp;&nbsp;&nbsp;Priezvisko</td>
<td class="bmenu" colspan="2"><input type="text" name="prie" id="prie" size="25" value="<?php echo $prie; ?>" disabled="disabled" style="padding:1px;" /></td>
<td class="bmenu" colspan="1">Meno</td>
<td class="bmenu" colspan="2"><input type="text" name="meno" id="meno" size="15" value="<?php echo $meno; ?>" disabled="disabled" style="padding:1px;" /></td>
<td class="bmenu" colspan="1">Titul&nbsp;&nbsp;
<input type="text" name="titl" id="titl" size="5" value="<?php echo $titl; ?>" disabled="disabled" style="padding:1px;" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2">&nbsp;&nbsp;&nbsp;Rodné èíslo</td>
<td class="bmenu" colspan="2">
<input type="text" name="h_rdc" id="h_rdc" size="5" value="<?php echo $h_rdc; ?>" disabled="disabled" style="padding:1px;" /> /
<input type="text" name="h_rdk" id="h_rdk" size="2" value="<?php echo $h_rdk; ?>" disabled="disabled" style="padding:1px;" />
</td>
<td class="bmenu" colspan="1">Trvalı pobyt</td>
<td class="bmenu" colspan="4"><input type="text" name="zuli" id="zuli" size="40" value="<?php echo $zuli; ?>" disabled="disabled" style="padding:1px;" /></td>
</tr>
<tr>
<td class="bmenu" colspan="10" style="font-weight:normal;">Zamestnávate¾</td>
</tr>
<tr>
<td class="bmenu" colspan="2">&nbsp;&nbsp;&nbsp;Názov</td>
<td class="bmenu" colspan="7"><input type="text" name="fnazov" id="fnazov" size="50" value="<?php echo $fnazov; ?>" disabled="disabled" style="padding:1px;" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2">&nbsp;&nbsp;&nbsp;Trvalı pobyt</td>
<td class="bmenu" colspan="7"><input type="text" name="dadresa" id="dadresa" size="50" value="<?php echo $dadresa; ?>" disabled="disabled" style="padding:1px;" /><br></td>
</tr>
<tr>
<td class="bmenu" colspan="2">&nbsp;&nbsp;&nbsp;Sídlo</td>
<td class="bmenu" colspan="7"><input type="text" name="fadresa" id="fadresa" size="50" value="<?php echo $fadresa; ?>" disabled="disabled" style="padding:1px;" /><br></td>
</tr>


<tr><td class="bmenu" colspan="10" style="height:10px;"></td></tr>
<tr>
<td class="bmenu" colspan="10" style="font-weight:normal; padding:0 1%; font-size:13px; text-align:justify;">
<p style="text-indent:2%;">
<strong>Oznamujem</strong>&nbsp;Vám, e dohodu o brigádnickej práci študentov, ktorú som s Vami uzatvoril(a) dòa <input type="text" name="da2" id="da2" size="10" />
<strong>urèujem pod¾a § 227a</strong>&nbsp;zákona è. 461/2003 Z.z. o sociálnom poistení v znení zákona è. 413/2012 Z.z. ako dohodu o brigádnickej práci študentov,
na základe ktorej nebudem ma postavenie zamestnanca na úèely dôchodkového poistenia po splnení podmienok ustanovenıch tımto zákonom.</p>
<p style="text-indent:2%;">
<strong>Zároveò èestne vyhlasujem, e právo urèi dohodu o brigádnickej práci študentov</strong>pod¾a § 227a zákona è. 461/2003 Z. z. o sociálnom poistení v znení zákona
è. 413/2012 Z.z.&nbsp;<strong>si súèasne neuplatòujem u iného zamestnávate¾a v tom istom kalendárnom mesiaci.</strong>
</p>
<p style="text-indent:2%;">Èestne vyhlasujem, e pred podpísaním tohto vyhlásenia som sa oboznámil(a) s pouèením, kto sa povauje za zamestnanca na úèely dôchodkového
poistenia pod¾a § 4 ods. 2 zákona  o sociálnom poistení, o podmienkach uplatòovania práva pod¾a § 227a zákona o sociálnom poistení a všetky skutoènosti, ktoré som uviedol(la)
v tomto vyhlásení, sú pravdivé.
</p>
<p style="text-indent:2%;">Uvedomujem si právne následky nepravdivého èestného vyhlásenia.</p>
<br>
Dòa&nbsp;<input type="text" name="da1" id="da1" size="10" />
</td>
</tr>
<tr><td class="bmenu" style="height:4px;"></td></tr>


<?php if ( $strana == 1 OR $strana == 9999 )                           { ?>

<?php                                                                  } //koniec 1.strana ?>




</FORM>
</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje 
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
       } while (false);
?>
</BODY>
</HTML>
