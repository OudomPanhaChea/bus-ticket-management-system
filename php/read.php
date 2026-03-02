<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once "./db.php";

// READ ONE
if (isset($_GET["id"])) {
  $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
  $stmt->execute([$_GET["id"]]);
  $ticket = $stmt->fetch();
  echo json_encode($ticket ?: ["error" => "Ticket not found"]);
  exit;
}

// READ ALL (with optional search)
$search = isset($_GET["search"]) ? "%" . $_GET["search"] . "%" : "%";
$stmt = $pdo->prepare("SELECT * FROM tickets WHERE passenger_name LIKE ? OR origin LIKE ? OR destination LIKE ? ORDER BY created_at DESC");
$stmt->execute([$search, $search, $search]);
echo json_encode($stmt->fetchAll());
?>