@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fas fa-check-circle"></i> {{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fas fa-exclamation-circle"></i> {{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fas fa-exclamation-triangle"></i> {{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="alert alert-info alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong><i class="fas fa-info-circle"></i> {{ $message }}</strong>
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
