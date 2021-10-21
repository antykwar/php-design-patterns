<?php

interface Subscriber
{
    public function attach(Observer $observer);
    public function detach(Observer $observer);
    public function notify();
}

interface Observer
{
    public function handle();
}

trait SubscriberMethods
{
    protected $observers = [];

    public function attach($observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer): void
    {
        // stub for detach method
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->handle();
        }
    }
}

class MailSender implements Observer
{
    public function handle()
    {
        var_dump('Sending mail about action');
    }
}

class SmsSender implements Observer
{
    public function handle()
    {
        var_dump('Sending SMS about action');
    }
}

class StatusUpdater implements Observer
{
    public function handle()
    {
        var_dump('Updating user status');
    }
}

class MoneyManager implements Subscriber
{
    use SubscriberMethods;

    public function someUsefulAction(): void
    {
        var_dump('Performing some important action');
        $this->notify();
    }
}

$manager = new MoneyManager;

$manager->attach(new MailSender);
$manager->attach(new SmsSender);
$manager->attach(new StatusUpdater);

$manager->someUsefulAction();
