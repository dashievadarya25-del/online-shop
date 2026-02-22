<?php

namespace Core;

class Autoloader
{
    public static function register(string $dir)
    {
        $autoload = function (string $classname) use ($dir)
        {
            //  ./../Core/App.php
            $path = str_replace('\\', '/', $classname); //Core/App
            $path = "$dir/$path.php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            }

            return false;
        };

        spl_autoload_register($autoload);
    }

}