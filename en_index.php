<?php include('data.php') ?>
<html>
<head>
</head>
<!DOCTYPE HTML>
<html lang="en" ng-app="uniApp">
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sur a Sur</title>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,900,700italic,900italic' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="../fonts/stylesheet.css" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/style_mobile.css"/>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<!--link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css"-->
	<!--link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css"-->

	<!-- Scripts -->
	<script src="../sources/jquery.min1.11.1.js"></script>
	<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>	
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<script src="http://d3js.org/topojson.v1.min.js"></script>
	<script src="http://d3js.org/queue.v1.min.js"></script>
	<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
	<script src="../sources/angular.min.js"></script>

	<!--script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script-->  

	<script>
		var json = <?php echo $json; ?>;
		var e = document.createEvent('UIEvents');
     	e.initUIEvent('click', true, true, window, 1);
		//console.log(json);
		$(document).ready(function(){


			var scope = angular.element($("#body")).scope();
			$("#All_O").on("change", function(){
				//console.log("Origin");
				//console.log(scope.model_origin_esp);
				if (this.checked){					
					scope.$apply(function(){
						$.each(scope.model_origin_esp, function(index, val){							
							var b = scope.normalizar(index)
							//console.log(b);
							scope.model_origin_esp[b] = true;
						});
					});
					scope.todos = true;
				}else{
					scope.$apply(function(){
						$.each(scope.model_origin_esp, function(index, val){							
							var b = scope.normalizar(index)
							//console.log(b);
							scope.model_origin_esp[b] = false;
						});
						scope.todos = false;
					});					
				}
				d3.select("#circle_"+scope.select_year).node().dispatchEvent(e);	
			});

			$("#All_D").on("change", function(){
				if (this.checked){					
					scope.$apply(function(){
						$.each(scope.model_destiny_esp, function(index, val){							
							var b = scope.normalizar(index)						
							scope.model_destiny_esp[b] = true;
						});
					});
					scope.todos = true;
				}else{
					scope.$apply(function(){
						$.each(scope.model_destiny_esp, function(index, val){							
							var b = scope.normalizar(index)							
							scope.model_destiny_esp[b] = false;
						});
					});
					scope.todos = false;					
				}
				d3.select("#circle_"+scope.select_year).node().dispatchEvent(e);	
			});     		

     		$(".ocultar_menu").on("click", function(){     			
     			scope.$apply(function(){
     				scope.menu = 0;
     			});
     		});

     		d3.selectAll("svg").on("click", function(){
     			var scope = angular.element($("#body")).scope();
     			scope.$apply(function(){
     				scope.menu = 0;
     			});
     		});

     		$(".check").on("click", function(){
     			var scope = angular.element($("#body")).scope();
     			d3.select("#circle_"+scope.select_year).node().dispatchEvent(e);	
     			scope.$apply(function(){
     				scope.tooltip = false;	
     				scope.check();
     			});     			
     		})

     		$("#All_D").trigger("click");
     		$("#All_O").trigger("click");     		
     		d3.select("#circle_2010").node().dispatchEvent(e);
     	});		

     	function resize() {     		
     		var scope = angular.element($('#body')).scope(); 
     		//console.log(scope.model_origin_esp);
     		var size = d3.scale.linear()
     			.domain([0,3000000])
     			.range([26,200]);  

     		var len1 = $.map(scope.origin, function(n, i) { return i; }).length;
     		var len2 = $.map(scope.destiny, function(n, i) { return i; }).length;

     		if ( (len1 == 0) || (len2 == 0) ){     			
     			d3.selectAll("rect")
     				.attr("width", 0)
     				.attr("height", 0);
     		}

     		$.each(scope.origin, function(index, val) {     			
     			if (index != "USA") {
	     			var rec = d3.select("#"+index+"_O");

	     			var text = d3.select("#"+index+"_T");
     				
	     			var x = parseInt(text.attr("x"))+10;
		     		var y = parseInt(text.attr("y"))-5;
		     		var w = 5;
		     		var h = 10;

		     		x = x + (w / 2);
		     		y = y + (w / 2);
		     		
		     		var nw = size(val.suma);

		     		if (val.suma == 0){
		     			nw=0;
		     		}

		     		x = (x)-(nw/2);
		     		y = (y)-(nw/2);     		


					rec.attr("x", x)
		     		   .attr("y", y)
	     			   .attr("width", function(){return nw;})
	     			   .attr("height", nw)
	     			   .attr("fill", function(){	     			   		
	     			   		if (nw<27){
	     			   			return "#FF4000";
	     			   		}else{
	     			   			return "#ffffff";
	     			   		}
	     			   })
	     			   .attr("fill-opacity", function(){
	     			   		if (nw<27){
	     			   			return 1;
	     			   		}else{
	     			   			return .1;
	     			   		}
	     			   })
	     			   .on("click", function(){	     			   		
	     			   		var id = $(this).attr("id").split("_")[0];	     			   		
	     			   		scope.$apply(function(){
	     			   			scope.select_origin  = scope.origin[id];	
	     			   			scope.select_origin_length  = $.map(scope.origin[id], function(n, i) { return i; }).length - 5;		     			   			
	     			   			scope.select_ctry = scope.paises[id].ing;
	     			   			scope.showSalieron = true;
	     			   			if (scope.model_destiny_esp[scope.normalizar(scope.select_ctry)]){
	     			   				scope.select_destiny = scope.destiny[id];	     			   			
	     			   				scope.select_destiny_length = $.map(scope.select_destiny, function(n, i) { return i; }).length - 5;
									scope.showEntraron = true;	     			   			
	     			   			}else{
	     			   				scope.select_destiny = {};
	     			   				scope.select_destiny_length = 0;
	     			   				scope.showEntraron = false;
	     			   			}	     			   				     			   			
	     			   			
	     			   		});	     			   		
	     			   		if ((scope.select_origin_length + scope.select_destiny_length)>10){
	     			   			d3.select("#tooltip_esp #info_migration").style({"height":"400px", "overflow-y":"scroll"});
	     			   		}else{
	     			   				d3.select("#tooltip_esp #info_migration").style({"height":"auto", "overflow-y":"auto"});
	     			   			}
	     			   		scope.tooltip = true;	     			   		
	     			   });

					text.on("click", function(){	     			   		
	     			   		var id = $(this).attr("id").split("_")[0];	     			   		
	     			   		scope.select_ctry = scope.paises[id].ing;
	     			   		scope.$apply(function(){	     			   			
	     			   			if (scope.model_destiny_esp[scope.normalizar(scope.select_ctry)]){
	     			   				scope.select_destiny = scope.destiny[id];	     			   			
	     			   				scope.select_destiny_length = $.map(scope.select_destiny, function(n, i) { return i; }).length - 5;
									scope.showEntraron = true;	     			   			
	     			   			}else{
	     			   				scope.select_destiny = {};
	     			   				scope.select_destiny_length = 0;
	     			   				scope.showEntraron = false;
	     			   			}
	     			   			if (scope.model_origin_esp[scope.normalizar(scope.select_ctry)]){	     			   				
	     			   				scope.select_origin  = scope.origin[id];
	     			   				scope.select_origin_length  = $.map(scope.select_origin, function(n, i) { return i; }).length - 5;	
	     			   				scope.showSalieron = true;
	     			   			}else{
	     			   				scope.select_origin = {};
	     			   				scope.select_origin_length = 0;
	     			   				scope.showSalieron = false;
	     			   			}  			   				     			   			
	     			   			if ((scope.select_origin_length + scope.select_destiny_length)>10){
	     			   				d3.select("#tooltip_esp #info_migration").style({"height":"400px", "overflow-y":"scroll"});
	     			   			}else{
	     			   				d3.select("#tooltip_esp #info_migration").style({"height":"auto", "overflow-y":"auto"});
	     			   			}
	     			   		});	     			   			     			   		
	     			   		scope.tooltip = true;	     			   		
	     			   });						
	     		}
     		});     		
     		$.each(scope.destiny, function(index, val) {
     			if (index!="USA") {
	     			var rec = d3.select("#"+index+"_D");

	     			var text = d3.select("#"+index+"_T");
     				

	     			var x = parseInt(text.attr("x"))+10;
		     		var y = parseInt(text.attr("y"))-5;
		     		var w = 5;
		     		var h = 10;

		     		x = x + (w / 2);
		     		y = y + (w / 2);

		     		var nw = size(val.suma);

		     		if (val.suma == 0){
		     			nw=0;
		     		}

		     		x = (x)-(nw/2);
		     		y = (y)-(nw/2);     		

					rec.attr("x", x)
		     		   .attr("y", y)
	     			   .attr("width", nw)
	     			   .attr("height", nw)
	     			   .attr("fill", function(){
	     			   		if (nw<27){
	     			   			return "#FF4000";
	     			   		}else{
	     			   			return "#bfe5ff";
	     			   		}
	     			   })	     			   
	     			   .attr("fill-opacity", function(){
	     			   		if (nw<27){
	     			   			return 1;
	     			   		}else{
	     			   			return .5;
	     			   		}
	     			   })
	     			   .on("click", function(){
	     			        var id = $(this).attr("id").split("_")[0];
	     			   		scope.$apply(function(){
	     			   			scope.select_destiny = scope.destiny[id];
	     			   			scope.select_destiny_length = $.map(scope.destiny[id], function(n, i) { return i; }).length - 5;     			   			
	     			   			scope.select_ctry = scope.paises[id].ing;
	     			   			scope.showEntraron = true;	     			   			
	     			   			if (scope.model_origin_esp[scope.normalizar(scope.select_ctry)]){	     			   				
	     			   				scope.select_origin  = scope.origin[id];
	     			   				scope.select_origin_length  = $.map(scope.select_origin, function(n, i) { return i; }).length - 5;	
	     			   				scope.showSalieron = true;
	     			   			}else{
	     			   				scope.select_origin = {};
	     			   				scope.select_origin_length = 0;
	     			   				scope.showSalieron = false;
	     			   			}	
	     			   			if ((scope.select_origin_length + scope.select_destiny_length)>10){
	     			   				d3.select("#tooltip_esp #info_migration").style({"height":"400px", "overflow-y":"scroll"});
	     			   			}else{
	     			   				d3.select("#tooltip_esp #info_migration").style({"height":"auto", "overflow-y":"auto"});
	     			   			}     			   			
	     			   		});	     			   		
	     			   		scope.tooltip = true;	     			   		

	     			   });
					text.on("click", function(){	     			   		
	     			   		var id = $(this).attr("id").split("_")[0];	     			   		
	     			   		scope.select_ctry = scope.paises[id].ing;
	     			   		scope.$apply(function(){	     			   			
	     			   			if (scope.model_destiny_esp[scope.normalizar(scope.select_ctry)]){
	     			   				scope.select_destiny = scope.destiny[id];	     			   			
	     			   				scope.select_destiny_length = $.map(scope.select_destiny, function(n, i) { return i; }).length - 5;
									scope.showEntraron = true;	     			   			
	     			   			}else{
	     			   				scope.select_destiny = {};
	     			   				scope.select_destiny_length = 0;
	     			   				scope.showEntraron = false;
	     			   			}
	     			   			if (scope.model_origin_esp[scope.normalizar(scope.select_ctry)]){	     			   				
	     			   				scope.select_origin  = scope.origin[id];
	     			   				scope.select_origin_length  = $.map(scope.select_origin, function(n, i) { return i; }).length - 5;	
	     			   				scope.showSalieron = true;
	     			   			}else{
	     			   				scope.select_origin = {};
	     			   				scope.select_origin_length = 0;
	     			   				scope.showSalieron = false;
	     			   			}  			   				     			   			
	     			   			if ((scope.select_origin_length + scope.select_destiny_length)>10){
	     			   				d3.select("#tooltip_esp #info_migration").style({"height":"400px", "overflow-y":"scroll"});
	     			   			}else{
	     			   				d3.select("#tooltip_esp #info_migration").style({"height":"auto", "overflow-y":"auto"});
	     			   			}
	     			   		});	     			   			     			   		
	     			   		scope.tooltip = true;	     			   		
	     			   });						
	     		}
     		});     		
     	}
	</script>
	<script src="js/controllers.js"></script>

	<style>
		div.cantidad2 {
			text-align: right;
			/*margin-right: 10px;*/
			font-family: robotobold;
			font-size: 14px;
			width: 300px;
		}

		div.barra {
			width: 300px;
			height: 13px;
			background-color: #DBE2E4;
		}
		#tooltip_esp{
			overflow:auto;
			padding: 5px;			
		}
		#tooltip_esp div{
			margin-left:6px;
		}
		div.porcentaje {
			height: 13px;
			background:url("images/bg.png") repeat-x;
			margin-left: 0px !important;
		}
	</style>
