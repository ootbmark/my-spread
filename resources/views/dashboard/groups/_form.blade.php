<div class="row">
    <div class="col-md-12 col-12">
        <div class="form-group">
            <label for="name">Group name<span class="text-red ml-1">*</span></label>
            <input type="text" class="form-control" id="name" placeholder="Group name" name="name" value="{{$group->name ?? old('name')}}">
            @error('name')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea  class="form-control" id="description" placeholder="Description" name="description">{{$group->description ?? old('description')}}</textarea>
            @error('description')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="parent_id">Parent group</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Select parent</option>
                @foreach($groups as $item)
                    <option value="{{$item->id}}" @if(isset($group) && $group->parent_id == $item->id) selected @endif>{{$item->name}}</option>
                @endforeach
            </select>
            @error('parent_id')
            <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
            @enderror
        </div>


    </div>
</div>
