<?php

	$inData = getRequestInfo();
	
	$id = 0;
	$fname = "";
	$lname = "";

	$conn = new mysqli("localhost", "access", "sqlsqlsql2", "db1");

	if( $conn->connect_error ) {
		returnWithError($conn->connect_error);
	}

	else {
		$stmt = $conn->prepare("SELECT ID, fname, lname FROM Users WHERE login = BINARY ? AND password = BINARY ?");
		$stmt->bind_param("ss", $inData["login"], $inData["password"]);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()) {
			returnWithInfo($row['fname'], $row['lname'], $row['ID']);
		}

		else{
			returnWithError("No Records Found");
		}

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
		$retValue = '{"id": 0, "error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}
	
	function returnWithInfo($fname, $lname, $id) {
		$retValue = '{"id":' . $id . ',"fname":"' . $fname . '","lname":"' . $lname . '","error":""}';
		sendResultInfoAsJson($retValue);
	}
	
?>
