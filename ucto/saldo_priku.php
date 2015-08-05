<HTML>
<?php
//prikaz na uhradu cinnost=7
$sys = 'UCT';
$urov = 1000;
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

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$uhrvseob = 1*$_REQUEST['uhrvseob'];
$vsetko=1;


if( $copern == 11 ) { $copern=10; $vsetko=0; }
$drupoh = 1*$_REQUEST['drupoh'];
$cinnost = 1*$_REQUEST['cinnost'];
$dobropis = 1*$_REQUEST['dobropis'];
$h_uce = $_REQUEST['h_uce'];
$h_obd = $_REQUEST['h_obd'];
$h_ico = 1*$_REQUEST['h_ico'];
$cislo_fak = 1*$_REQUEST['cislo_fak'];
$cislo_strana = 1*$_REQUEST['cislo_strana'];
if( $cislo_strana == 0 ) $cislo_strana=1;
$cislo_strank=$cislo_strana+2;
$cislo_stranp=$cislo_strana-3;
if( $cislo_stranp <= 0 ) $cislo_stranp=1;
$cislo_strand=$cislo_strana+3;
$cislo_ico = 1*$_REQUEST['cislo_ico'];

$cislo_stran1=$cislo_strank-2;
if( $cislo_stran1 <= 0 ) $cislo_stran1=1;
$cislo_stran2=$cislo_strank-1;
if( $cislo_stran2 <= 0 ) $cislo_stran2=1;
$cislo_stran3=$cislo_strank;
if( $cislo_stran3 <= 0 ) $cislo_stran3=1;

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$h_datp = $_REQUEST['h_datp'];
$h_datpsql = SqlDatum($_REQUEST['h_datp']);
//echo $h_datpsql;

//tabulka na ulozenie proti a vseob
if( $cinnost == 7 )
{
$sql = "SELECT * FROM F$kli_vxcf"."_uctprikvseob".$kli_uzid;
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<STR
(
   proti       VARCHAR(10),
   vseob       VARCHAR(10),
   prmx1       INT,
   prmt1       VARCHAR(10)
);
STR;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctprikvseob'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctprikvseob".$kli_uzid." ( proti,vseob,prmx1,prmt1 ) VALUES ( '39500', '2001', '0', 'text' )";
$ttqq = mysql_query("$ttvv");
}

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctprikvseob".$kli_uzid);
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $proti=$riaddok->proti;
  $vseob=$riaddok->vseob;
  }
}
//koniec tabulky na ulozenie proti a vseob

//zapis kliknutu fakturu do vseob
if( $copern == 1111 )
{
$proti = 1*$_REQUEST['proti'];
$vseob = 1*$_REQUEST['vseob'];
$h_icox = 1*$_REQUEST['h_icox'];
$h_fak = 1*$_REQUEST['h_fak'];
$h_zos = 1*$_REQUEST['h_zos'];
$h_ksy = $_REQUEST['h_ksy'];
$h_ssy = $_REQUEST['h_ssy'];
$h_uceb = $_REQUEST['h_uceb'];
$h_numb = $_REQUEST['h_numb'];

$h_ibanb = $_REQUEST['h_ibanb'];
$h_bicb = $_REQUEST['h_bicb'];

//echo "proti ".$proti." vseob ".$vseob;
//echo "strana".$cislo_strana;
//echo "strank".$cislo_strank;
//exit;

$nasiel=1;
$xdruh=6;
$cuce=1*substr($h_uce,0,3);
if( $cuce >= 321 ) $xdruh=6;

if( $nasiel == 1 )
  {

$twibxx="";
if( $alchem == 1 AND $cinnost == 7 )
     {
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $h_icox ORDER BY ico LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $twibxx=$riaddok->nai;
  }
$twibxx = StrTr($twibxx, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é","aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$twibxx=strtoupper($twibxx);
     }


//preuctuj dobropis na cielovu fakturu


    if( $xdruh == 6 )
      {
//echo "robim dobropis";
//" ( dok,cpl,uceb,numb,iban,twib,vsy,ksy,ssy,hodp,hodm,uce,ico,id ) ";

$ttvv = "INSERT INTO F$kli_vxcf"."_uctprikp ".
" ( dok,cpl,uceb,numb,twib,vsy,ksy,ssy,hodp,hodm,uce,ico,id,iban,pbic ) ".
" VALUES ( '$vseob', '0', '$h_uceb', '$h_numb',  '$twibxx', '$h_fak', '$h_ksy', '$h_ssy', '$h_zos', '$h_zos', ".
" '$h_uce',  '$h_icox', '$kli_uzid', '$h_ibanb', '$h_bicb'  )";;
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

$dobropis=1;

$ttvv = "UPDATE F$kli_vxcf"."_uctprikvseob".$kli_uzid." SET proti='$proti', vseob='$vseob' ";
$ttqq = mysql_query("$ttvv");
      }

$sumahodp=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprikp WHERE dok=$vseob";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sumahodp=$sumahodp+$hlavicka->hodp;
}

$i=$i+1;
  }

$ttvv = "UPDATE F$kli_vxcf"."_uctpriku SET hodp=$sumahodp, hodm=hodp WHERE dok=$vseob";
$ttqq = mysql_query("$ttvv");

  }

$copern=10; 
$vsetko=0;
}
//koniec zapisu kliknutej faktury do vseob

//zmazanie faktury zo zoznamu
if( $copern == 316 )
{

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE fak = $cislo_fak AND ico = $cislo_ico AND  pox = 1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE ico = $cislo_ico AND pox = 999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 AND ico = $cislo_ico ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

}

//zmazanie polozky z dokladu
if( $copern == 416 )
{
$h_cpl = 1*$_REQUEST['h_cpl'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctprikp WHERE cpl = $h_cpl ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sumahodp=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprikp WHERE dok=$vseob";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sumahodp=$sumahodp+$hlavicka->hodp;
}

$i=$i+1;
  }

$ttvv = "UPDATE F$kli_vxcf"."_uctpriku SET hodp=$sumahodp, hodm=hodp WHERE dok=$vseob";
$ttqq = mysql_query("$ttvv");


