<HTML>
<?php

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

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];

$chyby = 1*$_REQUEST['chyby'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";



$hhmm = Date ("H_i", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$idx=$kli_uzid.$hhmm;

$nazsub="UZAVIERKA_POD_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzávierka POD XML</title>
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
<BODY class="white" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Úètovná závierka POD <?php echo $kli_vrok; ?> - export do XML

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<?php
///////////////////////////////////////////////////TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU elsubor=1,2
if ( $copern == 10 AND $elsubor == 2  )
    {

//prva strana


if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }

$soubor = fopen("../tmp/$nazsub", "a+");


$sqlt = <<<mzdprc
(
<?xml version="1.0" encoding="UTF-8"?>
<dokument xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="universal.xsd">
	<hlavicka>
		<datumK>
			<den>31</den>
			<mesiac>12</mesiac>
			<rok>2014</rok>
		</datumK>
		<dic>0123456789</dic>
		<ico>12345678</ico>
		<skNace>
			<k1>31</k1>
			<k2>03</k2>
			<k3>0</k3>
		</skNace>
		<typUzavierky>
			<riadna>1</riadna>
			<mimoriadna>0</mimoriadna>
			<priebezna>0</priebezna>
			<mala>0</mala>
			<velka>1</velka>
		</typUzavierky>
		<obdobie>
			<od>
				<mesiac>1</mesiac>
				<rok>2014</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2014</rok>
			</do>
		</obdobie>
		<bPredObdobie>
			<od>
				<mesiac>1</mesiac>
				<rok>2013</rok>
			</od>
			<do>
				<mesiac>12</mesiac>
				<rok>2013</rok>
			</do>
		</bPredObdobie>
		<prilozeneSucasti>
			<suvaha>1</suvaha>
			<vykazZiskovStrat>1</vykazZiskovStrat>
			<poznamky>1</poznamky>
		</prilozeneSucasti>
		<uctJednotka>
			<obchMeno>
				<riadok>Meno úètovej jednotky</riadok>
				<riadok>pokraèovanie mena</riadok>
			</obchMeno>
			<sidlo>
				<ulica>Ulicová</ulica>
				<cislo>13</cislo>
				<psc>66666</psc>
				<obec>Obcová</obec>
				<oznObchodReg>
					<riadok>Oznaèenie obchodného registra a èíslo</riadok>
					<riadok>zápisu obchodnej spoloènosti</riadok>
				</oznObchodReg>
				<telefon>0901123456</telefon>
				<fax>0902123456</fax>
				<email>e-mail@uctovnaJednotka.sk</email>
			</sidlo>
		</uctJednotka>
		<datZostavenia>16.1.2015</datZostavenia>
		<datSchvalenia>23.1.2015</datSchvalenia>
	</hlavicka>
	<telo>
		<ucPod1Suvaha>
			<r001>
				<s1>11</s1>
				<s2>12</s2>
				<s3>13</s3>
				<s4>14</s4>
			</r001>
			<r002>
				<s1>21</s1>
				<s2>22</s2>
				<s3>23</s3>
				<s4>24</s4>
			</r002>
			<r003>
				<s1>31</s1>
				<s2>32</s2>
				<s3>33</s3>
				<s4>34</s4>
			</r003>
			<r004>
				<s1>41</s1>
				<s2>42</s2>
				<s3>43</s3>
				<s4>44</s4>
			</r004>
			<r005>
				<s1>51</s1>
				<s2>52</s2>
				<s3>53</s3>
				<s4>54</s4>
			</r005>
			<r006>
				<s1>61</s1>
				<s2>62</s2>
				<s3>63</s3>
				<s4>64</s4>
			</r006>
			<r007>
				<s1>71</s1>
				<s2>72</s2>
				<s3>73</s3>
				<s4>74</s4>
			</r007>
			<r008>
				<s1>81</s1>
				<s2>82</s2>
				<s3>83</s3>
				<s4>84</s4>
			</r008>
			<r009>
				<s1>91</s1>
				<s2>92</s2>
				<s3>93</s3>
				<s4>94</s4>
			</r009>
			<r010>
				<s1>101</s1>
				<s2>102</s2>
				<s3>103</s3>
				<s4>104</s4>
			</r010>
			<r011>
				<s1>111</s1>
				<s2>112</s2>
				<s3>113</s3>
				<s4>114</s4>
			</r011>
			<r012>
				<s1>121</s1>
				<s2>122</s2>
				<s3>123</s3>
				<s4>124</s4>
			</r012>
			<r013>
				<s1>131</s1>
				<s2>132</s2>
				<s3>133</s3>
				<s4>134</s4>
			</r013>
			<r014>
				<s1>141</s1>
				<s2>142</s2>
				<s3>143</s3>
				<s4>144</s4>
			</r014>
			<r015>
				<s1>151</s1>
				<s2>152</s2>
				<s3>153</s3>
				<s4>154</s4>
			</r015>
			<r016>
				<s1>161</s1>
				<s2>162</s2>
				<s3>163</s3>
				<s4>164</s4>
			</r016>
			<r017>
				<s1>171</s1>
				<s2>172</s2>
				<s3>173</s3>
				<s4>174</s4>
			</r017>
			<r018>
				<s1>181</s1>
				<s2>182</s2>
				<s3>183</s3>
				<s4>184</s4>
			</r018>
			<r019>
				<s1>191</s1>
				<s2>192</s2>
				<s3>193</s3>
				<s4>194</s4>
			</r019>
			<r020>
				<s1>201</s1>
				<s2>202</s2>
				<s3>203</s3>
				<s4>204</s4>
			</r020>
			<r021>
				<s1>211</s1>
				<s2>212</s2>
				<s3>213</s3>
				<s4>214</s4>
			</r021>
			<r022>
				<s1>221</s1>
				<s2>222</s2>
				<s3>223</s3>
				<s4>224</s4>
			</r022>
			<r023>
				<s1>231</s1>
				<s2>232</s2>
				<s3>233</s3>
				<s4>234</s4>
			</r023>
			<r024>
				<s1>241</s1>
				<s2>242</s2>
				<s3>243</s3>
				<s4>244</s4>
			</r024>
			<r025>
				<s1>251</s1>
				<s2>252</s2>
				<s3>253</s3>
				<s4>254</s4>
			</r025>
			<r026>
				<s1>261</s1>
				<s2>262</s2>
				<s3>263</s3>
				<s4>264</s4>
			</r026>
			<r027>
				<s1>271</s1>
				<s2>272</s2>
				<s3>273</s3>
				<s4>274</s4>
			</r027>
			<r028>
				<s1>281</s1>
				<s2>282</s2>
				<s3>283</s3>
				<s4>284</s4>
			</r028>
			<r029>
				<s1>291</s1>
				<s2>292</s2>
				<s3>293</s3>
				<s4>294</s4>
			</r029>
			<r030>
				<s1>301</s1>
				<s2>302</s2>
				<s3>303</s3>
				<s4>304</s4>
			</r030>
			<r031>
				<s1>311</s1>
				<s2>312</s2>
				<s3>313</s3>
				<s4>314</s4>
			</r031>
			<r032>
				<s1>321</s1>
				<s2>322</s2>
				<s3>323</s3>
				<s4>324</s4>
			</r032>
			<r033>
				<s1>331</s1>
				<s2>332</s2>
				<s3>333</s3>
				<s4>334</s4>
			</r033>
			<r034>
				<s1>341</s1>
				<s2>342</s2>
				<s3>343</s3>
				<s4>344</s4>
			</r034>
			<r035>
				<s1>351</s1>
				<s2>352</s2>
				<s3>353</s3>
				<s4>354</s4>
			</r035>
			<r036>
				<s1>361</s1>
				<s2>362</s2>
				<s3>363</s3>
				<s4>364</s4>
			</r036>
			<r037>
				<s1>371</s1>
				<s2>372</s2>
				<s3>373</s3>
				<s4>374</s4>
			</r037>
			<r038>
				<s1>381</s1>
				<s2>382</s2>
				<s3>383</s3>
				<s4>384</s4>
			</r038>
			<r039>
				<s1>391</s1>
				<s2>392</s2>
				<s3>393</s3>
				<s4>394</s4>
			</r039>
			<r040>
				<s1>401</s1>
				<s2>402</s2>
				<s3>403</s3>
				<s4>404</s4>
			</r040>
			<r041>
				<s1>411</s1>
				<s2>412</s2>
				<s3>413</s3>
				<s4>414</s4>
			</r041>
			<r042>
				<s1>421</s1>
				<s2>422</s2>
				<s3>423</s3>
				<s4>424</s4>
			</r042>
			<r043>
				<s1>431</s1>
				<s2>432</s2>
				<s3>433</s3>
				<s4>434</s4>
			</r043>
			<r044>
				<s1>441</s1>
				<s2>442</s2>
				<s3>443</s3>
				<s4>444</s4>
			</r044>
			<r045>
				<s1>451</s1>
				<s2>452</s2>
				<s3>453</s3>
				<s4>454</s4>
			</r045>
			<r046>
				<s1>461</s1>
				<s2>462</s2>
				<s3>463</s3>
				<s4>464</s4>
			</r046>
			<r047>
				<s1>471</s1>
				<s2>472</s2>
				<s3>473</s3>
				<s4>474</s4>
			</r047>
			<r048>
				<s1>481</s1>
				<s2>482</s2>
				<s3>483</s3>
				<s4>484</s4>
			</r048>
			<r049>
				<s1>491</s1>
				<s2>492</s2>
				<s3>493</s3>
				<s4>494</s4>
			</r049>
			<r050>
				<s1>501</s1>
				<s2>502</s2>
				<s3>503</s3>
				<s4>504</s4>
			</r050>
			<r051>
				<s1>511</s1>
				<s2>512</s2>
				<s3>513</s3>
				<s4>514</s4>
			</r051>
			<r052>
				<s1>521</s1>
				<s2>522</s2>
				<s3>523</s3>
				<s4>524</s4>
			</r052>
			<r053>
				<s1>531</s1>
				<s2>532</s2>
				<s3>533</s3>
				<s4>534</s4>
			</r053>
			<r054>
				<s1>541</s1>
				<s2>542</s2>
				<s3>543</s3>
				<s4>544</s4>
			</r054>
			<r055>
				<s1>551</s1>
				<s2>552</s2>
				<s3>553</s3>
				<s4>554</s4>
			</r055>
			<r056>
				<s1>561</s1>
				<s2>562</s2>
				<s3>563</s3>
				<s4>564</s4>
			</r056>
			<r057>
				<s1>571</s1>
				<s2>572</s2>
				<s3>573</s3>
				<s4>574</s4>
			</r057>
			<r058>
				<s1>581</s1>
				<s2>582</s2>
				<s3>583</s3>
				<s4>584</s4>
			</r058>
			<r059>
				<s1>591</s1>
				<s2>592</s2>
				<s3>593</s3>
				<s4>594</s4>
			</r059>
			<r060>
				<s1>601</s1>
				<s2>602</s2>
				<s3>603</s3>
				<s4>604</s4>
			</r060>
			<r061>
				<s1>611</s1>
				<s2>612</s2>
				<s3>613</s3>
				<s4>614</s4>
			</r061>
			<r062>
				<s1>621</s1>
				<s2>622</s2>
				<s3>623</s3>
				<s4>624</s4>
			</r062>
			<r063>
				<s1>631</s1>
				<s2>632</s2>
				<s3>633</s3>
				<s4>634</s4>
			</r063>
			<r064>
				<s1>641</s1>
				<s2>642</s2>
				<s3>643</s3>
				<s4>644</s4>
			</r064>
			<r065>
				<s1>651</s1>
				<s2>652</s2>
				<s3>653</s3>
				<s4>654</s4>
			</r065>
			<r066>
				<s1>661</s1>
				<s2>662</s2>
				<s3>663</s3>
				<s4>664</s4>
			</r066>
			<r067>
				<s1>671</s1>
				<s2>672</s2>
				<s3>673</s3>
				<s4>674</s4>
			</r067>
			<r068>
				<s1>681</s1>
				<s2>682</s2>
				<s3>683</s3>
				<s4>684</s4>
			</r068>
			<r069>
				<s1>691</s1>
				<s2>692</s2>
				<s3>693</s3>
				<s4>694</s4>
			</r069>
			<r070>
				<s1>701</s1>
				<s2>702</s2>
				<s3>703</s3>
				<s4>704</s4>
			</r070>
			<r071>
				<s1>711</s1>
				<s2>712</s2>
				<s3>713</s3>
				<s4>714</s4>
			</r071>
			<r072>
				<s1>721</s1>
				<s2>722</s2>
				<s3>723</s3>
				<s4>724</s4>
			</r072>
			<r073>
				<s1>731</s1>
				<s2>732</s2>
				<s3>733</s3>
				<s4>734</s4>
			</r073>
			<r074>
				<s1>741</s1>
				<s2>742</s2>
				<s3>743</s3>
				<s4>744</s4>
			</r074>
			<r075>
				<s1>751</s1>
				<s2>752</s2>
				<s3>753</s3>
				<s4>754</s4>
			</r075>
			<r076>
				<s1>761</s1>
				<s2>762</s2>
				<s3>763</s3>
				<s4>764</s4>
			</r076>
			<r077>
				<s1>771</s1>
				<s2>772</s2>
				<s3>773</s3>
				<s4>774</s4>
			</r077>
			<r078>
				<s1>781</s1>
				<s2>782</s2>
				<s3>783</s3>
				<s4>784</s4>
			</r078>
			<r079>
				<s5>795</s5>
				<s6>796</s6>
			</r079>
			<r080>
				<s5>805</s5>
				<s6>806</s6>
			</r080>
			<r081>
				<s5>815</s5>
				<s6>816</s6>
			</r081>
			<r082>
				<s5>825</s5>
				<s6>826</s6>
			</r082>
			<r083>
				<s5>835</s5>
				<s6>836</s6>
			</r083>
			<r084>
				<s5>845</s5>
				<s6>846</s6>
			</r084>
			<r085>
				<s5>855</s5>
				<s6>856</s6>
			</r085>
			<r086>
				<s5>865</s5>
				<s6>866</s6>
			</r086>
			<r087>
				<s5>875</s5>
				<s6>876</s6>
			</r087>
			<r088>
				<s5>885</s5>
				<s6>886</s6>
			</r088>
			<r089>
				<s5>895</s5>
				<s6>896</s6>
			</r089>
			<r090>
				<s5>905</s5>
				<s6>906</s6>
			</r090>
			<r091>
				<s5>915</s5>
				<s6>916</s6>
			</r091>
			<r092>
				<s5>925</s5>
				<s6>926</s6>
			</r092>
			<r093>
				<s5>935</s5>
				<s6>936</s6>
			</r093>
			<r094>
				<s5>945</s5>
				<s6>946</s6>
			</r094>
			<r095>
				<s5>955</s5>
				<s6>956</s6>
			</r095>
			<r096>
				<s5>965</s5>
				<s6>966</s6>
			</r096>
			<r097>
				<s5>975</s5>
				<s6>976</s6>
			</r097>
			<r098>
				<s5>985</s5>
				<s6>986</s6>
			</r098>
			<r099>
				<s5>995</s5>
				<s6>996</s6>
			</r099>
			<r100>
				<s5>1005</s5>
				<s6>1006</s6>
			</r100>
			<r101>
				<s5>1015</s5>
				<s6>1016</s6>
			</r101>
			<r102>
				<s5>1025</s5>
				<s6>1026</s6>
			</r102>
			<r103>
				<s5>1035</s5>
				<s6>1036</s6>
			</r103>
			<r104>
				<s5>1045</s5>
				<s6>1046</s6>
			</r104>
			<r105>
				<s5>1055</s5>
				<s6>1056</s6>
			</r105>
			<r106>
				<s5>1065</s5>
				<s6>1066</s6>
			</r106>
			<r107>
				<s5>1075</s5>
				<s6>1076</s6>
			</r107>
			<r108>
				<s5>1085</s5>
				<s6>1086</s6>
			</r108>
			<r109>
				<s5>1095</s5>
				<s6>1096</s6>
			</r109>
			<r110>
				<s5>1105</s5>
				<s6>1106</s6>
			</r110>
			<r111>
				<s5>1115</s5>
				<s6>1116</s6>
			</r111>
			<r112>
				<s5>1125</s5>
				<s6>1126</s6>
			</r112>
			<r113>
				<s5>1135</s5>
				<s6>1136</s6>
			</r113>
			<r114>
				<s5>1145</s5>
				<s6>1146</s6>
			</r114>
			<r115>
				<s5>1155</s5>
				<s6>1156</s6>
			</r115>
			<r116>
				<s5>1165</s5>
				<s6>1166</s6>
			</r116>
			<r117>
				<s5>1175</s5>
				<s6>1176</s6>
			</r117>
			<r118>
				<s5>1185</s5>
				<s6>1186</s6>
			</r118>
			<r119>
				<s5>1195</s5>
				<s6>1196</s6>
			</r119>
			<r120>
				<s5>1205</s5>
				<s6>1206</s6>
			</r120>
			<r121>
				<s5>1215</s5>
				<s6>1216</s6>
			</r121>
			<r122>
				<s5>1225</s5>
				<s6>1226</s6>
			</r122>
			<r123>
				<s5>1235</s5>
				<s6>1236</s6>
			</r123>
			<r124>
				<s5>1245</s5>
				<s6>1246</s6>
			</r124>
			<r125>
				<s5>1255</s5>
				<s6>1256</s6>
			</r125>
			<r126>
				<s5>1265</s5>
				<s6>1266</s6>
			</r126>
			<r127>
				<s5>1275</s5>
				<s6>1276</s6>
			</r127>
			<r128>
				<s5>1285</s5>
				<s6>1286</s6>
			</r128>
			<r129>
				<s5>1295</s5>
				<s6>1296</s6>
			</r129>
			<r130>
				<s5>1305</s5>
				<s6>1306</s6>
			</r130>
			<r131>
				<s5>1315</s5>
				<s6>1316</s6>
			</r131>
			<r132>
				<s5>1325</s5>
				<s6>1326</s6>
			</r132>
			<r133>
				<s5>1335</s5>
				<s6>1336</s6>
			</r133>
			<r134>
				<s5>1345</s5>
				<s6>1346</s6>
			</r134>
			<r135>
				<s5>1355</s5>
				<s6>1356</s6>
			</r135>
			<r136>
				<s5>1365</s5>
				<s6>1366</s6>
			</r136>
			<r137>
				<s5>1375</s5>
				<s6>1376</s6>
			</r137>
			<r138>
				<s5>1385</s5>
				<s6>1386</s6>
			</r138>
			<r139>
				<s5>1395</s5>
				<s6>1396</s6>
			</r139>
			<r140>
				<s5>1405</s5>
				<s6>1406</s6>
			</r140>
			<r141>
				<s5>1415</s5>
				<s6>1416</s6>
			</r141>
			<r142>
				<s5>1425</s5>
				<s6>1426</s6>
			</r142>
			<r143>
				<s5>1435</s5>
				<s6>1436</s6>
			</r143>
			<r144>
				<s5>1445</s5>
				<s6>1446</s6>
			</r144>
			<r145>
				<s5>1455</s5>
				<s6>1456</s6>
			</r145>
		</ucPod1Suvaha>
		<ucPod2VykazZS>
			<r01>
				<s1>11</s1>
				<s2>12</s2>
			</r01>
			<r02>
				<s1>21</s1>
				<s2>22</s2>
			</r02>
			<r03>
				<s1>31</s1>
				<s2>32</s2>
			</r03>
			<r04>
				<s1>41</s1>
				<s2>42</s2>
			</r04>
			<r05>
				<s1>51</s1>
				<s2>52</s2>
			</r05>
			<r06>
				<s1>61</s1>
				<s2>62</s2>
			</r06>
			<r07>
				<s1>71</s1>
				<s2>72</s2>
			</r07>
			<r08>
				<s1>81</s1>
				<s2>82</s2>
			</r08>
			<r09>
				<s1>91</s1>
				<s2>92</s2>
			</r09>
			<r10>
				<s1>101</s1>
				<s2>102</s2>
			</r10>
			<r11>
				<s1>111</s1>
				<s2>112</s2>
			</r11>
			<r12>
				<s1>121</s1>
				<s2>122</s2>
			</r12>
			<r13>
				<s1>131</s1>
				<s2>132</s2>
			</r13>
			<r14>
				<s1>141</s1>
				<s2>142</s2>
			</r14>
			<r15>
				<s1>151</s1>
				<s2>152</s2>
			</r15>
			<r16>
				<s1>161</s1>
				<s2>162</s2>
			</r16>
			<r17>
				<s1>171</s1>
				<s2>172</s2>
			</r17>
			<r18>
				<s1>181</s1>
				<s2>182</s2>
			</r18>
			<r19>
				<s1>191</s1>
				<s2>192</s2>
			</r19>
			<r20>
				<s1>201</s1>
				<s2>202</s2>
			</r20>
			<r21>
				<s1>211</s1>
				<s2>212</s2>
			</r21>
			<r22>
				<s1>221</s1>
				<s2>222</s2>
			</r22>
			<r23>
				<s1>231</s1>
				<s2>232</s2>
			</r23>
			<r24>
				<s1>241</s1>
				<s2>242</s2>
			</r24>
			<r25>
				<s1>251</s1>
				<s2>252</s2>
			</r25>
			<r26>
				<s1>261</s1>
				<s2>262</s2>
			</r26>
			<r27>
				<s1>271</s1>
				<s2>272</s2>
			</r27>
			<r28>
				<s1>281</s1>
				<s2>282</s2>
			</r28>
			<r29>
				<s1>291</s1>
				<s2>292</s2>
			</r29>
			<r30>
				<s1>301</s1>
				<s2>302</s2>
			</r30>
			<r31>
				<s1>311</s1>
				<s2>312</s2>
			</r31>
			<r32>
				<s1>321</s1>
				<s2>322</s2>
			</r32>
			<r33>
				<s1>331</s1>
				<s2>332</s2>
			</r33>
			<r34>
				<s1>341</s1>
				<s2>342</s2>
			</r34>
			<r35>
				<s1>351</s1>
				<s2>352</s2>
			</r35>
			<r36>
				<s1>361</s1>
				<s2>362</s2>
			</r36>
			<r37>
				<s1>371</s1>
				<s2>372</s2>
			</r37>
			<r38>
				<s1>381</s1>
				<s2>382</s2>
			</r38>
			<r39>
				<s1>391</s1>
				<s2>392</s2>
			</r39>
			<r40>
				<s1>401</s1>
				<s2>402</s2>
			</r40>
			<r41>
				<s1>411</s1>
				<s2>412</s2>
			</r41>
			<r42>
				<s1>421</s1>
				<s2>422</s2>
			</r42>
			<r43>
				<s1>431</s1>
				<s2>432</s2>
			</r43>
			<r44>
				<s1>441</s1>
				<s2>442</s2>
			</r44>
			<r45>
				<s1>451</s1>
				<s2>452</s2>
			</r45>
			<r46>
				<s1>461</s1>
				<s2>462</s2>
			</r46>
			<r47>
				<s1>471</s1>
				<s2>472</s2>
			</r47>
			<r48>
				<s1>481</s1>
				<s2>482</s2>
			</r48>
			<r49>
				<s1>491</s1>
				<s2>492</s2>
			</r49>
			<r50>
				<s1>501</s1>
				<s2>502</s2>
			</r50>
			<r51>
				<s1>511</s1>
				<s2>512</s2>
			</r51>
			<r52>
				<s1>521</s1>
				<s2>522</s2>
			</r52>
			<r53>
				<s1>531</s1>
				<s2>532</s2>
			</r53>
			<r54>
				<s1>541</s1>
				<s2>542</s2>
			</r54>
			<r55>
				<s1>551</s1>
				<s2>552</s2>
			</r55>
			<r56>
				<s1>561</s1>
				<s2>562</s2>
			</r56>
			<r57>
				<s1>571</s1>
				<s2>572</s2>
			</r57>
			<r58>
				<s1>581</s1>
				<s2>582</s2>
			</r58>
			<r59>
				<s1>591</s1>
				<s2>592</s2>
			</r59>
			<r60>
				<s1>601</s1>
				<s2>602</s2>
			</r60>
			<r61>
				<s1>611</s1>
				<s2>612</s2>
			</r61>
		</ucPod2VykazZS>
	</telo>
</dokument>
);
mzdprc;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." WHERE prx = 1 "; 

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

if( $j == 0 )
          {

  $text = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"."\r\n";
  fwrite($soubor, $text);
  $text = "<dokument xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"universal.xsd\">"."\r\n"; fwrite($soubor, $text);		
   	
  $text = "  <hlavicka>	"."\r\n"; fwrite($soubor, $text);

  $text = "  <datumK>"."\r\n";   fwrite($soubor, $text);
 

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

$pole = explode(".", $datk_sk);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];



//uzavierka k z ufirdalsie
if( $kli_vrok >= 2013 )
          {

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  if( $riadok->datk != '0000-00-00' )
    {
  $datk_sk=SkDatum($riadok->datk);

$pole = explode(".", $datk_sk);
$den=$pole[0];
$mesiac=$pole[1];
$rok=$pole[2];

    }
  }

          }




  $text = "    <den><![CDATA[".$den."]]></den>	"."\r\n"; fwrite($soubor, $text);
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text); 
  $text = "  </datumK>"."\r\n";   fwrite($soubor, $text);

  $dic=1*$fir_fdic;
  $text = "    <dic><![CDATA[".$dic."]]></dic>	"."\r\n"; fwrite($soubor, $text);

  $ico=1*$fir_fico;
  $text = "    <ico><![CDATA[".$ico."]]></ico>	"."\r\n"; fwrite($soubor, $text);

