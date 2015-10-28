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


<?php
//tlacove okno
$ulisuwin="width=700, height=' + vyskalis + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$ulisswin="width=980, height=' + vyskalis + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkalis + ', height=' + vyskalis + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";
$tlctwin="width=300, height=' + vyskawin + ', top=0, left=400, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
?>

<?php if ( $kli_vduj >= 0 AND $robot == 1 ) { ?> <!-- dopyt, nemám otestované a niè som s tým nerobil -->
 <div id="robotokno2" style="cursor:hand; display:none; position:absolute; z-index:200;">
  <a href="#" onclick="ukazrobot();"><img src='../obr/robot/robot3.jpg' style="width:30px; height:30px;" title="Dobrý deò, ja som Váš EkoRobot, ak chcete komunikova kliknite na mòa prosím 1x myšou"></a>
  <a href="#" ondoubleclick="ukazrobot();"><font size="1">RUR</font></a>
 </div>
<?php                                       } ?>

 <a href="#" onclick="window.open('../cis/cico.php?copern=1&page=1', '_blank', '<?php echo $ulisswin; ?>')">
  <img src='../obr/firmy.png' title="Èíselník IÈO">IÈO</a>
 <a href='../cis/cstr.php?copern=1&page=1' target="_blank"><img src="../obr/klienti.png" title="Èíselník stredísk">STR</a>
 <a href='../cis/czak.php?copern=1&page=1' target="_blank"><img src="../obr/firmy.png" title="Èíselník zákaziek">ZÁK</a>
 <a href='../cis/ufir.php?copern=91' target="_blank"><img src="../obr/klienti.png" title="Parametre programu Úètovníctvo">PRM</a>
 <a href='../cis/ufir.php?copern=1' target="_blank"><img src="../obr/firmy.png" title="Údaje o firme">FRM</a>
<?php
$hladaj_ucefo=31100;
$hladaj_ucefd=32100;
if ( $drupoh == 2 )
{
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_dodb WHERE ( drod = 1 ) ORDER BY dodb");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hladaj_ucefo=$riaddok->dodb;
  $hladaj_ucefd=$hladaj_uce;
  }
}
if ( $drupoh == 1 )
{
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ddod WHERE ( drdo = 1 ) ORDER BY ddod");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hladaj_ucefd=$riaddok->ddod;
  $hladaj_ucefo=$hladaj_uce;
  }
}
?>
 <a href="#" onclick="window.open('../faktury/vstfak.php?zmenajucet=1&hladaj_uce=<?php echo $hladaj_ucefo; ?>&copern=1&drupoh=1&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Zoznam odberate¾ských faktúr">FAK</a>
 <a href="#" onclick="window.open('../faktury/vstfak.php?zmenajucet=1&hladaj_uce=<?php echo $hladaj_ucefd; ?>&copern=1&drupoh=2&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Zoznam dodavate¾ských faktúr" >FAD</a>

<?php
$hladaj_ucepok=$hladaj_uce;
$hladaj_ucepok3=substr($hladaj_ucepok,0,3);
if ( $hladaj_ucepok3 != 211 ) $hladaj_ucepok="";
?>

