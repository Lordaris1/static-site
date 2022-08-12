<?php
if(isset($_POST["submit"])){

    $uname = $_POST["uname"];
    $pass = $_POST["psw"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($uname, $pass) !== false){

        header("Location: ../login.php?error=emptyInputs");
        exit();
    }

    loginUser($conn, $uname, $pass);
}    


else{
    header("Location: ../login.php");
    
}