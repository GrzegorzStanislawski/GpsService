<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gps\AzureProvider;
use App\Gps\GoogleProvider;
use App\Http\ApiResponse;

class GpsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function address(Request $request): void
    {
        try {
            $address = $request->input('address');

            $address = 'Dworskiego 55/50, Przemysl, Polska';

            if ((bool) $address === false) {
                throw new \Exception('Empty field address');
            }//end if

            $this->_init($request);

            ApiResponse::send(
                200,
                $this->provider->getByAddress($address)
            );
        } catch (\Exception $e) {
            ApiResponse::send(400, null, $e->getMessage());
        }//end if

    }//end address()


    /**
     * Start function of gps service.
     *
     * @return void
     */
    private function _init(Request $request): void
    {
        $provider = $request->input('provider');

        $provider = 'azure';

        if ((bool) $provider === false) {
            throw new \Exception('Undefined gps service provider');
        }//end if

        if (in_array($provider, ['google', 'azure']) === false) {
            throw new \Exception('Unkwown provider "'.$provider.'"');
        }//end if

        $this->token = $request->input('token');

        $this->token = '123';

        if ((bool) $this->token === false) {
            throw new \Exceptionn('Undefined gps service token');
        }//end if

        if ($provider === 'google') {
            $this->provder = new GoogleProvider($this->token);
        } else {
            $this->provider = new AzureProvider($this->token);
        }//end if

    }//end _init()

    //
}
