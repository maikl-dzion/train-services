<template>
  <div class="home">
    <!--    <img alt="Vue logo" src="../assets/logo.png">-->
    <!--    <pre>{{trainRoute}}</pre>-->

    <div v-if="preloader"
         class="custom-overload" style="text-align: center">
         <h3 style="background: #42b983; margin-top: -50px">Подождите идет загрузка данных ...</h3>
         <v-progress-circular
            :size="80"
            :width="5"
            color="info"
            indeterminate
            style="border:0px red solid;margin-top:5%"
         ></v-progress-circular>
    </div>

    <v-app-bar app>
      <v-card-text>

          <v-chip class="mr-2" >
            <span style="font-style:italic"> Номер поезда : </span>
            <span style="color:darkblue;font-weight: bold"> {{trainRoute.train}} </span>
          </v-chip>

          <v-chip class="mr-2" >
            <span style="font-style:italic"> Пункт отбытия : </span>
            <span style="color:darkblue; font-weight: bold"> {{trainRoute.from}} </span>
          </v-chip>

          <v-chip class="mr-2" >
            <span style="font-style:italic; "> Пункт прибытия : </span>
            <span style="color:green; font-weight: bold"> {{trainRoute.to}} </span>
          </v-chip>

      </v-card-text>
    </v-app-bar>

    <template>
          <v-card style="width: 100%; padding:5px;" ><v-row>

                <v-col cols="6" sm="6">
                  <v-text-field
                    label="Станция отправления"
                    persistent-hint
                    v-model="trainRoute.from"
                  ></v-text-field>
                </v-col>

                <v-col cols="6" sm="6">
                  <v-text-field
                    label="Станция прибытия"
                    v-model="trainRoute.to"
                  ></v-text-field>
                </v-col>

                <v-col cols="4" sm="4">
                  <v-text-field type="number"
                                label="Дата отправления"
                                v-model="trainRoute.day"
                  ></v-text-field>
                </v-col>

                <v-col cols="4" sm="4">
                  <v-text-field type="number"
                                label="Месяц отправления"
                                v-model="trainRoute.month"
                  ></v-text-field>
                </v-col>

                <v-col cols="4" sm="4">
                  <v-text-field
                    label="Номер поезда"
                    v-model="trainRoute.train"
                  ></v-text-field>
                </v-col>

          </v-row>

          <v-btn @click="getTrainRoute()"tile color="success" >
               Получить маршрут поезда
          </v-btn>

    </v-card></template>

    <div style="display: flex; margin-top:20px; width: 100%; ">

      <v-card style="width: 40%; margin:0px 3px 3px 0px; padding:0px;">

        <div style="display: flex; padding:3px;" >
          <h3 style="width:50%;text-align: center">Список поездов</h3>
        </div>

        <v-simple-table style="width: 100%; border: 1px gainsboro solid; border-radius: 0px" >
          <template v-slot:default>
            <thead>
                <tr>
                    <th class="text-left">Номер</th>
                    <th class="text-left">Отправление</th>
                    <th class="text-left">Прибытие</th>
                    <th class="text-left">Дата от-я</th>
                    <th class="text-left">Дата пр-я</th>
                    <th class="text-left">Расп.</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, i) in trainList.train_list"
                    :key="i" style="cursor: pointer"
                    @click="setRoute(item)" >
                      <td>{{ item.number }}</td>
                      <td>{{ item.from }}</td>
                      <td>{{ item.to }}</td>
                      <td>{{ item.departure_date }}</td>
                      <td>{{ item.arrival_date }}</td>
                      <td>{{ item.schedule }}</td>
                </tr>
            </tbody>
          </template>
        </v-simple-table>

      </v-card>


      <v-card style="width: 100%; margin:0px 3px 3px 3px; padding:4px;" >
        <h3>Маршрут поезда</h3>
        <div v-if="errorMessage" style="color:red"> {{errorMessage}} </div>
        <div v-else style="border: 1px gainsboro solid;padding:3px">
             <TrainRouteShow :route="trainRouteResult"/>
        </div>
      </v-card>

    </div>


    <v-footer app><div style="display: block">

        <v-btn @click="getTrainList()" color="info" style="width:280px; border-radius: 0px">
          Получить список поездов
        </v-btn>

        <v-btn @click="logShowBtn = !logShowBtn"tile color="info" style="width:200px; margin-left:10px">
           Просмотреть логи
        </v-btn>

        <div v-if="logShowBtn" style="width:80%; padding:5px;">
            <hr>
            <div>errorData</div>
            <div v-html="errorData" ></div><hr>
            <div>responseFullData</div>
            <div style="text-align: left"><pre>{{responseFullData}}</pre></div>
        </div>

    </div></v-footer>

  </div>
</template>

<script>

import axios from 'axios'
import TrainRouteShow from '../components/TrainRouteShow'

export default {
  name: 'home',
  data () {
    return {

      apiUrl    : 'http://bolderfest.ru/train-services/api',
      trainList : [],
      timeTable : [],
      trainRouteResult : [],
      errorData        : [],
      responseFullData : [],
      errorMessage     : '',
      logShowBtn       : false,
      preloader        : false,

      trainRoute: {
          'from': 'Санкт-Петербург',
          'to': 'Москва',
          'day': 10,
          'month': 2,
          'train': '019У',
      },

      cities: [
          'Санкт-Петербург',
          'Москва',
          'Екатеринбург',
          'ЧИТА',
      ],

    }
  },

  created () {
    this.getCities();
    this.getTrainList()
  },

  components : {
    TrainRouteShow,
  },

  methods: {

    fetchData (url, fn = null) {
      const apiUrl = this.apiUrl + '/' + url
      axios.get(apiUrl)
          .then(function (response) {
            fn(response)
            console.log(response)
          }).catch(function (error) {
            alert('Catch error')
            console.log(error)
          })
    },

    getCities () {
        this.fetchData('cities', (response) => {
          const data = response.data
          this.cities = data
        })
    },

    getTrainList () {
        this.preloader = true;
        this.fetchData('train-list', (response) => {
            const data = response.data
            this.trainList = data
            this.preloader = false;
        })
    },

    getTrainRoute() {
        this.errorMessage = '',
        this.trainRouteResult = [];
        const data   = this.trainRoute;
        const apiUrl = this.apiUrl + '/' + 'train-route';
        this.preloader = true;
        axios.post(apiUrl, data)
          .then(response => {
              const respStatus = this.responseHandle(response);
              this.preloader = false;
              console.log(response);
          }).catch(function (error) {
              alert('Catch error')
              this.errorData = error
              this.preloader = false;
              console.log(error)
          })
    },

    responseHandle(response) {
        if(!response.data) {
           this.errorMessage = 'Нет данных';
           return false;
        }

        this.responseFullData = response.data
        const data = response.data

        if(data.error) {
          this.errorMessage = data.error;
          return false;
        }

        this.trainRouteResult = data
        return true;
    },

    setRoute(item) {
        let date = item.departure_date;
        let route = {
          'from' : item.from,
          'to'   : item.to,
          'day'  : 10,
          'month': 2,
          'train': item.number,
        };
        this.trainRoute = route;
    },

  },
}
</script>

<style>
   .custom-overload {
      z-index:9999;
      border:0px red solid;
      width:100%;
      height: 100%;
      position: fixed;
      background: gainsboro;
      opacity: 0.5;
   }
</style>
