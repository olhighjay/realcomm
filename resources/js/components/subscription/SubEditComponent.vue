<template>
<div>
  <div v-if="successful" class="alert alert-success alert-highlighted " role="alert">
    You have successfully updated this subscription
  </div>
  <div v-if="failed" class="alert alert-danger alert-highlighted" role="alert">
    Server Error!.. Unable to complete your request.
  </div>
  <!-- <form @submit.prevent="handleSubmit" @change="emptyField()"> -->
  <form @submit.prevent="handleSubmit" @change="emptyField()">
      <label class="text-dark font-weight-medium" for="name">Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="name" name="name" type="text" :class="{'is-invalid' : nameErrors.length > 0, 'is-inv' : nameErrors.length > 0, 'form-control':true }" placeholder="John" aria-label="name" v-model="name" @input="disabling(name, nameErrors )">
      </div>
      <ul v-if="nameErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="nameError in nameErrors" :key="nameError" class="form-error" > {{ nameError   }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="editor">Description</label>
      <div class="mb-3">       
        <!-- <client-only> -->
          <vue-editor v-model="description"></vue-editor>
        <!-- </client-only> -->
      </div>

      <button v-if="loading === 'neutral'" type="submit" class="  btn btn-primary mb-4" :disabled="disable">Update </button>
      <button v-else-if="loading === 'loading'" disabled class="buttonload btn btn-primary">Loading.. <i class=" ml-2 fa fa-circle-o-notch fa-spin fa-1x"></i></button>
      <button v-else-if="loading === 'loaded'" disabled class="buttonload btn btn-primary">Done <i class=" ml-2 fa fa-check fa-1x"></i></button>
    </form>
</div>
</template>

<script>
import axios from 'axios'

export default {
  props:{
    id: {
      required: true,
      default: () => ('')
    }
  },
  data() {
    return {
      subscription: '',
      name:'',
      description:'',
      nameErrors: [],
      disable: false,
      button_clicked: false,
      loading: 'neutral',
      successful: false,
      failed: false,
    }
  },
  mounted() {
    this.loadSub();
  },
  methods: {
    loadSub() {
      axios.get('/subscriptions/'+this.id)
      .then(res => {
        this.subscription = res.data.subscription;
        this.name = this.subscription.name
        this.description = this.subscription.description
      })
    },
    handleSubmit() {
      this.nameErrors= [];
      this.checkErrors();
      this.button_clicked = true;
      this.loading = 'neutral';
      this.successful= false;
      this.failed= false;

      var data = {};
      if(this.button_clicked && this.nameErrors.length < 1) {
        data = {
          name: this.name,
          description: this.description ,
          type: 'save'
        }

        var url;
        url = '/subscriptions/'+this.subscription.id+'/edit'
        
        this.loading = 'loading';
        axios.post(url, data)
        .then(response => {
          console.log(response.status)
          if(response.status === 200) {
            this.loading = 'loaded';
            setTimeout(() => this.successful= true, 500);
            setTimeout(() => window.location.replace("/subscriptions"), 2000);
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
            this.failed = true;
            setTimeout(() => {
              this.loading = 'neutral';
              this.disable = false;
            }, 1000);
        })
      } 
     
    },
    disabling(field, fieldError) {
      this.disable;
      if( fieldError.length > 0) {
        if(field.length > 0) {
          if(field === this.name) {
            this.nameErrors = '';
          }

          if(this.nameErrors.length < 1) {
            this.disable = false;
          }
          
        } else if(field === ''){
          this.disable = true;
        }
      }
    },
    emptyField() {
      
      if (this.button_clicked) {
        this.checkErrors();
        if(this.nameErrors.length < 1) {
            this.disable = false;
        }
      }
      
    },
    checkErrors() {
      if(this.name.length < 1) {
        if(this.nameErrors.length > 0){
           this.nameErrors[this.nameErrors.length - 1] = 'Name is required';
        } else {
          this.nameErrors.push('Name is required ');
        }
        
      } else{
        this.nameErrors = [];
      }
      this.disable = true;
    }
  }
}
</script>

