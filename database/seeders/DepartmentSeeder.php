<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        Department::truncate();

        // Wipe every item file in the public uploads dir.
        $disk = Storage::disk('public');
        foreach ($disk->files('departments') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                $disk->delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        // Attached files on the private (default) disk.
        foreach (Storage::files('private_uploads/departments') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                Storage::delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        if (! Location::count()) {
            $this->call(LocationSeeder::class);
        }

        $locationIds = Location::pluck('id');

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        Department::factory()->count(1)->hr()->create([
            'location_id' => $locationIds->random(),
            'created_by' => $admin->id,
        ]);

        Department::factory()->count(1)->engineering()->create([
            'location_id' => $locationIds->random(),
            'created_by' => $admin->id,
        ]);

        Department::factory()->count(1)->marketing()->create([
            'location_id' => $locationIds->random(),
            'created_by' => $admin->id,
        ]);

        Department::factory()->count(1)->client()->create([
            'location_id' => $locationIds->random(),
            'created_by' => $admin->id,
        ]);

        Department::factory()->count(1)->product()->create([
            'location_id' => $locationIds->random(),
            'created_by' => $admin->id,
        ]);

        Department::factory()->count(1)->silly()->create([
            'location_id' => $locationIds->random(),
            'created_by' => $admin->id,
        ]);
    }
}
