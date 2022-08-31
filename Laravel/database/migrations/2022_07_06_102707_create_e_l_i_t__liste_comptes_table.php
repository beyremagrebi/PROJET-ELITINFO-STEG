<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ELIT_ListeCompte;

class CreateELITListeComptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_l_i_t__liste_comptes', function (Blueprint $table) {
            $table->string('CodeCompte',128)->primary();
            $table->string('CodeCompteBancaire',128);
            $table->string('Caption',128);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_l_i_t__liste_comptes');
    }
}
