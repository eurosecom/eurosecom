<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

//ulozit nahraty pohyb rozuctovania faktury
// set the output content type as xml
header('Content-Type: text/xml; Accept-Charset: utf-8; ');
//header('Content-Type: text/xml ');
// create the new XML document
$dom = new DOMDocument();

// create the root <response> element
$response = $dom->createElement('response');
$dom->appendChild($response);

// create the <vety> element and append it as a child of <response>
$vety = $dom->createElement('vety');
$response->appendChild($vety);


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");

$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }
$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; $nuctpoh=""; }


$h_odkial = strip_tags($_GET['h_odkial']);//0=hlavicka pokladnica podvojne
$h_drupoh = strip_tags($_GET['h_drupoh']);
$h_pohyb = strip_tags($_GET['h_pohyb']);

$h_odkupr=$h_odkial;
if( $h_odkial == 10 ) $h_odkupr='0 ';

$sqlzak = mysql_query("SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ucto = $h_odkupr AND druh = $h_drupoh AND cpoh = $h_pohyb ORDER BY cpoh DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $ucet_zk0=$riadzak->uzk0;
  $ucet_zk1=$riadzak->uzk1;
  $ucet_zk2=$riadzak->uzk2;
  $rdp_zk0=$riadzak->dzk0;
  $rdp_zk1=$riadzak->dzk1;
  $rdp_zk2=$riadzak->dzk2;
  $ucet_dn1=$riadzak->udn1;
  $ucet_dn2=$riadzak->udn2;
  $vzordok=$riadzak->ddn1;
  $strpoh=1*$riadzak->hstr;
  $zakpoh=1*$riadzak->hzak;
  $pohp=$riadzak->pohp;
  }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//prijmovy pokladnicny 
if( $h_drupoh == 1 AND $h_odkial == 0 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_dat = strip_tags($_GET['h_dat']);
$h_zk0 = 1*strip_tags($_GET['h_zk0']);
$h_zk1 = 1*strip_tags($_GET['h_zk1']);
$h_zk2 = 1*strip_tags($_GET['h_zk2']);
$h_dn1 = 1*strip_tags($_GET['h_dn1']);
$h_dn2 = 1*strip_tags($_GET['h_dn2']);
$h_txp = strip_tags($_GET['h_txp']);
$h_txz = strip_tags($_GET['h_txz']);
$h_poz = strip_tags($_GET['h_poz']);
$h_kto = strip_tags($_GET['h_kto']);
$h_unk = strip_tags($_GET['h_unk']);

$h_dat = SqlDatum($h_dat);

  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];

//doklad hlavicka
$h_zk0u=$h_zk0; $h_zk1u=$h_zk1; $h_zk2u=$h_zk2; $h_dn1u=$h_dn1; $h_dn2u=$h_dn2;

if( $ucet_zk0 == 60 OR $ucet_zk0 == 61 OR $ucet_zk0 == 62 ) { $h_zk0u=$h_zk0+$h_zk1+$h_zk2+$h_dn1+$h_dn2; $h_zk1u=0; $h_zk2u=0; $h_dn1u=0; $h_dn2u=0; }

 $uprt = "UPDATE F$kli_vxcf"."_pokpri SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume', ".
 "ico='$h_ico', txp='$h_txp', txz='$h_txz', kto='$h_kto', ".
 "zk0u='$h_zk0u', zk1u='$h_zk1u', zk2u='$h_zk2u', dn1u='$h_dn1u', dn2u='$h_dn2u', ".
 "sp1u=zk1u+dn1u, sp2u=zk2u+dn2u, hodu=zk0u+sp1u+sp2u, unk='$h_unk', ".
 "zk1=0, zk2=0, zk3=0, zk4=0, dn1=0, dn2=0, dn3=0, dn4=0, sz1=0, sz2=0, sz3=0, sz4=0, hod=0  ".
 "WHERE dok='$h_dok'";
$upravene = mysql_query("$uprt"); 

$uprt = "UPDATE F$kli_vxcf"."_pokpri SET hod=hodu WHERE dok='$h_dok' AND hod = 0 ";
$upravene = mysql_query("$uprt"); 

