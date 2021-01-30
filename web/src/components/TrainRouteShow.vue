<template>
<div>

  <v-card v-if="routeHeader"
          style="border-radius: 0px; padding:6px;"
          v-html="routeHeader">
  </v-card>

  <v-timeline dense >
      <v-timeline-item
        v-for="(item, i) in routeList" :key="i" >
              <span slot="opposite">Tus eu perfecto</span>
              <v-card class="elevation-2" style="width:40%" >
                  <v-card-title class="headline">{{item.stop}}</v-card-title>
                  <v-card-text>Время прибытия : {{item.arrival_time}}</v-card-text>
                  <v-card-text>Время отбытия : {{item.departure_time}}</v-card-text>
                  <v-card-text>Время стоянки : {{item.stop_time}}</v-card-text>
              </v-card>
      </v-timeline-item>
  </v-timeline>

</div>
</template>

<script>
export default {
  name: 'TrainRoute',
  props:['route'],

  computed: {
      routeList() {
         let routeList = [];
         if(this.route.route_list && this.route.route_list.stop_list)
             routeList = this.route.route_list.stop_list;
         return routeList;
      },

      routeHeader() {
          let route = '';
          if(this.route.train_description) {
              let number = this.route.train_description.number
              let from   = this.route.route_list.from;
              let to     = this.route.route_list.to;
              route     = `<span class="route-header">Номер</span>:${number}
                           <span class="route-header">Откуда</span>: ${from}
                           <span class="route-header">Куда</span>: ${to} `;
          }
          return route;
      }
  },
}
</script>

<style >
   .route-header {
     font-style: italic;
     color:green;
   }
</style>
