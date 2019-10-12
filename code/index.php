<?php
include ('vendor/autoload.php');

use Twig;
use Example\classes\CRUD;

const FILE_CONTENT = __dir__.'/src/datastore/pets.json';
$loader = new Twig_Loader_Filesystem(__dir__ . '/views');
$twig = new Twig_Environment($loader, array('debug' => false));

// instance local variables
$dataStore = file_get_contents(FILE_CONTENT);
if ($dataStore) {
    $dataStore = json_decode($dataStore, true);
}
$pets = [];

// default data
$petsModel = [
    'id' => 0,
    'category' => [
        'id' => 0,
        'name' => 'family',
    ],
    'name' => 'string',
    'photoUrls' => [
        'url',
        'anotherUrl',
    ],
    'tags' => [
        [
            'id' => 0,
            'name' => 'string',
        ],
        [
            'id' => 0,
            'name' => 'string',
        ],
    ],
    'status' => 'string',
];

// Check what is the page necessary to display
$view = (!empty($_GET['page'])) ? $_GET['page'] : 'list';
$crud = new CRUD();

// Routes
switch($view) {
    case 'list':
        if (!empty($dataStore)) {
            $pets = $crud->listAll($dataStore['pets']);
        }
    break;
    case 'create':
        $pets = $petsModel;
        $pets['id'] = end($dataStore['pets']) + 1;
        $method = 'POST';
    break;
    case 'update':
        $view = 'edit';
        $data = !empty($_POST['data']) ? $_POST['data'] : [];
        $method = $data['method'];
        unset($data['method']);

        $response = $crud->createUpdate($method, $data, $dataStore);
        $pets = $response['response'];
        $message = $response['message'];
        $method = 'PUT';

    break;
    case 'delete':
        $id = !empty($_GET['id']) ? $_GET['id'] : 0;
        $response = $crud->delete($id, $dataStore);
        $view = 'list';
        $message = $response['message'];
        if ($response['httpstatus'] === 200) {
            $pets = $crud->listAll($dataStore['pets']);
        }
    break;
    case 'edit':
        $params = [
            'find' => 'id',
            'value' => (!empty($_GET['id'])) ? $_GET['id'] : 0,
        ];
        $response = $crud->edit($params);
        $pets = $response['response'];
        $message = $response['message'];
        $method = 'PUT';
    break;

}

// Views
echo $twig->render('pets.html.twig', [
    'pets' => $pets,
    'view' => $view,
    'message' => $message,
    'method' => $method,
]);
?>
