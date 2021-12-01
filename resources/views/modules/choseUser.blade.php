<select class="chosen-select form-select ml-2 " name="id">
    @foreach ($users as $selUser)                    
        <option value="{{$selUser->id}}"
                @if ($selUser->id == $user->id)
                selected
                @endif
                >{{$selUser->name}}</option>
    @endforeach  
</select>

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/chosen/chosen.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('vendor/chosen/chosen.jquery.min.js') }}"></script>
<script>
$(".chosen-select").chosen();
</script>
@endpush