//doklad polozky
$h_str=0;
if( $strpoh > 0 ) { $h_str=$strpoh; }
$h_zak=0;
if( $zakpoh > 0 ) { $h_zak=$zakpoh; }
$h_fak=1*$h_poz;
if( $ucet_zk0 == 60 OR $ucet_zk0 == 61 OR $ucet_zk0 == 62 ) { $rdp_zk0=1; $rdp_zk1=1; $rdp_zk2=1; $h_fak=1*$h_poz; }
if( $h_zk0 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk0', '$rdp_zk0', 0, '$h_zk0', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk1', '$rdp_zk1', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_dn1', '$rdp_zk1', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk2', '$rdp_zk2', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_dn2', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}

     }
//koniec prijmovy pokladnicny

//vydavkovy pokladnicny 
if( $h_drupoh == 2 AND $h_odkial == 0 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_dat = strip_tags($_GET['h_dat']);
$h_zk0 = 1*strip_tags($_GET['h_zk0']);
$h_zk1 = 1*strip_tags($_GET['h_zk1']);
$h_zk2 = 1*strip_tags($_GET['h_zk2']);
$h_dn1 = 1*strip_tags($_GET['h_dn1']);
$h_dn2 = 1*strip_tags($_GET['h_dn2']);
$h_txp = strip_tags($_GET['h_txp']);
$h_txz = strip_tags($_GET['h_txz']);
$h_poz = strip_tags($_GET['h_poz']);
$h_kto = strip_tags($_GET['h_kto']);
$h_unk = strip_tags($_GET['h_unk']);
$pau80 = 1*$_GET['pau80'];

$h_dat = SqlDatum($h_dat);

  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];

//doklad hlavicka
$h_zk0u=$h_zk0; $h_zk1u=$h_zk1; $h_zk2u=$h_zk2; $h_dn1u=$h_dn1; $h_dn2u=$h_dn2;

if( $ucet_zk0 == 22 OR $ucet_zk0 == 23 OR $ucet_zk0 == 24 ) { $h_zk0u=$h_zk0+$h_zk1+$h_zk2+$h_dn1+$h_dn2; $h_zk1u=0; $h_zk2u=0; $h_dn1u=0; $h_dn2u=0; }

 $uprt = "UPDATE F$kli_vxcf"."_pokvyd SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume', ".
 "ico='$h_ico', txp='$h_txp', txz='$h_txz', kto='$h_kto', ".
 "zk0u='$h_zk0u', zk1u='$h_zk1u', zk2u='$h_zk2u', dn1u='$h_dn1u', dn2u='$h_dn2u', ".
 "sp1u=zk1u+dn1u, sp2u=zk2u+dn2u, hodu=zk0u+sp1u+sp2u, unk='$h_unk', ".
 "zk1=0, zk2=0, zk3=0, zk4=0, dn1=0, dn2=0, dn3=0, dn4=0, sz1=0, sz2=0, sz3=0, sz4=0, hod=0 ".
 "WHERE dok='$h_dok'";
$upravene = mysql_query("$uprt"); 

$uprt = "UPDATE F$kli_vxcf"."_pokvyd SET hod=hodu WHERE dok='$h_dok' AND hod = 0 ";
$upravene = mysql_query("$uprt"); 

//doklad polozky
$h_fak=1*$h_poz;
$h_str=0;
if( $strpoh > 0 ) { $h_str=$strpoh; }
$h_zak=0;
if( $zakpoh > 0 ) { $h_zak=$zakpoh; }
if( $ucet_zk0 == 22 OR $ucet_zk0 == 23 OR $ucet_zk0 == 24 ) { $rdp_zk0=1; $rdp_zk1=1; $rdp_zk2=1; $h_fak=1*$h_poz; }

if( $pau80 == 1 )
  {

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET xzk='$h_zk2', xdp='$h_dn2', xzk0='$h_zk0' ";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET mzk=0.8*xzk, mdp=0.8*xdp, mzk0=0.8*xzk0 ";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET nzk=xzk-mzk, ndp=xdp-mdp, nzk0=xzk0-mzk0 ";
$upravene = mysql_query("$uprt");

$h_zk0n=0; $h_zk2n=0;$h_dn2n=0;

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

  $h_zk0=1*$riaddok->mzk0;
  $h_zk2=1*$riaddok->mzk;
  $h_dn2=1*$riaddok->mdp;

  $h_zk0n=1*$riaddok->nzk0;
  $h_zk2n=1*$riaddok->nzk;
  $h_dn2n=1*$riaddok->ndp;

    }

  }

