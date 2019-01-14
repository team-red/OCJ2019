// Sidenav JavaScript code
function openNav(){
  sidebar_size = window.getComputedStyle(document.body).getPropertyValue('--sidebar_size');
  document.getElementById("side-bar").style.width = sidebar_size;
  document.getElementById("dark").style.display = "block";
  }
function closeNav(){
  document.getElementById("side-bar").style.width = "0";
  document.getElementById("dark").style.display = "none";
}

// Home page charts
function generate_chart(element_id, type, labels, datasets, options){
  if (type === undefined) {
        type = "doughnut";
  }
  if (options === undefined) {
        options = {
          maintainAspectRatio: false,
          cutoutPercentage: 80,
          legend: {display: false},
          centerText: {display: true,text: "280"}
        };
  }
  var ctx = document.getElementById(element_id);
  var chart = new Chart(ctx, {
      type: type,
      data: {
          labels: labels,
          datasets: datasets
      },
      options: options
  });
}

//contral text
Chart.plugins.register({
    afterDatasetsDraw: function(chartInstance, easing) {
        if (chartInstance.config.type == "doughnut") {
            var ctx = chartInstance.chart.ctx;
            var sum = 0;
            var act = 0;

            ctx.fillStyle = '#4f5566';
            var elmnt = document.getElementById("chart_done");
            var width = elmnt.offsetWidth;
            var height = elmnt.offsetHeight;
            var fontSize = 0;
            if (window.matchMedia("(min-width: 768px)").matches) {
              fontSize = width/8;
            } else {
              fontSize = 20;
            }
            var fontStyle = 'normal';
            var fontFamily = 'Rubik,sans-serif';
            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

            chartInstance.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.getDatasetMeta(i);
                            if (!meta.hidden) {
                                act = dataset.data[0];
                                meta.data.forEach(function(element, index) {
                                    sum += dataset.data[index];
                                });
                            }
                        });
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(act +"/"+ sum, width/2, height/2);
        }
    }
});

//creating charts
$( document ).ready(function() {
  // done chart
  generate_chart(
      "chart_done",
      undefined,
      ["Faits", "Pas encore Faits"],
      [{
        data: [12, 3],
        backgroundColor: ['#4f5566','#aab2bb'],
        borderWidth: 0
      }],
      undefined
    );

  //success chart
  generate_chart(
      "chart_success",
      undefined,
      ["Réussites", "Echecs"],
      [{
        data: [16, 12],
        backgroundColor: ['#4f5566','#aab2bb'],
        borderWidth: 0
      }],
      undefined
    );


    //marks chart
    generate_chart(
        "chart_marks",
        undefined,
        ["Note", ""],
        [{
          data: [16, 4],
          backgroundColor: ['#4f5566','#aab2bb'],
          borderWidth: 0
        }],
        undefined
      );

});
