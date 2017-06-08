<HTML>
<?php

do
{
$sys = 'ALL';
$urov = 10000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

$copern = $_REQUEST['copern'];
$cislo_id = $_REQUEST['cislo_id'];
$usermd = 1*$_REQUEST['usermd'];
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Grid</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">
    <!--

     
    // -->
</SCRIPT>

</HEAD>
<BODY class="white" >
<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana č. &p z &P pata=prazdna
// na vysku okraje vl=20 vp=10 hr=20 dl=20 poloziek 41  

require_once("../pswd/password.php");

$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }
if ( $newdelenie == 1 )
          {
$dtb2 = include("../oddel_dtb3new.php");
          }

//echo $mysqldb;

@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


//zmazat grid
if ( $copern == 14 )
{

$zmazane = mysql_query("DELETE FROM krtgrd WHERE id='$cislo_id'"); 

}
//koniec zmazat

//PIN grid
if ( $copern == 15 )
{
$sqldok = mysql_query("SELECT * FROM krtgrd WHERE id='$cislo_id' AND aktiv = 1 LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kartaa1=$riaddok->a1;
  }


$a1=$kartaa1; $b1=$kartaa1; $c1=$kartaa1; $d1=$kartaa1; $e1=$kartaa1; $f1=$kartaa1;
$a2=$kartaa1; $b2=$kartaa1; $c2=$kartaa1; $d2=$kartaa1; $e2=$kartaa1; $f2=$kartaa1;
$a3=$kartaa1; $b3=$kartaa1; $c3=$kartaa1; $d3=$kartaa1; $e3=$kartaa1; $f3=$kartaa1;
$a4=$kartaa1; $b4=$kartaa1; $c4=$kartaa1; $d4=$kartaa1; $e4=$kartaa1; $f4=$kartaa1;
$a5=$kartaa1; $b5=$kartaa1; $c5=$kartaa1; $d5=$kartaa1; $e5=$kartaa1; $f5=$kartaa1;
$a6=$kartaa1; $b6=$kartaa1; $c6=$kartaa1; $d6=$kartaa1; $e6=$kartaa1; $f6=$kartaa1;

$sqty = "UPDATE krtgrd SET a1='$a1', b1='$b1', c1='$c1', d1='$d1', e1='$e1', f1='$f1',".
" a2='$a2', b2='$b2', c2='$c2', d2='$d2', e2='$e2', f2='$f2',".
" a3='$a3', b3='$b3', c3='$c3', d3='$d3', e3='$e3', f3='$f3',".
" a4='$a4', b4='$b4', c4='$c4', d4='$d4', e4='$e4', f4='$f4',".
" a5='$a5', b5='$b5', c5='$c5', d5='$d5', e5='$e5', f5='$f5',".
" a6='$a6', b6='$b6', c6='$c6', d6='$d6', e6='$e6', f6='$f6'".
"WHERE id='$cislo_id' AND aktiv=1 ";

$ulozene = mysql_query("$sqty"); 

}
//koniec PIN

//cvicna grid
if ( $copern == 13 )
{

$a1=1234; $b1=1234; $c1=1234; $d1=1234; $e1=1234; $f1=1234;
$a2=1234; $b2=1234; $c2=1234; $d2=1234; $e2=1234; $f2=1234;
$a3=1234; $b3=1234; $c3=1234; $d3=1234; $e3=1234; $f3=1234;
$a4=1234; $b4=1234; $c4=1234; $d4=1234; $e4=1234; $f4=1234;
$a5=1234; $b5=1234; $c5=1234; $d5=1234; $e5=1234; $f5=1234;
$a6=1234; $b6=1234; $c6=1234; $d6=1234; $e6=1234; $f6=1234;

$sqty = "UPDATE krtgrd SET a1='$a1', b1='$b1', c1='$c1', d1='$d1', e1='$e1', f1='$f1',".
" a2='$a2', b2='$b2', c2='$c2', d2='$d2', e2='$e2', f2='$f2',".
" a3='$a3', b3='$b3', c3='$c3', d3='$d3', e3='$e3', f3='$f3',".
" a4='$a4', b4='$b4', c4='$c4', d4='$d4', e4='$e4', f4='$f4',".
" a5='$a5', b5='$b5', c5='$c5', d5='$d5', e5='$e5', f5='$f5',".
" a6='$a6', b6='$b6', c6='$c6', d6='$d6', e6='$e6', f6='$f6'".
"WHERE id='$cislo_id' AND aktiv=1 ";

$ulozene = mysql_query("$sqty"); 

}
//koniec cvicnej

