<HTML>
<?php
$sys = 'UCT';
$urov = 2000;
$cslm=100080;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {
//5=novy doklad zadavanie udajov po vyplneni ide na 68 ulozi a vrati sa do vstpok.php ako copern=1
//6=vymazanie faktury  po odsuhlaseni sa vrati sa do vstpok.php ako copern na 16
//8=uprava dokladu po vyplneni ide na 78 ulozi a vrati sa do vstpok.php ako copern na 1
//7=z novej 5 alebo upravy 8 po odpaleni sluzby ulozi 68 alebo 78 hlavicku a ide na vstup sluzieb
//77=ulozenie polozky sluzby do uctpok a naspat do copern na 7
//36=vymazanie polozky sluzby a naspat do copern na 7
//87=vybral som polozku sluzieb na upravu a 88 update upravenej a naspat do copern na 7
//97=vybral som textovu polozku sluzieb na upravu a 98 update upravenej textovej a naspat do copern na 7

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

$tlacitkoenter=0;
//if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $tlacitkoenter=1; }
if( $copern == 6 ) { $tlacitkoenter=0; }

$kontrolastrzak=0;
if( $poliklinikase == 1 ) $kontrolastrzak=1;
if( $kontrolstrzak == 1 ) $kontrolastrzak=1;

$textpopis=0;
if( $kli_vduj == 9 ) $textpopis=1;
if( $kli_vduj != 9 AND $fir_uctx02 == 1 ) $textpopis=1;

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvfak";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvskl = include("../faktury/vtvfak.php");
endif;

$sql = "SELECT ddu FROM F$kli_vxcf"."_uctban";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_uctban ADD ddu DATE NOT NULL AFTER dok ";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_uctban,F$kli_vxcf"."_banvyp".
" SET ddu=dat WHERE F$kli_vxcf"."_uctban.dok=F$kli_vxcf"."_banvyp.dok ";
$oznac = mysql_query("$sqtoz");

               }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlctwin="width=300, height=' + vyskawin + ', top=0, left=400, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = strip_tags($_REQUEST['drupoh']);
$hladaj_uce = $_REQUEST['hladaj_uce'];

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';

$ucto_sys=$_SESSION['ucto_sys'];
//echo $ucto_sys;
if( $ucto_sys == 1 )
{
$rozuct='ANO';
$sysx='UCT';
}

$page = strip_tags($_REQUEST['page']);
$cislo_dok = strip_tags($_REQUEST['cislo_dok']);
$h_uce = strip_tags($_REQUEST['h_uce']);

if( $drupoh == 5 ) { if( $h_uce != 2 ) { $h_uce=1; } }

if(!isset($hladaj_uce)) $hladaj_uce = $h_uce;
if( $h_uce == 0 ) $h_uce = $hladaj_uce;
$h_dok = strip_tags($_REQUEST['h_dok']);
$h_dat = strip_tags($_REQUEST['h_dat']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_nai = strip_tags($_REQUEST['h_nai']);
$h_poz = strip_tags($_REQUEST['h_poz']);
$h_kto = strip_tags($_REQUEST['h_kto']);
$h_txp = strip_tags($_REQUEST['h_txp']);
$h_txz = strip_tags($_REQUEST['h_txz']);

//echo $h_uce;

$newdok = strip_tags($_REQUEST['newdok']);
$h_zal = strip_tags($_REQUEST['h_zal']);
$h_hod = strip_tags($_REQUEST['h_hod']);
$h_zk0 = strip_tags($_REQUEST['h_zk0']);
$h_zk1 = strip_tags($_REQUEST['h_zk1']);
$h_zk2 = strip_tags($_REQUEST['h_zk2']);
$h_zk3 = strip_tags($_REQUEST['h_zk3']);
$h_zk4 = strip_tags($_REQUEST['h_zk4']);
$h_dn1 = strip_tags($_REQUEST['h_dn1']);
$h_dn2 = strip_tags($_REQUEST['h_dn2']);
$h_dn3 = strip_tags($_REQUEST['h_dn3']);
$h_dn4 = strip_tags($_REQUEST['h_dn4']);
$h_sz1 = strip_tags($_REQUEST['h_sz1']);
$h_sz2 = strip_tags($_REQUEST['h_sz2']);
$h_sz3 = strip_tags($_REQUEST['h_sz3']);
$h_sz4 = strip_tags($_REQUEST['h_sz4']);
$h_sp1 = strip_tags($_REQUEST['h_sp1']);
$h_sp2 = strip_tags($_REQUEST['h_sp2']);
$h_sp3 = strip_tags($_REQUEST['h_sp3']);
$h_sp4 = strip_tags($_REQUEST['h_sp4']);
$h_obj = strip_tags($_REQUEST['h_obj']);
$h_unk = strip_tags($_REQUEST['h_unk']);
$zmen = strip_tags($_REQUEST['zmen']);
$mena = strip_tags($_REQUEST['mena']);
$kurz = strip_tags($_REQUEST['kurz']);
$h_zmena = strip_tags($_REQUEST['h_zmena']);
if( $h_zmena != 1 ) { $zmen=0; $mena=''; $kurz=0; }

//echo $zmen." ".$mena." ".$kurz;

$hlat = strip_tags($_REQUEST['hlat']);
$vybr = strip_tags($_REQUEST['vybr']);
$hlat_ico = strip_tags($_REQUEST['h_ico']);
$hlat_nai = strip_tags($_REQUEST['h_nai']);

$cislo_dok = strip_tags($_REQUEST['cislo_dok']);

$rozb1 = strip_tags($_REQUEST['rozb1']);
$rozb2 = strip_tags($_REQUEST['rozb2']);
$h_tlsl = strip_tags($_REQUEST['h_tlsl']);
$sluz1 = 'MALE';
if( $h_tlsl == 1 AND $rozb2 == 'NOT' ) $sluz1 = 'VELKE';
$h_tltv = strip_tags($_REQUEST['h_tltv']);
$tov1 = 'MALE';
if( $h_tltv == 1 AND $rozb2 == 'NOT'  ) $tov1 = 'VELKE';

$hlas = strip_tags($_REQUEST['hlas']);

$mazanie=0;

$h_cpl = strip_tags($_REQUEST['h_cpl']);
$h_ucm = strip_tags($_REQUEST['h_ucm']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);
$h_rdp = strip_tags($_REQUEST['h_rdp']);
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_fak = strip_tags($_REQUEST['h_fak']);
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_pop = strip_tags($_REQUEST['h_pop']);
$h_hop = strip_tags($_REQUEST['h_hop']);


if ( $rozb2 == 'VELKE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'VELKE' AND $copern == 78) $copern=18;
if ( $rozb2 == 'MALE' AND $copern == 68) $copern=15;
if ( $rozb2 == 'MALE' AND $copern == 78) $copern=18;

if( $drupoh == 1 )
{
$tabl = "pokpri";
$cisdok = "pokpri";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "PrijatÈ od";
if( $copern == 5 )
    {
$odber=1;
$dodav=1;
$saldo_subor = include("saldo_subor.php"); 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
    }
}
if( $drupoh == 3 )
{
$tabl = "doppokpri";
$cisdok = "xdp05";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "PrijatÈ od";
}
if( $drupoh == 31 )
{
$tabl = "doppokpri";
$cisdok = "xdp05";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "PrijatÈ od";
}
if( $drupoh == 2 )
{
$tabl = "pokvyd";
$cisdok = "pokvyd";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "VyplatenÈ komu";
if( $copern == 5 )
    {
$odber=1;
$dodav=1;
$saldo_subor = include("saldo_subor.php"); 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
    }
}
if( $drupoh == 4 )
{
$tabl = "banvyp";
$cisdok = "uctx04";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "V˝pis z ˙Ëtu";
if( $copern == 5 )
    {
$odber=1;
$dodav=1;
$saldo_subor = include("saldo_subor.php"); 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
    }
}
if( $drupoh == 5 )
{
$tabl = "uctvsdh";
$cisdok = "uctx05";
if( $hladaj_uce == 2 ) $cisdok = "uctx13";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Firma";
if( $copern == 5 )
    {
$odber=1;
$dodav=1;
$saldo_subor = include("saldo_subor.php"); 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
    }
}

$uctpok="uctpok";
if( $rozuct == 'ANO' ) { $uctpok="uctpokuct"; }
if( $drupoh == 4 ) { $uctpok="uctban"; }
if( $drupoh == 5 ) { $uctpok="uctvsdp"; }

//echo $drupoh;

//naimportovanie banky TATRABANKA textove ulozenie v Internetbankingu verzia 4.8.4
//------------+------------+------------------+------+--------+--------+------------+---------+------------+------------+------------+------------------------------------------------------------------------+------------------------------------------------------------------------+
//Datum       | Datum      | Suma             | Mena | Typ    | Prefix | Cislo      | Kod     | Konstantny | Variabilny | Specificky | Ucel Platby                                                            | Popis                                                                  |
//Spracovania | Zuctovania |                  |      | Platby | Uctu   | Uctu       | Banky   | Symbol     | Symbol     | Symbol     |                                                                        |                                                                        |
//------------+------------+------------------+------+--------+--------+------------+---------+------------+------------+------------+------------------------------------------------------------------------+------------------------------------------------------------------------+
//24.09.2008  | 24.09.2008 |          3640.00 | SKK  | Kredit |        | 2628750463 | TATR    | 308        | 280729     |            | LACKO KAROL ING.-NOB                                                   | CCTB   1100/000000-2628750463                                          |
//24.09.2008  | 24.09.2008 |         13695.00 | SKK  | Debet  |        | 2624000366 | 1100    | 308        | 11081861   |            | Tatra Leasing s.r.o.                                                   | CSO  TATR   /000000-2624000366                                         |
//------------+------------+------------------+------+--------+--------+------------+---------+------------+------------+------------+------------------------------------------------------------------------+------------------------------------------------------------------------+


//naimportovanie banky TATRABANKA textove ulozenie v Internetbankingu verzia 5.0.1
//-------------+------------+----------+------+--------+------------+------------+-------+------------+------------+------------+--------------------------+--------------------------------
// D·tum       | D·tum      |     Suma | Mena | Typ    | PredËÌslie | »Ìslo ˙Ëtu | KÛd   | Konötantn˝ | Variabiln˝ | äpecifick˝ | ⁄Ëel platby              | Popis                          
// spracovania | z˙Ëtovania |          |      |        |            |            | banky | symbol     | symbol     | symbol     |                          |                                
//-------------+------------+----------+------+--------+------------+------------+-------+------------+------------+------------+--------------------------+--------------------------------
// 14.10.2013  | 14.10.2013 |    20,00 |  EUR | Debet  |            | 2278166653 |  200  | 308        | 11013186   |            | YellowNET  11013186      | CCINT  0200/000000-2278166653  
// 14.10.2013  | 14.10.2013 |     5,00 |  EUR | Debet  |            | 1001018151 |  200  | 308        | 7297871426 |            | Fa SPP 7297871426 /EDcom | CCINT  0200/000000-1001018151  

//potom to este zmenili od 6.11.2013
//-------------+------------+----------+------+--------+------------+------------+-------+--------------------------+------------+------------+------------+---------------------------+-------------------------------------------------------------------+--------------------------------
// D·tum       | D·tum      |     Suma | Mena | Typ    | PredËÌslie | »Ìslo ˙Ëtu | KÛd   | IBAN                     | Variabiln˝ | äpecifick˝ | Konötantn˝ | Referencia platiteæa      | Inform·cia pre prÌjemcu                                           | Popis                          
// spracovania | z˙Ëtovania |          |      |        |            |            | banky |                          | symbol     | symbol     | symbol     |                           |                                                                   |                                
//-------------+------------+----------+------+--------+------------+------------+-------+--------------------------+------------+------------+------------+---------------------------+-------------------------------------------------------------------+--------------------------------
// 06.11.2013  | 06.11.2013 |   436,62 |  EUR | Debet  |            |   25682423 | 7500  | SK1275000000000025682423 | 145729325  |            | 8          | /VS145729325/SS/KS8       | Alza  PF 145729325                                                | CCINT 7500/000000-0025682423   
// 06.11.2013  | 06.11.2013 |    15,00 |  EUR | Kredit |            | 1631817556 |  200  | SK3802000000001631817556 | 130490     | 321002     |  308       | /VS130490/SS321002/KS0308 |                                                                   | PLATBA 0200/000000-1631817556  


if ( $copern == 551 )
    {
$tatra = 1*strip_tags($_REQUEST['tatra']);

if ($_REQUEST["odeslano"]==1) 
{     
  if (move_uploaded_file($_FILES['original']['tmp_name'], "../import/tatrabanka.csv")) 
  { 
//tu bude import

$subor = fopen("../import/tatrabanka.csv", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";

if( $tatra == 1 ) 
  {
  $pole = explode("|", $riadok);
  $x_das = $pole[0];
  $x_dau = $pole[1];
  $x_hod = $pole[2];
  $x_men = $pole[3];
  $x_kad = trim($pole[4]);
  $x_prx = $pole[5];
  $x_ucb = $pole[6];
  $x_num = $pole[7];

  $x_ibn = $pole[8];

  $x_vsy = $pole[9];
  $x_ssy = $pole[10];
  $x_ksy = $pole[11];

  $x_rfr = $pole[12];

  $x_txt = trim($pole[13])." ".trim($pole[14]);
  $x_pop = $pole[14];
  $x_kon = $pole[15];

  $x_hod=str_replace(" ","",$x_hod);
  $x_hod=str_replace(",",".",$x_hod);
  }

//naimportovanie banky TATRABANKA CSV ulozenie v programe GEMINI
//,,,0000629149,ALCHEM SPOL. S R.O.,0000000000,2009.306.000270237728,2009,,,,4116204a6,,,,108754.62,10000,1007000000,pokracuje riadok
//ALCHEM SPOL. S R.O. ,81847.96,000000 2625230665,,20091102,1,EUR,,TATR,,1013000034,1,,000000 2622846333,20091102,N,C,,,,,BEZ,,,0000000308,,10000,44,213

if( $tatra == 2 ) 
  {
  $pole = explode(",", $riadok);
  $x_vsy = 1*$pole[3];
  $x_hod = $pole[19];
  $x_das = $pole[22];
  $dasr=substr($x_das,0,4);
  $dasm=substr($x_das,3,2);
  $dasd=substr($x_das,5,2);
  $x_das = $dasd.".".$dasm.".".$dasr;
  $x_dau = $x_das;
  $x_men = $pole[24];
  $x_ucb = $pole[31];
  $x_num = $pole[26];
  $x_ksy = $pole[42];

  $x_kad = "Kredit";
  $x_prx = "";

  $x_ssy = "";
  $x_txt = "";
  $x_pop = "";
  $x_kon = "";

//echo $riadok; echo " vsy ".$x_vsy;
  }

//"D·tum spracovania","D·tum z˙Ëtovania",Suma,Mena,Typ,"PredËÌslie","»Ìslo ˙Ëtu","KÛd banky","Konötantn˝ symbol","Variabiln˝ symbol","äpecifick˝ symbol","⁄Ëel platby",Popis
//07.10.2013,07.10.2013,"13,67",EUR,Debet,,2623805672,1100,308,613066463,,pr.reg. bbsisro.sk 613066463,PREVOD / INTERNET   2623805672

//potom to este zmenili od 6.11.2013
//"D·tum spracovania","D·tum z˙Ëtovania",Suma,Mena,Typ,"PredËÌslie","»Ìslo ˙Ëtu","KÛd banky",IBAN,"Variabiln˝ symbol","äpecifick˝ symbol","Konötantn˝ symbol","Referencia platiteæa","Inform·cia pre prÌjemcu",Popis
//06.11.2013,06.11.2013,"305,00",EUR,Debet,,2629028595,1100,SK6811000000002629028595,8005243074,,558,/VS8005243074/SS/KS558,MALLSK PF 8005243074,CCINT 1100/000000-2629028595
//06.11.2013,06.11.2013,"436,62",EUR,Debet,,  25682423,7500,SK1275000000000025682423,145729325,,8,/VS145729325/SS/KS8,Alza  PF 145729325,CCINT 7500/000000-0025682423


if( $tatra == 3 ) 
  {
  $pole = explode(",", $riadok);
  $x_das = $pole[0];
  $x_dau = $pole[1];
  $x_hodc = $pole[2];
  $x_hodd = $pole[3];
  $x_men = $pole[4];
  $x_kad = trim($pole[5]);
  $x_prx = $pole[6];
  $x_ucb = $pole[7];
  $x_num = $pole[8];

  $x_ibn = $pole[9];

  $x_vsy = $pole[10];
  $x_ssy = $pole[11];
  $x_ksy = $pole[12];

  $x_rfr = $pole[13];

  $x_txt = trim($pole[14])." ".trim($pole[15]);
  $x_pop = $pole[15];
  $x_kon = $pole[16];

  $x_hodc=str_replace("\"","",$x_hodc);
  $x_hodd=str_replace("\"","",$x_hodd);
  $x_hod = $x_hodc.".".$x_hodd;
  }

$ddusql=SqlDatum($x_dau);

$c_hod=1*$x_hod;
$c_ucb=1*$x_ucb;
$c_vsy=1*$x_vsy;
$x_txx="˙Ëet".$x_ucb." ".$x_num." popis ".$x_txt;

$h_ucm=$h_uce;
$h_ucd=0;
$h_ico=0;
$nasielico=0;
$podvojne=1;
if( $kli_vduj== 9 ) { $podvojne=0; }
if( $x_kad == 'Kredit' ) 
{
//echo "robim kredit";
$h_ucm=$h_uce;
$h_udm=$h_uce;
$h_ucd=31100;
if( $c_vsy == 0 AND $podvojne == 1 ) { $h_ucd=26100; }
$sqlico = mysql_query("SELECT uce,ico,hod,dn1,dn2 FROM F$kli_vxcf"."_fakodb WHERE fak = '$x_vsy' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $h_ucd=$riadico->uce;
  $h_ico=$riadico->ico;
  $h_hdp=$riadico->dn1+$riadico->dn2;
  $nasielico=1;
  }
if( $nasielico == 0 ) 
{
$sqlico = mysql_query("SELECT uce,ico,hod,dn1,dn2 FROM F$kli_vxcf"."_fakodbpoc WHERE fak = '$x_vsy' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $h_ucd=$riadico->uce;
  $h_ico=$riadico->ico;
  $h_hdp=$riadico->dn1+$riadico->dn2;
  $nasielico=1;
  }
}

if( $podvojne == 0 ) { $h_ucd=60; $h_udd=34399; }
$sqtz = "UPDATE F$kli_vxcf"."_banvyp SET zk0u=zk0u+'$x_hod', zk2u=zk2u+'$x_hod'".
" WHERE dok='$cislo_dok'";
//echo $sqtz;
$upravene = mysql_query("$sqtz"); 
}
if( $x_kad == 'Debet' )
{
$h_ucm=32100;
if( $c_vsy == 0 AND $podvojne == 1 ) { $h_ucm=26100; }
$h_ucd=$h_uce;
$h_udd=$h_uce;
$sqlico = mysql_query("SELECT uce,ico,hod,dn1,dn2 FROM F$kli_vxcf"."_fakdod WHERE fak = '$x_vsy' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $h_ucm=$riadico->uce;
  $h_ico=$riadico->ico;
  $h_hdp=$riadico->dn1+$riadico->dn2;
  $nasielico=1;
  }
if( $nasielico == 0 ) 
{
$sqlico = mysql_query("SELECT uce,ico,hod,dn1,dn2 FROM F$kli_vxcf"."_fakdodpoc WHERE fak = '$x_vsy' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $h_ucm=$riadico->uce;
  $h_ico=$riadico->ico;
  $h_hdp=$riadico->dn1+$riadico->dn2;
  $nasielico=1;
  }
}
if( $podvojne == 0 ) { $h_ucm=22; $h_udm=34399; }
$sqtz = "UPDATE F$kli_vxcf"."_banvyp SET zk1u=zk1u+'$x_hod', zk2u=zk2u-'$x_hod'".
" WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");
}

if( $c_hod != 0 )
     {
//////ak nenasiel ico daj popis
if( $nasielico == 0 )
{
//echo "robim nenasiel";
$sqty = "INSERT INTO F$kli_vxcf"."_uctban ( dok,ddu,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_dok', '$ddusql', '551', '0', '0', '0', '0', '0', '0', '0', '$x_txx',".
" '0', '0', '', '$kli_uzid' );"; 
$ulozene = mysql_query("$sqty"); 
}
//////podvojne
if( $podvojne == 1 )
 {
$sqty = "INSERT INTO F$kli_vxcf"."_uctban ( dok,ddu,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_dok', '$ddusql', '551', '$h_ucm', '$h_ucd', '1', '0', '$x_hod', '$h_ico', '$x_vsy', '',".
" '0', '0', '$h_unk', '$kli_uzid' );"; 
//echo $sqty;
//echo "robim podvojne";
$ulozene = mysql_query("$sqty"); 
 }
//////jednoduche
if( $podvojne == 0 )
 {
if( $nasielico == 1 )
  {
$x_hod=$x_hod-$h_hdp; 
  }
//zaklad
$sqty = "INSERT INTO F$kli_vxcf"."_uctban ( dok,ddu,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_dok', '$ddusql', '551', '$h_ucm', '$h_ucd', '1', '0', '$x_hod', '$h_ico', '$x_vsy', '',".
" '0', '0', '$h_unk', '$kli_uzid' );"; 
$ulozene = mysql_query("$sqty"); 
//dan
if( $nasielico == 1 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_uctban ( dok,ddu,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_dok', '$ddusql', '551', '$h_udm', '$h_udd', '1', '0', '$h_hdp', '$h_ico', '$x_vsy', '',".
" '0', '0', '$h_unk', '$kli_uzid' );"; 
$ulozene = mysql_query("$sqty"); 
  }
 }
    }

}
fclose ($subor);

include("../ucto/saldo_zmaz_uhr.php");
//koniec importu
  }
}
//koniec if odeslano
else 
{
?> 
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?tatra=<?php echo $tatra; ?>&sysx=<?php echo $sysx; ?>&rozuct=ANO&copern=551&drupoh=<?php echo $drupoh;?>
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $cislo_dok;?>&h_uce=<?php echo $h_uce;?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="35%" align="right" >S˙bor z TATRABANKY
        <?php if( $tatra == 1 ) { echo " Internetbanking v.4.8.4 alebo v.5.0.1 TXT s˙bor"; } ?>
        <?php if( $tatra == 2 ) { echo " GEMINI"; } ?>
        <?php if( $tatra == 3 ) { echo " Internetbanking v.5.0.1 CSV s˙bor"; } ?>
        :</td> 
        <td  width="30%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE=400000> 
        <input type="file" name="original" > 
        </td> 
        <td  width="35%" align="left" >(max. 400 kB)</td> 
      </tr> 
      <tr> 
        <td colspan="3"> 
              <input type="hidden" name="odeslano" value="1"> 
          <p align="center"><input type="submit" value="NaËÌtaù"></td> 
      </tr> 
    </table> 
    </form> 
<?php 
} 
//koniec else odeslano

$copern=8;
    }
//koniec naimportovanie banky TATRABANKA

//vymazanie poloziek rozuctovania
if ( $copern == 166 )
    {
if( $drupoh == 4 )
{
$sqtz = "UPDATE F$kli_vxcf"."_banvyp SET zk0u=0, zk1u=0, zk2u=0, dn1u=0, dn2u=0, sp1u=0, sp2u=0, hodu=0,".
" zk0=0, zk1=0, zk2=0, dn1=0, dn2=0, sp1=0, sp2=0, hod=0, zmen=0, mena='', kurz=0, hodm=0 WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");
$zmaztt = "DELETE FROM F$kli_vxcf"."_uctban WHERE dok='$cislo_dok'"; 
$zmazane = mysql_query("$zmaztt");
}
if( $drupoh == 1 )
{
$sqtz = "UPDATE F$kli_vxcf"."_pokpri SET zk0u=0, zk1u=0, zk2u=0, dn1u=0, dn2u=0, sp1u=0, sp2u=0, hodu=0, zmen=0, mena='', kurz=0, hodm=0".
" WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");
$zmaztt = "DELETE FROM F$kli_vxcf"."_uctpokuct WHERE dok='$cislo_dok'"; 
$zmazane = mysql_query("$zmaztt");
}
if( $drupoh == 2 )
{
$sqtz = "UPDATE F$kli_vxcf"."_pokvyd SET zk0u=0, zk1u=0, zk2u=0, dn1u=0, dn2u=0, sp1u=0, sp2u=0, hodu=0, zmen=0, mena='', kurz=0, hodm=0".
" WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");
$zmaztt = "DELETE FROM F$kli_vxcf"."_uctpokuct WHERE dok='$cislo_dok'"; 
$zmazane = mysql_query("$zmaztt");
}
if( $drupoh == 5 )
{
$sqtz = "UPDATE F$kli_vxcf"."_uctvsdh SET zk0u=0, zk1u=0, zk2u=0, dn1u=0, dn2u=0, sp1u=0, sp2u=0, hodu=0, zmen=0, mena='', kurz=0, hodm=0".
" WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");
$zmaztt = "DELETE FROM F$kli_vxcf"."_uctvsdp WHERE dok='$cislo_dok'"; 
$zmazane = mysql_query("$zmaztt");
}
include("../ucto/saldo_zmaz_uhr.php");
$copern=8;
    }
//koniec vymazania poloziek rozuctovania

