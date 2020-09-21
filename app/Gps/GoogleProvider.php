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
class GoogleProvider implements GpsProviderInterface
{


    public function __construct($token)
    {
        $this->token = $token;

    }//end __construct()


    public function getByAddress(string $address)
    {
        $client   = new \GuzzleHttp\Client(['base_uri' => 'https://maps.googleapis.com/']);
        $response = $client->request(
            'GET',
            'maps/api/geocode/json',
            [
                'query' => [
                    'key'     => $this->token,
                    'address' => urlencode($address),
                ],
            ]
        );

        $data = (array) json_decode($response->getBody(), true);

        if (isset($data['error_message']) === true) {
            throw new \Exception($data['error_message']);
        }//end if

        $return = $data['results'][0];
        return (array) $result['geometry']['location'];

    }//end getByAddress()


    public function getByPosition(array $position)
    {
        $client   = new \GuzzleHttp\Client(['base_uri' => 'https://maps.googleapis.com/']);
        $response = $client->request(
            'GET',
            'maps/api/geocode/json',
            [
                'query' => [
                    'key'    => $this->token,
                    'sensor' => 'true',
                    'latlng' => $position['lat'].','.$position['lng'],
                ],
            ]
        );

        $data = (array) json_decode($response->getBody(), true);

        if (isset($data['error_message']) === true) {
            throw new \Exception($data['error_message']);
        }//end if

        $sAddress = '';

        if (isset($data['results'][0]['formatted_address']) === true) {
            $sAddress = (string) $data['results'][0]['formatted_address'];
        }//end if

        return trim($sAddress);

    }//end getByPosition()


}//end class