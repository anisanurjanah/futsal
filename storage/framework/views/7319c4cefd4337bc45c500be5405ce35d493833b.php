

<?php $__env->startSection('title', 'Home'); ?>

<?php $__env->startSection('content'); ?>

    <section class="content">
        <div class="container-fluid py-3">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <div class="col-12 p-4">
                                <div class="album">
                                    <div class="container">
                                        <h5 class="mb-4">Pilih Lapangan</h5>

                                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                                        <?php $__currentLoopData = $lapangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col">
                                                <label class="d-block bg-body-secondary bg-gradient text-center rounded p-5 lapangan-option">
                                                    <input type="radio" name="lapangan_id" value="<?php echo e($lap->id); ?>" class="form-check-input d-none">
                                                    <h5 class="fw-bold m-0"><?php echo e($lap->name); ?></h5>
                                                </label>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                </div>
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
            <section id="tentang" class="content">
                <div class="container-fluid py-3">
                    <div class="p-4">
                        <div class="row featurette">
                            <div class="col-md-7 order-md-2">
                                <h2 class="featurette-heading fw-normal lh-1 mb-4">Tentang <span class="text-body-secondary">FitPlaza</span></h2>
                                
                                <p class="lead text-justify">
                                    FitPlaza adalah penyedia layanan GOR olahraga modern yang memudahkan siapa pun untuk melakukan reservasi lapangan secara online, cepat, dan transparan. Dari futsal, bulu tangkis, basket, hingga bulu tangkis, kami hadir untuk mendukung gaya hidup aktif dan sehat bagi semua kalangan. Dengan sistem reservasi yang user-friendly dan informasi jadwal yang selalu diperbarui, kami memastikan pengalaman sewa lapangan yang efisien dan tanpa ribet.
                                </p>
                            </div>
                            <div class="col-md-5 order-md-1">
                                <img src="https://images.pexels.com/photos/114296/pexels-photo-114296.jpeg?auto=compress&cs=tinysrgb&h=500&w=500"
                                    alt="Olahraga di FitPlaza"
                                    class="img-fluid rounded shadow"
                                    width="500"
                                    height="500"
                                    loading="lazy">   
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        
            <section id="layanan" class="content">
                <div class="container-fluid py-3">
                    <div class="album p-4">
                        <h2 class="featurette-heading fw-normal lh-1 mb-4 text-center">Layanan Kami</h2>
                        
                        <div class="container">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3 mb-3">
                                 <div class="col">
                                    <div class="card shadow-sm text-center p-4">
                                        <div class="d-flex justify-content-center mb-3">
                                            <i class="bi bi-calendar2-check-fill text-primary" style="font-size: 4rem;"></i>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text mx-4">Reservasi lapangan olahraga seperti futsal, basket, dan bulu tangkis</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card shadow-sm text-center p-4">
                                        <div class="d-flex justify-content-center mb-3">
                                            <i class="bi bi-people-fill text-success" style="font-size: 4rem;"></i>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text mx-4">Peminjaman lapangan untuk kegiatan pribadi, komunitas, atau event olahraga</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3">
                                 <div class="col">
                                    <div class="card shadow-sm text-center p-4">
                                        <div class="d-flex justify-content-center mb-3">
                                            <i class="bi bi-phone-fill text-info" style="font-size: 4rem;"></i>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text mx-4">Reservasi online dengan sistem yang mudah</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card shadow-sm text-center p-4">
                                        <div class="d-flex justify-content-center mb-3">
                                            <i class="bi bi-clock-fill text-warning" style="font-size: 4rem;"></i>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text mx-4">Informasi ketersediaan lapangan secara real-time</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="reservasi" class="content" style="background-color: #0d6efd;">
                <div class="container-fluid py-3 text-white text-center">
                    <div class="p-4">
                        <h2 class="fw-bold mb-3">Siap untuk Bermain?</h2>
                        <p class="lead mb-4">Reservasi lapangan favoritmu sekarang juga dengan mudah dan cepat di FitPlaza!</p>
                        <a href="<?php echo e(route('reservasi')); ?>" onclick="clearReservasiSession()" class="btn btn-light">
                            Mulai Reservasi
                        </a>
                    </div>
                </div>
            </section>
        
            <section id="kontak" class="content">
                <div class="container-fluid py-3">
                    <div class="p-4">
                        <h2 class="featurette-heading fw-normal lh-1 mb-4 text-center">Kontak Kami</h2>
                        
                        <div class="row g-0">
                            <div class="col-md-4">
                                <ul class="list-unstyled fs-5">
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="bi bi-browser-chrome text-primary me-3 fs-4"></i>
                                        <div>
                                            <strong>Website</strong><br>
                                            <span class="text-muted">http://wa.link/c1vivl</span>
                                        </div>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="bi bi-telephone-fill text-success me-3 fs-4"></i>
                                        <div>
                                            <strong>Telepon</strong><br>
                                            <span class="text-muted">0819-1707-3488</span>
                                        </div>
                                    </li>
                                    <li class="mb-3 d-flex align-items-start">
                                        <i class="bi bi-instagram text-danger me-3 fs-4"></i>
                                        <div>
                                            <strong>Instagram</strong><br>
                                            <span class="text-muted">@fitplaza.cilegonpark</span>
                                        </div>
                                    </li>
                                    <li class="d-flex align-items-start">
                                        <i class="bi bi-geo-alt-fill text-danger me-3 fs-4"></i>
                                        <div>
                                            <strong>Alamat</strong><br>
                                            <span class="text-muted">Kalitimbang, Kec. Cibeber, Kota Cilegon, Banten</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-8">
                                <div class="ratio ratio-4x3 rounded shadow-sm">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.574598920231!2d106.0461213!3d-6.0529456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e418f179e8d81e5%3A0x8849aad71b217f89!2sGOR%20Fit%20Plaza!5e0!3m2!1sid!2sid!4v1750130006128!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('script'); ?>
    <script>

        document.querySelectorAll('.lapangan-option input[type="radio"]').forEach(input => {
            input.addEventListener('change', function () {
                document.querySelectorAll('.lapangan-option').forEach(el => {
                    el.classList.remove('border', 'border-primary', 'shadow');
                });

                this.closest('.lapangan-option').classList.add('border', 'border-primary', 'shadow');
            });
        });
    
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
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    {
                        lapangan_id: '<?php echo e($item->lapangan_id); ?>',
                        title: '<?php echo e($item->lapangan->name); ?>',
                        start: '<?php echo e(\Carbon\Carbon::parse($item->tanggal . " " . $item->waktu_mulai)->format("Y-m-d\TH:i:s")); ?>',
                        end: '<?php echo e(\Carbon\Carbon::parse($item->tanggal . " " . $item->waktu_selesai)->format("Y-m-d\TH:i:s")); ?>',
                        backgroundColor: '#3c8dbc', //Primary (light-blue)
                        borderColor: '#3c8dbc'
                    }<?php if(!$loop->last): ?>,<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    const lapanganId = $('input[name="lapangan_id"]:checked').val();

                    sessionStorage.setItem('tanggalReservasi', info.dateStr);
                    sessionStorage.setItem('lapanganId', lapanganId);

                    console.log(lapanganId)
                    
                    window.location.href = '/reservasi';
                }
            });

            calendar.render();
            // $('#calendar').fullCalendar()

            $('input[name="lapangan_id"]').on('change', function () {
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
        <?php if(session('add_gagal')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Jadwal sudah ada',
            });
        <?php endif; ?>
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\futsal\resources\views/home/home.blade.php ENDPATH**/ ?>