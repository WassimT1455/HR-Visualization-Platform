<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnexionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('connexions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // lien vers utilisateur
            $table->string('ip_address')->nullable();          // IP de connexion
            $table->string('device')->nullable();              // type d'appareil
            $table->string('browser')->nullable();             // navigateur
            $table->string('operating_system')->nullable();    // OS
            $table->string('country')->nullable();             // pays détecté
            $table->timestamp('login_time')->nullable();       // datetime complet
            $table->string('heure_connexion')->nullable();     // heure seule
            $table->string('navigateur')->nullable();          // redondant avec browser
            $table->string('appareil')->nullable();            // redondant avec device
            $table->string('date')->nullable();                // date
            $table->string('time')->nullable();                // heure
            $table->text('cs_user_agent')->nullable();         // user agent complet
            $table->integer('distance_horaire')->nullable();   // écart avec horaire normal
            $table->integer('cs_status')->nullable();          // statut HTTP (200, 403…)
            $table->boolean('suspicious')->nullable();         // 1 si suspecte, 0 sinon
            $table->timestamps();

            // Clé étrangère vers users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connexions');
    }
}