//uloz upravy polozky sluzby 88 88 88 88 88 88 
if ( $copern == 88 )
    {
$z_cpl = strip_tags($_REQUEST['z_cpl']);
$z_ucm = strip_tags($_REQUEST['z_ucm']);
$z_ucd = strip_tags($_REQUEST['z_ucd']);
$z_rdp = strip_tags($_REQUEST['z_rdp']);
$z_dph = strip_tags($_REQUEST['z_dph']);
$z_fak = strip_tags($_REQUEST['z_fak']);
$z_ico = strip_tags($_REQUEST['z_ico']);
$z_str = strip_tags($_REQUEST['z_str']);
$z_zak = strip_tags($_REQUEST['z_zak']);
$z_pop = strip_tags($_REQUEST['z_pop']);
$z_hop = strip_tags($_REQUEST['z_hop']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

include("odpocitaj_pokpol.php");

include("pripocitaj_pokpol.php");

//uprav polozku
$sqtz = "UPDATE F$kli_vxcf"."_$uctpok SET ucm=$h_ucm, ucd='$h_ucd', rdp='$h_rdp', dph='$h_dph', fak='$h_fak', ico='$h_ico',".
" str='$h_str', zak='$h_zak', hod='$h_hop' ".
" WHERE cpl='$cislo_cpl'";

//echo $sqtz;

$upravene = mysql_query("$sqtz");

$ucm2=substr($h_ucm,0,2);
$ucd2=substr($h_ucd,0,2);
if( $ucm2 == 31 OR $ucm2 == 32 OR $ucm2 == 37 OR $ucd2 == 31 OR $ucd2 == 32 OR $ucd2 == 37 ) { include("../ucto/saldo_zmaz_uhr.php"); }

$copern=7;
    }
//koniec uloz upravu polozky sluzby 88 88 88 88 88 88 88 88 88 


//vyber upravy polozky sluzby 8787878787878787878 97979797979797979797979797
if ( $copern == 87 OR $copern == 97 )
    {
$z_cpl = strip_tags($_REQUEST['z_cpl']);
$z_ucm = strip_tags($_REQUEST['z_ucm']);
$z_ucd = strip_tags($_REQUEST['z_ucd']);
$z_rdp = strip_tags($_REQUEST['z_rdp']);
$z_dph = strip_tags($_REQUEST['z_dph']);
$z_fak = strip_tags($_REQUEST['z_fak']);
$z_str = strip_tags($_REQUEST['z_str']);
$z_zak = strip_tags($_REQUEST['z_zak']);
$z_pop = strip_tags($_REQUEST['z_pop']);
$z_hop = strip_tags($_REQUEST['z_hop']);
$z_ico = strip_tags($_REQUEST['z_ico']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
    }
//koniec vyber upravu polozky sluzby


//uloz upravy polozky textovej 9898989898989898989898 
if ( $copern == 98 )
    {
$z_cpl = strip_tags($_REQUEST['z_cpl']);
$z_ucm = strip_tags($_REQUEST['z_ucm']);
$z_ucd = strip_tags($_REQUEST['z_ucd']);
$z_rdp = strip_tags($_REQUEST['z_rdp']);
$z_dph = strip_tags($_REQUEST['z_dph']);
$z_fak = strip_tags($_REQUEST['z_fak']);
$z_str = strip_tags($_REQUEST['z_str']);
$z_zak = strip_tags($_REQUEST['z_zak']);
$z_pop = strip_tags($_REQUEST['z_pop']);
$z_hop = strip_tags($_REQUEST['z_hop']);
$z_ico = strip_tags($_REQUEST['z_ico']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

//uprav polozku
$sqtz = "UPDATE F$kli_vxcf"."_$uctpok SET pop='$h_pop' ".
" WHERE cpl='$cislo_cpl'";

$upravene = mysql_query("$sqtz");

$copern=7;
    }
//koniec uloz upravu textovej polozky 989898989898989898 


//ulozenie  polozky sluzby 7777777777777777
if ( $copern == 77 )
    {

if( $zmen != 1 ) { $h_zmen=0; $h_mena=""; $h_kurz=0; $h_hodm=0; $h_hop=$h_hop;}
if( $zmen == 1 AND $kli_vrok < 2009 ) { $h_zmen=1; $h_mena=$mena; $h_kurz=$kurz; $h_hodm=$h_hop; $h_hop=$h_hodm*$h_kurz; }
if( $zmen == 1 AND $kli_vrok > 2008 ) { $h_zmen=1; $h_mena=$mena; $h_kurz=$kurz; $h_hodm=$h_hop; $h_hop=$h_hodm/$h_kurz; }

if( $drupoh != 4 ) { 
$sqty = "INSERT INTO F$kli_vxcf"."_$uctpok ( dok,poh,ucm,ucd,rdp,dph,hod,zmen,mena,kurz,hodm,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_dok', '$drupoh', '$h_ucm', '$h_ucd', '$h_rdp', '$h_dph', '$h_hop', '$h_zmen', '$h_mena', '$h_kurz', '$h_hodm',".
" '$h_ico', '$h_fak', '$h_pop',".
" '$h_str', '$h_zak', '$h_unk', '$kli_uzid' );"; 
                   }
if( $drupoh == 4 ) { 
$ddusql = SqlDatum($_REQUEST['ddu']);
$ddusk = $_REQUEST['ddu'];

$sqty = "INSERT INTO F$kli_vxcf"."_$uctpok ( dok,ddu,poh,ucm,ucd,rdp,dph,hod,zmen,mena,kurz,hodm,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_dok', '$ddusql', '$drupoh', '$h_ucm', '$h_ucd', '$h_rdp', '$h_dph', '$h_hop', '$h_zmen', '$h_mena', '$h_kurz', '$h_hodm',".
" '$h_ico', '$h_fak', '$h_pop',".
" '$h_str', '$h_zak', '$h_unk', '$kli_uzid' );"; 
                   }
$ulozene = mysql_query("$sqty"); 


include("pripocitaj_pokpol.php");

$ucm2=substr($h_ucm,0,2);
$ucd2=substr($h_ucd,0,2);
if( $ucm2 == 31 OR $ucm2 == 32 OR $ucm2 == 37 OR $ucd2 == 31 OR $ucd2 == 32 OR $ucd2 == 37 ) { include("../ucto/saldo_zmaz_uhr.php"); }

if( $zmen == 1 AND $drupoh != 4 ) { 
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm+'$h_hodm' WHERE dok='$cislo_dok'"; $upravene = mysql_query("$sqtz"); }

if( $zmen == 1 AND $drupoh == 4 AND $h_kredit != 0 ) { 
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm+'$h_hodm' WHERE dok='$cislo_dok'"; $upravene = mysql_query("$sqtz"); }

if( $zmen == 1 AND $drupoh == 4 AND $h_debet != 0 ) { 
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm-'$h_hodm' WHERE dok='$cislo_dok'"; $upravene = mysql_query("$sqtz"); }

$copern=7;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia polozky sluzby

//vymazanie polozky sluzby 3636363636363636363
if ( $copern == 36 )
    {
$mazanie=1;

$z_cpl = strip_tags($_REQUEST['z_cpl']);
$z_ucm = strip_tags($_REQUEST['z_ucm']);
$z_ucd = strip_tags($_REQUEST['z_ucd']);
$z_rdp = strip_tags($_REQUEST['z_rdp']);
$z_dph = strip_tags($_REQUEST['z_dph']);
$z_fak = strip_tags($_REQUEST['z_fak']);
$z_str = strip_tags($_REQUEST['z_str']);
$z_zak = strip_tags($_REQUEST['z_zak']);
$z_pop = strip_tags($_REQUEST['z_pop']);
$z_hop = strip_tags($_REQUEST['z_hop']);
$z_hodm = strip_tags($_REQUEST['z_hodm']);
$z_zmen = strip_tags($_REQUEST['z_zmen']);
$z_ico = strip_tags($_REQUEST['z_ico']);
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctpok WHERE ( cpl='$cislo_cpl' )"); 

include("odpocitaj_pokpol.php");

$ucm2=substr($z_ucm,0,2);
$ucd2=substr($z_ucd,0,2);
if( $ucm2 == 31 OR $ucm2 == 32 OR $ucm2 == 37 OR $ucd2 == 31 OR $ucd2 == 32 OR $ucd2 == 37 ) { include("../ucto/saldo_zmaz_uhr.php"); }

if( $z_zmen == 1 AND $drupoh != 4 ) {
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm-'$z_hodm' WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");   }

if( $z_zmen == 1 AND $drupoh == 4 AND $z_kredit != 0 ) {
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm-'$z_hodm' WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");   }

if( $z_zmen == 1 AND $drupoh == 4 AND $z_debet != 0 ) {
$sqtz = "UPDATE F$kli_vxcf"."_$tabl SET hodm=hodm+'$z_hodm' WHERE dok='$cislo_dok'";
$upravene = mysql_query("$sqtz");   }

$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
$copern=7;
endif;
    }
//koniec vymazania polozky sluzby

//novy doklad hlavicka
if ( $copern == 5 OR $copern == 55 OR $copern == 555 )
    {
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$tabl WHERE ( isnull(dok) )"); 

if( $cisdokodd != 1 OR $drupoh == 5 )
        {
$sql = mysql_query("SELECT $cisdok FROM F$kli_vxcf"."_ufir");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->$cisdok;
  $nwwdok=$riadok->$cisdok;
  }
        }

if( $cisdokodd == 1 AND $drupoh != 5  )
        {
  if( $drupoh == 1 ) { $sql = mysql_query("SELECT cpri AS cfak FROM F$kli_vxcf"."_dpok WHERE drpk = 1 AND dpok = $hladaj_uce"); }
  if( $drupoh == 2 ) { $sql = mysql_query("SELECT cvyd AS cfak FROM F$kli_vxcf"."_dpok WHERE drpk = 1 AND dpok = $hladaj_uce"); }
  if( $drupoh == 3 ) { $sql = mysql_query("SELECT cpri AS cfak FROM F$kli_vxcf"."_dpok WHERE drpk = 2 AND dpok = $hladaj_uce"); }
  if( $drupoh == 4 ) { $sql = mysql_query("SELECT cban AS cfak FROM F$kli_vxcf"."_dban WHERE dban = $hladaj_uce"); }

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $newdok=$riadok->cfak;
  $nwwdok=$riadok->cfak;
  }
        }

//cislovanie podla ume ak vyhovuje ciselnej rade zoberie vyssie nastaveny ak nie zoberie max v rade+1, nemoze byt aj v jednej rade aj ume
$cisdokume=1*$fir_uctx10;
//toto ( zaroven ume aj jedna rada ) bolo povodne zablokovane if( $pvpokljed == 1 ) { $cisdokume=0; }
if( $drupoh == 5 ) { $cisdokume=1*$fir_uctx12; }

if( $cisdokume >= 3 AND $cisdokume <= 7 AND $drupoh != 4 )
        {
$pole = explode(".", $kli_vume);
$mesiac=1*$pole[0];
$rok=1*$pole[1];
if( $mesiac < 10 ) $mesiac="0".$mesiac;
$opacdok=strRev($newdok);
if( $cisdokume == 3 ) { $poccis="01"; $koncis="99"; $predok=substr($opacdok,4,4); }
if( $cisdokume == 4 ) { $poccis="001"; $koncis="999"; $predok=substr($opacdok,5,3); }
if( $cisdokume == 5 ) { $poccis="0001"; $koncis="9999"; $predok=substr($opacdok,6,2); }
if( $cisdokume == 6 ) { $poccis="00001"; $koncis="99999"; $predok=substr($opacdok,7,1); }
if( $cisdokume == 7 ) { $poccis="000001"; $koncis="999999"; $predok=substr($opacdok,8,0); }
$predok=strRev($predok);
$predok=1*$predok;

$pocdok=$predok.$mesiac.$poccis;
$kondok=$predok.$mesiac.$koncis;

$maxumedok=0;
  if( $drupoh == 1 OR $drupoh == 3 ) { $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_pokpri WHERE dok >= $pocdok AND dok <= $kondok ORDER BY dok DESC LIMIT 1"); }
  if( $drupoh == 2 ) { $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_pokvyd WHERE dok >= $pocdok AND dok <= $kondok ORDER BY dok DESC LIMIT 1"); }
  if( $drupoh == 5 ) { $sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdh WHERE dok >= $pocdok AND dok <= $kondok ORDER BY dok DESC LIMIT 1"); }

  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxumedok=1*$riaddok->dok+1;
  }

if( $maxumedok == 0 ) $newdok=$pocdok;
if( $maxumedok > 0 AND $newdok >= $pocdok AND $newdok <= $kondok ) $newdok=$newdok;
if( $maxumedok > 0 AND $newdok < $pocdok ) $newdok=$maxumedok;
if( $maxumedok > 0 AND $newdok > $kondok ) $newdok=$maxumedok;

//echo "podla ume ".$pocdok." - ".$kondok." MAX ".$maxumedok." NEW ".$newdok;


        }
//koniec cislovania podla ume

$maxdok=0;

$sql = mysql_query("SELECT dok FROM F$kli_vxcf"."_$tabl ORDER by dok ");
while($zaznam=mysql_fetch_array($sql)):
if( $zaznam["dok"] == $newdok ) $newdok=$newdok+1;
endwhile;

//ak jedna rada pokladne otestuj aj druhu tabulku
if( $pvpokljed == 1 AND $drupoh >= 1 AND $drupoh <= 2 )
{  
if( $drupoh == 1 ) $tabl2="pokvyd";
if( $drupoh == 2 ) $tabl2="pokpri";

$sql = mysql_query("( SELECT dok FROM F$kli_vxcf"."_$tabl2 ORDER by dok ) UNION ( SELECT dok FROM F$kli_vxcf"."_$tabl ORDER by dok ) ORDER BY dok");
while($zaznam=mysql_fetch_array($sql)):
//echo $zaznam["dok"]." ";
if( $zaznam["dok"] == $newdok ) $newdok=$newdok+1;
endwhile;

}
//koniec testu druhej tabulky ak je jedna rada pokladne

//co urobi ak nenasiel cislo dokladu z parametrov alebo z dpok,dban
$cnewdok=1*$newdok;
if( $cnewdok == 0 )
{
$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_$tabl WHERE uce=$hladaj_uce ORDER by dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $newdok=$riadmax->dok+1;
  }

if( $pvpokljed == 1 AND $drupoh >= 1 AND $drupoh <= 2 )
     {  
if( $drupoh == 1 ) $tabl2="pokvyd";
if( $drupoh == 2 ) $tabl2="pokpri";
$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_$tabl2 WHERE uce=$hladaj_uce ORDER by dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $newdok2=$riadmax->dok+1;
  }
if( $newdok2 > $newdok ) { $newdok=$newdok2; }
     }
}
//$newdok=1;
$cnewdok=1*$newdok;
if( $cnewdok == 0 ) { $newdok=1; }

$h_fak = $newdok;

//zapis nove nasledujuce cislo 
if( ( $cisdokodd != 1 AND $newdok > 1 ) OR $drupoh == 5 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_ufir SET $cisdok='$newdok'+1"); }
if( $cisdokodd == 1 AND $drupoh != 5 )
 { 
 if( $drupoh == 1 AND $newdok > 1 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dpok SET cpri='$newdok'+1 WHERE drpk=1 AND dpok = $hladaj_uce"); }
 if( $drupoh == 2 AND $newdok > 1 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dpok SET cvyd='$newdok'+1 WHERE drpk=1 AND dpok = $hladaj_uce"); }
 if( $drupoh == 3 AND $newdok > 1 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dpok SET cpri='$newdok'+1 WHERE drpk=2 AND dpok = $hladaj_uce"); }
 if( $drupoh == 4 AND $newdok > 1 ) { $upravene = mysql_query("UPDATE F$kli_vxcf"."_dban SET cban='$newdok'+1 WHERE dban = $hladaj_uce"); }
 }

if ( $copern == 55 OR $copern == 555 ) { $hladaj_uce=21100; }
if( $newdok == 1 AND $copern == 55 )
     {
$hladaj_uce=$fir_xfa03;

$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_pokpri WHERE uce=$hladaj_uce ORDER by dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $newdok=$riadmax->dok+1;
  }
     }


$sqlhh = "INSERT INTO F$kli_vxcf"."_$tabl ( uce,dok,doq,zk0,id ) VALUES ( $hladaj_uce, $newdok, $newdok, '0', $kli_uzid )";
//echo $sqlhh;
$ulozene = mysql_query("$sqlhh"); 
if (!$ulozene):
?>
<script type="text/javascript"> alert( " NIE JE SPOJENIE S DATAB¡ZOU ,  ukonËite program a spustite ho znovu " ) </script>
<?php
exit;
endif;
if ($ulozene):
$uloz="OK";
endif;
//uctovanie prikazu na uhradu
if( $copern == 555 )
{
$cislo_prik = strip_tags($_REQUEST['cislo_prik']);

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriku WHERE dok = $cislo_prik");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$pole = explode("-", $riadok->dat);
$h_ume = $pole[1].".".$pole[0];
$uceban=$riadok->uce;

$uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$riadok->uce', dat='$riadok->dat', ume='$h_ume',".
" ico='$riadok->ico', unk='$riadok->unk',".
" poz='$riadok->poz', txp='$riadok->txp', txz='$riadok->txz',".
" hod='$h_hod', zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', sz1='$h_sz1', sz2='$h_sz2',".
" zk3='$h_zk3', zk4='$h_zk4', dn3='$h_dn3', dn4='$h_dn4', sz3='$h_sz3', sz4='$h_sz4', sp1='$h_sp1', sp2='$h_sp2',".
" zk0u='0', zk1u='$riadok->hodp', zk2u=zk0u-zk1u,".
" kto='$riadok->kto'".
" WHERE id='$kli_uzid' AND dok='$newdok'";
//echo $uprt;
$upravene = mysql_query("$uprt");  

  }

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctprikp WHERE dok = $cislo_prik");
$cpol = mysql_num_rows($sql);
$i=0;

while ($i <= $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
  $riadok=mysql_fetch_object($sql);

$pole = explode("-", $riadok->dat);
$h_ume = $pole[1].".".$pole[0];

$sqty = "INSERT INTO F$kli_vxcf"."_$uctpok ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$newdok', '$drupoh', '$riadok->uce', '$uceban', '1', '0', '$riadok->hodp', '$riadok->ico', '$riadok->vsy', '',".
" '0', '0', '', '$kli_uzid' );"; 

$ulozene = mysql_query("$sqty");  

  }
$i=$i+1;
}

include("../ucto/saldo_zmaz_uhr.php");

$sluz1='VELKE';
$rozb1='NOT';
$rozb2='NOT';
$copern=8;
$cislo_dok=$newdok;
}

$kopydok = 1*$_REQUEST['kopydok'];
if( $kopydok == 1 )
  {
?> 
<script type="text/javascript">
  var okno = window.open("../ucto/kopia_dokladov.php?copern=1&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&cislo_dok=<?php echo $cislo_dok; ?>&kopia_dok=<?php echo $newdok; ?>","_self");
</script>
<?php 

exit;
  }

    }
if ( $copern == 15 ) $copern=5;
if ( $copern == 5 AND $sluz1 == "VELKE" ) $copern=7;
//koniec nova faktura hlavicka


//uhrada faktury z vstfak.php
if ( $copern == 55 )
    {

$h_tl0 = strip_tags($_REQUEST['h_tl0']);
$h_tl1 = strip_tags($_REQUEST['h_tl1']);
$h_tl2 = strip_tags($_REQUEST['h_tl2']);
$h_tl3 = strip_tags($_REQUEST['h_tl3']);
$h_tl4 = strip_tags($_REQUEST['h_tl4']);
$h_tl5 = strip_tags($_REQUEST['h_tl5']);
$h_tl6 = strip_tags($_REQUEST['h_tl6']);
$h_tl7 = strip_tags($_REQUEST['h_tl7']);
$h_tl8 = strip_tags($_REQUEST['h_tl8']);
$h_tl9 = strip_tags($_REQUEST['h_tl9']);
$h_tl10 = strip_tags($_REQUEST['h_tl10']);
$h_tl11 = strip_tags($_REQUEST['h_tl11']);
$h_tl12 = strip_tags($_REQUEST['h_tl12']);
$h_tl13 = strip_tags($_REQUEST['h_tl13']);
$h_tl14 = strip_tags($_REQUEST['h_tl14']);
$h_tl15 = strip_tags($_REQUEST['h_tl15']);
$h_tl16 = strip_tags($_REQUEST['h_tl16']);
$h_tl17 = strip_tags($_REQUEST['h_tl17']);
$h_tl18 = strip_tags($_REQUEST['h_tl18']);
$h_tl19 = strip_tags($_REQUEST['h_tl19']);



function uhrad_fak($akydok, $cislopok, $ucetpok, $uzivatel, $firma, $tabulka, $druhpoh, $klimes, $uctpohyby, $podvojx )
         {

if ( $druhpoh == 1 ) { $sql = "SELECT * FROM F$firma"."_fakodb WHERE dok=$akydok"; }
if ( $druhpoh == 31 ) { $sql = "SELECT * FROM F$firma"."_dopfak WHERE dok=$akydok"; }

$dsql = mysql_query($sql);
  if (@$dzak=mysql_data_seek($dsql,0))
  {
$friadok=mysql_fetch_object($dsql);

$hodnota=1*$friadok->hod;

if( $podvojx == 1 )
{
$uprt = "UPDATE F$firma"."_$tabulka SET uce='$ucetpok', dat='$friadok->dat', ume='$klimes',".
" ico='$friadok->ico',".
" poz='', txp='˙hrada fakt˙r', txz='',".
" zk1='0', zk2='0', dn1='0', dn2='0',".
" zk0=zk0+('$hodnota'), hod=zk0,".
" sp1='0', sp2='0',".
" unk='$friadok->unk' ".
" WHERE id='$uzivatel' AND dok='$cislopok'";
//echo $uprt;
$upravene = mysql_query("$uprt"); 
}
if( $podvojx == 0 )
{
$uprt = "UPDATE F$firma"."_$tabulka SET uce='$ucetpok', dat='$friadok->dat', ume='$klimes',".
" ico='$friadok->ico',".
" poz='', txp='˙hrada fakt˙r', txz='',".
" zk1u='0', zk2u='0', dn1u='0', dn2u='0',".
" zk0u=zk0u+('$hodnota'), hodu=zk0u,".
" sp1u='0', sp2u='0', zk1=0, zk2=0, zk0=0, dn1=0, dn2=0, hod=0, sp1=0, sp2=0,".
" unk='$friadok->unk' ".
" WHERE id='$uzivatel' AND dok='$cislopok'";
//echo $uprt;
$upravene = mysql_query("$uprt"); 
}

if( $podvojx == 1 )
{
$sqty = "INSERT INTO F$firma"."_$uctpohyby ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,id )".
" VALUES ('$cislopok', '1', '$ucetpok', '$friadok->uce', '0', '0', '$friadok->hod',".
" '$friadok->ico', '$friadok->fak', '$friadok->pop', '$friadok->str', '$friadok->zak', '$uzivatel' );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty"); 
}
if( $podvojx == 0 )
{
$hoddph=$friadok->dn1+$friadok->dn2;
$hodzak=$friadok->hod-$hoddph;
$sqty = "INSERT INTO F$firma"."_$uctpohyby ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,id )".
" VALUES ('$cislopok', '1', '$ucetpok', '60', '1', '0', '$hodzak',".
" '$friadok->ico', '$friadok->fak', '$friadok->pop', '$friadok->str', '$friadok->zak', '$uzivatel' );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty");
$sqty = "INSERT INTO F$firma"."_$uctpohyby ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,id )".
" VALUES ('$cislopok', '1', '$ucetpok', '34399', '1', '0', '$hoddph',".
" '$friadok->ico', '$friadok->fak', '$friadok->pop', '$friadok->str', '$friadok->zak', '$uzivatel' );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty"); 
}

  }
          }

if ( $drupoh == 1 ) { $pokluce = $fir_xfa03; }
if ( $drupoh == 31 ) { $pokluce = $fir_xdp03; }
$podvojne=1;
if( $kli_vduj== 9 ) { $podvojne=0; $uctpok="uctpokuct"; $sysx="UCT"; $rozuct="ANO"; }

if( $h_tl0 > 0 ) uhrad_fak($h_tl0, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl1 > 0 ) uhrad_fak($h_tl1, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl2 > 0 ) uhrad_fak($h_tl2, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl3 > 0 ) uhrad_fak($h_tl3, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl4 > 0 ) uhrad_fak($h_tl4, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl5 > 0 ) uhrad_fak($h_tl5, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl6 > 0 ) uhrad_fak($h_tl6, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl7 > 0 ) uhrad_fak($h_tl7, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl8 > 0 ) uhrad_fak($h_tl8, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl9 > 0 ) uhrad_fak($h_tl9, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl10 > 0 ) uhrad_fak($h_tl10, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl11 > 0 ) uhrad_fak($h_tl11, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl12 > 0 ) uhrad_fak($h_tl12, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl13 > 0 ) uhrad_fak($h_tl13, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl14 > 0 ) uhrad_fak($h_tl14, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl15 > 0 ) uhrad_fak($h_tl15, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl16 > 0 ) uhrad_fak($h_tl16, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl17 > 0 ) uhrad_fak($h_tl17, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl18 > 0 ) uhrad_fak($h_tl18, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);
if( $h_tl19 > 0 ) uhrad_fak($h_tl19, $newdok, $pokluce, $kli_uzid, $kli_vxcf, $tabl, $drupoh, $kli_vume, $uctpok, $podvojne);

include("../ucto/saldo_zmaz_uhr.php");

$sluz1='VELKE';
$rozb1='NOT';
$rozb2='NOT';
$copern=8;
if( $drupoh == 1 ) $drupoh=1;
if( $drupoh == 31 ) $drupoh=3;
$cislo_dok=$newdok;
    }
//koniec uhrada z vstfak.php


//uprava dokladu hlavicka
if ( $copern == 8 )
    {
$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat,".
" F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, poz,".
" txp, txz, zk1, dn1, sp1, zk2, dn2, sp2, zk0, hod, unk, kto".
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
$sql = mysql_query("$sqltt"); 
$nieje=0;
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$nieje=1;
$cislo_uce = $riadok->uce;
$cislo_dok = $riadok->dok;
$newdok = $riadok->dok;
$cislo_dat = $riadok->dat;
$cislo_ico = $riadok->ico;
$cislo_unk = $riadok->unk;
$cislo_kto = $riadok->kto;
$cislo_zk0 = $riadok->zk0;
$cislo_zk1 = $riadok->zk1;
$cislo_zk2 = $riadok->zk2;
$cislo_dn1 = $riadok->dn1;
$cislo_dn2 = $riadok->dn2;
$cislo_sp1 = $riadok->sp1;
$cislo_sp2 = $riadok->sp2;
$cislo_sz2 = $riadok->sz2;
$cislo_sz1 = $riadok->sz1;
$cislo_txp = $riadok->txp;
$cislo_txz = $riadok->txz;
$cislo_poz = $riadok->poz;
$cislo_hod = $riadok->hod;

$vybr_ico = $riadok->ico;
$vybr = 'ANO';
  }

if( $nieje == 0 )
{
?>
<script type="text/javascript">
 location.href='vstpok.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=<?php echo $page; ?>'  
</script>
<?php
}
    }

if ( $copern == 18 ) { $copern=8; }
if ( $copern == 8 AND $sluz1 == "VELKE" ) { $copern=7; }
//koniec uprava faktury hlavicka

//nova hlavicka ulozenie 68
if ( $copern == 68 )
  {

$h_dat = SqlDatum($h_dat);

  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];
 $uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume',".
" ico='$h_ico', unk='$h_unk',".
" poz='$h_poz', txp='$h_txp', txz='$h_txz',".
" hod='$h_hod', zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', sz1='$h_sz1', sz2='$h_sz2',".
" zk3='$h_zk3', zk4='$h_zk4', dn3='$h_dn3', dn4='$h_dn4', sz3='$h_sz3', sz4='$h_sz4', sp1='$h_sp1', sp2='$h_sp2',".
" kto='$h_kto'".
" WHERE id='$kli_uzid' AND dok='$h_dok'";
//echo $uprt;
$upravene = mysql_query("$uprt");  
$cislo_dok = $h_dok;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA ULOéEN¡ " ) </script>
<?php
exit;
endif;
if ($upravene):
$uprav="OK";
if ( $sluz1 != 'VELKE' )
{
?>
<script type="text/javascript">
 location.href='vstpok.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=1'  
</script>
<?php
}
$copern=7;
endif;
  }
//koniec nova hlavicka ulozenie

//uprava hlavicka ulozenie 78
if ( $copern == 78 )
  {
 
$h_dat = SqlDatum($h_dat);
$h_daz = SqlDatum($h_daz);
$h_das = SqlDatum($h_das);

  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];

//uprav doklad
 $uprt = "UPDATE F$kli_vxcf"."_$tabl SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume',
 ico='$h_ico', poz='$h_poz', txp='$h_txp', txz='$h_txz', kto='$h_kto',
 hod='$h_hod', zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', sz1='$h_sz1', sz2='$h_sz2',
 zk3='$h_zk3', zk4='$h_zk4', dn3='$h_dn3', dn4='$h_dn4', sz3='$h_sz3', sz4='$h_sz4', sp1='$h_sp1', sp2='$h_sp2',
 unk='$h_unk'
 WHERE dok='$h_dok'";
//echo $uprt;
$upravene = mysql_query("$uprt");  

//uprav ico poloziek toto som zrusil
$sqtz = "UPDATE F$kli_vxcf"."_$uctpok SET ico='$h_ico'".
" WHERE dok='$h_dok'";
//$upravpol = mysql_query("$sqtz"); 

$cislo_dok = $h_dok;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA ULOéEN¡ " ) </script>
<?php
exit;
endif;
if ($upravene):
$uprav="OK";
if ( $sluz1 != 'VELKE' )
{
?>
<script type="text/javascript">
 location.href='vstpok.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=1&drupoh=<?php echo $drupoh; ?>&page=1'  
</script>
<?php
}
$copern=7;
endif;
  }
//koniec uprava hlavicka ulozenie
//echo 'sluz'.$sluz1;
//echo 'rozb1'.$rozb1;
//echo 'rozb2'.$rozb2;
//echo 'copern'.$copern;


if ( $sluz1 == "VELKE" ) { $rozb1="NOT"; $rozb2="NOT"; }

//echo 'rozb1'.$rozb1;
//echo 'rozb2'.$rozb2;
//echo 'copern'.$copern;


$h_icoc=1*$h_ico;
if ( $h_icoc == 0 AND ( $drupoh == 1 OR $drupoh == 2 ) AND $copern == 7 ) 
{ 
//echo "idem",$copern;
$sqldok = mysql_query("SELECT ico FROM F$kli_vxcf"."_$tabl WHERE dok = $cislo_dok ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_ico=1*$riaddok->ico;
  } 
}

if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=8'); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) echo "<title>PokladniËn˝ doklad</title>"; ?>
<?php if( $drupoh == 4 ) echo "<title>Bankov˝ v˝pis</title>"; ?>
<?php if( $drupoh == 5 ) echo "<title>Vöeobecn˝ ˙Ëtovn˝ doklad</title>"; ?>
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
<SCRIPT Language="JavaScript" Src="../js/cookies.js"></SCRIPT>
<?php
if ( ( $copern == 7 OR $copern == 87 ) AND $kli_vduj != 9 )
{
?>
<script type="text/javascript" src="spr_ucm_xml.js"></script>
<script type="text/javascript" src="spr_ucd_xml.js"></script>
<?php
}
?>
<?php
if ( ( $copern == 7 OR $copern == 87 ) AND $kli_vduj == 9 )
{
?>
<script type="text/javascript" src="spr_drm_xml.js"></script>
<script type="text/javascript" src="spr_drd_xml.js"></script>
<?php
}
?>
<?php
if ( $copern == 7 OR $copern == 87 )
{
?>
<script type="text/javascript" src="spr_icp_xml.js"></script>
<script type="text/javascript" src="spr_str_xml.js"></script>
<script type="text/javascript" src="spr_zak_xml.js"></script>
<script type="text/javascript" src="spr_rdp_xml.js"></script>
<?php
}
?>
<?php
if ( $copern == 5 OR $copern == 8 )
{
?>
<script type="text/javascript" src="../ajax/spr_ico_xml.js"></script>
<?php
}
?>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawincela = screen.height;

function Len1ICO()
                    {
document.forms.fhlv1.h_kto.focus();
                    }

function HlvOnClick()
                    {
 Fxh.style.display='none';
 document.fhlv1.uloh.disabled = true; 
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 OR $drupoh == 5 )
{
?>
 document.fhlv1.sluzby.disabled = true;
<?php
}
?>
                    }


//posuny Enter[[[[[[[[[[[


function UceEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_dat.focus();
              }

                }


