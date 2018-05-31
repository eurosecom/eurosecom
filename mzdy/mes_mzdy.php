<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'MZD';
$urov = 2000;
$clsm = 210;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmzd = include("../mzdy/vtvmzd.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$kanc = 1*$_REQUEST['kanc'];
$cislo_kanc = 1*$_REQUEST['cislo_kanc'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];

$tlacitkoenter=0;
//if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $tlacitkoenter=1; }
if( $copern != 1 ) { $tlacitkoenter=0; }

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$ajstj=0;
if( $polno == 1 ) { $ajstj=1; }

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$prvydensk="1.".$kli_vmes.".".$kli_vrok;

if( $copern > 0 )
    {
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalkun WHERE ume = $kli_vume ORDER BY ume";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
?>
<script type="text/javascript">
alert ("POZOR ! Mzdy za obdobie <?php echo $kli_vume; ?> , \r boli uû spracovanÈ naostro !");
</script>
<?php
}
    }

$nexto = 1*$_REQUEST['nexto'];
if( $nexto == 1 ) { $_SESSION['vyb_osc'] = 1*$_REQUEST['vyb_osc']; $copern=1; }
$prevo = 1*$_REQUEST['prevo'];
if( $prevo == 1 ) { $_SESSION['vyb_osc'] = 1*$_REQUEST['vyb_osc']; $copern=1; } 
$novehladanie = 1*$_REQUEST['novehladanie'];
if( $novehladanie == 1 ) { $_SESSION['vyb_osc'] = ""; $copern=1; }

if( $copern == 101 ) { $_SESSION['vyb_osc'] = 1*$_REQUEST['vyb_osc']; $copern=1; }

$vyb_osc = 1*$_SESSION['vyb_osc'];

//echo "vyb_osc".$vyb_osc;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

if( $drupoh == 1 )
{
$uce=1;
$drpsk=2;
}

include("vypocet_sz4.php");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>MesaËn· mzda</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>
</SCRIPT>

<script type="text/javascript" src="mzd_vyberoc_xml.js"></script>
<script type="text/javascript" src="mzd_mes_vyp.js"></script>
<script type="text/javascript" src="mzd_mes_ins.js"></script>
<script type="text/javascript" src="mzd_mes_del.js"></script>

<script type="text/javascript" src="spr_str_xml.js"></script>
<?php if( $ajstj == 1 ) { ?>
<script type="text/javascript" src="spr_stj_xml.js"></script>
<?php                   } ?>
<script type="text/javascript" src="spr_zak_xml.js"></script>
<script type="text/javascript" src="spr_dm_xml.js"></script>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    

    function Trvale()
    {
    var osc = document.forms.forms1.h_ico.value;
    if( osc > 0 ) { 

    window.open('../mzdy/trvale.php?copern=1&drupoh=1&zkun=1&cislo_oc=' + osc + '&page=1', '_self', '<?php echo $tlcswin; ?>' ); }
    window.close;

    }


//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }


    function ZmazMesCvicna()
    {
        document.forms.formv1.h_dok.value=1500;

    }

//posuny Enter[[[[[[[[[[[

function DokEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
        document.forms.formv1.h_dat.focus();
        document.forms.formv1.h_dat.select();
                   }
                }

function DatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
        document.forms.formv1.h_str.focus();
        document.forms.formv1.h_str.select();
                   }
                }


function DpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
        document.forms.formv1.h_dk.focus();
        document.forms.formv1.h_dk.select();
                   }
                }

function DkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {

        if ( document.formv1.h_dp.value != '' && document.formv1.h_dk.value != ''  ) { 
            var pocdat = new Date();
       var b;
       b=document.formv1.h_dp.value;
       var c=b.toString();
       var d=c.split('.');
       pocdat.setDate(d[0]);
       pocddt=1*d[0];
       pocdat.setMonth("0");
       pocdat.setFullYear("2009");
            var kondat = new Date();
       var bb;
       bb=document.formv1.h_dk.value;
       var cc=bb.toString();
       var dd=cc.split('.');
       kondat.setDate(dd[0]);
       konddt=1*dd[0];
       kondat.setMonth("0");
       kondat.setFullYear("2009");
            var poccis   = pocdat.getDate();
            var koncis   = kondat.getDate();
            var pocetdni = konddt-pocddt+1;
            document.formv1.h_dn.value = pocetdni;
                                                                                      }

        document.forms.formv1.h_dn.focus();
        document.forms.formv1.h_dn.select();
                   }
                }

function DnFocus()
                {

        if ( document.formv1.h_dm.value >= 800 && document.formv1.h_dm.value <= 899 && document.formv1.h_dp.value == '' ) { 
        document.forms.formv1.h_dp.focus();
        document.forms.formv1.h_dp.select();
                   }
 
        if ( document.formv1.h_dm.value >= 502 && document.formv1.h_dm.value <= 503 && document.formv1.h_dp.value == '' ) { 
        document.forms.formv1.h_dp.focus();
        document.forms.formv1.h_dp.select();
                   }

<?php if( $alchem == 1 ) { ?>
        if ( document.formv1.h_dm.value == 513 && document.formv1.h_dp.value == '' ) { 
        document.forms.formv1.h_dp.focus();
        document.forms.formv1.h_dp.select();
                   }
<?php                    } ?>

        if ( document.formv1.h_dm.value >= 900 && document.formv1.h_dm.value <= 999  ) { 
        if ( document.formv1.h_kc.value == '' ) { document.formv1.h_kc.value = 0; }
        document.formv1.h_dn.value = 0;
        document.formv1.h_hh.value = 0;
        document.forms.formv1.h_kc.focus();
        document.forms.formv1.h_kc.select();
                   }
               }

function DnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
        if ( document.formv1.h_zak.value == '' ) document.formv1.h_zak.value = '0';
        var hodiny = document.formv1.h_dn.value*document.formv1.uva.value; hodiny2 = hodiny.toFixed(2);
        document.formv1.h_hh.value = hodiny2; 
<?php if( $ajstj == 0 ) { ?>
        document.forms.formv1.h_zak.focus();
        document.forms.formv1.h_zak.select();
<?php                   } ?>
<?php if( $ajstj == 1 ) { ?>
        if ( document.formv1.h_dm.value != 104 && document.formv1.h_dm.value != 107 && document.formv1.h_dm.value != 108 ) { 
        document.forms.formv1.h_zak.focus();
        document.forms.formv1.h_zak.select();
                                                                                      }
        if ( document.formv1.h_dm.value == 104 || document.formv1.h_dm.value == 107 || document.formv1.h_dm.value == 108 ) { 
        document.forms.formv1.h_stj.focus();
        document.forms.formv1.h_stj.select();
                                                                                      }
<?php                   } ?>
                   }
                }

