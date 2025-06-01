<?php

namespace App\Services;

use App\ApiResource\Simulator;

class SimulatorService
{
    public function simulate(Simulator $simulator)
    {

        $pricePerProduct = $simulator->getPricePerProduct();
        $numberProduct = $simulator->getNumberOfProduct();
        $package = $simulator->isPackage() ? 250 : 500;


        $totalPriceHT = $numberProduct * $pricePerProduct + $package;
        $tva = $totalPriceHT * 0.2;
        $totalPrice = $totalPriceHT + $tva;

        return [
            'totalPriceHT' => $totalPriceHT,
            'totalPrice' => $totalPrice,
        ];
    }
}
