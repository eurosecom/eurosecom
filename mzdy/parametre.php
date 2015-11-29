<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//vymaz upravove subory pre parametre
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new032009".$sqlt;
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new072009".$sqlt;
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010".$sqlt;
$vysledek = mysql_query("$sql");
if( $kli_vrok == 2011 )
{
//echo "idem";
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012011".$sqlt;
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new072011a".$sqlt;
$vysledek = mysql_query("$sql");

}
if( $kli_vrok == 2012 )
{
//echo "idem";
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012012b";
$vysledek = mysql_query("$sql");

}
if( $kli_vrok == 2013 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012013c";
$vysledek = mysql_query("$sql");
}
if( $kli_vrok == 2014 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012014c";
$vysledek = mysql_query("$sql");
}
if( $kli_vrok == 2015 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012015c";
$vysledek = mysql_query("$sql");
}
if( $kli_vrok == 2016 )
{
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016b";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012016c";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;

$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmzd = include("../mzdy/vtvmzd.php");
endif;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);

// zapis upravene sadzby
if ( $copern == 3 )
    {

$datum = strip_tags($_REQUEST['datum']);
$max_zp = strip_tags($_REQUEST['max_zp']);
$max_np = strip_tags($_REQUEST['max_np']);
$max_sp = strip_tags($_REQUEST['max_sp']);
$max_ip = strip_tags($_REQUEST['max_ip']);
$max_pn = strip_tags($_REQUEST['max_pn']);
$max_up = strip_tags($_REQUEST['max_up']);
$max_gf = strip_tags($_REQUEST['max_gf']);
$max_rf = strip_tags($_REQUEST['max_rf']);
$min_zp = strip_tags($_REQUEST['min_zp']);
$min_np = strip_tags($_REQUEST['min_np']);
$min_sp = strip_tags($_REQUEST['min_sp']);
$min_ip = strip_tags($_REQUEST['min_ip']);
$min_pn = strip_tags($_REQUEST['min_pn']);
$min_up = strip_tags($_REQUEST['min_up']);
$min_gf = strip_tags($_REQUEST['min_gf']);
$min_rf = strip_tags($_REQUEST['min_rf']);
$zam_zp = strip_tags($_REQUEST['zam_zp']);
$zam_zpn = strip_tags($_REQUEST['zam_zpn']);
$zam_np = strip_tags($_REQUEST['zam_np']);
$zam_sp = strip_tags($_REQUEST['zam_sp']);
$zam_ip = strip_tags($_REQUEST['zam_ip']);
$zam_pn = strip_tags($_REQUEST['zam_pn']);
$zam_up = strip_tags($_REQUEST['zam_up']);
$zam_gf = strip_tags($_REQUEST['zam_gf']);
$zam_rf = strip_tags($_REQUEST['zam_rf']);
$fir_zp = strip_tags($_REQUEST['fir_zp']);
$fir_zpn = strip_tags($_REQUEST['fir_zpn']);
$fir_np = strip_tags($_REQUEST['fir_np']);
$fir_sp = strip_tags($_REQUEST['fir_sp']);
$fir_ip = strip_tags($_REQUEST['fir_ip']);
$fir_pn = strip_tags($_REQUEST['fir_pn']);
$fir_up = strip_tags($_REQUEST['fir_up']);
$fir_gf = strip_tags($_REQUEST['fir_gf']);
$fir_rf = strip_tags($_REQUEST['fir_rf']);

$dan_bonus = strip_tags($_REQUEST['dan_bonus']);
$dan_danov = strip_tags($_REQUEST['dan_danov']);
$soc_perc = strip_tags($_REQUEST['soc_perc']);
$uva_hod = strip_tags($_REQUEST['uva_hod']);
$min_mzda = strip_tags($_REQUEST['min_mzda']);
$dan_perc = strip_tags($_REQUEST['dan_perc']);

$cicz = strip_tags($_REQUEST['cicz']);

$uprav="NO";

if( $kli_vrok >= 2013 ) { $dan_perc = 19; } 

$uprtxt = "UPDATE F$kli_vxcf"."_mzdprm SET ".
" max_zp='$max_zp', max_np='$max_np', max_sp='$max_sp', max_ip='$max_ip', max_pn='$max_pn', ".
" max_up='$max_up', max_gf='$max_gf', max_rf='$max_rf',".
" min_zp='$min_zp', min_np='$min_np', min_sp='$min_sp', min_ip='$min_ip', min_pn='$min_pn', ".
" min_up='$min_up', min_gf='$min_gf', min_rf='$min_rf',".
" zam_zp='$zam_zp', zam_zpn='$zam_zpn', zam_np='$zam_np', zam_sp='$zam_sp', zam_ip='$zam_ip', zam_pn='$zam_pn', ".
" zam_up='$zam_up', zam_gf='$zam_gf', zam_rf='$zam_rf',".
" fir_zp='$fir_zp', fir_zpn='$fir_zpn', fir_np='$fir_np', fir_sp='$fir_sp', fir_ip='$fir_ip', fir_pn='$fir_pn', ".
" fir_up='$fir_up', fir_gf='$fir_gf', fir_rf='$fir_rf',".
" dan_bonus='$dan_bonus', dan_danov='$dan_danov', soc_perc='$soc_perc', uva_hod='$uva_hod', min_mzda='$min_mzda', dan_perc='$dan_perc', ".
" cicz='$cicz' ".
" WHERE datum = '2009-01-01'"; 
//echo $uprtxt;

$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych sadzieb


$sql = "SELECT zuco FROM F$kli_vxcf"."_mzdprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ssyo VARCHAR(10) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ksyo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD vsyo DECIMAL(10,0) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD numo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD uceo VARCHAR(30) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD zuco INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT zuco FROM F$kli_vxcf"."_mzdzalprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD ssyo VARCHAR(10) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD ksyo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD vsyo DECIMAL(10,0) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD numo VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD uceo VARCHAR(30) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD zuco INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
}

