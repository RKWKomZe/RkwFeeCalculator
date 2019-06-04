<?php

namespace RKW\RkwFeecalculator\Controller;

/**
 * BackendProgramController
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwFeeProgram
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BackendProgramController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

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
        $programs = $this->programRepository->findAll();

        $this->view->assign('programs', $programs);
    }

    /**
     * action create
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program|null $program
     */
    public function createAction(\Rkw\RkwFeecalculator\Domain\Model\Program $program = null)
    {
        $this->view->assignMultiple(
            array(
                'calculator'       => $program,
                'assignablePrograms' => $this->programRepository->findAll()
            )
        );
    }

    /**
     * action store
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $program
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function storeAction(\Rkw\RkwFeecalculator\Domain\Model\Program $program)
    {
        $this->programRepository->add($program);
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
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $program
     */
    public function editAction(\Rkw\RkwFeecalculator\Domain\Model\Program $program)
    {
        $this->view->assignMultiple(
            array(
                'program'       => $program,
            )
        );
    }

    /**
     * action update
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $program
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateAction(\Rkw\RkwFeecalculator\Domain\Model\Program $program)
    {
        $this->programRepository->update($program);
        $this->redirect('index');
    }

    /**
     * action delete
     *
     * @param \Rkw\RkwFeecalculator\Domain\Model\Program $program
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    public function deleteAction(\Rkw\RkwFeecalculator\Domain\Model\Program $program)
    {
        $this->programRepository->remove($program);
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