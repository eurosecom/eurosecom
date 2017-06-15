<HTML>
<?php
$sys = 'HIM';
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

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$poh = 1*strip_tags($_REQUEST['poh']);
$page = 1*strip_tags($_REQUEST['page']);

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$parwin="width=' + sirkawin + ', height=' + vyskawin + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes";
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$tlacitkoenter=0;
//if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $tlacitkoenter=1; }

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvmaj";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmaj = include("../majetok/vtvmaj.php");
endif;

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// nacitanie premennych
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);
$h_ume = strip_tags($_REQUEST['h_ume']);
$h_druh = strip_tags($_REQUEST['h_druh']);
$h_drm = strip_tags($_REQUEST['h_drm']);
$h_inv = strip_tags($_REQUEST['h_inv']);
$h_naz = strip_tags($_REQUEST['h_naz']);
$h_pop = strip_tags($_REQUEST['h_pop']);
$h_poz = strip_tags($_REQUEST['h_poz']);
$h_vyc = strip_tags($_REQUEST['h_vyc']);
$h_rvr = strip_tags($_REQUEST['h_rvr']);
$h_tri = strip_tags($_REQUEST['h_tri']);
$h_obo = strip_tags($_REQUEST['h_obo']);
$h_jkp = strip_tags($_REQUEST['h_jkp']);
$h_ckp = strip_tags($_REQUEST['h_ckp']);
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_kanc = strip_tags($_REQUEST['h_kanc']);
$h_oc = strip_tags($_REQUEST['h_oc']);
$h_mno = strip_tags($_REQUEST['h_mno']);
$h_spo = strip_tags($_REQUEST['h_spo']);
$h_sku = strip_tags($_REQUEST['h_sku']);
$h_perc = strip_tags($_REQUEST['h_perc']);
$h_meso = strip_tags($_REQUEST['h_meso']);
$h_rzv = strip_tags($_REQUEST['h_rzv']);
$h_cen = strip_tags($_REQUEST['h_cen']);
$h_ops = strip_tags($_REQUEST['h_ops']);
$h_zos = strip_tags($_REQUEST['h_zos']);
$h_zss = strip_tags($_REQUEST['h_zss']);
$h_mes = strip_tags($_REQUEST['h_mes']);
$h_ros = strip_tags($_REQUEST['h_ros']);
$h_rop = strip_tags($_REQUEST['h_rop']);
$h_spo_dan = strip_tags($_REQUEST['h_spo_dan']);
$h_sku_dan = strip_tags($_REQUEST['h_sku_dan']);
$h_perc_dan = strip_tags($_REQUEST['h_perc_dan']);
$h_roco_dan = strip_tags($_REQUEST['h_roco_dan']);
$h_cen_dan = strip_tags($_REQUEST['h_cen_dan']);
$h_ops_dan = strip_tags($_REQUEST['h_ops_dan']);
$h_zos_dan = strip_tags($_REQUEST['h_zos_dan']);
$h_zss_dan = strip_tags($_REQUEST['h_zss_dan']);
$h_mes_dan = strip_tags($_REQUEST['h_mes_dan']);
$h_ros_dan = strip_tags($_REQUEST['h_ros_dan']);
$h_rop_dan = strip_tags($_REQUEST['h_rop_dan']);
$h_drh1 = strip_tags($_REQUEST['h_drh1']);
$h_drh2 = strip_tags($_REQUEST['h_drh2']);
$h_xmax = strip_tags($_REQUEST['h_xmax']);
$h_cen_max = strip_tags($_REQUEST['h_cen_max']);
$h_ops_max = strip_tags($_REQUEST['h_ops_max']);
$h_zos_max = strip_tags($_REQUEST['h_zos_max']);
$h_zss_max = strip_tags($_REQUEST['h_zss_max']);
$h_mes_max = strip_tags($_REQUEST['h_mes_max']);
$h_ros_max = strip_tags($_REQUEST['h_ros_max']);
$h_rop_max = strip_tags($_REQUEST['h_rop_max']);
$h_poh = strip_tags($_REQUEST['h_poh']);
$h_dph = strip_tags($_REQUEST['h_dph']);
$h_dap = strip_tags($_REQUEST['h_dap']);
$h_hd1 = strip_tags($_REQUEST['h_hd1']);
$h_hd2 = strip_tags($_REQUEST['h_hd2']);
$h_hd3 = strip_tags($_REQUEST['h_hd3']);
$h_hd4 = strip_tags($_REQUEST['h_hd4']);
$h_hd5 = strip_tags($_REQUEST['h_hd5']);
$h_hx1 = strip_tags($_REQUEST['h_hx1']);
$h_hx2 = strip_tags($_REQUEST['h_hx2']);
$h_hx3 = strip_tags($_REQUEST['h_hx3']);
$h_hx4 = strip_tags($_REQUEST['h_hx4']);
$h_hx5 = strip_tags($_REQUEST['h_hx5']);
$h_dox = strip_tags($_REQUEST['h_dox']);
$h_dob = strip_tags($_REQUEST['h_dob']);
$h_zar = strip_tags($_REQUEST['h_zar']);

$novapolozka=0;
//nacitanie hodnot pre novu polozku
if ( $copern == 3001 )
     {

if ( $drupoh == 1 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majmaj WHERE inv = '$h_inv' ";
$sql = mysql_query("$sqltx");
 }

if ( $drupoh == 2 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majdim WHERE inv = '$h_inv' ";
$sql = mysql_query("$sqltx");
 }


  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $majmaj=mysql_fetch_object($sql);
$h_ume = $majmaj->ume;
$h_druh = $majmaj->druh;
$h_drm = $majmaj->drm;
$h_inv = 1*$majmaj->inv+1;
$h_ninv = 1*$majmaj->inv+1;
$h_naz = $majmaj->naz;
$h_pop = $majmaj->pop;
$h_poz = $majmaj->poz;
$h_vyc = $majmaj->vyc;
$h_rvr = $majmaj->rvr;
$h_tri = $majmaj->tri;
$h_obo = $majmaj->obo;
$h_jkp = $majmaj->jkp;
$h_ckp = $majmaj->ckp;
$h_str = $majmaj->str;
$h_zak = $majmaj->zak;
$h_kanc = $majmaj->kanc;
$h_oc = $majmaj->oc;
$h_mno = $majmaj->mno;
$h_spo = $majmaj->spo;
$h_sku = $majmaj->sku;
$h_perc = $majmaj->perc;
$h_meso = $majmaj->meso;
$h_rzv = $majmaj->rzv;
$h_cen = $majmaj->cen;
$h_ops = $majmaj->ops;
$h_zos = $majmaj->zos;
$h_zss = $majmaj->zss;
$h_mes = $majmaj->mes;
$h_ros = $majmaj->ros;
$h_rop = $majmaj->rop;
$h_spo_dan = $majmaj->spo_dan;
$h_sku_dan = $majmaj->sku_dan;
$h_perc_dan = $majmaj->perc_dan;
$h_roco_dan = $majmaj->roco_dan;
$h_cen_dan = $majmaj->cen_dan;
$h_ops_dan = $majmaj->ops_dan;
$h_zos_dan = $majmaj->zos_dan;
$h_zss_dan = $majmaj->zss_dan;
$h_mes_dan = $majmaj->mes_dan;
$h_ros_dan = $majmaj->ros_dan;
$h_rop_dan = $majmaj->rop_dan;
$h_drh1 = $majmaj->drh1;
$h_drh2 = $majmaj->drh2;
$h_xmax = $majmaj->xmax;
$h_cen_max = $majmaj->cen_max;
$h_ops_max = $majmaj->ops_max;
$h_zos_max = $majmaj->zos_max;
$h_zss_max = $majmaj->zss_max;
$h_mes_max = $majmaj->mes_max;
$h_ros_max = $majmaj->ros_max;
$h_rop_max = $majmaj->rop_max;
$h_poh = $majmaj->poh;
$h_dph = $majmaj->dph;
$h_dap = $majmaj->dap;
$h_hd1 = $majmaj->hd1;
$h_hd2 = $majmaj->hd2;
$h_hd3 = $majmaj->hd3;
$h_hd4 = $majmaj->hd4;
$h_hd5 = $majmaj->hd5;
$h_hx1 = $majmaj->hx1;
$h_hx2 = $majmaj->hx2;
$h_hx3 = $majmaj->hx3;
$h_hx4 = $majmaj->hx4;
$h_hx5 = $majmaj->hx5;
$h_dox = $majmaj->dox;
$h_dob = $majmaj->dob;
$h_zar = $majmaj->zar;
$h_dob = SkDatum($h_dob);
$h_zar = SkDatum($h_zar);
$h_poh = 1;
$h_dph = 2;
$h_dap = $majmaj->dap;

$novapolozka=1;
$copern=1;
  }
//koniec nacitanie hodnot prenovu polozku
     }

