<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Administrator extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\Models\User;
$administrator->username = "administrator";
$administrator->name = "Site Administrator";
$administrator->email = "administrator@sr-mobil.test";
$administrator->password = \Hash::make("admin");
$administrator->save();
$this->command->info("administrator berhasil ditambahkan");
    }
}
