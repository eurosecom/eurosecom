<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
// cislo operacie
$copern = strip_tags($_REQUEST['copern']);
$sys = 'SKL';
$urov = 1100;
$cslm=401100;
if( $copern == 10 ) $copern=1;
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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlctwin="width=300, height=' + vyskawin + ', top=0, left=400, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvskl";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../sklad/vtvskl.php");
endif;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

// druh pohybu 1=prijem , 2=vydaj , 3=presun
$drupoh = strip_tags($_REQUEST['drupoh']);

if( $drupoh == 1 )
{
$tabl = "sklpri";
$cov1p = "PrÌjem";
$com1p = "prÌjem";
$com4p = "prÌjmu";
$dokm1p = "prÌjemka";
$dokm4p = "prÌjemky";
$dokm2p = "prÌjemku";
$dokm4pm = "prÌjemok";
$icov1p = "Dod·vateæ";
$hladp = "Dod·vateæ - STR/Z·kazka - Pozn·mka";
$skladp = "Na sklad";
$fakv1p = "Fakt˙ra";
$skladpd = "Na sklad:";
$fakv1pd = "Fakt˙ra:";
$cisdok = "sklcpr";
$akedrp = "<= 4";
$znmskl = "+";
$znxskl = "-";
$h_sk2 = $cislo_skl;
if( $copern == 68 ) $h_sk2 = $h_skl;
$popico = "Dod·vateæ I»O:";
$popnai = "Dod·vateæ N·zov:";
$adrdok = "prijemky";
}

if( $drupoh == 2 )
{
$tabl = "sklvyd";
$cov1p = "V˝daj";
$com1p = "v˝daj";
$com4p = "v˝daja";
$dokm1p = "v˝dajka";
$dokm4p = "v˝dajky";
$dokm2p = "v˝dajku";
$dokm4pm = "v˝dajok";
$icov1p = "Odberateæ";
$hladp = "Odberateæ - STR/Z·kazka - Pozn·mka";
$skladp = "Zo skladu";
$fakv1p = "Fakt˙ra";
$skladpd = "Zo skladu:";
$fakv1pd = "Fakt˙ra:";
$cisdok = "sklcvd";
$akedrp = ">= 6";
$znmskl = "-";
$znxskl = "+";
$h_sk2 = $cislo_skl;
if( $copern == 68 ) $h_sk2 = $h_skl;
$popico = "Odberateæ I»O:";
$popnai = "Odberateæ N·zov:";
$adrdok = "vydajky";
}

if( $drupoh == 3 )
{
$tabl = "sklpre";
$cov1p = "Presun";
$com1p = "presun";
$com4p = "presunu";
$dokm1p = "presunka";
$dokm4p = "presunky";
$dokm2p = "presunku";
$dokm4pm = "presuniek";
$icov1p = "Dod·vateæ";
$hladp = "Na sklad";
$skladp = "Zo skladu";
$skladpd = "Zo skladu:";
$fakv1pd = "";
$fakv1p = "   ";
$cisdok = "sklcps";
$akedrp = "= 5";
$znmskl = "-";
$znxskl = "+";
$h_str = 0;
$h_zak = 0;
$popico = " ";
$popnai = " ";
$adrdok = "presunky";
}


$uloz="NO";
$zmaz="NO";
$uprav="NO";


//uprava cisla dokladu
if( $copern == 3618 )
{
$n_spl = $_REQUEST['n_spl'];

$cisdok = "xcpri";
if( $drupoh == 2 ) { $cisdok = "xcvyd"; }
if( $drupoh == 3 ) { $cisdok = "xcpre"; }

$sql = mysql_query("SELECT $cisdok, xsklv FROM F$kli_vxcf"."_skluzid WHERE uzix = $kli_uzid ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  $xsklv=$riadok->xsklv;
  }

//cislovane v sklade pri,vyd,pre v jednej rade
$cislo_skladu=1*$_REQUEST['cislo_skladu'];
if( $cislo_skladu == 0 AND $xsklv == 9 )
    {
$sql = mysql_query("SELECT sklx FROM F$kli_vxcf"."_sklxskl ORDER BY sklx ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $cislo_skladu=$riadok->sklx;
  }
    }


if( $xsklv == 9 )
{
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_sklxskl WHERE sklx = $cislo_skladu ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  }
}
//koniec cislovane v sklade pri,vyd,pre v jednej rade

