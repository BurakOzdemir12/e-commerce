<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit85be388f26782ad07899e0e24a7b28f0
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit85be388f26782ad07899e0e24a7b28f0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit85be388f26782ad07899e0e24a7b28f0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit85be388f26782ad07899e0e24a7b28f0::$classMap;

        }, null, ClassLoader::class);
    }
}