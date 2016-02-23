<HTML>
<?php
$sys = 'HIM';
$urov = 2000;
$cslm=500501;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

//copern=2 drupoh=1 ide na copern=1 mesacne odpisy
//copern=3 drupoh=3 danove odpisy
//copern=4 drupoh=4 odpisovy plan
if( $copern != 1 AND $copern != 2 AND $copern != 3 AND $copern != 4 ) exit;

if( $copern == 2 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete spracovaù mesaËnÈ odpisy majetku za obdobie <?php echo $kli_vume; ?> ?") )
         { window.close();  }
else
  var okno = window.open("../majetok/mesodp.php?copern=1&drupoh=1&page=1","_self");
</script>

<?php
exit;
}


require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


$sqltt = "SELECT * FROM F$kli_vxcf"."_majmaj WHERE inv > 0 ORDER BY inv ";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);



$dsqlt = "INSERT INTO F$kli_vxcf"."_majtextmaj (invt) VALUES ( $riadok->inv ) ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

}
$i=$i+1;
$newdok=$newdok+1;
  }

//exit;


//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if( $copern == 1 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_majmajmes WHERE ume > 0 ORDER BY ume DESC LIMIT 1";
$posl = mysql_query("$poslhh"); 
  if (@$zaznam=mysql_data_seek($posl,0))
  {
  $posled=mysql_fetch_object($posl);
  $poslume = $posled->ume;
  }

if( $kli_vume < $poslume )
{
?>
<script type="text/javascript">
alert ("Bol spracovan˝ mesaËn˝ odpis za obdobie <?php echo $poslume; ?> , nemÙûete teraz spracovaù mesaËnÈ odpisy za obdobie <?php echo $kli_vume; ?> !");
window.close();
</script>
<?php
exit;
}
    }

if( $copern == 1 )
{

//Vytvorenie zalohy
$sql = "SELECT * FROM F$kli_vxcf"."_majmaj_$kli_vmes"."_$kli_vrok";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<majmaj
(
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   druh         INT(2),
   drm          INT(7),
   inv          DECIMAL(15,0) UNIQUE,
   naz          VARCHAR(40),
   pop          VARCHAR(40),
   poz          VARCHAR(40),
   vyc          VARCHAR(40),
   rvr          INT(4),
   tri          INT(3),
   obo          INT(3),
   jkp          INT(5),
   ckp          VARCHAR(15),
   drh1         INT,
   drh2         INT,
   mno          DECIMAL(10,2),
   dob          DATE,
   dox          INT,
   zar          DATE,
   rzv          INT(4),
   str          INT,
   zak          INT,
   oc           INT,
   kanc         INT,
   spo          INT,
   sku          INT,
   perc         DECIMAL(10,2),
   meso         DECIMAL(10,2),
   cen          DECIMAL(10,2),
   ops          DECIMAL(10,2),
   zos          DECIMAL(10,2),
   zss          DECIMAL(10,2),
   mes          DECIMAL(10,2),
   ros          DECIMAL(10,2),
   rop          DECIMAL(10,2),
   spo_dan      INT,
   sku_dan      INT,
   perc_dan     DECIMAL(10,2),
   roco_dan     DECIMAL(10,2),
   cen_dan      DECIMAL(10,2),
   ops_dan      DECIMAL(10,2),
   zos_dan      DECIMAL(10,2),
   zss_dan      DECIMAL(10,2),
   mes_dan      DECIMAL(10,2),
   ros_dan      DECIMAL(10,2),
   rop_dan      DECIMAL(10,2),
   xmax         INT,
   cen_max      DECIMAL(10,2),
   ops_max      DECIMAL(10,2),
   zos_max      DECIMAL(10,2),
   zss_max      DECIMAL(10,2),
   mes_max      DECIMAL(10,2),
   ros_max      DECIMAL(10,2),
   rop_max      DECIMAL(10,2),
   poh          INT,
   dph          INT,
   dap          DATE,
   dvp          VARCHAR(40),
   dvt          TEXT,
   hd1          DECIMAL(10,2),
   hd2          DECIMAL(10,2),
   hd3          DECIMAL(10,2),
   hd4          DECIMAL(10,2),
   hd5          DECIMAL(10,2),
   hx1          INT,
   hx2          INT,
   hx3          INT,
   hx4          INT,
   hx5          INT,
   id           INT,
   datm         TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
majmaj;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_majmaj_'.$kli_vmes.'_'.$kli_vrok.$sqlt;
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majmaj_$kli_vmes"."_$kli_vrok".
" SELECT *".
" FROM F$kli_vxcf"."_majmaj".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

$sqlt = <<<majmaj
(
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   druh         INT(2),
   drm          INT(7),
   inv          DECIMAL(15,0),
   naz          VARCHAR(40),
   pop          VARCHAR(40),
   poz          VARCHAR(40),
   vyc          VARCHAR(40),
   rvr          INT(4),
   tri          INT(3),
   obo          INT(3),
   jkp          INT(5),
   ckp          VARCHAR(15),
   drh1         INT,
   drh2         INT,
   mno          DECIMAL(10,2),
   dob          DATE,
   dox          INT,
   zar          DATE,
   rzv          INT(4),
   str          INT,
   zak          INT,
   oc           INT,
   kanc         INT,
   spo          INT,
   sku          INT,
   perc         DECIMAL(10,2),
   meso         DECIMAL(10,2),
   cen          DECIMAL(10,2),
   ops          DECIMAL(10,2),
   zos          DECIMAL(10,2),
   zss          DECIMAL(10,2),
   mes          DECIMAL(10,2),
   ros          DECIMAL(10,2),
   rop          DECIMAL(10,2),
   spo_dan      INT,
   sku_dan      INT,
   perc_dan     DECIMAL(10,2),
   roco_dan     DECIMAL(10,2),
   cen_dan      DECIMAL(10,2),
   ops_dan      DECIMAL(10,2),
   zos_dan      DECIMAL(10,2),
   zss_dan      DECIMAL(10,2),
   mes_dan      DECIMAL(10,2),
   ros_dan      DECIMAL(10,2),
   rop_dan      DECIMAL(10,2),
   xmax         INT,
   cen_max      DECIMAL(10,2),
   ops_max      DECIMAL(10,2),
   zos_max      DECIMAL(10,2),
   zss_max      DECIMAL(10,2),
   mes_max      DECIMAL(10,2),
   ros_max      DECIMAL(10,2),
   rop_max      DECIMAL(10,2),
   poh          INT,
   dph          INT,
   dap          DATE,
   dvp          VARCHAR(40),
   dvt          TEXT,
   hd1          DECIMAL(10,2),
   hd2          DECIMAL(10,2),
   hd3          DECIMAL(10,2),
   hd4          DECIMAL(10,2),
   hd5          DECIMAL(10,2),
   hx1          INT,
   hx2          INT,
   hx3          INT,
   hx4          INT,
   hx5          INT,
   id           INT,
   datm         TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
majmaj;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_majmajmes'.$sqlt;
$vysledek = mysql_query("$sql");


}
//koniec vytvorenie zalohy
else
{
?>
<script type="text/javascript" > 
alert ("MesaËnÈ odpisy za obdobie <?php echo $kli_vume; ?> uû boli spracovanÈ \r MÙûete ich zruöiù a spracovaù znovu .");
 location.href='zrsmes.php?copern=1&drupoh=<?php echo $drupoh; ?>&page=1' 
</script>
<?php
exit;
}

}
//koniec copern=1


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_odpprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_odpprx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<odpprc
(
   pol          INT,
   druh         INT(2),
   drm          INT(7),
   inv          DECIMAL(15,0),
   naz          VARCHAR(40),
   zar          DATE,
   rzv          INT(4),
   str          INT,
   zak          INT,
   cen          DECIMAL(12,2),
   ops          DECIMAL(12,2),
   zos          DECIMAL(12,2),
   spo          INT,
   sku          INT,
   perc         DECIMAL(10,2),
   meso         DECIMAL(10,2),
   zss          DECIMAL(12,2),
   ros          DECIMAL(12,2),
   rop          DECIMAL(12,2),
   mes          DECIMAL(12,2),
   cs1          DECIMAL(12,2),
   cs2          DECIMAL(12,2),
   cs3          DECIMAL(12,2),
   koe          DECIMAL(12,2),
   sad          DECIMAL(12,2),
   zvys         INT,
   drok         INT,
   orok         INT,
   zrok         INT
);
odpprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_odpprc'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_odpprx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//mesacny odpis operacie pred mesacnym odpisom
if( $copern == 1 )
          {

//pripocitaj zaradene k majmaj
$dsqlt = "INSERT INTO F$kli_vxcf"."_majmaj".
" SELECT 0,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majpoh".
" WHERE F$kli_vxcf"."_majpoh.ume = $kli_vume AND F$kli_vxcf"."_majpoh.poh = 2".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//odpocitaj vyradene
$dslqlt = "SELECT * FROM F$kli_vxcf"."_majpoh WHERE ( ume = $kli_vume AND poh = 3 )";
$dslql = mysql_query("$dslqlt");

$pzlaz = mysql_num_rows($dslql);

$j = 0;
   while ($j < $pzlaz )
   {
  if (@$dzak=mysql_data_seek($dslql,$j))
  {

$dlriadok=mysql_fetch_object($dslql);

$zmaztt = "DELETE FROM F$kli_vxcf"."_majmaj WHERE inv='$dlriadok->inv' ";
$zmazane = mysql_query("$zmaztt");

  }
$j = $j + 1;
   }

//prepocitaj zvysenie
$dslqlt = "SELECT * FROM F$kli_vxcf"."_majpoh WHERE ( ume = $kli_vume AND poh = 4 AND hx2 = 0 )";
$dslql = mysql_query("$dslqlt");

$pzlaz = mysql_num_rows($dslql);

$j = 0;
   while ($j < $pzlaz )
   {
  if (@$dzak=mysql_data_seek($dslql,$j))
  {

$dlriadok=mysql_fetch_object($dslql);


$uprtt = "UPDATE F$kli_vxcf"."_majmaj SET cen=cen+($dlriadok->hd1), zss=zss+($dlriadok->hd1), zos=cen-ops, hx1=rzv, rzv='$dlriadok->rzv',".
" cen_dan=cen_dan+($dlriadok->hd1), zss_dan=zss_dan+($dlriadok->hd1), zos_dan=cen_dan-ops_dan, hd1='$dlriadok->hd1' ".
" WHERE inv='$dlriadok->inv' AND cen='$dlriadok->cen'";
//echo $uprtt;
$upravene = mysql_query("$uprtt"); 


  }
$j = $j + 1;
   }

//exit;

//vykonaj rozdelenie
$dslqlt = "SELECT * FROM F$kli_vxcf"."_majpoh WHERE ( ume = $kli_vume AND poh = 5 AND hx2 = 0 )";
//echo $dslqlt;
$dslql = mysql_query("$dslqlt");

$pzlaz = mysql_num_rows($dslql);
$pzlaz=0;
//rozdelenie som nenechal znovu vykonat lebo problemy
$j = 0;
   while ($j < $pzlaz )
   {
  if (@$dzak=mysql_data_seek($dslql,$j))
  {

$dlriadok=mysql_fetch_object($dslql);


$uprtt = "UPDATE F$kli_vxcf"."_majmaj SET cen=cen-($dlriadok->hd1), ops=ops-($dlriadok->hd2), zos=cen-ops, zss=zos+ros,".
" cen_dan=cen_dan-($dlriadok->hd1), ops_dan=ops_dan-($dlriadok->hd2), zos_dan=cen_dan-ops_dan, zss_dan=zos_dan+ros_dan,".
" dap=$dlriadok->dap, hd1=$dlriadok->hd1, hd2=$dlriadok->hd2, datm=now() WHERE inv=$dlriadok->inv ";
//echo $uprtt;
$upravene = mysql_query("$uprtt"); 

$dsqlt = "INSERT INTO F$kli_vxcf"."_majmaj".
" SELECT 0,ume,druh,drm,hx1,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,hd1,hd2,(hd1-hd2),(hd1-hd2),0,0,0,spo_dan,sku_dan,perc_dan,roco_dan,hd1,hd2,(hd1-hd2),(hd1-hd2),0,0,0,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,1,1,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majpoh".
" WHERE inv=$dlriadok->inv AND poh = 5 AND hx1=$dlriadok->hx1".
"";
//echo $dsqlt;
$ulozene = mysql_query("$dsqlt");


  }
$j = $j + 1;
   }

//oznac pohyby hx2=1
$sqtoz = "UPDATE F$kli_vxcf"."_majpoh".
" SET hx2=1".
" WHERE ume = $kli_vume ";
$oznac = mysql_query("$sqtoz");

//koniec operacie pred mesacnym odpisom
          }

//daj do odpprc stav majetku po operaciach
if( $drupoh == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_odpprc$kli_uzid".
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,spo,sku,perc,meso,zss,ros,0,0,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_majmaj".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");
$majsodp="majsodp";
}

//daj do odpprc stav majetku pre danovy odpis a majsodp uprav aby bral danove odpisy 
if( $drupoh == 3 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_odpprc$kli_uzid".
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen_dan,(cen_dan-zss_dan),zss_dan,spo_dan,sku_dan,perc_dan,roco_dan,zss_dan,0,0,0,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_majmaj".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcf"."_dansodp$kli_uzid"." SELECT * FROM F$kli_vxcf"."_majsodp";
$dsql = mysql_query("$dsqlt");

//nastav danove do mesacnych
$sqtoz = "UPDATE F$kli_vxcf"."_dansodp$kli_uzid".
" SET rdoba1=rdoba1_dan, rdoba2=rdoba2_dan, rdoba3=rdoba3_dan, rdoba4=rdoba4_dan, rdoba5=rdoba5_dan, rdoba6=rdoba6_dan, ".
"zkoep1=zkoep1_dan, zkoep2=zkoep2_dan, zkoep3=zkoep3_dan, zkoep4=zkoep4_dan, zkoep5=zkoep5_dan, zkoep6=zkoep6_dan, ".
"zkoed1=zkoed1_dan, zkoed2=zkoed2_dan, zkoed3=zkoed3_dan, zkoed4=zkoed4_dan, zkoed5=zkoed5_dan, zkoed6=zkoed6_dan, ".
"zzvys1=zzvys1_dan, zzvys2=zzvys2_dan, zzvys3=zzvys3_dan, zzvys4=zzvys4_dan, zzvys5=zzvys5_dan, zzvys6=zzvys6_dan ".
"";
//echo $sqtoz;
//exit;
$oznac = mysql_query("$sqtoz");

$majsodp="dansodp$kli_uzid";
}

$pocetvypoctov=1;

//daj do odpprc len jednu polozku majetku pre odpisovy plan
if( $drupoh == 4 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_odpprcx2xplan'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = "CREATE TABLE F".$kli_vxcf."_odpprcx2xplan".$kli_uzid." SELECT * FROM F".$kli_vxcf."_odpprc".$kli_uzid." ";
$vysledok = mysql_query("$sqlt");

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_odpprcx2xplan'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$cislo_inv = 1*$_REQUEST['cislo_inv'];
$druh_pln = 1*$_REQUEST['druh_pln'];

if( $druh_pln == 0 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_odpprc$kli_uzid".
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,spo,sku,perc,meso,zss,ros,0,0,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_majmaj".
" WHERE inv = $cislo_inv ".
"";
  }
if( $druh_pln == 1 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_odpprc$kli_uzid".
" SELECT 1,1,drm,inv,naz,zar,rzv,str,zak,cen_dan,ops_dan,zos_dan,spo_dan,sku_dan,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_majmaj".
" WHERE inv = $cislo_inv ".
"";
  }
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET zos=cen, zss=cen, ops=0, ros=0 ";
$dsql = mysql_query("$dsqlt");

$sqlfir = "SELECT YEAR(zar) AS roky, MONTH(zar) AS mesy, sku FROM F$kli_vxcf"."_odpprc$kli_uzid WHERE inv = $cislo_inv ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$kli_vrok = $fir_riadok->roky;
$kli_vmes = $fir_riadok->mesy;
$sku = 1*$fir_riadok->sku;

$majsodp="majsodp";
$pocetvypoctov=48;
if( $sku == 2 ) { $pocetvypoctov=72; }
if( $sku == 3 ) { $pocetvypoctov=144; }
if( $sku >  3 ) { $pocetvypoctov=240; }

}

