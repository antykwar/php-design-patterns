<?php

interface CoffeeMachineInterface {
    public function makeCoffee();
}

interface CoffeeMakerInterface {
    public function boilAndMix();
}

class CoffeeMachine implements CoffeeMachineInterface
{
    public function makeCoffee()
    {
        echo "Coffee machine finished\n";
    }
}

class InstantCoffeeMaker implements CoffeeMakerInterface
{
    public function boilAndMix()
    {
        echo "Instant coffee is ready\n";
    }
}

class SleepyHedgehog
{
    public function __construct(protected CoffeeMachineInterface $coffeeProvider) {}

    public function drinkCoffee()
    {
        $this->coffeeProvider->makeCoffee();
        echo "I`ve drunk some coffee\n";
    }
}

class InstantCoffeeMakerAdapter implements CoffeeMachineInterface
{
    public function __construct(protected CoffeeMakerInterface $coffeeMaker) {}

    public function makeCoffee()
    {
        $this->coffeeMaker->boilAndMix();
    }
}

(new SleepyHedgehog(new CoffeeMachine()))->drinkCoffee();
(new SleepyHedgehog(new InstantCoffeeMakerAdapter(new InstantCoffeeMaker())))->drinkCoffee();
