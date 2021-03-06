<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit23f58580826bcce1cb8daaadd066ddf2
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'Eloquent\\Enumeration\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Eloquent\\Enumeration\\' => 
        array (
            0 => __DIR__ . '/..' . '/eloquent/enumeration/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit23f58580826bcce1cb8daaadd066ddf2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit23f58580826bcce1cb8daaadd066ddf2::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
