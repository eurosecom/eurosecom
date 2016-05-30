<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$copern = 1*$_REQUEST['copern'];
$sys = $_REQUEST['sys'];
if(!isset($sys)) $sys = 'ALL';
$urov = 2000;
$cslm=101902;
if( $sys == 'ALL' )
{
$uziv = include("../uziv.php");
if( !$uziv ) exit;
if(!isset($kli_vxcf)) $kli_vxcf = 1;
} 
if( $sys == 'CST' )
{
$sys = 'DOP';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;
$sesion = include("../cesty/session.php");
if(!isset($kli_vxcf)) $kli_vxcf = 9999;
$sys = 'CST';
}


  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$tlacitkoenter=0;
//if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 ) { $tlacitkoenter=1; }
$itstablet=0;
if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $itstablet=1; }

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
//    echo "VXCF $kli_vxcf Vume $kli_vume";



//Tabulka icoodbm
$sql = "SELECT icd2 FROM F$kli_vxcf"."_icoodbm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_icoodbm ADD icd2 varchar(20) not null AFTER poz2 ";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT * FROM F$kli_vxcf"."_icorozsirenie";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<ico
(
   ico         INT(10) PRIMARY KEY,
   pozn        TEXT,
   pico1       INT(6),
   pico2       INT(6),
   ptxt1       VARCHAR(20),
   ptxt2       VARCHAR(20)
);
ico;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_icorozsirenie'.$sqlt;
$vysledek = mysql_query("$sql");
}

$sql = "SELECT * FROM F$kli_vxcf"."_icoobalka".$kli_uzid;
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<ico
(
   odosl       DECIMAL(4,0) DEFAULT 0,
   poox1       DECIMAL(4,0) DEFAULT 0,
   pooy1       DECIMAL(4,0) DEFAULT 0,
   titlx       VARCHAR(30) NOT NULL,
   komux       VARCHAR(30) NOT NULL,
   obalx       DECIMAL(4,0) DEFAULT 1,
   pozx1       DECIMAL(4,0) DEFAULT 155,
   pozy1       DECIMAL(4,0) DEFAULT 65,
   pozx2       DECIMAL(4,0) DEFAULT 185,
   pozy2       DECIMAL(4,0) DEFAULT 65,
   pozx3       DECIMAL(4,0) DEFAULT 185,
   pozy3       DECIMAL(4,0) DEFAULT 65,
   poba1       INT(6) DEFAULT 0,
   poba2       INT(6) DEFAULT 0
);
ico;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_icoobalka'.$kli_uzid.$sqlt;
$vysledek = mysql_query("$sql");

$sqult = "INSERT INTO F$kli_vxcf"."_icoobalka$kli_uzid ( titlx ) VALUES ( '' );";
$ulozene = mysql_query("$sqult");
}

$setobal = 1*$_REQUEST['setobal'];
if( $setobal == 1 )
{
$h_poox1 = 1*$_REQUEST['h_poox1'];
$h_pooy1 = 1*$_REQUEST['h_pooy1'];
$h_pozx1 = 1*$_REQUEST['h_pozx1'];
$h_pozy1 = 1*$_REQUEST['h_pozy1'];

$h_odosl = 1*$_REQUEST['h_odosl'];
//echo $h_odosl;

$sqult = "UPDATE F$kli_vxcf"."_icoobalka$kli_uzid SET".
" poox1='$h_poox1', pooy1='$h_pooy1', pozx1='$h_pozx1', pozy1='$h_pozy1', ".
" odosl='$h_odosl' ";
//echo $sqult;
$ulozene = mysql_query("$sqult");
}

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_icoobalka$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $odosl=$riaddok->odosl;
  $poox1=$riaddok->poox1;
  $pooy1=$riaddok->pooy1;
  $titlx=$riaddok->titlx;
  $komux=$riaddok->komux;
  $obalx=$riaddok->obalx;
  $pozx1=$riaddok->pozx1;
  $pozy1=$riaddok->pozy1;
  $pozx2=$riaddok->pozx2;
  $pozy2=$riaddok->pozy2;
  $pozx3=$riaddok->pozx3;
  $pozy3=$riaddok->pozy3;
  }

//tlacove okno
$tlcuwin="width=850, height=' + vyskawin + ', top=0, left=50, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$citnas = include("../cis/citaj_nas.php");
$citfir = include("../cis/citaj_fir.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_dic = trim($_REQUEST['h_dic']);
$h_icd = trim($_REQUEST['h_icd']);
$h_nai = strip_tags($_REQUEST['h_nai']);
$h_na2 = strip_tags($_REQUEST['h_na2']);
$h_uli = strip_tags($_REQUEST['h_uli']);
$h_psc = strip_tags($_REQUEST['h_psc']);
$h_mes = strip_tags($_REQUEST['h_mes']);
$h_tel = strip_tags($_REQUEST['h_tel']);
$h_fax = strip_tags($_REQUEST['h_fax']);
$h_em1 = strip_tags($_REQUEST['h_em1']);
$h_em2 = strip_tags($_REQUEST['h_em2']);
$h_em3 = strip_tags($_REQUEST['h_em3']);
$h_www = strip_tags($_REQUEST['h_www']);
$h_uc1 = strip_tags($_REQUEST['h_uc1']);
$h_nm1 = strip_tags($_REQUEST['h_nm1']);
$h_ib1 = strip_tags($_REQUEST['h_ib1']);
$h_uc2 = strip_tags($_REQUEST['h_uc2']);
$h_nm2 = strip_tags($_REQUEST['h_nm2']);
$h_ib2 = strip_tags($_REQUEST['h_ib2']);
$h_uc3 = strip_tags($_REQUEST['h_uc3']);
$h_nm3 = strip_tags($_REQUEST['h_nm3']);
$h_ib3 = strip_tags($_REQUEST['h_ib3']);
$h_dns = strip_tags($_REQUEST['h_dns']);

$h_st1 = strip_tags($_REQUEST['h_st1']);
$h_st2 = strip_tags($_REQUEST['h_st2']);
$h_st3 = strip_tags($_REQUEST['h_st3']);

//$h_ib1 = $h_ib1."-".$h_st1;
//$h_ib2 = $h_ib2."-".$h_st2;
//$h_ib3 = $h_ib3."-".$h_st3;

$h_pozn = $_REQUEST['h_pozn'];
$uloz="NO";
$zmaz="NO";
$uprav="NO";

$sql = "ALTER TABLE F$kli_vxcf"."_ico MODIFY ib1 varchar(40) not null ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ico MODIFY ib2 varchar(40) not null ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ico MODIFY ib3 varchar(40) not null ";
$vysledek = mysql_query("$sql");

//vymazanie vsetkych poloziek ico
    if ( $copern == 1167 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r z ËÌselnÌka I»O ?") )
         { window.close()  }
else
         { location.href='cico.php?&copern=1168&page=1&drupoh=1'  }
</script>
<?php
    }
    if ( $copern == 1168 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_ico';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_ico"." vynulovan· <br />";


$copern=1;
    }
//koniec  vymazania ico



//import ICO
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/DOD_ICO.CSV ?") )
         { window.close()  }
else
         { location.href='cico.php?copern=156&page=1&drupoh=1'  }
</script>
<?php
    }
    if ( $copern == 156 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/DOD_ICO.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/DOD_ICO.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/DOD_ICO.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_ico = $pole[0];
  $x_icd = $pole[1];
  $x_naz = $pole[2];
  $x_uli = $pole[3];
  $x_mes = $pole[4];
  $x_psc = $pole[5];
  $x_tel = $pole[6];
  $x_fax = $pole[7];
  $x_ema = $pole[8];
  $x_www = $pole[9];
  $x_num = $pole[10];
  $x_ucb = $pole[11];
  $x_num2 = $pole[12];
  $x_ucb2 = $pole[13];
  $x_num3 = $pole[14];
  $x_ucb3 = $pole[15];
  $x_dns = $pole[16];
  $x_kon = $pole[17];

$x_dic=substr($x_icd,2,12);
$x_cico=1*$x_ico;
$x_naz1=substr($x_naz,0,35);
$x_naz2=substr($x_naz,35,35);
 
$sqult = "INSERT INTO F$kli_vxcf"."_ico ( ico,icd,dic,nai,na2,uli,mes,psc,tel,fax,em1,www,nm1,uc1,nm2,uc2,nm3,uc3,dns)".
" VALUES ( '$x_ico', '$x_icd', '$x_dic', '$x_naz1', '$x_naz2', '$x_uli', '$x_mes', '$x_psc', '$x_tel', '$x_fax', '$x_ema', '$x_www',".
" '$x_num', '$x_ucb', '$x_num2', '$x_ucb2', '$x_num3', '$x_ucb3', '$x_dns'".
"  );";
if( $x_cico > 0 ) { $ulozene = mysql_query("$sqult"); }

}
echo "Tabulka F$kli_vxcf"."_ico!"." naimportovan· <br />";
fclose ($subor);

