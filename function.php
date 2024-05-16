<?php
// Ensure this check is at the very top of your script
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('config.php'); // Ensure this file contains the database connection $conn

function check_login($conn)
{
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";

        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }

    // Redirect to login
    header("Location: login.php");
    die;
}

function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

$error = ""; // Initialize error variable

// For login
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Check if email and password fields are set
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (!empty($email) && !empty($password) && !is_numeric($email)) {
            // Read from database
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $user_data = mysqli_fetch_assoc($result);

                    if ($user_data['password'] === $password) {
                        $_SESSION['user_id'] = $user_data['user_id'];

                        if ($user_data['usertype'] == 'admin') {
                            // Redirect to admin page
                            header("Location: adminpanel.php");
                        } else {
                            // Redirect to user page
                            header("Location: index.php");
                        }
                        die;
                    } else {
                        $error = "Incorrect email or password!";
                    }
                } else {
                    $error = "Incorrect email or password!";
                }
            } else {
                $error = "Database query failed!";
            }
        } else {
            $error = "Please enter both email and password!";
        }
    } else {
        $error = "Please fill in all fields!";
    }
}
?>

