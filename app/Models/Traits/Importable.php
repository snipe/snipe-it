<?php 
namespace App\Models\Traits;
trait Importable
{
   // This is a new trait mostly to register `importing` and `imported` events 
   // Add to the list of observable events on any publishable model
   public function initializeImportable()
    {
        $this->addObservableEvents([
            'importing',
            'imported',
        ]);
    }
 
    // Create a publish method that we'll use to transition the 
    // status of any publishable model, and fire off the before/after events
    public function import()
    {
        if (false === $this->fireModelEvent('importing')) {
            return false;
        }
        // $this->forceFill(['status' => 'publish'])->save();
        $this->fireModelEvent('imported');
    }
 
    // Register the existence of the publishing model event
    public static function importing($callback)
    {
        static::registerModelEvent('importing', $callback);
    }
 
    // Register the existence of the published model event
    public static function imported($callback)
    {
        static::registerModelEvent('imported', $callback);
    }
    
}