if( file_exists("../import/FIR$kli_vxcf/POZ_ICO.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/POZ_ICO.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/POZ_ICO.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_ico = $pole[0];
  $x_pozn = $pole[1];
  $x_kon = $pole[2];

$x_cico=1*$x_ico;
 
$sqult = "INSERT INTO F$kli_vxcf"."_icorozsirenie ( ico,pozn )".
" VALUES ( '$x_ico', '$x_pozn' );";
if( $x_cico > 0 ) { $ulozene = mysql_query("$sqult"); }

}
echo "Tabulka F$kli_vxcf"."_icorozsirenie!"." naimportovan· <br />";
fclose ($subor);

    }
//koniec importu z ICO


//vymazanie odbm
if ( $copern == 116 )
    {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);
$cislo_odbm = strip_tags($_REQUEST['cislo_odbm']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_icoodbm WHERE ico='$cislo_ico' AND odbm='$cislo_odbm' "); 
$copern=108;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania odbm

//uprava odbm
if ( $copern == 118 )
    {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);
$cislo_odbm = strip_tags($_REQUEST['cislo_odbm']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_icoodbm WHERE ico = $cislo_ico AND odbm = $cislo_odbm ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

  if (@$zaznam=mysql_data_seek($sql,0))
{
$cico=mysql_fetch_object($sql);
$h_ico = $cico->ico;
$h_onai = AddSlashes($cico->onai);
$h_ona2 = AddSlashes($cico->ona2);
$h_ouli = AddSlashes($cico->ouli);
$h_opsc = $cico->opsc;
$h_omes = AddSlashes($cico->omes);
$h_poz1 = $cico->poz1;
$h_poz2 = $cico->poz2;
$h_icd2 = $cico->icd2;
}

     }
//koniec uprava odbm

//ulozenie noveho odbm
if ( $copern == 115 )
    {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);
$h_odbm = strip_tags($_REQUEST['h_odbm']);
$h_onai = strip_tags($_REQUEST['h_onai']);
$h_ona2 = strip_tags($_REQUEST['h_ona2']);
$h_ouli = strip_tags($_REQUEST['h_ouli']);
$h_opsc = strip_tags($_REQUEST['h_opsc']);
$h_omes = strip_tags($_REQUEST['h_omes']);
$h_poz1 = strip_tags($_REQUEST['h_poz1']);
$h_poz2 = strip_tags($_REQUEST['h_poz2']);
$h_icd2 = strip_tags($_REQUEST['h_icd2']);

$sqltt = "DELETE FROM F$kli_vxcf"."_icoodbm WHERE ico = $cislo_ico AND odbm = $h_odbm ";
$sql = mysql_query("$sqltt");

$ulozttt = "INSERT INTO F$kli_vxcf"."_icoodbm ( ico,odbm,onai,ouli,opsc,omes,ona2,poz1,poz2,icd2 ) ".
" VALUES ('$cislo_ico', '$h_odbm', '$h_onai', '$h_ouli', '$h_opsc', '$h_omes', '$h_ona2', '$h_poz1', '$h_poz2', '$h_icd2' )"; 
$ulozene = mysql_query("$ulozttt"); 
$copern=108;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia odbm



// 5=ulozenie polozky do databazy nahratej v cico.php
// 6=vymazanie polozky potvrdene v cico.php
if ( $copern == 15 || $copern == 16 )
     {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);
//ulozenie novej
if ( $copern == 15 )
    {

$h_ico = AddSlashes($h_ico);
$h_dic = trim($h_dic);
$h_icd = trim($h_icd);
$h_nai = AddSlashes($h_nai);
$h_na2 = AddSlashes($h_na2);
$h_uli = AddSlashes($h_uli);
$h_psc = AddSlashes($h_psc);
$h_mes = AddSlashes($h_mes);
$h_tel = AddSlashes($h_tel);
$h_fax = AddSlashes($h_fax);
$h_em1 = AddSlashes($h_em1);
$h_em2 = AddSlashes($h_em2);
$h_em3 = AddSlashes($h_em3);
$h_www = AddSlashes($h_www);
$h_uc1 = AddSlashes($h_uc1);
$h_nm1 = AddSlashes($h_nm1);
$h_ib1 = AddSlashes($h_ib1);
$h_uc2 = AddSlashes($h_uc2);
$h_nm2 = AddSlashes($h_nm2);
$h_ib2 = AddSlashes($h_ib2);
$h_uc3 = AddSlashes($h_uc3);
$h_nm3 = AddSlashes($h_nm3);
$h_ib3 = AddSlashes($h_ib3);
$h_dns = AddSlashes($h_dns);

$h_st1 = strip_tags($_REQUEST['h_st1']);
$h_st2 = strip_tags($_REQUEST['h_st2']);
$h_st3 = strip_tags($_REQUEST['h_st3']);

$h_ib1 = $h_ib1."-".$h_st1;
$h_ib2 = $h_ib2."-".$h_st2;
$h_ib3 = $h_ib3."-".$h_st3;

$uloztt = "INSERT INTO F$kli_vxcf"."_ico".
" ( ico,dic,icd,nai,na2,uli,psc,mes,tel,fax,em1,em2,em3,dns,www,uc1,nm1,uc2,nm2,uc3,nm3,ib1,ib2,ib3 )".
" VALUES ($h_ico, '$h_dic', '$h_icd', '$h_nai', '$h_na2', '$h_uli', '$h_psc', '$h_mes',".
" '$h_tel', '$h_fax', '$h_em1', '$h_em2', '$h_em3', '$h_dns',".
" '$h_www', '$h_uc1', '$h_nm1', '$h_uc2', '$h_nm2', '$h_uc3', '$h_nm3', '$h_ib1', '$h_ib2', '$h_ib3') "; 
//echo $uloztt;
$ulozene = mysql_query("$uloztt"); 

$uloztt = "INSERT INTO F$kli_vxcf"."_icorozsirenie ( ico,pozn ) VALUES ($h_ico, '$h_pozn' ) "; 
$ulozrrr = mysql_query("$uloztt");

$overok = 1*$_REQUEST['overok'];

$uloztt = "UPDATE F$kli_vxcf"."_icorozsirenie SET pozn='$h_pozn', pico1='$overok' WHERE ico = $h_ico "; 
$ulozrrr = mysql_query("$uloztt");
//echo $uloztt;

$copern=1;
$page=1;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA ico:$h_ico SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_ico WHERE ico='$cislo_ico'"); 
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
//echo "POLOéKA ico:$cislo_ico BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania

//uprava 8 a 18
if ( $copern == 18 )
  {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);

$h_ico = AddSlashes($h_ico);
$h_dic = AddSlashes($h_dic);
$h_icd = AddSlashes($h_icd);
$h_nai = AddSlashes($h_nai);
$h_na2 = AddSlashes($h_na2);
$h_uli = AddSlashes($h_uli);
$h_psc = AddSlashes($h_psc);
$h_mes = AddSlashes($h_mes);
$h_tel = AddSlashes($h_tel);
$h_fax = AddSlashes($h_fax);
$h_em1 = AddSlashes($h_em1);
$h_em2 = AddSlashes($h_em2);
$h_em3 = AddSlashes($h_em3);
$h_www = AddSlashes($h_www);
$h_uc1 = AddSlashes($h_uc1);
$h_nm1 = AddSlashes($h_nm1);
$h_ib1 = AddSlashes($h_ib1);
$h_uc2 = AddSlashes($h_uc2);
$h_nm2 = AddSlashes($h_nm2);
$h_ib2 = AddSlashes($h_ib2);
$h_uc3 = AddSlashes($h_uc3);
$h_nm3 = AddSlashes($h_nm3);
$h_ib3 = AddSlashes($h_ib3);
$h_dns = AddSlashes($h_dns);

$h_st1 = strip_tags($_REQUEST['h_st1']);
$h_st2 = strip_tags($_REQUEST['h_st2']);
$h_st3 = strip_tags($_REQUEST['h_st3']);

$h_ib1 = $h_ib1."-".$h_st1;
$h_ib2 = $h_ib2."-".$h_st2;
$h_ib3 = $h_ib3."-".$h_st3;

$h_datm = Date ("Y-m-d H:i:s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$upravttt = "UPDATE F$kli_vxcf"."_ico SET ico='$h_ico', dic='$h_dic', icd='$h_icd',
 nai='$h_nai', na2='$h_na2', uli='$h_uli', psc='$h_psc', mes='$h_mes', tel='$h_tel', fax='$h_fax',
 em1='$h_em1', em2='$h_em2', em3='$h_em3', www='$h_www',
 uc1='$h_uc1', nm1='$h_nm1', uc2='$h_uc2', nm2='$h_nm2', dns='$h_dns',
 uc3='$h_uc3', nm3='$h_nm3', ib1='$h_ib1', ib2='$h_ib2', ib3='$h_ib3', datm='$h_datm' WHERE ico='$cislo_ico'";  
//echo $upravttt;
$upravene = mysql_query("$upravttt");

$uloztt = "INSERT INTO F$kli_vxcf"."_icorozsirenie ( ico,pozn ) VALUES ($h_ico, '$h_pozn' ) "; 
$ulozrrr = mysql_query("$uloztt");

$overok = 1*$_REQUEST['overok'];

$uloztt = "UPDATE F$kli_vxcf"."_icorozsirenie SET pozn='$h_pozn', pico1='$overok'  WHERE ico = $h_ico "; 
$ulozrrr = mysql_query("$uloztt");
//echo $uloztt;

$copern=1;
$cislo_ico = $h_ico;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA ico:$cislo_ico UPRAVEN¡ ";
endif;
  }

//8=uprava
if ( $copern == 8 )
  {
$cislo_ico = strip_tags($_REQUEST['h_ico']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_icorozsirenie WHERE ico = $cislo_ico ";
$sql = mysql_query("$sqltt");

  if (@$zaznam=mysql_data_seek($sql,0))
{
$rico=mysql_fetch_object($sql);
$h_pozn = $rico->pozn;
}
  }

//6=uprava
if ( $copern == 6 )
  {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);
  }



//uprava ICO volane z vstf_t.php...
if ( $copern == 88 OR $copern == 8 )
    {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);
//echo $cislo_ico;
$sqltt = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico = $cislo_ico ";
//echo $sqltt;
$sql = mysql_query("$sqltt");

  if (@$zaznam=mysql_data_seek($sql,0))
{
$cico=mysql_fetch_object($sql);
$h_ico = $cico->ico;
$h_dic = $cico->dic;
$h_icd = $cico->icd;
$h_nai = AddSlashes($cico->nai);
$h_na2 = AddSlashes($cico->na2);
$h_uli = AddSlashes($cico->uli);
$h_psc = $cico->psc;
$h_mes = AddSlashes($cico->mes);
$h_tel = $cico->tel;
$h_fax = $cico->fax;
$h_em1 = $cico->em1;
$h_em2 = $cico->em2;
$h_em3 = $cico->em3;
$h_www = $cico->www;
$h_uc1 = $cico->uc1;
$h_nm1 = $cico->nm1;
$h_ib1 = $cico->ib1;
$h_uc2 = $cico->uc2;
$h_nm2 = $cico->nm2;
$h_ib2 = $cico->ib2;
$h_uc3 = $cico->uc3;
$h_nm3 = $cico->nm3;
$h_ib3 = $cico->ib3;
$h_dns = $cico->dns;

  $pole1 = explode("-", $h_ib1);
  $h_ib1 = $pole1[0];
  $h_st1 = $pole1[1];

//echo "ib1 ".$h_ib1." st1 ".$h_st1;

  $pole2 = explode("-", $h_ib2);
  $h_ib2 = $pole2[0];
  $h_st2 = $pole2[1];

  $pole3 = explode("-", $h_ib3);
  $h_ib3 = $pole3[0];
  $h_st3 = $pole3[1];

}

$sqltt = "SELECT * FROM F$kli_vxcf"."_icorozsirenie WHERE ico = $cislo_ico ";
$sql = mysql_query("$sqltt");

  if (@$zaznam=mysql_data_seek($sql,0))
{
$rico=mysql_fetch_object($sql);
$h_pozn = $rico->pozn;
$overok = 1*$rico->pico1;
//echo "pozn".$h_pozn;
}
$copern=8;
    }
//koniec uprava ICO



?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>».I»O</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

//posuny Enter[[[[[[[[[[[

function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_dic.focus();
              }

                }

function DicEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_icd.focus();
              }

                }

function IcdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_nai.focus();
              }

                }

function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_na2.focus();
              }

                }

function Na2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_uli.focus();
              }

                }

function UliEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_psc.focus();
              }

                }

function PscEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_mes.focus();
              }

                }

function MesEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_tel.focus();
              }

                }

function TelEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_fax.focus();
              }

                }

function FaxEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_www.focus();
              }

                }

function WwwEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_em1.focus();
              }

                }

function Em1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_em2.focus();
              }

                }

function Em2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.h_em3.focus();
              }

                }

function Em3Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_uc1.focus();
              }
                }

function Uc1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_nm1.focus();
              }
                }

function Nm1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_ib1.focus();
              }
                }

function Ib1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_st1.focus();
              }
                }

function St1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_uc2.focus();
              }
                }

function Uc2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_nm2.focus();
              }
                }

function Nm2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_ib2.focus();
              }
                }

function Ib2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_st2.focus();
              }
                }

function St2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_uc3.focus();
              }
                }

function Uc3Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_nm3.focus();
              }
                }

function Nm3Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_ib3.focus();
              }
                }

function Ib3Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_st3.focus();
              }
                }

function St3Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dns.focus();
              }
                }

function DnsEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
    var okvstup=1;


    if ( document.formv1.h_ico.value == '' ) okvstup=0;
    if ( document.formv1.h_nai.value == '' ) okvstup=0;
    if ( document.formv1.h_mes.value == '' ) okvstup=0;
    if ( document.formv1.h_uc1.value == '' ) okvstup=0;
    if ( document.formv1.h_nm1.value == '' ) okvstup=0;

    if ( okvstup == 0 && document.formv1.h_ico.value == '' ) { document.formv1.h_ico.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nai.value == '' ) { document.formv1.h_nai.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_mes.value == '' ) { document.formv1.h_mes.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_uc1.value == '' ) { document.formv1.h_uc1.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_nm1.value == '' ) { document.formv1.h_nm1.focus(); return (false); }
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }

//koniec posunov Enter

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_nai.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//vymazanie
  if ( $copern == 6 OR $copern == 9 OR $copern == 16 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {

    }

<?php
  }
//koniec vymazania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 )
  {
?>
//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
     else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
    }

    function VyberVstup()
    {
    document.forma3.page.focus();
    document.forma3.page.select();
    }

    function ObnovUI()
    {

    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>
<?php
//uprava
  if ( $copern == 8 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.h_ico.value = <?php echo "$h_ico";?>;
    document.formv1.h_dic.value = '<?php echo "$h_dic";?>';
    document.formv1.h_icd.value = '<?php echo "$h_icd";?>';
    document.formv1.h_nai.value = '<?php echo "$h_nai";?>';
    document.formv1.h_na2.value = '<?php echo "$h_na2";?>';
    document.formv1.h_uli.value = '<?php echo "$h_uli";?>';
    document.formv1.h_psc.value = '<?php echo "$h_psc";?>';
    document.formv1.h_mes.value = '<?php echo "$h_mes";?>';
    document.formv1.h_tel.value = '<?php echo "$h_tel";?>';
    document.formv1.h_fax.value = '<?php echo "$h_fax";?>';
    document.formv1.h_em1.value = '<?php echo "$h_em1";?>';
    document.formv1.h_em2.value = '<?php echo "$h_em2";?>';
    document.formv1.h_em3.value = '<?php echo "$h_em3";?>';
    document.formv1.h_www.value = '<?php echo "$h_www";?>';
    document.formv1.h_uc1.value = '<?php echo "$h_uc1";?>';
    document.formv1.h_nm1.value = '<?php echo "$h_nm1";?>';
    document.formv1.h_uc2.value = '<?php echo "$h_uc2";?>';
    document.formv1.h_nm2.value = '<?php echo "$h_nm2";?>';
    document.formv1.h_uc3.value = '<?php echo "$h_uc3";?>';
    document.formv1.h_nm3.value = '<?php echo "$h_nm3";?>';
    document.formv1.h_ib1.value = '<?php echo "$h_ib1";?>';
    document.formv1.h_ib2.value = '<?php echo "$h_ib2";?>';
    document.formv1.h_ib3.value = '<?php echo "$h_ib3";?>';
    document.formv1.h_dns.value = '<?php echo "$h_dns";?>';
    document.formv1.h_st1.value = '<?php echo "$h_st1";?>';
    document.formv1.h_st2.value = '<?php echo "$h_st2";?>';
    document.formv1.h_st3.value = '<?php echo "$h_st3";?>';
    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 )
  {
?>

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
//   Vstup.value = Vstup.value.replace ( ',','.' );
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

    function Zapis_COOK()
    {
//    WriteCookie ( 'ico_ico', document.formv1.h_ico.value , 240);
//    WriteCookie ( 'ico_nai', document.formv1.h_nai.value , 240);
//    WriteCookie ( 'ico_uc1', document.formv1.h_uc1.value , 240);
//    WriteCookie ( 'ico_mes', document.formv1.h_mes.value , 240);
    return (true);
    }

    function Obnov_vstup()
    {
//    document.formv1.h_ico.value = (ReadCookie ( 'ico_ico', '1' ));
//    document.formv1.h_nai.value = (ReadCookie ( 'ico_nai', 'nazov' ));
//    document.formv1.h_uc1.value = (ReadCookie ( 'ico_uc1', 'mesto' ));
//    document.formv1.h_mes.value = (ReadCookie ( 'ico_mes', 'ucet' ));
    return (true);
    }

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
     else { Oznam.style.display="none"; }
    }

    function VyberVstup()
    {
    document.formv1.h_ico.focus();
    document.formv1.h_ico.select();
    document.formv1.uloz.disabled = true; 
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_ico.value == '' ) okvstup=0;
    if ( document.formv1.h_nai.value == '' ) okvstup=0;
    if ( document.formv1.h_mes.value == '' ) okvstup=0;
    if ( document.formv1.h_uc1.value == '' ) okvstup=0;
    if ( document.formv1.h_nm1.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

<?php
//koniec nova,uprava
  }
?>

<?php
//nova
  if ( $copern == 5 )
  { 
?>
    function ObnovUI()
    {
<?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    }

<?php
//koniec nova
  }
?>


<?php
//odberne
  if ( $copern > 100 )
  {
?>

  function OdbmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_onai.focus();
              }
                }

  function OnaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_ona2.focus();
              }
                }

  function Ona2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_ouli.focus();
              }
                }

  function OuliEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_opsc.focus();
              }
                }

  function OpscEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_omes.focus();
              }
                }

function OmesEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;
    if ( document.formv1.h_odbm.value == '' ) okvstup=0;
    if ( document.formv1.h_onai.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
              }
                }


    function VyberVstup()
    {
    document.formv1.uloz.disabled = true; 
    document.formv1.h_odbm.focus();
    }

<?php
//uprava
  if ( $copern != 118 )
  { 
?>
    function ObnovUI()
    {

    }

<?php
//koniec uprava
  }
?>

<?php
//uprava
  if ( $copern == 118 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.h_odbm.value = '<?php echo "$cislo_odbm";?>';
    document.formv1.h_onai.value = '<?php echo "$h_onai";?>';
    document.formv1.h_ona2.value = '<?php echo "$h_ona2";?>';
    document.formv1.h_ouli.value = '<?php echo "$h_ouli";?>';
    document.formv1.h_opsc.value = '<?php echo "$h_opsc";?>';
    document.formv1.h_omes.value = '<?php echo "$h_omes";?>';
    document.formv1.h_poz1.value = '<?php echo "$h_poz1";?>';
    document.formv1.h_poz2.value = '<?php echo "$h_poz2";?>';
    document.formv1.h_icd2.value = '<?php echo "$h_icd2";?>';
    }

<?php
//koniec uprava
  }
?>

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_odbm.value == '' ) okvstup=0;
    if ( document.formv1.h_onai.value == '' ) okvstup=0;
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }


<?php
  }
//koniec odberne
?>

