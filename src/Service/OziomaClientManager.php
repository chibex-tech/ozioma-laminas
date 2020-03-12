<?php
namespace Chibex\Ozioma\Service;

use Chibex\Ozioma;


/**
 * This service is the implementation of Ozioma Messaging and Communications Platform's API.
 */
class OziomaClientManager
{    
    private $ozioma = null;
    
    public function __construct(Ozioma $ozioma)
    {
        $this->ozioma = $ozioma;
    }

    // this returns your SMS unit balance for this your project
    public function getBalance()
    {
        return $this->ozioma->balance->check();
    }
    
    // method for sending message
    public function send(array $data)
    {
        return $this->ozioma->message->send($data);
    }

    // method for scheduling message
    public function schedule(array $data) 
    {
        return $this->ozioma->message->schedule($data);
    }

    // method for listing your SMS Newsletter lists assigned to this your project from your Ozioma dashboard
    public function newsletterList()
    {
        return $this->ozioma->newsletter->list();
    }

    // method for adding subscriber to your SMS Newsletter list
    public function addSubscriber(array $data)
    {
        return $this->ozioma->newsletter->addSubscriber($data);
    }

    // methode for adding bulk subscribers to your SMS Newsletter list
    public function addBulkSubscribers(array $data)
    {
        return $this->ozioma->newsletter->addBulkSubscribers($data);
    }

    // method for list birthday groups assigned to this your project from your Ozioma dashboard
    public function birthdayGroupList()
    {
        return $this->ozioma->birthday->getGroupList();
    }

    // method for adding birthday contact to your birthday group
    public function addBirthdayContactToGroup(array $data)
    {
        return $this->ozioma->birthday->addContactToGroup($data);
    }

    // method for addming bulk birthday contacts to your birthday group
    public function addBulkBirthdayContactsToGroup(array $data)
    {
        return $this->ozioma->birthday->addBulkContactsToGroup($data);
    }

    // lists time zones which is required for schedule method
    public function listTimeZones()
    {
        return $this->ozioma->timezones->list();
    }

    // lists months which is required for addBirthdayContactToGroup and addBulkBirthdayContactsToGroup methods
    public function listMonths()
    {
        return $this->ozioma->month->list();
    }    

    // fetches a sent message by id recorded at Ozioma server
    public function fetchSentMessage($id)
    {
        return $this->ozioma->message->fetch($id);
    }

    // fetch sent message delivery report
    public function fetchSentMessageExtras($sentMessageId)
    {
        return $this->ozioma->message->getExtras($sentMessageId);
    }
}
