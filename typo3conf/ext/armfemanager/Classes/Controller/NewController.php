<?php
declare(strict_types=1);
namespace In2code\Armfemanager\Controller;

/**
 * Class NewController
 */
class NewController extends \In2code\Femanager\Controller\NewController
{

    /**
     * action create
     *
     * @param \In2code\Armfemanager\Domain\Model\User $user
     * @validate $user In2code\Femanager\Domain\Validator\ServersideValidator
     * @validate $user In2code\Femanager\Domain\Validator\PasswordValidator
     * @return void
     */
    public function createAction(\In2code\Armfemanager\Domain\Model\User $user)
    {
        parent::createAction($user);
    }
}
