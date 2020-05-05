<?php

namespace RKW\RkwFeecalculator\ViewHelpers;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class DynamicPropertyViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DynamicPropertyViewHelper extends AbstractViewHelper
{

    /**
     * Returns dynamically set property from object
     *
     * @todo: This ViewHelper might not be necessary in TYPO3 8 anymore.
     *
     * @param $obj  object Object
     * @param $prop string Property
     *
     * @return mixed|null
     */
    public function render($obj, $prop) {

        $getter = 'get' . ucfirst($prop);

        if (is_object($obj) && method_exists($obj, $getter)) {
            return $obj->$getter();
        }

        if (is_array($obj) && array_key_exists($prop, $obj)) {
            return $obj[$prop];
        }

        return NULL;
    }

}
