<HTML>
<?php
//VZAJOMNY ZAPOCET cinnost=8
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
$vsetko=1;

//uprava textov pred a za
if ( $copern == 2008 OR $copern == 2009 )
    {
$h_penp = strip_tags($_REQUEST['h_penp']);
//echo "penpe".$h_penp;
$sqtoz = "UPDATE F$kli_vxcf"."_uctupvtext SET vzpp='$h_penp' ";
if( $copern == 2009 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctupvtext SET vzpz='$h_penp' ";  }
$oznac = mysql_query("$sqtoz");
$copern=11;
}
//koniec uprava textov pred a za

//ulozenie vzpp
if( $copern == 1011 )
{
$n_vzpp = $_REQUEST['h_vzpp'];
$n_vzpp=str_replace("<br />","\r",$n_vzpp);

$ttvv = "UPDATE F$kli_vxcf"."_uctupvtext SET vzpp='$n_vzpp' ";
$ttqq = mysql_query("$ttvv");

$copern=11;
}
//koniec ulozenie vzpp

//ulozenie vzpz
if( $copern == 2011 )
{
$n_vzpz = $_REQUEST['h_vzpz'];
$n_vzpz=str_replace("<br />","\r",$n_vzpz);

$ttvv = "UPDATE F$kli_vxcf"."_uctupvtext SET vzpz='$n_vzpz' ";
$ttqq = mysql_query("$ttvv");

$copern=11;
}
//koniec ulozenie vzpz


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

$preuct = 1*$_REQUEST['preuct'];

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tabulka na ulozenie textov upomienky,penale
if( $cinnost == 8 )
{
$sql = "SELECT * FROM F$kli_vxcf"."_uctupvtext";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<STR
(
   upop       TEXT,
   upoz       TEXT,
   penp       TEXT,
   penz       TEXT,
   vzpp       TEXT,
   vzpz       TEXT,
   prmx1      INT,
   prmt1      VARCHAR(10)
);
STR;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctupvtext'.$sqlt;
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctupvtext ( upop,upoz,prmx1,prmt1 ) VALUES ( 'pred', 'za', '0', 'text' )";
$ttqq = mysql_query("$ttvv");

$n_upop="V·ûen˝ odberateæ,"."\r";
$n_upop=$n_upop."kontrolou n·öho saldokonta sme zistili tieto neuhradenÈ fakt˙ry po lehote splatnosti vystavenÈ na Vaöu spoloËnosù ."."\r";

$n_upoz="ProsÌme o Vaöu kontrolu nezaplaten˝ch fakt˙r po lehote splatnosti."."\r";
$n_upoz=$n_upoz."Pokiaæ ste uvedenÈ fakt˙ry po lehote splatnosti doposiaæ nezaplatili, urobte tak prosÌm ihneÔ"."\r";
$n_upoz=$n_upoz."na n·ö bankov˝ ˙Ëet ".$fir_fuc1." / ".$fir_fnm1." ."."\r";
$n_upoz=$n_upoz."V prÌpade, ûe ste uvedenÈ fakt˙ry po lehote splatnosti uhradili, povaûujte prosÌm t˙to upomienku za bezpredmetn˙ . "."\r\r";
$n_upoz=$n_upoz."œakujeme. "."\r";

$n_penp="V·ûen˝ odberateæ,"."\r";
$n_penp=$n_penp."kontrolou n·öho saldokonta sme zistili tieto neuhradenÈ fakt˙ry po lehote splatnosti vystavenÈ na Vaöu spoloËnosù ."."\r";

$n_penz="ProsÌme o Vaöu kontrolu nezaplaten˝ch fakt˙r po lehote splatnosti."."\r";
$n_penz=$n_penz."Pokiaæ ste uvedenÈ fakt˙ry po lehote splatnosti doposiaæ nezaplatili, urobte tak prosÌm ihneÔ"."\r";
$n_penz=$n_penz."na n·ö bankov˝ ˙Ëet ".$fir_fuc1." / ".$fir_fnm1." ."."\r";
$n_penz=$n_penz."V prÌpade, ûe ste uvedenÈ fakt˙ry po lehote splatnosti uhradili, povaûujte prosÌm t˙to penaliz·ciu za bezpredmetn˙ . "."\r\r";
$n_penz=$n_penz."œakujeme. "."\r";

$ttvv = "UPDATE F$kli_vxcf"."_uctupvtext SET upop='$n_upop', upoz='$n_upoz', penp='$n_penp', penz='$n_penz' ";
$ttqq = mysql_query("$ttvv");

}


$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupvtext");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $h_vzpp=$riaddok->vzpp;
  $h_vzpp=str_replace("\r","<br />",$h_vzpp);

  $h_vzpz=$riaddok->vzpz;
  $h_vzpz=str_replace("\r","<br />",$h_vzpz);

  }
}
//koniec tabulky na ulozenie textov upomienky,penale,zapocet

