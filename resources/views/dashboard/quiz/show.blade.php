@extends('dashboard.layouts.app')
@section('content')
    <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Show Page - {{$page->id}}</h4>
                        </div>
                        <div class="card-body">
                        <table class="table card-table">
                            <tbody>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>ID</td>
                                <td class="text-right"><span class="text-muted">{{$page->id}}</span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Title</td>
                                <td class="text-right"><span class="text-muted">{{$page->title}}</span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Slug</td>
                                <td class="text-right"><span class="text-muted">{{$page->slug}}</span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Publish Date</td>
                                <td class="text-right"><span class="text-muted">{{$page->publish_date}}</span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Meta Title</td>
                                <td class="text-right"><span class="text-muted">{{$page->meta_title}} </span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Meta Description</td>
                                <td class="text-right"><span class="text-muted">{{$page->meta_description}} </span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Meta Keywords</td>
                                <td class="text-right"><span class="text-muted">{{$page->meta_keywords}} </span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Created At</td>
                                <td class="text-right"><span class="text-muted">{{$page->created_at}}</span></td>
                            </tr>
                            <tr>
                                <td width="1"><i class="fa fa-align-justify text-muted"></i></td>
                                <td>Updated At</td>
                                <td class="text-right"><span class="text-muted">{{$page->updated_at}}</span></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="card-footer text-right">
                            <div class="d-flex">
                                <a href="#" class="btn btn-link j_return_back">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Image</h3>
                        </div>
                        <div class="card-body">
                            <img src="{{$page->image}}" alt="{{$page->title}}">
                        </div>
                        <div class="card-footer text-right">
                            <div class="d-flex">
                                <a href="#" class="btn btn-link j_return_back">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Content</h3>
                        </div>
                        <div class="card-body">
                            {!! $page->content !!}
                        </div>
                        <div class="card-footer text-right">
                            <div class="d-flex">
                                <a href="#" class="btn btn-link j_return_back">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection

