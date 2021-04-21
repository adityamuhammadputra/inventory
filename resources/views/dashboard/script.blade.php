@push('scripts')
<link href="https://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.css" rel="stylesheet">
<style>
    .fc-ltr .fc-basic-view .fc-day-number {
        text-align: center;
        font-size: 18px;
        top: 13px;
        position: relative;
    }

    #calendar tr, #calendar td, #calendar th, #calendar thead, #calendar tbody {
        border: 1px solid transparent;
    }

    .fc-sun, .fc-sat {
        color: #ef6262;
    }

    .fc-left>h2 {
        font-size: 18px;
        position: relative;
        top: 5px;
    }
    .fc-unthemed .fc-today {
        background: #eaf3ff;
    }
    .fc-toolbar {
        margin-bottom: 25px;
    }
    .fc-widget-header thead>tr{
        background: #eaf3ff;
        height: 20px;
    }

    .fc-widget-header thead>tr>th{
        padding: 8px;
    }
</style>
<script>
    $(function() {
        var ctx = document.getElementById('chartjs-dashboard-line').getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, 'rgba(215, 227, 244, 1)');
        gradient.addColorStop(1, 'rgba(215, 227, 244, 0)');
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales ($)",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: [
                        2115,
                        1562,
                        1584,
                        1892,
                        1587,
                        1923,
                        2566,
                        2448,
                        2805,
                        3438,
                        2917,
                        3327
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 1000
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });
    });



</script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
<script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script>

$(function() {

    $('#calendar').fullCalendar({
        height: 450,
        // aspectRatio: 2,
    // put your options and callbacks here
    })
});
</script>
@endpush
