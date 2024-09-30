<template>
  <v-app>
    <v-navigation-drawer app permanent width="180">
      <v-list>
        <v-list-item @click="tab = 'projects'" :active="tab === 'projects'">
          <v-list-item-icon>
            <v-icon>mdi-folder</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Proyectos</v-list-item-title>
        </v-list-item>
        <v-list-item @click="tab = 'tasks'" :active="tab === 'tasks'">
          <v-list-item-icon>
            <v-icon>mdi-check-circle</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Tareas</v-list-item-title>
        </v-list-item>
        <v-list-item @click="tab = 'users'" :active="tab === 'users'">
          <v-list-item-icon>
            <v-icon>mdi-account</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Admin</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app color="green" dark>
      <v-toolbar-title class="mx-auto">PRUEBA TECNICA - SUMI</v-toolbar-title>
    </v-app-bar>

    <v-main>
      <v-container>
        <component :is="currentComponent"></component>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import TaskComponent from './components/Task/TasksList.vue';
import ProjectComponent from './components/Projects/ProjectComponent.vue';
import UserComponent from './components/User/UserComponent.vue';

export default {
  name: 'App',

  components: {
    TaskComponent,
    ProjectComponent,
    UserComponent,
  },

  data: () => ({
    tab: 'projects', //MUESTRO PROYECT COMO PRIMER PESTAÑA
  }),

  computed: { // DETERMINA CUAL COMPOENENTE MOSTRAR SEGUN TAB
    currentComponent() {
      return {
        tasks: TaskComponent,
        projects: ProjectComponent,
        users: UserComponent,
      }[this.tab];
    },
  },
};
</script>

<style>
body {
  font-family: 'Roboto', sans-serif;
}
</style>
