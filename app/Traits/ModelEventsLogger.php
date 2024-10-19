<?php

namespace App\Traits;

use App\Models\ModelEvent;

/**
 * Class ModelEventsLogger
 */
trait ModelEventsLogger
{
    /**
     * Register Events handler.
     */
    public static function bootModelEventsLogger()
    {
        foreach (static::getModelEvents() as $event => $handler) {
            static::$event(function ($model) use ($handler) {
                $model->{$handler}($model);
            });
        }
    }

    protected static function getModelEvents()
    {
        return [
            'creating' => 'onCreating',
            'created' => 'onCreated',
            'updating' => 'onUpdating',
            'updated' => 'onUpdated',
            'deleting' => 'onDeleting',
            'deleted' => 'onDeleted',
            // Add other events and corresponding methods as needed
        ];
    }

    protected function getUserId()
    {
        // Get the authenticated user or null if not authenticated
        $user = request()->user();

        return $user ? $user->id : null;
    }

    protected function getIpAddress()
    {
        // Get the IP address from the request
        return request()->ip();
    }

    protected function logModelEvent($model, $action, $originalAttributes = [], $changedAttributes = [])
    {
        $reflect = new \ReflectionClass($model);

        $dataToStore = [
            'user_id' => $this->getUserId(),
            'content_id' => $model->id,
            'content_type' => $reflect->getShortName(),
            'action' => $action,
            'ip_address' => $this->getIpAddress(),
        ];

        if (! empty($originalAttributes)) {
            $dataToStore['original_attributes'] = json_encode($originalAttributes);
        }

        if (! empty($changedAttributes)) {
            $dataToStore['changed_attributes'] = json_encode($changedAttributes);
        }

        ModelEvent::create($dataToStore);
    }

    protected function onCreating($model)
    {
        // Logic for handling the "creating" event
    }

    protected function onCreated($model)
    {
        $finalAttributes = $model->getAttributes();

        // Log the event, indicating that the model has been created
        $this->logModelEvent($model, 'Created', $finalAttributes);
    }

    protected function onUpdating($model)
    {
        // Logic for handling the "updating" event
    }

    protected function onUpdated($model)
    {
        $originalAttributes = [];
        $changedAttributes = $model->getDirty();
        foreach ($changedAttributes as $name => $value) {
            $originalAttributes[$name] = $model->getOriginal($name);
        }

        $this->logModelEvent($model, 'Updated', $originalAttributes, $changedAttributes);
    }

    protected function onDeleting($model)
    {
        // Logic for handling the "deleting" event
    }

    protected function onDeleted($model)
    {
        $originalAttributes = $model->getAttributes();

        $this->logModelEvent($model, 'Deleted', $originalAttributes);
    }

    // Add other event handler methods as needed
}
