<HTML>
<?php
$sys = 'ALL';
$urov = 14000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$lenuct = 1*$_REQUEST['lenuct'];
$lenmzd = 1*$_REQUEST['lenmzd'];
$lenenpo = 1*$_REQUEST['lenenpo'];

if( $lenuct == 0 AND $lenmzd == 0 AND $lenenpo == 0 ) { $lenuct=1; $lenmzd=1; $vsetkysys=1; }

//inicializuj celu firmu
if( $copern == 4545 AND $kli_uzall > 90000 )
  {
//echo "idem";
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok){ $vtvall = include("../cis/vtvall.php"); }

if( $lenuct == 1 )
  {
$sql = "SELECT * FROM F$kli_vxcf"."_vtvfak";
$vysledok = mysql_query($sql);
if (!$vysledok){ $vtvall = include("../faktury/vtvfak.php"); }
$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok){ $vtvall = include("../ucto/vtvuct.php"); }
$sql = "SELECT * FROM F$kli_vxcf"."_vtvskl";
$vysledok = mysql_query($sql);
if (!$vysledok){ $vtvall = include("../sklad/vtvskl.php"); }
  }

if( $lenmzd == 1 )
  {
$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query($sql);
if (!$vysledok){ $vtvall = include("../mzdy/vtvmzd.php"); }
  }

if( $lenenpo == 1 )
  {
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok){ $vtvall = include("../cis/vtvall.php"); }

$sqlt = <<<vtvuct
(
   xcf         INT,
   id          INT,
   zmen        INT,
   datm        TIMESTAMP(14)
);
vtvuct;

$sql = "CREATE TABLE F".$kli_vxcf."_uctvsdh".$sqlt;
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_vtvuct".$sqlt;
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_vtvfak".$sqlt;
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_vtvskl".$sqlt;
$vysledek = mysql_query("$sql");

  }
//koniec enpo


if( $vsetkysys == 1 )
  {
$sql = "SELECT * FROM F$kli_vxcf"."_vtvmaj";
$vysledok = mysql_query($sql);
if (!$vysledok){ $vtvall = include("../majetok/vtvmaj.php"); }
  }
?>
<script type="text/javascript">             
window.open('../cis/ufir.php?copern=1', '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
</script>
<?php
exit;
  }

//koniec inicializuj celu firmu
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Z·lohovanie</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

