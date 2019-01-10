<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 10000;
$cslm=310;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

$databaza="";
$dtb2 = include("oddel_dtbz1.php");

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
$copernx = 1*$_REQUEST['copernx'];
if( $copernx == 0 ) $copernx=$copern;
$h_ycf = 1*$_REQUEST['h_ycf'];
$h_xcf = 1*$_REQUEST['h_xcf'];
$upozorni2011 = 1*$_REQUEST['upozorni2011'];
$upozorni2012 = 1*$_REQUEST['upozorni2012'];
$upozorni2013 = 1*$_REQUEST['upozorni2013'];

//$copern=1 Sklad
//$copern=2 Majetok
//$copern=3 Doprava
//$copern=9 Mzdy
//$copern=10 Uctovnictvo
//$copern=8 Vyroba

//echo $copern;

$citfir = include("../cis/citaj_fir.php");
//ak hosp.rok rovnake roky
if( $hosprok == 1 AND $kli_vrok == $fir_allx12 ) { $databaza=""; }

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//ak chcem pri oddelenych databazach docasne zmenit databazu, z ktorej berie udaje pre firmu cislo  $kli_vxcf
if( $kli_vxcf == 0 )
  {
$databaza=$mysqldb2015.".";

echo "db".$databaza;
  }

//znovu prenos z 2017 do 2018 UCTO a MAJ ak nastavena firma minuleho roku 2017 a rok 2017 v udajoch o firme, a 
//cislo firmy 2018 musi byt vacsie ako cislo firmy 2017
$aj2013=0;
if( $fir_allx11 > 0 AND $fir_allx11 < $kli_vxcf AND $kli_vrok == 2018 AND $fir_allx12 == 2017 )
{
if( $copern == 2 OR $copern == 10   )  { $aj2013=1; }
if( $copernx == 2 OR $copernx == 10 )  { $aj2013=1; }
}

//ak chcem dovolit natvrdo prenos z 2017 do 2018, inak dovoli v UCTO a MAJ ak nastavena firma roku 2017 a rok 2017 v udajoch o firme
if( $kli_vxcf == 0 )
  {
$aj2013=1;
  }

//echo $kli_vrok;

if( $kli_vrok == 2018 AND $aj2013 == 0 )
    {
?>
<script type="text/javascript">
alert ("                   POZOR ! \r MusÌte byù vo firme roku 2019 ! ");
window.close();
</script>
<?php
exit;
    }
//koniec ak nie je firma roku 2019



if( $kli_vrok == 2018 AND $upozorni2013 == 1 )
    {
?>
<script type="text/javascript">
alert ("           POZOR !!! Nie ste vo firme roku 2019 !  \r  Chcete znovu pren·öaù ˙daje do roku 2018 z roku 2017 ??? ");
</script>
<?php
    }
//koniec ak nie je firma roku 2019

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Prenos poc.stavov</title>
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
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>

<script type="text/javascript" src="sal_ico_xml.js"></script>
<script type="text/javascript" src="sal_saldo_xml.js"></script>

<script type="text/javascript">
//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

//posuny Enter[[[[[[[[[[[





function VyberVstup()
                {

                }

<?php if( $copern == 1 OR $copernx == 1 ) { ?>
function PrenesSkl()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;


if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=101&copernx=1&drupoh=1&page=1', '_self' );
                     }
                }
<?php                                        } ?>

<?php if( $copern == 2 OR $copernx == 2 ) { ?>
function PrenesMaj()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;


if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=102&copernx=2&drupoh=1&page=1', '_self' );
                     }
                }
<?php                                        } ?>


<?php if( $copern == 3 OR $copernx == 3 ) { ?>
function PrenesDop()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;


if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=103&copernx=3&drupoh=1&page=1', '_self' );
                     }
                }
<?php                                        } ?>


<?php if( $copern == 9 OR $copernx == 9 ) { ?>
function PrenesMzdy()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;


if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=109&copernx=9&drupoh=1&page=1', '_self' );
                     }
                }
<?php                                        } ?>

<?php if( $copern == 10 OR $copernx == 10 ) { ?>
function PrenesUcto()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;


if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=110&copernx=10&drupoh=1&page=1', '_self' );
                     }
                }
<?php                                        } ?>


<?php if( $copern == 8 OR $copernx == 8 ) { ?>
function PrenesVyroba()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;


if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=108&copernx=8&drupoh=1&page=1', '_self' );
                     }
                }
<?php                                        } ?>

function PrenesCis()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=121&copernx=<?php echo $copernx; ?>&drupoh=1&page=1', '_self' );
                     }
                }

function PrenesFir()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=122&copernx=<?php echo $copernx; ?>&drupoh=1&page=1', '_self' );
                     }
                }

function PrenesUcis()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=123&copernx=10&drupoh=1&page=1', '_self' );
                     }
                }

function PrenesCudz()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=124&copernx=10&drupoh=1&page=1', '_self' );
                     }
                }


function PrenesMzdyCis()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=221&copernx=9&drupoh=1&page=1', '_self' );
                     }
                }

function PrenesSaldo()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=210&copernx=10&drupoh=1&page=1&dajx1=1', '_self' );
                     }
                }

function PrenesSaldo2()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=210&copernx=10&drupoh=1&page=1&dajx2=1', '_self' );
                     }
                }

function PrenesSaldo3()
                {
var h_ycf = 1*document.forms.forms1.h_ycf.value;

if( h_ycf > 0 )      {
window.open('../cis/prenos_poc.php?h_ycf=' + h_ycf + '&h_xcf=<?php echo $kli_vxcf; ?>&copern=210&copernx=10&drupoh=1&page=1&dajx3=1', '_self' );
                     }
                }

