<?php

// src/Security/PostVoter.php
namespace App\Domain\Concession\Security;

use App\Domain\Concession\Entity\Concession;
use App\Domain\User\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ConcessionVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof Concession) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$concession instanceof Concession) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return true;
        }
        // you know $subject is a Post object, thanks to `supports()`
        /** @var Concession $concession */
        $concession = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canViewSA($user);
            case self::EDIT:
                return $this->canEdit($concession, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canViewSA(User $user)
    {
        // if he's not super admin, he can't view
        if ($user->getRoles() == 'ROLE_SUPER_ADMIN') {
            return false;
        }
    }

    private function canEdit(Concession $concession, User $user)
    {
        // this assumes that the Post object has a `getOwner()` method
        return $user === $concession->getOwner();
    }
}