<?php if( $ajstj == 0 ) { ?>

function StjEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
        document.forms.formv1.h_zak.focus();
        document.forms.formv1.h_zak.select();
                   }
                }

function VolajStj()
                {

                }

<?php                    } ?>


<?php if( $ajstj == 1 ) { ?>

function StjEnter(e)
           {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 )  {
        if ( document.formv1.h_stj.value != '' && document.formv1.h_stj.value != '0' ) 

              { myStjelement.style.display=''; volajStj(1); }

        if ( document.formv1.h_stj.value == '0' || document.formv1.h_stj.value == '' )
        {         
        document.forms.formv1.h_zak.focus();
        document.forms.formv1.h_zak.select();
        }
                }
            }

//co urobi po potvrdeni ok z tabulky str
function vykonajStj(stj,stjtext)
                {
         ukazStj.innerHTML = "Stroj: " + stjtext;
         ukazStj.style.display='';
         document.forms.formv1.h_stj.value = stj;
         myStjelement.style.display='none';
         ZhasniSP();
         document.formv1.h_zak.focus();
         document.formv1.h_zak.select();
                }


function Len1Stj(stj)
              {
         document.forms.formv1.h_stj.value = stj;
         myStjelement.style.display='none';
         ZhasniSP();
         document.formv1.h_zak.focus();
         document.formv1.h_zak.select();
              }

function Len0Stj()
                    {
         document.formv1.h_stj.focus();
         document.formv1.h_stj.select();
                    }

<?php                    } ?>


function HhEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
<?php if( $ajstj == 0 ) { ?>
        document.forms.formv1.h_sa.focus();
        document.forms.formv1.h_sa.select();
<?php                   } ?>
<?php if( $ajstj == 1 ) { ?>
        if ( document.formv1.h_dm.value != 104 && document.formv1.h_dm.value != 107 && document.formv1.h_dm.value != 108 ) { 
        document.forms.formv1.h_sa.focus();
        document.forms.formv1.h_sa.select();
                                                                                      }
        if ( document.formv1.h_dm.value == 104 || document.formv1.h_dm.value == 107 || document.formv1.h_dm.value == 108 ) { 
        document.forms.formv1.h_mn.focus();
        document.forms.formv1.h_mn.select();
                                                                                      }
<?php                   } ?>
                   }
                }

function MnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
        if ( document.formv1.h_sa.value == '' ) document.formv1.h_sa.value = '0';
        document.forms.formv1.h_sa.focus();
        document.forms.formv1.h_sa.select();
                   }
                }

function SaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
      if(k == 13 ) {
        if ( document.formv1.h_sa.value > 0 ) { 
          if( document.formv1.h_dm.value < 800  ) { var eura = document.formv1.h_hh.value*document.formv1.h_sa.value; }
          if( document.formv1.h_dm.value >= 800 ) { var eura = document.formv1.h_dn.value*document.formv1.h_sa.value; }
          if( document.formv1.h_mn.value > 0 ) { var eura = document.formv1.h_mn.value*document.formv1.h_sa.value; }
                 eura2 = eura.toFixed(2); document.formv1.h_kc.value = eura2;    }
        if( document.formv1.h_dm.value == 801  ) { document.formv1.h_sa.value=0; document.formv1.h_kc.value=0; }
        if( document.formv1.h_dm.value == 802  ) { document.formv1.h_sa.value=0; document.formv1.h_kc.value=0; }
        if( document.formv1.h_dm.value == 502  ) { document.formv1.h_kc.value=0; }
        if( document.formv1.h_dm.value == 503  ) { document.formv1.h_kc.value=0; }
        document.forms.formv1.h_kc.focus();
        document.forms.formv1.h_kc.select();
                   }
        if( document.formv1.dm_sa.value == 0 && document.forms.formv1.dm_ko.value == 50  ) 
                                               { 
        document.formv1.h_sa.value=0; 
        document.formv1.h_kc.value=0; 
        document.forms.formv1.h_kc.focus();
        document.forms.formv1.h_kc.select();
                                               }
                }

function KcEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

        if ( document.formv1.h_kc.value != '' ) Ulozit();

              }
                }


function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if( document.forms.forms1.h_ico.value != ''  )
        {
        document.forms.forms1.icoenter.value=1;
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms.forms1.h_nai.value = '';
        volajSaldo();
        }      

        if( document.forms1.h_ico.value == "" ) {  document.forms1.h_nai.focus(); }

              }
                }


function NaiEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        if(document.forms.forms1.h_nai.value != '' )
        {
        document.forms.forms1.icoenter.value=1;
        New.style.display="none";
        mySaldoelement.style.display='none';
        document.forms1.h_ico.value = ""; 
        volajSaldo();
        }   

        if( document.forms1.h_nai.value == "" ) { document.forms1.h_ico.focus(); }

              }
                }

//co urobi po potvrdeni ok z tabulky Saldo
function vykonajSaldo(oc,prie,meno,prm1,prm2,prm3,prm4,stz,zkz,znah,znem,uva,sz0,sz1,sz2,sz3,sz4)
                {
        document.forms.forms1.h_ico.value = oc;
        document.forms.forms1.h_nai.value = prie + " " + meno;
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        mySaldoelement.style.display='none';
        New.style.display='none';
        var mazanie = 0;
        //vypisMes(oc);
        divNahrate.style.display='';
        if( document.forms.formv1.h_dok.value == '' ) { document.forms.formv1.h_dok.value =1; }
        if( document.forms.formv1.h_dat.value == '' ) { document.forms.formv1.h_dat.value = '<?php echo $prvydensk; ?>'; }
        document.forms.formv1.h_str.value = stz;
        document.forms.formv1.h_zak.value = zkz;
        document.forms.formv1.znah.value = znah;
        document.forms.formv1.znem.value = znem;
        document.forms.formv1.uva.value = uva;
        document.forms.formv1.sz0.value = sz0;
        document.forms.formv1.sz1.value = sz1;
        document.forms.formv1.sz2.value = sz2;
        document.forms.formv1.sz3.value = sz3;
        document.forms.formv1.sz4.value = sz4;
        document.forms.formv1.h_dm.focus();
        document.forms.formv1.h_dm.select();
        prebliknioc();
                }

function prebliknioc()
                    {
        var vyboc=document.forms.forms1.h_ico.value;

        window.open('mes_mzdy.php?copern=1&drupoh=1&page=1&nexto=1&vyb_osc=' + vyboc + '&cislo_os=' + vyboc + '&tt=1', '_self' )
                    }


