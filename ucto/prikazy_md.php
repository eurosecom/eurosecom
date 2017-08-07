<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
// cislo operacie
$copern = strip_tags($_REQUEST['copern']);
$sys = 'UCT';
if( $_SERVER['SERVER_NAME'] == "www.stavoimpexsro.sk" ) { $sys = 'MZD'; }
$urov = 1100;
if( $copern == 10 ) $urov = 1000;
$cslm=103500;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvuct = include("../ucto/vtvuct.php");
endif;

$sql = "ALTER TABLE F$kli_vxcf"."_uctprikp ADD pbic VARCHAR(10) NOT NULL AFTER iban ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzaltrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$ucto_sys=$_SESSION['ucto_sys'];
//echo $ucto_sys;
if( $ucto_sys == 1 )
{
$rozuct='ANO';
$sysx='UCT';
}

// druh pohybu 1=prikaz n uhradu, 2=upomienka
$drupoh = strip_tags($_REQUEST['drupoh']);
//nastavenie uctu
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);
if(!isset($hladaj_uce) OR $hladaj_uce == '')
{
if( $drupoh == 1 )
{
$sqluce = mysql_query("SELECT * FROM F$kli_vxcf"."_dban WHERE ( dban > 0 ) ORDER BY dban");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $hladaj_uce=$riaduce->dban;
  }
}

}
//koniec nastavenia uctu


if( $drupoh == 1 )
{
$tabl = "uctpriku";
$cisdok = "pokpri";
$adrdok = "pokprijem";
$uctpol = "uctprikp";
$uctpoh = "uctprikp";
}

$uloz="NO";
$zmaz="NO";
$uprav="NO";


// 16=vymazanie dokladu potvrdene v vspr_u.php
if ( $copern == 16 )
     {
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctpol WHERE dok='$cislo_dok' ");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE dok='$cislo_dok' "); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";

endif;
     }
//koniec vymazania


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>
<?php if( $drupoh ==1 ) { echo "PrÌkazy na ˙hradu"; } ?>
</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

      function dajuce() 
      { 

  var ucet = document.formhl1.hladaj_uce.value;
<?php if( $sysx != 'UCT' ) { ?>
  var okno = window.open("vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=" + ucet + "&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1", "_self");
<?php                      } ?>
<?php if( $sysx == 'UCT' ) { ?>
  var okno = window.open("vstpru.php?sysx=UCT&hladaj_uce=" + ucet + "&rozuct=ANO&drupoh=<?php echo $drupoh;?>&page=1&copern=1", "_self");
<?php                      } ?>
      }

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
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
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
    document.formhl1.hladaj_uce.value='<?php echo $hladaj_uce;?>';
    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>

