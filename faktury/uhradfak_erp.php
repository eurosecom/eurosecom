<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'FAK';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kopia_dok = 1*strip_tags($_REQUEST['kopia_dok']);

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


if ( $copern == 20 )
        {
?>
<script type="text/javascript">
if( !confirm ("Chcete uhradiù fakt˙ru <?php echo $kopia_dok; ?> cez RRP  ?") )
         { location.href='vstfak.php?copern=1&drupoh=1&page=1&page=1';  }

else
         { location.href='uhradfak_erp.php?copern=2&kopia_dok=<?php echo $kopia_dok; ?>';  }

</script>
<?php
exit;
        }


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$cislo_dok=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopreg WHERE dok > 0 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_dok=$riaddok->dok+1;
  $uce=1*$riaddok->uce;
  }


$dnes_sql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 


$cbl=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dopreg WHERE dok > 0 AND dat = '$dnes_sql' ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cbl=$riaddok->fak+1;
  }


$pole = explode("-", $dnes_sql);
$kli_vmesx=$pole[1];
$kli_vrokx=$pole[0];

$ume=$kli_vmesx.".".$kli_vrokx;
$txp="⁄hrada fakt˙ry ".$kopia_dok;

if( $kopia_dok > 0 )
          {

//dopreg
//uce	ume	dat	dav	das	daz	dok	doq	skl	poh	ico	fak	dol	prf	obj	unk	dpr	
//ksy	ssy	poz	str	zak	txz	txp	
//zk0	zk1	zk2	zk3	zk4	dn1	dn2	dn3	dn4	cbl	cdu	cmu	sp1	sp2	sz1	sz2	sz3	sz4	
//hod	zal	zao	ruc	uhr	id	datm

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopreg SELECT ".
" $uce,$ume,'$dnes_sql','','$dnes_sql','$dnes_sql',$cislo_dok,$cislo_dok,0,0,ico,$cbl,'','','','','','','','',0,0,'','$txp', ".
" hod, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, hod, 0, 0, 0, 0, 0, ".
" hod, zal, zao, ruc, uhr, ".
" $kli_uzid,now()  ".
" FROM F$kli_vxcf"."_fakodb ".
" WHERE dok=$kopia_dok ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//dopslu
//dok	fak	dol	prf	cpl	slu	nsl	pop	pon	dph	cen	cep	ced	mno	mer	
//pfak	cfak	dfak	xfak	id	datm   

$nsl="ERP uhrada fa ".$kopia_dok;

$dsqlt = "INSERT INTO F$kli_vxcf"."_dopslu "." SELECT".
" $cislo_dok,$cbl,'','',0,103,'$nsl','','',0,hod,hod,hod,1,'',".
" 0,0,0,0,$kli_uzid,now()  ".
" FROM F$kli_vxcf"."_fakodb ".
" WHERE F$kli_vxcf"."_fakodb.dok=$kopia_dok ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");




          }

//exit;

?> 
<script type="text/javascript">
  var okno = window.open("../faktury/vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=42&page=1&cislo_dok=<?php echo $cislo_dok; ?>&hladaj_uce=<?php echo $uce; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT","_self");
</script>
<?php 


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Presun FAK do ERP</title>
<script type="text/javascript">
</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Presun FAK do ERP

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
