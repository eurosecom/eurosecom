<HTML>
<?php
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

//toto je import ext_faktur z pohody fy ENII

       do
       {


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlctwin="width=300, height=' + vyskawin + ', top=0, left=400, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = strip_tags($_REQUEST['drupoh']);
$h_sys = 1*$_REQUEST['h_sys'];
if( $h_sys == 0 ) { echo "Podsystém SYS = ".$h_sys." ???"; exit; }
$h_obdp = $_REQUEST['h_obdp'];


//toto je import ext_faktur z pohody fy ENII

//naimportovanie ext.faktur
if ( $copern == 55 )
    {
$skl=55;
$poh=$h_obdp*100+55;



$kli_vrok2=$kli_vrok-2000;
$kli_vmes2=$h_obdp;
if( $kli_vrok2 < 10 ) $kli_vrok2="0".$kli_vrok2;
if( $kli_vmes2 < 10 ) $kli_vmes2="0".$kli_vmes2;
$nazovsuboru="uct".$kli_vrok2.$kli_vmes2;
$obdobie=$kli_vmes2.".20".$kli_vrok2;
//echo $nazovsuboru;

if ($_REQUEST["odeslano"]==1) 
{     
  if (move_uploaded_file($_FILES['original']['tmp_name'], "../import/$nazovsuboru.csv")) 
  { 
//tu bude import



//tuto vymaz fakodb a uctodb a ico
$sqty = "DELETE FROM F$kli_vxcf"."_fakodb WHERE skl = 55 AND poh = $poh ";
$ulozene = mysql_query("$sqty");

$sqty = "DELETE FROM F$kli_vxcf"."_uctodb WHERE poh = $poh ";
$ulozene = mysql_query("$sqty");

$ico=400000+$h_obdp*1000+1;
$icomax=400000+$h_obdp*1000+999;

$sqty = "DELETE FROM F$kli_vxcf"."_ico WHERE ico >= $ico AND ico <= $icomax ";
//$ulozene = mysql_query("$sqty");

$sqult = "DELETE FROM F$kli_vxcf"."_ico WHERE ico > 99999999 ";
//$ulozene = mysql_query("$sqult");

$doklad=1;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok >= 0 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $doklad=$riaddok->dok+1;
    }


$subor = fopen("../import/$nazovsuboru.csv", "r");
while (! feof($subor))
{

  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

//Èíslo;Dátum;Splatné;Firma;Meno;Celkom;K likvidácii;€2;DPH2;IÈO;DIÈ;IÈ DPH
//140100265;3.2.2014;17.2.2014;Zemanová Zdenka;Zemanová Zdenka;39,98 EUR;39,98 EUR;33,33 EUR;6,65 EUR;;;
//140100266;3.2.2014;17.2.2014;Lenka Rožoková;;60,90 EUR;60,90 EUR;50,75 EUR;10,15 EUR;44621108;1080304489;
//140100267;3.2.2014;17.2.2014;Galisin Simona;Galisin Simona;49,50 EUR;49,50 EUR;41,26 EUR;8,24 EUR;;;
//140100268;3.2.2014;17.2.2014;Szutyanyiova Lucia;Szutyanyiova Lucia;26,90 EUR;26,90 EUR;22,43 EUR;4,47 EUR;;;
//140100269;3.2.2014;17.2.2014;Šedivá Zuzana;;55,64 EUR;55,64 EUR;46,37 EUR;9,27 EUR;47000163;1085394915;

//Èíslo;Dátum;Splatné;Text;€2;DPH2;Firma;Meno;Celkom;K likvidácii;DIÈ;IÈO;IÈ DPH
//140100516;3.3.2014;17.3.2014;Fakturujeme Vám tovar pod¾a Vašej objednávky:;34,15;6,83;Chrastinova Mgr. Jana;Chrastinova Jana;40,98;40,98;;;
//140100517;3.3.2014;17.3.2014;Fakturujeme Vám tovar pod¾a Vašej objednávky:;9,70;1,94;Lengyelova Dominika;Lengyelova Dominika;11,64;0,00;;;


//Èíslo;Dátum;Splatné;Text;€2;DPH2;Firma;Meno;Celkom;K likvidácii;DIÈ;IÈO;IÈ DPH
//140100705;1.4.2014;15.4.2014;Fakturujeme Vám tovar pod¾a Vašej objednávky:;13,41;2,67;Karikova Miriam;Karikova Miriam;16,08;16,08;;;
//140100706;1.4.2014;15.4.2014;Fakturujeme Vám tovar pod¾a Vašej objednávky:;24,15;4,83;LILSTAV, s.r.o.;Miklošová Eva Lili;28,98;28,98;2023021099;45480699;

//Èíslo;Dátum;Splatné;Text;€2;DPH2;Firma;Meno;Celkom;K likvidácii;DIÈ;IÈO;IÈ DPH
//140100919;2.5.2014;16.5.2014;Fakturujeme Vám tovar pod¾a Vašej objednávky:;32,33;6,45;mStudio;Lehotská Martina;38,78;38,78;;45950920;
//140100920;2.5.2014;16.5.2014;Fakturujeme Vám tovar pod¾a Vašej objednávky:;50,85;10,15;Synáková Jana;Synáková Jana;61,00;61,00;;;
//140100921;2.5.2014;16.5.2014;Fakturujeme Vám tovar pod¾a Vašej objednávky:;42,39;8,49;Honzikova Lucia;Honzikova Lucia;50,88;50,88;;;


  $x_fak = $pole[0];
  $x_dat = $pole[1];
  $x_das = $pole[2];

  $x_nai = $pole[6];
  $x_na2 = $pole[7];

  $x_hod = $pole[8];
$x_hod=str_replace(" EUR","",$x_hod);
$x_hod=str_replace(",",".",$x_hod);
$x_hod=str_replace(" ","",$x_hod);

  $x_dz2 = $pole[4];
$x_dz2=str_replace(" EUR","",$x_dz2);
$x_dz2=str_replace(",",".",$x_dz2);
$x_dz2=str_replace(" ","",$x_dz2);

  $x_dh2 = $pole[5];
$x_dh2=str_replace(" EUR","",$x_dh2);
$x_dh2=str_replace(",",".",$x_dh2);
$x_dh2=str_replace(" ","",$x_dh2);

  $ico = 1*$pole[11];
if( $ico == 0 ) { $ico=1111; }

  $dic = 1*$pole[10];
  $icd = $pole[12];

  $dat_sql = SqlDatum($x_dat);
  $das_sql = SqlDatum($x_das);
  $daz_sql = SqlDatum($x_dat);
  $x_ume = $kli_vume;

$c_dh2=1*$x_dh2;

$x_sp2=$x_hod;
$x_dz0=0;
if( $c_dh2 == 0 ) { $x_dz0=$x_hod; $x_sp2=0; }

$x_uce=31110; $x_ucm=31110; $x_ucd1=60400; $x_ucd2=34300; $x_rdp=55;

//vs 13010316 31110/60410,34320 - slovenské faktúry (zabudli zmenit cislo na 14)
//vs 140100001 31110/60410,34320 slovenské faktury
//vs 201400001 31110/60410,34320 slovenske faktury easy
//vs 4200140006 31120/60420 vystavene faktury do ceskej republiky
//vs 3401400001 31134/60420 vystavene faktury do španielska
//vs 3901400002 31139/60420 vystavene faktury do talianska
//vs 140200001 

if( $x_fak >= 150100001  AND $x_fak <= 150199999  ) { $x_uce=31110; $x_ucm=31110; $x_ucd1=60410; $x_ucd2=34320; $x_rdp=55; }
if( $x_fak >= 1500100001 AND $x_fak <= 1500199999 ) { $x_uce=31110; $x_ucm=31110; $x_ucd1=60410; $x_ucd2=34320; $x_rdp=55; }
if( $x_fak >= 3901500001 AND $x_fak <= 3901509999 ) { $x_uce=31139; $x_ucm=31139; $x_ucd1=60420; $x_ucd2=34320; $x_rdp=55; }
if( $x_fak >= 420150001  AND $x_fak <= 420159999  ) { $x_uce=31120; $x_ucm=31120; $x_ucd1=60420; $x_ucd2=34320; $x_rdp=55; }
if( $x_fak >= 3401500001 AND $x_fak <= 3401509999 ) { $x_uce=31134; $x_ucm=31134; $x_ucd1=60420; $x_ucd2=34320; $x_rdp=55; }
if( $x_fak >= 3601500001 AND $x_fak <= 3601509999 ) { $x_uce=31136; $x_ucm=31136; $x_ucd1=60420; $x_ucd2=34320; $x_rdp=55; }


$sqult = "INSERT INTO F$kli_vxcf"."_fakodb ( uce,dok,doq,fak,ico,str,zak,dat,daz,das,zk2,dn2,sp2,hod,id,".
"zk1,dn1,sp1,zk0,zao,zal,ruc,uhr,zk3,zk4,dn3,dn4,sz1,sz2,sz3,sz4,dol,prf,skl,poh,dav,".
"obj,unk,dpr,ksy,ssy,poz,txz,txp,ume,hodu,zk0u,zk2u,dn2u,zk1u,dn1u,sp1u,sp2u,".
"zmen,mena,kurz,hodm)".
" VALUES ( '$x_uce', '$doklad', '$doklad', '$x_fak', '$ico', '$x_str', '$x_zak', '$dat_sql', '$daz_sql', '$das_sql',".
" '$x_dz2', '$x_dh2', '$x_sp2', '$x_hod', '$kli_uzid',".
" '$x_dz5', '$x_dh5', '$x_sp1', '$x_dz0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$x_fak', '0', '0', '0', '$skl', '$poh', '$x_dav',".
" '', '', '', '$x_ksy', '$x_ssy', '', '$x_nai', '$x_pop', '$x_ume', '$x_hod','$x_dz0', '$x_dz2', '$x_dh2','$x_dz5', '$x_dh5', '$x_sp1', '$x_sp2',  ".
" '$zmen', '$x_mena', '$x_kurz', '$x_hodm' );";

$ulozene = mysql_query("$sqult"); 
//echo $sqult;


if( $x_dh2 == 0 ) { $x_rdp=61;  $x_dz2=$x_hod;  }

$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$doklad', '$poh', '$x_ucm', '$x_ucd1', '$x_rdp', 0, '$x_dz2', '$ico', '$x_fak', '$x_pop', '$x_str', '$x_zak', '', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");

if( $x_dh2 != 0 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$doklad', '$poh', '$x_ucm', '$x_ucd2', '$x_rdp', 0, '$x_dh2', '$ico', '$x_fak', '$x_pop', '$x_str', '$x_zak', '', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");
  }

$x_ucb=0;
$x_num=0;
$x_mes="sidlo";

 
$sqult = "INSERT INTO F$kli_vxcf"."_ico ( ico,icd,dic,nai,uli,mes,psc,tel,fax,em1,www,nm1,uc1,nm2,uc2,nm3,uc3,dns)".
" VALUES ( '$ico', '$icd', '$dic', '$x_nai', '$x_uli', '$x_mes', '$x_psc', '$x_tel', '$x_fax', '$x_ema', '$x_www',".
" '$x_num', '$x_ucb', '$x_num2', '$x_ucb2', '$x_num3', '$x_ucb3', '$x_dns'".
"  );";
if( $ico > 1111 ) { $ulozene = mysql_query("$sqult"); }


$ico=$ico+1;
$doklad=$doklad+1;
//koniec while
}
fclose ($subor);

//exit;

//koniec importu
  }

$copern=10;
}
//koniec if odeslano
else 
{
?> 
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?copern=55&drupoh=1&page=1&h_sys=<?php echo $h_sys; ?>&h_obdp=<?php echo $h_obdp; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="20%" align="right" >Súbor <?php echo $nazovsuboru; ?>.csv SYS <?php echo $h_sys; ?>:</td> 
        <td  width="60%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE="700000" > 
        <input type="file" name="original" size="60"> 
        </td> 
        <td  width="20%" align="left" >(max. 700 kB)</td> 
      </tr> 
      <tr> 
        <td colspan="3"> 
              <input type="hidden" name="odeslano" value="1"> 
          <p align="center"><input type="submit" value="Naèíta"></td> 
      </tr> 
    </table> 
    </form> 
<?php 
} 
//koniec else neodeslano


    }
//koniec naimportovanie faktur


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Import faktúr</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0; z-index: 300;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>


</HEAD>

<BODY class="white" id="white" onload="" >



<table class="h2" width="100%" >
<tr>
<td>EuroSecom-Import externých faktúr SYS <?php echo $h_sys; ?> obdobie <?php echo $kli_vume; ?> </td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<br />

<?php
if( $copern == 10 )
{
?>
OK
<script type="text/javascript">
    window.open('../faktury/vstfak.php?copern=1&drupoh=1001&page=1&pocstav=0', '_self' );
</script>
<?php
}
?>



<?php

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
