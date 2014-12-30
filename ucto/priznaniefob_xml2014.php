<HTML>
<?php
//XML pre FOB 2014
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
alert ("DaÚovÈ priznanie XML bude pripravenÈ v priebehu janu·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
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

$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="PRIZNANIEFOB_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;

//FO - priezvisko,meno,tituly a trvaly pobyt z ufirdalsie
$sql = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$vysledok = mysql_query($sql);
if ( $vysledok )
     {
$riadok=mysql_fetch_object($vysledok);
$dprie = $riadok->dprie;
$dmeno = $riadok->dmeno;
$dtitl = $riadok->dtitl;
$dtitz = $riadok->dtitz;
$duli = $riadok->duli;
$dcdm = $riadok->dcdm;
$dpsc = $riadok->dpsc;
$dmes = $riadok->dmes;
$dstat = $riadok->dstat;
$dtel = $riadok->dtel;
     }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>FOB xml | EuroSecom</title>
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
<table class="h2" width="100%">
 <tr>
  <td>EuroSecom  -  Priznanie k dani z prÌjmu FO typ B rok <?php echo $kli_vrok; ?> export do XML</td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid";?></span></td>
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
<!-- Danove priznanie k dani z prijmov fyzickej osoby, typ B, vzor 2014 -->
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<dic>01-1234567890</dic>
		<datumNarodenia>02.12.1965</datumNarodenia>
		<typDP>
			<rdp>1</rdp>
			<odp>0</odp>
			<ddp>0</ddp>
		</typDP>
		<zdanovacieObdobie>
			<rok>2014</rok>
			<datumDDP></datumDDP>
		</zdanovacieObdobie>
		<skNace>
			<k1>31</k1>
			<k2>03</k2>
			<k3>0</k3>
			<cinnost>V˝roba matracov</cinnost>
		</skNace>
		<priezvisko>äùastn˝</priezvisko>
		<meno>Peter</meno>
		<titul>Ing.</titul>
		<titulZa>PhDr.</titulZa>
		<adresaTrvPobytu>
			<ulica>Ulica TP</ulica>
			<cislo>08</cislo>
			<psc>09111</psc>
			<obec>Obec TP</obec>
			<stat>ät·t TP</stat>
		</adresaTrvPobytu>
		<nerezident>0</nerezident>
		<prepojeniePar2>1</prepojeniePar2>
		<adresaObvPobytu>
			<ulica>Ulica OP</ulica>
			<cislo>15</cislo>
			<psc>16222</psc>
			<obec>Obec OP</obec>
		</adresaObvPobytu>
		<zastupca>
			<priezvisko>Priezvisko ZZ</priezvisko>
			<meno>Meno ZZ</meno>
			<titul>titulZast</titul>
			<titulZa>titulZastZa</titulZa>
			<rodneCislo>0987654321</rodneCislo>
			<ulica>Ulica ZZ</ulica>
			<cislo>23</cislo>
			<psc>24333</psc>
			<obec>Obec ZZ</obec>
			<stat>Stat ZZ</stat>
			<tel>055/22445566</tel>
			<email>email@mail.sk</email>
		</zastupca>
	</hlavicka>
	<telo>
		<r29>1</r29>
		<r30>30.30</r30>
		<r31>
			<priezviskoMeno>Priezvisko a meno manzelky</priezviskoMeno>
			<rodneCislo>0000000000</rodneCislo>
			<vlastnePrijmy>311.11</vlastnePrijmy>
			<pocetMesiacov>12</pocetMesiacov>
		</r31>
		<r32>
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
		</r32>
		<r33viacAko4>0</r33viacAko4>
		<r34>34.31</r34>
		<r34a>34.32</r34a>
		<r35>35.35</r35>
		<r36>36.36</r36>
		<tabulka1>
			<t1r1>
				<s1>1011.11</s1>
				<s2>1012.12</s2>
			</t1r1>
			<t1r2>
				<s1>1021.11</s1>
				<s2>1022.12</s2>
			</t1r2>
			<t1r3>
				<s1>1031.11</s1>
				<s2>1032.12</s2>
			</t1r3>
			<t1r4>
				<s1>1041.11</s1>
				<s2>1042.12</s2>
			</t1r4>
			<t1r5>
				<s1>1051.11</s1>
				<s2>1052.12</s2>
			</t1r5>
			<t1r6>
				<s1>1061.11</s1>
				<s2>1062.12</s2>
			</t1r6>
			<t1r7>
				<s1>1071.11</s1>
				<s2>1072.12</s2>
			</t1r7>
			<t1r8>
				<s1>1081.11</s1>
				<s2>1082.12</s2>
			</t1r8>
			<t1r9>
				<s1>1091.11</s1>
				<s2>1092.12</s2>
			</t1r9>
			<t1r10>
				<s1>1101.11</s1>
				<s2>1102.12</s2>
			</t1r10>
			<t1r11>
				<s1>1111.11</s1>
				<s2>1112.12</s2>
			</t1r11>
			<t1r12>
				<s1>1121.11</s1>
				<s2>1122.12</s2>
			</t1r12>
		</tabulka1>
		<vydavkyPar6ods11_ods1a2>0</vydavkyPar6ods11_ods1a2>
		<vydavkyPar6ods11_ods3>1</vydavkyPar6ods11_ods3>
		<vydavkyPar6ods11_ods4>0</vydavkyPar6ods11_ods4>
		<vydavkyPar6ods10_ods1a2>0</vydavkyPar6ods10_ods1a2>
		<vydavkyPar6ods10_ods1a2pocMes>10</vydavkyPar6ods10_ods1a2pocMes>
		<vydavkyPar6ods10_ods4>1</vydavkyPar6ods10_ods4>
		<vydavkyPar6ods10_ods4pocMes>11</vydavkyPar6ods10_ods4pocMes>
		<vydavkyPoistPar6ods11_ods1a2>366.01</vydavkyPoistPar6ods11_ods1a2>
		<uplatnujemPar17ods17_ods1a2>0</uplatnujemPar17ods17_ods1a2>
		<uplatnujemPar17ods17_ods3a4>0</uplatnujemPar17ods17_ods3a4>
		<ukoncujemUplatnovaniePar17ods17_ods1a2>0</ukoncujemUplatnovaniePar17ods17_ods1a2>
		<ukoncujemUplatnovaniePar17ods17_ods3a4>1</ukoncujemUplatnovaniePar17ods17_ods3a4>
		<tabulka1a>
			<t1r1>
				<s1>1111.11</s1>
				<s2>1112.12</s2>
			</t1r1>
			<t1r2>
				<s1>1121.11</s1>
				<s2>1122.12</s2>
			</t1r2>
			<t1r3>
				<s1>1131.11</s1>
				<s2>1132.12</s2>
			</t1r3>
			<t1r4>
				<s1>1141.11</s1>
				<s2>1142.12</s2>
			</t1r4>
			<t1r5>
				<s1>1151.11</s1>
				<s2>1152.12</s2>
			</t1r5>
		</tabulka1a>
		<tabulka1b>
			<t1r1>
				<s1>1211.11</s1>
				<s2>1212.12</s2>
			</t1r1>
			<t1r2>
				<s1>1221.11</s1>
				<s2>1222.12</s2>
			</t1r2>
		</tabulka1b>
		<r37>37.37</r37>
		<r38>38.38</r38>
		<r39>39.39</r39>
		<r40>40.40</r40>
		<r41>41.41</r41>
		<r42>42.42</r42>
		<r43>43.43</r43>
		<r44>44.44</r44>
		<r45>45.45</r45>
		<r46>46.46</r46>
		<r47>47.47</r47>
		<r48>48.48</r48>
		<r49>49.49</r49>
		<r50>50.50</r50>
		<r51>51.51</r51>
		<r52>52.52</r52>
		<tabulka2>
			<t2r1>
				<s1>2011.11</s1>
				<s2>2012.12</s2>
			</t2r1>
			<t2r2>
				<s1>2021.11</s1>
				<s2>2022.12</s2>
			</t2r2>
			<t2r3>
				<s1>2031.11</s1>
				<s2>2032.12</s2>
			</t2r3>
			<t2r4>
				<s1>2041.11</s1>
				<s2>2042.12</s2>
			</t2r4>
			<t2r5>
				<s1>2051.11</s1>
				<s2>2052.12</s2>
			</t2r5>
			<t2r6>
				<s1>2061.11</s1>
				<s2>2062.12</s2>
			</t2r6>
			<t2r7>
				<s1>2071.11</s1>
				<s2>2072.12</s2>
			</t2r7>
			<t2r8>
				<s1>2081.11</s1>
				<s2>2082.12</s2>
			</t2r8>
			<t2r9>
				<s1>2091.11</s1>
				<s2>2092.12</s2>
			</t2r9>
			<t2r10>
				<s1>21011.11</s1>
				<s2>21012.12</s2>
			</t2r10>
			<t2r11>
				<s1>21111.11</s1>
				<s2>21112.12</s2>
			</t2r11>
			<t2r12>
				<s1>21211.11</s1>
			</t2r12>
		</tabulka2>
		<r53>53.53</r53>
		<r54>54.54</r54>
		<r55>55.55</r55>
		<tabulka3>
			<t3r1>
				<s1>3011.11</s1>
				<s2>3012.12</s2>
			</t3r1>
			<t3r2>
				<s1>3021.11</s1>
				<s2>3022.12</s2>
			</t3r2>
			<t3r3>
				<s1>3031.11</s1>
				<s2>3032.12</s2>
			</t3r3>
			<t3r4>
				<s1>3041.11</s1>
				<s2>3042.12</s2>
			</t3r4>
			<t3r5>
				<s1>3051.11</s1>
				<s2>3052.12</s2>
			</t3r5>
			<t3r6>
				<s1>3061.11</s1>
				<s2>3062.12</s2>
			</t3r6>
			<t3r7>
				<s1>3071.11</s1>
				<s2>3072.12</s2>
			</t3r7>
			<t3r8>
				<s1>3081.11</s1>
				<s2>3082.12</s2>
			</t3r8>
			<t3r9>
				<s1>3091.11</s1>
				<s2>3092.12</s2>
			</t3r9>
			<t3r10>
				<s1>3101.11</s1>
				<s2>3102.12</s2>
			</t3r10>
			<t3r11>
				<s1>3111.11</s1>
				<s2>3112.12</s2>
			</t3r11>
			<t3r12>
				<s1>3121.11</s1>
				<s2>3122.12</s2>
			</t3r12>
			<t3r13>
				<s1>3131.11</s1>
			</t3r13>
			<t3r14>
				<s1>3141.11</s1>
				<s2>3142.12</s2>
			</t3r14>
		</tabulka3>
		<r56>56.56</r56>
		<r57>57.57</r57>
		<r58>58.58</r58>
		<r59>
			<predchObdobie>
				<rok>2009</rok>
				<strata>592.59</strata>
			</predchObdobie>
		</r59>
		<r60>
			<predchObdobie>
				<rok>2010</rok>
				<strata>602.60</strata>
			</predchObdobie>
		</r60>
		<r61>
			<predchObdobie>
				<rok>2011</rok>
				<strata>612.61</strata>
			</predchObdobie>
		</r61>
		<r62>
			<predchObdobie>
				<rok>2012</rok>
				<strata>622.62</strata>
			</predchObdobie>
		</r62>
		<r63>
			<predchObdobie>
				<rok>2013</rok>
				<strata>632.63</strata>
			</predchObdobie>
		</r63>
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
		<r75>75.75</r75>
		<r76>76.76</r76>
		<r77>77.77</r77>
		<r78>78.78</r78>
		<r79>79.79</r79>
		<r80>80.80</r80>
		<r81>81.81</r81>
		<r82>82.82</r82>
		<r83>83.83</r83>
		<r84>84.84</r84>
		<r85>85.85</r85>
		<r86>86.86</r86>
		<r87>87.87</r87>
		<r88>88.88</r88>
		<r89>89.89</r89>
		<r90>90.90</r90>
		<r91>91.91</r91>
		<r92>92.92</r92>
		<r93>93.93</r93>
		<r94>94.94</r94>
		<r95>95.95</r95>
		<r96>96.96</r96>
		<r97>97.97</r97>
		<r98>98.98</r98>
		<r99>99.99</r99>
		<r100>100.00</r100>
		<r101>101.01</r101>
		<r102>102.02</r102>
		<r103>103.03</r103>
		<r104>104.04</r104>
		<r105>105.05</r105>
		<r106>106.06</r106>
		<r107>107.07</r107>
		<r108>108.08</r108>
		<r109>109.09</r109>
		<r110>110.10</r110>
		<r111>111.11</r111>
		<r112>112.12</r112>
		<r113>113.13</r113>
		<r114>114.14</r114>
		<r115>115.15</r115>
		<r116>116.16</r116>
		<r117>Stat danovej rezidencie</r117>
		<r118>118.18</r118>
		<r119>1</r119>
		<r120>20</r120>
		<neuplatnujem>1</neuplatnujem>
		<splnam3per>1</splnam3per>
		<r121>121.21</r121>
		<r122>
			<ico>12345678</ico>
			<sid>1234</sid>
			<pravnaForma>spol. s rucenim obmedzenym</pravnaForma>
			<obchMeno>
				<riadok>ObchodnÈ meno</riadok>
				<riadok>prijÌmateæa 2% dane</riadok>
			</obchMeno>
			<ulica>Ulica PrijÌmateæa</ulica>
			<cislo>99</cislo>
			<psc>77777</psc>
			<obec>Obec PrijÌmateæa</obec>
		</r122>
		<osobitneZaznamy>
			<uvadza>1</uvadza>
			<udajeOprijmoch>
				<kodStatu>105</kodStatu>
				<druhPrimuPar>1</druhPrimuPar>
				<druhPrimuOds>2</druhPrimuOds>
				<prijmy>7501.01</prijmy>
				<vydavky>7502.01</vydavky>
				<zTohoVydavky>7502.02</zTohoVydavky>
			</udajeOprijmoch>
			<udajeOprijmoch>
				<kodStatu>705</kodStatu>
				<druhPrimuPar>3</druhPrimuPar>
				<druhPrimuOds>4</druhPrimuOds>
				<prijmy>7503.03</prijmy>
				<vydavky>7504.03</vydavky>
				<zTohoVydavky>7502.04</zTohoVydavky>
			</udajeOprijmoch>
			<udajeOprijmoch>
				<kodStatu>308</kodStatu>
				<druhPrimuPar>5</druhPrimuPar>
				<druhPrimuOds>6</druhPrimuOds>
				<prijmy>7505.05</prijmy>
				<vydavky>7506.05</vydavky>
				<zTohoVydavky>7502.06</zTohoVydavky>
			</udajeOprijmoch>
			<udajeOprijmoch>
				<kodStatu>308</kodStatu>
				<druhPrimuPar>7</druhPrimuPar>
				<druhPrimuOds>8</druhPrimuOds>
				<prijmy>7501.01</prijmy>
				<vydavky>7502.07</vydavky>
				<zTohoVydavky>7502.08</zTohoVydavky>
			</udajeOprijmoch>
			<udajeOprijmoch>
				<kodStatu>308</kodStatu>
				<druhPrimuPar>9</druhPrimuPar>
				<druhPrimuOds>1</druhPrimuOds>
				<prijmy>7503.03</prijmy>
				<vydavky>7504.09</vydavky>
				<zTohoVydavky>7502.10</zTohoVydavky>
			</udajeOprijmoch>
			<udajeOprijmoch>
				<kodStatu>105</kodStatu>
				<druhPrimuPar>1</druhPrimuPar>
				<druhPrimuOds>2</druhPrimuOds>
				<prijmy>7505.05</prijmy>
				<vydavky>7506.11</vydavky>
				<zTohoVydavky>7502.12</zTohoVydavky>
			</udajeOprijmoch>
			<zaznamy/>
		</osobitneZaznamy>
		<r123>23</r123>
		<datumVyhlasenia>07.02.2014</datumVyhlasenia>
		<danovyPreplatokBonus>
			<vyplatitDanovyBonus>1</vyplatitDanovyBonus>
			<vratitDanPreplatok>1</vratitDanPreplatok>
			<sposobPlatby>
				<poukazka>0</poukazka>
				<ucet>1</ucet>
			</sposobPlatby>
			<bankovyUcet>
				<IBAN>SK111111111111111111111</IBAN>
				<predcislieUctu>123456</predcislieUctu>
				<cisloUctu>1234567890</cisloUctu>
				<kodBanky>1100</kodBanky>
			</bankovyUcet>
			<datum>24.02.2014</datum>
		</danovyPreplatokBonus>
		<socZdravPoistenie>
			<pr1>
				<s1>1.01</s1>
				<s2>1.02</s2>
			</pr1>
			<pr2>2.02</pr2>
			<pr3>3.03</pr3>
			<pr4>4.04</pr4>
			<pr5>5.05</pr5>
			<pr6>6.06</pr6>
			<pr7>7.07</pr7>
			<pr8>8.08</pr8>
			<pr9>9.09</pr9>
			<pr10>10.10</pr10>
			<pr11>11.11</pr11>
			<pr12>12.12</pr12>
			<pr13>13.13</pr13>
			<pr14>14.14</pr14>
			<pr15>15.15</pr15>
			<pr16>16.16</pr16>
			<priPrimoch6ods1a2VediemPU>0</priPrimoch6ods1a2VediemPU>
			<datum>28.02.2014</datum>
		</socZdravPoistenie>
	</telo>
</dokument>
);
mzdprc;


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpriznanie_fob ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ( $i <= $pol )
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

