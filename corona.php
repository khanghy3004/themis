<?php
include_once "dulieu/header.php";
//start: fix  Undefined index
if (!isset($_GET["CBHT"])) {
    $_GET["CBHT"] = '';
}
//end: fix  Undefined index
?>
<style type="text/css">
	.h_iframe iframe {position:absolute;top:1;left:0;width:100%; height:100%;}
</style>

<div class="h_iframe">
    <iframe  src="https://corona.kompa.ai/?fbclid=IwAR1URPy94V03XwUuEgFtbskfoocUKor3y7gG66F9EEWtnRLrr4bVsPkkcPU" frameborder="0" allowfullscreen></iframe>
</div>