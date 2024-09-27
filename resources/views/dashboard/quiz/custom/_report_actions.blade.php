<span style="overflow: visible; position: relative; width: 110px;">
    <a href="{{ route('quiz.report', $quiz_report->id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md"
            title="{{ __('Show Details') }}">
        <i class="flaticon-eye"></i>
    </a>
    <a href="{{route('quiz-answer.edit', $quiz_report->id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" target="_blank" title="{{__('Edit')}}">
        <i class="flaticon-edit"></i>
    </a>

    <form action="{{route('quiz.report.destroy', $quiz_report->id)}}" method="POST" style="display: none"
            onsubmit="return confirm('Are You Sure?')">
        @csrf
        @method('DELETE')
    </form>
    <a href="#" onclick="$(this).prev().submit();return false" class="btn btn-sm btn-clean btn-icon btn-icon-md"
            title="{{__('Delete')}}">
        <i class="flaticon2-trash"></i>
    </a>
</span>
