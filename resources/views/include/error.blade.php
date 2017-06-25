@if(session('error'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-lightred">
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif