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

        if (! $calculator) {    //  @todo: Ist das korrekt?
            $calculator = $this->calculatorRepository->findByUid($this->settings['calculator']);
        }

        $this->view->assign('calculator', $calculator);
    }

    /**
     * action store
     *
     */
    public function storeAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator)
    {
        $calculator->calculate();

        $this->forward('show', null, null, array('calculator' => $calculator));

    }
}
