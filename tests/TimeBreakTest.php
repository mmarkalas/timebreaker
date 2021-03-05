<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TimeBreakTest extends TestCase
{
    /**
     * Breakdown the time based on the example
     * on the Exercise.
     *
     * [POST]
     */
    public function testShouldBreakTime()
    {
        $parameters = [
            "from_date" => "2020-01-01T00:00:00",
            "to_date" => "2020-02-05T12:30:00",
            "expression" => [
                "2m",
                "m",
                "d",
                "2h"
            ]
        ];

        $this->post("timebreak", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonEquals([
            "success" => true,
            "code" => 200,
            "data" => [
                "2m" => 0,
                "m" => 1,
                "d" => 5,
                "2h" => 6.25
            ]
        ]);
    }

    /**
     * Get Result of time breakdown using
     * the timestamps
     *
     * [GET]
     */
    public function testShouldReturnBreakdown()
    {
        $this->get("timebreak?from_date=2020-01-01T00:00:00&to_date=2020-02-05T12:30:00", []);
        $this->seeStatusCode(200);
        $this->seeJsonEquals([
            "success" => true,
            "code" => 200,
            "data" => [
                [
                    "from_date" => "2020-01-01 00:00:00",
                    "to_date" => "2020-02-05 12:30:00",
                    "expression" => [
                        "2m",
                        "m",
                        "d",
                        "2h"
                    ],
                    "result" => [
                        "2m" => 0,
                        "m" => 1,
                        "d" => 5,
                        "2h" => 6.25
                    ]
                ]
            ]
        ]);
    }
}