//nacitanie hodnot pred upravou
if ( $copern == 8 )
     {

if ( $drupoh == 1 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majmaj WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

if ( $drupoh == 11 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majpoh WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

if ( $drupoh == 2 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majdim WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

if ( $drupoh == 12 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majpohdim WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $majmaj=mysql_fetch_object($sql);
$h_cpl = $majmaj->cpl;
$h_ume = $majmaj->ume;
$h_druh = $majmaj->druh;
$h_drm = $majmaj->drm;
$h_inv = $majmaj->inv;
$h_naz = $majmaj->naz;
$h_pop = $majmaj->pop;
$h_poz = $majmaj->poz;
$h_vyc = $majmaj->vyc;
$h_rvr = $majmaj->rvr;
$h_tri = $majmaj->tri;
$h_obo = $majmaj->obo;
$h_jkp = $majmaj->jkp;
$h_ckp = $majmaj->ckp;
$h_str = $majmaj->str;
$h_zak = $majmaj->zak;
$h_kanc = $majmaj->kanc;
$h_oc = $majmaj->oc;
$h_mno = $majmaj->mno;
$h_spo = $majmaj->spo;
$h_sku = $majmaj->sku;
$h_perc = $majmaj->perc;
$h_meso = $majmaj->meso;
$h_rzv = $majmaj->rzv;
$h_cen = $majmaj->cen;
$h_ops = $majmaj->ops;
$h_zos = $majmaj->zos;
$h_zss = $majmaj->zss;
$h_mes = $majmaj->mes;
$h_ros = $majmaj->ros;
$h_rop = $majmaj->rop;
$h_spo_dan = $majmaj->spo_dan;
$h_sku_dan = $majmaj->sku_dan;
$h_perc_dan = $majmaj->perc_dan;
$h_roco_dan = $majmaj->roco_dan;
$h_cen_dan = $majmaj->cen_dan;
$h_ops_dan = $majmaj->ops_dan;
$h_zos_dan = $majmaj->zos_dan;
$h_zss_dan = $majmaj->zss_dan;
$h_mes_dan = $majmaj->mes_dan;
$h_ros_dan = $majmaj->ros_dan;
$h_rop_dan = $majmaj->rop_dan;
$h_drh1 = $majmaj->drh1;
$h_drh2 = $majmaj->drh2;
$h_xmax = $majmaj->xmax;
$h_cen_max = $majmaj->cen_max;
$h_ops_max = $majmaj->ops_max;
$h_zos_max = $majmaj->zos_max;
$h_zss_max = $majmaj->zss_max;
$h_mes_max = $majmaj->mes_max;
$h_ros_max = $majmaj->ros_max;
$h_rop_max = $majmaj->rop_max;
$h_poh = $majmaj->poh;
$h_dph = $majmaj->dph;
$h_dap = $majmaj->dap;
$h_hd1 = $majmaj->hd1;
$h_hd2 = $majmaj->hd2;
$h_hd3 = $majmaj->hd3;
$h_hd4 = $majmaj->hd4;
$h_hd5 = $majmaj->hd5;
$h_hx1 = $majmaj->hx1;
$h_hx2 = $majmaj->hx2;
$h_hx3 = $majmaj->hx3;
$h_hx4 = $majmaj->hx4;
$h_hx5 = $majmaj->hx5;
$h_dox = $majmaj->dox;
$h_dob = $majmaj->dob;
$h_zar = $majmaj->zar;
$h_dob = SkDatum($h_dob);
$h_zar = SkDatum($h_zar);
$h_poh = $majmaj->poh;
$h_dph = $majmaj->dph;
$h_dap = $majmaj->dap;

  }
//koniec nacitanie hodnot pred upravou
     }




//nova polozka ulozenie 68
if ( $copern == 68 )
  {

$h_dob = SqlDatum($h_dob);
$h_zar = SqlDatum($h_zar);
$pole = explode("-", $h_zar);
$h_ume = $pole[1].".".$pole[0];


if ( $drupoh == 1 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_majmaj ( ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,str,zak,kanc,oc,mno,id,dob,zar,".
"spo,sku,perc,meso,rzv,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"drh1,drh2,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,poh,dph,dap,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,dox)".
" VALUES ('$h_ume', '1', '$h_drm', '$h_inv', '$h_naz', '$h_pop', '$h_poz', '$h_vyc', '$h_rvr',".
" '$h_tri', '$h_obo', '$h_jkp', '$h_ckp', '$h_str', '$h_zak', '$h_kanc', '$h_oc', '1',".
"  '$kli_uzid', '$h_dob', '$h_zar',".
" '$h_spo', '$h_sku', '$h_perc', '$h_meso', '$h_rzv', '$h_cen', '$h_ops', '$h_zos', '$h_zss', '$h_mes', '$h_ros', '$h_rop', '$h_spo_dan', '$h_sku_dan', '$h_perc_dan',".
" '$h_roco_dan', '$h_cen_dan', '$h_ops_dan', '$h_zos_dan', '$h_zss_dan', '$h_mes_dan', '$h_ros_dan', '$h_rop_dan',".
" 0,0,0,0,0,0,0,0,0,0,'2','$h_dph','$h_dob','','',0,0,0,0,0,0,0,0,0".
" );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty");

if( $ulozene ) {
$sqty = "INSERT INTO F$kli_vxcf"."_majpoh ( ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,str,zak,kanc,oc,mno,id,dob,zar,".
"spo,sku,perc,meso,rzv,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"drh1,drh2,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,poh,dph,dap,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,dox)".
" VALUES ('$h_ume', '1', '$h_drm', '$h_inv', '$h_naz', '$h_pop', '$h_poz', '$h_vyc', '$h_rvr',".
" '$h_tri', '$h_obo', '$h_jkp', '$h_ckp', '$h_str', '$h_zak', '$h_kanc', '$h_oc', '1',".
"  '$kli_uzid', '$h_dob', '$h_zar',".
" '$h_spo', '$h_sku', '$h_perc', '$h_meso', '$h_rzv', '$h_cen', '$h_ops', '$h_zos', '$h_zss', '$h_mes', '$h_ros', '$h_rop', '$h_spo_dan', '$h_sku_dan', '$h_perc_dan',".
" '$h_roco_dan', '$h_cen_dan', '$h_ops_dan', '$h_zos_dan', '$h_zss_dan', '$h_mes_dan', '$h_ros_dan', '$h_rop_dan',".
" 0,0,0,0,0,0,0,0,0,0,'2','$h_dph','$h_dob','','',0,0,0,0,0,0,0,0,0".
" );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty");
               }
   }

if ( $drupoh == 2 )
  {
$sqty = "INSERT INTO F$kli_vxcf"."_majdim ( ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,str,zak,kanc,oc,mno,id,dob,zar,".
"spo,sku,perc,meso,rzv,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"drh1,drh2,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,poh,dph,dap,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,dox)".
" VALUES ('$h_ume', '2', '$h_drm', '$h_inv', '$h_naz', '$h_pop', '$h_poz', '$h_vyc', '$h_rvr',".
" '$h_tri', '$h_obo', '$h_jkp', '$h_ckp', '$h_str', '$h_zak', '$h_kanc', '$h_oc', '$h_mno',".
"  '$kli_uzid', '$h_dob', '$h_zar',".
" '$h_spo', '$h_sku', '$h_perc', '$h_meso', '$h_rzv', '$h_cen', '$h_ops', '$h_zos', '$h_zss', '$h_mes', '$h_ros', '$h_rop', '$h_spo_dan', '$h_sku_dan', '$h_perc_dan',".
" '$h_roco_dan', '$h_cen_dan', '$h_ops_dan', '$h_zos_dan', '$h_zss_dan', '$h_mes_dan', '$h_ros_dan', '$h_rop_dan',".
" 0,0,0,0,0,0,0,0,0,0,'2','$h_dph','$h_dob','','',0,0,0,0,0,0,0,0,0".
" );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty");

if( $ulozene ) {
$sqty = "INSERT INTO F$kli_vxcf"."_majpohdim ( ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,str,zak,kanc,oc,mno,id,dob,zar,".
"spo,sku,perc,meso,rzv,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"drh1,drh2,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,poh,dph,dap,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,dox)".
" VALUES ('$h_ume', '2', '$h_drm', '$h_inv', '$h_naz', '$h_pop', '$h_poz', '$h_vyc', '$h_rvr',".
" '$h_tri', '$h_obo', '$h_jkp', '$h_ckp', '$h_str', '$h_zak', '$h_kanc', '$h_oc', '$h_mno',".
"  '$kli_uzid', '$h_dob', '$h_zar',".
" '$h_spo', '$h_sku', '$h_perc', '$h_meso', '$h_rzv', '$h_cen', '$h_ops', '$h_zos', '$h_zss', '$h_mes', '$h_ros', '$h_rop', '$h_spo_dan', '$h_sku_dan', '$h_perc_dan',".
" '$h_roco_dan', '$h_cen_dan', '$h_ops_dan', '$h_zos_dan', '$h_zss_dan', '$h_mes_dan', '$h_ros_dan', '$h_rop_dan',".
" 0,0,0,0,0,0,0,0,0,0,'2','$h_dph','$h_dob','','',0,0,0,0,0,0,0,0,0".
" );"; 
//echo $sqty;
$ulozene = mysql_query("$sqty");
               }
   }

if ($ulozene):
?>
<script type="text/javascript">
location.href='vstmaj.php?copern=1&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>'
</script>
<?php
exit;
endif;
if (!$ulozene):
$uprav="OK";
$copern=1;
endif;
  }
//koniec nova polozka ulozenie

