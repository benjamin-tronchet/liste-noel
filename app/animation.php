<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" and $_POST["animation"]) {
    $_SESSION['animation'] = $_POST["animation"];
}
?>