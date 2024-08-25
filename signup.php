<?php
$servername = "localhost";
$dbname = "qr_generate";
$dbusername = "root";
$dbpassword = "root";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        header("refresh:2;url=signup.html");  // Redirect back to signup page after 2 seconds
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);  // Hash the password

    // Check if username already exists
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username already exists!";
        header("refresh:2;url=signup.html");  // Redirect back to signup page after 2 seconds
    } else {
        // Insert new user into database
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashedPassword);

        if ($stmt->execute()) {
            echo "Signup successful! Redirecting to login...";
            header("refresh:2;url=login.html");  // Redirect after 2 seconds
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $stmt->close();
}
$conn->close();
?>
