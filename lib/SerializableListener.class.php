<?php

class SerializableListener extends Doctrine_Record_Listener
{
  /**
   * Instance of Doctrine_Auditlog
   *
   * @var Doctrine_AuditLog
   */
  protected $_serializable;


  public function __construct(Doctrine_Serializable $serializable)
  {
    $this->_serializable = $serializable;
  }

  public function preSave(Doctrine_Event $event)
  {

  }
}