<?php
    require('../model/m_user.php');
    
    session_start();

    if( isset( $_POST ) ){
        $email = $_POST['email'];
        $password = trim($_POST['password']) ;
        $firstname = trim($_POST['firstname']) ;
        $lastname = trim($_POST['lastname']);
        $username =$firstname . ' ' . $lastname;
        $role = 0;
        
        $new_user = new User();
        
        $new_user->create_1_user( $email, $password, $username, $role );

        header("Location: ../index.php");
    }



?>