(function ($) {
    "use strict";

    function Dashboard() {
        this.$body = $("body");
        this.charts = [];
    }

    Dashboard.prototype.initCharts = function () {
        window.Apex = {
            chart: {
                parentHeightOffset: 0,
                toolbar: { show: false },
            },
            grid: {
                padding: { left: 0, right: 0 },
            },
            colors: ["#3e60d5", "#47ad77", "#fa5c7c", "#ffbc00"],
        };

        const e = ["#3e60d5", "#47ad77", "#fa5c7c", "#ffbc00"];

        // if ($("#revenue-chart").length) {
        //     let t = $("#revenue-chart").data("colors");
        //     let revenueChartOptions = {
        //         series: [
        //             { name: "Revenue", data: [440, 505, 414, 526, 227, 413, 201] },
        //             { name: "Sales", data: [320, 258, 368, 458, 201, 365, 389] },
        //             { name: "Profit", data: [320, 458, 369, 520, 180, 369, 160] }
        //         ],
        //         chart: { height: 377, type: "bar" },
        //         plotOptions: { bar: { columnWidth: "60%" } },
        //         stroke: { show: true, width: 2, colors: ["transparent"] },
        //         dataLabels: { enabled: false },
        //         colors: t ? t.split(",") : e,
        //         xaxis: { categories: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"] },
        //         yaxis: { title: { text: "$ (thousands)" } },
        //         legend: { offsetY: 7 },
        //         grid: { padding: { bottom: 20 } },
        //         fill: { opacity: 1 },
        //         tooltip: { y: { formatter: function (e) { return "$ " + e + " thousands"; } } }
        //     };
        //     new ApexCharts(document.querySelector("#revenue-chart"), revenueChartOptions).render();
        // } else {
        //     console.warn("Chart container #revenue-chart not found.");
        // }

        // if ($("#yearly-sales-chart").length) {
        //     let t = $("#yearly-sales-chart").data("colors");
        //     let yearlySalesChartOptions = {
        //         series: [
        //             { name: "Mobile", data: [25, 15, 25, 36, 32, 42, 45] },
        //             { name: "Desktop", data: [20, 10, 20, 31, 27, 37, 40] }
        //         ],
        //         chart: { height: 250, type: "line", toolbar: { show: false } },
        //         colors: t ? t.split(",") : e,
        //         stroke: { curve: "smooth", width: [3, 3] },
        //         markers: { size: 3 },
        //         xaxis: { categories: ["2017", "2018", "2019", "2020", "2021", "2022", "2023"] },
        //         legend: { show: false }
        //     };
        //     new ApexCharts(document.querySelector("#yearly-sales-chart"), yearlySalesChartOptions).render();
        // } else {
        //     console.warn("Chart container #yearly-sales-chart not found.");
        // }

        // if ($("#us-share-chart").length) {
        //     let usShareChartOptions = {
        //         series: [44, 55, 13, 43],
        //         chart: { width: 80, type: "pie" },
        //         legend: { show: false },
        //         colors: ["#1a2942", "#f13c6e", "#3bc0c3", "#d1d7d973"],
        //         labels: ["Team A", "Team B", "Team C", "Team D"]
        //     };
        //     new ApexCharts(document.querySelector("#us-share-chart"), usShareChartOptions).render();
        // } else {
        //     console.warn("Chart container #us-share-chart not found.");
        // }
    };

    Dashboard.prototype.init = function () {
        this.initCharts();
    };

    $(document).ready(function () {
        $(window).on("load", function () {
            let dashboard = new Dashboard();
            dashboard.init();
        });
    });

})(window.jQuery);
