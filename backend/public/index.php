<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];

try {
    $db = new PDO('sqlite:../sqlite/cms.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($method === 'GET') {
        $stmt = $db->query('SELECT content FROM cms WHERE id = 1');
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['text' => $result['content']]);
    }

    if ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);
        $text = $input['text'];

        $stmt = $db->prepare('UPDATE cms SET content = :content WHERE id = 1');
        $stmt->bindValue(':content', $text);
        $stmt->execute();

        echo json_encode(['message' => 'Text saved successfully']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
