chart7 = $.jqplot('chart7', [line7], {
	// Only animate if we're not using excanvas (not in IE 7 or IE 8)..
	animate: !$.jqplot.use_excanvas,
	seriesDefaults:{
		renderer:$.jqplot.BarRenderer,
		pointLabels: {
			show: true,
			formatString: '%d\F',
		}
	},
	axesDefaults: {
		labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
		sortData: true,
		labelOptions: {
			fontSize: '13pt'
		}
	},
	legend:{
		renderer: $.jqplot.EnhancedLegendRenderer,
		show:true,
		labels:['Average Daily Temperature'],
		rendererOptions:{
			numberRows: 1
		},
		placement: 'outsideGrid',
		location: 's'
	},
	axes: {
		xaxis: {
			label: 'Date',
			renderer: $.jqplot.CategoryAxisRenderer,
		}
	},
	highlighter: { show: false }
});