function Len1Saldo(oc,stz,zkz,znah,znem,uva,sz0,sz1,sz2,sz3,sz4)
                    {
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
        mySaldoelement.style.display='none';
        New.style.display='none';
        var mazanie = 0;
        if( document.forms.forms1.icoenter.value == 0 ) { vypisMes(oc); }       
        divNahrate.style.display='';
        if( document.forms.formv1.h_dok.value == '' ) { document.forms.formv1.h_dok.value =1; }
        if( document.forms.formv1.h_dat.value == '' ) { document.forms.formv1.h_dat.value = '<?php echo $prvydensk; ?>'; }
        document.forms.formv1.h_str.value = stz;
        document.forms.formv1.h_zak.value = zkz;
        document.forms.formv1.znah.value = znah;
        document.forms.formv1.znem.value = znem;
        document.forms.formv1.uva.value = uva;
        document.forms.formv1.sz0.value = sz0;
        document.forms.formv1.sz1.value = sz1;
        document.forms.formv1.sz2.value = sz2;
        document.forms.formv1.sz3.value = sz3;
        document.forms.formv1.sz4.value = sz4;
        document.forms.formv1.h_dm.focus();
        document.forms.formv1.h_dm.select();
        if( document.forms.forms1.icoenter.value == 1 ) { prebliknioc(); }
                    }

function Len0Saldo()
                    {
        divNahrate.style.display='none';
        New.style.display="";
        document.forms.forms1.h_nai.focus();
        document.forms.forms1.h_nai.select();
                    }


function Dalsi()
                {
        var nowzak = document.forms.forms1.h_ico.value;
        var nextzak = 1*nowzak + 1;
        document.forms.forms1.h_ico.value = nextzak;
        document.forms.forms1.h_nai.value = '';
        mySaldoelement.style.display='none';
        document.forms.forms1.h_ico.focus();
        document.forms.forms1.h_ico.select();
        New.style.display='none';
        mySaldoelement.style.display='none';
        volajSaldo();

                }

function Minul()
                {
        var nowzak = document.forms.forms1.h_ico.value;
        var prevzak = 1*nowzak - 1;
        if( prevzak == 0 ) { prevzak=1; }
        document.forms.forms1.h_ico.value = prevzak;
        document.forms.forms1.h_nai.value = '';
        mySaldoelement.style.display='none';
        document.forms.forms1.h_ico.focus();
        document.forms.forms1.h_ico.select();
        New.style.display='none';
        mySaldoelement.style.display='none';
        volajSaldo();

                }

function NoveHladanie()
                {
          mySaldoelement.style.display='none';
          New.style.display='none';
          divNahrate.style.display='none';
                }

function ZhasniSP()
                {
                Fx.style.display="none";
                Dni.style.display="none";
                Dm.style.display="none";
                Des.style.display="none";
                Des4.style.display="none";
                Str.style.display="none";
                Stj.style.display="none";
                Zak.style.display="none";
                Datum.style.display="none";

                NiejeStr.style.display="none";
                NiejeStj.style.display="none";
                NiejeZak.style.display="none";
                NiejeDm.style.display="none";
                }

function VyberVstup()
                {
        <?php if( $vyb_osc > 0 )  echo "document.forms.forms1.h_ico.value = '$vyb_osc'; volajSaldo();"; ?>

                }

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


function Ulozit()
                {
    var okvstup=1;

    if ( document.formv1.h_dm.value == '' ) okvstup=0;
    if ( document.formv1.h_kc.value == '' ) okvstup=0;

    if ( okvstup == 1 )
    { 
    UlozMes(1,0,0);

    }

    if ( okvstup == 0 && document.formv1.h_dm.value == '' ) { document.formv1.h_dm.focus(); Fx.style.display="";}
    if ( okvstup == 0 && document.formv1.h_kc.value == '' ) { document.formv1.h_kc.focus(); Fx.style.display=""; }
    if ( okvstup == 0 && document.formv1.h_kc.value == '0' ) { document.formv1.h_kc.focus(); Fx.style.display=""; }
                }


function StrEnter(e)
           {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 )  {
        if ( document.formv1.h_str.value != '' && document.formv1.h_str.value != '0' ) 

              { myStrelement.style.display=''; volajStr(5,1); }

        if ( document.formv1.h_str.value == '0' )
        {         
        if ( document.formv1.h_dm.value == '' ) document.formv1.h_dm.value = '0';
        document.forms.formv1.h_dm.focus();
        document.forms.formv1.h_dm.select();
        }
                }
            }

//co urobi po potvrdeni ok z tabulky str
function vykonajStr(str,strtext)
                {
         ukazStr.innerHTML = "Stredisko: " + strtext;
         ukazStr.style.display='';
         document.forms.formv1.h_str.value = str;
         myStrelement.style.display='none';
         ZhasniSP();
         if ( document.formv1.h_dm.value == '' ) document.formv1.h_dm.value = '0';
         document.formv1.h_dm.focus();
         document.formv1.h_dm.select();
                }


function Len1Str(str)
              {
         document.forms.formv1.h_str.value = str;
         myStrelement.style.display='none';
         ZhasniSP();
         if ( document.formv1.h_dm.value == '' ) document.formv1.h_dm.value = '0';
         document.formv1.h_dm.focus();
         document.formv1.h_dm.select();
              }

function Len0Str()
                    {
         document.formv1.h_str.focus();
         document.formv1.h_str.select();
                    }

function ZakEnter(e)
           {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 )  {
        if ( document.formv1.h_zak.value != '' && document.formv1.h_zak.value != '0' ) 

              { myZakelement.style.display=''; volajZak(5,1); }

        if ( document.formv1.h_zak.value == '0' )
        {         
        if ( document.formv1.h_hh.value == '' ) document.formv1.h_hh.value = '0';
        if ( document.formv1.h_mn.value == '' ) document.formv1.h_mn.value = '0';
        if ( document.formv1.h_sa.value == '' ) document.formv1.h_sa.value = '0';
        document.forms.formv1.h_hh.focus();
        document.forms.formv1.h_hh.select();
        }
                }
            }


//co urobi po potvrdeni ok z tabulky zak
function vykonajZak(str,zak,zaktext)
                {
         ukazZak.innerHTML = "Z·kazka: " + zaktext;
         ukazZak.style.display='';
         document.forms.formv1.h_zak.value = zak;
         document.forms.formv1.h_str.value = str;
         myZakelement.style.display='none';
         ZhasniSP();
         if ( document.formv1.h_hh.value == '' ) document.formv1.h_hh.value = '0';
        if ( document.formv1.h_mn.value == '' ) document.formv1.h_mn.value = '0';
        if ( document.formv1.h_sa.value == '' ) document.formv1.h_sa.value = '0';
         document.formv1.h_hh.focus();
         document.formv1.h_hh.select();
                }


