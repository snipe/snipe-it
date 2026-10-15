<?php

namespace App\Importer;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

/**
 * When we are importing users via an Asset/etc import, we use createOrFetchUser() in
 * Importer\Importer.php. [ALG]
 *
 * Class CategoryImporter
 */
class CategoryImporter extends ItemImporter
{
    protected $categories;

    public function __construct($filename)
    {
        parent::__construct($filename);
    }

    protected function handle($row)
    {
        // CategoryImporter deliberately does NOT call parent::handle(). See
        // the other subclass migrations for the same pattern: absent CSV
        // columns stay out of $this->item so update mode preserves the DB
        // value, and present-but-empty cells land as null so update mode
        // clears the DB value. The base sanitize's reject-empty pass is
        // disabled by $rejectEmptyOnUpdate on ItemImporter.
        $this->item = [];

        $this->setItemFromCsvIfPresent($row, 'name');
        $this->setItemFromCsvIfPresent($row, 'notes');
        $this->setItemFromCsvIfPresent($row, 'eula_text');
        $this->setItemFromCsvIfPresent($row, 'tag_color');

        // category_type is required-in-list-of-5 validation. Lowercase it so
        // "Asset" from a human-authored CSV lands as "asset". Present-empty
        // stays as null (which will fail validation with a clear message).
        if ($this->csvRowHas($row, 'category_type')) {
            $raw = $this->findCsvMatch($row, 'category_type');
            $this->item['category_type'] = ($raw !== '') ? strtolower($raw) : null;
        }

        // Boolean flags. Present-empty maps to 0; present-with-value uses
        // fetchHumanBoolean; absent leaves the DB value alone on update.
        foreach (['use_default_eula', 'require_acceptance', 'checkin_email', 'alert_on_response'] as $flag) {
            if ($this->csvRowHas($row, $flag)) {
                $raw = $this->findCsvMatch($row, $flag);
                $this->item[$flag] = ($this->fetchHumanBoolean($raw) == 1) ? 1 : 0;
            }
        }

        $this->createCategoryIfNotExists($row);
    }

    /**
     * Create a category if a duplicate does not exist.
     *
     * @todo Investigate how this should interact with Importer::createCategoryIfNotExists
     *
     * @author A. Gianotto
     *
     * @since 6.1.0
     */
    public function createCategoryIfNotExists(array $row)
    {
        $editingCategory = false;
        $name = trim($this->item['name'] ?? '');

        $category = Category::where('name', '=', $name)->first();

        if ($this->findCsvMatch($row, 'id') != '') {
            // Override category if an ID was given
            \Log::debug('Finding category by ID: '.$this->findCsvMatch($row, 'id'));
            $category = Category::find($this->findCsvMatch($row, 'id'));
        }

        if ($category) {
            if (! $this->updating) {
                $this->log('A matching Category '.$name.' already exists');
                $this->recordSkipped();

                return;
            }

            $this->log('Updating Category');
            $editingCategory = true;
        } else {
            $this->log('No Matching Category, Create a new one');
            $category = new Category;
            $category->created_by = $this->created_by;
        }

        Log::debug('Item array is: ');
        Log::debug(print_r($this->item, true));

        if ($editingCategory) {
            Log::debug('Updating existing category');
            $category->update($this->sanitizeItemForUpdating($category));
        } else {
            Log::debug('Creating category');
            $category->fill($this->sanitizeItemForStoring($category));
        }

        if ($category->save()) {
            $this->log('Category '.$category->name.' created or updated from CSV import');
            if ($editingCategory) {
                $this->recordUpdated();
            } else {
                $this->recordCreated();
            }

            return $category;

        } else {
            Log::debug($category->getErrors());
            $this->recordErrored();
            $this->logError($category, 'Category "'.$name.'"');

            return $category->errors;
        }

    }
}
