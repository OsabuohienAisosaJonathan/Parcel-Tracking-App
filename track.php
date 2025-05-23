<?php
$code = strtoupper(trim($_GET['track_code']));

// Connect to DB
$conn = new mysqli('localhost', 'root', '', 'courier_x');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query shipment by tracking code
$stmt = $conn->prepare("SELECT * FROM shipments WHERE tracking_code = ?");
$stmt->bind_param("s", $code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "No shipment found with code: $code";
    exit;
}

$shipment = $result->fetch_assoc();
?>

<h1>Tracking Result for <?php echo $shipment['tracking_code']; ?></h1>
<p>Status: <?php echo $shipment['status']; ?></p>
<p>Shipper: <?php echo $shipment['shipper_name']; ?> - <?php echo $shipment['shipper_email']; ?></p>
<p>Receiver: <?php echo $shipment['receiver_name']; ?> - <?php echo $shipment['receiver_email']; ?></p>
<!-- Add more fields as needed -->

<?php
// Optionally get tracking history
$history = $conn->query("SELECT * FROM tracking_history WHERE shipment_id = {$shipment['id']} ORDER BY updated_at DESC");
if ($history->num_rows > 0) {
    echo "<h3>History</h3><ul>";
    while ($row = $history->fetch_assoc()) {
        echo "<li>{$row['updated_at']} — {$row['status']} @ {$row['location']}</li>";
    }
    echo "</ul>";
}
?>
