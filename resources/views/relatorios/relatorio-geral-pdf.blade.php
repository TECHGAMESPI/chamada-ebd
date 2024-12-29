<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório Geral - {{ $dataExibicao }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f5f5f5;
        }
        .totais {
            font-weight: bold;
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório Geral de Turmas</h1>
        <h2>Data: {{ $dataExibicao }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Turma</th>
                <th>Matriculados</th>
                <th>Presentes</th>
                <th>Ausentes</th>
                <th>Visitantes</th>
                <th>Bíblias (Alunos)</th>
                <th>Bíblias (Visitantes)</th>
                <th>Total Presentes</th>
                <th>Total Bíblias</th>
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
                            $presenca = \App\Helper\Helpers::verificaPresenca($aluno->aluno->id, $turma->id, $dataFormatada);
                            $material = \App\Helper\Helpers::verificamaterial($aluno->aluno->id, $turma->id, $dataFormatada);
                            
                            if ($presenca == 'Presente') {
                                $total_presentes++;
                            } else {
                                $total_ausentes++;
                            }
                            
                            if ($material == 'checked') {
                                $total_biblias++;
                            }
                        } catch (\Exception $e) {
                            continue;
                        }
                    }

                    $visitantes = \App\Helper\Helpers::contaVisitantes($turma->id, $dataFormatada);
                    $total_visitantes = $visitantes['total'];
                    $total_visitantes_com_biblia = $visitantes['com_material'];

                    $total_geral_matriculados += $total_matriculados;
                    $total_geral_presentes += $total_presentes;
                    $total_geral_ausentes += $total_ausentes;
                    $total_geral_visitantes += $total_visitantes;
                    $total_geral_biblias_alunos += $total_biblias;
                    $total_geral_biblias_visitantes += $total_visitantes_com_biblia;
                @endphp

                <tr>
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

            <tr class="totais">
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
</body>
</html> 