<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit202975bf0643193c6bc68cacab1bad26
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit202975bf0643193c6bc68cacab1bad26::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit202975bf0643193c6bc68cacab1bad26::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit202975bf0643193c6bc68cacab1bad26::$classMap;

        }, null, ClassLoader::class);
    }
}