//nacitaj udaje
if ( $copern > 1 )
    {

$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdprm WHERE datum > '0000-00-00'";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$datum = $fir_riadok->datum;
$max_zp = $fir_riadok->max_zp;
$max_np = $fir_riadok->max_np;
$max_sp = $fir_riadok->max_sp;
$max_ip = $fir_riadok->max_ip;
$max_pn = $fir_riadok->max_pn;
$max_up = $fir_riadok->max_up;
$max_gf = $fir_riadok->max_gf;
$max_rf = $fir_riadok->max_rf;
$min_zp = $fir_riadok->min_zp;
$min_np = $fir_riadok->min_np;
$min_sp = $fir_riadok->min_sp;
$min_ip = $fir_riadok->min_ip;
$min_pn = $fir_riadok->min_pn;
$min_up = $fir_riadok->min_up;
$min_gf = $fir_riadok->min_gf;
$min_rf = $fir_riadok->min_rf;
$zam_zp = $fir_riadok->zam_zp;
$zam_zpn = $fir_riadok->zam_zpn;
$zam_np = $fir_riadok->zam_np;
$zam_sp = $fir_riadok->zam_sp;
$zam_ip = $fir_riadok->zam_ip;
$zam_pn = $fir_riadok->zam_pn;
$zam_up = $fir_riadok->zam_up;
$zam_gf = $fir_riadok->zam_gf;
$zam_rf = $fir_riadok->zam_rf;
$fir_zp = $fir_riadok->fir_zp;
$fir_zpn = $fir_riadok->fir_zpn;
$fir_np = $fir_riadok->fir_np;
$fir_sp = $fir_riadok->fir_sp;
$fir_ip = $fir_riadok->fir_ip;
$fir_pn = $fir_riadok->fir_pn;
$fir_up = $fir_riadok->fir_up;
$fir_gf = $fir_riadok->fir_gf;
$fir_rf = $fir_riadok->fir_rf;

$dan_bonus = $fir_riadok->dan_bonus;
$dan_danov = $fir_riadok->dan_danov;
$soc_perc = $fir_riadok->soc_perc;
$uva_hod = $fir_riadok->uva_hod;
$min_mzda = $fir_riadok->min_mzda;
$dan_perc = $fir_riadok->dan_perc;

$zucd = $fir_riadok->zucd;
$uced = $fir_riadok->uced;
$numd = $fir_riadok->numd;
$vsyd = $fir_riadok->vsyd;
$ksyd = $fir_riadok->ksyd;
$ssyd = $fir_riadok->ssyd;

$zucs = $fir_riadok->zucs;
$uces = $fir_riadok->uces;
$nums = $fir_riadok->nums;
$vsys = $fir_riadok->vsys;
$ksys = $fir_riadok->ksys;
$ssys = $fir_riadok->ssys;

$zucdz = $fir_riadok->zucdz;
$ucedz = $fir_riadok->ucedz;
$numdz = $fir_riadok->numdz;
$vsydz = $fir_riadok->vsydz;
$ksydz = $fir_riadok->ksydz;
$ssydz = $fir_riadok->ssydz;

$zuco = $fir_riadok->zuco;
$uceo = $fir_riadok->uceo;
$numo = $fir_riadok->numo;
$vsyo = $fir_riadok->vsyo;
$ksyo = $fir_riadok->ksyo;
$ssyo = $fir_riadok->ssyo;


$zucz = $fir_riadok->zucz;

$cicz = $fir_riadok->cicz;

mysql_free_result($fir_vysledok);

    }
