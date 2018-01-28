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
$vtvdop = include("../vyroba/vtvvyr.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

//tlacove okno
$tlcuwin="width=850, height=' + vyskawin + ', top=0, left=50, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$citfir = include("../cis/citaj_fir.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";

//vymazanie komponentu
if ( $copern == 116 )
    {
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);
$cislo_nrcp = strip_tags($_REQUEST['cislo_nrcp']);
$cislo_ckmp = strip_tags($_REQUEST['cislo_ckmp']);
$cislo_drdr = strip_tags($_REQUEST['cislo_drdr']);
$cislo_mkmp = strip_tags($_REQUEST['cislo_mkmp']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrrcpp WHERE crcp='$cislo_crcp' AND ckmp='$cislo_ckmp' AND mkmp='$cislo_mkmp' AND drdr='$cislo_drdr' "); 
$copern=108;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA crcp:$cislo_crcp BOLA VYMAZAN¡ ";
endif;
     }
//koniec vymazania komponentu


//ulozenie noveho komponentu
if ( $copern == 115 )
    {
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);
$cislo_nrcp = strip_tags($_REQUEST['cislo_nrcp']);
$h_slu = strip_tags($_REQUEST['h_slu']);
$h_nsl = strip_tags($_REQUEST['h_nsl']);
$h_cen = strip_tags($_REQUEST['h_cen']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_mer = strip_tags($_REQUEST['h_mer']);
$h_drdr = strip_tags($_REQUEST['h_drdr']);
if( $h_drdr != 1 AND $h_drdr != 2 AND $h_drdr != 3 ) $h_drdr=1;

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_vyrrcpp ( crcp,drdr,ckmp,mkmp ) VALUES ('$cislo_crcp', '$h_drdr', '$h_slu', '$h_mno'); "); 
$copern=108;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia komponentu



// 5=ulozenie polozky do databazy nahratej v recepty.php
// 6=vymazanie polozky potvrdene v recepty.php
if ( $copern == 15 || $copern == 16 )
     {
$h_crcp = strip_tags($_REQUEST['h_crcp']);
$h_nrcp = strip_tags($_REQUEST['h_nrcp']);
$h_drcp = strip_tags($_REQUEST['h_drcp']);
$h_prcp = strip_tags($_REQUEST['h_prcp']);
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);
//ulozenie novej
if ( $copern == 15 )
    {

$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_vyrrcph ( crcp,nrcp,drcp,prcp ) VALUES ('$h_crcp', '$h_nrcp', $h_drcp, '$h_prcp'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA crcp:$h_crcp SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrrcph WHERE crcp='$cislo_crcp'"); 
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_vyrrcpp WHERE crcp='$cislo_crcp'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA crcp:$cislo_crcp BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava  18
if ( $copern == 18 )
  {
$h_crcp = strip_tags($_REQUEST['h_crcp']);
$h_nrcp = strip_tags($_REQUEST['h_nrcp']);
$h_drcp = strip_tags($_REQUEST['h_drcp']);
$h_prcp = strip_tags($_REQUEST['h_prcp']);
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);

$upravene = mysql_query("UPDATE F$kli_vxcf"."_vyrrcph SET crcp='$h_crcp', nrcp='$h_nrcp', drcp='$h_drcp', prcp='$h_prcp' WHERE crcp='$cislo_crcp'");  
$copern=1;
$cislo_crcp = $h_crcp;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA crcp:$cislo_crcp UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
      {

$h_crcp = strip_tags($_REQUEST['h_crcp']);
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_vyrrcph WHERE crcp = $cislo_crcp ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_crcp = $riadok->crcp;
$h_nrcp = $riadok->nrcp;
$h_drcp = $riadok->drcp;
$h_prcp = $riadok->prcp;

  }
       }
//koniec uprava nacitanie


//6=uprava
if ( $copern == 6 )
  {
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Recept˙ry</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>

<script type="text/javascript" src="vyr_kom_xml.js"></script>

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


//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;
    }


function DrdrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_slu.focus();
              }
                }


function SluEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.formv1.h_slu.value != ''  )
        {
        New.style.display="none";
        myKompelement.style.display='';
        document.forms.formv1.h_nsl.value = '';
        volajKomp();
        }      

        if( document.formv1.h_slu.value == "" ) {  document.formv1.h_nsl.focus(); }

              }
                }


function NslEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.formv1.h_nsl.value != '' )
        {
        New.style.display="none";
        myKompelement.style.display='';
        document.formv1.h_slu.value = ""; 
        volajKomp();
        }   

        if( document.formv1.h_nsl.value == "" ) { document.formv1.h_slu.focus(); }

              }
                }


function MnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.formv1.h_slu.value == '' ) okvstup=0;
    if ( document.formv1.h_nsl.value == '' ) okvstup=0;
    if ( document.formv1.h_mno.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false); }

              }
                }


//co urobi po potvrdeni ok z tabulky Komp
function vykonajKomp(slu,nazov,cena,mer)
                {
        document.forms.formv1.h_slu.value = slu;
        document.forms.formv1.h_nsl.value = nazov;
        document.forms.formv1.h_cen.value = cena;
        document.forms.formv1.h_mer.value = mer;
        myKompelement.style.display='none';
        document.forms.formv1.h_mno.focus();
        document.forms.formv1.h_mno.select();
                }


function Len1Komp()
                    {
        document.forms.formv1.h_mno.focus();
        document.forms.formv1.h_mno.select();
        myKompelement.style.display='none';
                    }

function Len0Komp()
                    {
        New.style.display="";
        document.forms.formv1.h_nsl.focus();
        document.forms.formv1.h_nsl.select();
                    }


<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nrcp.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//vymazanie
  if ( $copern == 6 OR $copern == 9 OR $copern == 16 )
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
//koniec vymazania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 )
  {
?>

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
<?php
//uprava
  if ( $copern == 8 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.h_crcp.value = '<?php echo "$h_crcp";?>';
    document.formv1.h_nrcp.value = '<?php echo "$h_nrcp";?>';
    document.formv1.h_drcp.value = '<?php echo "$h_drcp";?>';
    document.formv1.h_prcp.value = '<?php echo "$h_prcp";?>';
    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 OR $copern == 8 )
  {
?>

    function Zapis_COOK()
    {

    return (true);
    }

    function Obnov_vstup()
    {

    return (true);
    }


    function VyberVstup()
    {
    document.formv1.h_crcp.focus();
    document.formv1.h_crcp.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_crcp.value == '' ) okvstup=0;
    if ( document.formv1.h_nrcp.value == '' ) okvstup=0;
    if ( document.formv1.h_drcp.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false); }

    }

<?php
//koniec nova,uprava
  }
?>

<?php
//nova
  if ( $copern == 5 )
  { 
?>
    function ObnovUI()
    {
<?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    }

<?php
//koniec nova
  }
?>

<?php
//komponenty
  if ( $copern > 100 )
  {
?>
    function VyberVstup()
    {
    document.formv1.uloz.disabled = true;
    }

    function ObnovUI()
    {

    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_slu.value == '' ) okvstup=0;
    if ( document.formv1.h_mno.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }


<?php
  }
//koniec komponenty
?>



  </script>
</HEAD>
<BODY class="white" onload="ObnovUI(); VyberVstup();" >

<?php 


// aktualna strana
$page = strip_tags($_REQUEST['page']);
//nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<?php
if( $copern < 100 )
{
?>
<td>EuroSecom  -  Recept˙ry v˝robkov
<?php
}
?>
<?php
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);
$cislo_nrcp = strip_tags($_REQUEST['cislo_nrcp']);
if( $copern > 100 )
{
?>
<td>EuroSecom  -  Recept˙ra <?php echo $cislo_crcp; ?> <?php echo $cislo_nrcp; ?>
<?php
}
?>

<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>

</td>
<?php
if( $copern < 100 )
{
?>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
<?php
}
?>
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
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrrcph ORDER BY crcp");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nrcp = strip_tags($_REQUEST['hladaj_nrcp']);
$hladaj_crcp = strip_tags($_REQUEST['hladaj_crcp']);