function Len1Zak(str,zak)
              {
         document.forms.formv1.h_zak.value = zak;
         document.forms.formv1.h_str.value = str;
         myZakelement.style.display='none';
         ZhasniSP();
         if ( document.formv1.h_hh.value == '' ) document.formv1.h_hh.value = '0';
         document.formv1.h_hh.focus();
         document.formv1.h_hh.select();
              }

function Len0Zak()
                    {
         document.formv1.h_zak.focus();
         document.formv1.h_zak.select();
                    }

function DmEnter(e)
           {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 )  {
        if ( document.formv1.h_dm.value != '' && document.formv1.h_dm.value != '0' ) 

              { myDmelement.style.display=''; volajDm(5,1); }

        if ( document.formv1.h_dm.value == '0' )
        {         
        if ( document.formv1.h_dn.value == '' ) document.formv1.h_dn.value = '0';
        document.forms.formv1.h_dn.focus();
        document.forms.formv1.h_dn.select();
        }
                }
            }

//co urobi po potvrdeni ok z tabulky dm
function vykonajDm(dm,dmtext,sa,ko,sax)
                {
         ukazDm.innerHTML = "DM: " + dmtext;
         ukazDm.style.display='';
         document.forms.formv1.h_dm.value = dm;
         document.forms.formv1.dm_sa.value = sa;
         document.forms.formv1.dm_ko.value = ko;
         document.forms.formv1.dm_sax.value = sax;
         if ( document.formv1.dm_ko.value == 20 )
            { var vypsa=document.formv1.dm_sa.value*document.formv1.znah.value/100; document.formv1.h_sa.value = vypsa.toFixed(4); }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 0 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz0.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 1 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz1.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 2 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz2.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 3 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz3.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 4 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz4.value/100; }
<?php if( $fir_mzdx08 != 0 AND $kli_vrok > 2017 AND $kli_nezis == 1 ) { ?>
         if ( document.formv1.h_dm.value == 202 && document.formv1.h_sa.value < 0.6898 ) { document.formv1.h_sa.value = 0.6898; }
         if ( document.formv1.h_dm.value == 203 && document.formv1.h_sa.value < 1.3795 ) { document.formv1.h_sa.value = 1.3795; }
         if ( document.formv1.h_dm.value == 204 && document.formv1.h_sa.value < document.formv1.znah.value ) { document.formv1.h_sa.value = document.formv1.znah.value; }
         if ( document.formv1.h_dm.value == 223 && document.formv1.h_sa.value < 0.8277 ) { document.formv1.h_sa.value = 0.8277; }
<?php                                                                 } ?>
         if ( document.formv1.dm_ko.value == 40 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value; }
         if ( document.formv1.dm_ko.value == 60 )
            { var vypsa=document.formv1.dm_sa.value*document.formv1.znem.value/100; document.formv1.h_sa.value = vypsa.toFixed(4); }
         if ( document.formv1.dm_ko.value == 100 ) { document.formv1.h_sa.value = 0; }
         if ( document.formv1.dm_ko.value == 0 ) { document.formv1.h_sa.value = 0; }
         myDmelement.style.display='none';
         ZhasniSP();
         if ( document.formv1.h_dn.value == '' ) document.formv1.h_dn.value = '0';
         document.formv1.h_dn.focus();
         document.formv1.h_dn.select();
                }


function Len1Dm(dm,sa,ko,sax)
              {
         document.forms.formv1.h_dm.value = dm;
         document.forms.formv1.dm_sa.value = sa;
         document.forms.formv1.dm_ko.value = ko;
         document.forms.formv1.dm_sax.value = sax;
         if ( document.formv1.dm_ko.value == 20 )
            { var vypsa=document.formv1.dm_sa.value*document.formv1.znah.value/100; document.formv1.h_sa.value = vypsa.toFixed(4); }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 0 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz0.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 1 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz1.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 2 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz2.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 3 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz3.value/100; }
         if ( document.formv1.dm_ko.value == 30 && document.formv1.dm_sax.value == 4 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value*document.formv1.sz4.value/100; }
<?php if( $fir_mzdx08 != 0 AND $kli_vrok > 2017 AND $kli_nezis == 1 ) { ?>
         if ( document.formv1.h_dm.value == 202 && document.formv1.h_sa.value < 0.6898 ) { document.formv1.h_sa.value = 0.6898; }
         if ( document.formv1.h_dm.value == 203 && document.formv1.h_sa.value < 1.3795 ) { document.formv1.h_sa.value = 1.3795; }
         if ( document.formv1.h_dm.value == 204 && document.formv1.h_sa.value < document.formv1.znah.value ) { document.formv1.h_sa.value = document.formv1.znah.value; }
         if ( document.formv1.h_dm.value == 223 && document.formv1.h_sa.value < 0.8277 ) { document.formv1.h_sa.value = 0.8277; }
<?php                                                                 } ?>
         if ( document.formv1.dm_ko.value == 40 ) { document.formv1.h_sa.value = document.formv1.dm_sa.value; }
         if ( document.formv1.dm_ko.value == 60 )
            { var vypsa=document.formv1.dm_sa.value*document.formv1.znem.value/100; document.formv1.h_sa.value = vypsa.toFixed(4); }
         if ( document.formv1.dm_ko.value == 100 ) { document.formv1.h_sa.value = 0; }
         if ( document.formv1.dm_ko.value == 0 ) { document.formv1.h_sa.value = 0; }
         myDmelement.style.display='none';
         ZhasniSP();
         if ( document.formv1.h_dn.value == '' ) document.formv1.h_dn.value = '0';
         document.formv1.h_dn.focus();
         document.formv1.h_dn.select();
              }

function Len0Dm()
                    {
         document.formv1.h_dm.focus();
         document.formv1.h_dm.select();
                    }

function Kontrola()
                    {
window.open('vyplat_paska.php?&copern=1&page=1&ostre=0&kontrola=1', '_self','<?php echo $tlcswin; ?>' )
                    }

