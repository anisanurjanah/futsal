@extends('layout.home')

@section('title', 'Home')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Welcome</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <div class="col-8 p-4">
                                <select id="selectLapangan" class="form-control">
                                    <option value="">Pilih Lapangan</option>
                                    @foreach ($lapangan as $lap)
                                        <option value="{{ $lap->id }}">{{ $lap->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 p-4 mt-3">
                                <!-- THE CALENDAR -->
                                <div id="calendar" class="d-none"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Reservasi di sini</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{ route('reservasi') }}" class="btn btn-primary" onclick="clearReservasiSession()">Reservasi</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script>
    
        $(function () {
            /* initialize the external events
                -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function() {

                    // create an Event Object (https://fullcalendar.io/docs/event-object)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    }

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject)

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0 //  original position after the drag
                    })

                })
            }

            ini_events($('#external-events div.external-event'))
            
            /* initialize the calendar
            -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            // var containerEl = document.getElementById('external-events');
            var checkbox = document.getElementById('drop-remove');
            var calendarEl = document.getElementById('calendar');
            
            // initialize the external events
            // -----------------------------------------------------------------

            // new Draggable(containerEl, {
            //     itemSelector: '.external-event',
            //     eventData: function(eventEl) {
            //         return {
            //             title: eventEl.innerText,
            //             backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue(
            //                 'background-color'),
            //             borderColor: window.getComputedStyle(eventEl, null).getPropertyValue(
            //                 'background-color'),
            //             textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
            //         };
            //     }
            // });

            const allEvents = [
                @foreach ($data as $item)
                    {
                        lapangan_id: '{{ $item->lapangan_id }}',
                        title: '{{ $item->lapangan->name }}',
                        start: '{{ \Carbon\Carbon::parse($item->tanggal . " " . $item->waktu_mulai)->format("Y-m-d\TH:i:s") }}',
                        end: '{{ \Carbon\Carbon::parse($item->tanggal . " " . $item->waktu_selesai)->format("Y-m-d\TH:i:s") }}',
                        backgroundColor: '#3c8dbc', //Primary (light-blue)
                        borderColor: '#3c8dbc'
                    }@if (!$loop->last),@endif
                @endforeach
            ];

            calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'id',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'bootstrap',
                //Random default events
                events: [],
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(info) {
                    // is the "remove after drop" checkbox checked?
                    if (checkbox && checkbox.checked) {
                        // if so, remove the element from the "Draggable Events" list
                        info.draggedEl.parentNode.removeChild(info.draggedEl);
                    }
                },
                dateClick: function(info) {
                    const lapanganId = $('#selectLapangan').val();

                    sessionStorage.setItem('tanggalReservasi', info.dateStr);
                    sessionStorage.setItem('lapanganId', lapanganId);
                    
                    window.location.href = '/reservasi';
                }
            });

            calendar.render();
            // $('#calendar').fullCalendar()

            $('#selectLapangan').on('change', function() {
                const lapanganId = $(this).val();
                if (!lapanganId) {
                    $('#calendar').addClass('d-none');
                    return;
                }

                $('#calendar').removeClass('d-none').fadeIn(300, function() {
                    calendar.render();
                });

                calendar.removeAllEvents();

                const filteredEvents = allEvents.filter(e => e.lapangan_id === lapanganId);
                filteredEvents.forEach(e => calendar.addEvent(e));
            })
                
            /* ADDING EVENTS */
            var currColor = '#3c8dbc' //Red by default
            // Color chooser button
            $('#color-chooser > li > a').click(function(e) {
                e.preventDefault()
                // Save color
                currColor = $(this).css('color')
                // Add color effect to button
                $('#add-new-event').css({
                    'background-color': currColor,
                    'border-color': currColor
                })
            })
            $('#add-new-event').click(function(e) {
                e.preventDefault()
                // Get value and make sure it is not null
                var val = $('#new-event').val()
                if (val.length == 0) {
                    return
                }

                // Create events
                var event = $('<div />')
                event.css({
                    'background-color': currColor,
                    'border-color': currColor,
                    'color': '#fff'
                }).addClass('external-event')
                event.text(val)
                $('#external-events').prepend(event)

                // Add draggable funtionality
                ini_events(event)

                // Remove event from text input
                $('#new-event').val('')
            })
        })
    </script>
    <script>
        function clearReservasiSession() {
            sessionStorage.removeItem('tanggalReservasi');
            sessionStorage.removeItem('lapanganId');
        }
    </script>
    <script>
        @if (session('add_gagal'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        @endif
    </script>
@endsection
