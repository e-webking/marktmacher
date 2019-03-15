<?php
declare(strict_types=1);
namespace In2code\Armfemanager\Controller;

/**
 * Class EditController
 */
class EditController extends \In2code\Femanager\Controller\EditController
{

    /**
     * @param \In2code\Armfemanager\Domain\Model\User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @return void
     */
    public function updateAction(\In2code\Armfemanager\Domain\Model\User $user)
    {
        parent::updateAction($user);
    }

}
