<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Company::truncate();
        factory(Company::class, 4)->create();

        $src = public_path('/img/demo/companies');
        $dst =  public_path('/uploads/companies');

        $del_files = glob($dst."/*.*");

        foreach($del_files as $del_file){ // iterate files
            if(is_file($del_file))
                unlink($del_file); // delete file
        }


        $add_files = glob($src."/*.*");
        foreach($add_files as $add_file){
            $file_to_copy = str_replace($src,$dst,$add_file);
            copy($add_file, $file_to_copy);
        }

    }
}
