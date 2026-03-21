<?php
// Quick diagnostic: map controller-returned views to blade files to catch missing views

$controllerDir = __DIR__ . '/../app/Http/Controllers';
$bladeRoot = __DIR__ . '/../resources/views';

$missingViews = [];

if (!is_dir($controllerDir)) {
    fwrite(STDERR, "Controllers directory not found: $controllerDir\n");
    exit(1);
}

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($controllerDir));
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getRealPath());
        if (preg_match_all("/return\s+view\([\'\"]([^\'\"]+)[\'\"]/", $content, $matches)) {
            foreach ($matches[1] as $viewPath) {
                // Convert dot notation to blade path: e.g. "admin.dashboard" -> resources/views/admin/dashboard.blade.php
                $bladePath = $bladeRoot . '/' . str_replace('.', '/', $viewPath) . '.blade.php';
                if (!file_exists($bladePath)) {
                    $missingViews[] = [
                        'controller' => $file->getRealPath(),
                        'view' => $viewPath,
                        'blade' => $bladePath,
                    ];
                }
            }
        }
    }
}

if (!empty($missingViews)) {
    echo "Missing blade files for the following returned views:\n";
    foreach ($missingViews as $m) {
        echo "- Controller: {$m['controller']} -> View: {$m['view']} (expected: {$m['blade']})\n";
    }
    exit(2);
} else {
    echo "All checked views have corresponding blade templates.\n";
}
