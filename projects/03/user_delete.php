<?php
// Step 1: Include config.php file
include 'config.php';
// Step 2: Secure and only allow 'admin' users to access this page
if (!isset($_SESSION['loggedin']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect user to login page or display an error message
    $_SESSION['messages'][] = "You must be an administrator to access that resource.";
    header('Location: login.php');
    exit;
}
// Step 3: Check if the $_GET['id'] exists; if it does, 
//get the user the record from the database and store it in the associative array $user.
// If a user record with that ID does not exist, display the message "A user with that ID did not exist."
if($_GET['id']) {
            // User found. Now update the activated_on field with the current date and time
            $updateStmt = $pdo->prepare("UPDATE `users` SET `activation_code` = CONCAT('activated - ', NOW()) WHERE `id` = ?");
            $updateResult = $updateStmt->execute([$user['id']]);

            if ($updateResult) {
                // Update was successful
                $_SESSION['messages'][] = "Account activated successfully. You can now login.";
                header('Location: login.php');
                exit;
            } else {
                // Update failed
                $_SESSION['messages'][] = "A User with that ID did not exist";
            }
        }
// Step 4: Check if $_GET['confirm'] == 'yes'. This means they clicked the 'yes' button to confirm the removal of the record. 
//Prepare and execute a SQL DELETE statement where the user id == the $_GET['id']. 
//Else (meaning they clicked 'no'), return them to the users_manage.php page.
if($_GET['confirm'] == 'yes'){
    $delete = $pdo->prepare("DELETE FROM `users` WHERE `id` = ?");
    $deleted = $delete->execute(['id']);
} else {
    header('Location:users_manage.php');
    exit;
}

?>

<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>
<?php include 'config.php'; ?>

    <!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Delete User Account</h1>
    <p class="subtitle">Are you sure you want to delete the user: <?= $user['full_name'] ?></p>
    <div class="buttons">
        <a href="?id=<?= $user['id'] ?>&confirm=yes" class="button is-success">Yes</a>
        <a href="?id=<?= $user['id'] ?>&confirm=no" class="button is-danger">No</a>
    </div>
</section>
<!-- END YOUR CONTENT -->

<?php include 'templates/footer.php'; ?>