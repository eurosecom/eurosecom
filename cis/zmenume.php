<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 1000;
$clsm = 900;

$anal = 1*$_REQUEST['anal'];
if( $anal == 1 ) { $sys="ANA"; $urov=1000; }

$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$odkaz = trim($_REQUEST['odkaz']); 


//echo $odkaz;
$odkaz=urldecode($odkaz);
//echo $odkaz;
//exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$mysqldbfir=$mysqldb;

$mysqldbdatax=$mysqldbdata;

$dtb2 = include("oddel_dtbm1.php");

$mysqldbdata=$mysqldbdatax;


//copern=1 predchadzajuci mesiac
if( $copern == 1 )
{
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_pmes=$kli_vmes-1;
if( $kli_pmes < 1 ) $kli_pmes=1;
$kli_dmes=$kli_vmes+1;
if( $kli_dmes > 12 ) $kli_dmes=12;
$kli_pume=$kli_pmes.".".$kli_vrok;
$kli_dume=$kli_dmes.".".$kli_vrok;

$ulozttt = "UPDATE $mysqldbfir.nas_id SET ume='$kli_pume' WHERE id=$kli_uzid "; 
$ulozene = mysql_query("$ulozttt"); 
$kli_vume=$kli_pume;
}
//koniec predchazdajuci mesiac

//copern=2 nasledujuci mesiac
if( $copern == 2 )
{
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_pmes=$kli_vmes-1;
if( $kli_pmes < 1 ) $kli_pmes=1;
$kli_dmes=$kli_vmes+1;
if( $kli_dmes > 12 ) $kli_dmes=12;
$kli_pume=$kli_pmes.".".$kli_vrok;
$kli_dume=$kli_dmes.".".$kli_vrok;

$ulozttt = "UPDATE $mysqldbfir.nas_id SET ume='$kli_dume' WHERE id=$kli_uzid "; 
$ulozene = mysql_query("$ulozttt"); 
$kli_vume=$kli_dume;
}
//koniec nasledujuci mesiac

//zmen mesiac 101=januar....112=december
if( $copern > 100 )
{
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$kli_pmes=$copern-100;

if( $kli_pmes < 1 ) $kli_pmes=1;
if( $kli_dmes > 12 ) $kli_dmes=12;
$kli_pume=$kli_pmes.".".$kli_vrok;
$kli_dume=$kli_dmes.".".$kli_vrok;

$ulozttt = "UPDATE $mysqldbfir.nas_id SET ume='$kli_pume' WHERE id=$kli_uzid "; 
$ulozene = mysql_query("$ulozttt"); 
$kli_vume=$kli_pume;
}
//koniec zmen mesiac


session_start();    
$_SESSION['kli_vume'] = $kli_vume;

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zmena UME</title>
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
//prepni naspat do povodneho okna
if( $copern == 1 OR $copern == 2 OR $copern > 100 )
     {

?>
<script type="text/javascript">
window.open('<?php echo $odkaz;?>', '_self' )
</script>
<?php
exit;
     }

//koniec zmena UME
?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
