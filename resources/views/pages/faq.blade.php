@extends('layouts.app')
@section('content')
    <h1 class="title-h2 text-center mt-5 mb-4">FAQ</h1>
    <section class="my-container mb-5 bg-white p-4">
        <div class="faq-container">
            <div class="about_list_title">What the name SPREAD stands for?</div>
            <p>SPREAD is the acronym for Sharing Practices Rigorously, Easily Accelerates Delivery.</p>

            <div class="about_list_title">What are the core services provided by SPREAD?</div>
            <ul class="about_list">
                <li>Discussion Groups - an arrangement that categorises the discussions based on their context.</li>
                <li>Discussions - members can post their ideas/queries to be discussed.</li>
                <li>Responses - members can post their comments on various discussions.</li>
                <li>Alert Emails - members will get notifications about recent Discussions/Responses through email.</li>
                <li>Search - helps to find out discussions/ responses by giving some words/phrases.</li>
            </ul>
            <p></p>

            <div class="about_list_title">Why should I join SPREAD?</div>
            <p>SPREAD is the global community of drilling, completion & subsea professionals. It gives you access to a wealth of knowledge that you may not otherwise have had.</p>


            <div class="about_list_title">Discussion Groups</div>
            <p>All the discussions under the forum are organised under various categories known as discussion groups. Some of the groups are further divided into subgroups for a better classification.</p>

            <div class="about_list_title">Discussion</div>
            <p>Members can post their ideas/queries to be discussed in SPREAD. They have to choose the right Group before posting a discussion. A meaningful title and a small brief for the discussion are required. The discussions under a group are displayed in chronological (latest on top). You may see the discussion title, owner of discussion, name of last contributor to a discussion, last contributed date, number of responses received etc.</p>

            <div class="about_list_title">Responses</div>
            <p>Members can contribute their knowledge to any discussions, treated as Responses. Responses can be opted to fall under one of the following categories.</p>
            <ul class="about_list">
                <li>Facts / Objects: Observing the missing facts or Tools may be the key response. </li>
                <li>Context: laying a fingers on a specific factor either missing or not properly taken account of in a context.</li>
                <li>Rules / Objectives: Some special rule of thumb/ heuristic may be found relevant in a solution.</li>
                <li>Inferences: adding a missing link in a possible inference chain changes the situation dramatically.</li>
                <li>Ideas: An entirely new way of looking at the available data (may be successful elsewhere already) may be suggested at times.</li>
                <li>Conclusion: The initiator can provide a summary/ round up of the discussions that have taken place.</li>
                <li>Knowledgebase: highlighting a missing link (recently discovered fact/law) in knowledge base will be critical in certain situations.</li>
                <li>Experience: Recall of a past personal experience of success may provide a solution.</li>
                <li>Others: When none of the above classification suits, classify under this!</li>
            </ul>
            <p>You may see the category name on the top of a response, if present if selected anyone of the above at the time of posting a Response.</p>

            <div class="about_list_title">How do I become a member?</div>
            <p>To become a member you need to @if(Auth::check())register @else<a href="/create-account">register</a> @endif by choosing your organisation from the list of organisations. You have to provide a username, password, email-id and some other basic information. </p>

            <div class="about_list_title">Why for any member an e-mail id is compulsory?</div>
            <p>SPREAD sends alert emails and other messages through email.</p>

            <div class="about_list_title">Why professional/academic email-id is preferred for registration?</div>
            <p>We prefer a professional/academic email-id at the time of registration for greater authenticity to retain the community's reputation.</p>

            <div class="about_list_title">How can I change my email-id at SPREAD?</div>
            <p>Shortly after registration, your account get approved by Admin. After that event, if you so prefer, you may change your email-id to a new one of your choice. This could be done by clicking the Edit profile button from your profile page. </p>

            <div class="about_list_title">How do I retrieve my forgotten username/ password?</div>
            <p>Click on <a href="{{route('password.request')}}">"Forgotten Password"</a> link under the <a href="{{route('login')}}">login form</a> and proceed to get an e-mail from SPREAD containing the instructions to reset your password and thier by login to your profile. </p>

            <div class="about_list_title">How to start a new discussion?</div>
            <p>Click on the my spread logo in the top left corner which will take you to the homepage. From there you can click on the "Start a new discussion" button.
            <div class="article_two_index_body_links"><a href="{{route('discussions.check')}}" class="btn my-btn text-uppercase">Start a new discussion</a></div></p>

            <div class="about_list_title">How do I know if a discussion has been already posted?</div>
            <p>You can make use of the global <a href="{{route('discussions.index')}}">search</a> feature on the top right corner of every page.</p>

        </div>



        <a href="#" id="scroll"><span></span></a>
    </section>
@endsection

