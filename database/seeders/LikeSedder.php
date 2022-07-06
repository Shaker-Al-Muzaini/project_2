<?php

namespace Database\Seeders;

use App\Models\Tweet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(50)->create();
        Tweet::factory()->count(50)->create();
        foreach (range(1, 100) as $value) {
            DB::table('likes')->insert([
                'user_id' => User::all()->random()->id,
                'tweet_id' => Tweet::all()->random()->id,
            ]);
        }
    }
}
