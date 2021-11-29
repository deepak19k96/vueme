<template>
   <v-row>       
            

                <v-container>
                    <v-card min-height="320px">
                          <v-card-text class="pa-0">
                            <v-container>
                                <v-row>
                                    <v-col class="col-5 col-md-8 col-lg-9">
                                        <div class="font-weight-bold text-dark" >Overview</div>
                                    </v-col>
                                    <v-col class="col-7 col-md-4  col-lg-3">
                                        <v-row>
                                            <v-col>
                                                <v-select small style="font-size:12px"
                                                        @change="f_get_data_oveview()"                                                     
                                                        :items="search_months"                                                        
                                                        v-model="selected_month" 
                                                         :loading="loading"
                                                        solo
                                                        dense
                                                         background-color="#F0F0F7"
                                                        :menu-props="{contentClass: 'checkList-lineWhite'}"
                                                        class="widthSelect float-right"
                                                        :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important'}]"
                                                ></v-select>
                                            </v-col>                                            
                                        </v-row>
                                    </v-col>
                                </v-row>
                            </v-container>
                            <!----- <v-row style="font-size: 24px;
    text-align: center;
    display: contents;">
<div class="text-primary" style="color: rgb(191, 186, 186) !important;
    margin-top: 50px;
   " v-if="no_data" >No data for this period</div>

                            </v-row>  -->
                            <div :style="[mobile ? {'font-size':'20px', 'right': '20%'}:{}]" class="text-center text_no_data" v-if="no_data">No data for this period</div>
                            <div class="spinner-border text-primary" v-if="loading"></div>
                             <canvas :height="f_height_canvas()" id="overviews"></canvas>
                          </v-card-text>
                   
                    </v-card>
                </v-container>
           
         </v-row>
</template>

<script>

 import {mapGetters} from 'vuex';
import Chart from 'chart.js';
export default {
    data(){
    return {

        search_months: [    
                             { text:'This month', value: 0 },
                            //  { text:'Last month', value: 1 },
           {                   text:'Last 3 months',value: 2},
                            {  text:'Last 6 month', value: 5},
                            {  text:'Last year', value: 11
            },],

        selected_month: 0, 
            chart: null,
            loading:false,
            no_data:false,
            height_canvas: '100px'
                         
          
         

    }
        
       }, 
      
       mounted(){
           this.f_get_data_oveview();
       },
        computed:{
            ...mapGetters({
                mobile: 'util/mobile',
                
            }), 
           
        },
        methods: {
f_height_canvas(){
    console.log(this.mobile);
  return  this.mobile ? '180px' : '100px'
},
f_min_height(){
 return this.mobile ? '290px' : '380px';
},
        f_get_data_oveview: function() { 

                  this.loading =true;
                axios.get('/api/v1/user/analytics/overview?months='+this.selected_month, {
                 
                })
                    .then(response => {
                       
                        this.no_data=false;
                          if (this.chart != null) {
                                this.chart.destroy();                                
                              }
                              this.loading =false;
                              
                          
                           if(response.data[0].views.reduce((a,b) => a + b, 0) === 0 &&
                              response.data[0].sessions.reduce((a,b) => a + b, 0) === 0){
                              this.no_data =true;
                           }else{
                                 let datachart = this.get_data_chart(response);
                           this.createChart("overviews",datachart);
                           }
                          
                          

                    })
                    .catch(error => {
                        alert(error);
                        this.message_error = error;
                    });
        },
        get_data_chart(response){
          let graphic_type = 'line';
          if(this.selected_month ===0){
            graphic_type = 'bar';
          }
            return {
                type: graphic_type,
                data: {
                    labels: response.data[0].months,
                    height: '330px',
                    datasets: [
                    { // one line graph
                        label: 'Profile Views',
                        data: response.data[0].views,
                       borderColor: 'rgba(161, 42, 223, 0.5)',
                       backgroundColor: 'rgba(161, 42, 223, 0.1)',
                        borderWidth: 2
                    },
                    { // another line graph
                        label: 'Number of sessions',
                        data: response.data[0].sessions,
                      borderColor: 'rgba(50, 115, 220, 0.5)',
                       backgroundColor: 'rgba(50, 115, 220, 0.1)',                     
                        borderWidth: 3
                    }
                    ]
                },
                options: {
                    legend:{
                        position:'bottom',
                        align:'start'
                    },
                    responsive: true,
                    lineTension: 1,
                    scales: {
                    yAxes: [{
                        ticks: {
                        beginAtZero: true,
                        padding: 25,
                        }
                    }]
                    }
                }
                };
                        
        },    
        createChart(chartId, chartData) {
            const ctx = document.getElementById(chartId);
            this.chart = new Chart(ctx, {
            type: chartData.type,
            data: chartData.data,
            options: chartData.options,
            });
  

}
        }}
</script>

<style scoped>
.spinner-border{
   position: absolute;
    right: 45%;
    height: 60px;
    width: 60px;
    top: 160px;
    border-radius: 100%;
    color: #a163c1 !important;
 }
 .text_no_data{
      position: absolute;
    right: 35%;
    top: 170px;
    color: rgb(191, 186, 186) !important;
    font-size:24px;
 }
</style>>

