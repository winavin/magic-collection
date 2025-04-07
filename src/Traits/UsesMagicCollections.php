<?php
  
namespace Winavin\MagicCollection\Traits;

use Winavin\MagicCollection\Collections\BaseCollection;

trait UsesMagicCollections
{
     /**
     * Override Laravel's default collection instantiation.
     */
    public function newCollection(array $models = [])
    {
        return new ($this->useCollection())($models);
    }

    /**
     * Allows the model to specify a custom collection class.
     * Defaults to BaseCollection if not overridden.
     */
    protected function useCollection(): string
    {
        // If model overrides this method, it will be used instead
        if (method_exists(get_parent_class($this), 'useCollection')) {
            return parent::useCollection();
        }

        $guessedClass = str_replace("App\\Models","App\\Collections",get_class($this)) . "Collection";

        return class_exists($guessedClass)
            ? $guessedClass
            : BaseCollection::class;
    }
}