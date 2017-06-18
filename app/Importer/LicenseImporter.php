<?php

namespace App\Importer;

use App\Helpers\Helper;
use App\Models\Asset;
use App\Models\Category;
use App\Models\License;
use App\Models\Manufacturer;

class LicenseImporter extends ItemImporter
{
    protected $licenses;
    public function __construct($filename)
    {
        parent::__construct($filename);
        $this->licenses = License::all();
    }

    protected function handle($row)
    {
        // ItemImporter handles the general fetching.
        parent::handle($row);

        $this->createLicenseIfNotExists($row);
    }

    /**
     * Create the license if it does not exist.
     *
     * @author Daniel Melzter
     * @since 4.0
     * @param array $row
     * @return License|mixed|null
     */
    public function createLicenseIfNotExists(array $row)
    {
        $editingLicense = false;
        $license = new License;
        $license_id = $this->licenses->search(function ($key) {
            return strcasecmp($key->name, $this->item['name']) == 0;
        });
        if ($license_id !== false) {
            if (!$this->updating) {
                $this->log('A matching License ' . $this->item['name'] . ' already exists');
                return;
            }

            $this->log("Updating License");
            $editingLicense = true;
            $license = $this->licenses[$license_id];
        } else {
            $this->log("No Matching License, Creating a new one");
        }

        $asset_tag = $this->item['asset_tag'] = $this->findMatch($row, 'asset_tag'); // used for checkout out to an asset.
        $this->item['expiration_date'] = $this->findMatch($row, 'expiration_date');
        $this->item['license_email'] = $this->findMatch($row, "licensed_to_email");
        $this->item['license_name'] = $this->findMatch($row, "licensed_to_name");
        $this->item['maintained'] = $this->findMatch($row, 'maintained');
        $this->item['purchase_order'] = $this->findMatch($row, 'purchase_order');
        $this->item['reassignable'] = $this->findMatch($row, 'reassignable');
        $this->item['seats'] = $this->findMatch($row, 'seats');
        $this->item['termination_date'] = $this->findMatch($row, 'termination_date');

        if ($editingLicense) {
            $license->update($this->sanitizeItemForUpdating($license));
        } else {
            $license->fill($this->sanitizeItemForStoring($license));
        }
        if (!$editingLicense) {
            $this->licenses->add($license);
        }
        if (!$this->testRun) {
            if ($license->save()) {
                $license->logCreate('Imported using csv importer');
                $this->log('License ' . $this->item["name"] . ' with serial number ' . $this->item['serial'] . ' was created');

                // Lets try to checkout seats if the fields exist and we have seats.
                if ($license->seats > 0) {
                    $user = $this->item['user'];
                    $asset = Asset::where('asset_tag', $asset_tag)->first();
                    $targetLicense = $license->licenseSeats()->first();
                    if ($user) {
                        $targetLicense->assigned_to = $user->id;
                        if ($asset) {
                            $targetLicense->asset_id = $asset->id;
                        }
                        $targetLicense->save();
                    } elseif ($asset) {
                        $targetLicense->asset_id = $asset->id;
                        $targetLicense->save();
                    }
                }
                return;
            }
            $this->logError($license, 'License "' . $this->item['name'].'"');
        }
    }
}