//koniec nacitania




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Parametre Mzdy</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
<?php
//uprava sadzby
  if ( $copern == 2 )
  { 
?>
    function ObnovUI()
    {
    //document.formv1.datum.value = '<?php echo "$datum";?>';
    document.formv1.max_zp.value = '<?php echo "$max_zp";?>';
    document.formv1.max_np.value = '<?php echo "$max_np";?>';
    document.formv1.max_sp.value = '<?php echo "$max_sp";?>';
    document.formv1.max_ip.value = '<?php echo "$max_ip";?>';
    document.formv1.max_pn.value = '<?php echo "$max_pn";?>';
    document.formv1.max_up.value = '<?php echo "$max_up";?>';
    document.formv1.max_gf.value = '<?php echo "$max_gf";?>';
    document.formv1.max_rf.value = '<?php echo "$max_rf";?>';

    document.formv1.min_zp.value = '<?php echo "$min_zp";?>';
    document.formv1.min_np.value = '<?php echo "$min_np";?>';
    document.formv1.min_sp.value = '<?php echo "$min_sp";?>';
    document.formv1.min_ip.value = '<?php echo "$min_ip";?>';
    document.formv1.min_pn.value = '<?php echo "$min_pn";?>';
    document.formv1.min_up.value = '<?php echo "$min_up";?>';
    document.formv1.min_gf.value = '<?php echo "$min_gf";?>';
    document.formv1.min_rf.value = '<?php echo "$min_rf";?>';

    document.formv1.zam_zp.value = '<?php echo "$zam_zp";?>';
    document.formv1.zam_zpn.value = '<?php echo "$zam_zpn";?>';
    document.formv1.zam_np.value = '<?php echo "$zam_np";?>';
    document.formv1.zam_sp.value = '<?php echo "$zam_sp";?>';
    document.formv1.zam_ip.value = '<?php echo "$zam_ip";?>';
    document.formv1.zam_pn.value = '<?php echo "$zam_pn";?>';
    document.formv1.zam_up.value = '<?php echo "$zam_up";?>';
    document.formv1.zam_gf.value = '<?php echo "$zam_gf";?>';
    document.formv1.zam_rf.value = '<?php echo "$zam_rf";?>';

    document.formv1.fir_zp.value = '<?php echo "$fir_zp";?>';
    document.formv1.fir_zpn.value = '<?php echo "$fir_zpn";?>';
    document.formv1.fir_np.value = '<?php echo "$fir_np";?>';
    document.formv1.fir_sp.value = '<?php echo "$fir_sp";?>';
    document.formv1.fir_ip.value = '<?php echo "$fir_ip";?>';
    document.formv1.fir_pn.value = '<?php echo "$fir_pn";?>';
    document.formv1.fir_up.value = '<?php echo "$fir_up";?>';
    document.formv1.fir_gf.value = '<?php echo "$fir_gf";?>';
    document.formv1.fir_rf.value = '<?php echo "$fir_rf";?>';

    document.formv1.dan_bonus.value = '<?php echo "$dan_bonus";?>';
    document.formv1.dan_danov.value = '<?php echo "$dan_danov";?>';
    document.formv1.dan_perc.value = '<?php echo "$dan_perc";?>';
    document.formv1.uva_hod.value = '<?php echo "$uva_hod";?>';
    document.formv1.min_mzda.value = '<?php echo "$min_mzda";?>';
    document.formv1.soc_perc.value = '<?php echo "$soc_perc";?>';

<?php if( $kli_vrok >= 2013 ) { ?>
    document.formv1.dan_percx.value = '<?php echo "25.00";?>'
<?php                         } ?>

    document.formv1.cicz.value = '<?php echo "$cicz";?>';
    }
<?php
//koniec uprava
  }
?>



<?php
//nie uprava
  if ( $copern != 2 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
//koniec uprava
  }
?>

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
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt väèší ako 2029.\r"; err=3 }
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
		



		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
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


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des) 
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
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
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



</script>

<?php if( $copern == 2 ) { echo "<script type='text/javascript' src='uloz_banku.js'></script>"; } ?>

