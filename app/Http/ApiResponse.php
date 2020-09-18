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

namespace App\Http;

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
class ApiResponse
{


    public static function send($status=200, $data=null, $error=null): void
    {
        if ($data === null) {
            $data = (Object) null;
        }//end if

        $oDateTime = new \DateTime;
        $response  = [
            'status'      => (int) $status,
            'data'        => $data,
            'description' => [
                'error_code'        => '',
                'error_description' => $error,
                'message'           => '',
                'validator'         => [],
            ],
            'server'      => [
                'timestamp'       => (int) $oDateTime->format('U'),
                'server_version'  => '',
                'server_instance' => 'gps_service',
            ],
        ];

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($response);
        exit;

    }


}//end class