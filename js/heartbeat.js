setInterval(() => {
  fetch('heartbeat.php')
    .then(res => {
      if (!res.ok) {
        // Optional: redirect if session expired
        window.location.href = 'admin_log.php?timeout=1';
      }
    })
    .catch(() => {
      console.error('Heartbeat failed');
    });
}, 5 * 60 * 1000); // every 5 minutes