$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sknaceb=$pole[1];
$sknacec=$pole[2];
  $text = "  <skNace>"."\r\n";   fwrite($soubor, $text);	
  $k1=$sknacea;
  $text = "    <k1><![CDATA[".$k1."]]></k1>	"."\r\n"; fwrite($soubor, $text);
  $k2=$sknaceb;
  $text = "    <k2><![CDATA[".$k2."]]></k2>	"."\r\n"; fwrite($soubor, $text);
  $k3=$sknacec;
  $text = "    <k3><![CDATA[".$k3."]]></k3>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </skNace>"."\r\n";   fwrite($soubor, $text);

  $text = "  <typUzavierky>"."\r\n";   fwrite($soubor, $text);

//riadna mimoriadna 
$druz=0;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $druz=1*$riadok->druz;
  }

$riadna=1;
$mimoriadna=0;
if( $druz == 1 ) { $riadna=0; $mimoriadna=1; } 

  $text = "    <riadna><![CDATA[".$riadna."]]></riadna>	"."\r\n"; fwrite($soubor, $text);

  $text = "    <mimoriadna><![CDATA[".$mimoriadna."]]></mimoriadna>	"."\r\n"; fwrite($soubor, $text);
  $zostavena=0;
if( $h_zos != '' ) $zostavena = 1;
if( trim($h_sch) != '' ) { $zostavena=0; $h_zos=""; }
  $text = "    <zostavena><![CDATA[".$zostavena."]]></zostavena>	"."\r\n"; fwrite($soubor, $text);
  $schvalena=0;
