<?php

namespace LaravelAdminPackage\Html;

use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Route;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class Show
{
    private $model;
    private $form;
    private $html;
    private $gate;

    /**
     * Construct the class.
     *
     * @param  \Collective\Html\HtmlBuilder $html
     * @param  \Collective\Html\FormBuilder $form
     * @param \Illuminate\Auth\Access\Gate  $gate
     */
    public function __construct(HtmlBuilder $html, FormBuilder $form, Gate $gate)
    {
        $this->html = $html;
        $this->form = $form;
        $this->gate = $gate;
    }

    public function open($model)
    {
        return $this->reset()->setModel($model);
    }

    public function setModel($model)
    {
        $this->model = $this->findModel($model);

        return $this;
    }

    private function findModel($model)
    {
        if (is_array($model)) {
            list($model, $id) = $model;
        }

        if (is_string($model)) {
            $model = new $model;
        }

        if (!($model instanceof Model)) {
            throw new \InvalidArgumentException('Le model doit étendre Eloquent\Model');
        }

        if (isset($id)) {
            $model = $model->find(1);
        }

        return $model;
    }

    public function reset()
    {
        $clean = new self($this->html, $this->form, $this->gate);
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

    public function relationAttribute($relation, $relation_title_attribute, $default = null, $actionOrRoute = null)
    {
        if (!($relation = $this->model->$relation)) {
            return $default;
        }

        $url = $this->makeUrl([$actionOrRoute, $relation->id], $relation);

        return link_to($url, $relation->$relation_title_attribute);
    }

    private function makeUrl($hrefWithParameters = null, $model = null)
    {
        if ($model) {
            $model = $this->findModel($model);
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
            if (starts_with($href, '@')) {
                $href = 'Admin\\' . Str::studly(class_basename($model)) . 'Controller' . $href;

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

        return action('Admin\\' . Str::studly(class_basename($model)) . 'Controller@show', $parameters);
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

    public function emailAttribute($attribute = 'email')
    {
        return link_to('mailto:' . $this->model->$attribute, $this->model->$attribute);
    }

    public function createButton(array $options = [], $type = 'link', $title = 'Ajouter')
    {
        if ($this->gate->allows('create', [$this->model])) {
            return $this->button(['@create', null], $title, $options, $type);
        }
    }

    private function button($hrefWithParameters, $title, $options, $type)
    {
        $method = $type . 'Button';

        return $this->$method($hrefWithParameters, $title, $options);
    }

    public function indexButton(array $options = [], $type = 'link', $title = 'Retour à la liste')
    {
        if ($this->gate->allows('list', [$this->model])) {
            return $this->button(['@index', null], $title, $options, $type);
        }
    }

    public function linkButton($hrefWithParameters, $title, array $options = [])
    {
        $href = $this->makeUrl($hrefWithParameters);
        $options = array_merge(['class' => 'btn'], $options);

        return link_to($href, $title, $options, null, false);
    }

    public function modalButton($hrefWithParameters, $title, array $options = [])
    {
        $href = $this->makeUrl($hrefWithParameters);
        $options = array_merge(['data-toggle' => 'modal', 'data-target' => '#modal', 'href' => $href], $options);
        $options = array_merge(['class' => 'btn'], $options);

        return $this->form->button($title, $options);
    }

    public function indexActions($nameAttribute = null)
    {
        $output = $this->showButton(['class' => 'btn btn-info btn-xs', 'style' => 'margin: 0 2px'], 'link', '<i class="fa fa-eye"></i>');
        $output .= $this->editButton(['class' => 'btn btn-warning btn-xs', 'style' => 'margin: 0 2px'], 'link', '<i class="fa fa-edit"></i>');
        $output .= $this->deleteButton(['class' => 'btn btn-danger btn-xs', 'style' => 'margin: 0 2px'], '<i class="fa fa-times"></i>', $nameAttribute);

        return $output;
    }

    public function showButton(array $options = [], $type = 'link', $title = 'Voir')
    {
        if ($this->gate->allows('view', [$this->model])) {
            return $this->button('@show', $title, $options, $type);
        }
    }

    public function editButton(array $options = [], $type = 'link', $title = 'Editer')
    {
        if ($this->gate->allows('update', [$this->model])) {
            return $this->button('@edit', $title, $options, $type);
        }
    }

    public function deleteButton(array $options = [], $title = 'Supprimer', $nameAttribute = null, $redirect = null)
    {
        if ($this->gate->allows('delete', [$this->model])) {
            $output = $this->form->open(['method' => 'delete', 'url' => $this->makeUrl('@destroy'), 'rel' => 'delete-button', 'style' => 'display:inline']);
            if ($nameAttribute) {
                $output .= $this->form->hidden('name', $this->model->$nameAttribute);
            }
            if ($redirect) {
                $output .= $this->form->hidden('redirect', $this->makeUrl($redirect));
            }

            $output .= $this->form->button($title, array_merge(['class' => 'btn', 'type' => 'submit'], $options));
            $output .= $this->form->close();

            return $output;
        }
    }

    public function menu(string $name, $header = null, string $class = '')
    {
        $contents = collect(config('menus.' . $name))
            ->filter(function (array $item) {
                return !isset($item[2]) || $this->gate->allows($item[2]);
            })
            ->map(function (array $item): Link {
                list($route, $label) = $item;

                if (is_array($label)) {
                    list($label, $fontAwesomeClass) = $label;
                    $label = '<i class="fa fa-' . $fontAwesomeClass . '"></i> <span>' . $label . '</span>';
                }

                if (is_array($route)) {
                    list($route, $parameters) = $route;
                    $parameters = is_callable($parameters) ? $parameters() : $parameters;
                }

                return Link::toRoute($route, $label, $parameters ?? null);
            });

        if ($contents->isEmpty()) {
            return null;
        }

        if ($header) {
            $contents->prepend(Html::raw($header)->addParentClass('header'));
        }

        return Menu::new($contents->toArray())
            ->addClass($class)
            ->setActiveFromRequest('admin/');
    }
}
