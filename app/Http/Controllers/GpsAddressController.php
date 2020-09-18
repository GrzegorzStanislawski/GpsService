<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\ApiResponse;

class GpsAddressController extends GpsController
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
            $this->position = [
                'lat' => $request->input('lat'),
                'lng' => $request->input('lng'),
            ];

            if ((bool) $this->position['lat'] === false) {
                throw new \Exception('Empty field lat');
            }//end if

            if ((bool) $this->position['lng'] === false) {
                throw new \Exception('Empty field lng');
            }//end if

            $this->cacheReturn();
            $this->init($request);
            $this->address = $this->provider->getByPosition($this->position);
            $this->cache();
            ApiResponse::send(200, ['address' => $this->address]);
        } catch (\Exception $e) {
            ApiResponse::send(400, null, $e->getMessage());
        }//end if

    }//end address()


    public function cacheReturn(): void
    {
        $data = (array) \Db::selectOne(
            'SELECT LAT, LNG FROM GPS_CACHE WHERE LAT = :LAT AND LNG = :LNG LIMIT 1',
            [
                'LAT' => $this->position['lat'],
                'LNG' => $this->position['lng'],
            ]
        );

        if (empty($data) === false) {
            ApiResponse::send(
                200,
                [
                    'lat' => (float) $data['LAT'],
                    'lng' => (float) $data['LNG'],
                ]
            );
        }//end if

    }//end cacheReturn()

    //
}
