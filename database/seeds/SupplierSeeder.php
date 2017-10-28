<?php
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::truncate();
        factory(Supplier::class, 5)->create();

        $src = public_path('/img/demo/suppliers');
        $dst =  public_path('/uploads/suppliers');

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
