import {
    Chart,
    DoughnutController,
    ArcElement,
    Tooltip,
    Legend,
} from "chart.js";

Chart.register(DoughnutController, ArcElement, Tooltip, Legend);

export default class DonutChart {
    constructor(canvasId) {
        this.canvas = document.getElementById(canvasId);
        if (!this.canvas) return;

        this.labels = JSON.parse(this.canvas.dataset.labels);
        this.values = JSON.parse(this.canvas.dataset.values);
    }

    render() {
        if (!this.canvas) return;

        new Chart(this.canvas, {
            type: "doughnut",
            data: {
                labels: this.labels,
                datasets: [
                    {
                        data: this.values,
                        backgroundColor: [
                            "#4F46E5",
                            "#22C55E",
                            "#F59E0B",
                            "#EF4444",
                            "#3B82F6",
                            "#14B8A6",
                        ],
                    },
                ],
            },
            options: {
                responsive: true,
                cutout: "80%",
                layout: {
                    padding: {
                        left: 20,
                        right: 20,
                        top: 20,
                        bottom: 20,
                    },
                },
                plugins: {
                    legend: {
                        display: true,
                        position: "bottom", // legend on right
                        align: "center",
                        labels: {
                            boxWidth: 20,
                            padding: 25,
                        },
                    },
                },
            },
        });
    }
}

// Render
new DonutChart("donutChart").render();