function TlacVseo(vseob)
                {

window.open('vspr_zoznam.php?copern=20&drupoh=1&cislo_dok=' + vseob + '&page=1',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

    function TlacBank(doklad)
    {

    window.open('uctpohyby_pol.php?copern=80&drupoh=4&page=1&typ=PDF&cislo_uce=<?php echo $hladaj_uce; ?>&cislo_dok=' + doklad + '&page=1&cele=1', '_blank', '<?php echo $tlcswin; ?>' )

    }

function TlacBanky(vseob)
                {

window.open('banka_zoznam.php?copern=20&drupoh=1&cislo_dok=' + vseob + '&page=1&cislo_uce=<?php echo $hladaj_uce; ?>',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

    function TlacPlatit()
    {

window.open('banka_platit.php?copern=20&drupoh=1&cislo_dok=0&page=1&cislo_uce=0',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );

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
<?php if( $drupoh == 1 ) echo "<td>EuroSecom  -  PrÌkazy na ˙hradu"; ?>
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

$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE ( uce = $hladaj_uce AND dok > 0 )".
" OR isnull( dat) OR isnull(uce) OR uce = '' ". 
" ORDER BY dok DESC".
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
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);
$hladaj_txp = strip_tags($_REQUEST['hladaj_txp']);


if ( $hladaj_dat != "" ) {

         $datsql = SqlDatum($hladaj_dat);
$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dat = '$datsql' ".
" ORDER BY dok DESC".
"";

//echo $sqltt;
$sql = mysql_query("$sqltt");
                         }

if ( $hladaj_dok != "" ) {

$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE  F$kli_vxcf"."_$tabl.uce = $hladaj_uce AND F$kli_vxcf"."_$tabl.dok = '$hladaj_dok' ".
" ORDER BY dok DESC".
"";

$sql = mysql_query("$sqltt");
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
<FORM name="formhl1" class="hmenu" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=15 height=10 border=0 title="Vyhæad·vanie" >

<img src='../obr/tlac.png' onClick='TlacPlatit();' width=15 height=15 border=0 title="TlaË zoznamu neuhraden˝ch dod·vateæsk˝ch fakt˙r" >


<td class="hmenu" >
<td class="hmenu" >
<td class="hmenu" >
<td class="hmenu" >

<td class="hmenu" >
<?php
$sqluce = mysql_query("SELECT * FROM F$kli_vxcf"."_banvyp WHERE uce = $hladaj_uce ORDER BY dok DESC");
  if (@$zaznam=mysql_data_seek($sqluce,0))
  {
  $riaduce=mysql_fetch_object($sqluce);
  $posl_dok=$riaduce->dok;
  }

$posl1_dok=$posl_dok-1;
$posl2_dok=$posl_dok-2;
$posl3_dok=$posl_dok-3;
$posl4_dok=$posl_dok-4;
?>
<img src='../obr/tlac.png' onClick='TlacBank(<?php echo $posl_dok; ?>);' width=15 height=15 border=0 title="TlaË poslednÈho bank.v˝pisu s poËiatkom a zostatkom ˙Ëtu" >
<img src='../obr/tlac.png' onClick='TlacBank(<?php echo $posl1_dok; ?>);' width=15 height=15 border=0 title="TlaË predposlednÈho bank.v˝pisu s poËiatkom a zostatkom ˙Ëtu" >

<td class="hmenu" colspan="3">
<img src='../obr/zoznam.png' width=15 height=15 border=0 
 onClick="TlacBanky(<?php echo $posl_dok; ?>);" title='TlaËiù zoznam fakt˙r poslednÈho bank.v˝pisu ' >
<img src='../obr/zoznam.png' width=15 height=15 border=0 
 onClick="TlacBanky(<?php echo $posl1_dok; ?>);" title='TlaËiù zoznam fakt˙r predposlednÈho bank.v˝pisu ' >
<img src='../obr/zoznam.png' width=15 height=15 border=0 
 onClick="TlacBanky(<?php echo $posl2_dok; ?>);" title='TlaËiù zoznam fakt˙r bank.v˝pisu 2 dozadu' >
<img src='../obr/zoznam.png' width=15 height=15 border=0 
 onClick="TlacBanky(<?php echo $posl3_dok; ?>);" title='TlaËiù zoznam fakt˙r bank.v˝pisu 3 dozadu' >
<img src='../obr/zoznam.png' width=15 height=15 border=0 
 onClick="TlacBanky(<?php echo $posl4_dok; ?>);" title='TlaËiù zoznam fakt˙r bank.v˝pisu 4 dozadu' >
</tr>
<tr>
<?php
if( $drupoh == 1 )
{
$sqls = mysql_query("SELECT dban,nban,uceb FROM F$kli_vxcf"."_dban WHERE ( dban > 0 ) ORDER BY dban");
?>
<td class="hmenu">
<select class="hvstup" size="1" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>"  
 onchange="dajuce();" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dban"];?>" >
<?php 
$polmen = $zaznam["nban"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dban"];?></option>
<?php endwhile;?>
</select>
</td>
<?php
}
?>

<td class="hmenu"><input type="text" name="hladaj_dok" id="hladaj_dok" size="8" value="<?php echo $hladaj_dok;?>" />
<td class="hmenu"><input type="text" name="hladaj_dat" id="hladaj_dat" size="8" value="<?php echo $hladaj_dat;?>" />
<?php
if ( $drupoh == 1 )
{
?>
<td class="hmenu">
<td class="hmenu">
<?php
}
?>
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="obyc" align="left" colspan="3"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<?php
  if ( $drupoh == 1 )
  {
?>
<td class="hmenu" width="10%" >⁄Ëet
<td class="hmenu" width="10%" >Doklad
<td class="hmenu" width="10%" >D·tum
<td class="hmenu" width="15%" >Mena / Kurz 
<td class="hmenu" width="10%" align="right">Hodnota<?php echo $mena1; ?>
<td class="hmenu" width="20%" >⁄Ëel
<td class="hmenu" width="5%" >TlaË
<td class="hmenu" width="5%" >Uprav
<td class="hmenu" width="5%" >Zmaû
<td class="hmenu" width="10%" >Export
<?php
  }
?>
</tr>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$sk_dat = SkDatum($riadok->dat);
?>
<tr>
<td class="fmenu"><?php echo $riadok->uce;?></td>
<td class="fmenu">
<?php
  if ( $sysx == 'UCT' AND $kli_uzuct > 5000 )
  {
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=ANO&copern=555&drupoh=4&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_prik=<?php echo $riadok->dok;?>'>
<img src='../obr/zoznam.png' width=15 height=12 border=0 title="Za˙Ëtovanie dokladu" ></a>
<?php
  }
?>
<?php echo $riadok->dok;?>
</td>
<td class="fmenu"><?php echo $sk_dat;?></td>
<?php
if( $drupoh == 1 )
{
?>
<td class="fmenu"><?php echo $riadok->mena;?> / <?php echo $riadok->kurz;?> / <?php echo $riadok->hodm;?></td>
<td class="fmenu" align="right"><?php echo $riadok->hodp;?></td>
<td class="fmenu"><?php echo $riadok->txp;?></td>
<?php
}
?>
<td class="fmenu" >
<a href="#" onClick="window.open('vspr_pdf.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË vybranÈho dokladu" ></a>

<img src='../obr/zoznam.png' width=15 height=12 border=1 
 onClick="TlacVseo(<?php echo $riadok->dok; ?>);" 
 title='TlaËiù zoznam fakt˙r na ˙hradu' >
</td>
<td class="fmenu" >
<a href='vspr_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=NIE&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="⁄prava vybranÈho dokladu" ></a></td>
<td class="fmenu">
<a href='vspr_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazanie vybranÈho dokladu" ></a></td></a>
</td>
<td class="fmenu">
<?php
if ( $drupoh == 1 )
  {
?>
<a href="#" onClick="window.open('vspr_export.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/tatrabanka.jpg' width=15 height=15 border=0 title="Export ˙dajov do TATRABANKY Gemini" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=2&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/vub.jpg' width=15 height=15 border=1 title="Export ˙dajov do VUB KPC" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=3&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/vub.jpg' width=15 height=15 border=1 title="Export ˙dajov do VUB CDF" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=6&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/slsp.jpg' width=15 height=15 border=1 title="Export ˙dajov do SLSP HBform·t" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=5&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/dexia.jpg' width=15 height=15 border=1 title="Export ˙dajov do DEXIA ABO" ></a>

<a href="#" onClick="window.open('vspr_export.php?copern=7&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&h_uce=<?php echo $riadok->uce;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/banky/tatrabanka.jpg' width=15 height=15 border=0 title="Export ˙dajov do TATRABANKY CSV" ></a>

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
 Doklad DOK=<?php echo $cislo_dok;?> vymazan˝</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_uce=$hladaj_uce&hladaj_txp=$hladaj_txp";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_dat=$hladaj_dat&hladaj_dok=$hladaj_dok&hladaj_nai=$hladaj_nai&hladaj_uce=$hladaj_uce&hladaj_txp=$hladaj_txp";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="vstpru.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=4&drupoh=<?php echo $drupoh;?>&page=<?php echo $xstr;?>" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="vspr_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1" >
<INPUT type="submit" name="npol" id="npol" value="Nov˝ doklad" >
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

$cislista = include("uct_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
