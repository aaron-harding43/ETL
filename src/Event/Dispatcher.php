<?php

namespace ETL\Event;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use SplPriorityQueue;

class Dispatcher implements EventDispatcherInterface, ListenerProviderInterface
{
    /**
     * @var array Listeners
     */
    protected $listeners = [];

    /**
     * Dispatches an event across the listeners
     *
     * @param object $event The event to fire
     * @return object|void
     */
    public function dispatch(object $event)
    {
        $listeners = $this->getListenersForEvent($event);

        foreach ($listeners as $listener) {

            // If the event is stoppable and has been stopped, stop the listeners
            if (($event instanceof StoppableEventInterface) && $event->isPropagationStopped()) {
                return;
            }

            // Fire the listener
            $listener($event);
        }
    }

    /**
     * Retrieves listeners registered to the triggered event
     *
     * @param object $event
     * @return iterable Retrieves listeners for an event
     */
    public function getListenersForEvent(object $event): iterable
    {
        $eventName = get_class($event);

        if (isset($this->listeners[$eventName])) {
            return $this->listeners[$eventName];
        }

        // Return empty array
        return [];
    }

    /**
     * Registers a callable function for when the event is triggered
     *
     * @param string $event The event to listen for
     * @param callable $listener The function to fire when the event is triggered
     * @param int $priority The order to fire the listener
     */
    public function register(string $event, callable $listener, int $priority = 0)
    {
        if (!isset($this->listeners[$event])) {
            $this->listeners[$event] = new SplPriorityQueue();
        }

        // Add the listener to the stack
        $this->listeners[$event]->insert($listener, $priority);
    }
}
