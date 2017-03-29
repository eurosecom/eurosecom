<HTML>
<?php
$sys = 'ALL';
$urov = 15000;
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

function ZalohujMzdy()
                {
window.open('zaldat_mzdy.php?copern=10', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                }

function ZalohujLen(coako)
                {

  var copernx = coako;
  var zaldod = 0;
  if( document.formzal1.zaldod.checked ) zaldod=1;

window.open('zaldat_mzdy.php?zaldod=' + zaldod + '&copern='+ copernx + '&xxx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
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
<td>EuroSecom  -  Zálohovanie Miezd</td>
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
<a href="#" onClick="ZalohujMzdy();">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="98%">Zálohovať Mzdy 
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(11);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Údaje o zamestnancoch
<td class="bmenu" width="8%"><input type="checkbox" name="zalkun" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(12);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Trvalé mzdové položky 
<td class="bmenu" width="8%"><input type="checkbox" name="zaltrn" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(13);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Mesačnú dávku
<td class="bmenu" width="8%"><input type="checkbox" name="zalmes" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(14);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Údaje DDP 
<td class="bmenu" width="8%"><input type="checkbox" name="zalddp" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(15);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať Mzdové listy 
<td class="bmenu" width="8%"><input type="checkbox" name="zalmzl" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(16);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať číselníky a nastavenia miezd
<td class="bmenu" width="8%"><input type="checkbox" name="zalmcc" value="1" />
</td>
</tr>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZalohujLen(17);">
<img src='../obr/export.png' width=20 height=15 border=0 title='Zálohovať do TXT' ></a></td>
<td class="bmenu" width="90%">Zálohovať výkazy Dane z príjmu a Zúčtovania ZP
<td class="bmenu" width="8%"><input type="checkbox" name="zaldpz" value="1" />
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

$nazovsuboru="../tmp/zaloha".$kli_vxcf."Mzdy.txt";

if (File_Exists ("$nazovsuboru")) { $soubor = unlink("$nazovsuboru"); }

$soubor = fopen("$nazovsuboru", "a+");

//mzdkun POZOR cislovat tabulky od 301
if( $copern == 11 OR $copern == 10 ) {


  $text = "301;##########Tabulka F$kli_vxcf"."_mzdkun"."\r\n";
  fwrite($soubor, $text);
  $text = "0;oc;meno;prie;rodn;prbd;titl;akt;rdc;rdk;dar;mnr;cop;zmes;zpsc;zcdm;zuli;zema;ztel;pom;kat;wms;stz;zkz;uva;uvazn;dan;dav;nev;nrk;crp;znah;znem;doch;docv;dad;dvy;cdss;roh;spno;dsp;spnie;deti_sp;zrz_dn;ziv_dn;deti_dn;zpno;zpnie;dvp;zdrv;trd;sz0;sz1;sz2;sz3;sz4;sz5;vban;uceb;numb;vsy;ksy;ssy;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->oc.";".$riadok->meno.";".$riadok->prie.";".$riadok->rodn.";".$riadok->prbd.";".$riadok->titl.";".$riadok->akt.";".$riadok->rdc.";".$riadok->rdk.";".$riadok->dar.";".$riadok->mnr.";".$riadok->cop.";".$riadok->zmes.";".$riadok->zpsc.";".$riadok->zcdm.";".$riadok->zuli.";".$riadok->zema.";".$riadok->ztel.";".$riadok->pom.";".$riadok->kat.";".$riadok->wms.";".$riadok->stz.";".$riadok->zkz.";".$riadok->uva.";".$riadok->uvazn.";".$riadok->dan.";".$riadok->dav.";".$riadok->nev.";".$riadok->nrk.";".$riadok->crp.";".$riadok->znah.";".$riadok->znem.";".$riadok->doch.";".$riadok->docv.";".$riadok->dad.";".$riadok->dvy.";".$riadok->cdss.";".$riadok->roh.";".$riadok->spno.";".$riadok->dsp.";".$riadok->spnie.";".$riadok->deti_sp.";".$riadok->zrz_dn.";".$riadok->ziv_dn.";".$riadok->deti_dn.";".$riadok->zpno.";".$riadok->zpnie.";".$riadok->dvp.";".$riadok->zdrv.";".$riadok->trd.";".$riadok->sz0.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->sz5.";".$riadok->vban.";".$riadok->uceb.";".$riadok->numb.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



                                     }

//mzdtrn
if( $copern == 12 OR $copern == 10 ) {


  $text = "302;##########Tabulka F$kli_vxcf"."_mzdtrn"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;oc;dm;kc;mn;trx1;trx2;trx3;trx4;uceb;numb;vsy;ksy;ssy;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdtrn ORDER BY oc,dm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->oc.";".$riadok->dm.";".$riadok->kc.";".$riadok->mn.";".$riadok->trx1.";".$riadok->trx2.";".$riadok->trx3.";".$riadok->trx4.";".$riadok->uceb.";".$riadok->numb.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//mzdmes
if( $copern == 13 OR $copern == 10 ) {


  $text = "303;##########Tabulka F$kli_vxcf"."_mzdmes"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;dok;dat;ume;oc;dm;dp;dk;dni;hod;mnz;saz;kc;str;zak;stj;msx1;msx2;msx3;msx4;pop;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdmes ORDER BY oc,dm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->dok.";".$riadok->dat.";".$riadok->ume.";".$riadok->oc.";".$riadok->dm.";".$riadok->dp.";".$riadok->dk.";".$riadok->dni.";".$riadok->hod.";".$riadok->mnz.";".$riadok->saz.";".$riadok->kc.";".$riadok->str.";".$riadok->zak.";".$riadok->stj.";".$riadok->msx1.";".$riadok->msx2.";".$riadok->msx3.";".$riadok->msx4.";".$riadok->pop.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//mzdddp
if( $copern == 14 OR $copern == 10 ) {


  $text = "304;##########Tabulka F$kli_vxcf"."_mzdddp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;oc;perz_dd;fixz_dd;perp_dd;fixp_dd;cddp;czm;dtd;pd1;pd2;pd3;pd4;datm "."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdddp ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->oc.";".$riadok->perz_dd.";".$riadok->fixz_dd.";".$riadok->perp_dd.";".$riadok->fixp_dd.";".$riadok->cddp.";".$riadok->czm.";".$riadok->dtd.";".$riadok->pd1.";".$riadok->pd2.";".$riadok->pd3.";".$riadok->pd4.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


                                     }

//mzdzalsum,mzdzalvy,mzdzalmes,mzdzalkun,mzdzaltrn,mzdzalprm
if( $copern == 15 OR $copern == 10 ) {


  $text = "305;##########Tabulka F$kli_vxcf"."_mzdzalsum"."\r\n";
  fwrite($soubor, $text);
  $text = "0;sum_dni;sum_hod;sum_hru;sum_nem;sum_zrz;sum_hot;sum_ban;zzam_zp;zzam_np;zzam_sp;zzam_ip;zzam_pn;zzam_up;zzam_gf;zzam_rf;zfir_zp;zfir_np;zfir_sp;zfir_ip;zfir_pn;zfir_up;zfir_gf;zfir_rf;ozam_zp;ozam_np;ozam_sp;ozam_ip;ozam_pn;ozam_up;ozam_gf;ozam_rf;ofir_zp;ofir_np;ofir_sp;ofir_ip;ofir_pn;ofir_up;ofir_gf;ofir_rf;ozam_spolu;ofir_spolu;des1;des2;des3;des6;ume;oc;zdan_dnp;odan_dnp;pdan_dnv;pdan_fnd;pdan_zn1;pdan_zn2;odan_zrz;zakl_dan;bonus_dan;id;hot_eur;ban_eur;ddp_zam;ddp_fir;sum_cccp;sum_cccpsk;cista_mzda;cista_mzdask;sdoch;sdocv;sspnie;szpnie;spom;svban;snumb;scdss;ozam_dss;suva;ksum1;zmax_zp;zmax_np;zmax_sp;zmax_ip;zmax_pn;zmax_up;zmax_gf;zmax_rf;zmin_zp;zmin_np;zmin_sp;zmin_ip;zmin_pn;zmin_up;zmin_gf;zmin_rf;ksum2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdzalsum ORDER BY ume,oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->sum_dni.";".$riadok->sum_hod.";".$riadok->sum_hru.";".$riadok->sum_nem.";".$riadok->sum_zrz.";".$riadok->sum_hot.";".$riadok->sum_ban.";".$riadok->zzam_zp.";".$riadok->zzam_np.";".$riadok->zzam_sp.";".$riadok->zzam_ip.";".$riadok->zzam_pn.";".$riadok->zzam_up.";".$riadok->zzam_gf.";".$riadok->zzam_rf.";".$riadok->zfir_zp.";".$riadok->zfir_np.";".$riadok->zfir_sp.";".$riadok->zfir_ip.";".$riadok->zfir_pn.";".$riadok->zfir_up.";".$riadok->zfir_gf.";".$riadok->zfir_rf.";".$riadok->ozam_zp.";".$riadok->ozam_np.";".$riadok->ozam_sp.";".$riadok->ozam_ip.";".$riadok->ozam_pn.";".$riadok->ozam_up.";".$riadok->ozam_gf.";".$riadok->ozam_rf.";".$riadok->ofir_zp.";".$riadok->ofir_np.";".$riadok->ofir_sp.";".$riadok->ofir_ip.";".$riadok->ofir_pn.";".$riadok->ofir_up.";".$riadok->ofir_gf.";".$riadok->ofir_rf.";".$riadok->ozam_spolu.";".$riadok->ofir_spolu.";".$riadok->des1.";".$riadok->des2.";".$riadok->des3.";".$riadok->des6.";".$riadok->ume.";".$riadok->oc.";".$riadok->zdan_dnp.";".$riadok->odan_dnp.";".$riadok->pdan_dnv.";".$riadok->pdan_fnd.";".$riadok->pdan_zn1.";".$riadok->pdan_zn2.";".$riadok->odan_zrz.";".$riadok->zakl_dan.";".$riadok->bonus_dan.";".$riadok->id.";".$riadok->hot_eur.";".$riadok->ban_eur.";".$riadok->ddp_zam.";".$riadok->ddp_fir.";".$riadok->sum_cccp.";".$riadok->sum_cccpsk.";".$riadok->cista_mzda.";".$riadok->cista_mzdask.";".$riadok->sdoch.";".$riadok->sdocv.";".$riadok->sspnie.";".$riadok->szpnie.";".$riadok->spom.";".$riadok->svban.";".$riadok->snumb.";".$riadok->scdss.";".$riadok->ozam_dss.";".$riadok->suva.";".$riadok->ksum1.";".$riadok->zmax_zp.";".$riadok->zmax_np.";".$riadok->zmax_sp.";".$riadok->zmax_ip.";".$riadok->zmax_pn.";".$riadok->zmax_up.";".$riadok->zmax_gf.";".$riadok->zmax_rf.";".$riadok->zmin_zp.";".$riadok->zmin_np.";".$riadok->zmin_sp.";".$riadok->zmin_ip.";".$riadok->zmin_pn.";".$riadok->zmin_up.";".$riadok->zmin_gf.";".$riadok->zmin_rf.";".$riadok->ksum2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


  $text = "306;##########Tabulka F$kli_vxcf"."_mzdzalvy"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cel_dni;cel_hod;cel_hru;cel_nem;cel_zrz;cel_hot;cel_ban;czz_zzp;czz_znp;czz_zsp;czz_zip;czz_zpn;czz_zup;czz_zgf;czz_zrf;dok;dat;ume;oc;dm;dp;dk;dni;hod;mnz;saz;kc;kcsk;str;zak;stj;trncpl;czd_dnp;id;odkial;trx1;dne;hne;prd;prh;ds6;ds2;neod_dni;neod_hod;cddp;ddp_perz;ddp_fixz;ddp_perp;ddp_fixp;ddp_zam;ddp_fir;vdoch;vdocv;vspnie;vzpnie;vpom;konx;nesp_dni;nesp_hod;nezp_dni;nezp_hod "."\r\n";
;fwrite($soubor, $text);
;$vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdzalvy ORDER BY ume,oc,dm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cel_dni.";".$riadok->cel_hod.";".$riadok->cel_hru.";".$riadok->cel_nem.";".$riadok->cel_zrz.";".$riadok->cel_hot.";".$riadok->cel_ban.";".$riadok->czz_zzp.";".$riadok->czz_znp.";".$riadok->czz_zsp.";".$riadok->czz_zip.";".$riadok->czz_zpn.";".$riadok->czz_zup.";".$riadok->czz_zgf.";".$riadok->czz_zrf.";".$riadok->dok.";".$riadok->dat.";".$riadok->ume.";".$riadok->oc.";".$riadok->dm.";".$riadok->dp.";".$riadok->dk.";".$riadok->dni.";".$riadok->hod.";".$riadok->mnz.";".$riadok->saz.";".$riadok->kc.";".$riadok->kcsk.";".$riadok->str.";".$riadok->zak.";".$riadok->stj.";".$riadok->trncpl.";".$riadok->czd_dnp.";".$riadok->id.";".$riadok->odkial.";".$riadok->trx1.";".$riadok->dne.";".$riadok->hne.";".$riadok->prd.";".$riadok->prh.";".$riadok->ds6.";".$riadok->ds2.";".$riadok->neod_dni.";".$riadok->neod_hod.";".$riadok->cddp.";".$riadok->ddp_perz.";".$riadok->ddp_fixz.";".$riadok->ddp_perp.";".$riadok->ddp_fixp.";".$riadok->ddp_zam.";".$riadok->ddp_fir.";".$riadok->vdoch.";".$riadok->vdocv.";".$riadok->vspnie.";".$riadok->vzpnie.";".$riadok->vpom.";".$riadok->konx.";".$riadok->nesp_dni.";".$riadok->nesp_hod.";".$riadok->nezp_dni.";".$riadok->nezp_hod;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "307;##########Tabulka F$kli_vxcf"."_mzdzalmes"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;dok;dat;ume;oc;dm;dp;dk;dni;hod;mnz;saz;kc;str;zak;stj;msx1;msx2;msx3;msx4;pop;id;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdzalmes ORDER BY ume,oc,dm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->dok.";".$riadok->dat.";".$riadok->ume.";".$riadok->oc.";".$riadok->dm.";".$riadok->dp.";".$riadok->dk.";".$riadok->dni.";".$riadok->hod.";".$riadok->mnz.";".$riadok->saz.";".$riadok->kc.";".$riadok->str.";".$riadok->zak.";".$riadok->stj.";".$riadok->msx1.";".$riadok->msx2.";".$riadok->msx3.";".$riadok->msx4.";".$riadok->pop.";".$riadok->id.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "308;##########Tabulka F$kli_vxcf"."_mzdzalkun"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;oc;meno;prie;rodn;prbd;titl;akt;rdc;rdk;dar;mnr;cop;zmes;zpsc;zcdm;zuli;zema;ztel;pom;kat;wms;stz;zkz;uva;uvazn;dan;dav;nev;nrk;crp;znah;znem;doch;docv;dad;dvy;cdss;roh;spno;dsp;spnie;deti_sp;zrz_dn;ziv_dn;deti_dn;zpno;zpnie;dvp;zdrv;trd;sz0;sz1;sz2;sz3;sz4;sz5;vban;uceb;numb;vsy;ksy;ssy;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdzalkun ORDER BY ume,oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->oc.";".$riadok->meno.";".$riadok->prie.";".$riadok->rodn.";".$riadok->prbd.";".$riadok->titl.";".$riadok->akt.";".$riadok->rdc.";".$riadok->rdk.";".$riadok->dar.";".$riadok->mnr.";".$riadok->cop.";".$riadok->zmes.";".$riadok->zpsc.";".$riadok->zcdm.";".$riadok->zuli.";".$riadok->zema.";".$riadok->ztel.";".$riadok->pom.";".$riadok->kat.";".$riadok->wms.";".$riadok->stz.";".$riadok->zkz.";".$riadok->uva.";".$riadok->uvazn.";".$riadok->dan.";".$riadok->dav.";".$riadok->nev.";".$riadok->nrk.";".$riadok->crp.";".$riadok->znah.";".$riadok->znem.";".$riadok->doch.";".$riadok->docv.";".$riadok->dad.";".$riadok->dvy.";".$riadok->cdss.";".$riadok->roh.";".$riadok->spno.";".$riadok->dsp.";".$riadok->spnie.";".$riadok->deti_sp.";".$riadok->zrz_dn.";".$riadok->ziv_dn.";".$riadok->deti_dn.";".$riadok->zpno.";".$riadok->zpnie.";".$riadok->dvp.";".$riadok->zdrv.";".$riadok->trd.";".$riadok->sz0.";".$riadok->sz1.";".$riadok->sz2.";".$riadok->sz3.";".$riadok->sz4.";".$riadok->sz5.";".$riadok->vban.";".$riadok->uceb.";".$riadok->numb.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "309;##########Tabulka F$kli_vxcf"."_mzdzaltrn"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;cpl;oc;dm;kc;mn;trx1;trx2;trx3;trx4;uceb;numb;vsy;ksy;ssy;datm "."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdzaltrn ORDER BY ume,oc,dm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->cpl.";".$riadok->oc.";".$riadok->dm.";".$riadok->kc.";".$riadok->mn.";".$riadok->trx1.";".$riadok->trx2.";".$riadok->trx3.";".$riadok->trx4.";".$riadok->uceb.";".$riadok->numb.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "310;##########Tabulka F$kli_vxcf"."_mzdzalprm"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;datum;max_zp;max_np;max_sp;max_ip;max_pn;max_up;max_gf;max_rf;min_zp;min_np;min_sp;min_ip;min_pn;min_up;min_gf;min_rf;zam_zp;zam_zpn;zam_np;zam_sp;zam_ip;zam_pn;zam_up;zam_gf;zam_rf;fir_zp;fir_zpn;fir_np;fir_sp;fir_ip;fir_pn;fir_up;fir_gf;fir_rf;dan_bonus;dan_danov;soc_perc;uva_hod;min_mzda;dan_perc;zuco;uceo;numo;vsyo;ksyo;ssyo;ucedz;numdz;vsydz;ksydz;ssydz;zucdz;cicz;uced;numd;vsyd;ksyd;ssyd;zucd;uces;nums;vsys;ksys;ssys;zucs;zucz "."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdzalprm ORDER BY ume");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->datum.";".$riadok->max_zp.";".$riadok->max_np.";".$riadok->max_sp.";".$riadok->max_ip.";".$riadok->max_pn.";".$riadok->max_up.";".$riadok->max_gf.";".$riadok->max_rf.";".$riadok->min_zp.";".$riadok->min_np.";".$riadok->min_sp.";".$riadok->min_ip.";".$riadok->min_pn.";".$riadok->min_up.";".$riadok->min_gf.";".$riadok->min_rf.";".$riadok->zam_zp.";".$riadok->zam_zpn.";".$riadok->zam_np.";".$riadok->zam_sp.";".$riadok->zam_ip.";".$riadok->zam_pn.";".$riadok->zam_up.";".$riadok->zam_gf.";".$riadok->zam_rf.";".$riadok->fir_zp.";".$riadok->fir_zpn.";".$riadok->fir_np.";".$riadok->fir_sp.";".$riadok->fir_ip.";".$riadok->fir_pn.";".$riadok->fir_up.";".$riadok->fir_gf.";".$riadok->fir_rf.";".$riadok->dan_bonus.";".$riadok->dan_danov.";".$riadok->soc_perc.";".$riadok->uva_hod.";".$riadok->min_mzda.";".$riadok->dan_perc.";".$riadok->zuco.";".$riadok->uceo.";".$riadok->numo.";".$riadok->vsyo.";".$riadok->ksyo.";".$riadok->ssyo.";".$riadok->ucedz.";".$riadok->numdz.";".$riadok->vsydz.";".$riadok->ksydz.";".$riadok->ssydz.";".$riadok->zucdz.";".$riadok->cicz.";".$riadok->uced.";".$riadok->numd.";".$riadok->vsyd.";".$riadok->ksyd.";".$riadok->ssyd.";".$riadok->zucd.";".$riadok->uces.";".$riadok->nums.";".$riadok->vsys.";".$riadok->ksys.";".$riadok->ssys.";".$riadok->zucs.";".$riadok->zucz ;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }





                                     }

//mzdprm,mzddeti,mzdcisddp,mzddmn,mzdpomer,mzddss,mzducty,zdravpois
if( $copern == 16 OR $copern == 10 ) {



  $text = "311;##########Tabulka F$kli_vxcf"."_mzdprm"."\r\n";
  fwrite($soubor, $text);
  $text = "0;datum;max_zp;max_np;max_sp;max_ip;max_pn;max_up;max_gf;max_rf;min_zp;min_np;min_sp;min_ip;min_pn;min_up;min_gf;min_rf;zam_zp;zam_zpn;zam_np;zam_sp;zam_ip;zam_pn;zam_up;zam_gf;zam_rf;fir_zp;fir_zpn;fir_np;fir_sp;fir_ip;fir_pn;fir_up;fir_gf;fir_rf;dan_bonus;dan_danov;soc_perc;uva_hod;min_mzda;dan_perc;zuco;uceo;numo;vsyo;ksyo;ssyo;ucedz;numdz;vsydz;ksydz;ssydz;zucdz;cicz;uced;numd;vsyd;ksyd;ssyd;zucd;uces;nums;vsys;ksys;ssys;zucs;zucz;"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm ");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->datum.";".$riadok->max_zp.";".$riadok->max_np.";".$riadok->max_sp.";".$riadok->max_ip.";".$riadok->max_pn.";".$riadok->max_up.";".$riadok->max_gf.";".$riadok->max_rf.";".$riadok->min_zp.";".$riadok->min_np.";".$riadok->min_sp.";".$riadok->min_ip.";".$riadok->min_pn.";".$riadok->min_up.";".$riadok->min_gf.";".$riadok->min_rf.";".$riadok->zam_zp.";".$riadok->zam_zpn.";".$riadok->zam_np.";".$riadok->zam_sp.";".$riadok->zam_ip.";".$riadok->zam_pn.";".$riadok->zam_up.";".$riadok->zam_gf.";".$riadok->zam_rf.";".$riadok->fir_zp.";".$riadok->fir_zpn.";".$riadok->fir_np.";".$riadok->fir_sp.";".$riadok->fir_ip.";".$riadok->fir_pn.";".$riadok->fir_up.";".$riadok->fir_gf.";".$riadok->fir_rf.";".$riadok->dan_bonus.";".$riadok->dan_danov.";".$riadok->soc_perc.";".$riadok->uva_hod.";".$riadok->min_mzda.";".$riadok->dan_perc.";".$riadok->zuco.";".$riadok->uceo.";".$riadok->numo.";".$riadok->vsyo.";".$riadok->ksyo.";".$riadok->ssyo.";".$riadok->ucedz.";".$riadok->numdz.";".$riadok->vsydz.";".$riadok->ksydz.";".$riadok->ssydz.";".$riadok->zucdz.";".$riadok->cicz.";".$riadok->uced.";".$riadok->numd.";".$riadok->vsyd.";".$riadok->ksyd.";".$riadok->ssyd.";".$riadok->zucd.";".$riadok->uces.";".$riadok->nums.";".$riadok->vsys.";".$riadok->ksys.";".$riadok->ssys.";".$riadok->zucs.";".$riadok->zucz ;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "312;##########Tabulka F$kli_vxcf"."_mzddeti"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cpl;oc;md;rcd;dr;p1;p2;p3;p4;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddeti ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cpl.";".$riadok->oc.";".$riadok->md.";".$riadok->rcd.";".$riadok->dr.";".$riadok->p1.";".$riadok->p2.";".$riadok->p3.";".$riadok->p4.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "313;##########Tabulka F$kli_vxcf"."_mzdcisddp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cddp;nddp;uceb;numb;iban;vsy;ksy;ssy;anl;pz1;pz2;pz3;pz4;pz5;pt1;pt2;pt3;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdcisddp ORDER BY cddp");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cddp.";".$riadok->nddp.";".$riadok->uceb.";".$riadok->numb.";".$riadok->iban.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->anl.";".$riadok->pz1.";".$riadok->pz2.";".$riadok->pz3.";".$riadok->pz4.";".$riadok->pz5.";".$riadok->pt1.";".$riadok->pt2.";".$riadok->pt3.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "314;##########Tabulka F$kli_vxcf"."_mzddmn"."\r\n";
  fwrite($soubor, $text);
  $text = "0;dm;nzdm;dndm;td;nap_zp;nap_np;nap_sp;nap_ip;nap_pn;nap_up;nap_gf;nap_rf;br;rh;do;ne;ho;np;prn;prm;prv;prs;sa;ko;sax;su;au;suc;auc;dm1;dm2;dm3;dm4;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddmn ORDER BY dm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->dm.";".$riadok->nzdm.";".$riadok->dndm.";".$riadok->td.";".$riadok->nap_zp.";".$riadok->nap_np.";".$riadok->nap_sp.";".$riadok->nap_ip.";".$riadok->nap_pn.";".$riadok->nap_up.";".$riadok->nap_gf.";".$riadok->nap_rf.";".$riadok->br.";".$riadok->rh.";".$riadok->do.";".$riadok->ne.";".$riadok->ho.";".$riadok->np.";".$riadok->prn.";".$riadok->prm.";".$riadok->prv.";".$riadok->prs.";".$riadok->sa.";".$riadok->ko.";".$riadok->sax.";".$riadok->su.";".$riadok->au.";".$riadok->suc.";".$riadok->auc.";".$riadok->dm1.";".$riadok->dm2.";".$riadok->dm3.";".$riadok->dm4.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "315;##########Tabulka F$kli_vxcf"."_mzdpomer"."\r\n";
  fwrite($soubor, $text);
  $text = "0;pm;nzpm;prpm;zam_zp;zam_np;zam_sp;zam_ip;zam_pn;zam_up;zam_gf;zam_rf;fir_zp;fir_np;fir_sp;fir_ip;fir_pn;fir_up;fir_gf;fir_rf;zam_zm;pm_doh;pm_maj;np_soc;pm1;pm2;pm3;pm4;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer ORDER BY pm");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->pm.";".$riadok->nzpm.";".$riadok->prpm.";".$riadok->zam_zp.";".$riadok->zam_np.";".$riadok->zam_sp.";".$riadok->zam_ip.";".$riadok->zam_pn.";".$riadok->zam_up.";".$riadok->zam_gf.";".$riadok->zam_rf.";".$riadok->fir_zp.";".$riadok->fir_np.";".$riadok->fir_sp.";".$riadok->fir_ip.";".$riadok->fir_pn.";".$riadok->fir_up.";".$riadok->fir_gf.";".$riadok->fir_rf.";".$riadok->zam_zm.";".$riadok->pm_doh.";".$riadok->pm_maj.";".$riadok->np_soc.";".$riadok->pm1.";".$riadok->pm2.";".$riadok->pm3.";".$riadok->pm4.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }




  $text = "316;##########Tabulka F$kli_vxcf"."_mzddss"."\r\n";
  fwrite($soubor, $text);
  $text = "0;cdss;ndss;uceb;numb;iban;vsy;ksy;ssy;anl;pz1;pz2;pz3;pz4;pz5;pt1;pt2;pt3;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddss ORDER BY cdss");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->cdss.";".$riadok->ndss.";".$riadok->uceb.";".$riadok->numb.";".$riadok->iban.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->anl.";".$riadok->pz1.";".$riadok->pz2.";".$riadok->pz3.";".$riadok->pz4.";".$riadok->pz5.";".$riadok->pt1.";".$riadok->pt2.";".$riadok->pt3.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }




  $text = "317;##########Tabulka F$kli_vxcf"."_mzducty"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ucty;ucf_zp;ucf_np;ucf_sp;ucf_ip;ucf_pn;ucf_up;ucf_gf;ucf_rf;ucp_zp;ucp_np;ucp_sp;ucp_ip;ucp_pn;ucp_up;ucp_gf;ucp_rf;ucz_zp;ucz_np;ucz_sp;ucz_ip;ucz_pn;ucz_up;ucz_gf;ucz_rf;ucm_soc;ucd_soc;puc_zam;puc_kon;ucm_ddpf;ucm_dovo;ucm_dovm;ucd_ddpf;cfuct;konxuc;"."\r\n";
fwrite($soubor, $text);
$vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzducty ");
while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ucty.";".$riadok->ucf_zp.";".$riadok->ucf_np.";".$riadok->ucf_sp.";".$riadok->ucf_ip.";".$riadok->ucf_pn.";".$riadok->ucf_up.";".$riadok->ucf_gf.";".$riadok->ucf_rf.";".$riadok->ucp_zp.";".$riadok->ucp_np.";".$riadok->ucp_sp.";".$riadok->ucp_ip.";".$riadok->ucp_pn.";".$riadok->ucp_up.";".$riadok->ucp_gf.";".$riadok->ucp_rf.";".$riadok->ucz_zp.";".$riadok->ucz_np.";".$riadok->ucz_sp.";".$riadok->ucz_ip.";".$riadok->ucz_pn.";".$riadok->ucz_up.";".$riadok->ucz_gf.";".$riadok->ucz_rf.";".$riadok->ucm_soc.";".$riadok->ucd_soc.";".$riadok->puc_zam.";".$riadok->puc_kon.";".$riadok->ucm_ddpf.";".$riadok->ucm_dovo.";".$riadok->ucm_dovm.";".$riadok->ucd_ddpf.";".$riadok->cfuct.";".$riadok->konxuc;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "318;##########Tabulka F$kli_vxcf"."_zdravpois"."\r\n";
  fwrite($soubor, $text);
  $text = "0;zdrv;nzdr;uceb;numb;iban;vsy;ksy;ssy;anl;pz1;pz2;pz3;pz4;pz5;pt1;pt2;pt3;datm"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois ORDER BY zdrv");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->zdrv.";".$riadok->nzdr.";".$riadok->uceb.";".$riadok->numb.";".$riadok->iban.";".$riadok->vsy.";".$riadok->ksy.";".$riadok->ssy.";".$riadok->anl.";".$riadok->pz1.";".$riadok->pz2.";".$riadok->pz3.";".$riadok->pz4.";".$riadok->pz5.";".$riadok->pt1.";".$riadok->pt2.";".$riadok->pt3.";".$riadok->datm;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }






                                     }

//mzdevidencny,vyhlaseniedane,mzdpotvrdeniefo,rocneziadost,mzdrocnedane,mzdpotvrdenienemd,mzdpotvrdenienezd,mzdpotvrdeniezp
//tu ked nebudes mat data v tabulkach zavolaj
if( $copern == 17 OR $copern == 10 ) {



  $text = "319;##########Tabulka F$kli_vxcf"."_mzdevidencny"."\r\n";
  fwrite($soubor, $text);
  $text = "0;oc;kr01;kr02;kr03;kr04;kr05;kr06;kr07;kr08;kr09;kr10;kr11;kr12;kr13;zp01;zp02;zp03;zp04;zp05;zp06;zp07;zp08;zp09;zp10;zp11;zp12;zp13;dp01;dp02;dp03;dp04;dp05;dp06;dp07;dp08;dp09;dp10;dp11;dp12;dp13;dk01;dk02;dk03;dk04;dk05;dk06;dk07;dk08;dk09;dk10;dk11;dk12;dk13;vz01;vz02;vz03;vz04;vz05;vz06;vz07;vz08;vz09;vz10;vz11;vz12;vz13;vv01;vv02;vv03;vv04;vv05;vv06;vv07;vv08;vv09;vv10;vv11;vv12;vv13;kd01;kd02;kd03;kd04;kd05;kd06;kd07;kd08;kd09;kd10;kd11;kd12;kd13;konx;pozn;str2;datum"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdevidencny ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->oc.";".$riadok->kr01.";".$riadok->kr02.";".$riadok->kr03.";".$riadok->kr04.";".$riadok->kr05.";".$riadok->kr06.";".$riadok->kr07.";".$riadok->kr08.";".$riadok->kr09.";".$riadok->kr10.";".$riadok->kr11.";".$riadok->kr12.";".$riadok->kr13.";".$riadok->zp01.";".$riadok->zp02.";".$riadok->zp03.";".$riadok->zp04.";".$riadok->zp05.";".$riadok->zp06.";".$riadok->zp07.";".$riadok->zp08.";".$riadok->zp09.";".$riadok->zp10.";".$riadok->zp11.";".$riadok->zp12.";".$riadok->zp13.";".$riadok->dp01.";".$riadok->dp02.";".$riadok->dp03.";".$riadok->dp04.";".$riadok->dp05.";".$riadok->dp06.";".$riadok->dp07.";".$riadok->dp08.";".$riadok->dp09.";".$riadok->dp10.";".$riadok->dp11.";".$riadok->dp12.";".$riadok->dp13.";".$riadok->dk01.";".$riadok->dk02.";".$riadok->dk03.";".$riadok->dk04.";".$riadok->dk05.";".$riadok->dk06.";".$riadok->dk07.";".$riadok->dk08.";".$riadok->dk09.";".$riadok->dk10.";".$riadok->dk11.";".$riadok->dk12.";".$riadok->dk13.";".$riadok->vz01.";".$riadok->vz02.";".$riadok->vz03.";".$riadok->vz04.";".$riadok->vz05.";".$riadok->vz06.";".$riadok->vz07.";".$riadok->vz08.";".$riadok->vz09.";".$riadok->vz10.";".$riadok->vz11.";".$riadok->vz12.";".$riadok->vz13.";".$riadok->vv01.";".$riadok->vv02.";".$riadok->vv03.";".$riadok->vv04.";".$riadok->vv05.";".$riadok->vv06.";".$riadok->vv07.";".$riadok->vv08.";".$riadok->vv09.";".$riadok->vv10.";".$riadok->vv11.";".$riadok->vv12.";".$riadok->vv13.";".$riadok->kd01.";".$riadok->kd02.";".$riadok->kd03.";".$riadok->kd04.";".$riadok->kd05.";".$riadok->kd06.";".$riadok->kd07.";".$riadok->kd08.";".$riadok->kd09.";".$riadok->kd10.";".$riadok->kd11.";".$riadok->kd12.";".$riadok->kd13.";".$riadok->konx.";".urlencode($riadok->pozn).";".$riadok->str2.";".$riadok->datum;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }



  $text = "320;##########Tabulka F$kli_vxcf"."_vyhlaseniedane"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;oc;rdstav;pracov;manzel;mannar;manadr;manpsc;manzam;ineuda;nezd;bonus;m1det01;m1nar01;m1det02;m1nar02;m1det03;m1nar03;m1det04;m1nar04;m1det05;m1nar05;m2det01;m2nar01;m2det02;m2nar02;m2det03;m2nar03;m2det04;m2nar04;m2det05;m2nar05;m3det01;m3nar01;m3det02;m3nar02;m3det03;m3nar03;m3det04;m3nar04;m3det05;m3nar05;docx;ostat;datum;pozn;str2;konx"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_vyhlaseniedane ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->oc.";".$riadok->rdstav.";".$riadok->pracov.";".$riadok->manzel.";".$riadok->mannar.";".$riadok->manadr.";".$riadok->manpsc.";".$riadok->manzam.";".$riadok->ineuda.";".$riadok->nezd.";".$riadok->bonus.";".$riadok->m1det01.";".$riadok->m1nar01.";".$riadok->m1det02.";".$riadok->m1nar02.";".$riadok->m1det03.";".$riadok->m1nar03.";".$riadok->m1det04.";".$riadok->m1nar04.";".$riadok->m1det05.";".$riadok->m1nar05.";".$riadok->m2det01.";".$riadok->m2nar01.";".$riadok->m2det02.";".$riadok->m2nar02.";".$riadok->m2det03.";".$riadok->m2nar03.";".$riadok->m2det04.";".$riadok->m2nar04.";".$riadok->m2det05.";".$riadok->m2nar05.";".$riadok->m3det01.";".$riadok->m3nar01.";".$riadok->m3det02.";".$riadok->m3nar02.";".$riadok->m3det03.";".$riadok->m3nar03.";".$riadok->m3det04.";".$riadok->m3nar04.";".$riadok->m3det05.";".$riadok->m3nar05.";".$riadok->docx.";".$riadok->ostat.";".$riadok->datum.";".urlencode($riadok->pozn).";".$riadok->str2.";".$riadok->konx;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }


  $text = "321;##########Tabulka F$kli_vxcf"."_mzdpotvrdeniefo"."\r\n";
  fwrite($soubor, $text);
  $text = "0;oc;r01;r02;r03a;r03b;r04;r05;r06mes;r06sum;r07;r07det1;r07det2;r07det3;r07det4;r07det5;r07det6;r07mes1;r07mes2;r07mes3;r07mes4;r07mes5;r07mes6;r07sum1;r07sum2;r07sum3;r07sum4;r07sum5;r07sum6;r08;r09;r10;r11;r12a;r12b;r13;konx;pozn;konx1;m01pp;m02pp;m03pp;m04pp;m05pp;m06pp;m07pp;m08pp;m09pp;m10pp;m11pp;m12pp;m13pp;m01dh;m02dh;m03dh;m04dh;m05dh;m06dh;m07dh;m08dh;m09dh;m10dh;m11dh;m12dh;m13dh;podpa;podpn;prija;prijn;konx3;datv"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpotvrdeniefo ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->oc.";".$riadok->r01.";".$riadok->r02.";".$riadok->r03a.";".$riadok->r03b.";".$riadok->r04.";".$riadok->r05.";".$riadok->r06mes.";".$riadok->r06sum.";".$riadok->r07.";".$riadok->r07det1.";".$riadok->r07det2.";".$riadok->r07det3.";".$riadok->r07det4.";".$riadok->r07det5.";".$riadok->r07det6.";".$riadok->r07mes1.";".$riadok->r07mes2.";".$riadok->r07mes3.";".$riadok->r07mes4.";".$riadok->r07mes5.";".$riadok->r07mes6.";".$riadok->r07sum1.";".$riadok->r07sum2.";".$riadok->r07sum3.";".$riadok->r07sum4.";".$riadok->r07sum5.";".$riadok->r07sum6.";".$riadok->r08.";".$riadok->r09.";".$riadok->r10.";".$riadok->r11.";".$riadok->r12a.";".$riadok->r12b.";".$riadok->r13.";".$riadok->konx.";".urlencode($riadok->pozn).";".$riadok->konx1.";".$riadok->m01pp.";".$riadok->m02pp.";".$riadok->m03pp.";".$riadok->m04pp.";".$riadok->m05pp.";".$riadok->m06pp.";".$riadok->m07pp.";".$riadok->m08pp.";".$riadok->m09pp.";".$riadok->m10pp.";".$riadok->m11pp.";".$riadok->m12pp.";".$riadok->m13pp.";".$riadok->m01dh.";".$riadok->m02dh.";".$riadok->m03dh.";".$riadok->m04dh.";".$riadok->m05dh.";".$riadok->m06dh.";".$riadok->m07dh.";".$riadok->m08dh.";".$riadok->m09dh.";".$riadok->m10dh.";".$riadok->m11dh.";".$riadok->m12dh.";".$riadok->m13dh.";".$riadok->podpa.";".$riadok->podpn.";".$riadok->prija.";".$riadok->prijn.";".$riadok->konx3.";".$riadok->datv;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  } 

  $text = "322;##########Tabulka F$kli_vxcf"."_rocneziadost"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;oc;rdstav;pracov;manzel;mannar;manadr;manpsc;manzam;ineuda;nezd;bonus;m1det01;m1nar01;m1det02;m1nar02;m1det03;m1nar03;m1det04;m1nar04;m1det05;m1nar05;m2det01;m2nar01;m2det02;m2nar02;m2det03;m2nar03;m2det04;m2nar04;m2det05;m2nar05;m3det01;m3nar01;m3det02;m3nar02;m3det03;m3nar03;m3det04;m3nar04;m3det05;m3nar05;docx;ostat;datum;pozn;str2;konx;ziad3;ziad3eur;prisk;ziad5;ziad6;ziad6eur;ziad6b;ziad6beur;vzdeleur;manobd;manpes;maneur;docobd;doceur;ziv1eur;ziv2eur;ziv3eur;ziad9"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_rocneziadost ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->oc.";".$riadok->rdstav.";".$riadok->pracov.";".$riadok->manzel.";".$riadok->mannar.";".$riadok->manadr.";".$riadok->manpsc.";".$riadok->manzam.";".$riadok->ineuda.";".$riadok->nezd.";".$riadok->bonus.";".$riadok->m1det01.";".$riadok->m1nar01.";".$riadok->m1det02.";".$riadok->m1nar02.";".$riadok->m1det03.";".$riadok->m1nar03.";".$riadok->m1det04.";".$riadok->m1nar04.";".$riadok->m1det05.";".$riadok->m1nar05.";".$riadok->m2det01.";".$riadok->m2nar01.";".$riadok->m2det02.";".$riadok->m2nar02.";".$riadok->m2det03.";".$riadok->m2nar03.";".$riadok->m2det04.";".$riadok->m2nar04.";".$riadok->m2det05.";".$riadok->m2nar05.";".$riadok->m3det01.";".$riadok->m3nar01.";".$riadok->m3det02.";".$riadok->m3nar02.";".$riadok->m3det03.";".$riadok->m3nar03.";".$riadok->m3det04.";".$riadok->m3nar04.";".$riadok->m3det05.";".$riadok->m3nar05.";".$riadok->docx.";".$riadok->ostat.";".$riadok->datum.";".urlencode($riadok->pozn).";".$riadok->str2.";".$riadok->konx.";".$riadok->ziad3.";".$riadok->ziad3eur.";".$riadok->prisk.";".$riadok->ziad5.";".$riadok->ziad6.";".$riadok->ziad6eur.";".$riadok->ziad6b.";".$riadok->ziad6beur.";".$riadok->vzdeleur.";".$riadok->manobd.";".$riadok->manpes.";".$riadok->maneur.";".$riadok->docobd.";".$riadok->doceur.";".$riadok->ziv1eur.";".$riadok->ziv2eur.";".$riadok->ziv3eur.";".$riadok->ziad9;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }   

  $text = "323;##########Tabulka F$kli_vxcf"."_mzdrocnedane"."\r\n";
  fwrite($soubor, $text);
  $text = "0;oc;vyk;r00;r00z1;r00z2;r00a;r00a1;r00a2;r00b;r01;r02;r03;konx1;r04;r04a;r04a1;r04a2;r04b;r04c;r04c1;r04c2;r04d;r04e;r04f;r04x;konx2;r05;r06;r07;r08;r09;r10;konx3;r11;r11a;r11b;r12;r13;r14;r14a;r14b;r15;r15a;r15b;r16;r17;r18;r18n;r18p;konx4;pozn;da2;da21;da22;da23;da24;da25;d11;d12;d13;d14;d15;d16;d17;z11;z12;z13;z14;z15;z16;z17;po6;px2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdrocnedane ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->oc.";".$riadok->vyk.";".$riadok->r00.";".$riadok->r00z1.";".$riadok->r00z2.";".$riadok->r00a.";".$riadok->r00a1.";".$riadok->r00a2.";".$riadok->r00b.";".$riadok->r01.";".$riadok->r02.";".$riadok->r03.";".$riadok->konx1.";".$riadok->r04.";".$riadok->r04a.";".$riadok->r04a1.";".$riadok->r04a2.";".$riadok->r04b.";".$riadok->r04c.";".$riadok->r04c1.";".$riadok->r04c2.";".$riadok->r04d.";".$riadok->r04e.";".$riadok->r04f.";".$riadok->r04x.";".$riadok->konx2.";".$riadok->r05.";".$riadok->r06.";".$riadok->r07.";".$riadok->r08.";".$riadok->r09.";".$riadok->r10.";".$riadok->konx3.";".$riadok->r11.";".$riadok->r11a.";".$riadok->r11b.";".$riadok->r12.";".$riadok->r13.";".$riadok->r14.";".$riadok->r14a.";".$riadok->r14b.";".$riadok->r15.";".$riadok->r15a.";".$riadok->r15b.";".$riadok->r16.";".$riadok->r17.";".$riadok->r18.";".$riadok->r18n.";".$riadok->r18p.";".$riadok->konx4.";".urlencode($riadok->pozn).";".$riadok->da2.";".$riadok->da21.";".$riadok->da22.";".$riadok->da23.";".$riadok->da24.";".$riadok->da25.";".$riadok->d11.";".$riadok->d12.";".$riadok->d13.";".$riadok->d14.";".$riadok->d15.";".$riadok->d16.";".$riadok->d17.";".$riadok->z11.";".$riadok->z12.";".$riadok->z13.";".$riadok->z14.";".$riadok->z15.";".$riadok->z16.";".$riadok->z17.";".$riadok->po6.";".$riadok->px2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  


  $text = "324;##########Tabulka F$kli_vxcf"."_mzdpotvrdenienemd"."\r\n";
  fwrite($soubor, $text);
  $text = "0;oc;rdstav;uzemie;napprc;preod1;predo1;predv1;preod2;predo2;predv2;preod3;predo3;predv3;preod4;predo4;predv4;fe101;text51;text52;text53;vz01;vz02;vz03;vz04;vz05;vz06;vz07;vz08;vz09;vz10;vz11;vz12;vzspolu;vo01;vo02;vo03;vo04;vo05;vo06;vo07;vo08;vo09;vo10;vo11;vo12;vzodhad;konx;pozn;str2"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienemd ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->oc.";".$riadok->rdstav.";".$riadok->uzemie.";".$riadok->napprc.";".$riadok->preod1.";".$riadok->predo1.";".$riadok->predv1.";".$riadok->preod2.";".$riadok->predo2.";".$riadok->predv2.";".$riadok->preod3.";".$riadok->predo3.";".$riadok->predv3.";".$riadok->preod4.";".$riadok->predo4.";".$riadok->predv4.";".$riadok->fe101.";".$riadok->text51.";".$riadok->text52.";".$riadok->text53.";".$riadok->vz01.";".$riadok->vz02.";".$riadok->vz03.";".$riadok->vz04.";".$riadok->vz05.";".$riadok->vz06.";".$riadok->vz07.";".$riadok->vz08.";".$riadok->vz09.";".$riadok->vz10.";".$riadok->vz11.";".$riadok->vz12.";".$riadok->vzspolu.";".$riadok->vo01.";".$riadok->vo02.";".$riadok->vo03.";".$riadok->vo04.";".$riadok->vo05.";".$riadok->vo06.";".$riadok->vo07.";".$riadok->vo08.";".$riadok->vo09.";".$riadok->vo10.";".$riadok->vo11.";".$riadok->vo12.";".$riadok->vzodhad.";".$riadok->konx.";".urlencode($riadok->pozn).";".$riadok->str2;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  




  $text = "325;##########Tabulka F$kli_vxcf"."_mzdpotvrdenienezd"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;oc;urcity;starobny;predcas;invalid;preod1;predo1;predv1;predni1;preod2;predo2;predv2;predni2;preod3;predo3;predv3;predni3;vylod1;vyldo1;vyldv1;vyldni1;vylod2;vyldo2;vyldv2;vyldni2;vylod3;vyldo3;vyldv3;vyldni3;vylod4;vyldo4;vyldv4;vyldni4;vylod5;vyldo5;vyldv5;vyldni5;vyl2od1;vyl2do1;vyl2dv1;vyl2dni1;vyl2od2;vyl2do2;vyl2dv2;vyl2dni2;vyl2od3;vyl2do3;vyl2dv3;vyl2dni3;vyl2od4;vyl2do4;vyl2dv4;vyl2dni4;vyl2od5;vyl2do5;vyl2dv5;vyl2dni5;vyl3od1;vyl3do1;vyl3dv1;vyl3dni1;vyl3od2;vyl3do2;vyl3dv2;vyl3dni2;vyl3od3;vyl3do3;vyl3dv3;vyl3dni3;vyl3od4;vyl3do4;vyl3dv4;vyl3dni4;vyl3od5;vyl3do5;vyl3dv5;vyl3dni5;vymz;vz01;vz02;vz03;vz04;vz05;vz06;vz07;vz08;vz09;vz10;vz11;vz12;vz13;vo1b01;vo1b02;vo1b03;vo1b04;vo1b05;vo1b06;vo1b07;vo1b08;vo1b09;vo1b10;vo1b11;vo1b12;vo1b13;vo2b01;vo2b02;vo2b03;vo2b04;vo2b05;vo2b06;vo2b07;vo2b08;vo2b09;vo2b10;vo2b11;vo2b12;vo2b13;vo3b01;vo3b02;vo3b03;vo3b04;vo3b05;vo3b06;vo3b07;vo3b08;vo3b09;vo3b10;vo3b11;vo3b12;vo3b13;konx;por1;vzv1;ost1;exe1;prs1;por2;vzv2;ost2;exe2;prs2;por3;vzv3;ost3;exe3;prs3;datum;pozn;str2;invaldo;datod"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpotvrdenienezd ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->oc.";".$riadok->urcity.";".$riadok->starobny.";".$riadok->predcas.";".$riadok->invalid.";".$riadok->preod1.";".$riadok->predo1.";".$riadok->predv1.";".$riadok->predni1.";".$riadok->preod2.";".$riadok->predo2.";".$riadok->predv2.";".$riadok->predni2.";".$riadok->preod3.";".$riadok->predo3.";".$riadok->predv3.";".$riadok->predni3.";".$riadok->vylod1.";".$riadok->vyldo1.";".$riadok->vyldv1.";".$riadok->vyldni1.";".$riadok->vylod2.";".$riadok->vyldo2.";".$riadok->vyldv2.";".$riadok->vyldni2.";".$riadok->vylod3.";".$riadok->vyldo3.";".$riadok->vyldv3.";".$riadok->vyldni3.";".$riadok->vylod4.";".$riadok->vyldo4.";".$riadok->vyldv4.";".$riadok->vyldni4.";".$riadok->vylod5.";".$riadok->vyldo5.";".$riadok->vyldv5.";".$riadok->vyldni5.";".$riadok->vyl2od1.";".$riadok->vyl2do1.";".$riadok->vyl2dv1.";".$riadok->vyl2dni1.";".$riadok->vyl2od2.";".$riadok->vyl2do2.";".$riadok->vyl2dv2.";".$riadok->vyl2dni2.";".$riadok->vyl2od3.";".$riadok->vyl2do3.";".$riadok->vyl2dv3.";".$riadok->vyl2dni3.";".$riadok->vyl2od4.";".$riadok->vyl2do4.";".$riadok->vyl2dv4.";".$riadok->vyl2dni4.";".$riadok->vyl2od5.";".$riadok->vyl2do5.";".$riadok->vyl2dv5.";".$riadok->vyl2dni5.";".$riadok->vyl3od1.";".$riadok->vyl3do1.";".$riadok->vyl3dv1.";".$riadok->vyl3dni1.";".$riadok->vyl3od2.";".$riadok->vyl3do2.";".$riadok->vyl3dv2.";".$riadok->vyl3dni2.";".$riadok->vyl3od3.";".$riadok->vyl3do3.";".$riadok->vyl3dv3.";".$riadok->vyl3dni3.";".$riadok->vyl3od4.";".$riadok->vyl3do4.";".$riadok->vyl3dv4.";".$riadok->vyl3dni4.";".$riadok->vyl3od5.";".$riadok->vyl3do5.";".$riadok->vyl3dv5.";".$riadok->vyl3dni5.";".$riadok->vymz.";".$riadok->vz01.";".$riadok->vz02.";".$riadok->vz03.";".$riadok->vz04.";".$riadok->vz05.";".$riadok->vz06.";".$riadok->vz07.";".$riadok->vz08.";".$riadok->vz09.";".$riadok->vz10.";".$riadok->vz11.";".$riadok->vz12.";".$riadok->vz13.";".$riadok->vo1b01.";".$riadok->vo1b02.";".$riadok->vo1b03.";".$riadok->vo1b04.";".$riadok->vo1b05.";".$riadok->vo1b06.";".$riadok->vo1b07.";".$riadok->vo1b08.";".$riadok->vo1b09.";".$riadok->vo1b10.";".$riadok->vo1b11.";".$riadok->vo1b12.";".$riadok->vo1b13.";".$riadok->vo2b01.";".$riadok->vo2b02.";".$riadok->vo2b03.";".$riadok->vo2b04.";".$riadok->vo2b05.";".$riadok->vo2b06.";".$riadok->vo2b07.";".$riadok->vo2b08.";".$riadok->vo2b09.";".$riadok->vo2b10.";".$riadok->vo2b11.";".$riadok->vo2b12.";".$riadok->vo2b13.";".$riadok->vo3b01.";".$riadok->vo3b02.";".$riadok->vo3b03.";".$riadok->vo3b04.";".$riadok->vo3b05.";".$riadok->vo3b06.";".$riadok->vo3b07.";".$riadok->vo3b08.";".$riadok->vo3b09.";".$riadok->vo3b10.";".$riadok->vo3b11.";".$riadok->vo3b12.";".$riadok->vo3b13.";".$riadok->konx.";".$riadok->por1.";".$riadok->vzv1.";".$riadok->ost1.";".$riadok->exe1.";".$riadok->prs1.";".$riadok->por2.";".$riadok->vzv2.";".$riadok->ost2.";".$riadok->exe2.";".$riadok->prs2.";".$riadok->por3.";".$riadok->vzv3.";".$riadok->ost3.";".$riadok->exe3.";".$riadok->prs3.";".$riadok->datum.";".urlencode($riadok->pozn).";".$riadok->str2.";".$riadok->invaldo.";".$riadok->datod;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }  



  $text = "326;##########Tabulka F$kli_vxcf"."_mzdpotvrdeniezp"."\r\n";
  fwrite($soubor, $text);
  $text = "0;ume;oc;xzdrav;nebolzp;bolzp;bolzp01;bolzp02;bolzp03;bolzp04;bolzp05;bolzp06;bolzp07;bolzp08;bolzp09;bolzp10;bolzp11;bolzp12;zamod;zamdo;prijmy;zamnec;zamtel;minz;vymz;mz01;mz02;mz03;mz04;mz05;mz06;mz07;mz08;mz09;mz10;mz11;mz12;mz13;vz01;vz02;vz03;vz04;vz05;vz06;vz07;vz08;vz09;vz10;vz11;vz12;vz13;platistat;pozn;str2;konx;pod01;pdo01;ptx01;pod02;pdo02;ptx02;pod03;pdo03;ptx03;pod04;pdo04;ptx04;pod05;pdo05;ptx05;pod06;pdo06;ptx06;pod07;pdo07;ptx07;pod08;pdo08;ptx08;pod09;pdo09;ptx09;pod10;pdo10;ptx10;pod11;pdo11;ptx11;pod12;pdo12;ptx12;pod13;pdo13;ptx13;pod14;pdo14;ptx14;pod15;pdo15;ptx15;datum;priloh"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpotvrdeniezp ORDER BY oc");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->ume.";".$riadok->oc.";".$riadok->xzdrav.";".$riadok->nebolzp.";".$riadok->bolzp.";".$riadok->bolzp01.";".$riadok->bolzp02.";".$riadok->bolzp03.";".$riadok->bolzp04.";".$riadok->bolzp05.";".$riadok->bolzp06.";".$riadok->bolzp07.";".$riadok->bolzp08.";".$riadok->bolzp09.";".$riadok->bolzp10.";".$riadok->bolzp11.";".$riadok->bolzp12.";".$riadok->zamod.";".$riadok->zamdo.";".$riadok->prijmy.";".$riadok->zamnec.";".$riadok->zamtel.";".$riadok->minz.";".$riadok->vymz.";".$riadok->mz01.";".$riadok->mz02.";".$riadok->mz03.";".$riadok->mz04.";".$riadok->mz05.";".$riadok->mz06.";".$riadok->mz07.";".$riadok->mz08.";".$riadok->mz09.";".$riadok->mz10.";".$riadok->mz11.";".$riadok->mz12.";".$riadok->mz13.";".$riadok->vz01.";".$riadok->vz02.";".$riadok->vz03.";".$riadok->vz04.";".$riadok->vz05.";".$riadok->vz06.";".$riadok->vz07.";".$riadok->vz08.";".$riadok->vz09.";".$riadok->vz10.";".$riadok->vz11.";".$riadok->vz12.";".$riadok->vz13.";".$riadok->platistat.";".urlencode($riadok->pozn).";".$riadok->str2.";".$riadok->konx.";".$riadok->pod01.";".$riadok->pdo01.";".$riadok->ptx01.";".$riadok->pod02.";".$riadok->pdo02.";".$riadok->ptx02.";".$riadok->pod03.";".$riadok->pdo03.";".$riadok->ptx03.";".$riadok->pod04.";".$riadok->pdo04.";".$riadok->ptx04.";".$riadok->pod05.";".$riadok->pdo05.";".$riadok->ptx05.";".$riadok->pod06.";".$riadok->pdo06.";".$riadok->ptx06.";".$riadok->pod07.";".$riadok->pdo07.";".$riadok->ptx07.";".$riadok->pod08.";".$riadok->pdo08.";".$riadok->ptx08.";".$riadok->pod09.";".$riadok->pdo09.";".$riadok->ptx09.";".$riadok->pod10.";".$riadok->pdo10.";".$riadok->ptx10.";".$riadok->pod11.";".$riadok->pdo11.";".$riadok->ptx11.";".$riadok->pod12.";".$riadok->pdo12.";".$riadok->ptx12.";".$riadok->pod13.";".$riadok->pdo13.";".$riadok->ptx13.";".$riadok->pod14.";".$riadok->pdo14.";".$riadok->ptx14.";".$riadok->pod15.";".$riadok->pdo15.";".$riadok->ptx15.";".$riadok->datum.";".$riadok->priloh;

  $text = $text."\r\n";
  fwrite($soubor, $text);
  }   


  $text = "327;##########Tabulka F$kli_vxcf"."_treximaoc"."\r\n";
  fwrite($soubor, $text);
  $text = "0;psys;idec;zamest;vzdelanie;tartrieda;typzmluvy;pracovisko;bydlisko;zakon;stprisl;miesto;ico;stvrtrok;skisco08;pracpozicia;postihnutie;odborvzdelania"."\r\n";
  fwrite($soubor, $text);
  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_treximaoc ORDER BY idec");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = "1";

  $text = $text.";".$riadok->psys.";".$riadok->idec.";".$riadok->zamest.";".$riadok->vzdelanie
.";".$riadok->tartrieda.";".$riadok->typzmluvy.";".$riadok->pracovisko.";".$riadok->bydlisko.";".$riadok->zakon
.";".$riadok->stprisl.";".$riadok->miesto.";".$riadok->ico.";".$riadok->stvrtrok.";".$riadok->skisco08
.";".$riadok->pracpozicia.";".$riadok->postihnutie.";".$riadok->odborvzdelania;

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