function OnfocusDat()
                {
        if( document.forms.fhlv1.h_dat.value == "" ) { document.forms.fhlv1.h_dat.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dat.select();
                }

function DatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_unk.focus();
        document.forms.fhlv1.h_unk.select();
              }

                }


function UnkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        if( document.fhlv1.h_ico.value == "" ) { document.fhlv1.h_ico.value = '<?php echo $fir_fico; ?>'; }
        document.forms.fhlv1.h_ico.focus();
        document.forms.fhlv1.h_ico.select();
              }

                }


function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_ico.value != '')
        {
        myIcoElement.style.display='';
        nulujIco();
        volajIco();
        }      
        if( document.fhlv1.h_ico.value == "" ) { document.fhlv1.h_nai.disabled = false; document.fhlv1.h_nai.focus(); document.forms.fhlv1.h_nai.select(); }
        if( document.fhlv1.h_ico.value == 0 ) { document.fhlv1.h_nai.disabled = false; document.fhlv1.h_nai.focus(); document.forms.fhlv1.h_nai.select(); }

              }
                }



function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_nai.value != '' )
        {
        myIcoElement.style.display='';
        nulujIco();
        volajIco();
        }   

        if( document.fhlv1.h_nai.value != "" && document.fhlv1.h_ico.value > 0 )
            { document.fhlv1.h_ico.focus(); document.forms.fhlv1.h_ico.select(); }

        if( document.fhlv1.h_nai.value == "" ) { document.fhlv1.h_ico.focus(); document.forms.fhlv1.h_ico.select();}

              }
                }


//co urobi po potvrdeni ok z tabulky ico
function vykonajIco(ico,nazov,mesto,ucb,num,tel)
                {
        document.forms.fhlv1.h_ico.value = ico;
        document.forms.fhlv1.h_nai.value = nazov;
        myIcoElement.style.display='none';
        document.forms.fhlv1.h_kto.focus();
        document.forms.fhlv1.h_kto.select();
                }

function nulujIco()
                {

                }



function KtoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_txp.focus();
              }

                }


function TxpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_zk1.value == '' ){ document.forms.fhlv1.h_zk1.value = 0; }
        document.forms.fhlv1.h_zk1.focus();
        document.forms.fhlv1.h_zk1.select();
              }

                }


function TxzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }

                }



function Zk1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        dann = 0.<?php echo $fir_dph1; ?>*document.forms.fhlv1.h_zk1.value;
        <?php if( $vyb_rok < 2009 ) { echo "danz = dann.toFixed(1);"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "danz = dann.toFixed(2);"; } ?>

        document.forms.fhlv1.h_dn1.value = danz;
        document.forms.fhlv1.h_sp1.value = 1*document.forms.fhlv1.h_zk1.value+1*document.forms.fhlv1.h_dn1.value;
        document.forms.fhlv1.h_dn1.focus();
        document.forms.fhlv1.h_dn1.select();
              }

                }


function Dn1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        document.forms.fhlv1.h_sp1.value = 1*document.forms.fhlv1.h_zk1.value+1*document.forms.fhlv1.h_dn1.value;
        if(document.forms.fhlv1.h_zk2.value == '' ){ document.forms.fhlv1.h_zk2.value = 0; }
        document.forms.fhlv1.h_zk2.focus();
        document.forms.fhlv1.h_zk2.select();
              }

                }

function Zk2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        dann = 0.<?php echo $fir_dph2; ?>*document.forms.fhlv1.h_zk2.value;
        <?php if( $vyb_rok < 2009 ) { echo "danz = dann.toFixed(1);"; } ?>
        <?php if( $vyb_rok > 2008 ) { echo "danz = dann.toFixed(2);"; } ?>

        document.forms.fhlv1.h_dn2.value = danz;
        var hodsp2 = 1*document.forms.fhlv1.h_zk2.value+1*document.forms.fhlv1.h_dn2.value;
        hodsp2 = hodsp2.toFixed(2);
        document.forms.fhlv1.h_sp2.value = hodsp2;
        document.forms.fhlv1.h_dn2.focus();
        document.forms.fhlv1.h_dn2.select();
              }

                }

function Dn2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_zk2.value > 0 ){ 
        var hodsp2 = 1*document.forms.fhlv1.h_zk2.value+1*document.forms.fhlv1.h_dn2.value;
        hodsp2 = hodsp2.toFixed(2)
        document.forms.fhlv1.h_sp2.value = hodsp2;
        if(document.forms.fhlv1.h_zk0.value == '' ){ document.forms.fhlv1.h_zk0.value = 0;  document.forms.fhlv1.h_sp0.value = 0; }
        document.forms.fhlv1.h_zk0.focus();
        document.forms.fhlv1.h_zk0.select();
                                                   }
        if(document.forms.fhlv1.h_zk2.value == '' ){ 
        document.forms.fhlv1.h_sp2.focus();
        document.forms.fhlv1.h_sp2.select();
                                                   }
        if(document.forms.fhlv1.h_zk2.value == 0  ){ 
        document.forms.fhlv1.h_sp2.focus();
        document.forms.fhlv1.h_sp2.select();
                                                   }
              }
                }


function Sp2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.fhlv1.h_zk2.value > 0 && document.forms.fhlv1.h_dn2.value > 0  ){ 
        if(document.forms.fhlv1.h_zk0.value == '' ){ document.forms.fhlv1.h_zk0.value = 0;  document.forms.fhlv1.h_sp0.value = 0; }
        document.forms.fhlv1.h_zk0.focus();
        document.forms.fhlv1.h_zk0.select();
                                                   }
        if(document.forms.fhlv1.h_zk2.value == 0 && document.forms.fhlv1.h_dn2.value > 0  ){ 
        var hodzk2 = 1*document.forms.fhlv1.h_sp2.value-1*document.forms.fhlv1.h_dn2.value;
        hodzk2 = hodzk2.toFixed(2)
        document.forms.fhlv1.h_zk2.value = hodzk2;
        if(document.forms.fhlv1.h_zk0.value == '' ){ document.forms.fhlv1.h_zk0.value = 0;  document.forms.fhlv1.h_sp0.value = 0; }
        document.forms.fhlv1.h_zk0.focus();
        document.forms.fhlv1.h_zk0.select();
                                                   }
        if(document.forms.fhlv1.h_zk2.value == '' && document.forms.fhlv1.h_dn2.value > 0  ){ 
        var hodzk2 = 1*document.forms.fhlv1.h_sp2.value-1*document.forms.fhlv1.h_dn2.value;
        hodzk2 = hodzk2.toFixed(2)
        document.forms.fhlv1.h_zk2.value = hodzk2;
        if(document.forms.fhlv1.h_zk0.value == '' ){ document.forms.fhlv1.h_zk0.value = 0;  document.forms.fhlv1.h_sp0.value = 0; }
        document.forms.fhlv1.h_zk0.focus();
        document.forms.fhlv1.h_zk0.select();
                                                   }
        if(document.forms.fhlv1.h_zk2.value == '' && document.forms.fhlv1.h_dn2.value == '' ){ 
        document.forms.fhlv1.h_dn2.focus();
        document.forms.fhlv1.h_dn2.select();
                                                   }
        if(document.forms.fhlv1.h_zk2.value == 0 && document.forms.fhlv1.h_dn2.value == 0  ){ 
        document.forms.fhlv1.h_zk0.focus();
        document.forms.fhlv1.h_zk0.select();
                                                   }

        if(document.forms.fhlv1.h_zk2.value == 0 && document.forms.fhlv1.h_dn2.value == 0 && document.forms.fhlv1.h_sp2.value != 0  ){ 
        document.forms.fhlv1.h_dn2.focus();
        document.forms.fhlv1.h_dn2.select();
                                                   }
              }
                }

function Zk0Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        var hodhod = 1*document.forms.fhlv1.h_sp1.value+1*document.forms.fhlv1.h_sp2.value+1*document.forms.fhlv1.h_zk0.value;
        hodhod = hodhod.toFixed(2);
        document.forms.fhlv1.h_hod.value = hodhod;
        document.forms.fhlv1.h_hod.focus();
        document.forms.fhlv1.h_hod.select();
              }

                }

function HodEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
              }

                }

function PozEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;


    if ( okvstup == 0 && document.fhlv1.h_dat.value == '' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 0 && document.fhlv1.err_dat.value == '1' ) { document.fhlv1.h_dat.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.fhlv1.submit(); return (true); }
              }
                }


//script pre copern vymazanie 6 666666666666666 
<?php
if ( $copern == 6 ) 
{?>
    function ObnovUI()
    {

    }
    function VyberVstup()
    {

    }

<?php
//koniec skriptu 6 666666666
}?>


//script pre copern  7 77777777777777777 vstup sluzby
<?php
if ( $copern == 7 OR $copern == 87 ) 
{?>

function DduEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.forms1.h_ucm.focus();
        document.forms.forms1.h_ucm.select();
              }
                }


function UcmOnfocus(e)
                {

<?php
if ( $drupoh == 4 ) 
{
?>
        if ( document.forms1.h_ucm.value != '<?php echo $h_uce; ?>' && document.forms1.h_ucd.value != '<?php echo $h_uce; ?>' ) document.forms.forms1.h_ucm.value = '<?php echo $h_uce; ?>';
<?php
}
?>

        if ( document.forms1.h_ucm.value == '' ) document.forms1.h_ucm.value = '0';
        document.forms.forms1.h_ucm.focus();
        document.forms.forms1.h_ucm.select();

                }

function UcmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_ucm.value != '' && document.forms1.h_ucm.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myUcmelement.style.display=''; volajUcm(slpol,0); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0'; document.forms.forms1.h_ucd.focus(); document.forms.forms1.h_ucd.select(); }
<?php
}
?>
        if ( document.forms1.h_ucm.value == '0' )
        {         
        if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0';
        document.forms.forms1.h_ucd.focus();
        document.forms.forms1.h_ucd.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky ucm
function vykonajUcm(ucm,ucmtext)
                {
         ukazUcm.innerHTML = "UCM: " + ucmtext;
         ukazUcm.style.display='';
         document.forms.forms1.h_ucm.value = ucm;
         myUcmelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0';
         document.forms1.h_ucd.focus();
         document.forms1.h_ucd.select();
                }


function Len1Ucm(ucm)
              {
         document.forms.forms1.h_ucm.value = ucm;
         myUcmelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_ucd.value == '' ) document.forms1.h_ucd.value = '0';
         document.forms1.h_ucd.focus();
         document.forms1.h_ucd.select();
              }

function Len0Ucm()
                    {
         document.forms1.h_ucm.focus();
         document.forms1.h_ucm.select();
                    }


function UcdOnfocus(e)
                {

<?php
if ( $drupoh == 4 ) 
{
?>
        if ( document.forms1.h_ucm.value != '<?php echo $h_uce; ?>' && document.forms1.h_ucd.value != '<?php echo $h_uce; ?>' ) document.forms.forms1.h_ucd.value = '<?php echo $h_uce; ?>';
        document.forms.forms1.h_ucd.focus();
        document.forms.forms1.h_ucd.select();
<?php
}
?>


                }

function UcdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_ucd.value != '' && document.forms1.h_ucd.value != '0' )
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myUcdelement.style.display=''; volajUcd(slpol,0); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '0'; document.forms.forms1.h_rdp.focus(); }
<?php
}
?>

        if ( document.forms1.h_ucd.value == '0' )
        {         
        if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '1';
        document.forms.forms1.h_rdp.focus();
         <?php if( $rozuct == 'ANO' ) echo "document.forms1.h_rdp.select();"; ?>
        }
              }

                }


//co urobi po potvrdeni ok z tabulky ucd
function vykonajUcd(ucd,ucdtext)
                {
         ukazUcd.innerHTML = "UCD: " + ucdtext;
         ukazUcd.style.display='';
         document.forms.forms1.h_ucd.value = ucd;
         myUcdelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '1';
         document.forms1.h_rdp.focus();
         <?php if( $rozuct == 'ANO' ) echo "document.forms1.h_rdp.select();"; ?>
                }


function Len1Ucd(ucd)
              {
         document.forms.forms1.h_ucd.value = ucd;
         myUcdelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_rdp.value == '' ) document.forms1.h_rdp.value = '1';
         document.forms1.h_rdp.focus();
         <?php if( $rozuct == 'ANO' ) echo "document.forms1.h_rdp.select();"; ?>
              }

function Len0Ucd()
                    {
         document.forms1.h_ucd.focus();
         document.forms1.h_ucd.select();
                    }



<?php
if ( $rozuct != 'ANO' ) 
{
?>
function RdpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        if ( document.forms1.h_fak.value == '' ) document.forms1.h_fak.value = '0';
        document.forms.forms1.h_fak.focus();
        document.forms.forms1.h_fak.select();
              }

                }
<?php
}
?>


<?php
if ( $rozuct == 'ANO' ) 
{
?>function RdpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_rdp.value != '' ) 

        { myRdpelement.style.display=''; volajRdp(slpol,0); }

               }

                }


//co urobi po potvrdeni ok z tabulky rdp
function vykonajRdp(rdp,rdptext)
                {
         ukazRdp.innerHTML = "Druh DPH: " + rdptext;
         ukazRdp.style.display='';
         document.forms.forms1.h_rdp.value = rdp;
         myRdpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_fak.value == '' ) document.forms1.h_fak.value = '0';
         document.forms1.h_fak.focus();
         document.forms1.h_fak.select();
                }


function Len1Rdp(rdp)
              {
         document.forms.forms1.h_rdp.value = rdp;
         myRdpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_fak.value == '' ) document.forms1.h_fak.value = '0';
         document.forms1.h_fak.focus();
         document.forms1.h_fak.select();
              }

function Len0Rdp()
                    {
         document.forms1.h_rdp.focus();
         document.forms1.h_rdp.select();
                    }

<?php
}
?>

function FakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        if ( document.forms1.h_fak.value != '' && document.forms1.h_fak.value != '0'  ) { volajPriku(4); }
        if ( document.forms1.h_ico.value == '' ) document.forms1.h_ico.value = '<?php echo $h_ico; ?>';
        if ( document.forms1.h_ico.value == '0' ) document.forms1.h_ico.value = '<?php echo $h_ico; ?>';
        document.forms.forms1.h_ico.focus();
        document.forms.forms1.h_ico.select();
              }

                }

function IcpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_ico.value != '' && document.forms1.h_ico.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myIcpelement.style.display=''; volajIcp(slpol,0); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0'; document.forms.forms1.h_str.focus(); document.forms.forms1.h_str.select(); }
<?php
}
?>
        if ( document.forms1.h_ico.value == '0' )
        {         
        if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0';
        document.forms.forms1.h_str.focus();
        document.forms.forms1.h_str.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky ico
function vykonajIcp(ico,icptext)
                {
         ukazIcp.innerHTML = "I»O: " + icptext;
         ukazIcp.style.display='';
         document.forms.forms1.h_ico.value = ico;
         myIcpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0';
         document.forms1.h_str.focus();
         document.forms1.h_str.select();
                }


function Len1Icp(ico)
              {
         document.forms.forms1.h_ico.value = ico;
         myIcpelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_str.value == '' ) document.forms1.h_str.value = '0';
         document.forms1.h_str.focus();
         document.forms1.h_str.select();
              }

function Len0Icp()
                    {
         document.forms1.h_rdp.focus();
         document.forms1.h_rdp.select();
                    }


function StrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_str.value != '' && document.forms1.h_str.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myStrelement.style.display=''; volajStr(slpol,0); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0'; document.forms.forms1.h_zak.focus(); document.forms.forms1.h_zak.select(); }
<?php
}
?>
        if ( document.forms1.h_str.value == '0' )
        {         
        if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0';
        document.forms.forms1.h_zak.focus();
        document.forms.forms1.h_zak.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky str
function vykonajStr(str,strtext)
                {
         ukazStr.innerHTML = "Stredisko: " + strtext;
         ukazStr.style.display='';
         document.forms.forms1.h_str.value = str;
         myStrelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0';
         document.forms1.h_zak.focus();
         document.forms1.h_zak.select();
                }


function Len1Str(str)
              {
         document.forms.forms1.h_str.value = str;
         myStrelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_zak.value == '' ) document.forms1.h_zak.value = '0';
         document.forms1.h_zak.focus();
         document.forms1.h_zak.select();
              }

function Len0Str()
                    {
         document.forms1.h_str.focus();
         document.forms1.h_str.select();
                    }


function ZakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        var slpol = document.forms1.slpol.value;
        if ( document.forms1.h_zak.value != '' && document.forms1.h_zak.value != '0' ) 
<?php
if ( $sysx == 'UCT' ) 
{
?>
        { myZakelement.style.display=''; volajZak(slpol,0); }
<?php
}
?>
<?php
if ( $sysx != 'UCT' ) 
{
?>
        { if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0'; document.forms.forms1.h_hop.focus(); document.forms.forms1.h_hop.select(); }
<?php
}
?>
        if ( document.forms1.h_zak.value == '0' )
        {         
        if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0';
        document.forms.forms1.h_hop.focus();
        document.forms.forms1.h_hop.select();
        }
              }

                }


//co urobi po potvrdeni ok z tabulky zak
function vykonajZak(str,zak,zaktext)
                {
         ukazZak.innerHTML = "Z·kazka: " + zaktext;
         ukazZak.style.display='';
         document.forms.forms1.h_zak.value = zak;
         document.forms.forms1.h_str.value = str;
         myZakelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0';
         document.forms1.h_hop.focus();
         document.forms1.h_hop.select();
                }


function Len1Zak(str,zak)
              {
         document.forms.forms1.h_zak.value = zak;
         document.forms.forms1.h_str.value = str;
         myZakelement.style.display='none';
         ZhasniSP();
         if ( document.forms1.h_hop.value == '' ) document.forms1.h_hop.value = '0';
         document.forms1.h_hop.focus();
         document.forms1.h_hop.select();
              }

function Len0Zak()
                    {
         document.forms1.h_zak.focus();
         document.forms1.h_zak.select();
                    }

<?php if( $textpopis == 0 )  { ?>

function HopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.forms1.err_ucm.value == '1' ) okvstup=0;

    if ( document.forms1.h_ucm.value == '' ) okvstup=0;
    if ( document.forms1.h_ucd.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '0' ) okvstup=0;

<?php if( $kontrolastrzak == 1 ) { ?>

    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;

    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;

<?php                           } ?>

    if ( okvstup == 2 ) { document.forms1.uloz.disabled = true; Fx.style.display=""; document.forms1.h_str.focus(); document.forms1.h_str.select(); }
    if ( okvstup == 1 ) { document.forms.forms1.submit(); return (true); }
    if ( okvstup == 0 && document.forms1.err_ucm.value == '1' ) { document.forms1.h_ucm.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '' ) { document.forms1.h_hop.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '0' ) { document.forms1.h_hop.focus(); return (false); }
              }
                }

<?php                       } ?>


<?php if( $textpopis == 1 )  { ?>

function HopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        document.forms.forms1.h_pop.focus();
        document.forms.forms1.h_pop.select();
              }

                }

<?php                       } ?>


function JUPopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.forms1.err_ucm.value == '1' ) okvstup=0;

    if ( document.forms1.h_ucm.value == '' ) okvstup=0;
    if ( document.forms1.h_ucd.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '0' ) okvstup=0;