if ( $hladaj_nrcp != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrrcph WHERE ( nrcp LIKE '%$hladaj_nrcp%' ) ORDER BY crcp");
if ( $hladaj_crcp != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrrcph WHERE ( crcp = '$hladaj_crcp' ) ORDER BY crcp");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_vyrrcph WHERE NOT ( crcp='$cislo_crcp' ) ORDER BY crcp");
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
<FORM name="formhl1" class="hmenu" method="post" action="recepty.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_crcp" id="hladaj_crcp" size="15" value="<?php echo $hladaj_crcp;?>" />
<td class="hmenu"><input type="text" name="hladaj_nrcp" id="hladaj_nrcp" size="50" value="<?php echo $hladaj_nrcp;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="recepty.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>


<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="40%" >N·zov
<td class="hmenu" width="11%" >KategÛria
<td class="hmenu" width="5%" >Col.sadzobnÌk
<td class="hmenu" width="5%" >Uprav
<th class="hmenu" width="5%" >Zmaû
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
<td class="fmenu" ><?php echo $riadok->crcp;?></td>
<td class="fmenu" ><?php echo $riadok->nrcp;?></td>
<td class="fmenu" ><?php echo $riadok->drcp;?></td>
<td class="fmenu" ><?php echo $riadok->prcp;?></td>
<td class="fmenu" >
<a href='recepty.php?copern=8&page=<?php echo $page;?>
&cislo_crcp=<?php echo $riadok->crcp;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0 title="Upraviù n·zov,kategÛrie recept˙ry" ></a>
<a href="#" onClick="window.open('recepty.php?copern=108&cislo_crcp=<?php echo $riadok->crcp;?>
&cislo_nrcp=<?php echo $riadok->nrcp;?>', '_blank', '<?php echo $tlcuwin; ?>' )"> <img src='../obr/zoznam.png' width=20 height=20 border=0 title="Upraviù zoznam komponentov" ></a>
</td>
<td class="fmenu" width="5%" ><a href='recepty.php?copern=6&page=<?php echo $page;?>&cislo_crcp=<?php echo $riadok->crcp;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazanie celÈho receptu" ></a></td>
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
//koniec 1,2,3,4,5,6,7,8,9
?>

<?php
// 6=vymazanie polozky
if ( $copern == 6 )
  {
$h_crcp = strip_tags($_REQUEST['h_crcp']);
$h_nrcp = strip_tags($_REQUEST['h_nrcp']);
$h_drcp = strip_tags($_REQUEST['h_drcp']);
$h_prcp = strip_tags($_REQUEST['h_prcp']);
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_vyrrcph WHERE crcp='$cislo_crcp'";
$sql = mysql_query("$sqlp");
?>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" width="10%" ><?php echo $zaznam["crcp"];?></td>
<td class="fmenu" width="60%" ><?php echo $zaznam["nrcp"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["drcp"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["prcp"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="recepty.php?page=<?php echo $page;?>&copern=16>&cislo_crcp=<?php echo $cislo_crcp;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="recepty.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno nevymazaù" ></td>
</tr>
</FORM>
</table>

<?php
//mysql_close();
mysql_free_result($sql);
  }
//koniec pre vymazanie
?>

<?php
//zobraz pre novu polozku
if ( $copern == 5 OR $copern == 8 )
     {
?>
<tr>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter1 musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parameter2 musÌ byù ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka crcp=<?php echo $h_crcp;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="recepty.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_crcp=$cislo_crcp"; } ?>
" >

<td class="fmenu"><input type="text" name="h_crcp" id="h_crcp" size="20" 
onchange="return intg(this,1,999999,Bx)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Bx)" />

<td class="fmenu"><input type="text" name="h_nrcp" id="h_nrcp" size="50" 
onclick="Fx.style.display='none';" /></td>

<td class="fmenu"><input type="text" name="h_drcp" id="h_drcp" size="20" 
onclick="Fx.style.display='none';"  />

<td class="fmenu"><input type="text" name="h_prcp" id="h_prcp" size="5" 
onchange="return intg(this,1,9999999,Ex)" onClick="return Povol_uloz();" onkeyup="KontrolaCisla(this, Ex)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<td class="obyc" align="right"><INPUT type="reset" onclick="Fx.style.display='none'; VyberVstup();" id="resetp" name="resetp" value="Vymazaù formul·r" ></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="recepty.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
<?php
if ( $copern == 5 )
{
?>
<td class="obyc" align="right"><INPUT type="reset" onclick="Obnov_vstup();" id="obnovp" name="obnovp" value="Opakovaù hodnoty" ></td>
<?php
}
?>
</tr>
</FORM>
</table>
<?php
     }
//koniec zobrazenia pre novu polozku
//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka crcp=<?php echo $cislo_crcp;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka crcp=<?php echo $cislo_crcp;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="recepty.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_crcp=$hladaj_crcp&hladaj_nrcp=$hladaj_nrcp";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="recepty.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_crcp=$hladaj_crcp&hladaj_nrcp=$hladaj_nrcp";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="recepty.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" />
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="recepty.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
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

// polozky receptury
if ( $copern == 108 )
     {
$cislo_crcp = strip_tags($_REQUEST['cislo_crcp']);
$cislo_nrcp = strip_tags($_REQUEST['cislo_nrcp']);

$sqltt = "SELECT drdr,F$kli_vxcf"."_vyrrcpp.ckmp,F$kli_vxcf"."_sklcis.cis,F$kli_vxcf"."_sklcis.nat,F$kli_vxcf"."_vyroperacie.poop,F$kli_vxcf"."_vyroperacie.cen1, ".
" F$kli_vxcf"."_vyrkomp.nkmp,F$kli_vxcf"."_vyrkomp.cenk,F$kli_vxcf"."_vyrkomp.merk,F$kli_vxcf"."_vyrrcpp.mkmp, ".
" F$kli_vxcf"."_sklcis.mer AS mers,F$kli_vxcf"."_vyroperacie.mer AS mero ".
" FROM F$kli_vxcf"."_vyrrcpp".
" LEFT JOIN F$kli_vxcf"."_vyrkomp".
" ON F$kli_vxcf"."_vyrrcpp.ckmp=F$kli_vxcf"."_vyrkomp.ckmp".
" LEFT JOIN F$kli_vxcf"."_vyroperacie".
" ON F$kli_vxcf"."_vyrrcpp.ckmp=F$kli_vxcf"."_vyroperacie.cop".
" LEFT JOIN F$kli_vxcf"."_sklcis".
" ON F$kli_vxcf"."_vyrrcpp.ckmp=F$kli_vxcf"."_sklcis.cis".
" WHERE crcp = $cislo_crcp ORDER BY drdr,crcp,F$kli_vxcf"."_vyrkomp.ckmp";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="5%" >Druh
 <img src='../obr/info.png' width=12 height=12 border=0 title="Druh vstupu 1=komponent, 2=v˝robn· oper·cia, 3=skladov· poloûka(priemernÈ ceny)">
<td class="hmenu" width="10%" >KOMP/OPER/CIS
<td class="hmenu" width="40%" >N·zov
<td class="hmenu" width="10%" >Cena
<td class="hmenu" width="10%" >MJ
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
<tr>
<td class="fmenu" ><?php echo $riadok->drdr;?></td>
<td class="fmenu" ><?php echo $riadok->ckmp;?></td>
<?php
  if ( $riadok->drdr != 2 AND $riadok->drdr != 3 )
  {
?>
<td class="fmenu" ><?php echo $riadok->nkmp;?></td>
<td class="fmenu" ><?php echo $riadok->cenk;?></td>
<td class="fmenu" ><?php echo $riadok->merk;?></td>
<?php
  }
?>
<?php
  if ( $riadok->drdr == 2 )
  {
?>
<td class="fmenu" ><?php echo $riadok->poop;?></td>
<td class="fmenu" ><?php echo $riadok->cen1;?></td>
<td class="fmenu" ><?php echo $riadok->mero;?></td>
<?php
  }
?>
<?php
  if ( $riadok->drdr == 3 )
  {
?>
<td class="fmenu" ><?php echo $riadok->nat;?></td>
<td class="fmenu" ><?php echo $riadok->cen;?></td>
<td class="fmenu" ><?php echo $riadok->mers;?></td>
<?php
  }
?>
<td class="fmenu" ><?php echo $riadok->mkmp;?></td>
<td class="fmenu" width="5%" ><a href='recepty.php?copern=116&cislo_crcp=<?php echo $cislo_crcp;?>
&cislo_nrcp=<?php echo $cislo_nrcp;?>&cislo_ckmp=<?php echo $riadok->ckmp;?>&cislo_drdr=<?php echo $riadok->drdr;?>
&cislo_mkmp=<?php echo $riadok->mkmp;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazanie komponentu/oper·cie" ></a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="recepty.php?copern=115&cislo_crcp=<?php echo $cislo_crcp;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_drdr" id="h_drdr" size="2" value="1"
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return DrdrEnter(event.which)" /> 

<td class="hmenu"><input type="text" name="h_slu" id="h_slu" size="8" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return SluEnter(event.which)"/>

<td class="hmenu"><input type="text" name="h_nsl" id="h_nsl" size="40" 
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return NslEnter(event.which)" /> 

<img src='../obr/hladaj.png' border="0" title="Hæadaj zadanÈ ËÌslo alebo n·zov materi·lu" onclick="myKompelement.style.display=''; New.style.display='none'; Fx.style.display='none'; volajKomp();">


<td class="hmenu"><input type="text" name="h_cen" id="h_cen" size="8" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_mer" id="h_mer" size="8" disabled="disabled" /> 

<td class="hmenu"><input type="text" name="h_mno" id="h_mno" size="8" 
 onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" 
 onKeyDown="return MnoEnter(event.which)" /> 

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

<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<?php
     }
//koniec polozky receptury

// celkovy koniec dokumentu
$cislista = include("vyr_lista.php");
       } while (false);
?>
</BODY>
</HTML>
