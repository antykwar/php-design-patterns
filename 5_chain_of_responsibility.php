<?php

abstract class DriveChecker
{
    protected ?DriveChecker $successor = null;

    abstract public function check(DriverState $state);

    public function setSuccessor(DriveChecker $successor): void
    {
        $this->successor = $successor;
    }

    public function next(DriverState $state): void
    {
        if ($this->successor) {
            $this->successor->check($state);
        }
    }
}

class DriverState
{
    public bool $isFresh = true;
    public bool $hasFastenedBelt = true;
    public bool $hasStartedEngine = true;
}

class FreshChecker extends DriveChecker
{
    public function check(DriverState $state) {
        if (!$state->isFresh) {
            throw new Exception('You are drunk, you can`t drive!');
        }
        $this->next($state);
    }
}

class BeltChecker extends DriveChecker
{
    public function check(DriverState $state) {
        if (!$state->hasFastenedBelt) {
            throw new Exception('Fasten you belt first!');
        }
        $this->next($state);
    }
}

class EngineChecker extends DriveChecker
{
    public function check(DriverState $state) {
        if (!$state->hasStartedEngine) {
            throw new Exception('Start engine before trying to drive!');
        }
        $this->next($state);
    }
}

$fresh = new FreshChecker();
$belt = new BeltChecker();
$engine = new EngineChecker();

$fresh->setSuccessor($belt);
$belt->setSuccessor($engine);

$driverState = new DriverState();

try {
    $fresh->check($driverState);
    echo "Everything is OK!\n";
} catch (Exception $ex) {
    echo $ex->getMessage() . "\n";
}

$driverState->hasFastenedBelt = false;

try {
    $fresh->check($driverState);
    echo "Everything is OK!\n";
} catch (Exception $ex) {
    echo $ex->getMessage() . "\n";
}
