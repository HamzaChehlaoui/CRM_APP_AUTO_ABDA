document.addEventListener('DOMContentLoaded', function () {
const selectedBranch = window.chartData.selectedBranch;
const labels = window.chartData.labels;
const clientsVendus = window.chartData.clientsVendus;

// International Statistics Style Chart
const prospectsCtx = document.getElementById('prospectsChart').getContext('2d');

let prospectsChart = new Chart(prospectsCtx, {
type: 'bar',
data: {
labels: labels,
datasets: [{
label: 'Total payé',
data: clientsVendus,
backgroundColor: [
'#1f77b4', // Blue
'#ff7f0e', // Orange
'#2ca02c', // Green
'#d62728', // Red
'#9467bd', // Purple
'#8c564b', // Brown
'#e377c2', // Pink
'#7f7f7f', // Gray
'#bcbd22', // Olive
'#17becf', // Cyan
'#aec7e8', // Light Blue
'#ffbb78' // Light Orange
],
borderColor: '#ffffff',
borderWidth: 1,
borderRadius: 0,
barThickness: 40
}]
},
options: {
responsive: true,
maintainAspectRatio: false,
layout: {
padding: {
top: 10,
bottom: 10,
left: 15,
right: 15
}
},
plugins: {
legend: {
display: false
},
tooltip: {
backgroundColor: '#2c3e50',
titleColor: '#ffffff',
bodyColor: '#ffffff',
borderColor: '#34495e',
borderWidth: 1,
cornerRadius: 4,
displayColors: true,
titleFont: {
size: 13,
weight: 'bold',
family: 'Arial, sans-serif'
},
bodyFont: {
size: 12,
family: 'Arial, sans-serif'
},
padding: 10,
callbacks: {
label: function(context) {
return `${context.dataset.label}: ${context.parsed.y.toLocaleString()}`;
}
}
}
},
scales: {
y: {
beginAtZero: true,
ticks: {
color: '#2c3e50',
font: {
size: 11,
family: 'Arial, sans-serif'
},
padding: 5,
callback: function(value) {
if (value >= 1000000) {
return (value / 1000000).toFixed(1) + 'M';
} else if (value >= 1000) {
return (value / 1000).toFixed(0) + 'K';
}
return value.toLocaleString();
}
},
grid: {
color: '#bdc3c7',
lineWidth: 1,
drawBorder: true
},
border: {
color: '#2c3e50',
width: 2
},
title: {
display: true,
text: 'Amount',
color: '#2c3e50',
font: {
size: 12,
weight: 'bold',
family: 'Arial, sans-serif'
},
padding: 10
}
},
x: {
ticks: {
color: '#2c3e50',
font: {
size: 11,
family: 'Arial, sans-serif'
},
padding: 5,
maxRotation: 0,
minRotation: 0
},
grid: {
display: false
},
border: {
color: '#2c3e50',
width: 2
},
title: {
display: true,
text: 'Period',
color: '#2c3e50',
font: {
size: 12,
weight: 'bold',
family: 'Arial, sans-serif'
},
padding: 10
}
}
},
interaction: {
intersect: false,
mode: 'index'
},
animation: {
duration: 500,
easing: 'easeOutQuart'
}
}
});

// Add source and notes styling (common in statistical charts)
const chartContainer = document.querySelector('#prospectsChart').parentElement;

// Add source note
const sourceNote = document.createElement('div');
sourceNote.innerHTML = '<small style="color: #7f8c8d; font-family: Arial, sans-serif; font-size: 10px;">Source: Internal Data | Updated: ' + new Date().toLocaleDateString() + '</small>';
sourceNote.style.marginTop = '8px';
sourceNote.style.textAlign = 'left';
chartContainer.appendChild(sourceNote);

const chartTitle = chartContainer.querySelector('h3, h2, .chart-title');
if (chartTitle) {
chartTitle.style.cssText = `
font-family: Arial, sans-serif;
font-size: 16px;
font-weight: bold;
color: #2c3e50;
margin-bottom: 15px;
text-align: left;
border-bottom: 2px solid #3498db;
padding-bottom: 5px;
`;
}



function fetchPostSaleStats() {
    fetch(`/clients/post-sale-stats?branch_filter=${selectedBranch}`)
        .then(response => response.json())
        .then(data => {
            if (!data || data.length === 0) {
                displayNoDataMessage();
                return;
            }

            const sortedData = data.sort((a, b) => b.total_amount - a.total_amount);

            const topClients = sortedData.slice(0, 5);

            const labels = topClients.map(item => item.full_name);
            const values = topClients.map(item => parseFloat(item.total_amount));

            const colors = [
                '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728',
                '#9467bd', '#8c564b', '#e377c2', '#7f7f7f',
                '#bcbd22', '#17becf', '#aec7e8', '#ffbb78'
            ];
            const backgroundColors = labels.map((_, i) => colors[i % colors.length]);

            const hasData = values.some(value => value > 0);
            if (!hasData) {
                displayNoDataMessage();
                return;
            }

            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data: values,
                        backgroundColor: backgroundColors,
                        borderColor: '#ffffff',
                        borderWidth: 2,
                        hoverOffset: 8,
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    size: 12,
                                    family: 'Arial, sans-serif'
                                },
                                color: '#333333'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#1a1a1a',
                            bodyColor: '#404040',
                            bodyFont: {
                                size: 13,
                                family: 'Arial, sans-serif'
                            },
                            borderColor: '#cccccc',
                            borderWidth: 1,
                            padding: 12,
                            boxPadding: 6,
                            cornerRadius: 4,
                            displayColors: true,
                            callbacks: {
                                label: function (context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.raw / total) * 100).toFixed(1);
                                    return `${context.label}: ${context.formattedValue.toLocaleString()} DH (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error("Erreur lors du chargement des données post-vente:", error);
            displayNoDataMessage();
        });
}




function displayNoDataMessage() {
const chartContainer = document.getElementById('statusChart').parentElement;

const existingCanvas = document.getElementById('statusChart');
if (existingCanvas) {
existingCanvas.remove();
}

// Create professional no-data message
const noDataDiv = document.createElement('div');
noDataDiv.id = 'statusChart';
noDataDiv.className = 'no-data-message';
noDataDiv.innerHTML = `
<div
    style="
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 250px;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            color: #6c757d;
            font-family: Arial, sans-serif;
        ">
    <i class="fas fa-smile-beam text-4xl mb-4 text-gray-300"></i>

    <h3
        style="
                margin: 0 0 8px 0;
                font-size: 18px;
                font-weight: 600;
                color: #495057;
            ">
        Aucune donnée disponible</h3>
    <p
        style="
                margin: 0;
                font-size: 14px;
                text-align: center;
                max-width: 280px;
                line-height: 1.4;
            ">
        Il n'y a actuellement aucune donnée post-vente à afficher pour la sélection actuelle.</p>
</div>
`;

chartContainer.appendChild(noDataDiv);
}

fetchPostSaleStats();
});

function changePeriod(period) {
const url = new URL(window.location.href);
url.searchParams.set('period', period);
window.location.href = url.toString();
}