//uprava polozka ulozenie 78
if ( $copern == 78 )
  {

$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_inv = strip_tags($_REQUEST['cislo_inv']);

$h_dob = SqlDatum($h_dob);
$h_zar = SqlDatum($h_zar);
$pole = explode("-", $h_zar);
$h_ume = $pole[1].".".$pole[0];


if ( $drupoh == 1 )
  {

$h_poh = $majmaj->poh;
$h_dph = $majmaj->dph;
$h_dap = $majmaj->dap;

$sqtz = "UPDATE F$kli_vxcf"."_majmaj SET ".
"druh='1',drm='$h_drm',inv='$h_inv',naz='$h_naz',pop='$h_pop',poz='$h_poz',vyc='$h_vyc',rvr='$h_rvr',".
"tri='$h_tri',obo='$h_obo',jkp='$h_jkp',ckp='$h_ckp',str='$h_str',zak='$h_zak',kanc='$h_kanc',oc='$h_oc',mno='$h_mno',dob='$h_dob',zar='$h_zar',".
"spo='$h_spo',sku='$h_sku',perc='$h_perc',meso='$h_meso',rzv='$h_rzv',cen='$h_cen',ops='$h_ops',zos='$h_zos',zss='$h_zss',ros='$h_ros',".
"rop='$h_rop',spo_dan='$h_spo_dan',sku_dan='$h_sku_dan',perc_dan='$h_perc_dan',roco_dan='$h_roco_dan',cen_dan='$h_cen_dan',".
"ops_dan='$h_ops_dan',zos_dan='$h_zos_dan',zss_dan='$h_zss_dan',mes_dan='$h_mes_dan',ros_dan='$h_ros_dan',rop_dan='$h_rop_dan', ".
"poh='1',dph='1',dap='$h_dap' ".
" WHERE cpl='$cislo_cpl'";
//echo $sqtz;

$upravene = mysql_query("$sqtz");

  }

if ( $drupoh == 11 )
  {

$sqtz = "UPDATE F$kli_vxcf"."_majmaj SET ".
"ume='$h_ume',druh='1',drm='$h_drm',inv='$h_inv',naz='$h_naz',pop='$h_pop',poz='$h_poz',vyc='$h_vyc',rvr='$h_rvr',".
"tri='$h_tri',obo='$h_obo',jkp='$h_jkp',ckp='$h_ckp',str='$h_str',zak='$h_zak',kanc='$h_kanc',oc='$h_oc',mno='$h_mno',dob='$h_dob',zar='$h_zar',".
"spo='$h_spo',sku='$h_sku',perc='$h_perc',meso='$h_meso',rzv='$h_rzv',cen='$h_cen',ops='$h_ops',zos='$h_zos',zss='$h_zss',mes='$h_mes',ros='$h_ros',".
"rop='$h_rop',spo_dan='$h_spo_dan',sku_dan='$h_sku_dan',perc_dan='$h_perc_dan',roco_dan='$h_roco_dan',cen_dan='$h_cen_dan',".
"ops_dan='$h_ops_dan',zos_dan='$h_zos_dan',zss_dan='$h_zss_dan',mes_dan='$h_mes_dan',ros_dan='$h_ros_dan',rop_dan='$h_rop_dan', ".
"poh='2',dph='$h_dph',dap='$h_dap' ".
" WHERE inv='$cislo_inv'";
//echo $sqtz;

$upravene = mysql_query("$sqtz");


$sqtz = "UPDATE F$kli_vxcf"."_majpoh SET ".
"ume='$h_ume',druh='1',drm='$h_drm',inv='$h_inv',naz='$h_naz',pop='$h_pop',poz='$h_poz',vyc='$h_vyc',rvr='$h_rvr',".
"tri='$h_tri',obo='$h_obo',jkp='$h_jkp',ckp='$h_ckp',str='$h_str',zak='$h_zak',kanc='$h_kanc',oc='$h_oc',mno='$h_mno',dob='$h_dob',zar='$h_zar',".
"spo='$h_spo',sku='$h_sku',perc='$h_perc',meso='$h_meso',rzv='$h_rzv',cen='$h_cen',ops='$h_ops',zos='$h_zos',zss='$h_zss',mes='$h_mes',ros='$h_ros',".
"rop='$h_rop',spo_dan='$h_spo_dan',sku_dan='$h_sku_dan',perc_dan='$h_perc_dan',roco_dan='$h_roco_dan',cen_dan='$h_cen_dan',".
"ops_dan='$h_ops_dan',zos_dan='$h_zos_dan',zss_dan='$h_zss_dan',mes_dan='$h_mes_dan',ros_dan='$h_ros_dan',rop_dan='$h_rop_dan', ".
"poh='2',dph='$h_dph',dap='$h_dap' ".
" WHERE cpl='$cislo_cpl'";
//echo $sqtz;

$upravene = mysql_query("$sqtz");

  }

if ( $drupoh == 2 )
  {

$h_poh = $majmaj->poh;
$h_dph = $majmaj->dph;
$h_dap = $majmaj->dap;

$sqtz = "UPDATE F$kli_vxcf"."_majdim SET ".
"druh='2',drm='$h_drm',inv='$h_inv',naz='$h_naz',pop='$h_pop',poz='$h_poz',vyc='$h_vyc',rvr='$h_rvr',".
"tri='$h_tri',obo='$h_obo',jkp='$h_jkp',ckp='$h_ckp',str='$h_str',zak='$h_zak',kanc='$h_kanc',oc='$h_oc',mno='$h_mno',dob='$h_dob',zar='$h_zar',".
"spo='$h_spo',sku='$h_sku',perc='$h_perc',meso='$h_meso',rzv='$h_rzv',cen='$h_cen',ops='$h_ops',zos='$h_zos',zss='$h_zss',mes='$h_mes',ros='$h_ros',".
"rop='$h_rop',spo_dan='$h_spo_dan',sku_dan='$h_sku_dan',perc_dan='$h_perc_dan',roco_dan='$h_roco_dan',cen_dan='$h_cen_dan',".
"ops_dan='$h_ops_dan',zos_dan='$h_zos_dan',zss_dan='$h_zss_dan',mes_dan='$h_mes_dan',ros_dan='$h_ros_dan',rop_dan='$h_rop_dan', ".
"poh='1',dph='1',dap='$h_dap' ".
" WHERE cpl='$cislo_cpl'";
//echo $sqtz;

$upravene = mysql_query("$sqtz");

  }

if ( $drupoh == 12 )
  {

$sqtz = "UPDATE F$kli_vxcf"."_majdim SET ".
"ume='$h_ume',druh='2',drm='$h_drm',inv='$h_inv',naz='$h_naz',pop='$h_pop',poz='$h_poz',vyc='$h_vyc',rvr='$h_rvr',".
"tri='$h_tri',obo='$h_obo',jkp='$h_jkp',ckp='$h_ckp',str='$h_str',zak='$h_zak',kanc='$h_kanc',oc='$h_oc',mno='$h_mno',dob='$h_dob',zar='$h_zar',".
"spo='$h_spo',sku='$h_sku',perc='$h_perc',meso='$h_meso',rzv='$h_rzv',cen='$h_cen',ops='$h_ops',zos='$h_zos',zss='$h_zss',mes='$h_mes',ros='$h_ros',".
"rop='$h_rop',spo_dan='$h_spo_dan',sku_dan='$h_sku_dan',perc_dan='$h_perc_dan',roco_dan='$h_roco_dan',cen_dan='$h_cen_dan',".
"ops_dan='$h_ops_dan',zos_dan='$h_zos_dan',zss_dan='$h_zss_dan',mes_dan='$h_mes_dan',ros_dan='$h_ros_dan',rop_dan='$h_rop_dan', ".
"poh='2',dph='$h_dph',dap='$h_dap' ".
" WHERE inv='$cislo_inv'";
//echo $sqtz;

$upravene = mysql_query("$sqtz");


$sqtz = "UPDATE F$kli_vxcf"."_majpohdim SET ".
"ume='$h_ume',druh='2',drm='$h_drm',inv='$h_inv',naz='$h_naz',pop='$h_pop',poz='$h_poz',vyc='$h_vyc',rvr='$h_rvr',".
"tri='$h_tri',obo='$h_obo',jkp='$h_jkp',ckp='$h_ckp',str='$h_str',zak='$h_zak',kanc='$h_kanc',oc='$h_oc',mno='$h_mno',dob='$h_dob',zar='$h_zar',".
"spo='$h_spo',sku='$h_sku',perc='$h_perc',meso='$h_meso',rzv='$h_rzv',cen='$h_cen',ops='$h_ops',zos='$h_zos',zss='$h_zss',mes='$h_mes',ros='$h_ros',".
"rop='$h_rop',spo_dan='$h_spo_dan',sku_dan='$h_sku_dan',perc_dan='$h_perc_dan',roco_dan='$h_roco_dan',cen_dan='$h_cen_dan',".
"ops_dan='$h_ops_dan',zos_dan='$h_zos_dan',zss_dan='$h_zss_dan',mes_dan='$h_mes_dan',ros_dan='$h_ros_dan',rop_dan='$h_rop_dan', ".
"poh='2',dph='$h_dph',dap='$h_dap' ".
" WHERE cpl='$cislo_cpl'";
//echo $sqtz;

$upravene = mysql_query("$sqtz");

  }



if ($upravene):
?>
<script type="text/javascript">
location.href='vstmaj.php?copern=1&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>'
</script>
<?php
exit;
endif;
if (!$upravene):
$uprav="OK";
$copern=8;
endif;
  }
//koniec uprava polozky ulozenie


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<?php 
if ( $copern == 1 AND $drupoh == 1 )
     {
?>
<title>Dlhodob˝ majetok - zaradenie</title>
<?php
     }
?>
<?php 
if ( $copern == 1 AND $drupoh == 2 )
     {
?>
<title>Drobn˝ majetok - zaradenie</title>
<?php
     }
?>
<?php 
if ( $copern == 4 )
     {
?>
<title>Dlhodob˝ majetok - zv˝öenie hodnoty</title>
<?php
     }
?>
<?php 
if ( $copern == 5 AND $drupoh == 1 )
     {
?>
<title>Dlhodob˝ majetok - rozdelenie hodnoty</title>
<?php
     }
?>
<?php 
if ( $copern == 5 AND $drupoh == 2 )
     {
?>
<title>Drobn˝ majetok - rozdelenie hodnoty</title>
<?php
     }
?>
<?php 
if ( $copern == 6 AND $drupoh == 1 )
     {
?>
<title>Dlhodob˝ majetok - vymazanie poloûky</title>
<?php
     }
?>
<?php 
if ( $copern == 6 AND $drupoh == 11 )
     {
?>
<title>Dlhodob˝ majetok - vymazanie pohybu</title>
<?php
     }
?>
<?php 
if ( $copern == 6 AND $drupoh == 2 )
     {
?>
<title>Drobn˝ majetok - vymazanie poloûky</title>
<?php
     }
?>
<?php 
if ( $copern == 6 AND $drupoh == 12 )
     {
?>
<title>Drobn˝ majetok - vymazanie pohybu</title>
<?php
     }
?>
<?php 
if ( $copern == 8 AND $drupoh == 1 )
     {
?>
<title>Dlhodob˝ majetok - ˙prava poloûky</title>
<?php
     }
?>
<?php 
if ( $copern == 8 AND $drupoh == 11 )
     {
?>
<title>Dlhodob˝ majetok - ˙prava pohybu</title>
<?php
     }
?>
<?php 
if ( $copern == 8 AND $drupoh == 2 )
     {
?>
<title>Drobn˝ majetok - ˙prava poloûky</title>
<?php
     }
?>
<?php 
if ( $copern == 8 AND $drupoh == 12 )
     {
?>
<title>Drobn˝ majetok - ˙prava pohybu</title>
<?php
     }
?>
<?php 
if ( $copern == 106 AND $drupoh == 1 )
     {
?>
<title>Dlhodob˝ majetok - vyradenie poloûky</title>
<?php
     }
?>
<?php 
if ( $copern == 106 AND $drupoh == 2 )
     {
?>
<title>Drobn˝ majetok - vyradenie poloûky</title>
<?php
     }
?>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0; z-index: 200;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }

  </style>
<script type="text/javascript" src="ajax/spr_slu_xml.js"></script>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-90;

function InvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_naz.focus();
        document.forms.fhlv1.h_naz.select();
              }
                }

function NazEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dph.focus();
              }
                }


function PohEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_pop.focus();
              }
                }

function PopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_vyc.focus();
        document.forms.fhlv1.h_vyc.select();
              }
                }


function VycEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_rvr.focus();
        document.forms.fhlv1.h_rvr.select();
              }
                }

function RvrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_drm.focus();
              }
                }

function DrmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_ckp.focus();
        document.forms.fhlv1.h_ckp.select();
              }
                }

function CkpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_jkp.focus();
        document.forms.fhlv1.h_jkp.select();
              }
                }

function JkpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_tri.focus();
        document.forms.fhlv1.h_tri.select();
              }
                }

function TriEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_obo.focus();
        document.forms.fhlv1.h_obo.select();
              }
                }

function OboEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_str.focus();
              }
                }

function StrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_zak.focus();
              }
                }

function ZakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_kanc.focus();
              }
                }

function KancEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_oc.focus();
              }
                }

function OcEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dob.focus();
        document.forms.fhlv1.h_dob.select();
              }
                }


function OnfocusDob()
                {
        if( document.forms.fhlv1.h_dob.value == "" ) { document.forms.fhlv1.h_dob.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dob.select();
                }

function DobEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_zar.focus();
        document.forms.fhlv1.h_zar.select();
              }
                }

function OnfocusZar()
                {
        if( document.forms.fhlv1.h_zar.value == "" ) { document.forms.fhlv1.h_zar.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_zar.select();
                }


<?php 
if ( $drupoh == 1 OR $drupoh == 11 )
     {
?>
function ZarEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_sku.focus();
              }
                }
<?php 
     }
?>

<?php 
if ( $drupoh == 2 OR $drupoh == 11 )
     {
?>
function ZarEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        if( document.forms.fhlv1.h_cen.value == "" ) { document.forms.fhlv1.h_cen.value = '0'; }
        document.forms.fhlv1.h_cen.focus();
        document.forms.fhlv1.h_cen.select();
              }
                }
<?php 
     }
?>

function SkuEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_spo.focus();
              }
                }

function SpoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_perc.focus();
        document.forms.fhlv1.h_perc.select();
              }
                }

function PercEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_meso.focus();
        document.forms.fhlv1.h_meso.select();
              }
                }

function MesoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_rzv.focus();
        document.forms.fhlv1.h_rzv.select();
              }
                }

function RzvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        if( document.forms.fhlv1.h_cen.value == "" ) { document.forms.fhlv1.h_cen.value = '0'; }
        document.forms.fhlv1.h_cen.focus();
        document.forms.fhlv1.h_cen.select();
              }
                }

