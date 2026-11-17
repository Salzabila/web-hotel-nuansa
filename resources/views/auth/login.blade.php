<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Hotel Nuansa</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    * { font-family: 'Plus Jakarta Sans', sans-serif; }
    body { background-color: #F5EFE6; }
  </style>
</head>
<body class="min-h-screen bg-[#F5EFE6] flex flex-col items-center justify-center p-4">

  <div class="max-w-md w-full">
    
    <!-- BRAND LOGO & TITLE -->
    <div class="text-center mb-8">
      <div class="inline-flex w-14 h-14 rounded-2xl bg-[#F5A623] text-[#0B192C] font-black text-3xl items-center justify-center shadow-lg shadow-amber-500/20 mb-3.5">
        N
      </div>
      <h1 class="text-2xl md:text-3xl font-extrabold text-[#0B192C] tracking-tight">Hotel Nuansa</h1>
      <p class="text-slate-400 text-xs font-semibold tracking-wider uppercase mt-1">Front Office System</p>
    </div>

    <!-- LOGIN CARD -->
    <div class="bg-white rounded-3xl p-7 md:p-9 shadow-xl border border-stone-200/60">
      
      <div class="mb-6">
        <h2 class="text-lg font-bold text-[#0B192C]">Masuk ke Akun</h2>
        <p class="text-xs text-slate-500 font-medium mt-0.5">Masukkan No. HP atau ID staf terdaftar</p>
      </div>

      @if($errors->any())
        <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold mb-5 flex items-center gap-2.5">
          <i class="fas fa-circle-exclamation text-rose-500 text-sm shrink-0"></i>
          <span>{{ $errors->first('phone') ?? 'Nomor telepon atau password yang Anda masukkan salah.' }}</span>
        </div>
      @endif

      <form method="POST" action="{{ url('login') }}" class="space-y-4">
        @csrf

        <!-- No. HP / Username -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">No. HP / Username</label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
              <i class="fas fa-user"></i>
            </span>
            <input type="text" name="phone" id="loginPhone" required autofocus value="{{ old('phone') }}"
                   placeholder="admin atau 08123456789"
                   class="w-full pl-11 pr-4 py-3 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 font-semibold text-[#0B192C] bg-[#FAFAF8] focus:bg-white transition-all">
          </div>
        </div>

        <!-- Password -->
        <div>
          <label class="block text-xs font-bold text-slate-700 mb-1.5">Password</label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">
              <i class="fas fa-lock"></i>
            </span>
            <input type="password" name="password" id="loginPassword" required
                   placeholder="••••••••"
                   class="w-full pl-11 pr-11 py-3 rounded-2xl border border-stone-200 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 font-semibold text-[#0B192C] bg-[#FAFAF8] focus:bg-white transition-all">
            <button type="button" id="togglePasswordBtn" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
              <i class="fas fa-eye text-sm" id="togglePasswordIcon"></i>
            </button>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
          <button type="submit" 
                  class="w-full bg-[#F5A623] hover:bg-[#e29515] text-[#0B192C] font-extrabold py-3.5 rounded-full text-sm shadow-md transition-all active:scale-95 flex items-center justify-center gap-2">
            <span>Masuk</span>
            <i class="fas fa-arrow-right text-xs"></i>
          </button>
        </div>

      </form>

    </div>

    <!-- FOOTER -->
    <p class="text-center text-xs text-slate-400 font-medium mt-6">
      © {{ date('Y') }} Hotel Nuansa · All rights reserved
    </p>

  </div>

  <script>
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const pwdInput = document.getElementById('loginPassword');
    const pwdIcon = document.getElementById('togglePasswordIcon');

    toggleBtn.addEventListener('click', () => {
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';
        pwdIcon.classList.remove('fa-eye');
        pwdIcon.classList.add('fa-eye-slash');
      } else {
        pwdInput.type = 'password';
        pwdIcon.classList.remove('fa-eye-slash');
        pwdIcon.classList.add('fa-eye');
      }
    });
  </script>
</body>
</html>
