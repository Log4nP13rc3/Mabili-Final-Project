<?php
session_start();
header('Content-Type: application/json');

// Check if the user is authenticated
if (isset($_SESSION['user_id'])) {
    echo json_encode(['authenticated' => true]);
} else {
    echo json_encode(['authenticated' => false]);
}
?>