function HelpUcto()
                {

window.open('../cis/Prenos_UCTO_2019.pdf',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function HelpMaj()
                {

window.open('../cis/Prenos_MAJETOK_2019.pdf',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function HelpMzdy()
                {

window.open('../cis/Prenos_MZDY_2019.pdf',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function HelpSklad()
                {

window.open('../cis/Prenos_SKLAD_a_FAKTURY_2019.pdf',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  </script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Prenos poËiatoËnÈho stavu 
<?php 

$prenesciselniky=0;
$prenesufir=0;
$prenesucis=0;
$prenessaldo=0;
$prenescudz=0;
//echo $copern;
$copernco=$copern;

if( $copern == 121 ) 
{
$prenesciselniky=1;
$copern=$copernx; 
} 
if( $copern == 122 ) 
{
$prenesufir=1;
$copern=$copernx; 
} 
if( $copern == 123 ) 
{
$prenesucis=1;
$copern=$copernx; 
} 
if( $copern == 124 ) 
{
$prenescudz=1;
$copern=$copernx; 
} 
if( $copern == 210 ) 
{
$prenessaldo=1;
$copern=$copernx; 
} 

if( $copern == 221 ) 
{
$prenescismzdy=1;
$copern=$copernx; 
} 

?>


<?php if( $copern == 1 OR $copern == 101 ) { echo "SKLAD"; } ?>
<?php if( $copern == 2 OR $copern == 102 ) { echo "MAJETOK"; } ?>
<?php if( $copern == 3 OR $copern == 103 ) { echo "DOPRAVA"; } ?>
<?php if( $copern == 9 OR $copern == 109 ) { echo "Mzdy"; } ?>
<?php if( $copern == 10 OR $copern == 110 ) { echo "⁄»TOVNÕCTVO"; } ?>
<?php if( $copern == 8 OR $copern == 108 ) { echo "V›ROBA"; } ?>
 do F<?php echo $kli_vxcf;?> - <?php echo $kli_nxcf;?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php if( $copern >= 100 AND $copern <= 110 ) { $copernxy=$copern; $copern=$copernxy-100;  } ?>


<?php
$sql = "SELECT pods FROM prenosy ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE prenosy ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   kto          VARCHAR(10) NOT NULL,
   pods         VARCHAR(10) NOT NULL,
   co           VARCHAR(10) NOT NULL,
   zfir         VARCHAR(10) NOT NULL,
   zrok         VARCHAR(10) NOT NULL,
   dofir        VARCHAR(10) NOT NULL,
   dorok        VARCHAR(10) NOT NULL,
   kedy         TIMESTAMP(14)
);
statistika_p1304;

$vsql = "CREATE TABLE prenosy ".$sqlt;
$vytvor = mysql_query("$vsql");

}
 
//echo $copernco;
if( $copernco > 100 )
{

$vsql = "INSERT INTO prenosy ( kto, pods, co, zfir, zrok, dofir, dorok ) VALUES ".
" ( '$kli_uzid', '$copern', '$copernco', '$h_ycf', '$fir_allx12', '$kli_vxcf', '$kli_vrok' )  ";
$vytvor = mysql_query("$vsql");

}


?>


<?php
//vyber firmy
if( $copern < 100 )
{
?>
<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="40%">Z akej firmy chcete preniesù poË.stav do firmy , v ktorej ste nastavenÌ
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">

</tr>
<FORM name="forms1" class="obyc" method="post" action="#" >

<tr>
<td class="hmenu">
<?php
$pole = explode(",", $kli_txt1);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
$akefirmy = "( xcf >= $kli_fmin0 AND xcf <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin1 AND xcf <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin2 AND xcf <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin3 AND xcf <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin4 AND xcf <= $kli_fmax4 )";


if( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) 
{ 

$mysqldbfir="";
$dtb2 = include("oddel_dtbm1.php");
$setuzfir = include("vybuzfir.php"); 
}

$rokmin=$kli_vrok-1;
//echo "rokmin".$rokmin;
$podmxcf="xcf != ".$kli_vxcf." AND rok < ".$kli_vrok." AND rok = ".$rokmin;
if( $fir_allx11 > 0 ) $podmxcf="xcf = ".$fir_allx11." AND xcf != ".$kli_vxcf." AND rok <= ".$kli_vrok;
$sqlttt = "SELECT * FROM fir WHERE ( $akefirmy ) AND $podmxcf ORDER BY xcf";
//echo $sqlttt;
$sql = mysql_query("$sqlttt");
?>
<select size="1" name="h_ycf" id="h_ycf" >
<?php if( $fir_allx11 == 0 ) { ?>
<option value="0" >
000 - Vyberte firmu , z ktorej chcete preniesù poË.stav</option>
<?php                        } ?>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["xcf"];?>" >
<?php echo $zaznam["xcf"];?> - <?php echo $zaznam["naz"];?> - <?php echo $zaznam["rok"];?></option>
<?php endwhile;?>
<?php if( $kli_uzid == 171717 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) 
{ echo "<option value='667' >667</option>"; } ?>
</select>
<?php if( $copern == 10 ) { ?>
HELP<img src='../obr/info.png' width=20 height=20 border=0
onClick="HelpUcto();"
 title='Help - prenos poËiatoËn˝ch stavov ˙ËtovnÌctva' >
<?php                     } ?>
<?php if( $copern == 9 ) { ?>
HELP<img src='../obr/info.png' width=20 height=20 border=0
onClick="HelpMzdy();"
 title='Help - prenos poËiatoËn˝ch stavov miezd' >
<?php                     } ?>
<?php if( $copern == 1 ) { ?>
HELP<img src='../obr/info.png' width=20 height=20 border=0
onClick="HelpSklad();"
 title='Help - prenos poËiatoËn˝ch stavov sklad a fakt˙ry' >
<?php                     } ?>
<?php if( $copern == 2 ) { ?>
HELP<img src='../obr/info.png' width=20 height=20 border=0
onClick="HelpMaj();"
 title='Help - prenos poËiatoËn˝ch stavov majetku' >
<?php                     } ?>
</td>

<td class="hmenu" width="20%" colspan="2">


<?php if( $copern == 10 ) { ?>
UCT<img src='../obr/ok.png' width=20 height=20 border=0
onClick="PrenesUcto();"
 title='Prenos poËiatoËn˝ch stavov ˙Ëtovej osnovy - preËÌtajte si prosÌm pred prenosom HELP' >
<?php if( $fir_big == 0 )      { ?>
SAL<img src='../obr/ziarovka.png' width=20 height=20 border=0
onClick="PrenesSaldo();"
 title='Prenos poËiatoËn˝ch stavov saldokonta - preËÌtajte si prosÌm pred prenosom HELP' >
<?php                          } ?>

<?php if( $fir_big == 1 )      { ?>
SAL<img src='../obr/ziarovka.png' width=20 height=20 border=0
onClick="PrenesSaldo();"
 title='Prenos poËiatoËn˝ch stavov saldokonta ODBERATEºSK… FAKT⁄RY - preËÌtajte si prosÌm pred prenosom HELP' >
 <img src='../obr/ziarovka.png' width=20 height=20 border=0
onClick="PrenesSaldo2();"
 title='Prenos poËiatoËn˝ch stavov saldokonta DOD¡VATEºSK… FAKT⁄RY - preËÌtajte si prosÌm pred prenosom HELP' >
 <img src='../obr/ziarovka.png' width=20 height=20 border=0
onClick="PrenesSaldo3();"
 title='Prenos poËiatoËn˝ch stavov saldokonta ⁄HRADY - preËÌtajte si prosÌm pred prenosom HELP' >
<?php                          } ?>

<?php                     } ?>

<?php if( $copern == 9 )  { ?>
MZD<img src='../obr/ok.png' width=20 height=20 border=0
onClick="PrenesMzdy();"
 title='Prenos kmeÚov˝ch ˙dajov, trval˝ch poloûiek, DDP - preËÌtajte si prosÌm pred prenosom HELP' >

<?php                     } ?>

<?php if( $copern == 8 )  { ?>
VYR<img src='../obr/ok.png' width=20 height=20 border=0
onClick="PrenesVyroba();"
 title='Prenos datab·z v˝roby' >

<?php                     } ?>

<?php if( $copern == 3 )  { ?>
DOP<img src='../obr/ok.png' width=20 height=20 border=0
onClick="PrenesDop();"
 title='Prenos ˙dajov podsystÈmu DOPRAVA - preËÌtajte si prosÌm pred prenosom HELP' >

<?php                     } ?>

<?php if( $copern == 2 )  { ?>
MAJ<img src='../obr/ok.png' width=20 height=20 border=0
onClick="PrenesMaj();"
 title='Prenos ˙dajov podsystÈmu MAJETOK - preËÌtajte si prosÌm pred prenosom HELP' >

<?php                     } ?>

<?php if( $copern == 1 )  { ?>
SKL<img src='../obr/ok.png' width=20 height=20 border=0
onClick="PrenesSkl();"
 title='Prenos ˙dajov podsystÈmu SKLAD - preËÌtajte si prosÌm pred prenosom HELP' >

<?php                     } ?>


</td>

<td class="hmenu" width="10%">
<?php if( $copern == 10 ) { ?>
UCC<img src='../obr/zoznam.png' width=20 height=20 border=0
onClick="PrenesUcis();"
 title='Prenos ËÌselnÌkov ⁄ËtovnÌctva ( druhy dokladov, b·nk, pokladnÌc, druhy daÚov˝ch dokladov, ˙Ëtovn˝ch pohybov... ) - preËÌtajte si prosÌm pred prenosom HELP' >

PCU<img src='../obr/banky/dollar2.jpg' width=20 height=20 border=0
onClick="PrenesCudz();"
 title='Prenos zostatkov saldokonta v cudzej mene' >


<?php                     } ?>

<?php if( $copern == 9 ) { ?>
MZC<img src='../obr/zoznam.png' width=20 height=20 border=0
onClick="PrenesMzdyCis();"
 title='Prenos ËÌselnÌkov Mzdy ( druhy mzdov˝ch zloûiek, pomerov, ZP, DSS, DDP, ˙Ëtovanie miezd... ) - preËÌtajte si prosÌm pred prenosom HELP' >
<?php                     } ?>

</td>


<td class="hmenu" width="10%"></td>
<td class="hmenu" width="10%"></td>

<td class="hmenu" width="10%">
»ÕS<img src='../obr/zoznam.png' width=20 height=20 border=0
onClick="PrenesCis();"
 title='Prenos obecn˝ch ËÌselnÌkov I»O,STR,ZAK,STV,SKU - mÙûete opakovaù viackr·t' >
</td>

<td class="hmenu" width="10%">
FIR<img src='../obr/orig.png' width=20 height=20 border=0
onClick="PrenesFir();"
 title='Prenos ˙dajov o firme - mÙûete opakovaù viackr·t' >
</td>

</tr>


</FORM>
</table>

<div id="mySaldoelement"></div>
<div id="Okno"></div>
<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som firmu podæa zadan˝ch podmienok, sk˙ste znovu</span>

<?php
}
//koniec vyberu firmy
?>

<?php
//prenos obecnych ciselnikov
if( $prenesciselniky == 1 )
{

echo "Prenos ËÌselnÌkov.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos StredÌsk.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_str WHERE str >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_str SELECT str,nst,dst,ust,datm FROM ".$databaza."F$h_ycf"."_str WHERE ".$databaza."F$h_ycf"."_str.str >= 0";
$dsql = mysql_query("$dsqlt");

/////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos I»0.<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_icoprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_icopovodne";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_icopovodne SELECT * FROM F".$kli_vxcf."_ico WHERE ico >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_icopovodne ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_icoprenos SELECT * FROM ".$databaza."F".$h_ycf."_ico WHERE ico >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_icoprenos ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_icoprenos,F$kli_vxcf"."_ico SET plati=9 WHERE F$kli_vxcf"."_icoprenos.ico = F$kli_vxcf"."_ico.ico ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_ico WHERE ico >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_ico SELECT ".
"ico,dic,icd,nai,na2,uli,psc,mes,tel,fax,em1,em2,em3,www,uc1,nm1,ib1,uc2,nm2,ib2,uc3,nm3,ib3,dns,datm  FROM F$kli_vxcf"."_icoprenos WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_ico SELECT ".
"ico,dic,icd,nai,na2,uli,psc,mes,tel,fax,em1,em2,em3,www,uc1,nm1,ib1,uc2,nm2,ib2,uc3,nm3,ib3,dns,datm  FROM F$kli_vxcf"."_icopovodne ".
" WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_icoprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_icopovodne";
$vysledok = mysql_query("$sqlt");

$sqlt = "DELETE FROM F".$kli_vxcf."_icorozsirenie";
$vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_icorozsirenie SELECT * FROM ".$databaza."F".$h_ycf."_icorozsirenie WHERE ico > 0 ";
$dsql = mysql_query("$dsqlt");

$sqlt = "DELETE FROM F".$kli_vxcf."_icoodbm";
$vysledok = mysql_query("$sqlt");


$sql = "SELECT icd2 FROM F$kli_vxcf"."_icoodbm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_icoodbm ADD icd2 varchar(20) not null AFTER poz2 ";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT icd2 FROM ".$databaza."F".$h_ycf."_icoodbm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE ".$databaza."F".$h_ycf."_icoodbm ADD icd2 varchar(20) not null AFTER poz2 ";
$vysledek = mysql_query("$sql");
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_icoodbm SELECT * FROM ".$databaza."F".$h_ycf."_icoodbm WHERE ico > 0 ";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos zak.<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_zakprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_zakpovodne";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_zakpovodne SELECT * FROM F".$kli_vxcf."_zak WHERE zak >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_zakpovodne ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_zakprenos SELECT * FROM ".$databaza."F".$h_ycf."_zak WHERE zak >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_zakprenos ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_zakprenos,F$kli_vxcf"."_zak SET plati=9".
" WHERE F$kli_vxcf"."_zakprenos.zak = F$kli_vxcf"."_zak.zak AND F$kli_vxcf"."_zakprenos.str = F$kli_vxcf"."_zak.str ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_zak WHERE zak >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zak SELECT ".
"str,zak,nza,sku,stv,dzk,uzk,datm FROM F$kli_vxcf"."_zakprenos WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_zak SELECT ".
"str,zak,nza,sku,stv,dzk,uzk,datm FROM F$kli_vxcf"."_zakpovodne ".
" WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_zakprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_zakpovodne";
$vysledok = mysql_query("$sqlt");

////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Stavieb.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_stv WHERE stv >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_stv SELECT * FROM ".$databaza."F$h_ycf"."_stv WHERE ".$databaza."F$h_ycf"."_stv.stv >= 0";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos SkupÌn.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_sku WHERE sku >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sku SELECT * FROM ".$databaza."F$h_ycf"."_sku WHERE ".$databaza."F$h_ycf"."_sku.sku >= 0";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Strojov.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyroperacie";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyroperacie SELECT * FROM ".$databaza."F$h_ycf"."_vyroperacie ";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_vyroperacie MODIFY cop int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

echo "»ÌselnÌky prenesenÈ.<br />";
}
//koniec prenos obecnych ciselnikov
?>

<?php
//prenos udajov o firme
if( $prenesufir == 1 )
{

echo "Prenos Udaje o firme.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_ufir";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_ufir SELECT * FROM ".$databaza."F$h_ycf"."_ufir";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_ufirdalsie";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_uctnewdupobocka";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_ufirdalsie SELECT * FROM ".$databaza."F$h_ycf"."_ufirdalsie";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if( $kli_vrok >= 2011 )
{

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET allx11='$h_ycf' "; $ttqq = mysql_query("$ttvv");
$ttvv = "UPDATE F$kli_vxcf"."_ufir SET allx12=$kli_vrok-1 "; $ttqq = mysql_query("$ttvv");

//razitka,logo,hlavicka
if (File_Exists ("../dokumenty/FIR$h_ycf/hlavicka.jpg")) 
{ 
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavicka.jpg")) 
 {
$soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavicka.jpg"); 
 }
copy("../dokumenty/FIR$h_ycf/hlavicka.jpg", "../dokumenty/FIR$kli_vxcf/hlavicka.jpg");
}

if (File_Exists ("../dokumenty/FIR$h_ycf/hlavicka.bmp")) 
{ 
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavicka.bmp")) 
 {
$soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavicka.bmp"); 
 }
copy("../dokumenty/FIR$h_ycf/hlavicka.bmp", "../dokumenty/FIR$kli_vxcf/hlavicka.bmp");
}

if (File_Exists ("../dokumenty/FIR$h_ycf/logo.jpg")) 
{ 
if (File_Exists ("../dokumenty/FIR$kli_vxcf/logo.jpg")) 
 {
$soubor = unlink("../dokumenty/FIR$kli_vxcf/logo.jpg"); 
 }
copy("../dokumenty/FIR$h_ycf/logo.jpg", "../dokumenty/FIR$kli_vxcf/logo.jpg");
}

if (File_Exists ("../dokumenty/FIR$h_ycf/razitko$kli_uzid.jpg")) 
{ 
if (File_Exists ("../dokumenty/FIR$kli_vxcf/razitko$kli_uzid.jpg")) 
 {
$soubor = unlink("../dokumenty/FIR$kli_vxcf/razitko$kli_uzid.jpg"); 
 }
copy("../dokumenty/FIR$h_ycf/razitko$kli_uzid.jpg", "../dokumenty/FIR$kli_vxcf/razitko$kli_uzid.jpg");
}

//vypni prepocet na Sk
if( $kli_vrok >= 2012 )
  {
$soubor = fopen("../dokumenty/FIR$kli_vxcf/ajprepocetnask.nie", "a+");
  $text = "<?php ?>";
  fwrite($soubor, $text);
fclose($soubor);
  }

echo "⁄daje o firme prenesenÈ.<br />";
}
//koniec prenos udajov o firme
?>

<?php
//prenos ciselnikov uctovnictva
if( $prenesucis == 1 )
{

echo "Prenos ËÌselnÌkov ˙ËtovnÌctva.<br />";

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Druhov odberateæsk˝ch dokladov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_dodb WHERE dodb >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dodb SELECT * FROM ".$databaza."F$h_ycf"."_dodb WHERE ".$databaza."F$h_ycf"."_dodb.dodb >= 0";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Druhov dod·vateæsk˝ch dokladov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_ddod WHERE ddod >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_ddod SELECT * FROM ".$databaza."F$h_ycf"."_ddod WHERE ".$databaza."F$h_ycf"."_ddod.ddod >= 0";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos druhov PokladnÌc.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_dpok WHERE dpok >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dpok SELECT * FROM ".$databaza."F$h_ycf"."_dpok WHERE ".$databaza."F$h_ycf"."_dpok.dpok >= 0";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Druhov Bankov˝ch ˙Ëtov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_dban WHERE dban >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dban SELECT * FROM ".$databaza."F$h_ycf"."_dban WHERE ".$databaza."F$h_ycf"."_dban.dban >= 0";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Druhov dokladov DPH.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctdrdp ";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY crd3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY nrd VARCHAR(70) NOT NULL ";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdrdp SELECT * FROM ".$databaza."F$h_ycf"."_uctdrdp ";
$dsql = mysql_query("$dsqlt");

$sql = "DROP TABLE F$kli_vxcf"."_uctdphnew";
$vysledek = mysql_query("$sql");

if( $kli_vrok == 2011 )
{
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctdph11new_d";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctrobot11new_d";
$vysledek = mysql_query("$sql");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

if( $kli_vrok == 2014 )
{
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha2new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha3new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha4new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha8new ";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2015 )
{
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha2new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha3new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha4new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha8new ";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2016 )
{
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha2new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha3new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha4new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha8new ";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2017 )
{
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha2new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha3new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha4new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha8new ";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2018 )
{
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha2new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha3new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha4new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha8new ";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2019 )
{
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha2new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha3new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha4new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_uctvykdpha8new ";
$vysledek = mysql_query("$sql");
}

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Dealerov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_dealeri ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dealeri SELECT * FROM ".$databaza."F$h_ycf"."_dealeri ";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos CudzÌch mien, ˙Ëtov v cudzÌch men·ch a kurzovÈho lÌstka.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctkurzy ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctkurzy SELECT * FROM ".$databaza."F$h_ycf"."_uctkurzy ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctmeny ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctmeny SELECT * FROM ".$databaza."F$h_ycf"."_uctmeny ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctcudz ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctcudz SELECT * FROM ".$databaza."F$h_ycf"."_uctcudz ";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos AutomatickÈho ˙Ëtovania.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_uctpohyby ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_uctpohyby SELECT * FROM ".$databaza."F$h_ycf"."_uctpohyby ";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok > 2011 )
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctpohyby MODIFY cpoh int(11) PRIMARY KEY  ";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F$kli_vxcf"."_uctpohybyxxx SELECT * FROM F$kli_vxcf"."_uctpohyby ";
$vysledek = mysql_query("$sql");
$sql = "TRUNCATE F$kli_vxcf"."_uctpohyby ";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F$kli_vxcf"."_uctpohyby SELECT * FROM F$kli_vxcf"."_uctpohybyxxx GROUP BY cpoh ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_uctpohybyxxx ";
$vysledek = mysql_query("$sql");
}

$dsqlt = "DROP TABLE F$kli_vxcf"."_uctvzordok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_uctvzordok SELECT * FROM ".$databaza."F$h_ycf"."_uctvzordok ";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Nastaven˝ch textov.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_uctupvtext ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_uctupvtext SELECT * FROM ".$databaza."F$h_ycf"."_uctupvtext ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_faktext ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_faktext SELECT * FROM ".$databaza."F$h_ycf"."_faktext ";
$dsql = mysql_query("$dsqlt");



echo "»ÌselnÌky ˙ËtovnÌctva prenesenÈ.<br />";
}
//koniec prenos ciselnikov uctovnictva
?>

<?php
//prenos prenos zostatok saldo v cudzej mene
if( $prenescudz == 1 )
{

echo "Prenos zostatku saldokonta v cudzej mene.<br />";

//rozsir uctuhradpoc o zmen,mena,kurz,hodm
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD kurz DECIMAL(14,6) DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD mena VARCHAR(5) NOT NULL AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD zmen INT(1) DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F".$kli_vxcf."_uctuhradpoc$kli_uzid ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctuhradpoc$kli_uzid SELECT * FROM F".$kli_vxcf."_uctuhradpoc WHERE dok = 0";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_uctuhradpoc$kli_uzid";
$vysledok = mysql_query("$sqlt");

$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 )";
if( $agrostav == 1 OR $autovalas == 1 OR $delisasro == 1 OR $metalco == 1 OR $polno == 1 OR $lsucto == 1 )
{
$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 OR LEFT(ucm,2) = 37 OR LEFT(ucm,3) = 335 OR LEFT(ucm,3) = 391 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 OR LEFT(ucd,2) = 37 OR LEFT(ucd,3) = 335 OR LEFT(ucd,3) = 391 )";
}
if( $_SERVER['SERVER_NAME'] == "www.eurosekov.sk" ) 
{ 
$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 OR LEFT(ucm,2) = 37 OR LEFT(ucm,3) = 335 OR LEFT(ucm,3) = 391 OR LEFT(ucm,3) = 374 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 OR LEFT(ucd,2) = 37 OR LEFT(ucd,3) = 335 OR LEFT(ucd,3) = 391 OR LEFT(ucd,3) = 374 )";
}

//pokl.prijem
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,".
"".$databaza."F$h_ycf"."_uctpokuct.zmen,".$databaza."F$h_ycf"."_uctpokuct.mena,".$databaza."F$h_ycf"."_uctpokuct.kurz,".$databaza."F$h_ycf"."_uctpokuct.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokpri".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokpri.dok AND $podmucm";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,".
"".$databaza."F$h_ycf"."_uctpokuct.zmen,".$databaza."F$h_ycf"."_uctpokuct.mena,".$databaza."F$h_ycf"."_uctpokuct.kurz,".$databaza."F$h_ycf"."_uctpokuct.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokpri".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokpri.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");

//pokl.vydaj
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,".
"".$databaza."F$h_ycf"."_uctpokuct.zmen,".$databaza."F$h_ycf"."_uctpokuct.mena,".$databaza."F$h_ycf"."_uctpokuct.kurz,".$databaza."F$h_ycf"."_uctpokuct.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokvyd".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokvyd.dok AND $podmucm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,".
"".$databaza."F$h_ycf"."_uctpokuct.zmen,".$databaza."F$h_ycf"."_uctpokuct.mena,".$databaza."F$h_ycf"."_uctpokuct.kurz,".$databaza."F$h_ycf"."_uctpokuct.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokvyd".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokvyd.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");

$datumx="dat";
if( $fir_allx15 == 1 ) { $datumx="ddu"; }

//banka
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,$datumx,".$databaza."F$h_ycf"."_uctban.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctban.hod,".$databaza."F$h_ycf"."_uctban.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctban.pop),0,0,'',".$databaza."F$h_ycf"."_uctban.id,".$databaza."F$h_ycf"."_uctban.datm,".
"".$databaza."F$h_ycf"."_uctban.zmen,".$databaza."F$h_ycf"."_uctban.mena,".$databaza."F$h_ycf"."_uctban.kurz,".$databaza."F$h_ycf"."_uctban.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctban,".$databaza."F$h_ycf"."_banvyp".
" WHERE ".$databaza."F$h_ycf"."_uctban.dok=".$databaza."F$h_ycf"."_banvyp.dok AND $podmucm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,$datumx,".$databaza."F$h_ycf"."_uctban.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctban.hod,".$databaza."F$h_ycf"."_uctban.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctban.pop),0,0,'',".$databaza."F$h_ycf"."_uctban.id,".$databaza."F$h_ycf"."_uctban.datm,".
"".$databaza."F$h_ycf"."_uctban.zmen,".$databaza."F$h_ycf"."_uctban.mena,".$databaza."F$h_ycf"."_uctban.kurz,".$databaza."F$h_ycf"."_uctban.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctban,".$databaza."F$h_ycf"."_banvyp".
" WHERE ".$databaza."F$h_ycf"."_uctban.dok=".$databaza."F$h_ycf"."_banvyp.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");


//vseobecne
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctvsdp.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctvsdp.hod,".$databaza."F$h_ycf"."_uctvsdp.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctvsdp.pop),0,0,'',".$databaza."F$h_ycf"."_uctvsdp.id,".$databaza."F$h_ycf"."_uctvsdp.datm,".
"".$databaza."F$h_ycf"."_uctvsdp.zmen,".$databaza."F$h_ycf"."_uctvsdp.mena,".$databaza."F$h_ycf"."_uctvsdp.kurz,".$databaza."F$h_ycf"."_uctvsdp.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctvsdp,".$databaza."F$h_ycf"."_uctvsdh".
" WHERE ".$databaza."F$h_ycf"."_uctvsdp.dok=".$databaza."F$h_ycf"."_uctvsdh.dok AND $podmucm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc$kli_uzid".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctvsdp.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctvsdp.hod,".$databaza."F$h_ycf"."_uctvsdp.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctvsdp.pop),0,0,'',".$databaza."F$h_ycf"."_uctvsdp.id,".$databaza."F$h_ycf"."_uctvsdp.datm,".
"".$databaza."F$h_ycf"."_uctvsdp.zmen,".$databaza."F$h_ycf"."_uctvsdp.mena,".$databaza."F$h_ycf"."_uctvsdp.kurz,".$databaza."F$h_ycf"."_uctvsdp.hodm ".
" FROM ".$databaza."F$h_ycf"."_uctvsdp,".$databaza."F$h_ycf"."_uctvsdh".
" WHERE ".$databaza."F$h_ycf"."_uctvsdp.dok=".$databaza."F$h_ycf"."_uctvsdh.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_uctuhradpoc$kli_uzid WHERE zmen = 0";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_uctuhradpoc,F".$kli_vxcf."_uctuhradpoc$kli_uzid ".
" SET F$kli_vxcf"."_uctuhradpoc.zmen=F$kli_vxcf"."_uctuhradpoc$kli_uzid.zmen, ".
" F$kli_vxcf"."_uctuhradpoc.mena=F$kli_vxcf"."_uctuhradpoc$kli_uzid.mena, ".
" F$kli_vxcf"."_uctuhradpoc.kurz=F$kli_vxcf"."_uctuhradpoc$kli_uzid.kurz, ".
" F$kli_vxcf"."_uctuhradpoc.hodm=F$kli_vxcf"."_uctuhradpoc$kli_uzid.hodm  ".
" WHERE F$kli_vxcf"."_uctuhradpoc.dok=F$kli_vxcf"."_uctuhradpoc$kli_uzid.dok ".
" AND F$kli_vxcf"."_uctuhradpoc.hod=F$kli_vxcf"."_uctuhradpoc$kli_uzid.hod ".
" AND F$kli_vxcf"."_uctuhradpoc.ico=F$kli_vxcf"."_uctuhradpoc$kli_uzid.ico ".
" AND F$kli_vxcf"."_uctuhradpoc.fak=F$kli_vxcf"."_uctuhradpoc$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");


$sql = "DROP TABLE F".$kli_vxcf."_uctuhradpoc$kli_uzid ";
$vysledek = mysql_query("$sql");


$sql = "DROP TABLE F".$kli_vxcf."_uctcudz$kli_uzid ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctcudz$kli_uzid SELECT * FROM F".$kli_vxcf."_uctcudz WHERE cuce > 0";
$vysledek = mysql_query("$sql");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctcudz ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctcudz SELECT * FROM ".$databaza."F$h_ycf"."_uctcudz ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctcudz,F".$kli_vxcf."_uctcudz$kli_uzid ".
" SET F$kli_vxcf"."_uctcudz.pscu=F$kli_vxcf"."_uctcudz$kli_uzid.pscu, ".
" F$kli_vxcf"."_uctcudz.pssk=F$kli_vxcf"."_uctcudz$kli_uzid.pssk  ".
" WHERE F$kli_vxcf"."_uctcudz.cuce=F$kli_vxcf"."_uctcudz$kli_uzid.cuce ";
$dsql = mysql_query("$dsqlt");

echo "Zostatok saldokonta v cudzej mene prenesen˝.<br />";
}
//koniec prenos zostatok saldo v cudzej mene
?>


<?php
//prenos SKLAD
if( $copernxy == 101 )
{

echo "Prenos SKLADU.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Skladov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_skl WHERE skl >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_skl SELECT skl,nas,drs,ucs,datm FROM ".$databaza."F$h_ycf"."_skl WHERE ".$databaza."F$h_ycf"."_skl.skl >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos Druhov pohybov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklcph WHERE poh >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklcph SELECT poh,nph,drp,ucm,ucd,pph,datm FROM ".$databaza."F$h_ycf"."_sklcph WHERE ".$databaza."F$h_ycf"."_sklcph.poh >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos DoplÚuj˙ce ˙daje CIS.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_sklcisudaje ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_sklcisudaje SELECT * FROM ".$databaza."F$h_ycf"."_sklcisudaje WHERE ".$databaza."F$h_ycf"."_sklcisudaje.xcis >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos skluzid.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_skluzid ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_skluzid SELECT * FROM ".$databaza."F$h_ycf"."_skluzid ";
$dsql = mysql_query("$dsqlt");

echo "Prenos sklxskl.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_sklxskl ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_sklxskl SELECT * FROM ".$databaza."F$h_ycf"."_sklxskl ";
$dsql = mysql_query("$dsqlt");
  
////////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Ciselnika materialov.<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_sklcisprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_sklcispovodne";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_sklcispovodne SELECT * FROM F".$kli_vxcf."_sklcis WHERE cis >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_sklcispovodne ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_sklcisprenos SELECT * FROM ".$databaza."F".$h_ycf."_sklcis WHERE cis >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_sklcisprenos ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_sklcisprenos,F$kli_vxcf"."_sklcis SET plati=9".
" WHERE F$kli_vxcf"."_sklcisprenos.cis = F$kli_vxcf"."_sklcis.cis ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklcis WHERE cis >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklcis SELECT ".
"cis,nat,natBD,mer,dph,cep,ced,tl1,tl2,tl3,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2,datm FROM F$kli_vxcf"."_sklcisprenos WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklcis SELECT ".
"cis,nat,natBD,mer,dph,cep,ced,tl1,tl2,tl3,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2,datm FROM F$kli_vxcf"."_sklcispovodne ".
" WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_sklcisprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_sklcispovodne";
$vysledok = mysql_query("$sqlt");

if( $kli_vrok >= 2011 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_sklcis SET dph=20, ced=cep*1.20 WHERE dph = 19";
$dsql = mysql_query("$dsqlt");

}

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos z·sob.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklzas WHERE skl >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklzas SELECT skl,cis,cen,zas,datm FROM ".$databaza."F$h_ycf"."_sklzas WHERE ".$databaza."F$h_ycf"."_sklzas.skl >= 0";
$dsql = mysql_query("$dsqlt");


if( $kli_vrok == 2009 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_sklzas SET cen=cen/30.1260 WHERE skl >= 0";
$dsql = mysql_query("$dsqlt");

}

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklpoc WHERE skl >= 0";
$dsql = mysql_query("$dsqlt");

$prvdrok=$kli_vrok-1;
$prvdume="12.".$prvdrok;
$prvddat=$prvdrok."-12-31";

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklpoc SELECT ".
" 0,'$prvdume','$prvddat',1,1,skl,1,0,0,'',0,0,cis,zas,cen,$kli_uzid,0,datm,0,0 ".
" FROM F$kli_vxcf"."_sklzas WHERE zas != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sklpoc cpl  ume  dat  dok  doq  skl  poh  ico  fak  poz  str  zak  cis  mno  cen  id  sk2  datm  

//priemerne ceny 
if( $fir_xsk04 == 1 ) 
{ 
echo "PriemernÈ ceny.<br />";

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
$vyslpr = mysql_query("$sqlpr"); 

$sql = "SELECT * FROM F$kli_vxcf"."_sklzaspriemer";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
//echo "robim sklzaspriemer";

$sqlt = <<<sklzas
(
   prx         INT,
   skl         INT,
   cis         DECIMAL(15,0),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   hop         DECIMAL(10,2)
);
sklzas;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_sklzaspriemer'.$sqlt;
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklzaspriemer ".
" SELECT 0,skl,cis,cen,zas,(cen*zas) ".
" FROM F$kli_vxcf"."_sklzas ".
" WHERE cis >= 0 ORDER BY skl,cis,cen";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklzaspriemer ".
" SELECT 1,skl,cis,cen,SUM(zas),SUM(hop) ".
" FROM F$kli_vxcf"."_sklzaspriemer ".
" WHERE cis >= 0 GROUP by skl,cis";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklzaspriemer WHERE prx = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklzaspriemer SET cen=hop/zas WHERE zas != 0 AND hop != 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklzas WHERE cis >= 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklzas ".
" SELECT skl,cis,cen,zas,now() ".
" FROM F$kli_vxcf"."_sklzaspriemer ".
" WHERE cis >= 0 ORDER BY skl,cis,cen";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklpoc WHERE cis >= 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sklpoc SELECT ".
" 0,'$prvdume','$prvddat',1,1,skl,1,0,0,'',0,0,cis,zas,cen,$kli_uzid,0,datm,0,0 ".
" FROM F$kli_vxcf"."_sklzas WHERE zas != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

     }
}
//koniec priemerne ceny

//prenos 2.mernych jednotiek 
if( $polno == 1 )
{
echo "2.MernÈ jednotky.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_sklprc2 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_sklprc2 SELECT * FROM ".$databaza."F$h_ycf"."_sklprc2 WHERE pox1 = 8 AND mn2 != 0 AND poh = 999999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklpoc,F".$kli_vxcf."_sklprc2 ".
" SET F$kli_vxcf"."_sklpoc.mn2=F$kli_vxcf"."_sklprc2.mn2 ".
" WHERE F$kli_vxcf"."_sklpoc.cis=F$kli_vxcf"."_sklprc2.cis ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_sklprc2 ";
$dsql = mysql_query("$dsqlt");

}
//koniec prenos 2.mernych jednotiek 


$dsqlt = "DROP TABLE F$kli_vxcf"."_ezak ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_ezak SELECT * FROM ".$databaza."F$h_ycf"."_ezak ";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_ezak MODIFY ez_id int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ezak MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$dsqlt = "DROP TABLE F$kli_vxcf"."_webslu ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_webslu SELECT * FROM ".$databaza."F$h_ycf"."_webslu ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_webslu SET fir=$kli_vxcf ";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos ËÌselnÌka sluûieb .<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_sluzbyprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_sluzbypovodne";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_sluzbypovodne SELECT * FROM F".$kli_vxcf."_sluzby WHERE slu >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_sluzbypovodne ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_sluzbyprenos SELECT * FROM ".$databaza."F".$h_ycf."_sluzby WHERE slu >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_sluzbyprenos ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_sluzbyprenos,F$kli_vxcf"."_sluzby SET plati=9".
" WHERE F$kli_vxcf"."_sluzbyprenos.slu = F$kli_vxcf"."_sluzby.slu ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sluzby WHERE slu >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sluzby SELECT ".
" slu,nsl,nslp,nslz,mer,dph,cep,ced,tl1,tl2,tl3,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2,datm ".
" FROM F$kli_vxcf"."_sluzbyprenos WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_sluzby SELECT ".
" slu,nsl,nslp,nslz,mer,dph,cep,ced,tl1,tl2,tl3,labh1,labh2,kat01h,kat02h,kat03h,kat04h,webtx1,webtx2,datm ".
"  FROM F$kli_vxcf"."_sluzbypovodne WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_sluzbyprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_sluzbypovodne";
$vysledok = mysql_query("$sqlt");

if( $kli_vrok >= 2011 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_sluzby SET dph=20, ced=cep*1.20 WHERE dph = 19";
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

$pocp=0;
$poslhh = "SELECT * FROM F".$h_ycf."_restktgtov ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $pocp = mysql_num_rows($posl); }

if( $pocp > 3 )
  {
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos KategÛriÌ tovaru .<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_restktgtov";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_restktgtov SELECT * FROM F".$h_ycf."_restktgtov ";
$vysledek = mysql_query("$sql");

$uprtt = "UPDATE F$kli_vxcf"."_sklcis,F$h_ycf"."_sklcis SET ".
" F$kli_vxcf"."_sklcis.webtx1=F$h_ycf"."_sklcis.webtx1, ".
" F$kli_vxcf"."_sklcis.webtx2=F$h_ycf"."_sklcis.webtx2, ".
" F$kli_vxcf"."_sklcis.kat01h=F$h_ycf"."_sklcis.kat01h, ".
" F$kli_vxcf"."_sklcis.kat02h=F$h_ycf"."_sklcis.kat02h, ".
" F$kli_vxcf"."_sklcis.kat03h=F$h_ycf"."_sklcis.kat03h, ".
" F$kli_vxcf"."_sklcis.kat04h=F$h_ycf"."_sklcis.kat04h, ".
" F$kli_vxcf"."_sklcis.labh1=F$h_ycf"."_sklcis.labh1, ".
" F$kli_vxcf"."_sklcis.labh2=F$h_ycf"."_sklcis.labh2  ".
" WHERE F$kli_vxcf"."_sklcis.cis=F$h_ycf"."_sklcis.cis ";  

$upravene = mysql_query("$uprtt");

  }
////////////////////////////////////////////////////////////////////////////////////////////////

$pocp=0;
$poslhh = "SELECT * FROM ".$databaza."F".$h_ycf."_kuchrecepth ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $pocp = mysql_num_rows($posl); }
if( $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" ) { $pocp=0; }
if( $_SERVER['SERVER_NAME'] == "www.eurosecom.sk" ) { $pocp=0; }
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $pocp=0; }

if( $pocp > 10 )
  {
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Kuchyne .<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_uhot ";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_uhot SELECT * FROM ".$databaza."F".$h_ycf."_uhot ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_kuchsuroviny ";
$vysledok = mysql_query("$sqlt");
//echo $sql;

$sql = "INSERT INTO F".$kli_vxcf."_kuchsuroviny SELECT * FROM ".$databaza."F".$h_ycf."_kuchsuroviny ";
$vysledek = mysql_query("$sql");
//echo $sql;

$sql = "ALTER TABLE F".$kli_vxcf."_kuchsuroviny MODIFY ckmp int(11) PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_kuchsuroviny MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_kuchrecepth ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_kuchrecepth SELECT * FROM ".$databaza."F".$h_ycf."_kuchrecepth ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_kuchreceptp ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_kuchreceptp SELECT * FROM ".$databaza."F".$h_ycf."_kuchreceptp ";
$vysledek = mysql_query("$sql");


////////////////////////////////////////////////////////////////////////////////////////////////////
  }


$pocp=0;
$poslhh = "SELECT * FROM ".$databaza."F".$h_ycf."_ubythostia ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $pocp = mysql_num_rows($posl); }

if( $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" ) { $pocp=0; }
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $pocp=0; }
if( $pocp > 10 )
  {
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Ubytovania .<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_uhot ";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_uhot SELECT * FROM ".$databaza."F".$h_ycf."_uhot ";
$vysledek = mysql_query("$sql");


$sqlt = "TRUNCATE F".$kli_vxcf."_ubythostia ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubythostia SELECT * FROM ".$databaza."F".$h_ycf."_ubythostia ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_ubytdalsihostia ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubytdalsihostia SELECT * FROM ".$databaza."F".$h_ycf."_ubytdalsihostia ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_ubytcis ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubytcis SELECT * FROM ".$databaza."F".$h_ycf."_ubytcis ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_ubytcisudaje ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubytcisudaje SELECT * FROM ".$databaza."F".$h_ycf."_ubytcisudaje ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_ubytizby ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubytizby SELECT * FROM ".$databaza."F".$h_ycf."_ubytizby ";
$vysledek = mysql_query("$sql");

$ddir="../dokumenty/FIR".$kli_vxcf."/obr_izby";
if (!File_Exists ("$ddir")) { mkdir ($ddir, 0777); }

$i=1;
while( $i < 1000 )
     {
if (File_Exists ("../dokumenty/FIR$h_ycf/obr_izby/izba$i.jpg")) 
 {
copy("../dokumenty/FIR$h_ycf/obr_izby/izba$i.jpg", "../dokumenty/FIR$kli_vxcf/obr_izby/izba$i.jpg");
 }
$subx2="../dokumenty/FIR$h_ycf/obr_izby/izba$i"."x2.jpg";
$subx2do="../dokumenty/FIR$kli_vxcf/obr_izby/izba$i"."x2.jpg";
if (File_Exists ("$subx2")) { copy("$subx2", "$subx2do"); }

$subx2="../dokumenty/FIR$h_ycf/obr_izby/izba$i".".pdf";
$subx2do="../dokumenty/FIR$kli_vxcf/obr_izby/izba$i".".pdf";
if (File_Exists ("$subx2")) { copy("$subx2", "$subx2do"); }

$subx2="../dokumenty/FIR$h_ycf/obr_izby/izba$i"."x2.pdf";
$subx2do="../dokumenty/FIR$kli_vxcf/obr_izby/izba$i"."x2.pdf";
if (File_Exists ("$subx2")) { copy("$subx2", "$subx2do"); }

$i=$i+1;
     }

$sqlt = "TRUNCATE F".$kli_vxcf."_ubytizbapolozky ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubytizbapolozky SELECT * FROM ".$databaza."F".$h_ycf."_ubytizbapolozky ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_ubytktgtov ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubytktgtov SELECT * FROM ".$databaza."F".$h_ycf."_ubytktgtov ";
$vysledek = mysql_query("$sql");

$sqlt = "DROP TABLE F".$kli_vxcf."_ubytdruhubyt ";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_ubytdruhubyt SELECT * FROM ".$databaza."F".$h_ycf."_ubytdruhubyt ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_ubytzamestnanci ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_ubytzamestnanci SELECT * FROM ".$databaza."F".$h_ycf."_ubytzamestnanci ";
$vysledek = mysql_query("$sql");


//koniec ubytovanie/////////////////////////////////////////////////////////////////////////////
  }

$pocp=0;
$poslhh = "SELECT * FROM F".$h_ycf."_restpredp ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $pocp = mysql_num_rows($posl); }
if( $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" ) { $pocp=0; }
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $pocp=0; }

if( $pocp > 100 )
  {
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Reötaur·cie .<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_uhot ";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_uhot SELECT * FROM F".$h_ycf."_uhot ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_restponukatovset ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_restponukatovset SELECT * FROM F".$h_ycf."_restponukatovset ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_reststoly ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_reststoly SELECT * FROM F".$h_ycf."_reststoly ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_restcasnici ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_restcasnici SELECT * FROM F".$h_ycf."_restcasnici ";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_restktgtov ";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_restktgtov SELECT * FROM F".$h_ycf."_restktgtov ";
$vysledek = mysql_query("$sql");

$sqlt = "DROP TABLE F".$kli_vxcf."_dopdkpset ";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_dopdkpset SELECT * FROM F".$h_ycf."_dopdkpset ";
$vysledek = mysql_query("$sql");

$sqlt = "DROP TABLE F".$kli_vxcf."_dopdkp ";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_dopdkp SELECT * FROM F".$h_ycf."_dopdkp ";
$vysledek = mysql_query("$sql");


//koniec restauracia////////////////////////////////////////////////////////////////////////////////
  }

////////////////////////////////////////////////////////////////////////////////////////////////////

echo "SKLAD prenesen˝.<br />";
}
//koniec prenos SKLAD
?>

<?php
//prenos MAJETOK
if( $copernxy == 102 )
{

echo "Prenos MAJETKU.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos druhov majetku a druhov pohybov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_majdrm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majdrm SELECT * FROM ".$databaza."F$h_ycf"."_majdrm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_majdimdrm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majdimdrm SELECT * FROM ".$databaza."F$h_ycf"."_majdimdrm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_majdrunak";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majdrunak SELECT * FROM ".$databaza."F$h_ycf"."_majdrunak";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_majdruvyr";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majdruvyr SELECT * FROM ".$databaza."F$h_ycf"."_majdruvyr";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_majsodp";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_majsodp SELECT * FROM ".$databaza."F$h_ycf"."_majsodp";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok >= 2016 )
  {

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   prx6        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;

$sql = "CREATE TABLE F".$kli_vxcf."_majodpskup2015new ".$sqlt;
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_majodpskup2015new1 ".$sqlt;
$vysledek = mysql_query("$sql");

  }

if( $kli_vrok == 2015 )
  {
$sql = "DROP TABLE F".$kli_vxcf."_majodpskup2015new ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F".$kli_vxcf."_majodpskup2015new1 ";
$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD zzvys7_dan DECIMAL(10,2) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD zkoep7_dan DECIMAL(10,2) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD zkoed7_dan DECIMAL(10,2) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD rdoba7_dan DECIMAL(10,0) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");
  }

$dsqlt = "DELETE FROM F$kli_vxcf"."_kancelarie";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kancelarie SELECT * FROM ".$databaza."F$h_ycf"."_kancelarie";
$dsql = mysql_query("$dsqlt");

/////////////////////////////////////////////////////////////////////////////////////////////////

  
////////////////////////////////////////////////////////////////////////////////////////////////////

echo "Prenos majetku.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_majmaj WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majmaj SELECT * FROM ".$databaza."F$h_ycf"."_majmaj WHERE ".$databaza."F$h_ycf"."_majmaj.inv >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majmaj SET ".
" zss=zos, mes=0, ros=0,  ".
" ops_dan=ops_dan+hd5, zos_dan=cen_dan-ops_dan, zss_dan=zos_dan, mes_dan=0, ros_dan=0, hd5=0 ".
" WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok == 2009 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_majmaj SET ".
" cen=cen/30.1260, ops=ops/30.1260, zos=zos/30.1260, zss=zss/30.1260, meso=meso/30.1260, ".
" cen_dan=cen_dan/30.1260, ops_dan=ops_dan/30.1260, zos_dan=zos_dan/30.1260, zss_dan=zss_dan/30.1260, roco_dan=roco_dan/30.1260 ".
" WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

}

$sqlt = "DROP TABLE F".$kli_vxcf."_majtextmaj";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_majtextmaj SELECT * FROM ".$databaza."F$h_ycf"."_majtextmaj WHERE invt >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj MODIFY invt int PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

$dsqlt = "DELETE FROM F$kli_vxcf"."_majdim WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majdim SELECT * FROM ".$databaza."F$h_ycf"."_majdim WHERE ".$databaza."F$h_ycf"."_majdim.inv >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majdim SET ".
" zss=zos, mes=0, ros=0,  ".
" ops_dan=ops_dan+hd5, zos_dan=cen_dan-ops_dan, zss_dan=zos_dan, mes_dan=0, ros_dan=0, hd5=0 ".
" WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majdim SET poh=1 WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok == 2009 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_majdim SET ".
" cen=cen/30.1260, ops=ops/30.1260, zos=zos/30.1260, zss=zss/30.1260, meso=meso/30.1260, ".
" cen_dan=cen_dan/30.1260, ops_dan=ops_dan/30.1260, zos_dan=zos_dan/30.1260, zss_dan=zss_dan/30.1260, roco_dan=roco_dan/30.1260 ".
" WHERE inv >= 0";
$dsql = mysql_query("$dsqlt");

}


$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_1"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_2"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_3"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_4"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_5"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_6"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_7"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_8"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_9"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_10"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_11"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");
$rentt = "DROP TABLE F$kli_vxcf"."_majmaj_12"."_$kli_vrok ";
$dsqr = mysql_query("$rentt");

$rentt = "DELETE FROM F$kli_vxcf"."_majmajmes ";
$dsqr = mysql_query("$rentt");
$zmaztt = "DELETE FROM F$kli_vxcf"."_majodpisy ";
$zmazane = mysql_query("$zmaztt");

////////////////////////////////////////////////////////////////////////////////////////////////////

echo "MAJETOK prenesen˝.<br />";
}
//koniec prenos MAJETOK copern 102
?>


<?php
//prenos DOPRAVA
if( $copernxy == 103 )
{

echo "Prenos DOPRAVY.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos ËÌselnÌkov dopravy.<br />";

echo "Prenos druhov PHM.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_dopdpm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopdpm SELECT * FROM ".$databaza."F$h_ycf"."_dopdpm";
$dsql = mysql_query("$dsqlt");

echo "Prenos druhov Vozidiel.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_dopdvz";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopdvz SELECT * FROM ".$databaza."F$h_ycf"."_dopdvz";
$dsql = mysql_query("$dsqlt");

echo "Prenos druhov Platobn˝ch kariet.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_dopplk";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopplk SELECT * FROM ".$databaza."F$h_ycf"."_dopplk";
$dsql = mysql_query("$dsqlt");

echo "Prenos ËÌselnÌka sluûieb.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_dopsluzby";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopsluzby SELECT * FROM ".$databaza."F$h_ycf"."_dopsluzby";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok == 2009 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_dopvoz SET ".
" cep=cep/30.1260, ced=ced/30.1260 ";

$dsql = mysql_query("$dsqlt");

}


if( $kli_vrok >= 2011 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_dopsluzby SET dph=20, ced=cep*1.20 WHERE dph = 19";
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

/////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos Vozidiel .<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_dopvoz";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopvoz SELECT * FROM ".$databaza."F$h_ycf"."_dopvoz WHERE dvoz != 99 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_dopvoz,".$databaza."F$h_ycf"."_kjzstavtch$kli_uzid ".
" SET spmn4=tchmx  WHERE F$kli_vxcf"."_dopvoz.cvoz=".$databaza."F$h_ycf"."_kjzstavtch$kli_uzid.cvozx ";
$dsql = mysql_query("$dsqlt");


$sqlt = "DROP TABLE F".$kli_vxcf."_doptextdop";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_doptextdop SELECT * FROM ".$databaza."F$h_ycf"."_doptextdop ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_doptextdop MODIFY invt VARCHAR(30) PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

$sqlt = "DROP TABLE F".$kli_vxcf."_dopslcesty";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_dopslcesty SELECT * FROM ".$databaza."F$h_ycf"."_dopslcesty ";
$vysledek = mysql_query("$sql");


if( $kli_vrok == 2009 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_dopvoz SET ".
" cnbn=cnbn/30.1260, cnsn=cnsn/30.1260, cnbnv=cnbnv/30.1260, cnsnv=cnsnv/30.1260 ";

$dsql = mysql_query("$dsqlt");

}

if( $kli_vrok >= 2011 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_dopvoz SET sdph=20  WHERE sdph = 19";
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

/////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos VodiËov.<br />";

$dsqlt = "DELETE FROM F$kli_vxcf"."_dopvod";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopvod SELECT * FROM ".$databaza."F$h_ycf"."_dopvod";
$dsql = mysql_query("$dsqlt");


////////////////////////////////////////////////////////////////////////////////////////////////////

echo "DOPRAVA prenesen·.<br />";
}
//koniec prenos DOPRAVA copern 103
?>

<?php
//prenos uctovnictva pociatok obratovka 
if( $copernxy == 110 )
{

////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos ˙Ëtovej osnovy.<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_uctosnovaprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_uctosnovapovodne";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_uctosnovapovodne SELECT * FROM F".$kli_vxcf."_uctosnova WHERE ucc >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctosnovapovodne ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctosnovaprenos SELECT * FROM ".$databaza."F".$h_ycf."_uctosnova WHERE ucc >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctosnovaprenos ADD plati DECIMAL(3,0) DEFAULT 0 FIRST";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnovaprenos,F$kli_vxcf"."_uctosnova SET plati=9 WHERE F$kli_vxcf"."_uctosnovaprenos.uce = F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctosnova WHERE ucc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctosnova SELECT ".
"uce,nuc,crv,crs,pmd,pda,prm1,prm2,prm3,prm4,ucc FROM F$kli_vxcf"."_uctosnovaprenos WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctosnova SELECT ".
"uce,nuc,crv,crs,pmd,pda,prm1,prm2,prm3,prm4,ucc FROM F$kli_vxcf"."_uctosnovapovodne ".
" WHERE plati != 9";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova,F$kli_vxcf"."_uctosnovaprenos SET ".
" F$kli_vxcf"."_uctosnova.crs=F$kli_vxcf"."_uctosnovaprenos.crs, F$kli_vxcf"."_uctosnova.crv=F$kli_vxcf"."_uctosnovaprenos.crv ".
" WHERE F$kli_vxcf"."_uctosnova.uce = F$kli_vxcf"."_uctosnovaprenos.uce ";
$oznac = mysql_query("$sqtoz");

$sqlt = "DROP TABLE F".$kli_vxcf."_uctosnovaprenos";
$vysledok = mysql_query("$sqlt");

$sqlt = "DROP TABLE F".$kli_vxcf."_uctosnovapovodne";
$vysledok = mysql_query("$sqlt");

//vymaz pregenerovanie suvahy2011
$sqlt = "DROP TABLE F".$kli_vxcf."_uctgensuv2011";
$vysledok = mysql_query("$sqlt");

//vymaz pregenerovanie vykaz prijmov a vydavkov 2013
if( $kli_vrok == 2013 )
   {
$sqlt = "DROP TABLE F".$kli_vxcf."_uctgenvpv2013";
$vysledok = mysql_query("$sqlt");
   }

echo "⁄Ëtov· osnova prenesen·.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos poËiatoËn˝ch stavov na ˙Ëtoch.<br />";

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET pmd=0, pda=0 WHERE ucc > 0 ";
$oznac = mysql_query("$sqtoz");

$sql = "DROP TABLE F".$kli_vxcf."_uctzosuce ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctzosuce SELECT * FROM ".$databaza."F".$h_ycf."_uctzosuce WHERE uro != 1";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctzosuce SELECT * FROM ".$databaza."F".$h_ycf."_uctzosuce WHERE uro = 1";
$vysledek = mysql_query("$sql");

//ak hosp.rok napr. od 10.2016 do 9.2017 urob doklad z pohybov roka 2016 napr. 10.2016 aû 12.2016
if( $hosprok == 1 AND $kli_vrok != $fir_allx12 )
  {
$dokp="99900000" + $fir_allx12;
$umep="01.".$kli_vrok;
$datp=$kli_vrok."-01-01";
$txpp="hospod·rsky rok ".$fir_allx12;

$sql = "DELETE FROM F".$kli_vxcf."_uctvsdh WHERE uce = 2 AND dok = $dokp ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_uctvsdp WHERE dok = $dokp ";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctvsdh ".
" ( uce,ume,dat,dok,doq,txp,ico,hod,hodm,id,datm ) VALUES ('2','$umep','$datp','$dokp','$dokp','$txpp','$fir_fico','0','0','$kli_uzid',now() ) ";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctvsdp SELECT ".
" '$dokp', 5, 0, uce, '39500', 1, 0, zmd, 0, 0, '', '', 0, 0, '', 0, 0, '', '$kli_uzid', now() ".
" FROM  F".$kli_vxcf."_uctzosuce WHERE zmd != 0 ";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_uctvsdp SELECT ".
" '$dokp', 5, 0, '39500', uce,  1, 0, zdl, 0, 0, '', '', 0, 0, '', 0, 0, '', '$kli_uzid', now() ".
" FROM  F".$kli_vxcf."_uctzosuce WHERE zdl != 0 ";
$vysledek = mysql_query("$sql");

echo "Vöeobecn˝ doklad hospod·rskeho roka prenesen˝.<br />";
  }
//koniec ak hosp.rok napr. od 10.2016 do 9.2017 urob doklad z pohybov roka 2016 napr. 10.2016 aû 12.2016

$sql = "DELETE FROM F".$kli_vxcf."_uctzosuce WHERE LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 OR LEFT(uce,1) = 8 OR LEFT(uce,1) = 9 ";
$vysledek = mysql_query("$sql");

//akJU urob uctzosuce z prcpendens38 F".$kli_vxcf."_prcpendens".$kli_uzid.
if( $kli_vduj == 9 )
{
echo "JednoduchÈ ˙ËtovnÌctvo.<br />";

$sqlt = "DROP TABLE F".$kli_vxcf."_uctzosuce";
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   uce         VARCHAR(10),
   zmd         DECIMAL(10,2),
   zdl         DECIMAL(10,2)
);
prcdatum;

$vsql = "CREATE TABLE F".$kli_vxcf."_uctzosuce ".$sqlt;
//echo $vsql;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctzosuce SELECT".
" pokc,SUM(hotp-hotv),0 ".
" FROM ".$databaza."F".$h_ycf."_prcpendens".$kli_uzid." ".
" WHERE uro = 1 AND LEFT(pokc,3) = 211 GROUP BY pokc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctzosuce SELECT".
" ucbc,SUM(ucbp-ucbv),0 ".
" FROM ".$databaza."F".$h_ycf."_prcpendens".$kli_uzid." ".
" WHERE uro = 1 AND LEFT(ucbc,3) = 221 GROUP BY ucbc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
//koniec mam jednoduche
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova,F$kli_vxcf"."_uctzosuce SET ".
"F$kli_vxcf"."_uctosnova.pmd=zmd, pda=zdl WHERE F$kli_vxcf"."_uctosnova.uce = F$kli_vxcf"."_uctzosuce.uce ";
$oznac = mysql_query("$sqtoz");

//pociatky hosp.rok
if( $hosprok == 1 AND $kli_vrok != $fir_allx12 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET pmd=0, pda=0 WHERE ucc > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova,F$kli_vxcf"."_uctzosuce SET ".
"F$kli_vxcf"."_uctosnova.pmd=F$kli_vxcf"."_uctzosuce.pmd, pda=F$kli_vxcf"."_uctzosuce.pdl ".
" WHERE F$kli_vxcf"."_uctosnova.uce = F$kli_vxcf"."_uctzosuce.uce ";
$oznac = mysql_query("$sqtoz");

  }


//pociatok431

$sql = "DROP TABLE F".$kli_vxcf."_uctzosuce ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctzosuce SELECT * FROM ".$databaza."F".$h_ycf."_uctzosuce WHERE uro != 1";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctzosuce SELECT * FROM ".$databaza."F".$h_ycf."_uctzosuce WHERE uro = 1";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_uctzosuce WHERE LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 ";
$vysledek = mysql_query("$sql");

$sqltt = "SELECT * FROM F".$kli_vxcf."_uctzosuce WHERE uro = 1 ";
$zisk=0;
$pol=0;
$sql = mysql_query("$sqltt");
if( $sql ) { $pol = mysql_num_rows($sql); }
if( $pol > 0 ) {
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $zisk=$zisk+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

               }

$prenesaj431=1;
if( $hosprok == 1 AND $kli_vrok != $fir_allx12 ){ $prenesaj431=0; }

if( $prenesaj431 == 1 )
  {
$dsqlt = "UPDATE F$kli_vxcf"."_uctosnova SET pda=$zisk WHERE LEFT(uce,5) = 43100";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
echo "Prenos zisku=$zisk na ˙Ëet 43100<br />";
  }

if( $kli_vrok == 2009 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_uctosnova SET pmd=pmd/30.1260, pda=pda/30.1260 WHERE ucc > 0";
$dsql = mysql_query("$dsqlt");

}

//prepis analytiku mlynzahorie
if( $fir_fico == "44537018" AND $kli_vrok == 2010 )
{
$sql = "DROP TABLE F".$kli_vxcf."_uctosnovaxx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctosnovaxx SELECT * FROM F".$kli_vxcf."_uctosnova WHERE LEFT(uce,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_uctosnova WHERE LEFT(uce,3) = 311 ";
$vysledek = mysql_query("$sql");

//uce  nuc  crv  crs  pmd  pda  prm1  prm2  prm3  prm4  ucc 

$sql = "INSERT INTO F".$kli_vxcf."_uctosnova SELECT '311000',nuc,crv,crs,SUM(pmd),SUM(pda),prm1,prm2,0,0,311000 ".
"  FROM F".$kli_vxcf."_uctosnovaxx WHERE prm2 = 0 GROUP BY prm2 ";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F".$kli_vxcf."_uctosnovaxx ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_uctosnovaxx SELECT * FROM F".$kli_vxcf."_uctosnova WHERE LEFT(uce,3) = 321";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_uctosnova WHERE LEFT(uce,3) = 321 ";
$vysledek = mysql_query("$sql");

//uce  nuc  crv  crs  pmd  pda  prm1  prm2  prm3  prm4  ucc 

$sql = "INSERT INTO F".$kli_vxcf."_uctosnova SELECT '321000',nuc,crv,crs,SUM(pmd),SUM(pda),prm1,prm2,0,0,321000 ".
"  FROM F".$kli_vxcf."_uctosnovaxx WHERE prm2 = 0 GROUP BY prm2 ";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F".$kli_vxcf."_uctosnovaxx ";
$vysledek = mysql_query("$sql");
}



$sql = "DROP TABLE F".$kli_vxcf."_uctzosuce ";
$vysledek = mysql_query("$sql");


echo "PoËiatoËnÈ stavy  poËiatok ˙Ëtovej osnovy prenesenÈ.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////////

echo "⁄ËtovnÌctvo poËiatok ˙Ëtovej osnovy prenesenÈ.<br />";
}
//koniec prenos Uctovnictvo obratovka
?>

<?php
//prenos uctovnictva pociatok saldokonto
if( $prenessaldo == 1 )
{
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos poËiatoËn˝ch stavov saldokonta.<br />";

$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 )";
if( $agrostav == 1 OR $autovalas == 1 OR $delisasro == 1 OR $metalco == 1 OR $polno == 1 OR $lsucto == 1 )
{
$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 OR LEFT(ucm,2) = 37 OR LEFT(ucm,3) = 335 OR LEFT(ucm,3) = 391 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 OR LEFT(ucd,2) = 37 OR LEFT(ucd,3) = 335 OR LEFT(ucd,3) = 391 )";
}
if( $_SERVER['SERVER_NAME'] == "www.eurosekov.sk" ) 
{ 
$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 OR LEFT(ucm,2) = 37 OR LEFT(ucm,3) = 335 OR LEFT(ucm,3) = 391 OR LEFT(ucm,3) = 374 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 OR LEFT(ucd,2) = 37 OR LEFT(ucd,3) = 335 OR LEFT(ucd,3) = 391 OR LEFT(ucd,3) = 374 )";
}
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctsaldopoco ';
$vytvor = mysql_query("$vsql");
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctsaldopocd ';
$vytvor = mysql_query("$vsql");

