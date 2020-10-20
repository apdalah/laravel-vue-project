<template>
  <div>

    <v-breadcrumbs
      :items="breadcrumbs"
      divider="/"
    ></v-breadcrumbs>

    <v-toolbar
      flat
    >
      <v-toolbar-title>All Users</v-toolbar-title>
      <v-divider
        class="mx-4"
        inset
        vertical
      ></v-divider>
      <v-spacer></v-spacer>
      <v-dialog
        v-model="dialog"
        max-width="500px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            color="primary"
            dark
            class="mb-2"
            v-bind="attrs"
            v-on="on"
          >
            New User
          </v-btn>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container>
              <v-row>
                <v-col
                  cols="12"
                  sm="12"
                  md="6"
                >
                  <v-text-field
                    v-model="editedItem.name"
                    label="Name"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="6"
                >
                  <v-text-field
                    v-model="editedItem.email"
                    label="E-mail"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="6"
                >
                  <v-text-field
                    v-model="editedItem.password"
                    label="Password"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                  sm="12"
                  md="6"
                >
                  <v-text-field
                    v-model="editedItem.password_confirmation"
                    label="Confirm Password"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="12"
                >
                  <v-select
                    v-model="editedItem.role"
                    :items="allRoles"
                    label="Roles"
                    item-text="name"
                    return-object
                    chips
                  ></v-select>
                </v-col>
                <v-col
                  cols="12"
                >
                  <v-select
                    v-model="editedItem.permissions"
                    :items="allPermissions"
                    label="Permissions"
                    item-text="name"
                    return-object
                    multiple
                    chips
                  ></v-select>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
              color="blue darken-1"
              text
              @click="close"
            >
              Cancel
            </v-btn>
            <v-btn
              color="blue darken-1"
              text
              @click="save"
            >
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="tableData"
      sort-by="created_at"
      :search="search"
      class="elevation-1"
    >


          <template slot="item" slot-scope="props">

            <tr>
              <td>{{ props.item.name }}</td>
              <td class="text-xs-right">{{ props.item.email }}</td>
              <td class="text-xs-right" v-if="props.item.role && Object.keys(props.item.role).length > 0">
                {{ props.item.role.name }}
                </td>
              <td class="text-xs-right" v-else>n/a</td>
              <td class="text-xs-right" v-if="props.item.permissions && props.item.permissions.length > 0">
                <v-btn
                  small
                  color="primary"
                  dark
                  @click.stop="permissionDialog = true"
                >
                  View Permissions
                </v-btn>

                <!-- Permissions Dialog -->
                <v-dialog
                  v-model="permissionDialog"
                  max-width="290"
                >
                  <v-card>
                    <v-card-title class="headline">
                      Permissions
                    </v-card-title>

                    <v-card-text>
                      <p v-for="(permission, index) in props.item.permissions" :key="index">
                        {{ permission.name }}
                      </p>
                    </v-card-text>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn
                        text
                        @click="permissionDialog = false"
                      >
                        Close
                      </v-btn>
                    </v-card-actions>

                  </v-card>
                </v-dialog>
                
              </td>
              <td class="text-xs-right" v-else>n/a</td>
              <td class="text-xs-right">{{ props.item.created_at }}</td>
              <td class="text-xs-right">{{ props.item.updated_at }}</td>
              <td>
                <v-icon
                  small
                  class="mr-2"
                  @click="editItem(props.item)"
                >
                  mdi-pencil
                </v-icon>
                <v-icon
                  small
                  @click="deleteItem(props.item)"
                >
                  mdi-delete
                </v-icon>
              </td>
            </tr>

          </template>

          
          <template slot="no-data">
              <v-btn color="primary" @click="initialize">Reset</v-btn>
          </template>



    </v-data-table>



  </div>

</template>

<script>
  export default {
    data: () => ({

      breadcrumbs: [
        {
          text: 'Dashboard',
          disabled: false,
          href: '/admin/dashboard',
        },
        {
          text: 'User Manegment',
          disabled: true,
          href: '#',
        },
        {
          text: 'All Users',
          disabled: false,
          href: '/admin/users',
        },
      ],

      search: '',
      dialog: false,
      dialogDelete: false,
      permissionDialog: false,

      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'E-mail', value: 'email' },
        { text: 'Role', value: "role" },
        { text: 'Permissions', value: 'permissions[].name' },
        { text: 'Created at', value: 'created_at' },
        { text: 'Updated at', value: 'updated_at' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],

      tableData: [],
      editedIndex: -1,

      allRoles:[],
      allPermissions:[],


      editedItem: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: {},
        permissions: [],
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString()
      },

      defaultItem: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: {},
        permissions: [],
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString()
      },
      
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
    },

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        axios.get('/api/users').then(response => {
          this.tableData = response.data.data;
        });

        axios.get('/api/roles').then(response=>this.allRoles=response.data.data);
        axios.get('/api/permissions')
        .then( response=>this.allPermissions=response.data.data )
        .catch( error => console.log(error.response) );

      },

      editItem (item) {
        this.editedIndex = this.tableData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        if(confirm('Are you sure you want to delete this?')){
          this.editedIndex = this.tableData.indexOf(item)
          this.tableData.splice(this.editedIndex, 1)
          axios.delete('/api/users/'+item.id)
          .then( response=>console.log(response.data) )
          .catch( error => console.log(error.response) );
        }
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        if (this.editedIndex > -1) {
          Object.assign(this.tableData[this.editedIndex], this.editedItem)
          // update item
          axios.put('/api/users/'+this.editedItem.id,this.editedItem)
          .then( response=> console.log(response.data) )
          .catch( error => console.log(error.response) );

        } else {
          this.tableData.push(this.editedItem)
          // create new item
          axios.post('/api/users/',this.editedItem)
          .then( response=> console.log(response.data) )
          .catch( error => console.log(error.response) );
        }
        this.close()
      },
    },
  }
</script>