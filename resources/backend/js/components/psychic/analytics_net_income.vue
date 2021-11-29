<template>
   <v-row>       
            

                <v-container>
                    <v-card min-height="317px">
                          <v-card-text class="pa-0">
                            <v-container>
                                <v-row>
                                    <v-col class="col-5 col-sm-7">
                                        <div class="font-weight-bold text-dark" >Net Income</div>
                                        <div class="font-weight-bold text-primary" >Avg. ${{avg_income | numFormat('0,0.00')}}</div>
                                    </v-col>
                                    <v-col class="col-7 col-sm-5">
                                        <v-row>
                                            <v-col>
                                                <v-select 
                                                         style="font-size:12px" 
                                                        @change="f_get_data_oveview()"                                                     
                                                        :items="search_months"                                                        
                                                        v-model="selected_month" 
                                                        solo
                                                        dense
                                                         background-color="#F0F0F7"
                                                        :menu-props="{contentClass: 'checkList-lineWhite'}"
                                                        class="widthSelect float-right"
                                                       :style="[ !$vuetify.breakpoint.smAndDown ? {'width': '135px !important'}:{'width': '135px !important'}]"
                                                        :loading="loading"
                                                ></v-select>
                                            </v-col>                                            
                                        </v-row>
                                    </v-col>
                                </v-row>
                            </v-container>
                           <v-row style="font-size: 24px;
    text-align: center;
    display: contents;">
<div class="text-primary" style="    color: rgb(191, 186, 186) !important;
    margin-top: 60px;
  " v-if="no_data" >No data for this period</div>

                            </v-row> 
                              
                          <div class="spinner-border text-primary" v-if="loading"></div>
                             <canvas  height="140px" id="income"></canvas>
                          </v-card-text>
                   
                    </v-card>
                </v-container>
           
         </v-row>
</template>

<script>

import Chart from 'chart.js';
export default {
    data(){
    return {
        avg_income:0,     
        search_months: [    { text:'This month', value: 0 },
                            // { text:'Last month', value: 1 },
           {                   text:'Last 3 months',value: 2},
                            {  text:'Last 6 month', value: 5},
                            {  text:'Last year', value: 11
            },],

            selected_month: 0, 
            chart: null, 
            loading:false, 
            no_data:false,              
          
         

    }
        
       },  
       
       mounted(){
           this.f_get_data_oveview();
       },        
        methods: {


        f_get_data_oveview: function() { 

                 this.loading =true;
                axios.get('/api/v1/user/analytics/income?months='+this.selected_month, {
                 
                })
                    .then(response => {
                          this.no_data=false;
                          if (this.chart != null) {
                                this.chart.destroy();                                
                              }
                              this.loading =false;
                           this.avg_income =  response.data[0].net_income;  
                           if(parseInt(response.data[0].net_income) === 0){
                                 this.no_data = true;
                           }else{
                          let datachart = this.get_data_chart(response);
                           
                           this.createChart("income",datachart);

                           } 
                          
                          

                    })
                    .catch(error => {
                        alert(error);
                        this.message_error = error;
                    });
        },
        get_data_chart(response){
          
            return {
                type: 'bar',
                data: {
                    labels: response.data[0].months,                    
                    datasets: [
                    { // one line graph
                        label: 'Income',
                        data: response.data[0].views,
                        borderColor: '#A163C1',
                        backgroundColor: '#A163C1',
                        borderWidth: 2
                    }
                    ]
                },
                options: {
                    legend:{
                        display: false
                    },
                    responsive: true,
                    lineTension: 1,
                    scales: {
                    yAxes: [{
                        ticks: {
                        beginAtZero: true,
                        padding: 5,
                         callback: function(value, index, values) {
                        return '$' + value;
                        }
                        }
                    }]
                    }
                }
                };
                        
        },    
        createChart(chartId, chartData) {

            let ctx = document.getElementById(chartId);
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
    top: 145px;
    border-radius: 100%;
    color: #a163c1 !important;
 }
</style>>

