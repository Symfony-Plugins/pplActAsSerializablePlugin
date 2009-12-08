<?php

/**
 * Serializable
 *
 */
class Doctrine_pplSerializable extends Doctrine_Record_Generator
{
  protected $_options = array(
      'className'      => 'pplSerial',
      'tableName'      => false,
      'generateFiles'  => false,
      'table'          => false,
      'pluginTable'    => false,
      'children'       => array(),
      'options'        => array(),
      'format'         => '0000',
  );


  /**
   * __construct
   *
   * @param string $options
   * @return void
   */
  public function __construct($options)
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }

  public function buildRelation()
  {
    $this->buildForeignRelation('pplSerial');
    //$this->buildLocalRelation();
  }

  /**
   * buildDefinition
   *
   * @param object $Doctrine_Table
   * @return void
   */
  public function setTableDefinition()
  {
    $this->hasColumn('id', 'integer', 4, array(
        'unsigned' => true,
        'primary' => true,
        'autoincrement' => true,
    ));

    $this->hasColumn('model_class', 'string', 100);
    $this->hasColumn('ppl_year', 'string', 2);
    $this->hasColumn('serial', 'integer', 4, array('unsigned' => true));

    $this->index('model_class_parameter', array(
        'fields' => array('model_class', 'ppl_year'),
        'type' => 'unique',
    ));
  }

}