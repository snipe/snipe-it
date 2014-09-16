<?php

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        
        $this->call('AssetsSeeder');
        $this->call('CategoriesSeeder');
        
        // Location now created during installation
        // $this->call('LocationsSeeder');
        
        $this->call('ManufacturersSeeder');
        $this->call('ModelsSeeder');
        $this->call('DepreciationsSeeder');
        $this->call('StatuslabelsSeeder');
        $this->call('SettingsSeeder');
        $this->call('LicensesSeeder');
        $this->call('LicenseSeatsSeeder');
        $this->call('ActionlogSeeder');
        
        // Entity now created during installation
        // $this->call('EntitiesSeeder');
        
        $this->call('DefaultsSeeder');
        $this->call('CountriesSeeder');
        
        $this->call('InventoryStatesSeeder');
        $this->call('FamiliesSeeder');
        $this->call('ServiceAgreementsSeeder');
        $this->call('ServiceAgreementTypesSeeder');
        
    }

}
