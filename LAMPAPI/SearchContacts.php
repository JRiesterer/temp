<?php

	$inData = getRequestInfo();

	$searchResults = "";
	$searchCount = 0;

	$conn = new mysqli("localhost", "access", "sqlsqlsql2", "db1");

	if ($conn->connect_error) {
		returnWithError( $conn->connect_error );
	}

	else {
		$stmt = $conn->prepare("SELECT * FROM Contacts WHERE (fname like ? OR lname like ?) AND UserID = ?");
		$searchVal = "%" . $inData["searchVal"] . "%";
		$stmt->bind_param("sss", $searchVal, $searchVal, $inData["UserID"]);
		$stmt->execute();
		$result = $stmt->get_result();

		while( $row = $result->fetch_assoc() ) {

			if( $searchCount > 0 ) {
				$searchResults .= ",";
			}

			$searchCount++;
			$searchResults .= '{"fname" : "' . $row["fname"]. '", "lname" : "' . $row["lname"]. '", "phone" : "' . $row["phone"]. '", "email" : "' . $row["email"]. '", "UserID" : "' . $row["UserID"].'", "ID" : "' . $row["ID"]. '"}';
		}

		if( $searchCount == 0 )	{
			returnWithError("No Records Found");
		}

		else {
			returnWithInfo($searchResults);
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
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}

	function returnWithInfo($searchResults) {
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson($retValue);
	}
?>