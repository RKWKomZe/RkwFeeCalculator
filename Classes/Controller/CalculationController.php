<?php
namespace Rkw\RkwFeecalculator\Controller;

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

        $this->initializeAction();

        if (! $calculation->getCalculator()) {
            $calculation->setCalculator($this->calculatorRepository->findByUid($this->settings['calculator']));
        }

        $this->view->assignMultiple([
            'calculation' => $calculation,
            'assignedPrograms' => $calculation->getCalculator()->getAssignedPrograms()->toArray()
        ]);

    }

    /**
     * action store
     *
     * @validate $calculation \Rkw\RkwFeecalculator\Validation\CalculationValidator
     * @param Calculator|null $calculator
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     */
    public function storeAction(\Rkw\RkwFeecalculator\Domain\Model\Calculation $calculation = null)
    {
        if ($calculation === null) {
            $this->redirect('show');
        }

        $calculation->calculate();

        $this->forward('show', null, null, array('calculation' => $calculation));

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
//    protected function errorAction() {
//        echo 'ErrorAction';
//        $this->clearCacheOnError();
//        echo '<pre>';
//        foreach ($this->arguments->getValidationResults()->getFlattenedErrors() as $propertyPath => $errors) {
//            foreach ($errors as $error) {
//                $message .= 'Error for ' . $propertyPath . ': ' . $error->render() .
//                    PHP_EOL;
//            }
//            echo 'Error: ' . $message;
//        }
//        echo '</pre>';
//
//        $errorFlashMessage = $this->getErrorFlashMessage();
//        if ($errorFlashMessage !== FALSE) {
//            $errorFlashMessageObject = new \TYPO3\CMS\Core\Messaging\FlashMessage(
//                $errorFlashMessage,
//                '',
//                \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
//            );
//            $this->controllerContext->getFlashMessageQueue()->enqueue($errorFlashMessageObject);
//        }
//        $referringRequest = $this->request->getReferringRequest();
//        if ($referringRequest !== NULL) {
//            $originalRequest = clone $this->request;
//            $this->request->setOriginalRequest($originalRequest);
//            $this->request->setOriginalRequestMappingResults($this->arguments->getValidationResults());
//            $this->forward($referringRequest->getControllerActionName(), $referringRequest->getControllerName(), $referringRequest->getControllerExtensionName(), $referringRequest->getArguments());
//        }
//
//        $message = 'An error occurred while trying to call ' . get_class($this) . '->' . $this->actionMethodName . '().' . PHP_EOL;
//        return $message;
//    }
}
