<?php

namespace App\IpProviders;

class Herokuapp implements IpProvider
{
    protected $url;

    public function __construct()
    {
        $this->url = config('ipinfo.herokuapp.url');
    }

    public function getIspName(string $ip): array
    {
        $client = new \GuzzleHttp\Client();

        $request = $client->get("{$this->url}{$ip}");

        if ($request->getBody()) {
            $result = json_decode($request->getBody()->getContents());
        }

        return $result->ispname ?? [];
    }
}
