<?php


$host = 'https://petstore.swagger.io/v2/pet';
echo "\nStarting RESTFUL Tests\n\n";
//Successfully Creates A Story
$data = [
    'id' => 8002,
    'category' => [
        'id' => 8110,
        'name' => 'family',
    ],
    'name' => 'labrador',
    'photoUrls' => [
        'https://a.travel-assets.com/findyours-php/viewfinder/images/res20/331000/331441-Quintana-Roo.jpg',
        'https://a.travel-assets.com/findyours-php/viewfinder/images/res20/115000/115433-Belize.jpg',
    ],
    'tags' => [
        [
            'id' => 8012,
            'name' => 'travel',
        ],
        [
            'id' => 8022,
            'name' => 'water',
        ],
    ],
    'status' => 'available',
];

$response = callAPI('POST', $host, json_encode($data));
print_r($response);
