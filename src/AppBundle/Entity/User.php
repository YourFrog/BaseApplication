<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\UserInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 *  Encja opisująca użytkownika
 *
 * @ORM\Entity
 * @ORM\Table(schema="security", name="app_user")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser implements ParticipantInterface, AdvancedUserInterface
{
    use Common;

    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_expired", type="boolean", nullable=false)
     */
    private $isExpired = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_locked", type="boolean", nullable=false)
     */
    private $isLocked = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_credentials_expired", type="boolean", nullable=false)
     */
    private $isCredentialsExpired = false;

    /**
     *  Konstruktor
     */
    public function __construct()
    {
        parent::__construct();

        $this->createAt = new \DateTime();
        $this->roles = [UserInterface::ROLE_DEFAULT];
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonExpired()
    {
        return !$this->isExpired;
    }

    /**
     * {@inheritdoc}
     */
    public function isAccountNonLocked()
    {
        return !$this->isLocked;
    }

    /**
     * {@inheritdoc}
     */
    public function isCredentialsNonExpired()
    {
        return !$this->isCredentialsExpired;
    }

    /**
     *  Zablokowanie konta
     */
    public function lock()
    {
        $this->isLocked = true;
    }

    /**
     *  Odblokowanie konta
     */
    public function unlock()
    {
        $this->isLocked = false;
    }
}
