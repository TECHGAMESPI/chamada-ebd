<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <style>
        img {
            width: 150px;
            margin-top: 2%;
        }
        .section-border {
            padding: 1em;
            margin: 0 1em;
        }
        .table th, .table td {
            padding: 0.5rem;
            font-size: 0.9rem;
        }
        @media print {
            .container-fluid {
                width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>

    <title>Relatório Geral - EBD</title>
</head>

<body>
    <div class="container-fluid px-3">
        <!-- Formulário de seleção de data -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('relatorio.geral') }}" method="GET" class="d-flex gap-2">
                        <input type="date" 
                               name="data" 
                               class="form-control" 
                               value="{{ $dataFormatada ?? date('Y-m-d') }}" 
                               required
                               max="{{ date('Y-m-d') }}">

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Gerar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Conteúdo do relatório -->
        <section class="border section-border">
            <div class="d-flex align-items-center mb-3">
                <img src="https://proposta.techgamespi.com/wp-content/uploads/2024/12/missao-png.png" alt="Logo da ipp" class="mr-3">
                <div>
                    <h2 class="mb-1">Relatório Geral - EBD</h2>
                    <h5>Data: {{ isset($dataExibicao) ? $dataExibicao : date('d/m/Y') }}</h5>
                </div>
            </div>
        </section>

        <section class="mt-3">
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>Turma</th>
                            <th>Matric.</th>
                            <th>Pres.</th>
                            <th>Aus.</th>
                            <th>Visit.</th>
                            <th>Bíb.(A)</th>
                            <th>Bíb.(V)</th>
                            <th>Total Pres.</th>
                            <th>Total Bíb.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_geral_matriculados = 0;
                            $total_geral_presentes = 0;
                            $total_geral_ausentes = 0;
                            $total_geral_visitantes = 0;
                            $total_geral_biblias_alunos = 0;
                            $total_geral_biblias_visitantes = 0;
                        @endphp

                        @if(isset($turmas) && $turmas->count() > 0)
                            @php
                                \Log::info('Data na view:', ['dataFormatada' => $dataFormatada]);
                            @endphp
                            
                            @foreach($turmas as $turma)
                                @php
                                    $alunos = $turma->alunos()->whereHas('aluno', function($query) {
                                        $query->where('is_active', true);
                                    })->get();
                                    
                                    $total_matriculados = count($alunos);
                                    $total_presentes = 0;
                                    $total_biblias = 0;
                                    $total_ausentes = 0;

                                    foreach ($alunos as $aluno) {
                                        try {
                                            \Log::info('Verificando presença para:', [
                                                'aluno_id' => $aluno->aluno->id,
                                                'turma_id' => $turma->id,
                                                'data' => $dataFormatada
                                            ]);
                                            
                                            $presenca = \App\Helper\Helpers::verificaPresenca(
                                                $aluno->aluno->id, 
                                                $turma->id, 
                                                $dataFormatada
                                            );
                                            
                                            $material = \App\Helper\Helpers::verificamaterial(
                                                $aluno->aluno->id, 
                                                $turma->id, 
                                                $dataFormatada
                                            );
                                            
                                            if ($presenca == 'Presente') {
                                                $total_presentes++;
                                            } else {
                                                $total_ausentes++;
                                            }
                                            
                                            if ($material == 'checked') {
                                                $total_biblias++;
                                            }
                                        } catch (\Exception $e) {
                                            \Log::error('Erro ao verificar presença:', ['error' => $e->getMessage()]);
                                            continue;
                                        }
                                    }

                                    // Busca visitantes
                                    $visitantes = \App\Helper\Helpers::contaVisitantes($turma->id, $dataFormatada);
                                    $total_visitantes = $visitantes['total'] ?? 0;
                                    $total_visitantes_com_biblia = $visitantes['com_material'] ?? 0;

                                    // Acumula totais gerais
                                    $total_geral_matriculados += $total_matriculados;
                                    $total_geral_presentes += $total_presentes;
                                    $total_geral_ausentes += $total_ausentes;
                                    $total_geral_visitantes += $total_visitantes;
                                    $total_geral_biblias_alunos += $total_biblias;
                                    $total_geral_biblias_visitantes += $total_visitantes_com_biblia;
                                @endphp

                                <tr class="text-center">
                                    <td>{{ $turma->nome_turma }}</td>
                                    <td>{{ $total_matriculados }}</td>
                                    <td>{{ $total_presentes }}</td>
                                    <td>{{ $total_ausentes }}</td>
                                    <td>{{ $total_visitantes }}</td>
                                    <td>{{ $total_biblias }}</td>
                                    <td>{{ $total_visitantes_com_biblia }}</td>
                                    <td>{{ $total_presentes + $total_visitantes }}</td>
                                    <td>{{ $total_biblias + $total_visitantes_com_biblia }}</td>
                                </tr>
                            @endforeach
                        @endif

                        <!-- Linha de totais -->
                        <tr class="text-center font-weight-bold bg-light">
                            <td>TOTAIS</td>
                            <td>{{ $total_geral_matriculados }}</td>
                            <td>{{ $total_geral_presentes }}</td>
                            <td>{{ $total_geral_ausentes }}</td>
                            <td>{{ $total_geral_visitantes }}</td>
                            <td>{{ $total_geral_biblias_alunos }}</td>
                            <td>{{ $total_geral_biblias_visitantes }}</td>
                            <td>{{ $total_geral_presentes + $total_geral_visitantes }}</td>
                            <td>{{ $total_geral_biblias_alunos + $total_geral_biblias_visitantes }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <footer class="mt-3">
            <p class="small text-center">Relatório Geral EBD {{ date('Y') }}</p>
        </footer>
    </div>
</body>
</html>