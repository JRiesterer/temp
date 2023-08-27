<?php
	$inData = getRequestInfo();
	
	$fname = $inData["fname"];
    $lname = $inData["lname"];
    $phone = $inData["phone"];
    $email = $inData["email"];
    $UserID = $inData["UserID"];

	$conn = new mysqli("localhost", "access", "sqlsqlsql2", "db1");

	if ( $conn->connect_error ) {
		returnWithError($conn->connect_error);
	}

    else {
        $stmt = $conn->prepare("INSERT into Contacts (fname, lname, phone, email, UserID) VALUES (?,?,?,?,?)");
        $stmt->bind_param("ssssi", $fname, $lname, $phone, $email, $UserID);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        returnWithoutError();
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

    function returnWithoutError() {
        $retValue = '{"error":""}';
		sendResultInfoAsJson($retValue);
    }
?>