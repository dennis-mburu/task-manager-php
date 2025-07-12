<header>
    <h1>Task Manager</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> |
        <a href="logout.php">Logout</a></h2>
    <?php endif; ?>
    <hr>
</header>
