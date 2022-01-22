<template>
<div>
     <div v-if="successful" class="alert alert-success alert-highlighted " role="alert">
       You have successfully created a new admin
     </div>
     <div v-if="failed" class="alert alert-danger alert-highlighted" role="alert">
        Server Error!.. Unable to complete your request.
     </div>
    <form @submit.prevent="handleSubmit" @change="emptyField()">
      <label class="text-dark font-weight-medium" for="first_name">First Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="first_name" name="first_name" type="text" :class="{'is-invalid' : firstnameErrors.length > 0, 'is-inv' : firstnameErrors.length > 0, 'form-control':true }" placeholder="John" aria-label="first_name" v-model="first_name" @input="disabling(first_name, firstnameErrors )">
      </div>
      <ul v-if="firstnameErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="firstnameError in firstnameErrors" :key="firstnameError" class="form-error" > {{ firstnameError   }}</li>
      </ul>
      
      <label class="text-dark font-weight-medium" for="last_name">Last Name</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-account"></i>
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="last_name" name="last_name" type="text" :class="{'is-invalid' : lastnameError, 'is-inv' : lastnameError, 'form-control':true }" placeholder="James" aria-label="last_name" v-model="last_name" @input="disabling(last_name, lastnameError )" >
      </div>
      <ul v-if="lastnameError" class="mb-3 form-error-list"  >
        <li class="form-error"> {{ lastnameError   }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="email">Email</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-email"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="email" type="text" name="email" :class="{'is-invalid' : emailErrors.length > 0, 'is-inv' : emailErrors.length > 0, 'form-control':true}" placeholder="jahn@example.com " aria-label="email" v-model="email" @input="disabling(email, emailErrors )">
      </div>
      <ul v-if="emailErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="emailError in emailErrors" :key="emailError" class="form-error"> {{ emailError }}</li>
      </ul>

      <button v-if="loading === 'neutral'" type="submit" class="  btn btn-primary mb-4" :disabled="disable">{{admin ? 'Update' : 'Create'}} </button>
      <button v-else-if="loading === 'loading'" disabled class="buttonload btn btn-primary">Loading.. <i class=" ml-2 fa fa-circle-o-notch fa-spin fa-1x"></i></button>
      <button v-else-if="loading === 'loaded'" disabled class="buttonload btn btn-primary">Done <i class=" ml-2 fa fa-check fa-1x"></i></button>
    </form> 
</div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      first_name:'',
      last_name:'',
      email: '',
      firstnameErrors: [],
      lastnameError: '',
      emailErrors: [],
      disable: false,
      button_clicked: false,
      loading: 'neutral',
      successful: false,
      failed: false
    }
  },
  mounted() {
     this.edit();
   },
  props: {
    admin: {
      required: true,
      default: () => ({})
    }
  },
  // computed: {
     
  //    }
  //  },
  methods: {
    edit() {
      if(this.admin){
        this.first_name = this.admin.first_name;
        this.last_name = this.admin.last_name;
        this.email = this.admin.email;
      }
    },
    handleSubmit() {
      this.firstnameErrors= [];
      this.lastnameError = '';
      this.emailErrors= [];
      this.checkErrors();
      this.button_clicked = true;
      this.loading = 'neutral';
      this.successful= false;
      this.failed= false;

      var data = {};
      if(this.button_clicked && this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1) {
        data = {
          first_name: this.first_name,
          last_name: this.last_name ,
          email: this.email,
          type: 'save'
        }

        var url = '';
        if(this.admin){
          url = `/admins/${this.admin.id}/edit`
        } else {
          url = '/admins'
        }
        
        this.loading = 'loading';
        axios.post(url, data)
        .then(response => {
          console.log(response.status)
          if(response.status === 201) {
            this.loading = 'loaded';
            setTimeout(() => this.successful= true, 500);
            setTimeout(() => window.location.replace("/"), 2000);
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
          if(field === this.last_name) {
            this.lastnameError = '';
          } else if(field === this.email && this.validEmail(this.email)){
            this.emailErrors = [];
          } else if(field === this.first_name) {
            this.firstnameErrors= [];
          }

          if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1) {
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
        if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1) {
            this.disable = false;
        }
      }
      
    },
    validEmail: function (email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    checkErrors() {
      if(this.first_name.length < 1) {
        if(this.firstnameErrors.length > 0){
           this.firstnameErrors[this.firstnameErrors.length - 1] = 'First Name is required';
        } else {
          this.firstnameErrors.push('First Name is required ');
        }
        
      } else{
        this.firstnameErrors = [];
      }

      this.lastnameError = this.last_name.length > 0 ? '' : 'Last Name is required';

      if(this.email.length < 1) {
        if(this.emailErrors.length > 0){
           this.emailErrors[this.emailErrors.length - 1] = 'Email is required ';
        } else {
          this.emailErrors.push('Email is required');
        }
      } else if (!this.validEmail(this.email)) {
        if(this.emailErrors.length > 0){
          this.emailErrors[this.emailErrors.length - 1] = 'Invalid Email.';
        } else {
          this.emailErrors.push('Invalid Email.');
        }
      } else {
        this.emailErrors = [];
      }

      this.disable = true;
    }
  }
}
</script>

<style>
  .form-error-list {
    margin-top: -10px
  }
  .form-error {
    color:red;
    font-weight:400
  }
  .is-inv {
    border-color: #fe5461;
  }
  .buttonload {
  border: none; /* Remove borders */
  color: white; /* White text */
  padding: 12px 24px; /* Some padding */
  font-size: 16px; /* Set a font-size */
}
</style>