</head>
<body ng-controller="indexCtrl" id="body">
	<div class="content">
		<div class="ocultar_menu">		
			<div class="header">
				<div class="lang_version">
	   				<img id="lang" src="images/esp_button.png">
	  			</div>
	   			<div id="title_main">Ibero-American Migration Patterns: more than just the U.S.</div>				
	  		</div>
			<hr class="header_line">
			<div class="title">
				While the greatest number of immigrants that left their country were Spaniards between 1960 and 2010, 4.4 million, the Argentinians received the largest influx of Ibero-American immigrants, around 7.1 million.
			</div>		
			<hr class="title_line">
		</div>
		<div class="contenido">
			<div class="modal" ng-show="modal">
				<div id="contenedor_instrucciones" ng-show="instrucciones">
					<div class="titulo_nota">
						<div>
						<br/>
						<i class="fa fa-times-circle-o" ng-click="acerca = false; modal = false;"></i>
						</div>
						<div class="tituloT">Instructions</div>
					</div>
					<p>
						The map currently represents the total number of immigrants that entered and left any of the Ibero-American countries in 2010. You can either move between years by clicking on them or if you're only interested in specific country-to-country migration movements you can do so by selecting them in the dropdown menus of origin and destiny. Afterwards, click on a country to compare the numbers.
					</p>
				</div>
				<div class="acerca" ng-show="acerca">
					<div class="titulo_nota">						
						<div>
						<br/>
						<i class="fa fa-times-circle-o" ng-click="acerca = false; modal = false;"></i>
						</div>
						<div class="tituloT">About this project</div>
						<!--p class="linea"></p-->
					</div>
					<p>
						Coming soon...
					</p>
				</div>
			</div>
			<div id="Origin" ng-click="show(1)" ng-class="{activo:menu == 1}">
				<p>Origin</p><i class="fa fa-caret-down"></i>
			</div>
			<div id="Destiny" ng-click="show(2)" ng-class="{activo:menu == 2}">
				<p>Destiny</p><i class="fa fa-caret-down"></i>
			</div>
			<div class="menu_paises">
				<div id="menu_origen" class="menu" ng-show="menu == 1">
					<div class="checkboxFive">
						<input id="All_O" type="checkbox" name="Todos">
						<label for="All_O"></label>All</div>
					<div class="checkboxFive" ng-repeat="pais in paises">
						<input class="check" id="{{pais.esp}}_O" type="checkbox" name="pais" ng-model="model_origin_esp[pais['esp'].split(' ')[0].split('á')[0].split('é')[0].split('í')[0].split('í')[0].split('ú')[0].split('ñ')[0]]">
						<label for="{{pais.esp}}_O"></label>{{pais.ing}}</div>
				</div>
				<div id="menu_destino" class="menu" ng-show="menu == 2">
					<div class="checkboxFive">
						<input id="All_D" type="checkbox" name="Todos">
						<label for="All_D"></label>All</div>
					<div class="checkboxFive" ng-repeat="pais in paises">
						<input class="check" id="{{pais.esp}}_D" type="checkbox" name="pais" ng-model="model_destiny_esp[pais['esp'].split(' ')[0].split('á')[0].split('é')[0].split('í')[0].split('í')[0].split('ú')[0].split('ñ')[0]]">
						<label for="{{pais_esp}}_D"></label>{{pais.ing}}</div>
				</div>
			</div>
			<div class="infoExtra">
	  			<div class="verInstrucciones" ng-click="instrucciones = true; modal = true;">HELP <img src="images/ayuda.png"></div>
	  			<div class="info_acerca" ng-click="acerca = true; modal = true;">INFO <img src="images/info.png"></div>
			</div>

			<svg height="50" width="700" id="time_line">
				<line id="line_1960" x1="0" y1="20" x2="50" y2="20" stroke="#A2A2A2" stroke-width="2.5"/>
				<line id="line_1970" x1="50" y1="20" x2="170" y2="20" stroke="#A2A2A2" stroke-width="2.5"/>
				<line id="line_1980" x1="170" y1="20" x2="290" y2="20" stroke="#A2A2A2" stroke-width="2.5"/>
				<line id="line_1990" x1="290" y1="20" x2="410" y2="20" stroke="#A2A2A2" stroke-width="2.5"/>
				<line id="line_2000" x1="410" y1="20" x2="530" y2="20" stroke="#A2A2A2" stroke-width="2.5"/>
				<line id="line_2010" x1="530" y1="20" x2="650" y2="20" stroke="#A2A2A2" stroke-width="2.5"/>
				<line id="line_beyond" x1="650" y1="20" x2="700" y2="20" stroke="#A2A2A2" stroke-width="2.5"/>
				<circle id="circle_1960" class="circle_year" cx="50" cy="20" r="5" stroke="#A2A2A2" stroke-width="3" fill="#A2A2A2"/>
				<circle id="circle_1970" class="circle_year" cx="170" cy="20" r="5" stroke="#A2A2A2" stroke-width="3" fill="#A2A2A2"/>
				<circle id="circle_1980" class="circle_year" cx="290" cy="20" r="5" stroke="#A2A2A2" stroke-width="3" fill="#A2A2A2"/>
				<circle id="circle_1990" class="circle_year" cx="410" cy="20" r="5" stroke="#A2A2A2" stroke-width="3" fill="#A2A2A2"/>
				<circle id="circle_2000" class="circle_year" cx="530" cy="20" r="5" stroke="#A2A2A2" stroke-width="3" fill="#A2A2A2"/>
				<circle id="circle_2010" class="circle_year" cx="650" cy="20" r="5" stroke="#A2A2A2" stroke-width="3" fill="#A2A2A2"/>
				<text id="text_1960" class="years" x="35" y="45" fill="#000000">1960</text>
				<text id="text_1970" class="years" x="155" y="45" fill="#000000">1970</text>
				<text id="text_1980" class="years" x="275" y="45" fill="#000000">1980</text>
				<text id="text_1990" class="years" x="395" y="45" fill="#000000">1990</text>
				<text id="text_2000" class="years" x="515" y="45" fill="#000000">2000</text>
				<text id="text_2010" class="years" x="635" y="45" fill="#000000">2010</text>
			</svg>
			
			<div id="tooltip_esp" ng-show="tooltip">
				<h3>{{select_ctry}} / {{select_year}}</h3>				
				<i class="fa fa-times-circle-o" ng-click="tooltip = false"></i>
				<div id="info_migration">
					<div ng-show="showEntraron" class="label">Entered the country</div>
					<div class="chart" ng-repeat="salida in select_destiny | limitTo:select_destiny_length" ng-show="salida.ctry_dest">
						<div class="cantidad2">{{salida.ctry_orig}}: {{agregarComas(salida['yr'+select_year])}}</div>
						<div class="barra">
							<div class="porcentaje" ng-style="{width:getwidth(salida['yr'+select_year])}"></div>
						</div>
					</div>

					<div ng-show="showSalieron" class="label">Left the country</div>
					<div class="chart" ng-repeat="entrada in select_origin | limitTo:select_origin_length" ng-show="entrada.ctry_orig">				
						<div class="cantidad2">{{entrada.ctry_dest}}: {{agregarComas(entrada['yr'+select_year])}}</div>
						<div class="barra">
							<div class="porcentaje" ng-style="{width:getwidth(entrada['yr'+select_year])}"></div>
						</div>
					</div>
				</div>				
				<img id="back_map" src="images/back_esp.png" ng-click="tooltip = false">
			</div>

			<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="686.001px" height="820.915px" viewBox="-20.573 155.716 686.001 820.915"	 enable-background="new -20.573 155.716 686.001 820.915" xml:space="preserve">
				<g id="MAPA">
					<g>
						<g>
							<path id="puert" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M414.762,282.893 415.583,284.947 411.075,286.996 
								404.92,286.996 403.278,284.535 404.508,282.484 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M228.513,303.816 233.021,295.611 234.664,284.947 
								232.201,282.893 230.971,283.302 228.513,287.405 225.638,288.226 225.228,303.816 			"/>
							<path id="cost" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M278.972,356.329 273.638,351.815 270.356,345.663 
								266.664,347.303 263.384,345.251 253.536,344.433 252.715,349.767 254.357,353.457 259.279,356.329 259.69,353.866 
								258.048,352.636 260.1,352.636 263.793,357.56 269.947,360.43 270.356,364.945 273.227,366.178 273.638,364.125 275.69,366.584 
								278.15,360.841 276.511,360.021 276.511,357.969 			"/>
							<path id="cub" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M322.458,255.409 326.561,258.278 334.767,260.331 
								334.767,263.612 341.33,264.021 347.074,268.124 337.636,270.996 319.176,270.996 318.355,270.584 323.688,265.661 
								315.482,264.021 310.561,257.048 300.716,255.818 295.383,252.125 283.896,251.306 282.665,249.664 285.944,248.021 
								284.305,247.201 277.741,247.201 274.047,250.076 269.126,251.306 263.793,254.585 260.92,253.764 263.793,252.945 
								265.024,248.021 269.126,245.561 279.79,242.276 286.356,242.276 298.664,243.922 304.408,248.843 310.973,249.664 
								315.894,253.355 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M315.894,250.076 318.767,251.716 318.767,253.355 
								317.537,253.355 310.561,248.021 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M277.329,253.764 278.15,257.048 274.46,257.458 
								275.69,253.764 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M366.353,270.996 367.997,276.738 366.353,282.072 
								366.765,286.587 368.816,289.868 374.56,283.302 376.611,285.765 384.407,282.893 392.613,284.535 394.252,281.663 
								390.558,278.38 384.816,277.56 387.279,275.917 382.763,275.099 381.125,272.639 374.972,270.584 			"/>
							<path id="salva" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M218.665,322.688 229.743,327.201 233.846,327.201 
								237.125,325.561 236.303,321.458 231.382,321.458 223.998,316.943 			"/>
							<path id="guate" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M232.612,305.459 228.513,303.816 225.228,303.816 
								225.638,288.226 212.102,288.226 211.689,292.329 206.768,291.51 212.919,297.253 214.971,302.586 207.586,302.998 
								202.253,311.201 201.023,315.303 208.407,321.049 218.665,322.688 223.998,316.943 225.638,314.895 225.228,312.432 
								232.201,307.507 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M356.508,278.792 358.15,280.841 355.277,280.023 
								354.458,278.792 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M358.15,269.354 359.379,270.175 357.743,269.766 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M366.353,270.996 367.997,276.738 366.353,282.072 
								366.765,286.587 363.482,284.947 358.562,286.174 351.998,284.535 349.945,286.587 345.845,282.893 345.845,282.072 
								361.431,282.484 361.84,280.841 358.562,278.792 358.15,273.869 353.226,272.227 357.333,270.175 362.25,272.227 			"/>
							<path id="hondu" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M273.638,312.432 266.664,306.688 259.279,303.816 
								232.612,305.459 232.201,307.507 225.228,312.432 225.638,314.895 223.998,316.943 231.382,321.458 236.303,321.458 
								237.125,325.561 239.176,325.561 240.819,328.843 243.279,328.021 245.331,325.97 245.742,322.688 249.021,322.688 
								250.252,319.816 253.536,321.049 258.46,317.764 261.33,313.662 265.433,315.303 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M323.278,282.893 329.434,284.947 330.663,287.405 
								326.97,286.996 323.278,288.635 318.767,288.226 313.431,284.123 317.125,282.072 			"/>
							<path id="mexic" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M162.46,218.893 146.05,213.563 141.127,202.896 
								134.974,195.92 132.511,188.945 125.947,182.381 116.102,183.203 111.589,190.587 102.563,184.845 99.69,180.33 98.051,174.997 
								86.154,164.33 71.382,164.33 71.382,168.434 49.229,169.254 18.872,155.716 0,157.355 4.924,163.921 9.846,177.869 
								11.076,177.458 12.309,183.612 18.051,186.484 25.436,195.508 24.615,202.074 18.051,201.253 18.051,202.483 29.539,210.69 
								31.587,211.099 32.82,209.05 34.051,212.329 39.383,216.022 41.026,220.537 40.205,229.15 43.486,229.15 54.562,238.998 
								58.668,245.561 62.359,243.1 62.771,239.818 56.616,233.252 54.975,234.073 53.332,233.252 45.949,211.92 43.896,210.69 
								44.308,213.15 43.486,212.329 32.409,192.23 30.36,191.818 28.717,188.124 23.384,183.612 21.745,179.921 18.051,162.691 
								24.205,167.203 27.487,167.203 32.409,170.894 36.102,181.972 43.486,193.869 49.229,200.023 53.332,200.841 54.562,206.175 
								65.231,214.383 63.18,218.893 64.41,221.356 66.871,220.537 66.871,222.995 72.203,224.637 75.076,227.101 75.488,230.792 
								83.282,236.946 87.793,243.509 93.539,248.021 97.64,259.51 95.587,263.612 97.23,265.661 93.948,266.894 95.587,272.227 
								100.103,275.917 107.897,280.433 111.999,284.535 123.896,287.405 131.28,293.971 149.331,299.304 157.127,303.816 
								169.437,307.098 178.869,302.586 182.151,302.177 191.175,305.459 201.023,315.303 202.253,311.201 207.586,302.998 
								214.971,302.586 212.919,297.253 206.768,291.51 211.689,292.329 212.102,288.226 225.638,288.226 228.513,287.405 
								230.971,283.302 232.201,282.893 233.846,280.023 235.074,280.023 234.664,282.484 236.716,286.174 239.176,275.917 
								237.946,274.69 239.176,273.459 237.946,272.639 244.921,259.51 243.279,257.048 239.176,256.228 237.125,257.869 
								237.125,255.818 234.664,255.409 216.204,260.331 212.51,275.917 208.407,278.38 208.816,280.841 206.356,282.484 
								199.793,280.433 183.381,284.947 178.869,281.663 173.536,280.023 169.845,276.738 166.973,270.175 160.819,261.563 
								161.228,257.048 157.127,251.306 157.537,240.636 155.894,229.15 158.358,223.407 162.46,221.766 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M16.411,199.611 15.591,198.793 16.411,196.742 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M38.153,190.587 39.796,188.945 40.205,192.639 
								38.153,192.23 			"/>
							<path id="nicar" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M270.356,345.663 269.126,341.558 273.638,312.432 
								265.433,315.303 261.33,313.662 258.46,317.764 253.536,321.049 250.252,319.816 249.021,322.688 245.742,322.688 
								245.331,325.97 243.279,328.021 240.819,328.843 239.176,328.843 239.176,329.661 253.536,344.433 263.384,345.251 
								266.664,347.303 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M285.944,372.328 284.714,374.383 286.356,375.199 			"/>
							<path id="panam" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M321.228,364.535 320.815,366.178 322.869,369.869 
								319.998,372.738 318.767,372.328 317.125,375.199 313.431,370.277 315.894,366.584 313.021,366.178 306.458,361.66 
								296.61,368.226 296.201,370.277 299.074,373.968 295.383,376.431 292.922,376.431 292.098,371.916 289.638,372.738 
								285.944,368.226 277.741,366.994 276.511,368.64 275.69,366.584 278.15,360.841 276.511,360.021 276.511,357.969 
								278.972,356.329 281.436,357.969 282.665,361.66 290.459,362.893 298.664,359.61 300.716,360.841 302.765,356.736 
								306.458,356.736 315.073,358.787 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M315.894,210.28 317.125,212.329 308.51,211.099 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M356.508,257.869 356.099,260.331 351.587,261.563 
								351.587,259.918 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M337.226,232.434 338.047,233.664 336.818,233.664 
								333.945,228.741 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M330.663,224.637 331.073,229.15 329.434,227.101 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M317.537,235.304 319.176,233.252 319.176,237.355 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M315.482,225.458 317.537,228.741 316.716,231.613 
								313.021,228.741 314.252,224.637 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M323.278,214.383 322.869,218.484 321.637,214.792 
								322.869,212.329 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M347.894,247.612 347.894,250.076 349.535,246.382 
								345.431,245.561 			"/>
							<path id="argen" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M506.25,647.197 511.583,648.02 513.633,653.76 
								512.407,660.739 505.022,664.426 481.225,689.455 479.172,692.323 477.125,714.888 474.663,725.555 475.075,731.3 
								484.504,738.273 482.868,743.609 485.329,747.71 488.614,748.115 487.792,755.916 482.458,763.294 481.225,766.993 
								477.534,769.862 453.739,775.193 445.536,774.785 443.483,773.146 443.483,778.067 445.536,780.535 442.663,786.683 
								443.483,793.662 441.84,796.123 437.329,798.578 431.584,798.578 422.151,793.247 420.096,795.298 421.739,808.015 
								425.842,812.12 429.124,811.708 427.483,809.652 431.584,808.015 432.407,810.068 433.225,813.761 431.995,816.22 
								427.893,816.22 425.43,813.351 421.739,815.402 427.483,819.091 422.151,821.552 420.096,824.837 420.096,833.86 
								416.819,837.967 417.225,841.248 411.893,841.248 406.969,844.118 401.227,852.323 400.817,854.783 403.278,859.296 
								407.377,864.223 415.174,865.451 415.999,870.787 413.946,877.758 401.227,888.833 398.766,899.909 394.665,901.962 
								392.202,897.864 393.435,902.785 388.918,906.479 386.047,914.268 388.097,913.86 389.331,920.019 386.458,920.838 
								389.331,922.072 394.665,930.271 383.176,926.987 364.304,926.169 362.663,922.889 362.25,909.763 354.458,910.99 
								354.047,902.785 355.277,895.403 360.611,886.375 362.25,880.629 361.84,872.428 367.583,860.119 367.997,846.988 
								369.638,842.476 365.538,838.378 370.458,836.735 369.638,834.685 365.945,833.86 366.353,828.53 364.304,813.351 
								367.583,805.964 365.538,800.218 366.765,787.091 370.045,775.608 372.506,771.095 371.689,763.294 372.099,752.223 
								377.021,746.07 376.611,737.858 382.355,727.198 381.125,719.401 376.611,703.405 377.021,699.3 381.125,690.273 
								381.947,681.247 384.816,670.173 388.508,666.069 390.15,661.966 394.665,659.098 392.613,646.789 393.435,637.765 
								403.278,633.247 404.92,626.688 403.69,622.99 411.893,613.966 414.762,616.835 423.79,618.068 427.073,621.354 429.124,616.016 
								436.506,616.431 440.204,618.482 442.663,618.886 454.967,632.836 464.817,634.888 479.584,645.146 480.405,648.02 
								475.075,657.454 475.075,660.739 482.868,661.966 487.792,664.426 497.223,663.2 505.022,655.402 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M426.25,963.913 432.407,963.498 426.25,965.555 
								425.022,965.555 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M392.202,934.784 392.613,965.555 397.122,963.913 
								411.075,967.605 417.637,966.375 420.917,963.089 413.125,961.043 398.356,949.144 393.435,941.762 396.303,940.938 			"/>
							<path id="boliv" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M384.407,577.864 388.097,581.557 388.918,589.354 
								392.613,592.224 392.613,596.735 390.97,597.968 390.558,600.43 394.665,606.577 397.536,622.581 403.69,622.99 411.893,613.966 
								414.762,616.835 423.79,618.068 427.073,621.354 429.124,616.016 436.506,616.431 440.204,618.482 442.663,610.273 
								442.663,604.532 446.764,596.327 462.764,592.224 469.333,592.224 473.02,593.867 477.534,599.612 479.172,598.788 
								480.817,582.375 478.356,576.221 475.075,574.994 475.075,567.608 461.124,566.788 458.25,558.582 459.891,553.662 
								455.79,545.045 452.506,543.405 447.586,543.405 444.301,540.535 437.329,538.893 435.28,536.017 425.43,534.38 420.096,530.688 
								418.047,525.76 419.28,516.327 417.637,512.223 407.792,513.451 400.817,520.428 394.252,523.708 383.997,522.481 
								390.97,534.789 388.918,538.479 388.918,551.604 386.458,553.662 388.097,557.764 386.047,560.633 386.047,563.913 
								388.918,568.841 383.997,575.812 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M556.299,436.741 555.483,440.839 550.969,446.583 
								544.809,448.636 539.073,446.998 538.663,437.969 541.124,436.332 552.608,435.508 			"/>
							<path id="brazi" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M506.25,647.197 511.583,648.02 513.633,653.76 
								512.407,660.739 505.022,664.426 481.225,689.455 487.792,688.628 493.125,693.148 493.948,696.841 497.631,695.199 
								501.327,699.3 511.997,705.866 513.633,709.967 517.739,713.247 514.458,717.349 515.276,723.094 522.665,714.888 
								524.301,709.143 534.149,701.354 540.303,692.323 544.403,682.066 553.432,672.223 554.665,663.2 555.483,661.966 
								554.254,659.506 553.432,652.125 556.709,645.964 569.842,633.656 586.249,626.688 587.483,623.814 605.946,622.99 
								607.583,620.119 614.151,615.199 615.788,609.043 625.223,593.867 626.868,583.196 630.153,578.279 632.2,563.094 
								630.969,551.604 632.608,541.352 638.762,538.069 645.327,525.76 653.532,518.383 662.143,507.302 665.428,491.71 
								663.377,480.634 660.508,476.531 647.792,474.894 628.504,459.3 624.809,458.069 608.815,458.069 595.688,453.147 
								588.303,456.433 589.534,452.737 586.249,451.914 587.483,449.868 585.022,446.583 581.327,448.227 580.098,444.942 
								566.965,440.019 559.174,440.429 556.299,446.583 552.2,448.227 548.915,454.379 548.502,449.044 532.506,449.868 
								531.684,451.095 532.092,448.636 538.252,448.636 538.252,444.532 536.202,442.89 537.844,440.839 532.917,444.123 
								532.092,437.969 542.764,426.484 544.403,421.558 540.303,419.916 534.559,402.686 532.092,400.634 530.868,401.867 
								523.485,413.767 518.557,417.454 511.174,418.272 507.483,415.818 503.377,414.175 496.815,414.994 495.584,419.506 
								491.073,419.096 485.329,418.272 473.43,424.023 468.096,422.381 465.225,419.916 465.225,416.227 463.176,414.175 
								464.407,405.152 466.456,403.1 465.225,398.583 462.354,397.759 461.946,392.844 457.02,392.844 454.559,397.349 437.739,403.51 
								423.79,399.816 424.204,402.686 427.893,405.152 427.483,409.658 428.303,414.994 435.28,415.408 435.28,417.045 
								429.944,419.096 427.483,422.381 416.819,428.121 410.665,428.121 406.563,424.023 404.92,425.25 401.635,418.272 
								397.536,419.916 395.482,418.272 394.665,420.325 382.355,420.325 382.763,425.666 386.458,426.075 388.097,429.763 
								380.715,430.173 380.715,435.917 384.407,438.788 386.047,444.532 381.125,467.505 367.997,471.202 361.431,475.297 
								356.508,481.867 356.099,487.203 353.226,488.839 350.355,495.409 352.408,501.148 357.743,506.483 357.333,510.171 
								361.84,510.583 363.896,514.276 367.997,514.684 377.021,509.355 377.021,522.481 378.252,523.708 383.997,522.481 
								394.252,523.708 400.817,520.428 407.792,513.451 417.637,512.223 419.28,516.327 418.047,525.76 420.096,530.688 425.43,534.38 
								435.28,536.017 437.329,538.893 444.301,540.535 447.586,543.405 452.506,543.405 455.79,545.045 459.891,553.662 
								458.25,558.582 461.124,566.788 475.075,567.608 475.075,574.994 478.356,576.221 480.817,582.375 479.172,598.788 
								477.534,599.612 479.172,616.016 485.739,618.068 491.483,616.835 495.995,618.482 498.87,631.609 507.483,632.02 
								507.889,637.35 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M538.663,436.741 534.967,440.429 534.149,438.377 
								536.202,435.917 538.663,434.69 537.018,436.332 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M548.094,434.69 546.049,435.508 547.278,433.452 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M541.946,430.583 540.303,431.814 541.124,433.866 
								544.809,434.275 			"/>
							<path id="chil" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M376.611,583.196 379.072,598.373 379.892,611.918 
								378.665,623.404 376.202,627.091 377.021,644.328 374.972,649.254 374.972,658.273 368.816,677.145 370.045,686.583 
								367.583,690.273 366.765,693.556 368.816,710.787 367.583,723.094 357.333,751.808 355.277,751.808 355.687,756.735 
								351.998,758.374 351.998,771.095 354.047,780.939 351.587,785.042 349.945,801.043 353.638,805.145 357.333,802.686 
								362.663,803.503 358.562,807.198 361.431,807.607 361.84,812.528 360.611,810.886 359.379,811.708 360.611,813.761 
								358.562,815.402 359.379,818.273 356.508,823.608 358.15,827.296 355.277,831.4 359.379,834.271 359.792,838.378 
								354.047,841.248 354.047,844.118 356.099,845.346 353.226,846.577 352.408,848.226 355.687,846.988 353.638,849.043 
								355.277,849.455 352.408,851.096 351.998,854.783 354.458,852.323 353.638,855.199 350.355,858.477 350.355,855.199 
								349.125,857.245 347.484,856.426 348.306,854.375 347.074,851.096 340.921,851.096 342.97,854.783 336.818,858.886 
								335.997,861.76 338.047,863.404 337.636,860.534 339.69,859.296 343.382,861.76 347.074,861.352 349.125,864.223 
								347.894,865.451 349.125,866.683 345.431,869.139 349.125,870.787 348.306,873.248 350.355,872.428 354.047,878.167 
								347.894,876.525 347.484,878.992 345.021,875.707 345.845,881.042 349.945,880.629 351.175,883.094 347.074,881.862 
								347.074,893.345 350.355,889.653 349.535,893.754 350.355,895.812 347.074,897.041 344.199,902.376 349.945,906.888 
								347.894,908.121 348.306,909.763 351.175,909.763 351.587,910.99 348.306,911.814 348.306,914.683 351.998,918.373 
								353.226,926.578 354.458,926.987 353.638,920.838 356.099,926.578 357.333,924.528 356.099,922.474 359.792,923.298 
								357.333,920.423 361.431,923.298 359.792,926.169 361.84,929.862 359.379,933.965 368.816,933.965 372.506,937.653 
								370.458,941.348 364.304,945.457 363.896,943.404 362.663,943.808 363.482,947.092 367.997,949.961 372.506,949.961 
								374.56,936.425 387.279,929.039 394.665,930.271 383.176,926.987 364.304,926.169 362.663,922.889 362.25,909.763 
								354.458,910.99 354.047,902.785 355.277,895.403 360.611,886.375 362.25,880.629 361.84,872.428 367.583,860.119 
								367.997,846.988 369.638,842.476 365.538,838.378 370.458,836.735 369.638,834.685 365.945,833.86 366.353,828.53 
								364.304,813.351 367.583,805.964 365.538,800.218 366.765,787.091 370.045,775.608 372.506,771.095 371.689,763.294 
								372.099,752.223 377.021,746.07 376.611,737.858 382.355,727.198 381.125,719.401 376.611,703.405 377.021,699.3 
								381.125,690.273 381.947,681.247 384.816,670.173 388.508,666.069 390.15,661.966 394.665,659.098 392.613,646.789 
								393.435,637.765 403.278,633.247 404.92,626.688 403.69,622.99 397.536,622.581 394.665,606.577 390.558,600.43 390.97,597.968 
								392.613,596.735 392.613,592.224 388.918,589.354 388.097,581.557 384.407,577.864 382.355,581.557 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M392.202,934.784 386.87,934.375 386.047,932.329 
								383.176,935.602 377.838,936.425 380.304,938.477 377.838,939.296 377.838,943.808 386.87,945.041 380.304,949.553 
								381.125,955.298 386.458,957.758 380.304,956.117 379.892,957.349 381.125,958.167 379.892,959.4 373.741,954.065 
								375.792,957.758 370.045,959.809 370.458,962.271 374.56,962.271 374.15,964.322 388.918,966.375 392.613,965.555 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M378.252,970.476 376.202,968.424 378.252,968.424 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M376.611,947.092 378.252,953.655 376.202,954.065 
								377.838,955.713 374.56,953.655 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M365.945,951.191 372.918,956.941 364.304,955.298 
								363.896,952.013 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M351.998,944.631 358.15,945.457 363.482,950.787 
								361.84,954.065 357.743,954.888 354.458,952.832 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M343.382,936.425 356.099,944.631 345.021,939.296 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M351.175,932.329 349.945,935.199 349.535,932.733 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M352.408,929.039 356.099,928.22 357.333,930.682 
								358.562,926.578 360.202,930.271 357.743,934.784 361.431,938.477 364.713,935.199 368.816,935.602 369.638,937.653 
								361.431,942.58 361.431,945.86 360.202,945.457 356.099,941.762 359.379,941.762 358.15,938.886 354.458,939.705 
								351.998,936.425 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M351.175,920.019 351.587,922.474 349.945,918.373 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M348.306,922.072 349.945,924.528 347.894,923.298 
								347.484,920.838 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M341.742,918.787 343.791,915.087 344.199,918.373 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M345.431,912.632 345.021,915.087 343.791,915.087 
								342.152,908.53 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M345.431,909.348 343.382,905.655 347.074,908.53 
								347.894,910.582 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M337.636,904.012 342.152,903.604 341.33,906.479 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M336.818,897.041 337.636,895.812 339.279,898.271 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M340.921,887.607 342.152,883.917 345.021,887.197 
								344.199,901.143 342.152,899.505 342.152,894.17 338.867,891.705 340.921,892.118 339.279,889.653 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M337.226,883.094 337.636,881.447 338.867,883.503 
								337.226,885.146 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M337.226,877.758 338.047,876.525 340.1,883.094 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M346.253,873.248 343.791,871.61 345.021,870.787 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M347.484,842.066 350.355,841.248 351.175,844.118 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M356.099,833.86 358.15,835.503 357.743,838.378 
								354.047,839.606 352.408,835.917 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M349.945,804.323 351.998,805.964 353.638,811.708 
								351.175,814.174 352.408,816.635 351.587,816.635 352.408,820.325 351.175,820.325 350.355,823.194 346.253,822.375 
								345.845,820.325 347.894,807.198 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M381.947,968.015 381.125,965.963 386.87,967.197 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M381.947,969.25 394.252,966.375 395.482,968.424 
								390.15,968.015 396.303,970.068 393.435,971.705 396.711,972.527 398.356,976.631 389.331,970.476 386.87,971.3 389.331,974.573 
								386.458,974.168 384.407,971.705 386.458,969.658 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M396.711,967.197 404.508,966.375 405.331,969.658 
								400.407,970.476 397.122,969.658 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M207.586,436.741 207.998,438.377 206.356,438.377 			"/>
							<path id="ecuad" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M338.047,435.508 331.894,431.814 330.663,432.632 
								322.458,432.632 319.176,428.53 309.329,423.608 299.486,428.53 299.486,433.452 297.022,440.429 293.741,442.89 
								293.741,453.147 297.843,456.017 300.716,452.329 301.944,455.199 301.126,459.3 297.022,462.585 298.253,465.455 
								295.383,467.505 296.201,471.202 299.486,470.377 303.174,471.202 304.819,474.894 307.689,474.48 310.561,472.429 
								310.973,466.275 313.021,462.996 315.073,462.996 315.894,460.125 327.382,455.199 334.767,448.227 338.047,442.481 
								339.279,442.481 335.997,436.741 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M218.256,438.377 217.025,440.429 215.792,440.019 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M213.331,435.917 212.51,437.561 214.15,437.969 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M208.407,433.452 212.102,440.839 208.816,443.708 
								207.586,440.839 209.229,438.377 206.768,434.69 			"/>
							<path id="guiana" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M507.483,415.818 509.944,413.356 511.174,405.152 
								508.301,399.816 507.889,394.479 511.174,390.383 512.407,389.15 522.252,393.252 528.819,398.583 530.868,401.867 
								523.485,413.767 518.557,417.454 511.174,418.272 			"/>
							<path id="guyana" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M457.02,392.844 452.098,385.047 453.739,380.535 
								458.663,377.25 456.2,376.84 456.2,372.738 463.176,369.044 463.997,367.817 466.045,367.817 473.02,373.15 474.663,379.302 
								480.817,380.943 486.559,387.507 483.276,394.479 479.172,395.304 477.534,401.458 481.635,407.197 484.504,408.016 
								487.381,414.994 491.073,419.096 485.329,418.272 473.43,424.023 468.096,422.381 465.225,419.916 465.225,416.227 
								463.176,414.175 464.407,405.152 466.456,403.1 465.225,398.583 462.354,397.759 461.946,392.844 			"/>
							<path id="parag" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M477.534,599.612 473.02,593.867 469.333,592.224 
								462.764,592.224 446.764,596.327 442.663,604.532 442.663,610.273 440.204,618.482 442.663,618.886 454.967,632.836 
								464.817,634.888 479.584,645.146 480.405,648.02 475.075,657.454 475.075,660.739 482.868,661.966 487.792,664.426 
								497.223,663.2 505.022,655.402 506.25,647.197 507.889,637.35 507.483,632.02 498.87,631.609 495.995,618.482 491.483,616.835 
								485.739,618.068 479.172,616.016 			"/>
							<path id="per" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M384.407,577.864 382.355,581.557 376.611,583.196 
								362.25,571.3 350.355,566.788 339.279,559.406 329.842,550.376 329.434,542.171 319.176,526.993 309.329,501.558 304.819,497.46 
								300.716,489.249 291.278,481.867 292.922,478.993 291.278,476.946 290.047,469.559 297.022,462.585 298.253,465.455 
								295.383,467.505 296.201,471.202 299.486,470.377 303.174,471.202 304.819,474.894 307.689,474.48 310.561,472.429 
								310.973,466.275 313.021,462.996 315.073,462.996 315.894,460.125 327.382,455.199 334.767,448.227 338.047,442.481 
								339.279,442.481 335.997,436.741 338.047,435.508 342.152,436.332 347.894,442.89 351.175,444.123 352.408,448.636 
								355.277,449.044 356.508,454.379 362.25,454.789 365.945,452.737 370.458,453.965 372.918,452.737 379.072,455.199 
								380.715,458.069 376.202,465.041 381.125,467.505 367.997,471.202 361.431,475.297 356.508,481.867 356.099,487.203 
								353.226,488.839 350.355,495.409 352.408,501.148 357.743,506.483 357.333,510.171 361.84,510.583 363.896,514.276 
								367.997,514.684 377.021,509.355 377.021,522.481 378.252,523.708 383.997,522.481 390.97,534.789 388.918,538.479 
								388.918,551.604 386.458,553.662 388.097,557.764 386.047,560.633 386.047,563.913 388.918,568.841 383.997,575.812 			"/>
							<path id="suriname" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M491.073,419.096 487.381,414.994 484.504,408.016 
								481.635,407.197 477.534,401.458 479.172,395.304 483.276,394.479 486.559,387.507 503.377,386.688 511.174,388.331 
								511.174,390.383 507.889,394.479 508.301,399.816 511.174,405.152 509.944,413.356 507.483,415.818 503.377,414.175 
								496.815,414.994 495.584,419.506 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M454.559,347.712 452.918,352.636 446.764,353.457 
								450.045,350.584 448.817,347.712 			"/>
							<path id="urugu" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M481.225,689.455 487.792,688.628 493.125,693.148 
								493.948,696.841 497.631,695.199 501.327,699.3 511.997,705.866 513.633,709.967 517.739,713.247 514.458,717.349 
								515.276,723.094 509.534,731.709 503.377,734.585 492.713,733.761 484.504,730.072 478.764,729.658 474.663,725.555 
								477.125,714.888 479.172,692.323 			"/>
							<path id="venez" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M370.458,338.278 365.945,339.918 360.202,346.072 
								354.047,360.43 358.15,360.43 361.84,368.226 362.25,374.383 365.538,376.84 370.045,378.075 376.611,376.84 380.715,378.483 
								386.458,385.456 401.635,384.637 398.356,397.349 399.584,401.867 403.278,407.606 399.176,412.124 402.868,415.818 
								406.563,424.023 410.665,428.121 416.819,428.121 427.483,422.381 429.944,419.096 435.28,417.045 435.28,415.408 
								428.303,414.994 427.483,409.658 427.893,405.152 424.204,402.686 423.79,399.816 437.739,403.51 454.559,397.349 
								457.02,392.844 452.098,385.047 453.739,380.535 458.663,377.25 456.2,376.84 456.2,372.738 463.176,369.044 463.997,367.817 
								460.711,364.945 457.842,366.584 454.559,366.178 456.2,364.125 454.559,358.787 448.405,355.508 443.483,355.508 
								441.432,351.815 438.559,350.584 445.944,348.124 429.124,348.124 427.893,348.533 431.584,349.767 420.917,352.227 
								416.819,352.227 412.713,348.533 397.536,349.767 394.665,343.612 384.816,341.558 381.947,335.406 379.072,339.509 
								382.763,340.327 383.176,341.558 374.56,343.612 369.638,347.303 369.638,350.584 372.506,355.508 372.918,358.787 
								368.404,361.66 365.538,356.329 365.538,353.457 368.404,347.712 366.353,340.327 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M430.356,344.021 431.584,345.663 429.944,346.481 
								427.073,345.251 			"/>
							<path id="colom" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M317.125,375.199 318.767,372.328 319.998,372.738 
								322.869,369.869 320.815,366.178 321.228,364.535 325.74,369.869 325.74,364.535 335.175,357.56 335.587,349.767 
								340.921,345.663 344.199,345.663 345.021,347.303 347.484,343.2 355.277,342.379 362.663,339.1 364.713,335.815 367.997,333.764 
								371.689,335.815 370.458,338.278 365.945,339.918 360.202,346.072 354.047,360.43 358.15,360.43 361.84,368.226 362.25,374.383 
								365.538,376.84 370.045,378.075 376.611,376.84 380.715,378.483 386.458,385.456 401.635,384.637 398.356,397.349 
								399.584,401.867 403.278,407.606 399.176,412.124 402.868,415.818 406.563,424.023 404.92,425.25 401.635,418.272 
								397.536,419.916 395.482,418.272 394.665,420.325 382.355,420.325 382.763,425.666 386.458,426.075 388.097,429.763 
								380.715,430.173 380.715,435.917 384.407,438.788 386.047,444.532 381.125,467.505 376.202,465.041 380.715,458.069 
								379.072,455.199 372.918,452.737 370.458,453.965 365.945,452.737 362.25,454.789 356.508,454.379 355.277,449.044 
								352.408,448.636 351.175,444.123 347.894,442.89 342.152,436.332 338.047,435.508 331.894,431.814 330.663,432.632 
								322.458,432.632 319.176,428.53 309.329,423.608 308.51,421.558 311.382,419.916 311.792,414.175 319.176,412.124 
								319.998,408.839 324.919,403.51 320.815,403.1 321.228,382.172 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M450.458,299.713 447.997,300.943 447.997,303.816 
								452.098,301.353 			"/>
							<path fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M452.506,313.252 454.967,316.943 453.739,316.943 			"/>
							<polyline fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M254.357,336.224 259.279,339.918 260.92,344.021 
								254.357,342.379 252.715,336.224 254.357,336.224 			"/>
					</g>
					<path id="espan" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M113.136,612.143 129.735,624.794 147.134,627.954 
						154.239,625.584 161.358,627.954 164.522,632.7 166.101,630.329 172.429,633.489 189.028,632.7 192.183,635.072 188.239,645.348 
						153.452,665.902 136.063,694.359 137.651,702.266 143.958,706.215 142.382,709.378 134.478,716.494 129.735,729.93 
						121.04,730.719 109.97,745.742 73.616,746.536 57.017,759.971 47.522,756.024 38.827,740.206 26.181,737.047 25.394,729.143 
						33.298,721.237 28.546,711.754 31.712,701.471 26.97,689.618 34.874,683.289 34.087,676.971 35.663,661.154 44.36,649.297 
						41.202,642.977 17.487,643.766 15.112,639.018 4.04,645.348 6.417,634.279 4.04,635.072 2.464,631.119 4.04,627.166 
						-3.077,620.055 1.675,614.514 10.368,613.725 14.321,605.819 		"/>
					<path id="portu" fill="#DCE3E5" stroke="#FFFFFF" stroke-width="1.5" d="M4.04,645.348 6.417,662.736 -5.442,707.008 -0.702,713.33 
						6.417,711.754 3.251,740.206 26.181,737.047 25.394,729.143 33.298,721.237 28.546,711.754 31.712,701.471 26.97,689.618 
						34.874,683.289 34.087,676.971 35.663,661.154 44.36,649.297 41.202,642.977 17.487,643.766 15.112,639.018 		"/>
					</g>
				</g>

				<rect class="origen" id="CHL_O" ng-show="model_origin_esp.Chile" x="357.694" y="661.732" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="39.066" height="39.069"/>
				<rect id="CHL_D" ng-show="model_destiny_esp.Chile" x="357.694" y="661.732" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="39.066" height="39.069"/>
				<g>
					<text id="CHL_T" ng-show="(model_destiny_esp.Chile || model_origin_esp.Chile) && todos" x="366.5542" y="684.5742" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">CHL</text>
				</g>
				<rect class="origen" id="BRA_O" ng-show="model_origin_esp.Brasil" x="521.504" y="505.736" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="78.135" height="78.138"/>
				<rect id="BRA_D" ng-show="model_destiny_esp.Brasil" x="521.504" y="505.736" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="78.135" height="78.138"/>
				<g>
					<text id="BRA_T" ng-show="(model_destiny_esp.Brasil || model_origin_esp.Brasil) && todos" x="549.5464" y="548.1113" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">BRA</text>
				</g>
				<rect class="origen" id="BOL_O" ng-show="model_origin_esp.Bolivia" x="397.02" y="553.822" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="60.104" height="60.104"/>
				<rect id="BOL_D" ng-show="model_destiny_esp.Bolivia" x="397.02" y="553.822" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="60.104" height="60.104"/>
				<g>
					<text id="BOL_T" ng-show="(model_destiny_esp.Bolivia || model_origin_esp.Bolivia) && todos" x="416.8374" y="587.0869" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">BOL</text>
				</g>
				<rect class="origen" id="ARG_O" ng-show="model_origin_esp.Argentina" x="355.901" y="700.802" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="138.24" height="138.24"/>
				<rect id="ARG_D" ng-show="model_destiny_esp.Argentina" x="355.901" y="700.802" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="138.24" height="138.24"/>
				<g>
					<text id="ARG_T" ng-show="(model_destiny_esp.Argentina || model_origin_esp.Argentina) && todos" x="413.7544" y="773.2285" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">ARG</text>
				</g>
				<rect class="origen" id="COL_O" ng-show="model_origin_esp.Colombia" x="291.421" y="343.606" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="132.23" height="132.229"/>
				<rect id="COL_D" ng-show="model_destiny_esp.Colombia" x="291.421" y="343.606" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="132.23" height="132.229"/>
				<g>
					<text id="COL_T" ng-show="(model_destiny_esp.Colombia || model_origin_esp.Colombia) && todos" x="350.1245" y="413.0288" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">COL</text>
				</g>
				<rect class="origen" id="CUB_O" ng-show="model_origin_esp.Cuba" x="307.111" y="259.711" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="31.515" height="31.512"/>
				<rect id="CUB_D" ng-show="model_destiny_esp.Cuba" x="307.111" y="259.711" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="31.515" height="31.512"/>
				<g>
					<text id="CUB_T" ng-show="(model_destiny_esp.Cuba || model_origin_esp.Cuba) && todos" x="312.1484" y="278.6816" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">CUB</text>
				</g>
				<rect class="origen" id="DOM_O" ng-show="model_origin_esp.Rep" x="354.704" y="266.248" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="31.512" height="31.515"/>
				<rect id="DOM_D" ng-show="model_destiny_esp.Rep" x="354.704" y="266.248" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="31.512" height="31.515"/>
				<g>
					<text id="DOM_T" ng-show="(model_destiny_esp.Rep || model_origin_esp.Rep) && todos" x="357.5073" y="287.7861" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">DOM</text>
				</g>
				<rect class="origen" id="CRI_O" ng-show="model_origin_esp.Costa" x="214.586" y="351.287" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="45.079" height="45.08"/>
				<rect id="CRI_D" ng-show="model_destiny_esp.Costa" x="214.586" y="351.287" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="45.079" height="45.08"/>
				<g>
					<text id="CRI_T" ng-show="(model_destiny_esp.Costa || model_origin_esp.Costa) && todos" x="228.4429" y="377.0405" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">CRI</text>
				</g>
				<rect class="origen" id="ECU_O" ng-show="model_origin_esp.Ecuador" x="278.972" y="418.162" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="63.11" height="63.109"/>
				<rect id="ECU_D" ng-show="model_destiny_esp.Ecuador" x="278.972" y="418.162" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="63.11" height="63.109"/>
				<g>
					<text id="ECU_T" ng-show="(model_destiny_esp.Ecuador || model_origin_esp.Ecuador) && todos" x="300.1064"  y="452.9326" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">ECU</text>
				</g>
				<rect class="origen" id="SLV_O" ng-show="model_origin_esp.El" x="213.552" y="323.577" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="23.351" height="23.354"/>
				<rect id="SLV_D" ng-show="model_destiny_esp.El" x="213.552" y="323.577" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="23.351" height="23.354"/>
				<g>
					<text id="SLV_T" ng-show="(model_destiny_esp.El || model_origin_esp.El) && todos" x="215.9009" y="338.4697" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">SLV</text>
				</g>
				<rect class="origen" id="GTM_O" ng-show="model_origin_esp.Guatemala" x="181.491" y="306.883" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="26.173" height="26.171"/>
				<rect id="GTM_D" ng-show="model_destiny_esp.Guatemala" x="181.491" y="306.883" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="26.173" height="26.171"/>
				<g>
					<text id="GTM_T" ng-show="(model_destiny_esp.Guatemala || model_origin_esp.Guatemala) && todos" x="182.7744" y="323.1826" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">GTM</text>
				</g>
				<rect class="origen" id="HND_O" ng-show="model_origin_esp.Honduras" x="210.98" y="291.478" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="28.495" height="28.49"/>
				<rect id="HND_D" ng-show="model_destiny_esp.Honduras" x="210.98" y="291.478" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="28.495" height="28.49"/>
				<g>
					<text id="HND_T" ng-show="(model_destiny_esp.Honduras || model_origin_esp.Honduras) && todos" x="213.2646" y="308.2407" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">HND</text>
				</g>
				<rect class="origen" id="MEX_O" ng-show="model_origin_esp.M" x="114.483" y="235.112" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="31.155" height="31.151"/>
				<rect id="MEX_D" ng-show="model_destiny_esp.M" x="114.483" y="235.112" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="31.155" height="31.151"/>
				<g>
					<text id="MEX_T" ng-show="(model_origin_esp.M || model_destiny_esp.M) && todos" x="118.5371" y="253.9023" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">MEX</text>
				</g>
				<rect class="origen" id="NIC_O" ng-show="model_origin_esp.Nicaragua" x="245.426" y="293.791" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="45.079" height="45.077"/>
				<rect id="NIC_D" ng-show="model_destiny_esp.Nicaragua" x="245.426" y="293.791" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="45.079" height="45.077"/>
				<g>
					<text id="NIC_T" ng-show="(model_destiny_esp.Nicaragua || model_origin_esp.Nicaragua) && todos" x="259.0039" y="319.543" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">NIC</text>
				</g>
				<rect class="origen" id="VEN_O" ng-show="model_origin_esp.Venezuela" x="375.568" y="330.528" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="96.167" height="96.167"/>
				<rect id="VEN_D" ng-show="model_destiny_esp.Venezuela" x="375.568" y="330.528" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="96.167" height="96.167"/>
				<g>
					<text id="VEN_T" ng-show="(model_destiny_esp.Venezuela || model_origin_esp.Venezuela) && todos" x="413.0347" y="381.8262" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">VEN</text>
				</g>
				<rect class="origen" id="URY_O" ng-show="model_origin_esp.Uruguay" x="479.09" y="710.351" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="30.525" height="30.525"/>
				<rect id="URY_D" ng-show="model_destiny_esp.Uruguay" x="479.09" y="710.351" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="30.525" height="30.525"/>
				<g>
					<text id="URY_T" ng-show="(model_destiny_esp.Uruguay || model_origin_esp.Uruguay) && todos" x="482.9819" y="729.0635" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11.8075">URY</text>
				</g>
				<rect class="origen" id="PRI_O" ng-show="model_origin_esp.Puerto" x="397.815" y="275.631" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="30.439" height="30.443"/>
				<rect id="PRI_D" ng-show="model_destiny_esp.Puerto" x="397.815" y="275.631" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="30.439" height="30.443"/>
				<g>
					<text id="PRI_T" ng-show="(model_destiny_esp.Puerto || model_origin_esp.Puerto) && todos" x="404.312" y="294.0684" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">PRI</text>
				</g>
				<rect class="origen" id="PRT_O" ng-show="model_origin_esp.Portugal" x="-20.573" y="664.894" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="60.104" height="60.104"/>
				<rect id="PRT_D" ng-show="model_destiny_esp.Portugal" x="-20.573" y="664.894" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="60.104" height="60.104"/>
				<g>
					<text id="PRT_T" ng-show="(model_destiny_esp.Portugal || model_origin_esp.Portugal) && todos" x="-1.0713" y="698.252" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">PRT</text>
				</g>
				<rect class="origen" id="PER_O" ng-show="model_origin_esp.Per" x="338.046" y="528.941" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="48.082" height="48.083"/>
				<rect id="PER_D" ng-show="model_destiny_esp.Per" x="338.046" y="528.941" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="48.082" height="48.083"/>
				<g>
					<text id="PER_T" ng-show="(model_destiny_esp.Per || model_origin_esp.Per) && todos" x="351.4097" y="556.2891" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">PER</text>
				</g>
				<rect class="origen" id="PRY_O" ng-show="model_origin_esp.Paraguay" x="458.278" y="616.654" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="45.078" height="45.078"/>
				<rect id="PRY_D" ng-show="model_destiny_esp.Paraguay" x="458.278" y="616.654" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="45.078" height="45.078"/>
				<g>
					<text id="PRY_T" ng-show="(model_destiny_esp.Paraguay || model_origin_esp.Paraguay) && todos" x="470.4204" y="642.4072" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">PRY</text>
				</g>
				<rect class="origen" id="PAN_O" ng-show="model_origin_esp.Panam" x="264.015" y="347.712" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="23.351" height="23.349"/>
				<rect id="PAN_D" ng-show="model_destiny_esp.Panam" x="264.015" y="347.712" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="23.351" height="23.349"/>
				<g>
					<text id="PAN_T" ng-show="(model_destiny_esp.Panam || model_origin_esp.Panam) && todos" x="265.1572" y="362.6016" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">PAN</text>
				</g>
				<rect class="origen" id="ESP_O" ng-show="model_origin_esp.Espa" x="7.733" y="548.869" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="243.736" height="243.737"/>
				<rect id="ESP_D" ng-show="model_destiny_esp.Espa" x="7.733" y="548.869" fill="none" stroke="#1D1E3D" stroke-miterlimit="10" width="243.736" height="243.737"/>
				<g>
					<text id="ESP_T" ng-show="(model_destiny_esp.Espa || model_origin_esp.Espa)  && todos" x="124.0581" y="673.4189" fill="#1D1D1B" font-family="'Roboto-Regular'" font-size="11">ESP</text>
				</g>
				<g>
					<g>
						<path fill="#F9F9F9" d="M-15.255,626.692c1.936,0,1.936-3,0-3S-17.188,626.692-15.255,626.692L-15.255,626.692z"/>
					</g>
				</g>
				<!--<g id="Capa_4" display="none">
					<rect x="-11.867" y="1020.91" display="inline" fill="#FFFFFF" width="686.905" height="72.806"/>
					<g display="inline">
						<rect x="4.792" y="1034.363" fill="#1D1E3D" width="45.899" height="45.898"/>
						<rect x="35.995" y="1034.363" fill="#242347" width="45.898" height="45.898"/>
						<rect x="67.196" y="1034.363" fill="#2B2752" width="45.9" height="45.898"/>
						<rect x="98.399" y="1034.363" fill="#322C5C" width="45.899" height="45.898"/>
						<rect x="129.602" y="1034.363" fill="#3A3168" width="45.9" height="45.898"/>
						<rect x="160.804" y="1034.363" fill="#423774" width="45.899" height="45.898"/>
						<rect x="192.007" y="1034.363" fill="#4A3C80" width="45.898" height="45.898"/>
						<rect x="223.209" y="1034.363" fill="#54438D" width="45.899" height="45.898"/>
						<rect x="254.412" y="1034.363" fill="#4E5493" width="45.899" height="45.898"/>
						<rect x="285.615" y="1034.363" fill="#476396" width="45.898" height="45.898"/>
						<rect x="316.816" y="1034.363" fill="#407298" width="45.899" height="45.898"/>
						<rect x="348.019" y="1034.363" fill="#358097" width="45.897" height="45.898"/>
						<rect x="379.22" y="1034.363" fill="#2B8C95" width="45.899" height="45.898"/>
						<rect x="410.422" y="1034.363" fill="#199890" width="45.9" height="45.898"/>
						<rect x="441.625" y="1034.363" fill="#00A389" width="45.898" height="45.898"/>
						<rect x="472.831" y="1034.363" fill="#28A997" width="45.896" height="45.898"/>
						<rect x="504.032" y="1034.363" fill="#3CAEA4" width="45.898" height="45.898"/>
						<rect x="535.235" y="1034.363" fill="#4DB4B2" width="45.896" height="45.898"/>
						<rect x="566.434" y="1034.363" fill="#5CBABF" width="45.9" height="45.898"/>
						<rect x="597.637" y="1034.363" fill="#69C1CE" width="45.898" height="45.898"/>
						<rect x="628.84" y="1034.363" fill="#80CDE9" width="29.539" height="45.898"/>
					</g>
					<text transform="matrix(1 0 0 1 -84.7856 1070.3115)" display="inline" font-family="'Roboto-Regular'" font-size="11">#80CDE9</text>
					<text transform="matrix(1 0 0 1 -84.7856 1115.4893)" display="inline" font-family="'Roboto-Regular'" font-size="11">#1D1E3D</text>
				</g>-->
				<image id="foot_pic" xlink:href="images/info_map_esp.png" x="0" y="900" height="59px" width="131px"></image>
			</svg>
			<img id="foot_pic_mov" src="images/info_map_esp_mov.png">
 			<hr class="line_end">
			<div class="nota">
				<div class="titulo_nota">
					<p class="nm">Methodological Note:</p>
					<p class="linea web"></p>
				</div>
				<div class="parrafo">
					<p>Data is from the World Bank and is available for download in the section called <a href="http://econ.worldbank.org/WBSITE/EXTERNAL/EXTDEC/EXTDECPROSPECTS/0,,contentMDK:22803131~pagePK:64165401~piPK:64165026~theSitePK:476883,00.html" target="_blank">Bilateral Migration and Remittances</a>
					</p>
				</div>
			</div>
			<a href="https://www.dropbox.com/s/9t13j80fm1907ms/Destino_Origen.csv?dl=0" target="_blank">
				<img src="images/btn_descarga_ing.png" class="boton">
			</a>
		</div>
		<div class="footer">
			<div class="d4">
				<span>D4 for Univision Noticias.</span>
				<a href="http://www.data4.mx" target="_blank">http://www.data4.mx</a>
			</div>	
		</div>
	</div>
</body>
<script type="text/javascript">
	
</script>
</html>
