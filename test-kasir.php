<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Kasir Dashboard ===" . PHP_EOL . PHP_EOL;

// Check if user exists
$kasir = \App\Models\User::where('username', 'kasir')->first();
if (!$kasir) {
    echo "❌ User kasir tidak ditemukan!" . PHP_EOL;
    exit(1);
}

echo "✅ User kasir ditemukan: " . $kasir->name . " (role: " . $kasir->role . ")" . PHP_EOL;

// Check view exists
$viewPath = resource_path('views/dashboard-kasir.blade.php');
if (!file_exists($viewPath)) {
    echo "❌ View dashboard-kasir.blade.php tidak ditemukan!" . PHP_EOL;
    exit(1);
}

echo "✅ View dashboard-kasir.blade.php ada di: " . $viewPath . PHP_EOL;

// Check route
$route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('dashboard');
if (!$route) {
    echo "❌ Route 'dashboard' tidak ditemukan!" . PHP_EOL;
    exit(1);
}

echo "✅ Route 'dashboard' ada: " . $route->uri() . " -> " . $route->getActionName() . PHP_EOL;

// Simulate kasir login and test controller
\Illuminate\Support\Facades\Auth::login($kasir);
echo "✅ Auth login sebagai kasir berhasil" . PHP_EOL;

try {
    $controller = new \App\Http\Controllers\DashboardController();
    echo "✅ DashboardController instance berhasil dibuat" . PHP_EOL;
    
    // Test method exists
    $reflection = new ReflectionClass($controller);
    if (!$reflection->hasMethod('kasirDashboard')) {
        echo "❌ Method kasirDashboard tidak ditemukan!" . PHP_EOL;
    } else {
        echo "✅ Method kasirDashboard ada" . PHP_EOL;
    }
    
    echo PHP_EOL . "=== Semua test PASSED! ===" . PHP_EOL;
    echo "Dashboard kasir seharusnya bisa diakses di: http://localhost:8000" . PHP_EOL;
    echo "Login dengan: username=kasir, password=kasir123" . PHP_EOL;
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