if( $h_sch != '' ) $schvalena = 1;  
  $text = "    <schvalena><![CDATA[".$schvalena."]]></schvalena>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </typUzavierky>"."\r\n";   fwrite($soubor, $text);

  $text = "  <obdobie>"."\r\n";   fwrite($soubor, $text); 
//nacitaj obdobie z priznanie_po
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_po");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $obdd1=$riadok->obdd1;
  $obdm1=$riadok->obdm1;
  $obdr1=$riadok->obdr1+2000;
  $obdd2=$riadok->obdd2;
  $obdm2=$riadok->obdm2;
  $obdr2=$riadok->obdr2+2000;
  $obmd1=$riadok->obmd1;
  $obmm1=$riadok->obmm1;
  $obmr1=$riadok->obmr1+2000;
  $obmd2=$riadok->obmd2;
  $obmm2=$riadok->obmm2;
  $obmr2=$riadok->obmr2+2000;

  }


if( $kli_vrok >= 2013 )
{

//nacitaj obdobia z ufirdalsie
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if ( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);

$poleb = explode(".", $datbodsk);
$obdd1=$poleb[0];
$obdm1=$poleb[1];
$obdr1=$poleb[2];
$poleb = explode(".", $datbdosk);
$obdd2=$poleb[0];
$obdm2=$poleb[1];
$obdr2=$poleb[2];
$poleb = explode(".", $datmodsk);
$obmd1=$poleb[0];
$obmm1=$poleb[1];
$obmr1=$poleb[2];
$poleb = explode(".", $datmdosk);
$obmd2=$poleb[0];
$obmm2=$poleb[1];
$obmr2=$poleb[2];


     }
  }
}

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;
if( $cobdd1 == 0 OR $cobdm1 == 0 OR $cobdr1 == 0 ) { 
$obdd1="01"; $obdm1="01"; $obdr1=$kli_vrok; $obdd2="01"; $obdm2=$kli_vmes; $obdr2=$kli_vrok; 
$kli_mrok=$kli_vrok-1;
$obmd1="01"; $obmm1="01"; $obmr1=$kli_mrok; $obmd2="31"; $obmm2=12; $obmr2=$kli_mrok;
}

  $text = "  <od>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obdm1;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obdr1;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </od>"."\r\n";   fwrite($soubor, $text);

  $text = "  <do>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obdm2;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obdr2;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text); 
  $text = "  </do>"."\r\n";   fwrite($soubor, $text); 
  $text = "  </obdobie>"."\r\n";   fwrite($soubor, $text);

  $text = "  <bPredObdobie>"."\r\n";   fwrite($soubor, $text);
  $text = "  <od>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obmm1;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obmr1;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </od>"."\r\n";   fwrite($soubor, $text);

  $text = "  <do>"."\r\n";   fwrite($soubor, $text); 
  $mesiac=$obmm2;
  $text = "    <mesiac><![CDATA[".$mesiac."]]></mesiac>	"."\r\n"; fwrite($soubor, $text);
  $rok=$obmr2;
  $text = "    <rok><![CDATA[".$rok."]]></rok>	"."\r\n"; fwrite($soubor, $text); 
  $text = "  </do>"."\r\n";   fwrite($soubor, $text); 
  $text = "  </bPredObdobie>"."\r\n";   fwrite($soubor, $text);

  $text = "  <uctJednotka>"."\r\n";   fwrite($soubor, $text); 

  $text = "  <obchMeno>"."\r\n";   fwrite($soubor, $text);
  $riadok=iconv("CP1250", "UTF-8", $fir_fnaz);
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>	"."\r\n"; fwrite($soubor, $text);
  $riadok="";
  $text = "    <riadok><![CDATA[".$riadok."]]></riadok>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </obchMeno>"."\r\n";   fwrite($soubor, $text);

  $text = "  <sidlo>"."\r\n";   fwrite($soubor, $text); 
  $ulica=iconv("CP1250", "UTF-8", $fir_fuli);
  $text = "    <ulica><![CDATA[".$ulica."]]></ulica>	"."\r\n"; fwrite($soubor, $text);
  $cislo=$fir_fcdm;
  $text = "    <cislo><![CDATA[".$cislo."]]></cislo>	"."\r\n"; fwrite($soubor, $text);
  $psc=$fir_fpsc;
  $psc=str_replace(" ","",$psc);
  $text = "    <psc><![CDATA[".$psc."]]></psc>	"."\r\n"; fwrite($soubor, $text);
  $obec=iconv("CP1250", "UTF-8", $fir_fmes);
  $text = "    <obec><![CDATA[".$obec."]]></obec>	"."\r\n"; fwrite($soubor, $text);
  $telefon=$fir_ftel;
  $text = "    <telefon><![CDATA[".$telefon."]]></telefon>	"."\r\n"; fwrite($soubor, $text);
  $fax=$fir_ffax;
  $text = "    <fax><![CDATA[".$fax."]]></fax>	"."\r\n"; fwrite($soubor, $text);
  $email=$fir_fem1;
  $text = "    <email><![CDATA[".$email."]]></email>	"."\r\n"; fwrite($soubor, $text);
  $text = "  </sidlo>"."\r\n";   fwrite($soubor, $text);

  $text = "  </uctJednotka>"."\r\n";   fwrite($soubor, $text);

  $datZostavenia=$h_zos;
  $text = "    <datZostavenia><![CDATA[".$datZostavenia."]]></datZostavenia>	"."\r\n"; fwrite($soubor, $text);

  $datSchvalenia=$h_sch;
  $text = "    <datSchvalenia><![CDATA[".$datSchvalenia."]]></datSchvalenia>	"."\r\n"; fwrite($soubor, $text);
 
  $text = "  </hlavicka>"."\r\n";   fwrite($soubor, $text);
 
  $text = "  <telo>"."\r\n";   fwrite($soubor, $text);

