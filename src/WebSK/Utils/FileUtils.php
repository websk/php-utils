<?php

namespace WebSK\Utils;

/**
 * Class FileUtils
 * @package WebSK\Utils
 */
class FileUtils
{
    /**
     * @param string $file_path
     */
    public static function renderFileContent(string $file_path): string
    {
        $file_info = new \SplFileInfo($file_path);

        if (!$file_info->isFile()) {
            return;
        }

        $download_size = $file_info->getSize();

        $file_name = str_replace(' ', '_', urldecode($file_info->getFilename()));

        header(HTTP::HEADER_CONTENT_TYPE . ': application/' . $file_info->getExtension());
        header(HTTP::HEADER_CONTENT_DISPOSITION . ": attachment; filename=" . $file_name . ";");
        header(HTTP::HEADER_ACCEPT_RANGES . ": bytes");
        header(HTTP::HEADER_CONTENT_LENGTH . ": " . $download_size);

        readfile($file_path);
    }

    /**
     * Удаление каталога с подкаталогами и файлами
     * @param string $directory
     */
    public static function deleteDir(string $directory)
    {
        if (!is_dir($directory)) {
            return;
        }

        $dirs = @opendir($directory);
        while (($filedirs = readdir($dirs)) !== false) {
            if ($filedirs != "." and $filedirs != "..") {
                if (is_dir($directory . DIRECTORY_SEPARATOR . $filedirs)) {
                    self::deleteDir($directory . DIRECTORY_SEPARATOR . $filedirs);
                } else {
                    unlink($directory . DIRECTORY_SEPARATOR . $filedirs);
                }
            }
        }

        closedir($dirs);
        rmdir($directory);
    }

    /**
     * Проверка имени файла
     * @param string $file_name
     * @return bool
     */
    public static function checkFileName(string $file_name): bool
    {
        if (preg_match("/[^a-z0-9_-]/i", $file_name)) {
            return false;
        }

        return true;
    }
}
