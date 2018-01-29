<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'VYR';
$urov = 2000;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvvyr";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../vyroba/vtvvyr.php");
endif;

$vtvsek = include("../vyroba/vtvsekov.php");

$citfir = include("../cis/citaj_fir.php");

$citvyr = include("../vyroba/citaj_vyr.php");

//tlacove okno
$tlcuwin="width=850, height=' + vyskawin + ', top=0, left=50, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$cislo_zak = 1*strip_tags($_REQUEST['cislo_zak']);
$cislo_slu = 1*strip_tags($_REQUEST['cislo_slu']);
$nazov_slu = strip_tags($_REQUEST['nazov_slu']);
$cislo_crcp = 1*strip_tags($_REQUEST['cislo_crcp']);

//echo $nazov_slu;

$h_cslu = 1*strip_tags($_REQUEST['h_cslu']);
$h_popis = strip_tags($_REQUEST['h_popis']);
$h_roza = 1*strip_tags($_REQUEST['h_roza']);
$h_rozb = 1*strip_tags($_REQUEST['h_rozb']);
$h_nosn = 1*strip_tags($_REQUEST['h_nosn']);
$h_rozp = 1*strip_tags($_REQUEST['h_rozp']);
$h_oko = 1*strip_tags($_REQUEST['h_oko']);
$h_lem = 1*strip_tags($_REQUEST['h_lem']);
$h_mno = 1*strip_tags($_REQUEST['h_mno']);
$h_pozn = strip_tags($_REQUEST['h_pozn']);
$h_dpm = 1*strip_tags($_REQUEST['h_dpm']);
$h_cnm = 1*strip_tags($_REQUEST['h_cnm']);
$h_cpm = 1*strip_tags($_REQUEST['h_cpm']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_zink = strip_tags($_REQUEST['h_zink']);
$h_farb = strip_tags($_REQUEST['h_farb']);
$uprav = strip_tags($_REQUEST['uprav']);
$h_cszd = strip_tags($_REQUEST['h_cszd']);

if( $copern == 2 )
     {
$sql = "ALTER TABLE F$kli_vxcf"."_vyrseknosny MODIFY nosn int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyrsekrozper MODIFY rozp int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyrsekoko MODIFY oko int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_vyrseklem MODIFY lem int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

     }

//pristup podla prihlasenia
if( $fir_xvr01 == 1 )
     {
//echo "idem";

$nemapristup=0;
if( $copern >= 1   AND $vyr_xmodzak != 1 ) { $nemapristup=1; }


//takto zakazem pristup
if( $nemapristup == 1 )
{
$zakazvyr=1;
$citvyr = include("../vyroba/citaj_vyr.php");
exit;
}

     }
//koniec pristup podla prihlasenia


//vymazanie vyrobku
if ( $copern == 116 )
    {
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);
$cislo_slu = strip_tags($_REQUEST['cislo_slu']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrzakpol WHERE zak='$cislo_zak' AND slu='$cislo_slu' "); 

//zmazat aj z ciselnika automaticky generovane
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_dopsluzby WHERE zakv='$cislo_zak' AND slu='$cislo_slu' AND slu > 19999 AND slu < 990000001 "); 

//zmazat aj z receptur automaticky generovane
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrrcph WHERE crcp='$cislo_slu' AND crcp > 19999 "); 

//zmazat aj z receptur automaticky generovane
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrrcpp WHERE crcp='$cislo_slu' AND crcp > 19999 "); 

//zmazat aj z priradenie receptur automaticky generovane
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrrcpvyr WHERE crcp='$cislo_slu' AND slu='$cislo_slu' AND crcp > 19999 "); 

//zmazat aj z modelov automaticky generovane
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrsekmodel WHERE zak='$cislo_zak' AND slu='$cislo_slu' AND slu > 19999 "); 

$copern=2;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania vyrobku

//zapis modelu do databazy , zapis vyrobku do dslu a zapis receptury do recepty
if ( $copern == 3 )
{
$maxslu=0;
$sqlzak = mysql_query("SELECT slu FROM F$kli_vxcf"."_dopsluzby WHERE ( zakv = $cislo_zak AND slu > 19999 ) ORDER BY slu DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $maxslu=$riadzak->slu;
  }

$novemax=$maxslu+1;
if( $maxslu == 0 ) $novemax=$cislo_zak*10000+1;

$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekvyr WHERE cslu = $h_cslu ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $cslu_naz=$riadzak->nslu;
  }


$x_slu=$novemax;
$x_nsl=$x_slu." ".$cslu_naz;
if( $h_popis != '' ) $x_nsl=$x_slu." ".$h_popis;
$h_cdm=$h_cpm+($h_cpm*($h_dpm/100));
$nosn_naz="";
$rozp_naz="";
$oko_naz="";
$lem_naz="";
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrseknosny WHERE nosn = $h_nosn ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $nosn_naz=$riadzak->nnsn;
  }
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekrozper WHERE rozp = $h_rozp ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $rozp_naz=$riadzak->nrzp;
  }
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekoko WHERE oko = $h_oko ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $oko_naz=$riadzak->noko;
  }
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrseklem WHERE lem = $h_lem ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $lem_naz=$riadzak->nlem;
  }

$x_nslp="mm: ".$h_roza." x ".$h_rozb." "." np:".$nosn_naz." "."rp:".$rozp_naz." "."oko:".$oko_naz." "."lem:".$lem_naz." ".$h_pozn;
if( $h_roza == 0 AND $h_rozb == 0 ) { $x_nslp=$h_pozn; }


$sqult = "INSERT INTO F$kli_vxcf"."_dopsluzby ( slu,nsl,dph,cep,ced,mer,zakv,strv,nslp )".
" VALUES ( '$x_slu', '$x_nsl', '$h_dpm', '$h_cpm',".
" '$h_cdm', '$h_mer', '$cislo_zak', '$fir_dopstr', '$x_nslp' ); "; 
$ulozene = mysql_query("$sqult"); 

$ulozttt = "INSERT INTO F$kli_vxcf"."_vyrzakpol ( zak,slu,cepv,cedv,mnov,id )".
" VALUES ('$cislo_zak', '$x_slu', '$h_cpm', '$h_cdm', '$h_mno', '$kli_uzid'); "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_vyrrcph ( crcp,nrcp,drcp,prcp ) VALUES ('$x_slu', '$x_nsl', 1, '$h_cszd'); "); 

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_vyrrcpvyr ( slu,cis,pa1,pa2,crcp ) VALUES ('$x_slu', '$x_slu', 4, 0, '$x_slu'); "); 


$sqult = "INSERT INTO F$kli_vxcf"."_vyrsekmodel ( zak,slu,cslu,roza,rozb,nosn,rozp,oko,lem,mnoz,pozn,id,dpm,cnm,cpm,mjm,zink,farb,popis )".
" VALUES ( '$cislo_zak', '$x_slu', '$h_cslu', '$h_roza', '$h_rozb', '$h_nosn', '$h_rozp',".
" '$h_oko', '$h_lem', '$h_mno', '$h_pozn', '$kli_uzid', '$h_dpm', '$h_cnm', '$h_cpm', '$h_mer', '$h_zink', '$h_farb', '$h_popis' ); "; 
$ulozene = mysql_query("$sqult"); 


$cislo_slu=$x_slu;
$cislo_crcp=$x_slu;
//$h_mno='';
}
//koniec zapis model,vyrobok,recept

//uprava zapisaneho modelu do databazy , zapis vyrobku do dslu a zapis receptury do recepty
if ( $copern == 33 )
{

$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekvyr WHERE cslu = $h_cslu ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $cslu_naz=$riadzak->nslu;
  }

$x_slu=$cislo_slu;
$x_nsl=$x_slu." ".$cslu_naz;
if( $h_popis != '' ) $x_nsl=$x_slu." ".$h_popis;
//echo $x_nsl;
$h_cdm=$h_cpm+($h_cpm*($h_dpm/100));
$nosn_naz="";
$rozp_naz="";
$oko_naz="";
$lem_naz="";
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrseknosny WHERE nosn = $h_nosn ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $nosn_naz=$riadzak->nnsn;
  }
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekrozper WHERE rozp = $h_rozp ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $rozp_naz=$riadzak->nrzp;
  }
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekoko WHERE oko = $h_oko ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $oko_naz=$riadzak->noko;
  }
