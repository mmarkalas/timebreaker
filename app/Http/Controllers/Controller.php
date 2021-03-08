<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="TimeBreaker API",
 *    version="1.0.0",
 * )
 */
class Controller extends BaseController
{
    protected $response;

    public function __construct()
    {
        $this->response = new ApiResponse();
    }

    /**
     * Exception Handler to run all the process on Controller's methods.
     *
     * @param  callable $callback   Callback functions from Controller's methods
     * @return mixed
     */
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
        } catch (QueryException $e) {
            throw new ApiException('Please check database query.', Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
