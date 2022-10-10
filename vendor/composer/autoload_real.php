<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitf533e052e9b8c5493246e4b02a24e62b
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitf533e052e9b8c5493246e4b02a24e62b', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitf533e052e9b8c5493246e4b02a24e62b', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitf533e052e9b8c5493246e4b02a24e62b::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}