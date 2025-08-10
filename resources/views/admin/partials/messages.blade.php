@session('success-message')
    <div class="alert alert-success" role="alert">{{ $value }}</div>
@endsession

@session('error-message')
    <div class="alert alert-danger" role="alert">{{ $value }}</div>
@endsession