$dic=$fir_fdic;
  $text = "  <dic><![CDATA[".$dic."]]></dic>"."\r\n"; fwrite($soubor, $text);
$datumNarodenia="";
if ( $hlavicka->nrz == 1 ) $datumNarodenia=SkDatum($hlavicka->dar);
if ( $datumNarodenia == '00.00.0000' ) $datumNarodenia="";
  $text = "  <datumNarodenia><![CDATA[".$datumNarodenia."]]></datumNarodenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <typDP>"."\r\n"; fwrite($soubor, $text);
$rdp="1"; $odp="0"; $ddp="0";
if ( $hlavicka->druh == 2 ) { $rdp="0"; $odp="1"; $ddp="0"; }
if ( $hlavicka->druh == 3 ) { $rdp="0"; $odp="0"; $ddp="1"; }
  $text = "   <rdp><![CDATA[".$rdp."]]></rdp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <odp><![CDATA[".$odp."]]></odp>"."\r\n"; fwrite($soubor, $text);
  $text = "   <ddp><![CDATA[".$ddp."]]></ddp>"."\r\n"; fwrite($soubor, $text);
  $text = "  </typDP>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=$kli_vrok;
  $text = "   <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$datumDDP="";
if ( $ddp == 1 ) $datumDDP=SkDatum($hlavicka->ddp);
if ( $datumDDP == '00.00.0000' ) $datumDDP="";
  $text = "   <datumDDP><![CDATA[".$datumDDP."]]></datumDDP>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zdanovacieObdobie>"."\r\n"; fwrite($soubor, $text);

  $text = "  <skNace>"."\r\n"; fwrite($soubor, $text);
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
  $k1=$sknacea;
  $text = "   <k1><![CDATA[".$k1."]]></k1>"."\r\n"; fwrite($soubor, $text);
  $k2=$sknaceb;
  $text = "   <k2><![CDATA[".$k2."]]></k2>"."\r\n"; fwrite($soubor, $text);
  $k3=$sknacec;
  $text = "   <k3><![CDATA[".$k3."]]></k3>"."\r\n"; fwrite($soubor, $text);
