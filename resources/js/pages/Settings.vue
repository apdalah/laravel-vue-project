<template>
    <div class="dashboard">
        <v-breadcrumbs
        :items="items"
        divider="/"
        ></v-breadcrumbs>
    </div>
</template>

<script>
export default {
    data: () => ({
      items: [
        {
          text: 'Dashboard',
          disabled: false,
          href: '/admin/dashboard',
        },
        {
          text: 'Settings',
          disabled: false,
          href: '/admin/settings',
        },
      ],
    }),
}
</script>