function ZalohujCis()
                {
window.open('zaldat_ucto.php?copern=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZalohujSkl()
                {
window.open('zaldat_skl.php?copern=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZalohujLen(coako)
                {

  var copernx = coako;
  var zaldod = 0;
  if( document.formzal1.zalpri.checked ) zaldod=1;

window.open('zaldat_skl.php?zaldod=' + zaldod + '&copern='+ copernx + '&xxx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }


function Inicializuj()
                {
window.open('zaldat_skl.php?copern=4545', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function InicializujMzd()
                {
window.open('zaldat_skl.php?copern=4545&lenmzd=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function InicializujUct()
                {
window.open('zaldat_skl.php?copern=4545&lenuct=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function kopiruj144()
                {
window.open('../androidfanti/nacitaj_f144.php', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function InicializujEnpo()
                {
window.open('zaldat_skl.php?copern=4545&lenenpo=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }
   
</script>
</HEAD>
<BODY class="white" >

<?php 




?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Z·lohovanie Skladov FIR<?php echo $kli_vxcf;?> - <?php echo $kli_nxcf;?></td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 
if ( $copern == 101 )
//MEnu
     {
?>
<table class="vstup" width="100%" >
<FORM name="formzal1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujCis();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Z·lohovaù do TXT' ></a></td>
<td class="bmenu" width="98%">Z·lohovaù ËÌselnÌky 
</td>
</tr>
</table>



<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujSkl();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Z·lohovaù do TXT' ></a></td>
<td class="bmenu" width="98%">Z·lohovaù Sklady 
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(11);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Z·lohovaù do TXT' ></a></td>
<td class="bmenu" width="90%">Z·lohovaù PrÌjemky
<td class="bmenu" width="8%"><input type="checkbox" name="zalpri" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(12);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Z·lohovaù do TXT' ></a></td>
<td class="bmenu" width="90%">Z·lohovaù V˝dajky 
<td class="bmenu" width="8%"><input type="checkbox" name="zalvyd" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(13);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Z·lohovaù do TXT' ></a></td>
<td class="bmenu" width="90%">Z·lohovaù Presunky
<td class="bmenu" width="8%"><input type="checkbox" name="zalpre" value="1" />
</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(16);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Z·lohovaù do TXT' ></a></td>
<td class="bmenu" width="90%">Z·lohovaù ËÌselnÌky a nastavenia skladov
<td class="bmenu" width="8%"><input type="checkbox" name="zalscc" value="1" />
</td>
</tr>
</table>

<?php if( $kli_uzall > 90000 ) { ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InicializujUct();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Inicializovaù' ></a></td>
<td class="bmenu" width="90%">Inicializovaù firmu pre ˙ËtovnÌctvo
<td class="bmenu" width="8%"><input type="checkbox" name="zalscc" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InicializujMzd();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Inicializovaù' ></a></td>
<td class="bmenu" width="90%">Inicializovaù firmu pre mzdy a personalistiku
<td class="bmenu" width="8%"><input type="checkbox" name="zalscc" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="Inicializuj();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='Inicializovaù' ></a></td>
<td class="bmenu" width="90%">Inicializovaù firmu pre vöetky podsystÈmy
<td class="bmenu" width="8%"><input type="checkbox" name="zalscc" value="1" />
</td>
</tr>
</table>

<?php if( $_SERVER['SERVER_NAME'] == "www.eshoptest.sk" ) { ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="kopiruj144();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='»ÌselnÌky z firmy Ë.144' ></a></td>
<td class="bmenu" width="90%">J⁄ ËÌselnÌky z firmy Ë.144
<td class="bmenu" width="8%"><input type="checkbox" name="zalscc" value="1" />
</td>
</tr>
</table>
<?php                                                     } ?>


<?php if( $_SERVER['SERVER_NAME'] == "www.enposro.sk" OR $_SERVER['SERVER_NAME'] == "localhost" ) { ?>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="InicializujEnpo();">
<img src='../obr/naradie.png' width=20 height=15 border=0 title='»ÌselnÌky z firmy Ë.144' ></a></td>
<td class="bmenu" width="90%">Inicializovaù firmu pre ENPO v˝kazy
<td class="bmenu" width="8%"><input type="checkbox" name="zalscc" value="1" />
</td>
</tr>
</table>
<?php                                                     } ?>

<?php                          } ?>

</FORM>

<?php
// toto je koniec MEnu 
     }





if ( $copern >= 10 AND $copern <= 19 )
//zalohovanie 
     {

$nazovsuboru="../tmp/zaloha".$kli_vxcf."Skl.txt";

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

//POZOR cislovat tabulky od 501

//sklpri POZOR cislovat tabulky od 501
if( $copern == 11 OR $copern == 10 ) {

$text = "501;##########Tabulka F$kli_vxcf"."_sklpri"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;dat;dok;doq;skl;poh;ico;fak;unk;poz;str;zak;cis;mno;cen;id;sk2;datm;me2;mn2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklpri ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->unk.";".$riadok->poz.";".$riadok->str.";".$riadok->zak.";".$riadok->cis.";".$riadok->mno.";".$riadok->cen.";".$riadok->id.";".$riadok->sk2.";".$riadok->datm.";".$riadok->me2.";".$riadok->mn2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//sklvyd,sklfak
if( $copern == 12 OR $copern == 10 ) {

$text = "502;##########Tabulka F$kli_vxcf"."_sklvyd"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;dat;dok;doq;skl;poh;ico;fak;unk;poz;str;zak;cis;mno;cen;id;sk2;datm;me2;mn2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklvyd ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok-> cpl.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->unk.";".$riadok->poz.";".$riadok->str.";".$riadok->zak.";".$riadok->cis.";".$riadok->mno.";".$riadok->cen.";".$riadok->id.";".$riadok->sk2.";".$riadok->datm.";".$riadok->me2.";".$riadok->mn2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "503;##########Tabulka F$kli_vxcf"."_sklfak"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;dat;dok;doq;skl;poh;ico;fak;unk;dol;prf;poz;str;zak;cis;nat;dph;mer;pop;mno;cen;cep;ced;id;sk2;datm;me2;mn2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklfak ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->unk.";".$riadok->dol.";".$riadok->prf.";".$riadok->poz.";".$riadok->str.";".$riadok->zak.";".$riadok->cis.";".$riadok->nat.";".$riadok->dph.";".$riadok->mer.";".$riadok->pop.";".$riadok->mno.";".$riadok->cen.";".$riadok->cep.";".$riadok->ced.";".$riadok->id.";".$riadok->sk2.";".$riadok->datm.";".$riadok->me2.";".$riadok->mn2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//sklpre
if( $copern == 13 OR $copern == 10 ) {

$text = "504;##########Tabulka F$kli_vxcf"."_sklpre"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;dat;dok;doq;skl;poh;ico;fak;unk;poz;str;zak;cis;mno;cen;id;sk2;datm;me2;mn2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklpre ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->unk.";".$riadok->poz.";".$riadok->str.";".$riadok->zak.";".$riadok->cis.";".$riadok->mno.";".$riadok->cen.";".$riadok->id.";".$riadok->sk2.";".$riadok->datm.";".$riadok->me2.";".$riadok->mn2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//skl,sklcis,sklcisudaje,sklpoc,sklcph,sluzby,sklsluudaje,sklzas,sklzaspriemer,sklxskl
if( $copern == 14 OR $copern == 10 ) {

$text = "505;##########Tabulka F$kli_vxcf"."_skl"."\r\n";
  fwrite($soubor, $text);
  $text = "0;skl;nas;drs;ucs;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_skl ORDER BY skl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok-> skl.";".$riadok->nas.";".$riadok->drs.";".$riadok->ucs.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "506;##########Tabulka F$kli_vxcf"."_sklcis"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cis;nat;natBD;mer;dph;cep;ced;tl1;tl2;tl3;labh1;labh2;kat01h;kat02h;kat03h;kat04h;webtx1;webtx2;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcis ORDER BY cis");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cis.";".$riadok->nat.";".$riadok->natBD.";".$riadok->mer.";".$riadok->dph.";".$riadok->cep.";".$riadok->ced.";".$riadok->tl1.";".$riadok->tl2.";".$riadok->tl3.";".$riadok->labh1.";".$riadok->labh2.";".$riadok->kat01h.";".$riadok->kat02h.";".$riadok->kat03h.";".$riadok->kat04h.";".$riadok->webtx1.";".$riadok->webtx2.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "507;##########Tabulka F$kli_vxcf"."_sklcisudaje"."\r\n";
  fwrite($soubor, $text);
  $text = "0;xcis;xnat;xnat2;xnat3;xnat4;xnat5;xtxt;xtxt2;xtxt3;xtxt4;xtxt5;xmerx;xmer2;xmerk;xdr1;xdr2;xdr3;xdr4;xstz;xzkz;xkrd;xzvr;xrcp;xrcx"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcisudaje ORDER BY xcis");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->xcis.";".$riadok->xnat.";".$riadok->xnat2.";".$riadok->xnat3.";".$riadok->xnat4.";".$riadok->xnat5.";".$riadok->xtxt.";".$riadok->xtxt2.";".$riadok->xtxt3.";".$riadok->xtxt4.";".$riadok->xtxt5.";".$riadok->xmerx.";".$riadok->xmer2.";".$riadok->xmerk.";".$riadok->xdr1.";".$riadok->xdr2.";".$riadok->xdr3.";".$riadok->xdr4.";".$riadok->xstz.";".$riadok->xzkz.";".$riadok->xkrd.";".$riadok->xzvr.";".$riadok->xrcp.";".$riadok->xrcx;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "508;##########Tabulka F$kli_vxcf"."_sklpoc"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;dat;dok;doq;skl;poh;ico;fak;poz;str;zak;cis;mno;cen;id;sk2;datm;me2;mn2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklpoc ORDER BY skl,cis");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->poz.";".$riadok->str.";".$riadok->zak.";".$riadok->cis.";".$riadok->mno.";".$riadok->cen.";".$riadok->id.";".$riadok->sk2.";".$riadok->datm.";".$riadok->me2.";".$riadok->mn2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "509;##########Tabulka F$kli_vxcf"."_sklcph"."\r\n";
  fwrite($soubor, $text);
  $text = "0;poh;nph;drp;ucm;ucd;pph;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklcph ORDER BY poh");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->poh.";".$riadok->nph.";".$riadok->drp.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->pph.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "510;##########Tabulka F$kli_vxcf"."_sluzby"."\r\n";
  fwrite($soubor, $text);
  $text = "0;slu;nsl;nslp;nslz;mer;dph;cep;ced;tl1;tl2;tl3;labh1;labh2;kat01h;kat02h;kat03h;kat04h;webtx1;webtx2;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sluzby ORDER BY slu");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->slu.";".$riadok->nsl.";".$riadok->nslp.";".$riadok->nslz.";".$riadok->mer.";".$riadok->dph.";".$riadok->cep.";".$riadok->ced.";".$riadok->tl1.";".$riadok->tl2.";".$riadok->tl3.";".$riadok->labh1.";".$riadok->labh2.";".$riadok->kat01h.";".$riadok->kat02h.";".$riadok->kat03h.";".$riadok->kat04h.";".$riadok->webtx1.";".$riadok->webtx2.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "511;##########Tabulka F$kli_vxcf"."_sklsluudaje"."\r\n";
  fwrite($soubor, $text);
  $text = "0;xcis;xnat;xnat2;xnat3;xnat4;xnat5;xtxt;xtxt2;xtxt3;xtxt4;xtxt5;xmerx;xmer2;xmerk;xdr1;xdr2;xdr3;xdr4;xuce1;xuce2;xuce3;xuce4;xuce5;xuce6"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklsluudaje ORDER BY xcis");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->xcis.";".$riadok->xnat.";".$riadok->xnat2.";".$riadok->xnat3.";".$riadok->xnat4.";".$riadok->xnat5.";".$riadok->xtxt.";".$riadok->xtxt2.";".$riadok->xtxt3.";".$riadok->xtxt4.";".$riadok->xtxt5.";".$riadok->xmerx.";".$riadok->xmer2.";".$riadok->xmerk.";".$riadok->xdr1.";".$riadok->xdr2.";".$riadok->xdr3.";".$riadok->xdr4.";".$riadok->xuce1.";".$riadok->xuce2.";".$riadok->xuce3.";".$riadok->xuce4.";".$riadok->xuce5.";".$riadok->xuce6;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "512;##########Tabulka F$kli_vxcf"."_sklzas"."\r\n";
  fwrite($soubor, $text);
  $text = "0;skl;cis;cen;zas;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklzas ORDER BY skl,cis");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->skl.";".$riadok->cis.";".$riadok->cen.";".$riadok->zas.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "513;##########Tabulka F$kli_vxcf"."_sklzaspriemer"."\r\n";
  fwrite($soubor, $text);
  $text = "0;prx;skl;cis;cen;zas;hop"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklzaspriemer ORDER BY skl,cis");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->prx.";".$riadok->skl.";".$riadok->cis.";".$riadok->cen.";".$riadok->zas.";".$riadok->hop;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "514;##########Tabulka F$kli_vxcf"."_sklxskl"."\r\n";
  fwrite($soubor, $text);
  $text = "0;sklx;xsklp;xsklv;xcpri;xvpri;xcvyd;xvvyd;xcpre;xvpre;xucto;xzost;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklxskl ORDER BY sklx");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->sklx.";".$riadok->xsklp.";".$riadok->xsklv.";".$riadok->xcpri.";".$riadok->xvpri.";".$riadok->xcvyd.";".$riadok->xvvyd.";".$riadok->xcpre.";".$riadok->xvpre.";".$riadok->xucto.";".$riadok->xzost.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

fclose($soubor);

?>

<a href="<?php echo $nazovsuboru; ?>"><?php echo $nazovsuboru; ?></a>


<?php

// toto je koniec zalohovania 
     }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
