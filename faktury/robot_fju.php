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

$h_odkial = strip_tags($_GET['h_odkial']);//0=hlavicka pokladnica podvojne
$h_drupoh = strip_tags($_GET['h_drupoh']);
$h_pohyb = strip_tags($_GET['h_pohyb']);

$citfir = include("../cis/citaj_fir.php");

include("../ucto/saldo_zmaz_ok.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$nuctpoh="";
if( $_SESSION['kli_vrok'] < 2011 ) { $nuctpoh="2010"; }
$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; $nuctpoh=""; }

$h_odkade=$h_odkial;
if( $h_odkial == 19 ) $h_odkade=9;

$sqlzak = mysql_query("SELECT * FROM $ductpoh"."uctpohyby$nuctpoh WHERE ucto = $h_odkade AND druh = $h_drupoh AND cpoh = $h_pohyb ORDER BY cpoh DESC LIMIT 1");
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
  }

$samodph=0;
if( ( $rdp_zk2 == 37 OR $rdp_zk2 == 39 ) AND $kli_vrok <  2011 ) { $samodph=1; }
if( ( $rdp_zk2 == 34 OR $rdp_zk2 == 35 ) AND $kli_vrok >= 2011 ) { $samodph=1; }

$dalsieszd=0;
$dalsieszd10=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctdrdp WHERE crz3 = 1 AND rdp = $rdp_zk2 AND rdp < 49 ORDER BY rdp";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $hlavicka->crz3 == 1 ) { $dalsieszd=1; }
if( $hlavicka->szd == 10 ) { $dalsieszd10=1; }

}
$i=$i+1;
  }
if( $dalsieszd == 1 ) { $samodph=1; }
if( $dalsieszd10 == 1 ) { $dalsieszd10=1; }


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


//odberatelska faktura zahlavie
if( $h_drupoh == 11 AND $h_odkial == 9 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_dat = strip_tags($_GET['h_dat']);
$h_zao = 1*strip_tags($_GET['h_zao']);
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

$h_fak = strip_tags($_GET['h_fak']);
$h_dol = strip_tags($_GET['h_dol']);
$h_prf = strip_tags($_GET['h_prf']);
$h_obj = strip_tags($_GET['h_obj']);
$h_dpr = strip_tags($_GET['h_dpr']);
$h_str = strip_tags($_GET['h_str']);
$h_zak = strip_tags($_GET['h_zak']);
$h_ksy = strip_tags($_GET['h_ksy']);
$h_ssy = strip_tags($_GET['h_ssy']);

$h_daz = strip_tags($_GET['h_daz']);
$h_das = strip_tags($_GET['h_das']);
$h_sz3 = strip_tags($_GET['h_sz3']);
if( $h_sz3 == '' ) { $h_sz3=$h_fak; }
$h_dav = strip_tags($_GET['h_dav']);

$h_dat = SqlDatum($h_dat);
$h_daz = SqlDatum($h_daz);
$h_das = SqlDatum($h_das);

  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];

//doklad hlavicka
$h_zk0u=$h_zk0; $h_zk1u=$h_zk1; $h_zk2u=$h_zk2; $h_dn1u=$h_dn1; $h_dn2u=$h_dn2;

$uprt = "UPDATE F$kli_vxcf"."_fakodb SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume', sz3='$h_sz3', dav='$h_dav',".
" daz='$h_daz', das='$h_das', poh='$h_poh', skl='$h_skl', ico='$h_ico', fak='$h_fak', ksy='$h_ksy', ssy='$h_ssy',".
" poz='$h_poz', str='$h_str', zak='$h_zak', txp='$h_txp', txz='$h_txz', dol='$h_dol', prf='$h_prf',".
" zao='$h_zao', zk0='$h_zk0u', zk1='$h_zk1u', zk2='$h_zk2u', dn1='$h_dn1u', dn2='$h_dn2u', hod=zk0+zk1+zk2+dn1+dn2+zao,".
" sp1=zk1+dn1, sp2=zk2+dn2,".
" zk0u='$h_zk0u', zk1u='$h_zk1u', zk2u='$h_zk2u', dn1u='$h_dn1u', dn2u='$h_dn2u', hodu=zk0+zk1+zk2+dn1+dn2+zao,".
" sp1u=zk1+dn1, sp2u=zk2+dn2,".
" obj='$h_obj', unk='$h_unk', dpr='$h_dpr', zal='$h_zal', ruc='$h_ruc' ".
" WHERE id='$kli_uzid' AND dok='$h_dok'";

