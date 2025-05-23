<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; }
        .sidebar {
            min-height: 100vh;
            background: #212529;
            color: #fff;
            width: 220px;
            position: fixed;
            top: 0; left: 0;
            padding: 30px 0 0 0;
        }
        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 2rem;
        }
        .sidebar ul {
            list-style: none;
            padding-left: 0;
        }
        .sidebar ul li {
            margin: 1rem 0;
        }
        .sidebar ul li a {
            color: #adb5bd;
            text-decoration: none;
            padding: 0.5rem 2rem;
            display: block;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar ul li a:hover, .sidebar ul li a.active {
            background: #343a40;
            color: #fff;
            border-radius: 0 20px 20px 0;
        }
        .sidebar a {
            color: #adb5bd;
        }
        .sidebar a.logout {
            color: #ffc107;
            display: block;
            margin: 2rem 2rem 0 2rem;
            text-align: center;
        }
        .main-content {
            margin-left: 220px;
            padding: 2rem;
            background: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h2>Admin</h2>
    <ul>
        <li><a href="#" data-page="users.php">Users</a></li>
        <li><a href="#" data-page="franchises.php">Franchises</a></li>
        <li><a href="#" data-page="restaurants.php">Restaurants</a></li>
        <li><a href="#" data-page="employees.php">Employees</a></li>
        <li><a href="#" data-page="menu_categories.php">Menu Categories</a></li>
        <li><a href="#" data-page="menu_items.php">Menu Items</a></li>
        <li><a href="#" data-page="condiments.php">Condiments</a></li>
        <li><a href="#" data-page="upgrades.php">Upgrades</a></li>
        <li><a href="#" data-page="orders.php">Orders</a></li>
        <!-- Add more as needed -->
    </ul>
    <a href="./logout.php" class="logout">Logout</a>
</div>
<div class="main-content" id="main-content"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.sidebar ul li a[data-page]').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        fetch('./pages/' + page)
            .then(res => res.text())
            .then(html => {
                document.getElementById('main-content').innerHTML = html;
                // Optionally update active class
                document.querySelectorAll('.sidebar ul li a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            });
    });
});
</script>
</body>
</html>