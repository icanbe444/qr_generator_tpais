<?php
session_start();

$servername = "localhost";
$dbname = "qr_generate";  // Your database name
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

    // Fetch user data
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedInUser'] = $username;

            // Output a script to store the session in sessionStorage and redirect to generator.html
            echo "<script>
                    sessionStorage.setItem('loggedInUser', '$username');
                    window.location.href = 'tiny-qr.html';
                  </script>";
            exit();
        } else {
            echo "Invalid username or password!";
            header("refresh:2;url=login.html");
            exit();
        }
    } else {
        echo "Invalid username or password!";
        header("refresh:2;url=login.html");
        exit();
    }

    $stmt->close();
}
$conn->close();
?>
