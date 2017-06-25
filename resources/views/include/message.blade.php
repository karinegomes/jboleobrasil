@if(session('message'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        </div>
    </div>
@endif