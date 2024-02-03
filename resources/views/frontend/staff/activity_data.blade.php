@foreach ($activityDates as $key => $items)
@php
    $utcDate = convertDateTimeZoneUTCToDubai($key);
    $dateHeading = $utcDate->format('d M, Y');
@endphp
    <div class="activity-day">        
        <h5 class="activity-date" data-id="{{ $dateHeading  }}">{{ $dateHeading  }}</h5>
        <ul>
        <?php foreach ($items as $value) {  ?>
            <li>
                <div class="activity-list">
                    <span class="activity-icon">
                        <picture>
                            <img  src="{{ asset('assets/images/staff-member.svg')}}" alt="dashboard" width="" height="">
                        </picture>                    
                    </span>
                    <span class="activity-name">{{ $value['description'] ?? ''}}</span>
                </div>
                @php
                    $timeRemoveAMPM = str_replace(['am','pm'],"",$value['created_at']);
                    // $time = date('H:i A', strtotime($timeRemoveAMPM));                    
                    $utcDate = convertDateTimeZoneUTCToDubai($timeRemoveAMPM);
                    $time = $utcDate->format('h:i A');
                @endphp
                <div class="activity-time">{{ $time }}</div>
            </li>
        <?php  } ?>
        </ul>
    </div>
@endforeach 