if( $h_zk0 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk0', '$h_uce', '$rdp_zk0', 0, '$h_zk0', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk1', '$h_uce', '$rdp_zk1', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn1', '$h_uce', '$rdp_zk1', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '$rdp_zk2', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$h_uce', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}

if( $pau80 == 1 )
  {
if( $uzk > 0 ) { $ucet_zk0=$uzk; $ucet_zk2=$uzk; } 
if( $udp > 0 ) { $ucet_dn2=$udp; }
if( $azk > 0 ) { $ucet_zk0=substr($ucet_zk0,0,3).$azk; $ucet_zk2=substr($ucet_zk2,0,3).$azk; }
if( $adp > 0 ) { $ucet_dn2=substr($ucet_dn2,0,3).$adp; }

if( $h_zk0n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk0', '$h_uce', '1', 0, '$h_zk0n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '27', 0, '$h_zk2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$h_uce', '27', 0, '$h_dn2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $ajo == 1 AND $aju > 0 AND $h_dn2n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$aju', '$ucet_dn2', '10', 0, '$h_dn2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");  
}
  }
//koniec ak pau80=1

     }
//koniec vydavkovy pokladnicny


//vseobecny z poloziek podla vzoru 
if( $h_drupoh == 5 AND $h_odkial == 10 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_fak = strip_tags($_GET['h_fak']);
$h_hod = 1*strip_tags($_GET['h_hod']);

$h_hod1 = 1*strip_tags($_GET['h_hod1']);
$h_hod2 = 1*strip_tags($_GET['h_hod2']);
$h_hod3 = 1*strip_tags($_GET['h_hod3']);
$h_hod4 = 1*strip_tags($_GET['h_hod4']);


//doklad polozky

$hodu=0;

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvzordok WHERE dok = '$vzordok' ORDER BY cpl";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

$h_ucm=1*$rsluz->ucm;
if( $h_ucm == 0 ) $h_ucm=$h_uce;
$h_ucd=1*$rsluz->ucd;
if( $h_ucd == 0 ) $h_ucd=$h_uce;
$h_hox=1*$rsluz->hod;
if( $h_hox == 0 ) $h_hox=$h_hod;

$h_fak=1*$rsluz->fak;
if( $h_fak == 0 ) $h_fak=$h_fak;
$h_ico=1*$rsluz->ico;
if( $h_ico == 0 ) $h_fak=$h_ico;

$h_str=1*$rsluz->str;
if( $h_str == 0 ) $h_str=$h_str;
$h_zak=1*$rsluz->zak;
if( $h_zak == 0 ) $h_fak=$h_zak;

if( $h_hox == 0 AND $i == 0 AND $h_hod1 != 0 ) $h_hox=1*$h_hod1;
if( $h_hox == 0 AND $i == 1 AND $h_hod2 != 0 ) $h_hox=1*$h_hod2;
if( $h_hox == 0 AND $i == 2 AND $h_hod3 != 0 ) $h_hox=1*$h_hod3;
if( $h_hox == 0 AND $i == 3 AND $h_hod4 != 0 ) $h_hox=1*$h_hod4;


$h_hodu=$h_hodu+$h_hox;

$sqty = "INSERT INTO F$kli_vxcf"."_uctvsdp ( dok,poh,ucm,ucd,rdp,dph,hod,zmen,mena,kurz,hodm,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '0', '$h_ucm', '$h_ucd', '$rsluz->rdp', '0', '$h_hox', '0', '', '0', '0', ".
" '$rsluz->ico', '$rsluz->fak', ".
" '$rsluz->pop', '$rsluz->str', '$rsluz->zak', '', '$kli_uzid' );"; 

$ulozene = mysql_query("$sqty"); 

//doklad hlavicka
$sqtz = "UPDATE F$kli_vxcf"."_uctvsdh SET zk0u=zk0u+'$h_hox', hodu=hodu+'$h_hox' ".
" WHERE dok='$h_dok'";
$upravene = mysql_query("$sqtz"); 

}
$i = $i + 1;
  }


     }
//koniec vseobecny z poloziek


