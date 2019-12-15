var getSprintData;

window.onload = function () {
    function burnDownInit() {
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Day');
            data.addColumn('number', 'Sprint');
            data.addColumn('number', 'Planned');

            var sprintData = getSprintData();
            data.addRows(sprintData);

            var options = {
                chart: {
                    title: 'Burn down chart'
                },
                width: 900,
                height: 500
            };

            var chart = new google.charts.Line(document.getElementById('linechart_material'));

            chart.draw(data, google.charts.Line.convertOptions(options));
        }
    }

    getSprintData = function() {
        var sprintDuration = $('#sprintDuration').val(),
            planned = $('#storyPoints').val(),
            interval = planned / sprintDuration,
            data = [];
        data.push([0, parseFloat(planned), parseFloat(planned)]);
        for (let i = 1, ideal = planned - interval; i <= sprintDuration; i++, ideal -= interval) {
            let dayResult = $('#day' + i).val();
            data.push([i, parseFloat(dayResult), parseFloat(ideal)]);
        }
        return data;
    }

    $('#sprintDuration').on('change', function () {
        $('#daysBlock').empty();
        var daysCount = $(this).val();
        $('#daysBlock').append('<h3>Story points left:</h3>');
        for (let i = 1; i <= daysCount; i++) {
            $('#daysBlock').append('' +
                '<label for="day' + i + '">Day ' + i + '</label>\n' +
                '<input type="number" class="form-control col-md-4" id="day' + i + '">');
        }
    });

    $('#burndown').hide();

    $('#calculate').on('click', function () {
        var sprintData = getSprintData();
        burnDownInit(sprintData);
        $('#burnDownForm').hide();
        $('#burndown').show();
    });

    $('#change').on('click', function () {
        $('#burndown').hide();
        $('#burnDownForm').show();
    });
}