<?php
require 'include/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");

        $stmt->bindParam(':username', $username);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Successful login
            session_start(); // Start a new session
            $_SESSION['user_id'] = $user['id']; // Store user information in the session

            $valid = true;
            $message = 'Login successful';
        } else {
            $valid = false;
            $message = 'Login failed: Invalid username or password';
        }
    } catch (PDOException $e) {
        $valid = false;
        $message = 'Login failed: ' . $e->getMessage();
    }

    echo json_encode(['success' => $valid, 'message' => $message]);
}
