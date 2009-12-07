<?php

class Serializable extends Doctrine_Template
{
    /**
     * __construct
     *
     * @param string $array
     * @return void
     */
  public function __construct(array $options = array())
  {
    parent::__construct($options);
    $this->_plugin = new Doctrine_Serializable($this->_options);
  }

  /**
   * Initialize the Rattable plugin for the template
   *
   * @return void
   */
  public function setUp()
  {
    $this->_plugin->initialize($this->_table);
    $this->addListener(new sfDoctrineRecordListener());
  }

  /**
   * Get the plugin instance for the Rattable template
   *
   * @return void
   */
  public function getSerializable()
  {
    return $this->_plugin;
  }

  /**
   *
   * @return int formated serial
   */
  public function getNext()
  {
    
  }


  public function resetNeeded()
  {
    
  }

}