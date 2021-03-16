<?php 

    require_once 'connection.php';

    session_start();

    if (isset($_POST['btn_login'])) {
        $username = $_POST['txt_username']; // textbox name 
        $password = $_POST['txt_password']; // password


        $sql= "SELECT * FROM masterlogin WHERE username = '$username' AND password = '$password'";
        $statemnt = $db->query($sql);
        $statemnt->execute();
        $result = $statemnt->fetch(PDO::FETCH_ASSOC);
        $role = $result['role'];
   
  
        if (empty($username)) {
            $errorMsg[] = "Please enter username";
        } else if (empty($password)) {
            $errorMsg[] = "Please enter password";    
        } else if ($username AND $password) {
            try {
                $select_stmt = $db->prepare("SELECT username, password, role FROM masterlogin WHERE username = :uusername AND password = :upassword AND role = :urole");
                $select_stmt->bindParam(":uusername", $username);
                $select_stmt->bindParam(":upassword", $password);
                $select_stmt->bindParam(":urole", $role);
                $select_stmt->execute(); 

                while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $dbusername = $row['username'];
                    $dbpassword = $row['password'];
                    $dbrole = $row['role'];
                }
                if ($username != null AND $password != null AND $role != null) {
                    if ($select_stmt->rowCount() > 0) {
                        if ($username == $dbusername AND $password == $dbpassword AND $role == $dbrole) {
                            switch($dbrole) {
                                case 'admin':
                                    $_SESSION['admin_login'] = $username;
                                    $_SESSION['success'] = "Admin... Successfully Login...";
                                    header("location: admin/admin_home.php");
                                break;
                                case 'employee':
                                    $_SESSION['employee_login'] = $username;
                                    $_SESSION['success'] = "Employee... Successfully Login...";
                                    header("location: employee/employee_home.php");
                                break;
                                case 'user':
                                    $_SESSION['user_login'] = $username;
                                    $_SESSION['success'] = "User... Successfully Login...";
                                    header("location: user/user_home.php");
                                break;
                                default:
                                    $_SESSION['error'] = "Wrong username or password or role";
                                    header("location: index.php");
                            }
                        }
                    } else {
                        $_SESSION['error'] = "Wrong username or password or role";
                        header("location: index.php");
                    }
                }
            } catch(PDOException $e) {
                $e->getMessage();
            }
        }
    }

?>