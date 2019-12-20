<?PHP
$ajwebstranka=0;
if( $_SERVER['SERVER_NAME'] == "www.dssbrodske.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.penzionskalica.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.edcom.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.zszzsmrdaky.sk" ) { $ajwebstranka=1; }
if( $_SERVER['SERVER_NAME'] == "www.szsgbely.sk" ) { $ajwebstranka=1; }

if( $ajwebstranka == 0 )
 {
?>
<script type="text/javascript">
    window.open('../hses.php', '_self' );
</script>
<?php
 }
if( $ajwebstranka == 1 )
 {
?>
<script type="text/javascript">
    window.open('index.html', '_self' );
</script>
<?php
 }
?>


