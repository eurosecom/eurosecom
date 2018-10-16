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

$h_odkial = strip_tags($_GET['h_odkial']);//0=hlavicka faktura podvojne,10=polozky faktura
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
if( $h_odkial == 10 ) $h_odkade=0;

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
  $ico_xx=1*$riadzak->hico;
  $fak_xx=1*$riadzak->hfak;
  }

$samodph=0;
$ceskadph=0;
$samodph10=0;
if( ( $rdp_zk2 == 37 OR $rdp_zk2 == 39 ) AND $kli_vrok <  2011 ) { $samodph=1; }
if( ( $rdp_zk2 == 34 OR $rdp_zk2 == 35 OR $rdp_zk2 == 335 OR $rdp_zk2 == 337 ) AND $kli_vrok >= 2011 ) { $samodph=1; }
if( $rdp_zk1 == 40 AND $rdp_zk2 == 1 AND $kli_vrok >= 2012 ) { $samodph=1; $samodph10=1; }

if( $alchem == 1 AND ( $rdp_zk1 == 33 OR $rdp_zk2 == 46 ) AND $h_pohyb == 2094 ) { $samodph=1; $ceskadph=1; }

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


//odberatelska faktura zo zahlavia
if( $h_drupoh == 11 AND $h_odkial == 0 )
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
" obj='$h_obj', unk='$h_unk', dpr='$h_dpr', zal='$h_zal', ruc='$h_ruc'".
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
//koniec odberatelska faktura zo zahlavia


//odberatelska faktura z poloziek
if( $h_drupoh == 11 AND $h_odkial == 10 )
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

  $h_zmen=$riadzak->zmen;
  $h_mena=$riadzak->mena;
  $h_hodm=$riadzak->hodm;
  $h_kurz=$riadzak->kurz;

  }

if( $h_zk0 == 0 AND $h_zk1 == 0 AND $h_zk2 == 0 AND $h_zmen == 1 AND $h_kurz > 0 AND $h_hodm != 0 )
{
$h_zk0=$h_hodm/$h_kurz;

$uprt = "UPDATE F$kli_vxcf"."_fakodb SET ".
" zk0='$h_zk0', hod='$h_zk0' ".
" WHERE dok='$h_dok' AND hod = 0 ";
$upravene = mysql_query("$uprt"); 

}

$uprt = "UPDATE F$kli_vxcf"."_fakodb SET ".
" zk0u='$h_zk0', zk1u='$h_zk1', zk2u='$h_zk2', dn1u='$h_dn1', dn2u='$h_dn2', hodu=zk0u+zk1u+zk2u+dn1u+dn2u,".
" sp1u=zk1+dn1, sp2u=zk2+dn2".
" WHERE dok='$h_dok'";

$upravene = mysql_query("$uprt"); 


if( $fir_fico == 46529233 AND $h_uce == 31101 ) { $h_uce=31100; }

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
$h_odkial=0;

     }
//koniec odberatelska faktura z poloziek

//andrejko
//dodavatelska faktura zo zahlavia
if( $h_drupoh == 12 AND $h_odkial == 0 )
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

$pau80 = 1*$_GET['pau80'];
$h_zk0c=$h_zk0;

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

if( $pau80 == 1 )
  {

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET xzk='$h_zk2', xdp='$h_dn2', xzk0='$h_zk0' ";
$upravene = mysql_query("$uprt");
//echo $uprt;

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET mzk=0.8*xzk, mdp=0.8*xdp, mzk0=0.8*xzk0 ";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET nzk=xzk-mzk, ndp=xdp-mdp, nzk0=xzk0-mzk0 ";
$upravene = mysql_query("$uprt");

$h_zk0n=0; $h_zk2n=0; $h_dn2n=0;

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

//smzd plus pausal 80/20
if( $rdp_zk2 == 337 ) { $h_zk0=$h_zk0c; $pau80=0; }

    }


  }
//end if pau80=1


