
<?php

if(isset($_POST["submit"])){


    $uname = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['psw'];
    $rpass = $_POST['psw-repeat'];



    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';


    if(emptyInput($uname, $email, $pass, $rpass) !== false){

        header("Location: ../signup.php?error=emptyInputs");
        exit();
    }

    if(invalidUsername($uname) !== false ){

        header ("Location: ../signup.php?error=invalidUsername");
        exit();
    }
    if(invalidEmail($email) !== false){
        header("Location: ../signup.php?error=invalidEmail");
        exit();
    }
    if(passMatch($pass, $rpass) !== false){
        header("Location: ../signup.php?error=passMismatch");
        exit();
    }

    if(userExist($conn, $uname) !== false){

        header("Location: ../signup.php?error=UsernameTaken");
        exit();
        

    }


    createUser($conn, $uname, $email, $pass);
}

   
else{
    header("Location: ../signup.php");
    exit();
}