//suvaha riadky

$sqlttps = "SELECT * FROM F$kli_vxcf"."_pos_muj2014 WHERE dok > 0 ORDER BY dok "; 
$sqlps = mysql_query("$sqlttps");
$polps = mysql_num_rows($sqlps);

$ips=0;
  while ($ips <= $polps )
  {
  if (@$zaznam=mysql_data_seek($sqlps,$ips))
{
$hlavickps=mysql_fetch_object($sqlps);

$riadok=1*$hlavickps->dok;

if( $riadok ==  1 ) { $rm01=1*$hlavickps->hod; }
if( $riadok ==  2 ) { $rm02=1*$hlavickps->hod; }
if( $riadok ==  3 ) { $rm03=1*$hlavickps->hod; }
if( $riadok ==  4 ) { $rm04=1*$hlavickps->hod; }
if( $riadok ==  5 ) { $rm05=1*$hlavickps->hod; }
if( $riadok ==  6 ) { $rm06=1*$hlavickps->hod; }
if( $riadok ==  7 ) { $rm07=1*$hlavickps->hod; }
if( $riadok ==  8 ) { $rm08=1*$hlavickps->hod; }
if( $riadok ==  9 ) { $rm09=1*$hlavickps->hod; }
if( $riadok == 10 ) { $rm10=1*$hlavickps->hod; }
if( $riadok == 11 ) { $rm11=1*$hlavickps->hod; }
if( $riadok == 12 ) { $rm12=1*$hlavickps->hod; }
if( $riadok == 13 ) { $rm13=1*$hlavickps->hod; }
if( $riadok == 14 ) { $rm14=1*$hlavickps->hod; }
if( $riadok == 15 ) { $rm15=1*$hlavickps->hod; }
if( $riadok == 16 ) { $rm16=1*$hlavickps->hod; }
if( $riadok == 17 ) { $rm17=1*$hlavickps->hod; }
if( $riadok == 18 ) { $rm18=1*$hlavickps->hod; }
if( $riadok == 19 ) { $rm19=1*$hlavickps->hod; }
if( $riadok == 20 ) { $rm20=1*$hlavickps->hod; }
if( $riadok == 21 ) { $rm21=1*$hlavickps->hod; }
if( $riadok == 22 ) { $rm22=1*$hlavickps->hod; }
if( $riadok == 23 ) { $rm23=1*$hlavickps->hod; }
if( $riadok == 24 ) { $rm24=1*$hlavickps->hod; }
if( $riadok == 25 ) { $rm25=1*$hlavickps->hod; }
if( $riadok == 26 ) { $rm26=1*$hlavickps->hod; }
if( $riadok == 27 ) { $rm27=1*$hlavickps->hod; }
if( $riadok == 28 ) { $rm28=1*$hlavickps->hod; }
if( $riadok == 29 ) { $rm29=1*$hlavickps->hod; }
if( $riadok == 30 ) { $rm30=1*$hlavickps->hod; }
if( $riadok == 31 ) { $rm31=1*$hlavickps->hod; }
if( $riadok == 32 ) { $rm32=1*$hlavickps->hod; }
if( $riadok == 33 ) { $rm33=1*$hlavickps->hod; }
if( $riadok == 34 ) { $rm34=1*$hlavickps->hod; }
if( $riadok == 35 ) { $rm35=1*$hlavickps->hod; }
if( $riadok == 36 ) { $rm36=1*$hlavickps->hod; }
if( $riadok == 37 ) { $rm37=1*$hlavickps->hod; }
if( $riadok == 38 ) { $rm38=1*$hlavickps->hod; }
if( $riadok == 39 ) { $rm39=1*$hlavickps->hod; }
if( $riadok == 40 ) { $rm40=1*$hlavickps->hod; }
if( $riadok == 41 ) { $rm41=1*$hlavickps->hod; }
if( $riadok == 44 ) { $rm44=1*$hlavickps->hod; }
if( $riadok == 43 ) { $rm43=1*$hlavickps->hod; }
if( $riadok == 44 ) { $rm44=1*$hlavickps->hod; }
if( $riadok == 45 ) { $rm45=1*$hlavickps->hod; }

}
$ips = $ips + 1;
  }

  $text = "  <ucMuj1Suvaha>"."\r\n";   fwrite($soubor, $text);


  $text = "  <r01>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r01>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r02>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r02>"."\r\n";   fwrite($soubor, $text);


  $text = "  </ucMuj1Suvaha>"."\r\n";   fwrite($soubor, $text);

          }
