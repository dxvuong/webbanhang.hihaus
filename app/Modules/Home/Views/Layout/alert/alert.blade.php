@if(session()->has('success'))
    <div class="alert alert-success" style="margin: 0 20px;margin-top: 30px;">
        {{ session()->get('success') }}
    </div>
@endif
@if(session()->has('error'))
    <div class="alert alert-danger" style="margin: 0 20px;margin-top: 30px;">
        {{ session()->get('error') }}
    </div>
@endif
@if ($errors->any())
    @foreach ($errors->all() as $error)
        @if(!empty($error))
            <div class="alert alert-danger" style="margin: 0 20px;margin-top: 30px;">
                {{ $error }}
            </div>
        @endif
    @endforeach
@endif