$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrseklem WHERE lem = $h_lem ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $lem_naz=$riadzak->nlem;
  }


$x_nslp="mm: ".$h_roza." x ".$h_rozb." "." np:".$nosn_naz." "."rp:".$rozp_naz." "."oko:".$oko_naz." "."lem:".$lem_naz." ".$h_pozn;
if( $h_roza == 0 AND $h_rozb == 0 ) { $x_nslp=$h_pozn; }

$sqtz = "UPDATE F$kli_vxcf"."_dopsluzby SET nsl='$x_nsl', cep='$h_cpm', ced='$h_cdm', nslp='$x_nslp', mer='$h_mer' WHERE slu='$x_slu'";
$upravene = mysql_query("$sqtz");

$sqtz = "UPDATE F$kli_vxcf"."_vyrzakpol SET mnov='$h_mno', cepv='$h_cpm', cedv='$h_cdm'  WHERE zak = '$cislo_zak' AND slu='$x_slu'";
$upravene = mysql_query("$sqtz");

$sqtz = "UPDATE F$kli_vxcf"."_vyrrcph SET nrcp='$x_nsl' WHERE crcp='$x_slu'";
$upravene = mysql_query("$sqtz");

$sqtz = "UPDATE F$kli_vxcf"."_vyrsekmodel SET cslu='$h_cslu', roza='$h_roza', rozb='$h_rozb', nosn='$h_nosn', rozp='$h_rozp', mjm='$h_mer',".
" oko='$h_oko', lem='$h_lem', mnoz='$h_mno', pozn='$h_pozn', id='$kli_uzid', cpm='$h_cpm',".
" zink='$h_zink', farb='$h_farb', popis='$h_popis' WHERE zak = '$cislo_zak' AND slu='$x_slu'";
//echo $sqtz;
$upravene = mysql_query("$sqtz");

$cislo_slu=$x_slu;
$cislo_crcp=$x_slu;
//$h_mno='';
}
//koniec uprava zapisaneho  model,vyrobok,recept

//1=uprava ak uz existuje
if ( $copern == 1 )
      {

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrsekmodel WHERE zak = $cislo_zak AND slu = $cislo_slu  ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_crcp = $riadok->crcp;

$h_cslu = 1*$riadok->cslu;
$cislo_slu = 1*$riadok->slu;
$h_roza = 1*$riadok->roza;
$h_popis = $riadok->popis;
$h_rozb = 1*$riadok->rozb;
$h_nosn = 1*$riadok->nosn;
$h_rozp = 1*$riadok->rozp;
$h_oko = 1*$riadok->oko;
$h_lem = 1*$riadok->lem;
$h_mno = 1*$riadok->mnoz;
$h_pozn = $riadok->pozn;
$h_dpm = 1*$riadok->dpm;
$h_cnm = 1*$riadok->cnm;
$h_cpm = 1*$riadok->cpm;
$h_mer = $riadok->mjm;
$h_zink = $riadok->zink;
$h_farb = $riadok->farb;
  }
       }
//koniec uprava nacitanie

