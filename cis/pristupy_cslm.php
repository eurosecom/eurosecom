<?php
echo "V sripte pred testovanim pristupov uziv.php dam cslm=xyz, musi byt jednoznacne."."<br />"; 
echo "cslm 100000=ucto,200000=mzdy,300000=fakt,400000=sklad,500000=him"."<br />";
echo "Vsetci maju pristup ( ak splnaju all,uct,mzd... nastavene pristupy ) len vymenovane UZID nemaju pristup do skriptu s nastavenym cslm"."<br />";
echo "Ak ma UZID=38 uct_prava = 10000 a je v menp zadane uzid=38 a cslm=100020 tak ho nepusti do Vytvorenie mesacnych uctovnych zostav"."<br />";
echo "Ak ma UZID=38 uct_prava = 100 a nie je v menp zadane uzid=38 a cslm=100020 tak ho nepusti do Vytvorenie mesacnych uctovnych zostav lebo vyzaduju urov=1000"."<br />";

echo " "."<br />";
echo "vsade		 	cslm=999999	TOTAL BLOKOVANIE VSETKEHO - ready for ANDROIDkey"."<br />";
echo "    		 	cslm=999997	�as ke� bolo zablokovan� cez cslm=999999"."<br />";
echo "    		 	cslm=999998	�as ke� bolo odblokovan� cez cslm=999999"."<br />";
echo " "."<br />";

echo "UCTO ( pr�va pre ALL treba nastavi� na 1000 ak chce len prezera� aby sa nedostal do ��seln�kov a pr�va pre UCT treba nastavi� na 3000 na prezeranie )"."<br />";
echo "../ucto/meszos.php 	cslm=100020	Vytvorenie mesacnych uctovnych zostav"."<br />";
echo "../ucto/danprij.php 	cslm=100040	Priznanie k dani z prijmov"."<br />";
echo "../ucto/vspk_u.php 	cslm=100080	Uprava, mazanie POKLADNICA, BANKA, VSEOB"."<br />";
echo " "."<br />";

echo "../faktury/dodb.php 	cslm=101801	Druhy odberatelskych faktur"."<br />";
echo "../faktury/ddod.php 	cslm=101802	Druhy dodavatelskych faktur"."<br />";
echo "../ucto/dpok.php 		cslm=101803	Druhy pokladnic"."<br />";
echo "../ucto/dban.php 		cslm=101804	Druhy bankovych uctov"."<br />";
echo "../ucto/drudan.php 	cslm=101805	Druhy DPH"."<br />";
echo "../ucto/uctpoh.php 	cslm=101806	Pohyby asistenta ��tovania"."<br />";
echo " "."<br />";

echo "../ucto/prizdph2013.php 	cslm=100420	Priznanie DPH"."<br />";
echo "../ucto/archivdph2013.php cslm=100440	Archiv DPH"."<br />";
echo "../ucto/oprsys.php 	cslm=100620	Oprava dat z podsystemov"."<br />";
echo "../ucto/uctosnova.php 	cslm=100720	Uctova osnova"."<br />";
echo " "."<br />";

echo "../cis/ufir.php 		cslm=101901	Udaje o firme a parametre vsetkych programov ucto,mzdy.him,sklad,fakt..."."<br />";
echo " "."<br />";


echo "FAKT�RY ( pr�va pre FAK treba nastavi� na 1100 ak chce len prezera� )"."<br />";
echo "../faktury/vstf_u.php 	cslm=301881	Uprava, mazanie faktur odberatelskych"."<br />";
echo "../faktury/vstf_u.php 	cslm=301882	Uprava, mazanie faktur dodavatelskych"."<br />";
echo "../faktury/vstf_u.php 	cslm=301880	Uprava, mazanie faktur ine ako odberatelske alebo dodavatelske = dodacie listy, predfaktury..."."<br />";
echo "../faktury/vstf_t.php 	cslm=301890	Rozuctovanie tlac html faktur"."<br />";
echo " "."<br />";