$cnewdok=1*$newdok;
$opacdok=strRev($newdok);
if( $cnewdok > 9999 ) { $poccis="001"; $koncis="999"; $predok=substr($opacdok,3,2); }
if( $cnewdok > 99999 ) { $poccis="0001"; $koncis="9999"; $predok=substr($opacdok,4,2); }
if( $cnewdok > 999999 ) { $poccis="00001"; $koncis="99999"; $predok=substr($opacdok,5,2); }
if( $cnewdok > 9999999 ) { $poccis="000001"; $koncis="999999"; $predok=substr($opacdok,6,2); }
if( $cnewdok > 99999999 ) { $poccis="0000001"; $koncis="9999999"; $predok=substr($opacdok,7,2); }
$predok=strRev($predok);
$predok=1*$predok;

$pocdok=$predok.$poccis;
$kondok=$predok.$koncis;
$zmen=0;
if( $n_spl >= $pocdok AND $n_spl <= $kondok AND $n_spl > 0 ) { $zmen=1; }


if( $drupoh == 1 ) { $sqult = "UPDATE F$kli_vxcf"."_skluzid SET xcpri='$n_spl' WHERE uzix='$kli_uzid' "; }
if( $drupoh == 2 ) { $sqult = "UPDATE F$kli_vxcf"."_skluzid SET xcvyd='$n_spl' WHERE uzix='$kli_uzid' "; }
if( $drupoh == 3 ) { $sqult = "UPDATE F$kli_vxcf"."_skluzid SET xcpre='$n_spl' WHERE uzix='$kli_uzid' "; }
if( $xsklv == 9 ) { $sqult = "UPDATE F$kli_vxcf"."_sklxskl SET xcpri='$n_spl', xcvyd='$n_spl', xcpre='$n_spl' WHERE sklx=$cislo_skladu "; }
//echo $sqult;
if( $zmen == 1 ) { $ulozene = mysql_query("$sqult"); }

$copern=1;
}
//koniec uprava cisla dokladu

