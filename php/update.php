<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Content-Type");

require_once "./db.php";

$input = json_decode(file_get_contents("php://input"), true);

if (empty($input["id"])) {
  http_response_code(400);
  echo json_encode(["error" => "Ticket ID is required"]);
  exit;
}

$stmt = $pdo->prepare("UPDATE tickets SET passenger_name=?, origin=?, destination=?, travel_date=?, seat_number=?, ticket_price=?, status=? WHERE id=?");
$stmt->execute([
  $input["passenger_name"],
  $input["origin"],
  $input["destination"],
  $input["travel_date"],
  $input["seat_number"],
  $input["ticket_price"],
  $input["status"] ?? "active",
  $input["id"]
]);

echo json_encode(["success" => true, "message" => "Ticket updated successfully!"]);
?>