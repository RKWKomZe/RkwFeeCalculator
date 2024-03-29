<?php
namespace RKW\RkwFeecalculator\Controller;

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

use RKW\RkwFeecalculator\Domain\Model\Calculation;
use RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class CalculationController
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwFeecalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CalculationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ?CalculatorRepository $calculatorRepository = null;


    /**
     * @var \RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository
     */
    public function injectCheckupRepository(CalculatorRepository $calculatorRepository)
    {
        $this->calculatorRepository = $calculatorRepository;
    }


    /**
     * action show
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Calculation|null $calculation
     * @return void
     */
    public function showAction(Calculation $calculation = null): void {

        if (!$calculation) {
            $calculation = GeneralUtility::makeInstance(Calculation::class);
            $calculation->setCalculator($this->calculatorRepository->findByUid($this->settings['calculator']));
        }

        $this->view->assignMultiple([
            'calculation'      => $calculation,
            'assignedPrograms' => $calculation->getCalculator()->getAssignedPrograms()->toArray(),
        ]);

    }


    /**
     * action store
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Calculation|null $calculation
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @TYPO3\CMS\Extbase\Annotation\Validate("RKW\RkwFeecalculator\Validation\CalculationValidator", param="calculation")
     */
    public function storeAction(Calculation $calculation = null): void {

        if ($calculation === null) {
            $this->redirect('show');
        }

        $this->forward('show', null, null, ['calculation' => $calculation]);
    }
}
