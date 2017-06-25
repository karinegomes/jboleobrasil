@push('styles')
<link rel="stylesheet" href="{{ asset('js/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/mask/jquery.mask.js') }}"></script>

<script type="text/javascript">
    $('.date').datetimepicker({
        format: 'DD/MM/YYYY',
        showTodayButton: true
    });

    $('#valor, #agrosd, #silas, #dayane').mask("#.##0,00", {reverse: true});
</script>
@endpush