<?php 
if ( $drupoh == 1 OR $drupoh == 11 )
     {
?>
function CenEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        if( document.forms.fhlv1.h_ops.value == "" ) { document.forms.fhlv1.h_ops.value = '0'; }
        document.forms.fhlv1.h_ops.focus();
        document.forms.fhlv1.h_ops.select();
              }
                }
<?php 
     }
?>

<?php 
if ( $drupoh == 2 OR $drupoh == 12 )
     {
?>
function CenEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        if( document.forms.fhlv1.h_mno.value == "" ) { document.forms.fhlv1.h_mno.value = '1'; }
        document.forms.fhlv1.h_mno.focus();
        document.forms.fhlv1.h_mno.select();
              }
                }
<?php 
     }
?>

function MnoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
        document.forms.fhlv1.h_poz.select();
              }
                }

function OpsEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_zos.value = 1*document.forms.fhlv1.h_cen.value - 1*document.forms.fhlv1.h_ops.value; 
        document.forms.fhlv1.h_zos.focus();
        document.forms.fhlv1.h_zos.select();
              }
                }

function ZosEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_zss.value = 1*document.forms.fhlv1.h_zos.value + 1*document.forms.fhlv1.h_ros.value; 
        document.forms.fhlv1.h_zss.focus();
        document.forms.fhlv1.h_zss.select();
              }
                }

function ZssEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        if( document.forms.fhlv1.h_ros.value == "" ) { document.forms.fhlv1.h_ros.value = '0'; }
        document.forms.fhlv1.h_ros.focus();
        document.forms.fhlv1.h_ros.select();
              }
                }

function RosEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        if( document.forms.fhlv1.h_sku_dan.value == "0" ) { document.forms.fhlv1.h_sku_dan.value = document.forms.fhlv1.h_sku.value; }
        if( document.forms.fhlv1.h_spo_dan.value == "0" ) { document.forms.fhlv1.h_spo_dan.value = document.forms.fhlv1.h_spo.value; }
        if( document.forms.fhlv1.h_perc_dan.value == "" ) { document.forms.fhlv1.h_perc_dan.value = document.forms.fhlv1.h_perc.value; }
        if( document.forms.fhlv1.h_cen_dan.value == "" ) { document.forms.fhlv1.h_cen_dan.value = document.forms.fhlv1.h_cen.value; }
        if( document.forms.fhlv1.h_ops_dan.value == "" ) { document.forms.fhlv1.h_ops_dan.value = document.forms.fhlv1.h_ops.value; }
        if( document.forms.fhlv1.h_zos_dan.value == "" ) { document.forms.fhlv1.h_zos_dan.value = document.forms.fhlv1.h_zos.value; }
        if( document.forms.fhlv1.h_zss_dan.value == "" ) { document.forms.fhlv1.h_zss_dan.value = document.forms.fhlv1.h_zss.value; }
        document.forms.fhlv1.h_sku_dan.focus();
              }
                }


function Sku_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_spo_dan.focus();
              }
                }

function Spo_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_perc_dan.focus();
        document.forms.fhlv1.h_perc_dan.select();
              }
                }

function Perc_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_roco_dan.focus();
        document.forms.fhlv1.h_roco_dan.select();
              }
                }

function Roco_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_cen_dan.focus();
        document.forms.fhlv1.h_cen_dan.select();
              }
                }

function Rzv_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_cen_dan.focus();
        document.forms.fhlv1.h_cen_dan.select();
              }
                }

function Cen_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_ops_dan.focus();
        document.forms.fhlv1.h_ops_dan.select();
              }
                }

function Ops_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_zos_dan.focus();
        document.forms.fhlv1.h_zos_dan.select();
              }
                }

function Zos_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_zss_dan.focus();
        document.forms.fhlv1.h_zss_dan.select();
              }
                }

function Zss_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_ros_dan.focus();
        document.forms.fhlv1.h_ros_dan.select();
              }
                }

function Ros_danEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_poz.focus();
        document.forms.fhlv1.h_poz.select();
              }
                }



<?php 
if ( $copern == 1 OR $copern == 8 )
     {
?>
    function NastavVstup()
    {
<?php 
if ( $copern  == 8 OR $novapolozka == 1 )
                {
?>

document.forms.fhlv1.h_dph.value = '<?php echo $h_dph; ?>';
document.forms.fhlv1.h_drm.value = '<?php echo $h_drm; ?>';
document.forms.fhlv1.h_str.value = '<?php echo $h_str; ?>';
document.forms.fhlv1.h_zak.value = '<?php echo $h_zak; ?>';
document.forms.fhlv1.h_kanc.value = '<?php echo $h_kanc; ?>';
document.forms.fhlv1.h_oc.value = '<?php echo $h_oc; ?>';
<?php 
if ( $drupoh == 1 OR $drupoh == 11 )
              {
?>
document.forms.fhlv1.h_sku.value = '<?php echo $h_sku; ?>';
document.forms.fhlv1.h_spo.value = '<?php echo $h_spo; ?>';
document.forms.fhlv1.h_sku_dan.value = '<?php echo $h_sku_dan; ?>';
document.forms.fhlv1.h_spo_dan.value = '<?php echo $h_spo_dan; ?>';
<?php 
              }
?>

<?php 
if ( $novapolozka == 1 )
              {
?>
document.forms.fhlv1.h_inv.value = '<?php echo $h_ninv; ?>';
<?php 
              }
?>

<?php 
                }
?>
    document.fhlv1.uloh.disabled = true;
    document.forms.fhlv1.h_inv.focus();
    document.forms.fhlv1.h_inv.select();
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.fhlv1.h_inv.value == '' ) okvstup=0;
    if ( document.fhlv1.h_naz.value == '' ) okvstup=0;
    if ( document.fhlv1.h_cen.value == '' ) okvstup=0;
    <?php if( $drupoh == 1 OR $drupoh == 11 ) { echo "if ( document.fhlv1.h_cen_dan.value == '' ) okvstup=0;"; } ?>
    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (false) ; }
    }

<?php
     }
?>

<?php
if ( $copern == 6 )
     {
?>
    function NastavVstup()
    {

    document.fhlv1.uloh.disabled = true;
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (false) ; }
    }

<?php
     }
?>

<?php
if ( $copern == 106 )
     {
?>

  function MnvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_phv.focus();
              }
                }

  function PhvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dtv.focus();
        document.forms.fhlv1.h_dtv.select();
              }
                }

function OnfocusDtv()
                {
        if( document.forms.fhlv1.h_dtv.value == "" ) { document.forms.fhlv1.h_dtv.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dtv.select();
                }

  function DtvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dvv.focus();
        document.forms.fhlv1.h_dvv.select();
              }
                }


    function NastavVstup()
    {

    document.fhlv1.uloh.disabled = true;
    document.forms.fhlv1.h_phv.focus();
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (false) ; }
    }

<?php
     }
?>

<?php
if ( $copern == 4 )
     {
?>

  function PhzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dtz.focus();
        document.forms.fhlv1.h_dtz.select();
              }
                }

function OnfocusDtz()
                {
        if( document.forms.fhlv1.h_dtz.value == "" ) { document.forms.fhlv1.h_dtz.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dtz.select();
                }

  function DtzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dvz.focus();
        document.forms.fhlv1.h_dvz.select();
              }
                }


    function NastavVstup()
    {

    document.fhlv1.uloh.disabled = true;
    document.forms.fhlv1.h_phz.focus();
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (false) ; }
    }

<?php
     }
?>


<?php
if ( $copern == 5 )
     {
?>

  function CerEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_opr.focus();
        document.forms.fhlv1.h_opr.select();
              }
                }

  function OprEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_inr.focus();
        document.forms.fhlv1.h_inr.select();
              }
                }

  function InrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dtr.focus();
        document.forms.fhlv1.h_dtr.select();
              }
                }

  function OnfocusDtr()
                {
        if( document.forms.fhlv1.h_dtr.value == "" ) { document.forms.fhlv1.h_dtr.value = '<?php echo date("d.m.Y"); ?>'; }
        document.forms.fhlv1.h_dtr.select();
                }

  function DtrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.fhlv1.h_dvr.focus();
        document.forms.fhlv1.h_dvr.select();
              }
                }


    function NastavVstup()
    {

    document.fhlv1.uloh.disabled = true;
    document.forms.fhlv1.h_cer.focus();
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( okvstup == 1 ) { document.fhlv1.uloh.disabled = false; Fxh.style.display="none"; return (true); }
       else { document.fhlv1.uloh.disabled = true; Fxh.style.display=""; return (false) ; }
    }

<?php
     }
?>


//[[[[[[[[[[[[ KONTROLY
//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1965 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1965.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1)
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3)
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;

         if (b == "") { err=0 }
         if (Math.floor(b)==b && b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9]/g) != -1) { err=1 }
         if (Math.floor(b)!=b && b != "") { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 1 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 1 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des,errflag) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         <?php
         if ( $copern == 1 ) 
         {?>
         errflag.value = "0";
         <?php
         }?>
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         <?php
         if ( $copern == 88 ) 
         {?>
         document.formv1.uloz.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         <?php
         if ( $copern == 1 ) 
         {?>
         document.fhlv1.uloh.disabled = true;
         errflag.value = "1";
         <?php
         }?>
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
<?php if( $_SESSION['nieie'] == 0 )  { ?>
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;
<?php                                } ?>
    }

</script>
</HEAD>
<BODY class="white" onload="NastavVstup();">

<table class="h2" width="100%" >
<tr>
<?php if($copern == 1 AND $drupoh == 1) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - zaradenie</td>"; } ?>
<?php if($copern == 1 AND $drupoh == 2) { echo "<td>EuroSecom  -  Drobn˝ majetok - zaradenie</td>"; } ?>
<?php if($copern == 4 AND $drupoh == 1) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - zv˝öenie hodnoty</td>"; } ?>
<?php if($copern == 5 AND $drupoh == 1) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - rozdelenie hodnoty</td>"; } ?>
<?php if($copern == 5 AND $drupoh == 2) { echo "<td>EuroSecom  -  Drobn˝ majetok - rozdelenie hodnoty</td>"; } ?>
<?php if($copern == 6 AND $drupoh == 1) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - zmazaù poloûku</td>"; } ?>
<?php if($copern == 6 AND $drupoh == 11) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - zmazaù pohyb</td>"; } ?>
<?php if($copern == 6 AND $drupoh == 2) { echo "<td>EuroSecom  -  Drobn˝ majetok - zmazaù poloûku</td>"; } ?>
<?php if($copern == 6 AND $drupoh == 12) { echo "<td>EuroSecom  -  Drobn˝ majetok - zmazaù pohyb</td>"; } ?>
<?php if($copern == 8 AND $drupoh == 1) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - upraviù poloûku</td>"; } ?>
<?php if($copern == 8 AND $drupoh == 11) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - upraviù pohyb</td>"; } ?>
<?php if($copern == 8 AND $drupoh == 2) { echo "<td>EuroSecom  -  Drobn˝ majetok - upraviù poloûku</td>"; } ?>
<?php if($copern == 8 AND $drupoh == 12) { echo "<td>EuroSecom  -  Drobn˝ majetok - upraviù pohyb</td>"; } ?>
<?php if($copern == 106 AND $drupoh == 1) { echo "<td>EuroSecom  -  Dlhodob˝ majetok - vyradiù poloûku</td>"; } ?>
<?php if($copern == 106 AND $drupoh == 2) { echo "<td>EuroSecom  -  Drobn˝ majetok - vyradiù poloûku</td>"; } ?>

