<HTML>
<?php
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

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


//http://www.ekorobot.sk/ucto/ext_fakt.php?copern=55&page=1&h_sys=55&h_obdp=1&drupoh=1&uprav=1
if( $fir_fico == 36276693 AND $kli_vrok != 2018 ) { echo $kli_vrok." ??"; exit; }
if( $fir_fico == 36276693 AND $kli_vrok == 2018 ) 
{
?>
<script type="text/javascript">
  var okno = window.open("ext_fakt36276693.php?copern=55&page=1&h_sys=55&h_obdp=<?php echo $h_obdp; ?>&drupoh=1&uprav=1","_self");
</script>
<?php
exit;
}

//exit;

if( $fir_fico == 31416853 AND $kli_vrok != 2018 ) { echo $kli_vrok." ??"; exit; }
if( $fir_fico == 31416853 AND $kli_vrok == 2018 AND $h_sys == 59 ) 
{
?>
<script type="text/javascript">
  var okno = window.open("ext_fakt31416853sys59.php?copern=55&page=1&h_sys=59&h_obdp=<?php echo $h_obdp; ?>&drupoh=1&uprav=1","_self");
</script>
<?php
exit;
}

//naimportovanie ext.faktur
if ( $copern == 55 )
    {

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
$fakodb=1;
$uctskl=0;
$uctobd=0;
$ico=0;
$kvdph=0;

$i=0;
$vymazalsom=0;
$vymazalsomkv=0;

$subor = fopen("../import/$nazovsuboru.csv", "r");
while (! feof($subor))
{
  $i=$i+1;
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

if( $uctskl == 2 ) { $uctskl=1; }
if( $uctodb == 2 ) { $uctodb=1; }
if( $ico == 2 ) { $ico=1; }
if( $kvdph == 2 ) { $kvdph=1; }

$oddelovac="".$pole[0];
$oddelovac=trim(substr($oddelovac,0,8));

if( $oddelovac == "endodber" ) { $fakodb=0; $uctskl=2; $uctodb=0; $ico=0; $kvdph=0; }
if( $oddelovac == "endpohuc" ) { $fakodb=0; $uctskl=0; $uctodb=2; $ico=0; $kvdph=0; }
if( $oddelovac == "enducfak" ) { $fakodb=0; $uctskl=0; $uctodb=0; $ico=2; $kvdph=0; }
if( $oddelovac == "endico" ) { $fakodb=0; $uctskl=0; $uctodb=0; $ico=0; $kvdph=2; }
if( $oddelovac == "endkvdph" ) { $fakodb=0; $uctskl=0; $uctodb=0; $ico=0; $kvdph=0; }


//zaciatok fakodb
if( $fakodb == 1 )
          {
  $x_uce = $pole[0];
  $x_dok = $pole[1];
  $x_dor = $pole[2];
  $x_fak = $pole[3];
  $x_ico = $pole[4];
  $x_ksy = $pole[5];
  $x_ssy = $pole[6];
  $x_spl = $pole[7];
  $x_hod = $pole[8];
  $x_pop = $pole[9];
  $x_pom = $pole[10];
  $x_dat = $pole[11];
  $x_ume = $pole[12];
  $x_dpr = $pole[13];
  $x_hou = $pole[14];
  $x_kod = $pole[15];
  $x_uhr = $pole[16];
  $x_duh = $pole[17];
  $x_sys = $pole[18];
  $x_dz0 = $pole[19];
  $x_dz5 = $pole[20];
  $x_dh5 = $pole[21];
  $x_dz2 = $pole[22];
  $x_dh2 = $pole[23];

  $x_mena = $pole[24];
  $x_hodm = 1*$pole[25];
  $x_kurz = 1*$pole[26];

  $x_sz3 = trim($pole[27]);
  $x_dav = trim($pole[28]);
  $x_kon = $pole[29];

$sz35=substr($x_sz3,0,5);

if( $kli_vrok < 2014 ) { $x_sz3=""; $x_dav=""; }
if( $kli_vrok >= 2014 AND $x_sz3 == '' ) { $x_sz3=$x_fak; }
if( $kli_vrok >= 2014 AND $sz35 == 'konec' ) { $x_sz3=$x_fak; $x_dav=""; }
if( $x_dav == '0' ) { $x_dav=""; }

$zmen=1;
if( $x_hodm == 0 OR $x_kurz == 0 OR $x_kurz == 1 ) { $zmen=0; $x_hodm=0; $x_kurz=0; $x_mena=""; } 
 
  $dat_sql = SqlDatum($x_dat);
  $das_sql = SqlDatum($x_spl);
  $daz_sql = SqlDatum($x_dat);

if( $kli_vrok >= 2014 AND $_SERVER['SERVER_NAME'] == "www.euroautovalas.sk" )
{
  $dat_sql = SqlDatum($x_dor);
  $das_sql = SqlDatum($x_spl);
  $daz_sql = SqlDatum($x_dat);
}
 
  $poleu = explode("-", $dat_sql);
  $x_ume = $poleu[1].".".$poleu[0];

if( $x_ume != $kli_vume ) { echo "POZOR !!! Nastavené úètovné obdobie ".$kli_vume." sa nezhoduje s obdobím v prenášanej dávke ".$x_ume." (napríklad Faktúra ".$x_fak." )"; exit; }
if( $x_sys != $h_sys ) { echo "POZOR !!! Nastavený podsystém ".$h_sys." sa nezhoduje s podsystémom v prenášanej dávke ".$x_sys." (napríklad Faktúra ".$x_fak." )"; exit; }

//vymaz povodne
if( $vymazalsom == 0 )
    {
//echo "mazem";

$squlz = "DELETE FROM F$kli_vxcf"."_fakodb WHERE skl=$h_sys AND ume=$obdobie ";
//echo $squlz;
$zmazane = mysql_query("$squlz");

include("../ucto/saldo_zmaz_ok.php"); 

$squlz = "DELETE FROM F$kli_vxcf"."_uctskl WHERE poh=$h_sys AND ume=$obdobie ";
//echo $squlz;
$zmazane = mysql_query("$squlz");

//toto je dost casovo narocne preto od 10.2009 v alcheme a vsade od 1.2010 pouzivam vymazavanie z uctodb podla poh=11055
if( ( $kli_vume < 10.2009 AND $kli_vrok <= 2009 ) OR ( $alchem != 1 AND $autovalas != 1 AND $kli_vrok <= 2009 ) )
         {
//echo "pomale";

$squlz = "UPDATE F$kli_vxcf"."_uctodb SET poh=999 ";
$zmazane = mysql_query("$squlz");

$squlz = "UPDATE F$kli_vxcf"."_uctodb,F$kli_vxcf"."_fakodb SET F$kli_vxcf"."_uctodb.poh=F$kli_vxcf"."_fakodb.poh ".
"WHERE F$kli_vxcf"."_fakodb.dok=F$kli_vxcf"."_uctodb.dok ";
//echo $squlz;
$zmazane = mysql_query("$squlz");

$pohcis=1000*$h_obdp+$h_sys;
$squlz = "DELETE FROM F$kli_vxcf"."_uctodb WHERE poh=999 ";
$zmazane = mysql_query("$squlz");
          }

if( ( $kli_vume >= 10.2009 AND ( $alchem == 1 OR $autovalas= 1 ) ) OR $kli_vrok > 2009 )
         {
//echo "rychle";

$pohcis=1000*$h_obdp+$h_sys;
$squlz = "DELETE FROM F$kli_vxcf"."_uctodb WHERE poh=$pohcis ";
$zmazane = mysql_query("$squlz");
          }

$vymazalsom=1;
    }
//koniec vymazania povodneho

$x_sp1=1*($x_dz5+$x_dh5);
$x_sp2=1*($x_dz2+$x_dh2);

$ucet2=substr($x_uce,0,2);
$ucet3=substr($x_uce,0,3);
 
$sqult = "INSERT INTO F$kli_vxcf"."_fakodb ( uce,dok,doq,fak,ico,str,zak,dat,daz,das,zk2,dn2,sp2,hod,id,".
"zk1,dn1,sp1,zk0,zao,zal,ruc,uhr,zk3,zk4,dn3,dn4,sz1,sz2,sz3,sz4,dol,prf,skl,poh,dav,".
"obj,unk,dpr,ksy,ssy,poz,txz,txp,ume,hodu,zk0u,zk2u,dn2u,zk1u,dn1u,sp1u,sp2u,".
"zmen,mena,kurz,hodm)".
" VALUES ( '$x_uce', '$x_dok', '$x_dok', '$x_fak', '$x_ico', '$x_str', '$x_zak', '$dat_sql', '$daz_sql', '$das_sql',".
" '$x_dz2', '$x_dh2', '$x_sp2', '$x_hod', '$kli_uzid',".
" '$x_dz5', '$x_dh5', '$x_sp1', '$x_dz0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$x_sz3', '0', '0', '0', '$x_sys', '$pohcis', '$x_dav',".
" '', '', '', '$x_ksy', '$x_ssy', '', '', '$x_pop', '$x_ume', '$x_hod','$x_dz0', '$x_dz2', '$x_dh2','$x_dz5', '$x_dh5', '$x_sp1', '$x_sp2', ".
" '$zmen', '$x_mena', '$x_kurz', '$x_hodm' );";

if( $ucet3 == 311 ) { $ulozene = mysql_query("$sqult"); }

//tvrde upravy odb.miesta pre alchem
if( $fir_fico == 31424317 )
  {
if( $kli_vume == 5.2018 )
    {
$squlop = "UPDATE F$kli_vxcf"."_fakodb SET odbm=1 WHERE dok = 628014 ";
$oprvx = mysql_query("$squlop");
    }
if( $kli_vume == 7.2018 )
    {
$squlop = "UPDATE F$kli_vxcf"."_fakodb SET odbm=1 WHERE dok = 628040 ";
$oprvx = mysql_query("$squlop");
    }
if( $kli_vume == 9.2018 )
    {
$squlop = "UPDATE F$kli_vxcf"."_fakodb SET odbm=1 WHERE dok = 628084 OR dok = 628088 OR dok = 628098 ";
$oprvx = mysql_query("$squlop");
    }
if( $kli_vume == 10.2018 )
    {
$squlop = "UPDATE F$kli_vxcf"."_fakodb SET odbm=1 WHERE dok = 628121 ";
$oprvx = mysql_query("$squlop");
    }
  }
//koniec tvrde upravy odb.miesta pre alchem

//echo $pole[0]." ".$odber."-".$i."<br />";
          }
//koniec fakodb

//zaciatok uctskl
//dok ; ;ico ; ;cpr ; ;fak ; ;ucm ; ;ucd ; ;hod ; ;suh ; ;pop ; ;str ; ;zak ; ;ume ; 7;dat ; 10;rdp ; ;upl ; ;zme ; ;kod ; ;sys ; ;xt konec@r$

if( $uctskl == 1 )
          {
  $x_dok = $pole[0];
  $x_ico = $pole[1];
  $x_cpr = $pole[2];
  $x_fak = $pole[3];
  $x_ucm = $pole[4];
  $x_ucd = $pole[5];
  $x_hod = $pole[6];
  $x_suh = $pole[7];
  $x_pop = $pole[8];
  $x_str = $pole[9];
  $x_zak = $pole[10];
  $x_ume = $pole[11];
  $x_dat = $pole[12];
  $x_rdp = $pole[13];
  $x_upl = $pole[14];
  $x_zme = $pole[15];
  $x_kod = $pole[16];
  $x_sys = $pole[17];

  $x_kon = $pole[18];
  $dat_sql = SqlDatum($x_dat); 


if( $x_ume != $kli_vume ) { echo "POZOR !!! Nastavené úètovné obdobie ".$kli_vume." sa nezhoduje s obdobím v prenášanej dávke ".$x_ume." (napríklad Faktúra ".$x_fak." )"; exit; }
if( $x_sys != $h_sys ) { echo "POZOR !!! Nastavený podsystém ".$h_sys." sa nezhoduje s podsystémom v prenášanej dávke ".$x_sys." (napríklad Faktúra ".$x_fak." )"; exit; }

//vymaz povodne
if( $vymazalsom == 0 )
    {
//echo "mazem";

$squlz = "DELETE FROM F$kli_vxcf"."_fakodb WHERE skl=$h_sys AND ume=$obdobie ";
//echo $squlz;
$zmazane = mysql_query("$squlz");

include("../ucto/saldo_zmaz_ok.php"); 

$squlz = "DELETE FROM F$kli_vxcf"."_uctskl WHERE poh=$h_sys AND ume=$obdobie ";
//echo $squlz;
$zmazane = mysql_query("$squlz");


if( ( $kli_vume >= 10.2009 AND ( $alchem == 1 OR $autovalas= 1 ) ) OR $kli_vrok > 2009 )
         {
//echo "rychle";

$pohcis=1000*$h_obdp+$h_sys;
$squlz = "DELETE FROM F$kli_vxcf"."_uctodb WHERE poh=$pohcis ";
$zmazane = mysql_query("$squlz");
          }

$vymazalsom=1;
    }
//koniec vymazania povodneho


$c_dok=1*$x_dok;
$c_hod=1*$x_hod;
$c_ucm=1*$x_ucm;
$c_ucd=1*$x_ucd;
 
$sqty = "INSERT INTO F$kli_vxcf"."_uctskl ( ume,dat,dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$x_ume', '$dat_sql', '$x_dok', '$x_sys', '$x_ucm', '$x_ucd', '$x_rdp', 0, '$x_hod', '$x_ico', '$x_fak', '$x_pop', '$x_str', '$x_zak', '', $kli_uzid );"; 

if( $c_dok > 0 AND $c_hod != 0 AND $c_ucm > 0 AND $c_ucd > 0 ) { $ulozene = mysql_query("$sqty"); }
//echo $sqty;

//echo $pole[0]." ".$pohuc."-".$i."<br />";
          }
//koniec uctskl

//zaciatok uctodb
//dok ; ;ico ; ;cpr ; ;fak ; ;ucm ; ;ucd ; ;hod ; ;suh ; ;pop ; ;str ; ;zak ; ;ume ; 7;dat ; 10;rdp ; ;upl ; ;zme ; ;kod ; ;sys ; ;xt konec@r$

if( $uctodb == 1 )
          {
  $x_dok = $pole[0];
  $x_ico = $pole[1];
  $x_cpr = $pole[2];
  $x_fak = $pole[3];
  $x_ucm = $pole[4];
  $x_ucd = $pole[5];
  $x_hod = $pole[6];
  $x_suh = $pole[7];
  $x_pop = $pole[8];
  $x_str = $pole[9];
  $x_zak = $pole[10];
  $x_ume = $pole[11];
  $x_dat = $pole[12];
  $x_rdp = $pole[13];
  $x_upl = $pole[14];
  $x_zme = $pole[15];
  $x_kod = $pole[16];
  $x_sys = $pole[17];

  $x_kon = $pole[18];
 
if( $x_rdp == 52 ) { $x_rdp=55; }
$c_dok=1*$x_dok;
 
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$x_dok', '$pohcis', '$x_ucm', '$x_ucd', '$x_rdp', 0, '$x_hod', '$x_ico', '$x_fak', '$x_pop', '$x_str', '$x_zak', '', $kli_uzid );"; 

if( $c_dok > 0 ) { $ulozene = mysql_query("$sqty"); }
//echo $sqty;

//echo $pole[0]." ".$pohuc."-".$i."<br />";
          }
//koniec uctodb

//zaciatok ico
//ico ; ;dic ; ;naz ; ;uli ; ;kra ; ;psc ; ;mes ; ;tel ; ;fax ; ;xt konec@r$

if( $ico == 1 )
          {
  $x_ico = $pole[0];
  $x_icd = $pole[1];
  $x_naz = $pole[2];
  $x_uli = $pole[3];
  $x_kra = $pole[4];
  $x_psc = $pole[5];
  $x_mes = $pole[6];
  $x_tel = $pole[7];
  $x_fax = $pole[8];

  $x_kon = $pole[9];

$x_dic=substr($x_icd,2,12);
$x_cico=1*$x_ico;
$x_cpsc=1*$x_psc;
if( $x_cpsc < 10000) { $x_psc="0".$x_cpsc; }
 
$sqult = "INSERT INTO F$kli_vxcf"."_ico ( ico,icd,dic,nai,uli,mes,psc,tel,fax,em1,www,nm1,uc1,nm2,uc2,nm3,uc3,dns)".
" VALUES ( '$x_ico', '$x_icd', '$x_icd', '$x_naz', '$x_uli', '$x_mes', '$x_psc', '$x_tel', '$x_fax', '$x_ema', '$x_www',".
" '$x_num', '$x_ucb', '$x_num2', '$x_ucb2', '$x_num3', '$x_ucb3', '$x_dns'".
"  );";
if( $x_cico > 0 ) { $ulozene = mysql_query("$sqult"); }
//echo $sqult."<br />";

//echo $pole[0]." ".$pohuc."-".$i."<br />";
          }
//koniec ico


//zaciatok kvdph
if( $kvdph == 1 )
          {

//vymaz povodne
if( $vymazalsomkv == 0 )
    {
$squlz = "DELETE FROM F$kli_vxcf"."_uctvykdpha2 WHERE prx2=$kli_vmes ";
$zmazane = mysql_query("$squlz");

$vymazalsomkv=1;
    }
//koniec vymazania povodneho

//endico
//1;740002;;IO;1500.00;ks;3000.00;0.00;0;0;konec
//2;740002;;MT;30.00;ks;3000.00;0.00;0;0;konec
//endkvdph
//787;624009;1005;; 203.88;t;31601.4;0;;;konec

//cpld	dok	kodt	dtov	mnot	merj	zkld	sumd	prx1	prx2
//522;624003;1206;; 47.32;t;15000.44;0;;;konec

  $x_cpl = $pole[0];
  $x_dok = 1*$pole[1];
  $x_kodt = $pole[2];
  $x_dtov = $pole[3];
  $x_mnot = trim($pole[4]);
  $x_merj = trim($pole[5]);
  $x_zkld = 1*$pole[6];
  $x_sumd = 1*$pole[7];
  $x_prx1 = 1*$pole[8];
  $x_prx2 = 1*$pole[9];

  $x_kon = $pole[10];

$c_dok=1*$x_dok;
 
$sqty = "INSERT INTO F$kli_vxcf"."_uctvykdpha2 ( dok,kodt,dtov,mnot,merj,zkld,sumd,prx2 )".
" VALUES ('$x_dok', '$x_kodt', '$x_dtov', '$x_mnot', '$x_merj', '$x_zkld', '$x_sumd', '$kli_vmes' );"; 

if( $c_dok > 0 ) { $ulozene = mysql_query("$sqty"); }
 //echo $sqty."<br />";

          }
//koniec kvdph


//koniec while
}
fclose ($subor);

//exit;

//uloz do uctsklsaldo
$sql = "CREATE TABLE F".$kli_vxcf."_uctsklsaldo SELECT * FROM F".$kli_vxcf."_uctskl WHERE ume=$kli_vume ";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_uctsklsaldo WHERE ume=$kli_vume ";
$vysledek = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctsklsaldo SELECT * FROM F".$kli_vxcf."_uctskl WHERE ume=$kli_vume ".
" AND ( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 OR  LEFT(ucd,2) = 31 OR  LEFT(ucd,2) = 32 )  ";
$vysledek = mysql_query("$sql");

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
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
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
    window.open('../ucto/zozdok.php?copern=101&drupoh=1&page=1&cislo_uce=31100&page=1&tlacitR=1', '_self' );
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
