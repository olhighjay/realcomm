<template>
  <div class="copyright bg-white">
    <p>
      &copy; <span id="copy-year">{{ year }}</span> Copyright. Developed by
      <a
        class="text-primary"
        href="http://www.dignitio.com/"
        target="_blank"
        >Dignitio</a
      >.
    </p>
  </div> 
</template>

<script>

export default {
  data: function() {
    return {
      year: ''
    }
  },
  mounted() {
     this.footerYear();
   },
  methods: {
    footerYear() {
      this.year = (new Date()).getFullYear()
    }
  }
}
</script>
