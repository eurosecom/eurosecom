<?php
echo "V sripte pred testovanim pristupov uziv.php dam cslm=xyz, musi byt jednoznacne."."<br />"; 
echo "cslm 100000=ucto,200000=mzdy,300000=fakt,400000=sklad,500000=him"."<br />";
echo "Vsetci maju pristup ( ak splnaju all,uct,mzd... nastavene pristupy ) len vymenovane UZID nemaju pristup do skriptu s nastavenym cslm"."<br />";
echo "Ak ma UZID=38 uct_prava = 10000 a je v menp zadane uzid=38 a cslm=100020 tak ho nepusti do Vytvorenie mesacnych uctovnych zostav"."<br />";
echo "Ak ma UZID=38 uct_prava = 100 a nie je v menp zadane uzid=38 a cslm=100020 tak ho nepusti do Vytvorenie mesacnych uctovnych zostav lebo vyzaduju urov=1000"."<br />";

echo " "."<br />";
echo "vsade		 	cslm=999999	TOTAL BLOKOVANIE VSETKEHO - ready for ANDROIDkey"."<br />";
echo "    		 	cslm=999997	èas keï bolo zablokované cez cslm=999999"."<br />";
echo "    		 	cslm=999998	èas keï bolo odblokované cez cslm=999999"."<br />";
echo " "."<br />";

echo "UCTO ( práva pre ALL treba nastavi na 1000 ak chce len prezera aby sa nedostal do èíselníkov a práva pre UCT treba nastavi na 3000 na prezeranie )"."<br />";

echo "../ucto/vstpok.php 	cslm=101300	Zoznam pokladniènıch, bankovıch a všeobecnıch dokladov"."<br />";
echo "../ucto/meszos.php 	cslm=100020	Vytvorenie mesacnych uctovnych zostav, Úètovnı denník, VZaS, Súvaha"."<br />";
echo "../ucto/udennik.php 	cslm=100020	 "."<br />";
echo "../ucto/suvaha_pod2014.php cslm=100020	 "."<br />";
echo "../ucto/vykzis_pod2014.php cslm=100020	 "."<br />";
echo "../ucto/statzos.php 	cslm=102200	Štatistika a vıkazníctvo"."<br />";
echo "../ucto/danprij.php 	cslm=100040	Priznanie k dani z prijmov"."<br />";
echo "../ucto/vspk_u.php 	cslm=100080	Uprava, mazanie POKLADNICA, BANKA, VSEOB"."<br />";
echo " "."<br />";

echo "../ucto/uctpohyby.php 	cslm=103200	Vıpis úètovnıch pohybov"."<br />";
echo "../ucto/hladajdok.php 	cslm=103300	Preh¾adávanie dokladov"."<br />";
echo "../ucto/cudzie.php 	cslm=103400	Cudzie meny"."<br />";
echo "../ucto/vstpru.php 	cslm=103500	Príkazy na úhradu"."<br />";
echo "../ucto/prhdok.php 	cslm=103600	Zoznamy dokladov"."<br />";
echo " "."<br />";

echo "../faktury/dodb.php 	cslm=101801	Druhy odberatelskych faktur"."<br />";
echo "../faktury/ddod.php 	cslm=101802	Druhy dodavatelskych faktur"."<br />";
echo "../ucto/dpok.php 		cslm=101803	Druhy pokladnic"."<br />";
echo "../ucto/dban.php 		cslm=101804	Druhy bankovych uctov"."<br />";
echo "../ucto/drudan.php 	cslm=101805	Druhy DPH"."<br />";
echo "../ucto/uctpoh.php 	cslm=101806	Pohyby asistenta úètovania"."<br />";
echo " "."<br />";

echo "../ucto/prizdph2013.php 	cslm=100420	Priznanie DPH"."<br />";
echo "../ucto/archivdph2013.php cslm=100440	Archiv DPH"."<br />";
echo "../ucto/oprsys.php 	cslm=100620	Oprava dat z podsystemov"."<br />";
echo "../ucto/uctosnova.php 	cslm=100720	Uctova osnova"."<br />";
echo " "."<br />";

echo "../cis/ufir.php 		cslm=101901	Udaje o firme a parametre vsetkych programov ucto,mzdy.him,sklad,fakt..."."<br />";
echo "../cis/cico.php 		cslm=101902	Èíselník IÈO"."<br />";
echo "../cis/cstr.php 		cslm=101903	Èíselník stredísk"."<br />";
echo "../cis/czak.php 		cslm=101904	Èíselník zákaziek"."<br />";
echo " "."<br />";


