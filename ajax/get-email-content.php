<?php
session_start();

if (isset($_SESSION['emailContent'])) {
    echo $_SESSION['emailContent'];
} else {
    echo "No email content found.";
}
?>