<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

    <style>
        img {
            width: 80%;
            margin-top: 2%;
        }

        .titulo {
            display: flex;
            margin-top: -6%;
            margin-left: 17% !important;
        }

        .section-border {
            padding-left: 1.5em;
            margin-right: 5%;
        }
    </style>

    <title>Turma - {{ $turma->nome_turma }}</title>
</head>

<body>
    <div class="container-fluid">
        <section class="border section-border">
            <div class="row">
                <table>
                    <tbody>
                        <tr>
                            <td class="col-1">
                                <img src="https://proposta.techgamespi.com/wp-content/uploads/2024/12/missao-png.png" alt="Logo da Igreja Presbiteriana da Piçarreira">
                            </td>
                            <td class="col-10">
                                <div>
                                    <h1>Relatório de Alunos por Turma</h1>
                                    <h2>{{ $turma->nome_turma }}</h2>
                                    <h3>Data: {{ $data }}</h3>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="row alunos">
            <div class="col-11">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nome do Aluno</th>
                            <th scope="col">Status</th>
                            <th scope="col">Bíblia</th>
                            <th scope="col">Livro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_matriculados = count($alunos);
                            $total_presentes = 0;
                            $total_biblias = 0;
                            $total_livros = 0;
                        @endphp
                        @foreach ($alunos as $aluno)
                            @php
                                try {
                                    $dataFormatada = \Carbon\Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $dataFormatada = date('Y-m-d');
                                }
                                
                                $presenca = \App\Helper\Helpers::verificaPresenca($aluno->aluno->id, $turma->id, $dataFormatada);
                                $material = \App\Helper\Helpers::verificamaterial($aluno->aluno->id, $turma->id, $dataFormatada);
                                
                                if ($presenca == 'Presente') {
                                    $total_presentes++;
                                }
                                if ($material == 'checked') {
                                    $total_biblias++;
                                }
                                if ($material == 'checked' && $presenca == 'Presente') {
                                    $total_livros++;
                                }
                            @endphp
                            <tr>
                                <td class="small">{{ $aluno->aluno->name }}</td>
                                <td class="small">{{ $presenca }}</td>
                                <td class="small">{{ $material == 'checked' ? 'Sim' : 'Não' }}</td>
                                <td class="small">{{ $material == 'checked' && $presenca == 'Presente' ? 'Sim' : 'Não' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <section class="row mt-4">
            <div class="col-11">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="7" class="text-center">Estatísticas da Turma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_matriculados = count($alunos);
                            $total_presentes = 0;
                            $total_biblias = 0;
                            $total_livros = 0;

                            foreach ($alunos as $aluno) {
                                try {
                                    $dataFormatada = \Carbon\Carbon::createFromFormat('d/m/Y', $data)->format('Y-m-d');
                                } catch (\Exception $e) {
                                    $dataFormatada = date('Y-m-d');
                                }
                                
                                $presenca = \App\Helper\Helpers::verificaPresenca($aluno->aluno->id, $turma->id, $dataFormatada);
                                $material = \App\Helper\Helpers::verificamaterial($aluno->aluno->id, $turma->id, $dataFormatada);
                                
                                if ($presenca == 'Presente') {
                                    $total_presentes++;
                                }
                                if ($material == 'checked') {
                                    $total_biblias++;
                                }
                                if ($material == 'checked' && $presenca == 'Presente') {
                                    $total_livros++;
                                }
                            }
                            $total_ausentes = $total_matriculados - $total_presentes;

                            // Recupera dados dos visitantes
                            $visitantes = \App\Helper\Helpers::contaVisitantes($turma->id, $dataFormatada);
                            $total_visitantes = $visitantes['total'];
                            $total_visitantes_com_biblia = $visitantes['com_material'];

                            // Cálculo dos totais gerais
                            $total_geral_presentes = $total_presentes + $total_visitantes;
                            $total_geral_biblias = $total_biblias + $total_visitantes_com_biblia;
                        @endphp
                        <tr class="text-center">
                            <td>
                                <strong>Matriculados</strong><br>
                                {{ $total_matriculados }}
                            </td>
                            <td>
                                <strong>Presenças</strong><br>
                                {{ $total_presentes }}
                            </td>
                            <td>
                                <strong>Visitantes</strong><br>
                                {{ $total_visitantes }}
                            </td>
                            <td>
                                <strong>Bíblias (Alunos)</strong><br>
                                {{ $total_biblias }}
                            </td>
                            <td>
                                <strong>Bíblias (Visitantes)</strong><br>
                                {{ $total_visitantes_com_biblia }}
                            </td>
                            <td>
                                <strong>Total Presentes</strong><br>
                                {{ $total_geral_presentes }}
                            </td>
                            <td>
                                <strong>Total Bíblias</strong><br>
                                {{ $total_geral_biblias }}
                            </td>
                        </tr>

                        @if($visitantes['total'] > 0)
                            <tr>
                                <td colspan="7">
                                    <strong>Resumo de Visitantes:</strong>
                                    <ul>
                                        <li>Total de Visitantes: {{ $visitantes['total'] }}</li>
                                        <li>Visitantes com Bíblia: {{ $visitantes['com_material'] }}</li>
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        <footer>
            <p class="small text-center">Chamada EBD {{ date('Y') }}</p>
        </footer>
    </div>
</body>

</html>
