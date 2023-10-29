<div class="container my-3">
    @if(session('success_msg'))
        <div class="alert alert-primary text-center">
            <span>{{ session('success_msg') }}</span>
        </div>
    @endif
    @if(session('error_msg'))
        <div class="alert alert-danger text-center">
            <span>{{ session('error_msg') }}</span>
        </div>
    @endif
</div>
