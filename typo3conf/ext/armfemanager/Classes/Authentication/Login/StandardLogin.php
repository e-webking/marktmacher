<?php
declare(strict_types=1);
namespace In2code\Armfemanager\Authentication\Login;

/**
 * Standard Login of users
 *
 */
class StandardLogin extends \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication implements LoginInterface
{    
    /**
     * 
     * @param \In2code\Armfemanager\Domain\Model\User $user
     * @return boolean
     */
    public function login(\In2code\Armfemanager\Domain\Model\User $user)
    {
        $passwordProcessor = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Saltedpasswords\\Salt\\PhpassSalt');

        $loginData = array(
            'uname' => $user->getUsername(), //usernmae
            'uident' => $user->getPassword(), //password
            'status' => 'login'
        );


        $this->checkPid = false;
        $info = $this->getAuthInfoArray();
        $info['db_user']['username_column'] = 'username';

        $user_db = $this->fetchUserRecord($info['db_user'], $loginData['uname']);
        if ($user_db && $passwordProcessor->checkPassword($user->getPassword(), $user_db['password'])) {

            $this->setSession($user_db);
            return true;
        }
        return false;
    }


    private function setSession($user_db) 
    {

        $GLOBALS['TSFE']->fe_user->createUserSession($user_db);
        $GLOBALS['TSFE']->fe_user->user = $user_db;
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'fe_typo_user', $user_db);
    }
}