<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<div id="Okno"></div>

<?php 
//zaradenie novej polozky dlhodoby
if ( $copern == 1 OR $copern == 8 )
     {
?>

<table class="vstup" width="100%" align="left">
<?php 
if ( $copern == 1 )
     {
?>
<FORM name="fhlv1" class="obyc" method="post" action="vstm_u.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&copern=68" >
<?php 
     }
?>
<?php 
if ( $copern == 8 )
     {
?>
<FORM name="fhlv1" class="obyc" method="post" action="vstm_u.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $h_cpl;?>&cislo_inv=<?php echo $h_inv;?>&copern=78" >
<?php 
     }
?>
<tr>
<td class="pvstup" width="10%" >
<?php 
if ( $copern == 8 AND $drupoh > 5 )
     {
?>
UPRAV ZARADENIE
<?php 
     }
?>
<?php 
if ( $copern == 1)
     {
?>
ZARADENIE
<?php 
     }
?>
<?php 
if ( $copern == 8 AND $drupoh < 5 )
     {
?>
UPRAV POLOéKU
<?php 
     }
?>
</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td>
</tr>

<tr>
<td class="pvstup">Inv.»Ìslo:</td>
<td class="hvstup" colspan="2">
<input class="hvstup" type="text" name="h_inv" id="h_inv" value="<?php echo $h_inv;?>"
 onclick="Fxh.style.display='none';"
 onchange="return intg(this,1,9999999999999,Inv,document.fhlv1.err_inv)" 
 onkeyup="KontrolaCisla(this, Inv)" onKeyDown="return InvEnter(event.which)"/>
<INPUT type="hidden" name="err_inv" value="0">
</td>
<td class="pvstup">N·zov:</td>
<td class="hvstup" colspan="3">
<input class="hvstup" type="text" name="h_naz" id="h_naz" size="50" maxlength="40" value="<?php echo $h_naz;?>"
 onclick="Fxh.style.display='none';"
 onKeyDown="return NazEnter(event.which)" />
</td>
<td class="pvstup">Druh obstarania:</td>
<?php
if ( $copern == 8 AND ( $drupoh == 1 OR $drupoh == 2 ) )
     {
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_majdrunak WHERE cdrn = 1 ORDER BY cdrn");
     }
if ( $copern == 8 AND ( $drupoh == 11 OR $drupoh == 12 ) )
     {
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_majdrunak WHERE cdrn > 1 ORDER BY cdrn");
     }
if ( $copern == 1 AND ( $drupoh == 1 OR $drupoh == 2 ) )
     {
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_majdrunak WHERE cdrn > 1 ORDER BY cdrn");
     }
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_dph" id="h_dph" value="<?php echo $h_dph;?>" 
 onKeyDown="return PohEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cdrn"];?>" >
<?php echo $zaznam["cdrn"];?> <?php echo $zaznam["ndrn"];?></option>
<?php endwhile;?>
</select>
</td>
</tr>

<tr>
<td class="pvstup">Popis:</td>
<td class="hvstup" colspan="2">
<input class="hvstup" type="text" name="h_pop" id="h_pop" size="40" maxlength="30" value="<?php echo $h_pop;?>"
 onKeyDown="return PopEnter(event.which)" />
</td>
<td class="pvstup">V˝robnÈ ËÌslo:</td>
<td class="hvstup" colspan="2">
<input class="hvstup" type="text" name="h_vyc" id="h_vyc" size="15" maxlength="13" value="<?php echo $h_vyc;?>"
 onKeyDown="return VycEnter(event.which)" />
</td>
<td class="pvstup">&nbsp;</td>
<td class="pvstup">Rok v˝roby:</td>
<td class="hvstup" colspan="2">
<input class="hvstup" type="text" name="h_rvr" id="h_rvr" size="5" maxlength="4" value="<?php echo $h_rvr;?>" 
 onchange="return intg(this,1800,2050,Rvr,document.fhlv1.err_rvr)" 
 onkeyup="KontrolaCisla(this, Rvr)" onKeyDown="return RvrEnter(event.which)"/>
<INPUT type="hidden" name="err_rvr" value="0">
</td>
</tr>

<tr>
<td class="pvstup">Druh majetku:</td>
<?php
if( $drupoh == 1 OR $drupoh == 11 )
{
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_majdrm ORDER BY cdrm");
?>
<td class="fmenu" colspan="2">
<select class="hvstup" size="1" name="h_drm" id="h_drm" value="<?php echo $h_drm;?>" 
 onKeyDown="return DrmEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cdrm"];?>" >
<?php echo $zaznam["cdrm"];?> <?php echo $zaznam["ndrm"];?></option>
<?php endwhile;?>
</select>
<?php
}
?>
<?php
if( $drupoh == 2 OR $drupoh == 12 )
{
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_majdimdrm ORDER BY cdbm");
?>
<td class="fmenu" colspan="2">
<select class="hvstup" size="1" name="h_drm" id="h_drm" value="<?php echo $h_drm;?>"
 onKeyDown="return DrmEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cdbm"];?>" >
<?php echo $zaznam["cdbm"];?> <?php echo $zaznam["ndbm"];?></option>
<?php endwhile;?>
</select>
<?php
}
?>
</td>
<td class="pvstup">CKP - JKP:</td>
<td class="hvstup" colspan="2">
<input class="hvstup" type="text" name="h_ckp" id="h_ckp" size="20" maxlength="15" value="<?php echo $h_ckp;?>"
 onKeyDown="return CkpEnter(event.which)" />
<input class="hvstup" type="text" name="h_jkp" id="h_jkp" size="5" maxlength="5" value="<?php echo $h_jkp;?>"
 onchange="return intg(this,0,99999,Jkp,document.fhlv1.err_jkp)" 
 onkeyup="KontrolaCisla(this, Jkp)" onKeyDown="return JkpEnter(event.which)"/>
<INPUT type="hidden" name="err_jkp" value="0">
</td>
<td class="pvstup">&nbsp;</td>
<td class="pvstup">Trieda - Obor:</td>
<td class="hvstup" colspan="2">
<input class="hvstup" type="text" name="h_tri" id="h_tri" size="5" maxlength="3" value="<?php echo $h_tri;?>"
 onchange="return intg(this,0,9,Jkp,document.fhlv1.err_tri)" 
 onkeyup="KontrolaCisla(this, Tri)" onKeyDown="return TriEnter(event.which)"/>
<INPUT type="hidden" name="err_tri" value="0">
<input class="hvstup" type="text" name="h_obo" id="h_obo" size="5" maxlength="3" value="<?php echo $h_obo;?>"
 onchange="return intg(this,0,999,Obo,document.fhlv1.err_obo)" 
 onkeyup="KontrolaCisla(this, Obo)" onKeyDown="return OboEnter(event.which)"/>
<INPUT type="hidden" name="err_obo" value="0">
</td>
</tr>

<tr>
<td class="pvstup">STR - Z¡K:</td>
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_str ORDER BY str");
?>
<td class="fmenu" colspan="2">
<select class="hvstup" size="1" name="h_str" id="h_str" value="<?php echo $h_str;?>" 
 onKeyDown="return StrEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["str"];?>" >
<?php echo $zaznam["str"];?></option>
<?php endwhile;?>
</select>
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_zak ORDER BY zak");
?>
<select class="hvstup" size="1" name="h_zak" id="h_zak" value="<?php echo $h_zak;?>" 
 onKeyDown="return ZakEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["zak"];?>" >
<?php echo $zaznam["zak"];?> <?php echo $zaznam["nza"];?></option>
<?php endwhile;?>
</select>
</td>
<td class="pvstup">Kancel·ria:</td>
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_kancelarie ORDER BY kanc");
?>
<td class="fmenu" colspan="2">
<select class="hvstup" size="1" name="h_kanc" id="h_kanc" value="<?php echo $h_kanc;?>" 
 onKeyDown="return KancEnter(event.which)" >
<option value="0" >NezaradenÈ</option>
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["kanc"];?>" >
<?php echo $zaznam["kanc"];?> <?php echo $zaznam["nkan"];?></option>
<?php endwhile;?>
</td>
<td class="pvstup">&nbsp;</td>
<td class="pvstup">OsobnÈ ËÌslo:</td>
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY prie");
?>
<td class="fmenu" colspan="2">
<select class="hvstup" size="1" name="h_oc" id="h_oc" value="<?php echo $h_oc;?>" 
 onKeyDown="return OcEnter(event.which)" >
<option value="0" >NezaradenÈ</option>
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["oc"];?>" >
<?php echo $zaznam["oc"];?> <?php echo $zaznam["prie"];?> <?php echo $zaznam["meno"];?></option>
<?php endwhile;?>
</td>
</tr>

<tr>
<td class="pvstup" colspan="10">&nbsp;</td
</tr>

<tr>
<td class="pvstup">D·tum obstarania:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_dob" id="h_dob" size="8" maxlength="10" value="<?php echo $h_dob;?>"
 onkeyup="KontrolaDatum(this, Dob)" <?php if( $mazanie == 0 ) echo "onfocus='OnfocusDob()'"; ?>
 onChange="return kontrola_datum(this, Dob, this, document.fhlv1.err_dob)" onKeyDown="return DobEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dob" value="0">
</td>
<td class="pvstup">D·tum zaradenia:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_zar" id="h_zar" size="8" maxlength="10" value="<?php echo $h_zar;?>"
 onkeyup="KontrolaDatum(this, Dob)" <?php if( $mazanie == 0 ) echo "onfocus='OnfocusZar()'"; ?>
 onChange="return kontrola_datum(this, Dob, this, document.fhlv1.err_dob)" onKeyDown="return ZarEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_zar" value="0">
</td>
</tr>

<tr>
<td class="pvstup" colspan="10">&nbsp;</td
</tr>

<?php
//len drupoh 1
if( $drupoh == 1 OR $drupoh == 11 )
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;⁄ Ë t o v n È   o d p i s y</td
</tr>
<tr>
<td class="pvstup">Odpisov· skupina:</td>
<td class="hvstup" >
<select class="hvstup" size="1" name="h_sku" id="h_sku" onmouseover="Fxh.style.display='none';" value="<?php echo $h_sku;?>"
 onKeyDown="return SkuEnter(event.which)" >
<option value="0" >neodpisovaù</option>
<option value="1" >skupina 1</option>
<option value="2" >skupina 2</option>
<option value="3" >skupina 3</option>
<option value="4" >skupina 4</option>
<option value="5" >skupina 5</option>
<option value="6" >skupina 6</option>
<option value="7" >skupina 7</option>
<option value="8" >skupina 8</option>
<option value="9" >skupina 9</option>
<option value="10" >skupina 10</option>
</td>
<td class="pvstup">SpÙsob odpisovania:</td>
<td class="hvstup" >
<select class="hvstup" size="1" name="h_spo" id="h_spo" onmouseover="Fxh.style.display='none';" value="<?php echo $h_spo;?>"
 onKeyDown="return SpoEnter(event.which)" >
