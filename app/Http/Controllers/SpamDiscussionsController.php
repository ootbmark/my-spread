<?php

namespace App\Http\Controllers;

use App\Models\ThreadSpam;
use Illuminate\Http\Request;

class SpamDiscussionsController extends Controller
{
    function index(Request $request)
    {
        $threads = ThreadSpam::with('group')->orderBy('created_at', 'desc')->paginate(20);
        return view('spam-discussion.view', compact('threads'));
    }
    function view(Request $request, $id)
    {
        $threads = ThreadSpam::find($id);
        return view('spam-discussion.spam_view', compact('threads'));
    }
}
