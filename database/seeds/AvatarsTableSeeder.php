<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AvatarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // users avatars
      for ($i=0; $i < 12; $i++) {
        DB::table('user_avatars')->insert([
          'avatar'=>'cute'.$i.'.png',
          'path'=>"student_images",
        ]);
      }
        // classroom
      for ($i=1; $i <= 18; $i++) {
        DB::table('class_avatars')->insert([
          'avatar'=>'class'.$i.'.png',
          'path'=>"class_images",
        ]);
      }
      // Skill Icons
      for ($i=1; $i <= 50; $i++) {
        DB::table('skill_icons')->insert([
          'avatar'=>'skill-icon'.$i.'.png',
          'path'=>"skill_icons",
        ]);
      }

    }
}
