<?php
session_start();

header('Content-Type: application/json');

// Il file va chiamato solo via fetch POST da language.js: una richiesta
// GET (es. da navigazione diretta nel browser) viene rifiutata subito.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /");
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$requested = isset($data['lang']) ? strtolower(trim($data['lang'])) : '';

// whitelist: accetta solo le lingue che il sito supporta davvero,
// così una richiesta malformata o un valore inatteso non può mai
// finire in sessione e far fallire Lang() al prossimo caricamento
$allowedLanguages = ['it', 'en'];

if (in_array($requested, $allowedLanguages, true)) {
    $_SESSION['lang'] = $requested;
    echo json_encode(['success' => true, 'lang' => $requested]);
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Lingua non valida']);
}

session_write_close();