<option value="1" >rovnomernÈ </option>
<option value="2" >zr˝chlenÈ </option>
</td>
<td class="pvstup">Percento odpisu:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_perc" id="h_perc" size="8" maxlength="6" value="<?php echo $h_perc;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_perc)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return PercEnter(event.which)" />
<INPUT type="hidden" name="err_perc" value="0">
</td>
<td class="pvstup">MesaËn˝ odpis:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_meso" id="h_meso" size="10" maxlength="10" value="<?php echo $h_meso;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_meso)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return MesoEnter(event.which)" />
<INPUT type="hidden" name="err_meso" value="0">
</td>
<td class="pvstup">Rok zv˝ö.ceny:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_rzv" id="h_rzv" size="5" maxlength="4" value="<?php echo $h_rzv;?>"
 onchange="return intg(this,0,2050,Rvr,document.fhlv1.err_rvr)" 
 onkeyup="KontrolaCisla(this, Rvr)" onKeyDown="return RzvEnter(event.which)"/>
</td>
</tr>
<tr>
<td class="pvstup">Obstar·vacia cena:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_cen" id="h_cen" size="14" maxlength="15" value="<?php echo $h_cen;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_cen)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return CenEnter(event.which)" />
<INPUT type="hidden" name="err_cen" value="0">
<INPUT type="hidden" name="h_mno" value="1">
</td>
<td class="pvstup">Opr·vky:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_ops" id="h_ops" size="14" maxlength="15" value="<?php echo $h_ops;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_ops)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return OpsEnter(event.which)" />
<INPUT type="hidden" name="err_ops" value="0">
</td>
<td class="pvstup">Zostatkov· cena:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_zos" id="h_zos" size="14" maxlength="15" value="<?php echo $h_zos;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_zos)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return ZosEnter(event.which)" />
<INPUT type="hidden" name="err_zos" value="0">
</td>
<td class="pvstup">Zost.cena k 1.1.:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_zss" id="h_zss" size="14" maxlength="15" value="<?php echo $h_zss;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_zss)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return ZssEnter(event.which)" />
<INPUT type="hidden" name="err_zss" value="0">
</td>
<td class="pvstup">RoËn˝ odpis:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_ros" id="h_ros" size="14" maxlength="15" value="<?php echo $h_ros;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_ros)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return RosEnter(event.which)" />
<INPUT type="hidden" name="err_ros" value="0">
</td>
</tr>

<tr>
<td class="pvstup" colspan="10">&nbsp;</td
</tr>
<tr>
<td class="pvstup" colspan="10">&nbsp;D a Ú o v È   o d p i s y</td
</tr>

<tr>
<td class="pvstup">Odpisov· skupina:</td>
<td class="hvstup" >
<select class="hvstup" size="1" name="h_sku_dan" id="h_sku_dan" onmouseover="Fxh.style.display='none';" value="<?php echo $h_sku_dan;?>"
 onKeyDown="return Sku_danEnter(event.which)" >
<option value="0" >neodpisovaù</option>
<option value="1" >skupina 1</option>
<option value="2" >skupina 2</option>
<option value="3" >skupina 3</option>
<option value="4" >skupina 4</option>
<option value="5" >skupina 5</option>
<option value="6" >skupina 6</option>
<option value="7" >skupina 7</option>
</td>
<td class="pvstup">SpÙsob odpisovania:</td>
<td class="hvstup" >
<select class="hvstup" size="1" name="h_spo_dan" id="h_spo_dan" onmouseover="Fxh.style.display='none';" value="<?php echo $h_spo_dan;?>"
 onKeyDown="return Spo_danEnter(event.which)" >
<option value="1" >rovnomernÈ </option>
<option value="2" >zr˝chlenÈ </option>
</td>
<td class="pvstup">Percento odpisu:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_perc_dan" id="h_perc_dan" size="8" maxlength="6" value="<?php echo $h_perc_dan;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_perc_dan)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return Perc_danEnter(event.which)" />
<INPUT type="hidden" name="err_perc_dan" value="0">
</td>
<td class="pvstup">RoËn˝ odpis:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_roco_dan" id="h_roco_dan" size="10" maxlength="10" value="<?php echo $h_roco_dan;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_roco_dan)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return Roco_danEnter(event.which)" />
<INPUT type="hidden" name="err_roco_dan" value="0">
</td>
</tr>
<tr>
<td class="pvstup">Obstar·vacia cena:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_cen_dan" id="h_cen_dan" size="14" maxlength="15" value="<?php echo $h_cen_dan;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_cen_dan)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return Cen_danEnter(event.which)" />
<INPUT type="hidden" name="err_cen_dan" value="0">
</td>
<td class="pvstup">Opr·vky:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_ops_dan" id="h_ops_dan" size="14" maxlength="15" value="<?php echo $h_ops_dan;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_ops_dan)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return Ops_danEnter(event.which)" />
<INPUT type="hidden" name="err_ops_dan" value="0">
</td>
<td class="pvstup">Zostatkov· cena:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_zos_dan" id="h_zos_dan" size="14" maxlength="15" value="<?php echo $h_zos_dan;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_zos_dan)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return Zos_danEnter(event.which)" />
<INPUT type="hidden" name="err_zos_dan" value="0">
</td>
<td class="pvstup">Zost.cena k 1.1.:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_zss_dan" id="h_zss_dan" size="14" maxlength="15" value="<?php echo $h_zss_dan;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_zss_dan)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return Zss_danEnter(event.which)" />
<INPUT type="hidden" name="err_zss_dan" value="0">
</td>
<td class="pvstup">RoËn˝ odpis:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_ros_dan" id="h_ros_dan" size="14" maxlength="15" value="<?php echo $h_ro_dans;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_ros_dan)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return Ros_danEnter(event.which)" />
<INPUT type="hidden" name="err_ros_dan" value="0">
</td>
</tr>
<?php
  }
//koniec drupoh 1
?>

<?php
//len drupoh 2
if( $drupoh == 2 OR $drupoh == 12 )
  {
?>
<tr>
<td class="pvstup">Obstar·vacia cena:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_cen" id="h_cen" size="14" maxlength="15" value="<?php echo $h_cen;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_cen)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return CenEnter(event.which)" />
<INPUT type="hidden" name="err_cen" value="0">
</td>
</tr>
<tr>
<td class="pvstup">Mnoûstvo:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_mno" id="h_mno" size="14" maxlength="15" value="<?php echo $h_mno;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_mno)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return MnoEnter(event.which)" />
<INPUT type="hidden" name="err_mno" value="0">
</td>
</tr>
<?php
  }
//koniec drupoh 2
?>
<tr>
<td class="pvstup">Pozn·mka:</td>
<td class="hvstup" colspan="3">
<input class="hvstup" type="text" name="h_poz" id="h_poz" size="50" maxlength="40" value="<?php echo $h_poz;?>" />
</td>
</tr>

<tr></tr>
<tr>
<?php
$majetok="maj";
if( $drupoh == 2 ) $majetok="dim";
?>
<td class="pvstup"></td>
<td class="pvstup" colspan="2" rowspan="7">
<a href='vstm_s.php?copern=30&drupoh=<?php echo $drupoh;?>&page=1&cislo_xy=<?php echo $h_inv;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie fotografie A do datab·zy" ></a>
FotoA:
<?php
$jesub=0;

if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/ainv$h_inv.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/ainv<?php echo $h_inv;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/ainv<?php echo $h_inv;?>.jpg' width=100 height=80 border=0 title="FotoA" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/ainv$h_inv.gif") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/ainv<?php echo $h_inv;?>.gif' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/ainv<?php echo $h_inv;?>.gif' width=100 height=80 border=0 title="FotoA" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/ainv$h_inv.pdf") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/ainv<?php echo $h_inv;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/ainv<?php echo $h_inv;?>.pdf' width=100 height=80 border=0 title="FotoA" ></a>
<?php
} 
?>
</td>
<td class="pvstup" colspan="2" rowspan="7">
<a href='vstm_s.php?copern=31&drupoh=<?php echo $drupoh;?>&page=1&cislo_xy=<?php echo $h_inv;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie fotografie B do datab·zy" ></a>
FotoB:
<?php
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/binv$h_inv.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/binv<?php echo $h_inv;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/binv<?php echo $h_inv;?>.jpg' width=100 height=80 border=0 title="FotoB" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/binv$h_inv.gif") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/binv<?php echo $h_inv;?>.gif' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/binv<?php echo $h_inv;?>.gif' width=100 height=80 border=0 title="FotoB" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/binv$h_inv.pdf") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/binv<?php echo $h_inv;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/binv<?php echo $h_inv;?>.pdf' width=100 height=80 border=0 title="FotoB" ></a>
<?php
} 
?>
</td>
<td class="pvstup" colspan="2" rowspan="7">
<a href='vstm_s.php?copern=32&drupoh=<?php echo $drupoh;?>&page=1&cislo_xy=<?php echo $h_inv;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie fotografie C do datab·zy" ></a>
FotoC:
<?php
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/cinv$h_inv.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/cinv<?php echo $h_inv;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/cinv<?php echo $h_inv;?>.jpg' width=100 height=80 border=0 title="FotoC" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/cinv$h_inv.gif") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/cinv<?php echo $h_inv;?>.gif' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/cinv<?php echo $h_inv;?>.gif' width=100 height=80 border=0 title="FotoC" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/cinv$h_inv.pdf") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/cinv<?php echo $h_inv;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/cinv<?php echo $h_inv;?>.pdf' width=100 height=80 border=0 title="FotoC" ></a>
<?php
} 
?>
</td>
<td class="pvstup" colspan="2" rowspan="7">
<a href='vstm_s.php?copern=33&drupoh=<?php echo $drupoh;?>&page=1&cislo_xy=<?php echo $h_inv;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie fotografie D do datab·zy" ></a>
FotoD:
<?php
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/dinv$h_inv.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/dinv<?php echo $h_inv;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/dinv<?php echo $h_inv;?>.jpg' width=100 height=80 border=0 title="FotoD" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/dinv$h_inv.gif") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/dinv<?php echo $h_inv;?>.gif' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/dinv<?php echo $h_inv;?>.gif' width=100 height=80 border=0 title="FotoD" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$majetok/dinv$h_inv.pdf") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/dinv<?php echo $h_inv;?>.pdf' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/<?php echo $majetok;?>/dinv<?php echo $h_inv;?>.pdf' width=100 height=80 border=0 title="FotoD" ></a>
<?php
} 
?>
</td>
</tr>
<tr><td class="pvstup" width="10%"></td></tr>
<tr><td class="pvstup" width="10%"></td></tr>
<tr><td class="pvstup" width="10%"></td></tr>
<tr><td class="pvstup" width="10%"></td></tr>
<tr><td class="pvstup" width="10%"></td></tr>
<tr><td class="pvstup" width="10%"></td></tr>


