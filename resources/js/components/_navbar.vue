<template>

    <v-app-bar app :dark="true">
        <slot name="toggleButton"></slot>
        <v-toolbar-title>{{user.name}}</v-toolbar-title>
        <v-spacer></v-spacer>

        <v-menu
          offset-y
          origin="center center"
          class="elelvation-1"
          :nudge-bottom="14"
          transition="scale-transition"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn icon text v-bind="attrs" v-on="on" @click="markAsRead">
              <v-badge color="red" overlap>
                <span slot="badge">{{unreadNotifications.length}}</span>
                <v-icon medium>notifications</v-icon>
              </v-badge>
            </v-btn>
          </template>

          <v-list>
            <v-list-tile
              :class="{'green': notification.read_at==null}"
              @click="markAsRead"
              v-for="notification in allNotifications" :key="notification.id">
              <v-list-tile-content>
                <v-list-tile-title>
                  {{notification.data.created_user.name}} has just registered on {{notification.created_at}}
                </v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </v-list>
        </v-menu>

        <v-btn icon>
          <v-icon>mdi-magnify</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>mdi-heart</v-icon>
        </v-btn>

        <v-btn icon>
          <v-icon>mdi-dots-vertical</v-icon>
        </v-btn>

    </v-app-bar>

</template>


<script>
// console.log(user.notifications)
export default {
  props: ["user"],
  data: () => ({
       
    drawer: null,
    allNotifications: [],
    unreadNotifications: [],
  }),

  props: ["user"],
  watch:{
      allNotifications(val){
          this.unreadNotifications =  this.allNotifications.filter(notification => {
            return notification.read_at == null;
        });
      }
  },
  methods: {
    logout() {
      axios.post("/logout").then(response => window.location.reload());
    },
    markAsRead() {
      axios.get("/mark-all-read/" + this.user.id).then(response=>{
          this.unreadNotifications = [];
      });
    }
  },
 
  created() {
    this.allNotifications = window.user.user.notifications;

    this.unreadNotifications =  this.allNotifications.filter(notification => {
        return notification.read_at == null;
      });
    // Echo.private("App.User." + this.user.id).notification(notification => {
    //   this.allNotifications.unshift(notification.notification);
    // });
  }
};
</script>