$sql = "DROP TABLE F".$kli_vxcf."_prsaldoicofak$kli_uzid ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_prsaldoicofak$kli_uzid SELECT * FROM ".$databaza."F".$h_ycf."_prsaldoicofak$kli_uzid WHERE zos != 0";
$vysledek = mysql_query("$sql");

////faktury
$dajx1 = 1*$_REQUEST['dajx1'];
if( $fir_big == 0 ) $dajx1=1;
if( $dajx1 == 1 )
{
echo "Prenos poËiatoËn˝ch stavov odberateæsk˝ch fakt˙r.<br />";

//odber.faktury
$sqlt = "TRUNCATE F".$kli_vxcf."_fakodbpoc";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_fakodbpoc SELECT * FROM ".$databaza."F".$h_ycf."_fakodb ";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_fakodbpoc SELECT * FROM ".$databaza."F".$h_ycf."_fakodbpoc ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakodbpoc SET sz4=0 ";
$vysledek = mysql_query("$sql");

//zbavime sa starych
if( $poliklinikase == 1 AND $kli_vxcf == 809 )
{
echo "mazem";

$sql = "DELETE FROM F".$kli_vxcf."_fakodbpoc WHERE LEFT(uce,3) = 311 AND uce ! 311100 ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_prsaldoicofak$kli_uzid WHERE LEFT(uce,3) = 311 AND uce != 311100 ";
$vysledek = mysql_query("$sql");
}

$dsqlt = "UPDATE F$kli_vxcf"."_fakodbpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET sz4=99 WHERE F$kli_vxcf"."_fakodbpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakodbpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakodbpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_fakodbpoc WHERE sz4 != 99 ";
$vysledek = mysql_query("$sql");

//uctovanie k odber.fakturam
$sql = "DROP TABLE F".$kli_vxcf."_fakodbpocuct ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_fakodbpocuct SELECT * FROM F".$kli_vxcf."_uctskl WHERE ico = 1 AND ico = 0";
$vysledek = mysql_query("$sql");

//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm 
$sql = "INSERT INTO F".$kli_vxcf."_fakodbpocuct SELECT ".
"0,'0000-00-00',dok,0,0,ucm,0,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_uctodb WHERE $podmucm";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_fakodbpocuct SELECT ".
"0,'0000-00-00',dok,0,0,0,ucd,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_uctodb WHERE $podmucd";
$vysledek = mysql_query("$sql");

//dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
$umesp=0;
$poslhh = "SELECT * FROM ".$databaza."F".$h_ycf."_fakodbpocuct WHERE dok > 0 ";
$posl = mysql_query("$poslhh"); 
if($posl) { $umesp = mysql_num_rows($posl); }

if( $umesp == 0 ) {
$sql = "INSERT INTO F".$kli_vxcf."_fakodbpocuct SELECT ".
"0,'0000-00-00',dok,0,0,uce,0,1,0,(hodu-uhr),ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_fakodbpoc ";
$vysledek = mysql_query("$sql");
                       }
if( $umesp > 0 ) {
//echo "idem";
$sql = "INSERT INTO F".$kli_vxcf."_fakodbpocuct SELECT ".
"ume,dat,dok,0,0,ucm,0,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_fakodbpocuct WHERE $podmucm";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_fakodbpocuct SELECT ".
"ume,dat,dok,0,0,0,ucd,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_fakodbpocuct WHERE $podmucd";
$vysledek = mysql_query("$sql");
                       }

//zbavime sa 311xxx
if( $poliklinikase == 1 AND $kli_vxcf == 809 )
{
echo "mazem";

$sql = "DELETE FROM F".$kli_vxcf."_fakodbpocuct WHERE LEFT(ucm,3) = 311 AND ucm != 311100 ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_fakodbpocuct WHERE LEFT(ucd,3) = 311 AND ucd != 311100 ";
$vysledek = mysql_query("$sql");

}

//prepis analytiku mlynzahorie
if( $fir_fico == "44537018" AND $kli_vrok == 2010 )
{

$sql = "UPDATE F".$kli_vxcf."_fakodbpoc SET uce=31100  WHERE LEFT(uce,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakodbpocuct SET ucm=31100  WHERE LEFT(ucm,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakodbpocuct SET ucd=31100  WHERE LEFT(ucd,3) = 311";
$vysledek = mysql_query("$sql");

//exit;
}

$dsqlt = "UPDATE F$kli_vxcf"."_fakodbpocuct,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakodbpocuct.dph=99, F$kli_vxcf"."_fakodbpocuct.ume=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ume, ".
" F$kli_vxcf"."_fakodbpocuct.dat=F".$kli_vxcf."_prsaldoicofak$kli_uzid.dat ".
" WHERE F$kli_vxcf"."_fakodbpocuct.ucm=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakodbpocuct.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakodbpocuct.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_fakodbpocuct,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakodbpocuct.dph=99, F$kli_vxcf"."_fakodbpocuct.ume=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ume, ".
" F$kli_vxcf"."_fakodbpocuct.dat=F".$kli_vxcf."_prsaldoicofak$kli_uzid.dat ".
" WHERE F$kli_vxcf"."_fakodbpocuct.ucd=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakodbpocuct.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakodbpocuct.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_fakodbpocuct WHERE dph != 99 ";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_fakodbpocuct SELECT ".
"ume,dat,dok,0,0,ucm,ucd,1,0,SUM(hod),ico,fak,'',0,0,'',id,datm FROM F".$kli_vxcf."_fakodbpocuct GROUP BY dok,ucm,ucd,ico,fak";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_fakodbpocuct WHERE dph != 0 ";
$vysledek = mysql_query("$sql");
echo "OdberateæskÈ fakt˙ry prenesenÈ.<br />";

//prepis analytiku mlynzahorie
if( $fir_fico == "44537018" AND $kli_vrok == 2010 )
{

$sql = "UPDATE F".$kli_vxcf."_fakodbpoc SET uce=311000  WHERE LEFT(uce,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakodbpocuct SET ucm=311000  WHERE LEFT(ucm,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakodbpocuct SET ucd=311000  WHERE LEFT(ucd,3) = 311";
$vysledek = mysql_query("$sql");

//exit;
}

}
//koniec dajx1


