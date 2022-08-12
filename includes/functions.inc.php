


<?php

function emptyInput($username, $email, $psw, $pswRepeat){

    $result;

    if(empty($username) || empty($email) || empty($psw) || empty($pswRepeat) ){

        $result = true;
    }

    else{
        $result = false;
    }
    
    return $result;
}

function invalidUsername($username){

    $result;

    if(!preg_match("/^[a-zA-Z0-9]*$/",$username)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}
    function invalidEmail($email){
        $result;
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }
    function passMatch($pass, $rpass){
        $result;

        if($pass !== $rpass){
            $result = true;
        }
        else{
            $result = false;
        }
        return $result;
    }

    function  createUser($conn, $uname, $email, $pass){

        $stmt = $conn ->prepare("INSERT INTO user (user_Uname, user_Email, user_Password)
        VALUES (:username, :email, :psw) ");

        $hashedPws = password_hash($pass, PASSWORD_DEFAULT);

        $stmt ->bindValue(':username' , $uname);
        $stmt ->bindValue(':email' , $email);
        $stmt ->bindValue(':psw' , $hashedPws);
       
        $result = $stmt ->execute();

        header("Location: ../signup.php?error=none");
        exit();
    }
    function userExist($conn, $username){

        $stmt =$conn->prepare("SELECT * FROM user WHERE user_Uname = :username");
        $stmt ->bindParam(':username', $username);
        $stmt  ->execute();

        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!$data){
            $result = false;
        }
        else{
            $result;
        }
        return $result;
    }

   function emptyInputLogin($username, $password){

    $result;

    if(empty($username) || empty($password)  ){

        $result = true;
    }

    else{
        $result = false;
    }
    
    return $result;

   }

  function loginUser($conn, $uname, $password){



        $stmt = $conn->prepare("SELECT * FROM user WHERE user_Uname = :uname");
        $stmt ->bindParam(':uname', $uname);
        $stmt  ->execute();
        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$userDetails){
            header("Location: ../login.php?error=wronglog");
            exit();
        }

        $pwdHashed = $userDetails["user_Password"];
        $checkPwd = password_verify($password, $pwdHashed);

        if($checkPwd === false){
            header("Location: ../login.php?error=wronglog");
            exit();
        }
        else if($checkPwd === true){
            session_start();
            $_SESSION["userid"] = $userDetails["user_id"];
            $_SESSION["username"] = $userDetails["user_Uname"];

            header("Location: ../loggedInUser.php");
            exit();
            
        }
       
  }
