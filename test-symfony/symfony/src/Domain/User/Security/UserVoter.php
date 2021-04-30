<?php

// src/Security/PostVoter.php
namespace App\Domain\User\Security;

use App\Domain\User\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class UserVoter extends Voter
{
    // these strings are just invented: you can use anything
    /** @var string  */
    const EDIT = 'edit';

    /** @var string  */
    const ADD = 'add';

    /** @var string  */
    const DELETE = 'delete';

    /** @var Security  */
    private $security;

    /**
     * UserVoter constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports($attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject);
            case self::DELETE:
                return $this->canDelete($subject);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param User $subject
     * @return bool
     */
    private function canEdit(User $subject): bool
    {
        return $this->security->isGranted(current($subject->getRoles()));
    }

    /**
     * @param User $subject
     * @return bool
     */
    private function canDelete(User $subject): bool
    {
        return $this->security->isGranted(current($subject->getRoles()));
    }
}
