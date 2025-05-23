<?php
session_start();
require_once 'handler/logger.php';



$timeout_duration = 3600; // 60 minutes
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../admin_log.php");
    exit();
}
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: ../admin_log.php?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time();

function generateTrackingCode() {
    $prefix = "CX";
    $date = date("Ymd");
    $unique = strtoupper(bin2hex(random_bytes(3))); // 6 hex characters
    return "$prefix-$date-$unique";
}

if (!isset($_SESSION['tracking_code'])) {
    $_SESSION['tracking_code'] = generateTrackingCode();
}
$autoTrackingCode = $_SESSION['tracking_code'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>COURIER-X | Create Shipment</title>
  <link rel="stylesheet" href="../dash/css/adminlte.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<div class="app-wrapper">
  <nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
            <i class="bi bi-list"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#" data-lte-toggle="fullscreen">
            <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
            <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
          </a>
        </li>
        <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <img src="../dash/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image" />
            <span class="d-none d-md-inline">Admin</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <li class="user-header text-bg-primary">
              <img src="../dash/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image" />
              <p>Admin User - Courier Operator<br><small>Member since Nov. 2023</small></p>
            </li>
            <li class="user-footer">
              <!-- <a href="profile.php" class="btn btn-default btn-flat">Profile</a> -->
              <a href="logout.php" class="btn btn-default btn-flat float-end">Sign out</a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
      <a href="#" class="brand-link">
        <img src="../dash/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
        <span class="brand-text fw-light">Courier-X</span>
      </a>
    </div>
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
          <li class="nav-item"><a href="dashb.php" class="nav-link"><i class="nav-icon bi bi-speedometer"></i><p>Dashboard</p></a></li>
          <li class="nav-item"><a href="create.php" class="nav-link"><i class="nav-icon bi bi-pencil-square"></i><p>Create record(s)</p></a></li>
          <li class="nav-item"><a href="view.php" class="nav-link"><i class="nav-icon bi bi-filetype-js"></i><p>View Record(s)</p></a></li>
          <li class="nav-item"><a href="edit.php" class="nav-link"><i class="nav-icon bi bi-clipboard-fill"></i><p>Edit Record(s)</p></a></li>
          <li class="nav-item"><a href="delete.php" class="nav-link"><i class="nav-icon bi bi-box-arrow-in-right"></i><p>Delete Record(s)</p></a></li>
          <li class="nav-item"><a href="history.php" class="nav-link"><i class="nav-icon bi bi-browser-edge"></i><p>Record History</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <main class="app-main">
    <div class="app-content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6"><h3 class="mb-0">Create Records <hr></h3></div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
              <li class="breadcrumb-item"><a href="dashb.php">Home</a></li>
              <li class="breadcrumb-item active">Create Record(s)</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
      <?php if (isset($_GET['success']) && $_GET['success'] == 1): unset($_SESSION['tracking_code']); ?>
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
          Shipment created successfully!
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
          There was an error creating the shipment. Please try again.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card shadow-sm">
              <div class="card-header">
                <h5 class="card-title mb-0">Create New Shipment</h5>
              </div>
              <div class="card-body">
                <form action="handler/create_process.php" method="POST">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Tracking Code</label>
                      <input type="text" name="tracking_code" class="form-control" readonly required value="<?php echo htmlspecialchars($autoTrackingCode); ?>">
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                      <button type="button" onclick="regenerateCode()" class="btn btn-sm btn-secondary">Regenerate</button>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Product Type</label>
                      <input type="text" name="product_type" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Payment Mode</label>
                      <input type="text" name="payment_mode" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Weight (kg)</label>
                      <input type="number" name="weight" class="form-control" step="0.01">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Quantity</label>
                      <input type="number" name="quantity" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Pickup Date</label>
                      <input type="date" name="pickup_date" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Expected Delivery Date</label>
                      <input type="date" name="expected_delivery_date" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Departure Time</label>
                      <input type="time" name="departure_time" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Destination</label>
                      <input type="text" name="destination" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Total Freight ($)</label>
                      <input type="number" step="0.01" name="total_freight" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-select">
                        <option value="Pending Pickup">Pending Pickup</option>
                        <option value="In Transit">In Transit</option>
                        <option value="Delivered">Delivered</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Pending Payment">Pending Payment</option>
                        <option value="Returned">Returned</option>
                      </select>
                    </div>
                    <!-- Shipper Info -->
                    <div class="col-md-6">
                      <label class="form-label">Shipper Name</label>
                      <input type="text" name="shipper_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Shipper Email</label>
                      <input type="email" name="shipper_email" class="form-control">
                    </div>
                    <div class="col-md-12">
                      <label class="form-label">Shipper Address</label>
                      <textarea name="shipper_address" class="form-control" rows="2" required></textarea>
                    </div>

                    <!-- Receiver Info -->
                    <div class="col-md-6">
                      <label class="form-label">Receiver Name</label>
                      <input type="text" name="receiver_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Receiver Email</label>
                      <input type="email" name="receiver_email" class="form-control">
                    </div>
                    <div class="col-md-12">
                      <label class="form-label">Receiver Address</label>
                      <textarea name="receiver_address" class="form-control" rows="2" required></textarea>
                    </div>

                  </div>
                  <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary">Save Shipment</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="app-footer">
    <div class="float-end d-none d-sm-inline">Everything & Anything you want</div>
    <strong>Copyright &copy; 2025 <a href="#" class="text-decoration-none">Zux</a>.</strong> All rights reserved.
  </footer>
</div>

  <script>
  function regenerateCode() {
    const prefix = 'CX';
    const dateObj = new Date();
    const year = dateObj.getFullYear();
    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    const day = String(dateObj.getDate()).padStart(2, '0');
    const date = `${year}${month}${day}`;

    function generateHexSuffix(length) {
      const array = new Uint8Array(length / 2);
      window.crypto.getRandomValues(array);
      return Array.from(array).map(b => b.toString(16).padStart(2, '0')).join('').toUpperCase();
    }

    const suffix = generateHexSuffix(6);
    const newCode = `${prefix}-${date}-${suffix}`;
    document.querySelector('[name="tracking_code"]').value = newCode;
  }
  </script>
   <script src="../js/heartbeat.js"></script>
    <script src="../js/inactivity.js"></script>
</body>
</html>