<?php if( $kontrolastrzak == 1 ) { ?>

    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;

    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;

<?php                           } ?>

    if ( okvstup == 2 ) { document.forms1.uloz.disabled = true; Fx.style.display=""; document.forms1.h_str.focus(); document.forms1.h_str.select(); }
    if ( okvstup == 1 ) { document.forms.forms1.submit(); return (true); }
    if ( okvstup == 0 && document.forms1.err_ucm.value == '1' ) { document.forms1.h_ucm.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '' ) { document.forms1.h_hop.focus(); return (false); }
    if ( okvstup == 0 && document.forms1.h_hop.value == '0' ) { document.forms1.h_hop.focus(); return (false); }
              }
                }

function HdxEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {

        document.forms.forms1.h_hop.focus();
        document.forms.forms1.h_hop.select();
              }

                }

                 
//co urobi po potvrdeni ok z tabulky sluzby
function vykonajSlu(slu,nazov,dph,cenap,cenad,mer)
                {
        document.forms.forms1.h_slu.value = slu;
        document.forms.forms1.h_nsl.value = nazov;
        document.forms.forms1.h_dph.value = dph;
        document.forms.forms1.h_cep.value = cenap;
        document.forms.forms1.h_ced.value = cenad;
        document.forms.forms1.h_mer.value = mer;
        myDivElement.style.display='none';
        document.forms.forms1.h_mno.focus();
                }

function nulujPol()
                {

        Nen.style.display="none";
                }


    function ObnovUI()
    {
    <?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    }

    function VyberVstup()
    {
    if( document.forms1.h_fak.value == '' ) { document.forms1.h_fak.value = 0; }
<?php if( $mazanie == 1 ) { 
    echo "document.forms1.h_ucm.value = '$z_ucm';\r";
    echo "document.forms1.h_ucd.value = '$z_ucd';\r";
    echo "document.forms1.h_rdp.value = '$z_rdp';\r";
    echo "document.forms1.h_fak.value = '$z_fak';\r";
    echo "document.forms1.h_ico.value = '$z_ico';\r";
    echo "document.forms1.h_str.value = '$z_str';\r";
    echo "document.forms1.h_zak.value = '$z_zak';\r";
    echo "document.forms1.h_hop.value = '$z_hop';\r";
    if( $textpopis == 1 ) { echo "document.forms1.h_pop.value = '$z_pop';\r"; }
                          } ?>
<?php if( $mazanie != 1 ) { 
    if( $textpopis == 1 ) { echo "document.forms1.h_pop.value = '$h_pop';\r"; }
                          } ?>
<?php
if ( $drupoh == 1 OR $drupoh == 3 ) 
{
?>
    document.forms.forms1.h_ucm.value = '<?php echo $h_uce; ?>';
<?php
}
?>

<?php
if ( ( $drupoh == 4 OR $drupoh == 5 ) AND $mazanie != 1 ) 
{
?>
    document.forms.forms1.h_ucm.value = '<?php echo $h_ucm; ?>';
    document.forms.forms1.h_ucd.value = '<?php echo $h_ucd; ?>';
<?php
}
?>

<?php
if ( $drupoh == 2 ) 
{
?>
    document.forms.forms1.h_ucd.value = '<?php echo $h_uce; ?>';
<?php
}
?>
    document.forms1.h_cpl.disabled = true;
    document.forms1.h_ne1.disabled = true;
    document.forms1.uloz.disabled = true;
<?php if( $fir_allx15 == 0 OR $drupoh != 4 OR $copern == 87 ) { ?>
    document.forms1.h_ucm.focus();
    document.forms1.h_ucm.select();
<?php                                         } ?>
<?php if( $fir_allx15 == 1 AND $drupoh == 4 AND $copern != 87 ) { ?>
    document.forms1.ddu.focus();
    document.forms1.ddu.select();
<?php                                         } ?>
<?php
if ( $copern == 87 ) 
{
?>
    document.forms.forms1.h_ucm.value = '<?php echo $z_ucm; ?>';
    document.forms.forms1.h_ucd.value = '<?php echo $z_ucd; ?>';
    document.forms.forms1.h_rdp.value = '<?php echo $z_rdp; ?>';
    document.forms.forms1.h_fak.value = '<?php echo $z_fak; ?>';
    document.forms.forms1.h_ico.value = '<?php echo $z_ico; ?>';
    document.forms.forms1.h_str.value = '<?php echo $z_str; ?>';
    document.forms.forms1.h_zak.value = '<?php echo $z_zak; ?>';
    document.forms.forms1.h_hop.value = '<?php echo $z_hop; ?>';
<?php
}
?>
    }

    function Hlas()
    {
    document.forms1.hlas.value = 'ANO';
    }

    function NeHlas()
    {
    document.forms1.hlas.value = 'NIE';
    }

    function Zapis_COOK()
    {

    return (true);
    }

    function Povol_uloz()
    {
    var okvstup=1;

    if ( document.forms1.err_ucm.value == '1' ) okvstup=0;

    if ( document.forms1.h_ucm.value == '' ) okvstup=0;
    if ( document.forms1.h_ucd.value == '' ) okvstup=0;
    if ( document.forms1.h_hop.value == '' ) okvstup=0;

<?php if( $kontrolastrzak == 1 ) { ?>

    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 500000 && document.forms1.h_ucm.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 500000 && document.forms1.h_ucd.value <= 699999 && document.forms1.h_zak.value == '' ) okvstup=2;

    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_str.value == '' ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucm.value >= 50000 && document.forms1.h_ucm.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == 0 ) okvstup=2;
    if ( document.forms1.h_ucd.value >= 50000 && document.forms1.h_ucd.value <= 69999 && document.forms1.h_zak.value == '' ) okvstup=2;

<?php                           } ?>

    if ( okvstup == 1 ) { document.forms1.uloz.disabled = false; Fx.style.display="none"; return (true); }
    if ( okvstup == 0 ) { document.forms1.uloz.disabled = true; Fx.style.display=""; return (false) ; }
    if ( okvstup == 2 ) { document.forms1.uloz.disabled = true; Fx.style.display=""; document.forms1.h_str.focus(); document.forms1.h_str.select(); }
    }

    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    Zm.style.display="none";
    NiejeUce.style.display="none";
    NiejeIcp.style.display="none";
    NiejeStr.style.display="none";
    NiejeZak.style.display="none";
    NiejeRdp.style.display="none";
    Uce.style.display="none";
    Fak.style.display="none";
    Ico.style.display="none";
    Str.style.display="none";
    Zak.style.display="none";
    Des.style.display="none";
    Rdp.style.display="none";
    }


<?php
//koniec skriptu 7 77777777
}?>


//script pre copern  17 171717171717 vstup text sluzby
<?php
if ( $copern == 17 OR $copern == 97 ) 
{?>


function PopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ) {
        document.forms.forms1.h_mer.focus();
        document.forms.forms1.h_mer.select();
              }

                }


function MerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.forms1.h_pop.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.forms.forms1.submit(); return (true); }
    if ( okvstup == 0 && document.forms1.h_pop.value == '' ) { document.forms1.h_pop.focus(); return (false); }
              }
                }
                 
    function ObnovUI()
    {
    <?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    }
    function VyberVstup()
    {
    document.forms1.h_cpl.disabled = true;
    document.forms1.uloz.disabled = true;
<?php
if ( $copern == 97 ) 
{
?>
    document.forms.forms1.h_pop.value = '<?php echo $z_pop; ?>';
<?php
}
?>
    document.forms1.h_pop.focus();
    document.forms1.h_pop.select();
    }

    function Zapis_COOK()
    {

    return (true);
    }

    function Povol_uloz()
    {
    var okvstup=1;

    if ( document.forms1.h_pop.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.forms1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

    function ZhasniSP()
    {
    Fx.style.display="none";
    Ul.style.display="none";
    Zm.style.display="none";
    NiejeUce.style.display="none";
    NiejeIcp.style.display="none";
    NiejeStr.style.display="none";
    NiejeZak.style.display="none";
    NiejeRdp.style.display="none";
    Uce.style.display="none";
    Fak.style.display="none";
    Ico.style.display="none";
    Str.style.display="none";
    Zak.style.display="none";
    Des.style.display="none";
    Rdp.style.display="none";
    }


<?php
//koniec skriptu 17 171717171717
}?>


//script pre copern 5555555555555[[[[[[[[[[88888888888888888
<?php
if ( $copern == 5 OR $copern == 8 ) 
{?>
    function ObnovUI()
    {
<?php if( $vybr == 'ANO' )
{
  if( $cislo_uce != '' ) { echo "document.fhlv1.h_uce.value = '$cislo_uce';"; }
 echo "document.fhlv1.h_dok.value = '$cislo_dok';";
 echo "document.fhlv1.h_dat.value = '$cislo_dat';";
 echo "document.fhlv1.h_unk.value = '$cislo_unk';";
 echo "document.fhlv1.h_kto.value = '$cislo_kto';";
 echo "document.fhlv1.h_hod.value = '$cislo_hod';";
 echo "document.fhlv1.h_zk0.value = '$cislo_zk0';";
 echo "document.fhlv1.h_sp0.value = '$cislo_zk0';";
 echo "document.fhlv1.h_zk1.value = '$cislo_zk1';";
 echo "document.fhlv1.h_zk2.value = '$cislo_zk2';";
 echo "document.fhlv1.h_dn1.value = '$cislo_dn1';";
 echo "document.fhlv1.h_dn2.value = '$cislo_dn2';";
 echo "document.fhlv1.h_sp1.value = '$cislo_sp1';";
 echo "document.fhlv1.h_sp2.value = '$cislo_sp2';";
 echo "document.fhlv1.h_poz.value = '$cislo_poz';";
 echo "document.fhlv1.h_txp.value = '$cislo_txp';";
// echo "document.fhlv1.h_txz.value = '$cislo_txz';";
 echo "document.fhlv1.h_ico.value = '$cislo_ico';";
 echo "document.fhlv1.h_nai.value = '$vybr_nai';";
}
?>
    }

    function Hlat()
    {
    document.fhlv1.hlat.value = 'ANO';
    }

    function NeHlat()
    {
    document.fhlv1.hlat.value = 'NIE';
    }


    function Rozb1()
    {
    document.fhlv1.rozb1.value = 'VELKE';
    }

    function NeRozb1()
    {
    document.fhlv1.rozb1.value = 'MALE';
    }

    function Rozb2()
    {
    document.fhlv1.rozb2.value = 'VELKE';
    }

    function NeRozb2()
    {
    document.fhlv1.rozb2.value = 'MALE';
    }

    function Sluz1()
    {
    document.fhlv1.sluz1.value = 'VELKE';
    }

    function NeSluz1()
    {
    document.fhlv1.sluz1.value = 'MALE';
    }


    function Povol_uloz()
    {
    var okvstup=1;

    if ( document.fhlv1.h_dat.value == '' ) okvstup=0;
    if ( document.fhlv1.h_ico.value == '' ) okvstup=0;
    if ( document.fhlv1.err_dat.value == '1' ) okvstup=0;
    if ( document.fhlv1.err_ico.value == '1' ) okvstup=0;

    if ( okvstup == 1 )
       { 
         document.fhlv1.uloh.disabled = false;
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 OR $drupoh == 5 )
{
?>
 document.fhlv1.sluzby.disabled = false;
<?php
}
?>
         Fxh.style.display="none"; return (true);
       }
       else { 
            document.fhlv1.uloh.disabled = true;
            <?php
            if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 OR $drupoh == 5  )
            {
            ?>
            document.fhlv1.sluzby.disabled = true;
            <?php
            }
            ?>
            Fxh.style.display="";
            if ( okvstup == 0 && document.fhlv1.h_kto.value == '' ){ document.fhlv1.h_kto.focus();}
            return (false) ;
            }

    }

    function VyberVstup()
    {

<?php if( $hlat == 'ANO' OR $rozb1 == 'VELKE' OR $rozb2 == 'VELKE' OR $rozb1 == 'MALE' OR $rozb2 == 'MALE'  )
{
  if( $h_uce != '' ) { echo "document.fhlv1.h_uce.value = '$h_uce';"; }
 echo "document.fhlv1.h_dok.value = '$h_dok';";
 echo "document.fhlv1.h_das.value = '$h_das';";
 echo "document.fhlv1.h_daz.value = '$h_daz';";
 echo "document.fhlv1.h_dat.value = '$h_dat';";
 echo "document.fhlv1.h_dol.value = '$h_dol';";
 echo "document.fhlv1.h_prf.value = '$h_prf';";
 echo "document.fhlv1.h_str.value = '$h_str';";
 echo "document.fhlv1.h_sth.value = '$h_str';";
 echo "document.fhlv1.h_zak.value = '$h_zak';";
 echo "document.fhlv1.h_ksy.value = '$h_ksy';";
 echo "document.fhlv1.h_ssy.value = '$h_ssy';";
 echo "document.fhlv1.h_dol.value = '$h_dol';";
 echo "document.fhlv1.h_prf.value = '$h_prf';";
 echo "document.fhlv1.h_obj.value = '$h_obj';";
 echo "document.fhlv1.h_unk.value = '$h_unk';";
 echo "document.fhlv1.h_dpr.value = '$h_dpr';";
 echo "document.fhlv1.h_hod.value = '$h_hod';";
 echo "document.fhlv1.h_zal.value = '$h_zal';";
 echo "document.fhlv1.h_zk0.value = '$h_zk0';";
 echo "document.fhlv1.h_sp0.value = '$h_zk0';";
 echo "document.fhlv1.h_zk1.value = '$h_zk1';";
 echo "document.fhlv1.h_zk2.value = '$h_zk2';";
 echo "document.fhlv1.h_dn1.value = '$h_dn1';";
 echo "document.fhlv1.h_dn2.value = '$h_dn2';";
 echo "document.fhlv1.h_sp1.value = '$h_sp1';";
 echo "document.fhlv1.h_sp2.value = '$h_sp2';";
 echo "document.fhlv1.h_poz.value = '$h_poz';";
}
?>

<?php if( $hlat != 'ANO' AND $vybr != 'ANO' AND $rozb1 != 'VELKE' AND $rozb2 != 'VELKE' AND $rozb1 != 'MALE' AND $rozb2 != 'MALE' )
{
 echo "document.forms.fhlv1.h_dat.focus();";
}
?>

<?php if( $vybr == 'ANO' )
{
?>
  document.fhlv1.h_dat.focus();
<?php
}
?>

<?php if( $rozb1 == 'VELKE' )
{
?>
  document.fhlv1.h_txp.focus();
<?php
}
?>

<?php if( $rozb2 == 'VELKE' )
{
?>
  document.fhlv1.h_txz.focus();
<?php
}
?>

<?php if( $rozb1 == 'MALE' )
{
?>
  document.fhlv1.h_zk1.focus();
<?php
}
?>

<?php if( $rozb2 == 'MALE' )
{
?>
  document.fhlv1.h_poz.focus();
<?php
}
?>

    document.fhlv1.uloh.disabled = true;
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 OR $drupoh == 5 )
{
?>
 document.fhlv1.sluzby.disabled = true;
<?php
}
?>
    <?php  if( $hladaj_uce != '' ) { ?> document.fhlv1.h_uce.value='<?php echo $hladaj_uce;?>'; <?php } ?>
    document.fhlv1.nwwdok.disabled = true;
    document.fhlv1.h_ucenew.value = document.fhlv1.h_uce.value;
    document.fhlv1.h_ucenew.disabled = true;
   }


    function Zapis_COOK()
    {

    return (true);
    }

    function Obnov_vstup()
    {

    return (true);
    }


<?php
}?>
//koniec scriptu copern 5,8

//[[[[[[[[[[[[
//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1965 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1965.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1)
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;

         if (b == "") { err=0 }
         if (Math.floor(b)==b && b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9]/g) != -1) { err=1 }
         if (Math.floor(b)!=b && b != "") { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 OR $drupoh == 5 )
{
?>
 document.fhlv1.sluzby.disabled = true;
<?php
}
?>
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 5 OR $copern == 8 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 OR $drupoh == 5  )
{
?>
 document.fhlv1.sluzby.disabled = true;
<?php
}
?>
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
<?php if( $_SESSION['nieie'] == 0 )  { ?>
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;
<?php                                } ?>
    }

//funkcia na zobrazenie popisu poloziek
    function UkazSkryjPol (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;
    }

  function ukazrobot()
  { 
  myRobot = document.getElementById("robotokno");
  myRobotmenu = document.getElementById("robotmenu");
  myRobothlas = document.getElementById("robothlas");
  myRobot.style.top = toprobot;
  myRobot.style.left = leftrobot;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobothlas.style.top = toprobothlas;
  myRobothlas.style.left = leftrobothlas;
  <?php if( $kli_vduj >= 0 AND $vyb_robot == 1 ) { echo "robotokno.style.display=''; robotmenu.style.display='none';"; } ?>
  }

  function zhasnirobot()
  { 
  robotokno.style.display='none';
  robotmenu.style.display='none';
  robothlas.style.display='none';
  }

  function zobraz_robotmenu()
  { 
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlmenu;
  robotmenu.style.display='';
  hodprevz.style.display='';
  }

  function zobraz_robotmenudiv()
  { 
  hodprevz.style.display='';
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  robotmenu.style.display='none';
  robothlas.style.display='none';
  hodprevz.style.display='none';
  }

    var toprobot = 280;
    var leftrobot = 19;
    var toprobotmenu = 260;
    var leftrobotmenu = 50;
    var widthrobotmenu = 400;
    var toprobothlas = 300;
    var leftrobothlas = 60;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>";
    htmlmenu += "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmenu += "onClick='zhasni_menurobot();' alt='Zhasni menu' title='Zhasni menu' ></td></tr>";  

<?php if( $copern == 5 AND $drupoh < 3 ) { ?>

<?php
$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }
$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; $nuctpoh=""; }

$sqltt = "SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ucto = '$kli_vduj' AND druh = '$drupoh' ORDER BY cpoh";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$kli_vduj=1*$kli_vduj;
?>

    var toprobotmenu = toprobot - <?php echo $cpol; ?>*19;

    if( toprobot < 100 ) { toprobot=100; }

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(<?php echo $kli_vduj; ?>,<?php echo $drupoh; ?>,<?php echo $riadok->cpoh; ?>)\">" +
"Chcete za˙Ëtovaù <?php echo $riadok->pohp; ?> ?</a>";
    htmlmenu += "</td></tr>";

<?php
  }
$i=$i+1;
   }
?>

<?php                    } ?>



<?php if( $copern == 7 AND $kli_vduj == 9 ) { ?>

    var toprobotmenu = toprobot-6*19;
    <?php if( $drupoh == 1 OR $drupoh == 2 ) { echo "var toprobotmenu = toprobot-3*19;"; }?>

    if( toprobot < 100 ) { toprobot=100; }

<?php if( $drupoh == 4 OR $drupoh == 5 OR $drupoh == 2 ) { ?>
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(19,<?php echo $drupoh+100; ?>,22)\">" +
"Chcete za˙Ëtovaù ˙hradu dod·vateæskej fakt˙ry za materi·l ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(19,<?php echo $drupoh+100; ?>,23)\">" +
"Chcete za˙Ëtovaù ˙hradu dod·vateæskej fakt˙ry za tovar ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(19,<?php echo $drupoh+100; ?>,24)\">" +
"Chcete za˙Ëtovaù ˙hradu dod·vateæskej fakt˙ry za ostatnÈ ?</a>";
    htmlmenu += "</td></tr>";
<?php                                    } ?>

<?php if( $drupoh == 4 OR $drupoh == 5 OR $drupoh == 1 ) { ?>
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(19,<?php echo $drupoh+200; ?>,60)\">" +
"Chcete za˙Ëtovaù ˙hradu odberateæskej fakt˙ry za tovar ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(19,<?php echo $drupoh+200; ?>,61)\">" +
"Chcete za˙Ëtovaù ˙hradu odberateæskej fakt˙ry za v˝robky a sluûby ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"volajAutoUCT(19,<?php echo $drupoh+200; ?>,62)\">" +
"Chcete za˙Ëtovaù ˙hradu odberateæskej fakt˙ry za ostatnÈ ?</a>";
    htmlmenu += "</td></tr>";
<?php                                    } ?>

<?php                                       } ?>





    htmlmenu += "</table>";  
    
</script>

<?php if( $kli_vduj >= 0 AND $vyb_robot == 1 ) 
{ echo "<script type='text/javascript' src='robot_ucto.js'></script>"; } ?>

<?php if( ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 ) AND $copern == 7 ) 
{ echo "<script type='text/javascript' src='../ucto/uloz_mena.js'></script>"; } ?>

<script type='text/javascript'>


<?php if( $copern == 7 ) { ?>

//co urobi po potvrdeni ok z tabulky Priku
function vykonajPriku4(ico,nai,mes,vsy,uceb,uce,uc1,zos,nm1,fak,ksy,ssy,hdx)
                {
        document.forms.forms1.h_ico.value = ico;
        document.forms.forms1.h_fak.value = fak;
        document.forms.forms1.h_hop.value = zos;
        document.forms.forma4.h_hdx.value = hdx;
        myPrikuelement.style.display='none';
        document.forms.forms1.h_hop.focus();
        document.forms.forms1.h_hop.select();
                }


function volatPriku4()
                    {
    if ( document.forms1.h_fak.value != '' ) { volajPriku(4); }
                    }


function Len1Priku()
                    {
        myPrikuelement.style.display='none';
        document.forms.forms1.h_hop.focus();
        document.forms.forms1.h_hop.select();
                    }

function Len0Priku()
                    {
        myPrikuelement.style.display='none';
        document.forms.forms1.h_ico.focus();
        document.forms.forms1.h_ico.select();
                    }

<?php                   } ?>



