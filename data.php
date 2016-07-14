<?php 
	/*DB Connection*/
	$mysqli = new mysqli("mysql51-058.wc1.ord1.stabletransit.com", "871197_sursur", "D4.#2014.sur", "871197_sursur", 3306);
	
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	if (!$mysqli->set_charset("utf8")) {
	    printf("Error loading character set utf8: %s\n", $mysqli->error);
	}

	$res = $mysqli->query("SELECT * FROM Destino_Origen");
	$rows = array();
	while ($row = $res->fetch_assoc()) {
    	$rows[]=$row;
	}
	$json = json_encode($rows);
?>
