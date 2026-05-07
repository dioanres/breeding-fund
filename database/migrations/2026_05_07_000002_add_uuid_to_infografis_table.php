<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Infografis;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('infografis', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->unique()->after('id');
        });

        // Backfill existing rows
        Infografis::whereNull('uuid')->each(fn ($row) => $row->update(['uuid' => Str::uuid()]));

        Schema::table('infografis', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('infografis', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
