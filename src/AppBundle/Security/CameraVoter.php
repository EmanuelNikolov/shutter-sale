<?php

namespace AppBundle\Security;

use AppBundle\Entity\Camera;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CameraVoter extends Voter
{

    const EDIT = 'EDIT';

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user
     *   wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false
     *   otherwise
     */
    protected function supports($attribute, $subject): bool
    {
        if (!in_array($attribute, [self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Camera) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject
     * and token. It is safe to assume that $attribute and $subject already
     * passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute(
      $attribute,
      $subject,
      TokenInterface $token
    ): bool {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $camera = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($camera, $user);
        }

        throw new \LogicException("This ain't supposed to happen my man, what'd you do?!");
    }

    private function canEdit(Camera $camera, User $user): bool
    {
        return $user === $camera->getUser();
    }
}