//ulozenie novej
if ( $copern == 12 )
{
$idpovodne=$cislo_id-100000;

$zmazane = mysql_query("DELETE FROM krtgrd WHERE id='$idpovodne' AND aktiv = 1"); 

$update = mysql_query("UPDATE krtgrd SET aktiv=1, id='$idpovodne' WHERE id='$cislo_id' AND aktiv = 999"); 

$cislo_id=$idpovodne;

}
//koniec ulozenia novej


//generovanie novej
if ( $copern == 11 )
{

$zmazane = mysql_query("DELETE FROM krtgrd WHERE id='$cislo_id' AND aktiv > 1"); 

$a1=rand(1000, 9999); $b1=rand(1000, 9999); $c1=rand(1000, 9999); $d1=rand(1000, 9999); $e1=rand(1000, 9999); $f1=rand(1000, 9999);
$a2=rand(1000, 9999); $b2=rand(1000, 9999); $c2=rand(1000, 9999); $d2=rand(1000, 9999); $e2=rand(1000, 9999); $f2=rand(1000, 9999);
$a3=rand(1000, 9999); $b3=rand(1000, 9999); $c3=rand(1000, 9999); $d3=rand(1000, 9999); $e3=rand(1000, 9999); $f3=rand(1000, 9999);
$a4=rand(1000, 9999); $b4=rand(1000, 9999); $c4=rand(1000, 9999); $d4=rand(1000, 9999); $e4=rand(1000, 9999); $f4=rand(1000, 9999);
$a5=rand(1000, 9999); $b5=rand(1000, 9999); $c5=rand(1000, 9999); $d5=rand(1000, 9999); $e5=rand(1000, 9999); $f5=rand(1000, 9999);
$a6=rand(1000, 9999); $b6=rand(1000, 9999); $c6=rand(1000, 9999); $d6=rand(1000, 9999); $e6=rand(1000, 9999); $f6=rand(1000, 9999);

$idnove=100000+$cislo_id;

$sqty = "INSERT INTO krtgrd ( id,a1,b1,c1,d1,e1,f1,a2,b2,c2,d2,e2,f2 ,a3,b3,c3,d3,e3,f3 ,a4,b4,c4,d4,e4,f4 ,a5,b5,c5,d5,e5,f5 ,a6,b6,c6,d6,e6,f6,".
" nepl,aktiv  )".
" VALUES ('$idnove', '$a1', '$b1', '$c1', '$d1', '$e1', '$f1', ".
" '$a2', '$b2', '$c2', '$d2', '$e2', '$f2', ".
" '$a3', '$b3', '$c3', '$d3', '$e3', '$f3', ".
" '$a4', '$b4', '$c4', '$d4', '$e4', '$f4', ".
" '$a5', '$b5', '$c5', '$d5', '$e5', '$f5', ".
" '$a6', '$b6', '$c6', '$d6', '$e6', '$f6', 0, 999 ); ";

//echo $sqty;
$ulozene = mysql_query("$sqty"); 

}
//koniec generovania novej



