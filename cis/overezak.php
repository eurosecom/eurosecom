<?PHP

function isValidtest($test,$sablona)
    {
 return (eregi($sablona, $test));
    }

function otestuj($test)
    {
$sablona="[(]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[{]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[)]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[}]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[']"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[\"]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[\[]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[\]]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[;]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[,]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[.]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[&]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[#]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[$]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[/]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[\]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[@]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[<]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[>]"; 
if(isValidtest($test,$sablona)) $err=1;
$sablona="[+]"; 
if(isValidtest($test,$sablona)) $err=1;
if( $err == 1 )
{
echo 'Error code 431 '.$test.'<br />';
exit;
}
    }

$test = strip_tags($_REQUEST['wsxmn']);
$test = AddSlashes($test);
$err=0;
otestuj($test);
$test = strip_tags($_REQUEST['wsxhs']);
$test = AddSlashes($test);
$err=0;
otestuj($test);

$kdewebs="";
$eshop_fir=1*$_SESSION['eshop_fir'];
if( $eshop_fir > 0 ) { $kdewebs="F".$eshop_fir."_"; }

  $overezak = 0;
  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;

  mysql_select_db($mysqldb);

//echo $_REQUEST['wsxmn']."<br />";
//echo $_REQUEST['wsxhs']."<br />";
//exit;

$ezheslo1=$_REQUEST['wsxhs'];
$ezmeno1=$_REQUEST['wsxmn'];


  $sql = "SELECT ez_heslo FROM $kdewebs"."ezak WHERE ez_meno='$ezmeno1' ";
  $vysledok = mysql_query($sql);

  if (!$vysledok){
    echo "Overenie nemožno použi tabu¾ka E-užívate¾ov aplikácie nedostupná.";
    exit;
  }

  $sql = "SELECT * FROM $kdewebs"."ezak WHERE ez_meno='$ezmeno1' AND ez_heslo='$ezheslo1'";
  $vysledok = mysql_query($sql);
  $pocet=1*mysql_num_rows($vysledok);

  if ($pocet == 0){
    echo "Nesprávne meno alebo heslo.";
    exit;
  }else{

    $riadok=mysql_fetch_object($vysledok);
    $_SESSION['ez_id'] = $riadok->ez_id;
    $_SESSION['ez_meno'] = $riadok->ez_meno;
    $_SESSION['ez_heslo'] = $riadok->ez_heslo;
    $_SESSION['ez_ico'] = $riadok->ez_ico;
    $_SESSION['ez_odbm'] = 1*$riadok->cxx1;
    $_SESSION['ez_tel'] = $riadok->ez_tel;
    $_SESSION['ez_ema'] = $riadok->ez_ema;
    $_SESSION['ez_kto'] = $riadok->ez_kto;
    $_SESSION['ez_ccen'] = 1*$riadok->ccen;
    $_SESSION['ez_cskl'] = 1*$riadok->cskl;
    $_SESSION['prihl'] = 1;

    mysql_free_result($vysledok);
  }
 
?>
