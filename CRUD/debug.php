<?php
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>System Debug - Service Status</title>";
echo "<style>";
echo "body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }";
echo ".container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }";
echo ".success { color: green; font-weight: bold; }";
echo ".error { color: red; font-weight: bold; }";
echo ".warning { color: orange; font-weight: bold; }";
echo ".section { margin: 20px 0; padding: 15px; border-left: 4px solid #667eea; background: #f8f9fa; }";
echo "pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 5px; overflow-x: auto; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";
echo "<h1>🔧 System Services Debug</h1>";

// Test 1: Basic PHP
echo "<div class='section'>";
echo "<h2>1. PHP Server Status</h2>";
echo "<p><strong>PHP Version:</strong> " . phpversion() . "</p>";
echo "<p><strong>Server Software:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</p>";
echo "<p class='success'>✅ PHP is running</p>";
echo "</div>";

// Test 2: File Includes
echo "<div class='section'>";
echo "<h2>2. File Includes</h2>";
$files_to_check = [
    '../database/connection.php' => 'Database Connection',
    '../database/sanitize.php' => 'Sanitize Functions',
    '../css/style.css' => 'CSS Styles'
];

foreach ($files_to_check as $file => $description) {
    if (file_exists($file)) {
        echo "<p class='success'>✅ $description: $file (Exists)</p>";
    } else {
        echo "<p class='error'>❌ $description: $file (NOT FOUND)</p>";
    }
}
echo "</div>";

// Test 3: Database Connection
echo "<div class='section'>";
echo "<h2>3. Database Connection</h2>";
try {
    include '../database/connection.php';
    
    if ($conn) {
        echo "<p class='success'>✅ Database connection successful</p>";
        
        // Test query
        $result = mysqli_query($conn, "SELECT 1 as test");
        if ($result) {
            echo "<p class='success'>✅ Database query test passed</p>";
        } else {
            echo "<p class='error'>❌ Database query failed: " . mysqli_error($conn) . "</p>";
        }
        
        // Check if users table exists
        $table_check = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
        if (mysqli_num_rows($table_check) > 0) {
            echo "<p class='success'>✅ Users table exists</p>";
            
            // Count users
            $count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
            $count_data = mysqli_fetch_assoc($count_result);
            echo "<p><strong>Total users in database:</strong> " . $count_data['total'] . "</p>";
        } else {
            echo "<p class='error'>❌ Users table NOT FOUND</p>";
        }
        
    } else {
        echo "<p class='error'>❌ Database connection failed</p>";
    }
} catch (Exception $e) {
    echo "<p class='error'>❌ Database error: " . $e->getMessage() . "</p>";
}
echo "</div>";

// Test 4: Form Processing
echo "<div class='section'>";
echo "<h2>4. Form Processing Test</h2>";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<p class='success'>✅ Form submission detected</p>";
    echo "<p><strong>POST data received:</strong></p>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "<p>No form submission detected</p>";
}

// Test form
echo "<form method='POST' action=''>";
echo "<input type='hidden' name='test' value='debug_value'>";
echo "<button type='submit'>Test Form Submission</button>";
echo "</form>";
echo "</div>";

// Test 5: PHP Configuration
echo "<div class='section'>";
echo "<h2>5. PHP Configuration</h2>";
echo "<p><strong>Display Errors:</strong> " . (ini_get('display_errors') ? 'On' : 'Off') . "</p>";
echo "<p><strong>Error Reporting:</strong> " . ini_get('error_reporting') . "</p>";
echo "<p><strong>Max Execution Time:</strong> " . ini_get('max_execution_time') . "s</p>";
echo "<p><strong>Memory Limit:</strong> " . ini_get('memory_limit') . "</p>";
echo "<p><strong>Post Max Size:</strong> " . ini_get('post_max_size') . "</p>";
echo "<p><strong>Upload Max Filesize:</strong> " . ini_get('upload_max_filesize') . "</p>";
echo "</div>";

// Test 6: Server Environment
echo "<div class='section'>";
echo "<h2>6. Server Environment</h2>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</p>";
echo "<p><strong>Current Directory:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Request Method:</strong> " . ($_SERVER['REQUEST_METHOD'] ?? 'Unknown') . "</p>";
echo "<p><strong>Request URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "</p>";
echo "</div>";

// Test 7: CRUD Folder Structure
echo "<div class='section'>";
echo "<h2>7. Folder Structure Check</h2>";
function checkFolderStructure($basePath) {
    $expected = [
        'CRUD/' => [
            'index.php',
            'create.php', 
            'update.php',
            'delete.php'
        ],
        'database/' => [
            'connection.php',
            'sanitize.php',
            'database.sql'
        ],
        'css/' => [
            'style.css'
        ]
    ];
    
    foreach ($expected as $folder => $files) {
        $fullPath = $basePath . $folder;
        if (is_dir($fullPath)) {
            echo "<p class='success'>✅ Folder: $folder</p>";
            foreach ($files as $file) {
                $filePath = $fullPath . $file;
                if (file_exists($filePath)) {
                    echo "<p class='success'>&nbsp;&nbsp;✅ File: $file</p>";
                } else {
                    echo "<p class='error'>&nbsp;&nbsp;❌ File: $file (MISSING)</p>";
                }
            }
        } else {
            echo "<p class='error'>❌ Folder: $folder (MISSING)</p>";
        }
    }
}

checkFolderStructure('../');
echo "</div>";

echo "<div class='section'>";
echo "<h2>8. Quick Fix Suggestions</h2>";

// Check for common issues
$issues = [];

// Check if connection.php has output
$conn_content = file_get_contents('../database/connection.php');
if (strpos($conn_content, 'echo "Connected successfully"') !== false) {
    $issues[] = "Remove 'echo \"Connected successfully\"' from connection.php";
}

// Check for BOM issues
if (substr($conn_content, 0, 3) === "\xEF\xBB\xBF") {
    $issues[] = "connection.php has BOM (Byte Order Mark) - save as UTF-8 without BOM";
}

if (empty($issues)) {
    echo "<p class='success'>✅ No common issues detected</p>";
} else {
    echo "<p class='warning'>⚠️ Issues found:</p>";
    echo "<ul>";
    foreach ($issues as $issue) {
        echo "<li>$issue</li>";
    }
    echo "</ul>";
}
echo "</div>";

echo "</div>";
echo "</body>";
echo "</html>";
?>