$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

//uprava hodnoty polozky z dokladu
if( $copern == 618 )
{
$h_cpl = 1*$_REQUEST['h_cpl'];
$n_hod = 1*$_REQUEST['n_hod'];

$dsqlt = "UPDATE F$kli_vxcf"."_uctprikp SET hodp=$n_hod, hodm=$n_hod WHERE cpl = $h_cpl AND dok = $vseob ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sumahodp=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprikp WHERE dok=$vseob";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$sumahodp=$sumahodp+$hlavicka->hodp;
}

$i=$i+1;
  }

$ttvv = "UPDATE F$kli_vxcf"."_uctpriku SET hodp=$sumahodp, hodm=hodp WHERE dok=$vseob";
$ttqq = mysql_query("$ttvv");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

//uprava ksy polozky z dokladu
if( $copern == 718 )
{
$h_cpl = 1*$_REQUEST['h_cpl'];
$n_ksy = $_REQUEST['n_ksy'];
//echo "KSY".$n_ksy;
$Cislo=$n_ksy+"";
$n_ksy=sprintf("%04d", $Cislo);
//echo "KSY".$n_ksy;

$dsqlt = "UPDATE F$kli_vxcf"."_uctprikp SET ksy='$n_ksy' WHERE cpl = $h_cpl AND dok = $vseob ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

//uprava ssy polozky z dokladu
if( $copern == 818 )
{
$h_cpl = 1*$_REQUEST['h_cpl'];
$n_ssy = $_REQUEST['n_ssy'];
//$Cislo=$n_ssy+"";
//$n_ssy=sprintf("%07d", $Cislo);
//echo "SSY".$n_ssy;

$dsqlt = "UPDATE F$kli_vxcf"."_uctprikp SET ssy='$n_ssy' WHERE cpl = $h_cpl AND dok = $vseob ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

//nastav vseobecny doklad
if( $copern == 418 )
{
$h_vseob = 1*$_REQUEST['h_vseob'];
$h_proti = 1*$_REQUEST['h_proti'];

$ttvv = "UPDATE F$kli_vxcf"."_uctprikvseob".$kli_uzid." SET proti='$h_proti', vseob='$h_vseob' ";
$ttqq = mysql_query("$ttvv");

$vseob=$h_vseob;
$proti=$h_proti;

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}


//uprav hodnotu na rozdiel=0
if( $copern == 411 )
{
$h_cpl = 1*$_REQUEST['h_cpl'];
$rozdiel = 1*$_REQUEST['rozdiel'];

$dsqlt = "UPDATE F$kli_vxcf"."_uctprikp SET hod=hod-($rozdiel) WHERE dok = $vseob AND cpl = $h_cpl AND LEFT(ucd,3) = 311 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctprikp SET hod=hod+($rozdiel) WHERE dok = $vseob AND cpl = $h_cpl AND LEFT(ucm,3) = 321 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

if( $uhrvseob > 0 ) $vseob=$uhrvseob;

/////////////////////////////////////////////////////////////// LEN AK NIEJE copern316
if( $copern != 316 )
          {

if (File_Exists ("../tmp/saldo.$kli_uzid.pdf")) { $soubor = unlink("../tmp/saldo.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if( $h_ico > 0 AND $copern != 14 ) $pdf=new FPDF("P","mm","A4");
if( $h_ico == 0 OR $copern == 14 ) $pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


////////////////////////////////////////////////////////datum pociatku a konca salda

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

$h_obdcel=$h_obd.".".$kli_vrok;
$pole = explode(".", $h_obdcel);
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

//exit;

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

////////////////////////////////////////////////////////koniec datum pociatku a konca salda


////////////////////////////////////////////////////////////nastavenia co brat vsetky/nesparovane , obdobie

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prsaldo
(
   pox1        INT,
   pox2        INT,
   pox         INT,
   drupoh      INT,
   uce         VARCHAR(10),
   puc         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   ico         INT(10),
   fak         DECIMAL(10,0),
   poz         VARCHAR(80),
   ksy         VARCHAR(10),
   ssy         VARCHAR(10),
   hdp         DECIMAL(10,2),
   hdu         DECIMAL(10,2),
   hod         DECIMAL(10,2),
   uhr         DECIMAL(10,2),
   zos         DECIMAL(10,2),
   dau         DATE
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

if( $copern == 12 ) { $h_obd=0; $vsetko=1; $drupoh=2; }

if( $copern == 14 ) { $h_obd=0; $vsetko=1; $drupoh=4; }

if ( $h_obd == 0 ) { $datpod = ""; }
if ( $h_obd == 100 ) { $datpod = "AND ( drupoh = 7 OR drupoh = 8 )"; }
if ( $h_obd > 0 AND $h_obd < 13 ) { $datpod = "AND dat <= '".$datk_dph."'"; }

//ak vsetky obdobia zober priamo zo prsaldoicofak
if ( $h_obd == 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" WHERE uce > 0 ".
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");
                   }

//ak vybrane obdobia vyrob nove prsaldoicofak
if ( $h_obd != 0 ) { 


$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" SELECT drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce > 0 ".$datpod." ".
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");


                   }
//koniec vyrobenia noveho saldoicofak podla obdobia


//zober vsetky
if ( $drupoh == 1 AND $vsetko == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE uce != 0 ".$datpod.
" GROUP BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec zober vsetky

//uprava ak len nesparovane vsetko=0
if ( $drupoh == 1 AND $vsetko == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid".
" WHERE zos != 0 ".$datpod.
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec uprava ak len nesparovane vsetko=0

//exit;

//uprava ak za vsetky ico daj sucty
if ( $drupoh == 1 AND $h_ico == 0  )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec uprava ak za vsetky ICO daj sucty vsetko=0



//ak prikaz na uhradu cinnost=7 zober aj nerozuctovane
//echo "cin".$cinnost;
if ( $cinnost == 7 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,6,uce,0,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,0,0,hod,0,hod,'0000-00-00'".
" FROM F$kli_vxcf"."_fakdod ".
" WHERE F$kli_vxcf"."_fakdod.hod > 0 AND F$kli_vxcf"."_fakdod.hodu = 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
//koniec ak prikaz na uhradu

//exit;

////////////////////////////////////////////////////////////koniec nastavenia co brat


////////////////////////////////////////////////////////////kolko po splatnosti

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqtoz = "UPDATE F$kli_vxcf"."_$uctpol SET puc=TO_DAYS('$dnes')-TO_DAYS(das) WHERE hod != 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_$uctpol SET puc=0 WHERE puc < 0 ";
$oznac = mysql_query("$sqtoz");

//echo $datk_dph;
//exit;

$nulovazostava=1;

$sqtoz = "DELETE FROM F$kli_vxcf"."_$uctpol WHERE das > '$h_datpsql' ";
//echo $sqtoz;
if( $h_datpsql != '0000-00-00' ) { $oznac = mysql_query("$sqtoz"); }


/////////////////////////////////////////////////////////////DAJ PREC, KTORE SU NA PRIKU 60dni dozadu a neuhradene napocitaj do uhrad
if( $poliklinikase == 1 OR $slovakiaplay == 1 )
{
//echo "tu som";
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldopriku'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prsaldo
(
   pox1        INT,
   pox2        INT,
   pox         INT,
   dat         DATE,
   das         DATE,
   dnx         DECIMAL(10,0),
   dok         DECIMAL(10,0),
   ico         INT(10),
   fak         DECIMAL(10,0),
   hop         DECIMAL(10,2)
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldopriku'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldopriku$kli_uzid".
" SELECT 0,0,1,datm,'$dnes',0,dok,ico,vsy,hodp ".
" FROM F$kli_vxcf"."_uctprikp ".
" WHERE dok > 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldopriku$kli_uzid SET dnx=TO_DAYS(das)-TO_DAYS(dat)";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prsaldopriku$kli_uzid WHERE dnx > 60 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldopriku$kli_uzid,F$kli_vxcf"."_uctban ".
" SET pox1=99 ".
" WHERE F$kli_vxcf"."_prsaldopriku$kli_uzid.ico=F$kli_vxcf"."_uctban.ico ".
" AND F$kli_vxcf"."_prsaldopriku$kli_uzid.fak=F$kli_vxcf"."_uctban.fak ".
" AND F$kli_vxcf"."_prsaldopriku$kli_uzid.hop=F$kli_vxcf"."_uctban.hod AND LEFT(ucm,3) = 321 ".
"";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prsaldopriku$kli_uzid WHERE pox1 > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldopriku$kli_uzid,F$kli_vxcf"."_uctpokuct ".
" SET pox1=98 ".
" WHERE F$kli_vxcf"."_prsaldopriku$kli_uzid.ico=F$kli_vxcf"."_uctpokuct.ico ".
" AND F$kli_vxcf"."_prsaldopriku$kli_uzid.fak=F$kli_vxcf"."_uctpokuct.fak ".
" AND F$kli_vxcf"."_prsaldopriku$kli_uzid.hop=F$kli_vxcf"."_uctpokuct.hod AND LEFT(ucm,3) = 321 ".
"";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prsaldopriku$kli_uzid WHERE pox1 > 0 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldopriku$kli_uzid".
" SELECT 0,0,2,dat,das,dnx,dok,ico,fak,hop ".
" FROM F$kli_vxcf"."_prsaldopriku$kli_uzid ".
" WHERE dok > 0 GROUP BY ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prsaldopriku$kli_uzid WHERE pox != 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_$uctpol,F$kli_vxcf"."_prsaldopriku$kli_uzid ".
" SET uhr=uhr+hop, zos=zos-hop ".
" WHERE F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_prsaldopriku$kli_uzid.ico ".
" AND F$kli_vxcf"."_$uctpol.fak=F$kli_vxcf"."_prsaldopriku$kli_uzid.fak AND F$kli_vxcf"."_$uctpol.pox = 1";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_$uctpol WHERE zos <= 0 OR pox = 999";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");
}

/////////////////////////////////////////////////////////////// LEN AK NIEJE copern316
          }

if( $copern == 316 ) 
{ 


$copern=10; $drupoh=1; $vsetko=0;
}

?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>PrÌkaz na ˙hradu</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

 div.strana {
  padding-left:8;
  font-weight:bold;
  background-color:#ffff90;
  cursor:pointer;
}

 div.nekliknute {
  padding-left:8;
  font-weight:normal;
  background-color:#ffff90;
  cursor:pointer;
}

 div.kliknute {
  padding-left:8;
  font-weight:bold;
  background-color:lightgreen;
  cursor:pointer;
}

  </style>


<script type="text/javascript">


function ZmazVzp(ico,fak,strana)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=316&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
                }

function VzpFak(ico,fak,strana,zos,ksy,ssy,uceb,numb)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_icox=' + ico + '&h_fak=' + fak + '&h_zos=' + zos + 
'&h_ksy=' + ksy + '&h_ssy=' + ssy +'&h_uceb=' + uceb + '&h_numb=' + numb +
 '&h_obd=<?php echo $h_obd;?>&cislo_strana=' + strana + '&proti=' + proti + '&vseob=' + vseob + '&copern=1111&drupoh=1&page=1&cinnost=7', '_self' );

                }

function VzpFakIban(ico,fak,strana,zos,ksy,ssy,uceb,numb,iban,bic)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_icox=' + ico + '&h_fak=' + fak + '&h_zos=' + zos + 
'&h_ksy=' + ksy + '&h_ssy=' + ssy +'&h_uceb=' + uceb + '&h_numb=' + numb + '&h_ibanb=' + iban + '&h_bicb=' + bic +
 '&h_obd=<?php echo $h_obd;?>&cislo_strana=' + strana + '&proti=' + proti + '&vseob=' + vseob + '&copern=1111&drupoh=1&page=1&cinnost=7&ajiban=1', '_self' );

                }

function VzpIco(ico,fak,strana,zos)
                {

                }

function UpravPol(ico,fak,strana,cpl)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var rozdiel = document.forms.formd2.rozdiel.value;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=411&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
  '&rozdiel=' + rozdiel + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>
&h_cpl=' + cpl + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
                }

function ZmazPol(ico,fak,strana,cpl)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=416&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
 '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_cpl=' + cpl + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
                }

function NastavVseob(ico,fak,strana,vseob)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=418&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
 '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

                }

function TlacVzp(ico,vseob)
                {

window.open('vspr_pdf.php?copern=20&drupoh=1&cislo_dok=' + vseob + '&page=1',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );

                }

function TlacVseo(vseob)
                {

window.open('vspr_zoznam.php?copern=20&drupoh=1&cislo_dok=' + vseob + '&page=1',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }



function NastavZaciatok()
                {
                }

function UpravHod(cpl,suma)
                {

var uhr_cpl = cpl;
var uhr_sum = suma;

var dajid = "ZP" + uhr_cpl; 

  myUhrad = document.getElementById( dajid );
  var htmluhr = " ";

  htmluhr += " <table><tr><FORM name='fhodnew' class='obyc' method='post' action='#' ><td>";

  htmluhr += " <input class='hvstup' type='text' name='n_hod' id='n_hod' size='10' onkeyup='CiarkaNaBodku(this)' value='" + uhr_sum + "' /> ";

  htmluhr += " <img border=0 src='../obr/ok.png' style='width:12; height:15;' ";
  htmluhr += " title='Uloûiù upraven˙ hodnotu' ";
  htmluhr += " onClick=\"UlozHod(" + uhr_cpl + "," + uhr_sum + ");\"></td></FORM></tr></table>";

  myUhrad.innerHTML = htmluhr;
  myUhrad.className='kliknute';

  document.forms.fhodnew.n_hod.focus();
  document.forms.fhodnew.n_hod.select();
                }

function UlozHod(cpl,suma)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;
var n_hod = document.forms.fhodnew.n_hod.value;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=618&h_cpl=' + cpl + '&n_hod=' + n_hod + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

                }

function UpravKsy(cpl,ksy)
                {

var uhr_cpl = cpl;
var uhr_ksy = ksy;

var dajid = "KS" + uhr_cpl; 

  myUhrac = document.getElementById( dajid );
  var htmluhc = " ";

  htmluhc += " <table><tr><FORM name='fksynew' class='obyc' method='post' action='#' ><td>";

  htmluhc += " <input class='hvstup' type='text' name='n_ksy' id='n_ksy' size='4' maxlenght='4' onkeyup='CiarkaNaBodku(this)' value='" + uhr_ksy + "' /> ";

  htmluhc += " <img border=0 src='../obr/ok.png' style='width:12; height:15;' ";
  htmluhc += " title='Uloûiù upraven˝ KSY' ";
  htmluhc += " onClick=\"UlozKsy(" + uhr_cpl + ",'" + uhr_ksy + "');\"></td></FORM></tr></table>";

  myUhrac.innerHTML = htmluhc;
  myUhrac.className='kliknute';

  document.forms.fksynew.n_ksy.focus();
  document.forms.fksynew.n_ksy.select();
                }

function UlozKsy(cpl,ksy)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;
var n_ksy = document.forms.fksynew.n_ksy.value;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=718&h_cpl=' + cpl + '&n_ksy=' + n_ksy + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

                }

