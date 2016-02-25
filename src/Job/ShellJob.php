<?php

namespace T4web\Cron\Job;

use Cron\Job\ShellJob as BaseShellJob;
use Cron\Schedule\ScheduleInterface;

class ShellJob extends BaseShellJob
{
    /**
     * @var string
     */
    private $id;

    /**
     * @param string $id
     * @param string $command
     * @param ScheduleInterface $schedule
     */
    public function __construct($id, $command, ScheduleInterface $schedule)
    {
        $this->id = $id;
        $this->setCommand($command);
        $this->setSchedule($schedule);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
