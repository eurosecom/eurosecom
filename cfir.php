<HTML>
<?php

// require_once('otvTEST.inc');
// celkovy zaciatok dokumentu
       do
       {
$sys = 'ALL';
$urov = 15000;
$uziv = include("uziv.php");
if( !$uziv ) exit;

require_once("pswd/password.php");

$newdelenie=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) { $newdelenie=1; }
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("oddel_dtb3new.php");
          }
else
          {
$dtb2 = include("oddel_dtb3.php");
          }

@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$cislo_xcf = $_REQUEST['cislo_xcf'];
$nazov_xcf = $_REQUEST['nazov_xcf'];
?>
<?php
//vymazanie tabuliek
if( $copern == 66 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky tabulky firmy ËÌslo: <?php echo "$cislo_xcf"; ?> \r <?php echo "$nazov_xcf"; ?> ?") )
         { window.close();  }
else
  var okno = window.open("cfir.php?copern=67&page=1&cislo_xcf=<?php echo $cislo_xcf;?>","_self");
</script>

<?php
exit;
}

    if ( $copern == 168967 )
    {

//CISELNIKY
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_ico';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_ico!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_icoodbm';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_icoodbm!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sku';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sku!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_str';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_str!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_stv';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_stv!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_ufir';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_ufir!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_zak';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_zak!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvall';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvall!"."vymazan· <br />";

//SKLAD
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvskl';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvskl!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklcis';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklcis!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklpoc';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklpoc!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklpri';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklpri!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklvyd';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklvyd!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklpre';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklpre!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklzas';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklzas!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklfak';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklfak!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sklcph';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sklcph!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_skl';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_skl!"."vymazan· <br />";

//FAKTURY
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvfak';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvfak!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_ddod';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_ddod!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dodb';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dodb!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sluzby';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sluzby!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_sluzbyzas';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_sluzbyzas!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakodb';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakodb!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakodbpoc';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakodbpoc!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakslu';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakslu!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakdod';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakdod!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakdodpoc';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakdodpoc!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakdol';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakdol!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakprf';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakprf!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_fakvnp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_fakvnp!"."vymazan· <br />";


//UCTO
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvuct';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvuct!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctpok';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctpok!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_pokpri';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_pokpri!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_pokvyd';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_pokvyd!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dpok';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dpok!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_banvyp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_banvyp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dban';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dban!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctban';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctban!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctdod';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctdod!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctdop';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctdop!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctdrdp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctdrdp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctmaj';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctmaj!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctmzd';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctmzd!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctodb';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctodb!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctosnova';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctosnova!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctosnova2';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctosnova2!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctpokuct';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctpokuct!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctskl';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctskl!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctvsdh';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctvsdh!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctvsdp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctvsdp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctcudz';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctcudz!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctkurzy';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctkurzy!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctmeny';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctmeny!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctpriku';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctpriku!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_uctprikp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_uctprikp!"."vymazan· <br />";


//DOPRAVA
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvdop';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvdop!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopdkp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopdkp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopdol';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopdol!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopdpm';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopdpm!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopdvz';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopdvz!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopfak';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopfak!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopplk';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopplk!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopreg';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopreg!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopslu';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopslu!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopsluzby';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopsluzby!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopsluzbyzas';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopsluzbyzas!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopstzh';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopstzh!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopstzp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopstzp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopvnp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopvnp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopvod';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopvod!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopvoz';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopvoz!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopzvz';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopzvz!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopnakphm';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopnakphm!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_doppokpri';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_doppokpri!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopprf';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopprf!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopnaklady';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopnaklady!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_dopvynosy';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_dopvynosy!"."vymazan· <br />";


//VYROBA
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvvyr';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvvyr!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_unikod';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_unikod!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrrcph';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrrcph!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrrcpp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrrcpp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrrcpvyr';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrrcpvyr!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrkomp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrkomp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrzakdopln';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrzakdopln!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyroperacie';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyroperacie!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrprikh';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrprikh!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrprikp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrprikp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vyrzakpol';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vyrzakpol!"."vymazan· <br />";


//CESTOVNE
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvcst';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvcst!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_cstslcesty';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_cstslcesty!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_cstprikh';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_cstprikh!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_cstprikp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_cstprikp!"."vymazan· <br />";


//MAJETOK
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvmaj';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvmaj!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majdim';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majdim!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majdimdrm';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majdimdrm!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majmaj';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majmaj!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majdrm';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majdrm!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majdrunak';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majdrunak!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majdruvyr';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majdruvyr!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_kancelarie';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_kancelarie!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdkun';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdkun!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majodpisy';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majodpisy!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majpoh';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majpoh!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majpohdim';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majpohdim!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majsodp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majsodp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_majmajmes';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_majmajmes!"."vymazan· <br />";

//MZDY
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_vtvmzd';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_vtvmzd!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdkun';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdkun!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdtrn';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdtrn!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_zdravpois';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_zdravpois!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzddeti';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzddeti!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdddp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdddp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzddmn';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzddmn!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdpomer';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdpomer!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdmes';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdmes!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdprm';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdprm!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdzalprm';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdzalprm!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdzalkun';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdzalkun!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdzaltrn';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdzaltrn!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdzalmes';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdzalmes!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdzalvy';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdzalvy!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdzalsum';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdzalsum!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdzalddp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdzalddp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdcisddp';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdcisddp!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzddss';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzddss!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzducty';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzducty!"."vymazan· <br />";

$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdprm_new032009';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdprm_new032009!"."vymazan· <br />";
$sqlt = 'DROP TABLE F'.$cislo_xcf.'_mzdprm_new072009';
$vysledok = mysql_query("$sqlt");
if ($vysledok)
echo "Tabulka F$cislo_xcf"."_mzdprm_new072009!"."vymazan· <br />";



$copern=1;
    }
