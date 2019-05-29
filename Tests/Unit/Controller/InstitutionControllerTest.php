<?php
namespace Rkw\RkwFeecalculator\Tests\Unit\Controller;

/**
 * Test case.
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class InstitutionControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Rkw\RkwFeecalculator\Controller\InstitutionController
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = $this->getMockBuilder(\Rkw\RkwFeecalculator\Controller\InstitutionController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function listActionFetchesAllInstitutionsFromRepositoryAndAssignsThemToView()
    {

        $allInstitutions = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\ObjectStorage::class)
            ->disableOriginalConstructor()
            ->getMock();

        $institutionRepository = $this->getMockBuilder(\Rkw\RkwFeecalculator\Domain\Repository\InstitutionRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $institutionRepository->expects(self::once())->method('findAll')->will(self::returnValue($allInstitutions));
        $this->inject($this->subject, 'institutionRepository', $institutionRepository);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $view->expects(self::once())->method('assign')->with('institutions', $allInstitutions);
        $this->inject($this->subject, 'view', $view);

        $this->subject->listAction();
    }
}
