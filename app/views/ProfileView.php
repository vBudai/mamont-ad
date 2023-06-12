<?php

namespace app\views;

class ProfileView
{

    public function __construct(){}


    public function showAds($title, $data = []) : void
    {
        require __DIR__ . "../../templates/profile_ads.php";
    }

    public function showSettings($data = []): void
    {
        require __DIR__ . "../../templates/profile_settings.php";
    }

}