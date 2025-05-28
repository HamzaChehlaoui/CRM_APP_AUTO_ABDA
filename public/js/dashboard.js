document.addEventListener('DOMContentLoaded', function () {
    const selectedBranch = window.chartData.selectedBranch;
    const labels = window.chartData.labels;
    const clientsVendus = window.chartData.clientsVendus;

    // Line chart for Prospects
    const prospectsCtx = document.getElementById('prospectsChart').getContext('2d');
    let prospectsChart = new Chart(prospectsCtx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Clients Vendu',
                data: clientsVendus,
                borderColor: '#3A5CDB',
                backgroundColor: 'rgba(58, 92, 219, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#3A5CDB',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 10,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#262626',
                    bodyColor: '#525252',
                    bodyFont: { size: 12 },
                    borderColor: '#e5e5e5',
                    borderWidth: 1,
                    padding: 10,
                    boxPadding: 5
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { font: { size: 11 }, color: '#737373' },
                    grid: { color: 'rgba(0, 0, 0, 0.05)', drawBorder: false }
                },
                x: {
                    ticks: { font: { size: 11 }, color: '#737373' },
                    grid: { display: false, drawBorder: false }
                }
            }
        }
    });

    function fetchPostSaleStats() {
        fetch(`/clients/post-sale-stats?branch_filter=${selectedBranch}`)
            .then(response => response.json())
            .then(data => {
                const labelsMap = {
                    'en_attente_livraison': 'En attente de livraison',
                    'livre': 'Livré',
                    'sav_1ere_visite': '1ère visite SAV',
                    'relance': 'À relancer'
                };

                const colorMap = {
                    'en_attente_livraison': '#f59e0b',
                    'livre': '#22c55e',
                    'sav_1ere_visite': '#3b82f6',
                    'relance': '#ef4444'
                };

                const labels = [], values = [], backgroundColors = [];

                for (let key in data) {
                    if (labelsMap[key]) {
                        labels.push(labelsMap[key]);
                        values.push(data[key]);
                        backgroundColors.push(colorMap[key]);
                    }
                }

                const statusCtx = document.getElementById('statusChart').getContext('2d');
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels,
                        datasets: [{
                            data: values,
                            backgroundColor: backgroundColors,
                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    padding: 15,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#262626',
                                bodyColor: '#525252',
                                bodyFont: {
                                    size: 12
                                },
                                borderColor: '#e5e5e5',
                                borderWidth: 1,
                                padding: 10,
                                boxPadding: 5,
                                callbacks: {
                                    label: function (context) {
                                        return `${context.label}: ${context.formattedValue}`;
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error("Erreur lors du chargement des données post-vente:", error);
            });
    }

    fetchPostSaleStats();
});

function changePeriod(period) {
    const url = new URL(window.location.href);
    url.searchParams.set('period', period);
    window.location.href = url.toString();
}
