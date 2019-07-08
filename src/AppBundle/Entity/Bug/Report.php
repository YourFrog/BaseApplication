<?php

namespace AppBundle\Entity\Bug;

use AppBundle\Entity\Common;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(schema="bug", name="report")
 * @ORM\HasLifecycleCallbacks()
 */
class Report
{
    use Common;

    const STATUS_OPEN = 1;
    const STATUS_CONFIRM = 2;
    const STATUS_REJECT = 3;
    const STATUS_CLOSE = 4;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", name="id_report")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     *  Tytuł błędu
     *
     * @var Subject
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Bug\Subject")
     * @ORM\JoinColumn(name="id_subject", referencedColumnName="id_subject")
     */
    private $subject;

    /**
     *  Częstotliwość wystąpienia błędu
     *
     * @var Frequency
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Bug\Frequency")
     * @ORM\JoinColumn(name="id_frequency", referencedColumnName="id_frequency")
     */
    private $frequency;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = self::STATUS_OPEN;

    /**
     *  Adres URL którego dotyczy błąd
     *
     * @var string
     *
     * @ORM\Column(name="link", type="string", nullable=false)
     */
    private $link;

    /**
     *  Opis użytkownika dotyczący błędu
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     *  Adres e-mail na który należy zwrócić się z odpowiedzią
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=false)
     */
    private $email;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return Frequency
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param Subject $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @param Frequency $frequency
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}