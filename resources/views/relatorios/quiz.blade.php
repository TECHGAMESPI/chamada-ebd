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

    <title>Quiz - {{ $quiz->title }}</title>
</head>

<body>
    <div class="container-fluid">
        <section class="border section-border">
            <div class="row">
                <table>
                    <tbody>
                        <tr>
                            <td class="col-1">
                                <img src="https://chamadaebd.com.br/img/missao-png.png" alt="Logo da MEPB">
                            </td>
                            <td class="col-10">
                                <div>
                                    <h1>Quiz - {{ $quiz->title }}</h1>
                                    <h2>{{ $quiz->type }}</h2>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="row alunos mt-3">
            <div class="col-11">

                @forelse ($quiz->questions as $key => $question)

                    <h3>Questão {{ $key + 1 }}</h3>
                    {!! $question->body !!}
                    <p><strong>Alternativas:</strong></p>
                    <ul>
                        @forelse ($question->items as $key => $item)
                            <li>{!! $item->body !!}</li>
                        @empty
                            <li>Não existem itens cadastradas.</li>
                        @endforelse
                    </ul>


                @empty
                    <p>Não existem questões cadastradas.</p>
                @endforelse
            </div>
        </section>
        <footer>
            <p class="small text-center">Minha EBD {{ date('Y') }}</p>
        </footer>
</body>

</html>