//dodav.faktury
$dajx2 = 1*$_REQUEST['dajx2'];
if( $fir_big == 0 ) $dajx2=1;
if( $dajx2 == 1 )
{
echo "Prenos poËiatoËn˝ch stavov dod·vateæsk˝ch fakt˙r.<br />";
$sqlt = "TRUNCATE F".$kli_vxcf."_fakdodpoc";
$vysledok = mysql_query("$sqlt");

$sql = "INSERT INTO F".$kli_vxcf."_fakdodpoc SELECT * FROM ".$databaza."F".$h_ycf."_fakdod ";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_fakdodpoc SELECT * FROM ".$databaza."F".$h_ycf."_fakdodpoc ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_fakdodpoc MODIFY sz4 DECIMAL(4,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");

if( $_SERVER['SERVER_NAME'] == "www.euroautovalas.sk" )
{
$sql = "UPDATE F".$kli_vxcf."_fakdodpoc SET uce='321001' WHERE uce = '321401' ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakdodpoc SET uce='321004' WHERE uce = '321404' ";
$vysledek = mysql_query("$sql");
}


$sql = "UPDATE F".$kli_vxcf."_fakdodpoc SET sz4=0 ";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_fakdodpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET sz4=99 WHERE F$kli_vxcf"."_fakdodpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakdodpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakdodpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

//exit;

$sql = "DELETE FROM F".$kli_vxcf."_fakdodpoc WHERE sz4 != 99 ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_fakdodpoc MODIFY sz4 DATE NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_fakdodpoc SET sz4=daz WHERE daz != '0000-00-00' ";
$vysledek = mysql_query("$sql");

//uctovanie k dodav.fakturam
$sql = "DROP TABLE F".$kli_vxcf."_fakdodpocuct ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_fakdodpocuct SELECT * FROM F".$kli_vxcf."_uctskl WHERE ico = 1 AND ico = 0";
$vysledek = mysql_query("$sql");

//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm 
$sql = "INSERT INTO F".$kli_vxcf."_fakdodpocuct SELECT ".
"0,'0000-00-00',dok,0,0,ucm,0,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_uctdod WHERE $podmucm";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_fakdodpocuct SELECT ".
"0,'0000-00-00',dok,0,0,0,ucd,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_uctdod WHERE $podmucd";
$vysledek = mysql_query("$sql");

$umesp=0;
$poslhh = "SELECT * FROM ".$databaza."F".$h_ycf."_fakdodpocuct WHERE dok > 0 ";
$posl = mysql_query("$poslhh"); 
if($posl) { $umesp = mysql_num_rows($posl); }

if( $umesp == 0 ) { 
$sql = "INSERT INTO F".$kli_vxcf."_fakdodpocuct SELECT ".
"0,'0000-00-00',dok,0,0,0,uce,1,0,(hodu-uhr),ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_fakdodpoc ";
$vysledek = mysql_query("$sql");
                       }

if( $umesp > 0 ) {
//echo "idem";
$sql = "INSERT INTO F".$kli_vxcf."_fakdodpocuct SELECT ".
"ume,dat,dok,0,0,ucm,0,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_fakdodpocuct WHERE $podmucm";
$vysledek = mysql_query("$sql");
$sql = "INSERT INTO F".$kli_vxcf."_fakdodpocuct SELECT ".
"ume,dat,dok,0,0,0,ucd,1,0,hod,ico,fak,'',0,0,'',id,datm FROM ".$databaza."F".$h_ycf."_fakdodpocuct WHERE $podmucd";
$vysledek = mysql_query("$sql");
                       }


//prepis analytiku mlynzahorie
if( $fir_fico == "44537018" AND $kli_vrok == 2010 )
{

$sql = "UPDATE F".$kli_vxcf."_fakdodpoc SET uce=32100  WHERE LEFT(uce,3) = 321";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakdodpocuct SET ucm=32100  WHERE LEFT(ucm,3) = 321";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakdodpocuct SET ucd=32100  WHERE LEFT(ucd,3) = 321";
$vysledek = mysql_query("$sql");

//exit;
}

$dsqlt = "UPDATE F$kli_vxcf"."_fakdodpocuct,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakdodpocuct.dph=99, F$kli_vxcf"."_fakdodpocuct.ume=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ume, ".
" F$kli_vxcf"."_fakdodpocuct.dat=F".$kli_vxcf."_prsaldoicofak$kli_uzid.dat ".
" WHERE F$kli_vxcf"."_fakdodpocuct.ucm=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakdodpocuct.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakdodpocuct.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_fakdodpocuct,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakdodpocuct.dph=99, F$kli_vxcf"."_fakdodpocuct.ume=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ume, ".
" F$kli_vxcf"."_fakdodpocuct.dat=F".$kli_vxcf."_prsaldoicofak$kli_uzid.dat ".
" WHERE F$kli_vxcf"."_fakdodpocuct.ucd=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakdodpocuct.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakdodpocuct.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_fakdodpocuct WHERE dph != 99 ";
$vysledek = mysql_query("$sql");


$sql = "INSERT INTO F".$kli_vxcf."_fakdodpocuct SELECT ".
"ume,dat,dok,0,0,ucm,ucd,1,0,SUM(hod),ico,fak,'',0,0,'',id,datm FROM F".$kli_vxcf."_fakdodpocuct GROUP BY dok,ucm,ucd,ico,fak";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_fakdodpocuct WHERE dph != 0 ";
$vysledek = mysql_query("$sql");
echo "Dod·vateæskÈ fakt˙ry prenesenÈ.<br />";

//prepis analytiku mlynzahorie
if( $fir_fico == "44537018" AND $kli_vrok == 2010 )
{

$sql = "UPDATE F".$kli_vxcf."_fakdodpoc SET uce=321000  WHERE LEFT(uce,3) = 321";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakdodpocuct SET ucm=321000  WHERE LEFT(ucm,3) = 321";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakdodpocuct SET ucd=321000  WHERE LEFT(ucd,3) = 321";
$vysledek = mysql_query("$sql");

//exit;
}

}
//koniec dajx2

////uhrady
$dajx3 = 1*$_REQUEST['dajx3'];
if( $fir_big == 0 ) $dajx3=1;
if( $dajx3 == 1 )
{
echo "Prenos poËiatoËn˝ch stavov ˙hrad.<br />";
$sql = "CREATE TABLE F".$kli_vxcf."_uctuhradpoc SELECT * FROM F".$kli_vxcf."_uctskl WHERE dok = 0";
$vysledek = mysql_query("$sql");

$sqlt = "TRUNCATE F".$kli_vxcf."_uctuhradpoc";
$vysledok = mysql_query("$sqlt");

//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  

//rozsir o zmen,mena,kurz,hodm
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD kurz DECIMAL(14,6) DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD mena VARCHAR(5) NOT NULL AFTER datm";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctuhradpoc ADD zmen INT(1) DEFAULT 0 AFTER datm";
$vysledek = mysql_query("$sql");


//pokl.prijem
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokpri".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokpri.dok AND $podmucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokpri".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokpri.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");

//pokl.vydaj
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokvyd".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokvyd.dok AND $podmucm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctpokuct.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctpokuct.hod,".$databaza."F$h_ycf"."_uctpokuct.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctpokuct.pop),0,0,'',".$databaza."F$h_ycf"."_uctpokuct.id,".$databaza."F$h_ycf"."_uctpokuct.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctpokuct,".$databaza."F$h_ycf"."_pokvyd".
" WHERE ".$databaza."F$h_ycf"."_uctpokuct.dok=".$databaza."F$h_ycf"."_pokvyd.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");

$datumx="dat";
if( $fir_allx15 == 1 ) { $datumx="ddu"; }

//banka
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,$datumx,".$databaza."F$h_ycf"."_uctban.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctban.hod,".$databaza."F$h_ycf"."_uctban.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctban.pop),0,0,'',".$databaza."F$h_ycf"."_uctban.id,".$databaza."F$h_ycf"."_uctban.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctban,".$databaza."F$h_ycf"."_banvyp".
" WHERE ".$databaza."F$h_ycf"."_uctban.dok=".$databaza."F$h_ycf"."_banvyp.dok AND $podmucm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,$datumx,".$databaza."F$h_ycf"."_uctban.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctban.hod,".$databaza."F$h_ycf"."_uctban.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctban.pop),0,0,'',".$databaza."F$h_ycf"."_uctban.id,".$databaza."F$h_ycf"."_uctban.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctban,".$databaza."F$h_ycf"."_banvyp".
" WHERE ".$databaza."F$h_ycf"."_uctban.dok=".$databaza."F$h_ycf"."_banvyp.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");

