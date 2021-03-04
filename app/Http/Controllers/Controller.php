<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Response;
use InvalidArgumentException;
use App\Exceptions\ApiException;
use App\Http\Responses\ApiResponse;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Controller extends BaseController
{
    protected $response;

    public function __construct()
    {
        $this->response = new ApiResponse();
    }

    public function runWithExceptionHandling($callback)
    {
        try {
            $callback();

            if ($this->response->getCode()) {
                return response()
                    ->json($this->response->getPayload(), $this->response->getCode());
            }

            return response()
                ->json($this->response->getPayload());
        } catch (ApiException $e) {
            throw $e;
        } catch (ValidationException $e) {
            throw new ApiException(
                $e->getMessage(),
                $e->getResponse() ? $e->getResponse()->getStatusCode() : Response::HTTP_UNPROCESSABLE_ENTITY,
                $e->errors()
            );
        } catch (ModelNotFoundException $e) {
            throw new ApiException('Record not found.', Response::HTTP_NOT_FOUND);
        } catch (InvalidArgumentException $e) {
            throw new ApiException($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
