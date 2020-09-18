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
            $this->address = $request->input('address');

            $this->address = 'Dworskiego 55/50, Przemysl, Polska';

            if ((bool) $this->address === false) {
                throw new \Exception('Empty field address');
            }//end if

            $this->cacheReturn();
            $this->init($request);

            $position = $this->provider->getByAddress($this->address);

            \Db::insert(
                'INSERT INTO `GPS_CACHE` (`LAT`, `LNG`, `ADDRESS`, `USED`, `CREATED_AT`, `CREATED_BY`) VALUES (:LAT, :LNG, :ADDRESS, 1, :CREATED_AT, :CREATED_BY)',
                [
                    'LAT'        => $position['lat'],
                    'LNG'        => $position['lng'],
                    'ADDRESS'    => $this->address,
                    'CREATED_AT' => date('Y-m-d H:i:s'),
                    'CREATED_BY' => 'TEST',
                ]
            );

            ApiResponse::send(200, $position);
        } catch (\Exception $e) {
            ApiResponse::send(400, null, $e->getMessage());
        }//end if

    }//end address()


    public function cacheReturn(): void
    {
        $data = (array) \Db::selectOne(
            'SELECT LAT, LNG FROM GPS_CACHE WHERE UPPER(ADDRESS) LIKE UPPER(:SEARCH) LIMIT 1',
            ['SEARCH' => '%'.$this->address.'%']
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
