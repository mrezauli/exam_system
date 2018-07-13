<?php 

namespace Modules\Exam\Helpers;


class CustomCollection extends \Illuminate\Database\Eloquent\Collection {
    // define custom methods here, for example
    public function foo()
    {
        // ...
    }
}


class StdClass
{
    public function __get($name)
    {
        if (!isset($this->$name)) {
            return null;
        }

        return $this->$name;
    }

    public static function fromArray($attributes =[])
    {
        $object = new self();

        foreach ($attributes as $name => $value) {
            $object->$name = $value;
        }

        return $object;
    }
}