$upravene = mysql_query("$uprt"); 

$h_zk2=1*($h_zk2+$h_zao);

//doklad polozky
if( $h_zk0 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk0', '$rdp_zk0', 0, '$h_zk0', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk1', '$rdp_zk1', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_dn1', '$rdp_zk1', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk2', '$rdp_zk2', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_dn2', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}

     }
//koniec odberatelska faktura zahlavie


//odberatelska faktura polozky
if( $h_drupoh == 11 AND $h_odkial == 19 )
{
$h_dok = strip_tags($_GET['h_dok']);

$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_fakodb WHERE dok = $h_dok ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $h_zk0=$riadzak->zk0;
  $h_zk1=$riadzak->zk1;
  $h_zk2=$riadzak->zk2+$riadzak->zao;
  $h_dn1=$riadzak->dn1;
  $h_dn2=$riadzak->dn2;
  $h_uce=$riadzak->uce;
  $h_ico=$riadzak->ico;
  $h_fak=$riadzak->fak;
  $h_str=$riadzak->str;
  $h_zak=$riadzak->zak;
  $h_unk=$riadzak->unk;
  }


$uprt = "UPDATE F$kli_vxcf"."_fakodb SET ".
" zk0u='$h_zk0', zk1u='$h_zk1', zk2u='$h_zk2', dn1u='$h_dn1', dn2u='$h_dn2', hodu=zk0+zk1+zk2+dn1+dn2,".
" sp1u=zk1+dn1, sp2u=zk2+dn2".
" WHERE dok='$h_dok'";

$upravene = mysql_query("$uprt"); 

//doklad polozky
if( $h_zk0 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk0', '$rdp_zk0', 0, '$h_zk0', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk1', '$rdp_zk1', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_dn1', '$rdp_zk1', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_zk2', '$rdp_zk2', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctodb ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$h_uce', '$ucet_dn2', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
$h_odkial=9;
     }
//koniec odberatelska faktura polozky

//dodavatelska faktura zahlavie
if( $h_drupoh == 12 AND $h_odkial == 9 )
{
$h_uce = strip_tags($_GET['h_uce']);
$h_dok = strip_tags($_GET['h_dok']);
$h_ico = strip_tags($_GET['h_ico']);
$h_dat = strip_tags($_GET['h_dat']);
$h_zao = 1*strip_tags($_GET['h_zao']);
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

$h_fak = strip_tags($_GET['h_fak']);
$h_dol = strip_tags($_GET['h_dol']);
$h_prf = strip_tags($_GET['h_prf']);
$h_obj = strip_tags($_GET['h_obj']);
$h_dpr = strip_tags($_GET['h_dpr']);
$h_str = strip_tags($_GET['h_str']);
$h_zak = strip_tags($_GET['h_zak']);
$h_ksy = strip_tags($_GET['h_ksy']);
$h_ssy = strip_tags($_GET['h_ssy']);

$h_daz = strip_tags($_GET['h_daz']);
$h_das = strip_tags($_GET['h_das']);
$h_sz3 = strip_tags($_GET['h_sz3']);
if( $h_sz3 == '' ) { $h_sz3=$h_fak; }
$h_dav = strip_tags($_GET['h_dav']);
$h_dao = $_GET['h_dao'];

$h_dat = SqlDatum($h_dat);
$h_daz = SqlDatum($h_daz);
$h_das = SqlDatum($h_das);
$h_dao = SqlDatum($h_dao);

  $pole = explode("-", $h_dat);
  $h_ume = $pole[1].".".$pole[0];

//doklad hlavicka
$h_zk0u=$h_zk0; $h_zk1u=$h_zk1; $h_zk2u=$h_zk2; $h_dn1u=$h_dn1; $h_dn2u=$h_dn2;

$uprt = "UPDATE F$kli_vxcf"."_fakdod SET uce='$h_uce', dok='$h_dok', dat='$h_dat', ume='$h_ume', sz3='$h_sz3', dav='$h_dav', sz4='$h_dao',".
" daz='$h_daz', das='$h_das', poh='$h_poh', skl='$h_skl', ico='$h_ico', fak='$h_fak', ksy='$h_ksy', ssy='$h_ssy',".
" poz='$h_poz', str='$h_str', zak='$h_zak', txp='$h_txp', txz='$h_txz', dol='$h_dol', prf='$h_prf',".
" zao='$h_zao', zk0='$h_zk0u', zk1='$h_zk1u', zk2='$h_zk2u', dn1='$h_dn1u', dn2='$h_dn2u', hod=zk0+zk1+zk2+dn1+dn2+zao,".
" sp1=zk1+dn1, sp2=zk2+dn2,".
" zk0u='$h_zk0u', zk1u='$h_zk1u', zk2u='$h_zk2u', dn1u='$h_dn1u', dn2u='$h_dn2u', hodu=zk0+zk1+zk2+dn1+dn2+zao,".
" sp1u=zk1+dn1, sp2u=zk2+dn2,".
" obj='$h_obj', unk='$h_unk', dpr='$h_dpr', zal='$h_zal', ruc='$h_ruc'".
" WHERE id='$kli_uzid' AND dok='$h_dok'";

$upravene = mysql_query("$uprt"); 

$h_zk2=1*($h_zk2+$h_zao);

//doklad polozky
if( $h_zk0 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk0', '$h_uce', '$rdp_zk0', 0, '$h_zk0', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk1', '$h_uce', '$rdp_zk1', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn1', '$h_uce', '$rdp_zk1', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '$rdp_zk2', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$h_uce', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}

if( $samodph == 1 )
{
$rdp_zk2s=1*$rdp_zk2+50;
$prac_dn2=$h_zk0*$fir_dph2; $h_dn2=$prac_dn2/100;
$ucetszd="37900";
if( $fir_fico == 31416853 ) $ucetszd="39599";
if( $kli_vduj == 9 ) $ucetszd="0";

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$ucetszd', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucetszd', '$ucet_dn2', '$rdp_zk2s', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");
}

     }
