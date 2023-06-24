<?php

namespace app\views;

class AdsView
{

    public function __construct($params = []){}

    public function showAds($ads = []) : void
    {
        require __DIR__ . "../../templates/ads.php";
    }
    
}