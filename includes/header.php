<header>
    <h1>Task Manager</h1>
    <?php if (isset($_SESSION['username'])): ?>
        <div class=d-flex>
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <button class="logout-button">
                <a href="logout.php"><i class="fa-solid fa-power-off"></i>Logout</a>
            </button>
        </div>

    <?php endif; ?>
    <hr>
</header>