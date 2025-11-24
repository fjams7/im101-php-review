# PHP CRUD System - Function Reference

## Database Functions
- `mysqli_connect()` - Connects to MySQL database
- `mysqli_query()` - Executes SQL queries
- `mysqli_real_escape_string()` - Escapes special characters for SQL security
- `mysqli_fetch_assoc()` - Gets result rows as associative arrays
- `mysqli_num_rows()` - Counts rows in result set
- `mysqli_error()` - Returns database error messages
- `mysqli_close()` - Closes database connection

## Validation & Security Functions
- `preg_match()` - Validates patterns using regular expressions
- Name: `/^[a-zA-Z-' ]*$/` (letters, spaces, hyphens, apostrophes)
- Phone: `/^[0-9\-\(\)\s\+]*$/` (numbers, spaces, hyphens, parentheses, +)
- `filter_var()` - Validates data formats
- Email: `FILTER_VALIDATE_EMAIL`
- `empty()` - Checks if variable is empty
- `sanitize_input()` - Custom function to clean user input
- `htmlspecialchars()` - Prevents XSS attacks when outputting data

## Form & HTTP Functions
- `$_SERVER['REQUEST_METHOD']` - Checks if form was submitted (POST/GET)
- `$_POST` - Accesses form data
- `$_GET` - Accesses URL parameters
- `header()` - Redirects to other pages
- `exit()` - Stops script execution

## String Functions
- `trim()` - Removes whitespace from strings
- `stripslashes()` - Removes backslashes
- `htmlspecialchars()` - Converts special characters to HTML entities

## Control Structures
- `if/else` - Conditional logic
- `while` - Loops through database results
- `try/catch` - Error handling for transactions

## Prepared Statements (Security)
- `prepare()` - Creates SQL template with placeholders
- `bind_param()` - Binds variables to prepared statement
- `execute()` - Runs the prepared statement

## Transaction Functions
- `mysqli_autocommit()` - Controls transaction behavior
- `mysqli_commit()` - Saves changes permanently
- `mysqli_rollback()` - Undoes changes on error