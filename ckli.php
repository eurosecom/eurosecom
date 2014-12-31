<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 50000;
$uziv = include("uziv.php");
if( !$uziv ) exit;


  require_once("pswd/password.php");

$dtb2 = include("oddel_dtb3.php");

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];

$sql = "ALTER TABLE klienti MODIFY txt1 VARCHAR(85) ";
$vysledek = mysql_query("$sql");

if( $oddel2014 == 1 )
{
echo "modify primary, timestamp";
$sql = "ALTER TABLE dlogin MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ezak MODIFY ez_id int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE ezak MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE fir MODIFY xcf int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE h4bregister MODIFY rcpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE h4bregister_rgp MODIFY rcpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE klienti MODIFY id_klienta int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE klienti MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE krtgrd MODIFY id int UNIQUE ";
//$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE personal_dok MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE uctpoznamkypo MODIFY oc int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ucttopman MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE mzddmn MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE mzdpomer MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE nas_id MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE poslanemail MODIFY kedye timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE skluzid MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE uctpohyby MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


}
//koniec uprava rozdelenych databaz

//nastav fir a ume podla mojho konta
if( $copern == 1001 )
{
$cislo_id = 1*$_REQUEST['cislo_id'];
$page = 1*$_REQUEST['page'];

//xcf  id  ume  pr3  pr2  pr1  robot  datm  
$sqlttt = "SELECT * FROM nas_id WHERE id = $kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $firma=$riaddok->xcf;
  $ume=$riaddok->ume;
  }

$sqty = "DELETE FROM nas_id WHERE id = $cislo_id  ";
$ulozene = mysql_query("$sqty");

$Cislo=$ume+"";
$ume=sprintf("%0.4f", $Cislo);

$sqty = "INSERT INTO nas_id ( xcf,id,ume,pr3,pr2,pr1,robot,datm )".
" VALUES ( '$firma', '$cislo_id', '$ume', 0, 0, 0, 1, now()  );"; 
$ulozene = mysql_query("$sqty");

$copern=1;
}
//koniec nastav fir a ume podla mojho konta

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>».UûÌvateæov</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    function ObnovUI()
    {
    var ii=1*<?php echo $_REQUEST['page'];?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    }

    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
     else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
    }

<?php
//hladanie
    if ( $copern == 7 )
    {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_naz.focus();
    }
<?php
    }
?>
<?php
//nehladanie
    if ( $copern != 7 )
    {
?>
    function VyberVstup()
    {
    document.forma3.page.focus();
    document.forma3.page.select();
    }
<?php
    }
