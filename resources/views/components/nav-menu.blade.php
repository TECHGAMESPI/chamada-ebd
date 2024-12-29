<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation">
            <li><a href="{{ route('principal') }}"><i class="la la-home"></i><span class="menu-title" data-i18n="Dashboard">
                        Dashboard</span></a>
            </li>


            <li class=" navigation-header">MENU<i class="la la-ellipsis-h" data-toggle="tooltip" data-placement="right"
                    data-original-title="User Interface"></i>
            </li>
            @can('is_admin')
                <li class=" nav-item"><a href="#"><i class="fas fa-user-cog mr-1"></i>
                        <span class="menu-title">Administração</span>
                    </a>
                    <ul class="menu-content">
                        <li><a class="menu-item" href="{{ route('usuarios') }}"><i class="fas fa-users mr-1"></i><span
                                    data-i18n="">Usuários</span></a>
                        </li>
                        <li><a class="menu-item" href="{{ route('register') }}"><i class="fa fa-plus mr-1"
                                    aria-hidden="true"></i><span data-i18n="">Novo</span></a>
                        </li>
                        <li><a class="menu-item" href="{{ route('igrejas.index') }}"><i class="fas fa-church mr-1"></i><span
                                    data-i18n="Invoice List">Igrejas</span></a>
                        </li>
                    </ul>
                </li>
            @endcan
            <li class=" nav-item"><a href="#"><i class="fas fa-user mr-1"></i><span class="menu-title"
                        data-i18n="Components">Usuário</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('usuarios') }}"><i class="fas fa-users mr-1"></i><span
                                data-i18n="Alerts">Usuários</span></a>
                    </li>
                    @can('admin_superintendente')
                        <li><a class="menu-item" href="{{ route('registrar.index') }}"><i class="fa fa-plus mr-1"
                                    aria-hidden="true"></i><span data-i18n="Callout">Novo</span></a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="fas fa-user-graduate mr-1"></i><span class="menu-title"
                        data-i18n="Authentication">Alunos</span></a>
                <ul class="menu-content">
                    <li><a class="menu-item" href="{{ route('alunoPorTurma') }}"><i
                                class="fas fa-chalkboard-teacher mr-1"></i><span>Alunos por turma</span></a>
                    </li>
                    @cannot('aluno')
                        <li>
                            <a class="menu-item" href="{{ route('associar-aluno') }}">
                                <i class="fa fa-plus mr-1"></i>
                                <span>Associar Aluno</span></a>
                        </li>
                    @endcannot
                </ul>
            </li>
            <li class=" nav-item"><a href="#" class="menu-title"><i class="fas fa-list mr-1"></i><span
                        class="menu-title">Chamadas</span> </a>
                <ul class="menu-content">
                    @cannot('aluno')
                        <li><a class="menu-item" href="{{ route('chamada') }}"><i class="fa fa-plus" aria-hidden="true"></i>
                                Nova</a>
                        </li>
                        <li><a class="menu-item" href="{{ route('todas-chamadas') }}"><i class="fa fa-eye"
                                    aria-hidden="true"></i>
                                Todas Chamadas</a></li>
                    @endcannot
                    <li><a class="menu-item" href="{{ route('visualizar-chamadas') }}"><i class="fa fa-eye"
                                aria-hidden="true"></i>
                            Visualizar</a></li>

                </ul>
            </li>

            <li class=" nav-item"><a href="{{ route('material.index') }}"><i class="la la-file-text"></i><span
                        class="menu-title" data-i18n="Form Layouts">material de Apoio</span></a>

            </li>

            <li class=" nav-item"><a href="#"><i class="fas fa-chalkboard-teacher mr-1"></i><span
                        class="menu-title">Professores</span></a>
                <ul class="menu-content">
                    @can('admin_superintendente')
                        <li><a class="menu-item" href="{{ route('associar-professor') }}"><i class="fa fa-plus"
                                    aria-hidden="true"></i> Associar Professor</a></li>
                    @endcan
                    <li><a class="menu-item" href="{{ route('professorPorTurma') }}"><i class="fa fa-eye"
                                aria-hidden="true"></i>
                            Professor por Turma</a></li>

                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="fas fa-graduation-cap mr-1"></i><span class="menu-title"
                        data-i18n="Chartjs">Turmas</span></a>
                <ul class="menu-content">
                    @can('admin_superintendente')
                        <li><a class="menu-item" href="{{ route('turma.create') }}"><i class="fas fa-chalkboard"></i>
                                Nova turma</a></li>
                    @endcan

                    <li><a class="menu-item" href="{{ route('turmas') }}"><i class="fa fa-eye"
                                aria-hidden="true"></i>
                            Visualizar</a></li>
                </ul>
            </li>
            @can('is_admin')
                <li class=" nav-item"><a href="#"><i class="fas fa-file mr-1"></i><span class="menu-title"
                            data-i18n="Chartjs">Relatórios</span></a>
                    <ul class="menu-content">
                        <li>
                            <a href="{{ route('alunos.relatorio') }}">
                                <i class="fas fa-chalkboard"></i> Alunos Por Turma
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('relatorio.geral.index') }}">
                                <i class="fas fa-chart-bar"></i> Relatório Geral
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            <li>
                <a href="{{ route('quiz.index') }}">
                    <i class="fas fa-pencil-ruler mr-1"></i></i><span class="menu-title">Quizzes</span> </a>
            </li>
            <li>
                <a href="{{ route('gamiicacao') }}">
                    <i class="fas fa-gamepad mr-1"></i><span class="menu-title">Gameficação</span> </a>
            </li>
        </ul>
    </div>
</div>
