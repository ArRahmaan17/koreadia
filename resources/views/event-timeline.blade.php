@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.timeline')
@endsection
@section('css')
@endsection
@section('content')
    <div class="col-lg-12 mt-4">
        <div>
            <h2 class="text-center">{{ $data->name }}</h2>
            <div class="date text-center">
                {{ Carbon\Carbon::parse($data->date)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('l, j F Y') }}</div>
            <div class="timeline mt-2">
                @foreach ($data->agendas as $agenda)
                    <div class="timeline-item @if ($loop->index % 2 == 0) right @else left @endif">
                        <i
                            class="icon @if ($loop->first) ri-play-fill  @elseif($loop->last) ri-flag-fill  @else ri-fire-line @endif"></i>
                        <div class="date text-capitalize">
                            {{ Carbon\Carbon::parse($data->date . ' ' . $agenda->time)->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('h:i A') }}
                        </div>
                        <div class="content">
                            <h5 class="text-capitalize">{{ $agenda->name }} <span
                                    class="badge {{ compareDateEvent($data->date, $agenda->time, $data->agendas[$loop->index + 1]->time ?? null)['class'] }} {{ compareDateEvent($data->date, $agenda->time, $data->agendas[$loop->index + 1]->time ?? null)['color'] }} fs-10 align-middle ms-1">{{ compareDateEvent($data->date, $agenda->time, $data->agendas[$loop->index + 1]->time ?? null)['label'] }}
                                </span>
                            </h5>
                            @if ($agenda->online)
                                <div class="text-muted mb-2">
                                    <div class="col-12">
                                        <div>
                                            <label class="form-label">Topic</label>
                                            <input type="text" class="form-control" value="{{json_decode($agenda->meeting)->topic}}" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <label class="form-label">Id</label>
                                            <input type="text" class="form-control" value="{{json_decode($agenda->meeting)->id}}" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div>
                                            <label class="form-label">Passcode</label>
                                            <input type="text" class="form-control" value="{{json_decode($agenda->meeting)->passcode}}" disabled="">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted mb-2 ms-2">
                                    @lang('translation.location'): {{ $agenda->location }}
                                </p>
                                <p class="text-muted mb-2 ms-2">
                                    @lang('translation.speaker_agenda'):
                                </p>
                                <ul>
                                    @foreach (explode(',', $agenda->speaker) as $speaker)
                                        <li class="text-muted">{{ $speaker }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <a href="javascript:void(0);" class="link-primary text-decoration-underline">Read More <i class="ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
