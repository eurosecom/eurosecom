<HTML>
<?php
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

//toto je import externych dobropisov ramex sys 59

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


//naimportovanie ext.faktur
if ( $copern == 55 )
    {
$skl=$h_sys;
$poh=$h_obdp*100+$h_sys;



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
$sqty = "DELETE FROM F$kli_vxcf"."_fakodb WHERE skl = $h_sys AND poh = $poh ";
$ulozene = mysql_query("$sqty");

$sqty = "DELETE FROM F$kli_vxcf"."_uctodb WHERE poh = $poh ";
$ulozene = mysql_query("$sqty");

$ico=400000+$h_obdp*1000+1;
$icomax=400000+$h_obdp*1000+999;


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

//0Credit No.;1Invoice No.;2Created;3Order no.;4Order Date;5Customer Id;6Name in the Invoice;7Status;8Gross Amount;9Net Amount;10VAT Amount;11Refunded;12Refunded in EUR
//200000002;53160004;2016-03-16 12:32:14;200150009;2016-03-01 13:17:00;;Martin Lazár;Uzavretá;664.25;553.54;110.71;CZK 664.25;EUR 24.56
//100000001;43160039;2016-10-04 06:51:20;120150070;2016-09-28 11:51:35;150;Pavel Sokol;Expedovaná;185.15;154.29;30.86;EUR 185.15;EUR 185.15
//200000003;;2016-10-27 20:31:44;200150039;2016-10-27 20:29:09;270;Adam Glumbik;Nová;380.25;316.88;63.37;CZK 380.25;EUR 14.08


  $x_fak = 1*$pole[0];
  $x_obj = $pole[4];  
  $x_dav = $pole[1];

  $x_dattime = $pole[2];
  $dat_sql=substr($x_dattime,0,10);
  $das_sql=$dat_sql;
  $daz_sql=$dat_sql;

$poled = explode("-", $dat_sql);
$rok_dat=$poled[0];
$mes_dat=$poled[1];
$den_dat=$poled[2];

  $ber_ume = $mes_dat.".".$rok_dat;
  $ber_ume = 1*$ber_ume;

//echo "ber_ume".$ber_ume."ber_ume<br />";


  $x_nai = $pole[6];
  $x_na2 = "";


  $x_hodm = $pole[11];
  $zmen=0;
  $x_mena=substr($x_hodm,0,3);

$x_hodm=str_replace("EUR","",$x_hodm);
$x_hodm=str_replace("CZK","",$x_hodm);
$x_hodm=str_replace("USD","",$x_hodm);
$x_hodm=str_replace(",",".",$x_hodm);
$x_hodm=str_replace(" ","",$x_hodm);
$x_hodm=-1*$x_hodm;
//echo "hodm".$x_hodm."hodm<br />";

  $x_hod = $pole[12];
$x_hod=str_replace("EUR","",$x_hod);
$x_hod=str_replace("CZK","",$x_hod);
$x_hod=str_replace("USD","",$x_hod);
$x_hod=str_replace(",",".",$x_hod);
$x_hod=str_replace(" ","",$x_hod);
$x_hod=-1*$x_hod;
//echo "hod".$x_hod."hod<br />";

  $x_dz2 = $pole[9];
$x_dz2=str_replace("EUR","",$x_dz2);
$x_dz2=str_replace("CZK","",$x_dz2);
$x_dz2=str_replace("USD","",$x_dz2);
$x_dz2=str_replace(",",".",$x_dz2);
$x_dz2=str_replace(" ","",$x_dz2);
$x_dz2=-1*$x_dz2;
//echo "dz2".$x_dz2."dz2<br />";

  $x_dh2 = $pole[10];
$x_dh2=str_replace("EUR","",$x_dh2);
$x_dh2=str_replace("CZK","",$x_dh2);
$x_dh2=str_replace("USD","",$x_dh2);
$x_dh2=str_replace(",",".",$x_dh2);
$x_dh2=str_replace(" ","",$x_dh2);
$x_dh2=-1*$x_dh2;


  if( $x_mena == "CZK" OR $x_mena == "USD" ) { $zmen=1; $x_kurz=0;}
  if( $zmen == 0 ) { $x_hodm=0; $x_kurz=0; }
  if( $zmen == 1 ) 
  {
  $x_kurz=$x_hodm/$x_hod;
  $x_dh2=$x_dh2/$x_kurz;
  $x_dz2=$x_hod-$x_dh2;
  }


  $ico = 1*$pole[5];
if( $ico == 0 ) { $ico=1111; }

  $dic = "";
  $icd = "";

  $x_ume = 1*$kli_vume;
  

$c_dh2=1*$x_dh2;

$x_sp2=$x_hod;
$x_dz0=0;
if( $c_dh2 == 0 ) { $x_dz0=$x_hod; $x_sp2=0; }

$x_uce=31100; $x_ucm=31100; $x_ucd1=60400; $x_ucd2=34300; $x_rdp=55;

if( $x_fak > 0 AND $x_ume == $ber_ume ) 
        {

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
//echo $sqult."<br />";


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
if( $ico > 0 ) { $ulozene = mysql_query("$sqult"); }


$ico=$ico+1;
$doklad=$doklad+1;
//koniec while

//koniec if( $x_fak > 0 ) 
        }

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
<td>EuroSecom-Import externých dobropisov SYS <?php echo $h_sys; ?> obdobie <?php echo $kli_vume; ?> </td>
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
