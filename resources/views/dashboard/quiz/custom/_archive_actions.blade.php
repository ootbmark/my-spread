<span style="overflow: visible; position: relative; width: 110px;">
    @if($report->older !== null)
        <span class="btn btn-sm btn-clean btn-icon btn-icon-md show_change_list_modal"
              title="{{ __('Show Details') }}" data-id="{{$report->id}}">
            <i class="flaticon-eye"></i>
        </span>
    @endif
</span>