//vymazanie druhu vyrobku
if ( $copern == 216 )
    {
$cislo_cslu = strip_tags($_REQUEST['cislo_cslu']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrsekvyr WHERE cslu='$cislo_cslu' "); 

$copern=208;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania druhu vyrobku

//ulozenie noveho druhu vyrobku
if ( $copern == 215 AND $uprav != 1 )
    {
$h_cslu = strip_tags($_REQUEST['h_cslu']);
$h_nslu = strip_tags($_REQUEST['h_nslu']);

$ulozttt = "INSERT INTO F$kli_vxcf"."_vyrsekvyr ( nslu ) VALUES ( '$h_nslu' ); "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=208;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia druhov vyrobku


//uprava druhu vyrobku
if ( $copern == 215 AND $uprav == 1 )
    {
$cislo_cslu = 1*strip_tags($_REQUEST['cislo_cslu']);
$uprav_cslu = 1*strip_tags($_REQUEST['uprav_cslu']);
$h_cslu = strip_tags($_REQUEST['h_cslu']);
$h_nslu = strip_tags($_REQUEST['h_nslu']);
$h_vpi1 = strip_tags($_REQUEST['h_vpi1']);
$h_vpi2 = strip_tags($_REQUEST['h_vpi2']);
$h_vpd1 = strip_tags($_REQUEST['h_vpd1']);
$h_vpd2 = strip_tags($_REQUEST['h_vpd2']);
$h_vpt1 = strip_tags($_REQUEST['h_vpt1']);

$ulozttt = "UPDATE F$kli_vxcf"."_vyrsekvyr SET nslu='$h_nslu', vpi1='$h_vpi1', vpi2='$h_vpi2', ".
" vpd1='$h_vpd1', vpd2='$h_vpd2', vpt1='$h_vpt1' WHERE cslu='$uprav_cslu' "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=208;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava druhov vyrobku

//vymazanie nosneho
if ( $copern == 316 )
    {
$cislo_nosn = strip_tags($_REQUEST['cislo_nosn']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrseknosny WHERE nosn='$cislo_nosn' "); 

$copern=308;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania nosneho

//ulozenie noveho nosneho
if ( $copern == 315 AND $uprav != 1 )
    {
$h_nosn = strip_tags($_REQUEST['h_nosn']);
$h_nnsn = strip_tags($_REQUEST['h_nnsn']);
$h_nsir = strip_tags($_REQUEST['h_nsir']);
$h_nhru = strip_tags($_REQUEST['h_nhru']);
$h_npd1 = strip_tags($_REQUEST['h_npd1']);
$h_npd2 = strip_tags($_REQUEST['h_npd2']);
$h_npt1 = strip_tags($_REQUEST['h_npt1']);

$ulozttt = "INSERT INTO F$kli_vxcf"."_vyrseknosny ( nnsn,nsir,nhru,npd1,npd2,npt1 ) ".
" VALUES ( '$h_nnsn', '$h_nsir' , '$h_nhru' , '$h_npd1' , '$h_npd2' , '$h_npt1'  ); "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;

if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia nosneho

//uprava nosneho
if ( $copern == 315 AND $uprav == 1 )
    {
$cislo_nosn = 1*strip_tags($_REQUEST['cislo_nosn']);
$uprav_nosn = 1*strip_tags($_REQUEST['uprav_nosn']);
$h_nosn = strip_tags($_REQUEST['h_nosn']);
$h_nnsn = strip_tags($_REQUEST['h_nnsn']);
$h_nsir = strip_tags($_REQUEST['h_nsir']);
$h_nhru = strip_tags($_REQUEST['h_nhru']);
$h_npd1 = strip_tags($_REQUEST['h_npd1']);
$h_npd2 = strip_tags($_REQUEST['h_npd2']);
$h_npt1 = strip_tags($_REQUEST['h_npt1']);

$ulozttt = "UPDATE F$kli_vxcf"."_vyrseknosny SET nnsn='$h_nnsn', nsir='$h_nsir', nhru='$h_nhru', ".
" npd1='$h_npd1', npd2='$h_npd2', npt1='$h_npt1' WHERE nosn='$uprav_nosn' "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava nosneho

//vymazanie rozperneho
if ( $copern == 416 )
    {
$cislo_rozp = strip_tags($_REQUEST['cislo_rozp']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrsekrozper WHERE rozp='$cislo_rozp' "); 

$copern=408;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania rozperneho

//ulozenie noveho rozperneho
if ( $copern == 415 AND $uprav != 1 )
    {
$h_rozp = strip_tags($_REQUEST['h_rozp']);
$h_nrzp = strip_tags($_REQUEST['h_nrzp']);
$h_rsir = strip_tags($_REQUEST['h_rsir']);
$h_rhru = strip_tags($_REQUEST['h_rhru']);
$h_rpd1 = strip_tags($_REQUEST['h_rpd1']);
$h_rpd2 = strip_tags($_REQUEST['h_rpd2']);
$h_rpt1 = strip_tags($_REQUEST['h_rpt1']);

$ulozttt = "INSERT INTO F$kli_vxcf"."_vyrsekrozper ( nrzp,rsir,rhru,rpd1,rpd2,rpt1 ) ".
"VALUES ( '$h_nrzp', '$h_rsir' , '$h_rhru' , '$h_rpd1' , '$h_rpd2' , '$h_rpt1'  ); "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=408;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia rozperneho

//uprava rozperneho
if ( $copern == 415 AND $uprav == 1 )
    {
$cislo_rozp = 1*strip_tags($_REQUEST['cislo_rozp']);
$uprav_rozp = 1*strip_tags($_REQUEST['uprav_rozp']);
$h_rozp = strip_tags($_REQUEST['h_rozp']);
$h_nrzp = strip_tags($_REQUEST['h_nrzp']);
$h_rsir = strip_tags($_REQUEST['h_rsir']);
$h_rhru = strip_tags($_REQUEST['h_rhru']);
$h_rpd1 = strip_tags($_REQUEST['h_rpd1']);
$h_rpd2 = strip_tags($_REQUEST['h_rpd2']);
$h_rpt1 = strip_tags($_REQUEST['h_rpt1']);

$ulozttt = "UPDATE F$kli_vxcf"."_vyrsekrozper SET nrzp='$h_nrzp', rsir='$h_rsir', rhru='$h_rhru', ".
" rpd1='$h_rpd1', rpd2='$h_rpd2', rpt1='$h_rpt1' WHERE rozp='$uprav_rozp' "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=408;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava rozperneho

//vymazanie oko
if ( $copern == 516 )
    {
$cislo_oko = strip_tags($_REQUEST['cislo_oko']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrsekoko WHERE oko='$cislo_oko' "); 

$copern=508;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania oko

//ulozenie noveho oko
if ( $copern == 515 AND $uprav != 1 )
    {
$h_oko = strip_tags($_REQUEST['h_oko']);
$h_noko = strip_tags($_REQUEST['h_noko']);
$h_okoa = strip_tags($_REQUEST['h_okoa']);
$h_okob = strip_tags($_REQUEST['h_okob']);
$h_opd1 = strip_tags($_REQUEST['h_opd1']);
$h_opd2 = strip_tags($_REQUEST['h_opd2']);
$h_opt1 = strip_tags($_REQUEST['h_opt1']);

$ulozttt = "INSERT INTO F$kli_vxcf"."_vyrsekoko ( noko,okoa,okob,opd1,opd2,opt1  ) ".
"VALUES ( '$h_noko', '$h_okoa' , '$h_okob' , '$h_opd1' , '$h_opd2' , '$h_opt1'  ); "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=508;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia oko

//uprava oko
if ( $copern == 515 AND $uprav == 1 )
    {
$cislo_oko = 1*strip_tags($_REQUEST['cislo_oko']);
$uprav_oko = 1*strip_tags($_REQUEST['uprav_oko']);
$h_noko = strip_tags($_REQUEST['h_noko']);
$h_okoa = strip_tags($_REQUEST['h_okoa']);
$h_okob = strip_tags($_REQUEST['h_okob']);
$h_opd1 = strip_tags($_REQUEST['h_opd1']);
$h_opd2 = strip_tags($_REQUEST['h_opd2']);
$h_opt1 = strip_tags($_REQUEST['h_opt1']);

$ulozttt = "UPDATE F$kli_vxcf"."_vyrsekoko SET noko='$h_noko', okoa='$h_okoa', okob='$h_okob', ".
" opd1='$h_opd1', opd2='$h_opd2', opt1='$h_opt1' WHERE oko='$uprav_oko' "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=508;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava oko

//vymazanie lem
if ( $copern == 616 )
    {
$cislo_lem = strip_tags($_REQUEST['cislo_lem']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrseklem WHERE lem='$cislo_lem' "); 

$copern=608;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania lem

//ulozenie noveho lemu
if ( $copern == 615 AND $uprav != 1 )
    {
$h_lem = strip_tags($_REQUEST['h_lem']);
$h_nlem = strip_tags($_REQUEST['h_nlem']);
$h_lsir = strip_tags($_REQUEST['h_lsir']);
$h_lhru = strip_tags($_REQUEST['h_lhru']);
$h_lmat = strip_tags($_REQUEST['h_lmat']);
$h_lpd1 = strip_tags($_REQUEST['h_lpd1']);
$h_lpd2 = strip_tags($_REQUEST['h_lpd2']);
$h_lpt1 = strip_tags($_REQUEST['h_lpt1']);

$ulozttt = "INSERT INTO F$kli_vxcf"."_vyrseklem ( nlem,lsir,lhru,lmat,lpd1,lpd2,lpt1  ) ".
"VALUES ( '$h_nlem', '$h_lsir' , '$h_lhru' , '$h_lmat' , '$h_lpd1', '$l_npd2' , '$h_lpt1'  ); "; 
$ulozene = mysql_query("$ulozttt"); 
$copern=608;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia lem

//uprava lemu
if ( $copern == 615 AND $uprav == 1 )
    {
$cislo_lem = 1*strip_tags($_REQUEST['cislo_lem']);
$uprav_lem = 1*strip_tags($_REQUEST['uprav_lem']);
$h_lem = strip_tags($_REQUEST['h_lem']);
$h_nlem = strip_tags($_REQUEST['h_nlem']);
$h_lsir = strip_tags($_REQUEST['h_lsir']);
$h_lhru = strip_tags($_REQUEST['h_lhru']);
$h_lmat = strip_tags($_REQUEST['h_lmat']);
$h_lpd1 = strip_tags($_REQUEST['h_lpd1']);
$h_lpd2 = strip_tags($_REQUEST['h_lpd2']);
$h_lpt1 = strip_tags($_REQUEST['h_lpt1']);

$ulozttt = "UPDATE F$kli_vxcf"."_vyrseklem SET nlem='$h_nlem', lsir='$h_lsir', lhru='$h_lhru', lmat='$h_lmat', ".
" lpd1='$h_lpd1', lpd2='$h_lpd2', lpt1='$h_lpt1' WHERE lem='$uprav_lem' "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=608;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava lem

//208=uprava ak uz existuje
if ( $copern == 208 AND $uprav == 1 )
      {
$cislo_cslu = 1*strip_tags($_REQUEST['cislo_cslu']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrsekvyr WHERE cslu = $cislo_cslu  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_nslu = $riadok->nslu;
$h_vpi1 = $riadok->vpi1;
$h_vpi2 = $riadok->vpi2;
$h_vpd1 = $riadok->vpd1;
$h_vpd2 = $riadok->vpd2;
$h_vpt1 = $riadok->vpt1;
  }
       }

//koniec uprava nacitanie

//308=uprava ak uz existuje
if ( $copern == 308 AND $uprav == 1 )
      {
$cislo_nosn = 1*strip_tags($_REQUEST['cislo_nosn']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrseknosny WHERE nosn = $cislo_nosn  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_nnsn = $riadok->nnsn;
$h_nsir = $riadok->nsir;
$h_nhru = $riadok->nhru;
$h_npd1 = $riadok->npd1;
$h_npd2 = $riadok->npd2;
$h_npt1 = $riadok->npt1;
  }
       }

//koniec uprava nacitanie


//408=uprava ak uz existuje
if ( $copern == 408 AND $uprav == 1 )
      {
$cislo_rozp = 1*strip_tags($_REQUEST['cislo_rozp']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrsekrozper WHERE rozp = $cislo_rozp  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_nrzp = $riadok->nrzp;
$h_rsir = $riadok->rsir;
$h_rhru = $riadok->rhru;
$h_rpd1 = $riadok->rpd1;
$h_rpd2 = $riadok->rpd2;
$h_rpt1 = $riadok->rpt1;
  }
       }
//koniec uprava nacitanie

//508=uprava ak uz existuje
if ( $copern == 508 AND $uprav == 1 )
      {
$cislo_oko = 1*strip_tags($_REQUEST['cislo_oko']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrsekoko WHERE oko = $cislo_oko  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_noko = $riadok->noko;
$h_okoa = $riadok->okoa;
$h_okob = $riadok->okob;
$h_opd1 = $riadok->opd1;
$h_opd2 = $riadok->opd2;
$h_opt1 = $riadok->opt1;
  }
       }
//koniec uprava nacitanie

//608=uprava ak uz existuje
if ( $copern == 608 AND $uprav == 1 )
      {
$cislo_lem = 1*strip_tags($_REQUEST['cislo_lem']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrseklem WHERE lem = $cislo_lem  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_nlem = $riadok->nlem;
$h_lmat = $riadok->lmat;
$h_lsir = $riadok->lsir;
$h_lhru = $riadok->lhru;
$h_lpd1 = $riadok->lpd1;
$h_lpt1 = $riadok->lpt1;
  }
       }
//koniec uprava nacitanie

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Modelovanie v˝robku - V˝robn˝ prÌkaz</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>

<?php
if ( $copern < 100 )
{
?>
<script type="text/javascript" src="vyr_vyberzak_xml.js"></script>
<?php
}
?>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

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




<?php
//vyrobky
  if ( $copern < 100 )
  {
?>

function CsluEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms1.h_popis.focus();
        document.forms1.h_popis.select();
              }
                }

function PopisEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_roza.focus();
        document.forms1.h_roza.select();
              }
                }

function RozaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms1.h_cslu.value == 1 ) { document.forms1.h_zink.checked = "checked"; }
        document.forms1.h_rozb.focus();
        document.forms1.h_rozb.select();
              }
                }

function RozbEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_nosn.focus();
              }
                }

function NosnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_rozp.focus();
              }
                }

function RozpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_oko.focus();
              }
                }


function OkoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_lem.focus();
              }
                }


function LemEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_mno.focus();
        document.forms1.h_mno.select();
              }
                }

function CnmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_dpm.value = '<?php echo $fir_dph2; ?>';
        document.forms1.h_dpm.focus();
        document.forms1.h_dpm.select();
              }
                }

function DpmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_dpm.value = '<?php echo $fir_dph2; ?>';
        document.forms1.h_cpm.focus();
        document.forms1.h_cpm.select();
              }
                }


function MnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_dpm.value = '<?php echo $fir_dph2; ?>';
        if( document.forms1.h_mer.value == "" ) {  document.forms1.h_mer.value = 'ks'; }
        document.forms1.h_mer.focus();
        document.forms1.h_mer.select();
              }
                }

function MerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_dpm.value = '<?php echo $fir_dph2; ?>';
        document.forms1.h_cpm.focus();
        document.forms1.h_cpm.select();
              }
                }

function CpmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_pozn.focus();
        document.forms1.h_pozn.select();
              }
                }


function PoznEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms1.h_pozn.focus();
              }
                }

function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

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
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

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
function vykonajSaldo(zak,nza,obj,prm1,prm2,prm3,prm4)
                {
        document.forms.forms1.h_ico.value = zak;
        document.forms.forms1.h_nai.value = nza;
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
//        urobVyrSaldo(<?php echo $drupoh; ?>);
        mySaldoelement.style.display='';
                }


function Len1Saldo()
                    {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
//        urobVyrSaldo(<?php echo $drupoh; ?>);
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
    document.forms1.h_cslu.focus();
    document.forms1.uloz.disabled = true;
    document.forms1.h_dpm.value = '<?php echo $fir_dph2; ?>';
    }

    function ObnovUI()
    {
    <?php if( $copern == 1 OR $copern == 3 OR $copern == 33 ) { ?>
    document.forms1.h_cslu.value = '<?php echo "$h_cslu";?>';
    document.forms1.h_popis.value = '<?php echo "$h_popis";?>';
    document.forms1.h_roza.value = '<?php echo "$h_roza";?>';
    document.forms1.h_rozb.value = '<?php echo "$h_rozb";?>';
    document.forms1.h_nosn.value = '<?php echo "$h_nosn";?>';
    document.forms1.h_rozp.value = '<?php echo "$h_rozp";?>';
    document.forms1.h_oko.value = '<?php echo "$h_oko";?>';
    document.forms1.h_lem.value = '<?php echo "$h_lem";?>';
    document.forms1.h_mno.value = '<?php echo "$h_mno";?>';
    document.forms1.h_pozn.value = '<?php echo "$h_pozn";?>';
    document.forms1.h_dpm.value = '<?php echo $fir_dph2; ?>';
    document.forms1.h_cpm.value = '<?php echo "$h_cpm";?>';
    document.forms1.h_cnm.value = '<?php echo "$h_cnm";?>';
    document.forms1.h_mer.value = '<?php echo "$h_mer";?>';
    <?php                    } ?>
    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.forms1.h_roza.value == '' ) okvstup=0;
    if ( document.forms1.h_rozb.value == '' ) okvstup=0;
    if ( document.forms1.h_mno.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.forms1.uloz.disabled = true; Fx.style.display=""; return (false); }

    }

    function nastavUce()
    {

    }

    function resetStav()
    {

    }

    function EkoVyr()
    {

    }

    function TlacPrace(zakazka)
    {
window.open('../vyroba/model_prace.php?vyroba=1&copern=1&drupoh=1&vyb_zak=' + zakazka + '&page=1', '_blank', '<?php echo $tlcswin; ?>' )
    }

    function TlacMat(zakazka)
    {
window.open('../vyroba/model_mat.php?vyroba=1&copern=1&drupoh=1&vyb_zak=' + zakazka + '&page=1', '_blank', '<?php echo $tlcswin; ?>' )
    }

    function Prepocet()
    {


    }

<?php
  }
//koniec vyrobky
?>



<?php
//ciselnik druhov vyrobkov,nosny,rozperny,oko,lem
  if ( $copern > 200 AND $copern < 699 )
  {
?>

    function VyberVstup()
    {
    <?php if ( $copern > 200 AND $copern < 299 ) { echo "document.formv1.h_nslu.focus();"; } ?>
    <?php if ( $copern > 300 AND $copern < 399 ) { echo "document.formv1.h_nsir.focus();"; } ?>
    <?php if ( $copern > 400 AND $copern < 499 ) { echo "document.formv1.h_rsir.focus();"; } ?>
    <?php if ( $copern > 500 AND $copern < 599 ) { echo "document.formv1.h_okoa.focus();"; } ?>
    <?php if ( $copern > 600 AND $copern < 699 ) { echo "document.formv1.h_lmat.focus();"; } ?>
    document.formv1.uloz.disabled = true;
    }

    function ObnovUI()
    {
    <?php if( $copern == 208 AND $uprav == 1 ) { ?>
    document.formv1.h_cslu.value = '<?php echo "$cislo_cslu";?>';
    document.formv1.h_nslu.value = '<?php echo "$h_nslu";?>';
    document.formv1.h_vpi1.value = '<?php echo "$h_vpi1";?>';
    document.formv1.h_vpi2.value = '<?php echo "$h_vpi2";?>';
    document.formv1.h_vpd1.value = '<?php echo "$h_vpd1";?>';
    document.formv1.h_vpd2.value = '<?php echo "$h_vpd2";?>';
    document.formv1.h_vpt1.value = '<?php echo "$h_vpt1";?>';
    <?php                    } ?>

    <?php if( $copern == 308 AND $uprav == 1 ) { ?>
    document.formv1.h_nosn.value = '<?php echo "$cislo_nosn";?>';
    document.formv1.h_nnsn.value = '<?php echo "$h_nnsn";?>';
    document.formv1.h_nnsnx.value = '<?php echo "$h_nnsn";?>';
    document.formv1.h_nsir.value = '<?php echo "$h_nsir";?>';
    document.formv1.h_nhru.value = '<?php echo "$h_nhru";?>';
    document.formv1.h_npd1.value = '<?php echo "$h_npd1";?>';
    document.formv1.h_npd2.value = '<?php echo "$h_npd2";?>';
    document.formv1.h_npt1.value = '<?php echo "$h_npt1";?>';
    <?php                    } ?>

    <?php if( $copern == 408 AND $uprav == 1 ) { ?>
    document.formv1.h_rozp.value = '<?php echo "$cislo_rozp";?>';
    document.formv1.h_nrzp.value = '<?php echo "$h_nrzp";?>';
    document.formv1.h_nrzpx.value = '<?php echo "$h_nrzp";?>';
    document.formv1.h_rsir.value = '<?php echo "$h_rsir";?>';
    document.formv1.h_rhru.value = '<?php echo "$h_rhru";?>';
    document.formv1.h_rpd1.value = '<?php echo "$h_rpd1";?>';
    document.formv1.h_rpd2.value = '<?php echo "$h_rpd2";?>';
    document.formv1.h_rpt1.value = '<?php echo "$h_rpt1";?>';
    <?php                    } ?>

    <?php if( $copern == 508 AND $uprav == 1 ) { ?>
    document.formv1.h_oko.value = '<?php echo "$cislo_oko";?>';
    document.formv1.h_noko.value = '<?php echo "$h_noko";?>';
    document.formv1.h_nokox.value = '<?php echo "$h_noko";?>';
    document.formv1.h_okoa.value = '<?php echo "$h_okoa";?>';
    document.formv1.h_okob.value = '<?php echo "$h_okob";?>';
    document.formv1.h_opd1.value = '<?php echo "$h_opd1";?>';
    document.formv1.h_opd2.value = '<?php echo "$h_opd2";?>';
    document.formv1.h_opt1.value = '<?php echo "$h_opt1";?>';
    <?php                    } ?>

    <?php if( $copern == 608 AND $uprav == 1 ) { ?>
    document.formv1.h_lem.value = '<?php echo "$cislo_lem";?>';
    document.formv1.h_nlem.value = '<?php echo "$h_nlem";?>';
    document.formv1.h_nlemx.value = '<?php echo "$h_nlem";?>';
    document.formv1.h_lmat.value = '<?php echo "$h_lmat";?>';
    document.formv1.h_lsir.value = '<?php echo "$h_lsir";?>';
    document.formv1.h_lhru.value = '<?php echo "$h_lhru";?>';
    document.formv1.h_lpd1.value = '<?php echo "$h_lpd1";?>';
    document.formv1.h_lpt1.value = '<?php echo "$h_lpt1";?>';
    <?php                    } ?>

    }

    function Povol_uloz()
    {
    var okvstup=1;
<?php if ( $copern > 200 AND $copern < 299 ) { ?>
    //if ( document.formv1.h_cslu.value == '' ) okvstup=0;
    if ( document.formv1.h_nslu.value == '' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 300 AND $copern < 399 ) { ?>
    //if ( document.formv1.h_nosn.value == '' ) okvstup=0;
    if ( document.formv1.h_nnsn.value == '' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 400 AND $copern < 499 ) { ?>
    //if ( document.formv1.h_rozp.value == '' ) okvstup=0;
    if ( document.formv1.h_nrzp.value == '' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 500 AND $copern < 599 ) { ?>
    //if ( document.formv1.h_oko.value == '' ) okvstup=0;
    if ( document.formv1.h_noko.value == '' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 600 AND $copern < 699 ) { ?>
    //if ( document.formv1.h_lem.value == '' ) okvstup=0;
    if ( document.formv1.h_nlem.value == '' ) okvstup=0;
<?php                                        } ?>

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false); }

    }

function NsirEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_nhru.focus();
        document.formv1.h_nhru.select();
              }
                }

function NhruEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_nnsn.value = document.formv1.h_nsir.value + " x " + document.formv1.h_nhru.value;
        document.formv1.h_nnsnx.value = document.formv1.h_nnsn.value;
        document.formv1.h_npd1.focus();
        document.formv1.h_npd1.select();
              }
                }