function ObalkaTlac(cico)
                {

window.open('../faktury/obalka.php?copern=11&drupoh=101&cislo_ico=' + cico + '&page=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

   function ObalkaSet()
                {



                }

  function ZhasniSet()
  { 
  robotmenu.style.display='none';
  }

  function UlozSet()
  { 

  }

function TlacNespSaldo(icox)
                {

var h_ico = icox;

window.open('../ucto/saldo_pdf.php?h_uce=31100&h_nai=&h_ico=' + h_ico + '&h_obd=0&copern=10&drupoh=1&page=1&h_su=0&h_al=1&analyzy=0&zico=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

    function Rozb1()
    {
    var akevelke = document.formv1.rozb1.value;
    myTextpred = document.getElementById("h_pozn");
    if( akevelke != 'VELKE' )
      {
    myTextpred.rows = 8;
    myTextpred.cols = 80;
    document.formv1.rozb1.value = 'VELKE';
      }
    if( akevelke == 'VELKE' )
      {
    myTextpred.rows = 1;
    myTextpred.cols = 50;
    document.formv1.rozb1.value = 'MALE';
      }
    }

  </script>
</HEAD>

<?php
if( $sys != 'CST' )
{
?>
<BODY class="white" onload="ObnovUI(); VyberVstup();" >

<?php
//nastavenie datumu do kvdph
if ( $copern >= 1 )
     {
$copernx=$copern;
if( $copern == 8 ) { $copernx=88; }
//hodnoty nacita hore
?>
<div id="nastavdakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 200; left: 10; width:600; height:100;">

<table  class='ponuka' width='100%'><tr><td width='50%'>Nastavenie tlaËe ob·lok</td>
<td width='50%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:14px; height:14px;' onClick="nastavdakx.style.display='none';" title='Zhasni nastavenie' ></td></tr>  

<tr><FORM name='fobal' method='post' action='#' ><td class='ponuka' colspan='1'>TlaËiù Odosielateæa 
<td class='ponuka' colspan='1'> <input type='checkbox' name='h_odosl' value='1' /> </td></tr>

<tr><td class='ponuka' colspan='1'>
Umiestnenie Odosielateæa <td class='ponuka' colspan='1'> X: <input type='text' name='h_poox1' id='h_poox1' size='4' maxlenght='4' value='<?php echo $poox1; ?>' > 
 Y: <input type='text' name='h_pooy1' id='h_pooy1' size='4' maxlenght='4' value='<?php echo $pooy1; ?>' > </td></tr>

<tr><td class='ponuka' colspan='1'>
Umiestnenie Adres·ta <td class='ponuka' colspan='1'> X: <input type='text' name='h_pozx1' id='h_pozx1' size='4' maxlenght='4' value='<?php echo $pozx1; ?>' > 
 Y: <input type='text' name='h_pozy1' id='h_pozy1' size='4' maxlenght='4' value='<?php echo $pozy1; ?>' > </td></tr>

<tr><td colspan='2' align='right'><img border=0 src='../obr/ok.png' style='width:14px; height:14px;' onClick='UlozSetx();' title='Uloû nastavenie' ></td></tr>  

<tr><td></td></FORM></tr></table>
</div>
<script type="text/javascript">

function ObalkaSetx()
                {
nastavdakx.style.display='';
<?php if( $h_odosl == 1 ) { echo "document.fobal.h_odosl.checked='checked'; "; } ?>
                }



  function UlozSetx()
  { 

  var h_poox1 = document.forms.fobal.h_poox1.value;
  var h_pooy1 = document.forms.fobal.h_pooy1.value;
  var h_pozx1 = document.forms.fobal.h_pozx1.value;
  var h_pozy1 = document.forms.fobal.h_pozy1.value;

  var h_odosl = 0;
  if( document.fobal.h_odosl.checked ) h_odosl=1;

  window.open('cico.php?sys=<?php echo $sys; ?>&page=1&h_poox1=' + h_poox1 + '&h_pooy1=' + h_pooy1 + '&h_pozx1=' + h_pozx1 + '&h_pozy1=' + h_pozy1 + '&h_odosl=' + h_odosl + '&copern=<?php echo $copernx; ?>&cislo_ico=<?php echo $cislo_ico; ?>&setobal=1', '_self'  );
  }

</script>
<?php
     }
?>

<?php
}
if( $sys == 'CST' )
{
?>
<BODY class="white" style="background-image: url('../obr/auta/dialnica.jpg');"; onload="ObnovUI(); VyberVstup();">
<?php
}
?>

<?php 
// aktualna strana
$page = strip_tags($_REQUEST['page']);
//nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 5;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);
?>


<?php
if( $sys != 'CST' )
{
?>
<table class="h2" width="100%" >
<tr>
<?php  if ( $copern < 100 ) echo "<td>EuroSecom  -  »ÌselnÌk I»O"; ?>
<?php  if ( $copern > 100 ) echo "<td>EuroSecom  -  OdbernÈ miesta"; ?>
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky I»O ".$cislo_ico;
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<?php
}
?>

<?php
if( $sys == 'CST' )
{
?>
<table class="h2" width="100%" >
<tr><td width="100%">EuroSecom  -  »ÌselnÌk I»O</td></tr>
</table>
<table class="fmenu" width="100%" >
<tr><td><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzoc";?></span></td>
<td><span class="login"><?php echo " $kli_nxcf";?></span></td></tr>
</table>
<br />
<?php
}
?>



<?php
//vypocet IBANu
if ( $copern == 8 )
     {
?>
<script type="text/javascript">

//zapis nastavenie
function dajIBAN(cislo)
                {
var cislox = cislo;

window.open('../cis/dajiban.php?cislo_ico=<?php echo $cislo_ico; ?>&cislox=' + cislox + '&copern=1', '_self' );
                }

</script>
<?php
     }
?>



<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 8 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ico ORDER BY datm DESC");
  }
// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_nai = strip_tags($_REQUEST['hladaj_nai']);
$hladaj_mes = strip_tags($_REQUEST['hladaj_mes']);
$hladaj_uc1 = strip_tags($_REQUEST['hladaj_uc1']);
$hladaj_ico = strip_tags($_REQUEST['hladaj_ico']);

if ( $hladaj_uc1 != "" ) 
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_ico WHERE ( uc1 LIKE '%$hladaj_uc1%' OR uc2 LIKE '%$hladaj_uc1%' OR uc3 LIKE '%$hladaj_uc1%' OR icd LIKE '%$hladaj_uc1%' ) ".
"ORDER BY ico";
$sql = mysql_query("$sqltt");
}
if ( $hladaj_mes != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ( mes LIKE '%$hladaj_mes%' ) ORDER BY ico");
if ( $hladaj_nai != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ( nai LIKE '%$hladaj_nai%' ) ORDER BY ico");
if ( $hladaj_ico != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ( ico = '$hladaj_ico' ) ORDER BY ico");
  }
// zobraz uprava a zmazanie
if ( $copern == 8 OR $copern == 6 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ico WHERE ico > 0 ORDER BY datm DESC");
  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
?>

<table class="fmenu" width="100%" >

<?php
//nezobraz hladanie pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<FORM name="formhl1" class="hmenu" method="post" action="cico.php?sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" >
<img src='../obr/hladaj.png' width=15 height=12 border=0>
<?php
  if ( $kli_uzall > 90000 )
  {
?>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" >
<a href='../cis/cico.php?&copern=1167&page=1&drupoh=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="POZOR !!! Vymazaù vöetky ˙daje z ËÌselnÌka I»O."></a>

<a href='../cis/cico.php?&copern=155&page=1&drupoh=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
<?php
  }
?>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_ico" id="hladaj_ico" size="11" value="<?php echo $hladaj_ico;?>" />
<td class="hmenu"><input type="text" name="hladaj_nai" id="hladaj_nai" size="30" value="<?php echo $hladaj_nai;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_mes" id="hladaj_mes" size="30" value="<?php echo $hladaj_mes;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_uc1" id="hladaj_uc1" size="30" value="<?php echo $hladaj_uc1;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="cico.php?sys=<?php echo $sys; ?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>

<tr>
<th class="hmenu">I»O
<img src='../obr/naradie.png' onClick="ObalkaSetx();" width=15 height=12 border=0 title='Nastavenie tlaËe ob·lky' >
<th class="hmenu">N·zov<th class="hmenu">Mesto<th class="hmenu">I»DPH / Bankov˝ ˙Ëet/num
<th class="hmenu">Uprav<th class="hmenu">Zmaû
</tr>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" width="10%" ><?php echo $riadok->ico;?></td>
<td class="fmenu" width="30%" ><?php echo $riadok->nai;?></td>
<td class="fmenu" width="25%" >
<img src='../obr/obalka.jpg' onClick="ObalkaTlac(<?php echo $riadok->ico;?>);" width=15 height=12 border=0 title='TlaË ob·lky' >

<?php  if ( $agrostav == 1 )  { ?>
<img src='../obr/zoznam.png' onClick="TlacNespSaldo(<?php echo $riadok->ico;?>);" width=15 height=12 border=0 title='Saldokonto' >
<?php                         } ?>

 <?php echo $riadok->mes;?>, <?php echo $riadok->psc;?></td>
<td class="fmenu" width="25%" ><?php echo $riadok->icd;?> | <?php echo $riadok->uc1;?>/<?php echo $riadok->nm1;?> | <?php echo $riadok->uc2;?>/<?php echo $riadok->nm2;?></td>
<td class="fmenu" width="5%" ><a href='cico.php?sys=<?php echo $sys; ?>&copern=8&page=1&cislo_ico=<?php echo $riadok->ico;?>&h_ico=<?php echo $riadok->ico;?>'>
 <img src='../obr/uprav.png'  title="Upraviù poloûku" width=20 height=20 border=0></a></td>
<td class="fmenu" width="5%" ><a href='cico.php?sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_ico=<?php echo $riadok->ico;?>'>Zmaû</a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>
</table>
<table class="fmenu" width="100%" >
<tr><td><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></td></tr>
</table>
<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,5,6,7,8,9
?>

<?php
// 6=vymazanie polozky
if ( $copern == 6 )
  {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico='$cislo_ico'";
$sql = mysql_query("$sqlp");
?>
<table class="fmenu" width="100%" >
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" width="10%" ><?php echo $zaznam["ico"];?></td>
<td class="fmenu" width="30%" ><?php echo $zaznam["nai"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["mes"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["uc1"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_ico=<?php echo $cislo_ico;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno nevymazaù" ></td>
</tr>
</FORM>
</table>

<?php
//mysql_close();
mysql_free_result($sql);
  }
//koniec pre vymazanie
?>

<?php
//zobraz pre novu polozku
if ( $copern == 5 OR $copern == 8 )
     {
?>
<tr>
<span id="Bx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 I»O musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Dx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Druh I»O musÌ byù ËÌslo v rozsahu 1 aû 9</span>
<span id="Ex" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Parametre I»O musia byù ËÌslo v rozsahu 1 aû 9999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka I»O=<?php echo $h_ico;?> spr·vne uloûen·</span>
</tr>
<tr>
</table>

<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_ico=$cislo_ico"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">I»O:</td>
<td class="fmenu" width="24%">
<input type="text" name="h_ico" id="h_ico"  onKeyDown="return IcoEnter(event.which)"
onchange="return intg(this,1,99999999,Bx)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Bx)" />*
<?php
if ( $copern == 8 )
     {
?>
<a href="#" onClick="window.open('../cis/cico.php?copern=108&cislo_ico=<?php echo $cislo_ico;?>', '_blank', '<?php echo $tlcuwin; ?>' )">
 <img src='../obr/zoznam.png' width=15 height=15 border=0 title="OdbernÈ miesta" ></a>
<?php
     }
?>
</td>
<td class="fmenu" width="10%">DI»:</td>
<td class="fmenu" width="23%">
<input type="text" name="h_dic" id="h_dic" onKeyDown="return DicEnter(event.which)"/></td>
<td class="fmenu" width="10%">I»DPH:</td>
<td class="fmenu" width="23%">
<input type="text" name="h_icd" id="h_icd" onKeyDown="return IcdEnter(event.which)" />
 <input type="checkbox" name="overok" id="overok"value="1" title="iËDPH overenÈ" />
<script>
<?php if( $overok == 1 ) { ?>
   document.formv1.overok.checked = "true";
<?php                    } ?>
</script>
</td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">N·zov firmy:</td>
<td class="fmenu" colspan="3">
<input type="text" name="h_nai" id="h_nai" size="40" maxlength="35" onKeyDown="return NaiEnter(event.which)" />*</td>
<td class="fmenu">N·zov 2:</td>
<td class="fmenu" colspan="3">
<input type="text" name="h_na2" id="h_na2" size="40" maxlength="35" onKeyDown="return Na2Enter(event.which)"  /></td>
</tr>
<tr>
<td class="fmenu">SÌdlo ulica:</td>
<td class="fmenu">
<input type="text" name="h_uli" id="h_uli" size="30" maxlength="35" onKeyDown="return UliEnter(event.which)" /></td>
</tr>
<tr>
<td class="fmenu">SÌdlo PS»:</td>
<td class="fmenu">
<input type="text" name="h_psc" id="h_psc" onKeyDown="return PscEnter(event.which)" /></td>
<td class="fmenu">
<img src='../obr/obalka.jpg' onClick="ObalkaTlac(<?php echo $cislo_ico;?>);" width=15 height=12 border=0 title='TlaË ob·lky' >
SÌdlo mesto:</td>
<td class="fmenu">
<input type="text" name="h_mes" id="h_mes" size="30" maxlength="35" onKeyDown="return MesEnter(event.which)" />*</td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">TelefÛn:</td>
<td class="fmenu">
<input type="text" name="h_tel" id="h_tel" onKeyDown="return TelEnter(event.which)" /></td>
<td class="fmenu">Fax:</td>
<td class="fmenu">
<input type="text" name="h_fax" id="h_fax" onKeyDown="return FaxEnter(event.which)" /></td>
<td class="fmenu">Web:</td>
<td class="fmenu">
<input type="text" name="h_www" id="h_www" onKeyDown="return WwwEnter(event.which)" /></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Email 1:</td>
<td class="fmenu">
<input type="text" name="h_em1" id="h_em1" onKeyDown="return Em1Enter(event.which)" /></td>
<td class="fmenu">Email 2</td>
<td class="fmenu">
<input type="text" name="h_em2" id="h_em2" onKeyDown="return Em2Enter(event.which)" /></td>
<td class="fmenu">Email 3</td>
<td class="fmenu">
<input type="text" name="h_em3" id="h_em3" onKeyDown="return Em3Enter(event.which)" /></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 1 ˙Ëet:</td>
<td class="fmenu">
<input type="text" name="h_uc1" id="h_uc1" onKeyDown="return Uc1Enter(event.which)" />*</td>
<td class="fmenu">Banka 1 NUM:</td>
<td class="fmenu">
<input type="text" name="h_nm1" id="h_nm1" onKeyDown="return Nm1Enter(event.which)" />*</td>
<td class="fmenu" colspan="2">
<img src='../obr/vlozit.png' onclick="dajIBAN(1);" width=15 height=15 border=0 title="VypoËÌtaù SK IBAN Ë.1 z bankovÈho ˙Ëtu 1" >
IBAN-SWIFT:
<input type="text" name="h_ib1" id="h_ib1" onKeyDown="return Ib1Enter(event.which)" size="30"/>
-<input type="text" name="h_st1" id="h_st1" onKeyDown="return St1Enter(event.which)" size="9"/>
</td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 2 ˙Ëet:</td>
<td class="fmenu">
<input type="text" name="h_uc2" id="h_uc2" onKeyDown="return Uc2Enter(event.which)" /></td>
<td class="fmenu">Banka 2 NUM:</td>
<td class="fmenu">
<input type="text" name="h_nm2" id="h_nm2" onKeyDown="return Nm2Enter(event.which)" /></td>
<td class="fmenu" colspan="2">
<img src='../obr/vlozit.png' onclick="dajIBAN(2);" width=15 height=15 border=0 title="VypoËÌtaù SK IBAN Ë.2 z bankovÈho ˙Ëtu 2" >
IBAN-SWIFT:
<input type="text" name="h_ib2" id="h_ib2" onKeyDown="return Ib2Enter(event.which)" size="30"/>
-<input type="text" name="h_st2" id="h_st2" onKeyDown="return St2Enter(event.which)" size="9"/>
</td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Banka 3 ˙Ëet:</td>
<td class="fmenu">
<input type="text" name="h_uc3" id="h_uc3" onKeyDown="return Uc3Enter(event.which)" /></td>
<td class="fmenu">Banka 3 NUM:</td>
<td class="fmenu">
<input type="text" name="h_nm3" id="h_nm3" onKeyDown="return Nm3Enter(event.which)" /></td>
<td class="fmenu" colspan="2">
<img src='../obr/vlozit.png' onclick="dajIBAN(3);" width=15 height=15 border=0 title="VypoËÌtaù SK IBAN Ë.3 z bankovÈho ˙Ëtu 3" >
IBAN-SWIFT:
<input type="text" name="h_ib3" id="h_ib3" onKeyDown="return Ib3Enter(event.which)" size="30"/>
-<input type="text" name="h_st3" id="h_st3" onKeyDown="return St3Enter(event.which)" size="9"/>
</td>
</tr>
<tr></tr>
<tr>
<td class="fmenu">Splatnosù fakt˙r (dni):</td>
<td class="fmenu">
<input type="text" name="h_dns" id="h_dns" onKeyDown="return DnsEnter(event.which)" /></td>
<td class="fmenu" colspan="6">
<img src='../obr/ziarovka.png' border="1" onclick="Rozb1();" title="Zv‰Ëöiù/zmenöiù okno pre text" >
Pozn·mka:<textarea name="h_pozn" id="h_pozn" rows="1" cols="60" >
<?php echo $h_pozn; ?>
</textarea>
<input class="hvstup" type="hidden" name="rozb1" id="rozb1" value="NOT" />
</tr>
<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();" >&nbsp;</SPAN></td>
<td class="obyc" align="right"> 
<?php if( $itstablet == 1 )     {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Uloûiù poloûku' >
<?php                           }  ?>
</td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornou" name="stornou" value="Koniec vstupu" ></td>
<?php
if ( $copern == 5 )
{
?>
<td class="obyc" align="right"> </td>
<?php
}
?>
</tr>
</FORM>
</table>
<?php
     }
//koniec zobrazenia pre novu polozku
//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka I»O=<?php echo $cislo_ico;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka I»O=<?php echo $cislo_ico;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ico=$hladaj_ico&hladaj_nai=$hladaj_nai&hladaj_mes=$hladaj_mes&hladaj_uc1=$hladaj_uc1";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_ico=$hladaj_ico&hladaj_nai=$hladaj_nai&hladaj_mes=$hladaj_mes&hladaj_uc1=$hladaj_uc1";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="cico.php?sys=<?php echo $sys; ?>&copern=5&page=1&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Vloûiù nov˙ poloûku" >
</FORM>
</td>
<td>
<FORM name="forma6" class="obyc" method="post" target="_blank" action="cico_t.php
<?php
if ( $copern != 9 )
{
echo "?copern=10";
}
if ( $copern == 9 )
{
echo "?copern=11&hladaj_nai=$hladaj_nai&hladaj_ico=$hladaj_ico";
}
?>
" >
<INPUT type="submit" id="tlac" value="TlaËiù" >
</FORM>
</td>
</tr>
</table>

<?php
     }
//koniec nezobraz pre novu,upravu a mazanie
?>


<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }


// polozky odberne
if ( $copern == 118 ) { $copern=108; }
if ( $copern == 108 )
     {
$cislo_ico = strip_tags($_REQUEST['cislo_ico']);

$sqltt = "SELECT * FROM F$kli_vxcf"."_icoodbm".
" WHERE ico = $cislo_ico ORDER BY odbm";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%" >»Ìslo
<td class="hmenu" width="30%" >N·zov/N·zov2
<td class="hmenu" width="25%" >Ulica/Pozn·mka1/Pozn·mka2
<td class="hmenu" width="5%" >PS»
<td class="hmenu" width="24%" >Mesto/iËDPH2
<th class="hmenu" width="3%" >Edi
<th class="hmenu" width="3%" >Del
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->odbm;?></td>
<td class="fmenu" ><?php echo $riadok->onai;?></td>
<td class="fmenu" ><?php echo $riadok->ouli;?></td>
<td class="fmenu" ><?php echo $riadok->opsc;?></td>
<td class="fmenu" ><?php echo $riadok->omes;?> <?php echo $riadok->icd2;?></td>
<td class="fmenu" ><a href='../cis/cico.php?copern=118&cislo_ico=<?php echo $cislo_ico;?>&cislo_odbm=<?php echo $riadok->odbm;?>'>
<img src='../obr/uprav.png' width=15 height=10 border=0 title="⁄prava odbernÈho miesta" ></a>
<td class="fmenu" ><a href='../cis/cico.php?copern=116&cislo_ico=<?php echo $cislo_ico;?>&cislo_odbm=<?php echo $riadok->odbm;?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazanie odbernÈho miesta" ></a>
</td>
</tr>
<tr>
<td class="hmenu" > </td>
<td class="fmenu" ><?php echo $riadok->ona2;?></td>
<td class="fmenu" colspan="5" ><?php echo $riadok->poz1;?></td>
</tr>
<tr>
<td class="hmenu" > </td>
<td class="hmenu" > </td>
<td class="fmenu" colspan="5" ><?php echo $riadok->poz2;?></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="../cis/cico.php?copern=115&cislo_ico=<?php echo $cislo_ico;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_odbm" id="h_odbm" size="8" 
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return OdbmEnter(event.which)" /> 

<td class="hmenu"><input type="text" name="h_onai" id="h_onai" size="25" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return OnaiEnter(event.which)"/>

<td class="hmenu"><input type="text" name="h_ouli" id="h_ouli" size="25" 
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return OuliEnter(event.which)" /> 

<td class="hmenu"><input type="text" name="h_opsc" id="h_opsc" size="6" 
 onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" 
 onKeyDown="return OpscEnter(event.which)" /> 


<td class="hmenu"><input type="text" name="h_omes" id="h_omes" size="25" 
 onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';" 
 onKeyDown="return OmesEnter(event.which)" /> 

<td class="fmenu"><input type="text" name="h_ne1" id="h_ne1" size="2" /></td>
<td class="fmenu"><input type="text" name="h_ne2" id="h_ne2" size="2" /></td>
</tr>

<tr>

<td class="hmenu"> 

<td class="hmenu"><input type="text" name="h_ona2" id="h_ona2" size="25" 
onclick=" myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 onKeyDown="return Ona2Enter(event.which)"/>

<td class="hmenu" colspan="2" ><input type="text" name="h_poz1" id="h_poz1" size="35" 
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 /> 

<td class="hmenu"><input type="text" name="h_icd2" id="h_icd2" size="15"  /> iËDPH2 

</tr>

<tr>

<td class="hmenu"> 

<td class="hmenu">

<td class="hmenu" colspan="5" ><input type="text" name="h_poz2" id="h_poz2" size="35" 
onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="myKompelement.style.display='none'; New.style.display='none'; Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

</FORM>

</table>

<div id="myKompelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span>

<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<?php
     }
//koniec polozky receptury


// celkovy koniec dokumentu
if( $sys == 'CST' )
{
$cislista = include("../cesty/ces_lista.php");
}
       } while (false);
?>

<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>
</BODY>
</HTML>
