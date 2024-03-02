<script>
    var survey_id;

    function setvalue(id) {
        $('.js-swal-info').val(id)
        survey_id = $('.js-swal-info').val()
        // return survey_id
        console.log(this.survey_id)
    }!(function() {
        // var surveuy_id = $('.js-swal-info').attr('class');
        // var surveuy_id = $('.js-swal-info').val();


        function n(n, e) {
            for (var t = 0; t < e.length; t++) {
                var i = e[t];
                (i.enumerable = i.enumerable || !1), (i.configurable = !0), "value" in i && (i.writable = !0),
                    Object.defineProperty(n, i.key, i);
            }
        }
        var e = (function() {
            function e() {
                !(function(n, e) {
                    if (!(n instanceof e)) throw new TypeError("Cannot call a class as a function");
                })(this, e);
            }
            var t, i;
            return (
                (t = e),
                (i = [{
                        key: "sweetAlert2",
                        value: function() {
                            var n = Swal.mixin({
                                buttonsStyling: !1,
                                customClass: {
                                    confirmButton: "btn btn-success m-1",
                                    cancelButton: "btn btn-danger m-1",
                                    input: "form-control"
                                }
                            });
                            jQuery(".js-swal-simple").on("click", function(e) {
                                    n.fire("Hi, this is just a simple message!");
                                }),
                                jQuery(".js-swal-success").on("click", function(e) {
                                    n.fire("Success", "Everything was updated perfectly!",
                                        "success");
                                }),
                                jQuery(".js-swal-info").on("click", function(e) {
                                    // $('.js-swal-info').val(id)
                                    var survey_id = $(this).attr('id');
                                    url = '{!! route('view_log') !!}'
                                    $.ajax({
                                        url: url,
                                        dataType: "json",
                                        type: 'POST',
                                        data: {
                                            "_token": "{{ csrf_token() }}",
                                            "log_id": survey_id,

                                        },
                                        success: function(data) {
                                            var result = data.result
                                            var output = '';

                                            output +=
                                                '<p> <strong>old Data : </strong> ' +
                                                result['old_data'] +
                                                ' </p> ';
                                            output +=
                                                '<p> <strong>New Data : </strong> ' +
                                                result['new_data'] +
                                                ' </p> ';



                                            n.fire('Survey #' + result['id'] +
                                                ' ', output, "info");
                                            console.log(data);
                                        }
                                    });
                                }),
                                jQuery(".js-swal-warning").on("click", function(e) {
                                    n.fire("Warning", "Something needs your attention!",
                                        "warning");
                                }),
                                jQuery(".js-swal-error").on("click", function(e) {
                                    n.fire("Oops...", "Something went wrong!", "error");
                                }),
                                jQuery(".js-swal-question").on("click", function(e) {
                                    n.fire("Question", "Are you sure about that?",
                                        "question");
                                }),
                                jQuery(".js-swal-confirm").on("click", function(e) {
                                    n.fire({
                                        title: "Are you sure?",
                                        text: "You will not be able to recover this imaginary file!",
                                        icon: "warning",
                                        showCancelButton: !0,
                                        customClass: {
                                            confirmButton: "btn btn-danger m-1",
                                            cancelButton: "btn btn-secondary m-1"
                                        },
                                        confirmButtonText: "Yes, delete it!",
                                        html: !1,
                                        preConfirm: function(n) {
                                            return new Promise(function(n) {
                                                setTimeout(function() {
                                                    n();
                                                }, 50);
                                            });
                                        },
                                    }).then(function(e) {
                                        e.value ? n.fire("Deleted!",
                                                "Your imaginary file has been deleted.",
                                                "success") : "cancel" === e
                                            .dismiss && n.fire("Cancelled",
                                                "Your imaginary file is safe :)",
                                                "error");
                                    });
                                }),
                                jQuery(".js-swal-custom-position").on("click", function(e) {
                                    n.fire({
                                        position: "top-end",
                                        title: "Perfect!",
                                        text: "Nice Position!",
                                        icon: "success"
                                    });
                                });
                        },
                    },
                    {
                        key: "init",
                        value: function() {
                            this.sweetAlert2();
                        },
                    },
                ]),
                null && n(t.prototype, null),
                i && n(t, i),
                e
            );
        })();
        jQuery(function() {
            e.init();
        });
    })();
</script>
