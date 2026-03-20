<?php

namespace Service;

class LoggerService
{
    public function error(\Throwable $exception): void {
        $message = sprintf(
            "[%s] Ошибка: %s в файле %s на строке %d" . PHP_EOL,
            date('Y-m-d H:i:s'),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );

        $logPath = __DIR__ . '/../Storage/Log/errors.txt';
        file_put_contents($logPath, $message, FILE_APPEND);
    }

}