//doklad polozky
if( $h_zk0 != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk0', '$h_uce', '$rdp_zk0', 0, '$h_zk0', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk1 != 0 )
{
$rdp_zk1x=$rdp_zk1;
if( $samodph == 1 ) { $rdp_zk1x=30; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk1', '$h_uce', '$rdp_zk1x', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$rdp_zk1x=$rdp_zk1;
if( $samodph == 1 ) { $rdp_zk1x=30; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn1', '$h_uce', '$rdp_zk1x', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$rdp_zk2x=$rdp_zk2;
if( $samodph == 1 ) { $rdp_zk2x=25; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '$rdp_zk2x', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$rdp_zk2x=$rdp_zk2;
if( $samodph == 1 ) { $rdp_zk2x=25; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$h_uce', '$rdp_zk2x', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}

if( $pau80 == 1 )
  {
if( $uzk > 0 ) { $ucet_zk0=$uzk; $ucet_zk2=$uzk; } 
if( $udp > 0 ) { $ucet_dn2=$udp; }
if( $azk > 0 ) { $ucet_zk0=substr($ucet_zk0,0,3).$azk; $ucet_zk2=substr($ucet_zk2,0,3).$azk; }
if( $adp > 0 ) { $ucet_dn2=substr($ucet_dn2,0,3).$adp; }

$paudrh=27;
if( $h_zk0n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk0', '$h_uce', '1', 0, '$h_zk0n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '$paudrh', 0, '$h_zk2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$h_uce', '$paudrh', 0, '$h_dn2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $ajo == 1 AND $aju > 0 AND $h_dn2n != 0 )
{
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$aju', '$ucet_dn2', '10', 0, '$h_dn2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");  
}
  }
//koniec ak pau80=1

if( $samodph == 1 )
{
$rdp_zk2s=1*$rdp_zk2+50;
$sadzbaDPH=$fir_dph2;
if( $samodph10 == 1 ) { $sadzbaDPH=$fir_dph1; $rdp_zk2s=1*$rdp_zk1+50; $rdp_zk2=$rdp_zk1; $ucet_dn2=$ucet_dn1; }
if( $kli_vrok < 2011 ) $sadzbaDPH=19;
if( $alchem == 1 AND $ceskadph == 1 AND $kli_vrok == 2010 ) $sadzbaDPH=20;
if( $alchem == 1 AND $ceskadph == 1 AND $kli_vrok >= 2013 ) $sadzbaDPH=21;
if( $alchem == 1 AND $ceskadph == 1 AND $kli_vrok >= 2011 AND $rdp_zk2 == 46 ) $rdp_zk2s=86;
$prac_dn2=$h_zk0*$sadzbaDPH; $h_dn2=$prac_dn2/100;
$ucetszd="37900";
if( $ico_xx > 0 ) $ucetszd=$ico_xx;
if( $fir_fico == 31416853 ) $ucetszd="39599";
if( $alchem == 1 ) $ucetszd="39501";
if( $alchem == 1 AND $ceskadph == 1 ) $ucetszd="39502";
if( $autovalas == 1 ) $ucetszd="379019";


$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$ucetszd', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 

if( $fak_xx > 0 ) $ucet_dn2=$fak_xx;
if( $alchem == 1 ) $ucet_dn2="34355";
if( $alchem == 1 AND $ceskadph == 1 ) $ucet_dn2="34366";

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucetszd', '$ucet_dn2', '$rdp_zk2s', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");

//smzd 337 plus pausal 80/20
if( $rdp_zk2 == 337 )
    {

$sqty = "UPDATE F$kli_vxcf"."_uctdod SET rdp='$rdp_zk2' WHERE dok = $h_dok AND rdp = 1 "; 
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucetszd', '$ucetszd', '$rdp_zk2s', 0, '$h_zk0c', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");
//echo $sqty;

    }

//smzd 337 plus pausal 80/20
if( $rdp_zk2 == 337 AND $_GET['pau80'] == 1 )
    {
$paudrh=328;
$sadzbaDPH=$fir_dph2;
$prac_dn2x337=$h_zk0c*$sadzbaDPH; $h_dn2x337=$prac_dn2x337/100;

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET xzk='$h_zk0c', xdp='$h_dn2x337',  xzk0=0 ";
$upravene = mysql_query("$uprt");
//echo $uprt;

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET mzk=0.8*xzk, mdp=0.8*xdp, mzk0=0.8*xzk0 ";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE F$kli_vxcf"."_autopausal$kli_uzid SET nzk=xzk-mzk, ndp=xdp-mdp, nzk0=xzk0-mzk0 ";
$upravene = mysql_query("$uprt");

$h_zk0n=0; $h_zk2n=0; $h_dn2n=0;

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

if( $uzk > 0 ) { $ucet_zk0=$uzk; $ucet_zk2=$uzk; } 
if( $udp > 0 ) { $ucet_dn2=$udp; }
if( $azk > 0 ) { $ucet_zk0=substr($ucet_zk0,0,3).$azk; $ucet_zk2=substr($ucet_zk2,0,3).$azk; }
if( $adp > 0 ) { $ucet_dn2=substr($ucet_dn2,0,3).$adp; }

$sqty = "UPDATE F$kli_vxcf"."_uctdod SET hod='$h_zk2' WHERE dok = $h_dok AND rdp = 337 AND LEFT(ucm,3) != 343 "; 
$ulozene = mysql_query("$sqty");

$sqty = "UPDATE F$kli_vxcf"."_uctdod SET hod='$h_dn2' WHERE dok = $h_dok AND rdp = 337 AND LEFT(ucm,3) = 343 "; 
$ulozene = mysql_query("$sqty");


$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '$paudrh', 0, '$h_zk2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$ucetszd', '$paudrh', 0, '$h_dn2n', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");

    }

}

     }
//koniec dodavatelska faktura zo zahlavia


//dodavatelska faktura z poloziek
if( $h_drupoh == 12 AND $h_odkial == 10 )
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

if( $samodph == 0 )
{
if( $h_zmen == 1 ) { $h_zk0=$h_hodm/$h_kurz; }
}

$uprt = "UPDATE F$kli_vxcf"."_fakdod SET ".
" zk0u='$h_zk0', zk1u='$h_zk1', zk2u='$h_zk2', dn1u='$h_dn1', dn2u='$h_dn2', hodu=zk0u+zk1u+zk2u+dn1u+dn2u, ".
" sp1u=zk1u+dn1u, sp2u=zk2u+dn2u WHERE dok='$h_dok'";

$upravene = mysql_query("$uprt"); 

$uprt = "UPDATE F$kli_vxcf"."_fakdod SET ".
" zk0='$h_zk0', zk1='$h_zk1', zk2='$h_zk2', dn1='$h_dn1', dn2='$h_dn2', hod=zk0+zk1+zk2+dn1+dn2, ".
" sp1=zk1+dn1, sp2=zk2+dn2 WHERE dok='$h_dok'";

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
$rdp_zk1x=$rdp_zk1;
if( $samodph == 1 ) { $rdp_zk1x=30; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk1', '$h_uce', '$rdp_zk1x', 0, '$h_zk1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn1 != 0 )
{
$rdp_zk1x=$rdp_zk1;
if( $samodph == 1 ) { $rdp_zk1x=30; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn1', '$h_uce', '$rdp_zk1x', 0, '$h_dn1', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_zk2 != 0 )
{
$rdp_zk2x=$rdp_zk2;
if( $samodph == 1 ) { $rdp_zk2x=25; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_zk2', '$h_uce', '$rdp_zk2x', 0, '$h_zk2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}
if( $h_dn2 != 0 )
{
$rdp_zk2x=$rdp_zk2;
if( $samodph == 1 ) { $rdp_zk2x=25; }
$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$h_uce', '$rdp_zk2x', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 
}


if( $samodph == 1 )
{
$rdp_zk2s=1*$rdp_zk2+50;

$sadzbaDPH=$fir_dph2;
if( $samodph10 == 1 ) { $sadzbaDPH=$fir_dph1; $rdp_zk2s=1*$rdp_zk1+50; $rdp_zk2=$rdp_zk1; $ucet_dn2=$ucet_dn1; }

if( $kli_vrok < 2011 ) $sadzbaDPH=19;
if( $alchem == 1 AND $ceskadph == 1 AND $kli_vrok == 2010 ) $sadzbaDPH=20;
if( $alchem == 1 AND $ceskadph == 1 AND $kli_vrok >= 2013 ) $sadzbaDPH=21;
if( $alchem == 1 AND $ceskadph == 1 AND $kli_vrok >= 2011 AND $rdp_zk2 == 46 ) $rdp_zk2s=86;

if( $h_zmen == 1 ) { $prac_dn2=$h_zk0*$sadzbaDPH; $h_dn2=$prac_dn2/100; }
if( $h_zmen == 0 ) { $prac_dn2=$h_zk0*$sadzbaDPH; $h_dn2=$prac_dn2/100; }
$ucetszd="37900";
if( $ico_xx > 0 ) $ucetszd=$ico_xx;
if( $fir_fico == 31416853 ) $ucetszd="39599";
if( $alchem == 1 ) $ucetszd="39501";
if( $alchem == 1 AND $ceskadph == 1 ) $ucetszd="39502";
if( $autovalas == 1 ) $ucetszd="379019";

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucet_dn2', '$ucetszd', '$rdp_zk2', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty"); 

if( $fak_xx > 0 ) $ucet_dn2=$fak_xx;
if( $alchem == 1 ) $ucet_dn2="34355";
if( $alchem == 1 AND $ceskadph == 1 ) $ucet_dn2="34366";

$sqty = "INSERT INTO F$kli_vxcf"."_uctdod ( dok,poh,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,id )".
" VALUES ('$h_dok', '$h_drupoh', '$ucetszd', '$ucet_dn2', '$rdp_zk2s', 0, '$h_dn2', '$h_ico', '$h_fak', '', '$h_str', '$h_zak', '$h_unk', $kli_uzid );"; 
$ulozene = mysql_query("$sqty");
}

$h_odkial=0;
     }
//koniec dodavatelska faktura z poloziek


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
