<?php
function NazovKomodity($cislokomodity)
                {
if( $cislokomodity == 1 ) $text_komodita="obaly z papiera \"O\"";
if( $cislokomodity == 101 ) $text_komodita="obaly z papiera \"N\"";
if( $cislokomodity == 2 ) $text_komodita="obaly z plastov \"O\"";
if( $cislokomodity == 102 ) $text_komodita="obaly z plastov \"N\"";
if( $cislokomodity == 3 ) $text_komodita="obaly z kovu Al \"O\"";
if( $cislokomodity == 103 ) $text_komodita="obaly z kovu Al \"N\"";
if( $cislokomodity == 4 ) $text_komodita="obaly z kovu Fe \"O\"";
if( $cislokomodity == 104 ) $text_komodita="obaly z kovu Fe \"N\"";
if( $cislokomodity == 5 ) $text_komodita="obaly zo skla \"O\"";
if( $cislokomodity == 105 ) $text_komodita="obaly zo skla \"N\"";
if( $cislokomodity == 6 ) $text_komodita="viacvrstv.obaly \"O\"";
if( $cislokomodity == 106 ) $text_komodita="viacvrstv.obaly \"N\"";
if( $cislokomodity == 7 ) $text_komodita="elektroz. tr1";
if( $cislokomodity == 8 ) $text_komodita="elektroz. tr2";
if( $cislokomodity == 9 ) $text_komodita="elektroz. tr3";
if( $cislokomodity == 10 ) $text_komodita="elektroz. tr4";
if( $cislokomodity == 11 ) $text_komodita="elektroz. tr5";
if( $cislokomodity == 12 ) $text_komodita="elektroz. tr6";
if( $cislokomodity == 16 ) $text_komodita="batérie pren.";
if( $cislokomodity == 17 ) $text_komodita="batérie priem.";
if( $cislokomodity == 18 ) $text_komodita="batérie auto";
if( $cislokomodity == 19 ) $text_komodita="pneumatiky";
if( $cislokomodity == 20 ) $text_komodita="oleje";
if( $cislokomodity == 21 ) $text_komodita="sklo neobal";
if( $cislokomodity == 22 ) $text_komodita="viacvr.mat.neobal";
if( $cislokomodity == 23 ) $text_komodita="papier neobal";
if( $cislokomodity == 24 ) $text_komodita="plast neobal";

return $text_komodita;
                }
?>