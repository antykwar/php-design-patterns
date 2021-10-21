<?php

interface SignMakerInterface {
    public function makeSign($message);
}

class HandsSignMaker implements SignMakerInterface {
    public function makeSign($message)
    {
        echo "Showing \"{$message}\" with fingers\n";
    }
}

class SmokeSignMaker implements SignMakerInterface {
    public function makeSign($message)
    {
        echo "Sending \"{$message}\" with smoke rings\n";
    }
}

class FireworksSignMaker implements SignMakerInterface {
    public function makeSign($message)
    {
        echo "Launching rockets to say \"{$message}\"\n";
    }
}

class Notifier {
    public function makeSign($message, $notifier = null)
    {
        $notifier = $notifier ?: new SmokeSignMaker();
        $notifier->makeSign($message);
    }
}

$notifier = new Notifier();

$notifier->makeSign('I am here!');
$notifier->makeSign('And here I am!', new FireworksSignMaker());
