var lodingButton =
    '<button class="btn btn-primary w-100" type="button" disabled><span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> <span class="">Loading...</span></button>';

function formSubmit(formId, url, modalId, dataTable) {
    let submitButton = $(".submitButton").html();
    $.ajax({
        url: url,
        type: "POST",
        data: $("#" + formId).serialize(),
        beforeSend: function () {
            $(".submitButton").html(lodingButton);
        },
        success: function (response) {
            const { status, message, errors } = response;
            if (status == false) {
                if (message) {
                    Swal.fire({
                        icon: "error",
                        title: `${message}`,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                }

                if (errors) {
                    let errorsArr = Object.entries(errors);
                    for (let index = 0; index < errorsArr.length; index++) {
                        $(".error_" + errorsArr[index][0]).html(
                            errorsArr[index][1][0]
                        );
                    }
                }
            }
            if (status == true) {
                Swal.fire({
                    // position: 'top-end',
                    icon: "success",
                    title: `${message}`,
                    showConfirmButton: false,
                    timer: 1500,
                }).then(() => {
                    dataTable.draw();
                    $("#" + formId)[0].reset();
                    $("#" + modalId).modal("hide");
                });
            }
        },
        complete: function (data) {
            $(".submitButton").html(submitButton);
        },
    });
}

function deleteData(url, dataTable) {
    Swal.fire({
        title: "Are you sure?",
        text: "If Deleted, You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // console.log("Deleted");
            $.ajax({
                url: url,
                type: "POST",
                beforeSend: function () {
                    //$(".submitButton").html(lodingButton);
                },
                success: function (response) {
                    const { status, message } = response;
                    if (status == true) {
                        dataTable.draw();
                    }
                    Swal.fire({
                        icon: "success",
                        title: `${message}`,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                },
                complete: function (data) {
                    //$( ".submitButton" ).html(submitButton);
                },
            });
        }
    });
}
