<?php

use App\Http\Controllers\Item\{CreateController as ItemCreateController, DeleteItemController, UpdateItemController};
use App\Http\Controllers\Question\{CreateController, DeleteQuestionController, UpdateQuestionController};
use App\Http\Controllers\Quiz\DeleteQuizController;
use App\Http\Controllers\{AlterarSenhaController,
    AlunosPorTurmaController,
    EvaluationResponseController,
    PdfController,
    PerfilController,
    PrincipalController,
    ProfessorPorTurmaController,
    TurmaController,
    UsuariosController,
    VisualizarChamadasController};
use App\Livewire\Administrator\User\Register as UserRegister;
use App\Livewire\Church\{Create, Edit, Index, Show};
use App\Livewire\Class\Index as ClassIndex;
use App\Livewire\material\{Create as materialCreate, Edit as materialEdit, Index as materialIndex, Show as materialShow};
use App\Livewire\Quiz\Item\{Create as ItemCreate, Edit as ItemEdit};
use App\Livewire\Quiz\Question\{Create as QuestionCreate, Edit as QuestionEdit, Show as QuestionShow};
use App\Livewire\Quiz\Scheduling\{Index as SchedulingIndex, Show as SchedulingShow};
use App\Livewire\Quiz\{Create as QuizCreate, Edit as QuizEdit, Index as QuizIndex, Response, Revision, Show as QuizShow, ShowAll};
use App\Livewire\Student\{Create as StudentCreate, Index as StudentIndex};
use App\Livewire\User\{Edit as UserEdit, Index as UserIndex, Profile, Register};
use App\Livewire\{Chamada, Relatorios};
use Illuminate\Support\Facades\{Auth, Route};
use App\Http\Controllers\RelatorioGeralController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('principal');
    }

    return view('auth.login');
});

Route::get('/entrar', function () {
    if (Auth::check()) {
        return redirect()->route('principal');
    }

    return view('auth.login');
})->name("entrar");