<script type='text/javascript'>
//bankao

    var uceo = "<?php echo $uceo;?>";
    var numo = "<?php echo $numo;?>";
    var vsyo = "<?php echo $vsyo;?>";
    var ksyo = "<?php echo $ksyo;?>";
    var ssyo = "<?php echo $ssyo;?>";

    function jeBANKAO()
    { 
    jeBANKAO = document.getElementById("jeBANKAOelement");

    var htmlbankao = "<table  class='ponuka' width='100%'><tr>";

    htmlbankao += "<td width='40%'>Bankovı úèet Odbory: ";
    htmlbankao += "" + uceo + " / ";
    htmlbankao += "" + numo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='15%'>VSY:";
    htmlbankao += "" + vsyo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='10%'>KSY:";
    htmlbankao += "" + ksyo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='15%'>SSY:";
    htmlbankao += "" + ssyo + "";
    htmlbankao += "</td>";

    htmlbankao += "<td width='5%'><a href='#' onClick='vyberBANKUO();'>";
    htmlbankao += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankovı úèet pre odvod odborov' ></a>";
    htmlbankao += "</td>";


    htmlbankao += "<td width='15%' align='right'></td></tr>"; 
    htmlbankao += "</table>";
    jeBANKAO.innerHTML = htmlbankao;
    jeBANKAOelement.style.display='';
    }

    function vyberBANKUO()
    { 
    jeBANKAOelement.style.display='none';
    myBANKAO = document.getElementById("myBANKAOelement");

    var htmlmena = "<table  class='ponuka' width='100%'><tr><FORM name='fbanka5' class='obyc' method='post' action='#' >";

    htmlmena += "<td width='40%'>Bankovı úèet Odbory: ";
    htmlmena += "<input type='text' name='h_uceb' id='h_uceb' size='15' value=\"<?php echo $uceo;?>\" ";
    htmlmena += "onchange='return intg(this,1,99999999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "<input type='text' name='h_numb' id='h_numb' size='15' value=\"<?php echo $numo;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>VSY:";
    htmlmena += "<input type='text' name='h_vsy' id='h_vsy' size='10' value=\"<?php echo $vsyo;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='10%'>KSY:";
    htmlmena += "<input type='text' name='h_ksy' id='h_ksy' size='10' value=\"<?php echo $ksyo;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>SSY:";
    htmlmena += "<input type='text' name='h_ssy' id='h_ssy' size='10' value=\"<?php echo $ssyo;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='5%'>";
    htmlmena += "<img border=0 src='../obr/ok.png' style='width:15; height:10;' onclick='ulozBANKU(5,0);' alt='Uloi' title='Uloi' >";

    htmlmena += "</td>";


    htmlmena += "<td width='15%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmena += "onClick='zhasniBANKUO();' alt='Zhasni nastavenie úètu' ></td></FORM></tr>"; 
    htmlmena += "</table>";
    myBANKAO.innerHTML = htmlmena;
    myBANKAOelement.style.display='';
    }

    function zhasniBANKUO()
    { 
    myBANKAOelement.style.display='none';
    jeBANKAOelement.style.display='';
    }

//bankad

    var uced = "<?php echo $uced;?>";
    var numd = "<?php echo $numd;?>";
    var vsyd = "<?php echo $vsyd;?>";
    var ksyd = "<?php echo $ksyd;?>";
    var ssyd = "<?php echo $ssyd;?>";

    function jeBANKAD()
    { 
    jeBANKAD = document.getElementById("jeBANKADelement");

    var htmlbankad = "<table  class='ponuka' width='100%'><tr>";

    htmlbankad += "<td width='40%'>Bankovı úèet Daò z príjmu: ";
    htmlbankad += "" + uced + " / ";
    htmlbankad += "" + numd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='15%'>VSY:";
    htmlbankad += "" + vsyd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='10%'>KSY:";
    htmlbankad += "" + ksyd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='15%'>SSY:";
    htmlbankad += "" + ssyd + "";
    htmlbankad += "</td>";

    htmlbankad += "<td width='5%'><a href='#' onClick='vyberBANKUD();'>";
    htmlbankad += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankovı úèet pre odvod dane z príjmu' ></a>";
    htmlbankad += "</td>";


    htmlbankad += "<td width='15%' align='right'></td></tr>"; 
    htmlbankad += "</table>";
    jeBANKAD.innerHTML = htmlbankad;
    jeBANKADelement.style.display='';
    }

    function vyberBANKUD()
    { 
    jeBANKADelement.style.display='none';
    myBANKAD = document.getElementById("myBANKADelement");

    var htmlmena = "<table  class='ponuka' width='100%'><tr><FORM name='fbanka2' class='obyc' method='post' action='#' >";

    htmlmena += "<td width='40%'>Bankovı úèet Daò z príjmu: ";
    htmlmena += "<input type='text' name='h_uceb' id='h_uceb' size='15' value=\"<?php echo $uced;?>\" ";
    htmlmena += "onchange='return intg(this,1,99999999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "<input type='text' name='h_numb' id='h_numb' size='15' value=\"<?php echo $numd;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>VSY:";
    htmlmena += "<input type='text' name='h_vsy' id='h_vsy' size='10' value=\"<?php echo $vsyd;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='10%'>KSY:";
    htmlmena += "<input type='text' name='h_ksy' id='h_ksy' size='10' value=\"<?php echo $ksyd;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>SSY:";
    htmlmena += "<input type='text' name='h_ssy' id='h_ssy' size='10' value=\"<?php echo $ssyd;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='5%'>";
    htmlmena += "<img border=0 src='../obr/ok.png' style='width:15; height:10;' onclick='ulozBANKU(2,0);' alt='Uloi' title='Uloi' >";
    htmlmena += "</td>";


    htmlmena += "<td width='15%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmena += "onClick='zhasniBANKUD();' alt='Zhasni nastavenie úètu' ></td></FORM></tr>"; 
    htmlmena += "</table>";
    myBANKAD.innerHTML = htmlmena;
    myBANKADelement.style.display='';
    }

    function zhasniBANKUD()
    { 
    myBANKADelement.style.display='none';
    jeBANKADelement.style.display='';
    }

