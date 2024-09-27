<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .page-break {
            page-break-after: always;
        }

    </style>
</head>
<body>

@foreach($quizzes as $key => $quiz)
    <table align="center" width="100%" style="">
        <thead>

        </thead>
        <tbody bgcolor="silver">

        @php
            $in = 0;

            $p = 0;

            $r = 0;

            $i = 0;
            foreach ($quiz->quiz_reports as $report){
                if ($report->report_status || $report->report_status === 0){
                    $status = '';
                    if (isset(config()->get('report_status')[$report->report_status]))$status = config()->get('report_status')[$report->report_status];
                    if ($status == "In Progress") {
                        $in++;
                    }
                    if ($status == "Pending"){
                        $p++;
                    }

                    if ($status == "Rejected"){
                        $r++;
                    }

                    if ($status == "Implemented"){
                        $i++;
                    }
                }
            }
        @endphp
        <tr><td></td></tr>
        <tr>
            <td height="25" width="5" align="center" style="border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $in }}</td>
            <td colspan="3" align="center" style="font-size: 16px;text-align: left;background-color: #ffffff">IN PROGRESS (IP) .. We're working on a solution</td>
            <td></td>
            <td colspan="4" align="center" height="35" style="border: 2px solid #666666; font-size: 20px; font-weight: bold;text-align: center;">
                {{ $quiz->title ?? '' }}
            </td>
        </tr>
        <tr>
            <td height="25" align="center" width="5" style="text-align: center; background-color: #FFD579; border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $p }}</td>
            <td colspan="3" align="center" style="font-size: 16px;text-align: left;background-color: #ffffff">PENDING (Pend) .. We know what to do, just didn't do it yet</td>
        </tr>
        <tr>
            <td height="25" width="5" align="center" style="text-align: center;background-color: #FF7E79; border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $r }}</td>
            <td colspan="3" align="center" style="font-size: 16px;text-align: left;background-color: #ffffff">REJECTED (Rej) .. And reason  given in the Journal column</td>
            <td></td>
            <td align="center" style="font-size: 16px; text-align: center;border: 1px solid #000000;">
                No.
            </td>
        </tr>
        <tr>
            <td height="25" align="center" width="5" style="text-align: center;background-color: #92D050; border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $i }}</td>
            <td colspan="3" align="center" style="font-size: 16px;text-align: left;background-color: #ffffff">IMPLEMENTED (Impl) .. Completely closed out</td>
            <td></td>
            <td align="center" style="font-size: 16px; text-align: center;border: 1px solid #000000;">
                {{ count($quiz->quiz_reports) }}
            </td>
        </tr>
        <tr><td></td></tr>
        @php
            $count = 0;
            $current_count = 0;
            $groups = $quiz->groups->pluck('name', 'id');
            $group = 0;
        @endphp
        <tr>
            <td></td>
            <td></td>
            @if(!$quiz->questions->isEmpty())
                <td colspan="{{$quiz->questions->count()}}" style="border: 1px solid #000000; color: #16365b; font-size: 13px; font-style: italic; font-weight: bold; text-align: center;vertical-align: center; background-color: #dddddd">Questions</td>
            @endif
            <td colspan="3" style="border: 1px solid #000000; color: #16365b; font-size: 13px; font-style: italic; font-weight: bold; text-align: center;vertical-align: center; background-color: #dddddd">Statuses</td>
            <td colspan="6"></td>
            <td colspan="5" style="border: 1px solid #000000; color: #16365b; font-size: 13px; font-style: italic; font-weight: bold; text-align: center;vertical-align: center; background-color: #dddddd">Self-Verification</td>
        </tr>
        <tr>
            <td height="35" width="1"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;background-color: #16365b">No.
            </td>
            <td width="1"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b; ">
                <b>Type</b></td>
            @foreach($quiz->questions as $question)
                <td width="40"
                    style="border: 1px solid #000000; color: #ffffff;text-align: center;  font-weight: bold; background-color: #16365b; ">
                    {{ $question->title ?? '--' }}
                </td>
            @endforeach
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                Value
            </td>
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center;; background-color: #16365b">
                Effort
            </td>
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center;; background-color: #16365b">
                Current Priority
            </td>
            <td width="1"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                Status
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;background-color: #16365b">
                Action Party
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                Focal Point
            </td>
            <td width="1"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                Target Date
            </td>
            <td width="1"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                Lead Business Partner
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                Open
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                {{$quiz->verification_text_1}}
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                {{$quiz->verification_text_2}}
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                {{$quiz->verification_text_3}}
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                {{$quiz->verification_text_4}}
            </td>
            <td width="20"
                style="border: 1px solid #000000; color: #ffffff;text-align: center; background-color: #16365b">
                {{$quiz->verification_text_5}}
            </td>
            {{--            <td width="20"  height="25" style="vertical-align: center; background-color: #16365b; color: #fff">Open</td>--}}
        </tr>


        @foreach($quiz->quiz_reports as $report)

            @if($group !== $report->group_id && $report->group_id!== null)
                @php
                    $group = $report->group_id;
                    $count++;
                    $loopCount = 0;
                    $current_count = $count;
                @endphp
                <tr>
                    <td style="background: #DDDDDD;" colspan="{{count($quiz->questions)+9}}">
                        <b>{{$count}}. {{$groups[$group]}}</b>
                    </td>
                </tr>
            @endif

            <tr>
                @if($report->group_id !== null)

                    <td valign="center" align="center" style="border: 1px solid #000000; ">
                        {{$count}},{{  $loopCount+=1 }}
                    </td>
                @else
                    @php
                        $current_count++;
                    @endphp
                    <td valign="center" align="center" style="border: 1px solid #000000; ">
                        {{$current_count ?? '--'}}
                    </td>
                @endisset
                <td width="1" style="border: 1px solid #000000; "></td>
                @foreach($quiz->questions as $question)
                    @php
                        $txt = '';
                        $txtC = '';
                    @endphp

                    @foreach($report->quiz_answers as $quiz_answer)

                        @php

                            if ($quiz_answer->question_id == $question->id){
                                if ($quiz_answer->answer){
                                    $txt .= "{$quiz_answer->answer->title} \n";
                                }else{
                                    $txt .= "{$quiz_answer->text}";
                                }

                            }
                            if ($question->type === 'circling'){
                                if ($quiz_answer->question_id == $question->id){

                                    foreach ($quiz_answer->answers as $key => $item){
                                        if (count($quiz_answer->answers) === 1){
                                            $txtC .= "{$item->title}: ";
                                        }else{
                                            if (!$key) {
                                                $txtC .= "<b>{$item->title}</b>";
                                            }else if ($key == count($quiz_answer->answers)-1) {
                                                $txtC .= " / <b>{$item->title}:</b> ";
                                            }else{
                                                $txtC .= " / <b>{$item->title}</b> ";
                                            }
                                        }
                                    }

                                    $txtC .= $quiz_answer->text;

                                }
                            }

                        @endphp

                    @endforeach

                    <td height="25" width="40"
                        style="vertical-align: center;border: 1px solid #000000; white-space: inherit">
                        @if($question->type === 'circling')
                            {!! $txtC ?? '--' !!}
                        @else
                            {!! $txt ?? '--' !!}
                        @endif
                    </td>
                @endforeach

                <td width="10" height="25" valign="center" align="center"
                    style="vertical-align: center; border: 1px solid #000000;

                    @if($report->status == 'MEDIUM' || $report->status == 'medium') background-color: #FFD579;
                    @elseif($report->status == 'HIGH' || $report->status == 'high') background-color: #FF7E79;
                    @elseif($report->status == 'LOW' || $report->status == 'low') background-color: #92D050;
                    @endif
                        ">
                    {{ !empty($report->status) ? strtoupper(substr($report->status, 0, 1)) : '--' }}
                </td>
                <td width="1" height="25" valign="center" align="center"
                    style="vertical-align: center; border: 1px solid #000000;

                    @if($report->status_effort == 'MEDIUM' || $report->status_effort == 'medium') background-color: #FFD579;
                    @elseif($report->status_effort == 'HIGH' || $report->status_effort == 'high') background-color: #FF7E79;
                    @elseif($report->status_effort == 'LOW' || $report->status_effort == 'low') background-color: #92D050;
                    @endif
                        ">
                    {{ !empty($report->status_effort) ? strtoupper(substr($report->status_effort, 0, 1)) : '--' }}
                </td>
                <td width="1" height="25" valign="center" align="center"
                    style="vertical-align: center; border: 1px solid #000000;

                    @if(strtolower($report->priority) == 'medium') background-color: #FFD579;
                    @elseif(strtolower($report->priority) == 'high') background-color: #FF7E79;
                    @elseif(strtolower($report->priority) == 'low') background-color: #92D050;
                    @endif
                        ">
                    {{ !empty($report->priority) ? strtoupper(substr($report->priority, 0, 1)) : '--' }}
                </td>
                <td width="1" align="center" height="25" style="border: 1px solid #000000; @if($report->report_status || $report->report_status === 0)
                @if(config()->get('report_status')[$report->report_status] == 'Pending') background-color: #FFD579;
                @elseif(config()->get('report_status')[$report->report_status] == 'Rejected') background-color: #FF7E79;
                @elseif(config()->get('report_status')[$report->report_status] == 'Implemented') background-color: #92D050;
                @endif
                @endif
                    ">
                    @if($report->report_status || $report->report_status === 0)
                        {{ config()->get('report_status')[$report->report_status] }}
                    @else
                        --
                    @endif
                </td>

                <td width="20" align="center" height="25" style="vertical-align: center; border: 1px solid #000000; ">
                    {{ $report->action_party ?? '--' }}</td>
                <td width="20" align="center" height="25" style="vertical-align: center; border: 1px solid #000000; ">
                    {{ $report->focal_point ?? '--' }}</td>
                <td width="1" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000; "> {{ $report->target_date ?? '--' }}
                </td>
                <td width="1" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000; "> {{ $report->business_partner ?? '--' }}
                </td>
                @php

                    $statusOpen = null;

                    if(is_numeric($report->report_status)){
                        $status = config()->get('report_status')[$report->report_status];

                        if ($status == 'Implemented' || $status == 'Rejected'){
                            $statusOpen = 'No';
                        }else{
                            $statusOpen = 'Yes';
                        }
                    }


                @endphp

                <td width="20" height="25" align="center" style=" border: 1px solid #000000;
                @if($statusOpen)
                @if($statusOpen == 'No')
                    background-color: #FF7E79;
                @else background-color: #92D050;
                @endif
                @endif">
                    {{ $statusOpen  ?? '--' }}
                </td>
                <td width="20" align="center" height="25"
                    style="border: 1px solid #000000;"
                >
                    {{ $report->is_verification_1 ? 'Y' : '' }}
                </td>
                <td width="20" align="center" height="25"
                    style="border: 1px solid #000000;"
                >
                    {{ $report->is_verification_2 ? 'Y' : '' }}
                </td>
                <td width="20" align="center" height="25"
                    style="border: 1px solid #000000;"
                >
                    {{ $report->is_verification_3 ? 'Y' : '' }}
                </td>
                <td width="20" align="center" height="25"
                    style="border: 1px solid #000000;"
                >
                    {{ $report->is_verification_4 ? 'Y' : '' }}
                </td>
                <td width="20" align="center" height="25"
                    style="border: 1px solid #000000;"
                >
                    {{ $report->is_verification_5 ? 'Y' : '' }}
                </td>

            </tr>
        @endforeach

        {{-- <tr>
             <td colspan="3" scope="col" align="center"
                 style="text-align: center; color: #ffffff; background-color: #bebebe;">
                 Priority
             </td>
             <td colspan="3" scope="col" align="center"
                 style="text-align: center; color: #ffffff; background-color: #bebebe;">
                 Priority effort
             </td>

         <tr>
             <td colspan="3" scope="col" align="center"
                 style="text-align: center; color: #ffffff; background-color: #bebebe;">
                 <b>{{ QuizCheckStatus::status($quiz->quiz_reports) ?? '' }}</b>
             </td>
             <td colspan="3" scope="col" align="center"
                 style="text-align: center; color: #ffffff; background-color: #bebebe;">
                 <b> {{ QuizCheckStatus::statusEffort($quiz->quiz_reports) ?? '' }}</b>
             </td>
         </tr>--}}

        </tbody>
    </table>
    <div class="page-break"></div>
@endforeach


</body>
</html>



