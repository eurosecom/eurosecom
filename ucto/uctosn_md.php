<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$cslm=100720;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvvyr = include("../ucto/vtvuct.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$uloz="NO";
$zmaz="NO";
$uprav="NO";

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//oprava uct.osnovy cvicnej
    if ( $copern == 1 )
    {

$poslhh = "SELECT * FROM F$kli_vxcf"."_uctosnova ".
" WHERE ( uce = 21100 OR uce = 22100 OR uce = 31100 OR uce = 32100 OR uce = 50100 OR uce = 50400 OR uce = 60100 OR uce = 60400 ) AND crv = 1 AND crs = 1 ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 AND $kli_vrok >= 2010 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=56  WHERE uce = 21100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=57  WHERE uce = 22100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=48  WHERE uce = 31100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=106 WHERE uce = 32100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=9,  crs=0   WHERE uce = 50100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=2,  crs=0   WHERE uce = 50400 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=5,  crs=0   WHERE uce = 60100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=1,  crs=0   WHERE uce = 60400 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
}
    }
//koniec oprava uct.osnovy cvicnej


//nacitanie standartnej uctovej osnovy z tabulky zrusene
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˙ ˙Ëtov˙ osnovu z uctosnova_PU(JU) ?") )
         { window.close()  }
else
         { location.href='uctosn.php?sys=<?php echo $sys; ?>&copern=156&page=1'  }
</script>
<?php
    }

    if ( $copern == 156 )
    {
$copern=1;

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctosnova".
" SELECT uce,nuc,crv,crs,pmd,pda,prm1,prm2,prm3,prm4,ucc".
" FROM uctosnova_JU".
"";

$dsqlt2 = "INSERT INTO F$kli_vxcf"."_uctosnova".
" SELECT uce,nuc,crv,crs,pmd,pda,prm1,prm2,prm3,prm4,ucc".
" FROM uctosnova_PU".
"";

//echo $dsqlt;
if( $kli_vduj == 9 ) $dsql = mysql_query("$dsqlt");
if( $kli_vduj != 9 ) $dsql = mysql_query("$dsqlt2");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctosnova2';
$vysledok = mysql_query("$sqlt");

//koniec nacitania standartnej uctovej osnovy z tabulky zrusene
    }


