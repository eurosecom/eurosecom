<HTML>
<?php

do
{

$sys = 'ALL';
$urov = 5000;
$uziv = include("uziv.php");
if( !$uziv ) exit;

$npol = $_REQUEST['npol'];
$copern = $_REQUEST['copern'];
$cislo_xcf = $_REQUEST['cislo_xcf'];
$naz_xcf = $_REQUEST['naz_xcf'];
$naz_rok = 1*($_REQUEST['naz_rok']);
if( $naz_rok == 0 ) { $naz_rok=2015;  }
$naz_duj = 1*($_REQUEST['naz_duj']);
$naz_dtb = $_REQUEST['naz_dtb'];
$naz_prav = $_REQUEST['naz_prav'];
$page = $_REQUEST['page'];
$rok_ind = $naz_rok-2008;
$duj_ind = $naz_duj;

//max.hodnota xcf
if ( $copern == 5 )
  {
require_once("pswd/password.php");

$dtb2 = include("oddel_dtb3.php");

@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = mysql_query("SELECT MAX(xcf) FROM fir");
$max_xcf = mysql_result($sql, 0);
//$max_xcf = mysql_result(mysql_query("SELECT MAX(xcf) FROM fir"), 0);
$npol = $max_xcf + 1;
mysql_close();
mysql_free_result($sql);
  }

//vloz firmu
if ( $copern == 1007 )
  {
$cisloold = 1*$_REQUEST['cisloold'];
$cislonew = 1*$_REQUEST['cislonew'];

$sqlttt = "INSERT INTO fir SELECT ".
" '$cislonew',	naz,	rok,	duj,	dtb,	cis1,	cis2,	txt1,	txt2,	prav,	id_klienta,	now() ".
" FROM fir WHERE xcf = $cisloold ";
$sqldok = mysql_query("$sqlttt");

$copern=8;
$page=1;
$cislo_xcf=$cislonew;
$naz_xcf="";
$naz_rok="2015";
$naz_prav="";
$naz_duj="9";
$naz_dtb="";

$sqlttt = "SELECT * FROM fir WHERE xcf = $cislonew ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $naz_xcf=$riaddok->naz;
 $naz_rok=$riaddok->rok;
 $naz_prav=$riaddok->prav;
 $naz_duj=$riaddok->duj;
 $naz_dtb=$riaddok->dtb;
 }

$rok_ind = $naz_rok-2008;
$duj_ind = $naz_duj;

//cfir_u.php?copern=8&page=1&cislo_xcf=33&naz_xcf=SECOM 2011&naz_rok=2011
//&naz_prav=XxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxx&naz_duj=0&naz_dtb=

  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>».⁄Ë.Jednotiek</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="js/cookies.js">
</SCRIPT>
<SCRIPT Language="JavaScript">
    <!--
<?php
if ( $copern != 6 )
{
?>
      function KontrolaCisla(Vstup, Oznam)
      {
       if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
       else { Oznam.style.display="none"; }
      }

      function Obnov_vstup()
      {


      }

// Kontrola cisla v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
//       else {alert("ProsÌm vloûte ËÌslo " + x + " - " + y);
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              }; 
             };
      };

// Funkcia pre upozornenie pred opustenim okna
      var neupozorni=false;

      function Zakaz_uloz()
      {
      document.formv1.uloz.disabled = true;
      return (true);
      }
<?php
if ( $copern == 8 )
  {
?>
      function Nastav_UPSEL()
      {
      document.formv1.h_rok.value = <?php echo $naz_rok;?>;
      //document.formv1.h_duj.options[<?php echo $duj_ind;?>].selected = true;
      document.formv1.h_duj.value = <?php echo $naz_duj;?>;
      document.formv1.h_naz.focus();
      document.formv1.h_naz.select();
      document.formv1.h_xcf.disabled = true;
      return (true);
      }
<?php
  }
?>