//bankas

    var uces = "<?php echo $uces;?>";
    var nums = "<?php echo $nums;?>";
    var vsys = "<?php echo $vsys;?>";
    var ksys = "<?php echo $ksys;?>";
    var ssys = "<?php echo $ssys;?>";

    function jeBANKAS()
    { 
    jeBANKAS = document.getElementById("jeBANKASelement");

    var htmlbankas = "<table  class='ponuka' width='100%'><tr>";

    htmlbankas += "<td width='40%'>Bankovı úèet SP: ";
    htmlbankas += "" + uces + " / ";
    htmlbankas += "" + nums + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='15%'>VSY:";
    htmlbankas += "" + vsys + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='10%'>KSY:";
    htmlbankas += "" + ksys + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='15%'>SSY:";
    htmlbankas += "" + ssys + "";
    htmlbankas += "</td>";

    htmlbankas += "<td width='5%'><a href='#' onClick='vyberBANKUS();'>";
    htmlbankas += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankovı úèet pre odvod dane z príjmu' ></a>";
    htmlbankas += "</td>";


    htmlbankas += "<td width='15%' align='right'></td></tr>"; 
    htmlbankas += "</table>";
    jeBANKAS.innerHTML = htmlbankas;
    jeBANKASelement.style.display='';
    }

    function vyberBANKUS()
    { 
    jeBANKASelement.style.display='none';
    myBANKAS = document.getElementById("myBANKASelement");

    var htmlmena = "<table  class='ponuka' width='100%'><tr><FORM name='fbanka3' class='obyc' method='post' action='#' >";

    htmlmena += "<td width='40%'>Bankovı úèet SP: ";
    htmlmena += "<input type='text' name='h_uceb' id='h_uceb' size='15' value=\"<?php echo $uces;?>\" ";
    htmlmena += "onchange='return intg(this,1,99999999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "<input type='text' name='h_numb' id='h_numb' size='15' value=\"<?php echo $nums;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>VSY:";
    htmlmena += "<input type='text' name='h_vsy' id='h_vsy' size='10' value=\"<?php echo $vsys;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='10%'>KSY:";
    htmlmena += "<input type='text' name='h_ksy' id='h_ksy' size='10' value=\"<?php echo $ksys;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>SSY:";
    htmlmena += "<input type='text' name='h_ssy' id='h_ssy' size='10' value=\"<?php echo $ssys;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='5%'>";
    htmlmena += "<img border=0 src='../obr/ok.png' style='width:15; height:10;' onclick='ulozBANKU(3,0);' alt='Uloi' title='Uloi' >";
    htmlmena += "</td>";


    htmlmena += "<td width='15%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmena += "onClick='zhasniBANKUS();' alt='Zhasni nastavenie úètu' ></td></FORM></tr>"; 
    htmlmena += "</table>";
    myBANKAS.innerHTML = htmlmena;
    myBANKASelement.style.display='';
    }

    function zhasniBANKUS()
    { 
    myBANKASelement.style.display='none';
    jeBANKASelement.style.display='';
    }

