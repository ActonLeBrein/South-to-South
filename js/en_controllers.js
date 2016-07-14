/*
	Angular controller.
*/

var ancho = $(window).width();

var uniApp = angular.module('uniApp', []);


uniApp.factory('uniFactory', function($http) {
    var factory = {}; 
});

uniApp.controller('indexCtrl', function($scope, $filter, uniFactory) {

	$scope.acerca = false;
	$scope.instrucciones = false;
	$scope.modal = false;
	$scope.tooltip = false;
	$scope.selected_data = {};
	/*$scope.countries_esp;*/
	$scope.countries_ing;
	$scope.country_iso_esp = {};
	$scope.countries_iso;
	$scope.origin;
	$scope.destiny;
	/*$scope.model_origin_esp = {};
	$scope.model_destiny_esp = {};*/
	$scope.model_origin_ing = {};
	$scope.model_destiny_ing = {};
	$scope.menu = 0;
	$scope.select_ctry;
	$scope.select_origin;
	$scope.select_destiny;
	$scope.select_year;
	/*$scope.All_O = true;
	$scope.All_D = true;*/

	$scope.show = function(val) {
		if (val == $scope.menu) {
			$scope.menu = 0;
		}
		else {
			$scope.menu = val;
		}
	}

	$scope.init = function(){
		$scope.countries_iso = [];
		$scope.countries_esp = [];
		$scope.countries_ing = [];
		$scope.origin = {};
		$scope.destiny = {};
		var DynNam = '';
		var max = 0;
		$.each(json, function(index,value) {
			DynNam = value.iso_dest;
			if ($.inArray(DynNam, $scope.countries_iso) == -1) {
				$scope.countries_iso.push(DynNam);
			}
			DynNam = value.countries;
			if ($.inArray(DynNam, $scope.countries_ing) == -1 && DynNam != "" && DynNam != "United States") {
				$scope.countries_ing.push(DynNam);
			}
			if ($.inArray(DynNam, $scope.model_origin_ing) == -1) {
				$scope.model_origin_ing[DynNam] = false;
			}
			if ($.inArray(DynNam, $scope.model_destiny_ing) == -1) {
				$scope.model_destiny_ing[DynNam] = false;
			}
		});
		console.log($scope.countries_ing);
		console.log($scope.model_origin_ing);
		console.log($scope.model_destiny_ing);

		if (ancho <= 428) {
			var g_map = d3.select("#MAPA");
			var rects = d3.selectAll("#Capa_1 rect");
			var texts = d3.selectAll("#Capa_1 text");
			var visit = "nothing";
			
			g_map.attr("transform","translate(0,0)scale(.98)");
			
			/*ZOOM MAP*/

			d3.selectAll("#MAPA path")
				.on("click", function(d) {
					var thisID = $(this).attr('id');
					centers = {'mexic':[-100,-200],'guate':[-385,-327],'hondu':[-385,-327],'salva':[-385,-327],'nicar':[-385,-327],
							   'panam':[-385,-327],'cost':[-385,-327],'cub':[-785,-327],'puert':[-785,-327],'domin':[-785,-327],
							   'colom':[-744,-660],'venez':[-944,-660],'ecuad':[-644,-760],'per':[-844,-1060],'boliv':[-944,-1260],
							   'brazi':[-1344,-1060],'parag':[-1144,-1360],'chil':[-844,-1560],'urugu':[-1144,-1560],'argen':[-944,-1760],
							   'espan':[-100,-1560],'portu':[200,-1560]};
					if (visit != thisID) {
						visit = thisID;
						g_map.transition()
							.duration(750)
							.attr("transform", "translate("+centers[thisID][0]+","+centers[thisID][1]+")scale(3)");

						rects.transition()
							.duration(750)
							.attr("transform", "translate("+centers[thisID][0]+","+centers[thisID][1]+")scale(3)");

						texts.transition()
							.duration(750)
							.attr("transform", "translate("+centers[thisID][0]+","+centers[thisID][1]+")scale(3)");
					}
					else {
						visit = "nothing";
						g_map.transition()
							.duration(750)
							.attr("transform","translate(0,0)scale(0.98)");

						rects.transition()
							.duration(750)
							.attr("transform","translate(0,0)scale(0.98)");

						texts.transition()
							.duration(750)
							.attr("transform","translate(0,0)scale(0.98)");
					}
				});

			/*********/

			d3.select("#line_1960").attr("x2", 10);
			d3.select("#circle_1960").attr("cx", 12);
			d3.select("#text_1960").attr("x", 0);

			d3.select("#line_1970").attr("x1", 10)
									 .attr("x2", 60);
			d3.select("#circle_1970").attr("cx", 62);
			d3.select("#text_1970").attr("x", 50);

			d3.select("#line_1980").attr("x1", 60)
									 .attr("x2", 110);
			d3.select("#circle_1980").attr("cx", 112);
			d3.select("#text_1980").attr("x", 100);

			d3.select("#line_1990").attr("x1", 110)
									 .attr("x2", 160);
			d3.select("#circle_1990").attr("cx", 162);
			d3.select("#text_1990").attr("x", 150);

			d3.select("#line_2000").attr("x1", 160)
									 .attr("x2", 210);
			d3.select("#circle_2000").attr("cx", 212);
			d3.select("#text_2000").attr("x", 200);

			d3.select("#line_2010").attr("x1", 210)
									 .attr("x2", 260);
			d3.select("#circle_2010").attr("cx", 262);
			d3.select("#text_2010").attr("x", 250);

			d3.selectAll("#time_line circle")
				.on("click", function() {
					d3.selectAll("#time_line line")
						.attr("stroke", "#A2A2A2")
						.attr("stroke-width", 2.5);
					d3.selectAll("#time_line circle")
						.attr("stroke", "#A2A2A2")
						.attr("stroke-width", 3)
						.attr("fill", "#A2A2A2")
						.attr("r", 7);
					d3.selectAll("#time_line text")
						.attr("fill", "#000000");
					var year = parseInt(this.id.split("_")[1]); 
					var y = year;
					while (year >= 1960) {
						var id = "#line_" + year;
						d3.select(id).attr("stroke", "#2d87cf")
									 .attr("stroke-width", 3);
						id = "#circle_" + year;
						d3.select(id).attr("stroke", "#2d87cf")
									 .attr("stroke-width", 4)
									 .attr("fill", "#2d87cf")
									 .attr("r", 10);
						id = "#text_" + year;
						d3.select(id).attr("fill", "#2d87cf");
						year = year - 10;
					}
					var scope = angular.element($("#body")).scope();
					scope.$apply(function(){
						scope.select_year = y;
						scope.viewYear("yr"+y);
					});
			});
		}
		else {
			/*TIMELINE*/

			d3.selectAll("#time_line circle")
				.on("click", function() {
					d3.selectAll("#time_line line")
						.attr("stroke", "#A2A2A2")
						.attr("stroke-width", 2.5);
					d3.selectAll("#time_line circle")
						.attr("stroke", "#A2A2A2")
						.attr("stroke-width", 3)
						.attr("fill", "#A2A2A2")
						.attr("r", 5);
					d3.selectAll("#time_line text")
						.attr("fill", "#000000");
					var year = parseInt(this.id.split("_")[1]); 
					var y = year;
					while (year >= 1960) {
						var id = "#line_" + year;
						d3.select(id).attr("stroke", "#2d87cf")
									 .attr("stroke-width", 3);
						id = "#circle_" + year;
						d3.select(id).attr("stroke", "#2d87cf")
									 .attr("stroke-width", 4)
									 .attr("fill", "#2d87cf")
									 .attr("r", 6);
						id = "#text_" + year;
						d3.select(id).attr("fill", "#2d87cf");
						year = year - 10;
					}
					var scope = angular.element($("#body")).scope();
					scope.$apply(function(){
						scope.select_year = y;
						scope.viewYear("yr"+y);
					});
				});
		}
	}

	$scope.getWidth = function(s){
		var ancho = d3.scale.linear()
     		.domain([1000,3000000])
     		.range([0,300]);
     	return ancho(s)+"px";
	}

	$scope.normalizar = function(name){
		var r = "";
		switch (name){
			case "Spain"	: r = "Espa"; break;
			case "España"	: r = "Espa"; break;
			case "Dominican Republic": r = "Republica"; break;
			case "Brazil": r = "Brasil"; break;
			default	:
				r = name.split(' ')[0];
				break;
		}
		return r;		
	}

	$scope.viewYear = function(y){
		var DynNam = '';
		var max = 0;
		$scope.origin = {};
		$scope.destiny = {};
		$.each(json, function (index,value) {
			var name = $scope.normalizar(value.ctry_orig);
			var dest = $scope.normalizar(value.ctry_dest);
			if ( ($scope.model_origin_ing[name])) {
				if ( ($scope.model_destiny_ing[dest]) ) {
					if ($scope.origin[value.iso_orig]) {
						$scope.origin[value.iso_orig][value.iso_dest] = value;
						$scope.origin[value.iso_orig]["suma"] = $scope.origin[value.iso_orig]["suma"] + parseInt(value[y]);
					}
					else {
						$scope.origin[value.iso_orig] = {};
						$scope.origin[value.iso_orig][value.iso_dest] = value;
						$scope.origin[value.iso_orig]["suma"] = parseInt(value[y]);
					}
				}
			}
			if ( ($scope.model_destiny_ing[dest]) ) {
				if ( ($scope.model_origin_ing[name]) ) {
					if ($scope.destiny[value.iso_dest]) {
						$scope.destiny[value.iso_dest][value.iso_orig] = value;
						$scope.destiny[value.iso_dest]["suma"] = $scope.destiny[value.iso_dest]["suma"] + parseInt(value[y]);
					}
					else {
						$scope.destiny[value.iso_dest] = {};
						$scope.destiny[value.iso_dest][value.iso_orig] = value;
						$scope.destiny[value.iso_dest]["suma"] = parseInt(value[y]);
					}
				}
			}
		});
		console.log("origin:");
		console.log($scope.origin);
		console.log("destiny");
		console.log($scope.destiny);

		resize();
	}
	$scope.init();
});
