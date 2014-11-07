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

$nazsub="UZAVIERKA_MUJ_".$kli_vrok."_".$idx.".xml";

$copern=10;
$zarchivu=1;
$elsubor=2;


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzávierka MUJ XML</title>
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

<td>EuroSecom  -  Úètovná závierka MUJ <?php echo $kli_vrok; ?> - export do XML

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


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvaha_stt".
" ON F$kli_vxcf"."_prcsuv1000ahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvaha_stt.fic".
" WHERE prx = 1 ".""; 


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
 
  $text = "  <r001>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4301\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4302\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4303\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm01;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4304\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r001>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r002>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4305\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4306\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4307\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm02;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4308\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r002>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r003>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r03;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4309\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk03;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4310\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn03;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4311\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm03;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4312\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r003>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r004>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r04;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4313\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk04;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4314\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn04;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4315\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm04;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4316\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r004>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r005>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r05;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4317\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk05;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4318\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn05;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4319\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm05;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4320\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r005>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r006>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r06;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4321\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk06;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4322\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn06;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4323\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm06;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4324\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r006>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r007>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r07;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4325\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk07;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4326\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn07;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4327\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm07;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4328\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r007>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r008>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r08;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4329\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk08;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4330\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn08;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4331\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm08;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4332\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r008>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r009>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r09;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4333\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk09;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4334\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn09;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4335\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm09;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4336\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r009>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r010>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r10;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4337\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk10;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4338\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn10;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4339\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm10;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4340\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r010>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r011>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r11;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4341\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk11;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4342\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn11;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4343\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm11;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4344\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r011>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r012>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r12;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4345\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk12;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4346\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn12;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4347\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm12;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4348\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r012>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r013>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r13;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4349\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk13;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4350\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn13;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4351\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm13;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4352\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r013>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r014>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r14;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4353\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk14;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4354\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn14;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4355\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm14;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4356\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r014>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r015>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r15;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4357\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk15;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4358\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn15;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4359\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm15;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4360\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r015>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r016>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r16;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4361\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk16;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4362\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn16;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4363\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm16;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4364\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r016>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r017>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r17;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4365\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk17;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4366\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn17;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4367\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm17;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4368\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r017>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r018>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r18;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4369\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk18;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4370\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn18;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4371\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm18;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4372\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r018>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r019>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r19;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4373\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk19;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4374\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn19;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4375\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm19;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4376\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r019>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r020>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r20;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4377\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk20;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4378\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn20;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4379\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm20;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4380\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r020>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r021>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r21;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4381\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk21;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4382\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn21;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4383\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm21;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4384\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r021>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r022>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r22;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4385\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk22;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4386\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn22;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4387\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm22;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4388\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r022>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r023>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r23;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4389\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk23;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4390\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn23;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4391\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm23;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4392\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r023>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r024>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r24;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4393\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk24;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4394\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn24;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4395\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm24;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4396\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r024>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r025>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r25;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4397\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk25;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4398\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn25;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4399\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm25;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4400\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r025>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r026>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r26;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4401\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk26;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4402\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn26;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4403\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm26;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4404\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r026>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r027>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r27;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4405\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk27;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4406\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn27;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4407\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm27;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4408\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r027>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r028>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r28;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4409\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk28;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4410\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn28;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4411\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm28;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4412\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r028>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r029>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r29;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4413\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk29;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4414\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn29;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4415\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm29;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4416\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r029>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r030>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r30;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4417\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk30;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4418\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn30;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4419\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm30;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4420\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r030>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r031>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r31;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4421\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk31;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4422\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn31;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4423\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm31;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4424\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r031>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r032>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r32;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4425\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk32;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4426\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn32;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4427\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm32;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4428\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r032>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r033>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r33;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4429\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk33;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4430\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn33;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4431\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm33;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4432\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r033>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r034>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r34;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4433\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk34;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4434\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn34;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4435\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm34;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4436\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r034>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r035>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r35;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4437\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk35;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4438\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn35;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4439\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm35;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4440\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r035>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r036>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r36;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4441\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk36;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4442\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn36;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4443\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm36;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4444\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r036>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r037>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r37;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4445\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk37;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4446\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn37;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4447\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm37;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4448\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r037>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r038>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r38;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4449\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk38;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4450\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn38;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4451\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm38;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4452\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r038>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r039>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r39;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4453\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk39;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4454\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn39;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4455\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm39;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4456\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r039>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r040>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r40;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4457\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk40;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4458\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn40;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4459\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm40;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4460\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r040>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r041>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r41;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4461\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk41;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4462\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn41;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4463\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm41;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4464\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r041>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r042>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r42;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4465\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk42;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4466\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn42;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4467\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm42;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4468\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r042>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r043>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r43;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4469\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk43;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4470\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn43;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4471\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm43;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4472\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r043>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r044>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r44;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4473\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk44;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4474\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn44;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4475\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm44;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4476\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r044>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r045>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r45;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4477\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk45;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4478\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn45;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4479\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm45;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4480\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r045>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r046>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r46;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4481\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk46;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4482\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn46;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4483\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm46;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4484\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r046>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r047>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r47;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4485\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk47;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4486\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn47;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4487\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm47;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4488\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r047>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r048>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r48;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4489\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk48;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4490\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn48;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4491\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm48;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4492\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r048>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r049>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r49;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4493\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk49;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4494\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn49;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4495\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm49;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4496\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r049>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r050>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r50;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4497\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk50;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4498\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn50;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4499\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm50;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4500\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r050>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r051>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r51;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4501\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk51;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4502\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn51;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4503\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm51;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4504\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r051>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r052>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r52;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4505\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk52;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4506\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn52;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4507\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm52;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4508\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r052>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r053>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r53;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4509\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk53;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4510\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn53;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4511\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm53;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4512\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r053>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r054>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r54;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4513\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk54;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4514\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn54;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4515\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm54;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4516\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r054>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r055>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r55;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4517\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk55;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4518\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn55;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4519\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm55;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4520\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r055>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r056>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r56;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4521\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk56;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4522\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn56;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4523\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm56;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4524\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r056>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r057>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r57;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4525\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk57;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4526\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn57;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4527\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm57;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4528\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r057>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r058>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r58;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4529\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk58;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4530\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn58;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4531\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm58;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4532\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r058>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r059>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r59;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4533\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk59;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4534\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn59;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4535\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm59;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4536\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r059>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r060>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r60;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4537\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk60;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4538\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn60;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4539\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm60;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4540\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r060>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r061>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r61;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4541\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk61;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4542\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn61;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4543\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm61;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4544\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r061>"."\r\n";   fwrite($soubor, $text);
 
  $text = "  <r062>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r62;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4545\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk62;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4546\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn62;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4547\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm62;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4548\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r062>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r063>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r63;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4549\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk63;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4550\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn63;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4551\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm63;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4552\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r063>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r064>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r64;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4553\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk64;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4554\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn64;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4555\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm64;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4556\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r064>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r065>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r65;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s1 ukazovatel=\"4557\"><![CDATA[".$riadok."]]></s1>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rk65;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s2 ukazovatel=\"4558\"><![CDATA[".$riadok."]]></s2>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rn65;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s3 ukazovatel=\"4559\"><![CDATA[".$riadok."]]></s3>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm65;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s4 ukazovatel=\"4560\"><![CDATA[".$riadok."]]></s4>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r065>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r066>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r66;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4561\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm66;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4562\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r066>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r067>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r67;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4563\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm67;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4564\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r067>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r068>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r68;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4565\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm68;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4566\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r068>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r069>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r69;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4567\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm69;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4568\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r069>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r070>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r70;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4569\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm70;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4570\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r070>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r071>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r71;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4571\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm71;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4572\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r071>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r072>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r72;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4573\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm72;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4574\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r072>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r073>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r73;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4575\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm73;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4576\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r073>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r074>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r74;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4577\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm74;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4578\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r074>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r075>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r75;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4579\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm75;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4580\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r075>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r076>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r76;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4581\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm76;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4582\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r076>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r077>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r77;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4583\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm77;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4584\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r077>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r078>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r78;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4585\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm78;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4586\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r078>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r079>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r79;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4587\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm79;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4588\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r079>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r080>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r80;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4589\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm80;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4590\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r080>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r081>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r81;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4591\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm81;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4592\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r081>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r082>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r82;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4593\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm82;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4594\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r082>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r083>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r83;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4595\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm83;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4596\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r083>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r084>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r84;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4597\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm84;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4598\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r084>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r085>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r85;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4599\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm85;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4600\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r085>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r086>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r86;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4601\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm86;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4602\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r086>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r087>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r87;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4603\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm87;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4604\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r087>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r088>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r88;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4605\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm88;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4606\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r088>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r089>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r89;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4607\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm89;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4608\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r089>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r090>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r90;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4609\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm90;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4610\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r090>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r091>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r91;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4611\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm91;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4612\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r091>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r092>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r92;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4613\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm92;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4614\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r092>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r093>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r93;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4615\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm93;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4616\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r093>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r094>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r94;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4617\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm94;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4618\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r094>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r095>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r95;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4619\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm95;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4620\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r095>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r096>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r96;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4621\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm96;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4622\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r096>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r097>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r97;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4623\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm97;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4624\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r097>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r098>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r98;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4625\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm98;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4626\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r098>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r099>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r99;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4627\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm99;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4628\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r099>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r100>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r100;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4629\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm100;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4630\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r100>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r101>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r101;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4631\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm101;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4632\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r101>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r102>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r102;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4633\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm102;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4634\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r102>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r103>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r103;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4635\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm103;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4636\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r103>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r104>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r104;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4637\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm104;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4638\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r104>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r105>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r105;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4639\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm105;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4640\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r105>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r106>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r106;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4641\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm106;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4642\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r106>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r107>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r107;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4643\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm107;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4644\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r107>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r108>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r108;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4585\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm108;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4646\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r108>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r109>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r109;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4647\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm109;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4648\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r109>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r110>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r110;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4649\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm110;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4650\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r110>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r111>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r111;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4651\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm111;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4652\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r111>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r112>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r112;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4653\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm112;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4654\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r112>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r113>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r113;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4655\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm113;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4656\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r113>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r114>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r114;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4657\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm114;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4658\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r114>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r115>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r115;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4659\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm115;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4660\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r115>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r116>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r116;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4661\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm116;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4662\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r116>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r117>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r117;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4663\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm117;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4664\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r117>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r118>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r118;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4665\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm118;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4666\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r118>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r119>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r119;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4667\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm119;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4668\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r119>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r120>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r120;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4669\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm120;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4670\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r120>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r121>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r121;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4671\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm121;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4672\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r121>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r122>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r122;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4673\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm122;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4674\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r122>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r123>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r123;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4675\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm123;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4676\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r123>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r124>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r124;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4677\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm124;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4678\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r124>"."\r\n";   fwrite($soubor, $text);

  $text = "  <r125>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->r125;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s5 ukazovatel=\"4679\"><![CDATA[".$riadok."]]></s5>"."\r\n";   fwrite($soubor, $text);
  $riadok=1*$hlavicka->rm125;
  if( $riadok == 0 ) $riadok="";
  $text = "    <s6 ukazovatel=\"4680\"><![CDATA[".$riadok."]]></s6>"."\r\n";   fwrite($soubor, $text);
  $text = "  </r125>"."\r\n";   fwrite($soubor, $text);

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
