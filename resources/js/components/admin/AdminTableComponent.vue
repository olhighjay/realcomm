<template>

  <section class="ftco-section" >
    <div class="container" id="table">
      <element-overlay v-if="elementOverlay"></element-overlay>
      <div class="row justify-content-center">
        <div class="col-md-6 text-center mb-5">
          <h2 class="heading-section">Admins</h2>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="col-md-6">
            <!-- start search -->
            <search :modelUrl="'/admins/admins'" @updatedSearchedData="getAdminSearchResults($event)"></search>
            <!-- end search -->
          </div>
        </div>
        <div class="col-md-6 text-center d-flex mb-5 justify-content-end">
          <span style="font-size:16px"><b>Filter by:</b> &nbsp; </span>                     
          <filtering  @filteringByEmitter="filtersBy($event)"></filtering>
          &nbsp; &nbsp; &nbsp;
          <sorting  @sortingByEmitter="sortsBy($event)"></sorting>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="table-wrap" style="overflow-x:scroll;">
            <table class="table table-responsive-xl table-hover">
              <thead>
                <tr>
                  <th v-if="admins.length > 0"><label class="checkbox-wrap checkbox-primary">
                      <input type="checkbox" @click="select" v-model="selectAll">
                      <span class="checkmark"></span>
                    </label>&nbsp;
                  </th>
                  <th>S/N</th>
                  <!-- <th>&nbsp;</th> -->
                  <th style="padding-left:80px">First name 
                    <span  v-if="firstname_ordered === true" @click="orderObject('first_name','up')"  class="mdi mdi-debug-step-out" style="cursor:pointer"></span>
                    <span v-else @click="orderObject('first_name','down')" class="mdi mdi-debug-step-into" style="cursor:pointer"></span>
                  </th>
                  <th>Last name 
                    <span  v-if="lastname_ordered === true" @click="orderObject('last_name','up')" class="mdi mdi-debug-step-out" style="cursor:pointer"></span>
                    <span v-else @click="orderObject('last_name','down')" class="mdi mdi-debug-step-into" style="cursor:pointer"></span>
                  </th>
                  <th>Email
                    <span  v-if="email_ordered === true" @click="orderObject('email','up')" class="mdi mdi-debug-step-out" style="cursor:pointer"></span>
                    <span v-else @click="orderObject('email','down')" class="mdi mdi-debug-step-into" style="cursor:pointer"></span>
                  </th>
                  <th>Status</th>
                  <th>&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <tr class="alert" role="alert" v-for="admin in admins" :key="admin.id">
                  <td style="padding-top:20px">
                    <label class="checkbox-wrap checkbox-primary">
                      <input type="checkbox" :value="admin.id" v-model="selected">
                      <span class="checkmark"></span>
                    </label>
                  </td>
                  <td></td>
                  <td class="d-flex align-items-center">
                    <avatar :username="admin.first_name + ' ' + admin.last_name" :size="40" class="mr-3"></avatar>
                    <!-- <div class="img" style="background-image: url(images/person_1.jpg);"></div> -->
                    <div class="pl-3 email">
                      <span>{{admin.first_name}}</span>
                      <span>Added: {{new Date(admin.created_at).toISOString('dd-MM-YYYY').split('T')[0] }}</span>
                    </div>
                  </td>
                  <td>{{admin.last_name}}</td>
                  <td>{{admin.email}}</td>
                  <td class="status"><span v-if="admin.status === 'active'" class="active">{{admin.status}}</span> <span v-else class="inactive">{{admin.status}}</span></td>
                  <td class="text-right">
                  <div class="dropdown show d-inline-block widget-dropdown">
                    <a class="dropdown-toggle icon-burger-mini" href="" role="button" id="dropdown-recent-order1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static"></a>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-recent-order1">
                      <li class="dropdown-item">
                        <a :href="'/admins/'+admin.id">View</a>
                      </li>
                      <li class="dropdown-item">
                        <a :href="'/admins/'+admin.id+'/edit'">Edit</a>
                      </li>
                      <li class="dropdown-item">
                        <a href="#" @click="adminConfirmDeactivate([admin.id, 8], admin.status === 'inactive' ? 'activate' : 'deactivate', 'single-update')">{{admin.status === 'inactive' ? 'Activate' : 'Deactivate'}} </a> 
                      </li>
                      <li class="dropdown-item">
                        <a href="#" @click="adminConfirmDeactivate([admin.id], 'delete', 'single-update')">Remove</a>
                      </li>
                    </ul>
                  </div>
                </td>
                </tr>
              </tbody>
            </table>
            <div>
              <h4 style="text-align:center" v-if="admins.length < 1">No record found!!</h4>
            </div>

            <div v-if="selected.length > 0">{{selected.length === 1 ? selected.length + ' record has been selected' : selected.length + ' records have been selected'}}</div>


            <div class="row justify-content-center">
              <div class="col-md-6 mb-2 pt-2">
                <div v-if="selected.length > 0" class="btn-group mb-1">
                  <button type="button" class="btn btn-outline-secondary py-0" >Action</button>
                  <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu">
                    <a @click=" adminConfirmDeactivate(selected, 'activate', 'mass-update')" class="action-item dropdown-item" href="#" >Activate Selected Records</a>
                    <a  @click="adminConfirmDeactivate(selected, 'deactivate', 'mass-update')" class="dropdown-item" href="#">Deactivate Selected Records</a>
                    <a  @click="adminConfirmDeactivate(selected, 'delete', 'mass-update')" class="dropdown-item" href="#" >Delete Selected Records</a>
                  </div>
                  &nbsp;  &nbsp;  &nbsp;
                </div>
                
                <showonpage  @showNumberEmitter="showNumberOfDataOnPage($event)"></showonpage>

              </div>
              <div class="col-md-6 text-center d-flex mb-5 justify-content-end">
                <Pagination :incomingData="pageComp" :searchQuery="searchQuery" :modelUrl="'/admins/admins'" @updatePaginatedData="getAdminPaginationResults($event)"></Pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>

  import Avatar from 'vue-avatar'
  import Pagination from './AdminPaginationComponent.vue'
  import Search from '../reusable/SearchComponent.vue'
  import Onpage from '../reusable/ShowOnPageComponent.vue'
  import Sorting from '../reusable/SortingByComponent.vue'
  import Filtering from './AdminFilterByComponent.vue'
  import ElementOverlay from '../reusable/ElementOverlayComponent.vue'
