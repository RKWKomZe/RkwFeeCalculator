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
     * programRepository
     *
     * @var \Rkw\RkwFeecalculator\Domain\Repository\ProgramRepository
     * @inject
     */
    protected $programRepository = null;

    /**
     * action index
     */
    public function indexAction()
    {
        $calculators = $this->calculatorRepository->findAll();
        $programs = $this->programRepository->findAll();

        $this->view->assignMultiple(
            array(
                'calculators' => $calculators,
                'programs' => $programs
            )
        );
    }

}