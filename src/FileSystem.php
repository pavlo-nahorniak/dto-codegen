<?php

namespace App;

/**
 * Class FileSystem.
 *
 * @package App
 */
class FileSystem
{

    public const DIRECTORY_CHMOD = 0755;

    public const FILE_CHMOD = 0744;

    /**
     * Creates a directory.
     *
     * @param string $dirName
     *
     * @return bool
     * @throws \Exception
     */
    public function mkdir(string $dirName): bool
    {
        if (!file_exists($dirName)) {
            if (!mkdir($dirName, self::DIRECTORY_CHMOD, true)) {
                throw new \Exception(
                    sprintf(
                        "Directory %s could not be created!",
                        $dirName
                    )
                );
            }
        }

        if (!is_dir($dirName)) {
            throw new \Exception(
                sprintf(
                    "File %s is not a directory!",
                    $dirName
                )
            );
        }

        return true;
    }

    /**
     * Saves a file.
     *
     * @param string $filename
     * @param mixed $data
     *
     * @throws \Exception
     */
    public function saveFile(string $filename, $data)
    {
        $dirName = dirname($filename);
        $this->mkdir($dirName);

        if (file_put_contents($filename, $data) === false) {
            chmod($filename, self::FILE_CHMOD);
        }
    }
}
