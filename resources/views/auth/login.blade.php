<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <title>Masuk - Hotel Nuansa</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { 
      font-family: 'Inter', 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 20px;
    }
    
    .login-wrapper {
      display: grid;
      grid-template-columns: 1fr 1fr;
      max-width: 1200px;
      width: 100%;
      background: white;
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);
      min-height: 680px;
    }

    @media (max-width: 968px) {
      .login-wrapper {
        grid-template-columns: 1fr;
        max-width: 500px;
      }
      .illustration-panel {
        display: none;
      }
    }

    /* LEFT PANEL - Hotel Image with Overlay */
    .illustration-panel {
      background-image: linear-gradient(135deg, rgba(30, 58, 138, 0.85) 0%, rgba(37, 99, 235, 0.75) 100%),
                        url('/images/logo nuansa - background.jpg');
      background-size: cover;
      background-position: center;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 40px;
    }

    .illustration-panel::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: pulse 8s ease-in-out infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1) rotate(0deg); }
      50% { transform: scale(1.1) rotate(180deg); }
    }

    .hotel-logo {
      position: relative;
      z-index: 10;
      text-align: center;
      color: white;
      padding: 40px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(20px);
      border-radius: 20px;
      border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .hotel-logo img {
      max-width: 200px;
      height: auto;
      filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.5)) brightness(1.2);
      margin-bottom: 20px;
    }

    .hotel-logo h2 {
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 10px;
      text-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
      letter-spacing: 1px;
    }

    .hotel-logo p {
      font-size: 14px;
      font-weight: 300;
      opacity: 0.95;
      letter-spacing: 3px;
      text-transform: uppercase;
    }

    /* RIGHT PANEL - Clean White Form */
    .form-panel {
      background: #ffffff;
      padding: 60px 50px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form-container {
      width: 100%;
      max-width: 400px;
    }

    .form-title {
      font-family: 'Playfair Display', serif;
      font-size: 36px;
      font-weight: 600;
      color: #1e293b;
      margin-bottom: 10px;
      text-align: center;
      letter-spacing: -0.5px;
    }

    .form-subtitle {
      text-align: center;
      color: #64748b;
      font-size: 14px;
      font-weight: 400;
      margin-bottom: 40px;
    }

    /* Modern Material Design Input */
    .input-wrapper {
      position: relative;
      margin-bottom: 24px;
    }

    .input-wrapper i.left-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 16px;
      z-index: 1;
      transition: color 0.3s;
    }

    .input-wrapper i.right-icon {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 16px;
      z-index: 3;
      cursor: pointer;
      transition: color 0.3s;
    }

    .input-wrapper i.right-icon:hover {
      color: #1e3a8a;
    }

    .input-wrapper input {
      width: 100%;
      padding: 16px 50px 16px 50px;
      border: 2px solid #e2e8f0;
      border-radius: 12px;
      font-size: 15px;
      background: #f8fafc;
      color: #1e293b;
      font-weight: 500;
      transition: all 0.3s ease;
      font-family: 'Inter', sans-serif;
    }

    .input-wrapper input::placeholder {
      color: #cbd5e1;
      font-weight: 400;
    }

    .input-wrapper input:focus {
      outline: none;
      border-color: #3b82f6;
      background: white;
      box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .input-wrapper input:focus + i.left-icon {
      color: #3b82f6;
    }

    .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 32px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #475569;
      font-weight: 500;
      font-size: 14px;
    }

    .remember-me input[type="checkbox"] {
      width: 18px;
      height: 18px;
      accent-color: #3b82f6;
      cursor: pointer;
    }

    .forgot-password {
      color: #3b82f6;
      font-weight: 600;
      font-size: 14px;
      text-decoration: none;
      transition: color 0.3s;
    }

    .forgot-password:hover {
      color: #1e40af;
      text-decoration: underline;
    }

    .btn-login {
      width: 100%;
      padding: 16px;
      background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
      color: white;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
      transform: translateY(-2px);
      box-shadow: 0 12px 30px rgba(59, 130, 246, 0.4);
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .footer-text {
      text-align: center;
      margin-top: 32px;
      color: #94a3b8;
      font-size: 12px;
      font-weight: 400;
      padding-top: 24px;
      border-top: 1px solid #e2e8f0;
    }

    .error-message {
      background: #fef2f2;
      border-left: 4px solid #ef4444;
      color: #991b1b;
      padding: 16px;
      border-radius: 12px;
      margin-bottom: 24px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <!-- Left Panel: Hotel Image with Overlay -->
    <div class="illustration-panel">
      <div class="hotel-logo">
        <img src="/images/logo nuansa.jpg" alt="Hotel Nuansa">
        <h2>Hotel Nuansa</h2>
        <p>Management System</p>
      </div>
    </div>

    <!-- Right Panel: Form -->
    <div class="form-panel">
      <div class="form-container">
        <h1 class="form-title">Welcome Back</h1>
        <p class="form-subtitle">Please login to your account</p>

        <form method="POST" action="{{ url('login') }}" id="loginForm">
          @csrf
          
          @if($errors->any())
            <div class="error-message">
              <i class="fas fa-exclamation-circle"></i>
              <span>{{ $errors->first('phone') ?? 'Username atau password salah' }}</span>
            </div>
          @endif

          <!-- Username Input with Icon -->
          <div class="input-wrapper">
            <input 
              type="text" 
              name="phone" 
              id="phone"
              placeholder="Username"
              value="{{ old('phone') }}"
              required
              autofocus
            >
            <i class="fas fa-user left-icon"></i>
          </div>

          <!-- Password Input with Toggle Visibility -->
          <div class="input-wrapper">
            <input 
              type="password" 
              name="password" 
              id="password"
              placeholder="Password"
              required
            >
            <i class="fas fa-lock left-icon"></i>
            <i class="fas fa-eye right-icon" id="togglePassword"></i>
          </div>

          <div class="remember-forgot">
            <label class="remember-me">
              <input type="checkbox" name="remember" id="remember">
              <span>Remember me</span>
            </label>
            <a href="#" class="forgot-password">Forgot password?</a>
          </div>

          <button type="submit" class="btn-login">Login</button>

          <div class="footer-text">
            © 2026 Nuansa Hotel Management System
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    
    togglePassword.addEventListener('click', function() {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      
      // Toggle icon
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
