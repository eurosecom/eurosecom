<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$hladaj_uce = 1*$_REQUEST['hladaj_uce'];
$ostre = 1*$_REQUEST['ostre'];


if( $copern == 1 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp == 0 )
{
?>
<script type="text/javascript">
alert ("Mzdy za obdobie <?php echo $kli_vume; ?> , \r neboli spracované naostro !");
window.close();
</script>
<?php
exit;
}
    }



if(!isset($kli_vxcf)) $kli_vxcf = 1;

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

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$sql = "ALTER TABLE F$kli_vxcf"."_uctprikp ADD pbic VARCHAR(10) NOT NULL AFTER iban ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzaltrn MODIFY trx3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");

//bic dane sp a odbory
$sql = "SELECT bicod FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpfo1 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpfo2 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdppo1 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdppo2 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdph VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpzc VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpzr VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpdmv VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicdpfo1 VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicsp VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD bicod VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uhrada miezd</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
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

<?php
//tuto nacitam udaje z miezd do prikp
if( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 OR $copern == 5 )
     {
//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   sum_ban      DECIMAL(10,2) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   dok          INT(7) DEFAULT 0,
   ucep         VARCHAR(30) NOT NULL,
   nump         VARCHAR(4) NOT NULL,
   vsyp         DECIMAL(10,0) DEFAULT 0,
   ksyp         VARCHAR(4) NOT NULL,
   ssyp         VARCHAR(30) NOT NULL,
   dm           INT(7) DEFAULT 0,
   trncpl       INT(7) DEFAULT 0,
   twib         VARCHAR(30) NOT NULL,
   ibanp        VARCHAR(40) NOT NULL,
   pbicp        VARCHAR(10) NOT NULL,
   konx         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

$exekucie=0;
if( $copern == 5 AND $wedgb == 1 ) { $copern=1; $exekucie=1; }

//zamestnanci
if( $copern == 1 )
     {
//zober data zo sum vyplaty do banky
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum_ban,oc,$cislo_dok,".
" '','',0,'','',".
" 0,0,'','','',5".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND sum_ban > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln udaje kun do vy
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET ucep=uceb, nump=numb, vsyp=vsy, ksyp=ksy, ssyp=ssy".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if( $kli_vrok >= 2014 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdtextmzd".
" SET ibanp=ziban, pbicp=zswft ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdtextmzd.invt";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


}

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ksyp='0038' ".
" WHERE ksyp = '' OR ksyp = '0000' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if( $copern == 1 AND $wedgb == 1 AND $exekucie == 0 ) 
{
$podmexe=" AND dm != 938 AND dm != 939 ";
}
if( $copern == 1 AND $wedgb == 1 AND $exekucie == 1 ) 
{
$sql = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE oc >= 0 ";
$vysledek = mysql_query("$sql");

$podmexe=" AND ( dm = 938 OR dm = 939 ) ";
}

//zober data z trvalych
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT kc,oc,$cislo_dok,".
" uceb,numb,vsy,ksy,ssy,".
" 0,0,'',trx4,trx3,5".
" FROM F$kli_vxcf"."_mzdzaltrn".
" WHERE ume = $kli_vume AND uceb != '' AND numb != '0000' AND kc > 0 $podmexe ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdprcvypl$kli_uzid ADD wmm DECIMAL(10,0) AFTER konx";
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET wmm=wms ".
" WHERE F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc = F$kli_vxcf"."_mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if( $alchem == 1 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid SET twib='mzdy' WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");
    }


$wyplmiesto = 1*$_REQUEST['wyplmiesto'];
if( $wyplmiesto > 0 AND $merkfood == 0 )
  {
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE wmm != $wyplmiesto ";
$dsql = mysql_query("$dsqlt");
  }
