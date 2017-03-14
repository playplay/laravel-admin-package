<?php

namespace LaravelAdminPackage\App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    public function owns(BaseModel $related)
    {
        return $this->{$this->getKeyName()} === $related->{$this->getForeignKey()};
    }

    public function isOwnedBy(BaseModel $related)
    {
        return $related->{$related->getKeyName()} === $this->{$related->getForeignKey()};
    }

    public function getTitle() {
        if (($value = $this->title) || ($value = $this->name)) {
            return $value;
        }

        throw new \BadMethodCallException('No "getTitle()", "title" or "name" provided for ' . static::class . '!');
    }

}
