<template>
  <div>
    <title-bar :title-stack="titleStack"/>
    <hero-bar :has-right-visible="false">
      Hello {{ userName }}
    </hero-bar>
    <section class="section is-main-section">
      <card-component title="Todos" class="has-table has-mobile-sort-spaced">
        <tasks-table data-url="/tasks/list"/>
      </card-component>
    </section>
  </div>
</template>

<script>
// @ is an alias to /src
import { mapState } from 'vuex'
import TitleBar from '@/components/TitleBar'
import HeroBar from '@/components/HeroBar'
import CardComponent from '@/components/CardComponent'
import TasksTable from '@/components/TasksTable'
export default {
  name: 'home',
  components: {
    TasksTable,
    CardComponent,
    HeroBar,
    TitleBar
  },
  data () {
    return {

    }
  },
  computed: {
    titleStack () {
      return [
        'Admin',
        'Dashboard'
      ]
    },
    ...mapState([
      'userName'
    ]),
  },
  mounted () {
    this.$buefy.snackbar.open({
      message: 'Welcome back',
      queue: false
    })
  },
  methods: {

  }
}
</script>