echo "MAJETOK ( pr�va pre MAJ treba nastavi� na 1100 ak chce len prezera� )"."<br />";
echo "../majetok/vstmaj.php 	cslm=500101	Zoznam a pohyby dlhodob�ho a drobn�ho majetku"."<br />";
echo "../majetok/mesodp.php 	cslm=500501	Spracovanie mesa�n�ho odpisu"."<br />";
echo "../majetok/zrsmes.php 	cslm=500502	Zru�enie spracovania mesa�n�ho odpisu"."<br />";
echo "../majetok/majuct.php 	cslm=500503	Prevod do ��tovn�ctva"."<br />";
echo " "."<br />";

echo "SKLAD"."<br />";
echo "../sklad/vstpoh.php&nbsp;&nbsp;&nbsp;&nbsp; 401100&nbsp;&nbsp;&nbsp;&nbsp; Zoznam pr�jemok/v�dajok/presuniek"."<br />";
echo "../sklad/sposta.php&nbsp;&nbsp;&nbsp;&nbsp; 401200&nbsp;&nbsp;&nbsp;&nbsp; Spotreba staveni�tn�ch skladov"."<br />";
echo "../sklad/vstp_u.php&nbsp;&nbsp;&nbsp;&nbsp; 401111&nbsp;&nbsp;&nbsp;&nbsp; Pr�jemka - Nov�, �prava, Vymazanie"."<br />";
echo "../sklad/vstp_u.php&nbsp;&nbsp;&nbsp;&nbsp; 401112&nbsp;&nbsp;&nbsp;&nbsp; V�dajka - Nov�, �prava, Vymazanie"."<br />";
echo "../sklad/vstp_u.php&nbsp;&nbsp;&nbsp;&nbsp; 401113&nbsp;&nbsp;&nbsp;&nbsp; Presunka - Nov�, �prava, Vymazanie"."<br />";
echo "../sklad/poldok.php&nbsp;&nbsp;&nbsp;&nbsp; 401102&nbsp;&nbsp;&nbsp;&nbsp; Tla� pdf pr�jemky/v�dajky/presunky + tla� zoznamov"."<br />";
echo "../sklad/vstp_s.php&nbsp;&nbsp;&nbsp;&nbsp; 401103&nbsp;&nbsp;&nbsp;&nbsp; Na��taj origin�l do pr�jemky/v�dajky/presunky"."<br />";
echo "../sklad/sklad_kontrol.php&nbsp;&nbsp;&nbsp;&nbsp; 400001&nbsp;&nbsp;&nbsp;&nbsp; Skladov� kontroly"."<br />";
echo "../sklad/zmenapriemer_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 400002&nbsp;&nbsp;&nbsp;&nbsp; Kontrola priemern� / n�kupn� ceny"."<br />";
echo "../sklad/meszos.php&nbsp;&nbsp;&nbsp;&nbsp; 402100&nbsp;&nbsp;&nbsp;&nbsp; Mesa�n� skladov� zostavy"."<br />";
echo "../sklad/preuct.php&nbsp;&nbsp;&nbsp;&nbsp; 402200&nbsp;&nbsp;&nbsp;&nbsp; Prevod do ��tovn�ctva, Kontrola za��tovania dokladov"."<br />";
echo "../sklad/pohskl_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402101&nbsp;&nbsp;&nbsp;&nbsp; Zostavy 'Pohyb materi�lu v skladoch-mesa�n�' a 'za druh-mesa�n�' v PDF"."<br />";
echo "../sklad/pohyby_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402102&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Druhy pohybov v skladoch - mesa�n�' v PDF"."<br />";
echo "../sklad/sklzas_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402103&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav z�sob-mesa�n�/okam�it� stav' v PDF"."<br />";
echo "../sklad/zprijmu_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402104&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Zostava pr�jmu-mesa�n�' v PDF"."<br />";
echo "../sklad/zvydaja_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402105&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Zostava v�daja-mesa�n�' v PDF"."<br />";
echo "../sklad/zpresun.php&nbsp;&nbsp;&nbsp;&nbsp; 402106&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Zostava presunu-mesa�n�' v PDF"."<br />";
echo "../sklad/regleta_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402107&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Regleta z�sob-mesa�n�' v PDF"."<br />";
echo "../sklad/regletadru_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402108&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav z�sob pod�a materi�lov�ch druhov-mesa�n�' v PDF"."<br />";
echo "../sklad/sklkar.php&nbsp;&nbsp;&nbsp;&nbsp; 403100&nbsp;&nbsp;&nbsp;&nbsp; Skladov� karty"."<br />";
echo "../sklad/info_zas.php&nbsp;&nbsp;&nbsp;&nbsp; 403200&nbsp;&nbsp;&nbsp;&nbsp; Zoznam zost�v inform�cie o z�sob�ch"."<br />";
echo "../sklad/sklinv_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403300&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Invent�rna zostava' v PDF"."<br />";
echo "../sklad/sklkarta_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403101&nbsp;&nbsp;&nbsp;&nbsp; Zostava skladov�ch kariet v PDF"."<br />";
echo "../sklad/info_nakup.php&nbsp;&nbsp;&nbsp;&nbsp; 403201&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Inform�cie o n�kupe z�sob' v PDF"."<br />";
echo "../sklad/info_spotzak.php&nbsp;&nbsp;&nbsp;&nbsp; 403202&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Pr�jem/V�daj na vybran� z�kazku/Zostatok materi�lu na z�kazke a za vybran� obdobie' v PDF"."<br />";
echo "../sklad/pohskl_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403203&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Pohyb materi�lu v skladoch/za druh - okam�it� stav' v PDF"."<br />";
echo "../sklad/info_pohdok.php&nbsp;&nbsp;&nbsp;&nbsp; 403204&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Doklady za vybran� skladov� pohyb' v PDF"."<br />";
echo "../sklad/sklzaskat_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403205&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav z�sob - okam�it� stav pod�a kateg�ri�' v PDF"."<br />";
echo "../sklad/sklzaskom_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403206&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav komision�lnych z�sob - okam�it� stav' v PDF"."<br />";
echo "../sklad/sklzascpa_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403207&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav z�sob - okam�it� stav pod�a k�dov CPA' v PDF"."<br />";
echo "../sklad/sklzasnula_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403208&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Skladov� polo�ky s nul.mno�stvom a 0-vou hodnotou �i z�pornou priemer. cenou' v PDF"."<br />";
echo "../sklad/alkohol_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403209&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Okam�it� stav z�sob alkoholu - pod�a EAN k�dov' v PDF"."<br />";
echo "../sklad/sklzasmin_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403210&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Vyhodnotenie minim�lneho stavu z�sob' v PDF"."<br />";
echo "../sklad/regletakom_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403211&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Vyhodnotenie stavu a predaja komision�lnych z�sob' v PDF"."<br />";
echo "../sklad/cskl.php&nbsp;&nbsp;&nbsp;&nbsp; 404100&nbsp;&nbsp;&nbsp;&nbsp; ��seln�k skladov materi�lu a tovaru"."<br />";
echo "../sklad/ccis.php&nbsp;&nbsp;&nbsp;&nbsp; 404200&nbsp;&nbsp;&nbsp;&nbsp; ��seln�k materi�lov�ch a tovarov�ch polo�iek"."<br />";
echo "../sklad/csph.php&nbsp;&nbsp;&nbsp;&nbsp; 404300&nbsp;&nbsp;&nbsp;&nbsp; ��seln�k skladov�ch pohybov materi�lu a tovaru"."<br />";
echo "../sklad/cpoc.php&nbsp;&nbsp;&nbsp;&nbsp; 404400&nbsp;&nbsp;&nbsp;&nbsp; Po�iato�n� stav skladov"."<br />";
echo "../sklad/zmaznulcis.php&nbsp;&nbsp;&nbsp;&nbsp; 404500&nbsp;&nbsp;&nbsp;&nbsp; Vymazanie nulov�ch materi�lov�ch polo�iek"."<br />";
echo "../sklad/sklzas.php&nbsp;&nbsp;&nbsp;&nbsp; 404600&nbsp;&nbsp;&nbsp;&nbsp; Rekon�trukcia stavu z�sob"."<br />";
?>