//tabulka na ulozenie proti a vseob
if( $cinnost == 8 )
{
$sql = "SELECT * FROM F$kli_vxcf"."_uctvzajvseob".$kli_uzid;
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

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctvzajvseob'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctvzajvseob".$kli_uzid." ( proti,vseob,prmx1,prmt1 ) VALUES ( '39500', '2001', '0', 'text' )";
$ttqq = mysql_query("$ttvv");
}

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvzajvseob".$kli_uzid);
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $proti=$riaddok->proti;
  $vseob=$riaddok->vseob;
  }
}
//koniec tabulky na ulozenie proti a vseob

$zapiskliknutu=0;

//zapis kliknutu fakturu do vseob
if( $copern == 1111 )
{
$proti = 1*$_REQUEST['proti'];
$vseob = 1*$_REQUEST['vseob'];
$h_ico = 1*$_REQUEST['h_ico'];
$h_fak = 1*$_REQUEST['h_fak'];
$h_zos = 1*$_REQUEST['h_zos'];

//echo "proti ".$proti." vseob ".$vseob;
//echo "strana".$cislo_strana;
//echo "strank".$cislo_strank;
//exit;

$nasiel=1;
$xdruh=5;
$cuce=1*substr($h_uce,0,3);
if( $cuce >= 321 ) $xdruh=6;
$h_icoq=$h_ico;
if( $preuct == 1 )
{
$xdruh=5;
$cuce3=1*substr($h_uce,0,3);
$cuce2=1*substr($h_uce,0,2);
if( $cuce2 == 32 ) $xdruh=6;
if((  $agrostav == 1 OR $autovalas == 1 OR $ramex == 1 OR $ekorobot == 1 ) AND $cuce3 == 314 ) $xdruh=6;
if( $ramex == 1 AND $h_uce == 31460 ) $xdruh=5;

if( $agrostav == 1 AND $cuce3 == 324 ) $xdruh=5;
if( $agrostav == 1 AND $cuce3 == 379 ) $xdruh=6;
if( $polno == 1 AND $cuce3 == 379 ) $xdruh=6;
if( $agrostav == 1 AND $cuce3 == 378 ) $xdruh=6;
if( $autovalas == 1 AND $cuce3 == 335 ) $xdruh=6;
if( $autovalas == 1 AND $cuce3 == 379 ) $xdruh=6;
if( $autovalas == 1 AND $cuce3 == 335 ) $xdruh=5;
if( $ekorobot == 1 AND $h_uce == 31410 ) $xdruh=6;
}
$h_icoq = 1*$_REQUEST['h_icoq'];

if( $nasiel == 1 )
  {

//preuctuj dobropis na cielovu fakturu
    if( $xdruh == 5 )
      {
//echo "robim dobropis";
//" ( dok,poh,cpl,ucm,ucd,rdp,dph,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ";

$ttvv = "INSERT INTO F$kli_vxcf"."_uctvsdp ".
" ( dok,poh,cpl,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ".
" VALUES ( '$vseob', '0', '0', '$proti', '$h_uce', '1', '0', '$h_zos', '0', '0', ' ', '0', '$h_icoq', '$h_fak', '', '0', '0', '', '$kli_uzid'  )";
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

$dobropis=1;

$ttvv = "UPDATE F$kli_vxcf"."_uctvzajvseob".$kli_uzid." SET proti='$proti', vseob='$vseob' ";
$ttqq = mysql_query("$ttvv");
      }

    if( $xdruh == 6 )
      {
//echo "robim dobropis";
//" ( dok,poh,cpl,ucm,ucd,rdp,dph,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ";

$ttvv = "INSERT INTO F$kli_vxcf"."_uctvsdp ".
" ( dok,poh,cpl,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ".
" VALUES ( '$vseob', '0', '0', '$h_uce', '$proti', '1', '0', '$h_zos', '0', '0', ' ', '0', '$h_icoq', '$h_fak', '', '0', '0', '', '$kli_uzid'  )";;
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

$dobropis=1;

$ttvv = "UPDATE F$kli_vxcf"."_uctvzajvseob".$kli_uzid." SET proti='$proti', vseob='$vseob' ";
$ttqq = mysql_query("$ttvv");
      }

  }

$ttvv = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=1 WHERE fak = $h_fak AND ico = $h_icoq AND uce = $h_uce ";
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

//exit;

$zapiskliknutu=1;
if( $fir_big == 0 ) { include("../ucto/saldo_zmaz_ok.php"); }

$copern=316; 
//$copern=10; 
//$vsetko=0;
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

$cislo_ico = 1*$_REQUEST['cislo_ico'];
$cislo_fak = 1*$_REQUEST['cislo_fak'];

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctvsdp WHERE cpl = $h_cpl ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$ttvv = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid SET pox1=0 WHERE fak = $cislo_fak AND ico = $cislo_ico AND uce = $h_uce ";
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

$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET hod=$n_hod WHERE cpl = $h_cpl AND dok = $vseob ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

//uprava hodnoty cudzej meny polozky z dokladu
if( $copern == 1618 )
{
$h_cpl = 1*$_REQUEST['h_cpl'];
$n_hodm = 1*$_REQUEST['n_hodm'];
$n_kurz = 1*$_REQUEST['n_kurz'];
$n_mena = $_REQUEST['n_mena'];

if( $n_hodm != 0 AND $n_kurz > 0 ) {
$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET zmen=1, hodm='$n_hodm', kurz='$n_kurz', mena='$n_mena' WHERE cpl = $h_cpl AND dok = $vseob ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
                   }

if( $n_hodm == 0 OR $n_kurz <= 0 ) {
$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET zmen=0, hodm=0, kurz=0, mena='' WHERE cpl = $h_cpl AND dok = $vseob ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
                   }

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

//nastav vseobecny doklad
if( $copern == 418 )
{
$h_vseob = 1*$_REQUEST['h_vseob'];
$h_proti = 1*$_REQUEST['h_proti'];

$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdh WHERE dok=$h_vseob ORDER by dok DESC LIMIT 1");
$cpol = mysql_num_rows($sqlmax);
  if ( $cpol == 0)
  {
$sqty = "INSERT INTO F$kli_vxcf"."_uctvsdh ( uce,dok,doq,dat,ume,ico,id,txp )".
" VALUES ( 1, '$h_vseob', '$h_vseob', '0000-00-00', '0', '$fir_fico', '$kli_uzid', 'z·poËet' );"; 
$ulozene = mysql_query("$sqty"); 

$dnes = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$h_dat = SqlDatum($dnes);

$pole = explode("-", $h_dat);
$h_ume = $pole[1].".".$pole[0];

 $uprt = "UPDATE F$kli_vxcf"."_uctvsdh SET dat='$h_dat', ume='$h_ume',
 poz='$h_poz', txz=' ', kto=' ',
 hod=0, zk0=0, zk1=0, zk2=0, dn1=0, dn2=0, sz1=0, sz2=0, sp3=0, sp4=0,
 zk3=0, zk4=0, dn3=0, dn4=0, sz3=0, sz4=0, sp1=0, sp2=0,
 unk=' '
 WHERE dok='$h_vseob'";
//echo $uprt;
$upravene = mysql_query("$uprt"); 
  }

$ttvv = "UPDATE F$kli_vxcf"."_uctvzajvseob".$kli_uzid." SET proti='$h_proti', vseob='$h_vseob' ";
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

$ucmx=0; $ucdx=0;
$sqldoks = mysql_query("SELECT * FROM F$kli_vxcf"."_uctvsdp WHERE dok = $vseob AND cpl = $h_cpl ");
  if (@$zaznam=mysql_data_seek($sqldoks,0))
  {
  $riaddok=mysql_fetch_object($sqldoks);
  $ucmx=$riaddok->ucm;
  $ucdx=$riaddok->ucd;
  }
$ucd3 = substr($ucdx,0,3);

if( $rozdiel > 0 )
     {
$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET hod=hod-($rozdiel) WHERE dok = $vseob AND cpl = $h_cpl AND LEFT(ucd,3) = 311 AND hod > $rozdiel ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
     }

if( $rozdiel < 0 AND $ucd3 == 311 )
     {
$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET hod=hod-($rozdiel) WHERE dok = $vseob AND cpl = $h_cpl AND hod < $rozdiel";
$dsql = mysql_query("$dsqlt");
$rozdiel=0;
     }

if( $rozdiel < 0 )
     {
$rozdiem=-1*$rozdiel;
$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET hod=hod+($rozdiel) WHERE dok = $vseob AND cpl = $h_cpl AND LEFT(ucm,3) = 321 AND hod > $rozdiem ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
     }

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}


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


//dopln zapocitane pox1=1 zo vseob
if( $preuct == 0 )
{
$sql = "DROP TABLE F".$kli_vxcf."_prcvsdp$kli_uzid ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_prcvsdp$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_uctvsdp WHERE dok=$vseob";
//echo $sql;
$vysledek = mysql_query("$sql");

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid,F".$kli_vxcf."_prcvsdp$kli_uzid ".
" SET pox1=1".
" WHERE ( ucm = $h_uce OR ucd = $h_uce ) AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.ico = F$kli_vxcf"."_prcvsdp$kli_uzid.ico AND ".
" F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.fak = F$kli_vxcf"."_prcvsdp$kli_uzid.fak  ";
$oznac = mysql_query("$sqtoz");

$sql = "DROP TABLE F".$kli_vxcf."_prcvsdp$kli_uzid ";
$vysledek = mysql_query("$sql");
}
//koniec dopln zapocitane

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
<title>
<?php if( $preuct == 0 ) { echo "Vz·jomn˝ z·poËet"; } ?>
<?php if( $preuct == 1 ) { echo "Pre˙Ëtovanie saldokonta"; } ?>
</title>
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

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&copern=316&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
                }

<?php if( $preuct == 0 ) {  ?>

function VzpFak(ico,fak,strana,zos)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_icoq=' + ico + '&h_fak=' + fak + '&h_zos=' + zos + '&h_obd=<?php echo $h_obd;?>&cislo_strana=' + strana + '&proti=' + proti + '&vseob=' + vseob + '&copern=1111&drupoh=1&page=1&cinnost=8', '_self' );

                }

function VzpIco(ico,fak,strana,zos)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_fak=' + fak + '&h_zos=' + zos + '&h_obd=<?php echo $h_obd;?>&cislo_strana=' + strana + '&proti=' + proti + '&vseob=' + vseob + '&copern=1111&drupoh=1&page=1&cinnost=8', '_self' );

                }

