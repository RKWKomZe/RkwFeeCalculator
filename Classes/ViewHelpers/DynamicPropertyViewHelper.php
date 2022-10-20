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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use RKW\RkwFeecalculator\Domain\Model\SupportRequest;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

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
     * @param SupportRequest $obj
     * @param                $prop string Property
     * @param                $type string FieldType
     * @param                $raw bool Raw
     * @param                $format string Format
     *
     * @return mixed|null
     * @todo This ViewHelper might not be necessary in TYPO3 8 anymore.
     *
     */
    public function render(SupportRequest $obj, string $prop, $type = 'text', $raw = false, $format = null)
    {

        $getter = 'get' . ucfirst($prop);

        $result = null;

        if (is_object($obj) && method_exists($obj, $getter)) {

            if (in_array($type, ['select', 'radio'])) {

                if ($obj->$getter() instanceof \TYPO3\CMS\Extbase\DomainObject\AbstractEntity) {

                    $result = $this->getTitleOfRelation($getter, $obj);

                } else {

                    if ($raw) {
                        $result = $obj->$getter();
                    } else {
                        $result = LocalizationUtility::translate(
                            'tx_rkwfeecalculator_domain_model_supportrequest.' . $prop . '.' . $obj->$getter(),
                            'RkwFeecalculator'
                        );
                    }

                }

            } else if ($type === 'date') {

                $date = $obj->$getter();

                $result = ($date > 0) ? date('d.m.Y', $date) : '-';

            } else if ($format === 'currency') {

                $result = number_format($obj->$getter(),0,",",".");

            } else {

                $result = $obj->$getter();

            }

        }

        if (is_array($obj) && array_key_exists($prop, $obj)) {
            $result = $obj[$prop];
        }

        return $result;
    }

    /**
     * @param $getter
     * @param $obj
     * @return mixed
     */
    protected function getTitleOfRelation($getter, $obj)
    {
        $model = $obj->$getter();

        if (method_exists($model, 'getName')) {
            $result = $model->getName();
        } elseif (method_exists($model, 'getTitle')) {
            $result = $model->getTitle();
        } else {
            $result = $model;
        }

        return $result;
    }

}
