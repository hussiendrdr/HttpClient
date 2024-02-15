<?php

namespace App\Traits;

use App\Services\MarketAuthenticationService;
use GuzzleHttp\Client;

trait AuthorizesMarketRequests
{

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {

        $accessToken = $this->resolveAccessToken();
        $headers['Authorization'] = $accessToken;

    }

    public function resolveAccessToken()
    {
        $authenticationService = resolve(MarketAuthenticationService::class);



        return $authenticationService->getClientCredentialsToken();
    }

}
