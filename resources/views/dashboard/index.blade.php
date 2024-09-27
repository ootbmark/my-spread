@extends('layouts.app')
@section('add-css')
    <link href="/css/crop.css" rel="stylesheet">
    <link href="{{ mix('css/profile.css') }}" rel="stylesheet">
@endsection
@section('content')

    @include('profile._sidebar')

    <div class="profile-content">
        <ul class="nav mb-3 profile-nav-tab">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('dashboard.users.index')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Organisations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Discussions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Answers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Groups</a>
            </li>
        </ul>


        <div class="discussions-container ml-0 mt-4">
            <form action="">
                <div class="select2-w-100 mb-4">
                    <select name="" id="choose-user">
                        <option value="">Choose type a  user</option>
                        <option value="new">NOT IN THE LIST</option>
                    </select>
                </div>


                <div class="d-flex justify-content-between">
                    <select name="" class="form-control flex-grow-1 w-auto mr-4">
                        <option value="">Choose type a  user</option>
                        <option value="new">NOT IN THE LIST</option>
                    </select>

                    <select name="" class="form-control w-auto">
                        <option value="">Choose filter</option>
                        <option value="">lorem</option>
                    </select>
                </div>
                <br>


                <div class="discussions-search position-relative">
                    <input type="search" placeholder="Organisation name" name="search" aria-label="search" class="form-control">
                    <button type="submit" aria-label="search" class="btn"><span class="search-toggle"></span></button>
                </div>
                <br>


                <div class="d-flex justify-content-between align-items-center">
                    <div class="discussions-search position-relative flex-grow-1 mr-4">
                        <input type="search" placeholder="Organisation name" name="search" aria-label="search" class="form-control">
                        <button type="submit" aria-label="search" class="btn"><span class="search-toggle"></span></button>
                    </div>
                    <a href="#" class="btn my-btn">Add organisations</a>
                </div>
            </form>

            <div class="table-responsive mt-5 discussions-table">
                <table class="table">
                    <tbody><tr>
                        <th class="border-0"><a href="#">ID</a></th>
                        <th class="border-0"><a href="#">Name</a></th>
                        <th class="border-0"><a href="#">JOINED DATE</a></th>
                        <th class="border-0">status</th>
                        <th class="border-0">WEBSITE</th>
                        <th class="border-0">NUMBER  OF MEMBERS</th>
                        <th class="border-0">Logo</th>
                        <th class="border-0">ACTION</th>
                    </tr>
                    <tr>
                        <td><a href="#">5173</a></td>
                        <td><a href="#">Nehal Gajjar</a></td>
                        <td>20 /01/2005</td>
                        <td>Active</td>
                        <td>rp-squared.com</td>
                        <td>5</td>
                        <td class="td-logo"><img src="/img/rp2_logo2.png" alt=""></td>
                        <td class="action-buttons">
                            <a href="#" class="action-link action-link-blue" title="View"><i class="fa fa-eye"></i></a>
                            <a href="#" class="action-link action-link-green" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="action-link action-link-red" title="Remove"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="#">5173</a></td>
                        <td><a href="#">Nehal Gajjar</a></td>
                        <td>20 /01/2005</td>
                        <td>Active</td>
                        <td>rp-squaresquaredd.com</td>
                        <td>5</td>
                        <td class="td-logo"><img src="/img/drillers-logo.png" alt=""></td>
                        <td class="action-buttons">
                            <a href="#" class="action-link action-link-blue" title="View"><i class="fa fa-eye"></i></a>
                            <a href="#" class="action-link action-link-green" title="Edit"><i class="fa fa-pencil"></i></a>
                            <a href="#" class="action-link action-link-red" title="Remove"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @include('profile._avatar_scripts')
@endsection
