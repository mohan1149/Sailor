var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};

var config = {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
            ],
            backgroundColor: [
                '#'+ Math.floor(Math.random()*16777215).toString(16),
                'orange',
                'yellow',
                'green',
                'blue',
            ],					
        }],
        labels: [
            '10% 10 Class Section A - science',
            'Orange',
            'Yellow',
            'Green',
            'Blue'
        ]
    },
    options: {
        responsive: true,
        legend: {
            position: 'bottom',
        },
        title: {
            display: true,
            text: 'Syllabus Completion'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
};
window.onload = function() {
    var pieChart = document.getElementById('pieChart').getContext('2d');
    window.myDoughnut = new Chart(pieChart, config);
};