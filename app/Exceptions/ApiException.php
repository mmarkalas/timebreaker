<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ApiException extends HttpResponseException
{
    public function __construct($message = null, $code = 500, array $details = [])
    {
        if (!$code) {
            $code = 500;
        }

        // build response object
        $response = new Response();

        $responseBody = [
            'success' => false,
            'code'    => $code,
            'errors'  => [
                'message' => $message
            ]
        ];

        if (!empty($details)) {
            $responseBody['errors']['details'] = $details;
        }

        $response->setContent($responseBody)
            ->setStatusCode($code);

        parent::__construct($response);
    }
}