//bankovy z poloziek podla vzoru
if( $h_drupoh == 4 AND $h_odkial == 10 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_fak = strip_tags($_GET['h_fak']);
$h_hod = 1*strip_tags($_GET['h_hod']);

$h_hod1 = 1*strip_tags($_GET['h_hod1']);
$h_hod2 = 1*strip_tags($_GET['h_hod2']);
$h_hod3 = 1*strip_tags($_GET['h_hod3']);
$h_hod4 = 1*strip_tags($_GET['h_hod4']);

$hodu=0;

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvzordok WHERE dok = '$vzordok' ORDER BY cpl";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

$h_ucm=1*$rsluz->ucm;
if( $h_ucm == 0 ) $h_ucm=$h_uce;
$h_ucd=1*$rsluz->ucd;
if( $h_ucd == 0 ) $h_ucd=$h_uce;
$h_hox=1*$rsluz->hod;
if( $h_hox == 0 ) $h_hox=$h_hod;

$h_fak=1*$rsluz->fak;
if( $h_fak == 0 ) $h_fak=$h_fak;
$h_ico=1*$rsluz->ico;
if( $h_ico == 0 ) $h_fak=$h_ico;

$h_str=1*$rsluz->str;
if( $h_str == 0 ) $h_str=$h_str;
$h_zak=1*$rsluz->zak;
if( $h_zak == 0 ) $h_fak=$h_zak;

if( $h_hox == 0 AND $i == 0 AND $h_hod1 != 0 ) $h_hox=1*$h_hod1;
if( $h_hox == 0 AND $i == 1 AND $h_hod2 != 0 ) $h_hox=1*$h_hod2;
if( $h_hox == 0 AND $i == 2 AND $h_hod3 != 0 ) $h_hox=1*$h_hod3;
if( $h_hox == 0 AND $i == 3 AND $h_hod4 != 0 ) $h_hox=1*$h_hod4;

$h_hodu=$h_hodu+$h_hox;

$sqltt = "SELECT * FROM F$kli_vxcf"."_banvyp WHERE dok='$h_dok' ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ddu=$riaddok->dat;
  }

$sqty = "INSERT INTO F$kli_vxcf"."_uctban ( dok,ddu,poh,ucm,ucd,rdp,dph,hod,zmen,mena,kurz,hodm,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$ddu', '0', '$h_ucm', '$h_ucd', '$rsluz->rdp', '0', '$h_hox', '0', '', '0', '0', ".
" '$rsluz->ico', '$rsluz->fak', ".
" '$rsluz->pop', '$rsluz->str', '$rsluz->zak', '', '$kli_uzid' );"; 

$ulozene = mysql_query("$sqty"); 

//doklad hlavicka
$h_kredit=0;
$h_debet=0;
$md_sucet = substr("$h_ucm", 0, 3);
$dl_sucet = substr("$h_ucd", 0, 3);
if( $md_sucet == 221 ) $h_kredit=$h_hox;
if( $dl_sucet == 221 ) $h_debet=$h_hox;

$sqtz = "UPDATE F$kli_vxcf"."_banvyp SET zk0u=zk0u+('$h_kredit'), zk1u=zk1u+('$h_debet'), zk2u=zk0u-zk1u".
" WHERE dok='$h_dok'";
$upravene = mysql_query("$sqtz"); 

}
$i = $i + 1;
  }



     }
//koniec bankovy z poloziek

