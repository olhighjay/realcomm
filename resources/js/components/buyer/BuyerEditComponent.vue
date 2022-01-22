<template>
<div>
     <div v-if="successful" class="alert alert-success alert-highlighted " role="alert">
       You have successfully update this buyer
     </div>
     <div v-if="failed" class="alert alert-danger alert-highlighted" role="alert">
        Server Error!.. Unable to complete your request.
     </div>
    <form @submit.prevent="handleSubmit" @change="emptyField()">
      <div class="form-group row justify-content-center">
        <div class="channel-avatar">
          <img v-if="imageUrl !== ''" :src="imageUrl" class="image">
          <img v-else-if="buyer.profile_picture !== null" :src="'/images/buyer_profile_picture/thumbnail/'+buyer.profile_picture" alt="" class="image">
          <img v-else :src="'/assets/app/img/user/dummydp.jpg'" alt="" class="image">
          <div onclick="document.getElementById('image').click()" class="channel-avatar-overlay" >
            <span class="icon" title="User Profile">
              <span class="mdi mdi-camera"></span>
            </span>   
          </div>
        </div>
      </div>
      <input @change="onImagePicked" class="d-none" id="image" type="file" name="profile_picture" accept="image/*">

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
      <label class="text-dark font-weight-medium" for="middle_name">Middle Name</label>
      <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">
                <i class="mdi mdi-account"></i>
            </span>
        </div>
        <input :disabled="loading !== 'neutral'" id="middle_name" name="middle_name" type="text" placeholder="Adeola" aria-label="last_name" v-model="middle_name" class="form-control">
      </div>
      
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

      <label class="text-dark font-weight-medium" for="phone_number">Phone number</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-phone-classic"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="phone_number" type="text" name="phone_number" :class="{'is-invalid' : phoneNumberErrors.length > 0, 'is-inv' : phoneNumberErrors.length > 0, 'form-control':true}" placeholder="2348023456789 " aria-label="phone_number" v-model="phone_number" @input="disabling(phone_number, phoneNumberErrors )">
      </div>
      <ul v-if="phoneNumberErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="phoneNumberError in phoneNumberErrors" :key="phoneNumberError" class="form-error"> {{ phoneNumberError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="role">Role</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-human-child"></i> 
              </span>
          </div>
          <select :disabled="loading !== 'neutral'" class="form-control" id="role" v-model="role" :class="{'is-invalid' : roleErrors.length > 0, 'is-inv' : roleErrors.length > 0}"  @change="disabling(role, roleErrors )">
            <option value="" disabled selected>Select Role</option>
            <option value="customer" selected>Customer</option>
            <option value="guest">Guest Customer</option>
          </select>
      </div>
      <ul v-if="roleErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="roleError in roleErrors" :key="roleError" class="form-error"> {{ roleError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="gender">Gender</label>
      <div class="input-group">
          <ul class="list-unstyled list-inline" id="gender">
            <li class="d-inline-block mr-3">
              <label class="control control-radio outlined radio-primary">Male
                <input type="radio" name="gender" value="male" v-model="gender" checked="checked">
                <div class="control-indicator"></div>
              </label>
            </li>
            <li class="d-inline-block mr-3">
              <label class="control control-radio outlined radio-primary">Female
                <input type="radio" name="gender" value="female" v-model="gender">
                <div class="control-indicator"></div>
              </label>
            </li>
            <li class="d-inline-block mr-3">
              <label class="control control-radio outlined radio-primary">Other
                <input type="radio" name="gender" value="other" v-model="gender">
                <div class="control-indicator"></div>
              </label>
            </li>
          </ul>
      </div>
      <label class="text-dark font-weight-medium" for="address">Address</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-map-marker-multiple"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="address" type="text" name="address" :class="{'is-invalid' : addressErrors.length > 0, 'is-inv' : addressErrors.length > 0, 'form-control':true}" placeholder="2, Akoigba street, Ebute meta " aria-label="address" v-model="address" @input="disabling(address, addressErrors )">
      </div>
      <ul v-if="emailErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="addressError in addressErrors" :key="addressError" class="form-error"> {{ addressError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="state">State</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-source-commit-start"></i> 
              </span>
          </div>
          <select :disabled="loading !== 'neutral'" class="form-control" id="state" v-model="state"  :class="{'is-invalid' : stateErrors.length > 0, 'is-inv' : stateErrors.length > 0}"  @change="disabling(state, stateErrors )">
            <option disabled value="">Select state</option>
            <option value="Abia">Abia</option>
            <option value="Adamawa">Adamawa</option>
            <option value="Akwa Ibom">Akwa Ibom </option>
            <option value="Anambra">Anambra</option>
            <option value="Bauchi">Bauchi</option>
            <option value="Bayelsa">Bayelsa</option>
            <option value="Benue">Benue</option>
            <option value="Borno">Borno</option>
            <option value="Cross River">Cross River</option>
            <option value="Delta">Delta</option>
            <option value="Ebonyi">Ebonyi</option>
            <option value="Edo">Edo</option>
            <option value="Ekiti">Ekiti</option>
            <option value="Enugu">Enugu</option>
            <option value="Gombe">Gombe</option>
            <option value="Imo">Imo</option>
            <option value="Jigawa">Jigawa</option>
            <option value="Kaduna">Kaduna</option>
            <option value="Kano">Kano</option>
            <option value="Katsina">Katsina</option>
            <option value="Kebbi">Kebbi</option>
            <option value="Kogi">Kogi</option>
            <option value="Kwara">Kwara</option>
            <option value="Lagos">Lagos</option>
            <option value="Nasarawa">Nasarawa</option>
            <option value="Niger">Niger</option>
            <option value="">Ogun</option>
            <option value="Ogun">Ondo</option>
            <option value="Osun">Osun</option>
            <option value="Oyo">Oyo</option>
            <option value="Plateau">Plateau</option>
            <option value="Rivers">Rivers</option>
            <option value="Sokoto">Sokoto</option>
            <option value="Taraba">Taraba</option>
            <option value="Yobe">Yobe</option>
            <option value="Zamfara">Zamfara</option>
          </select>
      </div>
      <ul v-if="stateErrors.length > 0" class="mb-3 form-error-list"  >
        <li v-for="stateError in stateErrors" :key="stateError" class="form-error"> {{ stateError }}</li>
      </ul>

      <label class="text-dark font-weight-medium" for="dob">Date of Birth</label>
      <div class="input-group">
          <div class="input-group-prepend">
              <span class="input-group-text">
                  <i class="mdi mdi-calendar"></i> 
              </span>
          </div>
          <input :disabled="loading !== 'neutral'" id="dob" type="date" name="dob" :max="new Date().toISOString().slice(0, 10)" aria-label="dob" v-model="dob" class="form-control">
      </div>

      <button v-if="loading === 'neutral'" type="submit" class="  btn btn-primary mb-4" :disabled="disable"> Update</button>
      <button v-else-if="loading === 'loading'" disabled class="buttonload btn btn-primary">Loading.. <i class=" ml-2 fa fa-circle-o-notch fa-spin fa-1x"></i></button>
      <button v-else-if="loading === 'loaded'" disabled class="buttonload btn btn-primary">Done <i class=" ml-2 fa fa-check fa-1x"></i></button>
    </form> 
    Dob:{{ dob }}
    state: {{ state }}
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
      buyer: {},
      first_name:'',
      middle_name:'',
      last_name:'',
      email: '',
      phone_number: '',
      role: '',
      gender: 'male',
      address: '',
      state: '',
      dob: '',
      firstnameErrors: [],
      lastnameError: '',
      emailErrors: [],
      phoneNumberErrors: [],
      roleErrors: [],
      addressErrors: [],
      stateErrors: [],
      disable: false,
      button_clicked: false,
      loading: 'neutral',
      successful: false,
      failed: false,
      imageUrl: '',
      profile_picture: null
    }
  },
  mounted() {
    this.loadBuyer();
  },
  methods: {
    loadBuyer() {
      axios.get('/buyers/'+this.id+'?edit=true')
      .then(res => {
        this.buyer = res.data.buyer;
        this.first_name = this.buyer.first_name
        this.middle_name = this.buyer.middle_name
        this.last_name = this.buyer.last_name
        this.email = this.buyer.email
        this.phone_number = this.buyer.phone_number
        this.role = this.buyer.role
        this.gender = this.buyer.gender
        this.address = this.buyer.address
        this.state = this.buyer.state
        this.dob = this.buyer.dob
      })
    },
    handleSubmit() {
      this.firstnameErrors= [];
      this.lastnameError = '';
      this.emailErrors= [];
      this.phoneNumberErrors = [];
      this.roleErrors = [];
      this.addressErrors = [];
      this.stateErrors = [];
      this.checkErrors();
      this.button_clicked = true;
      this.loading = 'neutral';
      this.successful= false;
      this.failed= false;

      var data = {};
      if(this.button_clicked && this.firstnameErrors.length < 1 && this.emailErrors.length < 1  && this.roleErrors.length < 1 && this.phoneNumberErrors.length < 1 && this.lastnameError.length < 1 && this.addressErrors.length < 1 && this.stateErrors.length < 1) {
        

        var url = '';
        url = `/buyers/${this.buyer.id}/edit`
        
        this.loading = 'loading';
        
        const config = {
          headers: {
          'content-type': 'multipart/form-data',
          // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          }
        }
          // form data
        let formData = new FormData();
        if(this.profile_picture){
          formData.append('profile_picture', this.profile_picture);
        }
        formData.append('first_name', this.first_name);
        this.middle_name !== null ? formData.append('middle_name', this.middle_name) : '';
        formData.append('last_name', this.last_name);
        formData.append('email', this.email);
        formData.append('phone_number', this.phone_number);
        formData.append('role', this.role);
        formData.append('gender', this.gender);
        formData.append('address', this.address);
        formData.append('state', this.state);
        formData.append('dob', this.dob);
        formData.append('type', 'save');
        // send upload request
        axios.post(url, formData, config)
        .then(response => {
          console.log(response.status)
          if(response.status === 200) {
            this.loading = 'loaded';
            setTimeout(() => this.successful= true, 500);
            setTimeout(() => window.location.replace("/buyers"), 2000);
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
    onImagePicked (event) {
      const files = event.target.files
      let filename = files[0].name
      const fileReader = new FileReader()
      fileReader.onload = e => {
        this.imageUrl = e.target.result;
      console.log(e.target);
      };
      fileReader.readAsDataURL(files[0])
      this.profile_picture = files[0]
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
          } else if(field === this.phone_number) {
            this.phoneNumberErrors= [];
          } else if(field === this.role) {
            this.roleErrors= [];
          } else if(field === this.address) {
            this.addressErrors= [];
          } else if(field === this.state) {
            this.stateErrors= [];
          }

          if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1 && this.phoneNumberErrors.length < 1 && this.roleErrors.length < 1 && this.addressErrors.length < 1 && this.stateErrors.length < 1) {
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
        if(this.firstnameErrors.length < 1 && this.emailErrors.length < 1 && this.lastnameError.length < 1 && this.phoneNumberErrors.length < 1 && this.roleErrors.length < 1 && this.addressErrors.length < 1 && this.stateErrors.length < 1) {
            this.disable = false;
        }
      }
      
    },
    validEmail: function (email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    },
    validPhoneNumber: function (phone_number) {
      var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
      return re.test(phone_number);
    },
    checkErrors() {
        // check first name error
      if(this.first_name.length < 1) {
        if(this.firstnameErrors.length > 0){
           this.firstnameErrors[this.firstnameErrors.length - 1] = 'First Name is required';
        } else {
          this.firstnameErrors.push('First Name is required ');
        }
        
      } else{
        this.firstnameErrors = [];
      }

      // check last name error
      this.lastnameError = this.last_name.length > 0 ? '' : 'Last Name is required';

      // check email error
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

      // Check phone number error
      if(this.phone_number.length < 1) {
        if(this.phoneNumberErrors.length > 0){
           this.phoneNumberErrors[this.phoneNumberErrors.length - 1] = 'Phone number is required';
        } else {
          this.phoneNumberErrors.push('Phone number is required ');
        }
      }else if (!this.validPhoneNumber(this.phone_number)) {
        if(this.phoneNumberErrors.length > 0){
          this.phoneNumberErrors[this.phoneNumberErrors.length - 1] = 'Invalid Phone number.';
        } else {
          this.phoneNumberErrors.push('Invalid Phone number.');
        }
      } else{
        this.phoneNumberErrors = [];
      }
      
      // Check role error
      if(this.role.length < 1) {
        if(this.roleErrors.length > 0){
           this.roleErrors[this.roleErrors.length - 1] = 'Role is required';
        } else {
          this.roleErrors.push('Role is required ');
        }
      } else{
        this.roleErrors = [];
      }
      
      // Check address error
      if(this.address.length < 1) {
        if(this.addressErrors.length > 0){
           this.addressErrors[this.addressErrors.length - 1] = 'Address is required';
        } else {
          this.addressErrors.push('Address is required ');
        }
      } else{
        this.addressErrors = [];
      }
      
      // Check state error
      if(this.state.length < 1) {
        if(this.stateErrors.length > 0){
           this.stateErrors[this.stateErrors.length - 1] = 'State is required';
        } else {
          this.stateErrors.push('State is required ');
        }
      } else{
        this.stateErrors = [];
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


.channel-avatar {
  position: relative;
  width: 100px;
  height: 100px;
  cursor: pointer;
  /* border: 1px solid rgba(0, 0, 0, 0.125); */
}

.image {
  display: block;
  width: 100%;
  height: 100%;
}

.channel-avatar-overlay {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100%;
  width: 100%;
  opacity: 0;
  transition: .3s ease;
  background-color: rgba(0, 0, 0, 0.4);
}

.channel-avatar:hover .channel-avatar-overlay {
  opacity: 1;
}

.icon {
  color: white;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}

.mdi-camera:hover {
  color: #eee;
} 

.mdi-camera:before {
    font-size: xx-large;
}
</style>


