<div class="row">
    <div class="col-md-12 col-12">
        <div class="form-group">
            <label for="name">Organisation name<span class="text-red ml-1">*</span></label>
            <input type="text" class="form-control" id="name" placeholder="Organisation name" name="name" value="{{$organisation->name ?? old('name') }}">
            @error('name')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="short_name">Short name</label>
            <input type="text" class="form-control" id="short_name" placeholder="Short name" name="short_name" value="{{$organisation->short_name ?? old('short_name')}}">
            @error('short_name')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{$organisation->email ?? old('email')}}">
            @error('email')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" value="{{$organisation->phone ?? old('phone')}}">
            @error('phone')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="website">Website</label>
            <input type="text" class="form-control" id="website" placeholder="Website" name="website" value="{{$organisation->website ?? old('website')}}">
            @error('website')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea  class="form-control" id="website" placeholder="Address" name="address">{{$organisation->address ?? old('address')}}</textarea>
            @error('address')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="logo">Logo</label>
            <br>
            <input type="file" name="logo">
            @error('logo')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>

        @if(isset($organisation) && $organisation->getRawOriginal('logo'))
            <div class="form-group">
                <img src="{{$organisation->logo}}" alt="{{$organisation->name}}" width="200px">
            </div>
        @endif

    </div>
</div>
