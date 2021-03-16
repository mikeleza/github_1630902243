<?php 

    require_once "connection.php";
    $username = 'usertest';
    $password = '1234';
    $sql= "SELECT * FROM masterlogin WHERE username = '$username' AND password = '$password'";
    $statemnt = $db->query($sql);
    $statemnt->execute();
    $result = $statemnt->fetch(PDO::FETCH_ASSOC);
    $role = $result['role'];

    print_r($role);
    print_r($result);

?>