?>

  function NastavFirmu( id, page )
  { 

  window.open('ckli.php?cislo_id=' + id + '&copern=1001&page=' + page + '&xxx=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function Servis()
  { 
  window.open('../secom/servis.php?copern=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
  }

  function Spravy()
  { 
  window.open('../cis/uzivspravy.php?copern=1&page=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
  }

  function Kalendar()
  { 
  window.open('../cis/kalendar_tlac.php?copern=1&page=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
  }

  function Regpok()
  { 
  window.open('../secom/servis.php?copern=1&druhzoznamu=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
  }

  function Menp()
  { 
  window.open('../cis/setmenp.php?copern=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
  }

  function Fakturacia()
  {
   window.open('../secom/fakturacia.php?copern=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }

  function Vlozit(cisloold, cislonew)
  { 
  window.open('ckli_u.php?copern=1007&cisloold=' + cisloold + '&cislonew=' + cislonew + '&tt=1','_self'); 
  }

  function ZoznamFir(uzivatel)
  { 
  window.open('../cis/setuzfir.php?copern=1&uzid=' + uzivatel + '&tt=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
  }

  </script>
</HEAD>
<BODY class="white" onload="ObnovUI(); VyberVstup();" >

<?php 


// aktualna strana
$page = $_REQUEST['page'];
// nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  »ÌselnÌk uûÌvateæov

<img src='../obr/naradie.png' width=15 height=12 border=1 onClick='Servis();' title='InformaËn˝ a reklamn˝ systÈm' >

-

<img src='../obr/info.png' width=15 height=12 border=1 onClick='Spravy();' title='Spr·vy pre uûÌvateæov, tipy, triky' >


-

<img src='../obr/hodiny.jpg' width=15 height=12 border=1 onClick='Kalendar();' title='Kalend·r' >

-

<img src='../obr/banky/euro.jpg' width=15 height=12 border=1 onClick='Regpok();' title='UûÌvatelia Reg.pokladnice Secom,Edcom,Eurosecom...' >

-

<img src='../obr/klienti.png' width=15 height=12 border=1 onClick='Menp();' title='PrÌstupy k skriptom podæa CSLM/ID' >

-

<img src='../obr/zoznam.png' width=15 height=12 border=1 onClick='Fakturacia();' title='Faktur·cia z·kaznÌkov'>
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
//hladanie
if ( $copern == 7 )
{

}

//uprava
if ( $copern == 8 )
  {
$h_id = $_REQUEST['h_id'];
$h_uzm = $_REQUEST['h_uzm'];
$h_uzh = $_REQUEST['h_uzh'];
$h_prie = $_REQUEST['h_prie'];
$h_meno = $_REQUEST['h_meno'];
$h_all = $_REQUEST['h_all'];
$h_uct = $_REQUEST['h_uct'];
$h_mzd = $_REQUEST['h_mzd'];
$h_skl = $_REQUEST['h_skl'];
$h_him = $_REQUEST['h_him'];
$h_dop = $_REQUEST['h_dop'];
$h_ana = $_REQUEST['h_ana'];
$h_vyr = $_REQUEST['h_vyr'];
$h_fak = $_REQUEST['h_fak'];
$h_txt1 = $_REQUEST['h_txt1'];
$cis1 = $_REQUEST['cis1'];
$cislo_id = $_REQUEST['cislo_id'];
  require_once("pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
endif;
mysql_select_db($mysqldb);
$upravene = mysql_query("UPDATE klienti SET uziv_meno='$h_uzm', uziv_heslo='$h_uzh', priezvisko='$h_prie', meno='$h_meno',
 all_prav='$h_all', uct_prav='$h_uct', mzd_prav='$h_mzd', skl_prav='$h_skl', him_prav='$h_him', dop_prav='$h_dop',
 vyr_prav='$h_vyr', fak_prav='$h_fak', ana_prav='$h_ana', txt1='$h_txt1', cis1='$cis1' WHERE id_klienta=$cislo_id"); 
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
echo "POLOéKA ID:$cislo_id UPRAVEN¡ ";
endif;

$oddel2012=0;
if (File_Exists ("pswd/oddelena2012db2013.php")) { $oddel2012=1; }
if(!isset($mysqldb2012)) { $oddel2012=0; }
if( $oddel2012 == 1 ) {
$sqlttt=" DROP TABLE `".$mysqldb2012."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2012."`.`klienti` SELECT * FROM `".$mysqldb2013."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;
                      }

$oddel2013=0;
if (File_Exists ("pswd/oddelena2013db2014.php")) { $oddel2013=1; }
if(!isset($mysqldb2013)) { $oddel2013=0; }
if( $oddel2013 == 1 ) {
$sqlttt=" DROP TABLE `".$mysqldb2013."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2013."`.`klienti` SELECT * FROM `".$mysqldb2014."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;
                      }

$oddel2014=0;
if (File_Exists ("pswd/oddelena2014db2015.php")) { $oddel2014=1; }
if(!isset($mysqldb2014)) { $oddel2014=0; }
if( $oddel2014 == 1 ) {
$sqlttt=" DROP TABLE `".$mysqldb2014."`.`klienti` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2014."`.`klienti` SELECT * FROM `".$mysqldb2015."`.`klienti` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;
                      }

  }

// toto je cast ulozenie poloziek z ckli_u.php
// 5=ulozenie polozky do databazy nahratej v ckli_u.php
// 6=vymazanie polozky potvrdene v ckli_u.php
if ( $copern == 5 || $copern == 6 )
     {
$h_id = $_REQUEST['h_id'];
$h_uzm = $_REQUEST['h_uzm'];
$h_uzh = $_REQUEST['h_uzh'];
$h_prie = $_REQUEST['h_prie'];
$h_meno = $_REQUEST['h_meno'];
$h_all = $_REQUEST['h_all'];
$h_uct = $_REQUEST['h_uct'];
$h_mzd = $_REQUEST['h_mzd'];
$h_skl = $_REQUEST['h_skl'];
$h_him = $_REQUEST['h_him'];
$h_dop = $_REQUEST['h_dop'];
$h_ana = $_REQUEST['h_ana'];
$h_vyr = $_REQUEST['h_vyr'];
$h_fak = $_REQUEST['h_fak'];
$h_txt1 = $_REQUEST['h_txt1'];
$cis1 = $_REQUEST['cis1'];
$cislo_id = $_REQUEST['cislo_id'];
//ulozenie
if ( $copern == 5 )
    {
  require_once("pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
endif;
mysql_select_db($mysqldb);
$ulozene = mysql_query("INSERT INTO klienti ( uziv_meno,uziv_heslo,priezvisko,meno,all_prav,uct_prav,mzd_prav,skl_prav,him_prav,dop_prav,
vyr_prav,fak_prav,ana_prav,txt1,cis1 ) VALUES ('$h_uzm', '$h_uzh', '$h_prie', '$h_meno', '$h_all', '$h_uct', '$h_mzd', '$h_skl', '$h_him',
 '$h_dop', '$h_vyr', '$h_fak', '$h_ana', '$h_txt1', '$cis1'); "); 
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
echo "POLOéKA ID:AutoINC SPR¡VNE ULOéEN¡ ";
endif;
    }
//vymazanie
if ( $copern == 6 )
    {
  require_once("pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
endif;
mysql_select_db($mysqldb);
$zmazane = mysql_query("DELETE FROM klienti WHERE klienti.id_klienta = $cislo_id;"); 
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
echo "POLOéKA ID:$cislo_id BOLA VYMAZAN¡ ";
endif;
    }
     }


?>

<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 7=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM klienti ORDER BY id_klienta");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_naz = $_REQUEST['hladaj_naz'];

if ( $hladaj_naz != "" ) $sql = mysql_query("SELECT * FROM klienti WHERE ( uziv_meno LIKE '%$hladaj_naz%' OR priezvisko LIKE '%$hladaj_naz%' ) ORDER BY id_klienta");
if ( $hladaj_naz == "" ) $sql = mysql_query("SELECT * FROM klienti ORDER BY id_klienta");
  }
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =ceil($cpol / $pols);
?>

<table class="fmenu" width="100%" >
<tr>
<th class="hmenu">Id<th class="hmenu">Login_name<th class="hmenu">Login_heslo<th class="hmenu">Meno
<th class="hmenu">Priezvisko<th class="hmenu">herFIR<th class="hmenu">ALL_pr·va<th class="hmenu">UCT_pr·va
<th class="hmenu">MZD_pr·va<th class="hmenu">FAK_pr·va<th class="hmenu">SKL_pr·va<th class="hmenu">HIM_pr·va<th class="hmenu">DOP_pr·va
<th class="hmenu">VYR_pr·va<th class="hmenu">ANA_pr·va<th class="hmenu">Uprav<th class="hmenu">Zmaû
</tr><br />

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" width="6%" >
<?php

$uzje=0;
if( $_SERVER['SERVER_NAME'] != "localhost" AND $_SERVER['SERVER_NAME'] != "www.eshoptest.sk" ) { $uzje=1; }


if( $uzje == 0 ) { ?>
<img src='../obr/vlozit.png' width=15 height=12 border=1 onClick='Vlozit(<?php echo $riadok->id_klienta; ?>, 0);' title='Vloûiù novÈho uûÌvateæa s rovnak˝m nastavenÌm ako uûÌvateæ <?php echo $riadok->id_klienta; ?>' >
<?php            } ?>
<?php echo $riadok->id_klienta;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->uziv_meno;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->uziv_heslo;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->meno;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->priezvisko;?></td>
<td class="fmenu" width="10%" >
<?php if( $riadok->txt1 == "0-0" ) { ?>
<img src='../obr/zoznam.png' width=15 height=12 border=1 onClick='ZoznamFir(<?php echo $riadok->id_klienta; ?>);' title='Zoznam firiem pre uûÌvateæa <?php echo $riadok->id_klienta; ?>' >
<?php                              } ?>
<?php echo $riadok->txt1;?></td>
<td class="fmenu" width="5%" >
<img src='../obr/naradie.png' onClick="NastavFirmu(<?php echo $riadok->id_klienta;?>, <?php echo $page;?>);" width=15 height=15 border=0 title='Nastaviù predvolen˙ FIRmu a UME podæa mÙjho konta' >
<?php echo $riadok->all_prav;?>
</td>
<td class="fmenu" width="4%" ><?php echo $riadok->uct_prav;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->mzd_prav;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->fak_prav;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->skl_prav;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->him_prav;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->dop_prav;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->vyr_prav;?></td>
<td class="fmenu" width="4%" ><?php echo $riadok->ana_prav;?></td>
<td class="fmenu" width="4%" ><a href='ckli_u.php?copern=8&page=<?php echo $page;?>&cislo_id=<?php echo $riadok->id_klienta;?>
&naz_id=<?php echo $riadok->id_klienta;?>&naz_uzm=<?php echo $riadok->uziv_meno;?>&naz_uzh=<?php echo $riadok->uziv_heslo;?>
&naz_prie=<?php echo $riadok->priezvisko;?>&naz_meno=<?php echo $riadok->meno;?>&naz_all=<?php echo $riadok->all_prav;?>
&naz_uct=<?php echo $riadok->uct_prav;?>&naz_mzd=<?php echo $riadok->mzd_prav;?>&naz_skl=<?php echo $riadok->skl_prav;?>&naz_fak=<?php echo $riadok->fak_prav;?>
&naz_him=<?php echo $riadok->him_prav;?>&naz_dop=<?php echo $riadok->dop_prav;?>&naz_vyr=<?php echo $riadok->vyr_prav;?>
&naz_ana=<?php echo $riadok->ana_prav;?>&naz_txt1=<?php echo $riadok->txt1;?>&cis1=<?php echo $riadok->cis1;?>'> <img src='obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="4%" ><a href='ckli_u.php?copern=6&page=<?php echo $page;?>&cislo_id=<?php echo $riadok->id_klienta;?>'>Zmaû</a></td>
</tr>
<?php
  }
?>
<?php $i = $i + 1;?>
<?php
   }
?>
</table>
<?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?>
<?php
mysql_close();
mysql_free_result($sql);
    } while (false);
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="ckli.php?uziv=1
<?php
if ( $copern != 9 )
{
echo "&copern=3";
}
if ( $copern == 9 )
{
echo "&copern=9&hladaj_naz=$hladaj_naz";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="ckli.php?uziv=1
<?php
if ( $copern != 9 )
{
echo "&copern=2";
}
if ( $copern == 9 )
{
echo "&copern=9&hladaj_naz=$hladaj_naz";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="ckli.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="ckli_u.php?copern=5&page=<?php echo $page;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma5" class="obyc" method="post" action="ckli.php?copern=7&page=<?php echo $page;?>" >
<INPUT type="submit" id="hladaj" value="Hæadaù" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="ckli_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_naz=$hladaj_naz";
}
?>
" >
<INPUT type="submit" id="tlac" value="TlaËiù" >
</FORM>
</td>
</tr>
</table>

<?php
//hladanie formular
if ( $copern == 7 || $copern == 9 )
{
?>
<table class="fmenu">
<tr>
<FORM name="formhl1" class="hmenu" method="post" action="ckli.php?page=1&copern=9" >
<td class="hmenu">Hæadan˝ text &nbsp;<input type="text" name="hladaj_naz" id="hladaj_naz" size="50" value="<?php echo $hladaj_naz;?>" /> 
<td class="obyc" align="right"><INPUT type="submit" id="hlad1" name="hlad1" value="Vyhæadaj" ></td>
</tr>
</FORM>
<tr>
<FORM name="formhl2" class="hmenu" method="post" action="ckli.php?page=1&copern=1" >
<td class="hmenu"><img src='obr/hladaj.png' width=20 height=20 border=0></td>
<td class="obyc" align="right"><INPUT type="submit" id="hlad2" name="hlad2" value="Storno" ></td>
</tr>
</FORM>

<?php

// toto je koniec formulara hladanie
}

// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
