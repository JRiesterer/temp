<?php
    $inData = getRequestInfo();

    $fname = $inData["fname"];
    $lname = $inData["lname"];
    $UserID = $inData["UserID"];

    $conn = new mysqli("localhost", "access", "sqlsqlsql2", "db1");

    if( $conn->connect_error ) {
        returnWithError($conn->connect_error);
    }

    else {
        $stmt = $conn->prepare("DELETE FROM Contacts WHERE fname = ? AND lname = ? AND UserID = ?");
        $stmt->bind_param("ssi", $fname, $lname, $UserID);
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