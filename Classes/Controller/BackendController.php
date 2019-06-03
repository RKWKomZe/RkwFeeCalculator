<?php

namespace RKW\RkwFeecalculator\Controller;

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
     * action show
     *
     * @return void
     */
    public function showAction()
    {
//        $this->view->assign('calculator', $calculator);
    }

    /**
     * action create
     *
     * @return void
     */
    public function createAction()
    {
//        $this->view->assign('calculator', $calculator);
    }
}