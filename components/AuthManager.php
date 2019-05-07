<?php

namespace app\components;

use app\models\User;
use yii\rbac\Assignment;
use yii\rbac\PhpManager;
use Yii;

class AuthManager extends PhpManager
{


    /**
     * @param $userId
     * @return array|mixed|Assignment[]
     */
    public function getAssignments($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $assignment = new Assignment();
            $assignment->userId = $userId;
            $assignment->roleName = $user->role;
            return [$assignment->roleName => $assignment];
        }
            return [];
    }

    /**
     * @param $roleName
     * @param $userId
     * @return null|Assignment
     */
    public function getAssignment($roleName, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if ($user->role == $roleName) {
                $assignment = new Assignment();
                $assignment->userId = $userId;
                $assignment->roleName = $user->role;
        return $assignment;
             }
         }
        return null;
    }

    /**
     * @param $roleName
     * @return array
     */
    public function getUserIdsByRole($roleName)
    {
        return User::find()->where(['role' => $roleName])->select('id')->column();
    }

    /**
     * @param $role
     * @param $userId
     * @return mixed|null|Assignment
     */
    public function assign($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $assignment = new Assignment([
            'userId' => $userId,
            'roleName' => $role->name,
            'createdAt' => time(),
            ]);
            $this->setRole($user, $role->name);
            return $assignment;
        }
            return null;
    }

    /**
     * @param $role
     * @param $userId
     * @return bool
     */
    public function revoke($role, $userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            if ($user->role == $role->name) {
                $this->setRole($user, null);
                return true;
            }
        }
        return false;
    }

    /**
     * @param $userId
     * @return bool
     */
    public function revokeAll($userId)
    {
        if ($userId && $user = $this->getUser($userId)) {
            $this->setRole($user, null);
            return true;
        }
    return false;
    }

    /**
    * @param integer $userId
    * @return null|\yii\web\IdentityInterface|User
    */
    private function getUser($userId)
    {
        $webUser = Yii::$app->get('user', false);
        if ($webUser && !$webUser->getIsGuest() && $webUser->getId() == $userId) {
            return $webUser->getIdentity();
        } else {
            return User::findOne($userId);
        }
    }

    /**
    * @param User $user
    * @param string $roleName
    */
    private function setRole(User $user, $roleName)
    {
        $user->role = $roleName;
        $user->updateAttributes(['role' => $roleName]);
    }
}