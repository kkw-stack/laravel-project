<?php

use App\Models\Manager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone');
            $table->string('password');
            $table->boolean('is_super')->default(false);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('manager_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        if (env('JT_SUPER_ADMIN_NAME') && env('JT_SUPER_ADMIN_EMAIL') && env('JT_SUPER_ADMIN_PHONE') && env('JT_SUPER_ADMIN_PASSWORD')) {
            Manager::firstOrCreate([
                'name' => env('JT_SUPER_ADMIN_NAME'),
                'email' => env('JT_SUPER_ADMIN_EMAIL'),
                'phone' => env('JT_SUPER_ADMIN_PHONE'),
                'password' => env('JT_SUPER_ADMIN_PASSWORD'),
                'is_super' => true,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managers');
        Schema::dropIfExists('manager_password_reset_tokens');
    }
};
