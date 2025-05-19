<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #4dbcc4 0%, #2f8a8f 100%);
            overflow: hidden;
            position: relative;
        }

        .bubble-1 {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -200px;
            left: -200px;
        }

        .bubble-2 {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            bottom: -150px;
            left: 10%;
        }

        .container {
            display: flex;
            width: 900px;
            height: 500px;
        }

        .left-panel {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
        }

        .right-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 400px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            animation: slideIn 1.5s ease forwards;
        }

        @keyframes slideIn {
            0% {
                transform: translateX(100%);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        h1 {
            font-size: 60px;
            font-weight: 600;
            line-height: 1.1;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 span {
            display: inline-block;
            color: white;
            text-shadow:
                0 0 5px rgba(255, 255, 255, 0.8),
                0 0 10px rgba(255, 255, 255, 0.5);
        }

        .subtitle {
            font-size: 18px;
            font-weight: 300;
            margin-bottom: 30px;
            text-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 32px;
            font-weight: 500;
            margin-bottom: 30px;
            color: #1f5e63;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.8);
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }

        .btn {
            width: 100%;
            padding: 15px;
            border-radius: 50px;
            border: none;
            background: linear-gradient(135deg, #2f8a8f 0%, #1f5e63 100%);
            color: white;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes moveLeftRight {
            0% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(-50px);
            }

            100% {
                transform: translateX(0);
            }
        }

        @keyframes animateForm {
            0% {
                transform: translateX(100%);
            }

            50% {
                transform: translateX(-10%);
            }

            75% {
                transform: translateX(5%);
            }

            100% {
                transform: translateX(0);
            }
        }

        .animated-text {
            position: relative;
            display: inline-block;
        }

        .animated-text span {
            animation: glow 2s infinite;
        }

        @keyframes glow {

            0%,
            100% {
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.8);
            }

            50% {
                text-shadow: 0 0 20px rgba(255, 255, 255, 1), 0 0 30px rgba(255, 255, 255, 0.5);
            }
        }

        .animated-btn {
            position: relative;
            overflow: hidden;
        }

        .animated-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
        }

        .animated-btn:hover::before {
            left: 100%;
        }
    </style>
</head>

<body>
    <div class="bubble-1"></div>
    <div class="bubble-2"></div>

    <div class="container">
        <div class="left-panel">
            <h1 class="animated-text">Hello Friend!</h1>
            <p class="subtitle">Enter your personal details<br>and start journey with us</p>
        </div>

        <div class="right-panel">
            <div class="form-container" id="formContainer">
                <h2 class="form-title">Create Account</h2>
                <form id="signupForm" method="POST" action="signupui.php">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input
  type="password"
  name="password"
  class="form-control"
  placeholder="Password"
  required
  pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}"
  title="Password must be at least 8 characters long, include uppercase, lowercase, a number, and a special character."
>

                    </div>
                    <button type="submit" class="btn animated-btn" id="signupBtn">Sign up</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const title = document.querySelector('.animated-text');
            const text = title.textContent;
            title.innerHTML = '';
            for (let i = 0; i < text.length; i++) {
                const span = document.createElement('span');
                span.textContent = text[i];
                span.style.animationDelay = `${i * 0.1}s`;
                title.appendChild(span);
            }

            const signupBtn = document.getElementById('signupBtn');
            signupBtn.addEventListener('mouseover', function() {
                this.style.animation = 'pulse 0.5s infinite';
            });
            signupBtn.addEventListener('mouseout', function() {
                this.style.animation = '';
            });

            const formContainer = document.getElementById('formContainer');
            setTimeout(() => {
                formContainer.style.animation = 'animateForm 2s ease-in-out';
                formContainer.style.animationIterationCount = '2';
            }, 500);
        });
    </script>

</body>

</html>