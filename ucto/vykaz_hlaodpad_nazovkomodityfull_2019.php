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


if( $cislokomodity == 7 ) $text_komodita="elektroz. tr1 a. tep.výmena - Chladiaca technika chladnièky,mraznièky, klimatizácie, vinotéky a.i.";
if( $cislokomodity == 31 ) $text_komodita="elektroz. tr1 b. tep.výmena - Ostatné zariadenia na tepelnú výmenu olejové radiátory,zvhlèovaèe,odvlhèovaèe, a.i.";

if( $cislokomodity == 8 ) $text_komodita="elektroz. tr2 a. obrazovky - Televízory,Monitory,obrazovky a.i.";
if( $cislokomodity == 32 ) $text_komodita="elektroz. tr2 b. obrazovky - Notebooky a tablety a ïa¾šie zobrazovacie zariadenia ktoré ,obsahujú obrazovky väèšie ako 100 cm2";

if( $cislokomodity == 9 ) $text_komodita="elektroz. tr3 a. svetelné zd. - Svetelné zdroje s obsahom ortuti žiarivky,výbojky";
if( $cislokomodity == 33 ) $text_komodita="elektroz. tr3 b. svetelné zd. - Svetelné zdroje LED a iné";

if( $cislokomodity == 10 ) $text_komodita="elektroz. tr4 a. velké viac ako 50 - Ve¾ké zariadenia s výnimkou ve¾kých svietidiel a fotovoltaických panelov";
if( $cislokomodity == 34 ) $text_komodita="elektroz. tr4 b. velké viac ako 50 - Ve¾ké svietidlá s vonkajším rozmerom viac ako 50 cm";
if( $cislokomodity == 35 ) $text_komodita="elektroz. tr4 c. velké viac ako 50 - Fotovoltaické panely";

if( $cislokomodity == 11 ) $text_komodita="elektroz. tr5 a. malé menej ako 50 - Malé zariadenia s akýmko¾vek  vonkajším rozmerom menej ako 50cm";
if( $cislokomodity == 36 ) $text_komodita="elektroz. tr5 b. malé menej ako 50 - Malé svietidlá s vonkajším rozmerom menej ako 50 cm do hmotnosti 3 kg vrátane";
if( $cislokomodity == 37 ) $text_komodita="elektroz. tr5 c. malé menej ako 50 - Malé svietidlá s vonkajším rozmerom menej ako 50 cm nad hmotnos 3kg";

if( $cislokomodity == 12 ) $text_komodita="elektorz. tr6 a. malé IT, telekom. - Malé IT a telekomunikaèné zariadenia /s akýmko¾vek rozmerom menej ako 50 cm";
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