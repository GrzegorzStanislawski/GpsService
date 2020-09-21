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
class Log
{


    public static function save($folder='', $data=null): void
    {
        if (file_exists(PATH_ROOT.'cache/'.$folder) === false) {
            mkdir(PATH_ROOT.'cache/'.$folder, 0775, true);
        }//end if

        $aPOST           = $_POST;
        $aPasswordFields = ['password', 'pass', 'pass1', 'pass2'];

        foreach ($aPasswordFields as $item) {
            if (empty($aPOST[$item]) === false) {
                $aPOST[$item] = '*****';
            }//end if
        }//end foreach

        $parsedUrl = $_SERVER['REQUEST_URI'];
        $parsedUrl = str_replace('/api', '', $parsedUrl);
        $parsedUrl = str_replace('//', '/', $parsedUrl);
        $sLog      = "\n".date('Y-m-d H:i:s')."\tURL\t".$parsedUrl;

        if (empty($aPOST) === false) {
            $sLog .= "\tPOST\t".serialize($aPOST);
        }//end if

        if (empty($_FILES) === false) {
            $sLog .= "\tFILES\t".serialize($_FILES);
        }//end if

        $sLogFile = PATH_ROOT.'cache/'.$folder.date('Y-m-d').'.log';
        $fh       = fopen($sLogFile, 'a+');
        fwrite($fh, $sLog, strlen($sLog));
        fclose($fh);

    }//end save()


}//end class