<?php
namespace RKW\RkwFeecalculator\Controller;

use RKW\RkwFeecalculator\Domain\Model\Calculation;

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
     * @var \RKW\RkwFeecalculator\Domain\Repository\CalculatorRepository
     * @inject
     */
    protected $calculatorRepository = null;

    /**
     * action show
     *
     * @param \RKW\RkwFeecalculator\Domain\Model\Calculation $calculation
     * @return void
     */
    public function showAction(\RKW\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {

        if (! $calculation) {
            $calculation = new Calculation();
            $calculation->setCalculator($this->calculatorRepository->findByUid($this->settings['calculator']));
        }

        $this->view->assignMultiple([
            'calculation' => $calculation,
            'assignedPrograms' => $calculation->getCalculator()->getAssignedPrograms()->toArray(),
        ]);

    }

    /**
     * action store
     *
     * @validate $calculation \RKW\RkwFeecalculator\Validation\CalculationValidator
     * @param Calculation|null $calculation
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function storeAction(\RKW\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {
        if ($calculation === null) {
            $this->redirect('show');
        }

        $this->forward('show', null, null, array('calculation' => $calculation));

    }
}
