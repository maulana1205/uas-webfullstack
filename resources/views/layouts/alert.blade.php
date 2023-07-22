@if(session()->has('success'))
<div class="alert alert-success fade show mb-3" role="alert">
    {{session()->get('success')}}
</div>
@endif

@if(session()->has('error'))
<div class="alert alert-danger fade show mb-3" role="alert">
    {{session()->get('error')}}
</div>
@endif