<?php

namespace app\views;

class AdsView
{
    private array $ads;

    public function __construct($params = [])
    {
        $this->ads = [];
    }

    public function showAds($ads = []) : void
    {
        require __DIR__ . "../../templates/ads.php";
    }
    
}