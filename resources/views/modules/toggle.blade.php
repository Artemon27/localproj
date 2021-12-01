<div class="toggle-form" route ='{{ route('admin.'.\Str::plural(strtolower(class_basename($model))).'.toggle', $model->id) }}'>
    <div class="toggle-value d-none" value="{{(int)(!$model->getAttribute($toggle))}}"></div>
    <div class="toggle-field d-none" value="{{$toggle}}"></div>
    <a class="btn btn-{{$model->getAttribute($toggle) ? 'success' : 'danger'}} btn-xs"
       data-loading-text="..." title="{{@$title}}">
        <i class="fa fa-{{$model->getAttribute($toggle) ? 'check' : 'times'}}"></i>
    </a>
</div>  
@once
    @push('css')
    <link rel="stylesheet" href="{{ asset('js/plugins/toastr/toastr.css') }}">
    @endpush

    @push('js')
    <script src="{{ asset('js/toggle-div.js') }}"></script>
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    @endpush
@endonce