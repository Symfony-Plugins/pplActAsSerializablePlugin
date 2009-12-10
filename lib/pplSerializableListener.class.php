<?php

class pplSerializableListener extends Doctrine_Record_Listener
{
    public function preInsert(Doctrine_Event $event)
    {
        $invoker = $event->getInvoker();
        $class_name = $invoker->getSerializable()->getOption('className');

        $serial = $invoker->getSerialQuery()->fetchOne();

        if($serial)
        {
            $serial->serial += $serial->serial;
            $serial->save();
        }
        else
        {
            $c = new $class_name;
            $c->merge(array(
                    'model_class' => get_class($invoker),
                    'ppl_year'    => $invoker->getCurrentYear(),
                    'serial'      => $invoker->getNext(),
            ));

            $c->save();
        }
    }
}