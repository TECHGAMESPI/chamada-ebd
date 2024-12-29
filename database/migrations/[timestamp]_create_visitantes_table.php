use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitantesTable extends Migration
{
    public function up()
    {
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
            $table->date('data');
            $table->foreignId('igreja_id')->constrained('igrejas')->onDelete('cascade');
            $table->integer('quantidade')->default(0);
            $table->integer('com_material')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitantes');
    }
} 