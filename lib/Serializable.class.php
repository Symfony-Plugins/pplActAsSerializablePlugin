<?php

/**
 * Serializable
 *
 */
class Doctrine_Serializable extends Doctrine_Record_Generator
{
  protected $_options = array(
      'className'     => 'Serial',
      'tableName'     => false,
      'generateFiles' => false,
      'table'         => false,
      'pluginTable'   => false,
      'children'      => array(),
      'options'       => array(),
      'parameter'     => 'year',
      'format'        => '0000',
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
    $this->buildForeignRelation('Serial');
    $this->buildLocalRelation();
  }

  /**
   * buildDefinition
   *
   * @param object $Doctrine_Table
   * @return void
   */
  public function setTableDefinition()
  {
    $this->_options['parameter'] = ($this->_options['parameter'] != 'year') ? 'custom' :  $this->_options['parameter'];

    if($this->_options['format'])
    {

    }

    $this->hasColumn('id', 'integer', 4, array(
        'unsigned' => true,
        'primary' => true,
        'autoincrement' => true,
    ));

    $this->hasColumn('related_model', 'string(100)');
    $this->hasColumn('parameter', 'string(100)');

    $this->hasColumn('serial', 'integer', 4, array('unsigned' => true));
  }

  public function buildLocalRelation()
  {
    // relation to the main object
    $options['foreign'] = $this->_options['table']->getIdentifier();
    $options['local'] = $this->getSerialObjectFk();
    $options['type'] = Doctrine_Relation::ONE;
    $options['onDelete'] = 'CASCADE';
    $options['onUpdate'] = 'CASCADE';
    $this->_table->getRelationParser()->bind($this->_options['table']->getComponentName(), $options);
  }

  public function getSerialObjectFk()
  {
    return Doctrine_Inflector::tableize($this->_options['table']->getComponentName()) . '_id';
  }
}