// vydavkovy z poloziek podla vzoru
if( $h_drupoh == 22 AND $h_odkial == 10 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_fak = strip_tags($_GET['h_fak']);
$h_hod = 1*strip_tags($_GET['h_hod']);

$h_hod1 = 1*strip_tags($_GET['h_hod1']);
$h_hod2 = 1*strip_tags($_GET['h_hod2']);
$h_hod3 = 1*strip_tags($_GET['h_hod3']);
$h_hod4 = 1*strip_tags($_GET['h_hod4']);


//doklad polozky

$hodu=0;

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvzordok WHERE dok = '$vzordok' ORDER BY cpl";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

$h_ucm=1*$rsluz->ucm;
if( $h_ucm == 0 ) $h_ucm=$h_uce;
$h_ucd=1*$rsluz->ucd;
if( $h_ucd == 0 ) $h_ucd=$h_uce;
$h_hox=1*$rsluz->hod;
if( $h_hox == 0 ) $h_hox=$h_hod;

$h_fakxx=1*$rsluz->fak;
if( $h_fak == 0 ) $h_fak=$h_fakxx;
$h_icoxx=1*$rsluz->ico;
if( $h_ico == 0 ) $h_ico=$h_icoxx;

$h_strxx=1*$rsluz->str;
if( $h_str == 0 ) $h_str=$h_strxx;
$h_zakxx=1*$rsluz->zak;
if( $h_zak == 0 ) $h_zak=$h_zakxx;

if( $h_hox == 0 AND $i == 0 AND $h_hod1 != 0 ) $h_hox=1*$h_hod1;
if( $h_hox == 0 AND $i == 1 AND $h_hod2 != 0 ) $h_hox=1*$h_hod2;
if( $h_hox == 0 AND $i == 2 AND $h_hod3 != 0 ) $h_hox=1*$h_hod3;
if( $h_hox == 0 AND $i == 3 AND $h_hod4 != 0 ) $h_hox=1*$h_hod4;

$pozice = 1*StrPos($pohp, "zdanenie20"); 

if( $pozice > 0 )
    {

$sqltttx = "SELECT * FROM F$kli_vxcf"."_uctpokuct WHERE dok = $h_dok AND rdp = 31 ORDER BY cpl DESC LIMIT 1";
$sqlzakx = mysql_query("$sqltttx");
//echo "idem".$sqltttx;
//exit;
  if (@$zaznam=mysql_data_seek($sqlzakx,0))
  {
  $riadzakx=mysql_fetch_object($sqlzakx);
  $h_ico=$riadzakx->ico;
  $h_fak=$riadzakx->fak;
  $h_str=$riadzakx->str;
  $h_zak=$riadzakx->zak;
  $h_hox=1*$riadzakx->hod*$fir_dph2/100;
  }
    }

$pozice = 1*StrPos($pohp, "zdanenie10"); 

if( $pozice > 0 )
    {

$sqltttx = "SELECT * FROM F$kli_vxcf"."_uctpokuct WHERE dok = $h_dok AND rdp = 31 ORDER BY cpl DESC LIMIT 1";
$sqlzakx = mysql_query("$sqltttx");
//echo "idem".$sqltttx;
//exit;
  if (@$zaznam=mysql_data_seek($sqlzakx,0))
  {
  $riadzakx=mysql_fetch_object($sqlzakx);
  $h_ico=$riadzakx->ico;
  $h_fak=$riadzakx->fak;
  $h_str=$riadzakx->str;
  $h_zak=$riadzakx->zak;
  $h_hox=1*$riadzakx->hod*$fir_dph1/100;
  }
    }

//dok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm  

$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,zmen,mena,kurz,hodm,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '2', '$h_ucm', '$h_ucd', '$rsluz->rdp', '0', '$h_hox', '0', '', '0', '0', ".
" '$h_ico', '$h_fak', ".
" '$rsluz->pop', '$h_str', '$h_zak', '', '$kli_uzid' );"; 

$ulozene = mysql_query("$sqty"); 


}
$i = $i + 1;
  }

     }
//koniec vydavkovy z poloziek podla vzoru


// prijmovy z poloziek podla vzoru
if( $h_drupoh == 21 AND $h_odkial == 10 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_fak = strip_tags($_GET['h_fak']);
$h_hod = 1*strip_tags($_GET['h_hod']);

$h_hod1 = 1*strip_tags($_GET['h_hod1']);
$h_hod2 = 1*strip_tags($_GET['h_hod2']);
$h_hod3 = 1*strip_tags($_GET['h_hod3']);
$h_hod4 = 1*strip_tags($_GET['h_hod4']);


//doklad polozky

$hodu=0;

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvzordok WHERE dok = '$vzordok' ORDER BY cpl";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

$i=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);

$h_ucm=1*$rsluz->ucm;
if( $h_ucm == 0 ) $h_ucm=$h_uce;
$h_ucd=1*$rsluz->ucd;
if( $h_ucd == 0 ) $h_ucd=$h_uce;
$h_hox=1*$rsluz->hod;
if( $h_hox == 0 ) $h_hox=$h_hod;

$h_fakxx=1*$rsluz->fak;
if( $h_fak == 0 ) $h_fak=$h_fakxx;
$h_icoxx=1*$rsluz->ico;
if( $h_ico == 0 ) $h_ico=$h_icoxx;

