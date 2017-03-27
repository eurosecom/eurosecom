<?PHP
session_start();
$h5rtgh5 = include("odpad2010/h5rtgh5.php");

function isValidtest($test,$sablona)
    {
 return (@eregi($sablona, $test));
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


$test = strip_tags($_REQUEST['rtxmn']);
$test = AddSlashes($test);
$testmn = $test;
$err=0;
otestuj($test);
$test = strip_tags($_REQUEST['rtxhs']);
$test = AddSlashes($test);
$err=0;
otestuj($test);

  $overenie = 0;
  require_once("pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni){
    echo "Spojenie so serverom nedostupne.";
    exit;
                }

  mysql_select_db($mysqldb);

if( $_SERVER['SERVER_NAME'] == "www.ala.sk" ) { mysql_query("SET NAMES cp1250"); }
if( $_SERVER['SERVER_NAME'] == "skplaysro" ) { mysql_query("SET NAMES cp1250"); }
if( $_SESSION['ipad'] == 1 ) { mysql_query("SET NAMES cp1250"); mysql_query("SET CHARACTER SET cp1250");  }

$eurosecom2015virtualnyserver=0;
if( file_exists("pswd/eurosecom2015virtualnyserver.ano")) { $eurosecom2015virtualnyserver=1; }
if( file_exists("../pswd/eurosecom2015virtualnyserver.ano")) { $eurosecom2015virtualnyserver=1; }
if( $eurosecom2015virtualnyserver == 1 ) { mysql_query("SET NAMES cp1250"); }

$eurosecomvirtualnyserver=0;
if( file_exists("pswd/eurosecomvirtualnyserver.ano")) { $eurosecomvirtualnyserver=1; }
if( $eurosecomvirtualnyserver == 1 ) { mysql_query("SET CHARACTER SET cp1250"); }


  $ipad=$_SERVER["REMOTE_ADDR"];
  $dneskasql = Date ("Y-m-d 00:00:01", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
  $pocpri=0;
  $sqldok = mysql_query("SELECT * FROM dlogin WHERE datm > '$dneskasql' AND prie = '$testmn' ");
  if( $sqldok ) { $pocpri = mysql_num_rows($sqldok); }

  if( $pocpri > 50 ) {  echo "Nesprávne používané meno alebo heslo."; $_SESSION['kli_vhsxy'] = 1010; exit;  }

  mysql_query("INSERT INTO dlogin ( id,prie,ipad ) VALUES ( '0000', '$testmn', '$ipad')"); 

  $rtxmn=$_REQUEST['rtxmn'];
  $rtxhs=$_REQUEST['rtxhs'];
  //echo $rtxmn." ".$rtxhs;
  //exit;

$jemeno=0;
$sqlttt = "SELECT * FROM klienti WHERE uziv_meno = '$rtxmn'";
//echo $sqlttt;
$sqlico = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);

$uziv_meno=$riadico->uziv_meno;
$uziv_heslo=$riadico->uziv_heslo;
$jemeno=1;
  }
if( $jemeno == 0 ) { echo "Nesprávne meno alebo heslo."; $_SESSION['kli_vhsxy'] = 1010; exit; }


$jeheslo=0;
$sqlttt = "SELECT * FROM klienti WHERE uziv_meno = '$rtxmn' AND uziv_heslo = '$rtxhs'";
$sqlico = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);

$uziv_meno=$riadico->uziv_meno;
$uziv_heslo=$riadico->uziv_heslo;
$jeheslo=1;
  }
if( $jeheslo == 0 ) { echo "Nesprávne meno alebo heslo."; $_SESSION['kli_vhsxy'] = 1010; exit; }

    $sql =
    "SELECT * FROM klienti WHERE uziv_meno='{$_REQUEST['rtxmn']}'";
    $vysledok = mysql_query($sql);
    $riadok = mysql_fetch_object($vysledok);

