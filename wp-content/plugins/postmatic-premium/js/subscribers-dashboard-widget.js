jQuery( document ).ready( function($) {
	//Create 90 empty labels
	var labels = Array.apply(null, Array(90)).map(String.prototype.valueOf,"");

	// Chart data
	var data = {
		labels: labels,
	    datasets: [
		{
		    label: "post",
		    fillColor: "#EBEBEB",
		    strokeColor: "#bdc3c7",
		    pointColor: "rgba(220,220,220,1)",
		    pointStrokeColor: "#fff",
		    pointHighlightFill: "#fff",
		    pointHighlightStroke: "rgba(220,220,220,1)",
		    data: chart_data.post
		},
	    ]
	};


	var template = "<ul class=\"legend\">";
	template += "<% for (var i=0; i<datasets.length; i++){%>";
	template += "<li><span style=\"background-color:<%=datasets[i].strokeColor%>;\"></span>";
	template += " You have <%=datasets[i].points[datasets[i].points.length-1].value%> <%=datasets[i].label%> subscribers.</li>";
	template += "<%}%></ul>";

	var options = {
		scaleShowGridLines: false,
		scaleShowLabels: true,
		pointDot: false,
		showTooltips: false,
		lineTension: 1,
		legendTemplate : template
	};

	if ( $( "#subscribersChart" ).length ) {
		var ctx = $("#subscribersChart").get(0).getContext("2d");
		var subscribersChart = new Chart(ctx).Line(data, options);
		//var legend = subscribersChart.generateLegend();
		//$(".upper .left").append( legend );
		$(".upper .left .total").html( chart_data.total );
		var week = chart_data.week;
		var symbol, color;
		if ( week >= 0) {
			symbol = "+";
			color = "green";
		}
		else {
			symbol = "";
			color = "red";
		}
		$(".upper .right .week").html( symbol + week );
		$(".upper .right .week").css( "color", color );
	}

});