<tr></tr><tr></tr>
</table>
<br clear=left>
<tr>
<span id="Fxh" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Inv" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Invent·rne ËÌslo musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999999</span>
<span id="Rvr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Rok musÌ byù celÈ ËÌslo v rozsahu 1800 aû 2050</span>
<span id="Obo" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Obor musÌ byù celÈ ËÌslo v rozsahu 0 aû 999</span>
<span id="Tri" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Trieda musÌ byù celÈ ËÌslo v rozsahu 0 aû 9</span>
<span id="Jkp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 JKP musÌ byù celÈ ËÌslo v rozsahu 0 aû 99999</span>
<span id="Dob" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Zar" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="H2d" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo max. 2 desatinnÈ miesta</span>
<span id="Dtv" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
</tr>

<table class="vstup" width="100%">
<tr>
<td width="15%" >
<input type="submit" id="uloh" name="uloh" value="Uloûiù"  
 onmouseover="UkazSkryj('Uloûiù poloûku , n·vrat do zoznamu majetku'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Uloûiù poloûku' >
</td>
<td class="obyc" align="right" colspan="2">
<?php                           }  ?>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&copern=1" >
<td class="obyc" width="25%" align="right"><INPUT type="submit" id="stornou" name="stornou" value="Zoznam" align="right"
 onmouseover="UkazSkryj('Neuloûiù poloûku , n·vrat do zoznamu majetku')" onmouseout="Okno.style.display='none';"></td>
<td class="obyc" width="20%" >&nbsp;</td><td class="obyc" width="20%" >&nbsp;</td><td class="obyc" width="20%" >&nbsp;</td>
</tr>
</FORM>
</table>

<?php
     }
//koniec zaradenie novej polozky copern=1 a uprava polozky copern=8
?>

<?php 
//vymazanie polozky a pohybu dlhodoby
if ( $copern == 6 OR $copern == 106 OR $copern == 4 OR $copern == 5 )
     {

if ( $drupoh == 1 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majmaj WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

if ( $drupoh == 11 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majpoh WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

if ( $drupoh == 2 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majdim WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

if ( $drupoh == 12 )
 {
$sqltx = "SELECT * FROM F$kli_vxcf"."_majpohdim WHERE cpl = '$cislo_cpl' ";
$sql = mysql_query("$sqltx");
 }

  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $majmaj=mysql_fetch_object($sql);
?>

<table class="vstup" width="100%" height="140px" align="left">
<FORM name="fhlv1" class="obyc" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&cislo_inr=<?php echo $majmaj->hx1;?>
&cislo_cpl=<?php echo $cislo_cpl;?>&cislo_inv=<?php echo $majmaj->inv;?>&cislo_poh=<?php echo $cislo_poh;?>&copern=<?php echo 1*$copern+10;?>
&h_mnvx=<?php echo $majmaj->mno;?>" >
<tr>
<td class="pvstup" width="10%" >
<?php 
if ( $majmaj->poh == 1)
     {
?>
POLOéKA MAJETKU
<?php 
     }
?>
<?php 
if ( $majmaj->poh == 2)
     {
?>
ZARADENIE
<?php 
     }
?>
<?php 
if ( $majmaj->poh == 3)
     {
?>
VYRADENIE
<?php 
     }
?>
<?php 
if ( $majmaj->poh == 4)
     {
?>
ZV›äENIE
<?php 
     }
?>
<?php 
if ( $majmaj->poh == 5)
     {
?>
ROZDELENIE
<?php 
     }
?>
</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td><td class="pvstup" width="10%" >&nbsp;</td>
<td class="pvstup" width="10%" >&nbsp;</td>
</tr>

<tr>
<td class="pvstup">Inv.»Ìslo:</td><td class="hvstup" colspan="2"><?php echo $majmaj->inv; ?></td>
<td class="pvstup">N·zov:</td><td class="hvstup" colspan="3"><?php echo $majmaj->naz; ?></td>
<td class="pvstup">Pohyb/Druh:</td><td class="hvstup" ><?php echo $majmaj->poh; ?>/<?php echo $majmaj->dph; ?></td>
</tr>

<tr>
<td class="pvstup">Popis:</td><td class="hvstup" colspan="2"><?php echo $majmaj->pop; ?></td>
<td class="pvstup">V˝robnÈ ËÌslo:</td><td class="hvstup" colspan="2"><?php echo $majmaj->vyc; ?></td>
<td class="pvstup">&nbsp;</td><td class="pvstup">Rok v˝roby:</td><td class="hvstup" colspan="2"><?php echo $majmaj->rvr; ?></td>
</tr>

<tr>
<td class="pvstup">Druh majetku:</td><td class="hvstup" ><?php echo $majmaj->drm; ?></td>
<td class="pvstup">&nbsp;</td>
<td class="pvstup">CKP - JKP:</td><td class="hvstup" colspan="2"><?php echo $majmaj->ckp; ?> - <?php echo $majmaj->jkp; ?></td>
<td class="pvstup">&nbsp;</td>
<td class="pvstup">Trieda - Obor:</td><td class="hvstup" colspan="2"><?php echo $majmaj->tri; ?> - <?php echo $majmaj->obo; ?></td>
</tr>

<tr>
<td class="pvstup">STR - Z¡K:</td><td class="hvstup"  colspan="2"><?php echo $majmaj->str; ?> - <?php echo $majmaj->zak; ?></td>
<td class="pvstup">Kancel·ria:</td><td class="hvstup"  colspan="2"><?php echo $majmaj->kanc; ?></td>
<td class="pvstup">&nbsp;</td>
<td class="pvstup">OsobnÈ ËÌslo:</td><td class="hvstup" ><?php echo $majmaj->oc; ?></td>
</tr>

<tr>
<td class="pvstup" colspan="10">&nbsp;</td
</tr>

<tr>
<td class="pvstup">D·tum obstarania:</td><td class="hvstup" ><?php echo $majmaj->dob; ?></td>
<td class="pvstup">D·tum zaradenia:</td><td class="hvstup" ><?php echo $majmaj->zar; ?></td>
</tr>

<tr>
<td class="pvstup" colspan="10">&nbsp;</td
</tr>


<?php
//len drupoh 1
if( $drupoh == 1 OR $drupoh == 11 )
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;⁄ Ë t o v n È   o d p i s y</td
</tr>

<tr>
<td class="pvstup">Odpisov· skupina:</td><td class="hvstup" ><?php echo $majmaj->sku; ?></td>
<td class="pvstup">SpÙsob odpisovania:</td><td class="hvstup" ><?php echo $majmaj->spo; ?></td>
<td class="pvstup">Percento odpisu:</td><td class="hvstup" ><?php echo $majmaj->perc; ?></td></td>
<td class="pvstup">Zadaj mesaËn˝ odpis:</td><td class="hvstup" ><?php echo $majmaj->meso; ?></td></td>
<td class="pvstup">Rok zv˝ö.ceny:</td><td class="hvstup" ><?php echo $majmaj->rzv; ?></td>
</tr>
<tr>
<td class="pvstup">Obstar·vacia cena:</td><td class="hvstup" ><?php echo $majmaj->cen; ?></td>
<td class="pvstup">Opr·vky:</td><td class="hvstup" ><?php echo $majmaj->ops; ?></td>
<td class="pvstup">Zostatkov· cena:</td><td class="hvstup" ><?php echo $majmaj->zos; ?></td>
<td class="pvstup">Zost.cena k 1.1.:</td><td class="hvstup" ><?php echo $majmaj->zss; ?></td>
<td class="pvstup">RoËn˝ odpis:</td><td class="hvstup" ><?php echo $majmaj->ros; ?></td>
</tr>

<tr>
<td class="pvstup" colspan="10">&nbsp;</td
</tr>
<tr>
<td class="pvstup" colspan="10">&nbsp;D a Ú o v È   o d p i s y</td
</tr>

<tr>
<td class="pvstup">Odpisov· skupina:</td><td class="hvstup" ><?php echo $majmaj->sku_dan; ?></td>
<td class="pvstup">SpÙsob odpisovania:</td><td class="hvstup" ><?php echo $majmaj->spo_dan; ?></td>
<td class="pvstup">Percento odpisu:</td><td class="hvstup" ><?php echo $majmaj->perc_dan; ?></td></td>
<td class="pvstup">Zadaj roËn˝ odpis:</td><td class="hvstup" ><?php echo $majmaj->roco_dan; ?></td></td>
</tr>
<tr>
<td class="pvstup">Obstar·vacia cena:</td><td class="hvstup" ><?php echo $majmaj->cen_dan; ?></td>
<td class="pvstup">Opr·vky:</td><td class="hvstup" ><?php echo $majmaj->ops_dan; ?></td>
<td class="pvstup">Zostatkov· cena:</td><td class="hvstup" ><?php echo $majmaj->zos_dan; ?></td>
<td class="pvstup">Zost.cena k 1.1.:</td><td class="hvstup" ><?php echo $majmaj->zss_dan; ?></td>
<td class="pvstup">RoËn˝ odpis:</td><td class="hvstup" ><?php echo $majmaj->ros_dan; ?></td>
</tr>
<?php
//len drupoh 1
  }
?>

<?php
//len drupoh 2
if( $drupoh == 2 OR $drupoh == 12 )
  {
?>

<tr>
<td class="pvstup">Obstar·vacia cena:</td><td class="hvstup" ><?php echo $majmaj->cen; ?></td>
</tr>
<tr>
<td class="pvstup">Mnoûstvo:</td><td class="hvstup" ><?php echo $majmaj->mno; ?></td>
</tr>
<?php
//len drupoh 2
  }
?>

<tr>
<td class="pvstup">Pozn·mka:</td><td class="hvstup" colspan="3"><?php echo $majmaj->poz; ?></td>
</tr>

<?php
//len copern 106
if( $copern == 106 )
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;</td>
</tr>
<tr>
<td class="pvstup" colspan="10">VYRADENIE MAJETKU</td>
</tr>
<tr>
<?php
//len drupoh 2
if( $drupoh == 2 )
  {
?>
<tr>
<td class="pvstup">Vyr.mnoûstvo:</td><td class="hvstup" >
<input class="hvstup" type="text" name="h_mnv" id="h_mnv" size="5" maxlength="3" value="1"
 onchange="return cele(this,0,999,H2d,2,document.fhlv1.err_mnv)" 
 onkeyup="KontrolaDcisla(this, H2d)"  onKeyDown="return MnvEnter(event.which)" />
<INPUT type="hidden" name="err_mnv" value="0">
</td>
</tr>
<?php
//len drupoh 2
  }
?>

<td class="pvstup">Druh vyradenia:</td>
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_majdruvyr WHERE cdrv > 0 ORDER BY cdrv");
?>
<td class="fmenu">
<select class="hvstup" size="1" name="h_phv" id="h_phv" value="<?php echo $h_phv;?>" 
 onKeyDown="return PhvEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cdrv"];?>" >
<?php echo $zaznam["cdrv"];?> <?php echo $zaznam["ndrv"];?></option>
<?php endwhile;?>
</select>
</td>
</tr>
<tr>
<td class="pvstup">D·tum vyradenia:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_dtv" id="h_dtv" size="8" maxlength="10" value="<?php echo $h_dtv;?>"
 onkeyup="KontrolaDatum(this, Dtv)" <?php if( $mazanie == 0 ) echo "onfocus='OnfocusDtv()'"; ?>
 onChange="return kontrola_datum(this, Dtv, this, document.fhlv1.err_dtv)" onKeyDown="return DtvEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dtv" value="0">
</td>
</tr>
<tr>
<td class="pvstup">DÙvod vyradenia:</td>
<td class="hvstup" colspan="4">
<input class="hvstup" type="text" name="h_dvv" id="h_dvv" size="80" maxlength="80" value="<?php echo $h_dvv;?>" />
</td>
</tr>
<?php
//len copern 106
  }
?>


<?php
//len copern 4
if( $copern == 4 )
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;</td>
</tr>
<tr>
<td class="pvstup" colspan="10">ZV›äENIE HODNOTY</td>
</tr>
<tr>
<td class="pvstup">Hodnota zv˝öenia:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_phz" id="h_phz" size="14" maxlength="15" value="<?php echo $h_phz;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_phz)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return PhzEnter(event.which)" />
<INPUT type="hidden" name="err_phz" value="0">
</td>
<td class="pvstup" colspan="3">&nbsp;Zadajte o koæko <?php echo $mena1;?> chcete zv˝öiù pÙvodn˙ obstar·vaciu cenu</td>
</tr>
<tr>
<td class="pvstup">D·tum zv˝öenia:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_dtz" id="h_dtz" size="8" maxlength="10" value="<?php echo $h_dtz;?>"
 onkeyup="KontrolaDatum(this, Dtv)" <?php if( $mazanie == 0 ) echo "onfocus='OnfocusDtz()'"; ?>
 onChange="return kontrola_datum(this, Dtv, this, document.fhlv1.err_dtz)" onKeyDown="return DtzEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dtz" value="0">
