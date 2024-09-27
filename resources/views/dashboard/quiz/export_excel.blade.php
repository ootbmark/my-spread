<table border="1" align="center" width="100%" style="">
    <thead>
    {{--<tr>
        <td>User Name</td>
        <td>Question > answers</td>
        <td>Time Limit</td>
    </tr>--}}
    </thead>
    <tbody bgcolor="silver">
    @foreach($quizzes as $key => $quiz)


        @php
            $mapping->setQuiz($quiz);

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
        <tr>
            <td></td>
        </tr>
        <tr>
            <td height="25" width="5"
                style="text-align: center;vertical-align: center; border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $in }}</td>
            <td colspan="3" style="font-size: 16px;text-align: left;vertical-align: center;background-color: #ffffff">IN
                PROGRESS (IP) .. We're working on a solution
            </td>
            <td></td>
            <td colspan="4" height="35"
                style="border: 2px solid #666666; font-size: 20px; font-weight: bold;text-align: center;vertical-align: center;">
                {{ $quiz->title ?? '' }}
            </td>
        </tr>
        <tr>
            <td height="25" width="5"
                style="text-align: center;vertical-align: center; background-color: #FFD579; border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $p }}</td>
            <td colspan="3" style="font-size: 16px;text-align: left;vertical-align: center;background-color: #ffffff">
                PENDING (Pend) .. We know what to do, just didn't do it yet
            </td>
        </tr>
        <tr>
            <td height="25" width="5"
                style="text-align: center;vertical-align: center; background-color: #FF7E79; border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $r }}</td>
            <td colspan="3" style="font-size: 16px;text-align: left;vertical-align: center;background-color: #ffffff">
                REJECTED (Rej) .. And reason given in the Journal column
            </td>
            <td></td>
            <td style="font-size: 16px; text-align: center;vertical-align: center;border: 1px solid #000000;">
                No.
            </td>
        </tr>
        <tr>
            <td height="25" width="5"
                style="text-align: center;vertical-align: center; background-color: #92D050; border: 1px solid #000000; font-weight: bold; font-size: 16px">{{ $i }}</td>
            <td colspan="3" style="font-size: 16px;text-align: left;vertical-align: center;background-color: #ffffff">
                IMPLEMENTED (Impl) .. Completely closed out
            </td>
            <td></td>
            <td style="font-size: 16px; text-align: center;vertical-align: center;border: 1px solid #000000;">
                {{ count($quiz->quiz_reports) }}
            </td>
        </tr>
        <tr>
            <td></td>
        </tr>
        @php
            $count = 0;
            $current_count = 0;
            $groups = $quiz->groups->pluck('name', 'id');
            $group = 0;
        @endphp
        <tr>
            <td></td>
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
            <td height="35"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                No.
            </td>
            <td height="35"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                {{$mapping->getTitleForKey('id')}}
            </td>
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                <b>Type</b>
            </td>
            @foreach($quiz->questions as $question)
                <td width="40"
                    style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center;  font-weight: bold; background-color: #16365b">
                    {{$mapping->getTitleForKey($question->id)}}
                </td>
            @endforeach
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                {{$mapping->getTitleForKey('status')}}
            </td>
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                {{$mapping->getTitleForKey('status_effort')}}
            </td>
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b; word-wrap: break-word">
                {{$mapping->getTitleForKey('priority')}}
            </td>
            {{--<td style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                Current Priorit
            </td>--}}
            <td style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                {{$mapping->getTitleForKey('report_status')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                {{$mapping->getTitleForKey('action_party')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                {{$mapping->getTitleForKey('focal_point')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                {{$mapping->getTitleForKey('target_date')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b; word-wrap: break-word">
                {{$mapping->getTitleForKey('business_partner')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b">
                Open
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b; word-wrap: break-word">
                {{$mapping->getTitleForKey('is_verification_1')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b; word-wrap: break-word">
                {{$mapping->getTitleForKey('is_verification_2')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b; word-wrap: break-word">
                {{$mapping->getTitleForKey('is_verification_3')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b; word-wrap: break-word">
                {{$mapping->getTitleForKey('is_verification_4')}}
            </td>
            <td width="40"
                style="border: 1px solid #000000; color: #ffffff;text-align: center;vertical-align: center; background-color: #16365b; word-wrap: break-word">
                {{$mapping->getTitleForKey('is_verification_5')}}
            </td>
            {{--            <td width="20"  height="25" style="vertical-align: center; background-color: #16365b; color: #fff">Open</td>--}}
        </tr>


        @foreach($quiz->quiz_reports as $report)

            @if($group !== $report->group_id && $report->group_id!== null)
                @php
                    $group = $report->group_id;
                    $count++;
                    $current_count = $count;
                    $loopCount = 0;
                @endphp
                <tr>
                    <td style="background: #DDDDDD;" colspan="2">
                        <b>Group</b>
                    </td>
                    <td style="background: #DDDDDD;" colspan="{{count($quiz->questions)+15}}">
                        <b>{{$count}}. {{$groups[$group]}}</b>
                    </td>
                </tr>
            @endif

            <tr>
                @if($report->group_id !== null)

                    <td valign="center" align="center" style="border: 1px solid #000000; ">
                        {{$count .",". $loopCount+=1 }}
                    </td>
                @else
                    @php
                        $current_count++;
                    @endphp
                    <td valign="center" align="center" style="border: 1px solid #000000; ">
                        {{$current_count}}
                    </td>
                @endisset

                <td valign="center" align="center" style="border: 1px solid #000000; ">
                    {{$report->id}}
                </td>
                <td style="border: 1px solid #000000; "></td>

                @foreach($quiz->questions as $question)
                    <td height="25" width="40" align="left"
                        style="vertical-align: center; border: 1px solid #000000; font-weight: inherit">
                        {{$mapping->answersToString($report, $question)}}
                    </td>
                @endforeach

                <td width="10" height="25" valign="center" align="center"
                    style="vertical-align: center;
                        border: 1px solid #000000;
                    @if($report->status == 'MEDIUM' || $report->status == 'medium') background-color: #FFD579;
                    @elseif($report->status == 'HIGH' || $report->status == 'high') background-color: #FF7E79;
                    @elseif($report->status == 'LOW' || $report->status == 'low') background-color: #92D050;
                    @endif
                        ">
                    {{ $mapping->degreeValueToString($report->status) }}
                </td>
                <td width="10" height="25" valign="center" align="center"
                    style="vertical-align: center;
                        border: 1px solid #000000;
                    @if($report->status_effort == 'MEDIUM' || $report->status_effort == 'medium') background-color: #FFD579;
                    @elseif($report->status_effort == 'HIGH' || $report->status_effort == 'high') background-color: #FF7E79;
                    @elseif($report->status_effort == 'LOW' || $report->status_effort == 'low') background-color: #92D050;
                    @endif
                        ">
                    {{ $mapping->degreeValueToString($report->status_effort) }}
                </td>
                <td width="10" height="25" valign="center" align="center"
                    style="vertical-align: center;
                        border: 1px solid #000000;
                    @if(strtolower($report->priority) == 'medium') background-color: #FFD579;
                    @elseif(strtolower($report->priority) == 'high') background-color: #FF7E79;
                    @elseif(strtolower($report->priority) == 'low') background-color: #92D050;
                    @endif
                        ">
                    {{ $mapping->degreeValueToString($report->priority) }}
                </td>

                <td width="20" height="25" valign="center" align="center"
                    style="vertical-align: center;
                        border: 1px solid #000000;
                    @if($report->report_status || $report->report_status === 0)
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

                <td width="20" height="25" style="vertical-align: center; border: 1px solid #000000; ">
                    {{ $report->action_party ?? '--' }}</td>
                <td width="20" height="25" style="vertical-align: center; border: 1px solid #000000; ">
                    {{ $report->focal_point ?? '--' }}</td>
                <td width="20" height="25"
                    style="vertical-align: center; border: 1px solid #000000; "> {{ $report->target_date  ?? '--' }}
                </td>
                <td width="20" height="25"
                    style="vertical-align: center; border: 1px solid #000000; "> {{ $report->business_partner  ?? '--' }}
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

                <td width="20" valign="center" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000;
                    @if($statusOpen)
                    @if($statusOpen == 'No')
                        background-color: #FF7E79;
                    @else background-color: #92D050;
                    @endif
                    @endif"
                >
                    {{ $statusOpen  ?? '--' }}
                </td>
                <td width="20" valign="center" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000;"
                >
                    {{ $mapping->booleanToString($report->is_verification_1) }}
                </td>
                <td width="20" valign="center" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000;"
                >
                    {{ $mapping->booleanToString($report->is_verification_2) }}
                </td>
                <td width="20" valign="center" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000;"
                >
                    {{ $mapping->booleanToString($report->is_verification_3) }}
                </td>
                <td width="20" valign="center" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000;"
                >
                    {{ $mapping->booleanToString($report->is_verification_4) }}
                </td>
                <td width="20" valign="center" align="center" height="25"
                    style="vertical-align: center; border: 1px solid #000000;"
                >
                    {{ $mapping->booleanToString($report->is_verification_5) }}
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
    @endforeach
    </tbody>
</table>

