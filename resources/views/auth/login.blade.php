<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <title>Masuk - Hotel Nuansa</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { 
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #ffffff;
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
      border-radius: 32px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
      min-height: 650px;
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

    .illustration-panel {
      background: linear-gradient(135deg, rgba(30, 58, 138, 0.65) 0%, rgba(59, 130, 246, 0.65) 100%),
                  url('/images/hotel-building.jpg');
      background-size: cover;
      background-position: center;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 60px 40px;
    }

    .illustration-content {
      position: relative;
      z-index: 10;
      text-align: center;
      color: white;
    }

    .illustration-icon {
      font-size: 180px;
      color: rgba(255, 255, 255, 0.98);
      text-shadow: 0 15px 40px rgba(0, 0, 0, 0.6);
      animation: float 3s ease-in-out infinite;
      filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.4));
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }

    .illustration-text h2 {
      font-size: 48px;
      font-weight: 900;
      margin-top: 35px;
      margin-bottom: 16px;
      text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
      letter-spacing: 2px;
      line-height: 1.2;
    }

    .illustration-text p {
      font-size: 19px;
      opacity: 0.98;
      font-weight: 700;
      text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
      letter-spacing: 1px;
      line-height: 1.5;
    }

    .form-panel {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
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
      font-size: 32px;
      font-weight: 900;
      color: #1e3a8a;
      margin-bottom: 40px;
      text-align: center;
    }

    .input-wrapper {
      position: relative;
      margin-bottom: 20px;
    }

    .input-wrapper i {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #64748b;
      font-size: 18px;
    }

    .input-wrapper input {
      width: 100%;
      padding: 16px 20px 16px 55px;
      border: none;
      border-radius: 16px;
      font-size: 16px;
      background: white;
      color: #1e293b;
      font-weight: 600;
      transition: all 0.3s;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .input-wrapper input::placeholder {
      color: #94a3b8;
      font-weight: 500;
    }

    .input-wrapper input:focus {
      outline: none;
      box-shadow: 0 4px 16px rgba(30, 58, 138, 0.15);
      transform: translateY(-2px);
    }

    .remember-forgot {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .remember-me {
      display: flex;
      align-items: center;
      gap: 8px;
      color: #1e3a8a;
      font-weight: 600;
      font-size: 14px;
    }

    .remember-me input[type="radio"] {
      width: 18px;
      height: 18px;
      accent-color: #1e3a8a;
      cursor: pointer;
    }

    .forgot-password {
      color: #1e3a8a;
      font-weight: 700;
      font-size: 14px;
      text-decoration: none;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    .btn-login {
      width: 100%;
      padding: 18px;
      background: #1e3a8a;
      color: white;
      font-size: 18px;
      font-weight: 900;
      border: none;
      border-radius: 16px;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 8px 20px rgba(30, 58, 138, 0.3);
    }

    .btn-login:hover {
      background: #1e40af;
      transform: translateY(-3px);
      box-shadow: 0 12px 28px rgba(30, 58, 138, 0.4);
    }

    .social-login {
      text-align: center;
      margin-top: 30px;
    }

    .social-login p {
      color: #1e3a8a;
      font-weight: 600;
      margin-bottom: 16px;
      font-size: 14px;
    }

    .social-icons {
      display: flex;
      gap: 16px;
      justify-content: center;
    }

    .social-icon {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: white;
      color: #1e3a8a;
      font-size: 20px;
      transition: all 0.3s;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      cursor: pointer;
    }

    .social-icon:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .error-message {
      background: white;
      border-left: 4px solid #dc2626;
      color: #991b1b;
      padding: 16px;
      border-radius: 12px;
      margin-bottom: 24px;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .visit-site {
      position: absolute;
      bottom: 30px;
      left: 30px;
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(12px);
      color: white;
      padding: 12px 24px;
      border-radius: 12px;
      font-weight: 700;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border: 2px solid rgba(255, 255, 255, 0.4);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
      transition: all 0.3s;
    }

    .visit-site:hover {
      background: rgba(255, 255, 255, 0.45);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>
<body>
  <div class="login-wrapper">
    <!-- Panel Kiri: Ilustrasi -->
    <div class="illustration-panel">
      <div class="illustration-content">
        <i class="fas fa-hotel illustration-icon"></i>
        <div class="illustration-text">
          <h2>Hotel Nuansa</h2>
          <p>Sistem Informasi Manajemen</p>
        </div>
      </div>
      <a href="#" class="visit-site">
        <i class="fas fa-external-link-alt"></i>
        <span>Kunjungi Website</span>
      </a>
    </div>

    <!-- Panel Kanan: Form -->
    <div class="form-panel">
      <div class="form-container">
        <h1 class="form-title">Login to continue</h1>

        <form method="POST" action="{{ url('login') }}">
          @csrf
          
          @if($errors->any())
            <div class="error-message">
              <i class="fas fa-exclamation-circle"></i>
              <span>Username atau password salah</span>
            </div>
          @endif

          <div class="input-wrapper">
            <i class="fas fa-user"></i>
            <input 
              type="text" 
              name="username" 
              placeholder="Username/Email"
              required
              autofocus
            >
          </div>

          <div class="input-wrapper">
            <i class="fas fa-eye-slash"></i>
            <input 
              type="password" 
              name="password" 
              placeholder="Password"
              required
            >
          </div>

          <div class="remember-forgot">
            <label class="remember-me">
              <input type="radio" name="remember" id="remember">
              <span>Remember me</span>
            </label>
            <a href="#" class="forgot-password">Forget password?</a>
          </div>

          <button type="submit" class="btn-login">Login</button>

        </form>
      </div>
    </div>
  </div>
</body>
</html>
