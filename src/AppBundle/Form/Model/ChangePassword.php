<?php

namespace AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{

    /**
     * @var string
     * @SecurityAssert\UserPassword(message="Invalid old password.")
     */
    protected $oldPassword;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Your password must be at least {{ limit }} characters
     *   long",
     * )
     * @Assert\Regex(
     *     pattern="/[a-z0-9]+/",
     *     message="Your password can only contain lowercase letter and digits"
     * )
     */
    private $newPassword;

    /**
     * @return string
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     *
     * @return ChangePassword
     */
    public function setOldPassword(string $oldPassword): ChangePassword
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     *
     * @return ChangePassword
     */
    public function setNewPassword(string $newPassword): ChangePassword
    {
        $this->newPassword = $newPassword;
        return $this;
    }
}