//vseobecne
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctvsdp.dok,0,0,ucm,0,1,0,".$databaza."F$h_ycf"."_uctvsdp.hod,".$databaza."F$h_ycf"."_uctvsdp.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctvsdp.pop),0,0,'',".$databaza."F$h_ycf"."_uctvsdp.id,".$databaza."F$h_ycf"."_uctvsdp.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctvsdp,".$databaza."F$h_ycf"."_uctvsdh".
" WHERE ".$databaza."F$h_ycf"."_uctvsdp.dok=".$databaza."F$h_ycf"."_uctvsdh.dok AND $podmucm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,".$databaza."F$h_ycf"."_uctvsdp.dok,0,0,0,ucd,1,0,".$databaza."F$h_ycf"."_uctvsdp.hod,".$databaza."F$h_ycf"."_uctvsdp.ico,fak,".
"CONCAT(txp, ' ', ".$databaza."F$h_ycf"."_uctvsdp.pop),0,0,'',".$databaza."F$h_ycf"."_uctvsdp.id,".$databaza."F$h_ycf"."_uctvsdp.datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctvsdp,".$databaza."F$h_ycf"."_uctvsdh".
" WHERE ".$databaza."F$h_ycf"."_uctvsdp.dok=".$databaza."F$h_ycf"."_uctvsdh.dok AND $podmucd";
$dsql = mysql_query("$dsqlt");

