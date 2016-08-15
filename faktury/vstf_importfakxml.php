<?php

$zandroidu=1*$_REQUEST['zandroidu'];
if( $zandroidu == 1 )
  {
error_reporting(0);

//z delinfofak.php
//server
if (isset($_REQUEST['serverx'])) { $serverx = $_REQUEST['serverx']; }
$poles = explode("/", $serverx);
$servxxx=$poles[0];
$adrsxxx=$poles[1];

//userhash
$userhash = $_REQUEST['userhash'];

require_once('../androidfanti/MCrypt.php');
$mcrypt = new MCrypt();
//#Encrypt
//$encrypted = $mcrypt->encrypt("Text to encrypt");
$encrypted=$userhash;
#Decrypt
$userxplus = $mcrypt->decrypt($encrypted);

//user
//if (isset($_REQUEST['userx'])) { $userx = $_REQUEST['userx']; }
$userx=$userxplus;
$poleu = explode("/", $userx);
$nickxxx=$poleu[1];
$usidxxx=1*$poleu[3];
$pswdxxx=$poleu[5];
$fakx=1*$poleu[10];


//prmall firma a rok
if (isset($_REQUEST['prmall'])) { $prmall = $_REQUEST['prmall']; }
$poler = explode("/", $prmall);
$firxxx=1*$poler[1];
$kli_vrok=1*$poler[3];
$ftpqr=$poler[5];

// include db connect class
$dbcon="../".$adrsxxx."/db_connect.php";
require_once "$dbcon";
 
// connecting to db
$db = new DB_CONNECT();

//nastav databazu
$dbsed="../".$adrsxxx."/nastavdbase.php";
$sDat = include("$dbsed");
$databaza=$databaza.".";

$kli_vxcf=DB_FIR;
if( $firxxx > 0 ) { $kli_vxcf=$firxxx; }


// include mozem?
$cslm=910005;
$dbmoz="../androidfanti/mozem.php";
$sDat = include("$dbmoz");

if( $mozem == 0 ) { $icox=0; }

$ftpqrdecode=trim(urldecode($ftpqr));

$_REQUEST["odeslano"]=1;
$_REQUEST['copern']=1;
$kli_vxcf=126;
$_REQUEST['cislo_uce']=32100;

  }

if( $zandroidu == 0 )
  {
?>
<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
  }


       do
       {

if( $zandroidu == 0 )
    {
if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);
    }

// cislo operacie
//copern=1 z bankoveho
$copern = 1*$_REQUEST['copern'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$cislo_uce = 1*$_REQUEST['cislo_uce'];
$podvojne=1;
if( $kli_vduj == 9 ) { $podvojne=0; }


$citfir = include("../cis/citaj_fir.php");
//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//uloz polozku
if( $copern == 1003 )
{

  $h_xtel=strip_tags($_REQUEST['h_xtel']);
  $h_xpot=strip_tags($_REQUEST['h_xpot']);
  $h_unak=strip_tags($_REQUEST['h_unak']);
  $h_udph=strip_tags($_REQUEST['h_udph']);
  $h_ddph=strip_tags($_REQUEST['h_ddph']);
  $h_uonk=strip_tags($_REQUEST['h_uonk']);
  $h_uodp=strip_tags($_REQUEST['h_uodp']);
  $h_dodp=strip_tags($_REQUEST['h_dodp']);
  $h_podp=strip_tags($_REQUEST['h_podp']);
  $h_tstr=strip_tags($_REQUEST['h_tstr']);
  $h_tzak=strip_tags($_REQUEST['h_tzak']);
  $h_uonk0=strip_tags($_REQUEST['h_uonk0']);

$h_xtel=str_replace(" ","",$h_xtel);
$h_xtel=str_replace("/","",$h_xtel);

$ulozttt = "INSERT INTO F$kli_vxcf"."_uctimportfakxml ( xtel, xpot, unak, udph, ddph, uonk, uonk0, uodp, dodp, podp, tstr, tzak ) ".
" VALUES ( '$h_xtel', '$h_xpot', '$h_unak', '$h_udph', '$h_ddph', '$h_uonk', '$h_uonk0','$h_uodp', '$h_dodp', '$h_podp', '$h_tstr', '$h_tzak' ); ";
$vysledok = mysql_query("$ulozttt"); 

$copern=1001;
}
//koniec uloz polozku

$zmazanie=0;
//zmaz polozku
if( $copern == 1006 )
{
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_uctimportfakxml WHERE porx = $cislo_cpl");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $xtelx=$riadico->xtel;
  $xpotx=$riadico->xpot;
  $unakx=$riadico->unak;
  $udphx=$riadico->udph;
  $ddphx=$riadico->ddph;
  $uonkx=$riadico->uonk;
  $uonk0x=$riadico->uonk0;
  $uodpx=$riadico->uodp;
  $dodpx=$riadico->dodp;
  $podpx=$riadico->podp;
  $tstrx=$riadico->tstr;
  $tzakx=$riadico->tzak;
  $zmazanie=1;
  }


$ulozttt = "DELETE FROM F$kli_vxcf"."_uctimportfakxml WHERE porx = $cislo_cpl";
$vysledok = mysql_query("$ulozttt");

$copern=1001;
}
//koniec zmaz polozku