function Npd1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_npd1.focus();
        document.formv1.h_npd1.select();
              }
                }

function RsirEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_rhru.focus();
        document.formv1.h_rhru.select();
              }
                }

function RhruEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_nrzp.value = document.formv1.h_rsir.value + " x " + document.formv1.h_rhru.value;
        document.formv1.h_nrzpx.value = document.formv1.h_nrzp.value;
        document.formv1.h_rpd1.focus();
        document.formv1.h_rpd1.select();
              }
                }

function Rpd1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_rpd1.focus();
        document.formv1.h_rpd1.select();
              }
                }

function OkoaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_okob.focus();
        document.formv1.h_okob.select();
              }
                }

function OkobEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_noko.value = document.formv1.h_okoa.value + " x " + document.formv1.h_okob.value;
        document.formv1.h_nokox.value = document.formv1.h_noko.value;
        document.formv1.h_opd1.focus();
        document.formv1.h_opd1.select();
              }
                }

function Opd1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_opd1.focus();
        document.formv1.h_opd1.select();
              }
                }

function LmatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_lsir.focus();
        document.formv1.h_lsir.select();
              }
                }

function LsirEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_lhru.focus();
        document.formv1.h_lhru.select();
              }
                }

function LhruEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_nlem.value = document.formv1.h_lmat.value + " " + document.formv1.h_lsir.value + " x " + document.formv1.h_lhru.value;
        document.formv1.h_nlemx.value = document.formv1.h_nlem.value;
        document.formv1.h_lpd1.focus();
        document.formv1.h_lpd1.select();
              }
                }

function Lpd1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_lpd1.focus();
        document.formv1.h_lpd1.select();
              }
                }


<?php
  }
//koniec ciselnik druhov vyrobkov,nosny,rozperny,oko,lem
?>


  </script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI(); VyberVstup();" >


<table class="h2" width="100%" >
<tr>
<td>
<?php
if( $copern == 3 OR $copern == 33 ) $copern=2;

  if ( $copern == 1 ) echo "Modelovanie v˝robku - V˝robn˝ prÌkaz $cislo_slu";
  if ( $copern == 2 ) echo "Modelovanie v˝robku - NOV›";
  if ( $copern > 200 AND $copern < 299 ) echo "»ÌselnÌk druhov v˝robkov";
  if ( $copern > 300 AND $copern < 399 ) echo "»ÌselnÌk nosn˝ch prutov";
  if ( $copern > 400 AND $copern < 499 ) echo "»ÌselnÌk rozpern˝ch prutov";
  if ( $copern > 500 AND $copern < 599 ) echo "»ÌselnÌk veækosti oka";
  if ( $copern > 600 AND $copern < 699 ) echo "»ÌselnÌk lemov";
?>

<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ kladnÈ ËÌslo v rozsahu 0.01 aû 999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<?php
if( $copern == 1 OR $copern == 2 )
          {
$sqlzak = mysql_query("SELECT nza FROM F$kli_vxcf"."_zak WHERE zak = $cislo_zak ");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $nazov_zak=$riadzak->nza;
  }

$sqlslu = mysql_query("SELECT nsl FROM F$kli_vxcf"."_dopsluzby WHERE slu = $cislo_slu ");
  if (@$zaznam=mysql_data_seek($sqlslu,0))
  {
  $riadslu=mysql_fetch_object($sqlslu);
  $nazov_slu=$riadslu->nsl;
  }

?>

<div id="imgrost" style="cursor: hand; position: absolute; z-index: 200; top: 78; left: 650;">
<img src='../obr/rosty/rost1.jpg' width=200 height=80 border=0 title='V˝roba kovov˝ch roötov' >
</div>

<?php if( $copern == 1 ) { $copuloz=33; }?>
<?php if( $copern == 2 ) { $copuloz=3; }?>

<table class="fmenu" width="100%" >
<FORM name="forms1" class="obyc" method="post" action="model.php?copern=<?php echo $copuloz; ?>&cislo_zak=<?php echo $cislo_zak; ?>" >
<tr>
<td class="hmenu" colspan="1">Z·kazka<td class="hmenu" colspan="1"><?php echo $cislo_zak; ?><td class="hmenu" colspan="2"><?php echo $nazov_zak; ?>
<td class="hmenu" colspan="5" align="right">
<a href="#" onClick="window.open('../vyroba/vyrspot.php?copern=30&drupoh=1&page=1&cislo_zak=<?php echo $cislo_zak;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='V˝robnÈ n·klady a trûby za predanÈ v˝robky na z·kazke' ></a>
<a href="#" onClick="window.open('../vyroba/vyrspot.php?copern=30&drupoh=1&page=1&spo=1&cislo_zak=<?php echo $cislo_zak;?>', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Spotreba v˝robn˝ch komponentov a oper·ciÌ na z·kazke' ></a>
</tr>

<?php
if( $copern == 1 )
  {
?>
<tr>
<td class="hmenu" colspan="1">V˝robok<td class="hmenu" colspan="1"><?php echo $cislo_slu; ?><td class="hmenu" colspan="2"><?php echo $nazov_slu; ?>
</tr>
<tr>
<td class="hmenu" colspan="1">
<a href="#" onClick="window.open('../vyroba/model.php?copern=208&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
V˝robok:</a>
<td class="hmenu" colspan="2">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekvyr ORDER BY cslu");
?>
<select class="hvstup" size="1" name="h_cslu" id="h_cslu" onKeyDown="return CsluEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cslu"];?>" >
<?php echo $zaznam["nslu"];?></option>
<?php endwhile;?>
</select>
<input class="hvstup" type="hidden" name="cislo_slu" id="cislo_slu" value="<?php echo $cislo_slu;?>" />
</tr>
<?php
  }
?>

