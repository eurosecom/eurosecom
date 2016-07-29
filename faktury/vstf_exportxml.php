<HTML>
<?php

do
{
$sys = 'FAK';
$urov = 2000;
$drupoh = $_REQUEST['drupoh'];


$uziv = include("../uziv.php");
if( !$uziv ) exit;

$copern = $_REQUEST['copern'];
$cislo_dok = $_REQUEST['cislo_dok'];
$hladaj_uce = $_REQUEST['hladaj_uce'];
$citfir = include("../cis/citaj_fir.php");

$hhmmss = Date ("is", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

 $outfilexdel="../tmp/odberfak_".$cislo_dok."_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/odberfak_".$cislo_dok."_".$kli_uzid."_".$hhmmss.".xml";
if (File_Exists ("$outfilex")) { $soubor = unlink("$outfilex"); }

$databaza="";


$restt2 = "SELECT * FROM ".$databaza."F".$kli_vxcf."_fakodb WHERE dok = $cislo_dok ORDER BY dok ";
$resul2 = mysql_query("$restt2");
if (mysql_num_rows($resul2) > 0) 
  { 
$resul2 = mysql_fetch_array($resul2);
$icox = $resul2["ico"];
$datx = $resul2["dat"];
$dasx = $resul2["das"];
$dazx = $resul2["daz"];
$vsyx = $resul2["fak"];
$ksyx = $resul2["ksy"];
$ssyx = $resul2["ssy"];

$zk0 = 1*$resul2["zk0"];
$zk1 = 1*$resul2["zk1"];
$zk2 = 1*$resul2["zk2"];
$dn1 = 1*$resul2["dn1"];
$dn2 = 1*$resul2["dn2"];
$hod = 1*$resul2["hod"];
  } 

$restt3 = "SELECT * FROM ".$databaza."F".$kli_vxcf."_ufir ";
$resul3 = mysql_query("$restt3");
if (mysql_num_rows($resul3) > 0) 
  { 
$resul3 = mysql_fetch_array($resul3);

$oico = $resul3["fico"];
$odic = $resul3["fdic"];
$oicd = $resul3["ficd"];
$onai = $resul3["fnaz"];
$ouli = $resul3["fuli"]." ".$resul3["fcdm"];
$omes = $resul3["fmes"];
$opsc = $resul3["fpsc"];
$otel = $resul3["ftel"];
$omail = $resul3["fem1"];
$owww = $resul3["fwww"];
$oib = $resul3["fib1"];
$obc = $resul3["fsw1"];


$onai = iconv("CP1250", "UTF-8", $onai);
$ouli = iconv("CP1250", "UTF-8", $ouli);
$omes = iconv("CP1250", "UTF-8", $omes);
$opsc = iconv("CP1250", "UTF-8", $opsc);
$otel = iconv("CP1250", "UTF-8", $otel);
$omail = iconv("CP1250", "UTF-8", $omail);
$owww = iconv("CP1250", "UTF-8", $owww);

  } 


$resttt = "SELECT * FROM ".$databaza."F".$kli_vxcf."_ico WHERE ico = $icox ORDER BY ico ";
$result = mysql_query("$resttt");

if (mysql_num_rows($result) > 0) 
  {
 
$result = mysql_fetch_array($result);
 
$product = array();
$product["ico"] = $result["ico"];
$product["dic"] = $result["dic"];
$product["icd"] = $result["icd"];

$nai = $result["nai"];
$uli = $result["uli"];
$mes = $result["mes"];
$psc = $result["psc"];
$tel = $result["tel"];
$mail = $result["em1"];
$www = $result["www"];

$pole1 = explode("-", $result["ib1"]);
$h_ib1 = $pole1[0];
$h_st1 = $pole1[1];

$nai = iconv("CP1250", "UTF-8", $nai);
$uli = iconv("CP1250", "UTF-8", $uli);
$mes = iconv("CP1250", "UTF-8", $mes);
$psc = iconv("CP1250", "UTF-8", $psc);
$tel = iconv("CP1250", "UTF-8", $tel);
$mail = iconv("CP1250", "UTF-8", $mail);
$www = iconv("CP1250", "UTF-8", $www);

  }



$prodnai="<?xml version = \"1.0\" encoding=\"utf-8\" standalone=\"yes\" ?>"."\n";
$prodnai=$prodnai."<inv>"."\n";
$prodnai=$prodnai."<ico>".$result["ico"]."</ico>"."\n";
$prodnai=$prodnai."<dic>".$result["dic"]."</dic>"."\n";
$prodnai=$prodnai."<icd>".$result["icd"]."</icd>"."\n";
$prodnai=$prodnai."<nai>".$nai."</nai>"."\n";
$prodnai=$prodnai."<uli>".$uli."</uli>"."\n";
$prodnai=$prodnai."<mes>".$mes."</mes>"."\n";
$prodnai=$prodnai."<psc>".$psc."</psc>"."\n";
$prodnai=$prodnai."<tel>".$tel."</tel>"."\n";
$prodnai=$prodnai."<ema>".$mail."</ema>"."\n";
$prodnai=$prodnai."<iba>".$h_ib1."</iba>"."\n";
$prodnai=$prodnai."<bic>".$h_st1."</bic>"."\n";

$prodnai=$prodnai."<fak>".$vsyx."</fak>"."\n";

$prodnai=$prodnai."<dat>".$datx."</dat>"."\n";
$prodnai=$prodnai."<das>".$dasx."</das>"."\n";
$prodnai=$prodnai."<daz>".$dazx."</daz>"."\n";
$prodnai=$prodnai."<vsy>".$vsyx."</vsy>"."\n";
$prodnai=$prodnai."<ksy>".$ksyx."</ksy>"."\n";
$prodnai=$prodnai."<ssy>".$ssyx."</ssy>"."\n";

$prodnai=$prodnai."<zk0>".$zk0."</zk0>"."\n";
$prodnai=$prodnai."<zk1>".$zk1."</zk1>"."\n";
$prodnai=$prodnai."<zk2>".$zk2."</zk2>"."\n";
$prodnai=$prodnai."<dn1>".$dn1."</dn1>"."\n";
$prodnai=$prodnai."<dn2>".$dn2."</dn2>"."\n";
$prodnai=$prodnai."<hod>".$hod."</hod>"."\n";

$prodnai=$prodnai."<oico>".$oico."</oico>"."\n";
$prodnai=$prodnai."<odic>".$odic."</odic>"."\n";
$prodnai=$prodnai."<oicd>".$oicd."</oicd>"."\n";
$prodnai=$prodnai."<onai>".$onai."</onai>"."\n";
$prodnai=$prodnai."<ouli>".$ouli."</ouli>"."\n";
$prodnai=$prodnai."<omes>".$omes."</omes>"."\n";
$prodnai=$prodnai."<opsc>".$opsc."</opsc>"."\n";
$prodnai=$prodnai."<otel>".$otel."</otel>"."\n";
$prodnai=$prodnai."<oema>".$omail."</oema>"."\n";
$prodnai=$prodnai."<oiba>".$oib."</oiba>"."\n";
$prodnai=$prodnai."<obic>".$obc."</obic>"."\n";

$prodnai=$prodnai."</inv>"."\n";

$soubor = fopen("$outfilex", "a+");


fwrite($soubor, $prodnai);

fclose($soubor);

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Export faktúry</title>

</HEAD>
<BODY class="white" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom 
<?php
  if ( $copern == 20 ) echo "- Export faktúry èíslo $cislo_dok do súboru XML";

?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php

?>
<br />
<br />
Stiahnite si nižšie uvedený súbor XML na Váš lokálny disk:
<br />
<br />
<a href="<?php echo $outfilex; ?>"><?php echo $outfilex; ?></a>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>