//tlac grid
if ( $usermd == 0 OR ( $usermd == 1 AND $copern >= 10 AND $copern <= 11 ) )
{

if ( $copern == 10 OR $copern == 11 OR $copern == 12 OR $copern == 13 OR $copern == 14 OR $copern == 15 )
{
if ( $copern == 10 ) { $sql = mysql_query("SELECT * FROM krtgrd WHERE id = $cislo_id AND aktiv = 1 "); }
if ( $copern == 11 ) { $sql = mysql_query("SELECT * FROM krtgrd WHERE id = $idnove AND aktiv = 999 "); }
if ( $copern == 12 ) { $sql = mysql_query("SELECT * FROM krtgrd WHERE id = $cislo_id AND aktiv = 1 "); }
if ( $copern == 13 ) { $sql = mysql_query("SELECT * FROM krtgrd WHERE id = $cislo_id AND aktiv = 1 "); }
if ( $copern == 14 ) { $sql = mysql_query("SELECT * FROM krtgrd WHERE id = $cislo_id AND aktiv = 1 "); }
if ( $copern == 15 ) { $sql = mysql_query("SELECT * FROM krtgrd WHERE id = $cislo_id AND aktiv = 1 "); }

// celkom poloziek
$cpol = mysql_num_rows($sql);
// pocet poloziek na strane
$pols = 1*41;
// pocet stran
$xstr =ceil($cpol / $pols);
$strana = 1;
?>

<table width="300px" align="left" border="1" cellpadding="3" cellspacing="0" bordercolor="lightblue" >
<tr bgcolor="lightblue">
<td class="bmenu" align="center" >GRID<td class="hmenu" align="center" >A
<td class="bmenu" align="center" >B<td class="hmenu" align="center" >C
<td class="bmenu" align="center" >D<td class="hmenu" align="center" >E
<td class="bmenu" align="center" >F
</tr>

<?php
$celkom = 0.00;
$hodnota = 0.00;
$i=($strana*$pols)-$pols;
$konc=($strana*$pols)-1;

   while ($i <= $konc )
   {

  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="bmenu" align="center" >1
<td class="bmenu" align="center" ><?php echo $riadok->a1;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->b1;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->c1;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->d1;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->e1;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->f1;?></td>
</tr>
<tr>
<td class="bmenu" align="center" >2
<td class="bmenu" align="center" ><?php echo $riadok->a2;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->b2;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->c2;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->d2;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->e2;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->f2;?></td>
</tr>
<tr>
<td class="bmenu" align="center" >3
<td class="bmenu" align="center" ><?php echo $riadok->a3;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->b3;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->c3;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->d3;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->e3;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->f3;?></td>
</tr>
<tr>
<td class="bmenu" align="center" >4
<td class="bmenu" align="center" ><?php echo $riadok->a4;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->b4;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->c4;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->d4;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->e4;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->f4;?></td>
</tr>
<tr>
<td class="bmenu" align="center" >5
<td class="bmenu" align="center" ><?php echo $riadok->a5;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->b5;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->c5;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->d5;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->e5;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->f5;?></td>
</tr>
<tr>
<td class="bmenu" align="center" >6
<td class="bmenu" align="center" ><?php echo $riadok->a6;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->b6;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->c6;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->d6;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->e6;?></td>
<td class="bmenu" align="center" ><?php echo $riadok->f6;?></td>
</tr>

<?php
  }
$i = $i + 1;

   }

}
//koniec copern=10 a 11 tlac

}
//if ( $usermd == 0 OR ( $usermd == 1 AND $copern >= 10 AND $copern <= 11 ) )
?>

<?php
if( $newdelenie == 1 AND $copern != 10 AND $copern != 11  )
          {

if( $mysqldb2016 != $mysqldb2015 AND $mysqldb2015 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2015."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2015."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }


if( $mysqldb2016 != $mysqldb2017 AND $mysqldb2017 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2017."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }

if( $mysqldb2016 != $mysqldb2018 AND $mysqldb2018 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2018."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }

if( $mysqldb2016 != $mysqldb2019 AND $mysqldb2019 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2019."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }

if( $mysqldb2016 != $mysqldb2014 AND $mysqldb2014 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2014."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2014."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }

if( $mysqldb2016 != $mysqldb2013 AND $mysqldb2013 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2013."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2013."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }

if( $mysqldb2016 != $mysqldb2012 AND $mysqldb2012 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2012."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2012."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }

if( $mysqldb2016 != $mysqldb2011 AND $mysqldb2011 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2011."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2011."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }

if( $mysqldb2016 != $mysqldb2010 AND $mysqldb2010 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2010."`.`krtgrd` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2010."`.`krtgrd` SELECT * FROM `".$mysqldb2016."`.`krtgrd` "; $sql = mysql_query("$sqlttt");

                                   }


          }
//if( $newdelenie == 1 )
?>

</table>
<br clear=left>

<?php
if ( $copern == 11 )
{
?>
<br />
<a href="#" onClick="window.open('../cis/grid.php?copern=12&cislo_id=<?php echo $idnove;?>&usermd=<?php echo $usermd; ?>', '_self', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/ok.png' width=20 height=12 border=0 alt="Uložiť novú GridKartu" ></a>
<?php
exit;
}
?>

<?php
if ( $usermd == 1 AND $copern != 10 )
{
?>
<script type="text/javascript">

window.open('../users_md.php?copern=8&strana=1&cislo_id=<?php echo $cislo_id; ?>&uprav=4', '_self' );

</script>
<?php
exit;
}
?>

<?php
mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>