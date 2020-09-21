<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gps\AzureProvider;
use App\Gps\GoogleProvider;
use App\Http\ApiResponse;

class GpsController extends Controller
{

    public $token;

    public $address;

    public $position;

    /**
     * Provder class.
     *
     * @var mixed
     */
    public $provider;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function providers(): void
    {
        $data   = [];
        $data[] = [
            'code' => 'azure',
            'name' => 'Azure API'
        ];
        $data[] = [
            'code' => 'google',
            'name' => 'Google API'
        ];

        ApiResponse::send(200, $data);

    }//end providers()


    /**
     * Start function of gps service.
     *
     * @return void
     */
    public function init(Request $request): void
    {
        $provider = $request->post('provider');

        if ((bool) $provider === false) {
            throw new \Exception('Undefined gps service provider');
        }//end if

        if (in_array($provider, ['google', 'azure']) === false) {
            throw new \Exception('Unkwown provider "'.$provider.'"');
        }//end if

        $this->token = $request->input('token');

        if ((bool) $this->token === false) {
            throw new \Exceptionn('Undefined gps service token');
        }//end if

        if ($provider === 'google') {
            $this->provder = new GoogleProvider($this->token);
        } else {
            $this->provider = new AzureProvider($this->token);
        }//end if

    }//end init()

    
    public function cache(): void
    {
        \Db::insert(
            'INSERT INTO `GPS_CACHE` (`LAT`, `LNG`, `ADDRESS`, `USED`, `CREATED_AT`, `CREATED_BY`) VALUES (:LAT, :LNG, :ADDRESS, 1, :CREATED_AT, :CREATED_BY)',
            [
                'LAT'        => $this->position['lat'],
                'LNG'        => $this->position['lng'],
                'ADDRESS'    => $this->address,
                'CREATED_AT' => date('Y-m-d H:i:s'),
                'CREATED_BY' => 'TEST',
            ]
        );

    }//end cache()


}