//bankadz

    var ucedz = "<?php echo $ucedz;?>";
    var numdz = "<?php echo $numdz;?>";
    var vsydz = "<?php echo $vsydz;?>";
    var ksydz = "<?php echo $ksydz;?>";
    var ssydz = "<?php echo $ssydz;?>";

    function jeBANKADZ()
    { 
    jeBANKADZ = document.getElementById("jeBANKADZelement");

    var htmlbankadz = "<table  class='ponuka' width='100%'><tr>";

    htmlbankadz += "<td width='40%'>Bankovı úèet zráková daò: ";
    htmlbankadz += "" + ucedz + " / ";
    htmlbankadz += "" + numdz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='15%'>VSY:";
    htmlbankadz += "" + vsydz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='10%'>KSY:";
    htmlbankadz += "" + ksydz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='15%'>SSY:";
    htmlbankadz += "" + ssydz + "";
    htmlbankadz += "</td>";

    htmlbankadz += "<td width='5%'><a href='#' onClick='vyberBANKUDZ();'>";
    htmlbankadz += "<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 alt='Nastavi bankovı úèet pre odvod zrákovej dane' ></a>";
    htmlbankadz += "</td>";


    htmlbankadz += "<td width='15%' align='right'></td></tr>"; 
    htmlbankadz += "</table>";
    jeBANKADZ.innerHTML = htmlbankadz;
    jeBANKADZelement.style.display='';
    }

    function vyberBANKUDZ()
    { 
    jeBANKADZelement.style.display='none';
    myBANKADZ = document.getElementById("myBANKADZelement");

    var htmlmena = "<table  class='ponuka' width='100%'><tr><FORM name='fbanka4' class='obyc' method='post' action='#' >";

    htmlmena += "<td width='40%'>Bankovı úèet zráková daò: ";
    htmlmena += "<input type='text' name='h_uceb' id='h_uceb' size='15' value=\"<?php echo $ucedz;?>\" ";
    htmlmena += "onchange='return intg(this,1,99999999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "<input type='text' name='h_numb' id='h_numb' size='15' value=\"<?php echo $numdz;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>VSY:";
    htmlmena += "<input type='text' name='h_vsy' id='h_vsy' size='10' value=\"<?php echo $vsydz;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='10%'>KSY:";
    htmlmena += "<input type='text' name='h_ksy' id='h_ksy' size='10' value=\"<?php echo $ksydz;?>\" ";
    htmlmena += "onchange='return intg(this,0,9999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='15%'>SSY:";
    htmlmena += "<input type='text' name='h_ssy' id='h_ssy' size='10' value=\"<?php echo $ssydz;?>\" ";
    htmlmena += "onchange='return intg(this,1,9999999999,Cele)' onclick=\"Fx.style.display='none';\" onkeyup=\"KontrolaCisla(this, Cele)\" /> ";
    htmlmena += "</td>";

    htmlmena += "<td width='5%'>";
    htmlmena += "<img border=0 src='../obr/ok.png' style='width:15; height:10;' onclick='ulozBANKU(4,0);' alt='Uloi' title='Uloi' >";
    htmlmena += "</td>";


    htmlmena += "<td width='15%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'";
    htmlmena += "onClick='zhasniBANKUDZ();' alt='Zhasni nastavenie úètu' ></td></FORM></tr>"; 
    htmlmena += "</table>";
    myBANKADZ.innerHTML = htmlmena;
    myBANKADZelement.style.display='';
    }

    function zhasniBANKUDZ()
    { 
    myBANKADZelement.style.display='none';
    jeBANKADZelement.style.display='';
    }

    function danoveUcty()
    {
window.open('../cis/ufirdalsie.php?copern=1&drupoh=1&page=1','_self', 'width=1180, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')
    }

</script>

