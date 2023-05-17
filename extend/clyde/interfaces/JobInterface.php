<?php

namespace clyde\interfaces;

use think\queue\Job;

interface JobInterface
{
    public function fire(Job $job, $data): void;
}
