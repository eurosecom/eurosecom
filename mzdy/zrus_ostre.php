<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
$ostre = 1*$_REQUEST['ostre'];

//test zrusenia ci chcem a ci je urcite ostre
if( $copern == 1 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete zruši ostré spracovanie za obdobie <?php echo $kli_vume; ?> ?") )
         { window.close();  }
else
  var okno = window.open("../mzdy/zrus_ostre.php?&copern=2&page=1&ostre=1","_self");
</script>

<?php
exit;
}

if( $copern == 2 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp == 0 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie <?php echo $kli_vume; ?> , \r neboli spracované naostro !");
window.close();
</script>
<?php
exit;
}
    }

if( $copern == 2 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdmes WHERE oc >= 0 ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
?>
<script type="text/javascript">
alert ("V mesaènej dávke miezd sú nahraté údaje, \r nemôete ruši spracovanie !");
window.close();
</script>
<?php
exit;
}
    }

if( $copern == 2 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume > $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

$nedovolrusit=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzddovolrusit";
$vysledok = mysql_query("$sql");
if (!$vysledok) { $nedovolrusit=1; }

if( $umesp > 0 AND $nedovolrusit == 1 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie vyššie ako <?php echo $kli_vume; ?> boli spracované naostro, \r nemôete ruši ostré spracovanie za <?php echo $kli_vume; ?> !");
window.close();
</script>
<?php
exit;
}
    }

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$vyb_osc=0;
$all_oc=1;
$data_zal=1;
if( $copern == 101 ) { $vyb_osc = 1*$_SESSION['vyb_osc']; $all_oc=0; $copern=1; $data_zal=0; }

$podm_oc="oc > 0";
$mzdmes="mzdzalmes";
$mzdtrn="mzdzaltrn";
$mzdddp="mzdzalddp";
$mzdkun="mzdzalkun";
$mzdprm="mzdzalprm";
if( $all_oc == 0 )
{
$podm_oc="oc = ".$vyb_osc;
}

if( $copern == 1 ) { $data_zal=0; }

if( $data_zal == 0 )
{
$mzdmes="mzdmes";
$mzdtrn="mzdtrn";
$mzdddp="mzdddp";
$mzdkun="mzdkun";
$mzdprm="mzdprm";
}

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zrušenie ostrého spracovania</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    



</script>
</HEAD>
<BODY class="white" >

<?php
//obnova databaz pri ruseni ostreho
if( $copern == 2 AND $ostre == 1 )
     {

 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdkun WHERE oc >= 0 "; 
 $vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdkun"." SELECT ".
"oc,meno,prie,rodn,prbd,titl,akt,rdc,rdk,dar,mnr,cop,zmes,zpsc,zcdm,zuli,zema,ztel,pom,kat,wms,stz,zkz,uva,uvazn,dan,dav,".
"nev,nrk,crp,znah,znem,doch,docv,dad,dvy,cdss,roh,spno,dsp,spnie,deti_sp,zrz_dn,ziv_dn,deti_dn,zpno,zpnie,dvp,zdrv,trd,".
"sz0,sz1,sz2,sz3,sz4,sz5,vban,uceb,numb,vsy,ksy,ssy,datm".
" FROM F$kli_vxcf"."_mzdzalkun".
" WHERE ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");

 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE oc >= 0 "; 
 $vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdtrn"." SELECT ".
"0,oc,dm,kc,mn,trx1,trx2,trx3,trx4,uceb,numb,vsy,ksy,ssy,datm".
" FROM F$kli_vxcf"."_mzdzaltrn".
" WHERE ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdmes"." SELECT ".
"0,dok,dat,ume,oc,dm,dp,dk,dni,hod,mnz,saz,kc,str,zak,stj,msx1,msx2,msx3,msx4,pop,id,datm".
" FROM F$kli_vxcf"."_mzdzalmes".
" WHERE ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");

 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE oc >= 0 "; 
 $vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdddp"." SELECT ".
"0,oc,perz_dd,fixz_dd,perp_dd,fixp_dd,cddp,czm,dtd,pd1,pd2,pd3,pd4,datm".
" FROM F$kli_vxcf"."_mzdzalddp".
" WHERE ume = $kli_vume ";
$dsql = mysql_query("$dsqlt");



 //zmaz zalohy v ZAL
 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume "; 
 $vysledok = mysql_query("$sqlt");
 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdzaltrn WHERE ume = $kli_vume "; 
 $vysledok = mysql_query("$sqlt");
 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdzalmes WHERE ume = $kli_vume "; 
 $vysledok = mysql_query("$sqlt");
 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdzalprm WHERE ume = $kli_vume "; 
 $vysledok = mysql_query("$sqlt");
 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdzalddp WHERE ume = $kli_vume "; 
 $vysledok = mysql_query("$sqlt");
 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdzalvy WHERE ume = $kli_vume "; 
 $vysledok = mysql_query("$sqlt");
 $sqlt = "DELETE FROM F$kli_vxcf"."_mzdzalsum WHERE ume = $kli_vume "; 
 $vysledok = mysql_query("$sqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdneprav WHERE umex = $kli_vume  ";
$dsql = mysql_query("$dsqlt");

 $sqlt = "DROP TABLE F$kli_vxcf"."_mzddovolrusit "; 
 $vysledok = mysql_query("$sqlt");

//zmaz nemoc.zaklady bezny rok pri ostrom
$sqlt = "DROP TABLE F".$kli_vxcf."_mzdnemzakb ";
$vysledok = mysql_query("$sqlt");

?>
<script type="text/javascript">
alert ("Ostré spracovanie za obdobie <?php echo $kli_vume; ?> \r bolo zrušené !");
window.close();
</script>
<?php
exit;
     }

//koniec obnova databaz
?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