<?php
if ( $copern != 8 )
  {
?>
      function Nastav_UPSEL()
      {
      document.formv1.h_xcf.focus();
      document.formv1.h_xcf.select();
      return (true);
      }
<?php
  }
?>

      function Zapis_COOK()
      {

      }

      function Nastav_SEL()
      {
      Bx.style.display="none";
      document.formv1.h_rok.value = <?php echo $naz_rok;?>;
      document.formv1.h_duj.options[0].selected = true;
      document.formv1.uloz.disabled = true;
      return (true);
      }

      function Povol_uloz()
      {
      document.formv1.uloz.disabled = false;
      return (true);
      }

      function ulozenie (){
        if (neupozorni){
          return (false);
        } else {
          neupozorni = true;
          return (true);
        }
      }
<?php
}
?>
    // -->
</SCRIPT>
<?php
if ( $copern == 5 || $copern == 8 )
  {
?>
<SCRIPT Language="JavaScript" Event="onbeforeunload()"
      For="window">
    <!--
      // skript pro ud·lost onbeforeunload
      if (!neupozorni){
      event.returnValue =
      "Ak opustÌte str·nku , stratÌte nahrat˙ poloûku !"
      }
    // -->
</SCRIPT>
<?php
  }
?>
</HEAD>
<?php
if ( $copern != 6 ) {echo "<BODY class='white' onload='Zakaz_uloz(); Nastav_SEL(); Nastav_UPSEL();' >"; }
if ( $copern == 6 ) {echo "<BODY class='white' >"; }
?>