<?php if( $_SESSION['nieie'] >= 0 )  { ?>
    function VytlacDoklad()
    {
  var h_razitko = 0;
<?php
if ( $copern == 7 AND $drupoh < 4 )
     {
?>
  if( document.formx1.h_razitko.checked ) h_razitko=1;
<?php
     }
?>

    window.open('vspk_pdf.php?h_razitko=' + h_razitko + '&sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_dok=<?php echo $cislo_dok;?>&fff=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

    function PoklKniha()
    {

    var ucet = document.forms1.hladaj_uce.value;
    window.open('pokl_kniha.php?copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&cislo_uce=' + ucet + '&page=1&cele=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

    function TlacBank()
    {

    window.open('uctpohyby_pol.php?copern=80&drupoh=4&page=1&typ=PDF&cislo_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>&page=1&cele=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

    function MesPoklKniha()
    {

    var ucet = document.forms1.hladaj_uce.value;
    window.open('pokl_kniha.php?copern=40&drupoh=<?php echo $drupoh; ?>&page=1&typ=HTML&cislo_uce=' + ucet + '&page=1&cele=0', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

<?php                                } ?>



<?php //predvolene texty pre pokl doklad
if( ( $drupoh == 1 OR $drupoh == 2 ) AND ( $copern == 5 OR $copern == 8 ) ) { 
  if( $drupoh == 1 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 21 ORDER BY cpt"); }
  if( $drupoh == 2 ) { $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 31 ORDER BY cpt"); }
$i=0;
while( $i <= 3 ) {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
  $riadok=mysql_fetch_object($sql);
  if( $i == 0 ) $ptxp1=$riadok->txx;
  if( $i == 1 ) $ptxp2=$riadok->txx;
  if( $i == 2 ) $ptxp3=$riadok->txx;
  if( $i == 3 ) $ptxp4=$riadok->txx;
  }
$i=$i+1;
                 }
$pole_txp1 = explode("\r\n", $ptxp1);
$pole_txp2 = explode("\r\n", $ptxp2);
$pole_txp3 = explode("\r\n", $ptxp3);
$pole_txp4 = explode("\r\n", $ptxp4);

?>
    htmlptxp1_1 = "<?php echo $pole_txp1[0];?>";
    htmlptxp1_2 = "<?php echo $pole_txp1[1];?>";
    htmlptxp1_3 = "<?php echo $pole_txp1[2];?>";
    htmlptxp1_4 = "<?php echo $pole_txp1[3];?>";
    htmlptxp1_5 = "<?php echo $pole_txp1[4];?>";
    htmlptxp2_1 = "<?php echo $pole_txp2[0];?>";
    htmlptxp2_2 = "<?php echo $pole_txp2[1];?>";
    htmlptxp2_3 = "<?php echo $pole_txp2[2];?>";
    htmlptxp2_4 = "<?php echo $pole_txp2[3];?>";
    htmlptxp2_5 = "<?php echo $pole_txp2[4];?>";
    htmlptxp3_1 = "<?php echo $pole_txp3[0];?>";
    htmlptxp3_2 = "<?php echo $pole_txp3[1];?>";
    htmlptxp3_3 = "<?php echo $pole_txp3[2];?>";
    htmlptxp3_4 = "<?php echo $pole_txp3[3];?>";
    htmlptxp3_5 = "<?php echo $pole_txp3[4];?>";
    htmlptxp4_1 = "<?php echo $pole_txp4[0];?>";
    htmlptxp4_2 = "<?php echo $pole_txp4[1];?>";
    htmlptxp4_3 = "<?php echo $pole_txp4[2];?>";
    htmlptxp4_4 = "<?php echo $pole_txp4[3];?>";
    htmlptxp4_5 = "<?php echo $pole_txp4[4];?>";

    function Txp1()
    {
    document.fhlv1.h_txp.value = htmlptxp1_1 + "\r\n" + htmlptxp1_2 + "\r\n" + htmlptxp1_3 + "\r\n" + htmlptxp1_4 + "\r\n" + htmlptxp1_5;
    }
    function Txp2()
    {
    document.fhlv1.h_txp.value = htmlptxp2_1 + "\r\n" + htmlptxp2_2 + "\r\n" + htmlptxp2_3 + "\r\n" + htmlptxp2_4 + "\r\n" + htmlptxp2_5;
    }
    function Txp3()
    {
    document.fhlv1.h_txp.value = htmlptxp3_1 + "\r\n" + htmlptxp3_2 + "\r\n" + htmlptxp3_3 + "\r\n" + htmlptxp3_4 + "\r\n" + htmlptxp3_5;
    }
    function Txp4()
    {
    document.fhlv1.h_txp.value = htmlptxp4_1 + "\r\n" + htmlptxp4_2 + "\r\n" + htmlptxp4_3 + "\r\n" + htmlptxp4_4 + "\r\n" + htmlptxp4_5;
    }

<?php //koniec predvolene texty pre pokl.doklad
                   } ?>

</script>


<?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 ) 
{ echo "<script type='text/javascript' src='daj_priku.js'></script>"; } ?>


<?php if( $copern == 7 AND $drupoh >= 1 )       { ?>
<script type='text/javascript'>

function PonukaBanka()
                {

var h_ico = document.forms.forms1.h_ico.value;

window.open('../ucto/ponuka_banka.php?uhr=1&pol=0&dea=0&h_ico=' + h_ico + '&copern=11&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function PonukaHodnota()
                {

var h_ico = document.forms.forms1.h_ico.value;
var h_hop = document.forms.forms1.h_hop.value;
var h_ucm = document.forms.forms1.h_ucm.value;
var h_ucd = document.forms.forms1.h_ucd.value;

window.open('../ucto/ponuka_banka.php?uhr=1&pol=0&dea=0&h_ico=' + h_ico + '&h_hop=' + h_hop + '&h_ucm=' + h_ucm + '&h_ucd=' + h_ucd + '&copern=12&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function PonukaSaldo()
                {

var h_ico = document.forms.forms1.h_ico.value;
var h_ucm = document.forms.forms1.h_ucm.value;
var h_ucd = document.forms.forms1.h_ucd.value;

window.open('../ucto/ponuka_banka.php?uhr=1&pol=0&dea=0&h_ico=' + h_ico + '&h_ucm=' + h_ucm +  '&h_ucd=' + h_ucd + '&copern=13&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


</script>
<?php                          } ?>

<?php if( $copern == 7 AND $drupoh == 5 AND $agrostav == 1 )       { ?>
<script type='text/javascript'>

function ZosRezia()
                {

window.open('../ucto/agrostav_rezia.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function RozRezia()
                {

window.open('../ucto/agrostav_rezia.php?copern=2&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>', '_self' );
                }

function ZosObst()
                {

window.open('../ucto/agrostav_obstaranie.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function RozObst()
                {

window.open('../ucto/agrostav_obstaranie.php?copern=2&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>', '_self' );
                }



</script>
<?php                          } ?>

<?php if( $copern == 7 AND $drupoh == 5 AND $agrostav == 0 )       { ?>
<script type='text/javascript'>

function ZosORezia()
                {

window.open('../ucto/obecne_rezia.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function RozORezia()
                {

window.open('../ucto/obecne_rezia.php?copern=2&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>', '_self' );
                }

function DoDatabazy( unk )
                {

window.open('../ucto/db_dokladov.php?copern=1&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>&unk=' + unk + '&kkk=1', '_self' );
                }

function ZDatabazy()
                {

window.open('../ucto/db_dokladov.php?copern=2&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>', '_self' );
                }

function ZosPRezia()
                {

window.open('../ucto/polno_rezia.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function RozPRezia()
                {

window.open('../ucto/polno_rezia.php?copern=2&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>', '_self' );
                }

function ZosPNedok()
                {

window.open('../ucto/polno_nedok.php?copern=1&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function RozPNedok()
                {

window.open('../ucto/polno_nedok.php?copern=2&drupoh=1&page=1&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>', '_self' );
                }

</script>
<?php                          } ?>


<script type='text/javascript'>

function newIco()
                {

window.open('../cis/cico.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=5&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

<?php if( $tlacitkoenter == 1 ) {  ?>

    function polohaen1()
    { 
  myEnter = document.getElementById("tlacitkoEnter");
  myEnter.style.top = 95;
  myEnter.style.left = 405;
    }

    function polohaen2()
    { 
  myEnter = document.getElementById("tlacitkoEnter");
  myEnter.style.top = 300;
  myEnter.style.left = 405;
    }

    function polohaen3()
    { 
  myEnter = document.getElementById("tlacitkoEnter");
  myEnter.style.top = 240;
  myEnter.style.left = 405;
    }

    function ukaztlacitkoEnter()
    { 
    tlacitkoEnter.style.display='';
    }

    function zhasni_Enter()
    { 
    tlacitkoEnter.style.display='none';
    }

    function tlacitko_Enter()
    { 

    <?php if( $copern == 5 OR $copern == 8 ) {  ?>
    document.forms.fhlv1.klikenter.value=1;
    if( document.forms.fhlv1.kdefoc.value == 'uce' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; UceEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'ico' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; IcoEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'nai' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; NaiEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dat' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; DatEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'unk' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen1(); document.forms.fhlv1.klikenter.value=0; UnkEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'kto' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; KtoEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zk1' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Zk1Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dn1' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Dn1Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zk2' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Zk2Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'dn2' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Dn2Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'zk0' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; Zk0Enter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'hod' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; HodEnter(13); }
    if( document.forms.fhlv1.kdefoc.value == 'txp' && document.forms.fhlv1.klikenter.value == 1 ) { polohaen2(); document.forms.fhlv1.klikenter.value=0; TxpEnter(13); }
    <?php                    }  ?>
    <?php if( $copern == 7 ) {  ?>
    document.forms.forms1.klikenter.value=1;
    if( document.forms.forms1.kdefoc.value == 'ucm' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; UcmEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'ucd' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; UcdEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'rdp' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; RdpEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'fak' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; FakEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'ico' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; IcpEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'str' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; StrEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'zak' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; ZakEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'hop' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; HopEnter(13); }
    if( document.forms.forms1.kdefoc.value == 'pop' && document.forms.forms1.klikenter.value == 1  ) { document.forms.forms1.klikenter.value=0; JUPopEnter(13); }
    <?php                    }  ?>
    }


<?php                           }  ?> 

    <?php if( $copern == 5 OR $copern == 8 ) {  ?>
    function onUce()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'uce';"; } ?>  }
    function onIco()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'ico';"; } ?>  }
    function onNai()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'nai';"; } ?>  }
    function onDat()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dat';"; } ?>  }
    function onUnk()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'unk';"; } ?>  }
    function onKto()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'kto';"; } ?>  }
    function onZk1()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zk1';"; } ?>  }
    function onDn1()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dn1';"; } ?>  }
    function onZk2()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zk2';"; } ?>  }
    function onDn2()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'dn2';"; } ?>  }
    function onZk0()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'zk0';"; } ?>  }
    function onHod()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'hod';"; } ?>  }
    function onTxp()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.fhlv1.kdefoc.value = 'txp';"; } ?>  }
    <?php                    }  ?>
    <?php if( $copern == 7 ) {  ?>
    function onUcm()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'ucm';"; } ?>  }
    function onUcd()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'ucd';"; } ?>  }
    function onRdp()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'rdp';"; } ?>  }
    function onFak()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'fak';"; } ?>  }
    function onIco()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'ico';"; } ?>  }
    function onStr()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'str';"; } ?>  }
    function onZak()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'zak';"; } ?>  }
    function onHop()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'hop';"; } ?>  }
    function onPop()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.forms1.kdefoc.value = 'pop';"; } ?>  }
    <?php                    }  ?>


function regpokpri()
                {
    <?php if( $ajregistracka == 1 ) {  ?>
window.open('../doprava/regpok_nacitaj.php?&copern=1200&drupoh=<?php echo $drupoh; ?>&page=1&cislo_dok=<?php echo $cislo_dok; ?>',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
    <?php                           }  ?>
                }

<?php if( ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 5 ) AND ( $copern == 5 OR $copern == 8 ) ) {  ?>

  function zoznamTextov()
  { 
  myRobotmenu = document.getElementById("robotmenu");
  //myRobotmenu.style.width = 300;
  //myRobotmenu.style.left = 800;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlzoznamtextov;
  robotmenu.style.display='';
  }

  function zhasni_zoznamTextov()
  { 
  robotmenu.style.display='none';
  }

  function nastavText(textxy)
  { 
  var uri=textxy;

  //document.forms.fhlv1.h_txp.value=decodeURIComponent(uri);
  //document.forms.fhlv1.h_txp.value="aaaaa";
  document.forms.fhlv1.h_txp.value=uri;
  //document.forms.fhlv1.h_txp.value=unescape(uri);
  robotmenu.style.display='none';
  }

    var htmlzoznamtextov = "<table  class='ponuka' width='100%'><tr><td width='90%'>Texty</td>";
    htmlzoznamtextov += "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlzoznamtextov += "onClick='zhasni_zoznamTextov();' title='Zhasni menu' ></td></tr>";  

<?php
if( $drupoh == 1 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 21 ORDER BY cpt"; }
if( $drupoh == 2 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 31 ORDER BY cpt"; }
if( $drupoh == 5 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_faktext WHERE drh = 41 ORDER BY cpt"; }
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$text=$riadok->txx;
//$textr=urlencode($riadok->txx);
//$textr30=substr($textr,0,30);
//$textad=addslashes($text);
//$textrp=str_replace("\r","XXXRRR",$text);
//$textrep=str_replace("\n","XXXNNN",$textrp);

$textrp=str_replace("\r"," ",$text);
$textrep=str_replace("\n","",$textrp);
$textrep30=substr($textrep,0,30);
?>
    htmlzoznamtextov += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
    htmlzoznamtextov += "<a href=\"#\" onClick=\"nastavText('<?php echo $textrep; ?>'); \" ><?php echo $textrep30; ?> </a>";
    htmlzoznamtextov += "</td></tr>";

<?php
  }
$i=$i+1;
   }
?>
    htmlzoznamtextov += "</table>";

<?php                                    }  ?>

function KopyDok()
                {

window.open('../ucto/vspk_u.php?copern=5&kopydok=1&drupoh=<?php echo $drupoh;?>&page=1sysx=UCT&rozuct=ANO&hladaj_uce=<?php echo $hladaj_uce;?>&cislo_dok=<?php echo $cislo_dok;?>', '_self' );
                }

</script>

</HEAD>

<BODY class="white" id="white" 
onload="window.scrollTo(0, 3000); ObnovUI(); VyberVstup(); <?php if( $copern == 5 OR $copern == 7 ) { echo " ukazrobot(); "; } ?>
 <?php if( $tlacitkoenter == 1 ) { echo " ukaztlacitkoEnter(); "; } ?>
 <?php if( $copern == 7 AND $tlacitkoenter == 1 ) { echo " polohaen3(); "; } ?>
" >


<?php
if (  $copern == 7 AND $drupoh < 4  )
     {
//nastavenie parametrov 


?>
<div id="nastavfakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 300px; left: 10px; width:600px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie pokladniËnÈho dokladu uzv(<?php echo $kli_uzid; ?>)</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavfakx.style.display='none';" title='Zhasni menu' ></td></tr>  
                    
<tr><FORM name='enast' method='post' action='#' ><td class='ponuka' colspan='5'>
<a href="#" onClick="NacitajPol(<?php echo $kli_uzid; ?>, <?php echo $hladaj_uce; ?>, <?php echo $drupoh; ?>);"> Chcete uloûiù nastavenie pokladniËnÈho dokladu ?</a></td></tr>

<tr><td class='ponuka' colspan='1'><input type='checkbox' name='zmd' value='1' > PeËiatka  
<img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='PecSubor();' title='NaËÌtanie JPG s˙boru peËiatky' > 
<td class='ponuka' colspan='1'> öÌrka<input type='text' name='h_ucm1' id='h_ucm1' size='4' maxlenght='4' value='' >40
<td class='ponuka' colspan='1'> v˝öka<input type='text' name='h_ucm2' id='h_ucm2' size='4' maxlenght='4' value='' >20
<td class='ponuka' colspan='1'> zæava<input type='text' name='h_ucm3' id='h_ucm3' size='4' maxlenght='4' value='' >155
<td class='ponuka' colspan='1'> zhora<input type='text' name='h_ucm4' id='h_ucm4' size='4' maxlenght='4' value='' >130</td>
</tr>

<tr><td class='ponuka' colspan='1'><input type='checkbox' name='zdl' value='1' > Logo  
<img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='LogoSubor();' title='NaËÌtanie JPG s˙boru loga' > 
<td class='ponuka' colspan='1'> öÌrka<input type='text' name='h_ico1' id='h_ico1' size='4' maxlenght='4' value='' >180
<td class='ponuka' colspan='1'> v˝öka<input type='text' name='h_ico2' id='h_ico2' size='4' maxlenght='4' value='' >20
<td class='ponuka' colspan='1'> zæava<input type='text' name='h_ico3' id='h_ico3' size='4' maxlenght='4' value='' >15
<td class='ponuka' colspan='1'> zhora<input type='text' name='h_ico4' id='h_ico4' size='4' maxlenght='4' value='' >10</td>
</tr>

<tr><td class='ponuka' colspan='5'> 
   x1 <input type='text' name='h_ucm5' id='h_ucm5' size='4' maxlenght='4' value='' >
 | x2 <input type='text' name='h_ico5' id='h_ico5' size='4' maxlenght='4' value='' > </td></tr> 
<tr><td class='ponuka' colspan='5'> 
   netlaËiù ˙ËtovnÈ poloûky  <input type='checkbox' name='omd' value='1' > | x3 <input type='checkbox' name='odl' value='1' >
 | x4 <input type='checkbox' name='pmd' value='1' > | x5 <input type='checkbox' name='pdl' value='1' > 
</td></tr> 
</FORM></table>
</div>

<script type="text/javascript">
//uloz subor
function LogoSubor()
                {
window.open('../cis/ulozhlavicku.php?copern=1998&drupoh=1&page=1','_blank');
                }

function PecSubor()
                {
window.open('../cis/ulozhlavicku.php?copern=1997&drupoh=1&page=1','_blank');
                }

//zapis nastavenie
function NacitajPol( premx, hladajucex, drupohx )
                {
var doklad = document.forms.forms1.h_dok.value;

var ucm1 = document.forms.enast.h_ucm1.value;
var ucm2 = document.forms.enast.h_ucm2.value;
var ucm3 = document.forms.enast.h_ucm3.value;
var ucm4 = document.forms.enast.h_ucm4.value;
var ucm5 = document.forms.enast.h_ucm5.value;
var ico1 = document.forms.enast.h_ico1.value;
var ico2 = document.forms.enast.h_ico2.value;
var ico3 = document.forms.enast.h_ico3.value;
var ico4 = document.forms.enast.h_ico4.value;
var ico5 = document.forms.enast.h_ico5.value;
var premenna = premx;
var zmd = 0;
if( document.enast.zmd.checked ) zmd=1;
var zdl = 0;
if( document.enast.zdl.checked ) zdl=1;
var omd = 0;
if( document.enast.omd.checked ) omd=1;
var odl = 0;
if( document.enast.odl.checked ) odl=1;
var pmd = 0;
if( document.enast.pmd.checked ) pmd=1;
var pdl = 0;
if( document.enast.pdl.checked ) pdl=1;

window.open('pok_setuloz.php?cislo_dok=' + doklad + '&drupoh=' + drupohx + '&hladaj_uce=' + hladajucex + '&h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&premenna=' + premenna + '&copern=900', '_self' );
                }


</script>
<?php
     }
?>



<?php if( $tlacitkoenter == 1 ) {  ?>

<div id="tlacitkoEnter" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 95; left: 405; width:80; height:25;">
<img border=0 src='../obr/tlacitka/enter.jpg' style='width:50; height:25;' onClick="tlacitko_Enter();"
 title='tlaËÌtko Enter' >
<img border=+ src='../obr/zmazuplne.png' style='width:15; height:15;' onClick="zhasni_Enter();"
 title='zhasn˙ù Enter' >
</div>

<?php                           }  ?>


<?php
//hodnoty pre vzorove doklady
if( $copern == 7 AND $kli_vduj == 0 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 5 OR $drupoh == 4 ) ) 
     {

?>
<div id="hodprevz" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 226px; left: 50px; width:400px; height:50px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>
                   
<tr><FORM name='fhoddok' method='post' action='#' >

<td width='100%' colspan='5'>
H1:<input type='text' name='h_hod1' id='h_hod1' size='6' value="<?php echo $hod1;?>"
onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Des)" /> 

H2:<input type='text' name='h_hod2' id='h_hod2' size='6' value="<?php echo $hod2;?>" 
onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Des)" />

H3:<input type='text' name='h_hod3' id='h_hod3' size='5' value="<?php echo $hod3;?>"
onclick="Fx.style.display='none';" onkeyup=\"KontrolaDcisla(this, Des)" />

H4:<input type='text' name='h_hod4' id='h_hod4' size='5' value="<?php echo $hod4;?>"
onclick="Fx.style.display='none';" onkeyup="KontrolaDcisla(this, Des)" /> 
</td>

</tr>
</FORM></table>

<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>
<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' title='Zhasni menu' ></td></tr>  

<?php if( $copern == 7 AND $kli_vduj == 9 AND ( $drupoh == 5 OR $drupoh == 4 ) ) { ?>

<?php
$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }
$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; $nuctpoh=""; }

$sqltt = "SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ucto = '$kli_vduj' AND druh = '$drupoh' ORDER BY cpoh";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>


<tr><td width='100%' class='ponuka' colspan='2'> 
<a href="#" onClick="volajAutoUCT(29,<?php echo $drupoh; ?>,<?php echo $riadok->cpoh; ?>)">
Chcete za˙Ëtovaù <?php echo $riadok->pohp; ?> ?</a>
</td></tr>

<?php
  }
$i=$i+1;
   }

      }
//end copern = 7...
?>


<?php if( $copern == 7 AND $kli_vduj == 0 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 5 OR $drupoh == 4 ) ) { ?>
<?php 
$drupohxx=$drupoh; 
if( $drupoh == 1 ) { $drupohxx=21; }
if( $drupoh == 2 ) { $drupohxx=22; }
?>
<?php
$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }
$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; $nuctpoh=""; }

$sqltt = "SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ucto = '$kli_vduj' AND druh = '$drupohxx' ORDER BY cpoh";
$sql = mysql_query("$sqltt");

$cpol = mysql_num_rows($sql);
$i=0;

   while ($i <= $cpol )
   {
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);


?>

<tr><td width='100%' class='ponuka' colspan='2'> 
<a href="#" onClick="volajAutoUCT(10,<?php echo $drupohxx; ?>,<?php echo $riadok->cpoh; ?>)">
Chcete za˙Ëtovaù <?php echo $riadok->pohp; ?> ?</a>
</td></tr>

<?php
  }
$i=$i+1;
   }

}
//koniec copern=7...
?>

</table>



</div>
<script type="text/javascript">

</script>
<?php
     }
//koniec hodnoty pre vzorove doklady
?>


<?php
//nastavenie autopausal80
if ( ( $copern == 5 AND ( $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 ) ) OR ( $copern == 7 AND ( $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 ) ) )
     {

$sql = "SELECT nzk0 FROM F".$kli_vxcf."_autopausal".$kli_uzid." ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = "DROP TABLE F".$kli_vxcf."_autopausal".$kli_uzid." ";
$vysledok = mysql_query("$sqlt");
$sqlt = <<<mzdprc
(
   id           INT(7) DEFAULT 0,
   udp          VARCHAR(11) NOT NULL,
   adp          VARCHAR(11) NOT NULL,
   uzk          VARCHAR(11) NOT NULL,
   azk          VARCHAR(11) NOT NULL,
   ajo          DECIMAL(2,0) DEFAULT 0,
   aju          VARCHAR(11) NOT NULL,
   xzk          DECIMAL(10,2) DEFAULT 0,
   xdp          DECIMAL(10,2) DEFAULT 0,
   mzk          DECIMAL(10,2) DEFAULT 0,
   mdp          DECIMAL(10,2) DEFAULT 0,
   nzk          DECIMAL(10,2) DEFAULT 0,
   ndp          DECIMAL(10,2) DEFAULT 0,

   xzk0         DECIMAL(10,2) DEFAULT 0,
   mzk0         DECIMAL(10,2) DEFAULT 0,
   nzk0         DECIMAL(10,2) DEFAULT 0,

   kox          DECIMAL(2,0) DEFAULT 0
);
mzdprc;

$vsql = "CREATE TABLE F".$kli_vxcf."_autopausal".$kli_uzid." ".$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = "INSERT INTO F".$kli_vxcf."_autopausal".$kli_uzid." ( id, udp, adp, uzk, azk, ajo, aju ) VALUES ( '$kli_uzid', '', '', '', '99', 0, '' ) ";
if( $kli_vduj == 9 )
 {
$vsql = "INSERT INTO F".$kli_vxcf."_autopausal".$kli_uzid." ( id, udp, adp, uzk, azk, ajo, aju ) VALUES ( '$kli_uzid', '', '99', '17', '', 0, '' ) ";
 }
$vytvor = mysql_query("$vsql");

}


$udp="";
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_autopausal$kli_uzid WHERE id > 0 ORDER BY id DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $udp=$riaddok->udp;
  $adp=$riaddok->adp;
  $uzk=$riaddok->uzk;
  $azk=$riaddok->azk;
  $ajo=$riaddok->ajo;
  $aju=$riaddok->aju;

  }
?>
<div id="nastavpaux" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 260px; left: 170px; width:620px; height:300px;">
<table  class='ponuka' width='100%'>
<tr><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td><td width='20%'></td></tr>

<tr><td colspan='3'>Nastavenie ˙Ëtovania pauöalnych v˝davkov 80 - 20 % PHM ...</td>
<td colspan='2' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:10; height:10;" onClick="nastavpaux.style.display='none';" title='Zhasni' ></td></tr>  
                    
<tr><FORM name='enastpau' method='post' action='#' >
<td class='ponuka' colspan='4' align='left'> 
 ⁄Ëet DPH 20% neodpoËÌtan· 
<td class='ponuka' colspan='1' align='left'> 
<input type='text' name='h_udp' id='h_udp' size='10' maxlenght='10' value='<?php echo $udp; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 34399, 34388... = ⁄Ëet pre ˙Ëtovanie 20% neodpoËÌtanej DPH' >
</td></tr>
<tr><td class='ponuka' colspan='4'> 
 Analityka DPH 20% neodpoËÌtan· 
<td class='ponuka' colspan='1'> 
<input type='text' name='h_adp' id='h_adp' size='10' maxlenght='10' value='<?php echo $adp; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 99, 88... = Analytika pre ˙Ëtovanie 20% neodpoËÌtanej DPH. ⁄Ëet rovnak˝ ako v nastavenÌ Robota. Ak nastavÌte analytiku, ˙Ëet nechajte pr·zdny a opaËne ak nastavÌte ˙Ëet, analytiku nechajte pr·zdnu.' >
</td></tr>
<tr><td class='ponuka' colspan='4'> 
 ⁄Ëet Z·klad 20% neuplatnen˝ 
<td class='ponuka' colspan='1'> 
<input type='text' name='h_uzk' id='h_uzk' size='10' maxlenght='10' value='<?php echo $uzk; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 50199, 21399... = ⁄Ëet pre ˙Ëtovanie 20% neuplatnenÈho z·kladu DPH, pripoËÌtateænej poloûky' >
</td></tr>
<tr><td class='ponuka' colspan='4'> 
 Analityka Z·klad 20% neuplatnen˝  
<td class='ponuka' colspan='1'> 
<input type='text' name='h_azk' id='h_azk' size='10' maxlenght='10' value='<?php echo $azk; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 99, 88... = Analytika pre ˙Ëtovanie neuplatnenÈho z·kladu DPH, pripoËÌtateænej poloûky. ⁄Ëet rovnak˝ ako v nastavenÌ Robota. Ak nastavÌte analytiku, ˙Ëet nechajte pr·zdny a opaËne ak nastavÌte ˙Ëet, analytiku nechajte pr·zdnu.' >
</td></tr>
<tr><td class='ponuka' colspan='4'>
Od˙Ëtovaù neodpoËÌtan˙ DPH 20% 
<td class='ponuka' colspan='1'>  
<input type="checkbox" name="h_ajo" value="1" />
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Ak zaökrtnete, program pre˙Ëtuje 20% neodpoËÌtan˙ DPH na ˙Ëet nastaven˝ niûöie s DRD=10' >
<?php
if ( $ajo == 1 )
   {
?>
<script type="text/javascript">
document.enastpau.h_ajo.checked = "checked";
</script>
<?php
   }
?>
</td></tr>
<tr><td class='ponuka' colspan='4'>
⁄Ëet pre od˙Ëtovanie neodpoËÌtanej DPH 20% 
<td class='ponuka' colspan='1'>  
<input type='text' name='h_aju' id='h_aju' size='10' maxlenght='10' value='<?php echo $aju; ?>' >
 <img border=0 src='../obr/info.png' style="width:10; height:10;" onClick="NastavPau();" title='Napr. 54999... = ⁄Ëet pre pre˙Ëtovanie 20% neodpoËÌtanej DPH s DRD=10' >
</td></tr>
<tr><td class='ponuka' colspan='4'>
<td class='ponuka' colspan='1'>  
 <img border=0 src='../obr/ok.png' style="width:10; height:10;" onClick="NastavPau();" title='Uloû nastavenie' > Uloûiù
</td></tr>
</FORM></table>
</div>
<script type="text/javascript">

//zapis nastavenie
function NastavPau()
                {
var udp = document.forms.enastpau.h_udp.value;
var adp = document.forms.enastpau.h_adp.value;
var uzk = document.forms.enastpau.h_uzk.value;
var azk = document.forms.enastpau.h_azk.value;
var ajo = 0;
if ( document.enastpau.h_ajo.checked ) { ajo=1; }
var aju = document.forms.enastpau.h_aju.value;

window.open('fak_setulozpau.php?cislo_dok=<?php echo $cislo_dok; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>&drupoh=<?php echo $drupoh; ?>&udp=' + udp + '&adp=' + adp + '&uzk=' + uzk + '&azk=' + azk + '&ajo=' + ajo + '&aju=' + aju + '&copern=900', '_self' );
                }

</script>
<?php
     }
?>

<?php
//nastavenie cudzej meny na doklade
//echo $copern;
if ( ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 ) AND $copern == 7 )
     {
?>
<div id="nastavmenax" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 180px; left: 10px; width:800px; height:100px;">
<table  class='ponuka' width='100%'><tr><FORM name='fmena1' class='obyc' method='post' action='#' >

<td width='20%'>Cudzia mena:
<?php

$sqlttt = "SELECT dat,kurz,mena,hodm,dok FROM F$kli_vxcf"."_$tabl WHERE dok = $cislo_dok";
$sql = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datum=$riadok->dat;
  $kurz1=$riadok->kurz;
  $mena1=$riadok->mena;
  $hodm1=1*$riadok->hodm;
  }

$sqlttt = "SELECT pomr FROM F$kli_vxcf"."_uctkurzy WHERE mena = '$mena1' ";
$sql = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $pomer1=1*$riadok->pomr;
  }

//echo $sqlttt;

$sqtt = "SELECT * FROM F$kli_vxcf"."_uctmeny LEFT JOIN F$kli_vxcf"."_uctkurzy".
" ON F$kli_vxcf"."_uctmeny.mena=F$kli_vxcf"."_uctkurzy.mena".
" WHERE datk <= '$datum' ORDER BY datk DESC,F$kli_vxcf"."_uctmeny.mena LIMIT 25";

$sqls = mysql_query("$sqtt");

$i=0;
?>
<select class='hvstup' size='1' name='h_menax' id='h_menax' onchange="nastavKURZ();" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam['mena'];?>|<?php echo $zaznam['pomr'];?>|<?php echo $zaznam['kurz'];?>" >
<?php echo SkDatum($zaznam['datk']);?> <?php echo $zaznam['mena'];?> <?php echo $zaznam['kurz'];?></option>
<?php if( $i == 0 ) { $mena=$zaznam['mena']; $pomr=$zaznam['pomr']; $kurz=$zaznam['kurz']; } $i=$i+1; endwhile;?>
</select>
</td>

<td width='12%'>Mena:
<input type='text' name='h_mena' id='h_mena' size='5' readonly="readonly" /> 
</td>

<td width='12%'>Pomer:
<input type='text' name='h_pomr' id='h_pomr' size='5' value="" 
onchange='return intg(this,1,1000,Cele)' onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cele)" /> 
</td>

<td width='12%'>Kurz:
<input type='text' name='h_kurz' id='h_kurz' size='5' onchange='return cele(this,0,99999999,Desc,4,document.fmena1.err_kurz)' 
onkeyup="KontrolaDcisla(this, Desc)" value="" /> 
<INPUT type='hidden' name='err_kurz' value="0">
</td>

<td width='12%'>Hodnota:
<input type='text' name='h_hodm' id='h_hodm' size='5' onchange='return cele(this,0,99999999,Desc,2,document.fmena1.err_hodm)' 
onkeyup="KontrolaDcisla(this, Desc)" value="" /> 
<INPUT type='hidden' name='err_hodm' value="0">
</td>

<?php $ulozdru=1*2000+$drupoh; ?>

<td width='12%'>
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onclick='ulozMENU(<?php echo $ulozdru;?>);' title='Uloûiù' >
</td>


<td width='48%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:15px; height:15px;'
onClick="nastavmenax.style.display='none';" title='Zhasni v˝ber meny' ></td></FORM></tr> 
</table>
</div>
<script type="text/javascript">

//cudzia mena


    function nacitajKURZ()
    {

    document.fmena1.h_mena.value = "<?php echo $mena1;?>";
    document.fmena1.h_kurz.value = "<?php echo $kurz1;?>";
    document.fmena1.h_hodm.value = "<?php echo $hodm1;?>";
    document.fmena1.h_pomr.value = "<?php echo $pomer1;?>";
    document.fmena1.h_menax.value = "<?php echo $mena1."|".$pomer1."|".$kurz1;?>";
    document.fmena1.h_menax.focus();
    }

    function nastavKURZ()
    {

    var h_kurzx = document.fmena1.h_menax.value;
    var hxx = h_kurzx.split("|");
    document.fmena1.h_mena.value = hxx[0];
    document.fmena1.h_pomr.value = hxx[1];
    document.fmena1.h_kurz.value = hxx[2];
    document.fmena1.h_hodm.select();
    document.fmena1.h_hodm.focus();


    }


</script>
<?php
     }
?>


<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>

<div id="robothlas" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 150; left: 90; width:200; height:100;">
zobrazeny vysledok
</div>

<?php
$akemenu="zobraz_robotmenu()";
if( $copern == 7 AND $kli_vduj == 0 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 5 OR $drupoh == 4 ) ) 
     {
$akemenu="zobraz_robotmenudiv()";
     }
if( $copern == 7 AND $kli_vduj == 9 AND ( $drupoh == 5 OR $drupoh == 4 ) ) 
     {
$akemenu="zobraz_robotmenu()";
     }
?>
<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 200; left: 40; ">
<img border=0 src='../obr/robot/robot3.jpg' style='width:40; height:80;' onClick="<?php echo $akemenu; ?>;"
 alt='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' title='Zhasni EkoRobota' >
</div>


<table class="h2" width="100%" >
<tr>
<?php if( $drupoh == 1 ) echo "<td>EuroSecom  -  PrÌjmov˝ pokladniËn˝ doklad"; ?>
<?php if( $drupoh == 2 ) echo "<td>EuroSecom  -  V˝davkov˝ pokladniËn˝ doklad"; ?>
<?php if( $drupoh == 3 ) echo "<td>EuroSecom  -  PrÌjmov˝ pokladniËn˝ doklad"; ?>
<?php if( $drupoh == 4 ) echo "<td>EuroSecom  -  Bankov˝ v˝pis"; ?>
<?php if( $drupoh == 5 ) echo "<td>EuroSecom  -  Vöeobecn˝ ˙Ëtovn˝ doklad"; ?>
 <img src='../obr/info.png' width=12 height=12 border=0 alt="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
<?php
if ( $copern == 5 ) echo " - nov˝ ";
?>
<?php
if ( $copern == 6 ) echo " - vymazanie ";
?>
<?php
if ( $rozuct == 'NIE' AND ($copern == 7 OR $copern == 17) ) echo " - poloûky";
?>
<?php
if ( $rozuct == 'ANO' AND ($copern == 7 OR $copern == 17) ) echo " - roz˙Ëtovanie";
?>
<?php
if ( $copern == 87 OR $copern == 97 ) echo " - ˙prava poloûky";
?>
<?php
if ( $copern == 8 ) echo " - ˙prava ";
?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<div id="myUcmelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myUcdelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myFakelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myIcpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myStrelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myZakelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myRdpelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>

<?php 
//nova faktura
//[[[[[[[5555555555[[[[[[[[[888888888888
if ( $copern == 5 OR $copern == 8 )
     {

?>
<span style="position: absolute; top: 150; left: 50%;"> 
<div id="myIcoElement"></div>
</span>
<table class="vstup" width="50%" height="130px" align="left">
<tr></tr><tr></tr>
<FORM name="fhlv1" class="obyc" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1
&cislo_dok=<?php echo $newdok;?>
<?php
if ( $copern == 5 )
     {
?>
&copern=68" >
<?php
     }
?>
<?php
if ( $copern == 8 )
     {
?>
&copern=78" >
<?php
     }
?>
<tr>
<td class="pvstup">&nbsp;
 <?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) echo "Pokladnica:"; ?>
 <?php if( $drupoh == 4 ) echo "⁄Ëet:"; ?>
 <?php if( $drupoh == 5 ) echo "Druh:"; ?>
</td>
<?php
if( $drupoh == 1 OR $drupoh == 2 )
{
$sqls = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 1 ) ORDER BY dpok");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_ucenew" id="h_ucenew" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dpok"];?>" >
<?php 
$polmen = $zaznam["npok"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dpok"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
<input class="hvstup" type="hidden" name="h_uce" id="h_uce"  />
</td>
<?php
}
?>
<?php
if( $drupoh == 3 )
{
$sqls = mysql_query("SELECT dpok,npok FROM F$kli_vxcf"."_dpok WHERE ( drpk = 2 ) ORDER BY dpok");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_ucenew" id="h_ucenew" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dpok"];?>" >
<?php 
$polmen = $zaznam["npok"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dpok"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
<input class="hvstup" type="hidden" name="h_uce" id="h_uce"  />
</td>
<?php
}
?>
<?php
if( $drupoh == 4 )
{
$sqls = mysql_query("SELECT dban,nban,uceb FROM F$kli_vxcf"."_dban WHERE ( dban > 0 ) ORDER BY dban");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_ucenew" id="h_ucenew" onmouseover="HlvOnClick();" 
 onKeyDown="return UceEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["dban"];?>" >
<?php 
$polmen = $zaznam["nban"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["dban"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
<input class="hvstup" type="hidden" name="h_uce" id="h_uce"  />
</td>
<?php
}
?>
<?php
if( $drupoh == 5 )
{
?>
<td class="fmenu"><input class="hvstup" type="text" name="h_ucenew" id="h_ucenew" size="10" value="1" 
 onfocus="document.forms.fhlv1.h_uce.select();"  onKeyDown="return UceEnter(event.which)" />
<input class="hvstup" type="hidden" name="h_uce" id="h_uce"  />
</td>
<?php
}
?>
</tr>

<tr>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu:
<a href='../faktury/vstf_s.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=10<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $newdok;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Uloûenie origin·lu dokladu do datab·zy" title="Uloûenie origin·lu dokladu do datab·zy" ></a>
</td>
<td class="hvstup" width="25%" >
<input class="hvstup" type="text" name="nwwdok" id="nwwdok" size="10" value="<?php echo $newdok;?>" onclick="HlvOnClick()" />
<input class="hvstup" type="hidden" name="newdok" id="newdok" value="<?php echo $newdok;?>" />
<input class="hvstup" type="hidden" name="h_dok" id="h_dok" value="<?php echo $newdok;?>" />

<input class="hvstup" type="hidden" name="kdefoc" id="kdefoc" value="uce" />
<input class="hvstup" type="hidden" name="klikenter" id="klikenter" value="0" />

</td>
<td class="bmenu" width="10%" ></td>
</tr>
<tr><td class="pvstup" >&nbsp;D·tum:</td>
<td class="hvstup">
<input class="hvstup" type="text" name="h_dat" id="h_dat" size="10" maxlength="10" value="<?php echo $h_dat;?>"
 onclick="HlvOnClick()" onkeyup="KontrolaDatum(this, Kx)"  onfocus="OnfocusDat(); onDat();" 
 onChange="return kontrola_datum(this, Kx, this, document.fhlv1.err_dat)" onKeyDown="return DatEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dat" value="0">
<input class="hvstup" type="text" name="h_dns" id="h_dns" value="" size="2" maxlength="3">
</td>
</tr>

<input class="hvstup" type="hidden" name="h_daz" id="h_daz" />
<input class="hvstup" type="hidden" name="h_das" id="h_das" />
<input class="hvstup" type="hidden" name="h_obj" id="h_obj" />


<tr><td class="pvstup" >&nbsp;UNIkÛd:</td>
<td class="hvstup" >

<input class="hvstup" type="text" name="h_unk" id="h_unk" size="20" maxlength="20" value="<?php echo $h_unk;?>" onclick="HlvOnClick()"
 onKeyDown="return UnkEnter(event.which)" onfocus="onUnk();" />
<input class="hvstup" type="hidden" name="err_unk" value="0">
</td>
</tr>

<tr></tr><tr></tr>
</table>
<table class="vstup" width="50%" height="130px" align="left">
<tr></tr><tr></tr>
<tr><td class="pvstup" width="15%" >&nbsp;<?php echo $Odberatel; ?> I»O:
<img src='../obr/ziarovka.png' border="1" onclick="newIco();" width="12" hight="12" title="Vloûiù novÈ I»O do datab·zy" >
</td>
<td class="hvstup" width="25%" >
<?php if( $drupoh == 4 ) { $h_ico=$fir_fico; } ?>
<?php if( $drupoh == 5 ) { $h_ico=$fir_fico; } ?>
<input class="hvstup" type="text" name="h_ico" id="h_ico" size="12" maxlength="8" value="<?php echo $h_ico;?>"
 onclick="Fxh.style.display='none'; document.fhlv1.h_nai.disabled = false; myIcoElement.style.display='none'; nulujIco();"
 onchange="return intg(this,1,99999999,Ix,document.fhlv1.err_ico)" onkeyup="KontrolaCisla(this, Ix)" 
 onKeyDown="return IcoEnter(event.which)" onfocus="onIco();" />

<img src='../obr/hladaj.png' border="1" onclick="myIcoElement.style.display=''; volajIco();" alt="Hæadaj zadanÈ I»O alebo n·zov firmy" title="Hæadaj zadanÈ I»O alebo n·zov firmy" >

<input class="hvstup" type="hidden" name="err_ico" value="0">

</td>
<td class="pvstup" width="10%" ></td>
</tr>
<tr><td class="pvstup" >&nbsp;<?php echo $Odberatel; ?> N·zov:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_nai" id="h_nai" size="30" value="<?php echo $h_nai;?>"
 onKeyDown="return NaiEnter(event.which)" 
 onclick="Fxh.style.display='none'; myIcoElement.style.display='none'; nulujIco();" onfocus="onNai();" />
</td>
</tr>

<input class="hvstup" type="hidden" name="h_str1" id="h_str1" />
<input class="hvstup" type="hidden" name="h_str" id="h_str" />
<input class="hvstup" type="hidden" name="h_sth" id="h_sth" />

<input class="hvstup" type="hidden" name="h_zak1" id="h_zak1" />
<input class="hvstup" type="hidden" name="h_zak" id="h_zak" />
<input class="hvstup" type="hidden" name="h_zah" id="h_zah" />

<input class="hvstup" type="hidden" name="h_ksy" id="h_ksy" />
<input class="hvstup" type="hidden" name="h_ssy" id="h_ssy" />
<input class="hvstup" type="hidden" name="err_ksy" value="0">
<input class="hvstup" type="hidden" name="err_ssy" value="0">

<input class="hvstup" type="hidden" name="h_dol" id="h_dol" />
<input class="hvstup" type="hidden" name="h_prf" id="h_prf" />

<input class="hvstup" type="hidden" name="err_dol" value="0">
<input class="hvstup" type="hidden" name="err_prf" value="0">

<tr>
<td class="pvstup" >&nbsp;
<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) { echo "Osoba:"; }
if( $drupoh == 4 ) { echo "⁄Ëet:"; }
if( $drupoh == 5 ) { echo "Register:"; }
?>
</td>
<td class="hvstup" >
<?php if( $drupoh == 4 ) { $h_kto=$uceb; } ?>
<input class="hvstup" type="text" name="h_kto" id="h_kto" size="45" maxlength="40" value="<?php echo $h_kto;?>" onclick="HlvOnClick()"
 onKeyDown="return KtoEnter(event.which)" onfocus="onKto();" />
</td>
<td class="pvstup" align="right">
</td>
</tr>

<tr></tr><tr></tr>
</table>

<br clear=left>
<tr>
<span id="Fxh" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ix" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O dod·vateæa musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Jx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo dokladu musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo musÌ byù desatinnÈ ËÌslo na dve desatinnÈ miesta</span>
<span id="Kx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Uph" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Z·hlavie DOK=<?php echo $cislo_dok;?> upravenÈ</span>
<div id="Okno"></div>
</tr>

<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 4 OR $drupoh == 5 )
{
?>
<table class="vstup" width="100%">
<tr>

<td class="pvstup" width="16%" >
<input type="checkbox" name="h_tlsl" id="h_tlsl" value="1" checked="checked" />
<input type="submit" id="sluzby" name="sluzby" value="Poloûky"  
 onmouseover="UkazSkryj('Uloûiù z·hlavie dokladu, vstup poloûiek'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>

<td class="pvstup" width="16%" ></td><td class="pvstup" width="16%" ></td>
<td class="pvstup" width="16%" ></td><td class="pvstup" width="16%" ></td>
<td class="pvstup" width="16%" ></td><td class="pvstup" width="16%" ></td>
</tr>
</table>
<?php
}
?>

<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="16%">&nbsp;⁄Ëel:</td>
<td class="hvstup" width="100px">
<input class="hvstup" type="text" name="h_txp" id="h_txp" size="80" onclick="HlvOnClick()"
 onKeyDown="return TxpEnter(event.which)" onfocus="onTxp();" ></td>
<td class="pvstup">
<?php if( $drupoh == 1 OR $drupoh == 2 ) { ?>
&nbsp;&nbsp;<a href="#" onClick="Txp1();">1</a>&nbsp;&nbsp;
<a href="#" onClick="Txp2();">2</a>&nbsp;&nbsp;<a href="#" onClick="Txp3();">3</a>
&nbsp;&nbsp;<a href="#" onClick="Txp4();">4</a>
<?php                                    } ?>
<?php if( ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 5 ) AND ( $copern == 5 OR $copern == 8 ) ) { ?>
<img src='../obr/zoznam.png' onclick="zoznamTextov();" width=20 height=12 border=0 title="Vybraù predvolen˝ text zo zoznamu" >
<?php                                     } ?>
</td>
</tr>
</table>


<table class="vstup" width="100%">
<tr></tr><tr></tr>
<tr>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" align="right" >&nbsp;%DPH</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Z·klad</td>
<td class="pvstup" width="10%" align="right" >&nbsp;DaÚ</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Spolu</td>
</tr>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sz1" id="h_sz1" size="12" value="<?php echo $fir_dph1; ?>" disabled="disabled" />
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zk1" id="h_zk1" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Zk1Enter(event.which)" onfocus="onZk1();"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_dn1" id="h_dn1" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Dn1Enter(event.which)" onfocus="onDn1();"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sp1" id="h_sp1" size="12" /> 
</td>
</tr>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sz2" id="h_sz2" size="12" value="<?php echo $fir_dph2; ?>" disabled="disabled" />
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zk2" id="h_zk2" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Zk2Enter(event.which)" onfocus="onZk2();"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_dn2" id="h_dn2" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Dn2Enter(event.which)" onfocus="onDn2();"
/> 
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sp2" id="h_sp2" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Sp2Enter(event.which)"
/>  
</td>
</tr>

<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sz0" id="h_sz0" size="12" value="0" disabled="disabled" />
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_zk0" id="h_zk0" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return Zk0Enter(event.which)" onfocus="onZk0();"
/> 
</td>
<td class="hvstup" align="right" ></td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_sp0" id="h_sp0" size="12" /> 
</td>
</tr>
<tr>
<td class="pvstup" colspan="7" align="right" >
<img src='../obr/naradie.png' onClick="nastavpaux.style.display='';" width=15 height=15 border=0 title="Nastavenie ˙Ëtovania pauö·lu 80%" ></a>
&nbsp;
Pauö·l 80%<input type="checkbox" name="pau80" id="pau80" value="1" />
</td>

<td class="pvstup" align="right" colspan="2" >
Celkom hodnota dokladu:
</td>
<td class="hvstup" align="right" >
<input class="hvstup" type="text" name="h_hod" id="h_hod" size="12" onclick="HlvOnClick()"
 onkeyup="KontrolaDcisla(this, Dx)" onKeyDown="return HodEnter(event.which)" onfocus="onHod();"
/> 
</td>
</tr>

<tr></tr><tr></tr>
</table>

<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="16%" >
<?php
if( $rozb2 != 'VELKE' )
{
?>
<input class="hvstup" type="hidden" name="rozb2" id="rozb2" value="NOT" />
&nbsp;Text za:
</td>
<td class="hvstup" width="100px" >
<textarea name="h_txz" id="h_txz" rows="1" cols="80" >
<?php
}
?>
<?php
if( $rozb2 == 'VELKE' )
{
?>
<input class="hvstup" type="hidden" name="rozb2" id="rozb2" value="NOT" />
&nbsp;Text za:
</td>
<td class="hvstup" width="660px" >
<textarea name="h_txz" id="h_txz" rows="8" cols="80" >
<?php
}
?>
<?php if(  $vybr != 'ANO'  )
{
?>
<?php echo $h_txz; ?>
<?php
}
?>
<?php if( $vybr == 'ANO' )
{
?>
<?php echo $cislo_txz; ?>
<?php
}
?>
</textarea></td>
<td class="pvstup">&nbsp;</td>
</tr>
</table>

<table class="vstup" width="100%">
<tr>
<td class="pvstup" width="16%" >&nbsp;Pozn·mka:</td>
<td class="hvstup" width="100px" >
<input class="hvstup" type="text" name="h_poz" id="h_poz" size="80" maxlength="80" value="<?php echo $h_poz;?>" onclick="HlvOnClick()"
 onKeyDown="return PozEnter(event.which)" /></td>
<td class="pvstup">&nbsp;(Nebude vytlaËen· na doklade)</td><td class="pvstup" >&nbsp;</td>
</tr>
<tr>
<td>
<input type="submit" id="uloh" name="uloh" value="Uloûiù"  
 onmouseover="UkazSkryj('Uloûiù ˙pravy z·hlavia dokladu, n·vrat do zoznamu dokladov'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" onclick="Zapis_COOK();">
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="obyc" ><INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"></td>
<td class="obyc" align="right"></td>
</FORM>
</table>

<?php
// toto je koniec nova faktura copern=5
     }
?>

<?php 
//vymazanie faktury a sluzby
//[[[[[[[666666666666 777777777777
if ( $copern == 6 OR $copern == 7 OR $copern == 17 OR $copern == 87 OR $copern == 97 )
     {

$citzmen="";
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 ) { $citzmen=",zmen,mena,kurz,hodm"; }

$sqltt = "SELECT uce, dok, DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat,".
" F$kli_vxcf"."_$tabl.ico, F$kli_vxcf"."_ico.nai, poz,".
" txp, txz, zk1, dn1, zk2, dn2, zk0, sp1, sp2, hod, zk1u, dn1u, zk2u, dn2u, zk0u, sp1u, sp2u, hodu, unk, kto".$citzmen.
" FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.dok = $cislo_dok ".
"";
$sql = mysql_query("$sqltt");
$j = 0;
?>
<table class="vstup" width="50%" height="120px" align="left">
<tr></tr><tr></tr>
<?php
   while ($j <= 0 )
   {
  if (@$zaznam=mysql_data_seek($sql,$j))
  {
$riadok=mysql_fetch_object($sql);
?>

<tr>
<td class="pvstup">&nbsp;
<?php if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) echo "Pokladnica:"; ?>
<?php if( ( $drupoh == 1 OR $drupoh == 3 ) AND $ajregistracka == 1 ) { ?>
<img src='../obr/banky/euro.jpg' onclick="regpokpri();" width=20 height=12 border=0 title="Zaregistrovaù platbu do registraËnej pokladnice" >
<?php                                                                } ?>
<?php if( $drupoh == 4 ) echo "⁄Ëet:"; ?>
<?php if( $drupoh == 5 ) echo "Druh:"; ?>
</td>
<td class="fmenu"><?php echo $riadok->uce; ?><?php if( $riadok->zmen == 1 ) { echo " - MENA ".$riadok->mena; } ?></td>
<td class="bmenu" width="10%" >
<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 )
{
?>
<a href="#" onClick="nastavmenax.style.display=''; nacitajKURZ();">
<img src='../obr/banky/dollar2.jpg' width=20 height=12 border=0 alt='Vybraù menu' title='Vybraù menu' >Mena</a>
<?php
}
?>
</td>
</tr>
<tr>
<td class="pvstup" width="15%" >&nbsp;»Ìslo dokladu:
<a href='../faktury/vstf_s.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=10<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Uloûenie origin·lu dokladu do datab·zy" title="Uloûenie origin·lu dokladu do datab·zy" ></a>
</td>
<td class="hvstup" width="25%" ><?php echo $riadok->dok; ?></td>
<td class="bmenu">
<?php
if ( $copern != 6 AND $copern != 87 )
     {
?>
<?php
$tlaclenpdf=1;
if( $kli_vrok < 2014 ) { $tlaclenpdf=0; }
if( $_SESSION['nieie'] == 1 ) { $tlaclenpdf=1; }
?>
<?php if( $tlaclenpdf == 0 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) )  { ?>
<a href="#" onClick="window.open('vspk_t.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=20&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_dok=<?php echo $riadok->dok;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="VytlaËiù doklad" title="VytlaËiù doklad" >TlaËiù</a>
<?php                                } ?>

<?php if( $tlaclenpdf == 1 AND ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 ) )  { ?>
<a href="#" onclick="VytlacDoklad();" >
<img src='../obr/tlac.png' width=20 height=12 border=0 alt="VytlaËiù doklad" title="VytlaËiù doklad" >TlaËiù</a>
<?php                                } ?>

<?php
if( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 )
{
?>
<img src='../obr/pdf.png' onclick="VytlacDoklad();" width=15 height=12 border=0 alt="VytlaËiù doklad v tvare PDF" title="VytlaËiù doklad v tvare PDF" >
<?php
}
?>
<?php
if( $drupoh == 4 OR $drupoh == 5 )
{
?>
<img src='../obr/pdf.png' onclick="VytlacDoklad();" width=15 height=12 border=0 alt="VytlaËiù doklad v tvare PDF" title="VytlaËiù doklad v tvare PDF" >
<?php
}
?>
<?php
     }
?>
</td>
</tr>
<tr>
<td class="pvstup" >&nbsp;D·tum:</td>
<td class="hvstup"><?php echo $riadok->dat; ?></td>
</tr>
<tr>
<td class="pvstup" >&nbsp;UNIkÛd:</td>
<td class="hvstup"><?php echo $riadok->unk; ?></td>
<?php
if( $copern == 7 OR $copern == 17 )
{
if( $fir_allx15 == 0 OR $drupoh != 4 OR $ddusk == '' )  { $ddusk=$riadok->dat; } 
?>
<td>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&hladaj_uce=<?php echo $h_uce; ?>
&copern=8&drupoh=<?php echo $drupoh;?>&cislo_dok=<?php echo $riadok->dok;?>'>
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="⁄prava z·hlavia dokladu" title="⁄prava z·hlavia dokladu" >Z·hlavie</a>
</td>
<?php
}
?>
</tr>
<tr></tr><tr></tr>
</table>

<table class="vstup" width="50%" height="120px" align="left">
<tr></tr><tr></tr>

<tr>
<td class="pvstup"  width="40%">&nbsp;<?php echo $Odberatel; ?> I»O:</td>
<td class="fmenu"  width="40%"><?php echo $riadok->ico; ?></td>
<td class="bmenu" width="20%">
<?php
if ( $drupoh == 1 OR $drupoh == 2 )
{
?>
<td class="hmenu" >
<a href="#" onClick="MesPoklKniha();">
<img src='../obr/orig.png' width=15 height=15 border=0 alt="PokladniËn· kniha vybran˝ ˙Ëtovn˝ mesiac" title="PokladniËn· kniha vybran˝ ˙Ëtovn˝ mesiac" ></a>
<?php
}
?>
<?php
if ( $drupoh == 4 )
{
?>
<td class="hmenu">
<a href="#" onClick="PoklKniha();">
<img src='../obr/zoznam.png' width=15 height=15 border=0 alt="Zostatok bankovÈho ˙Ëtu cel˝ rok" title="Zostatok bankovÈho ˙Ëtu cel˝ rok" ></a>
<?php
}
?>
<?php
if ( $drupoh == 5 AND $agrostav == 1 )
{
?>
REZ 
 <img src='../obr/zoznam.png' onClick="ZosRezia();" width=15 height=15 border=0 alt="Zostava na v˝poËet rÈûie" title="Zostava na v˝poËet rÈûie" >
 <img src='../obr/orig.png' onClick="RozRezia();" width=15 height=15 border=0 alt="Roz˙Ëtovanie rÈûie" title="Roz˙Ëtovanie rÈûie" >
<?php
}
?>
<?php
if ( $drupoh == 5 AND $agrostav == 0 AND $polno == 0 )
{
?>
REZ 
 <img src='../obr/zoznam.png' onClick="ZosORezia();" width=15 height=15 border=0 alt="Zostava na v˝poËet rÈûie" title="Zostava na v˝poËet rÈûie" >
 <img src='../obr/orig.png' onClick="RozORezia();" width=15 height=15 border=0 alt="Roz˙Ëtovanie rÈûie" title="Roz˙Ëtovanie rÈûie" >
<?php
}
?>
<?php
if ( $drupoh == 5 AND $agrostav == 0 AND $polno == 1 )
{
?>
REZ 
 <img src='../obr/zoznam.png' onClick="ZosPRezia();" width=15 height=15 border=0 alt="Zostava na v˝poËet rÈûie - poænohospod·rska Ëinnosù" title="Zostava na v˝poËet rÈûie - poænohospod·rska Ëinnosù" >
 <img src='../obr/orig.png' onClick="RozPRezia();" width=15 height=15 border=0 alt="Roz˙Ëtovanie rÈûie" title="Roz˙Ëtovanie rÈûie" >
<?php
}
?>
</td>
</tr>
<tr>
<td class="pvstup" width="40%" >&nbsp;<?php echo $Odberatel; ?> N·zov:</td>
<td class="hvstup" width="40%" ><?php echo $riadok->nai; ?></td>
<td class="bmenu" width="20%">
<?php
if ( $drupoh == 4 )
{
?>
<td class="hmenu" align="right">
<a href="#" onClick="TlacBank();">
<img src='../obr/tlac.png' width=15 height=15 border=0 alt="TlaË bank.v˝pisu s poËiatkom a zostatkom ˙Ëtu" title="TlaË bank.v˝pisu s poËiatkom a zostatkom ˙Ëtu" ></a>
<?php
}
?>
<?php
if ( $drupoh == 5 AND $agrostav == 1 )
{
?>
OBS 
 <img src='../obr/zoznam.png' onClick="ZosObst();" width=15 height=15 border=0 alt="Zostava na v˝poËet obstar·vacÌch n·kladov" title="Zostava na v˝poËet obstar·vacÌch n·kladov" >
 <img src='../obr/orig.png' onClick="RozObst();" width=15 height=15 border=0 alt="Roz˙Ëtovanie obstar·vacÌch n·kladov" title="Roz˙Ëtovanie obstar·vacÌch n·kladov" >
<?php
}
?>
<?php
if ( $drupoh == 5 AND $agrostav == 0 AND $polno == 1 )
{
?>
NED 
 <img src='../obr/zoznam.png' onClick="ZosPNedok();" width=15 height=15 border=0 alt="Zostava na v˝poËet nedokonËenej v˝roby - poænohospod·rska Ëinnosù" title="Zostava na v˝poËet nedokonËenej v˝roby - poænohospod·rska Ëinnosù" >
 <img src='../obr/orig.png' onClick="RozPNedok();" width=15 height=15 border=0 alt="Roz˙Ëtovanie nedokonËenej v˝roby" title="Roz˙Ëtovanie nedokonËenej v˝roby" >
<?php
}
?>
</tr>
<tr>
<td class="pvstup" >&nbsp;Osoba:</td>
<td class="hvstup"><?php echo $riadok->kto; ?></td>
<td class="bmenu" >
<?php
if ( $drupoh == 5  )
{
?>
ZAL 
 <img src='../obr/export.png' onClick="DoDatabazy('<?php echo $riadok->unk; ?>');" width=15 height=15 border=0 alt="Uloûenie vöeobecnÈho dokladu do datab·zy" title="Uloûenie vöeobecnÈho dokladu do datab·zy" >
 <img src='../obr/import.png' onClick="ZDatabazy();" width=15 height=15 border=0 alt="KÛpia vöeobecnÈho dokladu z datab·zy" title="KÛpia vöeobecnÈho dokladu z datab·zy" >
<?php
}
?>

<?php
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 )
{
?> 
 <img src='../obr/export.png' onClick="KopyDok();" width=15 height=15 border=0 title="KÛpia dokladu <?php echo $riadok->dok; ?> do novÈho dokladu" >
<?php
}
?>

</tr>
<tr></tr><tr></tr>
</table>
<br clear=left>
<tr>
<div id="Okno"></div>
<div id="myMENAelement"></div>
</tr>

<?php
if( $riadok->zmen == 1 )
    {
//cudzia mena
$kurzform=1*$riadok->kurz;
?>
<table  class='ponuka' width='100%'>
<tr>
<td width="15%" >Cudzia mena: <?php echo $riadok->mena; ?></td>
<td width="12%" >Pomer: 1</td>
<td width="12%" >Kurz: <?php echo $kurzform; ?></td>
<td width="12%" >Hodnota: <?php echo $riadok->hodm; ?></td>
<td width="72%" > </td>
</tr>
</table>
<?php
    }
?>

<table class="vstup" width="100%">
<tr>
<?php
$vypis_txp = ereg_replace("\n", "<br>", trim($riadok->txp));
$vypis_txp = ereg_replace(" ", "&nbsp;", trim($vypis_txp));
?>
<td class="pvstup" width="15%" >
<?php
if ( $drupoh == 4 )
  {
?>
<a href="#" onClick="window.open('vspk_importxml.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $riadok->dok;?>
&cislo_uce=<?php echo $riadok->uce;?>', '_self' )">
<img src='../obr/import.png' width=15 height=15 border=0 title="Import v˝pisu z Banky nov˝ XML form·t pre vöetky banky od 1.2.2016 " ></a>

<?php
  }
?>

 ⁄Ëel:</td>
<td class="hvstup" width="85%" ><?php echo $vypis_txp; ?></td>
</tr>
</table>
<tr>
<span id="Uce" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo ˙Ëtu musÌ byù celÈ kladnÈ ËÌslo v rozsahu 0 aû 9999999</span>
<span id="Des" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Fak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo fakt˙ry musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Ico" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999</span>
<span id="Str" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo strediska musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999</span>
<span id="Zak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo z·kazky musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Rdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh DPH musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka spr·vne uloûen·</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka CPL=<?php echo $h_cpl;?>  zmazan·</span>
<span id="Nen" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nenaöiel som v ËÌselnÌku , pre voæn˝ vstup zadajte UCM=0</span>
<span id="NiejeUce" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som ˙Ëet v ËÌselnÌku </span>
<span id="NiejeIcp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som I»O v ËÌselnÌku </span>
<span id="NiejeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som stredisko v ËÌselnÌku </span>
<span id="NiejeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som z·kazku v ËÌselnÌku </span>
<span id="NiejeRdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som druh v ËÌselnÌku </span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ ËÌslo </span>
<span id="Kx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>

</tr>
<div id="myDivElement"></div>
<?php
//VYPIS ROZUCTOVANIA A POLOZIEK DOKLADU 
if ( $copern == 6 OR $copern == 7 OR $copern == 17 OR $copern == 87 OR $copern == 97 )
                {

$fmenu="fmenu";
$pvstup="pvstup";
$hvstup="hvstup";
$cotoje="Poloûky dokladu";
$seldph="%DPH";
$UCM="UCM";
$UCD="UCD";
if ( $rozuct == 'ANO' )
{
$fmenu="fmenz";
$pvstup="pvstuz";
$hvstup="hvstuz";
$cotoje="Roz˙Ëtovanie dokladu";
$seldph="DRD";
$UCM="M·Daù";
$UCD="Dal";
}
//jednoduche
if ( $kli_vduj == 9 )
{
$fmenu="fmenz";
$pvstup="pvstuz";
$hvstup="hvstuz";
$cotoje="Roz˙Ëtovanie dokladu";
$seldph="DRD";
$UCM="Pokladnica";
$UCD="Druh prÌjmu";
if( $drupoh == 2 ) { $UCM="Druh v˝daja"; $UCD="Pokladnica"; }
if( $drupoh == 4 ) { $UCM="PrÌjem⁄Ëet DruhV˝daja"; $UCD="V˝daj⁄Ëet DruhPrÌjmu"; }
if( $drupoh == 5 ) { $UCM="PrÌjem⁄Ëet DruhV˝daja"; $UCD="V˝daj⁄Ëet DruhPrÌjmu"; }
}
?>
<table class="<?php echo $fmenu; ?>" width="100%" >

<tr>
<td class="<?php echo $pvstup ?>"  colspan="8"><?php echo $cotoje; ?>
<?php
if ( $rozuct == 'ANO' )
{
?>
<a href="#" onClick="window.open('vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=ANO&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $riadok->dok+1;?>&h_ico=<?php echo $h_ico;?>&h_uce=<?php echo $h_uce;?>
&h_unk=<?php echo $h_unk;?>', '_self' )"><img src='../obr/next.png' width=12 height=12 border=0 alt="Roz˙Ëtovaù ÔalöÌ doklad" title="Roz˙Ëtovaù ÔalöÌ doklad" ></a>
<?php
}
?>
</td>
<td class="<?php echo $pvstup ?>" align="right"  colspan="2">
<?php
if ( $drupoh == 4 )
  {
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=ANO&copern=551&drupoh=<?php echo $drupoh;?>&tatra=1
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/banky/tatrabanka.jpg' width=20 height=20 border=0 title="Import ˙dajov z TXT bankovÈho v˝pisu TATRABANKA InternetBanking v.4.8.4 a v.5.0.1"></a>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=ANO&copern=551&drupoh=<?php echo $drupoh;?>&tatra=2
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/banky/tatrabanka.jpg' width=20 height=20 border=0 alt="Import ˙dajov z bankovÈho v˝pisu TATRABANKA GEMINI" title="Import ˙dajov z bankovÈho v˝pisu TATRABANKA GEMINI"></a>

<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=ANO&copern=551&drupoh=<?php echo $drupoh;?>&tatra=3
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/banky/tatrabanka.jpg' width=20 height=20 border=0 title="Import ˙dajov z CSV bankovÈho v˝pisu TATRABANKA InternetBanking v.5.0.1"></a>


<?php
  }
?>
<?php
if ( $rozuct == 'ANO' )
           {
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=ANO&copern=166&drupoh=<?php echo $drupoh;?>
&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $riadok->dok;?>&h_ico=<?php echo $riadok->ico;?>&h_uce=<?php echo $riadok->uce;?>&h_unk=<?php echo $riadok->unk;?>'>
<img src='../obr/kos.png' width=20 height=20 border=0 alt="Vymazanie vöetk˝ch poloûiek roz˙Ëtovania" title="Vymazanie vöetk˝ch poloûiek roz˙Ëtovania"></a>
<?php
           }
?>
</td>
</tr>
<tr>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >Por.ËÌslo
<?php if( $fir_allx15 == 1 AND $drupoh == 4 ) { ?>
 D·tum 
<?php                                         } ?>

<td class="<?php echo $pvstup ?>" width="10%">
<?php
if ( $copern == 7 )
           {
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=17&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok;?>' >
<img src='../obr/ziarovka.png' width=15 height=10 border=0 alt="Vloûiù textov˝ riadok" title="Vloûiù textov˝ riadok"></a>
<?php
           }
?>
<?php echo $UCM; ?>
<td class="<?php echo $pvstup ?>" width="10%"><?php echo $UCD; ?><td class="<?php echo $pvstup ?>" width="10%"><?php echo $seldph; ?>
<td class="<?php echo $pvstup ?>" width="10%" align="right">FAK<td class="<?php echo $pvstup ?>" width="10%" align="right">I»O
<td class="<?php echo $pvstup ?>" width="10%" align="right">STR
<td class="<?php echo $pvstup ?>" width="10%" align="right">Z¡K<td class="<?php echo $pvstup ?>" width="10%" align="right">Hodnota
<td class="<?php echo $pvstup ?>" width="10%">Zmaû
</tr>

<?php
//VYPIS POLOZIEK DOKLADU ALEBO ROZUCTOVANIE
if( $rozuct == 'NIE' )
{
$sluztt = "SELECT dok, poh, cpl, ucm, ucd, rdp, fak, ico, str, zak, hod,".
" pop". 
" FROM F$kli_vxcf"."_$uctpok".
" WHERE F$kli_vxcf"."_$uctpok.dok = $cislo_dok ".
" ORDER BY cpl";
}
if( $rozuct == 'ANO' )
{

//ak neexistuje uctosnova2 tak ju vytvor
$sql = "SELECT * FROM F$kli_vxcf"."_uctosnova2";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = <<<uctosnova2
(
   uce2        INT(10),
   nuc2        VARCHAR(40)
);
uctosnova2;
$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctosnova2'.$sqlt;
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctosnova2 ".
"SELECT uce,nuc ".
"FROM F$kli_vxcf"."_uctosnova WHERE ( uce > 0 ) ".
"ORDER BY ucc".
"";
$dsql = mysql_query("$dsqlt");
}

$dajddu="";
if( $drupoh == 4 ) { $dajddu="ddu,"; }

$sluztt = "SELECT dok,cpl,ucm,ucd,hod,F$kli_vxcf"."_$uctpok.rdp,F$kli_vxcf"."_$uctpok.ico,fak,F$kli_vxcf"."_$uctpok.str,F$kli_vxcf"."_$uctpok.zak, ".
" F$kli_vxcf"."_uctosnova.nuc,F$kli_vxcf"."_uctosnova2.nuc2,F$kli_vxcf"."_ico.nai,F$kli_vxcf"."_str.nst,F$kli_vxcf"."_zak.nza,pop,$dajddu ".
" zmen,mena,kurz,hodm ".
" FROM F$kli_vxcf"."_$uctpok".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpok.ico=F$kli_vxcf"."_ico.ico".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_$uctpok.str=F$kli_vxcf"."_str.str".
" LEFT JOIN F$kli_vxcf"."_zak".
" ON F$kli_vxcf"."_$uctpok.str=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_$uctpok.zak=F$kli_vxcf"."_zak.zak".
" LEFT JOIN F$kli_vxcf"."_uctdrdp".
" ON F$kli_vxcf"."_$uctpok.rdp=F$kli_vxcf"."_uctdrdp.rdp".
" LEFT JOIN F$kli_vxcf"."_uctosnova".
" ON F$kli_vxcf"."_$uctpok.ucm=F$kli_vxcf"."_uctosnova.uce".
" LEFT JOIN F$kli_vxcf"."_uctosnova2".
" ON F$kli_vxcf"."_$uctpok.ucd=F$kli_vxcf"."_uctosnova2.uce2".
" WHERE F$kli_vxcf"."_$uctpok.dok = $cislo_dok ".
" ORDER BY cpl";
}

//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);
?>

<?php
//zaciatok vypisu
$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

?>

<tr>
<?php
if ( $copern != 87 AND $copern != 97 AND $copern != 6 AND $zmen != 1 )
     {
?>
<td class="fmenu" width="10%" align="right" >
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&
<?php
if( $rsluz->ucm > 0 OR $rsluz->ucd > 0 OR $rsluz->hod > 0 )
{
?>
copern=87
<?php
}
?>
<?php
if(  $rsluz->ucm == 0 AND $rsluz->hod == 0 AND $rsluz->pop != '' )
{
?>
copern=97
<?php
}
?>
&drupoh=<?php echo $drupoh;?>&cislo_cpl=<?php echo $rsluz->cpl;?>&hladaj_uce=<?php echo $hladaj_uce;?>&z_cpl=<?php echo $rsluz->cpl;?>
&cislo_dok=<?php echo $rsluz->dok;?>&z_ucm=<?php echo $rsluz->ucm;?>&z_ucd=<?php echo $rsluz->ucd;?>
&z_rdp=<?php echo $rsluz->rdp;?>&z_fak=<?php echo $rsluz->fak;?>&z_ico=<?php echo $rsluz->ico;?>&z_str=<?php echo $rsluz->str;?>
&z_zak=<?php echo $rsluz->zak;?>&z_hop=<?php echo $rsluz->hod;?>&z_pop=<?php echo $rsluz->pop;?>&z_dph=<?php echo $rsluz->dph;?>'>
<?php echo $rsluz->cpl;?>
</a>&nbsp;

<?php if( $fir_allx15 == 1 AND $drupoh == 4 ) { ?>
 <?php echo SkDatum($rsluz->ddu);?>&nbsp;
<?php                                         } ?>

</td>
<?php
      }
?>

<?php
if ( $copern ==  6 OR $zmen == 1 )
     {
?>
<td class="fmenu" width="10%" >
<?php echo $rsluz->cpl;?>
</td>
<?php
      }
?>

<?php
if ( $copern == 87 AND $rsluz->cpl == $z_cpl )
     {
?>
<td class="fmenu" width="10%" align="right" style="font-family:bold; font-weight:bold; background-color:red; color:black;">
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 87 AND $rsluz->cpl != $z_cpl )
     {
?>
<td class="fmenu" width="10%" >
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 97 AND $rsluz->cpl == $z_cpl )
     {
?>
<td class="fmenu" width="10%" align="right" style="font-family:bold; font-weight:bold; background-color:red; color:black;">
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>
<?php
if ( $copern == 97 AND $rsluz->cpl != $z_cpl )
     {
?>
<td class="fmenu" width="10%" >
<?php echo $rsluz->cpl;?>
</td>
<?php
     }
?>
<?php
if( $rsluz->ucm > 0 OR $rsluz->ucd > 0 OR $rsluz->hod > 0 )
{
?>
<td class="fmenu" width="10%" 
 onmouseover="UkazSkryjPol('<?php echo $rsluz->ucm;?> = <?php echo $rsluz->nuc;?>')" onmouseout="Okno.style.display='none';" ><?php echo $rsluz->ucm;?></td>
<td class="fmenu" width="10%" 
 onmouseover="UkazSkryjPol('<?php echo $rsluz->ucd;?> = <?php echo $rsluz->nuc2;?>')" onmouseout="Okno.style.display='none';" ><?php echo $rsluz->ucd;?></td>
<td class="fmenu" width="10%" 
 onmouseover="UkazSkryjPol('<?php echo $rsluz->nrd;?>')" onmouseout="Okno.style.display='none';" ><?php echo $rsluz->rdp;?></td>
<td class="fmenu" width="10%" align="right" ><?php echo $rsluz->fak;?></td>
<td class="fmenu" width="10%" align="right" 
 onmouseover="UkazSkryjPol('<?php echo $rsluz->nai;?>')" onmouseout="Okno.style.display='none';" ><?php echo $rsluz->ico;?></td>
<td class="fmenu" width="10%" align="right" 
 onmouseover="UkazSkryjPol('<?php echo $rsluz->nst;?>')" onmouseout="Okno.style.display='none';" ><?php echo $rsluz->str;?></td>
<td class="fmenu" width="10%" align="right" 
 onmouseover="UkazSkryjPol('<?php echo $rsluz->nza;?>')" onmouseout="Okno.style.display='none';" ><?php echo $rsluz->zak;?></td>
<td class="fmenu" width="10%" align="right"
<?php if( $rsluz->zmen == 1 AND $rsluz->pop == '' ) { ?>
 onmouseover="UkazSkryjPol('<?php echo $rsluz->hodm;?><?php echo $rsluz->mena;?>')" onmouseout="Okno.style.display='none';"
<?php                         } ?>
<?php if( $rsluz->zmen == 0 AND $rsluz->pop != '' AND $rsluz->hod != 0 AND $textpopis == 1 ) { ?>
 onmouseover="UkazSkryjPol('<?php echo $rsluz->pop;?>')" onmouseout="Okno.style.display='none';"
<?php                                                                 } ?>
<?php if( $rsluz->zmen == 1 AND $rsluz->pop != '' AND $rsluz->hod != 0 AND $textpopis == 1 ) { ?>
 onmouseover="UkazSkryjPol('<?php echo $rsluz->hodm;?><?php echo $rsluz->mena;?> <?php echo $rsluz->pop;?>')" onmouseout="Okno.style.display='none';"
<?php                                                                 } ?>
  >
<?php echo $rsluz->hod;?></td>

<?php
}
?>
<?php
if(  $rsluz->ucm == 0 AND $rsluz->hod == 0 AND $rsluz->pop != '' )
{
?>
<td class="fmenu" width="10%" ><?php echo $rsluz->ucm;?></td>
<td class="fmenu" width="60%" colspan="7" ><?php echo $rsluz->pop;?></td>
<?php
}
?>
<td class="fmenu" width="5%" >
<?php
if (  $copern == 7 OR $copern == 17 )
     {
?>
<a href='vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=36&drupoh=<?php echo $drupoh;?>&cislo_cpl=<?php echo $rsluz->cpl;?>
&cislo_dok=<?php echo $rsluz->dok;?>
&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>
&z_ucm=<?php echo $rsluz->ucm;?>&z_ucd=<?php echo $rsluz->ucd;?>&z_dph=<?php echo $rsluz->dph;?>
&z_rdp=<?php echo $rsluz->rdp;?>&z_fak=<?php echo $rsluz->fak;?>&z_ico=<?php echo $rsluz->ico;?>&z_str=<?php echo $rsluz->str;?>
&z_zak=<?php echo $rsluz->zak;?>&z_hop=<?php echo $rsluz->hod;?>&z_zmen=<?php echo $rsluz->zmen;?>&z_hodm=<?php echo $rsluz->hodm;?>
&z_pop=<?php echo $rsluz->pop;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 alt="Vymazanie vybranej poloûky" title="Vymazanie vybranej poloûky" ></a>
<?php
     }
?>
</td>
</tr>
<?php
}

$i = $i + 1;
  }

                }
// KONIEC VYPISU POLOZIEK DOKLADU ALEBO ROZUCTOVANIE pre copern 6,7 6666666666666666  777777777777777
?>

<?php
// ZADAVANIE POLOZIEK DOKLADU - ALEBO ROZUCTOVANIE
if ( $rozuct == NIE OR $rozuct == ANO )
          {
?>

<?php
// vstup poloziek sluzby 777777777777777
if ( $copern == 7  OR $copern == 87 )
     {
?>
<tr>
<FORM name="forms1" class="obyc" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>
<?php
if ( $copern == 7 )
     {
?>
&copern=77&cislo_dok=<?php echo $cislo_dok;?>" >

<?php if( $fir_allx15 == 0 OR $drupoh != 4 )  { ?>
<td class="fmenu">
<input type="text" name="h_cpl" id="h_cpl" size="5" />
<INPUT type="hidden" name="ddu" value="<?php echo $ddusk; ?>">
<?php                                         } ?>
<?php if( $fir_allx15 == 1 AND $drupoh == 4 ) { ?>
<td class="fmenu" align="right" >
<input type="hidden" name="h_cpl" id="h_cpl" />
<INPUT type="text" name="ddu" id="ddu" value="<?php echo $ddusk; ?>" size="7" onKeyDown="return DduEnter(event.which)" 
 onChange="return kontrola_datum(this, Kx, this, document.forms1.err_ddu)" onkeyup="KontrolaDatum(this, Kx)" >
<?php                                         } ?>
<input class="hvstup" type="hidden" name="err_ddu" value="0">
</td>
<?php
}
?>
<?php
if ( $copern == 87 )
     {
?>
&copern=88&cislo_dok=<?php echo $cislo_dok;?>&cislo_cpl=<?php echo $z_cpl;?>" >
<td class="fmenu" >
<input type="text" name="h_cpl" id="h_cpl" size="5" style="background-color:lime; color:black;" value="<?php echo $z_cpl;?>" />
</td>
<?php
     }
?>

<td class="fmenu">
<a href="#" onClick="myUcmelement.style.display=''; volajUcm(<?php echo $slpol;?>,1);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù ˙Ëet" title="Hæadaù ˙Ëet" ></a>
<input type="text" name="h_ucm" id="h_ucm" size="7" 
 onfocus="return UcmOnfocus(event.which); onUcm();" 
 onchange="return intg(this,0,999999,Uce,document.forms1.err_ucm)"
 onclick="ZhasniSP(); "
 onkeyup="KontrolaCisla(this, Uce)" onKeyDown="return UcmEnter(event.which)"/>
<INPUT type="hidden" name="err_ucm" value="0"></td>

<td class="fmenu">
<a href="#" onClick="myUcdelement.style.display=''; volajUcd(<?php echo $slpol;?>,1);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù ˙Ëet" title="Hæadaù ˙Ëet" ></a>
<input type="text" name="h_ucd" id="h_ucd" size="7" 
 onchange="return intg(this,0,999999,Uce,document.forms1.err_ucd)" onfocus="return UcdOnfocus(event.which); onUcd();"
 onclick="ZhasniSP(); "
 onkeyup="KontrolaCisla(this, Uce)" onKeyDown="return UcdEnter(event.which)"/>
<INPUT type="hidden" name="err_ucm" value="0"></td>

<?php
if ( $rozuct != 'ANO' )
     {
?>
<td class="fmenu">
<select size="1" name="h_rdp" id="h_rdp" onmouseover="Fx.style.display='none';" onKeyDown="return RdpEnter(event.which)" >
<option value="<?php echo $fir_dph2;?>" ><?php echo $fir_dph2;?></option>
<option value="<?php echo $fir_dph1;?>" ><?php echo $fir_dph1;?></option>
<option value="0" >0</option>
<option value="<?php echo $fir_dph3;?>" ><?php echo $fir_dph3;?></option>
<option value="<?php echo $fir_dph4;?>" ><?php echo $fir_dph4;?></option>
</td>
<?php
     }
?>
<?php
if ( $rozuct == 'ANO' )
     {
?>
<td class="fmenu">
<a href="#" onClick="myRdpelement.style.display=''; volajRdp(<?php echo $slpol;?>,1);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù druh dokladu" title="Hæadaù druh dokladu" ></a>
<input type="text" name="h_rdp" id="h_rdp" size="3" 
 onclick="ZhasniSP();"
 onKeyDown="return RdpEnter(event.which)" onfocus="onRdp();"/>
</td>
<?php
     }
?>

<td class="fmenu" align="right">
<a href="#" onClick="myPrikuelement.style.display=''; volatPriku4();">
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù Fakt˙ru 0=vöetky,SECOM=vöetky pre firmu secom" title="Hæadaù Fakt˙ru 0=vöetky,SECOM=vöetky pre firmu secom" ></a>
<input type="text" name="h_fak" id="h_fak" size="10" 
 onclick="ZhasniSP(); myPrikuelement.style.display='none';" onKeyDown="return FakEnter(event.which)" onfocus="onFak();"/>
<INPUT type="hidden" name="err_fak" value="0"></td>

<td class="fmenu" align="right">
<a href="#" onClick="myIcpelement.style.display=''; volajIcp(<?php echo $slpol;?>,1);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù I»O" title="Hæadaù I»O" ></a>
<input type="text" name="h_ico" id="h_ico" size="7" 
 onclick="ZhasniSP();" onfocus="onIco();"
 onKeyDown="return IcpEnter(event.which)"/>
</td>

<td class="fmenu" align="right">
<a href="#" onClick="myStrelement.style.display=''; volajStr(<?php echo $slpol;?>,1);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù stredisko" title="Hæadaù stredisko" ></a>
<input type="text" name="h_str" id="h_str" size="7" 
 onclick="ZhasniSP();" onfocus="onStr();"
 onchange="return intg(this,0,9999,Str,document.forms1.err_str)"
 onkeyup="KontrolaCisla(this, Str)" onKeyDown="return StrEnter(event.which)"/>
<INPUT type="hidden" name="err_str" value="0"></td>

<td class="fmenu" align="right">
<a href="#" onClick="myZakelement.style.display=''; volajZak(<?php echo $slpol;?>,1);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 alt="Hæadaù z·kazku" title="Hæadaù z·kazku" ></a>
<input type="text" name="h_zak" id="h_zak" size="7" 
 onclick="ZhasniSP();" onfocus="onZak();"
 onchange="return intg(this,0,9999999,Zak,document.forms1.err_zak)"
 onkeyup="KontrolaCisla(this, Zak)" onKeyDown="return ZakEnter(event.which)"/>
<INPUT type="hidden" name="err_zak" value="0"></td>

<td class="fmenu" align="right">
<input type="text" name="h_hop" id="h_hop" size="10" 
 onclick="ZhasniSP();" onfocus="onHop();"
 onchange="return cele(this,-99999999,99999999,Des,2,document.forms1.err_hop)" 
 onkeyup="KontrolaDcisla(this, Des)" onKeyDown="return HopEnter(event.which)" />
<INPUT type="hidden" name="err_hop" >


<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="3" />
<?php
if( $riadok->zmen == 1 )
{
?>
<input type="checkbox" name="h_zmena" id="h_zmena" value="1" checked="checked" 
 onmouseover="UkazSkryjPol('ZaökrtnutÈ=<br />Hodnota v <?php echo $riadok->mena;?><br />NezaökrtnutÈ=<br />Hodnota v <?php echo $mena1;?>');"
 onmouseout="Okno.style.display='none';" />
<?php
}
?>
</td>
<input type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />
<input type="hidden" name="hladaj_uce" id="hladaj_uce" value="<?php echo $hladaj_uce;?>" />
<input type="hidden" name="h_uce" id="h_uce" value="<?php echo $h_uce;?>" />
<input type="hidden" name="h_unk" id="h_unk" value="<?php echo $h_unk;?>" />
<input type="hidden" name="slpol" id="slpol" value="<?php echo $slpol;?>" />
<input type="hidden" name="zmen" id="zmen" value="<?php echo $riadok->zmen;?>" />
<input type="hidden" name="mena" id="mena" value="<?php echo $riadok->mena;?>" />
<input type="hidden" name="kurz" id="zmen" value="<?php echo $riadok->kurz;?>" />

<input class="hvstup" type="hidden" name="kdefoc" id="kdefoc" value="ucm" />
<input class="hvstup" type="hidden" name="klikenter" id="klikenter" value="0" />

<?php
if ( $copern == 87 )
     {
?>
<input type="hidden" name="z_rdp" id="z_rdp" value="<?php echo $z_rdp;?>" />
<input type="hidden" name="z_dph" id="z_dph" value="<?php echo $z_dph;?>" />
<input type="hidden" name="z_hop" id="z_hop" value="<?php echo $z_hop;?>" />
<input type="hidden" name="z_ucm" id="z_ucm" value="<?php echo $z_ucm;?>" />
<input type="hidden" name="z_ucd" id="z_ucd" value="<?php echo $z_ucd;?>" />
<?php
     }
?>
</tr>

<tr>
<td class="hmenu" colspan="5" align="right">
<?php if ( $drupoh == 2 OR $drupoh == 4 OR $drupoh == 5 ) { ?>
<img src='../obr/naradie.png' onClick="nastavpaux.style.display='';" width=15 height=15 border=0 title="Nastavenie ˙Ëtovania pauö·lu 80%" ></a>
&nbsp;
Pauö·l 80%<input type="checkbox" name="pau80" id="pau80" value="1" />
<?php                     } ?>
<?php
if( $textpopis == 1 )
     {
?>
<td class="fmenu" colspan="4" align="right">
 <img src='../obr/info.png' width=12 height=12 border=0 alt="Textov˝ popis poloûky " title="Textov˝ popis poloûky ">
 text: <input type="text" name="h_pop" id="h_pop" size="60" maxlength="80"  
 onKeyDown="return JUPopEnter(event.which)" onfocus="onPop();" />
</td>
</tr>
<?php
     }
?>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" 
 onmouseover="UkazSkryj('Uloûiù poloûku do dokladu')" onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>

</FORM>
<td class="<?php echo $pvstup;?>" ></td>
<?php
if ( $copern != 87 )
     {
?>
<FORM name="formh4" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="<?php echo $pvstup;?>" >
<INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right">
</td>
</FORM>
<?php
}
?>
<?php
if ( $copern == 87 )
     {
?>
<FORM name="formh4" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
<?php
if( $fir_xfa01 == 1 )
{
?>
&h_tlsl=1
<?php
}
?>
&cislo_dok=<?php echo $cislo_dok;?>" >
<td class="<?php echo $pvstup;?>" >
<INPUT type="submit" id="stornou" name="stornou" value="Sp‰ù" align="right"
 onmouseover="UkazSkryj('Neupravovaù poloûku')" onmouseout="Okno.style.display='none';">
</td>
</FORM>
<?php
}
?>

<td class="<?php echo $pvstup;?>" ></td>
<FORM name="forma4" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $h_uce; ?>
&rozuct=<?php echo $rozuct; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1" >
<td class="<?php echo $pvstup;?>" >
<?php
if ( $copern != 87 )
     {
?>
<INPUT type="submit" name="npol" id="npol" value="Doklad" >
<?php
}
?>
</td>
<?php
if ( $kli_vduj == 9 AND ( $drupoh == 4 OR $drupoh == 1 OR $drupoh == 2 OR $drupoh == 5 ) )
     {
?>
<td class="<?php echo $pvstup;?>" align="right"></td>
<td class="<?php echo $pvstup;?>" align="right"></td>
<td class="<?php echo $pvstup;?>" align="right"></td>
<td class="<?php echo $pvstup;?>" align="right">
 <img src='../obr/info.png' width=12 height=12 border=0 alt="Hodnota nezaplatenej DPH z uhr·dzanej fakt˙ry" title="Hodnota nezaplatenej DPH z uhr·dzanej fakt˙ry">
<input type="text" name="h_hdx" id="h_hdx" size="8"  onclick="ZhasniSP();"
 onchange="return cele(this,-99999999,99999999,Des,2,document.forms1.err_hdx)" 
 onkeyup="KontrolaDcisla(this, Des)" onKeyDown="return HdxEnter(event.which)" />
<INPUT type="hidden" name="err_hdx" >
</td>
<?php
     }
?>
<?php
if ( $kli_vduj != 9 OR ( $drupoh != 5 AND $drupoh != 4 AND $drupoh != 1 AND $drupoh != 2 ) )
     {
?>
<td class="<?php echo $pvstup;?>" align="right">
<input type="hidden" name="h_hdx" id="h_hdx" />
<INPUT type="hidden" name="err_hdx" >
</td>
<?php
     }
?>
</FORM>

<?php
     }
//koniec vstupu poloziek sluzby 77777777777777777777
?>
<?php
// vstup text poloziek sluzby 1717171717171717
if ( $copern == 17 OR $copern == 97 )
     {
?>
<tr>
<FORM name="forms1" class="obyc" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>
<?php
if ( $copern == 17 )
{
?>
&copern=77&cislo_dok=<?php echo $cislo_dok;?>" >
<td class="fmenu"><input type="text" name="h_cpl" id="h_cpl" size="5" /></td>
<?php
}
?>
<?php
if ( $copern == 97 )
{
?>
&copern=98&cislo_dok=<?php echo $cislo_dok;?>&cislo_cpl=<?php echo $z_cpl;?>" >
<td class="fmenu" >
<input type="text" name="h_cpl" id="h_cpl" size="5" style="background-color:lime; color:black;" value="<?php echo $z_cpl;?>" />
</td>
<?php
}
?>

<td class="fmenu" colspan="7">
<input type="text" name="h_pop" id="h_pop" size="100" maxlength="90" onclick="ZhasniSP(); " 
 onKeyDown="return PopEnter(event.which)" />
</td>


<INPUT type="hidden" name="h_ucm" value="0"></td>
<INPUT type="hidden" name="h_ucd" value="0"></td>
<INPUT type="hidden" name="h_rdp" value="0"></td>
<INPUT type="hidden" name="h_dph" value="0"></td>
<INPUT type="hidden" name="h_fak" value="0"></td>
<INPUT type="hidden" name="h_hop" value="0"></td>

<input type="hidden" name="hlas" id="hlas" value="NIE" />


<td class="fmenu" align="right"><input type="text" name="h_mer" id="h_mer" size="3" onClick="return Povol_uloz();"
onKeyDown="return MerEnter(event.which)" />

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="3" /></td>
<input type="hidden" name="h_dok" id="h_dok" value="<?php echo $cislo_dok;?>" />

</tr>


<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" onclick="Zapis_COOK();" 
 onmouseover="UkazSkryj('Uloûiù poloûku do dokladu')" onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</FORM>
<td class="<?php echo $pvstup;?>" ></td>
<?php
if ( $copern != 97 )
     {
?>
<FORM name="formh4" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="<?php echo $pvstup;?>" >
<INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right">
</td>
</FORM>
<?php
}
?>
<?php
if ( $copern == 97 )
     {
?>
<FORM name="formh4" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
<?php
if( $fir_xfa01 == 1 )
{
?>
&h_tlsl=1
<?php
}
?>
&cislo_dok=<?php echo $cislo_dok;?>" >
<td class="<?php echo $pvstup;?>" >
<INPUT type="submit" id="stornou" name="stornou" value="Sp‰ù" align="right"
 onmouseover="UkazSkryj('Neupravovaù poloûku')" onmouseout="Okno.style.display='none';">
</td>
</FORM>
<?php
}
?>

<td class="<?php echo $pvstup;?>" ></td>
<FORM name="forma4" method="post" action="vspk_u.php?sysx=<?php echo $sysx; ?>&rozuct=<?php echo $rozuct; ?>&copern=5&drupoh=<?php echo $drupoh;?>&page=1" >
<td class="<?php echo $pvstup;?>" >
<?php
if ( $copern != 97 )
     {
?>
<INPUT type="submit" name="npol" id="npol" value="Doklad" >
<?php
}
?>
</td>
</FORM>

<?php
     }
//koniec vstupu text poloziek sluzby 171717171717
?>

<?php
// KONIEC ZADAVANIE POLOZIEK DOKLADU - ALEBO ROZUCTOVANIE
          }
?>


<?php
// ZOBRAZ SUMARE PRE ROZUCTOVANIE
if ( $rozuct == 'ANO' )
     {

//pre pokladnicne doklady
if ( $drupoh == 1 OR $drupoh == 2 OR $drupoh == 3 OR $drupoh == 5 )
          {

?>
<tr></tr><tr></tr>
<tr>
<td class="<?php echo $pvstup ?>" width="10%" colspan="3">
SAL<img src='../obr/zoznam.png' onClick="PonukaSaldo();" width=15 height=15 border=0 alt='Ponuka neuhraden˝ch fakt˙r za vybranÈ I»O' title='Ponuka neuhraden˝ch fakt˙r za vybranÈ I»O' >
</td>
<td class="<?php echo $pvstup ?>" width="10%" >&nbsp;</td>
<td class="<?php echo $pvstup ?>" width="10%" >&nbsp;</td><td class="<?php echo $pvstup ?>" width="10%" >&nbsp;</td>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >&nbsp;Sadzba DPH</td>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >&nbsp;Z·klad</td>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >&nbsp;DaÚ</td>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >&nbsp;Spolu</td>
</tr>
<?php
if(  $riadok->zk1u !=0 )
{
?>
<tr>
<td class="<?php echo $pvstup ?>" colspan="6" >&nbsp;</td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $fir_dph1; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->zk1u; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->dn1u; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->sp1u; ?></td>
</tr>
<?php
}
?>
<tr>
<td class="<?php echo $pvstup ?>" colspan="6" >&nbsp;</td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $fir_dph2; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->zk2u; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->dn2u; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->sp2u; ?></td>
</tr>
<?php
if(  $riadok->zk0u !=0 )
{
?>
<tr>
<td class="<?php echo $pvstup ?>" colspan="6" >&nbsp;</td>
<td class="<?php echo $hvstup ?>" align="right" >0</td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->zk0u; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->zk0u; ?></td>
</tr>
<?php
}
?>
<tr>
<td class="<?php echo $pvstup ?>" colspan="7" align="right" >&nbsp;
<td class="<?php echo $pvstup ?>" colspan="2" align="right" >
&nbsp;Celkom roz˙Ëtovan· hodnota dokladu:</td>
<td class="<?php echo $hvstup ?>" align="right" colspan="1" ><?php echo $riadok->hodu; ?></td>
</tr>
<tr></tr><tr></tr>

<?php
//koniec pre pokladnicne doklady
          }

//pre banku
if ( $drupoh == 4 )
          {

?>
<tr></tr><tr></tr>
<tr>
<td class="<?php echo $pvstup ?>" width="10%" colspan="4">&nbsp;</td>
<td class="<?php echo $pvstup ?>" width="10%" >&nbsp;</td>
<td class="<?php echo $pvstup ?>" width="10%" >&nbsp;</td><td class="<?php echo $pvstup ?>" width="10%" >&nbsp;</td>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >&nbsp;Vklady</td>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >&nbsp;V˝bery</td>
<td class="<?php echo $pvstup ?>" width="10%" align="right" >&nbsp;Rozdiel</td>
</tr>
<tr>
<td class="<?php echo $pvstup ?>" colspan="7" >
BU<img src='../obr/zoznam.png' onClick="PonukaBanka();" width=15 height=15 border=0 alt='Ponuka zoznamu bankov˝ch ˙Ëtov' title='Ponuka zoznamu bankov˝ch ˙Ëtov' >
HOD<img src='../obr/zoznam.png' onClick="PonukaHodnota();" width=15 height=15 border=0 alt='Ponuka neuhraden˝ch fakt˙r podæa hodnoty' title='Ponuka neuhraden˝ch fakt˙r podæa hodnoty' >
SAL<img src='../obr/zoznam.png' onClick="PonukaSaldo();" width=15 height=15 border=0 alt='Ponuka neuhraden˝ch fakt˙r za vybranÈ I»O' title='Ponuka neuhraden˝ch fakt˙r za vybranÈ I»O' >
</td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->zk0u; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->zk1u; ?></td>
<td class="<?php echo $hvstup ?>" align="right" ><?php echo $riadok->zk2u; ?></td>
</tr>
<tr></tr><tr></tr>

<?php
//koniec pre banku
          }
?>

</table>
<?php
// KONIEC ZOBRAZ SUMARE PRE ROZUCTOVANIE
     }
?>
<div id="myPrikuelement"></div>

<div id="jeUcm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeUcd" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeRdp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeIcp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>



<?php
//VYPIS POLOZIEK DOKLADU za rozuctovanim
if ( $rozuct == 'ANO' AND ( $copern == 6 OR $copern == 7 OR $copern == 17 OR $copern == 87 OR $copern == 97 ) )
                {
?>

<?php
//VYPIS POLOZIEK DOKLADU - NIE ROZUCTOVANIE za rozuctovanim
$sluztt = "SELECT dok, poh, cpl, ucm, ucd, rdp, fak, ico, str, zak, hod,".
" pop". 
" FROM F$kli_vxcf"."_uctpok".
" WHERE F$kli_vxcf"."_uctpok.dok = $cislo_dok ".
" ORDER BY cpl";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

if( $slpol > 0 )
{
?>

<table class="fmenu" width="100%" >

<tr><td class="pvstup" colspan="9">Poloûky dokladu</td></tr>
<tr>
<td class="pvstup" width="10%">Por.ËÌslo
<td class="pvstup" width="10%"><?php echo $UCM; ?>
<td class="pvstup" width="10%"><?php echo $UCD; ?><td class="pvstup" width="10%">%DPH
<td class="pvstup" width="10%" align="right">FAK<td class="pvstup" width="10%" align="right">I»O
<td class="pvstup" width="10%" align="right">STR
<td class="pvstup" width="10%" align="right">Z¡K<td class="pvstup" width="10%" align="right">Hodnota
<td class="pvstup" width="10%">Zmaû
</tr>

<?php
}

//zaciatok vypisu
$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

?>
<tr>
<td class="fmenu" width="10%" ><?php echo $rsluz->cpl;?></td>

<?php
if(  $rsluz->ucm > 0 OR $rsluz->ucd > 0 OR $rsluz->hod > 0 )
{
?>
<td class="fmenu" width="10%" ><?php echo $rsluz->ucm;?></td>
<td class="fmenu" width="10%" ><?php echo $rsluz->ucd;?></td>
<td class="fmenu" width="10%" ><?php echo $rsluz->rdp;?></td>
<td class="fmenu" width="10%" align="right" ><?php echo $rsluz->fak;?></td>
<td class="fmenu" width="10%" align="right" ><?php echo $rsluz->ico;?></td>
<td class="fmenu" width="10%" align="right" ><?php echo $rsluz->str;?></td>
<td class="fmenu" width="10%" align="right" ><?php echo $rsluz->zak;?></td>
<td class="fmenu" width="10%" align="right" ><?php echo $rsluz->hod;?></td>

<?php
}
?>
<?php
if(  $rsluz->ucm == 0 AND $rsluz->hod == 0 AND $rsluz->pop != '' )
{
?>
<td class="fmenu" width="10%" ><?php echo $rsluz->ucm;?></td>
<td class="fmenu" width="60%" colspan="7" ><?php echo $rsluz->pop;?></td>
<?php
}
?>
<td class="fmenu" width="5%" ></td>
</tr>
<?php
}

$i = $i + 1;
  }

                }
