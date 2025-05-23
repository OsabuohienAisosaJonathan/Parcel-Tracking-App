<?php
session_start();
require_once 'db.php';
require_once 'logger.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = [
        'tracking_code', 'product_type', 'shipper_name', 'shipper_email', 'shipper_address',
        'receiver_name', 'receiver_email', 'receiver_address', 'payment_mode', 'weight',
        'quantity', 'pickup_date', 'expected_delivery_date', 'departure_time',
        'destination', 'status', 'total_freight'
    ];

    $data = [];
    foreach ($fields as $field) {
        $data[$field] = !empty($_POST[$field]) ? trim($_POST[$field]) : null;
    }

    try {
        $stmt = $pdo->prepare("
            INSERT INTO shipments (
                tracking_code, product_type, shipper_name, shipper_email, shipper_address,
                receiver_name, receiver_email, receiver_address,
                payment_mode, weight, quantity, pickup_date,
                expected_delivery_date, departure_time, destination, status, total_freight
            ) VALUES (
                :tracking_code, :product_type, :shipper_name, :shipper_email, :shipper_address,
                :receiver_name, :receiver_email, :receiver_address,
                :payment_mode, :weight, :quantity, :pickup_date,
                :expected_delivery_date, :departure_time, :destination, :status, :total_freight
            )
        ");

        $stmt->execute($data);

        // Logging must be after a successful execute
        $newId = $pdo->lastInsertId();
        logActivity($pdo, $_SESSION['admin_username'], "Created new shipment record with ID $newId");

        header("Location: ../create.php?success=1");
        exit;

    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }
}
?>
