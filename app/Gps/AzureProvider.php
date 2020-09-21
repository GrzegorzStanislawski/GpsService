<?php
/**
 * Rest Api response helper class.
 *
 * PHP version >= 5.5.9
 *
 * @category   Dedicated_Software.
 * @package    Api
 * @subpackage Modules
 * @author     Jakub Juszczyk <jakub.juszczyk@witchcraftstudios.com>
 * @copyright  2016 Witchcraft Studios Sp. z o.o. (REGON 140871752)
 * @license    Witchcraft Studios
 * @link       http://www.witchcraftstudios.com
 */

namespace App\Gps;

use App\Gps\GpsProviderInterface;

/**
 * Class helping build consistent and correct response for Api.
 * In time sensitive interfaces make sure to create,
 * object before you start database operations.
 *
 * PHP version >= 5.5.9
 *
 * @category   Dedicated_Software.
 * @package    Api
 * @subpackage Modules
 * @author     Jakub Juszczyk <jakub.juszczyk@witchcraftstudios.com>
 * @copyright  2016 Witchcraft Studios Sp. z o.o. (REGON 140871752)
 * @license    Owner Witchcraft Studios
 * @link       http://www.witchcraftstudios.com
 */
class AzureProvider implements GpsProviderInterface
{


    public function __construct($token)
    {
        $this->token = $token;

    }//end __construct()


    public function getByAddress(string $address)
    {
        $client   = new \GuzzleHttp\Client(['base_uri' => 'https://atlas.microsoft.com/']);
        $response = $client->request(
            'GET',
            'search/address/json',
            [
                'query' => [
                    'subscription-key' => $this->token,
                    'api-version'      => 1.0,
                    'query'            => urlencode($address),
                ],
            ]
        );

        $data   = (array) json_decode($response->getBody(), true);
        $return = [];

        foreach ($data['results'] as $item) {
            if ($item['type'] === 'Point Address') {
                $return = $item;
                break;
            }//end if
        }//end foreach

        if (empty($return) === true) {
            foreach ($data['results'] as $item) {
                if (in_array($item['type'], ['POI', 'Geography']) === false) {
                    $return = $item;
                    break;
                }//end if
            }//end foreach
        }//end if

        if (empty($return) === true) {
            $return = $data['results'][0];
        }//end if

        return [
            'lat' => $return['position']['lat'],
            'lng' => $return['position']['lon'],
        ];

    }//end getByAddress()


    public function getByPosition(array $position)
    {
        $client   = new \GuzzleHttp\Client(['base_uri' => 'https://atlas.microsoft.com/']);
        $response = $client->request(
            'GET',
            'search/address/reverse/json',
            [
                'query' => [
                    'subscription-key' => $this->token,
                    'api-version'      => 1.0,
                    'query'            => $position['lat'].','.$position['lng'],
                ],
            ]
        );

        $data     = (array) json_decode($response->getBody(), true);
        $sAddress = '';

        if (isset($data['addresses'][0]['address']['freeformAddress']) === true) {
            $sAddress = (string) $data['addresses'][0]['address']['freeformAddress'];
        }//end if

        return trim($sAddress);

    }//end getByPosition()


}//end class