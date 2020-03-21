<?php

namespace PerfectOblivion\ActionServiceResponder\Payload;

use ArrayAccess;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use PerfectOblivion\ActionServiceResponder\Payload\Contracts\PayloadContract;
use Traversable;

class Payload implements PayloadContract, ArrayAccess, JsonSerializable, Jsonable, Arrayable
{
    /** @var int */
    private $status;

    /** @var mixed */
    private $output;

    /** @var array */
    private $messages = [];

    /** @var string|null */
    private $outputWrapper = null;

    /** @var string */
    private $messagesWrapper = 'messages';

    /**
     * Initialize a Payload object.
     */
    public static function instance(): PayloadContract
    {
        return new static;
    }

    /**
     * Set the Payload status.
     *
     * @param  int  $status
     */
    public function setStatus(int $status): PayloadContract
    {
        $instance = clone $this;
        $instance->status = $status;

        return $instance;
    }

    /**
     * Get the status of the payload.
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set the Payload messages.
     *
     * @param  array  $output
     */
    public function setMessages(array $messages): PayloadContract
    {
        $instance = clone $this;
        $instance->messages = $messages;

        return $instance;
    }

    /**
     * Get messages array from the payload.
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Set the Payload output.
     *
     * @param  mixed  $output
     * @param  string|null  $wrapper
     */
    public function setOutput($output, ? string $wrapper = null): PayloadContract
    {
        if ($wrapper) {
            $this->outputWrapper = $wrapper;
        }

        $instance = clone $this;
        $instance->output = $output;

        return $instance;
    }

    /**
     * Get the Payload output.
     */
    public function getOutput(): array
    {
        return $this->getArrayableItems($this->output);
    }

    /**
     * Get the raw Payload output.
     *
     * @return mixed
     */
    public function getRawOutput()
    {
        return $this->output;
    }

    /**
     * Retrieve the Payload output and wrap it.
     * Use the outputWrapper if it is set, otherwise use 'data'.
     */
    public function getwrappedOutput(): array
    {
        return $this->outputWrapper ? [$this->outputWrapper => $this->output] : ['data' => $this->output];
    }

    /**
     * Get the wrapper for the output.
     */
    public function getOutputWrapper(): ? string
    {
        return $this->outputWrapper;
    }

    /**
     * Get the wrapper for the messages.
     */
    public function getMessagesWrapper(): string
    {
        return $this->messagesWrapper;
    }

    /**
     * Return all of the components of the payload in array format.
     */
    public function all(): array
    {
        $all = ['output' => $this->getOutput()];
        if ($this->messages) {
            $all = array_merge($all, ['messages' => $this->getMessages()]);
        }
        if ($this->status) {
            $all = array_merge($all, ['status' => $this->getStatus()]);
        }

        return $all;
    }

    /**
     * Convert the Payload output to an array.
     */
    public function getArrayableItems(): array
    {
        if (is_array($this->output)) {
            return $this->output;
        } elseif ($this->output instanceof Arrayable) {
            return $this->output->toArray();
        } elseif ($this->output instanceof Jsonable) {
            return json_decode($this->output->toJson(), true);
        } elseif ($this->output instanceof JsonSerializable) {
            return $this->output->jsonSerialize();
        } elseif ($this->output instanceof Traversable) {
            return iterator_to_array($this->output);
        }

        return (array) $this->output;
    }

    /**
     * Dynamically retrieve attributes on the OutputItem.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->output[$key];
    }

    /**
     * Convert the Payload instance to JSON.
     *
     * @param  int  $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the Payload into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the Payload instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        $output = $this->outputWrapper || $this->messages ? $this->getWrappedOutput() : $this->getOutput();
        $messages = $this->messages ? [$this->messagesWrapper => $this->messages] : $this->messages;

        return $this->messages ? array_merge($output, $messages) : $output;
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }

    /**
     * Determine if an attribute exists on the Payload.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        if (! $this->output) {
            return false;
        }

        return isset($this->output[$key]);
    }

    /**
     * Unset an attribute on the Payload.
     *
     * @param  string  $key
     */
    public function __unset($key)
    {
        if (! $this->output) {
            return;
        }

        unset($this->output[$key]);
    }

    /**
     * Convert the Payload to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
