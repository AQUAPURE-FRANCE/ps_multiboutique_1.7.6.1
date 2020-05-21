<?php

class CustomLogger
{
    const DEFAULT_LOG_FILE = "prestashop_system.log";

    public static function log($message, $level = 'debug', $fileName = null)
    {
        $fileDir = _PS_ROOT_DIR_ . '/log/';
        $fileName = self::DEFAULT_LOG_FILE;

        if (is_array($message) || is_object($message)) {
            $message = print_r($message, true);
        }
        $formatted_message = $level . " -- " . date('Y/m/d - H:i:s') . ": " . $message . "\r\n";

        return file_put_contents($fileDir . $fileName, $formatted_message, FILE_APPEND);
    }
}