<?php
namespace Cache;

class File {
    private $expire;

    public function __construct($expire = 3600) {
        $this->expire = $expire;

        // Чистим устаревший кэш
        $files = glob(DIR_CACHE . 'cache.*');

        if ($files) {
            foreach ($files as $file) {
                $time = substr(strrchr($file, '.'), 1);

                if ($time < time()) {
                    if (is_string($file) && is_file($file)) {
                        @unlink($file); // @ гасит предупреждение, если файл исчез между проверкой и удалением
                    }
                }
            }
        }
    }

    public function get($key) {
        $files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

        if ($files) {
            $file = $files[0];

            // Файл мог уже исчезнуть или быть нечитаемым
            if (!is_file($file) || !is_readable($file)) {
                return false;
            }

            $handle = @fopen($file, 'r');

            // fopen вернул false – дальше не идём
            if ($handle === false) {
                return false;
            }

            // flock иногда не поддерживается на некоторых FS – гасим предупреждение
            @flock($handle, LOCK_SH);

            $size = @filesize($file);
            if ($size > 0) {
                $data = @fread($handle, $size);
            } else {
                $data = '';
            }

            @flock($handle, LOCK_UN);
            @fclose($handle);

            if ($data === '' || $data === false) {
                return false;
            }

            $result = json_decode($data, true);

            // Если вдруг кэш битый – тоже лучше вернуть false
            if (json_last_error() !== JSON_ERROR_NONE) {
                return false;
            }

            return $result;
        }

        return false;
    }

    public function set($key, $value) {
        $this->delete($key);

        // Убедимся, что каталог есть
        if (!is_dir(DIR_CACHE)) {
            @mkdir(DIR_CACHE, 0777, true);
        }

        $file = DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->expire);

        $handle = @fopen($file, 'w');

        if ($handle === false) {
            // Тут можете записать в лог, если нужно
            return;
        }

        @flock($handle, LOCK_EX);

        fwrite($handle, json_encode($value));

        fflush($handle);

        @flock($handle, LOCK_UN);

        @fclose($handle);
    }

    public function delete($key) {
        $files = glob(DIR_CACHE . 'cache.' . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    @unlink($file);
                }
            }
        }
    }
}
