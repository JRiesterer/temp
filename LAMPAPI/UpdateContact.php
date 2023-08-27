<?php

	$inData = getRequestInfo();

	$phone = $inData["phone"];
	$email = $inData["email"];
	$fname = $inData["fname"];
	$lname = $inData["lname"];
	$ID = $inData["ID "];

	$conn = new mysqli("localhost", "TheBeast", "WeLoveCOP4331", "COP4331");

    if ( $conn->connect_error ) {
        returnWithError($conn->connect_error);
    }

    else {
        $stmt = $conn->prepare("UPDATE Contacts SET fname = ?, lname = ?, phone = ?, email = ? WHERE ID = ?");
        $stmt->bind_param("ssssi", $fname, $lname, $phone, $email, $ID);
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
		$retValue = '{""error":"' . $err . '"}';
		sendResultInfoAsJson($retValue);
	}

    function returnWithoutError() {
        $retValue = '{"error":""}';
		sendResultInfoAsJson($retValue);
    }
?>