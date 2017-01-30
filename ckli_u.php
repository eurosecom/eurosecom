<HTML>
<?php

do
{

$sys = 'ALL';
$urov = 50000;
$uziv = include("uziv.php");
if( !$uziv ) exit;

$npol = $_REQUEST['npol'];
$copern = $_REQUEST['copern'];
$cislo_id = $_REQUEST['cislo_id'];
$naz_id = $_REQUEST['naz_id'];
$naz_uzm = $_REQUEST['naz_uzm'];
$naz_uzh = $_REQUEST['naz_uzh'];
$naz_prie = $_REQUEST['naz_prie'];
$naz_meno = $_REQUEST['naz_meno'];
$naz_all = $_REQUEST['naz_all'];
$naz_uct = $_REQUEST['naz_uct'];
$naz_mzd = $_REQUEST['naz_mzd'];
$naz_skl = $_REQUEST['naz_skl'];
$naz_him = $_REQUEST['naz_him'];
$naz_dop = $_REQUEST['naz_dop'];
$naz_ana = $_REQUEST['naz_ana'];
$naz_vyr = $_REQUEST['naz_vyr'];
$naz_fak = $_REQUEST['naz_fak'];
$naz_txt1 = $_REQUEST['naz_txt1'];
$cis1 = $_REQUEST['cis1'];
$page = $_REQUEST['page'];

//max.hodnota xcf
if ( $copern == 5 )
  {
  require_once("pswd/password.php");

if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("oddel_dtb3new.php");
          }
else
          {
$dtb2 = include("oddel_dtb3.php");
          }

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$min_uzall=50000;
if( $kli_uzall >= 100000 ) { $min_uzall=999999;}

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$sql = mysql_query("SELECT MAX(id_klienta) FROM klienti");
$max_id = mysql_result($sql, 0);
$npol = $max_id + 1;
mysql_close();
mysql_free_result($sql);
  }

//vloz uzivatela
if ( $copern == 1007 )
  {
$cisloold = 1*$_REQUEST['cisloold'];
$cislonew = 1*$_REQUEST['cislonew'];

$sqlttt = "INSERT INTO klienti SELECT ".
" 0, uziv_meno, uziv_heslo, priezvisko, meno, all_prav, uct_prav, mzd_prav, skl_prav, ".
" fak_prav, him_prav, dop_prav, ana_prav, vyr_prav, now(), cis1, cis2, txt1, txt2, email, aktivni ".
" FROM klienti WHERE id_klienta = $cisloold ";
$sqldok = mysql_query("$sqlttt");

$copern=8;
$page=1;
$cislo_id=0;

$sqlc = "SELECT * FROM klienti WHERE id_klienta > 0 ORDER BY id_klienta DESC ";
$vysledokc = mysql_query($sqlc);
if ( $vysledokc )
     {
$riadokc=mysql_fetch_object($vysledokc);
$cislo_id = $riadokc->id_klienta;
     }


$naz_id=$cislo_id;
$naz_id="";
$naz_uzm="";
$naz_uzh="";
$naz_prie="";
$naz_meno="";
$naz_all="";
$naz_uct="";
$naz_mzd="";
$naz_skl="";
$naz_fak="";
$naz_him="";
$naz_dop="";
$naz_vyr="";
$naz_ana="";
$naz_txt1="";
$cis1=1;

$sqlttt = "SELECT * FROM klienti WHERE id_klienta = $cislo_id ";
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 //echo "idem ".$riaddok->uziv_meno;
 $naz_uzm=$riaddok->uziv_meno;
 $naz_uzh=$riaddok->uziv_heslo;
 $naz_prie=$riaddok->priezvisko;
 $naz_meno=$riaddok->meno;
 $naz_all=$riaddok->all_prav;
 $naz_uct=$riaddok->uct_prav;
 $naz_mzd=$riaddok->mzd_prav;
 $naz_skl=$riaddok->skl_prav;
 $naz_fak=$riaddok->fak_prav;
 $naz_him=$riaddok->him_prav;
 $naz_dop=$riaddok->dop_prav;
 $naz_vyr=$riaddok->vyr_prav;
 $naz_ana=$riaddok->ana_prav;
 $naz_txt1=$riaddok->txt1;
 }


