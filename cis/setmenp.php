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

$jedenid = 1*$_REQUEST['jedenid'];

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$mysqldbfir=$mysqldb;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("../cis/oddel_dtbm1new.php");
          }
else
          {
$dtb2 = include("../cis/oddel_dtbm1.php");
          }

$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }
$kopiruj=0;

$sql = "ALTER TABLE $mysqldbfir.menp ADD datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER prav ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $mysqldbfir.menp MODIFY sys VARCHAR(50) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE $mysqldbfir.menp MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

//vymazanie 
if ( $copern == 316 )
    {
$cslm = 1*strip_tags($_REQUEST['cslm']);
$uzid = 1*strip_tags($_REQUEST['uzid']);
$datm = strip_tags($_REQUEST['datm']);
$zmazane = mysql_query("DELETE FROM $mysqldbfir.menp WHERE prav='$uzid' AND cslm='$cslm' AND  datm='$datm' "); 

$copern=1;
$kopiruj=1;
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

//vymazanie login
if ( $copern == 1316 )
    {
$datm = strip_tags($_REQUEST['datm']);
$zmazane = mysql_query("DELETE FROM $mysqldbfir.dlogin WHERE datm='$datm' "); 

$copern=1001;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOŽKA NEBOLA VYMAZANÁ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania login

//ulozenie noveho 
if ( $copern == 315 )
    {
$cslm = 1*strip_tags($_REQUEST['cslm']);
$uzid = 1*strip_tags($_REQUEST['uzid']);


$ulozttt = "INSERT INTO $mysqldbfir.menp ( sys, cslm, prav ) VALUES ( '', '$cslm', '$uzid'  ); "; 

//echo $ulozttt;

$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$kopiruj=1;
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


<?php
if( $newdelenie == 1 AND $kopiruj == 1 )
          {

if( $mysqldb2016 != $mysqldb2015 AND $mysqldb2015 != '' ) {

$sqlttt=" DROP TABLE `".$mysqldb2015."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2015."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2017 AND $mysqldb2017 != '' ) {

$sqlttt=" DROP TABLE `".$mysqldb2017."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2018 AND $mysqldb2018 != '' ) {

$sqlttt=" DROP TABLE `".$mysqldb2018."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }

if( $mysqldb2016 != $mysqldb2019 AND $mysqldb2019 != '' ) {

$sqlttt=" DROP TABLE `".$mysqldb2019."`.`menp` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`menp` SELECT * FROM `".$mysqldb2016."`.`menp` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

                                   }


          }
//if( $newdelenie == 1 )
?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>MENP</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

function ZmazPolozku(uzid, cslm, datm)
                {
window.open('setmenp.php?copern=316&page=1&sysx=UCT&uzid=' + uzid + '&cslm=' + cslm + '&datm=' + datm + '&drupoh=1', '_self' );
                }

function Help()
                {
window.open('pristupy_cslm.php', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


function setmenp()
                {
window.open('setmenp.php?copern=1&drupoh=1', '_self' );
                }


function dlogin()
                {
window.open('setmenp.php?copern=1001&drupoh=1', '_self' );
                }

function ZmazLogin(cslm)
                {
window.open('setmenp.php?copern=1316&page=1&sysx=UCT&datm=' + cslm + '&drupoh=1', '_self' );
                }

function JedenID(cslm)
                {
window.open('setmenp.php?copern=1&page=1&sysx=UCT&jedenid=' + cslm + '&drupoh=1', '_self' );
                }

</script>
</HEAD>
<BODY class="white" >



<table class="h2" width="100%" >
<tr>
<?php if ( $copern < 1000 ) { echo "<td>EuroSecom  -  MENP - užívate¾ské prístupy</td>"; } ?>
<?php if ( $copern > 1000 ) { echo "<td>EuroSecom  -  DLOGIN - logovací súbor</td>"; } ?>
<td>
menp <img src='../obr/klienti.png' onclick="setmenp();" width=15 height=15 border=0 title=''Prístupy k skriptom pod¾a CSLM/ID' >
&nbsp;&nbsp;&nbsp;&nbsp;dlogin <img src='../obr/zoznam.png' onclick="dlogin();" width=15 height=15 border=0 title='Logovací súbor' >
</td>
</tr>
</table>
<br />




<?php
if( $copern < 1000 ) {

$sqltt = "SELECT * FROM $mysqldbfir.menp WHERE cslm >= 0 ORDER BY prav, cslm";
if( $jedenid > 1 ) { $sqltt = "SELECT * FROM $mysqldbfir.menp WHERE prav = $jedenid ORDER BY prav, datm DESC"; }
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>
<table class="vstup" width="100%" >
<tr>
<td class="hmenu" width="10%" align="right" >UZID
<td class="hmenu" width="10%" align="right" >CSLM
<td class="hmenu" width="20%" align="right" >datum
<th class="hmenu" width="5%" >Del
<td class="hmenu" width="55%" align="right" > 

<a href="#" onClick="Help();">
<img src='../obr/info.png' width=15 height=10 border=0 title='Help' ></a>

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

<td class="fmenu" >
<a href="#" onClick="JedenID(<?php echo $riadok->prav;?>);">
<?php echo $riadok->prav;?></a></td>
<td class="fmenu" align="right" ><?php echo $riadok->cslm;?></td>
<td class="fmenu" align="left" ><?php echo $riadok->datm;?> <?php echo $riadok->sys;?></td>
<td class="fmenu" width="5%" >

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->prav;?>, <?php echo $riadok->cslm;?>, '<?php echo $riadok->datm;?>' );">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymaza riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="setmenp.php?copern=315" >
<tr>

<td class="hmenu"><input type="text" name="uzid" id="uzid" size="7"  />
<td class="hmenu"><input type="text" name="cslm" id="cslm" size="7"  />

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloži" ></td>
</tr>
</table>

<?php
//konec copern < 1000
                     }

if( $copern > 1000 ) {

$sqltt = "SELECT * FROM $mysqldbfir.dlogin WHERE id >= 0 ORDER BY datm DESC LIMIT 400";
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>
<table class="vstup" width="100%" >
<tr>
<td class="hmenu" width="20%" align="left" >IPX
<td class="hmenu" width="20%" align="left" >user
<td class="hmenu" width="20%" align="right" >Time
<th class="hmenu" width="5%" >Del
<td class="hmenu" width="35%" align="right" > 

<a href="#" onClick="Help();">
<img src='../obr/info.png' width=15 height=10 border=0 title='Help' ></a>

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

<td class="fmenu" ><?php echo $riadok->ipad;?></td>
<td class="fmenu" ><?php echo $riadok->prie;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->datm;?></td>
<td class="fmenu" width="5%" >

<a href="#" onClick="ZmazLogin('<?php echo $riadok->datm;?>');">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymaza riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="setmenp.php?copern=315" >
<tr>

<td class="hmenu"><input type="text" name="uzid" id="uzid" size="7"  />
<td class="hmenu"><input type="text" name="cslm" id="cslm" size="7"  />

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloži" ></td>
</tr>
</table>

<?php
//konec copern > 1000
                     }

// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
