<?php

namespace App\IpProviders;

interface IpProvider
{
    function getIspName(string $ip): array;
}
