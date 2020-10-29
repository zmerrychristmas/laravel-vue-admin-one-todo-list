<template>
  <div>
    <modal-trash-box :is-active="isModalActive" :trash-subject="trashObjectName" @confirm="trashConfirm" @cancel="trashCancel"/>
    <b-table
      :checked-rows.sync="checkedRows"
      :checkable="checkable"
      :loading="isLoading"
      :paginated="paginated"
      :per-page="perPage"
      :striped="true"
      :hoverable="true"
      default-sort="name"
      :data="tasks"
      >

      <template slot-scope="tasks">
        <b-table-column label="Name" field="name" sortable>
          {{ tasks.row.name }}
        </b-table-column>
        <b-table-column label="Assinge" field="assinge" sortable>
          {{ tasks.row.assinge }}
        </b-table-column>
        <b-table-column label="Description" field="description" sortable>
          {{ tasks.row.description }}
        </b-table-column>
        <b-table-column label="Author" field="author" sortable>
          {{ tasks.row.author }}
        </b-table-column>
        <b-table-column label="Status" field="status" sortable>
          {{ tasks.row.status == 1 ? 'Process' : 'Done' }}
        </b-table-column>
        <b-table-column label="Created">
          <small class="has-text-grey is-abbr-like" :title="tasks.row.created">{{ tasks.row.created }}</small>
        </b-table-column>
        <b-table-column custom-key="actions" class="is-actions-cell">
          <div class="buttons is-right">
            <button class="button is-small is-success"  type="button" @click.prevent="doneTask(tasks.row)">
              <b-icon icon="check" size="is-small"/>
            </button>
            <router-link :to="{name:'tasks.edit', params: {id: tasks.row.id}}" class="button is-small is-warning" v-show="isAdmin">
              <b-icon icon="account-edit" size="is-small"/>
            </router-link>
            <button class="button is-small is-danger" type="button" @click.prevent="trashModal(tasks.row)" v-show="isAdmin">
              <b-icon icon="trash-can" size="is-small"/>
            </button>
          </div>
        </b-table-column>
      </template>

      <section class="section" slot="empty">
        <div class="content has-text-grey has-text-centered">
          <template v-if="isLoading">
            <p>
              <b-icon icon="dots-horizontal" size="is-large"/>
            </p>
            <p>Fetching data...</p>
          </template>
          <template v-else>
            <p>
              <b-icon icon="emoticon-sad" size="is-large"/>
            </p>
            <p>All task are done!&hellip;</p>
          </template>
        </div>
      </section>
    </b-table>
  </div>
</template>
<style scoped>
 th:last-child {
  text-align: right;
 }
</style>
<script>
import { mapState } from 'vuex'
import ModalTrashBox from '@/components/ModalTrashBox'

export default {
  name: 'TaskTable',
  components: { ModalTrashBox },
  props: {
    dataUrl: {
      type: String,
      default: null
    },
    checkable: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      isModalActive: false,
      trashObject: null,
      tasks: [],
      isLoading: false,
      paginated: false,
      perPage: 10,
      checkedRows: []
    }
  },
  computed: {
    trashObjectName () {
      if (this.trashObject) {
        return this.trashObject.name
      }

      return null
    },
    ...mapState([
      'isAdmin'
    ])
  },
  created () {
    this.getData()
  },
  methods: {
    getData () {
      if (this.dataUrl) {
        this.isLoading = true
        axios
          .get(this.dataUrl)
          .then(r => {
            this.isLoading = false
            if (r.data && r.data.data) {
              if (r.data.data.length > this.perPage) {
                this.paginated = true
              }
              this.tasks = r.data.data
            }
          })
          .catch( err => {
            this.isLoading = false
            this.$buefy.toast.open({
              message: `Error: ${e.message}`,
              type: 'is-danger',
              queue: false
            })
          })
      }
    },
    trashModal (trashObject) {
      this.trashObject = trashObject
      this.isModalActive = true
    },
    trashConfirm () {
      this.isModalActive = false
      axios
        .delete(`/tasks/${this.trashObject.id}/destroy`)
        .then( r => {
          this.getData()
          this.$buefy.snackbar.open({
            message: `Deleted ${this.trashObject.name}`,
            queue: false
          })
        })
        .catch( err => {
          this.$buefy.toast.open({
            message: `Error: ${err.message}`,
            type: 'is-danger',
            queue: false
          })
        })
    },
    trashCancel () {
      this.isModalActive = false
    },
    doneTask(task) {
      task.status = task.status = 2 ? 1 : 2
      let method = 'patch'
      let url = `/tasks/${task.id}/toggle`
      axios({
        method,
        url,
        data: task
      }).then(r => {
        this.isLoading = false
        this.getData()
        this.$buefy.snackbar.open({
          message: 'Done',
          queue: false
        })
      }).catch(e => {
        this.isLoading = false
        this.$buefy.toast.open({
          message: `Error: ${e.message}`,
          type: 'is-danger',
          queue: false
        })
      })
    }
  }
}
</script>
