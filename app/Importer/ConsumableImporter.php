<?php

namespace App\Importer;

use App\Models\Consumable;

class ConsumableImporter extends ItemImporter
{
    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        parent::handle($row);
        $this->createConsumableIfNotExists($row);
    }

    /**
     * Create a consumable if a duplicate does not exist
     *
     * @author Daniel Melzter
     * @param  array $row CSV Row Being parsed.
     * @since 3.0
     */
    public function createConsumableIfNotExists($row)
    {
        $consumable = Consumable::where('name', $this->item['name'])->first();
        if ($consumable) {
            if (! $this->updating) {
                $this->log('A matching Consumable '.$this->item['name'].' already exists.  ');

                return;
            }
            $this->log('Updating Consumable');
            $consumable->update($this->sanitizeItemForUpdating($consumable));
            $consumable->save();

            return;
        }
        $this->log('No matching consumable, creating one');
        $consumable = new Consumable();
        $this->item['model_number'] = $this->findCsvMatch($row, 'model_number');
        $this->item['item_no'] = $this->findCsvMatch($row, 'item_number');
        $this->item['min_amt'] = $this->findCsvMatch($row, "min_amt");
        $consumable->fill($this->sanitizeItemForStoring($consumable));
        //FIXME: this disables model validation.  Need to find a way to avoid double-logs without breaking everything.
        $consumable->unsetEventDispatcher();
        if ($consumable->save()) {
            $consumable->logCreate('Imported using CSV Importer');
            $this->log('Consumable '.$this->item['name'].' was created');

            return;
        }
        $this->logError($consumable, 'Consumable');
    }
}
