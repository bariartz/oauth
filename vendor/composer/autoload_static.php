<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf533e052e9b8c5493246e4b02a24e62b
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Pondo\\Oauth\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Pondo\\Oauth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf533e052e9b8c5493246e4b02a24e62b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf533e052e9b8c5493246e4b02a24e62b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf533e052e9b8c5493246e4b02a24e62b::$classMap;

        }, null, ClassLoader::class);
    }
}
