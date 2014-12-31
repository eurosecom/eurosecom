<HTML>
<?php
$sys = 'ALL';
$urov = 90000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$uzid = 1*$_REQUEST['uzid'];

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$mysqldbfir="";
$dtb2 = include("oddel_dtbm1.php");

//Tabulka firuz
$sql = "SELECT * FROM $mysqldbfir.firuz ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
  {

$sqlt = <<<fakodb
(
   cplf    int not null auto_increment,
   uzid    DECIMAL(10,0),
   fiod    DECIMAL(10,0),
   fido    DECIMAL(10,0),
   PRIMARY KEY(cplf)
);
fakodb;

$sql = "CREATE TABLE $mysqldbfir.firuz ".$sqlt;
//echo $sql;
$vysledek = mysql_query("$sql");
  }

$sql = "ALTER TABLE $mysqldbfir.firuz MODIFY cplf int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

//vymazanie 
if ( $copern == 316 )
    {
$cplf = 1*strip_tags($_REQUEST['cplf']);
$zmazane = mysql_query("DELETE FROM $mysqldbfir.firuz WHERE cplf='$cplf' "); 

$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOŽKA NEBOLA VYMAZANÁ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania 

//ulozenie noveho 
if ( $copern == 315 )
    {
$fiod = 1*strip_tags($_REQUEST['fiod']);
$fido = 1*strip_tags($_REQUEST['fido']);

$ulozttt = "INSERT INTO $mysqldbfir.firuz ( uzid, fiod, fido ) VALUES ( '$uzid', '$fiod', '$fido'  ); "; 

//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;

if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOŽKA NEBOLA SPRÁVNE ULOŽENÁ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia 


?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>MENP</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

function ZmazPolozku(cplf)
                {
window.open('setuzfir.php?copern=316&page=1&sysx=UCT&uzid=<?php echo $uzid; ?>&cplf=' + cplf + '&drupoh=1', '_self' );
                }



</script>
</HEAD>
<BODY class="white" >



<table class="h2" width="100%" >
<tr>
<?php if ( $copern < 1000 ) { echo "<td>EuroSecom  -  Prístupné firmy pre užívate¾a èíslo $uzid</td>"; } ?><td>
</tr>
</table>
<br />




<?php
if( $copern < 1000 ) {

$sqltt = "SELECT * FROM $mysqldbfir.firuz WHERE uzid = $uzid ORDER BY fiod, fido";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>
<table class="vstup" width="100%" >
<tr>
<td class="hmenu" width="10%" align="left" >UZID
<td class="hmenu" width="10%" align="left" >xFod
<td class="hmenu" width="10%" align="left" >xFdo
<th class="hmenu" width="5%" >Del
<td class="hmenu" width="65%"> 
</tr>
<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" align="left" colspan="1"><?php echo $riadok->uzid;?></td>
<td class="fmenu" align="left" colspan="1"><?php echo $riadok->fiod;?></td>
<td class="fmenu" align="left" colspan="1"><?php echo $riadok->fido;?></td>
<td class="fmenu"  colspan="1">

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cplf;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymaza riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="setuzfir.php?copern=315&uzid=<?php echo $uzid; ?>" >
<tr>
<td class="hmenu" colspan="1"><?php echo $uzid; ?>
<td class="hmenu" colspan="1"><input type="text" name="fiod" id="fiod" size="7"  />
<td class="hmenu" colspan="1"><input type="text" name="fido" id="fido" size="7"  />

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloži" ></td>
</tr>
</table>

<?php
//konec copern < 1000
                     }



// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