//koiec vymazania copern=67

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>».⁄Ë.Jednotiek</title>
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

  function Servis()
  { 
  window.open('../secom/servis.php?copern=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
  }

  function Vlozit(cisloold, cislonew)
  { 
  window.open('cfir_u.php?copern=1007&cisloold=' + cisloold + '&cislonew=' + cislonew + '&tt=1','_self'); 
  }

  function DeleneDtb()
  { 
  window.open('../cis/delenedtb.php?copern=1','_blank','width=980, height=800, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes'); 
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
<td>EuroSecom  -  »ÌselnÌk ˙Ëtovn˝ch jednotiek

<?php if( $kli_uzidall > 500000 )
  {
?>
<img src='../obr/naradie.png' width=15 height=12 border=1 onClick='Servis();' title='InformaËn˝ a reklamn˝ systÈm' >
<?php
  }
?>
<img src='../obr/naradie.png' width=15 height=12 border=1 onClick='DeleneDtb();' title='NovÈ nastavenie delen˝ch datab·z' >
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
$h_xcf = $_REQUEST['h_xcf'];
$h_naz = $_REQUEST['h_naz'];
$h_rok = $_REQUEST['h_rok'];
$h_duj = $_REQUEST['h_duj'];
$h_dtb = $_REQUEST['h_dtb'];
$h_prav = $_REQUEST['h_prav'];
$cislo_xcf = $_REQUEST['cislo_xcf'];
require_once("pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
endif;
mysql_select_db($mysqldb);
$upravene = mysql_query("UPDATE fir SET naz='$h_naz', rok=$h_rok, duj=$h_duj, dtb='$h_dtb', prav='$h_prav', id_klienta='$kli_id' WHERE  xcf=$cislo_xcf"); 
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
echo "POLOéKA FIR:$cislo_xcf UPRAVEN¡ ";
$pole = explode(",", $h_dtb);
$pole0=$pole[0]; $pole1=$pole[1]; $pole2=$pole[2]; $pole3=$pole[3]; $pole4=$pole[4]; $pole5=$pole[5];
if( $pole0 == 'CDO' OR $pole1 == 'CDO' OR $pole2 == 'CDO' OR $pole3 == 'CDO' OR $pole4 == 'CDO' OR $pole5 == 'CDO' )
{
if (File_Exists ("dokumenty/FIR$cislo_xcf/cislovanie_dokladov_oddelene.ano"))
 { $soubor = unlink("dokumenty/FIR$cislo_xcf/cislovanie_dokladov_oddelene.ano"); }
$soubor = fopen("dokumenty/FIR$cislo_xcf/cislovanie_dokladov_oddelene.ano", "a+");
fclose($soubor);
}
if( $pole0 != 'CDO' AND $pole1 != 'CDO' AND $pole2 != 'CDO' AND $pole3 != 'CDO' AND $pole4 != 'CDO' AND $pole5 != 'CDO' )
{
if (File_Exists ("dokumenty/FIR$cislo_xcf/cislovanie_dokladov_oddelene.ano")) { $soubor = unlink("dokumenty/FIR$cislo_xcf/cislovanie_dokladov_oddelene.ano"); }
}
endif;
  }

// toto je cast ulozenie poloziek z cfir_u.php
// 5=ulozenie polozky do databazy nahratej v cfir_u.php
// 6=vymazanie polozky potvrdene v cfir_u.php
if ( $copern == 5 || $copern == 6 )
     {
$h_xcf = $_REQUEST['h_xcf'];
$h_naz = $_REQUEST['h_naz'];
$h_rok = $_REQUEST['h_rok'];
$h_duj = $_REQUEST['h_duj'];
$h_dtb = $_REQUEST['h_dtb'];
$h_prav = $_REQUEST['h_prav'];
$cislo_xcf = $_REQUEST['cislo_xcf'];
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
$ulozttt = "INSERT INTO fir ( xcf,naz,rok,duj,dtb,id_klienta,prav ) VALUES ".
" ($h_xcf, '$h_naz', $h_rok, $h_duj, '$h_dtb', '$kli_id', 'XxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxxXxxxxxxxxx' ); "; 
$ulozene = mysql_query("$ulozttt"); 
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
echo "POLOéKA FIR:$h_xcf SPR¡VNE ULOéEN¡ ";
$ddir="dokumenty/FIR".$h_xcf;
mkdir ($ddir, 0777);
if( $kli_vrok > 2011 )
  {
if (File_Exists ("dokumenty/FIR$h_xcf/ajprepocetnask.nie"))
 { $soubor = unlink("dokumenty/FIR$h_xcf/ajprepocetnask.nie"); }
$soubor = fopen("dokumenty/FIR$h_xcf/ajprepocetnask.nie", "a+");
fclose($soubor);
  }
$ddir="import/FIR".$h_xcf;
mkdir ($ddir, 0777);
$pole = explode(",", $h_dtb);
$pole0=$pole[0]; $pole1=$pole[1]; $pole2=$pole[2]; $pole3=$pole[3]; $pole4=$pole[4]; $pole5=$pole[5];
if( $pole0 == 'CDO' OR $pole1 == 'CDO' OR $pole2 == 'CDO' OR $pole3 == 'CDO' OR $pole4 == 'CDO' OR $pole5 == 'CDO' )
{
if (File_Exists ("dokumenty/FIR$h_xcf/cislovanie_dokladov_oddelene.ano"))
 { $soubor = unlink("dokumenty/FIR$h_xcf/cislovanie_dokladov_oddelene.ano"); }
$soubor = fopen("dokumenty/FIR$h_xcf/cislovanie_dokladov_oddelene.ano", "a+");
fclose($soubor);
}
if( $pole0 != 'CDO' AND $pole1 != 'CDO' AND $pole2 != 'CDO' AND $pole3 != 'CDO' AND $pole4 != 'CDO' AND $pole5 != 'CDO' )
{
if (File_Exists ("dokumenty/FIR$h_xcf/cislovanie_dokladov_oddelene.ano")) { $soubor = unlink("dokumenty/FIR$h_xcf/cislovanie_dokladov_oddelene.ano"); }
}

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
$zmazane = mysql_query("DELETE FROM fir WHERE fir.xcf = $cislo_xcf;"); 
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
echo "POLOéKA FIR:$cislo_xcf BOLA VYMAZAN¡ ";
endif;
    }
     }
?>

<?php
if( $newdelenie == 1 AND ( $copern == 5 OR $copern == 6 OR $copern == 8 ))
          {

if( $mysqldb2016 != $mysqldb2017 AND $mysqldb2017 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2017."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2017."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2017.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2017.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2018 AND $mysqldb2018 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2018."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2018."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2018.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2018.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }

if( $mysqldb2016 != $mysqldb2019 AND $mysqldb2019 != '' ) {
$sqlttt=" DROP TABLE `".$mysqldb2019."`.`fir` "; $sql = mysql_query("$sqlttt");
$sqlttt=" CREATE TABLE `".$mysqldb2019."`.`fir` SELECT * FROM `".$mysqldb2016."`.`fir` "; $sql = mysql_query("$sqlttt");
//echo $sqlttt;

$sql = "ALTER TABLE ".$mysqldb2019.".fir MODIFY id_klienta int PRIMARY KEY ";
$vysledek = mysql_query("$sql");
//echo $sql;
$sql = "ALTER TABLE ".$mysqldb2019.".fir MODIFY datm timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");


                                   }


          }
