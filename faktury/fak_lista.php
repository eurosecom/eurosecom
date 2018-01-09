<?php

if ( $absolut == '1' )
    {  
?>
<span style="position: absolute; top: 500;"> 
<?php
}
?>
<?php

if ( $absolut != '1' )
    {  
?>
<span style="position: relative;">
<?php
}
?>


<script type="text/javascript">
//sirka a vyska okna
var sirkalis = screen.width-10;
var vyskalis = screen.height-175;
</script>
<?php
//tlacove okno
$flisuwin="width=700, height=' + vyskalis + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$flisswin="width=980, height=' + vyskalis + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$fliscwin="width=' + sirkalis + ', height=' + vyskalis + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";
?>

<table class=user border=0 width="500" >
<tr class=user>

<?php
if( $robot == 1 )
{
?>
<div id="robotokno2" style="cursor: hand; display: none; position: absolute; z-index: 200; ">
<td width="8%">
<center>
<a href="#" onClick="ukazrobot();"><img border=2 src='../obr/robot/robot3.jpg' 
height="30" width="30" title="Dobrý deò , ja som Váš EkoRobot , ak chcete komunikova kliknite na mòa prosím 1x myšou" > </a>
<a href="#" ondoubleClick="ukazrobot();"><font size="1">RUR</font></a></center>
</div>
<?php
}
?>

<td width="8%">
<center>
<a href="#" onClick="window.open('../cis/cico.php?copern=1&page=1', '_blank', '<?php echo $flisswin; ?>' )"><img border=2 src='../obr/firmy.png' 
height="30" width="30" title="Èíselník IÈO" > </a>
<a href="#" onClick="window.open('../cis/cico.php?copern=1&page=1', '_blank', '<?php echo $flisswin; ?>' )"><font size="1">IÈO</font></a></center>

<td width="8%">
<center>
<a href='../cis/cstr.php?copern=1&page=1' target="_blank" ><img border=2 src="../obr/firmy.png"
height="30" width="30" title="Èíselník stredísk"> </a>
<a href='../cis/cstr.php?copern=1&page=1' target="_blank" ><font size="1">STR</font></a></center>

<td width="8%">
<center>
<a href='../cis/czak.php?copern=1&page=1' target="_blank" ><img border=2 src="../obr/klienti.png"
height="30" width="30" title="Èíselník zákaziek"> </a>
<a href='../cis/czak.php?copern=1&page=1' target="_blank" ><font size="1">ZÁK</font></a></center>

<td width="8%">
<center>
<a href='../cis/ufir.php?copern=21' target="_blank" ><img border=2 src="../obr/firmy.png"
height="30" width="30" title="Parametre programu Faktúry"> </a>
<a href='../cis/ufir.php?copern=21' target="_blank" ><font size="1">PRM</font></a></center>

<td width="8%">
<center>
<a href='../cis/ufir.php?copern=1' target="_blank" ><img border=2 src="../obr/klienti.png"
height="30" width="30" title="Údaje o firme"> </a>
<a href='../cis/ufir.php?copern=1' target="_blank" ><font size="1">FRM</font></a></center>


<td width="8%">
<center>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=1&page=1','_self','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/firmy.png' 
height="30" width="30" title="Zoznam odberate¾ských faktúr" > </a>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=1&page=1','_self','<?php echo $fliscwin; ?>')"><font size="1">FAK</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=2&page=1','_self','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
height="30" width="30" title="Zoznam dodavate¾ských faktúr" > </a>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=2&page=1','_self','<?php echo $fliscwin; ?>')"><font size="1">FAD</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../ucto/vstpok.php?copern=1&drupoh=1&page=1','_self','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/firmy.png' 
height="30" width="30" title="Zoznam príjmových pokladnièných dokladov" > </a>
<a href="#" onClick="window.open('../ucto/vstpok.php?copern=1&drupoh=1&page=1','_self','<?php echo $fliscwin; ?>')"><font size="1">POP</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../ucto/vstpok.php?copern=1&drupoh=2&page=1','_self','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
height="30" width="30" title="Zoznam výdavkových pokladnièných dokladov" > </a>
<a href="#" onClick="window.open('../ucto/vstpok.php?copern=1&drupoh=2&page=1','_self','<?php echo $fliscwin; ?>')"><font size="1">POV</font></a></center>


<td width="8%">
<center>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=11&page=1','_self','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/firmy.png' 
height="30" width="30" title="Zoznam dodacích listov" > </a>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=11&page=1','_self','<?php echo $fliscwin; ?>')"><font size="1">DOD</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=21&page=1','_self','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
height="30" width="30" title="Zoznam vnútropodnikových faktúr" > </a>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=21&page=1','_self','<?php echo $fliscwin; ?>')"><font size="1">VNP</font></a></center>

