<?php
session_start();

// Function to establish database connection
function connectToDatabase() {
  $host = "localhost";
  $username = "john";
  $password = "1234";
  $database = "john";

  $conn = new mysqli($host, $username, $password, $database);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  return $conn;
}

// Check if the user is already logged in
if (isset($_SESSION["username"])) {
  header("Location: account.html");
  exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Validate the form data (You can add more validation if required)
  if (empty($username) || empty($password)) {
    echo "Please fill in all the fields.";
  } else {
    // Connect to the MySQL database
    $conn = connectToDatabase();

    // Check the database connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Query the database to check if the username and password are valid
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      // Username and password are valid, user is authenticated
      $_SESSION["username"] = $username;
      header("Location: account.html");
      exit;
    } else {
      // Invalid username or password
      echo "Invalid username or password.";
    }

    // Close the database connection
    $conn->close();
  }
}
?>