function DavkaOc()
                    {
var cislo_oc=1*document.forms1.h_ico.value;

window.open('mesacnadavka_tlac.php?&copern=11&cislo_oc=' + cislo_oc + '&page=1','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                    }

<?php if( $tlacitkoenter == 1 ) {  ?>

    function ukaztlacitkoEnter()
    { 
    tlacitkoEnter.style.display='';
    }

    function zhasni_Enter()
    { 
    tlacitkoEnter.style.display='none';
    }

    function tlacitko_Enter()
    { 

    <?php if( $copern == 1 ) {  ?>
    document.forms.formv1.klikenter.value=1;
    if( document.forms.formv1.kdefoc.value == 'dok' && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; DokEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'dat' && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; DatEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'str' && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; StrEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'dm'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; DmEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'dp'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; DpEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'dk'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; DkEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'dn'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; DnEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'zak' && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; ZakEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'stj' && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; StjEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'hh'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; HhEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'sa'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; SaEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'mn'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; MnEnter(13); }
    if( document.forms.formv1.kdefoc.value == 'kc'  && document.forms.formv1.klikenter.value == 1  ) { document.forms.formv1.klikenter.value=0; KcEnter(13); }
    <?php                    }  ?>
    }


<?php                           }  ?> 

    <?php if( $copern == 1 ) {  ?>
    function onDok()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'dok';"; } ?>  }
    function onDat()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'dat';"; } ?>  }
    function onStr()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'str';"; } ?>  }
    function  onDm()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'dm';"; } ?>  }
    function  onDp()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'dp';"; } ?>  }
    function  onDk()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'dk';"; } ?>  }
    function  onDn()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'dn';"; } ?>  }
    function onZak()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'zak';"; } ?>  }
    function onStj()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'stj';"; } ?>  }
    function  onHh()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'hh';"; } ?>  }
    function  onSa()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'sa';"; } ?>  }
    function  onMn()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'mn';"; } ?>  }
    function  onKc()  { <?php if( $tlacitkoenter == 1 ) { echo "document.forms.formv1.kdefoc.value = 'kc';"; } ?>  }
    <?php                    }  ?>


function vlozDMN()
                    {

var cislo_ocx=1*document.forms1.h_ico.value;

window.open('vloz_dmn.php?copern=1&cislo_oc=' + cislo_ocx + '&xx=1', '_self' )
                    }


function zrazkyZoMzdy()
                {

var drupohx = 2;
var cislo_oc = 0;
cislo_oc=1*document.forms.forms1.h_ico.value;
if( cislo_oc > 0 ) { drupohx = 1; }

window.open('povinne_zrazky.php?copern=1&drupoh=' + drupohx + '&cislo_oc=' + cislo_oc + '&tt=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  </script>
<script type="text/javascript" src="vlozdmn_citaj.js"></script>
</HEAD>
<BODY class="white" id="white" onload="VyberVstup();
<?php if( $tlacitkoenter == 1 ) { echo " ukaztlacitkoEnter(); "; } ?>
" >


<?php
if (  $copern == 1 )
     {
//nastavenie parametrov 
?>
<div id="nastavfakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 300px; left: 10px; width:700px; height:100px;">
<table  class='ponuka' width='100%'>
<tr><td width='16%'></td><td width='16%'></td><td width='16%'></td><td width='16%'></td><td width='18%'></td><td width='18%'></td></tr>

<tr><td colspan='3'>Nastavenie proramovan˝ch poloûiek do mesaËnej d·vky</td>
<td colspan='3' align='right'><img border=0 src='../obr/zmazuplne.png' style="width:12; height:12;" onClick="nastavfakx.style.display='none';" title='Zhasni menu' ></td></tr>  
                    
<tr><FORM name='enast' method='post' action='#' ><td class='ponuka' colspan='5'>
<a href="#" onClick="ulozPol();"> Chcete uloûiù nastavenie programovan˝ch poloûiek ?</a>
<img border=0 src='../obr/ok.png' style="width:12; height:12;" onClick="ulozPol();" title="Uloûiù nastavenie programovan˝ch poloûiek." >

</td></tr>

<tr>
<td class='ponuka' colspan='1'><input type='checkbox' name='ajstravne' value='1' > StravnÈ lÌstky </td>
</tr>

<tr>
<td class='ponuka' colspan='1'>vsDN<input type='checkbox' name='vsdn' value='1' >
<img border=0 src='../obr/info.png' style="width:10; height:10;" title="Zamestn·vateæ platÌ stravn˝ lÌstok na vöetky pracovnÈ dni" >
</td>
<td class='ponuka' colspan='1'> minM<input type='checkbox' name='minm' value='1' >
<img border=0 src='../obr/info.png' style="width:10; height:10;" title="Zr·ûaù stravnÈ lÌstky za minul˝ mesiac, inak za mesiac, za ktor˝ nahr·vate v˝platu" >
</td>
<td class='ponuka' colspan='1'>Eur/ks<input type='text' name='eurl' id='eurl' size='5' maxlenght='5' value='' >
<img border=0 src='../obr/info.png' style="width:10; height:10;" title="Koæko zraziù Eur na jeden stravn˝ lÌstok = 45% z hodnoty lÌstka" >
</td>
<td class='ponuka' colspan='1'>ajSV<input type='checkbox' name='ajsv' value='1' >
<img border=0 src='../obr/info.png' style="width:10; height:10;" title="Zamestn·vateæ platÌ stravn˝ lÌstok aj na sviatky podæa kalend·ra ak s˙ to pondelok aû piatok, sobota a nedeæa sviatky neplatÌ, nie podæa nahratej dm 510" >
</td>
<td class='ponuka' colspan='1'>ajDV<input type='checkbox' name='ajdv' value='1' >
<img border=0 src='../obr/info.png' style="width:10; height:10;" title="Zamestn·vateæ platÌ stravn˝ lÌstok aj na dovolenku dm 506, 507" >
</td>
<td class='ponuka' colspan='1'>ajNH<input type='checkbox' name='ajnh' value='1' >
<img border=0 src='../obr/info.png' style="width:10; height:10;" title="Zamestn·vateæ platÌ stravn˝ lÌstok aj na n·hrady 518, 519 a 520" >
</td>
</tr>

<tr>
<td class='ponuka' colspan='6'><input type='checkbox' name='premie' value='1' > PrÈmie  
<img border=0 src='../obr/info.png' style="width:10; height:10;" title="VypoËÌta prÈmie na dm 304 z dm 101 aû 107 v mesaËnej d·vke, 
ak m· zamestnanec v ˙dajoch o zamestnancovi sz1 > 0, percento prÈmiÌ = sz3" >
</td>
</tr>


</FORM></table>
</div>

<script type="text/javascript">

//zapis nastavenie
function ulozPol()
                {

var ucm1 = 0;
var ajstravne = 0;
if( document.enast.ajstravne.checked ) { ajstravne=1; }
var premie = 0;
if( document.enast.premie.checked ) { premie=1; }
var eurl = document.enast.eurl.value;
var ajsv = 0;
if( document.enast.ajsv.checked ) { ajsv=1; }
var ajdv = 0;
if( document.enast.ajdv.checked ) { ajdv=1; }
var ajnh = 0;
if( document.enast.ajnh.checked ) { ajnh=1; }
var minm = 0;
if( document.enast.minm.checked ) { minm=1; }
var vsdn = 0;
if( document.enast.vsdn.checked ) { vsdn=1; }

window.open('vlozdmn_setuloz.php?cislo_oc=<?php echo $cislo_oc; ?>&vsdn=' + vsdn + '&minm=' + minm + '&ajstravne=' + ajstravne + '&premie=' + premie + '&eurl=' + eurl +  '&ajsv=' + ajsv +  '&ajdv=' + ajdv +  '&ajnh=' + ajnh + '&copern=900', '_self' );
                }


function UpravDochOC()
                {

var cislo_oc = 0;
var drupoh = 2;
cislo_oc=1*document.forms.forms1.h_ico.value;

if( cislo_oc != 0 ) 
  { 
window.open('../mzdy/dochadzka_detail.php?cislo_oc=' + cislo_oc + '&copern=20&drupoh=2&page=1&subor=0', '_self' );
  }
else
  {
window.open('../mzdy/dochadzka.php?cislo_oc=&copern=1&drupoh=1&page=1&subor=0', '_self' );
  }

                }

</script>
<?php
     }
?>


<table class="h2" width="100%" >
<tr>
<?php
if( $drupoh == 1 )
{
$drptxt="EkonomickÈ oper·cie";
?>
<td>EuroSecom  -  MesaËn· mzda
 <a href="#" onClick="window.open('mesacnadavka_tlac.php?&copern=1&page=1','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')">
<img src='../obr/tlac.png' width=15 height=15 border=0 title='TlaË mesaËnej d·vky za <?php echo $kli_vume; ?> podæa zamestnancov ' ></a>
 <a href="#" onClick="window.open('mesacnadavka_tlac.php?&copern=11&page=1','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')">
<img src='../obr/tlac.png' width=15 height=15 border=0 title='TlaË mesaËnej d·vky za <?php echo $kli_vume; ?> podæa zloûiek mzdy ' ></a>

<img src='../obr/tlac.png' onclick='DavkaOc();' width=15 height=15 border=0 title='TlaË mesaËnej d·vky za <?php echo $kli_vume; ?> pre vybranÈho zamestnanca podæa zloûiek mzdy ' ></a>
<?php
}
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if( $copern == 1 )
          {

//echo $cislo_oc;
?>

<table class="fmenu" width="100%" >
<tr>
<td class="hmenu" width="10%">Pomer
<td class="hmenu" width="20%" align="right"><div id="cislo">Os.ËÌslo</div>
<td class="hmenu" width="30%"><div id="nazov">Meno/Priezvisko</div>
<td class="hmenu" width="10%" align="right"></td>
<td class="hmenu" width="10%" align="right"></td>
<td class="hmenu" width="20%" align="right">
</td>
</tr>
<FORM name="forms1" class="obyc" method="post" action="#" >
<tr>
<td class="hmenu">
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm >= 0 ORDER BY pm");
?>
<select size="1" name="h_uce" id="h_uce" >
<option value="999" >Vöetky pomery</option>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["pm"];?>" >
<?php 
$polmen = $zaznam["nzpm"];
$poltxt = SubStr($polmen,0,20);
?>
<?php echo $zaznam["pm"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
<td class="hmenu" align="right">

<?php
$prev_oc=$vyb_osc-1; 
$next_oc=$vyb_osc+1;
$pomx=1; $stzx=1;
$sqlico = mysql_query("SELECT oc,pom,stz FROM F$kli_vxcf"."_mzdkun WHERE oc=$vyb_osc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $pomx=1*$riadico->pom;
  $stzx=1*$riadico->stz;
  }

//echo $pomx." ".$stzx;
$podmstz="";
if( $fir_mzdx07 == 1 ) { $podmstz=" AND pom != 9 AND stz = $stzx "; }

if( $prev_oc <= 0 ) $prev_oc=1;
if( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc,pom,stz FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc $podmstz ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT oc,pom,stz FROM F$kli_vxcf"."_mzdkun WHERE oc >= 0 $podmstz ORDER BY oc DESC LIMIT 1"); 
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }

if( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc,pom,stz FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc $podmstz");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $next_oc=$next_oc+1;
if( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;

if( $prev_oc <= 0 ) $prev_oc=$vyb_osc;
if( $next_oc > 9999 ) $next_oc=9999;

$stylebackcolor="";
if( $pomx == 9 ) { $stylebackcolor="STYLE='background-color: lightgray;'"; }
?>

<a href="#" onClick="window.open('mes_mzdy.php?copern=1&drupoh=1&page=1&nexto=1&vyb_osc=<?php echo $prev_oc; ?>&cislo_os=<?php echo $prev_oc; ?>', '_self' )">
<img src='../obr/prev.png' style='width:15; height:15;' border=0 title='PredoölÈ osË  <?php echo $prev_oc; ?>' ></a>
<a href="#" onClick="window.open('mes_mzdy.php?copern=1&drupoh=1&page=1&prevo=1&vyb_osc=<?php echo $next_oc; ?>&cislo_os=<?php echo $next_oc; ?>', '_self' )">
<img src='../obr/next.png' style='width:15; height:15;' border=0 title='œalöie osË <?php echo $next_oc; ?>' ></a>

<input type="hidden" name="nextosc" id="nextosc" value="<?php echo $next_oc;?>" />
<input type="hidden" name="prevosc" id="prevosc" value="<?php echo $prev_oc;?>" />
<input type="hidden" name="icoenter" id="icoenter" value="0" />

<input type="text" name="h_ico" id="h_ico" size="10" <?php echo $stylebackcolor; ?> 
onclick="NoveHladanie(); "
 onKeyDown="return IcoEnter(event.which)"/>

<td class="hmenu"><input type="text" name="h_nai" id="h_nai" size="40" <?php echo $stylebackcolor; ?> value="<?php echo $h_nai;?>" 
onclick="NoveHladanie(); "
 onKeyDown="return NaiEnter(event.which)" /> 

<img border=1 src='../obr/hladaj.png' style='width:15; height:10;' onclick="mySaldoelement.style.display='none'; New.style.display='none'; volajSaldo();" title='Hæadaj zadanÈ ËÌslo alebo meno zamestnanca ' >
</td>

<td class="obyc" align="right">
<INPUT type="reset" 
 onclick="window.open('mes_mzdy.php?copern=1&drupoh=1&page=1&novehladanie=1&cislo_oc=0&h_oc=0&vyb_osc=0', '_self' )"
 id="resetp" name="resetp" value="NovÈ hæadanie" ></td>


<td class="obyc" align="right" >
<a href="#" onClick="window.open('vyplat_paska.php?&copern=101&page=1&ostre=0','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')">
<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 title='V˝platn· p·ska zamestnanca' ></a>
</td>

<td class="obyc" align="right">
<a href="#" onClick="window.open('zamestnanci.php?&copern=108&page=1','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')">
<img src='../obr/uprav.png' width=15 height=15 border=0 title='⁄prava ˙dajov o zamestnancovi' ></a>

<a href="#" onClick="window.open('../mzdy/trvale.php?copern=101&drupoh=1&page=1&zkun=1','_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='⁄prava trval˝ch poloûiek zamestnanca' ></a>
</td>


</FORM>
</table>
<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som zamestnanca podæa zadan˝ch podmienok, sk˙ste znovu</span>
<div id="mySaldoelement"></div>
<div id="Okno"></div>

<?php
$fmenu="fmenz";
$pvstup="pvstuz";
$hvstup="hvstuz";
?>
<table class="<?php echo $fmenu; ?>" width="100%" >
<tr>
<td class="<?php echo $pvstup ?>" width="10%">Dok-D·tum
<td class="<?php echo $pvstup ?>" width="10%">STR
<td class="<?php echo $pvstup ?>" width="15%">DM
<td class="<?php echo $pvstup ?>" width="10%">D·tum od-do
<td class="<?php echo $pvstup ?>" width="10%" align="right">Dni
<td class="<?php echo $pvstup ?>" width="10%" align="right">Stroj-Z¡K
<td class="<?php echo $pvstup ?>" width="10%" align="right">Hodiny
<td class="<?php echo $pvstup ?>" width="10%" align="right">Mn-Sadzba
<td class="<?php echo $pvstup ?>" width="10%" align="right">Hodnota <?php echo $mena1;?>
<td class="<?php echo $pvstup ?>" width="5%">Zmaû
</tr>

</table>

<div id="divNahrate"></div>
<div id="divIns"></div>
<div id="divDel"></div>

<div id="myDmelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myStrelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myZakelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>
<div id="myStjelement" style="cursor: hand; position: absolute; z-index: 200; top: 150; left: 20;"></div>

<span id="Dm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo DM musÌ byù celÈ kladnÈ ËÌslo v rozsahu 0 aû 9999</span>
<span id="Des" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 99999999 max. 2 desatinnÈ miesta</span>
<span id="Dni" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.01 aû 31 max. 2 desatinnÈ miesta</span>
<span id="Des4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo v rozsahu 0.0001 aû 99999999 max. 4 desatinnÈ miesta</span>
<span id="Str" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo strediska musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Stj" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo stroja musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 999999</span>
<span id="Zak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 »Ìslo z·kazky musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 99999999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte spr·vne vyplniù vöetky poloûky vstupu</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>

<span id="NiejeDm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som DM v ËÌselnÌku </span>
<span id="NiejeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som stredisko v ËÌselnÌku </span>
<span id="NiejeStj" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som stroj v ËÌselnÌku </span>
<span id="NiejeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Nenaöiel som z·kazku v ËÌselnÌku </span>

<table class="<?php echo $fmenu; ?>" width="100%" >

<FORM name="formv1" class="obyc" method="post" action="#" >

<tr>
<td class="fmenu" width="10%">
<input type="text" name="h_dok" id="h_dok" size="10" maxlenght="10"
 onchange="return intg(this,0,999999,Dok,document.formv1.err_dok)"
 onclick="ZhasniSP(); " onfocus="onDok();"
 onkeyup="KontrolaCisla(this, Dok)" onKeyDown="return DokEnter(event.which)"/>
<INPUT type="hidden" name="err_dok" value="0"></td>

<td class="fmenu" width="10%"></td>
<td class="fmenu" width="15%"></td>

<td class="fmenu" width="10%">
<input class="fmenu" type="text" name="h_dp" id="h_dp" size="10" maxlength="10" 
 onclick="ZhasniSP()" onkeyup="KontrolaDatum(this, Datum)" onfocus="onDp();"  
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dp)" onKeyDown="return DpEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dp" value="0"></td>

<td class="fmenu" width="10%"></td>

<td class="fmenu" width="10%">
<a href="#" onClick="myStjelement.style.display=''; volajStj(2);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù stroj" ></a>
<input type="text" name="h_stj" id="h_stj" size="7" 
 onclick="ZhasniSP();" onfocus="onStj();"
 onchange="return intg(this,0,999999,Stj,document.formv1.err_stj)"
 onkeyup="KontrolaCisla(this, Stj)" onKeyDown="return StjEnter(event.which)"/>
<INPUT type="hidden" name="err_stj" value="0"></td>

<td class="fmenu" width="10%"></td>

<td class="fmenu" align="right" width="10%"><input type="text" name="h_mn" id="h_mn" size="8" 
 onclick="ZhasniSP();" onfocus="onMn();"
 onchange="return cele(this,0,99999999,Des4,4,document.formv1.err_mn)" 
 onkeyup="KontrolaDcisla(this, Des4)" onKeyDown="return MnEnter(event.which)" />
<INPUT type="hidden" name="err_mn" >
</td>

<td  width="10%" align="right" >
<img border=0 src='../obr/vlozit.png' onclick='vlozDMN();' style='width:12; height:12;' title='Vloûiù do mesaËnej d·vky naprogramovanÈ zloûky mzdy' >
</td>

<td  width="10%" align="right" >
<img border=0 src='../obr/naradie.png' onclick="nastavfakx.style.display=''; nacitajSet(<?php echo $cislo_oc;?>);" style='width:12; height:12;' title='Nastaviù programovanÈ zloûky mzdy do mesaËnej d·vky' >
</td>

</tr>

<tr>
<td class="fmenu" width="10%">
<input class="fmenu" type="text" name="h_dat" id="h_dat" size="10" maxlength="10" 
 onclick="ZhasniSP()" onkeyup="KontrolaDatum(this, Datum)" onfocus="onDat();"  
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dat)" onKeyDown="return DatEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dat" value="0"></td>

<td class="fmenu" width="10%">
<a href="#" onClick="myStrelement.style.display=''; volajStr(5,0);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù stredisko" ></a>
<input type="text" name="h_str" id="h_str" size="7" 
 onclick="ZhasniSP();" onfocus="onStr();"
 onchange="return intg(this,0,9999,Str,document.formv1.err_str)"
 onkeyup="KontrolaCisla(this, Str)" onKeyDown="return StrEnter(event.which)"/>
<INPUT type="hidden" name="err_str" value="0"></td>


<td class="fmenu" width="15%">
<a href="#" onClick="myDmelement.style.display=''; volajDm(5,0);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù DM" ></a>
<input type="text" name="h_dm" id="h_dm" size="12" 
 onclick="ZhasniSP(); " onKeyDown="return DmEnter(event.which)" onfocus="onDm();"/>
</td>


<td class="fmenu" width="10%">
<input class="fmenu" type="text" name="h_dk" id="h_dk" size="10" maxlength="10" 
 onclick="ZhasniSP()" onkeyup="KontrolaDatum(this, Datum)" onfocus="onDk();" 
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dk)" onKeyDown="return DkEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dk" value="0"></td>

<td class="fmenu" align="right" width="10%"><input type="text" name="h_dn" id="h_dn" size="5" 
 onclick="ZhasniSP();" onfocus="onDn(); DnFocus();" 
 onchange="return cele(this,0,31,Dni,2,document.formv1.err_dn)" 
 onkeyup="KontrolaDcisla(this, Dni)" onKeyDown="return DnEnter(event.which)" />
<INPUT type="hidden" name="err_dn" >

<td class="fmenu" width="10%">
<a href="#" onClick="myZakelement.style.display=''; volajZak(5,0);">
<img src='../obr/hladaj.png' width=12 height=12 border=0 title="Hæadaù zakazku" ></a>
<input type="text" name="h_zak" id="h_zak" size="7" 
 onclick="ZhasniSP();" onfocus="onZak();"
 onchange="return intg(this,0,99999999,Zak,document.formv1.err_zak)"
 onkeyup="KontrolaCisla(this, Zak)" onKeyDown="return ZakEnter(event.which)"/>
<INPUT type="hidden" name="err_zak" value="0"></td>

<td class="fmenu" align="right" width="10%"><input type="text" name="h_hh" id="h_hh" size="8" 
 onclick="ZhasniSP();" onfocus="onHh();"
 onchange="return cele(this,-999,99999999,Des,2,document.formv1.err_hh)" 
 onkeyup="KontrolaDcisla(this, Des)" onKeyDown="return HhEnter(event.which)" />
<INPUT type="hidden" name="err_hh" >

<td class="fmenu" align="right" width="10%"><input type="text" name="h_sa" id="h_sa" size="8" 
 onclick="ZhasniSP();" onfocus="onSa();"
 onchange="return cele(this,0,99999999,Des4,4,document.formv1.err_sa)" 
 onkeyup="KontrolaDcisla(this, Des4)" onKeyDown="return SaEnter(event.which)" />
<INPUT type="hidden" name="err_sa" >


<td class="fmenu" align="right" width="10%"><input type="text" name="h_kc" id="h_kc" size="10" 
 onclick="ZhasniSP();" onfocus="onKc();"
 onchange="return cele(this,-99999999,99999999,Des,2,document.formv1.err_kc)" 
 onkeyup="KontrolaDcisla(this, Des)" onKeyDown="return KcEnter(event.which)" />
<INPUT type="hidden" name="err_kc" >


<td class="fmenu" width="5%"><input type="text" name="h_ne1" id="h_ne1" size="3" /></td>
<input type="hidden" name="h_oc" id="h_oc"  />
<input type="hidden" name="pocpol" id="pocpol" value="<?php echo $pocpol; ?>"  />

<input type="hidden" name="stz" id="stz"  />
<input type="hidden" name="zkz" id="zkz"  />
<input type="hidden" name="znah" id="znah"  />
<input type="hidden" name="znem" id="znem"  />
<input type="hidden" name="uva" id="uva"  />
<input type="hidden" name="sz0" id="sz0"  />
<input type="hidden" name="sz1" id="sz1"  />
<input type="hidden" name="sz2" id="sz2"  />
<input type="hidden" name="sz3" id="sz3"  />
<input type="hidden" name="sz4" id="sz4"  />
<input type="hidden" name="dm_sa" id="dm_sa"  />
<input type="hidden" name="dm_ko" id="dm_ko"  />
<input type="hidden" name="dm_sax" id="dm_sax"  />

<input class="hvstup" type="hidden" name="kdefoc" id="kdefoc" value="dm" />
<input class="hvstup" type="hidden" name="klikenter" id="klikenter" value="0" />

</tr>
</table>
<div id="jeDm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeStr" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeZak" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>
<div id="jeStj" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:#e2e2e2; color:black;"></div>


    <table class="vstup" width="100%">
     <tr> 
<?php if( $_SESSION['nieie'] == 0 )  { ?>
       <td colspan="1" align="left">
<button id="uloz" onclick="Ulozit(); ">Uloûiù</button>

       </td>

       <td colspan="7" align="left">

       <td colspan="2" align="right">
<button id="uloz" onclick="Kontrola(); ">Kontrolovaù</button>
       </td>
<?php                                } ?>
<?php if( $_SESSION['nieie'] == 1 )  { ?>

       <td colspan="1" align="left">
<a href="#" onClick="Ulozit();"><img border=0 src='../obr/tlacitka/ulozit.jpg' style='width:65; height:22;' title='Uloûiù ' ></a>
       </td>

       <td colspan="2" align="left">
<a href="#" onClick="zrazkyZoMzdy();">
<img src='../obr/import.png' width=15 height=15 border=0 title='Nastavenie zr·ûok zo mzdy pri v˝kone rozhodnutia' >Zr·ûky zo mzdy</a>
&nbsp&nbsp&nbsp
<a href="#" onClick="UpravDochOC();">
<img src='../obr/hodiny.jpg' width=15 height=15 border=0 title='Doch·dzka zamestnanca' >Doch·dzka</a>


       <td colspan="5" align="left">

<?php if( $tlacitkoenter == 1 ) {  ?>

<div id="tlacitkoEnter" style="cursor: hand; display: none; width:80; height:25;">
<img border=0 src='../obr/tlacitka/enter.jpg' style='width:50; height:20;' onClick="tlacitko_Enter();"
 title='tlaËÌtko Enter' >
</div>

<?php                           }  ?>

       <td colspan="2" align="right">
<a href="#" onClick="Kontrola();"><img border=0 src='../obr/tlacitka/kontrolovat.jpg' style='width:65; height:22;' title='Kontrolovaù ' ></a>
       </td>

<?php                                } ?>

<div id="celkom" >
</div>

       </td>
      </tr> 
    </table> 

<?php
          }
//koniec copern=1
?>



<?php


// celkovy koniec dokumentu
$cislista = include("mzd_lista.php");
       } while (false);
?>
</BODY>
</HTML>