//import z ../import//UCTOSNova2013.CSV
    if ( $copern == 55 )
    {
$jejednoduche="";
if( $kli_vduj == 9 ) { $jejednoduche="ju"; }
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˙ ˙Ëtov˙ osnovu \r zo s˙boru ../import/uctosnova<?php echo $kli_vrok; ?><?php echo $jejednoduche; ?>.csv ?") )
         { window.close()  }
else
         { location.href='uctosn.php?sys=<?php echo $sys; ?>&copern=56&page=1'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;
$jejednoduche="";
if( $kli_vduj == 9 ) { $jejednoduche="ju"; }

if( file_exists("../import/uctosnova$kli_vrok$jejednoduche.csv")) echo "S˙bor ../import/uctosnova$kli_vrok$jejednoduche.csv existuje<br />";

$subor = fopen("../import/uctosnova$kli_vrok$jejednoduche.csv", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_drd = $pole[0];
  $x_uce = $pole[1];
  $x_nuc = $pole[2];
  $x_crv = $pole[3];
  $x_crs = $pole[4];
  $x_pmd = $pole[5];
  $x_pda = $pole[6];
  $x_prm1 = $pole[7];
  $x_prm2 = $pole[8];
  $x_prm3 = $pole[9];
  $x_prm4 = $pole[10];
  $x_ucc = $pole[11];

//0;uce;nuc;crv;crs;pmd;pda;prm1;prm2;prm3;prm4;ucc
//1;01100;ZriaÔovacie n·klady;0;4;0.00;0.00;0;0;3;3;1100
 
$c_uce=1*$x_uce;
$c_drd=1*$x_drd;

if( $c_uce >= 0 AND $c_drd == 1 )
 {
$sqult = "INSERT INTO F$kli_vxcf"."_uctosnova ( uce,nuc,crv,crs,pmd,pda,prm1,prm2,prm3,prm4,ucc )".
" VALUES ( '$x_uce', '$x_nuc', '$x_crv', '$x_crs', '0', '0',".
" '$x_prm1', '$x_prm2', '$x_prm3', '$x_prm4', '$x_ucc'  ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
 }

}

echo "Tabulka F$kli_vxcf"."_uctosnova!"." naimportovan· <br />";

fclose ($subor);

//tymto zaistim ze upravenu uctosnovu2013 uz nebude vo vykaze privyd prepocitavat
if( $kli_vrok == 2013 )
   {

$sqlt = <<<prcdatum
(
   uxx         VARCHAR(10)
);
prcdatum;

$vsql = "CREATE TABLE F".$kli_vxcf."_uctgenvpv2013 ".$sqlt;
$vytvor = mysql_query("$vsql");

   }
//koniec uprava generovania vykazu prijmov a vydavkov

    }
//koniec import z ../import//UCTOSNova2013.CSV


//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r ˙Ëtovej osnovy ?") )
         { window.close()  }
else
         { location.href='uctosn.php?sys=<?php echo $sys; ?>&copern=167&page=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_uctosnova';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_uctosnova!"." vynulovan· <br />";
    }



// 5=ulozenie polozky do databazy nahratej v uctosn.php
// 6=vymazanie polozky potvrdene v uctosn.php
if ( $copern == 15 || $copern == 16 )
     {
$h_uce = strip_tags($_REQUEST['h_uce']);
$h_nuc = strip_tags($_REQUEST['h_nuc']);
$h_crv = strip_tags($_REQUEST['h_crv']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_pmd = strip_tags($_REQUEST['h_pmd']);
$h_pda = strip_tags($_REQUEST['h_pda']);
$h_prm1 = strip_tags($_REQUEST['h_prm1']);
$h_prm2 = strip_tags($_REQUEST['h_prm2']);
$cislo_uce = strip_tags($_REQUEST['cislo_uce']);
//ulozenie novej
if ( $copern == 15 )
    {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctosnova2';
$vysledok = mysql_query("$sqlt");

$h_ucc=1*$h_uce;
$ulozene = mysql_query("INSERT INTO F$kli_vxcf"."_uctosnova ( uce,nuc,crv,crs,pmd,pda,prm1,prm2,ucc ) VALUES ('$h_uce', '$h_nuc', '$h_crv', '$h_crs', '$h_pmd', '$h_pda', '$h_prm1', '$h_prm2', '$h_ucc'); "); 
$copern=5;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA uce:$h_uce SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctosnova2';
$vysledok = mysql_query("$sqlt");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_uctosnova WHERE ( uce='$cislo_uce' OR uce='' )"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA uce:$cislo_uce BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctosnova2';
$vysledok = mysql_query("$sqlt");

$h_uce = strip_tags($_REQUEST['h_uce']);
$h_nuc = strip_tags($_REQUEST['h_nuc']);
$h_crv = strip_tags($_REQUEST['h_crv']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_pmd = strip_tags($_REQUEST['h_pmd']);
$h_pda = strip_tags($_REQUEST['h_pda']);
$h_prm1 = strip_tags($_REQUEST['h_prm1']);
$h_prm2 = strip_tags($_REQUEST['h_prm2']);
$cislo_uce = strip_tags($_REQUEST['cislo_uce']);
$h_ucc=1*$h_uce;

$upravtt = "UPDATE F$kli_vxcf"."_uctosnova SET uce='$h_uce', nuc='$h_nuc', crv='$h_crv', crs='$h_crs',".
" pmd='$h_pmd', pda='$h_pda', prm1='$h_prm1', prm2='$h_prm2', ucc='$h_ucc' WHERE uce='$cislo_uce'";  
$upravene = mysql_query("$upravtt");  
$copern=1;
$cislo_uce = $h_uce;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA uce:$cislo_uce UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
      {

$h_uce = strip_tags($_REQUEST['h_uce']);
$cislo_uce = strip_tags($_REQUEST['h_uce']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce = $cislo_uce ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_nuc = $riadok->nuc;
$h_crv = $riadok->crv;
$h_crs = $riadok->crs;
$h_pmd = $riadok->pmd;
$h_pda = $riadok->pda;
$h_prm1 = $riadok->prm1;
$h_prm2 = $riadok->prm2;
  }
       }
//koniec uprava nacitanie

//6=uprava
if ( $copern == 6 )
  {
$cislo_uce = strip_tags($_REQUEST['cislo_uce']);
  }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>⁄Ëtov· osnova</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

//posuny enter

function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_nuc.focus();
        document.forms.formv1.h_nuc.select();
              }
                }

function NucEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_crv.focus();
        document.forms.formv1.h_crv.select();
              }
                }

function CrvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_crs.focus();
        document.forms.formv1.h_crs.select();
              }
                }

function CrsEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_pmd.focus();
        document.forms.formv1.h_pmd.select();
              }
                }

function PmdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_pda.focus();
        document.forms.formv1.h_pda.select();
              }
                }

function PdaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_prm1.focus();
        document.forms.formv1.h_prm1.select();
              }
                }

function Prm1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_prm2.focus();
        document.forms.formv1.h_prm2.select();
              }
                }

function Prm2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_uce.value == '' ) okvstup=0;
    if ( document.formv1.h_nuc.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_uce.value == '' ) { document.formv1.h_uce.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nuc.value == '' ) { document.formv1.h_nuc.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

//koniec posuny enter

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;

         if (b == "") { err=0 }
         if (Math.floor(b)==b && b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9]/g) != -1) { err=1 }
         if (Math.floor(b)!=b && b != "") { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         errflag.value = "0";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
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
         errflag.value = "0";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
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

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nuc.focus();
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
    document.formv1.h_uce.value = '<?php echo "$h_uce";?>';
    document.formv1.h_nuc.value = '<?php echo "$h_nuc";?>';
    document.formv1.h_crv.value = '<?php echo "$h_crv";?>';
    document.formv1.h_crs.value = '<?php echo "$h_crs";?>';
    document.formv1.h_pmd.value = '<?php echo "$h_pmd";?>';
    document.formv1.h_pda.value = '<?php echo "$h_pda";?>';
    document.formv1.h_prm1.value = '<?php echo "$h_prm1";?>';
    document.formv1.h_prm2.value = '<?php echo "$h_prm2";?>';
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

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
     else { Oznam.style.display="none"; }
    }

    function VyberVstup()
    {
    document.formv1.h_uce.focus();
    document.formv1.h_uce.select();
    document.formv1.h_ne1.disabled = true;
    document.formv1.h_ne2.disabled = true;
    document.formv1.uloz.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_uce.value == '' ) okvstup=0;
    if ( document.formv1.h_nuc.value == '' ) okvstup=0;
    if ( document.formv1.h_crv.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

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
<td>EuroSecom
<?php
//podvojne
if ( $kli_vduj != 9 )
{
echo "  -  ⁄Ëtov· osnova PU ";
}
//jednoduche
if ( $kli_vduj == 9 )
{
echo "  -  ⁄Ëtov· osnova=Druhy pohybov JU ";
}
?>
<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
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
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova ORDER BY ucc");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nuc = strip_tags($_REQUEST['hladaj_nuc']);
$hladaj_uce = strip_tags($_REQUEST['hladaj_uce']);

if ( $hladaj_nuc != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE ( nuc LIKE '%$hladaj_nuc%' ) ORDER BY ucc");
if ( $hladaj_uce != "" )
{
if( strlen($hladaj_uce) == 3 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE ( LEFT(uce,3) = '$hladaj_uce' ) ORDER BY ucc"); }
if( strlen($hladaj_uce) != 3 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE ( uce = '$hladaj_uce' ) ORDER BY ucc"); }
}
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctosnova WHERE NOT ( uce='$cislo_uce' ) ORDER BY ucc");
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
<FORM name="formhl1" class="hmenu" method="post" action="uctosn.php?page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<a href="#" onClick="window.open('uctosn_pdf.php?copern=10&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË ˙Ëtovej osnovy s poËiatoËn˝m stavom vo form·te PDF' ></a>

<a href="#" onClick="window.open('uctosn_pdf.php?copern=10&page=1&podsuvahy=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË pods˙vahov˝ch ˙Ëtov vo form·te PDF' ></a>
<td class="hmenu" >
<a href="#" onClick="window.open('uctosn_pdf.php?copern=40&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË uzatvorenia ˙Ëtovnej knihy vo form·te PDF - musÌte najprv spracovaù Obratov˙ predvahu za 12.<?php echo $kli_vrok; ?>' ></a>

<a href="#" onClick="window.open('uctosn_pdf.php?copern=50&page=1', '_blank', '<?php echo $tlcswin; ?>' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË otvorenia ˙Ëtovnej knihy vo form·te PDF - musÌte najprv preniesù ˙daje z minulÈho roka' ></a>
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<?php
$jejednoduche="";
if( $kli_vduj == 9 ) { $jejednoduche="ju"; }
if ( $kli_uzall > 25000 )
  {
?>
<td class="hmenu" ><a href='uctosn.php?sys=<?php echo $sys; ?>&copern=67&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek ˙Ëtovnej osnovy"></a>

<td class="hmenu" ><a href='uctosn.php?sys=<?php echo $sys; ?>&copern=55&page=1'>
<img src='../obr/orig.png' width=20 height=15 border=0 title="ätandartn· osnova zo s˙boru ../import/uctosnova<?php echo $kli_vrok; ?><?php echo $jejednoduche; ?>.csv"></a>

<?php
  }
?>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_uce" id="hladaj_uce" size="15" value="<?php echo $hladaj_uce;?>" />
<td class="hmenu"><input type="text" name="hladaj_nuc" id="hladaj_nuc" size="50" value="<?php echo $hladaj_nuc;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="uctosn.php?page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>



<?php
//podvojne
if ( $kli_vduj != 9 )
{
?>
<tr>
<td class="hmenu" width="10%" >⁄Ëet
<td class="hmenu" width="40%" >N·zov
<td class="hmenu" width="5%" >»RV
 <img src='../obr/info.png' width=12 height=12 border=0 
 title="»RV = ËÌslo riadku vo V˝kaze ziskov a str·t">
<?php
if ( $copern == 8 AND $kli_vduj != 9 )
  {
?>
<a href="#" onClick="window.open('uctosn_nacitaj.php?copern=1&page=1', '_self' )">
<img src='../obr/import.png' width=12 height=12 border=1 title='NaËÌtaù CRV a CSV zo z·lohy ⁄Ëtovnej osnovy' ></a>
<?php
  }
?>
<td class="hmenu" width="5%" >»RS
 <img src='../obr/info.png' width=12 height=12 border=1 
 title="»RV = ËÌslo riadku v S˙vahe">
<td class="hmenu" width="10%" >PoËiatok M·Daù
<td class="hmenu" width="10%" >PoËiatok Dal
<td class="hmenu" width="5%" >PRM1
<td class="hmenu" width="5%" >PRM2
<td class="hmenu" width="5%" >Uprav
<th class="hmenu" width="5%" >Zmaû
</tr>
<?php
}
?>
<?php
//podvojne
if ( $kli_vduj == 9 )
{
?>
<tr>
<td class="hmenu" width="10%" >Druh
<td class="hmenu" width="40%" >N·zov
<td class="hmenu" width="5%" >»RV
 <img src='../obr/info.png' width=12 height=12 border=0 
 title="»RV = ËÌslo riadku vo V˝kaze o prÌjmoch a v˝davkoch">
<td class="hmenu" width="5%" >»RS
 <img src='../obr/info.png' width=12 height=12 border=0 
 title="»RV = ËÌslo riadku vo V˝kaze o majetku a z·v‰zkoch">
<td class="hmenu" width="10%" >PoË.stav
 <img src='../obr/info.png' width=12 height=12 border=0 
 title="PoËiatoËn˝ stav finanËn˝ch prostriedkov pokladnice alebo bankovÈho ˙Ëtu">
<td class="hmenu" width="10%" >NepouûitÈ
<td class="hmenu" width="5%" >VPR
 <img src='../obr/info.png' width=12 height=12 border=0 
 title="VPR 1=pohyb pri prÌjme peÚazÌ , 2=pohyb pri v˝daji peÚazÌ , inÈ=ËÌsla pokladnÌc,bankov˝ch ˙Ëtov,DPH,priebeûn· poloûka...">
<td class="hmenu" width="5%" >ZAP
 <img src='../obr/info.png' width=12 height=12 border=0 
 title="ZAP 1=zapoËÌtanÈ do daÚovÈho z·kladu , 2 alebo inÈ=nezapoËÌtanÈ do daÚovÈho z·kladu">
<td class="hmenu" width="5%" >Uprav
<th class="hmenu" width="5%" >Zmaû
</tr>
<?php
}
?>

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
<td class="fmenu" ><?php echo $riadok->uce;?></td>
<td class="fmenu" ><?php echo $riadok->nuc;?></td>
<td class="fmenu" ><?php echo $riadok->crv;?></td>
<td class="fmenu" ><?php echo $riadok->crs;?></td>
<td class="fmenu" ><?php echo $riadok->pmd;?></td>
<td class="fmenu" ><?php echo $riadok->pda;?></td>
<td class="fmenu" ><?php echo $riadok->prm1;?></td>
<td class="fmenu" ><?php echo $riadok->prm2;?></td>
<td class="fmenu" ><a href='uctosn.php?copern=8&page=<?php echo $page;?>&cislo_uce=<?php echo $riadok->uce;?>
&h_uce=<?php echo $riadok->uce;?>'> <img src='../obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href="uctosn.php?copern=6&page=<?php echo $page;?>&cislo_uce=<?php echo $riadok->uce;?>">Zmaû</a></td>
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
$h_uce = strip_tags($_REQUEST['h_uce']);
$h_nuc = strip_tags($_REQUEST['h_nuc']);
$h_crv = strip_tags($_REQUEST['h_crv']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_pmd = strip_tags($_REQUEST['h_pmd']);
$h_pda = strip_tags($_REQUEST['h_pda']);
$h_prm1 = strip_tags($_REQUEST['h_prm1']);
$h_prm2 = strip_tags($_REQUEST['h_prm2']);
$cislo_uce = strip_tags($_REQUEST['cislo_uce']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_uctosnova WHERE uce='$cislo_uce'";
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
<td class="fmenu" width="10%" ><?php echo $zaznam["uce"];?></td>
<td class="fmenu" width="40%" ><?php echo $zaznam["nuc"];?></td>
<td class="fmenu" width="10%" ><?php echo $zaznam["crv"];?></td>
<td class="fmenu" width="9%" ><?php echo $zaznam["crs"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["pmd"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["pda"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["prm1"];?></td>
<td class="fmenu" width="7%" ><?php echo $zaznam["prm2"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="uctosn.php?page=<?php echo $page;?>&copern=16>&cislo_uce=<?php echo $cislo_uce;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="uctosn.php?page=<?php echo $page;?>&copern=1" >
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
<span id="Uce" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 ⁄Ëet musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù celÈ ËÌslo </span>
<span id="Desat" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota  musÌ byù desatinnÈ ËÌslo </span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka uce=<?php echo $h_uce;?> spr·vne uloûen·</span>
</tr>
<tr>
<FORM name="formv1" class="obyc" method="post" action="uctosn.php?page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_uce=$cislo_uce"; } ?>
" >

<td class="fmenu"><input type="text" name="h_uce" id="h_uce" size="5" onclick="Fx.style.display='none';"
 onKeyDown="return UceEnter(event.which)"
 onchange="return intg(this,0,9999999,Uce,document.formv1.err_uce)" 
 onkeyup="KontrolaCisla(this, Uce)" />
<INPUT type="hidden" name="err_uce" value="0"></td>


<td class="fmenu"><input type="text" name="h_nuc" id="h_nuc" size="40" 
 onKeyDown="return NucEnter(event.which)"
 /></td>

<td class="fmenu"><input type="text" name="h_crv" id="h_crv" size="5" 
 onKeyDown="return CrvEnter(event.which)"
 onchange="return intg(this,0,999,Cele,document.formv1.err_crv)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_crv" value="0"></td>

<td class="fmenu"><input type="text" name="h_crs" id="h_crs" size="5" 
 onKeyDown="return CrsEnter(event.which)"
 onchange="return intg(this,0,999,Cele,document.formv1.err_crs)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_crs" value="0"></td>

<td class="fmenu"><input type="text" name="h_pmd" id="h_pmd" size="11" 
 onKeyDown="return PmdEnter(event.which)"
 onchange="return cele(this,-9999999,9999999,Desat,2,document.formv1.err_pmd)" 
 onkeyup="KontrolaDcisla(this, Desat)"  />
<INPUT type="hidden" name="err_pmd" value="0"></td>

<td class="fmenu"><input type="text" name="h_pda" id="h_pda" size="11" 
 onKeyDown="return PdaEnter(event.which)"
 onchange="return cele(this,-9999999,9999999,Desat,2,document.formv1.err_pda)" 
 onkeyup="KontrolaDcisla(this, Desat)"  />
<INPUT type="hidden" name="err_pda" value="0"></td>

<td class="fmenu"><input type="text" name="h_prm1" id="h_prm1" size="5" onclick="Fx.style.display='none';" 
 onKeyDown="return Prm1Enter(event.which)"
 onchange="return intg(this,0,999,Cele,document.formv1.err_prm1)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_prm1" value="0"></td>

<td class="fmenu"><input type="text" name="h_prm2" id="h_prm2" size="5" onclick="Fx.style.display='none';" 
 onKeyDown="return Prm2Enter(event.which)"
 onchange="return intg(this,0,999,Cele,document.formv1.err_prm2)" 
 onkeyup="KontrolaCisla(this, Cele)" />
<INPUT type="hidden" name="err_prm2" value="0"></td>

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="5" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="5" /></td>

</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="uctosn.php?page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
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
 Poloûka uce=<?php echo $cislo_uce;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka uce=<?php echo $cislo_uce;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="uctosn.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_uce=$hladaj_uce&hladaj_nuc=$hladaj_nuc";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="uctosn.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_uce=$hladaj_uce&hladaj_nuc=$hladaj_nuc";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="uctosn.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="uctosn.php?copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
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

// celkovy koniec dokumentu
$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
