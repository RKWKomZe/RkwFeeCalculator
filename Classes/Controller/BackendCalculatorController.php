<?php

namespace RKW\RkwFeecalculator\Controller;

/**
 * BackendCalculatorController
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeCalculator
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BackendCalculatorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
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

        $this->view->assign('calculators', $calculators);
    }

    /**
     * action create
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Calculator|null $calculator
     */
    public function createAction(\Rkw\RkwFeecalculator\Domain\Model\Calculator $calculator = null)
    {
        $this->view->assignMultiple(
            array(
                'calculator'       => $calculator,
                'assignablePrograms' => $this->programRepository->findAll()
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
                'calculator'       => $calculator,
                'assignablePrograms' => $this->programRepository->findAll()
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

    /**
     * A special action which is called if the originally intended action could
     * not be called, for example if the arguments were not valid.
     *
     * The default implementation sets a flash message, request errors and forwards back
     * to the originating action. This is suitable for most actions dealing with form input.
     *
     * We clear the page cache by default on an error as well, as we need to make sure the
     * data is re-evaluated when the user changes something.
     *
     * @return string
     */
    protected function errorAction() {
        echo 'ErrorAction';
        $this->clearCacheOnError();
        echo '<pre>';
        foreach ($this->arguments->getValidationResults()->getFlattenedErrors() as $propertyPath => $errors) {
            foreach ($errors as $error) {
                $message .= 'Error for ' . $propertyPath . ': ' . $error->render() .
                    PHP_EOL;
            }
            echo 'Error: ' . $message;

        }
        echo '</pre>';

        $errorFlashMessage = $this->getErrorFlashMessage();
        if ($errorFlashMessage !== FALSE) {
            $errorFlashMessageObject = new \TYPO3\CMS\Core\Messaging\FlashMessage(
                $errorFlashMessage,
                '',
                \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
            );
            $this->controllerContext->getFlashMessageQueue()->enqueue($errorFlashMessageObject);
        }
        $referringRequest = $this->request->getReferringRequest();
        if ($referringRequest !== NULL) {
            $originalRequest = clone $this->request;
            $this->request->setOriginalRequest($originalRequest);
            $this->request->setOriginalRequestMappingResults($this->arguments->getValidationResults());
            $this->forward($referringRequest->getControllerActionName(), $referringRequest->getControllerName(), $referringRequest->getControllerExtensionName(), $referringRequest->getArguments());
        }

        $message = 'An error occurred while trying to call ' . get_class($this) . '->' . $this->actionMethodName . '().' . PHP_EOL;
        return $message;
    }

}