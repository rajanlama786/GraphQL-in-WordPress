<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit93455bd2bd3c5dd723af2e0ebe1b9a40
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
    );

    public static $prefixesPsr0 = array (
        'A' => 
        array (
            'Acme' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit93455bd2bd3c5dd723af2e0ebe1b9a40::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit93455bd2bd3c5dd723af2e0ebe1b9a40::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit93455bd2bd3c5dd723af2e0ebe1b9a40::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit93455bd2bd3c5dd723af2e0ebe1b9a40::$classMap;

        }, null, ClassLoader::class);
    }
}
