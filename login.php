<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Health Tracker</title>
    <style>
        :root {
            --dark-blue: #263238;
            --green: #4CD4A1;
            --teal: #267B76;
            --gradient-bg: linear-gradient(135deg, var(--teal) 0%, #1E5F5C 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f5f5f5;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 600px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            background: var(--gradient-bg);
            position: relative;
            color: white;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .blob {
            position: absolute;
            background-color: var(--green);
            border-radius: 50%;
        }

        .blob-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            opacity: 0.7;
        }

        .blob-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
            opacity: 0.7;
        }

        .blob-3 {
            width: 150px;
            height: 150px;
            bottom: -50px;
            left: 50px;
            opacity: 0.5;
        }

        .left-content {
            position: relative;
            z-index: 1;
        }

        .left-content h1 {
            font-size: 3.5rem;
            margin-bottom: 15px;
        }

        .left-content p {
            font-size: 1.2rem;
            opacity: 0.9;
            line-height: 1.6;
        }

        .right-panel {
            flex: 1;
            background-color: var(--dark-blue);
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h2 {
            color: white;
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-header p {
            color: var(--green);
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #999;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 30px;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            background-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 2px rgba(76, 212, 161, 0.3);
        }

        .login-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 30px;
            background: linear-gradient(to right, var(--green), var(--teal));
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(76, 212, 161, 0.2);
        }

        .login-footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
        }

        .login-footer a {
            color: var(--green);
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: all 0.3s ease;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .left-content,
        .login-header,
        .form-group,
        .login-button,
        .login-footer {
            animation: fadeIn 0.8s ease forwards;
        }

        .login-header {
            animation-delay: 0.2s;
        }

        .form-group:nth-child(1) {
            animation-delay: 0.4s;
        }

        .form-group:nth-child(2) {
            animation-delay: 0.6s;
        }

        .login-button {
            animation-delay: 0.8s;
        }

        .login-footer {
            animation-delay: 1s;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
                max-width: 90%;
            }

            .left-panel {
                padding: 40px 30px;
            }

            .right-panel {
                padding: 40px 30px;
            }

            .left-content h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left-panel">
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>
            <div class="left-content">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal information</p>
            </div>
        </div>
        <div class="right-panel">
            <div class="login-form">
                <div class="login-header">
                    <h2>LOGIN</h2>
                    <p>PLEASE ENTER YOUR DETAILS</p>
                </div>
                <form id="loginForm" action="loginpageui.php" method="post">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="login-button">Login</button>
                </form>
                <div class="login-footer">
                    <span>Don't have an account?</span>
                    <a href="signup.php">Register</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                if (!email || !password) {
                    e.preventDefault();
                    alert('Please fill in all fields');
                }
            });
        });
    </script>

</body>

</html>