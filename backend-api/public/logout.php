<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logged Out</title>
    <script src="https://www.gstatic.com/firebasejs/10.11.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.11.0/firebase-auth.js"></script>
    <script>
      // TODO: Replace with your Firebase config
      const firebaseConfig = { /* ... */ };
      firebase.initializeApp(firebaseConfig);

      // Sign out from Firebase as well
      firebase.auth().signOut().then(() => {
        // Redirect to login page after sign out
        window.location.href = 'login.php';
      });
    </script>
</head>
<body>
    <p>Logging out...</p>
</body>
</html>