$h_strxx=1*$rsluz->str;
if( $h_str == 0 ) $h_str=$h_strxx;
$h_zakxx=1*$rsluz->zak;
if( $h_zak == 0 ) $h_zak=$h_zakxx;

if( $h_hox == 0 AND $i == 0 AND $h_hod1 != 0 ) $h_hox=1*$h_hod1;
if( $h_hox == 0 AND $i == 1 AND $h_hod2 != 0 ) $h_hox=1*$h_hod2;
if( $h_hox == 0 AND $i == 2 AND $h_hod3 != 0 ) $h_hox=1*$h_hod3;
if( $h_hox == 0 AND $i == 3 AND $h_hod4 != 0 ) $h_hox=1*$h_hod4;


$h_hodu=$h_hodu+$h_hox;

//dok  poh  cpl  ucm  ucd  rdp  dph  hod  hodm  kurz  mena  zmen  ico  fak  pop  str  zak  unk  id  datm  

$sqty = "INSERT INTO F$kli_vxcf"."_uctpokuct ( dok,poh,ucm,ucd,rdp,dph,hod,zmen,mena,kurz,hodm,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '1', '$h_ucm', '$h_ucd', '$rsluz->rdp', '0', '$h_hox', '0', '', '0', '0', ".
" '$h_ico', '$h_fak', ".
" '$rsluz->pop', '$h_str', '$h_zak', '', '$kli_uzid' );"; 

$ulozene = mysql_query("$sqty"); 


}
$i = $i + 1;
  }
     }
//koniec prijmovy z poloziek podla vzoru


$uce2=1*substr($h_uce,0,2);
$zk02=1*substr($ucet_zk0,0,2);
$ucm2=1*substr($h_ucm,0,2);
$ucd2=1*substr($h_ucd,0,2);
if( $ucm2 == 31 OR $ucm2 == 32 OR $ucm2 == 37 OR $ucd2 == 31 OR $ucd2 == 32 OR $ucd2 == 37 OR $uce2 == 31 OR $uce2 == 32 OR $uce2 == 37 OR $zk02 == 31 OR $zk02 == 32 OR $zk02 == 37 ) 
{ include("../ucto/saldo_zmaz_uhr.php"); }

$txp01=$h_odkial;
$txp02=$h_drupoh;
$txp03=$h_pohyb;
$txp04=$h_uce;
$txp05=$h_dok;
$txp06=$h_ico;

// create the title element for the veta
$pol01 = $dom->createElement('pol01');
$pol01Text = $dom->createTextNode($txp01);
$pol01->appendChild($pol01Text);

// create the pol02 element for the veta
$pol02 = $dom->createElement('pol02');
$pol02Text = $dom->createTextNode($txp02);
$pol02->appendChild($pol02Text);

// create the pol03 element for the veta
$pol03 = $dom->createElement('pol03');
$pol03Text = $dom->createTextNode($txp03);
$pol03->appendChild($pol03Text);

// create the pol04 element for the veta
$pol04 = $dom->createElement('pol04');
$pol04Text = $dom->createTextNode($txp04);
$pol04->appendChild($pol04Text);

// create the pol05 element for the veta
$pol05 = $dom->createElement('pol05');
$pol05Text = $dom->createTextNode($txp05);
$pol05->appendChild($pol05Text);

// create the pol06 element for the veta
$pol06 = $dom->createElement('pol06');
$pol06Text = $dom->createTextNode($txp06);
$pol06->appendChild($pol06Text);

// create the <veta> element 
$veta = $dom->createElement('veta');
$veta->appendChild($pol01);
$veta->appendChild($pol02);
$veta->appendChild($pol03);
$veta->appendChild($pol04);
$veta->appendChild($pol05);
$veta->appendChild($pol06);

// append <veta> as a child of <vety>
$vety->appendChild($veta);


//uloz xml strukturu
// build the XML structure in a string variable
$dom->encoding = 'utf-8';
$xmlString = $dom->saveXML();
// output the XML string
echo $xmlString;

// vystup textoveho retazca
//echo $xmlString;
//print $xmlString;

// konfigurace pro uložení
//$dom->formatOutput = TRUE;
//$dom->encoding = 'utf-8';
//$dom->save('../tmp/robot_ju.xml');
?>
