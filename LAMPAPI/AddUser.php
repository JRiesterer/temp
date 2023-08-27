<?php

	$inData = getRequestInfo();

	$fname = $inData["fname"];
    $lname = $inData["lname"];
    $login = $inData["login"];
    $password = $inData["password"];

	$conn = new mysqli("localhost", "access", "sqlsqlsql2", "db1");

	if ( $conn->connect_error ) {
		returnWithError($conn->connect_error);
	}

	else {
        $stmt = $conn->prepare("INSERT into Users (fname, lname, login, password) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $fname, $lname, $login, $password);
        $stmt->execute();

        returnWithoutError();

        $stmt->close();
        $conn->close();
	}

	function getRequestInfo() {
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson($obj) {
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError($err) {
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}

	function returnWithInfo( $searchResults ) {
		$retValue = '{"error":""}';
		sendResultInfoAsJson($retValue);
	}
?>