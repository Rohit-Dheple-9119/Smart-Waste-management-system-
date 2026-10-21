<?php
// data handling file - saves and checks all form data
session_start();
include("connection.php");

// if someone opens this file directly, send them back
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.html");
    exit();
}

$action = $_POST["action"];

// ---------- REGISTER ----------
if ($action == "register") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];

    if ($password != $confirm) {
        echo "Passwords do not match. <a href='index.html#register'>Go back</a>";
        exit();
    }

    // check if email is already used
    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        echo "This email is already registered. <a href='index.html#login'>Login here</a>";
        exit();
    }

    // save password in hashed form (not plain text)
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registration successful! <a href='index.html#login'>Login now</a>";
    } else {
        echo "Something went wrong. Try again.";
    }
}

// ---------- LOGIN ----------
if ($action == "login") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = mysqli_prepare($conn, "SELECT id, name, password FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row["password"])) {
        $_SESSION["user_id"] = $row["id"];
        $_SESSION["user_name"] = $row["name"];
        echo "Welcome " . htmlspecialchars($row["name"]) . "! Login successful. <a href='index.html'>Go to Home</a>";
    } else {
        echo "Wrong email or password. <a href='index.html#login'>Try again</a>";
    }
}

// ---------- WASTE REQUEST ----------
if ($action == "request") {
    $waste_type = $_POST["waste_type"];
    $name = $_POST["name"];
    $area = $_POST["area"];
    $phone = $_POST["phone"];
    $description = $_POST["description"];

    $stmt = mysqli_prepare($conn, "INSERT INTO requests (waste_type, name, area, phone, description) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $waste_type, $name, $area, $phone, $description);

    if (mysqli_stmt_execute($stmt)) {
        echo "Your request is submitted. <a href='index.html'>Back to Home</a>";
    } else {
        echo "Something went wrong. Try again.";
    }
}

// ---------- COMPLAINT ----------
if ($action == "complaint") {
    $type = $_POST["complaint_type"];
    $area = $_POST["area"];
    $description = $_POST["description"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];

    $stmt = mysqli_prepare($conn, "INSERT INTO complaints (complaint_type, area, description, name, phone) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssss", $type, $area, $description, $name, $phone);

    if (mysqli_stmt_execute($stmt)) {
        echo "Your complaint is submitted. <a href='index.html'>Back to Home</a>";
    } else {
        echo "Something went wrong. Try again.";
    }
}
?>
