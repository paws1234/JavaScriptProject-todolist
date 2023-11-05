<?php
require 'include/db.php';

session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    switch ($requestMethod) {
        case 'GET':
            $stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = ?');
            $stmt->execute([$user_id]);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('Content-Type: application/json');
            echo json_encode($tasks);
            break;

        case 'POST':
            $text = $_POST['text'];
            $stmt = $pdo->prepare('INSERT INTO tasks (user_id, text) VALUES (?, ?)');
            $stmt->execute([$user_id, $text]);
            echo json_encode(['id' => $pdo->lastInsertId()]);
            break;

        case 'PUT':
            parse_str(file_get_contents('php://input'), $data);
            $id = $data['id'];

            $stmt = $pdo->prepare('UPDATE tasks SET text = ? WHERE id = ? AND user_id = ?');
            $stmt->execute([$data['text'], $id, $user_id]);
            echo json_encode(['message' => 'Task updated successfully']);
            break;

        case 'DELETE':
            $id = $_GET['id'];

            $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
            $stmt->execute([$id, $user_id]);
            echo json_encode(['message' => 'Task deleted successfully']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            break;
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