$ivyp=1;
while( $ivyp <= $pocetvypoctov ) {
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//vypocet mesacneho odpisu

//vynuluj vsetky
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=0, cs3=zos-meso".
" WHERE inv > 0 ";
$oznac = mysql_query("$sqtoz");
//rovnomerne
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba1".
" WHERE ( spo = 1 AND sku = 1 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba2".
" WHERE ( spo = 1 AND sku = 2 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba3".
" WHERE ( spo = 1 AND sku = 3 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba4".
" WHERE ( spo = 1 AND sku = 4 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba5".
" WHERE ( spo = 1 AND sku = 5 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba6".
" WHERE ( spo = 1 AND sku = 6 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba7".
" WHERE ( spo = 1 AND sku = 7 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba8".
" WHERE ( spo = 1 AND sku = 8 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba9".
" WHERE ( spo = 1 AND sku = 9 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp".
" SET cs1=cen/rdoba10".
" WHERE ( spo = 1 AND sku = 10 AND F$kli_vxcf"."_$majsodp.cpl = 1 )";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=0 WHERE spo=1 AND sku=0 ";
$oznac = mysql_query("$sqtoz");

//zrychlene
//ci je druhy rok drok=1 , ci je zvysena cena zvys=1 , pocet odpisovanych rokov orok , pocet rokov zvysenej ceny zrok
//ta podmienka AND rzv <= $kli_vrok je tam preto aby zvysovanie v roku zaradenia nepovazoval za zvysenie
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET drok=$kli_vrok-YEAR(zar), orok=$kli_vrok-YEAR(zar), zrok=$kli_vrok-rzv, cs1=0, cs2=0, cs3=0 WHERE spo = 2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET drok=1 WHERE spo = 2 AND drok > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET zvys=1 WHERE spo = 2 AND rzv > 1980 AND rzv <= $kli_vrok ";
$oznac = mysql_query("$sqtoz");

if( $kli_vrok >= 2012 )
{
//uprava az v skripte 2012
//ak zrychlene a zvysena cena(techn.zhodnotenie) potom orok=$kli_vrok-rzv nie $kli_vrok-YEAR(zar)
//ta podmienka AND rzv = YEAR(zar) je tam preto aby zvysovanie v roku zaradenia nepovazoval za zvysenie
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET zvys=0 WHERE rzv = YEAR(zar) ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET orok=$kli_vrok-rzv, drok=$kli_vrok-rzv WHERE spo = 2 AND zvys = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET drok=1 WHERE spo = 2 AND zvys = 1 AND drok > 0 ";
$oznac = mysql_query("$sqtoz");

}
//tu si mozem pozriet kontrolny vypocet odpisov v tejto tabulke Fxyz_odpprcx2x 


//nastav koeficient
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep1 WHERE ( spo=2 AND sku=1 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed1 WHERE ( spo=2 AND sku=1 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep2 WHERE ( spo=2 AND sku=2 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed2 WHERE ( spo=2 AND sku=2 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep3 WHERE ( spo=2 AND sku=3 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed3 WHERE ( spo=2 AND sku=3 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep4 WHERE ( spo=2 AND sku=4 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed4 WHERE ( spo=2 AND sku=4 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep5 WHERE ( spo=2 AND sku=5 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed5 WHERE ( spo=2 AND sku=5 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep6 WHERE ( spo=2 AND sku=6 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed6 WHERE ( spo=2 AND sku=6 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep7 WHERE ( spo=2 AND sku=7 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed7 WHERE ( spo=2 AND sku=7 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep8 WHERE ( spo=2 AND sku=8 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed8 WHERE ( spo=2 AND sku=8 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep9 WHERE ( spo=2 AND sku=9 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed9 WHERE ( spo=2 AND sku=9 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoep10 WHERE ( spo=2 AND sku=10 AND drok=0 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zkoed10 WHERE ( spo=2 AND sku=10 AND drok=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys1 WHERE ( spo=2 AND sku=1 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys2 WHERE ( spo=2 AND sku=2 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys3 WHERE ( spo=2 AND sku=3 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys4 WHERE ( spo=2 AND sku=4 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys5 WHERE ( spo=2 AND sku=5 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys6 WHERE ( spo=2 AND sku=6 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys7 WHERE ( spo=2 AND sku=7 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys8 WHERE ( spo=2 AND sku=8 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys9 WHERE ( spo=2 AND sku=9 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid,F$kli_vxcf"."_$majsodp SET koe=zzvys10 WHERE ( spo=2 AND sku=10 AND zvys=1 AND F$kli_vxcf"."_$majsodp.cpl=1 )";
$oznac = mysql_query("$sqtoz");


//znizenie koeficientu o pocet rokov uprav orok a zrok ak by bol koef s odpocitanim orok a zrok mensi alebo rovny nule
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=koe-orok, cs2=koe-zrok WHERE spo=2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET orok=koe-1 WHERE spo=2 AND cs1 <= 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET zrok=koe-1 WHERE spo=2 AND cs2 <= 0 ";
$oznac = mysql_query("$sqtoz");

//vypocet odpisu zrych
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=cen/koe WHERE spo=2 AND drok=0 AND zvys=0 AND koe > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=(2*zss)/(koe-orok) WHERE spo=2 AND drok=1 AND zvys=0 AND koe > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=(2*zss)/koe WHERE spo=2 AND zvys=1 AND zrok=0 AND koe > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=(2*zss)/(koe-zrok) WHERE spo=2 AND zvys=1 AND zrok>0 AND koe > 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=0 WHERE spo=2 AND sku=0 ";
$oznac = mysql_query("$sqtoz");

//vplyv neuplatnenej casti odpisov v roku zaradenia od 2012 pri zrychlenom odpise
if( $kli_vrok >= 2013 )
{
//andrejko 
$dat11tento=$kli_vrok."-01-01";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_odpprc$kli_uzid WHERE spo=2 AND zvys=0 AND zar >= '2012-01-01' AND zar < '$dat11tento' ";

$sql = mysql_query("$sqlttt");
$cpol = mysql_num_rows($sql);
$i=0;

if( $cpol >= 1 )
               {

while ($i < $cpol )
{
  if (@$zaznam=mysql_data_seek($sql,$i))
    {
  $riadok=mysql_fetch_object($sql);

$pomerneuplatneny=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_majtextmaj WHERE invt = $riadok->inv ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $pomerneuplatneny=1*$riaddok->neuu-1*$riaddok->celu;
  if( $drupoh == 3 ) { $pomerneuplatneny=1*$riaddok->neud-1*$riaddok->celd; }
  }

$akykoe=1;
$zarrok=0;
$sqltt = "SELECT koe, YEAR(zar) AS zarrok FROM F$kli_vxcf"."_odpprc$kli_uzid WHERE inv = $riadok->inv ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akykoe=1*$riaddok->koe-1;
  $zarrok=1*$riaddok->zarrok;
  }
$kolkorokov=$kli_vrok-$zarrok+1;

//zaistenie aby to nerobil po zivotnosti
if( $akykoe >= $kolkorokov ) 
 {
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=(2*(zss-$pomerneuplatneny))/(koe-orok) WHERE spo=2 AND zvys=0 AND koe > orok AND inv = $riadok->inv ";
$oznac = mysql_query("$sqtoz");
 }

$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=0 WHERE spo=2 AND sku=0 AND inv = $riadok->inv ";
$oznac = mysql_query("$sqtoz");

//echo " akykoezivotnost ".$akykoe." rokzar ".$zarrok." kolkyrokodpis ".$kolkorokov;

//$sqtoz = "DROP TABLE F$kli_vxcf"."_majmaj_3_2013 ";
//$oznac = mysql_query("$sqtoz");
//exit;


    }
$i=$i+1;
}

//if( $cpol >= 1 )
               }
}
//koniec vplyv neuplatnenej casti odpisov v roku zaradenia od 2012 pri zrychlenom odpise


//ak je percento
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET cs1=cen*perc/100".
" WHERE ( inv > 0 AND perc > 0 )";
$oznac = mysql_query("$sqtoz");

//zaokruhli rocny
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs2=CEIL(cs1) WHERE inv > 0 ";
$oznac = mysql_query("$sqtoz");

//exit;

//od roku 2012 pri zaradeni v roku len alikvotnu cast odpisu podla mesiacov
if( $kli_vrok >= 2012 )
{
//uloz cely odpis pri zaradeni do majtextmaj
$sql = "SELECT * FROM F".$kli_vxcf."_majtextmaj";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sqlt = <<<paskovacka
(
   invt        int not null,
   itxt        TEXT not null
);
paskovacka;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_majtextmaj'.$sqlt;
$vysledok = mysql_query($sql);
              }

$sql = "SELECT zdro FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD nas1 DECIMAL(4,0) DEFAULT 0 AFTER itxt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zdro DECIMAL(1,0) DEFAULT 0 AFTER nas1";
$vysledek = mysql_query("$sql");
               }

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj MODIFY invt int PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

$sql = "SELECT zake FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD cene DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD peru DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD pere DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odmu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odme VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odpu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD odpe VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv1 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv2 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrmu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrme VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrpu VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zrpe VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD stre VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zake VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

               }

$sql = "SELECT kcpa FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv3 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD suv4 VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD stru VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD zaku VARCHAR(10) not null AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD kcpa VARCHAR(15) not null AFTER zdro";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT cens FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD cens DECIMAL(10,2) DEFAULT 0 AFTER zdro";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_majtextmaj,F$kli_vxcf"."_majmaj SET cens=cen*peru/100 WHERE F$kli_vxcf"."_majtextmaj.invt=F$kli_vxcf"."_majmaj.inv ";
$vysledek = mysql_query("$sql");
               }

$sql = "SELECT celu FROM F".$kli_vxcf."_majtextmaj ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD neud DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD neuu DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD celd DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_majtextmaj ADD celu DECIMAL(10,2) DEFAULT 0 AFTER cene";
$vysledek = mysql_query("$sql");
               }

if( $drupoh == 1 )
{
//invt	itxt  nas1  zdro  cens	kcpa  zaku  stru  suv4  suv3  zake  stre  zrpe  zrpu  zrme  zrmu  suv2  suv1  odpe  odpu  odme  odmu  pere  peru  cene  celu  celd  neuu  neud
$sqlt = "INSERT INTO F".$kli_vxcf."_majtextmaj SELECT ".
"inv,'',0,0,0,'','','','','','','','','','','','','','','','','',0,0,0,0,0,0,0 ".
" FROM F".$kli_vxcf."_odpprc".$kli_uzid." WHERE YEAR(zar) = $kli_vrok ";
$vysledok = mysql_query("$sqlt");

//uloz narok na cely uctovny
$sqlt = "UPDATE F".$kli_vxcf."_majtextmaj,F".$kli_vxcf."_odpprc$kli_uzid SET ".
" neuu=cs2 ".
" WHERE F".$kli_vxcf."_majtextmaj.invt=F".$kli_vxcf."_odpprc$kli_uzid.inv AND YEAR(zar) = $kli_vrok ";
$vysledok = mysql_query("$sqlt");
}
if( $drupoh == 3 )
{
//uloz narok na cely danovy
$sqlt = "UPDATE F".$kli_vxcf."_majtextmaj,F".$kli_vxcf."_odpprc$kli_uzid SET ".
" neud=cs2 ".
" WHERE F".$kli_vxcf."_majtextmaj.invt=F".$kli_vxcf."_odpprc$kli_uzid.inv AND YEAR(zar) = $kli_vrok ";
$vysledok = mysql_query("$sqlt");
}

//vypocitaj alikvotnu

$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=13-MONTH(zar) WHERE YEAR(zar) = $kli_vrok ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs2=(cs2/12)*cs1 WHERE cs1 >= 1 AND cs1 < 13 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs2=CEIL(cs2) WHERE cs1 >= 1 AND cs1 < 13 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs1=0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET cs2=231 WHERE inv = 386 ";
//$oznac = mysql_query("$sqtoz");
}
//koniec od roku 2012 pri zaradeni v roku len alikvotnu cast odpisu podla mesiacov

//ak rocny je vacsi ako zss
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET cs2=zss".
" WHERE cs2 > zss ";
$oznac = mysql_query("$sqtoz");

//danove drupoh=3, uctovne drupoh=1, $fir_majx01=1 len tolko mesacnych odpisov kolko mesiacov
//vypocitaj podiel na mesiac tak aby rozpocital odpis do konca

if( $drupoh == 3 ) { 
$kli_rozdel=12; 
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET mes=(cs2-ros)/(13-$kli_rozdel) WHERE inv > 0 ";
$oznac = mysql_query("$sqtoz");
}

if( $fir_majx01 != 1 AND $drupoh != 3 ) {
$kli_rozdel=$kli_vmes;
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET mes=(cs2-ros)/(13-$kli_rozdel) WHERE inv > 0 ";
$oznac = mysql_query("$sqtoz");
}

//exit;

if( $fir_majx01 == 1 AND $drupoh != 3 ) {
$kli_rozdel=1; 
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET mes=cs2/(13-$kli_rozdel) WHERE inv > 0 ";
$oznac = mysql_query("$sqtoz");

   //pre zaradene v roku aktualnom a zvysene v roku aktualnom vzdy rozdel na pocet zostavajucich mesiacov
   if( $kli_vrok >= 2012 ) {
$kli_rozdelx=$kli_vmes;
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET mes=(cs2-ros)/(13-$kli_rozdelx) WHERE inv > 0 AND YEAR(zar) = $kli_vrok ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid SET mes=(cs2-ros)/(13-$kli_rozdelx) WHERE inv > 0 AND rzv = $kli_vrok AND zvys = 1";
$oznac = mysql_query("$sqtoz");

                           }
}


//ak je dany odpis
if( $drupoh == 1 OR $drupoh == 4 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET mes=meso, cs2=12*meso".
" WHERE ( inv > 0 AND meso > 0 AND cs3 >= 0 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET mes=zos, cs2=ros+mes".
" WHERE ( inv > 0 AND meso > 0 AND cs3 < 0 )";
$oznac = mysql_query("$sqtoz");
}
if( $drupoh == 3 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET mes=meso, cs2=meso".
" WHERE ( inv > 0 AND meso > 0 AND cs3 >= 0 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET mes=zos, cs2=ros+mes".
" WHERE ( inv > 0 AND meso > 0 AND cs3 < 0 )";
$oznac = mysql_query("$sqtoz");
}

//prepocitaj opravky a zostatok
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET ros=ros+mes, rop=cs2, ops=ops+mes, zos=zos-mes".
" WHERE inv > 0 ";
$oznac = mysql_query("$sqtoz");

//ochrana ak zostane po vypocte 0.05...
if( $drupoh == 4 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET ros=ros+zos, ops=ops+zos, mes=mes+zos, zos=0 ".
" WHERE zos < 1 AND zos > 0 ";
$oznac = mysql_query("$sqtoz");
}

//ak po pripocitani mes je ros > zss teda zos < 0 uprav mes
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET mes=mes+zos, ros=ros+zos, ops=ops+zos, zos=0 ".
" WHERE inv > 0 AND mes > 0 AND zos < 0 ";
$oznac = mysql_query("$sqtoz");

//ak po pripocitani mes je zos < 1 uprav mes
$sqtoz = "UPDATE F$kli_vxcf"."_odpprc$kli_uzid".
" SET mes=mes+zos, ros=ros+zos, ops=ops+zos, zos=0 ".
" WHERE inv > 0 AND zos < 1 AND zos > 0 ";
$oznac = mysql_query("$sqtoz");

if( $drupoh == 1 AND $kli_vrok >= 2012 )
{
//uloz narok na cely uctovny
$sqlt = "UPDATE F".$kli_vxcf."_majtextmaj,F".$kli_vxcf."_odpprc$kli_uzid SET ".
" celu=ros ".
" WHERE F".$kli_vxcf."_majtextmaj.invt=F".$kli_vxcf."_odpprc$kli_uzid.inv AND YEAR(zar) = $kli_vrok ";
$vysledok = mysql_query("$sqlt");
}
if( $drupoh == 3 AND $kli_vrok >= 2012 )
{
//uloz narok na cely danovy
$sqlt = "UPDATE F".$kli_vxcf."_majtextmaj,F".$kli_vxcf."_odpprc$kli_uzid SET ".
" celd=ros ".
" WHERE F".$kli_vxcf."_majtextmaj.invt=F".$kli_vxcf."_odpprc$kli_uzid.inv AND YEAR(zar) = $kli_vrok ";
$vysledok = mysql_query("$sqlt");
}

if( $drupoh == 4 )
{
$sqlt = "UPDATE F".$kli_vxcf."_odpprc".$kli_uzid." SET pol=$ivyp, orok=$kli_vmes, zrok=$kli_vrok ";
$vysledok = mysql_query("$sqlt");

$sqlt = "INSERT INTO F".$kli_vxcf."_odpprcx2xplan".$kli_uzid." SELECT * FROM F".$kli_vxcf."_odpprc".$kli_uzid." ";
$vysledok = mysql_query("$sqlt");

$kli_vmes=$kli_vmes+1;
if( $kli_vmes == 13 ) 
 { 
$kli_vmes=1; $kli_vrok=$kli_vrok+1; 

$sqlt = "UPDATE F".$kli_vxcf."_odpprc".$kli_uzid." SET zss=zos, ros=0 ";
$vysledok = mysql_query("$sqlt");
 }

if( $ivyp == $pocetvypoctov ) 
 { 
$sqlfir = "SELECT zos FROM F$kli_vxcf"."_odpprc$kli_uzid WHERE inv = $cislo_inv ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$zos = 1*$fir_riadok->zos;
if( $zos < 1 ) { $zos=0; }
if( $zos > 0 ) { $ivyp=0; }
 }

//echo "zostatok".$zos." ".$ivyp."<br />";
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//vypocet mesacneho odpisu koniec
$ivyp=$ivyp+1;
//koniec while( $ivyp <= $pocetvypoctov ) {
                                }
//exit;
if( $drupoh == 4 )
{
$sqlt = "DELETE FROM F".$kli_vxcf."_odpprcx2xplan".$kli_uzid." WHERE mes=0 AND zos = 0 ";
$vysledok = mysql_query("$sqlt");

}

//tu si mozem pozriet kontrolny vypocet odpisov
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_odpprcx2x'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = "CREATE TABLE F".$kli_vxcf."_odpprcx2x".$kli_uzid." SELECT * FROM F".$kli_vxcf."_odpprc".$kli_uzid." ";
$vysledok = mysql_query("$sqlt");


if( $copern == 4 ) 
{ 
?>
<script type="text/javascript">
  var okno = window.open("odpisovy_plan.php?copern=1&page=1&cislo_inv=<?php echo $cislo_inv; ?>&druh_pln=<?php echo $druh_pln; ?>","_self");
</script>
<?php
exit; 
}


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_dansodp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//ulozenie novych uctovnych  mesacnych odpisov
if( $copern == 1 )
          {
//zapis do majmaj

          $vyslettt = "SELECT * FROM F$kli_vxcf"."_odpprc$kli_uzid WHERE inv > 0 ORDER BY inv ";
          $vysledok = mysql_query("$vyslettt");
          while ($riadok = mysql_fetch_object($vysledok))
          {
          //zaciatok cyklu

$sqtoz = "UPDATE F$kli_vxcf"."_majmaj ".
" SET mes=$riadok->mes, ros=$riadok->ros, cen=$riadok->cen, ops=$riadok->ops, ".
" zos=$riadok->zos, rop=$riadok->rop, ume=$kli_vume, poh=1, dph=1 ".
" WHERE inv= $riadok->inv ";
$oznac = mysql_query("$sqtoz");


          }
          //koniec cyklu


$sqtoz = "UPDATE F$kli_vxcf"."_majmaj,F$kli_vxcf"."_odpprc$kli_uzid".
" SET F$kli_vxcf"."_majmaj.mes=F$kli_vxcf"."_odpprc$kli_uzid.mes,F$kli_vxcf"."_majmaj.ros=F$kli_vxcf"."_odpprc$kli_uzid.ros,".
" F$kli_vxcf"."_majmaj.cen=F$kli_vxcf"."_odpprc$kli_uzid.cen,F$kli_vxcf"."_majmaj.ops=F$kli_vxcf"."_odpprc$kli_uzid.ops,".
" F$kli_vxcf"."_majmaj.zos=F$kli_vxcf"."_odpprc$kli_uzid.zos,F$kli_vxcf"."_majmaj.rop=F$kli_vxcf"."_odpprc$kli_uzid.rop,".
" F$kli_vxcf"."_majmaj.ume=$kli_vume,F$kli_vxcf"."_majmaj.poh=1,F$kli_vxcf"."_majmaj.dph=1".
" WHERE F$kli_vxcf"."_majmaj.inv=F$kli_vxcf"."_odpprc$kli_uzid.inv ";
//$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majmajmes".
" SELECT 0,$kli_vume,1,999,0,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,0,0,SUM(mno),dob,dox,zar,rzv,str,zak,oc,kanc,spo,sku,perc,meso,".
"SUM(cen),SUM(ops),SUM(zos),SUM(zss),SUM(mes),SUM(ros),SUM(rop),0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_majmaj".
" GROUP BY druh";
$dsql = mysql_query("$dsqlt");

//uloz vypocitane odpisy do majodpisy
$dsqlt = "INSERT INTO F$kli_vxcf"."_majodpisy".
" SELECT *".
" FROM F$kli_vxcf"."_majmaj".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");
          }
//ulozenie novych mesacnych odpisov koniec


//ulozenie novych danovych odpisov do polozky hd5
if( $copern == 3 )
          {
//zapis do majmaj
$sqtoz = "UPDATE F$kli_vxcf"."_majmaj,F$kli_vxcf"."_odpprc$kli_uzid".
" SET F$kli_vxcf"."_majmaj.hd5=F$kli_vxcf"."_odpprc$kli_uzid.mes".
" WHERE F$kli_vxcf"."_majmaj.inv=F$kli_vxcf"."_odpprc$kli_uzid.inv ";
$oznac = mysql_query("$sqtoz");

          }
//ulozenie novych danovych odpisov koniec

//group za drm
$dsqlt = "INSERT INTO F$kli_vxcf"."_odpprx$kli_uzid ".
" SELECT SUM(pol),2,drm,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso,zss,SUM(ros),SUM(rop),SUM(mes),0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_odpprc$kli_uzid".
" GROUP BY drm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//group za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_odpprx$kli_uzid ".
" SELECT SUM(pol),2,999,inv,naz,zar,rzv,str,zak,SUM(cen),SUM(ops),SUM(zos),spo,sku,perc,meso,zss,SUM(ros),SUM(rop),SUM(mes),0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_odpprc$kli_uzid".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_odpprc$kli_uzid".
" SELECT pol,druh,drm,inv,naz,zar,rzv,str,zak,cen,ops,zos,spo,sku,perc,meso,zss,ros,rop,mes,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_odpprx$kli_uzid".
"";
$dsql = mysql_query("$dsqlt");

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if( $drupoh == 1 )
{
 $outfilexmesdel="../dokumenty/FIR".$kli_vxcf."/mesodp.".$kli_vmes."_*.*";
 foreach (glob("$outfilexmesdel") as $filename) {
    unlink($filename);
 }

$outfilexmes="../dokumenty/FIR".$kli_vxcf."/mesodp.".$kli_vmes."_".$hhmmss.".pdf";
if (File_Exists ("$outfilexmes")) { $soubor = unlink("$outfilexmes"); }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/mesodp.$kli_vmes.pdf")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/mesodp.$kli_vmes.pdf"); }

}



if( $drupoh == 3 )
{
 $outfilexdandel="../dokumenty/FIR".$kli_vxcf."/danodp*.*";
 foreach (glob("$outfilexdandel") as $filename) {
    unlink($filename);
 }

$outfilexdan="../dokumenty/FIR".$kli_vxcf."/danodp_".$hhmmss.".pdf";
if (File_Exists ("$outfilexdan")) { $soubor = unlink("$outfilexdan"); }
}

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$pdf->AddPage();
$pdf->SetFont('arial','',7);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 


$strana=1;
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg'))
{
$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg',15,5,10,10);
}
if( $drupoh == 1 )
{
$pdf->SetY(5);$pdf->Cell(10,10," ","1",0,"R");$pdf->Cell(80,5,"Zostava odpisov ⁄»TOVN› stav $kli_vume","LTB",0,"L");
$pdf->Cell(160,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}
if( $drupoh == 3 )
{
$pdf->SetY(5);$pdf->Cell(10,10," ","1",0,"R");$pdf->Cell(80,5,"Zostava odpisov DA“OV› stav $kli_vume","LTB",0,"L");
$pdf->Cell(160,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}


$pdf->SetFont('arial','',6);
$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(7,5,"Inv.Ë.","1",0,"R");$pdf->Cell(45,5,"Popis","1",0,"L");
$pdf->Cell(8,5,"STR","1",0,"L");$pdf->Cell(12,5,"Z¡K","1",0,"L");$pdf->Cell(9,5,"DRM","1",0,"L");
$pdf->Cell(15,5,"SKU-SPO-%","1",0,"L");
$pdf->Cell(20,5,"Cena obstarania","1",0,"R");$pdf->Cell(20,5,"Opr·vky","1",0,"R");$pdf->Cell(20,5,"Zostatkov· cena","1",0,"R");
$pdf->Cell(20,5,"MesaËn˝ odpis","1",0,"R");$pdf->Cell(25,5,"SkutoËn˝ roËn˝ odpis","1",0,"R");$pdf->Cell(25,5,"Pl·novan˝ roËn˝ odpis","1",0,"R");
$pdf->Cell(14,5,"ZaradenÈ","1",1,"L");
$pdf->SetFont('arial','',7);



$sqltt = "SELECT * FROM F$kli_vxcf"."_odpprc$kli_uzid"." WHERE inv >= 0 ORDER BY drm,druh,inv";
//echo $sqltt;
$sql = mysql_query("$sqltt");

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
$sk_zar = SkDatum($rtov->zar);
$zostatok=$rtov->zos;
if( $zostatok == 0 ) $zostatok="";


if ( $j != 42 AND $rtov->druh == 1 )
   {
$pdf->SetFont('arial','',7);
$pdf->Cell(17,4,"$rtov->inv","L",0,"R");$pdf->Cell(45,4,"$rtov->naz","0",0,"L");
$pdf->Cell(8,4,"$rtov->str","0",0,"L");$pdf->Cell(12,4,"$rtov->zak","0",0,"L");$pdf->Cell(9,4,"$rtov->drm","0",0,"L");
if( $rtov->perc == 0 AND $rtov->meso == 0 )
{
$pdf->Cell(15,4,"$rtov->sku-$rtov->spo ","0",0,"L");
}
if( $rtov->perc != 0 AND $rtov->meso == 0 )
{
$pdf->Cell(15,4,"$rtov->perc% ","0",0,"L");
}
if( $rtov->perc == 0 AND $rtov->meso != 0 )
{
$pdf->Cell(15,4,"$rtov->meso $mena1","0",0,"L");
}
if( $rtov->perc != 0 AND $rtov->meso != 0 )
{
$pdf->Cell(15,4,"$rtov->sku-$rtov->spo/$rtov->meso ","0",0,"L");
}
$pdf->Cell(20,4,"$rtov->cen","0",0,"R");$pdf->Cell(20,4,"$rtov->ops","0",0,"R");$pdf->Cell(20,4,"$zostatok","0",0,"R");
$pdf->Cell(20,4,"$rtov->mes","0",0,"R");$pdf->Cell(25,4,"$rtov->ros","0",0,"R");$pdf->Cell(25,4,"$rtov->rop","0",0,"R");
$pdf->Cell(14,4,"$sk_zar","R",1,"L");
   }

//if ( $j == 42 AND $rtov->druh == 1 )
//koniec strany
if ( $j == 42 )
   {
if ( $rtov->druh == 1 )
     {
$pdf->SetFont('arial','',7);
$pdf->Cell(17,4,"$rtov->inv","LB",0,"R");$pdf->Cell(45,4,"$rtov->naz","B",0,"L");
$pdf->Cell(8,4,"$rtov->str","B",0,"L");$pdf->Cell(12,4,"$rtov->zak","B",0,"L");$pdf->Cell(9,4,"$rtov->drm","B",0,"L");
if( $rtov->perc == 0 AND $rtov->meso == 0 )
{
$pdf->Cell(15,4,"$rtov->sku-$rtov->spo","B",0,"L");
}
if( $rtov->perc != 0 AND $rtov->meso == 0 )
{
$pdf->Cell(15,4,"$rtov->perc% ","B",0,"L");
}
if( $rtov->perc == 0 AND $rtov->meso != 0 )
{
$pdf->Cell(15,4,"$rtov->meso $mena1","B",0,"L");
}
if( $rtov->perc != 0 AND $rtov->meso != 0 )
{
$pdf->Cell(15,4,"$rtov->sku-$rtov->spo/$rtov->meso ","B",0,"L");
}
$pdf->Cell(20,4,"$rtov->cen","B",0,"R");$pdf->Cell(20,4,"$rtov->ops","B",0,"R");$pdf->Cell(20,4,"$zostatok","B",0,"R");
$pdf->Cell(20,4,"$rtov->mes","B",0,"R");$pdf->Cell(25,4,"$rtov->ros","B",0,"R");$pdf->Cell(25,4,"$rtov->rop","B",0,"R");
$pdf->Cell(14,4,"$sk_zar","RB",1,"L");
      }

$pdf->Cell(250,2," ","T",1,"L");
$j=0;

$pdf->AddPage();
$pdf->SetFont('arial','',7);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$strana=$strana+1;
if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg'))
{
$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg',15,5,10,10);
}

if( $drupoh == 1 )
{
$pdf->SetY(5);$pdf->Cell(10,10," ","1",0,"R");$pdf->Cell(80,5,"Zostava odpisov ⁄»TOVN› stav $kli_vume","LTB",0,"L");
$pdf->Cell(160,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}
if( $drupoh == 3 )
{
$pdf->SetY(5);$pdf->Cell(10,10," ","1",0,"R");$pdf->Cell(80,5,"Zostava odpisov DA“OV› stav $kli_vume","LTB",0,"L");
$pdf->Cell(160,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}

$pdf->SetFont('arial','',6);
$pdf->Cell(10,5," ","0",0,"R");
$pdf->Cell(7,5,"Inv.Ë.","1",0,"R");$pdf->Cell(45,5,"Popis","1",0,"L");
$pdf->Cell(8,5,"STR","1",0,"L");$pdf->Cell(12,5,"Z¡K","1",0,"L");$pdf->Cell(9,5,"DRM","1",0,"L");
$pdf->Cell(15,5,"SKU-SPO-%","1",0,"L");
$pdf->Cell(20,5,"Cena obstarania","1",0,"R");$pdf->Cell(20,5,"Opr·vky","1",0,"R");$pdf->Cell(20,5,"Zostatkov· cena","1",0,"R");
$pdf->Cell(20,5,"MesaËn˝ odpis","1",0,"R");$pdf->Cell(25,5,"SkutoËn˝ roËn˝ odpis","1",0,"R");$pdf->Cell(25,5,"Pl·novan˝ roËn˝ odpis","1",0,"R");
$pdf->Cell(14,5,"ZaradenÈ","1",1,"L");
$pdf->SetFont('arial','',7);
   }
//tu konci blok koniec strany

if ( $rtov->druh != 1 AND $rtov->drm != 999 )
{
$pdf->SetFont('arial','',7);
$pdf->Cell(70,4,"DRM=$rtov->drm celkom $rtov->pol poloûiek","LTB",0,"R");
$pdf->Cell(8,4," ","TB",0,"L");$pdf->Cell(12,4," ","TB",0,"L");$pdf->Cell(16,4," ","TB",0,"L");
$pdf->Cell(20,4,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,4,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,4,"$zostatok","LTB",0,"R");
$pdf->Cell(20,4,"$rtov->mes","LRTB",0,"R");$pdf->Cell(25,4,"$rtov->ros","LRTB",0,"R");$pdf->Cell(25,4,"$rtov->rop","LRTB",0,"R");
$pdf->Cell(14,4," ","RTB",1,"L");
}

if ( $rtov->druh != 1 AND $rtov->drm == 999 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(70,5,"CELKOM za vöetky DRM $rtov->pol poloûiek","LTB",0,"R");
$pdf->Cell(8,5," ","TB",0,"L");$pdf->Cell(12,5," ","TB",0,"L");$pdf->Cell(16,5," ","TB",0,"L");
$pdf->Cell(20,5,"$rtov->cen","LRTB",0,"R");$pdf->Cell(20,5,"$rtov->ops","LRTB",0,"R");$pdf->Cell(20,5,"$zostatok","LTB",0,"R");
$pdf->Cell(20,5,"$rtov->mes","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ros","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->rop","LRTB",0,"R");
$pdf->Cell(14,5," ","RTB",1,"L");
}


}
$i = $i + 1;
$j = $j + 1;
  }

//zostava za druhy DRM

$pdf->AddPage();
$pdf->SetFont('arial','',7);
$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 
$strana=$strana+1;

if (File_Exists ('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg'))
{
$pdf->Image('../dokumenty/FIR'.$kli_vxcf.'/logo.jpg',15,5,10,10);
}
if( $drupoh == 1 )
{
$pdf->SetY(5);$pdf->Cell(10,10," ","1",0,"R");$pdf->Cell(80,5,"Zostava odpisov ⁄»TOVN› stav sumy za DRM $kli_vume","LTB",0,"L");
$pdf->Cell(100,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}
if( $drupoh == 3 )
{
$pdf->SetY(5);$pdf->Cell(10,10," ","1",0,"R");$pdf->Cell(80,5,"Zostava odpisov DA“OV› stav sumy za DRM $kli_vume","LTB",0,"L");
$pdf->Cell(100,5,"FIR$kli_vxcf $kli_nxcf strana $strana","RTB",1,"R");
}

$pdf->SetFont('arial','',6);
$pdf->Cell(10,5," ","0",0,"R");

$pdf->Cell(10,5,"DRM","1",0,"C");$pdf->Cell(20,5,"Poloûiek","1",0,"R");
$pdf->Cell(25,5,"Cena obstarania","1",0,"R");$pdf->Cell(25,5,"Opr·vky","1",0,"R");$pdf->Cell(25,5,"Zostatkov· cena","1",0,"R");
$pdf->Cell(25,5,"MesaËn˝ odpis","1",0,"R");$pdf->Cell(25,5,"SkutoËn˝ roËn˝ odpis","1",0,"R");$pdf->Cell(25,5,"Pl·novan˝ roËn˝ odpis","1",1,"R");
$pdf->SetFont('arial','',7);

$sqltt = "SELECT * FROM F$kli_vxcf"."_odpprc$kli_uzid"." WHERE druh != 1 ORDER BY drm,druh,inv";
//echo $sqltt;
$sql = mysql_query("$sqltt");

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
$sk_zar = SkDatum($rtov->zar);
$zostatok=$rtov->zos;
if( $zostatok == 0 ) $zostatok="";


if ( $rtov->druh != 1 AND $rtov->drm != 999 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(20,5,"$rtov->drm","LRTB",0,"C");
$pdf->Cell(20,5,"$rtov->pol","TB",0,"R");
$pdf->Cell(25,5,"$rtov->cen","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ops","LRTB",0,"R");$pdf->Cell(25,5,"$zostatok","LTB",0,"R");
$pdf->Cell(25,5,"$rtov->mes","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ros","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->rop","LRTB",1,"R");
}

if ( $rtov->druh != 1 AND $rtov->drm == 999 )
{
$pdf->SetFont('arial','',10);
$pdf->Cell(20,5,"CELKOM","LRTB",0,"C");
$pdf->Cell(20,5,"$rtov->pol","TB",0,"R");
$pdf->Cell(25,5,"$rtov->cen","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ops","LRTB",0,"R");$pdf->Cell(25,5,"$zostatok","LTB",0,"R");
$pdf->Cell(25,5,"$rtov->mes","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->ros","LRTB",0,"R");$pdf->Cell(25,5,"$rtov->rop","LRTB",1,"R");
}


}
$i = $i + 1;
$j = $j + 1;
  }

//zostava pohybov
if( $copern == 1 )
          {

$pdf->Cell(100,5," ","0",1,"R");


if( $drupoh == 1 )
{
$pdf->Cell(120,5,"Zostava pohybov majetku $kli_vume","LTB",0,"L");
$pdf->Cell(125,5," ","RTB",1,"R");
}

$pdf->SetFont('arial','',6);

$pdf->Cell(20,5,"POH","1",0,"C");$pdf->Cell(20,5,"D·tum","1",0,"R");$pdf->Cell(80,5,"Poloûka","1",0,"L");$pdf->Cell(25,5,"Mnoûstvo","1",0,"R");
$pdf->Cell(25,5,"Cena obstarania","1",0,"R");$pdf->Cell(25,5,"Opr·vky","1",0,"R");$pdf->Cell(25,5,"Zostatkov· cena","1",0,"R");
$pdf->Cell(25,5,"RoËn˝ odpis","1",1,"R");
$pdf->SetFont('arial','',7);

$sqltt = "SELECT * FROM F$kli_vxcf"."_majpoh"." WHERE ume = $kli_vume ORDER BY datm";
//echo $sqltt;
$sql = mysql_query("$sqltt");

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$j=0;           
$i=0;
$ccen=0;
$cops=0;
$czos=0;
$cros=0;
$cmno=0;

  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);
$sk_dap = SkDatum($rtov->dap);

$pdf->SetFont('arial','',8);

if ($rtov->poh == 2)
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph zaradenie","LRTB",0,"C");
$cen=($rtov->cen);
$ops=($rtov->ops);
$zos=($rtov->zos);
$ros=($rtov->ros);
$mno=($rtov->mno);
$sk_dap = SkDatum($rtov->zar);
}
if ($rtov->poh == 3)
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph vyradenie","LRTB",0,"C");
$cen=-($rtov->cen);
$ops=-($rtov->ops);
$zos=-($rtov->zos);
$ros=-($rtov->ros);
$mno=-($rtov->mno);
//$sk_dap = SkDatum($rtov->zar);
}
if ($rtov->poh == 4)
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph zv˝ö.ceny","LRTB",0,"C");
$cen=($rtov->hd1);
$ops=0;
$zos=($rtov->hd1);
$ros=0;
$mno=0;
}
if ($rtov->poh == 5)
{
$pdf->Cell(20,5,"$rtov->poh/$rtov->dph rozdelenie","LRTB",0,"C");
$cen=0;
$ops=0;
$zos=0;
$ros=0;
$mno=1;
}

$ccen=$ccen+$cen;
$cops=$cops+$ops;
$czos=$czos+$zos;
$cros=$cros+$ros;
$cmno=$cmno+$mno;

$Cislo=$cen+"";
$sCen=sprintf("%0.2f", $Cislo);
$Cislo=$ops+"";
$sOps=sprintf("%0.2f", $Cislo);
$Cislo=$zos+"";
$sZos=sprintf("%0.2f", $Cislo);
$Cislo=$ros+"";
$sRos=sprintf("%0.2f", $Cislo);
$Cislo=$mno+"";
$sMno=sprintf("%0.2f", $Cislo);

$pdf->Cell(20,5,"$sk_dap","TB",0,"R");$pdf->Cell(80,5,"$rtov->inv $rtov->naz","LTB",0,"L");$pdf->Cell(25,5,"$sMno","LRTB",0,"R");
$pdf->Cell(25,5,"$sCen","LRTB",0,"R");$pdf->Cell(25,5,"$sOps","LRTB",0,"R");$pdf->Cell(25,5,"$sZos","LTB",0,"R");
$pdf->Cell(25,5,"$sRos","LRTB",1,"R");

}
$i = $i + 1;
$j = $j + 1;
  }

$Cislo=$ccen+"";
$scCen=sprintf("%0.2f", $Cislo);
$Cislo=$cops+"";
$scOps=sprintf("%0.2f", $Cislo);
$Cislo=$czos+"";
$scZos=sprintf("%0.2f", $Cislo);
$Cislo=$cros+"";
$scRos=sprintf("%0.2f", $Cislo);
$Cislo=$cmno+"";
$scMno=sprintf("%0.2f", $Cislo);

$pdf->Cell(120,5,"CELKOM","LRTB",0,"L");$pdf->Cell(25,5,"$scMno","LRTB",0,"R");
$pdf->Cell(25,5,"$scCen","LRTB",0,"R");$pdf->Cell(25,5,"$scOps","LRTB",0,"R");$pdf->Cell(25,5,"$scZos","LTB",0,"R");
$pdf->Cell(25,5,"$scRos","LRTB",1,"R");

          }
//zostava pohybov koniec

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_odpprc'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_odpprx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$pdf->SetFont('arial','',6);
$pdf->Cell(180,3,"VytlaËil(a): $kli_uzmeno $kli_uzprie / $kli_uzid ","0",1,"L");

if( $copern == 1 )
          {
$pdf->Output("$outfilexmes");
?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilexmes; ?>","_self");
</script>
<?php
          }
if( $copern == 3 )
          {
$pdf->Output("$outfilexdan");
?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilexdan; ?>","_self");
</script>
<?php
          }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>MesaËn˝ odpis majetku</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >

<?php 



?>

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  MesaËn˝ odpis dlhodobÈho majetku</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php 



?>

<a href="../dokumenty/FIR<?php echo $kli_vxcf; ?>/mesodp.<?php echo $kli_vmes; ?>.pdf">../dokumenty/FIR<?php echo $kli_vxcf; ?>/mesodp.<?php echo $kli_vmes; ?>.pdf</a>


<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
