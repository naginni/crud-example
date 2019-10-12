<?php
namespace Example\classes;

use Example\classes\Pet;

class CRUD
{
    private $pet;
    const FILE_CONTENT = __dir__.'/../datastore/pets.json';

    public function __construct()
    {
        $this->pet = new Pet();
    }

    /**
     * Get all pets that have been saved
     *
     * @param Array $ids
     * @return Array
     */
    function listAll(array $ids): array
    {
        return $this->pet->getList($ids);
    }

    /**
     * Get all pets that have been saved
     *
     * @param Array $ids
     * @return Array
     */

    /**
     * This function will decode some parameters that I did not add as array
     * I did this because I have to create more fields and start working
     * with JS to create a smooth experience with the interface. However,
     * the main objective of this micro app is to create a CRUD.
     *
     * @param Array $data
     * @return Array
     */
    function createUpdate(string $method, array $data, array $dataStore): array
    {
        // check that the data and the id of the pet is not empty
        if (empty($data) || empty($data['id'])) {
            return [];
        }

        // keys required to decode
        $stringToArray = ['category', 'photoUrls', 'tags'];
        foreach ($stringToArray as $key) {
            if (empty($data[$key])) {
                continue;
            }

            $data[$key] = json_decode(trim($data[$key]), true);
        }

        // instance class
        // update data
        $response = $this->pet->create($method, $data);

        if ($response['httpstatus'] === 200) {
            $response['response'] = json_decode($response['response'], true);

            // Update datastore file with the new id that has been inserted.
            if ('POST' === $method) {
                $dataStore['pets'][] = $response['response']['id'];
                file_put_contents(self::FILE_CONTENT, json_encode($dataStore));
            }
        }

        return $response;
    }

    /**
     * Get pet by id
     *
     * @param Array $params
     * @return Array
     */
    function edit(array $params): array
    {
        $response = $this->pet->findBy($params);
        if ($response['httpstatus'] === 200) {
            $response['response'] = json_decode($response['response'], true);
        }

        return $response;
    }

    /**
     * Delete pet
     *
     * @param int $id
     * @return Array
     */
    function delete(int $id, array $dataStore): array
    {
        $response = $this->pet->delete($id);

        if ($response['httpstatus'] === 200) {
            $response['response'] = json_decode($response['response'], true);
            // Update datastore file with the new id that has been deleted.
            $index = array_search($id, $dataStore['pets']);
            if ($index >= 0) {
                unset($dataStore['pets'][$index]);
                file_put_contents(self::FILE_CONTENT, json_encode($dataStore));
            }
        }

        return $response;
    }
}

