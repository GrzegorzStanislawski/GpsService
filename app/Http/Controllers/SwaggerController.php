<?php

namespace App\Http\Controllers;

class SwaggerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function schema(): void
    {
        $file = dirname(__DIR__).'/../../public/assets/swagger.json';
        $file = file_get_contents($file);

        header('Content-type: application/json; charset=utf-8');
        echo $file;
        exit;

    }//end schema()


}