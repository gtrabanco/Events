<?php

/**
 * @file
 * A PHP class to administrate events and fire it.
 */

/**
 * 
 */
class Event
{
    static $event_callbacks;

    /**
     * Constructor.
     * 
     * @param string $event
     *   Name of the event (optional).
     */
    function __construct($event = NULL)
    {
        // Register the event if any.
        if (!empty($event)) {
            $this->register($event);
        }
    }
  
    /**
     * Registers an event.
     * 
     * @param string $event
     *   Name of the event.
     */
    protected function register($event)
    {
        if (empty($this->event_callbacks[$event])) {
            $this->event_callbacks[$event] = array();
        }
    }

    /**
     * Binds a callback to a event.
     * 
     * @param string $event
     *   Name of the event.
     * @param string $callback
     *   The method or function to call.
     */
    public function bind($event, $callback)
    {
        $this->event_callbacks[$event][] = $callback;
    }

    /**
     * Unbinds a callback to a event.
     * 
     * @param string $event
     *   Name of the event.
     * @param string $callback
     *   The method or function to call.
     */
    public function unbind($event, $callback)
    {
        foreach ($this->event_callbacks[$event] as $key => $event_callback) {
            if ($event_callback == $callback) {
                unset($this->event_callbacks[$event][$key]);
            }
        }
    }

    /**
     * Executes all the binded callbacks when the event is fired.
     * 
     * @param string $event
     *   Name of the event.
     * @param array $arguments
     *   The arguments to pass to each callback.
     */
    public function fire($event, $arguments = array())
    {
        if (!empty($this->event_callbacks[$event])) {
            foreach ($this->event_callbacks[$event] as $callback) {
                call_user_func_array($callback, $arguments);
            }
        }
    }
}
