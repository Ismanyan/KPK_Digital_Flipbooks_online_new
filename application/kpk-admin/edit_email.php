<?php
    require "../config/connection.php";
    if(!isset($_SESSION['login'])) {

        header("Location: ./login.php");
        exit;

    }

    if(!isset($_GET['id'])) {
        header("Location: ./admin_kontak.php");
        exit;
    }

    $id = mysqli_real_escape_string( $conn, stripslashes( htmlspecialchars($_GET['id']) ));

    $viewed = mysqli_query($conn, "UPDATE `contact` SET `status` = '0' WHERE `contact`.`id` = '$id'");
    header("Location: ./admin_kontak.php");
    exit;
