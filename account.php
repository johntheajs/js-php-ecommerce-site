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
// Function to update the username
function updateUsername($newUsername) {
  $conn = connectToDatabase();
  $username = $_SESSION["username"];
  $sql = "UPDATE users SET username = '$newUsername' WHERE username = '$username'";
  if ($conn->query($sql) === TRUE) {
    $_SESSION["username"] = $newUsername;
    return true;
  } else {
    return false;
  }
  $conn->close();
}
// Function to update the password
function updatePassword($currentPassword, $newPassword) {
  $conn = connectToDatabase();
  $username = $_SESSION["username"];
  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$currentPassword'";
  $result = $conn->query($sql);
  if ($result->num_rows == 1) {
    $sql = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
    if ($conn->query($sql) === TRUE) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
  $conn->close();
}
// Function to delete the account
function deleteAccount() {
    $conn = connectToDatabase();  
    $username = $_SESSION["username"];
    $sql = "DELETE FROM users WHERE username = '$username'";  
    if ($conn->query($sql) === TRUE) {
      session_destroy();
      header("Location: signin.html"); // Redirect to signin.html after successful deletion
      exit;
    } else {
      return false;
    }
    $conn->close();
  }
// Check if the user is logged in
if (!isset($_SESSION["username"])) {
  header("Location: signin.html");
  exit;
}
// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $action = $_GET["action"] ?? "";
  if ($action === "updateUsername") {
    $newUsername = $_POST["newUsername"];
    if (updateUsername($newUsername)) {
      echo "Username updated successfully!";
    } else {
      echo "Failed to update the username.";
    }
  } elseif ($action === "updatePassword") {
    $currentPassword = $_POST["currentPassword"];
    $newPassword = $_POST["newPassword"];
    if (updatePassword($currentPassword, $newPassword)) {
      echo "Password updated successfully!";
    } else {
      echo "Failed to update the password.";
    }
  } elseif ($action === "deleteAccount") {
    if (deleteAccount()) {
      echo "Account deleted successfully!";
    } else {
      echo "Failed to delete the account.";
    }
  }
}
?>
