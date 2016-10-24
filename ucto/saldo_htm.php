<HTML>
<?php
//VYTLACI SALDOKONTO VO FORMATE PDF
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
$h_drtx = strip_tags($_REQUEST['h_drtx']);
//echo "penpe".$h_penp;
if( $h_drtx == 1 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_uctupvtext SET upop='$h_penp' ";
if( $copern == 2009 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctupvtext SET upoz='$h_penp' ";  }
  }
if( $h_drtx == 2 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_uctupvtext SET penp='$h_penp' ";
if( $copern == 2009 ) { $sqtoz = "UPDATE F$kli_vxcf"."_uctupvtext SET penz='$h_penp' ";  }
  }
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
$copern=11;
}
//koniec uprava textov pred a za

//ulozenie upop
if( $copern == 1011 )
{
$n_upop = $_REQUEST['h_upop'];
$n_upop=str_replace("<br />","\r",$n_upop);

$ttvv = "UPDATE F$kli_vxcf"."_uctupvtext SET upop='$n_upop' ";
$ttqq = mysql_query("$ttvv");

$copern=11;
}
//koniec ulozenie upop

//ulozenie upoz
if( $copern == 2011 )
{
$n_upoz = $_REQUEST['h_upoz'];
$n_upoz=str_replace("<br />","\r",$n_upoz);

$ttvv = "UPDATE F$kli_vxcf"."_uctupvtext SET upoz='$n_upoz' ";
$ttqq = mysql_query("$ttvv");

$copern=11;
}
//koniec ulozenie upoz

//ulozenie penp
if( $copern == 3011 )
{
$n_penp = $_REQUEST['h_penp'];
$n_penp=str_replace("<br />","\r",$n_penp);

$ttvv = "UPDATE F$kli_vxcf"."_uctupvtext SET penp='$n_penp' ";
$ttqq = mysql_query("$ttvv");

$copern=11;
}
//koniec ulozenie penp

//ulozenie penz
if( $copern == 4011 )
{
$n_penz = $_REQUEST['h_penz'];
$n_penz=str_replace("<br />","\r",$n_penz);

$ttvv = "UPDATE F$kli_vxcf"."_uctupvtext SET penz='$n_penz' ";
$ttqq = mysql_query("$ttvv");

$copern=11;
}
//koniec ulozenie penz

if( $copern == 11 ) { $copern=10; $vsetko=0; }
$drupoh = 1*$_REQUEST['drupoh'];
$cinnost = 1*$_REQUEST['cinnost'];
$dobropis = 1*$_REQUEST['dobropis'];
$dobropi2 = 1*$_REQUEST['dobropi2'];
if( $dobropis == 2 ) { $dobropis=0; $dobropi2=1; }

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

$h_spl = 1*$_REQUEST['h_spl'];
$h_dsp = strip_tags($_REQUEST['h_dsp']);

//echo $h_spl;

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tabulka na ulozenie textov upomienky,penale
if( $cinnost == 1 )
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
  //$h_upop=htmlspecialchars($riaddok->upop);
  //$h_upop=addcslashes($riaddok->upop, '\0..\37');
  //$h_upop=htmlentities($riaddok->upop);
  $h_upop=$riaddok->upop;
  $h_upop=str_replace("\r","<br />",$h_upop);

  //echo $h_upop;
  $h_upoz=$riaddok->upoz;
  $h_upoz=str_replace("\r","<br />",$h_upoz);

  $h_penp=$riaddok->penp;
  $h_penp=str_replace("\r","<br />",$h_penp);
  $h_penz=$riaddok->penz;
  $h_penz=str_replace("\r","<br />",$h_penz);
  }
}
//koniec tabulky na ulozenie textov upomienky,penale

//tabulka na ulozenie proti a vseob
if( $cinnost == 9 )
{
$sql = "SELECT * FROM F$kli_vxcf"."_uctsparvseob".$kli_uzid;
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

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctsparvseob'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctsparvseob".$kli_uzid." ( proti,vseob,prmx1,prmt1 ) VALUES ( '39500', '2001', '0', 'text' )";
$ttqq = mysql_query("$ttvv");
}

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctsparvseob".$kli_uzid);
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $proti=$riaddok->proti;
  $vseob=$riaddok->vseob;
  }
}
//koniec tabulky na ulozenie proti a vseob

//sparuj uhradu a fakturu
if( $copern == 1111 )
{
$proti = 1*$_REQUEST['proti'];
$vseob = 1*$_REQUEST['vseob'];
//echo "proti ".$proti." vseob ".$vseob;
//echo "strana".$cislo_strana;
//echo "strank".$cislo_strank;
//exit;

$nasiel=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctsparovanie".$kli_uzid." WHERE sparuj=1";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $xfak_fak=$riaddok->fak_fak;
  $xfak_ico=$riaddok->fak_ico;
  $xfak_dok=$riaddok->fak_dok;
  $xfak_druh=$riaddok->fak_druh;
  $xuhr_ico=$riaddok->uhr_ico;
  $xuhr_fak=$riaddok->uhr_fak;
  $xuhr_dok=$riaddok->uhr_dok;
  $xuhr_druh=$riaddok->uhr_druh;
  $xuhr_suma=$riaddok->uhr_suma;
  $nasiel=1;
  }