// KONIEC VYPISU POLOZIEK DOKLADU - NIE ROZUCTOVANIE za rozuctovanim pre copern 6,7 6666666666666666  777777777777777
?>


<?php
if(  $slpol > 0 OR $rozuct == 'NIE' )
     {
?>
<tr></tr><tr></tr>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Sadzba DPH</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Z·klad</td>
<td class="pvstup" width="10%" align="right" >&nbsp;DaÚ</td>
<td class="pvstup" width="10%" align="right" >&nbsp;Spolu</td>
</tr>
<?php
if(  $riadok->zk1 !=0 )
{
?>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" ><?php echo $fir_dph1; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->zk1; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->dn1; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->sp1; ?></td>
</tr>
<?php
}
?>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" ><?php echo $fir_dph2; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->zk2; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->dn2; ?></td>
<td class="hvstup" align="right" ><?php echo $riadok->sp2; ?></td>
</tr>
<?php
if(  $riadok->zk0 !=0 )
{
?>
<tr>
<td class="pvstup" colspan="6" >&nbsp;</td>
<td class="hvstup" align="right" >0</td>
<td class="hvstup" align="right" ><?php echo $riadok->zk0; ?></td>
<td class="hvstup" align="right" ></td>
<td class="hvstup" align="right" ><?php echo $riadok->zk0; ?></td>
</tr>
<?php
}
?>
<tr>
<td class="pvstup" colspan="9" align="right" >&nbsp;Celkom hodnota dokladu:</td>
<td class="hvstup" align="right" colspan="1" ><?php echo $riadok->hod; ?></td>
</tr>
<tr></tr><tr></tr>
</table>
<?php
     }
