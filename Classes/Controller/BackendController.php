<?php

namespace RKW\RkwFeecalculator\Controller;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * BackendController
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * calculatorRepository
     *
     * @var \Rkw\RkwFeecalculator\Domain\Repository\CalculatorRepository
     * @inject
     */
    protected $calculatorRepository = null;

    /**
     * action index
     */
    public function indexAction()
    {
        $calculators = $this->calculatorRepository->findAll();

        $this->view->assign('calculators', $calculators);
    }

    /**
     * action create
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator|null $newCalculator
     */
    public function createAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $newCalculator = null)
    {
        $this->view->assignMultiple(
            array(
                'calculator'       => $newCalculator
            )
        );
    }

    /**
     * action store
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function storeAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator)
    {
        $this->calculatorRepository->add($calculator);
        $this->redirect('index');
    }

    /**
     * action show
     *
     */
    public function showAction()
    {
    }

    /**
     * action edit
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator
     */
    public function editAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator)
    {
        $this->view->assignMultiple(
            array(
                'calculator'       => $calculator
            )
        );
    }

    /**
     * action update
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator)
    {
        $this->calculatorRepository->update($calculator);
        $this->redirect('index');
    }

    /**
     * action delete
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator)
    {
        $this->calculatorRepository->remove($calculator);
        $this->redirect('index');
    }

}