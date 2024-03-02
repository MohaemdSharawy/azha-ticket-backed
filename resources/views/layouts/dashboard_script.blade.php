{{-- @php
    $h_code = [];
    // $h_code = '';
    foreach ($hotels as $hotel) {
        array_push($h_code, $hotel->code);
        // $h_code .= $hotel->code . ',';
    }
    // $code = json_encode($h_code);
    // dd($h_code);
@endphp --}}
<script type="">


    var codez = "{{$h_code}}"
    var adminz = "{{$admin_request}}"
    var guestz = "{{$guest_request}}"

    var json_code =  codez.replaceAll('&quot;','"')
    var json_admin =  adminz.replaceAll('&quot;','"')
    var json_guest =  guestz.replaceAll('&quot;','"')
    var code = JSON.parse(json_code);
    var admin = JSON.parse(json_admin);
    var guest = JSON.parse(json_guest);

    !(function() {
        // var hotels =
        function r(r, a) {
            for (var e = 0; e < a.length; e++) {
                var t = a[e];
                (t.enumerable = t.enumerable || !1), (t.configurable = !0), "value" in t && (t.writable = !0),
                    Object.defineProperty(r, t.key, t);
            }
        }
        var a = (function() {
            function a() {
                !(function(r, a) {
                    if (!(r instanceof a)) throw new TypeError("Cannot call a class as a function");
                })(this, a);
            }
            var e, t;
            return (
                (e = a),
                (t = [{
                        key: "initCharts",
                        value: function() {
                            (Chart.defaults.global.defaultFontColor = "#495057"),
                            (Chart.defaults.scale.gridLines.color = "transparent"),
                            (Chart.defaults.scale.gridLines.zeroLineColor = "transparent"),
                            (Chart.defaults.scale.ticks.beginAtZero = !0),
                            (Chart.defaults.global.elements.line.borderWidth = 0),
                            (Chart.defaults.global.elements.point.radius = 0),
                            (Chart.defaults.global.elements.point.hoverRadius = 0),
                            (Chart.defaults.global.tooltips.cornerRadius = 3),
                            (Chart.defaults.global.legend.labels.boxWidth = 12);
                            var r,
                                a = jQuery(".js-chartjs-earnings");
                            (r = {
                                labels: code,
                                datasets: [{
                                        label: "Admin Request",
                                        fill: !0,
                                        backgroundColor: "rgba(130, 224, 170)",
                                        borderColor: "transparent",
                                        pointBackgroundColor: "rgba(81, 121, 214, 1)",
                                        pointBorderColor: "#fff",
                                        pointHoverBackgroundColor: "#fff",
                                        pointHoverBorderColor: "rgba(81, 121, 214, 1)",
                                        data: admin,
                                    },
                                    {
                                        label: "Guest Request",
                                        fill: !0,
                                        backgroundColor: "rgba(203, 67, 53 )",
                                        borderColor: "transparent",
                                        pointBackgroundColor: "rgba(81, 121, 214, 1)",
                                        pointBorderColor: "#fff",
                                        pointHoverBackgroundColor: "#fff",
                                        pointHoverBorderColor: "rgba(81, 121, 214, 1)",
                                        data: guest,
                                    },
                                    // {
                                    //     label: "test",
                                    //     fill: !0,
                                    //     backgroundColor: "rgba(241, 196, 15)",
                                    //     borderColor: "transparent",
                                    //     pointBackgroundColor: "rgba(81, 121, 214, 1)",
                                    //     pointBorderColor: "#fff",
                                    //     pointHoverBackgroundColor: "#fff",
                                    //     pointHoverBorderColor: "rgba(81, 121, 214, 1)",
                                    //     data: [1, 1 , 1],
                                    // },
                                ],
                            }),
                            a.length &&
                                new Chart(a, {
                                    type: "bar",
                                    data: r,
                                    options: {
                                        tooltips: {
                                            intersect: !1,
                                            callbacks: {
                                                label: function(r, a) {
                                                    // return a.datasets[r.datasetIndex]
                                                    //     .label + ": $" + r.yLabel;
                                                   return a.datasets[r.datasetIndex]
                                                        .label + " " + r.yLabel;
                                                },
                                            },
                                        },
                                    },
                                });
                        },
                    },
                    {
                        key: "init",
                        value: function() {
                            this.initCharts();
                        },
                    },
                ]),
                null && r(e.prototype, null),
                t && r(e, t),
                a
            );
        })();
        jQuery(function() {
            a.init();
        });
    })();
</script>
