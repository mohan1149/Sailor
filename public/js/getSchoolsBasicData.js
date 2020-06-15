let labels     = ['Departments', 'Employees', 'Teaching Staff', 'Students'];
let graph_sets = [];
axios({
  method:'get',
  url:'/get/school/graph-data/'
})
.then(function(response){
  let datasets = response.data;
  datasets.map((dataset)=>{
    let g_set = {
      label:dataset.school_name,
      backgroundColor: '#'+ Math.floor(Math.random()*16777215).toString(16),
      borderColor: '#'+ Math.floor(Math.random()*16777215).toString(16),
      borderWidth: 1,
      data:[        
        dataset.depts_count,
        dataset.emps_count,	
        dataset.staff_count,
        dataset.studs_count        
	  ],
	  fill:false,
    };
    graph_sets.push(g_set);
  });

  var barChartData = {
    labels: labels,
    datasets: graph_sets,
  };
  var ctx = document.getElementById('institute-canvas').getContext('2d');
  window.myBar = new Chart(ctx, {
    type: 'line',
    data: barChartData,
    options: {
      responsive: true,
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'School(s) Bar Chart'
      }
    }
  });
});
