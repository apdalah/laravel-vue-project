<template>

    <v-container>
        <v-list-item>
            <v-list-item-icon>
                <v-icon>{{ icons.mdiBlogger }}</v-icon>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title class="title">
                    Blog
                </v-list-item-title>
                <v-list-item-subtitle>
                    laravel, vue depend on API
                </v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list
            dense
            nav
            tile
        >
            <div :key="i" v-for="(link, i) in links">

                <v-list-item
                v-if="!link.subLinks"
                link
                :to="link.path"
                active-class="highlighted"
                :class="link.path === $route.path ? 'highlighted' : ''"
                >
                    <v-list-item-icon>
                        <v-icon>{{ link.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ link.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-group
                    v-else
                    v-model="link.active"
                    :prepend-icon="link.action"
                    no-action
                >
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title v-text="link.title"></v-list-item-title>
                        </v-list-item-content>
                    </template>

                    <v-list-item
                        v-for="sublink in link.subLinks"
                        :to="sublink.path"
                        :key="sublink.title"
                        :prepend-icon="sublink.icon"
                    >
                        <v-list-item-icon>
                            <v-icon>{{ sublink.icon }}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>{{ sublink.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                </v-list-group>

            </div>

        </v-list>
    </v-container> 

</template>


<script>
import 
{ 
    mdiAccountCog,
    mdiCogTransferOutline,
    mdiTicket,
    mdiBlogger,
    mdiAccountGroup,
    mdiAccountOff,
    mdiAccountRemove,

} from '@mdi/js';

export default {
    
    data: () => ({

        icons: {
            mdiAccountCog,
            mdiCogTransferOutline,
            mdiTicket,
            mdiBlogger,
        },

        links: [
            {
                title   : 'Dashboard',
                icon   : 'mdi-view-dashboard',
                path     : '/admin/dashboard',
                permission : '',
            },
            {
                title     : 'Users Manegment',
                action: mdiAccountCog,
                active: false,
                // permission : $auth.isAdmin(),
                permission : '',
                subLinks : [
                    {
                        title : 'Users',
                        icon  : mdiAccountGroup,
                        path  : '/admin/users',
                    },
                    {
                        title : 'Permissions',
                        icon  : mdiAccountOff,
                        path  : '/admin/permissions',
                    },
                    {
                        title : 'Roles',
                        icon  : mdiAccountRemove,
                        path  : '/admin/roles',
                    }
                ]
            },
            {
                title   : 'Activities',
                icon   : mdiTicket,
                path     : '/admin/activities',
                permission : '',
            },
            {
                title   : 'Settings',
                icon   : mdiCogTransferOutline,
                path     : '/admin/settings',
                permission : '',
            },
        ],

        right: null,
    }),

}
</script>
