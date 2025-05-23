<?php
session_start();
require_once 'db.php';
require_once 'dashboard/handler/logger.php';

$username = $_SESSION['admin_username'] ?? 'Guest';
logActivity($pdo, $username, 'User tracked a shipment');

$shipment = [];
$trackingCode = $_GET['track_code'] ?? '';
$error = '';

if (!empty($trackingCode)) {
    $stmt = $pdo->prepare("SELECT * FROM shipments WHERE tracking_code = :code");
    $stmt->execute(['code' => $trackingCode]);
    $shipment = $stmt->fetch();

    if (!$shipment) {
        $error = "No shipment found for tracking code: " . htmlspecialchars($trackingCode);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Track Shipment | COURIER-X</title>
  <link rel="stylesheet" href="css/index.css" />
  <style>
@media print {
  body * {
    visibility: hidden;
  }
  #printable-area, #printable-area * {
    visibility: visible;
  }
  #printable-area {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
  .shipment-modal, .shipment-wrapper {
    background: #fff !important;
    color: #000 !important;
  }
}
</style>

</head>
<body>

<!-- Tracking Form -->
<section id="track-section" class="container">
  <div class="login-container">
    <div class="circle circle-one"></div>
    <div class="form-container">
      <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
      <h1 class="opacity">Access your parcel today</h1>

      <form id="track-form" method="GET" action="">
        <input type="text" name="track_code" placeholder="Enter Tracking Code" required pattern="[A-Za-z0-9\-]+" value="<?= htmlspecialchars($trackingCode) ?>" />
        <button type="submit">TRACK</button>
      </form>

      <?php if ($trackingCode && $error): ?>
        <p style="color: red; margin-top: 10px;"><?= $error ?></p>
      <?php endif; ?>
    </div>
    <div class="circle circle-two"></div>
  </div>
  <!-- theme varieties -->
  <!-- <div class="theme-btn-container"></div> -->

</section>

<!-- Shipment Details Section -->
<?php if ($shipment): ?>
<section id="parcel-modal" class="shipment-modal">
  <div class="shipment-wrapper" id="printable-area">
    <button onclick="history.back()" class="close-button">&times;</button>

    <div class="shipment-header">
      <h1>COURIER-X</h1>
      <p><strong>Tracking No:</strong> <?= htmlspecialchars($shipment['tracking_code']) ?></p>
    </div>

    <div class="shipment-row">
      <div class="shipment-box">
        <h3>Shipper Address</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($shipment['shipper_name']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($shipment['shipper_address']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($shipment['shipper_email']) ?></p>
      </div>
      <div class="shipment-box">
        <h3>Receiver Address</h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($shipment['receiver_name']) ?></p>
        <p><strong>Address:</strong> <?= htmlspecialchars($shipment['receiver_address']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($shipment['receiver_email']) ?></p>
      </div>
    </div>

    <div class="shipment-status">
      <p>SHIPMENT STATUS: <strong><?= htmlspecialchars($shipment['status']) ?></strong></p>
    </div>

    <div class="shipment-info-grid">
      <div><strong>Product:</strong> <?= htmlspecialchars($shipment['product_type']) ?></div>
      <div><strong>Payment Mode:</strong> <?= htmlspecialchars($shipment['payment_mode']) ?></div>
      <div><strong>Pickup Date:</strong> <?= htmlspecialchars($shipment['pickup_date']) ?></div>
      <div><strong>Weight:</strong> <?= htmlspecialchars($shipment['weight']) ?> kg</div>
      <div><strong>Quantity:</strong> <?= htmlspecialchars($shipment['quantity']) ?></div>
      <div><strong>Total Freight:</strong> $<?= htmlspecialchars($shipment['total_freight']) ?></div>
      <div><strong>Departure Time:</strong> <?= htmlspecialchars($shipment['departure_time']) ?></div>
      <div><strong>Destination:</strong> <?= htmlspecialchars($shipment['destination']) ?></div>
      <div><strong>Expected Delivery Date:</strong> <?= htmlspecialchars($shipment['expected_delivery_date']) ?></div>
    </div>

    <div class="map-container">
      <iframe
        src="https://www.google.com/maps?q=<?= urlencode($shipment['destination']) ?>&output=embed"
        width="100%" height="300" style="border:0;" allowfullscreen loading="lazy">
      </iframe>
    </div>

    <div style="text-align: center; margin-top: 30px;">
      <button onclick="history.back()" class="form-close-btn">Close</button>
      <button onclick="window.print()" class="form-close-btn">Print as PDF</button>
    </div>
  </div>
</section>
<?php endif; ?>

<script src="js/index.js"></script>
<script src="js/theme.js"></script>
</body>
</html>
