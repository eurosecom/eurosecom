<div id="uctlista-toolbar">
<style>
a { text-decoration: none; }
#uctlista-toolbar {
  overflow: auto;
  width: 98%;
  margin: 4% 1% 0 1%;
  padding-bottom: 1.5%;
}
#uctlista-toolbar > a {
  float: left;
  display: block;
  width: 36px;
  height: 40px;
  background-color: #fff;
  font-size: 10px;
  text-align: center;
  margin: 0 7px 7px 0;
  -webkit-box-shadow: inset 0 0 10px rgba(0,0,0,0.05), 0 2px 5px rgba(0,0,0,0.2);
  -moz-box-shadow: inset 0 0 10px rgba(0,0,0,0.05), 0 2px 5px rgba(0,0,0,0.2);
  box-shadow: inset 0 0 10px rgba(0,0,0,0.05), 0 2px 5px rgba(0,0,0,0.2);
}
#uctlista-toolbar > a > img {
  display: block;
  width: 26px;
  height: 22px;
  margin: 3px auto;
}
</style>

<script type="text/javascript">
//sirka a vyska okna
var sirkalis = screen.width-10;
var vyskalis = screen.height-175;
</script>
<?php
//tlacove okno
$ulisuwin="width=700, height=' + vyskalis + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$ulisswin="width=980, height=' + vyskalis + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkalis + ', height=' + vyskalis + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";
$tlctwin="width=300, height=' + vyskawin + ', top=0, left=400, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
?>

<?php if ( $kli_vduj >= 0 AND $robot == 1 ) { ?> <!-- dopyt, nem�m otestovan� -->
 <div id="robotokno2" style="cursor:hand; display:none; position:absolute; z-index:200;">
  <a href="#" onclick="ukazrobot();"><img src='../obr/robot/robot3.jpg' style="width:30px; height:30px;" title="Dobr� de�, ja som V� EkoRobot, ak chcete komunikova� kliknite na m�a pros�m 1x my�ou"></a>
  <a href="#" ondoubleclick="ukazrobot();"><font size="1">RUR</font></a>
 </div>
<?php                                       } ?>

 <a href="#" onclick="window.open('../cis/cico.php?copern=1&page=1', '_blank', '<?php echo $ulisswin; ?>')">
  <img src='../obr/firmy.png' title="��seln�k I�O">I�O</a>
 <a href='../cis/cstr.php?copern=1&page=1' target="_blank"><img src="../obr/klienti.png" title="��seln�k stred�sk">STR</a>
 <a href='../cis/czak.php?copern=1&page=1' target="_blank"><img src="../obr/firmy.png" title="��seln�k z�kaziek">Z�K</a>
 <a href='../cis/ufir.php?copern=191' target="_blank"><img src="../obr/klienti.png" title="Parametre programu Mzdy">PRM</a>
 <a href='../cis/ufir.php?copern=1' target="_blank"><img src="../obr/firmy.png" title="�daje o firme">FRM</a>
 <a href="#" onclick="window.open('../mzdy/mes_mzdy.php?copern=1&drupoh=1&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Mesa�n� d�vka">MES</a>
 <a href="#" onclick="window.open('../mzdy/zamestnanci.php?copern=1&drupoh=1&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Zoznam zamestnancov">ZAM</a>
 <a href="#" onclick="window.open('../mzdy/trvale.php?copern=1&drupoh=1&page=1&zkun=0','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Trval� polo�ky" >TRV</a>
 <a href="#" onclick="window.open('../mzdy/meszos.php?copern=1&drupoh=1&page=1&sysx=MZD','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Mesa�n� zostavy">ZOS</a>
 <a href="#" onclick="window.open('../mzdy/mzdevid.php?copern=1&drupoh=1&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Mzdov� a eviden�n� listy">MZL</a>
 <a href="#" onclick="window.open('../mzdy/RZ_dane.php?copern=1&drupoh=1&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Da� z pr�jmu FO">DAN</a>
 <a href="#" onclick="window.open('../mzdy/pomery.php?copern=1&drupoh=1&page=1','_blank','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Druhy pracovn�ch pomerov">POM</a>
 <a href="#" onclick="window.open('../mzdy/drmiezd.php?copern=1&drupoh=1&page=1&zkun=0','_blank','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Druhy mzdov�ch zlo�iek">DMN</a>
 <a href="#" onclick="window.open('../ucto/paskovacka.php?copern=5', '_blank', '<?php echo $tlctwin; ?>')">
  <img src='../obr/zoznam.png' title="Kalkula�ka">KAL</a>
 <a href="#" onclick="window.open('../mzdy/dochadzka.php?copern=1&drupoh=1&page=1&subor=0','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/hodiny.jpg' title="Doch�dzkov� syst�m" >DCH</a>
<?php $h_dru=1; if ( $drupoh == 2 OR $drupoh == 12 ) { $h_dru=2; } ?>
 <a href="#" onclick="window.open('../mzdy/tlac_zampdf.php?h_zos=1&h_dru=<?php echo $h_dru;?>&copern=30&drupoh=1&page=1&typ=PDF','_blank','<?php echo $vliscwin; ?>')">
  <img src='../obr/hladaj.png' title="Preddefinovan� zostava o ZAMESTNANCOCH �.1">ZS1</a>

<?php
$zmenume=1*$zmenume;
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_pmes=$kli_vmes-1;
if ( $kli_pmes < 1 ) $kli_pmes=1;
$kli_dmes=$kli_vmes+1;
if ( $kli_dmes > 12 ) $kli_dmes=12;
$kli_pume=$kli_pmes.".".$kli_vrok;
$kli_dume=$kli_dmes.".".$kli_vrok;
$odkaz64=urlencode($odkaz);
if ( $zmenume == 1 ) { ?>
 <a href="#" onclick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=1','_self')">
  <img src='../obr/prev.png' title="��tovn� mesiac <?php echo $kli_pume;?>">UM-</a>
 <a href="#" onclick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=2','_self')">
  <img src='../obr/next.png' title="��tovn� mesiac <?php echo $kli_dume;?>">UM+</a>
<?php                } ?>

 <a href="#" onclick="window.open('../podvojneu.php?copern=1','_self')"><img src='../obr/menu/ucto.jpg' title="Finan�n� ��tovn�ctvo">UCT</a>
 <a href="#" onclick="window.open('../sklad.php?copern=1','_self')"><img src='../obr/menu/sklady.jpg' title="Sklad, z�soby">SKL</a>
 <a href="#" onclick="window.open('../majetok.php?copern=1','_self')"><img src='../obr/menu/majetok.jpg' title="Dlhodob� majetok">MAJ</a>
 <a href="#" onclick="window.open('../vyroba/casovy_plan.php?copern=1&drupoh=1&page=1&subor=0','_self','<?php echo $lisswin; ?>')">
  <img src='../obr/hodiny.jpg' title="�asov� harmonogram">�AS</a>

</div>