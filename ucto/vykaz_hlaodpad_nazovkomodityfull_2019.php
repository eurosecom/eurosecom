<?php
function NazovKomodityfull($cislokomodity)
                {
if( $cislokomodity == 1 ) $text_komodita="obaly z papiera a lepenky \"O\" ";
if( $cislokomodity == 101 ) $text_komodita="obaly z papiera a lepenky \"N\" ";
if( $cislokomodity == 2 ) $text_komodita="obaly z plastov (PET, PE, PP, PS, PVC) \"O\"";
if( $cislokomodity == 102 ) $text_komodita="obaly z plastov (PET, PE, PP, PS, PVC) \"N\"";
if( $cislokomodity == 3 ) $text_komodita="obaly z kovu  - hlin�k \"O\"";
if( $cislokomodity == 103 ) $text_komodita="obaly z kovu  - hlin�k \"N\"";
if( $cislokomodity == 4 ) $text_komodita="obaly z kovu � �elezo \"O\"";
if( $cislokomodity == 104 ) $text_komodita="obaly z kovu � �elezo \"N\"";
if( $cislokomodity == 5 ) $text_komodita="obaly zo skla \"O\"";
if( $cislokomodity == 105 ) $text_komodita="obaly zo skla \"N\"";
if( $cislokomodity == 6 ) $text_komodita="obaly z viacvrstvov�ch kombinovan�ch materi�lov \"O\"";
if( $cislokomodity == 106 ) $text_komodita="obaly z viacvrstvov�ch kombinovan�ch materi�lov \"N\"";


if( $cislokomodity == 7 ) $text_komodita="elektroz. tr1 a. tep.v�mena - Chladiaca technika chladni�ky,mrazni�ky, klimatiz�cie, vinot�ky a.i.";
if( $cislokomodity == 31 ) $text_komodita="elektroz. tr1 b. tep.v�mena - Ostatn� zariadenia na tepeln� v�menu olejov� radi�tory,zvhl�ova�e,odvlh�ova�e, a.i.";

if( $cislokomodity == 8 ) $text_komodita="elektroz. tr2 a. obrazovky - Telev�zory,Monitory,obrazovky a.i.";
if( $cislokomodity == 32 ) $text_komodita="elektroz. tr2 b. obrazovky - Notebooky a tablety a �a��ie zobrazovacie zariadenia ktor� ,obsahuj� obrazovky v��ie ako 100 cm2";

if( $cislokomodity == 9 ) $text_komodita="elektroz. tr3 a. sveteln� zd. - Sveteln� zdroje s obsahom ortuti �iarivky,v�bojky";
if( $cislokomodity == 33 ) $text_komodita="elektroz. tr3 b. sveteln� zd. - Sveteln� zdroje LED a in�";

if( $cislokomodity == 10 ) $text_komodita="elektroz. tr4 a. velk� viac ako 50 - Ve�k� zariadenia s v�nimkou ve�k�ch svietidiel a fotovoltaick�ch panelov";
if( $cislokomodity == 34 ) $text_komodita="elektroz. tr4 b. velk� viac ako 50 - Ve�k� svietidl� s vonkaj��m rozmerom viac ako 50 cm";
if( $cislokomodity == 35 ) $text_komodita="elektroz. tr4 c. velk� viac ako 50 - Fotovoltaick� panely";

if( $cislokomodity == 11 ) $text_komodita="elektroz. tr5 a. mal� menej ako 50 - Mal� zariadenia s ak�mko�vek  vonkaj��m rozmerom menej ako 50cm";
if( $cislokomodity == 36 ) $text_komodita="elektroz. tr5 b. mal� menej ako 50 - Mal� svietidl� s vonkaj��m rozmerom menej ako 50 cm do hmotnosti 3 kg vr�tane";
if( $cislokomodity == 37 ) $text_komodita="elektroz. tr5 c. mal� menej ako 50 - Mal� svietidl� s vonkaj��m rozmerom menej ako 50 cm nad hmotnos� 3kg";

if( $cislokomodity == 12 ) $text_komodita="elektorz. tr6 a. mal� IT, telekom. - Mal� IT a telekomunika�n� zariadenia /s ak�mko�vek rozmerom menej ako 50 cm";
if( $cislokomodity == 16 ) $text_komodita="bat�rie a akumul�tory � prenosn�";
if( $cislokomodity == 17 ) $text_komodita="bat�rie a akumul�tory � priemyseln�";
if( $cislokomodity == 18 ) $text_komodita="bat�rie a akumul�tory � automobilov�";
if( $cislokomodity == 19 ) $text_komodita="pneumatiky";
if( $cislokomodity == 20 ) $text_komodita="olej";
if( $cislokomodity == 21 ) $text_komodita="sklo a v�robky zo skla";
if( $cislokomodity == 22 ) $text_komodita="viacvrstvov� kombinovan� materi�ly";
if( $cislokomodity == 23 ) $text_komodita="papier a lepenka a v�robky z papiera a lepenky";
if( $cislokomodity == 24 ) $text_komodita="v�robky z plastov (PET, PE, PP, PS, PVC)";

return $text_komodita;
                }

?>