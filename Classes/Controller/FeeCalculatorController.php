<?php
namespace Rkw\RkwFeecalculator\Controller;

use Rkw\RkwFeecalculator\Domain\Model\Calculator;
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
 * FeeCalculatorController
 */
class FeeCalculatorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator
     * @return void
     */
    public function showAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator = null)
    {

        $this->initializeAction();

        if (! $calculator) {
            $calculator = $this->calculatorRepository->findByUid($this->settings['calculator']);
        }

        $this->view->assignMultiple([
            'calculator' => $calculator,
            'assignedPrograms' => $calculator->getAssignedPrograms()->toArray()
        ]);

    }


    /**
     * action store
     *
     * @param Calculator|null $calculator
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function storeAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator = null)
    {
        if ($calculator === null) {
            $this->redirect('show');
        }

        $calculator->calculate();

        $this->forward('show', null, null, array('calculator' => $calculator));

    }
}
