@extends('layouts.app')

@section('content')
<div class="h-full">
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">Manajemen User</h1>
    <p class="text-slate-500 mt-2 text-base">Kelola akun admin dan kasir</p>
  </div>

  @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-check-circle text-xl"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 flex items-center gap-3">
      <i class="fas fa-exclamation-circle text-xl"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
    <div class="flex justify-between items-center mb-6">
      <div>
        <h2 class="text-xl font-bold text-slate-800">Daftar User</h2>
        <p class="text-slate-500 text-sm mt-1">Total: {{ $users->count() }} user</p>
      </div>
      <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition-all shadow-lg">
        <i class="fas fa-plus"></i> Tambah User
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b-2 border-slate-200 bg-gradient-to-r from-slate-50 to-slate-100">
            <th class="text-left py-4 px-6 font-bold text-gray-900">Nama</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Telepon</th>
            <th class="text-left py-4 px-6 font-bold text-gray-900">Role</th>
            <th class="text-center py-4 px-6 font-bold text-gray-900">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @foreach($users as $user)
            <tr class="hover:bg-blue-50 transition-colors duration-150">
              <td class="py-4 px-6 font-semibold text-gray-900">
                {{ $user->name }}
                @if($user->id === auth()->id())
                  <span class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Anda</span>
                @endif
              </td>
              <td class="py-4 px-6 text-gray-700">{{ $user->phone }}</td>
              <td class="py-4 px-6">
                @if($user->role === 'admin')
                  <span class="inline-flex items-center gap-1.5 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-crown"></i> Admin
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">
                    <i class="fas fa-user"></i> Kasir
                  </span>
                @endif
              </td>
              <td class="py-4 px-6">
                <div class="flex items-center justify-center gap-2">
                  <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold text-xs px-3 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md" style="line-height: 1; width: 75px; justify-content: center;">
                    <i class="fas fa-edit" style="font-size: 11px; vertical-align: middle;"></i>
                    <span style="vertical-align: middle;">Edit</span>
                  </a>
                  
                  <button type="button" onclick="openResetModal({{ $user->id }}, '{{ $user->name }}')" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold text-xs px-3 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md" style="line-height: 1; width: 75px; justify-content: center;">
                    <i class="fas fa-key" style="font-size: 11px; vertical-align: middle;"></i>
                    <span style="vertical-align: middle;">Reset</span>
                  </button>

                  @if($user->id !== auth()->id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-xs px-3 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md" style="line-height: 1; width: 75px; justify-content: center;">
                        <i class="fas fa-trash" style="font-size: 11px; vertical-align: middle;"></i>
                        <span style="vertical-align: middle;">Hapus</span>
                      </button>
                    </form>
                  @else
                    <div style="width: 75px;"></div>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Reset Password Modal -->
<div id="resetModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
  <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full">
    <div class="flex items-center gap-3 mb-5">
      <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
        <i class="fas fa-key text-orange-600"></i>
      </div>
      <div>
        <h3 class="text-lg font-bold text-slate-800">Reset Password</h3>
        <p class="text-xs text-slate-500" id="resetUserName"></p>
      </div>
    </div>
    
    <form id="resetForm" method="POST">
      @csrf
      <div class="space-y-3 mb-5">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
          <input type="password" 
                 name="new_password" 
                 class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" 
                 placeholder="Minimal 6 karakter"
                 required 
                 minlength="6">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
          <input type="password" 
                 name="new_password_confirmation" 
                 class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-sm" 
                 placeholder="Ulangi password"
                 required 
                 minlength="6">
        </div>
      </div>
      
      <div class="flex gap-2">
        <button type="button" 
                onclick="closeResetModal()" 
                class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium py-2 rounded-lg transition-colors text-sm">
          Batal
        </button>
        <button type="submit" 
                class="flex-1 bg-orange-600 hover:bg-orange-700 text-white font-medium py-2 rounded-lg transition-colors text-sm shadow-sm">
          Reset Password
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function openResetModal(userId, userName) {
  document.getElementById('resetModal').classList.remove('hidden');
  document.getElementById('resetUserName').textContent = userName;
  document.getElementById('resetForm').action = `/users/${userId}/reset-password`;
}

function closeResetModal() {
  document.getElementById('resetModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('resetModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeResetModal();
  }
});
</script>
@endsection
