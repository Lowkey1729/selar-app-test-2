<?php

namespace App\Services;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class File
{
    /**
     * @param string $dir
     */
    public static function remove(string $dir): void
    {
        static::filesystem('remove', [$dir]);
    }

    /**
     * @param $path
     * @param $content
     * @param bool $force
     * @return void
     */
    public static function put($path, $content, bool $force = true): void
    {
        if (file_exists($path) && !$force) {
            throw new \RuntimeException("File Already Exists");
        }

        if (false === @file_put_contents($path, $content)) {
            throw new \RuntimeException("Unable to save the file");
        }
    }

    /**
     * @param string $src
     * @param string $dst
     */
    public static function move(string $src, string $dst): void
    {
        static::filesystem('mirror', [$src, $dst]);
        static::remove($src);
    }


    /**
     * @param string $method
     * @param array $params
     * @return void
     */
    protected static function filesystem(string $method, array $params): void
    {
        try {
            \call_user_func_array([new Filesystem, $method], $params);
            return;
        } catch (IOExceptionInterface $e) {
            throw new \RuntimeException("Failed action" . $e->getPath(), $e->getCode(), $e);
        }
    }


    /**
     * @param string $dirname
     * @param int $mode
     * @return void
     */
    public static function makeDir(string $dirname, int $mode = 0777): void
    {
        static::filesystem('mkdir', [$dirname, $mode]);
    }

}