//ckli_u.php?copern=8&page=1&cislo_id=17&naz_id=17&naz_uzm=s&naz_uzh=s&naz_prie=analyzy&naz_meno=analyzy14&naz_all=10000&naz_uct=2000&naz_mzd=100
//&naz_skl=0&naz_fak=2000&naz_him=0&naz_dop=3000&naz_vyr=3000&naz_ana=3000&naz_txt1=53-53&cis1=1

  }
?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>».UûÌvateæov</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="js/cookies.js">
</SCRIPT>
<SCRIPT Language="JavaScript">
    <!--

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

<?php
if ( $copern != 6 )
{
?>
      function KontrolaCisla(Vstup, Oznam)
      {
       if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
       else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
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
      document.formv1.h_meno.focus();
      document.formv1.h_meno.select();
      document.formv1.h_id.disabled = true;
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
      document.formv1.h_uzm.focus();
      document.formv1.h_uzm.select();
      document.formv1.h_id.disabled = true;
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
if ( $copern == 5 ) {echo "EuroSecom  -  »ÌselnÌk uûÌvateæov - nov· poloûka ID: AutoINC "; }
if ( $copern == 8 ) {echo "EuroSecom  -  »ÌselnÌk uûÌvateæov - ˙prava poloûky ID: $cislo_id "; }
if ( $copern == 6 ) {echo "EuroSecom  -  »ÌselnÌk uûÌvateæov - vymazanie poloûky ID: $cislo_id "; }
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
<th class="hmenu">IdAuto<th class="hmenu">Login_name<th class="hmenu">Login_heslo<th class="hmenu">Meno
<th class="hmenu">Priezvisko<th class="hmenu">ALL_pr·va<th class="hmenu">UCT_pr·va
<th class="hmenu">MZD_pr·va<th class="hmenu">FAK_pr·va<th class="hmenu">SKL_pr·va<th class="hmenu">HIM_pr·va<th class="hmenu">DOP_pr·va
<th class="hmenu">VYR_pr·va<th class="hmenu">ANA_pr·va
<th class="hmenu">AktualizovanÈ<br />
</tr>

<FORM name="formv1" class="obyc" method="post" onSubmit="return ulozenie();" action="ckli.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=5&"; } ?>
<?php if ( $copern == 5 ) {echo "cislo_id=$npol&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=8&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_id=$cislo_id&"; } ?>
" >
<tr>
<td class="fmenu"><input type="text" name="h_id" id="h_id" size="3" value="" 
onchange="return intg(this,1,9999,Bx)" onkeyup="KontrolaCisla(this, Bx)" />

<td class="fmenu"><input type="text" name="h_uzm" id="h_uzm" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_uzm'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_uzh" id="h_uzh" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_uzh'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_meno" id="h_meno" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_meno'"; } ?>
/>

<td class="fmenu"><input type="text" name="h_prie" id="h_prie" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_prie'"; } ?>
/>

<td class="fmenu"><input type="text" name="h_all" id="h_all" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_all'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_uct" id="h_uct" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_uct'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_mzd" id="h_mzd" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_mzd'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_fak" id="h_fak" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_fak'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_skl" id="h_skl" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_skl'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_him" id="h_him" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_him'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_dop" id="h_dop" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_dop'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_vyr" id="h_vyr" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_vyr'"; } ?>
/>
<td class="fmenu"><input type="text" name="h_ana" id="h_ana" size="6" 
<?php if ( $copern == 8 ) { echo "value='$naz_ana'"; } ?>
/>

<td class="fmenu"><input type="text" name="h_zps" id="h_zps" size="20" /></td>
</tr>
<tr>
<td>Firmy-></td>
<td class="fmenu" colspan="7"><input type="text" name="h_txt1" id="h_txt1" size="80" 
<?php if ( $copern == 8 ) { echo "value='$naz_txt1'"; } ?>
/>

