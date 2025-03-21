<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbcfd0313ced32af9d35b3a1fc2c20ed2
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

        spl_autoload_register(array('ComposerAutoloaderInitbcfd0313ced32af9d35b3a1fc2c20ed2', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbcfd0313ced32af9d35b3a1fc2c20ed2', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbcfd0313ced32af9d35b3a1fc2c20ed2::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
