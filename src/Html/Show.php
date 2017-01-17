<?php

namespace LaravelAdminPackage\Html;

use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use Illuminate\Support\Str;
use Route;

class Show
{
    private $model;
    private $form;
    private $html;

    /**
     * Construct the class.
     *
     * @param  \Collective\Html\HtmlBuilder $html
     * @param  \Collective\Html\FormBuilder $form
     */
    public function __construct(HtmlBuilder $html, FormBuilder $form)
    {
        $this->html = $html;
        $this->form = $form;
    }

    public function open($model)
    {
        $this->reset()->setModel($model);
    }

    public function setModel(\Eloquent $model)
    {
        $this->model = $model;

        return $this;
    }

    public function reset()
    {
        $clean = new self($this->html, $this->form);
        foreach ($this as $key => $val) {
            if (property_exists($clean, $key)) {
                $this->$key = $clean->$key;
            } else {
                unset($this->$key);
            }
        }

        return $this;
    }

    public function close()
    {
        $this->reset();
    }

    public function relationAttribute($relation, $relation_title_attribute, $actionOrRoute = null)
    {
        $url = $this->makeUrl([$actionOrRoute, $this->model->$relation->id], $relation);

        return link_to($url, $this->model->$relation->$relation_title_attribute);
    }

    private function makeUrl($hrefWithParameters = null, $model = null)
    {
        if ($model) {
            $model = is_string($model) ? $model : get_class($model);
        } else {
            $model = $this->model;
        }

        if (is_array($hrefWithParameters)) {
            list($href, $parameters) = $hrefWithParameters;
        } else {
            $href = $hrefWithParameters;
            $parameters = $model->id;
        }

        if ($href) {
            if (in_array(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'], $href)) {
                $href = 'Admin\\' . Str::studly($model) . 'Controller@' . $href;

                return action($href, $parameters);
            }

            if (Str::contains($href, '@')) {
                return action($href, $parameters);
            }

            if (Route::has($href)) {
                return route($href, $parameters);
            }

            return url($href);
        }

        return action('Admin\\' . Str::studly($model) . 'Controller@show', $parameters);
    }

    public function dateAttribute($attribute)
    {
        return $this->model->$attribute->toFormattedDateString();
    }

    public function textAttribute($attribute)
    {
        return $this->model->$attribute;
    }

    public function imageAttribute($attribute)
    {
        return link_to(
            $this->model->$attribute,
            $this->html->image($this->model->$attribute, $attribute),
            ['target' => '_blank']
        );
    }

    public function colorAttribute($attribute)
    {
        return '<div style="background-color: ' . $attribute . '; width: 20px; height:20px"></div>';
    }

    public function booleanAttribute($attribute, $true = null, $false = null)
    {
        return $this->badge($this->model->$attribute, $true ?: 'Oui', $false ?: 'Non');
    }

    public function badge($boolean, $true, $false)
    {
        if ($boolean) {
            $class = 'success';
            $value = $true;
        } else {
            $class = 'danger';
            $value = $false;
        }

        return "<div class=\"label label-$class\">$value</div>";
    }

    public function urlAttribute($attribute)
    {
        return link_to($this->model->$attribute);
    }

    public function emailAttribute($attribute)
    {
        return link_to('mailto:' . $this->model->$attribute, $this->model->$attribute);
    }

    public function showButton($title = 'Voir', $options = [], $type = 'link')
    {
        return $this->button('show', $title, $options, $type);
    }

    private function button($hrefWithParameters, $title, $options, $type)
    {
        $method = $type . 'Button';

        return $this->$method($hrefWithParameters, $title, $options);
    }

    public function createButton($title = 'Ajouter', $options = [], $type = 'link')
    {
        return $this->button(['create', null], $title, $options, $type);
    }

    public function editButton($title = 'Editer', $options = [], $type = 'link')
    {
        return $this->button('edit', $title, $options, $type);
    }

    public function indexButton($title = 'Retour à la liste', $options = [], $type = 'link')
    {
        return $this->button('index', $title, $options, $type);
    }

    public function linkButton($hrefWithParameters, $title, $options = [])
    {
        $href = $this->makeUrl($hrefWithParameters);
        $options = array_merge(['class' => 'btn'], $options);

        return link_to($href, $title, $options);
    }

    public function modalButton($hrefWithParameters, $title, $options = [])
    {
        $href = $this->makeUrl($hrefWithParameters);
        $options = array_merge(['data-toggle' => 'modal', 'data-target' => '#modal', 'data-href' => $href], $options);
        $options = array_merge(['class' => 'btn'], $options);

        return $this->form->button($title, $options);
    }

    public function deleteButton($title, $attribute = null, $options = [], $redirect = null)
    {
        $this->form->open(['method' => 'delete', 'url' => $this->makeUrl('destroy'), 'rel' => 'delete-button']);
        if ($attribute) {
            $this->form->hidden('name', $this->model->$attribute);
        }
        if ($redirect) {
            $this->form->hidden('redirect', $this->makeUrl($redirect));
        }

        $this->form->submit($title, array_merge(['class' => 'btn'], $options));
        $this->form->close();
    }

}
