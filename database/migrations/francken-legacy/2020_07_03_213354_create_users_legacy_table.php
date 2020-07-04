<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersLegacyTable extends Migration
{
    protected $connection = 'francken-legacy';

    /**
     * Run the migrations.
     */
    public function up() : void
    {
        if (Schema::connection('francken-legacy')->hasTable('users')) {
            return;
        }

        Schema::connection('francken-legacy')->create('users', function (Blueprint $table) : void {
            $table->increments('id');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('');
            $table->timestamps();
        });
    }
}
