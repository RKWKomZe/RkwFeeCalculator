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
 * Class ZeroPlaceholderViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ZeroPlaceholderViewHelper extends AbstractViewHelper
{

    /**
     * Show zero value as empty
     *
     * due to https://fluidtypo3.org/viewhelpers/fluid/master/Form/TextfieldViewHelper.html commit 967b86239e2459ce60938dbe42f0a66129942e1d
     *
     * @param float $value
     * @return string
     */
    public function render($value = '0')
    {
        $value = ($value == '0') ? '' : $value;

        return $value;

    }

}
