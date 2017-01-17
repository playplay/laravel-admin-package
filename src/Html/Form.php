<?php

namespace LaravelAdminPackage\Html;

use Watson\BootstrapForm\BootstrapForm;

class Form extends BootstrapForm
{
    public function select($name, $label = null, $list = [], $selected = null, array $options = [])
    {
        $options = array_merge(['rel' => 'select2'], $options);

        return parent::select($name, $label, $list, $selected, $options);
    }

    public function checkbox($name, $label = null, $value = 1, $checked = null, array $options = [])
    {
        $options = array_merge(['rel' => 'switch'], $options);
        return parent::checkbox($name, $label, $value, $checked, $options);
    }

    public function tags($name, $label = null, $list = [], $selected = null, array $options = [])
    {
        $options = array_merge(['rel' => 'taginput', 'multiple'], $options);

        return parent::select($name, $label, $list, $selected, $options);
    }

    public function colorPicker($name, $label = null, $value = null, array $options = [])
    {
        $options = array_merge(['rel' => 'colorpicker'], $options);

        return parent::text($name, $label, $value, $options);
    }

    /* TODO Image field with image preview :
     *  public function image($name, $label = null, $src = null, array $options = [])
     {
         $label = $this->getLabelTitle($label, $name);

         $options = array_merge(['class' => 'filestyle', 'data-buttonBefore' => 'true'], $options);

         $options = $this->getFieldOptions($options, $name);
         $inputElement = $this->form->input('file', $name, null, $options);

         $wrapperOptions = $this->isHorizontal() ? ['class' => $this->getRightColumnClass()] : [];
         $wrapperElement = '<div' . $this->html->attributes($wrapperOptions) . '>' . $inputElement . $this->getFieldError($name) . $this->getHelpText($name, $options) . '</div>';

         return $this->getFormGroup($name, $label, $wrapperElement);
     }*/
}