if( $nasiel == 1 )
  {
//prepis vsy uhrady na faktuy a povodny daj do poznamky
    if( $xuhr_druh == 13 )
      {
$dsqlt = "UPDATE F$kli_vxcf"."_uctban SET  pop = CONCAT( pop, ' PF', fak ) WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctban SET  fak='$xfak_fak' WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
      }
    if( $xuhr_druh == 14 )
      {
$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET  pop = CONCAT( pop, ' PF', fak ) WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctvsdp SET  fak='$xfak_fak' WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
      }
    if( $xuhr_druh == 11 OR $xuhr_druh == 12 )
      {
$dsqlt = "UPDATE F$kli_vxcf"."_uctpokuct SET  pop = CONCAT( pop, ' PF', fak ) WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctpokuct SET  fak='$xfak_fak' WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
      }
    if( $xuhr_druh >= 11 AND $xuhr_druh <= 14 )
      {
$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofak$kli_uzid SET uhr=uhr-'$xuhr_suma', zos=zos+'$xuhr_suma' WHERE fak = $xfak_fak AND ico = $xfak_ico AND dok = $xfak_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
$dobropis=0;
      }
//preuctuj dobropis na cielovu fakturu
    if( $xuhr_druh == 5 )
      {
//echo "robim dobropis";
//" ( dok,poh,cpl,ucm,ucd,rdp,dph,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ";

$ttvv = "INSERT INTO F$kli_vxcf"."_uctvsdp ".
" ( dok,poh,cpl,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ".
" VALUES ( '$vseob', '0', '0', '$h_uce', '$proti', '1', '0', -('$xuhr_suma'), '0', '0', ' ', '0', '$xuhr_ico', '$xuhr_fak', '', '0', '0', '', '$kli_uzid'  )";
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctvsdp ".
" ( dok,poh,cpl,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ".
" VALUES ( '$vseob', '0', '0', '$h_uce', '$proti', '1', '0', '$xuhr_suma', '0', '0', ' ', '0', '$xfak_ico', '$xfak_fak', '', '0', '0', '', '$kli_uzid'  )";
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofak$kli_uzid SET hod=hod+'$xuhr_suma', zos=zos+'$xuhr_suma' WHERE fak = $xfak_fak AND ico = $xfak_ico AND dok = $xfak_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
$dobropis=1;

$ttvv = "UPDATE F$kli_vxcf"."_uctsparvseob".$kli_uzid." SET proti='$proti', vseob='$vseob' ";
$ttqq = mysql_query("$ttvv");
      }

    if( $xuhr_druh == 6 )
      {
//echo "robim dobropis";
//" ( dok,poh,cpl,ucm,ucd,rdp,dph,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ";

$ttvv = "INSERT INTO F$kli_vxcf"."_uctvsdp ".
" ( dok,poh,cpl,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ".
" VALUES ( '$vseob', '0', '0', '$proti', '$h_uce', '1', '0', -('$xuhr_suma'), '0', '0', ' ', '0', '$xuhr_ico', '$xuhr_fak', '', '0', '0', '', '$kli_uzid'  )";
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctvsdp ".
" ( dok,poh,cpl,ucm,ucd,rdp,dph,hod,hodm,kurz,mena,zmen,ico,fak,pop,str,zak,unk,id ) ".
" VALUES ( '$vseob', '0', '0', '$proti', '$h_uce', '1', '0', '$xuhr_suma', '0', '0', ' ', '0', '$xfak_ico', '$xfak_fak', '', '0', '0', '', '$kli_uzid'  )";
//echo $ttvv;
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE F$kli_vxcf"."_prsaldoicofak$kli_uzid SET hod=hod+'$xuhr_suma', zos=zos+'$xuhr_suma' WHERE fak = $xfak_fak AND ico = $xfak_ico AND dok = $xfak_dok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofak$kli_uzid WHERE fak = $xuhr_fak AND ico = $xuhr_ico AND dok = $xuhr_dok ";
$dsql = mysql_query("$dsqlt");
$dobropis=1;

$ttvv = "UPDATE F$kli_vxcf"."_uctsparvseob".$kli_uzid." SET proti='$proti', vseob='$vseob' ";
$ttqq = mysql_query("$ttvv");
      }

  }
include("../ucto/saldo_zmaz_ok.php");


$copern=10; 
$vsetko=0;
}
//koniec sparovania faktury a uhrady

//zmaz polozku zo zoznamu
if( $copern == 316 )
{
if( $cinnost == 1 ) {
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofakp$kli_uzid WHERE fak = $cislo_fak AND ico = $cislo_ico ";
$dsql = mysql_query("$dsqlt");
                    }
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

$ttvv = "UPDATE F$kli_vxcf"."_uctsparvseob".$kli_uzid." SET proti='$h_proti', vseob='$h_vseob' ";
$ttqq = mysql_query("$ttvv");

$vseob=$h_vseob;
$proti=$h_proti;

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}