?>


<table class="vstup" width="100%">
<FORM name="formx1" class="obyc" method="post" action="#" >
<tr>
<?php
if ( $copern == 7 AND $drupoh < 4  )
     {

$peciatkaano=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_pokladnicaset$kli_uzid ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $peciatkaano=1*$riaddok->zmd;
  }
?>
<script type="text/javascript" src="pok_set.js"></script>
<td class="pvstup" width="15%" >
&nbsp&nbsp<img src='../obr/naradie.png' onClick="nastavfakx.style.display=''; volajPokset(<?php echo $kli_uzid;?>);" width=15 height=15 border=0 title="Nastaviù parametre pokladniËnÈho dokladu" ></a>
&nbsp&nbsp
<input type="checkbox" name="h_razitko" value="1" /> peËiatka
<?php
if ( $peciatkaano == 1 )
   {
?>
<script type="text/javascript">
document.formx1.h_razitko.checked = "checked";
</script>
<?php
   }
?> 
</td>
<?php
     }
?>

<td class="pvstup" width="15%" >&nbsp;Pozn·mka:</td>
<td class="hvstup" width="40%" ><?php echo $riadok->poz; ?></td>
<td class="pvstup" width="25%" >&nbsp;(Nebude vytlaËen· na doklade)</td><td class="pvstup" width="5%" >&nbsp;