Route::middleware(['auth'])->group(function () {

    Route::get('/user/home', [PrincipalController::class, 'index'])->name('principal');

    Route::get('/user/usuarios', UserIndex::class)->name('usuarios');
    Route::delete('/user/{id}/delete', [UsuariosController::class, 'destroy'])->name('delete.user');
    Route::get('/user/usuario/{id}/editar', UserEdit::class)->name('user.edit');
    Route::put('/user/usuario/{id}/editar', [UsuariosController::class, 'update']);

    Route::get('/user/chamada', Chamada::class)->name('chamada');
    Route::get('/user/chamada/{id}', Chamada::class);

    Route::get('/user/visualizar-chamadas/', [VisualizarChamadasController::class, 'create'])->name('visualizar-chamadas');
    Route::get('/user/visualizar-chamadas-por-turma/', [VisualizarChamadasController::class, 'chamadas'])->name('todas-chamadas');
    Route::get('/user/visualizar-chamadas-por-turma/{id}', [VisualizarChamadasController::class, 'chamadas']);
    Route::get('/user/turmas', ClassIndex::class)->name('turmas');

    Route::get('/user/turma', [TurmaController::class, 'create'])->name('turma.create');
    Route::post('/user/turma', [TurmaController::class, 'store'])->name('turma.store');
    Route::get('/user/turma/{id}/editar', [TurmaController::class, 'editar'])->name('turma.edit');
    Route::put('/user/turma/{id}/editar', [TurmaController::class, 'update'])->name('turma.update');
    Route::delete('/user/excluir-turma', [TurmaController::class, 'destroy'])->name('excluir-turma');

    Route::get('/user/professor-por-turma', [ProfessorPorTurmaController::class, 'index'])->name('professorPorTurma');
    Route::get('/user/associar-professor', [ProfessorPorTurmaController::class, 'create'])->name('associar-professor');
    Route::post('/user/associar-professor', [ProfessorPorTurmaController::class, 'store']);
    Route::get('/user/atualiza-turma/{id}', [ProfessorPorTurmaController::class, 'atualizaTurma']);
    Route::post('/user/excluir-professor', [ProfessorPorTurmaController::class, 'destroy'])->name('excluir-professor');

    Route::get('/user/aluno-por-turma', StudentIndex::class)->name('alunoPorTurma');
    Route::get('/user/associar-aluno', StudentCreate::class)->name('associar-aluno');
    Route::post('/user/associar-aluno', [AlunosPorTurmaController::class, 'store']);
    Route::post('/user/excluir-aluno', [AlunosPorTurmaController::class, 'destroy'])->name('excluir-aluno');

    Route::get('/user/perfil', Profile::class)->name('perfil');
    Route::put('/user/perfil', [PerfilController::class, 'UPDATE']);

    Route::get('/user/alterar-senha', [AlterarSenhaController::class, 'create'])->name('alterar-senha');
    Route::post('/user/alterar-senha', [AlterarSenhaController::class, 'store'])->name('alterar-senha');

    Route::get('/user/alunos-por-turma/', Relatorios::class)->name('alunos.relatorio');
    Route::post('/alunos/pdf/', [PdfController::class, 'alunosPorTurma'])->name('alunos-por-turma');
    Route::get('/user/quiz/{quiz}/pdf', [PdfController::class, 'quiz'])->name('quiz.pdf');

    Route::get('/registrar-usuario', Register::class)->name('registrar.index');
    Route::get('/igrejas', Index::class)->name('igrejas.index');
    Route::get('/igrejas/novo', Create::class)->name('igrejas.create');
    Route::get('/igrejas/editar/{id}', Edit::class)->name('igrejas.edit');
    Route::get('/igrejas/{id}', Show::class)->name('igrejas.show');

    Route::prefix('user/material')->name('material.')->group(function () {
        Route::get('/', materialIndex::class)->name('index');
        Route::get('create', materialCreate::class)->name('create');
        Route::get('show/{material}', materialShow::class)->name('show');
        Route::get('edit/{material}', materialEdit::class)->name('edit');
    });

    Route::prefix('user/quiz')->name('quiz.')->group(function () {
        Route::get('/', QuizIndex::class)->name('index');
        Route::get('create', QuizCreate::class)->name('create');
        Route::get('show/{quiz}', QuizShow::class)->name('show');
        Route::get('show/{quiz}/all', ShowAll::class)->name('show.all');
        Route::get('edit/{quiz}', QuizEdit::class)->name('edit');
        Route::delete('delete/{quiz}', DeleteQuizController::class)->name('delete');
    });

    Route::prefix('user/quiz/scheduling')->name('quiz.scheduling.')->group(function () {
        Route::get('/', SchedulingIndex::class)->name('index');
        Route::get('create/{quiz}', App\Livewire\Quiz\Scheduling\Create::class)->name('create');
        Route::get('show/{quiz}', SchedulingShow::class)->name('show');
        //        Route::get('show/{quiz}/all', ShowAll::class)->name('show.all');
        //        Route::get('edit/{quiz}', QuizEdit::class)->name('edit');
        //        Route::delete('delete/{quiz}', DeleteQuizController::class)->name('delete');
    });

    Route::get('/user/quiz/{quiz}/question/{question}/show', QuestionShow::class)->name('question.show')->lazy();
    Route::get('/user/quiz/{quiz}/question/create', QuestionCreate::class)->name('question.create')->lazy();
    Route::post('/user/quiz/{quiz}/question/create', CreateController::class)->name('question.store');
    Route::get('/user/quiz/{quiz}/question/{question}/edit', QuestionEdit::class)->name('question.edit');
    Route::put('/user/quiz/{quiz}/question/{question}/edit', UpdateQuestionController::class)->name('question.update');
    Route::delete('/user/question/{question}/delete', DeleteQuestionController::class)->name('question.delete');

    Route::get('/user/quiz/{quiz}/question/{question}/item/create', ItemCreate::class)->name('item.create')->lazy();
    Route::post('/user/quiz/{quiz}/question/{question}/item/create', ItemCreateController::class)->name('item.store')->lazy();
    Route::delete('/user/quiz/{quiz}/question/{question}/item/{item}/delete', DeleteItemController::class)->name('item.delete');
    Route::get('/user/quiz/{quiz}/question/{question}/item/{item}/edit', ItemEdit::class)->name('item.edit');
    Route::put('/user/quiz/{quiz}/question/{question}/item/{item}/edit', UpdateItemController::class)->name('item.update');

    Route::get('/user/quiz/{quiz}/revision', Revision::class)->name('quiz.revision');
    Route::get('/user/quiz/{quiz}/response', Response::class)->name('quiz.response');
    Route::get('/user/quiz/{quiz}/response/evaluation', EvaluationResponseController::class)->name('quiz.response.evaluation');

    Route::get('/register', UserRegister::class)->name('register');

    Route::get('/gameficacao', function () {
        toastr()->addInfo('Função em desenvolvimento', 'Aguarde!');

        return back();
    })->name('gamiicacao')->middleware('auth');

    Route::get('/relatorio-geral', [RelatorioGeralController::class, 'index'])
        ->name('relatorio.geral.index');
    Route::get('/relatorio-geral/gerar', [RelatorioGeralController::class, 'gerarRelatorio'])
        ->name('relatorio.geral');
});

Route::get('/sair', function () {
    Auth::logout();

    return redirect('/entrar');
});

require __DIR__ . '/auth.php';
