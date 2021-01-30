<template>

  <v-app>

<!--    <v-app-bar app>-->
<!--      &lt;!&ndash;      <router-link to="/">Home</router-link> / &ndash;&gt;-->
<!--      &lt;!&ndash;      <router-link to="/about">About</router-link>&ndash;&gt;-->
<!--    </v-app-bar>-->

<!--    <v-navigation-drawer app ></v-navigation-drawer>-->

    <v-main>
      <v-container fluid>
         <router-view></router-view>
      </v-container>
    </v-main>

  </v-app>

</template>

<style>
/*#app {*/
/*  font-family: 'Avenir', Helvetica, Arial, sans-serif;*/
/*  -webkit-font-smoothing: antialiased;*/
/*  -moz-osx-font-smoothing: grayscale;*/
/*  text-align: center;*/
/*  color: #2c3e50;*/
/*}*/

/*#nav {*/
/*  padding: 30px;*/
/*}*/

/*#nav a {*/
/*  font-weight: bold;*/
/*  color: #2c3e50;*/
/*}*/

/*#nav a.router-link-exact-active {*/
/*  color: #42b983;*/
/*}*/
</style>
