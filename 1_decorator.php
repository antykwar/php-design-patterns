<?php

interface FellowshipMemberMessage
{
    public function speakToFrodo();
}

class BasicMessage implements FellowshipMemberMessage
{
    public function speakToFrodo()
    {
        return "Frodo, you are the most brave hobbit I have ever knew!";
    }
}

class AragornMessage implements FellowshipMemberMessage
{
    public function __construct(protected FellowshipMemberMessage $message) {}

    public function speakToFrodo()
    {
        return $this->message->speakToFrodo() . ' ' . 'You have my sword!';
    }
}

class LegolasMessage implements FellowshipMemberMessage
{
    public function __construct(protected FellowshipMemberMessage $message) {}

    public function speakToFrodo()
    {
        return $this->message->speakToFrodo() . ' ' . 'You have my bow!';
    }
}

class GimliMessage implements FellowshipMemberMessage
{
    public function __construct(protected FellowshipMemberMessage $message) {}

    public function speakToFrodo()
    {
        return $this->message->speakToFrodo() . ' ' . 'You have my axe!';
    }
}

$membersToSpeak = ['Aragorn', 'Legolas', 'Gimli'];
$message = new BasicMessage;

foreach ($membersToSpeak as $memberToSpeak) {
    $memberToSpeak .= 'Message';
    $message = new $memberToSpeak($message);
}

echo $message->speakToFrodo() . "\n";
