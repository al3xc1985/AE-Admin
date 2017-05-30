function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear().toString().substr(2, 2);
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = date + ' ' + month + '`' + year + ' - ' + hour + ':' + min + ':' + sec ;
  return time;
}

$(document).ready(function(){
	$.ajax({
		url : "RAMData.php",
		type : "GET",
		success : function(data){
			console.log(data);

			var Timestamp = [];
			var RAM_Usage = [];

			for(var i in data) {
				Timestamp.push(timeConverter(data[i].Timestamp));
				RAM_Usage.push(data[i].RAM_Usage);
			}

			var chartdata = {
				labels: Timestamp,
				datasets: [
					{
						label: "RAM (MB)",
						fillColor: "rgba(0, 0, 0, 0.5)",
						lineTension: 0,
						backgroundColor: "rgba(0, 0, 0, 0.25)",
						//borderColor: "rgba(255, 255, 255, 0.25)",
						pointHoverBackgroundColor: "rgba(0, 0, 0, 0.25)",
						pointHoverBorderColor: "rgba(0, 0, 0, 0.25)",
                        radius: 0,
						data: RAM_Usage
					}
				]
			};

			var ctx = $("#ram_usage");

			var LineGraph = new Chart(ctx, {
				type: 'line',
				data: chartdata,
                options: {
                    legend: {
                        display: false
                     },
                    scales:
                    {
                        yAxes: [{
                            gridLines : {
                                display : false
                            },
                            ticks: {
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines : {
                                display : false
                            },
                            ticks: {
                                display: false
                            }
                        }]
                    }
                }
			});
		},
		error : function(data) {

		}
	});
});