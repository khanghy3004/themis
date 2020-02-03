<?php
include_once "dulieu/header.php";
//start: fix  Undefined index
if (!isset($_GET["CBHT"])) {
    $_GET["CBHT"] = '';
}
//end: fix  Undefined index
?>
<?php
if(isset($_POST['datetime1']) && isset($_POST['datetime2']) && isset($_POST['cname']) && isset($_POST['maxpoint'])){
	$date = substr($_POST['datetime1'], 0, 10);
	$time = substr($_POST['datetime1'], 11);
	$datetime1 = $date." ".$time;
	$date = substr($_POST['datetime2'], 0, 10);
	$time = substr($_POST['datetime2'], 11);
	$datetime2 = $date." ".$time;

	$sql = "UPDATE thoigian SET timebegin='".$datetime1."', timeend='".$datetime2."', name='".$_POST['cname']."', maxpoint='".$_POST['maxpoint']."' WHERE id=1";
	echo $sql;
	if ($conn->query($sql) === TRUE) {
	    echo "Record updated successfully";
	} else {
	    echo "Error updating record: " . $conn->error;
	}

	$conn->close();
}
?>
<div class="container">
	<h4>Update Name and Time...</h4>
	<form action="" method="post">
		<p>Name Contest <input class='form-control' type="text" id="cname" name="cname"></p>
		<p>Max point <input class='form-control' type="text" id="maxpoint" name="maxpoint"></p>
		<p>Start <input class='form-control' type="datetime-local" id="datetime1" name="datetime1"></p>
		<p>End <input class='form-control' type="datetime-local" id="datetime2" name="datetime2"></p>
	  	<input class='btn btn-info' type="submit" value="Submit">
	</form>
</div>
