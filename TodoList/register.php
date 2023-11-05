<?php
require 'include/db.php'; 


$response = ['success' => false, 'message' => 'Invalid request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
      
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");

 
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

   
        $response = ['success' => true, 'message' => 'Registration successful'];
    } catch (PDOException $e) {
      
        $response = ['success' => false, 'message' => 'Registration failed: ' . $e->getMessage()];
    }
}


header('Content-Type: application/json');
echo json_encode($response);