let inactivityTime = function () {
  let time;
  const logoutAfter = 15 * 60 * 1000; // 15 minutes

  function resetTimer() {
    clearTimeout(time);
    time = setTimeout(() => {
      alert("You were logged out due to inactivity.");
      window.location.href = "logout.php";
    }, logoutAfter);
  }

  // Activity events
  window.onload = resetTimer;
  document.onmousemove = resetTimer;
  document.onkeydown = resetTimer;
  document.onclick = resetTimer;
  document.onscroll = resetTimer;
};

inactivityTime();

