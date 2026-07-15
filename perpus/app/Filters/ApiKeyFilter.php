<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = $request->getHeaderLine('X-API-KEY');

        if($apiKey !== 'PERPUS123')
        {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'message' => 'API Key tidak valid'
                ]);
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ){}
}