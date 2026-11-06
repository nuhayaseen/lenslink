<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('photographer_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photographer_profile_id')
                  ->constrained('photographer_profiles')
                  ->onDelete('cascade');
            $table->string('name');                        // Basic, Standard, Premium
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('duration_hours');             // how many hours included
            $table->integer('edited_photos');              // number of edited photos delivered
            $table->boolean('includes_raw')->default(false);
            $table->boolean('includes_album')->default(false);
            $table->boolean('includes_video')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('photographer_packages');
    }
};