</HEAD>
<BODY class="white" onload="ObnovUI();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 ) echo " Sadzby odvodov do ZP,SP a dane z príjmov od 01.01.$kli_vrok";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zobraz nastavene sadzby
if ( $copern == 1 OR $copern == 3 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_mzdprm WHERE datum > '0000-00-00'";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>

<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musí by celé kladné èíslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Dátum musí by v tvare DD.MM.RRRR,DD.MM alebo DD napríklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 2 desatinné miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 4 desatinné miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 1 desatinné miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OSÈ musí by celé kladné èíslo v rozsahu 1 a 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Musíte vyplni všetky poloky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloka OSÈ=<?php echo $h_oc;?> správne uloená</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="parametre.php?copern=2" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Fond</td>
<td class="bmenu" colspan="2">%Zamestnanec</td>
<td class="bmenu" colspan="2">%Zamestnávate¾</td>
<td class="bmenu" colspan="2">Maximálny VZ <?php echo "$mena1";?></td>
<td class="bmenu" colspan="2">Minimálny VZ <?php echo "$mena1";?></td>
</tr>
<tr>
<td class="bmenu" colspan="2">ZP Zdravotné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_zp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_zp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_zp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_zp";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">ZP Zdravotné poistenie - zníené sadzby</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_zpn";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_zpn";?></td>
<td class="bmenu" colspan="2" align="right">IÈZ/variabilnı symbol SP: </td>
<td class="fmenu" colspan="2"><?php echo "$riadok->cicz";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">NP Nemocenské poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_np";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_np";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_np";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_np";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">DP Starobné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_sp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_sp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_sp";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_sp";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">DP Invalidné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_ip";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_ip";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_ip";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_ip";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">PvN Poistenie v nezamestnanosti</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_pn";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_pn";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_pn";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_pn";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">UP Úrazové poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_up";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_up";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_up";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_up";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">GF Garanèné poistenie</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_gf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_gf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_gf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_gf";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">RF Poistenie do rezervného fondu</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->zam_rf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->fir_rf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->max_rf";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_rf";?></td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr>
<td class="bmenu" colspan="2">Daòovı bonus mesaène <?php echo "$mena1";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->dan_bonus";?></td>
</tr>
<tr>
<td class="bmenu" colspan="2">Nezdanite¾ná èas na daòovníka mesaène <?php echo "$mena1";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->dan_danov";?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Sadzba dane z príjmu </td>
<td class="fmenu" colspan="2"><?php echo "$riadok->dan_perc";?>%
<?php if( $kli_vrok == 2013 ) { ?>
 + 25.00% z rozdielu (základ dane - 2866.81) ak Základ dane > 2866.81 
<?php                         } ?>
<?php if( $kli_vrok == 2014 ) { ?>
 + 25.00% z rozdielu (základ dane - 2918.53) ak Základ dane > 2918.53 
<?php                         } ?>
<?php if( $kli_vrok >= 2015 ) { ?>
 + 25.00% z rozdielu (základ dane - 2918.53) ak Základ dane > 2918.53 
<?php                         } ?>
</td>
<td></td>
<td class="bmenu" colspan="4">
<?php if( $kli_vrok < 2012 ) { ?>Bankovı úèet daò z príjmu: <?php echo "$riadok->uced";?> / <?php echo "$riadok->numd";?><?php } ?>
<?php if( $kli_vrok == 2012 ) { ?>Bankovı úèet pre daò z príjmu nastavíte v údajoch o firme cez ikonku "úèty DÚ"<?php } ?>
<?php if( $kli_vrok == 2013 ) { ?>Bankovı úèet pre daò z príjmu nastavíte v údajoch o firme cez ikonku "úèty DÚ"<?php } ?>
<?php if( $kli_vrok >= 2014 ) { ?>Bankovı úèet pre daò z príjmu, SP a odbory nastavíte v <a href="#" onClick="danoveUcty();"> údajoch o firme  </a><?php } ?>
</td>
</tr>

<tr>
<td class="bmenu" colspan="2">Minimálna mzda <?php echo "$mena1";?></td>
<td class="fmenu" colspan="2"><?php echo "$riadok->min_mzda";?></td>
<td></td>
<td class="bmenu" colspan="4">
<?php if( $kli_vrok < 2012 ) { ?>Bankovı úèet zráková daò: <?php echo "$riadok->ucedz";?> / <?php echo "$riadok->numdz";?><?php } ?></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Úväzok hod/deò</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->uva_hod";?></td>
<td></td>
<td class="bmenu" colspan="4">
<?php if( $kli_vrok < 2014 ) { ?>Bankovı úèet SP: <?php echo "$riadok->uces";?> / <?php echo "$riadok->nums";?><?php } ?>
</td>
</tr>

<tr>
<td class="bmenu" colspan="2">Percento soc.fondu</td>
<td class="fmenu" colspan="2"><?php echo "$riadok->soc_perc";?></td>
<td></td>
<td class="bmenu" colspan="4">
<?php if( $kli_vrok < 2014 ) { ?>Bankovı úèet Odbory: <?php echo "$riadok->uceo";?> / <?php echo "$riadok->numo";?><?php } ?>
</td>
</tr>

<tr></tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia  sadzieb
?>



<?php
//upravy  sadzby
if ( $copern == 2 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musí by celé kladné èíslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Dátum musí by v tvare DD.MM.RRRR,DD.MM alebo DD napríklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 2 desatinné miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 4 desatinné miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus by desatinné èíslo, maximálne 1 desatinné miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OSÈ musí by celé kladné èíslo v rozsahu 1 a 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Musíte vyplni všetky poloky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloka OSÈ=<?php echo $h_oc;?> správne uloená</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="parametre.php?copern=3" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Fond</td>
<td class="bmenu" colspan="2">%Zamestnanec</td>
<td class="bmenu" colspan="2">%Zamestnávate¾</td>
<td class="bmenu" colspan="2">Maximálny VZ <?php echo "$mena1";?></td>
<td class="bmenu" colspan="2">Minimálny VZ <?php echo "$mena1";?></td>
</tr>
<tr>
<td class="bmenu" colspan="2">ZP Zdravotné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_zp" id="zam_zp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_zp" id="fir_zp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_zp" id="max_zp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_zp" id="min_zp" /></td>
</tr>

<tr>
<td class="bmenu" colspan="2">ZP Zdravotné poistenie - zníené sadzby</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_zpn" id="zam_zpn" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_zpn" id="fir_zpn" /></td>
<td class="bmenu" colspan="2" align="right">IÈZ: </td>
<td class="fmenu" colspan="2"><input type="text" name="cicz" id="cicz" /></td>
</tr>

<td class="bmenu" colspan="2">NP Nemocenské poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_np" id="zam_np" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_np" id="fir_np" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_np" id="max_np" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_np" id="min_np" /></td>
</tr>

<td class="bmenu" colspan="2">DP Starobné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_sp" id="zam_sp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_sp" id="fir_sp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_sp" id="max_sp" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_sp" id="min_sp" /></td>
</tr>

<td class="bmenu" colspan="2">DP Invalidné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_ip" id="zam_ip" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_ip" id="fir_ip" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_ip" id="max_ip" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_ip" id="min_ip" /></td>
</tr>

<td class="bmenu" colspan="2">PvN Poistenie v nezamestnanosti</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_pn" id="zam_pn" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_pn" id="fir_pn" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_pn" id="max_pn" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_pn" id="min_pn" /></td>
</tr>

<td class="bmenu" colspan="2">UP Úrazové poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_up" id="zam_up" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_up" id="fir_up" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_up" id="max_up" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_up" id="min_up" /></td>
</tr>

<td class="bmenu" colspan="2">GF Garanèné poistenie</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_gf" id="zam_gf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_gf" id="fir_gf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_gf" id="max_gf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_gf" id="min_gf" /></td>
</tr>

<td class="bmenu" colspan="2">RF Poistenie do rezervného fondu</td>
<td class="fmenu" colspan="2"><input type="text" name="zam_rf" id="zam_rf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="fir_rf" id="fir_rf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="max_rf" id="max_rf" /></td>
<td class="fmenu" colspan="2"><input type="text" name="min_rf" id="min_rf" /></td>
</tr>

<tr><td class="bmenu" colspan="10"></td></tr>

<tr>
<td class="bmenu" colspan="2">Daòovı bonus mesaène <?php echo "$mena1";?></td>
<td class="fmenu" colspan="2"><input type="text" name="dan_bonus" id="dan_bonus" /></td>
</tr>
<tr>
<td class="bmenu" colspan="2">Odpoèet na daòovníka mesaène <?php echo "$mena1";?></td>
<td class="fmenu" colspan="2"><input type="text" name="dan_danov" id="dan_danov" /></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Sadzba dane z príjmu %</td>
<td class="fmenu" colspan="2"><input type="text" name="dan_perc" id="dan_perc" /></td>
<?php if( $kli_vrok == 2013 ) { ?>
<td class="bmenu" colspan="1" align="center"> + </td>
<td class="fmenu" colspan="1"><input type="text" name="dan_percx" id="dan_percx" size="4" />%</td>
<td class="bmenu" colspan="3" align="center">z rozdielu (základ dane - 2866.81) ak Základ dane > 2866.81 </td>
<?php                         } ?>
<?php if( $kli_vrok == 2014 ) { ?>
<td class="bmenu" colspan="1" align="center"> + </td>
<td class="fmenu" colspan="1"><input type="text" name="dan_percx" id="dan_percx" size="4" />%</td>
<td class="bmenu" colspan="3" align="center">z rozdielu (základ dane - 2918.53) ak Základ dane > 2918.53 </td>
<?php                         } ?>
<?php if( $kli_vrok >= 2015 ) { ?>
<td class="bmenu" colspan="1" align="center"> + </td>
<td class="fmenu" colspan="1"><input type="text" name="dan_percx" id="dan_percx" size="4" />%</td>
<td class="bmenu" colspan="3" align="center">z rozdielu (základ dane - 2918.53) ak Základ dane > 2918.53 </td>
<?php                         } ?>
</tr>

<tr>
<td class="bmenu" colspan="2">Minimálna mzda <?php echo "$mena1";?></td>
<td class="fmenu" colspan="2"><input type="text" name="min_mzda" id="min_mzda" /></td>
</tr>

<tr>
<td class="bmenu" colspan="2">Úväzok hod/deò</td>
<td class="fmenu" colspan="2"><input type="text" name="uva_hod" id="uva_hod" /></td>
</tr>


<tr>
<td class="bmenu" colspan="2">Percento soc.fondu</td>
<td class="fmenu" colspan="2"><input type="text" name="soc_perc" id="soc_perc" /></td>
</tr>

<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloi úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="parametre.php?copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloi"></td>
</tr>
</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>
<div id="myBANKADZelement"></div>
<div id="jeBANKADZelement"></div>
<div id="myBANKASelement"></div>
<div id="jeBANKASelement"></div>
<div id="myBANKAOelement"></div>
<div id="jeBANKAOelement"></div>

<?php if( $kli_vrok < 2012 ) { ?>
<script type="text/javascript">
jeBANKAD(); jeBANKADZ(); jeBANKAS(); jeBANKAO();
</script>
<?php                        } ?>

<?php if( $kli_vrok >= 2012 AND $kli_vrok < 2014 ) { ?>
<script type="text/javascript">
jeBANKAS(); jeBANKAO();
</script>
<?php                        } ?>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  sadzby
?>





<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
