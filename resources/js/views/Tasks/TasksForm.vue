<template>
  <div>
    <title-bar :title-stack="titleStack"/>
    <hero-bar>
      {{ heroTitle }}
      <router-link slot="right" to="/tasks/index" class="button">
        Task List
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      <tiles>
        <card-component :title="formCardTitle" icon="account-edit" class="tile is-child">
          <form @submit.prevent="submit">
            <template v-if="id">
              <b-field label="Task" horizontal>
                <b-input :value="form.name" custom-class="is-static" readonly />
              </b-field>
              <hr>
            </template>
            <b-field label="Name" message="Task name" horizontal>
              <b-input placeholder="e.g. aaa..." v-model="form.name" required />
            </b-field>
          <b-field label="Assigne" horizontal>
            <b-select placeholder="Select a assigne" v-model="form.user_id" required>
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.name }}
              </option>
            </b-select>
          </b-field>
          <b-field label="Description" message="Task description ..." horizontal>
            <b-input type="textarea" placeholder="Task description ..." v-model="form.description" maxlength="255" required/>
          </b-field>
            <hr>
            <b-field horizontal>
              <b-button type="is-primary" :loading="isLoading" native-type="submit">Submit</b-button>
            </b-field>
            <input type="hidden" name="status" :value="form.status">
          </form>
        </card-component>
        <card-component v-if="isTaskExists" title="Task" icon="account" class="tile is-child">
          <b-field label="Name">
            <b-input :value="item.name" custom-class="is-static" readonly/>
          </b-field>
          <b-field label="user">
            <b-input :value="item.assinge" custom-class="is-static" readonly/>
          </b-field>
          <b-field label="Description">
            <b-input :value="item.description" custom-class="is-static" readonly/>
          </b-field>
          <b-field label="Created">
            <b-input :value="item.created" custom-class="is-static" readonly/>
          </b-field>
        </card-component>
      </tiles>
    </section>
  </div>
</template>

<script>
import clone from 'lodash/clone'
import TitleBar from '@/components/TitleBar'
import HeroBar from '@/components/HeroBar'
import Tiles from '@/components/Tiles'
import CardComponent from '@/components/CardComponent'
import Notification from '@/components/Notification'

export default {
  name: 'TaskForm',
  components: { CardComponent, Tiles, HeroBar, TitleBar, Notification },
  props: {
    id: {
      default: null
    }
  },
  data () {
    return {
      isLoading: false,
      item: null,
      form: this.getClearFormObject(),
      users: null,
      createdReadable: null,
    }
  },
  computed: {
    titleStack () {
      let lastCrumb

      if (this.isTaskExists) {
        lastCrumb = this.form.name
      } else {
        lastCrumb = 'New Task'
      }

      return [
        'Admin',
        'Tasks',
        lastCrumb
      ]
    },
    heroTitle () {
      if (this.isTaskExists) {
        return this.form.name
      } else {
        return 'Create Task'
      }
    },
    formCardTitle () {
      if (this.isTaskExists) {
        return 'Edit Task'
      } else {
        return 'New Task'
      }
    },
    isTaskExists () {
      return !!this.item
    }
  },
  created () {
    this.getData()
  },
  methods: {
    getClearFormObject () {
      return {
        id: null,
        name: null,
        user_id: null,
        status: 1
      }
    },
    getData () {
      if (this.id) {
        axios
          .get(`/tasks/${this.id}`)
          .then(r => {
            this.form = r.data.data
            this.item = clone(r.data.data)
          })
          .catch(e => {
            this.item = null

            this.$buefy.toast.open({
              message: `Error: ${e.message}`,
              type: 'is-danger',
              queue: false
            })
          })
      }
      axios
        .get(`/users`)
        .then(r => {
          this.users = r.data.data
        })
        .catch(e => {
          this.users = null

          this.$buefy.toast.open({
            message: `Info: ${e.message}`,
            type: 'is-info',
            queue: false
          })
        })
    },
    input (v) {
      //this.createdReadable = moment(v).format('MMM D, Y').toString()
    },
    submit () {
      this.isLoading = true
      let method = 'post'
      let url = '/tasks/store'

      if (this.id) {
        method = 'patch'
        url = `/tasks/${this.id}`
      }

      axios({
        method,
        url,
        data: this.form
      }).then(r => {
        this.isLoading = false

        if (!this.id && r.data.data.id) {
          this.$router.push({name: 'tasks.edit', params: {id: r.data.data.id}})

          this.$buefy.snackbar.open({
            message: 'Created',
            queue: false
          })
        } else {
          this.item = r.data.data

          this.$buefy.snackbar.open({
            message: 'Updated',
            queue: false
          })
        }
      }).catch(e => {
        this.isLoading = false

        this.$buefy.toast.open({
          message: `Error: ${e.message}`,
          type: 'is-danger',
          queue: false
        })
      })
    }
  },
  watch: {
    id (newValue) {
      this.form = this.getClearFormObject()
      this.item = null

      if (newValue) {
        this.getData()
      }
    }
  }
}
</script>
