<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gps\AzureProvider;
use App\Gps\GoogleProvider;

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


    /**
     * Start function of gps service.
     *
     * @return void
     */
    public function init(Request $request): void
    {
        $provider = $request->input('provider');

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

    //
}
