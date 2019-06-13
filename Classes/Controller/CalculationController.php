<?php
namespace Rkw\RkwFeecalculator\Controller;

use Rkw\RkwFeecalculator\Domain\Model\Calculation;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/***
 *
 * This file is part of the "RKW FeeCalculator" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 Christian Dilger <c.dilger@addorange.de>
 *
 ***/

/**
 * CalculationController
 */
class CalculationController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * calculatorRepository
     *
     * @var \Rkw\RkwFeecalculator\Domain\Repository\CalculatorRepository
     * @inject
     */
    protected $calculatorRepository = null;

    /**
     * action show
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation
     * @return void
     */
    public function showAction(\Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {

        if (! $calculation) {
            $calculation = new Calculation();
            $calculation->setCalculator($this->calculatorRepository->findByUid($this->settings['calculator']));
        }

        $this->view->assignMultiple([
            'calculation' => $calculation,
            'assignedPrograms' => $calculation->getCalculator()->getAssignedPrograms()->toArray(),
            'possibleDays' => ($calculation->getSelectedProgram()) ? $calculation->getSelectedProgram()->getPossibleDays() : [],
        ]);

    }

    /**
     * action store
     *
     * @validate $calculation \Rkw\RkwFeecalculator\Validation\CalculationValidator
     * @param Calculation|null $calculation
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function storeAction(\Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {
        if ($calculation === null) {
            $this->redirect('show');
        }

        $this->forward('show', null, null, array('calculation' => $calculation));

    }
}
