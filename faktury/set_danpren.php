<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 1000;
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
//copern=1 z bankoveho
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_uce = 1*$_REQUEST['cislo_uce'];


$citfir = include("../cis/citaj_fir.php");

if( $copern == 7  ) { 
?>
<script type="text/javascript">
if( confirm ("Chcete preniesù daÚov˙ povinnosù na doklade <?php echo $cislo_dok; ?> ?") )
         { window.open('../faktury/set_danpren.php?copern=77&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>&cislo_uce=<?php echo $cislo_uce;?>', '_self' ); }
else
         { window.close(); }

</script>
<?php
exit;
                    }
if( $copern == 77 ) { 

$sqtoz = "UPDATE F$kli_vxcf"."_dopslu SET ced=cep, dph=0 WHERE dok = $cislo_dok ";
$vysledok = mysql_query($sqtoz);

$sqtoz = "UPDATE F$kli_vxcf"."_dopfak SET zk0=zk2 WHERE dok = $cislo_dok AND zk2 != 0 ";
$vysledok = mysql_query($sqtoz);

$sqtoz = "UPDATE F$kli_vxcf"."_dopfak SET zk2=0, hod=zk0, dn2=0, sp2=0 WHERE dok = $cislo_dok AND zk2 != 0 ";
$vysledok = mysql_query($sqtoz);


                    }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Import IBAN xml</title>

<script type="text/javascript">


</script>
</HEAD>
<BODY class="white" >


<?php
//prepni spat

//<a href='vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=31&page=1&hladaj_uce=31160&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT
//&cislo_dok=560001&h_fak=560001&h_dol=0&h_prf=0'>
if( $drupoh == 31 )
{
?>
<script type="text/javascript">

window.open('../faktury/vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=31&page=1&hladaj_uce=<?php echo $cislo_uce; ?>&h_tltv=1&h_tlsl=0&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok; ?>&h_ico=&h_uce=<?php echo $cislo_uce; ?>&h_fak=<?php echo $cislo_dok; ?>&h_dol=0&h_prf=0', '_self' )

</script>
<?php
}
?>


<?php
exit;

//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
