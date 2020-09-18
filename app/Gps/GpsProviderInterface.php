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
interface GpsProviderInterface
{

	public function getByAddress(String $address);

	public function getByPosition(array $position);


}//end class