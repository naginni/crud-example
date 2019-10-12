<?php
namespace Example\helpers;

class Helpers
{
    /**
     * This function uses curl to connect to the petstore.swagger.io API *
     *
     * @param String $method
     * @param String $url
     * @param String $data
     *
     * @return Array
     */
    public function call(string $method, string $url, string $data): array
    {
       $ch = curl_init();
       $headers = [
          'Content-Type: application/json',
       ];

       switch ($method) {
          case 'POST':
            // set up the post method and check if the data isn't empty
            curl_setopt($ch, CURLOPT_POST, true);
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            break;
          case 'PUT':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if (!empty($data)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            }
            break;
          case 'DELETE':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
          default:
            if (!empty($data)) {
                $url = sprintf("%s?%s", $url, http_build_query($data));
            }
       }

       // OPTIONS:
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // EXECUTE:
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [
            'response' => $result,
            'httpstatus' => $httpCode,
        ];
    }
}