/////////////////////////////////////////////////////////////// LEN AK NIEJE copern316
if( $copern != 316 )
          {

if (File_Exists ("../tmp/dsaldo.$kli_uzid.pdf")) { $soubor = unlink("../tmp/dsaldo.$kli_uzid.pdf"); }

$ajspat = 1*$_REQUEST['ajspat'];
if( $ajspat == 1 ) {

$pdfx = $_REQUEST['pdfx'];
//echo $pdfx;
//exit;

if (File_Exists ("../tmp/dsaldo.$cislo_fak.$kli_uzid.pdf")) { $soubor = unlink("../tmp/dsaldo.$cislo_fak.$kli_uzid.pdf"); }
                   }

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
if ( ( $drupoh == 1 AND $h_ico == 0 ) OR ( $cinnost == 1 AND $h_ico != 0 ) )
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


//zober vsetky za jednu fakturu
if ( $drupoh == 2 AND $vsetko == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldo$kli_uzid.fak = $cislo_fak AND F$kli_vxcf"."_prsaldo$kli_uzid.ico = $h_ico ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec zober vsetky za jednu fakturu

//zober vsetky za vsetky faktury
if ( $drupoh == 4 AND $vsetko == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,1,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,hod,uhr,zos,dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldo$kli_uzid.fak >= 0 AND F$kli_vxcf"."_prsaldo$kli_uzid.ico >= 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;
}
//koniec zober vsetky za vsetky faktury

//exit;

////////////////////////////////////////////////////////////koniec nastavenia co brat


//ak penalizovat len niektore
if( $cinnost == 1 AND $h_spl > 0 )
{

if( $h_spl == 1 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE zos > 0 AND  pox = 1 "; }
if( $h_spl == 2 ) { $dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE zos <= 0 AND pox = 1 "; }
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid WHERE pox = 999 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,999,drupoh,uce,puc,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE uce != 0 ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");

$tabl="prsaldoico".$kli_uzid;
$uctpol="prsaldoicofaknesp".$kli_uzid;

$copern=316;
}


////////////////////////////////////////////////////////////kolko po splatnosti

$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$sqtoz = "UPDATE F$kli_vxcf"."_$uctpol SET puc=TO_DAYS('$dnes')-TO_DAYS(das) WHERE hod != 0";
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


//ak vsetky pri upomienkach prepni na ovladanie upomienok
if( $vsetko == 1 AND $cinnost == 1 ) { $vsetko=0; }

?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Saldo HTML</title>
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

<?php
if ( $cinnost == 9 )
{
?>
<script type="text/javascript" src="spar_uhrada_xml.js"></script>
<script type="text/javascript" src="spar_faktura_xml.js"></script>
<?php
}
?>

<script type="text/javascript">


function ZmazUpom(ico,fak,strana)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;

window.open('../ucto/saldo_htm.php?copern=316&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak + '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );
                }

function UpomFak(ico,fak,strana)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var h_pen = document.forms.forms2.h_pen.value;
var h_ppe = document.forms.forms2.h_ppe.value;

window.open('../ucto/upomienka.php?copern=10&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
  '&h_pen=' + h_pen +  '&h_ppe=' + h_ppe +
 '&h_spl=<?php echo $h_spl; ?>&h_dsp=<?php echo $h_dsp; ?>
&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

function UpomIco(ico,fak,strana)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var h_pen = document.forms.forms2.h_pen.value;
var h_ppe = document.forms.forms2.h_ppe.value;

window.open('../ucto/upomienka.php?copern=20&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
  '&h_pen=' + h_pen +  '&h_ppe=' + h_ppe +
 '&h_spl=<?php echo $h_spl; ?>&h_dsp=<?php echo $h_dsp; ?>
&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

function MailIco(ico,fak,strana)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var h_pen = document.forms.forms2.h_pen.value;
var h_ppe = document.forms.forms2.h_ppe.value;

window.open('../ucto/upomienka.php?copern=20&posem=1&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
  '&h_pen=' + h_pen +  '&h_ppe=' + h_ppe +
 '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>',
 '_blank', 'width=800, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes'  );
                }

function NieKtejtoFak(ico,fak,dok,strana,druh)
                {
var fak_ico = ico;
var fak_fak = fak;
var fak_dok = dok;
var fak_druh = druh;
var cislo_strana = strana;
var dajid = "FA" + fak_ico + fak_fak + fak_dok; 

  myFak = document.getElementById( dajid );
  var htmlfak = fak_fak + " ";
  htmlfak += " <img border=0 src='../obr/vlozit.png' style='width:15; height:15;' ";
  htmlfak += " title='S touto Fakt˙rou sp·rovaù ˙hradu' ";
  htmlfak += " onClick=\"KtejtoFak(" + fak_ico + "," + fak_fak + "," + fak_dok + "," + cislo_strana + "," + fak_druh + ");\"> ";

  myFak.innerHTML = htmlfak;
  myFak.className='nekliknute';

  myStrana1 = document.getElementById("divstrana1");
  var htmlstrana = "éiadna vybran· fakt˙ra";
  myStrana1.innerHTML = htmlstrana;
  myStrana1.className='strana';
  myStrana2 = document.getElementById("divstrana2");
  myStrana2.innerHTML = htmlstrana;
  myStrana2.className='strana';
  myStrana3 = document.getElementById("divstrana3");
  myStrana3.innerHTML = htmlstrana;
  myStrana3.className='strana';

var fak_ico = 0;
var fak_fak = 0;
var fak_dok = 0;
var fak_druh = 0;

//znuluj cislo faktury na servery
UlozFakturu(fak_ico,fak_fak,fak_dok,cislo_strana,fak_druh);
                }

function KtejtoFak(ico,fak,dok,strana,druh)
                {

var fak_ico = ico;
var fak_fak = fak;
var fak_dok = dok;
var fak_druh = druh;
var cislo_strana = strana;
var dajid = "FA" + fak_ico + fak_fak + fak_dok; 

  myFak = document.getElementById( dajid );
  var htmlfak = fak_fak + " ";
  htmlfak += " <img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' ";
  htmlfak += " title='S touto Fakt˙rou nesp·rovaù ˙hradu' ";
  htmlfak += " onClick=\"NieKtejtoFak(" + fak_ico + "," + fak_fak + "," + fak_dok + "," + cislo_strana + "," + fak_druh + ");\"> ";

  myFak.innerHTML = htmlfak;
  myFak.className='kliknute';

  myStrana1 = document.getElementById("divstrana1");
  var htmlstrana = " PRIRADIç K FAKT⁄RE - doklad ËÌslo " + fak_dok + " I»O " + fak_ico + " Fakt˙ra " + fak_fak;
  myStrana1.innerHTML = htmlstrana;
  myStrana1.className='strana';
  myStrana2 = document.getElementById("divstrana2");
  myStrana2.innerHTML = htmlstrana;
  myStrana2.className='strana';
  myStrana3 = document.getElementById("divstrana3");
  myStrana3.innerHTML = htmlstrana;
  myStrana3.className='strana';

//posli cislo faktury na server
UlozFakturu(fak_ico,fak_fak,fak_dok,cislo_strana,fak_druh);
                }

function TutoUhradu(ico,fak,dok,strana,druh,suma)
                {
var uhr_ico = ico;
var uhr_fak = fak;
var uhr_dok = dok;
var uhr_druh = druh;
var uhr_sum = suma;
var cislo_strana = strana;
var dajid = "UH" + uhr_ico + uhr_fak + uhr_dok; 
//var dajid = "UH3141962329000011";

  myUhrad = document.getElementById( dajid );
  //myUhrad = document.getElementById("UH3141962329000011");
  var htmluhr = uhr_fak + " ";
  htmluhr += " <img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' ";
  htmluhr += " title='T˙to ˙hradu nesp·rovaù' ";
  htmluhr += " onClick=\"NieTutoUhradu(" + uhr_ico + "," + uhr_fak + "," + uhr_dok + "," + cislo_strana + "," + uhr_druh + "," + uhr_sum + ");\"> ";

  myUhrad.innerHTML = htmluhr;
  myUhrad.className='kliknute';

 
  myStrana1 = document.getElementById("divstrana1");
  var htmlstrana = "⁄HRADA - doklad ËÌslo " + uhr_dok + " I»O " + uhr_ico + " Fakt˙ra " + uhr_fak;
  myStrana1.innerHTML = htmlstrana;
  myStrana1.className='strana';
  myStrana2 = document.getElementById("divstrana2");
  myStrana2.innerHTML = htmlstrana;
  myStrana2.className='strana';
  myStrana3 = document.getElementById("divstrana3");
  myStrana3.innerHTML = htmlstrana;
  myStrana3.className='strana';

//posli cislo uhrady na server
UlozUhradu(uhr_ico,uhr_fak,uhr_dok,cislo_strana,uhr_druh,uhr_sum);

                }

function NieTutoUhradu(ico,fak,dok,strana,druh,suma)
                {
var uhr_ico = ico;
var uhr_fak = fak;
var uhr_dok = dok;
var uhr_druh = druh;
var uhr_sum = suma;
var cislo_strana = strana;
var dajid = "UH" + uhr_ico + uhr_fak + uhr_dok; 

  myUhrad = document.getElementById( dajid );
  var htmluhr = uhr_fak + " ";
  htmluhr += " <img border=0 src='../obr/ziarovka.png' style='width:15; height:15;' ";
  htmluhr += " title='T˙to ˙hradu sp·rovaù' ";
  htmluhr += " onClick=\"TutoUhradu(" + uhr_ico + "," + uhr_fak + "," + uhr_dok + "," + cislo_strana + "," + uhr_druh + "," + uhr_sum +  ");\"> ";

  myUhrad.innerHTML = htmluhr;
  myUhrad.className='nekliknute';

  myStrana1 = document.getElementById("divstrana1");
  var htmlstrana = "éiadna vybran· ˙hrada";
  myStrana1.innerHTML = htmlstrana;
  myStrana1.className='strana';
  myStrana2 = document.getElementById("divstrana2");
  myStrana2.innerHTML = htmlstrana;
  myStrana2.className='strana';
  myStrana3 = document.getElementById("divstrana3");
  myStrana3.innerHTML = htmlstrana;
  myStrana3.className='strana';

var uhr_ico = 0;
var uhr_fak = 0;
var uhr_dok = 0;
var uhr_druh = 0;
var uhr_sum = 0;

//znuluj cislo uhrady na servery
UlozUhradu(uhr_ico,uhr_fak,uhr_dok,cislo_strana,uhr_druh,uhr_sum);
                }


function SparujUHFA(ico,fak,dok,strana)
                {
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_htm.php?h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&cislo_strana=' + strana + '&proti=' + proti + '&vseob=' + vseob + '&copern=1111&drupoh=1&page=1&cinnost=9&dobropi2=<?php echo $dobropi2;?>', '_self' );
                }

function NastavZaciatok()
                {
var fak_ico = 0;
var fak_fak = 0;
var fak_dok = 0;
var uhr_ico = 0;
var uhr_fak = 0;
var uhr_dok = 0;
                }



function NastavVseob(ico,fak,strana,vseob)
                {
var cislo_ico = ico;
var cislo_fak = fak;
var cislo_strana = strana;
var proti = document.forms.formd2.proti.value;
var vseob = document.forms.formd2.vseob.value;

window.open('../ucto/saldo_htm.php?copern=418&cislo_strana=' + cislo_strana + '&cislo_ico=' + cislo_ico +  '&cislo_fak=' + cislo_fak +
 '&drupoh=<?php echo $drupoh; ?>&cinnost=<?php echo $cinnost; ?>&h_vseob=' + vseob + '&h_proti=' + proti + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=<?php echo $h_obd; ?>', '_self' );

                }

function PonukaUpomienka( ico )
                {
var h_ico = ico;

window.open('../ucto/ponuka_upomienka.php?uhr=1&pol=0&dea=0&h_ico=' + h_ico + '&copern=11&drupoh=1&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
    
</script>
</HEAD>
<BODY class="white" onload="NastavZaciatok();" >

<div id="textupop" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>
<div id="textupoz" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>
<div id="textpenp" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>
<div id="textpenz" style="cursor: hand; display: none; position: absolute; z-index: 400; top: 105; left: 30; width:960; height:400;"></div>

<table class="h2" width="100%" >
<tr>
<td>
<?php if( $cinnost != 9 AND $cinnost != 1 ) { echo "EuroSecom  -  Saldokonto HTML form·t"; } ?>
<?php if( $cinnost == 9 ) { echo "EuroSecom  -  RuËnÈ sp·rovanie a opravy saldokonta"; } ?>
<?php if( $cinnost == 1 ) { echo "EuroSecom  -  Upomienky, pen·le odberateæsk˝ch fakt˙r"; } ?>
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//text pred a za upo, pen
if ( $copern == 10 )
     {

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctupvtext ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);

  $h_penp1=$riaddok->upop;
  $h_penz1=$riaddok->upoz;
  $h_penp2=$riaddok->penp;
  $h_penz2=$riaddok->penz;
  }

?>
<div id="myTextElement" style="cursor: hand; display: none; position: absolute; z-index: 800; top: 190px; left: 20px; width:800px; height:200px;">
</div>

<div id="nastavtpx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 190px; left: 10px; width:800px; height:200px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='fhoddok' method='post' action='#' >
<td colspan='5'>Text Upomienka - pred poloûkami
<input type='hidden' name='druh' id='druh' >
<input type='hidden' name='drtx' id='drtx' >
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
<td colspan='5'>Text Upomienka - za poloûkami
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

<div id="pastavtpx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 190px; left: 10px; width:800px; height:200px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='phoddok' method='post' action='#' >
<td colspan='5'>Text Pen·le - pred poloûkami
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onClick='UlozPenp();' title='Uloû zmeny v texte' >

</td>
<td colspan='5' align='right'>

<img border=0 src='../obr/zmazuplne.png' style="width:15px; height:15px;" onClick="pastavtpx.style.display='none'; myTextElement.style.display='none';" title='Zhasni' >

</td></tr>  
                    
<tr><td colspan='10' class='obyc' align='left'>
<textarea name='h_penp' id='h_penp' rows='12' cols='118' ><?php echo $h_penp2; ?></textarea>
</td></tr>


</FORM></table>
</div>

<div id="pastavtzx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 190px; left: 10px; width:800px; height:200px;">
<table  class='ponuka' width='100%'>
<tr><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td>
<td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td><td width='10%'></td></tr>

<tr><FORM name='phoddoz' method='post' action='#' >
<td colspan='5'>Text Pen·le - za poloûkami
<img border=0 src='../obr/ok.png' style='width:15px; height:15px;' onClick='UlozPenz();' title='Uloû zmeny v texte' >

</td>
<td colspan='5' align='right'>

<img border=0 src='../obr/zmazuplne.png' style="width:15px; height:15px;" onClick="pastavtzx.style.display='none'; myTextElement.style.display='none';" title='Zhasni' >

</td></tr>  
                    
<tr><td colspan='10' class='obyc' align='left'>
<textarea name='h_penz' id='h_penz' rows='12' cols='118' ><?php echo $h_penz2; ?></textarea>
</td></tr>


</FORM></table>
</div>

<script type="text/javascript">

function RozniPenp(druh, drtx)
                {

  document.forms.fhoddok.drtx.value=drtx;
  document.forms.fhoddok.druh.value=1;

  if( drtx == 1 )
  {
  nastavtpx.style.display='';
  }
  if( drtx == 2 )
  {
  pastavtpx.style.display='';
  } 

                }

function RozniPenz(druh, drtx)
                {
  document.forms.fhoddok.drtx.value=drtx;
  document.forms.fhoddok.druh.value=2;

  if( drtx == 1 )
  {
  nastavtzx.style.display='';
  }
  if( drtx == 2 )
  {
  pastavtzx.style.display='';
  } 

                }


function UlozPenp()
                {
  nastavtpx.style.display='none';
  pastavtpx.style.display='none';
  var druh = document.forms.fhoddok.druh.value;
  var drtx = document.forms.fhoddok.drtx.value;                 

<?php if( $_SESSION['chrome'] == 0 ) { ?>
  var h_penpe = document.forms.fhoddok.h_penp.value.replace("\r","%0D%0A");
  if( drtx == 2 ) { h_penpe = document.forms.phoddok.h_penp.value.replace("\r","%0D%0A"); }
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
  if( drtx == 2 ) { h_penpe = document.forms.phoddok.h_penp.value.replace("\n","%0D%0A"); }
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

      if( druh == 1 ) { var copernx=2008; }
      if( druh == 2 ) { var copernx=2009; }

if( drtx == 1 )
 {
window.open('../ucto/saldo_htm.php?regpok=<?php echo $regpok; ?>&h_drtx=1&h_penp=' + h_penpe + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=0&copern=' + copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&cinnost=<?php echo $cinnost; ?>', '_self' );
 }
if( drtx == 2 )
 {
window.open('../ucto/saldo_htm.php?regpok=<?php echo $regpok; ?>&h_drtx=2&h_penp=' + h_penpe + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=0&copern=' + copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&cinnost=<?php echo $cinnost; ?>', '_self' );
 }
                }

function UlozPenz()
                {
  nastavtzx.style.display='none';
  pastavtzx.style.display='none';
  var druh = document.forms.fhoddok.druh.value;
  var drtx = document.forms.fhoddok.drtx.value;                

<?php if( $_SESSION['chrome'] == 0 ) { ?>
  var h_penpe = document.forms.fhoddoz.h_penz.value.replace("\r","%0D%0A");
  if( drtx == 2 ) { h_penpe = document.forms.phoddoz.h_penz.value.replace("\n","%0D%0A"); }
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
  if( drtx == 2 ) { h_penpe = document.forms.phoddoz.h_penz.value.replace("\n","%0D%0A"); }
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


      if( druh == 1 ) { var copernx=2008; }
      if( druh == 2 ) { var copernx=2009; }


if( drtx == 1 )
 {
window.open('../ucto/saldo_htm.php?regpok=<?php echo $regpok; ?>&h_drtx=1&h_penp=' + h_penpe + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=0&copern=' + copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&cinnost=<?php echo $cinnost; ?>', '_self' );
 }
if( drtx == 2 )
 {
window.open('../ucto/saldo_htm.php?regpok=<?php echo $regpok; ?>&h_drtx=2&h_penp=' + h_penpe + '&h_uce=<?php echo $h_uce; ?>&h_ico=<?php echo $h_ico; ?>&h_obd=0&copern=' + copernx + '&drupoh=<?php echo $drupoh; ?>&page=1&cinnost=<?php echo $cinnost; ?>', '_self' );
 }
                }


</script>
<?php
     }
//koniec text pred a za upo,pen
?>

<?php
///////////////////////////////////////////////////////////////////////////////pre jedno a vsetky ICO
if ( $copern == 10 AND $drupoh == 1 AND $h_ico >= 0 )
{

$strana=1;
//zaciatok vypisu tovaru

$podmucex="uce = $h_uce";
if( $cinnost == 1 AND $metalco == 1 )
{
$podmucex="( LEFT(uce,3) = 311 OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 314 )"; 
}

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE $podmucex ".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok,fak";

if ( $h_ico > 0 )
{
$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$uctpol.ico = $h_ico AND $podmucex ".
" ORDER BY nai,F$kli_vxcf"."_$uctpol.ico,pox,dat,dok,fak";

}

//echo $tovtt;
//exit;
$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

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
<a href="#" onClick="window.open('../ucto/saldo_htm.php?cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_htm.php?cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
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
<?php if( $cinnost == 9  AND $strana == $cislo_strana ) { ?>

<?php
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvsdp WHERE dok = $vseob ORDER BY cpl";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

$ip=0;
  while ($ip <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$ip))
{
$rsluz=mysql_fetch_object($sluz);
?>
<?php if( $ip == 0 ) { ?>
<table  class='fmenu' width='100%'>
<tr>
<td width='10%' align='right'>Doklad</td>
<td width='10%' align='right'>UCM</td>
<td width='10%' align='right'>UCD</td>
<td width='10%' align='right'>Fakt˙ra</td>
<td width='10%' align='right'>I»O</td>
<td width='10%' align='right'>Hodnota</td>
<td width='10%' align='right'>
<a href='vspk_u.php?sysx=UCT&rozuct=NIE&copern=8&drupoh=5&page=1&h_tlsl=1&rozb1=NOT&rozb2=NOT&cislo_dok=<?php echo $vseob;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="⁄prava dokladu" ></a>
</td>
</tr>
<?php                } ?>
<tr>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->dok; ?></td>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->ucm; ?></td>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->ucd; ?></td>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->fak; ?></td>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->ico; ?></td>
<td width='10%' align='right' class="fmenu" ><?php echo $rsluz->hod; ?></td>
</tr>
<?php
}
$ip = $ip + 1;
  }
?>
<?php                                                   } ?>

<table  class='fmenu' width='100%'>
<?php if( $cinnost == 1  AND $strana == $cislo_strana ) { ?>
<tr>
<FORM name="forms2" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="4">
<select size="1" name="h_pen" id="h_pen" >
<option value="0" >Upomienka </option>
<option value="1" >PenalizaËn· fakt˙ra</option>
<option value="2" >Ods˙hlasenie fakt˙r</option>
</select>
 %Pen·le ppa: 
 <input type="text" name="h_ppe" id="h_ppe" size="10"  />
<td class="hmenu" colspan="2">
<td class="hmenu" colspan="2">
<td class="hmenu" colspan="2">
UP<img src='../obr/zoznam.png' onClick="RozniPenp(1,1);" width=15 height=15 border=0 title='Text upomienky pred poloûkami' >
<img src='../obr/zoznam.png' onClick="RozniPenz(2,1);" width=15 height=15 border=0 title='Text upomienky za poloûkami' >
 PE<img src='../obr/orig.png' onClick="RozniPenp(1,2);" width=15 height=15 border=0 title='Text penalizaËnej fakt˙ry pred poloûkami' >
<img src='../obr/orig.png' onClick="RozniPenz(2,2);" width=15 height=15 border=0 title='Text penalizaËnej fakt˙ry za poloûkami' >
 ZU
<img src='../obr/tlac.png' onClick="PonukaUpomienka(0);" width=15 height=15 border=0 title='Zoznam vytvoren˝ch upomienok' >
</FORM>
<?php                     } ?>

<?php if( $cinnost == 9  AND $strana == $cislo_strana ) { 
$dnes = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dnes_sk=SkDatum($dnes);
?>
<tr>
<FORM name="formd2" class="obyc" method="post" action="#" >
<td class="hmenu" colspan="4">
 Proti˙Ëet pri pre˙ËtovanÌ: 
 <input type="text" name="proti" id="proti" size="10" value="<?php echo $proti;?>" />
 »Ìslo vöeob.dokladu: 
 <input type="text" name="vseob" id="vseob" size="10" value="<?php echo $vseob;?>" />
<img src='../obr/vlozit.png' width=15 height=12 border=1 
 onClick="NastavVseob(<?php echo $h_ico; ?>,0,<?php echo $strana; ?>,<?php echo $vseob; ?>);" 
 title='Nastaviù ËÌslo vöeobecnÈho dokladu' >
<td class="hmenu" colspan="2">
</FORM>
<?php                     } ?>

<tr>
<td colspan='4' align='left'>Saldokonto nesp·rovanÈ strana <?php echo $cislo_strana; ?> aû <?php echo $cislo_strank; ?></td>
<td colspan='1' align='left'>
<a href="#" onClick="window.open('../ucto/saldo_htm.php?cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_htm.php?cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/next.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_strand; ?>' ></a>
</td>
<td colspan='5' align='right'><?php echo "FIR".$kli_vxcf." ".$kli_nxcf." strana ".$strana; ?></td>
</tr> 
<tr>
<td colspan='2' align='left'>⁄Ëet: <?php echo $h_uce; ?></td>
<td colspan='2' align='left'>Obdobie: <?php echo $h_obdn; ?></td>
</tr> 
<?php $div1=0; $div2=0; $div3=0; if( $cinnost == 9  AND $strana == $cislo_stran1 ) { $div1=1; ?>
<tr><td colspan="10"><div id="divstrana1" >éiadna vybran· ˙hrada, strana <?php echo $strana; ?></div></td></tr>
<?php                     } ?>
<?php if( $cinnost == 9  AND $strana == $cislo_stran2 ) {  $div2=1; ?>
<tr><td colspan="10"><div id="divstrana2" >éiadna vybran· ˙hrada, strana <?php echo $strana; ?></div></td></tr>
<?php                     } ?>
<?php if( $cinnost == 9  AND $strana == $cislo_stran3 ) {  $div3=1; ?>
<tr><td colspan="10"><div id="divstrana3" >éiadna vybran· ˙hrada, strana <?php echo $strana; ?></div></td></tr>
<?php                     } ?>
<tr>
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
if( $cinnost == 1 )
           {
?>
<img src='../obr/pdf.png' width=10 height=10 border=1 
onClick="UpomFak(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>);"
 title='Vytvoriù PDF upomienku,pen·le pre doklad <?php echo $rtov->dok; ?>' >
<?php
           }
?>
<?php echo $pospl; ?></td>
<td class='hvstup' align='right' >
<?php  if ( $cinnost == 9 AND $rtov->drupoh >= 11 AND $rtov->drupoh <= 13 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='UH".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $rtov->drupoh == 14 AND $vsetko == 0 AND $dobropi2 == 0 )   { echo "<div class='nekliknute' id='UH".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 1 AND ( $rtov->drupoh == 5 OR $rtov->drupoh == 6 ) AND $rtov->hod < 0 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='UH".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 1 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $rtov->hod >= 0 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='FA".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 0 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $vsetko == 0 )   { echo "<div class='nekliknute' id='FA".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>
<?php  if ( $cinnost == 9 AND $rtov->drupoh == 14 AND $vsetko == 0 AND $dobropi2 == 1 )      { echo "<div class='nekliknute' id='FA".$rtov->ico.$rtov->fak.$rtov->dok."' >"; } ?>  

<?php echo $rtov->fak; ?>
<?php
if( $cinnost == 1 )
           {
?>
<img src='../obr/zmazuplne.png' width=10 height=10 border=0 
 onClick="ZmazUpom(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>);" 
 title='Zmazaù poloûku z upomienky, NIE zo saldokonta ani z ˙Ëtovania' >
<?php
           }
?>
<?php  if ( $cinnost == 9 ) { $jediv=0; } ?>
<?php  if ( $cinnost == 9 AND $dobropis == 1 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $rtov->hod >= 0 AND $vsetko == 0 )   { ?>
<img border=0 src='../obr/vlozit.png' style='width:15; height:15;' 
 title='S touto Fakt˙rou sp·rovaù ˙hradu,dobropis ' 
 onClick="KtejtoFak(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $rtov->dok; ?>,<?php echo $strana; ?>,<?php echo $rtov->drupoh; ?>);">
<?php  $jediv=1;                            } ?>

<?php  if ( $cinnost == 9 AND $dobropis == 0 AND $rtov->drupoh >= 5 AND $rtov->drupoh <= 8 AND $vsetko == 0 )   { ?>
<img border=0 src='../obr/vlozit.png' style='width:15; height:15;' 
 title='S touto Fakt˙rou sp·rovaù ˙hradu ' 
 onClick="KtejtoFak(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $rtov->dok; ?>,<?php echo $strana; ?>,<?php echo $rtov->drupoh; ?>);">
<?php  $jediv=1;                            } ?>

<?php  if ( $cinnost == 9 AND $rtov->drupoh >= 11 AND $rtov->drupoh <= 13 AND $vsetko == 0 )   { ?>
<img border=0 src='../obr/ziarovka.png' style='width:15; height:15;'
 title='T˙to ˙hradu sp·rovaù' 
 onClick="TutoUhradu(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $rtov->dok; ?>,<?php echo $strana; ?>,<?php echo $rtov->drupoh; ?>,<?php echo $rtov->zos; ?>);">
<?php  $jediv=1;                            } ?>

<?php  if ( $cinnost == 9 AND $rtov->drupoh == 14 AND $vsetko == 0 AND $dobropi2 == 0 )   { ?>
<img border=0 src='../obr/ziarovka.png' style='width:15; height:15;'
 title='T˙to ˙hradu sp·rovaù' 
 onClick="TutoUhradu(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $rtov->dok; ?>,<?php echo $strana; ?>,<?php echo $rtov->drupoh; ?>,<?php echo $rtov->zos; ?>);">
<?php  $jediv=1;                            } ?>

<?php  if ( $cinnost == 9 AND $dobropis == 1 AND ( $rtov->drupoh == 5 OR $rtov->drupoh == 6 ) AND $rtov->hod < 0 AND $vsetko == 0 )   { ?>
<img border=0 src='../obr/ziarovka.png' style='width:15; height:15;'
 title='Tento dobropis sp·rovaù' 
 onClick="TutoUhradu(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $rtov->dok; ?>,<?php echo $strana; ?>,<?php echo $rtov->drupoh; ?>,<?php echo $rtov->zos; ?>);">
<?php  $jediv=1;                            } ?>

<?php  if ( $cinnost == 9 AND $dobropis == 0 AND $rtov->drupoh == 14 AND $vsetko == 0 AND $dobropi2 == 1 )   { ?>
<img border=0 src='../obr/vlozit.png' style='width:15; height:15;' 
 title='S t˝mto Vöeob.dokladom sp·rovaù ˙hradu ' 
 onClick="KtejtoFak(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $rtov->dok; ?>,<?php echo $strana; ?>,<?php echo $rtov->drupoh; ?>);">
<?php  $jediv=1;                            } ?>

<?php  if ( $cinnost == 9 AND $jediv == 1 )   { echo "</div>"; } ?>
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
if( $cinnost == 1 )
           {
?>
<img src='../obr/pdf.png' width=10 height=10 border=1
onClick="UpomIco(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>);"
 title='Vytvoriù PDF upomienku,pen·le pre I»O <?php echo $rtov->ico; ?>' >

<img src='../obr/obalka.jpg' width=10 height=10 border=1
onClick="MailIco(<?php echo $rtov->ico; ?>,<?php echo $rtov->fak; ?>,<?php echo $strana; ?>);"
 title='Poslaù upomienku pre I»O <?php echo $rtov->ico; ?> e-mailom' >
<?php
           }
?>
CELKOM za I»O <?php echo $rtov->ico." ".$rtov->nai." ".$rtov->mes; ?>
<?php
if( $cinnost == 1 )
           {
?>
 <img src='../obr/tlac.png' onClick="PonukaUpomienka(<?php echo $rtov->ico; ?>);" width=15 height=15 border=0 title='Zoznam vytvoren˝ch upomienok pre I»O' >
<?php
           }
?>
</td>
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
$strankuj=1;
if( $h_ico > 0 AND $cinnost == 1 ) $strankuj=0;
if( $j >= 37 AND $strankuj == 1 ) { $j=0; $strana=$strana+1; }
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
if( $cinnost == 1 )
     {
?>
<a href="#" onClick="window.open('../ucto/saldo_htm.php?cislo_strana=<?php echo $cislo_stranp;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
 '_self' );">
<img src='../obr/prev.png' width=10 height=10 border=0 title='Strana <?php echo $cislo_stranp; ?>' ></a>
<a href="#" onClick="window.open('../ucto/saldo_htm.php?cislo_strana=<?php echo $cislo_strand;?>&h_uce=<?php echo $h_uce;?>&h_ico=<?php echo $h_ico;?>&h_obd=<?php echo $h_obd;?>&copern=11&drupoh=1&page=1&cinnost=<?php echo $cinnost; ?>',
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

<?php if( $cinnost == 9  AND $div2 == 0 ) {  $div2=1; ?>
<tr><td colspan="10"><div id="divstrana2" >éiadna vybran· ˙hrada, strana <?php echo $strana; ?></div></td></tr>
<?php                     } ?>
<?php if( $cinnost == 9  AND $div3 == 0 ) {  $div3=1; ?>
<tr><td colspan="10"><div id="divstrana3" >éiadna vybran· ˙hrada, strana <?php echo $strana; ?></div></td></tr>
<?php                     } ?>

<?php
}
//////////////////////////////////////////////////////////////////////////////////////////////////koniec pre jedno a vsetky ICO


////////////////////////////////////////////////////////////////////////////////pre jednu fakturu
if ( $copern == 12 AND $drupoh == 2 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_$tabl".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$tabl.ico=F$kli_vxcf"."_ico.ico".
" WHERE F$kli_vxcf"."_$tabl.ico = $h_ico AND uce = $h_uce".
"";

//echo $sqltt;
$sql = mysql_query("$sqltt");
     

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $hlavicka=mysql_fetch_object($sql);

$dat_sk=SkDatum($hlavicka->dat);
$strana=1;
$hod=0;
$uhr=0;
$zos=0;

//koniec hlavicka pred

//zaciatok vypisu tovaru

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" WHERE F$kli_vxcf"."_$uctpol.ico = $h_ico AND uce = $h_uce AND fak = $cislo_fak ".
" ORDER BY dat,dok";

//echo $tovtt;

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;

//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
  while ($i <= $tvpol )
  {

if ( $j == 0 )
      {

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(10);

if( $vsetko == 1 ) { $pdf->Cell(90,5,"Saldokonto za fakt˙ru $cislo_fak","LTB",0,"L"); }
if( $ajspat == 1 ) { 

$odkaz = $pdfx;

$pdf->Cell(20,5,"Sp‰ù","TB",0,"L",0,$odkaz); }

$pdf->Cell(0,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");

$pdf->Cell(180,2," ","0",1,"R");


$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";

$pdf->SetFont('arial','',8);
$pdf->Cell(40,4,"⁄Ëet: $h_uce","0",0,"L");
$pdf->Cell(90,4,"Obdobie: $h_obdn","0",1,"L");
$pdf->Cell(180,4,"I»O: $h_ico, $hlavicka->nai, $hlavicka->mes $hlavicka->tel $hlavicka->em1 ","0",1,"L");

$pdf->Cell(180,2," ","0",1,"R");

$pdf->Cell(15,4,"UME","1",0,"R");$pdf->Cell(20,4,"Doklad","1",0,"R");$pdf->Cell(20,4,"Vystaven·","1",0,"L");$pdf->Cell(20,4,"Splatn·","1",0,"L");
$pdf->Cell(10,4,"poSPL","1",0,"L");
$pdf->Cell(20,4,"Fakt˙ra","1",0,"R");$pdf->Cell(25,4,"Hodnota","1",0,"R");$pdf->Cell(25,4,"UhradenÈ","1",0,"R");$pdf->Cell(0,4,"Zostatok","1",1,"R");


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

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

//sumare napocet
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = $uhr + $rtov->uhr;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);

$pdf->Cell(15,4,"$rtov->ume","0",0,"R");$pdf->Cell(20,4,"$rtov->dok","0",0,"R");$pdf->Cell(20,4,"$dat_sk","0",0,"L");
if( $rtov->drupoh < 10 ) { $pdf->Cell(20,4,"$das_sk","0",0,"L"); }
if( $rtov->drupoh >= 10 ) { $pdf->Cell(20,4," ","0",0,"L"); }

if( $rtov->drupoh < 10 ) { $pdf->Cell(10,4,"$pospl","0",0,"L"); }
if( $rtov->drupoh >= 10 ) { $pdf->Cell(10,4," ","0",0,"L"); }

$pdf->Cell(20,4,"$rtov->fak","0",0,"R");
$pdf->Cell(25,4,"$rtov->hod","0",0,"R");$pdf->Cell(25,4,"$rtov->uhr","0",0,"R");$pdf->Cell(0,4,"$Szos","0",1,"R");
if( $rtov->poz != '' ) { $pdf->Cell(85,4," ","0",0,"R");$pdf->Cell(0,4,"$rtov->poz","0",1,"L"); $j=$j+1; }
}
$i = $i + 1;
$j = $j + 1;
if( $j >= 37 ) { $j=0; $strana=$strana+1; }
  }

           }
//koniec ak je tovar

$pdf->Cell(105,4,"SPOLU","T",0,"R");
$pdf->Cell(25,4,"$Shod","T",0,"R");$pdf->Cell(25,4,"$Suhr","T",0,"R");$pdf->Cell(0,4,"$Szos","T",1,"R");

  }
//koniec hlavicky pre jedno ICO

}
///////////////////////////////////////////////////////////////////////////////koniec pre jednu fakturu


////////////////////////////////////////////////////////////////////////////////pre  vsetky faktury polozkovite
if ( $copern == 14 AND $drupoh == 4 )
{
//sumar vsetko pox=999 a pox1=0
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,999,999,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,SUM(hod),SUM(uhr),SUM(zos)".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce = $h_uce GROUP BY pox";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vlozim tam sumar za kazdu fakturu ten mi bude nulovat napocet hod,uhr,zos pox=1 a pox1=1
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 1,0,1,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,0,0,0".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce = $h_uce GROUP BY ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//vlozim tam sumar za ico pox=10 a pox1=0
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,10,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,SUM(hod),SUM(uhr),SUM(zos)".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce = $h_uce GROUP BY ico";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//hlavicka ico pox=0 a pox1=0
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" SELECT 0,0,0,drupoh,uce,1,ume,dat,das,daz,dok,ico,fak,".
"poz,ksy,ssy,hdp,hdu,SUM(hod),SUM(uhr),SUM(zos)".
" FROM F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid".
" WHERE F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.pox = 1 AND F$kli_vxcf"."_prsaldoicofaknesp$kli_uzid.uce = $h_uce GROUP BY ico";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//zaciatok vypisu tovaru

$podmicoy="";
if( $h_ico > 0 ) { $podmicoy="F$kli_vxcf"."_$uctpol.ico = $h_ico AND "; }

$tovtt = "SELECT * FROM F$kli_vxcf"."_$uctpol".
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_$uctpol.ico=F$kli_vxcf"."_ico.ico".
" WHERE $podmicoy uce = $h_uce ".
" ORDER BY pox2,nai,F$kli_vxcf"."_$uctpol.ico,pox,fak,pox1,dat,dok";

//echo $tovtt;

$tov = mysql_query("$tovtt");
$tvpol = mysql_num_rows($tov);
if( $tvpol > 0 ) $jetovar=1;

if( $tvpol > 0 ) $nulovazostava=0;

//Ak je tovar
if( $jetovar == 1 )
           {
$i=0;
$j=0;
$strana=1;
  while ($i <= $tvpol )
  {

if ( $j == 0 )
      {

if( $vsetko == 1 ) { 

$datkdph_sk=SkDatum($datk_dph);
if( $h_obd == 0 ) $h_obdn="Vöetko";

?>
<table  class='fmenu' width='100%'>
<tr>
<td colspan='5' align='left'>Saldokonto poloûkovitÈ</td>
<td colspan='5' align='right'><?php echo "FIR".$kli_vxcf." ".$kli_nxcf." strana ".$strana; ?></td>
</tr> 
<tr>
<td colspan='2' align='left'>⁄Ëet: <?php echo $h_uce; ?></td>
<td colspan='2' align='left'>Obdobie: <?php echo $h_obdn; ?></td>
</tr> 
<tr>
<td width='7%' align='right'>UME</td>
<td width='10%' align='left'>Doklad</td>
<td width='7%' >Vystaven·</td>
<td width='7%' >Splatn·</td>
<td width='5%' >poSPL</td>
<td width='10%' align='right' >Fakt˙ra ËÌslo</td>
<td width='10%' align='right' >Hodnota</td>
<td width='10%' align='right' >⁄hrada</td>
<td width='29%'>Popis</td>
<td width='10%' align='right' >Zostatok</td>
</tr> 
<?php
                   }


if( $vsetko != 1 ) { 

?>
<tr>
<td colspan='10' align='left'>I»O: <?php echo $rtov->ico." ".$rtov->nai.", ".$rtov->mes." ".$rtov->tel." ".$rtov->em1; ?></td>
</tr> 
<?php
                   }


      }
//koniec j=0


  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$dat_sk=SkDatum($rtov->dat);
$das_sk=SkDatum($rtov->das);

$hhod = $rtov->hod;
if( $hhod == 0 ) $hhod="";
$Cislo=$hhod+"";
$Hhod=sprintf("%0.2f", $Cislo);
$huhr = $rtov->uhr;
if( $huhr == 0 ) $huhr="";
$Cislo=$huhr+"";
$Huhr=sprintf("%0.2f", $Cislo);
$hzos = $rtov->zos;
$Cislo=$hzos+"";
$Hzos=sprintf("%0.2f", $Cislo);

$pospl=$rtov->puc;
if( $pospl == 0 ) $pospl="";

//prva uroven faktury a uhrady
if( $rtov->pox == 1 AND $rtov->pox1 == 0 )      {

//sumare napocet
$hod = $hod + $rtov->hod;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = $uhr + $rtov->uhr;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = $zos + $rtov->zos;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);

if( $rtov->drupoh >= 10 ) { $das_sk=""; $pospl=""; }

?>
<tr>
<td class='hvstup' width='7%' align='right'><?php echo $rtov->ume; ?></td>
<td class='hvstup' width='10%' align='left'>
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
<td class='hvstup' width='7%' ><?php echo $dat_sk; ?></td>
<td class='hvstup' width='7%' ><?php echo $das_sk; ?></td>
<td class='hvstup' width='5%' ><?php echo $pospl; ?></td>
<td class='hvstup' width='10%' align='right' ><?php echo $rtov->fak; ?></td>
<td class='hvstup' width='10%' align='right' ><?php echo $hhod; ?></td>
<td class='hvstup' width='10%' align='right' ><?php echo $huhr; ?></td>
<td class='hvstup' width='29%'><?php echo $rtov->poz; ?></td>
<td class='hvstup' width='10%' align='right' ><?php echo $Szos; ?></td>
</tr> 
<?php
$j = $j + 1;

                           }
//koniec prva uroven faktury a uhrady

//sumar za fakturu bude mi nulovat sumar
if( $rtov->pox == 1 AND $rtov->pox1 == 1 )      {

//sumare napocet
$hod = 0;
$Cislo=$hod+"";
$Shod=sprintf("%0.2f", $Cislo);
$uhr = 0;
$Cislo=$uhr+"";
$Suhr=sprintf("%0.2f", $Cislo);
$zos = 0;
$Cislo=$zos+"";
$Szos=sprintf("%0.2f", $Cislo);

$pdf->Cell(20,4," ","0",1,"R");
$j=$j+1;

                           }
//koniec prva uroven faktury a uhrady


//hlavicka ico
if( $rtov->pox == 0 )      {

?>
<tr>
<td class='hvstup_zlte' colspan='10' align='left'>FIRMA I»O <?php echo $rtov->ico." ".$rtov->nai.", ".$rtov->mes." ".$rtov->tel." ".$rtov->em1; ?></td>
</tr> 
<?php
$j = $j + 1;

                           }
//koniec sumar za ico

//sumar za ico
if( $rtov->pox == 10 )      {

?>
<tr>
<td class='hvstup_tzlte' colspan='6' align='left'>CELKOM za I»O <?php echo $rtov->ico." ".$rtov->nai.", ".$rtov->mes; ?></td>

<td class='hvstup_tzlte' align='right' ><?php echo $rtov->hod; ?></td>
<td class='hvstup_tzlte' align='right' ><?php echo $rtov->uhr; ?></td>
<td class='hvstup_tzlte' > </td>
<td class='hvstup_tzlte' align='right' ><?php echo $rtov->zos; ?></td>
</tr> 
<?php
$j = $j + 1;

                           }
//koniec sumar za ico

//sumar vsetko
if( $rtov->pox2 == 999 )      {

?>
<tr>
<td class='hvstup_tzlte' colspan='6' align='left'>CELKOM za vöetky I»O</td>

<td class='hvstup_tzlte' align='right' ><?php echo $rtov->hod; ?></td>
<td class='hvstup_tzlte' align='right' ><?php echo $rtov->uhr; ?></td>
<td class='hvstup_tzlte' > </td>
<td class='hvstup_tzlte' align='right' ><?php echo $rtov->zos; ?></td>
</tr> 
<?php
$j = $j + 1;

                           }
//koniec sumar za ico

}
$i = $i + 1;
if( $j >= 37 ) { $j=0; $strana=$strana+1; }
  }

           }
//koniec ak je tovar

?>
</table>
<?php
}
///////////////////////////////////////////////////////////////////////////////koniec pre vsetky faktury polozkovite


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
if ( $drupoh == 2 AND $ajspat == 0 )
{
$pdf->Output("../tmp/dsaldo.$kli_uzid.pdf")
?>
<script type="text/javascript">
  var okno = window.open("../tmp/dsaldo.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php 
}
?>

<?php 
if ( $drupoh == 2 AND $ajspat == 1 )
{
$pdf->Output("../tmp/dsaldo.$cislo_fak.$kli_uzid.pdf")
?>
<script type="text/javascript">
  var okno = window.open("../tmp/dsaldo.<?php echo $cislo_fak; ?>.<?php echo $kli_uzid; ?>.pdf","_self");
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
