<?PHP
error_reporting(0);
session_start();
$_SESSION['eshop_fir'] = 93;

$autoreg=0;
if (File_Exists ('../eshop/autoregistracia.ano') ) { $autoreg=1; }
$autoregsubor="../dokumenty/FIR".$_SESSION['eshop_fir']."/autoregistracia.ano";
if (File_Exists ($autoregsubor) ) { $autoreg=1; }

if( $autoreg == 1 )
  {
$_SESSION['ez_id'] = 999990001;
$_SESSION['prihl'] = 1;
  }

$blokuj=0;
if( $blokuj == 1 ) { echo "Na stránka eshopu prebieha momentálne údržba, prepáète za doèasnú, krátkodobú nefunkènos. Èinnos bude obnovená dnes od 12.00. Ïakujeme."; exit; }

//window.open('../kupuj/webs.php', '_blank', 'width=1080, height=900, top=0, left=0, menubar=no, titlebar=no, location=no, status=no, resizable=yes, scrollbars=yes'  );

?>
<script type="text/javascript">
    window.open('../kupuj/webs.php', '_self' );
</script>
<?php

?>

