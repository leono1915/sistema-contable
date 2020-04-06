function listar(){
  var opcion='deudores';
var accion='listar';
$.ajax({

url:'cru.php',
type:'post',
data:{opcion,accion},
success:function(respuesta){
  console.log(respuesta)
var deudores=``;
var nombres=[];
var array=[];
var i=0;
var j=0;
JSON.parse(respuesta).forEach(element=>{
  array[i]=element.nombre;
  
  
  
  deudores+=` <div class="description-block mb-4">
  <p>Folios</p>
  <div class="sparkbar pad" data-color="#fff">
  ${element.folio}</div>
  <h5 class="description-header">${element.cantidad+=element.cantidad}</h5>
  
  <button class='btn btn-success '>  <span class="description-text">CORCHOMEX</span></button>
  </div>`;   
  i++; 

})
var uniqs = array.filter(function(item, index, arra) {
  return arra.indexOf(item) === index;
})
var tam=uniqs.length;
  for( l=0;l<tam;l++){
     nombres[l]=uniqs[l]
  }
  console.log(nombres)

document.getElementById('contenidoDeudores').innerHTML=deudores;
}
/*var uniqs = array.filter(function(item, index, arra) {
                return arra.indexOf(item) === index;
              })
              var tam=uniqs.length;
                for( l=0;l<tam;l++){
                    template+=`
                    <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <h4 class='panel-title'>
                            <a data-toggle='collapse' data-parent='#accordian' href='#${l+2}'>
                                <span class='badge pull-right'><i class='fa fa-plus'></i></span>
                               ${uniqs[l]}
                            </a>
                        </h4>
                    </div>
                    <div id='${l+2}' class='panel-collapse collapse'>
                        <div class='panel-body' id='${l}'>
                              
                        </div>
                    </div>
                </div>             
               
                       `; 
                       console.log(l)
                }
            // $('#accordian').html(template);
            document.getElementById('accordian').innerHTML=template;
             var j;
           
             let test =[];
            
             var k=0;
           JSON.parse(respuesta).forEach(element => {
               k++; 
               test[k-1]=''; 
           for(j=0;j<tam+1;j++){
           switch(element.nombre){
          
           case uniqs[j]:  
                   
                     test[j]+=`<ul> <li> ${element.producto} <li> </ul>`;
                          
                         // $(`#${j+2}`).html(test[j]);
                         document.getElementById(`${j+2}`).innerHTML=test[j];
                         
           break;
           default: break;
          }
         
           }*/
/*<table class="table table-bordered table-striped mb-0">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody  id='contenidoDeudores'>
  <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      
       
  </tbody>
  </table>*/






});
}
$(function () {

  'use strict'

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

  //-----------------------
  //- MONTHLY SALES CHART -
  //-----------------------
  listar();
  // Get context with jQuery - using jQuery's .get() method.
  $('#filtradoDia').on('click',funcionfiltrardatos);
  $('#calendarInicio').datepicker({
    
  })
  $('#calendarFin').datepicker({
    
  })
  
 var meses=[];
   

 
 
  function funcionfiltrardatos(){
    console.log('haz dado click')
    var i=0;
    var opcion='historial';
    var accion='listarCompras';
    var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
    $.ajax({
      url:'cru.php',
      type:'POST',
      data:{opcion,accion},
      success:function (respuesta){
       var template="";
       var fecha="";
       //console.log(respuesta)
          var jason=JSON.parse(respuesta);
        
          jason.forEach(element => {
            switch(element.mes){
              case '1': meses[i]='Enero';
              break;
              case '2': meses[i]='Febrero';
              break;
              case '3': meses[i]='Marzo';
              break;
              case '4': meses[i]='Abril';
              break;
              case '5': meses[i]='Mayo';
              break;
              case '6': meses[i]='Junio';
              break;
              case '7': meses[i]='Julio';
              break;
              case '8': meses[i]='Agosto';
              break;
              case '9': meses[i]='Septiembre';
              break;
              case '10': meses[i]='Octubre';
              break;
              case '11': meses[i]='Noviembre';
              break;
              case '12': meses[i]='Diciembre';
              break;


            }
          
              template+=` <th>|      </th>
              <tr>
               <TD>
                        
               <TABLE WIDTH=100%>
                       
               <TR>
               <TD>Pendientes ${element.pendiente}</TD>
               <TD>Autorizadas ${element.autorizado}</TD>
               </TR>
               <TD>Total</TD>
               <TD>Compras</TD>
               <TR>
                   <Td>Total</Td>
                   <Td>$${element.facturado}</Td>
                   
               </TR>
                    <Td>Total</Td>
                    <td>$${element.facturado}</td>
               </TABLE>
               </TD> 
              
               
               </tr>
   
                       
                       
                       `;
                    i++; 
          });
    
          var array2=[65000, 100000, 80000, 20000, 15000, 10000, 9000,6500, 10000, 8000, 20000, 
            15000, 10000, 90000,6005, 10000, 80000, 200001, 15000, 10000, 90000]
         var array=[15000, 50000, 50000, 80000, 50000, 4000, 2000,6500, 10000, 8000, 20000,
           150000, 10000, 9000,6500, 10000, 8000, 200000, 150000, 100000, 9000];
          var salesChartData = {
            labels  : meses,
            datasets: [
              { 
                //                   aqui va la venat total
                label               : 'Digital Goods',
                backgroundColor     : 'rgba(60,141,188,0.9)',
                borderColor         : 'rgba(60,141,188,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : array
              },
              {
                //aqui va la inversion y gastos
                label               : 'Electronics',
                backgroundColor     : 'rgba(210, 214, 222, 1)',
                borderColor         : 'rgba(210, 214, 222, 1)',
                pointRadius         : false,
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : array2
              },
             /* { 
                                  aqui va la venat total
                label               : 'Digital Goods',
                backgroundColor     : 'rgba(0,255,0,0.6)',
                borderColor         : 'rgba(0,255,0,0.6)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : array2
              },*/
            ]
          }
        
          var salesChartOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
              display: false
            },
            scales: {
              xAxes: [{
                gridLines : {
                  display : false,
                }
              }],
              yAxes: [{
                gridLines : {
                  display : false,
                }
              }]
            }
          }
        
          // This will get the first returned node in the jQuery collection.
          var salesChart = new Chart(salesChartCanvas, { 
              type: 'line', 
              data: salesChartData, 
              options: salesChartOptions
            }
          )
        
          //---------------------------
          //- END MONTHLY SALES CHART -
          //---------------------------
        
          //-------------
          //- PIE CHART -
          //-------------
          // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        
        
            var l=[
              'exodia', 
              'IE',
              'FireFox', 
              'Safari', 
              'Opera', 
              'Navigator', 
          ]
            var pieData        = {
              labels:l,
              datasets: [
                {
                  data: [700,500,400,600,300,100],
                  backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }
              ]
            }
            var pieOptions     = {
              legend: {
                display: false
              }
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var pieChart = new Chart(pieChartCanvas, {
              type: 'doughnut',
              data: pieData,
              options: pieOptions      
            })
           
          
      }
  })
  }

  
 // var meses=['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'];
 
  //-----------------
  //- END PIE CHART -
  //-----------------

  /* jVector Maps
   * ------------
   * Create a world map with markers
   */
  

  // $('#world-map-markers').vectorMap({
  //   map              : 'world_en',
  //   normalizeFunction: 'polynomial',
  //   hoverOpacity     : 0.7,
  //   hoverColor       : false,
  //   backgroundColor  : 'transparent',
  //   regionStyle      : {
  //     initial      : {
  //       fill            : 'rgba(210, 214, 222, 1)',
  //       'fill-opacity'  : 1,
  //       stroke          : 'none',
  //       'stroke-width'  : 0,
  //       'stroke-opacity': 1
  //     },
  //     hover        : {
  //       'fill-opacity': 0.7,
  //       cursor        : 'pointer'
  //     },
  //     selected     : {
  //       fill: 'yellow'
  //     },
  //     selectedHover: {}
  //   },
  //   markerStyle      : {
  //     initial: {
  //       fill  : '#00a65a',
  //       stroke: '#111'
  //     }
  //   },
  //   markers          : [
  //     {
  //       latLng: [41.90, 12.45],
  //       name  : 'Vatican City'
  //     },
  //     {
  //       latLng: [43.73, 7.41],
  //       name  : 'Monaco'
  //     },
  //     {
  //       latLng: [-0.52, 166.93],
  //       name  : 'Nauru'
  //     },
  //     {
  //       latLng: [-8.51, 179.21],
  //       name  : 'Tuvalu'
  //     },
  //     {
  //       latLng: [43.93, 12.46],
  //       name  : 'San Marino'
  //     },
  //     {
  //       latLng: [47.14, 9.52],
  //       name  : 'Liechtenstein'
  //     },
  //     {
  //       latLng: [7.11, 171.06],
  //       name  : 'Marshall Islands'
  //     },
  //     {
  //       latLng: [17.3, -62.73],
  //       name  : 'Saint Kitts and Nevis'
  //     },
  //     {
  //       latLng: [3.2, 73.22],
  //       name  : 'Maldives'
  //     },
  //     {
  //       latLng: [35.88, 14.5],
  //       name  : 'Malta'
  //     },
  //     {
  //       latLng: [12.05, -61.75],
  //       name  : 'Grenada'
  //     },
  //     {
  //       latLng: [13.16, -61.23],
  //       name  : 'Saint Vincent and the Grenadines'
  //     },
  //     {
  //       latLng: [13.16, -59.55],
  //       name  : 'Barbados'
  //     },
  //     {
  //       latLng: [17.11, -61.85],
  //       name  : 'Antigua and Barbuda'
  //     },
  //     {
  //       latLng: [-4.61, 55.45],
  //       name  : 'Seychelles'
  //     },
  //     {
  //       latLng: [7.35, 134.46],
  //       name  : 'Palau'
  //     },
  //     {
  //       latLng: [42.5, 1.51],
  //       name  : 'Andorra'
  //     },
  //     {
  //       latLng: [14.01, -60.98],
  //       name  : 'Saint Lucia'
  //     },
  //     {
  //       latLng: [6.91, 158.18],
  //       name  : 'Federated States of Micronesia'
  //     },
  //     {
  //       latLng: [1.3, 103.8],
  //       name  : 'Singapore'
  //     },
  //     {
  //       latLng: [1.46, 173.03],
  //       name  : 'Kiribati'
  //     },
  //     {
  //       latLng: [-21.13, -175.2],
  //       name  : 'Tonga'
  //     },
  //     {
  //       latLng: [15.3, -61.38],
  //       name  : 'Dominica'
  //     },
  //     {
  //       latLng: [-20.2, 57.5],
  //       name  : 'Mauritius'
  //     },
  //     {
  //       latLng: [26.02, 50.55],
  //       name  : 'Bahrain'
  //     },
  //     {
  //       latLng: [0.33, 6.73],
  //       name  : 'São Tomé and Príncipe'
  //     }
  //   ]
  // })
 

})
