<?php
    session_start();

    unset($_SESSION['email']);
    unset($_SESSION['fullname']);
    unset($_SESSION['email']);
    session_destroy();
    header("location:./");
?>