<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IncidentManagementRequest;
use App\Models\Incident;
use App\Models\People;
use App\Repositories\IncidentRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Class IncidentManagementController
 * @package App\Http\Controllers\Api
 */
class IncidentManagementController extends BaseApiController
{
    private $incidents;

    private $peoples;

    /**
     * Dependency injection of Incident
     * IncidentManagementController constructor.
     * @param IncidentRepository $incidents
     */
    public function __construct(IncidentRepository $incidents)
    {
        $this->incidents = $incidents;
        $this->peoples = new People();
    }

    /**
     * Get all incident
     * @param Request $request
     * @return JsonResponse
     */
    protected function index(Request $request)
    {
        $incidents = $this->incidents->getAll();
        return $this->successResponse($incidents);
    }

    /**
     * Create incident
     * @param Request $request
     * @return mixed
     */
    protected function store(Request $request)
    {
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'location' => 'required',
            'location.latitude' => ['required', 'regex:/^[-]?((([0-8]?[0-9])(\.(\d+))?)|(90(\.0+)?))/'],
            'location.longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))(\.(\d+))?)|180(\.0+)?)$/'],
            'category' => 'required|numeric|in:1,2,3',
            'incidentDate' => 'required|date',
            'createDate' => 'date',
            'modifyDate' => 'date',
            'people.*' => 'required|array',
            'people.*.type' => 'in:witness,staff',
            'title' => 'required|string'
        ]);

        if ($validator->fails()) {
            $this->statusCode = 422;
            return $this->errorResponse($validator->messages());
        }

        $incident = new Incident();
        $incident->location = json_encode($request->location);
        $incident->category = $request->category;
        $incident->incidentDate = Carbon::parse($request->incidentDate)->toDateTimeString();
        $incident->title = $request->title;
        $incident->comments = $request->comments;

        if (!empty($request->createDate)) {
            $incident->createDate = Carbon::parse($request->createDate)->toDateTimeString();
        }

        if (!empty($request->modifyDate)) {
            $incident->modifyDate = Carbon::parse($request->modifyDate)->toDateTimeString();
        }
        try {
            $incident->save();

            $peopoles = $request->people;
            $peoplesArray = [];
            foreach ($peopoles as $key => $peopole) {
                $peoplesArray[$key]['incident_id'] = $incident->id;
                $peoplesArray[$key]['name'] = $peopole['name'];
                $peoplesArray[$key]['type'] = $peopole['type'];
            }
            $this->peoples->insert($peoplesArray);

        } catch (\Exception $exception) {
            $this->statusCode = 422;
            return $this->errorResponse($exception->getMessage());
        }
        $this->statusCode = 201;
        return $this->successResponse($incident);
    }
}