//mzdy
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,dok,0,0,ucm,0,1,0,hod,ico,fak,".
" pop,0,0,'',id,datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctmzd ".
" WHERE $podmucm ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,dok,0,0,0,ucd,1,0,hod,ico,fak,".
" pop,0,0,'',id,datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctmzd ".
" WHERE $podmucd ";
$dsql = mysql_query("$dsqlt");


//minulorocne
//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  zmen  mena  kurz  hodm  
//pozor ked sa ale prenasalo skoro nemusi obsahovat uctuhradpoc minuleho roka polozky zmen,mena,kurz,hodm
//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
$fir_allx11min=0;
$sqlttt = " SELECT * FROM ".$databaza."F".$h_ycf."_ufir ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $fir_allx11min=1*$riaddok->allx11;
  }
if( $fir_allx11min > 0 )
  {
//echo "idem";
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,dok,poh,0,ucm,0,rdp,1,hod,ico,fak,pop,str,zak,unk,id,datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctuhradpoc ".
" WHERE $podmucm ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,dok,poh,0,0,ucd,rdp,1,hod,ico,fak,pop,str,zak,unk,id,datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctuhradpoc ".
" WHERE $podmucd ";
$dsql = mysql_query("$dsqlt");
  }
//echo $dsqlt;
//exit;

