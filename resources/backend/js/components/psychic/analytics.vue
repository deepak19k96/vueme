<template>
   <div>
       <v-row>
       <v-col cols="12" class="">
        <p-analytics-overview        
        ></p-analytics-overview>
       </v-col>
         <v-col class="col-12 col-sm-5">
       <p-analytics-earnings :user="user"></p-analytics-earnings>
         </v-col>
         <v-col class="col-12 col-sm-7">
       <p-analytics-net-income/>
         </v-col>
       </v-row>
      
   </div>
</template>

<script>



    function getData() {
        return {

        };

    }
    export default {
        name: "analytics",   
        props:['user'],    
   
        data: getData,        
       
}

         
</script>

<style type="text/css" scoped>


</style>