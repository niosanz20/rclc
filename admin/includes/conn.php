<?php
	$conn = new mysqli('sql6.freemysqlhosting.net', 'sql6424317', 'TLUGj5A7ZZ', 'sql6424317');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
