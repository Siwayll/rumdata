<?php

namespace Siwayll\RumData;

class RumData implements \ArrayAccess
{
    public function get(string ...$names)
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

    public function set($value, string ...$names): self
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

    public function kill(string ...$names)
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

    public function has(string ...$names)
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

