<?php
namespace Rkw\RkwFeecalculator\Controller;

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
 * InstitutionController
 */
class InstitutionController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * institutionRepository
     *
     * @var \Rkw\RkwFeecalculator\Domain\Repository\InstitutionRepository
     * @inject
     */
    protected $institutionRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $institutions = $this->institutionRepository->findAll();
        $this->view->assign('institutions', $institutions);
    }
}
