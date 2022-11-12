<?php
if (isset($msg)) {
	for ($i=0; $i < count($msg); $i++) { 
		$cadena = substr($msg[$i],0,1);
		print "<div class='alert ";
		if($cadena=="0") print "alert-success' ";
		if($cadena=="1") print "alert-danger' ";
		if($cadena=="2") print "alert-warning' ";
		//if($cadena=="3") print "' style='display: none;' ";

		print ">";
		print substr($msg[$i],1);
		print "</div>";
	}
}
?>

<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    setTimeout(function() {
        $(".alert").fadeOut(1500);
    },3000);
});
</script>