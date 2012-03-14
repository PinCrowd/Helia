<?php

class Zircote_Rest_Composite
{
    public $_components = array();
    public function addComponent($component)
    {
        $component->setComposite($this);
        $this->_components[spl_object_hash($component)] = $component;
    }

}