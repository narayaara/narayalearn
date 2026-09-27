<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->string('type')->default('material')->after('material_id');
            // type: 'material' atau 'topic'
            
            // Untuk topik, simpen subject_id + topic_name
            $table->unsignedBigInteger('subject_id')->nullable()->after('type');
            $table->string('topic_name')->nullable()->after('subject_id');
        });
    }

    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropColumn(['type', 'subject_id', 'topic_name']);
        });
    }
};