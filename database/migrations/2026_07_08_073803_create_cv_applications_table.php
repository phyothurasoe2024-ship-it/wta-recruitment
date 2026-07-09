<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_applications', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 20)->unique();
            $table->string('name', 120);
            $table->string('nrc', 60)->unique();
            $table->text('address');
            $table->string('email', 160);
            $table->string('phone', 40);
            $table->string('photo_path', 255)->nullable();
            $table->string('nrc_file_path', 255)->nullable();
            $table->text('work_experience')->nullable();
            $table->text('why_join_wta');
            $table->enum('status', ['pending', 'under_review', 'interview', 'accepted', 'rejected'])
                  ->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('status');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_applications');
    }
};
