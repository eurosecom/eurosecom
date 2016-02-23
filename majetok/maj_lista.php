<?php
$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

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
$lisuwin="width=700, height=' + vyskalis + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$lisswin="width=980, height=' + vyskalis + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$vlisuwin="width=700, height=' + vyskalis + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$vlisswin="width=980, height=' + vyskalis + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$vliscwin="width=' + sirkalis + ', height=' + vyskalis + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";
?>

<table class=user border=0 width="500" >
<tr class=user>

<td width="8%">
<center>
<a href="#" onClick="window.open('../cis/cico.php?copern=1&page=1', '_blank', '<?php echo $lisswin; ?>' )"><img border=2 src='../obr/klienti.png' 
style="width:30; height:30;" title="Èíselník IÈO" > </a>
<a href="#" onClick="window.open('../cis/cico.php?copern=1&page=1', '_blank', '<?php echo $lisswin; ?>' )"><font size="1">IÈO</font></a></center>

<td width="8%">
<center>
<a href='../cis/cstr.php?copern=1&page=1' target="_blank" ><img border=2 src="../obr/firmy.png"
style="width:30; height:30;" title="Èíselník stredísk"> </a>
<a href='../cis/cstr.php?copern=1&page=1' target="_blank" ><font size="1">STR</font></a></center>

<td width="8%">
<center>
<a href='../cis/czak.php?copern=1&page=1' target="_blank" ><img border=2 src="../obr/klienti.png"
style="width:30; height:30;" title="Èíselník zákaziek"> </a>
<a href='../cis/czak.php?copern=1&page=1' target="_blank" ><font size="1">ZÁK</font></a></center>

<td width="8%">
<center>
<a href='../cis/ufir.php?copern=81' target="_blank" ><img border=2 src="../obr/firmy.png"
style="width:30; height:30;" title="Parametre programu Dlhodobý majetok"> </a>
<a href='../cis/ufir.php?copern=81' target="_blank" ><font size="1">PRM</font></a></center>

<td width="8%">
<center>
<a href='../cis/ufir.php?copern=1' target="_blank" ><img border=2 src="../obr/klienti.png"
style="width:30; height:30;" title="Údaje o firme"> </a>
<a href='../cis/ufir.php?copern=1' target="_blank" ><font size="1">FRM</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><img border=2 src='../obr/firmy.png' 
style="width:30; height:30;" title="Zoznam dlhodobého majetku" > </a>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><font size="1">MAJ</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=11&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
style="width:30; height:30;" title="Pohyby dlhodobého majetku" > </a>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=11&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><font size="1">POM</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=2&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><img border=2 src='../obr/firmy.png' 
style="width:30; height:30;" title="Zoznam drobného majetku" > </a>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=2&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><font size="1">DIM</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=12&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
style="width:30; height:30;" title="Pohyby drobného majetku" > </a>
<a href="#" onClick="window.open('../majetok/vstmaj.php?copern=1&drupoh=12&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><font size="1">POD</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../majetok/mesodp.php?copern=2&drupoh=1&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><img border=2 src='../obr/firmy.png' 
style="width:30; height:30;" title="Mesaèný odpis majetku" > </a>
<a href="#" onClick="window.open('../majetok/mesodp.php?copern=2&drupoh=1&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><font size="1">MES</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../majetok/zrsmes.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><img border=2 src='../obr/klienti.png' 
style="width:30; height:30;" title="Preh¾ady a rušenie mesaèných odpisov" > </a>
<a href="#" onClick="window.open('../majetok/zrsmes.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>','_self','<?php echo $vliscwin; ?>')"><font size="1">PRH</font></a></center>

<?php $h_dru=1; if( $drupoh == 2 OR $drupoh == 12 ) { $h_dru=2; } ?>

<td width="8%">
<center>
<a href="#" onClick="window.open('../majetok/tlac_majpdf.php?h_zos=1&h_dru=<?php echo $h_dru;?>&copern=30&drupoh=1&page=1&typ=PDF','_blank','<?php echo $vliscwin; ?>')"><img border=2 src='../obr/hladaj.png' 
style="width:30; height:30;" title="Preddefinovaná zostava MAJETKU è.1" > </a>
<a href="#" onClick="window.open('../majetok/tlac_majpdf.php?h_zos=1&h_dru=<?php echo $h_dru;?>&copern=30&drupoh=1&page=1&typ=PDF','_blank','<?php echo $vliscwin; ?>')"><font size="1">ZS1</font></a></center>


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
style="width:30; height:30;" title="Úètovný mesiac <?php echo $kli_pume;?>" > </a>
<a href="#" onClick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=1','_self')"><font size="1">UM-</font></a></center>


<td width="8%">
<center>
<a href="#" onClick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=2','_self')"><img border=2 src='../obr/next.png' 
style="width:30; height:30;" title="Úètovný mesiac <?php echo $kli_dume;?>" > </a>
<a href="#" onClick="window.open('../cis/zmenume.php?odkaz=<?php echo $odkaz64;?>&copern=2','_self')"><font size="1">UM+</font></a></center>
<?php
}
?>

<td width="8%">
<center>
<a href="#" onClick="window.open('../podvojneu.php?copern=1','_self')"><img border=2 src='../obr/menu/ucto.jpg' 
style="width:30; height:30;" title="Finanèné úètovníctvo" > </a>
<a href="#" onClick="window.open('../podvojneu.php?copern=1','_self')"><font size="1">UCT</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../mzdy.php?copern=1','_self')"><img border=2 src='../obr/menu/mzdy.jpg' 
style="width:30; height:30;" title="Mzdy a personalistika" > </a>
<a href="#" onClick="window.open('../mzdy.php?copern=1','_self')"><font size="1">MZD</font></a></center>

<td width="8%">
<center>
<a href="#" onClick="window.open('../sklad.php?copern=1','_self')"><img border=2 src='../obr/menu/sklady.jpg' 
style="width:30; height:30;" title="Sklad, zásoby" > </a>
<a href="#" onClick="window.open('../sklad.php?copern=1','_self')"><font size="1">SKL</font></a></center>


<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
<td width="10%" ></td>
</span>
<?php
/*


*/

?>