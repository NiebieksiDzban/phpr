<body>
<?= htmlspecialchars((string)($_SESSION['user_id'] ?? ''), ENT_QUOTES, 'UTF-8') ?> <br>
    <a href="./logout">Logout</a>
    <a href="./login">Login</a>
    <a href="./register">Register</a>
