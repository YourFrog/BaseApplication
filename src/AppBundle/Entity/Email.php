<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WhiteOctober\SwiftMailerDBBundle\EmailInterface;

/**
 *  Encja opisująca wiadomość e-mail na kolejce
 *
 * @ORM\Entity
 * @ORM\Table(schema="email", name="queue")
 * @ORM\HasLifecycleCallbacks()
 */
class Email implements EmailInterface
{
    use Common;

    const STATUS_SUSPEND = 4;

    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="message", type="text", nullable=false)
     */
    private $message;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="status", type="string", nullable=false)
     */
    private $status;
    
    /**
     * @var string
     * 
     * @ORM\Column(name="environment", type="string", nullable=false)
     */
    private $environment;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getEnvironment(): string 
    {
        return $this->environment;
    }

    public function getMessage(): string 
    {
        return json_decode($this->message);   
    }

    public function getMessageObject()
    {
        return unserialize($this->getMessage());
    }

    public function getStatus(): string 
    {
        return $this->status;
    }

    public function setEnvironment($environment) 
    {
        $this->environment = $environment;
    }

    public function setMessage($message) 
    {
        $this->message = json_encode($message);
    }

    public function setStatus($status) 
    {
        $this->status = $status;
    }
}
