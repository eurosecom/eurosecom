<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 2000;
$clsm = 900;
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

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$strana = 1*$_REQUEST['strana'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
//$cislo_dok=710031;
//echo $cislo_dok;
//exit;

$citfir = include("../cis/citaj_fir.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$zlava = 1*$_REQUEST['zlava'];

//copern=900 uloz nastavenie fak
if( $copern == 900 )
{
$ucm1 = $_REQUEST['h_ucm1'];
$ucm2 = $_REQUEST['h_ucm2'];
$ucm3 = $_REQUEST['h_ucm3'];
$ucm4 = $_REQUEST['h_ucm4'];
$ucm5 = $_REQUEST['h_ucm5'];
$ico1 = 1*$_REQUEST['h_ico1'];
$ico2 = 1*$_REQUEST['h_ico2'];
$ico3 = 1*$_REQUEST['h_ico3'];
$ico4 = 1*$_REQUEST['h_ico4'];
$ico5 = 1*$_REQUEST['h_ico5'];
$premenna = $_REQUEST['premenna'];
$zmd = 1*$_REQUEST['zmd'];
$zdl = 1*$_REQUEST['zdl'];
$omd = 1*$_REQUEST['omd'];
$odl = 1*$_REQUEST['odl'];
$pmd = 1*$_REQUEST['pmd'];
$pdl = 1*$_REQUEST['pdl'];
$u1f = 1*$_REQUEST['u1f'];
$u2f = 1*$_REQUEST['u2f'];
$u3f = 1*$_REQUEST['u3f'];

//if( $zdl == 0 AND $omd == 0 AND $odl == 0 AND $pmd == 0 AND $pdl == 0 ) { $zmd=1; }
if( $ucm5 == 0 ) { $ucm5=40; }
if( $ucm5 > 80 ) { $ucm5=80; }
if( $ucm5 > 40 ) 
{ 
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu MODIFY nsl VARCHAR(80) NOT NULL";
$vysledek = mysql_query("$sql");
}

$ttvv = "DELETE FROM F$kli_vxcf"."_fakturaset$kli_uzid ";
$ttqq = mysql_query("$ttvv");
$ttvv = "DELETE FROM F$kli_vxcf"."_fakturaset ";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_fakturaset ( polozka,ucm1,ucm2,ucm3,ucm4,ucm5,ico1,ico2,ico3,ico4,ico5,zmd,zdl,omd,odl,pmd,pdl ) ".
" VALUES ( '$premenna', '$ucm1', '$ucm2', '$ucm3', '$ucm4', '$ucm5', '$ico1', '$ico2', '$ico3', '$ico4', '$ico5', ".
" '$zmd', '$zdl', '$omd', '$odl', '$pmd', '$pdl' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_fakturaset$kli_uzid ( polozka,ucm1,ucm2,ucm3,ucm4,ucm5,ico1,ico2,ico3,ico4,ico5,zmd,zdl,omd,odl,pmd,pdl ) ".
" VALUES ( '$premenna', '$ucm1', '$ucm2', '$ucm3', '$ucm4', '$ucm5', '$ico1', '$ico2', '$ico3', '$ico4', '$ico5', ".
" '$zmd', '$zdl', '$omd', '$odl', '$pmd', '$pdl' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "DELETE FROM F$kli_vxcf"."_fakodbucb WHERE dok = $cislo_dok ";
$ttqq = mysql_query("$ttvv");
$vsql = "INSERT INTO F".$kli_vxcf."_fakodbucb ( dok, u1f, u2f, u3f ) VALUES ('$cislo_dok', '$u1f', '$u2f', '$u3f') ";
$vytvor = mysql_query("$vsql");

}
//koniec copern=900 uloz nastavenie fak

//zlava faktura
if( $zlava == 1 AND $drupoh != 42 )
{
$h_cep=0;
$h_ced=0;
$zaklad2s=0;
$sqlttt = "SELECT zk2 FROM F$kli_vxcf"."_fakodb WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad2s=1*$riaddok->zk2;
  }

$h_cep=$ico5*$zaklad2s/100;
$h_ced=(100+$fir_dph2)*$h_cep/100;

$textzlavy="Z¾ava ".$ico5."%"; 

$sqty = "INSERT INTO F$kli_vxcf"."_fakslu ( dok,fak,dol,prf,slu,nsl,pop,dph,cep,ced,mno,mer,dfak,cfak,pfak,id,pon )". 
" VALUES ('$cislo_dok', '0', '', '', '0', '$textzlavy', '', '20', '$h_cep', '$h_ced',".
" '-1', '', 0, 0, 0, '$kli_uzid', '' );"; 
$ulozene = mysql_query("$sqty");

$h_cep2=$h_cep;
$h_ced2=$h_ced;
$h_cep0=0;

$sqtz = "UPDATE F$kli_vxcf"."_fakodb SET ".
" zk2=zk2-('$h_cep2'), sp2=sp2-('$h_ced2'), dn2=sp2-zk2,  ".
" zk0=zk0-('$h_cep0'), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";

//echo $sqtz;
$upravene = mysql_query("$sqtz");
//exit;
}
//koniec zlava faktura

//zlava ERP
if( $zlava == 1 AND $drupoh == 42 )
{
//$tabl = "dopreg";
//$tablsluzby = "dopslu";

//dopreg
//uce	ume	dat	dav	das	daz	dok	doq	skl	poh	ico	fak	dol	prf	obj	unk	dpr	
//ksy	ssy	poz	str	zak	txz	txp	zk0	zk1	zk2	zk3	zk4	dn1	dn2	dn3	dn4	cbl	
//cdu	cmu	sp1	sp2	sz1	sz2	sz3	sz4	hod	zal	zao	ruc	uhr	id	datm

//dopslu
//dok	fak	dol	prf	cpl	slu	nsl	pop	pon	dph	cen	cep	ced	mno	mer	pfak	
//cfak	dfak	xfak	id	datm

$h_cep=0;
$h_ced=0;
$zaklad2s=0;
$sqlttt = "SELECT zk2 FROM F$kli_vxcf"."_dopreg WHERE dok = $cislo_dok ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zaklad2s=1*$riaddok->zk2;
  }

$h_cep=$ico5*$zaklad2s/100;
$h_ced=(100+$fir_dph2)*$h_cep/100;
$mnoz=-1;

$h_cep2=$h_cep;
$h_ced2=$h_ced;
$h_cep0=0;

$textzlavy="Z¾ava ".$ico5."%"; 
if( $h_cep < 0 ) 
  {
$h_cep=-1*$h_cep;
$h_ced=-1*$h_ced;
$mnoz=1;

$h_cep2=-1*$h_cep;
$h_ced2=-1*$h_ced;
$h_cep0=0;
  }


$sqty = "INSERT INTO F$kli_vxcf"."_fakslu ( dok,fak,dol,prf,slu,nsl,pop,dph,cep,ced,mno,mer,dfak,cfak,pfak,id,pon )". 
" VALUES ('$cislo_dok', '0', '', '', '0', '$textzlavy', '', '20', '$h_cep', '$h_ced',".
" '$mnoz', '', 0, 0, 0, '$kli_uzid', '' );"; 
$ulozene = mysql_query("$sqty");


$sqtz = "UPDATE F$kli_vxcf"."_dopreg SET ".
" zk2=zk2-($h_cep2), sp2=sp2-($h_ced2), dn2=sp2-zk2,  ".
" zk0=zk0-($h_cep0), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";

//echo $sqtz;
$upravene = mysql_query("$sqtz");
//exit;
}
//koniec zlava ERP

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Nastavenie faktury uloz</title>
  <style type="text/css">

  </style>

<script type="text/javascript">

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />





<?php
//vstf_u.php?vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=31100&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT
//&cislo_dok=710031&h_fak=710031&h_dol=0&h_prf=0

//prepni do faktury
$cstat=10101;
if( $cstat == 10101 AND $drupoh != 42 )
{
?>
<script type="text/javascript">

window.open('../faktury/vstf_u.php?copern=8&drupoh=1&page=1&cislo_dok=<?php echo $cislo_dok; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT', '_self' )

</script>
<?php
exit;
}
if( $cstat == 10101 AND $drupoh == 42 )
{
?>
<script type="text/javascript">

window.open('../faktury/vstf_u.php?copern=8&drupoh=42&page=1&cislo_dok=<?php echo $cislo_dok; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT&regpok=1', '_self' )

</script>
<?php
exit;
}
//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
