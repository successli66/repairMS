$(function () {
	
    var templatePlugins = function () {

        var tp_clock = function () {

            function tp_clock_time() {
                var now = new Date();
                var hour = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();

                hour = hour < 10 ? '0' + hour : hour;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : minutes;

                $(".plugin-clock").html(hour + "<span>:</span>" + minutes);
            }
            if ($(".plugin-clock").length > 0) {

                tp_clock_time();

                window.setInterval(function () {
                    tp_clock_time();
                }, 2000);

            }
        };

        var tp_date = function () {

            if ($(".plugin-date").length > 0) {

                var days = ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
                var months = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

                var now = new Date();
                var day = days[now.getDay()];
                var date = now.getDate();
                var month = months[now.getMonth()];
                var year = now.getFullYear();

                $(".plugin-date").html(year + "年" + month + "月" + date + "日 " + day);
            }

        };

        return {
            init: function () {
                tp_clock();
                tp_date();
            }
        };
    }();


    templatePlugins.init();

    // New selector case insensivity        
    $.expr[':'].containsi = function (a, i, m) {
        return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
    };
});