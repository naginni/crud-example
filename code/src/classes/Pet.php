<?php
namespace Example\classes;

use Example\helpers\Helpers;

class Pet
{
    private $host;
    private $api;

    public function __construct()
    {
        $this->host = 'https://petstore.swagger.io/v2/pet';
        $this->api = new Helpers();
    }

    /**
    * @param Array $data
    *
    * @return Array
    */
    public function getList(array $data): array
    {
        $response = [];
        foreach ($data as $key => $id) {
            $params = [
                'find' => 'id',
                'value' => $id,
            ];
            // Check the status of the return and if it is different than 200
            // continue with the next request
            $output = $this->findBy($params);
            if ($output['httpstatus'] !== 200) {
                continue;
            }

            $response[$key] = json_decode($output['response'], true);
        }

        return $response;
    }

    /**
    * @param string $method
    * @param Array $data
    *
    * @return Array
    */
    public function create(string $method, array $data): array
    {
        return $this->updateCreate($method, $data);
    }


    /**
    * @param Array $params
    *
    * @return Array
    */
    public function findBy(array $params): array
    {
        $host = $this->host;
        if ($params['find'] === 'status') {
            $host .= '/findByStatus?status=' . $params['value'];
        }

        if ($params['find'] === 'id') {
            $host .= '/' . $params['value'];
        }

        // Connect with the ENDPOINT
        $response = $this->api->call('GET', $host, '');

        if ($output['httpstatus'] !== 200) {
            $response['message'] = '[ERROR] This pet was not possible to find.';
        }

        return $response;
    }

    /**
    * @param int $id
    *
    * @return Array
    */
    public function delete(int $id): array
    {
        $host = $this->host . '/' . $id;
        $response = $this->api->call('DELETE', $host, '');
        $response['message'] = '[INFO] The pet was delete.';

        if ($response['httpstatus'] !== 200) {
            $response['message'] = '[ERROR] This pet was not possible to delete.';
        }

        return $response;
    }

    /**
    * @param String $data
    * @param Array $data
    *
    * @return Array
    */
    protected function updateCreate(string $method, array $data): array
    {
        $message ='[INFO] The information has been updated.';

        if (empty($data)) {
            $message = '[ERROR] The data is empty impossible to execute your request.';
            return [
                'message' => $message,
                'status' => 400,
            ];
        }

        // Connect with the ENDPOINT
        $response = $this->api->call($method, $this->host, json_encode($data));
        $response['message'] = $message;

        if ($response['httpstatus'] !== 200) {
            $response['message'] = '[ERROR] There is an error in you data please check it again.';
        }

        return $response;
    }
}

