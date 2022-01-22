<template>
  <div class="btn-group mb-1">
    <button type="button" class="btn btn-outline-secondary py-0" >{{onPageDirection && onPageDirection !== '-' ? onPageDirection : 'State' }}</button>
    <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a @click="filteringBy('state','-')" :class="{active: onPageDirection === '-'}"    class="dropdown-item" href="#">All</a>
      <a @click="filteringBy('state','Abuja')" :class="{active: onPageDirection === 'Abuja'}"   class="dropdown-item" href="#">FCT Abuja</a>
      <a @click="filteringBy('state','Abia')" :class="{active: onPageDirection === 'Abia'}"   class="dropdown-item" href="#">Abia</a>
      <a @click="filteringBy('state','Adamawa')" :class="{active: onPageDirection === 'Adamawa'}"   class="dropdown-item" href="#">Adamawa</a>
      <a @click="filteringBy('state','Akwa Ibom')" :class="{active: onPageDirection === 'Akwa Ibom'}"   class="dropdown-item" href="#">Akwa Ibom </a>
      <a @click="filteringBy('state','Anambra')" :class="{active: onPageDirection === 'Anambra'}"   class="dropdown-item" href="#">Anambra</a>
      <a @click="filteringBy('state','Bauchi')" :class="{active: onPageDirection === 'Bauchi'}"   class="dropdown-item" href="#">Bauchi</a>
      <a @click="filteringBy('state','Bayelsa')" :class="{active: onPageDirection === 'Bayelsa'}"   class="dropdown-item" href="#">Bayelsa</a>
      <a @click="filteringBy('state','Benue')" :class="{active: onPageDirection === 'Benue'}"   class="dropdown-item" href="#">Benue</a>
      <a @click="filteringBy('state','Borno')" :class="{active: onPageDirection === 'Borno'}"   class="dropdown-item" href="#">Borno</a>
      <a @click="filteringBy('state','Cross River')" :class="{active: onPageDirection === 'Cross River'}"   class="dropdown-item" href="#">Cross River</a>
      <a @click="filteringBy('state','Delta')" :class="{active: onPageDirection === 'Delta'}"   class="dropdown-item" href="#">Delta</a>
      <a @click="filteringBy('state','Ebonyi')" :class="{active: onPageDirection === 'Ebonyi'}"   class="dropdown-item" href="#">Ebonyi</a>
      <a @click="filteringBy('state','Edo')" :class="{active: onPageDirection === 'Edo'}"   class="dropdown-item" href="#">Edo</a>
      <a @click="filteringBy('state','Ekiti')" :class="{active: onPageDirection === 'Ekiti'}"   class="dropdown-item" href="#">Ekiti</a>
      <a @click="filteringBy('state','Enugu')" :class="{active: onPageDirection === 'Enugu'}"   class="dropdown-item" href="#">Enugu</a>
      <a @click="filteringBy('state','Gombe')" :class="{active: onPageDirection === 'Gombe'}"   class="dropdown-item" href="#">Gombe</a>
      <a @click="filteringBy('state','Imo')" :class="{active: onPageDirection === 'Imo'}"   class="dropdown-item" href="#">Imo</a>
      <a @click="filteringBy('state','Jigawa')" :class="{active: onPageDirection === 'Jigawa'}"   class="dropdown-item" href="#">Jigawa</a>
      <a @click="filteringBy('state','Kaduna')" :class="{active: onPageDirection === 'Kaduna'}"   class="dropdown-item" href="#">Kaduna</a>
      <a @click="filteringBy('state','Kano')" :class="{active: onPageDirection === 'Kano'}"   class="dropdown-item" href="#">Kano</a>
      <a @click="filteringBy('state','Katsina')" :class="{active: onPageDirection === 'Katsina'}"   class="dropdown-item" href="#">Katsina</a>
      <a @click="filteringBy('state','Kebbi')" :class="{active: onPageDirection === 'Kebbi'}"   class="dropdown-item" href="#">Kebbi</a>
      <a @click="filteringBy('state','Kogi')" :class="{active: onPageDirection === 'Kogi'}"   class="dropdown-item" href="#">Kogi</a>
      <a @click="filteringBy('state','Kwara')" :class="{active: onPageDirection === 'Kwara'}"   class="dropdown-item" href="#">Kwara</a>
      <a @click="filteringBy('state','Lagos')" :class="{active: onPageDirection === 'Lagos'}"   class="dropdown-item" href="#">Lagos</a>
      <a @click="filteringBy('state','Nasarawa')" :class="{active: onPageDirection === 'Nasarawa'}"   class="dropdown-item" href="#">Nasarawa</a>
      <a @click="filteringBy('state','Niger')" :class="{active: onPageDirection === 'Niger'}"   class="dropdown-item" href="#">Niger</a>
      <a @click="filteringBy('state','Ogun')" :class="{active: onPageDirection === 'Ogun'}"   class="dropdown-item" href="#">Ogun</a>
      <a @click="filteringBy('state','Ondo')" :class="{active: onPageDirection === 'Ondo'}"   class="dropdown-item" href="#">Ondo</a>
      <a @click="filteringBy('state','Oyo')" :class="{active: onPageDirection === 'Oyo'}"   class="dropdown-item" href="#">Oyo</a>
      <a @click="filteringBy('state','Plateau')" :class="{active: onPageDirection === 'Plateau'}"   class="dropdown-item" href="#">Plateau</a>
      <a @click="filteringBy('state','Rivers')" :class="{active: onPageDirection === 'Rivers'}"   class="dropdown-item" href="#">Rivers</a>
      <a @click="filteringBy('state','Sokoto')" :class="{active: onPageDirection === 'Sokoto'}"   class="dropdown-item" href="#">Sokoto</a>
      <a @click="filteringBy('state','Taraba')" :class="{active: onPageDirection === 'Taraba'}"   class="dropdown-item" href="#">Taraba</a>
      <a @click="filteringBy('state','Yobe')" :class="{active: onPageDirection === 'Yobe'}"   class="dropdown-item" href="#">Yobe</a>
      <a @click="filteringBy('state','Zamfara')" :class="{active: onPageDirection === 'Zamfara'}"   class="dropdown-item" href="#">Zamfara</a>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      onPageDirection: null,
    }
  },
  methods: {
    filteringBy: function(name, direction) {
      this.onPageDirection = direction
      this.$emit('stateFilterEmitter', [name, direction])
    }
  }
}
</script>

<style scoped>
  .active {
    color:white !important;
  }
  .btn-outline-secondary {
  padding-top: 3px;
  padding-bottom: 3px;
}


</style>