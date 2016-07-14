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
	$scope.countries_esp;
	$scope.countries_ing;
	$scope.country_iso_esp = {};
	$scope.countries_iso;
	$scope.origin;
	$scope.destiny;
	$scope.model_origin_esp = {};
	$scope.model_destiny_esp = {};
	$scope.model_origin_ing = {};
	$scope.model_destiny_ing = {};
	$scope.menu = 0;
	$scope.select_ctry;
	$scope.select_origin;
	$scope.select_destiny;
	$scope.select_origin_length;
	$scope.select_destiny_length;
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
			DynNam = value.paises;
			if ($.inArray(DynNam, $scope.countries_esp) == -1 && DynNam != "" && DynNam != "Estados Unidos") {
				$scope.countries_esp.push(DynNam);
			}
			if ($.inArray(DynNam, $scope.model_origin_esp) == -1) {
				$scope.model_origin_esp[DynNam] = false;
			}
			if ($.inArray(DynNam, $scope.model_destiny_esp) == -1) {
				$scope.model_destiny_esp[DynNam] = false;
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
		console.log($scope.countries_esp);
		console.log($scope.model_origin_esp);
		console.log($scope.model_destiny_esp);
		console.log($scope.countries_ing);
		console.log($scope.model_origin_ing);
		console.log($scope.model_destiny_ing);

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
					console.log("entra");
					scope.select_year = y;
					scope.viewYear("yr"+y);
				});
			});

		var g_map = d3.select("#MAPA");

		if (ancho <= 428) {
		  g_map.attr("transform","translate(0,0)scale(.98)");

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
		};
	}

	$scope.getwidth = function(s){
		var ancho = d3.scale.linear()
     		.domain([0,600000])
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
			if ( ($scope.model_origin_esp[name])) {
				if ( ($scope.model_destiny_esp[dest]) ) {
					if ($scope.destiny[value.iso_orig]) {
						$scope.destiny[value.iso_orig][value.iso_dest] = value;
						$scope.destiny[value.iso_orig]["suma"] = $scope.destiny[value.iso_orig]["suma"] + parseInt(value[y]);
					}
					else {
						$scope.destiny[value.iso_orig] = {};
						$scope.destiny[value.iso_orig][value.iso_dest] = value;
						$scope.destiny[value.iso_orig]["suma"] = parseInt(value[y]);
					}
				}
			}
			if ( ($scope.model_destiny_esp[dest]) ) {
				if ( ($scope.model_origin_esp[name]) ) {
					if ($scope.origin[value.iso_dest]) {
						$scope.origin[value.iso_dest][value.iso_orig] = value;
						$scope.origin[value.iso_dest]["suma"] = $scope.origin[value.iso_dest]["suma"] + parseInt(value[y]);
					}
					else {
						$scope.origin[value.iso_dest] = {};
						$scope.origin[value.iso_dest][value.iso_orig] = value;
						$scope.origin[value.iso_dest]["suma"] = parseInt(value[y]);
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

	/*$scope.resize = function(id, ns){
		var rec = d3.select("#"+id);
 		var x = parseInt(rec.attr("x"));
 		var y = parseInt(rec.attr("y"));
 		var w = parseInt(rec.attr("width"));
 		var h = parseInt(rec.attr("height"));

 		x = x + (w / 2);
 		y = y + (w / 2);

 		var nw = ns;

 		x = (x)-(nw/2);
 		y = (y)-(nw/2);
 		h = nw;

		rec.attr("x", x);
 		rec.attr("y", y);
 		rec.attr("width", nw);
 		rec.attr("height", h);
	}*/

	$scope.drawMap = function(){		
		var width,
		    height = 500,
		    centered;
		if (ancho <= 428) {
		  width = 320
		}
		else {
		  width = 775
		};

		var projection = d3.geo.albersUsa()
		    .scale(1000)
		    .translate([width / 2, height / 2]);

		var path = d3.geo.path()
		    .projection(projection);

		/*var div = d3.select("body").append("div")   
		    .attr("class", "tooltip")               
		    .style("opacity", 0);*/

		var svg = d3.select("#state_map").append("svg")
		    .attr("width", width)
		    .attr("height", height);

		svg.append("rect")
		    .attr("class", "background")
		    .attr("width", width)
		    .attr("height", height)
		    .on("click", clicked);

		var g = svg.append("g");

		d3.json("/Gobernadores_Senadores/js/us.json", function(error, us) {
		  g.append("path")
		      .datum(topojson.mesh(us, us.objects.states, function(a, b) { return a !== b; }))
		      .attr("id", "state-borders")
		      .attr("d", path);
		      
		  g.append("g")
		      .attr("id", "states")		      
		    .selectAll("path")
		      .data(topojson.feature(us, us.objects.states).features)
		    .enter().append("path")
		    	.attr("id", function(d){ return 'state_'+d.id})		    	
		    	/*.style("fill", function(d){
		    		var arr = $.grep($scope.list_sendadores, function( a ) {
  						return a.FIPS_Code == d.id;
					});		    		
		    		if (arr[0]){
						var color = d3.scale.ordinal();
						color.domain([0,1,2,3]);
						color.range(["#BDCEDE","538635","97C47A","#FF00FF"]);												
						if (parseInt(arr[0].hayspecial) == 1) {
							return color(3)
						}else{
							var c = color(parseInt(arr[0].elections));							
							return c;
						}
					}
		    	})*/
		      .attr("d", path)
		      .on("click", clicked);

		   $scope.colorear();
		});

		console.log(ancho);
		if (ancho <= 428) {
		  g.attr("transform","translate(89,60)scale(.38)");
		};

		function clicked(d) {

			/* Marcar estado seleccionado */
			var marcado_id = d.id
			d3.selectAll("path").classed("marcado", false);
			d3.select("#state_"+marcado_id).classed("marcado", true);

		  var x, y, k, st_code, st, abb, centroid;

		  st_code = d.id;
		  //st = $scope.seek_name(st_code);
		  //st =""

		  if (d && centered !== d) {
		    centroid = path.centroid(d);
		    x = centroid[0];
		    y = centroid[1];
		    k = 4;
		    centered = d;
		    /*div.transition()
		      .duration(200)
		      .style("opacity", .9)
		    div.html("Code: "+st_code+"<br/>"+"State: "+st)
		      .style("left", (d3.event.pageX) + "px")
		      .style("top", (d3.event.pageY - 28) + "px");*/
		  }
		  else {
		    x = width / 2;
		    y = height / 2;
		    if (ancho > 428) {
		      k = 1;
		    }
		    else {
		      k = .38;
		    }
		    centered = null;
		    /*div.transition()
		      .duration(500)
		      .style("opacity", 0);*/
		  }

		  g.selectAll("path")
		      .classed("active", centered && function(d) { return d === centered; });

		  	/*if (ancho <= 428) {
			g.transition()
				.duration(750)
				.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")")
				.style("stroke-width", 1.5 / k + "px");
			}*/


			/* Mostrar modal */				
				
				var scope = angular.element($('#body')).scope();         			
				if (scope.seleccionada == "senador"){

					var color_st_s = "";
					$.each($scope.list_sendadores, function(index,val){								
						if (parseInt(val.FIPS_Code) == d.id){
							if (parseInt(val.pollpercrep) > parseInt(val.pollpercdem)){
								color_st_s = "#E93838";
							}
							else {
								color_st_s = "#3E65AA";
							}
						}
					})

					d3.selectAll(".path_state_senador")
						.attr("d",$("#state_"+d.id).attr("d"))
						.style("fill",color_st_s);
					k = 1;
					if (d.id == 6 || d.id == 48 || d.id == 32 || d.id == 16){
						k = .6;
					}
					if (ancho<400){
						k = .4;						
						if (d.id == 6 || d.id == 48 || d.id == 32 || d.id == 16){
							k = .2;
						}
						if ($scope.id_seleccionado != d.id){
							d3.selectAll(".g_senador")
								.attr("transform", "translate(" + 100 / 2 + "," + 70 / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")");
						}
					}else{
						if ($scope.id_seleccionado != d.id){							
							d3.selectAll(".g_senador")
								.attr("transform", "translate(" + 200 / 2 + "," + 120 / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")");
						}
					}

					scope.$apply(function(){
						var arr = $.grep($scope.list_sendadores, function( a ) {
  							return a.FIPS_Code == d.id;
						});		
						if (arr[0]){    		
							scope.senador_seleccionado = arr[0];
							if (($scope.hayspecial()) || ($scope.hayeleccion())){
		        				scope.senadores = true;
								scope.gobernadores = false;	
								scope.id_seleccionado = d.id;
							}else{
								scope.senadores = false;
								scope.gobernadores = false;	
							}
						}							        			
	    			});				
				}
				else {
					var color_st_g = "";
					$.each($scope.list_gobernadores, function(index,val){								
						if (parseInt(val.FIPS_Code) == d.id){
							if (parseInt(val.pollpercrep) < parseInt(val.pollpercdem)){
								color_st_g = "#E93838";
							}
							else {
								color_st_g = "#3E65AA";
							}
						}
					})

					d3.select("#path_state_gobernador")
						.attr("d",$("#state_"+d.id).attr("d"))
						.style("fill",color_st_g);
					k = 1;
					if (d.id == 6 || d.id == 48 || d.id == 32 || d.id == 16){
						k = .6;
					}
					if (ancho<400){
						k = .4;						
						if (d.id == 6 || d.id == 48 || d.id == 32 || d.id == 16){
							k = .2;
						}
						if ($scope.id_seleccionado != d.id){
							d3.selectAll("#g_gobernador")
								.attr("transform", "translate(" + 100 / 2 + "," + 70 / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")");
						}
					}else{
						if ($scope.id_seleccionado != d.id){
							d3.select("#g_gobernador")
								.attr("transform", "translate(" + 200 / 2 + "," + 120 / 2 + ")scale(" + k + ")translate(" + -x + "," + -y + ")");
						}

					}

					scope.$apply(function(){
						var arr = $.grep($scope.list_gobernadores, function( a ) {
  							return a.FIPS_Code == d.id;
						});
						if (arr[0]){    		
							scope.gobernador_seleccionado = arr[0];
							if ($scope.hayeleccion2()){
								scope.id_seleccionado = d.id;
		        				scope.senadores = false;
								scope.gobernadores = true;	

							}else{
								scope.senadores = false;
								scope.gobernadores = false;	
							}
						}
					});	
				}			
		}
	}


	

	$scope.init();

});
