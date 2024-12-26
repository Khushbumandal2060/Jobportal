<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: #e4e9f7;
        }
        h2 {
            text-align: center;
            color: darkslategray;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 90vh;
        }
        .box {
            background: #fdfdfd;
            display: flex;
            flex-direction: column;
            padding: 25px 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-box {
            width: 450px;
            margin: 0px 10px;
        }
        .form-box header {
            font-size: 25px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid #e6e6e6;
            margin-bottom: 10px;
        }
        .form-box form .field {
            display: flex;
            margin-bottom: 10px;
            flex-direction: column;
        }
        .form-box form .input input {
            height: 40px;
            width: 100%;
            font-size: 16px;
            padding: 0 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            outline: none;
        }
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-container input {
            flex: 1;
            height: 40px;
            padding-right: 40px; /* Space for the button */
        }
        .password-container button {
            position: absolute;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: darkslategray;
            padding: 0;
            height: 100%;
        }
        .btn {
            height: 35px;
            background: darkslategray;
            border: 0;
            border-radius: 5px;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            transition: all .3s;
            margin-top: 10px;
            padding: 0px 10px;
        }
        .btn:hover {
            opacity: 0.82;
        }
        .links {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <h2>Login</h2>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="field input">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" id="togglePassword">👁️</button>
                    </div>
                </div>
                <div class="field input">
                    <input type="submit" class="btn" name="submit" value="Login">
                </div>
                <div class="link">
                    <p>Don't have an account? <a href="register.php">Register here</a>.</p>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
        });
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Example of processing login (replace with actual database logic)
        if ($username === 'admin' && $password === 'password') {
            echo '<script>alert("Login successful!");</script>';
        } else {
            echo '<script>alert("Invalid username or password.");</script>';
        }
    }
    ?>
</body>
</html>
