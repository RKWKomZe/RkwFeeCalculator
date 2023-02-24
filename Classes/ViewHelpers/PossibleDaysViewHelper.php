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

use RKW\RkwFeecalculator\Domain\Model\Program;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class PossibleDaysViewHelper
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class PossibleDaysViewHelper extends AbstractViewHelper
{

    /**
     * Initialize arguments.
     *
     * @return void
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('program', Program::class, 'The program class.', false,  null);
    }


    /**
     * Get the possible days
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Program|null $program
     * @return array
     */
    public function render(Program $program = null): array
    {
        /** @var \RKW\RkwFeecalculator\Domain\Model\Program $program */
        $program = $this->arguments['program'];

        return $program ? $program->getPossibleDays() : [];
    }

}
