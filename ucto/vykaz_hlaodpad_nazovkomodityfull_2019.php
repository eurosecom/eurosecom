<?php
function NazovKomodityfull($cislokomodity)
                {
if( $cislokomodity == 1 ) $text_komodita="obaly z papiera a lepenky \"O\" ";
if( $cislokomodity == 101 ) $text_komodita="obaly z papiera a lepenky \"N\" ";
if( $cislokomodity == 2 ) $text_komodita="obaly z plastov (PET, PE, PP, PS, PVC) \"O\"";
if( $cislokomodity == 102 ) $text_komodita="obaly z plastov (PET, PE, PP, PS, PVC) \"N\"";
if( $cislokomodity == 3 ) $text_komodita="obaly z kovu  - hliník \"O\"";
if( $cislokomodity == 103 ) $text_komodita="obaly z kovu  - hliník \"N\"";
if( $cislokomodity == 4 ) $text_komodita="obaly z kovu – železo \"O\"";
if( $cislokomodity == 104 ) $text_komodita="obaly z kovu – železo \"N\"";
if( $cislokomodity == 5 ) $text_komodita="obaly zo skla \"O\"";
if( $cislokomodity == 105 ) $text_komodita="obaly zo skla \"N\"";
if( $cislokomodity == 6 ) $text_komodita="obaly z viacvrstvových kombinovaných materiálov \"O\"";
if( $cislokomodity == 106 ) $text_komodita="obaly z viacvrstvových kombinovaných materiálov \"N\"";
if( $cislokomodity == 7 ) $text_komodita="elektroz.tep.výmena";
if( $cislokomodity == 8 ) $text_komodita="elektroz.obrazovky";
if( $cislokomodity == 9 ) $text_komodita="elektroz.svetelné zd.";
if( $cislokomodity == 10 ) $text_komodita="elektroz.velké viac ako 50";
if( $cislokomodity == 11 ) $text_komodita="elektroz.malé menej ako 50";
if( $cislokomodity == 12 ) $text_komodita="elektorz.malé IT, telekom.";
if( $cislokomodity == 16 ) $text_komodita="batérie a akumulátory – prenosné";
if( $cislokomodity == 17 ) $text_komodita="batérie a akumulátory – priemyselné";
if( $cislokomodity == 18 ) $text_komodita="batérie a akumulátory – automobilová";
if( $cislokomodity == 19 ) $text_komodita="pneumatiky";
if( $cislokomodity == 20 ) $text_komodita="olej";
if( $cislokomodity == 21 ) $text_komodita="sklo a výrobky zo skla";
if( $cislokomodity == 22 ) $text_komodita="viacvrstvové kombinované materiály";
if( $cislokomodity == 23 ) $text_komodita="papier a lepenka a výrobky z papiera a lepenky";
if( $cislokomodity == 24 ) $text_komodita="výrobky z plastov (PET, PE, PP, PS, PVC)";

return $text_komodita;
                }
?>