function UpravSsy(cpl,ssy)
                {

var uhr_cpl = cpl;
var uhr_ssy = ssy;

var dajid = "SS" + uhr_cpl; 

  myUhrae = document.getElementById( dajid );
  var htmluhe = " ";

  htmluhe += " <table><tr><FORM name='fssynew' class='obyc' method='post' action='#' ><td>";

  htmluhe += " <input class='hvstup' type='text' name='n_ssy' id='n_ssy' size='8' maxlenght='4' onkeyup='CiarkaNaBodku(this)' value='" + uhr_ssy + "' /> ";

  htmluhe += " <img border=0 src='../obr/ok.png' style='width:12; height:15;' ";
  htmluhe += " title='Uloûiù upraven˝ SSY' ";
  htmluhe += " onClick=\"UlozSsy(" + uhr_cpl + ",'" + uhr_ssy + "');\"></td></FORM></tr></table>";

  myUhrae.innerHTML = htmluhe;
  myUhrae.className='kliknute';

  document.forms.fssynew.n_ssy.focus();
  document.forms.fssynew.n_ssy.select();
                }

function UlozSsy(cpl,ssy)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;
var n_ssy = document.forms.fssynew.n_ssy.value;

window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=818&h_cpl=' + cpl + '&n_ssy=' + n_ssy + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

                }

    function CiarkaNaBodku(Vstup)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
    }
    