//if( $newdelenie == 1 )
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
$sql = mysql_query("SELECT * FROM fir ORDER BY xcf");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_naz = $_REQUEST['hladaj_naz'];

if ( $hladaj_naz != "" ) $sql = mysql_query("SELECT * FROM fir WHERE ( naz LIKE '%$hladaj_naz%' OR xcf LIKE '%$hladaj_naz%' ) ORDER BY xcf");
if ( $hladaj_naz == "" ) $sql = mysql_query("SELECT * FROM fir ORDER BY xcf");
  }
// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =ceil($cpol / $pols);
?>

<table class="fmenu" width="100%" >
<tr>
<th class="hmenu">FIR<th class="hmenu">N·zov ˙Ëtovnej jednotky<th class="hmenu">Rok<th class="hmenu">DUJ<th class="hmenu">Parametre<th class="hmenu">Uprav<th class="hmenu">Zmaû
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
<td class="fmenu" width="10%" ><?php echo $riadok->xcf;?></td>
<td class="fmenu" width="60%" >
<?php
if ( $kli_uzall > 500000 )
  {
?>
<a href='cfir.php?copern=66&page=<?php echo $page;?>&cislo_xcf=<?php echo $riadok->xcf;?>&nazov_xcf=<?php echo $riadok->naz;?>'>
 <img src='obr/odstran.png' width=20 height=20 border=0 title="Vymazaù vöetky tabulky vybranej firmy"></a>
<?php
  }
