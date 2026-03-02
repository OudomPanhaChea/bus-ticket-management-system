<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once "./db.php";

$input = json_decode(file_get_contents("php://input"), true);

if (
  empty($input["passenger_name"]) || empty($input["origin"]) || empty($input["destination"]) ||
  empty($input["travel_date"]) || empty($input["seat_number"]) || !isset($input["ticket_price"])
) {
  http_response_code(400);
  echo json_encode(["error" => "All fields are required"]);
  exit;
}

$stmt = $pdo->prepare("INSERT INTO tickets (passenger_name, origin, destination, travel_date, seat_number, ticket_price) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([
  $input["passenger_name"],
  $input["origin"],
  $input["destination"],
  $input["travel_date"],
  $input["seat_number"],
  $input["ticket_price"]
]);

echo json_encode(["success" => true, "id" => $pdo->lastInsertId(), "message" => "Ticket created successfully!"]);
?>