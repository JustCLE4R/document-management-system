
var ctx = document.getElementById("pie-chart").getContext("2d");
var myPolarChart = new Chart(ctx, {
    type: "polarArea",
    data: {
        labels: ["Sudah Mengisi", "Belum Mengisi", "Golput"],
        datasets: [
            {
                backgroundColor: [
                    "rgb(10, 83, 10)",
                    "rgba(14, 153, 7, 0.919)",
                    "green",
                ],
                data: [141, 253, 189],
            },
        ],
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
        },
    },
});

