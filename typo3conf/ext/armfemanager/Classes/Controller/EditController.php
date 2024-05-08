<?php
declare(strict_types=1);
namespace In2code\Armfemanager\Controller;

/**
 * Class EditController
 */
class EditController extends \In2code\Femanager\Controller\EditController
{

    public function initializeUpdateAction()
    {
        if ($this->arguments->hasArgument('user')) {
            // Workaround to avoid php7 warnings of wrong type hint.
            /** @var \In2code\Armfemanager\Xclass\Extbase\Mvc\Controller\Argument $user */
            $user = $this->arguments['user'];
            $user->setDataType(\In2code\Armfemanager\Domain\Model\User::class);
        }
    }
    
    /**
     * @param \In2code\Armfemanager\Domain\Model\User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @return void
     */
    public function updateAction($user)
    {
        parent::updateAction($user);
    }

}
