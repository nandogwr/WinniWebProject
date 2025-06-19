<?php
spl_autoload_register(function ($class) {
    $prefixes = [
        'PhpOffice\\PhpSpreadsheet\\' => __DIR__ . '/PhpSpreadsheet/src/PhpSpreadsheet/',
        'Psr\\SimpleCache\\' => __DIR__ . '/simple-cache/src/',
        'Psr\\Container\\' => __DIR__ . '/container/src/',
        'ZipStream\\' => __DIR__ . '/ZipStream/src/',
    ];

    foreach ($prefixes as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) === 0) {
            $relativeClass = substr($class, $len);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});
