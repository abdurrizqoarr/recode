import axios from "axios";
import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", function () {
    const aumSelect = document.getElementById("aum");
    const chartContainer = document.getElementById("chart-container");
    const loadingState = document.getElementById("loading-state");

    aumSelect.addEventListener("change", function () {
        const idaum = this.value;

        // Sembunyikan chart & tampilkan loading
        chartContainer.classList.add("hidden");
        chartContainer.classList.remove("flex");
        loadingState.style.display = "flex";

        if (idaum) {
            axios
                .get(`/get-rekap-per-aum`, {
                    params: { idaum: idaum },
                })
                .then((response) => {
                    const ctx = document.getElementById("acquisitions");

                    // Hancurkan chart sebelumnya jika ada
                    if (window.rekapChartInstance) {
                        window.rekapChartInstance.destroy();
                    }

                    const labels = response.data.labels;
                    const data = response.data.datasets[0].data;

                    const labelColors = [
                        "#3b82f6",
                        "#10b981",
                        "#f59e0b",
                        "#ef4444",
                        "#8b5cf6",
                        "#ec4899",
                        "#6b7280",
                    ];
                    const backgroundColors = labels.map(
                        (_, i) => labelColors[i % labelColors.length]
                    );

                    window.rekapChartInstance = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: "Jumlah Pegawai",
                                    data: data,
                                    backgroundColor: backgroundColors,
                                },
                            ],
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        label: function (context) {
                                            const index = context.dataIndex;
                                            const label = labels[index];
                                            return `${label}: ${context.formattedValue}`;
                                        },
                                    },
                                },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                },
                            },
                        },
                    });

                    // Tampilkan chart dan sembunyikan loading
                    loadingState.style.display = "none";
                    chartContainer.classList.remove("hidden");
                    chartContainer.classList.add("flex");
                })
                .catch((error) => {
                    console.error("Fetch error:", error);

                    // Sembunyikan loading & chart
                    loadingState.style.display = "none";
                    chartContainer.classList.add("hidden");
                    chartContainer.classList.remove("flex");

                    // Hapus chart jika masih ada
                    if (window.rekapChartInstance) {
                        window.rekapChartInstance.destroy();
                        window.rekapChartInstance = null;
                    }
                });
        } else {
            // Jika tidak ada pilihan, sembunyikan loading & chart
            loadingState.style.display = "none";
            chartContainer.classList.add("hidden");
            chartContainer.classList.remove("flex");
        }
    });
});
