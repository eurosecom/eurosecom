<HTML>
<?php
//XML pre FOA 2014
do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$zdrd = $_REQUEST['zdrd'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];
$h_arch = $_REQUEST['h_arch'];

$chyby = 1*$_REQUEST['chyby'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("DaÚovÈ priznanie XML bude pripravenÈ v priebehu janu·ra 2014. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");

//druh priznania 1=mesacne,2=stvrtrocne,4=rocne
$fir_uctx01 = $_REQUEST['fir_uctx01'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$cislo_oc = $_REQUEST['cislo_oc'];
$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="PRIZNANIEFOA_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>FOA xml | EuroSecom</title>
<style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
</style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
</script>
</HEAD>
<BODY class="white">
<table class="h2" width="100%" >
 <tr>
  <td>EuroSecom  -  Priznanie FOA export do XML rok <?php echo $kli_vrok; ?></td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
 </tr>
</table>

<?php
//XML SUBOR elsubor=2
if ( $copern == 10 AND $elsubor == 2  )
     {
//prva strana
if ( File_Exists("../tmp/$nazsub") ) { $soubor = unlink("../tmp/$nazsub"); }
$soubor = fopen("../tmp/$nazsub", "a+");

//rok2014
$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<rodneCislo>1234567890</rodneCislo>
		<datumNarodenia>05.08.1966</datumNarodenia>
		<typDP>
			<rdp>1</rdp>
			<odp>0</odp>
			<ddp>0</ddp>
		</typDP>
		<zdanovacieObdobie>
			<rok>2014</rok>
			<datumDDP>16.04.2014</datumDDP>
		</zdanovacieObdobie>
		<priezvisko>äùstn˝</priezvisko>
		<meno>Miroslav</meno>
		<titul>Ing.</titul>
		<titulZa>PhDr.</titulZa>
		<adresaTrvPobytu>
			<ulica>Ulica TP</ulica>
			<cislo>07</cislo>
			<psc>08111</psc>
			<obec>Obec TP</obec>
			<stat>ät·t TP</stat>
		</adresaTrvPobytu>
		<nerezident>0</nerezident>
		<adresaObvPobytu>
			<ulica>Ulica OP</ulica>
			<cislo>13</cislo>
			<psc>14111</psc>
			<obec>Obec OP</obec>
		</adresaObvPobytu>
		<zastupca>
			<priezvisko>Priezvisko ZZ</priezvisko>
			<meno>Meno ZZ</meno>
			<titul>titul ZZ</titul>
			<titulZa>titul Za</titulZa>
			<rodneCislo>1111112222</rodneCislo>
			<ulica>Ulica ZZ</ulica>
			<cislo>12</cislo>
			<psc>22222</psc>
			<obec>Obec ZZ</obec>
			<stat>Stat ZZ</stat>
			<tel>055/22445566</tel>
			<email>email@mail.sk</email>
		</zastupca>
	</hlavicka>
	<telo>
		<r27>0</r27>
		<r28>28</r28>
		<r29>
			<priezviskoMeno>Priezvisko a meno manzelky</priezviskoMeno>
			<rodneCislo>0000000000</rodneCislo>
			<vlastnePrijmy>290.29</vlastnePrijmy>
			<pocetMesiacov>12</pocetMesiacov>
		</r29>
		<r30>
			<!-- minimalny pocet elementov dieta je 4, maximalny pocet je 20 -->
			<dieta>
				<priezviskoMeno>Priezvisko a meno dietata 1</priezviskoMeno>
				<rodneCislo>1111111111</rodneCislo>
				<m00>1</m00>
				<m01>0</m01>
				<m02>0</m02>
				<m03>0</m03>
				<m04>0</m04>
				<m05>0</m05>
				<m06>0</m06>
				<m07>0</m07>
				<m08>0</m08>
				<m09>0</m09>
				<m10>0</m10>
				<m11>0</m11>
				<m12>0</m12>
			</dieta>
			<dieta>
				<priezviskoMeno>Priezvisko a meno dietata 2</priezviskoMeno>
				<rodneCislo>2222222222</rodneCislo>
				<m00>0</m00>
				<m01>1</m01>
				<m02>1</m02>
				<m03>1</m03>
				<m04>0</m04>
				<m05>0</m05>
				<m06>0</m06>
				<m07>0</m07>
				<m08>0</m08>
				<m09>0</m09>
				<m10>0</m10>
				<m11>0</m11>
				<m12>0</m12>
			</dieta>
			<dieta>
				<priezviskoMeno>Priezvisko a meno dietata 3</priezviskoMeno>
				<rodneCislo>3333333333</rodneCislo>
				<m00>0</m00>
				<m01>0</m01>
				<m02>0</m02>
				<m03>0</m03>
				<m04>0</m04>
				<m05>0</m05>
				<m06>0</m06>
				<m07>0</m07>
				<m08>0</m08>
				<m09>0</m09>
				<m10>0</m10>
				<m11>0</m11>
				<m12>1</m12>
			</dieta>
			<dieta>
				<priezviskoMeno>Priezvisko a meno dietata 4</priezviskoMeno>
				<rodneCislo>4444444444</rodneCislo>
				<m00>0</m00>
				<m01>0</m01>
				<m02>0</m02>
				<m03>0</m03>
				<m04>0</m04>
				<m05>0</m05>
				<m06>0</m06>
				<m07>0</m07>
				<m08>0</m08>
				<m09>0</m09>
				<m10>0</m10>
				<m11>0</m11>
				<m12>1</m12>
			</dieta>
		</r30>
		<r31viacAko4>0</r31viacAko4>
		<r32>32.31</r32>
		<r32a>32.32</r32a>
		<r33>33.33</r33>
		<r33a>33.01</r33a>
		<r33b>33.02</r33b>
		<r34>34.34</r34>
		<r35>35.35</r35>
		<r36>36.36</r36>
		<r37>37.37</r37>
		<r38>38.38</r38>
		<r39>39.39</r39>
		<r40>40.40</r40>
		<r41>41.41</r41>
		<r42>42.42</r42>
		<r43>43.43</r43>
		<r44>44.44</r44>
		<r45>45</r45>
		<r46>46.46</r46>
		<r47>47.47</r47>
		<r48>48.48</r48>
		<r49>49.49</r49>
		<r50>50.50</r50>
		<r51>51.51</r51>
		<r52>52.52</r52>
		<r53>53.53</r53>
		<r54>54.54</r54>
		<r55>55.55</r55>
		<r56>56.56</r56>
		<r57>57.57</r57>
		<r58>58.58</r58>
		<r59>59.59</r59>
		<r60>60.60</r60>
		<r61>61.61</r61>
		<r62>62.62</r62>
		<r63>63.63</r63>
		<r64>64.64</r64>
		<r65>65.65</r65>
		<r66>66.66</r66>
		<r67>67.67</r67>
		<r68>68.68</r68>
		<r69>69.69</r69>
		<r70>70.70</r70>
		<r71>71.71</r71>
		<r72>72.72</r72>
		<r73>73.73</r73>
		<r74>74.74</r74>
		<paragraf50>1</paragraf50>
		<splnam3per>1</splnam3per>
		<r75>75.75</r75>
		<r76>
			<ico>12345678</ico>
			<sid>1234</sid>
			<pravnaForma>prijimatel spol. s rucanim obmedzenym</pravnaForma>
			<obchMeno>
				<riadok>prijimatel ObchodnÈ meno</riadok>
				<riadok>prijÌmateæa 2% dane</riadok>
			</obchMeno>
			<ulica>Ulica PrijÌmateæa</ulica>
			<cislo>99</cislo>
			<psc>77777</psc>
			<obec>Obec PrijÌmateæa</obec>
		</r76>
		<osobitneZaznamy>
			<uvadza>1</uvadza>
			<udajeOprijmoch>
				<kodStatu>105</kodStatu>
				<prijmy>7501.01</prijmy>
				<vydavky>7502.02</vydavky>
			</udajeOprijmoch>
			<udajeOprijmoch>
				<kodStatu>705</kodStatu>
				<prijmy>7503.03</prijmy>
				<vydavky>7504.04</vydavky>
			</udajeOprijmoch>
			<udajeOprijmoch>
				<kodStatu>308</kodStatu>
				<prijmy>7505.05</prijmy>
				<vydavky>7506.06</vydavky>
			</udajeOprijmoch>
			<zaznamy/>
		</osobitneZaznamy>
		<r77>ät·t daÚovej rezidencie</r77>
		<r78>78.78</r78>
		<r79>79</r79>
		<datumVyhlasenia>24.02.2014</datumVyhlasenia>
		<danovyPreplatokBonus>
			<vyplatitDanovyBonus>1</vyplatitDanovyBonus>
			<vyplatitZamPremiu>1</vyplatitZamPremiu>
			<vratitDanPreplatok>1</vratitDanPreplatok>
			<sposobPlatby>
				<poukazka>1</poukazka>
				<ucet>1</ucet>
			</sposobPlatby>
			<bankovyUcet>
				<IBAN>SK111111111111111111</IBAN>
				<predcislieUctu>123456</predcislieUctu>
				<cisloUctu>1234567890</cisloUctu>
				<kodBanky>1100</kodBanky>
			</bankovyUcet>
			<datum>24.02.2014</datum>
		</danovyPreplatokBonus>
		<pomocneVypocty/>
	</telo>
</dokument>
);
mzdprc;

//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_foa WHERE oc = $cislo_oc ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$obdobie=$kli_vmes;
$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if ( $j == 0 )
     {
  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n"; fwrite($soubor, $text);
  $text = "<dokument>"."\r\n"; fwrite($soubor, $text);		

  $text = " <hlavicka>"."\r\n"; fwrite($soubor, $text);

$rodneCislo=$hlavicka->rdc.$hlavicka->rdk;
  $text = "  <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);

$datumNarodenia=SkDatum($hlavicka->dar);
  if ( $hlavicka->nrz == 0 ) $datumNarodenia="";
  if ( $datumNarodenia == '00.00.0000' ) $datumNarodenia="";
  $text = "  <datumNarodenia><![CDATA[".$datumNarodenia."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$rdp="1"; $odp="0"; $ddp="0";
if ( $hlavicka->druh == 2 ) { $rdp="0"; $odp="1"; $ddp="0"; }
if ( $hlavicka->druh == 3 ) { $rdp="0"; $odp="0"; $ddp="1"; }
  $text = "   <rdp><![CDATA[".$rdp."]]></rdp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <odp><![CDATA[".$odp."]]></odp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <ddp><![CDATA[".$ddp."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n";   fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=$kli_vrok;
  $text = "   <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$datumDDP="";
if ( $ddp == 1 ) $datumDDP=SkDatum($hlavicka->ddp);
if ( $datumDDP == '00.00.0000' ) $datumDDP="";
  $text = "   <datumDDP><![CDATA[".$datumDDP."]]></datumDDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->dprie);
  $text = "  <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);

$meno=iconv("CP1250", "UTF-8", $hlavicka->dmeno);
  $text = "  <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);

$titul=iconv("CP1250", "UTF-8", $hlavicka->dtitl);
  $text = "  <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);

$titul=iconv("CP1250", "UTF-8", $hlavicka->dtitz);
  $text = "  <titulZa><![CDATA[".$titul."]]></titulZa>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaTrvPobytu>"."\r\n";   fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->duli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->dcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->dpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->dmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);

$stat=iconv("CP1250", "UTF-8", $hlavicka->xstat);
if ( $stat == '' ) $stat="SR";
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);

$nerezident=$hlavicka->nrz;
  $text = "  <nerezident><![CDATA[".$nerezident."]]></nerezident>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->d2uli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->d2cdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->d2psc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->d2mes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaObvPobytu>"."\r\n";   fwrite($soubor, $text);

  $text = "  <zastupca>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->zprie);
  $text = "   <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $hlavicka->zmeno);
  $text = "   <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $hlavicka->ztitl);
  $text = "   <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $hlavicka->ztitz);
  $text = "   <titulZa><![CDATA[".$titul."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->zrdc.$hlavicka->zrdk;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->zuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=iconv("CP1250", "UTF-8", $hlavicka->zcdm);
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->zpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->zmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $hlavicka->zstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$telefon=$hlavicka->dtel;
  $text = "   <tel><![CDATA[".$telefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$mailfax=iconv("CP1250", "UTF-8", $hlavicka->dmailfax);
  $text = "   <email><![CDATA[".$mailfax."]]></email>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zastupca>"."\r\n"; fwrite($soubor, $text);
  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);

  $text = " <telo>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r27;
  $text = "  <r27><![CDATA[".$riadok."]]></r27>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r28;
