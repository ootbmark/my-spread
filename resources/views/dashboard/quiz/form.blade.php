<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-12">
            @include('dashboard.components.form._text', (['name' => 'question']))
        </div>
{{--        <div class="col-lg-6">--}}
{{--            @include('dashboard.components.form._select', (['name' => 'categories', 'data' => $categories, 'selected' => $selected_categories ?? [], 'select_2' => true, 'multiple' => true]))--}}
{{--        </div>--}}
    </div>
    <div class="form-group row">
        <div class="col-lg-12">
            @include('dashboard.components.form._textarea', (['name' => 'answer', 'editor' => true]))
        </div>
    </div>
</div>


