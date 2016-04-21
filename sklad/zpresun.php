<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 500;
$cslm=402106;
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


$copern = $_REQUEST['copern'];


$cit_nas = include("../cis/citaj_nas.php");

//copern=10 mesacna zostava
//copern=20 zostava presunu z informacii


if ( $copern == 10 OR $copern == 20 )
    {

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
   sk2         INT,
   dok         INT,
   ico         INT,
   fak         INT,
   str         INT,
   zak         INT,
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,2),
   prs         DECIMAL(10,2),
   pdj         DECIMAL(10,2),
   vdj         DECIMAL(10,2),
   prj         DECIMAL(10,2),
   pcs         DECIMAL(10,2)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc2'.$sqlt;
$vytvor = mysql_query("$vsql");

if ( $copern == 20 )
    {
//presun minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,sk2,dok,ico,fak,str,zak,cis,mno,cen,(mno*cen),(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND ume < $vyb_ume )".
" ORDER BY skl,dok".
"";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,sk2,skl,dok,ico,fak,str,zak,cis,mno,cen,-(mno*cen),-(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND ume < $vyb_ume )".
" ORDER BY skl,dok".
"";
$dsql = mysql_query("$dsqlt");
    }

//presun mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,sk2,dok,ico,fak,str,zak,cis,mno,cen,(mno*cen),(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND ume = $vyb_ume )".
" ORDER BY skl,dok".
"";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,sk2,skl,dok,ico,fak,str,zak,cis,mno,cen,-(mno*cen),-(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND ume = $vyb_ume )".
" ORDER BY skl,dok".
"";
$dsql = mysql_query("$dsqlt");


//group za skl,dok,cen
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT ume,dat,skl,sk2,dok,ico,fak,str,zak,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl,dok".
"";

$dsql = mysql_query("$dsqlt");

//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
    }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlaè-V</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">
    <!--

     
    // -->
</SCRIPT>

</HEAD>
<BODY class="white" >
<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana è. &p z &P pata=prazdna
// na vysku okraje vl=15 vp=15 hr=15 dl=15 poloziek 43   

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

if ( $copern == 10 OR $copern == 20  )
  {
$sqlt = "SELECT F$kli_vxcf"."_sklprc2.skl,sk2,dok,DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat,".
" F$kli_vxcf"."_sklprc2.ico,fak,str,zak,prs,F$kli_vxcf"."_ico.nai ".
" FROM F$kli_vxcf"."_sklprc2".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc2.skl=F$kli_vxcf"."_skl.skl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_sklprc2.ico=F$kli_vxcf"."_ico.ico".
" ORDER by skl,dok".
"";

//echo $sqlt;

$sql = mysql_query("$sqlt");
  }
  

// celkom poloziek
$cpol = mysql_num_rows($sql);
// pocet poloziek na strane
$pols = 1*43;
// pocet stran
$xstr =ceil($cpol / $pols);
$strana = 1;

?>

<?php
$celskl = 0.00;
$prijem = 0.00;
$skl_min = 9999999999;
$pocet_skl = 0;

   while ($strana <= $xstr )
     {
$riad_dokon =  $pols+1;
?>

<table width="660px" align="left" border="1" cellpadding="3" cellspacing="0" bordercolor="lightblue" >
<tr bgcolor="lightblue">
<td class="tlacs" align="left" colspan="3">Zostava výdaja</td>
<td class="tlacs" align="right" colspan="4"><?php echo $vyb_ume; ?> <?php echo $vyb_naz; ?></td>
</tr>
<tr bgcolor="lightblue">
<th class="tlac">zo Skladu<th class="tlac">Doklad<th class="tlac">Dátum
<th class="tlac">na SKLAD<th class="tlac">Suma
</tr>

<?php
$i=($strana*$pols)-$pols-$pocet_skl;
$konc=($strana*$pols)-1-$pocet_skl;
$riad_dokon = $riad_dokon-1;

   while ($i <= $konc )
   {

  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$riad_dokon = $riad_dokon-1;
//agregacna uroven skl 
$skl_rozdiel = $skl_min - $riadok->skl;

//nechcem agregovat
//$skl_rozdiel = 0;
?>
<?php
if( $skl_rozdiel < 0 )
{
?>
<tr bgcolor="lightblue">
<td class="tlacs" colspan="3">Celkom sklad:&nbsp;</td>
<td class="tlacs" align="right" colspan="2"><?php echo $sCelskl;?> Eur </td>
</tr>
<?php
$riad_dokon = $riad_dokon-1;
$pocet_skl=$pocet_skl+1;
$konc=$konc-1;
$celskl = 0;
}
?>

<tr>
<td class="tlac" width="20%" >&nbsp;<?php echo $riadok->skl;?></td>
<td class="tlac" width="20%" >&nbsp;<?php echo $riadok->dok;?></td>
<td class="tlac" width="20%" >&nbsp;<?php echo $riadok->dat;?></td>
<td class="tlac" width="20%" >&nbsp;<?php echo $riadok->sk2;?></td>
<td class="tlac" align="right" width="20%" >&nbsp;<?php echo $riadok->prs;?></td>
<?php 

$celskl = $celskl + $riadok->prs;
$Cislo=$celskl+"";
$sCelskl=sprintf("%0.2f", $Cislo);


$presun = $presun + $riadok->prs;
$Cislo=$presun+"";
$sPresun=sprintf("%0.2f", $Cislo);

?>

</tr>
<?php
  }
$i = $i + 1;
$skl_min = $riadok->skl;

   }
?>

<?php
$strana = $strana + 1;
     }
?>
<tr bgcolor="lightblue">
<td class="tlacs" colspan="3">Celkom sklad:&nbsp;</td>
<td class="tlacs" align="right" colspan="2"><?php echo $sCelskl;?> Eur </td>
</tr>
<tr>
<td class="tlacs" colspan="3">Celkom:&nbsp;</td>
<td class="tlacs" align="right" colspan="2"><?php echo $sPresun;?> Eur </td>
</tr>
</table>
<br clear=left>

<?php
//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");

mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>