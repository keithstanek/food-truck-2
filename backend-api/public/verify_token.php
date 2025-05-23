<?php
require_once '../vendor/autoload.php'; // For kreait/firebase-php
use Kreait\Firebase\Auth;

$body = json_decode(file_get_contents('php://input'), true);
$token = $body['token'] ?? '';

$auth = (new \Kreait\Firebase\Factory())->createAuth();
try {
    $verifiedIdToken = $auth->verifyIdToken($token);
    $_SESSION['user'] = $verifiedIdToken->claims()->get('user_id');
    echo json_encode(['success' => true]);
} catch (\Throwable $e) {
    echo json_encode(['success' => false]);
}