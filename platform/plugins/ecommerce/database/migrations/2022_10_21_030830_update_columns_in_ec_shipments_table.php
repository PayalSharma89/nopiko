<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('ec_shipments', 'label_url')) {
            Schema::table('ec_shipments', function (Blueprint $table): void {
                $table->text('label_url')->nullable();
                $table->mediumText('metadata')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('ec_shipments', function (Blueprint $table): void {
            $table->dropColumn(['label_url', 'transaction']);
        });
    }
};