<?php
if( $copern == 2 )
  {
?>
<tr>
<td class="hmenu" colspan="1">
<a href="#" onClick="window.open('../vyroba/model.php?copern=208&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
V˝robok:</a>
<td class="hmenu" colspan="2">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekvyr ORDER BY cslu");
?>
<select class="hvstup" size="1" name="h_cslu" id="h_cslu" onKeyDown="return CsluEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cslu"];?>" >
<?php echo $zaznam["nslu"];?></option>
<?php endwhile;?>
</select>
</tr>
<?php
  }
?>

<tr>
<td class="hmenu" >Popis:
<td class="hmenu" colspan="3">
<input type="text" name="h_popis" id="h_popis" size="60" maxlength="40"
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return PopisEnter(event.which)"/>
</tr>


<tr>
<td class="hmenu" width="15%">
<td class="hmenu" width="15%">
<td class="hmenu" width="15%">
<td class="hmenu" width="15%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
<td class="hmenu" width="10%">
</tr>
<tr>
<td class="hmenu" >Rozmery AxB:
<td class="hmenu" >
<input type="text" name="h_roza" id="h_roza" size="10" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return RozaEnter(event.which)" onchange="return intg(this,0,999999,Cele,document.forms1.err_roza)" 
 onkeyup="KontrolaCisla(this, Cele)"/>A mm
<INPUT type="hidden" name="err_roza" value="0">
<td class="hmenu" >
<input type="text" name="h_rozb" id="h_rozb" size="10" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return RozbEnter(event.which)" onchange="return intg(this,0,999999,Cele,document.forms1.err_rozb)" 
 onkeyup="KontrolaCisla(this, Cele)"/>B mm
<INPUT type="hidden" name="err_rozb" value="0">
</tr>

<tr>
<td class="hmenu" colspan="1">
<a href="#" onClick="window.open('../vyroba/model.php?copern=308&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
Nosn˝ prut:</a>
<td class="hmenu" colspan="1">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrseknosny ORDER BY nosn");
?>
<select class="hvstup" size="1" name="h_nosn" id="h_nosn" onKeyDown="return NosnEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["nosn"];?>" >
<?php echo $zaznam["nnsn"];?></option>
<?php endwhile;?>
</select>
</tr>

<tr>
<td class="hmenu" colspan="1">
<a href="#" onClick="window.open('../vyroba/model.php?copern=408&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
Rozpern˝ prut:</a>
<td class="hmenu" colspan="1">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekrozper ORDER BY rozp");
?>
<select class="hvstup" size="1" name="h_rozp" id="h_rozp" onKeyDown="return RozpEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["rozp"];?>" >
<?php echo $zaznam["nrzp"];?></option>
<?php endwhile;?>
</select>
</tr>

<tr>
<td class="hmenu" colspan="1">
<a href="#" onClick="window.open('../vyroba/model.php?copern=508&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
Oko:</a>
<td class="hmenu" colspan="1">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrsekoko ORDER BY oko");
?>
<select class="hvstup" size="1" name="h_oko" id="h_oko" onKeyDown="return OkoEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["oko"];?>" >
<?php echo $zaznam["noko"];?></option>
<?php endwhile;?>
</select>
</tr>

<tr>
<td class="hmenu" colspan="1">
<a href="#" onClick="window.open('../vyroba/model.php?copern=608&drupoh=1&page=1', '_blank', '<?php echo $tlcuwin; ?>' )">
Lem:</a>
<td class="hmenu" colspan="1">
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrseklem ORDER BY lem");
?>
<select class="hvstup" size="1" name="h_lem" id="h_lem" onKeyDown="return LemEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["lem"];?>" >
<?php echo $zaznam["nlem"];?></option>
<?php endwhile;?>
</select>

<td class="hmenu" >Zinok:
<input type="checkbox" name="h_zink" value="1"  />
<?php
if ( $h_zink == 1 )
   {
?>
<script type="text/javascript">
document.forms1.h_zink.checked = "checked";
</script>
<?php
   }
?>
<td class="hmenu" >Farba:
<input type="checkbox" name="h_farb" value="1"  />
<?php
if ( $h_farb == 1 )
   {
?>
<script type="text/javascript">
document.forms1.h_farb.checked = "checked";
</script>
<?php
   }
?>
<td class="hmenu" >V˝robn· cena:
<td class="hmenu" colspan="1">
<input type="text" name="h_cnm" id="h_cnm" size="10" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return CnmEnter(event.which)"/>

<td class="hmenu" >Sadzba DPH:
<td class="hmenu" colspan="1">
<input type="text" name="h_dpm" id="h_dpm" size="6" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return DpmEnter(event.which)"/>
</tr>

<tr>
<td class="hmenu" >Mnoûstvo:
<td class="hmenu" colspan="1">
<input type="text" name="h_mno" id="h_mno" size="6" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return MnoEnter(event.which)" onchange="return intg(this,0,999999,Cele,document.forms1.err_mno)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_mno" value="0">
<input type="text" name="h_mer" id="h_mer" size="3" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return MerEnter(event.which)"/>
</tr>

<tr>
<td class="hmenu" >Predajn· cena:
<td class="hmenu" colspan="1">
<input type="text" name="h_cpm" id="h_cpm" size="10" 
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return CpmEnter(event.which)" onchange="return cele(this,0.00,999999,Desc,2,document.forms1.err_cpm)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_cpm" value="0"></td>

<td class="hmenu" colspan="3">Coln˝ sadzobnÌk:
<input type="text" name="h_cszd" id="h_cszd" size="8" maxlength="8" value="7314"/>
</tr>

<tr>
<td class="hmenu" >Pozn·mka:
<td class="hmenu" colspan="3">
<input type="text" name="h_pozn" id="h_pozn" size="60" maxlength="40"
onclick=" mySaldoelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return PoznEnter(event.which)"/>

</tr>

<tr>
<td class="hmenu">
<td class="hmenu">
<td class="hmenu">
<td class="hmenu">
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</FORM>
<FORM name="forms2" class="obyc" method="post" action="model.php?copern=2&cislo_zak=<?php echo $cislo_zak; ?>" >
<td class="hmenu">
<?php
if ( $copern == 1 )
     {
?>
<INPUT type="submit" name="npol" id="npol" value="Nov˝" >
<?php
     }
?>
</td>
</FORM>
</tr>

</table>

<div id="mySaldoelement"></div>
<div id="Okno"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som z·kazku podæa zadan˝ch podmienok, sk˙ste znovu</span>

<?php
// vypis vyrobky v model
$cislo_zak = strip_tags($_REQUEST['cislo_zak']);

$sqltt = "SELECT F$kli_vxcf"."_vyrzakpol.slu,cepv,cedv,mnov,F$kli_vxcf"."_dopsluzby.nsl,F$kli_vxcf"."_dopsluzby.dph,F$kli_vxcf"."_dopsluzby.mer,".
" F$kli_vxcf"."_vyrrcpvyr.crcp,F$kli_vxcf"."_vyrrcph.nrcp, nslp, prcp".
" FROM F$kli_vxcf"."_vyrzakpol".
" LEFT JOIN F$kli_vxcf"."_dopsluzby".
" ON F$kli_vxcf"."_vyrzakpol.slu=F$kli_vxcf"."_dopsluzby.slu".
" LEFT JOIN F$kli_vxcf"."_vyrrcpvyr".
" ON F$kli_vxcf"."_vyrzakpol.slu=F$kli_vxcf"."_vyrrcpvyr.slu".
" LEFT JOIN F$kli_vxcf"."_vyrrcph".
" ON F$kli_vxcf"."_vyrrcpvyr.crcp=F$kli_vxcf"."_vyrrcph.crcp".
" WHERE zak = $cislo_zak ORDER BY F$kli_vxcf"."_vyrzakpol.slu DESC";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" colspan="7" >
<a href="#" onClick="TlacPrace(<?php echo $cislo_zak; ?>)">
<img src='../obr/tlac.png' width=20 height=20 border=0 title='VytlaËiù Pr·ce na z·kazke' ></a>
<a href="#" onClick="TlacMat(<?php echo $cislo_zak; ?>)">
<img src='../obr/tlac.png' width=20 height=20 border=0 title='VytlaËiù Materi·l na z·kazke' ></a>

