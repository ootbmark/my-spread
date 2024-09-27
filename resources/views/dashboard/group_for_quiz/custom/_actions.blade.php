<span style="overflow: visible; position: relative; width: 110px;">
     {{--<a href="{{route('instructors.show', $instructor->id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Show Details">--}}
        {{--<i class="flaticon-eye"></i>--}}
     {{--</a>--}}
    <a href="{{route('groups-for-quiz.edit', $group->id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{__('Edit details')}}">
          <i class="flaticon-edit"></i>
    </a>
    <form action="{{route('groups-for-quiz.destroy', $group->id)}}" method="POST" style="display: none" onsubmit="return confirm('Are You Sure?')">
        @csrf
        @method('DELETE')
    </form>
    <a href="#" onclick="$(this).prev().submit()" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="{{__('Delete')}}">
         <i class="flaticon2-trash"></i>
    </a>
</span>
