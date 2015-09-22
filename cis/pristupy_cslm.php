<?php
echo "V sripte pred testovanim pristupov uziv.php dam cslm=xyz, musi byt jednoznacne."."<br />"; 
echo "cslm 100000=ucto,200000=mzdy,300000=fakt,400000=sklad,500000=him"."<br />";
echo "Vsetci maju pristup ( ak splnaju all,uct,mzd... nastavene pristupy ) len vymenovane UZID nemaju pristup do skriptu s nastavenym cslm"."<br />";
echo "Ak ma UZID=38 uct_prava = 10000 a je v menp zadane uzid=38 a cslm=100020 tak ho nepusti do Vytvorenie mesacnych uctovnych zostav"."<br />";
echo "Ak ma UZID=38 uct_prava = 100 a nie je v menp zadane uzid=38 a cslm=100020 tak ho nepusti do Vytvorenie mesacnych uctovnych zostav lebo vyzaduju urov=1000"."<br />";

echo " "."<br />";
echo "vsade		 	cslm=999999	TOTAL BLOKOVANIE VSETKEHO - ready for ANDROIDkey"."<br />";
echo "    		 	cslm=999997	Ëas keÔ bolo zablokovanÈ cez cslm=999999"."<br />";
echo "    		 	cslm=999998	Ëas keÔ bolo odblokovanÈ cez cslm=999999"."<br />";
echo " "."<br />";

echo "UCTO ( pr·va pre ALL treba nastaviù na 1000 ak chce len prezeraù aby sa nedostal do ËÌselnÌkov a pr·va pre UCT treba nastaviù na 3000 na prezeranie )"."<br />";
echo "../ucto/meszos.php 	cslm=100020	Vytvorenie mesacnych uctovnych zostav"."<br />";
echo "../ucto/danprij.php 	cslm=100040	Priznanie k dani z prijmov"."<br />";
echo "../ucto/vspk_u.php 	cslm=100080	Uprava, mazanie POKLADNICA, BANKA, VSEOB"."<br />";
echo " "."<br />";

echo "../faktury/dodb.php 	cslm=101801	Druhy odberatelskych faktur"."<br />";
echo "../faktury/ddod.php 	cslm=101802	Druhy dodavatelskych faktur"."<br />";
echo "../ucto/dpok.php 		cslm=101803	Druhy pokladnic"."<br />";
echo "../ucto/dban.php 		cslm=101804	Druhy bankovych uctov"."<br />";
echo "../ucto/drudan.php 	cslm=101805	Druhy DPH"."<br />";
echo "../ucto/uctpoh.php 	cslm=101806	Pohyby asistenta ˙Ëtovania"."<br />";
echo " "."<br />";

echo "../ucto/prizdph2013.php 	cslm=100420	Priznanie DPH"."<br />";
echo "../ucto/archivdph2013.php cslm=100440	Archiv DPH"."<br />";
echo "../ucto/oprsys.php 	cslm=100620	Oprava dat z podsystemov"."<br />";
echo "../ucto/uctosnova.php 	cslm=100720	Uctova osnova"."<br />";
echo " "."<br />";

echo "../cis/ufir.php 		cslm=101901	Udaje o firme a parametre vsetkych programov ucto,mzdy.him,sklad,fakt..."."<br />";
echo " "."<br />";


echo "FAKT⁄RY ( pr·va pre FAK treba nastaviù na 1100 ak chce len prezeraù )"."<br />";
echo "../faktury/vstf_u.php 	cslm=301881	Uprava, mazanie faktur odberatelskych"."<br />";
echo "../faktury/vstf_u.php 	cslm=301882	Uprava, mazanie faktur dodavatelskych"."<br />";
echo "../faktury/vstf_u.php 	cslm=301880	Uprava, mazanie faktur ine ako odberatelske alebo dodavatelske = dodacie listy, predfaktury..."."<br />";
echo "../faktury/vstf_t.php 	cslm=301890	Rozuctovanie tlac html faktur"."<br />";
echo " "."<br />";

echo "MAJETOK ( pr·va pre MAJ treba nastaviù na 1100 ak chce len prezeraù )"."<br />";
echo "../majetok/vstmaj.php 	cslm=500101	Zoznam a pohyby dlhodobÈho a drobnÈho majetku"."<br />";
echo "../majetok/mesodp.php 	cslm=500501	Spracovanie mesaËnÈho odpisu"."<br />";
echo "../majetok/zrsmes.php 	cslm=500502	Zruöenie spracovania mesaËnÈho odpisu"."<br />";
echo "../majetok/majuct.php 	cslm=500503	Prevod do ˙ËtovnÌctva"."<br />";
?>