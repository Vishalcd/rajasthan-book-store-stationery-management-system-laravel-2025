import {
    Chart,
    LineController,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    Filler,
} from "chart.js";

Chart.register(
    LineController,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    Filler
);

export default class LineChart {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;

        this.labels = JSON.parse(this.canvas.dataset.labels);
        this.values = JSON.parse(this.canvas.dataset.values);

        // Set fixed height
        this.canvas.style.height = "300px"; // adjust as needed
    }

    render() {
        if (!this.canvas) return;

        new Chart(this.canvas, {
            type: "line",
            data: {
                labels: this.labels,
                datasets: [
                    {
                        label: "Revenue",
                        data: this.values,
                        fill: true,
                        borderColor: "#4F46E5",
                        backgroundColor: "rgba(79, 70, 229, 0.2)",
                        tension: 0.3,
                        pointRadius: 3,
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: "index", intersect: false },
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            color: "rgba(200, 200, 200, 0.2)",
                            drawBorder: false,
                        },
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: "rgba(200, 200, 200, 0.2)",
                            drawBorder: false,
                        },
                        ticks: {
                            callback: (v) =>
                                new Intl.NumberFormat("en-IN", {
                                    style: "currency",
                                    currency: "INR",
                                    minimumFractionDigits: 2,
                                }).format(v),
                        },
                    },
                },
            },
        });
    }
}

// Render
new LineChart("lineChart").render();
