
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Tracker - Welcome</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            overflow-x: hidden;
            color: #333;
        }

        /* Background Elements */
        .bg-circles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.6;
        }

        .circle-1 {
            width: 500px;
            height: 500px;
            background: linear-gradient(45deg, #4CAF50, #8BC34A);
            top: -250px;
            left: -100px;
            animation: float 15s infinite ease-in-out;
        }

        .circle-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, #7986CB, #90CAF9);
            bottom: -150px;
            left: 10%;
            animation: float 20s infinite ease-in-out reverse;
        }

        .circle-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #9C27B0, #E91E63);
            top: 30%;
            right: -100px;
            animation: float 18s infinite ease-in-out 2s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            25% {
                transform: translateY(-20px) rotate(5deg);
            }
            50% {
                transform: translateY(0) rotate(0deg);
            }
            75% {
                transform: translateY(20px) rotate(-5deg);
            }
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 1s ease;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background-color: #4CAF50;
            border-radius: 50%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logo-icon::after {
            content: '';
            position: absolute;
            width: 30px;
            height: 30px;
            background-color: #8BC34A;
            border-radius: 50%;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            gap: 30px;
            padding: 40px 0;
        }

        .welcome-text {
            max-width: 800px;
        }

        .welcome-text h1 {
            font-size: 48px;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            animation: fadeInUp 1s ease 0.2s both;
        }

        .welcome-text h1 .highlight {
            color: #4CAF50;
            position: relative;
        }

        .welcome-text p {
            font-size: 18px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 30px;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin: 20px 0 40px;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease 0.6s both;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            width: 280px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background-color: #E8F5E9;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
            color: #4CAF50;
            font-size: 28px;
        }

        .feature-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        .feature-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Buttons */
        .auth-buttons {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            animation: fadeInUp 1s ease 0.8s both;
        }

        .btn {
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border: none;
        }

        .btn::after {
            content: '';
            position: absolute;
            width: 150%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            top: 0;
            left: -150%;
            transform: skew(45deg);
            transition: all 0.5s ease;
        }

        .btn:hover::after {
            left: -30%;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .btn-primary {
            background: linear-gradient(45deg, #4CAF50, #8BC34A);
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #4CAF50;
            border: 2px solid #4CAF50;
        }

        /* Heart Animation */
        .heart-container {
            position: absolute;
            right: 10%;
            top: 40%;
            animation: heartBeat 2s infinite, float 6s infinite alternate;
        }

        .heart {
            width: 100px;
            height: 100px;
            background-color: #FF5252;
            border-radius: 50%;
            position: relative;
            transform: rotate(-45deg);
            animation: pulse 1.5s ease infinite;
        }

        .heart::before, .heart::after {
            content: '';
            width: 100px;
            height: 100px;
            background-color: #FF5252;
            border-radius: 50%;
            position: absolute;
        }

        .heart::before {
            top: -50px;
        }

        .heart::after {
            left: 50px;
        }

        .heart-face {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            transform: rotate(45deg);
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .eyes {
            display: flex;
            gap: 30px;
            position: relative;
            top: 15px;
        }

        .eye {
            width: 15px;
            height: 15px;
            background-color: #333;
            border-radius: 50%;
        }

        .mouth {
            width: 30px;
            height: 15px;
            background-color: #333;
            border-radius: 0 0 15px 15px;
            position: relative;
            top: 30px;
        }

        .arm {
            width: 40px;
            height: 10px;
            background-color: #333;
            position: absolute;
            border-radius: 10px;
        }

        .arm-left {
            transform: rotate(30deg);
            left: -40px;
            top: 50px;
        }

        .arm-right {
            transform: rotate(-30deg);
            right: -40px;
            top: 50px;
        }

        .leg {
            width: 10px;
            height: 30px;
            background-color: #333;
            position: absolute;
            border-radius: 10px;
        }

        .leg-left {
            bottom: -20px;
            left: 30px;
        }

        .leg-right {
            bottom: -20px;
            right: 30px;
        }

        @keyframes pulse {
            0%, 100% {
                transform: rotate(-45deg) scale(1);
            }
            50% {
                transform: rotate(-45deg) scale(1.1);
            }
        }

        @keyframes heartBeat {
            0%, 100% {
                transform: scale(1);
            }
            15% {
                transform: scale(1.2);
            }
            30% {
                transform: scale(1);
            }
            45% {
                transform: scale(1.2);
            }
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modal Styles */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 15px;
            width: 400px;
            max-width: 90%;
            transform: translateY(50px);
            transition: all 0.3s ease;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .modal.active .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-header h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .modal-body {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #666;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .modal-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-footer a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 14px;
        }

        .modal-footer a:hover {
            text-decoration: underline;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: #999;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: #333;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .heart-container {
                display: none;
            }

            .main-content {
                padding: 20px 0;
            }

            .welcome-text h1 {
                font-size: 36px;
            }

            .welcome-text p {
                font-size: 16px;
            }

            .features {
                flex-direction: column;
                align-items: center;
            }

            .auth-buttons {
                flex-direction: column;
                width: 100%;
                max-width: 280px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Circles -->
    <div class="bg-circles">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>

    <div class="container">
        <!-- Header -->
        <header>
            <div class="logo">
                <div class="logo-icon"></div>
                <div class="logo-text">HealthTrack</div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <div class="welcome-text">
                <h1>Hello! I'm your <span class="highlight">health tracker</span></h1>
                <p>I am a health tracker that monitors your fitness metrics like BMI, BMR, blood pressure, and oxygen levels to help you stay on top of your health goals.</p>
            </div>

            <div class="features">
			    <a href="dashboard.php" style="text-decoration: none; color: inherit;">
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Monitor Metrics</h3>
                    <p>Track your BMI, BMR, blood pressure, oxygen levels and more in one place with easy-to-read charts.</p>
                </div>
				</a>
                <div class="feature-card">
				<a href="goals.php" style="text-decoration: none; color: inherit;">
                    <div class="feature-icon">🎯</div>
                    <h3>Set Goals</h3>
                    <p>Create personalized health goals and track your progress with customizable milestones.</p>
                </div>
				<a href="chatbot.php" style="text-decoration: none; color: inherit;">
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Stay Connected</h3>
                    <p>Get notifications and insights about your health metrics anywhere, anytime.</p>
                </div>
				</a>
            </div>

            <div class="auth-buttons">
                <a href="login.php"><button class="btn btn-primary" id="login-btn">LOGIN</button></a>
                <a href="signup.php"><button class="btn btn-secondary" id="signup-btn">SIGN UP</button></div></a>
            </div>
        </div>
    </div>

    <!-- Heart Animation -->
    <div class="heart-container">
        <div class="heart">
            <div class="heart-face">
                <div class="eyes">
                    <div class="eye"></div>
                    <div class="eye"></div>
                </div>
                <div class="mouth"></div>
            </div>
        </div>
        <div class="arm arm-left"></div>
        <div class="arm arm-right"></div>
        <div class="leg leg-left"></div>
        <div class="leg leg-right"></div>
    </div>

    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-login">&times;</span>
            <div class="modal-header">
                <h2>Welcome Back</h2>
                <p>Log in to continue your health journey</p>
            </div>
            <div class="modal-body">
                <form id="login-form">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <input type="password" id="login-password" class="form-control" placeholder="Enter your password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" id="forgot-password">Forgot Password?</a>
                <button class="btn btn-primary" type="submit" form="login-form">LOGIN</button>
            </div>
        </div>
    </div>

    <!-- Signup Modal -->
    <div class="modal" id="signup-modal">
        <div class="modal-content">
            <span class="close-modal" id="close-signup">&times;</span>
            <div class="modal-header">
                <h2>Create Account</h2>
                <p>Start your health journey today</p>
            </div>
            <div class="modal-body">
                <form id="signup-form">
                    <div class="form-group">
                        <label for="signup-name">Full Name</label>
                        <input type="text" id="signup-name" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-email">Email</label>
                        <input type="email" id="signup-email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-password">Password</label>
                        <input type="password" id="signup-password" class="form-control" placeholder="Create a password" required>
                    </div>
                    <div class="form-group">
                        <label for="signup-confirm">Confirm Password</label>
                        <input type="password" id="signup-confirm" class="form-control" placeholder="Confirm your password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="dashboard.html" id="have-account">Already have an account?</a>
                <button class="btn btn-primary" type="submit" form="signup-form">SIGN UP</button>
            </div>
        </div>
    </div>
