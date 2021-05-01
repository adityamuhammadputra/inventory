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
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Total"],
                datasets: [
                    {
                        label: "Rental",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: window.theme.primary,
                        data: {{ $data->graphRental }}
                    },
                    {
                        label: "Event",
                        fill: true,
                        backgroundColor: gradient,
                        borderColor: window.theme.danger,
                        data: {{ $data->graphEvent }}
                    }
                ]
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

    var url = '/api/v1/lookup-calendar?' + $('.wrap-filter').serialize();
    $('#calendar').fullCalendar({
        height: 450,
        firstDay: 0,
        events: {
            url: url,
        },
        allDayDefault: true,
        eventRender: function(event, element) {
            // element.html('<span class="badge badge-'+event.color+' pull-right">'+event.title+'</span>');
            element.html('<span class="fc-title" style="position: absolute;top: '+event.top+'px;font-size: 10px; right: '+event.right+'px;color: '+event.color+'">'+event.title+'</span>');
        },
        dayClick: function(date) {
            let url = "/api/v1/lookup-calendar/" + date.format();
            let dateStr = date.toString();
            dateStr = dateStr.substr(0,15);
            dateStr = dateStr.substr(3,15);
            $('.timeline-time').html(dateStr)
            $.ajax({
                url : url,
                type : "GET",
                success: function (data) {
                    // $('.timeline').removeAttr('style')
                    $('.timeline').html(data);
                }
            });

        }
    })
});

$(document).on('click', '.fc-day-number' , function(){
    $('.fc-day-number').css('color', 'unset');
    $(this).css('color', 'rgb(249 140 1)');
})

</script>
@endpush

@push('css')
<style>
    .fc-day-grid-event{
        position:relative;
        width:101%;
        left:-5px;
        height: 0px;
        border: none !important;
        top: 27px;

    }
</style>
@endpush

@push('css')
<style>

    .fc-day-number:hover{
        cursor: pointer;
    }
    ul.timeline {
        list-style-type: none;
        position: relative;
    }
    ul.timeline:before {
        content: ' ';
        background: #d4d9df;
        display: inline-block;
        position: absolute;
        left: 29px;
        width: 2px;
        height: 100%;
        z-index: 400;
    }
    ul.timeline > li {
        margin: 20px 0;
        padding-left: 20px;
    }
    ul.timeline > li:before {
        content: ' ';
        background: white;
        display: inline-block;
        position: absolute;
        border-radius: 50%;
        /* border: 3px solid #f18c09; */
        left: 23px;
        width: 15px;
        height: 15px;
        z-index: 400;
    }

    ul.timeline > li.Rental1:before {
        border: 8px solid #3b7ddd;
    }

    ul.timeline > li.Event1:before {
        border: 8px solid #f98c01;
    }

    ul.timeline > li.Event2:before, ul.timeline > li.Rental2:before{
        border: 8px solid #d0d0d0;
    }

    code.Event1{
        color: #f98c01;
    }

    code.Rental1{
        color: #3b7ddd;
    }
    code.Event2, code.Rental2{
        color: #d0d0d0;
    }


</style>
@endpush

