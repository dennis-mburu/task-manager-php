<header class="header">
    <div class="header-container">
        <h1 class="header-title">
            <a href="dashboard.php"><i class="fa-solid fa-clipboard-list"></i> Task Manager</a>
        </h1>

        <?php if (isset($_SESSION['username'])): ?>
            <div class="user-actions">
                <span class="welcome-text">👋 Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>

                <a href="profile.php" class="btn">
                    <i class="fa-solid fa-user-gear"></i> Profile
                </a>

                <a href="logout.php" class="btn btn-logout">
                    <i class="fa-solid fa-power-off"></i> Logout
                </a>
            </div>
        <?php endif; ?>
    </div>
</header>