<?php                     }  ?>


<?php if( $preuct == 1 ) {  ?>

function VzpFak(ico,fak,strana,zos)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_icoq=' + ico + '&h_fak=' + fak + '&h_zos=' + zos + '&h_obd=<?php echo $h_obd;?>&cislo_strana=' + strana + '&proti=' + proti + '&vseob=' + vseob + '&copern=1111&drupoh=1&page=1&cinnost=8', '_self' );

                }

function VzpIco(ico,fak,strana,zos)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_icoq=' + ico + '&h_fak=' + fak + '&h_zos=' + zos + '&h_obd=<?php echo $h_obd;?>&cislo_strana=' + strana + '&proti=' + proti + '&vseob=' + vseob + '&copern=1111&drupoh=1&page=1&cinnost=8', '_self' );

                }

<?php                     }  ?>


function UpravPol(ico,fak,strana,cpl)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var rozdiel = document.forms.formd2.rozdiel.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&copern=411&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
  '&rozdiel=' + rozdiel + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>
&h_cpl=' + cpl + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
                }

function ZmazPol(ico,fak,strana,cpl)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&copern=416&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
 '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_cpl=' + cpl + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
                }

function NastavVseob(ico,fak,strana,vseob)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&copern=418&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
 '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

                }

function TlacVzp(ico,vseob)
                {

window.open('../ucto/zapocet.php?copern=10&vseob=<?php echo $vseob; ?>&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

function TlacVseoOld(vseob)
                {

window.open('vspk_t.php?sysx=UCT&rozuct=ANO&copern=20&drupoh=5&page=1&cislo_dok=<?php echo $vseob; ?>',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

function TlacVseo(vseob)
    {
    var hladaj_dok = 1;
    var drupohx = 5;
    var cislo_dok = vseob;
    window.open('vspk_pdf.php?sysx=UCT&rozuct=ANO&hladaj_dok=' + hladaj_dok + '&copern=20&drupoh=' + drupohx + '&page=&cislo_dok=' + cislo_dok + '&fff=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

function NastavZaciatok()
                {
<?php if( $preuct == 0 AND $h_ico > 0 ) { echo "document.forms.semskoc.sem.focus();"; } ?>
                }

function UlozHod(cpl,suma)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;
var n_hod = document.forms.fhodnew.n_hod.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&copern=618&h_cpl=' + cpl + '&n_hod=' + n_hod + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

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

    function CiarkaNaBodku(Vstup)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
    }

function upravMENU(cpl,kurz,hodm,mena)
                {

var uhr_cpl = cpl;
var uhr_kurz = kurz;
var uhr_hodm = hodm;
var uhr_mena = mena;

var dajid = "CM" + uhr_cpl; 


  myUhram = document.getElementById( dajid );
  var htmluhm = " ";

  htmluhm += " <table><tr><FORM name='fhodmnew' class='obyc' method='post' action='#' ><td>";

  htmluhm += " <input class='hvstup' type='text' name='n_mem' id='n_mem' size='3' onkeyup='CiarkaNaBodku(this)' value='" + uhr_mena + "' /> ";
  htmluhm += " kurz<input class='hvstup' type='text' name='n_kum' id='n_kum' size='8' onkeyup='CiarkaNaBodku(this)' value='" + uhr_kurz + "' /> ";
  htmluhm += " hodnota<input class='hvstup' type='text' name='n_hom' id='n_hom' size='8' onkeyup='CiarkaNaBodku(this)' value='" + uhr_hodm + "' /> ";

  htmluhm += " <img border=0 src='../obr/ok.png' style='width:12; height:15;' ";
  htmluhm += " title='Uloûiù upravenÈ hodnoty' ";
  htmluhm += " onClick=\"UlozHom(" + uhr_cpl + ");\"></td></FORM></tr></table>";

  myUhram.innerHTML = htmluhm;
  myUhram.className='kliknute';

  document.forms.fhodmnew.n_hom.focus();
  document.forms.fhodmnew.n_hom.select();
                }

function UlozHom(cpl)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;
var n_hodm = document.forms.fhodmnew.n_hom.value;
var n_kurz = document.forms.fhodmnew.n_kum.value;
var n_mena = document.forms.fhodmnew.n_mem.value;

window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&copern=1618&h_cpl=' + cpl + '&n_hodm=' + n_hodm + '&n_kurz=' + n_kurz + '&n_mena=' + n_mena + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

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
<td>EuroSecom  -  
<?php if( $preuct == 0 ) { echo "Vz·jomn˝ z·poËet"; } ?>
<?php if( $preuct == 1 ) { echo "Pre˙Ëtovanie saldokonta"; } ?>
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//text pred a za vz andrej
if ( $copern == 10 )
     {

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupvtext ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);

  $h_penp1=$riaddok->vzpp;
  $h_penz1=$riaddok->vzpz;
  }

?>
<div id="myTextElement" style="cursor: hand; display: none; position: absolute; z-index: 800; top: 190px; left: 20px; width:800px; height:200px;">
</div>

<div id="nastavtpx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 190px; left: 10px; width:800px; height:200px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='fhoddok' method='post' action='#' >
<td colspan='5'>Text z·poËtu - pred poloûkami
<input type='hidden' name='druh' id='druh' >
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onClick='UlozPenp();' title='Uloû zmeny v texte' >

</td>
<td colspan='5' align='right'>

<img border=0 src='../obr/zmazuplne.png' style="width:15px; height:15px;" onClick="nastavtpx.style.display='none'; myTextElement.style.display='none';" title='Zhasni' >

</td></tr>  
                    
<tr><td colspan='10' class='obyc' align='left'>
<textarea name='h_penp' id='h_penp' rows='12' cols='118' ><?php echo $h_penp1; ?></textarea>
</td></tr>


</FORM></table>
</div>

<div id="nastavtzx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 190px; left: 10px; width:800px; height:200px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='fhoddoz' method='post' action='#' >
<td colspan='5'>Text z·poËtu - za poloûkami
<input type='hidden' name='druh' id='druh' >
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onClick='UlozPenz();' title='Uloû zmeny v texte' >

</td>
<td colspan='5' align='right'>

<img border=0 src='../obr/zmazuplne.png' style="width:15px; height:15px;" onClick="nastavtzx.style.display='none'; myTextElement.style.display='none';" title='Zhasni' >

</td></tr>  
                    
<tr><td colspan='10' class='obyc' align='left'>
<textarea name='h_penz' id='h_penz' rows='12' cols='118' ><?php echo $h_penz1; ?></textarea>
</td></tr>


</FORM></table>
</div>

<script type="text/javascript">

function RozniPenp(druh)
                {
  nastavtpx.style.display='';
  document.forms.fhoddok.druh.value=1; 

                }

function RozniPenz(druh)
                {
  nastavtzx.style.display='';
  document.forms.fhoddok.druh.value=2; 

                }

function DajTextp(druh)
                {
  if( druh == 1 ) { DajText(1); }
  if( druh == 2 ) { DajText(2); }
                }


function UlozPenp()
                {
  nastavtpx.style.display='none';                

<?php if( $_SESSION['chrome'] == 0 ) { ?>
  var h_penpe = document.forms.fhoddok.h_penp.value.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
<?php                                } ?>
<?php if( $_SESSION['chrome'] == 1 ) { ?>
  var h_penpe = document.forms.fhoddok.h_penp.value.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
<?php                                } ?>

      var druh = document.forms.fhoddok.druh.value;
      if( druh == 1 ) { var copernx=2008; }
      if( druh == 2 ) { var copernx=2009; }

window.open('../ucto/saldo_zapocet.php?regpok=<?php echo $regpok; ?>&h_penp=' + h_penpe + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=0&copern=' + copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&cinnost=<?php echo $cinnost; ?>', '_self' );

                }

function UlozPenz()
                {
  nastavtzx.style.display='none';                

<?php if( $_SESSION['chrome'] == 0 ) { ?>
  var h_penpe = document.forms.fhoddoz.h_penz.value.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
<?php                                } ?>
<?php if( $_SESSION['chrome'] == 1 ) { ?>
  var h_penpe = document.forms.fhoddoz.h_penz.value.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\n","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
      h_penpe = h_penpe.replace("\r","%0D%0A");
<?php                                } ?>

      var druh = document.forms.fhoddok.druh.value;
      if( druh == 1 ) { var copernx=2008; }
      if( druh == 2 ) { var copernx=2009; }

window.open('../ucto/saldo_zapocet.php?regpok=<?php echo $regpok; ?>&h_penp=' + h_penpe + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=0&copern=' + copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&cinnost=<?php echo $cinnost; ?>', '_self' );

                }


</script>
<?php
     }
//koniec text pred a za vz
?>

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
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok,fak";

if ( $h_ico > 0 )
{
$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$uctpol.ico = $h_ico AND uce = $h_uce ".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok,fak";

$cislo_strank=100;
}

//echo $tovtt;
//exit;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol >= 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;
$jeformsem=0;

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


if ( $j == 0 AND $strana >= $cislo_strana AND $strana <= $cislo_strank )
      {

$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";
if( $h_obd > 0 AND $h_obd < 13 ) $h_obdn="do ".$datkdph_sk;
if( $h_obd == 100 ) $h_obdn="PoËiatoËn˝ stav";

if( $vsetko == 1 ) { 
?>
<table  class='fmenu' width='100%'>
<tr>
<td colspan='4' align='left'>Saldokonto strana <?php echo $cislo_strana; ?> aû <?php echo $cislo_strank; ?></td>
<td colspan='1' align='left'>
<a href="#" onClick="window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
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
<td width='5%' >poSPL</td>
<td width='10%' align='right' >Fakt˙ra ËÌslo</td>
<td width='10%' align='right' >Hodnota</td>
<td width='10%' align='right' >UhradenÈ</td>
<td width='10%' align='right' >Zostatok</td>
</tr> 
<?php
                   }

if( $vsetko == 0 ) { 
?>
<?php if( $cinnost == 8 AND $strana == $cislo_strana ) { ?>

<?php
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvsdp WHERE dok = $vseob ORDER BY cpl";
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

$cucm=1*substr($rsluz->ucm,0,3);
$cucd=1*substr($rsluz->ucd,0,3);
if( $cucd == 311 ) { $suma311=$suma311+$rsluz->hod; $rozdiel=$rozdiel+$rsluz->hod; }
if( $cucm == 321 ) { $suma321=$suma321+$rsluz->hod; $rozdiel=$rozdiel-$rsluz->hod; }

$Cislo=$rozdiel+"";
$rozdiel=sprintf("%0.2f", $Cislo);
if( $rozdiel < 0.01 AND $rozdiel > -0.01 ) $rozdiel="0.00";

?>
<?php if( $ip == 0 ) { ?>
<table  class='fmenu' width='100%'>
<tr>
<td width='10%' align='right'>Doklad</td>
<td width='9%' align='right'>UCM</td>
<td width='9%' align='right'>UCD</td>
<td width='10%' align='right'>Fakt˙ra</td>
<td width='10%' align='right'>I»O</td>
<td width='10%' align='right'>Hodnota</td>
<td width='2%' align='right'> </td>
<td width='10%' align='right'>
<img src='../obr/zoznam.png' width=15 height=12 border=1 
 onClick="TlacVseo(<?php echo $vseob; ?>);" 
 title='TlaËiù vöeobecn˝ doklad' >
<a href='vspk_u.php?sysx=UCT&rozuct=NIE&copern=8&drupoh=5&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $vseob;?>'>
<img src='../obr/uprav.png' width=15 height=12 border=1 title="⁄prava dokladu" ></a>
<img src='../obr/tlac.png' width=15 height=12 border=1 
 onClick="TlacVzp(<?php echo $rsluz->ico; ?>,<?php echo $vseob; ?>);" 
 title='TlaËiù vz·jomn˝ z·poËet' >
</td>
</tr>
<?php                } ?>
<tr>
<?php $xckmpx=$ip+1; ?>
<FORM name="formsx<?php echo $xckmpx; ?>" class="obyc" method="post" action="#" >
<td width='10%' align='right' class="fmenu" >
<?php echo $rsluz->dok; ?>

<!-- toto som zaremoval neviem ci niekto pouziva ??????
<div class='nekliknute' id='CM<?php echo $rsluz->cpl; ?>' >
<?php echo $rsluz->dok; ?>
<?php
$kurzx=$rsluz->kurz;
$hodmx=$rsluz->hodm;
$menax=$rsluz->mena;
?>
<a href="#" onClick="upravMENU(<?php echo $rsluz->cpl; ?>,<?php echo $kurzx; ?>,<?php echo $hodmx; ?>,'<?php echo $menax; ?>');">
<img src='../obr/banky/dollar2.jpg' 
 width=20 height=12 border=0 title='Upraviù Hodnotu v cudzej mene <?php echo $rsluz->hodm; ?> <?php echo $rsluz->mena; ?>' ></a>
</div>
-->

</td>
<td width='9%' align='right' class="fmenu" ><?php echo $rsluz->ucm; ?></td>
<td width='9%' align='right' class="fmenu" ><?php echo $rsluz->ucd; ?></td>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->fak; ?>
 <img src='../obr/ok.png' width=15 height=12 border=1 
 onClick="UpravPol(<?php echo $rsluz->ico; ?>,<?php echo $rsluz->fak; ?>,<?php echo $strana; ?>,<?php echo $rsluz->cpl; ?>);" 
 title='PrispÙsobiù poloûku zo vöeobecnÈho dokladu na rozdiel=0' >
</td>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->ico; ?></td>

<td width='10%' align='right' class="fmenu" >

<div id="SP<?php echo $xckmpx; ?>" >

<?php echo $rsluz->hod; ?>
 <img src='../obr/uprav.png' width=15 height=12 border=1 onClick="SP<?php echo $xckmpx; ?>.style.display='none'; SPX<?php echo $xckmpx; ?>.style.display='';"
 title='Upraviù hodnotu poloûky' >

</div>

<div id="SPX<?php echo $xckmpx; ?>" style="display:none; " >

 <input class='hvstup' type='text' name='n_mnozs' id='n_mnozs' size='8' value="<?php echo $rsluz->hod;?>" />

 <img src="../obr/ok.png" onClick="UlozSTZX<?php echo $xckmpx; ?>(<?php echo $rsluz->dok; ?>, <?php echo $rsluz->cpl; ?> );" width=15 height=10 border=1 title="Uloûiù poloûku" >

</div>

</td>
<td width='2%' align='left' class="fmenu" >
 <img src='../obr/zmazuplne.png' width=15 height=12 border=1 
 onClick="ZmazPol(<?php echo $rsluz->ico; ?>,<?php echo $rsluz->fak; ?>,<?php echo $strana; ?>,<?php echo $rsluz->cpl; ?>);" 
 title='Zmazaù poloûku zo vöeobecnÈho dokladu a z·poËtu' >
</td>
</FORM>
</tr>
<script type="text/javascript">
function UlozSTZX<?php echo $xckmpx; ?>(doklad,cpl)
{

var n_cpl = cpl;
var n_mnozs = document.forms.formsx<?php echo $xckmpx; ?>.n_mnozs.value;
var vseob= doklad;


window.open('saldo_zapocet.php?preuct=<?php echo $preuct;?>&copern=618&h_cpl=' + n_cpl + '&n_hod=' + n_mnozs + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

            
}
</script>
<?php
}
$ip = $ip + 1;
  }
?>
<?php if( $rozdiel != 0 OR $suma311 != 0 ) { ?>
<tr>
<td align='left' class="bmenu" >Pohæad·vky = <?php echo $suma311; ?></td>
<td align='left' class="bmenu" >Z·v‰zky = <?php echo $suma321; ?></td>
<td align='right' class="bmenu" colspan="4" >Rozdiel = <?php echo $rozdiel; ?></td>
</tr>
<?php                                      } ?>
<?php                                                   } ?>

<table  class='fmenu' width='100%'>

<?php if( $cinnost == 8 AND $strana == $cislo_strana ) { 
$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);
?>
<tr>
<FORM name="formd2" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="4">
 <input type="hidden" name="rozdiel" id="rozdiel" value="<?php echo $rozdiel;?>" />
 Proti˙Ëet pri pre˙ËtovanÌ: 
 <input type="text" name="proti" id="proti" size="10" value="<?php echo $proti;?>" />
 »Ìslo vöeob.dokladu: 
 <input type="text" name="vseob" id="vseob" size="10" value="<?php echo $vseob;?>" />
<img src='../obr/vlozit.png' width=15 height=12 border=1 
 onClick="NastavVseob(<?php echo $h_ico; ?>,0,<?php echo $strana; ?>,<?php echo $vseob; ?>);" 
 title='Nastaviù ËÌslo vöeobecnÈho dokladu' >
<td class="hmenu" colspan="2">
<td class="hmenu" colspan="2">
VZ<img src='../obr/zoznam.png' onClick="RozniPenp(1);" width=15 height=15 border=0 title='Text z·poËtu pred poloûkami' >
<img src='../obr/zoznam.png' onClick="RozniPenz(2);" width=15 height=15 border=0 title='Text z·poËtu za poloûkami' >
</FORM>
<?php                     } ?>

<tr>
<td colspan='4' align='left'>Saldokonto nesp·rovanÈ strana <?php echo $cislo_strana; ?> aû <?php echo $cislo_strank; ?></td>
<td colspan='1' align='left'>
<?php if( $h_ico == 0 ) { ?>
<a href="#" onClick="window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/next.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_strand; ?>' ></a>
<?php                   } ?>
</td>
<td colspan='5' align='right'><?php echo "FIR".$kli_vxcf." ".$kli_nxcf." strana ".$strana; ?></td>
</tr> 
<tr>
<td colspan='2' align='left'>⁄Ëet: <?php echo $h_uce; ?></td>
<td colspan='2' align='left'>Obdobie: <?php echo $h_obdn; ?></td>
</tr> 

<tr>
<?php if( $i == 0 ) { echo "<FORM name='semskoc' class='obyc' method='post' action='#' >"; } ?>
<td width='30%' align='left'>Firma</td>
<td width='5%' align='left'>UME</td>
<td width='10%' align='left'>Doklad</td>
<td width='7%' >Vystaven·</td>
<td width='7%' >Splatn·</td>
<td width='5%' >poSPL</td>
<td width='9%' align='right' >Fakt˙ra ËÌslo</td>
<td width='9%' align='right' >Hodnota</td>
<td width='9%' align='right' >UhradenÈ</td>
<td width='9%' align='right' >Zostatok</td>
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
$hvstup="hvstup";
if( $rtov->pox1 > 0 ) { $hvstup='hvstup_bred'; }
?>
<tr>
<td class='<?php echo $hvstup; ?>' align='left'>
<a href="#" onClick="window.open('../cis/cico.php?copern=88&page=1&cislo_ico=<?php echo $rtov->ico;?>',
 '_blank', 'width=1070, height=900, top=60, left=20, status=yes, resizable=yes, scrollbars=yes' )"><?php echo "I»O: ".$rtov->ico; ?></a>
<?php echo " ".$rtov->nai; ?>
<?php if( $i == 0 AND $zapiskliknutu == 0 ) { echo "<input class='hvstup' type='text' name='sem' id='sem' size='1' />"; $jeformsem=1; } ?>
<?php if( $zapiskliknutu == 1 AND $rtov->ico == $h_ico AND $rtov->fak == $h_fak AND $rtov->zos == $h_zos  ) 
{ echo "<input class='hvstup' type='text' name='sem' id='sem' size='1' />"; $jeformsem=1; } ?>
</td>
<td class='<?php echo $hvstup; ?>' align='left'><?php echo $rtov->ume; ?></td>
<td class='<?php echo $hvstup; ?>' align='left'>
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
<td class='<?php echo $hvstup; ?>' ><?php echo $dat_sk; ?></td>
<td class='<?php echo $hvstup; ?>' ><?php echo $das_sk; ?></td>
<?php  
$hvstupx='hvstup';
if( $pospl > 0 ) { $hvstupx='hvstup_bred'; }
?>
<td class='<?php echo $hvstupx; ?>' >
<?php
if( $cinnost == 8 )
           {

$courob="ZapoËÌtaù";
if( $preuct == 1 ) $courob="Od˙Ëtovat zostatok";
$icoxx=1*$rtov->ico;
?>
<img src='../obr/pdf.png' width=10 height=10 border=1 
onClick="VzpFak(<?php echo $icoxx; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>,<?php echo $rtov->zos; ?>);"
 title='<?php echo $courob; ?> doklad <?php echo $rtov->dok; ?>' >
<?php
           }
?>
<?php echo $pospl; ?></td>
<td class='<?php echo $hvstup; ?>' align='right' >
<?php  if ( $cinnost == 9 AND $rtov->drupoh >= 11 AND $rtov->drupoh <= 14 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='UH".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 1 AND ( $rtov->drupoh == 5 OR $rtov->drupoh == 6 ) AND $rtov->hod < 0 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='UH".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 1 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $rtov->hod >= 0 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='FA".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 0 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='FA".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>


<?php echo $rtov->fak; ?>
<?php
if( $cinnost == 8 )
           {
?>
<img src='../obr/zmazuplne.png' width=10 height=10 border=0 
 onClick="ZmazVzp(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>);" 
 title='Zmazaù poloûku zo z·poËtu, NIE zo saldokonta ani z ˙Ëtovania' >
<?php
           }
?>

</td>

<td class='<?php echo $hvstup; ?>' align='right' ><?php echo $rtov->hod; ?></td>
<td class='<?php echo $hvstup; ?>' align='right' ><?php echo $rtov->uhr; ?></td>
<td class='<?php echo $hvstup; ?>' align='right' ><?php echo $rtov->zos; ?></td>
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
if( $cinnost == 8 )
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
if( $j >= 37 AND $h_ico == 0 ) { $j=0; $strana=$strana+1; }
  }

           }
//koniec ak je tovar

if( $jeformsem == 0 ) { 
echo "<tr><td class='bmenu' >";
echo "<input class='bmenu' type='text' name='sem' id='sem' size='1' /></td></tr>";
                      }
echo "</FORM>"; 

if( $h_ico == 0 )
       {
?>
<tr>
<td class='hvstup_tzlte' colspan='4' align='left'>CELKOM za vöetky I»O strana <?php echo $cislo_strana; ?> aû <?php echo $cislo_strank; ?></td>
<td colspan='3' class='hvstup_tzlte' align='left'>
<?php
if( $cinnost == 8 )
     {
?>
<a href="#" onClick="window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_zapocet.php?preuct=<?php echo $preuct;?>&cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
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