//merkfood
if( $wyplmiesto > 0 AND $merkfood == 1 AND $fir_fico == 22706852 )
  {
if( $wyplmiesto == 1 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE wmm >= 11 AND wmm <= 31 "; }
if( $wyplmiesto == 2 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE wmm < 11 OR wmm > 20 "; }
if( $wyplmiesto == 3 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE wmm < 21 OR wmm > 31 "; }
$dsql = mysql_query("$dsqlt");
  }
//eurodiskont
if( $wyplmiesto > 0 AND $merkfood == 1 AND $fir_fico == 45232903 )
  {
if( $wyplmiesto == 1 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE wmm > 120 "; }
if( $wyplmiesto == 2 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE wmm < 121 OR wmm > 159 "; }
if( $wyplmiesto == 3 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE wmm < 160 "; }
$dsql = mysql_query("$dsqlt");
  }

$sql = "ALTER TABLE F$kli_vxcf"."_mzdprcvypl$kli_uzid DROP wmm ";
$vysledek = mysql_query("$sql");

     }
//koniec zamestnancov

//odvody a dan z prijmu
if( $copern == 2 )
     {
//zober data zo sum socialna poistovna dm=1
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT (ozam_np+ozam_sp+ozam_ip+ozam_pn+ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf),oc,$cislo_dok,".
" '','',0,'','',".
" 1,0,'SP','','',5".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data zo sum dan z prijmu dm=3
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT (odan_dnp),oc,$cislo_dok,".
" '','',0,'','',".
" 3,0,'Dan z prijmu','','',5".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND odan_dnp > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z vy dan z prijmu odrataj 902,903,952,953 bonus,rz,zp
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT kc,oc,$cislo_dok,".
" '','',0,'','',".
" 3,0,'Dan z prijmu','','',5".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND ( dm = 902 OR dm = 903 OR dm = 952 OR dm = 953 ) ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data zo sum dan zrazkova dm=4
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT (odan_zrz),oc,$cislo_dok,".
" '','',0,'','',".
" 4,0,'','','',5".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND odan_zrz > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data zo sum ZP dm=2
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT (ozam_zp+ofir_zp),oc,$cislo_dok,".
" '','',0,'','',".
" 2,0,'','','',5".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume = $kli_vume AND ( ozam_zp > 0 OR ofir_zp > 0 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln banku z mzdprm pre SP
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprm".
" SET ucep=uces, nump=nums, vsyp=vsys, ksyp=ksys, ssyp=ssys".
" WHERE dm=1";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//dopln banku z mzdprm pre DAN
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprm".
" SET ucep=uced, nump=numd, vsyp=vsyd, ksyp=ksyd, ssyp=ssyd".
" WHERE dm=3";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//dopln banku z mzdprm pre DANZRAZKOVU
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprm".
" SET ucep=ucedz, nump=numdz, vsyp=vsydz, ksyp=ksydz, ssyp=ssydz".
" WHERE dm=4";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//od 1.1.2012 ucty pre dan v ufirdalsie
if( $kli_vume == 12.2011 OR $kli_vrok > 2011 )
{
$kli_vmesx=1*$kli_vmes;
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$vsydan="1100".$kli_vmesx.$kli_vrok;
$vsydzr="8100".$kli_vmesx.$kli_vrok;
$ucetdan=""; $ucetdzr=""; $numdan=""; $numdzr="";
$sqlpoktt = "SELECT * FROM F$kli_vxcf"."_ufirdalsie";
$sqlpok = mysql_query("$sqlpoktt"); 
  if (@$zaznam=mysql_data_seek($sqlpok,0))
  {
  $riadokpok=mysql_fetch_object($sqlpok);
  $ucetdan = $riadokpok->ucdpzc;
  $ucetdzr = $riadokpok->ucdpzr;
  $numdan = $riadokpok->nmdpzc;
  $numdzr = $riadokpok->nmdpzr;
  $ksydan = $riadokpok->ksdpzc;
  $ksydzr = $riadokpok->ksdpzr;
  $ssydan = $riadokpok->ssdpzc;
  $ssydzr = $riadokpok->ssdpzr;

  $ibandan = $riadokpok->ibdpzc;
  $ibandzr = $riadokpok->ibdpzr;

  $bicdan = $riadokpok->bicdpzc;
  $bicdzr = $riadokpok->bicdpzr;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprm".
" SET ucep='$ucetdan', nump='$numdan', vsyp='$vsydan', ksyp='$ksydan', ssyp='$ssydan', ibanp='$ibandan', pbicp='$bicdan' ".
" WHERE dm=3";
//echo $sqtoz;
//exit;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprm".
" SET ucep='$ucetdzr', nump='$numdzr', vsyp='$vsydzr', ksyp='$ksydzr', ssyp='$ssydzr', ibanp='$ibandzr', pbicp='$bicdzr'   ".
" WHERE dm=4";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
}


//ucty pre sp
if( $kli_vrok >= 2014 )
   {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
$ucsp=$riadok->ucsp;
$nmsp=$riadok->nmsp;
$kssp=$riadok->kssp;
$sssp=$riadok->sssp;
$vssp=$riadok->vssp;
$ibsp=$riadok->ibsp;
$bicsp=$riadok->bicsp;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid ".
" SET ucep='$ucsp', nump='$nmsp', vsyp='$vssp', ksyp='$kssp', ssyp='$sssp', ibanp='$ibsp', pbicp='$bicsp' ".
" WHERE dm=1";
$oznac = mysql_query("$sqtoz");

   }

//dopln zdrv z kun
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdkun".
" SET trncpl=zdrv".
" WHERE dm=2 AND F$kli_vxcf"."_mzdprcvypl$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$kli_vumex=$kli_vmes;
if( $kli_vmes < 10 ) $kli_vumex="0".$kli_vmes;
$ssyq=$kli_vrok.$kli_vumex;

//dopln banku z zdravpois pre ZP
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_zdravpois".
" SET ucep=uceb, nump=numb, vsyp=vsy, ksyp=ksy, ssyp=ssy, twib=CONCAT('ZP ', nzdr), ibanp=iban, pbicp=pt3 ".
" WHERE dm=2 AND F$kli_vxcf"."_mzdprcvypl$kli_uzid.trncpl=F$kli_vxcf"."_zdravpois.zdrv AND ".
" F$kli_vxcf"."_mzdprcvypl$kli_uzid.trncpl >= 2400 AND F$kli_vxcf"."_mzdprcvypl$kli_uzid.trncpl <= 2499  ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_zdravpois".
" SET ucep=uceb, nump=numb, vsyp=vsy, ksyp=ksy, ssyp=$ssyq, twib=CONCAT('ZP ', nzdr), ibanp=iban, pbicp=pt3 ".
" WHERE dm=2 AND F$kli_vxcf"."_mzdprcvypl$kli_uzid.trncpl=F$kli_vxcf"."_zdravpois.zdrv AND ".
" ( F$kli_vxcf"."_mzdprcvypl$kli_uzid.trncpl < 2400 OR F$kli_vxcf"."_mzdprcvypl$kli_uzid.trncpl > 2499 )";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;
     }
//koniec odvodov a dane z prijmu


//odvody DDP
if( $copern == 3 )
     {
//zober data zo sum DDP dm=1
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT (ozam_ddp+ofir_ddp),oc,$cislo_dok,".
" '','',0,'','',".
" 1,xddp,'','','',5".
" FROM F$kli_vxcf"."_mzdprcddp".$kli_uzid." ".
" WHERE ( ozam_ddp != 0 OR ofir_ddp != 0 ) AND F$kli_vxcf"."_mzdprcddp".$kli_uzid.".konx = 9 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//dopln banku z mzdcisddp
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdcisddp".
" SET ucep=uceb, nump=numb, vsyp=vsy, ksyp=ksy, ssyp=ssy, twib=nddp, ibanp=iban, pbicp=pt3 ".
" WHERE dm=1 AND F$kli_vxcf"."_mzdprcvypl$kli_uzid.trncpl=F$kli_vxcf"."_mzdcisddp.cddp";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid." WHERE dm = 1 AND ( nump = '0' OR nump = '' ) ";
$dsql = mysql_query("$dsqlt");

     }
//koniec odvodov DDP

//odvody Odbory
if( $copern == 4 )
     {
//zober data zo sum DDP dm=8
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT kc,oc,$cislo_dok,".
" '','',0,'','',".
" 8,0,'odb','','',5".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND dm = 920 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln banku z mzdprm pre SP
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid,F$kli_vxcf"."_mzdprm".
" SET ucep=uceo, nump=numo, vsyp=vsyo, ksyp=ksyo, ssyp=ssyo".
" WHERE dm=8";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if( $kli_vrok >= 2014 )
   {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
$ucod=$riadok->ucod;
$nmod=$riadok->nmod;
$ksod=$riadok->ksod;
$ssod=$riadok->ssod;
$vsod=$riadok->vsod;
$ibod=$riadok->ibod;
$bicod=$riadok->bicod;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid ".
" SET ucep='$ucod', nump='$nmod', vsyp='$vsod', ksyp='$ksod', ssyp='$ssod', ibanp='$ibod', pbicp='$bicod' ".
" WHERE dm=8";
$oznac = mysql_query("$sqtoz");

   }


     }
//koniec odvodov Odbory

//ak vsyp = 0 daj 1.2009
$vsyp=$kli_vume*10000;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET vsyp=$vsyp".
" WHERE vsyp = 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//ak ssyp = 0 daj 1.2009
$ssyp=$kli_vume*10000;
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ssyp=$ssyp".
" WHERE ssyp = 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//ddp tatry sympatia ssy=201304 a nie 042013
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcvypl$kli_uzid".
" SET ssyp=$kli_vrok*100+$kli_vmes ".
" WHERE dm = 1 AND twib LIKE '%TATRY%' ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" SELECT sum(sum_ban),0,$cislo_dok,".
" ucep,nump,vsyp,ksyp,ssyp,".
" 0,0,twib,ibanp,pbicp,0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY ucep,nump,vsyp,ksyp,ssyp";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE konx > 0".
" ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

if( $drupoh == 1 AND $agrostav == 1 AND $kli_vrok < 2010 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE nump = '0900' ";
$dsql = mysql_query("$dsqlt");
}
if( $drupoh == 2 AND $agrostav == 1 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid WHERE nump != '0900' ";
$dsql = mysql_query("$dsqlt");
}

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcvyplx".$kli_uzid.
" SELECT sum(sum_ban),0,$cislo_dok,".
" '','',0,'','',".
" 0,0,'','','',0".
" FROM F$kli_vxcf"."_mzdprcvypl".$kli_uzid.
" WHERE oc >= 0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//uloz do prikazov


$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcvypl$kli_uzid"." WHERE oc >= 0 ORDER BY ucep,sum_ban");
$cpol = mysql_num_rows($sql);
$i=0;

while ($i <= $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
  $riadok=mysql_fetch_object($sql);

$sqty = "INSERT INTO F$kli_vxcf"."_uctprikp ( dok,uceb,numb,hodp,hodm,vsy,ksy,ssy,id,uce,ico,iban,pbic,twib )".
" VALUES ('$cislo_dok', '$riadok->ucep', '$riadok->nump', '$riadok->sum_ban', '$riadok->sum_ban', '$riadok->vsyp', '$riadok->ksyp', '$riadok->ssyp',".
" '$kli_uzid', '$hladaj_uce', '0', '$riadok->ibanp', '$riadok->pbicp', '$riadok->twib' );"; 
$ulozene = mysql_query("$sqty"); 

  }
$i=$i+1;
}



$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprcvyplx".$kli_uzid." WHERE oc >= 0 ORDER BY oc DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_hodp=$riaddok->sum_ban;
  $h_hodm=$riaddok->sum_ban;
  }

$uprt = "UPDATE F$kli_vxcf"."_uctpriku SET hodp=hodp+'$h_hodp', hodm=hodm+'$h_hodm'  WHERE dok='$cislo_dok'";
//echo $uprt;
$upravene = mysql_query("$uprt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

     }
//koniec nacitania miezd

//uhrad mzdy prepni naspat do prikazu
if( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 )
     {

?>
<script type="text/javascript">
window.open('../ucto/vspr_u.php?sysx=UCT&rozuct=NIE&copern=8&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>', '_self' )
</script>
<?php
exit;
     }

//koniec uhrada mzdy
?>

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