$cinnost=iconv("CP1250", "UTF-8", $hlavicka->cinnost);
  $text = "   <cinnost><![CDATA[".$cinnost."]]></cinnost>"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n"; fwrite($soubor, $text);

$priezvisko=iconv("CP1250", "UTF-8", $dprie);
  $text = "  <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $dmeno);
  $text = "  <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $dtitl);
  $text = "  <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titulza=iconv("CP1250", "UTF-8", $dtitz);
  $text = "  <titulZa><![CDATA[".$titulza."]]></titulZa>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $duli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$dcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$dpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $dmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $dstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaTrvPobytu>"."\r\n"; fwrite($soubor, $text);

$nerezident=$hlavicka->nrz;
  $text = "  <nerezident><![CDATA[".$nerezident."]]></nerezident>"."\r\n"; fwrite($soubor, $text);
$nerezident=$hlavicka->prp;
  $text = "  <prepojeniePar2><![CDATA[".$nerezident."]]></prepojeniePar2>"."\r\n"; fwrite($soubor, $text);

  $text = "  <adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->d2uli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->d2cdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->d2psc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->d2mes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </adresaObvPobytu>"."\r\n"; fwrite($soubor, $text);

  $text = "  <zastupca>"."\r\n"; fwrite($soubor, $text);