//koniec dodavatelska faktura zahlavie

//dodavatelska faktura polozky
if( $h_drupoh == 12 AND $h_odkial == 19 )
{
$h_dok = strip_tags($_GET['h_dok']);

$sqlzak = mysql_query("SELECT * FROM F$kli_vxcf"."_fakdod WHERE dok = $h_dok ORDER BY dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlzak,0))
  {
  $riadzak=mysql_fetch_object($sqlzak);
  $h_zk0=$riadzak->zk0;
  $h_zk1=$riadzak->zk1;
  $h_zk2=$riadzak->zk2+$riadzak->zao;
  $h_dn1=$riadzak->dn1;
  $h_dn2=$riadzak->dn2;
  $h_uce=$riadzak->uce;
  $h_ico=$riadzak->ico;
  $h_fak=$riadzak->fak;
  $h_str=$riadzak->str;
  $h_zak=$riadzak->zak;
  $h_unk=$riadzak->unk;
  $h_zmen=$riadzak->zmen;
  $h_mena=$riadzak->mena;
  $h_hodm=$riadzak->hodm;
  $h_kurz=$riadzak->kurz;
  }

if( $samodph == 1 )
{
if( $h_zmen == 1 ) { $h_zk0=$h_hodm/$h_kurz; }
if( $h_zmen == 0 ) { $h_zk0=$h_zk0; }
}

$uprt = "UPDATE F$kli_vxcf"."_fakdod SET ".
" zk0u='$h_zk0', zk1u='$h_zk1', zk2u='$h_zk2', dn1u='$h_dn1', dn2u='$h_dn2', hodu=zk0+zk1+zk2+dn1+dn2,".
" sp1u=zk1+dn1, sp2u=zk2+dn2".
" WHERE dok='$h_dok'";

$upravene = mysql_query("$uprt"); 


//doklad polozky
if( $h_zk0 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk0', '$h_uce', '$rdp_zk0', 0, '$h_zk0', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk1', '$h_uce', '$rdp_zk1', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn1', '$h_uce', '$rdp_zk1', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '$rdp_zk2', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$h_uce', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}

if( $samodph == 1 )
{
$rdp_zk2s=1*$rdp_zk2+50;
if( $h_zmen == 1 ) { $prac_dn2=$h_zk0*$fir_dph2; $h_dn2=$prac_dn2/100; }
if( $h_zmen == 0 ) { $prac_dn2=$h_zk0*$fir_dph2; $h_dn2=$prac_dn2/100; }
$ucetszd="37900";
if( $fir_fico == 31416853 ) $ucetszd="39599";
if( $kli_vduj == 9 ) $ucetszd="0";

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$ucetszd', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucetszd', '$ucet_dn2', '$rdp_zk2s', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");
}


$h_odkial=9;
     }
//koniec dodavatelska faktura polozky

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
