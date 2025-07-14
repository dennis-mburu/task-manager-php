<?php
include 'includes/db.php';
include 'includes/auth.php';
// Ensure only admin can access this page
requireAdmin();

// Fetch all users from the database
$result = mysqli_query($conn, "SELECT id, username, email, role FROM users ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Users – Task Manager</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>
    <div class="manage-page-title">
        <?php include 'includes/back_nav.php'; ?>
        <h2><i class="fa-solid fa-wrench"></i>Manage Users</h2>
        <p class="subtext">View, edit, or remove users from the system.</p>
    </div>


    <section class="dashboard-tasks">
        <div class="container">
            <?php if (isset($_GET['deleted'])): ?>
                <p class="success">✅ User deleted successfully.</p>
            <?php endif; ?>
            <?php if (isset($_GET['updated'])): ?>
                <p class="success">✅ User updated successfully.</p>
            <?php endif; ?>
            <div class="table-wrapper">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter = 1;
                        while ($user = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>{$counter}</td>";
                            echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                            echo "<td><a href='edit_user.php?id={$user['id']}' class='btn small'><i class='fa-solid fa-user-pen'></i>Edit</a></td>";
                            echo "<td><button class='btn small danger' onclick='showDeleteModal({$user['id']})'><i class='fa-solid fa-trash'></i>Delete</button></td>";
                            echo "</tr>";
                            $counter++;
                        }

                        if ($counter === 1) {
                            echo "<tr><td colspan='5'>No users found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>



    <!-- User delete Confirmation Modal -->
    <div id="confirmModal" class="modal hidden">
        <div class="modal-content">
            <p><i class="fa-solid fa-triangle-exclamation" style="color: red"></i>Are you sure you want to delete this user? This action will also delete all tasks assigned to this user, and cannot be undone!</p>
            <div class="modal-actions">
                <button onclick="confirmUserDelete()" class="btn danger">Yes, Delete</button>
                <button onclick="closeModal()" class="btn">Cancel</button>
            </div>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="js/scripts.js"></script>
</body>

</html>