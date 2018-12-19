<HTML>
<?php

do
{
$sys = 'FAK';
$urov = 2000;
$drupoh = $_REQUEST['drupoh'];


$uziv = include("../uziv.php");
if( !$uziv ) exit;

$copern = $_REQUEST['copern'];
$cislo_dok = $_REQUEST['cislo_dok'];
$hladaj_uce = $_REQUEST['hladaj_uce'];
$citfir = include("../cis/citaj_fir.php");



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Import položiek faktúry</title>
  <style type="text/css">

  </style>
</HEAD>
<BODY class="white" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom 
<?php
  if ( $copern == 20 ) echo "- import položiek do faktúry číslo $cislo_dok zo súboru CSV";

?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 
//ala.sk import fak2018
if ( $_SERVER['SERVER_NAME'] == "www.ala.sk" OR $_SERVER['SERVER_NAME'] == "localhost"  )
                { 
$obj=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok = $cislo_dok ORDER BY dok DESC LIMIT 1";
//echo $sqlttt."<br />";
$sqlzak = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $obj=1*$riadzak->obj;
  }

//dok	fak	dol	prf	cpl	slu	nsl	pop	pon	dph	cen	cep	ced	
//mno	mer	pfak	cfak	dfak	id	datm

$sqult = "INSERT INTO F$kli_vxcf"."_fakslu SELECT ".
" '$cislo_dok', 0, 0, 0, 0, cis, nat, '', '', '20', 0, cep, 1.2*cep, mno, '', 0, 0, 0, $kli_uzid, now() FROM fak2018 ".
" WHERE fak = $obj ";

//echo $sqult."<br />";

$ulozene = mysql_query("$sqult");

$sumcep=0; $sumced=0;
$sqlttt = "SELECT SUM(cep*mno) AS sumcep, SUM(ced*mno) AS sumced FROM F$kli_vxcf"."_fakslu WHERE dok = $cislo_dok GROUP BY dok";
//echo $sqlttt."<br />";
$sqlzak = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $sumcep=1*$riadzak->sumcep;
  $sumced=1*$riadzak->sumced;
  }

$sqult = "UPDATE F$kli_vxcf"."_fakodb SET zk2=$sumcep, sp2=$sumced WHERE dok = $cislo_dok ";
$ulozene = mysql_query("$sqult");

$sqult = "UPDATE F$kli_vxcf"."_fakodb SET dn2=sp2-zk2, hod=sp2 WHERE dok = $cislo_dok ";
$ulozene = mysql_query("$sqult");

$sqult = "UPDATE F$kli_vxcf"."_fakodb SET zk2u=zk2, dn2u=dn2, sp2u=sp2, hodu=hod, txp='Fakturujeme Vám' WHERE dok = $cislo_dok ";
$ulozene = mysql_query("$sqult");

?>
<script type="text/javascript" > 

window.open('vstf_u.php?vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_fak=<?php echo $cislo_dok; ?>&h_dol=0&h_prf=0', '_self' );

</script>
<?php

                }
//koniec ala.sk import fak2018
?>

