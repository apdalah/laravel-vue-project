<template>
  <div id="app">
    <v-app id="inspire" dark>
      <v-navigation-drawer v-model="drawer" clipped fixed  app width="270">
        <sidebar></sidebar>
      </v-navigation-drawer>

      <navbar>
        <template v-slot:toggleButton>
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        </template>
      </navbar>

      <v-main>
        <router-view></router-view>
      </v-main>
            
      <v-footer app fixed>
        <span>&copy; 2019</span>
      </v-footer>
    </v-app>
  </div>
</template>


    

    <v-main>
      <!--  -->
    </v-main>



<script>
import Sidebar from "./_sidebar";
import Navbar from "./_navbar";
export default {
  components: { Sidebar, Navbar },
  data: () => ({
    drawer: null,
  }),
  props: ["user"]
};
</script>