<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\NavigationMenu;

NavigationMenu::whereIn('title', [
    'Pre-4th Republic Laws',
    '4th Republic Laws',
    'Case Laws',
    'News'
])->update(['is_active' => false]);

echo "Successfully reverted main navigation activation in database!\n";
