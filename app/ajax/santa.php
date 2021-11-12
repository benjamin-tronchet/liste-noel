<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" and $_POST["santa"]) {
    $_SESSION['santa'] = $_POST["santa"];
}
?>