if ( $hlavicka->r28 == 0 ) $riadok="";
  $text = "  <r28><![CDATA[".$riadok."]]></r28>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r29>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->mprie);
  $text = "   <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->mrod;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$vlastnePrijmy=$hlavicka->mpri;
if ( $hlavicka->mpri == 0 ) $vlastnePrijmy="";
  $text = "   <vlastnePrijmy><![CDATA[".$vlastnePrijmy."]]></vlastnePrijmy>"."\r\n"; fwrite($soubor, $text);
$pocetMesiacov=$hlavicka->mpom;
if ( $hlavicka->mpom == 0 ) $pocetMesiacov="";
  $text = "   <pocetMesiacov><![CDATA[".$pocetMesiacov."]]></pocetMesiacov>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r29>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r30>"."\r\n"; fwrite($soubor, $text);
  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d1prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d1rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00="$hlavicka->d1pomc";
if ( $hlavicka->d1pomc == 0 ) $m00="";
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d1pom1;
if ( $hlavicka->d1pom1 == 0 ) $m01="";
if ( $hlavicka->d1pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d1pom2;
if ( $hlavicka->d1pom2 == 0 ) $m02="";
if ( $hlavicka->d1pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d1pom3;
if ( $hlavicka->d1pom3 == 0 ) $m03="";
if ( $hlavicka->d1pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d1pom4;
if ( $hlavicka->d1pom4 == 0 ) $m04="";
if ( $hlavicka->d1pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d1pom5;
if ( $hlavicka->d1pom4 == 0 ) $m05="";
if ( $hlavicka->d1pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d1pom6;
if ( $hlavicka->d1pom6 == 0 ) $m06="";
if ( $hlavicka->d1pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d1pom7;
if ( $hlavicka->d1pom7 == 0 ) $m07="";
if ( $hlavicka->d1pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d1pom8;
if ( $hlavicka->d1pom8 == 0 ) $m08="";
if ( $hlavicka->d1pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d1pom9;
if ( $hlavicka->d1pom9 == 0 ) $m09="";
if ( $hlavicka->d1pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d1pom10;
if ( $hlavicka->d1pom10 == 0 ) $m10="";
if ( $hlavicka->d1pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d1pom11;
if ( $hlavicka->d1pom11 == 0 ) $m11="";
if ( $hlavicka->d1pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d1pom12;
if ( $hlavicka->d1pom12 == 0 ) $m12="";
if ( $hlavicka->d1pomc == 1 ) $m12="";
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d2prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d2rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d2pomc;
if ( $hlavicka->d2pomc == 0 ) $m00="";
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d2pom1;
if ( $hlavicka->d2pom1 == 0 ) $m01="";
if ( $hlavicka->d2pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d2pom2;
if ( $hlavicka->d2pom2 == 0 ) $m02="";
if ( $hlavicka->d2pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d2pom3;
if ( $hlavicka->d2pom3 == 0 ) $m03="";
if ( $hlavicka->d2pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d2pom4;
if ( $hlavicka->d2pom4 == 0 ) $m04="";
if ( $hlavicka->d2pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d2pom5;
if ( $hlavicka->d2pom5 == 0 ) $m05="";
if ( $hlavicka->d2pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d2pom6;
if ( $hlavicka->d2pom6 == 0 ) $m06="";
if ( $hlavicka->d2pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d2pom7;
if ( $hlavicka->d2pom7 == 0 ) $m07="";
if ( $hlavicka->d2pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d2pom8;
if ( $hlavicka->d2pom8 == 0 ) $m08="";
if ( $hlavicka->d2pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d2pom9;
if ( $hlavicka->d2pom9 == 0 ) $m09="";
if ( $hlavicka->d2pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d2pom10;
if ( $hlavicka->d2pom10 == 0 ) $m10="";
if ( $hlavicka->d2pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d2pom11;
if ( $hlavicka->d2pom11 == 0 ) $m11="";
if ( $hlavicka->d2pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d2pom12;
if ( $hlavicka->d2pom12 == 0 ) $m12="";
if ( $hlavicka->d2pomc == 1 ) $m12="";
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d3prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>	"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d3rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>	"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d3pomc;
if ( $hlavicka->d3pomc == 0 ) $m00="";
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d3pom1;
if ( $hlavicka->d3pom1 == 0 ) $m01="";
if ( $hlavicka->d3pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d3pom2;
if ( $hlavicka->d3pom2 == 0 ) $m02="";
if ( $hlavicka->d3pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d3pom3;
if ( $hlavicka->d3pom3 == 0 ) $m03="";
if ( $hlavicka->d3pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d3pom4;
if ( $hlavicka->d3pom4 == 0 ) $m04="";
if ( $hlavicka->d3pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d3pom5;
if ( $hlavicka->d3pom5 == 0 ) $m05="";
if ( $hlavicka->d3pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d3pom6;
if ( $hlavicka->d3pom6 == 0 ) $m06="";
if ( $hlavicka->d3pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d3pom7;
if ( $hlavicka->d3pom7 == 0 ) $m07="";
if ( $hlavicka->d3pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d3pom8;
if ( $hlavicka->d3pom8 == 0 ) $m08="";
if ( $hlavicka->d3pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d3pom9;
if ( $hlavicka->d3pom9 == 0 ) $m09="";
if ( $hlavicka->d3pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d3pom10;
if ( $hlavicka->d3pom10 == 0 ) $m10="";
if ( $hlavicka->d3pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d3pom11;
if ( $hlavicka->d3pom11 == 0 ) $m11="";
if ( $hlavicka->d3pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d3pom12;
if ( $hlavicka->d3pom12 == 0 ) $m12="";
if ( $hlavicka->d3pomc == 1 ) $m12="";
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d4prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d4rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d4pomc;
if ( $hlavicka->d4pomc == 0 ) $m00="";
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d4pom1;
if ( $hlavicka->d4pom1 == 0 ) $m01="";
if ( $hlavicka->d4pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d4pom2;
if ( $hlavicka->d4pom2 == 0 ) $m02="";
if ( $hlavicka->d4pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d4pom3;
if ( $hlavicka->d4pom3 == 0 ) $m03="";
if ( $hlavicka->d4pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d4pom4;
if ( $hlavicka->d4pom4 == 0 ) $m04="";
if ( $hlavicka->d4pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d4pom5;
if ( $hlavicka->d4pom5 == 0 ) $m05="";
if ( $hlavicka->d4pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d4pom6;
if ( $hlavicka->d4pom6 == 0 ) $m06="";
if ( $hlavicka->d4pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d4pom7;
if ( $hlavicka->d4pom7 == 0 ) $m07="";
if ( $hlavicka->d4pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d4pom8;
if ( $hlavicka->d4pom8 == 0 ) $m08="";
if ( $hlavicka->d4pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d4pom9;
if ( $hlavicka->d4pom9 == 0 ) $m09="";
if ( $hlavicka->d4pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d4pom10;
if ( $hlavicka->d4pom10 == 0 ) $m10="";
if ( $hlavicka->d4pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d4pom11;
if ( $hlavicka->d4pom11 == 0 ) $m11="";
if ( $hlavicka->d4pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d4pom12;
if ( $hlavicka->d4pom12 == 0 ) $m12="";
if ( $hlavicka->d4pomc == 1 ) $m12="";
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r30>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->det4;
  $text = "  <r31viacAko4><![CDATA[".$riadok."]]></r31viacAko4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r32;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r32><![CDATA[".$riadok."]]></r32>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r32a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r32a><![CDATA[".$riadok."]]></r32a>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r33><![CDATA[".$riadok."]]></r33>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r33a><![CDATA[".$riadok."]]></r33a>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33b;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r33b><![CDATA[".$riadok."]]></r33b>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r34;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34><![CDATA[".$riadok."]]></r34>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r35;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r35><![CDATA[".$riadok."]]></r35>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r36;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r36><![CDATA[".$riadok."]]></r36>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r37;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r37><![CDATA[".$riadok."]]></r37>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r38;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r38><![CDATA[".$riadok."]]></r38>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r39;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r39><![CDATA[".$riadok."]]></r39>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r40;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r40><![CDATA[".$riadok."]]></r40>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r41;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r41><![CDATA[".$riadok."]]></r41>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r42;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r42><![CDATA[".$riadok."]]></r42>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r43;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r43><![CDATA[".$riadok."]]></r43>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r44;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r44><![CDATA[".$riadok."]]></r44>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r45;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r45><![CDATA[".$riadok."]]></r45>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r46;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r46><![CDATA[".$riadok."]]></r46>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r47;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r47><![CDATA[".$riadok."]]></r47>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r48;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r48><![CDATA[".$riadok."]]></r48>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r49;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r49><![CDATA[".$riadok."]]></r49>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r50;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r50><![CDATA[".$riadok."]]></r50>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r51;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r51><![CDATA[".$riadok."]]></r51>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r52;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r52><![CDATA[".$riadok."]]></r52>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r53;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r53><![CDATA[".$riadok."]]></r53>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r54;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r54><![CDATA[".$riadok."]]></r54>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r55;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r55><![CDATA[".$riadok."]]></r55>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r56;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r56><![CDATA[".$riadok."]]></r56>"."\r\n"; fwrite($soubor, $text);
  
$riadok=$hlavicka->r57;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r57><![CDATA[".$riadok."]]></r57>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r58;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r58><![CDATA[".$riadok."]]></r58>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r59;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r59><![CDATA[".$riadok."]]></r59>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r60;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r60><![CDATA[".$riadok."]]></r60>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r61;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r61><![CDATA[".$riadok."]]></r61>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r62;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r62><![CDATA[".$riadok."]]></r62>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r63;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r63><![CDATA[".$riadok."]]></r63>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r64;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r64><![CDATA[".$riadok."]]></r64>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r65;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r65><![CDATA[".$riadok."]]></r65>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r66;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r66><![CDATA[".$riadok."]]></r66>"."\r\n"; fwrite($soubor, $text);

$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r67;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r67><![CDATA[".$riadok."]]></r67>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r68;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r68><![CDATA[".$riadok."]]></r68>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r69;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r69><![CDATA[".$riadok."]]></r69>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r70;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r70><![CDATA[".$riadok."]]></r70>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r71;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r71><![CDATA[".$riadok."]]></r71>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r72;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r72><![CDATA[".$riadok."]]></r72>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r73;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r73><![CDATA[".$riadok."]]></r73>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r74;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r74><![CDATA[".$riadok."]]></r74>"."\r\n"; fwrite($soubor, $text);

$pgf50=$hlavicka->upl50;
if ( $hlavicka->r75 == 0 ) { $pgf50=1; }
  $text = "  <paragraf50><![CDATA[".$pgf50."]]></paragraf50>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->spln3;
  $text = "  <splnam3per><![CDATA[".$riadok."]]></splnam3per>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r75;
if ( $pgf50 == 1 OR $riadok == 0 OR $hlavicka->druh == 3 ) $riadok="";
  $text = "  <r75><![CDATA[".$riadok."]]></r75>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r76>"."\r\n"; fwrite($soubor, $text);
$pico=$hlavicka->pico;
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $pico="";
if ( $hlavicka->pico < 1000000 AND $hlavicka->pico > 1 ) { $pico="00".$hlavicka->pico; }
  $text = "   <ico><![CDATA[".$pico."]]></ico>"."\r\n"; fwrite($soubor, $text);

$psid=$hlavicka->psid;
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $psid="";
  $text = "   <sid><![CDATA[".$psid."]]></sid>"."\r\n"; fwrite($soubor, $text);

$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->pfor);
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $pravnaForma="";
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  
  $text = "   <obchMeno>"."\r\n";   fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pmen);
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchMeno>"."\r\n";   fwrite($soubor, $text);
  
$ulica=iconv("CP1250", "UTF-8", $hlavicka->puli);
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $ulica="";
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->pcdm;
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $cislo="";
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->ppsc;
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $psc="";
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->pmes);
if ( $pgf50 == 1 OR $hlavicka->druh == 3 ) $obec="";
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r76>"."\r\n"; fwrite($soubor, $text);
  
  $text = "  <osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);
$uvadza=$hlavicka->uoso;
  $text = "   <uvadza><![CDATA[".$uvadza."]]></uvadza>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzks1;
if ( $nerezident == 0 ) $riadok="";
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr1;
if ( $nerezident == 0 OR $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd1;
if ( $nerezident == 0 OR $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzks2;
if ( $nerezident == 0 ) $riadok="";
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr2;
if ( $nerezident == 0 OR $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd2;
if ( $nerezident == 0 OR $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzks3;
if ( $nerezident == 0 ) $riadok="";
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr3;
if ( $nerezident == 0 OR $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd3;
if ( $nerezident == 0 OR $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

$zaznamy=iconv("CP1250", "UTF-8", $hlavicka->osob);
if ( $uvadza == 0 ) $zaznamy="";
  $text = "   <zaznamy><![CDATA[".$zaznamy."]]></zaznamy>"."\r\n"; fwrite($soubor, $text);
  $text = "  </osobitneZaznamy>"."\r\n";   fwrite($soubor, $text);

$riadok=iconv("CP1250", "UTF-8", $hlavicka->sdnr);
if ( $nerezident == 0 ) $riadok="";
  $text = "  <r77><![CDATA[".$riadok."]]></r77>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->udnr;
if ( $nerezident == 0 OR $riadok == 0 ) $riadok="";
  $text = "  <r78><![CDATA[".$riadok."]]></r78>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->pril;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r79><![CDATA[".$riadok."]]></r79>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->dat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "  <datumVyhlasenia><![CDATA[".$datum."]]></datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);
$vypbonus=$hlavicka->zdbo;
  $text = "   <vyplatitDanovyBonus><![CDATA[".$vypbonus."]]></vyplatitDanovyBonus>"."\r\n"; fwrite($soubor, $text);
$vyplatitZamPremiu=$hlavicka->zpre;
  $text = "   <vyplatitZamPremiu><![CDATA[".$vyplatitZamPremiu."]]></vyplatitZamPremiu>"."\r\n"; fwrite($soubor, $text);
$vypprepl=$hlavicka->zprp;
  $text = "   <vratitDanPreplatok><![CDATA[".$vypprepl."]]></vratitDanPreplatok>"."\r\n"; fwrite($soubor, $text);

  $text = "   <sposobPlatby>"."\r\n"; fwrite($soubor, $text);
if ( $hlavicka->zdbo == 0 AND $hlavicka->zpre == 0 AND $hlavicka->zprp == 0 )
{
$hlavicka->ucet="0";
$hlavicka->post="0";
$hlavicka->da2="";
}
$poukazka=$hlavicka->post;
  $text = "    <poukazka><![CDATA[".$poukazka."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ucet=$hlavicka->ucet;
  $text = "    <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);

  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$iban=$hlavicka->diban;
if ( $ucet == 0 ) $iban="";
  $text = "    <IBAN><![CDATA[".$iban."]]></IBAN>"."\r\n"; fwrite($soubor, $text);

$pole = explode("-", $hlavicka->uceb);
$predcislieUctu=$pole[0];
$cisloUctu=$pole[1];
if( $pole[1] == '' ) { $cisloUctu=$pole[0]; $predcislieUctu=""; }

if ( $ucet == 0 ) $predcislieUctu="";
  $text = "    <predcislieUctu><![CDATA[".$predcislieUctu."]]></predcislieUctu>"."\r\n"; fwrite($soubor, $text);

if ( $ucet == 0 ) $cisloUctu="";
  $text = "    <cisloUctu><![CDATA[".$cisloUctu."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
$kodBanky=$hlavicka->numb;
if ( $ucet == 0 ) $kodBanky="";
  $text = "    <kodBanky><![CDATA[".$kodBanky."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);

$datum=SKDatum($hlavicka->da2);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);

$pomocneVypocty=iconv("CP1250", "UTF-8", $hlavicka->pomv);
  $text = "  <pomocneVypocty><![CDATA[".$pomocneVypocty."]]></pomocneVypocty>"."\r\n"; fwrite($soubor, $text);

  $text = " </telo>"."\r\n"; fwrite($soubor, $text);
  $text = "</dokument>"."\r\n"; fwrite($soubor, $text);
     }
//koniec ak j=0
}
$i = $i + 1;
$j = $j + 1;
  }
fclose($soubor);
?>

<?php if ( $elsubor == 2 ) { ?>
<br />
<br />
Stiahnite si niûöie uveden˝ s˙bor XML na V·ö lok·lny disk a naËÌtajte na www.financnasprava.sk alebo do aplik·cie eDane:
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />
<?php                      } ?>

<?php
//mysql_free_result($vysledok);
     }
//koniec XML SUBOR

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>