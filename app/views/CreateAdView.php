<?php

namespace app\views;

class CreateAdView
{
    public function __construct(){}

    public function showPage($categories, $cities, array $adInfo = []): void
    {

        require __DIR__ . "../../templates/create_ad.php";

    }
}