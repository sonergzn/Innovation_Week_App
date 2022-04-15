<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $currentdate = date('Y-m-d H:i:s');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('posts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($i=0; $i < 10; $i++) { 
            DB::table('posts')->insert([
                'slug'=>Str::random(7),
                'title'=>Str::random(10),
                'description'=>Str::random(20),
                'image_path'=>Str::random(5),
                'created_at'=>$currentdate,
                'updated_at'=>$currentdate,
                'user_id'=>1
            ]);
        }
           
    }
}
