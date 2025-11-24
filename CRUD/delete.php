<?php
include '../database/connection.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $sql = "DELETE FROM users WHERE id = '$id'";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=User deleted successfully!");
    } else {
        header("Location: index.php?msg=Error deleting user!");
    }
} else {
    header("Location: index.php");
}

mysqli_close($conn);
exit();
?>