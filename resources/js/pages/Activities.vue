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
          text: 'Activities',
          disabled: false,
          href: '/admin/activities',
        },
      ],
    }),
}
</script>