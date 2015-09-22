<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'HIM';
$zana = 1*$_REQUEST['zana'];
if( $zana == 1 ) $sys="ANA";
$urov = 1000;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvmaj";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../majetok/vtvmaj.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$vybzam = 1*$_REQUEST['vybzam'];

//echo $cislo_oc;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");
if( $agrostav == 1 AND $kli_vxcf == 109 ) { $kli_vxcf=2; }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Karty majetok</title>
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

<script type="text/javascript" src="spr_karvyber_xml.js"></script>
<script type="text/javascript" src="spr_karukaz_xml.js"></script>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

//funkcia na nastavenie Uce 
    function nastavUce()
    {
        var jehodnota = document.forms.forms1.h_uce.value;
        if( jehodnota == 1 ) {  document.forms1.h_uce.value = 0; }
        if( jehodnota == 0 ) {  document.forms1.h_uce.value = 1; }
    }

//funkcia na reset nastavenie Uce 
    function resetStav()
    {
    document.forms1.h_uce.value = 1;
    }

//posuny Enter[[[[[[[[[[[



function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){
        if( document.forms.forms1.h_ico.value != ''  )
        {
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.value = '';
        volajSaldo();
        }      

        if( document.forms1.h_ico.value == "" ) {  document.forms1.h_nai.focus(); }

              }
                }


function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kód stlaèenej klávesy

  if(k == 13 ){
        if(document.forms.forms1.h_nai.value != '' )
        {
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms1.h_ico.value = ""; 
        volajSaldo();
        }   

        if( document.forms1.h_nai.value == "" ) { document.forms1.h_ico.focus(); }

              }
                }

//co urobi po potvrdeni ok z tabulky Saldo
function vykonajSaldo(ico,nai,mes,prm1,prm2,prm3,prm4)
                {
        document.forms.forms1.h_ico.value = ico;
        document.forms.forms1.h_nai.value = nai;
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        urobSaldo(<?php echo $drupoh; ?>);
        mySaldoelement.style.display='';
                }


function Len1Saldo()
                    {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        urobSaldo(<?php echo $drupoh; ?>);
        mySaldoelement.style.display='';
                    }

function Len0Saldo()
                    {
        New.style.display="";
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
                    }


function VyberVstup()
                {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select(); 
                }





  </script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<?php
if( $drupoh == 1 )
{
?>
<td>EuroSecom  -  Karty dlhodobého majetku
<?php
}
?>
<?php
if( $drupoh == 2 )
{
?>
<td>EuroSecom  -  Karty drobného majetku
<?php
}
?>
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formuláry po zadaní hodnoty položky a stlaèení Enter program prejde na vstup ïalšej položky">

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if( $copern == 1 )
          {
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="20%">Kanc/Osè
<td class="hmenu" width="10%"><div id="cislo">Kancelária/Os.èíslo</div>
<td class="hmenu" width="30%"><div id="nazov">Názov/Priezvisko</div>
<td class="hmenu" width="40%" align="right">
<a href="#" onClick="window.open('../majetok/majkar.php?copern=10&drupoh=<?php echo $drupoh; ?>&page=1&kanc=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi všetky karty za Kancelárie vo formáte PDF' ></a>
<a href="#" onClick="window.open('../majetok/majkar.php?copern=10&drupoh=<?php echo $drupoh; ?>&page=1&kanc=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Vytlaèi všetky karty za Zamestnancov vo formáte PDF' ></a>
</td>
</tr>
<FORM name="forms1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu">
<input type="checkbox" name="h_uce" id="h_uce" value="1" checked="checked" onclick="nastavUce();" />

<td class="hmenu"><input type="text" name="h_ico" id="h_ico" size="10" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; "
 onKeyDown="return IcoEnter(event.which)"/>

<td class="hmenu"><input type="text" name="h_nai" id="h_nai" size="50" value="<?php echo $h_nai;?>" 
onclick="mySaldoelement.style.display='none'; New.style.display='none'; "
 onKeyDown="return NaiEnter(event.which)" /> 

<img src='../obr/hladaj.png' border="1" onclick="mySaldoelement.style.display='none'; New.style.display='none'; volajSaldo();" title="H¾adaj zadané èíslo alebo názov" >

<td class="obyc" align="right">
<INPUT type="reset" 
 onclick="mySaldoelement.style.display='none'; New.style.display='none'; document.forms.forms1.h_nai.focus(); resetStav();"
 id="resetp" name="resetp" value="Nové h¾adanie" ></td>

</FORM>
</table>

<div id="mySaldoelement"></div>
<div id="Okno"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenašiel som osobné èíslo ani kanceláriu pod¾a zadaných podmienok, skúste znovu</span>

<?php
          }