</script>
</HEAD>
<BODY class="white" onload="NastavZaciatok();" >

<div id="textvzpp" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>
<div id="textvzpz" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>
<div id="textpenp" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>
<div id="textpenz" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  PrÌkaz na ˙hradu</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



<?php

///////////////////////////////////////////////////////////////////////////////pre jedno a vsetky ICO
if ( $copern == 10 AND $drupoh == 1 AND $h_ico >= 0 )
{

$strana=1;
//zaciatok vypisu tovaru

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE uce = $h_uce ".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok";

if ( $h_ico > 0 )
{
$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$uctpol.ico = $h_ico AND uce = $h_uce ".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok";

}

//echo $tovtt;
//exit;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol >= 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;


//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
  while ($i <= $tvpol )
  {

//echo "st ".$strana."cst ".$cislo_strana;
//echo "strana".$cislo_strana;
//echo "strank".$cislo_strank;

//echo "vsetko ".$vsetko;
//echo "cinnost ".$cinnost;
//echo "strana ".$strana;
//echo "cop ".$copern;
//echo " poh".$drupoh;
//echo " ico".$h_ico;
//echo "cislo_strana ".$cislo_strana;
//echo "cislo_strank ".$cislo_strank;

if ( $j == 0 AND $strana >= $cislo_strana AND $strana <= $cislo_strank )
      {

$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="PoËiatoËn˝ stav";


if( $vsetko >= 0 ) { 
?>
<?php if( $cinnost == 7 AND $strana == $cislo_strana ) { ?>

<?php
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctprikp ".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_uctprikp.ico=F$kli_vxcf"."_ico.ico".
" WHERE dok = $vseob ORDER BY cpl";
//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

$ip=0;
$suma311=0;
$suma321=0;
$rozdiel=0;
  while ($ip <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$ip))
{
$rsluz=mysql_fetch_object($sluz);

$suma321=$suma321+$rsluz->hodp; $rozdiel=$rozdiel+$rsluz->hodp; 

$Cislo=$rozdiel+"";
$rozdiel=sprintf("%0.2f", $Cislo);
if( $rozdiel < 0.01 AND $rozdiel > -0.01 ) $rozdiel="0.00";

?>
<?php if( $ip == 0 ) { ?>
<table  class='fmenu' width='100%'>
<tr>
<td width='4%' align='right'>Doklad</td>
<td width='17%' align='right'>iban bic</td>
<td width='10%' align='right'>˙Ëet</td>
<td width='4%' align='right'>num</td>
<td width='8%' align='right'>vsy</td>
<td width='7%' align='right'>ksy</td>
<td width='7%' align='right'>ssy</td>
<td width='18%' align='left'>I»O</td>
<td width='10%' align='right'>Hodnota</td>
<td width='5%' align='right'> </td>
<td width='10%' align='right'>
<img src='../obr/zoznam.png' width=15 height=12 border=1 
 onClick="TlacVseo(<?php echo $vseob; ?>);" 
 title='TlaËiù zoznam fakt˙r na ˙hradu' >

<a href='vspr_u.php?hladaj_uce=<?php echo $hladaj_uce; ?>&rozuct=NIE&copern=8&drupoh=1&page=<?php echo $page;?>&h_tlsl=1&rozb1=NOT&rozb2=NOT
&cislo_dok=<?php echo $vseob;?>&h_uce=<?php echo $hladaj_uce;?>'>
<img src='../obr/uprav.png' width=15 height=12 border=1 title="⁄prava prÌkazu na ˙hradu a export" ></a>

<img src='../obr/tlac.png' width=15 height=12 border=1 
 onClick="TlacVzp(<?php echo $rsluz->ico; ?>,<?php echo $vseob; ?>);" 
 title='TlaËiù prÌkaz na ˙hradu' >
</td>
</tr>
<?php                } ?>
<tr>
<?php $xckmpx=$ip+1; ?>
<FORM name="formsx<?php echo $xckmpx; ?>" class="obyc" method="post" action="#" >
<td align='right' class="fmenu" ><?php echo $rsluz->dok; ?></td>
<td align='right' class="fmenu" ><?php echo $rsluz->iban; ?> <?php echo $rsluz->pbic; ?></td>
<td align='right' class="fmenu" ><?php echo $rsluz->uceb; ?></td>
<td align='right' class="fmenu" ><?php echo $rsluz->numb; ?></td>
<td align='right' class="fmenu" ><?php echo $rsluz->vsy; ?></td>
<td align='right' class="fmenu" >

<div id="SPK<?php echo $xckmpx; ?>" >
<?php echo $rsluz->ksy; ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 onClick="SPK<?php echo $xckmpx; ?>.style.display='none'; SPKX<?php echo $xckmpx; ?>.style.display='';"
 title='Upraviù KSY' >
</div>
<div id="SPKX<?php echo $xckmpx; ?>" style="display:none; " >
 <input class='hvstup' type='text' name='n_ksy' id='n_ksy' size='4' value="<?php echo $rsluz->ksy;?>" />
 <img src="../obr/ok.png" onClick="UlozKSYX<?php echo $xckmpx; ?>(<?php echo $rsluz->dok; ?>, <?php echo $rsluz->cpl; ?> );" width=15 height=10 border=1 title="Uloûiù KSY" >
</div>

<!-- toto povodne som zaremoval
<div class='nekliknute' id='KS<?php echo $rsluz->cpl; ?>' >
<?php echo $rsluz->ksy; ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 
 onClick="UpravKsy(<?php echo $rsluz->cpl; ?>,'<?php echo $rsluz->ksy; ?>');" 
 title='Upraviù KSY poloûky' >
</div>
-->
</td>

<td align='right' class="fmenu" >

<div id="SPS<?php echo $xckmpx; ?>" >
<?php echo $rsluz->ssy; ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 onClick="SPS<?php echo $xckmpx; ?>.style.display='none'; SPSX<?php echo $xckmpx; ?>.style.display='';"
 title='Upraviù SSY' >
</div>
<div id="SPSX<?php echo $xckmpx; ?>" style="display:none; " >
 <input class='hvstup' type='text' name='n_ssy' id='n_ssy' size='8' value="<?php echo $rsluz->ssy;?>" />
 <img src="../obr/ok.png" onClick="UlozSSYX<?php echo $xckmpx; ?>(<?php echo $rsluz->dok; ?>, <?php echo $rsluz->cpl; ?> );" width=15 height=10 border=1 title="Uloûiù SSY" >
</div>

<!-- toto povodne som zaremoval
<div class='nekliknute' id='SS<?php echo $rsluz->cpl; ?>' >
<?php echo $rsluz->ssy; ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 
 onClick="UpravSsy(<?php echo $rsluz->cpl; ?>,'<?php echo $rsluz->ssy; ?>');" 
 title='Upraviù SSY poloûky' >
</div>
-->
</td>

<td align='left' class="fmenu" ><?php echo $rsluz->ico; ?> <?php echo $rsluz->nai; ?></td>

<td width='10%' align='right' class="fmenu" >

<div id="SP<?php echo $xckmpx; ?>" >
<?php echo $rsluz->hodp; ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 onClick="SP<?php echo $xckmpx; ?>.style.display='none'; SPX<?php echo $xckmpx; ?>.style.display='';"
 title='Upraviù hodnotu poloûky' >
</div>
<div id="SPX<?php echo $xckmpx; ?>" style="display:none; " >
 <input class='hvstup' type='text' name='n_mnozs' id='n_mnozs' size='8' value="<?php echo $rsluz->hodp;?>" />
 <img src="../obr/ok.png" onClick="UlozHODX<?php echo $xckmpx; ?>(<?php echo $rsluz->dok; ?>, <?php echo $rsluz->cpl; ?> );" width=15 height=10 border=1 title="Uloûiù hodnotu" >
</div>

<!-- toto povodne som zaremoval
<div class='nekliknute' id='ZP<?php echo $rsluz->cpl; ?>' >
<?php echo $rsluz->hodp; ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 
 onClick="UpravHod(<?php echo $rsluz->cpl; ?>,<?php echo $rsluz->hodp; ?>);" 
 title='Upraviù hodnotu poloûky' >
</div>
-->

</td>
<td width='2%' align='left' class="fmenu" >
 <img src='../obr/zmazuplne.png' width=15 height=12 border=1 
 onClick="ZmazPol(<?php echo $rsluz->ico; ?>,<?php echo $rsluz->vsy; ?>,<?php echo $strana; ?>,<?php echo $rsluz->cpl; ?>);" 
 title='Zmazaù poloûku z prÌkazu na ˙hradu' >
</td>
</FORM>
</tr>
<script type="text/javascript">
function UlozHODX<?php echo $xckmpx; ?>(doklad,cpl)
{

var n_cpl = cpl;
var n_mnozs = document.forms.formsx<?php echo $xckmpx; ?>.n_mnozs.value;
var vseob= doklad;

window.open('saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=618&h_cpl=' + n_cpl + '&n_hod=' + n_mnozs + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
            
}
function UlozSSYX<?php echo $xckmpx; ?>(doklad,cpl)
{

var n_cpl = cpl;
var n_ssy = document.forms.formsx<?php echo $xckmpx; ?>.n_ssy.value;
var vseob= doklad;

window.open('saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=818&h_cpl=' + n_cpl + '&n_ssy=' + n_ssy + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
            
}
function UlozKSYX<?php echo $xckmpx; ?>(doklad,cpl)
{

var n_cpl = cpl;
var n_ksy = document.forms.formsx<?php echo $xckmpx; ?>.n_ksy.value;
var vseob= doklad;

window.open('saldo_priku.php?h_datp=<?php echo $h_datp;?>&copern=718&h_cpl=' + n_cpl + '&n_ksy=' + n_ksy + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
            
}
</script>
<?php
}
$ip = $ip + 1;
  }
?>
<?php if( $rozdiel != 0 OR $suma321 != 0 ) { ?>
<tr>
<td align='left' class="bmenu" > </td>
<td align='left' class="bmenu" > </td>
<td align='right' class="bmenu" colspan="7" >Na ˙hradu = <?php echo $rozdiel; ?></td>
</tr>
<?php                                      } ?>
<?php                                                   } ?>

<table  class='fmenu' width='100%'>

<?php if( $cinnost == 7 AND $strana == $cislo_strana ) { 
$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);
?>
<tr>
<FORM name="formd2" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="4">
 <input type="hidden" name="rozdiel" id="rozdiel" value="<?php echo $rozdiel;?>" />
 <input type="hidden" name="proti" id="proti" value="<?php echo $proti;?>" />
 »Ìslo prÌkazu na ˙hradu: 
 <input type="text" name="vseob" id="vseob" size="10" value="<?php echo $vseob;?>" />
<img src='../obr/vlozit.png' width=15 height=12 border=1 
 onClick="NastavVseob(<?php echo $h_ico; ?>,0,<?php echo $strana; ?>,<?php echo $vseob; ?>);" 
 title='Nastaviù ËÌslo prÌkazu na ˙hradu' >
<td class="hmenu" colspan="2">
<td class="hmenu" colspan="2">
</FORM>
<?php                     } ?>

<tr>
<td colspan='4' align='left'>Saldokonto nesp·rovanÈ strana <?php echo $cislo_strana; ?> aû <?php echo $cislo_strank; ?></td>
<td colspan='1' align='left'>
<a href="#" onClick="window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/next.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_strand; ?>' ></a>
</td>
<td colspan='5' align='right'><?php echo "FIR".$kli_vxcf." ".$kli_nxcf." strana ".$strana; ?></td>
</tr> 
<tr>
<td colspan='2' align='left'>⁄Ëet: <?php echo $h_uce; ?></td>
<td colspan='2' align='left'>Obdobie: <?php echo $h_obdn; ?></td>
</tr> 

<tr>
<td width='30%' align='left'>Firma</td>
<td width='5%' align='left'>UME</td>
<td width='10%' align='left'>Doklad</td>
<td width='7%' >Vystaven·</td>
<td width='7%' >Splatn·</td>
<td width='8%' >poSPL</td>
<td width='9%' align='right' >Fakt˙ra ËÌslo</td>
<td width='8%' align='right' >Hodnota</td>
<td width='8%' align='right' >UhradenÈ</td>
<td width='8%' align='right' >Zostatok</td>
</tr> 



<?php
                   }

      }
//koniec j=0


  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$dat_sk=SkDatum($rtov->dat);
if( $dat_sk == '00.00.0000' ) $dat_sk=SkDatum($rtov->dau);
if( $dat_sk == '00.00.0000' ) $dat_sk="";

$das_sk=SkDatum($rtov->das);
if( $das_sk == '00.00.0000' ) $das_sk="";

$poz=$rtov->poz;
if( $alchem == 1 AND $rtov->poz == '(55)odber. fakt˙ra' ) $poz="";

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

//sumare napocet
if( $rtov->pox == 1 )
           {
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = $uhr + $rtov->uhr;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);
           }

if( $rtov->pox == 1 AND $strana >= $cislo_strana AND $strana <= $cislo_strank )
           {
?>
<tr>
<td class='hvstup' align='left'>
<a href="#" onClick="window.open('../cis/cico.php?copern=88&page=1&cislo_ico=<?php echo $rtov->ico;?>',
 '_blank', 'width=1070, height=900, top=60, left=20, status=yes, resizable=yes, scrollbars=yes' )"><?php echo "I»O: ".$rtov->ico; ?></a>
<?php echo " ".$rtov->nai; ?>
</td>
<td class='hvstup' align='left'><?php echo $rtov->ume; ?></td>
<td class='hvstup' align='left'>
<?php  if ( $rtov->drupoh == 11 )  { ?>
<a href="#" onClick="window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $rtov->uce; ?>
&rozuct=ANO&copern=8&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $rtov->dok; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='⁄prava prÌjmovÈho pokladniËnÈho dokladu'></a>
<a href="#" onClick="window.open('../ucto/vspk_t.php?copern=20&drupoh=1&page=1&sysx=UCT&rozuct=ANO&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

<?php  if ( $rtov->drupoh == 12 )  { ?>
<a href="#" onClick="window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $rtov->uce; ?>
&rozuct=ANO&copern=8&drupoh=2&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $rtov->dok; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='⁄prava v˝davkovÈho pokladniËnÈho dokladu'></a>
<a href="#" onClick="window.open('../ucto/vspk_t.php?copern=20&drupoh=2&page=1&sysx=UCT&rozuct=ANO&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

<?php  if ( $rtov->drupoh == 13 )  { ?>
<a href="#" onClick="window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $rtov->uce; ?>
&rozuct=ANO&copern=8&drupoh=4&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $rtov->dok; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='⁄prava bankovÈho dokladu'></a>
<a href="#" onClick="window.open('../ucto/vspk_t.php?copern=20&drupoh=4&page=1&sysx=UCT&rozuct=ANO&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

<?php  if ( $rtov->drupoh == 14 )  { ?>
<a href="#" onClick="window.open('../ucto/vspk_u.php?sysx=UCT&hladaj_uce=<?php echo $rtov->uce; ?>
&rozuct=ANO&copern=8&drupoh=5&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $rtov->dok; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='⁄prava vöeobecnÈho ˙ËtovnÈho dokladu'></a>
<a href="#" onClick="window.open('../ucto/vspk_t.php?copern=20&drupoh=5&page=1&sysx=UCT&rozuct=ANO&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

<?php  if ( $rtov->drupoh == 5 )   { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&hladaj_uce=<?php echo $rtov->uce; ?>
&rozuct=ANO&copern=20&drupoh=1&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $rtov->dok; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='⁄prava roz˙Ëtovania odberateæskej fakt˙ry'></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?copern=20&drupoh=1&page=1&pocstav=0&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

<?php  if ( $rtov->drupoh == 6 )   { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?sysx=UCT&hladaj_uce=<?php echo $rtov->uce; ?>
&rozuct=ANO&copern=20&drupoh=2&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $rtov->dok; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<input type='image' src='../obr/zoznam.png' width=15 height=12 border=0 title='⁄prava roz˙Ëtovania dod·vateæskej fakt˙ry'></a>
<a href="#" onClick="window.open('../faktury/vstf_t.php?copern=20&drupoh=2&page=1&pocstav=0&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

<?php  if ( $rtov->drupoh == 7 )   { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?copern=20&drupoh=1&page=1&pocstav=1&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

<?php  if ( $rtov->drupoh == 8 )   { ?>
<a href="#" onClick="window.open('../faktury/vstf_t.php?copern=20&drupoh=2&page=1&pocstav=1&cislo_dok=<?php echo $rtov->dok; ?>
', '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )"><?php echo $rtov->dok; ?></a>
<?php                              } ?>

</td>
<td class='hvstup' ><?php echo $dat_sk; ?></td>
<td class='hvstup' ><?php echo $das_sk; ?></td>
<?php  
$hvstupx='hvstup';
if( $pospl > 0 ) { $hvstupx='hvstup_bred'; }
?>
<td class='<?php echo $hvstupx; ?>' >
<?php
if( $cinnost == 7 )
           {
$ksy="".$rtov->ksy;
if( $ksy == '' AND $alchem == 1 ) { $ksy="0008"; }
if( $ksy == '' ) $ksy="0308";

$ssy="".$rtov->ssy;
if( $ssy == '' ) $ssy="0";
$uc1="".$rtov->uc1;
if( $uc1 == '' ) $uc1="00";
$nm1="".$rtov->nm1;
if( $nm1 == '' ) $nm1="0000";
$uc2="".$rtov->uc2;
if( $uc2 == '' ) $uc2="00";
$nm2="".$rtov->nm2;
if( $nm2 == '' ) $nm2="0000";
$uc3="".$rtov->uc3;
if( $uc3 == '' ) $uc3="00";
$nm3="".$rtov->nm3;
if( $nm3 == '' ) $nm3="0000";

  $pole1 = explode("-", $rtov->ib1);
  $h_ib1 = $pole1[0];
  $h_st1 = $pole1[1];

$ibn1=trim($h_ib1);
if( $ibn1 == '' ) $ibn1="0000";
$bic1=trim($h_st1);
if( $bic1 == '' ) $bic1="0";

  $pole2 = explode("-", $rtov->ib2);
  $h_ib2 = $pole2[0];
  $h_st2 = $pole2[1];

$ibn2=trim($h_ib2);
if( $ibn2 == '' ) $ibn2="0000";
$bic2=trim($h_st2);
if( $bic2 == '' ) $bic2="0";

  $pole3 = explode("-", $rtov->ib3);
  $h_ib3 = $pole3[0];
  $h_st3 = $pole3[1];

$ibn3=trim($h_ib3);
if( $ibn3 == '' ) $ibn3="0000";
$bic3=trim($h_st3);
if( $bic3 == '' ) $bic3="0";

?>
<img src='../obr/pdf.png' width=10 height=10 border=1 
onClick="VzpFakIban(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>,<?php echo $rtov->zos; ?>,
'<?php echo $ksy; ?>','<?php echo $ssy; ?>','<?php echo $uc1; ?>','<?php echo $nm1; ?>','<?php echo $ibn1; ?>','<?php echo $bic1; ?>');"
 title='Uhradiù doklad <?php echo $rtov->dok; ?> na ˙Ëet <?php echo $rtov->uc1; ?>/<?php echo $rtov->nm1; ?>  iban/bic <?php echo $ibn1; ?>/<?php echo $bic1; ?>' >

<?php  if ( $uc2 != '00' )   { ?>
<img src='../obr/pdf.png' width=10 height=10 border=1 
onClick="VzpFakIban(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>,<?php echo $rtov->zos; ?>,
'<?php echo $ksy; ?>','<?php echo $ssy; ?>','<?php echo $uc2; ?>','<?php echo $nm2; ?>','<?php echo $ibn2; ?>','<?php echo $bic2; ?>');"
 title='Uhradiù doklad <?php echo $rtov->dok; ?> na ˙Ëet <?php echo $rtov->uc2; ?>/<?php echo $rtov->nm2; ?>' >
<?php                        } ?>

<?php  if ( $uc3 != '00' )   { ?>
<img src='../obr/pdf.png' width=10 height=10 border=1 
onClick="VzpFakIban(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>,<?php echo $rtov->zos; ?>,
'<?php echo $ksy; ?>','<?php echo $ssy; ?>','<?php echo $uc3; ?>','<?php echo $nm3; ?>','<?php echo $ibn3; ?>','<?php echo $bic3; ?>');"
 title='Uhradiù doklad <?php echo $rtov->dok; ?> na ˙Ëet <?php echo $rtov->uc3; ?>/<?php echo $rtov->nm3; ?>' >
<?php                        } ?>

<?php
           }
?>
<?php echo $pospl; ?></td>
<td class='hvstup' align='right' >
<?php  if ( $cinnost == 9 AND $rtov->drupoh >= 11 AND $rtov->drupoh <= 14 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='UH".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 1 AND ( $rtov->drupoh == 5 OR $rtov->drupoh == 6 ) AND $rtov->hod < 0 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='UH".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 1 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $rtov->hod >= 0 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='FA".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 0 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='FA".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>


<?php echo $rtov->fak; ?>
<?php
if( $cinnost == 7 )
           {
?>
<img src='../obr/zmazuplne.png' width=10 height=10 border=0 
 onClick="ZmazVzp(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>);" 
 title='Zmazaù poloûku zo zoznamu fakt˙r, NIE zo saldokonta ani z ˙Ëtovania' >
<?php
           }
?>

</td>

<td class='hvstup' align='right' ><?php echo $rtov->hod; ?></td>
<td class='hvstup' align='right' ><?php echo $rtov->uhr; ?></td>
<td class='hvstup' align='right' ><?php echo $rtov->zos; ?></td>
</tr> 
<?php

if( $poz != ''  ) {
?>
<tr>
<td class='hvstup' colspan='10' align='left'><?php echo $poz; ?></td></tr> 
<?php
                        }
           }

if( $rtov->pox == 999 AND $strana >= $cislo_strana AND $strana <= $cislo_strank )
                {
?>
<tr>
<td class='hvstup_zlte' colspan='7' align='left'>
<?php
if( $cinnost == 7 )
           {
?>
<img src='../obr/pdf.png' width=10 height=10 border=1
onClick="VzpIco(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>);"
 title='Vytvoriù PDF z·poËet pre I»O <?php echo $rtov->ico; ?>' >

<?php
           }
?>
CELKOM za I»O <?php echo $rtov->ico." ".$rtov->nai." ".$rtov->mes; ?></td>

<td class='hvstup_zlte' align='right' ><?php echo $rtov->hod; ?></td>
<td class='hvstup_zlte' align='right' ><?php echo $rtov->uhr; ?></td>
<td class='hvstup_zlte' align='right' ><?php echo $rtov->zos; ?></td>
</tr> 
<?php

                }

}
$i = $i + 1;
$j = $j + 1;
if(  $rtov->pox == 1 AND $rtov->poz != ''  ) { $j = $j + 1; }
if( $j >= 37 ) { $j=0; $strana=$strana+1; }
  }

           }
//koniec ak je tovar

if( $h_ico == 0 )
       {
?>
<tr>
<td class='hvstup_tzlte' colspan='4' align='left'>CELKOM za vöetky I»O strana <?php echo $cislo_strana; ?> aû <?php echo $cislo_strank; ?></td>
<td colspan='3' class='hvstup_tzlte' align='left'>
<?php
if( $cinnost == 7 )
     {
?>
<a href="#" onClick="window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_priku.php?h_datp=<?php echo $h_datp;?>&cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/next.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_strand; ?>' ></a>
<?php
     }
?>
</td>

<?php
if(  $cislo_strana <= $strana  )
     {
?>
<td class='hvstup_tzlte' align='right' ><?php echo $Shod; ?></td>
<td class='hvstup_tzlte' align='right' ><?php echo $Suhr; ?></td>
<td class='hvstup_tzlte' align='right' ><?php echo $Szos; ?></td>
<?php
     }
?>
</tr> 

<?php
       }
?>

<?php
}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec pre jedno a vsetky ICO



if( $nulovazostava == 1 )
{
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

if( $h_ico > 0 ) $pdf=new FPDF("P","mm","A4");
if( $h_ico == 0 ) $pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto","LTB",0,"L"); }
if( $vsetko == 0 ) { $pdf->Cell(90,5,"Saldokonto nesp·rovanÈ","LTB",0,"L"); }
$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(105,4,"Pr·zdna zostava","0",1,"R");

}



?> 

<?php 
if ( $drupoh == 2  )
{
$pdf->Output("../tmp/saldo.$kli_uzid.pdf")
?>
<script type="text/javascript">
  var okno = window.open("../tmp/saldo.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php 
}
?>

<?php 
if (  $drupoh == 1 OR $drupoh == 2 OR $drupoh == 4 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofaknesp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
}

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
