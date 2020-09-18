<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\ApiResponse;

class GpsPositionController extends GpsController
{


    /**
     * Fetch position address.
     *
     * @param Request $request Current request.
     *
     * @throws \Exception
     * @return void
     */
    public function position(Request $request): void
    {
        try {
            $this->address = $request->input('address');

            if ((bool) $this->address === false) {
                throw new \Exception('Empty field address');
            }//end if

            $this->cacheReturn();
            $this->init($request);
            $this->position = $this->provider->getByAddress($this->address);
            $this->cache();
            ApiResponse::send(200, $this->position);
        } catch (\Exception $e) {
            ApiResponse::send(400, null, $e->getMessage());
        }//end if

    }//end position()


    /**
     * Try fetch result from cache.
     *
     * @return void
     */
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


}//end class