<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'db.php';

$database = new Database();
$db = $database->getConnection();

// Handle GET request to fetch records
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $query = "SELECT * FROM members";
    $stmt = $db->prepare($query);
    $stmt->execute();

    $num = $stmt->rowCount();

    if ($num > 0) {
        $data = array();
        $data["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $item = array(
                "number_" => $number_,
                "emergency_number" => $emergency_number,
                "photo" => $photo,
                "profession" => $profession,
                "nationality" => $nationality,
                "events_joined" => $events_joined,
                "name_" => $name_,
                "password_" => $password_,
                "date_of_birth" => $date_of_birth,
                "gender" => $gender,
                "join_date" => $join_date,
                "email" => $email,
                "role_" => $role_,
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

    $query = "INSERT INTO members (number_, emergency_number, photo, profession, nationality, events_joined, name_, password_, date_of_birth, gender, join_date, email, role_) VALUES (:number_, :emergency_number, :photo, :profession, :nationality, :events_joined, :name_, :password_, :date_of_birth, :gender, :join_date, :email, :role_)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':number_', $input['number_']);
    $stmt->bindParam(':emergency_number', $input['emergency_number']);
    $stmt->bindParam(':photo', $input['photo']);
    $stmt->bindParam(':profession', $input['profession']);
    $stmt->bindParam(':nationality', $input['nationality']);
    $stmt->bindParam(':events_joined', $input['events_joined']);
    $stmt->bindParam(':name_', $input['name_']);
    $stmt->bindParam(':password_', $input['password_']);
    $stmt->bindParam(':date_of_birth', $input['date_of_birth']);
    $stmt->bindParam(':gender', $input['gender']);
    $stmt->bindParam(':join_date', $input['join_date']);
    $stmt->bindParam(':email', $input['email']);
    $stmt->bindParam(':role_', $input['role_']);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "Record created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create record."));
    }
    exit;
}

// Handle PUT request to update a record
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $input = json_decode(file_get_contents('php://input'), true);

    $query = "UPDATE members SET emergency_number = :emergency_number, photo = :photo, profession = :profession, nationality = :nationality, events_joined = :events_joined, name_ = :name_, password_ = :password_, date_of_birth = :date_of_birth, gender = :gender, join_date = :join_date, email = :email, role_ = :role_ WHERE number_ = :number_";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':number_', $input['number_']);
    $stmt->bindParam(':emergency_number', $input['emergency_number']);
    $stmt->bindParam(':photo', $input['photo']);
    $stmt->bindParam(':profession', $input['profession']);
    $stmt->bindParam(':nationality', $input['nationality']);
    $stmt->bindParam(':events_joined', $input['events_joined']);
    $stmt->bindParam(':name_', $input['name_']);
    $stmt->bindParam(':password_', $input['password_']);
    $stmt->bindParam(':date_of_birth', $input['date_of_birth']);
    $stmt->bindParam(':gender', $input['gender']);
    $stmt->bindParam(':join_date', $input['join_date']);
    $stmt->bindParam(':email', $input['email']);
    $stmt->bindParam(':role_', $input['role_']);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Record updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update record."));
    }
    exit;
}

// Handle DELETE request to delete a record
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);

    $query = "DELETE FROM members WHERE number_ = :number_";
    $stmt = $db->prepare($query);

    $stmt->bindParam(':number_', $input['number_']);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Record deleted."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete record."));
    }
    exit;
}
?>
