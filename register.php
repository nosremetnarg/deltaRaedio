<?php
if(isset($_POST['loginButton'])) {
    // login button was pressed
 
}
if(isset($_POST['registerButton'])) {
    // register button was pressed
 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Delta Raedio</title>
</head>
<body>
    <div id="inputContainer" class="">
    <form action="register.php" id="loginForm" method="POST">
    <h2>Login to your account</h2>
    <p>
    <label for="loginUsername">Username</label>
    <input type="text" id="loginUsername" name="loginUsername" placeholder="Bart Simpson" required>
    </p>
    <p>
    <label for="loginPassword">Password</label>
    <input type="password" id="loginPassword" name="loginPassword" placeholder="your password" required>
    </p>
   <button type="submit" name="loginButton">LOG IN</button>
    </form>

    <form action="register.php" id="registerForm" method="POST">
    <h2>Create your account</h2>
    <p>
    <label for="username">Username</label>
    <input type="text" id="username" name="username" placeholder="Bart Simpson" required>
    </p>
    <p>
    <label for="firstName">First Name</label>
    <input type="text" id="firstName" name="firstName" placeholder="Bart " required>
    </p>
    <p>
    <label for="lastName">Last Name</label>
    <input type="text" id="lastName" name="lastName" placeholder="Simpson" required>
    </p>
    <p>
    <label for="email">email</label>
    <input type="email" id="email" name="email" placeholder="Bart@gmail.com" required>
    </p>
    <p>
    <label for="email2">Confirm Email</label>
    <input type="email2" id="email2" name="email2" placeholder="Bart@gmail.com" required>
    </p>


    <p>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="your password" required>
    </p>
    <p>
    <label for="password">Confirm Password</label>
    <input type="password2" id="password2" name="password2" required>
    </p>
   <button type="submit" name="registerButton">SIGN UP</button>
    </form>
    </div>
</body>
</html>