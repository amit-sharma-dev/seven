<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncidentTest extends TestCase
{

    public function testDatabase()
    {
        $this->assertDatabaseHas('peoples', [
            'type' => 'staff',
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateIncident()
    {
        $request = ['location' =>
            [
                'latitude' => 12.9231501,
                'longitude' => 74.7818517,
            ],
            'title' => 'incident title',
            'category' => 1,
            'people' =>
                [
                    0 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'staff',
                        ],
                    1 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'witness',
                        ],
                    2 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'staff',
                        ],
                ],
            'comments' => 'This is a string of comments',
            'incidentDate' => '2020-09-01T13:26:00+00:00',
            'createDate' => '2020-09-01T13:32:59+01:00',
            'modifyDate' => '2020-09-01T13:32:59+01:00'
        ];
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/incident', $request);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function testGetAllIncident()
    {
        $this->json('GET', 'api/incident', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "success" => true
            ]);
    }

    public function testInvalidLatitudeAndLongitude()
    {
        $request = ['location' =>
            [
                'latitude' => "A",
                'longitude' => 74.7818517,
            ],
            'title' => 'incident title',
            'category' => 1,
            'people' =>
                [
                    0 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'staff',
                        ],
                    1 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'witness',
                        ],
                    2 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'staff',
                        ],
                ],
            'comments' => 'This is a string of comments',
            'incidentDate' => '2020-09-01T13:26:00+00:00',
            'createDate' => '2020-09-01T13:32:59+01:00',
            'modifyDate' => '2020-09-01T13:32:59+01:00'
        ];
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/incident', $request);

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'errors' => ['location.latitude' => ['The location.latitude format is invalid.']]
            ]);
    }

    public function testInvalidCategory()
    {
        $request = ['location' =>
            [
                'latitude' => "A",
                'longitude' => 74.7818517,
            ],
            'title' => 'incident title',
            'category' => null,
            'people' =>
                [
                    0 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'staff',
                        ],
                    1 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'witness',
                        ],
                    2 =>
                        [
                            'name' => 'Name of person',
                            'type' => 'staff',
                        ],
                ],
            'comments' => 'This is a string of comments',
            'incidentDate' => '2020-09-01T13:26:00+00:00',
            'createDate' => '2020-09-01T13:32:59+01:00',
            'modifyDate' => '2020-09-01T13:32:59+01:00'
        ];
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', '/api/incident', $request);

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
                'errors' => ['category' => ['The category field is required.']]
            ]);
    }
}
