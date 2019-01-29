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


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zálohovanie</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

function ZalohujCis()
                {

  var zaldod = 0;
  if( document.formzal1.zaldod.checked ) zaldod=1;

window.open('zaldat_ucto.php?zaldod=' + zaldod + '&copern=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZalohujUct()
                {

  var zaldod = 0;
  if( document.formzal1.zaldod.checked ) zaldod=1;

window.open('zaldat_ucto.php?zaldod=' + zaldod + '&copern=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZalohujLen(coako)
                {

  var copernx = coako;
  var zaldod = 0;
  if( document.formzal1.zaldod.checked ) zaldod=1;

window.open('zaldat_ucto.php?zaldod=' + zaldod + '&copern='+ copernx + '&xxx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }
    
</script>
</HEAD>
<BODY class="white" >

<?php 

// cislo operacie
$copern = 1*$_REQUEST['copern'];


?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Zálohovanie Účtovníctva</td>
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
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="98%">Zálohovať číselníky 
</td>
</tr>
</table>



<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujUct();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="98%">Zálohovať účtovníctvo 
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(11);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Dodávateľské faktúry 
<td class="bmenu" width="8%"><input type="checkbox" name="zaldod" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(12);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Odberateľské faktúry 
<td class="bmenu" width="8%"><input type="checkbox" name="zalodb" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(13);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Pokladničné doklady 
<td class="bmenu" width="8%"><input type="checkbox" name="zalpok" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(14);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Bankové výpisy 
<td class="bmenu" width="8%"><input type="checkbox" name="zalban" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(15);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Všeobecné účtovné doklady 
<td class="bmenu" width="8%"><input type="checkbox" name="zalvse" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(16);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať číselníky a nastavenia účtovníctva
<td class="bmenu" width="8%"><input type="checkbox" name="zalucc" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(17);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať účtovanie podsystémov
<td class="bmenu" width="8%"><input type="checkbox" name="zalpds" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(28);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať účtovnú osnovu
<td class="bmenu" width="8%"><input type="checkbox" name="zaluos" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(19);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať počiatočný stav saldokonta a cudzej meny
<td class="bmenu" width="8%"><input type="checkbox" name="zalpsl" value="1" />
</td>
</tr>
</table>

</FORM>

<?php
// toto je koniec MEnu 
     }



if ( $copern == 1 )
//zalohovanie ciselniky
     {

$nazovsuboru="../tmp/zaloha".$kli_vxcf."Cis.txt";

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");


  $text = "101;##########Tabulka F$kli_vxcf"."_ico"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ico;dic;icd;nai;na2;uli;psc;mes;tel;fax;em1;em2;em3;www;uc1;nm1;ib1;uc2;nm2;ib2;uc3;nm3;ib3;dns;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico ORDER BY ico");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";
  
  $text = $text.";".$riadok->ico.";".$riadok->dic.";".$riadok->icd.";".$riadok->nai.";".$riadok->na2.";".$riadok->uli.";".$riadok->psc;
  $text = $text.";".$riadok->mes.";".$riadok->tel.";".$riadok->fax.";".$riadok->em1.";".$riadok->em2.";".$riadok->em3.";".$riadok->www;
  $text = $text.";".$riadok->uc1.";".$riadok->nm1.";".$riadok->ib1.";".$riadok->uc2.";".$riadok->nm2.";".$riadok->ib2.";".$riadok->uc3;
  $text = $text.";".$riadok->nm3.";".$riadok->ib3.";".$riadok->dns.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


  $text = "102;##########Tabulka F$kli_vxcf"."_str"."\r\n";
  fwrite($soubor, $text);
  $text = "0;str;nst;dst;ust;datm "."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_str ORDER BY str");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->str.";".$riadok->nst.";".$riadok->dst.";".$riadok->ust.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


  $text = "103;##########Tabulka F$kli_vxcf"."_zak"."\r\n";
  fwrite($soubor, $text);
  $text = "0;str;zak;nza;sku;stv;dzk;uzk;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_zak ORDER BY str,zak");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->str.";".$riadok->zak.";".$riadok->nza.";".$riadok->sku.";".$riadok->stv.";".$riadok->dzk.";".$riadok->uzk.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


  $text = "104;##########Tabulka F$kli_vxcf"."_sku"."\r\n";
  fwrite($soubor, $text);
  $text = "0;sku;nsu;dsu;usu;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sku ORDER BY sku");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->sku.";".$riadok->nsu.";".$riadok->dsu.";".$riadok->usu.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


  $text = "105;##########Tabulka F$kli_vxcf"."_stv"."\r\n";
  fwrite($soubor, $text);
  $text = "0;stv;nsv;dsv;usv;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_stv ORDER BY stv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->stv.";".$riadok->nsv.";".$riadok->dsv.";".$riadok->usv.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "109;##########Tabulka F$kli_vxcf"."_ufir"."\r\n";
  fwrite($soubor, $text);

  $text = "0;udaje;fico;fdic;ficd;fnaz;fuli;fcdm;fmes;fpsc;ftel;ffax;fwww;fem1;fem2;fem3;fem4;fuc1;fnm1;fnb1;fsb1;fib1;fsw1;fuc2;fnm2;fnb2;fsb2;";
  $text = $text."fib2;fsw2;fuc3;fnm3;fnb3;fsb3;fib3;fsw3;fuc4;fnm4;fnb4;fsb4;fib4;fuc5;fnm5;fnb5;fsb5;fib5;fuc6;fnm6;fnb6;fsb6;fib6;dph1;dph2;dph3;dph4;dopzak;";
  $text = $text."dopstr;dopobj;dopreg;dopstz;dopvnp;dopdol;dopfak;xdp01;xdp02;xdp03;xdp04;xdp05;xdp06;pokvyd;pokpri;xfa01;xfa02;xfa03;xfa04;xfa05;xfa06;xfa07;";
  $text = $text."xfa08;xsk01;xsk02;xsk03;xsk04;fakzak;fakstr;fakprf;fakvnp;fakdol;fakobj;fakodb;fakdod;sklcis;sklcvd;sklcps;sklcpr;sklzak;sklstr;obreg;kurz12;";
  $text = $text."mena2;mena1;mzdt01;mzdt02;mzdt03;mzdt04;mzdt05;mzdx01;mzdx02;mzdx03;mzdx04;mzdx05;mzdx06;mzdx07;mzdx08;mzdx09;uc1fk;uc2fk;uc3fk;uctt01;uctt02";
  $text = $text."uctt03;uctt04;uctt05;uctx01;uctx02;uctx03;uctx04;uctx05;uctx06;uctx07;uctx08;uctx09;uctx10;uctx15;xvr05;xvr04;xvr03;xvr02;xvr01;xsk05;xsk06;";
  $text = $text."xsk07;xsk08;xsk09;allx15;allx14;allx13;allx12;allx11;uctx14;uctx13;uctx12;uctx11;majx01;majx02;majx03;majx04;majx05;datm"."\r\n";

  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_ufir ");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->udaje.";".$riadok->fico.";".$riadok->fdic.";".$riadok->ficd.";".$riadok->fnaz.";".$riadok->fuli;
  $text = $text.";".$riadok->fcdm.";".$riadok->fmes.";".$riadok->fpsc.";".$riadok->ftel.";".$riadok->ffax.";".$riadok->fwww.";".$riadok->fem1;
  $text = $text.";".$riadok->fem2.";".$riadok->fem3.";".$riadok->fem4.";".$riadok->fuc1.";".$riadok->fnm1.";".$riadok->fnb1.";".$riadok->fsb1;
  $text = $text.";".$riadok->fib1.";".$riadok->fsw1.";".$riadok->fuc2.";".$riadok->fnm2.";".$riadok->fnb2.";".$riadok->fsb2.";".$riadok->fib2;
  $text = $text.";".$riadok->fsw2.";".$riadok->fuc3.";".$riadok->fnm3.";".$riadok->fnb3.";".$riadok->fsb3.";".$riadok->fib3.";".$riadok->fsw3;
  $text = $text.";".$riadok->fuc4.";".$riadok->fnm4.";".$riadok->fnb4.";".$riadok->fsb4.";".$riadok->fib4.";".$riadok->fuc5.";".$riadok->fnm5;
  $text = $text.";".$riadok->fnb5.";".$riadok->fsb5.";".$riadok->fib5.";".$riadok->fuc6.";".$riadok->fnm6.";".$riadok->fnb6.";".$riadok->fsb6;
  $text = $text.";".$riadok->fib6.";".$riadok->dph1.";".$riadok->dph2.";".$riadok->dph3.";".$riadok->dph4.";".$riadok->dopzak;
  $text = $text.";".$riadok->dopstr.";".$riadok->dopobj.";".$riadok->dopreg.";".$riadok->dopstz.";".$riadok->dopvnp.";".$riadok->dopdol;
  $text = $text.";".$riadok->dopfak.";".$riadok->xdp01.";".$riadok->xdp02.";".$riadok->xdp03.";".$riadok->xdp04.";".$riadok->xdp05;
  $text = $text.";".$riadok->xdp06.";".$riadok->pokvyd.";".$riadok->pokpri.";".$riadok->xfa01.";".$riadok->xfa02.";".$riadok->xfa03;
  $text = $text.";".$riadok->xfa04.";".$riadok->xfa05.";".$riadok->xfa06.";".$riadok->xfa07.";".$riadok->xfa08.";".$riadok->xsk01;
  $text = $text.";".$riadok->xsk02.";".$riadok->xsk03.";".$riadok->xsk04.";".$riadok->fakzak.";".$riadok->fakstr.";".$riadok->fakprf;
  $text = $text.";".$riadok->fakvnp.";".$riadok->fakdol.";".$riadok->fakobj.";".$riadok->fakodb.";".$riadok->fakdod.";".$riadok->sklcis;
  $text = $text.";".$riadok->sklcvd.";".$riadok->sklcps.";".$riadok->sklcpr.";".$riadok->sklzak.";".$riadok->sklstr.";".$riadok->obreg;
  $text = $text.";".$riadok->kurz12.";".$riadok->mena2.";".$riadok->mena1.";".$riadok->mzdt01.";".$riadok->mzdt02.";".$riadok->mzdt03;
  $text = $text.";".$riadok->mzdt04.";".$riadok->mzdt05.";".$riadok->mzdx01.";".$riadok->mzdx02.";".$riadok->mzdx03.";".$riadok->mzdx04;
  $text = $text.";".$riadok->mzdx05.";".$riadok->mzdx06.";".$riadok->mzdx07.";".$riadok->mzdx08.";".$riadok->mzdx09.";".$riadok->uc1fk;
  $text = $text.";".$riadok->uc2fk.";".$riadok->uc3fk.";".$riadok->uctt01.";".$riadok->uctt02.";".$riadok->uctt03.";".$riadok->uctt04;
  $text = $text.";".$riadok->uctt05.";".$riadok->uctx01.";".$riadok->uctx02.";".$riadok->uctx03.";".$riadok->uctx04.";".$riadok->uctx05;
  $text = $text.";".$riadok->uctx06.";".$riadok->uctx07.";".$riadok->uctx08.";".$riadok->uctx09.";".$riadok->uctx10.";".$riadok->uctx15;
  $text = $text.";".$riadok->xvr05.";".$riadok->xvr04.";".$riadok->xvr03.";".$riadok->xvr02.";".$riadok->xvr01.";".$riadok->xsk05;
  $text = $text.";".$riadok->xsk06.";".$riadok->xsk07.";".$riadok->xsk08.";".$riadok->xsk09.";".$riadok->allx15.";".$riadok->allx14;
  $text = $text.";".$riadok->allx13.";".$riadok->allx12.";".$riadok->allx11.";".$riadok->uctx14.";".$riadok->uctx13.";".$riadok->uctx12;
  $text = $text.";".$riadok->uctx11.";".$riadok->majx01.";".$riadok->majx02.";".$riadok->majx03.";".$riadok->majx04.";".$riadok->majx05.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


fclose($soubor);

?>

<a href="<?php echo $nazovsuboru; ?>"><?php echo $nazovsuboru; ?></a>


<?php

// toto je koniec zalohovania ciselniky 
     }

if ( $copern >= 10 AND $copern <= 28 )
//zalohovanie uctovnictvo
     {

$nazovsuboru="../tmp/zaloha".$kli_vxcf."Ucto.txt";

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

if( $copern == 11 OR $copern == 10 ) {

  $text = "201;##########Tabulka F$kli_vxcf"."_fakdod"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dav;das;daz;dok;doq;skl;poh;ico;fak;dol;prf;obj;unk;dpr;ksy;ssy;poz;str;zak;txz;txp;zk0;zk1;zk2;zk3;zk4;dn1;dn2;dn3;dn4;sp1;sp2;sz1;sz2;sz3;sz4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;odbm;zal;zao;ruc;uhr;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdod ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dav.";".$riadok->das.";".$riadok->daz.";".$riadok->dok;
  $text = $text.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->dol.";".$riadok->prf;
  $text = $text.";".$riadok->obj.";".$riadok->unk.";".$riadok->dpr.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->poz.";".$riadok->str;
  $text = $text.";".$riadok->zak.";".urlencode($riadok->txz).";".urlencode($riadok->txp).";".$riadok->zk0.";".$riadok->zk1.";".$riadok->zk2.";".$riadok->zk3;
  $text = $text.";".$riadok->zk4.";".$riadok->dn1.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1.";".$riadok->sp2;
  $text = $text.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->zk0u.";".$riadok->zk1u.";".$riadok->zk2u;
  $text = $text.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u.";".$riadok->sp1u.";".$riadok->sp2u.";".$riadok->hodu.";".$riadok->hod;
  $text = $text.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->odbm.";".$riadok->zal.";".$riadok->zao;
  $text = $text.";".$riadok->ruc.";".$riadok->uhr.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "202;##########Tabulka F$kli_vxcf"."_uctdod"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdod ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp;
  $text = $text.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak;
  $text = $text.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
                                     }

if( $copern == 12 OR $copern == 10 ) {

  $text = "203;##########Tabulka F$kli_vxcf"."_fakodb"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dav;das;daz;dok;doq;skl;poh;ico;fak;dol;prf;obj;unk;dpr;ksy;ssy;poz;str;zak;txz;txp;zk0;zk1;zk2;zk3;zk4;dn1;dn2;dn3;dn4;sp1;sp2;sz1;sz2;sz3;sz4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;odbm;zal;zao;ruc;uhr;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodb ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dav.";".$riadok->das.";".$riadok->daz.";".$riadok->dok;
  $text = $text.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->dol.";".$riadok->prf;
  $text = $text.";".$riadok->obj.";".$riadok->unk.";".$riadok->dpr.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->poz.";".$riadok->str;
  $text = $text.";".$riadok->zak.";".urlencode($riadok->txz).";".urlencode($riadok->txp).";".$riadok->zk0.";".$riadok->zk1.";".$riadok->zk2.";".$riadok->zk3;
  $text = $text.";".$riadok->zk4.";".$riadok->dn1.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1.";".$riadok->sp2;
  $text = $text.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->zk0u.";".$riadok->zk1u.";".$riadok->zk2u;
  $text = $text.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u.";".$riadok->sp1u.";".$riadok->sp2u.";".$riadok->hodu.";".$riadok->hod;
  $text = $text.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->odbm.";".$riadok->zal.";".$riadok->zao;
  $text = $text.";".$riadok->ruc.";".$riadok->uhr.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "204;##########Tabulka F$kli_vxcf"."_uctodb"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctodb ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp;
  $text = $text.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak;
  $text = $text.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "205;##########Tabulka F$kli_vxcf"."_fakslu"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;fak;dol;prf;cpl;slu;nsl;pop;pon;dph;cen;cep;ced;mno;mer;pfak;cfak;dfak;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakslu ORDER BY dok,slu");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->fak.";".$riadok->dol.";".$riadok->prf.";".$riadok->cpl.";".$riadok->slu.";".$riadok->nsl;
  $text = $text.";".$riadok->pop.";".$riadok->pon.";".$riadok->dph.";".$riadok->cen.";".$riadok->cep.";".$riadok->ced.";".$riadok->mno.";".$riadok->mer;
  $text = $text.";".$riadok->pfak.";".$riadok->cfak.";".$riadok->dfak.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "206;##########Tabulka F$kli_vxcf"."_sklfak"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;dat;dok;doq;skl;poh;ico;fak;unk;dol;prf;poz;str;zak;cis;nat;dph;mer;pop;mno;cen;cep;ced;id;sk2;datm;me2;mn2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklfak ORDER BY dok,cis");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh;
  $text = $text.";".$riadok->ico.";".$riadok->fak.";".$riadok->unk.";".$riadok->dol.";".$riadok->prf.";".$riadok->poz.";".$riadok->str.";".$riadok->zak;
  $text = $text.";".$riadok->cis.";".$riadok->nat.";".$riadok->dph.";".$riadok->mer.";".$riadok->pop.";".$riadok->mno.";".$riadok->cen.";".$riadok->cep;
  $text = $text.";".$riadok->ced.";".$riadok->id.";".$riadok->sk2.";".$riadok->datm.";".$riadok->me2.";".$riadok->mn2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }
                                     }

//1=pokpri,2=pokvyd,3=uctpokuct,4=uctpok
if( $copern == 13 OR $copern == 10 ) {

  $text = "207;##########Tabulka F$kli_vxcf"."_pokpri"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dok;doq;txp;txz;ico;kto;unk;poz;zk0;zk1;zk2;zk3;zk4;sz1;sz2;sz3;sz4;dn1;dn2;dn3;dn4;sp1;sp2;sp3;sp4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_pokpri ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".urlencode($riadok->txp).";".$riadok->txz;
  $text = $text.";".$riadok->ico.";".$riadok->kto.";".$riadok->unk.";".$riadok->poz.";".$riadok->zk0.";".$riadok->zk1.";".$riadok->zk2;
  $text = $text.";".$riadok->zk3.";".$riadok->zk4.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->dn1;
  $text = $text.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1.";".$riadok->sp2.";".$riadok->sp3.";".$riadok->sp4;
  $text = $text.";".$riadok->zk0u.";".$riadok->zk1u.";".$riadok->zk2u.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u.";".$riadok->sp1u;
  $text = $text.";".$riadok->sp2u.";".$riadok->hodu.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen;
  $text = $text.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


 $text = "208;##########Tabulka F$kli_vxcf"."_pokvyd"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dok;doq;txp;txz;ico;kto;unk;poz;zk0;zk1;zk2;zk3;zk4;sz1;sz2;sz3;sz4;dn1;dn2;dn3;dn4;sp1;sp2;sp3;sp4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_pokvyd ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".urlencode($riadok->txp).";".$riadok->txz;
  $text = $text.";".$riadok->ico.";".$riadok->kto.";".$riadok->unk.";".$riadok->poz.";".$riadok->zk0.";".$riadok->zk1.";".$riadok->zk2;
  $text = $text.";".$riadok->zk3.";".$riadok->zk4.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->dn1;
  $text = $text.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1.";".$riadok->sp2.";".$riadok->sp3.";".$riadok->sp4;
  $text = $text.";".$riadok->zk0u.";".$riadok->zk1u.";".$riadok->zk2u.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u.";".$riadok->sp1u;
  $text = $text.";".$riadok->sp2u.";".$riadok->hodu.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen;
  $text = $text.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "209;##########Tabulka F$kli_vxcf"."_uctpokuct"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;poh;cpl;ucm;ucd;rdp;dph;hod;hodm;kurz;mena;zmen;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpokuct ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "210;##########Tabulka F$kli_vxcf"."_uctpok"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;poh;cpl;ucm;ucd;rdp;dph;hod;hodm;kurz;mena;zmen;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpok ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id;datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                                     }

//1=banvyp,2=uctban
if( $copern == 14 OR $copern == 10 ) {



  $text = "211;##########Tabulka F$kli_vxcf"."_banvyp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dok;doq;txp;txz;ico;kto;unk;poz;zk0;zk1;zk2;zk3;zk4;sz1;sz2;sz3;sz4;dn1;dn2;dn3;dn4;sp1;sp2;sp3;sp4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_banvyp ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->txp;
  $text = $text.";".urlencode($riadok->txz).";".$riadok->ico.";".$riadok->kto.";".$riadok->unk.";".$riadok->poz.";".$riadok->zk0.";".$riadok->zk1;
  $text = $text.";".$riadok->zk2.";".$riadok->zk3.";".$riadok->zk4.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4;
  $text = $text.";".$riadok->dn1.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1.";".$riadok->sp2.";".$riadok->sp3;
  $text = $text.";".$riadok->sp4.";".$riadok->zk0u.";".$riadok->zk1u.";".$riadok->zk2u.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u;
  $text = $text.";".$riadok->sp1u.";".$riadok->sp2u.";".$riadok->hodu.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena;
  $text = $text.";".$riadok->zmen.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

 $text = "212;##########Tabulka F$kli_vxcf"."_uctban"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;ddu;poh;cpl;ucm;ucd;rdp;dph;hod;hodm;kurz;mena;zmen;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctban ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->ddu.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//1=uctvsdh,2=uctvsdp
if( $copern == 15 OR $copern == 10 ) {

 $text = "213;##########Tabulka F$kli_vxcf"."_uctvsdh"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dok;doq;txp;txz;ico;kto;unk;poz;zk0;zk1;zk2;zk3;zk4;sz1;sz2;sz3;sz4;dn1;dn2;dn3;dn4;sp1;sp2;sp3;sp4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdh ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->doq.";".$riadok->txp;
  $text = $text.";".urlencode($riadok->txz).";".$riadok->ico.";".$riadok->kto.";".$riadok->unk.";".$riadok->poz.";".$riadok->zk0.";".$riadok->zk1;
  $text = $text.";".$riadok->zk2.";".$riadok->zk3.";".$riadok->zk4.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4;
  $text = $text.";".$riadok->dn1.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1.";".$riadok->sp2.";".$riadok->sp3;
  $text = $text.";".$riadok->sp4.";".$riadok->zk0u.";".$riadok->zk1u.";".$riadok->zk2u.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u;
  $text = $text.";".$riadok->sp1u.";".$riadok->sp2u.";".$riadok->hodu.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena;
  $text = $text.";".$riadok->zmen.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

 $text = "214;##########Tabulka F$kli_vxcf"."_uctvsdp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;poh;cpl;ucm;ucd;rdp;dph;hod;hodm;kurz;mena;zmen;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdp ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//1=uctdrdp,2=uctpohyby,3=ddod,4=dodb,5=dban,6=dpok,7=uctcudz,8=uctmeny,uctkurzy,uctosnova 
if( $copern == 16 OR $copern == 10 OR $copern == 28 ) {

if( $copern == 16 OR $copern == 10 ) {

 $text = "215;##########Tabulka F$kli_vxcf"."_uctdrdp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;rdp;nrd;szd;crz;crd;crz1;crd1;crz2;crd2;crz3;crd3"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctdrdp ORDER BY rdp");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->rdp.";".$riadok->nrd.";".$riadok->szd.";".$riadok->crz.";".$riadok->crd.";".$riadok->crz1.";".$riadok->crd1.";".$riadok->crz2.";".$riadok->crd2.";".$riadok->crz3.";".$riadok->crd3;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

 $text = "216;##########Tabulka F$kli_vxcf"."_uctpohyby"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpoh;pohp;ucto;druh;uzk0;dzk0;uzk1;dzk1;uzk2;dzk2;udn1;ddn1;udn2;ddn2;hfak;hico;hstr;hzak;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpohyby ORDER BY cpoh");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpoh.";".$riadok->pohp.";".$riadok->ucto.";".$riadok->druh.";".$riadok->uzk0.";".$riadok->dzk0.";".$riadok->uzk1.";".$riadok->dzk1.";".$riadok->uzk2.";".$riadok->dzk2.";".$riadok->udn1.";".$riadok->ddn1.";".$riadok->udn2.";".$riadok->ddn2.";".$riadok->hfak.";".$riadok->hico.";".$riadok->hstr.";".$riadok->hzak.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

 $text = "217;##########Tabulka F$kli_vxcf"."_ddod"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ddod;ndod;drdo;ucdo;cfak;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_ddod ORDER BY ddod");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ddod.";".$riadok->ndod.";".$riadok->drdo.";".$riadok->ucdo.";".$riadok->cfak.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

 $text = "218;##########Tabulka F$kli_vxcf"."_dodb"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dodb;nodb;drod;ucod;strv;zakv;cfak;cx01;cx02;tx01;tx02;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb ORDER BY dodb");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dodb.";".$riadok->nodb.";".$riadok->drod.";".$riadok->ucod.";".$riadok->strv.";".$riadok->zakv.";".$riadok->cfak.";".$riadok->cx01.";".$riadok->cx02.";".$riadok->tx01.";".$riadok->tx02.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

 $text = "219;##########Tabulka F$kli_vxcf"."_dban"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dban;nban;uceb;numb;iban;twib;parb;cban;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_dban ORDER BY dban");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dban.";".$riadok->nban.";".$riadok->uceb.";".$riadok->numb.";".$riadok->iban.";".$riadok->twib.";".$riadok->parb.";".$riadok->cban.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "220;##########Tabulka F$kli_vxcf"."_dpok"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dpok;npok;drpk;ucpk;cvyd;cpri;datm;"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_dpok ORDER BY dpok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dpok.";".$riadok->npok.";".$riadok->drpk.";".$riadok->ucpk.";".$riadok->cvyd.";".$riadok->cpri.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "221;##########Tabulka F$kli_vxcf"."_uctcudz"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cuce;cume;mena;pscu;pssk;prc1;prc2;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctcudz ORDER BY cuce");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cuce.";".$riadok->cume.";".$riadok->mena.";".$riadok->pscu.";".$riadok->pssk.";".$riadok->prc1.";".$riadok->prc2.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "222;##########Tabulka F$kli_vxcf"."_uctmeny"."\r\n";
  fwrite($soubor, $text);
  $text = "0;mena;nmen;dmen;umen;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctmeny ORDER BY mena");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->mena.";".$riadok->nmen.";".$riadok->dmen.";".$riadok->umen.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

$text = "223;##########Tabulka F$kli_vxcf"."_uctkurzy"."\r\n";
  fwrite($soubor, $text);
  $text = "0;mena;datk;pomr;kurz;prk1;prk2;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctkurzy ORDER BY mena,datk");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->mena.";".$riadok->datk.";".$riadok->pomr.";".$riadok->kurz.";".$riadok->prk1.";".$riadok->prk2.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                                     }

if( $copern >  0                ) {

  $text = "224;##########Tabulka F$kli_vxcf"."_uctosnova "."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;nuc;crv;crs;pmd;pda;prm1;prm2;prm3;prm4;ucc"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova ORDER BY ucc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->nuc.";".$riadok->crv.";".$riadok->crs.";".$riadok->pmd.";".$riadok->pda.";".$riadok->prm1.";".$riadok->prm2.";".$riadok->prm3.";".$riadok->prm4.";".$riadok->ucc;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                                  }
                                     }

//uctmzd,uctskl,uctmaj
if( $copern == 17 OR $copern == 10 ) {

  $text = "225;##########Tabulka F$kli_vxcf"."_uctmzd"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;dat;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctmzd ORDER BY ume,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "226;##########Tabulka F$kli_vxcf"."_uctskl"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;dat;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctskl ORDER BY ume,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "227;##########Tabulka F$kli_vxcf"."_uctmaj"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;dat;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctmaj ORDER BY ume,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";


  $text = $text.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }






                                     }

//fakdodpoc,fakdodpocuct,fakodbpoc,fakodbpocuct,uctuhradpoc,uctpriku,uctprikp,uctcudzold
if( $copern == 19 OR $copern == 10 ) {

  $text = "228;##########Tabulka F$kli_vxcf"."_fakdodpoc"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dav;das;daz;dok;doq;skl;poh;ico;fak;dol;prf;obj;unk;dpr;ksy;ssy;poz;str;zak;txz;txp;zk0;zk1;zk2;zk3;zk4;dn1;dn2;dn3;dn4;sp1;sp2;sz1;sz2;sz3;sz4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;odbm;zal;zao;ruc;uhr;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdodpoc ORDER BY ume,dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dav.";".$riadok->das.";".$riadok->daz;
  $text = $text.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->dol;
  $text = $text.";".$riadok->prf.";".$riadok->obj.";".$riadok->unk.";".$riadok->dpr.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->poz;
  $text = $text.";".$riadok->str.";".$riadok->zak.";".urlencode($riadok->txz).";".urlencode($riadok->txp).";".$riadok->zk0.";".$riadok->zk1.";".$riadok->zk2;
  $text = $text.";".$riadok->zk3.";".$riadok->zk4.";".$riadok->dn1.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1;
  $text = $text.";".$riadok->sp2.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->zk0u.";".$riadok->zk1u;
  $text = $text.";".$riadok->zk2u.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u.";".$riadok->sp1u.";".$riadok->sp2u.";".$riadok->hodu;
  $text = $text.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->odbm.";".$riadok->zal;
  $text = $text.";".$riadok->zao.";".$riadok->ruc.";".$riadok->uhr.";".$riadok->id.";".$riadok->datm ;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "229;##########Tabulka F$kli_vxcf"."_fakdodpocuct"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;dat;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdodpocuct ORDER BY ume,dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "230;##########Tabulka F$kli_vxcf"."_fakodbpoc"."\r\n";
  fwrite($soubor, $text);
  $text = "0;uce;ume;dat;dav;das;daz;dok;doq;skl;poh;ico;fak;dol;prf;obj;unk;dpr;ksy;ssy;poz;str;zak;txz;txp;zk0;zk1;zk2;zk3;zk4;dn1;dn2;dn3;dn4;sp1;sp2;sz1;sz2;sz3;sz4;zk0u;zk1u;zk2u;dn1u;dn2u;sp0u;sp1u;sp2u;hodu;hod;hodm;kurz;mena;zmen;odbm;zal;zao;ruc;uhr;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodbpoc ORDER BY ume,dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->uce.";".$riadok->ume.";".$riadok->dat.";".$riadok->dav.";".$riadok->das.";".$riadok->daz;
  $text = $text.";".$riadok->dok.";".$riadok->doq.";".$riadok->skl.";".$riadok->poh.";".$riadok->ico.";".$riadok->fak.";".$riadok->dol;
  $text = $text.";".$riadok->prf.";".$riadok->obj.";".$riadok->unk.";".$riadok->dpr.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->poz;
  $text = $text.";".$riadok->str.";".$riadok->zak.";".urlencode($riadok->txz).";".urlencode($riadok->txp).";".$riadok->zk0.";".$riadok->zk1.";".$riadok->zk2;
  $text = $text.";".$riadok->zk3.";".$riadok->zk4.";".$riadok->dn1.";".$riadok->dn2.";".$riadok->dn3.";".$riadok->dn4.";".$riadok->sp1;
  $text = $text.";".$riadok->sp2.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->zk0u.";".$riadok->zk1u;
  $text = $text.";".$riadok->zk2u.";".$riadok->dn1u.";".$riadok->dn2u.";".$riadok->sp0u.";".$riadok->sp1u.";".$riadok->sp2u.";".$riadok->hodu;
  $text = $text.";".$riadok->hod.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".$riadok->odbm.";".$riadok->zal;
  $text = $text.";".$riadok->zao.";".$riadok->ruc.";".$riadok->uhr.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "231;##########Tabulka F$kli_vxcf"."_fakodbpocuct"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;dat;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodbpocuct ORDER BY ume,dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok-> ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "232;##########Tabulka F$kli_vxcf"."_uctuhradpoc"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;dat;dok;poh;cpl;ucm;ucd;rdp;dph;hod;ico;fak;pop;str;zak;unk;id;datm;zmen;mena;kurz;hodm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctuhradpoc ORDER BY ume,dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->poh.";".$riadok->cpl.";".$riadok->ucm.";".$riadok->ucd.";".$riadok->rdp.";".$riadok->dph.";".$riadok->hod.";".$riadok->ico.";".$riadok->fak.";".$riadok->pop.";".$riadok->str.";".$riadok->zak.";".$riadok->unk.";".$riadok->id.";".$riadok->datm.";".$riadok->zmen.";".$riadok->mena.";".$riadok->kurz.";".$riadok->hodm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "233;##########Tabulka F$kli_vxcf"."_uctpriku"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;uce;dat;hodp;hodm;kurz;mena;zmen;txp;txz;ico;kto;unk;poz;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriku  ORDER BY dok");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->uce.";".$riadok->dat.";".$riadok->hodp.";".$riadok->hodm.";".$riadok->kurz.";".$riadok->mena.";".$riadok->zmen.";".urlencode($riadok->txp).";".urlencode($riadok->txz).";".$riadok->ico.";".$riadok->kto.";".$riadok->unk.";".$riadok->poz.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

  $text = "234;##########Tabulka F$kli_vxcf"."_uctprikp "."\r\n";
  fwrite($soubor, $text);
  $text = "0;dok;cpl;uceb;numb;iban;twib;vsy;ksy;ssy;hodp;hodm;uce;ico;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctprikp ORDER BY dok,cpl");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dok.";".$riadok->cpl.";".$riadok->uceb.";".$riadok->numb.";".$riadok->iban.";".$riadok->twib.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->hodp.";".$riadok->hodm.";".$riadok->uce.";".$riadok->ico.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

                                     }

fclose($soubor);

if (File_Exists ("../tmp/uctosnova.csv")) { $soubor = unlink("../tmp/uctosnova.csv"); }
if( $copern == 28 ) {   copy("$nazovsuboru", "../tmp/uctosnova.csv"); }

?>

<a href="<?php echo $nazovsuboru; ?>"><?php echo $nazovsuboru; ?></a>


<?php

// toto je koniec zalohovania uctovnictvo 
     }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