//koniec copern=1
?>

<?php
//tlac vsetkych kariet v PDF
if( $copern == 10 OR $copern == 11 OR $copern == 12 )
          {

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcmajkars'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcmajkarsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcmajkars
(
   drm          INT,
   inv          INT,
   str          INT,
   zak          INT,
   dob          DATE,
   cen          DECIMAL(10,2),
   mno          DECIMAL(10,2),
   hod          DECIMAL(10,2),
   naz          VARCHAR(80),
   kank         INT,
   ok           INT,
   pox          INT,
   poy          INT
);
prcmajkars;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcmajkars'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcmajkarsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcmajkarsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$podm="inv > 0";
if( $copern == 11 ) $podm="kanc = ".$cislo_kanc;
if( $copern == 12 ) $podm="oc = ".$cislo_oc;

if( $drupoh == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcmajkars$kli_uzid"." SELECT".
" drm,inv,str,zak,dob,cen,mno,(cen*mno),naz,kanc,oc,0,0".
" FROM F$kli_vxcf"."_majmaj".
" WHERE $podm";
$dsql = mysql_query("$dsqlt");
}

if( $drupoh == 2 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcmajkars$kli_uzid"." SELECT".
" drm,inv,str,zak,dob,cen,mno,(cen*mno),naz,kanc,oc,0,0".
" FROM F$kli_vxcf"."_majdim".
" WHERE $podm";
$dsql = mysql_query("$dsqlt");
}

//vymaz ostatnych ak je vybrany zamestnanec v personal_analyzy
if( $vybzam == 1 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prcmajkars$kli_uzid WHERE ok != $cislo_oc ";
$dsql = mysql_query("$dsqlt");
}

if( $kanc == 1 )
{
//sumar za kancelarie
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcmajkars$kli_uzid "." SELECT".
" drm,inv,str,zak,dob,0,SUM(mno),SUM(hod),naz,kank,ok,9,0".
" FROM F$kli_vxcf"."_prcmajkars$kli_uzid".
" WHERE inv > 0".
" GROUP BY kank".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
if( $kanc == 0 )
{
//sumar za zamestnanca
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcmajkars$kli_uzid "." SELECT".
" drm,inv,str,zak,dob,0,SUM(mno),SUM(hod),naz,kank,ok,9,0".
" FROM F$kli_vxcf"."_prcmajkars$kli_uzid".
" WHERE inv > 0".
" GROUP BY ok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcmajkars$kli_uzid "." SELECT".
" drm,inv,str,zak,dob,0,SUM(mno),SUM(hod),naz,kank,ok,99,1".
" FROM F$kli_vxcf"."_prcmajkars$kli_uzid".
" WHERE pox = 0".
" GROUP BY pox".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if (File_Exists ("../tmp/majkar.$kli_uzid.pdf")) { $soubor = unlink("../tmp/majkar.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$tri="inv";
if( $copern == 11 OR $copern == 12 ) $tri="naz";

if( $kanc == 1 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcmajkars$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_kancelarie".
" ON F$kli_vxcf"."_prcmajkars$kli_uzid.kank=F$kli_vxcf"."_kancelarie.kanc".
" WHERE inv > 0 ".
" ORDER BY poy,kank,pox,$tri";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}
if( $kanc == 0 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcmajkars$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_prcmajkars$kli_uzid.ok=F$kli_vxcf"."_mzdkun.oc".
" WHERE inv > 0 ".
" ORDER BY poy,ok,pox,$tri";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {

if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $kanc == 1 )
{
$pdf->Cell(110,5,"Inventúra majetku pod¾a kancelárie za $kli_vume","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}
if( $kanc == 0 )
{
$pdf->Cell(110,5,"Inventúra majetku pod¾a zamestnancov za $kli_vume","LTB",0,"L");
$pdf->Cell(167,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}

$pdf->Cell(20,5,"Inv.èíslo","1",0,"R");$pdf->Cell(10,5,"Druh","1",0,"R");$pdf->Cell(10,5,"STR","1",0,"R");$pdf->Cell(20,5,"ZÁK","1",0,"R");
$pdf->Cell(20,5,"Kancelária","1",0,"R");$pdf->Cell(20,5,"Os.èíslo","1",0,"R");$pdf->Cell(20,5,"Prijaté","1",0,"L");
$pdf->Cell(20,5,"Obst.cena","1",0,"R");$pdf->Cell(25,5,"Množstvo","1",0,"R");$pdf->Cell(25,5,"Hodnota","1",0,"R");
$pdf->Cell(87,5,"Popis","1",1,"L");

      }

  if (@$zaznam=mysql_data_seek($sql,$i))
 {
$polozka=mysql_fetch_object($sql);



if( $polozka->pox == 0 )
{
$pdf->Cell(20,5,"$polozka->inv","0",0,"R");$pdf->Cell(10,5,"$polozka->drm","0",0,"R");$pdf->Cell(10,5,"$polozka->str","0",0,"R");$pdf->Cell(20,5,"$polozka->zak","0",0,"R");
$pdf->Cell(20,5,"$polozka->kank","0",0,"R");$pdf->Cell(20,5,"$polozka->ok","0",0,"R");$pdf->Cell(20,5,"$polozka->dob","0",0,"L");
$pdf->Cell(20,5,"$polozka->cen","0",0,"R");$pdf->Cell(25,5,"$polozka->mno","0",0,"R");$pdf->Cell(25,5,"$polozka->hod","0",0,"R");
$pdf->Cell(87,5,"$polozka->naz","0",1,"L");
if( $j > 30 ) { $j=-1; $strana=$strana+1; }
}

if( $polozka->pox == 9 )
{
if( $kanc == 1 )
  {
$pdf->Cell(140,5,"Celkom kancelária $polozka->kanc $polozka->nkan","T",0,"R");
$pdf->Cell(25,5,"$polozka->mno","T",0,"R");$pdf->Cell(25,5,"$polozka->hod","T",1,"R");
  }
if( $kanc == 0 )
  {
$pdf->Cell(140,5,"Celkom zamestnanec $polozka->ok $polozka->titl $polozka->prie $polozka->meno","T",0,"R");
$pdf->Cell(25,5,"$polozka->mno","T",0,"R");$pdf->Cell(25,5,"$polozka->hod","T",1,"R");
  }

$j=-1;
if( $copern == 11 OR $copern == 12 ) $j=0;
$strana=$strana+1;
}

if( $polozka->pox == 99 AND $copern == 10 )
{
$pdf->Cell(20,5," ","T",1,"R");
$pdf->Cell(140,5,"Celkom všetky položky","T",0,"R");
$pdf->Cell(25,5,"$polozka->mno","T",0,"R");$pdf->Cell(25,5,"$polozka->hod","T",1,"R");

$j=0;
$strana=$strana+1;
}

 }

$i = $i + 1;
$j = $j + 1;
  }


$pdf->Output("../tmp/majkar.$kli_uzid.pdf");
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/majkar.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php

//koniec tlac vsetkych kariet v PDF
          }
?>

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
