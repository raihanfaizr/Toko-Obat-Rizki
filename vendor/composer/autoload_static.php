<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit934ee1824a3067a0ca7ec5e77c11fd18
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit934ee1824a3067a0ca7ec5e77c11fd18::$classMap;

        }, null, ClassLoader::class);
    }
}
