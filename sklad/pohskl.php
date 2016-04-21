<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 1000;
$cslm=402101;
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


if ( $copern == 10 OR $copern == 20 )
    {
if ( $copern == 10 ) $podm_poc = "ume < ".$vyb_ume;
if ( $copern == 10 ) $podm_obd = "ume = ".$vyb_ume;
if ( $copern == 20 ) $podm_poc = "ume < 1.".$vyb_rok;
if ( $copern == 20 ) $podm_obd = "ume >= 1.".$vyb_rok." AND ume <= 12.".$vyb_rok;

//echo 'pociatok'.$podm_poc;
//echo 'obdobie'.$podm_obd;

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


//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpoc WHERE NOT ( cis = 0 )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//prijem minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//vydaj minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//faktury minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun- minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0','0','0',-(mno*cen) FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun+ minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,sk2,cis,mno,cen,(mno*cen),'0','0','0','0',(mno*cen) FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


//prijem mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,(mno*cen),'0','0','0',(mno*cen),'0' FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//vydaj mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,-(mno*cen),'0','0',-(mno*cen),'0','0' FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//faktury mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,-(mno*cen),'0',-(mno*cen),'0','0','0' FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun- mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,cis,mno,cen,-(mno*cen),-(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun+ mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,sk2,cis,mno,cen,(mno*cen),(mno*cen),'0','0','0','0' FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//group za skl,cis,cen
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT ume,dat,skl,cis,mno,cen,SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs) FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl".
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

if ( $copern == 10 OR $copern == 20 )
  {
$sqlt = "SELECT F$kli_vxcf"."_sklprc2.skl,pcs,prj,vdj,pdj,prs,zas ".
" FROM F$kli_vxcf"."_sklprc2".
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc2.skl=F$kli_vxcf"."_skl.skl".
" WHERE NOT( pcs = 0 AND prj = 0 AND prs = 0 AND zas = 0 )".
" ORDER by skl".
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
$pocstav = 0.00;
$prijem = 0.00;
$vydaj = 0.00;
$presun = 0.00;
$zostatok = 0.00;
$skl_min = 9999999999;
$pocet_skl = 0;

   while ($strana <= $xstr )
     {
$riad_dokon =  $pols+1;
?>

<table width="660px" align="left" border="1" cellpadding="3" cellspacing="0" bordercolor="lightblue" >
<tr bgcolor="lightblue">
<?php
if ( $copern == 10 )
  {
?>
<td class="tlacs" align="left" colspan="3">Pohyb materiálu v skladoch</td>
<td class="tlacs" align="right" colspan="4"><?php echo $vyb_ume; ?> <?php echo $vyb_naz; ?></td>
<?php
  }
?>
<?php
if ( $copern == 20 )
  {
?>
<td class="tlacs" align="left" colspan="4">Pohyb materiálu v skladoch - okamžitý stav celé úètovné obdobie</td>
<td class="tlacs" align="right" colspan="3"><?php echo $vyb_naz; ?></td>
<?php
  }
?>
</tr>
<tr bgcolor="lightblue">
<th class="tlac">Sklad<th class="tlac">Poè.stav<th class="tlac">Príjem
<th class="tlac">Výdaj<th class="tlac">Faktúrované<th class="tlac">Presun<th class="tlac">Zostatok
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
//$skl_rozdiel = $skl_min - $riadok->skl;
//nechcem agregovat
$skl_rozdiel = 0;
?>
<?php
if( $skl_rozdiel < 0 )
{
?>
<tr bgcolor="lightblue">
<td class="tlacs" colspan="8">Celkom sklad:&nbsp;<?php echo $sCelskl;?> Sk </td>
</tr>
<?php
$riad_dokon = $riad_dokon-1;
$pocet_skl=$pocet_skl+1;
$konc=$konc-1;
$celskl = 0;
}
?>

<tr>
<td class="tlac" width="10%" >&nbsp;<?php echo $riadok->skl;?></td>
<td class="tlac" align="right" width="15%" align="right" >&nbsp;<?php echo $riadok->pcs;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->prj;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->vdj;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->pdj;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->prs;?></td>
<td class="tlac" align="right" width="15%" >&nbsp;<?php echo $riadok->zas;?></td>
<?php 
$pocstav = $pocstav + $riadok->pcs;
$Cislo=$pocstav+"";
$sPocstav=sprintf("%0.2f", $Cislo);
$prijem = $prijem + $riadok->prj;
$Cislo=$prijem+"";
$sPrijem=sprintf("%0.2f", $Cislo);
$vydaj = $vydaj + $riadok->vdj;
$Cislo=$vydaj+"";
$sVydaj=sprintf("%0.2f", $Cislo);
$predaj = $predaj + $riadok->pdj;
$Cislo=$predaj+"";
$sPredaj=sprintf("%0.2f", $Cislo);
$presun = $presun + $riadok->prs;
$Cislo=$presun+"";
$sPresun=sprintf("%0.2f", $Cislo);
$zostatok = $zostatok + $riadok->zas;
$Cislo=$zostatok+"";
$sZostatok=sprintf("%0.2f", $Cislo);

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

<td class="tlacs">Celkom:&nbsp;</td>
<td class="tlacs" align="right"><?php echo $sPocstav;?></td>
<td class="tlacs" align="right"><?php echo $sPrijem;?></td>
<td class="tlacs" align="right"><?php echo $sVydaj;?></td>
<td class="tlacs" align="right"><?php echo $sPredaj;?></td>
<td class="tlacs" align="right"><?php echo $sPresun;?></td>
<td class="tlacs" align="right"><?php echo $sZostatok;?></td>
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