<td colspan="2">
osË->
<input type="text" name="cis1" id="cis1" size="8" 
<?php if ( $copern == 8 ) { echo "value='$cis1'"; } ?>
/>
<td class="hmenu" colspan="3">GridKarta 
<a href="#" onClick="window.open('../cis/grid.php?copern=10&cislo_id=<?php echo $naz_id;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 title="VytlaËiù GridKartu" ></a>
<a href="#" onClick="window.open('../cis/grid.php?copern=11&cislo_id=<?php echo $naz_id;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=12 border=0 title="Vygenerovaù nov˙ GridKartu" ></a>
<a href="#" onClick="window.open('../cis/grid.php?copern=15&cislo_id=<?php echo $naz_id;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/orig.png' width=20 height=12 border=0 title="Nastaviù PIN GridKartu vöetky polia rovnakÈ" ></a>
<a href="#" onClick="window.open('../cis/grid.php?copern=13&cislo_id=<?php echo $naz_id;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/ziarovka.png' width=20 height=12 border=0 title="Nastaviù cviËn˙ GridKartu 1234" ></a>
<a href="#" onClick="window.open('../cis/grid.php?copern=14&cislo_id=<?php echo $naz_id;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/zmazuplne.png' width=20 height=12 border=0 title="Zmazaù GridKartu" ></a>
</tr>
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="INS" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td></td><td></td><td></td><td></td>
<td></td><td></td><td></td><td></td><td></td>
<td></td><td></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Nastav_SEL(); Zakaz_uloz();" id="resetp" name="resetp" value="NUL" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" onSubmit="return ulozenie();" action="ckli.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="ESC" ></td>
<td class="obyc"><SPAN id="vypis">&nbsp;</SPAN></td>
<?php
if ( $copern == 5 )
{
?>
<td></td><td></td><td></td>
<td></td><td></td><td></td><td></td><td></td>
<td></td><td></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Obnov_vstup();" id="obnovp" name="obnovp" value="REP" ></td>
<?php
}
?>
</tr>
</FORM>
<tr>
<td colspan="10">Rozsah prÌstupn˝ch firiem napr: 1-500 AND TABLE fir->prav( SUBSTRING(prav,uzid,1) != n,N ) cez phpadmin</td><td></td><td></td><td></td><td></td>
</tr>
<tr>
<td colspan="10">PrÌstupnÈ menu TABLE menp->sys,cslm,prav( SUBSTRING(prav,uzid,1) != n,N ) cez phpadmin</td><td></td><td></td><td></td><td></td>
</tr>
<tr>
<td colspan="10">PovolenÈ IPX TABLE ak existuje ipxok ipad=245.234.56.xxx cez phpadmin</td><td></td><td></td><td></td><td></td>
</tr>
<tr>
<td colspan="10">Posledne aktualizovanÈ poloûky</td><td></td><td></td><td></td><td></td>
</tr>

<?php
  require_once("pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$sql = mysql_query("SELECT * FROM klienti WHERE all_prav < $min_uzall ORDER BY datm DESC LIMIT 20");
// celkom poloziek
$cpol = mysql_num_rows($sql);
?>

<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu"><?php echo $zaznam["id_klienta"];?></td>
<td class="fmenu"><?php echo $zaznam["uziv_meno"];?></td>
<td class="fmenu"><?php echo $zaznam["uziv_heslo"];?></td>
<td class="fmenu"><?php echo $zaznam["meno"];?></td>
<td class="fmenu"><?php echo $zaznam["priezvisko"];?></td>
<td class="fmenu"><?php echo $zaznam["all_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["uct_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["mzd_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["fak_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["skl_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["him_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["dop_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["vyr_prav"];?></td>
<td class="fmenu"><?php echo $zaznam["ana_prav"];?></td>
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

$sqlp = "SELECT * FROM klienti WHERE id_klienta='$cislo_id'";
$sql = mysql_query("$sqlp");
?>
<table class="fmenu">
<tr>
<th class="hmenu">Id<th class="hmenu">Login_name<th class="hmenu">Login_heslo<th class="hmenu">Meno
<th class="hmenu">Priezvisko<th class="hmenu">ALL_pr·va<th class="hmenu">UCT_pr·va
<th class="hmenu">MZD_pr·va<th class="hmenu">FAK_pr·va<th class="hmenu">SKL_pr·va<th class="hmenu">HIM_pr·va<th class="hmenu">DOP_pr·va
<th class="hmenu">VYR_pr·va<th class="hmenu">ANA_pr·va<th class="hmenu">AktualizovanÈ
</tr><br />

<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" width="5%" ><?php echo $zaznam["id_klienta"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["uziv_meno"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["uziv_heslo"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["meno"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["priezvisko"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["all_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["uct_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["mzd_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["fak_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["skl_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["him_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["dop_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["vyr_prav"];?></td>
<td class="fmenu" width="5%" ><?php echo $zaznam["ana_prav"];?></td>
<td class="fmenu" width="20%"><?php echo $zaznam["datm"];?></td>
</tr>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="ckli.php?page=<?php echo $page;?>&copern=6&cislo_id=<?php echo $cislo_id;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;DEL&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="ckli.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="ESC" ></td>
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