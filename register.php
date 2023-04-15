<?php
    require_once("connection.php");

    // FETCH USER
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    function encrypt_decrypt($string, $action = 'encrypt'){ // ENCRYPT DECRYPT METHOD 
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'AA74CDCC2BBRT935136HH7B63C27'; 
        $secret_iv = '5fgf5HJ5g27'; 
        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 16); 
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    // REGISTER DITEKAN
    if (isset($_GET["registerbtn"])) {
        $username = $_GET["username"];
        $email = $_GET["email"];
        $password = $_GET["password"];
        $confirm = $_GET["confirm"];

        $canRegister = true;

        if ($username != "") {
            if($email != ""){
                // CHECK USERNAME KEMBAR
                foreach($users as $key => $value){
                    if($value["email"] == $email){ 
                        $canRegister = false; break;
                    }
                }
                
                if ($canRegister) {
                    if ($password != "") {
                        if ($password == $confirm) {
                            $encrypted_password = encrypt_decrypt($password, 'encrypt'); // ENKRIPSI PASS
                            // BERHASIL REGISTER
                            $stmt = $conn->prepare("INSERT INTO users(username, email, password) VALUES(?,?,?)");
                            $stmt->bind_param("sss", $username, $email, $encrypted_password);
                            $result =$stmt->execute();
                            
                            echo "<script> alert('$username berhasil daftar sebagai user LIKENEWCAR!')</script>";
                        } else {echo "<script> alert('Confirm Password Salah atau kosong'); </script>";}
                    } else {echo "<script> alert('Password tidak boleh kosong'); </script>";}
                }else{echo "<script> alert('Email sudah dipakai!'); </script>";}
                    
            }else {echo "<script> alert('Email kosong!'); </script>";}
        } else {echo "<script> alert('Username tidak boleh kosong'); </script>"; }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="bootstrap.bundle.min.js / bootstrap.bundle.js" rel="stylesheet">
    <!-- CDN Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS Style -->
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("./Asset/homeAsset/registerBG.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: calc(100vh);
            padding: 5% 0;
        }

        .indexButton {
            background-color: rgb(0, 0, 0, 0);
            border: none;
            color: white;
        }

        .indexButton:hover {
            color: Blue;
        }

        .content {
            height: calc(100vh - 98px);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: -10vh;
        }
    </style>
</head>

<body class="text-center">
    <div class="content">
        <div class="leftContainer" style="width: 60%;">
            <div class="innerContainer text-center">
                <div class="formContainer">
                    <!-- REGISTER FORM -->
                    <form action="#" method="GET">
                        <div class="leftForm">
                            <img class="mb-4" src="./Asset/homeAsset/userIcon.png" alt="" width="150px" height="150px">
                            <h1 class="h3 mb-3 fw-normal" style="color:white;">Create New Account</h1>
    
                            <div class="form-floating col-3 mx-auto w-50"> <!-- USERNAME -->
                                <input type="text" class="form-control" id="tb_username" placeholder="Username" name="username">
                                <label for="floatingInput">Username</label>
                            </div>
                            <div class="form-floating col-3 mx-auto w-50"><!-- NAME -->
                                <input type="text" class="form-control" id="tb_email" placeholder="Email Address" name="email">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="form-floating col-3 mx-auto w-50"><!-- PASSWORD -->
                                <input type="password" class="form-control" id="tb_password" placeholder="Password" name="password">
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div class="form-floating col-3 mx-auto w-50"><!-- CONFIRM -->
                                <input type="password" class="form-control" id="tb_confirm" placeholder="Confirm Password" name="confirm">
                                <label for="floatingPassword">Confirm Password</label>
                            </div>
                            <button class="w-10 btn btn-lg btn-warning mt-3" name="registerbtn">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGIN FORM -->
    <form action="index.php" method="GET">
        <h6 class="mb-0 text-light fw-light">Already have account? <button class="indexButton" name="index">Click Here</button></h6>
        <h6 class="mt-2 mb-0 text-light fw-normal">© 2020–2021</h6>
    </form>

</body>
</html>