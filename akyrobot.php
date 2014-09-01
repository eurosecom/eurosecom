<?php
$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$robot3="robot3";

$pole = explode(".", $dnes);
$aky_rok=$pole[2];

//echo $aky_rok;

if( $dnes == '01.01.'.$aky_rok ) $robot3="robot3_novyrok";
if( $dnes == '06.01.'.$aky_rok ) $robot3="robot3_trajakrali";
if( $dnes == '18.04.'.$aky_rok ) $robot3="robot3_velkanoc";
if( $dnes == '19.04.'.$aky_rok ) $robot3="robot3_velkanoc";
if( $dnes == '20.04.'.$aky_rok ) $robot3="robot3_velkanoc";
if( $dnes == '21.04.'.$aky_rok ) $robot3="robot3_velkanoc";
if( $dnes == '01.06.'.$aky_rok ) $robot3="robot3_0106_mdd";
if( $dnes == '30.06.'.$aky_rok ) $robot3="robot3_3006_vysv";
if( $dnes == '01.07.'.$aky_rok ) $robot3="robot3_0107_prazdniny";
if( $dnes == '05.07.'.$aky_rok ) $robot3="robot3_0507_cyril";
if( $dnes == '29.08.'.$aky_rok ) $robot3="robot3_2908_snp";
if( $dnes == '01.09.'.$aky_rok ) $robot3="robot3_0109_ustava";
if( $dnes == '06.12.'.$aky_rok ) $robot3="robot3_0612_mik";
if( $dnes == '24.12.'.$aky_rok ) $robot3="robot3_vianoce";
if( $dnes == '25.12.'.$aky_rok ) $robot3="robot3_vianoce";
if( $dnes == '26.12.'.$aky_rok ) $robot3="robot3_vianoce";
if( $dnes == '31.12.'.$aky_rok ) $robot3="robot3_silvester";


//2015
if( $dnes == '03.04.2015' ) $robot3="robot3_velkanoc";
if( $dnes == '04.04.2015' ) $robot3="robot3_velkanoc";
if( $dnes == '05.04.2015' ) $robot3="robot3_velkanoc";
if( $dnes == '06.04.2015' ) $robot3="robot3_velkanoc";

?>