<?php
    include 'config.php';

    session_start();
    $user_id = $_SESSION['user_id'];
    
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    //mysqli_query($conn, "DELETE FROM `order_manager` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
?>
