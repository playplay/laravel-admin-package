<?php

namespace LaravelAdminPackage\Html;

use Watson\BootstrapForm\BootstrapForm;

class Form extends BootstrapForm
{
    protected $feedbackIcon;

    public function select($name, $label = null, $list = [], $selected = null, array $options = [])
    {
        $options = array_merge(['rel' => 'select2'], $options);

        return parent::select($name, $label, $list, $selected, $options);
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

    /**
     * @param $feedbackClass
     *
     * @return \LaravelAdminPackage\Html\Form
     *
     */
    public function hasFeedback($feedbackIcon)
    {
        $this->feedbackIcon = $feedbackIcon;

        return $this;
    }

    /**
     * Create the input group for an element with the correct classes for errors.
     *
     * @param  string $type
     * @param  string $name
     * @param  string $label
     * @param  string $value
     * @param  array  $options
     *
     * @return string
     */
    public function input($type, $name, $label = null, $value = null, array $options = [])
    {
        $label = $this->getLabelTitle($label, $name);
        $options = $this->getFieldOptions($options, $name);
        $inputElement = $type === 'password' ? $this->form->password($name, $options) : $this->form->{$type}($name, $value, $options);

        if ($this->feedbackIcon) {
            $spanOptions = [
                'class'       => 'form-control-feedback glyphicon glyphicon-' . $this->feedbackIcon,
                'aria-hidden' => 'true',
            ];
            $inputElement .= '<span' . $this->html->attributes($spanOptions) . '></span>';
        }

        $wrapperOptions = $this->isHorizontal() ? ['class' => $this->getRightColumnClass()] : [];
        $wrapperElement = '<div' . $this->html->attributes($wrapperOptions) . '>' . $inputElement . $this->getFieldError($name) . $this->getHelpText($name, $options) . '</div>';

        $formGroup =  $this->getFormGroup($name, $label, $wrapperElement);
        $this->resetField();

        return $formGroup;
    }

    /**
     * Merge the options provided for a form group with the default options
     * required for Bootstrap styling.
     *
     * @param  string $name
     * @param  array  $options
     *
     * @return array
     */
    protected function getFormGroupOptions($name = null, array $options = [])
    {
        $class = 'form-group';

        if ($name) {
            $class .= ' ' . $this->getFieldErrorClass($name);
        }

        if ($this->feedbackIcon) {
            $class .= ' has-feedback';
        }

        return array_merge(['class' => $class], $options);
    }

    private function resetField()
    {
        $this->feedbackIcon = null;
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