<?php
$hladaj_uceban=$hladaj_uce;
$hladaj_uceban3=substr($hladaj_uceban,0,3);
if ( $hladaj_uceban3 != 221 ) $hladaj_uceban="";
?>
 <a href="#" onclick="window.open('../ucto/vstpok.php?hladaj_uce=<?php echo $hladaj_ucepok; ?>&sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=1&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Zoznam príjmových pokladnièných dokladov" >POP</a>
 <a href="#" onclick="window.open('../ucto/vstpok.php?hladaj_uce=<?php echo $hladaj_ucepok; ?>&sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=2&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Zoznam výdavkových pokladnièných dokladov" >POV</a>
 <a href="#" onclick="window.open('../ucto/vstpok.php?hladaj_uce=<?php echo $hladaj_uceban; ?>&sysx=UCT&rozuct=ANO&copern=1&drupoh=4&page=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Zoznam bankových výpisov" >BAN</a>
 <a href="#" onclick="window.open('../ucto/vstpok.php?sysx=UCT&rozuct=ANO&copern=1&drupoh=5&page=1&hladaj_uce=1','_self','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Zoznam všeobecných dokladov" >VŠE</a>
 <a href="#" onclick="window.open('../ucto/uctosn.php?sysx=UCT&rozuct=ANO&copern=1&page=1','_blank','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Úètová osnova" >ÚÈT</a>
 <a href="#" onclick="window.open('../ucto/drudan.php?sysx=UCT&rozuct=ANO&copern=1&page=1','_blank','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Druhy daòových dokladov DPH" >DPH</a>
 <a href="#" onclick="window.open('../ucto/uctpoh.php?copern=1&page=1','_blank','<?php echo $uliscwin; ?>')">
  <img src='../obr/klienti.png' title="Úètovné pohyby pre EkoRobot" >UPH</a>
 <a href="#" onclick="window.open('../ucto/kurzy.php?copern=1&drupoh=1&page=1','_blank','<?php echo $uliscwin; ?>')">
  <img src='../obr/firmy.png' title="Kurzový lístok" >KUR</a>
 <a href="#" onclick="window.open('../ucto/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT','_self')">
  <img src='../obr/klienti.png' title="Mesaèné zostavy" >MES</a>
 <a href="#" onclick="window.open('../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT','_self')">
  <img src='../obr/firmy.png' title="Saldokontá" >SAL</a>
 <a href="#" onclick="window.open('../ucto/uctpohyby.php?copern=1&drupoh=1&page=1&sysx=UCT','_self')">
  <img src='../obr/klienti.png' title="Výpis úètovných pohybov" >VYP</a>
 <a href="#" onclick="window.open('../ucto/hladaj_dok.php?copern=1&drupoh=1&page=1&sysx=UCT', '_self'  )">
  <img src='../obr/hladaj.png' title="Preh¾adávanie dokladov" >HLD</a>
 <a href="#" onclick="window.open('../ucto/paskovacka.php?copern=5', '_blank', '<?php echo $tlctwin; ?>' )">
  <img src='../obr/zoznam.png' title="Kalkulaèka" >KAL</a>
 <a href="#" onclick="window.open('../faktury/ftexty.php?copern=105', '_blank', '<?php echo $ulisuwin; ?>' )">
  <img src='../obr/firmy.png' title="Doplòujúce texty do zostáv" >TXT</a>
 <a href="#" onclick="window.open('../ucto/danprij.php?copern=1&drupoh=1&page=1&sysx=UCT','_self')">
  <img src='../obr/klienti.png' title="Priznanie k dani z príjmov" >DAN</a>

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
if ( $zmenume == 1 ) {
?>
 <a href="#" onclick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=1','_self')">
  <img src='../obr/prev.png' title="Úètovný mesiac <?php echo $kli_pume;?>">UM-</a>
 <a href="#" onclick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=2','_self')">
  <img src='../obr/next.png' title="Úètovný mesiac <?php echo $kli_dume;?>">UM+</a>
<?php                } ?>

 <a href="#" onclick="window.open('../mzdy.php?copern=1','_self')"><img src='../obr/menu/mzdy.jpg' title="Mzdy a personalistika" >MZD</a>
 <a href="#" onclick="window.open('../sklad.php?copern=1','_self')"><img src='../obr/menu/sklady.jpg' title="Sklad, zásoby" >SKL</a>
 <a href="#" onclick="window.open('../majetok.php?copern=1','_self')"><img src='../obr/menu/majetok.jpg' title="Dlhodobý majetok" >MAJ</a>
 <a href="#" onclick="window.open('../vyroba/casovy_plan.php?copern=1&drupoh=1&page=1&subor=0','_self','<?php echo $lisswin; ?>')">
  <img src='../obr/hodiny.jpg' title="Èasový harmonogram" >ÈAS</a>
</div>

<script type="text/javascript">
  function ListaFakUct(faktura)
  {
   var h_fak = faktura;
   window.open('../ucto/hladaj_fakicotlac.php?&h_fak=' + h_fak + '&h_datp=01.01.1990&h_datk=31.12.2050&copern=31&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
  function ListaIcoUct(ico)
  {
   var h_ico = ico;
   window.open('../ucto/hladaj_fakicotlac.php?&h_ico=' + h_ico + '&h_datp=01.01.1990&h_datk=31.12.2050&copern=31&drupoh=1&page=1&typ=HTML', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
</script>