?>
<?php echo $riadok->naz;?>
</td>
<td class="fmenu" width="10%" ><?php echo $riadok->rok;?></td>
<td class="fmenu" width="10%" ><?php echo $riadok->duj;?></td>
<td class="fmenu" width="10%" >
<?php
$cislonew=$riadok->xcf+1;

$uzje=0;
$sqlttt = "SELECT * FROM fir WHERE xcf = $cislonew ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $uzje=1;
 }
if( $_SERVER['SERVER_NAME'] != "localhost" AND $_SERVER['SERVER_NAME'] != "www.eshoptest.sk" ) { $uzje=1; }

if( $uzje == 0 ) { ?>
<img src='../obr/vlozit.png' width=15 height=12 border=1 onClick='Vlozit(<?php echo $riadok->xcf; ?>, <?php echo $cislonew; ?>);' title='Vloûiù firmu s ËÌslom <?php echo $cislonew; ?> a rovnak˝m nastavenÌm ako firma <?php echo $riadok->xcf; ?>' >
<?php            } ?>
<?php echo $riadok->dtb;?>
</td>
<td class="fmenu" width="5%" ><a href='cfir_u.php?copern=8&page=<?php echo $page;?>
&cislo_xcf=<?php echo $riadok->xcf;?>&naz_xcf=<?php echo $riadok->naz;?>&naz_rok=<?php echo $riadok->rok;?>&naz_prav=<?php echo $riadok->prav;?>
&naz_duj=<?php echo $riadok->duj;?>&naz_dtb=<?php echo $riadok->dtb;?>'> <img src='obr/uprav.png' width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='cfir_u.php?copern=6&page=<?php echo $page;?>&cislo_xcf=<?php echo $riadok->xcf;?>'>Zmaû</a></td>
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
<FORM name="forma2" class="obyc" method="post" action="cfir.php?uziv=1
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
<FORM name="forma1" class="obyc" method="post" action="cfir.php?uziv=1
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
<FORM name="forma3" class="obyc" method="post" action="cfir.php?copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="cfir_u.php?copern=5&page=<?php echo $page;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma5" class="obyc" method="post" action="cfir.php?copern=7&page=<?php echo $page;?>" >
<INPUT type="submit" id="hladaj" value="Hæadaù" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="cfir_t.php
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
<FORM name="formhl1" class="hmenu" method="post" action="cfir.php?page=1&copern=9" >
<td class="hmenu">Hæadan˝ text &nbsp;<input type="text" name="hladaj_naz" id="hladaj_naz" size="50" value="<?php echo $hladaj_naz;?>" /> 
<td class="obyc" align="right"><INPUT type="submit" id="hlad1" name="hlad1" value="Vyhæadaj" ></td>
</tr>
</FORM>
<tr>
<FORM name="formhl2" class="hmenu" method="post" action="cfir.php?page=1&copern=1" >
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
