# PHP CRUD System - User Management

A simple PHP web application for managing users with Create, Read, Update, and Delete (CRUD) operations. This system demonstrates basic PHP form handling, database operations, and security practices.

## 🚀 System Overview
- **Purpose**: Manage user records (name, email, phone)
- **Features**: Add new users, view all users, edit user details, delete users
- **Security**: Input validation, SQL injection prevention, XSS protection
- **Database**: MySQL with users table

## 📁 Project Structure
crud_basics/\
├── CRUD/\
│ ├── index.php # List all users\
│ ├── create.php # Add new user\
│ ├── update.php # Edit user\
│ └── delete.php # Delete user\
├── database/\
│ ├── connection.php # Database connection\
│ ├── sanitize.php # Input sanitization\
│ └── database.sql # Database schema\
└── css/\
└── style.css # Styling

# PHP CRUD System - Function Reference

## Database Functions
- `mysqli_connect()` - Establishes connection to MySQL database using credentials
- `mysqli_query()` - Executes SQL queries like SELECT, INSERT, UPDATE, DELETE
- `mysqli_real_escape_string()` - Escapes special characters to prevent SQL injection attacks
- `mysqli_fetch_assoc()` - Fetches database results as associative arrays (e.g., `$row['name']`)
- `mysqli_num_rows()` - Counts number of rows returned from SELECT query
- `mysqli_error()` - Returns the last database error message for debugging
- `mysqli_close()` - Closes the database connection to free resources

## Validation & Security Functions
- `preg_match()` - Validates text patterns using regular expressions (regex)
  - **Name**: `/^[a-zA-Z-' ]*$/` - Only allows letters, spaces, hyphens, apostrophes
  - **Phone**: `/^[0-9\-\(\)\s\+]*$/` - Only numbers, spaces, hyphens, parentheses, plus sign
- `filter_var()` - Validates and sanitizes data using PHP filters
  - **Email**: `FILTER_VALIDATE_EMAIL` - Checks if email has proper format (user@domain.com)
- `empty()` - Checks if a variable is empty (null, "", 0, false, array())
- `sanitize_input()` - Custom function that combines trim(), stripslashes(), htmlspecialchars()
- `htmlspecialchars()` - Converts special characters to HTML entities to prevent XSS attacks

## Form & HTTP Functions
- `$_SERVER['REQUEST_METHOD']` - Detects if form was submitted (POST) or page loaded (GET)
- `$_POST` - Superglobal array containing all form data from POST requests
- `$_GET` - Superglobal array containing all URL parameters (e.g., ?id=1)
- `header()` - Sends raw HTTP headers, used for redirecting to other pages
- `exit()` - Stops script execution immediately, often used after redirects

## String Functions
- `trim()` - Removes whitespace and other characters from beginning and end of strings
- `stripslashes()` - Removes backslashes added by addslashes() or magic quotes
- `htmlspecialchars()` - Converts special characters like <, >, & to HTML entities (&lt;, &gt;, &amp;)

## Control Structures
- `if/else` - Conditional statements for decision making in code
- `while` - Loop that continues as long as condition is true (used for database results)
- `try/catch` - Error handling structure for exceptions (used in transactions)

## Prepared Statements (Security)
- `prepare()` - Creates a SQL template with placeholders (?) instead of actual values
- `bind_param()` - Binds variables to the prepared statement placeholders
  - **"sssi"** = string, string, string, integer parameter types
- `execute()` - Runs the prepared statement with the bound parameters

## Transaction Functions
<<<<<<< HEAD
- `mysqli_autocommit(false)` - Turns off auto-commit mode to start a transaction
- `mysqli_commit()` - Saves all changes made during the transaction permanently
- `mysqli_rollback()` - Undoes all changes made during the transaction if errors occur

## File Inclusion
- `include` - Includes and evaluates the specified file, continues if file not found
- Used to connect database files and sanitization functions across multiple pages

## 🔧 How to Use
1. Run `database.sql` in MySQL to create database and table
2. Place files in web server directory (e.g., XAMPP htdocs)
3. Access `index.php` through web browser to start managing users

## 🛡️ Security Features Implemented
- **SQL Injection Prevention**: Prepared statements and mysqli_real_escape_string()
- **XSS Prevention**: htmlspecialchars() when outputting user data
- **Input Validation**: preg_match() and filter_var() for data format checking
- **Data Sanitization**: Custom sanitize_input() function for cleaning user input
=======
- `mysqli_autocommit()` - Controls transaction behavior
- `mysqli_commit()` - Saves changes permanently
- `mysqli_rollback()` - Undoes changes on error
>>>>>>> 5dd97a40bd03cd1636878418e1382e77c56dfbac
