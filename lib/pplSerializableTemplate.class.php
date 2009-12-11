<?php

class pplSerializable extends Doctrine_Template
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
        $this->_plugin = new Doctrine_pplSerializable($this->_options);
    }

    public function initOptions()
    {
        $this->setOption('model_class', get_class($this->getInvoker()));
    }

    /**
     * Initialize the Rattable plugin for the template
     *
     * @return void
     */
    public function setUp()
    {
        $this->_plugin->initialize($this->_table);
        $this->addListener(new pplSerializableListener());
    }

    /**
     * Get the plugin instance for the Rattable template
     *
     * @return Doctrine_Serializable
     */
    public function getSerializable()
    {
        return $this->_plugin;
    }

    /**
     *
     * @return string formated serial
     */
    public function getFormatedSerial()
    {
        $nb = new sfNumberFormat();
        return $nb->format($this->getNext(), $this->getFormat());
    }

    /**
     * @return int next serial
     */
    public function getNext()
    {
        if($this->getInvoker()->exists())
        {
            throw new Exception('You can only get Serial on new objects');
        }

        return $this->getSerial()+1;
    }

    public function getSerial()
    {
        return $this->getSerialQuery()->limit(1)->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
    }

    public function getCurrentYear()
    {
        return date('y', time());
    }

    public function getYear()
    {
        $model_class = get_class($this->getInvoker());

        return Doctrine_Query::create()
                ->select('MAX(ppl_year)')
                ->from('pplSerial ps')
                ->where('ps.model_class = ?', array($model_class))
                ->limit(1)
                ->execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * @return boolean
     */
    public function resetNeeded()
    {
        return $this->getYear() < $this->getCurrentYear();
    }

    /**
     *
     * @return Doctrine_Query
     */
    public function getSerialQuery()
    {
        $model_class = get_class($this->getInvoker());
        $year = $this->getCurrentYear();

        return Doctrine_Query::create()
                ->select('ps.serial')
                ->from($this->getSerializable()->getOption('className') . ' ps')
                ->where('ps.model_class = ? AND ps.ppl_year = ?', array($model_class, $year));
    }

    protected function getFormat()
    {
        return $this->getSerializable()->getOption('format');
    }

}