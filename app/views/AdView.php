<?php

namespace app\views;

class AdView
{
    public function __construct(){}


    public function showAd($data): void
    {
        require __DIR__ . "../../templates/ad.php";
    }

}