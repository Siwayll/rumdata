<?php

namespace Siwayll\RumData;

class RumData implements \ArrayAccess
{
    public function isAList(...$names)
    {
        $value = $this->get(...$names);
        if ($value === null) {
            return true;
        }
        foreach ($value as $key => $value) {
            if (!is_numeric($key)) {
                return false;
            }
        }

        return true;
    }

    public function append($value, ...$names): self
    {
        if ($this->isAList(...$names) === false) {
            return $this;
        }

        $id = count((array) $this->get(...$names));
        $names[] = $id;
        return $this->set($value, ...$names);
    }

    public function get(...$names)
    {
        $data = $this;
        foreach ($names as $name) {
            if (!isset($data->{$name})) {
                return null;
            }
            $data = $data->{$name};
        }
        return $data;
    }

    public function set($value, ...$names): self
    {
        $data = $this;
        foreach ($names as $count => $name) {
            if ($count == count($names) - 1) {
                $data->{$name} = $value;
                break;
            }

            if (!isset($data->{$name})) {
                $data->{$name} = new self();
            }
            $data = $data->{$name};
        }

        return $this;
    }

    public function kill(...$names)
    {
        $data = $this;
        foreach ($names as $count => $name) {
            if (!isset($data->{$name})) {
                return $this;
            }

            if ($count == count($names) - 1) {
                unset($data->{$name});
                break;
            }

            $data = $data->{$name};
        }

        return $this;
    }

    public function has(...$names)
    {
        $data = $this;
        foreach ($names as $name) {
            if (!isset($data->{$name})) {
                return false;
            }

            $data = $data->{$name};
        }

        return true;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($value, $offset);
    }

    public function offsetUnset($offset)
    {
        return $this->kill($offset);
    }
}
