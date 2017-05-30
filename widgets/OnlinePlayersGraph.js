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
		url : "OnlinePlayersData.php",
		type : "GET",
		success : function(data){
			console.log(data);

			var Timestamp = [];
			var Players = [];

			for(var i in data) {
				Timestamp.push(timeConverter(data[i].Timestamp));
				Players.push(data[i].Players);
			}

			var chartdata = {
				labels: Timestamp,
				datasets: [
					{
						label: "Online Players",
						fillColor: "rgba(0, 0, 0, 0.5)",
						lineTension: 0,
						backgroundColor: "rgba(0, 0, 0, 0.25)",
						//borderColor: "rgba(255, 255, 255, 0.25)",
						pointHoverBackgroundColor: "rgba(0, 0, 0, 0.25)",
						pointHoverBorderColor: "rgba(0, 0, 0, 0.25)",
                        radius: 0,
						data: Players
					}
				]
			};

			var ctx = $("#player-stats");

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