$md5grid=$_SESSION['md5grid'];
$grid=$_SESSION['grid'];
$gridhash=$_SESSION['gridhash'];
//ak existuje tabulka krtgrd precitaj pre $kli_uziv z gridtabulky hodnotu policka session $grid spoj ju s session $gridhash urob hash a porovnaj s $md5grid
//ak je rovnake OK inak ukonci overenie
$sqlttt = "SELECT * FROM krtgrd WHERE id = '$riadok->id_klienta' AND aktiv=1";
//echo $sqlttt;
//echo "grid".$grid;
//exit;
$sqlico = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);

$grid_hod=$riadico->$grid;
$gridspl_x=$grid_hod."".$gridhash;
$md5grid_x=md5( $gridspl_x );

if( $md5grid == $md5grid_x ) {  }
if( $md5grid != $md5grid_x ) 
{ $_SESSION['kli_vhsxy'] = 14455265; echo "md5grid ".$md5grid."-".$md5grid_x; echo " Error code 431 <br />"; $_SESSION['kli_vhsxy'] = 1010; exit; }

  }



$cook=0;
if( $cook == 1 )
    {
    setcookie("kli_uzid", $riadok->id_klienta, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzmeno", $riadok->meno, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzprie", $riadok->priezvisko, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzall", $riadok->all_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzuct", $riadok->uct_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzmzd", $riadok->mzd_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzskl", $riadok->skl_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzhim", $riadok->him_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzdop", $riadok->dop_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzana", $riadok->ana_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzfak", $riadok->fak_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_uzvyr", $riadok->vyr_prav, time() + (7 * 24 * 60 * 60));
    setcookie("kli_txt1", $riadok->txt1, time() + (7 * 24 * 60 * 60));
    }

    session_start();    
    $_SESSION['kli_uzid'] = $riadok->id_klienta;
    $_SESSION['kli_xuzid'] = $riadok->id_klienta;
    $_SESSION['kli_uzmeno'] = $riadok->meno;
    $_SESSION['kli_uzprie'] = $riadok->priezvisko;
    $_SESSION['kli_uzall'] = $riadok->all_prav;
    $_SESSION['kli_uzuct'] = $riadok->uct_prav;
    $_SESSION['kli_uzmzd'] = $riadok->mzd_prav;
    $_SESSION['kli_uzskl'] = $riadok->skl_prav;
    $_SESSION['kli_uzhim'] = $riadok->him_prav;
    $_SESSION['kli_uzdop'] = $riadok->dop_prav;
    $_SESSION['kli_uzana'] = $riadok->ana_prav;
    $_SESSION['kli_uzfak'] = $riadok->fak_prav;
    $_SESSION['kli_uzvyr'] = $riadok->vyr_prav;
    $_SESSION['kli_xuzall'] = $riadok->all_prav;
    $_SESSION['kli_xuzuct'] = $riadok->uct_prav;
    $_SESSION['kli_xuzmzd'] = $riadok->mzd_prav;
    $_SESSION['kli_xuzskl'] = $riadok->skl_prav;
    $_SESSION['kli_xuzhim'] = $riadok->him_prav;
    $_SESSION['kli_xuzdop'] = $riadok->dop_prav;
    $_SESSION['kli_xuzana'] = $riadok->ana_prav;
    $_SESSION['kli_xuzfak'] = $riadok->fak_prav;
    $_SESSION['kli_xuzvyr'] = $riadok->vyr_prav;
    $_SESSION['kli_txt1'] = $riadok->txt1;
    $_SESSION['verzia'] = '2017_04';


    $ipad=$_SERVER["REMOTE_ADDR"];
    mysql_query("INSERT INTO dlogin ( id,prie,ipad ) VALUES ( '$riadok->id_klienta', '$riadok->priezvisko', '$ipad')"); 


  $sql = "SELECT * FROM vtvtab";
  $vysledok = mysql_query($sql);
  if (!$vysledok){
  $vtvtab = include("vtvtab.php");
                 }

$hs = 1*$_REQUEST['hs'];
$dajmenu=1;
$menu = include("hsheslo.php");


?>
