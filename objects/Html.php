<?php

class Html
{
    protected $mode = 'html';

    //TODO: add htmlspecialchars where applicable
    public function getTag($tag, $value = false, $attributes = array())
    {
        $methodName = 'getTag' . ucfirst($tag);

        if (is_callable(array($this, $methodName)))
        {
            return call_user_func_array(array($this, $methodName),
                                 array($value, $attributes));
        }

        $noValue = ($value === false);
        $xhtml = ($this->mode == 'xhtml');

        $attributesStr = $attributes ? $this->getAttributes($attributes) : '';

        return
            '<'.$tag.
            $attributesStr.
            (($noValue && $xhtml) ? '/' : '').
            '>'.
            $value.
            ((!$noValue || !$xhtml) ? '</'.$tag.'>' : '' );
            ;
    }

    public function getTagMeta($value, $attributes)
    {
        return
            '<meta'.
            ($attributes ? $this->getAttributes($attributes) : '').
            ($this->mode == 'xhtml' ? '/' : '').
            '>'
            ;
    }

    public function getTagInput($value, $attributes)
    {
        return
            '<input'
            .($attributes ? $this->getAttributes($attributes) : '')
            .'value="'.$value.'"'
            .($this->mode == 'xhtml' ? '/' : '')
            .'>'
            ;
        
    }

    //TODO: add htmlspecialchars where applicable
    protected function getAttributes($attributes = array())
    {
        $attributesStr = '';

        foreach ($attributes as $attrName => $attrValue)
        {
            $attributesStr .= ' '.$attrName.'="'.$attrValue.'"';
        }

        return $attributesStr;
    }

}