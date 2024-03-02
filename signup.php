<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $name = $_POST["name"];
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Validate the form data (You can add more validation if required)
  if (empty($name) || empty($username) || empty($password)) {
    echo "Please fill in all the fields.";
  } else {
    // Connect to the MySQL database
    $conn = new mysqli("localhost", "john", "1234", "john");

    // Check the database connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Insert the user data into the database
    $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
      echo "Registration successful!";
      // Redirect to the signin page
      header("Location: signin.html");
      exit;
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
  }
}
?>
