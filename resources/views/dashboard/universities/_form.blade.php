<div class="row">
    <div class="col-md-12 col-12">
        <div class="form-group">
            <label for="name">University name<span class="text-red ml-1">*</span></label>
            <input type="text" class="form-control" id="name" placeholder="University name" name="name" value="{{$university->name ?? old('name') }}">
            @error('name')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
    </div>
</div>