echo "FAKTÚRY ( práva pre FAK treba nastavi na 1100 ak chce len prezera )"."<br />";
echo "../faktury/vstf_u.php 	cslm=301881	Uprava, mazanie faktur odberatelskych"."<br />";
echo "../faktury/vstf_u.php 	cslm=301882	Uprava, mazanie faktur dodavatelskych"."<br />";
echo "../faktury/vstf_u.php 	cslm=301880	Uprava, mazanie faktur ine ako odberatelske alebo dodavatelske = dodacie listy, predfaktury..."."<br />";
echo "../faktury/vstf_t.php 	cslm=301890	Rozuctovanie tlac html faktur"."<br />";
echo " "."<br />";

echo "MAJETOK ( práva pre MAJ treba nastavi na 1100 ak chce len prezera )"."<br />";
echo "../majetok/vstmaj.php 	cslm=500101	Zoznam a pohyby dlhodobého a drobného majetku"."<br />";
echo "../majetok/mesodp.php 	cslm=500501	Spracovanie mesaèného odpisu"."<br />";
echo "../majetok/zrsmes.php 	cslm=500502	Zrušenie spracovania mesaèného odpisu"."<br />";
echo "../majetok/majuct.php 	cslm=500503	Prevod do úètovníctva"."<br />";
echo " "."<br />";