$priezvisko=iconv("CP1250", "UTF-8", $hlavicka->zprie);
  $text = "   <priezvisko><![CDATA[".$priezvisko."]]></priezvisko>"."\r\n"; fwrite($soubor, $text);
$meno=iconv("CP1250", "UTF-8", $hlavicka->zmeno);
  $text = "   <meno><![CDATA[".$meno."]]></meno>"."\r\n"; fwrite($soubor, $text);
$titul=iconv("CP1250", "UTF-8", $hlavicka->ztitl);
  $text = "   <titul><![CDATA[".$titul."]]></titul>"."\r\n"; fwrite($soubor, $text);
$titulza=iconv("CP1250", "UTF-8", $hlavicka->ztitz);
  $text = "   <titulZa><![CDATA[".$titulza."]]></titulZa>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->zrdc.$hlavicka->zrdk;
  $text = "   <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->zuli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->zcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->zpsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->zmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
$stat=iconv("CP1250", "UTF-8", $hlavicka->zstat);
  $text = "   <stat><![CDATA[".$stat."]]></stat>"."\r\n"; fwrite($soubor, $text);
$telefon=$dtel;
  $text = "   <tel><![CDATA[".$telefon."]]></tel>"."\r\n"; fwrite($soubor, $text);
$mail=iconv("CP1250", "UTF-8", $fir_fem1);
  $text = "   <email><![CDATA[".$mail."]]></email>"."\r\n"; fwrite($soubor, $text);
  $text = "  </zastupca>"."\r\n"; fwrite($soubor, $text);

  $text = " </hlavicka>"."\r\n"; fwrite($soubor, $text);
  $text = " <telo>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r29;
  $text = "  <r29><![CDATA[".$riadok."]]></r29>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r30;
if ( $hlavicka->r29 == 0 ) $riadok="";
if ( $riadok == 0 ) $riadok="";
  $text = "  <r30><![CDATA[".$riadok."]]></r30>"."\r\n"; fwrite($soubor, $text);
 
  $text = "  <r31>"."\r\n"; fwrite($soubor, $text);
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
  $text = "  </r31>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r32>"."\r\n"; fwrite($soubor, $text);
  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d1prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d1rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=$hlavicka->d1pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d1pom1;
