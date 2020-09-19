<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    protected function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Return API success response
     * @param array $data response data
     * @param array $paginateData paginate data
     * @param array $additionalData additional data
     * @return JsonResponse
     *
     */
    public function successResponse($data, $paginateData = [], $additionalData = [])
    {
        $response = $paginateResponseArray = [];
        $dataArray['data'] = !empty($data) ? $data : [];
        $additionalDataArray = !empty($additionalData) ? $additionalData : [];
        if (!empty($paginateData)) {
            $paginateDataArray = $this->responseWithPagination($paginateData);
        }
        $paginateResponseArray = !empty($paginateDataArray) ? $paginateDataArray : [];
        $response = array_merge($dataArray, $additionalDataArray, $paginateResponseArray);

        $response['success'] = true;
        $response['status_code'] = $this->getStatusCode();
        return response()->json($response, $this->getStatusCode());
    }


    /**
     * Returns API error response
     * @param $errors
     * @return JsonResponse
     */
    public function errorResponse($errors)
    {
        $response['success'] = false;
        $response['errors'] = $errors;
        $response['status_code'] = $this->getStatusCode();
        return response()->json($response, $this->getStatusCode());
    }

    /**
     *@author Atul Singh <atulk.singh@vfirst.com>
     * Return pagination detail of given data
     * @param Paginator $items
     * @return array
     */
    protected function responseWithPagination(Paginator $items)
    {
        $data = [];
        if (!empty($items)) {
            $data = [
                "paginator" => [
                    "total_count" => $items->total(),
                    "total_pages" => ceil($items->total() / $items->perPage()),
                    "current_page" => $items->currentPage(),
                    "limit" => $items->perPage()
                ]
            ];
        }
        return $data;
    }

    protected function paginateResponse(Paginator $items, $data)
    {
        $result = [];
        if (!empty($data)) {
            $result['data'] = $data;
            $result['data'][0]['paginator'] = [
                "total_count" => $items->total(),
                "total_pages" => ceil($items->total() / $items->perPage()),
                "current_page" => $items->currentPage(),
                "limit" => $items->perPage()
            ];
        }
        return $this->respond($result);
    }

    protected function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

}