$sql = "SELECT uonk0 FROM F$kli_vxcf"."_uctimportfakxml  ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = "DROP TABLE F".$kli_vxcf."_uctimportfakxml ";
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   porx         int not null auto_increment,
   xtel         VARCHAR(30) NOT NULL,
   xpot         VARCHAR(40) NOT NULL,
   unak         VARCHAR(10) NOT NULL DEFAULT '51800',
   udph         VARCHAR(10) NOT NULL DEFAULT '34300',
   ddph         DECIMAL(4,0) DEFAULT 25,
   uonk0        VARCHAR(10) NOT NULL DEFAULT '51800',
   uonk         VARCHAR(10) NOT NULL DEFAULT '51899',
   uodp         VARCHAR(10) NOT NULL DEFAULT '34300',
   dodp         DECIMAL(4,0) DEFAULT 27,
   podp         DECIMAL(10,2) DEFAULT 0,
   tstr         DECIMAL(10,0) DEFAULT 0,
   tzak         DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(porx)
);
statistika_p1304;

$vsql = "CREATE TABLE F".$kli_vxcf."_uctimportfakxml ".$sqlt;
$vytvor = mysql_query("$vsql");

}


$vsql = "DROP TABLE F".$kli_vxcf."_importfakxml".$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$sql = "SELECT zkln FROM F$kli_vxcf"."_importfakxml".$kli_uzid." ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<statistika_p1304
(
   porc         int not null auto_increment,
   fak          VARCHAR(30) NOT NULL,
   vsy          VARCHAR(30) NOT NULL,
   tel          VARCHAR(30) NOT NULL,
   dat          DATE NOT NULL,
   daz          DATE NOT NULL,
   das          DATE NOT NULL,
   zkl0         DECIMAL(10,2) DEFAULT 0,
   zkl          DECIMAL(10,2) DEFAULT 0,
   dph          DECIMAL(10,2) DEFAULT 0,
   zklo         DECIMAL(10,2) DEFAULT 0,
   dpho         DECIMAL(10,2) DEFAULT 0,
   zklu         DECIMAL(10,2) DEFAULT 0,
   dphu         DECIMAL(10,2) DEFAULT 0,
   szd          DECIMAL(4,0) DEFAULT 0,
   cel          DECIMAL(10,2) DEFAULT 0,
   riadok       VARCHAR(250) NOT NULL,
   xpot         VARCHAR(40) NOT NULL,
   unak         VARCHAR(10) NOT NULL DEFAULT '51800',
   udph         VARCHAR(10) NOT NULL DEFAULT '34300',
   ddph         DECIMAL(4,0) DEFAULT 25,
   uonk0        VARCHAR(10) NOT NULL DEFAULT '51800',
   uonk         VARCHAR(10) NOT NULL DEFAULT '51899',
   uodp         VARCHAR(10) NOT NULL DEFAULT '34300',
   dodp         DECIMAL(4,0) DEFAULT 27,
   podp         DECIMAL(10,2) DEFAULT 0,
   tstr         DECIMAL(10,0) DEFAULT 0,
   tzak         DECIMAL(10,0) DEFAULT 0,
   zkln         DECIMAL(10,2) DEFAULT 0,
   dphn         DECIMAL(10,2) DEFAULT 0,
   PRIMARY KEY(porc)
);
statistika_p1304;

