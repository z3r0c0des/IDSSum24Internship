<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include_once 'db.php';

$database = new Database();
$db = $database->getConnection();
//events
// Handle GET request to fetch records
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM evvent";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $num = $stmt->rowCount();

    if ($num > 0) {
        $data = array();
        $data["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = array(
                "status_" => $row['status_'],
                "description_" => $row['description_'],
                "category" => $row['category'],
                "destination" => $row['destination'],
                "date_from" => $row['date_from'],
                "date_to" => $row['date_to'],
                "budget" => $row['budget'],
                "guides" => $row['guides'],
                "members" => $row['members'],
                "name_" => $row['name_'],
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

    $query = "INSERT INTO evvent (status_, description_, category, destination, date_from, date_to, budget, guides, members, name_) VALUES (:status_, :description_, :category, :destination, :date_from, :date_to, :budget, :guides, :members, :name_)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':status_', $input['status_']);
    $stmt->bindParam(':description_', $input['description_']);
    $stmt->bindParam(':category', $input['category']);
    $stmt->bindParam(':destination', $input['destination']);
    $stmt->bindParam(':date_from', $input['date_from']);
    $stmt->bindParam(':date_to', $input['date_to']);
    $stmt->bindParam(':budget', $input['budget']);
    $stmt->bindParam(':guides', $input['guides']);
    $stmt->bindParam(':members', $input['members']);
    $stmt->bindParam(':name_', $input['name_']);

    try {
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array("message" => "Record created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create record."));
        }
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(array("message" => $e->getMessage()));
    }
    exit;
}

// Handle PUT request to update a record
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    $query = "UPDATE evvent SET status_ = :status_, description_ = :description_, category = :category, destination = :destination, date_from = :date_from, date_to = :date_to, budget = :budget, guides = :guides, members = :members WHERE name_ = :name_";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':status_', $input['status_']);
    $stmt->bindParam(':description_', $input['description_']);
    $stmt->bindParam(':category', $input['category']);
    $stmt->bindParam(':destination', $input['destination']);
    $stmt->bindParam(':date_from', $input['date_from']);
    $stmt->bindParam(':date_to', $input['date_to']);
    $stmt->bindParam(':budget', $input['budget']);
    $stmt->bindParam(':guides', $input['guides']);
    $stmt->bindParam(':members', $input['members']);
    $stmt->bindParam(':name_', $input['name_']);

    try {
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "Record updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update record."));
        }
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(array("message" => $e->getMessage()));
    }
    exit;
}

// Handle DELETE request to delete a record
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);

    $query = "DELETE FROM evvent WHERE name_ = :name_";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':name_', $input['name_']);

    try {
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array("message" => "Record deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete record."));
        }
    } catch (PDOException $e) {
        http_response_code(400);
        echo json_encode(array("message" => $e->getMessage()));
    }
    exit;
}
?>
