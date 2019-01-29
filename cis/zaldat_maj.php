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
window.open('zaldat_ucto.php?copern=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZalohujMaj()
                {
window.open('zaldat_maj.php?copern=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZalohujLen(coako)
                {

  var copernx = coako;
  var zaldod = 0;
  if( document.formzal1.zalmaj.checked ) zaldod=1;

window.open('zaldat_maj.php?zaldod=' + zaldod + '&copern='+ copernx + '&xxx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
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
<td>EuroSecom  -  Zálohovanie Majetku</td>
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
<a href="#" onClick="ZalohujMaj();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="98%">Zálohovať Majetok 
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(11);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Dlhodobý majetok
<td class="bmenu" width="8%"><input type="checkbox" name="zalmaj" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(12);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Drobný majetok 
<td class="bmenu" width="8%"><input type="checkbox" name="zaldim" value="1" />
</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(13);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať číselníky a nastavenia majetku
<td class="bmenu" width="8%"><input type="checkbox" name="zalhcc" value="1" />
</td>
</tr>
</table>


</FORM>

<?php
// toto je koniec MEnu 
     }





if ( $copern >= 10 AND $copern <= 19 )
//zalohovanie 
     {

$nazovsuboru="../tmp/zaloha".$kli_vxcf."Maj.txt";

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

//majmaj,majpoh,majmajmes,majmaj_1_2011  POZOR cislovat od 401
if( $copern == 11 OR $copern == 10 ) {


  $text = "401;##########Tabulka F$kli_vxcf"."_majmaj"."\r\n";
  fwrite($soubor, $text);
  $text = "0; cpl;ume;druh;drm;inv;naz;pop;poz;vyc;rvr;tri;obo;jkp;ckp;drh1;drh2;mno;dob;dox;zar;rzv;str;zak;oc;kanc;spo;sku;perc;meso;cen;ops;zos;zss;mes;ros;rop;spo_dan;sku_dan;perc_dan;roco_dan;cen_dan;ops_dan;zos_dan;zss_dan;mes_dan;ros_dan;rop_dan;xmax;cen_max;ops_max;zos_max;zss_max;mes_max;ros_max;rop_max;poh;dph;dap;dvp;dvt;hd1;hd2;hd3;hd4;hd5;hx1;hx2;hx3;hx4;hx5;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majmaj ORDER BY inv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->druh.";".$riadok->drm.";".$riadok->inv.";".$riadok->naz.";".$riadok->pop.";".$riadok->poz.";".$riadok->vyc.";".$riadok->rvr.";".$riadok->tri.";".$riadok->obo.";".$riadok->jkp.";".$riadok->ckp.";".$riadok->drh1.";".$riadok->drh2.";".$riadok->mno.";".$riadok->dob.";".$riadok->dox.";".$riadok->zar.";".$riadok->rzv.";".$riadok->str.";".$riadok->zak.";".$riadok->oc.";".$riadok->kanc.";".$riadok->spo.";".$riadok->sku.";".$riadok->perc.";".$riadok->meso.";".$riadok->cen.";".$riadok->ops.";".$riadok->zos.";".$riadok->zss.";".$riadok->mes.";".$riadok->ros.";".$riadok->rop.";".$riadok->spo_dan.";".$riadok->sku_dan.";".$riadok->perc_dan.";".$riadok->roco_dan.";".$riadok->cen_dan.";".$riadok->ops_dan.";".$riadok->zos_dan.";".$riadok->zss_dan.";".$riadok->mes_dan.";".$riadok->ros_dan.";".$riadok->rop_dan.";".$riadok->xmax.";".$riadok->cen_max.";".$riadok->ops_max.";".$riadok->zos_max.";".$riadok->zss_max.";".$riadok->mes_max.";".$riadok->ros_max.";".$riadok->rop_max.";".$riadok->poh.";".$riadok->dph.";".$riadok->dap.";".$riadok->dvp.";".$riadok->dvt.";".$riadok->hd1.";".$riadok->hd2.";".$riadok->hd3.";".$riadok->hd4.";".$riadok->hd5.";".$riadok->hx1.";".$riadok->hx2.";".$riadok->hx3.";".$riadok->hx4.";".$riadok->hx5.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "402;##########Tabulka F$kli_vxcf"."_majpoh"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;druh;drm;inv;naz;pop;poz;vyc;rvr;tri;obo;jkp;ckp;drh1;drh2;mno;dob;dox;zar;rzv;str;zak;oc;kanc;spo;sku;perc;meso;cen;ops;zos;zss;mes;ros;rop;spo_dan;sku_dan;perc_dan;roco_dan;cen_dan;ops_dan;zos_dan;zss_dan;mes_dan;ros_dan;rop_dan;xmax;cen_max;ops_max;zos_max;zss_max;mes_max;ros_max;rop_max;poh;dph;dap;dvp;dvt;hd1;hd2;hd3;hd4;hd5;hx1;hx2;hx3;hx4;hx5;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majpoh ORDER BY ume,inv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->druh.";".$riadok->drm.";".$riadok->inv.";".$riadok->naz.";".$riadok->pop.";".$riadok->poz.";".$riadok->vyc.";".$riadok->rvr.";".$riadok->tri.";".$riadok->obo.";".$riadok->jkp.";".$riadok->ckp.";".$riadok->drh1.";".$riadok->drh2.";".$riadok->mno.";".$riadok->dob.";".$riadok->dox.";".$riadok->zar.";".$riadok->rzv.";".$riadok->str.";".$riadok->zak.";".$riadok->oc.";".$riadok->kanc.";".$riadok->spo.";".$riadok->sku.";".$riadok->perc.";".$riadok->meso.";".$riadok->cen.";".$riadok->ops.";".$riadok->zos.";".$riadok->zss.";".$riadok->mes.";".$riadok->ros.";".$riadok->rop.";".$riadok->spo_dan.";".$riadok->sku_dan.";".$riadok->perc_dan.";".$riadok->roco_dan.";".$riadok->cen_dan.";".$riadok->ops_dan.";".$riadok->zos_dan.";".$riadok->zss_dan.";".$riadok->mes_dan.";".$riadok->ros_dan.";".$riadok->rop_dan.";".$riadok->xmax.";".$riadok->cen_max.";".$riadok->ops_max.";".$riadok->zos_max.";".$riadok->zss_max.";".$riadok->mes_max.";".$riadok->ros_max.";".$riadok->rop_max.";".$riadok->poh.";".$riadok->dph.";".$riadok->dap.";".$riadok->dvp.";".$riadok->dvt.";".$riadok->hd1.";".$riadok->hd2.";".$riadok->hd3.";".$riadok->hd4.";".$riadok->hd5.";".$riadok->hx1.";".$riadok->hx2.";".$riadok->hx3.";".$riadok->hx4.";".$riadok->hx5.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "403;##########Tabulka F$kli_vxcf"."_majmajmes"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;druh;drm;inv;naz;pop;poz;vyc;rvr;tri;obo;jkp;ckp;drh1;drh2;mno;dob;dox;zar;rzv;str;zak;oc;kanc;spo;sku;perc;meso;cen;ops;zos;zss;mes;ros;rop;spo_dan;sku_dan;perc_dan;roco_dan;cen_dan;ops_dan;zos_dan;zss_dan;mes_dan;ros_dan;rop_dan;xmax;cen_max;ops_max;zos_max;zss_max;mes_max;ros_max;rop_max;poh;dph;dap;dvp;dvt;hd1;hd2;hd3;hd4;hd5;hx1;hx2;hx3;hx4;hx5;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majmajmes ORDER BY inv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->druh.";".$riadok->drm.";".$riadok->inv.";".$riadok->naz.";".$riadok->pop.";".$riadok->poz.";".$riadok->vyc.";".$riadok->rvr.";".$riadok->tri.";".$riadok->obo.";".$riadok->jkp.";".$riadok->ckp.";".$riadok->drh1.";".$riadok->drh2.";".$riadok->mno.";".$riadok->dob.";".$riadok->dox.";".$riadok->zar.";".$riadok->rzv.";".$riadok->str.";".$riadok->zak.";".$riadok->oc.";".$riadok->kanc.";".$riadok->spo.";".$riadok->sku.";".$riadok->perc.";".$riadok->meso.";".$riadok->cen.";".$riadok->ops.";".$riadok->zos.";".$riadok->zss.";".$riadok->mes.";".$riadok->ros.";".$riadok->rop.";".$riadok->spo_dan.";".$riadok->sku_dan.";".$riadok->perc_dan.";".$riadok->roco_dan.";".$riadok->cen_dan.";".$riadok->ops_dan.";".$riadok->zos_dan.";".$riadok->zss_dan.";".$riadok->mes_dan.";".$riadok->ros_dan.";".$riadok->rop_dan.";".$riadok->xmax.";".$riadok->cen_max.";".$riadok->ops_max.";".$riadok->zos_max.";".$riadok->zss_max.";".$riadok->mes_max.";".$riadok->ros_max.";".$riadok->rop_max.";".$riadok->poh.";".$riadok->dph.";".$riadok->dap.";".$riadok->dvp.";".$riadok->dvt.";".$riadok->hd1.";".$riadok->hd2.";".$riadok->hd3.";".$riadok->hd4.";".$riadok->hd5.";".$riadok->hx1.";".$riadok->hx2.";".$riadok->hx3.";".$riadok->hx4.";".$riadok->hx5.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "404;##########Tabulka F$kli_vxcf"."_majmaj_1_2011"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;druh;drm;inv;naz;pop;poz;vyc;rvr;tri;obo;jkp;ckp;drh1;drh2;mno;dob;dox;zar;rzv;str;zak;oc;kanc;spo;sku;perc;meso;cen;ops;zos;zss;mes;ros;rop;spo_dan;sku_dan;perc_dan;roco_dan;cen_dan;ops_dan;zos_dan;zss_dan;mes_dan;ros_dan;rop_dan;xmax;cen_max;ops_max;zos_max;zss_max;mes_max;ros_max;rop_max;poh;dph;dap;dvp;dvt;hd1;hd2;hd3;hd4;hd5;hx1;hx2;hx3;hx4;hx5;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majmaj_1_2011 ORDER BY inv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->druh.";".$riadok->drm.";".$riadok->inv.";".$riadok->naz.";".$riadok->pop.";".$riadok->poz.";".$riadok->vyc.";".$riadok->rvr.";".$riadok->tri.";".$riadok->obo.";".$riadok->jkp.";".$riadok->ckp.";".$riadok->drh1.";".$riadok->drh2.";".$riadok->mno.";".$riadok->dob.";".$riadok->dox.";".$riadok->zar.";".$riadok->rzv.";".$riadok->str.";".$riadok->zak.";".$riadok->oc.";".$riadok->kanc.";".$riadok->spo.";".$riadok->sku.";".$riadok->perc.";".$riadok->meso.";".$riadok->cen.";".$riadok->ops.";".$riadok->zos.";".$riadok->zss.";".$riadok->mes.";".$riadok->ros.";".$riadok->rop.";".$riadok->spo_dan.";".$riadok->sku_dan.";".$riadok->perc_dan.";".$riadok->roco_dan.";".$riadok->cen_dan.";".$riadok->ops_dan.";".$riadok->zos_dan.";".$riadok->zss_dan.";".$riadok->mes_dan.";".$riadok->ros_dan.";".$riadok->rop_dan.";".$riadok->xmax.";".$riadok->cen_max.";".$riadok->ops_max.";".$riadok->zos_max.";".$riadok->zss_max.";".$riadok->mes_max.";".$riadok->ros_max.";".$riadok->rop_max.";".$riadok->poh.";".$riadok->dph.";".$riadok->dap.";".$riadok->dvp.";".$riadok->dvt.";".$riadok->hd1.";".$riadok->hd2.";".$riadok->hd3.";".$riadok->hd4.";".$riadok->hd5.";".$riadok->hx1.";".$riadok->hx2.";".$riadok->hx3.";".$riadok->hx4.";".$riadok->hx5.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


                                     }

//majdim,majpohdim
if( $copern == 12 OR $copern == 10 ) {


  $text = "405;##########Tabulka F$kli_vxcf"."_majdim"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;druh;drm;inv;naz;pop;poz;vyc;rvr;tri;obo;jkp;ckp;drh1;drh2;mno;dob;dox;zar;rzv;str;zak;oc;kanc;spo;sku;perc;meso;cen;ops;zos;zss;mes;ros;rop;spo_dan;sku_dan;perc_dan;roco_dan;cen_dan;ops_dan;zos_dan;zss_dan;mes_dan;ros_dan;rop_dan;xmax;cen_max;ops_max;zos_max;zss_max;mes_max;ros_max;rop_max;poh;dph;dap;dvp;dvt;hd1;hd2;hd3;hd4;hd5;hx1;hx2;hx3;hx4;hx5;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majdim ORDER BY inv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->druh.";".$riadok->drm.";".$riadok->inv.";".$riadok->naz.";".$riadok->pop.";".$riadok->poz.";".$riadok->vyc.";".$riadok->rvr.";".$riadok->tri.";".$riadok->obo.";".$riadok->jkp.";".$riadok->ckp.";".$riadok->drh1.";".$riadok->drh2.";".$riadok->mno.";".$riadok->dob.";".$riadok->dox.";".$riadok->zar.";".$riadok->rzv.";".$riadok->str.";".$riadok->zak.";".$riadok->oc.";".$riadok->kanc.";".$riadok->spo.";".$riadok->sku.";".$riadok->perc.";".$riadok->meso.";".$riadok->cen.";".$riadok->ops.";".$riadok->zos.";".$riadok->zss.";".$riadok->mes.";".$riadok->ros.";".$riadok->rop.";".$riadok->spo_dan.";".$riadok->sku_dan.";".$riadok->perc_dan.";".$riadok->roco_dan.";".$riadok->cen_dan.";".$riadok->ops_dan.";".$riadok->zos_dan.";".$riadok->zss_dan.";".$riadok->mes_dan.";".$riadok->ros_dan.";".$riadok->rop_dan.";".$riadok->xmax.";".$riadok->cen_max.";".$riadok->ops_max.";".$riadok->zos_max.";".$riadok->zss_max.";".$riadok->mes_max.";".$riadok->ros_max.";".$riadok->rop_max.";".$riadok->poh.";".$riadok->dph.";".$riadok->dap.";".$riadok->dvp.";".$riadok->dvt.";".$riadok->hd1.";".$riadok->hd2.";".$riadok->hd3.";".$riadok->hd4.";".$riadok->hd5.";".$riadok->hx1.";".$riadok->hx2.";".$riadok->hx3.";".$riadok->hx4.";".$riadok->hx5.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "406;##########Tabulka F$kli_vxcf"."_majpohdim"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;druh;drm;inv;naz;pop;poz;vyc;rvr;tri;obo;jkp;ckp;drh1;drh2;mno;dob;dox;zar;rzv;str;zak;oc;kanc;spo;sku;perc;meso;cen;ops;zos;zss;mes;ros;rop;spo_dan;sku_dan;perc_dan;roco_dan;cen_dan;ops_dan;zos_dan;zss_dan;mes_dan;ros_dan;rop_dan;xmax;cen_max;ops_max;zos_max;zss_max;mes_max;ros_max;rop_max;poh;dph;dap;dvp;dvt;hd1;hd2;hd3;hd4;hd5;hx1;hx2;hx3;hx4;hx5;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majpohdim ORDER BY ume,inv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->druh.";".$riadok->drm.";".$riadok->inv.";".$riadok->naz.";".$riadok->pop.";".$riadok->poz.";".$riadok->vyc.";".$riadok->rvr.";".$riadok->tri.";".$riadok->obo.";".$riadok->jkp.";".$riadok->ckp.";".$riadok->drh1.";".$riadok->drh2.";".$riadok->mno.";".$riadok->dob.";".$riadok->dox.";".$riadok->zar.";".$riadok->rzv.";".$riadok->str.";".$riadok->zak.";".$riadok->oc.";".$riadok->kanc.";".$riadok->spo.";".$riadok->sku.";".$riadok->perc.";".$riadok->meso.";".$riadok->cen.";".$riadok->ops.";".$riadok->zos.";".$riadok->zss.";".$riadok->mes.";".$riadok->ros.";".$riadok->rop.";".$riadok->spo_dan.";".$riadok->sku_dan.";".$riadok->perc_dan.";".$riadok->roco_dan.";".$riadok->cen_dan.";".$riadok->ops_dan.";".$riadok->zos_dan.";".$riadok->zss_dan.";".$riadok->mes_dan.";".$riadok->ros_dan.";".$riadok->rop_dan.";".$riadok->xmax.";".$riadok->cen_max.";".$riadok->ops_max.";".$riadok->zos_max.";".$riadok->zss_max.";".$riadok->mes_max.";".$riadok->ros_max.";".$riadok->rop_max.";".$riadok->poh.";".$riadok->dph.";".$riadok->dap.";".$riadok->dvp.";".$riadok->dvt.";".$riadok->hd1.";".$riadok->hd2.";".$riadok->hd3.";".$riadok->hd4.";".$riadok->hd5.";".$riadok->hx1.";".$riadok->hx2.";".$riadok->hx3.";".$riadok->hx4.";".$riadok->hx5.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


                                     }

//kancelarie,majdrm,majdimdrm,majdrunak,majdruvyr,majodpisy,majpres,majsodp,majtextmaj,majzos_maj
if( $copern == 13 OR $copern == 10 ) {


                                     }


  $text = "407;##########Tabulka F$kli_vxcf"."_kancelarie"."\r\n";
  fwrite($soubor, $text);
  $text = "0;kanc;nkan;ukan;pkan;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_kancelarie ORDER BY kanc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->kanc.";".$riadok->nkan.";".$riadok->ukan.";".$riadok->pkan.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "408;##########Tabulka F$kli_vxcf"."_majdrm"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cdrm;ndrm;ddrm;pdrm;ucmodpis;ucdodpis;ucmzar;ucdzar;ucmvyr;ucdvyr;ucmvyo;ucdvyo;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majdrm ORDER BY cdrm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cdrm.";".$riadok->ndrm.";".$riadok->ddrm.";".$riadok->pdrm.";".$riadok->ucmodpis.";".$riadok->ucdodpis.";".$riadok->ucmzar.";".$riadok->ucdzar.";".$riadok->ucmvyr.";".$riadok->ucdvyr.";".$riadok->ucmvyo.";".$riadok->ucdvyo.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "409;##########Tabulka F$kli_vxcf"."_majdimdrm"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cdbm;ndbm;ddbm;pdbm;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majdimdrm ORDER BY cdbm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cdbm.";".$riadok->ndbm.";".$riadok->ddbm.";".$riadok->pdbm.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "410;##########Tabulka F$kli_vxcf"."_majdrunak"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cdrn;ndrn;udrn;pdrn;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majdrunak ORDER BY cdrn");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cdrn.";".$riadok->ndrn.";".$riadok->udrn.";".$riadok->pdrn.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "411;##########Tabulka F$kli_vxcf"."_majdruvyr"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cdrv;ndrv;udrv;pdrv;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majdruvyr ORDER BY cdrv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cdrv.";".$riadok->ndrv.";".$riadok->udrv.";".$riadok->pdrv.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "412;##########Tabulka F$kli_vxcf"."_majodpisy"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;ume;druh;drm;inv;naz;pop;poz;vyc;rvr;tri;obo;jkp;ckp;drh1;drh2;mno;dob;dox;zar;rzv;str;zak;oc;kanc;spo;sku;perc;meso;cen;ops;zos;zss;mes;ros;rop;spo_dan;sku_dan;perc_dan;roco_dan;cen_dan;ops_dan;zos_dan;zss_dan;mes_dan;ros_dan;rop_dan;xmax;cen_max;ops_max;zos_max;zss_max;mes_max;ros_max;rop_max;poh;dph;dap;dvp;dvt;hd1;hd2;hd3;hd4;hd5;hx1;hx2;hx3;hx4;hx5;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majodpisy ORDER BY ume,inv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->ume.";".$riadok->druh.";".$riadok->drm.";".$riadok->inv.";".$riadok->naz.";".$riadok->pop.";".$riadok->poz.";".$riadok->vyc.";".$riadok->rvr.";".$riadok->tri.";".$riadok->obo.";".$riadok->jkp.";".$riadok->ckp.";".$riadok->drh1.";".$riadok->drh2.";".$riadok->mno.";".$riadok->dob.";".$riadok->dox.";".$riadok->zar.";".$riadok->rzv.";".$riadok->str.";".$riadok->zak.";".$riadok->oc.";".$riadok->kanc.";".$riadok->spo.";".$riadok->sku.";".$riadok->perc.";".$riadok->meso.";".$riadok->cen.";".$riadok->ops.";".$riadok->zos.";".$riadok->zss.";".$riadok->mes.";".$riadok->ros.";".$riadok->rop.";".$riadok->spo_dan.";".$riadok->sku_dan.";".$riadok->perc_dan.";".$riadok->roco_dan.";".$riadok->cen_dan.";".$riadok->ops_dan.";".$riadok->zos_dan.";".$riadok->zss_dan.";".$riadok->mes_dan.";".$riadok->ros_dan.";".$riadok->rop_dan.";".$riadok->xmax.";".$riadok->cen_max.";".$riadok->ops_max.";".$riadok->zos_max.";".$riadok->zss_max.";".$riadok->mes_max.";".$riadok->ros_max.";".$riadok->rop_max.";".$riadok->poh.";".$riadok->dph.";".$riadok->dap.";".$riadok->dvp.";".$riadok->dvt.";".$riadok->hd1.";".$riadok->hd2.";".$riadok->hd3.";".$riadok->hd4.";".$riadok->hd5.";".$riadok->hx1.";".$riadok->hx2.";".$riadok->hx3.";".$riadok->hx4.";".$riadok->hx5.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "413;##########Tabulka F$kli_vxcf"."_majpres"."\r\n";
  fwrite($soubor, $text);
  $text = "0;druh;inv;oc;kanc;nwoc;nwkanc;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majpres ORDER BY inv,datm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->druh.";".$riadok->inv.";".$riadok->oc.";".$riadok->kanc.";".$riadok->nwoc.";".$riadok->nwkanc.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "414;##########Tabulka F$kli_vxcf"."_majsodp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;rdoba1;rdoba2;rdoba3;rdoba4;rdoba5;rdoba6;rdoba7;rdoba8;rdoba9;rdoba10;zkoep7;zkoep8;zkoep9;zkoep10;zkoed7;zkoed8;zkoed9;zkoed10;zzvys7;zzvys8;zzvys9;zzvys10;zkoep1;zkoep2;zkoep3;zkoep4;zkoep5;zkoep6;zkoed1;zkoed2;zkoed3;zkoed4;zkoed5;zkoed6;zzvys1;zzvys2;zzvys3;zzvys4;zzvys5;zzvys6;rdoba1_dan;rdoba2_dan;rdoba3_dan;rdoba4_dan;rdoba5_dan;rdoba6_dan;zkoep1_dan;zkoep2_dan;zkoep3_dan;zkoep4_dan;zkoep5_dan;zkoep6_dan;zkoed1_dan;zkoed2_dan;zkoed3_dan;zkoed4_dan;zkoed5_dan;zkoed6_dan;zzvys1_dan;zzvys2_dan;zzvys3_dan;zzvys4_dan;zzvys5_dan;zzvys6_dan"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majsodp ");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->rdoba1.";".$riadok->rdoba2.";".$riadok->rdoba3.";".$riadok->rdoba4.";".$riadok->rdoba5;
  $text = $text.";".$riadok->rdoba6.";".$riadok->rdoba7.";".$riadok->rdoba8.";".$riadok->rdoba9.";".$riadok->rdoba10.";".$riadok->zkoep7;
  $text = $text.";".$riadok->zkoep8.";".$riadok->zkoep9.";".$riadok->zkoep10.";".$riadok->zkoed7.";".$riadok->zkoed8.";".$riadok->zkoed9;
  $text = $text.";".$riadok->zkoed10.";".$riadok->zzvys7.";".$riadok->zzvys8.";".$riadok->zzvys9.";".$riadok->zzvys10.";".$riadok->zkoep1;
  $text = $text.";".$riadok->zkoep2.";".$riadok->zkoep3.";".$riadok->zkoep4.";".$riadok->zkoep5.";".$riadok->zkoep6.";".$riadok->zkoed1;
  $text = $text.";".$riadok->zkoed2.";".$riadok->zkoed3.";".$riadok->zkoed4.";".$riadok->zkoed5.";".$riadok->zkoed6.";".$riadok->zzvys1;
  $text = $text.";".$riadok->zzvys2.";".$riadok->zzvys3.";".$riadok->zzvys4.";".$riadok->zzvys5.";".$riadok->zzvys6.";".$riadok->rdoba1_dan;
  $text = $text.";".$riadok->rdoba2_dan.";".$riadok->rdoba3_dan.";".$riadok->rdoba4_dan.";".$riadok->rdoba5_dan.";".$riadok->rdoba6_dan;
  $text = $text.";".$riadok->zkoep1_dan.";".$riadok->zkoep2_dan.";".$riadok->zkoep3_dan.";".$riadok->zkoep4_dan.";".$riadok->zkoep5_dan;
  $text = $text.";".$riadok->zkoep6_dan.";".$riadok->zkoed1_dan.";".$riadok->zkoed2_dan.";".$riadok->zkoed3_dan.";".$riadok->zkoed4_dan;
  $text = $text.";".$riadok->zkoed5_dan.";".$riadok->zkoed6_dan.";".$riadok->zzvys1_dan.";".$riadok->zzvys2_dan.";".$riadok->zzvys3_dan;
  $text = $text.";".$riadok->zzvys4_dan.";".$riadok->zzvys5_dan.";".$riadok->zzvys6_dan;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  } 



  $text = "415;##########Tabulka F$kli_vxcf"."_majtextmaj"."\r\n";
  fwrite($soubor, $text);
  $text = "0;invt;itxt;nas1;zdro;zaku;stru;suv4;suv3;zake;stre;zrpe;zrpu;zrme;zrmu;suv2;suv1;odpe;odpu;odme;odmu;pere;peru;cene"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majtextmaj ORDER BY invt");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->invt.";".urlencode($riadok->itxt).";".$riadok->nas1.";".$riadok->zdro.";".$riadok->zaku.";".$riadok->stru.";".$riadok->suv4.";".$riadok->suv3.";".$riadok->zake.";".$riadok->stre.";".$riadok->zrpe.";".$riadok->zrpu.";".$riadok->zrme.";".$riadok->zrmu.";".$riadok->suv2.";".$riadok->suv1.";".$riadok->odpe.";".$riadok->odpu.";".$riadok->odme.";".$riadok->odmu.";".$riadok->pere.";".$riadok->peru.";".$riadok->cene;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }

 

$text = "416;##########Tabulka F$kli_vxcf"."_majzos_maj"."\r\n";
  fwrite($soubor, $text);
  $text = "0;czs;nzs;pzs;ttp;ttz;cpl;por;pol;pop;vyz;pod;trd;fic"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majzos_maj ORDER BY czs");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->czs.";".$riadok->nzs.";".$riadok->pzs.";".$riadok->ttp.";".$riadok->ttz.";".$riadok->cpl.";".$riadok->por.";".$riadok->pol.";".$riadok->pop.";".$riadok->vyz.";".$riadok->pod.";".$riadok->trd.";".$riadok->fic;

  $text = $text."\r\n";
  fwrite($soubor, $text);
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
