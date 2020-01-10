<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

/* Models */
use App\Models\Organisation;
use App\Models\User;
use App\Models\Branch;
use App\Models\Network;

class SeedAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /**
         * Add Admin
         */
        User::create(
            [
                'name' => 'Administrator',
                'email' => 'admin@test.acme',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
                'is_admin' => 1,
            ]
        );

        /**
         * Add User
         */
        User::create(
            [
                'name' => 'User',
                'email' => 'user@test.acme',
                'password' => Hash::make('password'),
                'email_verified_at' => Carbon::now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
