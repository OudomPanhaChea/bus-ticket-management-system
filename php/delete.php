<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once "./db.php";

$input = json_decode(file_get_contents("php://input"), true);

if (empty($input["id"])) {
  http_response_code(400);
  echo json_encode(["error" => "Ticket ID is required"]);
  exit;
}

$stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ?");
$stmt->execute([$input["id"]]);

echo json_encode(["success" => true, "message" => "Ticket deleted successfully!"]);
?>