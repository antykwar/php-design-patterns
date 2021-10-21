<?php

abstract class HotDrinkProvider
{
    public function makeDrink()
    {
        $this
            ->boilWater()
            ->addDrinkBase()
            ->addSugar();
    }

    abstract protected function addDrinkBase();

    protected function boilWater()
    {
        echo "Boiling water\n";
        return $this;
    }

    protected function addSugar()
    {
        echo "Adding some sugar\n";
        return $this;
    }
}

class CoffeeProvider extends HotDrinkProvider
{
    protected function addDrinkBase()
    {
        echo "Adding COFFEE\n";
        return $this;
    }
}

class CocoaProvider extends HotDrinkProvider
{
    protected function addDrinkBase()
    {
        echo "Adding COCOA\n";
        return $this;
    }
}

(new CoffeeProvider())->makeDrink();
(new CocoaProvider())->makeDrink();
