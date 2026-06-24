<?php
session_start();
$error = "";
$success = "";

// 1. Database Connection
$conn = new mysqli("localhost", "root", "", "event_manager");

// 2. Logic to handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_btn'])) {
    $user = mysqli_real_escape_string($conn, $_POST['u_name']);
    $pass = $_POST['u_pass']; 

    $result = $conn->query("SELECT * FROM admin_users WHERE username = '$user'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($pass == $row['password']) { 
            $_SESSION['admin_logged_in'] = $row['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else { $error = "Incorrect Password!"; }
    } else { $error = "User not found!"; }
}

// 3. Logic to handle "Create Account"
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup_btn'])) {
    $user = mysqli_real_escape_string($conn, $_POST['u_name']);
    $pass = mysqli_real_escape_string($conn, $_POST['u_pass']);
    
    $check = $conn->query("SELECT * FROM admin_users WHERE username = '$user'");
    if($check->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        $insert = $conn->query("INSERT INTO admin_users (username, password) VALUES ('$user', '$pass')");
        if($insert) {
            $success = "Account created successfully! Please Login.";
        } else {
            $error = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Radha Events | Secure Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex; flex-direction: column;
            justify-content: center; align-items: center;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            overflow-x: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .auth-box {
            position: relative;
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            z-index: 10;
            text-align: center;
        }

        .auth-box h2 { color: #fff; margin-bottom: 30px; letter-spacing: 2px; }

        .input-group { position: relative; margin-bottom: 30px; }
        
        .input-group input {
            width: 100%; padding: 10px 35px 10px 0; font-size: 16px; color: #fff;
            border: none; border-bottom: 2px solid #fff;
            outline: none; background: transparent; transition: 0.5s;
            box-sizing: border-box;
        }

        .input-group label {
            position: absolute; top: 0; left: 0; padding: 10px 0;
            color: #fff; pointer-events: none; transition: 0.5s;
        }

        .input-group input:focus ~ label, 
        .input-group input:valid ~ label {
            top: -20px; color: #fff; font-size: 12px; font-weight: bold;
        }

        /* Icons Styling */
        .field-icon {
            position: absolute;
            right: 5px;
            top: 12px;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
            z-index: 2;
        }

        .field-icon:hover { color: #fff; }

        #clear-username { display: none; } /* Hidden until typing starts */

        .submit-btn {
            width: 100%; padding: 10px; background: #fff; color: #271fa0;
            border: none; border-radius: 5px; font-size: 18px; font-weight: bold;
            cursor: pointer; transition: 0.3s; margin-top: 10px;
        }
        .submit-btn:hover { background: #7e3ce7; color: #fff; transform: scale(1.05); }

        .toggle-text { color: #fff; margin-top: 20px; display: block; cursor: pointer; text-decoration: underline; font-size: 14px; }
        .msg { font-weight: bold; margin-bottom: 15px; font-size: 14px; }
        .error-msg { color: #ffeb3b; }
        .success-msg { color: #23d5ab; }

        .visme-wrapper { width: 100%; margin-top: 20px; }
    </style>
</head>
<body>
        
<div class="auth-box">
    <div class="logo">
        <img src="images/logo.png" alt="Radha Events Logo" style="max-width: 150px; margin-bottom: 10px;">
    </div>
    
    <h2 id="title-text">LOGIN</h2>
    
    <?php if($error != ""): ?> <p class="msg error-msg"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></p> <?php endif; ?>
    <?php if($success != ""): ?> <p class="msg success-msg"><i class="fas fa-check-circle"></i> <?php echo $success; ?></p> <?php endif; ?>

    <form method="POST" id="auth-form">
        <div class="input-group">
            <input type="text" name="u_name" id="u_name" required autocomplete="off">
            <label>Username</label>
            <i class="fas fa-times-circle field-icon" id="clear-username" title="Clear Text"></i>
        </div>

        <div class="input-group">
            <input type="password" name="u_pass" id="u_pass" required>
            <label>Password</label>
            <i class="fas fa-eye field-icon" id="toggle-password" title="Show Password"></i>
        </div>
        
        <button type="submit" name="login_btn" id="submit-action" class="submit-btn">LOGIN</button>
        
        <a class="toggle-text" onclick="toggleView()" id="toggle-link">New here? Create an Account</a>
    </form>
</div>

<script>
    const usernameInput = document.getElementById('u_name');
    const clearBtn = document.getElementById('clear-username');
    const passwordInput = document.getElementById('u_pass');
    const togglePassBtn = document.getElementById('toggle-password');

    // 1. Clear Username Logic
    usernameInput.addEventListener('input', () => {
        clearBtn.style.display = usernameInput.value.length > 0 ? 'block' : 'none';
    });

    clearBtn.addEventListener('click', () => {
        usernameInput.value = '';
        clearBtn.style.display = 'none';
        usernameInput.focus();
    });

    // 2. Show/Hide Password Logic
    togglePassBtn.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle Icon
        togglePassBtn.classList.toggle('fa-eye');
        togglePassBtn.classList.toggle('fa-eye-slash');
    });

    // 3. Toggle between Login and Signup
    function toggleView() {
        const btn = document.getElementById('submit-action');
        const title = document.getElementById('title-text');
        const link = document.getElementById('toggle-link');

        if (btn.name === "login_btn") {
            btn.name = "signup_btn";
            btn.innerText = "CREATE ACCOUNT";
            title.innerText = "JOIN RADHA EVENTS";
            link.innerText = "Already have an account? Sign In";
        } else {
            btn.name = "login_btn";
            btn.innerText = "LOGIN";
            title.innerText = "LOGIN";
            link.innerText = "New here? Create an Account";
        }
    }
</script>

</body>
</html>