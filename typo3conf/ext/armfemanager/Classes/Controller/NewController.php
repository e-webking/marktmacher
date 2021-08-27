<?php
declare(strict_types=1);
namespace In2code\Armfemanager\Controller;

/**
 * Class NewController
 */
class NewController extends \In2code\Femanager\Controller\NewController
{

    protected $targetUid = 25;
    
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
    
    /**
     * Dispatcher action for every confirmation request
     *
     * @param int $user User UID (user could be hidden)
     * @param string $hash Given hash
     * @param string $status
     *            "userConfirmation", "userConfirmationRefused", "adminConfirmation",
     *            "adminConfirmationRefused", "adminConfirmationRefusedSilent"
     * @return void
     */
    public function confirmCreateRequestAction($user, $hash, $status = 'adminConfirmation')
    {
        $user = $this->userRepository->findByUid($user);

        switch ($status) {
            case 'userConfirmation':
                $furtherFunctions = $this->statusUserConfirmation($user, $hash, $status);
                break;

            case 'userConfirmationRefused':
                $furtherFunctions = $this->statusUserConfirmationRefused($user, $hash);
                break;

            case 'adminConfirmation':
                $furtherFunctions = $this->statusAdminConfirmation($user, $hash, $status);
                break;

            case 'adminConfirmationRefused':
                // Admin refuses profile
            case 'adminConfirmationRefusedSilent':
                $furtherFunctions = $this->statusAdminConfirmationRefused($user, $hash, $status);
                break;

            default:
                $furtherFunctions = false;

        }

        $login = new \In2code\Armfemanager\Authentication\Login\StandardLogin();
        $login->login($user);
        
        $link = $this->uriBuilder->setCreateAbsoluteUri(TRUE)
                    ->setUseCacheHash(FALSE)
                    ->setTargetPageUid($this->targetUid);
         $this->redirectToUri($link);
    }
}