<td width="8%">
<center>
<a href='../sklad/cskl.php?copern=1&page=1' target="_blank" ><img border=2 src="../obr/firmy.png"
height="30" width="30" title="Èíselník skladov"> </a>
<a href='../sklad/cskl.php?copern=1&page=1' target="_blank" ><font size="1">SKL</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../sklad/ccis.php?copern=1&page=1','_blank','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
height="30" width="30" title="Èíselník materiálu a tovaru" > </a>
<a href="#" onClick="window.open('../sklad/ccis.php?copern=1&page=1','_blank','<?php echo $fliscwin; ?>')"><font size="1">MAT</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../faktury/cslu.php?copern=1&page=1','_blank','<?php echo $fliscwin; ?>')"><img border=2 src='../obr/firmy.png' 
height="30" width="30" title="Èíselník služieb" > </a>
<a href="#" onClick="window.open('../faktury/cslu.php?copern=1&page=1','_blank','<?php echo $fliscwin; ?>')"><font size="1">SLU</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../ucto/kurzy.php?copern=1&drupoh=1&page=1','_blank','<?php echo $uliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
height="30" width="30" title="Kurzový lístok" > </a>
<a href="#" onClick="window.open('../ucto/kurzy.php?copern=1&drupoh=1&page=1','_blank','<?php echo $uliscwin; ?>')"><font size="1">KUR</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../sklad/sklkar.php?copern=1&drupoh=1&page=1','_blank','<?php echo $vlisuwin; ?>')"><img border=2 src='../obr/zoznam.png' 
height="30" width="30" title="Skladové karty" > </a>
<a href="#" onClick="window.open('../sklad/sklkar.php?copern=1&drupoh=1&page=1','_blank','<?php echo $vlisuwin; ?>')"><font size="1">KAR</font></a></center>


<?php
  $ajregistracka=0;
  if (File_Exists ("../dokumenty/FIR$kli_vxcf/ajregistracka.ano")) { $ajregistracka=1; }
  if (File_Exists ("dokumenty/FIR$kli_vxcf/ajregistracka.ano")) { $ajregistracka=1; }
if( $vyb_xcf == 2687 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ajregistracka=1; }
if( $kli_vxcf == 2687 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ajregistracka=1; }
if( $vyb_xcf == 2688 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ajregistracka=1; }
if( $kli_vxcf == 2688 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ajregistracka=1; }
  if( $ajregistracka == 1 ) { ?>
<td width="8%">
<center>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=42&page=1&hladaj_uce=21160&pocstav=0&regpok=1','_self','<?php echo $uliscwin; ?>')"><img border=2 src='../obr/banky/euro.jpg' 
height="30" width="30" title="Registraèná pokladnica" > </a>
<a href="#" onClick="window.open('../faktury/vstfak.php?copern=1&drupoh=42&page=1&hladaj_uce=21160&pocstav=0&regpok=1','_self','<?php echo $uliscwin; ?>')"><font size="1">REG</font></a></center>
<?php                       } ?>


<?php
  $ajeshop=0;
  if (File_Exists ("eshop/index.php")) { $ajeshop=1; }
  if (File_Exists ("../eshop/index.php")) { $ajeshop=1; }
  if( $ajeshop == 1 ) { ?>
<td width="8%">
<center>
<a href="#" onClick="window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')"><img border=2 src='../obr/kosik.gif' 
height="30" width="30" title="Objednávky v e-shope" > </a>
<a href="#" onClick="window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')"><font size="1">eshop</font></a></center>
<?php                       } ?>


<?php
$zmenume=1*$zmenume;
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_pmes=$kli_vmes-1;
if( $kli_pmes < 1 ) $kli_pmes=1;
$kli_dmes=$kli_vmes+1;
if( $kli_dmes > 12 ) $kli_dmes=12;
$kli_pume=$kli_pmes.".".$kli_vrok;
$kli_dume=$kli_dmes.".".$kli_vrok;

$odkaz64=urlencode($odkaz);
if( $zmenume == 1 )
{
?>

<td width="8%">
<center>
<a href="#" onClick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=1','_self')"><img border=2 src='../obr/prev.png' 
height="30" width="30" title="Úètovný mesiac <?php echo $kli_pume;?>" > </a>
<a href="#" onClick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=1','_self')"><font size="1">UM-</font></a></center>


<td width="8%">
<center>
<a href="#" onClick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=2','_self')"><img border=2 src='../obr/next.png' 
height="30" width="30" title="Úètovný mesiac <?php echo $kli_dume;?>" > </a>
<a href="#" onClick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=2','_self')"><font size="1">UM+</font></a></center>
<?php
}
?>

<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
</span>

<script type="text/javascript">
function ListaFakUct()
                {

                }

function ListaIcoUct()
                {

                }
</script>

<?php
/*


*/

?>