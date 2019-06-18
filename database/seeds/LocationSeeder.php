<?php
use Illuminate\Database\Seeder;
use App\Models\Location;


class LocationSeeder extends Seeder
{
    public function run()
    {
        Location::truncate();
        factory(Location::class, 10)->create();

        $src = public_path('/img/demo/locations');
        $dst =  public_path('/uploads/locations');

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