$vsql = "CREATE TABLE F".$kli_vxcf."_importfakxml".$kli_uzid." ".$sqlt;
$vytvor = mysql_query("$vsql");

}
$vsql = "DELETE FROM F".$kli_vxcf."_importfakxml".$kli_uzid." ";
$vytvor = mysql_query("$vsql");

$nazovsuboru="importfak".$kli_uzid.".xml";
$obsah="";
$i=1;

if( $zandroidu == 1 ) { $nazovsuboru="importfak17.xml"; }

if ($_REQUEST["odeslano"]==1) 
{     
  if (move_uploaded_file($_FILES['original']['tmp_name'], "../tmp/$nazovsuboru") OR $zandroidu == 1 ) 
  { 
//tu bude import

$subor = fopen("../tmp/$nazovsuboru", "r");
$riadok = fread($subor,filesize("../tmp/$nazovsuboru"));
fclose($subor);
 
//echo $riadok."<br />";

$pole = explode("<inv", $riadok);

$i=0;
foreach ($pole as &$value) {

//echo $value."<br />";

if( $i == 1 )
  {

$p1ico = explode("<ico>", $value);
$p2ico = explode("</ico>", $p1ico[1]);
$mojeico=1*$p2ico[0];

if( $mojeico != $fir_fico AND $zandroidu == 0 )
    {
echo "I»O odberateæa na fakt˙re ".$mojeico." nie je rovnakÈ ako I»O v ˙dajoch o firme ".$fir_fico;
exit;
    }


  }

//exit;

$p1ico = explode("<oico>", $value);
$p2ico = explode("</oico>", $p1ico[1]);
$tel=$p2ico[0];

$p1fak = explode("<fak>", $value);
$p2fak = explode("</fak>", $p1fak[1]);
$fak=$p2fak[0];

$p1fak = explode("<vsy>", $value);
$p2fak = explode("</vsy>", $p1fak[1]);
$vsy=$p2fak[0];

$p1dat = explode("<dat>", $value);
$p2dat = explode("</dat>", $p1dat[1]);
$datsql=$p2dat[0];
//$datsql=SqlDatum($datsk);

$p1daz = explode("<daz>", $value);
$p2daz = explode("</daz>", $p1daz[1]);
$dazsql=$p2daz[0];
//$dazsql=Sqldatum($dazsk);

$p1das = explode("<das>", $value);
$p2das = explode("</das>", $p1das[1]);
$dassql=$p2das[0];
//$dassql=SqlDatum($dassk);



$p1zkl = explode("<zk2>", $value);
$p2zkl = explode("</zk2>", $p1zkl[1]);
$zkl=$p2zkl[0];

$p1dph = explode("<dn2>", $value);
$p2dph = explode("</dn2>", $p1dph[1]);
$dph=$p2dph[0];

$p1zkl = explode("<zk1>", $value);
$p2zkl = explode("</zk1>", $p1zkl[1]);
$zkln=$p2zkl[0];

$p1dph = explode("<dn1>", $value);
$p2dph = explode("</dn1>", $p1dph[1]);
$dphn=$p2dph[0];

$p1zkl0 = explode("<zk0>", $value);
$p2zkl0 = explode("</zk0>", $p1zkl0[1]);
$zkl0=$p2zkl0[0];

$p1cel = explode("<hod>", $value);
$p2cel = explode("</hod>", $p1cel[1]);
$cel=$p2cel[0];



//echo $zkl0."\r\n";

$text=$value."\r\n";
if( $i > 0 ) 
    {

$vsql = "INSERT INTO F".$kli_vxcf."_importfakxml$kli_uzid ( riadok, fak, vsy, tel, dat, daz, das, zkl, dph, szd, cel, zkl0, zkln, dphn ) VALUES ".
" ( '$text', '$fak', '$vsy', '$tel', '$datsql', '$dazsql', '$dassql', '$zkl', '$dph', '$szd', '$cel', '$zkl0', '$zkln', '$dphn' ) ";
$vytvor = mysql_query("$vsql");

    }
//if i > 0

$i=$i+1;
}

fclose($soubox);


//exit;

$jedefault=0;
$sqlico = mysql_query("SELECT * FROM F$kli_vxcf"."_uctimportfakxml WHERE xtel = '' ");
  if (@$zaznam=mysql_data_seek($sqlico,0))
  {
  $riadico=mysql_fetch_object($sqlico);
  $xpotxx=$riadico->xpot;
  $unakxx=$riadico->unak;
  $udphxx=$riadico->udph;
  $ddphxx=$riadico->ddph;
  $uonkxx=$riadico->uonk;
  $uonk0xx=$riadico->uonk0;
  $uodpxx=$riadico->uodp;
  $dodpxx=$riadico->dodp;
  $podpxx=$riadico->podp;
  $tstrxx=$riadico->tstr;
  $tzakxx=$riadico->tzak;
  if( $unakxx > 0 ) { $jedefault=1; }
  }

$sqty = "UPDATE F$kli_vxcf"."_importfakxml$kli_uzid SET ".
" xpot='$xpotxx', ".
" unak='$unakxx', ".
" udph='$udphxx', ".
" ddph='$ddphxx', ".
" uonk='$uonkxx', ".
" uonk0='$uonk0xx', ".
" uodp='$uodpxx', ".
" dodp='$dodpxx', ".
" podp='$podpxx', ".
" tstr='$tstrxx', ".
" tzak='$tzakxx'  ";
//echo $sqty; 
if( $jedefault == 1 ) { $ulozene = mysql_query("$sqty"); }


$sqty = "UPDATE F$kli_vxcf"."_importfakxml$kli_uzid,F$kli_vxcf"."_uctimportfakxml SET ".
" F$kli_vxcf"."_importfakxml$kli_uzid.xpot=F$kli_vxcf"."_uctimportfakxml.xpot, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.unak=F$kli_vxcf"."_uctimportfakxml.unak, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.udph=F$kli_vxcf"."_uctimportfakxml.udph, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.ddph=F$kli_vxcf"."_uctimportfakxml.ddph, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.uonk=F$kli_vxcf"."_uctimportfakxml.uonk, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.uonk0=F$kli_vxcf"."_uctimportfakxml.uonk0, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.uodp=F$kli_vxcf"."_uctimportfakxml.uodp, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.dodp=F$kli_vxcf"."_uctimportfakxml.dodp, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.podp=F$kli_vxcf"."_uctimportfakxml.podp, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.tstr=F$kli_vxcf"."_uctimportfakxml.tstr, ".
" F$kli_vxcf"."_importfakxml$kli_uzid.tzak=F$kli_vxcf"."_uctimportfakxml.tzak  ".
" WHERE F$kli_vxcf"."_importfakxml$kli_uzid.tel=F$kli_vxcf"."_uctimportfakxml.xtel ";
//echo $sqty; 
$ulozene = mysql_query("$sqty");



$sqty = "UPDATE F$kli_vxcf"."_importfakxml$kli_uzid SET zklo=podp*zkl/100, dpho=podp*dph/100 WHERE podp > 0 ";
$ulozene = mysql_query("$sqty");
$sqty = "UPDATE F$kli_vxcf"."_importfakxml$kli_uzid SET zklu=zkl-zklo, dphu=dph-dpho WHERE porc > 0 ";
$ulozene = mysql_query("$sqty");

//exit;

          $ixx=0;
          $vyslettt = "SELECT * FROM F$kli_vxcf"."_importfakxml$kli_uzid WHERE porc > 0 ORDER BY tel ";
          $vysledok = mysql_query("$vyslettt");
          while ($riadok = mysql_fetch_object($vysledok))
          {
          //zaciatok cyklu



$cislo_new=0;
$sqldok2 = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdod WHERE dok > 0 ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok2,0))
  {
  $riaddok2=mysql_fetch_object($sqldok2);
  $cislo_new=$riaddok2->dok+1;
  }

$pole = explode("-", $datsql);
$kli_vmesx=$pole[1];
$kli_vrokx=$pole[0];

$ume=$kli_vmesx.".".$kli_vrokx;
$textp=$riadok->xpot;
$ico=$riadok->tel;

//fakdod uce	ume	dat	dav	das	daz	dok	doq	skl	poh	ico	fak	dol	prf	obj	unk	dpr	ksy	ssy	
//poz	str	zak	txz	txp	zk0	zk1	zk2	zk3	zk4	dn1	dn2	dn3	dn4	sp1	sp2	sz1	sz2	sz3	sz4	
//zk0u	zk1u	zk2u	dn1u	dn2u	sp0u	sp1u	sp2u	hodu	hod	hodm	kurz	mena	zmen	odbm	zal	zao	ruc	uhr	
//id	datm


$dsqlt = "INSERT INTO F$kli_vxcf"."_fakdod (uce, ume, dat, das, daz, sz4, dok, doq, ico, sz3, fak, txp, zk2, dn2, zk1, dn1, zk0, hod, id ) ".
" VALUES ".
" ( $cislo_uce, $ume, '$riadok->dat', '$riadok->das', '$riadok->daz', '$riadok->daz', $cislo_new, $cislo_new, '$ico', '$riadok->fak', '$riadok->vsy', '$textp', ".
"  '$riadok->zkl', '$riadok->dph', '$riadok->zkln', '$riadok->dphn', '$riadok->zkl0', '$riadok->cel', '$kli_uzid' )  ";
if( $ixx >= 0 ) { $dsql = mysql_query("$dsqlt"); }

$dsqlt = "UPDATE F$kli_vxcf"."_fakdod SET ".
" zk2u=zk2, dn2u=dn2, hodu=hod, sp2=zk2+dn2, sp2u=zk2+dn2, ".
" zk1u=zk1, dn1u=dn1, sp1=zk1+dn1, sp1u=zk1+dn1, zk0u=zk0, ".
" dol=0, prf=0, str=0, zak=0 ".
" WHERE dok = $cislo_new ";
$dsql = mysql_query("$dsqlt"); 

  $unak=1*$riadok->unak;
  $udph=1*$riadok->udph;
  $ddph=1*$riadok->ddph;
  $uonk=1*$riadok->uonk;
  $uonk0=1*$riadok->uonk0;
  $uodp=1*$riadok->uodp;
  $dodp=1*$riadok->dodp;
  $tstr=1*$riadok->tstr;
  $tzak=1*$riadok->tzak;

if( $unak == 0 ) { $unak=51800; }
if( $udph == 0 ) { $udph=34300; }
if( $ddph == 0 ) { $ddph=25; }
if( $uonk == 0 ) { $uonk=51899; }
if( $uonk0 == 0 ) { $uonk0=51800; }
if( $uodp == 0 ) { $uodp=34300; }
if( $dodp == 0 ) { $dodp=27; }
 
//uctdod dok	poh	cpl	ucm	ucd	rdp	dph	hod	ico	fak	pop	str	zak	unk	id	datm

if( $riadok->zklu != 0 )
{

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_new', '12', '$unak', '$cislo_uce', '$ddph', '0', '$riadok->zklu', '$ico', '$riadok->vsy', '', '$tstr',".
" '$tzak', '', '$kli_uzid' );"; 
if( $ixx >= 0 ) { $ulozene = mysql_query("$sqty"); } 
}


if( $riadok->dphu != 0 )
{

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_new', '12', '$udph', '$cislo_uce', '$ddph', '0', '$riadok->dphu', '$ico', '$riadok->vsy', '', '$tstr',".
" '$tzak', '', '$kli_uzid' );"; 
if( $ixx >= 0 ) { $ulozene = mysql_query("$sqty"); } 
}


if( $riadok->zklo != 0 )
{

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_new', '12', '$uonk', '$cislo_uce', '$dodp', '0', '$riadok->zklo', '$ico', '$riadok->vsy', '', '$tstr',".
" '$tzak', '', '$kli_uzid' );"; 
if( $ixx >= 0 ) { $ulozene = mysql_query("$sqty"); } 
}


if( $riadok->dpho != 0 )
{

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_new', '12', '$uodp', '$cislo_uce', '$dodp', '0', '$riadok->dpho', '$ico', '$riadok->vsy', '', '$tstr',".
" '$tzak', '', '$kli_uzid' );"; 
if( $ixx >= 0 ) { $ulozene = mysql_query("$sqty"); } 
}


if( $riadok->zkl0 != 0 )
{

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_new', '12', '$uonk0', '$cislo_uce', '1', '0', '$riadok->zkl0', '$ico', '$riadok->vsy', '', '$tstr',".
" '$tzak', '', '$kli_uzid' );"; 
if( $ixx >= 0 ) { $ulozene = mysql_query("$sqty"); } 
}


if( $riadok->zkln != 0 )
{

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_new', '12', '$unak', '$cislo_uce', '30', '0', '$riadok->zkln', '$ico', '$riadok->vsy', '', '$tstr',".
" '$tzak', '', '$kli_uzid' );"; 
if( $ixx >= 0 ) { $ulozene = mysql_query("$sqty"); } 
}


if( $riadok->dphn != 0 )
{

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$cislo_new', '12', '$udph', '$cislo_uce', '30', '0', '$riadok->dphn', '$ico', '$riadok->vsy', '', '$tstr',".
" '$tzak', '', '$kli_uzid' );"; 
if( $ixx >= 0 ) { $ulozene = mysql_query("$sqty"); } 
}


$ixx=$ixx+1;
          }
          //koniec cyklu




