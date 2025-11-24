<?php
include '../database/connection.php';
include '../database/sanitize.php';

// define error variables for required fields only
$nameErr = $emailErr = $phoneErr = "";
$name = $email = $phone = "";

$error = ''; // general errors
$user = null;

// get user ID from URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        // pre-populate form fields with existing data
        $name = $user['name'];
        $email = $user['email'];
        $phone = $user['phone'];
    } else {
        header("Location: index.php?msg=User not found!");
        exit();
    }
}

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

// handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // validate Name (REQUIRED)
    if (empty($_POST['name'])) {
        $nameErr = "Name is required";
    } else {
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
        // use prepared statement (prevents sql injection)
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $phone, $id);
        
        if ($stmt->execute()) {
            header("Location: index.php?msg=User updated successfully!");
            exit();
        } else {
            // error handling
            $error = "Error: " . $stmt->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Update User</h1>
        
        <?php if ($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($user): ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
            
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>