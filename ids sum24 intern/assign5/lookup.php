<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

// Handle GET request to fetch records
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM lookup";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $num = $stmt->rowCount();

    if ($num > 0) {
        $data = array();
        $data["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $item = array(
                "code_" => $code_,
                "order_number" => $order_number,
            );
            array_push($data["records"], $item);
        }

        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No records found."));
    }
    exit;
}


// Handle POST request to create a new record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    $query = "INSERT INTO lookup (order_number) VALUES (:order_number)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':order_number', $input['order_number']);
    
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "Record created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create record."));
    }
    exit;
}

?>