<?php 
if ($copern > 0)
                { 

if ($_REQUEST["odeslano"]==1): 

$pole = explode(".", $_FILES['original']['name']);
$snazov=$pole[0];
$styp=strtolower($pole[1]);
if( $styp != "csv" ) { echo $styp." Erorr Code 433"; exit; }

  if (move_uploaded_file($_FILES['original']['tmp_name'], "../tmp/polozky.csv")) 
  { 

$subor = fopen("../tmp/polozky.csv", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);


  $x_cis = $pole[0];
  $x_nat = $pole[1];
  $x_dph = 1*str_replace(",",".",$pole[2]);
  $x_cep = 1*str_replace(",",".",$pole[3]);
  $x_ced = 1*str_replace(",",".",$pole[4]);
  $x_mno = 1*str_replace(",",".",$pole[5]);
  $x_mer1 = str_replace("\r","",$pole[6]);

  $x_mer = str_replace("\n","",$x_mer1);

$ccep=1*$x_cep;
$cced=1*$x_ced;
$cmno=1*$x_mno;

if( $ccep > 0 AND $cced > 0 AND $cmno != 0 )
  {
//fakslu dok  fak  dol  prf  cpl  slu  nsl  pop  pon  dph  cen  cep  ced  mno  mer  pfak  cfak  dfak  id  datm  

$sqult = "INSERT INTO F$kli_vxcf"."_fakslu ( dok,fak,dol,prf,cpl,slu,nsl,pop,pon,dph,cen,cep,ced,mno,mer,pfak,cfak,dfak,id,datm )".
" VALUES ( '$cislo_dok', 0, 0, 0, 0, '$x_cis', '$x_nat', '', '', '$x_dph', 0, '$x_cep', '$x_ced', '$x_mno', '$x_mer', 0, 0, 0, $kli_uzid, now() );";

//echo $sqult;

$ulozene = mysql_query("$sqult"); 



$h_ced=$x_ced;
$h_cep=$x_cep;
$h_mno=$x_mno;
$h_dph=$x_dph;

$h_ced2 = $h_ced;
$h_cep2 = $h_cep;
$h_spo2 = ($h_cep*$h_mno)*(1+$fir_dph2/100);
//echo $h_spo2;
$h_ced1 = 0;
$h_cep1 = 0;
$h_spo1 = 0;
$h_cep0 = 0;
if( $h_dph == $fir_dph1 )
{
$h_ced1 = $h_ced;
$h_cep1 = $h_cep;
$h_spo1 = ($h_cep*$h_mno)*(1+$fir_dph1/100);
$h_ced2 = 0;
$h_cep2 = 0;
$h_spo2 = 0;
$h_cep0 = 0;
}
if( $h_dph == 0 )
{
$h_cep0 = $h_cep;
$h_ced1 = 0;
$h_cep1 = 0;
$h_spo1 = 0;
$h_ced2 = 0;
$h_cep2 = 0;
$h_spo2 = 0;
}

$sqtz = "UPDATE F$kli_vxcf"."_fakodb SET zk1=zk1+('$h_mno'*'$h_cep1'), sp1=sp1+('$h_spo1'), dn1=sp1-zk1,".
" zk2=zk2+('$h_mno'*'$h_cep2'), sp2=sp2+('$h_spo2'), dn2=sp2-zk2,".
" zk0=zk0+('$h_mno'*'$h_cep0'), hod=sp1+sp2+zk0 ".
" WHERE dok='$cislo_dok'";

//echo $sqtz;

$upravene = mysql_query("$sqtz");
//exit;

  }

//koniec while
}
fclose ($subor);

$sZao = include("../funkcie/zaokruhli_hod.php");
$sZad = include("../funkcie/zaokruhli_dph.php");

$pole = explode(".", $kli_vume);
$vyb_mes=$pole[0];
$vyb_rok=$pole[1];

//echo $vyb_rok." ".$fir_xfa02;
//exit;

$zad = zaokruhli_dph("1", $kli_vxcf, "fakodb", $cislo_dok, $vyb_rok);
$zao = zaokruhli_hod($fir_xfa02, $kli_vxcf, "fakodb", $cislo_dok);

?>
<script type="text/javascript" > 

window.open('vstf_u.php?vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce; ?>&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_fak=<?php echo $cislo_dok; ?>&h_dol=0&h_prf=0', '_self' );


</script>
<?php
  }; 
else: 
?> 
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?cislo_dok=<?php echo $cislo_dok; ?>
&drupoh=<?php echo $drupoh; ?>&copern=<?php echo $copern; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="35%" align="right" >Súbor:</td> 
        <td  width="30%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE=420000> 
        <input type="file" name="original" > 
        </td> 
        <td  width="35%" align="left" >(max. 400 kB)</td> 
      </tr> 
      <tr> 
        <td colspan="3"> 
              <input type="hidden" name="odeslano" value="1"> 
          <p align="center"><input type="submit" value="Odoslať"></td> 
      </tr> 
    </table> 
    </form> 
<?php 
endif; 
//koniec copern 0
                 }
?> 



<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>