<?php

namespace T4web\Cron\Log;

class TextFile implements LoggerInterface
{
    public function log($jobId, $startTime, $endTime, $isSuccessful, $output, $error)
    {
        $filename = sprintf("data/%s.log", $jobId);

        $message = '';
        if ($isSuccessful) {
            $message .= sprintf('[%s] Job processed successful', date('Y-m-d H:i:s')) . PHP_EOL;
        } else {
            $message .= sprintf('[%s] Job fail', date('Y-m-d H:i:s')) . PHP_EOL;
        }

        $message .= '  Start: ' . date('Y-m-d H:i:s', $startTime) . PHP_EOL;
        $message .= '  End: ' . date('Y-m-d H:i:s', $endTime) . PHP_EOL;
        $message .= '  Execution time: ' . $this->getExecutionTime($startTime, $endTime) . PHP_EOL;
        $message .= $this->prepareOutput($output);
        $message .= $this->prepareError($error);
        $message .= PHP_EOL;

        file_put_contents($filename, $message, FILE_APPEND);
    }

    private function getExecutionTime($startTime, $endTime)
    {
        $executionTime = $endTime - $startTime;
        $days = floor($executionTime / 3600*24);
        $hours = floor(($executionTime - ($days*3600*24)) / 3600);
        $minutes = floor(($executionTime - ($hours*3600)) / 60);
        $secs = floor($executionTime % 60);

        $executionTimeText = '';
        if ($days > 0) {
            $executionTimeText .= "$days days ";
        }

        if ($hours > 0) {
            $executionTimeText .= "$hours hours ";
        }

        if ($minutes > 0) {
            $executionTimeText .= "$minutes mins ";
        }

        if ($secs > 0) {
            $executionTimeText .= "$secs seconds";
        }

        return $executionTimeText;
    }

    private function prepareOutput($output)
    {
        if (empty($output)) {
            return;
        }

        return '--Output: ' . PHP_EOL . implode('', $output) . PHP_EOL . '--End output.' . PHP_EOL;
    }

    private function prepareError($error)
    {
        if (empty($error)) {
            return;
        }

        return '--Error: ' . PHP_EOL . implode('', $error) . PHP_EOL . '--End error.' . PHP_EOL;
    }
}
