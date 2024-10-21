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
/* Step 3: You can use your completed `register.php` page as a guide for this page. 
However, you must remove the unused fields from the form handler and add a handler for the user role field; 
if the email already exists, redirect back to `user_add.php`, displaying the message "That email already exists. Please choose another." 
You must also update the SQL INSERT statement, and when the record is successfully created, redirect back to the `users_manage.php` page with the message "The user account for $full_name was created. 
They will need to login to activate their account."
*/
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract, sanitize user input, and assign data to variables
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encrypt password
    $phone = htmlspecialchars($_POST['phone']);
    $role = htmlspecialchars($_POST['role']);
    $activation_code = uniqid(); // Generate a unique id

    // Check if the email is unique
    $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $stmt->execute([$email]);
    $userExists = $stmt->fetch();

    if ($userExists) {
        // Email already exists, redirect back to user_add.php "That email already exists. Please Choose another."
        $_SESSION['messages'][] = "That email already exists. Please Choose another.";
        header('Location: user_add.php');
        exit;
    } else {
       // Extract, sanitize user input and assign data to variables
    $user_bio = htmlspecialchars($_POST['user_bio']); // Extract and sanitize user bio

        //Email is unique, proceed with inserting the new user record, redirect to users_manage.php
        $insertStmt = $pdo->prepare("INSERT INTO `users`(`full_name`, `email`, `pass_hash`, `phone`, `activation_code`, `user_bio`,`role`) VALUES (?, ?, ?, ?, ?, ?,?)");
        $insertStmt->execute([$full_name, $email, $password, $phone, $activation_code, $user_bio, $role]);
        // Generate activation link. This is instead of sending a verification Email and or SMS message
        $activation_link = "?code=$activation_code";
        
        $_SESSION['messages'][] = "The user account for $full_name was created. They will need to login to activate their account.";
        header('Location: users_manage.php');
        exit;
    }
}
// Check if an activation code is provided in the URL query string
if (isset($_GET['code'])) {
    $activationCode = $_GET['code'];

    try {
        // Prepare a SQL statement to select the user with the given activation code
        $stmt = $pdo->prepare("SELECT * FROM users WHERE activation_code = ? LIMIT 1");
        $stmt->execute([$activationCode]);
        $user = $stmt->fetch();

        // Check if user exists
        if ($user) {
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
                $_SESSION['messages'][] = "Failed to activate account. Please try the activation link again or contact support.";
            }
        } else {
            // No user found with that activation code
            $_SESSION['messages'][] = "Invalid activation code. Please check the link or contact support.";
        }
    } catch (PDOException $e) {
        // Handle any database errors (optional)
        die("Database error occurred: " . $e->getMessage());
    }
}
?>

<?php include 'templates/head.php'; ?>
<?php include 'templates/nav.php'; ?>
<?php include 'config.php'; ?>

    <!-- BEGIN YOUR CONTENT -->
<section class="section">
    <h1 class="title">Add User</h1>
    <form action="user_add.php" method="post">
        <!-- Full Name -->
        <div class="field">
            <label class="label">Full Name</label>
            <div class="control">
                <input class="input" type="text" name="full_name" required>
            </div>
        </div>
        <!-- Email -->
        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" name="email" required>
            </div>
        </div>
        <!-- Password -->
        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" name="password" required>
            </div>
        </div>
        <!-- Phone -->
        <div class="field">
            <label class="label">Phone</label>
            <div class="control">
                <input class="input" type="tel" name="phone">
            </div>
        </div>
        <!-- Role -->
        <div class="field">
            <label class="label">Role</label>
            <div class="control">
                <div class="select">
                    <select name="role">
                        <option value="admin">Admin</option>
                        <option value="editor">Editor</option>
                        <option value="user" selected>User</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Submit -->
        <div class="field is-grouped">
            <div class="control">
                <button type="submit" class="button is-link">Add User</button>
            </div>
            <div class="control">
                <a href="users_manage.php" class="button is-link is-light">Cancel</a>
            </div>
        </div>
    </form>
</section>
<!-- END YOUR CONTENT -->

<?php include 'templates/footer.php'; ?>