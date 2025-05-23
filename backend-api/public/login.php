<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.gstatic.com/firebasejs/10.11.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/10.11.0/firebase-auth.js"></script>
    <script>
      // TODO: Replace with your Firebase config
      const firebaseConfig = { /* ... */ };
      firebase.initializeApp(firebaseConfig);

      function googleLogin() {
        const provider = new firebase.auth.GoogleAuthProvider();
        firebase.auth().signInWithPopup(provider)
          .then(result => result.user.getIdToken())
          .then(token => {
            // Send token to backend for verification
            fetch('verify_token.php', {
              method: 'POST',
              headers: {'Content-Type': 'application/json'},
              body: JSON.stringify({token})
            }).then(res => res.json())
              .then(data => {
                if (data.success) window.location.href = 'index.php';
                else alert('Login failed');
              });
          });
      }
    </script>
</head>
<body class="bg-light d-flex align-items-center" style="height:100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="mb-4">Admin Login</h3>
                        <button class="btn btn-primary w-100" onclick="googleLogin()">
                            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" style="width:20px; margin-right:8px;">
                            Login with Google
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional, for components) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>