//exit;
//koniec importu
  }

}
//koniec if odeslano
if( $zandroidu == 0 )
  {

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Import IBAN xml</title>

<script type="text/javascript">

    function ObnovUI()
    {
<?php if( $zmazanie == 1 ) { ?>

    document.formv1.h_xtel.value = '<?php echo "$xtelx";?>';
    document.formv1.h_xpot.value = '<?php echo "$xpotx";?>';
    document.formv1.h_unak.value = '<?php echo "$unakx";?>';
    document.formv1.h_udph.value = '<?php echo "$udphx";?>';
    document.formv1.h_ddph.value = '<?php echo "$ddphx";?>';
    document.formv1.h_uonk.value = '<?php echo "$uonkx";?>';
    document.formv1.h_uonk0.value = '<?php echo "$uonk0x";?>';
    document.formv1.h_uodp.value = '<?php echo "$uodpx";?>';
    document.formv1.h_dodp.value = '<?php echo "$dodpx";?>';
    document.formv1.h_podp.value = '<?php echo "$podpx";?>';
    document.formv1.h_tstr.value = '<?php echo "$tstrx";?>';
    document.formv1.h_tzak.value = '<?php echo "$tzakx";?>';

    document.formv1.h_xtel.focus();
    document.formv1.h_xtel.select();
<?php                      } ?>
    }


</script>
</HEAD>
<BODY class="white" onload="ObnovUI();" >


<?php
if ($_REQUEST["odeslano"]!=1) 
{ 
?> 

<?php if( $copern == 1 ) { ?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom - Import XML dod·vateæskej fakt˙ry
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_dok=<?php echo $cislo_dok; ?>&cislo_uce=<?php echo $cislo_uce; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr>
        <td  width="10%" align="left" >
<a href="#" onClick="window.open('vstfak.php?copern=1&drupoh=1002&page=1&pocstav=0&hladaj_uce=<?php echo $cislo_uce;?>&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Sp‰ù do zoznamu dod·vateæsk˝ch fakt˙r" ></a></td> 
        <td  width="10%" align="right" >Vyberte s˙bor:</td> 
        <td  width="60%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE="700000" > 
        <input type="file" name="original" size="60"> 
        </td> 
        <td  width="10%" align="left" >(max. 700 kB)</td> 
        <td  width="10%" align="right" >
<a href="#" onClick="window.open('vstf_importfakxml.php?copern=1001&drupoh=<?php echo $drupoh;?>&page=1&cislo_uce=<?php echo $cislo_uce;?>
&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/next.png' width=15 height=15 border=0 title="Nastavenie importu xml" ></a>
</td> 
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
//koniec copern == 1
?>
<?php if( $copern == 1001 ) { ?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom - Nastavenie importu XML fakt˙ry
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
    <form method="POST" name="formv1" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?copern=1003&drupoh=<?php echo $drupoh;?>&page=1&cislo_uce=<?php echo $cislo_uce; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="10%" align="left" >
<a href="#" onClick="window.open('vstfak.php?copern=1&drupoh=1002&page=1&pocstav=0&hladaj_uce=<?php echo $cislo_uce; ?>&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title="Sp‰ù do zoznamu dod·vateæsk˝ch fakt˙r" ></a></td>

        <td  width="10%" align="left" >xico</td>
        <td  width="10%" align="left" >xpop</td>
        <td  width="10%" align="left" >unak</td>
        <td  width="10%" align="left" >udph</td>
        <td  width="10%" align="left" >ddph</td>
        <td  width="10%" align="left" >uonk0</td>
        <td  width="10%" align="left" >uonk</td>
        <td  width="10%" align="left" >uodp</td>
        <td  width="10%" align="left" >dodp</td>
        <td  width="10%" align="left" >podp</td>
        <td  width="10%" align="left" >tstr</td>
        <td  width="10%" align="left" >tzak</td>
        <td  width="5%" align="left" >Zmazaù</td>


        <td  width="5%" align="right" > </td> 
        <td  width="5%" align="right" >
<a href="#" onClick="window.open('vstf_importfakxml.php?copern=1&drupoh=<?php echo $drupoh;?>&page=1&cislo_uce=<?php echo $cislo_uce;?>
&cislo_uce=<?php echo $cislo_uce;?>', '_self' )">
<img src='../obr/prev.png' width=15 height=15 border=0 title="Sp‰ù do Importu XML dod·vateæskej fakt˙ry" ></a>
</td> 

      </tr> 


<?php
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctimportfakxml  WHERE porx > 0 ORDER BY porx ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);
?>
        <tr>
        <td  colspan="1" align="left" > </td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->xtel; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->xpot; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->unak; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->udph; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->ddph; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->uonk0; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->uonk; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->uodp; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->dodp; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->podp; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->tstr; ?></td>
        <td  colspan="1" align="left" ><?php echo $hlavicka->tzak; ?></td>
        <td  colspan="1" align="left" ><a href="#" onClick="window.open('vstf_importfakxml.php?copern=1006&drupoh=<?php echo $drupoh;?>&page=1&cislo_uce=<?php echo $cislo_uce;?>&cislo_cpl=<?php echo $hlavicka->porx; ?>', '_self' )">
<img src='../obr/zmaz.png' width=15 height=15 border=0 title="Zmazaù poloûku" ></a>
</td>
        </tr>

<?php
}
$i=$i+1;
  }
?>
        <tr>
        <td  colspan="1" align="left" > </td>
        <td  colspan="1" align="left" ><input type="text" name="h_xtel" id="h_xtel" size="15"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_xpot" id="h_xpot" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_unak" id="h_unak" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_udph" id="h_udph" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_ddph" id="h_ddph" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_uonk0" id="h_uonk0" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_uonk" id="h_uonk" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_uodp" id="h_uodp" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_dodp" id="h_dodp" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_podp" id="h_podp" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_tstr" id="h_tstr" size="10"/></td>
        <td  colspan="1" align="left" ><input type="text" name="h_tzak" id="h_tzak" size="10"/></td>
        </tr>
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" ></td>
</tr>
    </table> 
    </form> 
<?php 
                            }
//koniec copern == 1001
} 
//koniec if neodeslano


  }
//koniec $zandroidu == 0
?>

<?php
//prepni spat

if( $copern == 1 AND $_REQUEST["odeslano"] == 1 AND $zandroidu == 0 )
{
?>
<script type="text/javascript">

window.open('vstfak.php?copern=1&drupoh=1002&page=1&pocstav=0&hladaj_uce=<?php echo $cislo_uce; ?>&cislo_uce=<?php echo $cislo_uce;?>', '_self' )

</script>
<?php
}
?>

<?php
//nmessage do androidu

if( $copern == 1 AND $zandroidu == 1 )
{

$response = array();
$product = array();
$product["nai"] = $cislo_new;            
// success
$response["success"] = 1;
// user node
$response["product"] = array();
array_push($response["product"], $product);
// echoing JSON response
echo json_encode($response);
}
?>

<?php
exit;

//koniec prepni do faktury
// celkovy koniec dokumentu
       } while (false);

if( $zandroidu == 0 ) 
    {
?>
</BODY>
</HTML>
<?php
    }
?>
