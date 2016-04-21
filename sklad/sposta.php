<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 1000;
$cslm=401200;
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

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//ulozenie nahratej spotreby 7777777777777777777777777777777
if ( $copern == 77 )
    {
$cislo_skl = $_REQUEST['cislo_skl'];
$cislo_str = $_REQUEST['cislo_str'];
$cislo_zak = $_REQUEST['cislo_zak'];
$pocriad = $_REQUEST['pocriad'];

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1]-2000;
$newdok=(100000000*$kli_vrok)+(1000000*$kli_vmes)+$cislo_skl;
$h_dat="".$pole[1]."-".$pole[0]."-28";

$sqlzm = "DELETE FROM F$kli_vxcf"."_sklvyd WHERE ( dok=$newdok AND cis=0 )";
$zmaz = mysql_query("$sqlzm");

$sqlul = "INSERT INTO F$kli_vxcf"."_sklvyd ( dok,ume,dat,skl,doq,cis,poh,ico,fak,str,zak,id )".
" VALUES ( $newdok, $kli_vume, '$h_dat', $cislo_skl, $newdok, 0, 11, 11, 0, $cislo_str, $cislo_zak, $kli_uzid ); "; 
$ulozene = mysql_query("$sqlul"); 

include("../tmp/vloz$kli_uzid.php");

//echo $sqlul;

$copern=10;
    }
//koniec ulozenia nahratej spotreby 777777777777777777777777

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
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc_stvcel';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc_stvpol';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc_stvcel'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc_stvpol'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
   poh         INT,
   str         INT,
   zak         INT,
   cis         DECIMAL(15,0),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   zst         DECIMAL(10,2),
   vst         DECIMAL(10,2),
   zas         DECIMAL(10,2),
   prs         DECIMAL(10,2),
   pdj         DECIMAL(10,2),
   vdj         DECIMAL(10,2),
   prj         DECIMAL(10,2),
   pcs         DECIMAL(10,2),
   drs         INT,
   vstmn       DECIMAL(10,3),
   zstmn       DECIMAL(10,3)

);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc2'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc_stvcel'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc_stvpol'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//poc.stav
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,mno,cen,(mno*cen),'0',(mno*cen),'0','0','0','0',(mno*cen),0,0,mno FROM F$kli_vxcf"."_sklpoc WHERE NOT ( cis = 0 )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//prijem minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,mno,cen,(mno*cen),'0',(mno*cen),'0','0','0','0',(mno*cen),0,0,mno FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//vydaj minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,-mno,cen,-(mno*cen),'0',-(mno*cen),'0','0','0','0',-(mno*cen),0,0,-mno FROM F$kli_vxcf"."_sklvyd WHERE ( NOT(poh = 11) AND cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//vydaj minuly STV
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,-mno,cen,-(mno*cen),'0',-(mno*cen),'0','0','0','0',-(mno*cen),0,0,-mno FROM F$kli_vxcf"."_sklvyd WHERE ( poh = 11 AND cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//faktury minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,-mno,cen,-(mno*cen),'0',-(mno*cen),'0','0','0','0',-(mno*cen),0,0,-mno FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun- minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,-mno,cen,-(mno*cen),'0',-(mno*cen),'0','0','0','0',-(mno*cen),0,0,-mno FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");
//presun+ minuly
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,sk2,poh,0,sk2,cis,mno,cen,(mno*cen),'0',(mno*cen),'0','0','0','0',(mno*cen),0,0,mno FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_poc )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


//prijem mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,mno,cen,(mno*cen),'0',(mno*cen),'0','0','0',(mno*cen),'0',0,0,mno FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//vydaj mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,-mno,cen,-(mno*cen),'0',-(mno*cen),'0','0',-(mno*cen),'0','0',0,0,-mno FROM F$kli_vxcf"."_sklvyd WHERE ( NOT(poh = 11) AND cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");


//vydaj mesiaca STV
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,0,cen,-(mno*cen),-(mno*cen),0,'0','0','0','0','0',0,-mno,-mno FROM F$kli_vxcf"."_sklvyd WHERE ( poh = 11 AND cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//faktury mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,-mno,cen,-(mno*cen),'0',-(mno*cen),'0',-(mno*cen),'0','0','0',0,0,-mno FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun- mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,poh,0,skl,cis,-mno,cen,-(mno*cen),'0',-(mno*cen),-(mno*cen),'0','0','0','0',0,0,-mno FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//presun+ mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,sk2,poh,0,sk2,cis,mno,cen,(mno*cen),'0',(mno*cen),(mno*cen),'0','0','0','0',0,0,mno FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//dopln drs
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc,F$kli_vxcf"."_skl".
" SET F$kli_vxcf"."_sklprc.drs = F$kli_vxcf"."_skl.drs ".
" WHERE F$kli_vxcf"."_sklprc.skl = F$kli_vxcf"."_skl.skl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln str
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc,F$kli_vxcf"."_zak".
" SET F$kli_vxcf"."_sklprc.str = F$kli_vxcf"."_zak.str ".
" WHERE F$kli_vxcf"."_sklprc.zak = F$kli_vxcf"."_zak.zak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//group za skl = zostatok celkom za sklad v Sk
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc_stvcel".$kli_uzid.
" SELECT ume,dat,skl,poh,str,zak,cis,mno,cen,SUM(zst),SUM(vst),SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),drs,SUM(vstmn),SUM(zstmn) FROM F$kli_vxcf"."_sklprc ".
" WHERE drs = 2".
" GROUP BY skl".
"";
$dsql = mysql_query("$dsqlt");

//group za skl,cis,cen = zostatok celkom za sklad,cis,cen v mno
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc_stvpol".$kli_uzid.
" SELECT ume,dat,skl,poh,str,zak,cis,SUM(mno),cen,SUM(zst),SUM(vst),SUM(zas),SUM(prs),SUM(pdj),SUM(vdj),SUM(prj),SUM(pcs),drs,SUM(vstmn),SUM(zstmn) FROM F$kli_vxcf"."_sklprc ".
" WHERE drs = 2".
" GROUP BY skl,cis,cen".
"";
$dsql = mysql_query("$dsqlt");

//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
    }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlaè-Š</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">
    <!--

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;


