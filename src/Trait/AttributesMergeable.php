<?php

namespace Cosnavel\LaravelQueryLocalization\Trait;

trait AttributesMergeable
{
    public $class;

    public function mountAttributesMergeable($class = null)
    {
        $this->class = $class;
    }

    public function merge($defaultValues = '', $mergeables = '')
    {
        $defaultValues = explode(' ', $defaultValues);
        $mergeables = explode(' ', $mergeables);

        return implode(' ', array_unique(array_merge($defaultValues, $mergeables)));
    }
}
