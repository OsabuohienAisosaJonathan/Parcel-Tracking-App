<?php
$timeout_msg = "";

if (isset($_GET['timeout']) && $_GET['timeout'] == 1) {
    $timeout_msg = "Your session expired due to inactivity. Please log in again.";
}
?>

<!-- Later in HTML body -->
<?php if ($timeout_msg): ?>
  <div style="color: orange; text-align: center; margin-bottom: 10px;">
    <?= htmlspecialchars($timeout_msg) ?>
  </div>
<?php endif; ?>
