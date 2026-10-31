<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomFieldsToUsersTable extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->nullable()->after('password');
            $table->string('matricule')->nullable()->after('role');
            $table->string('fonction')->nullable()->after('matricule');
            $table->integer('solde_conges')->default(0)->after('fonction');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'matricule', 'fonction', 'solde_conges']);
        });
    }
}
