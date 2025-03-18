$(document).ready(function () {
    "use strict";

    if (!$.fn.DataTable) {
        console.error("DataTables library is not loaded.");
        return;
    }

    // Basic Datatable
    $("#basic-datatable").DataTable({
        keys: true,
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Datatable with Buttons
    var datatableButtons = $("#datatable-buttons").DataTable({
        lengthChange: false,
        buttons: ["copy", "print"],
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    datatableButtons.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");

    // Selection Datatable
    $("#selection-datatable").DataTable({
        select: {
            style: "multi"
        },
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Alternative Pagination
    $("#alternative-page-datatable").DataTable({
        pagingType: "full_numbers",
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Scroll Vertical
    $("#scroll-vertical-datatable").DataTable({
        scrollY: "350px",
        scrollCollapse: true,
        paging: false,
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Scroll Horizontal
    $("#scroll-horizontal-datatable").DataTable({
        scrollX: true,
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Complex Header
    $("#complex-header-datatable").DataTable({
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        columnDefs: [
            { visible: false, targets: -1 }
        ]
    });

    // Row Callback
    $("#row-callback-datatable").DataTable({
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        },
        createdRow: function (row, data, dataIndex) {
            if (parseFloat(data[5].replace(/[\$,]/g, "")) > 150000) {
                $("td", row).eq(5).addClass("text-danger");
            }
        }
    });

    // State Saving
    $("#state-saving-datatable").DataTable({
        stateSave: true,
        language: {
            paginate: {
                previous: "<i class='ri-arrow-left-s-line'></i>",
                next: "<i class='ri-arrow-right-s-line'></i>"
            }
        },
        drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
        }
    });

    // Fixed Columns Datatable
    $("#fixed-columns-datatable").DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: true
    });

    // Fixed Header Datatable
    document.addEventListener("DOMContentLoaded", function () {
        let table = document.getElementById("fixed-header-datatable");

        if (table) {
            $('#fixed-header-datatable').DataTable({
                responsive: true,
                fixedHeader: true
            });
        }
    });

    // Apply Bootstrap styles to DataTable elements
    $(".dataTables_length select").addClass("form-select form-select-sm");
    $(".dataTables_length label").addClass("form-label");
});