if ( $hlavicka->d1pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d1pom2;
if ( $hlavicka->d1pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d1pom3;
if ( $hlavicka->d1pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d1pom4;
if ( $hlavicka->d1pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d1pom5;
if ( $hlavicka->d1pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d1pom6;
if ( $hlavicka->d1pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d1pom7;
if ( $hlavicka->d1pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d1pom8;
if ( $hlavicka->d1pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d1pom9;
if ( $hlavicka->d1pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d1pom10;
if ( $hlavicka->d1pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d1pom11;
if ( $hlavicka->d1pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d1pom12;
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
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=$hlavicka->d2pom1;
if ( $hlavicka->d2pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=$hlavicka->d2pom2;
if ( $hlavicka->d2pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=$hlavicka->d2pom3;
if ( $hlavicka->d2pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=$hlavicka->d2pom4;
if ( $hlavicka->d2pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=$hlavicka->d2pom5;
if ( $hlavicka->d2pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=$hlavicka->d2pom6;
if ( $hlavicka->d2pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=$hlavicka->d2pom7;
if ( $hlavicka->d2pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=$hlavicka->d2pom8;
if ( $hlavicka->d2pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=$hlavicka->d2pom9;
if ( $hlavicka->d2pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=$hlavicka->d2pom10;
if ( $hlavicka->d2pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=$hlavicka->d2pom11;
if ( $hlavicka->d2pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=$hlavicka->d2pom12;
if ( $hlavicka->d2pomc == 1 ) $m12="";
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d3prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d3rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=1*$hlavicka->d3pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=1*$hlavicka->d3pom1;
if ( $hlavicka->d3pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=1*$hlavicka->d3pom2;
if ( $hlavicka->d3pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=1*$hlavicka->d3pom3;
if ( $hlavicka->d3pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=1*$hlavicka->d3pom4;
if ( $hlavicka->d3pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=1*$hlavicka->d3pom5;
if ( $hlavicka->d3pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=1*$hlavicka->d3pom6;
if ( $hlavicka->d3pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=1*$hlavicka->d3pom7;
if ( $hlavicka->d3pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=1*$hlavicka->d3pom8;
if ( $hlavicka->d3pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=1*$hlavicka->d3pom9;
if ( $hlavicka->d3pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=1*$hlavicka->d3pom10;
if ( $hlavicka->d3pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=1*$hlavicka->d3pom11;
if ( $hlavicka->d3pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=1*$hlavicka->d3pom12;
if ( $hlavicka->d3pomc == 1 ) $m12="";
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);

  $text = "   <dieta>"."\r\n"; fwrite($soubor, $text);
$priezvisko= iconv("CP1250", "UTF-8", $hlavicka->d4prie);
  $text = "    <priezviskoMeno><![CDATA[".$priezvisko."]]></priezviskoMeno>"."\r\n"; fwrite($soubor, $text);
$rodneCislo=$hlavicka->d4rod;
if ( $riadok == 0 ) $riadok="";
  $text = "    <rodneCislo><![CDATA[".$rodneCislo."]]></rodneCislo>"."\r\n"; fwrite($soubor, $text);
$m00=1*$hlavicka->d4pomc;
  $text = "    <m00><![CDATA[".$m00."]]></m00>"."\r\n"; fwrite($soubor, $text);
$m01=1*$hlavicka->d4pom1;
if ( $hlavicka->d4pomc == 1 ) $m01="";
  $text = "    <m01><![CDATA[".$m01."]]></m01>"."\r\n"; fwrite($soubor, $text);
$m02=1*$hlavicka->d4pom2;
if ( $hlavicka->d4pomc == 1 ) $m02="";
  $text = "    <m02><![CDATA[".$m02."]]></m02>"."\r\n"; fwrite($soubor, $text);
$m03=1*$hlavicka->d4pom3;
if ( $hlavicka->d4pomc == 1 ) $m03="";
  $text = "    <m03><![CDATA[".$m03."]]></m03>"."\r\n"; fwrite($soubor, $text);
$m04=1*$hlavicka->d4pom4;
if ( $hlavicka->d4pomc == 1 ) $m04="";
  $text = "    <m04><![CDATA[".$m04."]]></m04>"."\r\n"; fwrite($soubor, $text);
$m05=1*$hlavicka->d4pom5;
if ( $hlavicka->d4pomc == 1 ) $m05="";
  $text = "    <m05><![CDATA[".$m05."]]></m05>"."\r\n"; fwrite($soubor, $text);
$m06=1*$hlavicka->d4pom6;
if ( $hlavicka->d4pomc == 1 ) $m06="";
  $text = "    <m06><![CDATA[".$m06."]]></m06>"."\r\n"; fwrite($soubor, $text);
$m07=1*$hlavicka->d4pom7;
if ( $hlavicka->d4pomc == 1 ) $m07="";
  $text = "    <m07><![CDATA[".$m07."]]></m07>"."\r\n"; fwrite($soubor, $text);
$m08=1*$hlavicka->d4pom8;
if ( $hlavicka->d4pomc == 1 ) $m08="";
  $text = "    <m08><![CDATA[".$m08."]]></m08>"."\r\n"; fwrite($soubor, $text);
$m09=1*$hlavicka->d4pom9;
if ( $hlavicka->d4pomc == 1 ) $m09="";
  $text = "    <m09><![CDATA[".$m09."]]></m09>"."\r\n"; fwrite($soubor, $text);
$m10=1*$hlavicka->d4pom10;
if ( $hlavicka->d4pomc == 1 ) $m10="";
  $text = "    <m10><![CDATA[".$m10."]]></m10>"."\r\n"; fwrite($soubor, $text);
$m11=1*$hlavicka->d4pom11;
if ( $hlavicka->d4pomc == 1 ) $m11="";
  $text = "    <m11><![CDATA[".$m11."]]></m11>"."\r\n"; fwrite($soubor, $text);
$m12=1*$hlavicka->d4pom12;
if ( $hlavicka->d4pomc == 1 ) $m12="";
  $text = "    <m12><![CDATA[".$m12."]]></m12>"."\r\n"; fwrite($soubor, $text);
  $text = "   </dieta>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r32>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r33;
  $text = "  <r33viacAko4><![CDATA[".$riadok."]]></r33viacAko4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r34;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34><![CDATA[".$riadok."]]></r34>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r34a;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r34a><![CDATA[".$riadok."]]></r34a>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r35;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r35><![CDATA[".$riadok."]]></r35>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r36;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r36><![CDATA[".$riadok."]]></r36>"."\r\n"; fwrite($soubor, $text);
  
  $text = "  <tabulka1>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r5>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r9>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r10>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1v12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r12>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uppr1;
  $text = "  <vydavkyPar6ods11_ods1a2><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uppr3;
  $text = "  <vydavkyPar6ods11_ods3><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uppr4;
  $text = "  <vydavkyPar6ods11_ods4><![CDATA[".$riadok."]]></vydavkyPar6ods11_ods4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uvp61;
  $text = "  <vydavkyPar6ods10_ods1a2><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uvp61m;
if ( $riadok == 0 ) $riadok="";
  $text = "  <vydavkyPar6ods10_ods1a2pocMes><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods1a2pocMes>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uvp64;
  $text = "  <vydavkyPar6ods10_ods4><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uvp64m;
if ( $riadok == 0 ) $riadok="";
  $text = "  <vydavkyPar6ods10_ods4pocMes><![CDATA[".$riadok."]]></vydavkyPar6ods10_ods4pocMes>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->psp6;
if ( $riadok == 0 ) $riadok="";
  $text = "  <vydavkyPoistPar6ods11_ods1a2><![CDATA[".$riadok."]]></vydavkyPoistPar6ods11_ods1a2>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->uos61;
  $text = "  <uplatnujemPar17ods17_ods1a2><![CDATA[".$riadok."]]></uplatnujemPar17ods17_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->uos64;
  $text = "  <uplatnujemPar17ods17_ods3a4><![CDATA[".$riadok."]]></uplatnujemPar17ods17_ods3a4>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->kos61;
  $text = "  <ukoncujemUplatnovaniePar17ods17_ods1a2><![CDATA[".$riadok."]]></ukoncujemUplatnovaniePar17ods17_ods1a2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->kos64;
  $text = "  <ukoncujemUplatnovaniePar17ods17_ods3a4><![CDATA[".$riadok."]]></ukoncujemUplatnovaniePar17ods17_ods3a4>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabulka1a>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1az5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1ak5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r5>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1a>"."\r\n"; fwrite($soubor, $text);

$text = "  <tabulka1b>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t1r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bz1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bk1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t1r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bz2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t1bk2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t1r2>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka1b>"."\r\n"; fwrite($soubor, $text);

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

  $text = "  <tabulka2>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t2r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p1;
if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r5>"."\r\n"; fwrite($soubor, $text);

  $text = "  <t2r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r9>"."\r\n"; fwrite($soubor, $text);
 
  $text = "   <t2r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r10>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r11>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t2r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t2p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t2r12>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka2>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r53;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r53><![CDATA[".$riadok."]]></r53>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r54;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r54><![CDATA[".$riadok."]]></r54>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r55;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r55><![CDATA[".$riadok."]]></r55>"."\r\n"; fwrite($soubor, $text);

  $text = "  <tabulka3>"."\r\n"; fwrite($soubor, $text);
  $text = "   <t3r1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r1>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r2>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r3>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);;
  $text = "   </t3r4>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r5>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r6>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v7;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r7>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v8;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r8>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v9;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r9>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v10;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r10>"."\r\n";   fwrite($soubor, $text);
  
  $text = "   <t3r11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v11;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r11>"."\r\n"; fwrite($soubor, $text);
 
  $text = "   <t3r12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);;
$riadok=$hlavicka->t3v12;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);;
  $text = "   </t3r12>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p13;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r13>"."\r\n"; fwrite($soubor, $text);

  $text = "   <t3r14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3p14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->t3v14;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </t3r14>"."\r\n"; fwrite($soubor, $text);
  $text = "  </tabulka3>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r56;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r56><![CDATA[".$riadok."]]></r56>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r57;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r57><![CDATA[".$riadok."]]></r57>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r58;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r58><![CDATA[".$riadok."]]></r58>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r59>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=2009;
//$rok=$hlavicka->rr59;
//if ( $hlavicka->rr59 == 0 ) $rok="";
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$strata=$hlavicka->r59;
if ( $hlavicka->r59 == 0 ) $strata="";
  $text = "    <strata><![CDATA[".$strata."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r59>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r60>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=2010;
//$rok=$hlavicka->rr60;
//if ( $hlavicka->rr60 == 0 ) $rok="";
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$strata=$hlavicka->r60;
if ( $hlavicka->r60 == 0 ) $strata="";
  $text = "    <strata><![CDATA[".$strata."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r60>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r61>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=2011;
//$rok=$hlavicka->rr61;
//if ( $hlavicka->rr61 == 0 ) $rok="";
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$strata=$hlavicka->r61;
if ( $hlavicka->r61 == 0 ) $strata="";
  $text = "    <strata><![CDATA[".$strata."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r61>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r62>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
$rok=2012;
//$rok=$hlavicka->rr62;
//if ( $hlavicka->rr62 == 0 ) $rok="";
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$strata=$hlavicka->r62;
if ( $hlavicka->r62 == 0 ) $strata="";
  $text = "    <strata><![CDATA[".$strata."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r62>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r63>"."\r\n"; fwrite($soubor, $text);
  $text = "   <predchObdobie>"."\r\n"; fwrite($soubor, $text);
$rok="2013";
  $text = "    <rok><![CDATA[".$rok."]]></rok>"."\r\n"; fwrite($soubor, $text);
$strata=$hlavicka->r63;
if ( $hlavicka->r63 == 0 ) $strata="";
  $text = "    <strata><![CDATA[".$strata."]]></strata>"."\r\n"; fwrite($soubor, $text);
  $text = "   </predchObdobie>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r63>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->r64;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r64><![CDATA[".$riadok."]]></r64>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r65;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r65><![CDATA[".$riadok."]]></r65>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r66;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r66><![CDATA[".$riadok."]]></r66>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r67;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r67><![CDATA[".$riadok."]]></r67>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r68;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r68><![CDATA[".$riadok."]]></r68>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r69;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r69><![CDATA[".$riadok."]]></r69>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r70;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r70><![CDATA[".$riadok."]]></r70>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r71;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r71><![CDATA[".$riadok."]]></r71>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r72;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r72><![CDATA[".$riadok."]]></r72>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r73;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r73><![CDATA[".$riadok."]]></r73>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r74;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r74><![CDATA[".$riadok."]]></r74>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r75;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r75><![CDATA[".$riadok."]]></r75>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r76;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r76><![CDATA[".$riadok."]]></r76>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r77;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r77><![CDATA[".$riadok."]]></r77>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r78;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r78><![CDATA[".$riadok."]]></r78>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r79;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r79><![CDATA[".$riadok."]]></r79>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r80;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r80><![CDATA[".$riadok."]]></r80>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r81;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r81><![CDATA[".$riadok."]]></r81>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r82;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r82><![CDATA[".$riadok."]]></r82>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r83;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r83><![CDATA[".$riadok."]]></r83>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r84;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r84><![CDATA[".$riadok."]]></r84>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r85;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r85><![CDATA[".$riadok."]]></r85>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r86;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r86><![CDATA[".$riadok."]]></r86>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r87;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r87><![CDATA[".$riadok."]]></r87>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r88;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r88><![CDATA[".$riadok."]]></r88>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r89;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r89><![CDATA[".$riadok."]]></r89>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r90;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r90><![CDATA[".$riadok."]]></r90>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r91;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r91><![CDATA[".$riadok."]]></r91>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r92;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r92><![CDATA[".$riadok."]]></r92>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r93;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r93><![CDATA[".$riadok."]]></r93>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r94;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r94><![CDATA[".$riadok."]]></r94>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r95;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r95><![CDATA[".$riadok."]]></r95>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r96;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r96><![CDATA[".$riadok."]]></r96>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r97;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r97><![CDATA[".$riadok."]]></r97>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r98;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r98><![CDATA[".$riadok."]]></r98>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r99;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r99><![CDATA[".$riadok."]]></r99>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r100;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r100><![CDATA[".$riadok."]]></r100>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r101;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r101><![CDATA[".$riadok."]]></r101>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r102;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r102><![CDATA[".$riadok."]]></r102>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r103;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r103><![CDATA[".$riadok."]]></r103>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r104;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r104><![CDATA[".$riadok."]]></r104>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r105;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r105><![CDATA[".$riadok."]]></r105>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r106;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r106><![CDATA[".$riadok."]]></r106>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r107;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r107><![CDATA[".$riadok."]]></r107>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r108;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r108><![CDATA[".$riadok."]]></r108>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r109;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r109><![CDATA[".$riadok."]]></r109>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r110;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r110><![CDATA[".$riadok."]]></r110>"."\r\n"; fwrite($soubor, $text);

$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r111;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r111><![CDATA[".$riadok."]]></r111>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r112;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r112><![CDATA[".$riadok."]]></r112>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r113;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r113><![CDATA[".$riadok."]]></r113>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r114;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r114><![CDATA[".$riadok."]]></r114>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r115;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r115><![CDATA[".$riadok."]]></r115>"."\r\n"; fwrite($soubor, $text);
$riadok="";
if ( $ddp == 1 ) $riadok=$hlavicka->r116;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r116><![CDATA[".$riadok."]]></r116>"."\r\n"; fwrite($soubor, $text);

$riadok=iconv("CP1250", "UTF-8", $hlavicka->sdnr);
if ( $nerezident == 0 ) $riadok="";
  $text = "  <r117><![CDATA[".$riadok."]]></r117>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r118;
if ( $nerezident == 0 ) $riadok="";
if ( $riadok == 0 ) $riadok="";
  $text = "  <r118><![CDATA[".$riadok."]]></r118>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->ldnr;
if ( $nerezident == 0 ) $riadok="";
  $text = "  <r119><![CDATA[".$riadok."]]></r119>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->nrzsprev;
if ( $nerezident == 0 ) $riadok="";
if ( $riadok == 0 ) $riadok="";
  $text = "  <r120><![CDATA[".$riadok."]]></r120>"."\r\n"; fwrite($soubor, $text);

$neuplatnujem=$hlavicka->upl50;
if ( $hlavicka->r119 == 0 ) { $neuplatnujem=1; }
  $text = "  <neuplatnujem><![CDATA[".$neuplatnujem."]]></neuplatnujem>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->spl3d;
  $text = "  <splnam3per><![CDATA[".$riadok."]]></splnam3per>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->r121;
if ( $neuplatnujem == 1 ) $riadok="";
if ( $riadok == 0 ) $riadok="";
  $text = "  <r121><![CDATA[".$riadok."]]></r121>"."\r\n"; fwrite($soubor, $text);

  $text = "  <r122>"."\r\n"; fwrite($soubor, $text);
$ico=$hlavicka->pico;
//$ico=$hlavicka->pico."/".$hlavicka->psid;
//if ( $hlavicka->psid == '' ) { $ico=$hlavicka->pico; }
  $text = "   <ico><![CDATA[".$ico."]]></ico>"."\r\n"; fwrite($soubor, $text);
$sid=$hlavicka->psid;
  $text = "   <sid><![CDATA[".$sid."]]></sid>"."\r\n"; fwrite($soubor, $text);

$pravnaForma=iconv("CP1250", "UTF-8", $hlavicka->pfor);
  $text = "   <pravnaForma><![CDATA[".$pravnaForma."]]></pravnaForma>"."\r\n"; fwrite($soubor, $text);
  $text = "   <obchMeno>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pmen);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
$riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>"."\r\n"; fwrite($soubor, $text);
  $text = "   </obchMeno>"."\r\n";   fwrite($soubor, $text);
$ulica=iconv("CP1250", "UTF-8", $hlavicka->puli);
  $text = "   <ulica><![CDATA[".$ulica."]]></ulica>"."\r\n"; fwrite($soubor, $text);
$cislo=$hlavicka->pcdm;
  $text = "   <cislo><![CDATA[".$cislo."]]></cislo>"."\r\n"; fwrite($soubor, $text);
$psc=$hlavicka->ppsc;
  $text = "   <psc><![CDATA[".$psc."]]></psc>"."\r\n"; fwrite($soubor, $text);
$obec=iconv("CP1250", "UTF-8", $hlavicka->pmes);
  $text = "   <obec><![CDATA[".$obec."]]></obec>"."\r\n"; fwrite($soubor, $text);
  $text = "  </r122>"."\r\n"; fwrite($soubor, $text);

  $text = "  <osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);
$uvadza=$hlavicka->uoso;
  $text = "   <uvadza><![CDATA[".$uvadza."]]></uvadza>"."\r\n"; fwrite($soubor, $text);


  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks1);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp1);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro1);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks2);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp2);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro2);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd2;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks3);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp3);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro3);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd3;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks4);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp4);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro4);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd4;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks5);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp5);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro5);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd5;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

  $text = "   <udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pzks6);
  $text = "    <kodStatu><![CDATA[".$riadok."]]></kodStatu>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdrp6);
  $text = "    <druhPrimuPar><![CDATA[".$riadok."]]></druhPrimuPar>"."\r\n"; fwrite($soubor, $text);
$riadok=iconv("CP1250", "UTF-8", $hlavicka->pdro6);
  $text = "    <druhPrimuOds><![CDATA[".$riadok."]]></druhPrimuOds>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzpr6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <prijmy><![CDATA[".$riadok."]]></prijmy>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzvd6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <vydavky><![CDATA[".$riadok."]]></vydavky>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->pzthvd6;
if ( $riadok == 0 ) $riadok="";
  $text = "    <zTohoVydavky><![CDATA[".$riadok."]]></zTohoVydavky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </udajeOprijmoch>"."\r\n"; fwrite($soubor, $text);

$zaznamy=iconv("CP1250", "UTF-8", $hlavicka->osob);
if ( $uvadza == 0 ) $zaznamy="";
  $text = "   <zaznamy><![CDATA[".$zaznamy."]]></zaznamy>"."\r\n"; fwrite($soubor, $text);
  $text = "  </osobitneZaznamy>"."\r\n"; fwrite($soubor, $text);

$riadok=$hlavicka->pril;
if ( $riadok == 0 ) $riadok="";
  $text = "  <r123><![CDATA[".$riadok."]]></r123>"."\r\n"; fwrite($soubor, $text);
$datum=SKDatum($hlavicka->dat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "  <datumVyhlasenia><![CDATA[".$datum."]]></datumVyhlasenia>"."\r\n"; fwrite($soubor, $text);

  $text = "  <danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);
$vyplatbonus=$hlavicka->zdbo;
  $text = "   <vyplatitDanovyBonus><![CDATA[".$vyplatbonus."]]></vyplatitDanovyBonus>"."\r\n"; fwrite($soubor, $text);
$vratpreplatok=$hlavicka->zpre;
  $text = "   <vratitDanPreplatok><![CDATA[".$vratpreplatok."]]></vratitDanPreplatok>"."\r\n"; fwrite($soubor, $text);
  $text = "   <sposobPlatby>"."\r\n";   fwrite($soubor, $text);
$poukazka="0";
if ( $vyplatbonus == 1 OR $vratpreplatok == 1 ) $poukazka=$hlavicka->post;
  $text = "    <poukazka><![CDATA[".$poukazka."]]></poukazka>"."\r\n"; fwrite($soubor, $text);
$ucet="0";
if ( $vyplatbonus == 1 OR $vratpreplatok == 1 ) $ucet=$hlavicka->ucet;
if ( $poukazka == 1 ) $ucet="0";
  $text = "    <ucet><![CDATA[".$ucet."]]></ucet>"."\r\n"; fwrite($soubor, $text);
  $text = "   </sposobPlatby>"."\r\n"; fwrite($soubor, $text);
  $text = "   <bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$iban=$hlavicka->diban;
if ( $ucet == 0 ) $iban="";
  $text = "    <IBAN><![CDATA[".$iban."]]></IBAN>"."\r\n"; fwrite($soubor, $text);

$pole = explode("-", $hlavicka->uceb);
$predcislieUctu=$pole[0];
$cisloUctu=$pole[1];
if ( $pole[1] == '' ) { $cisloUctu=$pole[0]; $predcislieUctu=""; }
if ( $ucet == 0 ) $predcislieUctu="";
  $text = "    <predcislieUctu><![CDATA[".$predcislieUctu."]]></predcislieUctu>"."\r\n"; fwrite($soubor, $text);
if ( $ucet == 0 ) $cisloUctu="";
  $text = "    <cisloUctu><![CDATA[".$cisloUctu."]]></cisloUctu>"."\r\n"; fwrite($soubor, $text);
$kodBanky=$hlavicka->numb;
if ( $ucet == 0 ) $kodBanky="";
  $text = "    <kodBanky><![CDATA[".$kodBanky."]]></kodBanky>"."\r\n"; fwrite($soubor, $text);
  $text = "   </bankovyUcet>"."\r\n"; fwrite($soubor, $text);
$datum="";
if ( $vyplatbonus == 1 OR $vratpreplatok == 1 ) $datum=SKDatum($hlavicka->da2);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </danovyPreplatokBonus>"."\r\n"; fwrite($soubor, $text);

  $text = "  <socZdravPoistenie>"."\r\n"; fwrite($soubor, $text);
  $text = "   <pr1>"."\r\n";   fwrite($soubor, $text);
$riadok=$hlavicka->sz1p1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz1v1;
if ( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n"; fwrite($soubor, $text);
  $text = "   </pr1>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz2;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr2><![CDATA[".$riadok."]]></pr2>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz3;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr3><![CDATA[".$riadok."]]></pr3>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz4;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr4><![CDATA[".$riadok."]]></pr4>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz5;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr5><![CDATA[".$riadok."]]></pr5>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz6;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr6><![CDATA[".$riadok."]]></pr6>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz7;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr7><![CDATA[".$riadok."]]></pr7>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz8;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr8><![CDATA[".$riadok."]]></pr8>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz9;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr9><![CDATA[".$riadok."]]></pr9>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz10;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr10><![CDATA[".$riadok."]]></pr10>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz11;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr11><![CDATA[".$riadok."]]></pr11>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz12;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr12><![CDATA[".$riadok."]]></pr12>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz13;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr13><![CDATA[".$riadok."]]></pr13>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz14;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr14><![CDATA[".$riadok."]]></pr14>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz15;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr15><![CDATA[".$riadok."]]></pr15>"."\r\n"; fwrite($soubor, $text);
$riadok=$hlavicka->sz16;
if ( $riadok == 0 ) $riadok="";
  $text = "   <pr16><![CDATA[".$riadok."]]></pr16>"."\r\n"; fwrite($soubor, $text);

$vediempu=$hlavicka->vpdu;
  $text = "   <priPrimoch6ods1a2VediemPU><![CDATA[".$vediempu."]]></priPrimoch6ods1a2VediemPU>"."\r\n"; fwrite($soubor, $text);
$datum=SKDatum($hlavicka->szdat);
if ( $datum =='00.00.0000' ) $datum="";
  $text = "   <datum><![CDATA[".$datum."]]></datum>"."\r\n"; fwrite($soubor, $text);
  $text = "  </socZdravPoistenie>"."\r\n";   fwrite($soubor, $text);

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

// celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>