<td class="hmenu" colspan="1" >
<a href="#" onClick="window.open('dopzak.php?copern=108&cislo_zak=<?php echo $cislo_zak;?>',
 '_self' )"> <img src='../obr/zoznam.png' width=15 height=15 border=0 title="Zoznam v˝robkov" ></a>
</tr>
<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="35%" >N·zov
<td class="hmenu" width="5%" >DPH
<td class="hmenu" width="10%" >CenaBezDPH
<td class="hmenu" width="10%" >CenaSDPH
<td class="hmenu" width="5%" >MJ
<td class="hmenu" width="10%" >Mnoûstvo
<th class="hmenu" width="5%" >Zmaû
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>

<?php
$colsadz=trim($riadok->prcp);
$colsadzc=1*$colsadz;

if( $colsadzc > 1 AND $riadok->nslp == '' )
{
$riadok->nslp=" ";
}
?>

<?php
if( $riadok->nslp != '' )
{
$pole = explode("NP:", $riadok->nslp);
$rozmer=$pole[0];
$ostat=$pole[1];
?>
<tr>
<td class="fmenV" colspan="7" >&nbsp;<?php echo $riadok->nslp;?>

<?php
if( $colsadzc > 1 )
{
?>
SCS <?php echo $colsadz; ?> - prenos DP
<?php
}
?>

</td>
</tr>
<?php
}
?>

<tr>
<td class="fmenu" ><?php echo $riadok->slu;?></td>
<td class="fmenu" >
<?php
  if ( $riadok->crcp > 0 )
  {
?>
<a href="#" onClick="window.open('../vyroba/model.php?copern=1&drupoh=1&page=1&cislo_slu=<?php echo $riadok->slu;?>
&cislo_zak=<?php echo $cislo_zak;?>&nazov_slu=<?php echo $riadok->nsl;?>&cislo_crcp=<?php echo $riadok->crcp;?>', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/naradie.png' width=15 height=15 border=0 
 title='Modelovanie v˝robku ËÌslo <?php echo $riadok->slu;?>, Recept˙ra <?php echo $riadok->crcp;?> <?php echo $riadok->nrcp;?> ' ></a>

<a href="#" onClick="window.open('recepty.php?copern=108&cislo_crcp=<?php echo $riadok->crcp; ?>', '_blank',
 'width=850, height=' + vyskawin + ', top=0, left=50, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
 <img src='../obr/zoznam.png' width=15 height=15 border=0 title="Upraviù Recept˙ru <?php echo $riadok->crcp;?>, zoznam komponentov" ></a>
<?php
  }
?>

<?php echo $riadok->nsl;?>
</td>
<td class="fmenu" ><?php echo $riadok->dph;?></td>
<td class="fmenu" ><?php echo $riadok->cepv;?></td>
<td class="fmenu" ><?php echo $riadok->cedv;?></td>
<td class="fmenu" ><?php echo $riadok->mer;?></td>
<td class="fmenu" ><?php echo $riadok->mnov;?></td>
<td class="fmenu" width="5%" >
<a href="#" onClick="window.open('model.php?copern=116&cislo_zak=<?php echo $cislo_zak;?>
&cislo_slu=<?php echo $riadok->slu;?>', '_self', '<?php echo $tlcswin; ?>' )">
<img src='../obr/zmaz.png' width=15 height=15 border=0  title='Vymazanie v˝robku' ></a>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
//koniec vypis vyrobkov v model
?>
<tr><td class="bmenu" ></tr>
</table>

<?php
          }
//////////////koniec copern=1a2 MODEL


// druhy vyrobkov
if ( $copern == 208 )
     {
$podmx="cslu > 0 ";
if ( $uprav == 1 ) $podmx="cslu != ".$cislo_cslu;

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrsekvyr WHERE ".$podmx." ORDER BY cslu";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="35%" >N·zov
<td class="hmenu" width="10%" >Par
<td class="hmenu" width="10%" >Par
<td class="hmenu" width="10%" >Par
<td class="hmenu" width="10%" >Par
<td class="hmenu" width="10%" >Par
<th class="hmenu" width="5%" >Edi/Del
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->cslu;?></td>
<td class="fmenu" ><?php echo $riadok->nslu;?></td>
<td class="fmenu" ><?php echo $riadok->vpi1;?></td>
<td class="fmenu" ><?php echo $riadok->vpi2;?></td>
<td class="fmenu" ><?php echo $riadok->vpd1;?></td>
<td class="fmenu" ><?php echo $riadok->vpd2;?></td>
<td class="fmenu" ><?php echo $riadok->vpt1;?></td>
<td class="fmenu" width="5%" >
<a href='model.php?copern=208&cislo_cslu=<?php echo $riadok->cslu;?>&uprav=1'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù riadok" ></a>
<?php if( $kli_uzall > 50000 ) { ?>
<a href='model.php?copern=216&cislo_cslu=<?php echo $riadok->cslu;?>&uprav=0'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
<?php                          } ?>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="model.php?copern=215&uprav=<?php echo $uprav;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_cslu" id="h_cslu" size="8" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" disabled="disabled" />
<input class="hvstup" type="hidden" name="uprav_cslu" id="uprav_cslu" value="<?php echo $cislo_cslu;?>" />

<td class="hmenu"><input type="text" name="h_nslu" id="h_nslu" size="40" 
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 

<td class="hmenu"><input type="text" name="h_vpi1" id="h_vpi1" size="8"  /> 

<td class="hmenu"><input type="text" name="h_vpi2" id="h_vpi2" size="8"  /> 

<td class="hmenu"><input type="text" name="h_vpd1" id="h_vpd1" size="8"  /> 

<td class="hmenu"><input type="text" name="h_vpd2" id="h_vpd2" size="8"  /> 

<td class="hmenu"><input type="text" name="h_vpt1" id="h_vpt1" size="10" 
 onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 

<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

</FORM>

</table>

<div id="myKompelement"></div>

<?php
     }
//koniec druhy vyrobkov


// nosne pruty
if ( $copern == 308 )
     {
$podmx="nosn > 0 ";
if ( $uprav == 1 ) $podmx="nosn != ".$cislo_nosn;

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrseknosny WHERE ".$podmx." ORDER BY nnsn";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="10%" >öÌrka
<td class="hmenu" width="10%" >hr˙bka
<td class="hmenu" width="35%" >popis
<td class="hmenu" width="10%" >kg/m
<td class="hmenu" width="10%" >Par
<td class="hmenu" width="10%" >Par
<th class="hmenu" width="5%" >Edi/Del
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->nosn;?></td>
<td class="fmenu" ><?php echo $riadok->nsir;?></td>
<td class="fmenu" ><?php echo $riadok->nhru;?></td>
<td class="fmenu" ><?php echo $riadok->nnsn;?></td>
<td class="fmenu" ><?php echo $riadok->npd1;?></td>
<td class="fmenu" ><?php echo $riadok->npd2;?></td>
<td class="fmenu" ><?php echo $riadok->npt1;?></td>
<td class="fmenu" width="5%" >
<a href='model.php?copern=308&cislo_nosn=<?php echo $riadok->nosn;?>&uprav=1'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù riadok" ></a>
<?php if( $kli_uzall > 50000 ) { ?>
<a href='model.php?copern=316&cislo_nosn=<?php echo $riadok->nosn;?>&uprav=0'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
<?php                          } ?>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="model.php?copern=315&uprav=<?php echo $uprav;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_nosn" id="h_nosn" size="8"  disabled="disabled" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" />
<input class="hvstup" type="hidden" name="uprav_nosn" id="uprav_nosn" value="<?php echo $cislo_nosn;?>" />

<td class="hmenu"><input type="text" name="h_nsir" id="h_nsir" size="8" 
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return NsirEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_nsir)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_nsir" value="0"> 

<td class="hmenu"><input type="text" name="h_nhru" id="h_nhru" size="8"
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return NhruEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_nhru)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_nhru" value="0"> 

<td class="hmenu"><input type="text" name="h_nnsnx" id="h_nnsnx" size="40" disabled="disabled"
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 
<INPUT type="hidden" name="h_nnsn" value=""> 

<td class="hmenu"><input type="text" name="h_npd1" id="h_npd1" size="8" 
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return Npd1Enter(event.which)"
 onchange="return cele(this,0.001,999999,Desc,3,document.formv1.err_npd1)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_npd1" value="0"></td>

<td class="hmenu"><input type="text" name="h_npd2" id="h_npd2" size="8" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_npt1" id="h_npt1" size="10" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

