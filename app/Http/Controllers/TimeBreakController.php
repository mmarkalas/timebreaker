<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\TimeBreakdownRepositoryInterface;
use Illuminate\Http\Request;

class TimeBreakController extends Controller
{
    /**
     * @var TimeBreakdownRepositoryInterface
     */
    private $timeBreakdownRepository;

    /**
     * TimeBreakdownRepositoryInterface constructor.
     *
     * @param TimeBreakdownRepositoryInterface $timeBreakdownRepository
     */
    public function __construct(TimeBreakdownRepositoryInterface $timeBreakdownRepository)
    {
        parent::__construct();
        $this->timeBreakdownRepository = $timeBreakdownRepository;
    }

    /**
     * @OA\Get(
     *     path="/timebreak",
     *     summary="Get All Time Breakdown Records",
     *     description="Get All Time Breakdown Records with filter for from_date and to_date",
     *     tags={"TIME BREAKDOWN"},
     *     security={
     *         { "bearer": {}}
     *     },
     *     @OA\Parameter(
     *         name="from_date",
     *         in="query",
     *         description="From Datetime",
     *         schema={
     *            "type"="string",
     *            "example"="2020-01-01 00:00:00"
     *         }
     *     ),
     *     @OA\Parameter(
     *         name="to_date",
     *         in="query",
     *         description="To Datetime",
     *         schema={
     *            "type"="string",
     *            "example"="2020-02-05 12:30:00"
     *         }
     *     ),
     *     @OA\Response(
     *         response=Symfony\Component\HttpFoundation\Response::HTTP_OK,
     *         description="Time Breakdown Record Found.",
     *         @OA\JsonContent(
     *             example={
     *                      "success": true,
     *                      "code": 200,
     *                      "data": {
     *                          {
     *                              "id": 1,
     *                              "from_date": "2020-01-01 00:00:00",
     *                              "to_date": "2020-02-05 12:30:00",
     *                              "expression": {
     *                                  "2m",
     *                                  "m",
     *                                  "d",
     *                                  "2h"
     *                               },
     *                               "result": {
     *                                  "2m": 0,
     *                                  "m": 1,
     *                                  "d": 5,
     *                                  "2h": 6.25
     *                               },
     *                               "created_at": "2021-03-05T18:19:40.000000Z",
     *                               "updated_at": "2021-03-05T18:19:40.000000Z"
     *                          }
     *                       }
     *
     *               }
     *         )
     *     )
     * )
     *
     * Get All Time Breakdown Records with filter for from_date and to_date
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $result = $this->timeBreakdownRepository->search($request);

            $this->response->setPayload($result);
        });
    }

    /**
     * @OA\Post(
     *     path="/timebreak",
     *     summary="Create Time Breakdown",
     *     description="Create Time Breakdown from Date Range and Date Expression",
     *     tags={"TIME BREAKDOWN"},
     *     security={
     *         { "bearer": {}}
     *     },
     *     @OA\RequestBody(
     *         description="JSON Payload",
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="from_date",
     *                 description="From Datetime",
     *                 type="string",
     *                 example="2020-01-01 00:00:00"
     *             ),
     *             @OA\Property(
     *                 property="to_date",
     *                 description="To Datetime",
     *                 type="string",
     *                 example="2020-02-05 12:30:00"
     *             ),
     *             @OA\Property(
     *                 property="expression",
     *                 description="An array of expression on how to breakdown the date range",
     *                 type="array",
     *                 @OA\Items(
     *                     type="array",
     *                     @OA\Items()
     *                 ),
     *                 example={
     *                     "2m",
     *                     "m",
     *                     "d",
     *                     "2h"
     *                 }
     *            )
     *         )
     *     ),
     *     @OA\Response(
     *         response=Symfony\Component\HttpFoundation\Response::HTTP_CREATED,
     *         description="IP Address creation successful",
     *         @OA\JsonContent(
     *             example={
     *                 {
     *                     "success": true,
     *                     "code": 200,
     *                     "data": {
     *                         "2m": 0,
     *                         "m": 1,
     *                         "d": 5,
     *                         "2h": 6.25
     *                     }
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY,
     *         description="Invalid given data",
     *         @OA\JsonContent(
     *              example={
     *                 {
     *                     "success": false,
     *                     "code": 422,
     *                     "errors": {
     *                         "message": "The given data was invalid.",
     *                         "details": {
     *                             "from_date": {
     *                                 "The from date field is required."
     *                             },
     *                             "to_date": {
     *                                 "The to date field is required."
     *                             },
     *                             "expression": {
     *                                 "The expression field is required."
     *                             }
     *                          }
     *                      }
     *                  }
     *             }
     *         )
     *     )
     * )
     *
     * Create Time Breakdown from Date Range and Date Expression
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function breakTime(Request $request)
    {
        return $this->runWithExceptionHandling(function () use ($request) {
            $this->validate($request, [
                'from_date' => 'required|date|different:to_date',
                'to_date' => 'required|date|different:from_date',
                'expression' => 'required',
            ]);

            $result = $this->timeBreakdownRepository->process($request);

            $this->response->setPayload($result);
        });
    }
}