//koniec ak j=0



}
$i = $i + 1;
$j = $j + 1;
  }

//vykazziskov a strat


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvyk1000ziss".$kli_uzid." WHERE prx = 1 "; 

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavickav=mysql_fetch_object($sql);


if( $j == 0 )
          {

$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; 
$rm11=""; $rm12=""; $rm13=""; $rm14=""; $rm15=""; $rm16=""; $rm17=""; $rm18=""; $rm19=""; $rm20="";
$rm21=""; $rm22=""; $rm23=""; $rm24=""; $rm25=""; $rm26=""; $rm27=""; $rm28=""; $rm29=""; $rm30="";
$rm31=""; $rm32=""; $rm33=""; $rm34=""; $rm35=""; $rm36=""; $rm37=""; $rm38="";

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_pov_muj2014 WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
$polpv = mysql_num_rows($sqlpv);

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);

$riadok=1*$hlavickpv->dok;

if( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }
if( $riadok == 22 ) { $rm22=1*$hlavickpv->hod; }
if( $riadok == 23 ) { $rm23=1*$hlavickpv->hod; }
if( $riadok == 24 ) { $rm24=1*$hlavickpv->hod; }
if( $riadok == 25 ) { $rm25=1*$hlavickpv->hod; }
if( $riadok == 26 ) { $rm26=1*$hlavickpv->hod; }
if( $riadok == 27 ) { $rm27=1*$hlavickpv->hod; }
if( $riadok == 28 ) { $rm28=1*$hlavickpv->hod; }
if( $riadok == 29 ) { $rm29=1*$hlavickpv->hod; }
if( $riadok == 30 ) { $rm30=1*$hlavickpv->hod; }
if( $riadok == 31 ) { $rm31=1*$hlavickpv->hod; }
if( $riadok == 32 ) { $rm32=1*$hlavickpv->hod; }
if( $riadok == 33 ) { $rm33=1*$hlavickpv->hod; }
if( $riadok == 34 ) { $rm34=1*$hlavickpv->hod; }
if( $riadok == 35 ) { $rm35=1*$hlavickpv->hod; }
if( $riadok == 36 ) { $rm36=1*$hlavickpv->hod; }
if( $riadok == 37 ) { $rm37=1*$hlavickpv->hod; }
if( $riadok == 38 ) { $rm38=1*$hlavickpv->hod; }

}
$ipv = $ipv + 1;
  }


  $text = "  <ucMuj2VykazZS>"."\r\n";   fwrite($soubor, $text);


  $text = "  <r01>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavickav->r01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r01>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r02>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavickav->r02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$rm02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r02>"."\r\n";   fwrite($soubor, $text);


  $text = "  </ucMuj2VykazZS>"."\r\n";   fwrite($soubor, $text);





  $text = "  </telo>"."\r\n";   fwrite($soubor, $text);    

  $text = "  </dokument>"."\r\n";   fwrite($soubor, $text);
    
          }
//koniec ak j=0



}
$i = $i + 1;
$j = $j + 1;
  }



fclose($soubor);
?>



<?php
if( $elsubor == 2 )
{
?>
<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk a naèítajte na www.drsr.sk alebo do aplikácie eDane :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />


<?php
}
?>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<?php
//mysql_free_result($vysledok);
    }
/////////////////////////////////////////////////////koniec TLAC a VYTVORENIE XML SUBORU PRE ELEKTRONIKU


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