<table class="h2" width="100%" >
<tr>
<td>
<?php
if ( $copern == 5 ) {echo "EuroSecom  -  »ÌselnÌk ˙Ëtovn˝ch jednotiek - nov· poloûka FIR: $npol "; }
if ( $copern == 8 ) {echo "EuroSecom  -  »ÌselnÌk ˙Ëtovn˝ch jednotiek - ˙prava poloûky FIR: $cislo_xcf "; }
if ( $copern == 6 ) {echo "EuroSecom  -  »ÌselnÌk ˙Ëtovn˝ch jednotiek - vymazanie poloûky FIR: $cislo_xcf "; }
?>
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
// 5=vlozenie novej,8=uprava
if ( $copern == 5 || $copern == 8 )
  {
?>
<table class="fmenu">
<tr>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo firmy FIR musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
</tr>
<tr>
<th class="hmenu">FIR<th class="hmenu">N·zov ˙Ëtovnej jednotky<th class="hmenu">Rok<th class="hmenu">DUJ<th class="hmenu">Parametre<th class="hmenu">AktualizovanÈ<br />
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" onSubmit="return ulozenie();" action="cfir.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=5&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=8&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_xcf=$cislo_xcf&"; } ?>
" >

<td class="fmenu"><input type="text" name="h_xcf" id="h_xcf" size="12" value="
<?php if ( $copern == 5 ) {echo $npol; } ?>
<?php if ( $copern == 8 ) {echo $cislo_xcf; } ?>
" onchange="return intg(this,1,9999,Bx)" onkeyup="KontrolaCisla(this, Bx)" />

<td class="fmenu"><input type="text" name="h_naz" id="h_naz" size="50" 
<?php if ( $copern == 8 ) {echo "value='$naz_xcf'"; } ?>
 />

<TD class="fmenu">
         <SELECT name="h_rok" id="h_rok">
         <OPTION value="2015">
         2015
         </OPTION>
         <OPTION value="2014">
         2014
         </OPTION>
         <OPTION value="2013">
         2013
         </OPTION>
         <OPTION value="2012">
         2012
         </OPTION>
         <OPTION value="2011">
         2011
         </OPTION>
         <OPTION value="2010">
         2010
         </OPTION>
         <OPTION value="2009">
         2009
         </OPTION>
         <OPTION value="2008">
         2008
         </OPTION>

         </SELECT>

<TD class="fmenu">
         <SELECT name="h_duj" id="h_duj">
         <OPTION value="0">
         0=POD  PU
         </OPTION>
         <OPTION value="1">
         1=NO   PU
         </OPTION>
         <OPTION value="2">
         2=Mzdy CZ
         </OPTION>
         <OPTION value="9">
         9=POD  JU
         </OPTION>
         </SELECT>

<td class="fmenu"><input type="text" name="h_dtb" id="h_dtb" 
<?php if ( $copern == 8 ) {echo "value='$naz_dtb'"; } ?>
size="10" onClick="return Povol_uloz();" />

<td class="fmenu"><input type="text" name="h_zps" id="h_zps" size="20" /></td>
</tr>
<?php
if ( $copern == 8 )
  {
?>
<tr>
<td class="fmenu" colspan=4"><input type="text" name="h_prav" id="h_prav" size="80" maxlength="80" value="<?php echo $naz_prav; ?>"/></td>
</tr>
<?php
  }
?>
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù  poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td></td><td></td><td></td><td></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Nastav_SEL(); Zakaz_uloz();" id="resetp" name="resetp" value="Vymazaù  formul·r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" onSubmit="return ulozenie();" action="cfir.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Storno neuloûiù" ></td>
<td class="obyc"><SPAN id="vypis">&nbsp;</SPAN></td>
<?php
if ( $copern == 5 )
{
?>
<td></td><td></td><td></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Obnov_vstup();" id="obnovp" name="obnovp" value="Opakovaù hodnoty" ></td>
<?php
}
?>
</tr>
</FORM>
<tr>
<td></td><td></td><td></td><td></td><td></td><td>Posledne aktualizovanÈ poloûky</td>
</tr>

<?php
require_once("pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = mysql_query("SELECT * FROM fir ORDER BY datm DESC LIMIT 20");
// celkom poloziek
$cpol = mysql_num_rows($sql);
?>

<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu"><?php echo $zaznam["xcf"];?></td>
<td class="fmenu"><?php echo $zaznam["naz"];?></td>
<td class="fmenu"><?php echo $zaznam["rok"];?></td>
<td class="fmenu"><?php echo $zaznam["duj"];?></td>
<td class="fmenu"><?php echo $zaznam["dtb"];?></td>
<td class="fmenu"><?php echo $zaznam["datm"];?></td>
</tr>
<?php endwhile;?>
</table>

<?php
mysql_close();
mysql_free_result($sql);
  }
// 6=vymazanie polozky
if ( $copern == 6 )
  {
$page = $_REQUEST['page'];

require_once("pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sqlp = "SELECT * FROM fir WHERE xcf='$cislo_xcf'";
$sql = mysql_query("$sqlp");
?>
<table class="fmenu">
<tr>
<th class="hmenu">FIR<th class="hmenu">N·zov ˙Ëtovnej jednotky<th class="hmenu">Rok<th class="hmenu">DUJ<th class="hmenu">Parametre<th class="hmenu">AktualizovanÈ
</tr><br />
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" width="10%"><?php echo $zaznam["xcf"];?></td>
<td class="fmenu" width="44%"><?php echo $zaznam["naz"];?></td>
<td class="fmenu" width="10%"><?php echo $zaznam["rok"];?></td>
<td class="fmenu" width="10%"><?php echo $zaznam["duj"];?></td>
<td class="fmenu" width="9%"><?php echo $zaznam["dtb"];?></td>
<td class="fmenu" width="17%"><?php echo $zaznam["datm"];?></td>
</tr>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="cfir.php?page=<?php echo $page;?>&copern=6&cislo_xcf=<?php echo $cislo_xcf;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="cfir.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno nevymazaù" ></td>
</tr>
</FORM>
</table>

<?php
mysql_close();
mysql_free_result($sql);
  }

} while (false);
?>
</BODY>
</HTML>