//prepis analytiku mlynzahorie
if( $fir_fico == "44537018" AND $kli_vrok == 2010 )
{

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucm=31100  WHERE LEFT(ucm,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucd=31100  WHERE LEFT(ucd,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucm=32100  WHERE LEFT(ucm,3) = 321";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucd=32100  WHERE LEFT(ucd,3) = 321";
$vysledek = mysql_query("$sql");

//exit;
}

//zbavime sa 311xxx
if( $poliklinikase == 1 AND $kli_vxcf == 809 )
{
echo "mazem";

$sql = "DELETE FROM F".$kli_vxcf."_uctuhradpoc WHERE LEFT(ucm,3) = 311 AND ucm != 311100 ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_uctuhradpoc WHERE LEFT(ucd,3) = 311 AND ucd != 311100 ";
$vysledek = mysql_query("$sql");

}

//zmaz sparovane
$dsqlt = "UPDATE F$kli_vxcf"."_uctuhradpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_uctuhradpoc.dph=99 WHERE F$kli_vxcf"."_uctuhradpoc.ucm=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_uctuhradpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_uctuhradpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctuhradpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_uctuhradpoc.dph=99 WHERE F$kli_vxcf"."_uctuhradpoc.ucd=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_uctuhradpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_uctuhradpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_uctuhradpoc WHERE dph != 99 ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_uctuhradpoc WHERE fak=0 AND ico=0 ";
$vysledek = mysql_query("$sql");

//zalohy z mtz mimo system
if( $autovalas == 1 AND $kli_vrok == 2013 )
   {

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctuhradpoc".
" SELECT ume,dat,dok,0,0,0,ucd,1,0,hod,ico,fak,".
" pop,0,0,'',id,datm,0,'',0,0 ".
" FROM ".$databaza."F$h_ycf"."_uctskl ".
" WHERE ucd = 324100 AND ume > 8.2012 AND ( fak = 909191030 OR fak = 909131423 OR fak = 912201318 OR fak = 909251344 OR fak = 411021449 )  ";
$dsql = mysql_query("$dsqlt");
   }

echo "⁄hrady prenesenÈ.<br />";


if( $fir_fico == "44537018" AND $kli_vrok == 2010 )
{

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucm=311000  WHERE LEFT(ucm,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucd=311000  WHERE LEFT(ucd,3) = 311";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucm=321000  WHERE LEFT(ucm,3) = 321";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_uctuhradpoc SET ucd=321000  WHERE LEFT(ucd,3) = 321";
$vysledek = mysql_query("$sql");

//exit;
}


//len pre metalco a alchem uprav  pri faktoringovych polozkach
if( $metalco == 1 OR $alchem == 1 )
          {
//echo "idem";
$dsqlt = "UPDATE F$kli_vxcf"."_uctuhradpoc,".$databaza."F$h_ycf"."_uctfktspl ".
" SET dph=66, datm=fspl ".
" WHERE F$kli_vxcf"."_uctuhradpoc.dok = ".$databaza."F$h_ycf"."_uctfktspl.fdok  ".
" AND F$kli_vxcf"."_uctuhradpoc.ucm = ".$databaza."F$h_ycf"."_uctfktspl.fuce  ".
" AND F$kli_vxcf"."_uctuhradpoc.ico = ".$databaza."F$h_ycf"."_uctfktspl.fico  ".
" AND F$kli_vxcf"."_uctuhradpoc.fak = ".$databaza."F$h_ycf"."_uctfktspl.ffak  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctuhradpoc,".$databaza."F$h_ycf"."_uctfktspl ".
" SET dph=77, datm=fspl ".
" WHERE F$kli_vxcf"."_uctuhradpoc.dok = ".$databaza."F$h_ycf"."_uctfktspl.fdok  ".
" AND F$kli_vxcf"."_uctuhradpoc.ico = ".$databaza."F$h_ycf"."_uctfktspl.fico  ".
" AND F$kli_vxcf"."_uctuhradpoc.fak = ".$databaza."F$h_ycf"."_uctfktspl.ffak AND dph != 66 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctuhradpoc ".
" SET dph=66 WHERE  LEFT(ucm,3) = 311 AND dph = 77 ";
$dsql = mysql_query("$dsqlt");

//exit;

//F533_uctuhradpoc  ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
//                  zmen  mena  kurz  hodm  

//F533_fakodbpocuct ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
$dsqlt = "INSERT INTO F$kli_vxcf"."_fakodbpocuct ".
" SELECT ".
" ume,dat,dok,poh,0,ucm,ucd,rdp,0,hod,ico,fak,pop,str,zak,unk,id,now() ".
" FROM  F$kli_vxcf"."_uctuhradpoc ".
" WHERE F$kli_vxcf"."_uctuhradpoc.dph = 66  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//F533_uctuhradpoc  ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
//                  zmen  mena  kurz  hodm  

//F533_fakodbpoc    uce  ume  dat  dav  das  daz  dok  doq  skl  poh  ico  fak  dol  prf  obj  unk  dpr  ksy  
//                  ssy  poz  str  zak  txz  txp  zk0  zk1  zk2  zk3  zk4  dn1  dn2  dn3  dn4  sp1  sp2  sz1  
//                  sz2  sz3  sz4  zk0u  zk1u  zk2u  dn1u  dn2u  sp0u  sp1u  sp2u  hodu  hod  hodm  kurz  mena  
//                  zmen  odbm  zal  zao  ruc  uhr  id  datm  
$dsqlt = "INSERT INTO F$kli_vxcf"."_fakodbpoc ".
" SELECT ".
" ucm,ume,dat,dat,datm,dat,dok,dok,0,poh,ico,fak,0,0,'','','','',".  
" '',pop,str,zak,'',pop,hod,0,0,0,0,0,0,0,0,0,0,0,".  
" 0,0,0,hod,0,0,0,0,hod,0,0,hod,hod,0,0,'',". 
" 0,0,0,0,0,0,id,now() ".
" FROM  F$kli_vxcf"."_uctuhradpoc ".
" WHERE F$kli_vxcf"."_uctuhradpoc.dph = 66  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctuhradpoc WHERE dph = 66  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//rovnako aj dodavatelske faktoringy
$dsqlt = "INSERT INTO F$kli_vxcf"."_fakdodpocuct ".
" SELECT ".
" ume,dat,dok,poh,0,ucm,ucd,rdp,0,hod,ico,fak,pop,str,zak,unk,id,now() ".
" FROM  F$kli_vxcf"."_uctuhradpoc ".
" WHERE F$kli_vxcf"."_uctuhradpoc.dph = 77  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_fakdodpoc ".
" SELECT ".
" ucd,ume,dat,dat,datm,dat,dok,dok,0,poh,ico,fak,0,0,'','','','',".  
" '',pop,str,zak,'',pop,hod,0,0,0,0,0,0,0,0,0,0,0,".  
" 0,0,0,hod,0,0,0,0,hod,0,0,hod,hod,0,0,'',". 
" 0,0,0,0,0,0,id,now() ".
" FROM  F$kli_vxcf"."_uctuhradpoc ".
" WHERE F$kli_vxcf"."_uctuhradpoc.dph = 77  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctuhradpoc WHERE dph = 77  ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


          }
//koniec len pre metalco uprav pri faktoringovych polozkach

}
//koniec dajx3

//ak jednoduche prenes uhrady do faktur uhrada je rozuctovana na 343 a 60=druh prijmu,vydavku zober to z prsaldoicofak
if( $kli_vduj == 9 )
{
echo "JednoduchÈ ˙ËtovnÌctvo.<br />";
$sql = "DROP TABLE F".$kli_vxcf."_prsaldoicofak$kli_uzid ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_prsaldoicofak$kli_uzid SELECT * FROM ".$databaza."F".$h_ycf."_prsaldoicofak$kli_uzid WHERE zos != 0";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_fakodbpoc ".
" SELECT ".
" uce,ume,MAX(dat),MAX(dav),MAX(das),MAX(daz),MAX(dok),9999,skl,poh,ico,fak,dol,prf,obj,unk,dpr,ksy,ssy,poz,str,zak,txz,txp,".  
" SUM(zk0),SUM(zk1),SUM(zk2),SUM(zk3),SUM(zk4),SUM(dn1),SUM(dn2),SUM(dn3),SUM(dn4),SUM(sp1),SUM(sp2),".
" sz1,sz2,sz3,sz4,SUM(zk0u),SUM(zk1u),SUM(zk2u),SUM(dn1u),SUM(dn2u),SUM(sp0u),SUM(sp1u),SUM(sp2u),SUM(hodu),SUM(hod),SUM(hodm),". 
" kurz,mena,zmen,odbm,zal,SUM(zao),ruc,0,id,now() ".
" FROM  F$kli_vxcf"."_fakodbpoc ".
" WHERE uce > 0  GROUP BY uce,ico,fak ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_fakodbpoc WHERE doq != 9999 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakodbpoc SET doq = dok ";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_fakodbpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakodbpoc.uhr=F$kli_vxcf"."_fakodbpoc.uhr+F".$kli_vxcf."_prsaldoicofak$kli_uzid.uhr ".
" WHERE F$kli_vxcf"."_fakodbpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakodbpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakodbpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

//orange rovnake vsy urob sumu dodav za ico,fak
//uce  ume  dat  dav  das  daz  dok  doq  skl  poh  ico  fak  dol  prf  obj  unk  dpr  ksy  ssy  poz  str  zak  txz  txp  
//zk0  zk1  zk2  zk3  zk4  dn1  dn2  dn3  dn4  sp1  sp2  sz1  sz2  sz3  sz4  zk0u  zk1u  zk2u  dn1u  dn2u  sp0u  sp1u  sp2u  hodu  hod hodm   
//kurz  mena  zmen  odbm  zal  zao  ruc  uhr  id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_fakdodpoc ".
" SELECT ".
" uce,ume,MAX(dat),MAX(dav),MAX(das),MAX(daz),MAX(dok),9999,skl,poh,ico,fak,dol,prf,obj,unk,dpr,ksy,ssy,poz,str,zak,txz,txp,".  
" SUM(zk0),SUM(zk1),SUM(zk2),SUM(zk3),SUM(zk4),SUM(dn1),SUM(dn2),SUM(dn3),SUM(dn4),SUM(sp1),SUM(sp2),".
" sz1,sz2,sz3,sz4,SUM(zk0u),SUM(zk1u),SUM(zk2u),SUM(dn1u),SUM(dn2u),SUM(sp0u),SUM(sp1u),SUM(sp2u),SUM(hodu),SUM(hod),SUM(hodm),". 
" kurz,mena,zmen,odbm,zal,SUM(zao),ruc,0,id,now() ".
" FROM  F$kli_vxcf"."_fakdodpoc ".
" WHERE uce > 0  GROUP BY uce,ico,fak ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_fakdodpoc WHERE doq != 9999 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_fakdodpoc SET doq = dok ";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_fakdodpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakdodpoc.uhr=F$kli_vxcf"."_fakdodpoc.uhr+F".$kli_vxcf."_prsaldoicofak$kli_uzid.uhr ".
" WHERE F$kli_vxcf"."_fakdodpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakdodpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakdodpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
$dsql = mysql_query("$dsqlt");

//tu vymaz z fakodbpoc, ktore vobec nie su prsaldoicofak
$dsqlt = "UPDATE F$kli_vxcf"."_fakodbpoc SET poh=9 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_fakdodpoc SET poh=9 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_fakodbpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakodbpoc.poh=0 ".
" WHERE F$kli_vxcf"."_fakodbpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakodbpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakodbpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_fakdodpoc,F".$kli_vxcf."_prsaldoicofak$kli_uzid ".
" SET F$kli_vxcf"."_fakdodpoc.poh=0 ".
" WHERE F$kli_vxcf"."_fakdodpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakdodpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakdodpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_fakdodpoc WHERE poh = 9 ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_fakodbpoc WHERE poh = 9 ";
$vysledek = mysql_query("$sql");

//tu vymaz z prsaldoicofak, ktore su v fakodbpoc to uz nerobim
$dsqlt = "UPDATE F".$kli_vxcf."_prsaldoicofak$kli_uzid,F$kli_vxcf"."_fakodbpoc ".
" SET F".$kli_vxcf."_prsaldoicofak$kli_uzid.puc=99 ".
" WHERE F$kli_vxcf"."_fakodbpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakodbpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakodbpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F".$kli_vxcf."_prsaldoicofak$kli_uzid,F$kli_vxcf"."_fakdodpoc ".
" SET F".$kli_vxcf."_prsaldoicofak$kli_uzid.puc=99 ".
" WHERE F$kli_vxcf"."_fakdodpoc.uce=F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce ".
" AND F$kli_vxcf"."_fakdodpoc.ico=F".$kli_vxcf."_prsaldoicofak$kli_uzid.ico ".
" AND F$kli_vxcf"."_fakdodpoc.fak=F".$kli_vxcf."_prsaldoicofak$kli_uzid.fak ";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F".$kli_vxcf."_prsaldoicofak$kli_uzid WHERE puc = 99 ";
//$vysledek = mysql_query("$sql");

//prsaldoicofak drupoh  uce  puc  ume  dat  das  daz  dok  ico  fak  poz  ksy  ssy  hdp  hdu  hod  uhr  zos  dau  

//fakodbpoc  uce  ume  dat  dav  das  daz  dok  doq  skl  poh  ico  fak  dol  prf  obj  unk  dpr  ksy  ssy  poz  str  zak  
// txz  txp  zk0  zk1  zk2  zk3  zk4  dn1  dn2  dn3  dn4  sp1  sp2  sz1  sz2  sz3  sz4  zk0u  zk1u  zk2u  dn1u  dn2u  sp0u  sp1u  sp2u  hodu  hod  
// hodm  kurz  mena  zmen  odbm  zal  zao  ruc  uhr  id  datm  

$dsqlt = "INSERT INTO F$kli_vxcf"."_fakodbpoc ".
" SELECT uce,ume,dau,dau,dau,dau,dok,dok,0,0,ico,fak,0,0,0,'','','','',poz,0,0,".
" '','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,0,0,0,0,uhr,$kli_uzid,now() ".
" FROM F".$kli_vxcf."_prsaldoicofak$kli_uzid WHERE F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce=31100 ";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_fakdodpoc ".
" SELECT uce,ume,dau,dau,dau,dau,dok,dok,0,0,ico,fak,0,0,0,'','','','',poz,0,0,".
" '','',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'',0,0,0,0,0,uhr,$kli_uzid,now() ".
" FROM F".$kli_vxcf."_prsaldoicofak$kli_uzid WHERE F".$kli_vxcf."_prsaldoicofak$kli_uzid.uce=32100 ";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");



$doklad=0; $faktura=0; $ucet=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid WHERE dok > 0 AND uce = 31100 ORDER BY uce");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucet=$riaddok->uce;
  $doklad=$riaddok->dok;
  $faktura=$riaddok->fak;
  }
//echo $doklad." ".$faktura." ".$ucet;

$sql = "DELETE FROM F".$kli_vxcf."_uctuhradpoc WHERE dok > 0 ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_fakdodpocuct WHERE dok > 0 ";
$vysledek = mysql_query("$sql");
$sql = "DELETE FROM F".$kli_vxcf."_fakodbpocuct WHERE dok > 0 ";
$vysledek = mysql_query("$sql");

//if( $kli_uzid == 17 ) { exit; }
}
//koniec prenos uhrad jednoduche


include("../ucto/saldo_zmaz_ok.php");

echo "PoËiatoËnÈ stavy saldokonta prenesenÈ.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////////

echo "⁄ËtovnÌctvo Saldokonto prenesenÈ.<br />";
}
//koniec prenos Uctovnictvo saldokonto
?>