//import z ../import/sklpri.txt
    if ( $copern == 55 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/sklpri.csv ?") )
         { window.close()  }
else
         { location.href='vstpoh.php?copern=56&page=1&drupoh=1'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;

if( file_exists("../import/SKLPRI.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/SKLPRI.CSV existuje<br />";

//skl b 0;xz ; b;cis b 0;xz ; b;naz b 0;xz ; b;cen b 0;xz ; b;mno b 0;xz ; b;mer b 0;xz ; b;jkp b 0;
//xz ; b;ume b 7;xz ; b;dat b 10;xz ; b;dok b 0;xz ; b;poh b 0;xz ; b;fak b 0;xz ; b;ico b 0;
//xz ; b;xt koniec@b;xz r$

$subor = fopen("../import/FIR$kli_vxcf/SKLPRI.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
//  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_skl = $pole[0];
  $x_cis = $pole[1];
  $x_nat = $pole[2];
  $x_cen = $pole[3];
  $x_mno = $pole[4];
  $x_mer = $pole[5];
  $x_jkp = $pole[6];

  $x_ume = $pole[7];
  $x_dat = $pole[8];
  $x_dok = $pole[9];
  $x_poh = $pole[10];
  $x_fak = 1*$pole[11];
  $x_ico = 1*$pole[12];
  $x_str = 1*$pole[13];
  $x_zak = 1*$pole[14];

  $x_kon = $pole[15];

if( $x_fak == 0 ) $x_fak=1;
if( $x_ico == 0 ) $x_ico=1*$fir_fico;
if( $x_str == 0 ) $x_str=1;
if( $x_zak == 0 ) $x_zak=1;

$sql_dat=SqlDatum($x_dat);

$ulozttt = "INSERT INTO F$kli_vxcf"."_sklpri ( skl,cis,ico,fak,ume,dat,".
" dok,doq,poh,str,zak, ".
" cen,mno,id,unk,poz,sk2 ) ".
" VALUES ($x_skl, '$x_cis', '$x_ico', '$x_fak', '$x_ume', '$sql_dat',".
" '$x_dok', '$x_dok', '$x_poh', '$x_str', '$x_zak',". 
" '$x_cen', '$x_mno', '$kli_uzid', '', '', $x_skl ); "; 

//echo $ulozttt;

$ulozene = mysql_query("$ulozttt"); 
 

}

echo "Tabulka F$kli_vxcf"."_sklpri!"." naimportovan· <br />";

fclose ($subor);


    }

//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r prÌjemok ?") )
         { window.close()  }
else
         { location.href='vstpoh.php?copern=167&page=1&drupoh=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_sklpri';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_sklpri!"." vynulovan· <br />";

    }


//import z ../import/sklpri.txt
    if ( $copern == 52 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/sklvyd.csv ?") )
         { window.close()  }
else
         { location.href='vstpoh.php?copern=53&page=1&drupoh=2'  }
</script>
<?php
    }
    if ( $copern == 53 )
    {
$copern=1;

if( file_exists("../import/SKLVYD.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/SKLVYD.CSV existuje<br />";

//skl b 0;xz ; b;cis b 0;xz ; b;naz b 0;xz ; b;cen b 0;xz ; b;mno b 0;xz ; b;mer b 0;xz ; b;jkp b 0;
//xz ; b;ume b 7;xz ; b;dat b 10;xz ; b;dok b 0;xz ; b;poh b 0;xz ; b;fak b 0;xz ; b;ico b 0;
//xz ; b;xt koniec@b;xz r$

$subor = fopen("../import/FIR$kli_vxcf/SKLVYD.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
//  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_skl = $pole[0];
  $x_cis = $pole[1];
  $x_nat = $pole[2];
  $x_cen = $pole[3];
  $x_mno = $pole[4];
  $x_mer = $pole[5];
  $x_jkp = $pole[6];

  $x_ume = $pole[7];
  $x_dat = $pole[8];
  $x_dok = $pole[9];
  $x_poh = $pole[10];
  $x_fak = 1*$pole[11];
  $x_ico = 1*$pole[12];
  $x_str = 1*$pole[13];
  $x_zak = 1*$pole[14];

  $x_kon = $pole[15];

if( $x_fak == 0 ) $x_fak=1;
if( $x_ico == 0 ) $x_ico=1*$fir_fico;
if( $x_str == 0 ) $x_str=1;
if( $x_zak == 0 ) $x_zak=1;

$sql_dat=SqlDatum($x_dat);

$ulozttt = "INSERT INTO F$kli_vxcf"."_sklvyd ( skl,cis,ico,fak,ume,dat,".
" dok,doq,poh,str,zak, ".
" cen,mno,id,unk,poz,sk2 ) ".
" VALUES ($x_skl, '$x_cis', '$x_ico', '$x_fak', '$x_ume', '$sql_dat',".
" '$x_dok', '$x_dok', '$x_poh', '$x_str', '$x_zak',". 
" '$x_cen', '$x_mno', '$kli_uzid', '', '', $x_skl ); "; 

//echo $ulozttt;

$ulozene = mysql_query("$ulozttt"); 
 

}

echo "Tabulka F$kli_vxcf"."_sklvyd!"." naimportovan· <br />";

fclose ($subor);


    }

//vymazanie vsetkych poloziek
    if ( $copern == 68 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r v˝dajok ?") )
         { window.close()  }
else
         { location.href='vstpoh.php?copern=168&page=1&drupoh=2'  }
</script>
<?php
    }
    if ( $copern == 168 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_sklvyd';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_sklvyd!"." vynulovan· <br />";

    }



// 16=vymazanie dokladu potvrdene v vstp_u.php
if ( $copern == 16 )
     {
$cislo_skl = strip_tags($_REQUEST['cislo_skl']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

//odpocitat polozky z sklzas
$dsqlt = "SELECT skl,cis,cen,mno,sk2 FROM F$kli_vxcf"."_$tabl WHERE skl='$cislo_skl' AND dok='$cislo_dok' AND cis > 0 ";
$dsql = mysql_query("$dsqlt");

$pzaz = mysql_num_rows($dsql);

$i = 0;
   while ($i < $pzaz )
   {
  if (@$dzak=mysql_data_seek($dsql,$i))
  {

$driadok=mysql_fetch_object($dsql);
$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znxskl($driadok->mno) WHERE ( skl=$driadok->skl AND cis=$driadok->cis AND cen=$driadok->cen );";
$upravene = mysql_query("$sqtu");
if ($drupoh == 3)
{
$sqtu = "UPDATE F$kli_vxcf"."_sklzas SET zas=zas$znmskl($driadok->mno) WHERE ( skl=$driadok->sk2 AND cis=$driadok->cis AND cen=$driadok->cen );";
$upravene = mysql_query("$sqtu");
}

  }
$i = $i + 1;
   }

$sqlpr = 'DROP TABLE F'.$kli_vxcf.'_sklzaspriemer';
if( $fir_xsk04 == 1 ) { $vyslpr = mysql_query("$sqlpr"); }

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE skl='$cislo_skl' AND dok='$cislo_dok' "); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";

if ( $fir_xsk05 == 0 )
    {
$upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$cislo_dok' WHERE $cisdok > '$cislo_dok'"); 
    }

if ( $fir_xsk05 == 1 )
    {
$cisdok = "xcpri";
if( $drupoh == 2 ) { $cisdok = "xcvyd"; }
if( $drupoh == 3 ) { $cisdok = "xcpre"; }

$sql = mysql_query("SELECT $cisdok, xsklv FROM F$kli_vxcf"."_skluzid WHERE uzix = $kli_uzid ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  $xsklv=$riadok->xsklv;
  }

//cislovane v sklade pri,vyd,pre v jednej rade
$cislo_skladu=1*$_REQUEST['cislo_skladu'];
if( $cislo_skladu == 0 AND $xsklv == 9 )
    {
$sql = mysql_query("SELECT sklx FROM F$kli_vxcf"."_sklxskl ORDER BY sklx ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $cislo_skladu=$riadok->sklx;
  }
    }
if( $xsklv == 9 )
{
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_sklxskl WHERE sklx = $cislo_skladu ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  }
}
//koniec cislovane v sklade pri,vyd,pre v jednej rade

$cnewdok=1*$newdok;
$opacdok=strRev($newdok);
if( $cnewdok > 9999 ) { $poccis="001"; $koncis="999"; $predok=substr($opacdok,3,2); }
if( $cnewdok > 99999 ) { $poccis="0001"; $koncis="9999"; $predok=substr($opacdok,4,2); }
if( $cnewdok > 999999 ) { $poccis="00001"; $koncis="99999"; $predok=substr($opacdok,5,2); }
if( $cnewdok > 9999999 ) { $poccis="000001"; $koncis="999999"; $predok=substr($opacdok,6,2); }
if( $cnewdok > 99999999 ) { $poccis="0000001"; $koncis="9999999"; $predok=substr($opacdok,7,2); }
$predok=strRev($predok);
$predok=1*$predok;

$pocdok=$predok.$poccis;
$kondok=$predok.$koncis;
$zmen=0;
if( $cislo_dok >= $pocdok AND $cislo_dok <= $kondok AND $cislo_dok > 0 ) { $zmen=1; }

if( $zmen == 1 AND $xsklv != 9 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_skluzid SET $cisdok='$cislo_dok' WHERE $cisdok > '$cislo_dok' AND uzix = $kli_uzid "); }
if( $zmen == 1 AND $xsklv == 9 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_sklxskl SET xcpri='$cislo_dok', xcvyd='$cislo_dok', xcpre='$cislo_dok' WHERE $cisdok > '$cislo_dok' AND sklx = $cislo_skladu "); }

    }
//echo "POLOéKA DOK:$cislo_dok BOLA VYMAZAN¡ ";
endif;

     }
//koniec vymazania


//podmienka ak podla uzivatela
$podmpodlauz="";
if ( $fir_xsk05 == 1 )
    {
$cisdok = "xcpri";
$viddok = "xvpri";
if( $drupoh == 2 ) { $cisdok = "xcvyd"; $viddok = "xvvyd"; }
if( $drupoh == 3 ) { $cisdok = "xcpre"; $viddok = "xvpre";}

$covidim=0;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_skluzid WHERE uzix = $kli_uzid ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $covidim=1*$riadok->$viddok;
  $xsklv=$riadok->xsklv;
  }


//cislovane v sklade pri,vyd,pre v jednej rade
$cislo_skladu=1*$_REQUEST['cislo_skladu'];
if( $copern == 9 ) { $cislo_skladu=1*$_REQUEST['hladaj_skl']; }
if( $cislo_skladu == 0 AND $xsklv == 9 )
    {
$sql = mysql_query("SELECT sklx FROM F$kli_vxcf"."_sklxskl ORDER BY sklx ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $cislo_skladu=$riadok->sklx;
  }
    }
if( $xsklv == 9 )
{
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_sklxskl WHERE sklx = $cislo_skladu ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  }
}
//koniec cislovane v sklade pri,vyd,pre v jednej rade


$cnewdok=1*$newdok;
$opacdok=strRev($newdok);
if( $cnewdok > 9999 ) { $poccis="001"; $koncis="999"; $predok=substr($opacdok,3,2); }
if( $cnewdok > 99999 ) { $poccis="0001"; $koncis="9999"; $predok=substr($opacdok,4,2); }
if( $cnewdok > 999999 ) { $poccis="00001"; $koncis="99999"; $predok=substr($opacdok,5,2); }
if( $cnewdok > 9999999 ) { $poccis="000001"; $koncis="999999"; $predok=substr($opacdok,6,2); }
if( $cnewdok > 99999999 ) { $poccis="0000001"; $koncis="9999999"; $predok=substr($opacdok,7,2); }
$predok=strRev($predok);
$predok=1*$predok;

$pocdok=$predok.$poccis;
$kondok=$predok.$koncis;

if( $covidim == 0 ) { $podmpodlauz=" F$kli_vxcf"."_$tabl.dok >= $pocdok AND F$kli_vxcf"."_$tabl.dok <= $kondok AND"; }
    }
//koniec podmienka ak podla uzivatela


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Sklad <?php echo $cov1p; ?> zoznam</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
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

// Kontrola des.cisla v rozsahu x az y  
      function cele(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nai.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//hladanie
  if ( $copern == 9 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {

    }

<?php
  }
//koniec hladania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 OR $copern == 10 )
  {
?>
//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
     else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
    }

    function VyberVstup()
    {
    document.forma3.page.focus();
    document.forma3.page.select();
    }

    function ObnovUI()
    {

    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>

    function ZoznamRaktur()
    {
    var dokl = document.formhl1.hladaj_dok.value;

    window.open('poldok.php?copern=101&drupoh=<?php echo $drupoh; ?>&page=1&cislo_doklady=' + dokl + '&page=1&tlacitR=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }

    function DokladPDF(doklad)
    {
    window.open('poldok.php?copern=101&cislo_dok=' + doklad + '&drupoh=<?php echo $drupoh; ?>&page=1&page=1&tlacitR=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
    }

function UlozSpl(cpl,splat)
                {
var n_spl = document.forms.fhosnew.n_spl.value;

window.open('vstpoh.php?copern=3618&n_spl=' + n_spl + '&drupoh=<?php echo $drupoh; ?>&cislo_skladu=<?php echo $cislo_skladu; ?>&page=1', '_self' );

                }

function UpravSpl(cpl,splat)
                {

var uhr_cpl = cpl;
var uhr_spl = '<?php echo $cnewdok; ?>';

var dajis = "SP" + uhr_cpl; 

  myUhras = document.getElementById( dajis );
  var htmluhs = " ";

  htmluhs += " <table><tr><FORM name='fhosnew' class='obyc' method='post' action='#' ><td>";

  htmluhs += " <input class='hvstup' type='text' name='n_spl' id='n_spl' size='10' onkeyup='CiarkaNaBodku(this)' value='" + uhr_spl + "' /> ";

  htmluhs += " <img border=0 src='../obr/ok.png' style='width:12; height:15;' ";
  htmluhs += " title='Uloûiù upravenÈ ËÌslo dokladu' ";
  htmluhs += " onClick=\"UlozSpl(" + uhr_cpl + ",'" + uhr_spl + "');\"></td></FORM></tr></table>";

  myUhras.innerHTML = htmluhs;
  myUhras.className='kliknute';

  document.forms.fhosnew.n_spl.focus();
  document.forms.fhosnew.n_spl.select();
                }



  </script>
</HEAD>
<BODY class="white" onload="ObnovUI(); VyberVstup();" >

<?php 


// aktualna strana
$page = strip_tags($_REQUEST['page']);
// nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
if( $copern == 9 ) $pols = 900;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  <?php echo $cov1p; ?> 
<?php if(  $copern != 10 ) echo "z·sob - zoznam "; ?>
<?php if(  $copern == 10 ) echo "z·sob - zostava "; ?>
<?php echo $dokm4pm; ?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 7 && $copern != 9 AND $copern != 10 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
  {
//[[[[[

$sqltt =  "SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE ( $podmpodlauz F$kli_vxcf"."_$tabl.dok > 0 AND F$kli_vxcf"."_$tabl.dok < 801000000 AND F$kli_vxcf"."_$tabl.ume >= $kli_vume )".
" OR isnull( F$kli_vxcf"."_$tabl.ume) OR isnull( F$kli_vxcf"."_$tabl.dat) OR F$kli_vxcf"."_$tabl.skl = 0 ". 
" GROUP BY dok ORDER BY dok DESC".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt");

  }
// zobraz hladanie vo vsetkych prijemkach
if ( $copern == 9 )
  {

$hladaj_nai = strip_tags($_REQUEST['hladaj_nai']);
$hladaj_dok = strip_tags($_REQUEST['hladaj_dok']);
$hladaj_dat = strip_tags($_REQUEST['hladaj_dat']);
$hladaj_skl = strip_tags($_REQUEST['hladaj_skl']);
$hladaj_poh = strip_tags($_REQUEST['hladaj_poh']);

if ( $hladaj_nai != "" ) {

if( $drupoh == 1 )
{
$sqltx = "SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  $podmpodlauz ( F$kli_vxcf"."_ico.nai LIKE '%$hladaj_nai%' OR zak LIKE '%$hladaj_nai%' OR poz LIKE '%$hladaj_nai%' )".
" GROUP BY dok ORDER BY dok DESC".
"";
}

if( $drupoh == 2 )
{
$sqltx = "SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  $podmpodlauz ( F$kli_vxcf"."_ico.nai LIKE '%$hladaj_nai%' OR zak LIKE '%$hladaj_nai%' OR poz LIKE '%$hladaj_nai%' )".
" GROUP BY dok ORDER BY dok DESC".
"";
}

if( $drupoh == 3 )
{
$sqltx = "SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  $podmpodlauz sk2 LIKE '%$hladaj_nai%'".
" GROUP BY dok ORDER BY dok DESC".
"";
}


$sql = mysql_query("$sqltx");

                        }

if ( $hladaj_skl != "" ) { 

$sql = mysql_query("SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  $podmpodlauz F$kli_vxcf"."_$tabl.skl = '$hladaj_skl' ".
" GROUP BY dok ORDER BY dok DESC".
"");

}

if ( $hladaj_dat != "" ) {

    if( strlen($hladaj_dat) == 6 OR strlen($hladaj_dat) == 7 )
         {
         $sqltt = "SELECT ume, dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
         " F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
         " FROM F$kli_vxcf"."_$tabl".
         " LEFT JOIN F$kli_vxcf"."_sklcis".
         " ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
         " LEFT JOIN F$kli_vxcf"."_ico".
         " ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
         " WHERE  $podmpodlauz F$kli_vxcf"."_$tabl.ume = $hladaj_dat ".
         " GROUP BY dok ORDER BY dok DESC".
         "";
         }  

    if( strlen($hladaj_dat) != 6 AND strlen($hladaj_dat) != 7 )
         {
         $datsql = SqlDatum($hladaj_dat);

         $sqltt = "SELECT ume, dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
         " F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
         " FROM F$kli_vxcf"."_$tabl".
         " LEFT JOIN F$kli_vxcf"."_sklcis".
         " ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
         " LEFT JOIN F$kli_vxcf"."_ico".
         " ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
         " WHERE  $podmpodlauz F$kli_vxcf"."_$tabl.dat = '$datsql' ".
         " GROUP BY dok ORDER BY dok DESC".
         "";
         } 

$sql = mysql_query("$sqltt");
}

if ( $hladaj_dok != "" ) {

$sql = mysql_query("SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  $podmpodlauz F$kli_vxcf"."_$tabl.dok = '$hladaj_dok' ".
" GROUP BY dok ORDER BY dok DESC".
"");


}

if ( $hladaj_poh != "" ) {

$sql = mysql_query("SELECT dok, doq, skl, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat, poh, sk2, F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, str, zak, fak, cpl,".
" F$kli_vxcf"."_$tabl.cis, F$kli_vxcf"."_sklcis.nat, cen, mno, F$kli_vxcf"."_sklcis.mer,COUNT(*) AS ppl, poz ". 
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_$tabl.cis=F$kli_vxcf"."_sklcis.cis".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  $podmpodlauz F$kli_vxcf"."_$tabl.poh = '$hladaj_poh' ".
" GROUP BY dok ORDER BY dok DESC".
"");


}

  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
?>

<table class="fmenu" width="100%" >

<?php
//nezobraz hladanie pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<FORM name="formhl1" class="hmenu" method="post" action="vstpoh.php?drupoh=<?php echo $drupoh;?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=15 height=10 border=0 title="Vyhæad·vanie" >
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_dok" id="hladaj_dok" size="15" value="<?php echo $hladaj_dok;?>" />
<td class="hmenu"><input type="text" name="hladaj_skl" id="hladaj_skl" size="15" value="<?php echo $hladaj_skl;?>" />
<td class="hmenu"><input type="text" name="hladaj_poh" id="hladaj_poh" size="5" value="<?php echo $hladaj_poh;?>" />
<td class="hmenu"><input type="text" name="hladaj_dat" id="hladaj_dat" size="15" value="<?php echo $hladaj_dat;?>" />
<td class="hmenu"><input type="text" name="hladaj_nai" id="hladaj_nai" size="30" value="<?php echo $hladaj_nai;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="vstpoh.php?drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>

<?php
//import prijem
if ( $drupoh == 1 AND $kli_uzall > 10000 )
     {
?>
<td class="hmenu" ><a href='vstpoh.php?copern=67&drupoh=1&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek prÌjmov"></a>
<td class="hmenu" ><a href='vstpoh.php?copern=55&drupoh=1&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
<?php
     }
?>

<?php
//import vydaj
if ( $drupoh == 2 AND $kli_uzall > 10000 )
     {
?>
<td class="hmenu" ><a href='vstpoh.php?copern=68&drupoh=2&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek v˝dajov"></a>
<td class="hmenu" ><a href='vstpoh.php?copern=52&drupoh=2&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
<?php
     }
?>

<?php
if ( $drupoh == 1 OR $drupoh == 2  )
{
?>
<td class="hmenu">
<a href="#" onClick="ZoznamRaktur();">
<img src='../obr/pdf.png' width=15 height=15 border=0 title="Zoznam dokladov za <?php echo $kli_vume;?> vo form·te PDF" ></a>
</td>
<?php
}
?>

</tr>
</FORM>
<?php
     }
?>


<?php if( $fir_xsk05 == 1 ) { ?>
<tr>
<td class="bmenu" colspan="6" >
<div class='nekliknute' id='SP123' >

 <img src='../obr/uprav.png' width=15 height=12 border=1 
 onClick="UpravSpl(123,'111');" 
 title='Upraviù N·sleduj˙ce ËÌslo dokladu' >
</div>
</td></tr>
<?php                      } ?>


<tr>
<th class="hmenu">Doklad
<th class="hmenu"><?php echo $skladp; ?><th class="hmenu">POH<th class="hmenu">D·tum/UME
<th class="hmenu"><?php echo $hladp; ?><th class="hmenu"><?php echo $fakv1p; ?><th class="hmenu">Poloûiek
<th class="hmenu">TlaË<th class="hmenu">Uprav<th class="hmenu">Zmaû<th class="hmenu">Orig
</tr>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" width="10%" ><?php echo $riadok->dok;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->skl;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->poh;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->dat;?></td>
<?php
if( $drupoh == 1 )
{
?>
<td class="fmenu" width="35%" ><?php echo $riadok->nai;?> - <?php echo $riadok->str;?>/<?php echo $riadok->zak;?> - <?php echo $riadok->poz;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->fak;?></td>
<?php
}
?>
<?php
if( $drupoh == 2 )
{
?>
<td class="fmenu" width="35%" ><?php echo $riadok->nai;?> - <?php echo $riadok->str;?>/<?php echo $riadok->zak;?> - <?php echo $riadok->poz;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->fak;?></td>
<?php
}
?>
<?php
if( $drupoh == 3 )
{
?>
<td class="fmenu" width="35%" ><?php echo $riadok->sk2;?></td>
<td class="fmenu" width="10%" > </td>
<?php
}
?>
<?php
$ppl=$riadok->ppl-1;
?>
<td class="fmenu" width="9%" ><?php echo $ppl;?></td>
<td class="fmenu" width="4%" >
<?php
$tlaclenpdf=1;
if( $kli_vrok < 2014 ) { $tlaclenpdf=0; }
if( $_SESSION['nieie'] == 1 ) { $tlaclenpdf=1; }
//$tlaclenpdf=0;
?>
<?php if( $tlaclenpdf == 0 )  { ?>
<a href="#" onClick="window.open('vstp_t.php?copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho dokladu" ></a>
<?php                                } ?>

<img src='../obr/pdf.png' width=15 height=15 border=0 onClick='DokladPDF(<?php echo $riadok->dok;?>);' title="TlaË dokladu Ë.<?php echo $riadok->dok;?> vo form·te PDF" >

</td>
<td class="fmenu" width="4%" >
<?php
if( $copern != 10 )
{
?>
<a href='vstp_u.php?copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_skl=<?php echo $riadok->skl;?>&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="⁄prava vybranej <?php echo $dokm4p; ?>" ></a></td>
<?php
}
?>
<td class="fmenu" width="4%" >
<?php
if( $copern != 10 )
{
?>
<a href='vstp_u.php?copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_skl=<?php echo $riadok->skl;?>&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazanie vybranej <?php echo $dokm4p; ?>" ></a></td></a>
<?php
}
?>
</td>
<td class="fmenu" width="4%" >
<?php
//aky subor existuje podla toho daj koncovku
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.pdf"))  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.pdf' target="_blank">
<img src='../obr/pdf.png' width=15 height=10 border=0 title="Zobrazenie origin·lu <?php echo $dokm4p; ?>" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.jpg' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 title="Zobrazenie origin·lu <?php echo $dokm4p; ?>" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.bmp") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.bmp' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 title="Zobrazenie origin·lu <?php echo $dokm4p; ?>" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.gif") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.gif' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 title="Zobrazenie origin·lu <?php echo $dokm4p; ?>" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/d$riadok->dok.png") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $adrdok;?>/d<?php echo $riadok->dok;?>.png' target="_blank">
<img src='../obr/orig.png' width=15 height=10 border=0 title="Zobrazenie origin·lu <?php echo $dokm4p; ?>" ></a>
<?php
} 
?>
</td>
</tr>
<?php
  }
$i = $i + 1;
   }
if ( $copern != 5 AND $copern != 8 AND $copern != 6 ) echo "</table>";
?>

<tr><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></tr>

<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,7,9

//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Doklad SKL=<?php echo $cislo_skl;?> DOK=<?php echo $cislo_dok;?> vymazan˝</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="vstpoh.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_skl=$hladaj_skl";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="vstpoh.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_skl=$hladaj_skl";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="vstpoh.php?copern=4&drupoh=<?php echo $drupoh;?>&page=<?php echo $xstr;?>" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="vstp_u.php?copern=5&drupoh=<?php echo $drupoh;?>&page=1&cislo_skladu=<?php echo $hladaj_skl;?>" >
<INPUT type="submit" name="npol" id="npol" value="Nov· <?php echo $dokm1p; ?>" >
</FORM>
</td>
</tr>
</table>

<?php
     }
//koniec nezobraz pre novu,upravu a mazanie
?>


<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }
if( $copern == 1 ) { 
$zmenume=1; 
$odkaz="../sklad/vstpoh.php?copern=1&drupoh=$drupoh&page=1"; 
                   }

$cislista = include("skl_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
