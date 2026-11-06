<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('package_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->integer('base_duration_hours')->default(1);
            $table->integer('base_edited_photos')->default(0);
            $table->boolean('includes_raw')->default(false);
            $table->boolean('includes_album')->default(false);
            $table->boolean('includes_video')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add template_id to photographer_packages
        Schema::table('photographer_packages', function (Blueprint $table) {
            $table->foreignId('template_id')
                  ->nullable()
                  ->constrained('package_templates')
                  ->onDelete('set null')
                  ->after('id');
        });
    }

    public function down(): void {
        Schema::table('photographer_packages', function (Blueprint $table) {
            $table->dropForeign(['template_id']);
            $table->dropColumn('template_id');
        });
        Schema::dropIfExists('package_templates');
    }
};