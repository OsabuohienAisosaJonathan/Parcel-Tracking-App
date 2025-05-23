<?php
session_start();
require_once '../../db.php'; // Adjust path if needed

header('Content-Type: application/json');

// Check required fields
$required = ['id', 'tracking_code', 'shipper_name', 'receiver_name', 'destination', 'status'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'error' => "Missing field: $field"]);
        exit;
    }
}

try {
    $stmt = $pdo->prepare("UPDATE shipments SET tracking_code = ?, shipper_name = ?, receiver_name = ?, destination = ?, status = ? WHERE id = ?");
    $stmt->execute([
        $_POST['tracking_code'],
        $_POST['shipper_name'],
        $_POST['receiver_name'],
        $_POST['destination'],
        $_POST['status'],
        $_POST['id']
    ]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
