<?php
include '../database/connection.php';
include '../database/sanitize.php';

// define error variables for required fields only
$nameErr = $emailErr = $phoneErr = "";
$name = $email = $phone = "";

$error = ''; // general errors

/* Enhanced validation
    1. preg_match() - Pattern Matching Function
    What it does: Searches a string for a specific pattern using regular expressions
        - Returns 1 if pattern is found
        - Returns 0 if pattern is NOT found
        - Returns false on error

    2. filter_var() - Filter Validation Function
    What it does: Filters and validates data using predefined filters
    Common filter types:
        - FILTER_VALIDATE_EMAIL - Validates email format
        - FILTER_VALIDATE_URL - Validates URL format
        - FILTER_VALIDATE_IP - Validates IP address
        - FILTER_VALIDATE_INT - Validates integer
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // validate Name (REQUIRED)
    if (empty($_POST['name'])) {
        $nameErr = "Name is required";
    } else {
        // cleans user input
        $name = sanitize_input($_POST['name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters, spaces, hyphens, and apostrophes allowed";
        }
    }
    
    // validate Email (REQUIRED)
    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = sanitize_input($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    
    // validate Phone (OPTIONAL)
    if (!empty($_POST['phone'])) {
        $phone = sanitize_input($_POST['phone']);
        if (!preg_match("/^[0-9\-\(\)\s\+]*$/", $phone)) {
            $phoneErr = "Invalid phone format. Only numbers, spaces, hyphens, parentheses, and + allowed";
        }
    }
    
    // if no errors in required fields, proceed with database operation
    if (empty($nameErr) && empty($emailErr) && empty($phoneErr)) {
        // ========== TRANSACTION START ==========
        mysqli_autocommit($conn, false);
        
        try {
            // use prepared statement for security (prevents sql injection)
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $email, $phone);
            
            if ($stmt->execute()) {
                mysqli_commit($conn);
                header("Location: index.php?msg=User created successfully!");
                exit();
            } else {
                throw new Exception($stmt->error);
            }
        // error handling
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $error = "Error creating user: " . $e->getMessage();
        }
        
        mysqli_autocommit($conn, true);
        // ========== TRANSACTION END ==========
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Create New User</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create User</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>