<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('photographer_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->foreignId('package_id')
                  ->nullable()
                  ->constrained('photographer_packages')
                  ->onDelete('set null');
            $table->string('event_type');
            $table->date('event_date');
            $table->string('event_location');
            $table->integer('duration_hours');
            $table->decimal('budget', 10, 2);
            $table->integer('guest_count')->nullable();
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'accepted', 'cancelled', 'completed'])
                  ->default('pending');
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};