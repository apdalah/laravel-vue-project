<template>
    <div class="dashboard">
        <v-breadcrumbs
        :items="breadcrumbs"
        divider="/"
        ></v-breadcrumbs>

        <v-toolbar
          flat
        >
          <v-toolbar-title>All Permissions</v-toolbar-title>
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
                New permission
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <!-- Start form -->

              <v-card-text>
                <v-container>
                  <v-row>
                    
                    <v-col
                      cols="12"
                      sm="6"
                      md="4"
                    >
                      <v-text-field
                        v-model="editedItem.name"
                        label="Name"
                      ></v-text-field>
                    </v-col>
                      
                  </v-row>
                </v-container>
              </v-card-text>

              <!-- End form -->

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
        class="elevation-1"
      >
        <template slot="item" slot-scope="props">
          <tr>
            <td>{{ props.item.name }}</td>
            <td>{{ props.item.created_at }}</td>
            <td>{{ props.item.updated_at }}</td>
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
        <template v-slot:no-data>
          <v-btn
            color="primary"
            @click="initialize"
          >
            Reset
          </v-btn>
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
          text: 'All Permissions',
          disabled: false,
          href: '/admin/permissions',
        },
      ],

      dialog: false,
      headers: [
        {
          text: 'Name',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'Created at', value: 'created_at' },
        { text: 'Updated at', value: 'updated_at' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],

      tableData: [],

      editedIndex: -1,

      editedItem: {
        name: '',
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString()
      },

      defaultItem: {
        name: '',
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
        axios.get('/api/permissions').then(response => {
          this.tableData = response.data.data;
        });

      },

      editItem (item) {
        this.editedIndex = this.tableData.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },

      deleteItem (item) {
        if(confirm('Are you sure you want to delete this permission ?')){
          this.editedIndex = this.tableData.indexOf(item)
          this.tableData.splice(this.editedIndex, 1)
          axios.delete('/api/permissions/'+item.id).then(response=>console.log(response.data))
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
          // edit item
          axios.put('/api/permissions/'+this.editedItem.id,this.editedItem).then(response=>console.log(response.data));
        } else {
          this.tableData.push(this.editedItem)
          // create item
          axios.post('/api/permissions/',this.editedItem).then(response=>console.log(response.data));
        }
        this.close()
      },
    },
  }
</script>