export default {
  components: {
    Avatar,
    Pagination,
    Search,
    Onpage,
    Sorting,
    Filtering,
    ElementOverlay
  },
  data () {
    return {
      selected: [],
      selectAll: false,
      admins: {},
      firstname_ordered: false,
      lastname_ordered: false,
      email_ordered: false,
      upOrder : false,
      pageComp: {},
      searchQuery : '',
      elementOverlay : false
    }
  },
  created() {
    // This loads the data after the page loads
    this.orderObject('', '');
  },
  methods: {
    // This loads the data from the server and uses parameters name and direction to sort or order the data
    orderObject(name, direction) {
      this.elementOverlay = true;
      axios.get(`/admins/admins?name=${name}&&direction=${direction}&&search=${this.searchQuery}&&page=1`)
        .then(response => {
          this.admins = response.data.admins.data;
          this.pageComp = response.data.admins
          console.log('orderObject');
          console.log(response.data );
          if(name === 'first_name'){
          this.firstname_ordered = direction === 'up' ? false : true;
          } else if(name === 'last_name'){
          this.lastname_ordered = direction === 'up' ? false : true;
          } else if(name === 'email'){
            this.email_ordered = direction === 'up' ? false : true;
          }
          this.elementOverlay = false;
        }); 
    },
    //This uses the alt alternatives to confirm if user really want to perform an action like delete, deactivavtye, activate and it performs the action
    adminConfirmDeactivate(ids, type, update_mode){
      Alt.alternative({
        status:'question',
        showConfirmButton:true,
        showCancelButton:true,
        stop:true,
        title:'Are You Sure?',
        text: ids.length > 1 ? `You are about to ${type} these records` : `You are about to ${type} this record`,
      })
      .then((res) => {
        if (res){
          Alt.alternative({
            status:'loading',
          });
          var updateAdminUrl;
          if(update_mode === 'mass-update') {
            updateAdminUrl = '/admins/mass-update';
          } else if(update_mode === 'single-update') {
            updateAdminUrl = `/admins/${ids[0]}/edit`;
          }
          // Update the selected records
          axios.post(updateAdminUrl, {type: type, ids: ids})
          .then(response => {
            if(response.status === 200) {
              // Update the index page data
              axios.get('/admins/admins')
                .then(response => {
                  Alt.alternative({
                    status:'success',
                    title:'Success',
                    text:`Records ${type}d successfully`
                  });
                  setTimeout(() => {
                    Alt.alert('loading',0)
                    $('#alert').addClass('fade').modal('hide')
                  },1000)
                  this.admins = response.data.admins.data;
                  this.pageComp = response.data.admins;
                  this.selected = [];
                  this.selectAll = false;
                }); 
            } else{
              setTimeout(() => {
                Alt.alternative({
                  status:'error',
                  title:'Error!!',
                  text:'There was something wrong with your request'
                })
              },200)
            }
          })
          .catch(error => {
            console.log(error.response)
            setTimeout(() => {
              Alt.alternative({
                status:'error',
                title:'Server Errors',
                text:'Your request failed on server'
              })
            },200)
          })
        }
      })
    },
    // This is used to select or multiselect data
    select() {
      this.selected = [];
			if (!this.selectAll) {
				for (let i in this.admins) {
					this.selected.push(this.admins[i].id);
				}
			}
    },
    // This is called to refresh the data
    getAdminPaginationResults(results) {
      this.admins = results;
    },

    getAdminSearchResults(results) {
      this.admins = results[0].admins.data;
      this.pageComp = results[0].admins;
      this.searchQuery = results[1];
    },

    showNumberOfDataOnPage(results) {
      this.orderObject(results[0], results[1]);
    },
    sortsBy(results) {
      this.orderObject(results[0], results[1]);
    },
    filtersBy(results) {
      this.orderObject(results[0], results[1]);
    }
  }
}
</script>


<style scoped>

.btn-outline-secondary {
  padding-top: 3px;
  padding-bottom: 3px;
}
.updateOrder {
  cursor: progress;
}

#table{
    position: relative;
}


</style>