</FORM>

</table>

<div id="myKompelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span>


<?php
     }
//koniec nosnych


// rozperne pruty
if ( $copern == 408 )
     {
$podmx="rozp > 0 ";
if ( $uprav == 1 ) $podmx="rozp != ".$cislo_rozp;

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrsekrozper WHERE ".$podmx." ORDER BY nrzp";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="10%" >öÌrka
<td class="hmenu" width="10%" >hr˙bka
<td class="hmenu" width="35%" >popis
<td class="hmenu" width="10%" >kg/m
<td class="hmenu" width="10%" >Par
<td class="hmenu" width="10%" >Par
<th class="hmenu" width="5%" >Edi/Del
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->rozp;?></td>
<td class="fmenu" ><?php echo $riadok->rsir;?></td>
<td class="fmenu" ><?php echo $riadok->rhru;?></td>
<td class="fmenu" ><?php echo $riadok->nrzp;?></td>
<td class="fmenu" ><?php echo $riadok->rpd1;?></td>
<td class="fmenu" ><?php echo $riadok->rpd2;?></td>
<td class="fmenu" ><?php echo $riadok->rpt1;?></td>
<td class="fmenu" width="5%" >
<a href='model.php?copern=408&cislo_rozp=<?php echo $riadok->rozp;?>&uprav=1'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù riadok" ></a>
<?php if( $kli_uzall > 50000 ) { ?>
<a href='model.php?copern=416&cislo_rozp=<?php echo $riadok->rozp;?>&uprav=0'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
<?php                          } ?>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="model.php?copern=415&uprav=<?php echo $uprav;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_rozp" id="h_rozp" size="8"  disabled="disabled" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" />
<input class="hvstup" type="hidden" name="uprav_rozp" id="uprav_rozp" value="<?php echo $cislo_rozp;?>" />

<td class="hmenu"><input type="text" name="h_rsir" id="h_rsir" size="8" 
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return RsirEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_rsir)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_rsir" value="0"> 

<td class="hmenu"><input type="text" name="h_rhru" id="h_rhru" size="8"
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return RhruEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_rhru)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_rhru" value="0"> 

<td class="hmenu"><input type="text" name="h_nrzpx" id="h_nrzpx" size="40" disabled="disabled"
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 
<INPUT type="hidden" name="h_nrzp" value=""> 

<td class="hmenu"><input type="text" name="h_rpd1" id="h_rpd1" size="8" 
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return Rpd1Enter(event.which)"
 onchange="return cele(this,0.001,999999,Desc,3,document.formv1.err_rpd1)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_rpd1" value="0"></td>

<td class="hmenu"><input type="text" name="h_rpd2" id="h_rpd2" size="8" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_rpt1" id="h_rpt1" size="10" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

</FORM>

</table>

<div id="myKompelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span>

<?php
     }
//koniec rozperne


// oko
if ( $copern == 508 )
     {
$podmx="oko > 0 ";
if ( $uprav == 1 ) $podmx="oko != ".$cislo_oko;

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrsekoko WHERE ".$podmx." ORDER BY noko";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="10%" >rozmer A x
<td class="hmenu" width="10%" >rozmer B
<td class="hmenu" width="35%" >popis
<td class="hmenu" width="10%" >par
<td class="hmenu" width="10%" >Par
<td class="hmenu" width="10%" >Par
<th class="hmenu" width="5%" >Edi/Del
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->oko;?></td>
<td class="fmenu" ><?php echo $riadok->okoa;?></td>
<td class="fmenu" ><?php echo $riadok->okob;?></td>
<td class="fmenu" ><?php echo $riadok->noko;?></td>
<td class="fmenu" ><?php echo $riadok->opd1;?></td>
<td class="fmenu" ><?php echo $riadok->opd2;?></td>
<td class="fmenu" ><?php echo $riadok->opt1;?></td>
<td class="fmenu" width="5%" >
<a href='model.php?copern=508&cislo_oko=<?php echo $riadok->oko;?>&uprav=1'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù riadok" ></a>
<?php if( $kli_uzall > 50000 ) { ?>
<a href='model.php?copern=516&cislo_oko=<?php echo $riadok->oko;?>&uprav=0'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
<?php                          } ?>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="model.php?copern=515&uprav=<?php echo $uprav;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_oko" id="h_oko" size="8"  disabled="disabled" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" />
<input class="hvstup" type="hidden" name="uprav_oko" id="uprav_oko" value="<?php echo $cislo_oko;?>" />

<td class="hmenu"><input type="text" name="h_okoa" id="h_okoa" size="8" 
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return OkoaEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_okoa)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_okoa" value="0"> 

<td class="hmenu"><input type="text" name="h_okob" id="h_okob" size="8"
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return OkobEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_okob)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_okob" value="0"> 

<td class="hmenu"><input type="text" name="h_nokox" id="h_nokox" size="40" disabled="disabled"
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 
<INPUT type="hidden" name="h_noko" value=""> 

<td class="hmenu"><input type="text" name="h_opd1" id="h_opd1" size="8" />

<td class="hmenu"><input type="text" name="h_opd2" id="h_opd2" size="8" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_opt1" id="h_opt1" size="10" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

</FORM>

</table>

<div id="myKompelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span>

<?php
     }
//koniec oko

// lem
if ( $copern == 608 )
     {
$podmx="lem > 0 ";
if ( $uprav == 1 ) $podmx="lem != ".$cislo_lem;

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrseklem WHERE ".$podmx." ORDER BY nlem";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="10%" >P/L/U
<td class="hmenu" width="10%" >öÌrka
<td class="hmenu" width="10%" >hr˙bka
<td class="hmenu" width="35%" >popis
<td class="hmenu" width="10%" >kg/m
<td class="hmenu" width="10%" >Par
<th class="hmenu" width="5%" >Edi/Del
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->lem;?></td>
<td class="fmenu" ><?php echo $riadok->lmat;?></td>
<td class="fmenu" ><?php echo $riadok->lsir;?></td>
<td class="fmenu" ><?php echo $riadok->lhru;?></td>
<td class="fmenu" ><?php echo $riadok->nlem;?></td>
<td class="fmenu" ><?php echo $riadok->lpd1;?></td>
<td class="fmenu" ><?php echo $riadok->lpt1;?></td>
<td class="fmenu" width="5%" >
<a href='model.php?copern=608&cislo_lem=<?php echo $riadok->lem;?>&uprav=1'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù riadok" ></a>
<?php if( $kli_uzall > 50000 ) { ?>
<a href='model.php?copern=616&cislo_lem=<?php echo $riadok->lem;?>&uprav=0'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>
<?php                          } ?>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="model.php?copern=615&uprav=<?php echo $uprav;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_lem" id="h_lem" size="8"  disabled="disabled" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" />
<input class="hvstup" type="hidden" name="uprav_lem" id="uprav_lem" value="<?php echo $cislo_lem;?>" />

<td class="hmenu"><input type="text" name="h_lmat" id="h_lmat" size="3" maxlength="1"
 onKeyDown="return LmatEnter(event.which)" 

/> 

<td class="hmenu"><input type="text" name="h_lsir" id="h_lsir" size="8" 
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return LsirEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_lsir)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_lsir" value="0"> 

<td class="hmenu"><input type="text" name="h_lhru" id="h_lhru" size="8"
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return LhruEnter(event.which)" 
 onchange="return intg(this,0,999999,Cele,document.formv1.err_lhru)" 
 onkeyup="KontrolaCisla(this, Cele)"/>
<INPUT type="hidden" name="err_lhru" value="0"> 

<td class="hmenu"><input type="text" name="h_nlemx" id="h_nlemx" size="40" disabled="disabled"
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" /> 
<INPUT type="hidden" name="h_nlem" value=""> 

<td class="hmenu"><input type="text" name="h_lpd1" id="h_lpd1" size="8" 
 onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return Lpd1Enter(event.which)"
 onchange="return cele(this,0.001,999999,Desc,3,document.formv1.err_lpd1)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_lpd1" value="0"></td>

<td class="hmenu"><input type="text" name="h_lpt1" id="h_lpt1" size="10" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 


</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

</FORM>

</table>

<div id="myKompelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span>

<?php
     }
//koniec lem


// celkovy koniec dokumentu
$cislista = include("vyr_lista.php");
       } while (false);
?>
</BODY>
</HTML>