</td>
</tr>
<tr>
<td class="pvstup">DÙvod zv˝öenia:</td>
<td class="hvstup" colspan="4">
<input class="hvstup" type="text" name="h_dvz" id="h_dvz" size="80" maxlength="80" value="<?php echo $h_dvz;?>" />
</td>
</tr>
<?php
//len copern 4
  }
?>

<?php
//len copern 5
if( $copern == 5 )
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;</td>
</tr>
<tr>
<td class="pvstup" colspan="10">ROZDELENIE HODNOTY</td>
</tr>
<tr>
<td class="pvstup">Oddeliù z CEN:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_cer" id="h_cer" size="14" maxlength="15" value="<?php echo $h_cer;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_cer)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return CerEnter(event.which)" />
<INPUT type="hidden" name="err_cer" value="0">
</td>
<td class="pvstup" colspan="3">&nbsp;Zadajte koæko <?php echo $mena1;?> chcete oddeliù z pÙvodnej obstar·vacej ceny</td>
</tr>
<tr>
<td class="pvstup">Oddeliù z OPS:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_opr" id="h_opr" size="14" maxlength="15" value="<?php echo $h_opr;?>"
 onchange="return cele(this,0,999999999,H2d,2,document.fhlv1.err_opr)" 
 onkeyup="KontrolaDcisla(this, H2d)" 
 onKeyDown="return OprEnter(event.which)" />
<INPUT type="hidden" name="err_opr" value="0">
</td>
<td class="pvstup" colspan="3">&nbsp;Zadajte koæko <?php echo $mena1;?> chcete oddeliù z pÙvodn˝ch opr·vok</td>
</tr>
<tr>
<td class="pvstup">NovÈ INV.ËÌslo:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_inr" id="h_inr" size="8" maxlength="10" value="<?php echo $h_inr;?>"
 onchange="return intg(this,1,9999999999999,Inv,document.fhlv1.err_inr)" 
 onkeyup="KontrolaCisla(this, Inv)" onKeyDown="return InrEnter(event.which)"/>
<input class="hvstup" type="hidden" name="err_inr" value="0">
</td>
</tr>
<tr>
<td class="pvstup">D·tum rozdelenia:</td>
<td class="hvstup" >
<input class="hvstup" type="text" name="h_dtr" id="h_dtr" size="8" maxlength="10" value="<?php echo $h_dtr;?>"
 onkeyup="KontrolaDatum(this, Dtv)" <?php if( $mazanie == 0 ) echo "onfocus='OnfocusDtr()'"; ?>
 onChange="return kontrola_datum(this, Dtv, this, document.fhlv1.err_dtz)" onKeyDown="return DtrEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dtr" value="0">
</td>
</tr>
<tr>
<td class="pvstup">DÙvod rozdelenia:</td>
<td class="hvstup" colspan="4">
<input class="hvstup" type="text" name="h_dvr" id="h_dvr" size="80" maxlength="80" value="<?php echo $h_dvz;?>" />
</td>
</tr>
<?php
//len copern 5
  }
?>

<?php
//len copern 6 a pohyb 3
if( $copern == 6 AND $cislo_poh == 3)
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;</td>
</tr>
<tr>
<td class="pvstup">Druh vyradenia:</td><td class="hvstup" ><?php echo $majmaj->dph; ?></td>
</tr>
<tr>
<td class="pvstup">D·tum vyradenia:</td><td class="hvstup" ><?php echo $majmaj->dap; ?></td>
</tr>
<tr>
<td class="pvstup">DÙvod vyradenia:</td><td class="hvstup" colspan="4"><?php echo $majmaj->dvp; ?></td>
</tr>
<?php
//len copern 6 a cislo_poh 3
  }
?>

<?php
//len copern 6 a pohyb 4
if( $copern == 6 AND $cislo_poh == 4)
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;</td>
</tr>
<tr>
<td class="pvstup">Hodnota zv˝öenia:</td><td class="hvstup" ><?php echo $majmaj->hd1; ?></td>
</tr>
<tr>
<td class="pvstup">D·tum zv˝öenia:</td><td class="hvstup" ><?php echo $majmaj->dap; ?></td>
</tr>
<tr>
<td class="pvstup">DÙvod zv˝öenia:</td><td class="hvstup" colspan="4"><?php echo $majmaj->dvp; ?></td>
</tr>
<?php
//len copern 6 a cislo_poh 4
  }
?>

<?php
//len copern 6 a pohyb 5
if( $copern == 6 AND $cislo_poh == 5)
  {
?>
<tr>
<td class="pvstup" colspan="10">&nbsp;</td>
</tr>
<tr>
<td class="pvstup">Oddeliù z CEN:</td><td class="hvstup" ><?php echo $majmaj->hd1; ?></td>
</tr>
<tr>
<td class="pvstup">Oddeliù z OPS:</td><td class="hvstup" ><?php echo $majmaj->hd2; ?></td>
</tr>
<tr>
<td class="pvstup">NovÈ INV.ËÌslo:</td><td class="hvstup" ><?php echo $majmaj->hx1; ?></td>
</tr>
<tr>
<td class="pvstup">D·tum rozdelenia:</td><td class="hvstup" ><?php echo $majmaj->dap; ?></td>
</tr>
<tr>
<td class="pvstup">DÙvod rozdelenia:</td><td class="hvstup" colspan="4"><?php echo $majmaj->dvp; ?></td>
</tr>
<?php
//len copern 6 a cislo_poh 4
  }
?>


<tr></tr><tr></tr>
</table>
<br clear=left>


<table class="vstup" width="100%">
<tr>
<?php
if( $copern == 6 )
  {
?>
<td width="15%" >
<input type="submit" id="uloh" name="uloh" value="Vymazaù"  
 onmouseover="UkazSkryj('Vymazaù poloûku , n·vrat do zoznamu majetku'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Uloûiù poloûku' >
</td>
<td class="obyc" align="right">
<?php                           }  ?>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&copern=1" >
<td class="obyc" width="25%" align="right"><INPUT type="submit" id="stornou" name="stornou" value="Storno" align="right"
 onmouseover="UkazSkryj('Nevymazaù poloûku , n·vrat do zoznamu majetku')" onmouseout="Okno.style.display='none';"></td>
<?php
  }
?>
<?php
if( $copern == 106 )
  {
?>
<td width="15%" >
<input type="submit" id="uloh" name="uloh" value="Vyradiù"  
 onmouseover="UkazSkryj('Vyradiù poloûku , n·vrat do zoznamu majetku'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Vyradiù poloûku' >
</td>
<td class="obyc" align="right">
<?php                           }  ?>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&copern=1" >
<td class="obyc" width="25%" align="right"><INPUT type="submit" id="stornou" name="stornou" value="Storno" align="right"
 onmouseover="UkazSkryj('Nevyradiù poloûku , n·vrat do zoznamu majetku')" onmouseout="Okno.style.display='none';"></td>
<?php
  }
?>
<?php
if( $copern == 4 )
  {
?>
<td width="15%" >
<input type="submit" id="uloh" name="uloh" value="Zv˝öiù"  
 onmouseover="UkazSkryj('Zv˝öiù hodnotu , n·vrat do zoznamu majetku'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Zv˝öiù hodnotu' >
</td>
<td class="obyc" align="right">
<?php                           }  ?>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&copern=1" >
<td class="obyc" width="25%" align="right"><INPUT type="submit" id="stornou" name="stornou" value="Storno" align="right"
 onmouseover="UkazSkryj('Nezv˝öiù hodnotu , n·vrat do zoznamu majetku')" onmouseout="Okno.style.display='none';"></td>
<?php
  }
?>
<?php
if( $copern == 5 )
  {
?>
<td width="15%" >
<input type="submit" id="uloh" name="uloh" value="Rozdeliù"  
 onmouseover="UkazSkryj('Rozdeliù hodnotu , n·vrat do zoznamu majetku'); return Povol_uloz();"
 onmouseout="Okno.style.display='none';" >
<SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN>
</td>
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Rozdeliù poloûku' >
</td>
<td class="obyc" align="right">
<?php                           }  ?>
</td>
</FORM>
<FORM name="formh4" class="obyc" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&copern=1" >
<td class="obyc" width="25%" align="right"><INPUT type="submit" id="stornou" name="stornou" value="Storno" align="right"
 onmouseover="UkazSkryj('Nerozdeliù hodnotu , n·vrat do zoznamu majetku')" onmouseout="Okno.style.display='none';"></td>
<?php
  }
?>
<td class="obyc" width="20%" >&nbsp;</td><td class="obyc" width="20%" >&nbsp;</td><td class="obyc" width="20%" >&nbsp;</td>
</tr>
</FORM>
</table>

<tr>
<span id="Fxh" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Inv" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Invent·rne ËÌslo musÌ byù celÈ ËÌslo v rozsahu 1 aû 9999999999999</span>
<span id="Rvr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Rok musÌ byù celÈ ËÌslo v rozsahu 1800 aû 2050</span>
<span id="Obo" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Obor musÌ byù celÈ ËÌslo v rozsahu 0 aû 999</span>
<span id="Tri" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Trieda musÌ byù celÈ ËÌslo v rozsahu 0 aû 9</span>
<span id="Jkp" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 JKP musÌ byù celÈ ËÌslo v rozsahu 0 aû 99999</span>
<span id="Dob" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Zar" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="H2d" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo max. 2 desatinnÈ miesta</span>
<span id="Dtv" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
</tr>

<?php
  }
//koniec cyklu na citanie udajov
     }
//koniec vymazania polozky a pohybu copern=6
?>





<?php
$cislista = include("maj_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
