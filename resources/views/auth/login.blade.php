<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول | النظام الإداري</title>
    
    <!-- Cairo Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.rtl.min.css">
    
    <!-- Remixicon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #e74c3c;
            --primary-dark: #c0392b;
            --secondary: #2c3e50;
            --light: #ecf0f1;
            --dark: #1a1a1a;
            --success: #2ecc71;
            --card-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Cairo', sans-serif;
            background: #f7f7f7;
            position: relative;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            background: var(--primary);
            opacity: 0.2;
            animation: float 8s infinite ease-in-out;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
            }
            25% {
                transform: translateY(-20px) translateX(10px);
            }
            50% {
                transform: translateY(0) translateX(20px);
            }
            75% {
                transform: translateY(20px) translateX(10px);
            }
        }
        
        .login-container {
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .login-card {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }
        
        .login-header {
            background: var(--primary);
            padding: 30px 25px;
            text-align: center;
            position: relative;
        }
        
        .login-header:after {
            content: "";
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            height: 40px;
            background: var(--primary);
            transform: skewY(-3deg);
        }
        
        .login-header h1 {
            color: white;
            margin: 0;
            font-weight: 700;
            font-size: 28px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .login-body {
            padding: 45px 30px 30px;
        }
        
        .login-form {
            margin-top: 15px;
        }
        
        .form-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .form-control {
            font-family: 'Cairo', sans-serif;
            height: 50px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            box-shadow: none;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.15);
        }
        
        .form-control:focus + .form-label,
        .form-control:not(:placeholder-shown) + .form-label {
            top: -10px;
            font-size: 12px;
            color: var(--primary);
            background: white;
            padding: 0 5px;
        }
        
        .form-label {
            position: absolute;
            top: 13px;
            right: 20px;
            color: #6c757d;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .form-button {
            width: 100%;
            height: 50px;
            margin-top: 15px;
            border-radius: 8px;
            border: none;
            background: var(--primary);
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(231, 76, 60, 0.3);
        }
        
        .form-button:hover {
            background: var(--primary-dark);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.4);
            transform: translateY(-2px);
        }
        
        .form-button:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(231, 76, 60, 0.4);
        }
        
        .login-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }
        
        .remember-check {
            display: flex;
            align-items: center;
        }
        
        .custom-checkbox {
            width: 20px;
            height: 20px;
            margin-left: 8px;
            border-radius: 4px;
            border: 2px solid #ced4da;
            display: inline-block;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .custom-checkbox.checked {
            background: var(--primary);
            border-color: var(--primary);
        }
        
        .custom-checkbox.checked:after {
            content: '\2714';
            position: absolute;
            color: white;
            font-size: 12px;
            top: 0;
            left: 4px;
        }
        
        #checkbox {
            display: none;
        }
        
        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        
        .brand-logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: white;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .logo-icon {
            font-size: 45px;
            color: var(--primary);
        }
        
        .error-message {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--primary);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            display: none;
        }
        
        /* Password visibility toggle */
        .password-toggle {
            position: absolute;
            top: 13px;
            left: 15px;
            color: #6c757d;
            cursor: pointer;
            font-size: 18px;
        }
        
        /* Success animation */
        @keyframes checkmark {
            0% {
                height: 0;
                width: 0;
                opacity: 0;
            }
            40% {
                height: 0;
                width: 10px;
                opacity: 1;
            }
            100% {
                height: 20px;
                width: 10px;
                opacity: 1;
            }
        }
        
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            position: relative;
            display: none;
        }
        
        .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid var(--success);
        }
        
        .check-icon::before {
            top: 43px;
            left: 19px;
            transform: rotate(45deg);
            position: absolute;
            content: "";
            width: 10px;
            height: 4px;
            background-color: var(--success);
        }
        
        .check-icon::after {
            top: 36px;
            left: 26px;
            transform: rotate(135deg);
            position: absolute;
            content: "";
            width: 25px;
            height: 4px;
            background-color: var(--success);
            animation: checkmark 0.3s ease-in-out 0.2s forwards;
        }
        
        /* Loading animation */
        .loading {
            display: none;
            width: 30px;
            height: 30px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            position: absolute;
            top: calc(50% - 15px);
            left: calc(50% - 15px);
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Particles background -->
    <div class="particles-container" id="particles"></div>
    
    <div class="login-container">
        <div class="login-card" id="loginCard">
            <div class="login-header">
                <div class="brand-logo">
                    <i class="ri-building-4-line logo-icon"></i>
                </div>
                <h1>مرحباً بك</h1>
            </div>
            
            <div class="login-body">
                <div class="error-message" id="errorMessage">
                    <i class="ri-error-warning-line me-2"></i>
                    بيانات الدخول غير صحيحة، الرجاء المحاولة مرة أخرى.
                </div>
                
                <div class="success-checkmark" id="successCheckmark">
                    <div class="check-icon"></div>
                </div>
                
                <form class="login-form" id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <input id="email" type="email" class="form-control" name="email" placeholder=" " required autofocus autocomplete="username">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                    </div>
                    
                    <div class="form-group">
                        <input id="password" type="password" class="form-control" name="password" placeholder=" " required autocomplete="current-password">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <i class="ri-eye-line password-toggle" id="passwordToggle"></i>
                    </div>
                    
                    <div class="login-footer">
                        <div class="remember-check">
                            <input type="checkbox" id="checkbox" name="remember">
                            <span class="custom-checkbox" id="customCheckbox"></span>
                            <label for="checkbox">تذكرني</label>
                        </div>
                        
                    </div>
                    
                    <button type="submit" class="form-button" id="loginButton">
                        <span>تسجيل الدخول</span>
                        <div class="loading" id="loading"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        // Create particles
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 15;
            
            for(let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size
                const size = Math.random() * 40 + 10;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}%`;
                particle.style.top = `${Math.random() * 100}%`;
                
                // Random animation delay
                particle.style.animationDelay = `${Math.random() * 8}s`;
                
                particlesContainer.appendChild(particle);
            }
            
            // Custom checkbox functionality
            const checkbox = document.getElementById('checkbox');
            const customCheckbox = document.getElementById('customCheckbox');
            
            customCheckbox.addEventListener('click', function() {
                checkbox.checked = !checkbox.checked;
                
                if(checkbox.checked) {
                    customCheckbox.classList.add('checked');
                } else {
                    customCheckbox.classList.remove('checked');
                }
            });
            
            // Password visibility toggle
            const passwordField = document.getElementById('password');
            const passwordToggle = document.getElementById('passwordToggle');
            
            passwordToggle.addEventListener('click', function() {
                if(passwordField.type === 'password') {
                    passwordField.type = 'text';
                    passwordToggle.classList.remove('ri-eye-line');
                    passwordToggle.classList.add('ri-eye-off-line');
                } else {
                    passwordField.type = 'password';
                    passwordToggle.classList.remove('ri-eye-off-line');
                    passwordToggle.classList.add('ri-eye-line');
                }
            });
            
            // Login form submission (for demo)
            const loginForm = document.getElementById('loginForm');
            const loginButton = document.getElementById('loginButton');
            const buttonText = loginButton.querySelector('span');
            const loading = document.getElementById('loading');
            const errorMessage = document.getElementById('errorMessage');
            const successCheckmark = document.getElementById('successCheckmark');
            
            loginForm.addEventListener('submit', function(e) {
                // This is for demo purposes only - you would remove this in production
                // as the form would actually submit to your backend
                // e.preventDefault();
                
                // Show loading animation
                buttonText.style.opacity = '0';
                loading.style.display = 'block';
                
                // Simulate API call for demo purposes
                // In a real app, this would be replaced by the actual form submission
                // setTimeout(function() {
                //     loading.style.display = 'none';
                //     
                //     const email = document.getElementById('email').value;
                //     const password = document.getElementById('password').value;
                //     
                //     // Demo validation
                //     if(email === 'demo@example.com' && password === 'password') {
                //         // Success login
                //         loginForm.style.display = 'none';
                //         successCheckmark.style.display = 'block';
                //         
                //         // Redirect after success display
                //         setTimeout(function() {
                //             window.location.href = '/dashboard';
                //         }, 1500);
                //     } else {
                //         // Failed login
                //         buttonText.style.opacity = '1';
                //         errorMessage.style.display = 'block';
                //         
                //         // Shake animation for error
                //         loginCard.classList.add('shake');
                //         setTimeout(function() {
                //             loginCard.classList.remove('shake');
                //         }, 500);
                //     }
                // }, 1500);
            });
        });
    </script>
</body>
</html>