<?php
if ( $drupoh == 5 AND ( $_SERVER['SERVER_NAME'] == "www.edcom.sk" OR $_SERVER['SERVER_NAME'] == "localhost" ) )
   {
?>
<a href="#" onClick="window.open('pridaj_polozky.php?copern=100&drupoh=<?php echo $drupoh; ?>&cislo_uce=<?php echo $hladaj_uce; ?>&cislo_dok=<?php echo $cislo_dok; ?>&page=1', '_self' )">
504<img src='../obr/ziarovka.png' width=15 height=15 border=0 title="Pridaj do dokladu Poloûky predanÈho tovaru za mesiac podæa dokladov s 604" ></a>
</td>
<?php
   }
?>
</tr>
</FORM>
</table>

<?php 
//[[[[[[[[[[[[66666666666666666vymazanie
if ( $copern == 6 )
     {
?>
<table class="vstup" width="100%">
<FORM name="formv2" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=16&
cislo_dok=<?php echo $riadok->dok;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="Vymazaù" 
 onmouseover="UkazSkryj('Vymazaù vybran˝ doklad')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="vstpok.php?sysx=<?php echo $sysx; ?>&hladaj_uce=<?php echo $hladaj_uce; ?>
&rozuct=<?php echo $rozuct; ?>&drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno" 
 onmouseover="UkazSkryj('Nevymazaù vybran˝ doklad , n·vrat do zoznamu dokladov')" onmouseout="Okno.style.display='none';" ></td>
</tr>
</FORM>
</table>
<?php 
     }
?>

<?php
  }
$j = $j + 1;
   }
?>


<?php
// toto je koniec vymazanie faktury copern=6 a sluzby copern=7 
     }

$robot=1;
$cislista = include("uct_lista.php");
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