<?php
//prenos udaje MZDY
if( $copernxy == 109 )
{

echo "Prenos MZDY.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////

echo "Prenos KmeÚovÈ ˙daje.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdkun SELECT * FROM ".$databaza."F$h_ycf"."_mzdkun WHERE ".$databaza."F$h_ycf"."_mzdkun.oc >= 0";
$dsql = mysql_query("$dsqlt");

$sql = "UPDATE F".$kli_vxcf."_mzdkun SET nev=0, crp=0  WHERE oc >= 0";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun,".$databaza."F".$h_ycf."_mzdprcdovolx$kli_uzid ".
" SET F$kli_vxcf"."_mzdkun.nev=".$databaza."F".$h_ycf."_mzdprcdovolx$kli_uzid.zostatok ".
" WHERE F$kli_vxcf"."_mzdkun.oc=".$databaza."F".$h_ycf."_mzdprcdovolx$kli_uzid.oc ";
$dsql = mysql_query("$dsqlt");

echo "Prenos TrvalÈ poloûky.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdtrn SELECT * FROM ".$databaza."F$h_ycf"."_mzdtrn WHERE ".$databaza."F$h_ycf"."_mzdtrn.oc >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos DDP zamestnancov.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdddp SELECT * FROM ".$databaza."F$h_ycf"."_mzdddp WHERE ".$databaza."F$h_ycf"."_mzdddp.oc >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos DetÌ zamestnancov.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddeti SELECT * FROM ".$databaza."F$h_ycf"."_mzddeti WHERE ".$databaza."F$h_ycf"."_mzddeti.oc >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos doplÚuj˙ce ˙daje zamestnancov.<br />";
$sqlt = "DROP TABLE F".$kli_vxcf."_mzdtextmzd";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdtextmzd SELECT * FROM ".$databaza."F$h_ycf"."_mzdtextmzd WHERE invt >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdtextmzd MODIFY invt VARCHAR(30) PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

echo "Prenos s˙beûnÈ pracovnÈ pomery zamestnancov.<br />";
$sqlt = "DROP TABLE F".$kli_vxcf."_mzdsubeznepp";
$vysledok = mysql_query("$sqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdsubeznepp SELECT * FROM ".$databaza."F$h_ycf"."_mzdsubeznepp WHERE cpl >= 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdsubeznepp MODIFY cpl INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT ";
$vysledek = mysql_query("$sql");


//cpl  oc  typ  kedy  nazov  paragraf  text1  text2  popis  pozn  konx1  
echo "Prenos person·lnych zml˙v.<br />";
$dsqlt = "DROP TABLE F$kli_vxcf"."_personal_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_personal_dok SELECT * FROM ".$databaza."F$h_ycf"."_personal_dok ";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_personal_dok MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new032009";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new072009";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010dovera3";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010a";
$vysledek = mysql_query("$sql");

if( $kli_vrok == 2011 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dm952";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dm953";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2012 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012c";
$vysledek = mysql_query("$sql");

$rokvym=$kli_vrok-2;
$datvym=$rokvym."-01-01";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '".$datvym."' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '".$datvym."' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '".$datvym."' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '".$datvym."' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

if( $kli_vrok == 2013 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013c";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2012-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2012-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2012-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '2012-01-01' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

if( $kli_vrok == 2014 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012014a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012014b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012014c";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2013-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2013-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2013-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '2013-01-01' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

if( $kli_vrok == 2015 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012015a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012015b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012015c";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2014-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2014-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2014-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '2014-01-01' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

}

if( $kli_vrok == 2016 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012016a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012016b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012016c";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2015-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2015-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2015-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '2015-01-01' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

}


if( $kli_vrok == 2017 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012017a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012017b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012017c";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2016-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2016-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2016-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '2016-01-01' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

}


if( $kli_vrok == 2018 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012018a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012018b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012018c";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2017-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2017-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2017-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '2017-01-01' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

}


if( $kli_vrok == 2019 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012019a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012019b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012019c";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2018-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2018-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_mzdkun.oc ".
" AND F$kli_vxcf"."_mzdkun.pom = 9 AND F$kli_vxcf"."_mzdkun.dav < '2018-01-01' AND F$kli_vxcf"."_mzdkun.dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE pom = 9 AND dav < '2018-01-01' AND dav != '0000-00-00' ";
$dsql = mysql_query("$dsqlt");

}

////////////////////////////////////////////////////////////////////////////////////////////////////

echo "MZDY prenesenÈ.<br />";
}
//koniec prenos udaje MZDY copern 109
?>


<?php
//prenos ciselniky MZDY
if( $prenescismzdy == 1 )
{

echo "Prenos ËÌselnÌkov MZDY.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////

echo "Prenos Druhov pomerov.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdpomer WHERE pm >= 0";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdpomer MODIFY pm3 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdpomer SELECT * FROM ".$databaza."F$h_ycf"."_mzdpomer WHERE ".$databaza."F$h_ycf"."_mzdpomer.pm >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos Druhov mzdov˝ch zloûiek.<br />";
$dsqlt = "DROP TABLE F$kli_vxcf"."_mzddmn ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_mzddmn SELECT * FROM ".$databaza."F$h_ycf"."_mzddmn ";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok == 2011 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dmpm ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dmpm_a ";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dmpm_b ";
$vysledek = mysql_query("$sql");
}

echo "Prenos »ÌselnÌka ZP.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdcisddp WHERE cddp >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdcisddp SELECT * FROM ".$databaza."F$h_ycf"."_mzdcisddp WHERE ".$databaza."F$h_ycf"."_mzdcisddp.cddp >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos »ÌselnÌka DSS.<br />";
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddss WHERE cdss >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzddss SELECT * FROM ".$databaza."F$h_ycf"."_mzddss WHERE ".$databaza."F$h_ycf"."_mzddss.cdss >= 0";
$dsql = mysql_query("$dsqlt");

echo "Prenos ⁄Ëtovania miezd.<br />";
$dsqlt = "DROP TABLE F$kli_vxcf"."_mzducty ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_mzducty SELECT * FROM ".$databaza."F$h_ycf"."_mzducty ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzducty SET cfuct=0 ";
$dsql = mysql_query("$dsqlt");

echo "Prenos »ÌselnÌka ZP.<br />";
$dsqlt = "DROP TABLE F$kli_vxcf"."_zdravpois ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_zdravpois SELECT * FROM ".$databaza."F$h_ycf"."_zdravpois ";
$dsql = mysql_query("$dsqlt");

echo "Prenos Parametre odvodov a dane.<br />";
$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprm ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_mzdprm SELECT * FROM ".$databaza."F$h_ycf"."_mzdprm ";
$dsql = mysql_query("$dsqlt");

//uprava parametrov miezd na aktualny stav od 1.1.2015
if( $kli_vrok == 2015 )
    {
$vyb_roks=2015;
$mysqldbdatas="";
$vyb_xcfs=$kli_vxcf;
$setprm = include("../mzdy/set2015parametre.php");
    }
//uprava parametrov miezd na aktualny stav od 1.1.2015

//uprava parametrov miezd na aktualny stav od 1.1.2016
if( $kli_vrok == 2016 )
    {
$vyb_roks=2016;
$mysqldbdatas="";
$vyb_xcfs=$kli_vxcf;
$setprm = include("../mzdy/set2016parametre.php");
    }
//uprava parametrov miezd na aktualny stav od 1.1.2016

//uprava parametrov miezd na aktualny stav od 1.1.2017
if( $kli_vrok == 2017 )
    {
$vyb_roks=2017;
$mysqldbdatas=$mysqldb;
$vyb_xcfs=$kli_vxcf;
$setprm = include("../mzdy/set2017parametre.php");
    }
//uprava parametrov miezd na aktualny stav od 1.1.2017

//uprava parametrov miezd na aktualny stav od 1.1.2018
if( $kli_vrok == 2018 )
    {
$vyb_roks=2018;
$mysqldbdatas=$mysqldb;
$vyb_xcfs=$kli_vxcf;
$setprm = include("../mzdy/set2018parametre.php");
    }
//uprava parametrov miezd na aktualny stav od 1.1.2018

//uprava parametrov miezd na aktualny stav od 1.1.2019
if( $kli_vrok == 2019 )
    {
$vyb_roks=2019;
$mysqldbdatas=$mysqldb;
$vyb_xcfs=$kli_vxcf;
$setprm = include("../mzdy/set2019parametre.php");
    }
//uprava parametrov miezd na aktualny stav od 1.1.2019

echo "Prenos Trexima.<br />";
$dsqlt = "DROP TABLE F$kli_vxcf"."_treximafir ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_treximafir SELECT * FROM ".$databaza."F$h_ycf"."_treximafir ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_treximaoc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_treximaoc SELECT * FROM ".$databaza."F$h_ycf"."_treximaoc ";
$dsql = mysql_query("$dsqlt");

echo "Prenos Delen˝ch prÌjmov pre priemery na n·hrady.<br />";
$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprnahdelene ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_mzdprnahdelene SELECT * FROM ".$databaza."F$h_ycf"."_mzdprnahdelene ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprnahset ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_mzdprnahset SELECT * FROM ".$databaza."F$h_ycf"."_mzdprnahset ";
$dsql = mysql_query("$dsqlt");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new032009";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new072009";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010dovera3";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010a";
$vysledek = mysql_query("$sql");

if( $kli_vrok == 2011 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dm952";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011dm953";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2013 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013pomer_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013pomer_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013pomer_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013pomer_e";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013pomer_f";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2014 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012014a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012014b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012014c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014pomer_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014pomer_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014pomer_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014pomer_e";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014pomer_f";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2015 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012015a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012015b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012015c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015pomer_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015pomer_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015pomer_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015pomer_e";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015pomer_f";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2016 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012016a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012016b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012016c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016pomer_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016pomer_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016pomer_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016pomer_e";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016pomer_f";
$vysledek = mysql_query("$sql");
}

if( $kli_vrok == 2017 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012017a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012017b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012017c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017pomer_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017pomer_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017pomer_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017pomer_e";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012017pomer_f";
$vysledek = mysql_query("$sql");

}

if( $kli_vrok == 2018 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012018a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012018b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012018c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018pomer_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018pomer_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018pomer_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018pomer_e";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018pomer_f";
$vysledek = mysql_query("$sql");

}

if( $kli_vrok == 2019 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012019a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012019b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_sepa012019c";
$vysledek = mysql_query("$sql");

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019pomer_a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019pomer_b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019pomer_c";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019pomer_d";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019pomer_e";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012019pomer_f";
$vysledek = mysql_query("$sql");

}

$ajdban=0;
$sudod=0; $suodb=0; $supok=0; $suban=0; 
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctdod WHERE dok > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $sudod=1;
  }
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctodb WHERE dok > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $suodb=1;
  }
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctpokuct WHERE dok > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $supok=1;
  }
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctban WHERE dok > 0 "; $sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $suban=1;
  }
if( $sudod == 0 AND $suodb == 0 AND $supok == 0 AND $suban == 0 ) { $ajdban=1; }
if( $ajdban == 1 )
{
echo "Prenos Druhov Bankov˝ch ˙Ëtov.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_dban ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_dban SELECT * FROM ".$databaza."F$h_ycf"."_dban WHERE ".$databaza."F$h_ycf"."_dban.dban >= 0";
$dsql = mysql_query("$dsqlt");
}

////////////////////////////////////////////////////////////////////////////////////////////////////

echo "»ÌselnÌky MZDY prenesenÈ.<br />";
}
//koniec prenos udaje MZDY cismzdy=1
?>


<?php
//prenos VYROBA
if( $copernxy == 108 )
{

echo "Prenos VYROBA.<br />";
////////////////////////////////////////////////////////////////////////////////////////////////
echo "Prenos ËÌselnÌkov a datab·z v˝roby.<br />";

$dsqlt = "DROP TABLE F$kli_vxcf"."_dopsluzby ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_dopsluzby SELECT * FROM ".$databaza."F$h_ycf"."_dopsluzby ";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok >= 2011 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_dopsluzby SET dph=20, ced=cep*1.20 WHERE dph = 19";
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_ufir SET dph2=20, dph4=19 "; $ttqq = mysql_query("$ttvv");
}

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrkontakt ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrkontakt SELECT * FROM ".$databaza."F$h_ycf"."_vyrkontakt ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrkontaktemail ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrkontaktemail SELECT * FROM ".$databaza."F$h_ycf"."_vyrkontaktemail ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrseklem ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrseklem SELECT * FROM ".$databaza."F$h_ycf"."_vyrseklem ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrsekmodel ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrsekmodel SELECT * FROM ".$databaza."F$h_ycf"."_vyrsekmodel ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrseknosny ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrseknosny SELECT * FROM ".$databaza."F$h_ycf"."_vyrseknosny ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrsekoko ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrsekoko SELECT * FROM ".$databaza."F$h_ycf"."_vyrsekoko ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrsekrozper ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrsekrozper SELECT * FROM ".$databaza."F$h_ycf"."_vyrsekrozper ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrsekvyr ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrsekvyr SELECT * FROM ".$databaza."F$h_ycf"."_vyrsekvyr ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrzakdopln ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrzakdopln SELECT * FROM ".$databaza."F$h_ycf"."_vyrzakdopln ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_vyrzakpol ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_vyrzakpol SELECT * FROM ".$databaza."F$h_ycf"."_vyrzakpol ";
$dsql = mysql_query("$dsqlt");

//POZOR v eurosekov.sk prenes aj nevyfakturovane zakazky _vyrrcph kvoli prenosu DP pozri tvrde_upravy.php

$dsqlt = "DELETE FROM F$kli_vxcf"."_vyrzakpol WHERE zak >= 170000 AND zak <= 179999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_vyrzakdopln WHERE zak >= 170000 AND zak <= 179999 ";
$dsql = mysql_query("$dsqlt");

////////////////////////////////////////////////////////////////////////////////////////////////////

echo "VYROBA prenesen·.<br />";
}
//koniec prenos VYROBA copern 108
?>

<?php

// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