echo "SKLAD"."<br />";
echo "../sklad/vstpoh.php&nbsp;&nbsp;&nbsp;&nbsp; 401100&nbsp;&nbsp;&nbsp;&nbsp; Zoznam príjemok/vıdajok/presuniek"."<br />";
echo "../sklad/sposta.php&nbsp;&nbsp;&nbsp;&nbsp; 401200&nbsp;&nbsp;&nbsp;&nbsp; Spotreba staveništnıch skladov"."<br />";
echo "../sklad/vstp_u.php&nbsp;&nbsp;&nbsp;&nbsp; 401111&nbsp;&nbsp;&nbsp;&nbsp; Príjemka - Nová, Úprava, Vymazanie"."<br />";
echo "../sklad/vstp_u.php&nbsp;&nbsp;&nbsp;&nbsp; 401112&nbsp;&nbsp;&nbsp;&nbsp; Vıdajka - Nová, Úprava, Vymazanie"."<br />";
echo "../sklad/vstp_u.php&nbsp;&nbsp;&nbsp;&nbsp; 401113&nbsp;&nbsp;&nbsp;&nbsp; Presunka - Nová, Úprava, Vymazanie"."<br />";
echo "../sklad/poldok.php&nbsp;&nbsp;&nbsp;&nbsp; 401102&nbsp;&nbsp;&nbsp;&nbsp; Tlaè pdf príjemky/vıdajky/presunky + tlaè zoznamov"."<br />";
echo "../sklad/vstp_s.php&nbsp;&nbsp;&nbsp;&nbsp; 401103&nbsp;&nbsp;&nbsp;&nbsp; Naèítaj originál do príjemky/vıdajky/presunky"."<br />";
echo "../sklad/sklad_kontrol.php&nbsp;&nbsp;&nbsp;&nbsp; 400001&nbsp;&nbsp;&nbsp;&nbsp; Skladové kontroly"."<br />";
echo "../sklad/zmenapriemer_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 400002&nbsp;&nbsp;&nbsp;&nbsp; Kontrola priemerné / nákupné ceny"."<br />";
echo "../sklad/meszos.php&nbsp;&nbsp;&nbsp;&nbsp; 402100&nbsp;&nbsp;&nbsp;&nbsp; Mesaèné skladové zostavy"."<br />";
echo "../sklad/preuct.php&nbsp;&nbsp;&nbsp;&nbsp; 402200&nbsp;&nbsp;&nbsp;&nbsp; Prevod do úètovníctva, Kontrola zaúètovania dokladov"."<br />";
echo "../sklad/pohskl_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402101&nbsp;&nbsp;&nbsp;&nbsp; Zostavy 'Pohyb materiálu v skladoch-mesaènı' a 'za druh-mesaènı' v PDF"."<br />";
echo "../sklad/pohyby_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402102&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Druhy pohybov v skladoch - mesaèné' v PDF"."<br />";
echo "../sklad/sklzas_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402103&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav zásob-mesaènı/okamitı stav' v PDF"."<br />";
echo "../sklad/zprijmu_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402104&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Zostava príjmu-mesaèná' v PDF"."<br />";
echo "../sklad/zvydaja_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402105&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Zostava vıdaja-mesaèná' v PDF"."<br />";
echo "../sklad/zpresun.php&nbsp;&nbsp;&nbsp;&nbsp; 402106&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Zostava presunu-mesaèná' v PDF"."<br />";
echo "../sklad/regleta_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402107&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Regleta zásob-mesaèná' v PDF"."<br />";
echo "../sklad/regletadru_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 402108&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav zásob pod¾a materiálovıch druhov-mesaèná' v PDF"."<br />";
echo "../sklad/sklkar.php&nbsp;&nbsp;&nbsp;&nbsp; 403100&nbsp;&nbsp;&nbsp;&nbsp; Skladové karty"."<br />";
echo "../sklad/info_zas.php&nbsp;&nbsp;&nbsp;&nbsp; 403200&nbsp;&nbsp;&nbsp;&nbsp; Zoznam zostáv informácie o zásobách"."<br />";
echo "../sklad/sklinv_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403300&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Inventúrna zostava' v PDF"."<br />";
echo "../sklad/sklkarta_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403101&nbsp;&nbsp;&nbsp;&nbsp; Zostava skladovıch kariet v PDF"."<br />";
echo "../sklad/info_nakup.php&nbsp;&nbsp;&nbsp;&nbsp; 403201&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Informácie o nákupe zásob' v PDF"."<br />";
echo "../sklad/info_spotzak.php&nbsp;&nbsp;&nbsp;&nbsp; 403202&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Príjem/Vıdaj na vybranú zákazku/Zostatok materiálu na zákazke a za vybrané obdobie' v PDF"."<br />";
echo "../sklad/pohskl_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403203&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Pohyb materiálu v skladoch/za druh - okamitı stav' v PDF"."<br />";
echo "../sklad/info_pohdok.php&nbsp;&nbsp;&nbsp;&nbsp; 403204&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Doklady za vybranı skladovı pohyb' v PDF"."<br />";
echo "../sklad/sklzaskat_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403205&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav zásob - okamitı stav pod¾a kategórií' v PDF"."<br />";
echo "../sklad/sklzaskom_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403206&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav komisionálnych zásob - okamitı stav' v PDF"."<br />";
echo "../sklad/sklzascpa_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403207&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Stav zásob - okamitı stav pod¾a kódov CPA' v PDF"."<br />";
echo "../sklad/sklzasnula_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403208&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Skladové poloky s nul.mnostvom a 0-vou hodnotou èi zápornou priemer. cenou' v PDF"."<br />";
echo "../sklad/alkohol_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403209&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Okamitı stav zásob alkoholu - pod¾a EAN kódov' v PDF"."<br />";
echo "../sklad/sklzasmin_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403210&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Vyhodnotenie minimálneho stavu zásob' v PDF"."<br />";
echo "../sklad/regletakom_pdf.php&nbsp;&nbsp;&nbsp;&nbsp; 403211&nbsp;&nbsp;&nbsp;&nbsp; Zostava 'Vyhodnotenie stavu a predaja komisionálnych zásob' v PDF"."<br />";
echo "../sklad/cskl.php&nbsp;&nbsp;&nbsp;&nbsp; 404100&nbsp;&nbsp;&nbsp;&nbsp; Èíselník skladov materiálu a tovaru"."<br />";
echo "../sklad/ccis.php&nbsp;&nbsp;&nbsp;&nbsp; 404200&nbsp;&nbsp;&nbsp;&nbsp; Èíselník materiálovıch a tovarovıch poloiek"."<br />";
echo "../sklad/csph.php&nbsp;&nbsp;&nbsp;&nbsp; 404300&nbsp;&nbsp;&nbsp;&nbsp; Èíselník skladovıch pohybov materiálu a tovaru"."<br />";
echo "../sklad/cpoc.php&nbsp;&nbsp;&nbsp;&nbsp; 404400&nbsp;&nbsp;&nbsp;&nbsp; Poèiatoènı stav skladov"."<br />";
echo "../sklad/zmaznulcis.php&nbsp;&nbsp;&nbsp;&nbsp; 404500&nbsp;&nbsp;&nbsp;&nbsp; Vymazanie nulovıch materiálovıch poloiek"."<br />";
echo "../sklad/sklzas.php&nbsp;&nbsp;&nbsp;&nbsp; 404600&nbsp;&nbsp;&nbsp;&nbsp; Rekonštrukcia stavu zásob"."<br />";
?>