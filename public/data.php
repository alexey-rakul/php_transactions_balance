<?php
include_once('db.php');
include_once('model.php');

try {
    $conn = get_connect();
    header('Content-Type: application/json');

    $user_id = isset($_GET['user']) ? (int)$_GET['user'] : null;

    if (!$user_id) {
        throw new Exception("Invalid user ID");
    }

    $transactions = get_user_transactions_balances($user_id, $conn);
    echo json_encode([
        'status' => 'success',
        'data' => $transactions
    ]);
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'An error occurred while processing your request'
    ]);
}