function TlacPodklad()
                {

window.open('spostanah_tlac.php?copern=10&cislo_skl=<?php echo $riadok->skl;?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

     
    // -->
</SCRIPT>

</HEAD>
<BODY class="white" >
<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana è. &p z &P pata=prazdna
// na sirku okraje  vl=15 vp=15 hr=15 dl=15 poloziek 28   

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

if ( $copern == 10 OR $copern == 20 )
  {
$sqlt = "SELECT F$kli_vxcf"."_sklprc_stvcel$kli_uzid.skl,pcs,prj,vdj,pdj,prs,zas,vst,".
"zst,F$kli_vxcf"."_sklprc_stvcel$kli_uzid.drs,vstmn,zstmn,str,zak ".
" FROM F$kli_vxcf"."_sklprc_stvcel".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_skl".
" ON F$kli_vxcf"."_sklprc_stvcel$kli_uzid.skl=F$kli_vxcf"."_skl.skl".
" WHERE F$kli_vxcf"."_sklprc_stvcel$kli_uzid.drs = 2 AND NOT( pcs = 0 AND prj = 0 AND prs = 0 AND zas = 0 )".
" ORDER by skl".
"";

//echo $sqlt;

$sql = mysql_query("$sqlt");
  }
  

// celkom poloziek
$cpol = mysql_num_rows($sql);
// pocet poloziek na strane
$pols = 1*28;
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
$vydstv = 0.00;
$zosstv = 0.00;
$skl_min = 9999999999;
$pocet_skl = 0;

   while ($strana <= $xstr )
     {
$riad_dokon =  $pols+1;

if( $strana > 1 )
   {
?>
</table>
<br clear=left>
<?php
   }
?>

<table width="860px" align="left" border="1" cellpadding="3" cellspacing="0" bordercolor="lightblue" >
<tr bgcolor="lightblue">
<?php
if ( $copern == 10 )
  {
?>
<td class="tlacs" align="left" colspan="5">
<a href="#" onClick="TlacPodklad();">
Stav staveništných skladov
</a>
</td>
<td class="tlacs" align="right" colspan="4"><?php echo $vyb_ume; ?> <?php echo $vyb_naz; ?></td>
<?php
  }
?>
<?php
if ( $copern == 20 )
  {
?>
<td class="tlacs" align="left" colspan="5">Stav staveništných skladov - okamžitý stav celé úètovné obdobie</td>
<td class="tlacs" align="right" colspan="4"><?php echo $vyb_naz; ?></td>
<?php
  }
?>
</tr>
<tr bgcolor="lightblue">
<th class="tlac">Sklad<th class="tlac">Poè.stav<th class="tlac">Príjem
<th class="tlac">Výdaj INÝ<th class="tlac">Predaj<th class="tlac">Presun<th class="tlac">Zásoba
<th class="tlac">Výdaj STV<th class="tlac">Zostatok STV
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

?>

<tr>
<td class="tlac" width="6%" >&nbsp;
<a href='spostanah.php?copern=20&cislo_skl=<?php echo $riadok->skl;?>' target="_blank" >
<?php echo $riadok->skl;?>
</a>
</td>
<td class="tlac" align="right" width="12%" align="right" >&nbsp;<?php echo $riadok->pcs;?></td>
<td class="tlac" align="right" width="12%" >&nbsp;<?php echo $riadok->prj;?></td>
<td class="tlac" align="right" width="12%" >&nbsp;<?php echo $riadok->vdj;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->pdj;?></td>
<td class="tlac" align="right" width="12%" >&nbsp;<?php echo $riadok->prs;?></td>
<td class="tlac" align="right" width="12%" >&nbsp;<?php echo $riadok->zas;?></td>
<td class="tlac" align="right" width="12%" >&nbsp;
<a href='spostanah.php?copern=21&cislo_skl=<?php echo $riadok->skl;?>&cislo_str=<?php echo $riadok->str;?>
&cislo_zak=<?php echo $riadok->zak;?>' >
<?php echo $riadok->vst;?>
</a>
</td>
<td class="tlac" align="right" width="12%" >&nbsp;<?php echo $riadok->zst;?></td>
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
$vydstv = $vydstv + $riadok->vst;
$Cislo=$vydstv+"";
$sVydstv=sprintf("%0.2f", $Cislo);
$zosstv = $zosstv + $riadok->zst;
$Cislo=$zosstv+"";
$sZosstv=sprintf("%0.2f", $Cislo);
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
<td class="tlacs" align="right"><?php echo $sVydstv;?></td>
<td class="tlacs" align="right"><?php echo $sZosstv;?></td>
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